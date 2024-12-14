<button id="rzp-button1" style="display:none">Pay with Razorpay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
// Checkout details as a json


/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */

// Boolean whether to show image inside a white frame. (default: true)


	
function processRazorpayTransaction(response,returnUrl) {
	var form = document.createElement("form");
	document.body.appendChild(form);
	form.method = "POST";
	form.action = returnUrl;
	var element1 = document.createElement("INPUT");         
	element1.name="rpayid"
	element1.value = response.razorpay_payment_id;
	element1.type = 'hidden'
	form.appendChild(element1);
	var element2 = document.createElement("INPUT");         
	element2.name="rsignature"
	element2.value = response.razorpay_signature;
	element2.type = 'hidden'
	form.appendChild(element2);
	var element3 = document.createElement("INPUT");         
	element3.name="roredrid"
	element3.value = response.razorpay_order_id;
	element3.type = 'hidden'
	form.appendChild(element3);
	form.submit();
}
			
</script>