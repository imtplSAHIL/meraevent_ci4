<?php
$eventName = (isset($eventDetail['eventName'])) ? $eventDetail['eventName'] : '';
$isMultiDateEvent = (isset($eventDetail['isMultiDateEvent'])) ? $eventDetail['isMultiDateEvent'] : '';
$startDateTime = isset($eventDetail['startDateTime']) ? allTimeFormats(convertTime($eventDetail['startDateTime'], $eventTimeZoneName, TRUE), 15) : '';
$endDateTime = isset($eventDetail['endDateTime']) ? allTimeFormats(convertTime($eventDetail['endDateTime'], $eventTimeZoneName, TRUE), 15) : '';
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
    <div class="db-bg-holder"> <div class="heading float-left">
            <h2><?php echo $eventName; ?></h2>
            <ul>
                <li class="linkscolor"><span class="fa fa-calendar paddingright"></span><?php echo $startDateTime; ?> <?php
                    if ($isMultiDateEvent == TRUE) {
                        echo '- ' . $endDateTime;
                    }
                    ?> <?php echo $timezone; ?></li>
                <li class="linkscolor"><span class="fa fa-map-marker paddingright"></span><?php echo $eventDetail['venueName']; ?></li>
            </ul>
        </div>
        <div class="fs-settings-buttons">
            <?php if ($isCurrentEvent) { ?>
                <a href="<?php echo commonHelperGetPageUrl('edit-event', $eventId); ?>"><button type="button" class="Edit-Btn blueborder"><span class="fa fa-edit"></span>Edit</button></a>
            <?php } ?>
            <a href="<?php echo commonHelperGetPageUrl('event-preview', '', '?view=preview&eventId=' . $eventId); ?>" target="_blank"> <button type="button" class="Edit-Btn greenborder"><span class="fa fa-eye"></span>Preview</button></a>
        </div>
    </div>

    <div class="db-org-url">
        <p>Organizer Link</p>
        <div class="paddingtb10">
            <a id="eventURL" href="<?php echo $eventUrl . '?ucode=organizer'; ?>" target="_blank" class="linkscolor"><span class="mce-ico mce-i-link"></span><?php echo $eventUrl . '?ucode=organizer'; ?></a>
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
        <div class="Box1" style="width:100%;">
            <div class="fixedBox">
                <div class="multidate-nav">
                    <div class="">
                        <ul class="multidate-nav-list multidate-nav-tabs multidatetab-group">
                            <li class="active"><a href="#multidateupcoming">Upcoming Events</a></li>
                            <li><a href="#multidatepast">Past Events</a></li>
                        </ul>
                        <div class="multidatetab-content">
                            <?php if (count($ticketCurrencies) > 0) { ?>
                                <section class="floatright">
                                    <section class="fs-sort-options"> <span class="sort">Sort By:</span>
                                        <div class="fs-select-wrapper">
                                            <select class="optionsdropdown" id="multieventdropdown">
                                                <?php foreach ($ticketCurrencies as $key => $value): ?>
                                                    <option><?php echo (strlen($value['currencyCode']) > 0 ) ? $value['currencyCode'] : 'FREE'; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="icon-arrow"></span>
                                        </div>
                                    </section>
                                </section>
                            <?php } ?>

                            <div id="multidateupcoming" class="multidate-tab-content active">
                                <section class="height400 zeropadimp tickets-table overflow"><!-- tickets-table overflow  -->
                                    <?php $totalPresentChildEvents = count($presentChildEvents); ?>
                                    <?php if ($totalPresentChildEvents > 0) { ?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablesaw-swipe">
                                            <thead>
                                                <tr>
                                                    <th>DATE & TIME</th>
                                                    <th>TOTAL SALES</th>
                                                    <th>TICKETS SOLD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($presentChildEvents as $event) { ?>
                                                    <tr>
                                                        <td class="multidate-eventlink"><a href="<?php echo commonHelperGetPageUrl('dashboard-eventhome') . $event['eventId'] ?>"><?php echo allTimeFormats($event['eventStartDate'], 3) . ' ' . allTimeFormats($event['eventStartDate'], 4) . ' ' . $event['timezone']; ?></a></td>
                                                        <td>
                                                            <?php $i = 1; ?>
                                                            <?php foreach ($ticketCurrencies as $key => $value) { ?>
                                                                <?php if ($value['currencyId'] != 3) { ?>
                                                                    <?php if ($event['totalpaid'][$value['currencyCode']] != 0 && empty($event['totalpaid'][$value['currencyCode']]) == FALSE) { ?>
                                                                        <p class = 'amount' id = '<?php echo 'a_' . $value['currencyCode']; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>><?php
                                                                               if ($value['currencyCode'] != 'FREE') {
                                                                                   echo $value['currencyCode'] . ' ';
                                                                               } echo $event['totalpaid'][$value['currencyCode']];
                                                                               ?></p>
                                                                    <?php } else { ?>
                                                                        <p class = 'amount' id = '<?php echo 'a_' . $value['currencyCode']; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>0</p>
                                                                       <?php } ?>
                                                                   <?php } else { ?>
                                                                       <?php if ($event['totalpaid']['FREE'] != 0 && empty($event['totalpaid']['FREE']) == FALSE) { ?>
                                                                        <p class = 'amount' id = '<?php echo 'a_FREE'; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>><?php echo $event['totalpaid']['FREE']; ?></p>
                                                                       <?php } else { ?>
                                                                        <p class = 'amount' id = '<?php echo 'a_FREE'; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>0</p>
                                                                       <?php } ?>
                                                                   <?php } $i++; ?>
                                                               <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php $i = 1; ?>
                                                            <?php foreach ($ticketCurrencies as $key => $value) { ?>
                                                                <?php if ($value['currencyId'] != 3) { ?>
                                                                    <?php if ($event['totalpaid'][$value['currencyCode'] . 'quantity'] != 0 && empty($event['totalpaid'][$value['currencyCode'] . 'quantity']) == FALSE) { ?>
                                                                        <p class = 'quantity' id = '<?php echo 'q_' . $value['currencyCode']; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>  <?php echo $event['totalpaid'][$value['currencyCode'] . 'quantity']; ?></p>
                                                                       <?php } else { ?>
                                                                        <p class = 'quantity' id = '<?php echo 'q_' . $value['currencyCode']; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>0</p>
                                                                       <?php } ?>
                                                                   <?php } else { ?>
                                                                       <?php if ($event['totalpaid']['FREEquantity'] != 0 && empty($event['totalpaid']['FREEquantity']) == FALSE) { ?>
                                                                        <p class = 'quantity' id = '<?php echo 'q_FREE'; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>><?php echo $event['totalpaid']['FREEquantity']; ?></p>
                                                                       <?php } else { ?>
                                                                        <p class = 'quantity' id = '<?php echo 'q_FREE'; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>0</p>
                                                                       <?php } ?>
                                                                   <?php } $i++; ?>
                                                               <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <h2>No events found!</h2>
                                    <?php } ?>
                                </section><!-- end of fs-Box1-content -->
                            </div>
                            <div id="multidatepast" class="multidate-tab-content hide">
                                <section class="height400 zeropadimp tickets-table overflow"><!-- tickets-table overflow  -->
                                    <?php $totalPastChildEvents = count($pastChildEvents); ?>
                                    <?php if ($totalPastChildEvents > 0) { ?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablesaw-swipe">
                                            <thead>
                                                <tr>
                                                    <th>DATE & TIME</th>
                                                    <th>TOTAL SALES</th>
                                                    <th>TICKETS SOLD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pastChildEvents as $event) { ?>
                                                    <tr>
                                                        <td class="multidate-eventlink"><a href="<?php echo commonHelperGetPageUrl('dashboard-eventhome') . $event['eventId'] ?>"><?php echo allTimeFormats($event['eventStartDate'], 3) . ' ' . allTimeFormats($event['eventStartDate'], 4) . ' ' . $event['timezone']; ?></a></td>
                                                        <td>
                                                            <?php $i = 1; ?>
                                                            <?php foreach ($ticketCurrencies as $key => $value) { ?>
                                                                <?php if ($value['currencyId'] != 3) { ?>
                                                                    <?php if ($event['totalpaid'][$value['currencyCode']] != 0 && empty($event['totalpaid'][$value['currencyCode']]) == FALSE) { ?>
                                                                        <p class = 'amount' id = '<?php echo 'a_' . $value['currencyCode']; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>><?php
                                                                               if ($value['currencyCode'] != 'FREE') {
                                                                                   echo $value['currencyCode'] . ' ';
                                                                               } echo $event['totalpaid'][$value['currencyCode']];
                                                                               ?></p>
                                                                    <?php } else { ?>
                                                                        <p class = 'amount' id = '<?php echo 'a_' . $value['currencyCode']; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>0</p>
                                                                       <?php } ?>
                                                                   <?php } else { ?>
                                                                       <?php if ($event['totalpaid']['FREE'] != 0 && empty($event['totalpaid']['FREE']) == FALSE) { ?>
                                                                        <p class = 'amount' id = '<?php echo 'a_FREE'; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>><?php echo $event['totalpaid']['FREE']; ?></p>
                                                                       <?php } else { ?>
                                                                        <p class = 'amount' id = '<?php echo 'a_FREE'; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>0</p>
                                                                       <?php } ?>
                                                                   <?php } $i++; ?>
                                                               <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php $i = 1; ?>
                                                            <?php foreach ($ticketCurrencies as $key => $value) { ?>
                                                                <?php if ($value['currencyId'] != 3) { ?>
                                                                    <?php if ($event['totalpaid'][$value['currencyCode'] . 'quantity'] != 0 && empty($event['totalpaid'][$value['currencyCode'] . 'quantity']) == FALSE) { ?>
                                                                        <p class = 'quantity' id = '<?php echo 'q_' . $value['currencyCode']; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>  <?php echo $event['totalpaid'][$value['currencyCode'] . 'quantity']; ?></p>
                                                                       <?php } else { ?>
                                                                        <p class = 'quantity' id = '<?php echo 'q_' . $value['currencyCode']; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>0</p>
                                                                       <?php } ?>
                                                                   <?php } else { ?>
                                                                       <?php if ($event['totalpaid']['FREEquantity'] != 0 && empty($event['totalpaid']['FREEquantity']) == FALSE) { ?>
                                                                        <p class = 'quantity' id = '<?php echo 'q_FREE'; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>><?php echo $event['totalpaid']['FREEquantity']; ?></p>
                                                                       <?php } else { ?>
                                                                        <p class = 'quantity' id = '<?php echo 'q_FREE'; ?>' <?php
                                                                        if ($i != 1) {
                                                                            echo 'style="display: none;"';
                                                                        };
                                                                        ?>>0</p>
                                                                       <?php } ?>
                                                                   <?php } $i++; ?>
                                                               <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <h2>No events found!</h2>
                                    <?php } ?>
                                </section><!-- end of fs-Box1-content -->
                            </div>
                        </div>
                    </div>
                </div> <!--End Multidate Nav-->
            </div><!--End of Fixed  Box-->
        </div><!--Box1-->

        <div class="Box1" style="width:100%;">
            <div class="fixedBox">
                <h2 class="boxborder c5">TICKET WIDGET CODE</h2>
                <div class="fs-Box1-content height200">
                    <div class="pb-30imp">
                        <p>If you want to embed the tickets on your website in a single window, Copy below HTML code and paste it on your website</p> 

                        <p class="widgetcopylink tooltip-left hoeverclass" id="copyEventWURLSW" data-tooltip="Copy to Clipboard"><span class="icon2-copy"></span> Copy Code</p>

                        <div class="generate">
                            <textarea id="eventWURLSW" readonly="readonly" cols="80" rows="4" class="textarea" class="lineheight20"><iframe src="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer&wcode=9063CD-9063CD-333333-9063CD-&theme=1'); ?>" width="100%" height="600px" frameborder="0px" ></iframe></textarea>
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

    </div>
</div>

<input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
<script>
    var api_sendTicketsoldDataToorganizer = '<?php echo commonHelperGetPageUrl('api_sendTicketsoldDataToorganizer'); ?>';
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
        var pageViews = '<?php echo isset($eventDetail['viewcount']) ? $eventDetail['viewcount'] : 0; ?>'
        var api_getTinyUrl = "<?php echo commonHelperGetPageUrl('api_getTinyUrl') ?>";
        var event_url = "<?php echo $linkToShare; ?>";
        var tweet = "<?php echo $tweet; ?>";
        var api_checkBankDetailsFilled = '<?php echo commonHelperGetPageUrl('api_checkBankDetailsFilled') ?>';
    </script>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('.multidate-nav-tabs > li > a').click(function (event) {
            event.preventDefault(); //stop browser to take action for clicked anchor
            //get displaying tab content jQuery selector
            var active_tab_selector = $('.multidate-nav-tabs > li.active > a').attr('href');
            //find actived navigation and remove 'active' css
            var actived_nav = $('.multidate-nav-tabs > li.active');
            actived_nav.removeClass('active');
            //add 'active' css into clicked navigation
            $(this).parents('li').addClass('active');
            //hide displaying tab content
            $(active_tab_selector).removeClass('active');
            $(active_tab_selector).addClass('hide');
            //show target tab content
            var target_tab_selector = $(this).attr('href');
            $(target_tab_selector).removeClass('hide');
            $(target_tab_selector).addClass('active');
        });
    });
</script>