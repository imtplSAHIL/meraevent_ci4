<?php
$jsExt = $this->config->item('js_gz_extension');
$jsPublicPath = $this->config->item('js_public_path');
?>
<script src="<?php echo $jsPublicPath . 'intlTelInput' . $jsExt; ?>"></script>
<script src="<?php echo $jsPublicPath . 'common' . $jsExt; ?>"></script>
<script src="<?php echo $jsPublicPath . 'jQuery-ui' . $jsExt; ?>"></script>
<script src="<?php echo $jsPublicPath . 'dashboard/spotRegistration' . $jsExt; ?>"></script>
<script src="<?php echo $jsPublicPath . 'additional-methods' . $jsExt; ?>"></script>
</html>
