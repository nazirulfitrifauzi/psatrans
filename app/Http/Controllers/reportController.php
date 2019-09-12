<?php

namespace App\Http\Controllers;

use App\Account;
use App\Task;
use App\Call;
use App\User;
use App\Log;
use App\Invoice;
use App\Payment;
use App\Company;
use App\Shipping;
use Auth;
use DB;
use PDF;
use Storage;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;

class reportController extends Controller
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

        return view('pages.report.summary')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    public function statement()
    {
        $checkAdmin   = auth()->user()->role;
        $checkActive  = User::where('active','=','0')->get();
        $activeCount  = $checkActive->count();
        $task = Task::where('status','!=','X')->take(5)->get();
        $call = Call::where('status','!=','X')->take(5)->get();
        $countpriority = Task::where('status','I')->where('priority','4')->count();
        $priority = Task::where('status','I')->where('priority','4')->get();

        return view('pages.report.statement')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
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
      // get request
      $invoice_no = $request->get('invoice_no');
      $shipper_code = $request->get('shipper_code');
      $datetime = Carbon::createFromFormat('m/d/Y h:i A', $request->date)->format('Y-m-d H:i:s');
      $amount = $request->get('amount');
      $method = $request->get('method');
      $reqaccount = $request->get('account');
      $remarks = $request->get('remarks');

      $shipper = Shipping::where('shipper_code',$shipper_code)->first();

      Invoice::where('invoice_no',$invoice_no)->update(['status' => 'Paid']);

      $payment = new Payment([
        'invoice_no'         =>  $invoice_no,
        'shipper_code'       =>  $shipper_code,
        'datetime'           =>  now(),
        'amount'             =>  $amount,
        'method'             =>  $method,
        'account'            =>  $reqaccount,
        'remarks'            =>  $remarks
      ]);

      $shipper_acc = Account::where('shipper_code',$shipper_code)
                              ->orderBy('update_time','desc')
                              ->first();

      $account = new Account([
        'shipper_code'  => $shipper_code,
        'shipper_name'  => $shipper->shipper_name,
        'details'       => 'Payment made',
        'amount'        => $amount,
        'acc_bal'       => ($shipper_acc->acc_bal + $amount),
        'update_time'   => now()
      ]);

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' create payment for Invoice No. ['.$invoice_no.'].'
      ]);
      $log->save();

      $account->save();
      $payment->save();
      return back()->with('success', 'Payment for Invoice No: '.$invoice_no.' successfully recorded.');
    }

    public function statementSearch(Request $request)
    {
        //init
        $invoice_total = 0;
        $payment_total = 0;

        //get request
        $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
        $shipper_code = $request->shipper_code;

        $company = Company::first();
        $shipper = Shipping::where('shipper_code',$shipper_code)->first();

        if(!$shipper)
        {
          return back()->with('error', 'Shipper Account not exist.');
        }

        $account = Account::where('shipper_code',$shipper_code)
                            ->where('update_time','<=',$start_date)
                            ->orderBy('update_time','desc')
                            ->first();

        //dd($account->acc_bal);
        $statement = DB::select('
        select * from
            (
                SELECT invoice_date as date,invoice_no,shipper_code,inv_total_amount as amount,  "invoice" as mode FROM invoice
                UNION
                select datetime as date,invoice_no,shipper_code, amount as amount, "payment" as mode from payment
            ) T
        where date(T.date) between "'.$start_date.'" and "'.$end_date.'"
        and shipper_code="'.$shipper_code.'"
        order by T.date
        ');

        //get invoice n payment
        foreach($statement as $row){
          if($row->mode == 'invoice'){
            $invoice_total += $row->amount;
          }
          elseif($row->mode == 'payment'){
            $payment_total += $row->amount;
          }
        }

        view()->share([
          'company' => $company,
          'account'  => $account,
          'statement' => $statement,
          'shipper' => $shipper
          ]);

        $date = now();
        $pdf_name = 'Statement_' . $shipper_code . '_' . $date->format('d-m-Y') .'.pdf';

        $data = [
          'title' => $pdf_name,
          'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('d M Y'),
          'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('d M Y'),
          'invoice_total' => $invoice_total,
          'payment_total' => $payment_total
        ];
        $pdf = PDF::loadView('pages.report.pdf.statement', $data);
        return $pdf->stream();
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
