@extends('layouts.app')

@section('page_title')
Parameter Setup
@endsection

@section('content')
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <div class="col-12 mb-3 p-3 bg-white">
      <div class="col-12-center titleBottomBorder">
        <p><i class="fas fa-tools"></i> <strong>SST Percentage</strong></p>
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
        <form class="needs-validation" action="/parameter/{{ $parameter->id }}" method="post">
          @method('PATCH')
          @csrf
          <div class="form-row">
            <div class="col-12 col-md-6">
              <label for="validationRegister">SST Percentage</label>
              <input type="hidden" name="id" value="{{ $parameter->id }}" >
              <input type="number" class="form-control" id="validationRegister" placeholder="Enter percentage" name="value" value="{{ $parameter->value }}" required>
              <div class="invalid-feedback">Please enter registration SST ID</div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary col-4 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
@endsection
