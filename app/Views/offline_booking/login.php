<div class="fs-form" style="width: 100%">
    <div id="offlineFlashError" class="db-alert db-alert-danger flashHide" style="display:none"></div>
    <h2 class="fs-box-title">Offline Booking - Login</h2>
    <div class="editFields">
        <form method="post" name="loginForm" id="loginForm">
            <input type="hidden" name="type" value="ME">
            <label>Email <span class="mandatory">*</span></label>
            <label>
                <input type="text" name="email" class="textfield">
            </label>
            <div class="clearBoth"></div>
            <label>Password <span class="mandatory">*</span></label>
            <label>
                <input type="password" name="password" class="textfield">
            </label>
            <input type="button" name="login" id="login" class="createBtn" value="LOG IN" style="margin-top: 0px"/>
        </form>
    </div>
</div>
<script>
    var api_UserLogin = "<?php echo commonHelperGetPageUrl('api_UserLogin') ?>";
    $(document).ready(function () {
        $('#loginForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "Please enter  email",
                    email: "Please enter valid email"
                },
                password: {
                    required: "Please enter password"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr('type') == 'checkbox' || element.attr('type') == 'radio') {
                    error.insertAfter($("input[name='" + element.attr('name') + "']:last"));
                } else {
                    error.insertAfter(element);
                }
            }
        });
        $(".createBtn").click(function () {
            if ($('#loginForm').valid()) {
                $.ajax({
                    url: api_UserLogin,
                    method: "POST",
                    data: $('#loginForm').serialize(),
                    success: function (data) {
                        if (data.response.total > 0) {
                            window.location = '<?php echo site_url(); ?>offlineBooking/booking';
                        } else {
                            $("#offlineFlashError").text(data.response.messages[0]);
                            $("#offlineFlashError").css('display', 'block').delay(5000).fadeOut('slow');
                        }
                    },
                    error: function (result) {
                        $("#offlineFlashError").text(result.responseJSON.response.messages[0]);
                        $("#offlineFlashError").css('display', 'block').delay(5000).fadeOut('slow');
                    }
                });
            }
        });
        $('#ticket').change(function () {
            getCustomFieldsData();
        });
    });
</script>