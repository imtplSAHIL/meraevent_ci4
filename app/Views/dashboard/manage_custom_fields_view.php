<div class="rightArea">
    <div class="heading">
        <h2>Add Custom Fields for Event : <span><?php echo $eventTitle; ?></span></h2>
        <div id="seoMessage" style="color:red">
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
        </div>
    </div>
    <!--Data Section Start-->
    <?php
        if (isset($errors)) {
            echo $errors[0];
        } else {
    ?>
        <div class="fs-form">
            <h2 class="fs-box-title">Custom Fields</h2>
            <div class="editFields">
                <form name="customfields" id="customfields" method="post" action="">
                    <input type="hidden" name="eventId" value ="<?php echo $eventId; ?>" id="eventId"/>
                    <div class="form-group">
                        <label>Field Name<span class="mandatory"> *</span></label>
                        <input type="text" class="textfield" name="fieldName" id="fieldName" value ="<?php echo (count($customFieldData) > 0) ? $customFieldData["fieldname"] : ""; ?>"<?php if($customFieldData['commonfieldid']>0){?> readonly="readonly"<?php } ?>>
                        <span></span>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="textfield" name="descField" id="fieldName" value ="<?php echo (count($customFieldData) > 0) ? $customFieldData["fieldDescription"] : ""; ?>">
                        <span></span>
                    </div>
                    <div class="form-group" <?php if($customFieldData['commonfieldid']>0){?> style="display: none;"<?php } ?>>
                        <label>Field Level <span class="mandatory">*</span></label>
                        <ul>
                            <li style="width: 30%; float: left">
                                <label><input type="radio" name="fieldlevel" class="customFieldLevel" id="customFieldLevelEvent" value="event" required <?php echo !empty($customFieldData) ? 'disabled' : ''; ?> <?php echo (!empty($customFieldData) && $customFieldData['fieldlevel'] == 'event') ? 'checked' : ''; ?>>Event Level</label>
                            </li>
                            <li>
                                <label><input type="radio" name="fieldlevel" class="customFieldLevel" id="customFieldLevelTicket" value="ticket" required <?php echo !empty($customFieldData) ? 'disabled' : ''; ?> <?php echo (!empty($customFieldData) && $customFieldData['fieldlevel'] == 'ticket') ? 'checked' : ''; ?>>Ticket Level</label>
                            </li>
                        </ul>
                        <?php if (!empty($customFieldData)) { ?>
                        <input type="hidden" name="fieldlevel" value="<?php echo $customFieldData['fieldlevel']; ?>">
                        <input type="hidden" name="order" value="<?php echo $customFieldData['order']; ?>">
                        <input type="hidden" name="displayonticket" value="<?php echo $customFieldData['displayonticket']; ?>">
                        <?php } ?>
                    </div>
                     <div class="form-group fieldLevelTickets" <?php echo (!empty($customFieldData) && $customFieldData['fieldlevel'] == 'ticket') ? '' : 'style="display: none"'; ?>>
                        <label>Tickets <span class="mandatory"> *</span></label>
                        <div style="position:relative">
                            <ul>
                                <?php foreach ($eventTickets as $key => $value) { ?>
                                    <li style="width: 30%; float: left">
                                        <label><input type="checkbox" name="ticketIds[]" required value="<?php echo $value['id']; ?>" <?php echo (!empty($customFieldData) && in_array($value['id'], explode(",", $customFieldData["other_ticketids"]))) ? 'checked' : ''; ?>><?php echo $value['name']; ?></label>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div style="clear: both"></div>
                    <div class="form-group" <?php if($customFieldData['commonfieldid']>0){?> style="display: none;"<?php } ?>>
                        <label>Field Type<span class="mandatory"> *</span></label>
                        <div style="position:relative">
                            <span class="icon-downarrow downarrowSettings"></span>
                            <select name="fieldType" required="" id="fieldType">
                                <option value=""> Select an Option </option>
                                <option value="textbox" <?php echo (count($customFieldData) > 0 && $customFieldData["fieldtype"] == 'textbox') ? 'selected="selected"' : ''; ?>>Textbox</option>
                                <option value="textarea" <?php echo (count($customFieldData) > 0 && $customFieldData["fieldtype"] == 'textarea') ? 'selected="selected"' : ''; ?>>Textarea</option>
                                <option value="dropdown" <?php echo (count($customFieldData) > 0 && $customFieldData["fieldtype"] == 'dropdown') ? 'selected="selected"' : ''; ?>>Dropdown</option>
                                <option value="radio" <?php echo (count($customFieldData) > 0 && $customFieldData["fieldtype"] == 'radio') ? 'selected="selected"' : ''; ?>>Radio Options</option>
                                <option value="checkbox" <?php echo (count($customFieldData) > 0 && $customFieldData["fieldtype"] == 'checkbox') ? 'selected="selected"' : ''; ?>>Check Boxes</option>
                                <option value="date" <?php echo (count($customFieldData) > 0 && $customFieldData["fieldtype"] == 'date') ? 'selected="selected"' : ''; ?>>Date</option>
                                <option value="file" <?php echo (count($customFieldData) > 0 && $customFieldData["fieldtype"] == 'file') ? 'selected="selected"' : ''; ?>>File Upload</option>
                            </select>
                        </div>
                    </div>
                    <div id="options_div" class="options_div" <?php if($customFieldData['commonfieldid']>0){?> style="display: none;"<?php } ?>>
                        <ul>
                            <?php
                            if (count($customFieldData) > 0 && ($customFieldData["fieldtype"] == 'dropdown' || $customFieldData["fieldtype"] == 'radio' || $customFieldData["fieldtype"] == 'checkbox')) {
                                foreach ($customFieldValues as $key => $customFieldValue) {
                                    ?>
                                    <li>
                                        <input id="addMoreTicketsInput" type="text" class="textfield addfield"
                                               name="customFieldValues[]" value="<?php echo $customFieldValue['value'];?>">
                                        <span style="cursor: pointer;" class="removeOption">
	                                        Remove

	                                    </span>
                                    </li>
                                <?php }
                            } else {
                                ?>
                                <li>
                                    <input id="addMoreTicketsInput" type="text" class="textfield addfield"
                                           name="customFieldValues[]">
                                    <span style="cursor: pointer;" class="removeOption">
	                                    Remove

	                                </span>
                                </li>
                            <?php } ?>
                        </ul>
                        <span class="field">
	                        <a href="javascript:void(0);"  id="addOptionClass" >+ Add more options</a>
	                    </span>
                    </div>
                    <div class="fs-mandatory-field" <?php if($customFieldData['commonfieldid']>0){?> style="display: none;"<?php } ?>>
                        <input type="checkbox" id="fs-mandatory-field" name="fieldMandatory" value="1" <?php if(isset($customFieldData)& count($customFieldData)>0 & ($customFieldData['fieldmandatory']==1)){?>checked="checked"<?php }?>>
                        <label for="fs-mandatory-field">Make this  field Mandatory</label>
                    </div>
                    <div class="clearBoth"></div>
                    <div class="fs-offline-only-field" <?php if($customFieldData['commonfieldid']>0){?> style="display: none;"<?php } ?>>
                        <input type="checkbox" id="fs-offline-only-field" name="offlineOnly" value="1" <?php if(isset($customFieldData)& count($customFieldData)>0 & ($customFieldData['offlineonly']==1)){?>checked="checked"<?php }?>>
                        <label for="fs-offline-only-field">Make this field only for offline only</label>
                    </div>
                    <div style="display: none;" class="textTextareaLimitations" >
                        <!--Min Length Field-->
                        <div class="widthfloat pull-left topAlign" <?php if($customFieldData['commonfieldid']>0){?> style="display: none;"<?php } ?>>
                            <label class="pull-left" for="minlengthenable">
                                <input type="checkbox" id="minlengthenable" name="minlengthenable" class="pull-left" value="1" <?php if(isset($customFieldData)& count($customFieldData)>0 & ($customFieldData['minlengthenable']==1)){?>checked="checked"<?php }?> >Minimum <span class='cfDateTitle'>Age</span><span class='cfOtherTitle'>Length</span>
                            </label>
                            <div class="pull-left form-group" >
                                <input type="text" class="grid-xs-1 textfield mb-0imp" placeholder="Min Length" name="minlength" id="minlength" <?php if($customFieldData['minlengthenable']==0){ echo "readonly";  } ?> value="<?php if(isset($customFieldData)& count($customFieldData)>0) { echo $customFieldData['minlength']; }?>" >
                                <span></span>
                            </div>
                        </div>
                        <div class="widthfloat pull-left topAlign " <?php if($customFieldData['commonfieldid']>0){?> style="display: none;"<?php } ?>>
                            <label class="pull-left" for="maxlengthenable">
                                <input type="checkbox" id="maxlengthenable" name="maxlengthenable" class="pull-left" value="1" <?php if(isset($customFieldData)& count($customFieldData)>0 & ($customFieldData['maxlengthenable']==1)){?>checked="checked"<?php }?> >Maximum <span class='cfDateTitle'>Age</span><span class='cfOtherTitle'>Length</span>
                            </label>
                            <div class="pull-left form-group" <?php if($customFieldData['commonfieldid']>0){?> style="display: none;"<?php } ?>>
                                <input type="text" class="grid-xs-1 textfield mb-0imp" placeholder="Max Length" name="maxlength" id="maxlength" <?php if($customFieldData['maxlengthenable']==0){ echo "readonly";  } ?> value="<?php if(isset($customFieldData)& count($customFieldData)>0) { echo $customFieldData['maxlength']; }?>" >
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="fs-custom-field-buttons float-right">
                        <input type="submit" name="submit" class="createBtn" value="<?php if(isset($customFieldData)& count($customFieldData)>0){echo 'Update';}else{ echo 'Add Field';}?>"/>
                        <a href="<?php echo site_url("dashboard/configure/customFields/".$eventId); ?>">
                            <button type="button" class="saveBtn">cancel</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
</div>
<script>
    var fieldType = "<?php echo $customFieldData["fieldtype"]; ?>";
    var fieldmandatory = "<?php echo $customFieldData["fieldmandatory"]; ?>";
    var customFieldVaues = "<?php json_encode($customFieldValues) ?>";
</script>


