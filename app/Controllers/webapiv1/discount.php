<?php

/**
 * Maintaing Ticket related data
 *
 * @author    Qison  Dev Team
 * @copyright  2015-2005 The PHP Group
 * @version    CVS: $Id:$
 * @since      Tags available since Sprint 2
 * @deprecated File deprecated in Release 2.0.0
 */
/*
 * Place includes, constant defines and $_GLOBAL settings here.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/discount_handler.php');

class Discount extends REST_Controller
{

    var $discountHandler;

    public function __construct()
    {
        parent::__construct();
        parent::_oauth_validation_check();
    }

    /*
     * Function to get the Discount list for the event
     *
     * @access	public
     * @param	taking post values that contains
     * 			eventId - integer
     * 			ticketId - integer (optional)
     * @return	json response with ticket detailed list
     */

    public function index_get()
    {
        $inputArray = $this->get();

        $this->discountHandler = new Discount_handler();
        $discountDetails = $this->discountHandler->getDiscountList($inputArray);
        if (!empty($discountDetails['response']['discountList'])) {
            $this->ticketDiscountHandler = new Ticketdiscount_handler();
            foreach ($discountDetails['response']['discountList'] as $key => $discount) {
                $ticketDiscountData = $this->ticketDiscountHandler->getTicketDiscountData($discount['id']);
                $discountDetails['response']['discountList'][$key]['tickets'] = !empty($ticketDiscountData['response']['ticketDiscountList']) ? $ticketDiscountData['response']['ticketDiscountList'] : [];
            }
        }
        $resultArray = array('response' => $discountDetails['response'], 'statusCode' => $discountDetails['statusCode']);
        $this->response($resultArray, $discountDetails['statusCode']);
    }

}
