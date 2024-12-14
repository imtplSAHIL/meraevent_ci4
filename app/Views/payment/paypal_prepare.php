<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<script>

    var CREATE_PAYMENT_URL  = '<?php echo commonHelperGetPageUrl('payment_paypalPreparePage');?>';
    var EXECUTE_PAYMENT_URL = '<?php echo commonHelperGetPageUrl('payment_paypalExecuteApi');?>';

    paypal.Button.render({

        env: '<?php if(isset($paypalGatewayEnvironment) && $paypalGatewayEnvironment == 'PROD'){ echo 'production'; }else{ echo 'sandbox'; } ?>', // Or 'sandbox'

        commit: true, // Show a 'Pay Now' button

        style: {
            label: 'checkout',
            fundingicons: true, // optional
            branding: true, // optional
            size:  'medium', // small | medium | large | responsive
            shape: 'rect',   // pill | rect
            color: 'gold'   // gold | blue | silve | black
        },

        <?php if(isset($calculationDetails) && $calculationDetails['currencyCode'] == 'USD'){ ?>
        funding: {
            allowed: [ paypal.FUNDING.CARD, paypal.FUNDING.CREDIT],
        },
        <?php } ?>

        payment: function() {
            <?php if(isset($seatsioticketmapping)){ ?>
                var paymentGateWay = paymentGatewaySelected;
            <?php }else{ ?>
                var paymentGateWay = $('input[name="paymentGateway"]:checked').val();
            <?php } ?>
            $('#paynow').click();
            var serializedData = $('#'+paymentGateWay+'_frm').serializeArray();
            var formValues = {};
            $.map(serializedData, function(n, i){
                formValues[n['name']] = n['value'];
            });
            var signupid = $('.eventsignupTextbox').val();
            
            return paypal.request.post(CREATE_PAYMENT_URL,formValues).then(function(data) {
                if(data.status == true){
                    return data.id;
                }else{
                    throw new Error(data.message);
                }
            })
        },

        onCancel: function(data, actions) {
            return actions.redirect();
        },

        <?php if($paypalEnableSeating == TRUE){ ?>
            onClick: function() {
                validat_reg_form();
            },
        <?php } ?>
        

        onError: function(err) {
            var error = 'Something Went Wrong! Please try again!';
            $('#booking_message_div').html(error);
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#dvLoading").hide();
        },

        onAuthorize: function(data,actions) {
            <?php if(isset($seatsioticketmapping)){ ?>
                var paymentGateWay = paymentGatewaySelected;
            <?php }else{ ?>
                var paymentGateWay = $('input[name="paymentGateway"]:checked').val();
            <?php } ?>
            var serializedData = $('#'+paymentGateWay+'_frm').serializeArray();
            var formValues = {};
            $.map(serializedData, function(n, i){
                formValues[n['name']] = n['value'];
            });
            var final = Object.assign({
                paymentID: data.paymentID,
                payerID:   data.payerID
            },formValues);
            return paypal.request.post(EXECUTE_PAYMENT_URL,final).then(function(data) {
                if(data.status == true){
                    return actions.redirect();
                }else{
                    if(data.response.code === 'INSTRUMENT_DECLINED'){
                        actions.restart();
                    }else{
                        $('#booking_message_div').html(data.response.messages);
                        $("html, body").animate({scrollTop: 0}, "slow");
                        $("#dvLoading").hide();
                    }
                }
                
            });
        }

    }, '#paypal-button-container');
</script>