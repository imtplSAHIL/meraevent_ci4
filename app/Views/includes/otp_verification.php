<div class="modal fade signup_popup" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; border: 0 none !important;height: auto;outline: medium none !important;overflow: hidden;">
	<div class="modal-dialog modal-dialog-center">
		<div class="modal-content">
        <!--<div class="popup-closeholder"><button class="popup-close" data-dismiss="modal">X</button></div>-->
			<div class="awesome_container">
				<h3 style="margin-top: 30px; text-align: center; margin-bottom: 20px;">Enter OTP Number</h3>
                <p style="text-align: center; margin-top: 5px; margin-bottom: 5px; color: green; display:none;" id="successMessage" class="success" ></p>
				<p style="text-align: center; margin-top: 5px;margin-left: 20px; margin-bottom: 2px; color#999; font-size:11px;">OTP sent to <b>XXXXXX<?php echo substr($mywallet['mobileno'],-4); ?></b></p>
                <p style="text-align: center; margin-top: 5px; margin-bottom: 5px; color#F00;display:none;" id="errormessages" class="error"></p>
                <form class="invitefriend_form form1" method="post" action="#" name="otpVerificationForm" id="otpVerificationForm">
                    <input type="hidden" value="<?php echo $eventData['id'];?>" name="EventId" id="EventId"/>
                    <input type="hidden" value="<?php echo $orderLogId; ?>" name="orderid" id="orderid"/>
                    <input type="hidden" value="<?php echo $eventData['eventUrl'];?>" name="EventUrl" id="EventUrl"/>
                
                	<div style="width: 320px;margin: 0 auto;margin-top: 10px;margin-bottom: 10px;text-align: center;">
                    	<input type="text" name="otp" id="otp" autocomplete="off" style="width: 100%;margin: 0 auto; padding: 15px 10px;border: 1px solid #ddd;border-radius: 5px;">
                    </div>
                    <div style="width: 90%;margin: 0 auto;">
                        <button type="submit" id="otpSubmitButt" class="btn commonBtn login paynowbtn" style="padding: 10px 20px;margin-bottom: 10px;width: 100%;border: 0;">VERIFY</button>
                       
                       <p style="text-align: center; margin-top: 5px; color: green; margin-bottom: 20px;"><a href="#" style="color:#066; font-weight:bold;" id="resendOtp">Resend OTP</a></p>
                        
                    </div>
                    
                    
                 </form>
                
                
                
			</div>
		</div>
	</div>
</div>








