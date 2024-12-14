<script type="text/javascript" src="<?= PAYTM_JS_PATH; ?>"></script>
<!--Important Code for Tab view relate-->


<div class="page-container">
    <div class="wrap">
        <div class="container">

            <!--Order No and Total Amount Div-->
            <div class="row PayExpressPageTop">
                <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12">
                    <div class="PayExpressOrderNo col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <p>Order No : <b><?php echo $eventSignupId; ?></b></p>
                    </div>
                    <div class="PayExpressOrderTotal col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                        <p>Total Amount : <b><?php echo $currencyCode . " " . $txtTxnAmount; ?></b></p>
                    </div>
                </div>
            </div>
            <!--Order No and Total Amount Div-->


            <!--Use paytm Wallet Div-->
            <div class="row" id="usePaytmWalletDiv" style="display:none;">
                <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12">
                    <form action="" name="payfromwalletForm" id="payfromwalletForm">
                        <div class="PayWithWallet">
                            <div class="PaywithWalletCheck">						 
                                <label>
                                    <input type="checkbox" name="payfromwalletCB" id="payfromwalletCB" checked="checked"> Use Paytm Wallet
                                </label>						 
                            </div>
                            <div id="walletbalanceShowHideDiv">
                                <div class="WalletTextContainer col-lg-3">
                                    <span>Payment to be made</span>
                                    <p><?php echo $txtTxnAmount; ?></p>
                                </div>
                                <div class="WalletSeperator">
                                    <p>–</p>
                                </div>
                                <div class="WalletTextContainer col-lg-3">
                                    <span>Money in your Paytm Wallet</span>
                                    <p id="paytmBalancePTag">INR 0</p>
                                    <!--<span class="pay-greenmsg">Balance : 0</span>-->
                                </div>
                                <div class="WalletSeperator">
                                    <p>=</p>
                                </div>
                                <div class="WalletTextContainer col-lg-3">
                                    <span>Select an option to pay balance</span>
                                    <p id="remainingAmountToPay">INR 0</p>
                                </div>
                                <div class="payfromwalletContainer" id="payfromwalletContainer" style="display:none;">
                                    <input class="PayExpressPaynow" type="submit" name="payfromwallet" id="payfromwallet" value="Pay Now"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--Use paytm Wallet Div-->


            <div class="row" id="paytmCardsSection">
                <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 PayExpressContainer"> -->
                <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 Padd360-0">
                    <div class="PayExpressContainer">

                        <!--Left Tab menus Div-->
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 PayExpressMenu">
                            <div class="list-group">
                                <a href="#" value="sc" id="SavedCardsAnchor" class="list-group-item paymentmodes" style="display:none;">Saved Cards</a>
                                <a href="#" value="cc" id="CreditCardsAnchor" class="list-group-item paymentmodes active">Credit / Debit Card</a>
                                <!--<a href="#" value="dc" id="DebitCardsAnchor" class="list-group-item paymentmodes">Debit Card</a>-->
                                <a href="#" value="nb" id="NetBankingAnchor" class="list-group-item paymentmodes">Net Banking</a>
                                <a href="#" value="paytmwallet" id="PaytmWalletAnchor" class="list-group-item paymentmodes">Paytm Wallet</a>
                            </div>
                        </div>
                        <!--Left Tab menus Div-->

                        <!--Right Tab Section Div Start-->
                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 PayExpressTab">

                            <!-- Saved Tab section -->
                            <div class="PayExpressTabContent" id="SavedCardsDiv">
                                <div class="PayExpressOptionHolder">
                                    <p id="savedCardTextPTag"><b>Your Saved Credit/Debit Cards</b></p>
                                    <form name="payWithSavedCardsForm" id="payWithSavedCardsForm">
                                        <!--Loop Div-->
                                        <!--<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 Padd0">
                                           <div class="PayExpressSavedCards">
                                              <input type='radio' name='walletCard' id='walletCard' value="">
                                              <span>4514-xxxx-xxxx-xxxx  - VISA</span>
                                              <input type="password" name="" class="SavedCVV" placeholder="CVV">
                                           </div>
                                        </div>-->
                                        <!--Loop Div-->
                                        <div class="form-group">
                                            <input type="submit"  name="payWithSavedCards" id="payWithSavedCards" class="col-lg-4 col-md-6 col-sm-6 col-xs-12 PayExpressPaynow" value="Make Payment">
                                            <p style="float:left; width:100%;"><a href="<?php echo site_url('payment?orderid=' . $postVar['orderId']).$backbuttonurl; ?>" class="PayExpressBackBtn">Go Back</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--End Of Saved Card Tab Section-->


                            <!-- Credit Tab section -->
                            <div class="PayExpressTabContent active" id="CreditCardsDiv">
                                <div class="PayExpressOptionHolder">
                                    <p class="PayExpressIcons"> 
                                        <img src="<?php echo $this->config->item('images_static_path') ?>PayExpress-Icons.png">
                                    </p>
                                </div>
                                <div class="PayExpressOptionHolder">
                                    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 Padd0">
                                        <form name="ccordc" id="ccordc" action="" method="post">
                                            <!--<div class="form-group">
                                               <label>Name On Card</label>
                                               <input type="text" name="name" id="nameoncard"/>
                                            </div>-->
                                            <div class="form-group">
                                                <label>Card Number</label>
                                                <input type="text" name="name" id="cardnumber"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Expiry Date</label>
                                                <select class="cardno" name="card_expiry_month" id="card_expiry_month">
                                                    <option value="" selected="selected">Month</option>
                                                    <option value="01">01 (Jan)</option>
                                                    <option value="02">02 (Feb)</option>
                                                    <option value="03">03 (Mar)</option>
                                                    <option value="04">04 (Apr)</option>
                                                    <option value="05">05 (May)</option>
                                                    <option value="06">06 (Jun)</option>
                                                    <option value="07">07 (Jul)</option>
                                                    <option value="08">08 (Aug)</option>
                                                    <option value="09">09 (Sep)</option>
                                                    <option value="10">10 (Oct)</option>
                                                    <option value="11">11 (Nov)</option>
                                                    <option value="12">12 (Dec)</option>
                                                </select>
                                                <?php
                                                $startYear = date('Y');
                                                ?>
                                                <select class="cardno" name="card_expiry_year" id="card_expiry_year">
                                                    <option value="">Year</option>
                                                    <?php
                                                    for ($i = 0; $i < 50; $i++) {
                                                        $year = $startYear++;
                                                        ?>
                                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>CVV</label>
                                                <input type="password" name="cvv" id="cvv" class="cardno" />
                                            </div>
                                            <div class="form-group">									
                                                <label><input type="checkbox" name="saveCard" id="saveCard" checked="checked"/> Save Card</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit"  name="submitccordc" id="submitccordc" class="col-lg-4 col-md-6 col-sm-6 col-xs-12 PayExpressPaynow" value="Make Payment">
                                                <p style="float:left; width:100%;"><a href="<?php echo site_url('payment?orderid=' . $postVar['orderId']).$backbuttonurl; ?>" class="PayExpressBackBtn">Go Back</a></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--End Of Credit Card  Tab Section-->




                            <!-- NetBanking  Tab Section -->
                            <div class="PayExpressTabContent" id="NetBankingDiv">
                                <div class="PayExpressOptionHolder">
                                    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 Padd0">
                                        <p><b>Select Bank</b></p>
                                        <form name="nbForm" id="nbForm" action="">
                                            <div class="form-group">

                                                <select id="nbSelected" name="nbSelected">
                                                    <option value="">Select bank</option>
                                                    <?php foreach ($netbankingList as $nbData) { ?>
                                                        <option value="<?php echo $nbData['bankcode']; ?>"><?php echo $nbData['bankname']; ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <p>Note:"If you are an ING Vysya now Kotak customer, please select Kotak Mahindra Bank from the list of banks and complete the transaction"</p>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" name="" class="col-lg-4 col-md-6 col-sm-6 col-xs-12 PayExpressPaynow" value="Make Payment">
                                                <p style="float:left; width:100%;"><a href="<?php echo site_url('payment?orderid=' . $postVar['orderId']).$backbuttonurl; ?>" class="PayExpressBackBtn">Go Back</a></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--End Of Netbanking Tab Section--> 


                            <!-- Paytm Wallet Tab Section -->
                            <div class="PayExpressTabContent" id="PaytmWalletDiv">
                                <div class="PayExpressOptionHolder">
                                    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 Padd0">

                                        <!--Request OTP Div-->
                                        <form name="RequestOTPForm" id="RequestOTPForm" action="">
                                            <div class="RequestOTP">
                                                <p><b>Enter Mobile Number to Login into your Paytm Account</b></p>
                                                <div class="form-group">
                                                    <input type="text" name="walletMobile" placeholder="Enter mobile" id="walletMobile" class="input50" value=""/>							
                                                    <p><?php echo MESSAGE_ENTER_10_DIGITS; ?></p>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" value="Request OTP" name="submitwalletmobile" id="submitwalletmobile" class="col-lg-4 col-md-6 col-sm-6 col-xs-12 PayExpressPaynow" /> 
                                                    <p style="float:left; width:100%;"><a href="<?php echo site_url('payment?orderid=' . $postVar['orderId']).$backbuttonurl; ?>" class="PayExpressBackBtn">Go Back</a></p>
                                                </div>
                                                <span id="otpMsg" class="error"></span>
                                            </div>
                                        </form>
                                        <!--Request OTP Div-->

                                        <!--Submit OTP Div-->
                                        <form name="otpForm" id="otpForm" style="display:none;">
                                            <div id="otpDiv" class="form-group" >
                                                <p><b>Enter OTP below</b></p>
                                                <input type="password" name="otp" placeholder="Enter OTP" id="otp" class="input50" value=""/><br/>
                                                <input type="hidden" name="otpState" placeholder="Enter OTP" id="otpState" value=""/>
                                                <input type="hidden" name="SSO_TOKEN" id="SSO_TOKEN" value=""/>
                                                <input type="hidden" name="PAYTM_TOKEN" id="PAYTM_TOKEN" value=""/>
                                                <input type="submit" value="Submit" name="submitotp" id="submitotp" class="col-lg-4 col-md-6 col-sm-6 col-xs-12 PayExpressPaynow" />
                                                <p style="float:left; width:100%;"><a id="retryOTP" href="#" class="PayExpressBackBtn">Retry</a></p>
                                            </div>
                                            <span id="otpValidationMsg" class="error"></span>
                                        </form>
                                        <!--Submit OTP Div-->

                                    </div>
                                </div>
                            </div>
                            <!--End Of Paytm Wallet Tab Section-->

                        </div>
                        <!--Right Tab Section Div End-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.page-container --> 
<!-- on scroll -->

<?php //$this->load->view("includes/elements/home_scroll_filter.php"); ?>
<?php
$actionUrl = site_url('payment/paytmPrepare');
?>
<form name="paytm_frm" id="paytm_frm" action="<?php echo $actionUrl; ?>" method='POST'>
    <input type="hidden" name="eventTitle" value="<?php echo $postVar['eventTitle']; ?>" />
    <input type="hidden" name="orderId" value="<?php echo $postVar['orderId']; ?>" />
    <input type="hidden" name="paymentGatewayKey" value="<?php echo $postVar['paymentGatewayKey']; ?>" />
    <input type="hidden" name="samepage" value="<?php echo $postVar['samepage']; ?>" />
    <input type="hidden" name="nobrand" value="<?php echo $postVar['nobrand']; ?>" />
    <input type="hidden" name="themefields" value="<?php echo $postVar['themefields']; ?>" />
    <input type="hidden" name="primaryAddress" class="primaryAddress" id="primaryAddress" value="<?php echo $postVar['primaryAddress']; ?>">
</form>
<!--   </div>
</div> -->
<script>
    var userId = '<?php echo getUserId(); ?>';
    var MID = '<?php echo PAYTM_MERCHANT_MID; ?>';
    var api_generateOTP = '<?php echo site_url('api/paytm/generateOTP'); ?>';
    var api_validateOTP = '<?php echo site_url('api/paytm/validateOTP'); ?>';
    var api_getSavedCards = '<?php echo site_url('api/paytm/getSavedCards'); ?>';
    var api_getBalance = '<?php echo site_url('api/paytm/getBalance'); ?>';
    var txnAmt =<?php echo $txtTxnAmount; ?>;
	var paymentGatewayKey=<?php echo $paymentGatewayKey; ?>;
	var isGuestLogin=<?php echo $this->customsession->getData('isGuestLogin'); ?>;
</script>