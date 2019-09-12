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

.button-circle {
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
    color: #0073aa;
  }
.file {
  visibility: hidden;
  position: absolute;
}
</style>
@endsection

@section('page_title')
Consignment Out for Delivery
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Consignment HQ List -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
          <p><i class="fas fa-box-open"></i> <strong>Consignment Out for Delivery</strong></p>
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
            <div class="col-12 col-md-7 px-2">
              <form class="form-group" action="{{ route('dashboard.outForDelivery') }}" method="get">
                <div class="form-inline">
                  <input id="search" type="text" class="form-control col-8 col-xl-5 borderFlatRight" name="search" placeholder="Search..." value="{{ isset($search) ? $search : '' }}">
                  <div class="input-group-append">
                    <button toggle="#search" type="submit" class="btn btn-light my-2 my-sm-0 borderFlatLeft"> Search </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <table id="consignment_table" class="table table-sm table-striped">
          <thead>
            <tr>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="15%">Date/Time</th>
              <th class="align-top" scope="col" width="10%">CN No</th>
              <th class="align-top d-none d-md-table-cell" scope="col" width="12%">Shipper</th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="12%">Des</th>
              <th class="align-top d-none d-md-table-cell" width="12%">Driver</th>
              <th class="align-top" scope="col" width="18%">Status</th>
              <th class="align-top" scope="col" width="18%">P.O.D</th>
              <th class="align-top" scope="col" width="7%"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($ofdlist as $row)
                <tr>
                  <form class="col-md-12" action="OutForDelivery/{{ $row->id }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf

                    <td class="align-middle d-none d-sm-table-cell">
                      {{ date_format($row['datetime'], "d M Y, g:ia") }}
                    </td>
                    <td class="align-middle">{{ $row['cn_no'] }}
                      <input type="hidden" value="{{ $row->id }}" name="id">
                      <input type="hidden" value="{{ $row->cn_no }}" name="cn_no">
                    </td>
                    <td class="align-middle d-none d-md-table-cell">
                      {{ $row['shipper_code'] }}
                      <input type="hidden" value="{{ $row->shipper_code }}" name="shipper_code">
                    </td>
                    <td class="align-middle d-none d-sm-table-cell">
                      {{ $row['destination_code'] }}
                      <input type="hidden" value="{{ $row->destination_code }}" name="destination_code">
                    </td>
                    <td class="align-middle d-none d-md-table-cell">
                      {{ $row['driver_name'] }}
                      <input type="hidden" value="{{ $row->driver_name }}" name="driver_name">
                    </td>
                    <td class="align-middle">
                      <select class="custom-select custom-select-sm" id="status" name="status">
                        <option value="In-progress" {{ ($row->status == 'In-progress') ? 'selected' : '' }}>On Road</option>
                        <option value="Completed" {{ ($row->status == 'Completed') ? 'selected' : '' }}>Completed</option>
                        @if ($checkAdmin == 'admin')
                        <option value="Close" {{ ($row->status == 'Close') ? 'selected' : '' }}>Close</option>
                        @endif
                      </select>
                    </td>
                    <td class="align-middle">
                      @if($row->attachment == '')
                        <div class="input-group">
                          <input type="hidden" value="{{ $row->attachment }}" name="attachment">
                          <input type="file" name="attachment" class="file">
                          <div class="input-group">
                            <input type="text" class="form-control" name="attachment" disabled placeholder="Upload Receipt" aria-label="Upload File" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                              <span class="browse input-group-text btn btn-primary" id="basic-addon2">
                                <i class="fas fa-search"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      @else
                        <a href="{{ Storage::url('DeliveryProof/'.$row->attachment.'') }}" target="_blank" class="btn btn-light btn-sm w-100 float-left" href="#" role="button"><i class="fas fa-paperclip"></i> Download</a>
                      @endif
                    </td>
                    <td class="align-middle">
                      <button type="submit" class="button-circle"><i class="fas fa-check-circle"></i></button>
                    </td>
                  </form>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No Record</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $ofdlist->appends(['search' => $search])->links() }}
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">

$(document).on("click", ".browse", function() {
  var file = $(this)
    .parent()
    .parent()
    .parent()
    .find(".file");
  file.trigger("click");
});

$(document).on("change", ".file", function() {
  $(this)
    .parent()
    .find(".form-control")
    .val(
      $(this)
        .val()
        .replace(/C:\\fakepath\\/i, "")
    );
});
</script>
@endsection
