<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/subcategory_handler.php');

class Subcategory extends REST_Controller {

    public function __construct() {
        parent::__construct();
		parent::_oauth_validation_check();
        $this->subcategoryHandler = new Subcategory_handler();
    }

    public function index_get() {
        $inputArray = $this->get();
        $subcategoryList = $this->subcategoryHandler->apiSubcategoryList($inputArray);
        $resultArray = array('response' => $subcategoryList['response'],'statusCode' => $subcategoryList['statusCode']);
        $this->response($resultArray, $subcategoryList['statusCode']);
    }

}
