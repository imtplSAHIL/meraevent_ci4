<?php
$divClass = 'col-sm-7 col-xs-12 col-md-8';
$divStyle = '';
$eventId =$eventData['id'];
$configCustomDatemsg = json_decode(CONFIGCUSTOMDATEMSG,true);
$configCustomTimemsg =  json_decode(CONFIGCUSTOMTIMEMSG,true);
$configspecialTickets = json_decode(SPECIALTICKETS,true);
$customValidationEventIds = json_decode(CUSTOMVALIDATIONEVENTIDS,true);
$configspecialTickets = isset($configspecialTickets[$eventId])?$configspecialTickets[$eventId]:array();

$royalOperaSeatingEventIds = $this->config->item('royalOperaSeatingEvents');
//var_dump (in_array('85244', $royalOperaSeatingEventIds) ); exit;
$GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY;

$eventTitleColor = '';
$headingBackgroundColor = '';
$ticketTextColor = '';
$bookNowBtnColor = '';
//die(var_dump($eventData['isMeraeventsDiscount']));
if ($ticketWidget == 'Yes') {
    $divClass = 'col-sm-12 col-xs-12 col-md-12';
    $divStyle = 'padding-left:0px;padding-right:0px;overflow:hidden;';
    $wCodeArray = explode('-', $wCode);

    $eventTitleColor = $wCodeArray[0];
    $headingBackgroundColor = $wCodeArray[1];
    if(strtolower($wCodeArray[2]) != 'ffffff'){
        $ticketTextColor = $wCodeArray[2];
    }else{
        $ticketTextColor = $wCodeArray[1];
    }
    $bookNowBtnColor = $wCodeArray[3];
    $limitSingleTicketType = $eventData['eventDetails']['limitSingleTicketType'];?>
    <input type="hidden" name="limitSingleTicketType" id="limitSingleTicketType" value="<?php echo $limitSingleTicketType;?>">
    <?php if($showTitle || $showDateTime || $showLocation){ ?>
        <div class="<?php echo $divClass; ?>" style="<?php echo $divStyle; ?>">
            <div class="row <?php echo preg_replace("/[^a-zA-Z]/", "", strtolower($eventData['categoryName'])) ?>" style="<?php if ($headingBackgroundColor != '') echo 'background:' . '#' . $headingBackgroundColor . ';'; ?>">
                <div class="img_below_cont ">
                    <h1 style="<?php if ($eventTitleColor != '') echo 'color:' . '#' . $eventTitleColor . ';'; ?>"><?php echo (isset($eventData['title']) && $showTitle)?$eventData['title']:'';?></h1>
                    <?php if($showDateTime){ ?>
                        <div class="sub_links"><span class="icon-calender"></span>
                            <?php
                            if(isset($configCustomDatemsg[$eventId]) && !isset($configCustomTimemsg[$eventId])){
                                echo $configCustomDatemsg[$eventId]." | ".allTimeFormats($eventData['startDate'],4).' to '.allTimeFormats($eventData['endDate'],4).' '.$eventData['location']['timezone'];
                            }else if(isset($configCustomTimemsg[$eventId]) && !isset($configCustomDatemsg[$eventId])){
                                echo allTimeFormats($eventData['startDate'],3);?><?php if (allTimeFormats($eventData['startDate'],9) != allTimeFormats($eventData['endDate'],9))  { echo " - ". allTimeFormats($eventData['endDate'],3);} echo " | ".$configCustomTimemsg[$eventId];
                            }else if(isset($configCustomTimemsg[$eventId]) && isset($configCustomDatemsg[$eventId])){
                                echo $configCustomDatemsg[$eventId]." | ".$configCustomTimemsg[$eventId];
                            }else{
                                echo allTimeFormats($eventData['startDate'],3);?><?php if (allTimeFormats($eventData['startDate'],9) != allTimeFormats($eventData['endDate'],9))  { echo " - ". allTimeFormats($eventData['endDate'],3);} echo " | ".allTimeFormats($eventData['startDate'],4).' to '.allTimeFormats($eventData['endDate'],4).' '.$eventData['location']['timezone'];
                            }  ?>
                            </span></div>
                    <?php } ?>
                    <?php if($showLocation && $eventData['eventMode'] == 0){ ?>
                        <div class="sub_links"> <span class="icon-google_map_icon"></span><span><?php echo $eventData['fullAddress']; ?></span></div>
                    <?php } ?>
                </div>
            </div>
        </div>
		<?php } ?>
        <?php } ?>
<input type="hidden" name="eventId" id="eventId" value="<?php if($multiEvent == TRUE){echo $multiEventId; }else{echo $eventData['id'];} ?>">
<input type="hidden" name="referralCode" id="referralCode" value="<?php echo $referralCode; ?>">
<input type="hidden" name="promoterCode" id="promoterCode" value="<?php echo $promoterCode; ?>">
<input type="hidden" name="pcode" id="pcode" value="<?php echo $pcode; ?>">
<input type="hidden" name="acode" id="acode" value="<?php echo $aCode; ?>">
<input type="hidden" name="rCode" id="rCode" value="<?php echo $rCode; ?>">
<input type="hidden" name="ticketWidget" id="ticketWidget" value="<?php echo $ticketWidget; ?>">
<input type="hidden" id="multiEvent" value="<?php echo ($multiEvent)? '1': '0' ; ?>">
<?php if (count($ticketDetails) > 0) { ?>
<div id="useracco" class="<?php echo $divClass; ?> event_left_cont" style="<?php echo $divStyle; ?>">



<?php if($multiEvent == TRUE && count($multiEventList) > 0){ ?>
<!-- Multi Date Calender View -->
<div class="multidate-calendar-container">
   <div class="multidate-calendar">

     <!-- Start of Date Calender for Multidate -->
      <div class="multidate-calendar-datewidget multidate-leftcal">        
         <div>
            <input type="hidden" class="form-control" id="multiDates-datePickerLeft" readonly="readonly">
             <a class="multidate-anchor" id="multiDates-datePickerLeftAnchor">
                <i class="icon2-calendar-check-o"></i>
             </a>
         </div>
      </div>
      <div class="multidate-calendar-datewidget multidate-rightcal">
        <div>
            <input type="hidden" class="form-control" id="multiDates-datePickerRight" readonly="readonly">
             <a class="multidate-anchor" id="multiDates-datePickerRightAnchor">
                 <i class="icon2-calendar-check-o"></i>
             </a>
         </div>
      </div>
      <!-- End of Date Calender for Multidate -->


      <!-- Start of Dates List View -->  
      <div class="multidate-calendar-holder">
        <?php foreach($multiEventList as $data): ?>
          <?php $mestartdate = allTimeFormats($data['startDateTime'], 11); $mtdate = new DateTime($mestartdate); ?> 
         <div class="multidate-cell <?php if($multiEventId == $data['eventId']){ echo 'multidate-selected'; } ?>">
               <div class="multidate-cell-content">
                <?php if($pageType != 'preview'){
                 $pageUrl = commonHelperEventDetailUrl($multiEventUrl); 
                }
                if($data['eventId'] != $eventId && $pageType != 'preview'){
                 $pageUrl .= '/'.$data['eventId']; 
                } 
                if(isset($getParams) && strlen($getParams) > 1){
                    $pageUrl .= '?'.$getParams;
                }

                ?>
                <?php if($pageType == 'preview'){
                    $pageUrl = commonHelperGetPageUrl('event-preview','','?view=preview&eventId='.$eventId.'&sub='.$data['eventId']);
                }?>
                <a href = "<?=$pageUrl;?>">
                    <div class="multidate-month"><?php echo $mtdate->format('M'); ?></div>
                    <div class="multidate-date"><?php echo $mtdate->format('j'); ?></div>
                    <div class="multidate-year"><?php echo $mtdate->format('Y'); ?></div>
                </a>
            </div>
         </div>
        <?php endforeach; ?>  
        
      </div>
      <!-- End of Dates List View -->


   </div> <!-- End of multidate-calendar -->
</div><!--End of multidate-calendar-container -->



    <!-- Multi Date Calender View -->
<?php } ?>

    <?php if($ticketGroupStatus){ echo '<div class="marginbottom30">'; }else{ echo '<ul>';} ?>


        <?php if (count($ticketDetails) > 0) {
            $ticketids = $nowdate = "";
            $soldoutTickets = array();
            $comingSoonTickets = array();
            if(isset($ticketGroups) && !empty($ticketGroups)){
                $i=0;
                foreach ($ticketGroups as $key => $value) {
                    if(isset($value['name'])){
                        ?>
                        <?php if($ticketGroupStatus){ ?>
                            <div class="widget-ticketgroup homepage" data-id='<?php echo $value["id"] ?>' data-maxcat='<?php echo $value["maxticketcategories"] ?>'>
                        <?php } ?>
                            <?php
                            $evenData=$value['tickets'];
                            if(isset($value['name'])){
                                ?>

                                <div class="widget-acc-btn-home" class="widget-grouptitle" <?php if($value['name'] ==''){ echo "style='display:none;'";}?>><p class="selected"><i class="icon2-angle-right"></i> <?php echo ucwords($value['name']); ?></p></div>
                            <?php } ?>

                            <?php if($ticketGroupStatus){ ?>
                            <?php if($value['name'] ==''){?> 
                                <div style="height: auto; /* display: inline; */ margin-top: 10px; width: 100%; border-top: 1px solid #d9d9d9;">
                            <?php }else{ ?>
                                <div class="widget-acc-content-home <?php echo $i==0 ? 'widget-open': '';?>">
                            <?php } ?>


                                
                                <div class="widget-acc-content-home-inner-home">
                                    <?php if($value["maxticketcategories"] > 0) { ?>
                                <div class="selected" style="padding: 10px 20px 10px 10px;color: #999;display: inline-block;font-size: 12px;width: 100%;"><i class="icon2-info-circle"></i> You can select maximum <?php echo $value["maxticketcategories"]?> ticket categor<?php echo $value["maxticketcategories"] > 1 ? 'ies' : 'y'?>  in this group</div>
                                <?php } ?>
                                    <?php } ?>
                                    <?php
                                    if(isset($evenData) && !empty($evenData)){
                                        $soldoutTicketsByGroup=$comingSoonTicketsByGroup=array();
                                        foreach ($evenData as $ticket) {
                                            $ticket=$ticketDetails[$ticket['ticketid']];
                                            if(isset($ticket) && !empty($ticket)){
                                                $nowdate = strtotime(nowDate($eventData['location']['timeZoneName']));
                                                $startdate = strtotime($ticket['startDate']);
                                                $enddate = strtotime($ticket['endDate']);
                                                $lastdate = $ticket['endDate'];
                                                if ($ticket['soldout'] == 1 || $enddate < $nowdate) {
                                                    $soldoutTickets[] = $ticket;
                                                    $soldoutTicketsByGroup[] = $ticket;
                                                } else if ($startdate > $nowdate) {
                                                    $comingSoonTickets[] = $ticket;
                                                    $comingSoonTicketsByGroup[] = $ticket;
                                                } else {
                                                    $description = $ticket['description'];
                                                    $first = substr($description, 0, 100);
                                                    $last = substr($description, 100);
                                                    ?>

                <?php if($ticketGroupStatus){ ?> <div class="widget-tickettype col-lg-12 col-md-12 zeroPadd"> <?php } ?>
                    <<?php if($ticketGroupStatus){ echo 'div'; }else{ echo 'li';} ?> id="accrdn_1" class="<?php echo preg_replace("/[^a-zA-Z]/", "", strtolower($eventData['categoryName'])); ?>">
                        <?php if($ticketGroupStatus == FALSE){ ?> <div class="borderTop"></div><?php } ?>
                        <div class="div-content">
                            <div class="cont_main">
                                <div class="eventCatName">
                                    <?php
                                        $description = $ticket['description'];
                                        $first = substr($description, 0, 150);
                                        $last = substr($description, 150);
                                    ?>
                                    <h2 style="<?php if ($ticketTextColor != '') echo 'color:' . '#' . $ticketTextColor . ';'; ?>"><?php echo $ticket['name'] ?> </h2>

                                    <?php if(strlen($description) > 149) {?>
                                    <p class="tckdesc"> <?php echo $first.'<i>...</i><span style="display:none">'.$last.'</span>';?></p>
                                    <p class="ticket-desc-loadmore"><a href="javascript:;">Show More</a></p>
                                    <?php } else { ?>
                                    <p class="tckdesc"> <?php echo $description?></p>
                                    <?php }?>

                                    <?php if (isset($ticket['taxes']) && count($ticket['taxes']) > 0) {
                                    foreach ($ticket['taxes'] as $taxData) {
                                        ?>
                                        <p class="taxtype">* Exclusive of <?php echo ucfirst($taxData['label']) . ' ' . $taxData['value'] . '%' ?></p>
                                    <?php }
                                    ?>
                                    <p></p>

                                    <?php } if(isset($eventTicketOptionSettings['ticketdatehide']) && $eventTicketOptionSettings['ticketdatehide'] != 1 ) { ?>
                                        <p class="lastdate">
                                            <i>Last Date: <?php echo lastDateFormat($ticket['endDate']) ?></i>

                                        </p>
                                    <?php }
                                    if (isset($ticket['viralData'])) {
                                        $viralValue = $ticket['currencyCode'] . ' ' . $ticket['viralData']['receivercommission'];
                                        if ($ticket['viralData']['type'] == 'percentage') {
                                            $viralValue = $ticket['viralData']['receivercommission'] . '%';
                                        }
                                        ?>
                                        <p class="redeem">Applicable Referral Discount <?php echo $viralValue; ?> </p>
                                    <?php } ?>

                                
                                </div>
                                <!--Ticketname Section End-->
                                 <div class="eventCatValue" style="<?php if ($ticketTextColor != '') echo 'color:' . $ticketTextColor . ';'; ?>"> <span>
                                    <?php if ($ticket['price'] > 0 || $ticket['type'] == 'donation') {
                                        echo $ticket['currencyCode'] . " ";
                                    } ?>
                                    <?php if ($ticket['type'] != 'donation') {
                                        echo $ticket['price'];
                                    } else if ($ticket['type'] == 'donation') { ?>
                                        <?php if ($ticket['soldout'] != 1 && $enddate >= $nowdate && $startdate <= $nowdate) { ?>
                                            <input type="text" name="ticket_selector" placeholder="Enter Amount" size='10' class="ticket_selector selectNo" value="" id="<?php echo $ticket['id'] ?>"> <?php } ?>
                                    <?php } ?> </span> 
                                </div>
                                <!---->
                                <div class="eventCatSelect">
                                    <?php
                                    //preparing the options array
                                    $optionText='';
                                    $optionText .= "<option value='0'>0</option>";
                                    for ($option = $ticket['minOrderQuantity']; $option <= $ticket['maxOrderQuantity']; $option++) {
                                        if (($ticket['totalSoldTickets'] + $option) <= $ticket['quantity']) {
                                            $optionText = $optionText . "<option>" . $option . "</option>";
                                        }
                                    }
                                    ?>
                                    <?php if ($ticket['type'] != 'donation') { ?>
                                        <?php if ($ticket['soldout'] != 1 && $enddate >= $nowdate) { ?>
                                            <select class="form-control ticket_selector selectNo <?php echo $ticket['type'];?>" id="<?php echo $ticket['id'] ?>">
                                                <?php echo $optionText; ?>
                                            </select>
                                        <?php } ?>
                                    <?php } else if ($ticket['type'] == 'donation') {
                                        echo 1;
                                    } ?>
                            </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php if($ticketGroupStatus == FALSE){ ?> <div class="borderBottom"></div><?php } ?>
                    </<?php if($ticketGroupStatus){ echo 'div'; }else{ echo 'li';} ?>>
                <?php if($ticketGroupStatus){ ?> </div> <?php } ?>


                                                <?php } } }
                                    }

                                    if(isset($comingSoonTicketsByGroup) && !empty($comingSoonTicketsByGroup)){
                                        foreach ($comingSoonTicketsByGroup as $ticket) {
                                        $startdate = strtotime($ticket['startDate']);
                                        $enddate = strtotime($ticket['endDate']);
                                        // $startdateConverted = convertTime($ticket['startDate'],$eventData['timeZoneName'],true);
                                        $startdateConverted = $ticket['startDate'];
                                        ?>
                                        <<?php if($ticketGroupStatus){ echo 'div'; }else{ echo 'li';} ?> id="accrdn_1" class="<?php echo preg_replace("/[^a-zA-Z]/", "", strtolower($eventData['categoryName'])); ?>">
                                        <?php if($ticketGroupStatus == FALSE){ ?> <div class="borderTop"></div><?php } ?>
                                            <div class="div-content">
                                                <div class="cont_main">
                                                    <div class="eventCatName">
                                                        <?php
                                                        $description = $ticket['description'];
                                                        $first = substr($description, 0, 100);
                                                        $last = substr($description, 100);
                                                        ?>

                                                        <h2 style="<?php if ($ticketTextColor != '') echo 'color:' . $ticketTextColor . ';'; ?>"><?php echo $ticket['name'] ?> </h2>


                                                        <?php if(strlen($description) > 99) {?>
                                                        <p class="tckdesc"> <?php echo $first.'<i>...</i><span style="display:none">'.$last.'</span>';?></p>
                                                        <p class="ticket-desc-loadmore"><a href="javascript:;">Show More</a></p>
                                                        <?php } else { ?>
                                                        <p class="tckdesc"> <?php echo $description?></p>
                                                        <?php }?>
                                                        <?php if(isset($eventTicketOptionSettings['ticketdatehide']) && $eventTicketOptionSettings['ticketdatehide'] != 1 ) {?>
                                                            <p class="lastdate">
                                                                <i>Start Date: <?php echo lastDateFormat($startdateConverted) ?></i>
                                                            </p>
                                                        <?php } ?>

                                                    </div>
                                                    <div class="eventCatValue" style="<?php if ($ticketTextColor != '') echo 'color:' . $ticketTextColor . ';'; ?>">
                                                        <span> <?php if ($ticket['price'] > 0 || $ticket['type'] == 'donation') {
                                                                echo $ticket['currencyCode'] . " ";
                                                            } ?><?php if ($ticket['type'] != 'donation') {
                                                                echo $ticket['price'];
                                                            }
                                                            //else if($ticket['type'] == 'donation'){
                                                            ?>
                                                            <?php //if($ticket['soldout'] != 1  && $enddate >= $nowdate && $startdate <= $nowdate) { ?>
                                                            <!-- <input type="text" name="ticket_selector" placeholder="Enter Amount" size='10' class="ticket_selector selectNo" value="" id="<?php // echo $ticket['id']  ?>"><?php // }  ?>-->
                                                            <?php //}?>
                                                        </span>
                                                    </div>

                                                    <div class="eventCatSelect">
                                                        <?php
                                                        // $optionText="";
                                                        //if($ticket['soldout'] == 1  || $enddate < $nowdate){
                                                        ?>
                                                        <!--<span class="selectpicker soldout_text"> <?php //echo 'Sold Out'; ?></span>-->

                                                        <?php // } else if($startdate > $nowdate ){  ?>
                                                        <span class="selectpicker comingsoon_text"> <?php echo 'Coming Soon'; ?></span>
                                                        <?php //  } else{  ?>
                                                        <!--                        <span class="selectpicker">-->
                                                        <?php
                                                        //preparing the options array
                                                        //                                    $optionText .= "<option value='0'>0</option>";
                                                        //                                    for($option=$ticket['minOrderQuantity'];$option<=$ticket['maxOrderQuantity']; $option++){
                                                        //                                       if(($ticket['totalSoldTickets']+$option) <= $ticket['quantity']) {
                                                        //                                            $optionText=$optionText."<option>".$option."</option>";
                                                        //                                        }
                                                        //                                    }
                                                        ?>
                                                        <?php //if($ticket['type'] != 'donation') {  ?>
                                                        <!--<select class="form-control ticket_selector selectNo"  id="<?php //echo $ticket['id']  ?>">-->
                                                        <?php // echo $optionText; ?>
                                                        <!--</select>-->
                                                        <?php // }else if($ticket['type'] == 'donation') { echo 1;}  ?>
                                                        <!-- </span> -->  <?php // }?>
                                                    </div>


                                                </div>

                                            </div>
                                            <div class="clearfix"></div>

                                            <?php if($ticketGroupStatus == FALSE){ ?> <div class="borderBottom"></div><?php } ?>
                                            </<?php if($ticketGroupStatus){ echo 'div'; }else{ echo 'li';} ?>>
                                        <?php   }
                                    }


                                    if(isset($soldoutTicketsByGroup) && !empty($soldoutTicketsByGroup)){
                                        foreach ($soldoutTicketsByGroup as $ticket) {
                                            $startdate = strtotime($ticket['startDate']);
                                            $enddate = strtotime($ticket['endDate']);
                                            //$lastdate = convertTime($ticket['endDate'],$eventData['timeZoneName'],true);
                                            $lastdate = $ticket['endDate'];
                                            ?>
                                            <<?php if($ticketGroupStatus){ echo 'div'; }else{ echo 'li';} ?> id="accrdn_1" class="<?php echo preg_replace("/[^a-zA-Z]/", "", strtolower($eventData['categoryName'])); ?>">
                                            <?php if($ticketGroupStatus == FALSE){ ?> <div class="borderTop"></div><?php } ?>
                                                <div class="div-content">
                                                    <div class="cont_main">
                                                        <div class="eventCatName">
                                                            <?php
                                                            $description = $ticket['description'];
                                                            $first = substr($description, 0, 100);
                                                            $last = substr($description, 100);
                                                            ?>

                                                            <h2 style="<?php if ($ticketTextColor != '') echo 'color:' . $ticketTextColor . ';'; ?>"><?php echo $ticket['name'] ?> </h2>


                                                            <?php if(strlen($description) > 99) {?>
                                                            <p class="tckdesc"> <?php echo $first.'<i>...</i><span style="display:none">'.$last.'</span>';?></p>
                                                            <p class="ticket-desc-loadmore"><a href="javascript:;">Show More</a></p>
                                                            <?php } else { ?>
                                                            <p class="tckdesc"> <?php echo $description?></p>
                                                            <?php }?>
                                                            <?php  if( $enddate < $nowdate ){ if(isset($eventTicketOptionSettings['ticketdatehide']) && $eventTicketOptionSettings['ticketdatehide'] != 1 ) { ?>
                                                                <p class="saledate">Sale Date Ended</p>
                                                            <?php } } ?>
                                                        </div>
                                                        <div class="eventCatValue" style="<?php if ($ticketTextColor != '') echo 'color:' . $ticketTextColor . ';'; ?>">
                                                            <span> <?php if ($ticket['price'] > 0 || $ticket['type'] == 'donation') {
                                                                    echo $ticket['currencyCode'] . " ";
                                                                } ?>
                                                                <?php if ($ticket['type'] != 'donation') {
                                                                    echo $ticket['price'];
                                                                }//else if($ticket['type'] == 'donation'){ ?>
                                                                <?php //if($ticket['soldout'] != 1  && $enddate >= $nowdate && $startdate <= $nowdate) {  ?>
                                                                <!--<input type="text" name="ticket_selector" placeholder="Enter Amount" size='10' class="ticket_selector selectNo" value="" id="<?php // echo $ticket['id'] ?>"><?php // } ?> -->
                                                                <?php //}?>
                                                            </span>
                                                        </div>

                                                        <div class="eventCatSelect">
                                                            <span class="selectpicker soldout_text"> <?php echo 'Sold Out'; ?></span>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>

                                                <?php if($ticketGroupStatus == FALSE){ ?> <div class="borderBottom"></div><?php } ?>
                                                </<?php if($ticketGroupStatus){ echo 'div'; }else{ echo 'li';} ?>>
                                        <?php   }
                                    }
                                    ?>
                                    <?php if($ticketGroupStatus){ ?>
                                </div> </div>
                            <?php } ?>
                        <?php if($ticketGroupStatus){ ?> </div> <?php } ?>
                        <?php
                    }  $i++; }
            }


            ?>


        <?php } ?>


            <?php $ticketids = rtrim($ticketids, ','); ?>

            <?php 
            if(isset($eventSettings['courierfee']) && $eventSettings['courierfee'] ){
            ?>
            <div class="courier-section">
                
                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <div class="col-md-6 zeroPadd">
                        <label class="courier_radio_btn btn btn-success active">
                        <img src="<?php echo $this->config->item('images_static_path'); ?>courier.png" class="courier-img">
                        <input type="radio" name="isCourier" id="option1" autocomplete="off" value="1" checked> 
                        <span>I want my tickets to be Delivered</span>
                    </label>
                    </div>
                    <div class="col-md-6 zeroPadd">
                        <label class="courier_radio_btn btn btn-success">
                        <img src="<?php echo $this->config->item('images_static_path'); ?>boxoffice.png" class="courier-img">
                        <input type="radio" name="isCourier" id="option2" autocomplete="off" value="0"> 
                        <span>I want to collect my tickets at Box-office</span>
                    </label> 
                    </div>
                </div>  
            </div>
            <?php } ?>

            <?php
            $buttonName=!empty($eventData['eventDetails']['bookButtonValue'])?$eventData['eventDetails']['bookButtonValue']:'Book Now';
            if($eventData['eventDetails']['organizertnc'] != '') { ?>
                <span class="terms">By clicking "<?php echo $buttonName;?>" you agree to the <a href="#tnc">Terms &amp; Conditions</a></span>
            <?php }?>

            <div class="clearfix"></div>


            <div class="book" id="calucationsDiv" style="display:none;">
                <!-- <div> -->

                <div id="ajax_calculation_div" class="book_subcont_a col-md-12">
                    <table id="totalAmountTbl" width="100%" class="table_cont table_cont_1">
                        <tbody>
                        <tr>
                            <td class="table_left_cont">Amount<span class="currencyCodeStr"></span></td>
                            <td class="table_ryt_cont" id="total_amount">0</td>
                        </tr>
                        </tbody>
                    </table>

                    <table style="display: none;" id="bulkDiscountTbl" width="100%" class="table_cont table_cont_1">
                        <tbody>
                        <tr>
                            <td class="table_left_cont"><?php if(array_key_exists($eventId,$royalOperaSeatingEventIds)){ ?>Member Discount<?php }else{ ?>Bulk Discount Amount<?php } ?> <span class="currencyCodeStr"></span></td>
                            <td class="table_ryt_cont" id="bulkDiscount_amount">0</td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="display: none;" id="discountTbl" width="100%" class="table_cont table_cont_1">
                        <tbody>
                        <tr>
                            <td class="table_left_cont">Discount Amount<span class="currencyCodeStr"></span></td>
                            <td class="table_ryt_cont" id="discount_amount">0</td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="display: none;" id="cashbackTbl" width="100%" class="table_cont table_cont_1">
                        <tbody>
                        <tr>
                            <td class="table_left_cont">Cashback Amount<span class="currencyCodeStr"></span></td>
                            <td class="table_ryt_cont" id="cashback_amount">0</td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="display: none;" id="referralDiscountTbl" width="100%" class="table_cont table_cont_1">
                        <tbody>
                        <tr>
                            <td class="table_left_cont">Referral Discount Amount<span class="currencyCodeStr"></span></td>
                            <td class="table_ryt_cont" id="referralDiscount_amount">0</td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="display: none;" id="courierFeeTbl" width="100%" class="table_cont table_cont_1">
                        <tbody>
                        <tr>
                            <td class="table_left_cont"><span class="courierFee"></span><span class="currencyCodeStr"></span></td>
                            <td class="table_ryt_cont" id="courierFee_amount">0</td>
                        </tr>
                        </tbody>
                    </table>


                    <div id="taxesDiv">

                    </div>


                    <!--Internet Handling Fee Start-->
                    <div class="ticketspages-feehandlingdiv table_cont handlingfees" id="handlingfeesbox"><?php echo HANDLING_FEE_LABEL;?> <span class="currencyCodeStr"></span> <i class="icon2-plus"></i>
                        <div class="ticketspages-feehandling-amount" id="internethandlingtotalamount"> 0</div>
                    </div>

                    <div class="ticketspages-feehandlingdivcontainer handlingfeescontainer">

                        <table style="display: none;" id="extraChargeTbl" width="100%" class="table_cont table_cont_1">

                        </table>
                        <table style="display: none;" id="totalInternetHandlingTbl" width="100%" class="table_cont table_cont_1 bordernone">
                            <tbody>
                            <tr>
                                <td class="table_left_cont"><?php echo $handlingFeeLable;?><span class="currencyCodeStr"></span></td>
                                <td class="table_ryt_cont" id="totalInternetHandlingAmount">0</td>
                            </tr>
                            </tbody>
                        </table>
                        <table style="display: none;" id="totalInternetHandlingGst" width="100%" class="table_cont table_cont_1">
                            <tbody>
                            <tr>
                                <td class="table_left_cont"> <?php echo HANDLING_FEE_GST_LABEL;?><span class="currencyCodeStr"></span></td>
                                <td class="table_ryt_cont" id="totalInternetHandlingGstAmount">0</td>
                            </tr>
                            </tbody>
                        </table>
                        <table style="display: none;" id="roundOfValueTbl" width="100%" class="table_cont table_cont_1">
                            <tbody>
                            <tbody>
                            <tr>
                                <td class="table_left_cont">Round of Value<span class="currencyCodeStr"></span></td>
                                <td class="table_ryt_cont" id="roundOfValue">0</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--Internet Handling Fee End-->


                    <div id="showdis" style="display:none;">
                        <table  width="100%" class="table_cont table_cont_2" id="TicketTableInfo1">
                            <tbody>
                            <tr>
                                <?php if (isset($eventData['discountExists']) && $eventData['discountExists'] == 1) { ?>
                                    <td class="discount_code"><a class="pointerCursor" onclick="ShowDiscountCodePopup();">
                                    <?php
                                    if(!empty($GPTW_EVENTS_ARRAY[$eventId]))
                                    {
                                        echo "Referral Code ?";
                                    }
                                    else
                                    {
                                        echo "Have Discount Code ?";
                                    }
                                    ?>
                                </a></td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="hidedis" style="display:none">
                        <table  width="100%" class="table_cont table_cont_2" id="TicketTableInfo1">
                            <tbody>
                            <tr>
                                <td class="discount_code"><a class="pointerCursor" onclick="HideDiscountCodePopup();">
                                
                                <?php
                                    if (!empty($GPTW_EVENTS_ARRAY[$eventId]))
                                    {
                                        echo "Close Referral Code";
                                    }
                                    else
                                    {
                                        echo "Close Discount Code";
                                    }
                                    ?>
                            
                                </a></td>
                                <td class="code_input"><div>
                                        <input type="text" class="require PromoCodeNewCSS" id="promo_code" name="promo_code" value="0">
                                        <div class="coupon_apply"><a id="apply_discount_btn"  onclick="return applyDiscount();" class="pointerCursor">Apply</a></div>
                                        <div class="coupon_reset"> <a id="apply_discount_btn"  onclick="return clearDiscount();" class="pointerCursor">Clear</a></div>
                                    </div>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <table style="display: none;" id="mediscountTbl" width="100%" class="table_cont table_cont_1">
                        <tbody>
                        <tr>
                            <td class="table_left_cont">Discount Amount<span class="currencyCodeStr"></span></td>
                            <td class="table_ryt_cont" id="mediscount_amount">0</td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="100%" class="table_cont table_cont_3">
                        <tbody>
                        <tr>
                            <td class="table_left_cont"><strong>Total Amount<span class="currencyCodeStr"></span></strong></td>
                            <td class="final_val"><strong id="purchase_total">0</strong></td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="100%">
                        <tbody><tr>
                            <?php if (($eventData['eventDetails']['tnctype'] == 'organizer' && !empty($eventData['eventDetails']['organizertnc']) ) || ($eventData['eventDetails']['tnctype'] == 'meraevents' && !empty($eventData['eventDetails']['meraeventstnc']))) { ?>
                                <td class="TermsTD">
                                    <div class="terms_cont">
                                        By clicking "<?php echo $buttonName; ?>" you agree to the <a style="color:#3366FF; cursor:pointer;" class="event_tnc">Terms and Conditions</a>
                                </td>
                            <?php } ?>
                            <td style="float:right;">
                                <div>
                                    <a class="book_now" href="javascript:;" onclick="booknow()" >
                                        <div id="wrap" class="<?php echo preg_replace("/[^a-zA-Z]/", "", strtolower($eventData['categoryName'])); ?>" style="<?php if ($bookNowBtnColor != '') echo 'background:' . '#' . $bookNowBtnColor . ';'; ?>">
                                            <div id="content"> <?php echo $buttonName; ?> </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody></table>
                </div><!--End of Full Div-->
                <!-- </div> --><!--End of Collapse Div-->
            </div>
        <?php if($ticketGroupStatus){ echo '</div>'; }else{ echo '</ul>';} ?>
    </div>
<?php } else{ ?>
    <div class="col-sm-7 col-xs-12 col-md-8 eventDetails" id="event_about">
        <h3>About The Event</h3>
        <div>
            <p><?php echo stripslashes($eventData['description']); ?></p>
        </div>
    </div>

<?php }?>
<!--T & C Start-->
<div class="modal fade" id="event_tnc" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-invite modal-dialog-center1">
        <div class="modal-content">
            <div class="popup_signup" style="height:auto; overflow:auto;">
                <div class="popup-closeholder">
                    <button data-dismiss="modal" class="popup-close">X</button>
                </div>
                <hr>
                <h3>Terms & Conditions</h3>
                <h3 class="subject"><?php echo isset($eventData['title']) ? $eventData['title'] : ''; ?></h3>
                <hr></hr>
                <div class="event_tnc_holder tncoverflow">
                    <?php echo $tncDetails; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--T & C End-->
