<!DOCTYPE html>
<html lang="en">
  <head>
    <title>PSA Transport Sdn Bhd</title>
    <link rel="icon" href="{{ asset('images/img/favicon.ico') }}" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
  </head>
  <body>
    <!-- Logo start -->
    <div class="jumbotron bg-dark">
      <div class="container col-5 ">
        <div class="row mb-5 justify-content-center">
          <div class="media text-center">
            <img src="{{ asset('images/img/psatrans-logo.png') }}" alt="PSA Transport logo">
          </div>
        </div>
      </div>
      <!-- Column 1: Form start -->
      <div class="container col-10 col-sm-8 col-md-6 col-lg-4 bg-white">
        <div class="row p-2 justify-content-center">
          <div class="col-12 my-4">
            <!-- Section 1: Reset Password Start -->
            <div class="tab-content" id="pills-tabContent">

              @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
              @endif

              <form class="needs-validation" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" placeholder="Enter your email" name="email" value="{{ old('email') }}" required>

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                <button type="submit" class="btn btn-yellow col-12 mt-2">SEND PASSWORD RESET LINK</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Copyright -->
    <div class="text-muted text-center"><small>©2019 PSA Transport Sdn Bhd. All Rights Reserved.</small></div>
  </body>
</html>
