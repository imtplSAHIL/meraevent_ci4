<style type="text/css">
    .opacity5 {
        opacity: 0.5;
    }
</style>
<?php $GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY; ?>
<div class="page-container">
    <div class="wrap">
        <!--   Big container   -->
        <div class="container">
            <div class="row">
                <div class="wizard768"> <!--col-lg-8 col-lg-offset-2 -->
                    <!--      Wizard container        -->
                    <div class="wizard-container">
                        <div class="card wizard-card">
                            <input type="hidden" id="showTitle" value="<?php echo $showTitle; ?>">
                            <input type="hidden" id="widgetThirdPartyUrl" value="<?php echo $widgetThirdPartyUrl; ?>">
                            <input type="hidden" id="redirectUrl" value="<?php echo $redirectUrl; ?>">
                            <input type="hidden" id="showDateTime" value="<?php echo $showDateTime; ?>">
                            <input type="hidden" id="showLocation" value="<?php echo $showLocation; ?>">
                            <input type="hidden" id="ticket_option" value="<?php echo $ticket_option; ?>">
                            <input type="hidden" id="ticket_option_ids" value="<?php echo $ticket_option_ids; ?>">
                            <input type="hidden" id="wcode" value="<?php echo $wCode; ?>">
                            <input type="hidden" id="widgettheme" value="<?php echo $widgettheme; ?>">
                            <input type="hidden" name="limitSingleTicketType" id="limitSingleTicketType" value="<?php echo $limitSingleTicketType; ?>">
                            <input type="hidden" name="eventId" id="eventId" value="<?php
                            if ($multiEvent == TRUE) {
                                echo $multiEventId;
                            } else {
                                echo $eventData['id'];
                            }
                            ?>">
                            <input type="hidden" name="referralCode" id="referralCode" value="<?php echo $referralCode; ?>">
                            <input type="hidden" name="promoterCode" id="eventId" value="<?php echo $promoterCode; ?>">
                            <input type="hidden" name="pcode" id="pcode" value="<?php echo $pcode; ?>">
                            <input type="hidden" name="acode" id="acode" value="<?php echo $aCode; ?>">
                            <input type="hidden" name="rCode" id="rCode" value="<?php echo!empty($rCode) ? 'widget_' . trim($rCode) : ''; ?>">
                            <input type="hidden" name="ticketWidget" id="ticketWidget" value="<?php echo $ticketWidget; ?>">
                            <input type="hidden" name="directDetails" id="directDetails" value="<?php echo $directDetails; ?>">
                            <div class="wizard-header">
                                <div class="wizard-title">
                                    <h2 style="<?php if (isset($eventTitleColor) && $eventTitleColor != '') echo 'color:' . '#' . $eventTitleColor . ';'; ?>"><?php echo (isset($eventData['title']) && $showTitle) ? ucwords($eventData['title']) : ''; ?></h2>
                                </div>
                                <div class="wizard-location">
                                    <p>
                                        <?php
                                        if ($showDateTime && $multiEvent == FALSE && $eventData['categoryName'] != 'Donations') {
                                            if (isset($configCustomDatemsg[$eventId]) && !isset($configCustomTimemsg[$eventId])) {
                                                echo $configCustomDatemsg[$eventId] . " | " . allTimeFormats($eventData['startDate'], 4) . ' to ' . allTimeFormats($eventData['endDate'], 4) . ' ' . $eventData['location']['timezone'];
                                            } else if (isset($configCustomTimemsg[$eventId]) && !isset($configCustomDatemsg[$eventId])) {
                                                echo allTimeFormats($eventData['startDate'], 3);
                                                if (allTimeFormats($eventData['startDate'], 9) != allTimeFormats($eventData['endDate'], 9)) {
                                                    echo " - " . allTimeFormats($eventData['endDate'], 3);
                                                } echo " | " . $configCustomTimemsg[$eventId];
                                            } else if (isset($configCustomTimemsg[$eventId]) && isset($configCustomDatemsg[$eventId])) {
                                                echo $configCustomDatemsg[$eventId] . " | " . $configCustomTimemsg[$eventId];
                                            } else {
                                                echo allTimeFormats($eventData['startDate'], 3);
                                                if (allTimeFormats($eventData['startDate'], 9) != allTimeFormats($eventData['endDate'], 9)) {
                                                    echo " - " . allTimeFormats($eventData['endDate'], 3);
                                                } echo " | " . allTimeFormats($eventData['startDate'], 4) . ' to ' . allTimeFormats($eventData['endDate'], 4) . ' ' . $eventData['location']['timezone'];
                                            }
                                        }
                                        ?>
                                    </p>
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
                                    <?php if (isset($widgetSettings[WIDGET_NOTES]) && $widgetSettings[WIDGET_NOTES] != '') { ?>
                                        <div class="widgetnotes">
                                            Note: <?php echo $widgetSettings[WIDGET_NOTES]; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="multidateoption-select">
                                        <?php
                                        if ($multiEvent == TRUE) {
                                            if (count($multiEventList)) {
                                                ?>
                                                <select id='multidateoption'>
                                                    <?php foreach ($multiEventList as $data) { ?>
                                                        <option value="<?php echo $data['eventId']; ?>" <?php
                                                        if ($multiEventId == $data['eventId']) {
                                                            echo "selected='Selected'";
                                                        }
                                                        ?>><?php echo allTimeFormats($data['startDateTime'], 3); ?></option>
                                                            <?php } ?>
                                                </select>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-navigation">
                                <ul class="nav nav-tabssection">
                                    <li><a id="tickets_tab1" class="tabhighlight" style="<?php echo $directDetails == 1 ? 'display:none;' : ''; ?><?php if ($headingBackgroundColor != '') echo 'background:' . '#' . $headingBackgroundColor . ';'; ?>">
                                            <?php
                                            if (isset($widgetSettings[TICKET_TAB_TITLE]) && $widgetSettings[TICKET_TAB_TITLE] != '') {
                                                echo $widgetSettings[TICKET_TAB_TITLE];
                                            } else if ($eventData['categoryName'] == 'Donations') {
                                                echo "Donations";
                                            } else {
                                                echo "TICKETS";
                                            }
                                            ?>
                                        </a></li>
                                    <li><a>DETAILS</a></li>
                                    <?php if ($eventSettings['stagedevent'] == 0 || ( $eventSettings['paymentstage'] == 1 && $eventSettings['stagedevent'] == 1)) { ?>
                                        <li><a>PAYMENT</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="iframetab-content">
                                <div class="tab-pane" id="ticket_pane_tab1"<?php echo $directDetails == 1 ? ' style="display:none;"' : ''; ?>>
                                    <div class="row">
                                        <div class="widget-container">
                                            <?php if ($eventData['id'] == 165221) { ?>
                                                <p class="error padding-five zeroMarg">Early bird/Late bird ticket is mandatory while booking.</p>
                                            <?php } ?>
                                            <!-- Ticket Type Start -->
                                            <?php
                                            if (count($ticketDetails) > 0) {
                                                $ticketids = $nowdate = "";
                                                $soldoutTickets = array();
                                                $comingSoonTickets = array();
                                                if (isset($ticketGroups) && !empty($ticketGroups)) {
                                                    $i = 0;
                                                    foreach ($ticketGroups as $key => $value) {
                                                        if ($ticket_option == 3 && !empty($value['name']) && !in_array($value['id'], explode(",", $ticket_option_ids))) {
                                                            continue;
                                                        }
                                                        if (isset($value['name'])) {
                                                            ?>
                                                            <div class="widget-ticketgroup" data-id='<?php echo $value["id"] ?>' data-maxcat='<?php echo $value["maxticketcategories"] ?>'>
                                                                <?php
                                                                $evenData = $value['tickets'];
                                                                if (isset($value['name']) && $value['name'] != '') {
                                                                    ?>
                                                                    <div class="widget-acc-btn" style="<?php
                                                                    if (isset($eventTitleColor) && $eventTitleColor != '') {
                                                                        echo 'color:' . '#' . $eventTitleColor . ' !important;';
                                                                    } else {
                                                                        echo 'color:' . '#9063cd !important;';
                                                                    }
                                                                    ?>" class="widget-grouptitle"><p class="selected"><i class="icon2-angle-right"></i> <?php echo ucwords($value['name']); ?></p></div>
                                                                     <?php } ?>
                                                                     <?php if ($ticketGroupStatus && isset($value['name']) && $value['name'] != '') { ?>
                                                                    <div class="widget-acc-content <?php echo $i == 0 ? 'widget-open' : ''; ?>">
                                                                        <div class="widget-acc-content-inner">
                                                                            <?php if ($value["maxticketcategories"] > 0) { ?>
                                                                                <span class="selected" style="padding: 10px 20px 0px 20px;color: #999;display: inline-block;font-size: 12px;width: 100%;"><i class="icon2-info-circle"></i> You can select maximum <?php echo $value["maxticketcategories"] ?> ticket categor<?php echo $value["maxticketcategories"] > 1 ? 'ies' : 'y' ?>  in this group</span>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                        <?php
                                                                        if (isset($evenData) && !empty($evenData)) {
                                                                            $soldoutTicketsByGroup = $comingSoonTicketsByGroup = array();
                                                                            foreach ($evenData as $ticket) {
                                                                                if ($ticket_option == 2 && !empty($ticket_option_ids) && !in_array($ticket['ticketid'], explode(",", $ticket_option_ids))) {
                                                                                    continue;
                                                                                }
                                                                                $ticket = $ticketDetails[$ticket['ticketid']];
                                                                                if (isset($ticket) && !empty($ticket)) {
                                                                                    $nowdate = strtotime(nowDate($eventData['location']['timeZoneName']));
                                                                                    $startdate = strtotime($ticket['startDate']);
                                                                                    $enddate = strtotime($ticket['endDate']);
                                                                                    $lastdate = $ticket['endDate'];
                                                                                    if ($ticket['soldout'] == 1 || $enddate < $nowdate) {
                                                                                        $soldoutTickets[] = $ticket;
                                                                                        $soldoutTicketsByGroup[] = $ticket;
                                                                                    } else if ($startdate > $nowdate) {
                                                                                        $comingSoonTickets[] = $ticket;
                                                                                        $comingSoonTicketsByGroup[] = $ticket;
                                                                                    } else {
                                                                                        $description = $ticket['description'];
                                                                                        $first = substr($description, 0, 80);
                                                                                        $last = substr($description, 80);
                                                                                        ?>


                                                                                        <div class="widget-tickettype col-lg-12 col-md-12 zeroPadd">
                                                                                            <div class="widget-namesection col-lg-8 col-md-6 col-xs-6 zeroPadd">
                                                                                                <p class="widget-ticketname" style="<?php if ($ticketTextColor != '') echo 'color:' . '#' . $ticketTextColor . ';'; ?>"><?php echo ucwords($ticket['name']); ?></p>
                                                                                                <?php
                                                                                                $description = $ticket['description'];
                                                                                                $first = substr($description, 0, 100);
                                                                                                $last = substr($description, 100);
                                                                                                ?>
                                                                                                <?php if (strlen($description) > 99) { ?>
                                                                                                    <p class="widget-desc"> <?php echo $first . '<i>...</i><span style="display:none">' . $last . '</span>'; ?></p>
                                                                                                    <p class="ticket-desc-loadmore" style="float:none"><a href="javascript:;">Show More</a></p>
                                                                                                <?php } else { ?>
                                                                                                    <p class="widget-desc"> <?php echo $description ?></p>
                                                                                                <?php } ?>
                                                                                                <?php if (isset($eventTicketOptionSettings['ticketdatehide']) && $eventTicketOptionSettings['ticketdatehide'] != 1) { ?>
                                                                                                    <p class="widget-saledate">Last Date : <?php echo lastDateFormat($ticket['endDate']) ?></p>
                                                                                                <?php } ?>
                                                                                                <?php
                                                                                                if (isset($ticket['taxes']) && count($ticket['taxes']) > 0) {
                                                                                                    foreach ($ticket['taxes'] as $taxData) {
                                                                                                        ?>
                                                                                                        <p class="widget-saledate taxtext">* Exclusive of <?php echo ucfirst($taxData['label']) . ' ' . $taxData['value'] . '%' ?></p>
                                                                                                    <?php }
                                                                                                    ?>

                                                                                                <?php } ?>
                                                                                                <?php
                                                                                                if (isset($ticket['viralData'])) {
                                                                                                    $viralValue = $ticket['currencyCode'] . ' ' . $ticket['viralData']['receivercommission'];
                                                                                                    if ($ticket['viralData']['type'] == 'percentage') {
                                                                                                        $viralValue = $ticket['viralData']['receivercommission'] . '%';
                                                                                                    }
                                                                                                    ?>
                                                                                                    <p class="widget-applicablediscounts">Applicable Referral Discount <?php echo $viralValue; ?> </p>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                            <!--Ticketname Section End-->
                                                                                            <div class="widget-price col-lg-2 col-md-3 col-xs-3 zeroPadd">
                                                                                                <!-- <p><i class="fa fa-rupee"></i> 12500</p> -->
                                                                                                <p style="<?php if ($ticketTextColor != '') echo 'color:' . $ticketTextColor . ';'; ?>">
                                                                                                    <?php
                                                                                                    if ($ticket['price'] > 0 || $ticket['type'] == 'donation') {
                                                                                                        echo $ticket['currencyCode'] . " ";
                                                                                                    }
                                                                                                    ?>
                                                                                                    <?php
                                                                                                    if ($ticket['type'] != 'donation') {
                                                                                                        echo $ticket['price'];
                                                                                                    } else if ($ticket['type'] == 'donation') {
                                                                                                        ?>
                                                                                                        <?php if ($ticket['soldout'] != 1 && $enddate >= $nowdate && $startdate <= $nowdate) { ?>
                                                                                                            <input type="text" name="ticket_selector" size='10' class="ticket_selector selectNo widget-DonationInput" value="" id="<?php echo $ticket['id'] ?>"> <?php } ?>
                                                                                                    <?php } ?>
                                                                                                </p>
                                                                                            </div>
                                                                                            <!---->
                                                                                            <div class="widget-quantity col-lg-2 col-md-3 col-xs-3 zeroPadd">
                                                                                                <?php
                                                                                                $optionText = '';
                                                                                                $optionText .= "<option value='0'>0</option>";
                                                                                                for ($option = $ticket['minOrderQuantity']; $option <= $ticket['maxOrderQuantity']; $option++) {
                                                                                                    if (($ticket['totalSoldTickets'] + $option) <= $ticket['quantity']) {
                                                                                                        $optionText = $optionText . "<option>" . $option . "</option>";
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                                <?php if ($ticket['type'] != 'donation') { ?>
                                                                                                    <?php
                                                                                                    if ($ticket['soldout'] != 1 && $enddate >= $nowdate) {
                                                                                                        $dropdowndisplay = '';
                                                                                                        if (isset($widgetSettings[TICKET_SELECTION_CHECKBOX]) && $widgetSettings[TICKET_SELECTION_CHECKBOX] == 'yes') {
                                                                                                            $dropdowndisplay = 'display:none';
                                                                                                            ?>
                                                                                                            <input type="checkbox" class="ticketselectioncheckbox" ticketid="<?php echo $ticket['id'] ?>">
                                                                                                        <?php } ?>
                                                                                                        <select style="<?php echo $dropdowndisplay; ?>" class="ticket_selector selectNo <?php echo $ticket['type']; ?> <?php echo "ticketselectioncheckbox_" . $ticket['id'] ?>" id="<?php echo $ticket['id'] ?>">
                                                                                                            <?php echo $optionText; ?>
                                                                                                        </select>
                                                                                                    <?php } ?>
                                                                                                    <?php
                                                                                                } else if ($ticket['type'] == 'donation') {
                                                                                                    //echo 1;
                                                                                                }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        if (isset($comingSoonTicketsByGroup) && !empty($comingSoonTicketsByGroup)) {
                                                                            foreach ($comingSoonTicketsByGroup as $ticket) {
                                                                                $startdate = strtotime($ticket['startDate']);
                                                                                $enddate = strtotime($ticket['endDate']);
                                                                                $startdateConverted = $ticket['startDate'];

                                                                                $description = $ticket['description'];
                                                                                $first = substr($description, 0, 80);
                                                                                $last = substr($description, 80);
                                                                                ?>

                                                                                <div class="widget-tickettype col-lg-12 col-md-12 zeroPadd">
                                                                                    <div class="widget-namesection col-lg-8 col-md-6 col-xs-6 zeroPadd">
                                                                                        <p class="widget-ticketname" style="<?php if ($ticketTextColor != '') echo 'color:' . '#' . $ticketTextColor . ';'; ?>"><?php echo ucwords($ticket['name']); ?> </p>
                                                                                        <?php
                                                                                        $description = $ticket['description'];
                                                                                        $first = substr($description, 0, 100);
                                                                                        $last = substr($description, 100);
                                                                                        ?>
                                                                                        <?php if (strlen($description) > 99) { ?>
                                                                                            <p class="widget-desc"> <?php echo $first . '<i>...</i><span style="display:none">' . $last . '</span>'; ?></p>
                                                                                            <p class="ticket-desc-loadmore" style="float:none"><a href="javascript:;">Show More</a></p>
                                                                                        <?php } else { ?>
                                                                                            <p class="widget-desc"> <?php echo $description ?></p>
                                                                                        <?php } ?>
                                                                                        <?php if (isset($eventTicketOptionSettings['ticketdatehide']) && $eventTicketOptionSettings['ticketdatehide'] != 1) { ?>
                                                                                            <p class="widget-saledate">Start Date : <?php echo lastDateFormat($startdateConverted) ?></p>
                                                                                        <?php } ?>

                                                                                    </div>
                                                                                    <!--Ticketname Section End-->
                                                                                    <div class="widget-price col-lg-2 col-md-3 col-xs-3 zeroPadd">
                                                                                        <p style="<?php if ($ticketTextColor != '') echo 'color:' . $ticketTextColor . ';'; ?>">
                                                                                            <?php
                                                                                            if ($ticket['price'] > 0 || $ticket['type'] == 'donation') {
                                                                                                echo $ticket['currencyCode'] . " ";
                                                                                            }
                                                                                            ?><?php
                                                                                            if ($ticket['type'] != 'donation') {
                                                                                                echo $ticket['price'];
                                                                                            }
                                                                                            ?>
                                                                                        </p>
                                                                                    </div>
                                                                                    <!---->
                                                                                    <div class="widget-quantity col-lg-2 col-md-3 col-xs-3 zeroPadd">
                                                                                        <p class="widgettext-ComingSoon">Coming Soon</p>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }

                                                                        if (isset($soldoutTicketsByGroup) && !empty($soldoutTicketsByGroup)) {
                                                                            foreach ($soldoutTicketsByGroup as $ticket) {
                                                                                $startdate = strtotime($ticket['startDate']);
                                                                                $enddate = strtotime($ticket['endDate']);
                                                                                $lastdate = $ticket['endDate'];
                                                                                $description = $ticket['description'];
                                                                                $first = substr($description, 0, 80);
                                                                                $last = substr($description, 80);
                                                                                ?>

                                                                                <div class="widget-tickettype col-lg-12 col-md-12 zeroPadd">
                                                                                    <div class="widget-namesection col-lg-8 col-md-6 col-xs-6 zeroPadd">
                                                                                        <p class="widget-ticketname" style="<?php if ($ticketTextColor != '') echo 'color:' . '#' . $ticketTextColor . ';'; ?>"><?php echo ucwords($ticket['name']); ?> </p>
                                                                                        <?php
                                                                                        $description = $ticket['description'];
                                                                                        $first = substr($description, 0, 100);
                                                                                        $last = substr($description, 100);
                                                                                        ?>
                                                                                        <?php if (strlen($description) > 99) { ?>
                                                                                            <p class="widget-desc"> <?php echo $first . '<i>...</i><span style="display:none">' . $last . '</span>'; ?></p>
                                                                                            <p class="ticket-desc-loadmore" style="float:none"><a href="javascript:;">Show More</a></p>
                                                                                        <?php } else { ?>
                                                                                            <p class="widget-desc"> <?php echo $description ?></p>
                                                                                        <?php } ?>
                                                                                        <?php
                                                                                        if ($enddate < $nowdate) {
                                                                                            if (isset($eventTicketOptionSettings['ticketdatehide']) && $eventTicketOptionSettings['ticketdatehide'] != 1) {
                                                                                                ?>
                                                                                                <p class="widget-saledate">Sale Date Ended</p>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>

                                                                                    </div>
                                                                                    <!--Ticketname Section End-->
                                                                                    <div class="widget-price col-lg-2 col-md-3 col-xs-3 zeroPadd">
                                                                                        <p style="<?php if ($ticketTextColor != '') echo 'color:' . $ticketTextColor . ';'; ?>">
                                                                                            <?php
                                                                                            if ($ticket['price'] > 0 || $ticket['type'] == 'donation') {
                                                                                                echo $ticket['currencyCode'] . " ";
                                                                                            }
                                                                                            ?><?php
                                                                                            if ($ticket['type'] != 'donation') {
                                                                                                echo $ticket['price'];
                                                                                            }
                                                                                            ?>
                                                                                        </p>
                                                                                    </div>
                                                                                    <!---->
                                                                                    <div class="widget-quantity col-lg-2 col-md-3 col-xs-3 zeroPadd">
                                                                                        <p class="widgettext-SoldOut">Sold Out</p>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <?php if ($ticketGroupStatus) { ?>
                                                                        </div> </div>
                                                                <?php } ?>
                                                            </div>
                                                            <?php
                                                        } $i++;
                                                    }
                                                }
                                            }
                                            if (isset($eventSettings['courierfee']) && $eventSettings['courierfee']) {
                                                ?>
                                                <div class="courier-section">
                                                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                                                        <div class="col-md-6 zeroPadd">
                                                            <label class="courier_radio_btn btn btn-success active">
                                                                <img src="<?php echo $this->config->item('images_static_path'); ?>courier.png" class="courier-img">
                                                                <input type="radio" name="isCourier" id="option1" autocomplete="off" value="1" checked>
                                                                <span>I want my tickets to be Delivered</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6 zeroPadd">
                                                            <label class="courier_radio_btn btn btn-success">
                                                                <img src="<?php echo $this->config->item('images_static_path'); ?>boxoffice.png" class="courier-img">
                                                                <input type="radio" name="isCourier" id="option2" autocomplete="off" value="0">
                                                                <span>I want to collect my tickets at Box-office</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <!-- Ticket Type End -->
                                            <?php if (($eventData['eventDetails']['tnctype'] == 'organizer' && !empty($eventData['eventDetails']['organizertnc']) ) || ($eventData['eventDetails']['tnctype'] == 'meraevents' && !empty($eventData['eventDetails']['meraeventstnc']))) { ?>
                                                <div class="widget-tandc col-lg-12 col-md-12 zeroPadd calucationsDiv" style="display: none;">
                                                    <p>
                                                        By clicking "<?php echo $buttonName; ?>" you agree to the <a class="event_tnc" href="#">Terms and Conditions</a>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                            <div class="widget-discountcontainer book calucationsDiv" style="display: none;">

                                                <div class="col-lg-6 col-md-6 col-sm-6 zeroPadd">
                                                    <div>
                                                    <?php
                                                            if(!empty($GPTW_EVENTS_ARRAY[$eventData['id']]))
                                                            {
                                                                $discount_label = "Referral Code";
                                                            }
                                                            else
                                                            {
                                                                $discount_label = "Discount Code";
                                                            }
                                                    ?>
                                                        <input type="text" id="promo_code" name="promo_code" value="0" placeholder="<?php echo $discount_label; ?>">
                                                        <a id="apply_discount_btn" onclick="return applyDiscount();" class="widgetapply">APPLY</a>
                                                        <a id="apply_discount_btn" onclick="return clearDiscount();" class="widgetapply">CLEAR</a>
                                                    </div>
                                                </div>

                                                <div class="widget-totalamountdiv col-lg-6 col-md-6 col-sm-6 zeroPadd">
                                                    <div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Amount</p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="total_amount"></p>
                                                        </div>
                                                    </div>
                                                    <div style="display: none;" id="bulkDiscountTbl" >
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Bulk Discount Amount</p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="bulkDiscount_amount"></p>
                                                        </div>
                                                    </div>
                                                    <div style="display: none;" id="discountTbl" >
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Discount Amount</p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="discount_amount"></p>
                                                        </div>
                                                    </div>
                                                    <div style="display: none;" id="cashbackTbl" >
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Cashback Amount</p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="cashback_amount"></p>
                                                        </div>
                                                    </div>
                                                    <div style="display: none;" id="referralDiscountTbl" >
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Referral Discount Amount</p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="referralDiscount_amount"></p>
                                                        </div>
                                                    </div>
                                                    <div style="display: none;" id="courierFeeTbl" >
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft courierFee"></p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="courierFee_amount"></p>
                                                        </div>
                                                    </div>

                                                    <div id="taxesDiv"></div>

                                                    <div class="handlingfees widget-feehandlingdiv" id="handlingfeesbox">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-8 col-md-8 col-sm-8 col-xs-8 widget-tleft"><?php echo HANDLING_FEE_LABEL; ?> <i class="icon2-plus"></i></p>
                                                            <p class="col-lg-4 col-md-4 col-sm-4 col-xs-4 widget-tright" id="internethandlingtotalamount">0</p>
                                                        </div>
                                                    </div>

                                                    <div class="handlingfeescontainer widget-feehandlingdivcontainer">
                                                        <div id="extraChargeTbl"></div>
                                                        <div id="totalInternetHandlingTbl" style="display: none;">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><?php echo $handlingFeeLable; ?></p>
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="totalInternetHandlingAmount"></p>
                                                            </div>
                                                        </div>
                                                        <div id="totalInternetHandlingGst" style="display: none;">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><?php echo HANDLING_FEE_GST_LABEL; ?></p>
                                                                <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="totalInternetHandlingGstAmount"></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="roundOfValueTbl" style="display: none;">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Round of Value</p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="roundOfValue"></p>
                                                        </div>
                                                    </div>
                                                    <div style="display: none;" id="mediscountTbl" >
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft">Discount Amount</p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="mediscount_amount"></p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 widget-amountcontainer">
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tleft"><b>Total Amount</b></p>
                                                            <p class="col-lg-6 col-md-6 col-sm-6 col-xs-6 widget-tright" id="purchase_total"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($nobrand != 1) { ?>
                                            <div class="widget-poweredby">
                                                <img src="<?php echo $this->config->item('images_static_path'); ?>me-widget-poweredby.png">
                                            </div>
                                        <?php } ?>
                                        <div class="wizard-footer calucationsDiv" style="display: none;">
                                            <div class="pull-right">
                                                <input onclick="booknow()" type='button' style="<?php if ($bookNowBtnColor != '') echo 'background:' . '#' . $bookNowBtnColor . ';'; ?>" class='button button-next button-fill nextstep button-wd' name='next' value='<?php echo $buttonName; ?>' />
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- wizard container -->
                </div>
            </div>
            <!-- row -->
        </div>
        <!--  big container -->
    </div>
</div>

<!--T & C Start-->
<div class="modal fade" id="event_tnc" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-invite modal-dialog-center1">
        <div class="modal-content">
            <div class="popup_signup" style="height:auto; overflow:auto;">
                <div class="popup-closeholder">
                    <button data-dismiss="modal" class="popup-close">X</button>
                </div>
                <hr>
                <h3>Terms & Conditions</h3>
                <h3 class="subject"><?php echo isset($eventData['title']) ? $eventData['title'] : ''; ?></h3>
                <hr></hr>
                <div class="event_tnc_holder tncoverflow">
                    <?php echo $tncDetails; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
<?php if (isset($widgetSettings[TICKET_SELECTION_CHECKBOX]) && $widgetSettings[TICKET_SELECTION_CHECKBOX] == 'yes') { ?>
        var ticketselectioncheckboxstatus = "yes";
<?php } else { ?>
        var ticketselectioncheckboxstatus = "no";
<?php } ?>
</script>

<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>css/public/me-font.css">
<!--Grouping Accordion Script-->
<script>
    var api_getTinyUrl = '';
    var ticketWidgetUrl = '<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventData['id'] . '&ucode=organizer&wcode=' . $this->input->get('wcode') . '&theme=1&redirectUrl=' . $this->input->get('redirectUrl')); ?>';
</script>