<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/gallery_handler.php');
require_once(APPPATH . 'handlers/currency_handler.php');
require_once(APPPATH . 'handlers/timezone_handler.php');
require_once(APPPATH . 'handlers/developer_handler.php');

class Event extends REST_Controller {

    var $eventHandler;
    var $developerHandler;

    public function __construct() {
        parent::__construct();
		parent::_oauth_validation_check();
        $this->eventHandler = new Event_handler();
        $this->emailHandler = new Email_handler();
        $this->developerHandler = new Developer_handler();
    }
    
    /*
     * Function to get the Events Details
     *
     * @access	public
     * @return	json data   
     */

    
    public function index_post() {
        $inputArray = $this->post();
        if(isset($inputArray['limit']) && $inputArray['limit'] > $this->config->item('apiLimitMaxValue')){
            $output['status'] = FALSE;
            $output["response"]["messages"][] = EVENTS_LIMIT_VALUE_EXCEEDED;
            $output['statusCode'] = STATUS_BAD_REQUEST;
            $this->response($output);
        }
        $accessTokenInfo = $this->developerHandler->setAccessTokenInfo();
        $inputArray['ownerId'] = $accessTokenInfo['user_id'];
        $inputArray['isStandardApiVisible'] = 1; //filtering on standard API
        $inputArray['needTimezoneName'] = 1; // Timezone to Time Zone Name
        $inputArray['disableApiVisible'] = 1; //removing isMobileVisible and isStandardVisible in response
        $inputArray['disableMultiEvents'] = 1; //removing Multi Events from API's
        $inputArray['apiCuration'] = TRUE; //API Curation
        if(isset($inputArray['dateValue'])){
            $inputArray['dateValue'] = allTimeFormats($inputArray['dateValue'], 1);
        }
        $eventList = $this->eventHandler->getEventList($inputArray);
        if(isset($eventList['response']['eventList'])){
             $this->developerHandler = new Developer_handler();
            $eventList['response']['eventList'] = $this->developerHandler->appendFlagstoEventList($eventList['response']['eventList']);
        }
        // if (isset($inputArray['get_private_events'])) {
        //     $privateEventList = $this->eventHandler->getPrivateEventList($inputArray);
        //     $eventList['response']['privateEventList'] = isset($privateEventList['response']['eventList']) ? $privateEventList['response']['eventList'] : array();
        // }
        $resultArray = array('response' => $eventList['response'],'statusCode' => $eventList['statusCode']);
        $this->response($resultArray, $eventList['statusCode']);
    }
    
    public function detail_get() {
        $inputArray = $this->get();
         //To show only standardapi enabled events
        $inputArray['isStandardApiVisible'] = 1;
        $inputArray['disableParameters'] = true;
        $inputArray['getsettings']= true;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);     
        if($eventDetails['statusCode']==STATUS_OK){
            // showing only enabled TNC
            if(strlen($eventDetails['response']['details']['eventDetails']['meraeventstnc']) < 1){
                 unset($eventDetails['response']['details']['eventDetails']['meraeventstnc']);
            }
            if(strlen($eventDetails['response']['details']['eventDetails']['organizertnc']) < 1){
                 unset($eventDetails['response']['details']['eventDetails']['organizertnc']);
            }
            //Swapping timeZoneName and timeZone
            $timeZoneName = $eventDetails['response']['details']['location']['timeZoneName'];
            $eventDetails['response']['details']['location']['timeZone'] = $timeZoneName;
            unset($eventDetails['response']['details']['location']['timeZoneName']);
            unset($eventDetails['response']['details']['timeZoneId']);
        
            $eventDetails['response']['details']['startDate']=convertTime($eventDetails['response']['details']['startDate'],$eventDetails['response']['details']['location']['timeZone'],true);
            $eventDetails['response']['details']['endDate']=convertTime($eventDetails['response']['details']['endDate'],$eventDetails['response']['details']['location']['timeZone'],true);
    }
    $resultArray = array('response' => $eventDetails['response'],'statusCode' => $eventDetails['statusCode']);
        $this->response($resultArray, $eventDetails['statusCode']);
    }

    /*
     * Function to get the Ticketwise Calculations
     *
     * @access	public
     * @param
     *           - ticketArray - array() - contains ticketId and Quantity
     *           - eventId - Integer - Id of the Event
     * @return	Html that contains Total Amount with Calculations
     */

    public function ticketcalculation_post() {
        $inputArray = $this->post();
        $this->eventHandler = new Event_handler();
        if(isset($inputArray['eventId']) && isset($inputArray['ticketArray']) && count($inputArray['ticketArray']) > 1 || count($inputArray['ticketArray']) > 0 && count($inputArray['donateTicketArray']) > 0){
            $input['eventId'] = $inputArray['eventId'];
            $EHresponse = $this->eventHandler->getEventDetails($input);
            if($EHresponse['statusCode']==STATUS_OK && $EHresponse['response']['details']['eventDetails']['limitSingleTicketType'] != 0){
                 $response['status'] = FALSE;
                 $response['statusCode'] = STATUS_OK;
                 $response['response']['messages'][] = SINGLE_TICKET_TYPE_WARNING;
                 $this->response($response);
            }
        }
        
        $ticketResultArray = $this->eventHandler->getEventTicketCalculation_structured($inputArray,$api = true);
        $resultArray = array('response' => $ticketResultArray['response'],'statusCode' => $ticketResultArray['statusCode']);
        $this->response($resultArray, $ticketResultArray['statusCode']);
    }

    public function gallery_get() {
        $inputArray = $this->post();
        
        $this->galleryHandler = new Gallery_handler();
        $galleryList = $this->galleryHandler->getEventGalleryList($inputArray);
        $resultArray = array('response' => $galleryList['response'],'statusCode' => $galleryList['statusCode']);
        $this->response($resultArray, $galleryList['statusCode']);
    }

    /*
     * Function to get the Event Payment Gateways
     *
     * @access	public
     * @param
     *           - eventId - Integer - Id of the Event (required)
     *           - paymentGatewayId - Integer (optional)
     * @return	Html that contains Total Amount with Calculations
     */

    public function gateways_get() {
        
        $inputArray = $this->get();
        $inputArray['gatewayStatus'] = true;
        $ticketResultArray = $this->eventHandler->getEventPaymentGateways($inputArray);
        $resultArray = array('response' => $ticketResultArray['response']);
        $this->response($resultArray, $ticketResultArray['statusCode']);
    }

    /*
     * Function to get the event list based on the places
     *
     * @access	public
     * @param
     * @return	json event list
     */
    public function eventListByPlace_post() {

        $inputArray = $this->post();
        $eventResultArray = $this->eventHandler->geteventListByPlaces($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);
    }

    public function checkDiscountCodeAvailable_post() {
        $inputArray = $this->post();
        $eventResultArray = $this->eventHandler->checkCodesAvailable($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);
    }
    
    public function currencyList_post() {
        $inputArray = $this->post();
        $this->currencyHandler = new Currency_handler();

        $currencyList = $this->currencyHandler->getCurrencyList($inputArray);
        $resultArray = array('response' => $currencyList['response']);
        $this->response($resultArray, $currencyList['statusCode']);
    }
    
    public function timezoneList_post() {
        $inputArray = $this->post();
        $this->timezoneHandler = new Timezone_handler();

        $timezoneList = $this->timezoneHandler->timeZoneList($inputArray);
        $resultArray = array('response' => $timezoneList['response']);
        $this->response($resultArray, $timezoneList['statusCode']);
    }
    
    public function create_post() {
        $inputData = $_POST;
        $accessTokenInfo = $this->developerHandler->setAccessTokenInfo();
        $inputData['ownerId'] = $accessTokenInfo['user_id'];
        $createEventData = $this->eventHandler->apiCreateEventInputDataFormat($inputData);
        
        if (!$createEventData['status']) {
            $statusCode = $createEventData['statusCode'];
            $resultArray = array('response' => $createEventData['response'],'statusCode' => $statusCode);
        } else {
            $createEventInput = $createEventData['response']['formattedData'];
            $createEventInput['sourceUserId'] = $accessTokenInfo['user_id'];
            $createEventInfo = $this->eventHandler->apiCreateEvent($createEventInput);
            $resultArray = array('response' => $createEventInfo['response'],'statusCode' => $createEventInfo['statusCode']);
        }
        $this->response($resultArray, $resultArray['statusCode']);
    }
    
    public function update_post(){
        $inputData = $this->input->post();
        $inputData['eventDescription'] = $_POST['eventDescription'];
        $accessTokenInfo = $this->developerHandler->setAccessTokenInfo();
        $inputData['ownerId'] = $accessTokenInfo['user_id'];
        $updateEventData = $this->eventHandler->apiUpdateEventInputDataFormat($inputData);
          if (!$updateEventData['status']) {
            $resultArray = array('status' => $updateEventData['status'],'response' => $updateEventData['response'],'statusCode' => $updateEventData['statusCode']);
        } else {
            $updateEventData = $updateEventData['response']['formattedData'];
            $updateEventData['sourceUserId'] = $accessTokenInfo['user_id'];
            $createEventInfo = $this->eventHandler->apiUpdateEvent($updateEventData);
            $resultArray = array('status' => $createEventInfo['status'],'response' => $createEventInfo['response'],'statusCode' => $createEventInfo['statusCode']);
        }
        $this->response($resultArray, $resultArray['statusCode']);
    }
    
    public function publishorunpublish_post(){
        $inputData = $this->input->post();
        $accessTokenInfo = $this->developerHandler->setAccessTokenInfo();
        $inputData['ownerId'] = $accessTokenInfo['user_id'];
        $response = $this->developerHandler->publishOrUnpublishEvent($inputData);
        $this->response($response, $response['statusCode']);
        
    }
}
