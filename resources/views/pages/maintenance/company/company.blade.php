@extends('layouts.app')

@section('page_title')
Company Setup
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <div class="col-12 mb-3 p-3 bg-white">
      <div class="col-12-center" style="border-bottom: 1px solid #e8e8e8;">
        <p><i class="fas fa-tools"></i>  <strong>Company Details</strong></p>
      </div>
      @if(\Session::has('error'))

      @elseif(\Session::has('success'))
        <div role="alert" class="col-12 px-2 mt-3 alert alert-primary alert-dismissible fade show">{!! \Session::get('success') !!}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
          </button>
        </div>
      @endif
      <div class="col-12 col-xl-10 px-0 py-4">
        <form class="needs-validation" action="/company-setup/{{ $company->id }}" method="post">
          @method('PATCH')
          @csrf

          <div class="form-group">
            <label for="companyName"><sup>*</sup> Company Name</label>
            <input type="hidden" name="id" value="{{ $company->id }}">
            <input type="text" class="form-control" id="companyName" placeholder="Enter company name" name="company_name"value="{{ $company->company_name }}" required>
            <div class="invalid-feedback">Please enter company name</div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="registerID"><sup>*</sup> Registration ID</label>
              <input type="text" class="form-control" id="registerID" placeholder="Enter ID" name="registration_id" value="{{ $company->registration_id }}" required>
              <div class="invalid-feedback">Please enter registration id</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="SST">SST ID</label>
              <input type="text" class="form-control" id="SST" placeholder="Enter ID" name="gst_id" value="{{ $company->gst_id }}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="address1"><sup>*</sup> Address</label>
            <input type="text" class="form-control" id="address1" placeholder="Enter address" name="address1" value="{{ $company->address1 }}" required>
            <div class="invalid-feedback">Please enter company address</div>
          </div>
          <div class="form-group">
            <label for="address2">Address 2</label>
            <input type="text" class="form-control" id="address2" placeholder="Enter address" name="address2" value="{{ $company->address2 }}">
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="city"><sup>*</sup> City</label>
              <input type="text" class="form-control" id="city" placeholder="Enter city" name="city" value="{{ $company->city }}" required>
              <div class="invalid-feedback">Please enter city</div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="state"><sup>*</sup> State</label>
              <select required id="state" class="form-control" name="state">
                <option selected="true" disabled="disabled">Select State</option>
                <option value="johor" @if($company->state == 'johor') selected @endif>Johor</option>
                <option value="kedah" @if($company->state == 'kedah') selected @endif>Kedah</option>
                <option value="kelantan" @if($company->state == 'kelantan') selected @endif>Kelantan</option>
                <option value="kl" @if($company->state == 'kl') selected @endif>Kuala Lumpur</option>
                <option value="labuan" @if($company->state == 'labuan') selected @endif>Labuan</option>
                <option value="malacca" @if($company->state == 'malacca') selected @endif>Malacca</option>
                <option value="n9" @if($company->state == 'n9') selected @endif>Negeri Sembilan</option>
                <option value="pahang" @if($company->state == 'pahang') selected @endif>Pahang</option>
                <option value="penang" @if($company->state == 'penang') selected @endif>Penang</option>
                <option value="perak" @if($company->state == 'perak') selected @endif>Perak</option>
                <option value="perlis" @if($company->state == 'perlis') selected @endif>Perlis</option>
                <option value="putrajaya" @if($company->state == 'putrajaya') selected @endif>Putrajaya</option>
                <option value="sabah" @if($company->state == 'sabah') selected @endif>Sabah</option>
                <option value="sarawak" @if($company->state == 'sarawak') selected @endif>Sarawak</option>
                <option value="selangor" @if($company->state == 'selangor') selected @endif>Selangor</option>
                <option value="terengganu" @if($company->state == 'terengganu') selected @endif>Terengganu</option>
              </select>
              <div class="invalid-feedback">Please enter state</div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="country"><sup>*</sup> Country</label>
              <input type="text" class="form-control" id="country" placeholder="Enter country" name="country" value="{{ $company->country }}" required>
              <div class="invalid-feedback">Please enter country</div>
            </div>
            <div class="col-md-2 mb-3">
              <label for="postcode"><sup>*</sup> Postcode</label>
              <input type="number" class="form-control" id="postcode" placeholder="Enter postcode" name="post_code" value="{{ $company->post_code }}" required>
              <div class="invalid-feedback">Please enter postcode</div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="tel"><sup>*</sup> Telephone</label>
              <input type="text" class="form-control" id="tel" placeholder="Enter number" name="telephone" value="{{ $company->telephone }}" required>
              <div class="invalid-feedback">Please enter telephone number</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="mobile">Mobile</label>
              <input type="text" class="form-control" id="mobile" placeholder="Enter number" name="mobile" value="{{ $company->mobile }}">
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="fax">Fax</label>
              <input type="text" class="form-control" id="fax" placeholder="Enter number" name="fax" value="{{ $company->fax }}">
            </div>
            <div class="col-md-6 mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ $company->email }}">
            </div>
          </div>
          <button type="submit" class="btn btn-primary col-4 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
        </form>
      </div>
    </div>
  </div>

@endsection
