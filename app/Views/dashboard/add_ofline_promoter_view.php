 <div class="rightArea">
             <?php if(isset($messages)){?>
                <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $messages;?></strong> 
        </div>                 
        <?php }?>  
      <div class="heading">
        <h2>Add Offline Promoter: <span><?php echo $eventName; ?></span></h2>
      </div>
      <?php
      if(isset($offlinePromoter)){
      $offlineValue= array_values($offlinePromoter);
      }?>
      <div class="editFields fs-add-offline-promoter-form">
        <form method="post" name="offlinePromoter" id="offlinePromoter" action=''>
          <label>Offline Promoter Name <span class="mandatory">*</span></label>
          <input type="text" value="<?php echo $offlineValue['0']['name'];?>" name="promoterName"  class="textfield">
          <label>Email ID <span class="mandatory">*</span></label>
          <input type="text" value="<?php echo $offlineValue['0']['email'];?>" name="promoterEmail"  class="textfield" <?php if($offlineValue['0']['email']){ ?> readonly <?php }?> />
          <label>Mobile Number <span class="mandatory">*</span></label>
          <input type="text" name="promoterMobile" id="mobileNo" value="<?php echo $offlineValue['0']['mobile'];?>"  class="textfield">
          <span style="margin-bottom:20px;"></span> <?php // echo MESSAGE_COUNTRYCODE_NOTE;?>
          <div class="clearBoth"></div>
          <label>Tickets <span class="mandatory">*</span></label>
          <div class="child">
                
              <?php  
			  
			  //print_r($selectedTicketIdList); 
			  if($tickets){ ?>
                  <?php foreach($tickets as $ticket){  
                      $discountDivStatus="display:none;";
                      ?>  <div class="BulkDiscClass"><label>
         				<input type="checkbox"  id="<?php echo $ticket['id']; ?>" name="ticketIds[]"  value="<?php echo $ticket['id']; ?>"
                <?php if (isset($selectedTicketIdList)) {
                                if (array_key_exists($ticket['id'], $selectedTicketIdList)) {
                                    $discountDivStatus=($editStatus == TRUE)?"":"display:none;";
                                    ?>checked='checked'<?php }
            } ?> class="showOrHideDiscCodes"
                >
               <?php echo $ticket['name'];?> </label>
                <div id="dicountBox<?php echo $ticket['id']; ?>" style="<?php echo $discountDivStatus; ?>">
                <?php $discountType="";
                $selectedTicketDiscountList=array();
                if(isset($selectedDiscountList[$ticket['id']])){
                    $selectedTicketDiscountList=$selectedDiscountList[$ticket['id']];
                }
				
				?>
               <div style="margin-left:20px;">Max Ticket Quantity &nbsp; <input type="text" class="textfield" style="width: 100px;margin-bottom:10px;" name="maxlimit[<?php echo $ticket['id']; ?>]" value="<?php echo $selectedTicketIdList[$ticket['id']]['maxlimit']; ?>"><span class="suggestiontext-g">(Leave blank, if you want to give unlimited)</span></div>
               
               <div><br /></div>
               <span class="suggestiontext-g" style="margin-bottom: 10px;margin-left: 20px; font-weight:bold;">Applicable discounts</span>
			   
               
                <?php
                
                foreach($discountsInfo as  $discount){ 
                    
                    $ticketDiscountArray=(isset($ticketDiscountMappingArray[$ticket['id']]))?$ticketDiscountMappingArray[$ticket['id']]:"";
                   
                    if(count($ticketDiscountArray) > 0 && in_array($discount['id'],$ticketDiscountArray)){
                     $discountType=($discount['calculationmode']=='percentage')? $discount['value']." %":'Flat'.$discount['value'];
                    ?>
                  <div style="float: left;" id="tktDiscBox<?php echo $ticket['id']; ?>" >
                  	 
                  
                            <span style="float: left; padding: 5px;width:100%;">
                                <label style="padding: 0 10px 0 10px;">
                                    <input type="checkbox" style="margin:5px 10px 0 30px; float:left;" name="ticketDiscount<?php echo $ticket['id']; ?>[]" value="<?php echo $discount['id']; ?>"
                                           <?php
                                           if (in_array($discount['id'], $selectedTicketDiscountList)) {?>
                                           checked='checked'<?php } ?>
                                           > <?php echo $discount['name']; ?> (<?php echo $discountType; ?>)
                                </label>
                            </span>

                  

                 </div>  
                    
               <?php 
                        }//end of if condition
                    }//end of discount for
                
                ?>
                </div><!-- end of discount box--> 

                       
                
                
           </div>     <?php } } else{ ?>
                <div id="paymentModeMessage" class="db-alert db-alert-info">
            <strong><?php echo 'No tickets found for this event';?></strong> 
        </div>
        <?php   }?>
        
           
          </div>
         <div id='checkboxErrorDiv'><span class='error' id='ticketCheckboxError' style='font-size:14px; padding-top: 12px;'></span> </div>
         <div class="clearBoth"></div>
          
         <div class="btn-holder float-right">
			 <input type="submit" value="Submit" name="formSubmit" class="createBtn"/>
			 <a href="<?php echo commonHelperGetPageUrl('dashboard-offlinepromoter', $eventId); ?>" class="saveBtn">Cancel</a>
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