<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Payment page controller
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, MeraEvents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     11-06-2015
 * @Last Modified On  18-02-2016
 * @Last Modified By  Shashi
 */
//require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/microsite_handler.php');

class Microsite extends CI_Controller {

    //var $commonHandler;
    var $micrositeHandler;

    public function __construct() {
        parent::__construct();
        //$this->commonHandler = new Common_handler();
        $this->micrositeHandler = new Microsite_handler();
    }

    /*
     * Function to display the booking page
     *
     * @access	public
     * @return	Display the Booking form with the custom fields and payment gateways
     */

    public function index($name, $param = '') {
		
        $name = trim($name);
        $microsite_path = site_url('microsites/' . $name);
		define('_HTTP_MICROSITE_CF_ROOT', $this->config->item('images_cloud_path').'microsites/'. $name);
		//if (in_array($name,array('dandiya','newyear','holi'))) {
         if (in_array($name,array('dandiya','newyear','holi','pushkarmela','valentinesday'))) {
            define('_HTTP_CF_ROOT', $this->config->item('images_cloud_path'));
            define('_HTTP_SITE_ROOT', site_url());
			
			
			$this->MeraEventsDynamicMicroSites($name,$param);
			return true;
		}
		
		
		
        /*if ($name == 'dandiya') {
            //define('_HTTP_CF_ROOT', $this->config->item('images_cloud_path'));
            //define('_HTTP_SITE_ROOT', site_url());
            include FCPATH . 'microsites/' . $name . '/templates/index_tpl.php';
            return true;
        }
         //echo FCPATH . 'microsites\\' . $name . '\\' . $param . '.php';exit;
        if (!empty($param)) {
            //echo FCPATH . 'microsites\\' . $name . '\\' . $param . '.php';exit;
            include FCPATH . 'microsites/' . $name . '/' . $param ;
            return true;
        }*/
		else
		{
			if(is_dir(FCPATH . 'microsites/' . $name)){
				include FCPATH . 'microsites/' . $name . '/index.php';
        		return true;
			}else{
        		return false;
			}
        	
		}
    }
	
	
	/*for holi, newyear, dandiya etc ..*/
	public function MeraEventsDynamicMicroSites($micrositename,$city)
	{
		//$this->output->enable_profiler(TRUE);
		
		
		
		require_once(APPPATH . 'handlers/banner_handler.php');
		$bannerHandler = new Banner_handler();
		
		require_once(APPPATH . 'handlers/newyearfilters_handler.php');
		$newyearfiltersHandler = new Newyearfilters_handler();
		
		require_once(APPPATH . 'handlers/specialdiscount_handler.php');
		$specialDiscountHandler = new SpecialDiscount_handler();
		
		require_once(APPPATH . 'handlers/solr_handler.php');
		$solrHandler = new Solr_handler();
		
		
		require_once(APPPATH . 'handlers/event_handler.php');
		$eventHandler = new Event_handler();
		
		require_once(APPPATH . 'handlers/seodata_handler.php');
		$seoHandler = new Seodata_handler();
		
		
		$bannerInputArray = $data = array();
		
		
		$listedCities = array('hyderabad'=>47,"bengaluru"=>37,"mumbai"=>14,"pune"=>77,"chennai"=>39,"ahmedabad"=>40,"pondicherry"=>407,"jaipur"=>41,"kolkata" => 42);
		$listedStates = array("delhi"=>53,"goa"=>11);
		$listedRegions = array("delhi"=>38,"goa"=>1231);
		
		
		
		
		$inputArray = array();
		
		
		$inputArray['page'] = 1;
		$inputArray['start'] = 0;
		$inputArray['limit'] = 24;
		
		//India
		$inputArray['countryId'] = $bannerInputArray['countryId'] = 14;
		$inputArray['categoryId'] = $bannerInputArray['categoryId'] = 1;
		
		$data['currentCity']=(empty($city))?'INDIA':strtoupper($city);
		
		if(array_key_exists($city,$listedCities)){
			$inputArray['cityId'] = $listedCities[$city];
		}
		elseif(array_key_exists($city,$listedStates)){
			$inputArray['stateId'] = $data['stateId'] = $listedStates[$city];
		}

	if($micrositename == 'holi')
		{  
			$inputArray['categoryId'] = 13;
			$bannerInputArray['type'] = 4; // 3-newyear, 4-Holi
			if($city == 'others'){
                $inputArray['excludeCities'] = array(47,37,14,40,77,407,39,41,139,448,504,38,1231,13073,409,23189,330,331,31472,383,1358,10124,324,350,1214,8982,1138,1224,581,408,32159,32160,32161,32162,32163,32164,32165,45717,550);
                $inputArray['excludeStates'] = array(53,11);
            }
			
		/*if(empty($city) || ($city == "india")){
		$data['pageTitle'] = 'Holi events in India 2019 | Holi festival India 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in India March 2019 and Holi festivals in India with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in india, holi events in india, holi parties in india, holi celebrations in india, holi colours, 2019 holi colours, festival of colours, festival of love";
		}else if($city == "hyderabad")
		{
			$data['pageTitle'] = 'Holi events in Hyderabad 2019 | Holi festival Hyderabad 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Hyderabad March 2019 and Holi festivals in Hyderabad with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in hyderabad, holi events in hyderabad, holi parties in hyderabad, holi celebrations in hyderabad, holi colours, 2019 holi colours, festival of colours, festival of love";
			
		}else if($city == "bengaluru")
		{
			$data['pageTitle'] = 'Holi events in Bangalore 2019 | Holi festival Bangalore 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Bangalore March 2019 and Holi festivals in Bangalore with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in bangalore, holi events in bangalore, holi parties in bangalore, holi celebrations in bangalore, holi colours, 2019 holi colours, festival of colours, festival of love";
		}else if($city == "mumbai")
		{
			$data['pageTitle'] = 'Holi events in Mumbai 2019 | Holi festival Mumbai 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Mumbai March 2019 and Holi festivals in Mumbai with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in mumbai, holi events in mumbai, holi parties in mumbai, holi celebrations in mumbai, holi colours, 2019 holi colours, festival of colours, festival of love";
		}else if($city == "pune")
		{
			$data['pageTitle'] = 'Holi events in Pune 2019 | Holi festival Pune 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Pune March 2019 and Holi festivals in Pune with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in pune, holi events in pune, holi parties in pune, holi celebrations in pune, holi colours, 2019 holi colours, festival of colours, festival of love";
		}else if($city == "chennai")
		{
			$data['pageTitle'] = 'Holi events in Chennai 2019 | Holi festival Chennai 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Chennai March 2019 and Holi festivals in Chennai with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in chennai, holi events in chennai, holi parties in chennai, holi celebrations in chennai, holi colours, 2019 holi colours, festival of colours, festival of love";
		}else if($city == "goa")
		{
			$data['pageTitle'] = 'Holi events in Goa 2019 | Holi festival Goa 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Goa March 2019 and Holi festivals in Goa with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in goa, holi events in goa, holi parties in goa, holi celebrations in goa, holi colours, 2019 holi colours, festival of colours, festival of love";
		}else if($city == "delhi")
		{
			$data['pageTitle'] = 'Holi events in Delhi 2019 | Holi festival Delhi 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Delhi March 2019 and Holi festivals in Delhi with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in delhi, holi events in delhi, holi parties in delhi, holi celebrations in delhi, holi colours, 2019 holi colours, festival of colours, festival of love";
		}
		else if($city == "ahmedabad")
		{
			$data['pageTitle'] = 'Holi events in Ahmedabad 2019 | Holi festival Ahmedabad 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Ahmedabad March 2019 and Holi festivals in Ahmedabad with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in ahmedabad, holi events in ahmedabad, holi parties in ahmedabad, holi celebrations in ahmedabad, holi colours, 2019 holi colours, festival of colours, festival of love";
		}
		else if($city == "kolkata")
		{
			$data['pageTitle'] = 'Holi events in Kolkata 2019 | Holi festival Kolkata 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Kolkata March 2019 and Holi festivals in Kolkata with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in kolkata, holi events in kolkata, holi parties in kolkata, holi celebrations in kolkata, holi colours, 2019 holi colours, festival of colours, festival of love";
		}
		else if($city == "jaipur")
		{
			$data['pageTitle'] = 'Holi events in Jaipur 2019 | Holi festival Jaipur 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in Jaipur March 2019 and Holi festivals in Jaipur with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in Jaipur, holi events in Jaipur, holi parties in Jaipur, holi celebrations in kolkata, holi colours, 2019 holi colours, festival of colours, festival of love";
		}else if($city == "others")
		{
			$data['pageTitle'] = 'Holi events in your city 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in your city March 2019 and Holi festivals in your city with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in your city, holi events in your city, holi parties in your city, holi celebrations in kolkata, holi colours, 2019 holi colours, festival of colours, festival of love";
                }
         else if($city == "pondicherry")
		{
			$data['pageTitle'] = 'Holi events in pondicherry 2019 | Holi festival pondicherry 2019 - MeraEvents';
		$data['pageDescription']="Holi is a traditional Hindu festival, celebrates the beginning of spring with the festival of colours. Book tickets online for upcoming Holi events in pondicherry March 2019 and Holi festivals in pondicherry with MeraEvents. Let's celebrate this Holi with colours, rain dance, DJ, and unlimited liquor.";
        $data['pageKeywords'] = "holi events 2019, holi festivals 2019, holi celebrations 2019, holi parties 2019, holi festivals in pondicherry, holi events in pondicherry, holi parties in pondicherry, holi celebrations in kolkata, holi colours, 2019 holi colours, festival of colours, festival of love";
		}	*/		
		
			$uri_city = "holi";
            if(!empty($city)){
                $uri_city = "holi/".$city;
            }
	
			/*$newyearfiltersList = $newyearfiltersHandler->getFilterList();
			//print_r($newyearfiltersList); exit;
			 if ($newyearfiltersList['status'] == true && $newyearfiltersList['response']['total']>0) {
	            $data['newyearfiltersList'] = $newyearfiltersList['response']['newyearfiltersList'];
	        }*/

	}
		 

		if($micrositename == 'newyear')
		{  
                    if($city == 'others'){
                        $inputArray['excludeCities'] = array(47,37,14,77,39,40,407,41,139,448,504,38,1231,13073,409,23189,330,331,31472,383,1358,10124,324,350,1214,8982,1138,1224,581,408,32159,32160,32161,32162,32163,32164,32165,45717,550);
                        $inputArray['excludeStates'] = array(53,11);
                    }
			$inputArray['categoryId'] = 8;
			$bannerInputArray['type'] = 3; // 3-newyear, 4-Holi
			
		if(empty($city) || ($city == "india")){
		$data['pageTitle'] = 'New year eve Party Events & Celebrations in India 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in India 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in india 2021, new year parties in india 2021, new year celebrations in india 2021, new year eve in india 2021, india new year events 2021, india new year parties 2021, india new year celebrations 2021, india new year eve 2021, best new year places in india, best new year locations in india, new year events for kids in india";
		}else if($city == "hyderabad")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Hyderabad 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Hyderabad 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in hyderabad 2021, new year parties in hyderabad 2021, new year celebrations in hyderabad 2021, new year eve in hyderabad 2021, hyderabad new year events 2021, hyderabad new year parties 2021, hyderabad new year celebrations 2021, hyderabad new year eve 2021, best new year places in hyderabad, best new year locations in hyderabad, new year events for kids in Hyderabad";
			
		}else if($city == "bengaluru")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Bangalore 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Bangalore 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in bangalore 2021, new year parties in bangalore 2021, new year celebrations in bangalore 2021, new year eve in bangalore 2021, bangalore new year events 2021, bangalore new year parties 2021, bangalore new year celebrations 2021, bangalore new year eve 2021, best new year places in bangalore, best new year locations in bangalore, new year events for kids in bangalore";
		}else if($city == "mumbai")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Mumbai 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Mumbai 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in mumbai 2021, new year parties in mumbai 2021, new year celebrations in mumbai 2021, new year eve in mumbai 2021, mumbai new year events 2021, mumbai new year parties 2021, mumbai new year celebrations 2021, mumbai new year eve 2021, best new year places in mumbai, best new year locations in mumbai, new year events for kids in mumbai";
		}else if($city == "pune")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Pune 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Pune 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in pune 2021, new year parties in pune 2021, new year celebrations in pune 2021, new year eve in pune 2021, pune new year events 2021, pune new year parties 2021, pune new year celebrations 2021, pune new year eve 2021, best new year places in pune, best new year locations in pune, new year events for kids in pune";
		}else if($city == "chennai")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Chennai 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Chennai 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in chennai 2021, new year parties in chennai 2021, new year celebrations in chennai 2021, new year eve in chennai 2021, chennai new year events 2021, chennai new year parties 2021, chennai new year celebrations 2021, chennai new year eve 2021, best new year places in chennai, best new year locations in chennai, new year events for kids in Chennai";
		}else if($city == "goa")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Goa 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Goa 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in goa 2021, new year parties in goa 2021, new year celebrations in goa 2021, new year eve in goa 2021, goa new year events 2021, goa new year parties 2021, goa new year celebrations 2021, goa new year eve 2021, best new year places in goa, best new year locations in goa, new year events for kids in goa";
		}else if($city == "delhi")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Delhi NCR 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Delhi NCR 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in delhi ncr 2021, new year parties in delhi ncr 2021, new year celebrations in delhi ncr 2021, new year eve in delhi ncr 2021, delhi ncr new year events 2021, delhi ncr new year parties 2021, delhi ncr new year celebrations 2021, delhi ncr new year eve 2021, best new year places in delhi ncr, best new year locations in delhi ncr, new year events for kids in delhi ncr";
		}
		else if($city == "ahmedabad")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Ahmedabad 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Ahmedabad 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in ahmedabad 2021, new year parties in ahmedabad 2021, new year celebrations in ahmedabad 2021, new year eve in ahmedabad 2021, ahmedabad new year events 2021, ahmedabad new year parties 2021, ahmedabad new year celebrations 2021, ahmedabad new year eve 2021, best new year places in ahmedabad, best new year locations in ahmedabad, new year events for kids in ahmedabad";
		}
		else if($city == "kolkata")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Kolkata 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Kolkata 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in kolkata 2021, new year parties in kolkata 2021, new year celebrations in kolkata 2021, new year eve in kolkata 2021, kolkata new year events 2021, kolkata new year parties 2021, kolkata new year celebrations 2021, kolkata new year eve 2021, best new year places in kolkata, best new year locations in kolkata, new year events for kids in kolkata";
		}
		else if($city == "jaipur")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Jaipur 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Jaipur 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in jaipur 2021, new year parties in jaipur 2021, new year celebrations in jaipur 2021, new year eve in jaipur 2021, jaipur new year events 2021, jaipur new year parties 2021, jaipur new year celebrations 2021, jaipur new year eve 2021, best new year places in jaipur, best new year locations in jaipur, new year events for kids in jaipur";
		}else if($city == "others")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in your city 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in your city 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in your city 2021, new year parties in your city 2021, new year celebrations in your city 2021, new year eve in your city 2021, new year events 2021, your city new year parties 2021, your city new year celebrations 2021, your city new year eve 2021, best new year places in your city, best new year locations in your city, new year events for kids in your city";
                }else if($city == "pondicherry")
		{
			$data['pageTitle'] = 'New year eve Party Events & Celebrations in Pondicherry 2021 - MeraEvents';
		$data['pageDescription']="Explore best New Year Parties, & Events in Pondicherry 2021 with ME. Celebrate this new year eve Dec 31st, 2021 in best place of partying to romantic dining and entertainment to family-friendly events.";
        $data['pageKeywords'] = "new year events in pondicherry 2021, new year parties in pondicherry 2021, new year celebrations in pondicherry 2021, new year eve in pondicherry 2021, pondicherry new year events 2021, pondicherry new year parties 2021, pondicherry new year celebrations 2021, pondicherry new year eve 2021, best new year places in pondicherry, best new year locations in pondicherry, new year events for kids in pondicherry";
		}

			
			$uri_city = "newyear";
                        if(!empty($city)){
                            $uri_city = "newyear/".$city;
                        }
		
		$newyearfiltersList = $newyearfiltersHandler->getFilterList();
		//print_r($newyearfiltersList); exit;
		 if ($newyearfiltersList['status'] == true && $newyearfiltersList['response']['total']>0) {
            $data['newyearfiltersList'] = $newyearfiltersList['response']['newyearfiltersList'];
        }
		}
		if($micrositename == 'dandiya')
		{  
			$inputArray['subcategoryId'] = array(8);
			$bannerInputArray['type'] = 4; // 3-newyear, 4-Holi
			
			if(empty($city) || ($city == "india")){
		$data['pageTitle'] = 'Dandiya Dance & Navratri Garba Dance Events in India 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in India 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "Dandiya events in India, dandiya dance in India, dandiya in India, garba events in India, Navratri garba in India, raas in India, garba raas in India, ras garba in India, dandiya events in India 2021, upcoming dandiya events in India, dandiya tickets 2021";
		}else if($city == "hyderabad")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Hyderabad 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Hyderabad 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in hyderabad, dandiya dance in hyderabad, dandiya in hyderabad, garba events in hyderabad, navratri garba in hyderabad, raas in hyderabad, garba raas in hyderabad, ras garba in hyderabad, dandiya events in hyderabad 2021, upcoming dandiya events in hyderabad 2021,dandiya tickets 2021";
			
		}else if($city == "bengaluru")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Bangalore 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Bangalore 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in bangalore, dandiya dance in bangalore, dandiya in bangalore, garba events in bangalore, navratri garba in bangalore, raas in bangalore, garba raas in bangalore, ras garba in bangalore, dandiya events in bangalore 2021, upcoming dandiya events in bangalore, dandiya tickets 2021";
		}else if($city == "mumbai")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Mumbai 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Mumbai 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in mumbai, dandiya dance in mumbai, dandiya in mumbai, garba events in mumbai, navratri garba in mumbai, raas in mumbai, garba raas in mumbai, ras garba in mumbai, dandiya events in mumbai 2021, upcoming dandiya events in mumbai,dandiya tickets 2021";
		}else if($city == "pune")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Pune 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Pune 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in pune, dandiya dance in pune, dandiya in pune, garba events in pune, navratri garba in pune, raas in pune, garba raas in pune, ras garba in pune, dandiya events in pune 2021, upcoming dandiya events in pune,dandiya tickets 2021";
		}else if($city == "chennai")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Chennai 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Chennai 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in chennai, dandiya dance in chennai, dandiya in chennai, garba events in chennai, navratri garba in chennai, raas in chennai, garba raas in chennai, ras garba in chennai, dandiya events in chennai 2021, upcoming dandiya events in chennai,dandiya tickets 2021";
		}else if($city == "goa")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Goa 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Goa 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in goa, dandiya dance in goa, dandiya in goa, garba events in goa, navratri garba in goa, raas in goa, garba raas in goa, ras garba in goa, dandiya events in goa 2021, upcoming dandiya events in goa,dandiya tickets 2021";
		}else if($city == "delhi")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Delhi 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Delhi 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in delhi, dandiya dance in delhi, dandiya in delhi, garba events in delhi, navratri garba in delhi, raas in delhi, garba raas in delhi, ras garba in delhi, dandiya events in delhi 2021, upcoming dandiya events in delhi, dandiya tickets 2021";
		}
		else if($city == "ahmedabad")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Ahmedabad 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Ahmedabad 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in ahmedabad, dandiya dance in ahmedabad, dandiya in ahmedabad, garba events in ahmedabad, navratri garba in ahmedabad, raas in ahmedabad, garba raas in ahmedabad, ras garba in ahmedabad, dandiya events in ahmedabad 2021, upcoming dandiya events in ahmedabad, dandiya tickets 2021";
		}
		else if($city == "kolkata")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Kolkata 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Kolkata 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in kolkata, dandiya dance in kolkata, dandiya in kolkata, garba events in kolkata, navratri garba in kolkata, raas in kolkata, garba raas in kolkata, ras garba in kolkata, dandiya events in kolkata 2021, upcoming dandiya events in kolkata,dandiya tickets 2021";
		}
		else if($city == "jaipur")
		{
			$data['pageTitle'] = 'Dandiya dance & Navratri Garba Dance Events in Jaipur 2021 Tickets';
		$data['pageDescription']="Book online dandiya & garba dance events in Jaipur 2021 tickets and enjoy this Navratri nonstop dandiya dance, songs with your family and friends. Book tickets Now.";
        $data['pageKeywords'] = "dandiya events in jaipur, dandiya dance in jaipur, dandiya in jaipur, garba events in jaipur, navratri garba in jaipur, raas in jaipur, garba raas in jaipur, ras garba in jaipur, dandiya events in jaipur 2021, upcoming dandiya events in Jaipur, dandiya tickets 2021";
		}
			
			$uri_city = "dandiya";
                        if(!empty($city)){
                            $uri_city = "dandiya/".$city;
                        }
		
			
		}




		if($micrositename == 'valentinesday')
		{  
			$inputArray['subcategoryId'] = array(1652);
			$bannerInputArray['type'] = 4; // 3-newyear, 4-Holi
			
			if(empty($city) || ($city == "india")){
		$data['pageTitle'] = 'Valentines Day Events in India 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in India and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in India, valentines day places, valentines day programs, valentines day celebrations India, valentines day tickets, valentines day online tickets, valentines day parties India, 14 feb party";
		}else if($city == "hyderabad")
		{
			$data['pageTitle'] = 'Valentines Day Events in Hyderabad 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in Hyderabad and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Hyderabad, valentines day places, valentines day programs, valentines day celebrations Hyderabad, valentines day tickets, valentines day online tickets, valentines day parties Hyderabad, 14 feb party";
			
		}else if($city == "bengaluru")
		{
			$data['pageTitle'] = 'Valentines Day Events in Bengaluru 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in Bengaluru and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Bengaluru, valentines day places, valentines day programs, valentines day celebrations Bengaluru, valentines day tickets, valentines day online tickets, valentines day parties Bengaluru, 14 feb party";
		}else if($city == "mumbai")
		{
			$data['pageTitle'] = 'Valentines Day Events in Mumbai 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in Mumbai and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Mumbai, valentines day places, valentines day programs, valentines day celebrations Mumbai, valentines day tickets, valentines day online tickets, valentines day parties Mumbai, 14 feb party";
		}else if($city == "pune")
		{
			$data['pageTitle'] = 'Valentines Day Events in Pune 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in Pune and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Pune, valentines day places, valentines day programs, valentines day celebrations Pune, valentines day tickets, valentines day online tickets, valentines day parties Pune, 14 feb party	";
		}else if($city == "chennai")
		{
			$data['pageTitle'] = 'Valentines Day Events in Chennai 2021 Tickets	';
		$data['pageDescription']="Find the best valentines day events in Chennai and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Chennai, valentines day places, valentines day programs, valentines day celebrations Chennai, valentines day tickets, valentines day online tickets, valentines day parties Chennai, 14 feb party	";
		}else if($city == "goa")
		{
			$data['pageTitle'] = 'Valentines Day Events in Goa 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in Goa and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Goa, valentines day places, valentines day programs, valentines day celebrations Goa, valentines day tickets, valentines day online tickets, valentines day parties Goa, 14 feb party	";
		}else if($city == "delhi")
		{
			$data['pageTitle'] = 'Valentines Day Events in Delhi 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in Delhi and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Delhi, valentines day places, valentines day programs, valentines day celebrations Delhi, valentines day tickets, valentines day online tickets, valentines day parties Delhi, 14 feb party	";
		}
		else if($city == "ahmedabad")
		{
			$data['pageTitle'] = 'Valentines Day Events in Ahmedabad 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in Ahmedabad and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Ahmedabad, valentines day places, valentines day programs, valentines day celebrations Ahmedabad, valentines day tickets, valentines day online tickets, valentines day parties Ahmedabad, 14 feb party	";
		}
		else if($city == "kolkata")
		{
			$data['pageTitle'] = 'Valentines Day Events in Kolkata 2021 Tickets	';
		$data['pageDescription']="Find the best valentines day events in Kolkata and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance	";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Kolkata, valentines day places, valentines day programs, valentines day celebrations Kolkata, valentines day tickets, valentines day online tickets, valentines day parties Kolkata, 14 feb party	";
		}
		else if($city == "jaipur")
		{
			$data['pageTitle'] = 'Valentines Day Events in Jaipur 2021 Tickets';
		$data['pageDescription']="Find the best valentines day events in Jaipur and book your tickets online for your favorite event to celebrate this awesome 14th February with romantic dinners, poolside dinner, private party, and dance";
        $data['pageKeywords'] = "valentines day events, valentines day party, valentines day parties, valentines day celebrations, valentines day events in Jaipur, valentines day places, valentines day programs, valentines day celebrations Jaipur, valentines day tickets, valentines day online tickets, valentines day parties Jaipur, 14 feb party	";
		}
			
			$uri_city = "valentinesday";
                        if(!empty($city)){
                            $uri_city = "valentinesday/".$city;
                        }
		
			
		}






		if($micrositename == 'pushkarmela')
		{  
				
		$data['pageTitle'] = 'Pushkar Mela Rajasthan 2016 |Pushkar tour Packages |Pushkar Mela India';
		$data['pageDescription']="Pushkar Mela Rajasthan 2016.";
        $data['pageKeywords'] = "Pushkar Mela Rajasthan 2016";
			
			$uri_city = "pushkarmela";
                        if(!empty($city)){
                            $uri_city = "pushkarmela/".$city;
                        }
		
			
		}
		
		
		//print_r($inputArray); exit;
		
		
		/*banners*/
        $bannerInputArray['limit'] = 10;
        if($inputArray['cityId'] > 0)
            $bannerInputArray['cityId'] = $data['cityId'] = $inputArray['cityId'];
			
		if(array_key_exists($city,$listedRegions))
			$bannerInputArray['cityId'] = $listedRegions[$city];
			
			
        if($inputArray['categoryId'] > 0){
            $bannerInputArray['categoryId'] = $inputArray['categoryId'];
		}
		
		

        $bannerList = $bannerHandler->getBannerList($bannerInputArray);
		//print_r($bannerList); exit;
        if ($bannerList['status'] == true && $bannerList['response']['total']>0) {
            $data['bannerList'] = $bannerList['response']['bannerList'];
        }
		
		
		/*discounts*/
		$discountInputArray['limit'] = 100;
		$discountInputArray['micrositename'] = $micrositename;
		$discountInputArray['status'] = 1;
		
		//$discountInputArray['cityId'] = 0;
		if($inputArray['cityId'] > 0)
            $discountInputArray['cityId'] = $inputArray['cityId'];
		if(array_key_exists($city,$listedRegions))
			$discountInputArray['cityId'] = $listedRegions[$city];
			
		
		$discountList = $specialDiscountHandler->getSpecialDiscounts($discountInputArray);
		//print_r($discountList); exit;
        if ($discountList['status'] == true && $discountList['response']['total']>0) {
			$dbDiscounts = array();
			$sno = 0;
			foreach($discountList['response']['discountList'] as $discounts)
			{
				$solrInputArray['selectFields'] = array("id", "url");
				$solrInputArray['id'] = $discounts['eventid'];
				$solrInputArray['limit'] = 1;
				$solrEventData = $solrHandler->getSitemapSolrEvents($solrInputArray);
				$solrEventData = json_decode($solrEventData,true);
				//print_r($solrEventData); exit;
				$currentEventURL = site_url()."event/".$solrEventData['response']['events'][0]['url'];
				
				$dbDiscounts[$sno]['discountlable'] = $discounts['title'];
				$dbDiscounts[$sno]['eventurl'] = $currentEventURL;
				$dbDiscounts[$sno]['promocode'] = $discounts['promocode'];
				$sno++;
			}
			
            $data['discountList'] = $dbDiscounts;
        }
		
		
		
		$eventListResponse = $eventHandler->getMEDynamicMicrositesEventList($inputArray);
		//print_r($inputArray); print_r($eventListResponse); exit;
		
        if ($eventListResponse['status'] == TRUE && $eventListResponse['response']['total']>0) {
            $data['eventsList'] = $eventListResponse["response"];
            /*To append acode to sub events starts here*/
            $getData = $this->input->get();
    		if(isset($getData['acode']) == TRUE && strlen($getData['acode']) > 0){
    			$eventListGet = $data['eventsList']['eventList'];
    			foreach($eventListGet as $key => $value){
    				$eventListGet[$key]['eventUrl'] = $value['eventUrl'].'?acode='.$getData['acode'];
    			}
    			$data['eventsList']['eventList'] = $eventListGet;
			}
            /*To append acode to sub events ends here*/
            $page = $eventListResponse["response"]["page"];
            $limit = $eventListResponse["response"]["limit"];        
        }
        
        $data['page']=$page;
        $data['limit']=$limit;
        $data['categoryId'] = $inputArray['categoryId'];
        $data['subcategoryId'] = $inputArray['subcategoryId'];
        unset($inputArray['categoryId']);
        unset($inputArray['type']);
        unset($inputArray['limit']);
		
        //changing stateId and cityId to others for Others page
        if(isset($inputArray['stateId']) == FALSE && isset($inputArray['cityId']) == FALSE  && $city == 'others'){
            $data['stateId'] = 'others';
            $data['cityId'] = 'others';
        }	
		
		
		
		
        $seoArray['url']=$uri_city;
		
        $seoKeys=$seoHandler->getSeoData($seoArray);   
		//print_r($seoArray); print_r($seoKeys); exit;    
        $data['seoStaus']=false;
        if(count($seoKeys['response']['seoData']) > 0){
            $sData=$seoKeys['response']['seoData'][0];
            $data['seoStaus']=true;
           	$data['pageTitle'] = !empty($data['pageTitle']) ? $data['pageTitle'] : $sData['seotitle'];
           	$data['pageDescription'] = !empty($data['pageDescription']) ? $data['pageDescription'] : $sData['seodescription'];
           	$data['pageKeywords'] = !empty($data['pageKeywords']) ? $data['pageKeywords'] : $sData['seokeywords'];
            $data['canonicalurl'] =$sData['canonicalurl'];
        }

        $data['microsite'] = $micrositename;
		
		//echo $micrositename; print_r($data); exit;
		
		$this->load->view('microsite/'.$micrositename, $data);
		
		
		//echo "after view fun"; exit;
	}

    public function vh1supersonic2015() {
		
		require_once (APPPATH . 'handlers/eventsignupticketdetail_handler.php');
		$eventsignupticketdetailHandler = new Eventsignup_Ticketdetail_handler();
		
		require_once(APPPATH . 'handlers/ticket_handler.php');
		$ticketHandler = new Ticket_handler();
		
		require_once(APPPATH . 'handlers/eventsignup_handler.php');
		$eventsignupHandler = new Eventsignup_handler();
		
		
		require_once(APPPATH . 'handlers/event_handler.php');
		$eventHandler = new Event_handler();
		
        //  $majorerror = 0;
        $data = $tokenDetails = $postVars = array();
        $data['tickets20arr'] = array("65894", "65895");
        $data['tickets100arr'] = array("65892", "65893");
        $data['ticketsmaparr'] = array("65894" => "65892", "65895" => "65893");
        $eventid = 79256;
        $data['esid'] = $this->input->get('esid');
        $data['code'] = $this->input->get('code');
        $postVars = $this->input->post();

        $inputArray['eventId'] = $eventid;
        $ticketdetails = $ticketHandler->getTickets($inputArray);
        $data['ticketdetails'] = $ticketdetails['response']['viralTicketData'];
        $inputs['eventsignupids'] = array($data['esid']);
        $inputs['ticketids'] = $data['tickets20arr'];
        $inputs['transactiontype'] = 'All';
        $eventSignupDetails = $eventsignupHandler->getSuccessfullTransactionsByEventId('', $data['esid']);
        if ($eventSignupDetails['status']) {
            $validTrancations = $eventsignupticketdetailHandler->getListByEventsignupIds($inputs);
            if ($validTrancations['status'] == TRUE && $validTrancations['response']['total'] > 0) {

                foreach ($validTrancations['response']['eventSignupTicketDetailList'] as $key => $value) {
                    $data['validTrancations'][$key] = $value;
                    $data['validTrancations'][$key]['ticketname'] = $ticketdetails['response']['viralTicketData'][$value['ticketid']]['name'];
                    $data['validTrancations'][$key]['signupdate'] = $eventSignupDetails['response']['eventsignupData'][0]['signupdate'];

                    // amount calculation
                    $calculationInput['eventId'] = $eventSignupDetails['response']['eventsignupData'][0]['eventid'];
                    foreach ($data['ticketdetails'] as $tdkey => $tdvalue) {
                        if ($tdvalue['id'] == $data['ticketsmaparr'][$data['validTrancations'][0]['ticketid']]) {
                            $ticketDetails[$tdvalue['id']] = $value['ticketquantity'];
                        } else {
                            $ticketDetails[$tdvalue['id']] = 0;
                        }
                    }
                    $calculationInput['ticketArray'] = $ticketDetails;
                    $calculationData = $eventHandler->getEventTicketCalculation($calculationInput);
                    $calculationData['response']['calculationDetails']['alreadypaidamount']['amount'] = $data['validTrancations'][0]['totalamount'];
                    $calculationData['response']['calculationDetails']['alreadypaidamount']['conveniencefee'] = $eventSignupDetails['response']['eventsignupData'][0]['totalamount'] - $data['validTrancations'][0]['totalamount'];
                    $calculationData['response']['calculationDetails']['totalPurchaseAmount'] = $calculationData['response']['calculationDetails']['totalPurchaseAmount'] - $eventSignupDetails['response']['eventsignupData'][0]['totalamount'];
                    $data['calculationDetails'] = $calculationData['response']['calculationDetails'];

                    $data['validTrancations'][$key]['remainingamount'] = $calculationData['response']['calculationDetails']['totalTicketAmount'] - $calculationData['response']['calculationDetails']['alreadypaidamount']['amount'];
                }
            } else {
                $data['errorstatus'] = TRUE;
                $data['completedStatus'] = TRUE;
                $data['errorMessage'] = 'You have completed your 100% transaction.';
                //  $majorerror = 1;
                $this->load->view('microsite/vh1supersonic2015', $data);
            }
        } else {
            $data['errorstatus'] = TRUE;
            $data['errorMessage'] = 'Invalid Url';
            //   $majorerror = 1;
            $this->load->view('microsite/vh1supersonic2015', $data);
        }
        $data['eventSignupDetails'] = $eventSignupDetails = $eventSignupDetails['response']['eventsignupData'];

        /* Code to get the event related gateways starts here */
        $eventGateways = array();
        $gateWayInput['eventId'] = $eventid;
        $gateWayInput['paymentGatewayId'] = $eventSignupDetails[0]['paymentgatewayid'];
        $gateWayData = $eventHandler->getEventPaymentGateways($gateWayInput);
        if ($gateWayData['status'] && count($gateWayData['response']['gatewayList']) > 0) {
            $eventGateways = $gateWayData['response']['gatewayList'];
        }
        foreach ($eventGateways as $key => $gateway) {
            $gatewayName = strtolower($gateway['gatewayName']);
            $data[$gatewayName . 'Gateway'] = 1;
            $data[$gatewayName . 'Key'] = $eventSignupDetails[0]['paymentgatewayid'];
        }
        $data['gateWayName'] = $gatewayName;
        $data['redirectUrl'] = site_url() . 'micrositePaymentResponse';
        /* Code to get the event related gateways ends here */

        $data['oldsignupid'] = $data['esid'];
        $data['makepayment'] = 0;
        if (isset($postVars['paynowForm']) && $postVars['paynowForm'] != '') {
            $paymentResult = $this->vh1supersonicPaynow($data);
            if ($paymentResult['status'] == TRUE) {
                $data['paymentdata'] = $paymentResult['response']['paymentdata'];
                $data['orderLogId'] = $paymentResult['response']['paymentdata']['orderId'];
                $data['primaryAddress'] = $paymentResult['response']['paymentdata']['primaryAddress'];
                $data['eventData']['title'] = $paymentResult['response']['paymentdata']['EventTitle'];
                $data['makepayment'] = 1;
            }
        }

        if ((!isset($data['code']) && $validTrancations['response']['total'] > 0) || isset($data['code'])) {
            $tokenDetails = $this->micrositeHandler->codeVerification($data['code']);

            if ($tokenDetails['status'] == TRUE) {
                if ($tokenDetails['response']['total'] == 0) {
                    
                } else {
                    $data['errorstatus'] = FALSE;
                    $data['errorMessage'] = '';
                }
            } else {
                $data['errorstatus'] = TRUE;
                $data['errorMessage'] = 'Sorry, It seems invalid request, Please try again.';
            }
        }
        $this->load->view('microsite/vh1supersonic2015', $data);
    }

    public function vh1supersonic2015Links() {
        $tickets = array("65894", "65895");
        $eventId = 79256;
        $result = $this->micrositeHandler->generateMailLinks($eventId, $tickets);
        print_r($result);
    }

    private function vh1supersonicPaynow($data) {
        $response = $this->micrositeHandler->paynow($data);
        return $response;
    }

    public function micrositePaymentResponse() {
        $orderid = $this->input->get('orderid');
        if (!isset($orderid) && $orderid == '') {
            echo "error";
            exit;
        }
        $response = $this->micrositeHandler->paymentResponse($orderid);
        if ($response['status']) {
            redirect(site_url('vh1supersonic2015?esid=' . $response['response']['eventsignup']));
        } else {
            $this->customsession->setData('isa_error', 'Your event has been published successfully');
            redirect(site_url('vh1supersonic2015?esid=' . $response['response']['eventsignup']));
        }
        return $response;
    }

}

?>