<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


require_once(APPPATH . 'handlers/common_handler.php');

class Razorpay_hook extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->commonHandler = new Common_handler();

    }

    public function verify()
    {
        $headers = $this->input->request_headers();
        $this->commonHandler->log_payment_message("\n\n ================================ \n");
        $this->commonHandler->log_payment_message("\n ".$this->commonHandler->get_client_ip()."\n The payment time is: ".date('Y/m/d H:i:s'));

        // $myfile = fopen($_SERVER['DOCUMENT_ROOT'] . "/content/razorpay_response.txt", "a");
        $signature = isset($headers['X-Razorpay-Signature']) ? $headers['X-Razorpay-Signature'] : '';
        $this->commonHandler->log_payment_message("\n ".$this->commonHandler->get_client_ip()."\n The signature is : ".$signature );

        $body = @file_get_contents('php://input');
        $reqBody = json_decode($body, true);
        $this->commonHandler->log_payment_message("\n Below is the json input received \n");
        $this->commonHandler->log_payment_message(print_r($body, TRUE));

        $triggeredEventType = $reqBody['event'];
        if ($triggeredEventType == 'payment.authorized' || $triggeredEventType == 'payment.captured') {
            
            $payLoad = $reqBody['payload'];
            $booking_id = $payLoad['payment']['entity']['notes']['merchant_order_id'];
            
            $payment_array = $payLoad['payment']['entity'];
            $this->commonHandler->log_payment_message(print_r($payment_array, TRUE));
            
            //Get Signup Details
            $ressqlEs = $this->db->query("SELECT id, eventid, transactionstatus FROM eventsignup WHERE id = " . $booking_id)->result_array();
            //Check Status
            $this->commonHandler->log_payment_message("\n Payment info block \n");
            if ($ressqlEs[0]['transactionstatus'] == 'success') {
                $this->commonHandler->log_payment_message("\n" . date('Y-m-d H:i:s') . "- Already Success Status");
            } else {
                $this->commonHandler->log_payment_message("\n" . date('Y-m-d H:i:s') . "- Make Success Started");

                $pg_result = $this->db->query("SELECT id, merchantid, hashkey FROM paymentgateway WHERE name = 'razorpay'");
                if (!empty($pg_result)) {
                    $pg_data = $pg_result->result_array();
                    $rpaykeyid = $pg_data['0']['merchantid'];
                    $rpaykeysecret = $pg_data['0']['hashkey'];



                    $razorpayAccessKeys = array('rpaykeyid' => $rpaykeyid, 'rpaykeysecret' => $rpaykeysecret);
                    $this->load->library('razorpay/razorpay.php', $razorpayAccessKeys);
                    if(!empty($signature))
                        $rpVerifyPayment = $this->razorpay->verifyWebhookSignature($body, $signature, "Mera@123");
                    else
                        $rpVerifyPayment = true;

                    if ($rpVerifyPayment) {
                        $ebsReturnArray['trpaymentstatus'] = "captured";
                        $ebsReturnArray['MerchantRefNo'] = $booking_id;
                        $ebsReturnArray['TransactionID'] = $payLoad['payment']['entity']['order_id'];
                        $ebsReturnArray['ResponseCode'] = 0;
                        $ebsReturnArray['PaymentStatus'] = "captured";
                        $ebsReturnArray['Amount'] = $payLoad['payment']['entity']['amount'];
                        $ebsReturnArray['mode'] = 'razorpay';
                        $resOrderLog = $this->db->query("SELECT id, userid, orderid, data FROM orderlog WHERE eventsignup = " . $booking_id)->result_array();
                        $orderId = $resOrderLog[0]['orderid'];
                        $oldOrderLogData = unserialize($resOrderLog[0]['data']);
                        $oldOrderLogData['paymentResponse'] = $ebsReturnArray;
                        $totalSaleQuantity = $oldOrderLogData['calculationDetails']['totalTicketQuantity'];
                        $eventId = $oldOrderLogData['eventid'];
                        $updatedSessData = serialize($oldOrderLogData);
                        $orderLogUpdateInput['condition']['orderId'] = $orderId;
                        $orderLogUpdateInput['condition']['eventSignupId'] = $booking_id;
                        $orderLogUpdateInput['update']['data'] = $updatedSessData;
                        $this->orderlogHandler = new Orderlog_handler();
                        $orderLogUpdateResponse = $this->orderlogHandler->orderLogUpdate($orderLogUpdateInput);
                        if (!$orderLogUpdateResponse['status']) {
                            $this->commonHandler->log_payment_message("\n" . date('Y-m-d H:i:s') . "-". ERROR_ORDERLOG_UPDATED);
                            return false;
                        }
                        // Inserting the gateway response starts here
                        $gatewayInsert['eventSignupId'] = $booking_id;
                        $gatewayInsert['paymentId'] = 0;
                        $gatewayInsert['transactionId'] = $payLoad['payment']['entity']['id'];
                        $gatewayInsert['statusCode'] = "200";
                        $gatewayInsert['statusMessage'] = $payLoad['payment']['entity']['status'];
                        $this->eventsignupHandler = new Eventsignup_handler();
                        $this->eventsignupHandler->saveGatewayPaymentResponse($gatewayInsert);
                        // Inserting the gateway response ends here
                        if (in_array($eventId, array_keys((array) (json_decode(EVENT_PROMOCODES))))) {
                            $inputEPromo['eventid'] = $eventId;
                            $inputEPromo['quantity'] = $totalSaleQuantity;
                            $inputEPromo['eventsignupid'] = $booking_id;
                            $this->updateEventPromoCodes($inputEPromo);
                        }
                        $oldOrderLogData['eventSignupId'] = $booking_id;
                        require_once(APPPATH . 'handlers/booking_handler.php');
                        $this->bookingHandler = new Booking_handler();
                        $oldOrderLogData['s2sUserId'] = $resOrderLog[0]['userid'];
                        $this->bookingHandler->updateTicketSoldCount($oldOrderLogData, $orderId);
                        $this->commonHandler->log_payment_message("\n" . date('Y-m-d H:i:s') . "-". SUCCESS_BOOKING);

                    }
                    else{
                        $this->commonHandler->log_payment_message("\n" . date('Y-m-d H:i:s') . "- Razorpay signature verification failed");
                    }
                }
            }
        }
        fclose($myfile);
    }

}
