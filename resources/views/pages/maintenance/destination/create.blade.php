@extends('layouts.app')

@section('style')
<style media="screen">
.dataTables_filter {
   float: right !important;
}
.dataTables_info {
  font-size: 80%;
  font-weight: 400;
  display: block;
  margin-top: .25rem;
  color: #6c757d !important;
}
.dataTable > thead > tr > th[class*='sort']:before, .dataTable > thead > tr > th[class*='sort']:after { content: '' !important; }

</style>
@endsection

@section('page_title')
Destination Setup
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 New Destination Added -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-tools"></i> <strong>New Destination</strong></p>
        </div>
        <div class="col-12 col-xl-10 px-0 py-4">
          
          @if(\Session::has('error'))
            <div role="alert" class="col-12 px-2 alert alert-danger alert-dismissible fade show">
              {!! \Session::get('error') !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
          @elseif(\Session::has('success'))
            <div role="alert" class="col-12 px-2 mt-3 alert alert-primary alert-dismissible fade show">
              {!! \Session::get('success') !!}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
          @endif

          <form class="needs-validation" method="POST" action="{{ route('destination.store') }}">
            @csrf
            <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="destinationCode"><sup>*</sup> Destination Code</label>
              <input type="text" class="form-control" id="destinationCode" placeholder="Enter destination code" name="destination_code"  onkeyup="this.value = this.value.toUpperCase();" required>
              <div class="invalid-feedback">Please enter destination code</div>
            </div>
            <div class="col-md-8 mb-3">
              <label for="destinationName"><sup>*</sup> Destination Name</label>
              <input type="text" class="form-control" id="destinationName" placeholder="Enter destination name" name="destination_name" required>
              <div class="invalid-feedback">Please enter destination name</div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary col-5 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
            <a class="btn btn-success col-5 col-md-2 mt-4" href="{{ route('destination.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
