<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PSA Transport Biling System</title>
    <link rel="icon" href="{{ asset('images/img/favicon.ico') }}" type="image/x-icon">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('headscript')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.4/css/all.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    PSA Transport Sdn Bhd
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                      <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
                      </li>
                      <li class="nav-item dropdown">
                          <a id="transaction" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                               Transaction <span class="caret"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-left" aria-labelledby="transaction">
                              <a class="dropdown-item" href="{{ route('consignment.index') }}">
                                Consignment Note
                              </a>
                          </div>
                      </li>
                      <li class="nav-item dropdown">
                          <a id="billing" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              Billing <span class="caret"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-left" aria-labelledby="billing">
                              <a class="dropdown-item" href="{{ route('manifest.index') }}">
                                Manifest Listing
                              </a>
                              <a class="dropdown-item" href="{{ route('invoice.index') }}">
                                Invoice Listing
                              </a>
                              <a class="dropdown-item" href="{{ route('invoice.reprint') }}">
                                Invoice Reprint
                              </a>
                          </div>
                      </li>
                      <li class="nav-item dropdown">
                          <a id="transaction" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                               Report <span class="caret"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-left" aria-labelledby="transaction">
                              <a class="dropdown-item" href="{{ route('report.index') }}">
                                Summary
                              </a>
                              <a class="dropdown-item" href="{{ route('report.statement') }}">
                                Statement
                              </a>
                          </div>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ route('tracking.index') }}">Tracking</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ route('call.index') }}">Call Log</a>
                      </li>
                      <li class="nav-item dropdown">
                          <a id="maintenance" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              Maintenance <span class="caret"></span>
                          </a>
                          <div class="dropdown-menu dropdown-menu-left" aria-labelledby="maintenance">
                              <a class="dropdown-item" href="{{ route('company-setup.index') }}">
                                Company Setup
                              </a>
                              <a class="dropdown-item" href="{{ route('parameter.index') }}">
                                Parameter Setup
                              </a>
                              <a class="dropdown-item" href="{{ route('shipping.index') }}">
                                Shipping Account
                              </a>
                              <a class="dropdown-item" href="{{ route('destination.index') }}">
                                Destination Setup
                              </a>
                              <a class="dropdown-item" href="{{ route('charges.index') }}">
                                Charges Setup
                              </a>
                          </div>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/user">User</a>
                      </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('script')
</body>
</html>
