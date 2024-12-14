<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/gallery_handler.php');
require_once(APPPATH . 'handlers/currency_handler.php');
require_once(APPPATH . 'handlers/timezone_handler.php');
require_once(APPPATH . 'handlers/developer_handler.php');

class Events extends REST_Controller {

    var $eventHandler;

    public function __construct() {
        parent::__construct();
        parent::_oauth_validation_check();
        $this->eventHandler = new Event_handler();
        $this->emailHandler = new Email_handler();
    }

    /*
     * Function to get the event details
     *
     * @access	public
     * @param
     *           limit - limit the number of records
     *           start - start of the records
     *           offset - -1(optional) If set to -1, all the events will be listed
     * @return	json data that contains all the event list
     */
    public function index_post() {
        $inputArray = $this->post();
        if(isset($inputArray['limit']) && $inputArray['limit'] > $this->config->item('apiLimitMaxValue')){
            $output['status'] = FALSE;
            $output["response"]["messages"][] = EVENTS_LIMIT_VALUE_EXCEEDED;
            $output['statusCode'] = STATUS_BAD_REQUEST;
            $this->response($output);
        }
        $inputArray['isStandardApiVisible'] = 1; //filtering on standard API
        $inputArray['needTimezoneName'] = 1; // Timezone to Time Zone Name
        $inputArray['disableApiVisible'] = 1; //removing isMobileVisible and isStandardVisible in response
        $eventList = $this->eventHandler->getEventList($inputArray);
        $resultArray = array('response' => $eventList['response']);
        $this->response($resultArray, $eventList['statusCode']);
    }
}
