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
Report
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Statement Report Check -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-dollar-sign"></i> <strong>Generate Statement</strong></p>
        </div>
        <div class="col-12 col-xl-10 px-0 py-4">
          <form action="/statement/search" target="_blank" method="post">
            @csrf
            <div class="form-row">
              <div class="col-lg-6 col-xl-4 mb-3">
                <label for="start_date"><sup>*</sup> Start Date</label>
                <div class="input-group date" id="start_date" data-target-input="nearest">
                  <input name="start_date" type="text" class="form-control datetimepicker-input" data-target="#start_date" placeholder="Enter start date">
                  <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-xl-4 mb-3">
                <label for="end_date"><sup>*</sup> End Date</label>
                <div class="input-group date" id="end_date" data-target-input="nearest">
                  <input name="end_date" type="text" class="form-control datetimepicker-input" data-target="#end_date" placeholder="Enter end date">
                  <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="destinationCode"><sup>*</sup> Shipper Code</label>
              <input class="form-control col-md-8 col-xl-4" type="text" placeholder="Enter shipper code" name="shipper_code" onkeyup="this.value = this.value.toUpperCase();" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary my-4">Generate Statement</button>
            <small class="form-text text-muted"><i class="fas fa-info-circle"></i> You may filter the report specifically by Shipper account.</small>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">

$(document).ready(function() {
  $('#start_date').datetimepicker({
      format: 'DD/MM/YYYY'
  });

  $('#end_date').datetimepicker({
      format: 'DD/MM/YYYY'
  });

});

</script>
@endsection
