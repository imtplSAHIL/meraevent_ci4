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
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/printpass_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');

class Printpass extends CI_Controller {
    //var $ci;
    var $eventHandler;
    var $commonHandler;
    var $printpassHandler;
    var $userHandler;
    public function __construct() {
        parent::__construct();
        $this->eventHandler = new Event_handler();
        $this->commonHandler = new Common_handler();
        $this->printpassHandler = new Printpass_handler();
        $this->userHandler = new User_handler();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;

    }

    public function index() {
        $userId = $this->customsession->getData('userId');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $inputEmail = $this->input->post('useremail');
            $eventsignupId = $this->input->post('regno');
            $userEmail=$inputEmail;
        }
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $param = $this->uri->segment(2);
            if (is_numeric($param)) {
                $eventsignupId = $param;
            } else if(!empty($param)){
                $param = $this->uri->segment(2);
                $dirty = array("+", "/", "=");
                $clean = array("_PLUS_", "_SLASH_", "_EQUALS_");
                $string = str_replace($clean, $dirty, $param);
                $text = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5("meraeventsencrypt"), base64_decode($string), MCRYPT_MODE_CBC, md5(md5("meraeventsencrypt"))), "\0");
                $idemail = explode("-", $text);
                $eventsignupId = $idemail[0];
                $userEmail = $idemail[1];
            }
        }
        $cookieData = $this->commonHandler->headerValues();
        $eventsignup['eventsignupId'] = isset($eventsignupId) ? $eventsignupId : '';
        $eventsignup['userEmail'] = isset($userEmail) ? $userEmail : $this->customsession->getData('userEmail');
        if ($eventsignupId != '') {
            $eventsignpudata = $this->printpassHandler->getUserEventsignup($eventsignup);
            if ($eventsignpudata['status'] && count($eventsignpudata['response']['eventSignupDetailData']) > 0) {
                $event['eventId'] = $eventsignpudata['response']['eventSignupDetailData']['eventsignupDetails']['eventid'];
                $eventSetttingsInfoResponse = $this->eventHandler->getEventSettings($event);
                $stagedevent = 0;
                if ($eventSetttingsInfoResponse['status']) {
                    if ($eventSetttingsInfoResponse['response']['total'] > 0) {

                        if($eventSetttingsInfoResponse['response']['eventSettings'][0]['stagedevent'] == 1){
                            $stagedevent = 1;
                            $paymentstage = $eventSetttingsInfoResponse['response']['eventSettings'][0]['paymentstage'];
                        }
                    }
                }
                $eventsignup['stagedevent'] = $stagedevent;
                $eventsignpudata = $this->printpassHandler->getUserEventsignup($eventsignup);
                if($stagedevent == 1){
                    if($eventsignpudata['response']['eventSignupDetailData']['eventsignupDetails']['stagedstatus'] == 1){
                        $data['message'] = TYPE_STAGED_ORGANIZER_NOT_APPROVED_ERROR;
                    }else if($eventsignpudata['response']['eventSignupDetailData']['eventsignupDetails']['stagedstatus'] == 3){
                        $data['message'] = TYPE_STAGED_ORGANIZER_REJECTED_THIS_REGISTRATION;
                    }else if($paymentstage == 2 && $eventsignpudata['response']['eventSignupDetailData']['eventsignupDetails']['stagedstatus'] == 2 && $eventsignpudata['response']['eventSignupDetailData']['eventsignupDetails']['transactionstatus'] != 'success' && !in_array($eventsignpudata['response']['eventSignupDetailData']['eventsignupDetails']['paymentstatus'],array('Refunded', 'Canceled'))){
                        $data['message'] = TYPE_STAGED_APPROVED_BUT_PAYMENT_NOT_DONE;
                    }else {
                        $data = $eventsignpudata['response']['eventSignupDetailData'];
                    }
                }else{
                    $data = $eventsignpudata['response']['eventSignupDetailData'];
                }
            } else {
                $data['message'] = ERROR_INVALID_DATA;
            }
        }
        $view = 'printpass_view';
        $data['pageName'] = 'Print Pass';
        $data['pageTitle'] = 'Print your ticket';
        if(isset($data['message'])){
            $view = 'error_view';
        }
        $data['content'] = $view;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'fixto'  ,
            $this->config->item('js_public_path') . 'jquery.validate'  ,
            $this->config->item('js_public_path') . 'event'  ,
            $this->config->item('js_public_path'). 'printpass'
        );
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'print_tickets'  ,
            $this->config->item('css_public_path') . 'onscroll-specific');

        if (count($cookieData) > 0) {
            $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
            $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }
         $this->load->library('qrcode');
        $footerValues = $this->commonHandler->footerValues();
        $data['categoryList'] = $footerValues['categoryList'];
        $data['cityList'] = $footerValues['cityList'];
        $data['defaultCountryId'] = $this->defaultCountryId;
        $data['defaultCityId'] = $this->defaultCityId;
        $this->load->view('templates/user_template', $data);
    }
}
?>