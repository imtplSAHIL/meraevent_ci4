<?php $this->load->view('includes/header');
?><div class="container"><?php
    $this->load->view('profile/left_menu.php');
	
	?>
    <div class="rightArea">
    <?php
    $this->load->view('mywallet/' . $content);
    ?>
    
    <!--<div style="margin-top:10px;"><img src="<?php echo $this->config->item('images_static_path'); ?>poweredby-udio.png" /></div>-->
    
    
    <div style="margin-top:10px;float: left;">
      <p style="float: left;">
       <img src="<?php echo $this->config->item('images_static_path'); ?>poweredby-udio.png">
      </p>
      <p style="float: left; margin-left: 60px; color: #333 !important; margin-top: 45px; margin-bottom: 40px;">
       <a href="<?php echo $this->config->item('images_content_cloud_path'); ?>udio/udio_terms_and_conditions.pdf" target="_blank" style="font-size: 13px;color: #333;">Terms &amp; Conditions</a>
      </p>
    </div>
    
    
    </div>
    
    
    	 
    </div>
    
   
     
</div><!-- wrap div -->
<!-- <link rel="stylesheet" type="text/css" href="<?php //echo $this->config->item('css_public_path'); ?>cssmenu.min.css.gz"> -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_public_path').'common'.$this->config->item('css_gz_extension'); ?>">
<script>
var api_dashboardEventchangeStatus = '<?php echo commonHelperGetPageUrl('api_dashboardEventchangeStatus');?>';
var api_stateList = '<?php echo commonHelperGetPageUrl('api_stateList');?>';
var api_stateList = '<?php echo commonHelperGetPageUrl('api_stateList');?>';
</script>
<!-- <script src="<?php //echo $this->config->item('js_public_path'); ?>dashboard/cssmenu.min.js.gz"></script> -->
<script src="<?php echo $this->config->item('js_public_path').'dashboard/customscripts'.$this->config->item('js_gz_extension'); ?>"></script>
<script src="<?php echo $this->config->item('js_public_path').'dashboard/main'.$this->config->item('js_gz_extension'); ?>"></script>
<script src="<?php echo $this->config->item('js_public_path').'common'.$this->config->item('js_gz_extension'); ?>"></script>
 <script src="<?php echo $this->config->item('js_public_path').'dashboard/fs-custom'.$this->config->item('js_gz_extension');  ?>"></script>


<?php
if (isset($jsArray) && is_array($jsArray)) {
    foreach ($jsArray as $js) {
        echo '<script src="' . $js .$this->config->item('js_gz_extension'). '"></script>';
        echo "\n";
    }
}
?>
<script>
// $('#user-toggle').click( function(event){
//        event.stopPropagation();
//        $("#helpdropdown-menu").hide();
//        $('#dropdown-menu').toggle();
//    });
//    $("#help-toggle").click(function () {
//		event.stopPropagation();
//		$('#dropdown-menu').hide();
//        $("#helpdropdown-menu").toggle();
//    });
</script>
</body>
</html>

