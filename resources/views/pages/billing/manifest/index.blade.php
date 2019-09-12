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
    <!-- Row 1 Manifest Listing Search -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-sticky-note"></i> <strong>Manifest Search</strong></p>
        </div>
        <div class="col-12 col-xl-10 px-0 py-4">
          <form action="/manifest/search" target="_blank" method="post">
            @csrf
            <div class="form-group">
              <label><sup>*</sup> Date</label>
              <div class="input-group date col-md-8 col-xl-4 px-0" id="cn_datetime" data-target-input="nearest">
                <input name="cn_datetime" type="text" class="form-control datetimepicker-input" data-target="#cn_datetime" placeholder="Date">
                <div class="input-group-append" data-target="#cn_datetime" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="destination_code">Destination Code</label>
              <input class="form-control col-md-8 col-xl-4" type="text" placeholder="Enter destination code" name="destination_code" onkeyup="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
              <label for="city">City</label>
              <input class="form-control col-md-8 col-xl-4" type="text" placeholder="Enter city" name="city" onkeyup="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
              <label for="driver">Driver</label>
              <select name="driver_name" id="driver_name" class="form-control col-md-8 col-xl-4">
                <option selected="true" disabled="disabled">Driver Name</option>
                @foreach ($driver as $drivername)
                  <option value="{{ $drivername->username }}">{{ $drivername->username }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary my-4" role="button">Preview Report</button>
            <small class="form-text text-muted"><i class="fas fa-info-circle"></i> You may filter the report by Destination Code OR City OR Driver Name. Date are compulsory.</small>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('#cn_datetime').datetimepicker({
        format: 'DD/MM/YYYY'
    });
  });
</script>
@endsection
