<?php $footerFAQLink = commonHelperGetPageUrl("faq");
$footerAboutusLink = commonHelperGetPageUrl("aboutus");
$contactUsLink = commonHelperGetPageUrl("contactUs");
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


<?php
  if($content=='ticketregistration_view' || $content=='ticket_widget_template_reg_info'){
     $jsExt = '.min.js';
   }else{
     $jsExt = $this->config->item('js_gz_extension');
    }
?>


$publicPath = $this->config->item('js_public_path');
$imgStaticPath = $this->config->item('images_static_path');
if($defaultCityId == 0){$defaultCityName = LABEL_ALL_CITIES;}
$urihome = $this->uri->segment(1);
?>





 


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
</body>
</html>
