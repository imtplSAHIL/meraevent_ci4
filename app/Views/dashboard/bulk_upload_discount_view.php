<div class="rightArea">
    <div class="heading">
        <h2>Add / Edit Discount Code : <span><?php echo $eventName; ?></span></h2>
       
    </div>

    <div class="editFields fs-add-discount-box">
    <?php //For all the errors of server side validations
        if (isset($status_message)) {
        ?>
        <div class="db-alert db-alert-success flashHide">
            <strong><?php print_r($status_message); ?></strong> 
        </div>
        
    <?php } ?>

        <form name='addBulkDiscountForm' method='post' enctype="multipart/form-data" action="<?php echo commonHelperGetPageUrl('dashboard-bulk-upload-discount', $this->input->get('eventId')); ?>" id='addBulkDiscountForm'>
           <input type="hidden" class="textfield" id="hiddenEventEndDate" name="hiddenEventEndDate" value="<?php if (isset($discountDetails['response']['discountList'][0]['startdatetime'])) {
                echo 0;
            }elseif(isset($eventEndDate)) {
                echo allTimeFormats(convertTime($eventEndDate, $eventTimeZoneName, TRUE),1);              
            }?>" >
            <input type="hidden" class="textfield" id="hiddenStartDate" name="hiddenStartDate" readonly value="<?php
            if (isset($discountDetails['response']['discountList'][0]['startdatetime'])) {
                echo allTimeFormats(convertTime($discountDetails['response']['discountList'][0]['startdatetime'], $eventTimeZoneName, TRUE),1);             
            } else {
                echo 0;
            }
            ?>" >            
            <input type="hidden" class="textfield" id="hiddenStartTime" name="hiddenStartTime" readonly value="<?php
            if (isset($discountDetails['response']['discountList'][0]['startdatetime'])) {
                echo allTimeFormats(convertTime($discountDetails['response']['discountList'][0]['startdatetime'], $eventTimeZoneName, TRUE),4);
            } else {
                echo 0;
            }
            ?>" >            
            <input type="hidden" class="textfield" id="hiddenEndDate" name="hiddenEndDate" readonly value="<?php
            if (isset($discountDetails['response']['discountList'][0]['enddatetime'])) {
                 echo allTimeFormats(convertTime($discountDetails['response']['discountList'][0]['enddatetime'], $eventTimeZoneName, TRUE),1);             
            } else {
                echo 0;
            }
            ?>" >            
            <input type="hidden" class="textfield" id="hiddenEndTime" name="hiddenEndTime" readonly value="<?php
            if (isset($discountDetails['response']['discountList'][0]['enddatetime'])) {
                echo allTimeFormats(convertTime($discountDetails['response']['discountList'][0]['enddatetime'], $eventTimeZoneName, TRUE),4);
            } else {
                echo 0;
            }
            ?>" >                                                                                                                                                                                                                             
            <input type="hidden" class="textfield" id="DiscountId" name="DiscountId" readonly value="<?php
                   if (isset($discountDetails['response']['discountList'][0]['id'])) {
                       echo $discountDetails['response']['discountList'][0]['id'];
                   }
                   ?>" >   
            
            <div id="filedownloadcontent" class="filedownloadcontent" >
                <!-- <div class="download_link" id="download_link" ><a href="#" style="color: #0000FF;">Download sample csv file here</a></div> -->
                <label>CSV File <span class="mandatory">*</span></label>
                <input type="file" name="csvfile" id="csvfile" class="textfield">
            </div>

            <div class="discountDateClass">
                <ul>
                    <li>
                        <label>Valid From Date <span class="mandatory">*</span></label>
                        <input type="text" class="textfield" id="discountStartDate" name="discountStartDate">  
                    </li>
                    <li>
                        <label>Valid From Time <span class="mandatory">*</span></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="textfield" id="discountStartTime" name="discountStartTime" data-toggle="dropdown">
                        </div>
                    </li>
                </ul>
            </div>

            <div class="discountDateClass">
                <ul>
                    <li>
                        <label>Valid till Date <span class="mandatory">*</span></label>
                        <input type="text" class="textfield" id="discountEndDate" name="discountEndDate">
                    </li>
                    <li>
                        <label>Valid till Time <span class="mandatory">*</span></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="textfield" id="discountEndTime" name="discountEndTime" data-toggle="dropdown">
                        </div>
                    </li>
                </ul>
            </div>
                <div><span class='error' id='dateTimeError' ></span></div>              
            <label style="float:left;">Discount Value <span class="mandatory">*</span> <span class="suggestiontext-g">(Enter the discount value here. For ex.200 for 200Rs)</span> </label>
            <input type="text" class="textfield" onchange="return func_update_price()" id="discountValue" name="discountValue" <?php if (isset($discountDetails)) { ?>value="<?php echo $discountDetails['response']['discountList'][0]['value']; ?>"<?php if($discountDetails['response']['discountList'][0]['totalused'] > 0){ echo "disabled"; } } ?> >
            <label>Discount Type <span class="mandatory">*</span></label>
            <div class="valid_date valid_bottom">
                <ul>
                    <li> 
                        <label><input type="radio" onchange="return func_update_price()" name="amountType" id="is_percentage" value="percentage" <?php
                               if (isset($discountDetails)) {
                                   if($discountDetails['response']['discountList'][0]['totalused'] > 0){echo "disabled";}
                                   if ($discountDetails['response']['discountList'][0]['calculationmode'] == 'percentage') {
                                       ?> checked="checked" <?php
                           }
                       } else {
                           ?> checked="checked"<?php } ?> >
                            Percentage </label></li>                    
                    <li>
                        <label><input type="radio" onchange="return func_update_price()" name="amountType" id="is_amount"  <?php
                               if (isset($discountDetails)) {
                                   if($discountDetails['response']['discountList'][0]['totalused'] > 0){echo "disabled";}
                                   if ($discountDetails['response']['discountList'][0]['calculationmode'] == 'flat') {
                                       ?> checked="checked" <?php
                           }
                       }
                               ?> value="flat">
                            Amount</label></li>
                </ul>
            </div>
            <div class="clearBoth height10"></div>

            <label>Usage Limit <span class="mandatory">*</span> <span class="suggestiontext-g">(No of registrants who can use this code)</span> </label>
            <input type="text" class="textfield" id="usageLimit" name="usageLimit"<?php if (isset($discountDetails)) { ?>value="<?php echo $discountDetails['response']['discountList'][0]['usagelimit'] ?>"<?php } ?>>
            <div class="clearBoth height10"></div>
            <label>Ticket Type <span class="mandatory">*</span></label>
            <div class='child'>
                <?php
                $i = 0;
                if ($ticketDetails['response']['total'] > 0) {
                    foreach ($ticketDetails['response']['ticketName'] as $ticket) {
                        if (isset($discountDetails) && $ticket['type'] == 'paid' && $ticket['soldout'] == 0 && $ticket['quantity'] >= $ticket['totalsoldtickets']) {
                            ?>
                <div class="BulkDiscClass"><label><input type="checkbox" id="<?php echo $ticket['id']; ?>" name="ticketIds[]" class="ticketCheckbox " value="<?php echo $ticket['id']; ?>" <?php
                                                                if (isset($ticketIdList)) {
                                                                    if (in_array($ticket['id'], $ticketIdList)) {
                                                                        ?>checked='checked'<?php
                                                                    }
                                                                }
                                                                ?>>
            <?php echo $ticket['name']; $i++;?></label>
            <input type="hidden" value="<?php echo $ticket['price']; ?>" id="actual_price-<?php echo $ticket['id']; ?>" />
            Price: <?php echo $currencyList[$ticket['currencyid']]['currencyCode']; ?> <span  id="org_price-<?php echo $ticket['id']; ?>"><?php  echo $ticket['price']; ?></span> <br />
            Final Price: <?php echo $currencyList[$ticket['currencyid']]['currencyCode']; ?> <span id="final_price-<?php echo $ticket['id']; ?>"><?php  echo $ticket['price']; ?></span>

  </div>                        
                <?php     }elseif (($ticket['type'] == 'paid' || $ticket['type'] == 'addon') && $ticket['soldout'] == 0 && strtotime($ticket['enddatetime']) > strtotime(allTimeFormats('',11)) && $ticket['quantity'] >= $ticket['totalsoldtickets']) {
                            ?>
                            <div class="BulkDiscClass"> <label> <input type="checkbox" id="<?php echo $ticket['id']; ?>" name="ticketIds[]" class="ticketCheckbox " value="<?php echo $ticket['id']; ?>" <?php
                                                                if (isset($ticketIdList)) {
                                                                    if (in_array($ticket['id'], $ticketIdList)) {
                                                                        ?>checked='checked'<?php
                                                                    }
                                                                }
                                                                ?>>
            <?php echo $ticket['name']; ?></label>
            <input type="hidden" value="<?php echo $ticket['price']; ?>" id="actual_price-<?php echo $ticket['id']; ?>" />
            
            Price: <?php echo $currencyList[$ticket['currencyid']]['currencyCode']; ?> <span  id="org_price-<?php echo $ticket['id']; ?>"><?php  echo $ticket['price']; ?></span> <br />
            Final Price: <?php echo $currencyList[$ticket['currencyid']]['currencyCode']; ?> <span id="final_price-<?php echo $ticket['id']; ?>"><?php  echo $ticket['price']; ?></span>
                            <?php $i++;
                            ?>  </div>


                            <?php }
                    }
                    ?>
                    <?php if ($i == 0) { ?>
                    <div class="db-alert db-alert-info"> 
                        <span id="noTicket">No active tickets found for this event</span>   
                    </div>    
    <?php }
} elseif (isset($ticketDetails['response']['total']) && $ticketDetails['response']['total'] == 0) { ?>
                 <div class="db-alert db-alert-info">
                    <span id="noTicket" >No tickets found for this event</span>  
                 </div>     
<?php }
?>    
                <div id='checkboxErrorDiv' style='display:none;'><span class='error' id='ticketCheckboxError' style='font-size:14px; padding-top: 12px;'></span> </div>
            </div>

            <div class="btn-holder float-right">
                <input type="submit" name='discountSubmit' class="createBtn" value='Save'>
                <a href="<?php echo commonHelperGetPageUrl('dashboard-list-discount', $eventId); ?>" class="saveBtn"><span ></span>Cancel</a>
            </div>            
        </form>
    </div>
</div>
<script>
$(window).load(function() {
    func_update_price();
});
function func_update_price()
{
    var discount_value = document.getElementById("discountValue").value;
    var discount_type = 'amount';
    if($('#is_percentage').is(':checked')) {
        var discount_type = 'percentage';
    }
    $('input[id^="actual_price-"]').each(function(i,e) {
        
        var ticket_id_str = e.id;
        var ticket_id_str = ticket_id_str.replace("actual_price-", "");
        var actual_price = e.value;
        if(discount_value == ''){
            $("#final_price-"+ticket_id_str).text(actual_price);
            $("#final_price-"+ticket_id_str).removeAttr("style");
        }
        else {
            if(discount_type == 'percentage'){
                final_price = actual_price - (actual_price * (discount_value / 100));
            }
            else{
                final_price = actual_price - discount_value;
            }
            if(final_price < 0)
            {
                final_price = 0;
            }
            $("#final_price-"+ticket_id_str).text(final_price);
            $("#final_price-"+ticket_id_str).css("color", "red");
        }
    });
}
</script>