<?php
//echo "<pre>";print_r($attendees['otherAttendee']);print_r($displayonTicketFields);
$configCustomDatemsg = json_decode(CONFIGCUSTOMDATEMSG,true);
$configTransactionDateonPass = json_decode(CONFIGTRANSACTIONDATEONPASS,true);
$configCustomTimemsg =  json_decode(CONFIGCUSTOMTIMEMSG,true);
$eventUrl = $eventData['eventUrl'];
$eventName = $eventData['title'];
$userEmail = $userDetail['email'];
$eventId = $eventData['id'];
$userId = $this->customsession->getData('userId');
$userMobile = $userDetail['mobile'];
$barcodeNumber = $eventsignupDetails['barcodenumber'];
$EventSignupId = $eventsignupDetails['id'];
$venueDetails = $eventData['fullAddress'];
$convertedStartTime=convertTime($eventData['startDate'],$eventData['location']['timeZoneName'],TRUE);
$convertedEndTime=convertTime($eventData['endDate'],$eventData['location']['timeZoneName'],TRUE);
$ticketpriceClass = 'col-sm-6';
 
 
 if($eventSettings['displayamountonticket'] == 1){
 	$ticketpriceClass = 'col-sm-4';
 }
 $referaleventurl = $eventUrl;
 $viralticketUrl =  $eventUrl;
 $backpageUrl = $eventUrl;
 $pcodeName='ucode';
 if($eventsignupDetails['bookingtype']=='global'){
    $pcodeName='acode';
 }
 if(!empty($eventticketviralsetting)){
 	$viralclass = "col-md-6";
 	$referralcode = $eventsignupDetails['referralcode'];
 	if($eventticketviralsetting[0]['type']== 'percentage'){
 		$referercomm =  $eventticketviralsetting[0]['referrercommission']."%";
 		$receivercomm =  $eventticketviralsetting[0]['receivercommission']."%";
 	}else{
 		$referercomm =  $eventticketviralsetting[0]['referrercommission']." ".$eventsignupDetails['currencyCode'];
 		$receivercomm =  $eventticketviralsetting[0]['receivercommission']." ".$eventsignupDetails['currencyCode'];
 	}
 	$viralticketUrl =  $eventUrl."?reffCode=".$referralcode;
        if(strlen($eventsignupDetails['promotercode'])>1){
            $pcode = $eventsignupDetails['promotercode'];
            $referaleventurl = $eventUrl."?".$pcodeName."=".$pcode;
            //$viralticketUrl = $eventUrl."?ucode=".$pcode;
            $backpageUrl = $referaleventurl;
        }else{
           $backpageUrl = $eventUrl;
        
        }
 }else{
 	$viralclass="col-md-12";
        if(strlen($eventsignupDetails['promotercode']) >1  ){
                $pcode = $eventsignupDetails['promotercode'];
                $referaleventurl = $eventUrl."?".$pcodeName."=".$pcode;
                $viralticketUrl = $eventUrl."?".$pcodeName."=".$pcode;
                $backpageUrl = $referaleventurl;
         }
 }

 // Back Button Url For Preview Page
 if($previewPagebooking == 1){
 	$backpageUrl = commonHelperGetPageUrl('event-preview','','?view=preview&eventId=' . $eventId);

 }
 
 $fblink = 'http://www.facebook.com/sharer/sharer.php?u='.urlencode($referaleventurl);
 $twitterlink = "http://twitter.com/?status=Meraevents".urlencode($referaleventurl);
 $linkedinlink = "http://www.linkedin.com/shareArticle?mini=true&amp;url=".urlencode($referaleventurl)."title=Meraevents";
 $googlelink = "https://plus.google.com/share?url=".urlencode($referaleventurl);

?>
		<div class="page-container">
	<div class="wrap">
		<div class="container print_ticket">
				<div class="row">
					<p>&nbsp;</p>
					<div class="col-lg-6 col-md-6 col-md-offset-3" style="border: 2px solid #b4eeff;
    background: #e5f9ff; padding: 50px 50px; border-radius:10px;font-family: 'Open Sans',sans-serif!important; ">
						<h2 style="text-align:center; font-family: 'Open Sans',sans-serif!important;  line-height:30px; font-size:22px;"><?php echo (isset($eventData['eventDetails']['stagedconfirmationmessage']) && !empty($eventData['eventDetails']['stagedconfirmationmessage'])) ? $eventData['eventDetails']['stagedconfirmationmessage'] : 'Thank you for applying. You will be receiving a confirmation mail.'; ?> </h2>
					</div>
				</div>				
				<div class="row">
      			 <div class="col-md-6 col-md-offset-3" ><a href="<?php  echo $backpageUrl; ?>" title="<?php echo $eventName;?>" style="float:right;margin-top:20px;"> Back to Events Page </a></div>
      			</div>	
                </div>
        </div>
</div>	
