<?php
$eventName = (isset($eventDetail['eventName'])) ? $eventDetail['eventName'] : '';
$isMultiDateEvent = (isset($eventDetail['isMultiDateEvent'])) ? $eventDetail['isMultiDateEvent'] : '';
$startDateTime = isset($eventDetail['startDateTime']) ? allTimeFormats(convertTime($eventDetail['startDateTime'], $eventTimeZoneName, TRUE), 15) : '';
$eventUrl = isset($eventDetail['url']) ? commonHelperGetPageUrl("preview-event", $eventDetail['url']) : "";
$viralTicketSuccessMessage = $this->customsession->getData('viralTicketSuccessMessage');
$this->customsession->unSetData('viralTicketSuccessMessage');
?>
<div class="clearL"></div>
<div class="rightArea">
    <?php if ($viralTicketSuccessMessage) { ?>
        <div id="viralTicketSuccessMessage" class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $viralTicketSuccessMessage; ?></strong> 
        </div>
    <?php } ?>
    <?php 
    if(isset($eventModeAlert)){
    if ($eventModeAlert['status'] == FALSE) { ?>
        <div id="eventModeAlert" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $eventModeAlertMessage; ?></strong> 
        </div>
    <?php }  } ?>
    <?php if ($isMultiDateEvent == 1 && count($childEvents) > 0) { ?>
        <div class="multidateselectbox-holder">
            <select id="multidateoption" class="multidateselectbox">
                <option value="<?php echo $parenteventid; ?>" <?php if ($parenteventid == $eventId) { ?> Selected="Selected"<?php } ?>>Manage all dates</option>
                <?php foreach ($childEvents as $event): ?>
                    <option value="<?php echo $event['eventId'] ?>" <?php if ($event['eventId'] == $eventId) { ?> Selected="Selected"<?php } ?>><?php echo allTimeFormats($event['eventStartDate'], 3); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php } ?>
    <div class="db-bg-holder"> <div class="heading float-left">
            <h2><?php echo $eventName; ?></h2>
            <ul>
                <li class="linkscolor"><span class="fa fa-calendar paddingright"></span><?php echo $startDateTime . '  ' . $timezone; ?></li>
                <li class="linkscolor"><span class="fa fa-map-marker paddingright"></span><?php echo $eventDetail['venueName']; ?></li>
            </ul>
        </div>
        <div class="fs-settings-buttons">
            <?php 
            /*if ($isEventStarted && $isCurrentEvent && $eventDetail['zoomEvent'] == 1) { ?>
                <a href="<?php echo commonHelperGetPageUrl('live-event', $eventId); ?>"><button type="button" class="Edit-Btn greenborder"><span class="fa fa-wifi"></span>Start Event</button></a>
            <?php } */
            if ($isCurrentEvent && $eventDetail['parenteventid'] == 0) { ?>
                <a href="<?php echo commonHelperGetPageUrl('edit-event', $eventId); ?>"><button type="button" class="Edit-Btn blueborder"><span class="fa fa-edit"></span>Edit</button></a>
            <?php } if ($eventDetail['parenteventid'] > 0) { ?>
                <a href="<?php echo commonHelperGetPageUrl('dashboard-eventhome', $eventDetail['parenteventid']); ?>"><button type="button" class="Edit-Btn blueborder"><span class="fa fa-angle-left"></span>Back to Main Event</button></a>
                <a href="<?php echo commonHelperGetPageUrl('event-preview', '', '?view=preview&eventId=' . $eventDetail['parenteventid'] . '&sub=' . $eventId); ?>" target="_blank"> <button type="button" class="Edit-Btn greenborder"><span class="fa fa-eye"></span>Preview</button></a>
            <?php } else { ?>
                <a href="<?php echo commonHelperGetPageUrl('event-preview', '', '?view=preview&eventId=' . $eventId); ?>" target="_blank"> <button type="button" class="Edit-Btn greenborder"><span class="fa fa-eye"></span>Preview</button></a>
            <?php } ?>
        </div>
    </div>

    <div class="db-org-url">
        <p>Organizer Link</p>
        <div class="paddingtb10">
            <a id="eventURL" href="<?php
            if ($isMultiDateEvent) {
                echo $eventUrl . '/' . $eventId . '?ucode=organizer';
            } else {
                echo $eventUrl . '?ucode=organizer';
            }
            ?>" target="_blank" class="linkscolor"><span class="mce-ico mce-i-link"></span><?php
               if ($isMultiDateEvent) {
                   echo $eventUrl . '/' . $eventId . '?ucode=organizer';
               } else {
                   echo $eventUrl . '?ucode=organizer';
               }
               ?></a>
            <span id="copyEventURL" class="copylink tooltip-bottom hoeverclass" data-tooltip="Copy to Clipboard">Copy Link</span>
            <?php
            $linkToShare = $eventUrl . '/' . $eventId . '?ucode=organizer';
            $tweet = substr($eventName, 0, 100);
            ?>
            <div class="orglink-share">
                <span class="org-sharetext">Share : </span>
                <a href="http://www.facebook.com/share.php?u=<?= urlencode($linkToShare) ?>&title=Meraevents -<?= $eventName ?>" target="_blank"><span class="fa fa-facebook"></span></a>
                <a href="https://twitter.com/share?url=<?= urlencode($linkToShare); ?>&amp;text=Meraevents - <?= $eventName ?>" target="_blank"><span class="fa fa-twitter"></span></a>
                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($linkToShare) ?>&amp;title=<?php echo $tweet ?>&amp;summary=<?php echo $eventDetail['fullAddress']; ?>&amp;source=Meraevents" target="_blank"><span class="fa fa-linkedin"></span></a>
            </div>
        </div>
    </div>
    <div class="clearBoth"></div>
    <!--Graph Section Start-->
    <div class="graphSec">
        <div class="Box1">
            <div class="fixedBox">
                <h2 class="boxborder c1">TICKET TRANSACTIONS</h2>
                <div class="fs-sort-options"> <span class="sort">Sort By:</span>
                    <div class="fs-select-wrapper">
                        <select id="dateReportType" >
                            <option <?php
                            if ($filterType == 'all') {
                                echo "selected";
                            }
                            ?> value="all">All Time</option>
                            <option <?php
                            if ($filterType == 'month') {
                                echo "selected";
                            }
                            ?> value="month">This Month</option>
                            <option <?php
                            if ($filterType == 'thisweek') {
                                echo "selected";
                            }
                            ?> value="thisweek">This Week</option>
                            <option <?php
                            if ($filterType == 'yesterday') {
                                echo "selected";
                            }
                            ?> value="yesterday">Yesterday</option>
                            <option <?php
                            if ($filterType == 'today') {
                                echo "selected";
                            }
                            ?> value="today">Today</option>
                        </select>
                        <span class="icon-arrow"></span>
                    </div>
                </div>
                <div class="clearBoth"></div>
                <div class="fs-Box1-content">
                    <div class="defaultDroplist">
                        <label class="icon-downarrow">
                            <select id="ticketType">
                                <option <?php
                                if ($ticketId == 0) {
                                    echo "selected";
                                }
                                ?>  value="0">All</option>
                                    <?php foreach ($ticketList as $ticket) {
                                        ?> <option <?php
                                    if ($ticketId == $ticket['id']) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $ticket['id'] ?>"><?php echo $ticket['name'] ?></option><?php }
                                ?>
                            </select>
                        </label>
                    </div>
                    <div class="weekGraph" id="chartContainer"></div>
                </div>
            </div>
        </div>
        <div class="Box1">
            <div class="fixedBox">
                <h2 class="boxborder c2">SALES OVERVIEW</h2>
                <?php if (count($ticketCurrencies) > 0) { ?>
                    <div class="fs-sort-options"> <span class="sort">Currency:</span>
                        <div class="fs-select-wrapper">
                            <select id="totalSaleDataAllCurrencies" class="dashboardBlocksHeaderSelectTag">
                                <?php foreach ($ticketCurrencies as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>" currencyType="<?php echo (!empty($value['currencyCode'])) ? $value['currencyCode'] : 'FREE'; ?>" <?php echo (key($totalSaleData['currencySale']) == $value['currencyCode'] || (empty($value['currencyCode']) && key($totalSaleData['currencySale']) == 'FREE')) ? 'selected' : ''; ?> ><?php echo (!empty($value['currencyCode'])) ? $value['currencyCode'] : 'FREE'; ?></option>
                                <?php } ?>
                            </select>
                            <span class="icon-arrow"></span>
                        </div>
                    </div>
                <?php } ?>

                <div class="clearBoth"></div>
                <div class="fs-Box1-content">
                    <div class="db-BoxStats">
                        <div id="ticketAmountDiv">
                            <div class="db-BoxStatsDiv stats-borderright mb-0imp textcenter">
                                <div class="db-BoxStatsInfo">
                                    <span class="labeltext" id="totalRevenueWithCurrency">TOTAL SALES ( <?php echo key($totalSaleData['currencySale']); ?> )</span>
                                    <p id="saleByCurrency">
                                        <span class="me me-<?php echo strtolower(key($totalSaleData['currencySale'])); ?>"></span><?php echo (!isset($totalSaleData['currencySalePaid'][key($totalSaleData['currencySale'])]) || empty($totalSaleData['currencySalePaid'][key($totalSaleData['currencySale'])])) ? 0 : $totalSaleData['currencySalePaid'][key($totalSaleData['currencySale'])]; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="db-BoxStatsDiv mb-0imp textcenter">
                            <div class="db-BoxStatsInfo">
                                <span class="labeltext">TICKETS SOLD</span>
                                <p id="ticketSoldTotal"><span class="fa fa-ticket"></span><?php echo (isset($totalSaleDataAllCurrencies[key($totalSaleData['currencySale']) . 'quantity'])) ? $totalSaleDataAllCurrencies[key($totalSaleData['currencySale']) . 'quantity'] : 0; // exit; echo $totalSaleData['quantity'];           ?></p>
                            </div>
                        </div>
                        <div class="db-BoxStatsDiv stats-bordertop stats-borderright mb-0imp textcenter">
                            <div class="db-BoxStatsInfo">
                                <span class="labeltext">PAGE VIEWS</span>
                                <p><span class="fa fa-eye"></span><?php echo isset($eventDetail['viewcount']) ? $eventDetail['viewcount'] : 0; ?></p>
                            </div>
                        </div>
                        <div class="db-BoxStatsDiv stats-bordertop mb-0imp textcenter">
                            <div class="db-BoxStatsInfo">
                                <span class="labeltext">CONVERSION RATE</span>
                                <p id="conversionRate"><span class="fa fa-percent"></span><?php echo round((isset($eventDetail['viewcount']) && $eventDetail['viewcount'] > 0 && $totalSaleDataAllCurrencies[key($totalSaleData['currencySale']) . 'quantity'] > 0) ? (($totalSaleDataAllCurrencies[key($totalSaleData['currencySale']) . 'quantity'] / $eventDetail['viewcount']) * 100) : 0); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Second Row-->
        <div class="Box1">
            <div class="fixedBox">
                <h2 class="boxborder c3">SALES EFFORTS</h2>
                <div class="fs-sort-options"> 
                    <span class="sort">Sort By:</span>
                    <div class="fs-select-wrapper">
                        <select id="menulist">
                            <option value="all">All Time</option>
                            <option value="month">This Month</option>
                            <option value="thisweek">This Week</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="today">Today</option>
                        </select>
                        <span class="icon-arrow"></span>
                    </div>
                </div>
                <div class="fs-Box1-content">
                    <div class="defaultDroplist">
                        <label class="icon-downarrow">
                            <select id="salesType" name="salesType">
                                <option value="meraevents">MeraEvents Sales</option>
                                <option value="organizer">Organizer Sales</option>
                                <option value="promoter">Affiliate Marketing Sales</option>
                                <option value="offlinepromoter">Offline Promoter Sales</option>
                                <option value="boxoffice">Box Office Sales</option>
                                <option value="viral">Viral Ticketing Sales</option>
                                <!--<option value="affiliate">Global Affiliate Marketing Sales</option>-->
                                <option value="spotregistration">Spot Registration Sales</option>
                            </select>
                        </label>
                    </div>
                    <div></div>
                    <div class="db-BoxStats">
                        <div class="db-BoxStatsDiv stats-borderright mb-0imp textcenter">
                            <div class="db-BoxStatsInfo">
                                <span class="labeltext">TICKETS SOLD</span>
                                <p id="salesEffortTickets"><span class="fa fa-ticket"></span><?php echo $salesEffortData['quantity']; ?></p>
                            </div>
                        </div>
                        <div class="db-BoxStatsDiv mb-0imp textcenter">
                            <div class="db-BoxStatsInfo">
                                <span class="labeltext">REGISTERED USERS</span>
                                <p id="registeredusers"><span class="fa fa-users"></span><?php echo isset($salesEffortData['registeredusers']) ? $salesEffortData['registeredusers'] : 0; ?></p>
                            </div>
                        </div>
                        <div id="salesEffortAmounts">
                            <?php
                            if (is_array($salesEffortData['currencySale'])) {
                                $keySalesEffort = 0;
                                foreach ($salesEffortData['currencySalePaid'] as $key => $value) {
                                    if (!empty($key) && strpos($key, 'quantity') == false) {
                                        if ($key != 'FREE') {
                                            if (!empty($key))
                                                $keySalesEffort++;
                                            ?>
                                            <div class="db-BoxStatsDiv stats-bordertop <?php if ($keySalesEffort % 2 != 0) { ?>stats-borderright<?php } ?> mb-0imp textcenter"><!-- border-rb -->
                                                <div class="db-BoxStatsInfo">
                                                    <span class="labeltext">REVENUE <?php
                                                        if ($key != 'INR' && $key != 'USD') {
                                                            echo '(' . $key . ')';
                                                        }
                                                        ?></span>
                                                    <p>
                                                        <span class="me me-<?php echo strtolower($key); ?>"></span><?php echo $value; ?></p>
                                                        <!-- <span class="icon2-rupee"></span>  -->
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                }
                                if (count($salesEffortData['currencySale']) == 1 || (count($salesEffortData['currencySale']) == 2 && array_key_exists("FREE", $salesEffortData['currencySale']))) {
                                    $cKeys = array_keys($salesEffortData['currencySale']);
                                    if (!in_array('INR', $cKeys)) {
                                        ?>
                                        <div class="db-BoxStatsDiv stats-bordertop mb-0imp textcenter"><!-- border-rb -->
                                            <div class="db-BoxStatsInfo">
                                                <span class="labeltext">REVENUE</span>
                                                <p><span class="me me-inr"></span>0</p>
                                                <!-- <span class="icon2-rupee"></span>  -->
                                            </div>
                                        </div>
                                    <?php } elseif (!in_array('USD', $cKeys)) { ?>
                                        <div  class="db-BoxStatsDiv stats-bordertop mb-0imp textcenter"><!-- border-rb -->
                                            <div class="db-BoxStatsInfo">
                                                <span class="labeltext">REVENUE</span>
                                                <p><span class="me me-usd"></span>0</p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    if ((count($salesEffortData['currencySale']) == 1 && array_key_exists("FREE", $salesEffortData['currencySale']))) {
                                        ?>
                                        <div  class="db-BoxStatsDiv stats-bordertop mb-0imp textcenter stats-borderleft"><!-- border-rb -->
                                            <div class="db-BoxStatsInfo">
                                                <span class="labeltext">REVENUE</span>
                                                <p><span class="me me-usd"></span>0</p>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <div class="db-BoxStatsDiv stats-bordertop mb-0imp textcenter stats-borderright">
                                    <div class="db-BoxStatsInfo">
                                        <span class="labeltext">REVENUE</span>
                                        <p><span class="me me-inr"></span>0</p>
                                    </div>
                                </div>
                                <div class="db-BoxStatsDiv stats-bordertop mb-0imp textcenter">
                                    <div class="db-BoxStatsInfo">
                                        <span class="labeltext">REVENUE</span>
                                        <p><span class="me me-usd"></span>0</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--ME & Organizer Sales -->
        <div class="Box1">
            <div class="fixedBox">
                <h2 class="boxborder c4">ORGANIZER VS MERAEVENTS EFFORTS</h2>
                <?php if (count($ticketCurrencies) > 0) { ?>
                    <div class="fs-sort-options"> <span class="sort">Currency:</span>
                        <div class="fs-select-wrapper">
                            <select id="organizerVsMeraEvents" class="dashboardBlocksHeaderSelectTag">
                                <!--   <option value="all">All</option> -->
                                <?php foreach ($ticketCurrencies as $key => $value) { ?>
                                    <option value="<?php echo (!empty($value['currencyCode'])) ? $value['currencyCode'] : 'FREE'; ?>" <?php echo (key($totalSaleData['currencySale']) == $value['currencyCode'] || (empty($value['currencyCode']) && key($totalSaleData['currencySale']) == 'FREE') ) ? 'selected' : ''; ?> ><?php echo (!empty($value['currencyCode'])) ? $value['currencyCode'] : 'FREE'; ?></option>
                                <?php } ?>
                            </select>
                            <span class="icon-arrow"></span>
                        </div>
                    </div>
                <?php } ?>

                <div class="clearBoth"></div>
                <div class="fs-Box1-content">
                    <div class="db-BoxStats faicon">
                        <div class="db-StatsGraph">
                            <div class="db-BoxGraphDiv"><!-- border-rb -->
                                <div class="db-BoxStatsInfo">
                                    <p class="effortstext">Organizer</p>
                                    <div class="GaugeDiv">
                                        <div id="orgSalesGraph"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="db-BoxGraphDiv">
                                <div class="db-BoxGraphInfo stats-borderright">
                                    <span class="labeltext">TICKETS SOLD</span>
                                    <p id="organizerTicketCount"><span class="fa fa-ticket"></span> <?php echo (isset($orgVsMeEfforts['organizerEfforts'][key($totalSaleData['currencySale']) . 'quantity']) && $orgVsMeEfforts['organizerEfforts'][key($totalSaleData['currencySale']) . 'quantity'] > 0 ) ? $orgVsMeEfforts['organizerEfforts'][key($totalSaleData['currencySale']) . 'quantity'] : 0; ?></p>
                                </div>
                                <?php if (isset($orgVsMeEfforts['organizerEfforts'][key($totalSaleData['currencySale'])])) { ?>
                                    <div class="db-BoxGraphInfo">
                                        <span class="labeltext">REVENUE </span>
                                        <p id="organizerCurrencyWiseAmount">
                                            <span class="me me-<?php echo strtolower(key($totalSaleData['currencySale'])); ?>"></span>
                                            <?php echo $orgVsMeEfforts['organizerEfforts'][key($totalSaleData['currencySale'])]; ?></p>
                                    </div>
                                <?php } else { ?>
                                    <div class="db-BoxGraphInfo">
                                        <span class="labeltext">REVENUE</span>
                                        <p  id="organizerCurrencyWiseAmount"><span class="me me-<?php echo strtolower(key($totalSaleData['currencySale'])); ?>"></span>0</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="db-StatsGraph">
                            <div class="db-BoxGraphDiv"><!-- border-rb -->
                                <div class="db-BoxStatsInfo">
                                    <p class="effortstext">MeraEvents</p>
                                    <div class="GaugeDiv"><!--class="GaugeDiv"-->
                                        <div id="orgSalesGraph1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="db-BoxGraphDiv">
                                <div class="db-BoxGraphInfo stats-borderright">
                                    <span class="labeltext">TICKETS SOLD</span>
                                    <p id="meraeventsTicketCount" ><span class="fa fa-ticket"></span> <?php echo (isset($orgVsMeEfforts['meraeventsEfforts'][key($totalSaleData['currencySale']) . 'quantity']) && $orgVsMeEfforts['meraeventsEfforts'][key($totalSaleData['currencySale']) . 'quantity'] > 0 ) ? $orgVsMeEfforts['meraeventsEfforts'][key($totalSaleData['currencySale']) . 'quantity'] : 0; ?></p>
                                </div>
                                <?php if (isset($orgVsMeEfforts['meraeventsEfforts'][key($totalSaleData['currencySale'])])) { ?>
                                    <div class="db-BoxGraphInfo">
                                        <span class="labeltext">REVENUE </span>
                                        <p id="meraeventsCurrencyWiseAmount">
                                            <span class="me me-<?php echo strtolower(key($totalSaleData['currencySale'])); ?>"></span>
                                            <?php echo $orgVsMeEfforts['meraeventsEfforts'][key($totalSaleData['currencySale'])]; ?></p>
                                    </div>
                                <?php } else { ?>
                                    <div class="db-BoxGraphInfo">
                                        <span class="labeltext">REVENUE</span>
                                        <p id="meraeventsCurrencyWiseAmount"><span class="me me-<?php echo strtolower(key($totalSaleData['currencySale'])); ?>"></span>0</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--ME & Organizer Sales -->
        <div class="Box1" style="width:100%;">
            <div class="fixedBox">
                <h2 class="boxborder c5">TICKET WIDGET CODE</h2>
                <div class="fs-Box1-content height200">
                    <div class="pb-30imp">
                        <p>If you want to embed the tickets on your website in a single window, Copy below HTML code and paste it on your website</p> 
                        <p class="widgetcopylink tooltip-left hoeverclass" id="copyEventWURLSW" data-tooltip="Copy to Clipboard"><span class="icon2-copy"></span> Copy Code</p>
                        <div class="generate">
                            <?php
                            if ($parenteventid > 0) {
                                $widgetUrl = commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $parenteventid . '&ucode=organizer&wcode=9063CD-9063CD-333333-9063CD-&theme=1&samepage=1&sub=' . $eventId . '');
                            } else {
                                $widgetUrl = commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer&wcode=9063CD-9063CD-333333-9063CD-&theme=1&samepage=1');
                            }
                            ?>
                            <textarea id="eventWURLSW" readonly="readonly" cols="80" rows="4" class="textarea" class="lineheight20"><iframe src="<?= $widgetUrl ?>" width="100%" height="600px" frameborder="0px" ></iframe></textarea>
                        </div>
                        <input type="hidden" id='url_val' value="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer&samepage=1'); ?>"/>
                    </div>
                    <div class="pb-30imp" style="display: none;">
                        <p>If you want to embed the tickets in your website, Copy below HTML code and paste it on your website</p> 
                        <p class="widgetcopylink tooltip-left hoeverclass" id="copyEventWURL" data-tooltip="Copy to Clipboard"><span class="icon2-copy"></span> Copy Code</p>

                        <div class="generate">
                            <textarea id="eventWURL" readonly="readonly" cols="80" rows="4" class="textarea" class="lineheight20"><iframe id="ticketWidget" src="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer'); ?>" width="100%" height="600px" frameborder="0px" ></iframe></textarea>
                        </div>
                        <input type="hidden" id='url_val' value="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer'); ?>"/>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $totaltickets = count($ticketList);
        if ($totaltickets > 0) {
            ?>
            <div class="fixedBox Box1" style="width:100% !important">
                <div class="fixedBox">
                    <h2 class="boxborder c6">TICKETS </h2>

                    <div class="tickets-table overflow">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-mode="swipe" data-tablesaw-minimap="" class="tablesaw-swipe">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Start/ End Dates</th>
                                    <th>Tax</th>
                                    <th>Sold</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody> 

                                <?php foreach ($ticketList as $value) { ?>
                                    <tr>
                                        <td><?php echo $value['name']; ?></td>
                                        <td>
                                            <?php
                                            if ($value['type'] == 'paid' || $value['type'] == 'addon') {
                                                echo ('<span class="me me-' . strtolower($value['currencyCode']) . '"></span>') . " " . number_format($value['price']) . ($value['currencyCode'] == 'SGD' ? '<br>(SGD)' : '');
                                            } elseif ($value['type'] == 'donation') {
                                                echo ('<span class="me me-' . strtolower($value['currencyCode']) . '"></span>') . " ---" . ($value['currencyCode'] == 'SGD' ? '<br>(SGD)' : '');
                                            } elseif ($value['type'] == 'free') {
                                                echo '0';
                                            }
                                            ?> 
                                        </td>
                                        <td><?php echo "Start: " . date('d-m-Y', strtotime($value['startDate'])) . "</br>End: " . date('d-m-Y', strtotime($value['endDate'])); ?></td>
                                        <td>
                                            <?php
                                            if (!empty($taxDetails[$value['id']])) {
                                                foreach ($taxDetails[$value['id']] as $key => $v) {
                                                    $shortTaxlabel = '';
                                                    $shortTaxlabel .= $v['label'];
                                                    echo rtrim(strtoupper($shortTaxlabel), '.') . " " . $v['value'] . " %</br>";
                                                }
                                            } else {
                                                echo '--';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $value['tkt_qty']; ?></td>
                                        <td><?php
                                            $className = 'LiveBtn';
                                            $buttonValue = 'Live';
                                            if ($value['soldout'] == 1 || ($value['quantity'] <= $value['totalSoldTickets'])) {
                                                $className = 'SoldOutBtn';
                                                $buttonValue = 'SoldOut';
                                            } else if (strtotime($value['endDate']) < strtotime((convertTime(allTimeFormats('', 11), $eventTimeZoneName, TRUE)))) {
                                                $className = 'SoldOutBtn';
                                                $buttonValue = 'Sale Ended';
                                            } else if ($value['displayStatus'] == 0) {
                                                $className = 'HiddenBtn';
                                                $buttonValue = 'Hidden';
                                            }
                                            ?>
                                            <button type="button" class="btn <?php echo $className; ?>  defaultCursor"><?php echo $buttonValue; ?></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if (count($ticketList) > 0) { ?>
                            <div style="float:right;">
                                <span id="sendsuccess" style="float: left; padding: 20px 10px 0 0;"></span>
                                <a href="javascript:;" class="submitBtn createBtn float-right"  id="send_ticketslist" style="margin:20px 5px;   float: right;">Send Email</a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
<script>
    var api_reportsGetWeekwiseSales = "<?php echo commonHelperGetPageUrl('api_reportsGetWeekwiseSales') ?>";
    var api_reportsSalesEffortReports = '<?php echo commonHelperGetPageUrl('api_reportsSalesEffortReports'); ?>';
    var api_sendTicketsoldDataToorganizer = '<?php echo commonHelperGetPageUrl('api_sendTicketsoldDataToorganizer'); ?>';
    var filterType = '<?php echo $filterType; ?>';
    var weekWiseJSONData = '<?php echo json_encode($weekWiseData); ?>';
    // var currencyCode='<?php echo $currencyCode . ' '; ?>';

</script>
<?php if ($totaltickets > 0) { ?>
    <script>
        $(function () {
            $('#send_ticketslist').on('click', function () {
                var pageUrl = api_sendTicketsoldDataToorganizer;
                var eventId = $('#eventId').val();
                var userEmail = "<?php echo $this->customsession->getData('userEmail'); ?>";
                var userId = "<?php echo $this->customsession->getData('userId'); ?>";
                var input = 'eventId=' + eventId + '&userEmail=' + userEmail + '&userId=' + userId;
                var method = 'POST';
                var dataFormat = 'JSON';
                $("#sendsuccess").html('<img id="success-img" src="../../images/me-loading.gif">');
                getPageResponse(pageUrl, method, input, dataFormat, callbackSuccess, callbackFailure);
                function callbackFailure(result) {
                    //            $("#sendsuccess").html(result.responseJSON.response.messages);
                    alert("Email not Sent. Try later");
                }
                function callbackSuccess(result) {
                    $("#sendsuccess").html('Mail sent Successfully');
                    setTimeout(function () {
                        $("#sendsuccess").html('');
                    }, 2000);
                    // window.location.href = site_url+result.response.filepath;
                }
            });
            $('.graphSec ,.db_Eventbox').matchHeight();

        });
        var defaultCurrency = '<?php echo key($totalSaleData['currencySale']); ?>';
        var salesEffortDataArray = '<?php echo json_encode($orgVsMeEfforts); ?>';
        var orgVsME = '<?php echo json_encode($orgVsMESales); ?>';
        var totalSaleQty = '<?php echo $totalSaleData['quantity']; ?>';
        var pageViews = '<?php echo isset($eventDetail['viewcount']) ? $eventDetail['viewcount'] : 0; ?>'
        var api_getTinyUrl = "<?php echo commonHelperGetPageUrl('api_getTinyUrl') ?>";
        var event_url = "<?php echo $linkToShare; ?>";
        var tweet = "<?php echo $tweet; ?>";
        var api_checkBankDetailsFilled = '<?php echo commonHelperGetPageUrl('api_checkBankDetailsFilled') ?>';
        var event_home_url = '<?php echo commonHelperGetPageUrl('dashboard-eventhome') ?>';
    </script>
<?php } ?>


<script src="<?php echo $this->config->item('js_public_path') . 'dashboard/fusioncharts/js/fusioncharts.js'; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path') . 'dashboard/fusioncharts/js/themes/fusioncharts.theme.fint.js'; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path') . 'dashboard/justgage/raphael-2.1.4.min.js'; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path') . 'dashboard/justgage/justgage.js'; ?>"></script>
