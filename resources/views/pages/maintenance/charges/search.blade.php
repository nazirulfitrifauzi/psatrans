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
Charges Setup
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 2 Charges Rate per shipper code-->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
          <p><i class="fas fa-tools"></i> <strong>Charges Rate</strong></p>
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
        <div class="col-12 px-2 mt-4">
          <p>
            <strong>Shipper Code</strong>: {{ $search->shipper_code }}
            <br>
            <strong>Shipper Name</strong>: {{ $search->shipper_name }}
            <input id="shipper_code" type="hidden" name="shipper_code" value="{{ $search->shipper_code }}">
            <input id="shipper_name" type="hidden" name="shipper_name" value="{{ $search->shipper_name }}">
          </p>
        </div>
        <form class="" action="/charges/update-charges" method="post">
          @csrf
          <table class="table-sm cellSeparate mt-4">
            <thead>
              <tr>
                <th class="cellSeparateHeader align-top" scope="col" width="8%">Destination</th>
                <th class="cellSeparateHeader align-top" scope="col" width="11%">Carton</th>
                <th class="cellSeparateHeader align-top" scope="col" width="11%">Size P</th>
                <th class="cellSeparateHeader align-top" scope="col" width="11%">Size S</th>
                <th class="cellSeparateHeader align-top" scope="col" width="11%">Size M</th>
                <th class="cellSeparateHeader align-top" scope="col" width="11%">Size B</th>
                <th class="cellSeparateHeader align-top" scope="col" width="11%">Size XL</th>
                <th class="cellSeparateHeader align-top" scope="col" width="11%">PLT</th>
                <th class="cellSeparateHeader align-top" scope="col" width="11%">M3</th>
              </tr>
            </thead>
            <tbody>
              <input name="shipper_code" id="shipper_code" type="hidden" class="form-control" value="{{ $search->shipper_code }}">
              @foreach($chargesx as $row)
                <tr>
                  <td>{{ $row->DESTINATION_CODE }}</td>

                  <input name="charges[{{ $loop->index }}][ID]" id="ID" type="hidden" class="form-control" value="{{ $row->ID }}">
                  <input name="charges[{{ $loop->index }}][SHIPPER_CODE]" id="SHIPPER_CODE" type="hidden" class="form-control" value="{{ $row->SHIPPER_CODE }}">
                  <input name="charges[{{ $loop->index }}][DESTINATION_CODE]" id="DESTINATION_CODE" type="hidden" class="form-control" value="{{ $row->DESTINATION_CODE }}">

                  <td>
                    <input name="charges[{{ $loop->index }}][CARTON_RATE]" id="CARTON_RATE" type="text" class="form-control" value="{{ $row->CARTON_RATE }}">
                  </td>

                  <td>
                    <input name="charges[{{ $loop->index }}][P_RATE]" id="P_RATE" type="text" class="form-control" value="{{ $row->P_RATE }}">
                  </td>

                  <td>
                    <input name="charges[{{ $loop->index }}][S_RATE]" id="S_RATE" type="text" class="form-control" value="{{ $row->S_RATE }}">
                  </td>

                  <td>
                    <input name="charges[{{ $loop->index }}][M_RATE]" id="M_RATE" type="text" class="form-control" value="{{ $row->M_RATE }}">
                  </td>

                  <td>
                    <input name="charges[{{ $loop->index }}][B_RATE]" id="B_RATE" type="text" class="form-control" value="{{ $row->B_RATE }}">
                  </td>

                  <td>
                    <input name="charges[{{ $loop->index }}][XL_RATE]" id="XL_RATE" type="text" class="form-control" value="{{ $row->XL_RATE }}">
                  </td>

                  <td>
                    <input name="charges[{{ $loop->index }}][PKT_RATE]" id="PKT_RATE" type="text" class="form-control" value="{{ $row->PKT_RATE }}">
                  </td>

                  <td>
                    <input name="charges[{{ $loop->index }}][M3_RATE]" id="M3_RATE" type="text" class="form-control" value="{{ $row->M3_RATE }}">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="col-12 px-0 py-3">
            <button type="submit" class="btn btn-primary col-4 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
            <a class="btn btn-success col-4 col-md-2 mt-4" href="{{ route('charges.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
