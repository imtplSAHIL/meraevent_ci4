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
    /*$profileImagePath = $this->customsession->getData('profileImagePath');
      $profileImage = commonHelperDefaultImage($profileImagePath, 'userprofile'); */
    
   <?php
  if($content=='ticketregistration_view' || $content=='ticket_widget_template_reg_info'){
     $jsExt = '.min.js';
   }else{
     $jsExt = $this->config->item('js_gz_extension');
    }
   ?>
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
	if($this->config->item('protocol') == 'http://'){
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
        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var https_url = '<?php echo https_url(); ?>';
            var cookie_expiration_time = "<?php echo COOKIE_EXPIRATION_TIME; ?>";
            var api_path = '<?php echo $this->config->item('api_path'); ?>';
            var images_static_path = '<?php echo $imgStaticPath; ?>';
            var api_getProfileDropdown = "<?php echo commonHelperGetPageUrl('api_getProfileDropdown') ?>";
            var uploadUrl ="<?php echo $this->config->item('protocol').$_SERVER['HTTP_HOST'].'/js/public/tinymce/plugins/jbimages/dialog-v4.php'; ?>";
        </script>
        <script>
            var api_searchSearchEventAutocomplete = "<?php echo $apiSearchEventAutocomplete; ?>";
            var api_commonRequestProcessRequest = "<?php echo $apiCommonRequestProcessRequest; ?>";
            var recommendationsEnable="<?php echo $this->config->item('recommendationsEnable')?"1":"0";?>";
        </script>
        <script src="<?php echo $jsPublicPath . 'jQuery' . $jsExt; ?>"></script>        
        <?php
        if (($displayHeaderType == "dashboard" || $displayHeaderType == "profile" || $displayHeaderType == "promoter" || $displayHeaderType == "currentTicket" || $displayHeaderType == "networking" || $displayHeaderType == "checkin" || $displayHeaderType == "pastTicket" || $displayHeaderType == "noAccess" || $displayHeaderType == "referalBonus" || $displayHeaderType == "mywallet") && $createEditDisplayHeader != "create" && $createEditDisplayHeader != "edit") {
            if($guestLogin == 1){ header("Location:".site_url()."logout"); exit; }
            ?>
            <title><?php echo $pageTitle ?></title>
            <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'dashboard'. $cssExt; ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'me-font' . $cssExt; ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'fa-style' . $cssExt; ?>">
            <link rel="stylesheet" href="<?php echo $cssPublicPath . 'jquery-ui' . $cssExt; ?>">
            <script src="<?php echo $jsPublicPath . 'jquery.validate' . $jsExt; ?>"></script>
            <?php
            if (isset($jsTopArray) && is_array($jsTopArray)) {
                foreach ($jsTopArray as $js) {
                    echo '<script src="' . $js . $jsExt . '"></script>';
                    echo "\n";
                }
            }
            ?>
            <?php
            if (isset($cssArray) && is_array($cssArray)) {
                foreach ($cssArray as $cssFile) {
                    echo '<link rel="stylesheet" type="text/css" href="' . $cssFile . $cssExt . '">';
                    echo "\n";
                }
            }
            ?>
            
            
        </head>
        <!--   we are adding pageurl as a class name   --->
        <body class="bodyLeft <?php echo ($this->uri->segment(2)) ? 'page-' . $this->uri->segment(2) : 'page-' . $this->uri->segment(1); ?>" <?php if (isset($moduleName)) {
                echo "ng-app=" . $moduleName;
            } ?>>
            <div id="dvLoading" class="loadingopacity" style="display:none;background-color: rgba(136, 136, 136, 0.4);
                 height: 100%;
                 position: fixed;
                 width: 100%;
                 z-index: 1000;opacity: 1;
                 filter: alpha(opacity=100);"><img src="<?php echo $this->config->item('images_static_path'); ?>loading.gif" class="loadingimg" alt="Loading.." style="left: 50%;
                   opacity: 1;
                   filter: alpha(opacity=100);
                   position: absolute;
                   top: 50%;
                   border-radius: 4px;
                   display: block;
                   background-color: white;
                   -webkit-transform: translate(-50%, -55%);
                   -moz-transform: translate(-50%, -55%);
                   -o-transform: translate(-50%, -55%);
                   -ms-transform: translate(-50%, -55%);
                   transform: translate(-50%, -55%);
                   padding: 30px 70px;" /></div>
                   <div id="menudvLoading" class="menuloadingopacity" style="display:none;"><img src="<?php echo $imgStaticPath; ?>loading.gif" class="menuloadingimg" alt="Loading.."/></div>
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
                            <ul >
                                 <?php if ($isGuestLogin == 0 && $isGlobalPromoter==0 && $isOrganizer==0) { ?>
                                <li><a href="<?php echo commonHelperGetPageUrl('dashboard-global-affliate'); ?>" class="createBtn">Become an affiliate</a></li>
                                <?php } ?>
                                <li class="fs-header-help"> <a href="javascript:void(0)"  id="help-toggle" ><span  class="float-left">Help</span><span class="float-left icon-downarrow"></span>
                                        <ul id="helpdropdown-menu" class="helpdropdown-menu none" role="menu">
                                            <li><a id="printTicket" href='<?php echo $printPass; ?>' target='_blank'>Print Tickets</a></li>
                                            <li><a href="<?php echo $pricing; ?>" target='_blank'>Pricing</a></li>
                                            <li><a href="<?php echo $support; ?>" target='_blank'>Support</a></li>
                                            <li><a href="<?php echo commonHelperGetPageUrl('features');?>" target="_blank">Organizer Features</a></li>
                                            <li><a href="<?php echo commonHelperGetPageUrl('why_meraevents');?>" target="_blank">Why MeraEvents</a></li>
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
    <?php if ($displayMethodType == "pastEventList" || ($displayHeaderType == "dashboard" && $displayMethodType == null)) { ?>
                    <?php
                }
            } else {
                ?>
                <title><?php echo isset($organizationDetails['seotitle']) ? $organizationDetails['seotitle'] : $pageTitle; ?></title> 
                <meta name="viewport" content="width=device-width,initial-scale=1.0">
                <meta name="apple-mobile-web-app-capable" content="yes">
                <?php if ($seoStaus) { ?>
                    <meta name="description" http-equiv="description" content="<?php echo $seoDescription; ?>">
                    <meta name="keywords" http-equiv="keywords" content="<?php echo $pageKeywords; ?>" />
                    <?php if (!empty($canonicalurl)) { ?>
                        <link rel="canonical" href="<?php echo $canonicalurl; ?>"/>  <?php } ?>
        <?php
                } else if ($defaultCityId > 0) {
        ?>
                    <meta name="description" http-equiv="description" content="Buy tickets & passes online for upcoming events in <?php echo $defaultCityName; ?>, live concerts, and events happening in <?php echo $defaultCityName; ?>. Book latest events at MeraEvents.com">
                    <meta name="keywords" http-equiv="keywords" content="Events in <?php echo $defaultCityName; ?>,Upcoming Events in <?php echo $defaultCityName; ?>,Latest Events in <?php echo $defaultCityName; ?>,Events in <?php echo $defaultCityName; ?>,<?php echo $defaultCityName; ?> Events,Events in <?php echo $defaultCityName; ?> Today,Events in <?php echo $defaultCityName; ?> this weekend,<?php echo $defaultCityName; ?> upcoming events,upcoming events <?php echo $defaultCityName; ?>,live concert events in <?php echo $defaultCityName; ?>,Latest Events in <?php echo $defaultCityName; ?>" />
                <?php } else if($viewPageName == "o") { ?>
                    <meta name="description" http-equiv="description" content="<?php echo isset($organizationDetails['seodescription']) ? $organizationDetails['seodescription'] : "MeraEvents.com is India's largest portal solely dedicated to Online Event promotions Upcoming Events Professional conferences Professional Events It offers many unique features.post your event and brand in front of a highly targeted audience with massive influence."; ?>">
                    <meta name="keywords" http-equiv="keywords" content="<?php echo isset($organizationDetails['seokeywords']) ? $organizationDetails['seokeywords'] : "Current Events, Corporate Events Online Portals, Event Solutions, Event Management, Cultural, Event Management in Companies, Events, Meeting and Conferences, Special Event ticket booking, seminars, conferences, concert, upcoming events , today, weekend"; ?>" />
        <?php }else{ ?>
                    <meta name="description" http-equiv="description" content="MeraEvents.com is India's largest portal solely dedicated to Online Event promotions Upcoming Events Professional conferences Professional Events It offers many unique features.post your event and brand in front of a highly targeted audience with massive influence.">
                    <meta name="keywords" http-equiv="keywords" content="Current Events, Corporate Events Online Portals, Event Solutions, Event Management, Cultural, Event Management in Companies, Events, Meeting and Conferences, Special Event ticket booking, seminars, conferences, concert, upcoming events , today, weekend" />
        <?php } ?>
        <?php if (isset($noIndex) && $noIndex) { ?>
            <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <?php } ?>
                    <meta name="author" content="MeraEvents" />
                    <meta name="rating" content="general" />          
<!--Twitter Card data-->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="MeraEvents.com">
<meta name="twitter:title" content="<?php echo isset($sharing_pageTitle) ? $sharing_pageTitle : $pageTitle; ?>">
<meta name="twitter:description" content="Buy tickets & passes online for upcoming events in <?php echo $defaultCityName; ?>, live concerts, and events happening in <?php echo $defaultCityName; ?>. Book latest events at MeraEvents.com">
<meta name="twitter:creator" content="MeraEvents">
<meta name="twitter:image" content="https://static.meraevents.com/images/static/me-logo-200.png">
<!-- Open Graph data -->
<meta property="og:title" content="<?php echo isset($sharing_pageTitle) ? $sharing_pageTitle : $pageTitle; ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.meraevents.com/" />
<meta property="og:image" content="https://static.meraevents.com/images/static/me-logo-200.png" />
<meta property="og:description" content="Buy tickets & passes online for upcoming events in <?php echo $defaultCityName; ?>, live concerts, and events happening in <?php echo $defaultCityName; ?>. Book latest events at MeraEvents.com" />
<meta property="og:site_name" content="MeraEvents.com" />
<meta property="fb:admins" content="125923692046" />
                <link rel="shortcut icon" href="<?php echo $imgStaticPath; ?>favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'me_custom'.$cssExt; ?>">

    <?php
    if (isset($cssArray) && is_array($cssArray)) {
        foreach ($cssArray as $cssFile) {
            echo '<link rel="stylesheet" type="text/css" href="' . $cssFile . $cssExt . '">';
            echo "\n";
        }
    }
    ?>
                <script type="text/javascript">
                    var defaultCountryId = '<?php echo $defaultCountryId; ?>';
                    var defaultCityName = '<?php echo $defaultCityName; ?>';
                    var defaultCityId = '<?php echo $defaultCityId; ?>';
                    var defaultSplCityStateId = '<?php echo $defaultSplCityStateId; ?>';
                    var defaultSubCategoryId = '<?php echo $defaultSubCategoryId; ?>';
                    var defaultSubCategoryName = '<?php echo $defaultSubCategoryName; ?>';
                    var defaultCountryName = '<?php echo $defaultCountryName; ?>';
                    var label_nomore_events = '<?php echo ERROR_NO_MOR_EVENTS; ?>';
                    var client_ajax_call_api_key = '<?php echo $this->config->item('client_ajax_call_api_key'); ?>';
                    var _paq=[];
                    var selectedSubcategoryId = <?php echo isset($selectedSubcategoryId) ? "[".implode(',',$selectedSubcategoryId)."]" : "\"\"" ?>;
                </script>
<?php if ($this->config->item('tsFeedbackEnable')) { ?>
<!--truesemantic feedback form -->
<script type="text/javascript">
var tsa = {auth:[], activity_data:{}, user_data:{}};
</script>
<?php }
?>
<!--truesemantic feedback form -->

    <?php
    if (isset($jsTopArray) && is_array($jsTopArray)) {
        foreach ($jsTopArray as $js) {
            echo '<script src="' . $js . $jsExt . '"></script>';
            echo "\n";
        }
    }
    ?>
                <link rel="stylesheet" href="<?php echo $cssPublicPath . 'jquery-ui' . $cssExt; ?>">

                <?php if(strlen($displayHeaderType) == 0 || $displayHeaderType == "payment" || $displayHeaderType == "confirmation" || $displayHeaderType == "login" || $displayHeaderType == "signup"){ include("elements/googletagmanagercode.php"); } ?>

                </head>
                <body class="single-winner" <?php if (isset($moduleName)) {
                echo "ng-app=" . $moduleName;
            } ?>>
                    <div id="dvLoading" class="loadingopacity" style="display:none;"><img src="<?php echo $imgStaticPath; ?>loading.gif" class="loadingimg" /></div>
                    <div id="menudvLoading" class="menuloadingopacity" style="display:none;"><img src="<?php echo $imgStaticPath; ?>loading.gif" class="menuloadingimg" /></div>
                  
                        <?php if((isset($hideGlobalAffiliateHeader) && $hideGlobalAffiliateHeader == 0) || !isset($hideGlobalAffiliateHeader)){ // include_once 'elements/affiliate_common_header.php';
 } ?>
                    <div class="site-container">
                        <!-- global header 
                        <?php if( (!(isset($_COOKIE['fcPromo']) && $_COOKIE['fcPromo']==1)) && $content =='home_view' ) { ?>
                        <div id="promobar-header" style="display: block;">  
                            <div class="promotionbar">      
                                <div class="promotionbar-inner">
                                    <div class="promotionbar-closebutton">X</div>           
                                    <strong>Get Rs.75 FreeCharge Cashback this Holi season.</strong> Buy any ticket on MeraEvents to get offer till 5th March. Valid for new users on FreeCharge.
                                </div>      
                            </div>         
                        </div>
                        <?php } ?> -->


                    </div>
                    <?php
} ?>
