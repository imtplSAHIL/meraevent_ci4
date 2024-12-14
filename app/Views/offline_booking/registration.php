<div class="fs-form" style="width: 100%">
    <div id="offlineFlashSuccess" class="db-alert db-alert-success flashHide" style="display:none"></div>
    <div id="offlineFlashError" class="db-alert db-alert-danger flashHide" style="display:none"></div>
    <h2 class="fs-box-title">Offline Booking</h2>
    <div class="editFields">
        <form method="post" name="offlinebooking" id="offlinebooking" enctype="multipart/form-data">
            <input type="hidden" id="quantity" name="quantity" value="1">
            <label>Select Event <span class="mandatory">*</span></label>
            <label>
                <span style="top:10px;" class="float-left icon-downarrow"></span>
                <select name="eventId" id="event">
                    <option value="">Select Event</option>
                    <?php foreach ($eventList as $event) { ?>
                        <option value="<?php echo $event['eventId'] ?>"><?php echo $event['eventName'] . " (" . $event['eventId'] . ")"; ?></option>
                    <?php } ?>
                </select>
            </label>
            <div class="clearBoth"></div>
            <label>Ticket Type <span class="mandatory">*</span></label>
            <label>
                <span style="top:10px;" class="float-left icon-downarrow"></span>
                <select name="ticketId" id="ticket">
                    <option value="">Select Ticket</option>
                </select>
            </label>
            <div id="searchAttendeeDetails" style="display: none">
                <label>Search Previous Attendee</label>
                <input type="text" name="search_previous_attendee" id="search_previous_attendee" class="textfield" style="width: 80%">
                <input type="button" name="search_attendee_btn" id="search_attendee_btn" class="createBtn" value="Search" style="margin-top: 0px"/>
            </div>
            <div class="clearBoth">&nbsp;</div>
            <div id="customFields">
            </div>
            <div class="clearBoth">&nbsp;</div>
            <div id="paymentDetails" style="display: none">
                <label>Payment Method <span class="mandatory">*</span></label>
                <label>
                    <select id="paymentMethod" name="paymentMethod">
                        <option value="spotcard">Spot card</option>
                        <option value="spotcash">Spot cash</option>
                    </select>
                </label>
                <label>Transaction Id <span class="mandatory">*</span></label>
                <input type="text" name="paymentTransactionId" id="paymentTransactionId" class="textfield">
                <label>Amount <span class="mandatory">*</span></label>
                <input type="number" name="paymentAmount" id="paymentAmount" class="textfield">
            </div>
            <input type="submit" name="offlineBooking" id="offlineBooking" class="createBtn float-right" value="BOOK NOW"/>
        </form>
    </div>
</div>

<script>
    var api_path = '<?php echo $this->config->item('api_path'); ?>';
    var api_getCustomFields = "<?php echo commonHelperGetPageUrl('api_getCustomFields'); ?>";
    var api_bookingOfflineBooking = "<?php echo commonHelperGetPageUrl('api_bookingOfflineBooking'); ?>";
    var utilsIntlNum = "<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils' . $this->config->item('js_gz_extension'); ?>";
        $(document).ready(function () {
            $("#event").change(function () {
                $('#customFields').html('');
                if ($(this).val() > 0) {
                    $.ajax({
                        url: api_path + "ticket/getEventTickets",
                        method: "POST",
                        data: {eventId: $(this).val()},
                        success: function (data) {
                            var ticketListJSON = data;
                            var ticketList = ticketListJSON.response.ticketList;
                            if (ticketList) {
                                var ticket_ids = '<option value="">Select Ticket</option>';
                                $.each(ticketList, function (k, v) {
                                    ticket_ids += '<option value="' + v.id + '">' + v.name + '</option>';
                                });
                                $('#ticket').html(ticket_ids);
                            }
                        }
                    });
                } else {
                    $('#ticket').html('<option value="">Select Ticket</option>');
                }
            });
            $('#ticket').change(function () {
                $('#paymentDetails').show();
                getCustomFieldsData();
                $('#searchAttendeeDetails').show();
            });
            $('#search_attendee_btn').click(function () {
                searchAttendee();
            });
            $("#search_previous_attendee").keydown(function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    searchAttendee();
                }
            });
        });
        function searchAttendee() {
            if ($('#search_previous_attendee').val() != '') {
                $("#dvLoading").show();
                $.ajax({
                    url: "<?php echo site_url(); ?>offlineBooking/searchAttendee",
                    method: "POST",
                    data: {search: $('#search_previous_attendee').val()},
                    success: function (data) {
                        $("#dvLoading").hide();
                        var options = JSON.parse(data);
                        if (options.status == 1) {
                            $.each(options.attendee_data, function (i, l) {
                                var cfname = String(l.fieldname);
                                var trimmedFieldName = cfname.replace(/[^A-Za-z0-9]/g, '');
                                $("#" + trimmedFieldName + "1").val(l.value);
                            });
                        }
                    }
                });
            } else {
                alert('Please enter search keyword')
            }
        }
</script>