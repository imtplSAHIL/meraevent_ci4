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
 * @Created     24-06-2015
 * @Last Modified On  24-06-2015
 * @Last Modified By  Sridevi
 */
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/dashboard_handler.php');
require_once(APPPATH . 'handlers/discount_handler.php');
require_once(APPPATH . 'handlers/configure_handler.php');
require_once(APPPATH . 'handlers/gallery_handler.php');
require_once(APPPATH . 'handlers/eventpaymentgateway_handler.php');
require_once(APPPATH . 'handlers/organizerbankdetail_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once(APPPATH . 'handlers/country_handler.php');
require_once(APPPATH . 'handlers/state_handler.php');
require_once(APPPATH . 'handlers/city_handler.php');
require_once(APPPATH . 'handlers/ticket_handler.php');

class Configure extends CI_Controller {

    var $dashboardHandler;
    var $eventHandler;
    var $configure_handler;
    var $paymentGatewayHandler;
    var $organizerbankdetailHandler;
    var $eventsignupHandler;
    var $countryHandler;
    var $stateHandler;
    var $cityHandler;
    
    public function __construct() {
        parent::__construct();
        $this->eventHandler = new Event_handler();
    }

    /*
     * Function to get the form for creating event
     *
     * @access	public
     * @return	Html that contains create event form
     */

    public function webhookUrl($eventId) {
        $inputArray['eventId'] = $eventId;
        $inputFormArray = $this->input->post('submit');
        if ($inputFormArray) {
            $inputArray['webhookUrl'] = $this->input->post('webhookUrl');
            $data['output'] = $this->eventHandler->updateWebhookUrl($inputArray);
        }
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['webhookUrl'] = "";
        $webhookUrlDetail = $this->eventHandler->getWebhookUrl($eventId);
        if ($webhookUrlDetail['status'] && $webhookUrlDetail['response']['total'] > 0 ) {
            $data['webhookUrl'] = $webhookUrlDetail['response']['webhookUrl'];
        }
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'webhook_view';
        $data['pageName'] = 'Web hook Url';
        $data['pageTitle'] = 'MeraEvents | Web hook Url';
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function customFields($eventId) {
        $data = array();
        $data['hideLeftMenu'] = 0;
        $data['eventId'] = $eventId;
        $input['eventId'] = $eventId;
        $data['eventTitle'] = commonHelperGetEventName($eventId);
        $inputCustomfields['eventId'] = $eventId;
        // $inputCustomfields['collectMultipleAttendeeInfo']=0;
        $inputCustomfields['allfields'] = 1;
        $inputCustomfields['statuslabels'] = 1;
        $this->configure_handler = new Configure_handler();
        $customfieldsResponse = $this->configure_handler->getCustomFields($inputCustomfields);
        if ($customfieldsResponse['status'] && $customfieldsResponse['response']['total'] > 0) {
            $data['customFieldData'] = $customfieldsResponse['response']['customFields'];
        } else {
            $data['errors'][] = $customfieldsResponse['response']['messages'][0];
        }
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/customfieldslisting' );
        $data['content'] = 'custom_fields_view';
        $data['pageTitle'] = 'MeraEvents | Custom Fields';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function seo($eventId) {
        $inputArray['eventId'] = $eventId;
        $data['eventTitle'] = commonHelperGetEventName($eventId);
        $seoDetails = $this->eventHandler->getSeoDetails($inputArray);
        if ($seoDetails['status'] == TRUE && $seoDetails['response']['total'] > 0) {
            $update = $this->input->post('submit');
            if ($update) {
                $inputArray['seotitle'] = $this->input->post("seotitle");
                $inputArray['seokeywords'] = $this->input->post("seokeywords");
                $inputArray['seodescription'] = $this->input->post("seodescription");
                $inputArray['conanicalurl'] = $this->input->post("conanicalurl");
                $multiEventCheck = $this->eventHandler->checkIsMultiEvent(array('eventId' => $eventId));
                if($multiEventCheck['status'] == TRUE && $multiEventCheck['masterEvent'] == TRUE){
                    $childEventIdsRes = $this->eventHandler->getMultiEventChildIds(array('eventId' => $eventId));
                    $childEventIds = $childEventIdsRes['response']['eventList'];
                    $childEventIds[] = $eventId;
                    foreach($childEventIds as $value){
                        $inputArray['eventId'] = $value;
                        $updateSeoDetails = $this->eventHandler->updateSeoDetails($inputArray);
                    }
                }else{
                    $updateSeoDetails = $this->eventHandler->updateSeoDetails($inputArray);
                }
                $data['seo'] =$updateSeoDetails;
                $data['message'] = $updateSeoDetails['response']['messages']['0'];
                $seoDetails = $this->eventHandler->getSeoDetails($inputArray);
            }
            $data['seoDetails'] = $seoDetails['response']['seodetails']['0'];
            $data['hideLeftMenu'] = 0;
            $data['content'] = 'seo_view';
            $data['pageName'] = 'Seo';
            $data['pageTitle'] = 'MeraEvents | Seo';
             $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/dashboard_configure' );
            $this->load->view('templates/dashboard_template', $data);
        } else {
            $redirectUrl = commonHelperGetPageUrl('dashboard-myevent');
            redirect($redirectUrl);
        }
    }

    public function ticketOptions($eventId) {
        $inputArray['eventId'] = $eventId;
        $data = array();
        $data['eventTitle'] = commonHelperGetEventName($eventId);
        $this->organizerbankdetailHandler = new Organizerbankdetail_handler();
         $this->organizerHandler = new Organizer_handler();
         $this->eventsignupHandler = new Eventsignup_handler();
        
        $ticketOptions = $this->eventHandler->getTicketOptions($inputArray);
        
        $this->eventHandler = new Event_handler();
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
        $inputArrayUser['userId'] = $eventDetails['response']['details']['ownerId'];
         
        
        $thisEventOwner = false;
        if(getUserId() == $eventDetails['response']['details']['ownerId']){
            $thisEventOwner = true;
        }
        //check the user status & event status
        $inputArrayAdmin['userIds'] = getUserId();
        
        
        $this->userHandler = new User_handler();
        $userData = $this->userHandler->getUserInfo($inputArrayAdmin);
        
        
        $isAdmin = false;
        if ($userData['status'] && $userData['response']['userData']['usertype'] == "superadmin") {
            $isAdmin = true;
        }
        
      
        if ($ticketOptions['status'] == TRUE && $ticketOptions['response']['total'] > 0) {
            
            $update = $this->input->post('submit');
            $postVars = $this->input->post();
            if ($update) {
                
                if ($postVars['collectmultipleattendeeinfo'] == 1) {
                    $inputArray['collectmultipleattendeeinfo'] = 1;
                } else {
                    $inputArray['collectmultipleattendeeinfo'] = 0;
                }
                if (isset($postVars['displayamountonticket'])) {
                    $inputArray['displayamountonticket'] = 1;
                } else {
                    $inputArray['displayamountonticket'] = 0;
                }
                if (isset($postVars['displaychargesonticket']) && $inputArray['displayamountonticket'] == 1) {
                    $inputArray['displaychargesonticket'] = 1;
                } else {
                    $inputArray['displaychargesonticket'] = 0;
                }
                $inputArray['nonormalwhenbulk'] = 0;
                if (isset($postVars['nonormalwhenbulk'])) {
                    $inputArray['nonormalwhenbulk'] = 1;
                }
//                if (isset($postVars['sendubermails'])) {
//                    $inputArray['sendubermails'] = 1;
//                } else {
//                    $inputArray['sendubermails'] = 0;
//                }
                
                if (isset($postVars['sendinvoice'])) {
                  
                    $inputArray['sendinvoice'] = 1;
                } else {
                    $inputArray['sendinvoice'] = 0;
                }
                
                if (isset($postVars['ticketdatehide'])) {
                 
                   $inputArray['ticketdatehide'] = 1;
               } else {
                   $inputArray['ticketdatehide'] = 0;
               }	
                
                if (isset($postVars['limitsingletickettype'])) {
                    $inputArray['limitsingletickettype'] = 1;
                } else {
                    $inputArray['limitsingletickettype'] = 0;
                }
                
                if (isset($postVars['registerationvalidatedomain'])) {
                    $inputArray['registerationvalidatedomain'] = 1;
                } else {
                    $inputArray['registerationvalidatedomain'] = 0;
                }
                $inputArray['registerationvalidatedomainlist'] = $postVars['registerationvalidatedomainlist'];

                $inputArray['printonticket'] = $postVars['printonticket'];
				
          
                
             if($isAdmin == true || $thisEventOwner == true && $postVars['companydetailsedit'] == true){   
               
                    $inputArrayOrganizerBank = array();
                 $inputArrayOrganizerBank['userId'] = getUserId();
                /* if (isset($postVars['servicetaxnumber'])) {
                    $inputArrayOrganizerBank['serviceTaxNumber'] = $postVars['servicetaxnumber'];
                } else {
                    $inputArrayOrganizerBank['serviceTaxNumber'] = '';
                } */
                 
                if (isset($postVars['gst'])) {
                    $inputArrayOrganizerBank['gst'] = $postVars['gst'];
                } else {
                    $inputArrayOrganizerBank['gst'] = '';
                } 
                
                if (isset($postVars['companyname'])) {
                     $inputArrayOrganizerBank['accountName'] = $postVars['companyname'];
                } else {
                     $inputArrayOrganizerBank['accountName'] = '';
                }
                if (isset($postVars['location'])) {
                     $inputArrayOrganizerBank['location'] = $postVars['location'];
                } else {
                     $inputArrayOrganizerBank['location'] = '';
                }
                if (isset($postVars['invoice_number'])) {
                     $inputArrayOrganizerBank['invoice_number'] = $postVars['invoice_number'];
                } else {
                     $inputArrayOrganizerBank['invoice_number'] = '';
                }
                if (isset($postVars['prefixinvoice'])) {
                     $inputArrayOrganizerBank['prefixinvoice'] = $postVars['prefixinvoice'];
                } else {
                     $inputArrayOrganizerBank['prefixinvoice'] = '';
                }
                
                $inputArrayOrganizerBank['eventid'] = $eventId;
                 
                $inputArrayUser = array();
                $inputArrayUser['userId'] = getUserId();
                
                $bankDetails = $this->organizerbankdetailHandler->getBankDetails($inputArrayUser);
                
                $updateEventsetting = $this->eventHandler->gstDetailsInvoice($inputArrayOrganizerBank);

                //getting bookings count for giving edit option of gst,company fields
                
                $id = $bankDetails['response']['bankDetails']['0']['userid'];
                if ($id > 0) {
                    $updateData = $this->organizerbankdetailHandler->updateBankNameandServiceTax($inputArrayOrganizerBank);
                  
                }else{
                
                    $insertData = $this->organizerbankdetailHandler->insertBankDetails($inputArrayOrganizerBank);
                }
                   $inputArrayUser['major'] = 1;
                        $companyDetails = $this->organizerHandler->getCompanyDetails($inputArrayUser);
        $orgId = $companyDetails['response']['companyDetails']['id'];
                 $companyInfo['userId'] = $inputArrayUser['userId'];
            $companyInfo['id'] = $orgId;
                        $companyInfo['countryId'] = $this->input->post("countryId");
                        $companyInfo['stateId'] = $this->input->post("stateId");
                        $companyInfo['cityId'] = $this->input->post("cityId");
                        $companyInfo['location'] = $this->input->post("location");
                        
                 if (isset($companyInfo['stateId']) && strlen($companyInfo['stateId']) > 0) {
                //for new state
                  $this->countryHandler = new Country_handler();
        $this->stateHandler = new State_handler();
        $this->cityHandler = new City_handler();   
                if (!is_numeric($companyInfo['stateId'])) {
                    $stateinput['state'] = $companyInfo['stateId'];
                    $stateinput['countryId'] = $companyInfo['countryId'];
                    $stateinput['googleapistate'] = TRUE;
                    $state = $this->stateHandler->stateInsert($stateinput);
                    if ($state['status'] === FALSE) {
                        return $state;
                    }
                    $companyInfo['stateId'] = $state['response']['stateId'];
                }
            }
            if (isset($companyInfo['cityId']) && strlen($companyInfo['cityId']) > 0) {
                //for new city
                if (!is_numeric($companyInfo['cityId'])) {
                    $cityinput['city'] = $companyInfo['cityId'];
                    $cityinput['countryId'] = $companyInfo['countryId'];
                    $cityinput['stateId'] = $companyInfo['stateId'];
                    $cityinput['googleapicity'] = TRUE;
                    $city = $this->cityHandler->cityInsert($cityinput);
                    if ($city['status'] === FALSE) {
                        return $city;
                    }
                    $companyInfo['cityId'] = $city['response']['cityId'];
                }
            }

            $companyData = $this->organizerHandler->updateCompanyAddressDetails($companyInfo);
            
             }
                $multiEventCheck = $this->eventHandler->checkIsMultiEvent(array('eventId' => $eventId));
                if($multiEventCheck['status'] == TRUE){
                    $childEventIdsRes = $this->eventHandler->getMultiEventChildIds(array('eventId' => $eventId));
                    if($childEventIdsRes['status'] == FALSE || $childEventIdsRes['response']['total'] == 0){
                        $redirectUrl = commonHelperGetPageUrl('dashboard-myevent');
                        redirect($redirectUrl);
                        $data['ticketOptionsMessage'] = $childEventIdsRes['response']['messages'];
                    }
                    $childEventIds = $childEventIdsRes['response']['eventList'];
                    $childEventIds[] = $eventId;
                    foreach($childEventIds as $value){
                        $inputArray['eventId'] = $value;
                        $updateeventSettings = $this->eventHandler->updateTicketOptions($inputArray);
                        $data['ticketSettings']=$updateeventSettings;
                        $data['message'] = $updateeventSettings['response']['messages']['0'];
                        $ticketOptions = $this->eventHandler->getTicketOptions($inputArray);
                    }
                }else{
                   
                    $updateeventSettings = $this->eventHandler->updateTicketOptions($inputArray);
                    $data['ticketSettings']=$updateeventSettings;
                    $data['message'] = $updateeventSettings['response']['messages']['0'];
                    $ticketOptions = $this->eventHandler->getTicketOptions($inputArray);
                }
    
            }
            
      
        
        $getinvoiceFieldData = $this->eventHandler->getInvoiceFields($eventId);
        $getbookingsStatus = $this->eventHandler->getTicketsBookingStatus($eventId);
        if($getbookingsStatus['0']['count'] > 0 && $getbookingsStatus['0']['einvoicenumber'] > 0){
            $data['editstatus'] = FALSE;
        }else{
            $data['editstatus'] = TRUE;
        }
			$bankDetails = $this->organizerbankdetailHandler->getBankDetails($inputArrayUser);
			
			$inputArrayUser['major'] = 1;
		   
			$companyDetails = $this->organizerHandler->getCompanyDetails($inputArrayUser);
		 
			$input['countryId'] = $companyDetails['response']['companyDetails']['countryid'];
			$input['cityId'] = $companyDetails['response']['companyDetails']['cityid'];
			$input['stateId'] = $companyDetails['response']['companyDetails']['stateid'];
            $csc =  $this->eventsignupHandler->getLocalityDetails($input);
			$locality = '';
			
					
			if($bankDetails['response']['total'] > 0 && $companyDetails['response']['total'] > 0    ){
						$companyname = $invoice_number = '';
						if(!empty($bankDetails['response']['bankDetails']['0']['accountname']))
						{
							$companyname = $bankDetails['response']['bankDetails']['0']['accountname'];
						}else if(!empty($companyDetails['response']['companyDetails']['companyname'])){
							  $companyname = $companyDetails['response']['companyDetails']['companyname'];
						}
                                                if(!empty($bankDetails['response']['bankDetails']['0']['invoice_number'])) {
                                                    $invoice_number = $bankDetails['response']['bankDetails']['0']['invoice_number'];
                                                }
							// $data['companydetails']['servicetaxnumber'] = $bankDetails['response']['bankDetails']['0']['servicetaxnumber'];
                                                        $data['companydetails']['gst'] = $bankDetails['response']['bankDetails']['0']['gst'];
							$data['companydetails']['companyname'] = $companyname;
                                                        $data['companydetails']['invoice_number'] = $invoice_number;  
						   //  $data['companydetails']['location'] = $location;   
							$data['companydetails']['countryid'] = $input['countryId'];
							$data['companydetails']['cityid'] = $input['cityId'];
							$data['companydetails']['stateid'] = $input['stateId'];
							
							if(!empty($companyDetails['response']['companyDetails']['address'])){
								$locality = $companyDetails['response']['companyDetails']['address'];
							}else if(!empty($this->eventsignupHandler->getLocalityDetails($input))){
								$locality = $this->eventsignupHandler->getLocalityDetails($input);
							}
							
							
							$data['companydetails']['location'] = $locality; 
							
						if($isAdmin == true || $thisEventOwner == true){
						   
							$data['companydetails']['companydetailsedit'] = true;
						}else{
							$data['companydetails']['companydetailsedit'] = false;
							$data['companydetails']['checkenable'] = false;    
							/* if(!empty($bankDetails['response']['bankDetails']['0']['servicetaxnumber']) && !empty($companyname) && !empty($locality)){
								$data['companydetails']['checkenable'] = true;    
							}*/ 
                                                        
                                                        if(!empty($bankDetails['response']['bankDetails']['0']['gst']) && !empty($companyname) && !empty($locality)){
								$data['companydetails']['checkenable'] = true;    
							}
							$data['companydetails']['nopermissionmessage'] = 'Please request organizer to update this option as some dependency data is not filled.';
						}
						
				 }
			elseif($isAdmin == true || $thisEventOwner == true){
				$data['companydetails']['companydetailsedit'] = true;
						
			}

            $this->db->select('id, name');
            $this->db->from('country');
            $this->db->where('deleted', 0);
            $query = $this->db->get();
            $result = $query->result_array();
           /*  echo '<pre>';
            print_r($result);
            die; */
            $data['countryList'] = $result;
			
            $ticketOptions['response']['ticketingOptions']['eventID'] = $eventId;
            $data['ticketOptions'] = $ticketOptions['response']['ticketingOptions'];
            $data['gstdetails'] = $getinvoiceFieldData['response']['invoicedetails'];
             $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/ticketOptions');
            $data['content'] = 'ticket_options_view';
            $data['pageName'] = 'Ticket Options';
            $data['pageTitle'] = 'MeraEvents | Ticket Options';
            $data['hideLeftMenu'] = 0;
            $data['csc'] = $csc;
            
            
            $this->load->view('templates/dashboard_template', $data);
        } else {
            $redirectUrl = commonHelperGetPageUrl('dashboard-myevent');
            redirect($redirectUrl);
            $data['ticketOptionsMessage'] = $ticketOptions['response']['messages'][0];
        }
    }

    /**
     * To Manage the custom fields add & update
     */
    public function manageCustomFields($eventId, $ticketId = 0, $customfieldId = 0) {
        $data = array();
        $this->configure_handler = new Configure_handler();
        $this->ticketHandler = new Ticket_handler();
        $input['eventId'] = $eventId;
        $data['eventTitle'] = commonHelperGetEventName($eventId);
        $multiEventCheck = $this->eventHandler->checkIsMultiEvent(array('eventId' => $eventId));
        if ($this->input->post('submit')) {
            $inputArray = $this->input->post();
            if ($multiEventCheck['status'] == TRUE) {
                $childEventIdsRes = $this->eventHandler->getMultiEventChildIds(array('eventId' => $eventId));
                if ($childEventIdsRes['status'] == TRUE && $childEventIdsRes['response']['total'] > 0) {
                    if ($inputArray['fieldlevel'] == 'ticket') {
                        //Ticket Level Custom Fields
                        $childEventTickets = array();
                        foreach ($inputArray['ticketIds'] as $key => $ticketId) {
                            $childEventTicketIdsRes = $this->ticketHandler->getMultiEventTicketIds(array('parentTicketId' => $ticketId, 'eventId' => $eventId));
                            if ($childEventTicketIdsRes['status'] == TRUE && $childEventTicketIdsRes['response']['total'] > 0) {
                                $childEventTickets[$ticketId] = $childEventTicketIdsRes['response']['eventList'];
                            }
                        }
                        $childTicketIds = array();
                        if (!empty($childEventTickets)) {
                            foreach ($childEventTickets as $childEventTicketsData) {
                                foreach ($childEventTicketsData as $childEventTicketData) {
                                    $childTicketIds[$childEventTicketData['eventId']][] = $childEventTicketData['ticketId'];
                                }
                            }
                        }
                        if ($customfieldId == 0) {
                            foreach ($inputArray['ticketIds'] as $key => $ticketId) {
                                $inputArray['eventId'] = $eventId;
                                $inputArray['ticketId'] = $ticketId;
                                $inputArray['other_ticketids'] = ($key == 0 ? implode(",", $inputArray['ticketIds']) : '');
                                $inputArray['customFieldId'] = $customfieldId;
                                $inputArray['parentCustomFieldId'] = 0;
                                $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                                $inputArray['parentCustomFieldId'] = $saveOrUpdateResponse['response']['affectedRows'];
                                $childEventTicketIds = $childEventTickets[$ticketId];
                                foreach ($childEventTicketIds as $childEventTicketData) {
                                    $inputArray['eventId'] = $childEventTicketData['eventId'];
                                    $inputArray['ticketId'] = $childEventTicketData['ticketId'];
                                    $inputArray['other_ticketids'] = ($key == 0 ? implode(",", $childTicketIds[$childEventTicketData['eventId']]) : '');
                                    $inputArray['customFieldId'] = $customfieldId;
                                    $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                                }
                            }
                        } else {
                            $customFieldIds = $this->configure_handler->getTicketCustomFieldIds($customfieldId);
                            $customFieldTicketIds = !empty($customFieldIds['response']['customFieldTicketIds']) ? $customFieldIds['response']['customFieldTicketIds'] : array();
                            $key = 0;
                            $notInTicketIds = array();
                            foreach ($inputArray['ticketIds'] as $notTicketId) {
                                if (!array_key_exists($notTicketId, $customFieldTicketIds)) {
                                    $notInTicketIds[] = $notTicketId;
                                }
                            }
                            foreach ($customFieldTicketIds as $ticketId => $customfieldId) {
                                if (in_array($ticketId, $inputArray['ticketIds'])) {
                                    $key++;
                                }
                                $inputArray['eventId'] = $eventId;
                                $inputArray['ticketId'] = !in_array($ticketId, $inputArray['ticketIds']) ? 0 : $ticketId;
                                $inputArray['other_ticketids'] = ($key == 1 ? implode(",", $inputArray['ticketIds']) : '');
                                $inputArray['customFieldId'] = $customfieldId;
                                $inputArray['deleted'] = !in_array($ticketId, $inputArray['ticketIds']) ? 1: 0;
                                $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                                $CCFinputArray['masterCustomFieldId'] = $customfieldId;
                                $childCustomFieldsRes = $this->configure_handler->getChildCustomFeildIds($CCFinputArray);
                                foreach ($childCustomFieldsRes['response']['customFields'] as $childCustomFields) {
                                    $inputArray['eventId'] = $childCustomFields['eventId'];
                                    $inputArray['ticketId'] = $childCustomFields['ticketId'];
                                    $inputArray['other_ticketids'] = ($key == 1 ? implode(",", $childTicketIds[$childCustomFields['eventId']]) : '');
                                    $inputArray['customFieldId'] = $childCustomFields['customFieldId'];
                                    $inputArray['deleted'] = !in_array($ticketId, $inputArray['ticketIds']) ? 1: 0;
                                    $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                                }
                            }
                            foreach ($notInTicketIds as $ticketId) {
                                $inputArray['eventId'] = $eventId;
                                $inputArray['ticketId'] = $ticketId;
                                $inputArray['other_ticketids'] = ($key == 0 ? implode(",", $inputArray['ticketIds']) : '');
                                $inputArray['customFieldId'] = 0;
                                $inputArray['deleted'] = 0;
                                $inputArray['parentCustomFieldId'] = 0;
                                $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                                $inputArray['parentCustomFieldId'] = $saveOrUpdateResponse['response']['affectedRows'];
                                $childEventTicketIds = $childEventTickets[$ticketId];
                                foreach ($childEventTicketIds as $childEventTicketData) {
                                    $inputArray['eventId'] = $childEventTicketData['eventId'];
                                    $inputArray['ticketId'] = $childEventTicketData['ticketId'];
                                    $inputArray['other_ticketids'] = ($key == 0 ? implode(",", $childTicketIds[$childEventTicketData['eventId']]) : '');
                                    $inputArray['customFieldId'] = 0;
                                    $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                                }
                                $key++;
                            }
                        }
                    } else {
                        //Event Level Custom Fields
                        if ($customfieldId == 0) {
                            $inputArray['ticketId'] = 0;
                            $inputArray['other_ticketids'] = '';
                            $inputArray['customFieldId'] = $customfieldId;
                            $inputArray['eventId'] = $eventId;
                            $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                            $inputArray['parentCustomFieldId'] = $saveOrUpdateResponse['response']['affectedRows'];
                            $childEventIds = $childEventIdsRes['response']['eventList'];
                            foreach ($childEventIds as $value) {
                                $inputArray['eventId'] = $value;
                                $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                            }
                        } else {
                            $inputArray['ticketId'] = 0;
                            $inputArray['other_ticketids'] = '';
                            $inputArray['customFieldId'] = $customfieldId;
                            $inputArray['eventId'] = $eventId;
                            $CCFinputArray['masterCustomFieldId'] = $customfieldId;
                            $childCustomFieldsRes = $this->configure_handler->getChildCustomFeildIds($CCFinputArray);
                            $childCustomFields = $childCustomFieldsRes['response']['customFields'];
                            $childCustomFields[] = array('customFieldId' => $customfieldId, 'eventId' => $eventId);
                            foreach ($childCustomFields as $value) {
                                $inputArray['customFieldId'] = $value['customFieldId'];
                                $inputArray['eventId'] = $value['eventId'];
                                $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                            }
                        }
                    }
                    if ($saveOrUpdateResponse['status'] && $saveOrUpdateResponse['response']['total'] > 0) {
                        redirect(commonHelperGetPageUrl('dashboard-customField', $eventId));
                    } else {
                        $data['message'] = $saveOrUpdateResponse['response']['messages'][0];
                    }
                } else {
                    redirect(commonHelperGetPageUrl('dashboard-customField', $eventId));
                }
            }else{
                if ($inputArray['fieldlevel'] == 'ticket') {
                    if ($customfieldId > 0) {
                        $customFieldIds = $this->configure_handler->getTicketCustomFieldIds($customfieldId);
                        $customFieldTicketIds = !empty($customFieldIds['response']['customFieldTicketIds']) ? $customFieldIds['response']['customFieldTicketIds'] : array();
                        $key = 0;
                        $notInTicketIds = array();
                        foreach ($inputArray['ticketIds'] as $notTicketId) {
                            if (!array_key_exists($notTicketId, $customFieldTicketIds)) {
                                $notInTicketIds[] = $notTicketId;
                            }
                        }
                        foreach ($customFieldTicketIds as $ticketId => $customfieldId) {
                            if (in_array($ticketId, $inputArray['ticketIds'])) {
                                $key++;
                            }
                            $inputArray['ticketId'] = !in_array($ticketId, $inputArray['ticketIds']) ? 0 : $ticketId;
                            $inputArray['other_ticketids'] = ($key == 1 ? implode(",", $inputArray['ticketIds']) : '');
                            $inputArray['customFieldId'] = $customfieldId;
                            $inputArray['deleted'] = !in_array($ticketId, $inputArray['ticketIds']) ? 1: 0;
                            $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                        }
                        foreach ($notInTicketIds as $ticketId) {
                            $inputArray['ticketId'] = $ticketId;
                            $inputArray['other_ticketids'] = ($key == 0 ? implode(",", $inputArray['ticketIds']) : '');
                            $inputArray['customFieldId'] = 0;
                            $inputArray['deleted'] = 0;
                            $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                            $key++;
                        }
                    } else {
                        foreach ($inputArray['ticketIds'] as $key => $ticketId) {
                            $inputArray['ticketId'] = $ticketId;
                            $inputArray['other_ticketids'] = ($key == 0 ? implode(",", $inputArray['ticketIds']) : '');
                            $inputArray['customFieldId'] = $customfieldId;
                            $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                        }
                    }
                } else {
                    $inputArray['ticketId'] = 0;
                    $inputArray['customFieldId'] = $customfieldId;
                    $inputArray['other_ticketids'] = '';
                    $saveOrUpdateResponse = $this->configure_handler->manageCustomField($inputArray);
                }
                if ($saveOrUpdateResponse['status'] && $saveOrUpdateResponse['response']['total'] > 0) {
                    $solrHandler = new Solr_handler();
                    $solrInput = array();
                    $solrInput['id'] = $eventId;
                    $solrInput['booknowbuttonvalue'] = 'Register Now';
                    $solrInput['mts'] = date("Y-m-d\TH:i:s\Z");
                    $solrHandler->solrUpdateEvent($solrInput);
                    redirect(commonHelperGetPageUrl('dashboard-customField', $eventId));
                } else {
                    $data['message'] = $saveOrUpdateResponse['response']['messages'][0];
                }
            }
        }
        // $customFieldId = $this->input->get("customFieldId");
        //var_dump($customFieldId);
        $data['customFieldData'] = $data['customFieldValues'] = array();
        if ($customfieldId > 0) {
            $inputArray["eventId"] = $eventId;
            $inputArray["customFieldId"] = $customfieldId;
            $inputArray["nonActiveCustomField"] = 1;
            $customFiledResponse = $this->configure_handler->getCustomFields($inputArray);
            if ($customFiledResponse['status'] && $customFiledResponse["response"]["total"] > 0) {
                $data['customFieldData'] = $customFiledResponse["response"]["customFields"][0];
            }
            $customFieldValues = $this->configure_handler->getCustomFieldValues($inputArray);
            if ($customFieldValues['status'] && $customFieldValues["response"]['total'] > 0) {
                $data['customFieldValues'] = $customFieldValues["response"]["fieldValuesInArray"];
            }
        }
        $inputTickets['eventId'] = $eventId;
        $inputTickets['statuslabels'] = 1;
        $ticketResponse = $this->eventHandler->getEventTicketDetails($inputTickets);
        if ($ticketResponse['status'] && $ticketResponse['response']['total'] > 0) {
            $data['eventTickets'] = $ticketResponse['response']['ticketList'];
        } else {
            $data['errors'][] = $ticketResponse['response']['messages'][0];
        }
        $data['eventId'] = $eventId;
        $data['pageTitle'] = 'MeraEvents | Add New Event Custom Field';
        $data['content'] = 'manage_custom_fields_view';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/customfields',
            $this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function ticketWidget($eventId) {
        $inputArray['eventId'] = $eventId;
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['content'] = 'ticket_widget_view';
        $data['pageName'] = 'Ticket Widget';
        $data['pageTitle'] = 'MeraEvents | Ticket Widget';
        $data['eventId'] = $eventId;
        $data['hideLeftMenu'] = 0;
        require_once(APPPATH . 'handlers/widgetsettings_handler.php');
        $widgetsettingsHandler = new Widgetsettings_handler();
        $widgetSettings=$widgetsettingsHandler->getWidgetSettings(array('eventid'=>$eventId));
        $widgetdata=array();
        if ($widgetSettings['status'] && count($widgetSettings) > 0 && $widgetSettings['response']['total']>0) {
            foreach ($widgetSettings['response']['widgetsettings'] as $wskey => $wsvalue) {
                $widgetdata[$wsvalue['optionname']]=$wsvalue['optionvalue'];
            }
        }
        $data['widgetSettings']=$widgetdata;
        //Get Ticket Groups
        require_once(APPPATH . 'handlers/ticketgroups_handler.php');
        $this->ticketgroupHandler = new ticketgroups_handler();
        $data['ticketgroups'] = $this->ticketgroupHandler->getGroupsWithTickets($inputArray);
        //Get All Tickets
        $this->ticketHandler = new Ticket_handler();
        $data['tickets'] = $this->ticketHandler->getTicketName($inputArray);
        $this->load->model('Event_setting_model');
        $this->Event_setting_model->resetVariable();
        $selectEventSettingData = array();
        $selectEventSettingData['widgetsettings'] = $this->Event_setting_model->widgetsettings;

        $this->Event_setting_model->setSelect($selectEventSettingData);
        $whereDetails['eventid'] = $eventId;
        $this->Event_setting_model->setWhereIns($whereDetails);
        $eventSettings = $this->Event_setting_model->get();
        $data['eventsettings']=$eventSettings[0];
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/jscolor',
            $this->config->item('js_public_path') . 'ticketwidget/ticketwidget',
            $this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $this->load->view('templates/dashboard_template', $data);
    }
    
    public function gallery($eventId,$imageFileId='') {       
        $this->galleryHandler = new Gallery_handler();        
        $eventId = $this->input->get('eventId');
        //Deleting the image
        if($imageFileId){
            $data['deleteGallery'] = $this->galleryHandler->deleteGallery($imageFileId);            
        }      
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['pageName'] = 'Event Dashboard';
        $data['pageTitle'] = 'MeraEvents | Gallery';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'gallery_view';
        $data['eventId'] = $eventId;
        $addGallery = $this->input->post('gallerySubmit');
        if ($addGallery) {
            $inputArray['type'] = 'eventgallery';
                $inputArray['eventId'] = $eventId;
                $data['insertedGallery'] = $this->galleryHandler->insertGallery($inputArray);
            }
        $request['eventId']=$eventId;
        $data['galleryImages'] =$this->galleryHandler->getEventGalleryList($request);   
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function addTermsAndCondition($eventId) {
        $inputArray['eventId'] = $eventId;
        $this->dashboardHandler = new Dashboard_handler();
        $update = $this->input->post('tncSubmit');
        if ($update) {            
            if(empty(strip_tags(str_replace('&nbsp;','', $this->input->post("tncDescription"))))){
                $inputArray['tncDescription']='';
            }else{
                $inputArray['tncDescription'] = $this->input->post("tncDescription");
				$inputArray['displaytnconpass'] = $this->input->post("displaytnconpass"); 
            }
            $multiEventCheck = $this->eventHandler->checkIsMultiEvent(array('eventId' => $eventId));
            if($multiEventCheck['status'] == TRUE && $multiEventCheck['masterEvent'] == TRUE){
                $childEventIdsRes = $this->eventHandler->getMultiEventChildIds(array('eventId' => $eventId));
                $childEventIds = $childEventIdsRes['response']['eventList'];
                $childEventIds[] = $eventId;
                foreach($childEventIds as $value){
                    $inputArray['eventId'] = $value;
                    $data['updateTnc'] = $this->dashboardHandler->updateTncDetails($inputArray);
                }
            }else{
                $data['updateTnc'] = $this->dashboardHandler->updateTncDetails($inputArray);
            }
        }
        $data['eventName'] = commonHelperGetEventName($eventId);
        $tncDetail = $this->dashboardHandler->getTncDetail($inputArray);
		//print_r($tncDetail); exit;
        if ($tncDetail['status'] && $tncDetail['response']['total'] > 0) {
            $data['organizertnc'] = $tncDetail['response']['eventData']['organizertnc'];
			$data['displaytnconpass'] = $tncDetail['response']['eventData']['displaytnconpass'];
        } else {
            $data['organizertnc'] = "";
        }
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'terms_condition_view';
        $data['pageName'] = 'Terms And Conditions';
        $data['pageTitle'] = 'MeraEvents | Add Terms And Conditions';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'tinymce/tinymce',
            $this->config->item('js_public_path') . 'customTmc',
            $this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function emailAttendees($eventId) {
       
        $this->dashboardHandler = new Dashboard_handler();
        $emailAttendeesSendMail = $this->input->post('emailAttendeesSendMail');
        $emailAttendeesSendTestMail = $this->input->post('emailAttendeesSendTestMail');
        if ($emailAttendeesSendMail || $emailAttendeesSendTestMail) {
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', -1);
            $inputArray=$this->input->post(); //Appending input fields values along wiht eventid and userid written above
            $inputArray['eventId'] = $eventId;
            $inputArray['userIds'] = getUserId();
            $response = $this->dashboardHandler->sendEmailToAttendees($inputArray);
            if($response['status']){
                $this->customsession->setData('emailAttendeeSuccessMessage', $response['response']['messages'][0]);
            }else{
               $this->customsession->setData('emailAttendeeErrorMessage', $response['response']['messages'][0]);
               if(isset($response['response']['failedEmails'])){
                $this->customsession->setData('failedEmails', $response['response']['failedEmails']);
               }
            }
            $redirectUrl = commonHelperGetPageUrl('dashboard-emailAttendees', $eventId);
            redirect($redirectUrl);
        }
        $data['eventName'] = commonHelperGetEventName($eventId);
        //Getting the user and ticket details to load in view
        $userInputArray['eventId'] = $eventId;
        $userInputArray['userIds'] = getUserId();
        $userAndTicketDetail = $this->dashboardHandler->getUserAndTicketDetail($userInputArray);
        $data['userName'] = $userAndTicketDetail['userName'];
        $data['email'] = $userAndTicketDetail['email'];
        $data['ticketDetails'] = $userAndTicketDetail['ticketDetails'];

        $data['hideLeftMenu'] = 0;
        $data['content'] = 'email_attendees_view';
        $data['pageName'] = 'Email Attendees';
        $data['pageTitle'] = 'Email Attendees';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/dashboard_configure',
            $this->config->item('js_public_path') . 'tinymce/tinymce',
            $this->config->item('js_public_path') . 'emailAttendeeTinyMce');
        $this->load->view('templates/dashboard_template', $data);
    }
    
    public function paymentMode($eventId) {
        $inputArray['eventId'] = $eventId;
        $this->dashboardHandler = new Dashboard_handler(); 
        $this->paymentGatewayHandler = new EventpaymentGateway_handler();
        $data['eventName'] = commonHelperGetEventName($eventId);        
        $update = $this->input->post('paymentSubmit');
        if ($update) {
            $multiEventCheck = $this->eventHandler->checkIsMultiEvent(array('eventId' => $eventId));
            if($multiEventCheck['status'] == TRUE){
                $childEventIdsRes = $this->eventHandler->getMultiEventChildIds(array('eventId' => $eventId));
                if($childEventIdsRes['status'] == FALSE || $childEventIdsRes['response']['total'] == 0){
                   $output['staus'] = FALSE;
                   $output['response']['messages'][] = ERROR_SOMETHING_WENT_WRONG;
                   $data['paymentGatewayOutput'] = $output;
                }
                $childEventIds = $childEventIdsRes['response']['eventList'];
                $childEventIds[] = $eventId;
                $inputArray+=$this->input->post();
                foreach($childEventIds as $value){
                    $inputArray['eventId'] = $value;
                    $data['paymentGatewayOutput'] = $this->paymentGatewayHandler->updateEventPaymentGatewayDetail($inputArray);
                }
            }else{
                $inputArray+=$this->input->post();
                $data['paymentGatewayOutput'] = $this->paymentGatewayHandler->updateEventPaymentGatewayDetail($inputArray);
            }
			//print_r($data['paymentGatewayOutput']); exit;
        }
        //Storing event gateway Ids for this event 
        $data['eventPaymentGateways']=$eventPaymentGateways = $this->eventHandler->getEventPaymentGateways($inputArray); 
		//print_r($data['eventPaymentGateways']); exit;       
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'payment_mode_view';
        $data['pageName'] = 'Payment Mode';
        $data['pageTitle'] = 'MeraEvents | Payment Mode';
        $data['jsArray'] = array(
        $this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $this->load->view('templates/dashboard_template', $data);
    }
    
    public function contactInfo($eventId) {
        $inputArray['eventId'] = $eventId;
        $data['eventName'] = commonHelperGetEventName($eventId);
        $contactDetails = $this->eventHandler->getcontactInfo($inputArray);
        if($contactDetails['status'] == FALSE || $contactDetails['response']['total'] == 0){
            $data['error'] = $contactDetails['response']['messages'][0];
        }else{
            $update = $this->input->post();
            if (isset($update) && $update['submit'] == Update ) {
                $update['extratxnreportingemails'] = array_filter( explode(",", $update['extratxnreportingemails']), 'strlen' );
                $update['moreEmails'] = array_filter( explode(",", $update['moreEmails']), 'strlen' );
                $update['extratxnreportingemails'] = implode(',', $update['extratxnreportingemails']);
                $update['moreEmails'] = implode(',', $update['moreEmails']);
                $update['eventId'] = $eventId;
                    if ($update) {
                         $multiEventCheck = $this->eventHandler->checkIsMultiEvent(array('eventId' => $eventId));
                        if($multiEventCheck['status'] == TRUE && $multiEventCheck['masterEvent'] == TRUE){
                            $childEventIdsRes = $this->eventHandler->getMultiEventChildIds(array('eventId' => $eventId));
                            $childEventIds = $childEventIdsRes['response']['eventList'];
                            $childEventIds[] = $eventId;
                            foreach($childEventIds as $value){
                                 $update['eventId'] = $value;
                                 $updateContactDetails = $this->eventHandler->updateContactInfo($update);
                                 $data['updateContactDetails']=$updateContactDetails;
                                 $data['message'] = $updateContactDetails['response']['messages'][0];
                            }
                        }else{
                            $updateContactDetails = $this->eventHandler->updateContactInfo($update);
                            $data['updateContactDetails']=$updateContactDetails;
                            $data['message'] = $updateContactDetails['response']['messages'][0];
                        }
                        $contactDetails = $this->eventHandler->getcontactInfo($inputArray);
                        $data['contactDetails'] = $contactDetails['response']['contactDetails'];
                    }
            }else{
                $data['contactDetails'] = $contactDetails['response']['contactDetails'];
            }
        }
        $data['content'] = 'contactinfo_view';
        $data['pageName'] = 'Contact Information';
        $data['pageTitle'] = 'MeraEvents | Contact Information';
        $data['eventId'] = $eventId;
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/jscolor',
                                 $this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $this->load->view('templates/dashboard_template', $data);
    }
    
    public function deleteRequest($eventId) {
        $inputArray['eventId'] = $eventId;
        $inputArray['eventIdList'] = array($eventId);
        
        //Select count of all child events for multi events
        $multiEventCheck = $this->eventHandler->checkIsMultiEvent(array('eventId' => $eventId));
        if($multiEventCheck['status'] == TRUE && $multiEventCheck['masterEvent'] == TRUE){
            $childEventIdsRes = $this->eventHandler->getMultiEventChildIds(array('eventId' => $eventId));
            if($childEventIdsRes['status'] == TRUE && $childEventIdsRes['response']['total'] > 0){
                $childEventIds = $childEventIdsRes['response']['eventList'];
                $childEventIds[] = $eventId;
                $inputArray['eventIdList'] = $childEventIds;
            }  
        }
                
        $this->eventsignupHandler = new Eventsignup_handler();
        $getSoldTicketCountResponse = $this->eventsignupHandler->getSoldTicketCount($inputArray);
        
        if($getSoldTicketCountResponse['response']['total']){
            $data['soldTicketCount'] = $getSoldTicketCountResponse['response']['total'];
        }
        
        $inputFormArray = $this->input->post('deleteSubmit');
        if ($inputFormArray) {
            $inputArray['comments']=$this->input->post('deleteComment');
            $data['output'] = $this->eventHandler->deleteRequest($inputArray);
        }
        
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['eventId'] = $eventId;
        
        
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'deleterequest_view';
        $data['pageName'] = 'Request for delete';
        $data['pageTitle'] = 'MeraEvents | Request for delete';   
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/deleterequest');
        $this->load->view('templates/dashboard_template', $data);
    }
    
    
    
    
	
	public function customFieldCuration($eventId, $customFieldId = 0){
		
		$data['curationValues'] = 0;
		$searchString = NULL;
		
        $inputArray['eventId'] = $eventId;
        $data['eventName'] = commonHelperGetEventName($eventId);
        /*$tickets = $this->ticketHandler->getTicketName($inputArray);
        if($tickets['status'] == TRUE && $tickets['response']['total'] == 0){
            $data['status'] = false;
            $data['messages'] = $tickets['response']['messages'][0];
        }*/
		
		$inputCustomfields['eventId'] = $eventId;
        // $inputCustomfields['collectMultipleAttendeeInfo']=0;
        $inputCustomfields['allfields'] = 1;
        $inputCustomfields['statuslabels'] = 1;
		$inputCustomfields['customFieldId'] = $customFieldId;
		
        $this->configure_handler = new Configure_handler();
        $customfieldsResponse = $this->configure_handler->getCustomFields($inputCustomfields);
		//print_r($customfieldsResponse); exit;
		
		$data['error'] = $customfieldsResponse['response']['messages'][0];
        if ($customfieldsResponse['status'] && $customfieldsResponse['response']['total'] > 0) {
            $data['customFieldData'] = $customfieldsResponse['response']['customFields'];
			if(count($data['customFieldData']) > 0){
				$fieldType = $data['customFieldData'][0]['fieldtype'];
				if($fieldType != 'textbox'){
					$data['error'] = "Sorry, You can't add curation list to this custom field.";
				}else{
					$data['error'] = NULL;
					$data['customFieldname'] = $data['customFieldData'][0]['fieldname'];
					$data['CfTicketName'] = $data['customFieldData'][0]['ticketName'];
					$data['cflevel'] = $data['customFieldData'][0]['fieldlevel'];
				}
				
			}
        }
		
		
		if(strlen($data['error']) == 0){
			
			/*fetching curation data from DB*/
			require_once(APPPATH . 'handlers/eventcustomvalidator_handler.php');
			$customvalidatorHandler = new Eventcustomvalidator_handler();
			
			$postFormData = $this->input->post();
			//$ticketId = $this->input->post('ticketId');
			
			
			
			if ($postFormData && isset($postFormData['curationForm'])) {
				
				$formType = $postFormData['curationForm'];
				
				if($formType == "searchCuration"){
					$searchString = trim($postFormData['curationSearchKey']);
				}
				elseif($formType == "uploadCuration"){
					$CVinputArray['customFieldId'] = $customFieldId;
					$CVinputArray['eventId'] = $eventId;
					$csvadding = $customvalidatorHandler->uploadAndAddCurationValues($CVinputArray);
				  	if ($csvadding['status']) { 
					$data['status'] = true;
					$successMessage=$csvadding['response']['messages'][0];
					$this->customsession->setData('curationSuccessMessage', $successMessage);
					$redirectUrl = commonHelperGetPageUrl('dashboard-curation', $eventId."&".$customFieldId);
					redirect($redirectUrl);
					} else {
						$this->customsession->setData('curationErrorMessage', $csvadding['response']['messages'][0]);
						$redirectUrl = commonHelperGetPageUrl('dashboard-curation', $eventId."&".$customFieldId);
						 
					} 
				}
				 
			}
			
			
			
			
			/*fetching already available records*/
			$curationInput = array("eventId"=>$eventId, "customFieldId"=>$customFieldId,"searchString" => $searchString);
			$curationValues = $customvalidatorHandler->getCustomFieldCurationValues($curationInput);
			
			if ($curationValues['status'] && $curationValues['response']['total'] > 0) {
				$data['curationValues'] = $curationValues['response']['curationDetails'];
			}
			/*fetching already available records*/
		
		
		}
        
		
		$data['customFieldId'] = $customFieldId;
		$data['eventId'] = $eventId;
		$data['searchString'] = $searchString;
        
        $data['pageName'] = 'Custom Field Curation';
        $data['pageTitle'] = 'MeraEvents | Custom Field Curation';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'customfield_curation_view';
        $data['jsArray'] = array(
			$this->config->item('js_public_path') . 'jquery.validate',
			$this->config->item('js_public_path') . 'additional-methods',
            $this->config->item('js_public_path') . 'dashboard/customfieldslisting'
        );
		
		//print_r($data); exit;
        $this->load->view('templates/dashboard_template', $data);
    
		
		
	}
        
          // Checking wether all details are present or not to send invoice
        public function invoiceDetailsValidation(){
        
        $inputArray = array();
        $inputArray['eventId'] = $this->input->post('eventID');
            
        $this->eventHandler = new Event_handler();
        $eventDetails = $this->eventHandler->getEventDetails($inputArray);
          
        $inputArray['userId'] = $eventDetails['response']['details']['ownerId'];
        $thisEventOwner = false;
        if(getUserId() == $eventDetails['response']['details']['ownerId']){
            $thisEventOwner = true;
        }
        //check the user status & event status
        $inputArrayAdmin['userIds'] = getUserId();
        
        
        $this->userHandler = new User_handler();
        $userData = $this->userHandler->getUserInfo($inputArrayAdmin);
        
        
        $isAdmin = false;
        if ($userData['status'] && $userData['response']['userData']['usertype'] == "superadmin") {
            $isAdmin = true;
        }
        
        
        
        $this->organizerbankdetailHandler = new Organizerbankdetail_handler();
        $bankDetails = $this->organizerbankdetailHandler->getBankDetails($inputArray);
        
        
        $inputArray['major'] = 1;
        
        $this->organizerHandler = new Organizer_handler();
        $companyDetails = $this->organizerHandler->getCompanyDetails($inputArray);
       
        if($bankDetails['response']['total'] > 0 && $companyDetails['response']['total'] > 0    ){
                /*
                if(empty($bankDetails['response']['bankDetails']['0']['servicetaxnumber']))
                {
                    if($isAdmin == true || $thisEventOwner == true){
                    $errorDetails[] = "Please fill service tax number at <a href=".commonHelperGetPageUrl('user-bankdetail')."> Bank Details</a>.";
                        
                      //  $errorDetails[] = "<label>Service Tax Number</label> <input type='text' class='textfield valid' value=''> Please fill service tax number at <a href=".commonHelperGetPageUrl('user-bankdetail')."> Bank Details</a>.";
                    }else{
                    $errorDetails[] = "Please request organizer to update service tax number at Bank Details under profile menu.";    
                    }
                    
                }*/
            if(empty($bankDetails['response']['bankDetails']['0']['gst']))
                {
                    if($isAdmin == true || $thisEventOwner == true){
                    $errorDetails[] = "Please fill GST at <a href=".commonHelperGetPageUrl('user-bankdetail')."> Bank Details</a>.";
                        
                      //  $errorDetails[] = "<label>Service Tax Number</label> <input type='text' class='textfield valid' value=''> Please fill service tax number at <a href=".commonHelperGetPageUrl('user-bankdetail')."> Bank Details</a>.";
                    }else{
                    $errorDetails[] = "Please request organizer to update GST at Bank Details under profile menu.";    
                    }
                    
                }
                
                if(empty($bankDetails['response']['bankDetails']['0']['accountname']))
                {
                    if(empty($companyDetails['response']['companyDetails']['companyname'])){
                        if($isAdmin == true || $thisEventOwner == true){
                        $errorDetails[] = "Please fill account name at <a href=".commonHelperGetPageUrl('user-companyprofile')."> Company Details</a>.";
                        }else{
                        $errorDetails[] = "Please request organizer to update account name at Company Details under Company Details menu.";    
                        }
                    }
                }
                
            }
           
            // $errorDetails[] = "Please fill service tax number";
            if(count($errorDetails) > 0){
                $output['status'] = FALSE;
                $output["response"]['messages'] = $errorDetails;
                $output['statusCode'] = STATUS_OK;
                $output['response']['total'] = 0;
               
            } else{
                $output['status'] = TRUE;
                $output['response']['messages'] = $errorDetails;
                $output['statusCode'] = STATUS_OK;
                $output['response']['total'] = 1;
               
            }
            
        echo json_encode($output);
        
        }
        
        function saveWidgetSettings(){
            $inputFormArray = $this->input->post();
            require_once(APPPATH . 'handlers/widgetsettings_handler.php');
            $widgetsettingsHandler = new Widgetsettings_handler();
            $output=$widgetsettingsHandler->saveWidgetSettings($inputFormArray);
            echo json_encode($output);
        }
        
        
        public function stagedEvent($eventId) {
                $inputArray['eventId'] = $eventId;
                $data = array();
                $inputArray['eventIdList'] = array($eventId);
        
                $this->eventsignupHandler = new Eventsignup_handler();
                $getSoldTicketCountResponse = $this->eventsignupHandler->getSoldTicketCount($inputArray);

                if($getSoldTicketCountResponse['response']['total']){
                    $data['soldTicketCount'] = $getSoldTicketCountResponse['response']['total'];
                }
                
                
                $data['eventTitle'] = commonHelperGetEventName($eventId);
                $this->organizerbankdetailHandler = new Organizerbankdetail_handler();
                 $this->organizerHandler = new Organizer_handler();
                 $this->eventsignupHandler = new Eventsignup_handler();


                $ticketOptions = $this->eventHandler->getTicketOptions($inputArray);

                $this->eventHandler = new Event_handler();
                $eventDetails = $this->eventHandler->getEventDetails($inputArray);
                $inputArrayUser['userId'] = $eventDetails['response']['details']['ownerId'];


                $thisEventOwner = false;
                if(getUserId() == $eventDetails['response']['details']['ownerId']){
                    $thisEventOwner = true;
                }
                //check the user status & event status
                $inputArrayAdmin['userIds'] = getUserId();


                $this->userHandler = new User_handler();
                $userData = $this->userHandler->getUserInfo($inputArrayAdmin);


                $isAdmin = false;
                if ($userData['status'] && $userData['response']['userData']['usertype'] == "superadmin") {
                    $isAdmin = true;
                }


                if ($ticketOptions['status'] == TRUE && $ticketOptions['response']['total'] > 0) {

                    $update = $this->input->post('submit');
                    $postVars = $this->input->post();
                    if ($update) {

                        
                        if (isset($postVars['paymentstage']) && ($postVars['paymentstage'] == 1 || $postVars['paymentstage'] == 2)) {
                            $inputArray['stagedevent'] = 1;
                            if (isset($postVars['paymentstage']) && $postVars['paymentstage'] == 2) {
                                $inputArray['paymentstage'] = 2;
                            } else if($postVars['paymentstage'] == 1) {
                                $inputArray['paymentstage'] = 1;
                            }
                        } else {
                            $inputArray['paymentstage'] = 0;
                            $inputArray['stagedevent'] = 0;
                        }
                        
                        
                        
                        
                        $updateeventSettings = $this->eventHandler->updateStagedSettings($inputArray);
                        $data['ticketSettings']=$updateeventSettings;
                        $data['message'] = $updateeventSettings['response']['messages']['0'];
                        $ticketOptions = $this->eventHandler->getTicketOptions($inputArray);

                    }




                        

                        


                    $ticketOptions['response']['ticketingOptions']['eventID'] = $eventId;
                    $data['ticketOptions'] = $ticketOptions['response']['ticketingOptions'];

                     $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/ticketOptions');
                    $data['content'] = 'staged_event_view';
                    $data['pageName'] = 'Event Types';
                    $data['pageTitle'] = 'MeraEvents | Event Types';
                    $data['hideLeftMenu'] = 0;

                    $this->load->view('templates/dashboard_template', $data);
                } else {
                    $redirectUrl = commonHelperGetPageUrl('dashboard-myevent');
                    redirect($redirectUrl);
                    $data['ticketOptionsMessage'] = $ticketOptions['response']['messages'][0];
                }
    }

    public function fbPixel($eventId){
        $inputArray['facebookpixelcode'] = $this->input->post("facebookpixelcode");
        $searchword = 'connect.facebook.net';

        $inputArray['eventid'] = $eventId;
        $this->configure_handler = new Configure_handler();
        if($this->input->post('submit')){
        $checkcode=preg_replace('/[^A-Za-z0-9\-\(:._\ )]/', '', $inputArray['facebookpixelcode']);
        $checkExist = strpos($checkcode,'connect.facebook.neten_USfbevents.js');
        if($checkExist > 0){
            $data['updateTnc'] = $this->configure_handler->updateFbPixel($inputArray);
        }else{
                $data['updateTnc'] = array();
                $data['updateTnc']['status'] = FALSE;
                $data['updateTnc']['response']['messages'][0] = 'Please Enter Valid Code';
            }
        }
        $data['getfbPixel'] = $this->configure_handler->getFbPixel($inputArray);
                    $data['content'] = 'fb_pixel_code';
                    $data['pageName'] = 'Facebook Pixel Code';
                    $data['pageTitle'] = 'MeraEvents | FaceBook Pixel Code';
                    $data['hideLeftMenu'] = 0;

                    $this->load->view('templates/dashboard_template', $data);
    }

    public function gtm($eventId){
        $inputArray['gtm'] = $this->input->post("gtm");
        $inputArray['eventid'] = $eventId;
         $this->configure_handler = new Configure_handler();
         if($this->input->post('submit')){
             $checkcode=preg_replace('/[^A-Za-z0-9\-\(:._\ )]/', '', $inputArray['gtm']);

        $checkExist = strpos($checkcode,'www.googletagmanager.com');
        if($checkExist > 0){
        $data['updateTnc'] = $this->configure_handler->updateGTM($inputArray);
         }else{
                $data['updateTnc'] = array();
                $data['updateTnc']['status'] = FALSE;
                $data['updateTnc']['response']['messages'][0] = 'Please Enter Valid Code';
            }
         }
         $data['getGtmCode'] = $this->configure_handler->getGTM($inputArray);
                    $data['content'] = 'gtm_code';
                    $data['pageName'] = 'Google Tag Manager';
                    $data['pageTitle'] = 'MeraEvents | Google Tag Manager';
                    $data['hideLeftMenu'] = 0;

                    $this->load->view('templates/dashboard_template', $data);
    }
    
    public function enableExternalMeetingLink($eventid){
        $this->configure_handler = new Configure_handler();
        $inputArray['eventid'] = $eventid;
        $checkOnlineEvent = $this->configure_handler->checkEventMode($inputArray);
        if($checkOnlineEvent[0]['eventmode'] == 0){
            $data['eventModeAlert']['status'] = FALSE;
            $data['eventModeAlertMessage'] = 'Something Went Wrong';
            $this->customsession->setData('eventModeAlert', $data);
            $redirectUrl = commonHelperGetPageUrl('dashboard-eventhome', $eventid);
            redirect($redirectUrl);
        }
        if($this->input->post('submit')){
            //$inputArray['zoomStatus'] = $this->input->post('enablezoom');
            $inputArray['meetingUrl'] = $this->input->post('meetingUrl');
            $data['status'] = true;
            $data['updateZoomStatus'] = $this->configure_handler->updateZoomStatus($inputArray);
            $this->customsession->setData('paymentModeMessage', $data);
        }
        $data['eventName'] = commonHelperGetEventName($eventid);
        $data['getZoomDetails'] = $this->configure_handler->getZoomDetails($inputArray);
       // echo '<pre>';print_r($data);exit;
                    $data['content'] = 'meeting_enable_view';
                    $data['pageName'] = 'Zoom Enable';
                    $data['pageTitle'] = 'MeraEvents | Meeting Link';
                    $data['hideLeftMenu'] = 0;

                    $this->load->view('templates/dashboard_template', $data);
    }

}

?>