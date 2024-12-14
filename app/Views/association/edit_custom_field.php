<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?>
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong>
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Edit Custom Field</h2>
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
                    <input type="text" class="textfield" name="fieldName" id="fieldName" value="<?php echo $fieldsdata['customfieldsdata'][0]['fieldname']; ?>">
                    <span></span>
                </div>
                <br/>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="textfield" name="descField" id="fieldName" value="<?php $fieldsdata['customfieldsdata'][0]['fieldDescription'] ?>">
                    <span></span>
                </div>
                <div class="form-group">
                    <label>Field Level <span class="mandatory">*</span></label>
                    <ul>
                        <li style="width: 30%; float: left">
                            <label><input type="radio" name="fieldlevel" class="customFieldLevel" id="customFieldLevelEvent" value="event" required <?php echo $fieldsdata['customfieldsdata'][0]['fieldlevel'] == 'event' ? 'checked' : ''; ?>>All</label>
                        </li>
                        <li>
                            <label><input type="radio" name="fieldlevel" class="customFieldLevel" id="customFieldLevelTicket" value="ticket" required <?php echo $fieldsdata['customfieldsdata'][0]['fieldlevel'] == 'ticket' ? 'checked' : ''; ?>>Membership Type</label>
                        </li>
                    </ul>
                </div>
                <div class="form-group fieldLevelTickets" <?php echo $fieldsdata['customfieldsdata'][0]['fieldlevel'] == 'ticket' ? '' : 'style="display: none"'; ?>>
                    <label>Membership Types <span class="mandatory"> *</span></label>
                    <div style="position:relative">
                        <ul>
                            <?php foreach ($membership_types as $membership_type) { ?>
                                <li style="width: 33.33%; float: left">
                                    <label><input type="checkbox" name="membershipIds[]" required value="<?php echo $membership_type['ticketid']; ?>" <?php echo in_array($membership_type['ticketid'], explode(",", $fieldsdata['customfieldsdata'][0]["other_ticketids"])) ? 'checked' : ''; ?>><?php echo $membership_type['name']; ?></label>
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
                            <option value="textbox" <?php echo $fieldsdata['customfieldsdata'][0]["fieldtype"] == 'textbox' ? 'selected="selected"' : ''; ?>>Textbox</option>
                            <option value="textarea" <?php echo $fieldsdata['customfieldsdata'][0]["fieldtype"] == 'textarea' ? 'selected="selected"' : ''; ?>>Textarea</option>
                            <option value="dropdown" <?php echo $fieldsdata['customfieldsdata'][0]["fieldtype"] == 'dropdown' ? 'selected="selected"' : ''; ?>>Dropdown</option>
                            <option value="radio" <?php echo $fieldsdata['customfieldsdata'][0]["fieldtype"] == 'radio' ? 'selected="selected"' : ''; ?>>Radio Options</option>
                            <option value="checkbox" <?php echo $fieldsdata['customfieldsdata'][0]["fieldtype"] == 'checkbox' ? 'selected="selected"' : ''; ?>>Check Boxes</option>
                        </select>
                    </div>
                </div> <br>
                <div id="options_div" class="options_div">
                    <ul>
                        <?php
                        if (count($fieldsdata['customfieldsdata'][0]["fieldtype"]) > 0 && ($fieldsdata['customfieldsdata'][0]["fieldtype"] == 'dropdown' || $fieldsdata['customfieldsdata'][0]["fieldtype"] == 'radio' || $fieldsdata['customfieldsdata'][0]["fieldtype"] == 'checkbox')) {
                            foreach ($fieldsdata['subfields'] as $data) {
                                ?>
                                <li>
                                    <input id="addMoreTicketsInput" type="text" class="textfield addfield" name="customFieldValues[]" value="<?php echo $data['value']; ?>">
                                    <span style="cursor: pointer;" class="removeOption">Remove</span>
                                </li>
                                <?php
                            }
                        } else {
                            ?>
                            <li>
                                <input id="addMoreTicketsInput" type="text" class="textfield addfield" name="customFieldValues[]">
                                <span style="cursor: pointer;" class="removeOption">Remove</span>
                            </li>
                        <?php } ?>
                    </ul>
                    <span class="field">
                        <a href="javascript:void(0);" id="addOptionClass" > + Add more options</a>
                    </span>
                </div>
                <br>
                <div class="fs-mandatory-field">
                    <input type="checkbox" id="fs-mandatory-field" name="fieldMandatory" value="1" <?php echo $fieldsdata['customfieldsdata'][0]['fieldmandatory'] == '1' ? 'checked' : ''; ?>>
                    <label for="fs-mandatory-field">Make this field Mandatory</label>
                </div>
                <div class="clearBoth"></div>
                <div class="fs-custom-field-buttons float-right">
                    <input type="submit" name="submit" class="createBtn" value="Update"/>
                </div>
            </form>
        </div>
    <?php } ?>
</div>