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

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require (APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/reports_handler.php');

class Reports extends REST_Controller {

    var $reportsHandler;

    public function __construct() {
        parent::__construct();
        $this->reportsHandler = new Reports_handler();
    }

    /*
     * Function to get the transaction list
     *
     * @access	public
     * @param		Get contains
     * 				eventid - Integer
     *                              reporttype - string
     *                              transactiontype - string
     * 				page - Integer
     * @return	transactionList
     */

    public function getTransactions_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->getTransactions($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    /*
     * Function to get the transaction list
     *
     * @access	public
     * @param		Get contains
     * 				eventid - Integer
     *                              reporttype - string
     *                              transactiontype - string
     * 				page - Integer
     * @return	transactionList
     */

    public function exportTransactions_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->exportTransactions($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function emailTransactions_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->emailTransactions($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function getTransactionsTotal_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->getGrandTotal($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function getReportDetails_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->getReportDetails($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function getExportReports_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->getExportReports($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function salesEffortReports_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->getSalesEffortData($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function getWeekwiseSales_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->getWeekwiseSales($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }

    public function downloadImages_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->getFileUploadImages($inputArray);
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }
    
    public function updateCustomFieldsData_post() {
        $inputArray = $this->input->post();
        $output = $this->reportsHandler->updateCustomFieldsData($inputArray);
        //print_r($output);exit;
        $responseArray = array('response' => $output['response']);
        $this->response($responseArray, $output['statusCode']);
    }
	
    public function updateOrgCommentData_post() {
        $inputArray = $this->input->post();
        $this->commentsHandler = new Comment_handler();
        $output = $this->commentsHandler->insertComment($inputArray);      
        $responseArray = array('response' => $output['response'], 'status' =>$output['status'] );
        $this->response($responseArray, $output['statusCode']);
    }
    function updateSubUserStatus_post()
    {
        $inputArray = $this->input->post();
        $userId = $this->customsession->getUserId();
        $this->load->model('Organizersubuser_model');
        $this->Organizersubuser_model->resetVariable();
        $where[$this->Organizersubuser_model->userid] = $userId;
        $where[$this->Organizersubuser_model->subuserid] = $inputArray['subuserid'];
        $updateArray[$this->Organizersubuser_model->status] = $inputArray['status'];
        $this->Organizersubuser_model->setWhere($where);
        $this->Organizersubuser_model->setInsertUpdateData($updateArray);
        $updateStatus = $this->Organizersubuser_model->update_data();
        $response = array('status' => $updateStatus, 'value' => $inputArray['status'], 'subuserid' => $inputArray['subuserid']);
        $output['status'] = TRUE;
        $output["response"]["updatesubuserResponse"] = $response;
        $output["response"]["messages"][] = SUCCESS_UPDATED_COLLABORATOR;
        $output["response"]["total"] = 1;
        $output['statusCode'] = STATUS_UPDATED;
        $responseArray = array('response' => $output['response'], 'status' => $output['status']);
        $this->response($responseArray, $output['statusCode']);
    }

}
