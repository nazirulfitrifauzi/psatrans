@extends('layouts.app')

@section('style')

@endsection

@section('page_title')
User Activation
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 User List -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-users"></i> <strong>User List</strong></p>
        </div>
        <br>
        <!-- User Table -->
        <table id="user_table" class="table table-sm table-striped">
          <thead>
            <tr>
                <th style="text-align: center;">Username</th>
                <th style="text-align: center;">Email</th>
                <th style="text-align: center;">Position</th>
                <th style="text-align: center;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($requestAccess as $row)
                <tr>
                    <td align="center">{{ $row['username'] }}</td>
                    <td align="center">{{ $row['email'] }}</td>
                    <td align="center">{{ $row['position'] }}</td>
                    <td align="center">
                      <div class="row justify-content-center">
                        <form class="" action="/signup/{{ $row->id }}" method="post">
                          @method('PATCH')
                          @csrf
                          <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Approve</button>
                        </form>
                        &emsp;
                        <form class="" action="/signup/{{ $row->id }}" method="post">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Reject</button>
                        </form>
                      </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">No Record</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{$requestAccess->links()}}
    </div>
  </div>
@endsection

@section('script')
@endsection
