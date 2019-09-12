<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\User;
use App\Task;
use App\Call;
use App\Shipping;
use App\Company;
use App\Parameter;
use App\Invoice;
use App\Consignment;
use PDF;
use Storage;
use Response;
use DB;
use Carbon\Carbon;

class invoiceController extends Controller
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

      return view('pages.billing.invoice.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    public function download(Request $request)
    {
        //get request
        $shipper_code = $request->get('shipper_code');
        $date_from = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $date_to = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');

        //get data based on request
        $subtotal = 0;
        $gst = 0;
        $total = 0;

        $company_data = Company::first();
        $shipper_data = Shipping::where('shipper_code',$shipper_code)->first();
        $parameter_data = Parameter::first();
        $invoice_no = Invoice::orderBy('invoice_no','desc')->limit(1)->first();
        $shipper = Shipping::where('shipper_code',$shipper_code)->first();
        $company = Company::first();
        $invoice_data = DB::select('select * FROM consignment where invoice_no="" and shipper_code = :shipper_code and date(cn_datetime) BETWEEN :date_from and :date_to order by cn_datetime asc', ['shipper_code' => $shipper_code, 'date_from' => $date_from, 'date_to' => $date_to]);

        if(count($invoice_data) == 0)
        {
          return back()->with('error', 'Invoice for all Consignment on selected date is already created.');
        }
        else
        {
          $new_invoice_no = sprintf('%09d', $invoice_no->invoice_no + 1);
          //$new_invoice_no = '';

          /*foreach($invoice_data as $row){
              Consignment::whereId($row->id)->update(['invoice_no' => $new_invoice_no]);

              $subtotal += $row->sub_amount;
              $gst += $row->gst_amount;
              $total += $row->total_amount;
          }*/

          foreach($invoice_data as $row){
              Consignment::whereId($row->id)->update(['invoice_no' => $new_invoice_no]);

              $subtotal += ($row->sub_amount*$row->quantity);
              $gst += $row->gst_amount;
          }

          $total = $subtotal+$gst;

          //convert all data into an array
          $content = array(
              'shipper_data'   => $shipper_data,
              'invoice_data'   => $invoice_data,
              'company_data'   => $company_data,
              'parameter_data' => $parameter_data,
              'invoice_no'     => $invoice_no,
          );

          //create pdf and store to public folder
          view()->share([
            'content' => $content
          ]);

          $date = now();
          $pdf_name = $date->format('d-m-Y') . '_' . $request->shipper_code .'.pdf';

          $data = [
            'title'    => $pdf_name,
            'subtotal' => $subtotal,
            'gst'      => $gst,
            'total'    => $total
          ];
          $pdf = PDF::loadView('pages.billing.invoice.pdf.invoice', $data);
          $file = $pdf->output();
          Storage::put('public/invoice/'.$pdf_name,$file);


          //insert generated invoice no into invoice table
          $invoice = new Invoice([
            'invoice_no'         =>  $new_invoice_no,
            'invoice_date'       =>  now(),
            'shipper_code'       =>  $shipper_code,
            'shipper_name'       =>  $shipper_data->shipper_name,
            'inv_sub_amount'     =>  $subtotal,
            'inv_gst_amount'     =>  $gst,
            'inv_total_amount'   =>  $total,
            'pdf_name'           =>  $pdf_name
          ]);

          $shipper_acc = Account::where('shipper_code',$shipper_code)
                                  ->orderBy('update_time','desc')
                                  ->first();

          $account = new Account([
            'shipper_code'  => $shipper_code,
            'shipper_name'  => $shipper_data->shipper_name,
            'details'       => 'Invoice created',
            'amount'        => $total,
            'acc_bal'       => ($shipper_acc->acc_bal - $total),
            'update_time'   => now()
          ]);

          $account->save();
          $invoice->save();

          return $pdf->stream();
        }
    }

    public function reprint()
    {
      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      return view('pages.billing.invoice.reprint')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    public function redownload(Request $request)
    {
      $invoice_no = $request->get('invoice_no');
      $invoice = Invoice::where('invoice_no',$invoice_no)->first();

      if($invoice === null)
      {
        return back()->with('error','Invoice No not exist.');
      }
      else
      {
        $download_path = ( storage_path() . '/app/public/invoice/' . $invoice->pdf_name );

        return response()->file(
          $download_path
        );
      }
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
