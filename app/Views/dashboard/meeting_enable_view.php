<div class="rightArea">
     <?php if (isset($updateZoomStatus) && $updateZoomStatus['status'] == TRUE) { ?>
        <div id="paymentModeMessage" class="db-alert db-alert-success flashHide">
            <strong>&nbsp;&nbsp;  <?php  echo $updateZoomStatus['response']['messages'][0]; ?></strong> 
        </div>
    <?php } ?>
  
    <div class="heading">
        <h2>Setup your Online Event: <span><?php echo $eventName; ?></span></h2>
    </div>
    <!--Data Section Start-->
	<div class="fs-form">
                <div class="editFields">
                    <p>Create a meeting on any Video conferencing tool either Zoom or Google Meet or your preferred app and paste the invite url here.  
</p>
	        <form name='zoomEnable' method='post' action='' id='tncForm'>
<!--                    <label><input type="checkbox" name="enablezoom" class="enablezoom" value='<?php echo $getZoomDetails[0]['zoomevent']; ?>' <?php if($getZoomDetails[0]['zoomevent'] == 1){ echo 'checked'; } ?> />
            Enable Online Meeting For this Event</label>-->
<br/>
                    <div class="urlDiv">
            <label>URL </label>
            <input type="url" name="meetingUrl" class="textfield meetingUrl"  value="<?php echo $getZoomDetails[0]['externalmeetingurl']; ?> "/>
                    
            </div>
            <input type="submit" name='submit' class="createBtn float-right" id="zoomEnable" value='Save'>
	        </form>
	
	    </div>
	</div>   
</div>
