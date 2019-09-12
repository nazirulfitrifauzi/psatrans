<?php

namespace App\Http\Controllers;

use App\Parameter;
use App\User;
use App\Task;
use App\Call;
use App\Log;
use Illuminate\Http\Request;

class parameterController extends Controller
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
        $parameter    = Parameter::first();
        $checkAdmin   = auth()->user()->role;
        $checkActive  = User::where('active','=','0')->get();
        $activeCount  = $checkActive->count();
        $task = Task::where('status','!=','X')->take(5)->get();
        $call = Call::where('status','!=','X')->take(5)->get();
        $countpriority = Task::where('status','I')->where('priority','4')->count();
        $priority = Task::where('status','I')->where('priority','4')->get();

        return view('pages.maintenance.parameter.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','parameter','call'));
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
        'value' => 'required|max:255'
        ]);

      $title      = 'gst_percent';
      $changed_on = now();
      $changed_by = auth()->user()->username;
      $request->request->add([
        'title'       => $title,
        'changed_on'  => $changed_on,
        'changed_by'  => $changed_by
      ]);

      $data = request([
        'value'
      ]);

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' update SST value to '.$request->get('value').'%.'
      ]);
      $log->save();

      Parameter::whereId($id)->update($data);

      return back()->with('success', 'Parameter Setup is successfully updated');
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
