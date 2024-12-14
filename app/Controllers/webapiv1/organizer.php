<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once (APPPATH . 'libraries/REST_Controller.php');
require_once (APPPATH . 'handlers/dashboard_handler.php');
require_once (APPPATH . 'handlers/reports_handler.php');
require_once (APPPATH . 'handlers/eventsignup_handler.php');
require_once (APPPATH . 'handlers/profile_handler.php');

class Organizer extends REST_Controller {

    var $dashboardHandler;
    var $reportsHandler;
    var $profileHandler;

    public function __construct() {
        parent::__construct();
        parent::_oauth_validation_check();
        $this->dashboardHandler = new Dashboard_handler();
        $this->reportsHandler = new Reports_handler();
        $this->profileHandler = new Profile_handler();
    }

    public function events_get() {
        $this->loginCheck();
        $inputArray = $this->get();
        $userInfoResponse = $this->profileHandler->getUserDetails();
        $inputArray['ownerId'] = $userInfoResponse['response']['userData']['id'];
        $inputArray['collaborators']= TRUE; // for collaborators events
        $eventList = $this->dashboardHandler->getOrganizerEventList($inputArray);
        $resultArray['status'] = $eventList['status'];
        if(isset($eventList['response']['message'])){
            $resultArray['response'][] = $eventList['response']['message'];
        }else{
            $resultArray['response']['eventList'] = $eventList['response'];
            $resultArray['response']['total'] = count($eventList['response']);  
        }
        $resultArray['statusCode'] = $eventList['statusCode'];
        $this->response($resultArray, $eventList['statusCode']);
    }
    
    public function attendees_get() {
        $this->loginCheck();
        ini_set('memory_limit','800M');
        ini_set('max_execution_time','180');
        $eventArray = array();
        $inputArray = $this->get();
        $userInfoResponse = $this->profileHandler->getUserDetails();
        $inputArray['userId'] = $userInfoResponse['response']['userData']['id'];

        if((!isset($inputArray['eventId']) )&& (isset($inputArray['eventSignupId']))){
            $eventArray['eventsignupId'] = $inputArray['eventSignupId'];
            $eventSignupHandler = new Eventsignup_handler();
            $eventsignupData = $eventSignupHandler->getEventSignupData($eventArray);
            if(!isset($eventsignupData['response']['eventSignupData'])){
                $this->response($eventsignupData);
            }
            $inputArray['eventId'] = $eventsignupData['response']['eventSignupData'][0]['eventid'];
        }
        $inputArray['organizerApiFilter'] = true;
        $inputArray['REPORTS_TRANSACTION_LIMIT'] = 8000;
        $inputArray['orderStatus'] = TRUE;
        $inputArray['collaborators']= TRUE; // for collaborators events
        
//        $inputArray['reportType'] = 'summary';
//        $eventAttendeedData = $this->reportsHandler->getEventAttendeesSummary($inputArray);
            
        $inputArray['reportType'] = 'detail';
        $eventAttendeedData = $this->reportsHandler->getEventAttendeesDetails($inputArray);
        $resultArray['status'] = $eventAttendeedData['status'];
        if($resultArray['status'] == true && !isset($eventAttendeedData['response']['message']) && !isset($eventAttendeedData['response']['messages'])){
            $resultArray['response']['list'] = $eventAttendeedData['response'];
            $resultArray['response']['total'] = count($eventAttendeedData['response']);
        }else{
            if(isset($eventAttendeedData['response']['messages'])){
                $resultArray['response'] = $eventAttendeedData['response']['messages'];
            }elseif(isset($eventAttendeedData['response']['message'])){
                $resultArray['response'][] = $eventAttendeedData['response']['message'];
            }
        }
        $resultArray['statusCode'] = $eventAttendeedData['statusCode'];
        $this->response($resultArray,$resultArray['statusCode']);
    }
    
    private function loginCheck() {
        $loginCheck = $this->customsession->loginCheck();
        if ($loginCheck != 1 && !$loginCheck['status']) {
            $output['status'] = FALSE;
            $output['response']['messages'][] = $loginCheck['response']['messages'][0];
            $output['statusCode'] = STATUS_INVALID_SESSION;
            $this->response($output, $output['statusCode']);
        }
    }
}
