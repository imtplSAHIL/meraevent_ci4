<?php
//echo '<pre>'; print_r("here"); exit;
$eventIdPermission = $this->input->get('eventId'); 
$eventData = $this->config->item('eventData');
$isMultiEvent = $eventData["event" . $eventIdPermission]['isMultiEvent'];
$isMasterEvent = $eventData["event" . $eventIdPermission]['masterevent'];
$isCurrentEvent = (strtotime($eventData["event" . $eventIdPermission]['endDateTime']) > strtotime(allTimeFormats('',11))) ? TRUE : FALSE;
$useridPermission = getUserId();
$isCollaborator = $this->customsession->getData('isCollaborator');
$partialPaymentStatus = $this->customsession->getData('isPartialPayments');
$manageModule = TRUE;
$promoteModule = TRUE;
$reportModule = TRUE;
if ($isCollaborator == 1) {
    $collaboratorEventAccess = $this->config->item('collaboratorEventAccess');
    $collabEventUser = "collaboratorEvent" . $useridPermission . $eventIdPermission; 
    if ($collaboratorEventAccess[$collabEventUser] == 1) {        
        $collaboratorAccess = $this->config->item('collaboratorAccess');
        $collaboratorUserId = "collaborator".$useridPermission;
        if (strpos($collaboratorAccess[$collaboratorUserId], 'manage') === FALSE) {
             $manageModule = FALSE;
        }
        if (strpos($collaboratorAccess[$collaboratorUserId], 'promote') === FALSE) {
             $promoteModule = FALSE;
        }    
        if (strpos($collaboratorAccess[$collaboratorUserId], 'report') === FALSE) {
             $reportModule = FALSE;
        }
        //echo $collaboratorAccessLevel = $collaboratorAccess[$collaboratorUserId]);
    }
}
//Multievent setting
if($isMultiEvent == TRUE && $isMasterEvent == FALSE){
    $ChildEvent = TRUE;
}else{
    $ChildEvent = FALSE;
}
?>
<div class="leftFixed">
    <div id='cssmenu'>
        <ul>
            <li class='has-sub'><a href='<?php echo getDashboardUrl(); ?>'>
                    <span class="icon icon-event menuLeft"></span><span>Organizer View</span></a>
            </li>
            <?php if ($manageModule == TRUE || ($isMultiEvent == TRUE && $manageModule == FALSE)) {?>
            <li class='has-sub'><a href='<?php echo commonHelperGetPageUrl('dashboard-eventhome', $this->input->get('eventId')); ?>' <?php echo $this->uri->segment(2) == 'home' ? ' class="currentPage"' : '';?> ><span class="icon icon2-dashboard menuLeft"></span><span>Dashboard</span></a>
            </li>
            <?php if ($eventData["event".$eventIdPermission]['eventMode'] == 1 && $isMultiEvent == FALSE) { ?>
                        <li><a href="<?php echo commonHelperGetPageUrl('dashboard-enableExternalMeetingLink', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'enableExternalMeetingLink' ? ' class="currentsubLink"' : ''; ?>><span class="icon icon2-video-camera menuLeft"></span>Online Event</a></li>
                        <?php } ?>
            <?php } ?>
            <?php if ($manageModule && $ChildEvent == FALSE) {?>
            <li class='has-sub'><a href='javascript:void(0);' <?php echo ($this->uri->segment(2) == 'collaborator') ? ' class="currentPage"' : '';?>><span class="icon icon-configer menuLeft"></span><span>Manage</span></a>
                <ul <?php echo ($this->uri->segment(2) == 'collaborator') ? ' id="currentMenu" style="display: block"' : ''; ?>>
<!--                    <li <?php //echo ($this->uri->segment(3) == 'ticketOptions' ||$this->uri->segment(3) == 'ticketWidget'||$this->uri->segment(3) == 'paymentMode') ? ' id="currentMenu"   style="display: block"' : ''; ?>><a href="#" id="settings">Event Settings</span></a>
                        <ul id="settingsOpctions" style="display:none;" <?php // if($this->uri->segment(3) == 'ticketWidget' || $this->uri->segment(3) == 'ticketOptions' ||$this->uri->segment(3) == 'paymentMode') { echo ' class="settings" ';} ?> >
                        </ul>
                    </li>-->
                    <?php if($isCurrentEvent) { ?>
                        <li><a href="<?php echo commonHelperGetPageUrl('edit-event', $this->input->get('eventId')); ?>" target="_blank">Edit</a></li> 
                    <?php } ?>
                    <li><a href="<?php echo commonHelperGetPageUrl('event-preview','','?view=preview&eventId='. $this->input->get('eventId')); ?>" target="_blank">Preview</a></li> 
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-ticketwidget', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'ticketWidget' ? ' class="currentsubLink"' : ''; ?>>Ticket Widget</a></li> 
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-ticketOption', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'ticketOptions' ? ' class="currentsubLink"' : ''; ?>>Ticket Options</a></li>
                    <?php if ($isMasterEvent == FALSE) {?>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-ticketGroupig', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(2) == 'ticketgroups' ? ' class="currentsubLink"' : ''; ?>>Ticket Grouping</a></li>
                    <?php } ?>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-paymentMode', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'paymentMode' ? ' class="currentsubLink"' : ''; ?>>Payment Modes</a></li>  
                       
                    
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-customField', $this->input->get('eventId')); ?>"  <?php echo ($this->uri->segment(3) == 'customFields' || $this->uri->segment(3) == 'curation') ? ' class="currentsubLink"' : ''; ?>>Custom Fields</a></li>
                    <!--<li><a href="<?php echo commonHelperGetPageUrl('dashboard-webhook', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'webhookUrl' ? ' class="currentsubLink"' : ''; ?> >Web Hook URL</a></li>-->
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-gallery', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'gallery' ? ' class="currentsubLink"' : ''; ?> >Gallery</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-seo', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'seo' ? ' class="currentsubLink"' : ''; ?> >SEO</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-contactinfo', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'contactInfo' ? ' class="currentsubLink"' : ''; ?> >Contact Information</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-tnc', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'tnc' ? ' class="currentsubLink"' : ''; ?>>Terms & Conditions</a></li>
                    
                    <li><a href="<?php echo commonHelperGetPageUrl('custom-email-template', $this->input->get('eventId')); ?>"  <?php echo ($this->uri->segment(3) == 'customtemplate') ? ' class="currentsubLink"' : ''; ?>>Custom Template</a></li>
                   <?php  if ($collaboratorEventAccess[$collabEventUser] != 1){ ?>
                     <li><a href="<?php echo commonHelperGetPageUrl('dashboard-list-collaborator', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'collaboratorlist' || $this->uri->segment(3) == 'addcollaborator' || $this->uri->segment(3) == 'editcollaborator'? ' class="currentsubLink"' : ''; ?> >Collaborator</a></li>
                    <?php } ?>
			<li><a href="<?php echo commonHelperGetPageUrl('dashboard-deleteRequest', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'deleteRequest' ? ' class="currentsubLink"' : ''; ?>>Delete Request</a></li>		
                        <?php if($isMultiEvent == FALSE){ ?>
                        <li><a href="<?php echo commonHelperGetPageUrl('dashboard-stagedEvent', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'stagedEvent' ? ' class="currentsubLink"' : ''; ?>>Event Types</a></li>	
                        <?php } ?>
                        <li><a href="<?php echo commonHelperGetPageUrl('dashboard-fbPixel', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'fbPixel' ? ' class="currentsubLink"' : ''; ?>>FB Pixel Code</a></li>	
                        <li><a href="<?php echo commonHelperGetPageUrl('dashboard-gtm', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'gtm' ? ' class="currentsubLink"' : ''; ?>>GTM Code</a></li>	
                </ul>
            </li>
            <?php } ?>
            <?php if ($promoteModule == TRUE || $isMasterEvent == TRUE) {?>
            <li class='has-sub'><a href='javascript:void(0);' <?php echo ($this->uri->segment(2) == 'promote') ? ' class="currentPage"' : ''; ?>><span class="icon icon-promote menuLeft"></span><span>Promote</span></a>
                <ul <?php echo ($this->uri->segment(2) == 'promote') ? ' id="currentMenu" style="display: block"' : ''; ?>>
                    <?php if ($isMasterEvent == TRUE || $isMultiEvent == FALSE) {?>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-discount', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'discount' ? ' class="currentsubLink"' : ''; ?> >Discount</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-bulk-upload-discount', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'bulkUploadDiscounts' ? ' class="currentsubLink"' : ''; ?> >Bulk Upload Discounts</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-bulkdiscount', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'bulkDiscount' ? ' class="currentsubLink"' : ''; ?> >Bulk Discounts</a></li>
                    <?php } ?>
                    
                    <?php if ($isMultiEvent == FALSE) {?>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-offlinepromoter', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'offlinePromoterlist' || $this->uri->segment(3) == 'addOfflinePromoter' || $this->uri->segment(3) == 'editOfflinePromoter' ? ' class="currentsubLink"' : ''; ?>  >Offline Promoter</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-viralticket', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'viralTicket' ? ' class="currentsubLink"' : ''; ?> >Viral Ticketing</a></li>
                    <!--<li><a href="<?php echo commonHelperGetPageUrl('dashboard-pastattviralticket', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'pastattviralticket' ? ' class="currentsubLink"' : ''; ?> >Past Attendee Marketing</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-pastattlisting', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'pastattendeelist' ? ' class="currentsubLink"' : ''; ?> >Past Attendee Listing</a></li>-->
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-affliate', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'affiliate' ? ' class="currentsubLink"' : ''; ?>  >Affiliate Marketing</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-marketing-resources', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'marketing' ? ' class="currentsubLink"' : ''; ?>  >Marketing Resources</a></li>
                    <?php } ?>
                    <?php if ($isMasterEvent == FALSE) {?>
                     <li><a href="<?php echo commonHelperGetPageUrl('dashboard-guestlist-booking', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'guestListBooking' ? ' class="currentsubLink"' : ''; ?> >Bulk Booking</a></li>
                        <?php if($_SESSION['userEmail'] == 'neeraj.deginal@shrm.org' || $_SESSION['userEmail'] == 'alok.rawat@shrm.org' || $_SESSION['userEmail'] == 'bharti.tyagi@shrm.org' || $_SESSION['userEmail'] == 'deepak.sharma@shrm.org') { ?>
                           <li><a href="<?php echo commonHelperGetPageUrl('dashboard-guestlist-failures', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'guestBookingFailures' ? ' class="currentsubLink"' : ''; ?> >Bulk Booking Failures</a></li>
                        <?php } ?>
                     <li><a href="<?php echo commonHelperGetPageUrl('dashboard-spot-registration', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'spotRegistration' ? ' class="currentsubLink"' : ''; ?> >Spot Registration</a></li>
                    <?php } ?>
                     <?php if ($isMasterEvent == TRUE || $isMultiEvent == FALSE) {?>
                     <li><a href="<?php echo commonHelperGetPageUrl('dashboard-socialWidgets', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'socialwidgets' ? ' class="currentsubLink"' : ''; ?> >Social Widgets</a></li>
                    <?php } ?>
                     <?php if ($isMasterEvent == FALSE && $partialPaymentStatus == 1) {?>
                     <li><a href="<?php echo commonHelperGetPageUrl('dashboard-partialPayments', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'partialspayments' ? ' class="currentsubLink"' : ''; ?> >Partial Payments</a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if ($manageModule && $isMasterEvent == FALSE) {?>
            <li class='has-sub'><a href='javascript:void(0);' <?php echo $this->uri->segment(3) == 'emailAttendees' ? ' class="currentPage"' : '';?> ><span class="icon icon-mail whitecolor menuLeft"></span><span>Communicate</span></a>
                <ul <?php echo ($this->uri->segment(3) == 'emailAttendees') ? ' id="currentMenu" style="display: block"' : ''; ?>>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-emailAttendees', $this->input->get('eventId')); ?>"  <?php echo $this->uri->segment(3) == 'emailAttendees' ? ' class="currentsubLink"' : ''; ?>>Email Attendees</a></li>
                </ul>
            </li>
            <?php } ?>
            <?php if ($reportModule && $isMasterEvent == FALSE) {?>
            <li class='has-sub' ><a href='javascript:void(0);' <?php echo ($this->uri->segment(2) == 'reports' || $this->uri->segment(2) == 'saleseffort') ? ' class="currentPage"' : ''; ?>><span class="icon icon-report menuLeft"></span><span>Reports</span></a>
                <ul <?php echo ($this->uri->segment(2) == 'reports' || $this->uri->segment(2) == 'saleseffort') ? ' id="currentMenu" style="display: block"' : ''; ?>>
                    <?php
                    if(array_key_exists($this->input->get('eventId'), GPTW_EVENTS_ARRAY))
                    {
                        ?>
                        <li><a href="<?php echo commonHelperGetPageUrl('dashboard-offline-pending-transaction-report', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(2) == 'reports' ? ' class="currentsubLink"' : ''; ?>>Offline Pending Transactions</a></li>                            
                    <?php
                        }
                    ?>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $this->input->get('eventId') . '&summary&all&1'); ?>" <?php echo $this->uri->segment(2) == 'reports' ? ' class="currentsubLink"' : ''; ?>>
                    <?php
                        if(array_key_exists($this->input->get('eventId'), GPTW_EVENTS_ARRAY))
                        {
                            ?>Confirmed Purchaser Details
                    <?php
                        }
                        else
                        {
                            ?>
                            Transactions
                            <?php
                        }
                    ?>
                    </a></li>
                    <?php
                        if(array_key_exists($this->input->get('eventId'), GPTW_EVENTS_ARRAY))
                        {
                            ?>
                            <li><a href="<?php echo commonHelperGetPageUrl('dashboard-offline-attendees-transaction-report', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(2) == 'reports' ? ' class="currentsubLink"' : ''; ?>> Confirmed Attendee Details</a></li>                            
                    <?php
                        }
                    ?>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-saleseffort-report', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(2) == 'saleseffort' ? ' class="currentsubLink"' : ''; ?>>Sales Effort</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-analytics-report', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(2) == 'analyticsreport' ? ' class="currentsubLink"' : ''; ?>>Analytics Report</a></li>
                </ul>
            </li>
            <?php } ?>
            <?php if (($reportModule || $manageModule) && $isMasterEvent == FALSE) {?>
            <li class='has-sub'><a id="paymentLeftTab" href='javascript:void(0);' <?php echo $this->uri->segment(2) == 'payment' ? ' class="currentPage"' : '';?> ><span class="icon icon-payment menuLeft"></span><span>Payment</span></a>
                <ul <?php echo ($this->uri->segment(2) == 'payment') ? ' id="currentMenu" style="display: block"' : ''; ?>>
                    <li id='refundMenu'><a href="<?php echo commonHelperGetPageUrl('dashboard-refund', $this->input->get('eventId') . '&detail&refund'); ?>" <?php echo $this->uri->segment(3) == 'refund' ? ' class="currentsubLink"' : ''; ?>>Refund</a></li>
                    <li><a href="<?php echo commonHelperGetPageUrl('dashboard-payment-receipts', $this->input->get('eventId')); ?>" <?php echo $this->uri->segment(3) == 'receipts' ? ' class="currentsubLink"' : ''; ?>>Payment Receipts</a></li>
                    <li><a style="display:none;" id="bankDetailsSubTab" href="<?php echo commonHelperGetPageUrl('user-bankdetail'); ?>" <?php echo $this->uri->segment(3) == 'receipts' ? ' class="currentsubLink"' : ''; ?>>Bank Details</a></li>
                    
                </ul>
            </li>
            <?php } ?>
            <li><a <?php if($viewPageName == "networking") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('networkingApp');?>" target="_blank"><span class="icon fa fa-check-square-o"></span> Networking App</a></li>
             <li><a <?php if($viewPageName == "checkin") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('checkinApp');?>" target="_blank"><span class="icon fa fa-users"></span> Checkin App</a></li>
        </ul>
    </div>
    <div class="sidebar-full-height-bg"></div>
</div>

<script>
    var eventRefundUrl = "<?php echo commonHelperGetPageUrl('dashboard-refund', $this->input->get('eventId') . '&detail&refund&getRefundCount'); ?>";
    $(document).ready(function (){
                $.ajax({
			type:'GET',
			url: eventRefundUrl,
                        success:function(res){
                            res = JSON.parse(res);
                            if(res.response.total == 0){
                                $('#refundMenu').css({'display':'none'});
                            }
			},
			error:function(res){
			}
                });
           });

</script>

