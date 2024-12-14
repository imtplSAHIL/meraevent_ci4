<?php

/**
 * Maintaing delegate info validations related data
 *
 * @author     Shashi <shashidhar.enjapuri@qison.com>
 * @copyright  2015-2005 The PHP Group
 * @version    CVS: $Id:$
 * @since      File available since Sprint 1
 * @deprecated File deprecated in Release 2.0.0
 * @Last Modified by Shashi
 */
/*
 * Place includes, constant defines and $_GLOBAL settings here.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require (APPPATH . 'libraries/REST_Controller.php');
require (APPPATH . 'handlers/delegate_validations_handler.php');
require (APPPATH . 'handlers/configure_handler.php');
require_once(APPPATH . 'handlers/eventcustomvalidator_handler.php');

class Delegate_validations extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('common_helper');
        $this->delegateValidationsHandler = new Delegate_validations_handler();
    }

    /*
     * Function to get the Country list
     *
     * @access	public
     * @param	$inputArray contains
     * string (major - 1 or 0)
     * @return	array
     */

    public function checkPromoCode_post() {
        $postArray = $this->input->post();
        $response = $this->delegateValidationsHandler->checkPromoCode($postArray);

        $resultArray = array('response' => $response['response']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
    }
    
    public function checkPmiMemership_post(){
        $postArray = $this->input->post();
        $eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->getPmiChennaiDetails($postArray);

        $resultArray = array('response' => $response['response']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
        
    }
	
	public function checkTedX2016Email_post(){
        $postArray = $this->input->post();
        $eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->checkTedX2016Email($postArray);

        $resultArray = array('response' => $response['response'],"status" => $response['status']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
        
    }
	
	/*to add new curation value*/
	public function addCurationValue_post(){
        $inputArray = $this->input->post();
		$eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->addCurationValue($inputArray);
		
		$this->customsession->setData('curationSuccessMessage', $response['response']['messages']);
		
        $resultArray = array('response' => $response['response'], "status" => $response['status']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
        
    }
	
	/*to update curation value*/
	public function updateCurationValue_post(){
        $inputArray = $this->input->post();
		$eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->updateCurationValue($inputArray);
		
		$this->customsession->setData('curationSuccessMessage', $response['response']['messages']);
		
        $resultArray = array('response' => $response['response'], "status" => $response['status']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
        
    }
	
	/*to delete curation value*/
	public function deleteCurationValue_post(){
        $inputArray = $this->input->post();
		$eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->deleteCurationValue($inputArray);

        $resultArray = array('response' => $response['response'], "status" => $response['status']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
        
    }
	
	/*check generic curation*/
	public function checkGenericCurationValue_post(){
        $postArray = $this->input->post();
        $eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->getGenericCurationDetails($postArray);

        $resultArray = array('response' => $response['response']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
        
    }
	
	
	/*serverside checking for unique customfield values*/
	
	public function checkUniqueCfValues_post(){
        /*header('Content-type: application/json');
        $postArray = json_decode(file_get_contents('php://input'),true);
        print_r($postArray);*/
        $postArray = $this->input->post();
        $eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->checkUniqueCfValues($postArray);

        $resultArray = array('response' => $response['response'],"status" => $response['status']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
        
    }

    //validation for unique cf values on client and server side
    public function checkEventUniqueCfValues_post(){
        $postArray = $this->input->post();
        $eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->checkEventUniqueCfValues($postArray);

        $resultArray = array('response' => $response['response'],"status" => $response['status']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);
        
    }

	/*serverside checking for unique emailid & mobile number for 110906 event*/

    public function validatePincode_post(){
        $postArray = $this->input->post();
        $eventcustomvalidatorHandler = new Eventcustomvalidator_handler();
        $response = $eventcustomvalidatorHandler->validatePincode($postArray);
        $resultArray = array('response' => $response['response'],"status" => $response['status']);
        $statusCode = $response['statusCode'];
        $this->response($resultArray, $statusCode);

    }
	

}
