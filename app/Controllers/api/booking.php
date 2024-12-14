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
require_once(APPPATH . 'handlers/mywallet_handler.php');
require_once(APPPATH . 'handlers/paytm_handler.php');
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/confirmation_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once (APPPATH . 'handlers/orderlog_handler.php');
require_once (APPPATH . 'handlers/event_handler.php');

class Booking extends REST_Controller {
	
	var $attendeeHandler;
	var $fileHandler;
	var $attendeeDetailHandler;
	var $configureHandler;

    public function __construct() {
        parent::__construct();
        $this->bookingHandler = new Booking_handler();
        $this->commonHandler = new Common_handler();
        $this->confirmationHandler = new Confirmation_handler();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;
        $this->eventsignupHandler = new Eventsignup_handler();
        $this->eventHandler = new Event_handler();
		
		$this->load->library('form_validation');
    }

    /*
     * Api to save the booking data
     *
     * @access	public
     * @param
     *      	All the POST & FILE data that came from custom fields,tickts
     *      	ticketArr - array will be in `array(ticketId => ticketCount)` formet
     * @return	gives the json response regards the saving signup data
     */
	public function saveData_post() {
        
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." booking.php saveData_post function Line 61 ".date('Y/m/d H:i:s'));
        
		$postArray = $this->input->post();
                if (!empty($postArray)) {
                    foreach ($postArray as $key => $value) {
                        if (stripos($key, "MobileNo") !== false && substr_count($value, "+") > 1) {
                            $postArray[$key] = substr($value, strpos($value, '+', strpos($value, '+') + 1));
                        }
                    }
                }
		$fileArray = $_FILES;
		$inputArray = array_merge($postArray, $fileArray);
        $bookingResponse = $this->bookingHandler->saveBookingData($inputArray);
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." booking.php saveData_post function Line 74 below is bookingResponse ".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($bookingResponse, TRUE));
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." booking.php Line number 77 below is session data ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($_SESSION, TRUE));
        // $userSession = array();
        // $userSession['session_string'] = json_encode($_SESSION, true);
        // $userSession['user_ip'] = $this->commonHandler->get_client_ip();        
        // $sessionResponse = $this->bookingHandler->saveUserSession($userSession);
        // $this->bookingHandler->getUserSession($this->commonHandler->get_client_ip());

		$resultArray = $bookingResponse;
        $GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY;

        if(!empty($GPTW_EVENTS_ARRAY[$resultArray['confirmEventId']]))
        {
            $purchaserData = $postArray;
            $purchaserData['eventSignupId'] = $resultArray['eventSignupId'];
            $profarma_number = $this->bookingHandler->getPurchaserInvoice_number($resultArray['confirmEventId'], 'profarma_invoice_number');
            $purchaserData['invoice_number'] = GPTW_EMAIL_DETAILS[$resultArray['confirmEventId']]['invoice_number'].$profarma_number;
            $purchaserData['tax_invoice_number'] = GPTW_EMAIL_DETAILS[$resultArray['confirmEventId']]['tax_invoice_number'].$profarma_number;

            $purchaserResponse = $this->bookingHandler->savePurchaserData($purchaserData);
            $res = $this->bookingHandler->updatePurchaserInvoice_number($resultArray['confirmEventId'], 'profarma_invoice_number');
            // Send proforma invoice 

            //$eventsignupDetails = $this->confirmationHandler->emailProfarmaInvoice($resultArray['eventSignupId']);


            $inputArray['eventsignupId'] = $resultArray['eventSignupId'];
            $inputArray['userId'] = getUserId();
            $inputArray['isOrganizer'] = $this->customsession->getData("isOrganizer") ? true : false;
            
            //echo "<pre>"; print_r($inputArray); exit;
            $sendEmail = $this->confirmationHandler->resendTransactionsuccessEmail($inputArray);
        }

        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
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
	public function saveMobileAttendeeData_post() {
		
		$postArray = $this->input->post();
		$fileArray = $_FILES;
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
	public function saveMobileGatewayData_post() {
		
		$postArray = $this->input->post();
		$bookingResponse = $this->bookingHandler->saveGatewayData($postArray);
		
		$resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
	}
	
    public function offlineBooking_post() {
        $postArray = $this->input->post();
		$fileArray = $_FILES;
		$inputArray = array_merge($postArray,$fileArray);
        $response = $this->bookingHandler->offlineBooking($inputArray);
        $statusCode = $response['statusCode'];
        $this->response($response, $statusCode);
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
		$postArray['paymentGatewayKey'] = $this->input->get_post('paymentGatewayKey');
		$postArray['isMobile'] = true;
		$bookingResponse = $this->bookingHandler->ebsProcessingApi($postArray);
		
		$resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
	}
	
	
	public function processWalletTransaction_post() {
		
		$this->mywalletHandler = new MyWallet_handler();
		$postArray = $this->input->post();
		
		$bookingResponse = $this->mywalletHandler->processWalletTransaction($postArray);
		//print_r($bookingResponse);
		
		$resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
	}
	
	
	 public function updateRazorPayResponse_post() {
		 
		 $postArray = $this->input->post();
		 $postArray['paymentGatewayKey'] = $this->input->get_post('paymentGatewayKey');
		 $postArray['rpayid'] = $this->input->get_post('RazorPaymentId');
		 $postArray['isMobile'] = true;
		 $bookingResponse = $this->bookingHandler->razorpayProcessingApi($postArray);
		  
		 $resultArray = $bookingResponse;
		 $statusCode = $bookingResponse['statusCode'];
		 $this->response($resultArray, $statusCode);
	 }
    /*
     * Function to get the orderid status
     *
     * @access  public
     * @param   $inputArray contains
     *              orderId - alphanumeric
                    signupId - numeric
     * @return  array
     */
    public function getOrderStatus_post() {
        
        $postArray = $this->input->post();

        require_once(APPPATH . 'handlers/orderlog_handler.php');
        $orderlogHandler = new Orderlog_handler();
        
        $bookingResponse = $orderlogHandler->getOrderIdStatus($postArray);

        $resultArray = $bookingResponse;
        $statusCode = $bookingResponse['statusCode'];
        $this->response($resultArray, $statusCode);
    }
 
    public function delegatepass_get() {
       
        $eventsignupId =  $this->uri->segment(4);
        if(!urldecode($this->uri->segment(5))){
        $userEmail = str_replace("%40", "@", $userEmail);
    }else{
        $userEmail =  urldecode($this->uri->segment(5));
    }
        $footerValues = $this->commonHandler->footerValues();
        $cookieData = $this->commonHandler->headerValues();
        $eventsignupArray['eventsignupId'] = $eventsignupId;
        $eventsignupArray['userId'] = $this->customsession->getData('userId');
        if(isset($eventsignupId) && $eventsignupId != '' ){
            $inputArray['eventsignupId'] = $eventsignupId;
            $inputArray['userEmail'] = $userEmail;
            $checkEventsignup = $this->eventsignupHandler->checkEventsignup($inputArray);
            if($checkEventsignup['status'] && $checkEventsignup['response']['total']>0){
                $stagedevent = 0;
                if($checkEventsignup['response']['eventId'] != ''){
                    $event['eventId'] = $checkEventsignup['response']['eventId'];
                    $eventSetttingsInfoResponse = $this->eventHandler->getEventSettings($event);
                    if ($eventSetttingsInfoResponse['status']) {
                        if ($eventSetttingsInfoResponse['response']['total'] > 0) {
                            if($eventSetttingsInfoResponse['response']['eventSettings'][0]['stagedevent'] == 1){
                                $stagedevent = 1;
                                $paymentstage = $eventSetttingsInfoResponse['response']['eventSettings'][0]['paymentstage'];

                            }
                        }
                    }
                }
                $inputArray['stagedevent'] = $stagedevent;
                $checkEventsignup = $this->eventsignupHandler->checkEventsignup($inputArray);
                if($stagedevent == 1){

                    if($checkEventsignup['response']['stagedstatus'] == 1){
                        $data['message'] = TYPE_STAGED_ORGANIZER_NOT_APPROVED_ERROR;
                    }else if($checkEventsignup['response']['stagedstatus'] == 3){
                        $data['message'] = TYPE_STAGED_ORGANIZER_REJECTED_THIS_REGISTRATION;
                    }else if($paymentstage == 2 && $checkEventsignup['response']['stagedstatus'] == 2 && $checkEventsignup['response']['transactionstatus'] != 'success' && !in_array($checkEventsignup['response']['paymentstatus'],array('Refunded', 'Canceled'))){
                        $data['message'] = TYPE_STAGED_APPROVED_BUT_PAYMENT_NOT_DONE;
                    }else {
                        $eventsignupArray['eventsignupId'] = $inputArray['eventsignupId'];
                        $eventsignupArray['userId'] = $checkEventsignup['response']['userId'];
                        $this->confirmationHandler->printPasses($eventsignupArray);
                    }
                }else{
                    $eventsignupArray['eventsignupId'] = $inputArray['eventsignupId'];
                    $eventsignupArray['userId'] = $checkEventsignup['response']['userId'];
                    $this->confirmationHandler->printPasses($eventsignupArray);
                }


            }
            $data['moduleName'] = 'eventModule';
            $data['pageName'] = 'Print Pass';
            $data['pageTitle'] = 'Print Pass';
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'fixto'  ,
                $this->config->item('js_public_path') . 'inviteFriends'  ,
                $this->config->item('js_public_path') . 'jquery.validate'  ,
                $this->config->item('js_public_path') . 'event'  );
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'print_tickets'  ,
                $this->config->item('css_public_path') . 'onscroll-specific');
            $data['countryList']='';
            $data['categoryList']='';

            if (count($cookieData) > 0) {
                $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
                $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
            }
            if(isset($checkEventsignup['response']['messages']) && count($checkEventsignup['response']['messages'])>0){
                $data['content'] = 'error_view';
                if(!isset($data['message'])){
                    $data['message'] = ERROR_INVALID_DATA;
                }

            }
            $data['categoryList'] = $footerValues['categoryList'];
            $data['defaultCountryId'] = $this->defaultCountryId;
            
            $this->load->view('templates/user_template', $data);
        }

    }
}
