<?php

namespace App\Http\Controllers;

use App\Consignment;
use Illuminate\Http\Request;
use App\User;
use App\Destination;
use App\Parameter;
use App\Task;
use App\Call;
use App\Log;
use App\Tracking;
use Carbon\Carbon;

class consignmentController extends Controller
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

      return view('pages.transaction.consignment.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    public function search(Request $request)
    {
      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $data   =   $request->cn_no;

      $count       = Consignment::where('cn_no','=', $data)
                                ->count();

      if($count == 0)
      {
        return redirect('consignment')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'))->with('error', 'Consignment Number not Exist.');
      }
      else
      {
        $search       = Consignment::where('cn_no','=', $data)
                                  ->first();

        $destination_code = $search->destination_code;

        $destination_name = Destination::where('destination_code',$destination_code)
                                        ->value('destination_name');

        $sst  = Parameter::where('title','gst_percent')
                            ->value('value');

        return view('pages.transaction.consignment.search')->with(compact('checkAdmin','activeCount','task','countpriority','priority','search', 'destination_name','sst','call'));
      }

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
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $sst  = Parameter::where('title','gst_percent')
                          ->value('value');

      return view('pages.transaction.consignment.create')->with(compact('checkAdmin','activeCount','task','countpriority','priority','sst','call'));
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
         'cn_no' => ['required', 'string', 'max:50'],
         'shipper_code' => ['required'],
         'receiver_name' => ['required', 'max:50'],
         'destination_code' => ['required'],
       ]);

       $dt = Carbon::now();
       $pod = Carbon::createFromFormat('d/m/Y', $request->pod)->format('Y-m-d');

       $consignment = new Consignment([
         'cn_no'                =>  $request->get('cn_no'),
         'shipper_code'         =>  $request->get('shipper_code'),
         'shipper_name'         =>  $request->get('shipper_name'),
         'receiver_name'        =>  $request->get('receiver_name'),
         'pod'                  =>  $pod,
         'destination_code'     =>  $request->get('destination_code'),
         'cn_datetime'          =>  now(),
         'measure'              =>  $request->get('measure'),
         'weight'               =>  $request->get('weight'),
         'carton_size'          =>  $request->get('carton_size'),
         'carton_rate'          =>  $request->get('carton_rate'),
         'm3_size'              =>  $request->get('m3_size'),
         'm3_rate'              =>  $request->get('m3_rate'),
         'p_size'               =>  $request->get('p_size'),
         'p_rate'               =>  $request->get('p_rate'),
         's_size'               =>  $request->get('s_size'),
         's_rate'               =>  $request->get('s_rate'),
         'm_size'               =>  $request->get('m_size'),
         'm_rate'               =>  $request->get('m_rate'),
         'b_size'               =>  $request->get('b_size'),
         'b_rate'               =>  $request->get('b_rate'),
         'xl_size'              =>  $request->get('xl_size'),
         'xl_rate'              =>  $request->get('xl_rate'),
         'pkt_size'             =>  $request->get('pkt_size'),
         'pkt_rate'             =>  $request->get('pkt_rate'),
         'other_charges'        =>  $request->get('other_charges'),
         'other_amount'         =>  $request->get('other_amount'),
         'sub_amount'           =>  $request->get('sub_amount'),
         'gst_amount'           =>  $request->get('gst_amount'),
         'total_amount'         =>  $request->get('total_amount'),
         'remarks'              =>  $request->get('remarks'),
         'invoice_no'           =>  ''
       ]);

       $cn_no = $request->get('cn_no');

       $checkcnno = Consignment::where('cn_no','=',$cn_no)->exists();

       if($checkcnno == 'true')
       {
         return back()->with('error', 'Consignment No already exist.');
       }
       else
       {
          $tracking = new Tracking([
            'cn_no'     =>  $request->get('cn_no'),
            'status'    => 'RECEIVED',
            'datetime'  => now()
          ]);

          $tracking2 = new Tracking([
            'cn_no'     =>  $request->get('cn_no'),
            'status'    => 'HQ',
            'datetime'  => now()
          ]);

         $consignment->save();
         $tracking->save();
         $tracking2->save();

         $log = new Log([
           'status' => ''.strtoupper(auth()->user()->username).' create new Consignment No. ['.$request->get('cn_no').'].'
         ]);
         $log->save();

         return redirect()->route('consignment.index')->with('success', 'New Consignment added successfully.');
       }

     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function show(Consignment $consignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Consignment $consignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'cn_no' => ['required', 'string', 'max:50'],
        'shipper_code' => ['required'],
        'receiver_name' => ['required', 'max:50'],
        'destination_code' => ['required'],
        ]);

      $changed_on = now();
      $changed_by = auth()->user()->username;
      $request->request->add([
        'changed_on' => $changed_on,
        'changed_by' => $changed_by
      ]);

      $pod = Carbon::createFromFormat('d/m/Y', $request->pod)->format('Y-m-d');

      $data = request([
        'cn_no',
        'shipper_code',
        'shipper_name',
        'receiver_name',
        $pod,
        'destination_code',
        'cn_date',
        'delivery_no',
        'quantity',
        'measure',
        'weight',
        'carton_size',
        'carton_rate',
        'm3_size',
        'm3_rate',
        'p_size',
        'p_rate',
        's_size',
        's_rate',
        'm_size',
        'm_rate',
        'b_size',
        'b_rate',
        'xl_size',
        'xl_rate',
        'pkt_size',
        'pkt_rate',
        'other_charges',
        'other_amount',
        'sub_amount',
        'gst_amount',
        'total_amount',
        'remarks'
      ]);

      Consignment::whereId($id)->update($data);

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' update Consignment No. ['.$request->get('cn_no').'].'
      ]);
      $log->save();

      return redirect('consignment')->with('success', 'Consignment Note is successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Consignment  $consignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $consignment = Consignment::whereId($id)->value('cn_no');

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' delete Consignment No. ['.$consignment.'].'
      ]);
      $log->save();

      Consignment::destroy($id);

      //  Return response
      return response()->json([
          'success' => true,
          'message' => "Consignment Note has been deleted.",
      ]);
    }
}
