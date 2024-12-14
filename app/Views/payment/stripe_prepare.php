

<script src="https://checkout.stripe.com/checkout.js"></script>
<button id="customButton" style="display:none">Purchase</button>

<script>
var handler = StripeCheckout.configure({
  key: '<?php echo $gateway['hashkey']; ?>',
  image: '<?php echo $this->config->item('images_static_path')?>me-logo-200.png',
  locale: 'auto',
  token: function(token) {
	 //$("#dvLoading").show();
	  if(token.id.length > 0){
		   window.location = '<?php echo commonHelperGetPageUrl('payment',$gateway['functionname']."ProcessingPage"); ?>?orderId=<?php echo $orderLogId; ?>&samepage=<?php echo $samepage; ?>&paymentGatewayKey=<?php echo $gateway['paymentgatewayid']; ?>&tokenid='+token.id+'&eventtitle=<?php echo stripslashes($eventData['title'])?>&themefields=<?php echo $themeFieldsUrl;?>';
		  
	  }
    // You can access the token ID with `token.id`.
    // Get the token ID to your server-side code for use.
  },
  closed : function(){
	  $("#dvLoading").hide();
  }
});

document.getElementById('customButton').addEventListener('click', function(e) {
  // Open Checkout with further options:
  handler.open({
    name: 'MeraEvents.com',
    description: '<?php echo stripslashes($eventData['title'])?>',
    currency: '<?php echo $calculationDetails['currencyCode']; ?>',
    amount: <?php echo ($calculationDetails['totalPurchaseAmount']*100); ?>,
  });
  e.preventDefault();
});

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});

</script>





