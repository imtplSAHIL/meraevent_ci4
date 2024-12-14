<?php

/**
 * Maintaing promoter related data
 *
 * @author     Qison dev team
 * @copyright  2015-2005 The PHP Group
 * @version    CVS: $Id:$
 * @since      File available since Sprint 2
 * @deprecated File deprecated in Release 2.0.0
 */
/*
 * Place includes, constant defines and $_GLOBAL settings here.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
require (APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/promoter_handler.php');
require_once (APPPATH . 'handlers/affiliateresouce_handler.php');
require_once (APPPATH . 'handlers/file_handler.php');
class Promote extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->promoterHandler = new Promoter_handler();
        $this->fileHandler = new File_handler();
    }

    /*
     * Function to get the State list
     *
     * @access	public
     * @param		Get contains
     * 				KeyWord - String
     * 				Limit - Integer
     * @return	array
     */

    public function setStatus_post() {
        $id = $this->input->post('id');
        $output = $this->promoterHandler->setPromoterStatus($id);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function offlineTickets_get() {
        $inputArray = $this->get();
        $output = $this->promoterHandler->offlineTicketsByEvent($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function ticketsData_get() {
        $inputArray = $this->get();
        $output = $this->promoterHandler->getTicketData($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function addGlobalPromoter_post() {
        $inputArray = $this->input->post();
        $output = $this->promoterHandler->insertGlobalPromoter($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function checkGlobalCodeAvailability_post() {
        $inputArray = $this->input->post();
        $output = $this->promoterHandler->checkPromoterCode($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function getCSVData_post() {
        $inputArray = $this->input->post();
        //$inputArray=array_merge($inputArray,$_FILES);
        require_once(APPPATH . 'handlers/pastattviraltickets_handler.php');
        $this->pastattviraltickets_handler = new pastAttViraltickets_handler();
        $output = $this->pastattviraltickets_handler->getCSVData($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function insertOrgPastAttendees_post() {
        $inputArray = $this->input->post();
        //$inputArray=array_merge($inputArray,$_FILES);
        require_once(APPPATH . 'handlers/pastattviraltickets_handler.php');
        $this->pastattviraltickets_handler = new pastAttViraltickets_handler();
        $output = $this->pastattviraltickets_handler->insertOrgPastAttendees($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    /*
     *  Sending emails to Past attendees
     */

    public function sendEmailToPastAttendees_get() {
        //include_once APPPATH.'../crons/commondbdetails.php';
        require_once(APPPATH . 'handlers/pastattviraltickets_handler.php');
        $this->pastattviraltickets_handler = new pastAttViraltickets_handler();
        //$output=$this->pastattviraltickets_handler->pastAttMarketing($inputArray);
        $response = $this->pastattviraltickets_handler->pastAttMarketing();
        //print_r($response);exit;
        if ($response['status'] && $response['response']['total'] > 0) {
            require_once(APPPATH . 'handlers/emailrequest_handler.php');
            $emailrequest_handler = new Emailrequest_handler();
            //$userCount= $response['response']['userCount'];
            $eventIds = $response['response']['eventIds'];
            $EmailRequestDetails = $response['response']['EmailRequestDetails'];
            $eventId = $EmailRequestDetails[0]['eventid'];
            $organizerId = $EmailRequestDetails[0]['organizerid'];
            $ERId = $EmailRequestDetails[0]['id'];
            //$limit = PAST_ATTENDEE_USER_LIMIT;
            $insertData['eventids'] = $eventIds;
            $insertData['eventid'] = $eventId;
            //$loopCnt = ceil($userCount / $limit);
            $inputSingleUser['eventId'] = $eventIds;
            //for ($i = 0; $i < $loopCnt; $i++) {
            $insertData['endcount'] = $EmailRequestDetails[0]['attendeesentcount'];
            $insertResponse = $this->pastattviraltickets_handler->getUserData($insertData);
            //print_r($insertResponse);exit;
            if ($insertResponse['status'] && $insertResponse['response']['total'] > 0) {
                $esUsersDetails = $insertResponse['response']['userData'];
                $inputSingleUser['userData'] = $esUsersDetails;
                $inputSingleUser['eventId'] = $eventId;
                $insResp=$this->pastattviraltickets_handler->insertPastAttUser($inputSingleUser);
                if($insResp['status']){
                    $inputER['id'] = $ERId;
                    $inputER['attendeesentcount'] = $EmailRequestDetails[0]['attendeesentcount'] + $insertResponse['response']['total'];
                    $erResponse = $emailrequest_handler->update($inputER);
                    $responseArray = array('response' => $erResponse['response']);
                    $this->response($responseArray, $erResponse['statusCode']);
                }else{
                    $responseArray = array('response' => $insResp['response']);
                    $this->response($responseArray, $insResp['statusCode']);
                }
            } elseif ($insertResponse['status'] && $insertResponse['response']['total'] == 0) {
                $insertPastC['organizerId'] = $organizerId;
                $insertPastC['endcount'] = $EmailRequestDetails[0]['pastcontactssentcount'];
                $pastContacts = $this->pastattviraltickets_handler->getPastContacts($insertPastC);
                //var_dump($pastContacts);exit;
                if ($pastContacts['status'] && $pastContacts['response']['total'] > 0) {
                    $orgContacts = $pastContacts['response']['contacts'];
                    $inputSingleUser['userData'] = $orgContacts;
                    $inputSingleUser['eventId'] = $eventId;
                    $inputSingleUser['organizercontacts'] = true;
                    $insResp=$this->pastattviraltickets_handler->insertPastAttUser($inputSingleUser);
                    if($insResp['status']){
                        $inputER['id'] = $ERId;
                        $inputER['pastcontactssentcount'] = $EmailRequestDetails[0]['pastcontactssentcount'] + $pastContacts['response']['total'];
                        $erResponse = $emailrequest_handler->update($inputER);
                        $responseArray = array('response' => $erResponse['response']);
                        $this->response($responseArray, $erResponse['statusCode']);
                    }else{
                        $responseArray = array('response' => $insResp['response']);
                        $this->response($responseArray, $insResp['statusCode']);
                    }
                } elseif ($pastContacts['status'] && $pastContacts['response']['total'] == 0) {
                    $inputER['id'] = $ERId;
                    $inputER['emailstatus'] = 1;
                    $erResponse = $emailrequest_handler->update($inputER);
                    $responseArray = array('response' => $erResponse['response']);
                    $this->response($responseArray, $erResponse['statusCode']);
                } else {
                    $responseArray = array('response' => $pastContacts['response']);
                    $this->response($responseArray, $pastContacts['statusCode']);
                }
            } else {
                $responseArray = array('response' => $insertResponse['response']);
                $this->response($responseArray, $insertResponse['statusCode']);
            }
            //}
        } else {
            $responseArray = array('response' => $response['response']);
            $this->response($responseArray, $response['statusCode']);
        }
    }
    
    
    public function getPromoterbyEmail_post(){
        $inputArray = $this->input->post();
        require_once(APPPATH . 'handlers/user_handler.php');
        $userHandler = new User_handler();

        $inputArray['email']=$this->input->post('email');
        $userDetails = $userHandler->getUserData($inputArray);
        $inputs['userid']=$userDetails['response']['userData']['id'];
        $promoterDetails=$this->promoterHandler->getPromoterDataById($inputs);
        $responseArray = array('response' => $promoterDetails['response']);
        $this->response($responseArray, $promoterDetails['statusCode']);
        
    }
    
    public function setOrgStatus_post() {
        $id = $this->input->post('id');
        $orgid = $this->input->post('orgid');
        $output = $this->promoterHandler->setOrgPromoterStatus($id,$orgid);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }
    public function setResourceStatus_post() {
        $affiliateresouceHandler = new Affiliateresouce_handler();
        $resourceInput['id'] = $this->input->post('id');
        $resourceInput['eventId'] = $this->input->post('eventid');
        $resourceInput['statuschange']=TRUE;
        $output=$affiliateresouceHandler->updateResource($resourceInput);
        $responseArray = array('response' => $output['response'],'status'=>$output['status']);
        $this->response($responseArray, $output['statusCode']);
    }
    public function attendeeSampleCsv_get(){
       
        $eventId = $this->get('eventId');
        $ticketId = $this->get('ticketId');
        $ticketOptionInput['eventId'] = $eventId;
        $ticketOptionInput['eventDetailReq'] = false;
        $eventHandler=new Event_handler();
        
        $ticketOptionArray = $eventHandler->getTicketOptions($ticketOptionInput);
        $collectMultipleAttendeeInfo = $ticketOptionArray['response']['ticketingOptions'][0]['collectmultipleattendeeinfo'];
        
        $customFieldInput['eventId'] = $eventId;
        $customFieldInput['collectMultipleAttendeeInfo'] = $collectMultipleAttendeeInfo;
        $customFieldInput['disableSessionLockTickets'] = true;
        $customFieldInput['offlineFields'] = false;
        $customFieldInput['ticketsettinginvoice'] = 1;
        $configureHandler=new Configure_handler();
        $eventCustomFieldsArr = $configureHandler->getCustomFields($customFieldInput);
        $headerarray=array();
        foreach($eventCustomFieldsArr['response']['customFields'] as $key => $val){
            if(!in_array($val['fieldname'], $headerarray)){
                $headerarray[]=$val['fieldname'];
            }
        }
        $headerarray[]='Quantity';
        $headerarray[]='Discount Code';
        $filename = appendTimeStamp('sample_' . $eventId . '.csv');
        $res1 = is_dir($this->config->item('file_upload_temp_path'));
        if ($res1 != 1) {
            mkdir($this->config->item('file_upload_temp_path'), 0777, true);
        }
        $handle = fopen($this->config->item('file_upload_temp_path') . $filename, 'wa+');
        $header = $headerarray; 
        fputcsv($handle, $header);        
        fclose($handle);
        $attendExcel = file_exists($this->config->item('file_upload_temp_path')."/".$filename);
        if($attendExcel){
            $responseArray = array('response' => $filename,'status'=>1);
            $this->response($responseArray, 200);
        }else{
            echo false;
        }
        exit;
    }
    
    function downloadAttendeeSampleCsv_get(){
        $filename = $this->get('fileName');
        $filename = $this->config->item('file_upload_temp_path').$filename.".csv";
        $this->customsession->unSetData('errorCsvFile');
        
        ob_end_clean();
        header('Content-Description: File Transfer');
        header('Content-Type: "application/octet-stream"');
        header('Content-Disposition: attachment; filename='.basename($filename));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit;
    }
    
    public function customImage_post() {
       
        $postvalue = $this->input->post();
        $uploadFileName = str_replace(' ', '_',  $_FILES['upload_image']['name'][0]);
        
        $input = array('sourcepath' => $_FILES['upload_image']['tmp_name'][0], 'filename' => $uploadFileName, 'filetype' => $_FILES['upload_image']['type'][0], 'destinationpath' => 'organizerbanners');
       
        $fileResponse = $this->fileHandler->uploadToS3($input);
        
        //$this->response($fileResponse, $output['statusCode']);
        if($fileResponse['status']==1){
            $responseArray = array('imagepath' => $fileResponse['response']['uploadPath']);
            $this->response($responseArray, $fileResponse['status']);
        }else{
            $responseArray = array();
            $this->response($responseArray, $fileResponse['status']);
        }
        exit;
    }
}
