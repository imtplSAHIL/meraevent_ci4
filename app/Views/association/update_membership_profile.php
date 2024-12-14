<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?>
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Update Profile</h2>
    </div> 
    <div class="editFields fs-profile-form">

        <form name="personalDetails" id="personalDetails" method="post" action="" >
            <input type="hidden" name="id" value="<?php echo $editdata['membershipdetailsinfo'][0]['id']; ?>">
            <div class="form-group">
                <label>Select Chapter <span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="chapter_id" id="chapter_id" required>
                            <option value="<?php echo $editdata['membershipdetailsinfo'][0]['chapterid']; ?>"><?php echo $editdata['chapterdata'][0]['name'] ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Select Membership Type <span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="mermbershiptype_id" id="mermbershiptype_id" required>
                        <option value="<?php echo $editdata['membershipdetailsinfo'][0]['membershipid']; ?>"><?php echo $editdata['membershipdata'][0]['name'] ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Name <span class="mandatory" >*</span></label>
                <input type="text" name="name" class="textfield" value="<?php echo $editdata['membershipdetailsinfos']['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email <span class="mandatory" >*</span></label>
                <input type="text" name="email" class="textfield" value="<?php echo $editdata['membershipdetailsinfos']['email']; ?>" readonly required>
            </div>
            <div class="form-group">
                <label>Mobile Number <span class="mandatory" >*</span></label>
                <input type="text" name="mobile" class="textfield" value="<?php echo $editdata['membershipdetailsinfos']['mobile']; ?>"  required>
            </div>
            <div id="customFields"></div>

            <?php
if (!empty($customFields['response']['customFields'])) {
    foreach ($customFields['response']['customFields'] as $customField) {
        $fieldName = str_replace(" ", "", preg_replace("/[^A-Za-z0-9\s\s]/", "", $customField['fieldname']));
        $manadatorySpan = $requiredInput = '';
        if ($customField['fieldmandatory'] == 1) {
            $manadatorySpan = '<span class="mandatory" >*</span>';
            $requiredInput = 'required';
        }
        if ($customField['fieldtype'] == 'textbox') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <input type="text" name="<?php echo $fieldName; ?>" value="<?php echo $editdata['membershipdetailsinfos'][$fieldName]; ?>" class="form-control" <?php echo $requiredInput; ?>>
            </div>
            <?php
        } else if ($customField['fieldtype'] == 'textarea') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <textarea type="text" name="<?php echo $fieldName; ?>" class="form-control" <?php echo $requiredInput; ?>><?php echo $editdata['membershipdetailsinfos'][$fieldName]; ?></textarea>
            </div>
            <?php
        } else if ($customField['fieldtype'] == 'dropdown') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="<?php echo $fieldName; ?>" <?php echo $requiredInput; ?>>
                        <option value=''>Select</option>
                        <?php foreach ($customFields['response']['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                            <option value="<?php echo $customFieldValueArr['value']; ?>" <?php if ($customFieldValueArr['value'] == $editdata["membershipdetailsinfos"][$fieldName]) { ?> selected="selected" <?php } ?>><?php echo $customFieldValueArr['value']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php
        } else if ($customField['fieldtype'] == 'radio') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <ul>
                    <?php foreach ($customFields['response']['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                        <li style="width: 33.33%; float: left">
                            <label><input type="radio" name="<?php echo $fieldName; ?>" value="<?php echo $customFieldValueArr['value']; ?>" <?php echo in_array($customFieldValueArr['value'], explode(",",$editdata["membershipdetailsinfos"][$fieldName])) ? 'checked' : ''; ?> <?php echo $requiredInput; ?>><?php echo $customFieldValueArr['value']; ?></label>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div style="clear:both"></div>
            <?php
        } else if ($customField['fieldtype'] == 'checkbox') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <div style="position:relative">
                    <ul>
                        <?php foreach ($customFields['response']['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                            <li style="width: 33.33%; float: left">
                                <label><input type="checkbox" name="<?php echo $fieldName; ?>[]" value="<?php echo $customFieldValueArr['value']; ?>" <?php echo in_array($customFieldValueArr['value'], explode(",",$editdata["membershipdetailsinfos"][$fieldName])) ? 'checked' : ''; ?>  <?php echo $requiredInput; ?>><?php echo $customFieldValueArr['value']; ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div style="clear:both"></div>
            <?php
        }
    }
}
?>

            <br>
            <div class="clearBoth"></div>
            <input type="submit"  name="submit" class="submitBtn createBtn float-right" value="Update Profile"/>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'bootstrap' . $this->config->item('js_gz_extension'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('cfPath'); ?>css/public/<?php echo 'bootstrap' . $this->config->item('css_gz_extension'); ?>">
<script>
    $(document).ready(function () {
        $('#personalDetails').validate({
            rules: {
                chapter_id: {
                    required: true
                },
                mermbershiptype_id: {
                    required: true
                },
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: true,
                    phonePattern: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                }
            },
            messages: {
                chapter_id: {
                    required: "Please select chapter"
                },
                mermbershiptype_id: {
                    required: "Please select membership type"
                },
                name: {
                    required: "Please enter name"
                },
                email: {
                    required: "Please enter email",
                    email: "Please enter valid email"
                },
                mobile: {
                    required: "Please enter mobile number",
                    number: 'Please enter numbers only',
                    minlength: 'Please enter valid number',
                    maxlength: 'Please enter maximum 10 numbers only'
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") == 'checkbox') {
                    error.insertBefore(element.parent().parent().parent().parent().parent());
                } else if (element.attr("type") == 'radio') {
                    error.insertBefore(element.parent().parent().parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
        $.validator.addMethod("phonePattern", function (phone_number, element) {
            return this.optional(element) || phone_number.length > 1 &&
                    phone_number.match(/^([0|\+[0-9 -]{1,5})?[0-9 -]+$/);
        }, "Invalid mobile number");
    });
</script>



