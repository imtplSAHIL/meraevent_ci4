<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once (APPPATH . 'handlers/salesperson_handler.php');
require_once (APPPATH . 'handlers/eventsalespersonmapping_handler.php');
require_once (APPPATH . 'handlers/email_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/messagetemplate_handler.php');
require_once(APPPATH . 'handlers/profile_handler.php');
require_once(APPPATH . 'handlers/organization_handler.php');

class Organization extends CI_Controller
{

    var $eventsalespersonmapping;
    var $salesperson;
    var $emailhandler;
    var $userHandler;
    var $messagetemplateHandler;
    var $profileHandler;

    public function __construct()
    {
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

    public function index()
    {
        $userId = $this->customsession->getUserId();
        $inputArray['userId'] = $userId;
        $inputArray['major'] = 1;

        if ($this->session->flashdata('message')) {
            $messages = $this->session->flashdata('message');
        }

        if($this->input->post()){
            $userInfo['userid'] = $userId;
            $userInfo['orgid'] = $this->input->post("org_id");
            $userInfo['name'] = $this->input->post("name");
            $userInfo['slug'] = $this->input->post("slug");
            $userInfo['domain'] = $this->input->post("domain");
            $userInfo['information'] = $_POST["information"];
            $userInfo['seotitle'] = $this->input->post("seotitle");
            $userInfo['seokeywords'] = $this->input->post("seokeywords");
            $userInfo['seodescription'] = $this->input->post("seodescription");
            $userInfo['facebooklink'] = $this->input->post("facebooklink");
            $userInfo['twitterlink'] = $this->input->post("twitterlink");
            $userInfo['linkedinlink'] = $this->input->post("linkedinlink");
            $userInfo['instagramlink'] = $this->input->post("instagramlink");
            $userInfo['logopathid'] = $_FILES['logopathid'];
           // print_r($userInfo);exit;
            $updatePersonalData = $this->organizationHandler->insertOrganizer($userInfo);
            if ($updatePersonalData['status']) {
                redirect(commonHelperGetPageUrl('magage_organizer'));
            } else {
                $data['output'] = $updatePersonalData['response']['messages'][0];
            }
        }

        $orgnizerData = $this->organizationHandler->getOrganizationPageDetails($inputArray);
        $data['content'] = 'organizer_details_view';
        $data['pageName'] = 'Organization Details';
        $data['pageTitle'] = 'MeraEvents | Organization Details';
        $data['hideLeftMenu'] = 1;

        $data['orgnizerDetails'] = $orgnizerData['response']['organizationData'][0];
        $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'intlTelInput');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'intlTelInput');
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/profile');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function getLocalityDetails($idsArray)
    {
        if ($idsArray['countryId'] > 0) {
            $country = $this->countryHandler->getCountryListById($idsArray);
            $locality = $countryName = $country['response']['detail']['name'];
        }
        if ($idsArray['stateId'] > 0) {
            $state = $this->stateHandler->getStateListById($idsArray);
            $stateName = $state['response']['stateList']['0']['name'];
            $locality = $stateName . "," . $countryName;
        }
        if ($idsArray['cityId'] > 0) {
            $city = $this->cityHandler->getCityDetailById($idsArray);
            $cityName = $city['response']['detail']['name'];
            $locality = $cityName . "," . $stateName . "," . $countryName;
        }
        return $locality;
    }

}

?>