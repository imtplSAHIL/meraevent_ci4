<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Ingenico S2S Response controller
 */
class Ingenico extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * Function to display the booking page
     *
     * @access	public
     * @return	Display the Booking form with the custom fields and payment gateways
     */

    public function s2sResponse()
    {
        $pgResponseData = array();
        if (!empty($_GET['msg'])) {
            $pgResponseData = $_GET;
        } else if ($_POST['msg']) {
            $pgResponseData = $_POST;
        }
        $myfile = fopen($_SERVER['DOCUMENT_ROOT'] . "/content/s2s_response.txt", "a");
        fwrite($myfile, "\n". date('Y-m-d H:i:s') . "-" . $pgResponseData['msg']);
        //Get Booking Id
        $response_data = explode("|", $pgResponseData['msg']);
        $booking_id = $response_data[3];
        $tpsl_id = $response_data[5];
        $status = 1;
        $pg_result = $this->db->query("SELECT id, hashkey FROM paymentgateway WHERE name = 'ingenico'");
        if (!empty($pg_result)) {
            $pg_data = $pg_result->result_array();
            $hash_key = $pg_data['0']['hashkey'];
            $hash_verified = $this->verifyHash($hash_key, $response_data);
            if ($hash_verified && $response_data[0] == "0300" && strtolower($response_data[1]) == 'success') {
                $status = $this->makeSuccess($booking_id, $pgResponseData['msg'], $pg_data['0']['id']);
            } else {
                $status = 0;
            }
        } else {
            $status = 0;
        }
        fwrite($myfile, "\n". date('Y-m-d H:i:s') . "-" . $booking_id . "|" . $tpsl_id . "|" . $status);
        fclose($myfile);
        echo $booking_id . "|" . $tpsl_id . "|" . $status;
        die;
    }

    private function verifyHash($hash_key, $response_data)
    {
        $receivedSecureHash = $response_data[15];
        $params = $response_data[0];
        $params .= '|' . $response_data[1];
        $params .= '|' . $response_data[2];
        $params .= '|' . $response_data[3];
        $params .= '|' . $response_data[4];
        $params .= '|' . $response_data[5];
        $params .= '|' . $response_data[6];
        $params .= '|' . $response_data[7];
        $params .= '|' . $response_data[8];
        $params .= '|' . $response_data[9];
        $params .= '|' . $response_data[10];
        $params .= '|' . $response_data[11];
        $params .= '|' . $response_data[12];
        $params .= '|' . $response_data[13];
        $params .= '|' . $response_data[14];
        $params .= '|' . $hash_key;
        $generatedSecurehash = "";
        if (strlen($params) > 0) {
            $generatedSecurehash = md5($params);
        }
        if (!empty($generatedSecurehash) && $receivedSecureHash == $generatedSecurehash) {
            return true;
        }
        return false;
    }

    private function makeSuccess($booking_id, $pgResponseData, $payment_gateway_id)
    {
        $ressqlEs = $this->db->query("SELECT id, transactionstatus FROM eventsignup WHERE id = " . $booking_id)->result_array();
        //Check Status
        if ($ressqlEs[0]['transactionstatus'] == 'success') {
            return 1;
        } else {
            $resOrderLog = $this->db->query("SELECT id, userid, orderid FROM orderlog WHERE eventsignup = " . $booking_id)->result_array();
            $inputData['orderId'] = $resOrderLog[0]['orderid'];
            $inputData['msg'] = $pgResponseData;
            $inputData['paymentGatewayKey'] = $payment_gateway_id;
            $inputData['s2sUserId'] = $resOrderLog[0]['userid'];
            require_once(APPPATH . 'handlers/booking_handler.php');
            $bookingHandler = new Booking_handler();
            $apiResponse = $bookingHandler->ingenicoProcessingApi($inputData);
            if (!$apiResponse['status']) {
                return 0;
            } else {
                return 1;
            }
        }
    }

}

?>
