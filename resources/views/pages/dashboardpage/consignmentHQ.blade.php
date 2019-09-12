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
</style>
@endsection

@section('page_title')
Consignment HQ
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Consignment HQ List -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
          <p><i class="fas fa-box-open"></i> <strong>Consignment in HQ</strong></p>
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
              <form class="form-group" action="{{ route('dashboard.consignmentHQ') }}" method="get">
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
              <th class="align-top" scope="col" width="15%">Date</th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="12%">Time</th>
              <th class="align-top" scope="col" width="15%">CN No</th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="15%">Shipper Code</th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="15%">Destination Code</th>
              <th class="align-top" scope="col" width="23%">Driver</th>
              <th class="align-top" scope="col" width="5%"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($hqlist as $row)
                <tr>
                  <form class="col-md-12" action="consignmentHQ/{{ $row->id }}" method="post">
                    @method('PATCH')
                    @csrf

                    <td class="align-top">{{ date_format($row['cn_datetime'], "d M Y") }}</td>
                    <td class="align-top d-none d-sm-table-cell">{{ date_format($row['cn_datetime'], "g:ia") }}</td>
                    <td class="align-top">
                      {{ $row['cn_no'] }}
                      <input type="hidden" value="{{ $row->id }}" name="id">
                      <input type="hidden" value="{{ $row->cn_no }}" name="cn_no">
                    </td>
                    <td class="align-top d-none d-sm-table-cell">
                      {{ $row['shipper_code'] }}
                      <input type="hidden" value="{{ $row->shipper_code }}" name="shipper_code">
                    </td>
                    <td class="align-top d-none d-sm-table-cell">
                      {{ $row['destination_code'] }}
                      <input type="hidden" value="{{ $row->destination_code }}" name="destination_code">
                    </td>
                    <td class="align-middle">
                      <select name="driver_name" class="custom-select custom-select-sm" id="driver_name">
                        @if ($row->driver_name == '')
                          <option selected="true" disabled="disabled">Please Select</option>
                          @foreach ($driver as $drivername)
                            <option value="{{ $drivername->username }}">{{ $drivername->username }}</option>
                          @endforeach
                        @else
                          @foreach ($driver as $drivername)
                            <option value="{{ $drivername->username }}" {{ ($row->driver_name == $drivername->username) ? 'selected' : '' }}>{{ $drivername->username }}</option>
                          @endforeach
                        @endif

                      </select>
                    </td>
                    <td class="align-middle">
                      <button type="submit" class="button-circle"><i class="fas fa-check-circle"></i></i></button>
                    </td>
                  </form>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No Record</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $hqlist->appends(['search' => $search])->links() }}
    </div>
  </div>
@endsection
