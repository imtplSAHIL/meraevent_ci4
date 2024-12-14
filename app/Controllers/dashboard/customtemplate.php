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
 * @Created     31-07-2018
 * @Last Modified On  31-07-2018
 * @Last Modified By  srinivas
 */
require_once(APPPATH . 'handlers/dashboard_handler.php');
require_once(APPPATH . 'handlers/messagetemplate_handler.php');
require_once(APPPATH . 'handlers/event_handler.php');

class Customtemplate extends CI_Controller {

    var $dashboardHandler;
    var $eventHandler;
    
    public function __construct() {
        parent::__construct();
        $this->dashboardHandler = new Dashboard_handler();
        $this->messagetemplate_handler = new Messagetemplate_handler();
        $this->event_handler = new Event_handler();
    }

    public function index($event_id) {
        $post = $this->input->post();
        $data['pageTitle'] = 'System Templates';
        $data['eventId'] = $event_id;
        $data['editEvent'] = true;  
        //$data['messageType'] = $this->session->flashdata('message');
        //$data['messageType'] = (isset($getVar['message'])) ? $getVar['message'] : '';
        $data['pageName'] = 'My Events';
        $data['pageTitle'] = 'MeraEvents | Organizer View | Current Events';
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'customtemplate_index';
        $inputArray['event_id'] = $event_id;
        $inputArray['type'] = 'online';
        $onlineCustomtemplate = $this->messagetemplate_handler->getEventTemplate($inputArray);
        $data['onlineCustomTemplate'] = $onlineCustomtemplate['response']['templateDetail'];
      
        $inputArray['type'] = 'offline';
        $offlineCustomtemplate  = $this->messagetemplate_handler->getEventTemplate($inputArray);
        $data['offlineCustomTemplate'] = $offlineCustomtemplate['response']['templateDetail'];
        
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/fs-match-height',
        $this->config->item('js_public_path') . 'dashboard/current_past_events');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function updateTemplate($event_id, $event_type, $templateId = null){
        
       
        $data['pageTitle'] = 'System Templates';
        $data['eventId'] = $event_id;
        $data['editEvent'] = true;  
        //$data['messageType'] = $this->session->flashdata('message');
        //$data['messageType'] = (isset($getVar['message'])) ? $getVar['message'] : '';
        $data['pageName'] = 'My Events';
        $data['pageTitle'] = 'MeraEvents | Organizer View | Current Events';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'customtemplate_update';
        $inputArray['eventId'] = $event_id; 
        $eventDetailsResponse = $this->event_handler->getEventDetails($inputArray);
        
        $data['temptype'] = $event_type; 
        $data['defaultsubject'] = SUBJECT_DELEGATEEVENT_REG . stripslashes($eventDetailsResponse['response']['details']['title']);
        if($templateId != ''){
            $data['temp_id'] = $templateId;
            $inputArray['id'] = $templateId;
            $eventTemplateDetails = $this->messagetemplate_handler->getEventTemplate($inputArray);
            $rRemoveTemplate = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns:v="urn:schemas-microsoft-com:vml">
   <head>
      <!-- Define Charset -->
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <!-- Responsive Meta Tag -->
      <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
      <link href="https://fonts.googleapis.com/css?family=Muli:400,300" rel="stylesheet" type="text/css">
      <title>Application Successfully Submitted</title>
      <!-- Responsive Styles and Valid Styles -->
      <style type="text/css">
    /* Take care of image borders and formatting, client hacks */
    img { outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
    a img { border: none; }
    table { border-collapse: collapse !important;}
    #outlook a { padding:0; }
    .ReadMsgBody { width: 100%; }
    .ExternalClass { width: 100%; }
    .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
    table td { border-collapse: collapse; }
    .ExternalClass * { line-height: 115%; }
    .container-for-gmail-android { min-width: 600px; }

    /* General styling */
    
    body { font-family: Segoe UI,Trebuchet MS,calibri,Lucida Sans Unicode,Lucida Grande,Trebuchet MS,Tahoma,Helvetica Neue,Arial,sans-serif !important;
      -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important;height: 100%; color: #676767;  background-color: #eaf0f2; margin:0; padding:0; mso-margin-top-alt:0px; mso-margin-bottom-alt:0px; mso-padding-alt: 0px 0px 0px 0px; }

    td {font-family: Segoe UI,Trebuchet MS,calibri,Lucida Sans Unicode,Lucida Grande,Trebuchet MS,Tahoma,Helvetica Neue,Arial,sans-serif !important; text-align: center; }
    a {color: #676767; text-decoration: none !important; }
    .pull-left {text-align: left; }
    .pull-right {text-align: right; }
    .header-lg, .header-md, .header-sm {font-size: 32px; font-weight: 700; line-height: normal; padding: 35px 0 0; color: #4d4d4d; }
    .header-md {font-size: 24px; }
    .header-sm {padding: 5px 0; font-size: 18px; line-height: 1.3; }
    .content-padding {padding: 10px 0 10px 0; }
    .mobile-header-padding-right {width: 290px; text-align: right; padding-left: 10px; }
    .mobile-header-padding-left {width: 290px; text-align: left; padding-left: 10px; }
    .free-text {width: 100% !important; padding: 10px 60px 0px; }
    .block-rounded {border-radius: 5px; border: 1px solid #e5e5e5; vertical-align: top; }
    .button {padding: 30px 0; }
    .info-block {padding: 0 20px; width: 260px; }
    .app-block {padding: 0 20px; }
    .block-rounded {width: 260px; }    
    .force-width-gmail {min-width:600px; height: 0px !important; line-height: 1px !important; font-size: 1px !important; }
    .button-width {width: 228px; }
    .aright {text-align: right;}
    .aleft {text-align: left;}
     .item-col {padding-top: 20px; text-align: left !important; vertical-align: top; }
     .item-total {padding-top: 10px; text-align: left !important; vertical-align: top; }
     .title-dark {text-align: left; border-bottom: 1px solid #cccccc; color: #4d4d4d; font-weight: 700; padding-bottom: 5px; }
    .item-table {width: 580px; margin: 0 auto;}
    .preview {display:none;}
  </style>

 
  <style type="text/css" media="only screen and (max-width: 480px)">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {
      td[class="email-content"] {display: block !important; width: 280px !important; text-align: center; }
      table[class*="container-for-gmail-android"] {min-width: 290px !important; width: 100% !important; }
      table[class="w320"] {width: 320px !important; }
      table[class="w320inline"] {width: 320px !important; display: inline !important; }
      td[class="inline"] {display: inline !important; }
      img[class="force-width-gmail"] {display: none !important; width: 0 !important; height: 0 !important; }
      td[class*="mobile-header-padding-left"] {width: 160px !important; padding-left: 0 !important; }
      td[class*="mobile-header-padding-right"] {width: 160px !important; padding-right: 0 !important; }
      td[class="header-lg"] {font-size: 24px !important; padding-bottom: 5px !important; }
      a[class="button-width"],
      a[class="button-mobile"] {width: 248px !important; }
      td[class="header-md"] {font-size: 18px !important; padding-bottom: 5px !important; }
      td[class="content-padding"] {padding: 5px 0 30px !important; }
      td[class="button"] {padding: 5px !important; }
      td[class*="free-text"] {padding: 10px 18px 30px !important; }
      td[class="info-block"] {display: block !important; width: 280px !important; padding-bottom: 40px !important; }
      td[class="app-block"] {display: block !important; width: 280px !important; padding-bottom: 10px !important; }
      td[class="aright"] {text-align: center;}
      td[class="aleft"] {text-align: center;}
      td[class="w100"] {width:100% !important;text-align: center; display: inline-block; padding-top: 5px; padding-bottom: 10px; height: auto !important;}
      td[class="item-table"] { padding: 20px 10px !important; }
      td[class="item-total"] {padding-top: 10px; text-align: left !important; vertical-align: top; }
      td[class="hide"] { display:none !important; }
    }
  </style>
   </head>
   <body yahoo="fix"  bgcolor="#eaf0f2" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">'," ",$eventTemplateDetails['response']['templateDetail']);
            
            $data['templateDetails'] = str_replace('</body></html>'," ",$rRemoveTemplate);
        }
        
        if ($this->input->post('submit')) {
            $inputArray['subject'] = $this->input->post('subject');
            $inputArray['template'] = $this->input->post('template_header').'<br>'.$this->input->post('template_footer');
            $inputArray['eventid'] = $this->input->post('eventid');
            $inputArray['type'] = $this->input->post('type');
            $inputArray['id'] = $this->input->post('template_name');
//            $inputArray['facebooklink'] = $this->input->post('facebooklink');
//            $inputArray['youtubelink'] = $this->input->post('youtubelink');
//            $inputArray['googlelink'] = $this->input->post('googlelink');
//            $inputArray['twitterlink'] = $this->input->post('twitterlink');
//            $inputArray['instragramlink'] = $this->input->post('instragramlink');
//            $inputArray['linkedinlink'] = $this->input->post('linkedinlink');
            $output = $this->messagetemplate_handler->insertTemplate($inputArray);
            if ($output['status']) {
                $this->customsession->setData('promoterSuccessAdded', SUCCESS_ADDED_PROMOTER);
                redirect(commonHelperGetPageUrl('dashboard-customtemplate', $event_id));
            } else {
                $data['output'] = $output['response']['messages'][0];
            }
        }
       $data['hideLeftMenu'] = 0;
        $data['jsArray'] = array(            
            //'https://tinymce.cachefly.net/4.2/tinymce.min',
           $this->config->item('js_public_path') . 'dndbuilder/tinymce2/tinymce',
            $this->config->item('js_public_path') . 'dndbuilder/bootstrap',
            $this->config->item('js_public_path') . 'dndbuilder/bootstrap-colorpicker',
            $this->config->item('js_public_path') . 'dndbuilder/bootstrap-colorselector',
            $this->config->item('js_public_path') . 'dndbuilder/jquery-ui',
            $this->config->item('js_public_path') . 'dndbuilder/ace',
            $this->config->item('js_public_path') . 'dndbuilder/app',
            $this->config->item('js_public_path') . 'dndbuilder/jquery.ui.touch-punch',
            );
       $data['cssArray'] = array(
           'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome',
           $this->config->item('css_public_path') . 'dndbuilder/bootstrap',
           $this->config->item('css_public_path') . 'dndbuilder/bootstrap-theme',
           $this->config->item('css_public_path') . 'dndbuilder/bootstrap-colorpicker',
           $this->config->item('css_public_path') . 'dndbuilder/bootstrap-colorselector',
           $this->config->item('css_public_path') . 'dndbuilder/default',
           $this->config->item('css_public_path') . 'dndbuilder/gridsys',
           $this->config->item('css_public_path') . 'dndbuilder/theme', 
           $this->config->item('css_public_path') . 'font-awesome');

        $this->load->view('templates/dashboard_template', $data);
    }
    
    function ajaxTemplateInsert(){
       
        $postvalue = $_POST;
        $inputArray['subject'] = $postvalue['emailsubject'];
        $inputArray['template'] = $postvalue['template_content'];
        $inputArray['eventid'] = $postvalue['eventId'];
        $inputArray['type'] = $postvalue['enventType'];
        $inputArray['id'] = $postvalue['tempId'];
        $inputArray['formmail'] = 'MeraEvents<admin@meraevents.com>';
        //$inputArray['backgroudcolor'] = $this->input->post('backgroudcolor');
       // $inputArray['id'] = $this->input->post('template_name');
            //$inputArray['bannerpathid'] = $_FILES['logopathid'];
           
//            $inputArray['facebooklink'] = $this->input->post('facebooklink');
//            $inputArray['youtubelink'] = $this->input->post('youtubelink');
//            $inputArray['googlelink'] = $this->input->post('googlelink');
//            $inputArray['twitterlink'] = $this->input->post('twitterlink');
//            $inputArray['instragramlink'] = $this->input->post('instragramlink');
//            $inputArray['linkedinlink'] = $this->input->post('linkedinlink');
            $output = $this->messagetemplate_handler->insertTemplate($inputArray);
            
            echo $output['status']; exit;
    }
    

}
