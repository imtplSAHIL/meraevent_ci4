<?php $this->load->view('includes/header'); ?>
<div class="container">
    <?php
    $this->load->view('promoter/left_menu.php');
    $this->load->view($content);
    ?>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_public_path') . 'common' . $this->config->item('css_gz_extension'); ?>">
<script src="<?php echo $this->config->item('js_public_path') . 'dashboard/cssmenu' . $this->config->item('js_gz_extension'); ?>"></script>
<script src="<?php echo $this->config->item('js_public_path') . 'dashboard/customscripts' . $this->config->item('js_gz_extension'); ?>"></script>
<script src="<?php echo $this->config->item('js_public_path') . 'dashboard/main' . $this->config->item('js_gz_extension'); ?>"></script>
<script src="<?php echo $this->config->item('js_public_path') . 'common' . $this->config->item('js_gz_extension'); ?>"></script>
<script src="<?php echo $this->config->item('js_public_path') . 'dashboard/fs-custom' . $this->config->item('js_gz_extension'); ?>"></script>
<?php
if (isset($jsArray) && is_array($jsArray)) {
    foreach ($jsArray as $js) {
        echo '<script src="' . $js . $this->config->item('js_gz_extension') . '"></script>';
        echo "\n";
    }
}
?>
</body>
</html>

