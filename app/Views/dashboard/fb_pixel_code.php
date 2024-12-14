<div class="rightArea">
     <?php if (isset($updateTnc) && $updateTnc['status'] === TRUE) { ?>
        <div id="paymentModeMessage" class="db-alert db-alert-success flashHide">
            <strong>&nbsp;&nbsp;  <?php echo $updateTnc['response']['messages'][0]; ?></strong> 
        </div>
    <?php } ?>
    <?php if (isset($updateTnc) && $updateTnc['status'] === FALSE) { ?>
        <div id="paymentModeMessage" class="db-alert db-alert-danger flashHide">
            <strong>&nbsp;&nbsp;  <?php echo $updateTnc['response']['messages'][0]; ?></strong> 
        </div>
    <?php } ?>
  
    <div class="heading">
        <h2>Facebook Pixel Code: <span><?php echo $eventName; ?></span></h2>
    </div>
    <!--Data Section Start-->
	<div class="fs-form">
		<h2 class="fs-box-title">Enter Facebook Pixel Code</h2>
	    <div class="editFields">
	        <form name='tncForm' method='post' action='' id='tncForm'>
	           <textarea style="width:90%" class='required' tabindex="2" rows="18" name="facebookpixelcode" id="" ><?php  if(!empty($getfbPixel[0]['fbpixelcode'])){echo $getfbPixel[0]['fbpixelcode'];  }  ?></textarea>     
	                
                <input type="submit" name='submit' class="createBtn float-right" id="tncSubmit" value='Save'>
	        </form>
	
	    </div>
	</div>   
</div>