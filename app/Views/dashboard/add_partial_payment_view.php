 <div class="rightArea">
             <?php if(isset($messages)){?>
                <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $messages;?></strong> 
        </div>                 
        <?php }?>  
      <div class="heading">
        <h2>Add Partial Payment User: <span><?php echo $eventName; ?></span></h2>
      </div>
      <?php
      if(isset($offlinePromoter)){
      $partialUser= array_values($offlinePromoter);
      }?>
      <div class="editFields fs-add-offline-promoter-form">
        <form method="post" name="offlinePromoter" id="offlinePromoter" action=''>
          <label>User Name <span class="mandatory">*</span></label>
          <input type="text" value="<?php echo $partialUser['0']['name'];?>" name="promoterName"  class="textfield">
          <label>Email ID <span class="mandatory">*</span></label>
          <input type="text" value="<?php echo $partialUser['0']['email'];?>" name="promoterEmail"  class="textfield" <?php if($partialUser['0']['email']){ ?> readonly <?php }?> />
          <label>Mobile Number <span class="mandatory">*</span></label>
          <input type="text" name="promoterMobile" id="mobileNo" value="<?php echo $partialUser['0']['mobile'];?>"  class="textfield">
          <span style="margin-bottom:20px;"></span> <?php // echo MESSAGE_COUNTRYCODE_NOTE;?>
          <div class="clearBoth"></div>
          <label>Tickets <span class="mandatory">*</span></label>
          <div class="child">
            <?php if($tickets){
                $discountDivStatus="display:none;";
                    ?>  
                <select name="ticketIds" id="ticketids">
                    <option value="">Select Ticket</option>
                        <?php foreach ($tickets as $ticket){?>
                    <option value="<?php echo $ticket['id']; ?>" <?php if($partialUser[0]['ticketids'] == $ticket['id']){ echo 'selected'; } ?>><?php echo $ticket['name']; ?></option>
                        <?php } ?>
                </select>
              <div id="dicountBox" style="<?php echo $discountDivStatus; ?>">
                  <div style="margin-left:20px;">Ticket Price &nbsp; 
                      <input type="text" class="textfield" autocomplete="off" id="price" style="width: 100px;margin-bottom:10px;" name="price" onkeypress="return isNumber(event)" value="<?php echo $ticketprice; ?>" required <?php if($transactionscount > 0){?>readonly<?php  } ?>></div>
               <div><br /></div>
                </div>
                <?php  } else{ ?>
                <div id="paymentModeMessage" class="db-alert db-alert-info">
            <strong><?php echo 'No tickets found for this event';?></strong> 
        </div>
        <?php } ?>
          </div>
         <div id='radioErrorDiv'><span class='error' id='ticketradioError' style='font-size:14px; padding-top: 12px;'></span> </div>
         <div class="clearBoth"></div>
         <div class="btn-holder float-right">
			 <input type="submit" value="Submit" name="formSubmit" class="createBtn"/>
			 <a href="<?php echo commonHelperGetPageUrl('dashboard-partialPayments', $eventId); ?>" class="saveBtn">Cancel</a>
		 </div>
       </form>
      </div> 
    </div>

<script type="text/javascript">
 $.fn.intlTelInput.loadUtils("<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>");      
 $(window).ready(function(){
  $("#mobileNo").intlTelInput({
      autoPlaceholder: "off",
      initialCountry: intlCountrycode,
      separateDialCode: true
    });  
 });
</script>    

