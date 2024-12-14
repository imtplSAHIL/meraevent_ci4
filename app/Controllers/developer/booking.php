<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/developer_handler.php');

class Booking extends REST_Controller {

    var $developerHandler;

    public function __construct() {
        parent::__construct();
        parent::_oauth_validation_check();
        $this->developerHandler = new Developer_handler();
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

    public function saveAttendeeData_post() {
		$postArray = $this->input->post();
		$fileArray = $_FILES;
		$inputArray = array_merge($postArray,$fileArray);
        $inputArray['isFromAccessToken'] = true;
        $authorizedResponse=$this->developerHandler->isAuthorized();
        if($authorizedResponse['status'] && $authorizedResponse['response']['total']>0){
            $bookingResponse = $this->developerHandler->saveAttendeeData($inputArray);
            $this->response($bookingResponse, $bookingResponse['statusCode']);
        }else{
            $this->response($authorizedResponse, $authorizedResponse['statusCode']);
        }
    }
    
    public function paynow_post(){
        $inputArray = $this->post();
        $paynowResponse = $this->developerHandler->paynow($inputArray);
        $this->response($paynowResponse, $paynowResponse['statusCode']);
        
    }
    
    public function offlineBooking_post(){
        $inputArray = $this->post();
        $authorizedResponse=$this->developerHandler->isAuthorized();
        if($authorizedResponse['status'] && $authorizedResponse['response']['total']>0){
			$inputArray['noUserCheck'] = true;
            $paynowResponse = $this->developerHandler->offlineBookingApi($inputArray);
            $this->response($paynowResponse, $paynowResponse['statusCode']);
        }else{
            $this->response($authorizedResponse, $authorizedResponse['statusCode']);
        }        
    }

}

?>