<?php 
	$userId = $this->customsession->getUserId();
        $attendeeStatus = $this->customsession->getData('isAttendee');
        $promoterStatus = $this->customsession->getData('isPromoter');
        $orgStatus = $this->customsession->getData('isOrganizer');
        $collaboratorStatus = $this->customsession->getData('isCollaborator');
        $associationCheck = $this->customsession->getData('isAssociation');
        $userPPCheck = $this->customsession->getData('isPartialPaymentsAttendee');
        $attendeeCheck = (isset($attendeeStatus) && $attendeeStatus == 1) ? TRUE : FALSE;
        $promoterCheck = (isset($promoterStatus) && $promoterStatus == 1) ? TRUE : FALSE;
        $orgCheck = ((isset($orgStatus) && $orgStatus == 1) || (isset($collaboratorStatus) && $collaboratorStatus == 1)) ? TRUE : FALSE;
        $viewPageName = $this->uri->segment(1);
	$pageName = $this->uri->segment(2);
        $viewpage = $this->uri->segment(3);
       
 ?>
<div class="leftFixed">
 <div id='cssmenu'>
        <ul>
          <?php if($attendeeCheck){ ?>
          <li class="has-sub">
          	<a href="<?php echo getAttendeeUrl() ?>" <?php echo (($viewPageName == "currentTicket" || $viewPageName == "pastTicket" ) && $pageName == "") ? ' class="currentPage"' : ''; ?>><span class="icon icon-configer menuLeft icon2-ticket"></span>Attendee View</a>
            <ul <?php echo (($viewPageName == 'currentTicket' || $viewPageName == 'pastTicket') && $pageName == "") ? ' id="currentMenu" style="display: block"' : ''; ?>>
               
              <li><a <?php if($viewPageName == "currentTicket" ) { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-attendeeview-current');?>" class="unselected">Current Tickets</a> </li>
              <li><a <?php if($viewPageName == "pastTicket" ) { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-attendeeview-past');?>" class="unselected">Past Tickets</a>
              <li><a <?php if($viewPageName == "dashboard" && $pageName == 'mymemberships') { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('my_memberships');?>" class="unselected">My Memberships</a></li> 
              <?php if($userPPCheck == 1){ ?>
              <li><a <?php if($viewPageName == "dashboard" && $pageName == 'partialpayments') { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-partial-payments');?>" class="unselected">Partial Payments</a>
              <?php } ?>	  
              </ul>
          </li>
          <?php } ?>
          <?php if($orgCheck){?> 
          <li class="has-sub">
                <a href="<?php echo getDashboardUrl() ?>" <?php echo ($viewPageName == "dashboard" && ($pageName == "" || $pageName == "pastEventList")) ? ' class="currentPage"' : ''; ?>><span class="icon icon-event icon-configer menuLeft"></span>Organizer View</a>
            <ul <?php echo ($viewPageName == 'dashboard' && ($pageName == "" || $pageName == "pastEventList")) ? ' id="currentMenu" style="display: block"' : ''; ?>>
              <li><a <?php if($viewPageName == "dashboard" && $pageName == ""){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('dashboard-myevent');?>" class="unselected">Upcoming Events</a> </li>
              <li><a <?php if($viewPageName == "dashboard" && $pageName == "pastEventList" ) { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('dashboard-pastevent');?>" class="unselected">Past Events</a></li>
              <li><a <?php if($viewPageName == "dashboard" && $pageName == "accountmanager" && $viewpage == "" ) { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('accountManager');?>" class="unselected">Account Manager</a></li>
              <li><a <?php if($viewPageName == "dashboard" && $pageName == "subusers" && $viewpage == "" ) { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('dashboard-sub-users');?>" class="unselected">Sub Users</a></li>
              <?php if (!$associationCheck) { ?> 
              <li><a <?php if($viewPageName == "dashboard" && $pageName == "organization" ) { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('magage_organizer');?>" class="unselected">Manage Organizer Page</a></li> 
              <?php } ?> 
              <li><a href="<?php echo commonHelperGetPageUrl('features');?>" target= '_blank' class="unselected">Organizer Features</a></li>
              <li class='has-sub'><a href="<?php echo commonHelperGetPageUrl('dashboard-organizer-affliates'); ?>" <?php echo ($viewpage == "organizeraffiliates" || $viewpage == "addOrgPromoter") ? ' class="currentPage"' : ''; ?>>Affiliates</a>
            </li>
            <li><a href="<?php echo commonHelperGetPageUrl('offlineBooking');?>" target="_blank">Offline Booking</a></li>
            <li><a <?php if($viewPageName == "networking") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('networkingApp');?>" >Networking App</a></li>
            <li><a <?php if($viewPageName == "checkin") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('checkinApp');?>" >Checkin App</a></li>
            <li><a <?php if($viewPageName == "organizerevaluation") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('organizerEvaluation');?>"> Organizer Evaluation</a></li>
            </ul>
          </li>
            <li class="has-sub">
                <a><span class="icon icon-report menuLeft"></span>Reports</a>
                <ul>
                    <li><a <?php if($viewPageName == "dashboard" && $pageName == "eventssummaryreport") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('dashboard-events-summary-report');?><?php echo isset($subUserId) ? '/' . $subUserId : ''; ?>" class="unselected">Events Summary</a></li>
                    <li><a <?php if($viewPageName == "dashboard" && $pageName == "eventsdailyreport") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('dashboard-events-daily-report');?><?php echo isset($subUserId) ? '/' . $subUserId : ''; ?>" class="unselected">Events Daily</a></li>
                    <li><a <?php if($viewPageName == "dashboard" && $pageName == "eventsdailydetailreport") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('dashboard-events-daily-detail-report');?><?php echo isset($subUserId) ? '/' . $subUserId : ''; ?>" class="unselected">Events Daily Detail</a></li>
                    <li><a <?php if($viewPageName == "dashboard" && $pageName == "eventspaymentreport") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('dashboard-events-payment-report');?><?php echo isset($subUserId) ? '/' . $subUserId : ''; ?>" class="unselected">Events Payment</a></li>
                    <li><a <?php if($viewPageName == "dashboard" && $pageName == "eventsreconciliationreport") { echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('dashboard-events-reconciliation-report');?><?php echo isset($subUserId) ? '/' . $subUserId : ''; ?>" class="unselected">Events Reconciliation</a></li>
                </ul>
            </li>
          <?php } ?>
          <?php if($promoterCheck){?>
          <li class="has-sub" >
          	<a href="<?php echo getPromoterViewUrl() ?>" <?php echo ($viewPageName == "promoter") ? ' class="currentPage"' : ''; ?> ><span class="icon icon-configer menuLeft icon2-bullhorn"></span>Promoter View</a>
            <ul <?php echo ($viewPageName == 'promoter') ? ' id="currentMenu" style="display: block"' : ''; ?>>
              <li><a <?php if(($viewPageName == "promoter") && ($pageName == "currentlist")){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-promoterview-current');?>" class="unselected">Current Events</a> </li>
              <li><a <?php if(($viewPageName == "promoter") && ($pageName == "pastlist")){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-promoterview-past');?>" class="unselected">Past Events</a></li>
              <li><a <?php if(($viewPageName == "promoter") && ($pageName == "offlinebooking")){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-promoterview-offlinebooking');?>" class="unselected">Offline Booking</a></li>
			  
              </ul>
          </li>
          <?php } ?>
            <?php if ($associationCheck) { ?>
            <li class='has-sub'>
                <a href="<?php echo commonHelperGetPageUrl('association'); ?>" <?php echo ($pageName == "association") ? ' class="currentPage"' : ''; ?>><span class="icon icon2-group menuLeft"></span>Association View</a>
                    <?php if (isset($associationMenu) && $associationMenu == 1) { ?>
                        <ul <?php echo ($pageName == 'association') ? ' id="currentMenu" style="display: block"' : ''; ?>>
                            <li><a <?php echo ($pageName == "association" && $viewpage == "profile") ? 'class="currentsubLink"' : ''; ?> href="<?php echo commonHelperGetPageUrl('association_profile') . "/" . $associationId; ?>" class="unselected">Manage Association</a> </li>
                            <li><a <?php echo ($pageName == "association" && $viewpage == "chapters") ? 'class="currentsubLink"' : ''; ?> href="<?php echo commonHelperGetPageUrl('association_chapters') . "/" . $associationId; ?>" class="unselected">Manage Chapters</a></li>
                            <li><a <?php echo ($pageName == "association" && $viewpage == "membershiptypes") ? 'class="currentsubLink"' : ''; ?> href="<?php echo commonHelperGetPageUrl('association_membershiptypes') . "/" . $associationId; ?>" class="unselected">Manage Membership Types</a></li>
                            <li><a <?php echo ($pageName == "association" && $viewpage == "customfields") ? 'class="currentsubLink"' : ''; ?> href="<?php echo commonHelperGetPageUrl('association-custom-fields') . "/" . $associationId; ?>" class="unselected">Manage Custom Fields</a></li>
                            <li><a <?php echo ($pageName == "association" && $viewpage == "members") ? 'class="currentsubLink"' : ''; ?> href="<?php echo commonHelperGetPageUrl('association_members') . "/" . $associationId; ?>" class="unselected">Manage Members Directory</a></li>
                            <li><a <?php echo ($pageName == "association" && $viewpage == "terms") ? 'class="currentsubLink"' : ''; ?> href="<?php echo commonHelperGetPageUrl('association_terms_conditions') . "/" . $associationId; ?>" class="unselected">Terms and Conditions</a></li>
                        </ul>
                    <?php } ?>
              </li>
          <?php } ?>
        </ul>
		
      </div>
      <div class="sidebar-full-height-bg"></div>
 </div>
