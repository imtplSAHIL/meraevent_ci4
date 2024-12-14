 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/confirmation_handler.php');
require_once(APPPATH . 'handlers/email_handler.php');

class Transaction extends REST_Controller {

    var $confirmationHandler,$emailHandler;

    public function __construct() {
        parent::__construct();
        $this->confirmationHandler = new Confirmation_handler();
        $this->eventsignupHandler = new Eventsignup_handler();
    }


    /*
     * Function to get the Event Signup Details
     *
     * @access	public
     * @return	json data
     *  Parameters : orderId
     */

    public function transactionsuccessdetails_get() {
        $inputArray = $this->get();
        $eventsignupDetails = $this->confirmationHandler->eventSignupDetailData($inputArray);
        $resultArray = array('response' => $eventsignupDetails['response']);
        $this->response($resultArray, $eventsignupDetails['statusCode']);
    }
    
  
    /*
     * Function to get the EventSignup Details By orderid
     *
     * @access	public
     * @return	json data
     *  Parameters : orderId
     */
    public function resendTransactionSuccessEmailToDelegate_get(){
    	$inputArray = $this->get();
		$inputArray['userId'] = getUserId();
        $inputArray['isOrganizer'] = $this->customsession->getData("isOrganizer") ? true : false;
        $GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY;
		if(!empty($GPTW_EVENTS_ARRAY[$inputArray['eventId']])){
            $input = array();
            $purchaserDetails = $this->eventsignupHandler->getEventSignupDetailsByID($inputArray['eventsignupId']);
            $input['eventsignupId'] = $inputArray['eventsignupId'];
            $input['mobile'] = $purchaserDetails['mobile'];
            $input['eventtitle'] = $purchaserDetails['title'];
            $input['eventid '] = $purchaserDetails['eventid'];
            $input['timezone'] = 'IST';
            $input['userId'] = $purchaserDetails['userid'];
            $input['purchaser_date'] = date('d/m/Y');
            
            $input['isOrganizer'] = $this->customsession->getData("isOrganizer") ? true : false;
            $input['force_attendee_email'] = true;
            
            $sendEmail = $this->confirmationHandler->resendPurchaserTransactionsuccessEmail($input);
        }
        else
        {
            $sendEmail = $this->confirmationHandler->resendTransactionsuccessEmail($inputArray);
        }
        
    	$resultArray = array('response' => $sendEmail['response']);
    	$this->response($resultArray, $sendEmail['statusCode']);
    }
    
    /*
     * Function to get printpass
     *
     * @access	public
     * @return	json data
     *  Parameters : eventsignupid,email
     */
    public function emailPrintpass_get(){
    	$inputArray = $this->get();
    	$sendEmail = $this->confirmationHandler->emailPrintpass($inputArray);
    	$resultArray = array('response' => $sendEmail['response']);
    	$this->response($resultArray, $sendEmail['statusCode']);
    }
    /*
     * Function to send the SMS for Delegate Successfull Transaction
     *
     * @access	public
     * @return	json data
     *  Parameters : eventsignupid,eventtitle,mobile
     */
    
    public function resendSuccessEventsignupsmstoDelegate_get(){
    	$inputArray = $this->get();
		$inputArray['userId'] = getUserId();
    	$sendsms = $this->confirmationHandler->sendSuccessEventsignupsmstoDelegate($inputArray);
    	$resultArray = array('response' => $sendsms['response']);
    	$this->response($resultArray, $sendsms['statusCode']);
    	
    }
    
    /*
     * Function to send the SMS for Delegate Successfull Transaction
     *
     * @access	public
     * @return	json data
     *  Parameters : eventsignupid,eventtitle,mobile
     */
    
    public function stagedEventResendEmail_get(){
    	$inputArray = $this->get();
        $inputArray['userId'] = getUserId();
        $this->emailHandler = new Email_handler();
        $sendEmail = $this->emailHandler->stagedEventResendEmail($inputArray);        
        $resultArray = array('response' => $sendEmail['response']);
    	$this->response($resultArray, $sendEmail['statusCode']);
    	
    }

    public function bookingdetails_get() {
        $inputArray = $this->get();
        $eventsignupDetails = $this->confirmationHandler->getBookingDetailData($inputArray);
        $resultArray = array('response' => $eventsignupDetails['response']);
        $this->response($resultArray, $eventsignupDetails['statusCode']);
    }
   

}
