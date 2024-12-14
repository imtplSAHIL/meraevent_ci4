<div class="rightArea">
     <?php if(isset($output) && !empty($output)){ if($output['status']){ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $output['response']['messages'][0] ?></strong> 
        </div>                 
    <?php }else{ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $output['response']['messages'][0]; ?></strong> 
        </div>                 
     <?php } }?>
    
    <div class="clearBoth"></div>
    
    <div class="clearBoth"></div>
    <div class="heading float-left">
        <h2><?php if(isset($resourceId) && $resourceId>0){ echo "Edit"; }else{ echo "Add"; }?> Marketing Resource: <span> <?php echo $eventName; ?> </span></h2>
    </div>
    <div class="clearBoth"></div>
    <div class="editFields fs-add-promoter-form">
        <form name='addMarketingResourceForm' id="addMarketingResourceForm" method='post' action=''>
            <label>Resource Type <span class="mandatory">*</span></label>
            <select required="" name="resourcetype" id="marketingResourcetype">
                <option value="">Select</option>
                <option value="facebook" <?php if(isset($affiliateResouces['resourcetype']) && $affiliateResouces['resourcetype']=="facebook"){ ?> selected="selected" <?php } ?>>Facebook</option>
                <option value="twitter" <?php if(isset($affiliateResouces['resourcetype']) && $affiliateResouces['resourcetype']=="twitter"){ ?> selected="selected" <?php } ?>>Twitter</option>
                <option value="linkedin" <?php if(isset($affiliateResouces['resourcetype']) && $affiliateResouces['resourcetype']=="linkedin"){ ?> selected="selected" <?php } ?>>Linkedin</option>
                <option value="banner" <?php if(isset($affiliateResouces['resourcetype']) && $affiliateResouces['resourcetype']=="banner"){ ?> selected="selected" <?php } ?>>Banner</option>
                <option value="email" <?php if(isset($affiliateResouces['resourcetype']) && $affiliateResouces['resourcetype']=="email"){ ?> selected="selected" <?php } ?>>Emailer</option>
                <option value="others" <?php if(isset($affiliateResouces['resourcetype']) && $affiliateResouces['resourcetype']=="others"){ ?> selected="selected" <?php } ?>>Others</option>
                
            </select>
            <label>Title <span class="mandatory">*</span></label>
            <input required="" type="text" class="textfield" name='title' value="<?php echo isset($affiliateResouces['title'])?$affiliateResouces['title']:'';?>">
            <label id="resourcecontenttitle">Content <span class="mandatory">*</span></label>
            <textarea rows="10" class="textarea" required="" type="text" name='content' id='content' ><?php echo isset($affiliateResouces['content'])?$affiliateResouces['content']:'';?></textarea>
            <span id="twitternote" <?php if($affiliateResouces['resourcetype']=="twitter"){ }else{ ?> style="display: none;" <?php } ?> >Note: Maximum limit up to <b>110</b> characters</span>
            <div id='codeError' class='error'></div>
            <div class="clearBoth"></div>
            <div class="btn-holder float-right">
                <input name="submit" type="submit" id="marketingButton" class="createBtn" value="Save">
                <a href="<?php echo commonHelperGetPageUrl("dashboard-marketing-resources", $eventId); ?>">
                    <span class="saveBtn">Cancel</span> 
                </a>
            </div>
        </form>
    </div>
     

 <br>

</div>

