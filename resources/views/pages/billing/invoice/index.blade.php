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
Billing
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Billing Invoice Search -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-sticky-note"></i> <strong>Shipper Invoice</strong></p>
        </div>

        @if(\Session::has('error'))
          <div role="alert" class="col-12 px-2 mt-3 alert alert-danger alert-dismissible fade show">{!! \Session::get('error') !!}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </div>
        @elseif(\Session::has('success'))
          <div role="alert" class="col-12 px-2 mt-3 alert alert-primary alert-dismissible fade show">{!! \Session::get('success') !!}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </div>
        @endif

        <div class="col-12 col-xl-10 px-0 py-4">
          <form class="needs-validation" method="POST" target="_blank" action="{{ route('invoice.download') }}">
            @csrf
            <div class="form-row">
              <div class="col-lg-6 col-xl-4 mb-3">
                <label for="date_from"><sup>*</sup> Start Date</label>
                <div class="input-group date" id="date_from" data-target-input="nearest">
                  <input name="date_from" type="text" class="form-control datetimepicker-input" data-target="#date_from" placeholder="Enter start date">
                  <div class="input-group-append" data-target="#date_from" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-xl-4 mb-3">
                <label for="date_to"><sup>*</sup> End Date</label>
                <div class="input-group date" id="date_to" data-target-input="nearest">
                  <input name="date_to" type="text" class="form-control datetimepicker-input" data-target="#date_to" placeholder="Enter end date">
                  <div class="input-group-append" data-target="#date_to" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="shipperCode"><sup>*</sup> Shipper Code</label>
              <input class="form-control col-8 col-xl-4" type="text" id="shipperCode" placeholder="Enter shipper code" name="shipper_code" onkeyup="this.value = this.value.toUpperCase();" required>
            </div>
            <button class="btn btn-primary my-4" role="button">Generate Invoice</button>
            <small class="form-text text-muted"><i class="fas fa-info-circle"></i> You may generate the report by Date & Shipper Code. All elements are compulsory.</small>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">

$(document).ready(function() {
  $('#date_from').datetimepicker({
      format: 'DD/MM/YYYY'
  });

  $('#date_to').datetimepicker({
      format: 'DD/MM/YYYY'
  });
});
</script>
@endsection
