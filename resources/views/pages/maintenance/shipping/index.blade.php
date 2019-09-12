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
Shipper Setup
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Shipper Code Check -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-tools"></i> <strong>Shipper Account Verification</strong></p>
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

            <div class="col-12 col-md-6 px-2">
              <form class="form-group" action="{{ route('shipping.search') }}" method="post">
                @csrf
                <div class="form-inline">
                  <input class="form-control col-8 col-xl-6 borderFlatRight" type="search" placeholder="Enter shipper code" name="shipper_code">
                  <button class="btn btn-light my-2 my-sm-0 borderFlatLeft" type="submit">Search</button>
                </div>
              </form>
            </div>
            <div class="col-12 col-md-6 px-2">
              <a class="btn btn-primary float-right" href="{{ route('shipping.create') }}" role="button"><i class="fas fa-plus"></i>  Add new shipper account</a>
            </div>
          </div>
          <div class="row">
            <small class="form-text text-muted px-2"><i class="fas fa-info-circle"></i> Check if shipper account is already exist. Add in new shipper code if account not exist.</small>
          </div>

        </div>
      </div>
    </div>
    <!-- Row 2 Shipper Account List -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
          <p><i class="fas fa-tools"></i> <strong>Shipper Account</strong></p>
        </div>
        <br>
        <table id="shipping_table" class="table table-sm table-striped">
          <thead>
            <tr>
              <th class="align-top d-none d-md-table-cell" scope="col" width="8%">ID&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="13%">Code&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="30%">Name&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="15%">Tel</th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="18%">Email</th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="16%">Contact</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">

$(document).ready(function() {
  $('#shipping_table').DataTable({
    "processing": true,
    "serverSide": false,
    "ajax": "{{ route('ajaxdata.getdatashipping') }}",
    "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "All"]],
    "columns":[
        { "data": "id", "searchable": false },
        { "data": "shipper_code" },
        { "data": "shipper_name", "searchable": false },
        { "data": "telephone", "orderable": false, "searchable": false},
        { "data": "email", "orderable": false, "searchable": false},
        { "data": "contact", "orderable": false, "searchable": false},
    ],
    "buttons": [
            { extend: 'pdf', className: 'btn btn-primary col-md-2', text: 'Download' },
            { extend: 'print', className: 'btn btn-success col-md-2', text: 'Print'}
        ],
    "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
           "<'row'<'col-sm-12 col-md-12'B>>",
    "language": {"searchPlaceholder": "Enter Shipper Code"}
  });

});
</script>
@endsection
