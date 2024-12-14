<?php
$jsExt = $this->config->item('js_gz_extension');
$cssExt = $this->config->item('css_gz_extension');
$jsPublicPath = $this->config->item('js_public_path');
$cssPublicPath = $this->config->item('css_public_path');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Offline Booking</title>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'dashboard' . $cssExt; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'me-font' . $cssExt; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'fa-style' . $cssExt; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'jquery-ui' . $cssExt; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'intlTelInput' . $cssExt; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'common' . $cssExt; ?>">
        <script src="<?php echo $jsPublicPath . 'jQuery' . $jsExt; ?>"></script>
        <script src="<?php echo $jsPublicPath . 'jquery.validate' . $jsExt; ?>"></script>
    </head>
    <div id="dvLoading" class="loadingopacity" style="background-color: rgba(136, 136, 136, 0.4); height: 100%; position: fixed; width: 100%; z-index: 1000;display:none;">
        <img src="<?php echo $this->config->item('images_static_path'); ?>loading.gif" style="left: 50%; opacity: 1; filter: alpha(opacity=100); position: absolute; top: 50%; border-radius: 4px; display: block; background-color: white; -webkit-transform: translate(-50%, -55%); -moz-transform: translate(-50%, -55%); -o-transform: translate(-50%, -55%); -ms-transform: translate(-50%, -55%); transform: translate(-50%, -55%); padding: 30px 70px;" class="loadingimg" />
    </div>