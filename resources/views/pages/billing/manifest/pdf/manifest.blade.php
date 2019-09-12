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
      margin: 0cm 0cm;
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
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="contentSection">
        <tbody>
          <tr>
            <td align="left" valign="middle" width="100%">
              <h1>Manifest Listing</h1>
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

                @if(!empty($destination_name))
                <div class="gap">Destination Name: {{ $destination_name->destination_name }}</div>
                @else
                @endif

                <!-- Invoice start here -->
                <table width="100%" colspacing="0" border="0" style="border-collapse: collapse;" class="contentSection gap">
                  <thead>
                    <tr>
                      <th align="left" valign="middle" width="25%">Date/Time</th>
                      <th align="left" valign="middle" width="30%">Shipper</th>
                      <th align="left" valign="middle" width="15%">CN No</th>
                      <th align="left" valign="middle" width="20%">Receiver</th>
                      <th align="left" valign="middle" width="10%">Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($consignment as $index => $row)
                      @php
                        $newdate = date_create($row->cn_datetime);
                      @endphp
                      <tr>
                        <td>{{ date_format($newdate,"d M y, h:i a") }}</td>
                        <td>{{ $row->shipper_name }}</td>
                        <td>{{ $row->cn_no }}</td>
                        <td>{{ $row->receiver_name }}</td>
                        <td>{{ $row->quantity }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <!-- Copyright -->
                <div class="gap textLeft" style="font-size: 12px;height: 50px;">&copy;{{now()->format('Y')}} PSA Transport Sdn Bhd. All Rights Reserved.</div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </main>
</body>
</html>
