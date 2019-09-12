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
Report
@endsection

@section('content')
  <div class="row">
    <div class="col-12 col-lg-8 col-xl-9 px-2">
      <!-- Row 1 Statement Report Check -->
      <div class="row mx-0">
        <div class="col-12 mb-3 p-3 bg-white">
          <div class="col-12-center titleBottomBorder">
            <p><i class="fas fa-dollar-sign"></i> <strong>Payment Record Search</strong></p>
          </div>
          <div class="col-12 col-xl-10 px-0 py-4">
            <form>
              <div class="form-row">
                <div class="col-lg-6 col-xl-4 mb-3">
                  <label for="start_date"><sup>*</sup> Start Date</label>
                  <div class="input-group date" id="start_date" data-target-input="nearest">
                    <input name="start_date" type="text" class="form-control datetimepicker-input" data-target="#start_date" placeholder="Enter start date">
                    <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-xl-4 mb-3">
                  <label for="end_date"><sup>*</sup> End Date</label>
                  <div class="input-group date" id="end_date" data-target-input="nearest">
                    <input name="end_date" type="text" class="form-control datetimepicker-input" data-target="#end_date" placeholder="Enter end date">
                    <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="destinationCode">Shipper Code</label>
                <input class="form-control col-md-8 col-xl-4" type="text" placeholder="Enter shipper code" name="shipper_code" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              <div class="form-group">
                <label for="destinationCode">Invoice Number</label>
                <input class="form-control col-md-8 col-xl-4" type="text" placeholder="Enter invocie number" name="invoice_no" onkeyup="this.value = this.value.toUpperCase();">
              </div>
              <button type="button" class="btn btn-primary col-6 col-md-3 my-4" id="searchButton">Preview Report</button>
              <small class="form-text text-muted"><i class="fas fa-info-circle"></i> You may filter the report specifically by Shipper account OR Consignment Note.</small>
            </form>
          </div>
        </div>
      </div>
      <!-- Row 2 Statement Report -->
      <div class="row mx-0 tableresult">
        <div class="col-12 mb-3 p-3 bg-white">
          <div class="col-12-center">
            <p><i class="fas fa-dollar-sign"></i> <strong>Statement Report</strong></p>
          </div>
          <div class="mt-4">
            <ul id="myTab" class="nav nav-pills titleBottomBorder">
              <li class="nav-item col-4 col-md-2 px-0">
                <a href="#unpaidinvoice" class="nav-link tabBorderLeft text-center active">UNPAID</a>
              </li>
              <li class="nav-item col-4 col-md-2 px-0">
                <a href="#allinvoice" class="nav-link tabBorderRight text-center">ALL INVOICE</a>
              </li>
            </ul>
            <div class="tab-content mt-4">
              <div class="tab-pane fade active show" id="unpaidinvoice">
                <table id="report_summary_table_unpaid" class="table table-sm table-striped">
                  <thead>
                    <tr>
                      <th class="align-top" scope="col" width="12%">Status&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
                      <th class="align-top d-none d-sm-table-cell" scope="col" width="18%">Date/Time</th>
                      <th class="align-top d-none d-sm-table-cell" scope="col" width="15%">Invoice No</th>
                      <th class="align-top" scope="col" width="25%">Shipper Name</th>
                      <th class="align-top" scope="col" width="15%">Amount Due</th>
                      <th class="align-top" scope="col" width="15%"></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="tab-pane fade" id="allinvoice">
                <table id="report_summary_table_all" class="table table-sm table-striped">
                  <thead>
                    <tr>
                      <th class="align-top" scope="col" width="12%">Status&nbsp;&nbsp;&nbsp;<i class="fas fa-sort"></i></th>
                      <th class="align-top d-none d-sm-table-cell" scope="col" width="18%">Date/Time</th>
                      <th class="align-top d-none d-sm-table-cell" scope="col" width="15%">Invoice No</th>
                      <th class="align-top" scope="col" width="25%">Shipper Name</th>
                      <th class="align-top" scope="col" width="15%">Amount Due</th>
                      <th class="align-top" scope="col" width="15%"></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <!-- Payment Record Popup Window -->
              <div class="modal fade" id="modalBox" tabindex="-1" role="dialog" aria-labelledby="modalBoxTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h6 class="modal-title col-12" id="modalBoxTitle">Record a payment for this invoice
                        <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                      </h6>
                    </div>
                    <div class="modal-body">
                      <p>Record a payment you've already received such as cash, cheque or bank payment.</p>
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
              <!-- End Payment Record Popup Window -->
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('script')
<script>
  //hide table before search
  //$(".tableresult").hide();

  $(document).ready(function(){
    $('#start_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $('#end_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
        $("#report_summary_table_all").css("width",'');
        $("#report_summary_table_unpaid").css("width",'');
    });

      var table_all = $('#report_summary_table_all').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
          "url": "{{ route('ajaxdata.getdatareport') }}",
          "data": function (d) {
            d.start_date = $('#start_date').datetimepicker('viewDate')._d.toLocaleDateString();
            d.end_date = $('#end_date').datetimepicker('viewDate')._d.toLocaleDateString();
            d.shipper_code = $('#shipper_code').val();
            d.invoice_no = $('#invoice_no').val();
          }
        },
        "columns":[
          { "data": "status", "name": "status", render:function(data, type, row){
            if(row.status == "Pending"){
              return "<div class='overdue col-xl-10'>Pending</div>"
            }else if(row.status == "Paid"){
              return "<div class='paid col-xl-10'>Paid</div>"
            }
          }},
          { "data": "invoice_date" },
          { "data": "invoice_no" },
          { "data": "shipper_name" },
          { render:function(data, type, row){
              return "RM "+ parseFloat(row.inv_total_amount).toFixed(2)
            }
          },
          { render:function(data, type, row){
            if(row.status == "Pending"){
              return "<a style='text-decoration:none;' data-toggle='modal' data-id='"+ row.shipper_code +"' data-id2='"+ row.invoice_no +"' class='openModal' href='#modalBox'><i class='fas fa-edit'></i> Record Payment</a>"
            }else if(row.status == "Paid"){
              return "<span style='color:green;'>Payment Recorded</span>"
            }

            }
          },
        ],
        "bLengthChange": false,
        "dom": "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
      });

      var table_unpaid = $('#report_summary_table_unpaid').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
          "url": "{{ route('ajaxdata.getdatareport_unpaid') }}",
          "data": function (d) {
            d.start_date = $('#start_date').datetimepicker('viewDate')._d.toLocaleDateString();
            d.end_date = $('#end_date').datetimepicker('viewDate')._d.toLocaleDateString();
            d.shipper_code = $('#shipper_code').val();
            d.invoice_no = $('#invoice_no').val();
          }
        },
        "columns":[
          { "data": "status", "name": "status", render:function(data, type, row){
            if(row.status == "Pending"){
              return "<div class='overdue col-xl-10'>Pending</div>"
            }else if(row.status == "Paid"){
              return "<div class='paid col-xl-10'>Paid</div>"
            }
          }},
          { "data": "invoice_date" },
          { "data": "invoice_no" },
          { "data": "shipper_name" },
          { render:function(data, type, row){
              return "RM "+ parseFloat(row.inv_total_amount).toFixed(2)
            }
          },
          { render:function(data, type, row){
            if(row.status == "Pending"){
              return "<a style='text-decoration:none;' data-toggle='modal' data-id='"+ row.shipper_code +"' data-id2='"+ row.invoice_no +"' class='openModal' href='#modalBox'><i class='fas fa-edit'></i> Record Payment</a>"
            }else if(row.status == "Paid"){
              return "<span style='color:green;'>Payment Recorded</span>"
            }

            }
          },
        ],
        "bLengthChange": false,
        "dom": "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
      });

      $("#searchButton").click(function(e) {

        //show table after search
        //$(".tableresult").show();

        table_all.ajax.reload();
        table_unpaid.ajax.reload();

        e.preventDefault();
      });
  });

  $(document).on("click", ".openModal", function () {
      var shipper_code = $(this).data('id');
      var invoice_no = $(this).data('id2');
      $(".modal-body #shipper_code").val( shipper_code );
      $(".modal-body #invoice_no").val( invoice_no );
  });
</script>
@endsection
