<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'handlers/event_handler.php');

class DirectPayment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function createOrder()
    {
        $inputArray = $this->input->post();
        $this->eventHandler = new Event_handler();
        $inputArray['direct_payment_attendee_data'] = $inputArray['attendee'];
        $handlingfeeHandler = new Handlingfee_handler();
        $internetHandlingRes = $handlingfeeHandler->getHandlingFee($inputArray['eventId']);
        if ($internetHandlingRes['status'] == TRUE && $internetHandlingRes['response']['total'] > 0) {
            $inputArray['isInterNetHandling'] = 1;
        } else {
            $inputArray['isInterNetHandling'] = 0;
        }
        $inputArray['Event_Type'] = !empty($inputArray['Event_Type']) ? $inputArray['Event_Type'] : '';
        $inputArray['parentsignupid'] = !empty($inputArray['parentsignupid']) ? $inputArray['parentsignupid'] : '';
        $inputArray['redirectUrl'] = !empty($inputArray['redirecturl']) ? $inputArray['redirecturl'] : '';
        $ticketResultArray = $this->eventHandler->bookNow($inputArray);
        $resultArray = array('response' => $ticketResultArray['response']);
        if (!empty($resultArray['response']['orderId'])) {
            redirect(site_url() . 'directPayment?orderid=' . $resultArray['response']['orderId']);
        } else {
            echo "Some parameters are missing, try again";
            die;
        }
    }

    public function index()
    {
        $getVar = $this->input->get();
        $orderId = $getVar['orderid'];
        $orderLogDataResponse = $this->soldTicketValidation($orderId);
        $redirectUrl = site_url();
        if (($orderLogDataResponse['status'] && $orderLogDataResponse['response']['total'] == 0) || !$orderLogDataResponse['status']) {
            redirect($redirectUrl);
        }
        $orderLogSessionData = unserialize($orderLogDataResponse['response']['orderLogData']['data']);
        $selectedTicketData = $orderLogSessionData['ticketarray'];
        $eventId = ($orderLogSessionData['eventid']) ? $orderLogSessionData['eventid'] : '';
        if ($eventId == '') {
            redirect($redirectUrl);
        }
        $data = array();
        $isExisted = FALSE;
        $orderLogData = $orderLogDataResponse['response']['orderLogData'];

        if ($orderLogData['eventsignup'] > 0 && is_array($orderLogSessionData['paymentResponse']) &&
                ($orderLogSessionData['paymentResponse']['TransactionID'] > 0 || $orderLogSessionData['paymentResponse']['mode'] != '') && $orderLogSessionData['paymentResponse']['mode'] != 'postpayment') {
            $isExisted = TRUE;
        }

        $data['redirectUrl'] = '';
        if ($orderLogSessionData['redirecturl'] != '') {
            $data['redirectUrl'] = $orderLogSessionData['redirecturl'];
        }
        if($orderLogSessionData['Event_Type'] == 'PP'){
                        $data['Event_Type'] = $orderLogSessionData['Event_Type'];
        }
        if(!empty($orderLogSessionData['parentsignupid'])){
                        $data['parentsignupid'] = $orderLogSessionData['parentsignupid'];
        }      
        if ($orderLogSessionData['referralcode'] != '') {
            $data['referralcode'] = $orderLogSessionData['referralcode'];
        }
        //adding the past attendee referral marketing code
        if (isset($orderLogSessionData['pastAttReferralCode']) && $orderLogSessionData['pastAttReferralCode'] != '') {
            $data['pastAttReferralCode'] = $orderLogSessionData['pastAttReferralCode'];
        }
        if ($orderLogSessionData['promotercode'] != '') {
            $data['promotercode'] = $orderLogSessionData['promotercode'];
        }
        if (isset($orderLogSessionData['acode']) && $orderLogSessionData['acode'] != '') {
            $data['acode'] = $orderLogSessionData['acode'];
        }

        $data['calculationDetails'] = $orderLogSessionData['calculationDetails'];
        $data['addonArray'] = isset($orderLogSessionData['addonArray']) ? $orderLogSessionData['addonArray'] : array();

        $courierFee = 0;
        if (isset($orderLogSessionData['calculationDetails']['courierFee']) && $orderLogSessionData['calculationDetails']['courierFee'] > 0) {
            $courierFee = 1;
            $data['courierCharge'] = $orderLogSessionData['calculationDetails']['courierFee'];
            $data['courierFeeLabel'] = $orderLogSessionData['calculationDetails']['courierFeeLabel'];
        } elseif (isset($orderLogSessionData['calculationDetails']['courierFee']) && $orderLogSessionData['calculationDetails']['courierFee'] == 0) {
            $courierFee = 2;
        }

        $data['courierFee'] = $courierFee;

        /* Getting the Event Details starts here */
        $request['eventId'] = $eventId;
        $eventHandler = new Event_handler();
        $eventDataArr = $eventHandler->getEventLocationDetails($request);

        $eventDataArr = $eventHandler->getEventPageDetails($request);
        $eventSettingsDataArr = $eventHandler->getEventSettings($request);

        $courierFee = 0;
        if (isset($orderLogSessionData['calculationDetails']['courierFee']) && $orderLogSessionData['calculationDetails']['courierFee'] > 0 && $eventSettingsDataArr['response']['eventSettings'][0]['courierfee'] == TRUE) {
            $courierFee = 1;
            $data['courierCharge'] = $orderLogSessionData['calculationDetails']['courierFee'];
            $data['courierFeeLabel'] = $orderLogSessionData['calculationDetails']['courierFeeLabel'];
        } elseif (isset($orderLogSessionData['calculationDetails']['courierFee']) && $orderLogSessionData['calculationDetails']['courierFee'] == 0 && $eventSettingsDataArr['response']['eventSettings'][0]['courierfee'] == TRUE) {
            $courierFee = 2;
        }
        $data['courierFee'] = $courierFee;

        //Multievent Check
        $CMEInput['eventId'] = $eventId;
        $MEcheckResponse = $eventHandler->checkIsMultiEvent($CMEInput);
        if ($MEcheckResponse['status'] == TRUE && $MEcheckResponse['parentId'] > 0) {
            $data['masterEventId'] = $MEcheckResponse['parentId'];
        }

        $data['eventData'] = $data['eventSettingsData'] = $ticketDetails = array();
        if ($eventDataArr['status'] && $eventDataArr['response']['total'] > 0) {
            $eventData = $eventDataArr['response']['details'];
            $eventAddress = '';

            if (isset($eventData['location']['venueName']) && !empty($eventData['location']['venueName'])) {
                $eventAddress .= ',' . $eventData['location']['venueName'];
            }
            if (isset($eventData['location']['address1']) && !empty($eventData['location']['address1'])) {
                $eventAddress .= ', ' . $eventData['location']['address1'];
            }
            if (isset($eventData['location']['address2']) && !empty($eventData['location']['address2'])) {
                $eventAddress .= ', ' . $eventData['location']['address2'];
            }
            if (isset($eventData['location']['cityName']) && !empty($eventData['location']['cityName'])) {
                $eventAddress .= ', ' . $eventData['location']['cityName'];
            }
            if (isset($eventData['location']['stateName']) && !empty($eventData['location']['stateName'])) {
                $eventAddress .= ', ' . $eventData['location']['stateName'];
            }
            if (isset($eventData['location']['countryName']) && !empty($eventData['location']['countryName'])) {
                $eventAddress .= ', ' . $eventData['location']['countryName'];
            }
            $eventAddress = ltrim($eventAddress, ',');
            $eventData['fullAddress'] = $eventAddress;
            // For edit Order Url for Preview
            if ($orderLogSessionData['pageType'] == 'preview') {
                if ($MEcheckResponse['status'] == TRUE) {
                    $eventData['eventUrl'] = commonHelperGetPageUrl('event-preview', '', '?view=preview&eventId=' . $data['masterEventId'] . '&sub=' . $eventId);
                } else {
                    $eventData['eventUrl'] = commonHelperGetPageUrl('event-preview', '', '?view=preview&eventId=' . $eventId);
                }
            }

            if (isset($eventData['eventDetails']['bookButtonValue']) && !empty($eventData['eventDetails']['bookButtonValue'])) {
                $eventData['bookButtonValue'] = $eventData['eventDetails']['bookButtonValue'];
            } else {
                $eventData['bookButtonValue'] = 'PAY NOW';
            }

            $data['eventData'] = $eventData;

            $data['pageTitle'] = isset($eventData['title']) ? $eventData['title'] . ' | ' : '';
            $data['pageTitle'] .= 'Book tickets online for music concerts, live shows and professional events. Be informed about upcoming events in your city';
            // Getting Ticketing options of the event
            $ticketOptionInput['eventId'] = $eventId;
            $ticketOptionInput['eventDetailReq'] = false;
            $collectMultipleAttendeeInfo = 0;
            $geoLocalityDisplay = 1;
            $ticketOptionArray = $eventHandler->getTicketOptions($ticketOptionInput);


            if ($ticketOptionArray['status'] && $ticketOptionArray['response']['total'] > 0) {
                $collectMultipleAttendeeInfo = $ticketOptionArray['response']['ticketingOptions'][0]['collectmultipleattendeeinfo'];
                $geoLocalityDisplay = $ticketOptionArray['response']['ticketingOptions'][0]['geolocalitydisplay'];
                $data['eventTicketOptionSettings']['eventdatehide'] = $ticketOptionArray['response']['ticketingOptions'][0]['eventdatehide'];
                $data['eventTicketOptionSettings']['eventlocationhide'] = $ticketOptionArray['response']['ticketingOptions'][0]['eventlocationhide'];
            }
            $eventSettingsDataArr = $eventHandler->getEventSettings($request);
            if ($eventSettingsDataArr['status'] && $eventSettingsDataArr['response']['total'] > 0) {
                $data['eventSettings'] = $eventSettingsDataArr['response']["eventSettings"][0];
            }
        } else {
            redirect('home');
        }
        $data['collectMultipleAttendeeInfo'] = $collectMultipleAttendeeInfo;
        if ($courierFee == 1) {
            $geoLocalityDisplay = 0;
        }
        $data['geoLocalityDisplay'] = $geoLocalityDisplay;
        $data['courierFee'] = $courierFee;
        $userMismatch = false;
        /* Getting the Event Details ends here */
        if (!$isExisted) {

            /* Code to get the event related gateways starts here */
            $eventGateways = array();
            $gateWayInput['eventId'] = $eventId;
            $gateWayInput['gatewayStatus'] = true;
            $gateWayData = $eventHandler->getEventPaymentGateways($gateWayInput);
            if ($gateWayData['status'] && count($gateWayData['response']['gatewayList']) > 0) {
                $eventGateways = $gateWayData['response']['gatewayList'];
            }

            //Disable Payal INR for USD payments
            if ($orderLogSessionData['calculationDetails']['currencyCode'] == 'USD') {
                foreach ($eventGateways as $key => $value) {
                    if ($value['functionname'] == 'paypalinr') {
                        unset($eventGateways[$key]);
                    }
                }
            }

            $data['eventGateways'] = $eventGateways;
            $data['attendee_data'] = $orderLogSessionData['direct_payment_attendee_data'];
            /* Getting Ticketwise details starts here */
            $data['ticketData'] = $selectedTicketData;
            foreach ($selectedTicketData as $ticketId => $ticketQty) {
                $calculateTicketArr[$ticketId]['selectedQty'] = $ticketQty;
            }
            $data['calculateTicketArr'] = $calculateTicketArr;
            /* Getting Ticketwise details ends here */

            /* Getting user data starts here */
            $userDataArray = array();
            $orderUserId = $eventSignupId = $orderLogData['userid'];

            $userId = $this->customsession->getUserId();
            if ($userId > 0 && !empty($orderUserId) && $userId != $orderUserId) {
                $userMismatch = true;
                $userDataInput['ownerId'] = $orderUserId;
                $userDataInput['profileImageReq'] = false;
                $userHandler = new User_handler();
                $userDataResponse = $userHandler->getUserData($userDataInput);
                if ($userDataResponse['status'] && $userDataResponse['response']['total'] > 0) {
                    $userData = $userDataResponse['response']['userData'];
                    $incompleteEmail = $userData['email'];
                    $data['incompleteEmail'] = $incompleteEmail;
                }
            }

            // for attendee details by signupid Start
            if ($orderLogData['eventsignup'] > 0) {
                require_once(APPPATH . 'handlers/attendee_handler.php');
                $attendeeHandler = new Attendee_handler();
                $eventSignupId = $orderLogData['eventsignup'];
                $data['oldEventSignupId'] = $orderLogData['eventsignup'];
                $inputAttendee['eventsignupids'] = array($eventSignupId);
                $attendeeData = $attendeeHandler->getListByEventsignupIds($inputAttendee);
            }
            // for attendee details by signupid End

            if ($userId > 0 && !$userMismatch) {
                $userDataInput['ownerId'] = $userId;
                $isOrganizer = $this->customsession->getData('isOrganizer');
                if ($isOrganizer == 1) {
                    $userDataInput['organizerDataReq'] = true;
                }
                $userDataInput['profileImageReq'] = false;
                $userHandler = new User_handler();
                $userDataResponse = $userHandler->getUserData($userDataInput);
                if ($userDataResponse['status'] && $userDataResponse['response']['total'] > 0) {
                    $userData = $userDataResponse['response']['userData'];
                    $organizerData = isset($userDataResponse['response']['organizerData']) ? $userDataResponse['response']['organizerData'] : array();
                    $userDataArray['FullName'] = $userData['name'];
                    $userDataArray['EmailId'] = $userData['email'];
                    $userDataArray['MobileNo'] = ($userData['mobile'] != '') ? $userData['mobile'] : $userData['phone'];
                    $userDataArray['Address'] = $userData['address'];
                    $userDataArray['Country'] = $userData['country'];
                    if ($courierFee == TRUE) {
                        $userDataArray['State'] = $userData['state'];
                        $userDataArray['City'] = $userData['city'];
                    } else {
                        $userDataArray['State'] = (!empty($userData['state'])) ? $userData['state'] : $userDataArray['Country'];
                        $userDataArray['City'] = (!empty($userData['city'])) ? $userData['city'] : $userDataArray['State'];
                    }

                    $localityArr = array();
                    if ($userDataArray['City'] != '') {
                        $localityArr[] = $userDataArray['City'];
                    }
                    if ($userDataArray['State'] != '') {
                        $localityArr[] = $userDataArray['State'];
                    }
                    if ($userDataArray['Country'] != '') {
                        $localityArr[] = $userDataArray['Country'];
                    }
                    $userDataArray['Locality'] = implode(',', array_unique($localityArr));
                    $userDataArray['State'] = $userDataArray['State'];
                    $userDataArray['City'] = $userDataArray['City'];
                    $userDataArray['PinCode'] = $userData['pincode'];
                    $userDataArray['CompanyName'] = $userData['company'];
                    if (count($organizerData) > 0) {
                        $userDataArray['Designation'] = isset($organizerData['designation']) ? $organizerData['designation'] : '';
                    }
                }
            } elseif ($userId > 0 && $incompleteTrans && !$userMismatch) {
                require_once(APPPATH . 'handlers/attendee_handler.php');
                $attendeeHandler = new Attendee_handler();
                $eventSignupId = $orderLogData['eventsignup'];
                $inputAttendee['eventsignupids'] = array($eventSignupId);
                $attendeeData = $attendeeHandler->getListByEventsignupIds($inputAttendee);

                $eventSignupInput['eventsignupId'] = $eventSignupId;
                $eventsignupHandler = new Eventsignup_handler();
                $signupData = $eventsignupHandler->getEventsignupDetails($eventSignupInput);



                if ($signupData['status'] && $signupData['response']['total'] > 0) {
                    $data['eventSignupData']['stagedStatus'] = $signupData['response']['eventSignupList'][0]['stagedstatus'];
                } else {
                    $return['errorMessage'] = SOMETHING_WRONG;
                    $return['status'] = FALSE;
                    return $return;
                }
            }
            //getting user location from ip2location
            $ip2location_status = $this->config->item('ip2LocationEnable');
            if ($ip2location_status) {
                if (count($userDataArray) < 1 || !isset($userDataArray['City']) || $userDataArray['City'] == '') {
                    $user_ip = get_client_ip(); //from common helper
                    $user_loc_det_status = ip2location($user_ip);
                    if ($user_loc_det_status['status']) {
                        $user_loc_det = $user_loc_det_status['response']['locationDetails'];
                        if ($user_loc_det['city_name'] != '' && $user_loc_det['city_name'] != '-') {
                            $localityArr[] = $user_loc_det['city_name'];
                            $userDataArray['City'] = $user_loc_det['city_name'];
                        }
                        if ($user_loc_det['region_name'] != '' && $user_loc_det['region_name'] != '-') {
                            $localityArr[] = $user_loc_det['region_name'];
                            $userDataArray['State'] = $user_loc_det['region_name'];
                        }
                        if ($user_loc_det['country_name'] != '' && $user_loc_det['country_name'] != '-') {
                            $localityArr[] = $user_loc_det['country_name'];
                            $userDataArray['Country'] = $user_loc_det['country_name'];
                        }
                        $userDataArray['Locality'] = implode(',', array_unique($localityArr));
                    }
                }
            }
            if (isset($attendeeData) && $attendeeData['status'] && $attendeeData['response']['total'] > 0) {
                $attendeeeList = $attendeeData['response']['attendeeList'];
                $indexedAttendeeList = commonHelperGetIdArray($attendeeeList);
                $attendeeIds = array_keys($indexedAttendeeList);
            }
            if (isset($attendeeIds) && count($attendeeIds) > 0) {
                require_once(APPPATH . 'handlers/attendeedetail_handler.php');
                $attendeedetailHandler = new Attendeedetail_handler();
                $inputAttendeedetail['attendeeids'] = $attendeeIds;
                $attendeedetailData = $attendeedetailHandler->getListByAttendeeIds($inputAttendeedetail);
            }
            $attendeedetailList = $indexedAttendeedetailList = array();
            if (isset($attendeedetailData) && $attendeedetailData['status'] && $attendeedetailData['response']['total'] > 0) {
                $attendeedetailList = $attendeedetailData['response']['attendeedetailList'];
            }
            $attendeeId = '';
            $i = 1;
            $localityArray = array();
            foreach ($attendeedetailList as $value) {
                if (empty($attendeeId)) {
                    $attendeeId = $value['attendeeid'];
                }
                if ($attendeeId != $value['attendeeid']) {
                    $attendeeId = $value['attendeeid'];
                    $i++;
                }
                $trimmedFieldName = str_replace(" ", "", preg_replace("/[^A-Za-z0-9\s\s+]/", "", $indexedTempEventCustomFieldsArray[$value['customfieldid']]['fieldname']));
                $indexedAttendeedetailList[$trimmedFieldName][$i] = $value['value'];
                if ($trimmedFieldName == 'City' || $trimmedFieldName == 'State' || $trimmedFieldName == 'Country') {
                    $localityArray[$i][$trimmedFieldName] = $value['value'];
                }
            }
            if (!empty($localityArray)) {
                $localityFields = array();
                foreach ($localityArray as $lakey => $lavalue) {
                    $lvalue = $lavalue['City'] . ', ' . $lavalue['State'] . ', ' . $lavalue['Country'];
                    $lvalue = trim($lvalue, ",");
                    $localityFields[$lakey] = $lvalue;
                }
                $indexedAttendeedetailList[DB_LOCALITY] = $localityFields;
            }

            $data['userData'] = $userDataArray;
            $data['indexedAttendeedetailList'] = $indexedAttendeedetailList;
            /* Getting user data endds here */
            $eventSignupId = 0;
            $data['eventSignupId'] = $eventSignupId;
            $data['orderLogId'] = $orderId;
        }

        $data['moduleName'] = 'eventModule';
        $data['pastAttreferralDiscountpageName'] = 'Payment';
        $data['pageName'] = 'Payment';
        $data['isExisted'] = $isExisted;
        $data['userMismatch'] = $userMismatch;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'fixto',
            $this->config->item('js_public_path') . 'jquery.validate',
            $this->config->item('js_public_path') . 'additional-methods',
            $this->config->item('js_public_path') . 'delegate', $this->config->item('js_public_path') . 'ticketwidget/ticketwidget'
        );
        $data['jsTopArray'] = array(
            $this->config->item('js_public_path') . 'intlTelInput'
        );
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'delegate',
            $this->config->item('css_public_path') . 'intlTelInput'
        );

        $widgetTheme = isset($getVar['theme']) ? $getVar['theme'] : 0;
        $data['widgettheme'] = $widgetTheme;
        // devilsCircuitValidation
        $ticketFieldsValidation = $this->config->item('devilsCircuitValidation');
        if (isset($ticketFieldsValidation[$eventId]) && !empty($ticketFieldsValidation[$eventId])) {
            $data['ticketFieldsValidation'] = $ticketFieldsValidation[$eventId]['tickets'];
        }
        $themecss = $this->config->item('css_public_path') . 'ticketwidget/theme1/theme';
        array_push($data['cssArray'], $themecss);
        $data['handlingFeeLable'] = $this->config->item('internet_handling_lable');
        $data['content'] = 'direct_payment/reg_info';
        $this->load->view('templates/direct_payment_template', $data);
    }

    function soldTicketValidation($orderId, $orderLogDataArr = array())
    {
        $orderLogInput['orderId'] = $orderId;
        $redirectUrl = site_url();  // Need to replace it after finializing the error response page

        if (is_array($orderLogDataArr) && count($orderLogDataArr) > 0) {
            $orderLogData = $orderLogDataArr;
        } else {
            $orderlogHandler = new Orderlog_handler();
            $orderLogData = $orderlogHandler->getOrderlog($orderLogInput);
            if (($orderLogData['status'] && $orderLogData['response']['total'] == 0) || !$orderLogData['status']) {
                if (isset($orderLogDataArr['returnOutput']) && $orderLogDataArr['returnOutput'] == TRUE) {
                    $output = array();
                    $output['status'] = FALSE;
                    $output['message'] = ERROR_NO_ORDERLOG_FOUND;
                    $output['redirectUrl'] = $redirectUrl;
                    return $output;
                } else {
                    redirect($redirectUrl);
                }
            }
        }

        $orderLogSessionData = $orderLogData['response']['orderLogData']['data'];
        $orderLogSessionDataArr = unserialize($orderLogSessionData);
        $ticketArray = $orderLogSessionDataArr['ticketarray'];

        $ticketIds = array_keys($ticketArray);
        $ticketDataInput['eventId'] = $orderLogSessionDataArr['eventid'];
        $ticketDataInput['ticketIds'] = $ticketIds;
        $ticketDataInput['taxRequired'] = false;
        $ticketHandler = new Ticket_Handler();
        $ticketsData = $ticketHandler->getTicketsbyIds($ticketDataInput);
        $ticketDataArr = $ticketsData['response']['ticketdetails'];

        foreach ($ticketDataArr as $ticket) {
            $ticketSoldQty = $ticket['totalsoldtickets'];
            $availableTktQty = $ticket['quantity'];

            $ticketNewSoldQty = $ticketSoldQty + $ticketArray[$ticket['id']];

            // If the selected quantity with already sold tickets exceeded total quantity
            if ($ticketNewSoldQty > $availableTktQty) {
                $errorMessage = $ticket['name'] . ERROR_TICKET_EXCEEDED;
                $this->customsession->setData('booking_message', $errorMessage);
                if (isset($orderLogDataArr['returnOutput']) && $orderLogDataArr['returnOutput'] == TRUE) {
                    $output = array();
                    $output['status'] = FALSE;
                    $output['message'] = ERROR_TICKET_EXCEEDED;
                    $output['redirectUrl'] = $redirectUrl;
                    return $output;
                } else {
                    redirect($redirectUrl);
                }
            }
        }

        if (isset($orderLogDataArr['returnOutput']) && $orderLogDataArr['returnOutput'] == TRUE) {
            $output = array();
            $output['status'] = TRUE;
            $output['response'] = $orderLogData;
            return $output;
        } else {
            return $orderLogData;
        }
    }

}

?>
