<div class="page-container" ng-controller="signupController">

    <br>

    <!--sign up-->
    <div class="container" id="signUpContainer"  >
<!--    <h2 class="innerTopText">Sign Up</h2>-->
    <h3 class="innerTopText">Sign Up</h3>
    <div class="row loginContainer">
      
         <?php include_once('includes/elements/login_social_share.php');?>
        
        
      <div class="col-sm-6 rightSide">
        <div class="loginBlog">
<!--        <h2 class="login_header_rgt"> Create a new account</h2>-->
<!--        <p ng-if="commonError!=''" class="help-block   ng-cloak validation-error" id="commonErrorId">{{commonError}}</p>
        Display Errors if any
        -->
<div ng-show="commonErrors.length > 0">
  <div ng-repeat="error in commonErrors">
   <p class="help-block   ng-cloak validation-error" id="commonErrorId" ng-cloak>{{error}}</p>
  </div>
</div>
        <form name="signupForm" id="signupForm"  method='post' novalidate ng-submit="submitted = true" >
           <div class="form-group">
               <input type="text" name="testcode" id="testcode"  style="display:none"/>
               <input ng-change="hideErrorMsgs()" type="text" class="form-control userFields" style="text-transform: capitalize;"
                      name="name" id="nameid" placeholder="Full Name" ng-model="signup.name" required ng-pattern ="/^[a-zA-Z\s]*$/">
              <p ng-show=" submitted && signupForm.name.$error.required  " class="help-block   ng-cloak validation-error">Please enter your name</p>
              <p class="help-block  ng-cloak validation-error"  ng-show="signupForm.name.$error.pattern && submitted">Please enter characters only in Full Name</p>
           
            </div>
             <div class="form-group">
                 <input ng-change="hideErrorMsgs()" ng-model="signup.email" ng-required="true" name="email" ng-blur="emailBlur()"
                        ng-pattern="/^([a-zA-Z0-9\+_\-]+)(\.[a-zA-Z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,10}$/" type="email" class="form-control userFields" id="emailid" placeholder="Email address">
                <p class="error" ng-init="emailNameStatus=false" ng-cloak ng-show="emailNameStatus">Email already exists, please wait while you are being redirected to the login page</p>          
                <p class="help-block  ng-cloak validation-error"  ng-show="signupForm.email.$error.required && submitted">Email is required</p>
                <p class="help-block  ng-cloak validation-error"  ng-show="signupForm.email.$error.pattern && submitted">Enter valid email id</p>

        </div>
            
            <div class="form-group"> 
             <!--<pclass="alignRight"><a href="#">Forgot password?</a></p>-->
                <input ng-change="hideErrorMsgs()" type="password" class="form-control userFields" id="passwordid" name="password"  ng-minlength="6" placeholder="Password" ng-model="signup.password" required>
                <p class="help-block   ng-cloak validation-error"  ng-show="signupForm.password.$error.required && submitted">Password is required</p>
                <p class="help-block   ng-cloak validation-error"  ng-show="signupForm.password.$error.minlength && submitted">Please enter minimum 6 characters</p>
            </div>
            
            <div class="form-group">
            <input type="hidden" name="countryId" ng-model = "signup.countryId"  ng-init="signup.countryId =<?php echo $defaultCountryId; ?>" ng-value="<?php echo $defaultCountryId; ?>" />
             <input type="hidden" name="countryphoneCode" ng-model = "signup.countryphoneCode"  ng-init="signup.countryphoneCode = <?php echo $defaultCountryPhoneCode; ?>" ng-value="<?php echo $defaultCountryPhoneCode; ?>" />
              <!--<div style="float: left;
    position: absolute;padding: 11px 10px;"><a href="javascript:void(0);" style="color: #aaa;font-size: 17px;">&nbsp;<?php echo $defaultCountryPhoneCode;?></a></div>-->
             <input ng-change="hideErrorMsgs()" type="text" class="form-control userFields" id="phonenumberid"
                       ng-minlength="1" name="phonenumber" placeholder="Mobile number" 
                       ng-model="signup.phonenumber" ng-pattern="/^([0|\+[0-9+ -]{1,5})?[0-9+ -]+$/" required/> 
                       <!-- <span><?php // echo MESSAGE_COUNTRYCODE_NOTE;?></span> -->
                  <p class="help-block   ng-cloak validation-error"  ng-show="signupForm.phonenumber.$error.required && submitted">Phone number is required</p>
                 <p class="help-block  ng-cloak validation-error" ng-show="signupForm.phonenumber.$error.minlength && submitted">Please enter minimum 10 characters</p>
                 <p class="help-block  ng-cloak validation-error" ng-show="signupForm.phonenumber.$error.maxlength && submitted">You can enter upto 10 characters only</p>
                 <p class="help-block  ng-cloak validation-error" ng-show="signupForm.phonenumber.$error.pattern && submitted">Invalid mobile number</p>
                   </div>
            
            <div class="form-group">
           <label style="font-size:20px;font-weight:bold;margin-top:20px;margin-bottom:15px;">Enter calculation :</label>
            <div class="row">
           <div class="col-md-2 col-sm-2 col-xs-2"><input type="text" name="num1" id="num1id"   value="<?php echo rand(1,9);?>"   class="form-control userFields"" style="width:50px;font-weight:bold;font-size:25px;" disabled/></div>
           <div class="col-md-2 col-sm-2 col-xs-2"><span class="align-middle" style="font-weight:bold;font-size:25px;vertical-align: text-middle;">   +</span></div>
           <div class="col-md-2 col-sm-2 col-xs-2"><input type="text" name="num2"  id="num2id"  value="<?php echo rand(1,9);?>"  class="form-control userFields""  style="width:50px;font-weight:bold;font-size:25px;" disabled/></div>
           <div class="col-md-2 col-sm-2 col-xs-2"><span class="align-middle" style="width:50px;font-weight:bold;font-size:25px;vertical-align: text-middle;">=</span></div>
           <div class="col-md-2 col-sm-2 col-xs-2"><input type="text" style="width:80px;font-size:25px;" class="form-control userFields"" ng-change="hideErrorMsgs()" ng-model="signup.result_num"  name="result_num" id="result_numid" required /></div>
           </div>
           
            <p ng-show=" submitted && signupForm.result_num.$error.required  " class="help-block   ng-cloak validation-error" id="result_error1">Calculation is required</p>
            <p id="result_error2" style="color:red;font-size:15px;display:none">Incorrect calculation!</p>

            </div>
            <div class="form-group">
              <div class="g-recaptcha form-field" data-sitekey="<?php echo $siteKey; ?>"></div>

            </div>       
            <p class="text">By signing up, I agree to MeraEvents<a href="<?php echo commonHelperGetPageUrl('terms'); ?>" target="_blank"> T&C </a> and <a href="<?php echo commonHelperGetPageUrl("privacypolicy") ?>" target="_blank">Privacy Policy</a></p>
           
            <!-- <input type="submit" class="btn btn-default commonBtn login" onclick="showhideactivation()">SIGN UP</button> -->
		
			<button type="button" ng-click=" submitSignup(signup)" class="btn btn-default commonBtn sbtn login" style="line-height: 43px" >SIGN UP</button>
			
              <span><label class="al_reg"> <label >Already registered?</label> <a href="<?php echo commonHelperGetPageUrl('user-login'); ?>" target="_self">Log In</a></label></span>
            </form>
            </div>
          
          
      </div>
    </div>
  </div>
    <!--End od Signup-->

<!--    Successfull Registration-->
<div class="container" id="ActivateContainer" style="display: none;" >
    <h2 class="innerTopText">Thanks For Signing Up!</h2>
    <h3 class="innerTopText"></h3>
   
    <div class="row loginContainer">
      
      <div class="col-sm-12 rightSide">
        <div class="ConfirmBlog">
            <h2 class="login_header_rgt" style="font-size: 18px;" ng-cloak>Check {{registeredEmail}} for next steps. </h2>
          <form>
			   
          </form>
            <span> <label >Did not receive email? Please <a href="<?php echo site_url();?>resendActivationLink?email={{registeredEmail}}" > click here</a> to resend activation mail. </label> </span> 
		  </div>
      </div>
    </div>
  </div>

<!-- End of    Successfull Registration-->
</div>
<!-- /.wrap -->
<script type="text/javascript">
    
 $.fn.intlTelInput.loadUtils("<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>");   
 
$("#phonenumberid").intlTelInput({
     
      // allowDropdown: false,
      //autoHideDialCode: false,
       autoPlaceholder: "off",
      // dropdownContainer: "body",
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      initialCountry: "in",
       //nationalMode: false,
      // onlyCountries: ['in', 'si', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
      // preferredCountries: ['cn', 'jp'],
    //  separateDialCode: false,
    separateDialCode: true
    });    
var api_UsersignupEmailCheck = "<?php echo commonHelperGetPageUrl('api_UsersignupEmailCheck')?>";
var api_Usersignup = "<?php echo commonHelperGetPageUrl('api_Usersignup')?>";
</script>
<script>
$(document).ready(function(){
  
  $("#result_numid").blur(function(){
  
   var num1val= $("#num1id").val();
   var num2val= $("#num2id").val();
   var num_result=$("#result_numid").val();
   var sumnums=parseInt(num1val) + parseInt(num2val);
   
   if(num_result==sumnums){
      $("#result_error1").hide();
       $("#result_error2").hide();
      return true;
      }else if(num_result == ""){
       
       $('#result_numid').focus();
      
       $("#result_error1").show();
       $("#result_error2").hide();
        return false;
     }
     else{
      
      $("#result_numid").focus();
       $("#result_error1").hide();
       $("#result_error2").show();
            return false;
     }
  });
});
</script>
<script type="text/javascript">
    var countryName = "<?php echo ($ipCountry!='') ? $ipCountry : 'India' ?>";
</script>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
<script>
window.onload = function(e){
  if(typeof(countryName)!= 'undefined' && countryName!= '' && countryName != null){
    var intlCountrycode = getCountryCode(countryName);
    if(typeof(intlCountrycode) != 'undefined' && intlCountrycode != '')
      $("#phonenumberid").intlTelInput("setCountry", intlCountrycode);
  }
}

</script>
