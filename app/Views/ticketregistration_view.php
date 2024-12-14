<div class="page-container">
    <div class="wrap">
        <div class="container">
            <!-- Main component for a primary marketing message or call to action -->
            <?php   if(!isset($samepage)){
                include_once('includes/elements/event_detail_top.php');
            }
            function discardingExtraCommas($string){
                $keywords = preg_split("/[\s,]+/", $string);
                $filterd = array_filter($keywords);
                return implode(",",$filterd);

            }

            $GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY;
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
            ?>
            <!--Step2-->
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
                <div class="innerPageContainer">
                    <h2 class="pageTitle">Registration Information</h2>
                    <div class="row">
                        <div class="col-md-8">

                            <div id="booking_message_div" style="color: red;">
                                <?php
                                $sessionMessage = $this->customsession->getData('booking_message');
                                $this->customsession->unSetData('booking_message');
                                if(($sessionMessage)) {
                                    echo $sessionMessage; ?>
                                    <!--<script>
									var deepLinkURL='<?php //echo DEEP_LINK_ERROR;?>'+'?message='+'<?php //echo $sessionMessage;?>';
								</script> -->
                                <?php   }
                                ?>
                            </div>

                            <div id="errorMessage" style="text-align: center;color: red; display:none;">Oops..! Something went wrong..</div>

                            <div class="row">
                                <?php
                                $formCount = 1;
                                if($collectMultipleAttendeeInfo == 1) {
                                    $formCount = array_sum($ticketData);
                                }
                                ?>
                                <script language="javascript">
                                var ticket_qty_array = <?php echo json_encode($ticketData); ?>;
                                </script>
                                <div class="col-xs-12 regInfo">
                                    <form action="" name="ticket_registration" id="ticket_registration" enctype="multipart/form-data">
                                        <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventData['id'];?>">
                                        <input type="hidden" name="samepage" id="samepage" value="<?php echo $samepage;?>">
                                        <input type="hidden" name="nobrand" id="nobrand" value="<?php echo $nobrand;?>">
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
                                        $ticketData=($normalTickets+$addonData);
                                        $gstblockCreated = $eventSettings['sendinvoice'] ? false : true;
                                        ?>



<?php  
    
    if(!empty($GPTW_EVENTS_ARRAY[$eventData['id']]))
    {
        ?>
                                <div class="purchaser_form_div">
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
                                            <input type="text" class="form-control" name="pur_gst" id="gst" onchange="return update_gst_state(this.value)" data-originalname="GST Number" restriction-maxlength="0" restriction-minlength="0" value="">
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
                                                <input value="1" type="checkbox" name="pur_agree_tnc" id="pur_agree_tnc" class="customValidationClass mandatory_class valid" data-originalname="Terms and Conditions"><span></span><span style="color:red">*</span>
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
              ?>
                                        <?php
                                        
                                        foreach($ticketData as $ticketId => $ticketCount) {
                                            if($collectMultipleAttendeeInfo == 0) {
                                                $ticketCount = $formCount;
                                            }
                                            for($i=1 ; $i <= $ticketCount ; $i++) {?>
                                                <div class="registration_field_group_<?php echo $attendeeCount;?>">

                                                    <?php if($formCount > 1 && !in_array($ticketId, $addonArray)) { ?>
                                                        <h4><?php echo $calculationDetails['ticketsData'][$ticketId]['ticketType'] == 'donation' ? 'Donor Details' : 'Attendee ' . $attendeeCount; ?>
                                                            <?php if($collectMultipleAttendeeInfo == 1) {?>
                                                                (Ticket: <?php echo $calculationDetails['ticketsData'][$ticketId]['ticketName'];?>)
                                                            <?php } ?>
                                                        </h4>
                                                        <hr>
                                                    <?php }elseif($addonTicketLevelFields && in_array($ticketId, $addonArray) && $addonTextNotShown){
                                                        $addonTextNotShown=false;
                                                        echo '<h4>Add-on Items</h4>';
                                                    }
                                                    /*if($addonTicketLevelFields && in_array($ticketId, $addonArray)) {
                                                        ?>
                                                            (Ticket: <?php echo $calculationDetails['ticketsData'][$ticketId]['ticketName'];?>)
                                                        <?php
                                                    }*/
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


                                                    foreach($customDataField as $customField) {
                                                        if(($customField['fieldlevel'] == 'event' && !in_array($ticketId, $addonArray)) || ($collectMultipleAttendeeInfo == 1 && $customField['fieldlevel'] == 'ticket')) {
                                                            $mandatoryClass = '';
                                                            $trimmedFieldName = str_replace(" ", "", preg_replace("/[^A-Za-z0-9\s\s]/", "", $customField['fieldname']));
                                                            $fieldId = $customField['id'];
                                                            $fieldName = $trimmedFieldName.$attendeeCount;
                                                            $commonFieldId = $customField['commonfieldid'];

                                                            $noDisplayField = '';
                                                            $courierFreeClass = '';
                                                            
                                                            if($courierFee == 1 && in_array($commonFieldId, $courierFeeFieldsArray)){
                                                                $noDisplayField = "style='display:none'";
                                                                $courierFreeClass = "courierFeeBlocks";
                                                            }
                                                            

                                                            ?>
                                                            <div class="form-group <?=$courierFreeClass; ?>" <?=$noDisplayField; ?>>
                                                                <input type="hidden" name="formTicket<?php echo $attendeeCount;?>" value="<?php echo $ticketId;?>">
                                                                
                                                        <?php
                                                            
                                                            if($attendee_heading_flag == 0 && (empty($GPTW_EVENTS_ARRAY[$eventData['id']]) === false))
                                                            {
                                                                $attendee_heading_flag = 1;
                                                        ?>
                                                                <h4>Attendee Details</h4>
                                                        <?php
                                                            }
                                                        ?>
                                                                
                                                                
                                                                <?php
                                                                $multipleValueFieldArr = array('dropdown','radio','checkbox');
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
                                                               
                                                                if(((in_array($customField['fieldtype'],$multipleValueFieldArr) && count($customField['customFieldValues'][$fieldId]) > 0) || !in_array($customField['fieldtype'],$multipleValueFieldArr)) && (($geoLocalityDisplay == 1 && !in_array($trimmedFieldName,$hiddenLocationArray) || $geoLocalityDisplay == 0))) { ?>
                                                                    <label style="width: 100%" for="exampleInputtext1">
                                                                        <?php
                                                                        if($customField['fieldname'] == 'Email Id'){
                                                                            echo "Email Address";
                                                                        }else{
                                                                            echo $customField['fieldname'];
                                                                        }
                                                                        if($customField['fieldmandatory']) { ?>
                                                                            <span style='color:red'>*</span>
                                                                            <?php
                                                                            $mandatoryClass = 'mandatory_class';
                                                                        } ?>
                                                                        <span style="font-size: 11px;"><?php if(!empty($customField['fieldDescription'])){
                                                                            echo '(' .$customField['fieldDescription'] .')';
                                                                        }?></span>
                                                                    </label>
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
                                                                        <span style="font-size: 11px;"><?php if(!empty($customField['fieldDescription'])){
                                                                            echo '(' .$customField['fieldDescription'] .')';
                                                                        }?></span>
                                                                    </label>
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

                                                                        <input type="text" <?php echo ($attendeeCount == 1 && $customField['fieldname'] == 'Full Name') ? 'autofocus' : '';?> <?php if($eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2){ ?> readonly <?php } ?> class="form-control customValidationClass <?php echo $mandatoryClass.' '.$lengthenable; if($trimmedFieldName=='MobileNo'){ echo ' mobileNoFlags';}?>"
                                                                               name="<?php echo $fieldName;?>"
                                                                               id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"
                                                                               data-customFieldId="<?php echo $customField['id'];?>"
                                                                               data-originalName="<?php echo $customField['fieldname'];?>"
                                                                               restriction-maxlength = "<?php echo $maxlength;?>"
                                                                               restriction-minlength = "<?php echo $minlength;?>"

                                                                               data-customvalidation="<?php echo $customField['customvalidation'];?>"  ticketid="<?php echo $ticketId;?>"
                                                                               value="<?php if(count($indexedAttendeedetailList)>0) echo $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount];elseif(isset($userData[$trimmedFieldName]) && $userData[$trimmedFieldName] != '' && $attendeeCount == 1)
                                                                                   echo $userData[$trimmedFieldName];?>">


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
                                                                            <input type="text" <?php if($eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2){ ?> readonly <?php } ?> class="form-control customValidationClass <?php echo $mandatoryClass.' '.$lengthenable; if($trimmedFieldName=='MobileNo'){ echo ' mobileNoFlags';}?>"
                                                                                name="<?php echo $fieldName;?>"
                                                                                id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"
                                                                                data-customFieldId="<?php echo $customField['id'];?>"
                                                                                data-originalName="<?php echo $customField['fieldname'];?>"
                                                                                restriction-maxlength = "<?php echo $maxlength;?>"
                                                                                restriction-minlength = "<?php echo $minlength;?>"
                                                                                data-customvalidation="<?php echo $customField['customvalidation'];?>" ticketid="<?php echo $ticketId;?>"
                                                                                value="<?php if(count($indexedAttendeedetailList)>0) echo $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]; elseif($attendeeCount == 1) echo $userData[$trimmedFieldName];?>">
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <?php /*if($trimmedFieldName=='MobileNo'){?>
                                                                                               <span style="margin-bottom:20px;"><?php echo MESSAGE_COUNTRYCODE_NOTE;?></span>
                                                                                               <?php } */?>

                                                                        <!-- In place of Country, placing the Locality field -->


                                                                    <?php } ?>
                                                                    <!-- If the Locality field enebled then hiding the Country, State, City fields ends here -->

                                                                <?php } elseif($customField['fieldtype'] == 'date') { ?>

                                                                    <input type="text" readonly <?php if($eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2){ ?> readonly <?php } ?> class="form-control customValidationClass <?php echo $mandatoryClass;?> form-datepicker"
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

                                                                    <select <?php if($eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2){ ?>  <?php } ?> class="form-control customValidationClass <?php echo $mandatoryClass;?>"
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

                                                                <?php } elseif($customField['fieldtype'] == 'file') {

                                                                    ?>


                                                                    <?php if(isset($oldEventSignupId) && $eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2 && isset($customFieldsFileData[$oldEventSignupId]['customfields'][$fieldId])){?>

                                                                        <input type="hidden" name="old<?php echo $fieldName;?>"  value = "<?php echo $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]; ?>">
                                                                        <a target="_blank" href="<?php echo $customFieldsFileData[$oldEventSignupId]['customfields'][$fieldId]; ?>" >file</a>
                                                                    <?php } ?>

                                                                    <input type="file" <?php if($eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2){ ?> <?php } ?> data-originalName="<?php echo $customField['fieldname'];?>" class="custom-file-input customValidationClass <?php if(isset($oldEventSignupId) && $eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2 && isset($customFieldsFileData[$oldEventSignupId]['customfields'][$fieldId])){ } else { echo $mandatoryClass; }?>" name="<?php echo $fieldName;?>" id="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>"  data-customFieldId="<?php echo $fieldId;?>">

                                                                <?php } elseif($customField['fieldtype'] == 'radio' && count($customField['customFieldValues'][$fieldId]) > 0) { ?>

                                                                    <p>
                                                                        <?php foreach($customField['customFieldValues'][$fieldId] as $customFieldValueArr) { ?>
                                                                            <label class="customlable-r">

                                                                                <input value="<?php echo $customFieldValueArr['value'];?>" type="radio" class="customValidationClass <?php echo $mandatoryClass;?>" name="<?php echo $fieldName;?>" id="<?php echo $trimmedFieldName.'_'.$attendeeCount.'_'.$customFieldValueArr['id'];?>" <?php echo ($customFieldValueArr['isdefault'] == 1) ? 'checked="checked"' : '';?> data-customFieldId="<?php echo $fieldId;?>"
                                                                                       data-customvalidation="<?php echo $customField['customvalidation'];?>"
                                                                                       data-originalName="<?php echo $customField['fieldname'];?>" ticketid="<?php echo $ticketId;?>"   <?php  echo (count($indexedAttendeedetailList)>0 && isset($indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]) && $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]==$customFieldValueArr['value'])?'checked="checked"':'';  ?>
                                                                                    <?php if($eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2){ ?> <?php } ?> >
                                                                                <?php echo $customFieldValueArr['value'];?>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </p>

                                                                <?php } elseif($customField['fieldtype'] == 'checkbox' && count($customField['customFieldValues'][$fieldId]) > 0) { ?>

                                                                    <p>
                                                                        <?php foreach($customField['customFieldValues'][$fieldId] as $customFieldValueArr) { ?>
                                                                            <label class="customlable-t">
                                                                                <input value="<?php echo  $customFieldValueArr['value'];?>" type="checkbox" class="customValidationClass <?php echo $mandatoryClass;?>" name="<?php echo $fieldName;?>[]" id="<?php echo $trimmedFieldName.'_'.$attendeeCount.'_'.$customFieldValueArr['id'];?>" <?php if(count($indexedAttendeedetailList)>0 && isset($indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]) && in_array($customFieldValueArr['value'], explode(',', $indexedAttendeedetailList[$trimmedFieldName][$attendeeCount]))) echo 'checked="checked"'; elseif($customFieldValueArr['isdefault'] == 1) echo 'checked="checked"';?> data-customFieldId="<?php echo $fieldId;?>"  data-ticketid="<?php echo $ticketId;?>"  data-originalName="<?php echo $customField['fieldname'];?>" <?php if($eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2){ ?> <?php } ?> >
                                                                                <?php echo  $customFieldValueArr['value'];?>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </p>

                                                                <?php } ?>
                                                                <span class="<?php echo $trimmedFieldName.'_'.$attendeeCount;?>Err"></span>
                                                            </div>
                                                        <?php   }
                                                    } ?>
                                                    <!-- Custom Fields ends here -->
                                                    <?php 
                                                    if(!empty($gstCustomFields) && !$gstblockCreated){
                                                        $dataIds = array_column($gstCustomFields, 'id', 'fieldname');
                                                        ?>
                                                    <div class="form-group">
                                                        <p>
                                                            <label class="customlable-t">
                                                                <input value="1" type="checkbox" class="customValidationClass gstclass valid" name="CheckBox1[]" id="CheckBox_1_1" data-customfieldid="0" data-originalname="CheckBox" onClick="showGSTDetails(this)">
                                                                Do you need a GST Invoice (Optional)
                                                            </label>
                                                        </p>
                                                        <span class="CheckBox_1Err"></span>
                                                    </div>
                                                    <div class="form-group gstvalueclass">
                                                        <label for="exampleInputtext1">Company Name</label>
                                                        <input type="text" class="form-control customValidationClass" name="CompanyNameGST_1" id="CompanyNameGST_1" data-customfieldid="<?php echo $dataIds['Company Name']?>" data-originalname="Company Name" restriction-maxlength="0" restriction-minlength="0" data-customvalidation="" ticketid="<?php echo $ticketId;?>" value="">

                                                        <span class="CompanyNameGST_1Err"></span>
                                                    </div>
                                                    <div class="form-group gstvalueclass">
                                                        <label for="exampleInputtext1">Company Address</label>
                                                        <textarea class="form-control customValidationClass" name="CompanyAddressGST_1" id="CompanyAddressGST_1" data-customfieldid="<?php echo $dataIds['Company Address']?>" data-originalname="Company Address" restriction-maxlength="0" restriction-minlength="0" data-customvalidation="" ticketid="<?php echo $ticketId;?>"></textarea>
                                                        <span class="CompanyAddressGST_1Err"></span>
                                                    </div>
                                                    <div class="form-group gstvalueclass">
                                                        <label for="exampleInputtext1">GST Number</label>
                                                        <input type="text" class="form-control gstnumberclass customValidationClass" name="GSTNumberGST_1" id="GSTNumberGST_1" data-customfieldid="<?php echo $dataIds['GST Number']?>" data-originalname="GST Number" restriction-maxlength="15" restriction-minlength="15" data-customvalidation="" ticketid="<?php echo $ticketId;?>" value="" minlength="15" maxlength="15">
                                                        <span class="GSTNumberGST_1Err"></span>
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
                                </div>

                                <?php if($courierFee == '1'){ ?>
                                <div class="col-xs-12 mbottom50 text-success">
                                    <h4><b><?php echo COURIER_NOTE; ?></b></h4>
                                </div>
                                <?php } ?>

                                <?php if(count($eventGateways) > 0) {
                                    $showPaymentGateways = true;
                                    if($eventSettings['paymentstage'] == 2) {
                                        $showPaymentGateways = false;
                                    }
                                    $signupStagedStatus = 1;

                                    if($eventSettings['paymentstage'] == 2 && isset($eventSignupData['stagedStatus']) && $eventSignupData['stagedStatus'] == 2){
                                        $signupStagedStatus = 2;
                                        $showPaymentGateways = true;
                                    }

                                    ?>

                                    <?php if($calculationDetails['totalPurchaseAmount'] > 0 && $showPaymentGateways ) { ?>
                                        <h2 id = 'paymentSectionH2' class="pageTitle">Proceed to pay using</h2>
                                        <!-- <p> <b> Note: Currently UPI payments are facing technical issues. Avoid UPI payments.</b></p> -->
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
                                            if($gateway['functionname']=='stripe' && $gateway['selected'] == 1){
                                                $otherCurrencyGatewaySelected = 1;
                                            }
                                        } ?>
                                        <div id = "paymentSectionDiv" class="col-xs-12 paymentmode-section1">

                                            <?php
                                            if(isset($mywallet)){
                                                //print_r($mywallet);
                                                ?>
                                                <!--My Wallet Section-->
                                                <div class="col-sm-12 paymentmode-holder holder-wallet mywallet-payment">
                                                    <p class="text-left">
                                                        <label>
                                                            <input type="radio" name="paymentGateway" value="mywallet" id="<?php echo $mywallet['gatewayKey']; ?>">
                                                            <label>Pay through MeraWallet</label>
                                                        </label>
                                                    </p>
                                                    <p class="mywallet-balance-text">
                                                        Your Wallet Balance : <b>INR <?php echo $mywallet['avialablebalance']; ?></b>
                                                        &nbsp;&nbsp; | &nbsp;&nbsp;
                                                        Remaining Amount to Pay : <b>INR <?php echo $remainingToPay; ?></b>

                                                    </p>
                                                    <p>&nbsp;</p>
                                                    <p style="text-align:left;"><img src="<?php echo $this->config->item('images_static_path'); ?>poweredby-udio.png" height="60px" /></p>
                                                </div>
                                                <!--My Wallet Section-->



                                                <?php
                                            }
                                            ?>

                                            <?php
                                            $ebsGateway = $ebsKey = 0;
                                            $paytmGateway = $paytmKey = 0;
                                            $paypalGateway = $paypalKey = 0;
                                            $mobikwikGateway = $mobikwikKey = 0;
                                            $selectPaypal = FALSE;
                                            ?>
                                            <?php
                                            $gateWaysCount = count($eventGateways);
                                            foreach($eventGateways as $key=>$gateway) {
                                                $gatewayName = strtolower($gateway['gatewayName']);
                                                $gatewayKey = $gateway['paymentgatewayid'];
                                                $gatewayDescription = $gateway['description'];
                                                $gatewayFunction = $gateway['functionname'];
                                                $gatewayImage = $gateway['imageid'];
                                                if(($gateway['selected'] == 1 && in_array($gatewayFunction, array('paypal','paypalinr'))) || ($calculationDetails['currencyCode'] != 'INR' && in_array($gatewayFunction, array('paypal','paypalinr'))) && $eventSettings['seating'] == FALSE && $otherCurrencyGatewaySelected == 0){
                                                    $selectPaypal = TRUE;
                                                }
                                                ?>



                                                <!--New Payment Gateway-->
                                                <div class="col-sm-12 width100 paymentmode-holder marginbottom10">
                                                    <label class="text-left">
                                                        <label>
                                                            <input type="radio" id="<?php echo $gatewayKey;?>" name="paymentGateway" value="<?php echo $gatewayFunction;?>" <?php if(($gateway['selected'] == 1) || ($calculationDetails['currencyCode'] != 'INR' && $gatewayFunction == 'paypal' && $otherCurrencyGatewaySelected == 0) || $gateWaysCount ==1 ){echo 'checked="checked"';}?>><label id="<?php echo $gatewayFunction;?>_text">
                                                            </label>
                                                            <p class="PG-New-ImgHodler">
                                                                <img src="<?php echo $gatewayImage;?>" />
                                                            </p>
                                                            <p class="PG-NewText" id="<?php echo $gatewayFunction;?>_text"><?php echo $gatewayDescription;?>
                                                            </p>
                                                        </label>
                                                </div>
                                                <!--New Payment Gateway-->


                                            <?php } 
                                            
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



                                        </div>
                                    <?php } ?>
                                    <?php $paypalCheck = array_column($eventGateways,'gatewayName');?>
                                    <div id="paymentSectionBtn" class="PayNow-Holder">
                                        <a id="paynow" href="javascript:void(0)" class="btn commonBtn login paynowbtn" <?php if($selectPaypal == TRUE){ ?>style="display:none"<?php } ?> >
                                            <?php echo $eventData['bookButtonValue']; ?></a>
                                        <?php if(in_array('paypal', $paypalCheck) || in_array('paypalinr', $paypalCheck)){ ?> 
                                        <div id="paypal-button-container" class="paynowbtn margintop20" <?php if($selectPaypal == FALSE){ ?>style="display:none"<?php } ?>></div>
                                        <?php } ?>
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
                                    <form name="<?php echo $gatewayFunction;?>_frm" id="<?php echo $gatewayFunction;?>_frm" action="<?php echo $actionUrl;?>" method='POST'>
                                        <input type="hidden" name="eventTitle" value="<?php echo preg_replace("/[^A-Za-z0-9]/","", stripslashes($eventData['title']))?>" />
                                        <input type="hidden" name="orderId" value="<?php echo $orderLogId; ?>" />
                                        <input type="hidden" name="paymentGatewayKey" value="<?php echo $gatewayKey; ?>" />
                                        <input type="hidden" name="samepage" value="<?php echo $samepage; ?>" />
                                        <input type="hidden" name="nobrand" value="<?php echo $nobrand; ?>" />
                                        <input type="hidden" name="primaryAddress" class="primaryAddress" id="primaryAddress" value="<?php if(isset($primaryAddress) && $primaryAddress != '') echo $primaryAddress;?>">
                                    </form>

                                <?php } ?>

                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">

                            <?php
                            $editeventurl = $eventData['eventUrl'];
                            if($calculationDetails['totalPurchaseAmount'] == 0) {
                                $calculationDetails['currencyCode'] = '';
                            }
                            if(isset($referralcode)) {
                                $reffCode = $referralcode;
                                if(strpos($eventData['eventUrl'], '?')== true){
                                    $editeventurl = $eventData['eventUrl']."&reffCode=".$reffCode;
                                }else{
                                    $editeventurl = $eventData['eventUrl']."?reffCode=".$reffCode;
                                }
                            }
                            if(isset($promotercode)) {
                                $ucode = $promotercode;
                                if(strpos($eventData['eventUrl'], '?')== true){
                                    $editeventurl = $eventData['eventUrl']."&ucode=".$ucode;
                                }else{
                                    $editeventurl = $eventData['eventUrl']."?ucode=".$ucode;
                                }
                            }
                            if(isset($acode)) {
                                if(strpos($eventData['eventUrl'], '?')== true){
                                    $editeventurl = $eventData['eventUrl']."&acode=".$acode;
                                }else{
                                    $editeventurl = $eventData['eventUrl']."?acode=".$acode;
                                }
                            }
                            if(!isset($samepage)){
                                ?>
                                <script type="text/javascript">
                                    /* Fee Handling Show/Hide */
                                    $(document).ready(function(){
                                        $(".handlingfeescontainer").hide();

                                        $(".handlingfees").click(function(){
                                            $(".handlingfeescontainer").slideToggle('fast');
                                            $(this).find('i').toggleClass('icon2-plus icon2-minus')
                                        });
                                        <?php if(array_key_exists($eventId, GPTW_EVENTS_ARRAY)){ ?>
                                        $("div[class^='registration_field_group_']").hide();
                                        $("#paymentSectionH2").hide();
                                        $("#paymentSectionDiv").hide();
                                        $("#paymentSectionBtn").hide();
                                        <?php } ?>
                                        $("#savep").click(function(){
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
                                                $("div[class^='registration_field_group_']").show();
                                            }
                                            else{
                                                return false;
                                            }
                                        });

                                    });
                                </script>



                                <div class="summarySec">
                                    <div class="sumBlog">
                                        <span class="imgOverlay"></span>
                                        <?php
                                        if(isset($eventData['thumbnailPath']) && $eventData['thumbnailPath'] != '') { ?>
                                        <img src="<?php echo $eventData['thumbnailPath'];?>" alt="<?php echo $eventData['title'];?>" title="<?php echo $eventData['title'];?>" onError="this.src='<?php echo $eventData['defaultthumbnailPath']; ?>'; this.onerror = null">
                                    <?php } ?>
                                    <span class="titles">Payment Summary</span>
                                </div>
                                <div class="summaryDetail">
                                    <p class="floatL">Event Id : <?php echo (isset($masterEventId) && $masterEventId > 0)?$masterEventId.'<br>Date: '.allTimeFormats($eventData['startDate'], 3):$eventData['id'];?></p>
                                    <a href="<?php echo $editeventurl;?>" class="floatR backBg" title="Edit Your Order"><span class="icon-edit"></span></a>
                                </div>


                                    <div class="ticketSummary">
                                        <span>No of Tickets<p id="ticketQnty"><?php echo $calculationDetails['totalTicketQuantity'];?></p></span>



                                        <div class="coupon">
                                            <div class="totalamt-div2">
                                                <span>Amount</span>
                                                <span>
                                                <?php echo $calculationDetails['currencyCode'].' '.$calculationDetails['totalTicketAmount'];?>
                                                </span>
                                                </span>
                                            </div>
                                            <?php
                                            // Code discount and bulk discount will be considered as "Discount"
                                            $totalCodeBulkDiscount = $calculationDetails['totalCodeDiscount']+$calculationDetails['totalBulkDiscount'];
                                            if($totalCodeBulkDiscount > 0 && !$calculationDetails['isMeraeventsDiscount']) { ?>
                                                <div>
                                                    <span>Discount</span>
                                                    <span>
                                                        <?php echo $calculationDetails['currencyCode'].' '.$totalCodeBulkDiscount;?>
                                                    </span>
                                                </div>
                                            <?php }

                                            $totalReferralDiscount = $calculationDetails['totalReferralDiscount'];
                                            if($totalReferralDiscount > 0) { ?>
                                                <div>
                                                    <span>Referral Discount</span>
                                                    <span>
                                                        <?php echo $calculationDetails['currencyCode'].' '.$totalReferralDiscount;?>
                                                    </span>
                                                </div>
                                            <?php } ?>

                                            <?php

                                            if(isset($calculationDetails['totalTaxDetails']) && count($calculationDetails['totalTaxDetails']) > 0) {
                                                foreach($calculationDetails['totalTaxDetails'] as $taxData){
                                                    $eventsignuptaxtotal[$taxData['label']] += $taxData['taxAmount'];
                                                }
                                            }

                                            if(isset($calculationDetails['totalTaxDetails']) && count($calculationDetails['totalTaxDetails']) > 0) {
                                                foreach($eventsignuptaxtotal as $label => $value) { ?>
                                                    <div>
                                                        <span><?php echo $label;?></span>
                                                        <span>
                                                        <?php echo $calculationDetails['currencyCode'].' '.$value;?>
                                                    </span></div>
                                                <?php   }
                                            } ?>


                                            <!--Internet Handling Fee Start-->
                                            <?php
                                            $internetextracharge=0;
                                            if(is_array($calculationDetails['extraCharge']) && count($calculationDetails['extraCharge']) > 0) { ?>

                                                <?php foreach($calculationDetails['extraCharge'] as $extraCharge) {
                                                    if($extraCharge['totalAmount'] > 0) {
                                                        $internetextracharge+=$extraCharge['totalAmount'];
                                                    } } ?>
                                            <?php }
                                            $internetextracharge=$internetextracharge+$calculationDetails['totalInternetHandlingAmount']
                                            ?>
                                            <?php if(isset($courierCharge) && $courierCharge > 0){?>
                                                <div class="totalamt-div2">
                                                    <span><?php echo $courierFeeLabel;?></span>
                                                    <span>
                                                    <?php echo $calculationDetails['currencyCode'].' '.$courierCharge;?>
                                                    </span>
                                                    </span>
                                                </div>
                                            <?php } ?>
                                            <?php if($internetextracharge > 0){?>
                                                <div class="regpage-feehandlingdiv handlingfees">
                                                    <?php echo HANDLING_FEE_LABEL;?> <i class="icon2-plus"></i>
                                                    <div class="regpage-feehandling-amount"> <?php echo $calculationDetails['currencyCode'].' '.$internetextracharge;?></div>
                                                </div>
                                            <?php } ?>
                                            <div class="regpage-feehandlingdivcontainer handlingfeescontainer">
                                                <!-- Displaying the extra charge -->
                                                <?php if(is_array($calculationDetails['extraCharge']) && count($calculationDetails['extraCharge']) > 0) { ?>

                                                    <?php foreach($calculationDetails['extraCharge'] as $extraCharge) {
                                                        if($extraCharge['totalAmount'] > 0) {
                                                            ?>
                                                            <div>
                                                                <span><?php echo $extraCharge['label'];?></span>
                                                                <span>
                                                            <?php echo $calculationDetails['currencyCode'].' '.$extraCharge['totalAmountWithoutGst'];?>
                                                        </span>
                                                            </div>
                                                        <?php } } ?>
                                                <?php } ?>
                                                <?php if(isset($calculationDetails['totalInternetHandlingAmount']) && $calculationDetails['totalInternetHandlingAmount']>0){ ?>
                                                    <div>
                                                        <span><?php echo $handlingFeeLable;?></span>
                                                        <span>
                                                            <?php echo $calculationDetails['currencyCode'].' '.$calculationDetails['totalInternetHandlingAmountWithoutGst'];?>
                                                        </span>
                                                    </div>
                                                <?php } ?>
                                                <?php if(isset($calculationDetails['totalInternetHandlingOnlyGstAmount']) && $calculationDetails['totalInternetHandlingOnlyGstAmount']>0){ ?>
                                                    <div>
                                                        <span><?php echo HANDLING_FEE_GST_LABEL;?></span>
                                                        <span>
                                                            <?php echo $calculationDetails['currencyCode'].' '.$calculationDetails['totalInternetHandlingOnlyGstAmount'];?>
                                                        </span>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <!--Internet Handling Fee End-->
                                            <?php if($calculationDetails['isMeraeventsDiscount']): ?>
                                            <div>
                                                <span>Discount</span>
                                                <span>
                                                    <?php echo $calculationDetails['currencyCode'].' '.$totalCodeBulkDiscount;?>
                                                </span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="totalamt-div2 totalAmountid" amnt= "<?php echo $calculationDetails['totalPurchaseAmount'];?>" ><span>Total Amount<p><?php echo $calculationDetails['currencyCode'].' '.$calculationDetails['totalPurchaseAmount'];?></p></span></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!--End Step2-->
            <?php } ?>
        </div>
    </div>
    <!-- /.wrap -->
</div>
<script type="text/javascript">
   // var utilsIntlNum ="<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>";
    var utilsIntlNum ="<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils.min.js'; ?>";
    var customValidationEventIds = "<?php echo json_encode($customValidationEventIds);?>";
    customValidationEventIds = $.parseJSON(customValidationEventIds);
</script>

<?php if(isset($configCustomDatemsg[$eventId])){?>
    <script type="text/javascript">

        var weekendTickets ="<?php echo json_encode($configspecialTickets['weekends']);?>";
        var weekdayTickets ="<?php echo json_encode($configspecialTickets['weekdays']);?>";
        weekendTickets= $.parseJSON(weekendTickets);
        weekdayTickets = $.parseJSON(weekdayTickets);

    </script>
<?php }?>
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?php echo $this->config->item('google_app_key');?>"></script> -->
<script type="text/javascript">

    var booking_saveData ='<?php echo commonHelperGetPageUrl('api_bookingSaveData');?>';
    var api_citySearch = '<?php echo commonHelperGetPageUrl('api_citySearch');?>';
    var api_stateSearch = '<?php echo commonHelperGetPageUrl('api_stateSearch');?>';
    var api_countrySearch = '<?php echo commonHelperGetPageUrl('api_countrySearch');?>';
    var api_eventPromoCodes='<?php echo commonHelperGetPageUrl('api_eventPromoCodes');?>';
    var totalSaleTickets='<?php echo $calculationDetails['totalTicketQuantity'];?>';
    var api_getTinyUrl = "";
    var totalPurchaseAmount = "<?php echo $calculationDetails['totalPurchaseAmount'];?>";
    var stagedevent = "<?php echo $eventSettings['stagedevent'];?>";
    var paymentstage = "<?php echo $eventSettings['paymentstage'];?>";
    var signupStagedStatus = "<?php echo $signupStagedStatus; ?>";
    var customValidationMessage = "<?php echo $customValidationMessage; ?>";


    if(stagedevent == 1 && paymentstage == 2 && signupStagedStatus == 2){
        $(function() {
            $('#ticket_registration').find('*').prop('disabled', true);
        });
    }
    $(".gstvalueclass").hide();
    $(".gstnumberclass").keyup(function(k, v){
        var value = $(this).val();
        $(this).val(value.replace(/[^a-zA-Z0-9-\/]/g, ""));
    });
    function showGSTDetails(dis) {
        if($(dis).prop("checked")) {
            $(".gstvalueclass").show();
            $(".gstvalueclass .customValidationClass").removeClass('valid');
            $(".gstvalueclass .customValidationClass").addClass("required");
        } else {
            $(".gstvalueclass").hide();
            $(".gstvalueclass input").val('');
            $(".gstvalueclass textarea").val('');
            $(".gstvalueclass .customValidationClass").addClass("valid");
            $(".gstvalueclass .customValidationClass").removeClass("error");  
            $(".gstvalueclass .customValidationClass").removeClass("required");
        }
        $("#ticket_registration").valid();
    }

function update_gst_state(gst_number)
{
    var state_code = gst_number.substring(0, 2);
    $("#pur_state").val(state_code);
    return true;
}
</script>
<?php
include_once 'includes/elements/mywallet_js.php';


foreach($eventGateways as $key=>$gateway) {
    if(in_array($gateway['functionname'], array('stripe','razorpay','paypal','paypalinr','ingenico')) && $calculationDetails['totalPurchaseAmount'] > 0){
        if(isset($gateway['environment'])){
            $paypalGatewayEnvironment = $gateway['environment'];
        }
        if($gateway['functionname'] == 'paypalinr'){
            $gateway['functionname'] = 'paypal';
        }
        include_once 'payment/'.$gateway['functionname'].'_prepare.php';
    }
}

?>

<script language="javascript">
$(document).ready(function() { 
    $("input[id^='City_']").each(function() {
        this.value = '';
    });
});
</script>
