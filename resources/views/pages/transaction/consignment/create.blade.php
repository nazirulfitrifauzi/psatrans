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
          <p><i class="fas fa-box-open"></i> <strong>New Consignment Note</strong></p>
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
        <div class="col-12 col-xl-10 px-0 py-4">
          <form class="needs-validation" method="POST" action="{{ route('consignment.store') }}">
            @csrf
            <div class="form-group px-0 col-md-6">
              <label for="validationConsignmentNote"><sup>*</sup> Consignment Note</label>
              <input type="text" class="form-control" id="cn_no" placeholder="Enter consignment note" name="cn_no" onkeyup="this.value = this.value.toUpperCase();" required>
              <div class="invalid-feedback">Please enter consignment note</div>
            </div>
            <div class="form-row">
              <div class="col-md-6 col-xl-6 mb-3">
                <label for="shipperCode"><sup>*</sup> Shipper Code</label>
                <div class="form-inline">
                  <input id="shipper_code" class="form-control col-8 borderFlatRight" type="search" placeholder="Shipper code" name="shipper_code" onkeyup="this.value = this.value.toUpperCase();" required>
                  <div class="input-group-append">
                    <button toggle="#shipper_code" type="submit" class="input-group-text btn btn-info" id="searchButton"> Search </button>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-xl-6 mb-3">
                <label for="shipperName">Shipper Name</label>
                <input type="text" readonly class="form-control" id="shipper_name" name="shipper_name" value="">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-5 col-xl-3 mb-3">
                <label for="destinationCode"><sup>*</sup> Destination Code</label>
                <select required  name="destination_code" id="destination_code" class="form-control">
                  <option value="">Please Select</option>
                </select>
                <div class="invalid-feedback">Please enter destination code</div>
              </div>

              <div class="col-md-7 col-xl-9 mb-3">
                <label for="destination_name">Destination Name</label>
                <input type="text" readonly class="form-control" id="destination_name" name="destination_name" value="">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-7 col-xl-6 mb-3">
                <label for="receiverName"><sup>*</sup> Receiver Name</label>
                <input type="text" class="form-control" id="receiver_name" placeholder="Enter receiver name" name="receiver_name" required>
                <div class="invalid-feedback">Please enter receiver name</div>
              </div>
              <div class="col-md-5 col-xl-4 mb-3">
                <label> P.O.D</label>
                <div class="input-group date" id="pod" data-target-input="nearest">
                  <input name="pod" type="text" class="form-control datetimepicker-input" data-target="#pod" placeholder="Date">
                  <div class="input-group-append" data-target="#pod" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group col-md-5 px-0">
              <label for="measure"><strong>Measure</strong></label>
              <select name="measure" class="form-control" id="measure" onChange="selectmeasure(this)">
                <option value="">Please Select</option>
                <option value="CTN">[CTN] Carton</option>
                <option value="M3">[M3] M3</option>
                <option value="PKT">[PLT] Packet</option>
              </select>
            </div>
            <div class="form-row">
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="carton_size">Carton</label>
                <input class="form-control borderFlatRight" id="carton_size" name="carton_size" value="0">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="carton_rate">Carton Rate</label>
                <input readonly class="form-control borderFlatLeft" id="carton_rate" name="carton_rate" value="">
              </div>
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="p_size">P Size</label>
                <input class="form-control borderFlatRight" id="p_size" name="p_size" value="0">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="p_rate">P Rate</label>
                <input readonly class="form-control borderFlatLeft calc_charge" id="p_rate" value="" name="p_rate">
              </div>
            </div>
            <div class="form-row">
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="s_size">S Size</label>
                <input class="form-control borderFlatRight" id="s_size" value="0" name="s_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="s_rate">S Rate</label>
                <input readonly class="form-control borderFlatLeft" id="s_rate" value="" name="s_rate">
              </div>
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="m_size">M Size</label>
                <input class="form-control borderFlatRight" id="m_size" name="m_size" value="0">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="m_rate">M Rate</label>
                <input readonly class="form-control borderFlatLeft" id="m_rate" value="" name="m_rate">
              </div>
            </div>
            <div class="form-row">
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="b_size">B Size</label>
                <input class="form-control borderFlatRight" id="b_size" value="0" name="b_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="b_rate">B Rate</label>
                <input readonly class="form-control borderFlatLeft" id="b_rate" value="" name="b_rate">
              </div>
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="xl_size">XL Size</label>
                <input class="form-control borderFlatRight" id="xl_size" value="0" name="xl_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="xl_rate">XL Rate</label>
                <input readonly class="form-control borderFlatLeft" id="xl_rate" value="" name="xl_rate">
              </div>
            </div>
            <div class="form-row">
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="pkt_size">PLT Size</label>
                <input class="form-control borderFlatRight" id="pkt_size" value="0" name="pkt_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="pkt_rate">PLT Rate</label>
                <input readonly class="form-control borderFlatLeft" id="pkt_rate" value="" name="pkt_rate">
              </div>
              <div class="col-6 col-md-2 pr-0 mb-3">
                <label for="m3_size">M3 Size</label>
                <input class="form-control borderFlatRight" id="m3_size" value="0" name="m3_size">
              </div>
              <div class="col-6 col-md-3 pl-0 mb-3">
                <label for="m3_rate">M3 Rate</label>
                <input readonly class="form-control borderFlatLeft" id="m3_rate" value="" name="m3_rate">
              </div>
            </div>
            <div class="form-group">
              <label for="other_amount">Other Amount</label>
              <input class="form-control col-12 col-md-4" id="other_amount" value="0.00" name="other_amount">
            </div>
            <div class="form-group">
              <label for="weight">Weight (kg)</label>
              <input class="form-control col-12 col-md-4" id="weight" value="" name="weight">
            </div>
            <div class="form-group">
              <label for="remarks">Remarks</label>
              <textarea class="form-control" id="remarks" placeholder="Enter note" rows="3" name="remarks"></textarea>
            </div>
            <div class="form-group col-md-4 px-0">
              <label for="sub_amount">Sub Amount</label>
              <input readonly="" class="form-control" id="sub_amount" value="0.00" name="sub_amount">
            </div>
            <div class="form-group col-md-4 px-0">
              <label for="gst_amount">SST Amount</label>
              <input readonly="" class="form-control" id="gst_amount" value="0.00" name="gst_amount">
            </div>
            <div class="form-row col-md-4 px-0">
              <label for="total_amount"><strong>Total Amount</strong></label>
              <input readonly class="form-control" id="total_amount" value="0.00" name="total_amount">
            </div>
            <button type="submit" class="btn btn-primary col-5 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
            <a class="btn btn-success col-5 col-md-2 mt-4" href="{{ route('consignment.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script>

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

    $("#searchButton").click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "{{ route('ajaxdata.getchargesdestination') }}?shipper_code=" + $("#shipper_code").val(),
        method: 'GET',
        success: function(data) {
            $('#destination_code').html(data.html);
            $('#shipper_name').val(data.shipper_name);
        }
      });
    });

    //hide rate before user select measure option
    $(".cartonrate").hide();
    $(".prate").hide();
    $(".srate").hide();
    $(".mrate").hide();
    $(".brate").hide();
    $(".xlrate").hide();
    $(".pktrate").hide();
    $(".m3rate").hide();

    $("#destination_code").change(function(){
        $.ajax({
            url: "{{ route('ajaxdata.getchargesdata') }}?destination_code=" + $("#destination_code").val() + "&shipper_code=" + $("#shipper_code").val(),
            method: 'GET',
            success: function(data) {
              $('#destination_name').val(data.html);
              $('#p_rate').val(data.prate);
              $('#s_rate').val(data.srate);
              $('#m_rate').val(data.mrate);
              $('#b_rate').val(data.brate);
              $('#xl_rate').val(data.xlrate);
              $('#pkt_rate').val(data.pktrate);
              $('#carton_rate').val(data.cartonrate);
              $('#m3_rate').val(data.m3rate);
            }
        });
    });

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
        defaultDate: moment(new Date()),
        format: 'DD/MM/YYYY'
    });
  });

</script>
@endsection
