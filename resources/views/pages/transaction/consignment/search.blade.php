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
Transaction
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-box-open"></i> <strong>Existing Consignment Note Update</strong></p>
        </div>
        @if(\Session::has('error'))
          <div role="alert" class="col-12 px-2 mt-3 alert alert-danger alert-dismissible fade show">
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
        <div class="col-12 col-xl-10 px-0 pb-4">
          <form class="needs-validation" action="/consignment/{{ $search->id }}" method="post">
            @method('PATCH')
            @csrf
            <div class="form-group">
              <label for="cn_no"><sup>*</sup> Consignment Note</label>
              <input type="text" readonly class="form-control col-md-5" id="cn_no" value="{{ $search->cn_no }}" name="cn_no" required readonly>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="shipper_code"><sup>*</sup> Shipper Code</label>
                <input type="text" class="form-control" id="shipper_code" value="{{ $search->shipper_code }}" name="shipper_code">
                <div class="invalid-feedback">Please enter shipper code</div>
              </div>
              <div class="col-md-8 mb-3">
                <label for="shipper_name">Shipper Name</label>
                <input type="text" readonly class="form-control" id="shipper_name" value="{{ $search->shipper_name }}" name="shipper_name">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="destination_code"><sup>*</sup> Destination Code</label>
                <input type="text" class="form-control" id="destination_code" value="{{ $search->destination_code }}" name="destination_code">
                <div class="invalid-feedback">Please enter destination code</div>
              </div>
              <div class="col-md-8 mb-3">
                <label for="destination_name">Destination Name</label>
                <input type="text" readonly class="form-control" id="destination_name" value="{{ $destination_name }}" name="destination_name">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="receiver_name"><sup>*</sup> Receiver Name</label>
                <input type="text" class="form-control" id="receiver_name" placeholder="Enter receiver name" value="{{ $search->receiver_name }}" name="receiver_name" required>
                <div class="invalid-feedback">Please enter receiver name</div>
              </div>
              <div class="col-md-6 col-xl-5 mb-3">
                <label> P.O.D</label>
                <div class="input-group date" id="pod" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target="#pod" placeholder="Date" name="pod">
                  <div class="input-group-append" data-target="#pod" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-5 mb-3">
                <label for="measure"><strong>Measure</strong></label>
                <select id="measure" class="form-control">
                  <option value="CTN" @if($search->measure == 'CTN') selected @endif >[CTN] Carton</option>
                  <option value="M3" @if($search->measure == 'M3') selected @endif >[M3] M3</option>
                  <option value="PKT" @if($search->measure == 'PKT') selected @endif >[PLT] Packet</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="carton_size">Carton</label>
                <input class="form-control borderFlatRight" id="carton_size" value="{{ $search->carton_size }}" name="carton_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="carton_rate">Carton Rate</label>
                <input readonly class="form-control borderFlatLeft" id="carton_rate" value="@if($search->carton_rate == '') 0.00 @else {{$search->carton_rate}} @endif" name="carton_rate">
              </div>
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="p_size">P Size</label>
                <input class="form-control borderFlatRight" id="p_size" value="{{ $search->p_size }}" name="p_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="p_rate">P Rate</label>
                <input readonly class="form-control borderFlatLeft" id="p_rate" value="@if($search->p_rate == '') 0.00 @else {{$search->p_rate}} @endif" name="p_rate">
              </div>
            </div>
            <div class="form-row">
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="s_size">S Size</label>
                <input class="form-control borderFlatRight" id="s_size" value="{{ $search->s_size }}" name="s_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="s_rate">S Rate</label>
                <input readonly class="form-control borderFlatLeft" id="s_rate" value="@if($search->s_rate == '') 0.00 @else {{$search->s_rate}} @endif" name="s_rate">
              </div>
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="m_size">M Size</label>
                <input class="form-control borderFlatRight" id="m_size" value="{{ $search->m_size }}" name="m_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="m_rate">M Rate</label>
                <input readonly class="form-control borderFlatLeft" id="m_rate" value="@if($search->m_rate == '') 0.00 @else {{$search->m_rate}} @endif" name="m_rate">
              </div>
            </div>
            <div class="form-row">
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="b_size">B Size</label>
                <input class="form-control borderFlatRight" id="b_size" value="{{ $search->b_size }}" name="b_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="b_rate">B Rate</label>
                <input readonly class="form-control borderFlatLeft" id="b_rate" value="@if($search->b_rate == '') 0.00 @else {{$search->b_rate}} @endif" name="b_rate">
              </div>
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="xl_size">XL Size</label>
                <input class="form-control borderFlatRight" id="xl_size" value="{{ $search->xl_size }}" name="xl_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="xl_rate">XL Rate</label>
                <input readonly class="form-control borderFlatLeft" id="xl_rate" value="@if($search->xl_rate == '') 0.00 @else {{$search->xl_rate}} @endif" name="xl_rate">
              </div>
            </div>
            <div class="form-row">
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="pkt_size">PLT Size</label>
                <input class="form-control borderFlatRight" id="pkt_size" value="{{ $search->pkt_size }}" name="pkt_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="pkt_rate">PLT Rate</label>
                <input readonly class="form-control borderFlatLeft" id="pkt_rate" value="@if($search->pkt_rate == '' || $search->pkt_rate == ' ' ) 0.00 @else {{$search->pkt_rate}} @endif" name="pkt_rate">
              </div>
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="m3_size">M3 Size</label>
                <input class="form-control borderFlatRight" id="m3_size" value="{{ $search->m3_size }}" name="m3_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="m3_rate">M3 Rate</label>
                <input readonly class="form-control borderFlatLeft" id="m3_rate" value="@if($search->m3_rate == '') 0.00 @else {{$search->m3_rate}} @endif" name="m3_rate">
              </div>
            </div>
            <div class="form-group mb-3">
              <label for="other_amount">Other Amount</label>
              <input class="form-control col-12 col-md-4" id="other_amount" value="@if($search->other_amount == '') 0.00 @else {{$search->other_amount}} @endif" name="other_amount">
            </div>
            <div class="form-group mb-3">
              <label for="weight">Weight</label>
              <input class="form-control col-12 col-md-4" id="weight" value="@if($search->weight == '') 0 @else {{$search->weight}} @endif" name="weight">
            </div>
            <div class="form-group mb-3">
              <label for="remarks">Remarks</label>
              <textarea class="form-control" id="remarks" placeholder="Enter note" name="remarks" rows="3">{{ $search->remarks }}</textarea>
            </div>
            <div class="form-group col-md-4 px-0">
              <label for="sub_amount">Sub Amount</label>
              <input type="number" readonly="" class="form-control" id="sub_amount" value="{{ $search->sub_amount }}" name="sub_amount">
            </div>
            <div class="form-group col-md-4 px-0">
              <label for="gst_amount">SST Amount</label>
              <input type="number" readonly="" class="form-control" id="gst_amount" value="{{ $search->gst_amount }}" name="gst_amount">
            </div>
            <div class="form-group col-md-4 px-0">
              <label for="total_amount"><strong>Total Amount</strong></label>
              <input type="number" readonly class="form-control" id="total_amount" value="{{ $search->total_amount }}" name="total_amount">
            </div>
            <button type="submit" class="btn btn-primary col-4 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>

            <a onclick="deleteData({{ $search->id }})" class="btn btn-success col-4 col-md-2 mt-4" style="color: white;"><i class="fa fa-trash"></i> Delete</a>
            <a class="btn btn-secondary col-4 col-md-2 mt-4" href="{{ route('consignment.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">

function getNum(val) {
  if (isNaN(val)){
    return '0.00';
  }
  else {
    return parseFloat(val).toFixed(2);
  }
}

function calculate(){
  var subtotal;
  var sst_value = {{ $sst }}/100;
  var total;

  var carton = document.getElementById('carton_size').value*document.getElementById('carton_rate').value;
  var p = document.getElementById('p_size').value*document.getElementById('p_rate').value;
  var s = document.getElementById('s_size').value*document.getElementById('s_rate').value;
  var m = document.getElementById('m_size').value*document.getElementById('m_rate').value;
  var b = document.getElementById('b_size').value*document.getElementById('b_rate').value;
  var xl = document.getElementById('xl_size').value*document.getElementById('xl_rate').value;
  var pkt = document.getElementById('pkt_size').value*document.getElementById('pkt_rate').value;
  var m3 = document.getElementById('m3_size').value*document.getElementById('m3_rate').value;
  var other = 1*document.getElementById('other_amount').value;

  subtotal = getNum(carton + p + s + m + b + xl + pkt + m3 + other);
  document.getElementById('sub_amount').value=subtotal;

  sst = getNum(document.getElementById('sub_amount').value*sst_value);
  document.getElementById('gst_amount').value=sst;

  total = getNum(parseFloat(document.getElementById('sub_amount').value)+parseFloat(document.getElementById('gst_amount').value));
  document.getElementById('total_amount').value=total;
}

$(document).ready(function() {
  $("#carton_size, #p_size, #s_size, #m_size, #b_size, #xl_size, #pkt_size, #m3_size").each(function(){
    $(this).keyup(function(){
      calculate();
    });
  });
});

function checkotheramount(){
  if($('#other_amount').val() == '' || $('#other_amount').val() == '0' || $('#other_amount').val() == '0.00'){
    $('#p_size').attr('readonly', false);
    $('#s_size').attr('readonly', false);
    $('#m_size').attr('readonly', false);
    $('#b_size').attr('readonly', false);
    $('#xl_size').attr('readonly', false);
    $('#pkt_size').attr('readonly', false);
    $('#carton_size').attr('readonly', false);
    $('#m3_size').attr('readonly', false);

    calculate();
  } else{
    $('#p_size').attr('readonly', true);
    $('#s_size').attr('readonly', true);
    $('#m_size').attr('readonly', true);
    $('#b_size').attr('readonly', true);
    $('#xl_size').attr('readonly', true);
    $('#pkt_size').attr('readonly', true);
    $('#carton_size').attr('readonly', true);
    $('#m3_size').attr('readonly', true);
    document.getElementById('p_size').value='0';
    document.getElementById('s_size').value='0';
    document.getElementById('m_size').value='0';
    document.getElementById('b_size').value='0';
    document.getElementById('xl_size').value='0';
    document.getElementById('pkt_size').value='0';
    document.getElementById('carton_size').value='0';
    document.getElementById('m3_size').value='0';

    calculate();
  }
}

$("#other_amount").keyup(function(){
  checkotheramount()
});

$(function () {
  $('#pod').datetimepicker({
      defaultDate: "{{ $search->pod }}",
      format: 'DD/MM/YYYY'
  });

  $('#date').datetimepicker({
      defaultDate: "{{ $search->cn_date }}",
      format: 'DD/MM/YYYY'
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
                  url: "{{ url('consignment')}}" + '/' + id,
                  data: {'_token' : CSRF_TOKEN, '_method' : 'DELETE'},
                  dataType: 'JSON',
                  success: function (results) {
                      if (results.success === true) {
                          Swal.fire(
                            "Done!",results.message,"success"
                          ).then(function() {
                            window.location = "{{ url('consignment')}}";
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
