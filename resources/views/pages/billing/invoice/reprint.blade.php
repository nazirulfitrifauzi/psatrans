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
Billing
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Invoice Reprint -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-sticky-note"></i> <strong>Invoice Re-print</strong></p>
        </div>
        <div class="col-xl-10 px-0 py-4">
          <form method="POST" target="_blank" action="{{ route('invoice.redownload') }}">
            @csrf
            <div class="form-group">
              <label for="invoiceNo">Invoice Number</label>
              <input class="form-control col-md-8 col-xl-4" type="text" id="invoiceNo" placeholder="Enter invoice number" name="invoice_no" onkeyup="this.value = this.value.toUpperCase();" required>
            </div>
            <button type="submit" class="btn btn-primary my-4">Re-print Invoice</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
