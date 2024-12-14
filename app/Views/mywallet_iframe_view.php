<div class="page-container">
    <div class="wrap">
        <div class="container"> 
            <!-- top section -->
            <div id="event_div" class="" style="z-index: 99;">
            <div class="row professional">
                <div class="img_below_cont ">
                    <h1>Wallet Payment</h1>
                    <div class="sub_links"><span class="icon-calender"></span>                       
                            </span></div>
                    <div class="sub_links"> <span class="icon-google_map_icon"></span><span><?php if(isset($eventData['eventMode']) && $eventData['eventMode'] == 1){ echo "Webinar"; } else { echo $eventData['fullAddress']; } ?></span></div>
                </div>
                
            </div>

        </div>
            <!-- top section -->
            
			
            
            
            
            
            <!--Step2-->
                <div class="innerPageContainer" style="margin-bottom: 30px;">
                    <h2 class="pageTitle">Registration Information</h2>
                    <div class="row">
                        <div class="col-md-8">
                        <div class="row">
                        	<div class="col-xs-12 regInfo">
                            <p>Almost there, we are processing your request..</p>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-xs-12 col-md-4"></div>
                    </div>
                </div>
        </div>
    </div>
    <!-- /.wrap --> 
</div>


<script type="text/javascript">

	var customValidationEventIds = null;
	var mywallet = showOtpVerificationModal = false;
	<?php
	if(isset($mywallet) && $mywallet['addedMoneyToWallet']){
		?>
		mywallet = showOtpVerificationModal = true; 
		<?php
	}
	?>
	var api_myWalletOtpGeneration='<?php echo commonHelperGetPageUrl('api_myWalletOtpGeneration');?>';
	//var payment_myWalletValidateotp='<?php echo commonHelperGetPageUrl('payment_myWalletValidateotp');?>';
	var payment_myWalletDoTransaction='<?php echo commonHelperGetPageUrl('payment_myWalletDoTransaction');?>';
	var api_myWalletValidateotp = '<?php echo commonHelperGetPageUrl('api_myWalletValidateotp');?>';
	
</script>


<!--OTP popup for mywallet-->
<?php if(isset($mywallet)){ include_once('includes/otp_verification.php');  } ?>
<!--OTP popup for mywallet-->
