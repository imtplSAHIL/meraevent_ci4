<div class="rightArea">
    <div class="heading float-left">
        <h2>Ticket Widget Code: <span><?php echo $eventName; ?></span></h2>
    </div>
    <div class="clearBoth"></div>
    <!--Data Section Start-->

    <div class="previewSec">
        <!-- <div class="fs-form fs-form-widget-setting">
                                <h2 class="fs-box-title">Preview</h2>
                                <img alt="Ticket Widget" src="<?php echo $this->config->item('images_static_path'); ?>ticket_widget.jpg" />
        </div> -->
        <!-- <div class="grid-row padding20">
                        <div class="fs-form fs-form-widget-setting">
                       </div>
        </div> -->

        <!--Ticket Widget Theme Section-->
        <div class="grid-row padding20 pb-0imp" style="display: none;">
            <div class="grid-lg-12 grid-md-12 grid-sm-12 nopadding">
                <div class="fs-form fs-form-widget-setting boxshadow">
                    <h2 class="fs-box-title">Select Ticket Widget Theme</h2>
                    <div class="ticketFields fs-form-content">
                        <div onclick="selecttheme(0, this);" class="ticketwidget-theme-option grid-lg-2 grid-md-2 grid-sm-6 grid-xs-12 widgetselected">
                            <a>Theme One</a>
                        </div>
                        <div onclick="selecttheme(1, this);" class="ticketwidget-theme-option grid-lg-2 grid-md-2 grid-sm-6 grid-xs-12">
                            <a>Theme Two</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Ticket Widget Theme Section-->

        <div class="grid-row padding20">
            <div class="grid-lg-6 grid-md-12 grid-sm-12 nopadding">
                <div class="fs-form fs-form-widget-setting boxshadow">
                    <h2 class="fs-box-title">Ticket Fields</h2>
                    <div class="ticketFields fs-form-content">
                        <div class="grid-lg-12 grid-sm-12 grid-xs-12 nopadding">
                            <div class="WidgetSelectOptions">
                                <select id="theme" style="display: none;">
                                    <option value="1">Theme 1</option>
                                </select>
                                <p class="head">Select Options</p>
                                <p><label><input type="checkbox" checked="checked" name="" id="showTitle"/> Show Event Title</label></p>
                                <p><label><input type="checkbox" checked="checked" name="" id="showDateTime"/> Show Event Date & Time</label></p>
                                <p><label><input type="checkbox" checked="checked" name="" id="showLocation"/> Show Event Location</label></p>
                                <?php if (!empty($tickets['response']['ticketName']) && count($tickets['response']['ticketName']) == 1) { ?>
                                <p><label><input type="checkbox" name="" id="directDetails"/> Remove Tickets Tab</label></p>
                                <?php } ?>
                                <p class="head">Select Ticket Options</p>
                                <ul>
                                    <li style="float: left; width: 30%"><label><input type="radio" checked="checked" name="ticket_option" value="1" id="ticketOptionAll"/> All Tickets</label></li>
                                    <li style="float: left; width: 30%"><label><input type="radio" name="ticket_option" value="2" id="ticketOptionTicket"/> Tickets</label></li>
                                    <?php if (!empty($ticketgroups['response']['ticketgroups'])) { ?>
                                        <li style="float: left; width: 30%"><label><input type="radio" name="ticket_option" value="3" id="ticketOptionGroup"/> Ticket Groups</label></li>
                                    <?php } ?>
                                </ul>
                                <?php if (!empty($tickets['response']['ticketName'])) { ?>
                                    <div id="ticket_level" style="clear: both; display: none">
                                        <?php foreach ($tickets['response']['ticketName'] as $ticket) { ?>
                                            <div><label><input type="checkbox" checked="checked" value="<?= $ticket['id']; ?>"/> <?= $ticket['name']; ?></label></div>
                                        <?php } ?>
                                    </div>
                                <?php } if (!empty($ticketgroups['response']['ticketgroups'])) { ?>
                                    <div id="group_level" style="clear: both; display: none">
                                        <?php foreach ($ticketgroups['response']['ticketgroups'] as $ticket_group) { ?>
                                            <div><label><input type="checkbox" checked="checked" value="<?= $ticket_group['id']; ?>"/> <?= $ticket_group['name']; ?></label></div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="grid-lg-6 grid-md-6 grid-sm-6 grid-xs-12 nopadding">
                                <span class="fs-color-code-for">Event Title Text Color</span>
                                <div class="colorCode">
                                    <input class="color colorpicker" id="event_title_color" value="1789A3">
                                </div>
                            </div>
                            <div class="grid-lg-6 grid-md-6 grid-sm-6 grid-xs-12 nopadding">
                                <span class="fs-color-code-for">Heading Background Color</span>
                                <div class="colorCode">
                                    <input class="color colorpicker" id="heading_bg_color" value="1789A3">
                                </div>
                            </div>
                            <div class="grid-lg-6 grid-md-6 grid-sm-6 grid-xs-12 nopadding">
                                <span class="fs-color-code-for">Ticket Text Color</span>
                                <div class="colorCode">
                                    <input class="color colorpicker" id="ticket_txt_color" value="333333">
                                </div>
                            </div>
                            <div class="grid-lg-6 grid-md-6 grid-sm-6 grid-xs-12 nopadding">
                                <span class="fs-color-code-for">Book Now Button Color</span>
                                <div class="colorCode">
                                    <input class="color colorpicker" id="book_bt_color" value="81c868">
                                </div>
                            </div>
                            <div class="grid-lg-10 nopadding margintop20">
                                <form id="ticketwidget" name="ticketwidget">
                                    <label class="widthfloat">Iframe Height in Pixels ( Ex : 700 )</label>
                                    <input type="text" class="textfield" id="iframe_height" name="Iframeheight" value="600">
                                    <label style="" class="theme1hide">Redirect URL(Will redirect to mentioned URL after booking success)</label>
                                    <input style="" type="text" class="textfield theme1hide" name="redirect_url" id="redirect_url">
                                </form>
                                <button type="button" class="createBtn float-right" name="widget_button" id="widget_button">generate code</button>
                            </div>
                        </div><!--End First Grid-->
                    </div>
                </div>
            </div>

            <div class="grid-lg-6 grid-md-12 grid-sm-12 nopadding">
                <div class="fs-form fs-form-widget-setting boxshadow">
                    <h2 class="fs-box-title">Embed the Tickets</h2>
                    <div class="fs-form fs-form-widget-setting">
                        <div class="ticketFields fs-form-content"><!-- fs-form-content -->
                            <p>If you want to embed the tickets in your website, Copy below HTML code and paste it on your website</p><br>
                            <p style="padding: 5px 0px">Widget code for All Tickets</p>
                            <div class="generate">
                                <textarea readonly="readonly" cols="80" rows="4" id="allTicketArea" style="margin-bottom: 0px;" class="lineheight20 textarea"><iframe src="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer') . '&wcode=9063CD-9063CD-333333-9063CD-&theme=1&samepage=1'; ?>" width="100%" height="600px" frameborder="0px" ></iframe></textarea>
                                <p class="widgetcopylink tooltip-left hoeverclass" id="copyAllTicketArea" data-tooltip="Copy to Clipboard"><span class="icon2-copy"></span> Copy Code</p>
                            </div>
                            <p style="clear: both; padding: 5px 0px">Widget code with customization</p>
                            <div class="generate">
                                <textarea readonly="readonly" cols="80" rows="6" id="text_area"` style="margin-bottom: 0px;" class="lineheight20 textarea"><iframe src="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer') . '&wcode=9063CD-9063CD-333333-9063CD-&theme=1&samepage=1'; ?>" width="100%" height="600px" frameborder="0px" ></iframe></textarea>
                                <p class="widgetcopylink tooltip-left hoeverclass" id="copyCustomArea" data-tooltip="Copy to Clipboard"><span class="icon2-copy"></span> Copy Code</p>
                            </div>
                            <input type="hidden" id='url_val' value="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer'); ?>"/>
                            <p style="clear: both; padding: 5px 0px">Widget Code with referral rcode tracking</p>
                            <div class="generate">
                            <textarea readonly="readonly" cols="80" rows="6" id="rcodearea" style="margin-bottom: 0px;" class="lineheight20 textarea">
<iframe id="me_widget" width="100%" height="600px" frameborder="0px"></iframe>
<script>
var URL = window.location.href;
var URLon = URL.split("?");
var rcodevalue = '';
URLon.forEach(function (item) {
tmp = item.split("=");
if (tmp[0] === 'rcode') {
rcodevalue = decodeURIComponent(tmp[1]);
}
});
document.getElementById('me_widget').src = '<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId ); ?>&ucode=organizer&wcode=9063CD-9063CD-333333-9063CD-&theme=1&samepage=1&rcode=' + rcodevalue;
</script>
                            </textarea>
                                <p class="widgetcopylink tooltip-left hoeverclass" id="copyrcodeArea" data-tooltip="Copy to Clipboard"><span class="icon2-copy"></span> Copy Code</p>
                            </div>
                            <input type="hidden" id='url_val' value="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer'); ?>"/>
                        
                        </div>
                        <div class="ticketFields fs-form-content"><!-- fs-form-content -->
                            
                            </div>
                        <div class="ticketFields fs-form-content theme1hide" style="display: none;">
                            <p>If you want to embed the tickets on your website in a single window, Copy below HTML code and paste it on your website</p><br>
                            <div class="generate">
                                <textarea readonly="readonly" cols="80" rows="4" id="text_area_samepage" class="lineheight20 textarea"><iframe id="ticketWidget" src="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer'); ?>" width="100%" height="600px" frameborder="0px" ></iframe></textarea>
                            </div>
                            <input type="hidden" id='url_val' value="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId . '&ucode=organizer&samepage=1'); ?>"/>
                        </div>
                        <p style="height:100px;">&nbsp;</p>
                    </div>
                </div>
            </div>

            <?php if (isset($eventsettings['widgetsettings']) && $eventsettings['widgetsettings'] == 1) { ?>
                <div class="grid-lg-6 grid-md-12 grid-sm-12 nopadding">
                    <div class="fs-form fs-form-widget-setting boxshadow">
                        <h2 class="fs-box-title">Widget Settings</h2>
                        <div class="ticketFields fs-form-content">

                            <div class="grid-lg-12 grid-sm-12 grid-xs-12 nopadding">
                                <div class="grid-lg-12 nopadding margintop20">

                                    <input type="hidden" id="wteventid" value="<?php echo $eventId; ?>">
                                    <label class="widthfloat" title="Tickets">Menu Name</label>
                                    <input type="text" class="textfield" id="<?php echo TICKET_TAB_TITLE; ?>" name="<?php echo TICKET_TAB_TITLE; ?>" value="<?php echo isset($widgetSettings[TICKET_TAB_TITLE]) ? $widgetSettings[TICKET_TAB_TITLE] : '' ?>">
                                    <label class="widthfloat" title="Tickets">Notes</label>
                                    <input type="text" class="textfield" id="<?php echo WIDGET_NOTES; ?>" name="<?php echo WIDGET_NOTES; ?>" value="<?php echo isset($widgetSettings[WIDGET_NOTES]) ? $widgetSettings[WIDGET_NOTES] : '' ?>">
                                    <label class="widthfloat" title="Tickets">Quantity Selection Model</label>
                                    <p class="pb-10imp"><label><input <?php if (isset($widgetSettings[TICKET_SELECTION_CHECKBOX]) && $widgetSettings[TICKET_SELECTION_CHECKBOX] == 'yes') { ?> checked="checked" <?php } ?> type="checkbox" id="<?php echo TICKET_SELECTION_CHECKBOX; ?>" name="<?php echo TICKET_SELECTION_CHECKBOX; ?>" value="yes"/> CheckBox</label></p>
                                    <label class="widthfloat" title="Tickets">Ticket Summary Display in Payment Tab</label>
                                    <p class="pb-10imp"><label><input <?php if (isset($widgetSettings[DISPLAY_SUMMARY_IN_PAYMENT]) && $widgetSettings[DISPLAY_SUMMARY_IN_PAYMENT] == 'yes') { ?> checked="checked" <?php } ?> type="checkbox" id="<?php echo DISPLAY_SUMMARY_IN_PAYMENT; ?>" name="<?php echo DISPLAY_SUMMARY_IN_PAYMENT; ?>" value="yes"/> Yes</label></p>

                                    <button type="button" class="createBtn float-right bottomAdjust" name="widget_settings_button" id="widget_settings_button">Save Settings</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="grid-row padding20">
            <div class="grid-lg-12 grid-md-12 grid-sm-12 nopadding">
                <div class="fs-form fs-form-widget-setting boxshadow">
                    <h2 class="fs-box-title">Ticket Widget Preview</h2>
                    <div class="ticketFields fs-form-content">
                        <div class="WidgetPreview">
                            <iframe id="widget_frame" width="100%" height="600px" src="<?php echo commonHelperGetPageUrl('ticketWidget', '', '?eventId=' . $eventId); ?>"> </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var saveWidgetSettings = "<?php echo commonHelperGetPageUrl('saveWidgetSettings') ?>";
        var TICKET_TAB_TITLE = "<?php echo TICKET_TAB_TITLE; ?>";
        var TICKET_SELECTION_CHECKBOX = "<?php echo TICKET_SELECTION_CHECKBOX; ?>";
        var DISPLAY_SUMMARY_IN_PAYMENT = "<?php echo DISPLAY_SUMMARY_IN_PAYMENT; ?>";
        var WIDGET_NOTES = "<?php echo WIDGET_NOTES; ?>";
    </script>
