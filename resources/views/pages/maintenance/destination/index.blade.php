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
    <!-- Row 1 Destination Check -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-tools"></i> <strong>Destination Code Check</strong></p>
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
              <form class="form-group" action="{{ route('destination.search') }}" method="post">
                @csrf
                <div class="form-inline">
                  <input class="form-control col-8 col-xl-6 borderFlatRight" type="search" name="destination_code" placeholder="Destination code">
                  <button class="btn btn-light my-2 my-sm-0 borderFlatLeft" type="submit">Search</button>
                </div>
              </form>
            </div>
            <div class="col-12 col-md-6 px-2">
              <a class="btn btn-primary float-right" href="{{ route('destination.create') }}" role="button"><i class="fas fa-plus"></i>  Add new destination account</a>
            </div>
            <small class="form-text text-muted px-2"><i class="fas fa-info-circle"></i> Check if destination code is already exist. Add in new destination code if code not exist.</small>
          </div>
        </div>
      </div>
    </div>
    <!-- Row 2 Destination List -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
          <p><i class="fas fa-tools"></i> <strong>Destination List</strong></p>
        </div>
        <br>
        <table id="destination_table" class="table table-sm table-striped">
          <thead>
            <tr>
              <th class="align-top" scope="col" width="10%">ID&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="20%">Code&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="70%">Name&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
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
  $('#destination_table').DataTable({
    "processing": true,
    "serverSide": false,
    "ajax": "{{ route('ajaxdata.getdatadestination') }}",
    "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "All"]],
    "columns":[
        { "data": "id", "searchable": false },
        { "data": "destination_code" },
        { "data": "destination_name", "searchable": false },
    ],
    "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
           "<'row'<'col-sm-12 col-md-12'B>>",
    "language": {"searchPlaceholder": "Enter Destination Code"},
    "buttons": [
            { extend: 'pdf', className: 'btn btn-primary col-md-2', text: 'Download' },
            { extend: 'print', className: 'btn btn-success col-md-2', text: 'Print'}
        ]
  });
});
</script>
@endsection
