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
    $isOrganizer = $this->customsession->getData('isOrganizer');
    $isCollaborator = $this->customsession->getData('isCollaborator');
    $isDashboardAccess = 0;
    if ($isOrganizer == 1 || $isCollaborator == 1) {
        $isDashboardAccess = 1;
    }
    /* $profileImagePath = $this->customsession->getData('profileImagePath');
      $profileImage = commonHelperDefaultImage($profileImagePath, 'userprofile'); */
    if($content=='ticketregistration_view' || $content=='ticket_widget_template_reg_info' || $content=='event_view' || $content=='search_view'){
     $jsExt = '.min.js';
     }else{
     $jsExt = $this->config->item('js_gz_extension');
     }
    $cssExt = $this->config->item('css_gz_extension');
    $jsPublicPath = $this->config->item('js_public_path');
    $cssPublicPath = $this->config->item('css_public_path');
    $imgStaticPath = $this->config->item('images_static_path');
    $home = commonHelperGetPageUrl('home');
    
    /*if($this->config->item('protocol') == 'https://'){
        $seoDetails['noIndex'] = TRUE;
    }*/
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="author" content="MeraEvents" >
        <meta name="rating" content="general" /> 
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
        <title><?php echo $pageTitle; ?></title>         
        <meta name="description" http-equiv="description" content="<?php echo isset($eventData['eventDetails']['seodescription']) ? $eventData['eventDetails']['seodescription'] : "MeraEvents.com is India's largest portal solely dedicated to Online Event promotions Upcoming Events Professional conferences Professional Events It offers many unique features.post your event and brand in front of a highly targeted audience with massive influence"; ?>" />
        <meta name="keywords" http-equiv="keywords" content="<?php echo isset($eventData['eventDetails']['seokeywords']) ? $eventData['eventDetails']['seokeywords'] : "Current Events, Corporate Events Online Portals, Event Solutions, Event Management, Cultural, Event Management in Companies, Events, Meeting and Conferences, Special Event ticket booking, seminars, conferences, concert, upcoming events , today, weekend"; ?>" />
        <?php if(isset($eventData['eventDetails']['conanicalurl']) && !empty($eventData['eventDetails']['conanicalurl'])){?>
             <link rel="canonical" href="<?php echo $eventData['eventDetails']['conanicalurl']; ?>"/>   
        <?php }?>
                      
        <?php if (isset($seoDetails['noIndex']) && $seoDetails['noIndex']) { ?>
            <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <?php } else { ?>
            <?php /* ?><meta name="robots" content="index, follow"><?php */ ?>
        <?php } ?>
        
        
        <!--Twitter Card data-->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="MeraEvents.com">
        <meta name="twitter:title" content="<?php echo isset($sharing_pageTitle) ? $sharing_pageTitle : $pageTitle; ?>">
        <meta name="twitter:description" content="<?php echo isset($eventData['eventDetails']['seodescription']) ? $eventData['eventDetails']['seodescription'] : 'Buy tickets & passes online for upcoming events in your city, live concerts, and events happening in your city. Book latest events at MeraEvents.com'; ?>">
        <meta name="twitter:creator" content="MeraEvents">
        <meta name="twitter:image" content="<?php echo (empty($eventData['bannerPath']))?$eventData['defaultBannerImage']:$eventData['bannerPath'];?>">
        <meta name="twitter:image:width" content="1170">
        <meta name="twitter:image:height" content="370">
         
        
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo isset($sharing_pageTitle) ? $sharing_pageTitle : $pageTitle; ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo (isset($eventData['eventDetails']['conanicalurl']) && !empty($eventData['eventDetails']['conanicalurl'])) ? $eventData['eventDetails']['conanicalurl'] : site_url('event/'.$eventData['url']); ?>" />
        <meta property="og:image" content="<?php echo (empty($eventData['bannerPath']))?$eventData['defaultBannerImage']:$eventData['bannerPath'];?>" />
        <meta property="og:image:width" content="1170"/>
        <meta property="og:image:height" content="370"/>
        <meta property="og:description" content="<?php echo isset($eventData['eventDetails']['seodescription']) ? $eventData['eventDetails']['seodescription'] : 'Buy tickets & passes online for upcoming events in your city, live concerts, and events happening in your city. Book latest events at MeraEvents.com'; ?>" />
        <meta property="og:site_name" content="MeraEvents.com" />
        <meta property="fb:admins" content="125923692046" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'me_custom'.$cssExt; ?>">
        <script type="text/javascript">
            var site_url = '<?php echo https_url(); ?>';
            var defaultCountryId = '<?php echo $defaultCountryId; ?>';
            var defaultCityId = '<?php echo $defaultCityId; ?>';
            var defaultCategoryId = '<?php echo $defaultCategoryId; ?>';
            var defaultSplCityStateId = '<?php echo $defaultSplCityStateId; ?>';
            var defaultSubCategoryId = '<?php echo $defaultSubCategoryId; ?>';
            var defaultSubCategoryName = '<?php echo $defaultSubCategoryName; ?>';
            var defaultCountryName = '<?php echo $defaultCountryName; ?>';
            var defaultCityName = '<?php echo $defaultCityName; ?>';
            var api_path = '<?php echo $this->config->item('api_path'); ?>';
            var label_nomore_events = '<?php echo ERROR_NO_MOR_EVENTS; ?>';
            var defaultCategoryName = '<?php echo $defaultCategory; ?>';
            var totalResultCount = '<?php echo isset($eventsList['eventList']) ? count($eventsList['eventList']) : 0; ?>' || 0;
            var client_ajax_call_api_key = '<?php echo $this->config->item('client_ajax_call_api_key'); ?>';
            var cookie_expiration_time = "<?php echo COOKIE_EXPIRATION_TIME; ?>";
            var api_getProfileDropdown = "<?php echo commonHelperGetPageUrl('api_getProfileDropdown') ?>";
            var _paq=[];
            var recommendationsEnable="<?php echo $this->config->item('recommendationsEnable')?"1":"0";?>";
        </script>
        <?php if ($this->config->item('tsFeedbackEnable')) { ?>
        <script type="text/javascript">
            var tsa = {auth:[], activity_data:{}, user_data:{}};
        </script>
        <?php } ?>
        <script src="<?php echo $jsPublicPath . 'jQuery' . $jsExt; ?>"></script>  
        <script src="<?php echo $jsPublicPath . 'jquery.validate' . $jsExt; ?>"></script>
        <style type="text/css">
            .filterdiv {
                display: none;
            }
            .ui-menu .ui-menu-item{
                font-size:25px;padding: 6px 1em 6px .4em;
            }
            .thumbnail .overlay, .myoverlay .overlay {
                display: none;
            }
            .thumbnail:hover .overlay{
                display: none;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet"
              href="<?php echo $cssPublicPath . 'jquery-ui' . $cssExt; ?>">
              <?php
              if (isset($cssArray) && is_array($cssArray)) {
                  foreach ($cssArray as $cssFile) {
                      echo '<link rel="stylesheet" type="text/css" href="' . $cssFile . $cssExt . '">';
                      echo "\n";
                  }
              }
              include("elements/googletagmanagercode.php"); 
              ?>
        <?php
        if (isset($eventData['eventDetails']['fbpixelcode']) && !empty($eventData['eventDetails']['fbpixelcode'])) {
            $fbq_code = $eventData['eventDetails']['fbpixelcode'];
            $fbq_viewcontent = "fbq('track', 'ViewContent', {
                content_name: '" . $eventData['title'] . "',
                content_category: '" . $eventData['categoryName'] . "',
                content_ids: ['" . $eventData['id'] . "'],
                content_type: 'event'
            });";
            echo substr_replace($fbq_code, $fbq_viewcontent, strpos($fbq_code, "PageView');") + 11, 0);
        }
        ?>
        <?php echo isset($eventData['eventDetails']['googleanalyticsscripts']) ? $eventData['eventDetails']['googleanalyticsscripts'] : ''; ?>
    </head>
    <!-- Static navbar -->
    <body class="single-winner" <?php if (isset($moduleName)) {
                echo "ng-app=" . $moduleName;
            } ?>>
        <?php include("elements/googletagmanagerbodycode.php"); ?>
        <div id="dvLoading" class="loadingopacity" style="display:none;"><img src="<?php echo $imgStaticPath; ?>loading.gif" class="loadingimg" alt="Loading.." /></div>
        <div id="menudvLoading" class="menuloadingopacity" style="display:none;"><img src="<?php echo $imgStaticPath; ?>loading.gif" class="menuloadingimg" alt="Loading.." /></div>
        <div class="site-container">
            <!-- global header -->
            <?php if ($content == 'event_view' || $content == 'search_view') { ?>    
                <header class="site-header" role="banner">
                    <div class="site-header__wrap">
                        <div class="topContainer hidden-lg hidden-md">
                            <div class="wrap">
                                <!--<div class="topContainer">-->
                                <div class="navbar navbar-default" role="navigation">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" id="nav-toggle2" onClick="getProfileLink('event_header');" data-menu="event_header" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>

                                        <?php if ($content == 'search_view') { ?>
                                            <a class=" onscroll " id="settingsBtn" href="javascript:void(0)" >
                                                <span class="icon-set"></span>
                                            </a>
                                        <?php } ?>    
                                        <div class="logo_align">
                                            <a class="navbar-brand logo"  href="<?php echo $home; ?>"> 
                                                <img src="<?php echo $imgStaticPath; ?>me-logo.svg" alt=""> </a> </div>
                                    </div>
                                    <div class="btn-group ddCustom selCountry"> 
                                    <?php
                                    foreach ($countryList as $value) {
                                        if ($value['id'] == $defaultCountryId) {
                                            ?>
                                            <a onClick="setCookieCustom('countryId', '<?php echo $value['id']; ?>', '<?php echo COOKIE_EXPIRATION_TIME; ?>')"  href="<?php echo $value['domain']; ?>" class="btn headerDD"> 
                                                    <span class="status">                                   
                                                        <span class="sprite-icon flag-custom-position <?php echo $value['shortName']; ?>"></span>
                                                        <span class="country-code"><?php echo $value['shortName']; ?></span>
                                                    </span>
                                                </a>
                                                <!--append class "ddBG" if you wnat bg color-->
                                                
                                                    <?php
                                                }
                                    } ?>
                                    <ul class="dropdown-menu dropdown-inverse ddBG headerDD" >
                                    <?php foreach ($countryList as $value) {?>
                                                <li onClick="setCookieCustom('countryId', '<?php echo $value['id']; ?>', '<?php echo COOKIE_EXPIRATION_TIME; ?>')">
                                                   
                                                    <a href="<?php echo $value['domain']; ?>"> 
                                                        <span class="sprite-icon <?php echo $value['shortName']; ?>"></span>
                                                        <span class="country-code"><?php echo $value['shortName']; ?></span>
                                                    </a>
                                                </li>
                                            <?php }
                                            ?>
                                        </ul>
                                        <a class="btn  btn-lg btn-sm btn-md dropdown-toggle"
                                           type="button" data-toggle="dropdown" href="javascript:;"> <span
                                                class="icon-downArrow"></span>
                                        </a>
                                    </div>
                                    <!-- /btn-group -->
                                    <div class="col-sm-12 mobileNavSelector">
                                        <ul>
                                            <li class="col-xs-4"><a href="javascript:void(0)">hyd</a></li>
                                            <li class="col-xs-4"><a href="javascript:void(0)">All</a></li>
                                            <li class="col-xs-4"><a href="javascript:void(0)">Today</a></li>
                                        </ul>
                                    </div>
                                    <div class="navbar-collapse collapse">
                                        <ul class="nav navbar-nav navbar-right profile-dropdown">
                                            <!-- Ajax dropdown comes here -->
                                        </ul>
                                    </div>
                                    <!--/.nav-collapse -->
                                </div>
                            </div>
                        </div>
                    <?php } ?> 
                    <?php if ($content != 'create_event_view') { ?>  
                        <div class="onScrollContainer hidden-sm hidden-xs" style="opacity: 1;visibility: visible;" >
                            <div class="topContainer">
                                <div class="wrap">
                                    <div class="onScrollContainer__container">
                                        <div class="navbar-header">
                                            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                                            <div class="logo_align">
                                                <a class="navbar-brand logo" href="<?php echo $home; ?>"> <img src="<?php echo $this->config->item('images_static_path'); ?>me-logo.svg" alt="" >
                                                </a>
                                            </div>
                                        </div>
                                         <div class="btn-group ddCustom selCountry"> 
                                        <?php
                                        foreach ($countryList as $value) {
                                            if ($value['id'] == $defaultCountryId) 
                                            {
                                                ?>
                                                <a onClick="setCookieCustom('countryId', '<?php echo $value['id']; ?>', '<?php echo COOKIE_EXPIRATION_TIME; ?>')" href="<?php echo $value['domain']; ?>" class="btn headerDD"> 
                                                    <span class="status">
                                                        <span class="sprite-icon flag-custom-position <?php echo $value['shortName']; ?>"></span>
                                                        <span class="country-code"><?php echo $value['shortName']; ?></span>
                                                    </span>
                                                </a>
                                                <?php
                                            }
                                        }?>
                                        <ul class="dropdown-menu dropdown-inverse ddBG headerDD">
                                        <?php foreach ($countryList as $value) {
                                                ?>
                                                <li onClick="setCookieCustom('countryId', '<?php echo $value['id']; ?>', '<?php echo COOKIE_EXPIRATION_TIME; ?>')" value="<?php echo $value['id']; ?>">
                                                    <a href="<?php echo $value['domain']; ?>"> 
                                                        <span class="sprite-icon <?php echo $value['shortName']; ?>"></span>
                                                        <span class="country-code"><?php echo $value['shortName']; ?></span>
                                                    </a>
                                                   
                                                </li>
                                            <?php }
                                            ?>
                                            </ul>
                                            <a data-toggle="dropdown" type="button" class="btn  btn-lg btn-sm btn-md dropdown-toggle"> <span class="icon-downArrow"></span> </a> 
                                        </div>
                                        <?php if ($displayHeaderType != 'search') { ?>
                                            <div class="search-container">
                                                <input type="search" placeholder="Search by Event Name , Event ID , Key Words" class="search form-control searchExpand icon-me_search">
                                                <a class="search icon-me_search"></a>
                                            </div>
                                        <?php } ?>

                                        <div class="navbar-collapse collapse">
                                            <ul class="nav navbar-nav navbar-right">
                                                <?php if ($userId) { ?>
                                                    <li class="dropdown"> 
                                                        <a class="dropdown-toggle afterlogindiv"  style="cursor: pointer;"
                                                           data-toggle="dropdown" role="button" aria-expanded="false"
                                                           id="scrollnavtoggle" onClick="getProfileLink('event_header');" data-menu="event_header" href="javascript:;">
                                                            <!-- <img src="<?php echo $imgStaticPath . DEFAULT_PROFILE_IMAGE; ?>" alt="<?php echo $imgStaticPath . DEFAULT_PROFILE_IMAGE; ?>"> -->
                                                            <div class="sprite-icon profile-icon-50"></div>
                                                        </a>
                                                        <ul class="dropdown-menu profile-dropdown" role="menu">
                                                            <!-- Ajax dropdown comes here -->
                                                        </ul>
                                                    </li>
                                                <?php } else { ?>
                                                    <li class="dropdown"> 
                                                        <a href="#" class="dropdown-toggle detailonscroll"
                                                           data-toggle="dropdown" role="button" aria-expanded="false"
                                                           id="scrollnavtoggle">
                                                            <span class="icon-set"></span>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <?php echo commonHtmlElement('create-event'); ?>
                                                            <?php echo commonHtmlElement('logout', $isLogin); ?>
                                                        </ul>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <?php } ?>
                </div>
            </header>
            <!-- /global header -->
        </div>
        <!--important-->
        <!-- /.wrap -->
