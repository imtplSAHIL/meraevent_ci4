<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'handlers/eventsignup_handler.php');

class Apitransactions extends CI_Controller 
{
	var $eventSignupHandler;
        
    public function __construct() {
        parent::__construct();
    }

    public function getTransactions(){
        $type = $this->uri->segments[3];
        $eventId = $this->uri->segments[4];
        $startDate = $this->uri->segments[5];
        $endDate = $this->uri->segments[6];
        $page = $this->uri->segments[7];
        $inputs['transactiontype'] = $type; 
        if(isset($eventId) && $eventId != 'all'){
           $inputs['eventid'] = $eventId;
        }
        if(isset($startDate) && $startDate != ''){
            $inputs['startdate'] = str_replace('-','/', $startDate);
        }
        if(isset($endDate) && $endDate != ''){
            $inputs['enddate'] = str_replace('-','/', $endDate);
        }
        $inputs['page'] = $page;
        $this->eventSignupHandler = new Eventsignup_handler();
        $apiTransactionsData = $this->eventSignupHandler->getThirdPartyTransactionsValidation($inputs);
        if(!$apiTransactionsData['status']){
            $statusCode = $apiTransactionsData['statusCode'];
            $resultArray = array('response' => $apiTransactionsData['response']);
            $data['formErrors'] = $resultArray['response']['messages'];      
        }else{
            $apiTransactionsInput = $apiTransactionsData['response']['formattedData']; 
            $apiTransactions = $this->eventSignupHandler->getThirdPartyTransactions($apiTransactionsInput);
        }
        
        if($inputs['eventid'] == 'all'){
            $inputs['eventid'] = '';
        }
        $data['formdata'] = $inputs;
        $headerFields = array('S. No','Receipt No','Date','Event Name / Id','Quantity','Paid');
        $data['headerFields'] = $headerFields;
        $data['searchData'] = $apiTransactions['response']['searchData'];
        $data['searchSummary'] = $apiTransactions['response']['searchSummary'];
        $data['totalTransactions'] = $apiTransactions['response']['total'];
        $data['messages'] = $apiTransactions['response']['messages'];
        $data['pageName'] = 'API Transactions';
        $data['pageTitle'] = 'MeraEvents | API Transactions';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'apitransactions_view';
        $data['cssArray'] = array(
           $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/apitransactions'
        );
        $this->load->view('templates/dashboard_template', $data);
    }
        
}