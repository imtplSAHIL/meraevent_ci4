<?php $footerFAQLink = commonHelperGetPageUrl("faq");
$footerAboutusLink = commonHelperGetPageUrl("aboutus");
$contactUsLink = commonHelperGetPageUrl("contactUs");
$contactUsFormLink = commonHelperGetPageUrl("contactUsForm");
$privacyLink = commonHelperGetPageUrl("privacypolicy");
$siteMap = commonHelperGetPageUrl("mesitemap");
$footerCareerLink = commonHelperGetPageUrl("career");
$footerBlogLink = commonHelperGetPageUrl("blog");
$footerNewsLink = commonHelperGetPageUrl("news");
$footerClientfbLink = commonHelperGetPageUrl("client_feedback");
$footerPricingLink = commonHelperGetPageUrl("pricing");
$createEventLink = commonHelperGetPageUrl('create-event');
$bugBountyLink = commonHelperGetPageUrl("bugbounty");
$searchLink = commonHelperGetPageUrl("search");


$jsExt = $this->config->item('js_gz_extension');
/*if($content=='ticketregistration_view'){
 $jsExt = '.min.js';  
}else{
$jsExt = $this->config->item('js_gz_extension');
}*/


$publicPath = $this->config->item('js_public_path');
$imgStaticPath = $this->config->item('images_static_path');
if($defaultCityId == 0){$defaultCityName = LABEL_ALL_CITIES;}
$urihome = $this->uri->segment(1);
?>



<footer id="footer">

  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
            <h5>Categories</h5>
            <ul class="footer-list footer-list-icons">
              <?php
					$cityName = str_replace(' ', '', $defaultCityName);
					foreach ($categoryList as $cat){
					$catValue = strtolower($cat['value']);
				?>
				<li value="<?php echo $cat['id'];?>">
					<a class="footerCategorySearch" id="<?php echo $cat['id']; ?>" <?php if($cityName == "AllCities" || $urihome == ""){ ?> href ="<?php echo site_url().$catValue;?>" <?php }else if($catValue == "newyear"){ ?> href ="<?php echo site_url().$catValue.'/'.strtolower($defaultCityName);?>" <?php } else { ?> href="<?php echo site_url().strtolower($defaultCityName).'-events'.'/'.$catValue; ?>"<?php } ?>><?php echo $cat['name'];?></a>
				</li>
				<?php
				}
				?>
            </ul>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <h5>Services</h5>
            <ul class="footer-list footer-list-icons">
              <li><a href="<?php echo commonHelperGetPageUrl("eventregistration"); ?>">Free Events Registration</a></li>
				<li><a href="<?php echo commonHelperGetPageUrl("selltickets"); ?>">Sell Tickets Online</a></li>
				<li><a href="<?php echo $createEventLink;?>">Create Event</a></li>
				<!--<li><a href="discount.html">Discount</a></li> -->
				<li><a id="eventFind" href="<?php echo $searchLink; ?>">Find Event</a></li>
				<li><a href="<?php echo $footerPricingLink; ?>" target="_blank">Fees & Pricings</a></li>
				<!--
				<li><a href="<?php echo commonHelperGetPageUrl("apidevelopers");?>" target="_blank">Developers</a></li>
				-->
				<li><a href="<?php echo commonHelperGetPageUrl("dashboard-global-affliate-home");?>" target="_blank">Global Affiliate Marketing</a></li>
				<li><a href="<?php echo commonHelperGetPageUrl("features");?>" target="_blank">Organizer Features</a></li>
                                <li><a href="<?php echo commonHelperGetPageUrl('why_meraevents');?>" target="_blank">Why MeraEvents</a></li>
				<li class="footer-list-height">&nbsp;</li>				
            </ul>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <h5>Need Help</h5>
            <ul class="footer-list footer-list-icons">
              <li><a href="<?php echo $footerAboutusLink; ?>">About Us</a></li>
				<!-- <li><a href="<?php// echo $footerCareerLink; ?>">Careers</a></li>-->
				<li><a href="<?php echo $footerBlogLink; ?>" target="_blank">Blog</a></li>
                                <li><a href="<?php echo $contactUsFormLink; ?>" target="_blank">Contact Us</a></li>
				<li><a href="<?php echo $footerFAQLink; ?>">FAQs</a></li>
                                <li><a href="<?php echo commonHelperGetPageUrl("terms"); ?>" target="_blank">Terms of use</a></li>
				<!-- <li><a href="http://www.meraevents.com/apidevelopers">Developers</a></li>  This link's href needs to be changed after developing api developer page - Sai Sudheer-->
				<li><a href="<?php echo $footerNewsLink; ?>">News</a></li>
				<li><a href="<?php echo commonHelperGetPageUrl("mediakit"); ?>">Media Kit</a></li>
				<!--				<li><a href="<?php //echo $footerClientfbLink; ?>">Client's Feedback</a></li>-->
				
				<li><a href="<?php echo $privacyLink; ?>" target="_blank">Privacy Policy</a></li>
				<li><a href="<?php echo $siteMap; ?>">Site Map</a></li>
				<!-- <li><a href="https://www.getastra.com/r/MeraEvents-5a704fe6a546c" target="_blank">Submit a Bug</a></li> -->
				<!--<li><a href="<?php //echo commonHelperGetPageUrl("team"); ?>">Team</a></li>-->

				<!-- <li class="bugbounty_img"><a href="<?php// echo $bugBountyLink; ?>" target="_blank"><img src="<?php//  echo $imgStaticPath; ?>bugbounty.png"></a></li> -->
            </ul>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <h5>Products</h5>
            <ul class="footer-list footer-list-icons">
              <li><a href="https://www.moozup.com/" target="_blank">Moozup</a></li>
              <li><a href="https://www.easytag.in/" target="_blank">EasyTag</a></li>
            </ul>
          </div>          
        </div> <!-- row -->       
      </div><!-- col-lg-9 -->

      <div class="col-lg-3 footer-followus">
        <h5>FOLLOW US</h5>
        
        <!-- <div class="footer-subscribe-section">
                <p>Subscribe to our Newsletter</p> 
              <div class="input-group">
                <input class="form-control" placeholder="Subscribe to our Newsletter" name="newsletterEmail" id="newsletterEmail" type="text">
                <span class="input-group-btn">
                  <button class="btn btn-light" type="submit">Go!</button>
                </span>
              </div>
            </div>  -->    <!-- footer-subscribe-section -->

            <!--<div class="row socialIcons">
					<h4>Get Weekly Updates On Events</h4>
				<form action="https://meraevents.us12.list-manage.com/subscribe/post?u=f96a2420628d423aab0d3cbaa&amp;id=e85e25c728" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<span class="icon-nextArrow" style="top:68% !important;" onclick="document.getElementById('mc-embedded-subscribe-form').submit()"></span>
					<input type="email" value="" name="EMAIL" id="mce-EMAIL" placeholder="Email ID" class="form-control require email">
				</form>
			</div>-->

        <ul class="footer-social-list">
          <li><a href="https://www.facebook.com/meraeventsindia" target="_blank"><i class="icon2-facebook"></i></a></li>
          <li><a href="https://twitter.com/#!/meraeventsindia" target="_blank"><i class="icon2-twitter"></i></a></li>
          <li><a href="https://www.linkedin.com/company/meraevents" target="_blank"><i class="icon2-linkedin"></i></a></li>
        </ul>
        <div class="footer-contact-text">
          <a href="<?php echo $contactUsLink; ?>">@ Support</a>  
        </div>

        <!-- <p style="font-size:18px; color:#fff;padding:5px 10px;"><i class="icon2-phone"></i> 040-49171447  (Mon-Sun 10AM to 7PM)</p>
				<p style="font-size:18px; color:#fff;padding:5px 10px;"><i class="icon2-envelope-o"></i> <a href="mailto:support@meraevents.com">support@meraevents.com</a></p> -->

      </div><!-- col-lg-3 footer-followus -->     
    </div> <!-- row -->

    <div class="row">
      <div class="col-lg-12 footer-city-category">
        <div class="col-lg-12 col-md-6 col-sm-4 col-xs-6">
          <ul class="footer-city-list-inline">
                   <!-- <li><b>COUNTRIES : </b> </li>
                   <li><a href="#">Mumbai </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Bengaluru </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Delhi/NCR </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Ahmedabad </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Jaipur </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Kolkata </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Hyderabad </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Pune </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Goa </a></li> -->
                   <li class="footercat-heading">CITIES <span class="f-sep">:</span> </li>
					<?php
					$numItems = count($cityList);$i = 0;
					foreach ($cityList as $city) { ?>
					<li>
						<a id="<?php echo $city['id']; ?>" href="<?php echo site_url().strtolower(str_replace(' ','-',$city['name']))."-events"; ?>"><?php echo $city['name']; ?></a>
						<?php if(++$i !== $numItems) { ?>
						<span class="f-sep">|</span>
						<?php  }?>
					</li>
					<?php } ?>
          </ul>
        </div>
        <div class="col-lg-12 col-md-6 col-sm-4 col-xs-6">
                <ul class="footer-city-list-inline">
                   <!-- <li><b>CATEGORIES : </b> </li>
                   <li><a href="#">India </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Singapore </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">Malaysia </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">United Kingdom </a> <span class="f-sep">|</span> </li>
                   <li><a href="#">United States </a> </li> -->
                   <li class="footercat-heading">COUNTRIES <span class="f-sep">:</span> </li>
					<?php
						$numCountries = count($countryList);$pipe = 0;
						foreach ($countryList as $value) {
					?><li>
						<a onClick="setCookieCustom('countryId', '<?php echo $value['id']; ?>', '<?php echo COOKIE_EXPIRATION_TIME; ?>')"  href="<?php echo $value['domain']; ?>"><?php echo $value['name']; ?></a>						
						<?php if(++$pipe !== $numCountries) { ?><span class="f-sep">|</span><?php  } ?>
						
					</li><?php
									}
					?>
                </ul>
            </div>
      </div><!-- col-lg-12 footer-city-category -->
    </div> <!-- row -->

    <div class="row">
      <div class="col-lg-12">
        <p class="footer-copyright text-left">
           &copy; 2009-<?php echo date("Y");?>, Copyright @ Versant Online Solutions Pvt Ltd. All Rights Reserved
        </p>
      </div>
    </div> <!-- row -->


  </div> <!-- container -->
  
</footer>


 


<script>
var api_commonrequestsUpdateCookie = "<?php echo commonHelperGetPageUrl('api_commonrequestsUpdateCookie')?>";
</script>
<?php
// Loading Wizrocket
include("elements/wizrocket.php");
	$callclass = $this->router->fetch_class();
if($callclass == 'home' || $callclass == 'search' ||  $callclass == 'user' || $callclass == 'nopage' ){?>
<script src="<?php echo $this->config->item('js_angular_path').'angular'.$jsExt;?>"></script>
<?php } ?>
<script src="<?php echo $publicPath.'combined'.$jsExt;?>"></script>
<script src="<?php echo $publicPath.'common'.$jsExt;?>"></script>
<?php
if(isset($jsArray) && is_array($jsArray)) {
		foreach($jsArray as $js) {
      echo '<script src="'.$js.$jsExt.'"></script>';
      echo "\n";
  }
}
//Loading Google ANalytics
include("elements/googleanalytics.php");
// Loading TrueSemantic
if ($this->config->item('tsFeedbackEnable')) {
include("elements/truesemantic.php");
}
if($this->config->item('recommendationsEnable')){
// Loading Piwik recommendations script
include("elements/piwikrecommendations.php");
}
// Loading adroll tag
include("elements/adroll_tag.php");
// Loading facebook pixcel code
include("elements/facebook_pixel.php");
?>
<?php if($this->config->item('recommendations_box_enable')){ ?>
<script type="text/javascript">
  var BOXX_CUSTOMER_ID = "<?php $userid= getUserId(); echo ($userid) ? $userid : '' ; ?>";
</script>

<script type="text/javascript" src="https://js.boxx.ai/js_init/?client_id=yO8" defer></script>
<?php } ?>
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
var Eventurl = "<?php echo $createEventLink;?>";
var EventEditurl = "<?php echo commonHelperGetPageUrl('edit-event')?>";
var winloc = window.location.href + "/";
if( winloc.indexOf(Eventurl) != -1|| winloc.indexOf(EventEditurl) != -1 ){
loadtinyMce();
}
window.$zopim||(function(d,s){var z=$zopim=function(c){
z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//cdn.zopim.com/?re1Tn1zzg8om9TaoaKDzgaN1esPgyzg7';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->

<!-- Below is the code taken from google tag manager --- just for backup purpose added here  -->
<!-- <script async>(function(s,u,m,o,j,v){j=u.createElement(m);v=u.getElementsByTagName(m)[0];j.async=1;j.src=o;j.dataset.sumoSiteId='c5a08baf1f7731fa0a370a9b44babdc34de9d21e77afb0dd5eaef576c2fe22d3';v.parentNode.insertBefore(j,v)})(window,document,'script','//load.sumo.com/');</script> -->
</body>
</html>
