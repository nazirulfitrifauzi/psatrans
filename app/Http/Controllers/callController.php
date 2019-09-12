<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Call;
use App\CallRemark;
use App\Task;
use App\Log;
use Auth;
use Illuminate\Support\Facades\DB;

class callController extends Controller
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
      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      return view('pages.calllog.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $assign = User::where('position','EXECUTIVE')->get();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();
      $checkid = Call::orderBy('id','desc')->value('id');

      $newid = $checkid + 1;

      return view('pages.calllog.create')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call','newid','assign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $checkid = Call::orderBy('id','desc')->value('id');

      $newid = $checkid + 1;

      $this->validate($request, [
        'contact_name' => ['required', 'string', 'max:50'],
        'subject' => ['required', 'max:200'],
      ]);

      $call = new Call([
        'subject'           =>  $request->get('subject'),
        'description'       =>  $request->get('description'),
        'contact_name'      =>  $request->get('contact_name'),
        'contact_no'        =>  $request->get('contact_no'),
        'assign_to'         =>  $request->get('assign_to'),
        'priority'          =>  $request->get('priority'),
        'status'            =>  'I'
      ]);

      $call->save();

      if(!empty($request->get('remarks')))
      {
        $remark = new CallRemark([
          'call_id'        =>  $newid,
          'user'           =>  auth()->user()->username,
          'remark'         =>  $request->get('remarks'),
          'datetime'       =>  now()
        ]);

        $remark->save();
      }

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' create Call Log with Subject ['.$request->get('subject').'].'
      ]);
      $log->save();

      return redirect()->route('call.index')->with('success', 'Call Log added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $assign = User::where('position','EXECUTIVE')->get();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $calldata = Call::whereId($id)->first();
      $remark = Call::find($id)->remark;

      return view('pages.calllog.show')->with(compact('checkAdmin','activeCount','calldata','task','countpriority','assign','priority','remark','call'));
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

      if($request->status != 'X')
      {
        $data = request([
          'contact_no',
          'contact_name',
          'subject',
          'description',
          'status',
        ]);

        Call::whereId($id)->update($data);

        if(empty($request->get('remarks')))
        {
          $log = new Log([
            'status' => ''.strtoupper(auth()->user()->username).' update Call Log ID ['.$id.'].'
          ]);
          $log->save();

          return redirect('call')->with('success', 'Call Log is successfully updated.');
        }
        else
        {
          $remark = new CallRemark([
            'call_id'        =>  $id,
            'user'           =>  auth()->user()->username,
            'remark'         =>  $request->get('remarks'),
            'datetime'       =>  now()
          ]);

          //dd($remark);
          $remark->save();

          $log = new Log([
            'status' => ''.strtoupper(auth()->user()->username).' add Remarks for Call Log ID ['.$id.'].'
          ]);
          $log->save();

          return back()->with('success', 'Remark is successfully added.');
        }
      }
      else
      {
        $delete_on = now();
        $delete_by = auth()->user()->username;
        $request->request->add([
          'delete_on' => $delete_on,
          'delete_by' => $delete_by
        ]);

        $data = request([
          'contact_no',
          'contact_name',
          'subject',
          'description',
          'status',
          'delete_on',
          'delete_by'
        ]);

        Call::whereId($id)->update($data);

        if(empty($request->get('remarks')))
        {
          $log = new Log([
            'status' => ''.strtoupper(auth()->user()->username).' delete Call Log ID ['.$id.'].'
          ]);
          $log->save();

          return redirect('call')->with('success', 'Call Log with ID: '.$id.' is closed permenantly.');
        }
        else
        {
          $remark = new CallRemark([
            'call_id'        =>  $id,
            'user'           =>  auth()->user()->username,
            'remark'         =>  $request->get('remarks'),
            'datetime'       =>  now()
          ]);

          $remark->save();

          $log = new Log([
            'status' => ''.strtoupper(auth()->user()->username).' delete Call Log ID ['.$id.'].'
          ]);
          $log->save();

          return redirect('call')->with('success', 'Call Log with ID: '.$id.' is closed permenantly.');
        }
      }

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
