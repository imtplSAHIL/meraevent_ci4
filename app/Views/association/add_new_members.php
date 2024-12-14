<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?>
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Add New Member</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form name="personalDetails" id="personalDetails" method="post" action="" >
            <div class="form-group">
                <label>Select Chapter <span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="chapter_id" id="chapter_id" required>
                        <option value="">Select Chapter</option>
                        <?php foreach ($chapters as $chapter) { ?>
                            <option value="<?php echo $chapter['id']; ?>"><?php echo $chapter['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Select Membership Type <span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="mermbershiptype_id" id="mermbershiptype_id" required>
                        <option value="">Select Membership Type</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Name <span class="mandatory" >*</span></label>
                <input type="text" name="name" class="textfield" required>
            </div>
            <div class="form-group">
                <label>Email <span class="mandatory" >*</span></label>
                <input type="text" name="email" class="textfield" required>
            </div>
            <div class="form-group">
                <label>Mobile Number <span class="mandatory" >*</span></label>
                <input type="text" name="mobile" class="textfield" required>
            </div>
            <div id="customFields"></div>
            <br>
            <div class="clearBoth"></div>
            <input type="submit"  name="submit" class="submitBtn createBtn float-right" value="Create Member"/>
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
        $("#chapter_id").change(function () {
            $('#customFields').html('');
            if ($(this).val() > 0) {
                $.ajax({
                    url: "<?php echo commonHelperGetPageUrl('assocation-get-membership-type-options'); ?>",
                    method: "POST",
                    data: {parentassociationid: <?php echo $associationId; ?>, id: $(this).val()},
                    success: function (data) {
                        $('#mermbershiptype_id').html(data);
                    }
                });
            } else {
                $('#mermbershiptype_id').html('<option>--Select--</option>');
            }
        });
        $("#mermbershiptype_id").change(function () {
            $('#customFields').html('');
            if ($(this).val() > 0) {
                $.ajax({
                    url: "<?php echo commonHelperGetPageUrl('assocation-get-membership-type-custom-fields'); ?>",
                    method: "POST",
                    data: {id: $(this).val()},
                    success: function (data) {
                        $('#customFields').html(data);
                    }
                });
            }
        });
    });
</script>



