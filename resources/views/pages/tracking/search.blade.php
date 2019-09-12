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
Tracking
@endsection

@section('content')
<div class="row">
  @guest
    <div class="col-12 col-lg-11 col-xl-12 px-2">
  @else
    <div class="col-12 col-lg-8 col-xl-9 px-2">
  @endguest
    <!-- Row 1 Consignment Tracking -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-truck-moving"></i> <strong>Consignment Tracking</strong></p>
        </div>
        <div class="col-12 col-xl-6 px-0 py-4">
          <form class="needs-validation" method="POST" action="{{ route('tracking.search') }}" class="row">
            @csrf
            <div class="form-inline">
              <input id="cn_no" class="form-control col-8 col-xl-6 borderFlatRight" type="search" placeholder="Consignment note" name="cn_no" value="{{ isset($cn_no) ? $cn_no : '' }}" required>
              <button class="btn btn-light my-2 my-sm-0 borderFlatLeft" type="submit">Track Consignment</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Row 2 Consignment Delivery Status -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-truck-moving"></i> <strong>Delivery Status</strong></p>
        </div>
        <!-- Consignment Delivery Table -->
        <div class="col-xl-8 my-4">
          <div class="row">
            <div class="col-md-4 py-2 font-weight-bold">Date/Time</div>
            <div class="col-md-8 py-2 font-weight-bold">Status</div>
          </div>
          <div class="row border-top">

            @if($region == 'HQ')

              <!-- RECEIVED BLOCK -->
              @if(in_array('RECEIVED',$status))
                <div class="col-md-4 py-2">{{ $tracking[0]->datetime->format('d M Y, h:i a') }}</div>
                <div class="col-md-8 py-2">Received Order</div>
              @endif

              <!-- HQ BLOCK -->
              @if(in_array('HQ',$status))
                <div class="col-md-4 py-2">{{ $tracking[1]->datetime->format('d M Y, h:i a') }}</div>
                <div class="col-md-8 py-2">Consignment in HQ (KL Hub)</div>
              @endif

              <!-- ARRANGING & OFD BLOCK -->
              @if(in_array('ARRANGING',$status))
                @if(now() > $tracking[2]->datetime)
                  <div class="col-md-4 py-2">{{ $tracking[2]->datetime->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment arranging for delivery</div>
                @endif

                @if(now() > $tracking[2]->datetime->add('hour',1))
                  <div class="col-md-4 py-2">{{ $tracking[2]->datetime->add('hour',1)->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment out for delivery to customer</div>
                @endif <!--  end arranging -->

              @elseif(!in_array('ARRANGING',$status))

                @if(now() > $tracking[1]->datetime->add('hour',12))
                  <div class="col-md-4 py-2">{{ $tracking[1]->datetime->add('hour',12)->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment arranging for delivery</div>
                @endif

                @if(now() > $tracking[1]->datetime->add('hour',13))
                  <div class="col-md-4 py-2">{{ $tracking[1]->datetime->add('hour',13)->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment out for delivery to customer</div>
                @endif
              @endif <!-- end !arranging -->

              <!-- ATTEMPTING BLOCK -->
              @if(in_array('ATTEMPTING',$status) && now() > $tracking[3]->datetime)
                <div class="col-md-4 py-2">{{ $tracking[3]->datetime->format('d M Y, h:i a') }}</div>
                <div class="col-md-8 py-2">Consignment attempting to deliver</div>
              @elseif(!in_array('ATTEMPTING',$status))

                @if(in_array('ARRANGING',$status))
                  @if(now() > $tracking[2]->datetime->add('hour',10))
                    <div class="col-md-4 py-2">{{ $tracking[2]->datetime->add('hour',10)->format('d M Y, h:i a') }}</div>
                    <div class="col-md-8 py-2">Consignment attempting to deliver</div>
                  @endif

                @else(!in_array('ARRANGING',$status))

                  @if(now() > $tracking[1]->datetime->add('hour',23))
                    <div class="col-md-4 py-2">{{ $tracking[1]->datetime->add('hour',23)->format('d M Y, h:i a') }}</div>
                    <div class="col-md-8 py-2">Consignment attempting to deliver</div>
                  @endif
                @endif

              @endif

              <!-- DELIVERED BLOCK -->
              @if(in_array('DELIVERED',$status))
                <div class="col-md-4 py-2">{{ $tracking[4]->datetime->format('d M Y, h:i a') }}</div>
                <div class="col-md-8 py-2">Consignment delivered to [{{ $receiver_name }}]</div>
              @endif

            @else <!-- SELAIN REGION HQ -->

              <!-- RECEIVED BLOCK -->
              @if(in_array('RECEIVED',$status))
                <div class="col-md-4 py-2">{{ $tracking[0]->datetime->format('d M Y, h:i a') }}</div>
                <div class="col-md-8 py-2">Received order</div>
              @endif

              <!-- HQ BLOCK -->
              @if(in_array('HQ',$status))
                <div class="col-md-4 py-2">{{ $tracking[1]->datetime->format('d M Y, h:i a') }}</div>
                <div class="col-md-8 py-2">Consignment in HQ (KL Hub)</div>
              @endif

              <!-- TRANSIT BLOCK -->
              @if($region == 'NORTH')

                @if(in_array('TRANSIT PENANG',$status))
                  @if(now() > $tracking[2]->datetime)
                    <div class="col-md-4 py-2">{{ $tracking[2]->datetime->format('d M Y, h:i a') }}</div>
                    <div class="col-md-8 py-2">Consignment transit to Penang hub</div>
                  @endif

                  @if(now() > $tracking[2]->datetime->add('hour',8))
                    <div class="col-md-4 py-2">{{ $tracking[2]->datetime->add('hour',8)->format('d M Y, h:i a') }}</div>
                    <div class="col-md-8 py-2">Consignment reach Penang hub</div>
                  @endif
                @endif

              @elseif($region == 'SOUTH')

                @if(in_array('TRANSIT JB',$status))
                  @if(now() > $tracking[2]->datetime)
                    <div class="col-md-4 py-2">{{ $tracking[2]->datetime->format('d M Y, h:i a') }}</div>
                    <div class="col-md-8 py-2">Consignment transit to Johor Bahru hub</div>
                  @endif

                  @if(now() > $tracking[2]->datetime->add('hour',8))
                    <div class="col-md-4 py-2">{{ $tracking[2]->datetime->add('hour',8)->format('d M Y, h:i a') }}</div>
                    <div class="col-md-8 py-2">Consignment reach Johor Bahru hub</div>
                  @endif
                @endif

              @endif

              <!-- ARRANGING & OFD BLOCK -->
              @if(in_array('ARRANGING',$status))

                @if($region == 'NORTH' && now() < $tracking[2]->datetime->add('hour',8))
                  <div class="col-md-4 py-2">{{ $tracking[3]->datetime->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment reach Penang hub</div>
                @elseif($region == 'SOUTH' && now() < $tracking[2]->datetime->add('hour',8))
                  <div class="col-md-4 py-2">{{ $tracking[3]->datetime->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment reach Johor Bahru hub</div>
                @endif

                @if(now() > $tracking[3]->datetime)
                  <div class="col-md-4 py-2">{{ $tracking[3]->datetime->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment arranging for delivery</div>
                @endif

                @if(now() > $tracking[3]->datetime->add('hour',9))
                  <div class="col-md-4 py-2">{{ $tracking[3]->datetime->add('hour',9)->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment out for delivery to customer</div>
                @endif

              @elseif(!in_array('ARRANGING',$status))

                @if(now() > $tracking[2]->datetime->add('hour',20))
                  <div class="col-md-4 py-2">{{ $tracking[2]->datetime->add('hour',20)->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment arranging for delivery</div>
                @endif

                @if(now() > $tracking[2]->datetime->add('hour',21))
                  <div class="col-md-4 py-2">{{ $tracking[2]->datetime->add('hour',21)->format('d M Y, h:i a') }}</div>
                  <div class="col-md-8 py-2">Consignment out for delivery to customer</div>
                @endif
              @endif <!-- end !arranging -->

              <!-- ATTEMPTING BLOCK -->
              @if(in_array('ATTEMPTING',$status) && now() > $tracking[4]->datetime)
                <div class="col-md-4 py-2">{{ $tracking[4]->datetime->format('d M Y, h:i a') }}</div>
                <div class="col-md-8 py-2">Consignment attempting to deliver</div>
              @elseif(!in_array('ATTEMPTING',$status))

                @if($region == 'NORTH')

                  @if(in_array('TRANSIT PENANG',$status))
                    @if(now() > $tracking[2]->datetime->add('hour',31))
                      <div class="col-md-4 py-2">{{ $tracking[2]->datetime->add('hour',31)->format('d M Y, h:i a') }}</div>
                      <div class="col-md-8 py-2">Consignment attempting to deliver</div>
                    @endif
                  @endif

                @elseif($region == 'SOUTH')

                  @if(in_array('TRANSIT JB',$status))
                    @if(now() > $tracking[2]->datetime->add('hour',31))
                      <div class="col-md-4 py-2">{{ $tracking[2]->datetime->add('hour',31)->format('d M Y, h:i a') }}</div>
                      <div class="col-md-8 py-2">Consignment attempting to deliver</div>
                    @endif
                  @endif

                @endif

              @endif

              <!-- DELIVERED BLOCK -->
              @if(in_array('DELIVERED',$status))
                <div class="col-md-4 py-2">{{ $tracking[4]->datetime->format('d M Y, h:i a') }}</div>
                <div class="col-md-8 py-2">Consignment delivered to [{{ $receiver_name }}]</div>
              @endif

            @endif

          </div>
        </div>
        <!-- END Consignment Delivery Table -->
      </div>
    </div>
  </div>
@endsection
