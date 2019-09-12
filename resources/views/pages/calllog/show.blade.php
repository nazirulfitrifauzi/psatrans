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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <style media="screen">
    .dataTables_filter {
       float: left !important;
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

  </head>
  <body>
  <!-- CONTENT START HERE -->
  <!-- Left Navigation Menu -->
    <!-- Menu Left Bar Start -->
    <div class="jumbotron m-0 p-0">
      <div class="container mainDashboard">
      <!-- Top Header -->
      <div class="row menuBar">
        <div class="col-12 p-1 pr-4 menuBottomBorder text-right">
          <a href="{{ url('/dashboard') }}"><i class="fas fa-home"></i><span class="topHeaderIcon"> Dashboard</span></a>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <a href="{{ route('log') }}"><i class="fas fa-history"></i><span class="topHeaderIcon"> History</span></a>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i><span class="topHeaderIcon"> Log Out</a></span>
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </div>
      </div>
      <div class="row">
      <div class="col-xl-1 menuBar">
        <nav class="navbar navbar-light light-blue lighten-4 d-xl-none">
          <!-- Logo -->
          <img src="{{ asset('images/img/psatrans-logo.png') }}" alt="PSA Transport logo" width="130">
          <!-- Mobile Nav Menu Only -->
          <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="true" aria-label="Toggle navigation"><span class="dark-blue-text"><i class="fas fa-bars fa-1x"></i></span></button>
          <div class="navbar-collapse collapse mt-4" id="navbarSupportedContent1">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item menuBottomBorder active">
                <a class="nav-link text-white" href="#">TRANSACTION</a>
                <div class="mb-2">
                  <a href="{{ route('consignment.index') }}">Check Consignment</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('consignment.create') }}">New Consignment</a>
                </div>
              </li>
              <li class="nav-item menuBottomBorder">
                <a class="nav-link text-white" href="#">BILLING</a>
                <div class="mb-2">
                  <a href="{{ route('manifest.index') }}">Manifest</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('invoice.index') }}">Invoice</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('invoice.reprint') }}">Re-print</a>
                </div>
              </li>
              <li class="nav-item menuBottomBorder">
                <a class="nav-link text-white" href="#">REPORT</a>
                <div class="mb-2">
                  <a href="{{ route('report.index') }}">Summary</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="/reportstatement.php">{{ route('report.statement') }}</a>
                </div>
              </li>
              <li class="nav-item menuBottomBorder">
                <a class="nav-link text-white" href="{{ route('tracking.index') }}">TRACKING</a>
              </li>
              <li class="nav-item menuBottomBorder">
                <a class="nav-link text-white" href="#">TASK LIST</a>
                <div class="mb-2">
                  <a href="{{ route('task.index') }}">Task List</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('task.create') }}">New Task</a>
                </div>
              </li>
              <li class="nav-item menuBottomBorder">
                <a class="nav-link text-white" href="#">CALL LOG</a>
                <div class="mb-2">
                  <a href="{{ route('call.index') }}">Call List</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('call.create') }}">New Log</a>
                </div>
              </li>
              <li class="nav-item menuBottomBorder">
                <a class="nav-link text-white" href="#">MAINTENANCE</a>
                <div class="mb-2">
                  <a href="{{ route('company-setup.index') }}">Company</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('parameter.index') }}">SST</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('shipping.index') }}">Shipper</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('destination.index') }}">Destination</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <br><a href="{{ route('charges.index') }}">Charges</a></div>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white" href="#">USER</a>
                <div class="mb-2">
                  <a href="{{ route('user.index') }}">User List</a>
                  &nbsp;&nbsp;
                  <span class="topHeaderIcon">|</span>
                  &nbsp;&nbsp;
                  <a href="{{ route('user.create') }}">New User</a>
                </div>
              </li>
            </ul>
          </div>
          <!-- End Mobile Nav Menu Only -->
        </nav>
        <!-- Nav Menu - Exclude Mobile -->
        <div class="row d-none d-xl-block">
          <div class="col-12 my-3">
            <a href="{{ url('/dashboard') }}"><img src="{{ asset('images/img/psatrans-logo.png') }}" alt="PSA Transport logo" width="95"></a>
          </div>
        </div>
        <div class="row d-none d-xl-block profileBgHighlight">
          <div class="col-12 py-1">
            <p class="text-white my-2">PROFILE</p>
          </div>
        </div>
        <div class="row d-none d-xl-block profileBg">
          <div class="col-12 py-4">
            <p class="text-white">{{ ucfirst(Auth::user()->username) }}</p>
            <p class="text-white">{{ ucfirst(Auth::user()->position) }} </p>
            <p class="text-white">{{ ucfirst(Auth::user()->role) }} </p>
          </div>
        </div>
        <div class="row d-none d-xl-block">
          <div class="col-12 px-0 my-3">
            <nav>
              <ul class="navMenu m-0 p-0">
                <li>
                  <a href="#">
                    <div>Transaction</div>
                  </a>
                  <ul class="m-0 p-0">
                    <li>
                      <a href="{{ route('consignment.index') }}">
                        <div>Check Consignment</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('consignment.create') }}">
                        <div>New Consignment</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#">
                    <div>Billing</div>
                  </a>
                  <ul class="m-0 p-0">
                    <li>
                      <a href="{{ route('manifest.index') }}">
                        <div>Manifest</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('invoice.index') }}">
                        <div>Invoice</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('invoice.reprint') }}">
                        <div>Re-print</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#">
                    <div>Report</div>
                  </a>
                  <ul class="m-0 p-0">
                    <li>
                      <a href="{{ route('report.index') }}">
                        <div>Summary</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('report.statement') }}">
                        <div>Statement</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="{{ route('tracking.index') }}">
                    <div>Tracking</div>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div>Task List</div>
                  </a>
                  <ul class="m-0 p-0">
                    <li>
                      <a href="{{ route('task.index') }}">
                        <div>Task List</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('task.create') }}">
                        <div>New Task</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#">
                    <div>Call Log</div>
                  </a>
                  <ul class="m-0 p-0">
                    <li>
                      <a href="{{ route('call.index') }}">
                        <div>Call List</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('call.create') }}">
                        <div>New Log</div>
                      </a>
                    </li>
                  </ul>
                </li>
                @if( Auth::user()->role == 'admin' )
                <li>
                  <a href="#">
                    <div>Maintenance</div>
                  </a>
                  <ul class="m-0 p-0">
                    <li>
                      <a href="{{ route('company-setup.index') }}">
                        <div>Company</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('parameter.index') }}">
                        <div>SST</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('shipping.index') }}">
                        <div>Shipper</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('destination.index') }}">
                        <div>Destination</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('charges.index') }}">
                        <div>Charges</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#">
                    <div>User</div>
                  </a>
                  <ul class="m-0 p-0">
                    <li>
                      <a href="{{ route('user.index') }}">
                        <div>User List</div>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('user.create') }}">
                        <div>New User</div>
                      </a>
                    </li>
                  </ul>
                </li>
                @endif
              </ul>
            </nav>
          </div>
        </div>
        <!-- End Nav Menu - Exclude Mobile -->
      </div>

  <!-- Page Title -->
  <div class="col-xl-11 min-vh-100 p-4">
    <div class="row">
      <div class="col-12 mb-3">
        <h4>Call Log</h4>
      </div>
    </div>
  <!-- Notification -->
  @if ($checkAdmin == 'admin')
    @if ($activeCount >= 1 || $countpriority >= 1)
      <div class="row">
          <div class="col-12 px-2">
            <div class="col-12 p-3 my-3 bg-white">
              @if($countpriority >= 1)
                <span>
                  <sup><i class="fas fa-exclamation-triangle"></i></sup> <a href="{{ route('task.index') }}"><span class="text-danger">{{ $countpriority }} URGENT Task (Priority 4)</span></a> waiting to be resolved!
                </span>
                <br>
              @else
              @endif

              @if($activeCount >= 1)
                <span class="mb-0">
                  <i class="far fa-frown-open"></i> Pending user activation request: <a href="{{ route('user-activation') }}"><span class="text-danger">{{$activeCount}}  waiting users</span></a>
                </span>
              @else
              @endif
            </div>
          </div>
      </div>
    @else
    @endif

  @else
  @endif
<!-- Column 1 -->
<div class="row">
  <div class="col-12 col-lg-8 col-xl-9 px-2">
    <!-- Row 1 Existing Call Log Update -->
    <div class="row mx-0">
      <div class="col-12 mb-3 p-3 bg-white">
        <div class="col-12-center titleBottomBorder">
          <p><i class="fas fa-thumbtack"></i> <strong>Existing Call Log Updated</strong></p>
        </div>
        @if(\Session::has('error'))

        @elseif(\Session::has('success'))
          <div role="alert" class="col-12 px-2 mt-3 alert alert-primary alert-dismissible fade show">{!! \Session::get('success') !!}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
          </div>
        @endif
        <div class="col-12 px-0 py-4">
          <form class="needs-validation" action="/call/{{ $calldata->id }}" method="post">
            @method('PATCH')
            @csrf

            <div class="form-row">
              <div class="col-md-3 mb-3">
                <label for="callID"><b>Call Log ID:</b></label>
                <input readonly type="text" class="form-control-plaintext" name="id" value="A00{{ $calldata->id }}">
              </div>
              <div class="col-md-5 mb-3">
                <label for="contactName"><b>Contact Name:</b></label>
                <input disabled="" type="text" class="form-control-plaintext" id="contactName" name="contact_name" value="{{ $calldata->contact_name }}">
              </div>
              <div class="col-md-4 mb-3">
                <label for="tel"><b>Telephone:</b></label>
                <input disabled="" type="number" class="form-control-plaintext" id="tel" name="contact_no" value="{{ $calldata->contact_no }}">
              </div>
            </div>
            <div class="form-group">
              <label for="subject"><b>Subject:</b></label>
              <input disabled="" type="text" class="form-control-plaintext" id="subject" name="subject" value="{{ $calldata->subject }}">
            </div>
            <div class="form-group">
              <label for="description"><b>Description:</b></label>
              <input disabled="" class="form-control-plaintext" id="description" name="description" value="{{ $calldata->description }}">
            </div>
            <div class="form-row">
              <div class="col-md-4 mb-3">
                <label for="assignTo"><b><sup>*</sup> Assign To:</b></label>
                <select name="assign_to" class="form-control" id="assign_to" required>
                  @foreach($assign as $row)
                    <option value="{{ $row->username }}" @if($calldata->assign_to == $row->username) selected @else @endif>{{ $row->firstname }} {{ $row->lastname }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label for="priority"><b><sup>*</sup> Priority:</b></label>
                <select required id="priority" class="form-control" name="priority">
                  <option value="4" @if($calldata->priority == '4') selected @endif >4 – Urgent</option>
                  <option value="3" @if($calldata->priority == '3') selected @endif >3 – Important</option>
                  <option value="2" @if($calldata->priority == '2') selected @endif >2 – Normal</option>
                  <option value="1" @if($calldata->priority == '1') selected @endif >1 – Low</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="taskStatus"><b><sup>*</sup> Task Status:</b></label>
                <select required id="taskStatus" class="form-control" name="status">
                  <option value="I" @if($calldata->status == 'I') selected @endif >In-progress</option>
                  <option value="C" @if($calldata->status == 'C') selected @endif >Completed</option>
                  <option value="X" @if($calldata->status == 'X') selected @endif >Close</option>
                </select>
              </div>
            </div>
            <div class="form-group bg-light p-2 mt-3">
              <label for="remark"><b>Remarks</b></label>
              <!-- Remarks Log Record -->
                  @if (count($remark) > 0)
                    <table class="table table-sm my-4">
                      <thead>
                        <tr>
                          <th class="align-top" scope="col" width="20%">Date/Time</th>
                          <th class="align-top" scope="col" width="65%">Action</th>
                          <th class="align-top" scope="col" width="15%">User</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($remark as $row)
                          <tr>
                            <td>{{ $row->datetime->format('d M Y, h:i a') }}</td>
                            <td>{{ ucfirst($row->remark) }}</td>
                            <td>{{ ucfirst($row->user) }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                  @else
                  @endif
              <textarea class="form-control" id="remark" placeholder="Enter task remarks" rows="4" name="remarks"></textarea>
            </div>
            <button type="submit" class="btn btn-primary col-5 col-md-2 mt-4"><i class="fa fa-check"></i> Save</button>
            <a class="btn btn-success col-5 col-md-2 mt-4" href="{{ route('call.index') }}" role="button"><i class="fas fa-redo-alt"></i> Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Sidebar -->
  <div class="col-12 col-lg-4 col-xl-3 px-2">
    <div class="row mx-0">
      <div class="col-12 pt-3 bg-white">
        <p><i class="fas fa-thumbtack"></i>  <strong>Task List</strong></p>
      </div>
      <div class="col-12 mb-3 bg-white">
        <!-- Section 1-->
        <!-- Row 1 Task List: Display 6 rows -->
        <table class="table table-sm table-striped">
          <thead>
            <tr>
              <th class="align-top" scope="col" width="55%">Subject</th>
            </tr>
          </thead>
          <tbody>
            @if(count($task) === 0)
            <tr>
              <td><a href="{{ route('task.create') }}" style="text-decoration:none;"><i class="fas fa-plus-circle"></i> Add Task</a></td>
            </tr>
            @else
              @foreach ($task as $row)
              <tr>
                <td><a href="task/{{ $row->id }}" style="text-decoration: none;">{{ $row->subject }}</a></td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        <p class="text-right"><a href="{{ route('task.index') }}" style="text-decoration: none;float: right;"><i class="fas fa-chevron-circle-right"></i> Full List</a></p>
      </div>
    </div>
  </div>
  </div>
  <!-- Footer -->
  <div class="row">
  <div class="col-12 footer my-2">
    <small>©2019 PSA Transport Sdn Bhd. All Rights Reserved.</small>
  </div>
  </div>
  </div>
  </div>
    </div>
  </div>
  </body>
  </html>
