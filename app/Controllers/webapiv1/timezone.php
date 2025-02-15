<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/timezone_handler.php');

class Timezone extends REST_Controller {

    public function __construct() {
        parent::__construct();
		parent::_oauth_validation_check();
    }

    public function index_get() {
        $inputArray = $this->get();
        $this->timezoneHandler = new Timezone_handler();

        $timezoneList = $this->timezoneHandler->timeZoneList($inputArray);
        $resultArray = array('response' => $timezoneList['response'], 'statusCode' => $timezoneList['statusCode']);
        $this->response($resultArray, $timezoneList['statusCode']);
    }

}
