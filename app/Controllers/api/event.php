<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/gallery_handler.php');
require_once(APPPATH . 'handlers/handlingfee_handler.php');

class Event extends REST_Controller {

    var $eventHandler;

    public function __construct() {
        parent::__construct();

        $this->eventHandler = new Event_handler();
    }

    public function index_get() {
        
    }

    public function list_get() {
        $inputArray = $this->get();
        unset($inputArray['eventMode']);
        unset($inputArray['eventType']);	
		if(isset($inputArray['microsite']) && $inputArray['microsite']=='holi'){
			$inputArray['categoryId'] = 13;
			$eventList = $this->eventHandler->getMEDynamicMicrositesEventList($inputArray);
		}else{
                        if(isset($inputArray['cityId']) && $inputArray['cityId'] == 'others' || isset($inputArray['stateId']) && $inputArray['stateId'] == 'others'){
                            $inputArray['excludeCities'] = array(47,37,14,77,407,41,139,448,504,38,13073,409,23189,330,331,31472,383,1358,10124,324,350,1214,8982,1138,1224,581,408,32159,32160,32161,32162,32163,32164,32165,45717,550);
                            $inputArray['excludeStates'] = array(53,11);
                            unset($inputArray['stateId']);
                            unset($inputArray['cityId']);
                        }
			$eventList = $this->eventHandler->getEventList($inputArray);
		}
		
        
        $resultArray = array('response' => $eventList['response']);
        $this->response($resultArray, $eventList['statusCode']);
    }
	
	public function pastlist_get() {
        $inputArray = $this->get();
		
		
			$eventList = $this->eventHandler->getPastEventList($inputArray);
		
		
        
        $resultArray = array('response' => $eventList['response']);
        $this->response($resultArray, $eventList['statusCode']);
    }
	
	public function filterlist_get(){
	    $inputArray = $this->get();	
		if(isset($inputArray['filcat']) || isset($inputArray['filtprice'])) {
		 $resultArray1 = array('filcat' => $inputArray['filcat'],'filtprice' => $inputArray['filtprice']);  	 
       	  $eventIdarray = $this->eventHandler->getNewyearFilterEvents($resultArray1);
		  if (isset($eventIdarray) && $eventIdarray['response']['total'] > 0) {              
          $inputArray['eventIdsArray'] = $eventIdarray['response']['eventIdsArray'];	
           if(isset($inputArray['cityId']) && $inputArray['cityId'] == 'others' || isset($inputArray['stateId']) && $inputArray['stateId'] == 'others'){
                $inputArray['excludeCities'] = array(47,37,14,77,39,40,407,41);
                $inputArray['excludeStates'] = array(53,11);
                unset($inputArray['stateId']);
                unset($inputArray['cityId']);
            }
          $eventList = $this->eventHandler->getEventList($inputArray);
          $resultArray = array('response' => $eventList['response']);
          $this->response($resultArray, $eventList['statusCode']);		
          }else{
			  $output = array();
			  $output['status'] = TRUE;
		      $output['response']['messages'][] = ERROR_NO_DATA;
			  $output['response']['total'] = 0;
		      $output['statusCode'] = STATUS_OK;
			  $resultArray = array('response' => $output);
			 $this->response($resultArray, $output['statusCode']); 
		  } 		  
		}else{
			$eventList = $this->eventHandler->getEventList($inputArray);
            $resultArray = array('response' => $eventList['response']);
            $this->response($resultArray, $eventList['statusCode']);
		} 
		
	}

    public function piwikList_get() {
        $inputArray = $this->get();

        $eventList = $this->eventHandler->getEventPiwikList($inputArray);
        $resultArray = array('response' => $eventList['response']);

        $this->response($resultArray, $eventList['statusCode']);
    }
    /*
     * Function to get the Events list Citywise
     *
     * @access	public
     * @return	json data
     */

    /* public function getCityEvents_get() {
      $inputArray = $this->get();
      $eventList = $this->eventHandler->getEventListCityWise($inputArray);
      $resultArray = array('response' => $eventList['response']);

      $this->response($resultArray, $eventList['statusCode']);
      } */

    /*
     * Function to get the Events Details
     *
     * @access	public
     * @return	json data   
     */

    public function detail_get() {
        $inputArray = $this->get();

        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        $resultArray = array('response' => $eventDetails['response']);
        $resultArray =  dataCustomFormat($resultArray);
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

    public function getTicketCalculation_post() {
        $inputArray = $this->post();
        $ticketResultArray = $this->eventHandler->getEventTicketCalculation($inputArray);
        $resultArray = array('response' => $ticketResultArray['response']);
        $this->response($resultArray, $ticketResultArray['statusCode']);
    }

    //for book now
    public function bookNow_post() {
        $inputArray = $this->post();

        //Checking Internet Handling for an Event ID
        $handlingfeeHandler = new Handlingfee_handler();
        $internetHandlingRes = $handlingfeeHandler->getHandlingFee($inputArray['eventId']);
        if($internetHandlingRes['status'] == TRUE && $internetHandlingRes['response']['total'] > 0){
           $inputArray['isInterNetHandling'] = 1;
        }else{
            $inputArray['isInterNetHandling'] = 0;
        }
        
        $ticketResultArray = $this->eventHandler->bookNow($inputArray);
        $resultArray = array('response' => $ticketResultArray['response']);
        $this->response($resultArray, $ticketResultArray['statusCode']);
    }

    public function contactInfo_get() {
        $inputArray = $this->get();
        $eventContactInfo = $this->eventHandler->getEventContactInfo($inputArray);
        $resultArray = array('response' => $eventContactInfo['response']);

        $this->response($resultArray, $eventContactInfo['statusCode']);
    }

    public function checkUrlExists_get() {
        $inputArray = $this->get();
        $eventContactInfo = $this->eventHandler->checkUrlExists($inputArray);
        $resultArray = array('response' => $eventContactInfo['response']);

        $this->response($resultArray, $eventContactInfo['statusCode']);
    }

    /**
     * To create the event
     */
    public function create_post() {
       
        $inputData = $this->post();
        if(empty(getUserId())){
           $statusCode=STATUS_BAD_REQUEST;
           $output=array();
           $output['response']['messages'][] = ERROR_NO_SESSION;
            $resultArray = array('response' => $output);
           
        }else{ 
            $inputData['ownerId'] = getUserId();
            $statusCode=200;
            $inputData['eventMode'] = 0;
            if (isset($inputData['isliveevent']) && $inputData['isliveevent'] == 1) {
                $inputData['eventMode'] = 1;
                // if(!empty($inputData['onlineEventUrl'])){
                //     $inputData['zoomStatus'] = 1;
                // }
            }
            
            $createEventData = $this->eventHandler->createEventInputDataFormat($inputData);
            if(!$createEventData['status']){
                $statusCode=$createEventData['statusCode'];
                $resultArray = array('response' => $createEventData['response']);
            }else{
                    $createEventInput=$createEventData['response']['formattedData'];
                    $createEventInfo = $this->eventHandler->createEvent($createEventInput);
                    if($createEventInput['isParentEvent'] == 1 && $createEventInfo['status'] == TRUE){
                       $createEventInput['parentEventId'] = $createEventInfo['response']['id'];
                       $this->eventHandler->createChildEvents($createEventInput);
                    }
                $resultArray = array('response' => $createEventInfo['response']);
                $eventLink = commonHelperGetPageUrl('preview-event', $resultArray['response']['url']);
                if (isset($createEventInfo['status']) && $createEventInfo['status']) {
                    if ($inputData['submitValue'] == "golive") {
                        if($createEventInput['isSpam'] == TRUE){
                            $this->customsession->setData('message', EVENT_SPAM);
                        }else{
                            if(isset($inputData['demo_interest']) && $inputData['demo_interest'] == 1)
                            {
                                $sendSyncMail = $this->eventHandler->sendDemoMailtoAdmin($createEventInfo);
                            }
                            $this->customsession->setData('message', 'Your event has been published successfully.');
                            $this->customsession->setData('eventLink', $eventLink);
                            $sendMail = $this->eventHandler->sendEventPublichedEmailToOrg($createEventInfo);
                            //$eventSyncCategories = array(1, 8, 9);
                            $eventSyncCategories = json_decode(EVENTS_SYNC_ORG_CUSTOM_EMAIL);
                            if(in_array($inputData['categoryId'], $eventSyncCategories) && $inputData['private']==0 && count(json_decode($inputData['multiEvents'])) == 0 && $inputData['accepttoenow']==1){
                                
                                $sendSyncMail = $this->eventHandler->sendEventSyncEeventsnowEmailToOrg($createEventInfo);
                            }
                        }
                    }
                    if ($inputData['submitValue'] == "save") {
                        $this->customsession->setData('message', 'Your event has been created successfully');
                    }
                }
                    $statusCode=$createEventInfo['statusCode'];
            }
        }
        $this->response($resultArray, $statusCode);
    }

    public function gallery_get() {
        $inputArray = $this->get();
        $this->galleryHandler = new Gallery_handler();
        $galleryList = $this->galleryHandler->getEventGalleryList($inputArray);
        $resultArray = array('response' => $galleryList['response']);

        $this->response($resultArray, $galleryList['statusCode']);
    }

    /*
     * To Update the event
     */

    public function edit_post() {
        
        $inputData = $this->post();
        if(empty(getUserId())){
           $statusCode=STATUS_BAD_REQUEST;
           $output=array();
           $output['response']['messages'][] = ERROR_NO_SESSION;
           $resultArray = array('response' => $output);
        }else{
            require_once(APPPATH . 'handlers/dashboard_handler.php');
            $dashboardHandler=new Dashboard_handler();
            $input['eventId'] = $inputData['eventId'];
            $eventResponse=$dashboardHandler->eventAccessVerify($input);
            if($eventResponse['status'] && $eventResponse['response']['total']>0){
                $isOwner=($eventResponse['response']['eventData']['ownerId']==getUserId())?true:false;
                $isCollaboratorForEvent=true;
                if(!$isOwner){
                    require_once(APPPATH . 'handlers/collaborator_handler.php');
                    $collaborator_handler=new Collaborator_handler();
                    $inputCollaborator['eventId']=$inputData['eventId'];
                    $inputCollaborator['getacesslevel']=true;
                    $inputCollaborator['userids']= array(getUserId());
                    $collaboratorResponse=$collaborator_handler->getEventByUserIds($inputCollaborator);
                    //print_r($collaboratorResponse);exit;
                    if($collaboratorResponse['status']){
                        if(($collaboratorResponse['response']['total']>0 && strpos($collaboratorResponse['response']['collaboratorDetail']['module'],'manage')===FALSE) || $collaboratorResponse['response']['total']==0){
                            $isCollaboratorForEvent=false;
                        }
                    }else{
                        $isCollaboratorForEvent=false;
                    }
                }
                if(!$isOwner && !$isCollaboratorForEvent){
                    $statusCode=STATUS_BAD_REQUEST;
                    $output=array();
                    $output['messages'][] = ERROR_NOT_OWNER_FOR_EVENT;
                    $resultArray = array('response' => $output);
                }else{
                    $statusCode=200;
                    $inputData['eventMode'] = 0;

                    if (isset($inputData['isliveevent']) && $inputData['isliveevent'] == 1) {
                        $inputData['eventMode'] = 1;
                    }
                    $eventEditDetails = $this->eventHandler->getEventStatus($inputData['eventId']);
                    $updateEventData = $this->eventHandler->updateEventInputDataFormat($inputData);
                    
                    if(!$updateEventData['status']){
                        $statusCode=$updateEventData['statusCode'];
                        $resultArray = array('response' => $updateEventData['response']);
                    }else{
                        $updateEventInputData=$updateEventData['response']['formattedData'];
                        $updateEventInfo = $this->eventHandler->eventUpdate($updateEventInputData);
                        $resultArray = array('response' => $updateEventInfo['response']);
                        if($updateEventInputData['isMultiEvent'] == TRUE && $updateEventInputData['isParentEvent'] == TRUE && $updateEventInfo['status'] == TRUE){
                            if(count($updateEventInputData['newMultiEventArray']) > 0){
                               $updateEventInputData['createEventData'] = $this->eventHandler->createEventInputDataFormat($inputData); 
                            }
                            $this->eventHandler->updateChildEvents($updateEventInputData);
                        }
                        $eventLink = commonHelperGetPageUrl('preview-event', $resultArray['response']['url']);
                        if (isset($statusCode) && $updateEventInfo['status']) {
                            if ($inputData['submitValue'] == "golive") {
                                if($updateEventInputData['isSpam'] == TRUE){
                                    $this->customsession->setData('message', EVENT_SPAM);
                                }else{
                                    if(isset($inputData['demo_interest']) && $inputData['demo_interest'] == 1)
                                    {
                                        $sendDemoMail = $this->eventHandler->sendDemoMailtoAdmin($updateEventInfo);
                                    }
                                    $this->customsession->setData('message', 'Your event has been published successfully.');
                                    $this->customsession->setData('eventLink', $eventLink);                
                                    $sendMail = $this->eventHandler->sendEventPublichedEmailToOrg($updateEventInfo);
                                    $eventSyncCategories = json_decode(EVENTS_SYNC_ORG_CUSTOM_EMAIL);
                                    if(in_array($inputData['categoryId'], $eventSyncCategories) && $inputData['private']==0 && count(json_decode($inputData['multiEvents'])) == 0 && $inputData['accepttoenow']==1){
                                        $sendSyncMail = $this->eventHandler->sendEventSyncEeventsnowEmailToOrg($updateEventInfo);
                                    }
                                }
                            }
                            if ($inputData['submitValue'] == "save") {
                                $this->customsession->setData('message', 'Your event has been updated successfully');
                                
                                $eventSyncCategories = json_decode(EVENTS_SYNC_ORG_CUSTOM_EMAIL);
                                if(in_array($inputData['categoryId'], $eventSyncCategories) && $inputData['private']==0 && count(json_decode($inputData['multiEvents'])) == 0 && $eventEditDetails[0]['private']==1 && $eventEditDetails[0]['status']==1 && $inputData['accepttoenow']==1){
                                    $sendSyncMail = $this->eventHandler->sendEventSyncEeventsnowEmailToOrg($updateEventInfo);
                                }
                                if(in_array($inputData['categoryId'], $eventSyncCategories) && !in_array($eventEditDetails[0]['categoryid'], $eventSyncCategories) && $inputData['accepttoenow']==1){
                                    $sendSyncMail = $this->eventHandler->sendEventSyncEeventsnowEmailToOrg($updateEventInfo);
                                }
                            }
                        }
                        $statusCode=$updateEventInfo['statusCode'];
                    }
                }
            }else{
                $statusCode=STATUS_BAD_REQUEST;
                $resultArray = array('response' => $eventResponse['response']);
            }
        }
        $this->response($resultArray, $statusCode);
    }

    public function eventCount_get() {
        $inputArray = $this->get();
        $inputArray['ticketSoldout'] = 0;
        $inputArray['status'] = 1;
        $eventCountList = $this->eventHandler->getEventsCountByRegTypes($inputArray);
        $resultArray = array('response' => $eventCountList['response']);
        $statusCode = $eventCountList['statusCode'];
        $this->response($resultArray, $statusCode);
    }

    public function extraCharge_get() {
        $inputArray = $this->get();
        $chargesList = $this->eventHandler->extraCharge($inputArray);
        $resultArray = array('response' => $chargesList['response']);
        $this->response($resultArray, $chargesList['statusCode']);
    }

    public function copyEvent_post() {
        $inputArray = $this->post();
        $eventCopyResponse = $this->eventHandler->copyEvent($inputArray);
        $resultArray = array('response' => $eventCopyResponse['response']);
        $this->response($resultArray, $eventCopyResponse['statusCode']);
    }

    public function mailInvitations_post() {
        $inputArray = $this->post();
        $mailInvitations = $this->eventHandler->mailInvitation($inputArray);
        $resultArray = array('response' => $mailInvitations['response']);
        $statusCode = $mailInvitations['statusCode'];
        $this->response($resultArray, $statusCode);
    }

    public function changeStatus_post() {
        $eventId = $this->post('eventId');
        $output = $this->eventHandler->changeEventStatus($eventId);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function deleteEvent_post() {
        $eventId = $this->post('eventId');
        $output = $this->eventHandler->deleteEvent($eventId);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
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

    public function eventPaymentGateways_get() {
        $inputArray = $this->get();
        $inputArray['gatewayStatus'] = true;
        $ticketResultArray = $this->eventHandler->getEventPaymentGateways($inputArray);
	if($ticketResultArray['status'] == "TRUE" && $ticketResultArray["response"]['total'] > 0)
        {
                        foreach($ticketResultArray["response"]["gatewayList"] as $gatewayDataKey => $gatewayData)
                        {
                                foreach($gatewayData as $gDataKey => $gData)
                                {
                                if($gDataKey == "hashkey")
                                        unset($ticketResultArray["response"]["gatewayList"][$gatewayDataKey]["hashkey"]);
                                }
                        }
        }
        $resultArray = array('response' => $ticketResultArray['response']);
        $this->response($resultArray, $ticketResultArray['statusCode']);
    }

    //To cancel the event in solr
    public function eventCancel_post() {
        $inputArray = $this->post();
        $eventResultArray = $this->eventHandler->eventCancel($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);
    }

    //To change  the event ticket  in solr
    public function eventTicketSoldout_post() {
        $inputArray = $this->post();
        $eventResultArray = $this->eventHandler->eventTicketSoldout($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);
    }

    public function solrEventStatus_post() {
        $inputArray = $this->post();
        $eventResultArray = $this->eventHandler->solrEventStatus($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);

    }

    public function checkDiscountCodeAvailable_get() {
        $inputArray = $this->get();
        $eventResultArray = $this->eventHandler->checkCodesAvailable($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);
    }

    /*
     * Function to get the event list based on the places
     *
     * @access	public
     * @param
     * @return	json event list
     */
    public function eventListByPlace_get() {

        $inputArray = $this->get();
        $eventResultArray = $this->eventHandler->geteventListByPlaces($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);
    }
    
    //To change the event popularity value
    public function solrEventPopularityStatus_post() {
        $inputArray = $this->post();
        $eventResultArray = $this->eventHandler->solrEventStatus($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);
    }
	
	
	
	public function sitemapevents_post() {
        $inputArray = $this->post();
        $eventList = $this->eventHandler->getSitemapEventList($inputArray);
        $resultArray = array('response' => $eventList['response']);

        $this->response($resultArray, $eventList['statusCode']);
    }
    public function solrAPIStatus_post() {
        $inputArray = $this->post();
        $eventResultArray = $this->eventHandler->solrAPIStatus($inputArray);
        $resultArray = array('response' => $eventResultArray['response']);
        $this->response($resultArray, $eventResultArray['statusCode']);
    }
    
	public function getTinyUrl_post(){
		$post = $this->post();
		$tinyUrl = $post['url'];
		if(strlen(trim($tinyUrl)) > 0){
			$tinyUrl = getTinyUrl($tinyUrl);
		}
		$resultArray = array('response' => $tinyUrl);
        $this->response($resultArray, 200);
	}
	
	
	public function updateEventViewCount_post(){
		$post = $this->post();
		$eventid = $post['eventid'];
		if(strlen(trim($eventid)) > 0){
			$eventResultArray = $this->eventHandler->updateEventViewCount($eventid);
			if($eventResultArray['status']){
				$resultArray = array('response' => $eventResultArray['response']['messages']['viewcount']);
				$this->response($resultArray, $eventResultArray['statusCode']);
			}
		}
	}
	
	/*public function getEventViewCount_get(){
		$get = $this->get();
		$eventid = $get['eventid'];
		if(strlen(trim($eventid)) > 0){
			$eventResultArray = $this->eventHandler->getEventViewCount($eventid);
			if($eventResultArray['status']){
				$resultArray = array('response' => $eventResultArray['response']['messages']['viewcount']);
				$this->response($resultArray, $eventResultArray['statusCode']);
			}
		}
	}
	
	*/

        public function otherEvents_get(){
        $getVar = $this->get();
        $otherEveInput['eventId'] = $getVar['eventid'];
        $otherEveInput['limit'] =3;
        $otherEveInput['page']=$getVar['page'];
        $otherEventsResult = $this->eventHandler->otherEvents($otherEveInput);
        $this->response($otherEventsResult, 200);
        }

        public function similarCategoryEvents_get(){
            $getVar = $this->get();
            $getVar['limit'] =3;
            $getEventsData = $this->eventHandler->similarCategoryEvents($getVar);
            $this->response($getEventsData, 200);
            }
    
}
