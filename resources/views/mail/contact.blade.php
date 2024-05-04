<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office"
>
  <head>
    <!--[if gte mso 9]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG />
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
    <![endif]-->

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->

    <!-- Your title goes here -->
    <title>Newsletter</title>
    <!-- End title -->

    <!-- Start stylesheet -->
    <style type="text/css">
      a,
      a[href],
      a:hover,
      a:link,
      a:visited {
        /* This is the link colour */
        text-decoration: none !important;
        color: #0000ee;
      }
      .link {
        text-decoration: underline !important;
      }
      p,
      p:visited {
        /* Fallback paragraph style */
        font-size: 15px;
        line-height: 24px;
        font-family: "Helvetica", Arial, sans-serif;
        font-weight: 300;
        text-decoration: none;
        color: #000000;
      }
      h1 {
        /* Fallback heading style */
        font-size: 22px;
        line-height: 24px;
        font-family: "Helvetica", Arial, sans-serif;
        font-weight: normal;
        text-decoration: none;
        color: #000000;
      }
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td {
        line-height: 100%;
      }
      .ExternalClass {
        width: 100%;
      }
    </style>
    <!-- End stylesheet -->
  </head>

  <!-- You can change background colour here -->
  <body
    style="
      text-align: center;
      margin: 0;
      padding-top: 10px;
      padding-bottom: 10px;
      padding-left: 0;
      padding-right: 0;
      -webkit-text-size-adjust: 100%;
      background-color: #f2f4f6;
      color: #000000;
    "
    align="center"
  >
    <!-- Fallback force center content -->
    <div style="text-align: center">

      <!-- Start single column section -->
      <table
        align="center"
        style="
          text-align: left;
          vertical-align: top;
          width: 600px;
          max-width: 600px;
          background-color: #ffffff;
        "
        width="600"
      >
        <tbody>
          <tr>
            <td
              style="
                width: 596px;
                vertical-align: top;
                padding-left: 30px;
                padding-right: 30px;
                padding-top: 30px;
                padding-bottom: 40px;
              "
              width="596"
            >
              <h1>
                <p
                  style="
                    font-size: 15px;
                    line-height: 24px;
                    font-family: &quot;Helvetica&quot;, Arial, sans-serif;
                    font-weight: 400;
                    text-decoration: none;
                    color: #919293;
                  "
                >
                  E-Posta Hesabı :
                  <a
                    target="_blank"
                    style="text-decoration: underline; color: #000000"
                    href="mailto:{{ $email }}"
                    download="HTML Email Template"
                    ><u>{{ $email }}</u></a
                  >
                </p>
              </h1>

              <h1>
                <p
                  style="
                    font-size: 15px;
                    line-height: 24px;
                    font-family: &quot;Helvetica&quot;, Arial, sans-serif;
                    font-weight: 400;
                    text-decoration: none;
                    color: #919293;
                  "
                >
                  İsim :
                  <span style="color: #000000">{{ $name }}</span>
                </p>
              </h1>

              <p
                style="
                  font-size: 15px;
                  line-height: 24px;
                  font-family: &quot;Helvetica&quot;, Arial, sans-serif;
                  font-weight: 400;
                  text-decoration: none;
                  color: #000000;
                "
              >
                {{ $message }}
              </p>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- End single column section -->
    </div>
  </body>
</html>
