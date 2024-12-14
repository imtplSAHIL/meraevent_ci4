<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once (APPPATH . 'handlers/salesperson_handler.php');
require_once (APPPATH . 'handlers/eventsalespersonmapping_handler.php');
require_once (APPPATH . 'handlers/email_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/messagetemplate_handler.php');
require_once(APPPATH . 'handlers/profile_handler.php');
require_once(APPPATH . 'handlers/organization_handler.php');


class Mymemberships extends CI_Controller 
{

   
	var $eventsalespersonmapping;
	var $salesperson;
	var $emailhandler;
	var $userHandler;
	var $messagetemplateHandler;
        var $profileHandler;

    public function __construct() {
        parent::__construct();
	
        $this->profileHandler = new Profile_handler();
        $this->userHandler = new User_handler();
        $this->countryHandler = new Country_handler();
        $this->stateHandler = new State_handler();
        $this->cityHandler = new City_handler();
        $this->alertHandler = new Alert_handler();
        $this->organizerbankdetailHandler = new Organizerbankdetail_handler();
        $this->organizationHandler = new Organization_handler();
    }
	public function index(){
            
            $userId = $this->customsession->getUserId();
            $state = $user =array();
            $inputArray['userId'] = $userId;
            $inputArray['major'] = 1;
            $locality = '';

            if($this->session->flashdata('message')){
                $messages = $this->session->flashdata('message');
            }

            $subscriptions = $this->organizationHandler->myMemberships($inputArray);

            //$data['message'] = $messages;
            //$data['status'] = $status;
            $data['subscriptionsInfo'] = $subscriptions;
            $data['content'] = '../association/my_memberships';
            $data['pageName'] = 'MyMemberships';
            $data['pageTitle'] = 'MeraEvents | Organization Details';
            $data['hideLeftMenu'] = 1;
            
            //$data['orgnizerDetails'] = $orgnizerData['response']['organizationData'][0];
            $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'intlTelInput');
            $data['cssArray'] = array($this->config->item('css_public_path') . 'intlTelInput');
            $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/profile');     
            $this->load->view('templates/dashboard_template', $data);

        }
        



}
?>