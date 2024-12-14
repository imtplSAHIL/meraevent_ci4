<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Venue controller (Grouping of events Page by venue)
 *
 * @package		CodeIgniter
 * @author		Shashank
 * @copyright           Copyright (c) 2015, Meraevents.
 * @Version		Version 1.0
 * @Since               Class available 29-11-17 
 * @Created             28-04-18
 * @Last Modified On    02-05-18
 * @Last Modified By    Shashank
 */
require_once(APPPATH . 'handlers/eventfbpagemapping_handler.php');

class Facebookapp extends CI_Controller {

    var $fbtabHandler;
    var $commonHandler;

    public function __construct() {
        parent::__construct();
        $this->fbtabHandler = new eventfbpagemapping_handler();
    }

    public function index() {
        $postData = $this->input->post();
        $pageStatus = TRUE;
        if(!isset($postData['signed_request'])){
            $pageStatus = FALSE;
        }

        $signedRequest = $postData['signed_request'];
        $formattedDataRes = $this->parse_signed_request($signedRequest);
        if($formattedDataRes['status'] == FALSE){
            $pageStatus = FALSE;
        }
        $formattedData = $formattedDataRes['response'];

        $pageId = $formattedData['page']['id'];

        $MinputArray['pageId'] = $pageId;
        $eventMappingDataRes = $this->fbtabHandler->getByPageId($MinputArray);
        if($eventMappingDataRes['status'] == FALSE){
            $pageStatus = FALSE;
        }

        $eventMappingData = $eventMappingDataRes['response'];
        $eventId = $eventMappingData['details'][0]['eventId'];

        if($pageStatus == TRUE){
          $ticketWidgetUrl = commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId .'&ucode=organizer');
          redirect($ticketWidgetUrl,'refresh');
        }else{
          $data['content'] = '404_view';
          $data['pageTitle'] = '404 Page Not Found: MeraEvents.com';
          $this->load->view('templates/user_template', $data);
        }

    }

    public function parse_signed_request($signed_request) {
          list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

          $secret = $this->config->item('fb_app_secret'); // Use your app secret here

          // decode the data
          $sig = $this->base64_url_decode($encoded_sig);
          $data = json_decode($this->base64_url_decode($payload), true);

          // confirm the signature
          $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
          if ($sig !== $expected_sig) {
            $output['status'] = FALSE;
            $output['response']['message'] = 'Bad Signed JSON signature!';
            return $output;
          }

          $output['status'] = TRUE;
          $output['response'] = $data;
          return $output;
    }

    public function base64_url_decode($input) {
      return base64_decode(strtr($input, '-_', '+/'));
    }



}

?>