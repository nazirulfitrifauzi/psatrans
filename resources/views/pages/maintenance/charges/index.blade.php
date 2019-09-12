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
Charges Setup
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Shipper Code Check -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-tools"></i> <strong>Shipper Code Check</strong></p>
        </div>
        <div class="col-12 px-2 py-4">
          <div class="row">
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
            <div class="col-12 px-2">
              <form class="form-group" action="{{ route('charges.search') }}" method="post">
                @csrf
                <div class="form-inline">
                  <input class="form-control col-4 col-xl-3 borderFlatRight" type="search" placeholder="Enter shipper code" name="shipper_code" onkeyup="this.value = this.value.toUpperCase();">
                  <button class="btn btn-light my-2 my-sm-0 borderFlatLeft" type="submit">Search</button>
                </div>
              </form>
            </div>
            <small class="form-text text-muted px-2"><i class="fas fa-info-circle"></i> Search rates based on specific shipper code.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
