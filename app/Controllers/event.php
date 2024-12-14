<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Default landing page controller
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, Meraevents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0
 * @Created     11-06-2015
 * @Last Modified On  24-06-2015
 * @Last Modified By  Sridevi
 */
//require_once(APPPATH . 'handlers/dashboard_handler.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/solr_handler.php');
require_once(APPPATH . 'handlers/ticket_handler.php');
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/gallery_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once(APPPATH . 'handlers/promoter_handler.php');
require_once(APPPATH . 'handlers/salesperson_handler.php');
require_once(APPPATH . 'handlers/discount_handler.php');
require_once(APPPATH . 'handlers/seodata_handler.php');
require_once(APPPATH . 'handlers/ticketgroups_handler.php');
require_once(APPPATH . 'handlers/corporate_handler.php');
class Event extends CI_Controller {
    const CANCELLED = 3;
    var $eventHandler;
    var $ticketHandler;
    var $geoHandler;
    var $solrHandler;
    var $defaultCountryId;
    var $commonHandler;
    var $salespersonHandler;
    var $ticketgroupsHandler;
    public function __construct() {
        parent::__construct();
        $this->solrHandler = new Solr_handler();
        $this->eventHandler = new Event_handler();
        $this->ticketHandler = new Ticket_handler();
        $this->commonHandler = new Common_handler();
        $this->salespersonHandler = new Salesperson_handler();
        $this->seodataHandler = new Seodata_handler();
        $this->ticketgroupsHandler = new Ticketgroups_handler();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;
    }
    public function index($eventUrl) {
        /*$example = array('meraevents.com','ibm.com','google.com','dell.com');
        $isCorporateUser = false;
        $userId = getUserId();
        if($userId != 0){
            $this->user_handler = new User_handler();
            $validEmail = $this->user_handler->getUserEmailIdByUserId($userId);
            if($validEmail['response']['total'] > 0){
                $userEmail = $validEmail['response']['userData']['email'];
                $userExplode = explode("@",$userEmail);
                if(in_array(end($userExplode),$example)){
                    $isCorporateUser = true;
                }
            }
        }*/
        //Set 0 errors
        $isError = false;
        //Let the application know that it should read from Solr DB
        $eventExisSolrStatus = true;
        //Assign all GET based variables from url to a variable
        $getVar = $this->input->get();
        //Create a new array to store redirect information
        $eventRedirects = array();
        //Get redirects from config
        $eventRedirects = $this->config->item('eventRedirects');
        if(isset($eventRedirects) && $eventRedirects != NULL && in_array($eventUrl, $eventRedirects)){
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".base_url()."newyear");
            exit();
        }
        //Create a new input array
        $inputArray = array();
        //Assign event slug to input array with key uri
        $inputArray['url'] = $eventUrl;
        //Set mapping type to url redirect
        $inputArray['mappingtype'] = "urlredirect";
        //Disable ME discount
        $disableMEDiscount = false;
        $seoUrl = $this->seodataHandler->getSeoData($inputArray);
        //die(json_encode($seoUrl));
        if ($seoUrl['status'] && $seoUrl['response']['total'] > 0) {
            //Convert previous normal slug to SEO optimized slug
            $eventUrl = $seoUrl['response']['seoData'][0]['mappingurl'];
            //Redirects to sites base_uri + '/event/' + $eventSeoSlug
            redirect(commonHelperEventDetailUrl($eventUrl));
        }
        //Check if preview based url was called if so proceed
        if(strtolower($this->uri->segment(1))=='previewevent'){
            //Check if eventId / EventId parameter was set else we cannot fetch event so we redirect them back to home page on such case
            if(!isset($getVar['eventId']) && !isset($getVar['EventId'])){
                //Redirect to home page
                redirect(commonHelperGetPageUrl('home'));
            }
            if(isset($getVar['EventId'])){
                //Redirect function
                commonHelperRedirect(
                    commonHelperGetPageUrl(
                        'event-preview',
                        '',
                        '?view=preview&eventId=' . isset($getVar['EventId']) ? $getVar['EventId'] : $getVar['eventId']
                    )
                );
            }
            //Check if its a pricing url and redirect appropriately
            if(strtolower($this->uri->segment(1))=='pricingtab.php' && isset($getVar['eventid'])){
                $wcode = $getVar['wcode'];
                commonHelperRedirect(
                    commonHelperGetPageUrl(
                        'pricingtab',
                        '',
                        '?EventId=' . $getVar['eventid'].'&wcode='.$wcode
                    )
                );
            }
        }
        //Break down the url by exploding
        $eventUrlExplode = explode("&",$eventUrl);
        //If there are parameters breakdown further
        if(count($eventUrlExplode) > 0){
            //Set event url base
            $eventUrl = $eventUrlExplode[0];
            //Explode the parameters
            $eventUrlParamExplode = explode("=",$eventUrlExplode[1]);
            //Check if the first param is "ucode"
            if($eventUrlParamExplode[0] == 'ucode'){
                $getVar['ucode'] = $eventUrlParamExplode[1];
            }
        }
        //Prepare an array to use to query the Solr database
        $eventExitsSolrArr = array();
        //Make sure to include the event even if its of private type
        $eventExitsSolrArr['private'] = TRUE;
        //Set the url of the event to query
        $eventExitsSolrArr['eventUrl'] = $eventUrl;
        //Check if URL exists and check whether it is published or not
        $eventExistsSolr = $this->solrHandler->getEventByUrl($eventExitsSolrArr);
        //If event doesn't exist in Solr let application know that it doesn't exist
        if(!$eventExistsSolr['status']){
            $eventExisSolrStatus = false;
        }
        //Create a new session key called booking_message
        $this->customsession->setData('booking_message', '');
        //Set page type
        $pageType = isset($getVar['view']) ? $getVar['view'] : '';
        //Set event id
        $eventId = $eventIdGet = isset($getVar['eventId']) ? $getVar['eventId'] : '';
        //Set Referral code
        $referralCode = isset($getVar['reffCode']) ? $getVar['reffCode'] : '';
        //Set promoter code
        $promoterCode = isset($getVar['ucode']) ? $getVar['ucode'] : '';
        //Set Past attendee's referal code
        $pcode = isset($getVar['pcode']) ? $getVar['pcode'] : '';
        //Set Global affiliate
        $aCode = isset($getVar['acode']) ? $getVar['acode'] : '';
        //Set Social Referral code
        $rCode = isset($getVar['rcode']) ? $getVar['rcode'] : '';
        //Set ticket widget
        $ticketWidget = ($getVar['ticketWidget']) ? $getVar['ticketWidget'] : '';
        //Check if its same page or not
        $samepage = ($getVar['samepage']) ? $getVar['samepage'] : 1;
        //Check if its a brand or no brand
        $nobrand = ($getVar['nobrand']) ? $getVar['nobrand'] : '';
        //Check if title should be showed or not
        $showTitle = isset($getVar['title']) ? $getVar['title'] : 1;
        //Set variable to show location or not
        $showLocation = isset($getVar['location']) ? $getVar['location'] : 1;
        //Set variable to show date time or not
        $showDateTime = isset($getVar['dateTime']) ? $getVar['dateTime'] : 1;
        //Set variable to get widget theme
        $widgetTheme = isset($getVar['theme']) ? $getVar['theme'] : 1;
        //Setting redirection variable
        $redirectUrl = isset($getVar['redirectUrl']) ? $getVar['redirectUrl'] : '';
        if(!empty($referralCode) || !empty($promoterCode) || !empty($pcode) || !empty($aCode) || !empty($ticketWidget)){
            $disableMEDiscount = true;
        }
        //Check if pageType is not empty and if its preview else redirect to home
        if( !empty($pageType) && strtolower($pageType) != 'preview'){
            //Redirect to home
            redirect(site_url());
        }
        //If pageType is preview and event id is not empty
        if ($pageType == 'preview' && $eventIdGet != '') {
            //Set variable for event id
            $eventId = $eventIdGet;
            //if event id is missing or is not numeric / integer assume its an attempt to inject and redirect back to home
            if((empty($eventId) || !(is_int($eventId)||is_numeric($eventId)))){
                //Redirect to home
                redirect(site_url());
            }
        } elseif (( !empty($eventId) || ( isset($getVar['EventId']) && !empty($getVar['EventId']) ) ) && $pageType == '') {
            $eventId = !empty($eventId) ? $eventId : $getVar['EventId'];
            $ticketWidget = 'Yes';
        } elseif ($eventUrl != '') {
            //Make sure to include the event even if its of private type;
            //Set the url of the event to query
            //Set status = 1
            //Check if URL exists and check whether it is published or not
            $eventId = $this->solrHandler->getEventByUrl(array(
                'private' => TRUE,
                'eventUrl' => $eventUrl,
                'status' => 1
            ));
            if (!$eventId['status']) {
                //Create a new data array
                $data = array();
                //Prepare cookie data
                $cookieData = $this->commonHandler->headerValues();
                //Check if there is any cookie data
                if (count($cookieData) > 0) {
                    //Set country list in the data array
                    $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
                    //Set the default country id
                    $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
                }
                //Set footer values
                $footerValues = $this->commonHandler->footerValues();
                //Set category list
                $data['categoryList'] = $footerValues['categoryList'];
                //Set city list
                $data['cityList'] = $footerValues['cityList'];
                //Set default country id
                $data['defaultCountryId'] = $this->defaultCountryId;
                //Set error is true
                $isError = true;
            } else {
                //If url exists then set the eventId
                $eventId = $eventExistsSolr['response']['eventId'];
            }
        }
        //$data = array();
        //If there are no errors create a new data array
        if(!$isError) {
            //Update event view count if cookie is not set
            $data['viewCountUp'] = 0;
            //IF cookie is not set then create a new cookie with the event id as the key and 1 view as current view count and 1 day expiry time
            if(!isset($_COOKIE[$eventId])) {
                setcookie($eventId, '1', time() + (86400 * 7), "/");
                //$this->eventHandler->updateEventViewCount($eventId);\
                //Set view count 1
                $data['viewCountUp'] = 1;
            }
            //Create a new request array
            $request = array();
            //Set event id
            $request['eventId'] = $eventId;
            //Get ticket's settings
            $eventTicketOptionSettingsArray = $this->eventHandler->getTicketOptions($request);
            //If we have set options then continue
            if($eventTicketOptionSettingsArray['response']['total'] > 0 ){
                //Set event ticket's settings
                //Set event's datehide option value
                $data['eventTicketOptionSettings']['eventdatehide'] = $eventTicketOptionSettingsArray['response']['ticketingOptions'][0]['eventdatehide'];
                //Show date time or not
                $showDateTime = ($data['eventTicketOptionSettings']['eventdatehide'] == 0) ? 1 : 0;
                //Set event's locationhide option value
                $data['eventTicketOptionSettings']['eventlocationhide'] = $eventTicketOptionSettingsArray['response']['ticketingOptions'][0]['eventlocationhide'];
                //Show location or not
                $showLocation = ($data['eventTicketOptionSettings']['eventlocationhide'] == 0) ? 1 : 0;
                //show similar category events
                $data['eventTicketOptionSettings']['similareventshide'] = $eventTicketOptionSettingsArray['response']['ticketingOptions'][0]['similareventshide'];
                //Show location or not
                $showSimilarCategoryEvents = ($data['eventTicketOptionSettings']['similareventshide'] == 0) ? 1 : 0;
                //set ticket datehide option value
                $data['eventTicketOptionSettings']['ticketdatehide'] = $eventTicketOptionSettingsArray['response']['ticketingOptions'][0]['ticketdatehide'];
            }
            //Getting the Event Details
            $eventDataArr = $this->eventHandler->getEventPageDetails($request);
            //If event is canceled or total tickets = 0 redirect to home page
            if ($eventDataArr['status'] && $eventDataArr['response']['details']['status'] == 3 || $eventDataArr['status'] && $eventDataArr['response']['total'] == 0) {
                redirect(site_url());
            }
            //If event has tickets store event details to a variable
            if ($eventDataArr['status'] && $eventDataArr['response']['total'] > 0) {
                $eventData = $eventDataArr['response']['details'];
            }
            //If canonical url is set but empty set the event's current url as canonical url
            if (isset($eventData['eventDetails']['conanicalurl']) && strlen(trim($eventData['eventDetails']['conanicalurl'])) == 0) {
                $eventData['eventDetails']['conanicalurl'] = $eventData['eventUrl'];
            }
            //If a sales person exists for this event or has been assigned
            if (isset($eventData['eventDetails']['salespersonid']) && $eventData['eventDetails']['salespersonid'] > 0) {
                //Fetch sales person's details
                $salesDataArr = $this->salespersonHandler->getSalesPersonDetails(array(
                    'salesPersonId' => $eventData['eventDetails']['salespersonid']
                ));
                //Sales person's details should be added to event data if data comes up
                if ($salesDataArr['status'] && $salesDataArr['response']['total'] > 0) {
                    $eventData['salesDetails'] = $salesDataArr['response']['details'][0];
                }
            }
        }
        //If referalcode is not empty and there are no errors so far
        if (!empty($referralCode) && !$isError) {
            //Instantiate a new eventsignup handler
            $eventsignupHandler = new Eventsignup_handler();
            //Check if referal code is valid
            $isValidReffCode = $eventsignupHandler->isValidCode(array(
                'type' => 'referal',
                'code' => $referralCode
            ));
            if (isset($isValidReffCode) && $isValidReffCode['status'] && !$isValidReffCode['response']['codeData']['valid']) {
                redirect(commonHelperGetPageUrl('preview-event', $eventUrl));
            }
        }
        //If past attendee referal exists and there are no errors so far
        if (!empty($pcode) && !$isError) {
            //Include logic for pastattendee marketing handler
            require_once(APPPATH . 'handlers/pastattendeemarketing_handler.php');
            //Instantiate a new pastattendee marketing handler
            $pastAttHandler = new Pastattendeemarketing_handler();
            //Check if past attendee's referal code is valid
            $isValidPCode = $pastAttHandler->isValidCode(array(
                'type' => 'pastatt_referral',
                'pcode' => $pcode,
                'eventid' => $eventId
            ));
            if (isset($isValidPCode) && $isValidPCode['status'] && !$isValidPCode['response']['codeData']['valid']) {
                redirect(commonHelperGetPageUrl('preview-event', $eventUrl));
            }
        }
        if (!empty($promoterCode) && !$isError) {
            //if promoter is organizer
            if ($promoterCode == 'organizer') {
                $promoterOutputResponse['status'] = TRUE;
                $promoterOutputResponse['response']['total'] = 1;
            } else {
                //if promoter is affiliate
                $inputCode['type'] = 'affliate';
                $inputCode['code'] = array($promoterCode);
                $inputCode['eventId'] = $eventId;
                $this->promoterHandler = new Promoter_handler();
                $promoterOutputResponse = $this->promoterHandler->getPromoterList($inputCode);
            }
        }
        if (isset($promoterOutputResponse['status']) && isset($promoterOutputResponse['response']['total']) && $promoterOutputResponse['response']['total'] == 0) {
            redirect(commonHelperGetPageUrl('preview-event', $eventUrl));
        }
        if (!empty($aCode) && !$isError) {
            $inputCode['type'] = 'global';
            $inputCode['promoterCode'] = ($aCode);
            $this->promoterHandler = new Promoter_handler();
            $aCodeResponse = $this->promoterHandler->checkPromoterCode($inputCode);
        }
        if (isset($aCodeResponse['status']) && isset($aCodeResponse['response']['total']) && $aCodeResponse['response']['total'] == 0) {
            redirect(commonHelperGetPageUrl('preview-event', $eventUrl));
        }
        if($this->customsession->getData('userId') > 0 && $eventData['private'] == 0){
            $this->promoterHandler = new Promoter_handler();
            $globalPromoterOutputResponse = $this->promoterHandler->getGlobalCode(array(
                'userid' => $this->customsession->getData('userId')
            ));
        }
        if(isset($globalPromoterOutputResponse) && $globalPromoterOutputResponse['status'] && $globalPromoterOutputResponse['response']['total']>0){
            $data['globalPromoterCode']=$globalPromoterOutputResponse['response']['promoterList'][0]['code'];
        }
        //country list
        $data['countryList'] = array();
        $data['eventData'] = $ticketDetails = $ticketIds = array();
        if ($ticketWidget != 'Yes') {
            $cookieData = $this->commonHandler->headerValues();
            if (count($cookieData) > 0) {
                $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
                $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
            }
            $footerValues = $this->commonHandler->footerValues();
            $data['categoryList'] = $footerValues['categoryList'];
            $data['cityList'] = $footerValues['cityList'];
            $data['defaultCountryId'] = $this->defaultCountryId;
            $galleryHandler = new Gallery_handler();
            $galleryImages = $galleryHandler->getEventGalleryList($request);
            if ($galleryImages['status'] && $galleryImages['response']['total'] > 0) {
                $data['gallery'] = $galleryImages["response"]["galleryList"];
            }
        }
        if ($eventData['registrationType'] != 3) {
            $requestTickets = $request;
            //Check if its a Multi Event
            $CMEInput['eventId'] = $eventId;
            $checkResponse = $this->eventHandler->checkIsMultiEvent($CMEInput);
            if($checkResponse['status'] == TRUE){
                $data['multiEvent'] = TRUE;
                $EHInputs['eventId'] = $request['eventId'];
                $EHInputs['masterEventId'] = $request['eventId'];
                $EHresponse = $this->eventHandler->getMultiEventChildIdsSolr($EHInputs);
                $childEventList = $EHresponse['response']['eventList'];
                $data['getParams'] = http_build_query($getVar) . "\n";
            }else{
                $data['multiEvent'] = FALSE;
            }
            //Load Child Event Details for Multi Events
            $childId = $this->uri->segment(3);
            if($pageType == 'preview' || $ticketWidget == 'Yes'){
                if(isset($getVar['sub'])){
                 $childId = $getVar['sub'];
                }   
            }
            //Checking if child event is a valid multi event
            if(isset($childEventList) && strlen($childId) > 0 && $checkResponse['status'] == TRUE && $checkResponse['masterEvent'] == TRUE){
                $childEventId = trim($childId);
                if(in_array($childEventId, $childEventList)){
                    $requestTickets['eventId'] = $childEventId;
                     $childDetailsRes = $this->eventHandler->getEventInfoById(array('eventid' => $childEventId));
                     if($childDetailsRes['status'] == TRUE && $childDetailsRes['response']['total'] > 0){
                         $childEventStartDate = $childDetailsRes['response']['eventInfo'][0]['startdatetime'];
                     }
                }else{
                    if($pageType == 'preview'){
                         $redirectUrl = site_url();
                         redirect($redirectUrl);
                    }
                    $redirectUrl = commonHelperEventDetailUrl($eventUrl);
                    if(strlen($data['getParams']) > 1){
                        $redirectUrl .= '?'.$data['getParams'];
                    }
                    redirect($redirectUrl);
                }
            }
            //Redirecting to home page if child event is used for ticket widget
            if($checkResponse['status'] == TRUE && $checkResponse['masterEvent'] == 0 && $ticketWidget == 'Yes'){
                $redirectUrl = site_url();
                redirect($redirectUrl);
            }
            //Redirecting to home page if child event is used for event preivew
            if($checkResponse['status'] == TRUE && $checkResponse['masterEvent'] == 0 && $pageType == 'preview'){
                $redirectUrl = commonHelperGetPageUrl('event-preview').'?view=preview&eventId='.$checkResponse['parentId'];
                redirect($redirectUrl);
            }

            if($checkResponse['status'] == TRUE){
                if(count($childEventList) > 0){
                    $lastEventId = array_reverse($childEventList);
                    $lastEventId = $lastEventId[0];
                    $lastEventInfoRes = $this->eventHandler->getEventDetails(array('eventId' => $lastEventId));
                    $lastEventInfo = $lastEventInfoRes['response']['details'];
                    $lastEventStartDate = convertTime($lastEventInfo['startDate'],$lastEventInfo['location']['timeZoneName'],false);
                    $lastEventEndDate = convertTime($lastEventInfo['endDate'],$lastEventInfo['location']['timeZoneName'],false);
                    $eventEndDate = convertTime($eventData['endDate'],$eventData['location']['timeZoneName'],false);
                    $eventStartDate = convertTime($eventData['startDate'],$eventData['location']['timeZoneName'],false);
                    if(strtotime(date('Y-m-d h:i:s')) > strtotime($eventEndDate) && strtotime(date('Y-m-d h:i:s')) < strtotime($lastEventStartDate) || strtotime(date('Y-m-d h:i:s')) > strtotime($eventEndDate) && strtotime(date('Y-m-d h:i:s')) > strtotime($lastEventEndDate)){
                        $customDate = $eventStartDate;
                    }elseif(strtotime(date('Y-m-d h:i:s')) > strtotime($lastEventStartDate)){
                        $customDate = $lastEventStartDate;
                    }else{
                        $customDate = date('Y-m-d 00:00:00');
                    }
                }
            }

            
            //Disabling Master Event Tickets
            if(strlen($childId) == 0 && $checkResponse['status'] == TRUE && $checkResponse['masterEvent'] == TRUE){
                $EHIdsInputs['customDate'] = $customDate;
                $EHIdsInputs['masterEventId'] = $EHInputs['masterEventId'];
                $EHresponse = $this->eventHandler->getMultiEventChildIdsSolr($EHIdsInputs);
                $childEventList = $EHresponse['response']['eventList'];
                $requestTickets['eventId'] = $childEventList[0];
                $data['masterEvent'] = TRUE;
            }else{
                $data['masterEvent'] = FALSE;
            }
            if($checkResponse['status'] == TRUE && $ticketWidget != 'Yes'){
                $data['event_url'] = commonHelperEventDetailUrl($eventData['url']);
                if($pageType == 'preview'){
                    $data['event_url'] = commonHelperGetPageUrl('event-preview').'?view=preview&eventId='.$eventId;
                }
                $data['multiEventId'] = $requestTickets['eventId'];
                $data['multiEventUrl'] = $eventUrl;
                $MEHInputs['masterEventId'] = $eventId;
                if(isset($childEventStartDate)){
                    $MEHInputs['customDate'] = $childEventStartDate;
                }else{
                    $MEHInputs['customDate'] = allTimeFormats($customDate, 11);
                }
                $multiEventRes = $this->eventHandler->getMultiEventsSolr($MEHInputs);
                if($multiEventRes['status'] == TRUE && count($multiEventRes['response']['eventList']) > 0){
                    $data['multiEventList'] = $multiEventRes['response']['eventList'];
                }
                //Events with formatted dates for calendar
                $EHInputss['masterEventId'] = $eventId;
                $EHInputss['customDate'] = allTimeFormats($customDate, 11);
                $multiEventDatesResp = $this->eventHandler->getMultiEventsDatesSolr($EHInputss);
                if($multiEventDatesResp['status'] == TRUE && count($multiEventDatesResp['response']['eventList']) > 0){
                    $enableDates = $multiEventDatesResp['response']['eventList'];
                    $data['multiEventListWithDates'] = json_encode($enableDates);
                    $data['enableDates'] = "'" . implode("', '",array_column($enableDates, 'startDate')) . "'";
                }
            }else{
                $EHInputs['masterEventId'] = $eventId;
                $multiEventRes = $this->eventHandler->getMultiEventsSolr($EHInputs);
                if($multiEventRes['status'] == TRUE && count($multiEventRes['response']['eventList']) > 0){
                    $data['multiEventList'] = $multiEventRes['response']['eventList'];
                }
                $data['multiEventId'] = $requestTickets['eventId'];
            }

            $requestTickets['allTickets'] = 0;
            //Set timezone for the event
            $requestTickets['eventTimezoneName'] = $eventData['location']['timeZoneName'];
            // Getting the Tickets list for the Event
            $ticketResponse = $this->ticketHandler->getEventTicketList($requestTickets);
            //If there are tickets then set tax details
            if ($ticketResponse['status'] && $ticketResponse['response']['total'] > 0) {
                $ticketDetailsData = $ticketResponse['response']['ticketList'];
                $taxDetails = isset($ticketResponse['response']['taxDetails']) ? $ticketResponse['response']['taxDetails'] : array();
                $ticketDetails = commonHelperGetIdArray($ticketDetailsData);
                $forwardArray = array();
                foreach($ticketDetails as $value){
                    if($value['soldout'] == TRUE || $value['pastTicket'] == TRUE){
                        $forwardArray[] = $value['id'];
                    }
                }
                if($data['multiEvent'] == TRUE && count($ticketDetails) == count($forwardArray) && strlen($childId) == 0 && $ticketWidget != 'Yes'){
                    $redirect_url = commonHelperEventDetailUrl($eventData['url']).'/'.$childEventList[1];
                    redirect($redirect_url);
                }
                //die(json_encode($ticketDetails));
            }
            foreach ($taxDetails as $key => $value) {
                $ticketDetails[$key]['taxes'] = $taxDetails[$key];
            }
            $ticketIds = array_keys($ticketDetails);
        }
        $eventAddress = array();
        if (isset($eventData['location']['venueName']) && !empty($eventData['location']['venueName'])) {
            $eventAddress[] = $eventData['location']['venueName'];
        }
        if (isset($eventData['location']['address1']) && !empty($eventData['location']['address1'])) {
            $eventAddress[] = $eventData['location']['address1'];
        }
        if (isset($eventData['location']['address2']) && !empty($eventData['location']['address2'])) {
            $eventAddress[] = $eventData['location']['address2'];
        }
        if (isset($eventData['location']['cityName']) && !empty($eventData['location']['cityName'])) {
            $eventAddress[] = " ".$eventData['location']['cityName'];
        }
        if (isset($eventData['location']['stateName']) && !empty($eventData['location']['stateName'])) {
            $eventAddress[] = " ".$eventData['location']['stateName'];
        }
        if (isset($eventData['location']['countryName']) && !empty($eventData['location']['countryName'])) {
            $eventAddress[] = " ".$eventData['location']['countryName'];
        }
        $eventData['fullAddress'] = implode(',',array_unique($eventAddress));
        $eventData['saleButtonTitleList'] = saleButtonTitle();
        $eventData['timeZoneName'] = $eventData['location']['timeZoneName'];
        $seoRequestArray = array();
        $seoRequestArray['eventId'] = $request['eventId'];
        $eventSettingsDataArr = $this->eventHandler->getEventSettings($request);
        if ($eventSettingsDataArr['status'] && $eventSettingsDataArr['response']['total'] > 0) {
            $data['eventSettings'] = $eventSettingsDataArr['response']["eventSettings"][0];
        }
        $seoRequestArray['title'] = isset($eventData['title']) ? $eventData['title'] : '';
        $data['pageTitle']= isset($eventData['eventDetails']['seotitle'])  ? $eventData['eventDetails']['seotitle'] : '';
        if($eventData['eventMode'] == 1){
            $data['sharing_pageTitle'] =  "{$eventData['title']} | MeraEvents.com";
        }
        if(isset($eventData['location']['cityName']) && !empty($eventData['location']['cityName'])  && ($eventData['eventDetails']['seotitle'] == $eventData['title'])) {
            //Title - Place + Date | Brand
            $data['pageTitle'] =  $eventData['title']. ' - ' . $eventData['location']['cityName'] . ' | MeraEvents.com';
        }
        $noIndex = false;
        //is private event or not published
        if ($eventData['private'] == 1 || $eventData['status'] != 1) {
            $noIndex = TRUE;
        }
        $data['seoDetails']['noIndex'] = $noIndex;
        if (!empty($referralCode) && count($ticketIds) > 0) {
            $inputViral['ticketIdArr'] = $ticketIds;
            $viralTickets = $this->ticketHandler->getViralTickets($inputViral);
        }
        /*
        * past attendee marketing code
        */
        if (!empty($pcode) && count($ticketIds) > 0) {
            $inputViral['ticketIdArr'] = $ticketIds;
            $pTickets = $this->ticketHandler->getViralTickets($inputViral);
        }
        $viralResponse = array();
        if (isset($viralTickets) && $viralTickets['status']) {
            if ($viralTickets['response']['total'] > 0) {
                $viralResponse = $viralTickets['response']['viralData'];
            }
        } elseif (isset($viralTickets)) {
            $data['errors'][] = $isValidReffCode['response']['messages'][0];
        }
        foreach ($viralResponse as $viralTicketData) {
            $ticketId = $viralTicketData['ticketid'];
            $ticketDetails[$ticketId]['viralData'] = $viralTicketData;
        }
        //First set normal discount as false because we don't know if a normal type discount exists or not, if it does then we can later set it as true and continue
        $eventData['discountExists'] = true;
        /*$eventData['normalDiscountExists'] = FALSE;
        $eventData['normalGlobalExists'] = FALSE;
        $eventData['cashbackExists'] = FALSE;
        $eventData['combinationExists'] = FALSE;
        $eventData['corporateExists'] = FALSE;
        if ($eventData['registrationType'] != CANCELLED) {
            $this->discountHandler = new Discount_handler();
            if($isCorporateUser){
                $corporateDiscount = $this->discountHandler->getMeraeventsDiscounts(array(
                    'eventId' => $eventId,
                    'discountType' => 'corporate',
                    'pageType' => 'eventdetail'
                ),$disableMEDiscount);
                //Check if user is corporate user and a discount is applicable
                if($corporateDiscount['status'] && $corporateDiscount['response']['total'] > 0){
                    //Set normal discount exists as true
                    $eventData['corporateExists'] = TRUE;
                    $eventData['discountExists'] = FALSE;
                }
            } else {
                //Initiate handler to check if event has any normal discounts
                $normalDiscount = $this->discountHandler->getDiscountData(array(
                    'eventId' => $eventId,
                    'discountType' => 'normal',
                    'pageType' => 'eventdetail'
                ));
                $normalGlobal = $this->discountHandler->getMeraeventsDiscounts(array(
                    'eventId' => $eventId,
                    'discountType' => 'normal_global',
                    'pageType' => 'eventdetail'
                ),$disableMEDiscount);
                //Initiate handler to check if event has any cashback based discount
                $cashback = $this->discountHandler->getMeraeventsDiscounts(array(
                    'eventId' => $eventId,
                    'discountType' => 'cashback',
                    'pageType' => 'eventdetail'
                ),$disableMEDiscount);
                //Initiate handler to check if event has any cashback + % based combination discount
                $combination = $this->discountHandler->getMeraeventsDiscounts(array(
                    'eventId' => $eventId,
                    'discountType' => 'combination',
                    'pageType' => 'eventdetail'
                ),$disableMEDiscount);
                //Check if normal discount exists
                if ($normalDiscount['status'] && $normalDiscount['response']['total'] > 0) {
                    //Assign that discount's data to a variable
                    $eventDiscountArr = $normalDiscount['response']['discountList'][0];
                    //If the item's total usage doesn't exceed usage limit then continue
                    if ($normalDiscount['response']['total'] > 0 && $eventDiscountArr['totalused'] < $eventDiscountArr['usagelimit']) {
                        //Set normal discount exists as true
                        $eventData['normalDiscountExists'] = TRUE;
                        $eventData['discountExists'] = TRUE;
                    }
                }
                elseif($normalGlobal['status'] && $normalGlobal['response']['total'] > 0){
                    //Assign that discount's data to a variable
                    $eventDiscountArr = $normalGlobal['response']['discountCode'][0];
                    if ($normalGlobal['response']['total'] > 0 && $eventDiscountArr['totalused'] < $eventDiscountArr['usagelimit']) {
                        //Set normal discount exists as true
                        $eventData['normalGlobalExists'] = TRUE;
                        $eventData['discountExists'] = TRUE;
                    }
                }
                elseif($cashback['status'] && $cashback['response']['total'] > 0){
                    //Assign that discount's data to a variable
                    $eventDiscountArr = $cashback['response']['discountCode'][0];
                    if ($cashback['response']['total'] > 0 && $eventDiscountArr['totalused'] < $eventDiscountArr['usagelimit']) {
                        //Set normal discount exists as true
                        $eventData['cashbackExists'] = TRUE;
                        $eventData['discountExists'] = TRUE;
                    }
                }
                elseif($combination['status'] && $combination['response']['total'] > 0){
                    //Assign that discount's data to a variable
                    $eventDiscountArr = $combination['response']['discountCode'][0];
                    if ($combination['response']['total'] > 0 && $eventDiscountArr['totalused'] < $eventDiscountArr['usagelimit']) {
                        //Set normal discount exists as true
                        $eventData['combinationExists'] = TRUE;
                        $eventData['discountExists'] = TRUE;
                    }
                }
            }
        }*/
        //Terms & Conditions of event
        $tncType = $eventData['eventDetails']['tnctype'];
        //T&C from organizer
        $organizerTnc = $eventData['eventDetails']['organizertnc'];
        //T&C from Meraevents
        $meraeventsTnc = $eventData['eventDetails']['meraeventstnc'];
        //Check which T&C is application and prioritize checking with organizer first and append appropriate T&C on the details page
        if ($tncType == 'organizer') {
            if ($organizerTnc != '') {
                $data['tncDetails'] = $organizerTnc;
            }
        } else if ($tncType == 'meraevents') {
            if ($meraeventsTnc != '') {
                $data['tncDetails'] = $meraeventsTnc;
            }
        }
        //Global promoters code
        $data['aCode'] = $aCode;
        //Social Referral code
        $data['rCode'] = $rCode;
        //Event data
        $data['eventData'] = $eventData;
        //Tickets & their details
        $data['ticketDetails'] = $ticketDetails;
        //referral code
        $data['referralCode'] = $referralCode;
        //Past attendee referal code
        $data['pcode'] = $pcode;
        //Promoter's code
        $data['promoterCode'] = $promoterCode;
        //Module name
        $data['moduleName'] = 'eventModule';
        //Page name
        $data['pageName'] = 'Event List';
        //Ticket widget
        $data['ticketWidget'] = $ticketWidget;
        //Page type
        $data['pageType'] = $pageType;
        //Samepage or not
        $data['samepage'] = $samepage;
        //Display brand or no
        $data['nobrand'] = $nobrand;
        //Title for the event
        $data['showTitle'] = $showTitle;
        //Show date & time or not
        $data['showDateTime'] = $showDateTime;
        //Det redirect url
        $data['redirectUrl'] = $redirectUrl;
        //Show location or not
        $data['showLocation'] = $showLocation;
        //Check if widget code exists and push it into the data array
        if (isset($getVar['wcode']) && $getVar['wcode'] != '') {
            $data['wCode'] = $getVar['wcode'];
        }
        //Prepare javascript files that are to be imported to the template
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'fixto',
            $this->config->item('js_public_path') . 'lightbox',
            $this->config->item('js_public_path') . 'jquery.validate',
            $this->config->item('js_public_path') . 'common',
            $this->config->item('js_public_path') . 'event',
            $this->config->item('js_public_path') . 'inviteFriends'
        );
        //Prepare css files that are to be imported to the template
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'lightbox',
            $this->config->item('css_public_path') . 'common'
        );
        //
        $data['content'] = 'event_view';
        //Check if errors are present and redirect to error view and tell that event is unpublished
        if ($isError) {
            $data['content'] = 'error_view';
            $data['message'] = str_replace('REDIRECT_URL', site_url(), UNPUBLISHED_EVENT_ERROR);
        }
        //If event doesn't exist send them to a 404 page
        if(!$eventExisSolrStatus){
            $data['content'] = '404_view';
            $data['pageTitle'] = '404 Page Not Found: MeraEvents.com';
        }
        //Set Template
        $template = 'templates/user_template';
        //Set widget theme
        $data['widgettheme'] = $widgetTheme;
        //If ticket has widget continue
        if ($ticketWidget == 'Yes') {
            //If widget theme has been set continue else go with default
            if(isset($widgetTheme) && $widgetTheme>=1){
                //Widget code assign to variable
                $wCode = $getVar['wcode'];
                /*Commenting out these variables since they are no longer used
                    $eventTitleColor = '';
                    $headingBackgroundColor = '';
                    $ticketTextColor = '';
                    $bookNowBtnColor = '';
                */
                //Split widget code
                $wCodeArray = explode('-', $wCode);
                //Assume event's title color from the split code part 1
                $eventTitleColor = $wCodeArray[0];
                //Assume event's heading background color from the split code part 2
                $headingBackgroundColor = $wCodeArray[1];
                //If the color for the split code is white then use the color specified for heading instead of the set color to make sure text is visible
                // else use the set color from code
                if(strtolower($wCodeArray[2]) == 'ffffff'){
                    $ticketTextColor = $wCodeArray[1];
                }else{
                    $ticketTextColor = $wCodeArray[2];
                }
                //Set book now button color
                $bookNowBtnColor = $wCodeArray[3];
                $data['eventTitleColor']=$eventTitleColor;
                $data['headingBackgroundColor']=$headingBackgroundColor;
                $data['ticketTextColor']=$ticketTextColor;
                $data['bookNowBtnColor']=$bookNowBtnColor;
                $data['wCode'] = $getVar['wcode'];
                $data['limitSingleTicketType'] = $eventData['eventDetails']['limitSingleTicketType'];
                $data['buttonName']=!empty($eventData['eventDetails']['bookButtonValue'])?$eventData['eventDetails']['bookButtonValue']:'Book Now';
                $themecss=$this->config->item('css_public_path') . 'ticketwidget/theme'.$widgetTheme.'/theme';
                array_push($data['cssArray'],$themecss);
                $parrenturl=$_SERVER['HTTP_REFERER'];
                if($parrenturl!=''){
                    $logoutstatus=FALSE;
                    if (strpos($parrenturl, site_url()) !== false) {
                        $data['widgetThirdPartyUrl']='';
                        if (strpos($parrenturl, 'orderid=') !== false) {
                            $logoutstatus=TRUE;
                        }
                    }else{
                        $logoutstatus=TRUE;
                        $data['widgetThirdPartyUrl']=$parrenturl;
                    }
                    if(isset($getVar['widgetThirdPartyUrl']) && $getVar['widgetThirdPartyUrl']!=''){
                        $data['widgetThirdPartyUrl'] = $getVar['widgetThirdPartyUrl'];
                    }
                    if($logoutstatus){
                        require_once(APPPATH . 'handlers/user_handler.php');
                        $userHandler = new User_handler();
                        $userHandler->logout();
                    }
                }
                require_once(APPPATH . 'handlers/widgetsettings_handler.php');
                $widgetsettingsHandler = new Widgetsettings_handler();
                $widgetSettings=$widgetsettingsHandler->getWidgetSettings(array('eventid'=>$eventId));
                $widgetdata=array();
                if ($widgetSettings['status'] && count($widgetSettings) > 0 && $widgetSettings['response']['total']>0) {
                    foreach ($widgetSettings['response']['widgetsettings'] as $wskey => $wsvalue) {
                        $widgetdata[$wsvalue['optionname']]=$wsvalue['optionvalue'];
                    }
                }
                $data['showLocation'] = isset($getVar['location']) ? $getVar['location'] : $showLocation;
                $data['showDateTime'] = isset($getVar['dateTime']) ? $getVar['dateTime'] : $showDateTime;
                $data['widgetSettings']=$widgetdata;
                $data['content'] = 'templates/widgets/theme'.$widgetTheme.'/ticket_widget_template';
            }else{
                $data['content'] = 'includes/elements/event_tickets';
            }
            $template = 'templates/ticket_widget_template';
        }
        $data['handlingFeeLable']=$this->config->item('internet_handling_lable');
        $data['ticket_option'] = !empty($getVar['t']) ? $getVar['t'] : '1';
        $data['ticket_option_ids'] = !empty($getVar['tid']) ? $getVar['tid'] : '';
        $data['directDetails'] = isset($getVar['directDetails']) ? $getVar['directDetails'] : 0;
        //Ticket grouping data retrieval starts here
        $ticketDetailsIds=array_keys($ticketDetails);
        $groupInputs=array();
        $groupInputs['eventId']=$eventId;
        $groupInputs['ticketIds']=$ticketDetailsIds;
        $ticketGroups=$this->ticketgroupsHandler->getGroupsWithTickets($groupInputs);
        $data['ticketGroupStatus']=FALSE;
        $ticketGroupsData=array();
        if(isset($ticketGroups['status']) && $ticketGroups['response']['total']>0){
            $data['ticketGroupStatus']=TRUE;
            function orderCmp( $a, $b ){
                if ( $a[order] == $b[order] )
                    return 0;
                if ( $a[order] < $b[order] )
                    return -1;
                return 1;
            }
            foreach ($ticketGroups['response']['ticketgroups'] as $tdkey => $tdvalue) {
                if ($data['ticket_option'] == 3 && !in_array($tdkey, explode(",", $data['ticket_option_ids']))) {
                    continue;
                }
                if(isset($tdvalue['tickets']) && !empty($tdvalue['tickets'])){
                    foreach ($tdvalue['tickets'] as $tkey => $tvalue) {
                        $tdvalue['tickets'][$tkey]['order']=$ticketDetails[$tkey]['order'];
                        if ($data['ticket_option'] == 2 && !empty($data['ticket_option_ids']) && !in_array($tkey, explode(",", $data['ticket_option_ids']))) {
                            unset($tdvalue['tickets'][$tkey]);
                            continue;
                        }
                    }
                    if (empty($tdvalue['tickets'])) {
                        $tdvalue = array();
                    }
                    usort($tdvalue['tickets'], orderCmp );
                    $ticketGroupsData[$tdkey]=$tdvalue;
                }
            }
            $data['ticketGroups']=$ticketGroupsData;
        }else{
            $ticketsData=array();
            foreach ($ticketDetails as $tdikey => $tdivalue) {
                $ticketInput=array();
                $ticketInput['ticketid']=$tdivalue['id'];
                $ticketInput['order']=$tdivalue['order'];
                $ticketsData[]=$ticketInput;
            }
            $ticketGroupsData[0]['id']=1;
            $ticketGroupsData[0]['name']='';
            $ticketGroupsData[0]['order']=1;
            $ticketGroupsData[0]['tickets']=$ticketsData;
            $data['ticketGroups']=$ticketGroupsData;
        }
                
        $this->load->view($template, $data);
    }

    public function live()
    {
        if (isset($_GET['k']) && !empty($_GET['k'])) {
            $salt = "meraeventsencrypt";
            $live_event_attendee = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($salt), base64_decode($_GET['k']), MCRYPT_MODE_CBC, md5(md5($salt))), "\0");
            $eventid_attendeeid = explode("-", $live_event_attendee);
            $eventId = $eventid_attendeeid[0];
            $attendeeid = $eventid_attendeeid[1];
            $eventData = $this->eventHandler->getEventDetails(array('eventId' => $eventId));
            if ($eventData['status']) {
                $eventData1 = $eventData['response']['details'];
                //Check Attendee
                if (isset($_GET['a']) && $_GET['a'] == 1) {
                    $cookieId = get_cookie('liveEvent' . $eventId);
                    if (!empty($cookieId) && $cookieId == $attendeeid) {
                        $data['eventMeetingStart'] = true;
                        $data['eventMeetingId'] = $eventData1['eventDetails']['zoommeetingid'];
                        $data['eventMeetingPassword'] = $eventData1['eventDetails']['zoommeetingpassword'];
                    } else {
                        $this->load->model('Attendee_model');
                        //Get Attendee Details
                        $this->Attendee_model->resetVariable();
                        $select['id'] = $this->Attendee_model->id;
                        $select['joined'] = $this->Attendee_model->joined;
                        $this->Attendee_model->setSelect($select);
                        $where[$this->Attendee_model->id] = $attendeeid;
                        $this->Attendee_model->setWhere($where);
                        $attendeeResponse = $this->Attendee_model->get();
                        if (!empty($attendeeResponse[0]['id']) && $attendeeResponse[0]['joined'] == 0) {
                            $this->Attendee_model->resetVariable();
                            $updatewhere['id'] = $attendeeid;
                            $updateData['joined'] = 1;
                            $this->Attendee_model->setInsertUpdateData($updateData);
                            $this->Attendee_model->setWhere($updatewhere);
                            $response = $this->Attendee_model->update_data();
                            if ($response) {
                                $liveEventCookie = array('name' => 'liveEvent' . $eventId, 'value' => $attendeeid, 'expire' => COOKIE_EXPIRATION_TIME);
                                set_cookie($liveEventCookie);
                                $data['eventMeetingStart'] = true;
                                $data['eventMeetingId'] = $eventData1['eventDetails']['zoommeetingid'];
                                $data['eventMeetingPassword'] = $eventData1['eventDetails']['zoommeetingpassword'];
                            } else {
                                redirect('/');
                            }
                        } else {
                            redirect('/');
                        }
                    }
                }
                $data['isCurrentEvent'] = strtotime($eventData1['endDate']) > strtotime(allTimeFormats('', 11)) ? TRUE : FALSE;
                $data['isEventStarted'] = strtotime($eventData1['startDate']) < strtotime(allTimeFormats('', 11)) ? TRUE : FALSE;
                $data['startDateString'] = date('d F Y H:i:s', strtotime($eventData1['startDate']));
                //Difference between start date & current date
                $datetime1 = new DateTime(allTimeFormats('', 11));
                $datetime2 = new DateTime($eventData1['startDate']);
                $difference = $datetime1->diff($datetime2);
                $data['days_diff'] = $difference->format('%a');
                $data['hours_diff'] = $difference->format('%H');
                $data['mins_diff'] = $difference->format('%i');
                $data['secs_diff'] = $difference->format('%s');
                //Convert to Timezone
                $eventData1['startDate'] = convertTime($eventData1['startDate'], $eventData1['location']['timeZoneName'], TRUE);
                $eventData1['endDate'] = convertTime($eventData1['endDate'], $eventData1['location']['timeZoneName'], TRUE);
                $data['eventMeetingRole'] = 0;
                $data['eventMeetingDisplayName'] = 'Attendee';
                $data['eventDetail'] = $eventData1;
                $data['content'] = 'event_live_attendee_view';
                $data['eventId'] = $eventId;
                $data['pageName'] = 'Live Event';
                $data['pageTitle'] = 'MeraEvents | Live Event';
                $data['key'] = $_GET['k'];
                $this->load->view('templates/live_event_template', $data);
            } else {
                redirect('/');
            }
        } else {
            redirect('/');
        }
    }

}
?>