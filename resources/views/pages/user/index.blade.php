@extends('layouts.app')

@section('style')
<style media="screen">
.dataTables_filter {
   float: left !important;
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
User
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 User List -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-users"></i> <strong>User List</strong></p>
        </div>

        @if(\Session::has('error'))

        @elseif(\Session::has('success'))
          <div role="alert" class="col-12 px-2 mt-3 alert alert-primary alert-dismissible fade show">User account has been successfully added.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </div>
        @endif

        <br>
        <!-- User Table -->
        <table id="user_table" class="table table-sm table-striped">
          <thead>
            <tr>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="15%">Position&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="15%">Role&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="15%">Username</th>
              <th class="align-top d-none d-md-table-cell" scope="col" width="15%">First Name</th>
              <th class="align-top d-none d-md-table-cell" scope="col" width="15%">Last Name</th>
              <th class="align-top" scope="col" width="20%">Email</th>
              <th class="align-top" scope="col" width="5%"></th>
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
     $('#user_table').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax": "{{ route('ajaxdata.getdatauser') }}",
       "columns":[
           { "data": "position", "searchable":false },
           { "data": "role", "searchable":false },
           { "data": "username", "sortable":false, "searchable":false },
           { "data": "firstname", "sortable":false },
           { "data": "lastname", "sortable":false, "searchable":false },
           { "data": "email", "sortable":false, "searchable":false },
           { render:function(data, type, row){
               return "<a href='user/"+ row.id +"'><i class='fas fa-edit float-right'></i></a>"
             }, "sortable":false, "searchable":false
           },

       ],
       "bLengthChange": false,
       "dom": "<'row'<'col-sm-12 col-md-12'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "language": {"searchPlaceholder": "First Name"}
     });
});
</script>
@endsection
