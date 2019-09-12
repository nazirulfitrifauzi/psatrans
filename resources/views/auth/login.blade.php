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
            <ul class="nav nav-pills mb-4 text-center" id="pills-tab" role="tablist">
              <li class="nav-item col-6 px-0">
                <a class="nav-link tabBorderLeft active" id="pills-home-tab" data-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">LOGIN</a>
              </li>
              <li class="nav-item col-6 px-0">
                <a class="nav-link tabBorderRight" id="pills-profile-tab" data-toggle="pill" href="#pills-signup" role="tab" aria-controls="pills-signup" aria-selected="false">SIGN UP</a>
              </li>
            </ul>
            <!-- Section 1: Login Start -->
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade active show" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">

                @if(\Session::has('info'))
                  <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    Please wait for the Administrator to approve your registration. A successful notification will be send to your registered email.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @elseif(\Session::has('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! \Session::get('error') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif

                <form class="needs-validation" method="POST" action="{{ route('login') }}">
                  @csrf

                  <div class="form-group">
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="{{ old('username') }}" required>
                    <div class="invalid-feedback">Please enter username</div>
                  </div>

                  <div class="input-group mb-3">
                    <input type="password" class="form-control form-control-md pwd" id="password" placeholder="Password" name="password" required>
                    <div class="input-group-prepend">
                      <div class="input-group-text reveal"><i toggle="#password" class="fas toggle-password fa-eye-slash"></i></div>
                    </div>
                    <small class="text-muted col-12 pt-2"><i class="fas fa-info-circle"></i> Password must be 8-20 characters long.</small>
                  </div>

                  <!--
                  <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" id="checkbox">
                    <label class="form-check-label" for="checkbox">Remember me</label>
                  </div>
                -->
                  <button type="submit" class="btn btn-yellow col-12 mt-2">LOGIN</button>
                  <a href="{{ route('tracking.index') }}" class="btn btn-yellow col-12 mt-2">GUEST</a>

                  @if (Route::has('password.request'))
                    <div class="input-group mt-3">
                      <p class="text-muted text-right col-12"><u><a href="{{ route('password.request') }}">Forgot your password?</a></u></p>
                    </div>
                  @endif
                </form>
              </div>
              <!-- Section 2: Signup Start -->
              <div class="tab-pane fade" id="pills-signup" role="tabpanel" aria-labelledby="pills-signup-tab">

                <form class="needs-validation" method="POST" action="{{ route('register') }}">
                  @csrf

                  <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                      <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstname" value="{{ old('firstname') }}" required>
                      <div class="invalid-feedback">Please enter first name</div>
                    </div>

                    <div class="form-group col-12 col-md-6">
                      <input type="text" class="form-control" id="lastName" placeholder="Last Name" name="lastname" value="{{ old('lastname') }}" required>
                      <div class="invalid-feedback">Please enter last name</div>
                    </div>
                  </div>

                  <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
                    <div class="invalid-feedback">Please enter valid email</div>
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="{{ old('username') }}" required>
                    <div class="invalid-feedback">Please enter username</div>
                  </div>

                  <div class="form-group">
                    <select required="" id="Position" class="form-control" name="position">
                      <option selected="true" disabled="disabled">Select Position</option>
                      <option value="EXECUTIVE">Executive</option>
                      <option value="DRIVER">Driver</option>
                    </select>
                    <div class="invalid-feedback">Please select position</div>
                  </div>

                  <div class="input-group mb-3">
                    <input type="password" class="form-control form-control-md pwd" id="password2" placeholder="Password" name="password" required>
                    <div class="input-group-prepend">
                      <div class="input-group-text reveal"><i toggle="#password2" class="fas toggle-password fa-eye-slash"></i></div>
                    </div>
                    <small class="text-muted col-12 pt-2"><i class="fas fa-info-circle"></i> Password must be 8-20 characters long.</small>
                  </div>

                  <div class="input-group mb-3">
                    <input id="password-confirm" type="password" class="form-control form-control-md pwd" name="password_confirmation" required placeholder="Confirm Password" required>
                    <div class="input-group-prepend">
                      <div class="input-group-text reveal"><i toggle="#password-confirm" class="fas toggle-password fa-eye-slash"></i></div>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-yellow col-12 mt-3">REQUEST ACCESS</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Password Toggle -->
    <script type="text/javascript">
      $(".toggle-password").click(function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
      });
    </script>
    <!-- Copyright -->
    <div class="text-muted text-center"><small>©2019 PSA Transport Sdn Bhd. All Rights Reserved.</small></div>
  </body>
</html>
