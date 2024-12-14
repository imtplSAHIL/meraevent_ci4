
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
        
<link
	href='https://fonts.googleapis.com/css?family=Droid+Serif:400italic'
	rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_public_path').'me_custom.min.css'; ?>"> 
<script type="text/javascript">
	var site_url = '<?php echo site_url(); ?>';
	 var https_url = '<?php echo https_url();?>';
	var api_path = '<?php echo $this->config->item('api_path'); ?>';
	var client_ajax_call_api_key = '<?php echo $this->config->item('client_ajax_call_api_key'); ?>';
	var api_getTicketCalculation ='<?php echo commonHelperGetPageUrl('api_getTicketCalculation');?>';
	var api_bookNow = '<?php echo commonHelperGetPageUrl('api_bookNow');?>';
</script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->


<link rel="stylesheet"
	  href="<?php echo $this->config->item('css_public_path').'jquery-ui'.$this->config->item('css_gz_extension'); ?>">
<?php
	if(isset($cssArray) && is_array($cssArray)) {
		foreach($cssArray as $cssFile) {
				echo '<link rel="stylesheet" type="text/css" href="'.$cssFile.$this->config->item('css_gz_extension').'">';
				echo "\n";
		}
	}
?>
<?php
  if($content=='ticketregistration_view' || $content=='ticket_widget_template_reg_info'){
     $jsExt = '.min.js';
   }else{
     $jsExt = $this->config->item('js_gz_extension');
    }
?>

<script src="<?php echo $this->config->item('js_public_path').'jQuery'.$jsExt; ?>"></script>
<?php
if (isset($eventData['eventDetails']['fbpixelcode']) && !empty($eventData['eventDetails']['fbpixelcode'])) {
    $fbq_code = $eventData['eventDetails']['fbpixelcode'];
    $fbq_viewcontent = "";
    if (isset($calculationDetails)) {
        $fbq_tickets = array();
        foreach ($calculationDetails['ticketsData'] as $fbq_ticket) {
            $fbq_tickets[] = ['id' => $fbq_ticket['ticketId'], 'quantity' => $fbq_ticket['selectedQuantity']];
        }
        $fbq_viewcontent = "fbq('track', 'InitiateCheckout', {
                            content_category: '" . $eventData['title'] . "',
                            content_ids: '" . $eventData['id'] . "',
                            contents: '" . json_encode($fbq_tickets) . "',
                            currency: '" . $calculationDetails['currencyCode'] . "',
                            num_items: '" . $calculationDetails['totalTicketQuantity'] . "',
                            value: '" . $calculationDetails['totalTicketAmount'] . "',
                        });";
    } else if (isset($eventsignupDetails)) {
        $fbq_tickets = array();
        foreach ($ticketDetails as $fbq_ticket) {
            $fbq_tickets[] = ['id' => $fbq_ticket['ticketid'], 'quantity' => $fbq_ticket['ticketquantity']];
        }
        $fbq_viewcontent = "fbq('track', 'Purchase', {
                            content_ids: '" . $eventData['id'] . "',
                            content_name: '" . $eventData['title'] . "',
                            content_type: 'event',
                            contents: '" . json_encode($fbq_tickets) . "',
                            currency: '" . $eventsignupDetails['currencyCode'] . "',
                            num_items: '" . $eventsignupDetails['quantity'] . "',
                            value: '" . round($eventsignupDetails['totalamount']) . "',
                        });";
    } else {
        $fbq_viewcontent = "fbq('track', 'ViewContent', {
                content_name: '" . $eventData['title'] . "',
                content_category: '" . $eventData['categoryName'] . "',
                content_ids: ['" . $eventData['id'] . "'],
                content_type: 'event'
            });";
    }
    echo substr_replace($fbq_code, $fbq_viewcontent, strpos($fbq_code, "PageView');") + 11, 0);
}
?>
<?php echo isset($eventData['eventDetails']['googleanalyticsscripts']) ? $eventData['eventDetails']['googleanalyticsscripts'] : ''; ?>
</head>
<div id="dvLoading" class="loadingopacity" style="display:none;"><img src="<?php echo $this->config->item('images_static_path'); ?>loading.gif" class="loadingimg" /></div>
<?php 
if($nobrand !=1) { ?>
<?php if(isset($widgettheme) && $widgettheme==0){ ?>
<div style="height:36px; float:left; width:100%;">

<p style="float:left;padding:10px 0 0 10px; margin-right:10px; font-size:11px;">Powered By</p>
<p style="float:left;margin:0;"><img src="https://static.meraevents.com/images/static/me-logo.svg" width="90px" /></p>


</div>
<?php } } ?>

