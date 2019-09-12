<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use App\Task;
use App\Call;
use App\Log;
use Illuminate\Http\Request;

class companyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company      = Company::first();
        $checkAdmin   = auth()->user()->role;
        $checkActive  = User::where('active','=','0')->get();
        $activeCount  = $checkActive->count();
        $task = Task::where('status','!=','X')->take(5)->get();
        $call = Call::where('status','!=','X')->take(5)->get();
        $countpriority = Task::where('status','I')->where('priority','4')->count();
        $priority = Task::where('status','I')->where('priority','4')->get();

        return view('pages.maintenance.company.company')->with(compact('checkAdmin','activeCount','company','task','countpriority','priority','call'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'company_name' => 'required|max:255',
        'registration_id' => 'required|max:255',
        'gst_id' => 'required|max:255',
        'address1' => 'required|max:255',
        'city' => 'required|max:255',
        'state' => 'required|max:255',
        'post_code' => 'required|max:255',
        'country' => 'required|max:255',
        'telephone' => 'required|max:255'
        ]);

      $changed_on = now();
      $changed_by = auth()->user()->username;
      $request->request->add([
        'changed_on' => $changed_on,
        'changed_by' => $changed_by
      ]);

      $data = request([
        'company_name',
        'registration_id',
        'gst_id',
        'address1',
        'address2',
        'city',
        'state',
        'post_code',
        'country',
        'telephone',
        'fax',
        'email',
        'remark',
        'changed_on',
        'changed_by'
      ]);

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' update Company details.'
      ]);
      $log->save();

      Company::whereId($id)->update($data);

      return back()->with('success', 'Company details has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
