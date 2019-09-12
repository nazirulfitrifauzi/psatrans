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
    <!-- Row 1 New Shipper Account Form -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-tools"></i> <strong>New Shipper Account</strong></p>
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
        <div class="col-12 col-xl-11 px-0 py-4">
        <form class="needs-validation" method="POST" action="{{ route('shipping.store') }}">
          @csrf
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="companyCode"><sup>*</sup> Shipper Code</label>
              <input type="text" class="form-control" id="companyCode" placeholder="Enter code" name="shipper_code"  onkeyup="this.value = this.value.toUpperCase();" required>
              <div class="invalid-feedback">Please enter shipper code</div>
            </div>
            <div class="col-md-8 mb-3">
              <label for="companyName"><sup>*</sup> Shipper Name</label>
              <input type="text" class="form-control" id="companyName" placeholder="Enter shipper name" name="shipper_name" required>
              <div class="invalid-feedback">Please enter shipper name</div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="register"><sup>*</sup> Contact Name</label>
              <input type="text" class="form-control" id="register" placeholder="Enter contact name" name="contact" required>
              <div class="invalid-feedback">Please enter contact person name id</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="SST">SST ID</label>
              <input type="text" class="form-control" id="SST" placeholder="Enter ID" name="gst_id">
            </div>
          </div>
          <div class="form-group">
            <label for="address"><sup>*</sup> Address</label>
            <input type="text" class="form-control" id="address" placeholder="Enter address" name="address1" required>
            <div class="invalid-feedback">Please enter company address</div>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="city"><sup>*</sup> City</label>
              <input type="text" class="form-control" id="city" placeholder="Enter city" name="city" required>
              <div class="invalid-feedback">Please enter city</div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="state"><sup>*</sup> State</label>
              <select required id="state" class="form-control" name="state">
                <option selected="true" disabled="disabled">Select State</option>
                <option value="johor">Johor</option>
                <option value="kedah">Kedah</option>
                <option value="kelantan">Kelantan</option>
                <option value="kl">Kuala Lumpur</option>
                <option value="labuan">Labuan</option>
                <option value="malacca">Malacca</option>
                <option value="n9">Negeri Sembilan</option>
                <option value="pahang">Pahang</option>
                <option value="penang">Penang</option>
                <option value="perak">Perak</option>
                <option value="perlis">Perlis</option>
                <option value="putrajaya">Putrajaya</option>
                <option value="sabah">Sabah</option>
                <option value="sarawak">Sarawak</option>
                <option value="selangor">Selangor</option>
                <option value="terengganu">Terengganu</option>
              </select>
              <div class="invalid-feedback">Please enter state</div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="country"><sup>*</sup> Country</label>
              <input type="text" class="form-control" id="country" placeholder="Enter country" name="country" required>
              <div class="invalid-feedback">Please enter country</div>
            </div>
            <div class="col-md-2 mb-3">
              <label for="postcode"><sup>*</sup> Postcode</label>
              <input type="number" class="form-control" id="postcode" placeholder="Postcode" name="postcode" required>
              <div class="invalid-feedback">Please enter postcode</div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="tel"><sup>*</sup> Telephone</label>
              <input type="text" class="form-control" id="tel" placeholder="Enter number" name="telephone" required>
              <div class="invalid-feedback">Please enter telephone number</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="mobile">Mobile</label>
              <input type="text" class="form-control" id="mobile" placeholder="Enter number" name="mobile">
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="fax">Fax</label>
              <input type="text" class="form-control" id="fax" placeholder="Enter number" name="fax">
            </div>
            <div class="col-md-6 mb-3">
              <label for="email"><sup>*</sup>Email</label>
              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="credit">Credit Limit</label>
              <input type="number" class="form-control" id="credit" placeholder="Enter credit limit" name="credit_limit">
            </div>
            <div class="col-md-4 mb-3">
              <label for="invoiceTerms">Invoice Terms (Day)</label>
              <input type="number" class="form-control" id="invoiceTerms" placeholder="Enter day limit" name="term_day">
            </div>
            <div class="col-md-4 mb-3">
              <label for="invoiceFormat">Invoice Format</label>
              <select required class="custom-select custom-select-sm" name="invoice_format">
                <option selected="true" disabled="disabled">Select Invoice</option>
                <option value="C">[CTN] Carton</option>
                <option value="P">[PLT] Packet</option>
                <option value="M3">[M3] M3</option>
              </select>
              <div class="invalid-feedback">Please select invoice format</div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary col-5 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
          <a class="btn btn-success col-5 col-md-2 mt-4" href="{{ route('shipping.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
        </form>
      </div>
      </div>
    </div>
  </div>
@endsection
