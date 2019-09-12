<?php

namespace App\Http\Controllers;


use App\User;
use App\Task;
use App\Call;
use App\Log;
use App\Mail\userApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
//use \App\Jobs\sendApprovedEmail;

class signupController extends Controller
{
  public function activateUser()
  {
      $checkAdmin = auth()->user()->role;
      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();
      $task = Task::where('status','!=','X')->take(5)->get();
      $call = Call::where('status','!=','X')->take(5)->get();
      $countpriority = Task::where('status','I')->where('priority','4')->count();
      $priority = Task::where('status','I')->where('priority','4')->get();

      $requestAccess  = User::where('active','=','0')
                        ->orderBy('username','ASC')
                        ->paginate(10);

      return view('pages.user.userActivation')->with(compact('checkAdmin','activeCount','requestAccess','task','countpriority','priority','call'));
  }

  public function update(Request $request, $id)
  {
      $username = User::where('id',$id)->value('username');

      $log = new Log([
        'status' => ''.strtoupper(auth()->user()->username).' approve access request for ['.$username.'].'
      ]);
      $log->save();

      $data = User::whereId($id)->update(['active' => 1]);
      $this->sendEmail($id);

      $checkActive  = User::where('active','=','0')->get();
      $activeCount  = $checkActive->count();

      if ($activeCount >= 1)
      {
        return back();
      }
      else
      {
        return redirect('/dashboard');
      }
  }

  public function destroy($id)
  {
    $username = User::where('id',$id)->value('username');

    $log = new Log([
      'status' => ''.strtoupper(auth()->user()->username).' reject access request for ['.$username.'].'
    ]);
    $log->save();

    $data = User::whereId($id)->delete();

    return back();
  }

  public function sendEmail($id)
  {
      $firstname = User::whereId($id)->value('firstname');
      //job queue
      //$details['email'] = User::whereId($id)->value('email');
      //dispatch(new sendApprovedEmail($details));

      // uncomment this to not use queue job
      $email  = User::whereId($id)->value('email');
      Mail::to($email)->send(new userApproved($firstname));
  }
}
