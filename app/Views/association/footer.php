<footer>
    <p>&copy; <?php echo date('Y'); ?> Versant Online Solutions Pvt Ltd. All Rights Reserved</p>
    <img src="/images/association/meraevents-logo.png" alt="Versant Online Solutions Pvt. Ltd" title="Versant Online Solutions Pvt. Ltd">
</footer>
<?php
$jsExt = $this->config->item('js_gz_extension');
if (isset($jsArray) && is_array($jsArray)) {
    foreach ($jsArray as $js) {
        echo '<script src="' . $js . $jsExt . '"></script>';
        echo "\n";
    }
}
?>
</body>
</html>