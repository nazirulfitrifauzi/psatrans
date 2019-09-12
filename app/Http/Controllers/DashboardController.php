<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use App\Task;
use App\Call;
use App\Log;
use App\Company;
use App\Consignment;
use App\Destination;
use App\OutForDelivery;
use App\Tracking;
use PDF;
use Storage;
use Response;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirect()
    {
        if (Auth::user())
        {
          return redirect('dashboard');
        }
        else
        {
          return view('auth.login');
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $checkAdmin = auth()->user()->role;
        $checkActive  = User::where('active','=','0')->get();
        $activeCount  = $checkActive->count();
        $task = Task::where('status','!=','X')->take(5)->get();
        $call = Call::where('status','!=','X')->take(5)->get();
        $countpriority = Task::where('status','I')->where('priority','4')->count();
        $priority = Task::where('status','I')->where('priority','4')->get();
        $driver = User::where('position','driver')->get();

        $hqlist = Consignment::where('region','HQ')
                               ->where('status','created')
                               ->orderBy('cn_datetime','desc')
                               ->take(5)
                               ->get();

        $tasklist = Task::where('status','!=','X')->take(5)->get();
        $calllist = Call::where('status','!=','X')->take(5)->get();

        return view('pages.dashboard')->with(compact('checkAdmin','activeCount','task','countpriority','priority','hqlist','driver','tasklist','calllist','call'));
    }

    public function consignmentHQ(Request $request,Consignment $consignment)
    {
      $checkAdmin = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $search = $request->input('search');
      $hqlist = Consignment::where('region','HQ')
                            ->where('status','created')
                            ->search($search)
                            ->orderBy('cn_datetime','desc')
                            ->paginate(15);
      $driver = User::where('position','DRIVER')->get();

      return view('pages.dashboardpage.consignmentHQ')->with(compact('checkAdmin','activeCount','task','countpriority','priority','hqlist','driver','search','call'));
    }

    public function consignmentSouth(Request $request)
    {
      $checkAdmin = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $search = $request->input('search');
      $southlist = Consignment::where('region','SOUTH')
                                ->where('status','assign to south')
                                ->search($search)
                                ->orderBy('cn_datetime','desc')
                                ->paginate(15);
      $driver = User::where('position','DRIVER')->get();

      return view('pages.dashboardpage.consignmentSouth')->with(compact('checkAdmin','activeCount','task','countpriority','priority','southlist','driver','search','call'));
    }

    public function consignmentNorth(Request $request)
    {
      $checkAdmin = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $search = $request->input('search');
      $northlist = Consignment::where('region','NORTH')
                                ->where('status','assign to north')
                                ->search($search)
                                ->orderBy('cn_datetime','desc')
                                ->paginate(15);
      $driver = User::where('position','DRIVER')->get();

      return view('pages.dashboardpage.consignmentNorth')->with(compact('checkAdmin','activeCount','task','countpriority','priority','northlist','driver','search','call'));
    }

    public function outForDelivery(Request $request,Consignment $consignment)
    {
      $checkAdmin = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $search = $request->input('search');
      $ofdlist = OutForDelivery::search($search)->orderBy('datetime','desc')->paginate(15);

      return view('pages.dashboardpage.outForDelivery')->with(compact('checkAdmin','activeCount','task','countpriority','priority','ofdlist','search','call'));
    }

    public function updateconsignmentHQ(Request $request, $id)
    {
      $destination_name = Destination::where('destination_code',$request->destination_code)->value('destination_name');
      $destination_name2 = strtoupper($destination_name);

      $south = array('SEREMBAN','NEGERI SEMBILAN','MELAKA','BATU PAHAT','SEGAMAT','TANGKAK','LABIS','KLUANG','PONTIAN','MUAR','KOTA TINGGI','ROMPIN','JOHOR BAHRU');
      $north = array('PERLIS','GURUN','KEDAH','ALOR SETAR','KULIM','BUTTERWORTH','PENANG','SELAMA');

      if(in_array($destination_name2,$south))
      {
        $request->request->add([
          'region' => 'SOUTH',
          'status' => 'assign to south'
        ]);

        $data = request([
          'driver_name',
          'region',
          'status'
        ]);

        $tracking = new Tracking([
          'cn_no'     =>  $request->get('cn_no'),
          'status'    => 'TRANSIT JB',
          'datetime'  => now()
        ]);

        Consignment::whereId($id)->update($data);
        $tracking->save();

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' move Consignment No. ['.$request->cn_no.'] to South.'
        ]);
        $log->save();

        return back()->with('success', 'Consignment Note Number: '.$request->cn_no.' is move to South.');
      }
      else if(in_array($destination_name2,$north))
      {
        $request->request->add([
          'region' => 'NORTH',
          'status' => 'assign to north'
        ]);

        $data = request([
          'driver_name',
          'region',
          'status'
        ]);

        $tracking = new Tracking([
          'cn_no'     =>  $request->get('cn_no'),
          'status'    => 'TRANSIT PENANG',
          'datetime'  => now()
        ]);

        Consignment::whereId($id)->update($data);
        $tracking->save();

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' move Consignment No. ['.$request->cn_no.'] to North.'
        ]);
        $log->save();

        return back()->with('success', 'Consignment Note Number: '.$request->cn_no.' is move to North.');
      }
      else
      {
        if($request->driver_name == '')
        {
            return back()->with('error', 'Driver Name is required for Consignment HQ.');
        }
        else
        {
          $request->request->add([
            'region' => 'HQ',
            'status' => 'out for delivery'
          ]);

          $data = request([
            'driver_name',
            'region',
            'status'
          ]);

          Consignment::whereId($id)->update($data);

          $ofd = new OutForDelivery([
            'cn_no'                =>  $request->get('cn_no'),
            'shipper_code'         =>  $request->get('shipper_code'),
            'destination_code'     =>  $request->get('destination_code'),
            'driver_name'          =>  $request->get('driver_name'),
          ]);

          $tracking = new Tracking([
            'cn_no'     =>  $request->get('cn_no'),
            'status'    => 'ARRANGING',
            'datetime'  => now()
          ]);

          $ofd->save();
          $tracking->save();

          $log = new Log([
            'status' => ''.strtoupper(auth()->user()->username).' move Consignment No. ['.$request->cn_no.'] to Out for Delivery.'
          ]);
          $log->save();

          return back()->with('success', 'Consignment Note Number: '.$request->cn_no.' is move to Out For Delivery.');
        }
      }

    }

    public function updateconsignmentSouth(Request $request, $id)
    {
      if($request->driver_name == '')
      {
          return back()->with('error', 'Driver Name is required to move consignment into Out For Delivery.');
      }
      else
      {
        $request->request->add([
          'status' => 'out for delivery'
        ]);

        $data = request([
          'driver_name',
          'status'
        ]);

        Consignment::whereId($id)->update($data);

        $ofd = new OutForDelivery([
          'cn_no'                =>  $request->get('cn_no'),
          'shipper_code'         =>  $request->get('shipper_code'),
          'destination_code'     =>  $request->get('destination_code'),
          'driver_name'          =>  $request->get('driver_name'),
        ]);

        $tracking = new Tracking([
          'cn_no'     =>  $request->get('cn_no'),
          'status'    => 'ARRANGING',
          'datetime'  => now()
        ]);

        $ofd->save();
        $tracking->save();

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' move Consignment No. ['.$request->cn_no.'] to Out for Delivery.'
        ]);
        $log->save();

        return back()->with('success', 'Consignment Note Number: '.$request->cn_no.' is move to Out For Delivery.');
      }
    }

    public function updateconsignmentNorth(Request $request, $id)
    {
      if($request->driver_name == '')
      {
          return back()->with('error', 'Driver Name is required to move consignment into Out For Delivery.');
      }
      else
      {
        $request->request->add([
          'status' => 'out for delivery'
        ]);

        $data = request([
          'driver_name',
          'status'
        ]);

        Consignment::whereId($id)->update($data);

        $ofd = new OutForDelivery([
          'cn_no'                =>  $request->get('cn_no'),
          'shipper_code'         =>  $request->get('shipper_code'),
          'destination_code'     =>  $request->get('destination_code'),
          'driver_name'          =>  $request->get('driver_name'),
        ]);

        $tracking = new Tracking([
          'cn_no'     =>  $request->get('cn_no'),
          'status'    => 'ARRANGING',
          'datetime'  => now()
        ]);

        $ofd->save();
        $tracking->save();

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' move Consignment No. ['.$request->cn_no.'] to Out for Delivery.'
        ]);
        $log->save();

        return back()->with('success', 'Consignment Note Number: '.$request->cn_no.' is move to Out For Delivery.');
      }
    }

    public function updateOutForDelivery(Request $request, $id)
    {
      //dd($request->all());

      if($request->status != 'Close')
      {
        if($request->status == 'Completed')
        {
          if (!$request->attachment)
          {
            return back()->with('error', 'You need to upload receipt screenshot to Completed this task.');
          }
          else
          {
            $date = now();
            $image = $request->file('attachment');

            $new_name = $request->cn_no . '_'. $date->format('d-m-Y') .'.' . $image->getClientOriginalExtension();
            $image->move(public_path("images"), $new_name);

            $pdf_name = $request->cn_no . '_'. $date->format('d-m-Y') .'.pdf';

            $data = [
              'title' => $pdf_name,
              'content' => 'Delivery Proof for Consignment No. : ' .$request->cn_no,
              'date' => 'Date : ' .$date->format('d-m-Y'),
              'image' => $request->cn_no . '_'. $date->format('d-m-Y').'.' . $image->getClientOriginalExtension()
            ];

            $pdf = PDF::loadView('pages.pdf_convert', $data);
            $file = $pdf->output();
            Storage::put('public/DeliveryProof/'.$pdf_name,$file);

            $image_path = public_path("images").'/'.$request->cn_no . '_'. $date->format('d-m-Y') .'.' . $image->getClientOriginalExtension();
            unlink($image_path);

            $data2 = request([
              'status'
            ]);

            $tracking = new Tracking([
              'cn_no'     =>  $request->get('cn_no'),
              'status'    => 'ATTEMPTING',
              'datetime'  => now()
            ]);

            $tracking2 = new Tracking([
              'cn_no'     =>  $request->get('cn_no'),
              'status'    => 'DELIVERED',
              'datetime'  => now()
            ]);

            Consignment::where('cn_no',$request->cn_no)->update($data2);
            OutForDelivery::whereId($id)->update($data2 + ['attachment' => $pdf_name]);
            $tracking->save();
            $tracking2->save();

            $log = new Log([
              'status' => ''.strtoupper(auth()->user()->username).' update Consignment No. ['.$request->cn_no.'] proof of delivery.'
            ]);
            $log->save();

            return back()->with('success', 'Consignment Note Number: '.$request->cn_no.' is successfully updated.');
          }
        }
        else // status = in-progress
        {
          if(!$request->attachment)
          {
            $data = request([
              'status'
            ]);

            OutForDelivery::whereId($id)->update($data);

            $log = new Log([
              'status' => ''.strtoupper(auth()->user()->username).' update Consignment No. ['.$request->cn_no.'].'
            ]);
            $log->save();

            return back()->with('success', 'Consignment Note Number: '.$request->cn_no.' is successfully updated.');
          }
          else
          {
            return back()->with('error', 'Please select Status as Completed to upload POD.');
          }

        }
      }
      else
      {
        $this->destroyOFD($id);
        Storage::delete('public/DeliveryProof/'.$request->attachment);

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' close Consignment No. ['.$request->cn_no.'].'
        ]);
        $log->save();

        return back()->with('success', 'Consignment Note is successfully closed.');
      }
    }

    public function destroyOFD($id)
    {
        OutForDelivery::destroy($id);
        return back();
    }

    public function downloadAttachment($attachment)
    {
      $path = storage_path().'/'.'DeliveryProof/'.$attachment;
      return Response::download($path);
    }

    public function downloadDriverOFD(Request $request)
    {
      $drivername = $request->get('driver_name');
      $date_from = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
      $date_to = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
      $company = Company::first();

      $driver_data=DB::select('select * FROM out_for_delivery where driver_name = :driver_name and datetime BETWEEN :date_from and :date_to order by datetime', ['driver_name' => $drivername, 'date_from' => $date_from, 'date_to' => $date_to]);

      view()->share([
        'driver_data' => $driver_data,
        'company' => $company
        ]);

      $date = now();
      $pdf_name = $date->format('d-m-Y') . '_' . $request->driver_name .'.pdf';

      $data = [
        'title' => $pdf_name,
        'driver_name' => $drivername,
      ];
      $pdf = PDF::loadView('pages.dashboardpage.pdf.driver', $data);
      return $pdf->stream();
    }

    public function log()
    {
      $checkAdmin = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $tasklist = Task::where('status','!=','X')->take(5)->get();
      $calllist = Call::where('status','!=','X')->take(5)->get();

      return view('pages.dashboardpage.log')->with(compact('checkAdmin','activeCount','task','countpriority','priority','tasklist','calllist','call'));
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
