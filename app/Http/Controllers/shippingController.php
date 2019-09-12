<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\Shipping;
use App\Account;
use App\User;
use App\Destination;
use App\Charges;
use App\Task;
use App\Call;
use App\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
Use Alert;

class shippingController extends Controller
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

      return view('pages.maintenance.shipping.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
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

      $shipper_acc = Account::where('shipper_code',$data)
                              ->orderBy('update_time','desc')
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
        return redirect('shipping')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'))->with('error', 'Shipper account not found. Please enter a valid shipper code or register new shipper account.');
      }
      else
      {
        return view('pages.maintenance.shipping.search')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call', 'search','shipper_acc'));
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

      return view('pages.maintenance.shipping.create')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //dd($request->all());

      $this->validate($request, [
        'shipper_code' => ['required', 'string', 'max:50'],
        'shipper_name' => ['max:500']
      ]);

      $shipping = new Shipping([
        'shipper_code'    =>  $request->get('shipper_code'),
        'shipper_name'    =>  $request->get('shipper_name'),
        'contact'         =>  $request->get('contact'),
        'gst_id'          =>  $request->get('gst_id'),
        'address1'        =>  $request->get('address1'),
        'city'            =>  $request->get('city'),
        'state'           =>  $request->get('state'),
        'country'         =>  $request->get('country'),
        'postcode'        =>  $request->get('postcode'),
        'telephone'       =>  $request->get('telephone'),
        'mobile'          =>  $request->get('mobile'),
        'fax'             =>  $request->get('fax'),
        'email'           =>  $request->get('email'),
        'credit_limit'    =>  $request->get('credit_limit'),
        'term_day'        =>  $request->get('term_day'),
        'invoice_format'  =>  $request->get('invoice_format'),
        'deleted_by'      =>  ''
      ]);

      $code = $request->get('shipper_code');
      $name = $request->get('shipper_name');

      $checkshippercode = Shipping::where('shipper_code','=',$code)->exists();
      $checkshippername = Shipping::where('shipper_name','=',$name)->exists();

      if($checkshippercode == 'true')
      {
        return back()->with('error', 'Shipper code already existed.');
      }
      elseif($checkshippername == 'true')
      {
        return back()->with('error', 'Shipper name already existed.');
      }
      else
      {
        $destination  = Destination::distinct()
                        ->where('deleted_by','=','')
                        ->orderBy('destination_code')
                        ->get(['destination_code']);

        foreach($destination as $row){
          $data2  = array(
            'shipper_code'      => $code,
            'destination_code'  => $row['destination_code'],
            'created_by'        => '',
            'created_on'        => now()
          );

          DB::table('charges')->insert($data2);
        }

        $account = new Account([
          'shipper_code' => $request->get('shipper_code'),
          'shipper_name' => $request->get('shipper_name'),
          'details'      => 'Account created',
          'amount'       => '0.00',
          'acc_bal'      => '0.00',
          'update_time'  => now()
        ]);

        $log = new Log([
          'status' => ''.strtoupper(auth()->user()->username).' create shipper account ['.$request->get('shipper_name').'].'
        ]);
        $log->save();

        //return $destination;
        $account->save();
        $shipping->save();
        return redirect()->route('shipping.index')->with('success', 'Shipping Account added successfully.');
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
      $oldshipper = Shipping::whereId($id)->value('shipper_code');

      $request->validate([
        'shipper_code' => ['required', 'string', 'max:50'],
        'shipper_name' => ['max:255']
        ]);

      $changed_on = now();
      $changed_by = auth()->user()->username;
      $request->request->add([
        'changed_on' => $changed_on,
        'changed_by' => $changed_by
      ]);

      $data = request([
        'shipper_code',
        'shipper_name',
        'contact',
        'gst_id',
        'address1',
        'city',
        'state',
        'country',
        'postcode',
        'telephone',
        'mobile',
        'fax',
        'email',
        'credit_limit',
        'term_day',
        'invoice_format',
        'changed_on',
        'changed_by'
      ]);

      Shipping::whereId($id)->update($data);

      Account::where('shipper_code',$oldshipper)
              ->update(['shipper_code' => $request->get('shipper_code'), 'shipper_name' => $request->get('shipper_name')]);

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' update shipper account ['.$request->get('shipper_name').'].'
      ]);
      $log->save();

      return redirect()->route('shipping.index')->with('success', 'Company details has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $shipper = Shipping::whereId($id)->value('shipper_code');
      $shipper_name = Shipping::whereId($id)->value('shipper_name');

      Shipping::destroy($id);
      Charges::where('shipper_code','=',$shipper)->delete();

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' delete shipper account ['.$shipper_name.'].'
      ]);
      $log->save();

      //  Return response
      return response()->json([
          'success' => true,
          'message' => "Shipper account has been successfully deleted.",
      ]);
    }
}
