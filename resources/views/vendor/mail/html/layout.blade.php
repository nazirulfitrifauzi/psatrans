<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <style>
      /* CLIENT-SPECIFIC STYLES */
      body, table, td, a {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      }
      /* Prevent WebKit and Windows mobile changing default text sizes */
      a {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      color: #848484;
      text-decoration: none;
      }
      /* Prevent WebKit and Windows mobile changing default text sizes */
      table, td {
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
      }
      /* Remove spacing between tables in Outlook 2007 and up */
      img {
      -ms-interpolation-mode: bicubic;
      }
      /* Allow smoother rendering of resized image in Internet Explorer */
      a, a:hover, a:visited, a:active {
      color: #848484;
      }
      /* iOS BLUE LINKS */
      a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
      }
      /* ANDROID CENTER FIX */
      div[style*="margin: 16px 0;"] {
      margin: 0 !important;
      clear: both;
      }
      /* Basics */
      img {
      border: 0;
      height: auto;
      outline: none;
      clear: both;
      }
      table {
      border-collapse: collapse !important;
      border-spacing: 0;
      clear: both;
      font-family: 'Roboto', Arial, sans-serif;
      }
      body {
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;
      background-color: #ffffff;
      font-family: 'Roboto', Arial, sans-serif;
      }
      td {
      padding: 0;
      }
      div[style*="margin: 16px 0"] {
      margin: 0 !important;
      }
      p, b, span, td {
      Margin: 0;
      font-family: 'Roboto', Arial, sans-serif;
      }
    </style>
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    {{ $header ?? '' }}

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                        {{ $subcopy ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{ $footer ?? '' }}
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
