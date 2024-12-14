<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
            class="db-alert db-alert-success flashHide" <?php } else { ?>
            class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp; <?php echo $message; ?></strong>
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association Member - Upload Profile Picture</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form name="personalDetails" id="personalDetails" method="post" action="" enctype="multipart/form-data" >
            <div class="form-group">
                <label>Profile Picture</label>
                (only JPG, JPEG, PNG are allowed and should less than 2MB)
                <input type="file" id="picture" name="picture" value="" class="upload_image textfield"/>
                <?php if ($personalDetails['profileimagefilepath'] != "") { ?>
                    <br/>
                    <img src="
            <?php echo $personalDetails['profileimagefilepath']; ?>" style="width: 200px;height: 200px;"/>
                    <br/>
                <?php } ?>
            </div>
            <br>
            <div class="clearBoth"></div>
            <input type="submit" name="submit" class="submitBtn createBtn float-right" value="Upload Picture"/>
        </form>
    </div>
</div>
<script type="text/javascript"
        src="<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'bootstrap'.$this->config->item(
                'js_gz_extension'
            ); ?>"></script>
<link rel="stylesheet" type="text/css"
      href="<?php echo $this->config->item('cfPath'); ?>css/public/<?php echo 'bootstrap'.$this->config->item(
              'css_gz_extension'
          ); ?>">
<script>
    $(document).ready(function () {
        $('#personalDetails').validate({
            rules: {
                picture: {
                    accept: "jpg|png|jpeg",
                    filesize: 2000000
                }
            },
            messages: {
                picture: {
                    accept: "Only image type jpg/png/jpeg is allowed",
                    filesize: "Image size should be less than 2 MB"
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
    });
</script>



