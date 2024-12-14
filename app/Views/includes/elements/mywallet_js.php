<script>	
	var mywallet = showOtpVerificationModal = false;
	var remainingAmtToWallet = 0;
	<?php
	if(isset($mywallet)){
		?> mywallet = true;  <?php
		if($remainingToPay > 0){ ?>remainingAmtToWallet = '<?php echo $remainingToPay; ?>';<?php }
	}
	?>
	var api_myWalletOtpGeneration='<?php echo commonHelperGetPageUrl('api_myWalletOtpGeneration');?>';
	//var payment_myWalletValidateotp='<?php echo commonHelperGetPageUrl('payment_myWalletValidateotp');?>';
	var payment_myWalletDoTransaction='<?php echo commonHelperGetPageUrl('payment_myWalletDoTransaction');?>';
	var api_myWalletValidateotp = '<?php echo commonHelperGetPageUrl('api_myWalletValidateotp');?>';
	var api_myWalletAddFund = '<?php echo commonHelperGetPageUrl('api_myWalletAddFund');?>';
	
</script>


<!--OTP popup for mywallet-->
<?php if(isset($mywallet)){ include_once(APPPATH.'views/includes/otp_verification.php');  } ?>
<!--OTP popup for mywallet-->