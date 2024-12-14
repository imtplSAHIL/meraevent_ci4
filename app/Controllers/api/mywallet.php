<?php

/**
 * dashboard related api's
 *
 * @author    Qison  Dev Team
 * @copyright  2015-2005 The PHP Group
 * @version    CVS: $Id:$
 * @since      Discounts available since Sprint 4
 * @deprecated File deprecated in Release 2.0.0
 */
/*
 * Place includes, constant defines and $_GLOBAL settings here.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/mywallet_handler.php');

class myWallet extends REST_Controller {

    var $mywalletHandler;

    public function __construct() {
        parent::__construct();
        $this->mywalletHandler = new MyWallet_handler();
    }

    public function getTransactions_post() {
		$userId = getUserId();
        $inputArray = $this->input->post();
		$inputArray['userId'] = $userId;
		
        $output = $this->mywalletHandler->getWalletTransactions($inputArray);
		
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }
	
	public function myWalletOtpGeneration_post() {
		$userId = getUserId();
        $inputArray = $this->input->post();
		$inputArray['userId'] = $userId;
		
        $output = $this->mywalletHandler->generateOtp($inputArray);
		
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
	}
	
	
	/*add money to wallet, get iframe url*/
	public function addMoneyToWallet_post() {
		$userId = getUserId();
        $inputArray = $this->input->post();
		//print_r($inputArray); exit;
		$inputArray['userid'] = $userId;
		
        $output = $this->mywalletHandler->addMoneyToWallet($inputArray);
		//print_r($output); exit;
		
        $responseArray = array('response' => $output['response'],'status' => $output['status']);
        $this->response($responseArray, $output['statusCode']);
	}
	
	
	/*process add money to wallet response*/
	public function processAddMoneyToWallet_post() {
		$userId = getUserId();
        $postVar = $this->input->post();
		$getVar = $this->input->get();
		//print_r($getVar); print_r($postVar); exit;
		$postVar['userid'] = $userId;
		
		if(isset($getVar['page'])){
			$postVar['page'] = $getVar['page'];
		}
		
        $output = $this->mywalletHandler->processAddMoneyToWallet($postVar);
		//print_r($output); exit;
		
        $responseArray = array('response' => $output['response'],'status' => $output['status']);
        $this->response($responseArray, $output['statusCode']);
	}
	
	/*redeem Points from user dashboard*/
	public function redeemPoints_post() {
		$userId = getUserId();
        $inputArray = $this->input->post();
		//print_r($inputArray); exit;
		$inputArray['userid'] = $userId;
		
        $output = $this->mywalletHandler->redeemPoints($inputArray);
		//print_r($output); exit;
		
        $responseArray = array('response' => $output['response'],'status' => $output['status']);
        $this->response($responseArray, $output['statusCode']);
	}
	
	

}
