<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/currency_handler.php');

class Currency extends REST_Controller {

    public function __construct() {
        parent::__construct();
		parent::_oauth_validation_check();
    }

    public function index_get() {
        $inputArray = $this->get();
        $this->currencyHandler = new Currency_handler();

        $currencyList = $this->currencyHandler->getCurrencyList($inputArray);
        $resultArray = array('response' => $currencyList['response'], 'statusCode' => $currencyList['statusCode']);
        $this->response($resultArray, $currencyList['statusCode']);
    }

}
