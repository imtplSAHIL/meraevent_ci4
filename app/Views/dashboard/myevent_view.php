<?php
$eventCount = count($eventList);
if ($pageType == "upcoming") {
    $currentClass = "selected";
    $pastClass = "";
   $totalEventCount= isset($totalEventCount)?$totalEventCount:0;
    $currentTotal = "( <span id='totalcount'>" .$totalEventCount. "</span> )";
    $pastTotal = "";
    $message = $this->customsession->getData('message');
    $publishedLink = $this->customsession->getData('eventLink');
} else {
    $currentClass = "";
    $pastClass = "selected";
    $totalEventCount= isset($totalEventCount)?$totalEventCount:0;
    $pastTotal = "( <span id='totalcount'>" . $totalEventCount . " </span>)";
    $currentTotal = "";
}
//print_r($eventList);exit;
?>
<div class="rightArea rightbg">
  <div class="searchBox">
                        <div class="search-container">
                            <input class="search icon-search"
                                   id="dashboard_search" type="search"
                                   placeholder="Search" value="<?php echo $searchword;?>"  onsearch="OnSearch(this)">
                            <a class="search icon-search cleareventsearch" id="searchicon"></a> 
                        </div>

                    </div>
    <input type="hidden" id="page" name="page" value="<?php echo $page;?>"/>
    <input type="hidden" id="pageType" name="pageType" value="<?php echo $pageType;?>"/>
    <?php if($this->session->flashdata('message')){ ?>
    <div class="db-alert db-alert-danger"><?php echo $this->session->flashdata('message'); ?></div>
    <?php } ?>
    <h3>Organizer View</h3>
    <div class="dbalert db-success hide" id="publishMsg" <?php if (isset($message) && strlen($message)>0) { ?>style="display: block;" <?php } else { ?> style="display: none;"<?php } ?>><?php echo $message; if(isset($publishedLink) && !empty($publishedLink)){ ?> <a target="_blank" style="color:#ba36a6;" href="<?php echo $publishedLink; ?>">  Click Here  </a> <?php } $this->customsession->unSetData('eventLink');$this->customsession->unSetData('message');?> </div>
    <div style='display:none' class="db-alert db-alert-danger" id="publishDateError"></div>
    <div>
        <ul class="tabs" data-persist="true">
            <li class="<?php echo $currentClass; ?>"><a href="<?php echo commonHelperGetPageUrl('dashboard-myevent'); ?>" class="eventtypes" >Upcoming Events <?php echo $currentTotal; ?></a></li>
            <li class="<?php echo $pastClass; ?>"><a href="<?php echo commonHelperGetPageUrl('dashboard-pastevent'); ?>" class="eventtypes" >Past Events <?php echo $pastTotal; ?></a></li>
            <li>
            
            
            </li>
        </ul>
        
        <div class="tabcontents">
                <h6 id='no-events' style="display: none"> There are <span id="eventscount"></span> events found for the searched keyword:<span id='searchkeyword'></span> </h6>
            <div id="upcoming-eventview">
                <?php
                if ($eventCount > 0) {
                    $uloop = 1;
                    $eventMonthName = "";
                    
                    foreach ($eventList as $event) {

                        $eventMonthDiv = "";
                        $eventMonth = $event['eventMonth'];
                        $eventId = $event['eventId'];
                        $allAccess = true;
                        $manageURL = commonHelperGetPageUrl('dashboard-eventhome', $eventId);
                        $collaborativeEventIds = array_keys($collaborativeEventData);
                        
                        
                        if (in_array($eventId, $collaborativeEventIds) && !in_array("manage", $collaborativeEventData[$eventId])) {
                            $allAccess = false;
                        }
                        if (in_array($eventId, $collaborativeEventIds) && in_array("promote", $collaborativeEventData[$eventId])) {
                            $manageURL = commonHelperGetPageUrl('dashboard-list-discount', $eventId);
                        } elseif (in_array($eventId, $collaborativeEventIds) && in_array("report", $collaborativeEventData[$eventId])) {
                            $manageURL = commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&all&1');
                        }
                        if (in_array($eventId, $collaborativeEventIds) && (in_array("promote", $collaborativeEventData[$eventId]) || in_array("report", $collaborativeEventData[$eventId])) && $event['masterevent'] == TRUE) {
                            $manageURL = commonHelperGetPageUrl('dashboard-eventhome', $eventId);
                        }
                        $reportsURL = commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&all&1');
                        if (in_array($eventId, $collaborativeEventIds) && !in_array("report", $collaborativeEventData[$eventId])) {
                            $reportsURL = 'javascript:;';
                        }
                        $eventName = $event['eventName'];
                        $eventName = (strlen($eventName) > 30) ? substr($eventName, 0, 30) . "..." : $eventName;
                        $soldOutTickets = $event['soldOutTickets'];
                        $eventCityName = $event['eventCityName'];
                        $eventCountryName = $event['eventCountryName'];
                        $eventPublishStatus = "Publish";
                        $titleColorClass='fs-unpublished-event';
                        $eventunpublishStatus = "UnPublished";
                        if($event['eventStatus'] == 1 ){
                           $eventPublishStatus= "Unpublish";
                           $titleColorClass='';
                           $eventunpublishStatus="published";
                        }
                        $eventUrl = $event['url'];
                        $eventStartDate =  $event['eventStartDate'];
                        $eventEndDate =  $event['eventEndDate'];
                        $divClass = ($uloop % 2 == 0) ? "boxTeal" : "";
                        $divClass = ($uloop % 3 == 0) ? "boxLightTeal" : "";
                        if (strcmp($eventMonthName, $eventMonth) != 0) {
                            $eventMonthName = $eventMonth;
                            $eventMonthDiv = "<h6 class='".$eventMonth." event-months'>" . $eventMonth . "</h6>";
                             if ($uloop > 1){
                                echo '<div class="clearBoth"></div>'; 
                             }
                            $uloop = 1;
                        }
						 if ($event['eventStatus'] == 1){
								// $pageSiteUrl .'event/'.$eventUrl . '?ucode=organizer'; 
								$Url = commonHelperGetPageUrl('event-detail','',$eventUrl.'?ucode=organizer');
								 }
							    else{	 
								$Url =  commonHelperGetPageUrl('event-preview','','?view=preview&eventId=' . $eventId); 
								}
                        ?>

                        <?php echo $eventMonthDiv; ?>

                        <div class="db_EventboxNew EventTitleholder <?php echo $titleColorClass;?> grid-lg-4 grid-md-6 grid-sm-6 grid-xs-12" eventid="<?php echo $eventId;?>" eventtitle= "<?php echo preg_replace('/[^A-Za-z0-9?!]/','',$eventName);?>" eventmon = "<?php echo $eventMonthName;?>">
                            
                            
                            <!--Event id & Venue-->
                            <div class="EventIDHolder">
                                <div class="db_EventID">EVENT ID : <a class="ticketsId <?php echo 'previewURL_'.$eventId;?>" href="<?php echo $Url; ?>" target="_blank"><?php echo $eventId; ?></a> 

                                <?php if(in_array($eventId, $collaborativeEventIds) || $event['private'] == 1){ ?>
                                <div class="gridview-btn-holder">
                                
                                <?php if ( in_array( $eventId, $collaborativeEventIds ) ) { ?> <span class="collaboratebtn-db"><!-- class="collboator_event" -->
                                    Collaborator
                                </span> <?php } ?>
                                
                                    <?php if($event['private'] == 1 ){ ?>
                                        <span class="privatebtn-db">Private</span>
                                    <?php } ?>
                                
                                </div>
                                <?php } ?>
                                </div>
                                
                                <div class="db_DateTime">
                                    <span><i class="fa fa-calendar"></i> <?php echo $eventStartDate." - ".$eventEndDate.' '.$event['timezone']; ?></span>
                                    <?php if ($event['parenteventid'] == 0 && $event['masterevent'] == 0 && $event['eventmode'] == 1){ ?>
                                    <span><i class="fa fa-wifi"></i> <a href="<?php echo commonHelperGetPageUrl('dashboard-enableExternalMeetingLink', $eventId); ?>">Setup Your Online Event</a></span>
                                    <?php } else { ?>
                                        <span><a target="_blank" href="https://maps.google.com/maps?saddr=&daddr='+'<?php echo $event['fullAddress'];?>'"><i class="fa fa-map-marker"></i> <?php echo (!empty($eventCityName) ? $eventCityName . ', ' : '').$eventCountryName ; ?></a></span>
                                    <?php } ?>
                                </div>
                                <div class="db-public-status">
                                    <?php if (((in_array( $eventId, $collaborativeEventIds) && in_array("manage", $collaborativeEventData[$eventId])) || !in_array( $eventId, $collaborativeEventIds)) && $pageType == "upcoming") { ?>
                                    <a title="Edit Event" class="tooltip-left hoeverclass" data-tooltip="Edit Event" href="<?php echo $event['editUrl']; ?>"><span class="fa fa-edit gridview-edit"></span></a>
                                    <?php } ?>
                                    <?php if((!in_array( $eventId, $collaborativeEventIds)) && $event['soldOutTickets'] == 0){ ?>
                                    <a title="Delete Event" class="tooltip-left hoeverclass" data-tooltip="Delete Event" onclick="deleteEvent('<?php echo $eventId; ?>')" href="javascript:void(0);"><span class="fa fa-trash gridview-delete" ></span></a>
                                    <?php } ?>
                                </div>

                            </div>
                            <!--Event id & Venue--> 
                            
                             <div class="title-ribbon title-both-ribbon">
                                <h2><a class="showeventbox <?php echo 'previewURL_'.$eventId;?>" href="<?php echo $Url; ?>" target="_blank" title="<?php echo $event['eventName']; ?>">
                                     <?php echo $eventName; ?>
                                 </a></h2>
                             </div>  
                        <?php if($event['parenteventid'] == 0 && $event['masterevent'] == 0){ ?> 
                            <div class="Event-GridHolder">                               
                                <div class="grid-lg-6 grid-xs-6 nopadding">
                                    <span>TICKETS SOLD</span>
                                        <a class="showeventbox" href="<?php echo $reportsURL ?>">
                                            <?php if($eventList[$eventId]['soldOutTickets'] > 0){ ?>
                                            <?php $count=1; ?>
                                            <?php foreach($event['transactionCurrency'] as $currCode=>$paidAmt){
                                            if(strpos($currCode,'quantity') == FALSE){ ?>
                                            <p class="<?php echo $eventId; ?>" id="q_<?php echo $currCode."_".$eventId; ?>" <?php if($count != 1){ ?>hidden<?php } ?>><?php echo $event['transactionCurrency'][$currCode."quantity"] > 0 ? $event['transactionCurrency'][$currCode."quantity"] : "0" ; ?></p>
                                            <?php 
                                            $count++;
                                                }
                                            } ?> 
                                            <?php }else { echo "<p>0</p>"; } ?>
                                        </a>
                                 </div>
                                 <div class="grid-lg-6 grid-xs-6 nopadding">
                                     <span>TOTAL SALES </span>
                                     <?php 
                                    if(isset($event['transactionCurrency']) && count($event['transactionCurrency']) > 1){ ?>
                                     
                                        <label class="icon-downarrow curdropdown">
                                            <select id="dropdowncur_<?php echo $eventId; ?>" onChange="showValue(this,'<?php echo $eventId; ?>')" class="db-currencydropdown">
                                               <?php foreach($event['transactionCurrency'] as $currCode=>$paidAmt){
                                                      if(!strpos($currCode,'quantity')){ ?>
                                                 <option value="<?php echo $currCode."_".$eventId; ?>"><?php echo $currCode; ?></option>
                                                      <?php }
                                                      } ?>
                                             </select>
                                        </label>
                                        <a class="showeventbox" href="<?php echo $reportsURL ?>">
                                        <?php if($eventList[$eventId]['soldOutTickets'] > 0){ ?>
                                        <?php $count = 1 ; ?>
                                        <?php foreach($event['transactionCurrency'] as $currCode=>$paidAmt){ ?>
                                       <?php if(!strpos($currCode,'quantity')){ ?>
                                            <p class="<?php echo $eventId; ?>" id="a_<?php echo $currCode."_".$eventId; ?>" <?php if($count != 1){ ?>hidden<?php } ?>><?php if($currCode == 'ALL'){echo $event['totalCurrency'];}elseif($currCode != 'FREE'){echo $currCode;}?> <?php echo (!empty($paidAmt)) ? $paidAmt: "0"; ?></p>
                                        <?php $count++ ;
                                            }
                                        } ?> 
                                        <?php }else { echo $eventList[$eventId]['soldOutTickets']; } ?>
                                        </a>
                                    <?php }else{?>
                                        <a class="showeventbox" href="<?php echo $reportsURL ?>">
                                            <p>0</p>
                                        </a>
                                    <?php } ?>
                                 </div>     
                            </div>    
                        <?php }else{ ?>
                         <div class="Event-GridHolder">    
                            <div class="grid-lg-12 grid-xs-12 nopadding">
                                <a href="<?php echo $manageURL; ?>" class="showeventbox viewmultidate-grid">
                                    <p class="viewmultidate-btn">Multiple Events</p>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                            

                             
                                 <div class="db-eventview-controls">
                                <ul>
                                    <li class="grid-lg-6 grid-sm-6 grid-xs-6 nopadding">
                                    <a href="<?php echo $manageURL; ?>">
                                        <h5><span class="fa fa-dashboard"></span> Event Dashboard</h5></a>
                                    </li>
                                    
                                    
                                    <li class="grid-lg-6 grid-sm-6 grid-xs-6 nopadding">
                                    <a class="<?php echo 'previewURL_'.$eventId;?>" href="<?php echo $Url; ?>" target="_blank"><h5><span class="icon2-eye"></span> Preview</h5></a>
                                    </li>
                                    <?php if ($allAccess && $event['parenteventid'] == 0 && $event['masterevent'] == 0) { ?>
                                        <li class="grid-lg-6 grid-sm-6 grid-xs-6 nopadding">
                                        <a onclick="copyEvent('<?php echo $eventId; ?>')" href="javascript:void(0);"><h5><span class="icon2-copy"></span> Duplicate</h5> </a>
                                        </li>
                                                             <?php } ?>
                                     <input type='text' hidden="hidden" value='<?php echo $event['ActualeventStartDate'];?>' id="<?php echo $eventId . "eventStartDate"; ?>">
                                    <?php if ($allAccess ) { 
                                                if(strlen($currentClass)>0){
                                            ?>
                                   <li class="grid-lg-6 grid-sm-6 grid-xs-6 nopadding">
                                        <a onclick="changeEventStatus('<?php echo $Url; ?>','<?php echo $eventId; ?>');" href="javascript:void(0);" class="db-noborder">

                                            <h5 id="<?php echo $eventId; ?>publishStatusText"><span class="icon2-times-circle-o"></span><?php echo $eventPublishStatus; ?></h5>
                                        </a>
                                    </li>
                                    <?php }else{?>
                                    <li class="grid-lg-6 grid-sm-6 grid-xs-6 nopadding">
                                    <a onclick="changeEventStatus('<?php echo $Url; ?>','<?php echo $eventId; ?>');" href="javascript:void(0);" class="db-noborder">
                                        <span class="icon2-times-circle-o"></span>
                                        <h5 id="<?php echo $eventId; ?>publishStatusText"><?php echo $eventunpublishStatus; ?></h5>
                                    </a>
                                    </li>
                                    <?php } ?>
                                    <?php }?>
                                     
                                </ul>
                             </div>
                        </div>
                <?php 
                        $uloop++;
                    }
                }else{
                	echo '<h6 id="no-results"> There are no events in the dashboard </h6>';
                }
                ?>
            </div>
           <?php   if($totalEventCount>EVENTS_DISPLAY_LIMIT){?>
                    <a id="viewMore" class="fs-inline-btn fs-btn" >View More</a>
                <?php }?>
        </div>
    </div>
</div>
<div class="clearBoth"></div>
<script>
$(function(){
    $('.db_Eventbox').matchHeight();

});
</script>
<div id="popup1" style="display:none;">
	<div class="db-popup">
		<div class="db-closeholder"><a class="db-close" href="#">&times;</a></div>
		<div class="db-popupcontent">
			<div class="sweet-alert showSweetAlert"> 
	 				<div class="sa-icon sa-warning pulseWarning" style="display: block;">
	 			      <span class="sa-body pulseWarningIns"></span>
	 			      <span class="sa-dot pulseWarningIns"></span>
	 			    </div> 
	 			    <h2 id="publishOrUnpublishTxt">Are you sure?</h2>
	   <!--<p style="display: block;">You will not be able to undo this action!</p>   -->
	   <div class="sa-button-container">
	         <button class="confirm confirmbtn" style="" id="yesButton">Yes</button>
	      <div class="sa-confirm-button-container">
	      <button class="cancel" style="display: inline-block; box-shadow: none;">Cancel</button>         
	 			      </div>
	 			   </div>  				 
			</div>

		</div>
	</div>
</div>
<div id="popup2" style="display:none;">
	<div class="db-popup">
		 
		<div class="db-closeholder"><a class="db-close" href="#">&times;</a></div>
		<div class="db-popupcontent">
			
			<div class="sweet-alert showSweetAlert"> 
				 
	 				<div class="sa-icon sa-warning pulseWarning" style="display: block;">
	 			      <span class="sa-body pulseWarningIns"></span>
	 			      <span class="sa-dot pulseWarningIns"></span>
	 			    </div> 
	 			    <h2 id="copyTxt">Are you sure?</h2>
	   <!--<p style="display: block;">You will not be able to undo this action!</p>   -->
	   <div class="sa-button-container">
	         <button class="confirm confirmbtn" style="" id="yesCopyButton">Yes</button>
	      <div class="sa-confirm-button-container">
	      <button class="cancel" style="display: inline-block; box-shadow: none;">Cancel</button>         
	 			      </div>
	 			   </div>  				 
			</div>

		</div>
	</div>
</div>
<div id="popup3" style="display:none;">
    <div class="db-popup">
         
        <div class="db-closeholder"><a class="db-close" href="#">&times;</a></div>
        <div class="db-popupcontent">
            
            <div class="sweet-alert showSweetAlert"> 
                 
                    <div class="sa-icon sa-warning pulseWarning" style="display: block;">
                      <span class="sa-body pulseWarningIns"></span>
                      <span class="sa-dot pulseWarningIns"></span>
                    </div> 
                    <h2 id="deleteTxt">Are you sure?</h2>
       <!--<p style="display: block;">You will not be able to undo this action!</p>   -->
       <div class="sa-button-container">
             <button class="confirm confirmbtn" style="" id="yesDeleteButton">Yes</button>
          <div class="sa-confirm-button-container">
          <button class="cancel" style="display: inline-block; box-shadow: none;">Cancel</button>         
                      </div>
                   </div>                
            </div>

        </div>
    </div>
</div>
                                    <style>
                                    .modal{
										position: fixed;
										top: 0;
										right: 0;
										bottom: 0;
										left: 0;
										z-index: 1050;
										background-color: rgba(136, 136, 136, 0.4);
									}
                                    </style>