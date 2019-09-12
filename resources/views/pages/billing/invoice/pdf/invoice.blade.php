<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{$title}}</title>
 <style>
  /**
      Set the margins of the page to 0, so the footer and the header
      can be of the full height and width !
   **/
	 @page {
     margin: 50px 0px 40px 0px;
   }

  /** Define now the real margins of every page in the PDF **/
  body {
    font-family: 'Roboto', sans-serif;
    font-weight: 400; font-size: 12px;
    line-height: 1.4;
    margin-left: 1.5cm;
    margin-right: 1.5cm;
  }
  main{
		page-break-inside: auto;
  }
  .contentSection {
    font-size: 12px;
    line-height: 1.4;
  }
  th, .cellGrey {
    background-color: #f1f1f1;
    padding: 6px;
  }
  td {
    padding: 6px;
  }
  h1 {
    font-size: 25px;
    text-align: center;
  }
  .textCenter {
    text-align: center;
  }
  .whiteBg {
    background-color: #fff;
    margin-top: 20px;
    padding: 20px;
  }
  .column {
    display: inline-block;
    width: 49%;
    vertical-align: middle;
  }
  .textLeft {
    text-align: left;
  }
  .textRight {
    text-align: right;
  }
  .divider {
    border-bottom: 1px solid #e4e4e4; height: 30px;
  }
  .gap {
    margin-top: 25px;
  }
  .Table {
    display: table; width: 100%;
  }
  .Row {
    display: table-row;
    line-height: 1px;
  }
  .Cell {
    width:70%;
    display: table-cell;
  }
  .Cell2 {
    width:29%;
    display: table-cell;
  }
	.cellGrey {
		background-color: #f1f1f1; padding: 6px;
	}
	.signature {
		border-bottom: 1px dotted #ccc; height: 60px; width: 200px; float: right;
	}
	ol li {
		margin-left: -20px;
	}
  .company {
    font-size: 12px;
  }
</style>
</head>
<body>
    <main>
              <h1>Invoice Statement</h1>
              <p class="textCenter">Invoice Number: {{ sprintf('%09d', $content['invoice_no']->invoice_no+1) }}<br>(Generate on {{now()->format('d/m/Y')}})</p>
              <div class="whiteBg">
                <div>
                  <div class="column textLeft"><img src="{{ public_path('images/img/psa-logo-blackwhite.png') }}" height="5%"></div>
                  <div class="column textRight company">
                    <b>{{ $content['company_data']->company_name }} ( {{ $content['company_data']->registration_id }} )</b><br>
                    {{ $content['company_data']->address1 }},<br>
                    {{ $content['company_data']->post_code }} {{ $content['company_data']->city }}, {{ $content['company_data']->state }},<br>
                    {{ $content['company_data']->country }}.<br>
                    GST ID: {{ $content['company_data']->gst_id }}
                  </div>
                </div>
                <div class="divider">&nbsp;</div>
								<!-- Shipper Details -->
								<div class="gap">
									<div class="column textLeft company" style="vertical-align:top">
										<p>To: <br>
											<b>{{ $content['shipper_data']->shipper_name }}</b><br>
                      
                      @php
                        $address = $content['shipper_data']->address1;

                        $addressArray = array_map(
                          function($value) {
                            return implode(',', $value);
                          },
                          array_chunk(
                            explode(',', $address),
                            2
                          )
                        );

                        $count = count($addressArray);

                        for($x = 0; $x < $count; $x++){
                          print_r($addressArray[$x]);
                          echo ',<br>';
                        }
                      @endphp

											{{ $content['shipper_data']->postcode }} {{ $content['shipper_data']->city }}, {{ $content['shipper_data']->state }},<br>
											{{ $content['shipper_data']->country }}<br>
											GST ID: {{ $content['shipper_data']->gst_id }}
										</p>
									</div>
								</div>
                <!-- Invoice start here -->
                <table width="100%" colspacing="0" border="0" style="border-collapse: collapse;" class="contentSection">
                  <thead>
                    <tr>
											<th align="left" valign="middle" width="18%">Date</th>
	                    <th align="left" valign="middle" width="10%">CN No</th>
	                    <th align="left" valign="middle" width="26%">Destination</th>
	                    <th align="left" valign="middle" width="10%">Quantity</th>
	                    <th align="left" valign="middle" width="18%">Amount</th>
	                    <th align="left" valign="middle" width="18%">Total</th>
                    </tr>
                  </thead>
                  <tbody>
										@foreach ($content['invoice_data'] as $key => $data)
					            <tr>
					              <td>{{date('d M Y', strtotime($data->cn_datetime))}}</td>
					              <td>{{$data->cn_no}}</td>
					              <td>{{$data->destination_code}}</td>
					              <td>{{$data->quantity}}</td>
					              <td>RM {{ number_format($data->sub_amount,2)}}</td>
					              <td>RM {{ number_format($data->sub_amount * $data->quantity,2) }}</td>
					            </tr>
					          @endforeach
										<!-- Total Amount Summary -->
										<tr>
											<td colspan="4"></td>
											<td>Sub Amount</td>
											<td>RM {{ number_format($subtotal,2) }}</td>
										</tr>
										<tr>
											<td colspan="4"></td>
											<td>SST Amount</td>
											<td>RM {{ number_format($gst,2) }}</td>
										</tr>
										<tr>
											<td colspan="4"></td>
											<td class="cellGrey"><b>Total Amount</b></td>
											<td class="cellGrey"><b>RM {{ number_format($total,2) }}</b></td>
										</tr>
                  </tbody>
                </table>
								<!-- End Invoice Table start here -->
	              <div class="gap">
	                <ol>
	                  <li>All cheque should be crossed and made payable to PSA TRANSPORT SDN BHD.</li>
	                  <li>Receipt for payment is not valid until the company's official receipt by authorise personnel is given.</li>
	                  <li>We reserve the right to charge at the rate of interest 1.5% per month on all overdue accounts.</li>
	                  <li>Bank Details: Public Bank Berhad / Account Number: 3148-6505-31.</li>
	                </ol>
	              </div>
	              <div class="gap" style="height: 140px;">
	                <div class="column textRight" style="width: 30%;float: right;">
	                  <p>PSA TRANSPORT SDN BHD</p>
	                  <div class="signature">&nbsp;</div>
	                  <p>Authorized Signature</p>
	                </div>
	              </div>
	            </div>
                <!-- Copyright -->
                <div class="textLeft" style="font-size: 10px;height: 50px;">&copy;{{now()->format('Y')}} PSA Transport Sdn Bhd. All Rights Reserved.
              	</div>
    </main>
</body>
</html>
