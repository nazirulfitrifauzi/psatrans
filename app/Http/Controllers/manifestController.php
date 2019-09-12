<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Task;
use App\Call;
use App\Company;
use App\Destination;
use App\Consignment;
use Carbon\Carbon;
use DB;
use PDF;

class manifestController extends Controller
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
      $driver = User::where('position','DRIVER')->get();

      return view('pages.billing.manifest.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','driver','call'));
    }

    public function manifestSearch(Request $request)
    {
      $cn_date_time = Carbon::createFromFormat('d/m/Y', $request->cn_datetime)->format('Y-m-d');
      $destination_code = $request->destination_code;
      $city = $request->city;
      $driver_name = $request->driver_name;
      $company = Company::first();
      $destination_name = Destination::where('destination_code',$destination_code)->first();

      if(!$destination_code)
      {
        $destination = '';
      }
      else
      {
        $destination = 'and consignment.destination_code = "'.$destination_code.'"';
      }

      if(!$city)
      {
        $city1 = '';
        $city2 = '';
      }
      else
      {
        $city1 = 'inner join shipping on shipping.shipper_code = consignment.shipper_code';
        $city2 = 'and shipping.city like "%'.$city.'%"';
      }

      if(!$driver_name)
      {
        $driver = '';
      }
      else
      {
        $driver = 'and consignment.driver_name = "'.$driver_name.'"';
      }

      $consignment=DB::select('select * from consignment '.$city1.' where invoice_no = "" and cn_datetime like "%'.$cn_date_time.'%" '.$destination.' '.$city2.' '.$driver.'');

      view()->share([
        'consignment' => $consignment,
        'company' => $company
      ]);

      $date = now();
      $pdf_name = 'Manifest_' . $date->format('d-m-Y') .'.pdf';

      $data = [
        'title' => $pdf_name,
        'destination_name' => $destination_name
      ];
      $pdf = PDF::loadView('pages.billing.manifest.pdf.manifest', $data);
      return $pdf->stream();
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
