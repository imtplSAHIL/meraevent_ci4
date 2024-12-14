<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php'); 

require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/solr_handler.php');
require_once(APPPATH . 'handlers/search_handler.php');

class Search extends REST_Controller 
{
	public function __construct() 
	{
        parent::__construct();
		$this->commonHandler = new Common_handler();
		$this->searchHandler = new Search_handler();
    }

	/*
     * Function to search the events
     *
     * @access	public
     * @param
     *      	`keyWord` - Mandatory
     *      	`countryId` - optional
     *      	`stateId` - optional
     *      	`cityId` - optional
     *      	`categoryId` - optional
     *      	`subcategoryId` - optional
     *			`day` - optional
     *					- `1` (today)
     *					- `2` (tomorrow)
     *					- `3` (this week)
     *					- `4` (this weekend)
     *					- `5` (this month)
     *					- `6` (all time)
     *					- `7` (custom date)
     *			`dateValue` - optional for custom date
     *      	`start` - optional
     *      	`limit` - optional (By default it takes 12)
     * @return	json formatted event result array based on search criteria
     */
	public function searchEvent_get() {
        $inputArray = $this->input->get();
		
        $eventResult = $this->searchHandler->searchEvents($inputArray);
        $resultArray = array('response' => $eventResult['response']);
		$statusCode = 200;
		if($eventResult['statusCode'] != '') {
			$statusCode = $eventResult['statusCode'];
		}
		$this->response($resultArray, $statusCode);
    }
	
	/*
     * Function to search the events for the autocomplete
     *
     * @access	public
     * @param
     *      	`keyWord` - Mandatory
     * @return	json formatted event result array based on search criteria
     */
    public function searchEventAutocomplete_get() {
        $keyWord = $this->input->get('term');
        $inputArray['keyWord'] = $keyWord;
		if($this->input->get('countryId') && !is_numeric($keyWord)){
			$inputArray['countryId'] = $this->input->get('countryId');
		}
		if($this->input->get('categoryId') && !is_numeric($keyWord)){
			$inputArray['categoryId'] = $this->input->get('categoryId');
		}
        $this->solrHandler = new Solr_handler();
		
		$inputArray['isAutoComplete'] = true;
        $solrResult = $this->solrHandler->getSolrEventsBySearch($inputArray);
        $eventResult = json_decode($solrResult, true);
		//print_r($eventResult); exit;
        $resultArr = array();
		
		$microsite = $this->input->get('microsite');
		
		$autoCompleteLabel = strlen($microsite)?'label':'value';

        if (isset($eventResult['response']['total']) && $eventResult['response']['total'] > 0) {
			
			/*getting featured countries list*/
			$dbCountryList = array();
			$countryInputArr['major'] = 1;
			require_once(APPPATH . 'handlers/country_handler.php');
			$countryHandler = new Country_handler();
			$countryList = $countryHandler->getCountryList($countryInputArr);
			//print_r($countryList);exit;
			
			if(isset($countryList['status']) && $countryList['status'] && $countryList['response']['total'] > 0){
				$dbCountryList = commonHelperGetIdArray($countryList['response']['countryList']);
				//foreach($dbCountryList as $ckey => $cval){
			}
			//print_r($dbCountryList); exit;
			
            $eventList = $eventResult['response']['events'];
            $i = 0;
            foreach ($eventList as $event) {
                $resultArr[$i][$autoCompleteLabel] = $event['title'];
                $resultArr[$i]['url'] = $event['url'];
				if(array_key_exists($event['countryId'],$dbCountryList)){
					$resultArr[$i]['url'] = $dbCountryList[$event['countryId']]['domain']."/event/".$event['url'];
				}else{
					$resultArr[$i]['url'] = $dbCountryList[$event['countryId']]['domain']."/event/".$event['url'];
				}
                $i++;
            }
        }
        $statusCode = 200;
        if($resultArr['statusCode'] != '') {
                $statusCode = $resultArr['statusCode'];
        }
        $this->response($resultArr, $statusCode);
         
    }
	
	
	/*
     * Function to search the events for the autocomplete (newyear/holi/dandiya)
     *
     * @access	public
     * @param
     * `keyWord` - Mandatory
     * @return	json formatted event result array based on search criteria
     */
    public function searchDynamicMicrositesEventAutocomplete_get() {
        $keyWord = $this->input->get('term');
		$microsite = $this->input->get('microsite');
		
		if($microsite == 'holi'){
			//$inputArray['categoryId'] = 13;
			//$inputArray['subcategoryId'] = 164;
			$inputArray['catorsubcat'] = array('categoryId'=>13,'subcategoryId'=>164);
		}
		elseif($microsite == 'dandiya'){
			$inputArray['categoryId'] = 1;
			$inputArray['subcategoryId'] = 8;
		}
		elseif($microsite == 'newyear'){
			$inputArray['categoryId'] = 8;
			
		}
		
		
		
        $inputArray['keyWord'] = $keyWord;
		
		
        $this->solrHandler = new Solr_handler();
        $solrResult = $this->solrHandler->getSolrEventsBySearch($inputArray);
        $eventResult = json_decode($solrResult, true);
        $resultArr = array();

        if (isset($eventResult['response']['total']) && $eventResult['response']['total'] > 0) {
            $eventList = $eventResult['response']['events'];
            $i = 0;
            foreach ($eventList as $event) {
                $resultArr[$i]['label'] = $event['title'];
                $resultArr[$i]['url'] = $event['url'];
                $i++;
            }
        }
		
		
		return $this->response($resultArr);
		
        $statusCode = 200;
        if($resultArr['statusCode'] != '') {
                $statusCode = $resultArr['statusCode'];
        }
        $this->response($resultArr, $statusCode);
         
    }

}
