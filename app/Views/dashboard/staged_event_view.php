
    <div class="rightArea">
        <?php if (isset($ticketSettings) && $ticketSettings['status'] == TRUE ) { ?>
        <div id="ticketOptionsMessage" class="db-alert db-alert-success flashHide">
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>   
        <?php if (isset($ticketSettings) && $ticketSettings['status'] == FALSE ) { ?>
        <div id="ticketOptionsMessage" class="db-alert db-alert-danger flashHide">
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?> 
          <br>
      <div class="heading float-left">
        <h2>Event Title: <span><?php echo $eventTitle;?></span></h2>
        
          
      </div>
      <div class="clearBoth"></div>
      <?php if($soldTicketCount > 0){ 
                    ?>
                <div class="editFields">
                    <p class="error">This event has transactions so you cannot change the event type.</p>
                </div>
                <?php 
                } else { ?>
      <!--Data Section Start-->
      <div class="information">
        <form id="ticketOptions" method="post" action="" name="ticketOptions">
                  <div class="fs-form fs-form-widget-setting">
				<h2 class="fs-box-title">Event Types</h2>
				<div class="fs-form-content">
					
			        
                                
                                <p>
                                    		<label>
							<input type="radio" name="paymentstage" value="0"  <?php if($ticketOptions[0]['paymentstage'] == 0) { ?> checked="checked" <?php } ?>>
							<span class="fs-label-content">Regular Event</span> 
						</label>
						<span class="mleft">
							Capture the user details with payment. Users will receive the confirmation ticket in mail.
	          			</span> 
	          		</p>
                                
                                
                                
                                <div class="clearBoth" ><br /></div>
                                
                                
                                <p>
                                    		<label>
							<input type="radio" name="paymentstage" value="2"  <?php if($ticketOptions[0]['paymentstage'] == 2) { ?> checked="checked" <?php } ?>>
							<span class="fs-label-content">Post payment</span> 
						</label>
						<span class="mleft">
							Capture the user details without payment. After curation users will receive the payment link to complete the payment.
	          			</span> 
	          		</p>
                                <div class="clearBoth" ></div>
			  		<p>
				  		<label>
				  			<input type="radio" name="paymentstage" value="1"  <?php if($ticketOptions[0]['paymentstage'] == 1) { ?> checked="checked" <?php } ?>>
				  			<span class="fs-label-content">Pre payment</span> 
				  		</label>
				  		<span class="mleft">
				  			Capture the user details with payment. After curation users will receive the confirmation ticket in mail.
	          			</span> 
	          		</p>
				</div>
	        </div>		
            
            
                        <input type="hidden" id="eventID" value="<?php echo $ticketOptions['eventID'] ?>" >
			<input type="submit" class="submitBtn createBtn float-right submitBtnTicketOptions" name="submit" value="save"/>
        </form>
      </div>
    <?php } ?>
    </div>

<script>
    var invoiceDetailsValidation = '<?php echo commonHelperGetPageUrl('invoiceDetailsValidation');?>';
     $(document).ready(function (){
         customCheckbox("sendinvoice"); 
         customCheckbox('nonormalwhenbulk');
         customCheckbox("ticketdatehide");
     });
</script>
<script>
var api_cityCitysByState = "<?php echo commonHelperGetPageUrl('api_cityCitysByState');?>";
var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch')?>";
var api_stateSearch = "<?php echo commonHelperGetPageUrl('api_stateSearch')?>";
var api_citySearch = "<?php echo commonHelperGetPageUrl('api_citySearch')?>";
</script>



