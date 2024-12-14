<?php

function getMailHost($email){
    $explode = explode("@",$email);
    return strtolower($explode[1]);
}

// Function to get the client IP address
function commonHelperGetClientIp() {
    $ipAddress = '';
    if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
    else
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    return $ipAddress;
}

function get_client_ip() {
    $ipaddress = '';
    if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    return $ipaddress;
}

// Function for HTTPS Url

function https_url(){
    return  str_replace('http://','https://',site_url());
}

function commonHelperGetIdArray($input, $groupByKey = 'id') {
    $returnArray = array();
    if (count($input) > 0) {
        foreach ($input as $key => $val) {
            $keyname = $val[$groupByKey];
            foreach ($val as $id => $value) {
                if ($id == $groupByKey)
                    $keyname = $value;
                $returnArray[$keyname][$id] = $value;
            }
        }
    }
    return $returnArray;
}

function eventType($eventType) {
    $eventType = strtolower($eventType);
    $eventTypeValues = array();
    switch ($eventType) {
        case 'paid':
            $eventTypeValues['registrationType'] = 2;
            break;
        case 'free':
            $eventTypeValues['registrationType'] = 1;
            break;
        case 'webinar':
            $eventTypeValues['eventMode'] = 1;
            $eventTypeValues['registrationType'] = 4;
            break;
        case 'nonwebinar':
            $eventTypeValues['eventMode'] = 0;
            $eventTypeValues['registrationType'] = 4;
            break;
        case 'noreg':
            $eventTypeValues['registrationType'] = 3;
            break;
        case 'info only':
            $eventTypeValues['registrationType']= 3 ;
            break;
        default:
            $eventTypeValues[] = '';
            break;
    }
    return $eventTypeValues;
}

//function to get tinyurl for long URL
function getTinyUrl($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

// function to get customFilterArray
function commonHelperCustomFilterArray() {
    $filterArray = array(0 => array("id" => 1, "name" => 'today', "value" => 'today'),
        1 => array("id" => 2, "name" => 'tomorrow', "value" => 'tomorrow'),
        2 => array("id" => 3, "name" => 'this week', "value" => 'this-week'),
        3 => array("id" => 4, "name" => 'this weekend', "value" => 'this-weekend'),
        4 => array("id" => 5, "name" => 'this month', "value" => 'this-month'),
        5 => array("id" => 6, "name" => 'all time', "value" => 'all-time'),
        6 => array("id" => 7, "name" => 'Custom Date', "value" => 'custom-date')
    );

    return $filterArray;
}

function commonHelperEventDetailUrl($url) {
    return site_url("event/" . $url);
}

function site_url_get() {
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
    $host = $_SERVER['HTTP_HOST'];
    $currentUrl = $protocol . '://' . $host . '/';
    return $currentUrl;
}

//To get the pick a theme related shor/thumb/banner images array
//@image_path: site url of the project
function get_theme_images_array($image_path) {
    $theme_images = array();
    $image_path = $image_path . 'picktheme/';
//    $theme_images[0]['short'] = $image_path . "short1.jpg";
//    $theme_images[0]['thumb'] = $image_path . "thumb1.jpg";
//    $theme_images[0]['banner'] = $image_path . "banner1.jpg";
//    $theme_images[0]['theam'] =  "Music";

    $theme_images[1]['short'] =$image_path . "entertainment-short.jpg";
    $theme_images[1]['thumb'] = $image_path . "Entertainment-thumb.jpg";
    $theme_images[1]['banner'] = $image_path . "Entertainment.jpg";
    $theme_images[1]['theam'] =  "Entertainment";

    $theme_images[2]['short'] =$image_path . "campus-short.jpg";
    $theme_images[2]['thumb'] = $image_path . "campus-thumbnail.jpg";
    $theme_images[2]['banner'] = $image_path . "campus-banner.jpg";
    $theme_images[2]['theam'] =  "Campus";

    $theme_images[3]['short'] =$image_path . "professional-short.jpg";
    $theme_images[3]['thumb'] = $image_path . "Professional-thumb.jpg";
    $theme_images[3]['banner'] = $image_path . "Professional.jpg";
    $theme_images[3]['theam'] =  "Professional";

    $theme_images[4]['short'] =$image_path . "spiritual-short.jpg";
    $theme_images[4]['thumb'] = $image_path . "Spiritual-thumb.jpg";
    $theme_images[4]['banner'] = $image_path . "Spiritual.jpg";
    $theme_images[4]['theam'] =  "Spiritual";

    $theme_images[5]['short'] =$image_path . "sports-short.jpg";
    $theme_images[5]['thumb'] = $image_path . "Sports-thumb.jpg";
    $theme_images[5]['banner'] = $image_path . "Sports.jpg";
    $theme_images[5]['theam'] =  "Sports";

    $theme_images[6]['short'] =$image_path . "tradeshows-short.jpg";
    $theme_images[6]['thumb'] = $image_path . "TradeShows-thumb.jpg";
    $theme_images[6]['banner'] = $image_path . "TradeShows.jpg";
    $theme_images[6]['theam'] =  "TradeShows";

    $theme_images[7]['short'] =$image_path . "training-short.jpg";
    $theme_images[7]['thumb'] = $image_path . "training-thumbnail.jpg";
    $theme_images[7]['banner'] = $image_path . "training-banner.jpg";
    $theme_images[7]['theam'] =  "Training";

//    $theme_images[8]['short'] =$image_path . "spcl-short.jpg";
//    $theme_images[8]['thumb'] = $image_path . "spcl-t.jpg";
//    $theme_images[8]['banner'] = $image_path . "spcl.jpg";
//    $theme_images[8]['theam'] =  "SpecialOccasion";

//    $theme_images[9]['short'] =$image_path . "new-year-short.jpg";
//    $theme_images[9]['thumb'] = $image_path . "newyear-t.jpg";
//    $theme_images[9]['banner'] = $image_path . "newyear.jpg";
//    $theme_images[9]['theam'] =  "NewYear";

    $theme_images[8]['short'] =$image_path . "activities-short.jpg";
    $theme_images[8]['thumb'] = $image_path . "activities-thumbnail.jpg";
    $theme_images[8]['banner'] = $image_path . "activities-banner.jpg";
    $theme_images[8]['theam'] =  "Activities";
    
    $theme_images[10]['short'] = $image_path . "donations-short.jpg";
    $theme_images[10]['thumb'] = $image_path . "donations-thumbnail.png";
    $theme_images[10]['banner'] = $image_path . "donations-banner.png";
    $theme_images[10]['theam'] = "Donations";
    
    $theme_images[11]['short'] = $image_path . "webinar-short.jpg";
    $theme_images[11]['thumb'] = $image_path . "webinar-thumbnail.png";
    $theme_images[11]['banner'] = $image_path . "webinar-banner.png";
    $theme_images[11]['theam'] = "Webinars";

    return $theme_images;
}

function dateFormate($date, $separator) {
    $dates = explode($separator, $date);

    $month = $dates[0];
    $day = $dates[1];
    $year = $dates[2];

    $finalDate = $year . '-' . $month . '-' . $day;
    return $finalDate;
}

//To get the login user id
function getUserId() {
    $ci = &get_instance();
    $userId = $ci->customsession->getUserId();
    if ($userId) {
        return $userId;
    }
}

// To get the Dashboard Url
function getDashboardUrl(){
    require_once(APPPATH . 'handlers/dashboard_handler.php');
    $dashboardHandler = new Dashboard_handler();
    $ci = &get_instance();
    $inputArray['loginredirectCheck']=true;
    if($ci->uri->segment(1)=='confirmation'){
        return commonHelperGetPageUrl('user-attendeeview-current');
    }

    $userCurrentevents = $dashboardHandler->getUpcomingPastEventsCount();
    //echo 'url1';print_r($userCurrentevents); echo 'url1';
    if($userCurrentevents['status'] && isset($userCurrentevents['response']['upcomingEventsCount'])){
        return $redirectUrl = commonHelperGetPageUrl('dashboard-myevent');
    }
    if($userCurrentevents['status'] && isset($userCurrentevents['response']['pastEventCount'])){
        $redirectUrl = commonHelperGetPageUrl('dashboard-pastevent');
        return $redirectUrl;
    }
}

//To get the attend view URl
function getAttendeeUrl() {
    require_once(APPPATH . 'handlers/profile_handler.php');
    $profileHandler = new Profile_handler();
    $ci = &get_instance();
    $redirectUrl = commonHelperGetPageUrl('user-attendeeview-past');
    $inputArray['ticketType'] = 'current';
    $currentTickets = $profileHandler->getUserTicketListCount($inputArray);
    if ($currentTickets['status'] && $currentTickets['response']['total'] > 0) {
        $redirectUrl = commonHelperGetPageUrl('user-attendeeview-current');
    }
    return $redirectUrl;
}

//To get the promoter view URl
function getPromoterViewUrl(){
    require_once(APPPATH . 'handlers/promoter_handler.php');
    $promoterHandler = new Promoter_handler();
    $ci = &get_instance();
    $userCurrentevents = $promoterHandler->getUpcomingPastPromoterEventsCount();
    if($userCurrentevents['status'] && isset($userCurrentevents['response']['upcomingPromoterEventsCount'])){
        return $redirectUrl = commonHelperGetPageUrl('user-promoterview-current');
    }
    if($userCurrentevents['status'] && isset($userCurrentevents['response']['pastPromoterEventsCount'])){
        return $redirectUrl = commonHelperGetPageUrl('user-promoterview-past');
    }
}

// date comparison function --date should be (02/07/2015 15:38) formate
function dateCompare($date, $time, $compareDate = "", $compareTime = "") {
    $compareDateTime = $compareDate . ' ' . $compareTime;
    if ($compareDate == "" && $compareTime == "") {
        $compareDateTime = date("m/d/Y H:i");
    }
    $dateTime = $date . ' ' . $time;
    $dateTime = strtotime($dateTime);
    $compareDateTime = strtotime($compareDateTime);

    if ($compareDateTime < $dateTime) {
        return true;
    } else {
        return false;
    }
}

// Data Value validation

function dateValidation($date, $separator = '/') {
    if (count(explode($separator, $date)) == 3) {
        $pattern = "@([0-9]{2})" . $separator . "([0-9]{2})" . $separator . "([0-9]{4})@";
        if (preg_match($pattern, $date, $parts)) {
            if (checkdate($parts[1], $parts[2], $parts[3]))
                return TRUE;
            else
                return FALSE;
        }
    }
}

//date time validation
function checkDateTime($data) {
    if (date('Y-m-d H:i:s', strtotime($data)) == $data) {
        return true;
    } else {
        return false;
    }
}
/**
 * Append current time stamp to passed file name
 * @Parm fileName
 */
function appendTimeStamp($fileName) {
    $currentTime = strtotime("now");
    $path_parts = pathinfo($fileName);
    $path_parts['filename']=cleanUrl($path_parts['filename']);
    $newFileName = $path_parts['filename'] . $currentTime . "." . $path_parts['extension'];
    return $newFileName;
}

// function to get Change sale button title
function saleButtonTitle() {
    $filterArray = array(0 => array("id" => 1, "name" => 'Register Now'),
        1 => array("id" => 2, "name" => 'Book Now'),
        2 => array("id" => 3, "name" => 'Donate'),
    );

    return $filterArray;
}

function commonHelperDefaultImage($path, $type) {
    if (strlen($path) > 1) {
        return $path;
    } else {
        $image = "";
        $ci = &get_instance();
        switch ($type) {
            case 'eventlogo':
                $image = $ci->config->item('images_content_path') . "eventlogo/defaulteventlogo.jpg";
                break;
            case 'topbanner':
                $image = $ci->config->item('images_content_path') . "banners/defaulteventbanner.jpg";
            case 'userprofile':
                $image = $ci->config->item('images_static_path') . DEFAULT_PROFILE_IMAGE;
        }
        return $image;
    }
}


function commonHelperCheckUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (curl_exec($ch) !== FALSE) {
        return true;
    } else {
        return false;
    }
}

/**
 * Extract date in mm/dd/YYY format from dd/mm/yy h:m:s
 */
function extractDate($dateString) {
    return date("m/d/Y", strtotime($dateString));
}

/**
 * Extract time in h:m:s format from dd/mm/yy h:m:s
 */
function extractTime($dateString) {
    return date("H:i:s", strtotime($dateString));
}

function commonHelpergenerateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

/**
 * To return the mathed key values array
 */
function arrayComparison($arrayList, $ticketId) {
    foreach ($arrayList as $key => $value) {
        if ($value['id'] == $ticketId) {
            return $value;
        }
    }
    return FALSE;
}

function commonHelperGetEventType($eventType) {
    $eventTypeValues = array();
    switch ($eventType) {
        case 'paid' :
            $eventTypeValues['registrationType'] = 2;
            break;
        case 'free' :
            $eventTypeValues['registrationType'] = 1;
            break;
        case 'webinar' :
            $eventTypeValues['eventMode'] = 1;
            break;
        //            case 'topselling':
        //                    $eventTypeValues['']='';
        //                break;
        default :
            $eventTypeValues[] = '';
            break;
    }
    return $eventTypeValues;
}

//To remove the script tags from the text
function removeScriptTag($removeText) {
    $removeText = str_replace('<script>', ' ', $removeText);
    $removeText = str_replace('</script>', ' ', $removeText);
    return $removeText;
}

//To encrypt the password
function encryptPassword($passwordString) {
    return md5($passwordString);
}

function commonHelperGetPageUrl($pageName, $params = "", $getParams = "") {
    $pageUrls = array();
    $pageSiteUrl = site_url();
    $ci = &get_instance();
    $home = defined('COUNTRY_URI') ? rtrim($pageSiteUrl ,"/") : $pageSiteUrl;
    $pageUrls['home'] = $home;
    $pageUrls['barcode'] = $ci->config->item('server_path').'barcode/barcode.php';
    $pageUrls['dashboard-myevent'] = $pageSiteUrl . "dashboard";
    $pageUrls['dashboard-eventhome'] = $pageSiteUrl . "dashboard/home/";
    $pageUrls['dashboard-pastevent'] = $pageSiteUrl . "dashboard/pastEventList";
    $pageUrls['dashboard-ticketwidget'] = $pageSiteUrl . "dashboard/configure/ticketWidget/";
    $pageUrls['invoiceDetailsValidation'] = $pageSiteUrl . "dashboard/configure/invoiceDetailsValidation";
    $pageUrls['dashboard-customtemplate'] = $pageSiteUrl . "dashboard/customtemplate/";
    $pageUrls['dashboard-customtemplate-update'] = $pageSiteUrl . "dashboard/customtemplate/updateTemplate/";


    $pageUrls['ticketWidget'] = $pageSiteUrl . "ticketWidget";
    $pageUrls['dashboard-webhook'] = $pageSiteUrl . "dashboard/configure/webhookUrl/";
    $pageUrls['dashboard-gallery'] = $pageSiteUrl . "dashboard/configure/gallery/";
    $pageUrls['dashboard-seo'] = $pageSiteUrl . "dashboard/configure/seo/";
    $pageUrls['dashboard-ticketOption'] = $pageSiteUrl . "dashboard/configure/ticketOptions/";
    $pageUrls['dashboard-customField'] = $pageSiteUrl . "dashboard/configure/customFields/";
    $pageUrls['dashboard-customField_curation'] = $pageSiteUrl . "dashboard/configure/curation/";
    $pageUrls['dashboard-discount'] = $pageSiteUrl . "dashboard/promote/discount/";
    $pageUrls['dashboard-viralticket'] = $pageSiteUrl . "dashboard/promote/viralTicket/";
    $pageUrls['dashboard-pastattviralticket'] = $pageSiteUrl . "dashboard/promote/pastattviralticket/";
    $pageUrls['dashboard-uploadpastatt'] = $pageSiteUrl . "dashboard/promote/uploadorganizerattendees/";
    $pageUrls['dashboard-pastattlisting'] = $pageSiteUrl . "dashboard/promote/pastattendeelist/";
    $pageUrls['sendemailtopastattendees'] = $pageSiteUrl . "api/emailrequest/add";
    $pageUrls['api_stagedEventResendEmail'] =   $pageSiteUrl . "api/transaction/stagedEventResendEmail";
    $pageUrls['dashboard-affliate'] = $pageSiteUrl . "dashboard/promote/affiliate/";
    $pageUrls['dashboard-organizer-affliates'] = $pageSiteUrl . "dashboard/promote/organizeraffiliates";
    $pageUrls['dashboard-add-affliate'] = $pageSiteUrl . "dashboard/promote/addPromoter/";
    $pageUrls['dashboard-add-org-affliate'] = $pageSiteUrl . "dashboard/promote/addOrgPromoter/";
    $pageUrls['api-get-affliate-promoter'] = $pageSiteUrl . "api/promote/getPromoterbyEmail/";
    $pageUrls['dashboard-transaction-report'] = $pageSiteUrl . "dashboard/reports/";
    $pageUrls['dashboard-offline-pending-transaction-report'] = $pageSiteUrl . "dashboard/offlinepending/";
    $pageUrls['dashboard-offline-attendees-transaction-report'] = $pageSiteUrl . "dashboard/offlineAttendees/";

    $pageUrls['dashboard-edit-offline-purchaser'] = $pageSiteUrl . "dashboard/editPurchaser/";
    $pageUrls['dashboard-download-profarma-invoice'] = $pageSiteUrl . "dashboard/downloadProfarmaInvoice/";
    $pageUrls['dashboard-download-tax-invoice'] = $pageSiteUrl . "dashboard/downloadTaxInvoice/";
    $pageUrls['dashboard-email-tax-invoice'] = $pageSiteUrl . "dashboard/emailTaxInvoice/";
    $pageUrls['dashboard-email-profarma-invoice'] = $pageSiteUrl . "dashboard/emailProfarmaInvoice/";
    $pageUrls['raise-tax-invoice'] = $pageSiteUrl . "dashboard/raiseTaxInvoice/";
    $pageUrls['cancel-registration'] = $pageSiteUrl . "dashboard/cancelRegistration/";
    
    $pageUrls['dashboard-make-transaction-success'] = $pageSiteUrl . "dashboard/makeTransactionSuccess/";
    $pageUrls['dashboard-download-attendee-info'] = $pageSiteUrl . "dashboard/downloadAttendeeInfo/";
    $pageUrls['dashboard-download-attendee-dashboard'] = $pageSiteUrl . "dashboard/downloadAttendeeDashboard/";
    $pageUrls['dashboard-events-summary-report'] = $pageSiteUrl . "dashboard/eventssummaryreport";
    $pageUrls['dashboard-events-daily-report'] = $pageSiteUrl . "dashboard/eventsdailyreport";
    $pageUrls['dashboard-events-daily-detail-report'] = $pageSiteUrl . "dashboard/eventsdailydetailreport";
    $pageUrls['dashboard-events-payment-report'] = $pageSiteUrl . "dashboard/eventspaymentreport";
    $pageUrls['dashboard-events-reconciliation-report'] = $pageSiteUrl . "dashboard/eventsreconciliationreport";
    $pageUrls['dashboard-sub-user-reports'] = $pageSiteUrl . "dashboard/subuserreports";
    $pageUrls['dashboard-sub-users'] = $pageSiteUrl . "dashboard/subusers";
    $pageUrls['dashboard-sub-user-add'] = $pageSiteUrl . "dashboard/subuseradd";
    $pageUrls['api_subUserUpdateStatus'] =   $pageSiteUrl . "api/reports/updateSubUserStatus";
    $pageUrls['promoter-transaction-report'] = $pageSiteUrl . "promoter/reports/";
    $pageUrls['dashboard-saleseffort-report'] = $pageSiteUrl . "dashboard/saleseffort/";
    $pageUrls['dashboard-analytics-report'] = $pageSiteUrl . "dashboard/analyticsreport/";
    $pageUrls['dashboard-add-discount'] = $pageSiteUrl . "dashboard/promote/addDiscount/";
    $pageUrls['dashboard-bulk-upload-discount'] = $pageSiteUrl . "dashboard/promote/bulkUploadDiscounts/";
    
    $pageUrls['dashboard-list-discount'] = $pageSiteUrl . "dashboard/promote/discount/";
    /*$pageUrls['dashboard-list-collaborator'] = $pageSiteUrl . "dashboard/promote/collaboratorlist/";
    $pageUrls['dashboard-add-collaborator'] = $pageSiteUrl . "dashboard/promote/addcollaborator/";
    $pageUrls['dashboard-edit-collaborator'] = $pageSiteUrl . "dashboard/promote/editcollaborator/";*/
    $pageUrls['dashboard-list-collaborator'] = $pageSiteUrl . "dashboard/collaborator/collaboratorlist/";
    $pageUrls['dashboard-add-collaborator'] = $pageSiteUrl . "dashboard/collaborator/addcollaborator/";
    $pageUrls['dashboard-edit-collaborator'] = $pageSiteUrl . "dashboard/collaborator/editcollaborator/";
    $pageUrls['user-myprofile'] = $pageSiteUrl . "profile/";
    $pageUrls['user-companyprofile'] = $pageSiteUrl . "profile/company";
    $pageUrls['user-bankdetail'] = $pageSiteUrl . "profile/bank";
    $pageUrls['user-alert'] = $pageSiteUrl . "profile/alert";
    $pageUrls['user-savedevent'] = $pageSiteUrl . "profile/";
    $pageUrls['changepassword'] = $pageSiteUrl . "profile/changePassword";
    $pageUrls['developerapi'] = $pageSiteUrl . "profile/developerapi";
    $pageUrls['createApp'] = $pageSiteUrl . "profile/createApp";
    $pageUrls['updateApp'] = $pageSiteUrl . "profile/updateApp";
    $pageUrls['user-changePassword'] = $pageSiteUrl . "changePassword/";
    $pageUrls['user-logout'] = $pageSiteUrl . "logout";
    $pageUrls['create-event'] = $pageSiteUrl . "dashboard/event/create/";
    $pageUrls['edit-event'] = $pageSiteUrl . "dashboard/event/edit/";
    $pageUrls['live-event'] = $pageSiteUrl . "dashboard/event/live/";
    $pageUrls['preview-event'] = $pageSiteUrl . "event/";
    $pageUrls['dashboard-bulkdiscount'] = $pageSiteUrl . "dashboard/promote/bulkDiscount/";
    $pageUrls['dashboard-add-bulkdiscount'] = $pageSiteUrl . "dashboard/promote/addBulkDiscount/";
    $pageUrls['dashboard-tnc'] = $pageSiteUrl . "dashboard/configure/tnc/";
    $pageUrls['user-attendeeview-current'] = $pageSiteUrl . "currentTicket";
    $pageUrls['user-attendeeview-past'] = $pageSiteUrl . "pastTicket";
    $pageUrls['user-attendeeview-referal'] = $pageSiteUrl . "referalBonus";
    $pageUrls['dashboard-add-offline-promoter'] = $pageSiteUrl . "dashboard/promote/addOfflinePromoter/";
    $pageUrls['dashboard-add-partial-payment'] = $pageSiteUrl . "dashboard/promote/addPartialPayment/";
    $pageUrls['dashboard-edit-offline-promoter'] = $pageSiteUrl . "dashboard/promote/editOfflinePromoter/";
    $pageUrls['dashboard-offlinepromoter'] = $pageSiteUrl . "dashboard/promote/offlinePromoterlist/";
    $pageUrls['dashboard-partialPayments'] = $pageSiteUrl . "dashboard/promote/partialPayments/";
    $pageUrls['dashboard-edit-partialPayments'] = $pageSiteUrl . "dashboard/promote/editPartialPayment/";
    $pageUrls['custom-email-template'] = $pageSiteUrl . "dashboard/customtemplate/index/";

    $pageUrls['user-mywallet'] = $pageSiteUrl . "mywallet/";
    $pageUrls['user-mywallet-transactions'] = $pageSiteUrl . "mywallet/transactions";
    $pageUrls['user-mywallet-vouchers'] = $pageSiteUrl . "mywallet/vouchers";
    $pageUrls['user-mywallet-beneficiaries'] = $pageSiteUrl . "mywallet/beneficiaries";

    $pageUrls['offlineBooking'] = $pageSiteUrl . "offlineBooking";
    $pageUrls['user-noaccess'] = $pageSiteUrl . "noAccess/";
    $pageUrls['user-login'] = $pageSiteUrl . "login";
    $pageUrls['user-promoterview-current'] = $pageSiteUrl . "promoter/currentlist";
    $pageUrls['user-promoterview-past'] = $pageSiteUrl . "promoter/pastlist";
    $pageUrls['user-promoterview-offlinebooking'] = $pageSiteUrl . "promoter/offlinebooking";
    $pageUrls['user-promoterview-eventdetailslist'] = $pageSiteUrl . "promoter/eventDetailsList/";
    $pageUrls['api_eventPiwikList'] =   $pageSiteUrl . "api/event/piwikList";
    $pageUrls['api_getCSVData'] =   $pageSiteUrl . "api/promote/getCSVData";
    $pageUrls['api_insertOrgPastAttendees'] =   $pageSiteUrl . "api/promote/insertOrgPastAttendees";
    $pageUrls['api_otherEvents'] = $pageSiteUrl .'api/event/otherEvents';
    $pageUrls['api_similarCategoryEvents'] = $pageSiteUrl .'api/event/similarCategoryEvents';
    $pageUrls['search'] = $pageSiteUrl . "search";
    $pageUrls['career'] = $pageSiteUrl . "career";
    $pageUrls['faq'] = $pageSiteUrl . "faq";
    $pageUrls['venue'] =   $pageSiteUrl . "venue/";
    $pageUrls['pricing'] = $pageSiteUrl . "pricing";
    $pageUrls['pricingtab'] = $pageSiteUrl . "pricingtab.php";
    $pageUrls['blog'] = $pageSiteUrl . "blog";
    $pageUrls['blog_savecomments'] = $pageSiteUrl . "blog/savecomments";
    $pageUrls['news'] = $pageSiteUrl . "news";
    $pageUrls['mediakit'] = $pageSiteUrl . "mediakit";
    $pageUrls['eventregistration'] = $pageSiteUrl . "eventregistration";
    $pageUrls['selltickets'] = $pageSiteUrl . "selltickets";
    $pageUrls['terms'] = $pageSiteUrl . "terms";
    $pageUrls['apidevelopers'] = $pageSiteUrl . "apidevelopers";
    $pageUrls['client_feedback'] = $pageSiteUrl . "client_feedback";
    $pageUrls['aboutus'] = $pageSiteUrl . "aboutus";
    $pageUrls['team'] = $pageSiteUrl . "team";
    $pageUrls['dashboard-gallery'] = $pageSiteUrl . "dashboard/configure/gallery/";
    $pageUrls['dashboard-contactinfo'] = $pageSiteUrl . "dashboard/configure/contactInfo/";
    $pageUrls['dashboard-paymentMode'] = $pageSiteUrl . "dashboard/configure/paymentMode/";
    $pageUrls['dashboard-refund'] = $pageSiteUrl . "dashboard/payment/refund/";
    $pageUrls['dashboard-payment-receipts'] = $pageSiteUrl . "dashboard/payment/receipts/";
    $pageUrls['dashboard-emailAttendees'] = $pageSiteUrl . "dashboard/configure/emailAttendees/";
    $pageUrls['dashboard-deleteRequest'] = $pageSiteUrl . "dashboard/configure/deleteRequest/";
    $pageUrls['dashboard-stagedEvent'] = $pageSiteUrl . "dashboard/configure/stagedEvent/";
    $pageUrls['dashboard-fbPixel'] = $pageSiteUrl . "dashboard/configure/fbPixel/";
    $pageUrls['dashboard-gtm'] = $pageSiteUrl . "dashboard/configure/gtm/";
    $pageUrls['event-tnc-popup'] = $pageSiteUrl . "dashboard/event/termsAndConditions/";
    $pageUrls['print_pass'] = $pageSiteUrl . "printpass/";
    $pageUrls['dashboard-guestlist-booking'] = $pageSiteUrl . "dashboard/promote/guestListBooking/";
    $pageUrls['dashboard-guestlist-failures'] = $pageSiteUrl . "dashboard/promote/guestBookingFailures/";
    $pageUrls['dashboard-guestlist-bulkupload'] = $pageSiteUrl . "dashboard/promote/processBulkUpload/";
    $pageUrls['captcha'] = "https://" . $_SERVER['HTTP_HOST'] . "/captcha.php";
    $pageUrls['user-activationLink']=$pageSiteUrl . "activationLink/";
    $pageUrls['user-signup']=$pageSiteUrl . "signup/";
    $pageUrls['event-preview']=$pageSiteUrl . "previewevent";
    $pageUrls['event-detail']=$pageSiteUrl . "event/";
    $pageUrls['multiple-offlinepass']=$pageSiteUrl . "confirmation/getMultipleOfflinePasses";
    $pageUrls['download-file'] =   $pageSiteUrl . "home/download";
    $pageUrls['content-page'] =   $pageSiteUrl . "content";
    /*$pageUrls['api_getTicketCalculation'] = https_url()."api/event/getTicketCalculation";
     $pageUrls['api_bookNow'] =  https_url()."api/event/bookNow";
     $pageUrls['api_bookingSaveData'] =  https_url()."api/booking/saveData"; */
    $pageUrls['api_getTicketCalculation'] = $pageSiteUrl."api/event/getTicketCalculation";
    $pageUrls['api_bookNow'] =  $pageSiteUrl."api/event/bookNow";
    $pageUrls['api_bookingSaveData'] =  $pageSiteUrl."api/booking/saveData";
    $pageUrls['api_citySearch'] =  $pageSiteUrl."api/city/search";
    $pageUrls['api_countrySearch'] =  $pageSiteUrl.'api/country/search';
    $pageUrls['api_stateSearch'] =  $pageSiteUrl.'api/state/search';
    $pageUrls['api_delegateSmsSend'] =  $pageSiteUrl.'api/transaction/resendSuccessEventsignupsmstoDelegate';
    $pageUrls['api_emailPrintpass'] =  $pageSiteUrl.'api/transaction/emailPrintpass';
    $pageUrls['api_eventPromoCodes'] =  $pageSiteUrl.'api/eventpromocodes/check';
    $pageUrls['confirmation'] =  $pageSiteUrl . 'confirmation';
    $pageUrls['payment'] =  $pageSiteUrl . 'payment/';
    $pageUrls['payment_ebsProcessingPage'] =   $pageSiteUrl . "payment/ebsProcessingPage";
    $pageUrls['payment_amazonpayProcessingPage'] =   $pageSiteUrl . "payment/amazonpayProcessingPage";
    $pageUrls['payment_mobikwikProcessingPage'] =   $pageSiteUrl . "payment/mobikwikProcessingPage";
    $pageUrls['payment_paytmProcessingPage'] =   $pageSiteUrl . "payment/paytmProcessingPage";
    $pageUrls['payment_paypalProcessingPage'] =   $pageSiteUrl . "payment/paypalProcessingPage";
    $pageUrls['payment_paypalPreparePage'] =   $pageSiteUrl . "payment/paypalPrepare";
    $pageUrls['payment_paypalExecuteApi'] =   $pageSiteUrl . "api/payment/paypalExecute";

    //$pageUrls['payment_myWalletOtpGeneration'] =   $pageSiteUrl . "payment/myWalletOtpGeneration";
    $pageUrls['api_myWalletOtpGeneration'] =   $pageSiteUrl . "api/mywallet/myWalletOtpGeneration";
    //$pageUrls['payment_myWalletValidateotp'] =   $pageSiteUrl . "payment/myWalletValidateotp";
    $pageUrls['api_myWalletValidateotp'] =  $pageSiteUrl."api/booking/processWalletTransaction";
    $pageUrls['api_getTransactions'] =   $pageSiteUrl . "api/mywallet/getTransactions";
    $pageUrls['api_myWalletAddFund'] =   $pageSiteUrl . "api/mywallet/addMoneyToWallet";
    $pageUrls['api_processAddMoneyToWallet'] =   $pageSiteUrl . "mywallet/processAddMoneyToWallet";
    $pageUrls['api_redeemPoints'] =   $pageSiteUrl . "api/mywallet/redeemPoints";
    $pageUrls['bugbounty'] =   $pageSiteUrl."bugbounty";
    $pageUrls['thecollegefever'] =   $pageSiteUrl."thecollegefever";
    $pageUrls['mesitemap'] =   $pageSiteUrl."mesitemap";
    $pageUrls['support'] =   $pageSiteUrl."support";//"http://support.meraevents.com/anonymous_requests/new";
    $pageUrls['contactUs'] =   $pageSiteUrl."support";
    $pageUrls['contactUsForm'] =   $pageSiteUrl."contact";
    $pageUrls['privacypolicy'] =   $pageSiteUrl."privacypolicy";
    $pageUrls['dashboard-global-affliate-home'] = $pageSiteUrl . "globalaffiliate/home";
    $pageUrls['dashboard-global-affliate-why'] = $pageSiteUrl . "globalaffiliate/why";
    $pageUrls['dashboard-global-affliate'] = $pageSiteUrl . "globalaffiliate/join";
    $pageUrls['dashboard-global-affliate-faq'] = $pageSiteUrl . "globalaffiliate/faq";
    $pageUrls['dashboard-global-affliate-bonus'] = $pageSiteUrl . "profile/index/affiliateBonus";
    $pageUrls['dashboard-ticketTransfer'] = $pageSiteUrl . "dashboard/ticketTransfer/";
    $pageUrls['dashboard-incompletetransaction-comment'] = $pageSiteUrl . "dashboard/transactionComment/";

    $pageUrls['api_updateCustomfieldsData']=$pageSiteUrl.'api/reports/updateCustomFieldsData';
    $pageUrls['api_commonRequestProcessRequest'] =   $pageSiteUrl . "api/common_requests/processRequest";
    $pageUrls['api_subcategoryList'] =   $pageSiteUrl . "api/subcategory/list";
    $pageUrls['api_countryDetails'] =   $pageSiteUrl . "api/country/details";
    $pageUrls['api_checkUrlExists'] =   $pageSiteUrl . "api/event/checkUrlExists";
    $pageUrls['api_subcategoryEventsCount'] =   $pageSiteUrl . "api/subcategory/eventsCount";
    $pageUrls['api_categoryEventsCount'] =   $pageSiteUrl . "api/category/eventCount";
    $pageUrls['api_cityEventsCount'] =   $pageSiteUrl . "api/city/eventCount";
    $pageUrls['api_filterEventsCount'] =   $pageSiteUrl . "api/filter/eventCount";
    $pageUrls['api_categorycityEventsCount'] =   $pageSiteUrl . "api/category/cityEventsCount";
    $pageUrls['api_subcategorycityEventsCount'] =   $pageSiteUrl . "api/subcategory/cityEventsCount";
    $pageUrls['api_bannerList'] =   $pageSiteUrl . "api/banner/list";
    $pageUrls['api_stateList'] =   $pageSiteUrl . "api/state/list";
    $pageUrls['api_cityCitysByState'] =   $pageSiteUrl . "api/city/citysByState";
    $pageUrls['api_eventList'] =   $pageSiteUrl . "api/event/list";
    $pageUrls['api_eventEventsCount'] =   $pageSiteUrl . "api/event/eventCount";
    $pageUrls['api_searchSearchEvent'] =   $pageSiteUrl . "api/search/searchEvent";
    $pageUrls['api_searchSearchEventAutocomplete'] =   $pageSiteUrl . "api/search/searchEventAutocomplete";
    $pageUrls['api_UsersignupEmailCheck'] =   $pageSiteUrl . "api/user/signupEmailCheck";
    $pageUrls['api_Usersignup'] =   $pageSiteUrl . "api/user/signup";
    $pageUrls['api_UserLogin'] =   $pageSiteUrl . "api/user/login";
    $pageUrls['resendActivationLink'] =   $pageSiteUrl . "resendActivationLink";
    $pageUrls['api_UserchangePassword'] =   $pageSiteUrl . "api/user/changePassword";
    $pageUrls['api_ticketCalculateTaxes'] =   $pageSiteUrl . "api/ticket/calculateTaxes";
    $pageUrls['api_blogBloglist'] =   $pageSiteUrl . "api/blog/blogList";
    $pageUrls['api_eventMailInvitations'] =   $pageSiteUrl . "api/event/mailInvitations";
    $pageUrls['api_tagsList'] =   $pageSiteUrl . "api/tag/list";
    $pageUrls['api_ticketDelete'] =   $pageSiteUrl . "api/ticket/delete";
    $pageUrls['api_eventCreate'] =   $pageSiteUrl . "api/event/create";
    $pageUrls['api_eventEdit'] =   $pageSiteUrl . "api/event/edit";
    $pageUrls['api_dashboardEventchangeStatus'] =   $pageSiteUrl . "api/event/changeStatus";
    $pageUrls['api_promoteofflineTickets'] =   $pageSiteUrl . "api/promote/offlineTickets";
    $pageUrls['api_promoteticketsData'] =   $pageSiteUrl . "api/promote/ticketsData";
    $pageUrls['api_promotesetStatus'] =   $pageSiteUrl . "api/promote/setStatus";
    $pageUrls['api_org_promotesetStatus'] =   $pageSiteUrl . "api/promote/setOrgStatus";
    $pageUrls['api_bookingOfflineBooking'] =   $pageSiteUrl . "api/booking/offlineBooking";
    $pageUrls['url_dashboardReports'] =   $pageSiteUrl . "dashboard/reports";
    $pageUrls['api_reportsGetReportDetails'] =   $pageSiteUrl . "api/reports/getReportDetails";
    $pageUrls['api_promoteattendeeSampleCsv'] =   $pageSiteUrl . "api/promote/attendeeSampleCsv";
    $pageUrls['api_promotedownloadattendeeSampleCsv'] =   $pageSiteUrl . "api/promote/downloadAttendeeSampleCsv";
    $pageUrls['api_customTemplateInsert'] =   $pageSiteUrl . "dashboard/customtemplate/ajaxTemplateInsert";
    $pageUrls['api_promotecustomimageupload'] =   $pageSiteUrl . "api/promote/customImage";
    //$pageUrls['api_reportsExportTransactions'] =   $pageSiteUrl . "api/reports/exportTransactions";
    $pageUrls['api_reportsExportTransactions'] =   site_url() . "download/downloadCsv";
    $pageUrls['api_reportsDownloadImages'] =   $pageSiteUrl . "api/reports/downloadImages";
    $pageUrls['api_reportsEmailTransactions'] =   $pageSiteUrl . "api/reports/emailTransactions";
    $pageUrls['api_apiTransactions'] =   $pageSiteUrl . "api/dashboard/getThirdPartyTransactions";
    $pageUrls['apiTransactions'] =   $pageSiteUrl . "dashboard/apitransactions";
    $pageUrls['api_collaboratorAdd'] =   $pageSiteUrl . "api/collaborator/add";
    $pageUrls['api_collaboratorUpdateStatus'] =   $pageSiteUrl . "api/collaborator/updateStatus";
    $pageUrls['api_collaboratorUpdate'] =   $pageSiteUrl . "api/collaborator/Update";
    $pageUrls['api_collaboratorResendEmail'] =   $pageSiteUrl .'api/collaborator/collaboratorResendEmail';
    $pageUrls['api_deleteCollaboratorEmail'] =   $pageSiteUrl .'api/collaborator/deleteCollaborator';
    $pageUrls['dasboard-configureAddcustomfields'] =   $pageSiteUrl . "dashboard/configure/addcustomfields";
    $pageUrls['api_configureGetDashboardEventCustomFields'] =   $pageSiteUrl . "api/configure/getDashboardEventCustomFields";
    $pageUrls['api_configureUpdateStatus'] =   $pageSiteUrl . "api/configure/updateStatus";
    $pageUrls['api_reportsGetWeekwiseSales'] =   $pageSiteUrl . "api/reports/getWeekwiseSales";
    $pageUrls['api_reportsSalesEffortReports'] =   $pageSiteUrl . "api/reports/salesEffortReports";
    $pageUrls['api_commonrequestsUpdateCookie'] =   $pageSiteUrl . "api/common_requests/updateCookie";
    $pageUrls['api_userGetUserData'] =   $pageSiteUrl . "api/user/getUserData";
    $pageUrls['api_sendTicketsoldDataToorganizer'] =   $pageSiteUrl . "api/ticket/sendTicketsoldDataToorganizer";
    $pageUrls['api_getEvents'] =   $pageSiteUrl . "api/dashboard/getEvents";
    $pageUrls['api_copyEvent'] =   $pageSiteUrl . "api/event/copyEvent";
    $pageUrls['api_deleteEvent'] =   $pageSiteUrl . "api/event/deleteEvent";
    $pageUrls['api_organizationEvents'] =   $pageSiteUrl . "api/organization/list";
    $pageUrls['api_organizerContactEmails'] =   $pageSiteUrl . "api/organization/contactOrg";
    $pageUrls['api_updateSeats'] =   $pageSiteUrl . "api/seating/updateSeats";
    $pageUrls['api_checkUpdateSeats'] =   site_url() . "api/seating/checkUpdateSeats";
    $pageUrls['api_updateSeatsio'] =   site_url() . "api/seating/updateSeatsio";
    $pageUrls['api_checkUserNameExist'] =   site_url() . "api/user/userNameCheck";
    $pageUrls['api_UsermobileverifyOTP'] =   site_url() . "api/user/userMobileVerifyOtp";
    $pageUrls['api_UserOTPGen'] =   site_url() . "api/user/userOTPGen";
    $pageUrls['api_resendDelegateEmail'] =  $pageSiteUrl.'api/transaction/resendTransactionSuccessEmailToDelegate';
    $pageUrls['api_sendemailtopastatt'] = $pageSiteUrl . "api/promote/viralEmailToPastAttendees";
    $pageUrls['api_insertSingleUser'] = $pageSiteUrl . "api/promote/insertSingleUser";
    $pageUrls['api_globalPromoter'] =   $pageSiteUrl . "api/promote/addGlobalPromoter";
    $pageUrls['api_checkGlobalCodeAvailability'] =   $pageSiteUrl . "api/promote/checkGlobalCodeAvailability";
    $pageUrls['microsite_shivkhera'] =  $pageSiteUrl.'shivkhera';
    $pageUrls['api_getProfileDropdown'] =   site_url() . "api/user/getProfileDropdown";
    $pageUrls['api_getCustomFields'] =   site_url() . "api/configure/getCustomFields";
    $pageUrls['api_checkBankDetailsFilled'] =   site_url() . "api/profile/isBankDetailsFilled";
    $pageUrls['api_getVenueEvents'] =   site_url() . "api/venue/events";
    $pageUrls['api_getVenues'] =   site_url() . "api/venue/list";
    $pageUrls['dashboard-curation'] = $pageSiteUrl . "dashboard/configure/curation/";
    $pageUrls['api_deleteCurationValue'] = $pageSiteUrl . "api/delegate_validations/deleteCurationValue/";
    $pageUrls['api_addCurationValue'] = $pageSiteUrl . "api/delegate_validations/addCurationValue/";
    $pageUrls['api_updateCurationValue'] = $pageSiteUrl . "api/delegate_validations/updateCurationValue/";
    $pageUrls['api_getTinyUrl'] = $pageSiteUrl . "api/event/getTinyUrl";
    $pageUrls['api_updateEventViewCount'] = $pageSiteUrl . "api/event/updateEventViewCount";
    $pageUrls['api_updateOrgCommentData']=$pageSiteUrl.'api/reports/updateOrgCommentData';
    //$pageUrls['api_getEventViewCount'] = $pageSiteUrl . "api/event/getEventViewCount";
    $pageUrls['features'] = $pageSiteUrl . "features";
    $pageUrls['why_meraevents'] = $pageSiteUrl . "why_meraevents";
    $pageUrls['accountManager']=$pageSiteUrl ."dashboard/accountmanager/";
    $pageUrls['networkingApp']=$pageSiteUrl ."networking";
    $pageUrls['checkinApp']=$pageSiteUrl ."checkin";
    $pageUrls['organizerEvaluation'] = $pageSiteUrl ."profile/index/organizerEvaluation";
    $pageUrls['send_mail_for_callback']=$pageSiteUrl ."dashboard/accountmanager/send_mail_for_callback/";
    $pageUrls['send_sms']=$pageSiteUrl ."dashboard/accountmanager/send_sms";
    $pageUrls['saveWidgetSettings']=$pageSiteUrl ."dashboard/configure/saveWidgetSettings";
    $pageUrls['orgPromoterCommissionEdit'] = $pageSiteUrl . "dashboard/promote/editOrgPromoterCommission/";
    $pageUrls['promoterEventCommissionEdit'] = $pageSiteUrl . "dashboard/promote/editEventPromoterCommission/";
    $pageUrls['api_add_bookmark']=$pageSiteUrl.'api/bookmark/saveBookmark';
    $pageUrls['api_remove_bookmark']=$pageSiteUrl.'api/bookmark/removeBookmark';
    $pageUrls['bookmarked']=$pageSiteUrl.'home/bookmarked';
    $pageUrls['pastbookmarked']=$pageSiteUrl.'home/pastbookmarked';
    $pageUrls['api_pasteventList'] =   $pageSiteUrl . "api/event/pastlist";
    $pageUrls['dashboard-spot-registration'] =   $pageSiteUrl . "dashboard/promote/spotRegistration/";
    $pageUrls['dashboard-marketing-resources'] = $pageSiteUrl . "dashboard/promote/marketing/";
    $pageUrls['dashboard-add-marketing-resources'] = $pageSiteUrl . "dashboard/promote/addresource/";
    $pageUrls['api-resource-status'] = $pageSiteUrl . "api/promote/setResourceStatus";
    $pageUrls['dashboard-ticketGroupig'] = $pageSiteUrl ."dashboard/ticketgroups/groupslist/";
    $pageUrls['dashboard-add_TicketGroup_View'] = $pageSiteUrl ."dashboard/ticketgroups/addgroup/";
    $pageUrls['dashboard-CreateNewTicketGroup'] = $pageSiteUrl ."dashboard/ticketgroups/createNewTicketGroup/";
    $pageUrls['dashboard-editTicketGroup'] = $pageSiteUrl ."dashboard/ticketgroups/editTicketGroup/";
    $pageUrls['dashboard-deleteTicketGroup'] = $pageSiteUrl ."dashboard/ticketgroups/delete/";
    $pageUrls['dashboard-socialWidgets'] = $pageSiteUrl ."dashboard/promote/socialwidgets/";
    $pageUrls['dashboard-recurring'] = $pageSiteUrl ."dashboard/recurringpayment";
    $pageUrls['dashboard-recurring-addclient'] = $pageSiteUrl ."dashboard/recurringpayment/addClient";
    $pageUrls['dashboard-recurring-payments'] = $pageSiteUrl ."dashboard/recurringpayment";
    $pageUrls['dashboard-recurring-customers'] = $pageSiteUrl ."dashboard/recurringpayment/customers";
    $pageUrls['dashboard-recurring-createsubscription'] = $pageSiteUrl ."dashboard/recurringpayment/subscription/create";
    $pageUrls['dashboard-recurring-listsubscription'] = $pageSiteUrl ."dashboard/recurringpayment/listSubscriptions";
    $pageUrls['dashboard-recurring-createplan'] = $pageSiteUrl ."dashboard/recurringpayment/plan/create";
    $pageUrls['dashboard-recurring-listplans'] = $pageSiteUrl ."dashboard/recurringpayment/listPlans";
    $pageUrls['dashboard-recurring-complete'] = $pageSiteUrl ."dashboard/recurringpayment/addClient/complete/";

    $pageUrls['organizerProfile']=$pageSiteUrl ."dashboard/accountmanager/orgProfile";
    $pageUrls['organizerProfileindex']=$pageSiteUrl ."dashboard/accountmanager/orgPage";

    $pageUrls['dashboard-errorcsvdownload'] = $pageSiteUrl . "dashboard/promote/errorCsvDownload/";
    $pageUrls['magage_organizer'] = $pageSiteUrl . "dashboard/organization";
    //Association Links
    $pageUrls['association'] = $pageSiteUrl . "dashboard/association";
    $pageUrls['association_dashboard'] = $pageSiteUrl . "dashboard/association/dashboard";
    $pageUrls['association_profile'] = $pageSiteUrl . "dashboard/association/profile";
    $pageUrls['association_chapters'] = $pageSiteUrl . "dashboard/association/chapters";
    $pageUrls['add-chapter'] = $pageSiteUrl . "dashboard/association/addchapter";
    $pageUrls['edit-chapter'] = $pageSiteUrl . "dashboard/association/editchapter";
    $pageUrls['delete-chapter'] = $pageSiteUrl . "dashboard/association/deletechapter";
    $pageUrls['association_members'] = $pageSiteUrl . "dashboard/association/members";
    $pageUrls['association_membershiptypes'] = $pageSiteUrl . "dashboard/association/membershiptypes";
    $pageUrls['add-membership-type'] = $pageSiteUrl . "dashboard/association/addmembershiptype";
    $pageUrls['edit-membership-type'] = $pageSiteUrl . "dashboard/association/editmembershiptype";
    $pageUrls['delete-membership-type'] = $pageSiteUrl . "dashboard/association/deletemembershiptype";
    $pageUrls['url-exists'] = $pageSiteUrl . "dashboard/association/checkNameExists";
    $pageUrls['my_memberships'] = $pageSiteUrl . "dashboard/mymemberships";
    $pageUrls['user-partial-payments'] = $pageSiteUrl . "profile/index/userpartialpayments";
    $pageUrls['partial-payment-event-details'] = $pageSiteUrl . "profile/index/paymentdetails";
    $pageUrls['view-chapter-members'] = $pageSiteUrl . "dashboard/association/viewChapterMembers";
    $pageUrls['chapter-reports'] = $pageSiteUrl . "dashboard/association/chapterReports";
    $pageUrls['export-report'] = $pageSiteUrl . "dashboard/association/export";
    $pageUrls['association-add-new-member'] = $pageSiteUrl . "dashboard/association/addNewMember";
    $pageUrls['association-update-profile-pic'] = $pageSiteUrl . "dashboard/association/updateProfilePic";
    $pageUrls['assocation-get-membership-type-options'] = $pageSiteUrl . "dashboard/association/getMembershipTypeOptions";
    $pageUrls['assocation-get-membership-type-custom-fields'] = $pageSiteUrl . "dashboard/association/getMembershipTypeCustomFields";
    $pageUrls['organization_razorpayProcessingPage'] = $pageSiteUrl . "organizationpayment/razorpayProcessingPage";
    $pageUrls['organization_amazonpayProcessingPage'] = $pageSiteUrl . "organizationpayment/amazonpayProcessingPage";
    $pageUrls['organization_ebsProcessingPage'] = $pageSiteUrl . "organizationpayment/ebsProcessingPage";
    $pageUrls['organization_paypalProcessingPage'] = $pageSiteUrl . "organizationpayment/paypalProcessingPage";
    $pageUrls['membership_confirmation'] = $pageSiteUrl . "organization/confirmation";
    $pageUrls['save_membership'] = $pageSiteUrl . "organization/saveMembership";
    $pageUrls['association-custom-fields'] = $pageSiteUrl . "dashboard/association/customfields";
    $pageUrls['association-add-custom-fields'] = $pageSiteUrl . "dashboard/association/addcustomfield";
    $pageUrls['association-edit-custom-fields'] = $pageSiteUrl . "dashboard/association/editcustomfield";
    $pageUrls['association-ordercustom-fields'] = $pageSiteUrl . "dashboard/association/updatecustomfieldorder";
    $pageUrls['association-update-membership-user-profile'] = $pageSiteUrl . "dashboard/association/updateMembershipUserProfile";
    $pageUrls['import-association-members'] = $pageSiteUrl . "dashboard/association/importMembers";
    $pageUrls['association_terms_conditions'] = $pageSiteUrl . "dashboard/association/termsandconditions";
    $pageUrls['save-dontation-tkt-price'] = $pageSiteUrl. "dashboard/promote/upadteTkrPrice";
    $pageUrls['dashboard-enableExternalMeetingLink'] = $pageSiteUrl. "dashboard/configure/enableExternalMeetingLink/";

    if($ci->config->item('https_enabled')== true){
        $pageUrls['api_getTicketCalculation'] = https_url()."api/event/getTicketCalculation";
        $pageUrls['api_bookNow'] =  https_url()."api/event/bookNow";
        $pageUrls['api_bookingSaveData'] =  https_url()."api/booking/saveData";
        $pageUrls['confirmation'] =  https_url() . 'confirmation';
        $pageUrls['payment'] =  https_url() . 'payment';
        $pageUrls['organization_amazonpayProcessingPage'] = https_url() . 'organization/amazonpayProcessingPage';
    }

    $params = str_replace('&', '/', $params);
    $return = (isset($pageUrls[$pageName])) ? $pageUrls[$pageName] : $pageUrls['dashboard-myevent'];
    $return.= (strlen($params) > 0) ? str_replace("&", "/", $params) : "";
    if (strlen($getParams) > 0) {
        $return.= $getParams;
    }
    return $return;
}

function commonHtmlElement($type,$display = 0,$isGuestLogin = 0,$dashboardUrl='')
{
    $returnString = "";
    switch ($type)
    {
        case 'myprofile':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='".commonHelperGetPageUrl('user-myprofile')."'><span class='icon2-user'></span> Profile</a></li>";
            }
            break;
        case 'mywallet':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='".commonHelperGetPageUrl('user-mywallet')."'><span class='icon2-google-wallet'></span> MeraWallet</a></li>";
            }
            break;
        case 'bank-details':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='".commonHelperGetPageUrl('user-bankdetail')."'><span class='icon2-bank'></span> Bank Details</a></li>";
            }
            break;
        case 'myevent':
            if($display == 1 && $isGuestLogin == 0) {
                if($dashboardUrl=='' || $dashboardUrl==' '){$dashboardUrl=  getDashboardUrl();}
                $returnString = "<li><a href='".$dashboardUrl."'><span class='icon-event'></span> Organizer View</a></li>";
            }
            break;
        case 'create-event':
            if($isGuestLogin == 0) {
                $returnString = "<li><a href='".commonHelperGetPageUrl('create-event')."'><span class='icon2-pencil'></span> Create Event</a></li>";
            }
            break;
        case 'account_manager':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='".commonHelperGetPageUrl('accountManager')."'><span class='icon2-user'></span> Account Manager</a></li>";
            }
            break;
        case 'apitransactions':
            if($display == 1 && $isGuestLogin == 0){
                $returnString = "<li><a href='".commonHelperGetPageUrl('apiTransactions').'/all/all/'.date("m-d-Y",strtotime('-3 days')).'/'.date("m-d-Y").'/1'."'><span class='icon2-cogs'></span> API Transactions</a></li>";
            }
            break;
        case 'logout':
            if($display == 1) {
                $returnString = "<li><a href='".commonHelperGetPageUrl('user-logout')."'><span class='icon2-sign-out'></span> Logout</a></li>";

            } else {
                $returnString = "<li><a href='".commonHelperGetPageUrl('user-login')."' target='_self'><span class='icon2-sign-in' ></span> Login</a></li>";

            }
            break;
        case 'savedevent':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='".commonHelperGetPageUrl('user-savedevent')."'><span class='icon2-bookmark' ></span> Saved Events</a></li>";
            }
            break;
        case 'attendeeview':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='".  getAttendeeUrl()."'><span class='icon2-ticket' ></span> Attendee View</a></li>";
            }
            break;
        case 'promoterview':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='". getPromoterViewUrl()."'><span class='icon2-bullhorn' ></span> Promoter View</a></li>";
            }
            break;
        case 'dashboardButton':
            if($display == 1 && $isGuestLogin == 0) {
                if($dashboardUrl==''||$dashboardUrl==' '){$dashboardUrl=getDashboardUrl();}
                $returnString = "<a href='".$dashboardUrl."' class='btn btn-default pinkColor colorWhite'>dashboard</a>";
            }
            break;
        case 'bookmarked':
            if($display == 1) {
                $returnString = "<li><a href='".commonHelperGetPageUrl('bookmarked')."'><span class='icon2-bookmark'></span>Bookmark Events</a></li>";
            }
            break;
        case 'dashboard-organizer-affliates':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='". commonHelperGetPageUrl('dashboard-organizer-affliates')."'><span class='icon2-bullhorn' ></span> Affiliates</a></li>";
            }
            break;
        case 'manage_organizer':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='". commonHelperGetPageUrl('magage_organizer')."'><span class='icon2-bullhorn' ></span> Manage Organizer</a></li>";
            }
            break;
        case 'manage_association':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='". commonHelperGetPageUrl('association')."'><span class='icon2-group' ></span> Manage Association</a></li>";
            }
            break;
        case 'subowner':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='". commonHelperGetPageUrl('dashboard-sub-user-reports')."'><span class='icon2-list' ></span> Sub User Reports</a></li>";
            }
            break;
        case 'my_memberships':
            if($display == 1 && $isGuestLogin == 0) {
                $returnString = "<li><a href='". commonHelperGetPageUrl('my_memberships')."'><span class='icon2-group' ></span>My Memberships</a></li>";
            }
            break;

    }
    return $returnString;
}

function commonHelperDownload($file) {
    $ci = &get_instance();
    $file = $ci->input->get("filePath");
    if (strlen($file) > 0) {
        $ci->load->helper('download');
        //$data = file_get_contents($file); // Read the file's contents

        $filePathInfo = pathinfo($file);
        $filebasename = urlencode($filePathInfo['basename']);

        $actualfile=$filePathInfo['dirname']."/".$filebasename;
        $data =url_get_contents($actualfile);
        $name = urlencode(basename($file));
        force_download($name, $data);
    } else {
        echo "Oops..!, something went wrong. Please try again.";
    }
}

function random_password($length = 6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr(str_shuffle($chars), 0, $length);
    return $password;
}

//To check the string is in md5 or not
function isValidMd5($md5 = '') {
    return strlen($md5) == 32 && ctype_xdigit($md5);
}

//To format to mysql date format(Y-m-d H:i:s)
function formatToMysqlDate($inputArray) {
    $date = $inputArray['date'];
    $time = $inputArray['time'];

    $dateSplit = explode('/', $date);
    $month = $dateSplit[0];
    $day = $dateSplit[1];
    $year = $dateSplit[2];
    $finalDate = $year . '-' . $month . '-' . $day;

    $timeSplit = explode(' ', $time);
    $dateTime = $finalDate . " " . $timeSplit[0] . " " . $timeSplit[1];

    $finalDateTime = date('Y-m-d H:i:s', strtotime($dateTime));
    return $finalDateTime;
}

/**
 *
 * @param type $dateTime
 * @param type $timeZoneName
 * @param type $utc default false convert the passed  datetime to utc time
 * $utc passed as true convert the utc datetime to passed timezone format
 * @return type
 */
function convertTime($dateTime, $timeZoneName, $utc = FALSE) {
    if (!$utc) {
        $sourceTimeZone = $timeZoneName;
        $destinationTimeZone = "UTC";
    } else {
        $sourceTimeZone = "UTC";
        $destinationTimeZone = $timeZoneName;
    }
    $date = new DateTime($dateTime, new DateTimeZone($sourceTimeZone));
    $date->setTimezone(new DateTimeZone($destinationTimeZone));
    return $date->format('Y-m-d H:i:s');
}

/**
 * @param type $dateTime
 * @param type $timeZoneName
 * @param type $utc default false convert the passed  datetime to utc time
 * $utc passed as true convert the utc datetime to passed timezone format
 * @return statr date with timzone format
 */
function appendTimeZone($dateTime, $timeZoneName, $utc = FALSE) {
    $sourceTimeZone = $timeZoneName;
    $destinationTimeZone = $timeZoneName;
    $date = new DateTime($dateTime, new DateTimeZone($sourceTimeZone));
    $checkDate=$date->setTimezone(new DateTimeZone($destinationTimeZone));
    $timeformat= date_format($checkDate, 'Y-m-d H:i:sP');
    $date_frmt= explode(" ", $timeformat);
    $date= $date_frmt[0];
    $time= $date_frmt[1];
    return $finalTime=$date.'T'.$time;
}

/**
 * To get the ticket type related enum value
 * @param type $ticketTypeNo
 * @return int
 */
function getTicketType($ticketTypeNo) {

    switch ($ticketTypeNo) {
        case 1:
            $type = 'free';
            break;
        case 2:
            $type = 'paid';
            break;
        case 3:
            $type = 'donation';
            break;
        case 4:
            $type = 'addon';
            break;
        default:
            $type = 2;
    }
    return $type;
}

/* * To remove unwanted characters from string
 * @param type $string
 * @return string
 */

function cleanUrl($string) {
    // Remove special charcters
    $string = preg_replace('/[^A-Za-z0-9_\-]/', ' ', $string);
    // Replacing spaces with "_"
    $string = str_replace(' ', '-', $string);
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

//Convert the date from (2015-08-24 17:16:00 )format to (14 Apr 2015, 05:20 PM )format
function convertDateTime($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("d M Y\, h:i A", $time);
    return $formattedTime;
}

function commonHelperGetEventName($eventId = 0) {
    $eventName = "";
    $ci = &get_instance();
    $eventData = $ci->config->item('eventData');
    if (isset($eventData["event" . $eventId]['eventName'])) {
        $eventName = $eventData["event" . $eventId]['eventName'];
    }
    return $eventName;
}
function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}


/**
 * If admin logied in we send admin user id othe wise we will
 *  send user related session info
 */
function getSessionUserId(){
    $ci = &get_instance();
    $adminId=$ci->customsession->getData("adminId");
    if ($adminId) {
        return $adminId;
    }
    return getUserId();
}

function onlyCurrentDate(){
    return date('m/d/Y');
}
function currentDateTime(){
    return date('Y-m-d H:i:s');
}
function timeConvert($inputDate){
    return  date('h:i a',strtotime($inputDate));
}
function reminderDate($inputDate){
    return  date('Ymd',strtotime($inputDate));
}
function nowDate($inputDate){
    $timezone = new DateTimeZone($inputDate);
    $date =  new DateTime('', $timezone);
    return $date->format('Y-m-d H:i:s');
}
function seoFormat($inputDate){
    return  date('h:i a',strtotime($inputDate));
}

function lastDateFormat($inputDate){
    return date('d-m-Y', strtotime($inputDate));

}

function convertDate($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("l\, jS M Y", $time);
    return $formattedTime;
}

//Last Date conversion format type 11-04-2015
function convertDateTo($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("F d, Y", $time);
    return $formattedTime;
}

function commonHelperRedirect($url){
    redirect($url,'location',302);exit;
}

function recommendationsUserIdWithSalt($userid) {
    $ci = &get_instance();
    $salt=$ci->config->item('piwik_user_salt');

    $userslat=md5($userid.$salt);
    setcookie("piwikUserId",$userslat , (2592000 + time()));
    return $userslat;
}
function commonhelpergetpiwikuserid($userid){
    $ci = &get_instance();
    return md5($userid.$ci->config->item('piwik_user_salt'));
}
//To get the random generated strings for client id & client scret
function random_strings_for_client() {
    $rand=(time()*rand(1,9)).rand(1000,9999);
    return substr(str_shuffle($rand),0,9);
}

function eventTypeById($registrationType,$eventMode) {


    switch ($registrationType) {
        case '2':
            $type = 'paid';
            break;
        case '1':
            $type = 'free';
            break;
        case 'webinar':
            $eventTypeValues['eventMode'] = 1;
            $eventTypeValues['registrationType'] = 4;
            break;
        case 'nonwebinar':
            $eventTypeValues['eventMode'] = 0;
            $eventTypeValues['registrationType'] = 4;
            break;
        case '4':
            if($eventMode == '1') {
                $type = 'webinar';
            } else {
                $type = 'nonwebinar';
            }

            break;
        case '3':
            $type = 'noreg';
            break;
        default:
            $type = 'paid';
            break;
    }
    return $type;
}

function dataCustomFormat($inputData){
    if(isset($inputData['response']['details']['description']))
    {
        $description = $inputData['response']['details']['description'];
        $description = str_replace("<br />","\n",$description);
        $description = str_replace("</p>","\n\n",$description);
        $description = str_replace("<br>","\n",$description);
        $description = strip_tags($description);
        $inputData['response']['details']['plainDescription'] = $description;
    }
    return $inputData;

}
function commonHelperGetPaytmAuthCode($input){
    $type='';
    switch ($input) {
        case 'ccordc':
            $type = '3D';
            break;
        case 'nb':
            $type = 'USRPWD';
            break;
        case 'wallet':
            $type = 'USRPWD';
            break;
        default:
            $type = '3D';
            break;
    }
    return $type;
}
function commonHelperGetPaytmPaymentTypeId($input){
    $type='';
    switch ($input) {
        case 'cc':
            $type = 'CC';
            break;
        case 'dc':
            $type = 'DC';
            break;
        case 'nb':
            $type = 'NB';
            break;
        case 'wallet':
            $type = 'PPI';
            break;
        default:
            $type = 'CC';
            break;
    }
    return $type;
}

/*IP based location*/
function ip2location($ip){

    require_once(APPPATH . 'handlers/ip2location_handler.php');
    $ip2locationHandler = new Ip2location_handler();

    $inputArray['ip'] = $ip;
    $location = $ip2locationHandler->getLocationDetailsByIP($inputArray);
    //print_r($location); exit;
    return $location;

}

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

/**
 * Append current time stamp along with random string to passed file name
 * @Parm fileName
 */
function appendRandomStringTimeStamp($fileName) {
    $currentTime = strtotime("now");
    $path_parts = pathinfo($fileName);
    $path_parts['filename']=cleanUrl($path_parts['filename']);
    $newFileName = $path_parts['filename'] . $currentTime . commonHelpergenerateRandomString(5) . "." . $path_parts['extension'];
    return $newFileName;
}

/**
 * Append string to passed file name
 * @Parm fileName
 */
function appendStringToFileName($fileName,$addingString) {
    $extension_pos = strrpos($fileName, '.'); // find position of the last dot, so where the extension starts
    $newFileName = substr($fileName, 0, $extension_pos) . $addingString . substr($fileName, $extension_pos);
    return $newFileName;
}

function is_in_array($array, $key, $key_value){
    $within_array = false;
    foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = is_in_array($v, $key, $key_value);
            if($within_array){
                break;
            }
        } else {
            if( $v == $key_value && $k == $key ){
                $within_array = true;
                break;
            }
        }

    }
    return $within_array;
}

//to print 1 as 1st and 2 as 2nd
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function decimalToHours($dec){
    $seconds = ($dec * 3600);
    $hours = floor($dec);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return '-'.$hours." hours -".$minutes." minutes -".$seconds." seconds";
}

function decimalToMinutes($dec){
    $seconds = ($dec * 60);
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return "-".$minutes." minutes -".$seconds." seconds";
}

function decimalToDays($dec){
    $days = floor($dec);
    $decPart = $dec - $days;
    $decPartHours = $decPart * 24;
    $seconds = ($decPartHours * 3600);
    $hours = floor($decPartHours);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return '-'.$days.' days -'.$hours." hours -".$minutes." minutes -".$seconds." seconds";
}

function respond($success = false, $message = "", $data = []){
    return json_encode(["success" => $success,"message" => $message, "data" => $data]);
}

/**
 * To get the url related content based on the passed url
 * @param $url
 * @return url content
 */
function url_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getCurrentTimeUTC() {
    $time = gmdate('Y-m-d\TH:i:s.u\Z', strtotime(date('Y-m-d H:i:s.u')));
    return $time;
}

function convertDate($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("l\, jS M Y", $time);
    return $formattedTime;
}

// Function to convert the mysql date format(2015-08-10 09:00:00 ) to  August 10, 2015
function convertDateTo($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("F d, Y", $time);
    return $formattedTime;
}

function commonHelperRedirect($url){
    redirect($url,'location',302);exit;
}

function recommendationsUserIdWithSalt($userid) {
    $ci = &get_instance();
    $salt=$ci->config->item('piwik_user_salt');

    $userslat=md5($userid.$salt);
    setcookie("piwikUserId",$userslat , (2592000 + time()));
    return $userslat;
}
function commonhelpergetpiwikuserid($userid){
    $ci = &get_instance();
    return md5($userid.$ci->config->item('piwik_user_salt'));
}
//To get the random generated strings for client id & client scret
function random_strings_for_client() {
    $rand=(time()*rand(1,9)).rand(1000,9999);
    return substr(str_shuffle($rand),0,9);
}

function eventTypeById($registrationType,$eventMode) {


    switch ($registrationType) {
        case '2':
            $type = 'paid';
            break;
        case '1':
            $type = 'free';
            break;
        case 'webinar':
            $eventTypeValues['eventMode'] = 1;
            $eventTypeValues['registrationType'] = 4;
            break;
        case 'nonwebinar':
            $eventTypeValues['eventMode'] = 0;
            $eventTypeValues['registrationType'] = 4;
            break;
        case '4':
            if($eventMode == '1') {
                $type = 'webinar';
            } else {
                $type = 'nonwebinar';
            }

            break;
        case '3':
            $type = 'noreg';
            break;
        default:
            $type = 'paid';
            break;
    }
    return $type;
}

function dataCustomFormat($inputData){
    if(isset($inputData['response']['details']['description']))
    {
        $description = $inputData['response']['details']['description'];
        $description = str_replace("<br />","\n",$description);
        $description = str_replace("</p>","\n\n",$description);
        $description = str_replace("<br>","\n",$description);
        $description = strip_tags($description);
        $inputData['response']['details']['plainDescription'] = $description;
    }
    return $inputData;

}
function commonHelperGetPaytmAuthCode($input){
    $type='';
    switch ($input) {
        case 'ccordc':
            $type = '3D';
            break;
        case 'nb':
            $type = 'USRPWD';
            break;
        case 'wallet':
            $type = 'USRPWD';
            break;
        default:
            $type = '3D';
            break;
    }
    return $type;
}
function commonHelperGetPaytmPaymentTypeId($input){
    $type='';
    switch ($input) {
        case 'cc':
            $type = 'CC';
            break;
        case 'dc':
            $type = 'DC';
            break;
        case 'nb':
            $type = 'NB';
            break;
        case 'wallet':
            $type = 'PPI';
            break;
        default:
            $type = 'CC';
            break;
    }
    return $type;
}

/*IP based location*/
function ip2location($ip){

    require_once(APPPATH . 'handlers/ip2location_handler.php');
    $ip2locationHandler = new Ip2location_handler();

    $inputArray['ip'] = $ip;
    $location = $ip2locationHandler->getLocationDetailsByIP($inputArray);
    //print_r($location); exit;
    return $location;

}

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

/**
 * Append current time stamp along with random string to passed file name
 * @Parm fileName
 */
function appendRandomStringTimeStamp($fileName) {
    $currentTime = strtotime("now");
    $path_parts = pathinfo($fileName);
    $path_parts['filename']=cleanUrl($path_parts['filename']);
    $newFileName = $path_parts['filename'] . $currentTime . commonHelpergenerateRandomString(5) . "." . $path_parts['extension'];
    return $newFileName;
}

/**
 * Append string to passed file name
 * @Parm fileName
 */
function appendStringToFileName($fileName,$addingString) {
    $extension_pos = strrpos($fileName, '.'); // find position of the last dot, so where the extension starts
    $newFileName = substr($fileName, 0, $extension_pos) . $addingString . substr($fileName, $extension_pos);
    return $newFileName;
}

function is_in_array($array, $key, $key_value){
    $within_array = false;
    foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = is_in_array($v, $key, $key_value);
            if($within_array){
                break;
            }
        } else {
            if( $v == $key_value && $k == $key ){
                $within_array = true;
                break;
            }
        }

    }
    return $within_array;
}

//to print 1 as 1st and 2 as 2nd
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function decimalToHours($dec){
    $seconds = ($dec * 3600);
    $hours = floor($dec);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return '-'.$hours." hours -".$minutes." minutes -".$seconds." seconds";
}

function decimalToMinutes($dec){
    $seconds = ($dec * 60);
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return "-".$minutes." minutes -".$seconds." seconds";
}

function decimalToDays($dec){
    $days = floor($dec);
    $decPart = $dec - $days;
    $decPartHours = $decPart * 24;
    $seconds = ($decPartHours * 3600);
    $hours = floor($decPartHours);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return '-'.$days.' days -'.$hours." hours -".$minutes." minutes -".$seconds." seconds";
}

function respond($success = false, $message = "", $data = []){
    return json_encode(["success" => $success,"message" => $message, "data" => $data]);
}

/**
 * To get the url related content based on the passed url
 * @param $url
 * @return url content
 */
function url_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getCurrentTimeUTC() {
    $time = gmdate('Y-m-d\TH:i:s.u\Z', strtotime(date('Y-m-d H:i:s.u')));
    return $time;
}

function convertDate($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("l\, jS M Y", $time);
    return $formattedTime;
}

// Function to convert the mysql date format(2015-08-10 09:00:00 ) to  August 10, 2015
function convertDateTo($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("F d, Y", $time);
    return $formattedTime;
}

function commonHelperRedirect($url){
    redirect($url,'location',302);exit;
}

function recommendationsUserIdWithSalt($userid) {
    $ci = &get_instance();
    $salt=$ci->config->item('piwik_user_salt');

    $userslat=md5($userid.$salt);
    setcookie("piwikUserId",$userslat , (2592000 + time()));
    return $userslat;
}
function commonhelpergetpiwikuserid($userid){
    $ci = &get_instance();
    return md5($userid.$ci->config->item('piwik_user_salt'));
}
//To get the random generated strings for client id & client scret
function random_strings_for_client() {
    $rand=(time()*rand(1,9)).rand(1000,9999);
    return substr(str_shuffle($rand),0,9);
}

function eventTypeById($registrationType,$eventMode) {


    switch ($registrationType) {
        case '2':
            $type = 'paid';
            break;
        case '1':
            $type = 'free';
            break;
        case 'webinar':
            $eventTypeValues['eventMode'] = 1;
            $eventTypeValues['registrationType'] = 4;
            break;
        case 'nonwebinar':
            $eventTypeValues['eventMode'] = 0;
            $eventTypeValues['registrationType'] = 4;
            break;
        case '4':
            if($eventMode == '1') {
                $type = 'webinar';
            } else {
                $type = 'nonwebinar';
            }

            break;
        case '3':
            $type = 'noreg';
            break;
        default:
            $type = 'paid';
            break;
    }
    return $type;
}

function dataCustomFormat($inputData){
    if(isset($inputData['response']['details']['description']))
    {
        $description = $inputData['response']['details']['description'];
        $description = str_replace("<br />","\n",$description);
        $description = str_replace("</p>","\n\n",$description);
        $description = str_replace("<br>","\n",$description);
        $description = strip_tags($description);
        $inputData['response']['details']['plainDescription'] = $description;
    }
    return $inputData;

}
function commonHelperGetPaytmAuthCode($input){
    $type='';
    switch ($input) {
        case 'ccordc':
            $type = '3D';
            break;
        case 'nb':
            $type = 'USRPWD';
            break;
        case 'wallet':
            $type = 'USRPWD';
            break;
        default:
            $type = '3D';
            break;
    }
    return $type;
}
function commonHelperGetPaytmPaymentTypeId($input){
    $type='';
    switch ($input) {
        case 'cc':
            $type = 'CC';
            break;
        case 'dc':
            $type = 'DC';
            break;
        case 'nb':
            $type = 'NB';
            break;
        case 'wallet':
            $type = 'PPI';
            break;
        default:
            $type = 'CC';
            break;
    }
    return $type;
}

/*IP based location*/
function ip2location($ip){

    require_once(APPPATH . 'handlers/ip2location_handler.php');
    $ip2locationHandler = new Ip2location_handler();

    $inputArray['ip'] = $ip;
    $location = $ip2locationHandler->getLocationDetailsByIP($inputArray);
    //print_r($location); exit;
    return $location;

}

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

/**
 * Append current time stamp along with random string to passed file name
 * @Parm fileName
 */
function appendRandomStringTimeStamp($fileName) {
    $currentTime = strtotime("now");
    $path_parts = pathinfo($fileName);
    $path_parts['filename']=cleanUrl($path_parts['filename']);
    $newFileName = $path_parts['filename'] . $currentTime . commonHelpergenerateRandomString(5) . "." . $path_parts['extension'];
    return $newFileName;
}

/**
 * Append string to passed file name
 * @Parm fileName
 */
function appendStringToFileName($fileName,$addingString) {
    $extension_pos = strrpos($fileName, '.'); // find position of the last dot, so where the extension starts
    $newFileName = substr($fileName, 0, $extension_pos) . $addingString . substr($fileName, $extension_pos);
    return $newFileName;
}

function is_in_array($array, $key, $key_value){
    $within_array = false;
    foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = is_in_array($v, $key, $key_value);
            if($within_array){
                break;
            }
        } else {
            if( $v == $key_value && $k == $key ){
                $within_array = true;
                break;
            }
        }

    }
    return $within_array;
}

//to print 1 as 1st and 2 as 2nd
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function decimalToHours($dec){
    $seconds = ($dec * 3600);
    $hours = floor($dec);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return '-'.$hours." hours -".$minutes." minutes -".$seconds." seconds";
}

function decimalToMinutes($dec){
    $seconds = ($dec * 60);
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return "-".$minutes." minutes -".$seconds." seconds";
}

function decimalToDays($dec){
    $days = floor($dec);
    $decPart = $dec - $days;
    $decPartHours = $decPart * 24;
    $seconds = ($decPartHours * 3600);
    $hours = floor($decPartHours);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return '-'.$days.' days -'.$hours." hours -".$minutes." minutes -".$seconds." seconds";
}

function respond($success = false, $message = "", $data = []){
    return json_encode(["success" => $success,"message" => $message, "data" => $data]);
}

/**
 * To get the url related content based on the passed url
 * @param $url
 * @return url content
 */
function url_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getCurrentTimeUTC() {
    $time = gmdate('Y-m-d\TH:i:s.u\Z', strtotime(date('Y-m-d H:i:s.u')));
    return $time;
}

function convertDate($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("l\, jS M Y", $time);
    return $formattedTime;
}

// Function to convert the mysql date format(2015-08-10 09:00:00 ) to  August 10, 2015
function convertDateTo($inputDate) {
    $time = strtotime($inputDate);
    $formattedTime = date("F d, Y", $time);
    return $formattedTime;
}

function commonHelperRedirect($url){
    redirect($url,'location',302);exit;
}

function recommendationsUserIdWithSalt($userid) {
    $ci = &get_instance();
    $salt=$ci->config->item('piwik_user_salt');

    $userslat=md5($userid.$salt);
    setcookie("piwikUserId",$userslat , (2592000 + time()));
    return $userslat;
}
function commonhelpergetpiwikuserid($userid){
    $ci = &get_instance();
    return md5($userid.$ci->config->item('piwik_user_salt'));
}
//To get the random generated strings for client id & client scret
function random_strings_for_client() {
    $rand=(time()*rand(1,9)).rand(1000,9999);
    return substr(str_shuffle($rand),0,9);
}

function eventTypeById($registrationType,$eventMode) {


    switch ($registrationType) {
        case '2':
            $type = 'paid';
            break;
        case '1':
            $type = 'free';
            break;
        case 'webinar':
            $eventTypeValues['eventMode'] = 1;
            $eventTypeValues['registrationType'] = 4;
            break;
        case 'nonwebinar':
            $eventTypeValues['eventMode'] = 0;
            $eventTypeValues['registrationType'] = 4;
            break;
        case '4':
            if($eventMode == '1') {
                $type = 'webinar';
            } else {
                $type = 'nonwebinar';
            }

            break;
        case '3':
            $type = 'noreg';
            break;
        default:
            $type = 'paid';
            break;
    }
    return $type;
}

function dataCustomFormat($inputData){
    if(isset($inputData['response']['details']['description']))
    {
        $description = $inputData['response']['details']['description'];
        $description = str_replace("<br />","\n",$description);
        $description = str_replace("</p>","\n\n",$description);
        $description = str_replace("<br>","\n",$description);
        $description = strip_tags($description);
        $inputData['response']['details']['plainDescription'] = $description;
    }
    return $inputData;

}
function commonHelperGetPaytmAuthCode($input){
    $type='';
    switch ($input) {
        case 'ccordc':
            $type = '3D';
            break;
        case 'nb':
            $type = 'USRPWD';
            break;
        case 'wallet':
            $type = 'USRPWD';
            break;
        default:
            $type = '3D';
            break;
    }
    return $type;
}
function commonHelperGetPaytmPaymentTypeId($input){
    $type='';
    switch ($input) {
        case 'cc':
            $type = 'CC';
            break;
        case 'dc':
            $type = 'DC';
            break;
        case 'nb':
            $type = 'NB';
            break;
        case 'wallet':
            $type = 'PPI';
            break;
        default:
            $type = 'CC';
            break;
    }
    return $type;
}

/*IP based location*/
function ip2location($ip){

    require_once(APPPATH . 'handlers/ip2location_handler.php');
    $ip2locationHandler = new Ip2location_handler();

    $inputArray['ip'] = $ip;
    $location = $ip2locationHandler->getLocationDetailsByIP($inputArray);
    //print_r($location); exit;
    return $location;

}

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

/**
 * Append current time stamp along with random string to passed file name
 * @Parm fileName
 */
function appendRandomStringTimeStamp($fileName) {
    $currentTime = strtotime("now");
    $path_parts = pathinfo($fileName);
    $path_parts['filename']=cleanUrl($path_parts['filename']);
    $newFileName = $path_parts['filename'] . $currentTime . commonHelpergenerateRandomString(5) . "." . $path_parts['extension'];
    return $newFileName;
}

/**
 * Append string to passed file name
 * @Parm fileName
 */
function appendStringToFileName($fileName,$addingString) {
    $extension_pos = strrpos($fileName, '.'); // find position of the last dot, so where the extension starts
    $newFileName = substr($fileName, 0, $extension_pos) . $addingString . substr($fileName, $extension_pos);
    return $newFileName;
}

function is_in_array($array, $key, $key_value){
    $within_array = false;
    foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = is_in_array($v, $key, $key_value);
            if($within_array){
                break;
            }
        } else {
            if( $v == $key_value && $k == $key ){
                $within_array = true;
                break;
            }
        }

    }
    return $within_array;
}

//to print 1 as 1st and 2 as 2nd
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function decimalToHours($dec){
    $seconds = ($dec * 3600);
    $hours = floor($dec);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return '-'.$hours." hours -".$minutes." minutes -".$seconds." seconds";
}

function decimalToMinutes($dec){
    $seconds = ($dec * 60);
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return "-".$minutes." minutes -".$seconds." seconds";
}

function decimalToDays($dec){
    $days = floor($dec);
    $decPart = $dec - $days;
    $decPartHours = $decPart * 24;
    $seconds = ($decPartHours * 3600);
    $hours = floor($decPartHours);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    return '-'.$days.' days -'.$hours." hours -".$minutes." minutes -".$seconds." seconds";
}

function respond($success = false, $message = "", $data = []){
