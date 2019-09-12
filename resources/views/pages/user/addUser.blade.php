@extends('layouts.app')

@section('style')
<style media="screen">
.dataTables_filter {
  text-align: left !important;
}
</style>
@endsection

@section('page_title')
New User
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 New User Form -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-users"></i> <strong>New User Account</strong></p>
        </div>

        @if(\Session::has('error'))
        <div role="alert" class="col-12 px-2 mt-3 alert alert-danger alert-dismissible fade show">{!! \Session::get('error') !!}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
          </button>
        </div>
        @elseif(\Session::has('success'))

        @endif

        <div class="col-12 col-xl-10 px-0 py-4">
          <form class="needs-validation" method="POST" action="{{ route('user.store') }}">
            @csrf
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="firstName"><sup>*</sup> First Name</label>
                <input type="text" class="form-control" id="firstName" placeholder="Enter first name" name="firstname" value="{{ old('firstname') }}" required>
                <div class="invalid-feedback">Please enter first name</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName"><sup>*</sup> Last Name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Enter last name" name="lastname" value="{{ old('lastname') }}" required>
                <div class="invalid-feedback">Please enter last name</div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="register"><sup>*</sup> Username</label>
                <input type="text" class="form-control" id="register" placeholder="Enter username" name="username" value="{{ old('username') }}" required>
                <div class="invalid-feedback">Please enter username</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="email"><sup>*</sup> Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}" required>
                <div class="invalid-feedback">Please enter email address</div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="role"><sup>*</sup> Role</label>
                <select required id="role" class="form-control"name="role">
                  <option selected="true" disabled="disabled">Select Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                  <option value="client">Client</option>
                </select>
                <div class="invalid-feedback">Please select a role</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="position"><sup>*</sup> Position</label>
                <select required id="position" class="form-control" name="position">
                  <option selected="true" disabled="disabled">Select Position</option>
                  <option value="executive">Executive</option>
                  <option value="driver">Driver</option>
                </select>
                <div class="invalid-feedback">Please enter position</div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary col-5 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
            <a class="btn btn-secondary col-5 col-md-2 mt-4" href="{{ route('user.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
@endsection
