<div class="rightArea">
    <?php
    $promoterSuccessMessage = $this->customsession->getData('promoterSuccessAdded');
    $this->customsession->unSetData('promoterSuccessAdded');
    if ($promoterSuccessMessage) {
        ?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $promoterSuccessMessage; ?></strong>
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Terms & Conditions</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form name="personalDetails" id="personalDetails" method="post" action="">
            <div id="userSuccessMessage"> </div> <div id="userErrorMessage"> </div>
            <div class="form-group">
                <label>Terms and conditions<span class="mandatory">*</span></label>
                <textarea style="width:60%" class='required' tabindex="2" rows="10" name="tncDescription" id="tncDescription" ><?php echo $termsandconditions; ?></textarea>
                <span></span>
            </div>
            <input type="hidden"  name="associationid" value="<?php echo $associationId; ?>"/>
            <div style="clear: both"></div>
            <div class="clearBoth"></div>
            <input type="submit"  name="submit" class="createBtn float-right" value="Save"/>
        </form>
    </div>
</div>