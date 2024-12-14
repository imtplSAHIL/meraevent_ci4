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
 * @Created     10/18/2022
 * @Last Modified On  10/18/2022
 * @Last Modified By  Venkat
 */
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/confirmation_handler.php');
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once (APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/payment_handler.php');

class Webhookrazorpay extends CI_Controller {

    var $commonHandler;
    var $confirmationHandler;
    var $eventsignupHandler;
    var $eventHandler;

    public function __construct() {
        parent::__construct();
        $this->commonHandler = new Common_handler();
        $this->confirmationHandler = new Confirmation_handler();
        $this->eventsignupHandler = new Eventsignup_handler();
        $this->eventHandler = new Event_handler();
        $this->paymentHandler = new Payment_handler();
    }

    public function verify_payment() {
       
        //wxwJ5PgK93h3lnqR4CHWvdzP9v5LiAx4
        $headers = $this->input->request_headers();
        $this->commonHandler->log_payment_message("\n\n ================================ \n");
        $this->commonHandler->log_payment_message("\n ".$this->commonHandler->get_client_ip()."\n The payment time is: ".date('Y/m/d H:i:s'));

        $body = @file_get_contents('php://input');
        $this->commonHandler->log_payment_message("\n Below is the json input received \n");
        $this->commonHandler->log_payment_message(print_r($body, TRUE));

        $reqBody = json_decode($body, true);

        // $reqBody['payload']['payment']['entity'] = '1833760';
        if (!empty($reqBody['payload']['payment']['entity']))
        {
            $payment_array = $reqBody['payload']['payment']['entity'];
            $this->commonHandler->log_payment_message(print_r($payment_array, TRUE));

            //==== Testing purpose ====//
            // $payment_array['notes']['merchant_order_id'] = 1833760;
            // $payment_array['email'] = 'venkata.ummadi@etggs.digital';
            // $payment_array['id'] = 'pay_KVCwSBeXBQTsOb';
            // $payment_array['status'] = 'captured';
            
            $this->commonHandler->log_payment_message("\n Payment info block \n");
            //==== Get payment details from the database  =====//
            $input['eventsignupId'] = $payment_array['notes']['merchant_order_id'];
            $event_signup_details = $this->eventsignupHandler->getEventsignupDetails($input);
            $event_signup_details = $event_signup_details['response']['eventSignupList'][0];
            
            if (($event_signup_details['paymentstatus'] == 'NotVerified' && $payment_array['status'] == 'captured'))
            {
                $update_array = array();
                $update_array['transactionstatus'] = 'success';
                $update_array['paymentstatus'] = 'Captured';
                $update_array['paymenttransactionid'] = $payment_array['id'];
                $update_array['eventsignupId'] = $payment_array['notes']['merchant_order_id'];

                //==== Make the transaction success ===//
                $this->eventsignupHandler->updatePaymentDetails($update_array);

                $this->commonHandler->log_payment_message("\n Updating payment details \n");
                $this->commonHandler->log_payment_message(print_r($update_array, TRUE));

                //==== Send email to the customer ====//
                $inputArray = array();
                $inputArray['userId'] = '';
                $inputArray['userEmail'] = $payment_array['email'];
                $inputArray['eventsignupId'] = $payment_array['notes']['merchant_order_id'];
                $inputArray['isOrganizer'] = false;

                $this->confirmationHandler->resendTransactionsuccessEmail($inputArray);

                $this->commonHandler->log_payment_message("\n Sending email input data \n");
                $this->commonHandler->log_payment_message(print_r($inputArray, TRUE));
            }
        }

        http_response_code(200);


            // Array
            // (
            //     [entity] => event
            //     [account_id] => acc_5wAO2ksX2o2vlN
            //     [event] => payment.captured
            //     [contains] => Array
            //         (
            //             [0] => payment
            //         )

            //     [payload] => Array
            //         (
            //             [payment] => Array
            //                 (
            //                     [entity] => Array
            //                         (
            //                             [id] => pay_KVCwSBeXBQTsOb
            //                             [entity] => payment
            //                             [amount] => 144000
            //                             [currency] => INR
            //                             [status] => captured
            //                             [order_id] => order_KVCw0HWJMXPJKb
            //                             [invoice_id] => 
            //                             [international] => 
            //                             [method] => upi
            //                             [amount_refunded] => 0
            //                             [refund_status] => 
            //                             [captured] => 1
            //                             [description] => ML Workshop 
            //                             [card_id] => 
            //                             [bank] => 
            //                             [wallet] => 
            //                             [vpa] => pandit.avani123@oksbi
            //                             [email] => pandit.avani123@gmail.com
            //                             [contact] => +918435003395
            //                             [notes] => Array
            //                                 (
            //                                     [address] => 
            //                                     [merchant_order_id] => 1833760
            //                                 )

            //                             [fee] => 1020
            //                             [tax] => 156
            //                             [error_code] => 
            //                             [error_description] => 
            //                             [error_source] => 
            //                             [error_step] => 
            //                             [error_reason] => 
            //                             [acquirer_data] => Array
            //                                 (
            //                                     [rrn] => 229197095560
            //                                 )

            //                             [created_at] => 1666090254
            //                             [base_amount] => 144000
            //                         )

            //                 )

            //         )

            //     [created_at] => 1666090314
            // )
    }
}

?>
