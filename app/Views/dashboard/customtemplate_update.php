<style>
    #div-bg {
        /*height: 200px;
        width: 200px;
        border: 1px solid black;*/
        display: inline-block;
        box-sizing: border-box;
    }

    #btn-color-picker {background: none; border: #000 1px solid; padding: 2px; cursor: pointer; }
    .htmlpage table { box-shadow: none !important;  margin-top:0 !important }
    .htmlpage table tr td { border-bottom: 0px !important; padding:0;; }
    .overflow-a {overflow:auto;}
    .lyrow{
        margin-bottom:10px;
    }
    .divoverflow{
        overflow: hidden;
    }
</style>
<style type="text/css">
    /* Take care of image borders and formatting, client hacks */
    img {outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
    a img {border: none; }
    table {border-collapse: collapse !important; }
    #outlook a {padding: 0; }
    .ReadMsgBody {width: 100%; }
    .ExternalClass {width: 100%; }
    .backgroundTable {margin: 0 auto; padding: 0; width: 100% !important; }
    table td {border-collapse: collapse; }
    .ExternalClass * {line-height: 115%; }
    .container-for-gmail-android {min-width: 600px; }
    /* General styling */

    body {font-family: 'Segoe UI', 'Trebuchet MS', 'calibri', 'Lucida Sans Unicode', 'Lucida Grande', 'Trebuchet MS', 'Tahoma', 'Helvetica Neue', 'Arial', 'sans-serif' !important; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; color: #676767; background-color: #eaf0f2; margin: 0; padding: 0; mso-margin-top-alt: 0px; mso-margin-bottom-alt: 0px; mso-padding-alt: 0px 0px 0px 0px; }
    td {font-family: 'Segoe UI', 'Trebuchet MS', 'calibri', 'Lucida Sans Unicode', 'Lucida Grande', 'Trebuchet MS', 'Tahoma', 'Helvetica Neue', 'Arial', 'sans-serif' !important; text-align: center; }
    a {color: #676767; text-decoration: none !important; }
    .pull-left {text-align: left; }
    .pull-right {text-align: right; }
    .header-lg, .header-md, .header-sm {font-size: 32px; font-weight: 700; line-height: normal; padding: 35px 0 0; color: #4d4d4d; }
    .header-md {font-size: 24px; }
    .header-sm {padding: 5px 0; font-size: 18px; line-height: 1.3; }
    .content-padding {padding: 10px 0 10px 0; }
    .mobile-header-padding-right {width: 290px; text-align: right; padding-left: 10px; }
    .mobile-header-padding-left {width: 290px; text-align: left; padding-left: 10px; }
    .free-text {width: 100% !important; padding: 10px 60px 0px; }
    .block-rounded {border-radius: 5px; border: 1px solid #e5e5e5; vertical-align: top; }
    .button {padding: 30px 0; }
    .info-block {padding: 0 20px; width: 260px; }
    .app-block {padding: 0 20px; }
    .block-rounded {width: 260px; }
    .force-width-gmail {min-width: 600px; height: 0px !important; line-height: 1px !important; font-size: 1px !important; }
    .button-width {width: 228px; }
    .aright {text-align: right; }
    .aleft {text-align: left; }
    .item-col {padding-top: 20px; text-align: left !important; vertical-align: top; }
    .item-total {padding-top: 10px; text-align: left !important; vertical-align: top; }
    .title-dark {text-align: left; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px; }
    .item-table {width: 580px; margin: 0 auto; }
</style>

<style type="text/css" media="only screen and (max-width: 480px)">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {
        td[class="email-content"] {display: block !important; width: 280px !important; text-align: center; }
        table[class*="container-for-gmail-android"] {min-width: 290px !important; width: 100% !important; }
        table[class="w320"] {width: 320px !important; }
        table[class="w320inline"] {width: 320px !important; display: inline !important; }
        td[class="inline"] {display: inline !important; }
        img[class="force-width-gmail"] {display: none !important; width: 0 !important; height: 0 !important; }
        td[class*="mobile-header-padding-left"] {width: 160px !important; padding-left: 0 !important; }
        td[class*="mobile-header-padding-right"] {width: 160px !important; padding-right: 0 !important; }
        td[class="header-lg"] {font-size: 24px !important; padding-bottom: 5px !important; }
        a[class="button-width"], a[class="button-mobile"] {width: 248px !important; }
        td[class="header-md"] {font-size: 18px !important; padding-bottom: 5px !important; }
        td[class="content-padding"] {padding: 5px 0 30px !important; }
        td[class="button"] {padding: 5px !important; }
        td[class*="free-text"] {padding: 10px 18px 30px !important; }
        td[class="info-block"] {display: block !important; width: 280px !important; padding-bottom: 40px !important; }
        td[class="app-block"] {display: block !important; width: 280px !important; padding-bottom: 10px !important; }
        td[class="aright"] {text-align: center; }
        td[class="aleft"] {text-align: center; }
        td[class="w100"] {width: 100% !important; text-align: center; display: inline-block; padding-top: 5px; padding-bottom: 10px; height: auto !important; }
        td[class="item-table"] {padding: 20px 10px !important; }
        td[class="item-total"] {padding-top: 10px; text-align: left !important; vertical-align: top; }
        td[class="hide"] {display: none !important; }
    }
</style>
<!--<form enctype="multipart/form-data" method="post" name="addOrgForm" id="addTemplateForm" action=''>-->

<div class="rightArea">
    <div class="edit">
        <div class="navbar navbar-fixed-top navbar-htmleditor"> <!-- navbar-inverse  -->
            <div class="navbar-header">
                <button data-target="navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="glyphicon-bar"></span>
                    <span class="glyphicon-bar"></span>
                    <span class="glyphicon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="/">Htmleditor</a> -->
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav" id="menu-htmleditor">
                    <li>
                        <div class="btn-group" data-toggle="buttons-radio">
<!--                                <button type="button" id="edit" class="active btn btn-primary"><i class="glyphicon glyphicon-edit "></i> Edit</button>-->
<!--                                <button type="button" class="btn btn-primary" id="sourcepreview"><i class="glyphicon-eye-open glyphicon"></i> Preview</button>-->
                            <button type="button" class="btn btn-warning float-right" id="save_template"><i class="fa fa-save"></i>&nbsp;save</button> <!-- id="save" -->
                        </div>
                        &nbsp;

                    </li>
                </ul>
            </div>
        </div>
        <div class="showMessage"></div>   
        <input type="hidden" value="<?php echo $eventId; ?>" id="eventId" class="eventId" >
        <input type="hidden" value="<?php echo $temp_id; ?>" id="tempId" class="tempId" >
        <input type="hidden" value="<?php echo $temptype; ?>" id="enventType" class="enventType">
        <!-- <div class="container"> -->
        <div class="gridn-container zeromarpad">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sidebar-nav">
                        <div class="each-section">
                            <p class="title">Email Logo</p>
                            <div class="contentholder">
                                <form>
                                    <input type="file" id="image_upload" class="image_upload">
                                </form>
                            </div>
                        </div>
                        <div class="each-section">
                            <p class="title">Elements</p>
                            <div class="contentholder">
                                <!-- elemento paragraph -->
                                <div class="box box-element" data-type="paragraph">
                                    <a href="#close" class="remove btn btn-danger btn-xs"  title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs" title="Move"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" title="Update"><i class="fa fa-gear"></i></a>
                                    </span>
                                    <div class="preview">
                                        <i class="fa fa-font fa-2x"></i>
                                        <div class="element-desc">Paragraph</div>
                                    </div>
                                    <div class="view">
                                        <p>Write Content Here</p>
                                    </div>
                                </div>
                                <!-- Image -->
                                <div class="box box-element" data-type="image">
                                    <a href="#close" class="remove btn btn-danger btn-xs" title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs" title="Move"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" title="Update"><i class="fa fa-gear"></i></a>
                                    </span>
                                    <div class="preview">
                                        <i class="fa fa-picture-o fa-2x"></i>
                                        <div class="element-desc">Image</div>
                                    </div>
                                    <div class="view" id="img_responsive_logo">
                                        <img src="http://placehold.it/586x150" class="img-responsive" id="img_responsive" title="default title"/>
                                    </div>
                                </div>
                                <!-- Button -->
                            </div>
                        </div>
                        <!--                            <div class="each-section">
                                                        <p class="title">Background Color</p>
                                                        <div class="contentholder">
                                                            <button id="email-bg-color-picker" class="btn btn-md">
                                                                <img src="https://phppot.com/demo/changing-div-background-using-bootstrap-colorpicker/ic_color_lens.png" />
                                                            </button>
                                                            <script type="text/javascript">
                                                                $(document).ready(function ($) {
                                                                    $('#email-bg-color-picker').colorpicker();
                                                                    $('#email-bg-color-picker').colorpicker().on('changeColor', function () {
                                                                        $('#email-div-bg').css('background-color', $(this).colorpicker('getValue', '#ffffff'));
                                                                    });
                                                                });
                        
                                                            </script>
                                                        </div>
                                                    </div>-->
                    </div>
                </div>
                <!--col-lg-3-->
                <!--/span-->
                <div class="form-group divoverflow">
                    <div class="col-sm-10">
                        <input type="text" id="email_subject" placeholder="Email Subject" class="form-control email_subject" value="<?php echo empty($templateDetails[0]['subject']) ? $defaultsubject : $templateDetails[0]['subject']; ?>">
                    </div>
                </div>
                <div class="form-group">

                </div>
                <div class="col-lg-8 overflow-a" id="template_content">
                    <?php if (empty($templateDetails)) { ?>  
                        <div class="htmlpage" id="email-div-bg">
                            <table align="center" cellpadding="0" cellspacing="0" width="100%" style="background: #eaf0f2;">
                                <!-- style="background: #eaf0f2;" -->
                                <center>
                                    <tr>
                                        <td align="center" valign="top" class="body-text">
                                            <table align="center" cellpadding="0" cellspacing="0" width="600" style="width: 600px; margin: 0 auto;" class="container-for-gmail-android" bgcolor="#eaf0f2">
                                                <tr>
                                                    <td height="20" style="font-size: 20px; line-height: 20px;"> </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top" width="600">
                                                <center>
                                                    <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
                                                        <tr>
                                                            <td align="left" valign="top" width="600" >
                                                        <center>
                                                            <table cellspacing="0" cellpadding="0" width="100%">
                                                                <tr>
                                                                    <td height="10" style="font-size: 10px; line-height: 10px;"> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="100%" height="60" valign="top" style="text-align: center; vertical-align:middle;">
                                                                <center>
                                                                    <table cellpadding="0" cellspacing="0" width="600" class="w320" align="center">
                                                                        <tr>
                                                                            <td align="center" valign="top" style="vertical-align: middle;">
                                                                               <!-- <a href="http://www.meraevents.com" target="_blank" title="MeraEvents"><img width="54" height="54" src="{meLogo}" alt="MeraEvents" border="0"></a> -->
                                                                                <a href="http://www.meraevents.com" target="_blank" title="MeraEvents"><div id="custom_template_logo" style="padding-top:5px;"><img width="140" src="https://static.meraevents.com/images/static/me-logo.png" alt="MeraEvents" border="0"></div></a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </center>
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" bgcolor="#FFFFFF" style="font-size: 10px; line-height: 10px; background: #eaf0f2;"> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 22px; font-weight: normal; color: #333333;">
                                                                        <div class="lyrow ui-draggable" style="display: block;">
                                                                            <div class="view">
                                                                                <div>
                                                                                    <!-- ui-sortable -->
                                                                                    <div class="col-md-12 column ui-sortable">
                                                                                        <!---->
                                                                                        <div class="box box-element" data-type="paragraph">
                                                                                           <!-- <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a> -->
    <!--                                                                                            <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>-->
                                                                                            <span class="configuration">
                                                                                                <a class="btn btn-xs btn-warning settings"  href="#" title="Update"><i class="fa fa-gear"></i></a>
                                                                                            </span>
                                                                                            <!-- <div class="preview">
                                                                                               <i class="fa fa-font fa-2x"></i>
                                                                                               <div class="element-desc"></div>
                                                                                               </div> -->
                                                                                            <div class="view">
                                                                                                <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                                                                    <tr>
                                                                                                        <td align="left" valign="top" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 22px; font-weight: normal; color: #333333; text-align: center;">
                                                                                                            Hi {userName} <br>Thanks for your order! Your registration is complete.
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" bgcolor="#ffffff" style="font-size: 10px; line-height: 10px;"> </td>
                                                                </tr>
                                                            </table>
                                                        </center>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" width="100%" bgcolor="#FFFFFF" style="background-color: #FFFFFF;">
                                                        <center>
                                                            <table cellspacing="0" cellpadding="0" width="600" class="w320">
                                                                <tr>
                                                                    <td height="20" bgcolor="#FFFFFF" style="font-size: 20px; line-height: 20px;"> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top" style="padding-top: 10px; padding-bottom: 10px;">
                                                                <center>
                                                                    <table cellpadding="0" cellspacing="0" width="600" class="w320" align="center">
                                                                        <tr>
                                                                            <td align="center" valign="top" style="vertical-align: middle;">
                                                                                <img width="136" height="71" src="{emailBoxIcon}" alt="MeraEvents">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </center>
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" style="font-size: 10px; line-height: 10px;"> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 18px; font-weight: normal; color: #333333; line-height: normal;">
                                                                        <a href="{eventUrl}" style="color: #9063cd !important; text-decoration: none; font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 18px; font-weight: bold; ">{eventTitle}</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" style="font-size: 10px; line-height: 10px;"> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 14px; font-weight: normal; color: #333333; line-height: normal;">
                                                                        Please find the e-ticket attached<br>
                                                                        <b>Transaction No : {transactionNumber} </b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" style="font-size: 10px; line-height: 10px;"> </td>
                                                                </tr>
                                                                {customEticketMsg}
                                                                <tr>
                                                                    <td height="15" style="font-size: 15px; line-height: 15px;"> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" width="580" class="w320" align="center" bgcolor="#9063cd" style="background-color:#9063cd;">
                                                                            <tr>
                                                                                <td align="center" valign="middle" class="w100" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 20px; font-weight: normal; color: #FFFFFF; line-height: normal; height: 50px;">
                                                                                    Registration No : {regNumber}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top" style="border-bottom: 1px solid #e5e5e5;">
                                                                        <table cellpadding="0" cellspacing="0" width="580" class="w320" align="center">
                                                                            <tr>
                                                                                <td align="center" valign="middle" class="w100" width="280" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 16px; font-weight: normal; color: #333333; line-height: normal; height: 60px;">
                                                                                    {userName} <br>
                                                                                    {userMobile}
                                                                                </td>
                                                                                <td align="center" valign="middle" class="w100" width="280" style="font-family:'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 16px; font-weight: normal; color: #333333; line-height: normal; height: 60px;">
                                                                                    {userEmail}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="15" style="font-size: 15px; line-height: 15px;"> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" width="560" class="w320" align="center" style="margin:0 auto !important;">
                                                                            <tr>
                                                                                <td align="left" valign="top" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 16px; font-weight: normal; color: #333333; text-align: left; line-height: normal;">Order Summary</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" style="font-size: 10px; line-height: 10px;"> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                    <table cellpadding="0" cellspacing="0" width="560" class="w320" align="center" style="margin:0 auto !important; text-align: center !important;">
                                                                        <tbody><tr>
                                                                                                <td align="left" valign="top" class="title-dark" width="300" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 16px; font-weight: normal; color: #333333; text-align: left; line-height: normal;">
                                                                                                    Ticket
                                                                                                </td>
                                                                                                <td align="left" valign="top" class="title-dark" width="130" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 16px; font-weight: normal; color: #333333; text-align: left; line-height: normal;">
                                                                                                    Qty
                                                                                                </td>
                                                                                                <td align="left" valign="top" class="title-dark" width="130" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 16px; font-weight: normal; color: #333333; text-align: left; line-height: normal;">
                                                                                                    Total
                                                                                                </td>
                                                                                            </tr>
                                                                        </tbody></table></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top" width="100%" style="background-color: #ffffff;text-align: center !important;">
                                                                <center>
                                                                    <table cellpadding="0" cellspacing="0" width="560" class="w320" align="center" style="margin:0 auto !important; text-align: center !important;">
                                                                        <tbody><tr>
                                                                                <td class="item-table">
                                                                                    <table cellspacing="0" cellpadding="0" width="100%" align="center" style="text-align: center !important;">
                                                                                        <tbody>

                                                                                            

                                                                                            {ticketData}

                                                                                            <tr>
                                                                                                <td class="item-col item mobile-row-padding"></td>
                                                                                                <td class="item-col quantity"></td>
                                                                                                <td class="item-col price"></td>
                                                                                            </tr>

                                                                                            {subTotal}
                                                                                            {discountAmount} 	
                                                                                            {ticketTaxes}
                                                                                            {eventextrachargeamount}
                                                                                            {courierfee}

                                                                                            <tr>
                                                                                                
                                                                                                <td align="right" valign="top" colspan="3">
                                                                                                    <table cellspacing="0" cellpadding="0" width="100%" align="right">
                                                                                                        <tbody>
                                                                                                            <tr>  
                                                                                                                <td align="right" class="item-total" style="text-align:right; padding-right: 10px;" width="400">
                                                                                                                    <div class="total-space" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 14px; font-weight: bold; color: #333333; text-align: right !important; line-height: normal;">Total Paid</div>
                                                                                                                </td>
                                                                                                                <td align="right" class="item-total" style="text-align:right; padding-right: 10px;" width="210">
                                                                                                                    <div class="total-space" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 14px; font-weight: bold; color: #333333; text-align: right !important; line-height: normal;">{currencyCode} {totalAmount}</div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>                      
                                                                                            </tr>
                                                                                        </tbody></table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody></table>
                                                                </center>
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20" style="font-size: 20px; line-height: 20px;"> </td>
                                                                </tr>
                                                            </table>
                                                        </center>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" bgcolor="#ffffff" style="background-color: #FFFFFF;  border-top: 1px solid #e5e5e5; ">
                                                                <table cellpadding="0" cellspacing="0" width="600" class="w320inline">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center" valign="top">
                                                                                <table cellpadding="0" cellspacing="0" width="560" class="w320" align="center" style="margin: 0 auto !important;">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td height="20" style="font-size: 20px; line-height: 20px;"> </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="left" valign="top" class="w100" width="280" style="width:280px;font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 16px; font-weight: normal; color: #333333; line-height: normal;text-align: left;">
                                                                                                <table cellpadding="0" cellspacing="0" class="w320" align="center" style="margin: 0 auto !important;">
                                                                                                    <tr>
                                                                                                        <td align="left" valign="top" width="16" height="16"><img src="{eVenueIcon}" width="16" height="16"></td>
                                                                                                        <td align="left" valign="top" style="text-align: left !important;padding-left: 10px;">
                                                                                                            <font style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important;font-size: 14px;color: #333333; text-align: left;">{venue}</font>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td align="left" valign="top" class="w100" width="280" style="width:280px;font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 16px; font-weight: normal; color: #333333; line-height: normal;text-align: left;">
                                                                                                <table cellpadding="0" cellspacing="0" class="w320" align="center" style="margin: 0 auto !important;">
                                                                                                    <tr>
                                                                                                        <td align="left" valign="top" width="16" height="16"><img src="{eDateIcon}" width="16" height="16"></td>
                                                                                                        <td align="left" valign="top" style="text-align: left !important; padding-left: 10px;">
                                                                                                            <font style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important;font-size: 14px;color: #333333;text-align: left;">{eventDate}</font>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                                <p></p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" valign="top" style="border-top: 1px solid #e5e5e5;">
                                                                                <table cellpadding="0" cellspacing="0" width="580" class="w320" align="center" style="margin: 0 auto !important;">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td height="10" style="font-size: 10px; line-height: 10px;"> </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" valign="top" class="w100" width="280" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 14px; font-weight: normal; color: #333333; line-height: normal;text-align: center;">
                                                                                                <a style="color: #333333; font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; text-decoration: none;font-weight: normal; font-size: 14px;"><b>Organizer Email</b><br> </a><a href="mailto:{organizerEmail}" style="color: #333333; text-decoration: none;font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important;font-weight: normal; font-size: 14px; ">{organizerEmail}</a>
                                                                                            </td>
                                                                                            <td align="center" valign="top" class="w100" width="280" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 14px; font-weight: normal; color: #333333; line-height: normal;text-align: center;"><a style="color: #333333; text-decoration: none;font-family:'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important;font-weight: normal; font-size: 14px;"><b>Mobile No</b> <br> {organizerMobile}</a></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="10" style="font-size: 10px; line-height: 10px;"> </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="10" style="height: 10px; line-height: 10px;"> </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="15" style="height: 15px; line-height: 15px;"> </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" width="100%" bgcolor="#FFFFFF" style="background-color: #FFFFFF;">
                                                        <center>
                                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top" style="font-size: 15px; line-height: 15px;" height="15"> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="top">
                                                                            <table cellpadding="0" cellspacing="0" width="100%" align="center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" valign="top" style="font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; font-size: 20px; font-weight: 500; color: #333333;">
                                                                                            Get the MeraEvents app!
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="top" style="font-size: 15px; line-height: 15px;" height="15"> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="top">
                                                                            <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate !important;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="app-block">
                                                                                            <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate !important;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="center" valign="top">
                                                                                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align="right" valign="top" class="aright">
                                                                                                                            <a href="http://bit.ly/meas2017" title="Download From App Store"><img width="142" height="45" class="info-img" src="{eAppStoreIcon}" alt="Download From App Store"></a>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                        <td class="app-block">
                                                                                            <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate !important;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="center" valign="top">
                                                                                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align="left" valign="top" class="aleft">
                                                                                                                            <a href="http://bit.ly/megp2017" title="Download From Play Store"><img width="142" height="45" class="info-img" src="{eplaystoreicon}" alt="Download From Play Store"></a>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="top" style="font-size: 20px; line-height: 20px;" height="20"> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="top" bgcolor="#ffffff" style="background-color: #FFFFFF;  border-top: 1px solid #e5e5e5; ">
                                                                            <table cellpadding="0" cellspacing="0" width="600" class="w320inline">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" valign="top" style="padding-top:10px; padding-bottom:10px; ">
                                                                                            <table cellpadding="0" cellspacing="0" align="center" width="100%" style="border-collapse:separate !important;">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="center" valign="top" class="email-content">
                                                                                                            <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate !important;">
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align="left" valign="top">
                                                                                                                            <table cellspacing="0" cellpadding="0" width="100%" align="center">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td align="center" valign="top">
                                                                                                                                            <a style="color: #333333; font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; text-decoration: none;font-weight: normal; font-size: 14px;">Email Us : </a><a href="mailto:support@meraevents.com" style="color: #333333; text-decoration: none;font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important;font-weight: normal; font-size: 14px; ">{supportEmail}</a>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                        <td align="left" valign="top" class="email-content">
                                                                                                            <table cellpadding="0" cellspacing="0" width="100%" align="center" style="border-collapse:separate !important;">
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align="left" valign="top">
                                                                                                                            <table cellspacing="0" cellpadding="0" width="100%" align="center">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td align="center" valign="top">
                                                                                                                                            <a style="color: #333333; text-decoration: none;font-family:'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important;font-weight: normal; font-size: 14px;">Call Us : {supportPhone}</a>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td height="10" style="height: 10px; line-height: 10px;"> </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </center>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" style="font-size: 20px; line-height: 20px;" height="20"> </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" style="text-align: center; width: 320px; margin: 0 auto;">
                                                        <center>
                                                            <table border="0" align="center" cellpadding="0" cellspacing="0" width="320" style="text-align: center; width: 320px; margin: 0 auto;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top">
                                                                <center>
                                                                    <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 180px; margin: 0 auto; text-align: center;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="28" height="28">
                                                                                    <a style="display: block; width: 28px; height: 28px; border-style: none !important; border: 0 !important;" href="http://www.facebook.com/meraeventsindia" title="Facebook" target="_blank"><img width="28" height="28" border="0" style="display: block; width: 28px; height: 28px;" src="{fbemailicon}" alt="Facebook"></a>
                                                                                </td>
                                                                                <td width="10">  </td>
                                                                                <td width="28" height="28">
                                                                                    <a style="display: block; width: 28px; height: 28px; border-style: none !important; border: 0 !important;" href="http://twitter.com/#!/meraeventsindia" title="Twitter" target="_blank"><img width="28" height="28" border="0" style="display: block; width: 28px; height: 28px;" src="{twitteremailicon}" alt="Twitter"></a>
                                                                                </td>
                                                                                <td width="10">  </td>   
                                                                                <td width="28" height="28">
                                                                                    <a style="display: block; width: 28px; height: 28px; border-style: none !important; border: 0 !important;" href="https://www.instagram.com/meraeventsindia/" title="Instagram" target="_blank"><img width="28" height="28" border="0" style="display: block; width: 28px; height: 28px;" src="{instagramemailicon}" alt="Instagram"></a>
                                                                                </td>
                                                                                <td width="10">  </td>
                                                                                <td width="28" height="28">
                                                                                    <a style="display: block; width: 28px; height: 28px; border-style: none !important; border: 0 !important;" href="https://www.linkedin.com/company/meraevents" title="Linkedin" target="_blank"><img width="28" height="28" border="0" style="display: block; width: 28px; height: 28px;" src="{linkedinemailicon}" alt="Linkedin"></a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </center>
                                                                </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </center>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" style="font-size: 10px; line-height: 10px;" height="10"> </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" style="color: #666666; font-size: 12px; font-family: 'Segoe UI','Trebuchet MS','calibri','Lucida Sans Unicode','Lucida Grande','Trebuchet MS','Tahoma','Helvetica Neue','Arial','sans-serif' !important; mso-line-height-rule: exactly;">
                                                                <p style="padding: 0; color: #666666; margin: 0;font-weight: normal; line-height: 20px;">This order is subject to MeraEvents <a href="http://www.meraevents.com/terms" style="color: #9063cd; text-decoration: none; font-weight: normal;">Terms & Conditions</a>, <a href="http://www.meraevents.com/privacypolicy" style="color: #9063cd; text-decoration: none; font-weight: normal;">Privacy Policy</a></p>
                                                                <p style="padding: 0; color: #666666; margin: 0;font-weight: normal; line-height: 20px;">You are received this email because you have been registered/subscribed with <a href="http://www.meraevents.com" style="color: #666666; text-decoration: none; font-weight: normal;">MeraEvents.com</a></p>
                                                                <p style="padding: 0; color: #666666; margin: 0;font-weight: normal; line-height: 20px;">To be sure that you receive our e-mail in your inbox, please add MeraEvents to your address book.</p>
                                                                <p style="padding: 0; color: #666666; margin: 0;font-weight: normal; line-height: 20px;">© 2017 Versant Online Solutions Pvt Ltd. All Rights Reserved.</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" style="font-size: 30px; line-height: 30px;" height="30"> </td>
                                                        </tr>
                                                    </table>
                                                </center>
                                        </td>
                                    </tr>
                            </table>

                            </td>
                            </tr>
                            </center>
                            </table>
                        </div>
                    <?php } else { ?>
                        <?php echo $templateDetails[0]['template']; ?>
                    <?php } ?>
                </div>
                <!-- col-lg-8 -->
            </div> <!-- row end -->           
            <!--Modal Popup Code-->
            <div class="modal fade" id="download" tabindex="-1" role="dialog" aria-labelledby="download" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class='fa fa-save'></i>&nbsp;Save as </h4>
                        </div>
                        <div class="modal-body" id='sourceCode'>
                            <textarea id="src" rows="10"></textarea>
                            <textarea id="model" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-close'></i>&nbsp;Close</button>
                            <button type="button" class="btn btn-success" id="srcSave"><i class='fa fa-save'></i>&nbsp;Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="preferences" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="preferencesTitle"></h4>
                        </div>
                        <div class="modal-body" id="preferencesContent">
                            <!--<iframe src="media-popup.php" style="width:100%; height:300px ; display:none;" frameborder="0" ></iframe>-->
                            <div id="mediagallery" style="overflow:auto;height:400px; display:none">
                                <?php include "media-popup.php"; ?>
                                <a class="btn btn-info" href="javascript:;" onclick="$('#mediagallery').hide();$('#thepref').show();">Return to image settings</a>
                            </div>
                            <div id="thepref">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#Settings" aria-controls="Settings" role="tab" data-toggle="tab">Settings</a></li>
                                    <!--                                        <li role="presentation"><a href="#CellSettings" aria-controls="profile" role="tab" data-toggle="tab">Cell settings</a></li>
                                                                            <li role="presentation"><a href="#RowSettings" aria-controls="messages" role="tab" data-toggle="tab">Row settings</a></li>-->
                                </ul>
                                <form id="image_upload_form" class="image_upload_form" enctype="multipart/form-data" method="post">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="Settings">
                                            <!-- header -->
                                            <div class="panel panel-body">
                                                <div id="ht" style="display: none;">
                                                    <textarea id="html5editorLite"></textarea>
                                                </div>
                                                <!-- fine header -->
                                                <!-- text -->
                                                <div id="text" style="display: none;">
                                                    <textarea id="html5editor"></textarea>
                                                </div>
                                                <!-- end text -->
                                                <!-- settaggio immagine -->
                                                <div id="image" style="display:none">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <!--                                                            <div id="imgContent">
                                                                                                                        </div>-->
                                                                                                                        <!-- <a class="btn btn-default form-control" href="#" id="gallery"><i class="icon-upload-alt"></i>&nbsp;Browse ...</a> -->
                                                            <input type="file" id="upload_image" class="upload_image" name="upload_image">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <!--                                                            <div class="form-group">
                                                                                                                            <label for="img-url">Url :</label>
                                                                                                                            <input type="text" value="" id="img-url" class="form-control" />
                                                                                                                        </div>-->
                                                            <!--   <div class="form-group">
                                                                               <label for="img-url">Click Url:</label>
                                                                               <input type="text" value="" id="img-clickurl" class="form-control" />
                                                                           </div>
                                                            -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="img-width">Width :</label>
                                                                        <input type="text" value="" id="img-width" class="form-control" name="img_width"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="img-height">Height :</label>
                                                                        <input type="text" value="" id="img-height" class="form-control"  name="img_height"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="img-title">Title : </label>
                                                                <input type="text" value="" id="img-title" class="form-control" name="image_title"/>
                                                            </div>
                                                            <!--                                                            <div class="form-group">
                                                                                                                            <label for="img-rel">Rel :</label>
                                                                                                                            <input type="text" value="" id="img-rel" class="form-control" />
                                                                                                                        </div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- fine settaggi immagine -->
                                                <!-- settaggio youtube -->
                                                <div id="youtube" style="display:none">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="youtube-video">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <form>
                                                                <div class="form-group">
                                                                    <label for="video-url">Video id :</label>
                                                                    <input type="text" value="" id="video-url" class="form-control" />
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="video-width">Width :</label>
                                                                            <input type="text" value="" id="video-width" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="video-height">Height :</label>
                                                                            <input type="text" value="" id="video-height" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- fine settagio youtube -->
                                                <!-- settaggio mappa -->
                                                <div id="map" style="display:none">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="map-content">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <form>
                                                                <div class="form-group">
                                                                    <label for="address">Latitude :</label>
                                                                    <input type="text" value="" id="latitude" class="form-control" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="address">Longitude :</label>
                                                                    <input type="text" value="" id="longitude" class="form-control" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="address">Zoom :</label>
                                                                    <input type="text" value="" id="zoom" class="form-control" />
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="img-width">Width :</label>
                                                                            <input type="text" value="" id="map-width" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="img-height">Height :</label>
                                                                            <input type="text" value="" id="map-height" class="form-control" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- settaggio bottone -->
                                                <div id="buttons" style="display:none">
                                                    <div id="buttonContainer"></div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label> Label : </label>
                                                        <input type="text" class="form-control" id="buttonLabel" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label> Href : </label>
                                                        <input type="text" class="form-control" id="buttonHref" />
                                                    </div>
                                                    <span class="btn-group btn-group-xs">
                                                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">Styles <span class="caret"></span></a>
                                                        <ul class="dropdown-menu">
                                                            <li class=""><a href="#" class="btnpropa" rel="btn-default">Default</a></li>
                                                            <li class=""><a href="#" class="btnpropa" rel="btn-primary">Primary</a></li>
                                                            <li class=""><a href="#" class="btnpropa" rel="btn-success">Success</a></li>
                                                            <li class=""><a href="#" class="btnpropa" rel="btn-info">Info</a></li>
                                                            <li class=""><a href="#" class="btnpropa" rel="btn-warning">Warning</a></li>
                                                            <li class=""><a href="#" class="btnpropa" rel="btn-danger">Danger</a></li>
                                                            <li class=""><a href="#" class="btnpropa" rel="btn-link">Link</a></li>
                                                        </ul>
                                                    </span>
                                                    <span class="btn-group btn-group-xs">
                                                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">Size <span class="caret"></span></a>
                                                        <ul class="dropdown-menu">
                                                            <li class=""><a href="#" class="btnpropb" rel="btn-lg">Large</a></li>
                                                            <li class=""><a href="#" class="btnpropb" rel="btn-default">Default</a></li>
                                                            <li class=""><a href="#" class="btnpropb" rel="btn-sm">Small</a></li>
                                                            <li class=""><a href="#" class="btnpropb" rel="btn-xs">Mini</a></li>
                                                        </ul>
                                                    </span>
                                                    <span class="btn-group btn-group-xs">
                                                        <a class="btn btn-xs btn-default btnprop" href="#" rel="btn-block">Block</a>
                                                        <a class="btn btn-xs btn-default btnprop" href="#" rel="active">Active</a>
                                                        <a class="btn btn-xs btn-default btnprop" href="#" rel="disabled">Disabled</a>
                                                    </span>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label> Custom width / height / font-size / padding top : </label>
                                                        <br>
                                                        <span class="btn-group">
                                                            <input type="text"  id="custombtnwidth" style="width:20%"/>
                                                            <input type="text"  id="custombtnheight" style="width:20%"/>
                                                            <input type="text"  id="custombtnfont" style="width:20%"/>
                                                            <input type="text"  id="custombtnpaddingtop" style="width:20%"/>
                                                        </span>
                                                    </div>
                                                </div>
                                                <!-- fine bottone-->
                                                <!-- settaggio code -->
                                                <div id="code" style="display:none">
                                                </div>
                                                <!-- fine code -->
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="CellSettings">
                                            <div class="panel panel-body">
                                                <table width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #cccccc" id="tabCol">
                                                    <tr>
                                                        <td>&nbsp;Margin</td>
                                                        <td></td>
                                                        <td><input type="text" size="4" class="form-control text-center" data-ref="margin-top" /></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td bgcolor="#f2f2f2">Padding</td>
                                                        <td bgcolor="#f2f2f2"><input type="text" size="4" class="form-control text-center" data-ref="padding-top" /></td>
                                                        <td bgcolor="#f2f2f2"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" size="4" class="form-control text-center" data-ref="margin-left"></td>
                                                        <td bgcolor="#f2f2f2"><input type="text" size="4" class="form-control text-center" data-ref="padding-left"></td>
                                                        <td bgcolor="#f2f2f2"></td>
                                                        <td bgcolor="#f2f2f2"><input type="text" size="4" class="form-control text-center" data-ref="padding-right"></td>
                                                        <td><input type="text" size="4" class="form-control text-center" data-ref="margin-right"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td bgcolor="#f2f2f2"></td>
                                                        <td bgcolor="#f2f2f2"><input type="text" size="4" class="form-control text-center" data-ref="padding-bottom"></td>
                                                        <td bgcolor="#f2f2f2"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" size="4" class="form-control text-center" data-ref="margin-bottom"></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!--
                                                                    <div class="form-group">
                                                                        <label>Css class :</label>
                                                                        <input type="text" class="form-control" id="colcss" />
                                                                    </div>
                                                        -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="RowSettings">
                                            <div class="panel panel-body">
                                                <table width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #cccccc" id="tabRow">
                                                    <tr>
                                                        <td>&nbsp;Margin</td>
                                                        <td></td>
                                                        <td><input type="text" size="4" class="form-control text-center" data-ref="margin-top" /></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td bgcolor="#f2f2f2">Padding</td>
                                                        <td bgcolor="#f2f2f2"><input type="text" size="4" class="form-control text-center" data-ref="padding-top" /></td>
                                                        <td bgcolor="#f2f2f2"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" size="4" class="form-control text-center" data-ref="margin-left"></td>
                                                        <td bgcolor="#f2f2f2"><input type="text" size="4" class="form-control text-center" data-ref="padding-left"></td>
                                                        <td bgcolor="#f2f2f2"></td>
                                                        <td bgcolor="#f2f2f2"><input type="text" size="4" class="form-control text-center" data-ref="padding-right"></td>
                                                        <td><input type="text" size="4" class="form-control text-center" data-ref="margin-right"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td bgcolor="#f2f2f2"></td>
                                                        <td bgcolor="#f2f2f2"><input type="text" size="4" class="form-control text-center" data-ref="padding-bottom"></td>
                                                        <td bgcolor="#f2f2f2"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" size="4" class="form-control text-center" data-ref="margin-bottom"></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-close'></i>&nbsp;Close</button>
                                <button type="button" class="btn btn-primary" id="applyChanges"><i class='fa fa-check'></i>&nbsp;Apply changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Small modal for alert-->
                <!--/span-->
                <div id="download-layout">
                    <div class="container"></div>
                </div>
            </div>
        </div> <!-- gridn-container zeromarpad -->
    </div> <!-- edit -->
</div> <!-- right area -->
<script>
    var api_promoteofflineTickets = "<?php echo commonHelperGetPageUrl('api_promotecustomimageupload'); ?>";
    var api_customTemplateInsert = "<?php echo commonHelperGetPageUrl('api_customTemplateInsert'); ?>";
    var redirect_customtemplate = "<?php echo commonHelperGetPageUrl('custom-email-template', $eventId); ?>";
    $(document).ready(function (e) {

        $('#image_upload_form').on('submit', (function (e) {
            e.preventDefault();
            var senddata = new FormData();
            //Form data
            var form_data = $('#image_upload_form').serializeArray();
            $.each(form_data, function (key, input) {
                senddata.append(input.name, input.value);
            });

            //File data
            var file_data = $('input[name="upload_image"]')[0].files;
            var ext = $('input[name="upload_image"]').val().split('.').pop().toLowerCase();

            if (ext != '') {
                if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert('This is not an allowed file type.');
                    return false;
                }
                if ($('input[name="upload_image"]')[0].files[0].size > 2000000) {
                    alert("Please upload file less than 2MB. Thanks!!");
                    return false;
                }
            }

            for (var i = 0; i < file_data.length; i++) {
                senddata.append("upload_image[]", file_data[i]);
            }
            //Custom data
            senddata.append('key', 'value');
            var url = api_promoteofflineTickets;
            $.ajax({
                type: 'POST',
                url: url,
                data: senddata,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#preferences").modal('hide');
                    $('#img_responsive_logo img').attr('src', data.imagepath);
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }));
        $(document).on("click", "#applyChanges", function () {
            $("#image_upload_form").submit();
        });
        $('#save_template').click(function () {
            var event_content = $('#template_content').html();
            var eventId = $('#eventId').val();
            var emailsubject = $('#email_subject').val();
            var enventType = $('#enventType').val();
            var temp = $('#tempId').val();
            var url = api_customTemplateInsert;

            $.ajax({
                type: 'POST',
                url: url,
                data: {template_content: event_content, emailsubject: emailsubject, eventId: eventId, enventType: enventType, tempId: temp},
                cache: false,
                //contentType: 'html',
                // processData: false,
                success: function (data) {
                    if (data == 1) {
                        $(".showMessage").html("<div class='db-alert db-alert-success flashHide'><strong>Email template insert successful</strong></div>");
                        //setTimeout("window.location.href="+redirect_customtemplate, 400);
                        var timeoutID = setTimeout(function () {
                            window.location.href = redirect_customtemplate;
                        }, 1500);
                    } else {
                        $(".showMessage").html("<div id='Message' class='db-alert db-alert-danger flashHide'><strong>Email template insert fails</strong></div>");
                    }

                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });
        })
        $("#image_upload").change(function () {
            //Here is where you will make your AJAX call
            var file_data = $(this)[0].files;
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert('This is not an allowed file type.');
                return false;
            }
            if ($(this)[0].files[0].size > 2000000) {
                alert("Please upload file less than 2MB. Thanks!!");
                return false;
            }

            var senddata = new FormData();
            for (var i = 0; i < file_data.length; i++) {
                senddata.append("upload_image[]", file_data[i]);
            }
            var url = api_promoteofflineTickets;
            $.ajax({
                type: 'POST',
                url: url,
                data: senddata,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#custom_template_logo img').attr('src', data.imagepath);
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });
        });
    });
</script>