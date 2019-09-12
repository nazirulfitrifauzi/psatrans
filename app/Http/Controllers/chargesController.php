<?php

namespace App\Http\Controllers;

use App\Charges;
use App\User;
use App\Shipping;
use App\Destination;
use App\Task;
use App\Call;
use App\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class chargesController extends Controller
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

      return view('pages.maintenance.charges.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    public function search(Request $request)
    {
      $data   =   $request->shipper_code;

      $count       = Shipping::where('shipper_code','=', $data)
                                ->where('deleted_by', '=', '')
                                ->count();

      $search       = Shipping::where('shipper_code','=', $data)
                                ->where('deleted_by', '=', '')
                                ->first();
      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $destination  = Destination::where('deleted_by','=','')->get();

      $chargesx=DB::select('select A.DESTINATION_CODE, B.CARTON_RATE, B.M3_RATE, B.P_RATE, B.S_RATE, B.M_RATE, B.B_RATE, B.XL_RATE, B.PKT_RATE, B.ID, B.SHIPPER_CODE FROM destination A LEFT JOIN charges B ON A.DESTINATION_CODE=B.DESTINATION_CODE AND B.SHIPPER_CODE= :id WHERE A.DELETED_BY="" ORDER BY A.DESTINATION_CODE', ['id' => $data]);

      if($count == 0)
      {
        return redirect('charges')->with(compact('checkAdmin','activeCount','task','countpriority','priority'))->with('error', 'Shipper code not found. Please enter a valid shipper code.');
      }
      else
      {
        return view('pages.maintenance.charges.search')->with(compact('checkAdmin','activeCount', 'search', 'chargesx','task','countpriority','priority','call'));
      }
    }

    public function updateCharges(Request $request)
    {
      $charges  = $request->input('charges');

      foreach($charges as $row){
        $charge = Charges::find($row['ID']);
        $data2  = array(
          'carton_rate'       => $row['CARTON_RATE'],
          'm3_rate'           => $row['M3_RATE'],
          'p_rate'            => $row['P_RATE'],
          's_rate'            => $row['S_RATE'],
          'm_rate'            => $row['M_RATE'],
          'b_rate'            => $row['B_RATE'],
          'xl_rate'           => $row['XL_RATE'],
          'pkt_rate'          => $row['PKT_RATE'],
          'shipper_code'      => $row['SHIPPER_CODE']
        );
        Charges::whereId($row['ID'])->update($data2);
        $search       = Shipping::where('shipper_code','=', $row['SHIPPER_CODE'])
                                  ->where('deleted_by', '=', '')
                                  ->first();
        $chargesx=DB::select('select A.DESTINATION_CODE, B.CARTON_RATE, B.M3_RATE, B.P_RATE, B.S_RATE, B.M_RATE, B.B_RATE, B.XL_RATE, B.PKT_RATE, B.ID, B.SHIPPER_CODE FROM destination A LEFT JOIN charges B ON A.DESTINATION_CODE=B.DESTINATION_CODE AND B.SHIPPER_CODE= :id WHERE A.DELETED_BY="" ORDER BY A.DESTINATION_CODE', ['id' => $row['SHIPPER_CODE']]);
      }

      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

    //return redirect('charges')->with(compact('checkAdmin','activeCount'))->with('success', 'Charges Setup successfully save.');

    return redirect('charges')->with(compact('checkAdmin','activeCount', 'search', 'chargesx','task','countpriority','priority','call'))->with('success', 'Rate charge has been successfully updated.');

    //return $request->all();
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
     * @param  \App\Charges  $charges
     * @return \Illuminate\Http\Response
     */
    public function show(Charges $charges)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Charges  $charges
     * @return \Illuminate\Http\Response
     */
    public function edit(Charges $charges)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Charges  $charges
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Charges $charges)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Charges  $charges
     * @return \Illuminate\Http\Response
     */
    public function destroy(Charges $charges)
    {
        //
    }
}
