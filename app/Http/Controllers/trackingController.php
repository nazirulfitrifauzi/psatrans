<?php

namespace App\Http\Controllers;

use App\Task;
use App\Call;
use App\User;
use App\Consignment;
use App\Tracking;
use Auth;
use DB;
use Illuminate\Http\Request;

class trackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Auth::check())
      {
        $checkAdmin   = auth()->user()->role;
        $checkActive  = User::where('active','=','0')->get();
        $activeCount  = $checkActive->count();
        $task = Task::where('status','!=','X')->take(5)->get();
        $call = Call::where('status','!=','X')->take(5)->get();
        $countpriority = Task::where('status','I')->where('priority','4')->count();
        $priority = Task::where('status','I')->where('priority','4')->get();
      }
      else
      {
        //guest
      }

      return view('pages.tracking.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    public function search(Request $request)
    {
        if(Auth::check())
        {
          $checkAdmin   = auth()->user()->role;
          $checkActive  = User::where('active','=','0')->get();
          $activeCount  = $checkActive->count();
          $task = Task::where('status','!=','X')->take(5)->get();
          $call = Call::where('status','!=','X')->take(5)->get();
          $countpriority = Task::where('status','I')->where('priority','4')->count();
          $priority = Task::where('status','I')->where('priority','4')->get();
        }
        else
        {
          //guest
        }

        $cn_no = $request->get('cn_no');
        $tracking = Tracking::where('cn_no',$cn_no)->get();
        $receiver_name = Consignment::where('cn_no',$request->cn_no)->value('receiver_name');
        $region = Consignment::where('cn_no',$request->cn_no)->value('region');

        //$trackArray = $tracking->toArray();
        $status = array();
        foreach ($tracking as $row)
        {
          $status[] = $row->status;
        }

        return view('pages.tracking.search')->with(compact('checkAdmin','activeCount','task','countpriority','priority','tracking','receiver_name','region','cn_no','status','call'));
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
        //
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
