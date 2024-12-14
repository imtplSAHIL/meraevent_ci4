<!--Main Container-->
<div class="page-container" id="corporate-vue">
    <div class="wrap CorporatePage">

        <div class="Corporate_Intro CorporatePage-PurpleBg">
            <div class="container">                
                <div class="row">
                    <div class="col-lg-6 col-sm-6 Corporatetitle padding">
                    <h1 class="mainfont fw-elight whitefont">MeraEvents for Corporate Users</h1>
                    <a href="javascript:void(0);" class="Corporate-Btn Intro_PrimaryBtn margin-twenty-tb corporatecreateaccount">REGISTER</a>
                    </div><!-- col-md-6 Corporatetitle padding -->
                    <div class="col-lg-6 col-sm-6 Corporate_Intro_Image text-right">
                        <img src="<?php echo $this->config->item('images_static_path'); ?>corporate-headerslider.png" alt="MeraEvents for Corporate Users">
                    </div>
                </div>
            </div><!-- //container -->
        </div> <!-- //Corporate_Intro CorporatePage-PurpleBg -->

        <div class="Corporate-StepsToDo CorporatePage-WhiteBg padding-fourty">
            <div class="container">
                <h3 class="mainfont blackfont fw-light text-center">What should i do</h3>
                <img src="<?php echo $this->config->item('images_static_path'); ?>whatshouldido.png" class="whatshouldido-web" alt="What Should I Do - Corporate Users">
                <img src="<?php echo $this->config->item('images_static_path'); ?>whatshouldido-vertical.png" class="whatshouldido-mobile" alt="What Should I Do - Corporate Users">
            </div>
        </div><!-- Corporate-StepsToDo -->

        <div class="Corporate-DomainContainer CorporatePage-YellowBg padding-fifty">
            <div class="container Corporatetitle">
                 <h3 class="mainfont fw-normal text-center">Check your company website domain</h3>         
                    <form id="domainCheck" v-on:submit="checkDomain($event)">
                        <div class="Corporate-DomainHolder">                             
                            <input type="text" placeholder="Enter your domain name" name="domain" v-model="check.domain" class="mainfont">
                            <button class="Corporate-DomainSubmit mainfont whitefont">SUBMIT</button>
                        </div>
                        <domain-check-result v-if="check.result" v-bind:message="check.message" v-bind:status="check.status"></domain-check-result>
                    </form>
            </div>            
        </div><!-- Corporate-DomainSec CorporatePage-YellowBg -->

        <div class="Corporate-RegistrationForm CorporatePage-GreyBg padding-fourty" >
            <div class="container">
                <div class="row row-table">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 Corporate-RegForm-Title">
                    <h1 class="blackfont mainfont fw-light">MeraEvents for Corporate Users offers a unique for corporate users.</h1>
                    <p>Register today with your work email and get a complimentary corporate user discount on every purchase of a ticket. Not only will you avail this discount for your purchase but also help friends in your company.</p>                    
                </div><!-- col-lg-6 col-md-6 col-sm-6 col-xs-12 -->

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 Corporate-RegForm">
                    <!-- contact form 1 -->
                    <div class="Corporate-RegForm-GreyBg">
                        <h3 class="mainfont blackfont">Registration Form</h3>
                        <div class="Corporate-RegForm-WhiteBg">
                            <form>
                                <div class="row">

                                    <div class="form-group col-md-6 col-sm-12">
                                        <input type="text" class="form-control" placeholder="Full Name">
                                        <!-- <p class="mainfont error-message-text text-left fw-bold">Fill the Details</p> -->
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <input type="email" class="form-control" placeholder="Company Email Id">         
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <input type="text" class="form-control" placeholder="Mobile No">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <input type="text" class="form-control" placeholder="Company Name">
                                    </div>                                    
                                    <div class="form-group col-md-12 col-sm-12 clearboth">
                                        <input type="text" class="form-control cityAutoComplete" placeholder="City">
                                    </div>
                                    <div class="form-group col-sm-12 inline-block">
                                        <button type="submit" class="Corporate-RegForm-Submit">REGISTER</button>
                                    </div> 
                                    
                                    <div class="CorporatePage-SubmitInfo">
                                        By signing up, I agree to MeraEvents <a href="<?php echo commonHelperGetPageUrl("terms"); ?>" target="_blank">T&C</a> and <a href="<?php echo commonHelperGetPageUrl("terms"); ?>" target="_blank">Privacy Policy</a>
                                    </div> 

                                    <div class="clearfix"></div> 
                                    
                                </div> 
                            </form>
                        </div>
                    </div>
                </div><!-- //Corporate-RegForm --> 
                </div>

            </div><!-- container -->            
        </div><!-- Corporate-RegistrationForm -->

         <div class=" Corporate-HowthisWork triangle"><!-- CorporatePage-LightPurpleBg inlineblock -->
           <!--  <div class="comments-bg"></div> -->          

                <div class="container">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 HowDoesThisWork-Image text-center padding-zero">
                        <div class="whitebg-left min-height-ff">
                       <img src="<?php echo $this->config->item('images_static_path'); ?>howdoesthiswork.png" alt="How does this work - Corporate Users">
                       </div> 
                     </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 CorporatePage-HowDoesThisWork-Grid CorporatePage-LightPurpleBg">
                
                       <h1 class="Corporate-HowthisWorkTitle mainfont whitefont fw-light">How does this work?</h1>
                       <ul class="Corporate-HowthisWorkList mainfont whitefont">
                           <li>Check if your company website is registered with us</li>
            
                           <li>If registered already, using your work email (having the same domain as the registered company website) purchase the ticket for your desired event</li>
                            
                           <li>If your company website / domain is not registered. Register your work mail and create a user account just once</li>
                            
                           <li>Purchase the ticket to your desired event with the registered work mail or after login in</li>
                       </ul>
                    </div>
                </div> 
       </div> 
       
       <div class="Corporate-HowAmhelping CorporatePage-WhiteBg triangle-white"><!-- inlineblock -->
               <div class="container">
                   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 CorporatePage-HowDoesThisWork-Grid CorporatePage-YellowBg">
                   <h1 class="Corporate-HowthisWorkTitle mainfont blackfont fw-light">How am i helping my friends by registering my company website/work mail domain?</h1>
                   <ul class="Corporate-HowthisWorkList mainfont blackfont">
                       <li>Once you create a user account using your work email, we will verify and register the domain for subsequent corporate users having the same work mail domain</li>
        
                       <li>You and the future users purchasing tickets to a desired event using the same work mail domain will automatically avail a complimentary corporate discount for every purchase</li>
                   </ul>
                   <p class="morequestions">Have more questions? fill the form, will get back to you</p>              
               </div>

               <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 HowAmhelping-ContactForm padding-zero">
                   <div class="whitebg-right min-height-ff text-center">
                         <div class="HowAmhelping-ContactFormHolder">
                            <form id="enquiry" v-on:submit="sendEnquiry($event)">
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <input type="text" name="first_name" class="form-control" placeholder="First Name">
                                        <!-- <div class="help-block with-errors"></div> -->
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                                    </div>

                                    <div class="form-group col-md-6 col-sm-12">
                                        <input type="email" name="email" class="form-control" placeholder="Company Email Id">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <input type="text" name="mobile" class="form-control" placeholder="Mobile No">
                                    </div>

                                    <div class="form-group col-md-12 col-sm-12 overflowauto">
                                        <textarea rows="4" name="message" placeholder="Comments"></textarea>
                                    </div> 

                                    <div class="form-group col-sm-12 overflowauto">
                                        <button type="submit" class="Corporate-RegForm-Submit">SUBMIT</button>
                                    </div>
                                </div> 
                            </form>
                        </div>
                   </div>
               </div> 
               </div> 
       </div>
        
    </div> <!-- // Wrap -->
</div> <!-- // Main Container-->

<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
<!-- Script for Scrolling to RegForm on Btn Click -->
<script type="text/javascript">
    var api_cityCitysByState = "<?php echo commonHelperGetPageUrl('api_cityCitysByState');?>";
    var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch')?>";
    var api_stateSearch = "<?php echo commonHelperGetPageUrl('api_stateSearch')?>";
    var api_citySearch = "<?php echo commonHelperGetPageUrl('api_citySearch')?>";
    var api_DomainCheck = "<?php echo site_url('corporate/check'); ?>";
    var api_CorporateEnquiry = "<?php echo site_url('corporate/enquire'); ?>";
    $(".corporatecreateaccount").click(function() {
        $('html, body').animate({
            scrollTop: $(".Corporate-RegistrationForm").offset().top
        }, 1000);
    });
    $('.cityAutoComplete').autocomplete({
        source: function (request, response) {
            var countryName = $.trim($('.countryAutoComplete').val());
            var stateName = $.trim($('.stateAutoComplete').val());
            var addEventCheck = false;
            if (stateName != '') {
                addEventCheck = true;
            }
            $.get(api_citySearch, {keyWord: request.term, countryName: countryName, stateName: stateName, addEventCheck: addEventCheck}, function (data) {
                response(data.response.cityList);
            });
        }
    });
    Vue.component('domain-check-result',{
        props:['message','status'],
        template: '<div class="mainfont padding-tten text-center fw-bold" v-bind:class="status+\'-message-text\'">{{ message }}</div>'
    });

    new Vue({
        el: '#corporate-vue',
        data : {
            check: {
                domain: '',
                result: false,
                status: '',
                message: ''
            }
        },
        methods: {
            checkDomain: function($e){
                $e.preventDefault();
                var regex = /^(?=.{0,253}$)(([a-z0-9][a-z0-9-]{0,61}[a-z0-9]|[a-z0-9])\.)+((?=.*[^0-9])([a-z0-9][a-z0-9-]{0,61}[a-z0-9]|[a-z0-9]))$/i;
                var vm = this;
                vm.check.result = false;
                try {
                    if( this.check.domain.length == 0 ){
                        throw "Please enter a domain!";
                    } else if(!regex.test( this.check.domain )){
                        throw "Please enter a valid domain!"
                    } else {
                        axios.post(
                            api_DomainCheck,$('#domainCheck').serialize()
                        ).then(function(response) {
                            console.log(response);
                            vm.check.result = true;
                            vm.check.status = response.data.success ? "success" : "error";
                            vm.check.message = response.data.message;
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }
                } catch (err){
                    vm.check.result = true;
                    vm.check.status = "error";
                    vm.check.message = err;
                }
            },
            sendEnquiry: function($e){
                $e.preventDefault();
                try {
                    axios.post(
                        api_CorporateEnquiry,$('#enquiry').serialize()
                    ).then(function(response) {
                        console.log(response);
                    }).catch(function (error) {
                        console.log(error);
                    });
                } catch (err){
                    console.log(error);
                }
            }
        }
    });
</script>