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
    /* $profileImagePath = $this->customsession->getData('profileImagePath');
      $profileImage = commonHelperDefaultImage($profileImagePath, 'userprofile'); */
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
        if($guestLogin == 1){ header("Location:".site_url()."logout"); exit; }
            ?>
            <title><?php echo $pageTitle ?></title>
<!--            <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'dashboard'. $cssExt; ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'me-font' . $cssExt; ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo $cssPublicPath . 'fa-style' . $cssExt; ?>">
            <link rel="stylesheet" href="<?php echo $cssPublicPath . 'jquery-ui' . $cssExt; ?>">-->
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
      <div id="theme-container">
         <header id="masthead" class="site-header full-width border-bottom_header background-white">
            <div class="header-menu full-width-1">
               <div class="header-nav d-flex menu-color-gray">
                  <div class="site-header__logo">
                     <div class="logo-head logo-black">
                        <a class="navbar-brand logo" href="<?php echo $home; ?>"> <img src="<?php echo $imgStaticPath; ?>me-logo.svg" alt="" >
                        </a>
                     </div>
                  </div>
                  <div class="social-menu-header">
                     <div class="d-lg-none nav-mobile">
                        <a href="#" class="nav-toggle js-nav-toggle"><span></span></a>
                     </div>
                  </div>
                  <nav id="menu-nav">
                     <ul class="list-menu min-list main-navigation">
                        
                        <li class="head-menu">
                                                        <a href="#">Help<span class="icon-downArrow"></span></a>
                                                        <ul role="menu" class="sub-menu">
                                                            <li><a id="printTicket" href='<?php echo $printPass; ?>' target='_blank'>Print Tickets</a></li>
                                                            <li><a href="<?php echo $pricing; ?>" target='_blank'>Pricing</a></li>
                                                            <li><a href="<?php echo $support; ?>" target='_blank'>Support</a></li>
                                                            <li><a href="<?php echo commonHelperGetPageUrl('features');?>" target="_blank">Organizer Features</a></li>
                                                            <li><a href="<?php echo commonHelperGetPageUrl('why_meraevents');?>" target="_blank">Why MeraEvents</a></li>
                                                        </ul></li>
                        <?php if (!$userId) { ?>
                            <?php
                            $className = $this->router->fetch_class();
                            if ($className == 'payment') {
                                $redirecting_url = defined('COUNTRY_URI') ?  ltrim($_SERVER['REQUEST_URI'], '/'.COUNTRY_URI) : ltrim($_SERVER['REQUEST_URI'], '/');
                                ?>
                                <li class="head-menu"><a href="<?php echo $userLogin . '?redirect_url=' . $redirecting_url; ?>" target="_self">Login</a></li>
                                <li class="head-menu" > <a href="<?php echo commonHelperGetPageUrl('user-signup'); ?>">Sign Up</a> </li>
                            <?php } else { ?>
                                <li class="head-menu"><a href="<?php echo $userLogin; ?>" target="_self">Login</a></li>
                                <li class="head-menu" > <a href="<?php echo commonHelperGetPageUrl('user-signup'); ?>">Sign Up</a> </li>
                            <?php } ?>
                        <?php } ?>
                                
                               
                        
                        
                     </ul>
                  </nav>
               </div>
               <!-- .site-header__menu -->
            </div>
         </header>