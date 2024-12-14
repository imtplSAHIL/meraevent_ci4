<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once (APPPATH . 'handlers/ticketgroups_handler.php');
require_once(APPPATH . 'handlers/ticketgroupmapping_handler.php');
require_once(APPPATH . 'handlers/ticket_handler.php');

class Ticketgroups extends CI_Controller {

    var $ticketgroupHandler;
    var $ticketgroupmappingHandler;

    public function __construct() {
        parent::__construct();
        $this->ticketgroupHandler = new ticketgroups_handler();
        $this->ticketgroupmappingHandler = new ticketgroupmapping_handler();
    }

    //for showing create  Groups of tickets..page and all ticket including groped 
    //also use for editing purpose
    function addgroup($eventId, $groupid) {

        $input['eventId'] = $eventId;
        $this->ticketHandler = new ticket_handler();
        $eventTicketData = $this->ticketHandler->getTicketName($input);
        if ($eventTicketData['status'] == 0 || $eventTicketData['response']['total'] == 0) {
           
            commonHelperRedirect(commonHelperGetPageUrl('dashboard-ticketGroupig', $eventId));
        }

        $totalTicketIds = array();
        $totalTicketIdName = array();
        foreach ($eventTicketData['response']['ticketName'] as $key => $value) {
            $totalTicketIds[] = $value['id'];
            $totalTicketIdName[$value['id']]['ticketid'] =$value['id'];
            $totalTicketIdName[$value['id']]['TicketName'] =$value['name'];
        }
        
       
        //for getting All grouped and un grouped data
        $order = 1;
        $groupedTicketIds = array();
        $input['ticketIds']= $totalTicketIds;
        $groupedTicketIdsName = $this->getGroupedTicketIdsName($input);
        if ($groupedTicketIdsName['totalTicketData'] > 0) {
            $data['inGroupTicketData'] = $groupedTicketIdsName['inGroupTicketData'];
            $data['outGroupTicketData'] = $groupedTicketIdsName['outGroupTicketData'];
            $order += $groupedTicketIdsName['inGroupTotalTicket'];
        }
        else
        {
            $data['outGroupTicketData']['tickets'] = $totalTicketIdName;
        }
        
    
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['pageTitle'] = 'Add New Group';
        $data['formAction'] = commonHelperGetPageUrl('dashboard-CreateNewTicketGroup');
        
        if (isset($groupid))
        {//for editing group
            $selectedGroupData = array();
            $InputForTicket['ticketGroupIds'][] = $groupid;
            $InputForTicket['eventId'] = $eventId;
            $selectedGroupData = $this->ticketgroupmappingHandler->getGroupTickets($InputForTicket);
            
            foreach($selectedGroupData['response']['grouptickets'] as $key=>$value)
            {
                if($value['TicketName']=='')
                {
                    unset($selectedGroupData['response']['grouptickets'][$key]);
                    $selectedGroupData['response']['total']--;
                }
            }
                
            $data['selectedGroup'] = $selectedGroupData['response']['grouptickets'];
            foreach($data['inGroupTicketData'] as $key=>$value)
            {
                if($value['id'] == $groupid)
                {
                    unset($data['inGroupTicketData'][$key]);
                }
            }
            
            $InputforName['eventId'] = $eventId;
            $InputforName['groupId'] = $groupid;

            $groupData = $this->ticketgroupHandler->getTicketGroups($InputforName);
            $data['groupName'] = $groupData['response']['ticketgroups'][0]['name'];
            $order = $groupData['response']['ticketgroups'][0]['order'];
            $maxticketcategories = $groupData['response']['ticketgroups'][0]['maxticketcategories'] > 0 ? $groupData['response']['ticketgroups'][0]['maxticketcategories'] :'' ;
            $data['pageTitle'] = 'Edit Group';
            $data['formAction'] = commonHelperGetPageUrl('dashboard-editTicketGroup') . $eventId;
            $data['edit'] = 1;
            $data['groupId'] = $groupid;
        }
        $data['order'] = $order;
        $data['maxticketcategories'] = $maxticketcategories;
        $data['content'] = 'add_ticketgroup_view';
        $data['hideLeftMenu'] = 0;
        $data['eventId'] = $eventId;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/ticket-grouping');
        $this->load->view('templates/dashboard_template', $data);
    }

    //function for creating New Ticket Groups..Of event 
    public function createNewTicketGroup() {
        $inputArray = $this->input->post();
        $ticketData = $this->ticketgroupHandler->insertNewTicketGroup($inputArray);
        
        if ($ticketData['status'] == '' || $ticketData['status'] == 0) {
            $this->session->set_flashdata('errorMsg', $ticketData['response']['messages'][0]);
            commonHelperRedirect(commonHelperGetPageUrl('dashboard-add_TicketGroup_View', $inputArray['eventId']));
        }
        $this->session->set_flashdata('successMsg', $ticketData['response']['messages']);
        commonHelperRedirect(commonHelperGetPageUrl('dashboard-ticketGroupig', $inputArray['eventId']));
    }

    //function for editing of Ticket Group
    public function editTicketGroup() {
        $inputArray = $this->input->post();
        $result = $this->ticketgroupHandler->editGroup($inputArray);
        if ($result['status'] == 0 || $result['status'] == '') {
            $this->session->set_flashdata('errorMsg', $result['response']['messages']);
            commonHelperRedirect(commonHelperGetPageUrl('dashboard-add_TicketGroup_View', $inputArray['eventId'] . '/' . $inputArray['groupId']));
        }

        $this->session->set_flashdata('successMsg', $result['response']['messages']);
        commonHelperRedirect(commonHelperGetPageUrl('dashboard-ticketGroupig', $inputArray['eventId']));
    }

    // getting Ticket Groups name and order  with All TicketIds and Ticket Names of each group
    public function groupslist($eventId) {
        $input['eventId'] = $eventId;
        
        $this->form_validation->reset_form_rules();
        $this->form_validation->pass_array($input);
        $this->form_validation->set_rules('eventId', 'eventId', 'is_natural_no_zero');

        if ($this->form_validation->run() == FALSE) {
            $response = $this->form_validation->get_errors();
            $output['status'] = FALSE;
            $output['response']['messages'] = $response['message'];
            $output['statusCode'] = STATUS_BAD_REQUEST;
            commonHelperRedirect(commonHelperGetPageUrl('dashboard-eventhome'));
        }

        $data = $this->ticketgroupHandler->getGroupsWithTickets($input);
        
        $data['eventName'] = commonHelperGetEventName($eventId);
        $data['content'] = 'ticketgrouping_list_view'; //'add_ticketgroup_view';
        $data['hideLeftMenu'] = 0;
        $data['eventId'] = $eventId;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/ticket-grouping');

        $this->load->view('templates/dashboard_template', $data);
    }

    public function delete($eventId, $groupId) {

        $inputArray['eventId'] = $eventId;
        $inputArray['groupId'] = $groupId;

        $result = $this->ticketgroupHandler->deleteTicketGroup($inputArray);

        if ($result['status'] == 1) {
            $this->session->set_flashdata('successMsg', $result['response']['messages']);
            commonHelperRedirect(commonHelperGetPageUrl('dashboard-ticketGroupig', $eventId));
        }
    }

    public function getGroupedTicketIdsName($input) {
     
        $inGroupTicketData = array();
        $outGroupTicketData = array();
        $inGroupTotalTicket = 0;
        $outGroupTotalTicket = 0;
        $groupedTicket = $this->ticketgroupHandler->getGroupsWithTickets($input);
        
        if ($groupedTicket['response']['total'] > 0)
        {
            foreach ($groupedTicket['response']['ticketgroups'] as $key => $value)
            {
                if($value['id']==0)
                {
                    $outGroupTicketData = $value;
                }
                else
                {
                    $inGroupTicketData[] = $value;
                }
            }
        }
        $output['inGroupTicketData'] = $inGroupTicketData;
        $output['outGroupTicketData'] =  $outGroupTicketData;
        $output['inGroupTotalTicket'] = count($inGroupTicketData);
        $output['outGroupTotalTicket'] = count($outGroupTicketData);
        $output['totalTicketData'] = $groupedTicket['response']['total'];
        return $output;
    }

}

?>