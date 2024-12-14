<style>
    .paymentmode-section1 p {
        height: auto !important;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
    }
    .text-left {
        text-align: left !important;
        height: auto !important;
    }
    .paymentmode-section1 label {
        display: inline-block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    .paymentmode-section1 img {
        vertical-align: middle;
    }
    .paymentmode-section1 p {
        height: auto !important;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        display: inline-block;
    }
    .paymentmode-holder .custom-radio {
        width: 23px;
        height: 23px;
        display: inline-block;
        position: relative;
        z-index: 1;
        top: 5px;
        background: url("/css/res/images/radio_btn.png") no-repeat;
    }
    .paymentmode-holder .custom-radio input[type="radio"] {
        margin: 1px;
        position: absolute;
        top: 0;
        left: 0;
        width: 23px;
        height: 23px;
        z-index: 2;
        cursor: pointer;
        outline: none;
        opacity: 0;
        _noFocusLine: expression(this.hideFocus=true);
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        filter: alpha(opacity=0);
        -khtml-opacity: 0;
        -moz-opacity: 0;
    }
    .paymentmode-holder span {
        font-size: 16px;
        font-family: 'Roboto';
        color: #a09f9f;
        font-weight: 100;
    }
    .paymentmode-holder .custom-radio.selected {
        background: url("/css/res/images/radio-selected.png") no-repeat;
    }
    .paymentmode-holder .custom-radio {
        top: 20px !important;
    }
    .commonBtn {
        background: #9063CD;
        border: 2px solid #9063CD;
        border-radius: 5px;
        -moz-background-clip: padding;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        color: #FFF;
        font-size: 16px;
        font-weight: 400;
        line-height: 36px;
        margin-bottom: 17px;
        text-transform: none;
        width: 320px;
        height: 50px;
    }
    .mandatory, .error { color: red; }
    #customFields ul { list-style: none; }
</style>
<?php if (isset($message)) { ?>
    <div id="personalDetailsMessage" <?php if ($status) { ?>
             class="db-alert db-alert-success flashHide" <?php } else { ?> 
             class="db-alert db-alert-danger flashHide" <?php } ?> >
        <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
    </div>
<?php } ?> 
<section>
    <div class="container-fluid">
        <div class="content-body">
            <div class="container">
                <form action="" method="post" id="joinForm">
                    <input type="hidden" name="orgid" value="<?php echo $orgid; ?>">
                    <input type="hidden" name="paymentGatewayId" id="paymentGatewayId">
                    <div class="panel-group" id="next_accordion" role="tablist" aria-multiselectable="true" style="margin-top: 10px">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title"><span>1</span> Please Choose Membership Type</h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in"  aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <?php
                                            $i = 0;
                                            foreach ($membershipTypes['response']['membershipTypes'] as $data) {
                                                $checked = "";
                                                if ($i == 0) {
                                                    $checked = "checked";
                                                }
                                                $i++;
                                                ?>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <label class="custom-radio">
                                                        <?php echo $data['name']; ?> 
                                                        <input type="radio" name="organizationmembershipid" value="<?php echo $data['id']; ?>" <?php echo $checked; ?>>
                                                        <span class="checkmark"> </span>
                                                    </label>
                                                </div>
                                                <div class="col-xs-8 col-sm-3 col-md-4 col-lg-5 text-right">
                                                    <h5>INR <?php echo $data['price']; ?></h5>
                                                </div>
                                                <input type="hidden" name="price" id="price" value="">
                                                <input type="hidden" name="type" value="">
                                                <input type="hidden" name="tax" value="">  
                                                <input type="hidden" name="totalamount" value="">  
                                                <input type="hidden" name="eventid" value="">
                                                <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
                                                    <select class="form-control quantity" name="quantity" id="qty<?php echo $data['id']; ?>" data-mid="<?php echo $data['id']; ?>" data-type="<?php echo $data['type']; ?>" data-tax="<?php echo $data['tax']; ?>" data-price="<?php echo $data['price']; ?>" data-eventid="<?php echo $data['eventid']; ?>">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="row" id="price-show" style="display: none;">
                                            <div class="col-xs-12 col-sm-6 col-md-4 registration-amount" >
                                                <div class="col-xs-12 col-sm-12 col-md-12 sub-total sub-quantity" >
                                                    <p>Quantity :</p>
                                                    <p class="sub-qty">1</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 sub-total">
                                                    <p>Sub Total :</p>
                                                    <p class="subtotal">₹ </p>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 sub-total extraTax CGST" style="">
                                                    <p>GST :</p>
                                                    <p class="CGST-value">₹ </p>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 discount sub-total" >
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 sub-total total-amount">
                                                    <p>Total :</p>
                                                    <p class="totalPrice" style="background-color: rgb(255, 255, 255);">₹ </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group text-right">
                                            <button type="button" class="btn btn-info proceedBtn">Proceed</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><span>2</span> Registration Details</h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="Name">Name <span class="mandatory">*</span></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Mail">Email <span class="mandatory">*</span></label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Mobile Number <span class="mandatory">*</span></label>
                                        <input type="text" name="mobile" class="form-control" required>
                                    </div>
                                    <input type="hidden" name="chapterName" value="<?php echo $chapterName; ?>">
                                    <div id="customFields"></div>
                                    <?php
                                    if (count($eventGateways) > 0) {
                                        $showPaymentGateways = true;
                                        $signupStagedStatus = 1;
                                        foreach ($eventGateways as $key => $gateway) {
                                            if ($gateway['functionname'] == 'stripe' && $gateway['selected'] == 1) {
                                                $otherCurrencyGatewaySelected = 1;
                                            }
                                        }
                                        ?>
                                        <div class="col-xs-12 paymentmode-section1">
                                            <h2 class="pageTitle">Proceed to pay using</h2>
                                            <?php
                                            $ebsGateway = $ebsKey = 0;
                                            $paytmGateway = $paytmKey = 0;
                                            $paypalGateway = $paypalKey = 0;
                                            $mobikwikGateway = $mobikwikKey = 0;
                                            $selectPaypal = FALSE;
                                            foreach ($eventGateways as $key => $gateway) {
                                                $gatewayName = strtolower($gateway['gatewayName']);
                                                $gatewayKey = $gateway['paymentgatewayid'];
                                                $gatewayDescription = $gateway['description'];
                                                $gatewayFunction = $gateway['functionname'];
                                                $gatewayImage = $gateway['imageid'];
                                                if (($gateway['selected'] == 1 && in_array($gatewayFunction, array('paypal', 'paypalinr'))) && $otherCurrencyGatewaySelected == 0) {
                                                    $selectPaypal = TRUE;
                                                }
                                                ?>
                                                <!--New Payment Gateway-->
                                                <div class="col-sm-12 width100 paymentmode-holder marginbottom10">
                                                    <label class="text-left">
                                                        <label>
                                                            <input type="radio" id="<?php echo $gatewayKey; ?>" name="paymentGateway" value="<?php echo $gatewayFunction; ?>" <?php
                                                            if (($gateway['selected'] == 1)) {
                                                                echo 'checked="checked"';
                                                            }
                                                            ?>>
                                                            <label id="<?php echo $gatewayFunction; ?>_text"></label>
                                                            <p class="PG-New-ImgHodler">
                                                                <img src="<?php echo $gatewayImage; ?>" />
                                                            </p>
                                                            <p class="PG-NewText" id="<?php echo $gatewayFunction; ?>_text"><?php echo $gatewayDescription; ?>
                                                            </p>
                                                        </label>
                                                    </label>
                                                </div>
                                                <!--New Payment Gateway-->
                                            <?php } if (!empty($termsandconditions)) { ?>
                                            <div class="form-group">
                                                <input type="checkbox" name="acceptterms" value="1"><a id="termsBtn" ><label for="acceptterms"> Accept Terms & Conditions <span class="mandatory">*</span></label></a>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <?php $paypalCheck = array_column($eventGateways, 'gatewayName'); ?>
                                    <div class="PayNow-Holder">
                                        <a id="paynow" href="javascript:void(0)" class="btn commonBtn" <?php if ($selectPaypal == TRUE) { ?>style="display:none"<?php } ?>>Pay Now</a>
                                        <?php if (in_array('paypal', $paypalCheck) || in_array('paypalinr', $paypalCheck)) { ?> 
                                            <div id="paypal-button-container" class="paynowbtn margintop20" <?php if ($selectPaypal == FALSE) { ?>style="display:none"<?php } ?>></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                foreach ($eventGateways as $key => $gateway) {
                    $gatewayName = strtolower($gateway['gatewayName']);
                    $gatewayKey = $gateway['paymentgatewayid'];
                    $gatewayDescription = $gateway['description'];
                    $gatewayFunction = $gateway['functionname'];
                    $gatewayImage = $gateway['imageid'];
                    $actionUrl = site_url('organizationpayment/' . $gatewayFunction . 'Prepare');
                    ?>
                    <form name="<?php echo $gatewayFunction; ?>_frm" id="<?php echo $gatewayFunction; ?>_frm" action="<?php echo $actionUrl; ?>" method='POST'>
                        <input type="hidden" name="eventTitle" value="Membership" />
                        <input type="hidden" name="eventSignupId" class="eventSignupId" value="" />
                        <input type="hidden" name="orderTotalAmount" class="orderTotalAmount" value="" />
                        <input type="hidden" name="paymentGatewayKey" value="<?php echo $gatewayKey; ?>" />
                        <input type="hidden" name="paymentName" class="paymentName" />
                        <input type="hidden" name="paymentEmail" class="paymentEmail" />
                        <input type="hidden" name="paymentMobile" class="paymentMobile" />
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script>
    $("#termsBtn").click(function () {
        var count = -1; // initially -1 as we are having a delay of 1000ms
        var counter = setInterval(timer, 100); //1000 will  run it every 1 second
        function timer()
        {
            count = count + 1;
            if (count >= 2) //+1 than the req time as we have a delay of 1000ms
            {
                clearInterval(counter);
                /////////////what code should go here for the modal to pop up??///////////////////////
                $("#terms").modal();

                return;
            }
            //document.getElementById("timer").innerHTML=count + " secs"; // watch for spelling
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('.quantity ').val('0');
        $('.proceedBtn').click(function () {
            var qtyCheck = false;
            $(".quantity").each(function () {
                if ($(this).val() > 0) {
                    qtyCheck = true;
                }
            });
            if (qtyCheck && $('.type').val() != '') {
                $.ajax({
                    url: "<?php echo commonHelperGetPageUrl('assocation-get-membership-type-custom-fields'); ?>",
                    method: "POST",
                    data: {id: $('input[name=organizationmembershipid]:checked').val()},
                    success: function (data) {
                        $('#customFields').html(data);
                    }
                });
                $('#collapseOne').collapse('hide');
                $('#collapseTwo').collapse('show');
            } else {
                alert('Please select Membership type & quantity');
            }
        });
        $('#joinForm').validate({
            rules: {
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
                },
                acceptterms: {
                    required: true
                }
            },
            messages: {
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
                },
                acceptterms: {
                    required: "Please accept terms and conditions"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") == 'checkbox') {
                    error.insertAfter(element.parent().children('a'));
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
        $('input[name=organizationmembershipid]').change(function () {
            $('.quantity ').val('0');
            $("#qty" + $(this).val()).val(1).trigger('change');
        });
        $('.quantity').on('change', function () {
            $('.quantity').attr('disabled', 'disabled');
            $("input[name=organizationmembershipid]").removeAttr('checked');
            if ($(this).val() == '1') {
                $("input[name=organizationmembershipid][value=" + $(this).data('mid') + "]").attr('checked', 'checked');
                $(this).removeAttr("disabled");
                $("#price-show").show();
                var newPrice = $(this).data('price');
                var tax = $(this).data('tax');
                var type = $(this).data('type');
                var eventid = $(this).data('eventid');
                gst = (newPrice * tax) / 100;
                total = newPrice + gst;
                $(".subtotal").html(newPrice);
                $(".CGST-value").html(gst);
                $(".totalPrice").html(total);
                /// $("#price").value(total);
                $('input[name="price"]').val(newPrice);
                $('input[name="tax"]').val(gst);
                $('input[name="totalamount"]').val(total);
                $('input[name="type"]').val(type);
                $('input[name="eventid"]').val(eventid);
                if (total == 0) {
                    $('.paymentmode-section1').hide();
                }
            } else {
                $("#price-show").hide();
                $('.quantity').removeAttr('disabled', 'disabled');
                $('input[name="price"]').val('');
            }
        });
        $('.paymentmode-section1 input[type="radio"]').each(function () {
            $(this).wrap("<span class='custom-radio'></span>");
            if ($(this).is(':checked')) {
                $(this).parent().addClass("selected");
            }
        });
        $('.paymentmode-section1 input[type="radio"]').click(function () {
            $(".custom-radio").removeClass("selected");
            $(this).parent().toggleClass("selected");
        });
        $('#paynow').click(function () {
            if ($('#joinForm').valid()) {
                var paymentGateWay = $('input[name="paymentGateway"]:checked').val();
                var gateWayId = $('input[name="paymentGateway"]:checked').attr('id');
                $('#paymentGatewayId').val(gateWayId);
                var formData = new FormData($('#joinForm')[0]);
                var syncType = true;
                var isSeating = 0;
                if ((paymentGateWay == 'paypal' || paymentGateWay == 'paypalinr') && isSeating == '0') {
                    syncType = false;
                }
                $.ajax({
                    url: '<?php echo commonHelperGetPageUrl('save_membership') ?>',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    async: syncType,
                    beforeSend: function () {
                        $("#dvLoading").show();
                    },
                    success: function (retData) {
                        $('.eventSignupId').val(retData.eventSignupId);
                        $('.orderTotalAmount').val(retData.totalamount);
                        $('.paymentName').val(retData.name);
                        $('.paymentEmail').val(retData.email);
                        $('.paymentMobile').val(retData.mobile);

                        if (retData.status) {
                            if (retData.totalamount == 0) {
                                window.location.href = '<?php echo commonHelperGetPageUrl('membership_confirmation'); ?>?id=' + retData.eventSignupId;
                            } else {
                                if (paymentGateWay == 'stripe') {
                                    $("#customButton").click();
                                } else if (paymentGateWay == 'razorpay') {
                                    var options = JSON.parse(retData.razorpayInput);
                                    var rpReturnUrl = options.returnUrl;
                                    options.handler = function (response) {
                                        processRazorpayTransaction(response, rpReturnUrl);
                                    };
                                    options.theme.image_padding = false;
                                    options.modal = {
                                        ondismiss: function () {
                                            $("#dvLoading").hide();
                                        },
                                        escape: true,
                                        backdropclose: false
                                    };

                                    var rzp = new Razorpay(options);

                                    $("#rzp-button1").click(function (e) {
                                        rzp.open();
                                        e.preventDefault();
                                    });
                                    $("#rzp-button1").click();
                                } else if (paymentGateWay == 'paypal') {
                                    if (isSeating == '0') {
                                        $("#dvLoading").hide();
                                    }
                                } else if (paymentGateWay == 'paypalinr') {
                                    if (isSeating == '0') {
                                        $("#dvLoading").hide();
                                    }
                                } else {
                                    $('#' + paymentGateWay + '_frm').submit();
                                }
                            }
                        } else {
                            alert(retData.message);
                            $("#dvLoading").hide();
                            return false;
                        }
                    },
                    error: function (result) {
                        var messages = result.responseJSON.response.messages;

                        var serverError = '';
                        $.each(messages, function (i, l) {
                            serverError += "* " + l + "<br>";
                        });
                        $('#booking_message_div').html(serverError);
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                        $("#dvLoading").hide();
                    }
                });
            }
        });
    });
    $('.paymentmode-holder input[name="paymentGateway"]').on('change', function () {
        var paymentGateWay = $('input[name="paymentGateway"]:checked').val();
        if (paymentGateWay == 'paypal' || paymentGateWay == 'paypalinr') {
            $('#paynow').hide();
            $('#paypal-button-container').show();
        } else {
            $('#paynow').show();
            $('#paypal-button-container').hide();
        }
    });
</script>
<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="terms" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Terms & Conditions</h4>
                </div>
                <div class="modal-body">
                    <p><?php echo $termsandconditions; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<?php
foreach ($eventGateways as $key => $gateway) {
    if (in_array($gateway['functionname'], array('stripe', 'razorpay', 'paypal', 'paypalinr'))) {
        if (isset($gateway['environment'])) {
            $paypalGatewayEnvironment = $gateway['environment'];
        }
        if ($gateway['functionname'] == 'paypalinr') {
            $gateway['functionname'] = 'paypal';
        }
        include_once APPPATH . 'views/payment/' . $gateway['functionname'] . '_prepare.php';
    }
}
?>