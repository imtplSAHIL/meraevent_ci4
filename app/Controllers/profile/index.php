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
require_once(APPPATH . 'handlers/profile_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/country_handler.php');
require_once(APPPATH . 'handlers/state_handler.php');
require_once(APPPATH . 'handlers/city_handler.php');
require_once(APPPATH . 'handlers/alert_handler.php');
require_once(APPPATH . 'handlers/organizerbankdetail_handler.php');
require_once(APPPATH . 'handlers/organizer_handler.php');
require_once(APPPATH . 'handlers/oauth_clients_handler.php');
require_once(APPPATH . 'handlers/file_handler.php');

class Index extends CI_Controller {

    var $profileHandler;
    var $userHandler;
    var $countryHandler;
    var $stateHandler;
    var $cityHandler;
    var $alertHandler;
    var $organizerbankdetailHandler;
    var $organizerHandler;

    public function __construct() {
        parent::__construct();
        $this->profileHandler = new Profile_handler();
        $this->userHandler = new User_handler();
        $this->countryHandler = new Country_handler();
        $this->stateHandler = new State_handler();
        $this->cityHandler = new City_handler();
        $this->alertHandler = new Alert_handler();
        $this->organizerbankdetailHandler = new Organizerbankdetail_handler();
        $this->organizerHandler = new Organizer_handler();
        // if user not logged in redirect to home page
        $userId = $this->customsession->getUserId();
       if(!$userId){
          $redirectUrl = site_url();
          redirect($redirectUrl);
       }
    }

    public function bankDetail($userId) {
        $inputArray['userId'] = getUserId();
        $bankDetails = $this->organizerbankdetailHandler->getBankDetails($inputArray);
        $update = $this->input->post('bankDetails');
        if ($update) {
            $inputArray['userId'] = getUserId();
            $inputArray['accountName'] = $this->input->post("accountName");
            $inputArray['accountNumber'] = $this->input->post("accountNumber");
            $inputArray['bankName'] = $this->input->post("bankName");
            $inputArray['branch'] = $this->input->post("branch");
            $inputArray['ifsccode'] = $this->input->post("ifsccode");
            $inputArray['pancard'] = $this->input->post("pancard");
            $inputArray['aadhar'] = $this->input->post("aadhar");
            // $inputArray['serviceTaxNumber'] = $this->input->post("serviceTaxNumber");
            $inputArray['gst'] = $this->input->post("gst");
            $type = $this->input->post("accountType");
            $inputArray['accountType'] = ($type == 'current') ? 1 : 2;
            $id = $bankDetails['response']['bankDetails']['0']['userid'];
            if (isset($_FILES['gstDocument']) && $_FILES['gstDocument']['tmp_name']!='') {
                $fileResponse = $this->bankDetailDocUpload($inputArray);
                $fileId = $fileResponse['response']['fileId'];
            }
            if (isset($_FILES['orgpancard']) && $_FILES['orgpancard']['tmp_name']!='') {
                $fileResponse = $this->pancardDocUpload($inputArray);
                $orgpanfileId = $fileResponse['response']['fileId'];
                $inputArray['pancarddocid'] = $orgpanfileId;
            }
            if (isset($_FILES['orgadharcard']) && $_FILES['orgadharcard']['tmp_name']!='') {
                $fileResponse = $this->adharDocUpload($inputArray);
                $orgadharfileId = $fileResponse['response']['fileId'];
                $inputArray['adhardocid'] = $orgadharfileId;
            }
            if (isset($_FILES['orgcheque']) && $_FILES['orgcheque']['tmp_name']!='') {
                $fileResponse = $this->chequeDocUpload($inputArray);
                $orgchequefileId = $fileResponse['response']['fileId'];
                $inputArray['chequedocid'] = $orgchequefileId;
            }
            $inputArray['bankgstdocid'] = $fileId;
            if ($id > 0) {
                $updateData = $this->organizerbankdetailHandler->updateBankDetails($inputArray);
                if ($updateData['status']) {
                        $this->customsession->setData('bankDetailMessage', $updateData['response']['messages']['0']);
                        $redirectUrl = commonHelperGetPageUrl('user-bankdetail');
                        redirect($redirectUrl);
                }else{
                        $this->customsession->setData('bankDetailErrorMessage', $updateData['response']['messages']['0']);
                        $redirectUrl = commonHelperGetPageUrl('user-bankdetail');
                        redirect($redirectUrl);
                }
            } else {
                $insertData = $this->organizerbankdetailHandler->insertBankDetails($inputArray);
                if ($insertData['status']) {
                        $this->customsession->setData('bankDetailMessage', $updateData['response']['messages']['0']);
                        $redirectUrl = commonHelperGetPageUrl('user-bankdetail');
                        redirect($redirectUrl);
                }else{
                        $this->customsession->setData('bankDetailErrorMessage', $updateData['response']['messages']['0']);
                        $redirectUrl = commonHelperGetPageUrl('user-bankdetail');
                        redirect($redirectUrl);
                }
            }
        }

        $data['message'] = $message;
        $data['status'] = $status;
        $data['bankDetails'] = $bankDetails['response']['bankDetails']['0'];
        ///print_r($data['bankDetails']);exit;
        $data['gst_form_path'] = $this->config->item('images_static_path')."non-gst-declaration.pdf";
        $data['pageName'] = 'Bank Details';
        $data['pageTitle'] = 'MeraEvents | Bank Details';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
        	$this->config->item('js_public_path') . 'dashboard/profile' 
        );
        $data['content'] = 'bank_details_view';
        $this->load->view('templates/profile_template', $data);
    }

    public function companyDetail() {
        $userId = $this->customsession->getUserId();
        $inputArray['userId'] = $userId;
        $inputArray['major'] = 1;
        $locality = '';
        
        $companyDetails = $this->organizerHandler->getCompanyDetails($inputArray);
        $orgId = $companyDetails['response']['companyDetails']['id'];
        $input['countryId'] = $companyDetails['response']['companyDetails']['countryid'];
        $input['cityId'] = $companyDetails['response']['companyDetails']['cityid'];
        $input['stateId'] = $companyDetails['response']['companyDetails']['stateid'];
        $this->getLocalityDetails($input);
        $locality = '';
        if(!empty($companyDetails['response']['companyDetails']['address'])){
            $locality = $companyDetails['response']['companyDetails']['address'];
        }elseif(!empty($this->getLocalityDetails($input))){
            $locality = $this->getLocalityDetails($input);
        }
        
        
        $update = $this->input->post('companyForm');
        if ($update) {
            $companyInfo['userId'] = $userId;
            $companyInfo['id'] = $orgId;
            $companyInfo['address'] = $this->input->post("locality");
            $companyInfo['companyname'] = $this->input->post("companyname");
            $companyInfo['designation'] = $this->input->post("designation");
            $companyInfo['description'] = $this->input->post("description");
            $companyInfo['countryId'] = $this->input->post("countryId");
            $companyInfo['stateId'] = $this->input->post("stateId");
            $companyInfo['cityId'] = $this->input->post("cityId");
            $companyInfo['phone'] = $this->input->post("phone");
            $companyInfo['email'] = $this->input->post("email");
            $companyInfo['url'] = $this->input->post("url");
            if (isset($companyInfo['stateId']) && strlen($companyInfo['stateId']) > 0) {
                //for new state
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
            
            $companyData = $this->organizerHandler->updateCompanyDetails($companyInfo);
            if ($companyData['status'] == TRUE) {
                $messages = $companyData['response']['messages']['0'];
                $status = $companyData['status'];
                
                $companyDetails = $this->organizerHandler->getCompanyDetails($inputArray);
                $locality = '';
                  if(!empty($companyDetails['response']['companyDetails']['address'])){
                        $locality = $companyDetails['response']['companyDetails']['address'];
                    }elseif(!empty($this->getLocalityDetails($input))){
                        $locality = $this->getLocalityDetails($input);
                    }
                
            } else {
                $messages = $companyData['response']['messages']['0'];
                $status = $companyData['status'];
            }
        }
        
        $data['companyDetails'] = $companyDetails['response']['companyDetails'];
        $data['message'] = $messages;
        $data['status'] = $status;
        $data['locality'] = $locality;
        $data['content'] = 'company_details_view';
        $data['pageName'] = 'Company Details';
        $data['pageTitle'] = 'MeraEvents | Company Details';
        $data['hideLeftMenu'] = 0;
        $data['jsTopArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui'  ); 
//        $data['cssArray'] = array(
//            $this->config->item('css_public_path') . 'jquery-ui.css');
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/profile' 
        );     
        $this->load->view('templates/profile_template', $data);
    }

    public function personalDetail() {

        $userId = $this->customsession->getUserId();
        $state = $user =array();
        $inputArray['userId'] = $userId;
        $inputArray['major'] = 1;
        $locality = '';

        if($this->session->flashdata('message')){
            $messages = $this->session->flashdata('message');
        }

        require_once(APPPATH . 'handlers/event_handler.php');
        $eventHandler = new Event_handler();
        $isUserMobileVerified = $this->userHandler->isMobileVerified($inputArray);
        $userevents = $eventHandler->getEventsCountByUserId($inputArray); 
        
        $data['ismobileverified'] = (!$isUserMobileVerified['status'] && !$userevents['status']) ? '0' : '1';
        $redirect_url = $this->input->get('redirect_url');
        $data['redirect'] = ($redirect_url!='') ? 1 : 0;

        if($isUserMobileVerified['status'] == 1 && $redirect_url!=''){
            redirect($redirect_url);
        }

        
        $orgnizerData = $this->organizerHandler->getCompanyDetails($inputArray);
        $personalDetails = $this->profileHandler->getPersonalDetails($inputArray);
        $input['countryId'] = $personalDetails['response']['personalDetails']['0']['response']['userData']['countryid'];
        $input['cityId'] = $personalDetails['response']['personalDetails']['0']['response']['userData']['cityid'];
        $input['stateId'] = $personalDetails['response']['personalDetails']['0']['response']['userData']['stateid'];
        $locality = $this->getLocalityDetails($input);
        $old_mobile = $personalDetails['response']['personalDetails']['0']['response']['userData']['mobile'];
       
        //print_r($_POST); exit;
        //var_dump($delete_wallet); exit;

        $update = $this->input->post('personalDetailsForm');
        if ($update) {
            $user['username']=$this->input->post("username");
            $userNameCheck= $this->userHandler->userNameCheck($user);
            if($userNameCheck['status'] == true && $userNameCheck['response']['total'] == 1){
                $status = FALSE;
                $messages = $userNameCheck['response']['messages'];
            }
            elseif(!$isUserMobileVerified['status'] && !$userevents['status'] && $redirect_url != ''){
                $status = FALSE;
                $messages = USER_MOBILE_NOT_VERIFIED;
            }
            else{
                
                $userInfo['userId'] = $userId;
                $userInfo['username'] = $this->input->post("username");
                $userInfo['name'] = $this->input->post("name");
                $userInfo['address'] = $this->input->post("address");
                $userInfo['email'] = $this->input->post("email");
                $userInfo['countryId'] = $this->input->post("countryId");
                $userInfo['stateId'] = $this->input->post("stateId");
                $userInfo['cityId'] = $this->input->post("cityId");
                $userInfo['phone'] = $this->input->post("phone");
                $userInfo['mobile'] = $this->input->post("mobile");
                $userInfo['pincode'] = $this->input->post("pincode");
                $userInfo['facebooklink'] = $this->input->post("facebooklink");
                $userInfo['twitterlink'] = $this->input->post("twitterlink");
                $userInfo['googlepluslink'] = $this->input->post("googlepluslink");
                $userInfo['linkedinlink'] = $this->input->post("linkedinlink");
                $userInfo['companyname'] = $this->input->post("companyname");
                $userInfo['designation'] = $this->input->post("designation");
                $userInfo['mobile'] = $this->input->post("mobile");

                $updating_mobile = $this->input->post("mobile");
                $delete_wallet = FALSE;
                if( $updating_mobile !='')
                    $delete_wallet = ($old_mobile != $updating_mobile) ? TRUE : FALSE;

                if (isset($userInfo['stateId']) && strlen($userInfo['stateId']) > 0) {
                    //for new state
                    if (!is_numeric($userInfo['stateId'])) {
                        $stateinput['state'] = $userInfo['stateId'];
                        $stateinput['countryId'] = $userInfo['countryId'];
                        $stateinput['googleapistate'] = TRUE;
                        $state = $this->stateHandler->stateInsert($stateinput);
                        if ($state['status'] === FALSE) {
                            return $state;
                        }
                        $userInfo['stateId'] = $state['response']['stateId'];
                    }
                }
                if (isset($userInfo['cityId']) && strlen($userInfo['cityId']) > 0) {
                    //for new city
                    if (!is_numeric($userInfo['cityId'])) {
                        $cityinput['city'] = $userInfo['cityId'];
                        $cityinput['countryId'] = $userInfo['countryId'];
                        $cityinput['stateId'] = $userInfo['stateId'];
                        $cityinput['googleapicity'] = TRUE;
                        $city = $this->cityHandler->cityInsert($cityinput);
                        if ($city['status'] === FALSE) {
                            return $city;
                        }
                        $userInfo['cityId'] = $city['response']['cityId'];
                    }
                }

                $updatePersonalData = $this->profileHandler->updatePersonalDetails($userInfo);
                if ($updatePersonalData['status'] == TRUE) {
                    $messages = $updatePersonalData['response']['messages']['0'];
                    $status = $updatePersonalData['status'];
                    $orgnizerData = $this->organizerHandler->getCompanyDetails($userInfo);
                    $personalDetails = $this->profileHandler->getPersonalDetails($userInfo);
                    $locality = $this->getLocalityDetails($userInfo);
                    
                    $profilePic = $personalDetails['response']['personalDetails']['0']['response']['userData']['profileimagefilepath'];
                    $this->customsession->setData('profileImagePath', $profilePic);

                    
                } else {
                    $messages = $updatePersonalData['response']['messages']['0'];
                    $status = $updatePersonalData['status'];
                }
            }
        }
		
		
		/*checking if, wallet exists*/
		$data['mywallet'] = FALSE;
		require_once(APPPATH . 'handlers/mywallet_handler.php');
		$mywalletHandler = new MyWallet_handler();
		$walletArray['userId'] = $userId;
        if($delete_wallet){
            $mywalletHandler->deleteWalletUserByUserId($userId);
        }//sss
        else{
            $walletUserDetails = $mywalletHandler->getWalletUserDetails($walletArray);
    		//print_r($walletUserDetails); exit;
            if($walletUserDetails['status']){
    			if(count($walletUserDetails['response']['walletUserDetails']) > 0){
    				$data['mywallet'] = TRUE;
    			}
    			
    		}
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
		
        $data['message'] = $messages;
        $data['status'] = $status;
        $data['content'] = 'personal_details_view';
        $data['pageName'] = 'Personal Details';
        $data['pageTitle'] = 'MeraEvents | My Account';
        $data['hideLeftMenu'] = 0;
        $data['locality'] = $locality;
        $data['personalDetails'] = $personalDetails['response']['personalDetails']['0']['response']['userData'];
        $data['orgnizerDetails'] = $orgnizerData['response']['companyDetails'];
        $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui',
                                    $this->config->item('js_public_path') . 'intlTelInput'
            );
        $data['cssArray'] = array(
        $this->config->item('css_public_path') . 'intlTelInput'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/profile'
        );  

         
        $this->load->view('templates/profile_template', $data);
    }
    public function stateslist() {
       
        $countryid=$this->input->post('countryId');
        
        $this->db->select('id, name');
        $this->db->from('state');
        $this->db->where('countryid', $countryid);
        $this->db->where('deleted', 0);
        $this->db->where('status', 1);
        $this->db->limit(42);
        $query = $this->db->get();
        $result = $query->result_array();
        $opts= "<option>Choose Your State</option>";
        foreach($result as $k=>$v){
            
           $opts.= "<option value='".$v['id']."'>".$v['name']."</option>";
        }
        //print_r($result);
        echo $opts;
    }
    public function citylist() {
       
        $stateid=$this->input->post('state_id');
       /*  $input['countryId'] =$this->input->post('countryId');
       
            $country = $this->countryHandler->getCountryListById($input);
            
       
        print_r($country);
        die;  */
        $this->db->select('city.id, city.name');
        $this->db->from('statecity');
        $this->db->join('city', 'city.id = statecity.cityid', 'left');
        $this->db->where('statecity.stateid', $stateid);
        $this->db->where('deleted', 0);
        $this->db->where('status', 1);
        //$this->db->limit(42);
        $query = $this->db->get();
        $result = $query->result_array();
        $opts= "<option>Choose Your City</option>";
        foreach($result as $k=>$v){
            
           $opts.= "<option value='".$v['id']."'>".$v['name']."</option>";
        }
        //print_r($result);
        echo $opts;
    }

   public function alertSetting() {
        $userId = $this->customsession->getUserId();
        $inputArray['userId'] = $userId;                
        $update = $this->input->post('alertForm');
        //For updating the alert options for the user
        if ($update) {
            $incomplete = $this->input->post("incomplete");
            $dailytransaction = $this->input->post("dailytransaction");
            $dailysuccesstransaction = $this->input->post("dailysuccesstransaction");
            $ticketregistration = $this->input->post("ticketregistration");
            if (isset($incomplete)) {
                $alertArray['incomplete'] = ($incomplete == 1) ? 1 : 0;
            }
            if (isset($dailytransaction)) {
                $alertArray['dailytransaction'] = ($dailytransaction == 1) ? 1 : 0;
            }
            if (isset($dailysuccesstransaction)) {
                $alertArray['dailysuccesstransaction'] = ($dailysuccesstransaction == 1) ? 1 : 0;
            }
            if (isset($ticketregistration)) {
                $alertArray['ticketregistration'] = ($ticketregistration == 1) ? 1 : 0;
            }
                foreach ($alertArray as $key => $val) {
                    $insertArray['type'] = $key;
                    $insertArray['userid'] = $userId;
                    $insertArray['status'] = $val;
                    $alertUpdate = $this->alertHandler->alertUpdate($insertArray);
                    $data['messages'] = $alertUpdate['response']['messages']['0'];
                    $data['status'] = $alertUpdate['status'];
                }          
        }
        //To make default alert options for the first time user
        $alertDetails = $this->alertHandler->getAlerts($inputArray);   
        if($alertDetails['response']['total']==0){
            $defaultAlertOptions=$this->config->item('default_alert_options');
            foreach($defaultAlertOptions as $key=>$val){
                    $insertArray['type'] = $key;
                    $insertArray['userid'] = $userId;
                    $insertArray['status'] = $val;              
                    $alertInsert = $this->alertHandler->alertInsert($insertArray);
                    $data['messages'] = $alertInsert['response']['messages']['0']; 
                    $data['status'] = $alertInsert['status'];
                }
        }
        //For showing the modified options on the page
        $alertDetails = $this->alertHandler->getAlerts($inputArray);
        $data['alertDetails'] = $alertDetails['response']['alertDetails'];     
        $data['content'] = 'alerts_view';
        $data['pageName'] = 'Alerts';
        $data['pageTitle'] = 'MeraEvents | Alerts';
        $data['hideLeftMenu'] = 0;
        $data['alertDetails'] = $alertDetails['response']['alertDetails'];
        $data['jsArray'] = array(
        		$this->config->item('js_public_path') . 'dashboard/profile'
        ); 
        $this->load->view('templates/profile_template', $data);
    }


    public function changePassword() {
        if ($this->input->post('changePasswordSubmit')) {
            $inputArray['password'] = $this->input->post('password');
            $inputArray['confirmPassword'] = $this->input->post('confirmPassword');
            $userId = getUserId();
            $tokenId = '';
            $output = $this->userHandler->updatePassword($inputArray, $userId, $tokenId);
            $data['output'] = $output;
        }
        $data['content'] = 'dashboard_change_password_view';
        $data['moduleName'] = 'changePasswordModule';
        $data['pageName'] = 'Dashboard Change Password';
        $data['pageTitle'] = 'MeraEvents | Change Password';
        $data['dashboardPage'] = TRUE; //To not include event_scroll header in the changePassword_view
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'main' ,
            $this->config->item('js_public_path') . 'dashboard/profile' 
         );
           // site_url() . 'js/public/dashboard/profile.js');

        $this->load->view('templates/profile_template', $data);
    }

    public function getCurrentTicket() {
    	$inputArray['ticketType'] = 'current';
        $eventList = $this->profileHandler->getUserTicketList($inputArray);
        if ($eventList['status'] == TRUE && $eventList['response']['total']>0 ) {
            $data['eventList'] = $eventList['response']['eventList'];
        }
        $data['pageName'] = 'Current Tickets';
        $data['pageTitle'] = 'MeraEvents | Attendee View | Current Tickets';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'attendee_ticket_view';
        $data['pageType'] = "current";
        $data['currentTotal'] = ($eventList['response']['total'] > 0 ) ? $eventList['response']['total'] : '';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function getPastTicket() {
		$inputArray['ticketType'] = 'past';
        $eventList = $this->profileHandler->getUserTicketList($inputArray);
        if ($eventList['status'] == TRUE && $eventList['response']['total']>0 ) {
        	
            $data['eventList'] = $eventList['response']['eventList'];
        }else{
        	$data['eventList'] = array();
        }
        $data['pageName'] = 'Past Tickets';
        $data['pageTitle'] = 'MeraEvents | Attendee View | Past Tickets';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'attendee_ticket_view';
        $data['pageType'] = "past";
        $data['pastTotal'] = ($eventList['response']['total'] > 0 )?$eventList['response']['total'] : '';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function getReferalBonus() {

        $eventList = $this->profileHandler->getUserCurrentTicketList();
        if ($eventList['status'] == TRUE) {
            $data['eventList'] = $eventList['response']['eventList'];
        }
        $data['pageName'] = 'Current Tickets';
        $data['pageTitle'] = 'Attendee - Current Tickets';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'attendee_ticket_view';
        $data['pageType'] = "current";
        $this->load->view('templates/dashboard_template', $data);
    }
    
    public function getLocalityDetails($idsArray){
        if ($idsArray['countryId'] > 0) {
            $country = $this->countryHandler->getCountryListById($idsArray);
            $locality = $countryName = $country['response']['detail']['name'];
        }
        if ($idsArray['stateId'] > 0) {
            $state = $this->stateHandler->getStateListById($idsArray);
            $stateName = $state['response']['stateList']['0']['name'];
            $locality  = $stateName . "," .$countryName;
        }
        if ($idsArray['cityId'] > 0) {
            $city = $this->cityHandler->getCityDetailById($idsArray);
            $cityName = $city['response']['detail']['name'];
            $locality = $cityName . "," . $stateName . "," . $countryName;
        }
        return $locality;
    }
    
    public function createApp() {
        if ($this->input->post('submit')) {
            $inputArray = $this->input->post();
            $oauthClientsHandler = new Oauth_clients_handler();
            $output = $oauthClientsHandler->insertAppDetails($inputArray);
            redirect(commonHelperGetPageUrl('developerapi'));
        }
        $data['content'] = 'create_api_view.php';
        $data['moduleName'] = 'changePasswordModule';
        $data['pageName'] = 'Dashboard Create APP';
        $data['pageTitle'] = 'MeraEvents | Create APP';
        $data['dashboardPage'] = TRUE; //To not include event_scroll header in the changePassword_view
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'main',
            $this->config->item('js_public_path') . 'dashboard/profile'
        );
        $this->load->view('templates/profile_template', $data);
    }

    public function developerapi() {
        $data['content'] = 'api_list_view';
        $data['moduleName'] = 'changePasswordModule';
        $data['pageName'] = 'Dashboard Apps list';
        $data['pageTitle'] = 'MeraEvents | Apps List';
        $data['dashboardPage'] = TRUE; //To not include event_scroll header in the changePassword_view
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'main',
            $this->config->item('js_public_path') . 'dashboard/profile'
        );

        $oauthClientsHandler = new Oauth_clients_handler();
        $inputArray['user_id'] = $this->customsession->getUserId();
        $data['appList'] = $oauthClientsHandler->getClientAppDetails($inputArray);

        $this->load->view('templates/profile_template', $data);
    }

    public function updateApp($id) {
        if ($this->input->post('submit')) {
            $inputArray = $this->input->post();
            $oauthClientsHandler = new Oauth_clients_handler();
            $inputArray['id'] = $id;
            $output = $oauthClientsHandler->updateAppDetails($inputArray);
            redirect(commonHelperGetPageUrl('developerapi'));
        }

        if ($id > 0) {
            $oauthClientsHandler = new Oauth_clients_handler();
            $inputArray['app_id'] = $id;
            $data['appList'] = $oauthClientsHandler->getClientAppDetails($inputArray);
            $fileHandler = new File_handler();
            $fileArray = array();
            $fileArray['fileids'][] = $data['appList']['response']['appDetails'][0]['app_image'];
            $data['filedata'] = $fileHandler->getData($fileArray);
            $data['coludPath'] = $this->config->item('images_content_path');
        } else {
            redirect(commonHelperGetPageUrl('developerapi'));
        }
        $data['content'] = 'update_api_view.php';
        $data['moduleName'] = 'changePasswordModule';
        $data['pageName'] = 'Dashboard Create APP';
        $data['pageTitle'] = 'MeraEvents | Create APP';
        $data['dashboardPage'] = TRUE; //To not include event_scroll header in the changePassword_view
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'main',
            $this->config->item('js_public_path') . 'dashboard/profile',
            $this->config->item('js_public_path') . 'dashboard/customscript'
        );


        $this->load->view('templates/profile_template', $data);
    }
    public function affiliateBonus() {
        require_once(APPPATH . 'handlers/userpoint_handler.php');
        $userPointHandler = new Userpoint_handler();
        $inputPoints['userId'] = getUserId();
        //$inputPoints['type']='affiliate';
        $userPointResponse=$userPointHandler->getAffiliateUserpoints($inputPoints);
        //print_r($userPointResponse);exit;
        $indexedESPoints=array();
		$finalData=array();
        if($userPointResponse['status'] && $userPointResponse['response']['total']>0){
            $indexedESPoints =  commonHelperGetIdArray($userPointResponse['response']['userPoints'],'eventsignupid');
			
			$eventSignupIds =  array_keys($indexedESPoints);
			if(count($eventSignupIds)>0){
				require_once(APPPATH . 'handlers/eventsignup_handler.php');
				$eventsignupHandler = new Eventsignup_handler();
				require_once(APPPATH . 'handlers/eventsignupticketdetail_handler.php');
				$eventsignupticketdetailHandler = new Eventsignup_Ticketdetail_handler();
				$inputES['eventsignupids']=$eventSignupIds;
				$eventSignupListResponse=$eventsignupHandler->getEventSignupListById($inputES);
                                $ticketinput['groupbyeventsignupid']=1;
                                $ticketinput['eventsignupids']=$eventSignupIds;
				$eventSignupTicketsResponse=$eventsignupticketdetailHandler->getTicketSumByEventSignupIds($ticketinput);
			   // $eventsignupHandler
			}
			
			
			
			$eventSignupData = array();
			if(isset($eventSignupListResponse) && $eventSignupListResponse['status'] && $eventSignupListResponse['response']['total']>0){
				foreach ($eventSignupListResponse['response']['eventsignupList'] as $value) {
					$eventIds[]=$value['eventid'];
					$eventSignupData[$value['id']] = $value;
				}
			}
			
                        $eventSignupTicketsData = array();
			if(isset($eventSignupTicketsResponse) && $eventSignupTicketsResponse['status'] && $eventSignupTicketsResponse['response']['total']>0){
				foreach ($eventSignupTicketsResponse['response']['eventSignupTicketDetailList'] as $tvalue) {
					$eventSignupTicketsData[$tvalue['eventsignupid']]+= $tvalue['ticketcount'];
				}
			}
			//print_r($eventSignupTicketsData); exit;
			
			if(isset($eventIds) && count($eventIds)>0){
				require_once(APPPATH . 'handlers/event_handler.php');
				$eventHandler = new Event_handler();
				$inputEvent['eventids']=$eventIds;
				$eventResponse=$eventHandler->getEventInfoById($inputEvent);
			}
			
			//print_r($indexedESPoints);exit;
			
			$eventData = array();
			if($eventResponse['status'] && $eventResponse['response']['total'] > 0){
				foreach($eventResponse['response']['eventInfo'] as $eventinfo){
					$eventData[$eventinfo['id']]['url'] = commonHelperGetPageUrl('preview-event').$eventinfo['url'];
					$eventData[$eventinfo['id']]['title'] = $eventinfo['title'];
				}
			}
			//print_r($eventData); exit;
			
			$finalData = array();
			foreach($userPointResponse['response']['userPoints'] as $points){
				//print_r($points);
				//$finalData[$value['id']]['url']=$eventData[$eventSignupData[$points['eventsignupid']]['eventid']]['url'].$pointsData[$value['id']]['url'];
				$finalData[$points['id']]['signupid']=$points['eventsignupid'];
				$finalData[$points['id']]['title']=$eventData[$eventSignupData[$points['eventsignupid']]['eventid']]['title'];
				$finalData[$points['id']]['points']=$points['points'];
				$finalData[$points['id']]['type']=$points['type'];
				$finalData[$points['id']]['wallettransferred']=$points['wallettransferred'];
				$finalData[$points['id']]['trtime']=date("d M Y, h:i A",strtotime(convertTime($points['cts'],'Asia/Kolkata',TRUE)));
					
				if($points['type'] == 'viral'){
					//$finalData[$value['id']]['url']=$eventData[$value['eventid']]['url']."?reffCode=".$value['referralcode'];
					$finalData[$points['id']]['url']=$eventData[$eventSignupData[$points['eventsignupid']]['eventid']]['url'];
				}else{
					$finalData[$points['id']]['url']=$eventData[$eventSignupData[$points['eventsignupid']]['eventid']]['url']."?acode=".$eventSignupData[$points['eventsignupid']]['promotercode'];
				}
					
				
			}
			
			
        }
		
		//print_r($finalData); exit;
        
		
		
        
		/*checking, if user has wallet or not*/
		require_once(APPPATH . 'handlers/mywallet_handler.php');
		$mywalletHandler = new MyWallet_handler();
		$walletUserDetails = $mywalletHandler->getWalletUserDetails(array("userId"=>$inputPoints['userId']));
		if($walletUserDetails['status']){
			$walletDetails = $walletUserDetails['response']['walletUserDetails'][0][0];
			
			if($walletDetails['walletstatus'] == 'success'){
				$data['mywallet'] = TRUE;
			}else{
				$data['mywallet'] = FALSE;
			}
			
		}
		//print_r($data); exit;
		/*checking, if user has wallet or not*/
		
		
		/*get total redeemable points*/
		$data['redeemablePoints'] = 0;
		require_once(APPPATH . 'handlers/userpoint_handler.php');
		$this->userPointHandler = new Userpoint_handler();
		$userPointsResponse = $userPointHandler->getUserTotalViralPoints($inputPoints['userId']);
		if($userPointsResponse['status']){
			$data['redeemablePoints'] = $userPointsResponse['response']['userPoints'][0]['points'];
			$totalUserPointIds = $userPointsResponse['response']['userPoints'][0]['ids'];
		}
		//print_r($userPointsResponse); exit;
		/*get total redeemable points*/
		
		
//        echo '<pre>';
//        print_r($finalData);exit;
        $data['affiliateBonusDetails'] = $finalData;
        $data['eventSignupTicketsData'] = $eventSignupTicketsData;
        //print_r($data);exit;
        $data['pageName'] = 'Affiliate Bonus';
        $data['pageTitle'] = 'MeraEvents | Affiliate Bonus';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
        	$this->config->item('js_public_path') . 'dashboard/profile' 
        );
        $data['content'] = 'affiliate_bonus_view';
        $this->load->view('templates/profile_template', $data);
    }
    
    public function networking() {
        $data['pageName'] = 'Networking App';
        $data['pageTitle'] = 'MeraEvents | Networking App';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'networkingapp_view';
        $data['pageType'] = "current";
        $this->load->view('templates/dashboard_template', $data);
    }

    /*
    * Checkin Page
    */

    public function checkin(){
        $data['pageName'] = 'Checkin App';
        $data['pageTitle'] = 'MeraEvents | Checkin App';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'checkinapp_view';
        $this->load->view('templates/dashboard_template', $data);
    }

    /*
     * Bank details File Upload
     * */
    public function bankDetailDocUpload($inputArray) {
        $fileHandler = new File_handler();
        $appFileConfig['fieldName'] = "gstDocument";
        $appPath = $this->config->item('s3_gstDocument_path') . $inputArray['userId'];
        $appFileConfig['upload_path'] = $this->config->item('file_upload_path') . $appPath;
        $appFileConfig['allowed_types'] = CF_ALLOWED_EXTENTIONS;
        $appFileConfig['dbFilePath'] = $appPath . "/";
        $appFileConfig['dbFileType'] = BANK_DOC_TYPE;
        $appFileConfig['folderId'] = $inputArray['userId'];
        $appFileConfig['fileName'] = $_FILES['gstDocument']["name"];
        $appFileConfig['sourcePath'] = $_FILES['gstDocument']["tmp_name"];
        $appFileConfig['imageResize'] = FALSE;
        return $fileHandler->doUpload($appFileConfig);
    }
    /*
     * Pancard details File Upload
     * */
    public function pancardDocUpload($inputArray) {
        $fileHandler = new File_handler();
        $appFileConfig['fieldName'] = "orgpancard";
        $appPath = $this->config->item('s3_orgpancard_path') . $inputArray['userId'];
        $appFileConfig['upload_path'] = $this->config->item('file_upload_path') . $appPath;
        $appFileConfig['allowed_types'] = CF_ALLOWED_EXTENTIONS;
        $appFileConfig['dbFilePath'] = $appPath . "/";
        $appFileConfig['dbFileType'] = BANK_DOC_TYPE;
        $appFileConfig['folderId'] = $inputArray['userId'];
        $appFileConfig['fileName'] = $_FILES['orgpancard']["name"];
        $appFileConfig['sourcePath'] = $_FILES['orgpancard']["tmp_name"];
        $appFileConfig['imageResize'] = FALSE;
        return $fileHandler->doUpload($appFileConfig);
    }
    /*
     * Adharcard details File Upload
     * */
    public function adharDocUpload($inputArray) {
        $fileHandler = new File_handler();
        $appFileConfig['fieldName'] = "orgadharcard";
        $appPath = $this->config->item('s3_orgadharcard_path') . $inputArray['userId'];
        $appFileConfig['upload_path'] = $this->config->item('file_upload_path') . $appPath;
        $appFileConfig['allowed_types'] = CF_ALLOWED_EXTENTIONS;
        $appFileConfig['dbFilePath'] = $appPath . "/";
        $appFileConfig['dbFileType'] = BANK_DOC_TYPE;
        $appFileConfig['folderId'] = $inputArray['userId'];
        $appFileConfig['fileName'] = $_FILES['orgadharcard']["name"];
        $appFileConfig['sourcePath'] = $_FILES['orgadharcard']["tmp_name"];
        $appFileConfig['imageResize'] = FALSE;
        return $fileHandler->doUpload($appFileConfig);
    }
    /*
     * Cancellation Cheque File Upload
     * */
    public function chequeDocUpload($inputArray) {
        $fileHandler = new File_handler();
        $appFileConfig['fieldName'] = "orgcheque";
        $appPath = $this->config->item('s3_orgcheque_path') . $inputArray['userId'];
        $appFileConfig['upload_path'] = $this->config->item('file_upload_path') . $appPath;
        $appFileConfig['allowed_types'] = CF_ALLOWED_EXTENTIONS;
        $appFileConfig['dbFilePath'] = $appPath . "/";
        $appFileConfig['dbFileType'] = BANK_DOC_TYPE;
        $appFileConfig['folderId'] = $inputArray['userId'];
        $appFileConfig['fileName'] = $_FILES['orgcheque']["name"];
        $appFileConfig['sourcePath'] = $_FILES['orgcheque']["tmp_name"];
        $appFileConfig['imageResize'] = FALSE;
        return $fileHandler->doUpload($appFileConfig);
    }
    
    public function organizerEvaluation(){
        $getOrgData = $this->profileHandler->getOrgEvaluationdata();
        if ($this->input->post('submit')) {
            $inputArray = $this->input->post();
            $addOrgEvaluation = $this->profileHandler->addOrgEvaluation($inputArray);
            if ($addOrgEvaluation['status']) {
                $this->customsession->setData('promoterFlashErrorMessage', $addOrgEvaluation['response']['messages'][0]);
                redirect(commonHelperGetPageUrl(organizerEvaluation));
            } else {
                $data['errors'] = $addOrgEvaluation['response']['messages'][0];
            }
        }
        $data['orgEvaluationdata'] = $getOrgData;
        $data['pageName'] = 'Organizer Questionaire';
        $data['pageTitle'] = 'MeraEvents | Organizer Questionaire';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/profile'
            );
        $data['content'] = '../profile/org_questionaire_view';
        $this->load->view('templates/profile_template', $data);
    }

    public function userpartialpayments(){
        $userId = getUserId();
        $partialPaymentEventsList = $this->profileHandler->getUserPartialPaymentEvents($userId);
        if($partialPaymentEventsList['response']['total'] > 0){
            $data['partialPaymentsEvents'] = $partialPaymentEventsList;
        }else{
            $data['partialPaymentsEvents'] = '';
        }
        $data['pageName'] = 'Partial Payments';
        $data['pageTitle'] = 'MeraEvents | Partial Payments';
        $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/profile'
            );
        $data['content'] = '../profile/user_partial_payment_events';
        $this->load->view('templates/profile_template', $data);
    }

    public function paymentdetails($inviteid, $eventid, $ticketid){
        $parentsignupid = $this->profileHandler->getParentSignupId($inviteid);
        $userId = $this->customsession->getUserId();
        $state = $user =array();
        $inputArray['userId'] = $userId;
        $inputArray['major'] = 1;
        $locality = '';

        if($this->session->flashdata('message')){
            $messages = $this->session->flashdata('message');
        }
        $courierFee = 0;
        $personalDetails = $this->profileHandler->getPersonalDetails($inputArray);
        $input['countryId'] = $personalDetails['response']['personalDetails']['0']['response']['userData']['countryid'];
        $input['cityId'] = $personalDetails['response']['personalDetails']['0']['response']['userData']['cityid'];
        $input['stateId'] = $personalDetails['response']['personalDetails']['0']['response']['userData']['stateid'];
        $locality = $this->getLocalityDetails($input);
        $old_mobile = $personalDetails['response']['personalDetails']['0']['response']['userData']['mobile'];
        $inputs['parentsignupid'] = $parentsignupid[0]['id'];
        $inputs['userid'] = $userId;
        $getpaymentsInfo = $this->profileHandler->getUserPartialPayments($inputs);
        $input['eventId'] = $this->uri->segment(5);
        $input['ticketids'] = $this->uri->segment(6);
        $input['parentsignupid'] = $parentsignupid[0]['id'];
        $getNames = $this->profileHandler->getTicketNames($input);
        $orderLogSessionData['ticketarray'] = array($ticketid => 1);
        $selectedTicketData = $orderLogSessionData['ticketarray'];
        require_once(APPPATH . 'handlers/eventsignup_handler.php');
        $this->configureHandler = new Configure_handler();
        $eventCustomFieldsArr = $this->configureHandler->getCustomFields($input);
        $eventId = $input['eventId'];
        if($courierFee == 1){
                $CFInputs['eventId'] = $eventId;
                $CFInputs['commonfieldids'] = array(4,5,6,7,10);
                $CFInputs['nonActiveCustomField'] = TRUE;
                $CFFieldsRes = $configureHandler->getCustomFields($CFInputs);
            }
            $eventCustomFields = $eventLevelCustomFields = $ticketLevelCustomFields = $gstCustomFields = array();
            if ($eventCustomFieldsArr['status'] && $eventCustomFieldsArr['response']['total'] > 0) {
                $tempEventCustomFieldsArray = $eventCustomFieldsArr['response']['customFields'];
                if (isset($CFFieldsRes) && $CFFieldsRes['status'] && $CFFieldsRes['response']['total'] > 0) {
                    $CFFields = $CFFieldsRes['response']['customFields'];
                    $tempEventCustomFieldsArray = array_merge($tempEventCustomFieldsArray,$CFFields);
                    $tempEventCustomFieldsArray = commonHelperGetIdArray($tempEventCustomFieldsArray);
                    foreach($tempEventCustomFieldsArray as $k => $v){
                        $tempEventCustomFieldsArray[$k]['fieldmandatory'] = 1;
                    }
                }
            }

            if($courierFee == 2){
                $notNeededFields = array(4,5,6,7,10);
                foreach($tempEventCustomFieldsArray as $key => $value){
                    if(in_array($value['commonfieldid'], $notNeededFields)){
                        unset($tempEventCustomFieldsArray[$key]);
                    }
                }
            }

            $indexedTempEventCustomFieldsArray=  commonHelperGetIdArray($tempEventCustomFieldsArray);
            $customFieldIdsArray = array_column($tempEventCustomFieldsArray, 'id');
            $customFieldValuesInput['customFieldIdArray'] = $customFieldIdsArray;
            $tempEventCustomFieldsArr = $this->configureHandler->getCustomFieldValues($customFieldValuesInput);
            $eventCustomFieldsArr = $tempEventCustomFieldsArr['response']['fieldValuesInArray'];
            foreach ($eventCustomFieldsArr as $eventCustomField) {
                $eventCustomFieldValueArr[$eventCustomField['customfieldid']][] = $eventCustomField;
            }
            /* Getting Ticketwise details starts here */
            $data['ticketData'] = $selectedTicketData;

            foreach ($selectedTicketData as $ticketId => $ticketQty) {
                $calculateTicketArr[$ticketId]['selectedQty'] = $ticketQty;

                /* Getting Custom fields for the event and ticketwise starts here */
                foreach ($tempEventCustomFieldsArray as $customFieldArr) {
                    $customFieldArr['customFieldValues'][$customFieldArr['id']] = isset($eventCustomFieldValueArr[$customFieldArr['id']])?$eventCustomFieldValueArr[$customFieldArr['id']]:array();
                    if($customFieldArr['fieldlevel'] == 'event' && in_array($customFieldArr['commonfieldid'], array(11, 12, 13))){
                        $gstCustomFields[] = $customFieldArr;
                    }elseif ($customFieldArr['fieldlevel'] == 'event') {
                        $eventCustomFields[$ticketId][] = $customFieldArr;
                    } elseif ($customFieldArr['fieldlevel'] == 'ticket' && $customFieldArr['ticketid'] == $ticketId) {
                        $eventCustomFields[$ticketId][] = $customFieldArr;
                    }
                }
                /* Getting Custom fields for the event and ticketwise ends here */
            }

            $data['customFieldsArray'] = $eventCustomFields;
            $data['gstCustomFields'] = $gstCustomFields;
            
                //get file upload custom field data

        $allFileCustData = array();
        $inputFileData['eventid'] = $eventId;
        $inputFileData['eventsignupids'] = array($orderLogData['eventsignup']);
        //$inputFileData['reporttype'] = $reportType;
          $eventsignupHandler = new Eventsignup_handler();    
        $fileUploadsResponse = $eventsignupHandler->getFileTypeCustomFieldData($inputFileData);

       
        if ($fileUploadsResponse['status']) {
            if ($fileUploadsResponse['response']['total'] > 0) {
                //print_r($fileUploadsResponse); exit;
                foreach ($fileUploadsResponse['response']['attendeedetailData'] as $esId => $ticktIds) {
                    foreach ($ticktIds as $ticktId => $serialKeys){
                        foreach ($serialKeys as $serialKey => $attendeeData) {
                            foreach ($attendeeData as $custId => $fileData) {
                                //print_r($attendeeData);
                                // $response[$esId]['customfields'][$custId] = $this->ci->config->item('images_content_path') . $this->ci->config->item('s3_customField_path') . $eventId . "/" . $fileData['value'];
                                $response[$esId]['customfields'][$custId] = $fileData['value'];
                            }
                        }
                    }
                    
                }
                $output['response']['downloadAllRequired'] = true;
                //$allFileCustData = $fileUploadsResponse['response']['attendeedetailData'];
            }
        }
            $data['customFieldsFileData'] = $response;
            $data['calculateTicketArr'] = $calculateTicketArr;
        $data['partialpaymentinviteid'] = $this->uri->segment(4);
        $data['pastPayments'] = $getpaymentsInfo;
        $data['eventid'] = $this->uri->segment(5);
        $data['ticketid'] = $this->uri->segment(6);
        $data['getNamesInfo'] = $getNames;
        $data['parentsignupid'] = $parentsignupid[0]['id'];
        $data['personalDetails'] = $personalDetails;
        $data['locality'] = $locality;
        $data['pageName'] = 'Partial Payments';
        $data['pageTitle'] = 'MeraEvents | Partial Payments';
        $data['hideLeftMenu'] = 1;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/profile'
            );
        $data['customfields'] = $data['customFieldsArray'][$ticketid];
        $data['content'] = '../profile/user_partial_payment_details';
        $this->load->view('templates/profile_template', $data);
    }
}

?>