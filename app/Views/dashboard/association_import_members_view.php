<div class="rightArea">
     <?php  
        $guestListBookingFlashMessage=$this->customsession->getData('guestListBookingSuccessMessage');
        $this->customsession->unSetData('guestListBookingSuccessMessage');
        $errorUrl = $this->customsession->getData('errorCsvFile');
    ?>
    
    <?php if($guestListBookingFlashMessage){?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $guestListBookingFlashMessage; ?></strong> 
        </div>
    <?php }?>   
                 <?php if(isset($messages)){?>
                <?php if($status == false) { ?>
                <div id="Message" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $messages;?></strong>  </div> 
             <?php } ?>
                       
        <?php }?>  
    <?php //if(isset($errorUrl) && $errorUrl!=''){?>
            
          <?php //}?>
    
    <div class="heading">
        <h2>IMPORT MEMBERS FOR THE ASSOCIATION : <?php echo  $eventName;?><span><?php if(isset($errorUrl) && $errorUrl!=''){?>
            <a href="#" style="color: #bb1818; padding-left: 25px;" class="downlond_error_csv" id="downlond_error_csv">Download Error CSV File</a>
            <input type="hidden" name="errorcsvfile" id="downloaderrorcsv" value="<?php echo $errorUrl; ?>">
        <?php $this->customsession->unSetData('errorCsvFile'); }?></span></h2>
    </div>
    <!--Data Section Start-->

    <div class="fs-form">
        <h2 class="fs-box-title">Bulk Booking</h2>
        <div class="editFields">
        <form enctype="multipart/form-data" method="post" name="guestlistbooking" id="guestlistbooking" action=''>
     <input type="hidden" name="eventId" id="eventId" class="eventId" value="<?php echo $eventId; ?>">
            <div class="clearBoth"></div>

            <div class="form-group">
                <label>Select Chapter <span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="chapter_id" id="chapter_id" required>
                        <option value="">Select Chapter</option>
                        <?php foreach ($chapters as $chapter) { ?>
                            <option value="<?php echo $chapter['id']; ?>"><?php echo $chapter['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Select Membership Type <span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="mermbershiptype_id" id="mermbershiptype_id" required>
                        <option value="">Select Membership Type</option>
                    </select>
                </div>
            </div>
            <div id="filedownloadcontent" class="filedownloadcontent" style="display:none;">
                <div class="download_link" id="download_link" ><a href="#" style="color: #0000FF;">Download sample csv file here</a></div>
                <label>CSV File <span class="mandatory">*</span></label>
                <input type="file" name="csvfile" id="csvfile" class="textfield">
                <input type="submit" name="guestBooking" id="guestBooking" class="createBtn float-right" value="Upload"/>
            </div>
        </form>
            <input type="hidden" id="downloadsamplecsv" class="downloadsamplecsv">
    </div>
    </div>
</div>
</div>

<script>
var api_bookingOfflineBooking = "<?php echo commonHelperGetPageUrl('api_bookingOfflineBooking');?>";
var api_getTicketCalculation = "<?php echo commonHelperGetPageUrl('api_getTicketCalculation');?>";
var api_promoteattendeeSampleCsv = "<?php echo commonHelperGetPageUrl('api_promoteattendeeSampleCsv');?>";
var api_promotedownloadattendeeSampleCsv = "<?php echo commonHelperGetPageUrl('api_promotedownloadattendeeSampleCsv');?>";
</script>
<script>
    $(document).ready(function () {
    $("#chapter_id").change(function () {
            $('#customFields').html('');
            if ($(this).val() > 0) {
                $.ajax({
                    url: "<?php echo commonHelperGetPageUrl('assocation-get-membership-type-options'); ?>",
                    method: "POST",
                    data: {parentassociationid: <?php echo $associationId; ?>, id: $(this).val()},
                    success: function (data) {
                        $('#mermbershiptype_id').html(data);
                    }
                });
            } else {
                $('#mermbershiptype_id').html('<option>--Select--</option>');
            }
        });
    $("#mermbershiptype_id").change(function () {
            $('#customFields').html('');
            if ($(this).val() > 0) {
                $.ajax({
                    url: "<?php echo commonHelperGetPageUrl('assocation-get-membership-type-custom-fields'); ?>",
                    method: "POST",
                    data: {id: $(this).val()},
                    success: function (data) {
                        $('#filedownloadcontent').show(); 
                    }
                });
            }
        });
    });
</script>