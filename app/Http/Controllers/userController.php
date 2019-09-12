<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\User;
use App\Task;
use App\Call;
use App\Log;
use App\Mail\userApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Mail\userCreated;


class userController extends Controller
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
      $checkAdmin = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      return view('pages.user.index')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $checkAdmin = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      return view('pages.user.addUser')->with(compact('checkAdmin','activeCount','task','countpriority','priority','call'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkEmail = User::where('email',$request->get('email'))->count();
        $checkUsername = User::where('username',$request->get('username'))->count();

        if($checkEmail > 0)
        {
          return back()->with('error', "User with email <b>'".$request->get('email')."'</b> already created.");
        }
        elseif($checkUsername > 0)
        {
          return back()->with('error', "User with username <b>'".$request->get('username')."'</b> already created.");
        }
        else
        {
          $this->validate($request, [
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'position' => ['required', 'string'],
            'role' => ['required', 'string']
          ]);

          $user = new User([
            'firstname' =>  $request->get('firstname'),
            'lastname' =>  $request->get('lastname'),
            'email' =>  $request->get('email'),
            'username' =>  $request->get('username'),
            'position' =>  $request->get('position'),
            'password' => Hash::make('psa@123!'),
            'role' =>  $request->get('role'),
            'active' => 1
          ]);

          $firstname = $request->get('firstname');

          $user->save();

          $email  = $request->get('email');
          Mail::to($email)->send(new userCreated($firstname));

          $log = new Log([
            'status' => ''.strtoupper(auth()->user()->username).' create user ['.$request->get('username').'].'
          ]);
          $log->save();

          return redirect()->route('user.index')->with('success', 'User added successfully.');
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
      $checkAdmin   = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $assign = User::where('position','EXECUTIVE')->get();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $userdata = User::whereId($id)->first();

      return view('pages.user.show')->with(compact('checkAdmin','activeCount','userdata','task','countpriority','priority','assign','call'));
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
      $data = request([
        'firstname',
        'lastname',
        'username',
        'email',
        'role',
        'position'
      ]);

      User::whereId($id)->update($data);

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' update user ['.$request->get('username').'].'
      ]);
      $log->save();

      return back()->with('success', 'User account has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $username = User::where('id',$id)->value('username');

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' delete user ['.$username.'].'
      ]);
      $log->save();

      User::destroy($id);

      //  Return response
      return response()->json([
          'success' => true,
          'message' => "User Account has been deleted.",
      ]);
    }

}
