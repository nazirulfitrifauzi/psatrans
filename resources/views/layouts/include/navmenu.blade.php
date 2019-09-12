<!-- Menu Left Bar Start -->
<div class="jumbotron m-0 p-0">
<div class="container mainDashboard">
<!-- Top Header -->
<div class="row menuBar">
  <div class="col-12 p-1 pr-4 menuBottomBorder text-right">
    <a href="/dashboard.php"><i class="fas fa-home"></i><span class="topHeaderIcon"> Dashboard</span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/loghistory.php"><i class="fas fa-history"></i><span class="topHeaderIcon"> History</span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/login.php"><i class="fas fa-sign-out-alt"></i><span class="topHeaderIcon"> Log Out</a></span>
  </div>
</div>
<div class="row">
<div class="col-xl-1 menuBar">
  <nav class="navbar navbar-light light-blue lighten-4 d-xl-none">
    <!-- Logo -->
    <img src="/img/psatrans-logo.png" alt="PSA Transport logo" width="130">
    <!-- Mobile Nav Menu Only -->
    <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="true" aria-label="Toggle navigation"><span class="dark-blue-text"><i class="fas fa-bars fa-1x"></i></span></button>
    <div class="navbar-collapse collapse mt-4" id="navbarSupportedContent1">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item menuBottomBorder active">
          <a class="nav-link text-white" href="#">TRANSACTION</a>
          <div class="mb-2"><a href="/transaction.php">Check Consignment</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/newtransaction.php">New Consignment</a></div>
        </li>
        <li class="nav-item menuBottomBorder">
          <a class="nav-link text-white" href="#">BILLING</a>
          <div class="mb-2"><a href="/manifestlisting.php">Manifest</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/billinginvoice.php">Invoice</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/invoicereprint.php">Re-print</a></div>
        </li>
        <li class="nav-item menuBottomBorder">
          <a class="nav-link text-white" href="#">REPORT</a>
          <div class="mb-2"><a href="/reportsummary.php">Summary</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/reportstatement.php">Statement</a></div>
        </li>
        <li class="nav-item menuBottomBorder">
          <a class="nav-link text-white" href="/tracking.php">TRACKING</a>
        </li>
        <li class="nav-item menuBottomBorder">
          <a class="nav-link text-white" href="#">TASK LIST</a>
          <div class="mb-2"><a href="/tasklist.php">Call List</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/newtask.php">New Task</a></div>
        </li>
        <li class="nav-item menuBottomBorder">
          <a class="nav-link text-white" href="#">CALL LOG</a>
          <div class="mb-2"><a href="/calllog.php">Call List</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/newcalllog.php">New Log</a></div>
        </li>
        <li class="nav-item menuBottomBorder">
          <a class="nav-link text-white" href="#">MAINTENANCE</a>
          <div class="mb-2"><a href="/companysetup.php">Company</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/parametersetup.php">SST</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/shippersetup.php">Shipper</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/destinationsetup.php">Destination</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<br><a href="/chargessetup.php">Charges</a></div>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="#">USER</a>
          <div class="mb-2"><a href="/userlist.php">User List</a>&nbsp;&nbsp;<span class="topHeaderIcon">|</span>&nbsp;&nbsp;<a href="/newuser.php">New User</a></div>
        </li>
      </ul>
    </div>
    <!-- End Mobile Nav Menu Only -->
  </nav>
  <!-- Nav Menu - Exclude Mobile -->
  <div class="row d-none d-xl-block">
    <div class="col-12 my-3">
      <img src="/img/psatrans-logo.png" alt="PSA Transport logo" width="95">
    </div>
  </div>
  <div class="row d-none d-xl-block profileBgHighlight">
    <div class="col-12 py-1">
      <p class="text-white my-2">PROFILE</p>
    </div>
  </div>
  <div class="row d-none d-xl-block profileBg">
    <div class="col-12 py-4">
      <p class="text-white">Christ Eng</p>
      <p class="text-white">Executive</p>
      <p class="text-white">Admin</p>
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
                <a href="/transaction.php">
                  <div>Check Consignment</div>
                </a>
              </li>
              <li>
                <a href="/newtransaction.php">
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
                <a href="/manifestlisting.php">
                  <div>Manifest</div>
                </a>
              </li>
              <li>
                <a href="/billinginvoice.php">
                  <div>Invoice</div>
                </a>
              </li>
              <li>
                <a href="/invoicereprint.php">
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
                <a href="/reportsummary.php">
                  <div>Summary</div>
                </a>
              </li>
              <li>
                <a href="/reportstatement.php">
                  <div>Statement</div>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="/tracking.php">
              <div>Tracking</div>
            </a>
          </li>
          <li>
            <a href="#">
              <div>Task List</div>
            </a>
            <ul class="m-0 p-0">
              <li>
                <a href="/tasklist.php">
                  <div>Task List</div>
                </a>
              </li>
              <li>
                <a href="/newtask.php">
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
                <a href="/calllog.php">
                  <div>Call List</div>
                </a>
              </li>
              <li>
                <a href="/newcalllog.php">
                  <div>New Log</div>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">
              <div>Maintenance</div>
            </a>
            <ul class="m-0 p-0">
              <li>
                <a href="/companysetup.php">
                  <div>Company</div>
                </a>
              </li>
              <li>
                <a href="/parametersetup.php">
                  <div>SST</div>
                </a>
              </li>
              <li>
                <a href="/shippersetup.php">
                  <div>Shipper</div>
                </a>
              </li>
              <li>
                <a href="/destinationsetup.php">
                  <div>Destination</div>
                </a>
              </li>
              <li>
                <a href="/chargessetup.php">
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
                <a href="/userlist.php">
                  <div>User List</div>
                </a>
              </li>
              <li>
                <a href="/newuser.php">
                  <div>New User</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <!-- End Nav Menu - Exclude Mobile -->
</div>
