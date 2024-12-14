<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once (APPPATH . 'libraries/REST_Controller.php');
require_once (APPPATH . 'handlers/city_handler.php');
require_once (APPPATH . 'handlers/file_handler.php');

class City extends REST_Controller {

    public $cityHandler, $response, $fileHandler;

    public function __construct() {
        parent::__construct();
		parent::_oauth_validation_check();
        $this->cityHandler = new City_handler();
        $this->fileHandler = new File_handler();
    }

    public function index_get() {
        $inputArray = $this->get();
        $cityList = $this->cityHandler->getCityList($inputArray);
        
         if ($cityList['status'] && $cityList['response']['total'] > 0) {
            $formattedResponse = array();
            foreach ($cityList['response']['cityList'] as $arrKey => $city) {
                foreach ($city as $key => $value) {
                    switch ($key) {
                        case 'countryid':
                            $formattedResponse[$arrKey]['countryId'] = $value;
                            break;
                        case 'splcitystateid':
//                            $formattedResponse[$arrKey]['specialCityStateId'] = $value;
                            break;
                        case 'aliascityid':
//                            $formattedResponse[$arrKey]['aliasCityId'] = $value;
                            break;
                        default :$formattedResponse[$arrKey][$key] = $value;
                            break;
                    }
                }
            }
            $cityList['response']['cityList'] = $formattedResponse;
        }
        $resultArray = array('response' => $cityList['response'],'statusCode' => $cityList['statusCode']);

        $this->response($resultArray, $cityList['statusCode']);
    }

}
