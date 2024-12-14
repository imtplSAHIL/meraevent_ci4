<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?> 
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Edit Chapter</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form enctype="multipart/form-data" name="OrganizerDetailsForm" id="personalDetails" method="post" action="" >
            <input type="hidden" id="org_id" name="org_id" value="<?php echo $orgnizerDetails['id']; ?>" class="textfield">
            <input type="hidden" id="org_id" name="parentassociationid" value="<?php echo $orgnizerDetails['parentassociationid']; ?>" class="textfield">
            <label>Chapter Display Name <span class="mandatory">*</span></label>
            <input type="text" id="orgname" name="name" value="<?php echo $orgnizerDetails['name']; ?>" class="textfield">
            <div id="userSuccessMessage"> </div> <div id="userErrorMessage"> </div>
            <label>Url <span class="mandatory"></span><?php
                if (isset($orgnizerDetails['slug'])) {
                    $orgurl = $this->config->item('server_path') . "c/" . $orgnizerDetails['slug'];
                    ?> <span><a href="javascript:void(0)" onClick='copyToClipboard("<?php echo $orgurl; ?>")' style="padding-left: 7px;color: #5f259f;">Copy Link</a></span><?php } ?></label>
            <div class="input-group orgslug">
                <span class="input-group-addon"><?php echo $this->config->item('server_path') . "c/"; ?></span>
                <input type="text" class="form-control slug" id='slug' value="<?php echo isset($orgnizerDetails['slug']) ? $orgnizerDetails['slug'] : ''; ?>" readonly="readonly">
            </div>
            <br>
            <label>Chapter promoter Link <span class="mandatory"></span><?php
                if (isset($orgnizerDetails['slug'])) {
                    $orgurl1 = $this->config->item('server_path') . "o/" . $orgnizerDetails['slug'] . "?ucode=organizer";
                    ?> <span><a href="javascript:void(0)" onClick='copyToClipboard("<?php echo $orgurl1; ?>")' style="padding-left: 7px;color: #5f259f;">Copy Link</a></span><?php } ?></label>
            <div class="input-group orgslug">
                <span class="input-group-addon"><?php echo $this->config->item('server_path') . "c/"; ?></span>
                <input type="text" class="form-control slug" id='slug' value="<?php echo isset($orgnizerDetails['slug']) ? $orgnizerDetails['slug'] . "?ucode=organizer" : ''; ?>" readonly="readonly">
            </div>
            <br>

            <label>Description</label>
            <textarea class="textarea" name="information"><?php echo $orgnizerDetails['information']; ?></textarea>
            <div class="form-files">
                <label>Banner Image</label>(only JPG, JPEG, PNG are allowed and should less than 2MB)
                <input type="file"  name='bannerpathid' id='bannerpathid'><img src="<?php echo $orgnizerDetails['bannerPath']; ?>" width="100" height="50"/>
            </div>

            <div class="form-file">
                <label>Logo Image</label>(only JPG, JPEG, PNG are allowed and should less than 2MB)
                <input type="file"  name='logopathid' id='logopathid'><img src="<?php echo $orgnizerDetails['logoPath']; ?>" width="100" height="50"/>
                <br></div>
            <div class="clearBoth"></div>

            <input type="submit"  name="OrganizerDetailsForm" class="submitBtn createBtn float-right" value="UPDATE"/>
        </form>
    </div>
</div>
</div>

<script type="text/javascript" src="<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'bootstrap' . $this->config->item('js_gz_extension'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('cfPath'); ?>css/public/<?php echo 'bootstrap' . $this->config->item('css_gz_extension'); ?>">
<script>
                        var loadUtilsUrl = '<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils' . $this->config->item('js_gz_extension'); ?>';
                            $.fn.intlTelInput.loadUtils(loadUtilsUrl);
                            $("#MobileNo").intlTelInput({
                                autoPlaceholder: "off",
                                separateDialCode: true
                            });
                            $("#otp_mobile").intlTelInput({
                                autoPlaceholder: "off",
                                separateDialCode: true
                            });
//var api_cityCitysByState = "<?php echo commonHelperGetPageUrl('api_cityCitysByState'); ?>";
                            var api_UsermobileverifyOTP = "<?php echo commonHelperGetPageUrl('api_UsermobileverifyOTP'); ?>";
                            var api_UserOTPGen = "<?php echo commonHelperGetPageUrl('api_UserOTPGen'); ?>";
                            var api_checkUserNameExist = "<?php echo commonHelperGetPageUrl('api_checkUserNameExist'); ?>";
                            var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch') ?>";
                            var api_stateSearch = "<?php echo commonHelperGetPageUrl('api_stateSearch') ?>";
                            var api_citySearch = "<?php echo commonHelperGetPageUrl('api_citySearch') ?>";
                            var oldMobileNo = "<?php echo $personalDetails['mobile']; ?>";
</script>
<script>
    $('INPUT[type="file"]').change(function () {

        var size = this.files[0].size;
        var maxFileSize = 2097152;
        if (size > maxFileSize) {
            alert('Image should be less than 2MB');
            this.value = '';
        } else {

            var ext = this.value.match(/\.(.+)$/)[1];
            switch (ext) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    $('.filebutton').attr('disabled', false);
                    break;
                default:
                    alert('Only jp, jpeg, png, gif files are allowed');
                    this.value = '';
            }
        }

    });
</script>