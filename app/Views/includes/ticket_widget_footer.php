<?php
  if($content=='ticketregistration_view' || $content='ticket_widget_template_reg_info'){
     $jsExt = '.min.js';
   }else{
     $jsExt = $this->config->item('js_gz_extension');
    }
?>



<script src="<?php echo $this->config->item('js_public_path').'intlTelInput'.$jsExt; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path').'typeahead'.$jsExt; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path').'jQuery-ui'.$jsExt; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path').'mordernizer'.$jsExt; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path').'bootstrap'.$jsExt; ?>"></script>
<?php $visible = false; if($visible) { ?>
<script src="<?php echo $this->config->item('js_public_path').'me-ie7'.$jsExt; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path').'index'.$jsExt; ?>"></script>
<script src="<?php echo $this->config->item('js_angular_path').'angular'.$jsExt;?>"></script>
<?php } ?>
<script src="<?php echo $this->config->item('js_public_path').'analytics'.$jsExt; ?>"></script>
<script src="<?php echo $this->config->item('js_public_path').'combined'.$jsExt;?>"></script>
<?php 
// Loading Wizrocket 
  include("elements/wizrocket.php"); 
	$callclass = $this->router->fetch_class(); 
	if($callclass == 'home' || $callclass == 'search' ||  $callclass == 'user' || $callclass == 'nopage' ){?>
	<script src="<?php echo $this->config->item('js_angular_path').'angular'.$jsExt;?>"></script>
<?php } ?>
<?php
	if(isset($jsArray) && is_array($jsArray)) {
		foreach($jsArray as $js) {
                  	echo '<script src="'.$js.$jsExt.'"></script>';
                        echo "\n";
                }
	}
?>
