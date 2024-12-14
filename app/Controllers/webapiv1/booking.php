<?php

/**
 * To save the booking related data
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, MeraEvents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     11-08-2015
 * @Last Modified On  11-08-2015
 * @Last Modified By  Gautam
*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
require_once(APPPATH . 'libraries/REST_Controller.php');

require_once(APPPATH . 'handlers/booking_handler.php');
require_once(APPPATH . 'handlers/paytm_handler.php');
require_once(APPPATH . 'handlers/configure_handler.php');
require_once(APPPATH . 'handlers/developer_handler.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once (APPPATH . 'handlers/orderlog_handler.php');

class Booking extends REST_Controller {
	
	var $attendeeHandler;
	var $fileHandler;
	var $attendeeDetailHandler;
	var $configureHandler;
        
    public function __construct() {
        parent::__construct();
        $this->bookingHandler = new Booking_handler();
		parent::_oauth_validation_check();
		$this->load->library('form_validation');
    }
	
	//for book now
    public function index_post() {
        $inputArray = $this->post();

        $this->eventHandler = new Event_handler();
        if(isset($inputArray['eventId'])){
            $eventTicketDetails = $this->eventHandler->getEventTicketDetails($inputArray);
            foreach($eventTicketDetails['response']['ticketList'] as $k => $v){
                if($v['type'] == 'addon'){
                    $addon = $v['id'];
                    if(isset($inputArray['ticketArray'][$addon]) && count($inputArray['ticketArray']) == 1 && count($inputArray['donateTicketArray']) == 0 || isset($inputArray['ticketArray'][$addon]) && isset($inputArray['donateTicketArray']) && count($inputArray['donateTicketArray']) == 0 && count($inputArray['ticketArray']) == 1){
                        $response['status'] = FALSE;
                        $response['statusCode'] = STATUS_OK;
                        $response['response']['messages'][] = ADDON_TICKET_WARNING;
                        $this->response($response);
                    }
                }
            }
        }
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
        
        $ticketResultArray = $this->eventHandler->bookNow($inputArray,$api = false);
        $resultArray = array('response' => $ticketResultArray['response']);
        $this->response($resultArray, $ticketResultArray['statusCode']);
    }
	
	/*
     * Function to get the custom fields of an event or order
     *
     * @access	public
     * @param	$inputArray contains
     * 				Either eventId - integer
     * 				Or orderId - integer are required
     * 				collectMultipleAttendeeInfo - 1 or 0
     * 				customFieldId - integer
     * 				ticketid - integer
     * @return	array
     */

    public function customfields_post() {
		
        $inputArray = $this->input->post();
		$this->configureHandler = new Configure_handler();
		$inputArray['isValuesRequired'] = true;
                $inputArray['disableCommonfieldid'] = true;
                $inputArray['offlineonly'] = false;
        $customFieldsList = $this->configureHandler->getCustomFieldForms($inputArray);
		
        $resultArray = array('response' => $customFieldsList['response'], 'statusCode' => $customFieldsList['statusCode']);
        $statusCode = $customFieldsList['statusCode'];
        $this->response($resultArray, $statusCode);
    }
     public function saveattendeedata_post() {
		$postArray = $this->input->post();
		$fileArray = $_FILES;
		$inputArray = array_merge($postArray,$fileArray);
                $inputArray['disableGatewayData'] = 1;
		
        $inputArray['isFromAccessToken'] = true;
        $this->developerHandler=new Developer_handler();
        $authorizedResponse=$this->developerHandler->isAuthorized();
        if($authorizedResponse['status'] && $authorizedResponse['response']['total']>0){
            $bookingResponse = $this->developerHandler->saveAttendeeData($inputArray);
            $this->response($bookingResponse, $bookingResponse['statusCode']);
        }else{
            $this->response($authorizedResponse, $authorizedResponse['statusCode']);
        }
    }
    public function offline_post(){
        $inputArray = $this->post();
	$inputArray['transactionID']=$inputArray['transactionId'];
        $this->developerHandler=new Developer_handler();
        $authorizedResponse=$this->developerHandler->isAuthorized();
        if($authorizedResponse['status'] && $authorizedResponse['response']['total']>0){
			$inputArray['noUserCheck'] = true;
            $paynowResponse = $this->developerHandler->offlineBookingApi($inputArray);
            $this->response($paynowResponse, $paynowResponse['statusCode']);
        }else{
            $this->response($authorizedResponse, $authorizedResponse['statusCode']);
        }        
    }
	/*
     * Api to save the booking data from "Mobile"
     *
     * @access	public
     * @param
     *      	All the POST & FILE data that came from custom fields,tickts
     *      	ticketArr - array will be in `array(ticketId => ticketCount)` formet
     * @return	gives the json response regards the saving signup data
     */
	public function attendeesData_post() {
		
		$postArray = $this->input->post();
		$fileArray = $_FILES;
		
		$this->orderlogHandler = new Orderlog_handler();
		$orderLogInput['orderId'] = $postArray['orderId'];
        $orderLogData = $this->orderlogHandler->getOrderlog($orderLogInput);
        if ($orderLogData['status'] && $orderLogData['response']['total'] == 0) {
            $response['status'] = FALSE;
            $response['statusCode'] = STATUS_NO_DATA;
            $response['response']['messages'][] = ERROR_NO_ORDERLOG_FOUND;
            return $response;
        } elseif ($orderLogData['eventsignup'] > 0 && isset($orderLogData['paymentResponse']) && is_array($orderLogData['paymentResponse']) &&
                ($orderLogData['paymentResponse']['TransactionID'] > 0 || $orderLogData['paymentResponse']['mode'] != '')) {
            $response['status'] = FALSE;
            $response['statusCode'] = STATUS_NO_DATA;
            $response['response']['messages'][] = ERROR_ORDERID_USED;
            return $response;
        }
        $orderLogSessionData = unserialize($orderLogData['response']['orderLogData']['data']);
		$postArray['eventId'] = $orderLogSessionData['eventid'];
		$postArray['ticketArr'] = $orderLogSessionData['ticketarray'];
		
		$inputArray = array_merge($postArray,$fileArray);
		$inputArray['isMobile'] = TRUE;
		
		$bookingResponse = $this->bookingHandler->saveBookingData($inputArray);
		
		$resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
	}
	
	/*
     * Function to save the gateway data of the booking from mobile
     *
     * @access	public
     * @param
     *      	eventSignupId - integer
     *      	orderId - string
     *      	paymentGatewayId - integer
     * @return	gives the response status based on saving the gateway adding
     */
	public function gatewayData_post() {
		
		$postArray = $this->input->post();
		$bookingResponse = $this->bookingHandler->saveGatewayData($postArray);
		
		$resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
	}
	
	/*
     * Function to create checksum for paytm
     *
     * @access	public
     * @param
     * 			ORDER_ID
     * 			TXN_AMOUNT
     *      	
     * @return	gives the checksum as response
     */
	public function createPaytmChecksum_post() {
        $this->paytmHandler = new Paytm_handler();
        $inputArray = $this->input->post();
        $response = $this->paytmHandler->createChecksum($inputArray);
        echo $response;exit;
    }

	/*
     * Function to validate the checksum that comes from paytm
     *
     * @access	public
     * @param
     * 			All post variables comes from paytm
     *      	
     * @return	gives the validation status of checksum
     */
    public function validatePaytmChecksum_post() {

        $this->paytmHandler = new Paytm_handler();
        $inputArray = $this->input->post();
        $response = $this->paytmHandler->validateChecksum($inputArray);
        $data['encodedJson'] = $response;
        $this->load->view('payment/paytm_validation_checksum', $data);
    }
	
	/*
     * Function to create checksum for mobikwik
     *
     * @access	public
     * @param
     * 			ORDER_ID
     * 			TXN_AMOUNT
     *      	
     * @return	gives the checksum as response
     */
	public function createMobikwikChecksum_post() {
			
        $inputArray = $this->post();
        $response = $this->bookingHandler->createMobikwikChecksum($inputArray);
        if(!$response['status']) {
            $resultArray = array('response' => $response['response']);
            $this->response($resultArray, $response['statusCode']);
        }
		header('Content-Type: text/xml');
        $string = '<?xml version="1.0" encoding="UTF-8"?>
					<checksum> 
						<status>SUCCESS</status>
						<checksumValue>'.$response['response']['checkSum'].'</checksumValue> 
				   </checksum>';
        echo $string;exit;
    }

	/*
     * Function to validate checksum for mobikwik
     *
     * @access	public
     * @param
     * 			All post variables comes from mobikwik response
     *      	
     * @return	gives the status of the checksum
     */
    public function validateMobikwikChecksum_post() {
	
        $inputArray = $this->post();
        $inputArray['paymentGatewayKey'] = $this->input->get_post('paymentGatewayKey');
        $response = $this->bookingHandler->validateMobikwikChecksum($inputArray);
        if(!$response['status']) {
            $resultArray = array('response' => $response['response']);
            $this->response($resultArray, $response['statusCode']);
        }
        $responseData = $response['response']['responseData'];
		header('Content-Type: text/xml');
        $string = '<?xml version="1.0" encoding="UTF-8"?>
            <paymentResponse> 
                <orderid>'.$responseData['orderId'].'</orderid>
                <amount>'.$responseData['amount'].'</amount> 
                <status>' .$responseData['status']. '</status>
                <statusMsg>'. $responseData['statusMsg'] .'</statusMsg>
            </paymentResponse>';
        echo $string;exit;
    }
	
	/*
     * Function to save the payment response data for Paytm
     *
     * @access	public
     * @param
     *      	eventSignup - integer
     *      	orderId - string
     *      	paymentGatewayId - integer
     *      	email - string
     *      	mobile - integer
     *      	POST variables those are coming from paytm response
     * @return	gives the response status based on saving the payment response
     */
	public function updatePaytmResponse_post() {
		
		$postArray = $this->input->post();
		$bookingResponse = $this->bookingHandler->paytmProcessingApi($postArray);
		
		$resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
	}
	
	/*
     * Function to save the payment response data for Mobikwik
     *
     * @access	public
     * @param
     *      	orderId - string
     *      	paymentGatewayId - integer
     *      	POST variables those are coming from paytm response
     * @return	gives the response status based on saving the payment response
     */
	public function updateMobikwikResponse_post() {
		
		$postArray = $this->input->post();
		$postArray['paymentGatewayKey'] = $this->input->get_post('paymentGatewayKey');
		$postArray['isMobile'] = true;
		$bookingResponse = $this->bookingHandler->mobikwikProcessingApi($postArray);
		
		$resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
	}
	
	/*
     * Function to save the payment response data for EBS
     *
     * @access	public
     * @param
     *      	orderId - string
     *      	paymentGatewayId - integer
     *      	POST variables those are coming from paytm response
     * @return	gives the response status based on saving the payment response
     */
	public function updateEbsResponse_post() {
		
		$postArray = $this->input->post();
		$postArray['isMobile'] = true;
		$postArray['paymentGatewayKey'] = $this->input->get_post('paymentGatewayKey');
		$bookingResponse = $this->bookingHandler->ebsProcessingApi($postArray);
		
		$resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
	}
	
	/*
     * Function to return the pass data
     *
     * @access	public
     * @param
     *      	eventsignupId - integer
     * @return	returns the pass data
     */
	public function pass_get() {
		
		$this->developerHandler = new Developer_handler();
        $inputArray = $this->get();
        $this->load->library('resource');
        $accessTokenResponse = $this->resource->getAccessTokenDetails();
        $sourceUserId = $accessTokenResponse['user_id'];
        $this->load->model('Eventsignup_model');
        if(isset($sourceUserId) && $sourceUserId > 0){
            $this->Eventsignup_model->resetVariable();
            $selectInput['sourceuserid'] = $this->Eventsignup_model->sourceuserid;
            $this->Eventsignup_model->setSelect($selectInput);
            $where[$this->Eventsignup_model->id] = $inputArray['eventsignupId'];
            $this->Eventsignup_model->setWhere($where);
            $Response = $this->Eventsignup_model->get();
            if(!empty($Response) && $sourceUserId != $Response[0]['sourceuserid']){
                $output['status'] = FALSE;
                $output['response']['messages'][] = ERROR_NOT_AUTHORIZED;
                $output['statusCode'] = STATUS_UNAUTHORIZED;   
                $this->response($output);
            }
        }   
        $resultArray = $this->developerHandler->printPass_common($inputArray);
        if(isset($resultArray['eventsignupDetails']['signupdate'])){
         $resultArray['eventsignupDetails']['signupdate'] = allTimeFormats(appendTimeZone(allTimeFormats(strtotime($resultArray['eventsignupDetails']['signupdate']),11),'UTC'),11);
        }
        $this->response($resultArray, $resultArray['statusCode']);
    }
}
