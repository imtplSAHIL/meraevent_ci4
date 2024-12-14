<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once (APPPATH . 'handlers/salesperson_handler.php');
require_once (APPPATH . 'handlers/eventsalespersonmapping_handler.php');
require_once (APPPATH . 'handlers/email_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/messagetemplate_handler.php');
require_once(APPPATH . 'handlers/profile_handler.php');
require_once(APPPATH . 'handlers/organization_handler.php');
require_once(APPPATH . 'handlers/sms_handler.php');

class Accountmanager extends CI_Controller 
{

   
	var $eventsalespersonmapping;
	var $salesperson;
	var $emailhandler;
	var $userHandler;
	var $messagetemplateHandler;
        var $profileHandler;
        var $smsHandler;

    public function __construct() 
	{
        parent::__construct();
	$this->eventsalespersonmapping = new eventsalespersonmapping_handler();
        $this->salesperson =  new salesperson_handler();
        $this->userHandler = new User_handler();
        $this->messagetemplateHandler = new Messagetemplate_handler();
        $this->emailhandler =  new email_handler();
        $this->organization =  new Organization_handler();
        $this->smshandler =  new Sms_handler();
	   	
		
        
		
       
    }
	public function index(){
		
	   
	   $input['organizer_id']= $this->customsession->getUserId();
	  
           //for getting Sales person Data
	   $output=$this->eventsalespersonmapping->get_salespersonid_by_organizer_id($input);
           $input_for_salesperson['salesPersonId']= $output['response']['salesPersonId'];
	   $output=$this->salesperson->getSalesPersonDetails($input_for_salesperson);
	   $data['sales_person_detail']=$output['response']['details'][0];
          
           //for getting organizer data 
            $userInput['ownerId']=$input['organizer_id'];
           
            $userOutput = $this->userHandler->getUserData($userInput);
	    $ParseInput['Org_Name'] = str_replace(' ', '', $userOutput['response']['userData']['name']);
            $ParseInput['Org_Email']=$userOutput['response']['userData']['email'];
            $ParseInput['Org_Mobile'] =$data['org_mobile'] = $userOutput['response']['userData']['mobile'];
		
           
           //for getting Sms Tempalte 
           $templateInputs['type'] = TYPE_ORG_SMS;                
           $templateInputs['mode'] = 'sms';
           
           $templateDetails = $this->messagetemplateHandler->getTemplateDetail($templateInputs);
           $templateMessage = $templateDetails['response']['templateDetail']['template'];
           
           //for parsing the template 
           $this->load->library('parser');
           $data['message'] = $this->parser->parse_string($templateMessage, $ParseInput, TRUE);
           
	   //echo "<pre>";print_r($data);exit;
           
           $data['support_team_email'] = GENERAL_INQUIRY_EMAIL;
           $data['support_team_mobile'] = GENERAL_INQUIRY_MOBILE;
           $data['payment_team_email'] = PAYMENT_TEAM_EMAIL;
           $data['payment_team_mobile'] = PAYMENT_TEAM_MOBILE;
           $data['company_manager_email'] = COMPANY_MANAGER_EMAIL;
           $data['company_manager_mobile'] = COMPANY_MANAGER_MOBILE;
           $data['ceo_mail'] = CEO_EMAIL;
           $data['ceo_mobile'] = CEO_MOBILE;
           
           //echo "<pre>";print_r($data);exit;
           
            $data['pageName'] = 'Account Manager';
            $data['pageTitle'] = 'MeraEvents | Account Manager';
            $data['hideLeftMenu'] = 1;
            $data['content'] = 'account_manager_view';
            $data['jsTopArray'] = array(
                $this->config->item('js_public_path') . 'intlTelInput',
                $this->config->item('js_public_path') .'jQuery-ui' 
            );
            $data['jsArray'] = array($this->config->item('js_public_path').'dashboard/account-manager');
            
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'intlTelInput'
            );
            
            $this->load->view('templates/dashboard_template', $data);
        }
	
    
	
	public function send_mail_for_callback()
	{
		$receiver_mail = $this->input->post('receiver_mail');
		$data['receivername'] = $this->input->post('receivername');
		$message = $this->input->post('message');
		$inputArray['receiver_mail']=$receiver_mail;
		$inputArray['message']=$message;
		$this->form_validation->reset_form_rules();
		$this->form_validation->pass_array($inputArray);
		$this->form_validation->set_rules('receiver_mail', 'Receiver Email', 'trim|required_strict|valid_email');
		$this->form_validation->set_rules('message', 'Message', 'required_strict');
		
		if ($this->form_validation->run() == FALSE) 
		{
			
			$response = $this->form_validation->get_errors();
			$this->session->set_flashdata('msg', implode(",",$response['message']));
			$AcManagerPageUrl= commonHelperGetPageUrl('accountManager');
                        commonHelperRedirect($AcManagerPageUrl);
		}
		$subject = $this->input->post('custom_subject');
		
                //getting the organizer data
		$input['ownerId']= $this->customsession->getUserId();
		$output = $this->userHandler->getUserData($input);
		$userId = $output['response']['userData']['id'];
		$data['name'] = $output['response']['userData']['name'];
                $data['mailId']=$output['response']['userData']['email'];
                $data['mobile'] = $output['response']['userData']['mobile'];
		$data['message']= $message;
		
		//getting the template
                $templateInputs['type'] = TYPE_CALL_BACK;                
                $templateInputs['mode'] = 'email';
                $templateDetails = $this->messagetemplateHandler->getTemplateDetail($templateInputs);
		
		$templateId = $templateDetails['response']['templateDetail']['id'];
                $from = $templateDetails['response']['templateDetail']['fromemailid'];
                $templateMessage = $templateDetails['response']['templateDetail']['template'];
		
		$this->load->library('parser');
                $message = $this->parser->parse_string($templateMessage, $data, TRUE);
                $sentmessageInputs['messageid'] = $templateId;
                $sentmessageInputs['userId'] = $userId;
		 $cc='';
                 
                 /* Sending mail to Manage and CEO as Carbon copy
                  */
                if($receiver_mail == COMPANY_MANAGER_EMAIL || $receiver_mail == CEO_EMAIL)
                {
                    $cc = $receiver_mail;
                    //getting the Account Manager Email 
                    $organizerInput['organizer_id'] = $this->customsession->getUserId();
                    $output=$this->eventsalespersonmapping->get_salespersonid_by_organizer_id($organizerInput);
                    
                    if($output['status'] == 1 && $output['response']['total'] == 1)
                    {
                        $input_for_salesperson['salesPersonId']= $output['response']['salesPersonId'];
                        $output=$this->salesperson->getSalesPersonDetails($input_for_salesperson);
                        
                        $receiver_mail = $output['response']['details'][0]['email'];
                        
                    }
                    else
                    {
                        $receiver_mail = GENERAL_INQUIRY_EMAIL;
                    }
                }
		
		$output=$this->emailhandler->EmailSend($receiver_mail, $cc, '', $from,  $subject, $message, '', '', '', $sentmessageInputs);
                //echo "receiver mail=".$receiver_mail." cc=".$cc."  from=".$from." </br>subject=".$subject."  message=".$message;
                //echo"<pre>";print_r($output);exit;
		if($output['status']==1)
		{
			$this->session->set_flashdata('msg', ACCOUNT_MANAGER_EMAIL_SENT_SUCCESS);
		}
		else
		{
			$this->session->set_flashdata('msg', ERROR_EMAIL_NOT_SENT);
		}
		
            $AcManagerPageUrl= commonHelperGetPageUrl('accountManager');
            commonHelperRedirect($AcManagerPageUrl);
	}
	
        
        //function for sending Sms
	public function send_sms()
	{
		
		
	    $number = $this->input->post('receiver_number');
            $data['receivername'] = str_replace(' ', '', $this->input->post('receiver_name'));
            
            //getting the Organizer Data
            $input['ownerId']= $this->customsession->getUserId();
            $output = $this->userHandler->getUserData($input);
            
            $userId = $output['response']['userData']['id'];
            $data['Org_Name'] = str_replace(' ', '', $output['response']['userData']['name']);
            $data['Org_Email']=$output['response']['userData']['email'];
            $data['Org_Mobile'] = $output['response']['userData']['mobile'];
             
            if(empty($data['Org_Mobile']))
            {
                $data['Org_Mobile'] = $this->input->post('organizer_mobile');
              
                //for updating mobile number 
                $this->profileHandler =  new profile_handler();
                $userInput['mobile'] = $data['Org_Mobile'];
                $output = $this->profileHandler->updateMobileNumber($userInput);
                //echo"<pre>";print_r($output);exit;
                
                
            }
           
	     // getting template data
            $templateInputs['type'] = TYPE_ORG_SMS;                
            $templateInputs['mode'] = 'sms';
            
            $templateDetails = $this->messagetemplateHandler->getTemplateDetail($templateInputs);
	    $templateId = $templateDetails['response']['templateDetail']['id'];
            $templateMessage = $templateDetails['response']['templateDetail']['template'];
            
            
	    $this->load->library('parser');
            $message = $this->parser->parse_string($templateMessage, $data, TRUE);
		
		
            //sending message 
            $sentmessageInputs['messageid'] = $templateId;
            $sentmessageInputs['userId'] = $userId;
            
            $output=$this->smshandler->sendSms($number,$message,$sentmessageInputs);
            if($output['status']==1)
	    {
		$this->session->set_flashdata('msg', $output['response']['messages'][0]);
	    }
            
            /*sending a copy of message to account manager(or support team ,if no a/c manager assign) 
             if 
            organizer try to send message to CEO or Manager*/
            if($number==COMPANY_MANAGER_MOBILE || $number==CEO_MOBILE)
            {
                //getting the Account Manager Mobile 
                $organizerInput['organizer_id'] = $this->customsession->getUserId();
                $output=$this->eventsalespersonmapping->get_salespersonid_by_organizer_id($organizerInput);
               
                if($output['status'] == 1 && $output['response']['total'] == 1)
                {
                    $input_for_salesperson['salesPersonId']= $output['response']['salesPersonId'];
                    $output=$this->salesperson->getSalesPersonDetails($input_for_salesperson);
                    $AcManagerMob = $output['response']['details'][0]['mobile'];
                    
                        
                       //send message copy to a/c Manager 
                    $output=$this->smshandler->sendSms($AcManagerMob,$message,$sentmessageInputs);
                    
                    if($output['status']==1)
                    {
                        $this->session->set_flashdata('msg', $output['response']['messages'][0]);
                    }
                }
                else
                {
                    //sending message to Support Team.
                     $output=$this->smshandler->sendSms(GENERAL_INQUIRY_MOBILE,$message,$sentmessageInputs);
                    if($output['status']==1)
                    {
                        $this->session->set_flashdata('msg', $output['response']['messages'][0]);
                    }    
                }
            }
            $AcManagerPageUrl= commonHelperGetPageUrl('accountManager');
            commonHelperRedirect($AcManagerPageUrl);
	}
        
        function orgProfile(){
           
            $input['id']= $this->customsession->getUserId();
            
            $orgDetails = $this->organization->getOrgDetails($input);
            
            $data['pageName'] = 'Manage Organizer Page';
            $data['pageTitle'] = 'MeraEvents | Organizer Profile';
            $data['hideLeftMenu'] = 1;
            $data['content'] = 'organizer_profile_view';
            $data['orgDetails'] = $orgDetails['response']['orgDetails'];
           
            if ($this->input->post('submit')) {
                $this->input->post['bannerpathid']=$_FILES['bannerpathid'];
                $inputArray['name'] = $this->input->post('name');
                if($this->input->post('id')){
                    $inputArray['orgid'] = $this->input->post('id');
                }   
                $inputArray['slug'] = $this->input->post('slug');
                $inputArray['information'] = $this->input->post('information');
                $inputArray['createdby'] = $this->customsession->getUserId();
                $inputArray['bannerpathid'] = $_FILES['bannerpathid'];
                $inputArray['userid'] = $input['id'];
                $inputArray['seokeywords'] = $this->input->post('seokeywords');
                $inputArray['seodescription'] = $this->input->post('seodescription');
                $inputArray['seotitle'] = $this->input->post('seotitle');
                $output = $this->organization->insertOrganizer($inputArray);
                
                if ($output['status']) {
                    $this->customsession->setData('promoterSuccessAdded', SUCCESS_ADDED_PROMOTER);
                    redirect(commonHelperGetPageUrl('organizerProfileindex'));
                } else {
                    $data['output'] = $output['response']['messages'][0];
                }
            }
            $data['jsTopArray'] = array(
                $this->config->item('js_public_path') . 'intlTelInput',
                $this->config->item('js_public_path') .'jQuery-ui' 
            );
           
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'intlTelInput',
                $this->config->item('css_public_path') . 'bootstrap'
            );
            $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/organizer');
            $this->load->view('templates/dashboard_template', $data);
        }
        
        function orgPage(){
           
            $input['id']= $this->customsession->getUserId();
            
            $orgDetails = $this->organization->getOrgDetails($input);
           
            $data['pageName'] = 'Manage Organizer Page';
            $data['pageTitle'] = 'MeraEvents | Organizer Profile';
            $data['hideLeftMenu'] = 1;
            $data['content'] = 'organizer_view';
            $data['orgDetails'] = $orgDetails['response']['orgDetails'];
           
            $data['jsTopArray'] = array(
                $this->config->item('js_public_path') . 'intlTelInput',
                $this->config->item('js_public_path') .'jQuery-ui' 
            );
          
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'intlTelInput',
                $this->config->item('css_public_path') . 'bootstrap'
            );
           
            $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/organizer');
            $this->load->view('templates/dashboard_template', $data);
        }
        
        function checkOrganizerSlug(){
            $input['slug']= $this->input->post('url');
            $input['id']= $this->input->post('orgId');
            $sulgExits = $this->organization->getOrgSlugExits($input);
            echo $sulgExits['status'];exit;

        }
	
}
?>