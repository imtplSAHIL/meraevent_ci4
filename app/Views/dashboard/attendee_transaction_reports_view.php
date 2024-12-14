<!--Right Content Area Start-->
<div class="rightArea">
    <form action='' method="POST" />
    <div class="heading">
        <h2>Confirmed Attendee Details</h2>
    </div>
    <!--Data Section Start-->
    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
    <div class="clearBoth"></div>

    <div class="fs-export-email fs-export-reports-special">
        <button type="button" class="Btn blueborder" name="exportAttendeeReports" id="exportAttendeeReports"><span class="icon-export"></span>Export</button>
    </div>


    <!--Curation Events Buttons-->
    <div class="refundSec bottomAdjust100" >   
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="transactionTable" class="transactionTable">
            <thead>
            <tr>
                <?php foreach ($header_array as $value) {
                    ?>
                    <th scope="col" data-tablesaw-priority="2"><?php echo $value; ?></th>
                <?php } ?>
            </tr>
            </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
        foreach($attendeeList as $event_signup_id => $attendee_details){
         foreach($attendee_details as $attendee_id => $transactions){
             ?>
        <tr>
            <?php
                        foreach($header_array as $current_key)
                        {
                                if($current_key == 'Actions')
                                {
                                    continue;
                                }

                                if($current_key == 'SNo')
                                {
                                    ?>
                                    <td><?php echo $i++; ?></td>
                                    <?php
                                }
                                else{
                            ?>
                                <td><?php echo $transactions[$current_key]; ?></td>
                            <?php
                                }
                        }
                        ?>
                        
                        <td>
                        <a href='<?php echo commonHelperGetPageUrl('dashboard-ticketTransfer',$eventId.'&'.$transactions['EventSignupId']); ?>' >
                            Edit Attendee Details
                        </a> <br /><br />
                        <!-- <a title = "Resend Email" class="resendEmail" value="<?php echo $transactions['EventSignupId']; ?>" href="javascript:void()"><span id="resendEmailSuccessMessage<?php echo $transactions['EventSignupId']; ?>" ></span>Resend Ticket to All Attendees</a> <br /> -->
                        <!-- <a href='<?php echo commonHelperGetPageUrl('dashboard-download-attendee-dashboard', $transactions['EventSignupId']);?>' > Download Details</a> <br /> -->
                        </td>
        </tr>
                 <?php
         }
        }
         ?>
        </form>

<script language="javascript">
    var staged = 0;
    var api_eventResendEmail = "<?php echo commonHelperGetPageUrl('api_resendDelegateEmail') ?>";
    function func_confirm_payment_capture(redirect_url)
    {
        var retVal = confirm("Do you want to confirm the payment ?");
        if( retVal == true )
        {
            window.location.href = redirect_url;
            return true;
        }
        else
        {
            return false;
        }
    }
    $( "#exportAttendeeReports" ).click(function() {
        window.location.href = window.location.href + "?report=1";
        return true;
    });
    
</script>