<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Event signup Confirmation  page controller
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, MeraEvents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0
 * @Created     11-06-2015
 * @Last Modified On  03-08-2015
 * @Last Modified By  Raviteja
 */
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/confirmation_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once (APPPATH . 'handlers/orderlog_handler.php');
require_once (APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/reports_handler.php');

class Confirmation extends CI_Controller {

    var $commonHandler;
    var $confirmationHandler;
    var $eventsignupHandler;
    var $eventHandler;
    public function __construct() {
        parent::__construct();
        $this->commonHandler = new Common_handler();
        $this->confirmationHandler = new Confirmation_handler();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;
        $this->eventsignupHandler = new Eventsignup_handler();
        $this->eventHandler = new Event_handler();
        $this->reportsHandler = new Reports_handler();
    }

    public function index() {
       
        //=== Below code is to handle the offline payments. Specially developed for GPTW client. ====//
        $offlinepayment = $this->input->get('offlinepayment');
        if($offlinepayment == 'true')
        {
            $inputArray['eventsignupId'] = $this->input->get('eventSignupId');
            $inputArray['userEmail'] = $this->input->get('userEmail');
            $inputArray['userId'] = $this->input->get('userId');
            $inputArray['orderid'] = $this->input->get('orderid');
            // $inputArray['eventsignupId'] = '1721022';
            // $inputArray['orderid'] = '20210523Gx42RnnBkd052549';
            // $inputArray['userId'] = '629696';
            // $inputArray['userEmail'] = 'venkata.ummadi@etg.digital';
            $inputArray['content'] = 'confirmation_view';
            $sendEmail = $this->confirmationHandler->emailAutoProformaInvoice($inputArray);
            $inputArray['purchaserDetails'] = $this->eventsignupHandler->getEventSignupDetailsByID($this->input->get('eventSignupId'));
            $this->load->view('offline_payment_confirmation', $inputArray);
            return;
        }
        
        $userId = $this->customsession->getData('userId');
        $cookieData = $this->commonHandler->headerValues();
        $footerValues = $this->commonHandler->footerValues();
        $orderid = $this->input->get('orderid');
        $samepage = $this->input->get('samepage');
        $nobrand = $this->input->get('nobrand');
        $getVar = $this->input->get();
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Start Index function Line 41 orderId: $orderid userId:: $userId ::".date('Y/m/d H:i:s'));
        $widgetTheme = isset($getVar['theme']) ? $getVar['theme'] : 0;

        $orderLogInput['orderId'] = $orderid;
        $this->orderlogHandler = new Orderlog_handler();
        $orderLogData = $this->orderlogHandler->getOrderlog($orderLogInput);
        $oldOrderLogData = $orderLogData['response']['orderLogData'];
        if(empty($userId))
        {
            $userId = $oldOrderLogData['userid'];
        }

        if (!isset($orderid) && $orderid == '' || $userId == '') {
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index NoAccess Line 53 orderId: $orderid ::".date('Y/m/d H:i:s'));
            redirect(commonHelperGetPageUrl("home", 'NoAccess'), 'refresh');
            exit;
        }

        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php below is the session data ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($_SESSION, TRUE));
        
        $orderLogCalculationData = unserialize($orderLogData['response']['orderLogData']['data']);
        $eventsignupArray['eventsignupId'] = $oldOrderLogData['eventsignup'];
        $eventsignupArray['userId'] = $userId;
        $eventsignupArray['orderId'] = $orderid;
        $eventsignupArray['orderlogData'] = $orderLogCalculationData;
        $eventsignupArray['isExtraIdsArray'] = true;
        $eventSignupdata = $this->eventsignupHandler->getEventsignupDetailData($eventsignupArray);
        
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Line 97 below is orderLogCalculationData ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($orderLogCalculationData, TRUE));
        $this->commonHandler->log_message(print_r($eventSignupdata, TRUE));
        
        //=== Send attendee details to client API starts here ===//
        $eid = $eventSignupdata['response']['eventSignupDetailData']['eventsignupDetails']['eventid'];
        
        if($eid == 243751 || $eid == 238652 || $eid == 236017 || $eid == 238583 || $eid == 238915 || $eid == 238928 || $eid == 238934 || $eid == 239068 || $eid == 239069 || $eid == 239070 || $eid == 239071 || $eid == 239072 || $eid == 239073 || $eid == 239074 || $eid == 239075 || $eid == 239076 || $eid == 239077 || $eid == 239078 || $eid == 239079 || $eid == 239080 || $eid == 239081 || $eid == 239082 || $eid == 239083 || $eid == 239084 || $eid == 239085 || $eid == 239086 || $eid == 239089 || $eid == 239090 || $eid == 239091 || $eid == 239092 || $eid == 239093 || $eid == 239094 || $eid == 239095|| $eid == 239402 || $eid == 239403 || $eid == 239404 || $eid == 239405 || $eid == 239406 || $eid == 240054 || $eid == 240192 || $eid == 240203 || $eid == 240275 || $eid == 240252 || $eid == 248162  || $eid == 240043 || $eid == 240450 || $eid == 240514 || $eid == 244237 || $eid == 244470){
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index  Line 72 API call: $orderid ::".date('Y/m/d H:i:s'));
        $esid = $eventsignupArray['eventsignupId'];
        $getFieldsData = $this->eventsignupHandler->getUserDataForApi($eid,$esid);
        //echo '<pre>hello';print_r($getFieldsData);exit;
        $api_tickets_data = array();
        $counter = 0;
        foreach($orderLogCalculationData['calculationDetails']['ticketsData'] as $current_ticket)
        {
            $api_tickets_data[$counter]['ticketId'] = $current_ticket['ticketId'];
            $api_tickets_data[$counter]['ticketName'] = $current_ticket['ticketName'];
            $api_tickets_data[$counter]['ticketType'] = $current_ticket['ticketType'];
            $api_tickets_data[$counter]['ticketPrice'] = $current_ticket['ticketPrice'];
            $api_tickets_data[$counter]['selectedQuantity'] = $current_ticket['selectedQuantity'];
            $api_tickets_data[$counter]['totalAmount'] = $current_ticket['totalAmount'];
            $api_tickets_data[$counter]['currencyCode'] = $current_ticket['currencyCode'];
            $counter++;
        }

        $final_array = array();
        $final_array['apikey'] = 'njxY55Eis$2%t%i74s2%2qW^r'; //@redo take from db
        $final_array['attendees'] = array();
        $client_api_url = 'https://us-central1-iicindiaimpactinvestingweek.cloudfunctions.net/meraeventsapi'; //@redo take from db
        if($eid == 238652 || $eid == 236017 || $eid == 238583 || $eid == 238915 || $eid == 238928 || $eid == 238934 || $eid == 239068 || $eid == 239069 || $eid == 239070 || $eid == 239071 || $eid == 239072 || $eid == 239073 || $eid == 239074 || $eid == 239075 || $eid == 239076 || $eid == 239077 || $eid == 239078 || $eid == 239079 || $eid == 239080 || $eid == 239081 || $eid == 239082 || $eid == 239083 || $eid == 239084 || $eid == 239085 || $eid == 239086 || $eid == 239089 || $eid == 239090 || $eid == 239091 || $eid == 239092 || $eid == 239093 || $eid == 239094 || $eid == 239095|| $eid == 239402 || $eid == 239403 || $eid == 239404 || $eid == 239405 || $eid == 239406)
        {
            $client_api_url = 'https://api.shaastra.org/payments';
        }
        if($eid == 240054 || $eid == 240192|| $eid == 240203 || $eid == 240275 || $eid == 240450 || $eid == 240514)
        {
            $client_api_url = 'https://kurukshetra.ml/user/pay';
        }
        if($eid == 240252 || $eid == 248162)
        {
            $client_api_url = 'https://api.technex.co.in/payment-details/add/';
        }
        if($eid == 240043)
        {
            $client_api_url = 'https://api.ecellbphc.in/payments/callback';
        }
        if($eid == 244237)
        {
            $client_api_url = 'https://indianextstar.com/api/payment/add.php';
        }
        if($eid == 244470)
        {
            $client_api_url = 'https://stylishkidofindia.com/api/payment/add.php';
        }
      /*
        if($eid == 247106)
        {
            $client_api_url = 'https://www.meraevents.com/developers/token.php';
        }
      */
        $final_array['attendees'] = array_filter(array_merge(array(), $getFieldsData['attendeedetailList']));
        $final_array['ticketItems'] = $api_tickets_data;
        $final_array['eventName'] = $eventSignupdata['response']['eventSignupDetailData']['eventData']['title'];
        $final_array['eventid'] = $eid;
        $final_array['regNumber'] = $eventsignupArray['eventsignupId'];
       // echo'<pre>';
        $data['api_data']=$final_array;
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index  Line number 114 :: $client_api_url ".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($final_array, TRUE));
        $input_json = json_encode($final_array, true); 
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index  Line number 118 Below is JSON DATA ".date('Y/m/d H:i:s'));
        echo $this->commonHandler->log_message(print_r($input_json, TRUE));
        $sendAttendeeData = $this->commonHandler->callAPI('POST', $client_api_url, $input_json);
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index response from attendee API: $orderid ::".date('Y/m/d H:i:s'));
        $this->commonHandler->log_message(print_r($sendAttendeeData, TRUE));
        }
        else{
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index  Line number 125 No API CALLED FOR THIS EVENT ".date('Y/m/d H:i:s'));
        }
        //=== Send attendee details to client API ends here ===//

        if(isset($eventSignupdata['response']['eventSignupDetailData'])){
            $data = $eventSignupdata['response']['eventSignupDetailData'];
        }else{
            $data = $eventSignupdata;
        }
        
        if($data['eventsignupDetails']['courierfee'] > 0){
             require_once (APPPATH . 'handlers/courierfee_handler.php');
             $courierFeeHandler = new Courierfee_handler();
             $courierFeeRes = $courierFeeHandler->getCourierFeeLabelaByEventId(array('eventId' => $data['eventsignupDetails']['eventid']));
             if($courierFeeRes['status'] == TRUE){
                $data['eventsignupDetails']['courierfeelabel'] = $courierFeeRes['response']['courierFee'][0]['label'];
             }
        }
        $GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY;
        if(!empty($GPTW_EVENTS_ARRAY[$eid]))
        {
            $data['purchaserDetails'] = $this->reportsHandler->getEventSignupDetail($eventsignupArray['eventsignupId']);
        }
        
        /* Check if event is a Multi Event */
        $CMEInput['eventId'] = $data['eventData']['id'];
        $checkResponse = $this->eventHandler->checkIsMultiEvent($CMEInput);
        if($checkResponse['status'] == TRUE){
            $data['multiEvent'] = TRUE;
            $data['multiEventParentId'] = $checkResponse['parentId'];
        }       
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 146 ::".date('Y/m/d H:i:s'));
		$data['widgetRedirectUrl'] = '';
		$usedReferalCode = '';
		if($orderLogCalculationData['referralcode'] != '') {
			$usedReferalCode = $orderLogCalculationData['referralcode'];
		}
        $data['usedReferalCode'] = $usedReferalCode;
        $data['previewPagebooking']=0;
        if(isset($orderLogCalculationData['pageType']) && $orderLogCalculationData['pageType'] == 'preview' ){
            $data['previewPagebooking'] =1;
        }
        // If it is 20-80 event,with considering old signup id, redirecting to its calculation page
        if(isset($orderLogCalculationData['oldsignupid']) && $orderLogCalculationData['widgetredirecturl'] != '' && $orderLogCalculationData['oldsignupid'] > 0) {
            $redirectUrl = $orderLogCalculationData['widgetredirecturl'];
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index Line 103 redirecting here redirectUrl :: $redirectUrl orderId: $orderid ::".date('Y/m/d H:i:s'));
            header("Location: ".$redirectUrl);
            exit;
        } elseif($orderLogCalculationData['widgetredirecturl'] != '' && $orderLogCalculationData['oldsignupid'] == '') {
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 108 ::".date('Y/m/d H:i:s'));
		
            $data['widgetRedirectUrl'] = urldecode($orderLogCalculationData['widgetredirecturl']).'?orderId='.$orderid;
        }
        //setting for ticketwidget third party redirection
        $redirectionUrl = '';
        if(isset($orderLogCalculationData['paymentResponse']) && $orderLogCalculationData['redirecturl'] != '' && $orderLogCalculationData['paymentResponse']['MerchantRefNo'] > 0 ){
            $redirectionUrl = $orderLogCalculationData['redirecturl'] . ((strpos($orderLogCalculationData['redirecturl'], "?") !== false) ? "&orderId=" : "?orderId=") . $data['eventsignupDetails']['id'] . '&userId=' . $data['eventsignupDetails']['userid'];
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 116 redirectionUrl:: $redirectionUrl ::".date('Y/m/d H:i:s'));
	
            if (isset($orderLogCalculationData['Event_Type'])) {
                $redirectionUrl .= '&Event_Type=' . $orderLogCalculationData['Event_Type'];
                $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index function 113 redirecting here redirectionUrl :: $redirectionUrl orderId: $orderid ::".date('Y/m/d H:i:s'));
            }
        }
        $data['orderlogData'] = $orderLogCalculationData;
        $data['moduleName'] = 'eventModule';
        $data['pageName'] = 'Payment Confirmation';
        $data['pageTitle'] = $data['eventData']['title'].' | '. 'Payment Confirmation';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'fixto'  ,
            $this->config->item('js_public_path') . 'inviteFriends'  ,
            $this->config->item('js_public_path') . 'jquery.validate' ,
            $this->config->item('js_public_path') . 'event');
        //,$this->config->item('js_public_path') . 'deeplink');
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'print_tickets'  ,
            $this->config->item('css_public_path') . 'onscroll-specific');
        $smsData['eventtitle'] = $data['eventData']['title'];
        $data['orderid'] = $orderid;
        $smsData['mobile'] = $data['userDetail']['mobile'];
        $data['countryList'] = '';
        $data['categoryList'] = '';

        if (count($cookieData) > 0) {
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 142 ::".date('Y/m/d H:i:s'));
            $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
            $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }

        if(is_array($orderLogCalculationData['paymentResponse']) && count($orderLogCalculationData['paymentResponse']) > 0 && $orderLogCalculationData['paymentResponse']['MerchantRefNo'] > 0) {

        }
        else
        {
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 262 ERROR INVALID DATA ::".date('Y/m/d H:i:s'));
            $data['response']['messages'] = array(ERROR_INVALID_DATA);
        }

        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 151 ::".date('Y/m/d H:i:s'));
        $data['content'] = 'confirmation_view';

        if (isset($data['response']['messages']) && count($data['response']['messages'])>0)
        {
            $data['content'] = 'error_view';
            $data['message'] = "Something Went wrong. Please Try Again";
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 156 SOMETHING WENT WRONG FAILED ::".date('Y/m/d H:i:s'));
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Below is complete data array -> ::".date('Y/m/d H:i:s'));
            $this->commonHandler->log_message(print_r($data, TRUE));
        }
        elseif(in_array($data['eventsignupDetails']['eventid'],json_decode(TEDX_CUSTOM_EMAIL)))
        {
            $data['content'] = 'tedx_confirmation_view';
        }
        
        $eventSettingsInput['eventId'] = $data['eventsignupDetails']['eventid'];
        $eventSettingsDataArr = $this->eventHandler->getEventSettings($eventSettingsInput);
        if ($eventSettingsDataArr['status'] && $eventSettingsDataArr['response']['total'] > 0 ) {
            if($eventSettingsDataArr['response']["eventSettings"][0]['stagedevent'] == 1 && $eventSignupdata['response']['eventSignupDetailData']['eventsignupDetails']['stagedstatus'] != 2 ){
                $data['content'] = 'stagedevent_confirmation_view';
            }
        }
        $data['categoryList'] = $footerValues['categoryList'];
        $data['cityList'] = $footerValues['cityList'];
        $categoryArr = commonHelperGetIdArray($footerValues['categoryList']);
        $data['eventData']['categoryName'] = $categoryArr[$data['eventData']['categoryId']];
        $data['defaultCountryId'] = $this->defaultCountryId;
        $data['samepage'] = $samepage;
        $data['nobrand'] = $nobrand;
        $data['widgetTheme']=$widgetTheme;
        $data['redirectionUrl']=$redirectionUrl;
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 177 ::".date('Y/m/d H:i:s'));
        if($widgetTheme>0){
            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 179 ::".date('Y/m/d H:i:s'));
            $showTitle = isset($getVar['title']) ? $getVar['title'] : 1;
            $showLocation = isset($getVar['location']) ? $getVar['location'] : 1;
            $showDateTime = isset($getVar['dateTime']) ? $getVar['dateTime'] : 1;
            $wcode = isset($getVar['wcode']) ? $getVar['wcode'] : '';
            $thirdPartyUrl = isset($getVar['parrent']) ? $getVar['parrent'] : '';
            $ticket_option = !empty($getVar['t']) ? $getVar['t'] : '1';
            $ticket_option_ids = !empty($getVar['tid']) ? $getVar['tid'] : '';
            $data['backpageWidgetUrl']="&samepage=1&theme=$widgetTheme&title=$showTitle&dateTime=$showDateTime&location=$showLocation&wcode=$wcode&nobrand=$nobrand&t=$ticket_option&tid=$ticket_option_ids";
            if(isset($thirdPartyUrl) && $thirdPartyUrl!=''){
                $data['widgetThirdPartyUrl']=$thirdPartyUrl;
            }

            $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php line num 192 $thirdPartyUrl  ::".date('Y/m/d H:i:s'));
        }
        $data['handlingFeeLable']=$this->config->item('internet_handling_lable');
        $this->commonHandler->log_message("\n ".$this->commonHandler->get_client_ip()." Confirmation.php Index function end Line 181 orderId: $orderid ::".date('Y/m/d H:i:s'));
       // $this->load->library('ciqrcode');
        $this->load->library('qrcode');
        if(isset($samepage) && $samepage == 1){
            $this->load->view('templates/ticket_widget_template', $data);
        }else{
            $this->load->view('templates/user_template', $data);
        }

    }


// Function to Print the Delegate Pass for Eventsignup

    public function delegatepass() {
       
        $eventsignupId =  $this->uri->segment(2);
        $userEmail =  urldecode($this->uri->segment(3));
        $footerValues = $this->commonHandler->footerValues();
        $cookieData = $this->commonHandler->headerValues();
        $eventsignupArray['eventsignupId'] = $eventsignupId;
        $eventsignupArray['userId'] = $this->customsession->getData('userId');
        if(isset($eventsignupId) && $eventsignupId != '' ){
            $inputArray['eventsignupId'] = $eventsignupId;
            $inputArray['userEmail'] = $userEmail;
            $checkEventsignup = $this->eventsignupHandler->checkEventsignup($inputArray);
            if($checkEventsignup['status'] && $checkEventsignup['response']['total']>0){
                $stagedevent = 0;
                if($checkEventsignup['response']['eventId'] != ''){
                    $event['eventId'] = $checkEventsignup['response']['eventId'];
                    $eventSetttingsInfoResponse = $this->eventHandler->getEventSettings($event);
                    if ($eventSetttingsInfoResponse['status']) {
                        if ($eventSetttingsInfoResponse['response']['total'] > 0) {
                            if($eventSetttingsInfoResponse['response']['eventSettings'][0]['stagedevent'] == 1){
                                $stagedevent = 1;
                                $paymentstage = $eventSetttingsInfoResponse['response']['eventSettings'][0]['paymentstage'];

                            }
                        }
                    }
                }
                $inputArray['stagedevent'] = $stagedevent;
                $checkEventsignup = $this->eventsignupHandler->checkEventsignup($inputArray);

                if($stagedevent == 1){

                    if($checkEventsignup['response']['stagedstatus'] == 1){
                        $data['message'] = TYPE_STAGED_ORGANIZER_NOT_APPROVED_ERROR;
                    }else if($checkEventsignup['response']['stagedstatus'] == 3){
                        $data['message'] = TYPE_STAGED_ORGANIZER_REJECTED_THIS_REGISTRATION;
                    }else if($paymentstage == 2 && $checkEventsignup['response']['stagedstatus'] == 2 && $checkEventsignup['response']['transactionstatus'] != 'success' && !in_array($checkEventsignup['response']['paymentstatus'],array('Refunded', 'Canceled'))){
                        $data['message'] = TYPE_STAGED_APPROVED_BUT_PAYMENT_NOT_DONE;
                    }else {
                        $eventsignupArray['eventsignupId'] = $inputArray['eventsignupId'];
                        $eventsignupArray['userId'] = $checkEventsignup['response']['userId'];
                        $this->confirmationHandler->printPass($eventsignupArray);
                    }
                }else{
                    $eventsignupArray['eventsignupId'] = $inputArray['eventsignupId'];
                    $eventsignupArray['userId'] = $checkEventsignup['response']['userId'];
                    $this->confirmationHandler->printPass($eventsignupArray);
                }


            }
            $data['moduleName'] = 'eventModule';
            $data['pageName'] = 'Print Pass';
            $data['pageTitle'] = 'Print Pass';
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'fixto'  ,
                $this->config->item('js_public_path') . 'inviteFriends'  ,
                $this->config->item('js_public_path') . 'jquery.validate'  ,
                $this->config->item('js_public_path') . 'event'  );
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'print_tickets'  ,
                $this->config->item('css_public_path') . 'onscroll-specific');
            $data['countryList']='';
            $data['categoryList']='';

            if (count($cookieData) > 0) {
                $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
                $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
            }
            if(isset($checkEventsignup['response']['messages']) && count($checkEventsignup['response']['messages'])>0){
                $data['content'] = 'error_view';
                if(!isset($data['message'])){
                    $data['message'] = ERROR_INVALID_DATA;
                }

            }
            $data['categoryList'] = $footerValues['categoryList'];
            $data['defaultCountryId'] = $this->defaultCountryId;
            
            $this->load->view('templates/user_template', $data);
        }

    }

    // Function to resend the Eventsignup DelegateEmail

    public function resendTransactionSuccessEmailToDelegate() {
        $eventsignupArray = $this->input->get();
        $eventsignupArray['userId'] = getUserId();
        $this->confirmationHandler->resendTransactionsuccessEmail($eventsignupArray);
    }
    // print multiple passes

    
    public function getMultipleOfflinePasses($uniqueId, $eventId) {

        $uniqueId=trim($this->input->get('uniqueId'));
        $eventId=trim($this->input->get('eventId'));
        if (strlen($uniqueId) == 0 || strlen($eventId) == 0) {
            echo 'Invalid Url';
        }
        $inputArray['eventId'] = $eventId;
        $inputArray['extrafield'] = $uniqueId;
        $signupIds = $this->eventsignupHandler->getEventSignupId($inputArray);
        $eventsignId = $signupIds['response']['eventsignupids']['0'];
      //  $this->load->library('phpwkhtmltopdf');
      //  $phpwkhtmltopdf = new Phpwkhtmltopdf();

        $i = 0;
        $esId=count($eventsignId);
        foreach ($eventsignId as $value) {
            $eventsignupArray['eventsignupId'] = $value['id'];
            $eventsignupDetails[] = $this->eventsignupHandler->getEventsignupDetailData($eventsignupArray);
            $data = $eventsignupDetails[$i]['response']['eventSignupDetailData'];
            $delegatepassTemplateData = $this->eventsignupHandler->getdelegatepassHtml($data);
            $data = utf8_encode($delegatepassTemplateData);

            if($esId != $i){
                //$phpwkhtmltopdf->pdf->addPage($data);
                echo $data;
                $i++;
            }
        }
        
        
        // Define the PrintPage function inside PHP
        echo '<script type="text/javascript">
        function PrintPage() {
            var bodyContent = document.body.innerHTML; // Get the entire body content
            var popupWin = window.open("", "_blank", "width=1300,height=600");
            popupWin.document.open();
            popupWin.document.write("<html><head><title>MeraEvents</title>");
            popupWin.document.write("<style>body { font-family: Arial, sans-serif; }</style></head>");
            popupWin.document.write("<body onload=\'window.print();\'>");
            popupWin.document.write(bodyContent); // Write the body content
            popupWin.document.write("</body></html>");
            popupWin.document.close();
        }
        </script><center><button onclick="PrintPage()">Print</button></center>';
        
    
       // $phpwkhtmltopdf->pdf->send();
    }
}

?>
