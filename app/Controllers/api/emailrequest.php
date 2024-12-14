<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once (APPPATH . 'libraries/REST_Controller.php');
require_once (APPPATH . 'handlers/emailrequest_handler.php');

class Emailrequest extends REST_Controller {

    public $emailrequest_handler;

    public function __construct() {
        parent::__construct();
        $this->emailrequest_handler = new Emailrequest_handler();
    }

    public function add_get() {
        $inputArray = $this->get();
        $emailrequestResponse = $this->emailrequest_handler->add($inputArray);
        $resultArray = array('response' => $emailrequestResponse['response']);

        $this->response($resultArray, $emailrequestResponse['statusCode']);
    }

}
