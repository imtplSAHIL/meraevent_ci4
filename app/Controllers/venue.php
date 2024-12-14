<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Venue controller (Grouping of events Page by venue)
 *
 * @package		CodeIgniter
 * @author		Ani Reddy 
 * @copyright           Copyright (c) 2015, Meraevents.
 * @Version		Version 1.0
 * @Since               Class available 29-11-17 
 * @Created             29-11-17
 * @Last Modified On    29-11-17
 * @Last Modified By    Shashank
 */
require_once(APPPATH . 'handlers/venue_handler.php');
require_once(APPPATH . 'handlers/city_handler.php');
require_once(APPPATH . 'handlers/common_handler.php');
class Venue extends CI_Controller {

    var $venueHandler;
    var $commonHandler;

    public function __construct() {
        parent::__construct();
        $this->venueHandler = new Venue_handler();
        $this->commonHandler = new Common_handler();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;
    }

    public function index() {
        $cityUrl = $this->uri->segment(2);
        $venueUrl = $this->uri->segment(3);
        if(strlen($venueUrl) > 0){
            $request['url'] = $venueUrl;
        }
        if(strlen($cityUrl) > 0 && isset($request['url'])){
            $request['cityUrl'] = $cityUrl;
        }
        if(!isset($request['url']) && strlen($cityUrl) > 0){
            $inputArray['cityUrl'] = $cityUrl;
            $cityIdRes = $this->venueHandler->getCityId($inputArray);
            if($cityIdRes['status'] == TRUE && $cityIdRes['response']['total'] > 0){
                $CVInput['cityId'] = $cityIdRes['response']['cityId'];
                $CVInput['rowId'] = $cityIdRes['response']['rowId'];
                $CVInput['page'] = 1;
                $request['url'] = $cityUrl;
            }
        }
        $venueDataRes = $this->venueHandler->getVenueDetails($request);
        if($venueDataRes['status'] == FALSE || $venueDataRes['response']['total'] == 0){
            $url = site_url_get();
            commonHelperRedirect($url);
        }
        $venueData = $venueDataRes['response']['venueData'];

        if(!isset($request['cityId']) && !isset($CVInput)){
            //Events display based on Venue
            $VHInputs['venueName'] = $venueData['name'];
            $VHInputs['cityId'] = $venueData['cityid'];
            $VHInputs['excludeEvents'] = $venueData['eventid'];
            $eventsDataRes = $this->venueHandler->getVenueEvents($VHInputs);
            $this->cityHandler = new City_handler();
            $cityName = $this->cityHandler->getNames(array('cityIds' => $venueData['cityid']));
            $data['cityName'] = $cityName['response']['cityName'][0]['name'];
            $data['defaultImagePath'] = $this->config->item('images_content_cloud_path');
            $data['content'] = 'venue_events_view';
            $data['url']= $venueUrl; 
            $data['cityUrl']= $cityUrl; 
            $data['venueDetails']= $venueData;
            $data['eventsData'] = $eventsDataRes['response']['eventList'];
            $data['totalCount'] = $eventsDataRes['response']['totalCount'];
            $data['jsArray'] = array(
                 $this->config->item('js_public_path') . 'venue_events'    
            );
        
        }else{
            //Venues Display based on City
            $venuesDataRes = $this->venueHandler->getCityVenues($CVInput);
            $data['content'] = 'venue_view';
            $data['cityId']= $CVInput['cityId'];
            $data['rowId']= $CVInput['rowId'];
            $data['page']= $CVInput['page'] + 1;
            $data['cityDetails']= $venueData; 
            $data['venuesData'] = $venuesDataRes['response']['venueData'];
            $data['totalCount'] = $venuesDataRes['response']['totalCount'];
            $data['jsArray'] = array(
                 $this->config->item('js_public_path') . 'venue'    
            );
        }

        $data['pageTitle'] = (isset($venueData['seotitle']) && strlen($venueData['seotitle']) > 0)? ucwords($venueData['seotitle']) : ucwords($venueData['name']);
        if(strlen($venueData['seokeywords']) > 0 &&  strlen($venueData['seodescription']) > 0){
            $data['pageKeywords'] = $venueData['seokeywords'];
            $data['seoDescription'] = $venueData['seodescription'];
            $data['seoStaus'] = TRUE;
        }
        $data['defaultCityName'] = ucwords($cityUrl);
        $data['defaultCityId'] = $venueData['cityid'];
        //Footer categories
        $data['countryList']='';
        $data['categoryList']='';
        $cookieData = $this->commonHandler->headerValues();
        $footerValues = $this->commonHandler->footerValues();
        if (count($cookieData) > 0) {
        	$data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
        	$this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }
        $data['categoryList'] = $footerValues['categoryList'];
		$data['cityList'] = $footerValues['cityList'];
        $data['defaultCountryId'] = $this->defaultCountryId;
        $this->load->view('templates/user_template', $data);
    }

}

?>