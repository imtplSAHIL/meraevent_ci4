<?php
$displayHeaderType = $this->uri->segment(1);
$displayMethodType = $this->uri->segment(2);
$createEditDisplayHeader = $this->uri->segment(3);
$userId = $this->customsession->getUserId();
$isLogin = ($userId > 0) ? 1 : 0;
$guestLogin = $this->customsession->getData('isGuestLogin');
$isGuestLogin = ($userId > 0 && $guestLogin > 0) ? 1 : 0;
$isAttendee = $this->customsession->getData('isAttendee');
$isPromoter = $this->customsession->getData('isPromoter');
$isGlobalPromoter = $this->customsession->getData('isGlobalPromoter');
$isOrganizer = $this->customsession->getData('isOrganizer');
$isCollaborator = $this->customsession->getData('isCollaborator');
$isDashboardAccess = 0;
if ($isOrganizer == 1 || $isCollaborator == 1) {
    $isDashboardAccess = 1;
}
$jsExt = $this->config->item('js_gz_extension');
$cssExt = $this->config->item('css_gz_extension');
$jsPublicPath = $this->config->item('js_public_path');
$cssPublicPath = $this->config->item('css_public_path');
$imgStaticPath = $this->config->item('images_static_path');
$apiSearchEventAutocomplete = commonHelperGetPageUrl('api_searchSearchEventAutocomplete');
$apiCommonRequestProcessRequest = commonHelperGetPageUrl('api_commonRequestProcessRequest');
$home = commonHelperGetPageUrl('home');
$printPass = commonHelperGetPageUrl('print_pass');
$pricing = commonHelperGetPageUrl('pricing');
$support = commonHelperGetPageUrl('support');
$createEvent = commonHelperGetPageUrl('create-event');
$userLogin = commonHelperGetPageUrl('user-login');

$noIndex = FALSE;
if ($this->config->item('protocol') == 'http://') {
    $noIndex = TRUE;
}

$viewPageName = $this->uri->segment(1);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $imgStaticPath; ?>apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $imgStaticPath; ?>favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $imgStaticPath; ?>favicon-16x16.png">
        <link rel="shortcut icon" href="<?php echo $imgStaticPath; ?>favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo $imgStaticPath; ?>favicon.ico" type="image/x-icon">
        <link rel="manifest" href="<?php echo $imgStaticPath; ?>site.webmanifest">
        <link rel="mask-icon" href="<?php echo $imgStaticPath; ?>safari-pinned-tab.svg" color="#5f259f">
        <meta name="msapplication-TileColor" content="#fdda24">
        <meta name="theme-color" content="#5f259f">     
        <title><?php echo isset($organizationDetails['seotitle']) ? $organizationDetails['seotitle'] : $pageTitle; ?></title> 
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="shortcut icon" href="<?php echo $imgStaticPath; ?>favicon.ico">
        <script src="<?php echo $jsPublicPath . 'jQuery' . $jsExt; ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'me-font' . $cssExt; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'fa-style' . $cssExt; ?>">
    </head>
    <body class="single-winner">
        <div class="wrapper"> 
            <!--Top Area-->
            <div class="headerSec">
                <div class="float-left">
                    <a href="#" id="mobile-menu-toggle"><span class="icon2-bars" aria-hidden="true"></span></a>
                    <a href="<?php echo $home; ?>" class="logo">
                        <img src="<?php echo $imgStaticPath; ?>me-logo.svg" alt="Mera Events" > 
                    </a>
                </div>
                <div class="float-right">
                    <div class="rightList">
                        <ul>
                            <li class="fs-header-help"> <a href="javascript:void(0)"  id="help-toggle" ><span  class="float-left">Help</span><span class="float-left icon-downarrow"></span>
                                    <ul id="helpdropdown-menu" class="helpdropdown-menu none" role="menu">
                                        <li><a id="printTicket" href='<?php echo $printPass; ?>' target='_blank'>Print Tickets</a></li>
                                        <li><a href="<?php echo $pricing; ?>" target='_blank'>Pricing</a></li>
                                        <li><a href="<?php echo $support; ?>" target='_blank'>Support</a></li>
                                        <li><a href="<?php echo commonHelperGetPageUrl('features'); ?>" target="_blank">Organizer Features</a></li>
                                        <li><a href="<?php echo commonHelperGetPageUrl('why_meraevents'); ?>" target="_blank">Why MeraEvents</a></li>
                                    </ul>
                            </li>
                            <?php if ($isGuestLogin == 0) { ?>
                                <li><a href="<?php echo $createEvent; ?>" class="createBtn">create event</a></li>
                            <?php } ?>
                            <li class="fs-usermenu"  style="cursor: pointer;"> 
                                <a id="user-toggle" onClick="getProfileLink('header');" data-menu="header">
                                    <span class="accessibility">Profile</span>
                                </a>
                                <ul id="dropdown-menu" class="db-usermenu none profile-dropdown" role="menu">
                                    <!-- Ajax dropdown comes here -->
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearBoth"></div>
        </div>