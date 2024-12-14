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
 * @Created     24-06-2015
 * @Last Modified On  24-06-2015
 * @Last Modified By  Sridevi
 */
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/solr_handler.php');
require_once(APPPATH . 'handlers/ticket_handler.php');
require_once(APPPATH . 'handlers/file_handler.php');
require_once(APPPATH . 'handlers/category_handler.php');
require_once(APPPATH . 'handlers/currency_handler.php');
require_once(APPPATH . 'handlers/timezone_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once(APPPATH . 'handlers/collaborator_handler.php');
require_once(APPPATH . 'handlers/multieventticketcriteria_handler.php');


class Event extends CI_Controller {

    var $eventHandler;
    var $ticketHandler;
    var $fileHandler;
    var $solrHandler;
    var $categoryHandler;
    var $currencyHandler;
    var $defaultCountryId;
    var $cookieHandler;
    var $commonHandler;
    var $timezoneHandler;
    var $tickettaxHandler;
    var $eventSignupHandler;

    public function __construct() {
        parent::__construct();
        $this->eventHandler = new Event_handler();
        $this->commonHandler = new Common_handler();
        $this->categoryHandler = new Category_handler();
        $this->currencyHandler = new Currency_handler();
        $this->timezoneHandler = new Timezone_handler();
        $this->tickettaxHandler = new Tickettax_handler();
    }

    /*
     * Function to get the form for creating event
     *
     * @access	public
     * @return	Html that contains create event form
     */

    public function create() {
        $userId = $this->customsession->getUserId();
        $inputArray['userId'] = $userId;
        require_once(APPPATH . 'handlers/user_handler.php');
        $userHander = new User_handler();
        $isUserMobileVerified = $userHander->isMobileVerified($inputArray);
        $isOrgVerified = $userHander->isOrgVerified($inputArray);
        $userevents = $this->eventHandler->getEventsCountByUserId($inputArray); 
        
        $blockedIps = $this->config->item('blockedCreateEventIps');
        $userIp = commonHelperGetClientIp();
        if(!empty($blockedIps) && in_array($userIp, $blockedIps)){
            redirect(commonHelperGetPageUrl('home'));
        }
        
        if(!$isUserMobileVerified['status'] && !$userevents['status']){
            //do stuff for user mobile not verified & 0 events for user
            $this->session->set_flashdata('message', USER_MOBILE_NOT_VERIFIED);
            redirect(commonHelperGetPageUrl('user-myprofile').'?redirect_url='.commonHelperGetPageUrl('create-event'));
        } 
        
        if( !$isOrgVerified['status'] && $userevents['response']['eventscount'] >= 1 ){
            //do stuff for unverified organizer & only 1 event is there
            $getOrgQuestionnaireStatus = $this->eventHandler->getOrgQuestionnaireStatus($userId);
            if($getOrgQuestionnaireStatus['status'] == FALSE){
            $this->session->set_flashdata('message', ORG_QUESTIONNAIRE_EMPTY);
            redirect(commonHelperGetPageUrl('organizerEvaluation'));
            }
            $this->session->set_flashdata('message', ORG_NOT_VERIFIED);
            redirect(commonHelperGetPageUrl('dashboard'));
        }

        $data = $this->createEditDetails();
        $data1['pageTitle'] = 'Create Event';
        $data1['content'] = 'ticket';
        
        if($this->input->post('eventId')){
            $input['eventId'] = $this->input->post('eventId');
            $eventDetails = $this->eventHandler->getEventDetails($input);
            $data['eventId'] = $_POST['eventId'];
            $data['copyEvent'] = 1;
            $data['eventTimeZoneName'] = $eventDetails['response']['details']['location']['timeZoneName'];
            $inputArray['countryName'] = $eventDetails['response']['details']['location']['countryName'];
            $inputArray['stateName'] = $eventDetails['response']['details']['location']['stateName'];
            $inputArray['cityName'] = $eventDetails['response']['details']['location']['cityName'];
            $inputArray['status'] = 1;
            $eventtickettaxes = $this->tickettaxHandler->getTaxes($inputArray);
            if (!$eventDetails['status']) {
                $output['status'] = FALSE;
                $output['response']['messages'][] = ERROR_INVALID_EVENTID;
                $output['statusCode'] = 400;
                return $output;
            }

            $ticketdetails = $this->eventHandler->getActualEventTicketDetails($data);

            $data['eventDetails'] = $eventDetails['response']['details'];
            $data['eventDetails']['status'] = 0;
            $data['eventDetails']['title'] = removeScriptTag($data['eventDetails']['title']) . ' copy';
            $data['eventDetails']['url'] = cleanUrl($data['eventDetails']['url']) . '-copy';
            $urlExists = $this->eventHandler->checkUrlExists(array('eventUrl' => $data['eventDetails']['url']));
            $i = 0;
            $updated = false;
            while (!$urlExists['status']) {
                $url = $data['eventDetails']['url'] . ++$i;
                $urlExists = $this->eventHandler->checkUrlExists(array('eventUrl' => $url));
                $updated = true;
            }
            if ($updated) {
                $data['eventDetails']['url'] = $data['eventDetails']['url'] . $i;
            }

            $timeZoneName = $data['eventDetails']['location']['timeZoneName'];
            $finalStartTime = '09:00:00';
            $finalEndTime = '18:00:00';
            $startdatetime = explode(" ", convertTime(allTimeFormats(("+2 Days"), 11), $timeZoneName, true));
            $data['eventDetails']['convertedStartDate'] = allTimeFormats($startdatetime[0], 1);
            $data['eventDetails']['convertedStartTime'] = allTimeFormats($finalStartTime, 2);
            $enddatetime = explode(" ", convertTime(allTimeFormats(("+2 Days"), 11), $timeZoneName, true));
            $data['eventDetails']['convertedEndDate'] = allTimeFormats($enddatetime[0], 1);
            $data['eventDetails']['convertedEndTime'] = allTimeFormats($finalEndTime, 2);

            $data1['content'] = 'ticket';

            $currencyListResponse = $this->currencyHandler->getCurrencyList();
            $currencyList = array();
            if ($currencyListResponse['status'] && $currencyListResponse['response']['total'] > 0) {
                $currencyList = $currencyListResponse['response']['currencyList'];
            }

            $currentTickrtDate= convertTime(allTimeFormats(("+0 Days"), 11), $timeZoneName, TRUE);
            $currentTickrtDate=allTimeFormats($currentTickrtDate, 1);
            foreach ($ticketdetails['response']['ticketList'] as $key => $value) {
                $ticketStartDate = allTimeFormats($value['startDate'], 11);
                $finalStartDate = $finalStartTime = $ticketStartDate;
                if (strtotime($ticketStartDate) <= strtotime($currentDateTime)) {
                    $finalStartDate = convertTime(allTimeFormats('', 9), $timeZoneName, TRUE);
                    $finalStartTime = $currentStartTime;
                }
                $ticketEndDate = allTimeFormats($value['endDate'], 11);
                $finalEndDate = $finalEndTime = $ticketEndDate;
                if (strtotime($ticketEndDate) <= strtotime($currentDateTime)) {
                    $finalEndDate = convertTime(allTimeFormats('', 9), $timeZoneName, TRUE);
                    $finalEndTime = $currentEndTime;
                }

                $ticketdetails['response']['ticketList'][$key]['startDate'] = allTimeFormats($currentTickrtDate.$data['eventDetails']['convertedStartTime'],11);
                $ticketdetails['response']['ticketList'][$key]['endDate'] = allTimeFormats($data['eventDetails']['convertedEndDate'].$data['eventDetails']['convertedEndTime'],11);   
            }
            $data1['eventDetails'] = $eventDetails['response']['details'];
            $data1['timeZoneName'] = $timeZoneName;
            $data1['defaultCurrencyId'] = (isset($data['countryList'][$eventDetails['response']['details']['location']['countryId']])?($data['countryList'][$eventDetails['response']['details']['location']['countryId']]['defaultCurrencyId']):1);
            $data1['currencyDetails'] = $currencyList;
            $data1['eventTicketDetails'] = $ticketdetails['response']['ticketList'];
            $data1['eventtickettaxes'] = $eventtickettaxes['response']['taxList'];
            $data1['ticketTaxDetails'] = $ticketdetails['response']['taxList'];
            $data1['oldTicketDetails'] = $ticketdetails['response']['taxDetails'];
            $ticketTaxIds = array();
            foreach ($ticketdetails['response']['taxDetails'] as $key => $taxArr) {
                foreach ($taxArr as $taxmappArr) {
                    $ticketTaxIds[$key][] = $taxmappArr['taxid'];
                }
            }
            $data1['ticketTaxIds'] = $ticketTaxIds;

            require_once(APPPATH . 'handlers/eventextracharge_handler.php');
            $this->eventExtraChargeHandler = new Eventextracharge_handler();
            $extraInput['eventid'] = $this->input->post('eventId');
            $extraCharges = $this->eventExtraChargeHandler->getExtrachargeByEventId($extraInput);
            $extraChargeArray = array();

            $organiserFee = '';
            if($extraCharges['status'] && $extraCharges['response']['total'] > 0) {

                $feeArray = $this->config->item('organizer_fees');
                $extraChargeArray = $extraCharges['response']['eventExtrachargeList'];
                $extraCount = 0;
                foreach($extraChargeArray as $extraCharge) {
                    foreach($feeArray as $feeKey => $feeVal) {
                        if($feeVal['label'] == $extraCharge['label']) {
                            $organiserFee = $feeKey;
                            $extraCount++;
                        }
                    }
                }
                if($extraCount == count($feeArray)) {
                    $organiserFee = 'both';
                }
            }
            $data['eventId'] = 0;
            $data['eventid'] = $this->input->post('eventId');
            $data1['organiser_fee'] = $organiserFee;
            $data['duplicateEvent'] = 1;
            $data1['duplicateEvent'] = 1;
            $data['messages'] = $this->input->post('messages');
        }else{
             $currencyListResponse = $this->currencyHandler->getCurrencyList();
                $currencyList = array();
                if ($currencyListResponse['status'] && $currencyListResponse['response']['total'] > 0) {
                    $currencyList = $currencyListResponse['response']['currencyList'];
                }
                $data1['currencyDetails'] = $currencyList;
            
            $participationtickettype = $this->eventHandler->getParticipationType();
            if ($participationtickettype['status'] && $participationtickettype['response']['total'] > 0) {
            $participationticketDetails = $participationtickettype['response']['participationTicketsList'];
            }
            $data1['participationticketData'] = $participationtickettype;
        }
        
            $data['ticketView'] = $this->load->view('includes/elements/ticket', $data1, true);
            $data['eventTicketDetails'] = array();
            $this->load->view('templates/event_template', $data);
    }

    public function ticket_view() {
        $data['content'] = 'ticket';

        $currencyListResponse = $this->currencyHandler->getCurrencyList();
        $currencyList = array();
        if ($currencyListResponse['status'] && $currencyListResponse['response']['total'] > 0) {
            $currencyList = $currencyListResponse['response']['currencyList'];
        }
        $data['currencyDetails'] = $currencyList;
        $this->load->view('includes/elements/ticket.php', $data);
    }

    /**
     * To edit the event
     * @param type $id --edit event id
     */
    public function edit($id) {

        $data = $this->createEditDetails();
        $data['pageTitle'] = 'Edit Event';

        $data['eventId'] = $id;
        $data['editEvent'] = true;
        $eventDetails = $this->eventHandler->getEventDetails($data);
        $data['eventTimeZoneName'] = $eventDetails['response']['details']['location']['timeZoneName'];
        $inputArray['countryName'] = $eventDetails['response']['details']['location']['countryName'];
        $inputArray['stateName'] = $eventDetails['response']['details']['location']['stateName'];
        $inputArray['cityName'] = $eventDetails['response']['details']['location']['cityName'];
        $inputArray['status'] = 1;
        $eventtickettaxes = $this->tickettaxHandler->getTaxes($inputArray);
        if (!$eventDetails['status']) {
            $output['status'] = FALSE;
            $output['response']['messages'][] = ERROR_INVALID_EVENTID;
            $output['statusCode'] = 400;
            return $output;
        }

        $ticketdetails = $this->eventHandler->getActualEventTicketDetails($data);
        $eventSettingDetails = $this->eventHandler->getEventSettings($data);
        
        $data['eventSettingDetails'] = $eventSettingDetails['response']['eventSettings'][0];
        $data['eventDetails'] = $eventDetails['response']['details'];
        $timeZoneName = $data['eventDetails']['location']['timeZoneName'];
        $startdatetime = explode(" ", convertTime($data['eventDetails']['startDate'], $timeZoneName, true));
        $data['eventDetails']['convertedStartDate'] = allTimeFormats($startdatetime[0], 1);
        $data['eventDetails']['StartDate'] = $startdatetime[0];
        $data['eventDetails']['StartTime'] = $startdatetime[1];
        $data['eventDetails']['convertedStartTime'] = allTimeFormats($startdatetime[1], 2);
        $enddatetime = explode(" ", convertTime($data['eventDetails']['endDate'], $timeZoneName, true));
        $data['eventDetails']['convertedEndDate'] = allTimeFormats($enddatetime[0], 1);
        $data['eventDetails']['convertedEndTime'] = allTimeFormats($enddatetime[1], 2);
        $data1['content'] = 'ticket';
        $currencyListResponse = $this->currencyHandler->getCurrencyList();
        $getParticipationtypes = $this->eventHandler->getParticipationType();
        $currencyList = array();
        if ($currencyListResponse['status'] && $currencyListResponse['response']['total'] > 0) {
            $currencyList = $currencyListResponse['response']['currencyList'];
        }
        $ticketsresponse = $getParticipationtypes;
        $data1['eventDetails'] = $eventDetails['response']['details'];
        $data1['timeZoneName'] = $timeZoneName;
		$data1['defaultCurrencyId'] = (isset($data['countryList'][$eventDetails['response']['details']['location']['countryId']])?($data['countryList'][$eventDetails['response']['details']['location']['countryId']]['defaultCurrencyId']):1);
        $data1['currencyDetails'] = $currencyList;
        $data1['participationticketData'] = $ticketsresponse;
        $data1['eventTicketDetails'] = $ticketdetails['response']['ticketList'];
        $data1['eventtickettaxes'] = $eventtickettaxes['response']['taxList'];
        $data1['ticketTaxDetails'] = $ticketdetails['response']['taxList'];
        $data1['oldTicketDetails'] = $ticketdetails['response']['taxDetails'];
        $ticketTaxIds = array();
        foreach ($ticketdetails['response']['taxDetails'] as $key => $taxArr) {
            foreach ($taxArr as $taxmappArr) {
                $ticketTaxIds[$key][] = $taxmappArr['taxid'];
            }
        }
        $data1['ticketTaxIds'] = $ticketTaxIds;
        $MEinputArray['eventId'] = $data['eventId'];
        $MECheck = $this->eventHandler->checkIsMultiEvent($MEinputArray);
        $data['multiEvent'] = $MECheck['status'];
        $data1['multiEvent'] = $MECheck['status'];
        if($MECheck['status'] == TRUE && $MECheck['masterEvent'] == TRUE){
            $CEinputArray['eventId'] = $data['eventId'];
            $oldMultiEventsRes = $this->eventHandler->getMultiEventChildIds($CEinputArray);
            if($oldMultiEventsRes['status'] == TRUE && $oldMultiEventsRes['response']['total'] > 0){
                $multiEventChilds = $oldMultiEventsRes['response']['eventList'];
            }
            
            $ticketCriteriaHandler = new Multieventticketcriteria_handler();
            foreach($data1['eventTicketDetails'] as $key => $ticket){
                $TCInputs['eventId'] = $ticket['eventId'];
                $TCInputs['ticketId'] = $ticket['id'];
                $criteriaRes = $ticketCriteriaHandler->getCriteria($TCInputs);
                if($criteriaRes['status'] == TRUE){
                    $data1['eventTicketDetails'][$key]['ticketPeriodType'] = $criteriaRes['response']['criteria'][0]['ticketPeriodType'];
                    $data1['eventTicketDetails'][$key]['ticketEndType'] = $criteriaRes['response']['criteria'][0]['ticketEndType'];
                    $data1['eventTicketDetails'][$key]['ticketPeriodValue'] = $criteriaRes['response']['criteria'][0]['ticketPeriodValue'];
                }
            }
            

            $multiEventJson = array();
            $MultiEventsRes = $this->eventHandler->fetchChildEvents($CEinputArray);
            if($MultiEventsRes['status'] == TRUE && $MultiEventsRes['response']['total'] > 0){
                $MultiEventsList = $MultiEventsRes['response']['eventList'];
                foreach($MultiEventsList as $event){
                    $multiEventJson[] = array(
                        $event['eventId'],
                        array(
                           date('Y',strtotime($event['eventStartDate'])),
                           date('n',strtotime($event['eventStartDate'])),
                           date('j',strtotime($event['eventStartDate'])),
                           date('G',strtotime($event['eventStartDate'])),
                           intval(date('i',strtotime($event['eventStartDate']))),
                        ),
                        array(
                           date('Y',strtotime($event['eventEndDate'])), 
                           date('n',strtotime($event['eventEndDate'])), 
                           date('j',strtotime($event['eventEndDate'])), 
                           date('G',strtotime($event['eventEndDate'])), 
                           intval(date('i',strtotime($event['eventEndDate']))),
                        ));
                 
                }
            }   
            $data['multiEvents'] = json_encode($multiEventJson,JSON_NUMERIC_CHECK);
            $data['multiEventCheck'] = TRUE;
        }
        //print_r($data1);exit;
        $this->eventSignupHandler = new Eventsignup_handler();
        if(isset($multiEventChilds) && $MECheck['status'] == TRUE){
            $transactions = $this->eventSignupHandler->getSuccessfullTransactionsByEventId($multiEventChilds, '', 'count');
        }else{
            $transactions = $this->eventSignupHandler->getSuccessfullTransactionsByEventId($data['eventId'], '', 'count');
        }
        $data['transactionsCount'] = 0;
        $data1['transactionsCount'] = 0;
        if ($transactions['status'] == TRUE) {
            $data['transactionsCount'] = $transactions['response']['eventsignupData'][0]['count'];
            $data1['transactionsCount'] = $data['transactionsCount'];
        }
        // successfull transaction tickets
        if (isset($data1['eventTicketDetails']) && !empty($data1['eventTicketDetails'])) {
            foreach ($data1['eventTicketDetails'] as $tkey => $tvalue) {
                $transactionsTickets = array();
                $transactionsTickets = $this->eventSignupHandler->getSuccessfullTransactionsByEventId($data['eventId'], '', 'count', $tvalue['id']);
                if ($transactionsTickets['status'] == TRUE) {
                    if(isset($multiEventChilds) && $MECheck['status'] == TRUE){
                        $data1['transactionsTicketCount'][$tvalue['id']] = $data['transactionsCount'];
                    }else{
                        $data1['transactionsTicketCount'][$tvalue['id']] = $transactionsTickets['response']['eventsignupData'][0]['count'];
                    }
                }
            }
        }
        
        require_once(APPPATH . 'handlers/eventextracharge_handler.php');
        $this->eventExtraChargeHandler = new Eventextracharge_handler();
        $extraInput['eventid'] = $id;
        $extraCharges = $this->eventExtraChargeHandler->getExtrachargeByEventId($extraInput);
        $extraChargeArray = array();
        
        $organiserFee = '';
        if($extraCharges['status'] && $extraCharges['response']['total'] > 0) {
            
            $feeArray = $this->config->item('organizer_fees');
            $extraChargeArray = $extraCharges['response']['eventExtrachargeList'];
            $extraCount = 0;
            foreach($extraChargeArray as $extraCharge) {
                foreach($feeArray as $feeKey => $feeVal) {
                    if($feeVal['label'] == $extraCharge['label']) {
                        $organiserFee = $feeKey;
                        $extraCount++;
                    }
                }
            }
            if($extraCount == count($feeArray)) {
                $organiserFee = 'both';
            }
        }
        $data1['eventsnow_categories'] = json_decode(EVENTS_SYNC_ORG_CUSTOM_EMAIL);
        $data1['organiser_fee'] = $organiserFee;
        $data['ticketView'] = $this->load->view('includes/elements/ticket', $data1, true);
        
		$this->load->view('templates/event_template', $data);
    }

    /**
     * To bring the create & update event related details
     * @return string
     */
    public function createEditDetails() {

        $inputArray = $this->input->get();
        $cookieData = $this->commonHandler->headerValues($inputArray);
        $categoryData = array("major" => 1);
        $categoryList = $this->categoryHandler->getCategoryList($categoryData);

      if (count($cookieData) > 0) {
            $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
           $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
       }
        $data = $cookieData;
        
        if ($categoryList['status'] == TRUE && $categoryList['response']['total'] > 0) {
            $data['categoryList'] = $categoryList['response']['categoryList'];
        }

        $timeZoneList = $this->timezoneHandler->timeZoneList();
        if ($timeZoneList['status'] == TRUE && $timeZoneList['response']['total'] > 0) {
            $data['timeZoneList'] = $timeZoneList['response']['timeZoneList'];
        }


        $data['defaultCountryId'] = $this->defaultCountryId;
        $data['defaultCityId'] = '';
        $footerValues = $this->commonHandler->footerValues();
        $data['cityList'] = $footerValues['cityList'];
        //Pick a theme related images list
        $image_path = $this->config->item('images_content_path');
        $data['pickThemeImages'] = get_theme_images_array($image_path);
        $data['content'] = 'create_event_view';
        $data['pageTitle'] = PAGETITLE_CREATE_EVENT;
        $data['saleButtonTitleList'] = saleButtonTitle();

        $data['userType'] = $this->customsession->getData('userType');

        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jquery.multi-select-dropdown',
            $this->config->item('js_public_path') . 'moment',
            $this->config->item('js_public_path') . 'moment-range',
            $this->config->item('js_public_path') . 'moment-weekday-calc',
            $this->config->item('js_public_path') . 'additional-methods',
            $this->config->item('js_public_path') . 'create_event',
            $this->config->item('js_public_path') . 'bootstrap-tagsinput',
            $this->config->item('js_public_path') . 'tags-custom',
            $this->config->item('js_public_path') . 'bootstrap-timepicker',
            //$this->config->item('js_public_path') . 'onscrollScript',
            $this->config->item('js_public_path') . 'tinymce/tinymce',
            $this->config->item('js_public_path') . 'bootstrap-select' );
        $data['cssArray'] = array(
                /* $this->config->item('css_public_path') . 'create_event_news',
                  $this->config->item('css_public_path') . 'bootstrap-select',
                  $this->config->item('css_public_path') . 'bootstrap-tagsinput', */
        );

        return $data;
    }

    /**
     * Selected Event Dashboard Page
     * @return string
     */
    public function home($eventId, $filtertype = 'all', $ticketId = 0) {
        $inputArray['eventId'] = $eventId;
        $eventData = $this->config->item('eventData');
        $checkZoomEvent = $this->eventHandler->checkZoomEvent($inputArray);
        if($checkZoomEvent[0]['zoomEvent'] == 1){
            $eventData["event" . $eventId]['zoomEvent'] = $checkZoomEvent[0]['zoomEvent'];
        }
        $checkME = $this->eventHandler->checkIsMultiEvent(array('eventId' => $eventId)); 
        $timeZoneData['timezoneId'] = $eventData["event" . $eventId]['timezoneId'];
        $timeZoneDetails = $this->timezoneHandler->details($timeZoneData);
        if ($timeZoneDetails['status']) {
            $timeZoneName = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['name'];
            $timezone = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['timezone'];
        }
        $data['eventTimeZoneName'] = $timeZoneName;
        $data['timezone'] = $timezone;
        $data['eventDetail'] = array();
		
        $eventData['fullAddress']='';
                
        if (isset($eventData["event" . $eventId])) {
            $eventData1 = $eventData["event" . $eventId];
            $data['isCurrentEvent'] = strtotime($eventData["event" . $eventId]['endDateTime']) > strtotime(allTimeFormats('', 11)) ? TRUE : FALSE;
            $data['isEventStarted'] = strtotime('-60 minutes', strtotime($eventData["event" . $eventId]['startDateTime'])) < strtotime(allTimeFormats('', 11)) ? TRUE : FALSE;
        }
        
        $request['eventId'] = $eventId;
        $eventHandler = new Event_handler();
     
        $eventDataArr = $eventHandler->getEventLocationDetails($request);
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
            $eventData1['fullAddress'] = $eventAddress;
        }
                
        $isMultiDateEvent = $checkME['status'];
        $data['isMultiDateEvent'] = $checkME['status'];
        $eventData1['masterevent'] = $eventData['masterevent'];
        $eventData1['parenteventid'] = $eventData['parenteventid'];
        $eventData1['isMultiDateEvent'] = $isMultiDateEvent;
        if($checkME['status'] == TRUE && $checkME['parentId'] > 0){
            $parentDetailsRes = $this->eventHandler->getEventViewCount($checkME['parentId']);
            if($parentDetailsRes['status'] == TRUE){
                $eventData1['viewcount'] = $parentDetailsRes['response']['messages']['viewcount'];
            }
        }
        $data['parenteventid'] = $eventData['parenteventid'];

        $data['eventDetail']=$eventData1;
        $ticketHandler = new Ticket_handler();
        $ticketInput = array('eventId' => $eventId);
        $ticketInput['eventTimeZoneName'] = $timeZoneName;
        $ticketArray = array();
        $tikcetlistdata = $ticketHandler->getActualEventTicketList($ticketInput);
        if ($tikcetlistdata['status'] == TRUE && count($tikcetlistdata['response']['total']) > 0) {
            $ticketArray = $tikcetlistdata['response']['ticketList'];
            $data['taxDetails'] = $tikcetlistdata['response']['taxDetails'];
            $data['taxList'] = $tikcetlistdata['response']['taxList'];
        }
        if($checkME['status'] == FALSE || $checkME['status'] == TRUE && $checkME['masterEvent'] == 0){
            $this->eventSignupHandler = new Eventsignup_handler();
            $inputTotal['eventid'] = $eventId;
            $inputTotal['transactiontype'] = 'all';
            $inputTotal['currencyid'] = '1';
            $inputTotal['filtertype'] = $filtertype;
            if ($ticketId > 0) {
                $inputTotal['ticketid'] = $ticketId;
            }
            $inputTotal['fromHomePage'] = true;
            $totalSaleDataArray = $this->eventSignupHandler->getWeekwiseSales($inputTotal);
            $inputTransactionTotal['eventid'] = $eventId;
            $inputTransactionTotal['reporttype'] = 'summary';
            $inputTransactionTotal['transactiontype'] = 'all';
            $totalSaleTicket = 0;
            $totalSaleAmount = array();
            if ($totalSaleDataArray['status'] == TRUE && $totalSaleDataArray['response']['total'] > 0) {
                $txnData = $totalSaleDataArray['response']['weekWiseData'];
                $totalSaleAmountArray = $totalSaleDataArray['response']['totalTransactionsData'];

                  $totalSaleDataAllCurrencies = $totalSaleAmountArray['totalpaid'];
                  if(isset($totalSaleAmountArray['totalamount']['FREE'])){
                      $totalSaleDataAllCurrencies['FREE']=$totalSaleAmountArray['totalamount']['FREE'];
                  }if(isset($totalSaleAmountArray['totalamount']['FREEquantity'])){
                      $totalSaleDataAllCurrencies['FREEquantity']=$totalSaleAmountArray['totalamount']['FREEquantity'];
                  }
                  $currencyWiseTickets = $totalSaleAmountArray['totalamount'];

                  $totalSaleDataAllCurrenciesUpdated =  array();
                  $data['weekWiseData'] = $txnData;
            } else {

            }
            $totalpaidCurrCode='INR';
            if (isset($totalSaleAmountArray)) {
                $totalSaleTicket = $totalSaleAmountArray['totalquantity'];

                            if(count($totalSaleAmountArray['totalamount'])>=0){
                                $currencies = 0;
                                    foreach($totalSaleAmountArray['totalamount'] as $currCode=>$tPaid){

                                        if($currCode != '' && $currCode != 'FREE' && $tPaid > 0 && strpos($currCode, 'quantity') === false){

                                            $temp=$tPaid;
                                            $totalpaidCurrCode=$currCode;
                                            $currencies++;
                                        }else if($currCode == 'FREEquantity' && $tPaid > 0){

                                            $freequantity = true;
                                            $tempFree=$tPaid;
                                            $totalpaidCurrCodeFree='FREE';
                                        }
                                    }

                            }else{
                                    $temp=isset($totalSaleAmountArray['totalamount']['INR'])?$totalSaleAmountArray['totalamount']['INR']:0;
                            }

                            $totalSaleAmountArray['totalamount']=array();
                            if($currencies > 0){
                                $totalSaleAmountArray['totalamount'][$totalpaidCurrCode]=($temp);
                            }else if($freequantity == true){
                                $totalSaleAmountArray['totalamount'][$totalpaidCurrCodeFree]=0;
                            }else{
                                $totalSaleAmountArray['totalamount'][$totalpaidCurrCode]=($temp);
                            }

                $totalSaleAmount = $totalSaleAmountArray['totalamount'];
            }
            $totalSaleData = array('quantity' => $totalSaleTicket, "currencySale" => $totalSaleAmount, "currencySalePaid" => $totalSaleAmountArray['totalpaid']);

            $inputEffort['eventid'] = $eventId;
            $salesEffortDataResponse = $this->eventSignupHandler->getSalesEffortTotals($inputEffort);

            // var_dump($inputEffort);
            $ticketHandler = new Ticket_handler();
            $ticketCurrencies = $ticketHandler->getTicketCurrencies($inputEffort);

            $ticketPaidCurrencies=array();

                    $orgVsMESales=array('meraevents'=>array('totalquantity'=>0,'totalamount'=>array('INR'=>0)),'organizer'=>array('totalquantity'=>0,'totalamount'=>array('INR'=>0)));
                    //print_r($salesEffortDataResponse);exit;
                    $orgVsMeEfforts['organizerEfforts']=$orgVsMeEfforts['meraeventsEfforts']=array();
            if ($salesEffortDataResponse['status'] && $salesEffortDataResponse['response']['total'] > 0) {
                $salesEffortDataArray = $salesEffortDataResponse['response']['salesEffortResponse'];
                foreach ($salesEffortDataArray as $key => $value) {
                    if ($key == 'meraevents') {
                        $salesEffortData = array('quantity' => $value['totalquantity'], "currencySale" => $value['totalamount'],"currencySalePaid" => $value['totalpaidamount'],'registeredusers' => $value['registeredusers']);
                                            $orgVsMESales[$key]['totalquantity']=$value['totalquantity'];
                                            if(isset($value['totalamount']['INR'])){
                                                    $orgVsMESales[$key]['totalamount']['INR']=$value['totalamount']['INR'];
                                                    $orgVsMESales[$key]['totalpaidamount']['INR']=$value['totalpaidamount']['INR'];
                                            }elseif(isset($value['totalamount']['USD'])){
                                                    $orgVsMESales[$key]['totalamount']['USD']=$value['totalamount']['USD'];
                                                    $orgVsMESales[$key]['totalpaidamount']['USD']=$value['totalpaidamount']['USD'];
                                                    unset($orgVsMESales[$key]['totalamount']['INR']);
                                            }elseif(count(array_keys($value['totalamount']))==1){
                                                    foreach($value['totalamount'] as $k=>$v){
                                                            $orgVsMESales[$key]['totalamount'][$k]=$v;
                                                            unset($orgVsMESales[$key]['totalamount']['INR']);
                                                    }
                                                    foreach($value['totalpaidamount'] as $k=>$v){
                                                            $orgVsMESales[$key]['totalpaidamount'][$k]=$v;
                                                            unset($orgVsMESales[$key]['totalpaidamount']['INR']);
                                                    }
                                            }
                    }elseif ($key == 'organizer') {
                        $orgVsMESales[$key]['totalquantity']=$value['totalquantity'];
                                            if(isset($value['totalamount']['INR'])){
                                                    $orgVsMESales[$key]['totalamount']['INR']=$value['totalamount']['INR'];
                                                    $orgVsMESales[$key]['totalpaidamount']['INR']=$value['totalpaidamount']['INR'];
                                            }elseif(isset($value['totalamount']['USD'])){
                                                    $orgVsMESales[$key]['totalamount']['USD']=$value['totalamount']['USD'];
                                                    $orgVsMESales[$key]['totalpaidamount']['USD']=$value['totalpaidamount']['USD'];
                                                    unset($orgVsMESales[$key]['totalamount']['INR']);
                                            }elseif(count(array_keys($value['totalamount']))==1){
                                                    foreach($value['totalamount'] as $k=>$v){
                                                            $orgVsMESales[$key]['totalamount'][$k]=$v;
                                                            unset($orgVsMESales[$key]['totalamount']['INR']);
                                                    }
                                                    foreach($value['totalpaidamount'] as $k=>$v){
                                                            $orgVsMESales[$key]['totalpaidamount'][$k]=$v;
                                                            unset($orgVsMESales[$key]['totalpaidamount']['INR']);
                                                    }
                                            }
                    }

            /* Organizer efforts= Organizer Sales+Affiliate Marketing Sales+Offline Promoter Sales+Box Office Sales+Viral Ticketing Sales 
                 * MeraEvents efforts = Global Affiliate Marketing Sales+ MeraEvents Sales
                 */
                if($key == 'organizer' || $key == 'promoter' || $key == 'offlinepromoter' || $key == 'viral' || $key == 'spotregistration'){

                   foreach($value['totalpaidamount'] as $k=>$v){

                            if(!isset($orgVsMeEfforts['organizerEfforts'][$k])){
                                $orgVsMeEfforts['organizerEfforts'][$k]=0;
                            }
                            $v=str_replace( ',', '', $v );
                            $orgVsMeEfforts['organizerEfforts'][$k]=$orgVsMeEfforts['organizerEfforts'][$k]+$v;
                            if ($k!='' && strpos($k, 'quantity') == false) {
                                $ticketPaidCurrencies[]=$k;
                            }
                    }
                    foreach($value['totalamount'] as $k=>$v){
                        if($k=='FREE'){
                            if(!isset($orgVsMeEfforts['organizerEfforts'][$k])){
                                $orgVsMeEfforts['organizerEfforts'][$k]=0;
                            }
                            $v=str_replace( ',', '', $v );
                            $orgVsMeEfforts['organizerEfforts'][$k]=$orgVsMeEfforts['organizerEfforts'][$k]+$v;
                            // $orgVsMeEfforts['organizerEfforts']['FREEquantity']=$orgVsMeEfforts['organizerEfforts']['FREEquantity']+$value['FREEtickets'];

                        }
                    }
                  }
                  if($key == 'meraevents' || $key == 'affiliate' || $key == 'boxoffice'){

                    foreach($value['totalpaidamount'] as $k=>$v){

                            if(!isset($orgVsMeEfforts['meraeventsEfforts'][$k])){
                                $orgVsMeEfforts['meraeventsEfforts'][$k]=0;
                            }
                            $v=str_replace( ',', '', $v );
                            $orgVsMeEfforts['meraeventsEfforts'][$k]=$orgVsMeEfforts['meraeventsEfforts'][$k]+$v;
                            if ($k!='' && strpos($k, 'quantity') == false) {
                                $ticketPaidCurrencies[]=$k;
                            }
                    }

                    foreach($value['totalamount'] as $k=>$v){
                         if($k=='FREE'){
                            if(!isset($orgVsMeEfforts['meraeventsEfforts'][$k])){
                                $orgVsMeEfforts['meraeventsEfforts'][$k]=0;
                            }
                            $v=str_replace( ',', '', $v );
                            $orgVsMeEfforts['meraeventsEfforts'][$k]=$orgVsMeEfforts['meraeventsEfforts'][$k]+$v;
                            // $orgVsMeEfforts['meraeventsEfforts']['FREEquantity']=$orgVsMeEfforts['meraeventsEfforts']['FREEquantity']+$value['FREEtickets'];

                         }
                    }
                  }    
                }
            }
            $ticketCurrenciesCodes=$ticketCurrenciesCodesData=array();
            if(isset($ticketCurrencies) && !empty($ticketCurrencies)){
                foreach ($ticketCurrencies as $tckey => $tcvalue) {
                    if($tcvalue['currencyCode']!=''){
                    $ticketCurrenciesCodes[]=$tcvalue['currencyCode'];
                    }
                }
            }
            $ticketCurrenciesAndPaidCurrencies=array_diff($ticketPaidCurrencies,$ticketCurrenciesCodes);
            $ticketCurrenciesAndPaidCurrencies=array_unique($ticketCurrenciesAndPaidCurrencies);
            if(isset($ticketCurrenciesAndPaidCurrencies) && !empty($ticketCurrenciesAndPaidCurrencies)){
                foreach ($ticketCurrenciesAndPaidCurrencies as $tcpckey => $tcpcvalue) {
                    $currencyCodeInput['currencyCode']=$tcpcvalue;
                    $currencyDetailData=$this->currencyHandler->getCurrencyDetailByCode($currencyCodeInput);
                    $ticketCurrencies[]=$currencyDetailData['response']['currencyList']['detail'];
                }

            }
                $ticketCurrenciesSort = array();
                foreach ($ticketCurrencies as $skey => $srow)
                {
                    $ticketCurrenciesSort[$skey] = $srow['currencyId'];
                }
                array_multisort($ticketCurrenciesSort, SORT_ASC, $ticketCurrencies);

            $collaboratorHandler = new Collaborator_handler();
            $inputCollaborator['eventid'] = $eventId;
            $collaboratorList = $collaboratorHandler->getList($inputCollaborator);
            if ($collaboratorList['status'] && $collaboratorList['response']['total'] > 0) {
                $data['collaboratorList'] = $collaboratorList['response']['collaboratorList'];
            } else {
                $data['errors'][] = $collaboratorList['messages'][0];
            }
            $data['filterType'] = $filtertype;
            $data['ticketId'] = $ticketId;

            $data['totalSaleData'] = $totalSaleData;


            //Currencies according to sales
            $currencyList = array();
            foreach($totalSaleDataAllCurrencies as $key => $value){
                if(!strpos($key, 'quantity') && $key != 'FREE'){
                    $currencyListResponse = $this->currencyHandler->getCurrencyDetailByCode(array('currencyCode'=>$key));
                    $currencyList[] = $currencyListResponse['response']['currencyList']['detail'];
                }elseif($key == 'FREE'){
                    $currencyList[] = array(
                        'currencyCode' => 'FREE',
                    );
                }
            }
            if(isset($data['eventDetail']['parenteventid']) && $data['eventDetail']['parenteventid'] > 0){
                $EHInput['eventId'] = $data['eventDetail']['parenteventid'];
                $EHInput['method'] = 'summary';
                $EHResponse = $this->eventHandler->fetchChildEvents($EHInput);
                if($EHResponse['status'] == TRUE && $EHResponse['response']['total'] > 0){
                    $data['childEvents'] = $EHResponse['response']['eventList'];
                }
            }
            $ticketCurrencies = $currencyList;
            $data['totalSaleData']['currencySale'] = array($ticketCurrencies[0]['currencyCode']=>0);
            $data['totalSaleDataAllCurrencies'] = $totalSaleDataAllCurrencies;
            $data['currencyWiseTickets'] = $currencyWiseTickets;
            $data['ticketCurrencies'] = $ticketCurrencies;
            $data['orgVsMeEfforts']=$orgVsMeEfforts;
            $data['salesEffortData'] = $salesEffortData;
            $data['salesEffortDataArray'] = $salesEffortDataArray;
            $data['orgVsMESales'] = $orgVsMESales;
            $data['content'] = 'event_home_view';
            $data['currencyCode'] = 'INR';
            $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/home');
        }else{
            //Multi Date Master Event
             $EHInput['eventId'] = $eventId;
             $EHInput['type'] = 'present';
             $EHInput['method'] = 'detailed';
             $EHResponse = $this->eventHandler->fetchChildEvents($EHInput);
             if($EHResponse['status'] == TRUE && $EHResponse['response']['total'] > 0){
                $data['presentChildEvents'] = $EHResponse['response']['eventList'];
             }

             $EHInput['type'] = 'past';
             $EHResponse = $this->eventHandler->fetchChildEvents($EHInput);
             if($EHResponse['status'] == TRUE && $EHResponse['response']['total'] > 0){
                $data['pastChildEvents'] = $EHResponse['response']['eventList'];
             }
             $TCinputArray['eventid'] = $eventId;

            $this->ticketHandler = new Ticket_handler();
            $data['ticketCurrencies'] = $this->ticketHandler->getTicketCurrencies($TCinputArray);

            //Showing USD filter for all event
            $currencyCodes = array_column($data['ticketCurrencies'], 'currencyCode');
            if(!in_array('USD', $currencyCodes)){
                $usdCurrencyRes = $this->currencyHandler->getCurrencyDetailByCode(array('currencyCode' => 'USD'));    
                if($usdCurrencyRes['status'] == TRUE){
                    $data['ticketCurrencies'] = array_values(array_merge($data['ticketCurrencies'],$usdCurrencyRes['response']['currencyList']));            
                }
            }

            $data['content'] = 'event_home_master_view';
            $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/multievent-home');
        }
        $data['currencyCode'] = 'INR';
        $data['eventId'] = $eventId;
        $data['ticketList'] = $ticketArray;
        $data['pageName'] = 'Event Dashboard';
        $data['pageTitle'] = 'MeraEvents | Manage Event';
        $data['hideLeftMenu'] = 0;
        $this->load->view('templates/dashboard_template', $data);
    }

    public function live($eventId)
    {
        $this->eventSignupHandler = new Eventsignup_handler();
        $transactions = $this->eventSignupHandler->getSuccessfullTransactionsByEventId($eventId, '', 'count');
        $data['transactionsCount'] = 0;
        if ($transactions['status'] == TRUE) {
            $data['transactionsCount'] = $transactions['response']['eventsignupData'][0]['count'];
        }
        if ($data['transactionsCount'] == 0) {
            $this->session->set_flashdata('message', 'There is no bookings for the event, no need of live event.');
            redirect(commonHelperGetPageUrl('dashboard'));
        }
        $eventData = $this->eventHandler->getEventDetails(array('eventId' => $eventId));
        $eventData1 = $eventData['response']['details'];
        $data['isCurrentEvent'] = (strtotime($eventData1['endDate']) > strtotime(allTimeFormats('', 11))) ? TRUE : FALSE;
        if ($data['isCurrentEvent'] == 0) {
            $this->session->set_flashdata('message', 'Already event ended, no need of live event.');
            redirect(commonHelperGetPageUrl('dashboard'));
        }

        $timeZoneData['timezoneId'] = $eventData1['timeZoneId'];
        $timeZoneDetails = $this->timezoneHandler->details($timeZoneData);
        if ($timeZoneDetails['status']) {
            $timeZoneName = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['name'];
            $timezone = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['timezone'];
        }
        if (empty($eventData1['eventDetails']['zoommeetingid'])) {
            $startdatetime = convertTime($eventData1['startDate'], $timeZoneName, true);
            //Getting Zoom Meeting Details
            require_once(APPPATH . 'handlers/zoom_handler.php');
            $this->zoomHandler = new Zoom_handler();
            $meetingDetails = $this->zoomHandler->getMeetingDetails($eventData1, $startdatetime, $timezone);
            if (!is_array($meetingDetails)) {
                $this->session->set_flashdata('message', 'Something went wrong, try again.');
                redirect(commonHelperGetPageUrl('dashboard'));
            }
            $this->load->model('Eventdetail_model');
            $this->Eventdetail_model->resetVariable();
            $insertArray[$this->Eventdetail_model->zoommeetingid] = $meetingDetails['id'];
            $insertArray[$this->Eventdetail_model->zoommeetingpassword] = $meetingDetails['encrypted_password'];
            $where[$this->Eventdetail_model->eventdetail_id] = $eventId;
            $this->Eventdetail_model->setWhere($where);
            $this->Eventdetail_model->setInsertUpdateData($insertArray);
            $this->Eventdetail_model->update_data();
            $meetingId = $meetingDetails['id'];
            $meetingPassword = $meetingDetails['encrypted_password'];
        } else {
            $meetingId = $eventData1['eventDetails']['zoommeetingid'];
            $meetingPassword = $eventData1['eventDetails']['zoommeetingpassword'];
        }
        $data['eventMeetingId'] = $meetingId;
        $data['eventMeetingPassword'] = $meetingPassword;
        $data['eventMeetingRole'] = 1;
        $data['eventMeetingDisplayName'] = 'Organizer';
        $data['timezone'] = $timezone;
        $data['eventDetail'] = $eventData1;
        $data['content'] = 'event_live_view';
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/home');
        $data['eventId'] = $eventId;
        $data['pageName'] = 'Live Event';
        $data['pageTitle'] = 'MeraEvents | Live Event';
        $data['hideLeftMenu'] = 0;
        $this->load->view('templates/live_event_template', $data);
    }

    public function noAccess() {
        $message = $this->uri->segment(3);
        $data['pageName'] = 'Event Dashboard';
        $data['pageTitle'] = 'Event Dashboard';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'no_acess_view';
        $data['message'] = $message;
        $this->load->view('templates/dashboard_template', $data);
    }

    //To open event terms and conditions in new window
    public function termsAndConditions($eventId) {
        $inputArray['eventId'] = $eventId;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        if ($eventDetails['status']) {
            $data['eventName'] = $eventDetails['response']['details']['title'];
            if ($eventDetails['response']['details']['eventDetails']['tnctype'] == 'organizer') {
                if ($eventDetails['response']['details']['eventDetails']['organizertnc'] != '') {
                    $data['tncDetails'] = $eventDetails['response']['details']['eventDetails']['organizertnc'];
                }
            } else if ($eventDetails['response']['details']['eventDetails']['tnctype'] == 'meraevents') {
                if ($eventDetails['response']['details']['eventDetails']['meraeventstnc'] != '') {
                    $data['tncDetails'] = $eventDetails['response']['details']['eventDetails']['meraeventstnc'];
                }
            }
            $data['pageTitle'] = 'Terms And Conditions';
        } else {
            $data['errors'] = isset($eventDetails['response']['messages']) ? $eventDetails['response']['messages'] : '';
        }
        $this->load->view('dashboard/tnc_popup_view', $data);
    }

}

?>