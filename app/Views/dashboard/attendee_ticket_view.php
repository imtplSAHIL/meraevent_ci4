<?php
$eventCount = count($eventList);
if($pageType == "current")
{
	$currentClass = "selected";
	$pastClass = "";
	$currentTotal = "( ".$eventCount." )";
	$pastTotal = "";
}
else if($pageType == "past")
{
	$currentClass = "";
	$pastClass = "selected";
	$pastTotal = "( ".$eventCount." )";
	$currentTotal = "";
}

?>
<div id="preloader" style="display:none;"><div class="bg"></div></div>
<div class="rightArea">
  <h3>Attendee View</h3>
  
   <div>
        <ul class="tabs" data-persist="true">
            <li class="<?php echo $currentClass;?>"><a href="<?php echo commonHelperGetPageUrl('user-attendeeview-current');?>">Current Tickets <?php echo $currentTotal;?></a></li>
            <li class="<?php echo $pastClass;?>"><a href="<?php echo commonHelperGetPageUrl('user-attendeeview-past');?>">Past Tickets <?php echo $pastTotal;?></a></li>
           <!--  <li><a href="<?php echo commonHelperGetPageUrl('user-attendeeview-referal');?>">Referral Bonus</a></li>-->
        </ul>
        <div class="tabcontents">
            <div id="view1">
			<?php
				if($eventCount > 0 )
				{
				$uloop = 1;
				$eventMonthName ="";
				foreach($eventList as $event)
				{
					$eventMonthDiv = "";
				 	$eventMonth = $event['eventMonth'];
					$eventName = $event['eventName'];
					$eventName = (strlen($eventName) > 30) ? substr($eventName,0,30)."..." : $eventName;
					$eventId = ($event['multiEvent'] == TRUE && $event['multiEventParentId'] > 0)?$event['multiEventParentId']:$event['eventId'];
					$quantity = $event['quantity'];
					$totalAmount = $event['totalAmount'];
					$currencyCode =  $event['currencyCode'];
					$eventStartDate = $event['signupdate'];
					$txnType = (isset($event['txnType'])) ? $event['txnType'] : "";
					$divClass = ($uloop%2 ==0) ? "boxTeal" : "";
					$divClass = ($uloop%3 == 0) ? "boxLightTeal" : "";
					
					if(strcmp($eventMonthName,$eventMonth) != 0)
					{
						$eventMonthName = $eventMonth;
					 	$eventMonthDiv = "<h6>".$eventMonth."</h6>";	
						if($uloop > 1)
						echo '<div class="clearBoth"></div>';
						
						$uloop =1;
					}
					
			
			?>
			<?php echo $eventMonthDiv;
                        $totalAmount = $event['totalAmount'];
                        ?>
			<div class="db_Eventbox">
				
				<div class="fs-db_Eventbox-content pb-10imp">
					<h4 class="db-attendview-title"> <?php echo $eventName; ?></h4>
					<div class="fs-event-place-time">
	                	<div class="fs-event-start-date float-left"> 
	                		<span class="icon2-clock-o"></span>
	                		<span><?php echo $eventStartDate;?></span> 
	                	</div>
	                	
	            	</div>
				</div>
				
					
					<!--<div class="db_Eventbox_section">
						 
						  <div class="fs-ticket-management-buttons">
						  	  <div class="ticketsId">
						      		<p>Event ID: <strong> <?php echo $eventId;?> </strong></p>
						      </div>
						      <div class="fs-tickets-reg-no">
							      <p>
						      			<span class="icon-duplicate"></span> Reg No: <strong><?php echo $event['eventSignupId'];?></strong>
						      	  </p>
						      </div>
						  </div>
						  <div class="ticketsBooked">
						    <h5>Paid</h5>
						  	<div class="fs-total-amount"> <?php  if($totalAmount>0){ echo $currencyCode." "; } echo $totalAmount;?></div>
						  </div> 
					</div>-->
				    <!--<div  class="db_Eventbox_footer"> 
				    	<a class="fs-btn" href="printpass/<?php echo $event['eventSignupId'];?>" target="_blank"><span class="icon-manage" ></span>Email/Print Pass </a>
				    	  
				    </div>-->
				 <!--</div> -->


				 <div class="db-attendview-stats">
                              <ul>
                               
                                <li>
                                    <span>REG NO</span>
                                    <h5><?php echo $event['eventSignupId'];?></h5>
                                </li>
                                <li>
                                    <span>PAID</span>
                                    <h5><?php
                                        if($totalAmount>0){
                                            if($event['mediscountid'] != 0){
                                                echo $currencyCode." ".($totalAmount-$event['mediscountamount']);
                                            } else {
                                                echo $currencyCode." ".$totalAmount;
                                            }
                                        } else {
                                            echo $totalAmount;
                                        }
                                        ?>
                                    </h5>
                                </li>
                                 <li class="db-noborder">
                                    <span>QUANTITY</span>
                                    <h5><?php echo $quantity;?>  </h5>
                                </li>
                            </ul>
                 </div>


                 <div class="db_Eventbox_footer">
                 	<div class="fs-event-quantity float-left">  
	                		<strong>EVENT ID : <?php echo $eventId;?></strong>
	                	</div>

	                <div class="float-right">
                            <?php 
                          
                                if($event['stagedevent'] == 1) {
                                    if($event['paymentstage'] == 1 ){
                                        if($event['stagedstatus'] == 1){
                            ?>
                                <span class="fs-btn dark-btn-color" >Yet to Approve</span>
                            <?php
                                        }else if($event['stagedstatus'] == 2){
                                         ?>
                                <a class="fs-btn dark-btn-color" href="printpass/<?php echo $event['eventSignupId'];?>" target="_blank"><span class="icon-print" ></span>Email / Print Pass </a>
                                         <?php 
                                        }elseif($event['stagedstatus'] == 3 ){
                                        ?>
                                    <span class="fs-btn dark-btn-color" >Transaction Rejected</span>    
                                        <?php
                                    }
                                    }elseif($event['paymentstage'] == 2 ){
                                        if($event['stagedstatus'] == 1){
                            ?>
                                <span class="fs-btn dark-btn-color" >Yet to Approve</span>
                            <?php
                          
                                
                                        }else if($event['stagedstatus'] == 2 ){
                                            if($event['transactionstatus'] == 'success' && !in_array($event['paymentstatus'],array('Refunded','Canceled')) ){
                                         ?>
                                <a class="fs-btn dark-btn-color" href="printpass/<?php echo $event['eventSignupId'];?>" target="_blank"><span class="icon-print" ></span>Email / Print Pass </a>
                                         <?php 
                                            }else{
                                         ?>
                                <span class="fs-btn dark-btn-color" >Approved but payment is not done</span>
                                    <?php
                                            }
                                        }elseif($event['stagedstatus'] == 3 ){
                                        ?>
                                    <span class="fs-btn dark-btn-color" >Transaction Rejected</span>    
                                        <?php
                                    }
                                        
                                    }
                            } else if($event['transactionstatus'] == 'success' && !in_array($event['paymentstatus'],array('Refunded','Canceled')) ){ ?>
                                <a class="fs-btn dark-btn-color" href="printpass/<?php echo $event['eventSignupId'];?>" target="_blank"><span class="icon-print" ></span>Email / Print Pass </a>
                            <?php }else{
                                ?>
                                <span class="fs-btn dark-btn-color" >Transaction failed / payment issue</span>    
                                <?php
                            } ?>     
	                </div>
                 </div>


			</div>
  					
					<?php
					if($uloop%2 == 0) { ?><div class="clearBoth"></div><?php }
					$uloop++;
				}
			}else{
				
				echo "<h6>No Tickets booked Yet</h6>";
			}
		?>
   
            </div>
        </div>
    </div>
</div>
