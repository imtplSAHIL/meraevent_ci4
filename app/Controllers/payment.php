<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Payment page controller
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, MeraEvents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     11-06-2015
 * @Last Modified On  03-08-2015
 * @Last Modified By  Gautam
 */
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/ticket_handler.php');
require_once(APPPATH . 'handlers/tickettax_handler.php');
require_once(APPPATH . 'handlers/discount_handler.php');
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/configure_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once(APPPATH . 'handlers/paymentgateway_handler.php');
require_once(APPPATH . 'handlers/booking_handler.php');
require_once(APPPATH . 'handlers/paytm_handler.php');
require_once (APPPATH . 'handlers/orderlog_handler.php');
require_once (APPPATH . 'handlers/thirdpartypayment_handler.php');
require_once(APPPATH . 'handlers/mywallet_handler.php');
require_once (APPPATH . 'handlers/config_handler.php');

class Payment extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;
        $this->commonHandler = new Common_handler();
    }

    /*
     * Function to display the booking page
     *
     * @access	public
     * @return	Display the Booking form with the custom fields and payment gateways
     */

    public function index() {
        
        // $this->output->enable_profiler(TRUE);
        $commonHandler=new Common_handler();
        $getVar = $this->input->get();
        $orderId = $getVar['orderid'];
		$samepage = $getVar['samepage'];
		$nobrand = $getVar['nobrand'];
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Start Index function Line 56 orderId: $orderId ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($getVar, TRUE));

        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php line 60 below is the session data ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($_SESSION, TRUE));

        //==== If session is empty then we are overriding the session to prevent payment failures ====//
        // if(empty($_SESSION))
        // {
            // $bookingHandler = new Booking_handler();
            //$_SESSION = $bookingHandler->getUserSession($this->commonHandler->get_client_ip());
            // $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php line 69 AFTER OVERRIDING below is the session data ::".date('Y/m/d H:i:s'));
            // $this->commonHandler->log_message(print_r($_SESSION, TRUE));
        // }
        
        $mybrowser = $this->commonHandler->getBrowser();
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line number 65 below is user browser data ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($mybrowser, TRUE));
        
        $incompleteTrans=isset($getVar['incomplete'])?$getVar['incomplete']:false;
        $orderLogDataResponse = $this->soldTicketValidation($orderId);
        $redirectUrl = site_url();
        if (($orderLogDataResponse['status'] && $orderLogDataResponse['response']['total'] == 0) || !$orderLogDataResponse['status']) {
            redirect($redirectUrl);
        }
        $orderLogSessionData = unserialize($orderLogDataResponse['response']['orderLogData']['data']);
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Index function Line 71 after soldTicketValidation  orderId: $orderId ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($orderLogSessionData, TRUE));

        //$ticketCount = count($orderLogSessionData['ticketarray']);
        $selectedTicketData = $orderLogSessionData['ticketarray'];
        $eventId = ($orderLogSessionData['eventid']) ? $orderLogSessionData['eventid'] : '';
        if ($eventId == '') {
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Index function Line 78 redirect happened $redirectUrl orderId: $orderId ::".date('Y/m/d H:i:s'));
            redirect($redirectUrl);
        }
        
        //$data = array();
        $cookieData = $commonHandler->headerValues();
        if (count($cookieData) > 0) {
            $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }
        $data = $cookieData;
        $isExisted = FALSE;
        $orderLogData = $orderLogDataResponse['response']['orderLogData'];

        if ($orderLogData['eventsignup'] > 0 && is_array($orderLogSessionData['paymentResponse']) &&
                ($orderLogSessionData['paymentResponse']['TransactionID'] > 0 || $orderLogSessionData['paymentResponse']['mode'] != '') && $orderLogSessionData['paymentResponse']['mode'] != 'postpayment') {
            $isExisted = TRUE;
        }

        if ($orderLogSessionData['widgetredirecturl'] != '') {
            $data['redirectUrl'] = $orderLogSessionData['widgetredirecturl'];
        }
        if ($orderLogSessionData['referralcode'] != '') {
            $data['referralcode'] = $orderLogSessionData['referralcode'];
        }
        //adding the past attendee referral marketing code
        if ($orderLogSessionData['pastAttReferralCode'] != '') {
            $data['pastAttReferralCode'] = $orderLogSessionData['pastAttReferralCode'];
        }
        if ($orderLogSessionData['promotercode'] != '') {
            $data['promotercode'] = $orderLogSessionData['promotercode'];
        }
        if ($orderLogSessionData['acode'] != '') {
            $data['acode'] = $orderLogSessionData['acode'];
        }

        $footerValues = $commonHandler->footerValues();
        $data['categoryList'] = $footerValues['categoryList'];
        $data['defaultCountryId'] = $this->defaultCountryId;
        $data['calculationDetails'] = $orderLogSessionData['calculationDetails'];
        $data['addonArray'] = isset($orderLogSessionData['addonArray']) ? $orderLogSessionData['addonArray'] : array();

        $courierFee = 0;
        if(isset($orderLogSessionData['calculationDetails']['courierFee']) && $orderLogSessionData['calculationDetails']['courierFee'] > 0){
            $courierFee = 1;
            $data['courierCharge'] = $orderLogSessionData['calculationDetails']['courierFee'];
            $data['courierFeeLabel'] = $orderLogSessionData['calculationDetails']['courierFeeLabel'];
        }elseif(isset($orderLogSessionData['calculationDetails']['courierFee']) && $orderLogSessionData['calculationDetails']['courierFee'] == 0){
            $courierFee = 2;    
        }

        $data['courierFee'] = $courierFee;
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Index function Line 126 orderId: $orderId ::".date('Y/m/d H:i:s'));
        
        /* Getting the Event Details starts here */
        $request['eventId'] = $eventId;
        $eventHandler = new Event_handler();
        $eventDataArr = $eventHandler->getEventLocationDetails($request);
	
        $eventDataArr = $eventHandler->getEventPageDetails($request);
        $eventSettingsDataArr = $eventHandler->getEventSettings($request);

        $courierFee = 0;
        if(isset($orderLogSessionData['calculationDetails']['courierFee']) && $orderLogSessionData['calculationDetails']['courierFee'] > 0 && $eventSettingsDataArr['response']['eventSettings'][0]['courierfee'] == TRUE){
            $courierFee = 1;
            $data['courierCharge'] = $orderLogSessionData['calculationDetails']['courierFee'];
            $data['courierFeeLabel'] = $orderLogSessionData['calculationDetails']['courierFeeLabel'];
        }elseif(isset($orderLogSessionData['calculationDetails']['courierFee']) && $orderLogSessionData['calculationDetails']['courierFee'] == 0 && $eventSettingsDataArr['response']['eventSettings'][0]['courierfee'] == TRUE){
            $courierFee = 2;    
        }
        $data['courierFee'] = $courierFee;

        //Multievent Check
        $CMEInput['eventId'] = $eventId;
        $MEcheckResponse = $eventHandler->checkIsMultiEvent($CMEInput);
        if($MEcheckResponse['status'] == TRUE && $MEcheckResponse['parentId'] > 0){
          $data['masterEventId'] = $MEcheckResponse['parentId'];
        }
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Line 143 ::".date('Y/m/d H:i:s'));
        //print_r($eventDataArr);print_r($eventDetailDataArr);exit;
       $data['eventData'] = $data['eventSettingsData'] = $ticketDetails = array();
        if ($eventDataArr['status'] && $eventDataArr['response']['total'] > 0) {
            $eventData = $eventDataArr['response']['details'];
            $eventAddress = '';

            if (isset($eventData['location']['venueName']) && !empty($eventData['location']['venueName'])) {
                $eventAddress .= ',' . $eventData['location']['venueName'];
            }
            if (isset($eventData['location']['address1']) && !empty($eventData['location']['address1'])) {
                $eventAddress .= ', ' . $eventData['location']['address1'];
            }
            if (isset($eventData['location']['address2']) && !empty($eventData['location']['address2'])) {
                $eventAddress .= ', ' . $eventData['location']['address2'];
            }
            if (isset($eventData['location']['cityName']) && !empty($eventData['location']['cityName'])) {
                $eventAddress .= ', ' . $eventData['location']['cityName'];
            }
            if (isset($eventData['location']['stateName']) && !empty($eventData['location']['stateName'])) {
                $eventAddress .= ', ' . $eventData['location']['stateName'];
            }
            if (isset($eventData['location']['countryName']) && !empty($eventData['location']['countryName'])) {
                $eventAddress .= ', ' . $eventData['location']['countryName'];
            }
            $eventAddress = ltrim($eventAddress, ',');
            $eventData['fullAddress'] = $eventAddress;
            // For edit Order Url for Preview  
            if ($orderLogSessionData['pageType'] == 'preview') {
                if($MEcheckResponse['status'] == TRUE){
                    $eventData['eventUrl'] = commonHelperGetPageUrl('event-preview', '', '?view=preview&eventId='.$data['masterEventId'].'&sub='.$eventId);
                }else{
                    $eventData['eventUrl'] = commonHelperGetPageUrl('event-preview', '', '?view=preview&eventId=' . $eventId);
                }
            }
			
			if (isset($eventData['eventDetails']['bookButtonValue']) && !empty($eventData['eventDetails']['bookButtonValue'])) {
                $eventData['bookButtonValue'] = $eventData['eventDetails']['bookButtonValue'];
            }else{
				$eventData['bookButtonValue'] = 'PAY NOW';
			}
			
			
            $data['eventData'] = $eventData;

            $data['pageTitle'] = isset($eventData['title']) ? $eventData['title'] . ' | ' : '';
            $data['pageTitle'].='Book tickets online for music concerts, live shows and professional events. Be informed about upcoming events in your city';
            // Getting Ticketing options of the event
            $ticketOptionInput['eventId'] = $eventId;
            $ticketOptionInput['eventDetailReq'] = false;
            $collectMultipleAttendeeInfo = 0;
            $geoLocalityDisplay = 1;
            $ticketOptionArray = $eventHandler->getTicketOptions($ticketOptionInput);
        
            
            if ($ticketOptionArray['status'] && $ticketOptionArray['response']['total'] > 0) {
                $collectMultipleAttendeeInfo = $ticketOptionArray['response']['ticketingOptions'][0]['collectmultipleattendeeinfo'];
                $geoLocalityDisplay = $ticketOptionArray['response']['ticketingOptions'][0]['geolocalitydisplay'];
		$data['eventTicketOptionSettings']['eventdatehide'] = $ticketOptionArray['response']['ticketingOptions'][0]['eventdatehide'];
		$data['eventTicketOptionSettings']['eventlocationhide'] = $ticketOptionArray['response']['ticketingOptions'][0]['eventlocationhide'];
				
            }
             $eventSettingsDataArr = $eventHandler->getEventSettings($request);
            if ($eventSettingsDataArr['status'] && $eventSettingsDataArr['response']['total'] > 0) {
                $data['eventSettings'] = $eventSettingsDataArr['response']["eventSettings"][0];
            }
            
            
        } else {
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Line 212 Condition failed - Redirected to home page. ::".date('Y/m/d H:i:s'));
            redirect('home');
        }
        $data['collectMultipleAttendeeInfo'] = $collectMultipleAttendeeInfo;
        if($courierFee == 1){
            $geoLocalityDisplay = 0;
        }
        $data['geoLocalityDisplay'] = $geoLocalityDisplay;
        $data['courierFee'] = $courierFee;
        $userMismatch=false;
        /* Getting the Event Details ends here */
        if (!$isExisted) {

            /* Code to get the event related gateways starts here */
            $eventGateways = array();
            $gateWayInput['eventId'] = $eventId;
            $gateWayInput['gatewayStatus'] = true;
            $gateWayData = $eventHandler->getEventPaymentGateways($gateWayInput);
			//print_r($gateWayData); exit;
            if ($gateWayData['status'] && count($gateWayData['response']['gatewayList']) > 0) {
                $eventGateways = $gateWayData['response']['gatewayList'];
            }

            //Disable Payal INR for USD payments
            if($orderLogSessionData['calculationDetails']['currencyCode'] == 'USD'){
                foreach($eventGateways as $key => $value){
                    if($value['functionname'] == 'paypalinr'){
                        unset($eventGateways[$key]);
                    }
                }
            }

            $data['eventGateways'] = $eventGateways;
            $myWalletHandler=new MyWallet_handler();
            $myWalletResponse=$myWalletHandler->getBalance($data);
            if($myWalletResponse['status']){
                $data['mywallet'] = $myWalletResponse;
                $data['remainingToPay'] = $myWalletResponse['remainingToPay'];
            }
            //print_r($data);exit;
            $customFieldInput['eventId'] = $eventId;
            $customFieldInput['collectMultipleAttendeeInfo'] = $collectMultipleAttendeeInfo;
            $customFieldInput['disableSessionLockTickets'] = true;
            $customFieldInput['offlineFields'] = false;
            $configureHandler=new Configure_handler();
            $eventCustomFieldsArr = $configureHandler->getCustomFields($customFieldInput);
            if($courierFee == 1){
                $CFInputs['eventId'] = $eventId;
                $CFInputs['commonfieldids'] = array(4,5,6,7,10);
                $CFInputs['nonActiveCustomField'] = TRUE;
                $CFFieldsRes = $configureHandler->getCustomFields($CFInputs);
            }

            $eventCustomFields = $eventLevelCustomFields = $ticketLevelCustomFields = $gstCustomFields = array();
            if ($eventCustomFieldsArr['status'] && $eventCustomFieldsArr['response']['total'] > 0) {
                $tempEventCustomFieldsArray = $eventCustomFieldsArr['response']['customFields'];
                if (isset($CFFieldsRes) && $CFFieldsRes['status'] && $CFFieldsRes['response']['total'] > 0) {
                    $CFFields = $CFFieldsRes['response']['customFields'];
                    $tempEventCustomFieldsArray = array_merge($tempEventCustomFieldsArray,$CFFields);
                    $tempEventCustomFieldsArray = commonHelperGetIdArray($tempEventCustomFieldsArray);
                    foreach($tempEventCustomFieldsArray as $k => $v){
                        $tempEventCustomFieldsArray[$k]['fieldmandatory'] = 1;
                    }
                }
            }

            if($courierFee == 2){
                $notNeededFields = array(4,5,6,7,10);
                foreach($tempEventCustomFieldsArray as $key => $value){
                    if(in_array($value['commonfieldid'], $notNeededFields)){
                        unset($tempEventCustomFieldsArray[$key]);
                    }
                }
            }

            $indexedTempEventCustomFieldsArray=  commonHelperGetIdArray($tempEventCustomFieldsArray);
            $customFieldIdsArray = array_column($tempEventCustomFieldsArray, 'id');
            $customFieldValuesInput['customFieldIdArray'] = $customFieldIdsArray;
            $tempEventCustomFieldsArr = $configureHandler->getCustomFieldValues($customFieldValuesInput);
            $eventCustomFieldsArr = $tempEventCustomFieldsArr['response']['fieldValuesInArray'];
            foreach ($eventCustomFieldsArr as $eventCustomField) {
                $eventCustomFieldValueArr[$eventCustomField['customfieldid']][] = $eventCustomField;
            }
            /* Getting Ticketwise details starts here */
            $data['ticketData'] = $selectedTicketData;
            
            foreach ($selectedTicketData as $ticketId => $ticketQty) {
                $calculateTicketArr[$ticketId]['selectedQty'] = $ticketQty;

                /* Getting Custom fields for the event and ticketwise starts here */
                foreach ($tempEventCustomFieldsArray as $customFieldArr) {
                                           
                    $customFieldArr['customFieldValues'][$customFieldArr['id']] = isset($eventCustomFieldValueArr[$customFieldArr['id']])?$eventCustomFieldValueArr[$customFieldArr['id']]:array();
                    if($customFieldArr['fieldlevel'] == 'event' && in_array($customFieldArr['commonfieldid'], array(11, 12, 13))){
                        $gstCustomFields[] = $customFieldArr;
                    }elseif ($customFieldArr['fieldlevel'] == 'event') {
                        $eventCustomFields[$ticketId][] = $customFieldArr;
                    } elseif ($customFieldArr['fieldlevel'] == 'ticket' && $customFieldArr['ticketid'] == $ticketId) {
                        $eventCustomFields[$ticketId][] = $customFieldArr;
                    }
                }
                /* Getting Custom fields for the event and ticketwise ends here */
            }
            
            $data['customFieldsArray'] = $eventCustomFields;
            $data['gstCustomFields'] = $gstCustomFields;
            
                //get file upload custom field data
             
        $allFileCustData = array();
        $inputFileData['eventid'] = $eventId;
        
        $inputFileData['eventsignupids'] = array($orderLogData['eventsignup']);
        //$inputFileData['reporttype'] = $reportType;
          $eventsignupHandler = new Eventsignup_handler();    
        $fileUploadsResponse = $eventsignupHandler->getFileTypeCustomFieldData($inputFileData);

       
        if ($fileUploadsResponse['status']) {
            if ($fileUploadsResponse['response']['total'] > 0) {
                //print_r($fileUploadsResponse); exit;
                foreach ($fileUploadsResponse['response']['attendeedetailData'] as $esId => $ticktIds) {
                    foreach ($ticktIds as $ticktId => $serialKeys){
                        foreach ($serialKeys as $serialKey => $attendeeData) {
                            foreach ($attendeeData as $custId => $fileData) {
                                //print_r($attendeeData);
                                // $response[$esId]['customfields'][$custId] = $this->ci->config->item('images_content_path') . $this->ci->config->item('s3_customField_path') . $eventId . "/" . $fileData['value'];
                                $response[$esId]['customfields'][$custId] = $fileData['value'];
                            }
                        }
                    }
                    
                }
                $output['response']['downloadAllRequired'] = true;
                //$allFileCustData = $fileUploadsResponse['response']['attendeedetailData'];
            }
        }
            $data['customFieldsFileData'] = $response;
            $data['calculateTicketArr'] = $calculateTicketArr;
            /* Getting Ticketwise details ends here */

            /* Getting user data starts here */
            $userDataArray = array();
            $orderUserId=$eventSignupId=$orderLogData['userid'];
            
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line num 369 Below is GET Array ::".date('Y/m/d H:i:s'));
            $this->commonHandler->log_message(print_r($_GET, TRUE));
            
            if (!empty($_GET['userId']) && !empty($_GET['is_mobile'])) {
                $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line num 372 set session here using get method userid ::".date('Y/m/d H:i:s'));
                $userDataInput1['ownerId'] = $_GET['userId'];
                $userDataInput1['profileImageReq'] = false;
                $userHandler = new User_handler();
                $userData1 = $userHandler->getUserData($userDataInput1);
                $userHandler->setSession($userData1['response']['userData']);
            }
            $userId = $this->customsession->getUserId();
            $this->commonHandler->log_message(print_r($userId, TRUE));

            if($userId > 0 && !empty($orderUserId) && $userId!=$orderUserId){

                $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line num 386 userId:: $userId orderUserId:: $orderUserId ::".date('Y/m/d H:i:s'));
                $userMismatch=true;
                $userDataInput['ownerId'] = $orderUserId;
                $userDataInput['profileImageReq'] = false;
                $userHandler = new User_handler();
                $userDataResponse = $userHandler->getUserData($userDataInput);
                if ($userDataResponse['status'] && $userDataResponse['response']['total']>0) {
                    $userData = $userDataResponse['response']['userData'];
                    $incompleteEmail=$userData['email'];
                    $data['incompleteEmail']=$incompleteEmail;
                }
            }
            
            // for attendee details by signupid Start  
            if($orderLogData['eventsignup']>0){
                require_once(APPPATH . 'handlers/attendee_handler.php');
                $attendeeHandler=new Attendee_handler();
                $eventSignupId=$orderLogData['eventsignup'];
                $data['oldEventSignupId'] = $orderLogData['eventsignup'];
                $inputAttendee['eventsignupids']=array($eventSignupId);
                $attendeeData=$attendeeHandler->getListByEventsignupIds($inputAttendee);
            }
            // for attendee details by signupid End
            
            if ($userId > 0 && !$incompleteTrans && !$userMismatch) {
                $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line num 411 ::".date('Y/m/d H:i:s'));
                $userDataInput['ownerId'] = $userId;
                $isOrganizer = $this->customsession->getData('isOrganizer');
                if($isOrganizer == 1) {
                    $userDataInput['organizerDataReq'] = true;
                }
                $userDataInput['profileImageReq'] = false;
                $userHandler = new User_handler();
                $userDataResponse = $userHandler->getUserData($userDataInput);
                if ($userDataResponse['status'] && $userDataResponse['response']['total']>0) {
                    $userData = $userDataResponse['response']['userData'];
                    $organizerData=isset($userDataResponse['response']['organizerData'])?$userDataResponse['response']['organizerData']:array();
                    $userDataArray['FullName'] = $userData['name'];
                    $userDataArray['EmailId'] = $userData['email'];
                    $userDataArray['MobileNo'] = ($userData['mobile'] != '') ? $userData['mobile'] : $userData['phone'];
                    $userDataArray['Address'] = $userData['address'];
                    $userDataArray['Country'] = $userData['country'];
                    if($courierFee == TRUE){
                        $userDataArray['State'] = $userData['state'];
                        $userDataArray['City'] =  $userData['city'];
                    }else{
                        $userDataArray['State'] = ($userData['state'] != '') ? $userData['state'] : $userDataArray['Country'];
                        $userDataArray['City'] = ($userData['city'] != '') ? $userData['city'] : $userDataArray['State'];
                    }

                    $localityArr = array();
                    if ($userDataArray['City'] != '') {
                        $localityArr[] = $userDataArray['City'];
                    }
                    if ($userDataArray['State'] != '') {
                        $localityArr[] = $userDataArray['State'];
                    }
                    if ($userDataArray['Country'] != '') {
                        $localityArr[] = $userDataArray['Country'];
                    }
                    $userDataArray['Locality'] = implode(',',array_unique($localityArr));
                    $userDataArray['State'] = $userDataArray['State'];
                    $userDataArray['City'] = $userDataArray['City'];
                    $userDataArray['PinCode'] = $userData['pincode'];
                    $userDataArray['CompanyName'] = $userData['company'];
                    if(count($organizerData)>0){
                        $userDataArray['Designation'] = isset($organizerData['designation'])?$organizerData['designation']:'';
                    }
                }
            }elseif ($userId > 0 && $incompleteTrans && !$userMismatch) {
                $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line num 456 ::".date('Y/m/d H:i:s'));
                require_once(APPPATH . 'handlers/attendee_handler.php');
                $attendeeHandler=new Attendee_handler();
                $eventSignupId=$orderLogData['eventsignup'];
                $inputAttendee['eventsignupids']=array($eventSignupId);
                $attendeeData=$attendeeHandler->getListByEventsignupIds($inputAttendee);
                
                $eventSignupInput['eventsignupId'] = $eventSignupId;
                $eventsignupHandler = new Eventsignup_handler();    
                $signupData = $eventsignupHandler->getEventsignupDetails($eventSignupInput);
                
                
                
                if ($signupData['status'] && $signupData['response']['total'] > 0) {
                    $data['eventSignupData']['stagedStatus'] = $signupData['response']['eventSignupList'][0]['stagedstatus'];
                } else {
                    $return['errorMessage'] = SOMETHING_WRONG;
                    $return['status'] = FALSE;
                    return $return;
                }
            }
            //getting user location from ip2location
            //print_r($userDataArray); exit;
            $ip2location_status = $this->config->item('ip2LocationEnable');
            if($ip2location_status){
                if(count($userDataArray) <1 || !isset($userDataArray['City']) || $userDataArray['City'] == '' ){
                    $user_ip = get_client_ip(); //from common helper
                    $user_loc_det_status = ip2location($user_ip);
                    if($user_loc_det_status['status']){
                        $user_loc_det = $user_loc_det_status['response']['locationDetails'];
                        if ($user_loc_det['city_name'] != '' && $user_loc_det['city_name'] != '-') {
                            $localityArr[] = $user_loc_det['city_name'];
                            $userDataArray['City'] = $user_loc_det['city_name'];
                        }
                        if ($user_loc_det['region_name'] != '' && $user_loc_det['region_name'] != '-') {
                            $localityArr[] = $user_loc_det['region_name'];
                            $userDataArray['State'] = $user_loc_det['region_name'];
                        }
                        if ($user_loc_det['country_name'] != '' && $user_loc_det['country_name'] != '-') {
                            $localityArr[] = $user_loc_det['country_name'];
                            $userDataArray['Country'] = $user_loc_det['country_name'];
                        }
                        $userDataArray['Locality'] = implode(',',array_unique($localityArr));
                    }
                    //print_r($userDataArray['Locality']); exit;
                }
            }
            if(isset($attendeeData) && $attendeeData['status'] && $attendeeData['response']['total']>0){
                $attendeeeList=$attendeeData['response']['attendeeList'];
                $indexedAttendeeList=  commonHelperGetIdArray($attendeeeList);
                $attendeeIds= array_keys($indexedAttendeeList);
            }
            if(isset($attendeeIds) && count($attendeeIds)>0){
                require_once(APPPATH . 'handlers/attendeedetail_handler.php');
                $attendeedetailHandler=new Attendeedetail_handler();
                $inputAttendeedetail['attendeeids']=$attendeeIds;
                $attendeedetailData=$attendeedetailHandler->getListByAttendeeIds($inputAttendeedetail);
            }
            //print_r($attendeedetailData);exit;
            $attendeedetailList=$indexedAttendeedetailList=array();
            if(isset($attendeedetailData) && $attendeedetailData['status'] && $attendeedetailData['response']['total']>0){
                $attendeedetailList=$attendeedetailData['response']['attendeedetailList'];
            }
            $attendeeId='';
            $i=1;
           // print_r($attendeedetailList);exit;
            $localityArray=array();
            foreach ($attendeedetailList as $value) {
                if(empty($attendeeId)){
                    $attendeeId=$value['attendeeid'];
                }
                if($attendeeId!=$value['attendeeid']){
                    $attendeeId=$value['attendeeid'];
                    $i++;
                }
               // print_r($indexedTempEventCustomFieldsArray[$value['customfieldid']]);exit;
                $trimmedFieldName = str_replace(" ", "", preg_replace("/[^A-Za-z0-9\s\s+]/", "", $indexedTempEventCustomFieldsArray[$value['customfieldid']]['fieldname']));
                $indexedAttendeedetailList[$trimmedFieldName][$i]=$value['value'];
                if($trimmedFieldName=='City' || $trimmedFieldName=='State' || $trimmedFieldName=='Country'){
                    $localityArray[$i][$trimmedFieldName]=$value['value'];
                }
                
            }
            if(!empty($localityArray)){
                $localityFields=array();
                foreach ($localityArray as $lakey => $lavalue) {
                    $lvalue=$lavalue['City'].', '.$lavalue['State'].', '.$lavalue['Country'];
                    $lvalue= trim($lvalue,",");
                    $localityFields[$lakey]=$lvalue;
                }
                $indexedAttendeedetailList[DB_LOCALITY]=$localityFields;
            }
            //print_r($indexedAttendeedetailList);exit;
            
            $data['userData'] = $userDataArray;
            $data['indexedAttendeedetailList']=$indexedAttendeedetailList;
            /* Getting user data endds here */
            $eventSignupId = 0;
            $data['eventSignupId'] = $eventSignupId;
            $data['orderLogId'] = $orderId;
            
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line num 557 ::".date('Y/m/d H:i:s'));
            
        }
        
        
        
        $customValidationConfigArray = $this->config->item('customValidationMessage');
        if(array_key_exists($eventId, $customValidationConfigArray)){
            $data['customValidationMessage'] = $customValidationConfigArray[$eventId];
        }
//        //check whether event has gst
//        $this->load->model('Ticket_model');
//        $taxdetails = $this->Ticket_model->getTicketGstDetail(array('eventId' => $eventId));
//        $data['ticketTaxDetails'] = $taxdetails;
        
        $data['moduleName'] = 'eventModule';
        $data['content'] = 'ticketregistration_view';
        $data['pastAttreferralDiscountpageName'] = 'Payment';
		
		if(isset($samepage) && $samepage == 1){
			$data['samepage'] = $samepage;
		}
		//print_r($data); exit;
		
		$data['nobrand'] = $nobrand;
        $data['pageName'] = 'Payment';

        $data['isExisted'] = $isExisted;
        $data['userMismatch']=$userMismatch;
        $data['cityList'] = $footerValues['cityList'];
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'fixto',
            $this->config->item('js_public_path') . 'jquery.validate',
			$this->config->item('js_public_path') . 'additional-methods',
            $this->config->item('js_public_path') . 'delegate',$this->config->item('js_public_path') . 'ticketwidget/ticketwidget'
			);
        $data['jsTopArray'] = array(
            $this->config->item('js_public_path') . 'intlTelInput'
			);
		/*if(($this->customsession->getData('booking_message'))){
			$data['jsArray'][] =$this->config->item('js_public_path') . 'deeplink';
		}*/
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'delegate',
            $this->config->item('css_public_path') . 'intlTelInput'
			);
		
		/*appending model related JS & CSS files, for mywallet OTP verfication*/
		if(isset($data['mywallet'])){
			//js
			$data['jsArray'][] = $this->config->item('js_public_path') . 'lightbox';
			$data['jsArray'][] = $this->config->item('js_public_path') . 'otpVerification';
			
			//css
			$data['cssArray'][] = $this->config->item('css_public_path') . 'lightbox'; 
		}
                $widgetTheme = isset($getVar['theme']) ? $getVar['theme'] : 0;
                $data['widgettheme']=$widgetTheme;
                // devilsCircuitValidation
                $ticketFieldsValidation=$this->config->item('devilsCircuitValidation');
                if(isset($ticketFieldsValidation[$eventId]) && !empty($ticketFieldsValidation[$eventId])){
                   $data['ticketFieldsValidation']=$ticketFieldsValidation[$eventId]['tickets'];
                   
                }
                $data['handlingFeeLable']=$this->config->item('internet_handling_lable');
                if(isset($widgetTheme) && $widgetTheme>=1){

                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." WIDGET THEME payment.php Line num 624  ::".date('Y/m/d H:i:s'));
                    $wCode=$getVar['wcode'];
                    $eventTitleColor = '';
                    $headingBackgroundColor = '';
                    $ticketTextColor = '';
                    $bookNowBtnColor = '';
                    $wCodeArray = explode('-', $wCode);

                        $eventTitleColor = $wCodeArray[0];
                        $headingBackgroundColor = $wCodeArray[1];
                        if(strtolower($wCodeArray[2]) != 'ffffff'){ 
                            $ticketTextColor = $wCodeArray[2];
                        }else{
                            $ticketTextColor = $wCodeArray[1];
                        }
                        $bookNowBtnColor = $wCodeArray[3];
                    $samepage = ($getVar['samepage']) ? $getVar['samepage'] : 1;
                    $showTitle = isset($getVar['title']) ? $getVar['title'] : 1;
                    $showLocation = isset($getVar['location']) ? $getVar['location'] : 1;
                    $showDateTime = isset($getVar['dateTime']) ? $getVar['dateTime'] : 1;
                    $redirectionUrl = isset($getVar['redirectUrl']) ? $getVar['redirectUrl'] : 1;
                    $widgetThirdPartyUrl = isset($getVar['widgetThirdPartyUrl']) ? $getVar['widgetThirdPartyUrl'] : '';
                    $ticket_option = !empty($getVar['t']) ? $getVar['t'] : '1';
                    $ticket_option_ids = !empty($getVar['tid']) ? $getVar['tid'] : '';
                    $directDetails = !empty($getVar['directDetails']) ? $getVar['directDetails'] : 0;
                    if(isset($widgetThirdPartyUrl) && $widgetThirdPartyUrl!=''){
                        $data['widgetThirdPartyUrl']='----parrent='.$widgetThirdPartyUrl;
                        //$wtp=$widgetThirdPartyUrl;
                        $wtp='';
                    }else{
                        $data['widgetThirdPartyUrl']=''; 
                        $wtp='';
                    }

                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." WIDGET THEME payment.php Line num 659  ::".date('Y/m/d H:i:s'));
                    
                    $data['samepage'] = $samepage;
                    $data['showTitle'] = $showTitle;
                    $data['showDateTime'] = $showDateTime;
                    $data['showLocation'] = $showLocation;
                    $data['redirectUrl'] = $redirectionUrl;
                    $data['ticket_option'] = $ticket_option;
                    $data['ticket_option_ids'] = $ticket_option_ids;
                    $data['directDetails'] = $directDetails;
                
                    $data['eventTitleColor']=$eventTitleColor;
                    $data['headingBackgroundColor']=$headingBackgroundColor;
                    $data['ticketTextColor']=$ticketTextColor;
                    $data['bookNowBtnColor']=$bookNowBtnColor;
                    $data['wCode'] = $getVar['wcode'];
                    $data['tb']='details';
                    
                    $data['themeFieldsUrl']='----theme='.$widgetTheme.'----title='.$showTitle.'----dateTime='.$showDateTime.'----location='.$showLocation.'----wcode='.$getVar['wcode'].'----&nobrand='.$nobrand.'----&t='.$ticket_option.'----&tid='.$ticket_option_ids.'----&directDetails='.$directDetails;
                    $data['themeFieldsUrlForEBS']='----t='.$widgetTheme.'----ti='.$showTitle.'----dt='.$showDateTime.'----lo='.$showLocation.'----wc='.$getVar['wcode'].'----&nb='.$nobrand;
                    $data['themeFieldsUrlForPaytm']='----t='.$widgetTheme.'----ti='.$showTitle.'----dt='.$showDateTime.'----lo='.$showLocation.'----wc='.$getVar['wcode'].'----&nb='.$nobrand;
                    $data['ticketediteventurl']= site_url().'ticketWidget?eventId='.$eventId.'&theme='.$widgetTheme.'&title='.$showTitle.'&dateTime='.$showDateTime.'&location='.$showLocation.'&wcode='.$getVar['wcode'].'&nobrand='.$nobrand.'&t='.$ticket_option.'&tid='.$ticket_option_ids.'&directDetails='.$directDetails;
                    if($MEcheckResponse['status'] == TRUE){
                        $data['ticketediteventurl']= site_url().'ticketWidget?eventId='.$MEcheckResponse['parentId'].'&theme='.$widgetTheme.'&title='.$showTitle.'&dateTime='.$showDateTime.'&location='.$showLocation.'&wcode='.$getVar['wcode'].'&nobrand='.$nobrand.'&t='.$ticket_option.'&tid='.$ticket_option_ids.'&directDetails='.$directDetails;
                    }
                    if(isset($data['referralcode'])) {
                        $data['ticketediteventurl'] .= "&reffCode=".$data['referralcode'];
                    }
                    if(isset($data['promotercode'])) {
                        $data['ticketediteventurl'] .= "&ucode=".$data['promotercode'];
                    }
                    if(isset($data['acode'])) {
                        $data['ticketediteventurl'] .= "&acode=".$data['acode'];
                    }
                    $themecss=$this->config->item('css_public_path') . 'ticketwidget/theme'.$widgetTheme.'/theme';
                    array_push($data['cssArray'],$themecss);
                    
                    $data['content'] = 'templates/widgets/theme'.$widgetTheme.'/ticket_widget_template_reg_info';
                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." WIDGET THEME payment.php Line num 697  ::".date('Y/m/d H:i:s'));

                    require_once(APPPATH . 'handlers/widgetsettings_handler.php');
                    $widgetsettingsHandler = new Widgetsettings_handler();
                    $widgetSettings=$widgetsettingsHandler->getWidgetSettings(array('eventid'=>$eventId));
                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." WIDGET THEME payment.php Line num 702  ::".date('Y/m/d H:i:s'));
                    $widgetdata=array();
                    if ($widgetSettings['status'] && count($widgetSettings) > 0 && $widgetSettings['response']['total']>0) {
                        foreach ($widgetSettings['response']['widgetsettings'] as $wskey => $wsvalue) {
                            $widgetdata[$wsvalue['optionname']]=$wsvalue['optionvalue'];
                        }
                    }
                    $data['widgetSettings']=$widgetdata;
                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." WIDGET THEME payment.php Line num 710  ::".date('Y/m/d H:i:s'));
                    $template = 'templates/ticket_widget_template';
                    
                    $this->load->view($template, $data);
                }else{
                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line num 715  ::".date('Y/m/d H:i:s'));
		if(isset($samepage) && $samepage == 1){
			$this->load->view('templates/ticket_widget_template', $data);
		}elseif(isset($_GET['is_mobile']) && $_GET['is_mobile'] == 1){
        $this->load->view('templates/user_mobile_template', $data);
		}else{
        $this->load->view('templates/user_template', $data);
		}
                }

        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php End of Index function Line 717 ::".date('Y/m/d H:i:s'));

    }

    /*
     * Function to prepare the ebs form data to redirect to its payment page
     *
     * @access  public
     * @param
     *          TxnAmount - Total amount that need to pay the user
     *          oid - Order Id from the `orderlogs` table
     *          uid - User Id of the booking user
     *          EventSignupId - EventSignUp Id
     *          EventId - Id of the Event
     *          EventTitle - Title of the Event
     * @return  redirects to the ebs payment page
     */

    public function ebsPrepare() {

        $data = array();
        $ebsSecretKey = $this->config->item('ebs_secret_key');
        $data['account_id'] = $accountId = $this->config->item('account_id');
        $data['mode'] = $mode = $this->config->item('mode');
        $postVar = $this->input->post();
        
        //print_r($postVar); exit;
        
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $ebsSecretKey = $gatewayArr['hashkey'];
                $data['account_id'] = $accountId = $gatewayArr['merchantid'];
            }
        }
        /* Getting the payment gateway details from database ends here */

        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
        $samepage = $postVar['samepage'];
        $nobrand = $postVar['nobrand'];
                $themefields='';
                if(isset($postVar['themefields']) && $postVar['themefields']!=''){
                $themefields = '&tf='.$postVar['themefields'];
                }
                
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        //print_r($orderLogData); echo $this->ci->db->last_query();exit;
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventSignupId = $oldOrderLogData['eventsignup'];
        $txtTxnAmount = $data['txtTxnAmount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
        $EventId = $orderLogCalculationData['eventid'];
        // Getting order Log data ends here

        $addressStr = $postVar['primaryAddress'];
        $addressArr = explode('@@', $addressStr);

        $data['name'] = $addressArr[0];
        $data['email'] = $addressArr[1];
        $data['phone'] = $addressArr[2];
        $data['city'] = ($addressArr[5] != '') ? $addressArr[5] : $addressArr[3];
        $data['state'] = ($addressArr[4] != '') ? $addressArr[4] : $addressArr[3];
        $tempAddress = '';
        if ($data['city'] != '') {
            $tempAddress .= $data['city'] . ',';
        }
        if ($data['state'] != '') {
            $tempAddress .= $data['state'];
        }
        $data['address'] = ($addressArr[3]) ? $addressArr[3] : $tempAddress;
        $data['pincode'] = ($addressArr[6]) ? $addressArr[6] : '500081';

        $this->soldTicketValidation($orderId,$orderLogData);
        $data['eventTitle'] = $postVar['eventTitle'];
        $txtCustomerID = $data['txtCustomerID'] = $eventSignupId;

        $data['returnUrl'] = commonHelperGetPageUrl('payment_ebsProcessingPage') . "?orderId=$orderId&eventSignup=$eventSignupId&sp=$samepage&nb=$nobrand&paymentGatewayKey=$paymentGatewayKey&DR={DR}$themefields";
        $string = $ebsSecretKey . "|" . $accountId . "|" . $txtTxnAmount . "|" . $txtCustomerID . "|" . html_entity_decode($data['returnUrl']) . "|" . $mode;
        $data['secureHash'] = md5($string);
        $data['pageName'] = 'Ebs';

        require_once(APPPATH . 'handlers/eventpaymentgateway_handler.php');
        $eventPaymentGateway = new EventpaymentGateway_handler();
        $eventGateways = array();
        $gateWayInput['eventId'] = $EventId;
        $gateWayInput['gatewayStatus'] = true;
        $gateWayInput['paymentGatewayId'] = $paymentGatewayKey;
        $gateWayData = $eventPaymentGateway->getPaymentgatewayByEventId($gateWayInput);
        //print_r($gateWayData);
        if ($gateWayData['status'] && count($gateWayData['response']['eventPaymentGatewayList']) > 0) {
            $eventGatewayData = $gateWayData['response']['eventPaymentGatewayList'];
        }
        if(isset($eventGatewayData[0]['extraparams']) && $eventGatewayData[0]['extraparams'] != '') {
            $serializedExtraParam = unserialize($eventGatewayData[0]['extraparams']);
            foreach($serializedExtraParam as $key => $value) {
                $data['extraparams'][$key] = $value;
            }
        }
        //print_r($data); exit;

        $this->load->view('payment/ebs_prepare', $data);
    }

    /* Intermediate page for EBS to check the order,signup and checksum values */

    public function ebsProcessingPage() {

        $getVar = $this->input->get();
        $orderId = $getVar['orderId'];
        $this->soldTicketValidation($orderId);
        $samepage = $getVar['sp'];
        $nobrand = $getVar['nb'];
                $themefields='';
                if(isset($getVar['tf']) && $getVar['tf']!=''){
                $themefields = $getVar['tf'];
                $themefields= str_replace('----', '&', $themefields);
                $replacingArray=array("&t="=>"&theme=","&ti="=>"&title=","&dt="=>"&dateTime=","&lo="=>"&location=","&wc="=>"&wcode=","&nb="=>"&nobrand=");
                foreach ($replacingArray as $rakey => $ravalue) {
                $themefields= str_replace($rakey, $ravalue, $themefields);    
                }
                
                $themefields=$themefields.'&tb=payment';
                }
        $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->ebsProcessingApi($getVar);
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }
        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        header("Location: " . $successUrl);
        exit;
    }

    /*
     * Function to prepare the ebs form data to redirect to its payment page
     *
     * @access	public
     * @param
     *      	TxnAmount - Total amount that need to pay the user
     *      	oid - Order Id from the `orderlogs` table
     *      	uid - User Id of the booking user
     *      	EventSignupId - EventSignUp Id
     *      	EventId - Id of the Event
     *      	EventTitle - Title of the Event
     * @return	redirects to the ebs payment page
     */

    public function amazonpayPrepare() {

        $data = array();
        $postVar = $this->input->post();
		
		//print_r($postVar); exit;
		
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $amazonpayMerchantId = $gatewayArr['merchantid'];
                $amazonpayMerchantSecretKey = $gatewayArr['hashkey'];
                $amazonpayAcc = unserialize($gatewayArr['extraparams']);
                $amazonpayAccessKey = $amazonpayAcc['access_key'];
                $amazonpayBaseurl = $gatewayArr['posturl'];
                $amazonpaySandbox = $gatewayArr['environment'] == 'TEST' ? true : false;
            }
        }
        /* Getting the payment gateway details from database ends here */

        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
		$samepage = $postVar['samepage'];
		$nobrand = $postVar['nobrand'];
        $themefields='';
        if(isset($postVar['themefields']) && $postVar['themefields']!=''){
            $themefields = '&tf='.$postVar['themefields'];
        }
                
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        //print_r($orderLogData); echo $this->ci->db->last_query();exit;
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventSignupId = $oldOrderLogData['eventsignup'];
        $txtTxnAmount = $data['txtTxnAmount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
        $EventId = $orderLogCalculationData['eventid'];
        $currencyCode = $orderLogCalculationData['calculationDetails']['currencyCode'];
        // Getting order Log data ends here

        $addressStr = $postVar['primaryAddress'];
        $addressArr = explode('@@', $addressStr);

        $data['name'] = $addressArr[0];
        $data['email'] = $addressArr[1];
        $data['phone'] = $addressArr[2];
        $data['city'] = ($addressArr[5] != '') ? $addressArr[5] : $addressArr[3];
        $data['state'] = ($addressArr[4] != '') ? $addressArr[4] : $addressArr[3];
        $tempAddress = '';
        if ($data['city'] != '') {
            $tempAddress .= $data['city'] . ',';
        }
        if ($data['state'] != '') {
            $tempAddress .= $data['state'];
        }
        $data['address'] = ($addressArr[3]) ? $addressArr[3] : $tempAddress;
        $data['pincode'] = ($addressArr[6]) ? $addressArr[6] : '500081';

        $this->soldTicketValidation($orderId,$orderLogData);
        $data['eventTitle'] = $postVar['eventTitle'];
        $txtCustomerID = $data['txtCustomerID'] = $eventSignupId;

        $returnUrl = commonHelperGetPageUrl('payment_amazonpayProcessingPage');

        require_once(APPPATH . 'handlers/eventpaymentgateway_handler.php');
        $eventPaymentGateway = new EventpaymentGateway_handler();
        $eventGateways = array();
        $gateWayInput['eventId'] = $EventId;
        $gateWayInput['gatewayStatus'] = true;
        $gateWayInput['paymentGatewayId'] = $paymentGatewayKey;
        $gateWayData = $eventPaymentGateway->getPaymentgatewayByEventId($gateWayInput);
		//print_r($gateWayData);
        if ($gateWayData['status'] && count($gateWayData['response']['eventPaymentGatewayList']) > 0) {
            $eventGatewayData = $gateWayData['response']['eventPaymentGatewayList'];
        }
        if(isset($eventGatewayData[0]['extraparams']) && $eventGatewayData[0]['extraparams'] != '') {
            $serializedExtraParam = unserialize($eventGatewayData[0]['extraparams']);
            foreach($serializedExtraParam as $key => $value) {
                $data['extraparams'][$key] = $value;
            }
        }
        require_once(APPPATH . 'libraries/AmazonPay/PWAINBackendSDK.php');
        $config = array( 'merchant_id'   => $amazonpayMerchantId,
                         'access_key'    => $amazonpayAccessKey,
                         'secret_key'    => $amazonpayMerchantSecretKey,
                         'base_url'      => $amazonpayBaseurl); 
        
        $client = new PWAINBackendSDK($config);
        $amazonpayData = array();
        $amazonpayData['sellerOrderId'] = $eventSignupId;
        // $amazonpayData['transactionId '] = $eventSignupId;
        $amazonpayData['orderTotalAmount'] = $txtTxnAmount;
        $amazonpayData['orderTotalCurrencyCode'] = $currencyCode;
        $amazonpayData['sellerStoreName'] = "MeraEvents";
        $customInformation['paymentGatewayKey'] = $paymentGatewayKey;
        $customInformation['orderId'] = $orderId;
        $customInformation['sp'] = $samepage;
        $customInformation['nb'] = $nobrand;
        $customInformation['tf'] = $themefields;
        $amazonpayData['customInformation'] = json_encode($customInformation); //implode(",", array($orderId,$data['email']));
        
        if($amazonpaySandbox)
            $amazonpayData['isSandbox'] = "true";

        $redirectUrl = $client->getProcessPaymentUrl($amazonpayData, $returnUrl);
		// var_dump($amazonpayData); exit;
        header("Location: ".$redirectUrl, true, 301);


    }

    /* Intermediate page for EBS to check the order,signup and checksum values */

    public function amazonpayProcessingPage() {

        $getVar = $this->input->get();
        $customInformation = json_decode($_GET['customInformation'],true);
        $orderId = $customInformation['orderId'];
		$this->soldTicketValidation($orderId);
        $customInfo = json_decode($_GET['customInformation'],true);
		$samepage = $customInfo['sp'];
		$nobrand = $customInfo['nb'];
        $themefields='';
        if(isset($customInfo['tf']) && $customInfo['tf']!=''){
            $themefields = $customInfo['tf'];
            $themefields= str_replace('----', '&', $themefields);
            $replacingArray=array("&t="=>"&theme=","&ti="=>"&title=","&dt="=>"&dateTime=","&lo="=>"&location=","&wc="=>"&wcode=","&nb="=>"&nobrand=");
            foreach ($replacingArray as $rakey => $ravalue) {
                $themefields= str_replace($rakey, $ravalue, $themefields);    
            }
            
            $themefields=$themefields.'&tb=payment';
        }
        $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->amazonpayProcessingApi($_GET);
        
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }
        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        header("Location: " . $successUrl);
        exit;
    }

    /*
     * Function to prepare the mobikwik form data to redirect to its payment page
     *
     * @access	public
     * @param
     *      	mobileno - Number of the booking user
     *      	email - Email of the booking user
     *      	TxnAmount - Total amount that need to pay the user
     *      	oid - Order Id from the `orderlogs` table
     *      	merchantname - Name of the booking user
     * @return	redirects to the mobikwik payment page
     */

    public function mobikwikPrepare() {

        $data = array();
        $postVar = $this->input->post();

        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
		$samepage =  $postVar['samepage'];
		$nobrand =  $postVar['nobrand'];
                $themefields='';
                if(isset($postVar['themefields']) && $postVar['themefields']!=''){
                $themefields = '&themefields='.$postVar['themefields'];
                }
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventSignupId = $oldOrderLogData['eventsignup'];
        $txtTxnAmount = $data['txtTxnAmount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
        $EventId = $orderLogCalculationData['eventid'];
        // Getting order Log data ends here

        $addressStr = $postVar['primaryAddress'];
        $addressArr = explode('@@', $addressStr);
        $name = $addressArr[0];
        $email = $addressArr[1];
        $mobile = $addressArr[2];

        $this->soldTicketValidation($orderId,$orderLogData);

        $eventSignup = $eventSignupId;
        $txnAmount = $txtTxnAmount;

        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        $data['redirectUrl'] = commonHelperGetPageUrl('payment_mobikwikProcessingPage') . "?eventSignup=" . $eventSignup . "&samepage=".$samepage.'&nobrand='.$nobrand."&orderId=" . $orderId . "&paymentGatewayKey=" . $paymentGatewayKey.$themefields;

        $mobiwikSecretKey = $this->config->item('mobiwikSecretKey');
        $mobiwikMerchantId = $this->config->item('mobiwikMerchantId');

        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $mobiwikSecretKey = $gatewayArr['hashkey'];
                $mobiwikMerchantId = $gatewayArr['merchantid'];
            }
        }
        /* Getting the payment gateway details from database ends here */

        $this->load->library('mobikwik/checksum.php');
        /*$all = "'" . $mobile . "''" . $email . "''" . $txnAmount . "''" .
                $orderId . "''" . $data['redirectUrl'] . "''" . $mobiwikMerchantId . "'";*/
        $all = "'" . $mobile . "''" . $email . "''" . $txnAmount . "''" .
                $eventSignupId . "''" . $data['redirectUrl'] . "''" . $mobiwikMerchantId . "'";

        $checksum = $this->checksum->calculateChecksum($mobiwikSecretKey, $all);
        $actionUrl = $this->checksum->getActionUrl();
        $data['actionUrl'] = $actionUrl;
        $data['checksum'] = $checksum;
        $data['merchantName'] = $name;
        //$data['orderId'] = $orderId;
        $data['orderId'] = $eventSignupId;
        $data['mobileNo'] = $mobile;
        $data['amount'] = $txnAmount;
        $data['email'] = $email;
        $data['pageName'] = 'Mobikwik';
		$data['samepage'] = $samepage;
		$data['nobrand'] = $nobrand;
        $data['mobikwikMerchantId'] = $mobiwikMerchantId;
        $this->load->view('payment/mobikwik_prepare', $data);
    }

    /* Intermediate page for mobikwik to check the order,signup and checksum values */

    public function mobikwikProcessingPage() {
        $getVar = $this->input->get();
        $postVar = $this->input->post();

        $orderId = $getVar['orderId'];
		$this->soldTicketValidation($orderId);
		$samepage = $getVar['samepage'];
		$nobrand = $getVar['nobrand'];
                $themefields='';
                if(isset($getVar['themefields']) && $getVar['themefields']!=''){
                $themefields = $getVar['themefields'];
                $themefields= str_replace('----', '&', $themefields);
                $themefields=$themefields.'&tb=payment';
                }
        $redirectUrl = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields);

        $postVar['paymentGatewayKey'] = $getVar['paymentGatewayKey'];
        $postVar['orderId'] = $getVar['orderId'];
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->mobikwikProcessingApi($postVar);
        //echo '<pre>';
        // print_r($apiResponse);exit;
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            $this->customsession->setData('booking_message', $errorMessage);

            if (isset($apiResponse['response']['transactionCancel']) && $apiResponse['response']['transactionCancel']) {
                $redirectUrl = $this->getPreviousEventUrl($orderId);
            }
            redirect($redirectUrl);
        }

        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        header("Location: " . $successUrl);
        exit;
    }

    public function getPreviousEventUrl($orderId) {

        $eventUrl = site_url();
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);

        $request['eventId'] = $orderLogCalculationData['eventid'];
        $eventHandler = new Event_handler();
        $eventDataArr = $eventHandler->getEventDetails($request);
        $eventData = $eventDataArr['response']['details'];

        if ($orderLogCalculationData['pageType'] == 'preview') {
            $eventUrl = site_url() . 'previewevent?view=preview&eventId=' . $request['eventId'];
        } else {
            $eventUrl = $eventData['eventUrl'];
        }

        if ($orderLogCalculationData['referralcode'] != '') {
            $reffCode = $orderLogCalculationData['referralcode'];
            if (strpos($eventUrl, '?') == true) {
                $eventUrl = $eventUrl . "&reffCode=" . $reffCode;
            } else {
                $eventUrl = $eventUrl . "?reffCode=" . $reffCode;
            }
        }
        if ($orderLogCalculationData['promotercode'] != '') {
            $ucode = $orderLogCalculationData['promotercode'];
            if (strpos($eventUrl, '?') == true) {
                $eventUrl = $eventUrl . "&ucode=" . $ucode;
            } else {
                $eventUrl = $eventUrl . "?ucode=" . $ucode;
            }
        }
        return $eventUrl;
    }

    /*
     * Function to prepare the paytm form data to redirect to its payment page
     *
     * @access	public
     * @param
     *      	MOBILE_NO - Number of the booking user
     *      	EMAIL - Email of the booking user
     *      	TXN_AMOUNT - Total amount that need to pay the user
     *      	oid - Order Id from the `orderlogs` table
     *      	CUST_ID - User Id of the booking user
     *      	ORDER_ID - EventSignUp Id
     * @return	redirects to the paytm payment page
     */
        
    public function paytmPrepare() {

        $data = array();
        $postVar = $this->input->post();
		//print_r($postVar);exit;
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $paytmSecretKey = $gatewayArr['hashkey'];
                $paytmMerchantId = $gatewayArr['merchantid'];

                $extraParams = unserialize($gatewayArr['extraparams']);
                define('PAYTM_MERCHANT_KEY', $paytmSecretKey);
                define('PAYTM_MERCHANT_MID', $paytmMerchantId);

                define('PAYTM_MERCHANT_WEBSITE', $extraParams['PAYTM_MERCHANT_WEBSITE']);
                define('INDUSTRY_TYPE_ID', $extraParams['INDUSTRY_TYPE_ID']);
                define('CHANNEL_ID', $extraParams['CHANNEL_ID']);
            }
        }
        /* Getting the payment gateway details from database ends here */
        require_once(APPPATH . 'libraries/paytm/paytm_functions.php');

        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
		$samepage = $postVar['samepage'];
		$nobrand = $postVar['nobrand'];
                $themefields='';
                if(isset($postVar['themefields']) && $postVar['themefields']!=''){
                $themefields = '&tf='.$postVar['themefields'];
                }
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventSignupId = $oldOrderLogData['eventsignup'];
        $txtTxnAmount = $data['txtTxnAmount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
        $EventId = $orderLogCalculationData['eventid'];
        // Getting order Log data ends here

        $eventGatewayData = array();
        require_once(APPPATH . 'handlers/eventpaymentgateway_handler.php');
        $eventPaymentGateway = new EventpaymentGateway_handler();
        $gateWayInput['eventId'] = $EventId;
        $gateWayInput['gatewayStatus'] = true;
        $gateWayInput['paymentGatewayId'] = $paymentGatewayKey;
        $gateWayData = $eventPaymentGateway->getPaymentgatewayByEventId($gateWayInput);
        if ($gateWayData['status'] && count($gateWayData['response']['eventPaymentGatewayList']) > 0) {
            $eventGatewayData = $gateWayData['response']['eventPaymentGatewayList'];
        }
        
        $addressStr = $postVar['primaryAddress'];
        $addressArr = explode('@@', $addressStr);

        $name = $addressArr[0];
        $email = $addressArr[1];
        $mobile = $addressArr[2];
		if(isset($postVar['walletMobileNo']) && strlen($postVar['walletMobileNo'])>0){
			$mobile = $postVar['walletMobileNo'];
		}

        $this->soldTicketValidation($orderId,$orderLogData);

        $CUST_ID = trim($oldOrderLogData['userid']);
        $TXN_AMOUNT = $txtTxnAmount;//number_format($txtTxnAmount, 2);
        $MOBILE_NO = trim($mobile);
		$MOBILE_NO = substr($mobile, -10);
        $EMAIL = trim($email);
        $eventSignup = $eventSignupId;
        $CALLBACK_URL = commonHelperGetPageUrl('payment_paytmProcessingPage') . "?oI=" . $orderId . "&eS=" . $eventSignup . "&sp=".$samepage.'&nb='.$nobrand."&eM=" . $EMAIL . "&mO=" . $MOBILE_NO . "&pGI=" . $paymentGatewayKey.$themefields;
		$PAYMENT_DETAILS='';
		if(isset($postVar['token'])){
			$PAYMENT_DETAILS=$postVar['token'];
		}
		if(isset($postVar['ssoToken'])){
			$SSO_TOKEN = $postVar['ssoToken'];
		}
		if(isset($postVar['paytmToken'])){
			$PAYTM_TOKEN = $postVar['paytmToken'];
		}
		$AUTH_MODE=commonHelperGetPaytmAuthCode($postVar['optionSeletedPaytmAuthCode']);
		$PAYMENT_TYPE_ID=commonHelperGetPaytmPaymentTypeId($postVar['optionSeleted']);
        $checkSum = "";
        $paramList = array();
		// Create an array having all required parameters for creating checksum.
        $paramList["REQUEST_TYPE"] = "PAYTM_EXPRESS";
		$paramList["MID"] = PAYTM_MERCHANT_MID;
        //$paramList["ORDER_ID"] = $orderId;
        $paramList["ORDER_ID"] = $eventSignupId;
        $paramList["CUST_ID"] = $CUST_ID;
		$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
		$paramList["CHANNEL_ID"] = "WEB";
        $paramList["INDUSTRY_TYPE_ID"] = INDUSTRY_TYPE_ID;
        $paramList["WEBSITE"] = "Meraevents";
		if(strlen($PAYMENT_DETAILS)>0){
			$paramList["PAYMENT_DETAILS"] = $PAYMENT_DETAILS;
		}
		if(strlen($SSO_TOKEN)>0){
			$paramList["SSO_TOKEN"] = $SSO_TOKEN;
		}
		if(isset($postVar['isSavedCard']) && $postVar['isSavedCard']==1){
			$paramList['IS_SAVED_CARD']=1;
		}
		if(isset($postVar['addMoney']) && $postVar['addMoney']==1){
			$paramList['addMoney']=1;
		}
		if(isset($postVar['saveCard']) && $postVar['saveCard']==1){
			$paramList['STORE_CARD']=1;
		}
		if(isset($postVar['bankCode'])){
			$paramList['BANK_CODE']=$postVar['bankCode'];
		}
		if(strlen($PAYTM_TOKEN)>0){
			$paramList["PAYTM_TOKEN"] = $PAYTM_TOKEN;
		}
		$paramList["THEME"] = 'Merchant';
		$paramList["AUTH_MODE"] = $AUTH_MODE;
		$paramList["PAYMENT_TYPE_ID"] = $PAYMENT_TYPE_ID;
		$paramList["MSISDN"] = $MOBILE_NO;
        $paramList["EMAIL"] = $EMAIL;
        $paramList["CALLBACK_URL"] = $CALLBACK_URL;
        if(isset($eventGatewayData[0]['extraparams']) && $eventGatewayData[0]['extraparams'] != '') {
            $serializedExtraParam = unserialize($eventGatewayData[0]['extraparams']);
            foreach($serializedExtraParam as $key => $value) {
                $paramList[$key] = $value;
            }
        }
        //Here checksum string will be return
        $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
        $data['checkSum'] = $checkSum;
        $data['paramList'] = $paramList;
        $data['pageName'] = 'Paytm';
		$data['samepage'] = $samepage;
		$data['nobrand'] = $nobrand;
                $data['themefields'] =$themefields;
		//$data['jsArray']=array('');
		//print_r($data);exit;
        $this->load->view('payment/paytm_prepare', $data);
    }
	
	public function paytmSelect() {

        $data = array();
        $postVar = $this->input->post();
		$commonHandler=new Common_handler();
        //$data = array();
        $cookieData = $commonHandler->headerValues();
		 $data = $cookieData;
        if (count($cookieData) > 0) {
            $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }
		$footerValues = $commonHandler->footerValues();
        $data['categoryList'] = $footerValues['categoryList'];
        $data['defaultCountryId'] = $this->defaultCountryId;
		//print_r($postVar);exit;
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $paytmSecretKey = $gatewayArr['hashkey'];
                $paytmMerchantId = $gatewayArr['merchantid'];
				define('PAYTM_MERCHANT_MID', $paytmMerchantId);
            }
        }
        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
		$samepage = $postVar['samepage'];
		$nobrand = $postVar['nobrand'];
                $themefields='';
                $backbuttonurl='';
                if(isset($postVar['themefields']) && $postVar['themefields']!=''){
                $themefields = '&themefields='.$postVar['themefields'];
                $backbuttonurl= str_replace('----', '&', $postVar['themefields']);
                $replacingArray=array("&t="=>"&theme=","&ti="=>"&title=","&dt="=>"&dateTime=","&lo="=>"&location=","&wc="=>"&wcode=","&nb="=>"&nobrand=");
                foreach ($replacingArray as $rakey => $ravalue) {
                $backbuttonurl= str_replace($rakey, $ravalue, $backbuttonurl);    
                }
                }
                
        $data['backbuttonurl']=$backbuttonurl;
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventSignupId = $oldOrderLogData['eventsignup'];
        $txtTxnAmount = $data['txtTxnAmount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
		$currencyCode = $orderLogCalculationData['calculationDetails']['currencyCode'];
        $EventId = $orderLogCalculationData['eventid'];
		
        // Getting order Log data ends here
		require_once(APPPATH . 'handlers/netbankingdetail_handler.php');
		$netbankingdetail_handler=new Netbankingdetail_handler();
		$inputNBList['gateway']='paytm';
		$NBListResponse=$netbankingdetail_handler->get($inputNBList);	
		$data['netbankingList']=array();	
		if($NBListResponse['status'] && $NBListResponse['response']['total']>0){
			$data['netbankingList']=$NBListResponse['response']['netbankingList'];
		}
		$data['postVar']=$postVar;
		$data['content']='payment/paytm_select';
		$data['eventSignupId']=$eventSignupId;
		$data['paymentGatewayKey']=$paymentGatewayKey;
		$data['txtTxnAmount']=$txtTxnAmount;
		$data['currencyCode']=$currencyCode;
		$this->soldTicketValidation($orderId,$orderLogData);
		//$data['paramList'] = $paramList;
        $data['pageName'] = 'Paytm';
		$data['samepage'] = $samepage;
		$data['nobrand'] = $nobrand;
                $data['themeFieldsUrl'] = $themefields;
		$data['jsArray'] = array($this->config->item('js_public_path') . 'paytmSelect',$this->config->item('js_public_path') . 'common');
		$data['cssArray'] = array($this->config->item('css_public_path') . 'paytmSelect'); 
		if(isset($samepage) && $samepage == 1){
			$this->load->view('templates/ticket_widget_template', $data);
		}else{
        $this->load->view('templates/user_template', $data);
		}
		//print_r($orderLogCalculationData);exit;
        //$this->load->view('payment/paytm_select', $data);
    }
    /* Intermediate page for paytm to check the order,signup and checksum values */

    public function paytmProcessingPage() {

        $getVar = $this->input->get();
        $postVar = $this->input->post();
        
        	$orderId = $getVar['oI'];
                $samepage = $getVar['sp'];
		$nobrand = $getVar['nb'];
                $themefields='';
                if(isset($getVar['tf']) && $getVar['tf']!=''){
                $themefields = $getVar['tf'];
                $themefields= str_replace('----', '&', $themefields);
                $replacingArray=array("&t="=>"&theme=","&ti="=>"&title=","&dt="=>"&dateTime=","&lo="=>"&location=","&wc="=>"&wcode=","&nb="=>"&nobrand=");
                foreach ($replacingArray as $rakey => $ravalue) {
                $themefields= str_replace($rakey, $ravalue, $themefields);    
                }
                $themefields=$themefields.'&tb=payment';
                }
		$redirectUrl = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields);
                
		if ($postVar["STATUS"] == "TXN_FAILURE") {
            $this->customsession->setData('booking_message', ERROR_UNSUCCESSFUL_TRANSACTION);
            redirect($redirectUrl);
        }
		//print_r($postVar);exit;
		$postVar['paytmPostParams'] = $this->input->post();
		$this->soldTicketValidation($orderId);
		
        

        $postVar['paymentGatewayKey'] = $getVar['pGI'];
        $postVar['orderId'] = $orderId;
        $postVar['eventSignup'] = $getVar['eS'];
        $postVar['mobile'] = $getVar['mO'];
        $postVar['email'] = $getVar['eM'];
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->paytmProcessingApi($postVar);
		//print_r($apiResponse);exit;
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }

        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        header("Location: " . $successUrl);
        exit;
    }

    /* Intermediate page for Free transaction to update the orderlog data */

    public function freeTicketUpdation() {

        $getVar = $this->input->get();
        
        $orderId = $getVar['orderId'];
        $this->soldTicketValidation($orderId);

        $samepage = $getVar['samepage'];
        $nobrand = $getVar['nobrand'];
                $themefields='';
                if(isset($getVar['themefields']) && $getVar['themefields']!=''){
                $themefields = $getVar['themefields'];
                $themefields= str_replace('----', '&', $themefields);
                $themefields=$themefields.'&tb=payment';
                }
        $redirectUrl = commonHelperGetPageUrl('seating', '', '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields);
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->freeProcessingApi($getVar);
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }

        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        header("Location: " . $successUrl);
        exit;
    }


    /*
     * Function to prepare the paypal form data to redirect to its payment page
     *
     * @access	public
     * @param
     *      	txnAmount - Total amount that need to pay the user
     *      	oid - Order Id from the `orderlogs` table
     *      	currencyCode - Currency Code of the tickets
     *      	eventSignupId - EventSignUp Id
     *      	eventTitle - Title of the Event
     * @return	redirects to the paypal payment page
     */

    public function paypalPrepare() {
        $postVar = $this->input->post();
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        $gatewayData = $data = array();
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            
            if (count($gatewayArr) > 0) {
                $gatewayData = $gatewayArr;
            }
        }
        $gatwayCredentials = unserialize($gatewayData['extraparams']);
        $gatewayName = $gatewayData['functionname'];
        $gatewayMode = $gatewayData['environment'];
        $merchantId = $gatewayData['merchantid'];
        /* Getting the payment gateway details from database ends here */
        
        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
        $samepage = $postVar['samepage'];
        $nobrand = $postVar['nobrand'];
        $themefields='';
        $themefieldsErrorPage='';
        if(isset($postVar['themefields']) && $postVar['themefields']!=''){
            $themefields = '&themefields='.$postVar['themefields'];
            $themefieldsErrorPage= str_replace('----', '&', $themefields);
            $themefieldsErrorPage=$themefieldsErrorPage.'&tb=payment';
        }
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        if (($orderLogData['status'] && $orderLogData['response']['total'] == 0) || !$orderLogData['status']) {
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = ERROR_NO_ORDERLOG_FOUND;
            $output['redirectUrl'] = site_url();
            echo json_encode($output); exit;
        }
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventSignupId = $oldOrderLogData['eventsignup'];
        $txtTxnAmount = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
        $currencyCode = $orderLogCalculationData['calculationDetails']['currencyCode'];
        $EventId = $orderLogCalculationData['eventid'];
        
        if($eventSignupId == '0' || $eventSignupId == ''){
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = ERROR_SELECT_PAYPAL_STRIPE;
            $output['redirectUrl'] = site_url();
            echo json_encode($output); exit;
        }
        // Getting order Log data ends here

        /* Return output is used because paypal inloves this function through ajax request */
        $orderLogData['returnOutput'] = TRUE;
        $ticketValidation = $this->soldTicketValidation($orderId,$orderLogData);
        if($ticketValidation['status'] == FALSE){
            echo json_encode($ticketValidation); exit;
        }

        $PayPalReturnURL = commonHelperGetPageUrl('payment_paypalProcessingPage') . "?eventSignup=" . $eventSignupId . "&samepage=".$samepage.'&nobrand='.$nobrand."&orderId=" . $orderId . "&paymentGatewayKey=" . $paymentGatewayKey.$themefields;

        /* Converting the amount to USD other than USD payments since paypal not supports some of currency codes */
        if($gatewayName == 'paypal'){
            if ($currencyCode != 'USD') {
                $txtTxnAmount = $orderLogCalculationData['convertedAmount'];
            } else {
                $txtTxnAmount = $txtTxnAmount;
            }
        }elseif($gatewayName == 'paypalinr'){
            $txtTxnAmount = $txtTxnAmount;
        }
        

        if (!is_numeric($txtTxnAmount)) {
            $errorMessage = "Something is wrong with the transaction amount. Please try again.";
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = $errorMessage;
            $output['redirectUrl'] = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefieldsErrorPage);
            echo json_encode($output); exit;
        }

        //PayPal Credentials for Library
        $paypalAccessKeys = array(
            'PayPalApiClientId' => $gatwayCredentials['PayPalApiClientId'],
            'PayPalApiSecretKey' => $gatwayCredentials['PayPalApiSecretKey'],
            'mode' => $gatewayMode,
            'merchantId' => $merchantId
        );

        $this->load->library('paypal/paypal.php', $paypalAccessKeys);

        //Get profile experience id from config table, if does not exist create and add to config table
        $configHandler = new config_handler();
        $cfInputs['key'] = 'paypalProfileExperience';
        $cfInputs['sourcecriteria'] = $gatewayMode;    
        $profileExperienceRes = $configHandler->getConfigDetails($cfInputs);
        if($profileExperienceRes['status'] == TRUE){
            $createOrderInput['profileExperienceId'] = $profileExperienceRes['response']['configData'][0];
        }else{
           $paypalExperienceRes = $this->paypal->getProfileExperience();
           if($paypalExperienceRes['status'] == FALSE){
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = SOMETHING_WENT_WRONG;
            echo json_encode($output); exit;
           }

           $configData['key'] = 'paypalProfileExperience'; 
           $configData['sourcecriteria'] = $gatewayMode;    
           $configData['value'] = json_encode(array($paypalExperienceRes['response']));
           $insertRes = $configHandler->create($configData);
           if($insertRes['status'] == FALSE){
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = SOMETHING_WENT_WRONG;
            echo json_encode($output); exit;
           }
           $createOrderInput['profileExperienceId'] = $paypalExperienceRes['response'];
        }
        
        $userDetails = explode('@@', $orderLogCalculationData['addressStr']);
        $createOrderInput['customerName'] = $userDetails[0];
        $createOrderInput['customerEmail'] = $userDetails[1];
        $createOrderInput['customerPhone'] = $userDetails[2];
        $createOrderInput['customerCity'] = ($userDetails[5] != '') ? $userDetails[5] : $userDetails[3];
        $createOrderInput['customerState'] = ($userDetails[4] != '') ? $userDetails[4] : $userDetails[3];
        $tempAddress = '';
        if ($createOrderInput['customerCity'] != '') {
            $tempAddress .= $createOrderInput['customerCity'] . ',';
        }
        if ($createOrderInput['customerState'] != '') {
            $tempAddress .= $createOrderInput['customerState'];
        }
        $createOrderInput['customerAddress'] = ($userDetails[3]) ? $userDetails[3] : $tempAddress;
        $createOrderInput['customerPincode'] = ($userDetails[6]) ? $userDetails[6] : '500081';

        $createOrderInput['eventTitle'] = $postVar['eventTitle'];
        $createOrderInput['eventId'] = $EventId;
        $createOrderInput['amount'] = $txtTxnAmount;
         if($gatewayName == 'paypal'){
            $createOrderInput['currency'] = 'USD';
        }else{
            $createOrderInput['currency'] = $currencyCode;
        }

        $createOrderInput['receipt'] = $oldOrderLogData['eventsignup'];
        $createOrderInput['userId'] = $oldOrderLogData['userid'];
        $createOrderInput['orderId'] = $oldOrderLogData['orderid'];
        $createOrderInput['returnUrl'] = $PayPalReturnURL;
        $createOrderInput['cancelUrl'] = $PayPalReturnURL;

        $paymentRes = $this->paypal->createPayment($createOrderInput);
        if($paymentRes['status'] == FALSE){
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = $paymentRes['message'];
            $output['redirectUrl'] = site_url();
            echo json_encode($output); exit;
        }
        
        $paymentDetails = $paymentRes['response'];
        if($paymentDetails['state'] != 'created'){
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = 'Something is wrong with the transaction amount. Please try again.';
            $output['redirectUrl'] = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefieldsErrorPage);
            echo json_encode($output); exit;
        }
        $output = array(
            'status' => TRUE,    
            'id' => $paymentDetails['id']
        );
        echo json_encode($output); exit;
    }

    /* Intermediate page for PAYPAL to update the orderlog data */

    public function paypalProcessingPage() {
        $getVar = $this->input->get();
        
        $samepage = $getVar['samepage'];
        $nobrand = $getVar['nobrand'];
        $orderId = $getVar['orderId'];
        $themefields = '';
        if(isset($getVar['themefields']) && $getVar['themefields']!=''){
            $themefields = $getVar['themefields'];
            $themefields= str_replace('----', '&', $themefields);
            $themefields=$themefields.'&tb=payment';
        }

        $redirectUrl = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields);

        if(!isset($getVar['paymentId'])){
            $this->customsession->setData('booking_message','Something went wrong, Please try again!');
            redirect($redirectUrl);
        }

        //Loading Paypal Library
        $paymentGatewayKey = $getVar['paymentGatewayKey'];
        $gatewayData = $data = array();
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            
            if (count($gatewayArr) > 0) {
                $gatewayData = $gatewayArr;
            }
        }
        $gatwayCredentials = unserialize($gatewayData['extraparams']);
        $gatewayMode = $gatewayData['environment'];

        $paypalAccessKeys = array(
            'PayPalApiClientId' => $gatwayCredentials['PayPalApiClientId'], 
            'PayPalApiSecretKey' => $gatwayCredentials['PayPalApiSecretKey'],
            'mode' =>  $gatewayMode
        );

        $this->load->library('paypal/paypal.php', $paypalAccessKeys);

        $paymentDetailsRes = $this->paypal->getPaymentIdDetails($getVar['paymentId']);
        if($paymentDetailsRes['status'] == FALSE){
            //Handling on invalid PaymentId
            $this->customsession->setData('booking_message', $paymentDetailsRes['message']);
            redirect($redirectUrl);
        }

        $paymentDetails = $paymentDetailsRes['response'];
        $getVar['paymentDetails'] = $paymentDetails;
        $orderId = $paymentDetails['transactions'][0]['custom'];
        $this->soldTicketValidation($orderId);
        $getVar['orderId'] = $orderId;

        $redirectUrl = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields);

        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->paypalProcessingApi($getVar);
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }

        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        header("Location: " . $successUrl);
        exit;
    }

    
    /*
     * Function to validage the sold ticket count with the selected ticket quantity
     *
     * @access	public
     * @param
     *      	orderId - Order Id
     * @return	returns TRUE if the tickets are available or redirects to order page with message
     */

    function soldTicketValidation($orderId, $orderLogDataArr=array()) {

        $orderLogInput['orderId'] = $orderId;
        $redirectUrl = site_url();  // Need to replace it after finializing the error response page
        
        if(is_array($orderLogDataArr) && count($orderLogDataArr) > 0) {
            $orderLogData = $orderLogDataArr;
        } else {
            $orderlogHandler = new Orderlog_handler();
            $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
            
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Line num 1801 soldTicketValidation ::".date('Y/m/d H:i:s'));
            if (($orderLogData['status'] && $orderLogData['response']['total'] == 0) || !$orderLogData['status']) {
                if(isset($orderLogDataArr['returnOutput']) && $orderLogDataArr['returnOutput'] == TRUE){
                    $output = array();
                    $output['status'] = FALSE;
                    $output['message'] = ERROR_NO_ORDERLOG_FOUND;
                    $output['redirectUrl'] = $redirectUrl;
                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Line num 1806 soldTicketValidation ::".date('Y/m/d H:i:s'));
                    $this->commonHandler->log_message(print_r($output, TRUE));
                    return $output;
                }else{
                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Line num 1811 soldTicketValidation redirectUrl: $redirectUrl ::".date('Y/m/d H:i:s'));
                    exit;
                    
                    redirect($redirectUrl);
                }
            }
        }
        
        $orderLogSessionData = $orderLogData['response']['orderLogData']['data'];
        $orderLogSessionDataArr = unserialize($orderLogSessionData);
        $ticketArray = $orderLogSessionDataArr['ticketarray'];

        $ticketIds = array_keys($ticketArray);
        $ticketDataInput['eventId'] = $orderLogSessionDataArr['eventid'];
        $ticketDataInput['ticketIds'] = $ticketIds;
        $ticketDataInput['taxRequired'] = false;
        $ticketHandler = new Ticket_Handler();
        $ticketsData = $ticketHandler->getTicketsbyIds($ticketDataInput);
        $ticketDataArr = $ticketsData['response']['ticketdetails'];

        foreach ($ticketDataArr as $ticket) {
            $ticketSoldQty = $ticket['totalsoldtickets'];
            $availableTktQty = $ticket['quantity'];

            $ticketNewSoldQty = $ticketSoldQty + $ticketArray[$ticket['id']];

            // If the selected quantity with already sold tickets exceeded total quantity
            if ($ticketNewSoldQty > $availableTktQty) {
                $errorMessage = $ticket['name'] . ERROR_TICKET_EXCEEDED;
                $this->customsession->setData('booking_message', $errorMessage);
                if(isset($orderLogDataArr['returnOutput']) && $orderLogDataArr['returnOutput'] == TRUE){
                    $output = array();
                    $output['status'] = FALSE;
                    $output['message'] = ERROR_TICKET_EXCEEDED;
                    $output['redirectUrl'] = $redirectUrl;

                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Line num 1845 soldTicketValidation ::".date('Y/m/d H:i:s'));
                    $this->commonHandler->log_message(print_r($output, TRUE));
                    return $output;
                }else{
                    $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Line num 1848 soldTicketValidation redirectUrl: $redirectUrl ::".date('Y/m/d H:i:s'));
                    redirect($redirectUrl);
                }
            }
        }

        if(isset($orderLogDataArr['returnOutput']) && $orderLogDataArr['returnOutput'] == TRUE){
            $output = array();
            $output['status'] = TRUE;
            $output['response'] = $orderLogData;
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Line num 1859 soldTicketValidation ::".date('Y/m/d H:i:s'));
            $this->commonHandler->log_message(print_r($output, TRUE));
            return $output;
        }else{
            $commonHandler=new Common_handler();
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Line num 1863 soldTicketValidation ::".date('Y/m/d H:i:s'));
            $this->commonHandler->log_message(print_r($orderLogData, TRUE));
            return $orderLogData;
        }
    }

    /*
     * Function to validage the orderlog and eventsignid after the payment and before confirmation
     *
     * @access	public
     * @param
     *      	eventSignupId - EventSignUp Id
     *      	orderId - Order Id
     * @return	returns TRUE or FALSE based on the validation and update the `orderLog` table
     */

    /*public function orderLogValidation($getVar) {
        $orderId = $getVar['orderId'];
        $return['status'] = TRUE;

        $orderLogInput['orderId'] = $orderId;
        $orderLogData = array();
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $return['errorMessage'] = SOMETHING_WRONG;
            $return['status'] = FALSE;
            return $return;
        }
        $return['orderLogData'] = $orderLogData['response']['orderLogData'];

        $eventSignupId = $orderLogData['response']['orderLogData']['eventsignup'];
        $eventSignupInput['eventsignupId'] = $eventSignupId;
        $eventsignupHandler = new Eventsignup_handler();
        $signupData = $eventsignupHandler->getEventsignupDetails($eventSignupInput);
        if ($signupData['status'] && $signupData['response']['total'] > 0) {
            
        } else {
            $return['errorMessage'] = SOMETHING_WRONG;
            $return['status'] = FALSE;
            return $return;
        }
        $return['eventSignupData'] = $signupData['response']['eventSignupList'][0];
        return $return;
    }*/

    /*
     * Function to get the payment gateway key values
     *
     * @access	public
     * @param
     *      	$paymentGatewayKey - integer
     * @return	returns an array with the gateway credentials
     */

    public function getPaymentgatewayKeys($paymentGatewayKey) {
        $gatewayInput['gatewayId'] = $paymentGatewayKey;
        $paymentGatewayHandler = new Paymentgateway_handler();
        $gatewayData = $paymentGatewayHandler->getPaymentgatewayList($gatewayInput);
        if ($gatewayData['status']) {
            $gatewayArr = $gatewayData['response']['paymentgatewayList'][$paymentGatewayKey];
            if ($gatewayArr['hashkey'] != '' && $gatewayArr['merchantid'] != '') {
                return $gatewayArr;
            } elseif ($gatewayArr['name'] == 'paypal') {
                return $gatewayArr;
            }elseif ($gatewayArr['name'] == 'paypalinr') {
                return $gatewayArr;
            }
        }
        return array();
    }

    public function thirdPartyEbsPrepare() {
        $postVar = $this->input->post();
        $thirdpartypaymentHandler = new Thirdpartypayment_Handler();
        $thirdpartypaymentHandler->ebsPrepare($postVar);
    }

    public function thirdPartyEbsResponseSave() {
        $inputVar = $this->input->get();
        $thirdpartypaymentHandler = new Thirdpartypayment_Handler();
        $response = $thirdpartypaymentHandler->ebsResponseSave($inputVar);
        print_r($response);
    }
	
	
	public function myWalletOtpGeneration() {
        $data = array();
        $myWalletPaymentGatewayId = $this->config->item('myWalletGatewayId');
        $postVar = $this->input->post();
		
		//print_r($postVar); exit;

       

        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        //print_r($orderLogData); echo $this->ci->db->last_query();exit;
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventSignupId = $oldOrderLogData['eventsignup'];
        $txtTxnAmount = $data['txtTxnAmount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
        $EventId = $orderLogCalculationData['eventid'];
        // Getting order Log data ends here
		
		//getting user wallet amount
		/* Code to check mywallet available for this transaction */
			$userId = $this->customsession->getUserId();
			//print_r($data['calculationDetails']); exit;
			if($userId && $txtTxnAmount > 0 && $orderLogCalculationData['calculationDetails']['currencyCode'] == 'INR'){
				//use wallet
				$this->mywalletHandler = new MyWallet_handler();
				$isValidWalletUser = $this->mywalletHandler->getWalletUserDetails(array("userId"=>$userId));
				if($isValidWalletUser['status']){
					
					$userWalletBalance = 0;
					
					$this->load->library('shmart/shmartwallet.php');
					
					$walletUserDetails = $isValidWalletUser['response']['walletUserDetails'][0][0];
					$balanceInputArr['customerid'] = $walletUserDetails['customerid'];
					$userWalletGeneralBalance = $this->shmartwallet->getUserWalletGeneralBalance($balanceInputArr);	
					//print_r($userWalletGeneralBalance); exit;
					//echo $userWalletGeneralBalance; exit;
					
					if($userWalletGeneralBalance['status'] == 'success') {
						$userWalletBalance = $userWalletGeneralBalance['balance'];
					}
					
					
					
					if($userWalletGeneralBalance >= $orderLogCalculationData['calculationDetails']['totalPurchaseAmount']){
						$userWalletBalance = $userWalletBalance;
					}
				}
			}
			else{
				//wallet not applicable
				$redirectUrl = site_url();
            	redirect($redirectUrl);
			}
			
			
			/* Code to check mywallet available for this transaction, code ends here */
		
		
		/*creating reference id by inserting into wallet transaction table*/
		
		$diffAmtToPay = ($txtTxnAmount-$userWalletBalance);
		if($diffAmtToPay <= 0){ $remainingToPay = 0; }else{$remainingToPay = $diffAmtToPay; }
		
		
		
		if($remainingToPay == 0){
			//wallet amount is enough to do this transaction
			$OTPgeneration = $this->shmartwallet->generateOtp(array("consumer_id"=>$balanceInputArr['customerid']));
			if($OTPgeneration['status'] == 'success'){
				$output['status'] = TRUE;
				$output['response']["messages"][] = $OTPgeneration['message'];
				$output['statusCode'] = STATUS_OK;
				return $output;
			}
			else{
				$output['status'] = FALSE;
				$output["response"]["messages"][] = SOMETHING_WENT_WRONG;
				$output['statusCode'] = STATUS_SERVER_ERROR;
				return $output;
			}
		}
		elseif($remainingToPay > 0){
			//user need to pay rest amount via mywallet paymentgateways
		}
		
		
		
		$output['status'] = FALSE;
        $output["response"]["messages"][] = SOMETHING_WENT_WRONG;
        $output['statusCode'] = STATUS_SERVER_ERROR;
        return $output;
		
		
    }
	
	
	public function myWalletValidateOtp() {

        $data = array();
        $myWalletPaymentGatewayId = $this->config->item('myWalletGatewayId');
        $postVar = $this->input->post();
		
		//print_r($postVar); exit;

        $otp = $postVar['otp'];

        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        //print_r($orderLogData); echo $this->ci->db->last_query();exit;
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventSignupId = $oldOrderLogData['eventsignup'];
        $txtTxnAmount = $data['txtTxnAmount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
        $EventId = $orderLogCalculationData['eventid'];
        // Getting order Log data ends here
		
		//getting user wallet amount
		/* Code to check mywallet available for this transaction */
			$userId = $this->customsession->getUserId();
			//print_r($data['calculationDetails']); exit;
			if($userId && $txtTxnAmount > 0 && $orderLogCalculationData['calculationDetails']['currencyCode'] == 'INR'){
				//use wallet
				$this->mywalletHandler = new MyWallet_handler();
				$isValidWalletUser = $this->mywalletHandler->getWalletUserDetails(array("userId"=>$userId));
				if($isValidWalletUser['status']){
					
					$userWalletBalance = 0;
					
					$this->load->library('shmart/shmartwallet.php');
					
					$walletUserDetails = $isValidWalletUser['response']['walletUserDetails'][0][0];
					$balanceInputArr['customerid'] = $walletUserDetails['customerid'];
					$userWalletGeneralBalance = $this->shmartwallet->getUserWalletGeneralBalance($balanceInputArr);	
					//print_r($userWalletGeneralBalance); exit;
					//echo $userWalletGeneralBalance; exit;
					
					if($userWalletGeneralBalance['status'] == 'success') {
						$userWalletBalance = $userWalletGeneralBalance['balance'];
						
						
					}
					
					
					
					if($userWalletGeneralBalance >= $orderLogCalculationData['calculationDetails']['totalPurchaseAmount']){
						
						//creating merchant_refID for this transaction
						$merchantReffIdInput['userid'] = $userId;
						$merchantReffIdInput['requesttype'] = "GDFW";;
						$merchantReffIdInput['amount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
						$merchantReffIdInput['eventsignupid'] = $eventSignupId;
						$merchantReffIdInput['status'] = "pending";
						$merchantReffIdInput['request'] = serialize($merchantReffIdInput);
						$merchantReffIdInput['useragent'] = $_SERVER['HTTP_USER_AGENT'];
						$merchantReffIdInput['ipaddress'] = commonHelperGetClientIp();
						
						$merchantReff = $this->mywalletHandler->createMerchantReferenceId($merchantReffIdInput);
						if($merchantReff && $merchantReff['status']){
							$debitFromWalletInputArray['merchant_refID'] = $merchantReff['response']['messages'][0];
						}
						
						
						/*calling wellet debit API*/
						$debitFromWalletInputArray['consumer_id'] = $walletUserDetails['customerid'];
						$debitFromWalletInputArray['mobileNo'] = $walletUserDetails['mobile'];
						$debitFromWalletInputArray['total_amount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
						$debitFromWalletInputArray['email'] = $walletUserDetails['email'];
						$debitFromWalletInputArray['otp'] = $otp;
						$debitFromWalletInputArray['debit_from'] = "W";
						$generalWalletDebitResp = $this->shmartwallet->generalWalletDebit($debitFromWalletInputArray);
						
						//print_r($debitFromWalletInputArray); print_r($generalWalletDebitResp); exit;
						
						
						/*if wallet debit succ, updating records*/
						if($generalWalletDebitResp){
							
							if(strtolower($generalWalletDebitResp['status']) == 'success'){
								$upWalletTrsInputArray['userid'] = $userId;
								$upWalletTrsInputArray['id'] = $debitFromWalletInputArray['merchant_refID'];
								$upWalletTrsInputArray['paymenttransid'] = $generalWalletDebitResp['shmart_refID'];
								$upWalletTrsInputArray['response'] = serialize($generalWalletDebitResp);
								$upWalletTrsInputArray['status'] = 'success';
							}
							elseif(strtolower($generalWalletDebitResp['status']) == 'error'){
								$upWalletTrsInputArray['userid'] = $userId;
								$upWalletTrsInputArray['id'] = $debitFromWalletInputArray['merchant_refID'];
								$upWalletTrsInputArray['response'] = serialize($generalWalletDebitResp);
								$upWalletTrsInputArray['status'] = 'fail';
							}
							
							
							
							$upMerchantReff = $this->mywalletHandler->updateMerchantReferenceId($upWalletTrsInputArray);
							//print_r($upWalletTrsInputArray); print_r($upMerchantReff); exit;
							if($upMerchantReff && $upMerchantReff['status']){
								if(strtolower($generalWalletDebitResp['status']) == 'error'){
									$output['status'] = FALSE;
									$output['response']['messages'][] = $generalWalletDebitResp['message'];
								}
								else{
									$output['status'] = TRUE;
									$output['response']['messages'][] = "Merchant refence ID updated successfully";
								}
								
								$output['statusCode'] = STATUS_OK;
								
								//print_r($output);
								return $output;
							}
							
						}
						
						
						
						
						
					}
				}
			}
			
			
			$output['status'] = FALSE;
			$output['statusCode'] = STATUS_SERVER_ERROR;
			$output['response']['messages'][] = SOMETHING_WRONG;
			return $output;
			
    }

    /* Intermediate page for EBS to check the order,signup and checksum values */

    public function myWalletProcessingPage() {

        $getVar = $this->input->get();
        $orderId = $getVar['orderId'];
		$this->soldTicketValidation($orderId);
		$samepage = $getVar['samepage'];
		$nobrand = $getVar['nobrand'];
                $themefields='';
                if(isset($getVar['themefields']) && $getVar['themefields']!=''){
                $themefields = $getVar['themefields'];
                $themefields= str_replace('----', '&', $themefields);
                $themefields=$themefields.'&tb=payment';
                }
        $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->myWalletProcessingApi($getVar);
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }
        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        header("Location: " . $successUrl);
        exit;
    }
	
	
	public function processWalletTransaction() {
		//echo "here"; exit;
        //$this->output->enable_profiler(TRUE);
        $getVar = $this->input->get();
        $orderId = $getVar['orderid'];
		$samepage = $getVar['samepage'];
		$nobrand = $getVar['nobrand'];
        $incompleteTrans=isset($getVar['incomplete'])?$getVar['incomplete']:false;
        $orderLogDataResponse = $this->soldTicketValidation($orderId);
        $redirectUrl = site_url();
        if (($orderLogDataResponse['status'] && $orderLogDataResponse['response']['total'] == 0) || !$orderLogDataResponse['status']) {
            redirect($redirectUrl);
        }
        $orderLogSessionData = unserialize($orderLogDataResponse['response']['orderLogData']['data']);
        //$ticketCount = count($orderLogSessionData['ticketarray']);
        $selectedTicketData = $orderLogSessionData['ticketarray'];
        $eventId = ($orderLogSessionData['eventid']) ? $orderLogSessionData['eventid'] : '';
        if ($eventId == '') {
            redirect($redirectUrl);
        }
        $commonHandler=new Common_handler();
        //$data = array();
        $cookieData = $commonHandler->headerValues();
        if (count($cookieData) > 0) {
            $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }
        $data = $cookieData;
        $isExisted = FALSE;
        $orderLogData = $orderLogDataResponse['response']['orderLogData'];
        if ($orderLogData['eventsignup'] > 0 && is_array($orderLogSessionData['paymentResponse']) &&
                ($orderLogSessionData['paymentResponse']['TransactionID'] > 0 || $orderLogSessionData['paymentResponse']['mode'] != '')) {
            $isExisted = TRUE;
        }

        if ($orderLogSessionData['widgetredirecturl'] != '') {
            $data['redirectUrl'] = $orderLogSessionData['widgetredirecturl'];
        }
        if ($orderLogSessionData['referralcode'] != '') {
            $data['referralcode'] = $orderLogSessionData['referralcode'];
        }
        if ($orderLogSessionData['promotercode'] != '') {
            $data['promotercode'] = $orderLogSessionData['promotercode'];
        }
        if ($orderLogSessionData['acode'] != '') {
            $data['acode'] = $orderLogSessionData['acode'];
        }

        $footerValues = $commonHandler->footerValues();
        $data['categoryList'] = $footerValues['categoryList'];
        $data['defaultCountryId'] = $this->defaultCountryId;
        $data['calculationDetails'] = $orderLogSessionData['calculationDetails'];
        $data['addonArray'] = isset($orderLogSessionData['addonArray']) ? $orderLogSessionData['addonArray'] : array();
        /* Getting the Event Details starts here */
        $request['eventId'] = $eventId;
        $eventHandler = new Event_handler();
        $eventDataArr = $eventHandler->getEventLocationDetails($request);
        //print_r($eventDataArr);exit;
       $data['eventData'] = $ticketDetails = array();
        if ($eventDataArr['status'] && $eventDataArr['response']['total'] > 0) {} else {
            redirect('home');
        }
        $data['collectMultipleAttendeeInfo'] = $collectMultipleAttendeeInfo;
        $data['geoLocalityDisplay'] = $geoLocalityDisplay;
        $userMismatch=false;
		
		/* Code to check mywallet available for this transaction */
			$userId = $this->customsession->getUserId();
			//print_r($data['calculationDetails']); exit;
			if($userId && $data['calculationDetails']['totalPurchaseAmount'] > 0 && $data['calculationDetails']['currencyCode'] == 'INR'){
				//use wallet
				$this->mywalletHandler = new MyWallet_handler();
				$isValidWalletUser = $this->mywalletHandler->getWalletUserDetails(array("userId"=>$userId));
				//print_r($isValidWalletUser); exit;
				if($isValidWalletUser['status']){
					
					$userWalletBalance = 0;
					
					$this->load->library('shmart/shmartwallet.php');
					
					$walletUserDetails = $isValidWalletUser['response']['walletUserDetails'][0][0];
					$balanceInputArr['customerid'] = $walletUserDetails['customerid'];
					$userWalletGeneralBalance = $this->shmartwallet->getUserWalletGeneralBalance($balanceInputArr);	
					//print_r($userWalletGeneralBalance); exit;
					//echo $userWalletGeneralBalance; exit;
					
					if($userWalletGeneralBalance['status'] == 'success') {
						$userWalletBalance = $userWalletGeneralBalance['balance'];
					}
					
					//echo $userWalletBalance."-".$data['calculationDetails']['totalPurchaseAmount']; exit;
					//if($userWalletBalance >= $data['calculationDetails']['totalPurchaseAmount']){
						$mywallet['avialablebalance'] = $userWalletBalance;
						$mywallet['paymentgatewayid'] = $userWalletBalance;
						$mywallet['mobileno'] = $walletUserDetails['mobile'];
						$mywallet['gatewayKey'] = $this->config->item("myWalletGatewayId");
						
					//}
				}
			}
			else{
				//wallet not applicable
			}
		
		
        /* Getting the Event Details ends here */
		
		$mywallet['addedMoneyToWallet'] = true;
        $data['mywallet'] = $mywallet;
		$data['orderLogId'] = $orderId;
        $data['moduleName'] = 'eventModule';
        $data['content'] = 'mywallet_iframe_view';
        $data['pageName'] = 'Wallet Payment';
        $data['isExisted'] = $isExisted;
        $data['userMismatch']=$userMismatch;
        $data['cityList'] = $footerValues['cityList'];
        $data['jsArray'] = array(
				$this->config->item('js_public_path') . 'fixto',
				$this->config->item('js_public_path') . 'jquery.validate',
				$this->config->item('js_public_path') . 'delegate',
				$this->config->item('js_public_path') . 'lightbox',
				$this->config->item('js_public_path') . 'otpVerification'
			);
			
			$data['cssArray'] = array(
				$this->config->item('css_public_path') . 'delegate',
				$this->config->item('css_public_path') . 'lightbox'
			);
		
        $this->load->view('templates/user_template', $data);
    }

  
    /*
     * Function to prepare the Freecharge form data to redirect to its payment page
     *
     * @access	public
     * @param
     *      	TxnAmount - Total amount that need to pay the user
     *      	oid - Order Id from the `orderlogs` table
     *      	uid - User Id of the booking user
     *      	EventSignupId - EventSignUp Id
     *      	EventId - Id of the Event
     *      	EventTitle - Title of the Event
     * @return	redirects to the ebs payment page
     */

    public function freechargePrepare() {

        $postVar = $this->input->post();
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
		$samepage = $postVar['samepage'];
		$nobrand = $postVar['nobrand'];
                $themefields='';
                if(isset($postVar['themefields']) && $postVar['themefields']!=''){
                $themefields = '&themefields='.$postVar['themefields'];
                }
	$gatewayData = $data = array();
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
			
            if (count($gatewayArr) > 0) {
                $gatewayData = $gatewayArr;
            }
        }
        /* Getting the payment gateway details from database ends here */
	$this->load->library('freecharge/freecharge.php');
    
        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
		$this->soldTicketValidation($orderId,$orderLogData);
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $addressStr = $postVar['primaryAddress'];
        $addressArr = explode('@@', $addressStr);
        $eventSignupId = (string) $oldOrderLogData['eventsignup'];
        $returnUrl = commonHelperGetPageUrl('payment',$gatewayData['functionname']."ProcessingPage") . '?orderId='.$orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.'&eventSignup='.$eventSignupId.'&paymentGatewayKey='.$paymentGatewayKey.$themefields;
        $postVar['amount'] = (string)$orderLogCalculationData['calculationDetails']['totalPurchaseAmount'];
        $postVar['merchantId'] = $gatewayData['merchantid'];
        $postVar['merchantTxnId'] =  $eventSignupId ;
        $postVar['email'] = @$addressArr[1];
        $postVar['mobile'] = @$addressArr[2];
        $postVar['customerName'] = $addressArr[0];
        $postVar['channel'] = "WEB";
        $postVar['currency'] = $orderLogCalculationData['calculationDetails']['currencyCode'];;
        $postVar['surl'] = $returnUrl;
        $postVar['furl'] = $returnUrl;
        //$postVar['productInfo'] = $postVar['eventTitle'];
        $data['pageName'] = $gatewayData['name'];
        $EventId = $orderLogCalculationData['eventid'];
        // Getting order Log data ends here
        foreach($this->freecharge->formPaymentElements as $formkey=>$formval)
        {
            if(!empty(@$postVar[$formval]))
            {
                    $data['paramList'][$formkey] = $postVar[$formval];
            }
        }
		
        $data['posturl'] = $gatewayData['posturl'].$this->freecharge->paymentApi;
        $data['pgImage'] = $gatewayData['imageid'];
        $this->freecharge->merchantId = $gatewayData['merchantid'];
        $this->freecharge->hashKey = $gatewayData['hashkey'];
        $this->freecharge->createCheksum($gatewayData,$data['paramList']);
        $data['paramList']["checksum"] = $this->freecharge->checksum;
        $this->soldTicketValidation($orderId,$orderLogData);
        require_once(APPPATH . 'handlers/eventpaymentgateway_handler.php');
        $eventPaymentGateway = new EventpaymentGateway_handler();
        $eventGateways = array();
        $gateWayInput['eventId'] = $EventId;
        $gateWayInput['gatewayStatus'] = true;
        $gateWayInput['paymentGatewayId'] = $paymentGatewayKey;
        $gateWayData = $eventPaymentGateway->getPaymentgatewayByEventId($gateWayInput);
        if ($gateWayData['status'] && count($gateWayData['response']['eventPaymentGatewayList']) > 0) {
            $eventGatewayData = $gateWayData['response']['eventPaymentGatewayList'];
        }
        if(isset($eventGatewayData[0]['extraparams']) && $eventGatewayData[0]['extraparams'] != '') {
            $serializedExtraParam = unserialize($eventGatewayData[0]['extraparams']);
            foreach($serializedExtraParam as $key => $value) {
                $data['extraparams'][$key] = $value;
            }
        }

        $this->load->view('payment/payment_process_prepare', $data);
    }

    /* Intermediate page for Freecharge to check the order,signup and checksum values */

    public function freechargeProcessingPage() {

        $getVar = $this->input->get();
        $postVar = $this->input->post();
		$samepage = $getVar['samepage'];
		$nobrand = $getVar['nobrand'];
                $themefields='';
                if(isset($getVar['themefields']) && $getVar['themefields']!=''){
                $themefields = $getVar['themefields'];
                $themefields= str_replace('----', '&', $themefields);
                $themefields=$themefields.'&tb=payment';
                }
        $orderId = $getVar['orderId'];
		$this->soldTicketValidation($orderId);
        $inputData['orderId'] = $orderId;
        $inputData['merchantTxnId'] = $postVar['merchantTxnId'];
        $inputData['merchantTxnId'] = $postVar['merchantTxnId'];
        $inputData['checksum'] = $postVar['checksum'];
        $inputData['txnId'] = $postVar['txnId'];
        $inputData['amount'] = $postVar['amount'];
        $inputData['status'] = $postVar['status'];
        $inputData['errorCode'] = $postVar['errorCode'];
        $inputData['errorMessage'] = $postVar['errorMessage'];
        $inputData['paymentGatewayKey'] = $getVar['paymentGatewayKey'];
        $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->freechargeProcessingApi($inputData);
        if (!$apiResponse['status'] || $postVar['status']!= "COMPLETED") {
            $errorMessage = $apiResponse['response']['messages'][0];
            if(isset($postVar['errorMessage']))
            $errorMessage = $postVar['errorMessage'];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }
        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefields;
        header("Location: " . $successUrl);
        exit;
    }
	
	
	
	/*
     * Function to prepare the Razorpay form data to redirect to its payment page
     *
     * @access	public
     * @param
     *      	TxnAmount - Total amount that need to pay the user
     *      	oid - Order Id from the `orderlogs` table
     *      	uid - User Id of the booking user
     *      	EventSignupId - EventSignUp Id
     *      	EventId - Id of the Event
     *      	EventTitle - Title of the Event
     * @return	redirects to the ebs payment page
     */

    public function razorpayPrepare() {
        $postVar = $this->input->post();
		//print_r($postVar); exit;
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
		$gatewayData = $data = array();
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
			
            if (count($gatewayArr) > 0) {
                $gatewayData = $gatewayArr;
            }
        }
        /* Getting the payment gateway details from database ends here */
		//$this->load->library('razorpay/razorpay.php');
    
        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
		$samepage = $postVar['samepage'];
		$nobrand = $postVar['nobrand'];
        $themefields='';
        $themefieldsErrorPage='';
        if(isset($postVar['themefields']) && $postVar['themefields']!=''){
           $themefields = '&themefields='.$postVar['themefields'];
           $themefieldsErrorPage= str_replace('----', '&', $themefields);
           $themefieldsErrorPage=$themefieldsErrorPage.'&tb=payment';
        }
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
		$this->soldTicketValidation($orderId,$orderLogData);
		//print_r($postVar); exit;
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
		//print_r($orderLogCalculationData); exit;
        $addressStr = $postVar['primaryAddress'];
        $addressArr = explode('@@', $addressStr);
        $eventSignupId = (string) $oldOrderLogData['eventsignup'];
        $returnUrl = commonHelperGetPageUrl('payment',$gatewayData['functionname']."ProcessingPage") . '?orderId='.$orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.'&eventSignup='.$eventSignupId.'&paymentGatewayKey='.$paymentGatewayKey.$themefields;
		
		$backToPaymentPageUrl = site_url('payment?orderid=').$orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefieldsErrorPage;
		//commonHelperGetPageUrl('payment',$gatewayData['functionname']."Prepare") . "?orderId=$orderId";
		
		
		
		
		
		$razorpayAccessKeys = array('rpaykeyid' => $gatewayData['merchantid'], 'rpaykeysecret' => $gatewayData['hashkey']);
        $this->load->library('razorpay/razorpay.php', $razorpayAccessKeys);
		$createOrderInput['amount']=$orderLogCalculationData['calculationDetails']['totalPurchaseAmount']*100;
		$createOrderInput['currency']='INR';
		$createOrderInput['receipt']=$eventSignupId;
		$createOrderInput['payment_capture'] = 1;
		
		try{
			$order=$this->razorpay->getOrderObject();
			$rpayidDetails = $order->create($createOrderInput);
		}
		catch(Exception $e){
			//print_r($e->message);exit;
			$this->customsession->setData('booking_message', ERROR_SOMETHING_WENT_WRONG);
            redirect($backToPaymentPageUrl);
		}
		
		/*updating razorpayid in evensignup table*/
		/*$eventsignupHandler = new Eventsignup_handler();
		$upEs['eventSignUpId'] = $eventSignupId;
		$upEs['transactionId'] = $rpayidDetails->id;
		$eventsignupHandler->updateEventSignUp($upEs);*/
		/*updating razorpayid in evensignup table*/
		
		
		$data['amount'] = $orderLogCalculationData['calculationDetails']['totalPurchaseAmount']*100; //converting into paisa
        $data['order_id'] = $eventSignupId;
		$data['razorpay_order_id']=$rpayidDetails->id;
        $data['email'] = @$addressArr[1];
        $data['contact'] = @$addressArr[2];
        $data['description'] = $postVar['eventTitle'];
        $data['name'] = @$addressArr[0];
        $data['key'] = $gatewayData['merchantid'];
        $data['returnUrl'] = $returnUrl;
		$data['backToPaymentPageUrl'] = $backToPaymentPageUrl;
        //$postVar['productInfo'] = $postVar['eventTitle'];
        $data['pageName'] = $gatewayData['name'];
        $EventId = $orderLogCalculationData['eventid'];
        // Getting order Log data ends here
        $data['pgImage'] = $gatewayData['imageid'];
        

        $this->load->view('payment/razorpay_prepare', $data);
    }

    /* Intermediate page for Razorpay to check the order,signup values */
    public function razorpayProcessingPage()
    {
        $getVar = $this->input->get();
        $postVar = $this->input->post();
        sleep(10);
        $orderId = $getVar['orderId'];
        $samepage = $getVar['samepage'];
        $nobrand = $getVar['nobrand'];
        $themefields = '';
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Start intermediate page of razorpayProcessingPage function Line 2655 orderId: $orderId ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line number 2656 below is session data ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($_SESSION, TRUE));
        $mybrowser = $this->commonHandler->getBrowser();
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php Line number 2659 below is user browser data ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($mybrowser, TRUE));
        
        $getVar = $this->input->get();
        if (isset($getVar['themefields']) && $getVar['themefields'] != '') {
            $themefields = $getVar['themefields'];
            $themefields = str_replace('----', '&', $themefields);
            $themefields = $themefields . '&tb=payment';
        } else {
            if (isset($getVar['theme']) && $getVar['theme'] != '') {
                $themefields .= '&theme=' . $getVar['theme'];
            }
            if (isset($getVar['title']) && $getVar['title'] != '') {
                $themefields .= '&title=' . $getVar['title'];
            }
            if (isset($getVar['dateTime']) && $getVar['dateTime'] != '') {
                $themefields .= '&dateTime=' . $getVar['dateTime'];
            }
            if (isset($getVar['location']) && $getVar['location'] != '') {
                $themefields .= '&location=' . $getVar['location'];
            }
            if (isset($getVar['wcode']) && $getVar['wcode'] != '') {
                $themefields .= '&wcode=' . $getVar['wcode'];
            }
            if (isset($getVar['t']) && $getVar['t'] != '') {
                $themefields .= '&t=' . $getVar['t'];
            }
            if (isset($getVar['tid']) && $getVar['tid'] != '') {
                $themefields .= '&tid=' . $getVar['tid'];
            }
        }
        $ressqlEs = array();
        if (!empty($getVar['eventSignup'])) {
            $booking_id = $getVar['eventSignup'];
            $ressqlEs = $this->db->query("SELECT id, eventid, transactionstatus FROM eventsignup WHERE id = " . $booking_id)->result_array();
        }
        //Check Status
        if (!empty($ressqlEs) && $ressqlEs[0]['transactionstatus'] == 'success') {
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php razorpayProcessingPage Line 2651 Redirecting to confirmation page for orderId: $orderId ::".date('Y/m/d H:i:s'));
            $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $ressqlEs[0]['eventid'] . '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields;
            header("Location: " . $successUrl);
            exit;
        } else {

            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php razorpayProcessingPage Line 2657 ELSE Block for orderId: $orderId ::".date('Y/m/d H:i:s'));
            $this->soldTicketValidation($orderId);
            
            $inputData['orderId'] = $orderId;
            $inputData['rpayid'] = $postVar['rpayid'];
            $inputData['roredrid'] = $postVar['roredrid'];
            $inputData['rsignature'] = $postVar['rsignature'];
            $inputData['paymentGatewayKey'] = $getVar['paymentGatewayKey'];
            $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields;
            $bookingHandler = new Booking_handler();
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php razorpayProcessingPage Line 2666 calling razorpayProcessingApi for orderId: $orderId ::".date('Y/m/d H:i:s'));
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Passing below data to razorpayProcessingApi");
            $this->commonHandler->log_message(print_r($inputData, TRUE));
            $apiResponse = $bookingHandler->razorpayProcessingApi($inputData);
            
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." After coming from razorpayProcessingApi ::".date('Y/m/d H:i:s'));
            $this->commonHandler->log_message(print_r($apiResponse, TRUE));
            
            if (!$apiResponse['status']) {
                $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php razorpayProcessingPage Line 2671 Failed here for orderId: $orderId ::".date('Y/m/d H:i:s'));
                $errorMessage = $apiResponse['response']['messages'][0];
                if (isset($postVar['errorMessage']))
                    $errorMessage = $postVar['errorMessage'];
                $this->customsession->setData('booking_message', $errorMessage);
                $this->commonHandler->log_message(print_r($errorMessage, TRUE));
                $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php razorpayProcessingPage Line 2677 Redirecting to $redirectUrl ");
                redirect($redirectUrl);
            }
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php razorpayProcessingPage End function Line 2675 Redirecting to confirmation page for orderId: $orderId successUrl: $successUrl ::".date('Y/m/d H:i:s'));
            $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields;
            header("Location: " . $successUrl);
            exit;
        }
    }

    public function ingenicoProcessingPage()
    {
        $getVar = $this->input->get();
        $postVar = $_POST;
        sleep(10);
        $orderId = $getVar['orderId'];
        $samepage = $getVar['samepage'];
        $nobrand = $getVar['nobrand'];
        $themefields = '';
        if (isset($getVar['themefields']) && $getVar['themefields'] != '') {
            $themefields = $getVar['themefields'];
            $themefields = str_replace('----', '&', $themefields);
            $themefields = $themefields . '&tb=payment';
        } else {
            if (isset($getVar['theme']) && $getVar['theme'] != '') {
                $themefields .= '&theme=' . $getVar['theme'];
            }
            if (isset($getVar['title']) && $getVar['title'] != '') {
                $themefields .= '&title=' . $getVar['title'];
            }
            if (isset($getVar['dateTime']) && $getVar['dateTime'] != '') {
                $themefields .= '&dateTime=' . $getVar['dateTime'];
            }
            if (isset($getVar['location']) && $getVar['location'] != '') {
                $themefields .= '&location=' . $getVar['location'];
            }
            if (isset($getVar['wcode']) && $getVar['wcode'] != '') {
                $themefields .= '&wcode=' . $getVar['wcode'];
            }
            if (isset($getVar['t']) && $getVar['t'] != '') {
                $themefields .= '&t=' . $getVar['t'];
            }
            if (isset($getVar['tid']) && $getVar['tid'] != '') {
                $themefields .= '&tid=' . $getVar['tid'];
            }
        }
        $response_data = explode("|", $postVar['msg']);
        $booking_id = $response_data[3];
        $ressqlEs = $this->db->query("SELECT id, eventid, transactionstatus FROM eventsignup WHERE id = " . $booking_id)->result_array();
        //Check Status
        if ($ressqlEs[0]['transactionstatus'] == 'success') {
            $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $ressqlEs[0]['eventid'] . '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields;
            header("Location: " . $successUrl);
            exit;
        } else {
            $this->soldTicketValidation($orderId);
            $inputData['orderId'] = $orderId;
            $inputData['msg'] = $postVar['msg'];
            $inputData['paymentGatewayKey'] = $getVar['paymentGatewayKey'];
            $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields;
            $bookingHandler = new Booking_handler();
            $apiResponse = $bookingHandler->ingenicoProcessingApi($inputData);
            if (!$apiResponse['status']) {
                // echo "it stopped here 2233";
                $errorMessage = $apiResponse['response']['messages'][0];
                if (isset($postVar['errorMessage']))
                    $errorMessage = $postVar['errorMessage'];
                $this->customsession->setData('booking_message', $errorMessage);
                redirect($redirectUrl);
            }
            $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields;
            header("Location: " . $successUrl);
            exit;
        }
    }

    /* Stripe processing */
    public function stripeProcessingPage() {
		
        $getVar = $this->input->get();
        $postVar = $this->input->post();
        $orderId = $getVar['orderId'];
		$this->soldTicketValidation($orderId);
		$samepage = $getVar['samepage'];
                $themefields='';
                if(isset($getVar['themefields']) && $getVar['themefields']!=''){
                $themefields = $getVar['themefields'];
                $themefields= str_replace('----', '&', $themefields);
                $themefields=$themefields.'&tb=payment';
                }
        $inputData['orderId'] = $orderId;
        $inputData['tokenid'] = $getVar['tokenid'];
        $inputData['paymentGatewayKey'] = $getVar['paymentGatewayKey'];
        $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId.'&samepage='.$samepage.$themefields;
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->stripeProcessingApi($inputData);
		//print_r($apiResponse); exit;
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            if(isset($postVar['errorMessage']))
            $errorMessage = $postVar['errorMessage'];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }
        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.$themefields;
        header("Location: " . $successUrl);
        exit;
    }
	
	
	
	/*phonepe prepare*/
	public function phonepePrepare() {
        $postVar = $this->input->post();
		//print_r($postVar); exit;
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
		$gatewayData = $data = array();
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
			//print_r($gatewayArr); exit;
			
            if (count($gatewayArr) > 0) {
                $gatewayData = $gatewayArr;
            }
        }
        /* Getting the payment gateway details from database ends here */
		//$this->load->library('razorpay/razorpay.php');
    
        // Getting order Log data starts here
        $orderId = $postVar['orderId'];
		$samepage = $postVar['samepage'];
		$nobrand = $postVar['nobrand'];
        $themefields='';
        $themefieldsErrorPage='';
        if(isset($postVar['themefields']) && $postVar['themefields']!=''){
            $themefields = '&themefields='.$postVar['themefields'];
            $themefieldsErrorPage= str_replace('----', '&', $themefields);
            $themefieldsErrorPage=$themefieldsErrorPage.'&tb=payment';
        }
        $orderLogInput['orderId'] = $orderId;
        $orderlogHandler = new Orderlog_handler();
        $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
		//print_r($orderLogData); exit;
        if ($orderLogData['status'] && $orderLogData['response']['total'] > 0) {
            
        } else {
            $redirectUrl = site_url();
            redirect($redirectUrl);
        }
		$this->soldTicketValidation($orderId,$orderLogData);
		//print_r($postVar); exit;
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $addressStr = $postVar['primaryAddress'];
        $addressArr = explode('@@', $addressStr);
		//print_r($addressArr); exit;
        $eventSignupId = (string) $oldOrderLogData['eventsignup'];
        
        $returnUrl = commonHelperGetPageUrl('payment',$gatewayData['functionname']."ProcessingPage") . '?orderId='.$orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.'&eventSignup='.$eventSignupId.'&paymentGatewayKey='.$paymentGatewayKey.$themefields;
		
		$backToPaymentPageUrl = site_url('payment?orderid=').$orderId.'&samepage='.$samepage.'&nobrand='.$nobrand.$themefieldsErrorPage;
		//commonHelperGetPageUrl('payment',$gatewayData['functionname']."Prepare") . "?orderId=$orderId";
		
		$gatewayExtraParams = unserialize($gatewayData['extraparams']);
		$saltIndex = array_rand($gatewayExtraParams,1);
		$saltKey = $gatewayExtraParams[$saltIndex];
		//var_dump($pgkeys); exit;
		
		/*echo "<pre>";
		print_r($gatewayExtraParams);
		echo $saltIndex."-".$gatewayExtraParams[$pgkeyIndex];exit;*/
		
		/*$phonepeAccessKeys = array('merchantId' => $gatewayData['merchantid'], 'saltKey' => $gatewayExtraParams[$saltIndex],'saltIndex'=>$saltIndex);*/
        $this->load->library('phonepe/phonepe.php',array("posturl"=>$gatewayData['posturl']));
		$postData['amount']=$orderLogCalculationData['calculationDetails']['totalPurchaseAmount']*100;
		$postData['merchantId']=$gatewayData['merchantid'];
		$postData['transactionId']=$eventSignupId;
		$postData['merchantUserId'] = $this->customsession->getUserId();;
		$postData['merchantOrderId'] = $orderId;
		$postData['subMerchant'] = 'MeraEvents';
		$postData['mobileNumber'] = substr($addressArr[2],-10);
		$postData['message'] = $orderLogCalculationData['eventid'];
		$postData['email'] = $addressArr[1];
		$postData['shortName'] = $addressArr[0];
		
		
		
		$checksum = hash("sha256",$gatewayData['merchantid'].$eventSignupId.$postData['amount'].$saltKey)."###".$saltIndex;
		$headerData = array('Content-type: application/json', 'X-VERIFY: '.$checksum,'X-REDIRECT-URL:'.$returnUrl,'X-REDIRECT-MODE:POST');	
		
		$debitInput['postData'] = $postData;
		$debitInput['headerData'] = $headerData;
		
		/*updating orderlog with payment request*/
		$phonepePaymentRequest = $postData;
		$phonepePaymentRequest['saltKey'] = $saltKey;
		$phonepePaymentRequest['saltIndex'] = $saltIndex;
		$phonepePaymentRequest['headerData'] = $headerData;
		//print_r($phonepePaymentRequest); exit;
		
		
		$orderLogUpdateInput['condition']['orderId'] = $orderId;
        $orderLogUpdateInput['condition']['eventSignupId'] = $eventSignupId;
        $orderLogCalculationData['phonepePaymentRequest'] = $phonepePaymentRequest;
        $updatedSessData = serialize($orderLogCalculationData);

        $orderLogUpdateInput['update']['data'] = $updatedSessData;
        $orderlogHandler->orderLogUpdate($orderLogUpdateInput);
        /*updating orderlog with payment request*/
		
		
		
		$debit = $this->phonepe->debit($debitInput);
		//print_r($debit); exit;
			
		if($debit['status'] && $debit['statusCode'] == '200'){
			header("Location: ".$debit['response']['redirect_url']); exit;
		}else{
			$this->customsession->setData('booking_message', ERROR_SOMETHING_WENT_WRONG);
            redirect($backToPaymentPageUrl);
		}
		
    }
	
    
	/* phonepe processing */
    public function phonepeProcessingPage() {
		
        $getVar = $this->input->get();
        $postVar = $_POST;
		//print_r($getVar);print_r($postVar);

        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." payment.php phonepeProcessingPage function Line number 2979  ::".date('Y/m/d H:i:s'));
		
        $orderId = $getVar['orderId'];
		$this->soldTicketValidation($orderId);
		$samepage = $getVar['samepage'];
        $themefields='';
        if(isset($getVar['themefields']) && $getVar['themefields']!=''){
            $themefields = $getVar['themefields'];
            $themefields= str_replace('----', '&', $themefields);
            $themefields=$themefields.'&tb=payment';
        }
        $inputData['orderId'] = $orderId;
        $inputData['tokenid'] = $getVar['tokenid'];
		$inputData['paymentResponse'] = $postVar;
        $inputData['paymentGatewayKey'] = $getVar['paymentGatewayKey'];
        $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId.'&samepage='.$samepage.$themefields;
        
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Line 2996 Phonepe input array is ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($inputData, TRUE));
        
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->phonepeProcessingApi($inputData);
		
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Payment.php Line 3002 After coming from phonepeProcessingApi Response is ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($apiResponse, TRUE));

        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            if(isset($postVar['errorMessage']))
            $errorMessage = $postVar['errorMessage'];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }
        $successUrl = commonHelperGetPageUrl('confirmation') . "/" . $apiResponse['confirmEventId'] . '?orderid=' . $orderId.'&samepage='.$samepage.$themefields;
        header("Location: " . $successUrl);
        exit;
    }
	

}

?>
