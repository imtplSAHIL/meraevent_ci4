<?php $GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY; ?>
<div class="page-container">
    <div class="wrap">
        <!--   Big container   -->
        <div class="container">
            <div class="row">
                <div class="wizard768"> <!--col-lg-8 col-lg-offset-2 -->
                    <!--      Wizard container        -->
                    <div class="wizard-container">

                        <?php if($isExisted) { ?>
                            <div class="innerPageContainer" style="margin-bottom: 30px;">
                                <h2 class="pageTitle">Registration Information</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        Looks like you used the browser back button after completing your previous transaction to buy another ticket!<br>
                                        To buy another ticket for this event go to
                                        <a href="<?php echo $eventData['eventUrl'];?>">Preview Event</a> and continue from there.
                                        <br><br>Contact support at support@meraevents.com or 040-49171447 for assistance.
                                    </div>
                                </div>
                            </div>
                        <?php }elseif($userMismatch) { ?>
                            <div class="innerPageContainer" style="margin-bottom: 30px;">
                                <h2 class="pageTitle">Registration Information</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        You are not authorized to complete this transaction with this login. Please login with <span style="font-weight: bold;font-size: 18px;"><?php echo $incompleteEmail;?></span><br/> or try out with new transaction
                                        <a href="<?php echo $eventData['eventUrl'];?>">Preview Event</a>.
                                        <br><br>Contact support at support@meraevents.com or 040-49171447 for assistance.
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card wizard-card">

                                <div class="wizard-header">
                                    <div class="wizard-title">
                                        <h2 style="<?php if(isset($eventTitleColor) && $eventTitleColor != '') echo 'color:' . '#' . $eventTitleColor . ';'; ?>"><?php echo (isset($eventData['title']) && $showTitle)?ucwords($eventData['title']):'';?></h2>
                                    </div>
                                    <div class="wizard-location">
                                        <?php if($showDateTime){ ?>
                                            <p><?php
                                                if(isset($configCustomDatemsg[$eventId]) && !isset($configCustomTimemsg[$eventId])){
                                                    echo $configCustomDatemsg[$eventId]." | ".allTimeFormats($eventData['startDate'],4).' to '.allTimeFormats($eventData['endDate'],4).' '.$eventData['location']['timezone'];
                                                }else if(isset($configCustomTimemsg[$eventId]) && !isset($configCustomDatemsg[$eventId])){
                                                    echo allTimeFormats($eventData['startDate'],3);?><?php if (allTimeFormats($eventData['startDate'],9) != allTimeFormats($eventData['endDate'],9))  { echo " - ". allTimeFormats($eventData['endDate'],3);} echo " | ".$configCustomTimemsg[$eventId];
                                                }else if(isset($configCustomTimemsg[$eventId]) && isset($configCustomDatemsg[$eventId])){
                                                    echo $configCustomDatemsg[$eventId]." | ".$configCustomTimemsg[$eventId];
                                                }else{
                                                    echo allTimeFormats($eventData['startDate'],3);?><?php if (allTimeFormats($eventData['startDate'],9) != allTimeFormats($eventData['endDate'],9))  { echo " - ". allTimeFormats($eventData['endDate'],3);} echo " | ".allTimeFormats($eventData['startDate'],4).' to '.allTimeFormats($eventData['endDate'],4).' '.$eventData['location']['timezone'];
                                                }  ?></p>
                                        <?php } ?>
                                        <?php if ($showLocation && $eventData['categoryName'] != 'Donations') { ?>
                                            <p>
                                                <a>
                                                    <?php
                                                    if (isset($eventData['eventMode']) && $eventData['eventMode'] == 1) {
                                                        echo "Virtual Event";
                                                    } else if ($eventData['categoryName'] == 'Webinar') {
                                                        echo "Webinar";
                                                    } else {
                                                        echo $eventData['fullAddress'];
                                                    }
                                                    ?>
                                                </a>
                                            </p>
                                        <?php } ?>
                                        <?php  if(isset($widgetSettings[WIDGET_NOTES]) && $widgetSettings[WIDGET_NOTES]!=''){ ?>
                                            <div class="widgetnotes">
                                                Note: <?php echo $widgetSettings[WIDGET_NOTES];?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="wizard-navigation">
                                    <ul class="nav nav-tabssection">
                                        <li><a id="tickets_tab1"<?php echo $directDetails == 1 ? ' style="display:none;"' : ''; ?> href="<?php echo $ticketediteventurl;?>">
                                                <?php  if(isset($widgetSettings[TICKET_TAB_TITLE]) && $widgetSettings[TICKET_TAB_TITLE]!=''){
                                                    echo $widgetSettings[TICKET_TAB_TITLE];
                                                }else{ echo "TICKETS"; }?>
                                            </a></li>
                                        <li><a id="tickets_tab2" <?php if(isset($tb) && $tb=='details'){ ?> class="tabhighlight"  style="<?php if ($headingBackgroundColor != '') echo 'background:' . '#' . $headingBackgroundColor . ';'; ?>" <?php } ?>>DETAILS</a></li>
                                        <?php  if($calculationDetails['totalPurchaseAmount'] >= 0) { ?>
                                            <?php if($eventSettings['stagedevent'] == 0 || ($eventSettings['stagedevent'] == 1 && $eventSettings['paymentstage'] == 1)){ ?>
                                                <li onclick="tab2validate()"><a <?php if(isset($tb) && $tb=='payment'){ ?> id="tickets_tab3" style="<?php if ($headingBackgroundColor != '') echo 'background:' . '#' . $headingBackgroundColor . ';'; ?>" <?php } ?> class="tickets_tab3 <?php if(isset($tb) && $tb=='payment'){ ?> tabhighlight <?php } ?>">PAYMENT</a></li>
                                            <?php } } ?>
                                    </ul>
                                </div>
                                <div class="iframetab-content">
                                    <div class="tab-pane" id="ticket_pane_tab1" style="display: none;">
                                        <div class="row">
                                            <div class="widget-container">

                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane">
                                        <div id="booking_message_div" style="color: red;">
                                            <?php
                                            $sessionMessage = $this->customsession->getData('booking_message');
                                            $this->customsession->unSetData('booking_message');
                                            if(($sessionMessage)) {    echo $sessionMessage;   }
                                            ?>
                                        </div>

                                        <div id="errorMessage" style="text-align: center;color: red; display:none;">Oops..! Something went wrong..</div>

                                        <div class="row" id="ticket_pane_tab2" <?php if(isset($tb) && $tb=='payment'){ ?>style="display: none;" <?php } ?>>
                                            <?php
                                            $formCount = 1;
                                            if($collectMultipleAttendeeInfo == 1) {
                                                $formCount = array_sum($ticketData);
                                            }
                                            ?>
                                            <script language="javascript">
                                            var ticket_qty_array = <?php echo json_encode($ticketData); ?>;
                                            </script>
                                            <div class="">
                                                <input type="hidden" id="themefieldsActualFields" value="<?php echo '&samepage=1'.str_replace('----', '&', $themeFieldsUrl);?>">
                                                <input type="hidden" id="widgettheme" value="<?php echo $widgettheme; ?>">
                                                <input type="hidden" name="directDetails" id="directDetails" value="<?php echo $directDetails; ?>">
                                                <form action="" name="ticket_registration" id="ticket_registration" enctype="multipart/form-data">

                                                    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventData['id'];?>">
                                                    <input type="hidden" name="samepage" id="samepage" value="<?php echo $samepage;?>">
                                                    <input type="hidden" name="nobrand" id="nobrand" value="<?php echo $nobrand;?>">
                                                    <input type="hidden" name="redirectUrl" id="redirectUrl" value="<?php echo $redirectUrl;?>">
                                                    <input type="hidden" name="orderId" value="<?php echo $orderLogId; ?>" />
                                                    <input type="hidden" name="paymentGateway" id="paymentGateway">
                                                    <input type="hidden" name="paymentGatewayId" id="paymentGatewayId">
                                                    <input type="hidden" name="isSeating" id="isSeating" value="<?php echo $eventSettings['seating'];?>">
                                                    <input type="hidden" name="courierFee" id="courierFee" value="<?php echo $courierFee; ?>"> 

                                                    <?php foreach($ticketData as $ticketId => $ticketCount) { ?>
                                                        <input type="hidden" name="ticketArr[<?php echo $ticketId; ?>]" id="ticketArr[<?php echo $ticketId; ?>]" value="<?php echo $ticketCount; ?>" />
                                                    <?php } ?>

                                                    <input type="hidden" name="eventSignupId" id="eventSignupId" value="<?php echo $eventSignupId;?>">

                                                    <?php
                                                    $attendeeCount = 1;
                                                    $addonTextNotShown=true;
                                                    if($courierFee == 1){
                                                        $hiddenLocationArray = array();
                                                    }else{
                                                        $hiddenLocationArray = array('Country','State','City');
                                                    }
                                                    $courierFeeFieldsArray = array(4,5,6,10);
                                                    $localityCount = 0;
                                                    $addonTicketLevelFields=false;
                                                    $addonData=$normalTickets=array();
                                                    //print_r($customFieldsArray);exit;
                                                    if ($eventSettings['takeaddondata'] == 1) {
                                                        $addonArray = array();
                                                    }
                                                    foreach($ticketData as $ticketId => $ticketCount) {
                                                        if(in_array($ticketId, $addonArray)){
                                                            $addonData[$ticketId]=$ticketCount;
                                                        }else{
                                                            $normalTickets[$ticketId]=$ticketCount;
                                                        }
                                                    }
                                                    if($collectMultipleAttendeeInfo == 1) {
                                                        foreach ($addonData as $ticketId => $ticketCount) {
                                                            $customDataField = $customFieldsArray[$ticketId];
                                                            foreach ($customDataField as $customField) {
                                                                if($customField['fieldlevel']=='ticket'){
                                                                    $addonTicketLevelFields=true;break;
                                                                }
                                                            }
                                                            if($addonTicketLevelFields){
                                                                break;
                                                            }
                                                        }
                                                    }


                $gst_states_array = array('01' => "JAMMU AND KASHMIR", '02' => "HIMACHAL PRADESH", '03' => "PUNJAB", '04' => "CHANDIGARH", '05' => "UTTARAKHAND", '06' => "HARYANA", '07' => "DELHI", '08' => "RAJASTHAN", '09' => "UTTAR PRADESH", '10' => "BIHAR", '11' => "SIKKIM", '12' => "ARUNACHAL PRADESH", '13' => "NAGALAND", '14' => "MANIPUR", '15' => "MIZORAM", '16' => "TRIPURA", '17' => "MEGHALAYA", '18' => "ASSAM", '19' => "WEST BENGAL", '20' => "JHARKHAND", '21' => "ODISHA", '22' => "CHATTISGARH", '23' => "MADHYA PRADESH", '24' => "GUJARAT", '26' => "DADRA AND NAGAR HAVELI AND DAMAN AND DIU (NEWLY MERGED UT)", '27' => "MAHARASHTRA", '28' => "ANDHRA PRADESH(BEFORE DIVISION)", '29' => "KARNATAKA", '30' => "GOA", '31' => "LAKSHADWEEP", '32' => "KERALA", '33' => "TAMIL NADU", '34' => "PUDUCHERRY", '35' => "ANDAMAN AND NICOBAR ISLANDS", '36' => "TELANGANA", '37' => "ANDHRA PRADESH (NEWLY ADDED)", '38' => "LADAKH (NEWLY ADDED)");
                $employee_strength_array = array('Less than 100' => 'Less than 100',
                                        '101-500' => '101-500',
                                        '501-5000' => '501-5000',
                                        '5001-50000' => '5001-50000',
                                        'More than 50000' => 'More than 50000');
                $industry_array = array(
                                    'Advertising and Marketing' => 'Advertising and Marketing',
                                    'Aerospace' => 'Aerospace',
                                    'Agriculture, Forestry and Fishing' => 'Agriculture, Forestry and Fishing',
                                    'Biotechnology & Pharmaceuticals' => 'Biotechnology & Pharmaceuticals',
                                    'Construction, Infrastructure & Real Estate' => 'Construction, Infrastructure & Real Estate',
                                    'Education and Training' => 'Education and Training',
                                    'Electronics' => 'Electronics',
                                    'Financial Services & Insurance' => 'Financial Services & Insurance',
                                    'Health Care' => 'Health Care',
                                    'Hospitality' => 'Hospitality',
                                    'Industrial Services' => 'Industrial Services',
                                    'Information Technology' => 'Information Technology',
                                    'Manufacturing and Production' => 'Manufacturing and Production',
                                    'Media' => 'Media',
                                    'Mining and Quarrying' => 'Mining and Quarrying',
                                    'Non-Profit and Charity Organisations' => 'Non-Profit and Charity Organisations',
                                    'Professional Services' => 'Professional Services',
                                    'Retail' => 'Retail',
                                    'Social Services and Government Agencies' => 'Social Services and Government Agencies',
                                    'Telecommunications' => 'Telecommunications',
                                    'Trading' => 'Trading',
                                    'Transportation' => 'Transportation',
                                    'Other' => 'Other'
                                    );
                $attendee_heading_flag = 0;
                

if (!empty($GPTW_EVENTS_ARRAY[$eventData['id']]))
{
    ?>
                            <div class="purchaser_form_div registration-container">
                                    <h4>Purchaser Details</h4>
                                    <!-- Purchaser Fields startes here -->
                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        First Name <span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" autofocus="" class="form-control" name="pur_first_name" id="pur_first_name" data-originalname="First Name" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_first_name"></span>
                                    </div>
                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Last Name <span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" autofocus="" class="form-control" name="pur_last_name" id="pur_last_name" data-originalname="Last Name" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_last_name"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Email Id<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_email_id" id="pur_email_id"  data-originalname="Email Id" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_email_id"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Mobile Number<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_mobile" id="pur_mobile"  data-originalname="Mobile" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_mobile"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Organization Name <span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_org_name" id="pur_org_name"  data-originalname="Organization Name" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_org_name"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        GSTIN Number<span style="color:red"></span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_gst" id="gst" onchange="return update_gst_state(this.value)" data-originalname="Organization Name" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="gst"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        PAN Number<span style="color:red"></span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_pan" id="pan" data-originalname="PAN Number" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pan"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Job Title<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_job_title" id="pur_job_title"  data-originalname="Job Title" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_job_title"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Industry<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <select class="form-control" name="pur_industry" id="pur_industry" data-originalname="industry" value="">
                                        <?php
                                                foreach($industry_array as $industry_val => $industry_name)
                                                {
                                                    ?>
                                                    <option value="<?php echo $industry_val; ?>"><?php echo $industry_name; ?></option>
                                                    <?php
                                                }
                                        ?>
                                        </select>
                                        <span class="pur_industry"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Employee Strength<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <select class="form-control" name="pur_employee_strength" id="pur_employee_strength" data-originalname="industry" value="">
                                        <?php
                                                foreach($employee_strength_array as $row_key => $emp_strength)
                                                {
                                                    ?>
                                                    <option value="<?php echo $row_key; ?>"><?php echo $emp_strength; ?></option>
                                                    <?php
                                                }
                                        ?>
                                        </select>
                                        <span class="pur_employee_strength"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Billing Address<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_billing_address" id="pur_billing_address"  data-originalname="Billing Address" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_billing_address"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Country<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_country" id="pur_country"  data-originalname="Country" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_country"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        State<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <select class="form-control" name="pur_state" id="pur_state" data-originalname="State" value="">
										      <option value=''>Select</option>
                                            <?php
                                                foreach($gst_states_array as $state_code => $statename)
                                                {
                                                    ?>
                                                    <option value="<?php echo $state_code; ?>"><?php echo $statename; ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </select>
                                        <span class="pur_state"></span>
                                    </div>

                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        City<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_city" id="pur_city"  data-originalname="City" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_city"></span>
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label style="width: 100%" for="exampleInputtext1">
                                        Pin Code<span style="color:red">*</span>
                                        <span style="font-size: 11px;"></span>
                                        </label>
                                        <input type="text" class="form-control" name="pur_pin_code" id="pur_pin_code"  data-originalname="Mobile" restriction-maxlength="0" restriction-minlength="0" value="">
                                        <span class="pur_pin_code"></span>
                                    </div>

                                    <div class="form-group">
                                        <p>
                                            <label class="customlable-t">
                                            <input value="1" type="checkbox" class="customValidationClass valid" name="pur_is_sez_unit" id="pur_is_sez_unit"  data-originalname="CheckBox">
                                            Do you come under SEZ Unit?
                                            </label>
                                        </p>
                                        <span class="CheckBox_1Err"></span>
                                    </div>

                                    <div class="form-group">
                                        <p>
                                            <label class="customlable-t">
                                            <input value="1" type="checkbox" class="customValidationClass valid" name="pur_existing_client" id="pur_existing_client"  data-originalname="CheckBox">
                                            Are you an existing client of Great Place to Work&reg;?
                                            </label>
                                        </p>
                                        <span class="CheckBox_1Err"></span>
                                    </div>

                                    <div class="form-group">
                                        <p>
                                            <label class="customlable-t">
                                            <input value="1" type="checkbox" name="pur_agree_tnc" id="pur_agree_tnc"  data-originalname="CheckBox"><span></span><span style="color:red">*</span>
                                                I agree to the <a href="https://www.greatplacetowork.in/terms-and-conditions-annual-for-all-summit-2022.pdf" target="_blank">
                                                Terms and Conditions.</a>
                                            </label>
                                        </p>
                                        <span class="CheckBox_1Err"></span>
                                    </div>

                                    </div>

                                    <div class="savep-Holder">
                                        <a id="savep" class="btn commonBtn login">
                                         Proceed
                                        </a>
                                    </div>
                <?php  
                 }
                                                    $ticketData=($normalTickets+$addonData);
                                                    $gstblockCreated = $eventSettings['sendinvoice'] ? false : true;
                                                    foreach($ticketData as $ticketId => $ticketCount) {
                                                        if($collectMultipleAttendeeInfo == 0) {
                                                            $ticketCount = $formCount;
                                                        }
                                                        for($i=1 ; $i <= $ticketCount ; $i++) {?>
                                                            <div class="wid_registration_field_group_<?php echo $attendeeCount;?> registration-container" <?php if(!empty($GPTW_EVENTS_ARRAY[$eventData['id']])) { ?>style="display:none;" <?php } ?> >

                                                                <?php if($formCount > 1 && !in_array($ticketId, $addonArray)) { ?>
                                                                    <div class="widget-attendetext"><?php echo $calculationDetails['ticketsData'][$ticketId]['ticketType'] == 'donation' ? 'Donor Details' : 'Attendee ' . $attendeeCount; ?>
                                                                        <?php if($collectMultipleAttendeeInfo == 1) {?>
                                                                            (Ticket: <?php echo $calculationDetails['ticketsData'][$ticketId]['ticketName'];?>)
                                                                        <?php } ?>
                                                                    </div>

                                                                <?php }elseif($addonTicketLevelFields && in_array($ticketId, $addonArray) && $addonTextNotShown){
                                                                    $addonTextNotShown=false;
                                                                    echo '<div class="widget-attendetext">Add-on Items</div>';
                                                                }

                                                                ?>

                                                                <!-- Custom Fields startes here -->
                                                                <?php
                                                                $customDataField = $customFieldsArray[$ticketId];

                                                                $localityMandatory = false;
                                                                foreach($customDataField as $customField) {
                                                                    if(in_array($customField['fieldname'],$hiddenLocationArray) && $customField['fieldmandatory'] == 1) {
                                                                        $localityMandatory = true;
                                                                    }
                                                                }
                                                                if(in_array($ticketId, $addonArray)&& ($collectMultipleAttendeeInfo == 1 && $customField['fieldlevel'] != 'ticket')){?>
                                                                    <input type="hidden" name="formTicket<?php echo $attendeeCount;?>" value="<?php echo $ticketId;?>">
                                                                <?php   }
                                                                 $af = 0;
                                                                foreach($customDataField as $customField) {
                                                                    if(($customField['fieldlevel'] == 'event' && !in_array($ticketId, $addonArray)) || ($collectMultipleAttendeeInfo == 1 && $customField['fieldlevel'] == 'ticket')) {
                                                                        $mandatoryClass = '';
                                                                        $trimmedFieldName = str_replace(" ", "", preg_replace("/[^A-Za-z0-9\s\s]/", "", $customField['fieldname']));
                                                                        $fieldId = $customField['id'];
                                                                        $fieldName = $trimmedFieldName.$attendeeCount;


                                                                        $noDisplayField = '';
                                                                        $courierFreeClass = '';
                                                                        if($courierFee == 1 && in_array($customField['commonfieldid'], $courierFeeFieldsArray)){
                                                                            $noDisplayField = "style='display:none'";
                                                                            $courierFreeClass = "courierFeeBlocks";
                                                                        }
 
                                                                        ?>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?=$courierFreeClass; ?>" <?=$noDisplayField; ?>>
                                                                            <div class="form-group">
                                                                                <input type="hidden" name="formTicket<?php echo $attendeeCount;?>" value="<?php echo $ticketId;?>">
                                                                                <?php
                                                                                $multipleValueFieldArr = array('dropdown','radio','checkbox');

                                                                                if(((in_array($customField['fieldtype'],$multipleValueFieldArr) && count($customField['customFieldValues'][$fieldId]) > 0) || !in_array($customField['fieldtype'],$multipleValueFieldArr)) && (($geoLocalityDisplay == 1 && !in_array($trimmedFieldName,$hiddenLocationArray) || $geoLocalityDisplay == 0))) {

                                                                                    $lengthenable = '';
                                                                                    $maxlength = $minlength = 0;
                                                                                    if($customField['maxlengthenable']) {
                                                                                        $lengthenable = "lengthenable";
                                                                                        $maxlength = ($customField['maxlength'] > 0)? $customField['maxlength']: 0;
                                                                                    }

                                                                                    if($customField['minlengthenable']) {
                                                                                        $lengthenable = "lengthenable";
                                                                                        $minlength = ($customField['minlength'] > 0)? $customField['minlength']: 0;
                                                                                    }
                                                                                    ?>
                                                                                    <label for="exampleInputtext1"><?php echo $customField['fieldname'];
                                                                                        if($customField['fieldmandatory']) { ?>
                                                                                            <span style='color:red'>*</span>
                                                                                            <?php
                                                                                            $mandatoryClass = 'mandatory_class';
                                                                                        } ?>
                                                                                    </label> 
                                                                                    <span style="font-size: 11px;"><?php if(!empty($customField['fieldDescription'])){
                                                                            echo '(' .$customField['fieldDescription'] .')';
                                                                        }?></span>
                                                                                <?php }
                                                                                /* Label for the first Geo Location enabled field */
                                                                                elseif($localityCount == 0 && $geoLocalityDisplay == 1) {
                                                                                    ?>
                                                                                    <label for="exampleInputtext1"><?php echo $trimmedFieldName;
                                                                                        if($localityMandatory) { ?>
                                                                                            <span style='color:red'>*</span>
                                                                                            <?php
                                                                                            $mandatoryClass = 'mandatory_class';
                                                                                        } ?>
                                                                                    </label>
                                                                                    <span style="font-size: 11px;"><?php if(!empty($customField['fieldDescription'])){
                                                                            echo '(' .$customField['fieldDescription'] .')';
                                                                        }?></span>
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                                <?php if($customField['fieldtype'] == 'textarea') { ?>

                                                                                    <?php if((isset($userData[$trimmedFieldName]) && $userData[$trimmedFieldName] != '' && $attendeeCount == 1) || count($indexedAttendeedetailList)>0) { ?>
                                                                                        <textarea class="form-control customValidationClass <?php echo $mandatoryClass.' '.$lengthenable;?>"
                                                                                                  name="<?php echo $fieldName;?>" id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"
                                                                                                  data-customFieldId="<?php echo $customField['id'];?>"
                                                                                                  data-originalName="<?php echo $customField['fieldname'];?>"
                                                                                                  restriction-maxlength = "<?php echo $maxlength;?>"
                                                                                                  restriction-minlength = "<?php echo $minlength;?>"
                                                                                                  data-customvalidation="<?php echo $customField['customvalidation'];?>" ticketid="<?php echo $ticketId;?>"><?php echo count($indexedAttendeedetailList)>0?$indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]:trim($userData[$trimmedFieldName]);?></textarea>
                                                                                    <?php } else { ?>
                                                                                        <textarea class="form-control customValidationClass <?php echo $mandatoryClass.' '.$lengthenable;?>"
                                                                                                  name="<?php echo $fieldName;?>" id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"
                                                                                                  data-customFieldId="<?php echo $customField['id'];?>"
                                                                                                  data-originalName="<?php echo $customField['fieldname'];?>"
                                                                                                  restriction-maxlength = "<?php echo $maxlength;?>"
                                                                                                  restriction-minlength = "<?php echo $minlength;?>"
                                                                                                  data-customvalidation="<?php echo $customField['customvalidation'];?>"  ticketid="<?php echo $ticketId;?>"></textarea>
                                                                                    <?php } ?>
                                                                                <?php } elseif($customField['fieldtype'] == 'textbox') { ?>

                                                                                    <?php if($geoLocalityDisplay == 0 || ($geoLocalityDisplay == 1 && !in_array($trimmedFieldName,$hiddenLocationArray))) { ?>

                                                                                        <input type="text" class="form-control customValidationClass <?php echo $mandatoryClass.' '.$lengthenable;; if($trimmedFieldName=='MobileNo'){ echo ' mobileNoFlags';}?>"
                                                                                               name="<?php echo $fieldName;?>"
                                                                                               id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"
                                                                                               data-customFieldId="<?php echo $customField['id'];?>"
                                                                                               data-originalName="<?php echo $customField['fieldname'];?>"
                                                                                               restriction-maxlength = "<?php echo $maxlength;?>"
                                                                                               restriction-minlength = "<?php echo $minlength;?>"
                                                                                               data-customvalidation="<?php echo $customField['customvalidation'];?>"  ticketid="<?php echo $ticketId;?>"
                                                                                               value="<?php if(count($indexedAttendeedetailList)>0) echo $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount];elseif(isset($userData[$trimmedFieldName]) && $userData[$trimmedFieldName] != '' && $attendeeCount == 1)
                                                                                                   echo $userData[$trimmedFieldName];?>" <?php if($af==0){?> autofocus <?php }?> >
                                                                                        <?php /*if($trimmedFieldName=='MobileNo'){?>
                                                                                               <span style="margin-bottom:20px;"><?php echo MESSAGE_COUNTRYCODE_NOTE;?></span>
                                                                                               <?php } */?>

                                                                                        <!-- If the Locality field enebled then hiding the Country, State, City fields starts here -->
                                                                                    <?php } elseif($geoLocalityDisplay == 1 && in_array($trimmedFieldName,$hiddenLocationArray)) { ?>
                                                                                        
                                                                                        <?php
                                                                                        if($trimmedFieldName == 'Country')
                                                                                        {
                                                                                            ?>

                                                                                            <select id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>" data-originalName="<?php echo $customField['fieldname'];?>" name="<?php echo $fieldName;?>" class="form-control valid mandatory_class ">
                                                                                                <option value="">Select</option><option value="Afganistan">Afghanistan</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antigua & Barbuda">Antigua & Barbuda</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belarus">Belarus</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bonaire">Bonaire</option><option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option><option value="Botswana">Botswana</option><option value="Brazil">Brazil</option><option value="British Indian Ocean Ter">British Indian Ocean Ter</option><option value="Brunei">Brunei</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Canada">Canada</option><option value="Canary Islands">Canary Islands</option><option value="Cape Verde">Cape Verde</option><option value="Cayman Islands">Cayman Islands</option><option value="Central African Republic">Central African Republic</option><option value="Chad">Chad</option><option value="Channel Islands">Channel Islands</option><option value="Chile">Chile</option><option value="China">China</option><option value="Christmas Island">Christmas Island</option><option value="Cocos Island">Cocos Island</option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Congo">Congo</option><option value="Cook Islands">Cook Islands</option><option value="Costa Rica">Costa Rica</option><option value="Cote DIvoire">Cote DIvoire</option><option value="Croatia">Croatia</option><option value="Cuba">Cuba</option><option value="Curaco">Curacao</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Denmark">Denmark</option><option value="Djibouti">Djibouti</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="East Timor">East Timor</option><option value="Ecuador">Ecuador</option><option value="Egypt">Egypt</option><option value="El Salvador">El Salvador</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Ethiopia">Ethiopia</option><option value="Falkland Islands">Falkland Islands</option><option value="Faroe Islands">Faroe Islands</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="France">France</option><option value="French Guiana">French Guiana</option><option value="French Polynesia">French Polynesia</option><option value="French Southern Ter">French Southern Ter</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Germany">Germany</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Great Britain">Great Britain</option><option value="Greece">Greece</option><option value="Greenland">Greenland</option><option value="Grenada">Grenada</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guinea">Guinea</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Hawaii">Hawaii</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="Hungary">Hungary</option><option value="Iceland">Iceland</option><option value="Indonesia">Indonesia</option><option value="India">India</option><option value="Iran">Iran</option><option value="Iraq">Iraq</option><option value="Ireland">Ireland</option><option value="Isle of Man">Isle of Man</option><option value="Israel">Israel</option><option value="Italy">Italy</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Jordan">Jordan</option><option value="Kazakhstan">Kazakhstan</option><option value="Kenya">Kenya</option><option value="Kiribati">Kiribati</option><option value="Korea North">Korea North</option><option value="Korea Sout">Korea South</option><option value="Kuwait">Kuwait</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Laos">Laos</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Lesotho">Lesotho</option><option value="Liberia">Liberia</option><option value="Libya">Libya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Macau">Macau</option><option value="Macedonia">Macedonia</option><option value="Madagascar">Madagascar</option><option value="Malaysia">Malaysia</option><option value="Malawi">Malawi</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marshall Islands">Marshall Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mexico">Mexico</option><option value="Midway Islands">Midway Islands</option><option value="Moldova">Moldova</option><option value="Monaco">Monaco</option><option value="Mongolia">Mongolia</option><option value="Montserrat">Montserrat</option><option value="Morocco">Morocco</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Nambia">Nambia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Netherland Antilles">Netherland Antilles</option><option value="Netherlands">Netherlands (Holland, Europe)</option><option value="Nevis">Nevis</option><option value="New Caledonia">New Caledonia</option><option value="New Zealand">New Zealand</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Norfolk Island">Norfolk Island</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Palau Island">Palau Island</option><option value="Palestine">Palestine</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Phillipines">Philippines</option><option value="Pitcairn Island">Pitcairn Island</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="Republic of Montenegro">Republic of Montenegro</option><option value="Republic of Serbia">Republic of Serbia</option><option value="Reunion">Reunion</option><option value="Romania">Romania</option><option value="Russia">Russia</option><option value="Rwanda">Rwanda</option><option value="St Barthelemy">St Barthelemy</option><option value="St Eustatius">St Eustatius</option><option value="St Helena">St Helena</option><option value="St Kitts-Nevis">St Kitts-Nevis</option><option value="St Lucia">St Lucia</option><option value="St Maarten">St Maarten</option><option value="St Pierre & Miquelon">St Pierre & Miquelon</option><option value="St Vincent & Grenadines">St Vincent & Grenadines</option><option value="Saipan">Saipan</option><option value="Samoa">Samoa</option><option value="Samoa American">Samoa American</option><option value="San Marino">San Marino</option><option value="Sao Tome & Principe">Sao Tome & Principe</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Senegal">Senegal</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Singapore">Singapore</option><option value="Slovakia">Slovakia</option><option value="Slovenia">Slovenia</option><option value="Solomon Islands">Solomon Islands</option><option value="Somalia">Somalia</option><option value="South Africa">South Africa</option><option value="Spain">Spain</option><option value="Sri Lanka">Sri Lanka</option><option value="Sudan">Sudan</option><option value="Suriname">Suriname</option><option value="Swaziland">Swaziland</option><option value="Sweden">Sweden</option><option value="Switzerland">Switzerland</option><option value="Syria">Syria</option><option value="Tahiti">Tahiti</option><option value="Taiwan">Taiwan</option><option value="Tajikistan">Tajikistan</option><option value="Tanzania">Tanzania</option><option value="Thailand">Thailand</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad & Tobago">Trinidad & Tobago</option><option value="Tunisia">Tunisia</option><option value="Turkey">Turkey</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks & Caicos Is">Turks & Caicos Is</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="United Kingdom">United Kingdom</option><option value="Ukraine">Ukraine</option><option value="United Arab Erimates">United Arab Emirates</option><option value="United States of America">United States of America</option><option value="Uraguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Vatican City State">Vatican City State</option><option value="Venezuela">Venezuela</option><option value="Vietnam">Vietnam</option><option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option><option value="Virgin Islands (USA)">Virgin Islands (USA)</option><option value="Wake Island">Wake Island</option><option value="Wallis & Futana Is">Wallis & Futana Is</option><option value="Yemen">Yemen</option><option value="Zaire">Zaire</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option>
                                                                                            </select>
                                                                                            
                                                                                            <?php
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            ?>
                                                                                        <input type="text" class="form-control customValidationClass <?php echo $mandatoryClass.' '.$lengthenable; if($trimmedFieldName=='MobileNo'){ echo ' mobileNoFlags';}?>"
                                                                                               name="<?php echo $fieldName;?>"
                                                                                               id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"
                                                                                               data-customFieldId="<?php echo $customField['id'];?>"
                                                                                               data-originalName="<?php echo $customField['fieldname'];?>"
                                                                                               restriction-maxlength = "<?php echo $maxlength;?>"
                                                                                               restriction-minlength = "<?php echo $minlength;?>"
                                                                                               data-customvalidation="<?php echo $customField['customvalidation'];?>" ticketid="<?php echo $ticketId;?>"
                                                                                               value="<?php if(count($indexedAttendeedetailList)>0) echo $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]; elseif($attendeeCount == 1) echo $userData[$trimmedFieldName];?>" <?php if($af==0){?> autofocus <?php }?>>
                                                                                        <?php /*if($trimmedFieldName=='MobileNo'){?>
                                                                                               <span style="margin-bottom:20px;"><?php echo MESSAGE_COUNTRYCODE_NOTE;?></span>
                                                                                               <?php } */?>
                                                                                         <?php
                                                                                            }
                                                                                            ?>

                                                                                    <?php } ?>
                                                                                    <!-- If the Locality field enebled then hiding the Country, State, City fields ends here -->

                                                                                <?php } elseif($customField['fieldtype'] == 'date') { ?>

                                                                                    <input type="text" readonly class="form-control customValidationClass <?php echo $mandatoryClass;?> form-datepicker"
                                                                                           name="<?php echo $fieldName;?>" id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"
                                                                                           data-customFieldId="<?php echo $customField['id'];?>"
                                                                                           data-originalName="<?php echo $customField['fieldname'];?>"
                                                                                           data-customvalidation="<?php echo $customField['customvalidation'];?>" ticketid="<?php echo $ticketId;?>"
                                                                                           value="<?php echo count($indexedAttendeedetailList)>0?$indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]:'';?>"
                                                                                        <?php
                                                                                        if ($customField['minlengthenable'] || $customField['maxlengthenable']) {
                                                                                            if ($customField['minlengthenable']) {
                                                                                                if ($customField['minlength'] > 0) {
                                                                                                    $maxDate = date('m/d/Y', strtotime("-" . $customField['minlength'] . " year", time()));
                                                                                                } else {
                                                                                                    $maxDate = date('m/d/Y');
                                                                                                }
                                                                                                ?>
                                                                                                data-maxdate="<?= $maxDate; ?>"
                                                                                                <?php
                                                                                            }
                                                                                            if ($customField['maxlengthenable'] && $customField['maxlength'] > 0) {
                                                                                                $minDate = date('m/d/Y', strtotime("-" . $customField['maxlength'] . " year", time()));
                                                                                                ?>
                                                                                                data-mindate="<?= $minDate; ?>"
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    >

                                                                                <?php } elseif($customField['fieldtype'] == 'dropdown' && count($customField['customFieldValues'][$fieldId]) > 0) { ?>

                                                                                    <select class="form-control customValidationClass <?php echo $mandatoryClass;?>"
                                                                                            name="<?php echo $fieldName;?>" id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"
                                                                                            data-customFieldId="<?php echo $fieldId;?>"
                                                                                            data-originalName="<?php echo $customField['fieldname'];?>"
                                                                                            data-customvalidation="<?php echo $customField['customvalidation'];?>" ticketid="<?php echo $ticketId;?>" >
                                                                                        <option value=''>Select</option>
                                                                                        <?php foreach($customField['customFieldValues'][$fieldId] as $customFieldValueArr) { ?>
                                                                                            <option value="<?php echo $customFieldValueArr['value'];?>" <?php  if(count($indexedAttendeedetailList)>0 && isset($indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]) && $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]==$customFieldValueArr['value']) echo 'selected="selected"'; elseif($customFieldValueArr['isdefault'] == 1) echo 'selected="selected"';?>>
                                                                                                <?php echo $customFieldValueArr['value'];?>
                                                                                            </option>
                                                                                        <?php } ?>
                                                                                    </select>

                                                                                <?php } elseif($customField['fieldtype'] == 'file') { ?>

                                                                                    <input type="file"  data-originalName="<?php echo $customField['fieldname'];?>" class="custom-file-input customValidationClass <?php echo $mandatoryClass;?>" name="<?php echo $fieldName;?>" id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"  data-customFieldId="<?php echo $fieldId;?>">

                                                                                <?php } elseif($customField['fieldtype'] == 'radio' && count($customField['customFieldValues'][$fieldId]) > 0) { ?>

                                                                                    <div>
                                                                                        <?php foreach($customField['customFieldValues'][$fieldId] as $customFieldValueArr) { ?>
                                                                                            <label class="widget-checkbox">
                                                                                                <input value="<?php echo $customFieldValueArr['value'];?>" type="radio" class="customValidationClass <?php echo $mandatoryClass;?>" name="<?php echo $fieldName;?>" id="<?php echo $trimmedFieldName.'_'.$attendeeCount.'_'.$customFieldValueArr['id'];?>" <?php echo ($customFieldValueArr['isdefault'] == 1) ? 'checked="checked"' : '';?> data-customFieldId="<?php echo $fieldId;?>"
                                                                                                       data-customvalidation="<?php echo $customField['customvalidation'];?>"
                                                                                                       data-originalName="<?php echo $customField['fieldname'];?>" ticketid="<?php echo $ticketId;?>"   <?php  echo (count($indexedAttendeedetailList)>0 && isset($indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]) && $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]==$customFieldValueArr['value'])?'checked="checked"':'';  ?>
                                                                                                >
                                                                                                <?php echo $customFieldValueArr['value'];?>
                                                                                            </label>
                                                                                        <?php } ?>
                                                                                    </div>

                                                                                <?php } elseif($customField['fieldtype'] == 'checkbox' && count($customField['customFieldValues'][$fieldId]) > 0) { ?>

                                                                                    <div>
                                                                                        <?php foreach($customField['customFieldValues'][$fieldId] as $customFieldValueArr) { ?>
                                                                                            <label class="widget-checkbox">
                                                                                                <input value="<?php echo  $customFieldValueArr['value'];?>" type="checkbox" class="customValidationClass <?php echo $mandatoryClass;?>" name="<?php echo $fieldName;?>[]" id="<?php echo $trimmedFieldName.'_'.$attendeeCount.'_'.$customFieldValueArr['id'];?>" <?php if(count($indexedAttendeedetailList)>0 && isset($indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]) && in_array($customFieldValueArr['value'], explode(',', $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]))) echo 'checked="checked"'; elseif($customFieldValueArr['isdefault'] == 1) echo 'checked="checked"';?> data-customFieldId="<?php echo $fieldId;?>" data-ticketid="<?php echo $ticketId;?>" data-originalName="<?php echo $customField['fieldname'];?>">
                                                                                                <?php echo  $customFieldValueArr['value'];?>
                                                                                            </label>
                                                                                        <?php } ?>
                                                                                    </div>

                                                                                <?php } ?>
                                                                                <span class="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>Err"></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php   }
                                                                    $af++;
                                                                } ?>
                                                                <!-- Custom Fields ends here -->
                                                                <?php 
                                                                if(!empty($gstCustomFields) && !$gstblockCreated){
                                                                    $dataIds = array_column($gstCustomFields, 'id', 'fieldname');
                                                                    ?>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="form-group">
                                                                        <p>
                                                                            <label class="customlable-t">
                                                                                <input value="1" type="checkbox" class="customValidationClass  gstclass valid" name="CheckBox1[]" id="CheckBox_1_1" data-customfieldid="0" data-originalname="CheckBox" onClick="showGSTDetails(this)">
                                                                                Do you need a GST Invoice (Optional)
                                                                            </label>
                                                                        </p>
                                                                        <span class="CheckBox_1Err"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="form-group gstvalueclass">
                                                                        <label for="exampleInputtext1">Company Name</label>
                                                                        <input type="text" class="form-control customValidationClass" name="CompanyNameGST_1" id="CompanyNameGST_1" data-customfieldid="<?php echo $dataIds['Company Name']?>" data-originalname="Company Name" restriction-maxlength="0" restriction-minlength="0" data-customvalidation="" ticketid="<?php echo $ticketId;?>" value="">

                                                                        <span class="CompanyNameGST_1Err"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="form-group gstvalueclass">
                                                                        <label for="exampleInputtext1">Company Address</label>
                                                                        <textarea class="form-control customValidationClass" name="CompanyAddressGST_1" id="CompanyAddressGST_1" data-customfieldid="<?php echo $dataIds['Company Address']?>" data-originalname="Company Address" restriction-maxlength="0" restriction-minlength="0" data-customvalidation="" ticketid="<?php echo $ticketId;?>"></textarea>
                                                                        <span class="CompanyNameGST_1Err"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="form-group gstvalueclass">
                                                                        <label for="exampleInputtext1">GST Number</label>
                                                                        <input type="text" class="form-control gstnumberclass customValidationClass" name="GSTNumberGST_1" id="GSTNumberGST_1" data-customfieldid="<?php echo $dataIds['GST Number']?>" data-originalname="GST Number" restriction-maxlength="15" restriction-minlength="15" data-customvalidation="" ticketid="<?php echo $ticketId;?>" value="" minlength="15" maxlength="15">
                                                                        <span class="CompanyAddressGST_1Err"></span>
                                                                    </div>
                                                                </div>
                                                                    <?php $gstblockCreated = true;
                                                                }?>
                                                            </div>
                                                            <?php
                                                            $attendeeCount++;
                                                            $localityCount = 0;
                                                        }
                                                        if($collectMultipleAttendeeInfo == 0) {
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </form>
                                                <div class="wizard-footer w-mb20">
                                                    <div class="pull-right">
                                                        <?php  if($calculationDetails['totalPurchaseAmount'] > 0 ) {
                                                            if($eventSettings['stagedevent'] == 1 && $eventSettings['paymentstage'] == 2){
                                                                ?>
                                                                <a href="javascript:void(0)" style="<?php if ($bookNowBtnColor != '') echo 'background:' . '#' . $bookNowBtnColor . ';'; ?>" class="paynow button button-next button-fill nextstep button-wd">
                                                                    <?php echo $eventData['bookButtonValue']; ?></a>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <a id="attendeedetailsform" <?php if(!empty($GPTW_EVENTS_ARRAY[$eventData['id']])) { ?> style="display:none;" <?php } ?>  nextstep="yes" href="javascript:void(0)" style="<?php if ($bookNowBtnColor != '') echo 'background:' . '#' . $bookNowBtnColor . ';'; ?>" class="paynow button button-next button-fill nextstep button-wd">
                                                                    Proceed</a>
                                                            <?php } }else{ ?>
                                                            <a href="javascript:void(0)" style="<?php if ($bookNowBtnColor != '') echo 'background:' . '#' . $bookNowBtnColor . ';'; ?>" class="paynow button button-next button-fill nextstep button-wd">
                                                                <?php echo $eventData['bookButtonValue']; ?></a>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>        
                                         <?php if($courierFee == '1'){ ?>
                                            <div class="col-xs-12 mbottom50 text-success">
                                                <h4><b><?php echo COURIER_NOTE; ?></b></h4>
                                            </div>
                                        <?php } ?>
                                        </div>
                                        <div class="row" id="ticket_pane_tab3" <?php if(isset($tb) && $tb=='details'){ ?>style="display: none;" <?php } ?>>
                                            <?php if(isset($widgetSettings[DISPLAY_SUMMARY_IN_PAYMENT]) && $widgetSettings[DISPLAY_SUMMARY_IN_PAYMENT]=='yes'){ ?>
                                                <div class="widget-discountcontainer book calucationsDiv" style="">

                                                    <!--Price Split Start-->
                                                    <div class="col-lg-12 col-md-12 col-sm-12 zeroPadd">
                                                        <div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                <p class="col-lg-6 col-md-6 col-xs-6 widget-tleft">Ticket</p>
                                                                <p class="col-lg-3 col-md-3 col-xs-3 widget-tright"> Qty</p>
                                                                <p class="col-lg-3 col-md-3 col-xs-3 widget-tright">Price</p>
                                                            </div>
                                                        </div>
                                                        <?php foreach ($calculationDetails['ticketsData'] as $cdkey => $cdvalue) { ?>
                                                            <div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                    <p class="col-lg-6 col-md-6 col-xs-6 widget-tleft"><?php echo $cdvalue['ticketName'];?></p>
                                                                    <p class="col-lg-3 col-md-3 col-xs-3 widget-tright"> <?php echo $cdvalue['selectedQuantity'];?></p>
                                                                    <p class="col-lg-3 col-md-3 col-xs-3 widget-tright"> <?php echo $cdvalue['currencyCode']." ".$cdvalue['ticketPrice'];?></p>
                                                                </div>
                                                            </div>
                                                        <?php   } ?>
                                                    </div>
                                                    <!--Price Split Start-->

                                                    <div class="widget-totalamountdiv col-lg-8 col-md-8 col-sm-8 zeroPadd pull-right">
                                                        <div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Amount</p>
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="total_amount"><span>:</span> <?php echo $calculationDetails['currencyCode'].' '.$calculationDetails['totalTicketAmount'];?></p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        // Code discount and bulk discount will be considered as "Discount"
                                                        $totalCodeBulkDiscount = $calculationDetails['totalCodeDiscount']+$calculationDetails['totalBulkDiscount'];
                                                        $totalCashback = $calculationDetails['totalCodeCashBack'];
                                                        if($totalCodeBulkDiscount > 0) { ?>
                                                            <div id="bulkDiscountTbl">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Discount</p>
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="bulkDiscount_amount"><span>:</span>  <?php echo $calculationDetails['currencyCode'].' '.$totalCodeBulkDiscount;?></p>
                                                                </div>
                                                            </div>
                                                        <?php }

                                                        $totalReferralDiscount = $calculationDetails['totalReferralDiscount'];
                                                        if($totalReferralDiscount > 0) { ?>
                                                            <div id="discountTbl">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Referral Discount</p>
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="discount_amount"><?php echo $calculationDetails['currencyCode'].' '.$totalReferralDiscount;?></p>
                                                                </div>
                                                            </div>
                                                        <?php } if($totalCashback > 0){?>
                                                            <div id="discountTbl">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Cashback</p>
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="cashback_amount"><?php echo $calculationDetails['currencyCode'].' '.$totalCashback;?></p>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div id="taxesDiv">
                                                            <?php
                                                            if(isset($calculationDetails['totalTaxDetails']) && count($calculationDetails['totalTaxDetails']) > 0) {
                                                                foreach($calculationDetails['totalTaxDetails'] as $taxData) { ?>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                        <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><?php echo $taxData['label'].' ('.$taxData['value'].'%)';?></p>
                                                                        <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright"><span>:</span><?php echo $calculationDetails['currencyCode'].' '.$taxData['taxAmount'];?></p>
                                                                    </div>
                                                                <?php   }
                                                            } ?>

                                                        </div>

                                                        <div id="extraChargeTbl" style="display: block;">
                                                            <?php if(is_array($calculationDetails['extraCharge']) && count($calculationDetails['extraCharge']) > 0) { ?>

                                                                <?php foreach($calculationDetails['extraCharge'] as $extraCharge) {
                                                                    if($extraCharge['totalAmount'] > 0) {
                                                                        ?>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><?php echo $extraCharge['label'];?></p>
                                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright"><span>:</span><?php echo $calculationDetails['currencyCode'].' '.$extraCharge['totalAmount'];?></p>
                                                                        </div>
                                                                    <?php } } ?>
                                                            <?php } ?>
                                                        </div>

                                                        <div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><b>Total Amount</b></p>
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="purchase_total"><b><span>:</span> <?php echo $calculationDetails['currencyCode'].' '.$calculationDetails['totalPurchaseAmount'];?></b></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                            <?php if(count($eventGateways) > 0) { ?>
                                                <?php if($calculationDetails['totalPurchaseAmount'] > 0) { ?>
                                                    <?php
                                                    if(isset($mywallet)){
                                                        //print_r($mywallet);
                                                        ?>
                                                        <!--My Wallet Section-->
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-xs-12 widget-payment-offers">

                                                                <?php
                                                                $checkedKey=0;
                                                                $keySet=false;
                                                                foreach($eventGateways as $key=>$gateway) {
                                                                    if(!empty($gateway['gatewaytext'])){
                                                                        if(!$keySet){
                                                                            $checkedKey = $gateway['paymentgatewayid'];
                                                                            $keySet = true;
                                                                        }
                                                                        echo stripslashes($gateway['gatewaytext']);
                                                                    }
                                                                    if($gateway['isdefault'] > 0) {
                                                                        $checkedKey = $gateway['paymentgatewayid'];
                                                                        $keySet=true;
                                                                    }
                                                                } ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-lg-12 col-md-12 col-xs-12 merawallet-payment-holder">

                                                                <p class="wizard-gatewaytext">
                                                                    <label>
                                                    <span>
                                                    <input type="radio" name="paymentGateway" value="mywallet" id="<?php echo $mywallet['gatewayKey']; ?>">
                                                    </span>
                                                                        <b>Pay through MeraWallet</b>
                                                                    </label>
                                                                </p>
                                                                <p class="merawallet-balance">
                                                                    <span style="color: #1ba064;">Your Wallet Balance : <b>INR <?php echo $mywallet['avialablebalance']; ?></b></span>
                                                                    <span style="color: #ff6600;">Remaining Amount to Pay : <b>INR <?php echo $remainingToPay; ?></b></span>

                                                                </p>
                                                                <p class="merawallet-poweredby">
                                                                    <img src="<?php echo $this->config->item('images_static_path'); ?>poweredby-udio.png" height="60px" />
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!--My Wallet Section-->



                                                        <?php
                                                    } } }
                                            ?>
                                            <div class="row">
                                                <div class="col-sm-12 wizard-paymentgateways">
                                                    <?php if(count($eventGateways) > 0) { ?>
                                                        <?php if($calculationDetails['totalPurchaseAmount'] > 0) { ?>

                                                            <?php


                                                            $ebsGateway = $ebsKey = 0;
                                                            $paytmGateway = $paytmKey = 0;
                                                            $paypalGateway = $paypalKey = 0;
                                                            $mobikwikGateway = $mobikwikKey = 0;
                                                            $selectPaypal = FALSE;
                                                            ?>
                                                            <?php
                                                            foreach($eventGateways as $key=>$gateway) {
                                                                $gatewayName = strtolower($gateway['gatewayName']);
                                                                $gatewayKey = $gateway['paymentgatewayid'];
                                                                $gatewayDescription = $gateway['description'];
                                                                $gatewayFunction = $gateway['functionname'];
                                                                $gatewayImage = $gateway['imageid'];
                                                                $radioCheckedText = 'checked="checked"';
                                                                if($eventSettings['stagedevent'] == 1 && $eventSettings['paymentstage'] == 2){
                                                                    $gatewayFunction = $radioCheckedText = '';

                                                                }
                                                                
                                                                if(($gateway['selected'] == 1 && in_array($gatewayFunction, array('paypal','paypalinr'))) || ($calculationDetails['currencyCode'] != 'INR' && in_array($gatewayFunction, array('paypal','paypalinr'))) && $eventSettings['seating'] == FALSE && $otherCurrencyGatewaySelected == 0){
                                                                    $selectPaypal = TRUE;
                                                                }

                                                                ?>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wizard-gatewayholder">
                                                                    <p class="wizard-gatewaytext">
                                                                        <label>
                                                        <span>
                                                            <input type="radio" id="<?php echo $gatewayKey;?>" name="paymentGateway" value="<?php echo $gatewayFunction;?>" <?php if(($gateway['selected'] == 1) || ($calculationDetails['currencyCode'] == 'USD' && $gatewayFunction == 'paypal') ){ echo $radioCheckedText; }?>>
                                                        </span>
                                                                            <span id="<?php echo $gatewayFunction;?>_text"><?php echo $gatewayDescription;?></span>
                                                                        </label>
                                                                    </p>
                                                                    <div class="gateway-imgholder">
                                                                        <a href="javascript:;" class="paymentButton" id="<?php echo strtoupper($gatewayFunction);?>">
                                                                            <img src="<?php echo $gatewayImage;?>" />
                                                                        </a>
                                                                    </div>
                                                                </div>


                                                            <?php } ?>

                                                <?php
                                                if(!empty($GPTW_EVENTS_ARRAY[$eventData['id']]))
                                                {
                                                            ?>
                                                            
                                                            <div class="col-sm-12 width100 paymentmode-holder marginbottom10">
                                                            <label class="text-left">
                                                                <label>
                                                                    <input type="radio" id="25" name="paymentGateway" value="offline">
                                                                    <p class="PG-New-ImgHodler">
                                                                        Offline
                                                                    </p>
                                                                    <p class="PG-NewText" id="amazonpay_text"></p>
                                                                </label>
                                                            </label>
                                                        </div>
                                                <?php
                                                }
                                                ?>


                                                        <?php } ?>
                                                        <?php $paypalCheck = array_column($eventGateways,'gatewayName'); ?>
                                                        <div class="wizard-footer widgetwidthinlnie w-mb20">
                                                            <div class="pull-right">
                                                                <?php if ($eventData['id'] == 229080) { ?>
                                                                <p style="color: red; margin-bottom: 0px">Your payment confirmation will be from Versant Online Solutions our group company</p>
                                                                <?php } 
                                                    
                                        ?>
                                    
                                                     <a id="paynow" href="javascript:void(0)" style="float: right;<?php if ($bookNowBtnColor != '') echo 'background:' . '#' . $bookNowBtnColor . ';'; ?><?php if($selectPaypal == TRUE){ ?>display:none;<?php } ?>" class="button button-next button-fill nextstep button-wd" >
                                                                    <?php echo $eventData['bookButtonValue']; ?></a>
                                                                    <?php if(in_array('paypal', $paypalCheck) || in_array('paypalinr', $paypalCheck)){ ?> 
                                                                    <div id="paypal-button-container" class="paynowbtn margintop20" <?php if($selectPaypal == FALSE){ ?>style="display:none"<?php } ?>></div>
                                                                    <?php } ?>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php foreach($eventGateways as $key=>$gateway) {
                                                        $gatewayName = strtolower($gateway['gatewayName']);
                                                        $gatewayKey = $gateway['paymentgatewayid'];
                                                        $gatewayDescription = $gateway['description'];
                                                        $gatewayFunction = $gateway['functionname'];
                                                        $gatewayImage = $gateway['imageid'];
                                                        $actionUrl=site_url('payment/'.$gatewayFunction.'Prepare');
                                                        if($gatewayName=='paytm'){
                                                            $actionUrl=site_url('payment/'.$gatewayFunction.'Select');
                                                        }
                                                        ?>
                                                        <form name="<?php echo $gatewayFunction;?>_frm" id="<?php echo $gatewayFunction;?>_frm" action="<?php echo $actionUrl;?>" method='POST' <?php if($gatewayFunction=='phonepe' || $gatewayFunction=='ebs' ){ ?> target="_top" <?php }?>>
                                                            <input type="hidden" name="eventTitle" value="<?php echo preg_replace("/[^A-Za-z0-9]/","", stripslashes($eventData['title']))?>" />
                                                            <input type="hidden" name="orderId" value="<?php echo $orderLogId; ?>" />
                                                            <input type="hidden" name="paymentGatewayKey" value="<?php echo $gatewayKey; ?>" />
                                                            <input type="hidden" name="samepage" value="<?php echo $samepage; ?>" />
                                                            <input type="hidden" name="nobrand" value="<?php echo $nobrand; ?>" />
                                                            <?php if($gatewayFunction=='paypal' || $gatewayFunction=='phonepe'){ ?>
                                                                <input type="hidden" name="themefields" value="<?php echo $themeFieldsUrl.$widgetThirdPartyUrl; ?>" />
                                                            <?php }
                                                            elseif ($gatewayFunction=='paytm') { ?>
                                                                <input type="hidden" name="themefields" value="<?php echo $themeFieldsUrlForPaytm; ?>" />
                                                            <?php }elseif($gatewayFunction=='ebs'){ ?>
                                                                <input type="hidden" name="themefields" value="<?php echo $themeFieldsUrlForEBS; ?>" />
                                                            <?php  }else{ ?>
                                                                <input type="hidden" name="themefields" value="<?php echo $themeFieldsUrl; ?>" />
                                                            <?php } ?>
                                                            <input type="hidden" name="primaryAddress" class="primaryAddress" id="primaryAddress" value="<?php if(isset($primaryAddress) && $primaryAddress != '') echo $primaryAddress;?>">
                                                        </form>

                                                    <?php }  
                                ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php } ?>
                    </div>
                    <!-- wizard container -->
                </div>
            </div>
            <!-- row -->
        </div>
        <!--  big container -->
    </div>
</div>
<script type="text/javascript">
    var utilsIntlNum ="<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>";
    var customValidationEventIds = "<?php echo json_encode($customValidationEventIds);?>";
    customValidationEventIds = $.parseJSON(customValidationEventIds);
</script>
<script type="text/javascript">
        if(typeof($.fn.intlTelInput)!=='undefined'){
            var countryDataJson = $.fn.intlTelInput.getCountryData();
        }
        else{
            var countryDataJson = getCustomCountryData();
        }
    var countryName = "<?php echo $eventData['location']['countryName'] ?>", str='';
    var intlCountrycode = '';
    for (var i = 0, len = countryDataJson.length; i < len; i++) {
        str = countryDataJson[i].name;
        if(str.indexOf('(') > 0){
            str = str.substring(0, (str.indexOf('(')-1));
        }
        if(countryName == str){
            intlCountrycode = countryDataJson[i].iso2;
            continue;
        }
    }
    //If incase intlTelInput.getCountryData failed to get data then use below.
    function getCustomCountryData()
    {
        //Below country data is taken from intlTelInput.getCountryData function.
        var countryDataJson = [ [ "Afghanistan (‫افغانستان‬‎)", "af", "93" ], [ "Albania (Shqipëri)", "al", "355" ], [ "Algeria (‫الجزائر‬‎)", "dz", "213" ], [ "American Samoa", "as", "1684" ], [ "Andorra", "ad", "376" ], [ "Angola", "ao", "244" ], [ "Anguilla", "ai", "1264" ], [ "Antigua and Barbuda", "ag", "1268" ], [ "Argentina", "ar", "54" ], [ "Armenia (Հայաստան)", "am", "374" ], [ "Aruba", "aw", "297" ], [ "Australia", "au", "61", 0 ], [ "Austria (Österreich)", "at", "43" ], [ "Azerbaijan (Azərbaycan)", "az", "994" ], [ "Bahamas", "bs", "1242" ], [ "Bahrain (‫البحرين‬‎)", "bh", "973" ], [ "Bangladesh (বাংলাদেশ)", "bd", "880" ], [ "Barbados", "bb", "1246" ], [ "Belarus (Беларусь)", "by", "375" ], [ "Belgium (België)", "be", "32" ], [ "Belize", "bz", "501" ], [ "Benin (Bénin)", "bj", "229" ], [ "Bermuda", "bm", "1441" ], [ "Bhutan (འབྲུག)", "bt", "975" ], [ "Bolivia", "bo", "591" ], [ "Bosnia and Herzegovina (Босна и Херцеговина)", "ba", "387" ], [ "Botswana", "bw", "267" ], [ "Brazil (Brasil)", "br", "55" ], [ "British Indian Ocean Territory", "io", "246" ], [ "British Virgin Islands", "vg", "1284" ], [ "Brunei", "bn", "673" ], [ "Bulgaria (България)", "bg", "359" ], [ "Burkina Faso", "bf", "226" ], [ "Burundi (Uburundi)", "bi", "257" ], [ "Cambodia (កម្ពុជា)", "kh", "855" ], [ "Cameroon (Cameroun)", "cm", "237" ], [ "Canada", "ca", "1", 1, [ "204", "226", "236", "249", "250", "289", "306", "343", "365", "387", "403", "416", "418", "431", "437", "438", "450", "506", "514", "519", "548", "579", "581", "587", "604", "613", "639", "647", "672", "705", "709", "742", "778", "780", "782", "807", "819", "825", "867", "873", "902", "905" ] ], [ "Cape Verde (Kabu Verdi)", "cv", "238" ], [ "Caribbean Netherlands", "bq", "599", 1 ], [ "Cayman Islands", "ky", "1345" ], [ "Central African Republic (République centrafricaine)", "cf", "236" ], [ "Chad (Tchad)", "td", "235" ], [ "Chile", "cl", "56" ], [ "China (中国)", "cn", "86" ], [ "Christmas Island", "cx", "61", 2 ], [ "Cocos (Keeling) Islands", "cc", "61", 1 ], [ "Colombia", "co", "57" ], [ "Comoros (‫جزر القمر‬‎)", "km", "269" ], [ "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)", "cd", "243" ], [ "Congo (Republic) (Congo-Brazzaville)", "cg", "242" ], [ "Cook Islands", "ck", "682" ], [ "Costa Rica", "cr", "506" ], [ "Côte d’Ivoire", "ci", "225" ], [ "Croatia (Hrvatska)", "hr", "385" ], [ "Cuba", "cu", "53" ], [ "Curaçao", "cw", "599", 0 ], [ "Cyprus (Κύπρος)", "cy", "357" ], [ "Czech Republic (Česká republika)", "cz", "420" ], [ "Denmark (Danmark)", "dk", "45" ], [ "Djibouti", "dj", "253" ], [ "Dominica", "dm", "1767" ], [ "Dominican Republic (República Dominicana)", "do", "1", 2, [ "809", "829", "849" ] ], [ "Ecuador", "ec", "593" ], [ "Egypt (‫مصر‬‎)", "eg", "20" ], [ "El Salvador", "sv", "503" ], [ "Equatorial Guinea (Guinea Ecuatorial)", "gq", "240" ], [ "Eritrea", "er", "291" ], [ "Estonia (Eesti)", "ee", "372" ], [ "Ethiopia", "et", "251" ], [ "Falkland Islands (Islas Malvinas)", "fk", "500" ], [ "Faroe Islands (Føroyar)", "fo", "298" ], [ "Fiji", "fj", "679" ], [ "Finland (Suomi)", "fi", "358", 0 ], [ "France", "fr", "33" ], [ "French Guiana (Guyane française)", "gf", "594" ], [ "French Polynesia (Polynésie française)", "pf", "689" ], [ "Gabon", "ga", "241" ], [ "Gambia", "gm", "220" ], [ "Georgia (საქართველო)", "ge", "995" ], [ "Germany (Deutschland)", "de", "49" ], [ "Ghana (Gaana)", "gh", "233" ], [ "Gibraltar", "gi", "350" ], [ "Greece (Ελλάδα)", "gr", "30" ], [ "Greenland (Kalaallit Nunaat)", "gl", "299" ], [ "Grenada", "gd", "1473" ], [ "Guadeloupe", "gp", "590", 0 ], [ "Guam", "gu", "1671" ], [ "Guatemala", "gt", "502" ], [ "Guernsey", "gg", "44", 1 ], [ "Guinea (Guinée)", "gn", "224" ], [ "Guinea-Bissau (Guiné Bissau)", "gw", "245" ], [ "Guyana", "gy", "592" ], [ "Haiti", "ht", "509" ], [ "Honduras", "hn", "504" ], [ "Hong Kong (香港)", "hk", "852" ], [ "Hungary (Magyarország)", "hu", "36" ], [ "Iceland (Ísland)", "is", "354" ], [ "India (भारत)", "in", "91" ], [ "Indonesia", "id", "62" ], [ "Iran (‫ایران‬‎)", "ir", "98" ], [ "Iraq (‫العراق‬‎)", "iq", "964" ], [ "Ireland", "ie", "353" ], [ "Isle of Man", "im", "44", 2 ], [ "Israel (‫ישראל‬‎)", "il", "972" ], [ "Italy (Italia)", "it", "39", 0 ], [ "Jamaica", "jm", "1876" ], [ "Japan (日本)", "jp", "81" ], [ "Jersey", "je", "44", 3 ], [ "Jordan (‫الأردن‬‎)", "jo", "962" ], [ "Kazakhstan (Казахстан)", "kz", "7", 1 ], [ "Kenya", "ke", "254" ], [ "Kiribati", "ki", "686" ], [ "Kosovo", "xk", "383" ], [ "Kuwait (‫الكويت‬‎)", "kw", "965" ], [ "Kyrgyzstan (Кыргызстан)", "kg", "996" ], [ "Laos (ລາວ)", "la", "856" ], [ "Latvia (Latvija)", "lv", "371" ], [ "Lebanon (‫لبنان‬‎)", "lb", "961" ], [ "Lesotho", "ls", "266" ], [ "Liberia", "lr", "231" ], [ "Libya (‫ليبيا‬‎)", "ly", "218" ], [ "Liechtenstein", "li", "423" ], [ "Lithuania (Lietuva)", "lt", "370" ], [ "Luxembourg", "lu", "352" ], [ "Macau (澳門)", "mo", "853" ], [ "Macedonia (FYROM) (Македонија)", "mk", "389" ], [ "Madagascar (Madagasikara)", "mg", "261" ], [ "Malawi", "mw", "265" ], [ "Malaysia", "my", "60" ], [ "Maldives", "mv", "960" ], [ "Mali", "ml", "223" ], [ "Malta", "mt", "356" ], [ "Marshall Islands", "mh", "692" ], [ "Martinique", "mq", "596" ], [ "Mauritania (‫موريتانيا‬‎)", "mr", "222" ], [ "Mauritius (Moris)", "mu", "230" ], [ "Mayotte", "yt", "262", 1 ], [ "Mexico (México)", "mx", "52" ], [ "Micronesia", "fm", "691" ], [ "Moldova (Republica Moldova)", "md", "373" ], [ "Monaco", "mc", "377" ], [ "Mongolia (Монгол)", "mn", "976" ], [ "Montenegro (Crna Gora)", "me", "382" ], [ "Montserrat", "ms", "1664" ], [ "Morocco (‫المغرب‬‎)", "ma", "212", 0 ], [ "Mozambique (Moçambique)", "mz", "258" ], [ "Myanmar (Burma) (မြန်မာ)", "mm", "95" ], [ "Namibia (Namibië)", "na", "264" ], [ "Nauru", "nr", "674" ], [ "Nepal (नेपाल)", "np", "977" ], [ "Netherlands (Nederland)", "nl", "31" ], [ "New Caledonia (Nouvelle-Calédonie)", "nc", "687" ], [ "New Zealand", "nz", "64" ], [ "Nicaragua", "ni", "505" ], [ "Niger (Nijar)", "ne", "227" ], [ "Nigeria", "ng", "234" ], [ "Niue", "nu", "683" ], [ "Norfolk Island", "nf", "672" ], [ "North Korea (조선 민주주의 인민 공화국)", "kp", "850" ], [ "Northern Mariana Islands", "mp", "1670" ], [ "Norway (Norge)", "no", "47", 0 ], [ "Oman (‫عُمان‬‎)", "om", "968" ], [ "Pakistan (‫پاکستان‬‎)", "pk", "92" ], [ "Palau", "pw", "680" ], [ "Palestine (‫فلسطين‬‎)", "ps", "970" ], [ "Panama (Panamá)", "pa", "507" ], [ "Papua New Guinea", "pg", "675" ], [ "Paraguay", "py", "595" ], [ "Peru (Perú)", "pe", "51" ], [ "Philippines", "ph", "63" ], [ "Poland (Polska)", "pl", "48" ], [ "Portugal", "pt", "351" ], [ "Puerto Rico", "pr", "1", 3, [ "787", "939" ] ], [ "Qatar (‫قطر‬‎)", "qa", "974" ], [ "Réunion (La Réunion)", "re", "262", 0 ], [ "Romania (România)", "ro", "40" ], [ "Russia (Россия)", "ru", "7", 0 ], [ "Rwanda", "rw", "250" ], [ "Saint Barthélemy (Saint-Barthélemy)", "bl", "590", 1 ], [ "Saint Helena", "sh", "290" ], [ "Saint Kitts and Nevis", "kn", "1869" ], [ "Saint Lucia", "lc", "1758" ], [ "Saint Martin (Saint-Martin (partie française))", "mf", "590", 2 ], [ "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "pm", "508" ], [ "Saint Vincent and the Grenadines", "vc", "1784" ], [ "Samoa", "ws", "685" ], [ "San Marino", "sm", "378" ], [ "São Tomé and Príncipe (São Tomé e Príncipe)", "st", "239" ], [ "Saudi Arabia (‫المملكة العربية السعودية‬‎)", "sa", "966" ], [ "Senegal (Sénégal)", "sn", "221" ], [ "Serbia (Србија)", "rs", "381" ], [ "Seychelles", "sc", "248" ], [ "Sierra Leone", "sl", "232" ], [ "Singapore", "sg", "65" ], [ "Sint Maarten", "sx", "1721" ], [ "Slovakia (Slovensko)", "sk", "421" ], [ "Slovenia (Slovenija)", "si", "386" ], [ "Solomon Islands", "sb", "677" ], [ "Somalia (Soomaaliya)", "so", "252" ], [ "South Africa", "za", "27" ], [ "South Korea (대한민국)", "kr", "82" ], [ "South Sudan (‫جنوب السودان‬‎)", "ss", "211" ], [ "Spain (España)", "es", "34" ], [ "Sri Lanka (ශ්‍රී ලංකාව)", "lk", "94" ], [ "Sudan (‫السودان‬‎)", "sd", "249" ], [ "Suriname", "sr", "597" ], [ "Svalbard and Jan Mayen", "sj", "47", 1 ], [ "Swaziland", "sz", "268" ], [ "Sweden (Sverige)", "se", "46" ], [ "Switzerland (Schweiz)", "ch", "41" ], [ "Syria (‫سوريا‬‎)", "sy", "963" ], [ "Taiwan (台灣)", "tw", "886" ], [ "Tajikistan", "tj", "992" ], [ "Tanzania", "tz", "255" ], [ "Thailand (ไทย)", "th", "66" ], [ "Timor-Leste", "tl", "670" ], [ "Togo", "tg", "228" ], [ "Tokelau", "tk", "690" ], [ "Tonga", "to", "676" ], [ "Trinidad and Tobago", "tt", "1868" ], [ "Tunisia (‫تونس‬‎)", "tn", "216" ], [ "Turkey (Türkiye)", "tr", "90" ], [ "Turkmenistan", "tm", "993" ], [ "Turks and Caicos Islands", "tc", "1649" ], [ "Tuvalu", "tv", "688" ], [ "U.S. Virgin Islands", "vi", "1340" ], [ "Uganda", "ug", "256" ], [ "Ukraine (Україна)", "ua", "380" ], [ "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)", "ae", "971" ], [ "United Kingdom", "gb", "44", 0 ], [ "United States", "us", "1", 0 ], [ "Uruguay", "uy", "598" ], [ "Uzbekistan (Oʻzbekiston)", "uz", "998" ], [ "Vanuatu", "vu", "678" ], [ "Vatican City (Città del Vaticano)", "va", "39", 1 ], [ "Venezuela", "ve", "58" ], [ "Vietnam (Việt Nam)", "vn", "84" ], [ "Wallis and Futuna", "wf", "681" ], [ "Western Sahara (‫الصحراء الغربية‬‎)", "eh", "212", 1 ], [ "Yemen (‫اليمن‬‎)", "ye", "967" ], [ "Zambia", "zm", "260" ], [ "Zimbabwe", "zw", "263" ], [ "Åland Islands", "ax", "358", 1 ] ];
        // loop over all of the countries above
        for (var i = 0; i < countryDataJson.length; i++) {
            var c = countryDataJson[i];
            countryDataJson[i] = {
                name: c[0],
                iso2: c[1],
                dialCode: c[2],
                priority: c[3] || 0,
                areaCodes: c[4] || null
            };
        }
        return countryDataJson;
    }
</script>
<script>
    window.onload = function(e){
        if(intlCountrycode != '' && intlCountrycode != 'in' && $(".mobileNoFlags").eq(0).val()==''){
            $(".mobileNoFlags").each(function (index, value) {
                var currentElement = $(this);
                if(currentElement.val() == "")
                    currentElement.intlTelInput("setCountry", intlCountrycode);
            });
        }
    }
</script>
<?php if(isset($configCustomDatemsg[$eventId])){?>
    <script type="text/javascript">

        var weekendTickets ="<?php echo json_encode($configspecialTickets['weekends']);?>";
        var weekdayTickets ="<?php echo json_encode($configspecialTickets['weekdays']);?>";
        weekendTickets= $.parseJSON(weekendTickets);
        weekdayTickets = $.parseJSON(weekdayTickets);

    </script>
<?php }?>
<script type="text/javascript">
    var stagedevent = "<?php echo $eventSettings['stagedevent'];?>";
    var paymentstage = "<?php echo $eventSettings['paymentstage'];?>";
    var signupStagedStatus = 1;
    var booking_saveData ='<?php echo commonHelperGetPageUrl('api_bookingSaveData');?>';
    var api_citySearch = '<?php echo commonHelperGetPageUrl('api_citySearch');?>';
    var api_stateSearch = '<?php echo commonHelperGetPageUrl('api_stateSearch');?>';
    var api_countrySearch = '<?php echo commonHelperGetPageUrl('api_countrySearch');?>';
    var api_eventPromoCodes='<?php echo commonHelperGetPageUrl('api_eventPromoCodes');?>';
    var totalSaleTickets='<?php echo $calculationDetails['totalTicketQuantity'];?>';
    var api_getTinyUrl = "";
    var totalPurchaseAmount = "<?php echo $calculationDetails['totalPurchaseAmount'];?>";
    var customValidationMessage = "<?php echo $customValidationMessage; ?>";
</script>
<?php
include_once APPPATH.'views/includes/elements/mywallet_js.php';


foreach($eventGateways as $key=>$gateway) {
    if($gateway['functionname'] == 'paypalinr'){
            $gateway['functionname'] = 'paypal';
        }
    if(in_array($gateway['functionname'],array('stripe','razorpay','paypal','ingenico')) && $calculationDetails['totalPurchaseAmount'] > 0){
        if(isset($gateway['environment'])){
            $paypalGatewayEnvironment = $gateway['environment'];
        }
        include_once APPPATH.'views/payment/'.$gateway['functionname'].'_prepare.php';
    }
}
?>



<script type="text/javascript">
function update_gst_state(gst_number)
{
    var state_code = gst_number.substring(0, 2);
    $("#pur_state").val(state_code);
    return true;
}
                                    /* Fee Handling Show/Hide */
                                    $(document).ready(function(){
                                       
                                        <?php if(array_key_exists($eventId, GPTW_EVENTS_ARRAY)){ ?>
                                        
                                        $("div[class^='wid_registration_field_group_']").hide();
                                        $("#paymentSectionH2").hide();
                                        $("#paymentSectionDiv").hide();
                                        $("#paymentSectionBtn").hide();
                                        <?php } ?>
                                        
                                        $("#savep").click(function(){
                                            var eventId = $("#eventId").val();
                                            is_valid_purchaser_form = true;
                                            <?php if(array_key_exists($eventId, GPTW_EVENTS_ARRAY)){ ?>
                                            // is_valid_purchaser_form = purchaser_form_validation();
                                            $('[id^=pur_]').each(function() {
                                                if(this.value == '')
                                                {
                                                    is_valid_purchaser_form = false;
                                                    $(this).addClass("error");
                                                    $(this).attr("data-originalname");
                                                    $(this).next().html("Please enter "+$(this).attr("data-originalname"));
                                                    $(this).next().addClass( "error" );
                                                }
                                            });
                                            if(document.getElementById("pur_agree_tnc").checked == false)
                                            {
                                                alert("Please accept terms and conditions.");
                                                is_valid_purchaser_form = false;
                                            }
                                            <?php } ?>
                                            if(is_valid_purchaser_form == true)
                                            {
                                                $("div[class^='purchaser_form_div']").hide();
                                                $("#savep").hide();
                                                $("#paymentSectionH2").show();
                                                $("#paymentSectionDiv").show();
                                                $("#paymentSectionBtn").show();
                                                $("#attendeedetailsform").show();
                                                $("div[class^='wid_registration_field_group_']").show();
                                            }
                                            else{
                                                return false;
                                            }
                                        });

                                    });
               </script>

<script language="javascript">
$(document).ready(function() { 
    $("input[id^='City_']").each(function() {
        this.value = '';
    });
});
</script>
