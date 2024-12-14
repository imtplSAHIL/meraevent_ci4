<div class="page-container">
    <div class="wrap">
        <div class="container print_ticket">
            <?php if (isset($message) && $message != '') { ?>
                <div class="row">
                    <div class="col-md-6" style="margin-left:0px;">
                        <div style="background-color: green; color: #fff; padding: 10px"><?php echo $message; ?></div>
                    </div>
                </div>
                <?php
                header("refresh:2; url=" . commonHelperGetPageUrl('contactUsForm'));
            }
            ?>
            <div class="col-md-6">
                <form method="POST" action="" id="ContactForm">
                    <div class="form-group">
                        <span>Name <span class="err-msg">*</span></span>
                        <input type="text" class="form-control userFields" name="cname">
                    </div>
                    <div class="form-group">
                        <span>Email <span class="err-msg">*</span></span>
                        <input type="text" class="form-control userFields" name="cemail">
                    </div>
                    <div class="form-group">
                        <span>Contact Number <span class="err-msg">*</span></span>
                        <input type="text" class="form-control userFields" name="cphone">
                    </div>
                    <div class="form-group">
                        <span>Message <span class="err-msg">*</span></span>
                        <textarea class="form-control userFields" rows="4" style="height: auto" name="cmsg"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha form-field" data-sitekey="<?php echo $siteKey; ?>"></div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default sbtn login gobtn" type="button">GO</button>
                    </div>
                </form>
            </div>
            <div class="col-md-5 fright">
                <h2>MeraEvents</h2>
                <p style="font-size: 16px; margin: 10px 0 10px 0;">
                    <!-- H.No. 7-56/19, Second Floor, Prashant Hills,
                    Raidurg, Hyderabad - 500032
                    Telangana, India -->
                    5th Floor, Dwaraka Heights, Plot No. 17 Jubilee Enclave,
                    Hitech City, Hyderabad TG 500081 IN.
                </p>
                <p style="font-size: 16px; margin: 10px 0 20px 0;">Email <a href="mailto:support@meraevents.com">support@meraevents.com</a></p>
                <p style="height: 300px">
                    <iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3806.064253261444!2d78.37313641477645!3d17.456638505399148!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb93c50ab507bd%3A0xc9a051506cede52!2sMeraEvents!5e0!3m2!1sen!2sin!4v1554996567557!5m2!1sen!2sin"></iframe>
                </p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
<script>
    $(function () {
        $('.gobtn').click(function () {
            var form = $("#ContactForm");
            form.validate({
                rules: {
                    cname: {
                        required: true
                    },
                    cemail: {
                        required: true,
                        email: true
                    },
                    cphone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    cmsg: {
                        required: true
                    }
                }
            });
            var isValid = form.valid();
            if (isValid) {
                form.submit();
            } else {
                return false;
            }
        });
    });
</script>
