<div class="page-container">
    <div class="wrap">
        <div class="container"> 
            <div align="center"><img src="<?php echo $this->config->item('images_static_path')?>loading_image.gif"></div>
            <div align="center">Please wait while we are processing your request...</div>
            <div align="center"><img src="<?php echo $this->config->item('images_static_path')?>me-logo.svg"></div>
            <form method="post" action="<?php echo PAYTM_TXN_URL.'?orderid='.$paramList['ORDER_ID'];?>" name="paytm_form">
            	<?php
				//echo '<pre>';
			//print_r($paramList);exit;
                    foreach($paramList as $name => $value) {
                        echo '<input type="hidden" name="' . $name .'" value="' . $value . '"><br>';
                    }
                ?>
                <input type="hidden" name="CHECKSUMHASH" value="<?= $checkSum?>">
                <script type="text/javascript">
                    setTimeout("document.paytm_form.submit()",2000);
                </script>
            </form>
        </div>
    </div>
</div>