<?php

/**
 * Maintaing Ticket related data
 *
 * @author    Qison  Dev Team
 * @copyright  2015-2005 The PHP Group
 * @version    CVS: $Id:$
 * @since      Tags available since Sprint 2
 * @deprecated File deprecated in Release 2.0.0
 */
/*
 * Place includes, constant defines and $_GLOBAL settings here.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/ticket_handler.php');
require_once(APPPATH . 'handlers/tickettax_handler.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/developer_handler.php');

class Ticket extends REST_Controller {

    var $ticketHandler;
    var $eventHandler;
    var $ticketTaxHandler;
    var $developerHandler;

    public function __construct() {
        parent::__construct();
		parent::_oauth_validation_check();
        $this->ticketHandler = new Ticket_handler();
        $this->ticketTaxHandler = new Tickettax_handler();
        $this->eventHandler = new Event_handler();
        $this->developerHandler = new Developer_handler();
    }

    /*
     * Function to get the Ticket list for the event
     *
     * @access	public
     * @param	taking post values that contains
     * 			eventId - integer
     * 			ticketId - integer (optional)
     * @return	json response with ticket detailed list
     */

    public function index_get() {
        $inputArray = $this->get();

        $inputArray['tncRequired'] = true;
        $eventTicketDetails = $this->eventHandler->getEventTicketDetails($inputArray);
        if ($eventTicketDetails['status'] && $eventTicketDetails['response']['total'] > 0) {
            foreach($eventTicketDetails['response']['ticketList'] as $key => $value){
               unset($eventTicketDetails['response']['ticketList'][$key]['totalSoldTickets']); 
           }
        }
        //To get all taxes of the event
        $inputArray['getall'] = 1;
        $eventTaxDetails = $this->eventHandler->extraCharge($inputArray);
        if (!empty($eventTaxDetails['statusCode']) && $eventTaxDetails['statusCode'] == STATUS_OK) {
            $eventTicketDetails['response']['eventTaxes'] = $eventTaxDetails['response'];
        }
        //To get all custom fields of the event level & ticket level
        $this->configureHandler = new Configure_handler();
        $customFieldsList = $this->configureHandler->getCustomFields($inputArray);
        $values_custom_field_ids = array();
        if (!empty($customFieldsList['response']['customFields'])) {
            foreach ($customFieldsList['response']['customFields'] as $customField) {
                if (in_array($customField['fieldtype'], array('dropdown', 'radio', 'checkbox'))) {
                    $values_custom_field_ids[] = $customField['id'];
                }
            }
            $eventTicketDetails['response']['customFields'] = $customFieldsList['response']['customFields'];
        }
        if (!empty($values_custom_field_ids)) {
            $cf_input = ['customFieldIdArray' => $values_custom_field_ids];
            $customFieldsValues = $this->configureHandler->getCustomFieldValues($cf_input);
            $eventTicketDetails['response']['customFieldValues'] = $customFieldsValues['response']['fieldValuesInArray'];
        }
        $resultArray = array('response' => $eventTicketDetails['response'], 'statusCode' => $eventTicketDetails['statusCode']);
        $this->response($resultArray, $eventTicketDetails['statusCode']);
    }
    
    public function getEventTickets_post() {
        
        $inputArray = $this->input->post();
        $ticketList = $this->ticketHandler->getEventTicketList($inputArray);
        
        foreach ($ticketList['response']['ticketList'] as $ticket) {
            if ($ticket['pastTicket'] == 1) {
                $ticket['soldout'] = 1;
            }
            $ticketListArray[] = $ticket;
        }

        $ticketList['response']['ticketList'] = $ticketListArray;
        $resultArray = array('response' => $ticketList['response']);
        $this->response($resultArray, $ticketList['statusCode']);
    }
    
    public function create_post(){
        $accessTokenInfo = $this->developerHandler->setAccessTokenInfo();
        $inputData = $this->input->post();
        $inputData['ownerId'] = $accessTokenInfo['user_id'];
        $response = $this->developerHandler->createTicket($inputData);
        $this->response($response, $response['statusCode']);
    }
    
    public function update_post(){
        $accessTokenInfo = $this->developerHandler->setAccessTokenInfo();
        $inputData = $this->input->post();
        $inputData['ownerId'] = $accessTokenInfo['user_id'];
        $response = $this->developerHandler->updateTicket($inputData);
        $this->response($response, $response['statusCode']);
    }
    
    public function taxes_get(){
        $accessTokenInfo = $this->developerHandler->setAccessTokenInfo();
        $inputData = $this->input->get();
        $inputData['ownerId'] = $accessTokenInfo['user_id'];
        $taxDetails = $this->ticketTaxHandler->getTaxesWithEventId($inputData);
        $this->response($taxDetails, $taxDetails['statusCode']);
    }
    
    public function delete_get(){
        $accessTokenInfo = $this->developerHandler->setAccessTokenInfo();
        $inputArray = $this->input->get();
        $inputArray['ownerId'] = $accessTokenInfo['user_id'];
        $deleteTicketResponse = $this->ticketHandler->deleteTicketWithEventId($inputArray);
        $this->response($deleteTicketResponse, $deleteTicketResponse['statusCode']);
    }

}
