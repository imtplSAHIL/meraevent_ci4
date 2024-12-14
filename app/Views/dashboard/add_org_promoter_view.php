<div class="rightArea">
   
    <?php if (isset($output)) { ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $output ?></strong> 
        </div>                 
    <?php }
         if (isset($errors)) { ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $errors[0]; ?></strong> 
        </div>                 
    <?php } ?>  
    
       <?php if ($promoterId == 0) { ?>
    <div class="heading">
        <h2>Add Promoter:</h2>
    </div>
    <?php } ?>
    <div class="editFields fs-add-promoter-form" <?php if($promoterId>0){ echo 'style="display:none;"';}?>>
        <form name='addPromoterForm' method='post' action='' id='addPromoterForm'>
            <label>Promoter Name <span class="mandatory">*</span></label>
            <input type="text" class="textfield" name='promoterName' id='promoterName'>
            <label>Email ID <span class="mandatory">*</span></label>
            <input type="text" class="textfield" name='promoterEmail' id=''>
            <label>Promoter Code <span class="mandatory">*</span></label>
            <input type="text" class="textfield" name='promoterCode' id='promoterCode'>
            <label>Commission (% Percentage)<span class="mandatory">*</span></label>
            <input required type="number" min="1" max="80" class="textfield" name='commission' value="<?php echo isset($affiliateCustomCommition['affiliateglobalcommission'])?$affiliateCustomCommition['affiliateglobalcommission']:'';?>">
            <label>Your Site URL </label>
            <input type="text" class="textfield" name='orgPromoteURL' id='orgPromoteURL'>
            <div id='codeError' class='error'></div>
            <div class="clearBoth"></div>
            <div class="btn-holder float-right">
                <input name="submit" type="submit" id="promoButton" class="createBtn" value="Save">
                <a href="<?php echo commonHelperGetPageUrl("dashboard-organizer-affliates"); ?>">
                    <span class="saveBtn">Cancel</span> 
                </a>
            </div>
        </form>
    </div>         
   
            <?php if ($promoterId > 0) { ?>
             <div class="editFields fs-add-promoter-form">
                <form>
                <label>Promoter name <span class="mandatory">*</span></label>
                <input type="text" class="textfield" name='promoterName' id='promoterName' value="<?php echo $name;?>" readonly>
                <div class="clearBoth"></div>
                
                <label>Promoter Email Id <span class="mandatory">*</span></label>
                <input type="text" class="textfield" name='promoterEmail' id='promoterEmail' value="<?php echo $email;?>" readonly>
                <div class="clearBoth"></div>
                
                <div class="clearBoth"></div>
            
            </form>
            <?php } 
			?>
            
            
         <?php if ($promoterId > 0) { ?>
        <div class="btn-holder float-right">
            <a href="<?php echo commonHelperGetPageUrl("dashboard-organizer-affliate"); ?>" class="createBtn" style="float:left;">Go Back</a>
        </div>   
        <?php } ?>
    </div>
 

</div>
<script>
    var getPromoterurl='<?php echo commonHelperGetPageUrl('api-get-affliate-promoter'); ?>';
</script>
    