<div class="rightArea">
    <?php
    //print_r($attendees);exit;
    $attendeeSuccessMessage = $this->customsession->getData('attendeeSuccessMessage');
    $this->customsession->unSetData('attendeeSuccessMessage');
    ?>

    <?php if ($attendeeSuccessMessage) { ?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $attendeeSuccessMessage; ?></strong> 
        </div>
    <?php } ?>   
    <?php if (isset($messages)) { ?>
        <?php if ($status == false) { ?>
            <div id="Message" class="db-alert db-alert-danger flashHide">
                <strong>  <?php echo $messages; ?></strong> <?php } ?>
        </div>                 
    <?php } ?>  
    <div class="heading">
        <h2>Upload Attendees : <?php echo $eventName; ?></h2>
        <p style="font-size:14px; line-height: normal; margin-bottom:10px;">
            We are accepting only CSV files to use this page.</p>
    </div>
    <!--Data Section Start-->

    <div class="fs-form">
        <h2 class="fs-box-title">Upload Attendee Details</h2>
        <div class="editFields">
        	<input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId;?>"/>
            <form enctype="multipart/form-data" method="post" name="uploadOrgContacts" id="uploadOrgContacts" action=''>

                <div class="clearBoth"></div>

                <label>CSV File <span class="mandatory">*</span></label>
                <input type="file" name="csvfile" id="csvfile" class="textfield">
                <input type="submit" name="past_att_upload" id="past_att_upload" class="createBtn float-right" value="Upload"/>
            </form>
            <div class="clearBoth"></div>
            <div class="clearBoth"></div>
            <br>
            <form style="display:none;"  method="post" name="uploadAtt" id="uploadAtt" action=''>
                <input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value="<?= $fileName; ?>">
                <label>Category</label>
                <input type="text" name="category" id="category" class="textfield" value="">   
                <div class="clearBoth"></div>
                <input type="submit" name="columns_map" id="columns_map" class="createBtn float-right" value="Upload"/>
            </form>
        </div>
    </div>

</div>
</div>

<script>
    var api_getCSVData = "<?php echo commonHelperGetPageUrl('api_getCSVData'); ?>";
    var api_insertOrgPastAttendees = "<?php echo commonHelperGetPageUrl('api_insertOrgPastAttendees'); ?>";

    function getColumnVal(val, id)
    {
        $("#" + id).val(val);
    }
</script>