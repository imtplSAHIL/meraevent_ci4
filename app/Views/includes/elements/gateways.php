<?php
foreach ($eventGateways as $key => $gateway) {
    $gatewayName = strtolower($gateway['gatewayName']);
    $gatewayKey = $gateway['paymentgatewayid'];
    $gatewayDescription = $gateway['description'];
    $gatewayFunction = $gateway['functionname'];
    $gatewayImage = $gateway['imageid'];
    
    $actionUrl=site_url('payment/'.$gatewayFunction.'Prepare');
    if($gatewayName=='paytm'){
            $actionUrl=site_url('payment/'.$gatewayFunction.'Select');
    }
    
    if(isset($widgetStatus)){ ?>
        <form name="<?php echo $gatewayFunction;?>_frm" id="<?php echo $gatewayFunction;?>_frm" action="<?php echo $actionUrl;?>" method='POST' <?php if($gatewayFunction=='phonepe' || $gatewayFunction=='ebs' ){ ?> target="_top" <?php }?>>
            <input type="hidden" name="eventTitle" value="<?php echo preg_replace("/[^A-Za-z0-9]/","", stripslashes($eventData['title']))?>" />
            <input type="hidden" name="orderId" value="<?php echo $orderLogId; ?>" />
            <input type="hidden" name="paymentGatewayKey" value="<?php echo $gatewayKey; ?>" />
			 <input type="hidden" name="samepage" value="<?php echo $samepage; ?>" />
			 <input type="hidden" name="nobrand" value="<?php echo $nobrand; ?>" />
                         <?php if($gatewayFunction=='paypal' || $gatewayFunction=='phonepe'){ ?>
                             <input type="hidden" name="themefields" value="<?php echo $themeFieldsUrl.$widgetThirdPartyUrl; ?>" />
                         <?php }
                               elseif ($gatewayFunction=='paytm') { ?>
                         <input type="hidden" name="themefields" value="<?php echo $themeFieldsUrlForPaytm; ?>" />    
                         <?php }elseif($gatewayFunction=='ebs'){ ?>
                         <input type="hidden" name="themefields" value="<?php echo $themeFieldsUrlForEBS; ?>" />        
                           <?php  }else{ ?>
			 <input type="hidden" name="themefields" value="<?php echo $themeFieldsUrl; ?>" />
                         <?php } ?>
            <input type="hidden" name="primaryAddress" class="primaryAddress" id="primaryAddress" value="<?php if(isset($primaryAddress) && $primaryAddress != '') echo $primaryAddress;?>">
        </form>
   <?php }else{
    ?>
    <form name="<?php echo $gatewayFunction; ?>_frm" id="<?php echo $gatewayFunction; ?>_frm" action="<?php echo $actionUrl;?>" method='POST'>
        <input type="hidden" name="eventTitle" value="<?php echo preg_replace("/[^A-Za-z0-9]/", "", stripslashes($eventData['title'])) ?>" />
        <input type="hidden" name="orderId" value="<?php echo $orderLogId; ?>" />
        <input type="hidden" name="paymentGatewayKey" value="<?php echo $gatewayKey; ?>" />
        <input type="hidden" name="primaryAddress" class="primaryAddress" id="primaryAddress" value="<?php if (isset($primaryAddress) && $primaryAddress != '') echo $primaryAddress; ?>">
    </form>

    <?php } }