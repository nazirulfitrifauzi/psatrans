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
  .final{
    page-break-inside: avoid;
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
    margin-top: 30px;
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
  .company {
    font-size: 12px;
  }
  .page-break {
    page-break-after: always;
  }
</style>
</head>
<body>
    <main>
              <h1>Statement of Account</h1>
              <p class="textCenter">(Generate on {{now()->format('d/m/Y')}})</p>
              <div class="whiteBg">
                <div>
                  <div class="column textLeft"><img src="{{ public_path('images/img/psa-logo-blackwhite.png') }}" height="5%"></div>
                  <div class="column textRight company">
                    <b>{{ $company->company_name }} ( {{ $company->registration_id }} )</b><br>
                    {{ $company->address1 }},<br>
                    {{ $company->post_code }} {{ $company->city }}, {{ $company->state }},<br>
                    {{ $company->country }}.<br>
                    GST ID: {{ $company->gst_id }}
                  </div>
                </div>
                <div class="divider">&nbsp;</div>
                <div class="gap">
                  <!-- Shipper Details -->
                  <div class="column textLeft company" style="vertical-align:top">
                    <p>To: <br>
                      <b>{{ $shipper->shipper_name }}</b><br>
                      @php
                        $address = $shipper->address1;

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
                      {{ $shipper->postcode }} {{ ucwords(strtolower($shipper->city)) }}, {{ ucwords(strtolower($shipper->state)) }},<br>
                      {{ ucwords(strtolower($shipper->country)) }}<br>

                      GST ID: {{ $shipper->gst_id }}
                    </p>
                  </div>
                  <!-- Acoount Details -->
                  <div class="column textRight" style="vertical-align:top">
                    <p class="textRight"><b>Account Summary</b></p>
                    <div class="Table">
                      <div class="Row">
                        <div class="Cell">
                          <p class="company">Beginning balance {{ $start_date }}:</p>
                        </div>
                        <div class="Cell2">
                          <p class="company">RM
                            @if(!$account)
                               0.00
                            @else
                              {{ $account->acc_bal }}
                            @endif
                          </p>
                        </div>
                      </div>
                      <div class="Row">
                        <div class="Cell">
                          <p class="company">Invoice:</p>
                        </div>
                        <div class="Cell2">
                          <p class="company">RM {{ number_format($invoice_total,2) }}</p>
                        </div>
                      </div>
                      <div class="Row">
                        <div class="Cell">
                          <p class="company">Payment:</p>
                        </div>
                        <div class="Cell2">
                          <p class="company">RM {{ number_format($payment_total,2) }}</p>
                        </div>
                      </div>

                      @php
                        if(!$account)
                          $total = 0;
                        else{
                          $total = $account->acc_bal;
                        }

                        $last = 0;
                        $totals = [];
                      @endphp

                      @foreach($statement as $index => $row)
                        @php
                          if($row->mode == 'invoice')
                          {
                            $total -= $row->amount;
                          }
                          elseif($row->mode == 'payment')
                          {
                            $total += $row->amount;
                          }
                          $totals[$index] = $total;
                          $last = $total;
                        @endphp
                      @endforeach

                      <div class="Row">
                        <div class="Cell">
                          <p class="company">Ending balance {{ $end_date }}:</p>
                        </div>
                        <div class="Cell2">
                          <p class="company">
                            @if($last < 0)
                              RM 0.00
                            @else
                              RM {{ number_format($last,2) }}
                            @endif
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="divider">&nbsp;</div>
                <div class="gap"><b>Showing all invoice and payment between {{ $start_date }} to {{ $end_date }}</b></div>
                <!-- Invoice start here -->
                <table width="100%" colspacing="0" border="0" style="border-collapse: collapse;" class="contentSection gap">
                  <tbody>
                    <tr>
                      <th align="left" valign="middle" width="18%">Date</th>
                      <th align="left" valign="middle" width="46%">Details</th>
                      <th align="left" valign="middle" width="18%">Amount</th>
                      <th align="left" valign="middle" width="18%">Total</th>
                    </tr>
                    <tr>
                      <td>{{ $start_date }}</td>
                      <td>Beginning balance {{ $start_date }}</td>
                      <td></td>
                      <td>RM
                        @if(!$account)
                           0.00
                        @else
                          {{ $account->acc_bal }}
                        @endif
                      </td>
                    </tr>

                    @php
                      $i = -1;

                      if(!$account)
                        $total = 0;
                      else{
                        $total = $account->acc_bal;
                      }
                      $last = 0;
                      $totals = [];
                    @endphp

                    @foreach($statement as $index => $row)

                      @php
                        $i++;
                      @endphp

                      <tr>
                        <td>
                          @php
                            $date = date_create($row->date)
                          @endphp
                          {{ date_format($date,"d M Y") }}
                        </td>
                        <td>
                          @if($row->mode == 'invoice')
                            Invoice statement ( {{ $row->invoice_no }} )
                          @elseif($row->mode == 'payment')
                            Payment to invoice statement ( {{ $row->invoice_no }} )
                          @endif
                        </td>
                        <td>
                          RM {{ number_format($row->amount,2) }}
                        </td>
                        <td>
                          @php

                            if(!$account){
                              if($row->mode == 'invoice')
                              {
                                $total -= $row->amount;
                              }
                              elseif($row->mode == 'payment')
                              {
                                $total += $row->amount;
                              }
                              $totals[$index] = $total;
                              $last = $total;
                            }else{
                              if($row->mode == 'invoice')
                              {
                                $total -= $row->amount;
                              }
                              elseif($row->mode == 'payment')
                              {
                                $total += $row->amount;
                              }
                              $totals[$index] = $total;
                              $last = $total;
                            }

                          @endphp

                          @if($row->mode == 'invoice')
                            RM {{ number_format($total,2) }}
                          @else
                            RM {{ number_format($total,2) }}
                          @endif

                        </td>
                      </tr>

                    @endforeach

                    <tr>
                      <td>{{ $end_date }}</td>
                      <td>Ending balance {{ $end_date }}</td>
                      <td></td>
                      <td>RM {{ number_format($last,2) }}</td>
                    </tr>
                  </tbody>
                </table>
                <!-- End Invoice Table start here -->
                <div class="gap textRight final">
                  @if( $last < 0 )
                    <h2>Amount Due<br>RM {{ number_format($last,2) }}</h2>
                  @else
                    <h2>Balance Amount<br>RM {{ number_format(abs($last),2) }}</h2>
                  @endif
                </div>
                <!-- Copyright -->
                <div class="textLeft" style="font-size: 12px;height: 50px;">&copy;{{now()->format('Y')}} PSA Transport Sdn Bhd. All Rights Reserved.</div>
    </main>
</body>
</html>
