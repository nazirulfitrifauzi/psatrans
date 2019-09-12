<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Log;
use App\Shipping;
use App\Destination;
use App\Charges;
use App\Consignment;
use App\Call;
use App\Task;
use App\Tracking;
use App\OutForDelivery;
use Carbon\Carbon;

class AjaxdataController extends Controller
{

    //Dashboard
    public function getdashboard1()
    {
     $consignmentHQ = Consignment::where('region','HQ')
                                    ->where('status','created')
                                    ->orderBy('cn_datetime','desc')
                                    ->take(5)
                                    ->get();
     return Datatables::of($consignmentHQ)
                        ->editColumn('cn_datetime', function ($consignmentHQ) {
                                      return date('d M Y', strtotime($consignmentHQ->cn_datetime) );
                                    })
                        ->addColumn('cn_time', function ($consignmentHQ) {
                                      return date('g:ia', strtotime($consignmentHQ->cn_datetime) );
                                    })
                        ->make(true);
    }

    public function getdashboard2()
    {
     $consignmentHQ = Consignment::where('region','SOUTH')
                                    ->where('status','assign to south')
                                    ->orderBy('cn_datetime','desc')
                                    ->take(5)
                                    ->get();
     return Datatables::of($consignmentHQ)
                        ->editColumn('cn_datetime', function ($consignmentHQ) {
                                      return date('d M Y', strtotime($consignmentHQ->cn_datetime) );
                                    })
                        ->addColumn('cn_time', function ($consignmentHQ) {
                                      return date('g:ia', strtotime($consignmentHQ->cn_datetime) );
                                    })
                        ->make(true);
    }

    public function getdashboard3()
    {
     $consignmentHQ = Consignment::where('region','NORTH')
                                    ->where('status','assign to north')
                                    ->orderBy('cn_datetime','desc')
                                    ->take(5)
                                    ->get();
     return Datatables::of($consignmentHQ)
                        ->editColumn('cn_datetime', function ($consignmentHQ) {
                                      return date('d M Y', strtotime($consignmentHQ->cn_datetime) );
                                    })
                        ->addColumn('cn_time', function ($consignmentHQ) {
                                      return date('g:ia', strtotime($consignmentHQ->cn_datetime) );
                                    })
                        ->make(true);
    }

    public function getdashboard4()
    {
      $ofd = OutForDelivery::orderBy('datetime','desc')->take(10)->get();

      return DataTables::of($ofd)
                        ->editColumn('datetime', function ($ofd) {
                                      return date('d M Y', strtotime($ofd->datetime) );
                                    })
                        ->make(true);
    }

    // Report
    public function getdatareport(Request $request)
    {
      $start_date = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
      $end_date = Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

      if(!$request->shipper_code)
      {
        $shipper = '';
      }
      else
      {
        $shipper = 'and shipper_code = "'.$request->shipper_code.'"';
      }

      if(!$request->invoice_no)
      {
        $invoice = '';
      }
      else
      {
        $invoice = 'and invoice_no = "'.$request->invoice_no.'"';
      }

      $report = DB::select('select * FROM invoice where date(invoice_date) BETWEEN "'.$start_date.'" and "'.$end_date.'" '.$shipper.' '.$invoice.' order by invoice_date desc');

      return Datatables::of($report)->make(true);

    }

    public function getdatareport_unpaid(Request $request)
    {
      $start_date = Carbon::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
      $end_date = Carbon::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

      if(!$request->shipper_code)
      {
        $shipper = '';
      }
      else
      {
        $shipper = 'and shipper_code = "'.$request->shipper_code.'"';
      }

      if(!$request->invoice_no)
      {
        $invoice = '';
      }
      else
      {
        $invoice = 'and invoice_no = "'.$request->invoice_no.'"';
      }

      $report2 = DB::select('select * FROM invoice where date(invoice_date) BETWEEN "'.$start_date.'" and "'.$end_date.'" '.$shipper.' '.$invoice.' and status = "pending" order by invoice_date desc');

      return Datatables::of($report2)->make(true);

    }

    //Call Log
    public function getdatacall()
    {
     $call = Call::where('status','!=','X');
     return Datatables::of($call)
                         ->editColumn('datetime', function ($call) {
                             return $call->datetime->format('d/m/Y, h:i a');
                         })
                         ->make(true);
    }

    //Task List
    public function getdatatask()
    {
     $task = Task::where('status','!=','X')->orderBy('id');
     return Datatables::of($task)
                        ->editColumn('deadline', function ($task) {
                            return $task->deadline->format('d/m/Y, h:i a');
                        })
                        ->make(true);
    }

    //User
    public function getdatauser()
    {
     $user = User::all();
     return Datatables::of($user)
                        ->editColumn('position', function ($user) {
                          return ucfirst($user->position);
                        })
                        ->editColumn('role', function ($user) {
                          return ucfirst($user->role);
                        })
                        ->editColumn('firstname', function ($user) {
                          return ucfirst($user->firstname);
                        })
                        ->editColumn('lastname', function ($user) {
                          return ucfirst($user->lastname);
                        })
                        ->make(true);
    }

    //Shipping
    public function getdatashipping()
    {
     $shipping = Shipping::where('deleted_by','=','')->get();
     return Datatables::of($shipping)->make(true);
    }

    //Destination
    public function getdatadestination()
    {
     $destination = Destination::where('deleted_by','=','')->get();
     return Datatables::of($destination)->make(true);
    }

    //chargesDestination
    public function getchargesdestination(Request $request)
    {
      if (!$request->shipper_code) {
        $html = '<option value="">Please Select</option>';
      } else {
        //destination name
        $shipper = '';
        $shipper_name = Shipping::where('shipper_code',$request->shipper_code)
                                          ->value('shipper_name');
        $shipper .= '<input id="shipper_name" type="text" class="form-control @error("shipper_name") is-invalid @enderror" value="'.$shipper_name.'" name="shipper_name">';
        $shipper = $shipper_name;


        $html = '';
        $destination_code=DB::select('select distinct(destination_code) as destination from charges where shipper_code = :id and (carton_rate != "0.00" or m3_rate != "0.00" or p_rate != "0.00" or s_rate != "0.00" or m_rate != "0.00" or b_rate != "0.00" or xl_rate != "0.00" or pkt_rate != "0.00") order by destination', ['id' => $request->shipper_code]);

        $html = '<option value="">Please Select</option>';
        foreach ($destination_code as $destination) {
          $html .= '<option value="'.$destination->destination.'">'.$destination->destination.'</option>';
        }
      }

      return response()->json(['html' => $html, 'shipper_name' => $shipper,]);
    }

    //chargesData
    public function getchargesdata(Request $request)
    {
      if (!$request->destination_code) {
        $html = '<input id="destination_name" type="text" class="form-control @error("destination_name") is-invalid @enderror" value="" name="destination_name">';
      } else {
        //destination name
        $html = '';
        $destination_name = Destination::where('destination_code',$request->destination_code)
                                          ->value('destination_name');
        $html .= '<input id="destination_name" type="text" class="form-control @error("destination_name") is-invalid @enderror" value="'.$destination_name.'" name="destination_name">';
        $html = $destination_name;

        //p_rate
        $prate = '';
        $p_rate = Charges::where('destination_code',$request->destination_code)
                            ->where('shipper_code',$request->shipper_code)
                            ->value('p_rate');

          $prate .= '<input id="p_rate" type="text" class="form-control @error("p_rate") is-invalid @enderror" value="'.$p_rate.'" name="p_rate">';
          $prate = $p_rate;

        //s_rate
        $srate = '';
        $s_rate = Charges::where('destination_code',$request->destination_code)
                            ->where('shipper_code',$request->shipper_code)
                            ->value('s_rate');

          $srate .= '<input id="s_rate" type="text" class="form-control @error("s_rate") is-invalid @enderror" value="'.$s_rate.'" name="s_rate">';
          $srate = $s_rate;

        //m_rate
        $mrate = '';
        $m_rate = Charges::where('destination_code',$request->destination_code)
                            ->where('shipper_code',$request->shipper_code)
                            ->value('m_rate');

          $mrate .= '<input id="m_rate" type="text" class="form-control @error("m_rate") is-invalid @enderror" value="'.$m_rate.'" name="m_rate">';
          $mrate = $m_rate;

        //b_rate
        $brate = '';
        $b_rate = Charges::where('destination_code',$request->destination_code)
                            ->where('shipper_code',$request->shipper_code)
                            ->value('b_rate');

          $brate .= '<input id="b_rate" type="text" class="form-control @error("b_rate") is-invalid @enderror" value="'.$b_rate.'" name="b_rate">';
          $brate = $b_rate;

        //xl_rate
        $xlrate = '';
        $xl_rate = Charges::where('destination_code',$request->destination_code)
                            ->where('shipper_code',$request->shipper_code)
                            ->value('xl_rate');

          $xlrate .= '<input id="xl_rate" type="text" class="form-control @error("xl_rate") is-invalid @enderror" value="'.$xl_rate.'" name="xl_rate">';
          $xlrate = $xl_rate;

        //pkt_rate
        $pktrate = '';
        $pkt_rate = Charges::where('destination_code',$request->destination_code)
                            ->where('shipper_code',$request->shipper_code)
                            ->value('pkt_rate');

          $pktrate .= '<input id="pkt_rate" type="text" class="form-control @error("pkt_rate") is-invalid @enderror" value="'.$pkt_rate.'" name="pkt_rate">';
          $pktrate = $pkt_rate;

        //carton_rate
        $cartonrate = '';
        $carton_rate = Charges::where('destination_code',$request->destination_code)
                            ->where('shipper_code',$request->shipper_code)
                            ->value('carton_rate');

          $cartonrate .= '<input id="carton_rate" type="text" class="form-control @error("carton_rate") is-invalid @enderror" value="'.$carton_rate.'" name="carton_rate">';
          $cartonrate = $carton_rate;

        //m3_rate
        $m3rate = '';
        $m3_rate = Charges::where('destination_code',$request->destination_code)
                            ->where('shipper_code',$request->shipper_code)
                            ->value('m3_rate');

          $m3rate .= '<input id="m3_rate" type="text" class="form-control @error("m3_rate") is-invalid @enderror" value="'.$m3_rate.'" name="m3_rate">';
          $m3rate = $m3_rate;

      }

      return response()->json([
        'html' => $html,
        'prate' => $prate,
        'srate' => $srate,
        'mrate' => $mrate,
        'brate' => $brate,
        'xlrate' => $xlrate,
        'pktrate' => $pktrate,
        'cartonrate' => $cartonrate,
        'm3rate' => $m3rate
      ]);
    }

    //Log
    public function getdatalog()
    {
     $log = Log::orderBy('datetime','desc')->get();
     return Datatables::of($log)
                 ->make(true);
    }
}
