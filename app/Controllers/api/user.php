<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once (APPPATH . 'libraries/REST_Controller.php');
require_once (APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/printpass_handler.php');
require_once(APPPATH . 'handlers/common_handler.php');

class User extends REST_Controller {
    public $userHandler;
    public function __construct() {
        parent::__construct();
        $this->userHandler = new User_handler();
        $this->commonHandler = new Common_handler();
    }
    public function login_post() {
        $inputArray = $this->input->post();
        $loginResponse = $this->userHandler->login($inputArray);
            $resultArray = array('response' => $loginResponse['response']);
            $this->response($resultArray, $loginResponse['statusCode']);
    }

    public function logout_post() {
		
		$this->loginCheck();
        $inputArray = $this->post();
        $loginResponse = $this->userHandler->logout($inputArray);
        $resultArray = array('response' => $loginResponse['response']);
        $this->response($resultArray, $loginResponse['statusCode']);
    }
    
     function resendActivationLink_post() {//user acttivation link
        $inputArray = $this->post();

        $success = $this->userHandler->resendActivationLink($inputArray);
        $resultArray = array('response' => $success['response']);
        $this->response($resultArray, $success['statusCode']);
    }

    public function signup_post(){
        
        $inputArray=$this->post();
        
        if(isset($inputArray['email']) && !empty($inputArray['email'])){

            $em=$inputArray['email'];
            $ar=split("@",$em);
            $spam_array = array('qq.com','QQ.com','139.com','976441847.com',
                                'yeah.net','qq.cpm','6885485.com','foxmail.com',
                                'sina.com','yahoo.cn','vip.qq.com','126.com',
                                'yahoo.com.cn',
                                'QQ.COM','163.com', 'tom.com');

            if (in_array($ar[1], $spam_array)) 
            {
                $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." user API controller 404 response sent Line 61 ::".date('Y/m/d H:i:s'));
                http_response_code(404);
                exit;
            }
        }

        $signupResponse=$this->userHandler->signup($inputArray);
        $resultArray = array('response' => $signupResponse['response']);
        $this->response($resultArray,$signupResponse['statusCode']);
    }
	
	//Reset password api
	public function resetPassword_post() {
        $inputArray = $this->post();
        $resetPasswordResponse = $this->userHandler->resetPassword($inputArray);
		unset($resetPasswordResponse['response']['total']);
        $resultArray = array('response' => $resetPasswordResponse['response']);
        $this->response($resultArray, $resetPasswordResponse['statusCode']);
    }
	
	//Change password api
	public function changePassword_post() {
        $inputArray = $this->post();
        $changePasswordResponse = $this->userHandler->changePassword($inputArray);
		unset($changePasswordResponse['response']['total']);
        $resultArray = array('response' => $changePasswordResponse['response']);
        $this->response($resultArray, $changePasswordResponse['statusCode']);
    }
    public function  signupEmailCheck_post(){
        $inputArray = $this->post();
        $response = $this->userHandler->signupEmailCheck($inputArray);
        $resultArray = array('response' => $response['response']);
        $this->response($resultArray, $response['statusCode']);
        
    }
    
    public function adminSession_get() {
        $inputArray = $this->get();
        $response = $this->userHandler->adminSession($inputArray);
        if(isset($inputArray['adminId'])){
            $this->customsession->setData('adminId', $inputArray['adminId']);       
        }
	if(isset($inputArray['eventid']) && $inputArray['eventid'] > 0){
            redirect(commonHelperGetPageUrl('edit-event', $inputArray['eventid']));                
        }else{
            if(!empty(getDashboardUrl())){
                redirect(getDashboardUrl()); 
            }else{
                redirect(commonHelperGetPageUrl('user-myprofile'));
            }
        }
      //  $resultArray = array('response' => $response['response']);
		//$this->response($resultArray, $response['statusCode']);
    }
	
	/*
     * Function to login the user as Guest
     *
     * @access	public
     * @param
     *      	`userEmail` - Mandatory
     * @return	starts the session with the user input
     */
	public function userGuestLogin_post() {
		
		$inputArray = $this->post();
		$response = $this->userHandler->userGuestLogin($inputArray);
        $resultArray = array('response' => $response['response']);
        $this->response($resultArray, $response['statusCode']);
	}
	
	/*
    * Function to check for logged in user
    *
    * @access	public
    * @return	json response with status and message
    */
	public function loginCheck() {
		$loginCheck = $this->customsession->loginCheck();
		if($loginCheck != 1 && !$loginCheck['status']) {
			$output['status'] = FALSE;
			$output['response']['messages'][] = $loginCheck['response']['messages'][0];
			$output['statusCode'] = STATUS_INVALID_SESSION;
			
			$resultArray = array('response' => $output['response']);
			$this->response($resultArray, $output['statusCode']);
		}
	}
        
    public function  userNameCheck_post(){
        $inputArray = $this->post();
        $response = $this->userHandler->userNameCheck($inputArray);
        $resultArray = array('response' => $response['response']);
        $this->response($resultArray, $response['statusCode']);    
    }

    public function  userOTPGen_post(){
        $inputArray = $this->post();
        $response = $this->userHandler->userOTPGen($inputArray);
        $this->response($response, $response['statusCode']);
    }

    public function  userMobileVerifyOtp_post(){
        $inputArray = $this->post();
        $response = $this->userHandler->userMobileVerifyOtp($inputArray);
        $this->response($response, $response['statusCode']);
    }
	
	public function getProfileDropdown_get() {
		$response = $this->userHandler->getProfileDropdown($inputArray);
		echo $response;exit;
	}
	public function printpass_post() {
        $inputArray = $this->post();
		$this->ci = & get_instance();
		$this->ci->form_validation->reset_form_rules();
		$this->ci->form_validation->pass_array($inputArray);
		$this->ci->form_validation->set_rules('eventsignupId', 'eventsignupId', 'is_natural_no_zero|required_strict');
		$this->ci->form_validation->set_rules('userEmail', 'userEmail', 'required_strict|valid_email');
		if ($this->ci->form_validation->run() == FALSE) {
			$response = $this->ci->form_validation->get_errors();
			$output['response']['messages'] = $response['message'];
			$statusCode = STATUS_BAD_REQUEST;
			$this->response($output,$statusCode);
		}
        $printpassHandler = new Printpass_handler();
        $eventsignupDetails = $printpassHandler->getUserEventsignup($inputArray);
		if($eventsignupDetails['statusCode']==200){
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails'][$eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['userid']]);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['userid']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['transactionticketids']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['fromcurrencyid']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['tocurrencyid']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['bookingtype']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['discount']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['discountcodeid']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['paymentmodeid']);
			
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['paymentgatewayid']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['eventextrachargeid']);
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['transactiontickettype']);
			//var_dump($eventsignupDetails['response']['eventSignupDetailData']);exit; 
			foreach($eventsignupDetails['response']['eventSignupDetailData']['attendees']['primaryAttendee'] as $key1=>$value1){
				foreach($value1 as $key=>$value){
					if(!in_array($key,$eventsignupDetails['response']['eventSignupDetailData']['displayonTicketFields'])){
						unset($eventsignupDetails['response']['eventSignupDetailData']['attendees']['primaryAttendee'][$key1][$key]);
					}
				}
			}
			foreach($eventsignupDetails['response']['eventSignupDetailData']['attendees']['otherAttendee'] as $key1=>$value1){
				foreach($value1 as $key=>$value){
					if(!in_array($key,$eventsignupDetails['response']['eventSignupDetailData']['displayonTicketFields'])){
						unset($eventsignupDetails['response']['eventSignupDetailData']['attendees']['otherAttendee'][$key1][$key]);
					}
				}
			}
			unset($eventsignupDetails['response']['eventSignupDetailData']['eventSettings']);
		}
		$resultArray = array('response' => $eventsignupDetails['response']);
        $this->response($resultArray, $eventsignupDetails['statusCode']);
    }
}
