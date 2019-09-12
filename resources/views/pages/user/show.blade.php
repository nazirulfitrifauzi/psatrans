@extends('layouts.app')

@section('style')

@endsection

@section('page_title')
User
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 New User Form -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-users"></i> <strong>Existing User Account</strong></p>
        </div>
        @if(\Session::has('error'))

        @elseif(\Session::has('success'))
          <div role="alert" class="col-12 px-2 mt-3 alert alert-primary alert-dismissible fade show">
            {!! \Session::get('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </div>
        @endif

        <div class="col-12 col-xl-10 px-0 py-4">
          <form class="needs-validation" action="/user/{{ $userdata->id }}" method="post">
            @method('PATCH')
            @csrf
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="firstName"><sup>*</sup> First Name</label>
                <input type="text" class="form-control" id="firstName" placeholder="Enter first name" name="firstname" value="{{ $userdata->firstname }}" required>
                <div class="invalid-feedback">Please enter first name</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName"><sup>*</sup> Last Name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Enter last name" name="lastname" value="{{ $userdata->lastname }}" required>
                <div class="invalid-feedback">Please enter last name</div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="register"><sup>*</sup> Username</label>
                <input type="text" class="form-control" id="register" placeholder="Enter username" name="username" value="{{ $userdata->username }}" required>
                <div class="invalid-feedback">Please enter username</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email"><sup>*</sup> Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ $userdata->email }}" required>
                <div class="invalid-feedback">Please enter email address</div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="role"><sup>*</sup> Role</label>
                <select required id="role" class="form-control" name="role">
                  <option value="admin" @if($userdata->role == 'admin') selected @endif>Admin</option>
                  <option value="user" @if($userdata->role == 'user') selected @endif>User</option>
                  <option value="client" @if($userdata->role == 'client') selected @endif>Client</option>
                </select>
                <div class="invalid-feedback">Please enter role</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="position"><sup>*</sup> Position</label>
                <select required id="position" class="form-control" name="position">
                  <option value="executive" @if($userdata->position == 'executive') selected @endif>Executive</option>
                  <option value="driver" @if($userdata->position == 'driver') selected @endif>Driver</option>
                </select>
                <div class="invalid-feedback">Please enter position</div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary col-3 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
            <a style="color:#fff;" type="button" class="btn btn-success col-3 col-md-2 mt-4" onclick="deleteData({{ $userdata->id }})"><i class="fa fa-trash"></i> Delete</a>
            <a class="btn btn-secondary col-3 col-md-2 mt-4" href="{{ route('user.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {
     window.setTimeout(function() {
       $(".alert").fadeTo(500, 0).slideUp(500, function(){
         $(this).remove();
       });
     }, 4000);

});
</script>
<script>
  function deleteData(id) {
      Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: "warning",
          confirmButtonColor: '#2fa360',
          cancelButtonColor: '#d33',
          showCancelButton: !0,
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!"
      }).then(function (e) {

          if (e.value === true) {
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

              $.ajax({
                  type: 'POST',
                  url: "{{ url('user')}}" + '/' + id,
                  data: {'_token' : CSRF_TOKEN, '_method' : 'DELETE'},
                  dataType: 'JSON',
                  success: function (results) {
                      if (results.success === true) {
                          Swal.fire(
                            "Done!",results.message,"success"
                          ).then(function() {
                            window.location = "{{ url('user')}}";
                          });
                      } else {
                          swal("Error!", results.message, "error");
                      }
                  }
              });

          } else {
              e.dismiss;
          }
      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection
