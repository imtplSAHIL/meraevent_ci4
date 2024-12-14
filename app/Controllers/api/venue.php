<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/venue_handler.php');
require_once(APPPATH . 'handlers/solr_handler.php');

class Venue extends REST_Controller {

    var $eventHandler,$venueHandler;
    public function __construct() {
        parent::__construct();
        $this->eventHandler = new Event_handler();
        $this->venueHandler = new venue_handler();
    }
    
    public function events_post() {
        $inputArray = $this->post();
        $venueDataRes = $this->venueHandler->getVenueDetails($inputArray);
        if($venueDataRes['status'] == FALSE || $venueDataRes['response']['total'] == 0){
            $output['status'] = FALSE;
            $output['response']['message'] = ERROR_NO_DATA;
            $output['status'] = STATUS_BAD_REQUEST;
            $this->response($output, $output['status']);
        }
        $venueData = $venueDataRes['response']['venueData'];
        $VHInputs['venueName'] = $venueData['name'];
        if(isset($inputArray['page'])){
            $VHInputs['page'] = $inputArray['page'];
        }
        $VHInputs['cityId'] = $venueData['cityid'];
        $eventsDataRes = $this->venueHandler->getVenueEvents($VHInputs);
        if($eventsDataRes['status'] == FALSE || $eventsDataRes['response']['total'] == 0){
            $output['status'] = FALSE;
            $output['response']['message'] = ERROR_NO_DATA;
            $output['status'] = STATUS_BAD_REQUEST;
            $this->response($output, $output['status']);
        }
        $resultArray = array('response' => $eventsDataRes['response']);
        $this->response($resultArray, $eventsDataRes['statusCode']);
    }
	
    public function list_post() {
        $inputArray = $this->post();
        $venueDataRes = $this->venueHandler->getCityVenues($inputArray);
        if($venueDataRes['status'] == FALSE || $venueDataRes['response']['total'] == 0){
            $output['status'] = FALSE;
            $output['response']['message'] = ERROR_NO_DATA;
            $output['status'] = STATUS_BAD_REQUEST;
            $this->response($output, $output['status']);
        }
        $resultArray = array('response' => $venueDataRes['response']);
        $this->response($resultArray, $venueDataRes['statusCode']);
    }
    
}