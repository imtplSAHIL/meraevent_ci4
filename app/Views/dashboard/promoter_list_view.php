<div class="rightArea">
     <?php if(isset($output) && !empty($output)){ if($output['status']){ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $output['response']['messages'][0] ?></strong> 
        </div>                 
    <?php }else{ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $output['response']['messages'][0]; ?></strong> 
        </div>                 
     <?php } }?>
    <div class="fs-form"> 
       <h2 class="fs-box-title">Affiliate Settings</h2>
       <div class="editFields">
    <form name="affiliateSettingsForm" method="post" action="" id="affiliateSettingsForm">
        <input type="hidden" name="formtype" value="affiliateSettings">
        <label class="widthfloat" for="affiliateavail"><b>Do you want to give commission on ticket sales for this event to Promoters ?</b></label>
        <p class="pb-10imp"><label><input <?php if(isset($eventsettings['affiliateavail']) && $eventsettings['affiliateavail']==1){ ?> checked="checked" <?php }?> required="" type="radio"  name="affiliateavail" value="1">Yes</label>
        <p class="pb-10imp"><label><input <?php if(isset($eventsettings['affiliateavail']) && $eventsettings['affiliateavail']==0){ ?> checked="checked" <?php }?> type="radio"  name="affiliateavail" value="0">No</label></p>
            
            
        <label style="display: none;" class="widthfloat" for="affiliatetype"><b>Affiliate Type</b></label>
            
            <p style="display: none;" class="pb-10imp"><label><input  <?php if(isset($eventsettings['affiliatetype']) && $eventsettings['affiliatetype']==0){ ?> checked="checked" <?php }?>  required="" type="radio"  name="affiliatetype" id="affiliatetypeprivate" value="0"> Private </label><span class="mleft">(Only promoters which you have added can only promote)</span></p>
            <?php if(isset($eventsettings['affiliatetype']) && $eventsettings['affiliatetype']==1){ ?>
            <p class="pb-10imp"><label><input  <?php if(isset($eventsettings['affiliatetype']) && $eventsettings['affiliatetype']==1){ ?> checked="checked" <?php }?>  required="" type="radio"  name="affiliatetype" id="affiliatetypepublic" value="1"> Public </label><span class="mleft">(Any one can promote your event)</span></p>
            
            <div class="publiccommission" <?php if(isset($eventsettings['affiliatetype']) && $eventsettings['affiliatetype']==0){ ?> style="display: none;" <?php } ?>>
            <label class="widthfloat" for="affiliatetype"><b>Commission for global promoters</b></label>
            <p class="pb-10imp"><label><input min="1" max="80" required="" class="textfield3" type="text"  name="publiccommission" value="<?php echo isset($publicCommission)?$publicCommission:0;?>"> </label><span class="mleft"></span></p>
            </div>
            <?php } ?>
            <div id="codeError" class="error"></div>
            <div class="clearBoth"></div>
            
            <div class="btn-holder float-right">
                <input name="submit" type="submit" id="affiliatesettingsButton" class="createBtn" value="Save">
                
            </div>
        </form>
           
        </div> 
   </div>
    
   
    
    <?php
    $promoterSuccessMessage = $this->customsession->getData('promoterSuccessAdded');
    $this->customsession->unSetData('promoterSuccessAdded');
    if ($promoterSuccessMessage) { ?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $promoterSuccessMessage; ?></strong> 
        </div>
    <?php } ?>
    
    <div class="clearBoth"></div>
    <div class="float-right"> 
        <a href="<?php echo commonHelperGetPageUrl("dashboard-add-affliate", $eventId); ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add New Promoter
        </a> </div>
    <div class="clearBoth"></div>
    <div class="heading float-left">
        <h2>Promoters List: <span> <?php echo $eventName; ?> <?php //echo $eventId;  ?></span></h2>
    </div>
    <div class="clearBoth"></div>
    <?php if(isset($promoterDetails) && !$promoterDetails['status']) { ?>               
        <div class="db-alert db-alert-danger flashHide">                    
            <strong><?php print_r($promoterDetails['response']['messages'][0]); ?></strong> 
        </div>
        <?php } ?>  

        <div class="tablefields">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
                <thead>
                    <tr>
                        <th scope="col" data-tablesaw-priority="2">Promoter Name</th>
                        <th scope="col" data-tablesaw-priority="2">Promoter Code</th>
                        <th scope="col" data-tablesaw-priority="2">Created On</th>
                        <th scope="col" data-tablesaw-priority="2">Commission Earned</th>
                        <th scope="col" data-tablesaw-priority="2">COMMISSION (%)</th>
                        <th scope="col" data-tablesaw-priority="2">Tickets sold</th>
                        <th scope="col" data-tablesaw-priority="2">Ticket Paid Amount</th>
                        <th scope="col" data-tablesaw-priority="2">Current Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($promoterDetails['status'] && $promoterDetails['response']['total'] == 0) { ?>
                        <tr><td colspan="8">
                                <div id="noPromoterMessage" class="db-alert db-alert-info">                    
                                    <strong> <?php echo $promoterDetails['response']['messages'][0]; ?></strong> 
                                </div>
                            </td> </tr> <?php
            } else if ($promoterDetails['status'] && $promoterDetails['response']['total'] > 0) {              
                    $i = 0;
                    $promoterList = $promoterDetails['response']['promoterList'];
                    foreach ($promoterList as $index => $row) {
                        $class = 'odd';
                        if ($i % 2 == 0) {
                            $class = '';
                        }
                        $commissionPercentage=isset($commissionPercentages[$row['id']]['commission'])?$commissionPercentages[$row['id']]['commission']:0;
                                ?>
                                <tr <?php echo $class; ?> >
                                    <td><a class="affiliateview" href="<?php echo commonHelperGetPageUrl("dashboard-add-affliate", $eventId.'&'.$row['id']);?>"><?php echo $row['name']; ?></a></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo convertDateTime($row['cts']); ?></td>
                                    <td><?php $editcommissionstatus=0; if(isset($promoterSaleCommission[$row['id']]['totalcommission']) && !empty($promoterSaleCommission[$row['id']]['totalcommission'])){
                                        foreach ($promoterSaleCommission[$row['id']]['totalcommission'] as $pckey => $pcvalue) {
                                            echo $pckey.' '.round($pcvalue,2)."<br>";
                                            $editcommissionstatus+=$pcvalue;
                                        }
                                    }else{ echo 0;}?></td>
                                    <td><?php if($editcommissionstatus==0 || $commissionPercentage==0){ ?>
                                        <input id="promoterEventCommission<?php echo $index;?>" eventid="<?php echo $eventId;?>" promoterid="<?php echo $row['id'];?>" type="text" value="<?php echo $commissionPercentage; ?>" class="CustomOrder" disabled=""><span id="<?php echo $index;?>" class="promoterEventCommissionIcon icon-edit"></span>
                                    <?php }else{ ?>
                                        <input id="promoterEventCommission<?php echo $index;?>" eventid="<?php echo $eventId;?>" promoterid="<?php echo $row['id'];?>" type="text" value="<?php echo $commissionPercentage; ?>" class="CustomOrder" disabled="">
                                   <?php } ?>
                                    </td>
                                    <td><?php echo isset($row['quantity'])?array_sum($row['quantity']):0; ?></td>
                                    <td><?php if(isset($row['totalamount'])){
                                        $commitionAmoutWithCurrency='';
                                            foreach ($row['totalamount'] as $tmkey => $tmvalue) {
                                                if($tmkey!=''){
                                                $commitionAmoutWithCurrency.=$tmkey.' '.$tmvalue.'<br>';
                                                }
                                            }
                                            echo isset($commitionAmoutWithCurrency) && $commitionAmoutWithCurrency!=''?$commitionAmoutWithCurrency:0;
                                    }else{ echo 0;}?></td>
                                    <td><?php if ($row['status'] == 1) { ?>
                                            <button onclick="changeStatus('<?php echo $row['id']; ?>')" type="button" class="btn greenBtn" id='<?php echo $row['id']; ?>'>ACTIVE </button>
                                        <?php } else { ?>
                                            <button onclick="changeStatus('<?php echo $row['id']; ?>')" type="button" class="btn orangrBtn" id='<?php echo $row['id']; ?>'>INACTIVE </button>
                                        <?php } ?></td>
                                </tr>
                            <?php }
                        }
                     ?>                     
            </tbody>
        </table>
    </div>

 <br>
<div class="heading float-left">
    <h2>Ticket Commissions: </h2>
</div>
 <br><h4>Note: Affiliate commission will be applied on tickets if individual ticket commission is 0</h4>
    <div class="tablefields">
        
        <form id="viralTicket" method="post" action="">
            <input type="hidden" name="formtype" value="affiliateTicketCommissions">
<!--            <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-mode="swipe" data-tablesaw-minimap>-->
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
                    <tr>
                        <th scope="col">Ticket Type</th>
                        <th scope="col" >Ticket Price</th>
                        <th scope="col" style="display: none;">COMMISSION TYPE</th>
                        <th scope="col">Enable / Disable</th>
                        <th scope="col">Commission (%)</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ticketsCount = count($ticketData);
                    if ($ticketsCount > 0) {
                        foreach ($ticketData as $key => $val) {
                        	$saleDone = $val['affiliatesalesDone'];
                                $ids[] = $key;
                            ?>
                            <tr>
                                <td><?php echo $val['name']; ?></td>
                                <td><?php if($val['type']=='donation'){ echo "Donation Ticket"; }else{ echo $val['currencyCode'].' '.$val['price']; }?></td>
                                <td style="display: none;"><div  class="fs-summary-detail"><label style="float:left;"> <input type="radio"  name="type<?php echo $val['id']; ?>" value="percentage" checked="checked"> Percentage</label></div></td>
                                <td><input type="checkbox" class="enableDisable" name="status<?php echo $val['id']; ?>" value="1" <?php if(!isset($ticketCommission[$val['id']]['status'])){ ?> checked="checked" <?php }elseif ($ticketCommission[$val['id']]['status'] == 1) { ?> checked="checked" <?php } ?> <?php if($val['affiliatesalesDone'] === 1){ echo "salesDone=1";}?> ></td>
                                <td><input min="0" max="80" type="text" class="textfield3 mandatory_class" <?php if($val['affiliatesalesDone'] === 1){ echo "disabled";}?>  id="referrercommission<?php echo $val['id']; ?>" name="referrercommission<?php echo $val['id']; ?>" value="<?php echo isset($ticketCommission[$val['id']]['commission'])&&$ticketCommission[$val['id']]['commission']!=''?$ticketCommission[$val['id']]['commission']:0 ?>" <?php if($saleDone == 1){echo "salesDone='1' disabled";}?>>
                                    <input style="display: none;" type="text" class="textfield3 mandatory_class"  id="receivercommission<?php echo $val['id']; ?>" name="receivercommission<?php echo $val['id'];?>" value="0">
                                    <input type="hidden"  name="salesDone<?php echo $val['id']; ?>" value="<?php echo $saleDone;?>" />
                                </td>
                                
                            </tr>
                            <?php
                        }
                    
                        ?>
<?php
} else {
    ?>
    <tr> <td colspan="6">                
            <div id="noViralTicketingMessage" class="db-alert db-alert-info">                    
                    <strong>Affiliate ticketing not available, as you dont have paid tickets for this event</strong> 
                </div>
           </td>
    </tr>                        
<?php    
}
?>
                </tbody>
            </table>
            <div class="float-right">
                <input type="submit" class="createBtn float-right" name="viralTicketSubmit" id="viralTicketSubmit" value="Save"/>
            </div>
        </form>
        <input type="hidden" name="radioFieldname" id="radioFieldname" value="<?php echo json_encode($ids) ?>" />
    </div>
</div>

<script>
var promoterEventCommissionEdit='<?php echo commonHelperGetPageUrl('promoterEventCommissionEdit');?>';
</script>