<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Call;
use App\Log;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;


class taskController extends Controller
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

      return view('pages.task.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
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
      $checkid = Task::orderBy('id','desc')->value('id');

      $newid = $checkid + 1;

      return view('pages.task.create')->with(compact('checkAdmin','activeCount','task','countpriority','priority','assign','call','newid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'subject' => ['required', 'string', 'max:50'],
        'deadline' => ['required'],
        'priority' => ['required']
      ]);

      $deadline = Carbon::createFromFormat('d/m/Y', $request->deadline)->format('Y-m-d');

      $task = new Task([
        'subject'       =>  $request->get('subject'),
        'description'   =>  $request->get('description'),
        'deadline'      =>  $deadline,
        'remarks'       =>  $request->get('remarks'),
        'assign_to'     =>  $request->get('assign_to'),
        'request_by'    =>  $request->get('request_by'),
        'priority'      =>  $request->get('priority'),
      ]);

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' create task '.$request->get('subject').'.'
      ]);
      $log->save();

      //dump($task);
      $task->save();
      return redirect()->route('task.index')->with('success', 'Task has been successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
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

      $taskdata = Task::whereId($id)->first();

      return view('pages.task.show')->with(compact('checkAdmin','activeCount','taskdata','task','countpriority','priority','assign','call'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      if($request->status != 'X')
      {

        $deadline = Carbon::createFromFormat('d/m/Y', $request->deadline)->format('Y-m-d');

        Task::whereId($id)->update([
          'subject'       =>  $request->get('subject'),
          'description'   =>  $request->get('description'),
          'deadline'      =>  $deadline,
          'remarks'       =>  $request->get('remarks'),
          'assign_to'     =>  $request->get('assign_to'),
          'request_by'    =>  $request->get('request_by'),
          'priority'      =>  $request->get('priority'),
          ]);

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' update task '.$request->get('subject').'.'
        ]);
        $log->save();

        return redirect('task')->with('success', 'Task List is successfully updated.');
      }
      else
      {
        $deadline = Carbon::createFromFormat('d/m/Y', $request->deadline)->format('Y-m-d');

        $delete_on = now();
        $delete_by = auth()->user()->username;
        $request->request->add([
          'delete_on' => $delete_on,
          'delete_by' => $delete_by
        ]);

        $data = request([
          'subject',
          'description',
          $deadline,
          'remarks',
          'assign_to',
          'request_by',
          'priority',
          'status',
          'delete_on',
          'delete_by'
        ]);

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' close task '.$request->get('subject').'.'
        ]);
        $log->save();

        Task::whereId($id)->update($data);
        return redirect('task')->with('success', 'Task List with ID: '.$id.' is closed permenantly.');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
