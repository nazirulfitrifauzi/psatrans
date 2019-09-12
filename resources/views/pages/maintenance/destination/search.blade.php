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
    <!-- Row 1 Existing Destination Added -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-tools"></i> <strong>Existing Destination Account Update</strong></p>
        </div>
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
        <div class="col-12 col-xl-10 px-0 py-4">
          <form class="needs-validation" action="/destination/{{ $search->id }}" method="post">
            @method('PATCH')
            @csrf
            <div class="form-row">
            <div class="col-md-4 destinationName">
              <label for="destinationCode"><sup>*</sup> Destination Code</label>
              <input type="text" class="form-control" id="destinationCode" placeholder="Enter destination code" value="{{ $search->destination_code }}" name="destination_code" required>
              <div class="invalid-feedback">Please enter destination code</div>
            </div>
            <div class="col-md-8 destinationName">
              <label for="destinationName"><sup>*</sup> Destination Name</label>
              <input type="text" class="form-control" id="destinationName" placeholder="Enter destination name" value="{{ $search->destination_name }}" name="destination_name" required>
              <div class="invalid-feedback">Please enter destination name</div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary col-3 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
            <a onclick="deleteData({{ $search->id }})" class="btn btn-success col-4 col-md-2 mt-4" style="color: white;"><i class="fa fa-trash"></i> Delete</a>
            <a class="btn btn-secondary col-4 col-md-2 mt-4" href="{{ route('destination.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </form>
        </div>
      </div>
    </div>
    <!-- Row 2 Destination List -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
          <p><i class="fas fa-tools"></i> <strong>Destination List</strong></p>
        </div>
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
        { "data": "id" },
        { "data": "destination_code" },
        { "data": "destination_name" },
    ],
    "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
           "<'row'<'col-sm-12 col-md-12'B>>",
    "buttons": [
            { extend: 'pdf', className: 'btn btn-primary col-md-2', text: 'Download' },
            { extend: 'print', className: 'btn btn-success col-md-2', text: 'Print'}
        ]
  });
});
</script>
<script>
  function deleteData(id) {
      Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: "warning",
          confirmButtonColor: '#2fa360',
          cancelButtonColor: '#d33',
          showCancelButton: !0,
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!"
      }).then(function (e) {

          if (e.value === true) {
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

              $.ajax({
                  type: 'POST',
                  url: "{{ url('destination')}}" + '/' + id,
                  data: {'_token' : CSRF_TOKEN, '_method' : 'DELETE'},
                  dataType: 'JSON',
                  success: function (results) {
                      if (results.success === true) {
                          Swal.fire(
                            "Done!",results.message,"success"
                          ).then(function() {
                            window.location = "{{ url('destination')}}";
                          });
                      } else {
                          swal("Error!", results.message, "error");
                      }
                  }
              });

          } else {
              e.dismiss;
          }
      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection
