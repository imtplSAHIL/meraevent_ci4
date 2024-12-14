<?php $organizerid = $this->customsession->getUserId(); ?> 
<script type="text/javascript">

    $(document).ready(function () {
        $('#orgname').on('keyup', function () {
            var title = $.trim(this.value);
            var urlStr = title.replace(/[^A-Za-z0-9\-]/g, ' ');
            urlStr = urlStr.replace(/ /g, '-');
            urlStr = urlStr ? urlStr.replace(/-+/g, '-') : '';
            $('.slug').val(urlStr.toLowerCase());
        });
        $('#orgname').on('blur', function () {
            $('#orgname').trigger('keyup');
            checkUrlExists();
        });
        $('.slug').on('blur', function () {
            $('.slug').trigger('keyup');
            checkUrlExists();
        });

        $('#org_email').on('keyup', function () {

            var title = $.trim(this.value);
            //    var urlStr = title.replace(/[^A-Za-z0-9\-]/g, ' ');
            //    urlStr = urlStr.replace(/ /g, '-');
            //    urlStr = urlStr ? urlStr.replace(/-+/g, '-') : '';
            //    $('.slug').val(urlStr.toLowerCase());
        });
        $('#org_email').on('blur', function () {
            $('#org_email').trigger('keyup');
            checkUserEmailExist();
        });

    });

    function checkUrlExists() {
        var url = $('.slug').val();
        var orgId = '<?php echo $organizerid; ?>'
        $.ajax({
            url: "<?php echo commonHelperGetPageUrl('url-exists') ?>", //the page containing php script
            type: "post", //request type,
            dataType: 'json',
            data: {url: url, orgId: orgId},
            success: function (response) {
                if (response.response.userNameStatus == false) {
                    $('#userErrorMessage').html('');
                    $('#userSuccessMessage').html(response.response.messages);
                } else {
                    $('#userSuccessMessage').html('');
                    $('#userErrorMessage').html(response.response.messages);
                }
            }
        });
    }


</script>
<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?> 
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Add Chapter</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form enctype="multipart/form-data" name="OrganizerDetailsForm" id="personalDetails" method="post">
            <input type="hidden" id="org_id" name="org_id" value="" class="textfield">
            <label>Chapter Display Name <span class="mandatory">*</span></label>
            <input type="text" id="orgname" name="name" value="" class="textfield">
            <div id="userSuccessMessage" style="color:green"> </div> <div id="userErrorMessage" style="color:red"> </div>
            <label>Chapter URL <span class="mandatory"></span></label>
            <div class="input-group orgslug">
                <span class="input-group-addon"><?php echo $this->config->item('server_path') . "c/"; ?></span>
                <input type="text" class="form-control slug" name="slug" class='slug' value="" readonly="readonly">
            </div>
            <br>
            <label>Chapter promoter Link <span class="mandatory"></span></label>
            <div class="input-group orgslug">
                <span class="input-group-addon"><?php echo $this->config->item('server_path') . "c/"; ?></span>
                <input type="text" class="form-control slug" name="slug" class='slug' value="" readonly="readonly">
            </div>
            <br>
            <label>Description</label>
            <textarea class="textarea" name="information" required></textarea>
        <!--    <label>Organization User Email<span class="mandatory">*</span></label>
            <input type="text" id="" name="oname" value="" class="textfield">  -->
            <div id="userSuccessMessage" style="color:green"> </div> <div id="userErrorMessage" style="color:red"> </div>
            <div class="form-files">
                <label>Banner Image</label> (only JPG, JPEG, PNG are allowed and should less than 2MB)
                <input type="file"  name='bannerpathid' id='bannerpathid' class="filebutton" required>
                <br>
            </div>
            <div class="form-file">
                <label>Logo Image</label>(only JPG, JPEG, PNG are allowed and should less than 2MB)
                <input type="file"  name='logopathid' id='logopathid' class="filebutton" required>
                <br>
            </div>
            <div class="clearBoth"></div>

            <input type="submit"  name="submit" class="submitBtn createBtn float-right" value="Create Chapter"/>
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


