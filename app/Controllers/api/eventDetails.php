<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once (APPPATH . 'libraries/REST_Controller.php');
require_once (APPPATH . 'handlers/user_handler.php');
require_once (APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');


class EventDetails extends REST_Controller {
    public $userHandler;
    var $eventsignupHandler;
    var $eventHandler;

    public function __construct() {
        parent::__construct();
        $this->userHandler = new User_handler();
        $this->eventsignupHandler = new Eventsignup_handler();
        $this->eventHandler = new Event_handler();
    }
    	 
    public function  userOTPGen_post(){
        $inputArray = $this->post();
        $response = $this->userHandler->userOTPGen($inputArray);
        $this->response($response, $response['statusCode']);
    }
	
	public function getEventDetails_get() {

        $inputArray = $this->get();
        $eid = $inputArray['eventid'];
        $token = $inputArray['token'];
        $esid = '';
        
        if($token != 'bNQ5fB8GN4')
        {
            $response['Error'] = "Access denied.";
            $response = json_encode($response, true); 
		    echo $response;exit;
        }
        
        $input = array();
        $input['eventId'] = $eid;

        $eventdata = $this->eventHandler->getEventDetails($input);
        unset($eventdata['response']['details']['eventDetails']);

        $eventdata['response']['tickets'] = $eventdata['response']['details']['tickets'];
        unset($eventdata['response']['details']['tickets']);
        $event_signups = $this->eventsignupHandler->getUserDataForApi($eid,$esid);
        $eventdata['response']['event_signups'] = $event_signups;
        
        $response = json_encode($eventdata, true); 
		echo $response;exit;
	} 
}
