<?php  $this->load->view('includes/header');
            if(isset($hideLeftMenu) && $hideLeftMenu!=1) {
	    ?><div class="container"><?php
		$this->load->view('dashboard/left_menu.php');
		
	}else if(isset($hideLeftMenu) && $hideLeftMenu == 1) {
            ?><div class="container"><?php
		$this->load->view('promoter/left_menu.php');
        }
    $this->load->view('dashboard/'.$content);
	if(isset($hideLeftMenu) && $hideLeftMenu!=1) {
	?></div>  <?php
	}else if(isset($hideLeftMenu) && $hideLeftMenu == 1) {
	?></div>  <?php
	}
    ?>
<?php 
    $viewPageName = $this->uri->segment(1);
    $pageName = $this->uri->segment(2);
    $viewpage = $this->uri->segment(3);
?>
</div><!-- wrap div -->
<?php
if (isset($hideLeftMenu) && $hideLeftMenu != 1) {
    ?>
    <!-- <link rel="stylesheet" type="text/css" href="cssmenu.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_public_path').'common'.$this->config->item('css_gz_extension'); ?>">
    <!-- <script src="<?php //echo $this->config->item('js_public_path'); ?>dashboard/cssmenu.js"></script> -->
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/fs-match-height'.$this->config->item('js_gz_extension');  ?>"></script>
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/table-saw'.$this->config->item('js_gz_extension');  ?>"></script>
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/customscripts'.$this->config->item('js_gz_extension');  ?>"></script>
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/main'.$this->config->item('js_gz_extension');  ?>"></script>

<?php
} else {
    ?>
<!--    <link href="<?php echo $this->config->item('css_public_path').'me-iconfont'. $this->config->item('css_gz_extension'); ?>" rel="stylesheet" type="text/css">-->
    <script src="<?php echo $this->config->item('js_public_path').'tabcontent'.$this->config->item('js_gz_extension'); ?>"></script>
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/main'. $this->config->item('js_gz_extension'); ?>"></script>



    <?php
}
?>
<script src="<?php echo $this->config->item('js_public_path').'common'.$this->config->item('js_gz_extension'); ?>"></script>

<?php
if (isset($jsArray) && is_array($jsArray)) {
    foreach ($jsArray as $js) {
        echo '<script src="' . $js .$this->config->item('js_gz_extension'). '"></script>';
        echo "\n";
    }
}
?>
<?php if($viewpage != "updateTemplate" ) {?>
<script src="<?php echo $this->config->item('js_public_path').'dashboard/fs-custom'.$this->config->item('js_gz_extension');  ?>"></script>
 <?php }?>

</body>
</html>

