<div class="rightArea">
     <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if($status) { ?>
             class="db-alert db-alert-success flashHide" <?php } else { ?>
             class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong>
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Personal Details</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form enctype="multipart/form-data" name="personalDetails" id="personalDetails" method="post" action="" >
            <!--<label>User Name <span class="mandatory">*</span></label>-->
            <input type="hidden" id="username" name="username" value="<?php echo $personalDetails['username']; ?>" class="textfield">
            <div id="userSuccessMessage"> </div> <div id="userErrorMessage"> </div>
            <label>Email ID <span class="mandatory">*</span></label>
            <input type="text" name="email" value="<?php echo $personalDetails['email']; ?>" readonly class="textfield">
            <label>Name <span class="mandatory">*</span></label>
            <input type="text" name="name" value="<?php echo $personalDetails['name']; ?>" class="textfield">
            <label>Company Name</label>
            <input type="text" name="companyname" value="<?php echo $personalDetails['company'] ?>" class="textfield">
            <label>Address</label>
            <textarea class="textarea" name="address"><?php echo $personalDetails['address']; ?></textarea>
            <label>Location</label>
            <?php $locat=explode(',',$locality); 
          // echo count($locat);  
            ?>
            <input type="text" class="textfield localityAutoComplete" id="locality" name="locality" value="<?php  echo (isset($locality) && $locality != '') ? $locality : ''; ?>">
             <label>Country</label>
             <label>
             <span style="top:10px;" class="float-left icon-downarrow"></span>
             <select name="country_id" id="fields_table_country_id">
                <option>Choose Your Country</option>
                <?php 
                     foreach ($countryList as $key => $value) { 
                       if(($locat[2]==$value['name'] &&  count($locat)==3) || ($locat[0]==$value['name'] && count($locat)==1)) 
                            $seld='selected';
                        else
                            $seld='';
                        ?>
                     <option value="<?php echo $value['id']; ?>"  <?php echo $seld; ?>><?php echo $value['name']; ?></option>
                    <?php } 
                ?>
               
                
             </select>
                     </label>
           <!--  <input type="text" id="countryId" name="countryId" onclick="fun()" value = "<?php  //echo $personalDetails['countryid']; ?>"> -->
             <label>State</label>
             <label>
             <span style="top:10px;" class="float-left icon-downarrow"></span>
             <select name="stateId" id="fields_table_state_id">
             <option>Choose Your State</option>
             <?php if($locat[1]){ ?>
                <option value="<?php echo $personalDetails['stateid']; ?>" selected ><?php echo $locat[1]; ?></option>
                <?php } ?>
            </select>
            </label>
           <!--  <input type="text" id="stateId" name="stateId" value = "<?php  echo $personalDetails['stateid']; ?>"> -->
             <label>City</label>
             <label>
             <span style="top:10px;" class="float-left icon-downarrow"></span>
             <select name="cityId" id="fields_table_city_id">
             <option>Choose Your City</option>
             <?php if(isset($locat[0])  && count($locat)==3){ ?>
                <option value="<?php echo $personalDetails['cityid']; ?>" selected><?php echo $locat[0]; ?></option>
                <?php } ?>
             </select>
             </label>
<!--             <input type="text" id="cityId" name="cityId" value = "<?php  echo $personalDetails['cityid']; ?>">
 -->
            <input type="hidden" id="ismobileverified" name="ismobileverified" value = "<?php  echo $ismobileverified; ?>">
            <input type="hidden" id="redirect" name="redirect" value = "<?php echo ($redirect) ? '1' : '0' ?>">

            <div class="clearBoth"></div>
            <label>Mobile Number (<span style="color:#C60; font-size:12px;">Same number can be used for MeraWallet aswell</span>)
            <span class="mandatory">*</span> </label>
            <input type="text" id="MobileNo" name="mobile" value="<?php echo $personalDetails['mobile']; ?>" class="textfield"> <?php if($mywallet){ /*echo ' readonly ';*/ } ?>
            <span style="margin-bottom:20px;">
            <?php // echo MESSAGE_COUNTRYCODE_NOTE;?>
                <?php //echo $ismobileverified ? '' : 'Please check your mobile and click on update to validate' ?>
            </span>

            <label>Phone Number </label>
            <input type="text" name="phone" value="<?php echo $personalDetails['phone']; ?>" class="textfield">
            <label>Pincode </label>
            <input type="text" name="pincode" value="<?php echo $personalDetails['pincode']; ?>" class="textfield">
            <label>Profile Picture</label>
            (only JPG, JPEG, PNG are allowed and should less than 2MB)
            <input type="file" id="picture" name="picture" value="" class="upload_image textfield"/>
            <?php if ($personalDetails['profileimagefilepath'] != "") { ?>
                <br/>
                <img src="
            <?php echo $personalDetails['profileimagefilepath']; ?>" style="width: 200px;height: 200px;"/>
                <br/>
            <?php } ?>
            <?php
            $isOrganizer = $this->customsession->getData('isOrganizer');
            ?>
            <input type="hidden" name="isOrganizer" id="isOrganizer" value="<?php ($isOrganizer == 1) ? '1' :  '0' ?>">
            <?php
            if ($isOrganizer == 1) {
                $designation  = $orgnizerDetails['designation'];
                $facebooklink = $orgnizerDetails['facebooklink'];
                $twitterlink  = $orgnizerDetails['twitterlink'];
                $linkedinlink = $orgnizerDetails['linkedinlink'];
            } else {
                $designation  = $personalDetails['designation'];
                $facebooklink = $personalDetails['facebooklink'];
                $twitterlink  = $personalDetails['twitterlink'];
                $linkedinlink = $personalDetails['linkedinlink'];
            }
            ?>
            <label>Designation</label>
            <input type="text" name="designation" value="<?php echo $designation; ?>"
                   class="textfield">
            <label>Facebook </label>
            <input type="text" value="<?php echo $facebooklink; ?>" name="facebooklink"
                   class="textfield">
            <label>Twitter </label>
            <input type="text" value="<?php echo $twitterlink; ?>" name="twitterlink"
                   class="textfield">
            <?php /*<label>Google Plus </label>
            <input type="text" value="<?php echo $googlepluslink; ?>" name="googlepluslink" class="textfield"> */ ?>
            <label>Linked In </label>
            <input type="text" value="<?php echo $linkedinlink; ?>" name="linkedinlink"
                   class="textfield">
            <div class="clearBoth"></div>

            <div class="clearBoth"></div>
<!--            <img src="<?php //echo $personalDetails['profileimagefilepath']; ?>" alt="<?php //echo $personalDetails['profileimagefilepath']; ?>" id="picShow" width="120" height="120" />
            <input type="file" id="picture" name="picture"/>-->
            <input type="submit"  name="personalDetailsForm" class="submitBtn createBtn float-right" value="UPDATE"/>
        </form>
    </div>
</div>
</div>

<div class="modal fade signup_popup" id="mobileOtpModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mobileOtpModal" aria-hidden="true" style="display: none; border: 0 none !important;height: auto;outline: medium none !important;overflow: hidden;">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
        <div class="popup-closeholder pull-right"><button class="popup-close" data-dismiss="modal">X</button></div>
            <div class="awesome_container">
                <h3 style="margin-top: 30px; text-align: center; margin-bottom: 20px;">Please validate your mobile</h3>
                <p style="text-align: center; margin-top: 5px; margin-bottom: 5px; color: green; display:none;" id="successMessage" class="success" ></p>

                <p style="text-align: center; margin-top: 5px; margin-bottom: 5px; color#F00;display:none;" id="errormessages" class="error"></p>

                <form class="otpMobileConfirm form2" method="post" action="#" name="otpMobileConfirm" id="otpMobileConfirm">
                    <?php if($mywallet){ ?>
                    <p style="text-align: center; margin-top: 5px;margin-left: 20px; margin-bottom: 2px; color#999; font-size:16px;"> <b id="otp_mob_no">Your wallet will not be transfer to new mobile number <br>(Are you sure to proceed)</b></p>
                    <?php }?>
                    <div style="width: 320px;margin: 0 auto;margin-top: 10px;margin-bottom: 10px;text-align: center;">
                        <input type="text" id="otp_mobile" name="otp_mobile" autocomplete="off" value="<?php echo $personalDetails['mobile']; ?>" class="textfield" placeholder="Please Enter Mobile No."
                                    <?php echo ($personalDetails['mobile']!='') ? 'readonly' : '' ?>>
                    </div>

                    <div>
                        <p style="text-align: center; margin-top: 5px; color: green; margin-bottom: 20px;"><a href="#" style="color:#066; font-weight:bold;" id="changeMobile" ><?php echo ($personalDetails['mobile']!='') ? 'Change Mobile No.' : '' ?></a></p>
                    </div>

                    <div class="ProfileSubmitBtn">
                        <button type="submit" id="mobileConfirm" class="btn commonBtn login paynowbtn" >Send OTP</button>
                    </div>
                 </form>

                <form class="otpVerify form1" method="post" action="#" name="mobileOtpVerificationForm" id="mobileOtpVerificationForm" style="display: none">
                    <p style="text-align: center; margin-top: 5px;margin-left: 20px; margin-bottom: 2px; color#999; font-size:11px;">OTP sent to <b id="otp_mob_no"></b></p>

                    <div style="width: 320px;margin: 0 auto;margin-top: 10px;margin-bottom: 10px;text-align: center; ">
                        <input type="password" name="otp" id="otp" autocomplete="off" style="width: 100%;margin: 0 auto; padding: 15px 10px;border: 1px solid #ddd;border-radius: 5px;" placeholder="Please Enter OTP">
                    </div>

                    <div>
                        <p style="text-align: center; margin-top: 5px; color: green; margin-bottom: 20px;"><a href="javascript:;" style="color:#066; font-weight:bold;" id="resendOtp" >Resend OTP</a></p>
                    </div>

                    <div class="ProfileSubmitBtn">
                        <button type="submit" id="otpSubmitButt" class="btn commonBtn login paynowbtn ">VERIFY</button>

                       <p style="text-align: center; margin-top: 5px; color: green; margin-bottom: 20px;"><a href="#" style="color:#066; font-weight:bold;"  ></a></p>

                    </div>

                    <input type="hidden" name="otp_sent" id="otp_sent" value="0">
                    <input type="hidden" name="otpValidated" id="otpValidated" value="0">
                 </form>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'bootstrap'.$this->config->item('js_gz_extension'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('cfPath'); ?>css/public/<?php echo 'bootstrap'.$this->config->item('css_gz_extension'); ?>">
<script>
var loadUtilsUrl = '<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>';
    $.fn.intlTelInput.loadUtils(loadUtilsUrl);
    $("#MobileNo").intlTelInput({
            autoPlaceholder: "off",
            separateDialCode: true
    });
    $("#otp_mobile").intlTelInput({
            autoPlaceholder: "off",
            separateDialCode: true
    });
//var api_cityCitysByState = "<?php echo commonHelperGetPageUrl('api_cityCitysByState');?>";
var api_UsermobileverifyOTP = "<?php echo commonHelperGetPageUrl('api_UsermobileverifyOTP');?>";
var api_UserOTPGen = "<?php echo commonHelperGetPageUrl('api_UserOTPGen');?>";
var api_checkUserNameExist = "<?php echo commonHelperGetPageUrl('api_checkUserNameExist');?>";
var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch')?>";
var api_stateSearch = "<?php echo commonHelperGetPageUrl('api_stateSearch')?>";
var api_citySearch = "<?php echo commonHelperGetPageUrl('api_citySearch')?>";
var oldMobileNo = "<?php echo $personalDetails['mobile']; ?>";
</script>
<script>
   // var baseurl = "<?php echo base_url(); ?>";
    $("#fields_table_country_id").on("change", function () { 
       
	 var country_id=$(this).val();
	$.ajax({
		type: "POST",
        //url:"{{url('/profile/stateslist/')}}/"+country_id,
		url: '<?php echo site_url("profile/index/stateslist"); ?>',	
		data:'countryId='+country_id,
		beforeSend: function() {
			//$("#state-list").addClass("loader");
		},
		success: function(data){
			$("#fields_table_state_id").html(data);
			$('#city-list').find('option[value]').remove();
			$("#state-list").removeClass("loader");
		}
	});  
}); 
$("#fields_table_state_id").on("change", function () { 
	var val=$(this).val();
	$.ajax({
		type: "POST",
        url: '<?php echo site_url("profile/index/citylist"); ?>',			
		data:'state_id='+val,
		beforeSend: function() {
			//$("#state-list").addClass("loader");
		},
		success: function(data){
			$("#fields_table_city_id").html(data);
			$('#city-list').find('option[value]').remove();
			$("#state-list").removeClass("loader");
		}
	}); 
});

      

        if($('#ismobileverified').val() == 0 && $('#otp_sent').val() == 0 && $('#otpValidated').val() == 0 && $('#isOrganizer').val() == 0 && $('#redirect').val() ==1){
            $('#mobileOtpModal').modal('show');
        }
        else if($('#ismobileverified').val() == 0 && $('#otpValidated').val() == 0 && $('#isOrganizer').val() == 0 && $('#redirect').val() ==1){
            $('#mobileOtpModal').modal('show');
        }
        else if(oldMobileNo != $("#MobileNo").intlTelInput("getNumber") && $('#otpValidated').val() == 0 && $('#isOrganizer').val() == 0 && $('#redirect').val() ==1){
            $('#otp_mobile').val($('#MobileNo').val());
            $('#mobileOtpModal').modal('show');
        }
           
       </script>
