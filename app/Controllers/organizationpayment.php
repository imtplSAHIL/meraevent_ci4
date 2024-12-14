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
 * @Last Modified On  03-08-2015
 * @Last Modified By  Gautam
 */
require_once(APPPATH . 'handlers/eventsignup_handler.php');
require_once(APPPATH . 'handlers/paymentgateway_handler.php');
require_once(APPPATH . 'handlers/booking_handler.php');
require_once(APPPATH . 'handlers/config_handler.php');
require_once(APPPATH . 'handlers/organization_handler.php');

class Organizationpayment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;
    }

    public function amazonpayPrepare()
    {
        $postVar = $this->input->post();

        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $amazonpayMerchantId = $gatewayArr['merchantid'];
                $amazonpayMerchantSecretKey = $gatewayArr['hashkey'];
                $amazonpayAcc = unserialize($gatewayArr['extraparams']);
                $amazonpayAccessKey = $amazonpayAcc['access_key'];
                $amazonpayBaseurl = $gatewayArr['posturl'];
                $amazonpaySandbox = $gatewayArr['environment'] == 'TEST' ? true : false;
            }
        }

        require_once(APPPATH . 'libraries/AmazonPay/PWAINBackendSDK.php');
        $config = array('merchant_id' => $amazonpayMerchantId,
            'access_key' => $amazonpayAccessKey,
            'secret_key' => $amazonpayMerchantSecretKey,
            'base_url' => $amazonpayBaseurl);

        $client = new PWAINBackendSDK($config);
        $amazonpayData = array();
        $amazonpayData['sellerOrderId'] = $postVar['eventSignupId'];

        $txtTxnAmount = $postVar['orderTotalAmount'];

        $amazonpayData['orderTotalAmount'] = $txtTxnAmount;
        $amazonpayData['orderTotalCurrencyCode'] = 'INR';
        $amazonpayData['sellerStoreName'] = "MeraEvents";
        $customInformation['paymentGatewayKey'] = $paymentGatewayKey;
        $customInformation['orderId'] = $postVar['eventSignupId'];
        $amazonpayData['customInformation'] = json_encode($customInformation);
        $returnUrl = commonHelperGetPageUrl('organization_amazonpayProcessingPage');
        if ($amazonpaySandbox) {
            $amazonpayData['isSandbox'] = "true";
        }
        $redirectUrl = $client->getProcessPaymentUrl($amazonpayData, $returnUrl);
        header("Location: " . $redirectUrl, true, 301);
    }

    public function amazonpayProcessingPage()
    {
        $amazonpayRawResponse = $_GET;
        $amazonpayRawResponse['customInformation'] = json_decode($amazonpayRawResponse['customInformation'], true);
        $eventsignupHandler = new Eventsignup_handler();
        $eventSignupInput['eventsignupId'] = $amazonpayRawResponse['sellerOrderId'];
        $eventSignupDataList = $eventsignupHandler->getEventsignupDetails($eventSignupInput);
        if (!$eventSignupDataList['status']) {
            redirect('/');
        }
        $paymentGatewayKey = $amazonpayRawResponse['customInformation']['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
            $bookingHandler = new Booking_handler();
            $gatewayArr = $bookingHandler->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $amazonpayMerchantId = $gatewayArr['merchantid'];
                $amazonpayMerchantSecretKey = $gatewayArr['hashkey'];
                $amazonpayAcc = unserialize($gatewayArr['extraparams']);
                $amazonpayAccessKey = $amazonpayAcc['access_key'];
                $amazonpayBaseurl = $gatewayArr['posturl'];
            }
        }
        $eventSignupData = $eventSignupDataList['response']['eventSignupList']['0'];
        $eventSignupId = $eventSignupData['id'];

        require_once(APPPATH . 'libraries/AmazonPay/PWAINBackendSDK.php');
        $config = array('merchant_id' => $amazonpayMerchantId,
            'access_key' => $amazonpayAccessKey,
            'secret_key' => $amazonpayMerchantSecretKey,
            'base_url' => $amazonpayBaseurl);

        $client = new PWAINBackendSDK($config);
        $amazonpayResponse = $client->verifySignature($amazonpayRawResponse);
        $isSignatureValid = $amazonpayResponse ? 'true' : 'false';

        if (!$isSignatureValid) {
            redirect('/');
        }
        if ((float) $eventSignupData['totalamount'] != $amazonpayRawResponse['orderTotalAmount']) {
            redirect('/');
        }
        $paymentStatus = $amazonpayRawResponse['reasonCode'];
        if ($paymentStatus == 1) {
            
        } else {
            redirect('/');
        }
        /* If the transaction is un successful from amazonpay side */
        if ($amazonpayRawResponse['description'] != "Txn Success") {
            redirect('/');
        }

        /* Inserting the gateway response starts here */
        $gatewayInsert['eventSignupId'] = $eventSignupId;
        $gatewayInsert['paymentId'] = $amazonpayRawResponse['amazonOrderId'];
        $gatewayInsert['transactionId'] = $amazonpayRawResponse['amazonOrderId'];
        $gatewayInsert['statusCode'] = $amazonpayRawResponse['reasonCode'];
        $gatewayInsert['statusMessage'] = $amazonpayRawResponse['description'];
        $eventsignupHandler->saveGatewayPaymentResponse($gatewayInsert);
        /* Inserting the gateway response ends here */

        $eventInfo['orderId'] = $eventSignupId;
        $this->organizationHandler = new organization_handler();
        $updateEventSignup = $this->organizationHandler->EventSignupUpdate($eventInfo);

        if ($updateEventSignup) {
            $userdata = $this->organizationHandler->userData($eventSignupId);
            $this->organizationHandler->sendConfirmationEmail($userdata);
        }

        $successUrl = commonHelperGetPageUrl('membership_confirmation') . '?id=' . $eventSignupId;
        header("Location: " . $successUrl);
        exit;
    }

    /* Intermediate page for Razorpay to check the order,signup values */

    public function razorpayProcessingPage()
    {
        $getVar = $this->input->get();
        $postVar = $this->input->post();
        $eventSignupId = $getVar['eventSignup'];
        $rpayid = $postVar['rpayid'];
        $rsignature = $postVar['rsignature'];
        $paymentGatewayKey = $getVar['paymentGatewayKey'];
        $gatewayData = array();
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $gatewayData = $gatewayArr;
            }
        }
        $rpaykeyid = $gatewayData['merchantid'];
        $rpaykeysecret = $gatewayData['hashkey'];
        $razorpayAccessKeys = array('rpaykeyid' => $rpaykeyid, 'rpaykeysecret' => $rpaykeysecret);
        $this->load->library('razorpay/razorpay.php', $razorpayAccessKeys);
        $rpVerifyTr['rsignature'] = $rsignature;
        $rpVerifyTr['rpayid'] = $rpayid;
        $rpVerifyPayment = $this->razorpay->verifyPaymentSignature($rpVerifyTr);
        if ($rpVerifyPayment) {

            $rpayidDetails = json_decode($this->razorpay->fetch($rpVerifyTr['rpayid']), true);

            $rpayAmt = ($rpayidDetails['amount']);
            $rpayOrderID = $rpayidDetails['notes']['merchant_order_id'];
            $eventsignupHandler = new Eventsignup_handler();
            $eventSignupInput['eventsignupId'] = $rpayOrderID;
            $eventSignupDataList = $eventsignupHandler->getEventsignupDetails($eventSignupInput);
            $eventSignupData = $eventSignupDataList['response']['eventSignupList']['0'];
            $totalPurchaseAmount = $eventSignupData['totalamount'] * 100;
            if (($totalPurchaseAmount == $rpayAmt) && ($eventSignupId == $rpayOrderID)) {
                /* Inserting the gateway response starts here */
                $gatewayInsert['eventSignupId'] = $eventSignupId;
                $gatewayInsert['paymentId'] = 0;
                $gatewayInsert['transactionId'] = $rpayid;
                $gatewayInsert['statusCode'] = "200";
                $gatewayInsert['statusMessage'] = $rpayidDetails['status'];
                $eventsignupHandler->saveGatewayPaymentResponse($gatewayInsert);
                /* Inserting the gateway response ends here */

                $eventInfo['orderId'] = $eventSignupId;
                $this->organizationHandler = new organization_handler();
                $updateEventSignup = $this->organizationHandler->EventSignupUpdate($eventInfo);

                if ($updateEventSignup) {
                    $userdata = $this->organizationHandler->userData($eventSignupId);
                    $this->organizationHandler->sendConfirmationEmail($userdata);
                }

                $successUrl = commonHelperGetPageUrl('membership_confirmation') . '?id=' . $eventSignupId;
                header("Location: " . $successUrl);
                exit;
            }
        }
        redirect('/');
    }

    public function getPaymentgatewayKeys($paymentGatewayKey)
    {
        $gatewayInput['gatewayId'] = $paymentGatewayKey;
        $paymentGatewayHandler = new Paymentgateway_handler();
        $gatewayData = $paymentGatewayHandler->getPaymentgatewayList($gatewayInput);
        if ($gatewayData['status']) {
            $gatewayArr = $gatewayData['response']['paymentgatewayList'][$paymentGatewayKey];
            if ($gatewayArr['hashkey'] != '' && $gatewayArr['merchantid'] != '') {
                return $gatewayArr;
            } elseif ($gatewayArr['name'] == 'paypal') {
                return $gatewayArr;
            } elseif ($gatewayArr['name'] == 'paypalinr') {
                return $gatewayArr;
            }
        }
        return array();
    }

    public function ebsPrepare()
    {
        $data = array();
        $ebsSecretKey = $this->config->item('ebs_secret_key');
        $data['account_id'] = $accountId = $this->config->item('account_id');
        $data['mode'] = $mode = $this->config->item('mode');
        $postVar = $this->input->post();

        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $ebsSecretKey = $gatewayArr['hashkey'];
                $data['account_id'] = $accountId = $gatewayArr['merchantid'];
            }
        }
        /* Getting the payment gateway details from database ends here */

        $eventSignupId = $postVar['eventSignupId'];
        $txtTxnAmount = $data['txtTxnAmount'] = $postVar['orderTotalAmount'];

        $data['name'] = $postVar['paymentName'];
        $data['email'] = $postVar['paymentEmail'];
        $data['phone'] = $postVar['paymentMobile'];
        $data['city'] = '';
        $data['state'] = '';
        $data['address'] = '';
        $data['pincode'] = '';

        $data['eventTitle'] = $postVar['eventTitle'];
        $txtCustomerID = $data['txtCustomerID'] = $eventSignupId;

        $data['returnUrl'] = commonHelperGetPageUrl('organization_ebsProcessingPage') . "?eventSignup=$eventSignupId&paymentGatewayKey=$paymentGatewayKey";
        $string = $ebsSecretKey . "|" . $accountId . "|" . $txtTxnAmount . "|" . $txtCustomerID . "|" . html_entity_decode($data['returnUrl']) . "|" . $mode;
        $data['secureHash'] = md5($string);
        $data['pageName'] = 'Ebs';

        $this->load->view('payment/ebs_prepare', $data);
    }

    /* Intermediate page for EBS to check the order,signup and checksum values */

    public function ebsProcessingPage()
    {
        $getVar = $this->input->get();
        $eventSignupId = $getVar['MerchantRefNo'];
        $eventsignupHandler = new Eventsignup_handler();
        $eventSignupInput['eventsignupId'] = $eventSignupId;
        $eventSignupDataList = $eventsignupHandler->getEventsignupDetails($eventSignupInput);
        $eventSignupData = $eventSignupDataList['response']['eventSignupList']['0'];
        $totalPurchaseAmount = $eventSignupData['totalamount'];
        if (strcmp($getVar['ResponseCode'], 0) == 0 && $totalPurchaseAmount == $getVar['Amount'] && $getVar['ResponseMessage'] == "Transaction Successful") {
            /* Inserting the gateway response starts here */
            $gatewayInsert['eventSignupId'] = $eventSignupId;
            $gatewayInsert['paymentId'] = 0;
            $gatewayInsert['transactionId'] = $getVar['PaymentID'];
            $gatewayInsert['statusCode'] = "200";
            $gatewayInsert['statusMessage'] = $getVar['ResponseMessage'];
            $eventsignupHandler->saveGatewayPaymentResponse($gatewayInsert);
            /* Inserting the gateway response ends here */

            $eventInfo['orderId'] = $eventSignupId;
            $this->organizationHandler = new organization_handler();
            $updateEventSignup = $this->organizationHandler->EventSignupUpdate($eventInfo);

            if ($updateEventSignup) {
                $userdata = $this->organizationHandler->userData($eventSignupId);
                $this->organizationHandler->sendConfirmationEmail($userdata);
            }

            $successUrl = commonHelperGetPageUrl('membership_confirmation') . '?id=' . $eventSignupId;
            header("Location: " . $successUrl);
            exit;
        }
        redirect('/');
    }

    public function paypalPrepare()
    {
        $postVar = $this->input->post();
        /* Getting the payment gateway details from database starts here */
        $paymentGatewayKey = $postVar['paymentGatewayKey'];
        $gatewayData = $data = array();
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);
            if (count($gatewayArr) > 0) {
                $gatewayData = $gatewayArr;
            }
        }
        $gatwayCredentials = unserialize($gatewayData['extraparams']);
        $gatewayName = $gatewayData['functionname'];
        $gatewayMode = $gatewayData['environment'];
        $merchantId = $gatewayData['merchantid'];
        /* Getting the payment gateway details from database ends here */

        // Getting order Log data starts here
        $eventSignupId = $postVar['eventSignupId'];
        $PayPalReturnURL = commonHelperGetPageUrl('organization_paypalProcessingPage') . "?eventSignup=" . $eventSignupId . "&paymentGatewayKey=" . $paymentGatewayKey;

        /* Converting the amount to USD other than USD payments since paypal not supports some of currency codes */
        if ($gatewayName == 'paypal') {
            if ($currencyCode != 'USD') {
                $txtTxnAmount = $orderLogCalculationData['convertedAmount'];
            } else {
                $txtTxnAmount = $txtTxnAmount;
            }
        } elseif ($gatewayName == 'paypalinr') {
            $txtTxnAmount = $txtTxnAmount;
        }


        if (!is_numeric($txtTxnAmount)) {
            $errorMessage = "Something is wrong with the transaction amount. Please try again.";
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = $errorMessage;
            $output['redirectUrl'] = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefieldsErrorPage);
            echo json_encode($output);
            exit;
        }

        //PayPal Credentials for Library
        $paypalAccessKeys = array(
            'PayPalApiClientId' => $gatwayCredentials['PayPalApiClientId'],
            'PayPalApiSecretKey' => $gatwayCredentials['PayPalApiSecretKey'],
            'mode' => $gatewayMode,
            'merchantId' => $merchantId
        );

        $this->load->library('paypal/paypal.php', $paypalAccessKeys);

        //Get profile experience id from config table, if does not exist create and add to config table
        $configHandler = new config_handler();
        $cfInputs['key'] = 'paypalProfileExperience';
        $cfInputs['sourcecriteria'] = $gatewayMode;
        $profileExperienceRes = $configHandler->getConfigDetails($cfInputs);
        if ($profileExperienceRes['status'] == TRUE) {
            $createOrderInput['profileExperienceId'] = $profileExperienceRes['response']['configData'][0];
        } else {
            $paypalExperienceRes = $this->paypal->getProfileExperience();
            if ($paypalExperienceRes['status'] == FALSE) {
                $output = array();
                $output['status'] = FALSE;
                $output['message'] = SOMETHING_WENT_WRONG;
                echo json_encode($output);
                exit;
            }

            $configData['key'] = 'paypalProfileExperience';
            $configData['sourcecriteria'] = $gatewayMode;
            $configData['value'] = json_encode(array($paypalExperienceRes['response']));
            $insertRes = $configHandler->create($configData);
            if ($insertRes['status'] == FALSE) {
                $output = array();
                $output['status'] = FALSE;
                $output['message'] = SOMETHING_WENT_WRONG;
                echo json_encode($output);
                exit;
            }
            $createOrderInput['profileExperienceId'] = $paypalExperienceRes['response'];
        }

        $userDetails = explode('@@', $orderLogCalculationData['addressStr']);
        $createOrderInput['customerName'] = $userDetails[0];
        $createOrderInput['customerEmail'] = $userDetails[1];
        $createOrderInput['customerPhone'] = $userDetails[2];
        $createOrderInput['customerCity'] = ($userDetails[5] != '') ? $userDetails[5] : $userDetails[3];
        $createOrderInput['customerState'] = ($userDetails[4] != '') ? $userDetails[4] : $userDetails[3];
        $tempAddress = '';
        if ($createOrderInput['customerCity'] != '') {
            $tempAddress .= $createOrderInput['customerCity'] . ',';
        }
        if ($createOrderInput['customerState'] != '') {
            $tempAddress .= $createOrderInput['customerState'];
        }
        $createOrderInput['customerAddress'] = ($userDetails[3]) ? $userDetails[3] : $tempAddress;
        $createOrderInput['customerPincode'] = ($userDetails[6]) ? $userDetails[6] : '500081';

        $createOrderInput['eventTitle'] = $postVar['eventTitle'];
        $createOrderInput['eventId'] = $EventId;
        $createOrderInput['amount'] = $txtTxnAmount;
        if ($gatewayName == 'paypal') {
            $createOrderInput['currency'] = 'USD';
        } else {
            $createOrderInput['currency'] = $currencyCode;
        }

        $createOrderInput['receipt'] = $oldOrderLogData['eventsignup'];
        $createOrderInput['userId'] = $oldOrderLogData['userid'];
        $createOrderInput['orderId'] = $oldOrderLogData['orderid'];
        $createOrderInput['returnUrl'] = $PayPalReturnURL;
        $createOrderInput['cancelUrl'] = $PayPalReturnURL;

        $paymentRes = $this->paypal->createPayment($createOrderInput);
        if ($paymentRes['status'] == FALSE) {
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = $paymentRes['message'];
            $output['redirectUrl'] = site_url();
            echo json_encode($output);
            exit;
        }

        $paymentDetails = $paymentRes['response'];
        if ($paymentDetails['state'] != 'created') {
            $output = array();
            $output['status'] = FALSE;
            $output['message'] = 'Something is wrong with the transaction amount. Please try again.';
            $output['redirectUrl'] = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefieldsErrorPage);
            echo json_encode($output);
            exit;
        }
        $output = array(
            'status' => TRUE,
            'id' => $paymentDetails['id']
        );
        echo json_encode($output);
        exit;
    }

    /* Intermediate page for PAYPAL to update the orderlog data */

    public function paypalProcessingPage()
    {
        $getVar = $this->input->get();

        $samepage = $getVar['samepage'];
        $nobrand = $getVar['nobrand'];
        $orderId = $getVar['orderId'];
        $themefields = '';
        if (isset($getVar['themefields']) && $getVar['themefields'] != '') {
            $themefields = $getVar['themefields'];
            $themefields = str_replace('----', '&', $themefields);
            $themefields = $themefields . '&tb=payment';
        }

        $redirectUrl = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields);

        if (!isset($getVar['paymentId'])) {
            $this->customsession->setData('booking_message', 'Something went wrong, Please try again!');
            redirect($redirectUrl);
        }

        //Loading Paypal Library
        $paymentGatewayKey = $getVar['paymentGatewayKey'];
        $gatewayData = $data = array();
        if ($paymentGatewayKey > 0) {
            $gatewayArr = $this->getPaymentgatewayKeys($paymentGatewayKey);

            if (count($gatewayArr) > 0) {
                $gatewayData = $gatewayArr;
            }
        }
        $gatwayCredentials = unserialize($gatewayData['extraparams']);
        $gatewayMode = $gatewayData['environment'];

        $paypalAccessKeys = array(
            'PayPalApiClientId' => $gatwayCredentials['PayPalApiClientId'],
            'PayPalApiSecretKey' => $gatwayCredentials['PayPalApiSecretKey'],
            'mode' => $gatewayMode
        );

        $this->load->library('paypal/paypal.php', $paypalAccessKeys);

        $paymentDetailsRes = $this->paypal->getPaymentIdDetails($getVar['paymentId']);
        if ($paymentDetailsRes['status'] == FALSE) {
            //Handling on invalid PaymentId
            $this->customsession->setData('booking_message', $paymentDetailsRes['message']);
            redirect($redirectUrl);
        }

        $paymentDetails = $paymentDetailsRes['response'];
        $getVar['paymentDetails'] = $paymentDetails;
        $orderId = $paymentDetails['transactions'][0]['custom'];
        $this->soldTicketValidation($orderId);
        $getVar['orderId'] = $orderId;

        $redirectUrl = commonHelperGetPageUrl('payment', '', '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields);

        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->paypalProcessingApi($getVar);
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }

        $successUrl = commonHelperGetPageUrl('confirmation') . '?orderid=' . $orderId . '&samepage=' . $samepage . '&nobrand=' . $nobrand . $themefields;
        header("Location: " . $successUrl);
        exit;
    }

    /* Stripe processing */

    public function stripeProcessingPage()
    {
        $getVar = $this->input->get();
        $postVar = $this->input->post();
        $orderId = $getVar['orderId'];
        $this->soldTicketValidation($orderId);
        $samepage = $getVar['samepage'];
        $themefields = '';
        if (isset($getVar['themefields']) && $getVar['themefields'] != '') {
            $themefields = $getVar['themefields'];
            $themefields = str_replace('----', '&', $themefields);
            $themefields = $themefields . '&tb=payment';
        }
        $inputData['orderId'] = $orderId;
        $inputData['tokenid'] = $getVar['tokenid'];
        $inputData['paymentGatewayKey'] = $getVar['paymentGatewayKey'];
        $redirectUrl = commonHelperGetPageUrl('payment') . '?orderid=' . $orderId . '&samepage=' . $samepage . $themefields;
        $bookingHandler = new Booking_handler();
        $apiResponse = $bookingHandler->stripeProcessingApi($inputData);
        //print_r($apiResponse); exit;
        if (!$apiResponse['status']) {
            $errorMessage = $apiResponse['response']['messages'][0];
            if (isset($postVar['errorMessage']))
                $errorMessage = $postVar['errorMessage'];
            $this->customsession->setData('booking_message', $errorMessage);
            redirect($redirectUrl);
        }
        $successUrl = commonHelperGetPageUrl('confirmation') . '?orderid=' . $orderId . '&samepage=' . $samepage . $themefields;
        header("Location: " . $successUrl);
        exit;
    }

}

?>
