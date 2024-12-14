<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Organization controller (Grouping of events Page)
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, Meraevents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     07-12-2015
 * @Last Modified On  07-12-2015
 * @Last Modified By  Raviteja
 */
require_once(APPPATH . 'handlers/organization_handler.php');
require_once(APPPATH . 'handlers/common_handler.php');
class Organization extends CI_Controller {

    var $organizationHandler;
    var $commonHandler;

    public function __construct() {
        parent::__construct();
        $this->organizationHandler = new organization_handler();
        $this->commonHandler = new Common_handler();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;
    }

    public function index() {
       
        $segment=$this->uri->segment(3);
        if(isset($segment) && $segment !=''){
            $getVar['orgid'] = $this->uri->segment(3);
        }else{
            $getVar['slug'] = $this->uri->segment(2);
            $result = $this->db->select('id')->from('organization')->where('slug', $getVar['slug'])->limit(1)->get()->row();
            $getVar['orgid'] = $result->id;
        }
       
        $getParams = $this->input->get();
        if(isset($getParams['ucode']) && $getParams['ucode'] == 'organizer'){
            $getVar['effort'] = 'organizer';
        }
        $data['countryList']='';
        $data['categoryList']='';
        $cookieData = $this->commonHandler->headerValues();
        $footerValues = $this->commonHandler->footerValues();
        $data['eventsData']=array();
        $data['organizationDetails']= array();
        if (count($cookieData) > 0) {
        	$data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
        	$this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }
        $getVar['type'] = 'upcoming';
        $organizationDetails = $this->organizationHandler->getOrganizationDetails($getVar);
        if($organizationDetails['status'] && $organizationDetails['response']['totalcount'] == 0){
        	$getVar['type'] = 'past';
        	$organizationDetails = $this->organizationHandler->getOrganizationDetails($getVar);
        }
        if( !$organizationDetails['status'] || empty($organizationDetails['response']['organizationData'])  ){
        	$data['content'] = 'error_view';
        	$data['message'] = ERROR_NO_RECORDS;
        }else{
        	$data['content'] = 'organization_view';
            if(isset($getVar['effort'])){
                foreach($organizationDetails['response']['OrganizationEventsData'] as $key => $value){
                    $organizationDetails['response']['OrganizationEventsData'][$key]['url'] = $value['url'].'?ucode=organizer';
                }
            }
        }
       	$organizationList = $organizationDetails['response']['organizationData'];
        $updatedViews = $this->organizationHandler->updateViewCount($organizationList[0]);
        if($updatedViews['status']){
            $organizationList[0]['viewcount'] = $organizationList[0]['viewcount']+1;
        }
       	$data['organizationDetails']= $organizationList[0]; 
       	$data['eventsData'] =$organizationDetails['response']['OrganizationEventsData'] ;
       	$data['totalCount'] =$organizationDetails['response']['totalcount'];
       	$data['pageType']= $getVar['type'];
       	$data['jsArray'] = array(
             $this->config->item('js_public_path') . 'jquery.validate',
             $this->config->item('js_public_path') . 'organization',
             $this->config->item('js_public_path') . 'inviteFriends',
            'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap',
            'https://static.addtoany.com/menu/page',
       	);
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'themify-icons',
            $this->config->item('css_public_path') . 'bootstrap-4.3.1',
            $this->config->item('css_public_path') . 'rangeslider',
            $this->config->item('css_public_path') . 'lightgallery',
            $this->config->item('css_public_path') . 'style_innnerpage',
	);
      
       if(isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0){
            $data['logopath'] = $this->config->item('images_content_cloud_path') . $organizationList[0]['logoPath'];
        }else{
             $data['logopath'] = $this->config->item('images_content_cloud_path') . $organizationList[0]['logoPath'];
        }
        $data['categoryList'] = $footerValues['categoryList'];
        $data['cityList'] = $footerValues['cityList'];
        $data['defaultCountryId'] = $this->defaultCountryId;
       
        $this->load->view('templates/innerpage_template', $data);
    }

}

?>