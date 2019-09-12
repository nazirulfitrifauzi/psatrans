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
Tracking
@endsection

@section('content')
<div class="row">
  @guest
    <div class="col-12 col-lg-11 col-xl-12 px-2">
  @else
    <div class="col-12 col-lg-8 col-xl-9 px-2">
  @endguest

    <!-- Row 1 Consignment Tracking -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-truck-moving"></i> <strong>Consignment Tracking</strong></p>
        </div>

        <div class="col-12 col-xl-6 px-0 py-4">
          <form class="needs-validation" method="POST" action="{{ route('tracking.search') }}" class="row">
            @csrf
            <div class="form-inline">
              <input id="cn_no" class="form-control col-8 col-xl-6 borderFlatRight" type="search" placeholder="Consignment note" name="cn_no" required>
              <button class="btn btn-light my-2 my-sm-0 borderFlatLeft" type="submit">Track Consignment</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
