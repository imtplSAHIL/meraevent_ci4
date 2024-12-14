<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Default landing page controller
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, MeraEvents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     05-08-2015
 * @Last Modified On  05-08-2015
 * @Last Modified By  Qison  Dev Team
 */
require_once(APPPATH . 'handlers/mywallet_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/profile_handler.php');
//require_once(APPPATH . 'handlers/state_handler.php');
//require_once(APPPATH . 'handlers/city_handler.php');
//require_once(APPPATH . 'handlers/alert_handler.php');
//require_once(APPPATH . 'handlers/organizerbankdetail_handler.php');
//require_once(APPPATH . 'handlers/organizer_handler.php');
//require_once(APPPATH . 'handlers/oauth_clients_handler.php');
//require_once(APPPATH . 'handlers/file_handler.php');

class Index extends CI_Controller {

    var $profileHandler;
    var $userHandler;
    var $mywalletHandler;
    var $stateHandler;
    var $cityHandler;
    var $alertHandler;
    var $organizerbankdetailHandler;
    var $organizerHandler;
	var $userId;

    public function __construct() {
		
		//$this->output->enable_profiler(TRUE);
        parent::__construct();
        $this->userHandler = new User_handler();
        $this->mywalletHandler = new MyWallet_handler();
		
        // if user not logged in redirect to home page
        $this->userId = $this->customsession->getUserId();
       if(!$this->userId){
          $redirectUrl = site_url();
          redirect($redirectUrl);
       }
	   $this->load->library('shmart/shmartwallet.php');
    }

    public function index() {
		//echo "controller";exit;
		//$this->output->enable_profiler(TRUE);
        $inputArray['userId'] = getUserId();
        
        $createWallet = $this->input->post('walletFormType');
		//print_r($this->input->post()); exit;
        if ($createWallet) {
			
			$inputArray['walletFormType'] = $this->input->post("walletFormType");
			
			if($inputArray['walletFormType'] == 'CreateWallet'){
				$walletInputArray['name_of_customer'] = $this->input->post("Name");
				$walletInputArray['mobileNo'] = $this->input->post("MobileNo");
				
				//retrieving user details
				$userInput['userId'] = $inputArray['userId'];
				$userInput['selectfields'] = array('email');
				$userData = $this->userHandler->getUserDetailsByUserId($userInput);
				//print_r($userData); exit;
				
				if($userData['status'] && $userData['statusCode'] == 200){
					$walletInputArray['email'] = $userData['response']['userData']['email'];  
				}
				
				//print_r($inputArray); exit;
				
				//updating user profile info
				$this->profileHandler = new Profile_handler();
				$profileUpdateInputArr['name'] = $walletInputArray['name_of_customer'];
				$profileUpdateInputArr['mobile'] = $walletInputArray['mobileNo'];
				$profileUpdateResponse = $this->profileHandler->updateUserProfileFromWallet($profileUpdateInputArr);
				//print_r($profileUpdateResponse); exit;
				
				
				//if profile updated succful, making API call to create wallet
				if($profileUpdateResponse['status']){
                                        $mobile = trim($walletInputArray['mobileNo']);
                                        $walletInputArray['mobileNo'] = substr($mobile, -10);
				
					$response = $this->shmartwallet->createWallet($walletInputArray);
					//print_r($walletInputArray); print_r($response); exit;
					$data['APIresponse'] = $response;
					
					if(is_array($response) && count($response) > 0){
					
						if($response['status'] == 'error'){
							if($response['error_code'] == 101 && $response['consumer_id'] > 0){
								//means, account existed already, need OTP verification
								
								//checking user record in our DB
								$walletChkUserInputArr = array("customerid"=>$response['consumer_id'],"userId"=>$inputArray['userId']);
								$walletChkUser = $this->mywalletHandler->getWalletUserDetails($walletChkUserInputArr);
								
								if($walletChkUser['status'] && $walletChkUser['statusCode'] == 200){
									//user exists at udio wallet and Meraevents, so sending OTP request to validate mobile number	 
									$status = TRUE;
								}
								elseif($response['consumer_id'] > 0){
									$checkBlockArr['customerid'] = $response['consumer_id'];
									$walletBlockChkUser = $this->mywalletHandler->checkBlockUser($checkBlockArr);
									//print_r($walletBlockChkUser); exit;
									if($walletBlockChkUser['status'] == TRUE && $walletBlockChkUser['response']['total'] > 0){
										$message = "Oops, Something went wrong, Please try again";
										$fail = true;
									}
									else{
										//user exists at udio wallet, not on Meraevents, so inserting new record
										$walletUserInput['userid'] = $inputArray['userId'];
										$walletUserInput['consumer_id'] = $response['consumer_id'];
										$walletUserInput['walletstatus'] = 'otpsent';
										$walletUserInput['status'] = 1;
										$this->mywalletHandler->insertCustomer($walletUserInput);	
									}
									
								}else{
									$message = "Oops, Something went wrong, Please try again";
									$status = FALSE;
								}
								if(!isset($fail)){
									$OTPgeneration = $this->shmartwallet->generateOtp(array("consumer_id"=>$response['consumer_id']));
								}
								
								unset($inputArray['walletFormType']);
								
								
							}else{
								$message = "Oops, Something went wrong, Please try again";
								$status = FALSE;
							}
							
							//$message = $response['message'];
							//$status = FALSE;
						}
						else{
							$walletUserInput['userid'] = $inputArray['userId'];
							$walletUserInput['consumer_id'] = $response['consumer_id'];
							$walletUserInput['walletstatus'] = 'otpsent';
							$walletUserInput['status'] = 1;
							$this->mywalletHandler->insertCustomer($walletUserInput);
							
							$OTPgeneration = $this->shmartwallet->generateOtp(array("consumer_id"=>$response['consumer_id']));
							
							//$message = WALLET_USER_CREATED_SUCC;
							//$status = TRUE;
						}
					}
				}
				
				
				//updating user info
				//updating user info
				
			}
			elseif($inputArray['walletFormType'] == 'validateOTP'){
				
				$formInputArray['otp'] = $this->input->post("otp");
				
				//retrieving user details
				$userInput['userId'] = $inputArray['userId'];
				$userData = $this->mywalletHandler->getWalletUserDetails($userInput);
				
				//print_r($userData); exit;
				
				if($userData['status'] && $userData['statusCode'] == 200){
					$walletUserDetails = $userData['response']['walletUserDetails'][0][0];
					$otpInputArr['consumer_id'] = $walletUserDetails['customerid'];
					$otpInputArr['otp'] = $formInputArray['otp'];
					$activateUserResponse = $this->shmartwallet->activateUser($otpInputArr); 
					
					//print_r($activateUserResponse); exit;
					
					if($activateUserResponse['status'] == 'error'){
						//OTP verification failed
						if($activateUserResponse['error_code'] == 103){
							//user already active at udio wallet, updating our DB
							$updateUserInput['userid'] = $inputArray['userId'];
							$updateUserInput['customerid'] = $otpInputArr['consumer_id'];
							$updateUserInput['walletstatus'] = 'success';
							$updateUserInput['status'] = 1;
							$response = $this->mywalletHandler->updateCustomer($updateUserInput);
							
							
							/*sending congrats mail*/
							require_once(APPPATH . 'handlers/email_handler.php');
							$emailHandler = new Email_handler();
							
							if($userData && $userData['status']){
								$userDetails = $userData['response']['walletUserDetails'][0][0];
								$walletCreationCongratsInput['userName'] = $userDetails['name'];
								$walletCreationCongratsInput['userEmail'] = $userDetails['email'];
							}
							
							$walletCreationCongratsInput['walletUrl'] = site_url().'mywallet';
							//echo "from hand"; print_r($walletCreationCongratsInput); exit;
								
							$emailHandler->sendWalletCreationSuccessMail($walletCreationCongratsInput);
							/*sending congrats mail*/
							
							
							$message = WALLET_USER_CREATED_SUCC;
							$status = TRUE;
						}
						elseif($activateUserResponse['error_code'] == 105){
							//seems, entered OTP is wrong
							$message = $activateUserResponse['message'];
							//echo $message; exit;
							$status = FALSE;
						}
					}
					else{
						//OTP verification successful, updating records
						$updateUserInput['userid'] = $inputArray['userId'];
						$updateUserInput['customerid'] = $otpInputArr['consumer_id'];
						$updateUserInput['walletstatus'] = 'success';
						$updateUserInput['status'] = 1;
						$response = $this->mywalletHandler->updateCustomer($updateUserInput);
						
						if($response['status']){
							$message = WALLET_USER_CREATED_SUCC;
							$status = TRUE;
							
							/*sending congrats mail*/
							require_once(APPPATH . 'handlers/email_handler.php');
							$emailHandler = new Email_handler();
							
							if($userData && $userData['status']){
								$userDetails = $userData['response']['walletUserDetails'][0][0];
								$walletCreationCongratsInput['userName'] = $userDetails['name'];
								$walletCreationCongratsInput['userEmail'] = $userDetails['email'];
							}
							
							$walletCreationCongratsInput['walletUrl'] = site_url().'mywallet';
							//echo "from hand"; print_r($walletCreationCongratsInput); exit;
								
							$emailHandler->sendWalletCreationSuccessMail($walletCreationCongratsInput);
							/*sending congrats mail*/
							
						}
						else{
							$message = "Oops, Something went wrong, Please try again";
							$status = FALSE;
							
							/*$walletUserInput['userid'] = $inputArray['userId'];
							$walletUserInput['consumer_id'] = $response['consumer_id'];
							$walletUserInput['walletstatus'] = 'otpsent';
							$userCreated = $this->mywalletHandler->insertCustomer($walletUserInput);
							
							$message = WALLET_USER_CREATED_SUCC;
							$status = TRUE;*/
						}
						
						
					}
					
					//credit the amount to wallet, if user earned any viral bonus
					$creditToUserGeneralWalletInputArr['userid'] = $inputArray['userId'];
					$creditToUserGeneralWalletInputArr['customerid'] = $walletUserDetails['customerid'];
					$creditToUserGeneralWallet = $this->mywalletHandler->creditToUserGeneralWallet($creditToUserGeneralWalletInputArr);
					
				}
			}
			
            
        }

        $data['message'] = $message;
        $data['status'] = $status;
        
        //print_r($data['walletUserDetails']);exit;
        $data['pageName'] = 'MeraWallet';
        $data['pageTitle'] = 'MeraEvents | MeraWallet';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
        	$this->config->item('js_public_path') . 'dashboard/mywallet' 
        );
        
        $data['jsTopArray'] = array(
                $this->config->item('js_public_path') . 'intlTelInput'
	);
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'intlTelInput'
	);

		
		$data['content'] = 'wallet_home_view';
		//print_r($inputArray); exit;
		$walletUserDetails = $this->mywalletHandler->getWalletUserDetails($inputArray);
		//print_r($walletUserDetails); exit;
		
		if($walletUserDetails['status']){
			$data['walletDetails'] = $walletUserDetails['response']['walletUserDetails'][0][0];
			
			if($data['walletDetails']['walletstatus'] == 'otpsent'){
				$data['userwalletstatus'] = 'otppending';
			}
			elseif($data['walletUserDetails']['walletstatus'] == 'blocked'){
				$data['userwalletstatus'] = 'userblocked';
			}
			elseif($data['walletDetails']['walletstatus'] == 'success'){
				$data['userwalletstatus'] = 'validuser';
				$data['response_url'] = site_url('mywallet/addmoneyresponse');
				
				$data['availableBalance'] = $this->getUserWalletBalance($inputArray['userId']);
				
			}
			
		}
		else{
			//retrieving user details
			$inputArray['selectfields'] = array('email','mobile','name');
			$userData = $this->userHandler->getUserDetailsByUserId($inputArray);
			
			if($userData['status'] && $userData['statusCode'] == 200){
				$data['Name'] = $userData['response']['userData']['name']; 
				$data['EmailId'] = $userData['response']['userData']['email']; 
				$data['MobileNo'] = $userData['response']['userData']['mobile']; 
			}
			
			
			$data['userwalletstatus'] = 'createwallet';
		}
		
		//print_r($data); exit;
		
		
		
        $this->load->view('templates/mywallet_template', $data);
    }
	
	
	
	public function getUserWalletBalance($userid){
		$output['balance'] = 0;
		
		$inputArray['userId'] = $userid;
        $walletUserDetails = $this->mywalletHandler->getWalletUserDetails($inputArray);
		//print_r($walletUserDetails); exit;
        if($walletUserDetails['status']){
			$walletUserDetails = $walletUserDetails['response']['walletUserDetails'][0][0];
			$balanceInputArr['customerid'] = $walletUserDetails['customerid'];
			$userWalletGeneralBalance = $this->shmartwallet->getUserWalletGeneralBalance($balanceInputArr);	
			//print_r($userWalletGeneralBalance); exit;
			
			if($userWalletGeneralBalance['status'] == 'success') {
				$output['balance'] = $userWalletGeneralBalance['balance'];
			}
		}
		
		
		return $output['balance'];
	}
	
	
	
	/*to get wallet transactions*/
	public function walletTransactions(){
        $inputArray['userId'] = getUserId();
		$inputArray['page'] = $data['page'] = 1;
        
        //print_r($inputArray); exit;
		
			
		//print_r($trsInputArr); exit;
		$wallettransactions = $this->mywalletHandler->getWalletTransactions($inputArray);	
		//print_r($wallettransactions); exit;
			
		if($wallettransactions && $wallettransactions['status'] == 'success' && is_array($wallettransactions['response']['walletTransactions'])) {
				$data['transactions'] = $wallettransactions['response']['walletTransactions'];
		}
		else{
				$data['transactions'] = array();
		}
        //print_r($data['transactions']);exit;
		
        $data['pageName'] = 'MeraWallet - Transactions';
        $data['pageTitle'] = 'MeraEvents | MeraWallet | Transactions';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
        	$this->config->item('js_public_path') . 'dashboard/mywallet' 
        );
		
		$data['content'] = 'wallet_transactions_view';
		
		//print_r($data); exit;
		
        $this->load->view('templates/mywallet_template', $data);
    }
	
	
	
	
	/*process return data from udio paymentdateways, after add fund through iframe*/
	public function processAddMoneyToWallet(){
		$return_url = NULL;
		
        $inputArray['userId'] = getUserId();
		$postVar = $this->input->post();
		$getVar = $this->input->get();
		
		//print_r($postVar); print_r($getVar); exit;
		
		/*if(isset($getVar['return_url'])){
			$return_url = site_url('mywallet');
		}*/
		$page = $getVar['page'];
		$orderid = isset($getVar['orderid'])?$getVar['orderid']:NULL;
		
		//print_r($postVar); exit;
		$status_code = 0; //initiating
		$data['status'] = $data['addedMoneyToWallet'] = FALSE;
		$data['message'] = "Oops.., Something went wrong, Please try again.";
					
					
		
		
		if($postVar){
			
			$load_amount = $postVar['load_amount'];
			$shmart_refID = $postVar['shmart_refID'];
			$merchant_refID = $postVar['merchant_refID'];
			$status_code = $postVar['status_code'];
			$checksum = $postVar['checksum'];
			
			$upWalletTrsInputArray['userid'] = $inputArray['userId'];
			$upWalletTrsInputArray['id'] = $merchant_refID;
			$upWalletTrsInputArray['paymenttransid'] = $shmart_refID;
			$upWalletTrsInputArray['response'] = serialize($postVar);
		 	
			
			
			//checking with our DB, to make this tr succ/fail
			$mercRefInputArr['id'] = $merchant_refID;
			$mercRefInputArr['userid'] = $inputArray['userId'];
			//print_r($mercRefInputArr); 
			$merchantReferenceIdDetails = $this->mywalletHandler->getMerchantReferenceIdDetails($mercRefInputArr);
			//print_r($merchantReferenceIdDetails); exit;
			
			
			if($merchantReferenceIdDetails && $merchantReferenceIdDetails['status']){
				$merchantReferenceIdData = $merchantReferenceIdDetails['response']['walletTransactionDetails'][0];
				
				//print_r($merchantReferenceIdData); exit;
				if($merchantReferenceIdData['requesttype'] == 'AFTI' && $merchantReferenceIdData['amount'] == $load_amount && $merchantReferenceIdData['status'] == 'pending' && $status_code == 1){//success from udio
					if($page == 'payment'){
						$generateOtpResp = $this->mywalletHandler->generateOtp(array("userId"=>$inputArray['userId']));
					}
					$upWalletTrsInputArray['status'] = 'success';
					$data['addedMoneyToWallet'] = true;
				}else{
					$upWalletTrsInputArray['status'] = 'fail';
				}
				

				
			}
			
		}else{ //fail
			$upWalletTrsInputArray['status'] = 'fail';
		}
		
		//print_r($$upWalletTrsInputArray); exit;
		$upMerchantReffIdData = $this->mywalletHandler->updateMerchantReferenceId($upWalletTrsInputArray);
		//print_r($upMerchantReffIdData); exit;
		
		if($upMerchantReffIdData && $upMerchantReffIdData['status']){
			if($upWalletTrsInputArray['status'] == 'success'){
				$data['status'] = TRUE;
				$data['message'] = "Money added to wallet";
			}else{
				$data['status'] = FALSE;
				$data['message'] = "Transaction incomplete, Please try again";
				if($page == 'payment'){
					$this->customsession->setData('booking_message', $data['message']);
					redirect(site_url('payment/?orderid='.$orderid));
				}
			}
		}
		
		
		if($page == 'dashboard'){
			$this->customsession->setData('addedMoneyToWalletStatus', $data);
        	redirect(site_url('mywallet'));
		}elseif($page == 'payment'){
			redirect(site_url('payment/processWalletTransaction?orderid='.$orderid));
				
		}else{
			redirect(site_url());
		}
		
		
		//return $data;
    }
    

}

?>