

    <!--Succes / Error Messages-->
    <?php if(isset($message)){ ?>
        <div id="personalDetailsMessage" <?php if($status){ ?> class="db-alert db-alert-success flashHide" <?php } else { ?> class="db-alert db-alert-danger flashHide" <?php } ?> ><strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php }
	$sessionMessage = $this->customsession->getData('addedMoneyToWalletStatus');
    $this->customsession->unSetData('addedMoneyToWalletStatus');
    if(!empty($sessionMessage)) {
		?><div id="personalDetailsMessage" <?php if($sessionMessage['status']){ ?> class="db-alert db-alert-success flashHide" <?php } else { ?> class="db-alert db-alert-danger flashHide" <?php } ?> ><strong>&nbsp;&nbsp;  <?php echo $sessionMessage['message']; ?></strong> 
        </div><?php 
	} ?>
    <!--Succes / Error Messages-->
    
    <div id="errorMessage" class="db-alert db-alert-danger flashHide" style="display:none">Oops..! Something went wrong, Please try again.</div>
    <div id="successMessage" class="db-alert db-alert-success flashHide" style="display:none"></div>
    
    
    <?php
	
	//print_r($APIresponse);
	
	if($userwalletstatus == 'otppending'){
	?>

    <div class="heading">
        <h2>Activate Your Wallet</h2>
    </div>
    <div class="graphSec"> 
     <div class="fs-form fs-form-widget-setting">
        <div class="colsm8" style="width:90%;float:left;">
            <div class="WalletBox">
                  <h3>Enter the OTP</h3>
                   <form name="otpVerificationForm" id="otpVerificationForm" method="post" class="ticketTransferFlags">
                        <input type="text" name="otp" id="otp" autocomplete="off">
                        <input type="hidden" name="walletFormType" value="validateOTP" />
                        <input type="submit" name="addbalance" id="" value="Validate OTP">
                     </form>
                 <div id="errOTP" style=" float: left;width: 100%; margin-top: -10px;"></div>
            </div>
            
            <div class="WalletBox"><div style=" width: 100%;  padding:30px 30px 0 0;"><a href="javascript:void(0)" style="color:#066; font-weight:bold;" id="resendOtp">Resend OTP</a></div></div>
       </div>
    </div>
    </div>
    
    <?php
	}
	elseif($userwalletstatus == 'userblocked'){
	?>

    <div class="heading">
        <h2>Create Wallet</h2>
    </div>
    <div class="editFields fs-bank-details">
        <form id="" name="" method="post" action="" class="ticketTransferFlags">
            
        <label>Full Name <span class="mandatory">*</span></label>
        <input type="text" class="textfield" name="Name" id="Name" value="<?php echo $Name; ?>">
        
        <label>Email Id <span class="mandatory">*</span></label>
        <input type="text" class="textfield" name="EmailId" id="EmailId" value="<?php echo $EmailId; ?>" disabled="disabled">
        
        <label>Mobile No <span class="mandatory">*</span></label>
        <input type="text" class="textfield" name="MobileNo" id="MobileNo" value="<?php echo $MobileNo; ?>">
        
        <input type="hidden" name="walletFormType" value="CreateWallet" />

        <input type="submit" name="CreateWallet" value="CREATE WALLET"class="submitBtn fs-btn float-right"/>

        </form>
    </div>
    
    <?php
	}
	elseif($userwalletstatus == 'validuser'){
	?>

    <div class="heading"> <h2>MeraWallet</h2> </div>
    <div class="graphSec"> 
     <div class="fs-form fs-form-widget-setting">
                     
                <div class="colsm6" style="width:33%; float:left;">
                    <div class="WalletBox">
                        <h3>Your wallet balance</h3>
                        <p>INR <?php echo $availableBalance; ?></p>
                    </div>
                </div>
 
                <div class="colsm8" style="width:60%;float:left;">
                    <div class="WalletBox">
                        <h3>Add money to your wallet</h3>
                        <form class="ticketTransferFlags" name="addMoneyForm" id="addMoneyForm" method="post" action="<?php echo site_url('mywallet/addmoney');?>">
                            <input type="text" name="amount" id="amount">
                            <input type="hidden" name="response_url" id="response_url" value="<?php echo $response_url; ?>">
                            <input type="hidden" name="page" id="page" value="dashboard">
                            <input type="submit" name="addbalance" id="" value="Add Money">
                        </form>
                        <div id="errAmount" style=" float: left;width: 100%;"></div>
                    </div>
                </div>

            </div>

            </div>
    
    <?php
	}
	elseif($userwalletstatus == 'createwallet'){
	?>

    <div class="heading">
        <h2>Create Wallet</h2>
    </div>
    <div class="editFields fs-bank-details">
        <form id="createWalletForm" name="createWalletForm" method="post" action="" class="ticketTransferFlags">
            
        <label>Full Name <span class="mandatory">*</span></label>
        <input type="text" class="textfield" name="Name" id="Name" value="<?php echo $Name; ?>">
        
        <label>Email Id <span class="mandatory">*</span></label>
        <input type="text" class="textfield cursordisable" name="EmailId" id="EmailId" value="<?php echo $EmailId; ?>" disabled="disabled">
        
        <label>Mobile No <span class="mandatory">*</span> <span style="color:#C60; font-size:12px;"> Enter 10 digit Indian mobile number.</span></label>
       <div style="float: left; position: absolute;padding: 10px 10px;"></div>
    <input type="text" class="textfield" name="MobileNo" id="MobileNo" value="<?php echo $MobileNo; ?>" style=" padding-left: 50px;">
        
        <input type="hidden" name="walletFormType" value="CreateWallet" />

        <input type="submit" name="CreateWallet" value="CREATE WALLET"class="submitBtn fs-btn float-right"/>
        
        <p style="color:#C60; font-size:12px;">Note: If you update the Name & Mobile number here, will be updated same on your account profile
            </p>

        </form>
    </div>
    
    <?php
	}
	?>


<script type="text/javascript" language="javascript">
    $.fn.intlTelInput.loadUtils("<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>");
    $("#MobileNo").intlTelInput({
        autoPlaceholder: "off",
        initialCountry: "in",
        onlyCountries: ['in'],
        nationalMode: true,
        separateDialCode: true
    }); 
var api_myWalletOtpGeneration  = '<?php echo commonHelperGetPageUrl('api_myWalletOtpGeneration');?>';
var api_myWalletAddFund  = '<?php echo commonHelperGetPageUrl('api_myWalletAddFund');?>';
var myWalletMinTrAmount  = '<?php echo $this->config->item('myWalletMinTrAmount');?>';
var myWalletMaxTrAmount  = '<?php echo $this->config->item('myWalletMaxTrAmount');?>';
</script>