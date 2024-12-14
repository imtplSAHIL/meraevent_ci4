<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?>
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong>
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Add Custom Field</h2>
    </div>
    <!--Data Section Start-->
    <?php
    if (isset($errors)) {
        echo $errors[0];
    } else {
        ?>
        <div class="editFields fs-profile-form">
            <form name="customfields" id="customfields" method="post" action="">
                <input type="hidden" name="eventid" value="<?php echo $associationdata[0]['eventid']; ?>"/>
                <div class="form-group">
                    <label>Field Name<span class="mandatory"> *</span></label>
                    <input type="text" class="textfield" name="fieldName" id="fieldName" value="">
                    <span></span>
                </div>
                <br/>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="textfield" name="descField" id="fieldName" value="">
                    <span></span>
                </div>
                <div class="form-group">
                    <label>Field Level <span class="mandatory">*</span></label>
                    <ul>
                        <li style="width: 30%; float: left">
                            <label><input type="radio" name="fieldlevel" class="customFieldLevel" id="customFieldLevelEvent" value="event" required>All</label>
                        </li>
                        <li>
                            <label><input type="radio" name="fieldlevel" class="customFieldLevel" id="customFieldLevelTicket" value="ticket" required>Membership Type</label>
                        </li>
                    </ul>
                </div>
                <div class="form-group fieldLevelTickets" style="display: none">
                    <label>Membership Types <span class="mandatory"> *</span></label>
                    <div style="position:relative">
                        <ul>
                            <?php foreach ($membership_types as $membership_type) { ?>
                                <li style="width: 33.33%; float: left">
                                    <label><input type="checkbox" name="membershipIds[]" required value="<?php echo $membership_type['ticketid']; ?>"><?php echo $membership_type['name']; ?></label>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div style="clear: both"></div>
                <div class="form-group">
                    <label>Field Type<span class="mandatory"> *</span></label>
                    <div style="position:relative">
                        <span class="icon-downarrow downarrowSettings"></span>
                        <select name="fieldType" required="" id="fieldType">
                            <option value=""> Select an Option </option>
                            <option value="textbox">Textbox</option>
                            <option value="textarea">Textarea</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="radio">Radio Options</option>
                            <option value="checkbox">Check Boxes</option>
                        </select>
                    </div>
                </div> <br>
                <div id="options_div" class="options_div">
                    <ul>
                        <li>
                            <input id="addMoreTicketsInput" type="text" class="textfield addfield" name="customFieldValues[]">
                            <span style="cursor: pointer;" class="removeOption">Remove</span>
                        </li>
                    </ul>
                    <span class="field">
                        <a href="javascript:void(0);" id="addOptionClass" > + Add more options</a>
                    </span>
                </div>
                <br>
                <div class="fs-mandatory-field">
                    <input type="checkbox" id="fs-mandatory-field" name="fieldMandatory" value="1" >
                    <label for="fs-mandatory-field">Make this field Mandatory</label>
                </div>
                <div class="clearBoth"></div>
                <div class="fs-custom-field-buttons float-right">
                    <input type="submit" name="submit" class="createBtn" value="Add"/>
                </div>
            </form>
        </div>
    <?php } ?>
</div>