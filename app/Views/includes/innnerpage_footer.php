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
$jsExt = $this->config->item('js_gz_extension');
$publicPath = $this->config->item('js_public_path');
$imgStaticPath = $this->config->item('images_static_path');
if($defaultCityId == 0){$defaultCityName = LABEL_ALL_CITIES;}
$urihome = $this->uri->segment(1);
?>
<footer id="colophone">
            <div class="t-center site-footer__primary">
               <div class="footer-bottom site-footer">
                  <div class="container">
                     <div class="d-lg-flex  justify-content-between align-items-center footer-bottom-top">
                        <ul class="social-menu min-list inline-list">
                           <li><a href="<?php echo $footerAboutusLink; ?>">About us</a></li>
                           <li><a href="<?php echo $footerBlogLink; ?>" target="_blank">Blog</a></li>
                           <li><a href="<?php echo $footerFAQLink; ?>">FAQs</a></li>
                           <li><a href="<?php echo $footerNewsLink; ?>">News</a></li>
                           <li><a href="<?php echo commonHelperGetPageUrl("mediakit"); ?>">Media Kit</a></li>
                           <li><a href="<?php echo commonHelperGetPageUrl("terms"); ?>">Terms & Conditions</a></li>
                           <li><a href="<?php echo $privacyLink; ?>">Privacy Policy</a></li>
                        </ul>
                     </div>
                     <div class="footer-copyright">
                        <p>&copy; 2019 MeraEvents. All rights reserved.</p>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
 <!-- #colophone -->
         <a href="#" class="back-to-top"><span class="ion-ios-arrow-up"></span></a>
      </div>
      
<!--      <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.js" type="text/javascript"></script>-->
      <script src="assets/scripts/app.js"></script>
      <script async src="https://static.addtoany.com/menu/page.js"></script>
   </body>
   <script src="<?php echo $publicPath.'combined'.$jsExt;?>"></script>
<script src="<?php echo $publicPath.'common'.$jsExt;?>"></script>
        <?php
	if(isset($jsArray) && is_array($jsArray)) {
            foreach($jsArray as $js) {
                echo '<script src="'.$js.$jsExt.'"></script>';
                echo "\n";
            }
        }?>
   <script>
      $("#write").click(function() {
          $('html,body').animate({
              scrollTop: $("#write-form").offset().top-150
              // scrollTop: $("#write-form").offset().top - $(window).height() - 100
          }, 'slow');
      });
      $('.social-toggle').on('click', function() {
        $(this).next().toggleClass('open-menu');
      });
      
   </script>
   <script>
      var a2a_config = a2a_config || {};
      a2a_config.onclick = 1;
   </script>
   
</html>