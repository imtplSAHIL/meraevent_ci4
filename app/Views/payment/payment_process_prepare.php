<div class="page-container">
    <div class="wrap">
        <div class="container"> 
            <div align="center"><img src="<?php echo $this->config->item('images_static_path')?>loading_image.gif"></div>
            <div align="center">Please wait while we are redirecting to <?php echo $pageName;?>...</div>
            <div align="center"><img src="<?php echo $pgImage;?>"></div>
            <form method="post" action="<?php echo $posturl;?>" name="mepayment_form">
                <?php
                    foreach($paramList as $name => $value) {
                        echo '<input type="hidden" name="' . $name .'" value="' . $value . '"><br>';
                    }
                ?>
               </form>
			   <script type="text/javascript">
                    setTimeout("document.mepayment_form.submit()",2000);
                </script>
        </div>
    </div>
</div>