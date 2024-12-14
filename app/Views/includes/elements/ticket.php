<?php 
$count = 0;
$registrationType=1;
if(!isset($eventDetails['id'])){ 
$edit=0;
$maxval=1;
$ticketsCount = 1;
//$eventTicketDetails = array();  
$eventTicketDetails = array(
             0 => array("id"=>'',"name" => "", "description" => "", "eventId" => "", "price" => "",'type'=>2,"order"=>1,"displayStatus"=>'',"currencyId"=>'',"soldout"=>'',"currencyCode"=>'') );
}else{
    $ticketsCount = count($eventTicketDetails);
    $registrationType=$eventDetails['registrationType'];
    $edit = 1;
    foreach($eventTicketDetails as $key => $v){
    	$ticketIndex[] = $v['id'];
    }
    $maxval = max($ticketIndex)+1;
    
}
 
//for No registration events
if (isset($eventDetails) && $eventDetails['registrationType'] == 3 ){
    $edit = 1;
}

if(isset($duplicateEvent)){
    $maxval=1;
    $ticketsCount = 1;
    $edit = 0;
}
    
$tickettypes = array(1=>'Free',2=>'Paid',3=>'Donation',4=>'Add-on Items');
?>   
<div class="create_eve_tickets"> 
<input type="hidden" name="ticketscount" id="ticketscount" value="<?php echo $ticketsCount;?>" />
<input type="hidden" name="maxArrIndex" id="maxArrIndex"  value="<?php echo $maxval;?>"/>
<?php 
if(!empty($eventTicketDetails)){
foreach($eventTicketDetails as $key => $v){
if($edit == 0){
	$startdate = '';
	$starttime = '';
	$enddate = '';
	$endtime =  '';
}else{

 $startdatetime = explode(" ",$v['startDate']);
$startdate =allTimeFormats($startdatetime[0],1);
$starttime =allTimeFormats($startdatetime[1],2);
 
 $enddatetime = explode(" ",$v['endDate']);
 $enddate =allTimeFormats($enddatetime[0],1);
 $endtime =allTimeFormats($enddatetime[1],2);
}

if(isset($duplicateEvent)){
    $startdatetime = explode(" ",$v['startDate']);  
    $startdate =allTimeFormats($startdatetime[0],1);
    $starttime =allTimeFormats($startdatetime[1],2);
    $enddatetime = explode(" ",$v['endDate']);
    $enddate =allTimeFormats($enddatetime[0],1);
    $endtime =allTimeFormats($enddatetime[1],2);
}

$addTaxesClass="availableTaxes";
 if(isset($transactionsTicketCount[$v['id']]) && $transactionsTicketCount[$v['id']] > 0){ 
     $transactionsDisable=' readonly="readonly" ';
     //$transactionsCheckDisable=' onclick="return false;" ';
     $transactionsCheckDisable=' disabled ticketsold="1" '; 
     $addTaxesClass="";
 }else{
     $transactionsDisable="";
     $transactionsCheckDisable=' ';
 }
	?>
<div class="eventtickettype" >
<ul>
<li>
<label for="Ticket type">Ticket type </label>
<div class="TicketDropdownHolder">
     <input type="hidden" name="eventedit"  value="<?php echo $edit;?>" id="eventedit"/>
     <input type="hidden" name="ticketArrIndex" class="ticketArrIndex"  value="<?php if(!isset($duplicateEvent)){echo $v['id'];};?>"/>
     <input type="hidden" name="ticketId[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]"  value="<?php if(!isset($duplicateEvent)){echo $v['id'];}?>"/>
     <?php if(isset($duplicateEvent)){ ?><input type="hidden" name="duplicateTicketId[]"  value="<?php if(isset($duplicateEvent)){echo $v['id'];}?>"/> <?php } ?>
     <input type="hidden" name="indexedTicketArr[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]"  value="<?php echo $count;?>"/>
     <?php if(isset($transactionsTicketCount[$v['id']]) && $transactionsTicketCount[$v['id']] > 0){ ?>
       <select <?php echo $transactionsDisable;?> ticketcount="<?php echo $count;?>" name="ticketType[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" id="ticketType<?php echo $count;?>" class="ticketType selectedticket<?php echo $count;?>" >
    <?php foreach($tickettypes as $t => $ttv){
        //if(strtolower($ttv) == $v['type']){
        ?>
    <option value="<?php echo $t;?>" <?php if(strtolower($ttv) == $v['type'] || ($v['type']=='addon' && $ttv='Add-on Items')){echo "selected";}?> ><?php echo $ttv?></option>
        <?php } //}?>
    </select>  
  <?php   }else{ ?>
    <select ticketcount="<?php echo $count;?>" name="ticketType[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" id="ticketType<?php echo $count;?>" class="ticketType selectedticket<?php echo $count;?>" >
    <?php foreach($tickettypes as $t => $ttv){ ?>
    <option value="<?php echo $t;?>" <?php if(strtolower($ttv) == $v['type'] || ($v['type']=='addon' && $ttv=='Add-on Items')){echo "selected";}?> ><?php echo $ttv?></option>
    <?php }?>
    </select>
     <?php } ?>
     <span class="create-event-error ticketTypeError" id="ticketTypeError<?php echo $count;?>" style="display: none;"></span>
 </div>     
</li>
 
<li>
<label for="Ticket name">Ticket name</label>
<input <?php echo $transactionsDisable;?> type="text" class="form-control eventFields ticketName"  id="ticketName<?php echo $count;?>"  name="ticketName[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" 
       value="<?php echo $v['name']?>"/>
<span class="create-event-error ticketNameError" id="ticketNameError<?php echo $count;?>" style="display: none;"></span>
</li>
<li>
<label for="Quantity">Order</label>
<input type="text" class="form-control eventFields "  id="order<?php echo $count;?>"  name="order[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" value="<?php echo $v['order'];?>">
<span class="create-event-error ticket orderError order" id="ticketOrderError<?php echo $count;?>" style="display: none;"></span>
</li>
<li>
<label for="Price" style="display:<?php if ($v['type'] == "donation")  { echo 'none';}else {echo 'show'; } ?> ;">Price</label>
<span class="form-control eventFields ticketpricespan" id="ticketpricespan<?php echo $count;?>" style="display:<?php if ($v['type'] == "free")  { echo 'show';}else {echo 'none'; } ?> ;">0</span>
<input <?php echo $transactionsDisable;?> type="text" class="form-control eventFields ticketprice"  id="price<?php echo $count;?>"  name="price[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]"   style="display: <?php if (($v['type'] == "free") || ($v['type'] == 'donation')) { echo 'none';} ?> " value="<?php echo $v['price'];?>" />
<span class="create-event-error priceError" id= "priceError<?php echo $count;?>" style="display: none;">Price is required.</span>
</li>
<li class="advsettings_new">
<a href="javascript:void(0);" class="settingsIcon" <?php if($edit == 1 && $count<= count($eventTicketDetails)){ ?> data-old="1" <?php } ?> id="settingicon<?php echo $count;?>">
<img src="<?php echo $this->config->item('images_static_path')?>setting_icon.png"  alt=""/>
</a>
<?php if($edit == 1 && !isset($duplicateEvent)){
	$delstyle = '';
	$class = " onclick = deleteticket(".$v['id'].",".$v['eventId'].")";
	$addstyle = 'style="display:none"';
	
	}else{
		$delstyle = 'style="display:none"';
		$addstyle = '';
		$class= '';
	}
        if(isset($duplicateEvent)){
            $delstyle = '';
            $class= '';
        }
	?>
    <?php if(isset($transactionsTicketCount[$v['id']]) && $transactionsTicketCount[$v['id']] > 0){ }elseif(!isset($duplicateEvent) && $count>=0 || isset($duplicateEvent) && $count > 0){?>
    <a href="javascript:void(0)" class="btn deletTicket" <?php echo $delstyle;?> <?php echo $class; ?>>
        <img src="<?php echo $this->config->item('images_static_path')?>close-icon.png">
	</a>
    <?php } ?>
<!--    <span class="add_ticket" <?php //echo $addstyle;?>  >+</span>   -->
</li>
<li  class="ticketNo"></li>
</ul>
<div class="setting_content" id="setting_content<?php echo $count;?>"  style="display:none;">
<div class="adv_settings">
<span>Advanced Settings</span>
</div>
<div class="ticket_description">
<ul>
<li class="description_input">
<label for="ticketStart date">Ticket Description</label>
<input type="text" class="form-control eventFields ticketDescription"   id="ticketDescription<?php echo $count;?>"   name="ticketDescription[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" value="<?php echo $v['description'] ?>">
<span class="create-event-error ticketDescriptionError" id= "ticketDescriptionError<?php echo $count;?>" style="display: none;">Ticket description is required.</span>
</li>
</ul>
</div>

<div class="change_ticketsettings sales float" <?php if($multiEvent==1){ echo "style='display: none;'"; } ?>>
<ul>
<li>
<label for="Start date">Start date</label>
<input type="text" class="form-control eventFields event_start_date"  id="startdate<?php echo $count;?>"  name="ticketstartDate[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" 
       value="<?php echo $startdate;?>" readonly="readonly">
<span class="create-event-error startdateError" id= "startdateError<?php echo $count;?>" style="display: none;"></span>
</li>
<li>
<label for="Start time">Start time</label>
  <div class="input-group bootstrap-timepicker">
        <input type="text" class="form-control eventFields event_start_time"  id="starttime<?php echo $count;?>" name="ticketstartTime[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" value="<?php echo $starttime;?>" readonly="readonly">
	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>		
        <span class="create-event-error starttimeError" id= "starttimeError<?php echo $count;?>" style="display: none;"></span>
</div>

</li>
<li>
<label for="End date">End date</label>
<input type="text" class="form-control eventFields endDate <?php if($edit==1){echo "edit_";}?>event_end_date" id="enddate<?php echo $count;?>"  name="ticketendDate[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" value="<?php echo $enddate;?>" readonly="readonly">
<span class="create-event-error enddateError" id= "enddateError<?php echo $count;?>" style="display: none;"></span>
</li>
<li>
<label for="End time">End time</label>
  <div class="input-group bootstrap-timepicker">
    <input type="text" class="form-control eventFields event_end_time"  id="endtime<?php echo $count;?>"   name="ticketendTime[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" value="<?php echo $endtime;?>" readonly="readonly">
    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    <span class="create-event-error endtimeError" id= "endtimeError<?php echo $count;?>" style="display: none;"></span>
</div>

</li>

</ul>
</div>

<div class="TicketSalesEnd float" <?php if($multiEvent!=1){ echo "style='display: none;'"; } ?>>
    <ul>
        <li class="width30">
            <label>Ticket sales end</label>
            <input type="number" name="ticketPeriodValue[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" id="ticketPeriodValue" class="form-control eventFields" value="<?php if(isset($v['ticketPeriodValue'])) echo $v['ticketPeriodValue']; else echo "1.0"; ?>">
            <span class="create-event-error ticketPeriodValueError" id= "ticketPeriodValueError<?php echo $count;?>" style="display: none;"></span>
        </li>
        <li class="width30">
            <label>&nbsp;</label>
           <div class="TicketDropdownHolder"> <select name="ticketPeriodType[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]">
                           <option value="hours" <?php if(isset($v['ticketPeriodType']) && $v['ticketPeriodType'] == 'hours') echo "selected"; ?>>hour(s)</option>
                           <option value="days" <?php if(isset($v['ticketPeriodType']) && $v['ticketPeriodType'] == 'days') echo "selected"; ?>>day(s)</option>
                           <option value="minutes" <?php if(isset($v['ticketPeriodType']) && $v['ticketPeriodType'] == 'minutes') echo "selected"; ?>>minutes(s)</option>
                       </select></div>
        </li>
        <li class="width30">
            <label>before event</label>
            <div class="TicketDropdownHolder"><select name="ticketEndType[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]">
                            <option value="starts" <?php if(isset($v['ticketEndType']) && $v['ticketEndType'] == 'starts') echo "selected"; ?>>starts</option>
                            <option value="ends" <?php if(isset($v['ticketEndType']) && $v['ticketEndType'] == 'ends') echo "selected"; ?>>ends</option>
                        </select></div>
        </li>
        <li></li>
    </ul>
</div>

<div class="MarginTop float">
    <ul>
        <li style=" width: 26%; <?php if($v['type']=='free'){ echo "display: none"; }?>">
    <label>Currency </label> 
 <div class="TicketDropdownHolder">
     <?php if(isset($transactionsTicketCount[$v['id']]) && $transactionsTicketCount[$v['id']] > 0){ ?>
         
     <select <?php echo $transactionsDisable;?> name="currencyType[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" id="currencyType<?php echo $count;?>">
    <?php
    foreach ($currencyDetails as $currency) {  
        if(!empty($currency['currencyCode'])){
             if($v['currencyId'] == $currency['currencyId']){
    ?>
    <option <?php if($v['currencyId'] == $currency['currencyId']){echo "selected";} ?> value="<?php echo $currency['currencyId']; ?>"><?php  echo $currency['currencyCode']; ?></option>
             <?php } } }
             if($v['type']=='free'){ ?>
    <option value="3" selected=""/>
    <?php  }
?>
</select>
         <?php }else{ ?>
        <select name="currencyType[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" id="currencyType<?php echo $count;?>">
    <?php
    foreach ($currencyDetails as $currency) {  
        if(!empty($currency['currencyCode'])){
    ?>
            <option <?php if(isset($v['currencyId']) && $v['currencyId'] == $currency['currencyId']){echo "selected";} ?> value="<?php echo $currency['currencyId']; ?>"><?php  echo $currency['currencyCode']; ?></option>
        <?php } }?>
</select>
 <?php }?>
<?php //if($v['type']=='free'){ ?> 
     <!--<input class="freeticketcurrency" type="hidden" name="currencyType[<?php echo $v['id']?>]" id="currencyType<?php echo $count;?>" value="3" />-->
<?php //}?>
     <span class="create-event-error currencyTypeError" id= "currencyTypeError<?php echo $count;?>" style="display: none;"></span>
 </div>
</li>
<li style=" width: 26%; ">
    <label>Participation Type</label>
    <div class="TicketDropdownHolder">
    <select name="participationtickettype[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]">
        <option value="">-----</option>
        <?php
     foreach ($participationticketData['response']['participationTicketsList'] as $participationTickets){
         ?>
        <option <?php if(isset($participationTickets) && $participationTickets['participationticketname'] == $v['participationtickettype']){echo "selected"; } ?> value="<?php echo $participationTickets['participationticketname']; ?>"><?php echo $participationTickets['participationticketname']; ?></option>     
        <?php
     }
        ?>
    </select>
    </div>
</li>
    </ul>
</div>








<div class="change_currency sales float <?php if($edit == 1 && $count< count($eventTicketDetails)){ }else{ ?>taxList_div<?php } ?>" <?php if($edit == 0 || $v['type']=='free'){?>style="display: none;" <?php }?>>
        <ul class="<?php if($edit == 1 && $count< count($eventTicketDetails) || isset($duplicateEvent)){ ?>taxList_old_ul<?php }else{ ?>taxList_ul<?php } ?>"><?php if($edit == 1 || isset($duplicateEvent)){?>
            <span class="pull-left addTaxes" data_value="settingicon<?php if(isset($duplicateEvent)){echo $count;}?>">Add Taxes?</span>
            <div class="add_taxes add_taxes_settingicon<?php echo $count;?> <?php if($v['type']=='paid'){echo $addTaxesClass;}?>" style="display: block;">
            <input type="hidden" name="taxmappingcount[<?php if(!isset($duplicateEvent)){echo $v['id'];} ?>]" value="<?php if(!isset($duplicateEvent)){echo $v['id'];}?>" />
            
            <?php //if(isset($oldTicketDetails[$v['id']])){
              //  foreach ($oldTicketDetails[$v['id']] as $otkey => $otvalue) {  ?>
<!--                    <li class="TaxField">
		<span class="custom-checkbox selected">
		
		<input <?php //echo $transactionsCheckDisable;?> type="checkbox" name="taxArray[<?php //echo $count;?>][<?php //echo $v['id']?>]" value="<?php //echo $otvalue['taxmappingid'];?>" id="serviceTax<?php //echo $count?>" class="taxCheckBox" checked="checked" />
		</span><h5><?php //echo $otvalue['label'];?></h5>
		</li>
		<li class="TaxField_width">
		<ul style="margin: 0;">
		<li><input type="text" disabled class="form-control eventFields TaxField_width" value="<?php //echo $otvalue['value']?>"></li>
		</ul>
	</li>-->
           <?php 
          //  var_dump($ticketTaxIds); exit; //     }     
            // }else{ ?>
<?php 

$taxLabel = array();
foreach($eventtickettaxes as $et => $ev){
    if(!in_array($ev['label'],$taxLabel)){
       $ev['label'] = trim($ev['label']);
        array_push($taxLabel, $ev['label']);
    }
}
$taxLabel = array_unique($taxLabel);

            foreach ($taxLabel as $key => $value) {
                ?>   <div class="col-md-4 col-sm-4">
                    <label><?php echo $value; ?></label>
                    <div class="form-group TicketDropdownHolder"><select name = "taxArray[<?php if(!isset($duplicateEvent)){echo $v['id'];} if(isset($duplicateEvent)){echo $count;}?>][]" <?php echo $transactionsCheckDisable; ?> >
        <option value="" >none</option>
             <?php foreach($eventtickettaxes as $et => $ev){
                 $ev['label'] = trim($ev['label']);
                 if($ev['label'] == $value){
              
                        $className='';
                        $checked = '';	
                        $selected = '';
                        $taxmappingId=$ev['id'];
                        $taxValue=$ev['value'];

			if(isset($ticketTaxIds[$v['id']]) && in_array($ev['taxid'], $ticketTaxIds[$v['id']])){
		 		$checked = 'checked=checked';
                                $selected = 'selected=selected';
				$className=" selected";
                                $taxmappingId=$oldTicketDetails[$v['id']][$ev['taxid']]['taxmappingid'];
                                $taxValue=$oldTicketDetails[$v['id']][$ev['taxid']]['value'];
			}
		?>
                <option value ="<?php echo $taxmappingId ?>" <?php echo $selected;?> ><?php echo $taxValue; ?></option>
		
	
             <?php } } ?>
          <?php  // }?>
            </select></div></div>
                    
                <?php 
            }
?>





            
	 </div><?php }?></ul>
</div>
    <div id="qtyDiv<?php echo $count;?>" class="create_ticket_order sales float" <?php if($edit==1 && $v['type']=='donation'){ echo'style="display:none;"';}?>>
<ul>
<li >
<label for="Ticket name">Quantity</label>
<input type="text" class="form-control eventFields ticketquantity"  id="quantity<?php echo $count;?>"  name="quantity[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" 

       value="<?php echo isset($v['quantity'])?$v['quantity']:DEFAULT_TICKET_QUANTITY ?>" maxlength="10">

 
<span class="create-event-error quantityError ticketQtyError" id="ticketQtyError<?php echo $count;?>" style="display: none;"></span>
</li>
<li >
<label for="Quantity">Min Qty</label>
<input type="text" class="form-control eventFields minquantity"   id="minquantity<?php echo $count;?>"   name="minquantity[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" 
       value="<?php echo isset($v['minOrderQuantity'])?$v['minOrderQuantity']:MIN_TICKET_QUANTITY;?>" value="">
<span class="create-event-error minquantityError minQtyError" id="minQtyError<?php echo $count;?>" style="display: none;"></span>
</li>
<li>
<label for="Price">Max Qty</label>
<input type="text" class="form-control eventFields maxquantity"   id="maxquantity<?php echo $count;?>"   name="maxquantity[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" 
       value="<?php echo isset($v['maxOrderQuantity'])?$v['maxOrderQuantity']:MAX_TICKET_QUANTITY;?>" value=""/>
<span class="create-event-error maxquantityError maxQtyError" id="maxQtyError<?php echo $count;?>" style="display: none;"></span>
</li>
</ul>
</div>
<div class="change_sale">
<ul>

    <li>
        <?php 
        $soldHiddenValue="<input type='hidden' value='0' name='soldOut[$v[id]]'>";
        $className="";
        $noclassName= $nottodisplayHiddenValue=$nodispCheckedStatus="";
        $soldoutCheckedStatus="";
        if($edit==1 || isset($duplicateEvent)){
            if($v['soldout']==1){ 
                $soldHiddenValue="";
                $className=" selected";
                $soldoutCheckedStatus="checked='checked'";
            } 
         
            ?>
        <span class='custom-checkbox<?php echo $className;?>'>
            <input type="checkbox"  class="soldout soldoutCheckbox" id="soldout<?php echo $count;?>" name="soldOut[<?php if(!isset($duplicateEvent)){echo $v['id'];};?>]" 
                   value="1" <?php echo $soldoutCheckedStatus;?>>
            <?php echo $soldHiddenValue;?>
        </span>
            <h5>Sold out</h5>
          <?php 
        $nottodisplayHiddenValue="<input type='hidden' value='1' name='nottodisplay[$v[id]]'>";
        
        if(isset($v['displayStatus']) && $v['displayStatus']==0){ 
            $noclassName=" selected";
            $nottodisplayHiddenValue="";
            $nodispCheckedStatus="checked='checked'";
        }
                
           
        
        }else{?>
        	
        	<span class='custom-checkbox'>
				<input type="checkbox"  class="soldout soldoutCheckbox" id="soldout<?php echo $count;?>" name="soldOut[<?php if(!isset($duplicateEvent)){echo $v['id'];}?>]" value="1">
                                 <input type='hidden' value='0' name='soldOut[<?php if(!isset($duplicateEvent)){echo $v['id'];};?>]'>
			</span>
 
            <h5>Sold out</h5>
        	
        	
         <?php }?>  
            <span class="create-event-error soldoutError" id="soldoutError<?php echo $count;?>" style="display: none;"></span>
            </li>
            <li>
            <span class='custom-checkbox<?php echo $noclassName;?>'>
                <input type="checkbox" class="soldout nottodisplayCheckbox"  id="nottodisplay<?php echo $count;?>"  
                       name="nottodisplay[<?php if(!isset($duplicateEvent)){echo $v['id'];};?>]" value="0" <?php echo $nodispCheckedStatus;?>>
                <?php echo $nottodisplayHiddenValue;?>
            </span>
			<h5>Not to Display</h5>
                        <span class="create-event-error nottodisplayError" id="nottodisplayError<?php echo $count;?>" style="display: none;"></span>
        </li>
        </ul>
    </div>

</div>
</div>
<?php
$count++;
 }

}?>
</div>

<div id="dummy-ticket" style="display:none">

<div class="eventtickettype" >
<ul>
<li>
<label for="Ticket type">Ticket type </label>

<div class="TicketDropdownHolder">
    <input type="hidden" name="ticketArrIndex" class="ticketArrIndex"  value=""/>
    <input type="hidden" name="indexedTicketArr[]" class="indexedTicketArr"  value=""/>
    <select name="ticketType[]" id="ticketType" class="ticketType" ticketcount="0">
    <option value="2">Paid</option>
    <option value="1">Free</option>
    <option value="3">Donation</option>
    <option value="4">Add-on Items</option>
    </select>
    <span class="create-event-error ticketTypeError" id="ticketTypeError<?php echo $count;?>" style="display: none;"></span>
 </div>     
</li>
<li>
<label for="Ticket name">Ticket name</label>
<input type="text" class="form-control eventFields ticketName"  id="ticketName"  name="ticketName[]" 
       value=""/>
<span class="create-event-error ticketNameError" id="ticketNameError" style="display: none;"></span>
</li>
<li>
<label for="Quantity">Order</label>
<input type="text" class="form-control eventFields ticketOrder"  id="order" maxlength="10" name="order[]" value="<?php echo count($eventTicketDetails)?>">
<span class="create-event-error orderError ticketOrderError" id="ticketOrderError" style="display: none;"></span>
</li>
<li>
<label for="Price">Price</label>
<span class="form-control eventFields ticketpricespan" id="ticketpricespan" style="display:none;"></span>
<input type="text" class="form-control eventFields ticketprice"  id="price"  name="price[]" value="" />
<span class="create-event-error priceError" id="priceError" style="display: none;">Price is required.</span>
</li>
<li class="advsettings_new">
<a href="javascript:void(0);" class="settingsIcon" id="settingicon<?php echo $count;?>">
<img src="<?php echo $this->config->item('images_static_path')?>setting_icon.png"  alt=""/>
</a>
    <a href="javascript:void(0)" class="btn deletTicket" style="display:">
        <img src="<?php echo $this->config->item('images_static_path')?>close-icon.png">
</a>

    <!--<span class="add_ticket"  >+</span>-->     
</li>
<li  class="ticketNo"></li>
</ul>
    <div class="setting_content" id="setting_content"  style="display:none;">
<div class="adv_settings">
<span>Advanced Settings</span>
</div>
<div class="ticket_description">
<ul>
<li class="description_input">
<label for="ticketStart date">Ticket Description</label>
<input type="text" class="form-control eventFields ticketDescription"   id="ticketDescription"   name="ticketDescription[]" value="">
<span class="create-event-error ticketDescriptionError" id= "ticketDescriptionError" style="display: none;">Ticket description is required.</span>
</li>
</ul>
</div>

<div class="change_ticketsettings sales float" <?php if($multiEvent==1){ echo "style='display:none'"; }?> >
<ul>
<li>
<label for="Start date">Start date</label>
<input type="text" class="form-control eventFields event_start_date"  id="startdate"  name="ticketstartDate[]" readonly="readonly" />
<span class="create-event-error startdateError" id= "startdateError" style="display: none;"></span>
</li>
<li>
<label for="Start time">Start time</label>
  <div class="input-group bootstrap-timepicker">
        <input type="text" class="form-control eventFields event_start_time"  id="starttime" name="ticketstartTime[]" readonly="readonly" />
	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>	
        <span class="create-event-error starttimeError" id= "starttimeError" style="display: none;"></span>
</div>

</li>
<li>
<label for="End date">End date</label>
<input type="text" class="form-control eventFields endDate event_end_date" id="enddate"  name="ticketendDate[]" readonly="readonly"/>
<span class="create-event-error enddateError" id= "enddateError" style="display: none;"></span>
</li>
<li>
<label for="End time">End time</label>
  <div class="input-group bootstrap-timepicker">
    <input type="text" class="form-control eventFields event_end_time"  id="endtime"   name="ticketendTime[]" readonly="readonly"/>
    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>	
    <span class="create-event-error endtimeError" id= "endtimeError" style="display: none;"></span>
</div>

</li>
</ul>
</div>

<div class="TicketSalesEnd float" <?php if($multiEvent!=1){ echo "style='display: none;'"; } ?>>
    <ul>
        <li class="width30">
            <label>Ticket sales end</label>
            <input type="number" name="ticketPeriodValue[]" id="ticketPeriodValue" class="form-control eventFields" value="1.0">
            <span class="create-event-error ticketPeriodValueError" id= "ticketPeriodValueError<?php echo $count;?>" style="display: none;"></span>
        </li>
        <li class="width30">
            <label>&nbsp;</label>
           <div class="TicketDropdownHolder"> <select name="ticketPeriodType[]">
                           <option value="hours">hour(s)</option>
                           <option value="days">day(s)</option>
                           <option value="minutes">minutes(s)</option>
                       </select></div>
        </li>
        <li class="width30">
            <label>before event</label>
            <div class="TicketDropdownHolder"><select name="ticketEndType[]">
                            <option value="starts">starts</option>
                            <option value="ends">ends</option>
                        </select></div>
        </li>
        <li></li>
    </ul>
</div>

<div class="MarginTop float">
    <ul>
        <li style=" width: 26%;">
    <label>Currency </label> 
 <div class="TicketDropdownHolder">
<select name="currencyType[]" id="currencyType" class="currencyType">
    <?php
    foreach ($currencyDetails as $currency) {  
        if(!empty($currency['currencyCode'])){
    ?>
    <option value="<?php echo $currency['currencyId']; ?>"><?php echo $currency['currencyCode']; ?></option>
        <?php } }?>
</select>
     <span class="create-event-error currencyTypeError" id= "currencyTypeError" style="display: none;"></span>
 </div>
</li>
<li style=" width: 26%; ">
    <label>Participation Type</label>
    <div class="TicketDropdownHolder">
        <select name="participationtickettype[]">
        <option value="">-----</option>
        <?php
     foreach ($participationticketData['response']['participationTicketsList'] as $participationTickets){
         ?>
        <option value="<?php echo $participationTickets['participationticketname']; ?>"><?php echo $participationTickets['participationticketname']; ?></option>     
        <?php
     }
        ?>
    </select>
    </div>
</li>
    </ul>
</div>
 

<div class="change_currency sales float taxList_div" style="display: none;">
	<ul class="taxList_ul"></ul>
</div>
<div class="create_ticket_order sales float">
<ul>
<li >
<label for="Ticket name">Quantity</label>
<input type="text" class="form-control eventFields ticketquantity"  id="quantity"  name="quantity[]" 
       value="<?php echo DEFAULT_TICKET_QUANTITY ?>" maxlength="10">
 
<span class="create-event-error quantityError ticketQtyError" id="ticketQtyError" style="display: none;"></span>
</li>
<li >
<label for="Quantity">Min Qty</label>
<input type="text" class="form-control eventFields minquantity"   id="minquantity"   name="minquantity[]" 
       value="<?php echo MIN_TICKET_QUANTITY;?>" >
<span class="create-event-error minquantityError minQtyError" id="minQtyError" style="display: none;"></span>
</li>
<li>
<label for="Price">Max Qty</label>
<input type="text" class="form-control eventFields maxquantity"   id="maxquantity"   name="maxquantity[]" 
       value="<?php echo MAX_TICKET_QUANTITY;?>" />
<span class="create-event-error maxquantityError maxQtyError" id="maxQtyError" style="display: none;"></span>
</li>
</ul>
</div>
<div class="change_sale">
<ul>

    <li>
 <span class='custom-checkbox'>
				<input type="checkbox"  class="soldout soldoutCheckbox" id="soldout" name="soldOut[]" value="1">
                                 <input type='hidden' value='0' name='soldOut[]'>
 </span>
 
            <h5>Sold out</h5>
            <span class="create-event-error soldOutError" id="soldOutError" style="display: none;"></span>
        </li>
        <li>
            <span class='custom-checkbox'>
				<input type="checkbox" class="soldout nottodisplayCheckbox"  id="nottodisplay"  name="nottodisplay[]" value="0">
                                <input type='hidden' value='1' name='nottodisplay[]'>
            </span>
			<h5>Not to Display</h5>
                        <span class="create-event-error nottodisplayError" id="nottodisplayError" style="display: none;"></span>
        </li>
</ul>
    </div>

</div>
</div>


</div>