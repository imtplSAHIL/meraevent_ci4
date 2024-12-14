<style>
input:invalid:focus {
  background-image: linear-gradient(#F0D0D3,#F2E4E4);
}
select {
    margin-top: 0;
    width: 100%;
    padding: 10px;
    font-size: 14px;
    margin-bottom: 20px;
    background-color: white;
    font-family: 'Lato', sans-serif;
}

 span.icon-downarrow {
    left: 550px;
    position: relative;
    top: 64%;
 }

</style>
<div class="rightArea">
    <?php if (isset($ticketSettings) && $ticketSettings['status'] == TRUE) { ?>
        <div id="ticketOptionsMessage" class="db-alert db-alert-success flashHide">
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>   
    <?php if (isset($ticketSettings) && $ticketSettings['status'] == FALSE) { ?>
        <div id="ticketOptionsMessage" class="db-alert db-alert-danger flashHide">
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?> 
    <br>
    <div class="heading float-left">
        <h2>Ticketing Options: <span><?php echo $eventTitle; ?></span></h2>
        <p class="width98">Define what information to collect registrants and how the payment process will work for this event. Its a simple 4 step process that you would have to setup only once for your
            event. Once registrations begin for your event, some of these options would be disabled in order to maintain data consistancy.</p>
    </div>
    <div class="clearBoth"></div>
    <!--Data Section Start-->
    <div class="information">
        <form id="ticketOptions" method="post" action="" name="ticketOptions">
            <div class="fs-form fs-form-widget-setting">
                <h2 class="fs-box-title">Information to  Collect</h2>
                <div class="fs-form-content">
                    <p class="width98">
                        <label>
                            <input type="radio" name="collectmultipleattendeeinfo" value="1"  <?php if ($ticketOptions[0]['collectmultipleattendeeinfo'] != 0) { ?> checked="checked" <?php } ?>>
                            <span class="fs-label-content">Collect every attendee`s information in an order.</span> 
                        </label>
                        <span class="mleft">
                            You will be able to export all the details collected for all your attendees at any point. This option is ideal for conferences and formal events.
                        </span> 
                    </p>
                    <p class="width98">
                        <label>
                            <input type="radio" name="collectmultipleattendeeinfo" value="0"  <?php if ($ticketOptions[0]['collectmultipleattendeeinfo'] == 0) { ?> checked="checked" <?php } ?>>
                            <span class="fs-label-content">Collect only one person`s information in an order.</span> 
                        </label>
                        <span class="mleft">
                            This person will act as the Ticket Buyer for the order. We recommend this option for 
                            social events like plays, concerts , informational gatherings, etc.
                        </span> 
                    </p>
                </div>
            </div>
            
             <div class="fs-form fs-form-widget-setting">
                <h2 class="fs-box-title">Ticket Printout Settings</h2>
                <div class="fs-form-content">
                    <p class="width98">
                        <label>
                            <input 
                                type="radio" 
                                name="printonticket" 
                                <?php if ($ticketOptions[0]['printonticket'] == 1) { ?> checked="checked" <?php } ?>
                                value="1" >
                            <span class="fs-label-content">Print barcode on ticket</span> 
                        </label>
                    </p>
                    <p class="width98">
                        <label>
                            <input 
                                type="radio" 
                                name="printonticket" 
                                <?php if ($ticketOptions[0]['printonticket'] == 2) { ?> checked="checked" <?php } ?>
                                value="2">
                            <span class="fs-label-content">Print QR code on ticket</span>
                        </label>
                        
                    </p>
                    <p class="width98">
                        <label>
                            
                            <input 
                                type="radio" 
                                name="printonticket" 
                                <?php if ($ticketOptions[0]['printonticket'] == 3) { ?> checked="checked" <?php } ?>
                                value="3">
                            <span class="fs-label-content">Print barcode & QR code on ticket</span>
                        </label>
                        
                    </p>
                </div>
            </div>  
            <div class="fs-form fs-form-widget-setting">
                <h2 class="fs-box-title">Ticket Settings</h2>
                <div class="fs-form-content">
                    <p class="width98">
                        <label>
                            <input 
                                type="checkbox" 
                                name="limitsingletickettype" 
                                <?php if ($ticketOptions[1]['limitsingletickettype'] == 1) { ?> checked="checked" <?php } ?>
                                >
                            <span class="fs-label-content">Limit one ticket type per booking</span> 
                        </label>
                        <span class="mleft">If checked, allows delegate to book only one type of ticket.</span> 
                    </p>
                    <p class="width98">
                        <label>
                            <input 
                                type="checkbox" 
                                name="displayamountonticket" 
                                <?php if ($ticketOptions[0]['displayamountonticket'] == 1) { ?> checked="checked" <?php } ?>
                                >
                            <span class="fs-label-content">Display amount on Print Pass</span>
                        </label>
                        <span class="mleft">If checked, the amounts will be displayed on delegate pass.</span> 
                    </p>
                    <p class="width98">
                        <label>
                            <input 
                                type="checkbox" 
                                name="displaychargesonticket" 
                                <?php if ($ticketOptions[0]['displaychargesonticket'] == 1) { ?> checked="checked" <?php } ?>
                                >
                            <span class="fs-label-content">Display Convenience Fee on Print Pass</span>
                        </label>
                        <span class="mleft">If checked, the Service Charge, Gateway Charges and Booking Fee will be displayed on delegate pass.</span> 
                    </p>
                    <p class="width98">
                        <label>
                            <input 
                                type="checkbox" 
                                name="nonormalwhenbulk" 
                                <?php if ($ticketOptions[0]['nonormalwhenbulk'] == 1) { ?> checked="checked" <?php } ?>
                                >
                            <span class="fs-label-content">Normal discount not applicable on bulk discounted ticket</span>
                        </label>
                        <span class="mleft">If checked, the normal discount will not be applied on bulk discounted ticket.</span> 
                    </p>
                    <p class="width98">
                        <label>
                            <input 
                                type="checkbox" 
                                name="ticketdatehide" 
                                <?php if ($ticketOptions[0]['ticketdatehide'] == 1) { ?> checked="checked" <?php } ?>
                                >
                            <span class="fs-label-content">Hide Ticket End Date</span>
                        </label>
                        <span class="mleft">If checked, ticket(s) date(s) will be hidden.</span> 
                    </p>
                    <p class="width98">
                        <label>
                            <input type="checkbox" name="registerationvalidatedomain"<?php if ($ticketOptions[0]['registerationvalidatedomain'] == 1) { ?> checked="checked" <?php } ?>>
                            <span class="fs-label-content">Restrict Domains for Registration</span>
                        </label>
                        <span class="mleft">If checked, below entered domains will not allowed for registration.</span>
                    </p>
                    <p class="width98">
                        <label>Domains <font class="suggestiontext"> [ Enter list of domains seperated by a comma(,) No spaces allowed ]</font></label>
                        <input type='text' name='registerationvalidatedomainlist' class='textfield valid' value='<?php echo $ticketOptions[0]['registerationvalidatedomainlist'] ?>' />
                    </p>



<!--                    <p class="width98">
                    <label>
                            <input 
                                    type="checkbox" 
                                    name="sendubermails" 
                    <?php //if($ticketOptions[0]['sendubermails'] == 1) { ?> checked="checked" <?php // }?>
                                    >
                                    <span class="fs-label-content">Send UBER mails after each registration</span> 
                            </label>
                            <span class="mleft">If checked, an Email with the UBER discount code would be sent for every delegate registration.</span> 
              </p>-->
                </div>
            </div>      


            <div class="fs-form fs-form-widget-setting">
                <h2 class="fs-box-title">Invoice Settings</h2>
                <div class="fs-form-content">
                    <p class="width98">
                        <label>

                            <input 
                                type="checkbox" 
                                name="sendinvoice" 
                                id="sendinvoice" 
                                <?php if ($ticketOptions[0]['sendinvoice'] == 1) { ?> checked="checked" <?php } ?>
                                <?php if(empty($ticketOptions[2])) {?> disabled="disabled" <?php } ?>
                                >
                            <span class="fs-label-content">Send Invoice</span> 

                        </label>
                        <?php if(empty($ticketOptions[2])) {?>
                        <span class="mleft">To Enable Invoice , Please add GST to atleast one ticket</span>
                        <?php } else {?>
                        <span class="mleft">If checked, Invoice will be sent along with delegate pass.</span> 
                        <?php } ?>
                        <span id="sendinvoiceerror" class="error"></span> 
                    </p>
                    <input type="hidden" name="companydetailsedit" id="companydetailsedit" value="<?php echo $companydetails['companydetailsedit']; ?>"/>
                    <div id="companyDetails" class="inlineblock width98" <?php // if($ticketOptions[0]['sendinvoice'] != 1) { echo "style='display: none;'"; }                         ?> >

                            <p class="width98">
                                <label>GST Number<span class='mandatory' style="color:#f00; font-size:16px;">*</span></label> 
                                <input type='text' id='gst' name='gst'  size="60" minlength="15"  maxlength="15" class='textfield valid' value='<?php echo $gstdetails[0]['gstnumber'] ?>' /> 
                                <span id="gsterror" class="error" style="display: none">Please enter value</span> 
                            </p> 

                            <p class="width98">
                                <label>Company Name <span class='mandatory' style="color:#f00; font-size:16px;">*</span></label> 
                                <input type='text' id='companyname' name='companyname' size="60" class='textfield valid' value='<?php echo $gstdetails[0]['accountname'] ?>' />
                                <span id="companynameerror" class="error" style="display: none">Please enter value</span> 
                            </p>
                            <p class="width98">
                                <label>Location <span class='mandatory' style="color:#f00; font-size:16px;">*</span></label> 

                                <input type='text' id='locality' name='location' size="60" class='textfield valid localityAutoComplete' value='<?php echo $gstdetails[0]['location'] ?>' />
                                <span id="localityerror" class="error" style="display: none">Please enter value</span> 
                                

                            </p>

                            

                            
                            <?php $locat=explode(',',$csc);   ?>

                            

                             <p class="width98">
                                <label>Country <span class='mandatory' style="color:#f00; font-size:16px;">*</span></label>  
                                <label>
                                <span style="top:36px;" class="float-left icon-downarrow"></span>
                               
                                <select name="countryId" id="fields_table_country_id">
                                <option>Choose Your Country</option>
                                    <?php 
                                        foreach ($countryList as $key => $value) { 
                                            if($companydetails['countryid'] == $value['id']){
                                                $sl='selected';
                                            }else{
                                                $sl=''; 
                                            }
                                            ?>
                                        <option value="<?php echo $value['id']; ?>" <?php echo $sl; ?>><?php echo $value['name']; ?></option>
                                        <?php } 
                                    ?>
                                
                                    
                                </select>
                            </label>
                               <!-- <input type="text" id="countryId" name="countryId" value = "<?php echo $companydetails['countryid']; ?>">-->
                                <span id="countryerror" class="error" style="display: none">Please enter value</span> 

                            </p>

                              <p class="width98">
                                <label>State <span class='mandatory' style="color:#f00; font-size:16px;">*</span></label>  
                                <label>
                                <span style="top:36px;" class="float-left icon-downarrow"></span>
                                
                                <select name="stateId" id="fields_table_state_id">
                                <option>Choose Your State</option>
                                <?php if($locat[1]){ ?>
                                    <option value="<?php echo $companydetails['stateid']; ?>" ><?php echo $locat[1]; ?></option>
                                    <?php } ?>
                                </select>
                                </label>  
                                <!-- <input type="text" id="stateId" name="stateId" value = "<?php //echo $companydetails['stateid']; ?>"> -->
                                <span id="stateerror" class="error" style="display: none">Please enter value</span> 

                            </p>
                             <p class="width98">
                                <label>City <span class='mandatory' style="color:#f00; font-size:16px;">*</span></label>
                                <label>
                                <span style="top:36px;" class="float-left icon-downarrow"></span>
                                <select name="cityId" id="fields_table_city_id">
                                <option>Choose Your City</option>
                                <?php if(isset($locat[0]) && count($locat)==3){ ?>
                                    <option value="<?php echo $companydetails['cityid']; ?>" ><?php echo $locat[0]; ?></option>
                                    <?php } ?>
                                </select> 
                                </label>
                                <!--<input type="text" id="cityId" name="cityId" value = "<?php //echo $companydetails['cityid']; ?>">-->
                                <span id="cityerror" class="error" style="display: none">Please enter value</span> 

                            </p>


                            <p class="width98">
                                <label>Prefix Invoice <span class='mandatory' style="color:#f00; font-size:16px;">*</span></label> 
                                <input type='text' id='companyname' name='prefixinvoice' size="60" class='textfield valid' value='<?php echo $gstdetails[0]['prefixinvoice'] ?>' <?php if($editstatus == FALSE){?> readonly <?php } ?> />
                                <span id="companynameerror" class="error" style="display: none">Please enter value</span> 
                            </p>

                            <div class="clearBoth"></div>
                            <p class="width98">
                                <label>Invoice Start Number <span class='mandatory' style="color:#f00; font-size:16px;">*</span></label> 
                                <input type='text' id='invoice_number' name='invoice_number' size="60" class='textfield valid' onkeypress="return isNumber(event)" value='<?php echo $gstdetails[0]['invoicestartnumber'] ?>' placeholder='Enter Number' <?php if($editstatus == FALSE){?> readonly <?php } ?> />
                                <span id="invoice_numbererror" class="error" style="display: none">Please enter value</span> 
                            </p>

                    </div>
                </div>
            </div>  

            <input type="hidden" id="eventID" value="<?php echo $ticketOptions['eventID'] ?>" >
            <input type="submit" class="submitBtn createBtn float-right submitBtnTicketOptions" name="submit" value="save"/>
        </form>
    </div>
</div>

<script>
    var invoiceDetailsValidation = '<?php echo commonHelperGetPageUrl('invoiceDetailsValidation'); ?>';
    $(document).ready(function () {
        customCheckbox("sendinvoice");
        customCheckbox('nonormalwhenbulk');
        customCheckbox("ticketdatehide");
        customCheckbox("registerationvalidatedomain");
    });
    
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert('Enter numbers only');
        return false;
    }
    return true;
}
</script>
<script>
    var api_cityCitysByState = "<?php echo commonHelperGetPageUrl('api_cityCitysByState'); ?>";
    var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch') ?>";
    var api_stateSearch = "<?php echo commonHelperGetPageUrl('api_stateSearch') ?>";
    var api_citySearch = "<?php echo commonHelperGetPageUrl('api_citySearch') ?>";
</script>

<script>
   // var baseurl = "<?php echo base_url(); ?>";
    $("#fields_table_country_id").on("change", function () { 
       
	 var country_id=$(this).val();
	$.ajax({
		type: "POST",
        //url:"{{url('/profile/stateslist/')}}/"+country_id,
		url: '<?php echo site_url("profile/index/stateslist"); ?>',	
		data:'countryId='+country_id,
		beforeSend: function() {
			//$("#state-list").addClass("loader");
		},
		success: function(data){
			$("#fields_table_state_id").html(data);
			$('#city-list').find('option[value]').remove();
			$("#state-list").removeClass("loader");
		}
	});  
}); 
$("#fields_table_state_id").on("change", function () { 
	var val=$(this).val();
	$.ajax({
		type: "POST",
        url: '<?php echo site_url("profile/index/citylist"); ?>',			
		data:'state_id='+val,
		beforeSend: function() {
			//$("#state-list").addClass("loader");
		},
		success: function(data){
			$("#fields_table_city_id").html(data);
			$('#city-list').find('option[value]').remove();
			$("#state-list").removeClass("loader");
		}
	}); 
});

       
           
       </script>
