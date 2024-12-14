
<div class="col-sm-3 leftSide">

    <div class="loginBlog" style=" display: none; ">
        <!--        <h2 class="login_header_lef">Register with your social account</h2>-->
        <button onclick="fb2Auth();" type="button" class="btn btn-default btn-md commonBtn Lfb"><span class="icon-login_fb"></span>Login with Facebook</button>
        <!-- <button onclick="return redirectToTwitter();" type="button"  class="btn btn-default btn-md commonBtn Ltwt"><span class="icon-login_tweet"></span>Login with Twitter</button> -->
        <button type="button"  id="login-button" class="btn btn-default btn-md commonBtn Lgoogle"><span class="icon-login_google"></span>Login with Google</button>
    </div>
    <div class="socialIconsMobile">
        <ul>
            <li><a onclick="fb2Auth();" href="javascript:void(0)" class="icon-fb fb"></a></li>
            <li><a onclick="return redirectToTwitter();" href="javascript:void(0)" class="icon-tweet tweet"></a></li>
            <li><div id="gp_loginResponcive"><a href="javascript:void(0)" class="icon-google google"  onclick="javascript:googleAuth()" ></a></div></li> 
        </ul>
    </div>
</div>
<script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};HandleGoogleApiLibrary()" onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>
<script>
                var FB_APP_ID = '<?php echo $this->config->item('fb_app_id'); ?>';
                var TWITTER_APP_KEY = '<?php echo $this->config->item('twitter_app_key'); ?>';
                var GOOGLE_APP_ID = '<?php echo $this->config->item('google_app_id'); ?>';
                var h = parseInt($(window).height())*0.6; 
                var w = parseInt($(window).width())*0.6 ;
                function fb2Auth(){
					var fburl = "<?php echo $fbloginUrl;?>";
					window.open(fburl, "", "width="+w+", height="+h+"top=0,left=0");
					//window. fburl;
					
					/*var FBWindow = window.open(fburl, "", "width="+w+", height="+h+"top=0,left=0");  
					
					if(navigator.appVersion.search("Safari") == '-1')
					{ }
					else
					{
						var timer = setInterval(function() {   
							if(FBWindow.closed) {  
								clearInterval(timer);  
								window.location.reload();  
							}  
						}, 1000);
					}*/
					
                }
                
                // Click on login button
    $("#login-button").on('click', function() {
            $("#login-button").attr('disabled', 'disabled');

            // API call for Google login
            gapi.auth2.getAuthInstance().signIn().then(
                    // On success
                    function(success) {
                        sendData(success.qc.access_token, 'google');
                            // API call to get user information
//                            gapi.client.request({ path: 'https://www.googleapis.com/plus/v1/people/me' }).then(
//                                    // On success
//                                    function(success) {
//                                            console.log(success);
//                                            var user_info = JSON.parse(success.body);
//                                            //console.log(user_info);
//
//                                            $("#user-information div").eq(0).find("span").text(user_info.displayName);
//                                            $("#user-information div").eq(1).find("span").text(user_info.id);
//                                            $("#user-information div").eq(2).find("span").text(user_info.gender);
//                                            $("#user-information div").eq(3).find("span").html('<img src="' + user_info.image.url + '" />');
//                                            $("#user-information div").eq(4).find("span").text(user_info.emails[0].value);
//
//                                            $("#user-information").show();
//                                            $("#login-button").hide();
//                                    },
//                                    // On error
//                                    function(error) {
//                                            $("#login-button").removeAttr('disabled');
//                                            alert('Error : Failed to get user user information');
//                                    }
//                            );
                    },
                    // On error
                    function(error) {
                            $("#login-button").removeAttr('disabled');
                            console.log(error);
                            
                    }
            );
    });
    // Called when Google Javascript API Javascript is loaded
    function HandleGoogleApiLibrary() {
	// Load "client" & "auth2" libraries
	gapi.load('client:auth2', {
		callback: function() {
			// Initialize client library
			// clientId & scope is provided => automatically initializes auth2 library
			gapi.client.init({
		    	apiKey: '<?php echo $this->config->item('google_login_app_key'); ?>',
		    	clientId: '<?php echo $this->config->item('google_app_id'); ?>',
		    	scope: 'https://www.googleapis.com/auth/userinfo.profile'
			}).then(
				// On success
				function(success) {
			  		// After library is successfully loaded then enable the login button
			  		$("#login-button").removeAttr('disabled');
				}, 
				// On error
				function(error) {
					alert('Error : Failed to Load Library');
			  	}
			);
		},
		onerror: function() {
			// Failed to load libraries
		}
	});
    }
				
</script>

