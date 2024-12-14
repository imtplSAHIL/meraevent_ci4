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
        <link rel="icon" href="<?php echo $faviconPath; ?>" type="image/x-icon">
        <meta name="msapplication-TileColor" content="#fdda24">
        <meta name="theme-color" content="#5f259f">
        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var https_url = '<?php echo https_url(); ?>';
            var cookie_expiration_time = "<?php echo COOKIE_EXPIRATION_TIME; ?>";
            var api_path = '<?php echo $this->config->item('api_path'); ?>';
            var images_static_path = '<?php echo $imgStaticPath; ?>';
            var api_getProfileDropdown = "<?php echo commonHelperGetPageUrl('api_getProfileDropdown') ?>";
            var uploadUrl = "<?php echo $this->config->item('protocol') . $_SERVER['HTTP_HOST'] . '/js/public/tinymce/plugins/jbimages/dialog-v4.php'; ?>";
        </script>
        <script>
            var api_searchSearchEventAutocomplete = "<?php echo $apiSearchEventAutocomplete; ?>";
            var api_commonRequestProcessRequest = "<?php echo $apiCommonRequestProcessRequest; ?>";
            var recommendationsEnable = "<?php echo $this->config->item('recommendationsEnable') ? "1" : "0"; ?>";
        </script>
        <script src="<?php echo $jsPublicPath . 'jQuery' . $jsExt; ?>"></script>        
        <title><?php echo $pageTitle ?></title>
        <?php
        if (isset($cssArray) && is_array($cssArray)) {
            foreach ($cssArray as $cssFile) {
                echo '<link rel="stylesheet" type="text/css" href="' . $cssFile . $cssExt . '">';
                echo "\n";
            }
        }
        ?>
    </head>
    <body>
        <header class="header-section">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?php if (isset($is_chapter)) { ?>
                            <a class="navbar-brand" href="<?php echo $Organizationurl; ?>" style="clear: none; margin-right: 30px;"><img src="<?php echo $associationlogopath; ?>" style="height: 40px; width: 90px"></a>
                        <?php } ?>
                        <a class="navbar-brand" href="<?php echo $association_url; ?>" style="clear: none;"><img src="<?php echo $logopath; ?>" style="height: 40px; width: 90px; margin-right: 15px"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li><a href="<?php echo $association_url; ?>">Home</a></li>
                            <li><a href="<?php echo $association_url; ?>/events">Events</a></li>
                            <?php if (!isset($is_chapter)) { ?>
                                <li><a href="<?php echo $association_url; ?>/chapters">Chapters</a></li>
                            <?php } ?>
                            <li><a href="<?php echo $association_url; ?>/members">Members</a></li>
                            <?php
                            $userId = $this->customsession->getUserId();
                            if (empty($userId)) {
                                ?>
                                <li><a href="<?php echo $association_url; ?>/login">Login</a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo commonHelperGetPageUrl('my_memberships'); ?>">My Subscriptions</a></li>
                            <?php } ?>
                        </ul>
                        <div class="navbar-right"><a><img src="/images/association/meraevents-logo.png" alt=" " title=""> </a></div>
                    </div>
                </div>
            </nav>
        </header>