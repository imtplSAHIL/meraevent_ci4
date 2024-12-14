
<div class="page-container">
    <div class="wrap">
        <!--   Big container   -->
        <div class="container">
            <div class="row">
                <div class="wizard768"> <!--col-lg-8 col-lg-offset-2 -->
                    <!--      Wizard container        -->
                    <div class="wizard-container">

                        <?php if ($isExisted) { ?>
                            <div class="innerPageContainer" style="margin-bottom: 30px;">
                                <h2 class="pageTitle">Registration Information</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        Looks like you used the browser back button after completing your previous transaction to buy another ticket!<br>
                                        To buy another ticket for this event go to
                                        <a href="<?php echo $eventData['eventUrl']; ?>">Preview Event</a> and continue from there.
                                        <br><br>Contact support at support@meraevents.com or 040-49171447 for assistance.
                                    </div>
                                </div>
                            </div>
                        <?php } elseif ($userMismatch) { ?>
                            <div class="innerPageContainer" style="margin-bottom: 30px;">
                                <h2 class="pageTitle">Registration Information</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        You are not authorized to complete this transaction with this login. Please login with <span style="font-weight: bold;font-size: 18px;"><?php echo $incompleteEmail; ?></span><br/> or try out with new transaction
                                        <a href="<?php echo $eventData['eventUrl']; ?>">Preview Event</a>.
                                        <br><br>Contact support at support@meraevents.com or 040-49171447 for assistance.
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card wizard-card">
                                <div class="wizard-header">
                                    <div class="wizard-title">
                                        <h2 style="<?php if (isset($eventTitleColor) && $eventTitleColor != '') echo 'color:' . '#' . $eventTitleColor . ';'; ?>"><?php echo (isset($eventData['title'])) ? ucwords($eventData['title']) : ''; ?></h2>
                                    </div>
                                    <div class="wizard-location">
                                        <p><?php
                                            echo allTimeFormats($eventData['startDate'], 3);
                                            ?><?php
                                            if (allTimeFormats($eventData['startDate'], 9) != allTimeFormats($eventData['endDate'], 9)) {
                                                echo " - " . allTimeFormats($eventData['endDate'], 3);
                                            } echo " | " . allTimeFormats($eventData['startDate'], 4) . ' to ' . allTimeFormats($eventData['endDate'], 4) . ' ' . $eventData['location']['timezone'];
                                            ?></p>
                                        <p><a><?php
                                                if (isset($eventData['eventMode']) && $eventData['eventMode'] == 1) {
                                                    echo "Webinar";
                                                } else {
                                                    echo $eventData['fullAddress'];
                                                }
                                                ?></a></p>
                                    </div>
                                </div>
                                <div class="wizard-navigation">
                                    <ul class="nav nav-tabssection">
                                        <li><a id="tickets_tab2" class="tickets_tab2 tabhighlight">PAYMENT</a></li>
                                    </ul>
                                </div>
                                <div class="iframetab-content">
                                    <div class="tab-pane">
                                        <div id="errorMessage" style="text-align: center;color: red; display:none;">Oops..! Something went wrong..</div>
                                        <div class="row" id="ticket_pane_tab2">
                                            <div id="booking_message_div" style="color: red;">
                                                <?php
                                                $sessionMessage = $this->customsession->getData('booking_message');
                                                $this->customsession->unSetData('booking_message');
                                                if (($sessionMessage)) {
                                                    echo $sessionMessage;
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            $formCount = 1;
                                            if ($collectMultipleAttendeeInfo == 1) {
                                                $formCount = array_sum($ticketData);
                                            }
                                            ?>
                                            <div style="display: none">
                                                <input type="hidden" id="themefieldsActualFields" value="">
                                                <input type="hidden" id="widgettheme" value="<?php echo $widgettheme; ?>">
                                                <input type="hidden" name="directDetails" id="directDetails" value="">
                                                <form action="" name="ticket_registration" id="ticket_registration" enctype="multipart/form-data">

                                                    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventData['id']; ?>">
                                                    <input type="hidden" name="samepage" id="samepage" value="1">
                                                    <input type="hidden" name="redirectUrl" id="redirectUrl" value="<?php echo $redirectUrl; ?>">
                                                    <input type="hidden" name="orderId" value="<?php echo $orderLogId; ?>" />
                                                    <input type="hidden" name="paymentGateway" id="paymentGateway">
                                                    <input type="hidden" name="paymentGatewayId" id="paymentGatewayId">
                                                    <input type="hidden" name="isSeating" id="isSeating" value="<?php echo $eventSettings['seating']; ?>">
                                                    <input type="hidden" name="courierFee" id="courierFee" value="<?php echo $courierFee; ?>"> 
                                                    <input type="hidden" name="Event_Type" id="Event_Type" value="<?php echo $Event_Type; ?>"> 
                                                    <input type="text" name="parentsignupid" id="parentsignupid" value="<?php echo $parentsignupid; ?>"> 

                                                    <?php foreach ($ticketData as $ticketId => $ticketCount) { ?>
                                                        <input type="hidden" name="ticketArr[<?php echo $ticketId; ?>]" id="ticketArr[<?php echo $ticketId; ?>]" value="<?php echo $ticketCount; ?>" />
                                                    <?php } ?>

                                                    <input type="hidden" name="eventSignupId" id="eventSignupId" value="<?php echo $eventSignupId; ?>">
                                                    <?php
                                                    foreach ($attendee_data as $attendee_id => $attendee_values) {
                                                        foreach ($attendee_values as $attendee_field_name => $attendee_field_value) {
                                                            echo "<input type='hidden' name='$attendee_field_name".$attendee_id."' value='$attendee_field_value'>";
                                                        }
                                                    }
                                                    ?>
                                                </form>
                                                <div class="wizard-footer w-mb20">
                                                    <div class="pull-right">
                                                        <?php
                                                        if ($calculationDetails['totalPurchaseAmount'] > 0) {
                                                            if ($eventSettings['stagedevent'] == 1 && $eventSettings['paymentstage'] == 2) {
                                                                ?>
                                                                <a href="javascript:void(0)" style="<?php if ($bookNowBtnColor != '') echo 'background:' . '#' . $bookNowBtnColor . ';'; ?>" class="paynow button button-next button-fill nextstep button-wd">
                                                                    <?php echo $eventData['bookButtonValue']; ?></a>
                                                                <?php
                                                            }else {
                                                                ?>
                                                                <a id="attendeedetailsform"  nextstep="yes" href="javascript:void(0)" style="" class="paynow button button-next button-fill nextstep button-wd">
                                                                    Proceed</a>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a href="javascript:void(0)" class="paynow button button-next button-fill nextstep button-wd"><?php echo $eventData['bookButtonValue']; ?></a>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>        
                                            <?php if ($courierFee == '1') { ?>
                                                <div class="col-xs-12 mbottom50 text-success">
                                                    <h4><b><?php echo COURIER_NOTE; ?></b></h4>
                                                </div>
                                            <?php } ?>
                                            <?php if (isset($widgetSettings[DISPLAY_SUMMARY_IN_PAYMENT]) && $widgetSettings[DISPLAY_SUMMARY_IN_PAYMENT] == 'yes') { ?>
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
                                                                    <p class="col-lg-6 col-md-6 col-xs-6 widget-tleft"><?php echo $cdvalue['ticketName']; ?></p>
                                                                    <p class="col-lg-3 col-md-3 col-xs-3 widget-tright"> <?php echo $cdvalue['selectedQuantity']; ?></p>
                                                                    <p class="col-lg-3 col-md-3 col-xs-3 widget-tright"> <?php echo $cdvalue['currencyCode'] . " " . $cdvalue['ticketPrice']; ?></p>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <!--Price Split Start-->

                                                    <div class="widget-totalamountdiv col-lg-8 col-md-8 col-sm-8 zeroPadd pull-right">
                                                        <div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Amount</p>
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="total_amount"><span>:</span> <?php echo $calculationDetails['currencyCode'] . ' ' . $calculationDetails['totalTicketAmount']; ?></p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        // Code discount and bulk discount will be considered as "Discount"
                                                        $totalCodeBulkDiscount = $calculationDetails['totalCodeDiscount'] + $calculationDetails['totalBulkDiscount'];
                                                        $totalCashback = $calculationDetails['totalCodeCashBack'];
                                                        if ($totalCodeBulkDiscount > 0) {
                                                            ?>
                                                            <div id="bulkDiscountTbl">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Discount</p>
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="bulkDiscount_amount"><span>:</span>  <?php echo $calculationDetails['currencyCode'] . ' ' . $totalCodeBulkDiscount; ?></p>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }

                                                        $totalReferralDiscount = $calculationDetails['totalReferralDiscount'];
                                                        if ($totalReferralDiscount > 0) {
                                                            ?>
                                                            <div id="discountTbl">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Referral Discount</p>
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="discount_amount"><?php echo $calculationDetails['currencyCode'] . ' ' . $totalReferralDiscount; ?></p>
                                                                </div>
                                                            </div>
                                                        <?php } if ($totalCashback > 0) { ?>
                                                            <div id="discountTbl">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Cashback</p>
                                                                    <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="cashback_amount"><?php echo $calculationDetails['currencyCode'] . ' ' . $totalCashback; ?></p>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div id="taxesDiv">
                                                            <?php
                                                            if (isset($calculationDetails['totalTaxDetails']) && count($calculationDetails['totalTaxDetails']) > 0) {
                                                                foreach ($calculationDetails['totalTaxDetails'] as $taxData) {
                                                                    ?>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                        <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><?php echo $taxData['label'] . ' (' . $taxData['value'] . '%)'; ?></p>
                                                                        <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright"><span>:</span><?php echo $calculationDetails['currencyCode'] . ' ' . $taxData['taxAmount']; ?></p>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                        </div>

                                                        <div id="extraChargeTbl" style="display: block;">
                                                            <?php if (is_array($calculationDetails['extraCharge']) && count($calculationDetails['extraCharge']) > 0) { ?>

                                                                <?php
                                                                foreach ($calculationDetails['extraCharge'] as $extraCharge) {
                                                                    if ($extraCharge['totalAmount'] > 0) {
                                                                        ?>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><?php echo $extraCharge['label']; ?></p>
                                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright"><span>:</span><?php echo $calculationDetails['currencyCode'] . ' ' . $extraCharge['totalAmount']; ?></p>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            <?php } ?>
                                                        </div>

                                                        <div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><b>Total Amount</b></p>
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="purchase_total"><b><span>:</span> <?php echo $calculationDetails['currencyCode'] . ' ' . $calculationDetails['totalPurchaseAmount']; ?></b></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                            <div class="row">
                                                <div class="col-sm-12 wizard-paymentgateways">
                                                    <?php
                                                    $selectPaypal = FALSE;
                                                    if (count($eventGateways) > 0) {
                                                        if ($calculationDetails['totalPurchaseAmount'] > 0) {
                                                            $ebsGateway = $ebsKey = 0;
                                                            $paytmGateway = $paytmKey = 0;
                                                            $paypalGateway = $paypalKey = 0;
                                                            $mobikwikGateway = $mobikwikKey = 0;
                                                            foreach ($eventGateways as $key => $gateway) {
                                                                $gatewayName = strtolower($gateway['gatewayName']);
                                                                $gatewayKey = $gateway['paymentgatewayid'];
                                                                $gatewayDescription = $gateway['description'];
                                                                $gatewayFunction = $gateway['functionname'];
                                                                $gatewayImage = $gateway['imageid'];
                                                                $radioCheckedText = 'checked="checked"';
                                                                if ($eventSettings['stagedevent'] == 1 && $eventSettings['paymentstage'] == 2) {
                                                                    $gatewayFunction = $radioCheckedText = '';
                                                                }

                                                                if (($gateway['selected'] == 1 && in_array($gatewayFunction, array('paypal', 'paypalinr'))) || ($calculationDetails['currencyCode'] != 'INR' && in_array($gatewayFunction, array('paypal', 'paypalinr'))) && $eventSettings['seating'] == FALSE && $otherCurrencyGatewaySelected == 0) {
                                                                    $selectPaypal = TRUE;
                                                                }
                                                                ?>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wizard-gatewayholder">
                                                                    <p class="wizard-gatewaytext">
                                                                        <label>
                                                                            <span>
                                                                                <input type="radio" id="<?php echo $gatewayKey; ?>" name="paymentGateway" value="<?php echo $gatewayFunction; ?>" <?php
                                                                                if (($gateway['selected'] == 1) || ($calculationDetails['currencyCode'] == 'USD' && $gatewayFunction == 'paypal')) {
                                                                                    echo $radioCheckedText;
                                                                                }
                                                                                ?>>
                                                                            </span>
                                                                            <span id="<?php echo $gatewayFunction; ?>_text"><?php echo $gatewayDescription; ?></span>
                                                                        </label>
                                                                    </p>
                                                                    <div class="gateway-imgholder">
                                                                        <a href="javascript:;" class="paymentButton" id="<?php echo strtoupper($gatewayFunction); ?>">
                                                                            <img src="<?php echo $gatewayImage; ?>" />
                                                                        </a>
                                                                    </div>
                                                                </div>


                                                            <?php } ?>


                                                        <?php } ?>
                                                        <?php $paypalCheck = array_column($eventGateways, 'gatewayName'); ?>
                                                        <div class="wizard-footer widgetwidthinlnie w-mb20">
                                                            <div class="pull-right">
                                                                <a id="paynow" href="javascript:void(0)" style="<?php if ($selectPaypal == TRUE) { ?>display:none;<?php } ?>" class="button button-next button-fill nextstep button-wd" >
                                                                    <?php echo $eventData['bookButtonValue']; ?></a>
                                                                <?php if (in_array('paypal', $paypalCheck) || in_array('paypalinr', $paypalCheck)) { ?> 
                                                                    <div id="paypal-button-container" class="paynowbtn margintop20" <?php if ($selectPaypal == FALSE) { ?>style="display:none"<?php } ?>></div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php
                                                    foreach ($eventGateways as $key => $gateway) {
                                                        $gatewayName = strtolower($gateway['gatewayName']);
                                                        $gatewayKey = $gateway['paymentgatewayid'];
                                                        $gatewayDescription = $gateway['description'];
                                                        $gatewayFunction = $gateway['functionname'];
                                                        $gatewayImage = $gateway['imageid'];
                                                        $actionUrl = site_url('payment/' . $gatewayFunction . 'Prepare');
                                                        if ($gatewayName == 'paytm') {
                                                            $actionUrl = site_url('payment/' . $gatewayFunction . 'Select');
                                                        }
                                                        ?>
                                                        <form name="<?php echo $gatewayFunction; ?>_frm" id="<?php echo $gatewayFunction; ?>_frm" action="<?php echo $actionUrl; ?>" method='POST' <?php if ($gatewayFunction == 'phonepe' || $gatewayFunction == 'ebs') { ?> target="_top" <?php } ?>>
                                                            <input type="hidden" name="eventTitle" value="<?php echo preg_replace("/[^A-Za-z0-9]/", "", stripslashes($eventData['title'])) ?>" />
                                                            <input type="hidden" name="orderId" value="<?php echo $orderLogId; ?>" />
                                                            <input type="hidden" name="paymentGatewayKey" value="<?php echo $gatewayKey; ?>" />
                                                            <input type="hidden" name="primaryAddress" class="primaryAddress" id="primaryAddress" value="<?php if (isset($primaryAddress) && $primaryAddress != '') echo $primaryAddress; ?>">
                                                        </form>
                                                    <?php } ?>
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
    var utilsIntlNum = "<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils' . $this->config->item('js_gz_extension'); ?>";
        var customValidationEventIds = "";
        customValidationEventIds = $.parseJSON(customValidationEventIds);
        var countryDataJson = $.fn.intlTelInput.getCountryData();
        var countryName = "<?php echo $eventData['location']['countryName'] ?>", str = '';
        var intlCountrycode = '';
        for (var i = 0, len = countryDataJson.length; i < len; i++) {
            str = countryDataJson[i].name;
            if (str.indexOf('(') > 0) {
                str = str.substring(0, (str.indexOf('(') - 1));
            }
            if (countryName == str) {
                intlCountrycode = countryDataJson[i].iso2;
                continue;
            }
        }
        window.onload = function (e) {
            if (intlCountrycode != '' && intlCountrycode != 'in' && $(".mobileNoFlags").eq(0).val() == '') {
                $(".mobileNoFlags").each(function (index, value) {
                    var currentElement = $(this);
                    if (currentElement.val() == "")
                        currentElement.intlTelInput("setCountry", intlCountrycode);
                });
            }
        }
</script>

<script type="text/javascript">
        var stagedevent = "<?php echo $eventSettings['stagedevent']; ?>";
        var paymentstage = "<?php echo $eventSettings['paymentstage']; ?>";
        var signupStagedStatus = 1;
        var booking_saveData = '<?php echo commonHelperGetPageUrl('api_bookingSaveData'); ?>';
        var api_citySearch = '<?php echo commonHelperGetPageUrl('api_citySearch'); ?>';
        var api_stateSearch = '<?php echo commonHelperGetPageUrl('api_stateSearch'); ?>';
        var api_countrySearch = '<?php echo commonHelperGetPageUrl('api_countrySearch'); ?>';
        var api_eventPromoCodes = '<?php echo commonHelperGetPageUrl('api_eventPromoCodes'); ?>';
        var totalSaleTickets = '<?php echo $calculationDetails['totalTicketQuantity']; ?>';
        var api_getTinyUrl = "";
        var totalPurchaseAmount = "<?php echo $calculationDetails['totalPurchaseAmount']; ?>";
        var customValidationMessage = "";
</script>
<?php
foreach ($eventGateways as $key => $gateway) {
    if ($gateway['functionname'] == 'paypalinr') {
        $gateway['functionname'] = 'paypal';
    }
    if (in_array($gateway['functionname'], array('stripe', 'razorpay', 'paypal', 'ingenico')) && $calculationDetails['totalPurchaseAmount'] > 0) {
        if (isset($gateway['environment'])) {
            $paypalGatewayEnvironment = $gateway['environment'];
        }
        include_once APPPATH . 'views/payment/' . $gateway['functionname'] . '_prepare.php';
    }
}
?>