<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>class="db-alert db-alert-success flashHide" <?php } else { ?>class="db-alert db-alert-danger flashHide"<?php } ?>>
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong>
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Add Sub User</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form name="OrganizerDetailsForm" id="personalDetails" method="post">
            <label>User Email<span class="mandatory">*</span></label>
            <input type="text" name="email" value="" class="textfield" required>
            <div class="clearBoth"></div>
            <input type="submit"  name="submit" class="submitBtn createBtn float-right" value="Add Sub User"/>
        </form>
    </div>
</div>


