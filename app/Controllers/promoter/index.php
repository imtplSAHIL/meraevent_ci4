<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Default landing page controller
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, MeraEvents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     05-08-2015
 * @Last Modified On  05-08-2015
 * @Last Modified By  Qison  Dev Team
 */
require_once(APPPATH . 'handlers/promoter_handler.php');
require_once (APPPATH . 'handlers/event_handler.php');
require_once (APPPATH . 'handlers/promoterticketsale_handler.php');
require_once (APPPATH . 'handlers/affiliateresouce_handler.php');
require_once (APPPATH . 'handlers/affiliatecustomcommission_handler.php');
require_once (APPPATH . 'handlers/ticket_handler.php');
class Index extends CI_Controller {

    var $promoterHandler;
    var $promoterticketsaleHandler;
    var $affiliateresouceHandler;

    public function __construct() {
        parent::__construct();
        $this->promoterHandler = new Promoter_handler();
        $this->eventHandler = new Event_handler();
        $this->promoterticketsaleHandler = new Promoterticketsale_handler();
        $this->affiliateresouceHandler = new Affiliateresouce_handler();
    }

    public function currentList() {
        $inputArray['userId'] = getUserId();

        //$inputArray['userId'] = '31372';
        $inputArray['type'] = 'currentEvents';
        $promoters = $this->promoterHandler->getPromoterEvents($inputArray);
        $promoterSaleCommission=array();
        if(isset($promoters['response']['promoters']) && !empty($promoters['response']['promoters'])){
            foreach ($promoters['response']['promoters'] as $ptkey => $ptvalue) {
                if($ptvalue['type']=='affliate'){
                    $prmoterSalesArray['promoterid']=$ptvalue['promoterId'];
                    $prmoterSalesArray['eventid']=$ptvalue['eventId'];
                    $promoterSaleCommissions=$this->promoterticketsaleHandler->getAffiliateSales($prmoterSalesArray);

                    if(isset($promoterSaleCommissions['status']) && $promoterSaleCommissions['response']['total']>0){
                      $promoterSaleCommission[$ptvalue['promoterId']]=$promoterSaleCommissions['response']['promoterSaleCommissions'][$ptvalue['promoterId']]['totalcommission'];  
                    }
                }
            }
        }
        
        $data['promoterSaleCommission']=$promoterSaleCommission;
        $data['pageName'] = 'Promoter CurrentEvents';
        $data['pageTitle'] = 'MeraEvents | Promoter View | Current Events';
        $data['hideLeftMenu'] = 0;
        $data['promoters'] = $promoters['response']['promoters'];
        $data['content'] = 'promoter/currentevents_view';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/table-saw'
        );
        $this->load->view('templates/promoter_template', $data);
    }

    public function pastList() {
        $inputArray['userId'] = getUserId();
        //$inputArray['userId'] = '31372';
        $inputArray['type'] = 'pastEvents';
        $promoters = $this->promoterHandler->getPromoterEvents($inputArray);
        $promoterSaleCommission=array();
        if(isset($promoters['response']['promoters']) && !empty($promoters['response']['promoters'])){
            foreach ($promoters['response']['promoters'] as $ptkey => $ptvalue) {
                if($ptvalue['type']=='affliate'){
                    $prmoterSalesArray['promoterid']=$ptvalue['promoterId'];
                    $prmoterSalesArray['eventid']=$ptvalue['eventId'];
                    $promoterSaleCommissions=$this->promoterticketsaleHandler->getAffiliateSales($prmoterSalesArray);

                    if(isset($promoterSaleCommissions['status']) && $promoterSaleCommissions['response']['total']>0){
                      $promoterSaleCommission[$ptvalue['promoterId']]=$promoterSaleCommissions['response']['promoterSaleCommissions'][$ptvalue['promoterId']]['totalcommission'];  
                    }
                }
            }
        }
        
        $data['promoterSaleCommission']=$promoterSaleCommission;
        $data['pageName'] = 'Promoter PastEvents';
        $data['pageTitle'] = 'MeraEvents | Promoter View | Past Events';
        $data['hideLeftMenu'] = 0;
        $data['promoters'] = $promoters['response']['promoters'];
        $data['content'] = 'promoter/pastevents_view';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/table-saw'
        );
        $this->load->view('templates/promoter_template', $data);
    }

    // book offline tickets
    public function bookOfflineTicket() {
        $data['eventId'] = $this->input->get('eventId');
        $data['id'] = $this->input->get('id');
        $userEmail = $this->customsession->getData('userEmail');
        $inputArray['userId'] = getUserId();
        //$inputArray['type'] = 'currentEvents';
        $inputArray['eventId'] = $data['eventId'];
        if($this->input->get('id')){           
        $inputArray['id'] = $this->input->get('id');
        }
        $promoterEvents = $this->promoterHandler->promoterEventsList($inputArray);
        $promoterTickets = $this->promoterHandler->offlineTicketsByEvent($inputArray);
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        $data['pageName'] = 'Promoter Offline Booking';
        $data['eventData'] = $eventDetails['response']['details'];
        $data['pageName'] = 'Promoter Offline Booking';
        $data['pageTitle'] = 'MeraEvents | Promoter Offline Booking';
        $data['hideLeftMenu'] = 0;
        $data['events'] = $promoterEvents['response']['events'];
        $data['eventTickets'] = $promoterTickets['response']['eventTickets'];

        $data['content'] = 'promoter/offline_booking_view';
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'intlTelInput'
	);

        $data['jsTopArray'] = array(
            $this->config->item('js_public_path') . 'intlTelInput'
	);
        $data['jsArray'] = array(
                
			$this->config->item('js_public_path').'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/promote',
            $this->config->item('js_public_path') . 'dashboard/offlinePromoter',
            $this->config->item('js_public_path') . 'additional-methods'
        );
        $this->load->view('templates/promoter_template', $data);
    }

    //Event Details list
    public function eventDetailsList($type, $eventId, $promoterCode) {
        
        $inputArray['eventId'] = $eventId;
        $data['eventId'] = $eventId;
        $data['promoterCode'] = $promoterCode;
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        $data['pageName'] = 'Promoter Event Details';
        $data['pageTitle'] = 'Promoter Event Details';
        $data['hideLeftMenu'] = 0;
        $data['eventDetails'] = $eventDetails['response']['details'];
        $convertedStartTime = convertTime($eventDetails['response']['details']['startDate'], $eventDetails['response']['details']['location']['timeZoneName'], TRUE);
        $convertedEndTime = convertTime($eventDetails['response']['details']['endDate'], $eventDetails['response']['details']['location']['timeZoneName'], TRUE);
        $now = convertTime(allTimeFormats('',11), "Asia/Kolkata", TRUE);
        $nowdate = strtotime($now);
        $enddate = strtotime($convertedEndTime);
        if ($enddate > $nowdate) {
            $data['type'] = "current";
        } else {
            $data['type'] = "past";
        }
        $data['startDateTime'] = convertDateTo($convertedStartTime) . " " .  allTimeFormats($convertedStartTime,4);
        $data['endDateTime'] = convertDateTo($convertedEndTime) . " " .  allTimeFormats($convertedEndTime,4);
        
        $resourceInput['eventId']=$eventId;
        $resourceInput['status']=TRUE;
        $affiliateResouces=$this->affiliateresouceHandler->getResource($resourceInput);
        $affiliateResoucesDetails=array();
        if(isset($affiliateResouces['status']) && $affiliateResouces['response']['total'] > 0){
            foreach ($affiliateResouces['response']['affiliateResouces'] as $key => $value) {
               $affiliateResoucesDetails[$value['resourcetype']][]=$value;
            } 
        $data['affiliateResouces']=$affiliateResoucesDetails;    
        }
        $promoterInputArray['code']=$promoterCode;
        $promoterInputArray['eventId']=$eventId;
        $promoters = $this->promoterHandler->getPromoterByCode($promoterInputArray);
        if(isset($promoters['status']) && $promoters['response']['total']>0){
            $promoterid=$promoters['response']['promoters'][0]['id'];
        }
        if($promoterid>0){
        $affiliatecustomcommissionHandler=new Affiliatecustomcommission_handler();
        $ticketHandler=new Ticket_handler();
        
        $ticketInputArray['eventId'] = $eventId;
        $eventTicketDetails = $ticketHandler->getEventPromoteTickets($ticketInputArray);
        $ticketData = $eventTicketDetails['response']['ticketData'];
        $ticketComInputArray['eventid']=$eventId;
        $ticketCommissionData=$affiliatecustomcommissionHandler->getAffiliateTicketCommissionsbyEventId($ticketComInputArray);
        $ticketCommission=array();
        if(isset($ticketCommissionData['status']) && $ticketCommissionData['response']['total']>0){
            foreach ($ticketCommissionData['response']['ticketCommissions'] as $tckey => $tcvalue) {
                $ticketCommission[$tcvalue['ticketid']]=$tcvalue;
            }
        }
        
        $comissionArray['eventid'] = $eventId;
        $comissionArray['promoterid'] = $promoterid;
        $comissionArray['organizerid'] = $eventDetails['response']['details']['ownerId'];
        foreach ($ticketData as $tdkey => $idvalue) {
            if($ticketCommission[$idvalue['id']]['status']==1 || !isset($ticketCommission[$idvalue['id']]['status'])){
                $comissionArray['ticketid'] = $idvalue['id'];
                $commissionData = $affiliatecustomcommissionHandler->getPromoterCommission($comissionArray);
                if (isset($commissionData['status']) && $commissionData['response']['total'] > 0) {
                    $commissionPercentage=$commissionData['response']['commissions']['commission'];
                }
                $idvalue['promotercommission']=$commissionPercentage;
                $data['ticketData'][$tdkey]=$idvalue;
            }
        }
        
        }
        $eventUrl = $eventDetails['response']['details']['eventUrl'].'/'.$eventDetails['response']['details']['id']."?ucode=".$promoterCode;
        $data['eventShortUrl']=getTinyUrl($eventUrl);
        
        
        $data['content'] = 'promoter/PromoterEventDetails_view';
        $data['cssArray'] = array($this->config->item('css_public_path') . 'mnd-style');
        $this->load->view('templates/promoter_template', $data);
    }

    public function viewPromoterReports($eventId, $transactiontype, $promoterCode) {

        $data = array();
        $data['content'] = 'dashboard/transaction_reports_view';
        $data['headerFields'] = array();
        //$transactiontype = 'offline';
        $reporttype = 'summary';
        $promoterHandler = new Promoter_handler();
        $input['eventId'] = $eventId;
        $input['promotercode'] = $promoterCode;
        $input['transactiontype'] = $transactiontype;
        $input['page'] = 1;
        $input['reporttype'] = $reporttype;
        $promoterSalesResponse = $promoterHandler->getPromoterSales($input);
        if ($promoterSalesResponse['status'] && $promoterSalesResponse['response']['total'] > 0) {
            $data['headerFields'] = $promoterSalesResponse['headerFields'];
            $data['grandTotal'] = $promoterSalesResponse['grandTotal'];
            $transactionListResponse = $promoterSalesResponse['transactionListResponse'];
            $data['transactionList'] = $transactionListResponse['response']['transactionList'];
            $data['totalTransactionCount'] = $transactionListResponse['response']['totalTransactionCount'];
        } else {
            $data['headerFields'] = isset($promoterSalesResponse['headerFields']) ? $promoterSalesResponse['headerFields'] : array();
            $data['errors'][] = $promoterSalesResponse['response']['messages'][0];
        }
        $data['showFilters'] = 1;
        $data['page'] = 1;
        $data['hideLeftMenu'] = 0;
        $data['transactionType'] = $transactiontype;
        $data['reportType'] = $reporttype;
        $data['promoterCode'] = $promoterCode;
        $data['currencyCode'] = '';
        $data['eventId'] = $eventId;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'promoter-reports');
        $this->load->view('templates/promoter_template', $data);
    }

}

?>