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
Transaction
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Transaction: Consignment Note Search-->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-box-open"></i> <strong>Check Consignment Note</strong></p>
        </div>
        <div class="col-12 px-2 py-4">
          <div class="row">
            @if(\Session::has('error'))
              <div role="alert" class="col-12 px-2 mt-3 alert alert-danger alert-dismissible fade show">
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
            <div class="col-12 col-md-6 px-2">
              <form class="form-group" action="{{ route('consignment.search') }}" method="post">
                @csrf
                <div class="form-inline">
                  <input class="form-control col-8 col-xl-6 borderFlatRight" type="search" placeholder="Consignment note" name="cn_no" required>
                  <button class="btn btn-light my-2 my-sm-0 borderFlatLeft" type="submit">Search</button>
                </div>
              </form>
            </div>
          </div>
          <small class="form-text text-muted"><i class="fas fa-info-circle"></i> Check if consignment note is already exist. Add in new consignment note if code not exist.</small>
        </div>
      </div>
    </div>
  </div>
@endsection
