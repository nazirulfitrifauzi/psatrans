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
History
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Log History -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-history" style="color: #212529;"></i> <strong>Log History</strong></p>
        </div>
        <br>
        <table id="log_table" class="table table-sm table-striped mt-4">
          <thead>
            <tr>
              <th class="align-top" scope="col" width="20%">Date/Time&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="80%">Status</th>
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
     $('#log_table').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax": "{{ route('ajaxdata.getdatalog') }}",
       "columns":[
           { "data": "datetime", "name": "datetime", render:function(data, type, row)
             {
                return moment(data).format("DD MMM YYYY, h:mm a");
             }, "sortable":false
           },
           { "data": "status", "sortable":false },

       ],
       "bLengthChange": false,
       "dom": "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
     });
});
</script>
@endsection
