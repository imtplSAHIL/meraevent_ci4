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
        <h2>Terms & Conditions: <span><?php echo $eventName; ?></span></h2>
    </div>
    <!--Data Section Start-->
	<div class="fs-form">
		<h2 class="fs-box-title">Enter your Terms and Conditions</h2>
	    <div class="editFields">
	        <form name='tncForm' method='post' action='' id='tncForm'>
	           <textarea style="width:60%" class='required' tabindex="2" rows="10" name="tncDescription" id="tncDescription" ><?php echo $organizertnc; ?></textarea>     
	                
	            <div><span id="tncDiscriptionError" class="error"></span></div>
                
                
               <div> <p>
			        	<label>
			        		<input type="checkbox" name="displaytnconpass" <?php if($displaytnconpass == 1) { ?> checked="checked" <?php }?> >
							<span class="fs-label-content">Display Terms and Conditions on pass</span> 
						</label>
						<span class="mleft">If un checked, Terms and conditions wont print on delegate confirmation pass, if this event has custom T&C. </span> 
			    </p></div>
                
                <input type="submit" name='tncSubmit' class="createBtn float-right" id="tncSubmit" value='Save'>
	        </form>
	
	    </div>
	</div>   
</div>