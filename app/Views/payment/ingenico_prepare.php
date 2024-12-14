<style>
    #checkoutmodal { line-height: initial; }
    #checkoutmodal #paymethod-all li.pay_option { float: none; display: inline; }
    #checkoutmodal #paymethod-savedcard ul.tablist li { width: 100%; }
</style>
<script type="text/javascript" src="https://www.paynimo.com/Paynimocheckout/server/lib/checkout.js"></script>
<script>
    function handleResponse(res) {
        if (typeof res != 'undefined' && typeof res.paymentMethod != 'undefined' && typeof res.paymentMethod.paymentTransaction != 'undefined' && typeof res.paymentMethod.paymentTransaction.statusCode != 'undefined' && res.paymentMethod.paymentTransaction.statusCode == '0300') {
            // success code
        } else {
            // error code
        }
    }
    /*Close Button event to hide your loader*/
    $(document).off('click', '.popup-close').on('click', '.popup-close', function () {
        $("#dvLoading").hide();
    });
</script>