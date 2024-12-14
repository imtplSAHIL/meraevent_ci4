<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Default landing page controller
 *
 * @package     CodeIgniter
 * @author      Qison  Dev Team
 * @copyright   Copyright (c) 2015, MeraEvents.
 * @Version     Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     31-07-2015
 * @Last Modified On  31-07-2015
 * @Last Modified By  Qison  Dev Team
 */
require_once(APPPATH . 'handlers/ticket_handler.php');
require_once (APPPATH . 'handlers/currency_handler.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/promoter_handler.php');
require_once(APPPATH . 'handlers/discount_handler.php');
require_once(APPPATH . 'handlers/timezone_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once (APPPATH . 'handlers/guestlistbooking_handler.php');
require_once (APPPATH . 'handlers/offlinepromoterticketmapping_handler.php');
require_once (APPPATH . 'handlers/offlinepromoterdiscounts_handler.php');
require_once (APPPATH . 'handlers/pastattviraltickets_handler.php');
require_once (APPPATH . 'handlers/affiliatecustomcommission_handler.php');
require_once (APPPATH . 'handlers/promoterticketsale_handler.php');
require_once (APPPATH . 'handlers/affiliateresouce_handler.php');
require_once (APPPATH . 'handlers/eventfbpagemapping_handler.php');
require_once (APPPATH . 'handlers/profile_handler.php');

class Promote extends CI_Controller {

    var $eventHandler;
    var $ticketHandler;
    var $userHandler;
    var $promoterHandler;
    var $guestlistbookingHandler;
    var $affiliatecustomcommissionHandler;
    var $promoterticketsaleHandler;

    public function __construct() {
        parent::__construct();
        $this->promoterHandler = new Promoter_handler();
        $this->ticketHandler = new Ticket_handler();
        $this->currencyHandler = new Currency_handler();
        $this->eventHandler = new Event_handler();
        $this->discountHandler = new Discount_handler();
        $this->userHandler = new User_handler();
        $this->fileHandler = new File_handler();

        $this->eventsignupHandler = new Eventsignup_handler();
        $this->guestlistbookingHandler = new Guestlistbooking_handler();
        $this->offlinepromoterticketmappingHandler = new Offlinepromoterticketmapping_handler();
        $this->offlinepromoterdiscountsHandler = new Offlinepromoterdiscounts_handler();
        $this->affiliatecustomcommissionHandler = new Affiliatecustomcommission_handler();
        $this->promoterticketsaleHandler = new Promoterticketsale_handler();
        $_GET['eventId'] = $this->uri->segment(4);
    }

    public function viralTicket($eventId) {
        $inputArray['eventId'] = $eventId;
        $data = array();
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['eventId'] = $eventId;
        $inputArray['addonTicket'] = TRUE;
        $eventTicketDetails = $this->ticketHandler->getTickets($inputArray);
        $data['ticketData'] = $eventTicketDetails['response']['viralTicketData'];
        if ($eventTicketDetails['status'] == TRUE) {
            $update = $this->input->post('viralTicketSubmit');
            if ($update) {
                foreach ($eventTicketDetails['response']['viralTicketData'] as $key => $val) {
                    $tktId = $val['id'];
                    $eventId = $val['eventId'];
                    $viral['ticketId'] = $tktId;
                    $viral['eventId'] = $eventId;
                    $type = $this->input->post('type' . $tktId);
                    $status = $this->input->post('status' . $tktId);
                    if ($type) {
                        $viral['type'] = ($type == 'flat') ? 1 : 2;
                    } else {
                        $viral['type'] = ($val['type'] == 'flat') ? 1 : 2;
                    }
                    $viral['status'] = ($status == 1) ? 1 : 0;
                    $viral['salesDone'] = $this->input->post('salesDone' . $tktId);
                    $viral['referrercommission'] = $this->input->post('referrercommission' . $tktId);
                    $viral['receivercommission'] = $this->input->post('receivercommission' . $tktId);
                    $viralData[] = $viral;
                }
                $viralInfo = $viralData;
                $updateViralTicket = $this->ticketHandler->updateViralTicket($viralData);
                if ($updateViralTicket['status'] == TRUE) {
                    $data['messages'] = $updateViralTicket['response']['messages'][0];
                    $eventTicketDetails = $this->ticketHandler->getTickets($inputArray);
                    $data['ticketData'] = $eventTicketDetails['response']['viralTicketData'];
                    $this->customsession->setData('viralTicketSuccessMessage', SUCCESS_VIRAL_TICKET_SAVED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-eventhome', $eventId);
                    redirect($redirectUrl);
                } else {
                    $data['messages'] = $updateViralTicket['response']['messages']['0'];
                }
            }
        } else {
            $data['messages'] = $eventTicketDetails['response']['messages']['0'];
        }

        $data['hideLeftMenu'] = 0;
        $data['content'] = 'viral_ticket_view';
        $data['pageName'] = 'Viral Ticket';
        $data['pageTitle'] = 'MeraEvents | Viral Ticketing';
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote',);
        $this->load->view('templates/dashboard_template', $data);
    }

    /*
     * Setting the viral discounts for past attendees
     */

    public function pastAttViralTicket($eventId) {
        $inputArray['eventId'] = $eventId;
        $data = array();
        $this->pastattviraltickets_handler = new pastAttViraltickets_handler();
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['eventId'] = $eventId;
        $inputArray['addonTicket'] = TRUE;
        $eventTicketDetails = $this->pastattviraltickets_handler->getTickets($inputArray);
        //echo '<pre>';print_r($eventTicketDetails);exit;
        $data['ticketData'] = $eventTicketDetails['response']['viralTicketData'];
        if ($eventTicketDetails['status'] == TRUE) {
            $update = $this->input->post('viralTicketSubmit');
            $past_att_send_mails = $this->input->post('past_att_send_mails');
            if ($update) {
                foreach ($eventTicketDetails['response']['viralTicketData'] as $key => $val) {
                    $tktId = $val['id'];
                    $eventId = $val['eventId'];
                    $viral['ticketId'] = $tktId;
                    $viral['eventId'] = $eventId;
                    $type = $this->input->post('type' . $tktId);
                    $status = $this->input->post('status' . $tktId);
                    if ($type) {
                        $viral['type'] = ($type == 'flat') ? 1 : 2;
                    } else {
                        $viral['type'] = ($val['type'] == 'flat') ? 1 : 2;
                    }
                    $viral['status'] = ($status == 1) ? 1 : 0;
                    $viral['salesDone'] = $this->input->post('salesDone' . $tktId);
                    $viral['referrercommission'] = $this->input->post('referrercommission' . $tktId);
                    $viral['receivercommission'] = $this->input->post('receivercommission' . $tktId);
                    $viralData[] = $viral;
                }
                //echo 'krishna';exit;
                $viralInfo = $viralData;
                $updateViralTicket = $this->pastattviraltickets_handler->updatePastAttViralTicket($viralData);
                if ($updateViralTicket['status'] == TRUE) {
                    $data['messages'] = $updateViralTicket['response']['messages'][0];
                    $eventTicketDetails = $this->pastattviraltickets_handler->getTickets($inputArray);
                    $data['ticketData'] = $eventTicketDetails['response']['viralTicketData'];
                    $this->customsession->setData('viralTicketSuccessMessage', SUCCESS_VIRAL_TICKET_SAVED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-eventhome', $eventId);
                    //redirect($redirectUrl);
                } else {
                    $data['messages'] = $updateViralTicket['response']['messages']['0'];
                }
            }
        } else {
            $data['messages'] = $eventTicketDetails['response']['messages']['0'];
        }
		require_once (APPPATH . 'handlers/emailrequest_handler.php');
		$emailrequest_handler=new Emailrequest_handler();
		$inputPending['eventId']=$eventId;
		$isEmailPendingResponse=$emailrequest_handler->isEmailPending($inputPending);
		$data['showSendEmail']=true;
		if($isEmailPendingResponse['status']){
			$data['showSendEmail']=$isEmailPendingResponse['response']['isEmailPending'];
		}
        $data['userId'] = getUserId();
        //echo 'krishna';print_r($eventTicketDetails);exit;
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'past_att_viral_ticket_view';
        $data['pageName'] = 'Viral Ticket';
        $data['pageTitle'] = 'MeraEvents | Viral Ticketing';
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote',);
        $this->load->view('templates/dashboard_template', $data);
    }

    
    public function bulkUploadDiscounts($eventId, $id = '') {
        
        $this->eventHandler = new Event_handler();
        $this->timezoneHandler = new Timezone_handler();
        $inputArray['eventId'] = $eventId;
        $data['output'] = array();
        //For displaying dates for multievent
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        
        //==== If form is submitted ====//
        if(!empty($_POST))
        {
            if(empty($_FILES['csvfile']))
            {
                $data['status_message'] = "Please upload the csv file.";
            }

            $discounts_data = $this->fileHandler->uploadBulkDiscountsFile($eventId);
            foreach($discounts_data['response']['discounts_data'] as $current_row)
            {
                $this->discountHandler = new Discount_handler();

                $is_inserted = $this->discountHandler->insertDiscount($current_row, $_POST['ticketIds']);
            }
   
            $data['status_message'] = 'All Discounts Uploaded Successfully.';
        }

        if($eventDetails['response']['details']['masterevent'] == TRUE){
            $data['masterEvent'] = TRUE; 
            $childEventsRes = $this->eventHandler->getMultiEventsDatesSolr(array('masterEventId' => $eventId));
            if($childEventsRes['status'] == TRUE && count($childEventsRes['response']['eventList']) > 0){
                $data['childEvents'] = $childEventsRes['response']['eventList'];
                 $childEvents = array_column($data['childEvents'], 'id');
            }
        }else{
            $data['masterEvent'] = FALSE;
        }

        $timeZoneName = "";
        if ($eventDetails) {
            $data['eventName'] = $eventDetails['response']['details']['title'];
            $data['eventEndDate'] = $eventDetails['response']['details']['endDate'];
            $timeZoneData['timezoneId'] = $eventDetails['response']['details']['timeZoneId'];
            $timeZoneDetails = $this->timezoneHandler->details($timeZoneData);
            if ($timeZoneDetails['status']) {
                $timeZoneName = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['name'];
            }
        }
        $data['eventTimeZoneName'] = $timeZoneName;
        $ticketsDetails = $this->ticketHandler->getTicketName($inputArray);
        if ($ticketsDetails['status']) {
            $data['ticketDetails'] = $ticketsDetails;
        } else {
            $data['ticketDetails'] = array();
        }
        $currencyListResponse = $this->currencyHandler->getCurrencyList();
        $data['currencyList'] = $this->getCurrencyListArray($currencyListResponse['response']['currencyList']);
        
        $data['content'] = 'bulk_upload_discount_view';
        $data['pageName'] = 'Bulk Upload Discounts';
        $data['pageTitle'] = 'MeraEvents | Bulk Discount Discounts';
        $data['hideLeftMenu'] = 0;
        $data['eventId'] = $eventId;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'bootstrap',
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'bootstrap-timepicker',
            $this->config->item('js_public_path') . 'dashboard/discount');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'dashboard-timepicker',
            $this->config->item('css_public_path') . 'bootstrap',
            $this->config->item('css_public_path') . 'jquery-ui');
        //    print_r($data);exit;
        $this->load->view('templates/dashboard_template', $data);
    }

    public function addDiscount($eventId, $id = '') {
        $this->eventHandler = new Event_handler();
        $this->timezoneHandler = new Timezone_handler();
        $inputArray['eventId'] = $eventId;
        $data['output'] = array();
        //For displaying dates for multievent
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        if($eventDetails['response']['details']['masterevent'] == TRUE){
            $data['masterEvent'] = TRUE; 
            $childEventsRes = $this->eventHandler->getMultiEventsDatesSolr(array('masterEventId' => $eventId));
            if($childEventsRes['status'] == TRUE && count($childEventsRes['response']['eventList']) > 0){
                $data['childEvents'] = $childEventsRes['response']['eventList'];
                 $childEvents = array_column($data['childEvents'], 'id');
            }   
       
        }else{
            $data['masterEvent'] = FALSE;
        }
        $timeZoneName = "";
        if ($eventDetails) {
            $data['eventName'] = $eventDetails['response']['details']['title'];
            $data['eventEndDate'] = $eventDetails['response']['details']['endDate'];
            $timeZoneData['timezoneId'] = $eventDetails['response']['details']['timeZoneId'];
            $timeZoneDetails = $this->timezoneHandler->details($timeZoneData);
            if ($timeZoneDetails['status']) {
                $timeZoneName = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['name'];
            }
        }
        $data['eventTimeZoneName'] = $timeZoneName;
        $ticketsDetails = $this->ticketHandler->getTicketName($inputArray);
        if ($ticketsDetails['status']) {
            $data['ticketDetails'] = $ticketsDetails;
        } else {
            $data['ticketDetails'] = array();
        }
        $currencyListResponse = $this->currencyHandler->getCurrencyList();
        $data['currencyList'] = $this->getCurrencyListArray($currencyListResponse['response']['currencyList']);
        
        //For editing the discount details
        if (!empty($id)) {
            $inputs['eventId'] = $eventId;
            $inputs['id'] = $id;
            $inputs['type'] = 'normal';
            if($data['masterEvent'] == TRUE){
                $inputs['types'] = array('normal','masterDiscount'); 
            }
            $discountDetails = $this->discountHandler->getDiscountList($inputs);
            $data['discountDetails'] = $discountDetails;
            if ($discountDetails) {
                //Getting discountId     
                $discountId = $discountDetails['response']['discountList'][0]['id'];

                //Getting all ticket ids related to the discount code you want to edit           
                $this->ticketDiscountHandler = new Ticketdiscount_handler();
                $ticketDiscountData = $this->ticketDiscountHandler->getTicketDiscountData($discountId);
                $ticketDiscountData = $ticketDiscountData['response']['ticketDiscountList'];
                $selectedTicketIdList = $ticketIdList = array();
                foreach ($ticketDiscountData as $key => $value) {
                    $ticketIdList[] = $value['ticketid'];
                    if ($value['status'] == 1) {
                        $selectedTicketIdList[] = $value['ticketid'];
                    }
                }
                //Selected ticket list for multievent
                if($data['masterEvent'] == TRUE && $discountDetails['response']['discountList'][0]['eventid'] != $eventId){
                    $selectedMasterTicketIdsRes = $this->ticketHandler->getParentTicketIds(array('childTicketIds' => $selectedTicketIdList, 'childEventId' => $discountDetails['response']['discountList'][0]['eventid']));
                    if($selectedMasterTicketIdsRes['status'] == TRUE){
                        $selectedTicketIdList = $selectedMasterTicketIdsRes['response']['ticketIds'];
                    }
                }
                $data['ticketIdList'] = $selectedTicketIdList;
                $discountData = $this->input->post('discountSubmit');
                if ($discountData) {
                    //For editing
                    $inputArray = $this->input->post(); //Storing all the input form values in the inputArray
                    if($data['masterEvent'] == TRUE){
                        $inputArray['discountLevel'] = $discountDetails['response']['discountList'][0]['eventid'];
                    }
                    //discount for a single event
                    if(!isset($inputArray['discountLevel']) || $eventId != $inputArray['discountLevel']){
                        $inputArray['eventId'] = $eventId;
                        $inputArray['eventTimeZoneName'] = $timeZoneName;
                        $inputArray['type'] = 'normal';
                        $inputArray['id'] = $id;
                        $inputArray['dbTicketIdList'] = $ticketIdList;
                        $inputArray['discountValue'] = isset($inputArray['discountValue']) ? $inputArray['discountValue'] : $discountDetails['response']['discountList'][0]['value'];
                        $inputArray['amountType'] = isset($inputArray['amountType']) ? $inputArray['amountType'] : $discountDetails['response']['discountList'][0]['calculationmode'];
                        if(isset($inputArray['discountLevel']) && in_array($inputArray['discountLevel'], $childEvents)){
                            $inputArray['eventId'] = $inputArray['discountLevel'];
                            $childTicketIdRes = $this->ticketHandler->getChildTicketIds(array('parentTicketIds' => $inputArray['ticketIds'],'childEventId' => $inputArray['eventId']));
                            if($childTicketIdRes['status'] == TRUE){
                                $inputArray['ticketIds'] = $childTicketIdRes['response']['ticketIds'];
                            }
                            
                        }
                        $discountData = $this->discountHandler->update($inputArray);
                        $solrHandler = new Solr_handler();
                        $solrInput = array();
                        $solrInput['id'] = $eventId;
                        $solrInput['booknowbuttonvalue'] = 'Register Now';
                        $solrInput['mts'] = date("Y-m-d\TH:i:s\Z");
                        $solrHandler->solrUpdateEvent($solrInput);
                        if ($discountData['status']) {
                            $this->customsession->setData('discountFlashMessage', SUCCESS_UPDATED);
                            if($data['masterEvent'] == TRUE){
                                $redirectUrl = commonHelperGetPageUrl('dashboard-list-discount', $inputs['eventId']);
                            }else{
                                $redirectUrl = commonHelperGetPageUrl('dashboard-list-discount', $eventId);
                            }
                            redirect($redirectUrl);
                        } else {
                            $data['addDiscountOutput'] = $discountData;
                        }
                    }else{
                        //editing discount for all events (masterDiscount) or non multievent
                        if($data['masterEvent'] == TRUE){
                            $eventId = $discountDetails['response']['discountList'][0]['eventid'];
                        }
                        $inputArray['eventId'] = $eventId;
                        $inputArray['eventTimeZoneName'] = $timeZoneName;
                        if(!isset($inputArray['discountLevel'])){
                           $inputArray['type'] = 'normal';
                        }else{
                            $inputArray['type'] = 'masterDiscount';
                            $ticketHandler = new Ticket_handler();
                            $METickets['parentTicketIds'] = $inputArray['ticketIds'];
                            $METickets['eventId'] = $inputArray['eventId'];
                            $METicketidsRes = $ticketHandler->getMultiEventTicketIds($METickets);
                            if($METicketidsRes['status'] == TRUE && $METicketidsRes['response']['total'] > 0){
                                $ticketids = array_column($METicketidsRes['response']['eventList'], 'ticketId');
                                $ticketids = array_merge($inputArray['ticketIds'], $ticketids);
                                $inputArray['ticketIds'] = $ticketids;
                            }
                        }
                        $inputArray['id'] = $id;
                        $inputArray['dbTicketIdList'] = $ticketIdList;
                        $inputArray['discountValue'] = isset($inputArray['discountValue']) ? $inputArray['discountValue'] : $discountDetails['response']['discountList'][0]['value'];
                        $inputArray['amountType'] = isset($inputArray['amountType']) ? $inputArray['amountType'] : $discountDetails['response']['discountList'][0]['calculationmode'];
                        $discountData = $this->discountHandler->update($inputArray);
                        $solrHandler = new Solr_handler();
                        $solrInput = array();
                        $solrInput['id'] = $eventId;
                        $solrInput['booknowbuttonvalue'] = 'Register Now';
                        $solrInput['mts'] = date("Y-m-d\TH:i:s\Z");
                        $solrHandler->solrUpdateEvent($solrInput);
                        if ($discountData['status']) {
                            $this->customsession->setData('discountFlashMessage', SUCCESS_UPDATED);
                            if($data['masterEvent'] == TRUE){
                                $redirectUrl = commonHelperGetPageUrl('dashboard-list-discount', $inputs['eventId']);
                            }else{
                                $redirectUrl = commonHelperGetPageUrl('dashboard-list-discount', $eventId);
                            }
                            redirect($redirectUrl);
                        } else {
                            $data['addDiscountOutput'] = $discountData;
                        }
                    }
                }
            }
        } else {
            //For adding the discount
            $discountData = $this->input->post('discountSubmit');
            if ($discountData) {
                
                $inputArray = $this->input->post(); //Storing all the input form values in the inputArray
                $validDiscountCode = TRUE;
                if(preg_match("/\s/",$inputArray['discountCode'])){
                    $output['status'] = FALSE;
                    $output['response']['messages'][] = ERROR_INVALID_DISCOUNT_CODE;
                    $output['statusCode'] = STATUS_BAD_REQUEST;
                    $data['addDiscountOutput'] = $output;
                    $validDiscountCode = FALSE;
                }
                if($validDiscountCode == TRUE){
                    if(!isset($inputArray['discountLevel']) || $eventId != $inputArray['discountLevel']){
                        $inputArray['eventTimeZoneName'] = $timeZoneName;
                        $inputArray['eventId'] = $eventId;
                        $inputArray['type'] = 'normal';
                        if(isset($inputArray['discountLevel']) && in_array($inputArray['discountLevel'], $childEvents)){
                            $inputArray['eventId'] = $inputArray['discountLevel'];
                            $childTicketIdRes = $this->ticketHandler->getChildTicketIds(array('parentTicketIds' => $inputArray['ticketIds'],'childEventId' => $inputArray['eventId']));
                            if($childTicketIdRes['status'] == TRUE){
                                $inputArray['ticketIds'] = $childTicketIdRes['response']['ticketIds'];
                            }
                        }
                        $discountData = $this->discountHandler->add($inputArray);
                        $solrHandler = new Solr_handler();
                        $solrInput = array();
                        $solrInput['id'] = $eventId;
                        $solrInput['booknowbuttonvalue'] = 'Register Now';
                        $solrInput['mts'] = date("Y-m-d\TH:i:s\Z");
                        $solrHandler->solrUpdateEvent($solrInput);
                        if (!$discountData['status']) {
                            $data['addDiscountOutput'] = $discountData;
                        } else {
                            $this->customsession->setData('discountFlashMessage', SUCCESS_DISCOUNT_ADDED);
                            $redirectUrl = commonHelperGetPageUrl('dashboard-list-discount', $eventId);
                            redirect($redirectUrl);
                        }
                    }else{
                        //adding discount for all events (masterDiscount) or non multievent
                        $inputArray['eventTimeZoneName'] = $timeZoneName;
                        $inputArray['eventId'] = $eventId;
                        if(!isset($inputArray['discountLevel'])){
                           $inputArray['type'] = 'normal';
                        }else{
                            $inputArray['type'] = 'masterDiscount';
                        }
                        $discountData = $this->discountHandler->add($inputArray);
                        if (!$discountData['status']) {
                            $data['addDiscountOutput'] = $discountData;
                        } else {
                            $this->customsession->setData('discountFlashMessage', SUCCESS_DISCOUNT_ADDED);
                            $redirectUrl = commonHelperGetPageUrl('dashboard-list-discount', $eventId);
                            redirect($redirectUrl);
                        }
                    }
                }
            }
        }
        $data['content'] = 'add_discount_view';
        $data['pageName'] = 'Add/Edit Discount';
        $data['pageTitle'] = 'MeraEvents | Add/Edit Discount';
        $data['hideLeftMenu'] = 0;
        $data['eventId'] = $eventId;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'bootstrap',
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'bootstrap-timepicker',
            $this->config->item('js_public_path') . 'dashboard/discount');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'dashboard-timepicker',
            $this->config->item('css_public_path') . 'bootstrap',
            $this->config->item('css_public_path') . 'jquery-ui');
        $this->load->view('templates/dashboard_template', $data);
    }

    function getCurrencyListArray($currencyList)
    {
        $list_array = array();
        foreach($currencyList as $row)
        {
            $list_array[$row['currencyId']] = $row;
        }
        return $list_array;
    }

    public function addPromoter($eventId, $id = '') {
        $this->eventHandler = new Event_handler();
        $inputArray['eventId'] = $eventId;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        $eventUrl = $eventDetails['response']['details']['eventUrl'];
        if ($eventDetails) {
            $data['eventId'] = $eventDetails['response']['details']['id'];
            $data['eventName'] = $eventDetails['response']['details']['title'];
        }
        
        // global commission
        $globalaffiliateCustomCommition=0;
        $organizerid= $this->customsession->getUserId();
        $comissionInput['userid']=$organizerid;
        $affiliateCustomCommition=$this->affiliatecustomcommissionHandler->getAffiliateGlobalCustomCommission($comissionInput); 
        if($affiliateCustomCommition['status'] && $affiliateCustomCommition['response']['total'] > 0){
           $globalaffiliateCustomCommition=$affiliateCustomCommition['response']['affiliateCustomCommition'][0]['affiliateglobalcommission'];
        }
        $data['affiliateCustomCommition']=$globalaffiliateCustomCommition;
        if ($this->input->post('submit')) {
            $inputArray['name'] = $this->input->post('promoterName');
            $inputArray['email'] = $this->input->post('promoterEmail');
            $inputArray['code'] = $this->input->post('promoterCode');
            $inputArray['orgpromoteurl'] = $this->input->post('orgPromoteURL');
            $inputArray['type'] = 'affliate';
            $inputArray['templateType'] = TYPE_PROMOTER_INVITE;
            $inputArray['templateMode'] = 'email';
            $inputArray['commission']=$this->input->post('commission');
            $inputArray['organizerid']=$organizerid;
            $output = $this->promoterHandler->insertPromoter($inputArray, $eventDetails);
            if ($output['status']) {
                $this->customsession->setData('promoterSuccessAdded', SUCCESS_ADDED_PROMOTER);
                redirect(commonHelperGetPageUrl('dashboard-affliate', $eventId));
            } else {
                $data['output'] = $output['response']['messages'][0];
            }
        }

        $data['iframeURL'] = commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $inputArray['eventId']);
        if (!empty($id)) {
            $inputPromoter['promoterid'] = $id;
            $inputPromoter['eventid'] = $eventId;
            $promoterExistsResponse = $this->promoterHandler->isPromoterForEvent($inputPromoter);
            if (!$promoterExistsResponse['status']) {
                $data['output'] = $promoterExistsResponse['response']['messages'][0];
            } elseif ($promoterExistsResponse['response']['total'] == 0) {
                $data['errors'][] = 'THE URL YOU ENTERED SEEMS TO BE INCORRECT';
                //$this->load->view('templates/dashboard_template', $data);
            } else {
                $promoterData = $promoterExistsResponse['response']['promoterResponse'];
                $data['code'] = $promoterData[0]['code'];
                $data['name'] = $promoterData[0]['name'];
                $data['userid'] = $promoterData[0]['userid'];
                $promoterEmailId = $this->userHandler->getUserEmailIdByUserId($data['userid']);
                $data['email'] = $promoterEmailId['response']['userData']['email'];

                $data['promoterEventURL'] = $eventUrl . '?ucode=' . $promoterData[0]['code'];
                if (strlen(trim($promoterData[0]['orgpromoteurl'])) > 0) {
                    $URLSeperater = '?';
                    if (strpos($promoterData[0]['orgpromoteurl'], "?") !== false) {
                        $URLSeperater = '&';
                    }
                    $data['promoterEventURL'] = $promoterData[0]['orgpromoteurl'] . $URLSeperater . 'meprcode=' . $promoterData[0]['code'] . "\n(or)\n" . $eventUrl . '?ucode=' . $promoterData[0]['code'];
                }
                $data['iframeURL'] .= '&ucode=' . $promoterData[0]['code'];
            }
            
        $affiliateCommissionArray['eventid']=$eventId;
        $affiliateCommissionArray['promoterid']=$id;
        $affiliateCommissionArray['type']='eventattendee';
        $affiliateCommission=$this->affiliatecustomcommissionHandler->getAffiliateCustomCommission($affiliateCommissionArray);
        $data['promoterEventCommission']=$affiliateCommission['response']['affiliateCustomCommition'][0]['commission'];
        
        }
        $data['promoterId'] = $id;
        $data['eventUrl'] = $eventUrl;
        $data['content'] = 'add_promoter_view';
        $data['pageName'] = 'Add Promoter';
        $data['pageTitle'] = 'MeraEvents | Add Promoters';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function affiliate($eventId) {
        $organizerid= $this->customsession->getUserId();
        $this->eventHandler = new Event_handler();
        $ticketInputArray['eventId'] = $eventId;
        $ticketInputArray['donationTicket'] = TRUE;
        $eventTicketDetails = $this->ticketHandler->getTickets($ticketInputArray);
        $data['ticketData'] = $eventTicketDetails['response']['viralTicketData'];
        $ticketIds=array();
        if(isset($eventTicketDetails['response']['viralTicketData']) && !empty($eventTicketDetails['response']['viralTicketData'])){
            $ticketIds=array_keys($eventTicketDetails['response']['viralTicketData']);
        }
        
        $ticketInput['eventid']=$eventId;
        $ticketCommissionsResponse=$this->affiliatecustomcommissionHandler->getAffiliateTicketCommissionsbyEventId($ticketInput);
        $ticketCommissions=$ticketCommissionsResponse['response']['ticketCommissions'];
        
        // global commission
        $globalaffiliateCustomCommition=0;
        $comissionInput['userid']=$organizerid;
        $affiliateCustomCommition=$this->affiliatecustomcommissionHandler->getAffiliateGlobalCustomCommission($comissionInput); 
        if($affiliateCustomCommition['status'] && $affiliateCustomCommition['response']['total'] > 0){
           $globalaffiliateCustomCommition=$affiliateCustomCommition['response']['affiliateCustomCommition'][0]['affiliateglobalcommission'];
        }
        $data['affiliateCustomCommition']=$globalaffiliateCustomCommition;
        $postInputs=$this->input->post();
        
        if (isset($postInputs) && !empty($postInputs)){
            if($postInputs['formtype']=='affiliateSettings'){
            $postInputs['organizerid']=$organizerid;
            $postInputs['eventId']=$eventId;
            $affiliateGlobalCommission = $this->affiliatecustomcommissionHandler->saveAffiliateSettings($postInputs);
            $data['output'] = $affiliateGlobalCommission;
        
            }
            if($postInputs['formtype']=='affiliateTicketCommissions'){
                foreach ($eventTicketDetails['response']['viralTicketData'] as $key => $val) {
                    $affiliateData=array();
                    $tktId = $val['id'];
                    $eventId = $val['eventId'];
                    $affiliateData['ticketid'] = $tktId;
                    $affiliateData['eventid'] = $eventId;
                    $status = $this->input->post('status' . $tktId);
                    
                    $affiliateData['status'] = ($status == 1) ? 1 : 0;
                    $salesDone = $this->input->post('salesDone' . $tktId);
                    $affiliateData['type'] = 'ticket';
                    if($salesDone==0){
                    $affiliateData['commission'] = $this->input->post('referrercommission' . $tktId);
                    }else{
                    $affiliateData['nocommission']=TRUE;
                    }
                    
                   $this->affiliatecustomcommissionHandler->addAffiliateCustomCommission($affiliateData);
                }
                $data['output']['status'] = TRUE;
                $data['output']['response']['messages'][] = SUCCESS_UPDATED;
                $data['output']['statusCode'] = STATUS_OK;
            
                
                
            }
        }
        
        
        
        $this->load->model('Event_setting_model');
        $this->Event_setting_model->resetVariable();
        $selectEventSettingData = array();
        $selectEventSettingData['affiliateavail'] = $this->Event_setting_model->affiliateavail;
        $selectEventSettingData['affiliatetype'] = $this->Event_setting_model->affiliatetype;

        $this->Event_setting_model->setSelect($selectEventSettingData);
        $whereDetails['eventid'] = $eventId;
        $this->Event_setting_model->setWhereIns($whereDetails);
        $eventSettings = $this->Event_setting_model->get();
        $data['eventsettings']=$eventSettings[0];
        
        // public commission
        $publicCommissionArray['eventid']=$eventId;
        $publicCommissionArray['type']='public';
        $publicCommission=$this->affiliatecustomcommissionHandler->getAffiliateCustomCommission($publicCommissionArray);
        if(isset($publicCommission['status']) && $publicCommission['response']['total']>0){
          $data['publicCommission']=$publicCommission['response']['affiliateCustomCommition'][0]['commission'];  
        }
        $inputArray['eventId'] = $eventId;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        if ($eventDetails) {
            $data['eventId'] = $eventDetails['response']['details']['id'];
            $data['eventName'] = $eventDetails['response']['details']['title'];
            $timeZoneData['timezoneId'] = $eventDetails['response']['details']['timeZoneId'];
            $timeZoneData['status'] = 1;
            $this->timezoneHandler = new Timezone_handler();
            $timeZoneDetails = $this->timezoneHandler->details($timeZoneData);
            $timeZoneName = "";
            if ($timeZoneDetails['status']) {
                $timeZoneName = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['name'];
            }
            $data['eventTimeZoneName'] = $timeZoneName;
        }
        
        $inputArray['type'] = 'affliate';
        $inputArray['individualtransactions']=TRUE;
        $promoterDetails = $this->promoterHandler->getPromoterList($inputArray);
        $data['promoterDetails']=$promoterDetails;
         // ticket commissions
        $ticketInputArray['eventid']=$eventId;
        $ticketCommissionData=$this->affiliatecustomcommissionHandler->getAffiliateTicketCommissionsbyEventId($ticketInputArray);
        $ticketCommission=array();
        if(isset($ticketCommissionData['status']) && $ticketCommissionData['response']['total']>0){
            foreach ($ticketCommissionData['response']['ticketCommissions'] as $tckey => $tcvalue) {
                $ticketCommission[$tcvalue['ticketid']]=$tcvalue;
            }
        }
        
        // get promoters sales commissions details
        $promoterid=array();
         if ($promoterDetails['status'] && $promoterDetails['response']['total']>0) { 
             
            foreach ($promoterDetails['response']['promoterList'] as $plkey => $plvalue) {
                $promoterid[]=$plvalue['id'];
            }
         }
         $commissionPercentages=array();
         if(!empty($promoterid)){
        $prmoterSalesArray['promoterid']=$promoterid;
        $prmoterSalesArray['eventid']=$eventId;
        $promoterSaleCommissions=$this->promoterticketsaleHandler->getAffiliateSales($prmoterSalesArray);
        
        if(isset($promoterSaleCommissions['status']) && $promoterSaleCommissions['response']['total']>0){
          $data['promoterSaleCommission']=$promoterSaleCommissions['response']['promoterSaleCommissions'];  
        }
        
       
       $commissionPercentageArray['promoterid']=$promoterid;
       $commissionPercentageArray['eventid']=$eventId;
       $commissionPercentageArray['type']='eventattendee';
       $promoterCommissionPercentages=$this->affiliatecustomcommissionHandler->getAffiliateCustomCommission($commissionPercentageArray);
       if(isset($promoterCommissionPercentages['status']) && $promoterCommissionPercentages['response']['total']>0){
           foreach ($promoterCommissionPercentages['response']['affiliateCustomCommition'] as $acckey => $accvalue) {
               $commissionPercentages[$accvalue['promoterid']]=$accvalue;
           }
       }
        }
        $data['commissionPercentages']=$commissionPercentages;
        $data['ticketCommission'] = $ticketCommission;
        $data['content'] = 'promoter_list_view';
        $data['pageName'] = 'Promoter List';
        $data['pageTitle'] = 'MeraEvents | Promoter List';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function discount($eventId, $id = '') {
        $this->eventHandler = new Event_handler();
        $this->timezoneHandler = new Timezone_handler();
        $inputArray['eventId'] = $eventId;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        if ($eventDetails) {
            $data['eventName'] = $eventDetails['response']['details']['title'];
            $data['eventId'] = $eventDetails['response']['details']['id'];
            $data['masterEvent'] = $eventDetails['response']['details']['masterevent'];
            $timeZoneData['timezoneId'] = $eventDetails['response']['details']['timeZoneId'];
            $timeZoneData['status'] = 1;
            $timeZoneDetails = $this->timezoneHandler->details($timeZoneData);
            $timeZoneName = "";
            if ($timeZoneDetails['status']) {
                $timeZoneName = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['name'];
            }
            $data['eventTimeZoneName'] = $timeZoneName;
            $data['timezoneId'] = $timeZoneData['timezoneId'];
        }

        //Getting all discounts related to the event
        $inputArray['type'] = 'normal'; //Setting field 'type' as 'normal' to get normal discount list     
        //Updating the status depending on the start date and usage limit(availability)     
        if($data['masterEvent'] == TRUE){
            $inputArray['types'] = array('normal','masterDiscount'); 
        }
        $statusUpdated = $this->discountHandler->updateDiscountStatus($inputArray);
        $allDiscountList = $this->discountHandler->getDiscountList($inputArray);
        if ($allDiscountList['response']['total'] == 0) {
            $data['noDiscountMessage'] = $allDiscountList['response']['messages'][0];
        } else {
            $discountList = $allDiscountList['response']['discountList'];
            if ($discountList) {
                foreach($discountList as $key => $value){
                    $inputArray['eventid'] = $value['eventid'];
                    $detailsRes = $this->eventHandler->getEventInfoById($inputArray);
                    if($detailsRes['status'] == TRUE && $value['eventid'] != $eventId){
                        $discountList[$key]['eventStartDate'] = $detailsRes['response']['eventInfo'][0]['startdatetime'];
                    }
                }
                $data['discountList'] = $discountList;
            }

            //Getting all discount ids related to the event
            $discountIdList = array();
            foreach ($discountList as $key => $value) {
                $discountIdList[] = $value['id'];
            }

            //Getting all ticketdiscount data to get the tickets related to discounts of the event.
            $this->ticketDiscountHandler = new Ticketdiscount_handler();
            $allTicketDiscountList = $this->ticketDiscountHandler->getTicketDiscountData($discountIdList);
            $ticketDiscountList = $allTicketDiscountList['response']['ticketDiscountList'];

            //Deleting the discount
            if ($id) {
                $inputArray['id'] = $id;
                $inputArray['type'] = 'normal';
                if($data['masterEvent'] == TRUE){
                    $discountList = commonHelperGetIdArray($discountList,'id');
                    $inputArray['id'] = $discountList[$id]['id'];
                    $inputArray['type'] = $discountList[$id]['type'];
                    $inputArray['eventId'] = $discountList[$id]['eventid'];
                }
                $deletedStatus = $this->discountHandler->deleteDiscount($inputArray);
                if ($deletedStatus) {
                    $redirectUrl = commonHelperGetPageUrl('dashboard-list-discount', $eventId);
                    redirect($redirectUrl);
                }
            }
        }
        $data['pageName'] = 'Event Dashboard';
        $data['pageTitle'] = 'MeraEvents | Discount Codes';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'discount_list_view';
        $data['eventId'] = $eventId;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function bulkDiscount($eventId, $id = '') {
        $this->eventHandler = new Event_handler();
        $this->timezoneHandler = new Timezone_handler();
        $inputArray['eventId'] = $eventId;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        if ($eventDetails) {
            $data['eventName'] = $eventDetails['response']['details']['title'];
            $data['eventId'] = $eventDetails['response']['details']['id'];
            $data['masterEvent'] = $eventDetails['response']['details']['masterevent'];
            $timeZoneData['timezoneId'] = $eventDetails['response']['details']['timeZoneId'];
            $timeZoneData['status'] = 1;
            $timeZoneDetails = $this->timezoneHandler->details($timeZoneData);
            $timeZoneName = "";
            if ($timeZoneDetails['status']) {
                $timeZoneName = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['name'];
            }
            $data['eventTimeZoneName'] = $timeZoneName;
            $data['timezoneId'] = $timeZoneData['timezoneId'];
        }

        //Getting all discounts related to the event
        $inputArray['type'] = 'bulk'; //Setting field 'type' as 'bulk' to get bulk discount list     
        //Updating the status depending on the start date and usage limit(availability)     
        if($data['masterEvent'] == TRUE){
            $inputArray['type'] = 'masterBulkDiscount';
        }
        $statusUpdated = $this->discountHandler->updateDiscountStatus($inputArray);
        $allDiscountList = $this->discountHandler->getDiscountList($inputArray);
        if ($allDiscountList['response']['total'] == 0) {
            $data['noDiscountMessage'] = $allDiscountList['response']['messages'][0];
        } else {
            $discountList = $allDiscountList['response']['discountList'];
            if ($discountList) {
                $data['discountList'] = $discountList;
            }

            //Getting all discount ids related to the event
            $discountIdList = array();
            foreach ($discountList as $key => $value) {
                $discountIdList[] = $value['id'];
            }

            //Getting all ticketdiscount data to get the tickets related to discounts of the event.
            $this->ticketDiscountHandler = new Ticketdiscount_handler();
            $allTicketDiscountList = $this->ticketDiscountHandler->getTicketDiscountData($discountIdList);
            $ticketDiscountList = $allTicketDiscountList['response']['ticketDiscountList'];

            //Deleting the discount
            if ($id) {
                $inputArray['id'] = $id;
                if($data['masterEvent'] == TRUE){
                    $inputArray['type'] = 'masterBulkDiscount';
                }else{
                    $inputArray['type'] = 'bulk';
                }
                $deletedStatus = $this->discountHandler->deleteDiscount($inputArray);
                if ($deletedStatus) {
                    $redirectUrl = commonHelperGetPageUrl('dashboard-bulkdiscount', $eventId);
                    redirect($redirectUrl);
                }
            }
        }
        $data['pageName'] = 'Event Dashboard';
        $data['pageTitle'] = 'MeraEvents | Bulk Discount Codes';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'bulk_discount_list_view';
        $data['eventId'] = $eventId;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function addBulkDiscount($eventId, $id = '') {
        $this->eventHandler = new Event_handler();
        $this->timezoneHandler = new Timezone_handler();
        $inputArray['eventId'] = $eventId;
        $data['output'] = array();
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        $timeZoneName = "";
        if ($eventDetails) {
            $data['eventName'] = $eventDetails['response']['details']['title'];
            $data['eventEndDate'] = $eventDetails['response']['details']['endDate'];
            $data['masterEvent'] = $eventDetails['response']['details']['masterevent'];
            $timeZoneData['timezoneId'] = $eventDetails['response']['details']['timeZoneId'];
            $timeZoneData['status'] = 1;
            $timeZoneDetails = $this->timezoneHandler->details($timeZoneData);

            if ($timeZoneDetails['status']) {
                $timeZoneName = $timeZoneDetails['response']['detail'][$timeZoneData['timezoneId']]['name'];
            }
        }
        $data['eventTimeZoneName'] = $timeZoneName;
        $ticketsDetails = $this->ticketHandler->getTicketName($inputArray);
        if ($ticketsDetails['status']) {
            $data['ticketDetails'] = $ticketsDetails;
        } else {
            $data['ticketDetails'] = array();
        }

        //For editing the discount details
        if (!empty($id)) {
            $inputs['eventId'] = $eventId;
            $inputs['id'] = $id;
            if($data['masterEvent'] == TRUE){
                $inputs['type'] = 'masterBulkDiscount';
            }else{
                $inputs['type'] = 'bulk';
            }
            $discountDetails = " ";
            $discountDetails = $this->discountHandler->getDiscountList($inputs);
            $data['discountDetails'] = $discountDetails;
            if ($discountDetails) {
                //Getting discountId              
                $discountId = $discountDetails['response']['discountList'][0]['id'];

                //Getting all ticket ids related to the discount code you want to edit           
                $this->ticketDiscountHandler = new Ticketdiscount_handler();
                $ticketDiscountData = $this->ticketDiscountHandler->getTicketDiscountData($discountId);
                $ticketDiscountData = $ticketDiscountData['response']['ticketDiscountList'];
                $selectedTicketIdList = $ticketIdList = array();
                foreach ($ticketDiscountData as $key => $value) {
                    $ticketIdList[] = $value['ticketid'];
                    if ($value['status'] == 1) {
                        $selectedTicketIdList[] = $value['ticketid'];
                    }
                }
                $data['ticketIdList'] = $selectedTicketIdList;
                $discountData = $this->input->post('discountSubmit');
                if ($discountData) {
                    $inputArray = $this->input->post(); //Storing all the input form values in the inputArray
                    $inputArray['eventId'] = $eventId;
                    $inputArray['eventTimeZoneName'] = $timeZoneName;
                    if($data['masterEvent'] == TRUE){
                        $inputArray['type'] = 'masterBulkDiscount';
                        $ticketHandler = new Ticket_handler();
                        $METickets['parentTicketIds'] = $inputArray['ticketIds'];
                        $METickets['eventId'] = $inputArray['eventId'];
                        $METicketidsRes = $ticketHandler->getMultiEventTicketIds($METickets);
                        if($METicketidsRes['status'] == TRUE && $METicketidsRes['response']['total'] > 0){
                            $ticketids = array_column($METicketidsRes['response']['eventList'], 'ticketId');
                            $ticketids = array_merge($inputArray['ticketIds'], $ticketids);
                            $inputArray['ticketIds'] = $ticketids;
                        }
                    }else{
                        $inputArray['type'] = 'bulk';
                    }
                    $inputArray['id'] = $id;
                    $inputArray['dbTicketIdList'] = $ticketIdList;
                    $inputArray['discountValue'] = isset($inputArray['discountValue']) ? $inputArray['discountValue'] : $discountDetails['response']['discountList'][0]['value'];
                    $inputArray['amountType'] = isset($inputArray['amountType']) ? $inputArray['amountType'] : $discountDetails['response']['discountList'][0]['calculationmode'];
                    $discountData = $this->discountHandler->update($inputArray);
                    if ($discountData['status']) {
                        $this->customsession->setData('discountFlashMessage', SUCCESS_UPDATED);
                        $redirectUrl = commonHelperGetPageUrl('dashboard-bulkdiscount', $eventId);
                        redirect($redirectUrl);
                    } else {
                        $data['addDiscountOutput'] = $discountData;
                    }
                }
            }
        } else {
            //For adding the discount
            $discountData = $this->input->post('discountSubmit');
            if ($discountData) {
                $inputArray = $this->input->post(); //Storing all the input form values in the inputArray
                $inputArray['eventTimeZoneName'] = $timeZoneName;
                $inputArray['eventId'] = $eventId;
                if($data['masterEvent'] == TRUE){
                    $inputArray['type'] = 'masterBulkDiscount';
                }else{
                    $inputArray['type'] = 'bulk';
                }
                $discountData = $this->discountHandler->add($inputArray);
                if (!$discountData['status']) {
                    $data['addDiscountOutput'] = $discountData;
                } else {
                    $this->customsession->setData('discountFlashMessage', SUCCESS_DISCOUNT_ADDED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-bulkdiscount', $eventId);
                    redirect($redirectUrl);
                }
            }
        }
        $data['content'] = 'add_bulk_discount_view';
        $data['pageName'] = 'Add/Edit Bulk Discount';
        $data['pageTitle'] = 'MeraEvents | Add/Edit Bulk Discount';
        $data['hideLeftMenu'] = 0;
        $data['eventId'] = $eventId;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'bootstrap',
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'bootstrap-timepicker',
            $this->config->item('js_public_path') . 'dashboard/discount');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'dashboard-timepicker',
            $this->config->item('css_public_path') . 'bootstrap',
            $this->config->item('css_public_path') . 'jquery-ui');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function offlinePromoter($eventId) {
        $inputArray['eventId'] = $eventId;
        $data['eventId'] = $eventId;
        $data['eventName'] = commonHelperGetEventName($eventId);
        $inputArray['type'] = 'offline';
        $offlinePromotorList = $this->promoterHandler->getOfflinePromoterList($inputArray);
        $data['pageName'] = 'Offline Promoter Sale';
        $data['pageTitle'] = 'MeraEvents | Offline Promoter Sale';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'ofline_promoter_list_view';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/promote',
            $this->config->item('js_public_path') . 'dashboard/offlinePromoter');
        $data['offlinePromotorList'] = $offlinePromotorList;
        $this->load->view('templates/dashboard_template', $data);
    }

    public function addOfflinePromoter($eventId, $id = '') {
        $inputArray['eventId'] = $eventId;
        $inputArray['id'] = $id;
        $inputArray['ticketType'] = 'paidfree';
        $inputArray['soldout'] = 0;
        $inputArray['feature'] = 'Coming Soon';
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
		
		$promoterInputArray['id'] = $id;
		$promoterInputArray['eventId'] = $eventId;
        $offlinePromoter = $this->promoterHandler->getOfflinePromoterData($promoterInputArray);
		//print_r($inputArray);exit;
        $tickets = $this->ticketHandler->getTicketName($inputArray);
        //print_r($tickets);exit;
        $dInputArray['eventId'] = $eventId;
        $dInputArray['type'] = 'normal';
        $discounts = $this->discountHandler->getDiscountList($dInputArray);
        $data['discountsInfo']=$discounts['response']['discountList'];
         //Getting all discount ids related to the event
        $discountIdList = array();
        foreach ($data['discountsInfo'] as $key => $value) {
            $discountIdList[] = $value['id'];
        }

        //Getting all ticketdiscount data to get the tickets related to discounts of the event.
        $ticketDiscountMappingArray = array();
        if(count($discountIdList)> 0){
            $this->ticketDiscountHandler = new Ticketdiscount_handler();
            
            $allTicketDiscountList = $this->ticketDiscountHandler->getTicketDiscountData($discountIdList);
            $ticketDiscountList = $allTicketDiscountList['response']['ticketDiscountList'];
            foreach ($ticketDiscountList as $key => $value) {
                $ticketDiscountMappingArray[$value['ticketid']][] = $value['discountid'];
            }
        }
        
        $data['ticketDiscountMappingArray']=$ticketDiscountMappingArray;
        $update = $this->input->post('formSubmit');	
		//print_r($this->input->post()); exit;	
        if (!empty($id)) {
                $inputArray = $this->input->post();
                $inputArray['eventId'] = $eventId;
                $inputArray['id'] = $id;
                $inputArray['promoterId'] = $id;
                $inputArray['name'] = $this->input->post('promoterName');
                $inputArray['mobile'] = $this->input->post('promoterMobile');
                $inputArray['ticketIds'] = $this->input->post('ticketIds');
				$inputArray['maxlimit'] = $this->input->post('maxlimit');
                $offlineTickets = $this->offlinepromoterticketmappingHandler->getOfflineTickets($inputArray);
                $promoterTickets = $offlineTickets['response']['offline'];
                //$inputArray['ticketslimit'] = $this->input->post('ticketslimit'); 
                
            	/*if($inputArray['ticketslimit']==''){
                    $inputArray['ticketslimit']=null;
                }*/
                $ticketIdList = array();
                foreach ($promoterTickets as $key => $value) {
                    $ticketIdList[] = $value['ticketid'];
                    if($value['status']==1){
                        $selectedTicketIdList[$value['ticketid']]['ticketid'] = $value['ticketid'];
						$selectedTicketIdList[$value['ticketid']]['maxlimit'] = $value['maxlimit'];
                    }
                }
				//print_r($selectedTicketIdList); exit;
				
                $data['selectedTicketIdList']=$selectedTicketIdList;
                $data['editStatus']=TRUE;
                
                //selected ticket related discount list
                $selecteddiscountListArray['eventId']=$eventId;
                $selecteddiscountListArray['promoterId']=$id;
                
                $selecteddiscountList = $this->offlinepromoterdiscountsHandler->getPrometerEvetTicketDiscounts($selecteddiscountListArray);

                foreach ($selecteddiscountList['response']['prometerDiscountList'] as $key =>$value){
                    $data['selectedDiscountList'][$value['ticketid']][]=$value['discountid'];
                    
                }
                
                $inputArray['dbTicketIdList'] = $ticketIdList;
                $update = $this->input->post('formSubmit');//For editing
                if ($update) {
                    $ticError='';
                    $pdArray['id']=$id;
					
					$maxlimit = $this->input->post('maxlimit');
					$tktMaxlimit = array_sum($maxlimit);
					
					$unlimited = FALSE;
					if(count(array_filter($maxlimit)) != count($maxlimit)) {
						$unlimited = TRUE;
					}
					
					//echo $tktMaxlimit; exit;
					//print_r($maxlimit); exit;
					
                    $promoterDetails=$this->promoterHandler->getPromoterDataById($pdArray);
                    if($promoterDetails['status']){
                        $pArray['userId'] = $promoterDetails['response']['promoters'][0]['userid'];
                        $promoters = $this->promoterHandler->getPromoterEvents($pArray, $eventId);
						
						//print_r($promoters); exit;
                        
                         if ($promoters['status']) {
                            if (isset($promoters['response']['promoters']) && !empty($promoters['response']['promoters'])) {
                                $totalSoldTickets = isset($promoters['response']['promoters'][0]['quantity']) ? $promoters['response']['promoters'][0]['quantity'] : 0;
                                if(($tktMaxlimit!='' || $tktMaxlimit!=null) && ($tktMaxlimit < $totalSoldTickets) && !$unlimited){
                                   $ticError=str_replace('XXXX', $totalSoldTickets, ERROR_TICKET_LIMIT_UPDATE);
                                   $data['messages'] =$ticError;
                                }
                            }
                        }
                    }
                    
                //collecting the selected discount info
                foreach ($inputArray['ticketIds'] as $tId) {
                    $value = $this->input->post("ticketDiscount" . $tId);
                    if (isset($value)) {
                        $ticketDiscount = $this->input->post("ticketDiscount" . $tId);
                        foreach ($ticketDiscount as $discId) {
                            $inputArray['ticketDiscount'][] = $tId . "-" . $discId;
                        }
                    }
                }

                if($ticError==''){
                $offlinePromoter = $this->promoterHandler->updateOfflinePromoterData($inputArray);
                if (!$offlinePromoter['status']) {
                    $data['messages'] = $offlinePromoter['response']['messages']['0'];
                } else {
                    $this->customsession->setData('offlinePromoterFlashMessage', SUCCESS_UPDATED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-offlinepromoter', $eventId);
                    redirect($redirectUrl);
                }
                }
            }
        } 
		elseif($update) {
                $inputArray['templateType'] = TYPE_OFFLINE_PROMOTER_INVITE;
                $inputArray['templateMode'] = 'email';
                $inputArray['name'] = $this->input->post('promoterName');
                $inputArray['email'] = $this->input->post('promoterEmail');
                $inputArray['mobile'] = $this->input->post('promoterMobile');
                $inputArray['ticketIds'] = $this->input->post('ticketIds');
				$inputArray['maxlimit'] = $this->input->post('maxlimit');
                foreach ($inputArray['ticketIds'] as $tId) {
                    $value=$this->input->post("ticketDiscount" . $tId);
                    if (isset($value)) {
                    $ticketDiscount = $this->input->post("ticketDiscount" . $tId);
                    foreach ($ticketDiscount as $discId) {
                        $inputArray['ticketDiscount'][] = $tId . "-" . $discId;
                        }
                    }
                }
				
				
            
            	/*$inputArray['ticketslimit'] = $this->input->post('ticketslimit');
                if($inputArray['ticketslimit']==''){
                    $inputArray['ticketslimit']=null;
                }*/
                $offlinePromoter = $this->promoterHandler->addOfflinePromoter($inputArray, $eventDetails);
                if (!$offlinePromoter['status']) {
                    $data['messages'] = $offlinePromoter['response']['messages']['0'];
                } else {
                    $this->customsession->setData('offlinePromoterFlashMessage', SUCCESS_ADDED_OFFLINE_PROMOTER);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-offlinepromoter', $eventId);
                    redirect($redirectUrl);
                }
            }        
        $data['tickets'] = $tickets['response']['ticketName'];
        $data['eventId'] = $eventDetails['response']['details']['id'];
        $data['eventName'] = $eventDetails['response']['details']['title'];
        $data['pageName'] = 'Add Promoter Sale';
        $data['pageTitle'] = 'MeraEvents | Add Offline Promoter Sale';
        $data['hideLeftMenu'] = 0;
        $data['offlinePromoter'] = $offlinePromoter['response']['offlinePromoter'];
        $data['content'] = 'add_ofline_promoter_view';  
        $data['jsArray'] = array($this->config->item('js_public_path').'dashboard/offlinePromoter');
        $data['jsTopArray'] = array(
            $this->config->item('js_public_path').'intlTelInput'
            );
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'intlTelInput'
	);
        $this->load->view('templates/dashboard_template', $data);
    
    }

    public function guestListBooking($eventId) {
      


        $inputArray['eventId'] = $eventId;
        $data['eventName'] = commonHelperGetEventName($eventId);
        $inputArray['ticketType'] = 'donation';
        $tickets = $this->ticketHandler->getTicketName($inputArray);
        if ($tickets['status'] == TRUE && $tickets['response']['total'] == 0) {
            $data['status'] = false;
            $data['messages'] = $tickets['response']['messages'][0];
        }
        $update = $this->input->post('guestBooking');
      
        $ticketId = $this->input->post('ticketId');
        $inputArray['ticketId'] = $ticketId;
        
        if ($update == "Upload") {
            $this->customsession->unSetData('errorCsvFile');
            $booking = $this->guestlistbookingHandler->guestListBooking($inputArray);
            if ($booking['status'] == TRUE) {

               
                $data['status'] = true;
                if(isset($booking['errorFileUrl']) && $booking['errorFileUrl'] !=''){
                    $data['errorUrl'] = $booking['errorFileUrl'];
                }
                $data['messages'] = $booking['response']['messages'][0];
                $successMessage = $booking['response']['messages'][0];
                $this->customsession->setData('guestListBookingSuccessMessage', $successMessage);
                $this->customsession->setData('errorCsvFile', $booking['errorFileUrl']);
                $redirectUrl = commonHelperGetPageUrl('dashboard-guestlist-booking', $eventId);
                redirect($redirectUrl);
            } else {
                $this->customsession->unSetData('errorCsvFile');
                $data['status'] = false;
                $data['messages'] = $booking['response']['messages'][0];
            }
        }
        $data['eventId']=$eventId;
        $data['tickets'] = $tickets['response']['ticketName'];
        $data['pageName'] = 'Bulk Booking';
        $data['pageTitle'] = 'MeraEvents | Bulk Bookings';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'guestlist_booking_view';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/offlinePromoter'
        );
        
        $this->load->view('templates/dashboard_template', $data);
    }

    // This function moved to user controller.
    // public function processBulkUpload()
    // {
    //     $bulk_data = $this->guestlistbookingHandler->getBulkRegistrationData();
    //     $result = $this->guestlistbookingHandler->insertBulkRegistrationData($bulk_data);

    //     //Clear the autoset session
    //     unset($_SESSION['userId']);
    //     unset($_SESSION);
    //     session_destroy();
    //     exit;
    // }

    public function guestBookingFailures($eventId)
    {
        $result = $this->guestlistbookingHandler->checkBulkUploadFailures($eventId);

        $data['eventId']=$eventId;
        $data['result'] = $result;

        $data['pageName'] = 'Bulk Booking Failures';
        $data['pageTitle'] = 'MeraEvents | Bulk Bookings Failures';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'bulk_upload_failures_view';

        $this->load->view('templates/dashboard_template', $data);
    }

    /*
     * Uploading the Organizer attendees
     * 
     */

    public function uploadOrganizerAttendees($eventId) {
        $data['eventId'] = $eventId;
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['pageName'] = 'Past Attendee Marketing';
        $data['pageTitle'] = 'MeraEvents | Past Attendees';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'past_att_upload_view';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/promote',$this->config->item('js_public_path').'additional-methods'
        );
        //print_r($data);exit;
        $this->load->view('templates/dashboard_template', $data);
    }

    /*
     * Organizer Past attendee Listing
     */

    public function pastattendeelist($eventId) {
        $inputEventInfo['eventid']=$eventId;
        $eventInfoRes=$this->eventHandler->getEventInfoById($inputEventInfo);
        //print_r($eventInfoRes);exit;
        if($eventInfoRes['status'] && $eventInfoRes['response']['total']>0){
            require_once (APPPATH . 'handlers/organizerpastcontacts_handler.php');
            $organizerpastcontacts_handler = new organizerpastcontacts_handler();
            $inputAttList['organizerid']=$eventInfoRes['response']['eventInfo'][0]['ownerid'];
            $pastAttList = $organizerpastcontacts_handler->get($inputAttList);
            //print_r($pastAttList);exit;
            if($pastAttList['status'] && $pastAttList['response']['total']>0){
                $data['pastAttList'] = $pastAttList['response']['contacts'];
            }else{
                $data['messages']=$pastAttList['response']['messages'][0];
            }
        }else{
            $data['messages']=$eventInfoRes['response']['messages'][0];
        }
        
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'past_att_list_view';
        $data['pageName'] = 'Viral Ticket';
        $data['pageTitle'] = 'MeraEvents | Viral Ticketing';
        $this->load->view('templates/dashboard_template', $data);
    }

    /*
     * send emails to past attendees in asynchronous
     */

    public function sendEmailsToPastAtt() {
		$eventId = $this->input->post('eventId');
        $userId = getUserId();
        $url = commonHelperGetPageUrl('api_sendemailtopastatt');
        $post_string['eventId'] = $eventId;
        $post_string['userId'] = $userId;
        $ch = curl_init();
		//echo get_cookie('PHPSESSID');exit;
        curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch,CURLOPT_HTTPHEADER,array('PHPSESSID:'.get_cookie('PHPSESSID')));
		curl_setopt($ch,CURLOPT_COOKIE,'PHPSESSID='.get_cookie('PHPSESSID'));
		//var_dump($ch);exit;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'curl');
        //curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		session_write_close();
        $result = curl_exec($ch);
        curl_close($ch);
        $output['status'] = TRUE;
		$output['statusCode'] = STATUS_OK;
		$output['response']['total'] = 1;
		$output['response']['messages'][] = EMAIL_SENT_SUCCESSFULLY;
		return $output;
    }
    
     public function organizeraffiliates() {
        $this->eventHandler = new Event_handler();
        $eventIds=array();
         $organizerid= $this->customsession->getUserId();
         
         $organizerid=$this->customsession->getUserId();
        $postInputs=$this->input->post();
        if (isset($postInputs) && !empty($postInputs)){
            $postInputs['userid']=$organizerid;
            $affiliateGlobalCommission = $this->affiliatecustomcommissionHandler->addAffiliateGlobalCommission($postInputs);
            $data['output'] = $affiliateGlobalCommission;
        }
        $comissionInput['userid']=$organizerid;
        $affiliateCustomCommition=$this->affiliatecustomcommissionHandler->getAffiliateGlobalCustomCommission($comissionInput); 
        if($affiliateCustomCommition['status'] && $affiliateCustomCommition['response']['total'] > 0){
           $data['affiliateCustomCommition']=$affiliateCustomCommition['response']['affiliateCustomCommition'][0];
        }
        
        $ordData['ownerid']=$organizerid; 
        $orgEvents = $this->eventHandler->getOrganizerEvents($ordData);
         if ($orgEvents['status'] && $orgEvents['response']['total'] > 0) {
             foreach ($orgEvents['response']['organizerEvents'] as $orgkey => $orgvalue) {
               $eventIds[]=$orgvalue['id'];  
             }
        }
        $data['organizerid'] = $organizerid;
        $inputArray['eventId'] = $eventIds;
        $inputArray['organizerid'] = $organizerid;
        $inputArray['type'] = array('affliate');
        $inputArray['individualtransactions']=TRUE;
        $promoterDetails = $this->promoterHandler->getPromoterList($inputArray);
        
        $orgInputArray=array();
        $orgInputArray['organizerid'] = $organizerid;
        $orgPrpmoterDetails = $this->promoterHandler->getOrganizerGlobalPromoters($orgInputArray);
        $organizerPromoterDetails=array();
        
        if(isset($orgPrpmoterDetails['status']) && $orgPrpmoterDetails['response']['total']){
            foreach ($orgPrpmoterDetails['response']['promoterDetails'] as $pdkey => $pdvalue) {
                $promoterEmailId = $this->userHandler->getUserEmailIdByUserId($pdvalue['userid']);
                $pdvalue['email']=$promoterEmailId['response']['userData']['email'];
                $pdvalue['quantity']=$promoterDetails['response']['promoterList'][$pdvalue['userid']]['quantity'];
                $pdvalue['totalamount']=$promoterDetails['response']['promoterList'][$pdvalue['userid']]['totalamount'];
                $organizerPromoterDetails[$pdvalue['userid']]=$pdvalue;
            }
        }
        
        $promoterDetails['response']['promoterList']=$organizerPromoterDetails;
        $promoterDetails['response']['total']=count($organizerPromoterDetails);
        $customCommissions=$this->affiliatecustomcommissionHandler->getCommissionsByOrganizerId(array('organizerid'=>$organizerid));
        $data['customCommissions']=$customCommissions['response']['customCommition'];
        $data['promoterDetails']=$promoterDetails;
        
        $data['content'] = 'dashboard/organizer_affliates';
        $data['pageName'] = 'Affliate List';
        $data['pageTitle'] = 'MeraEvents | Affliate List';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote');
        $this->load->view('templates/promoter_template', $data);
    }
        
     public function addOrgPromoter() {
        $this->eventHandler = new Event_handler();
        $organizerid=$this->customsession->getUserId();
        
        if ($this->input->post('submit')) {
            $eventIds=array();
            $orgData['ownerid']=$organizerid;
            $orgEvents = $this->eventHandler->getOrganizerEvents($orgData);
            if ($orgEvents['status'] && $orgEvents['response']['total'] > 0) {
             foreach ($orgEvents['response']['organizerEvents'] as $orgkey => $orgvalue) {
               $eventIds[]=$orgvalue['id'];  
             }
          }
            if(isset($eventIds) && !empty($eventIds)){
              $inputArray['eventid'] =$eventIds; 
          }
          
          // Only ucoming event ids
            $orgUpcoingData['ownerid']=$organizerid;
            $orgUpcoingData['type']='upcoming';
            $orgUpcoingEvents = $this->eventHandler->getOrganizerEvents($orgUpcoingData);
            if ($orgUpcoingEvents['status'] && $orgUpcoingEvents['response']['total'] > 0) {
             foreach ($orgUpcoingEvents['response']['organizerEvents'] as $orgupkey => $orgupvalue) {
               $upcomingEventIds[]=$orgupvalue['id'];  
             }
          }
          
          if(isset($upcomingEventIds) && !empty($upcomingEventIds)){
              $inputArray['upcomingeventid'] =$upcomingEventIds; 
          }
            $inputArray['name'] = $this->input->post('promoterName');
            $inputArray['email'] = $this->input->post('promoterEmail');
            $inputArray['code'] = $this->input->post('promoterCode');
            $inputArray['orgpromoteurl'] = $this->input->post('orgPromoteURL');
            $inputArray['commission'] = $this->input->post('commission');
            if($inputArray['commission']<1){
                $inputArray['commission']=0;
            }
            $inputArray['organizerid'] = $organizerid;
            $inputArray['type'] = 'orgaffliate';
            $inputArray['templateType'] = TYPE_PROMOTER_INVITE_BY_ORG;
            $inputArray['templateMode'] = 'email';
            $output = $this->promoterHandler->insertOrgPromoter($inputArray);
            if ($output['status']) {
                $this->customsession->setData('promoterSuccessAdded', SUCCESS_ADDED_PROMOTER);
                redirect(commonHelperGetPageUrl('dashboard-organizer-affliates'));
            } else {
                $data['output'] = $output['response']['messages'][0];
            }
        }
        
        $comissionInput['userid']=$organizerid;
        $affiliateCustomCommition=$this->affiliatecustomcommissionHandler->getAffiliateGlobalCustomCommission($comissionInput); 
        if($affiliateCustomCommition['status'] && $affiliateCustomCommition['response']['total'] > 0){
           $data['affiliateCustomCommition']=$affiliateCustomCommition['response']['affiliateCustomCommition'][0];
        }
        
        $data['content'] = 'dashboard/add_org_promoter_view';
        $data['pageName'] = 'Add Promoter';
        $data['pageTitle'] = 'MeraEvents | Add Promoters';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote');
        $this->load->view('templates/promoter_template', $data);
    }
    
    function editOrgPromoterCommission(){
        $inputs=$this->input->post();
        if(isset($inputs) && !empty($inputs)){
           $organizerid=$this->customsession->getUserId(); 
           $inputs['organizerid']=$organizerid;
           $result=$this->affiliatecustomcommissionHandler->updateAffliateCommission($inputs); 
           return $result;
        }
    }
    function editEventPromoterCommission(){
        $inputs=$this->input->post();
        if(isset($inputs) && !empty($inputs)){
           $inputArray=array();
           $inputArray['eventid']=$inputs['eventid'];
           $inputArray['promoterid']=$inputs['promoterid'];
           $inputArray['commission']=$inputs['commission'];
           $inputArray['type']='eventattendee';
           $result=$this->affiliatecustomcommissionHandler->addAffiliateCustomCommission($inputArray); 
           return $result;
        }
    }
    

    function marketing($eventId){
        $affiliateresouceHandler = new Affiliateresouce_handler();
        $data=array();
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['eventId'] = $eventId;
        
        $resourceInput['eventId']=$eventId;
        $affiliateResouces=$affiliateresouceHandler->getResource($resourceInput);
        if(isset($affiliateResouces['status']) && $affiliateResouces['response']['total'] > 0){
        $data['affiliateResouces']=$affiliateResouces['response']['affiliateResouces'];    
        }
        $data['content'] = 'marketing_resources_view';
        $data['pageName'] = 'Marketing Resources';
        $data['pageTitle'] = 'MeraEvents | Marketing Resources';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote',);
        $this->load->view('templates/dashboard_template', $data);
    }
    
    function addresource($eventId,$resourceId){
        $affiliateresouceHandler = new Affiliateresouce_handler();
        $data=array();
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['eventId'] = $eventId;
        
        $postInputs=$this->input->post();
        
        if (isset($postInputs) && !empty($postInputs)){
            
            $resourceInput=array();
            $resourceInput['title']=$postInputs['title'];
            $resourceInput['resourceType']=$postInputs['resourcetype'];
            $resourceInput['content']=$postInputs['content'];
            $resourceInput['eventId']=$eventId;
            if($resourceId>0){
            $resourceInput['id']=$resourceId;    
            $data['output']=$affiliateresouceHandler->updateResource($resourceInput);
            }else{
            $data['output']=$affiliateresouceHandler->addResource($resourceInput);
            }
            if($data['output']['status']){
            $this->session->set_flashdata('successMsg', $data['output']['response']['messages'][0]);
            redirect(commonHelperGetPageUrl("dashboard-marketing-resources", $eventId));
            }
        }
        if($resourceId>0){
            $resourceInput['eventId']=$eventId;
            $resourceInput['id']=$resourceId;
            $affiliateResouces=$affiliateresouceHandler->getResource($resourceInput);
            if(isset($affiliateResouces['status']) && $affiliateResouces['response']['total'] > 0){
            $data['affiliateResouces']=$affiliateResouces['response']['affiliateResouces'][0];    
            }
            $data['resourceId']=$resourceId;
        }
        $data['eventId']=$eventId;
        $data['content'] = 'add_marketing_resources_view';
        $data['pageName'] = 'Add Marketing Resource';
        $data['pageTitle'] = 'MeraEvents | Marketing Resources';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/promote',);
        $this->load->view('templates/dashboard_template', $data);
    }
    
    //function for spot registration , organizer can sell ticket as promoter
    public function spotRegistration($eventId)
    {
        $inputArray['eventId'] = $eventId ;
        //$inputArray['userId'] = getUserId();
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        $eventTickets = $this->ticketHandler->getEventTicketList($inputArray);
        if($eventDetails['status'] ==1)
        {
            $data['eventData'] = $eventDetails['response']['details'];
            $data['eventId'] = $data['eventData']['id'];
            $data['eventTitle'] = $data['eventData']['title'];
        }
        
        if($eventTickets['status'] == 1)
        {
            $ticketData = array();
            $i=0;
            foreach($eventTickets['response']['ticketList'] as $key=>$value)
            {
                $ticketData[$i]['ticketid'] = $value['id'];
                $ticketData[$i]['ticketname'] = $value['name'];
                $ticketData[$i]['minOrderQuantity'] = $value['minOrderQuantity'];
                $ticketData[$i]['maxOrderQuantity'] = $value['maxOrderQuantity'];
                $i++;
            }
        }
        $data['eventTickets']= $ticketData;
        $data['pageName'] = 'Spot Registration';
        $data['pageTitle'] = 'MeraEvents | Spot Registration';
        $data['hideLeftMenu'] = 0;
        
        $data['content'] = 'spot_registration';
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'intlTelInput');

        $data['jsTopArray'] = array(
            $this->config->item('js_public_path') . 'intlTelInput');
        $data['jsArray'] = array(
            $this->config->item('js_public_path').'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/promote',
            $this->config->item('js_public_path') . 'dashboard/spotRegistration',
            $this->config->item('js_public_path') . 'additional-methods');
        //echo"<pre>";print_r($data);exit;
        $this->load->view('templates/dashboard_template', $data);
    }    

    public function socialwidgets($eventId){
        $pageHandler = new Eventfbpagemapping_handler();
        $get = $this->input->get();
        if(isset($get['tabs_added']) && count($get['tabs_added']) > 0 && is_array($get['tabs_added'])){
            foreach($get['tabs_added'] as $pageId => $status){
                if($status == TRUE){
                    $PHInput['pageId'] = $pageId;
                    $PHInput['eventId'] = $get['eventId'];
                    $check = $pageHandler->getByPageId($PHInput);
                    if($check['status'] == FALSE){
                        $insertPageRes = $pageHandler->add($PHInput);
                    }
                }
            }
            if(!empty($insertPageRes) && $insertPageRes['status'] == TRUE){
                $this->customsession->setData('successMessage', SUCCESS_ADDED);
            }else{
                $this->customsession->setData('errorMessage', ERROR_SOMETHING_WENT_WRONG);
            }
            $url = commonHelperGetPageUrl('dashboard-socialWidgets').$eventId;
            echo "<script>
            window.close();
            var winurl = '".$url."';
                    setTimeout(function(){
                        parent.window.opener.document.location.href = winurl;
                    });
            </script>";
            exit;
        }

        $inputArray['eventId'] = $eventId ;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);

        $addedTabPagesRes = $pageHandler->getByEventId($inputArray);
        if($addedTabPagesRes['status'] == TRUE){
            $data['addedTabPages'] = $addedTabPagesRes['response']['details'];
        }
        
        $data['fbloginUrl'] = 'https://www.facebook.com/dialog/pagetab?app_id='.$this->config->item('fb_app_id').'&redirect_uri='.current_url();
        $data['pageName'] = 'Social Widgets';
        $data['pageTitle'] = 'MeraEvents | Social Widgets';
        $data['hideLeftMenu'] = 0;
        
        $data['content'] = 'socialwidgets_view';
        $data['jsArray'] = array(
            $this->config->item('js_public_path').'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/promote',
            $this->config->item('js_public_path') . 'additional-methods');

        $this->load->view('templates/dashboard_template', $data);
    }

    public function partialPayments($eventId){
        $inputArray['eventId'] = $eventId;
        $data['eventId'] = $eventId;
        $data['eventName'] = commonHelperGetEventName($eventId);
        $partialPayments = $this->promoterHandler->getPartialPaymentsList($inputArray);
        
        $getDonationTkts = $this->promoterHandler->getDonationTicket($inputArray);
        if($getDonationTkts['status'] == true){
            $data['donationTktId'] = $getDonationTkts['donationTktId'];
            $data['donationTktPrice'] = $getDonationTkts['donationTktPrice'];
        }
        $data['pageName'] = 'Partial Payments Page';
        $data['pageTitle'] = 'MeraEvents | Partial Payment';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'partial_payment_list_view';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/promote',
            $this->config->item('js_public_path') . 'dashboard/partial_payment');
        $data['partialPaymentsList'] = $partialPayments;
        $this->load->view('templates/dashboard_template', $data);
    }

    public function addPartialPayment($eventId, $id=''){
        $inputArray['eventId'] = $eventId;
        $inputArray['id'] = $id;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
	$promoterInputArray['id'] = $id;
	$promoterInputArray['eventId'] = $eventId;
        $offlinePromoter = $this->promoterHandler->getPaymentUserData($promoterInputArray);
		//print_r($inputArray);exit;
        $tickets = $this->ticketHandler->getTicketName($inputArray);
        //print_r($tickets);exit;
        
        $update = $this->input->post('formSubmit');	
		//print_r($this->input->post()); exit;	
        if (!empty($id)) {
                $inputArray = $this->input->post();
                $inputArray['eventId'] = $eventId;
                $inputArray['id'] = $id;
                $inputArray['promoterId'] = $id;
                $inputArray['name'] = $this->input->post('promoterName');
                $inputArray['mobile'] = $this->input->post('promoterMobile');
                $inputArray['ticketIds'] = $this->input->post('ticketIds');
		$inputArray['price'] = $this->input->post('price');
                $ticketIdList = array();
               
                $data['editStatus']=TRUE;
                
                $update = $this->input->post('formSubmit');//For editing
                if ($update) {
                    $ticError='';
                    $pdArray['id']=$id;
		$price = $this->input->post('price');

                if($ticError==''){
                $offlinePromoter = $this->promoterHandler->updatePartialPaymentUserData($inputArray);
                if (!$offlinePromoter['status']) {
                    $data['messages'] = $offlinePromoter['response']['messages']['0'];
                } else {
                    $this->customsession->setData('offlinePromoterFlashMessage', SUCCESS_UPDATED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-partialPayments', $eventId);
                    redirect($redirectUrl);
                }
                }
            }
        } 
		elseif($update) {
                $inputArray['templateType'] = TYPE_PARTIAL_PAYMENT_INVITE;
                $inputArray['templateMode'] = 'email';
                $inputArray['name'] = $this->input->post('promoterName');
                $inputArray['email'] = $this->input->post('promoterEmail');
                $inputArray['mobile'] = $this->input->post('promoterMobile');
                $inputArray['ticketIds'] = $this->input->post('ticketIds');
		$inputArray['price'] = $this->input->post('price');
				
                $offlinePromoter = $this->promoterHandler->addPatialPaymentUser($inputArray, $eventDetails);
                if (!$offlinePromoter['status']) {
                    $data['messages'] = $offlinePromoter['response']['messages']['0'];
                } else {
                    $this->customsession->setData('offlinePromoterFlashMessage', SUCCESS_ADDED_PARTIAL_PAYMENT);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-partialPayments', $eventId);
                    redirect($redirectUrl);
                }
            }
            
            //get tkt price for edit mode
            $ppUserid = $id;
            $getTktPrice = $this->promoterHandler->getPartialPaymentTktPrice($ppUserid);
            if(isset($getTktPrice['ticketprice'])){
                $data['ticketprice'] = $getTktPrice['ticketprice'];
            }
            if(isset($getTktPrice['transactionscount'])){
                $data['transactionscount'] = $getTktPrice['transactionscount'];
            }
        $data['tickets'] = $tickets['response']['ticketName'];
        $data['eventId'] = $eventDetails['response']['details']['id'];
        $data['eventName'] = $eventDetails['response']['details']['title'];
        $data['pageName'] = 'Partial Payment';
        $data['pageTitle'] = 'MeraEvents | Partial Payment';
        $data['hideLeftMenu'] = 0;
        $data['offlinePromoter'] = $offlinePromoter['response']['offlinePromoter'];
        $data['content'] = 'add_partial_payment_view';  
        $data['jsArray'] = array($this->config->item('js_public_path').'dashboard/partial_payment');
        $data['jsTopArray'] = array(
            $this->config->item('js_public_path').'intlTelInput'
            );
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'intlTelInput'
	);
        //echo '<pre>';print_r($data);exit;
        $this->load->view('templates/dashboard_template', $data);
    }
    
    public function upadteTkrPrice(){
        $inputs = $this->input->post();
        $updateTktPrice = $this->promoterHandler->updateTktPrice($inputs);
        echo $updateTktPrice;exit;
    }
}
?>