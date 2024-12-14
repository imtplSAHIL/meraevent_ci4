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
 * @Created     03-08-2015
 * @Last Modified On  03-08-2015
 * @Last Modified By  Qison  Dev Team
 */
require_once(APPPATH . 'handlers/reports_handler.php');
require_once (APPPATH . 'handlers/event_handler.php');
require_once (APPPATH . 'handlers/ticket_handler.php');
require_once (APPPATH . 'handlers/attendee_handler.php');
require_once(APPPATH . 'handlers/configure_handler.php');
require_once (APPPATH . 'handlers/attendeedetail_handler.php');
require_once (APPPATH . 'handlers/confirmation_handler.php');
require_once (APPPATH . 'handlers/orderlog_handler.php');
require_once (APPPATH . 'handlers/email_handler.php');
require_once (APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/booking_handler.php');

class Reports extends CI_Controller
{

    var $reportsHandler;
    var $eventHandler;
    var $attendeeHandler;
    var $confirmationHandler;
    var $orderlogHandler;
    var $emailHandler;
    var $userHandler;
    var $ci;

    public function __construct()
    {
        parent::__construct();
        $this->ci = & get_instance();
        $this->load->library(array('acl'));
        $this->reportsHandler = new Reports_handler();
        $this->eventHandler = new Event_handler();
        $this->confirmationHandler = new Confirmation_handler();
        $this->orderlogHandler = new Orderlog_handler();
        $this->emailHandler = new Email_handler();
        $this->userHandler = new User_handler();
        $this->bookingHandler = new Booking_handler();
        $this->eventsignupHandler = new Eventsignup_handler();
        $_GET['eventId'] = $this->uri->segment(3);
    }

    private function parseGPTWTransactions($gptw_event_transactions)
    {
        $result = array();
        if(empty($gptw_event_transactions['response']['transactionList']))
        {
            return $result;
        }
        
        foreach($gptw_event_transactions['response']['transactionList'] as $trans)
        {            
            $result[$trans['eventsignupid']] = $trans;
        }

        return $result;
    }

    public function transaction($eventId, $reportType, $transactionType, $page)
    {
        $postVar = $this->input->post();
        $getVar = $this->input->get();
        $inputArray['eventid'] = $eventId;
        $inputArray['reporttype'] = $reportType;
        $inputArray['transactiontype'] = $transactionType;
        $inputArray['page'] = $page;
        
        $inputArray['transactionstatus'] = 'all';
        $gptw_event_transactions = $this->reportsHandler->getOfflineFailedTransactions($inputArray);
        unset($inputArray['transactionstatus']);
        $gptw_event_transactions = $this->parseGPTWTransactions($gptw_event_transactions);
        
        $promotercode = isset($getVar['promotercode']) ? $getVar['promotercode'] : '';
        $currencycode = isset($getVar['currencycode']) ? $getVar['currencycode'] : '';
        $selectStagedRegistrationState = isset($getVar['selectStagedRegistrationState']) ? $getVar['selectStagedRegistrationState'] : '';
        $selectStagedPaymentStatus = isset($getVar['selectStagedPaymentStatus']) ? $getVar['selectStagedPaymentStatus'] : '';
        if (!empty($promotercode)) {
            $inputArray['promotercode'] = $promotercode;
        }
        if (!empty($currencycode)) {
            $inputArray['currencycode'] = $currencycode;
        }
        if (!empty($selectStagedRegistrationState)) {
            $inputArray['selectStagedRegistrationState'] = $selectStagedRegistrationState;
        }
        if (!empty($selectStagedPaymentStatus)) {
            $inputArray['selectStagedPaymentStatus'] = $selectStagedPaymentStatus;
        }
        $ticketid = isset($getVar['ticketid']) && $getVar['ticketid'] > 0 ? $getVar['ticketid'] : 0;
        if ($ticketid > 0) {
            $inputArray['ticketid'] = $ticketid;
        }
        $data = array();
        $data['content'] = 'transaction_reports_view';
        $data['headerFields'] = array();
        $tableHeaderResponse = $this->reportsHandler->getHeaderFields($inputArray);
        if ($tableHeaderResponse['status'] && $tableHeaderResponse['response']['total'] > 0) {
            $data['headerFields'] = $tableHeaderResponse['response']['headerFields'];
        }
        //$input['eventId'] = $eventId;
        $data['eventTitle'] = commonHelperGetEventName($eventId);
        $ticketHandler = new Ticket_handler();
        $inputTicket['eventId'] = $eventId;
        //To skip passing free tickets
        if ($transactionType == 'card') {
            $inputTicket['ticketType'] = "paid only";
        }
        $getEventTickets = $ticketHandler->getTicketName($inputTicket);
        if ($getEventTickets['status']) {
            if ($getEventTickets['response']['total'] > 0) {
                $data['ticketsData'] = $getEventTickets['response']['ticketName'];
            }
        } else {
            $data['errors'][] = $getEventTickets['response']['messages'][0];
        }
        if ($transactionType != 'incomplete') {
            if($transactionType != 'failed'){
            $grandTotal = $this->reportsHandler->getGrandTotal($inputArray);

            if ($grandTotal['status'] && $grandTotal['response']['total'] > 0) {
                $data['grandTotal'] = $grandTotal['response']['grandTotalResponse'];
                //echo '<pre>';print_r($data);exit;
            } else {
                $data['errors'][] = $grandTotal['response']['messages'][0];
            }
            }else{
                $grandTotal = $this->reportsHandler->getFailedTransactions($inputArray);
                $data['grandTotal'] = $grandTotal;

            }
        }
        $data['fileCustomFieldArray'] = array();
        $inputFileCustExists['eventid'] = $eventId;
        $fileCustExistsResponse = $this->reportsHandler->checkFileUploadExists($inputFileCustExists);
        if ($fileCustExistsResponse['status']) {
            if ($fileCustExistsResponse['response']['total'] > 0) {
                $fileCustomFieldData = $fileCustExistsResponse['response']['fileCustomFieldData'];
                $data['fileCustomFieldArray'] = $fileCustomFieldData;
            }
        } else {
            $data['errors'][] = $fileCustExistsResponse['response']['messages'][0];
        }
        $eventSettingsInputArray['eventId'] = $eventId;
        $eventSettingsDataArr = $this->eventHandler->getEventSettings($eventSettingsInputArray);
        if ($eventSettingsDataArr['status'] && $eventSettingsDataArr['response']['total'] > 0) {
            $eventSettingsResult = $eventSettingsDataArr['response']["eventSettings"][0];
            if ($eventSettingsResult['stagedevent'] == 1 && isset($postVar['stagedstatus'])) {
                $inputEventArray['eventId'] = $eventId;
                $eventDetails = $this->eventHandler->getEventDetails($inputEventArray);
                $inputPostPaymentEmailTemplate['email-signature'] = '';
                $inputRejectionData['email-footer'] = $inputPostPaymentEmailTemplate['email-footer'] = '<tr><td align="center" valign="top" width="100%" bgcolor="#FFFFFF" style="background-color: #FFFFFF;">
                                                                <center>
                                                                  <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                                    <tbody>
                                                                    <tr>
                                                                    <td align="center" valign="top" style="font-size: 15px; line-height: 15px;" height="15">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" width="100%" align="center">
                                                                          <tbody><tr><td align="center" valign="top" style="font-family: \'Segoe UI\',\'Trebuchet MS\',\'calibri\',\'Lucida Sans Unicode\',\'Lucida Grande\',\'Trebuchet MS\',\'Tahoma\',\'Helvetica Neue\',\'Arial\',\'sans-serif\' !important; font-size: 20px; font-weight: 500; color: #333333;">
                                                                           Get the MeraEvents app!</td>
                                                                        </tr></tbody></table>
                                                                      </td>
                                                                    </tr>

                                                                    <tr>
                                                                    <td align="center" valign="top" style="font-size: 15px; line-height: 15px;" height="15">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                      <td align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate !important;">
                                                                          <tbody><tr>
                                                                            <td class="app-block">
                                                                              <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate !important;">
                                                                                <tbody><tr>
                                                                                  <td align="center" valign="top">
                                                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                                                      <tbody><tr>
                                                                                        <td align="right" valign="top" class="aright">
                                                                                          <a href="http://bit.ly/meas2017" title="Download From App Store"><img width="142" height="45" class="info-img" src="{e-appstore-icon}" alt="Download From App Store"></a>
                                                                                        </td>
                                                                                      </tr>                           
                                                                                    </tbody></table>
                                                                                  </td>
                                                                                </tr>
                                                                              </tbody></table>
                                                                            </td>
                                                                            <td class="app-block">
                                                                              <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate !important;">
                                                                                <tbody><tr>
                                                                                  <td align="center" valign="top">
                                                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                                                      <tbody><tr>
                                                                                        <td align="left" valign="top" class="aleft">
                                                                                          <a href="http://bit.ly/megp2017" title="Download From Play Store"><img width="142" height="45" class="info-img" src="{e-playstore-icon}" alt="Download From Play Store"></a>
                                                                                        </td>
                                                                                      </tr>                           
                                                                                    </tbody></table>
                                                                                  </td>
                                                                                </tr>
                                                                              </tbody></table>
                                                                            </td>
                                                                          </tr>
                                                                        </tbody></table>
                                                                      </td>
                                                                    </tr>


                                                                    <tr>
                                                                      <td align="center" valign="top" style="font-size: 20px; line-height: 20px;" height="20">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                              <td align="center" valign="top" bgcolor="#ffffff" style="background-color: #FFFFFF;  border-top: 1px solid #e5e5e5; "> 
                                                            <table cellpadding="0" cellspacing="0" width="600" class="w320inline">
                                                                    <tbody> 
                                                                    <tr>
                                                                      <td align="center" valign="top" style="padding-top:10px; padding-bottom:10px; ">
                                                                        <table cellpadding="0" cellspacing="0" align="center" width="100%" style="border-collapse:separate !important;">
                                                                          <tbody><tr>
                                                                            <td align="center" valign="top" class="email-content">
                                                                              <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:separate !important;">
                                                                                <tbody><tr>
                                                                                  <td align="left" valign="top">
                                                                                          <table cellspacing="0" cellpadding="0" width="100%" align="center">
                                                                                            <tbody><tr>
                                                                                              <td align="center" valign="top">
                                                                                                <a style="color: #333333; font-family: \'Segoe UI\',\'Trebuchet MS\',\'calibri\',\'Lucida Sans Unicode\',\'Lucida Grande\',\'Trebuchet MS\',\'Tahoma\',\'Helvetica Neue\',\'Arial\',\'sans-serif\' !important; text-decoration: none;font-weight: normal; font-size: 14px;">Email Us : </a><a href="mailto:support@meraevents.com" style="color: #333333; text-decoration: none;font-family: \'Segoe UI\',\'Trebuchet MS\',\'calibri\',\'Lucida Sans Unicode\',\'Lucida Grande\',\'Trebuchet MS\',\'Tahoma\',\'Helvetica Neue\',\'Arial\',\'sans-serif\' !important;font-weight: normal; font-size: 14px; ">support@meraevents.com</a>    
                                                                                              </td>                                   
                                                                                            </tr>
                                                                                            </tbody>
                                                                                          </table>
                                                                                   </td>
                                                                                </tr>
                                                                              </tbody></table>
                                                                            </td>
                                                                             <td align="left" valign="top" class="email-content">
                                                                              <table cellpadding="0" cellspacing="0" width="100%" align="center" style="border-collapse:separate !important;">
                                                                                <tbody><tr>
                                                                                  <td align="left" valign="top">
                                                                                          <table cellspacing="0" cellpadding="0" width="100%" align="center">
                                                                                            <tbody><tr>
                                                                                              <td align="center" valign="top">
                                                                                                 <a style="color: #333333; text-decoration: none;font-family: \'Segoe UI\',\'Trebuchet MS\',\'calibri\',\'Lucida Sans Unicode\',\'Lucida Grande\',\'Trebuchet MS\',\'Tahoma\',\'Helvetica Neue\',\'Arial\',\'sans-serif\' !important;font-weight: normal; font-size: 14px;">Call Us : 040-49171447</a>
                                                                                              </td>                                   
                                                                                            </tr>
                                                                                          </tbody></table>
                                                                                        </td>
                                                                                </tr>
                                                                              </tbody></table>
                                                                            </td>
                                                                          </tr>

                                                                        </tbody></table>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                              <td height="10" style="height: 10px; line-height: 10px;">&nbsp;</td>
                                                            </tr>
                                                                  </tbody></table>
                                                              </td>
                                                            </tr> 
                                                                  </tbody></table>
                                                                </center>
                                                              </td>
                                                              </tr>
                                                             <tr>
                                                                      <td align="center" valign="top" style="font-size: 20px; line-height: 20px;" height="20">&nbsp;</td>
                                                                    </tr>
                                                              <tr>
                                                                                 <td align="center" valign="top" style="text-align: center; width: 320px; margin: 0 auto;">
                                                                                    <center>
                                                                                    <table border="0" align="center" cellpadding="0" cellspacing="0" width="320" style="text-align: center; width: 320px; margin: 0 auto;">
                                                                                       <tbody>

                                                                                          <tr>
                                                                                             <td align="center" valign="top">
                                                                                                <center>
                                                                                                <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 180px; margin: 0 auto; text-align: center;">
                                                                                                   <tbody>
                                                                                                      <tr>
                                                                                                         <td width="28" height="28">
                                                                                                            <a style="display: block; width: 28px; height: 28px; border-style: none !important; border: 0 !important;" href="http://www.facebook.com/meraeventsindia" title="Facebook" target="_blank"><img width="28" height="28" border="0" style="display: block; width: 28px; height: 28px;" src="{fb-email-icon}" alt="Facebook"></a>      
                                                                                                         </td>
                                                                                                         <td width="10">&nbsp;&nbsp;</td>
                                                                                                         <td width="28" height="28">
                                                                                                            <a style="display: block; width: 28px; height: 28px; border-style: none !important; border: 0 !important;" href="http://twitter.com/#!/meraeventsindia" title="Twitter" target="_blank"><img width="28" height="28" border="0" style="display: block; width: 28px; height: 28px;" src="{twitter-email-icon}" alt="Twitter"></a>    
                                                                                                         </td>
                                                                                                         <td width="10">&nbsp;&nbsp;</td>
                                                                                                         <td width="28" height="28">
                                                                                                            <a style="display: block; width: 28px; height: 28px; border-style: none !important; border: 0 !important;" href="https://www.instagram.com/meraeventsindia/" title="Instagram" target="_blank"><img width="28" height="28" border="0" style="display: block; width: 28px; height: 28px;" src="{instagram-email-icon}" alt="Instagram"></a>      
                                                                                                         </td>
                                                                                                         <td width="10">&nbsp;&nbsp;</td>
                                                                                                         <td width="28" height="28">
                                                                                                            <a style="display: block; width: 28px; height: 28px; border-style: none !important; border: 0 !important;" href="https://www.linkedin.com/company/meraevents" title="Linkedin" target="_blank"><img width="28" height="28" border="0" style="display: block; width: 28px; height: 28px;" src="{linkedin-email-icon}" alt="Linkedin"></a>      
                                                                                                         </td>
                                                                                                      </tr>
                                                                                                   </tbody>
                                                                                                </table></center>
                                                                                             </td>
                                                                                          </tr>
                                                                                       </tbody>
                                                                                    </table>
                                                                                  </center>
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                    <td align="center" valign="top" style="font-size: 10px; line-height: 10px;" height="10">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                     <td align="center" style="color: #666666; font-size: 12px; font-family: \'Segoe UI\',\'Trebuchet MS\',\'calibri\',\'Lucida Sans Unicode\',\'Lucida Grande\',\'Trebuchet MS\',\'Tahoma\',\'Helvetica Neue\',\'Arial\',\'sans-serif\' !important; mso-line-height-rule: exactly;">
                                                                     <p style="padding: 0; color: #666666; margin: 0;font-weight: normal; line-height: 20px;">This s is subject to MeraEvents  <a href="http://www.meraevents.com/terms" style="color: #9063cd; text-decoration: none; font-weight: normal;">Terms &amp; Conditions</a>,  <a href="http://www.meraevents.com/privacypolicy" style="color: #9063cd; text-decoration: none; font-weight: normal;">Privacy Policy</a></p>
                                                                        <p style="padding: 0; color: #666666; margin: 0;font-weight: normal; line-height: 20px;">You received this email because you have been registered/subscribed with <a href="http://www.meraevents.com" style="color: #666666; text-decoration: none; font-weight: normal;">MeraEvents.com</a></p>
                                                                        <p style="padding: 0; color: #666666; margin: 0;font-weight: normal; line-height: 20px;">To be sure that you receive our e-mail in your inbox, please add MeraEvents to your address book.</p>
                                                                        <p style="padding: 0; color: #666666; margin: 0;font-weight: normal; line-height: 20px;">&copy; ' . date('Y') . ' Versant Online Solutions Pvt Ltd. All Rights Reserved.</p>
                                                                     </td>
                                                                  </tr> 
                                                                    <tr>
                                                                    <td align="center" valign="top" style="font-size: 30px; line-height: 30px;" height="30">&nbsp;</td>
                                                                    </tr>';
                $inputRejectionData['email-signature'] = $inputPostPaymentEmailTemplate['email-signature'] = '';
                $inputRejectionData['email-footer'] = $inputPostPaymentEmailTemplate['email-footer'] = '';
                $inputRejectionData['bannerPath'] = $inputPostPaymentEmailTemplate['bannerPath'] = $eventDetails['response']['details']['bannerPath'];
                if ($postVar['stagedstatus'] == 'approve') {
                    foreach ($postVar['registrationIds'] as $key => $value) {
                        if ($eventSettingsResult['paymentstage'] == 1) {
                            // prepayment
                            $eventsignupInputArray['eventsignupId'] = $value;
                            $this->ci->load->model('Eventsignup_model');
                            $inputEventsignup = array();
                            $this->ci->Eventsignup_model->resetVariable();
                            $inputEventsignup[$this->ci->Eventsignup_model->stagedstatus] = 2;
                            $where[$this->ci->Eventsignup_model->id] = $value;
                            $this->ci->Eventsignup_model->setWhere($where);
                            $this->ci->Eventsignup_model->setInsertUpdateData($inputEventsignup);
                            $this->ci->Eventsignup_model->update_data();
                            $this->confirmationHandler->resendTransactionsuccessEmail($eventsignupInputArray);
                        } else if ($eventSettingsResult['paymentstage'] == 2) {
                            $orderLogInput['signupId'] = $value;
                            $eventsignupArray['eventsignupId'] = $value;
                            $eventsignupDetails = $this->confirmationHandler->getConfirmationeventsignupDetailData($eventsignupArray);
                            if ($eventsignupDetails['status'] && $eventsignupDetails['response']['total'] > 0) {
                                $singupData = $eventsignupDetails['response']['eventSignupDetailData'];
                            }
                            $orderLogData = $this->orderlogHandler->getOrderlog($orderLogInput);
                            $inputUserArray['userIds'] = $orderLogData['response']['orderLogData']['userid'];
                            $userDetails = $this->userHandler->getUserInfo($inputUserArray);
                            $inputPostPaymentEmailTemplate['USER_FIRST_NAME'] = $userDetails['response']['userData']['name'];
                            $inputPostPaymentEmailTemplate['EVENT_TITLE'] = $eventDetails['response']['details']['title'];
                            $inputPostPaymentEmailTemplate['EVENT_URL'] = commonHelperGetPageUrl('home') . 'event/' . $eventDetails['response']['details']['url'];
                            $inputPostPaymentEmailTemplate['REGISTRATION_LINK'] = commonHelperGetPageUrl('home') . 'login?redirect_url=payment?orderid=' . $orderLogData['response']['orderLogData']['orderid'] . '&incomplete=true';
                            $inputPostPaymentEmailTemplate['SUPPORT_LINK'] = commonHelperGetPageUrl('home') . 'support';
                            $subject = 'Complete the payment to confirm participation - ' . $eventDetails['response']['details']['title']; //  . ' Reg. no:' . $value;
                            $inputPostPaymentEmailTemplate['subject'] = $subject;
                            $inputPostPaymentEmailTemplate['meraevent-email-logo'] = $this->ci->config->item('images_static_path') . 'emailers/meraevent-email-logo.png';
                            $inputPostPaymentEmailTemplate['e-incomplete-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-incomplete-icon.png';
                            $inputPostPaymentEmailTemplate['e-deleterequest-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-deleterequest-icon.png';
                            $inputPostPaymentEmailTemplate['supportMobile'] = GENERAL_INQUIRY_MOBILE;
                            $inputPostPaymentEmailTemplate['supportEmail'] = GENERAL_INQUIRY_EMAIL;
                            $inputPostPaymentEmailTemplate['e-deleterequest-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-deleterequest-icon.png';
                            $inputPostPaymentEmailTemplate['e-venue-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-venue-icon.png';
                            $inputPostPaymentEmailTemplate['e-date-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-date-icon.png';
                            $inputPostPaymentEmailTemplate['e-delreg-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-delreg-icon.png';
                            $inputPostPaymentEmailTemplate['e-appstore-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-appstore-icon.png';
                            $inputPostPaymentEmailTemplate['e-playstore-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-playstore-icon.png';
                            $inputPostPaymentEmailTemplate['fb-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/fb-email-icon.png';
                            $inputPostPaymentEmailTemplate['twitter-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/twitter-email-icon.png';
                            $inputPostPaymentEmailTemplate['gplus-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/gplus-email-icon.png';
                            $inputPostPaymentEmailTemplate['instagram-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/instagram-email-icon.png';
                            $inputPostPaymentEmailTemplate['linkedin-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/linkedin-email-icon.png';
                            $inputPostPaymentEmailTemplate['toEmail'] = $userDetails['response']['userData']['email'];
                            if ($eventsignupDetails['response']['eventSignupDetailData']['eventsignupDetails']['totalamount'] == 0) {
                                $this->ci->load->model('Eventsignup_model');
                                $inputEventsignup = array();
                                $this->ci->Eventsignup_model->resetVariable();
                                $inputEventsignup[$this->ci->Eventsignup_model->stagedstatus] = 2;
                                $where[$this->ci->Eventsignup_model->id] = $value;
                                $this->ci->Eventsignup_model->setWhere($where);
                                $this->ci->Eventsignup_model->setInsertUpdateData($inputEventsignup);
                                $this->ci->Eventsignup_model->update_data();
                                $eventsignupInputArray['eventsignupId'] = $value;
                                $emailsendResult = $this->confirmationHandler->resendTransactionsuccessEmail($eventsignupInputArray);
                            } else {
                                $emailsendResult = $this->emailHandler->sendIncompletePaymentDetailsEmail($inputPostPaymentEmailTemplate, $singupData);
                            }

                            if ($emailsendResult['status'] == true) {
                                $this->ci->load->model('Eventsignup_model');
                                $inputEventsignup = array();
                                $this->ci->Eventsignup_model->resetVariable();
                                $inputEventsignup[$this->ci->Eventsignup_model->stagedstatus] = 2;
                                $where[$this->ci->Eventsignup_model->id] = $value;
                                $this->ci->Eventsignup_model->setWhere($where);
                                $this->ci->Eventsignup_model->setInsertUpdateData($inputEventsignup);
                                $this->ci->Eventsignup_model->update_data();
                            }
                        }
                    }
                } else if ($postVar['stagedstatus'] == 'reject') {
                    foreach ($postVar['registrationIds'] as $key => $value) {
                        $this->ci->load->model('Eventsignup_model');
                        $inputEventsignup = array();
                        $this->ci->Eventsignup_model->resetVariable();
                        $inputEventsignup[$this->ci->Eventsignup_model->stagedstatus] = 3;
                        $where[$this->ci->Eventsignup_model->id] = $value;
                        $this->ci->Eventsignup_model->setWhere($where);
                        $this->ci->Eventsignup_model->setInsertUpdateData($inputEventsignup);
                        $this->ci->Eventsignup_model->update_data();
                        $orderLogInput['signupId'] = $value;
                        $eventsignupArray['eventsignupId'] = $value;
                        $eventsignupDetails = $this->confirmationHandler->getConfirmationeventsignupDetailData($eventsignupArray);
                        if ($eventsignupDetails['status'] && $eventsignupDetails['response']['total'] > 0) {
                            $singupData = $eventsignupDetails['response']['eventSignupDetailData'];
                        }
                        $orderLogData = $this->orderlogHandler->getOrderlog($orderLogInput);
                        $inputUserArray['userIds'] = $orderLogData['response']['orderLogData']['userid'];
                        $userDetails = $this->userHandler->getUserInfo($inputUserArray);
                        $inputRejectionData['signupdata'] = $singupData;
                        $inputRejectionData['toEmail'] = $userDetails['response']['userData']['email'];
                        $inputRejectionData['USER_FIRST_NAME'] = $userDetails['response']['userData']['name'];
                        $inputRejectionData['EVENT_ID'] = $eventDetails['response']['details']['id'];
                        $inputRejectionData['EVENT_TITLE'] = $eventDetails['response']['details']['title'];
                        $inputRejectionData['EVENT_URL'] = commonHelperGetPageUrl('home') . 'event/' . $eventDetails['response']['details']['url'];
                        $inputRejectionData['SUPPORT_LINK'] = commonHelperGetPageUrl('home') . 'support';
                        $inputRejectionData['meraevent-email-logo'] = $this->ci->config->item('images_static_path') . 'emailers/meraevent-email-logo.png';
                        $inputRejectionData['e-incomplete-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-incomplete-icon.png';
                        $inputRejectionData['e-deleterequest-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-deleterequest-icon.png';
                        $inputRejectionData['supportMobile'] = GENERAL_INQUIRY_MOBILE;
                        $inputRejectionData['supportEmail'] = GENERAL_INQUIRY_EMAIL;
                        $inputRejectionData['e-deleterequest-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-deleterequest-icon.png';
                        $inputRejectionData['e-venue-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-venue-icon.png';
                        $inputRejectionData['e-date-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-date-icon.png';
                        $inputRejectionData['e-delreg-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-delreg-icon.png';
                        $inputRejectionData['e-appstore-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-appstore-icon.png';
                        $inputRejectionData['e-playstore-icon'] = $this->ci->config->item('images_static_path') . 'emailers/e-playstore-icon.png';
                        $inputRejectionData['fb-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/fb-email-icon.png';
                        $inputRejectionData['twitter-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/twitter-email-icon.png';
                        $inputRejectionData['gplus-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/gplus-email-icon.png';
                        $inputRejectionData['instagram-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/instagram-email-icon.png';
                        $inputRejectionData['linkedin-email-icon'] = $this->ci->config->item('images_static_path') . 'emailers/linkedin-email-icon.png';
                        $inputRejectionData['eventSignupID'] = $value;
                        if ($eventSettingsResult['paymentstage'] == 1) {
                            $prePaymentRejectionEmailtoDelegateResult = $this->emailHandler->sendPrePaymentRejectionEmailtoDelegate($inputRejectionData);
                            $prePaymentRefundEmailtoSupportResult = $this->emailHandler->sendPrePaymentRefundEmailtoSupport($inputRejectionData);
                        } else if ($eventSettingsResult['paymentstage'] == 2) {
                            $postPaymentRejectionEmailtoDelegateResult = $this->emailHandler->sendPostPaymentRejectionEmailtoDelegate($inputRejectionData);
                        }
                    }
                }
            }
        }

        if ($eventSettingsDataArr['status'] && $eventSettingsDataArr['response']['total'] > 0) {
            $eventSettingsResult = $eventSettingsDataArr['response']["eventSettings"][0];
            if ($eventSettingsResult['stagedevent'] == 1) {
                $inputArray['stagedevent'] = $eventSettingsResult['stagedevent'];
                $inputArray['paymentstage'] = $eventSettingsResult['paymentstage'];
            }
        }

        $transactionListResponse = $this->reportsHandler->getReportDetails($inputArray);
        $transactionsTypes = array('card', 'cod', 'free', 'offline', 'incomplete', 'failed', 'boxoffice', 'viral', 'organizer', 'affiliate', 'cancel', 'others', 'meraevents', 'spotregistration');
        
        $data['typeOfTransactionsDone'] = $typeOfPaymentCount;
        if ($eventSettingsResult['paymentstage'] == 1) {
            $data['stagedRegistrationStates'] = array(1 => "Registered", 2 => "Approved", 3 => "Rejected");
        }if ($eventSettingsResult['paymentstage'] == 2) {
            // Showing incomplete in all itself
            if (isset($data['typeOfTransactionsDone']['incomplete'])) {
                unset($data['typeOfTransactionsDone']['incomplete']);
            }
            $data['stagedRegistrationStates'] = array(1 => "Registered", 2 => "Approved", 3 => "Rejected", 5 => "Approved paid", 7 => "Registered not paid", 8 => "Approved not paid");
        }

        if ($transactionListResponse['status'] && $transactionListResponse['response']['total'] > 0) {
            $data['transactionList'] = $transactionListResponse['response']['transactionList'];
            if (isset($transactionListResponse['response']['downloadAllRequired'])) {
                $data['downloadAllRequired'] = $transactionListResponse['response']['downloadAllRequired'];
            }
            $data['totalTransactionCount'] = $transactionListResponse['response']['totalTransactionCount'];
        } else {
            $data['errors'][] = $transactionListResponse['response']['messages'][0];
        }

        $data['is_gptw'] = 0;
        $GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY;
        if(!empty($GPTW_EVENTS_ARRAY[$eventId]))
        {
            $data['GPTW_transactions'] = $gptw_event_transactions;
            $data['purchaser_data'] = $this->eventsignupHandler->getEventPurchasersData($eventId);
            $data['headerFields'] = array('Sr No.', 'Purchase Date', 'Organisation Name', 'Purchaser Name', 
                'Purchaser Email', 'Purchaser Mobile Number', 'Quantity', 'Payment Type', 'Tax Invoice Number', 
                'Total Amount Paid', 'Actions');
            $data['is_gptw'] = 1;
            $data['content'] = 'purchaser_dashboard_view';
        }
        $data['page'] = $page;
        $data['hideLeftMenu'] = 0;
        $data['eventSettings'] = $eventSettingsResult;
        $data['transactionType'] = $transactionType;
        $data['eventId'] = $eventId;
        $data['ticketId'] = $ticketid;
        $data['reportType'] = $reportType;
        $data['promoterCode'] = $promotercode;
        $data['currencyCode'] = $currencycode;
        $data['selectStagedRegistrationState'] = $selectStagedRegistrationState;
        $data['selectStagedPaymentStatus'] = $selectStagedPaymentStatus;
        $data['pageTitle'] = 'MeraEvents | Export Reports';

        if(!empty($_GET['preport']) && $_GET['preport'] = 1)
        {
            $purchaser_data = $data['purchaser_data'];
            $final_array = array();
            foreach ($data['transactionList'] as $value) {

                $final_array[$value['id']]['first_name'] = $purchaser_data[$value['id']]['first_name'];
                $final_array[$value['id']]['last_name'] = $purchaser_data[$value['id']]['last_name'];
                $final_array[$value['id']]['email_id'] = $purchaser_data[$value['id']]['email_id'];
                $final_array[$value['id']]['mobile'] = "'".$purchaser_data[$value['id']]['mobile']."'";
                $final_array[$value['id']]['org_name'] = $purchaser_data[$value['id']]['org_name'];
                $final_array[$value['id']]['gst'] = $purchaser_data[$value['id']]['gst'];
                // $final_array[$value['id']]['pan'] = $purchaser_data[$value['id']]['pan'];
                $final_array[$value['id']]['job_title'] = $purchaser_data[$value['id']]['job_title'];
                $final_array[$value['id']]['industry'] = $purchaser_data[$value['id']]['industry'];
                $final_array[$value['id']]['employee_strength'] = $purchaser_data[$value['id']]['employee_strength'];
                $final_array[$value['id']]['billing_address'] = $purchaser_data[$value['id']]['billing_address'];
                $final_array[$value['id']]['country'] = $purchaser_data[$value['id']]['country'];
                $final_array[$value['id']]['state'] = $purchaser_data[$value['id']]['state'];
                $final_array[$value['id']]['city'] = $purchaser_data[$value['id']]['city'];
                $final_array[$value['id']]['pincode'] = $purchaser_data[$value['id']]['pincode'];

                $final_array[$value['id']]['is_sez_unit'] = $purchaser_data[$value['id']]['is_sez_unit'];
                $final_array[$value['id']]['existing_client'] = $purchaser_data[$value['id']]['existing_client'];
                $final_array[$value['id']]['agree_tnc'] = $purchaser_data[$value['id']]['agree_tnc'];
                $final_array[$value['id']]['purchaser_date'] = $purchaser_data[$value['id']]['purchaser_date'];
                
                if(empty($purchaser_data[$value['id']]['purchaser_date']))
                {
                    $final_array[$value['id']]['purchaser_date'] = $value['signupDate'];
                }
               
                $final_array[$value['id']]['quantity'] = $purchaser_data[$value['id']]['quantity'];
                $final_array[$value['id']]['paid'] = $value['paid'];
                $final_array[$value['id']]['tax_invoice_number'] = $purchaser_data[$value['id']]['tax_invoice_number'];
                $final_array[$value['id']]['invoice_date'] = $purchaser_data[$value['id']]['invoice_date'];

                // $final_array[$value['id']]['po_number'] = $purchaser_data[$value['id']]['po_number'];
                $final_array[$value['id']]['payment_type'] = 'Online';
                if($value['paymenttransactionid'] == 'Offline') {
                    $final_array[$value['id']]['payment_type'] = 'Offline';
                }
                $final_array[$value['id']]['Registered_date'] = $value['signupDate'];

            }
            $this->mssafe_csv_download($final_array);
            exit;
        }
        $data['jsArray'] = array(//$this->config->item('js_public_path') . 'dashboard/reports.min.js.gz'
            $this->config->item('js_public_path') . 'dashboard/jszip',
            $this->config->item('js_public_path') . 'dashboard/jszip-utils',
            $this->config->item('js_public_path') . 'dashboard/FileSaver',
            $this->config->item('js_public_path') . 'dashboard/reports');

        $this->load->view('templates/dashboard_template', $data);
    }

    public function editPurchaser($eventsignupId)
    {
        if(!empty($_POST)) // Update purchaser Details
        {
            $redirect_page = $_POST['redirect_page'];
            unset($_POST['redirect_page']);

            $is_updated = $this->reportsHandler->updatePurchaserDetails($_POST);
            $data['status_message'] = "Error in updating details.";
            if($is_updated)
            {
                $data['status_message'] = "Updated Successfully.";
                $purchaserDetails = $this->reportsHandler->getEventSignupDetail($eventsignupId);
                $redirectUrl = commonHelperGetPageUrl('dashboard-transaction-report', $purchaserDetails['eventid'] . '&summary&all&1');
                if($redirect_page == 'offlinepending')
                {
                    $redirectUrl = commonHelperGetPageUrl('dashboard-offline-pending-transaction-report').$purchaserDetails['eventid'];
                }
                redirect($redirectUrl);
                exit;
            }
        }
        
        $data['redirect_page'] = 'confirmed';
        if( stripos($_SERVER['HTTP_REFERER'], 'offlinepending') !== FALSE ) {
            $data['redirect_page'] = 'offlinepending';
        }

        $data['purchaserDetails'] = $this->reportsHandler->getEventSignupDetail($eventsignupId);
        $input['eventsignupId'] = $eventsignupId;
        $data['eventsignupId'] = $eventsignupId;
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'edit_purchaser_view';
        $data['jsTopArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/tickettransfer',
            $this->config->item('js_public_path') . 'intlTelInput'
        );
        
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'intlTelInput',
            $this->config->item('css_public_path') . 'tickettransfer'
        );

        $data['pageTitle'] = 'MeraEvents | Edit Invocie Details';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function offlinepending($eventId)
    {
        $postVar = $this->input->post();
        $getVar = $this->input->get();
        $inputArray['eventid'] = $eventId;
        $inputArray['reporttype'] = $getVar['report'];
        $inputArray['page'] = $page;

        $data = array();
        $data['content'] = 'offline_transaction_reports_view';
        $data['headerFields'] = array('SNO', 'Organization Name', 'Purchaser Name', 'Email id', 'Purchaser Contact Number', 'Quantity', 'Total Outstanding Amount', 'Proforma Invoice Number', 'Proforma Invoice', 'Tax Invoice', 'Actions');

        //$input['eventId'] = $eventId;
        $data['eventTitle'] = commonHelperGetEventName($eventId);
        $ticketHandler = new Ticket_handler();
        $inputTicket['eventId'] = $eventId;
        //To skip passing free tickets
        if ($transactionType == 'card') {
            $inputTicket['ticketType'] = "paid only";
        }
        $getEventTickets = $ticketHandler->getTicketName($inputTicket);
        if ($getEventTickets['status']) {
            if ($getEventTickets['response']['total'] > 0) {
                $data['ticketsData'] = $getEventTickets['response']['ticketName'];
            }
        } else {
            $data['errors'][] = $getEventTickets['response']['messages'][0];
        }
        
        $eventSettingsInputArray['eventId'] = $eventId;
        $transactionListResponse = $this->reportsHandler->getOfflineFailedTransactions($inputArray);

        if ($transactionListResponse['status'] && $transactionListResponse['response']['total'] > 0) {
            $data['transactionList'] = $transactionListResponse['response']['transactionList'];
        } else {
            $data['errors'][] = $transactionListResponse['response']['messages'][0];
        }
        if($getVar['report'] == 1)
        {
            $data['headerFields'] = array('SNO', 'Organization Name', 'Purchaser Name', 'Email id', 'Purchaser Contact Number', 'Quantity', 'Total Outstanding Amount', 'Proforma Invoice Number','Registered On','Invoice Date');
            $this->mssafe_csv_offline_pending_dashboard($data['transactionList'], $data['ticketsData'], $data['headerFields']);
        }
        
        $data['page'] = $page;
        $data['hideLeftMenu'] = 0;
        $data['eventId'] = $eventId;
        $data['ticketId'] = $ticketid;
        $data['pageTitle'] = 'MeraEvents | Export Reports';
        $data['jsArray'] = array(//$this->config->item('js_public_path') . 'dashboard/reports.min.js.gz'
            $this->config->item('js_public_path') . 'dashboard/jszip',
            $this->config->item('js_public_path') . 'dashboard/jszip-utils',
            $this->config->item('js_public_path') . 'dashboard/FileSaver',
            $this->config->item('js_public_path') . 'dashboard/reports');
        
        $this->load->view('templates/offline_pending_template', $data);
    }

    public function offlineAttendees($eventId)
    {
        $postVar = $this->input->post();
        $getVar = $this->input->get();
        // echo '<pre>';print_r($getVar);echo '</pre>'; exit();
        $inputArray['eventid'] = $eventId;
        $inputArray['reporttype'] = $getVar['report'];
        $inputArray['page'] = $page;
        
        $data = array();
        $data['content'] = 'attendee_transaction_reports_view';
        
        //$input['eventId'] = $eventId;
        $data['eventTitle'] = commonHelperGetEventName($eventId);
        $ticketHandler = new Ticket_handler();
        $inputTicket['eventId'] = $eventId;
        //To skip passing free tickets
        if ($transactionType == 'card') {
            $inputTicket['ticketType'] = "paid only";
        }
        $getEventTickets = $ticketHandler->getTicketName($inputTicket);
        if ($getEventTickets['status']) {
            if ($getEventTickets['response']['total'] > 0) {
                $ticket_data = $getEventTickets['response']['ticketName'];
                $ticket_array = [];
                foreach($ticket_data as $row)
                {
                    $ticket_array[$row['id']] = $row;
                }
                $data['ticketsData'] = $ticket_array;
            }
        } else {
            $data['errors'][] = $getEventTickets['response']['messages'][0];
        }
        
        $eventSettingsInputArray['eventId'] = $eventId;
        $result = $this->eventsignupHandler->getAttendeeListByEventId($eventId);
        $data['attendeeList'] = $result['attendeeList'];
        $data['header_array'] = $result['header_array'];
        
        if($getVar['report'] == 1)
        {
            // $data['headerFields'] = array('SNO', 'Organization Name', 'Attendee Name', 'Email id', 'Attendee Contact Number', 'Ticket Quantity', 'Ticket Type', 'Purchaser Name', 'Purchaser email');
            $this->mssafe_csv_attendee_dashboard($data['attendeeList'], $data['ticketsData'], $data['header_array']);
        }
        $data['page'] = $page;
        $data['hideLeftMenu'] = 0;
        $data['eventId'] = $eventId;
        $data['ticketId'] = $ticketid;
        $data['pageTitle'] = 'MeraEvents | Export Reports';
        $data['jsArray'] = array(//$this->config->item('js_public_path') . 'dashboard/reports.min.js.gz'
            $this->config->item('js_public_path') . 'dashboard/jszip',
            $this->config->item('js_public_path') . 'dashboard/jszip-utils',
            $this->config->item('js_public_path') . 'dashboard/FileSaver',
            $this->config->item('js_public_path') . 'dashboard/reports');
        
        $this->load->view('templates/offline_pending_template', $data);
    }
    
    public function downloadProfarmaInvoice($eventsignupId)
    {
        $eventsignupDetails = $this->confirmationHandler->downloadProfarmaInvoice($eventsignupId);
        exit;
    }

    public function downloadTaxInvoice($eventsignupId)
    {
        $eventsignupDetails = $this->confirmationHandler->downloadTaxInvoice($eventsignupId);
        exit;
    }
    
    public function emailTaxInvoice($eventsignupId)
    {
        // $eventsignupDetails = $this->confirmationHandler->emailTaxInvoice($eventsignupId);        
        $purchaserDetails = $this->eventsignupHandler->getEventSignupDetailsByID($eventsignupId);
        $inputArray['eventsignupId'] = $eventsignupId;
        $inputArray['mobile'] = $purchaserDetails['mobile'];
        $inputArray['eventtitle'] = $purchaserDetails['title'];
        $inputArray['eventid'] = $purchaserDetails['eventid'];
        $inputArray['timezone'] = 'IST';
        $inputArray['userId'] = $purchaserDetails['userid'];
        $inputArray['purchaser_date'] = date('d/m/Y');
    	
        $inputArray['isOrganizer'] = $this->customsession->getData("isOrganizer") ? true : false;
        //==== Send payment confirmation email to purchaser ====//
        $inputArray['force_attendee_email'] = false;
        $inputArray['send_tax_invoice'] = 1;
        $inputArray['send_ticket'] = 'no';
        $sendEmail = $this->confirmationHandler->resendPurchaserTransactionsuccessEmail($inputArray);
        echo "<b>Tax invoice is sent to the purchaser email id ".$purchaserDetails['email_id'].". <b>";
        exit;
    }
    
    public function raiseTaxInvoice($eventsignupId)
    {
        $purchaserDetails = $this->eventsignupHandler->getEventSignupDetailsByID($eventsignupId);
        $is_updated = $this->eventsignupHandler->raiseTaxInvoice($eventsignupId);
        $eventsignupDetails = $this->confirmationHandler->emailTaxInvoice($eventsignupId);

        // header('Location: ' . $_SERVER['HTTP_REFERER']);
        $redirectUrl = commonHelperGetPageUrl('dashboard-offline-pending-transaction-report').$purchaserDetails['eventid'];
        redirect($redirectUrl);
        exit;
    }

    public function cancelRegistration($eventsignupId)
    {
        $purchaserDetails = $this->eventsignupHandler->getEventSignupDetailsByID($eventsignupId);
        $is_updated = $this->eventsignupHandler->cancelRegistration($eventsignupId);
        $redirectUrl = commonHelperGetPageUrl('dashboard-offline-pending-transaction-report').$purchaserDetails['eventid'];
        redirect($redirectUrl);
        exit;
    }

    public function emailProfarmaInvoice($eventsignupId)
    {
        $eventsignupDetails = $this->confirmationHandler->emailProfarmaInvoice($eventsignupId);
        $purchaserDetails = $this->eventsignupHandler->getEventSignupDetailsByID($eventsignupId);
        echo "<b>Proforma invoice is sent to the purchaser email id ".$purchaserDetails['email_id'].". <b>";
        exit;
    }

    public function makeTransactionSuccess($eventsignupId)
    {
        $is_updated = $this->reportsHandler->makePurchaserTransactionSuccess($eventsignupId);
        $purchaserDetails = $this->eventsignupHandler->getEventSignupDetailsByID($eventsignupId);
        $inputArray['eventsignupId'] = $eventsignupId;
        $inputArray['mobile'] = $purchaserDetails['mobile'];
        $inputArray['eventtitle'] = $purchaserDetails['title'];
        $inputArray['eventid '] = $purchaserDetails['eventid'];
        $inputArray['timezone'] = 'IST';
        $inputArray['userId'] = $purchaserDetails['userid'];
        $inputArray['purchaser_date'] = date('d/m/Y');
    	
        $inputArray['isOrganizer'] = $this->customsession->getData("isOrganizer") ? true : false;
        //==== Send registration confirmation to attendee ====//
        // $inputArray['force_attendee_email'] = true;
        // $sendEmail = $this->confirmationHandler->resendPurchaserTransactionsuccessEmail($inputArray);

        //==== Send payment confirmation email to purchaser ====//
        $inputArray['force_attendee_email'] = false;
        $inputArray['send_tax_invoice'] = 2;

        $sendEmail = $this->confirmationHandler->resendPurchaserTransactionsuccessEmail($inputArray);
        $redirectUrl = commonHelperGetPageUrl('dashboard-offline-pending-transaction-report').$purchaserDetails['eventid'];
        redirect($redirectUrl);
        exit;
    }

    public function downloadAttendeeInfo($eventsignupId)
    {
        // output headers so that the file is downloaded rather than displayed
        $eventsignupArray['eventsignupId'] = $eventsignupId;
        $eventSignupdata = $this->eventsignupHandler->getEventsignupDetailData($eventsignupArray);
        $attendee_array = $eventSignupdata['response']['eventSignupDetailData']['attendees']['otherAttendee'];
        $purchaserDetails = $this->bookingHandler->getPurchaserDetails($eventsignupId, 'eventsignupid');
        // echo '<pre>';print_r($purchaserDetails);echo '</pre>'; exit();
        $output = $this->mssafe_csv($attendee_array, $purchaserDetails);
    }
    
    public function mssafe_csv($data, $purchaserDetails = array())
    {
        foreach($data as $row)
        {
            $header = array_keys($row);
            break;
        }
        $file_name = "Attendee_Details_".date("Y-m-d-h-i").'.csv';

        header('Content-type: text/csv');
        header("Content-Disposition: attachment; filename=$file_name");
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
        
        if(!empty($purchaserDetails))
        {
            fputcsv($file, array("Purchaser Details"));
            $full_name = $purchaserDetails['first_name']. ' '. $purchaserDetails['last_name'];
            fputcsv($file, array("Name", $full_name));
            fputcsv($file, array("Email", $purchaserDetails['email_id']));
            fputcsv($file, array("Mobile", $purchaserDetails['mobile']));
            fputcsv($file, array("Org Name", $purchaserDetails['org_name']));
            fputcsv($file, array("Job Title", $purchaserDetails['job_title']));
            fputcsv($file, array("Industry", $purchaserDetails['industry']));
            fputcsv($file, array("Employee Strength", $purchaserDetails['employee_strength']));
            fputcsv($file, array("Billing Address", $purchaserDetails['billing_address']));
            fputcsv($file, array("Country", $purchaserDetails['country']));
            fputcsv($file, array("State", $purchaserDetails['state']));
            fputcsv($file, array("City", $purchaserDetails['city']));
            
            $string = 'No';
            if($purchaserDetails['is_sez_unit'] == 1)
            {
                $string = 'Yes';
            }
            fputcsv($file, array(" Do you come under SEZ Unit?", $string));
            
            $string = 'No';
            if($purchaserDetails['existing_client'] == 1)
            {
                $string = 'Yes';
            }
            fputcsv($file, array("Are you an existing client of Great Place to Work&reg;? ", $string));
            
            $string = 'No';
            if($purchaserDetails['agree_tnc'] == 1)
            {
                $string = 'Yes';
            }
            
            fputcsv($file, array("I agree to the terms and conditions.", $string));
            fputcsv($file, array('', ''));
        }
        
        // send the column headers
        fputcsv($file, $header);
        // output each row of the data
        foreach ($data as $row)
        {
            if(!empty($row))
            {
                fputcsv($file, $row);
            }
        }
        exit();
    }
    
    public function downloadAttendeeDashboard($eventsignupId)
    {
        // output headers so that the file is downloaded rather than displayed
        $eventsignupArray['eventsignupId'] = $eventsignupId;
        $eventSignupdata = $this->eventsignupHandler->getEventsignupDetailData($eventsignupArray);
        // $attendee_array = $eventSignupdata['response']['eventSignupDetailData']['attendees']['otherAttendee'];
        $purchaserDetails = $this->bookingHandler->getPurchaserDetails($eventsignupId, 'eventsignupid');

        $ticketHandler = new Ticket_handler();
        //To skip passing free tickets
        if ($transactionType == 'card') {
            $inputTicket['ticketType'] = "paid only";
        }
        $getEventTickets = $ticketHandler->getTicketName($inputTicket);
        if ($getEventTickets['status']) {
            if ($getEventTickets['response']['total'] > 0) {
                $ticket_data = $getEventTickets['response']['ticketName'];
                $ticket_array = [];
                foreach($ticket_data as $row)
                {
                    $ticket_array[$row['id']] = $row;
                }
                $data['ticketsData'] = $ticket_array;
            }
        } else {
            $data['errors'][] = $getEventTickets['response']['messages'][0];
        }
        
        $result = $this->eventsignupHandler->getAttendeeListByEventId($eventId = '', $eventsignupId);
        $data['attendeeList'] = $result['attendeeList'];
        $data['header_array'] = $result['header_array'];
        $this->mssafe_csv_attendee_dashboard($data['attendeeList'], $data['ticketsData'], $data['header_array']);
        // $output = $this->mssafe_csv_attendee_dashboard($attendee_array, $purchaserDetails);
    }
    
    public function mssafe_csv_attendee_dashboard($data, $ticketsData, $header_array)
    {
        $file_name = "Confirmed_Attendee_Transactions_".date("Y-m-d-h-i").'.csv';
        header('Content-type: text/csv');
        header("Content-Disposition: attachment; filename=$file_name");
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
        array_pop($header_array); //Remove last column "Actions".

        fputcsv($file, $header_array);
        $i = 1;
        foreach ($data as $transactions)
        {
            if(!empty($transactions))
            {   
                foreach($transactions as $attendee_id => $attendee_data)
                {
                    $row = array();
                    foreach($header_array as $key)
                    {
                        if($key == 'Actions')
                        {
                            continue;
                        }
                        else if($key == 'SNo')
                        {
                            array_push($row, $i);
                        }
                        else
                        {
                            if($key == 'Mobile No')
                            {
                                $attendee_data['Mobile No'] = "'".$attendee_data['Mobile No']."'";
                            }
                            array_push($row, $attendee_data[$key]);
                        }
                    }

                    // fputcsv($file, array($i, $transactions['org_name'], $transactions['Full Name'], $transactions['Email Id'], $transactions['Mobile No'], $transactions['quantity'], ucwords($ticketsData[$transactions['ticketid']]['type']), $transactions['first_name'].' '.$transactions['last_name'], $transactions['email_id']));
                    fputcsv($file, $row);
                    $i++;
                }
            }
        }
        exit();
    }

    public function mssafe_csv_download($input_array)
    {
        $file_name = "Confirmed_Purchaser_Transactions_".date("Y-m-d-h-i").'.csv';
        header('Content-type: text/csv');
        header("Content-Disposition: attachment; filename=$file_name");
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
        $i = 1;
        foreach ($input_array as $transaction)
        {
            if(!empty($transaction))
            {
                if($i == 1)
                {
                    $header_array = array_keys($transaction);
                    $header_array = array_merge(array('Sno' => 'Sno'), $header_array);
                    fputcsv($file, $header_array);
                }
                $row[0] = $i;
                $row = array_merge($row, $transaction);
                fputcsv($file, $row);
                $i++;
            }
        }
        exit();
    }
    public function mssafe_csv_offline_pending_dashboard($data, $ticketsData, $header_array)
    {
        $file_name = "Offline_Pending_Transactions_".date("Y-m-d-h-i").'.csv';
        header('Content-type: text/csv');
        header("Content-Disposition: attachment; filename=$file_name");
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
        
        fputcsv($file, $header_array);
        $i = 1;
        foreach ($data as $transactions)
        {
            if(!empty($transactions))
            {
                $transactions['mobile'] = "'".$transactions['mobile']."'";
                fputcsv($file, array($i, $transactions['org_name'], $transactions['first_name']. ' '.$transactions['last_name'], $transactions['email_id'], $transactions['mobile'], $transactions['quantity'], $transactions['totalamount'],  $transactions['invoice_number'],$transactions['signupdate'],$transactions['invoice_date']));
            }
            $i++;
        }
        exit();
    }
    
    public function saleseffort($eventId)
    {
        $data['eventId'] = $eventId;
        $data['hideLeftMenu'] = 0;
        $data['eventTitle'] = commonHelperGetEventName($eventId);
        $data['content'] = 'sales_effort_reports_view';
        $data['jsArray'] = array();
        $data['cssArray'] = array();
        $inputSales['eventid'] = $eventId;
        $inputSales['page_name'] = 'sales_effort_reports_view';
        $salesData = $this->reportsHandler->getSalesEffortData($inputSales);
        //print_r($salesData);exit;
        if ($salesData['status'] && $salesData['response']['total'] > 0) {
            $data['salesData'] = $salesData['response']['salesEffortResponse'];
        } else {
            $data['errors'][] = $salesData['response']['messages'][0];
        }
        //print_r($data);exit;
        $data['pageTitle'] = 'MeraEvents | Sales Effort';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function analyticsreport($eventId)
    {
        $this->load->model('Event_model');
        $selectInput['id'] = $this->Event_model->id;
        $selectInput['title'] = $this->Event_model->title;
        $selectInput['url'] = $this->Event_model->url;
        $selectInput['cts'] = $this->Event_model->cts;
        $this->Event_model->setSelect($selectInput);
        $where[$this->Event_model->id] = $eventId;
        $this->Event_model->setWhere($where);
        $eventData = $this->Event_model->get();
        require_once(APPPATH . 'handlers/analytics_handler.php');
        $this->analyticsHandler = new Analytics_handler();
        //Booking Details
        $eventsignupData = $this->analyticsHandler->getBookingDetails($eventId);
        //Widget Referral
        $this->load->library('GoogleAnalytics');
        $google_analytics = new GoogleAnalytics();
        $data['start_date'] = date('Y-m-d', strtotime('-1 day', strtotime($eventData['0']['cts'])));
        $data['track_urls'] = array('/ticketWidget', 'eventId=' . $eventId, 'rcode=');
        $widgetReferralTrafficResult = $google_analytics->getEventTrafficData($data);
        $widgetReferralTraffic = $this->analyticsHandler->parseWidgetReferralResult($widgetReferralTrafficResult);
        //Pass Data to View
        $data['hideLeftMenu'] = 0;
        $data['eventTitle'] = $eventData['0']['title'];
        $data['content'] = 'traffic_reports_view';
        $data['viewPageName'] = '';
        $data['widgetReferralTraffic'] = $widgetReferralTraffic;
        $data['eventsignupData'] = $eventsignupData;
        $data['pageTitle'] = 'MeraEvents | Event Traffic Effort';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function ticketTransfer($eventId, $eventsignupId)
    {
        $input['eventId'] = $eventId;
        // $eventSettingsInputArray['eventId'] = $eventId;

        $eventSettingsInputArray['eventId'] = $eventId;
        $eventSettingsDataArr = $this->eventHandler->getEventSettings($eventSettingsInputArray);
        $eventsignupArray['eventsignupId'] = $eventsignupId;

        $eventsignupDetails = $this->confirmationHandler->getConfirmationeventsignupDetailData($eventsignupArray);
        if ($eventsignupDetails['status'] && $eventsignupDetails['response']['total'] > 0) {
            $singupData = $eventsignupDetails['response']['eventSignupDetailData'];
            $data['stagedstatus'] = 1;
            $data['stagedstatus'] = $singupData['eventsignupDetails']['stagedstatus'];
        }

        if ($eventSettingsDataArr['status'] && $eventSettingsDataArr['response']['total'] > 0) {
            $eventSettingsResult = $eventSettingsDataArr['response']["eventSettings"][0];
            $data['stagedevent'] = $data['paymentstage'] = 0;
            $data['stagedevent'] = $eventSettingsResult['stagedevent'];
            $data['paymentstage'] = $eventSettingsResult['paymentstage'];
        }

        $input['eventsignupId'] = $eventsignupId;
        $output = $this->reportsHandler->getCustomFieldsData($input);
        if ($output['status'] && $output['response']['total'] > 0) {
            $data['attendeedetailList'] = $output['response']['attendeedetailList'];
            $data['ticketNames'] = $output['response']['ticketNames'];
        } else {
            $data['error'] = $output['response']['messages'];
        }
        //print_r($output);exit;
        $data['eventId'] = $eventId;
        $data['eventsignupId'] = $eventsignupId;
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'ticket_transfer_view';
        $data['jsTopArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/tickettransfer',
            $this->config->item('js_public_path') . 'intlTelInput'
        );
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'intlTelInput',
            $this->config->item('css_public_path') . 'tickettransfer'
        );
        $data['pageTitle'] = 'MeraEvents | Ticket Transfer';

        $this->load->view('templates/dashboard_template', $data);
    }

    public function transactionComment($eventId, $eventsignupId)
    {

        $data['eventId'] = $eventId;
        $data['eventsignupId'] = $eventsignupId;
        $data['hideLeftMenu'] = 0;
        $data['content'] = 'incompleted_comment_view';


        $data['jsTopArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/tickettransfer',
            $this->config->item('js_public_path') . 'intlTelInput'
        );
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'intlTelInput',
            $this->config->item('css_public_path') . 'tickettransfer'
        );
        $data['pageTitle'] = 'Incompleted Transaction Comment';

        $this->load->view('templates/dashboard_template', $data);
    }

    public function eventssummaryreport($user_id = 0)
    {
        $userId = $this->customsession->getUserId();
        if ($user_id > 0) {
            $this->organizerHandler = new Organizer_handler();
            $owner_user_ids = $this->organizerHandler->getSubOwnerUserIds($userId);
            if (!in_array($user_id, $owner_user_ids)) {
                redirect(commonHelperGetPageUrl("user-noaccess", 'NoAccess'), 'refresh');
            }
            $userId = $user_id;
            $data['subUserId'] = $userId;
        }
        $input['userId'] = $userId;
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'eventssummaryreport_view';
        $data['viewPageName'] = "";
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/apitransactions'
        );
        $get_data = $this->input->get();
        $input['type'] = (isset($get_data['type']) && in_array($get_data['type'], array('upcoming', 'past', 'all'))) ? $get_data['type'] : 'upcoming';
        $summaryReportData = $this->reportsHandler->getEventsSummaryReportData($input);
        $data['summaryReportData'] = $summaryReportData;
        if (isset($get_data['download']) && $get_data['download'] == true) {
            ob_end_clean();
            $filename = 'events_summary_report_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            $file = fopen('php://output', 'w');
            if (!empty($summaryReportData['0'])) {
                $header = array("Event Id", "Event Name", "Total Tickets", "Total Sale Amount", "Paid Amount", "Commission Amount", "Remaining Amount");
                fputcsv($file, $header);
                foreach ($summaryReportData['0'] as $eventSale) {
                    $totPaidAmt = $totalCommission = 0;
                    if (!empty($summaryReportData['1'])) {
                        foreach ($summaryReportData['1'] as $eventPayment) {
                            if ($eventPayment['eventid'] == $eventSale['id']) {
                                $totPaidAmt = $eventPayment['paidAmt'];
                                $totalCommission = $eventPayment['commissionAmt'];
                            }
                        }
                    }
                    $saleAmt = ceil($eventSale['saleAmt']);
                    $totalAmtToBePaid = $saleAmt - $totPaidAmt - $totalCommission;
                    $line = array($eventSale['id'], $eventSale['title'], $eventSale['ticketQty'], $saleAmt, $totPaidAmt, $totalCommission, $totalAmtToBePaid);
                    fputcsv($file, $line);
                }
            } else {
                $header = array("No data found, Thank you");
                fputcsv($file, $header);
            }
            fclose($file);
            exit;
        }
        $data['pageTitle'] = 'MeraEvents | Events Summary Report';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function eventsdailyreport($user_id = 0)
    {
        $userId = $this->customsession->getUserId();
        if ($user_id > 0) {
            $this->organizerHandler = new Organizer_handler();
            $owner_user_ids = $this->organizerHandler->getSubOwnerUserIds($userId);
            if (!in_array($user_id, $owner_user_ids)) {
                redirect(commonHelperGetPageUrl("user-noaccess", 'NoAccess'), 'refresh');
            }
            $userId = $user_id;
            $data['subUserId'] = $userId;
        }
        $input['userId'] = $userId;
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'eventsdailyreport_view';
        $data['viewPageName'] = "";
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/apitransactions'
        );
        $get_data = $this->input->get();
        if (isset($get_data['startdate']) && !empty($get_data['startdate'])) {
            $SDt = $get_data['startdate'];
            $SDtExplode = explode("/", $SDt);
            $startdate = $SDtExplode[2] . '-' . $SDtExplode[0] . '-' . $SDtExplode[1] . ' 00:00:00';
            $startdate = allTimeFormats($startdate, 9);
            $input['startdate'] = $startdate;
        } else {
            $input['startdate'] = date('Y-m-d');
        }
        if (isset($get_data['enddate']) && !empty($get_data['enddate'])) {
            $SDt = $get_data['enddate'];
            $SDtExplode = explode("/", $SDt);
            $startdate = $SDtExplode[2] . '-' . $SDtExplode[0] . '-' . $SDtExplode[1] . ' 00:00:00';
            $startdate = allTimeFormats($startdate, 9);
            $input['enddate'] = $startdate;
        } else {
            $input['enddate'] = date('Y-m-d');
        }
        $dailyReportData = $this->reportsHandler->getEventsDailyReportData($input);
        $data['dailyReportData'] = $dailyReportData;
        if (isset($get_data['download']) && $get_data['download'] == true) {
            ob_end_clean();
            $filename = 'events_daily_report_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            $file = fopen('php://output', 'w');
            if (!empty($dailyReportData['0'])) {
                $header = array("Event Id", "Event Name", "Total Tickets", "Total Sale Amount");
                fputcsv($file, $header);
                foreach ($dailyReportData as $eventSale) {
                    $line = array($eventSale['id'], $eventSale['title'], $eventSale['ticketQty'], round($eventSale['saleAmt']));
                    fputcsv($file, $line);
                }
            } else {
                $header = array("No data found, Thank you");
                fputcsv($file, $header);
            }
            fclose($file);
            exit;
        }
        $data['pageTitle'] = 'MeraEvents | Events Daily Report';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function eventsdailydetailreport($user_id = 0)
    {
        $userId = $this->customsession->getUserId();
        if ($user_id > 0) {
            $this->organizerHandler = new Organizer_handler();
            $owner_user_ids = $this->organizerHandler->getSubOwnerUserIds($userId);
            if (!in_array($user_id, $owner_user_ids)) {
                redirect(commonHelperGetPageUrl("user-noaccess", 'NoAccess'), 'refresh');
            }
            $userId = $user_id;
            $data['subUserId'] = $userId;
        }
        $input['userId'] = $userId;
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'eventsdailydetailreport_view';
        $data['viewPageName'] = "";
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/apitransactions'
        );
        $get_data = $this->input->get();
        if (isset($get_data['fromdate']) && !empty($get_data['fromdate'])) {
            $SDt = $get_data['fromdate'];
            $SDtExplode = explode("/", $SDt);
            $startdate = $SDtExplode[2] . '-' . $SDtExplode[0] . '-' . $SDtExplode[1] . ' 00:00:00';
            $startdate = allTimeFormats($startdate, 9);
            $input['fromdate'] = $startdate;
        } else {
            $input['fromdate'] = date('Y-m-d');
        }
        if (isset($get_data['todate']) && !empty($get_data['todate'])) {
            $SDt = $get_data['todate'];
            $SDtExplode = explode("/", $SDt);
            $startdate = $SDtExplode[2] . '-' . $SDtExplode[0] . '-' . $SDtExplode[1] . ' 00:00:00';
            $startdate = allTimeFormats($startdate, 9);
            $input['todate'] = $startdate;
        } else {
            $input['todate'] = date('Y-m-d');
        }
        $page = isset($get_data['page']) ? $get_data['page'] : 1;
        $input['start'] = ($page - 1) * REPORTS_DISPLAY_LIMIT;
        $input['limit'] = REPORTS_DISPLAY_LIMIT;
        $input['download'] = (isset($get_data['download']) && $get_data['download'] == true) ? true : false;
        $dailyReportData = $this->reportsHandler->getEventsDailyDetailReportData($input);
        $attendeeData = $dailyReportData[2];
        $data['totalCount'] = $dailyReportData[0][0]['cnt'];
        $data['dailyReportData'] = $dailyReportData[1];
        $data['attendeeData'] = $attendeeData;
        if (isset($get_data['download']) && $get_data['download'] == true) {
            ob_end_clean();
            $filename = 'events_daily_detail_report_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            $file = fopen('php://output', 'w');
            if (!empty($dailyReportData[1])) {
                $header = array("Event Id", "Event Name", "Reg.No", "Name", "Email", "Mobile", "Quantity", "Amount", "Date");
                fputcsv($file, $header);
                foreach ($dailyReportData[1] as $eventSale) {
                    $line = array($eventSale['eventId'], $eventSale['title'], $eventSale['id'], $attendeeData[$eventSale['id']]['1'], $attendeeData[$eventSale['id']]['2'], $attendeeData[$eventSale['id']]['3'], $eventSale['quantity'], round($eventSale['saleAmt']), allTimeFormats(convertTime($eventSale['signupdate'], $eventSale['timeZone'], true), 11));
                    fputcsv($file, $line);
                }
            } else {
                $header = array("No data found, Thank you");
                fputcsv($file, $header);
            }
            fclose($file);
            exit;
        }
        $data['page'] = $page;
        $data['pageTitle'] = 'MeraEvents | Events Daily Detail Report';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function eventspaymentreport($user_id = 0)
    {
        $userId = $this->customsession->getUserId();
        if ($user_id > 0) {
            $this->organizerHandler = new Organizer_handler();
            $owner_user_ids = $this->organizerHandler->getSubOwnerUserIds($userId);
            if (!in_array($user_id, $owner_user_ids)) {
                redirect(commonHelperGetPageUrl("user-noaccess", 'NoAccess'), 'refresh');
            }
            $userId = $user_id;
            $data['subUserId'] = $userId;
        }
        $input['userId'] = $userId;
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'eventspaymentreport_view';
        $data['viewPageName'] = "";
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/apitransactions'
        );
        $get_data = $this->input->get();
        if (isset($get_data['startdate']) && !empty($get_data['startdate'])) {
            $SDt = $get_data['startdate'];
            $SDtExplode = explode("/", $SDt);
            $startdate = $SDtExplode[2] . '-' . $SDtExplode[0] . '-' . $SDtExplode[1] . ' 00:00:00';
            $startdate = allTimeFormats($startdate, 9);
            $input['startdate'] = $startdate;
        } else {
            $input['startdate'] = date('Y-m-d');
        }
        if (isset($get_data['enddate']) && !empty($get_data['enddate'])) {
            $SDt = $get_data['enddate'];
            $SDtExplode = explode("/", $SDt);
            $startdate = $SDtExplode[2] . '-' . $SDtExplode[0] . '-' . $SDtExplode[1] . ' 00:00:00';
            $startdate = allTimeFormats($startdate, 9);
            $input['enddate'] = $startdate;
        } else {
            $input['enddate'] = date('Y-m-d');
        }
        $paymentReportData = $this->reportsHandler->getEventsPaymentReportData($input);
        $data['paymentReportData'] = $paymentReportData;
        if (isset($get_data['download']) && $get_data['download'] == true) {
            ob_end_clean();
            $filename = 'events_payment_report_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            $file = fopen('php://output', 'w');
            if (!empty($paymentReportData['0'])) {
                $header = array("Event Id", "Event Name", "Paid Amount", "Commission Amount");
                fputcsv($file, $header);
                foreach ($paymentReportData as $eventPayment) {
                    $line = array($eventPayment['id'], $eventPayment['title'], round($eventPayment['paidAmt']), round($eventPayment['commissionAmt']));
                    fputcsv($file, $line);
                }
            } else {
                $header = array("No data found, Thank you");
                fputcsv($file, $header);
            }
            fclose($file);
            exit;
        }
        $data['pageTitle'] = 'MeraEvents | Events Payment Report';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function eventsreconciliationreport($user_id = 0)
    {
        $userId = $this->customsession->getUserId();
        if ($user_id > 0) {
            $this->organizerHandler = new Organizer_handler();
            $owner_user_ids = $this->organizerHandler->getSubOwnerUserIds($userId);
            if (!in_array($user_id, $owner_user_ids)) {
                redirect(commonHelperGetPageUrl("user-noaccess", 'NoAccess'), 'refresh');
            }
            $userId = $user_id;
            $data['subUserId'] = $userId;
        }
        $input['userId'] = $userId;
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'eventsreconciliationreport_view';
        $data['viewPageName'] = "";
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/apitransactions'
        );
        $get_data = $this->input->get();
        if (isset($get_data['startdate']) && !empty($get_data['startdate'])) {
            $SDt = $get_data['startdate'];
            $SDtExplode = explode("/", $SDt);
            $startdate = $SDtExplode[2] . '-' . $SDtExplode[0] . '-' . $SDtExplode[1] . ' 00:00:00';
            $startdate = allTimeFormats($startdate, 9);
            $input['startdate'] = $startdate;
        } else {
            $input['startdate'] = date('Y-m-d');
        }
        if (isset($get_data['enddate']) && !empty($get_data['enddate'])) {
            $SDt = $get_data['enddate'];
            $SDtExplode = explode("/", $SDt);
            $startdate = $SDtExplode[2] . '-' . $SDtExplode[0] . '-' . $SDtExplode[1] . ' 00:00:00';
            $startdate = allTimeFormats($startdate, 9);
            $input['enddate'] = $startdate;
        } else {
            $input['enddate'] = date('Y-m-d');
        }
        $reconciliationReportData = $this->reportsHandler->getEventsReconciliationReportData($input);
        $data['reconciliationReportData'] = $reconciliationReportData;
        if (isset($get_data['download']) && $get_data['download'] == true) {
            ob_end_clean();
            $filename = 'events_reconciliation_report_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            $file = fopen('php://output', 'w');
            if (!empty($reconciliationReportData)) {
                $header = array("Event Id", "Event Name", "Total Tickets", "Total Sale Amount", "Paid Amount", "Commission Amount");
                fputcsv($file, $header);
                foreach ($reconciliationReportData as $eventdata) {
                    $saleAmt = isset($eventdata['saleAmt']) ? round($eventdata['saleAmt']) : 0;
                    $ticketQty = isset($eventdata['ticketQty']) ? round($eventdata['ticketQty']) : 0;
                    $paidAmt = isset($eventdata['paidAmt']) ? round($eventdata['paidAmt']) : 0;
                    $commissionAmt = isset($eventdata['commissionAmt']) ? round($eventdata['commissionAmt']) : 0;
                    $line = array($eventdata['id'], $eventdata['title'], $ticketQty, $saleAmt, $paidAmt, $commissionAmt);
                    fputcsv($file, $line);
                }
            } else {
                $header = array("No data found, Thank you");
                fputcsv($file, $header);
            }
            fclose($file);
            exit;
        }
        $data['pageTitle'] = 'MeraEvents | Events Reconciliation Report';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function subusers()
    {
        $userId = $this->customsession->getUserId();
        $this->organizerHandler = new Organizer_handler();
        $sub_user_ids = $this->organizerHandler->getSubUserIds($userId);
        if (!empty($sub_user_ids)) {
            //Get Owner Details
            $this->load->model('User_model');
            $this->User_model->resetVariable();
            $selectInput['id'] = $this->User_model->id;
            $selectInput['name'] = $this->User_model->name;
            $selectInput['email'] = $this->User_model->email;
            $selectInput['company'] = $this->User_model->company;
            $whereDetails['id'] = array_keys($sub_user_ids);
            $this->User_model->setSelect($selectInput);
            $this->User_model->setWhereIns($whereDetails);
            $sub_user_details = $this->User_model->get();
            //Set Data to Output
            $data['sub_user_details'] = $sub_user_details;
        }
        $data['sub_user_ids'] = $sub_user_ids;
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'subusers_view';
        $data['viewPageName'] = "";
        $data['cssArray'] = array();
        $data['jsArray'] = array();
        $data['pageTitle'] = 'MeraEvents | Sub Users';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function subuseradd()
    {
        if ($this->input->post('submit')) {
            $inputArray = $this->input->post();
            $this->load->model('User_model');
            $this->User_model->resetVariable();
            $selectInput['id'] = $this->User_model->id;
            $whereDetails['email'] = $inputArray['email'];
            $whereDetails['status'] = 1;
            $this->User_model->setSelect($selectInput);
            $this->User_model->setWhereIns($whereDetails);
            $sub_user_details = $this->User_model->get();
            if (!empty($sub_user_details)) {
                $userId = $this->customsession->getUserId();
                if ($userId != $sub_user_details['0']['id']) {
                    //Check Sub User Exists
                    $this->load->model('Organizersubuser_model');
                    $this->Organizersubuser_model->resetVariable();
                    $select['id'] = $this->Organizersubuser_model->id;
                    $where[$this->Organizersubuser_model->userid] = $userId;
                    $where[$this->Organizersubuser_model->subuserid] = $sub_user_details['0']['id'];
                    $this->Organizersubuser_model->setSelect($select);
                    $this->Organizersubuser_model->setWhere($where);
                    $sub_user_exists = $this->Organizersubuser_model->get();
                    if (!empty($sub_user_exists)) {
                        $this->Organizersubuser_model->resetVariable();
                        $whereUpdate[$this->Organizersubuser_model->id] = $sub_user_exists['0']['id'];
                        $updateArray[$this->Organizersubuser_model->status] = 1;
                        $updateArray[$this->Organizersubuser_model->deleted] = 0;
                        $this->Organizersubuser_model->setWhere($whereUpdate);
                        $this->Organizersubuser_model->setInsertUpdateData($updateArray);
                        $this->Organizersubuser_model->update_data();
                    } else {
                        $this->Organizersubuser_model->resetVariable();
                        $inputdata[$this->Organizersubuser_model->userid] = $userId;
                        $inputdata[$this->Organizersubuser_model->subuserid] = $sub_user_details['0']['id'];
                        $inputdata[$this->Organizersubuser_model->status] = 1;
                        $inputdata[$this->Organizersubuser_model->deleted] = 0;
                        $this->Organizersubuser_model->setInsertUpdateData($inputdata);
                        $this->Organizersubuser_model->insert_data();
                    }
                    $this->customsession->setData('subUserAdd', 'Sub User Added Successfully.');
                    redirect(commonHelperGetPageUrl('dashboard-sub-users'));
                } else {
                    $data['status'] = FALSE;
                    $data['message'] = 'Given your email as sub user';
                    $this->customsession->setData('subUserAdd', 'No user found with given email');
                }
            } else {
                $data['status'] = FALSE;
                $data['message'] = 'No user found with given email';
                $this->customsession->setData('subUserAdd', 'No user found with given email');
            }
        }
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'subuseradd_view';
        $data['viewPageName'] = "";
        $data['cssArray'] = array();
        $data['jsArray'] = array();
        $data['pageTitle'] = 'MeraEvents | Add Sub User';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function subuserreports()
    {
        $userId = $this->customsession->getUserId();
        $this->organizerHandler = new Organizer_handler();
        $owner_user_ids = $this->organizerHandler->getSubOwnerUserIds($userId);
        //Get Owner Details
        $this->load->model('User_model');
        $this->User_model->resetVariable();
        $selectInput['id'] = $this->User_model->id;
        $selectInput['name'] = $this->User_model->name;
        $selectInput['company'] = $this->User_model->company;
        $whereDetails['id'] = $owner_user_ids;
        $this->User_model->setSelect($selectInput);
        $this->User_model->setWhereIns($whereDetails);
        $owner_details = $this->User_model->get();
        //Set Data to Output
        $data['owner_details'] = $owner_details;
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'subuserreports_view';
        $data['viewPageName'] = "";
        $data['cssArray'] = array();
        $data['jsArray'] = array();
        $data['pageTitle'] = 'MeraEvents | Sub User Report';
        $this->load->view('templates/dashboard_template', $data);
    }

}
