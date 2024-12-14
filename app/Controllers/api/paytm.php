<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
require (APPPATH . 'libraries/REST_Controller.php');
require (APPPATH . 'handlers/paymentgateway_handler.php');
require (APPPATH . 'handlers/netbankingdetail_handler.php');

class Paytm extends REST_Controller {

	public function __construct() {
		parent::__construct();

		$this -> load -> helper('common_helper');
	}

	public function generateOTP_get() {
		$inputArray = $this->input->get();
		require_once(APPPATH . 'libraries/paytm/paytm_functions.php');
		//$inputArray['paymentGatewayKey']=6;
		$paymentGatewayKey = $inputArray['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
			$gatewayInput['gatewayId'] = $paymentGatewayKey;
			$paymentGatewayHandler = new Paymentgateway_handler();
			$gatewayData = $paymentGatewayHandler->getPaymentgatewayList($gatewayInput);
			if ($gatewayData['status']) {
				$gatewayArr = $gatewayData['response']['paymentgatewayList'][$paymentGatewayKey];
				if ($gatewayArr['hashkey'] != '' && $gatewayArr['merchantid'] != '') {
					$gatewayArr= $gatewayArr;
				}
			}
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
		$checkSum = "";
		$paramList = array();
		
		
		
		$paramList["PHONE"] = $inputArray['mobile'];
		$paramList["USER_TYPE"] = '00';
		$paramList["RESPONSE_TYPE"] = 'token';
		$paramList["SCOPE"] = 'paytm,txn';
		$paramList["MID"] = PAYTM_MERCHANT_MID;
		$paramList["OTP_DELIVERY_METHOD"] = 'SMS';
		//$paramList["EMAIL"] = $inputArray['email'];
		
		
		$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
		//$checkSum = str_replace("+", "%2B", $checkSum);
		$paramList["CHECKSUM"] = $checkSum;
		
		$data_string = "JsonData=".json_encode($paramList);
		//echo $data_string. "<br/><br/>";
		
		$url = PAYTM_GENERATE_OTP;
		
		
		$ch = curl_init();                    // initiate curl
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);  // tell curl you want to post something
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$output = curl_exec ($ch); // execute
		$info = curl_getinfo($ch);
		$resultArray = array('response' => $output);
		$statusCode = STATUS_OK;
		$this -> response($resultArray, $statusCode);
	}
	
	public function validateOTP_post() {
		$inputArray = $this->input->post();
		require_once(APPPATH . 'libraries/paytm/paytm_functions.php');
		//$inputArray['paymentGatewayKey']=6;
		$paymentGatewayKey = $inputArray['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
			$gatewayInput['gatewayId'] = $paymentGatewayKey;
			$paymentGatewayHandler = new Paymentgateway_handler();
			$gatewayData = $paymentGatewayHandler->getPaymentgatewayList($gatewayInput);
			if ($gatewayData['status']) {
				$gatewayArr = $gatewayData['response']['paymentgatewayList'][$paymentGatewayKey];
				if ($gatewayArr['hashkey'] != '' && $gatewayArr['merchantid'] != '') {
					$gatewayArr= $gatewayArr;
				}
			}
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
		$checkSum = "";
		$paramList = array();
		
		
		
		$paramList["STATE"] = $inputArray['state'];
		$paramList["MID"] = PAYTM_MERCHANT_MID;
		$paramList["OTP"] = $inputArray['otp'];
		
		
		//$checkSum = getChecksumFromArray($paramList,"kbzk1DSbJiV_O3p5");
		//$checkSum = str_replace("+", "%2B", $checkSum);
		//$paramList["CHECKSUM"] = $checkSum;
		
		$data_string = "JsonData=".json_encode($paramList);
		//echo $data_string. "<br/><br/>";exit;
		
		$url = PAYTM_VALIDATE_OTP;
		
		
		$ch = curl_init();                    // initiate curl
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);  // tell curl you want to post something
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$output = curl_exec ($ch); // execute
		$info = curl_getinfo($ch);
		$resultArray = array('response' => $output);
		$statusCode = STATUS_OK;
		$this -> response($resultArray, $statusCode);
	}
	public function getSavedCards_get() {
		$inputArray = $this->input->get();
		require_once(APPPATH . 'libraries/paytm/paytm_functions.php');
		//$inputArray['paymentGatewayKey']=6;
		$paymentGatewayKey = $inputArray['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
			$gatewayInput['gatewayId'] = $paymentGatewayKey;
			$paymentGatewayHandler = new Paymentgateway_handler();
			$gatewayData = $paymentGatewayHandler->getPaymentgatewayList($gatewayInput);
			if ($gatewayData['status']) {
				$gatewayArr = $gatewayData['response']['paymentgatewayList'][$paymentGatewayKey];
				if ($gatewayArr['hashkey'] != '' && $gatewayArr['merchantid'] != '') {
					$gatewayArr= $gatewayArr;
				}
			}
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
		$checkSum = "";
		$paramList = array();
		
		
		
		$paramList["SSOToken"] = $inputArray['paytmtoken'];
		
		
		//$checkSum = getChecksumFromArray($paramList,"kbzk1DSbJiV_O3p5");
		//$checkSum = str_replace("+", "%2B", $checkSum);
		//$paramList["CHECKSUM"] = $checkSum;
		
		$data_string = "JsonData=".json_encode($paramList);
		//echo $data_string. "<br/><br/>";
		
		$url = PAYTM_SAVED_CARDS;
		
		
		$ch = curl_init();                    // initiate curl
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);  // tell curl you want to post something
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		
		//{"STATUS":"SUCCESS","SIZE":1,"BIN_DETAILS":[{"SAVE_CARD_ID":"489","CARDBIN":"437551","CARDLASTDIGIT":"1006","PAYMENTMODE":"CC","CARD_TYPE":"VISA","BANK_NAME":"ICICI"}]}
		$output = curl_exec ($ch); // execute
		//$info = curl_getinfo($ch);
		//echo $output;
		/*$cards = "";
		$card = json_decode($output,true);
		if($card["STATUS"] == "SUCCESS" ){
			foreach($card["BIN_DETAILS"] as $val){
				$cardNo = substr($val["CARDBIN"],0,4)."-xxxx-xxxx-".$val["CARDLASTDIGIT"];
				$cardType = $val["CARD_TYPE"];
				if($val["PAYMENTMODE"] == "CC"){
					$mode = "Credit Card";
				}else{
					$mode = "Debit Card";
				}
				$cardId = $val["SAVE_CARD_ID"];
				$cards .= "<table align='center' style='border: 3px solid rgb(0, 186, 242); font-size: 18px; padding: 10px 25px; width: 300px; border-radius: 15px;'>
							<tr><td><input style='width: 10%; float: left;' type='radio' name='walletCard' id='walletCard".$cardId."' value='".$cardId."'><div style='float: left;margin-top:10px;' >&nbsp;&nbsp;".$mode."</div></td></tr>
							<tr><td>&nbsp;&nbsp;&nbsp;".$cardNo."&nbsp;&nbsp;&nbsp;".$cardType."</td></tr>
							<tr><td align='right'>CVV &nbsp;&nbsp;&nbsp;<input type='text' id='walletCvv[".$cardId."]' name='walletCvv[".$cardId."]' size='3' style='width:40px;'>&nbsp;&nbsp;&nbsp;</td></tr>
						</table><br/>";
			}
		}
		echo $cards;*/
		$resultArray = array('response' => $output);
		$statusCode = STATUS_OK;
		$this -> response($resultArray, $statusCode);
	}
	public function getBalance_get() {
		$inputArray = $this->input->get();
		require_once(APPPATH . 'libraries/paytm/paytm_functions.php');
		//$inputArray['paymentGatewayKey']=6;
		$paymentGatewayKey = $inputArray['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
			$gatewayInput['gatewayId'] = $paymentGatewayKey;
			$paymentGatewayHandler = new Paymentgateway_handler();
			$gatewayData = $paymentGatewayHandler->getPaymentgatewayList($gatewayInput);
			if ($gatewayData['status']) {
				$gatewayArr = $gatewayData['response']['paymentgatewayList'][$paymentGatewayKey];
				if ($gatewayArr['hashkey'] != '' && $gatewayArr['merchantid'] != '') {
					$gatewayArr= $gatewayArr;
				}
			}
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
		$data_string = "";

		$url = PAYTM_GET_BALANCE;
		
		
		$ch = curl_init();                    // initiate curl
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);  // tell curl you want to post something
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','SSOToken:'.$inputArray['paytmtoken']));
		$output = curl_exec ($ch); // execute
		//$info = curl_getinfo($ch);
		$resultArray = array('response' => $output);
		$statusCode = STATUS_OK;
		$this -> response($resultArray, $statusCode);
	}
	public function getNetBankingList_get(){
		$inputArray=$this->input->get();
		$netbankingdetail_handler=new Netbankingdetail_handler();
		$inputNBList['gateway']='paytm';
		$NBListResponse=$netbankingdetail_handler->get($inputNBList);		
		$resultArray = array('response' => $NBListResponse['response']);
		$statusCode = $NBListResponse['statusCode'];
		$this->response($resultArray, $statusCode);
	}
}