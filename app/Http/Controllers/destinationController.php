<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\Destination;
use App\User;
use App\Shipping;
use App\Charges;
use App\Task;
use App\Call;
use App\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class destinationController extends Controller
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

      return view('pages.maintenance.destination.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    public function search(Request $request)
    {
      $data   =   $request->destination_code;

      $count       = Destination::where('destination_code','=', $data)
                                ->where('deleted_by', '=', '')
                                ->count();

      $search       = Destination::where('destination_code','=', $data)
                                ->where('deleted_by', '=', '')
                                ->first();
      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      if($count == 0)
      {
        return redirect('destination')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'))->with('error', 'Destination code not found. Please enter a valid destination code or register new destination account.');
      }
      else
      {
        return view('pages.maintenance.destination.search')->with(compact('checkAdmin','activeCount', 'search','task','countpriority','priority','call'));
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

      return view('pages.maintenance.destination.create')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
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
        'destination_code' => ['required', 'string', 'max:50'],
        'destination_name' => ['max:255']
      ]);

      $destination = new Destination([
        'destination_code'    =>  $request->get('destination_code'),
        'destination_name'    =>  $request->get('destination_name'),
        'created_on'          =>  now(),
        'created_by'          =>  auth()->user()->username,
        'deleted_by'          =>  '',
      ]);

      $code = $request->get('destination_code');
      $name = $request->get('destination_name');

      $checkdestinationcode = Destination::where('destination_code','=',$code)->exists();
      $checkdestinationname = Destination::where('destination_name','=',$name)->exists();

      if($checkdestinationcode == 'true')
      {
        return back()->with('error', 'Shipper code already existed.');
      }
      elseif($checkdestinationname == 'true')
      {
        return back()->with('error', 'Shipper name already existed.');
      }
      else
      {
        $shipping  = Shipping::distinct()
                        ->where('deleted_by','=','')
                        ->orderBy('shipper_code')
                        ->get(['shipper_code']);

        foreach($shipping as $row){
          $data2  = array(
            'shipper_code'      => $row['shipper_code'],
            'destination_code'  => $code,
            'created_by'        => '""',
            'created_on'        => now(),
            'changed_by'        => '""',
            'changed_on'        => null,
            'deleted_by'        => '""',
            'deleted_on'        => null
          );

          DB::table('charges')->insert($data2);
        }

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' create destination ['.$name.'].'
        ]);
        $log->save();

        $destination->save();
        return redirect()->route('destination.index')->with('success', 'Destination account has been successfully added.');
      }
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
      $request->validate([
        'destination_code' => ['required', 'string', 'max:50'],
        'destination_name' => ['max:255']
        ]);

      $changed_on = now();
      $changed_by = auth()->user()->username;
      $request->request->add([
        'changed_on' => $changed_on,
        'changed_by' => $changed_by
      ]);

      $data = request([
        'destination_code',
        'destination_name',
        'changed_on',
        'changed_by'
      ]);

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' update destination ['.$request->get('destination_name').'].'
      ]);
      $log->save();

      Destination::whereId($id)->update($data);

      return redirect('destination')->with('success', 'Destination is successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      $destination = Destination::whereId($id)->value('destination_code');
      $destination_name = Destination::whereId($id)->value('destination_code');

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' delete destination ['.$destination_name.'].'
      ]);
      $log->save();

      Destination::destroy($id);
      Charges::where('shipper_code','=',$destination)->delete();

      //  Return response
      return response()->json([
          'success' => true,
          'message' => "Destination has been deleted.",
      ]);
    }
}
