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
Shipper Setup
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Existing Shipper Code Form -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-tools"></i> <strong>Existing Shipper Account Update</strong></p>
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
        <br>
        <div class="col-12 col-xl-11 px-0 pb-4">
          <form class="needs-validation" action="{{ route('shipping.update',$search->id) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="companyCode"><sup>*</sup> Shipper Code</label>
                <input type="text" class="form-control" id="companyCode" placeholder="Enter code" value="{{ $search->shipper_code }}" name="shipper_code" required>
                <div class="invalid-feedback">Please enter shipper code</div>
              </div>
              <div class="col-md-8 mb-3">
                <label for="companyName"><sup>*</sup> Shipper Name</label>
                <input type="text" class="form-control" id="companyName" placeholder="Enter shipper name" value="{{ $search->shipper_name }}" name="shipper_name" required>
                <div class="invalid-feedback">Please enter shipper name</div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="register"><sup>*</sup> Contact Name</label>
                <input type="text" class="form-control" id="register" placeholder="Enter contact name" value="{{ $search->contact }}" name="contact" required>
                <div class="invalid-feedback">Please enter contact person name id</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="SST">SST ID</label>
                <input type="text" class="form-control" id="SST" placeholder="Enter ID" value="{{ $search->gst_id }}" name="gst_id">
              </div>
            </div>
            <div class="form-group">
              <label for="address"><sup>*</sup> Address</label>
              <input type="text" class="form-control" id="address" placeholder="Enter address" value="{{ $search->address1 }}" name="address1" required>
              <div class="invalid-feedback">Please enter company address</div>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="city"><sup>*</sup> City</label>
                <input type="text" class="form-control" id="city" placeholder="Enter city" value="{{ $search->city }}" name="city" required>
                <div class="invalid-feedback">Please enter city</div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="state"><sup>*</sup> State</label>
                <select required id="state" class="form-control" name="city">
                  <option selected="true" disabled="disabled">Select State</option>
                  <option value="johor" @if($search->state == 'johor') selected @endif>Johor</option>
                  <option value="kedah" @if($search->state == 'kedah') selected @endif>Kedah</option>
                  <option value="kelantan" @if($search->state == 'kelantan') selected @endif>Kelantan</option>
                  <option value="kl" @if($search->state == 'kl') selected @endif>Kuala Lumpur</option>
                  <option value="labuan" @if($search->state == 'labuan') selected @endif>Labuan</option>
                  <option value="malacca" @if($search->state == 'malacca') selected @endif>Malacca</option>
                  <option value="n9" @if($search->state == 'n9') selected @endif>Negeri Sembilan</option>
                  <option value="pahang" @if($search->state == 'pahang') selected @endif>Pahang</option>
                  <option value="penang" @if($search->state == 'penang') selected @endif>Penang</option>
                  <option value="perak" @if($search->state == 'perak') selected @endif>Perak</option>
                  <option value="perlis" @if($search->state == 'perlis') selected @endif>Perlis</option>
                  <option value="putrajaya" @if($search->state == 'putrajaya') selected @endif>Putrajaya</option>
                  <option value="sabah" @if($search->state == 'sabah') selected @endif>Sabah</option>
                  <option value="sarawak" @if($search->state == 'sarawak') selected @endif>Sarawak</option>
                  <option value="selangor" @if($search->state == 'selangor') selected @endif>Selangor</option>
                  <option value="terengganu" @if($search->state == 'terengganu') selected @endif>Terengganu</option>
                </select>
                <div class="invalid-feedback">Please select state</div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="country"><sup>*</sup> Country</label>
                <input type="text" class="form-control" id="postcode" placeholder="Enter country" value="{{ $search->country }}" name="country" required>
                <div class="invalid-feedback">Please enter country</div>
              </div>
              <div class="col-md-2 mb-3">
                <label for="postcode"><sup>*</sup> Postcode</label>
                <input type="number" class="form-control" id="postcode" placeholder="Postcode" value="{{ $search->postcode }}" name="postcode" required>
                <div class="invalid-feedback">Please enter postcode</div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="tel"><sup>*</sup> Telephone</label>
                <input type="text" class="form-control" id="tel" placeholder="Enter number" value="{{ $search->telephone }}" name="telephone" required>
                <div class="invalid-feedback">Please enter telephone number</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" placeholder="Enter number" value="{{ $search->mobile }}" name="mobile">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="fax">Fax</label>
                <input type="text" class="form-control" id="fax" placeholder="Enter number" value="{{ $search->fax }}" name="fax">
              </div>
              <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" value="{{ $search->email }}" name="email" required>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="credit">Credit Limit</label>
                <input type="number" class="form-control" id="credit" placeholder="Enter credit limit" value="{{ $search->credit_limit }}" name="credit_limit">
              </div>
              <div class="col-md-4 mb-3">
                <label for="invoiceTerms">Invoice Terms (Day)</label>
                <input type="number" class="form-control" id="invoiceTerms" placeholder="Enter day limit" value="{{ $search->term_day }}" name="term_day">
              </div>
              <div class="col-md-4 mb-3">
                <label for="invoiceFormat"><sup>*</sup> Invoice Format</label>
                <select required class="custom-select custom-select-sm" name="invoice_format">
                  <option selected="true" disabled="disabled">Select Invoice</option>
                  <option value="C" @if($search->invoice_format == 'C') selected @endif >[CTN] Carton</option>
                  <option value="P" @if($search->invoice_format == 'P') selected @endif>[PLT] Packet</option>
                  <option value="M3" @if($search->invoice_format == 'M3') selected @endif>[M3] M3</option>
                </select>
                <div class="invalid-feedback">Please select invoice format</div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary col-3 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
            <a onclick="deleteData({{ $search->id }})" class="btn btn-success col-4 col-md-2 mt-4" style="color: white;"><i class="fa fa-trash"></i> Delete</a>
            <a class="btn btn-secondary col-4 col-md-2 mt-4" href="{{ route('shipping.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </form>
        </div>
      </div>
    </div>
    <!-- Row 2 Shipper Account Details -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
          <p><i class="fas fa-tools"></i> <strong>Shipper Account Balance</strong></p>
        </div>
        <br>
        <div class="col-12 col-xl-11 px-0 pb-4">
            <div class="form-row">
              <label for="acc_bal" class="col-md-3 col-form-label text-md-right">Account Balance</label>

              <div class="col-md-5 input-group">
                <input id="acc_bal" type="text" class="form-control @error('acc_bal') is-invalid @enderror" value="RM {{ $shipper_acc->acc_bal }}" name="acc_bal" >
              </div>

              <div class="col-md-4" style="text-align: center !important;">
                <a class="btn btn-primary" data-toggle='modal' data-id='' data-id2='' class='openModal' href='#modalBox'><i class='fas fa-edit'></i> Refund Request</a>
              </div>
            </div>
        </div>
      </div>
    </div>
    <!-- Row 3 Shipper Account List -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
          <p><i class="fas fa-tools"></i> <strong>Shipper Account List</strong></p>
        </div>
        <br>
        <table id="shipping_table" class="table table-sm table-striped">
          <thead>
            <tr>
              <th class="align-top d-none d-md-table-cell" scope="col" width="8%">ID&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="13%">Code&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="30%">Name&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
              <th class="align-top" scope="col" width="15%">Tel</th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="18%">Email</th>
              <th class="align-top d-none d-sm-table-cell" scope="col" width="16%">Contact</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

    <!-- Refund Request Popup Window -->
    <div class="modal fade" id="modalBox" tabindex="-1" role="dialog" aria-labelledby="modalBoxTitle" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width:600px;" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title col-12" id="modalBoxTitle">Record a payment for this invoice
              <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
            </h3>
          </div>
          <div class="modal-body">
            <p style="text-align:center;">Record a payment you've already received such as cash, cheque or bank payment.</p>
            <form class="needs-validation mt-4" action="/report" method="post">
              @csrf
              <div class="form-group row">

                <input type="hidden" class="form-control" name="shipper_code" id="shipper_code" value="">
                <input type="hidden" class="form-control" name="invoice_no" id="invoice_no" value="">

                <label for="datetimepicker4" class="col-md-4 col-form-label text-right">Payment Date</label>
                <div class="input-group date col-md-6" id="datetimepicker4" data-target-input="nearest">
                  <input name="date" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" placeholder="Date" required>
                  <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="amount" class="col-md-4 col-form-label text-right">Amount</label>
                <div class="col-md-6">
                  <input name="amount" type="number" step=".01" class="form-control" id="amount" placeholder="RM" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="measure" class="col-md-4 col-form-label text-right">Payment Method</label>
                <select name="method" id="measure" class="form-control col-md-6 mx-3" required>
                  <option selected="true" value="">Select Method</option>
                  <option value="cash">Cash</option>
                  <option value="onlinebanking">Online Banking Transfer</option>
                  <option value="cheque">Cheque</option>
                </select>
              </div>
              <div class="form-group row">
                <label for="paymentAccount" class="col-md-4 col-form-label text-right">Payment Acount</label>
                <select name="account" id="paymentAccount" class="form-control col-md-6 mx-3" required>
                  <option selected="true" value="">Select Account</option>
                  <option value="account1">Account 1</option>
                  <option value="account2">Account 2</option>
                  <option value="account3">Account 3</option>
                </select>
              </div>
              <div class="form-group row">
                <label for="remarks" class="col-md-4 col-form-label text-right">Remarks</label>
                <textarea name="remarks" class="form-control col-md-7 mx-3" id="remarks" placeholder="Enter task remarks" rows="3"></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-success" type="submit">Save Payment</button>
          </div>
          </form>
        </div>
      </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

$(document).ready(function() {
  $('#shipping_table').DataTable({
    "processing": true,
    "serverSide": false,
    "ajax": "{{ route('ajaxdata.getdatashipping') }}",
    "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "All"]],
    "columns":[
        { "data": "id", "searchable": false },
        { "data": "shipper_code" },
        { "data": "shipper_name", "searchable": false },
        { "data": "telephone", "orderable": false, "searchable": false},
        { "data": "email", "orderable": false, "searchable": false},
        { "data": "contact", "orderable": false, "searchable": false},
    ],
    "buttons": [
            { extend: 'pdf', className: 'btn btn-primary col-md-2', text: 'Download' },
            { extend: 'print', className: 'btn btn-success col-md-2', text: 'Print'}
        ],
    "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
           "<'row'<'col-sm-12 col-md-12'B>>",
    "language": {"searchPlaceholder": "Enter Shipper Code"}
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
                  url: "{{ url('shipping')}}" + '/' + id,
                  data: {'_token' : CSRF_TOKEN, '_method' : 'DELETE'},
                  dataType: 'JSON',
                  success: function (results) {
                      if (results.success === true) {
                          Swal.fire(
                            "Done!",results.message,"success"
                          ).then(function() {
                            window.location = "{{ url('shipping')}}";
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
