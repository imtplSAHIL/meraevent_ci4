<div class="rightArea">
    <div class="heading float-left">
        <h2>Partial Payments</h2>
    </div>
    <div class="clearBoth"></div>
    <!--Data Section Start-->

    <div class="previewSec">
        <div class="grid-row padding20 pb-0imp" style="display: none;">
            <div class="grid-lg-12 grid-md-12 grid-sm-12 nopadding">
                <div class="fs-form fs-form-widget-setting boxshadow">
                    <h2 class="fs-box-title">Select Ticket Widget Theme</h2>
                    <div class="ticketFields fs-form-content">
                        <div onclick="selecttheme(0, this);" class="ticketwidget-theme-option grid-lg-2 grid-md-2 grid-sm-6 grid-xs-12 widgetselected">
                            <a>Theme One</a>
                        </div>
                        <div onclick="selecttheme(1, this);" class="ticketwidget-theme-option grid-lg-2 grid-md-2 grid-sm-6 grid-xs-12">
                            <a>Theme Two</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid-row padding20">
            <div class="grid-lg-8 grid-md-12 grid-sm-12 nopadding">
                <div class="fs-form fs-form-widget-setting boxshadow">
                    <h2 class="fs-box-title">Direct Payment</h2>
                    <div class="ticketFields fs-form-content">
                        <div class="grid-lg-12 grid-sm-12 grid-xs-12 nopadding">
                            <div class="WidgetSelectOptions">
                               <div class="editFields fs-profile-form" style="margin-top: 20px;">
        <form method="post" action="<?php echo site_url(); ?>directPayment/createOrder">                    
                    <?php
                    if (!empty($customfields)) {
                        foreach ($customfields as $customField) {
                            $fieldName = str_replace(" ", "", preg_replace("/[^A-Za-z0-9\s\s]/", "", $customField['fieldname']));
                            $manadatorySpan = $requiredInput = '';
                            if ($customField['fieldmandatory'] == 1) {
                                $manadatorySpan = '<span class="mandatory" >*</span>';
                                $requiredInput = 'required';
                            }
                    if ($customField['fieldtype'] == 'textbox') {
                        ?>
                        <div class="form-group">
                            <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                            <input type="text" name="<?php echo 'attendee[1][' . $fieldName .']'; ?>" class="textfield" <?php echo $requiredInput; ?>>
                        </div>
                    <?php
                        } else if ($customField['fieldtype'] == 'textarea') {
                    ?>
                        <div class="form-group">
                            <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                            <textarea type="text" name="<?php echo 'attendee[1][' . $fieldName .']'; ?>" class="form-control" <?php echo $requiredInput; ?>></textarea>
                        </div>
                    <?php
                        } else if ($customField['fieldtype'] == 'dropdown') {
                    ?>
                        <div class="form-group">
                            <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                            <div  style="position:relative">
                                <span class="icon-downarrow downarrowSettings"></span>
                                <select class="form-control" name="<?php echo 'attendee[1][' . $fieldName .']'; ?>" <?php echo $requiredInput; ?>>
                                    <option value=''>Select</option>
                                    <?php foreach ($customFields['response']['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                                        <option value="<?php echo $customFieldValueArr['value']; ?>"><?php echo $customFieldValueArr['value']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php
                        } else if ($customField['fieldtype'] == 'radio') {
                    ?>
                            <div class="form-group">
                                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                                <ul>
                                    <?php 
                                    foreach ($customField['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                                        <li style="width: 33.33%; float: left">
                                            <label><input type="radio" name="<?php echo 'attendee[1][' . $fieldName .']'; ?>" value="<?php echo $customFieldValueArr['value']; ?>" <?php echo $requiredInput; ?>><?php echo $customFieldValueArr['value']; ?></label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                    <div style="clear:both"></div>
                    <?php
                        } else if ($customField['fieldtype'] == 'checkbox') {
                    ?>
                                <div class="form-group">
                                    <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                                    <div style="position:relative">
                                        <ul>
                                            <?php foreach ($customFields['response']['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                                                <li style="width: 33.33%; float: left">
                                                    <label><input type="checkbox" name="<?php echo 'attendee[1][' . $fieldName .']'; ?>" value="<?php echo $customFieldValueArr['value']; ?>" <?php echo $requiredInput; ?>><?php echo $customFieldValueArr['value']; ?></label>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                    <div style="clear:both"></div>
                <?php
            }
        }
    }
?>
            <div class="form-group">
                <label>Amount <span class="mandatory">*</span> <?php echo $manadatorySpan; ?></label>
                <input type="text" name="attendee[1][amount]" id="amount" class="textfield" autocomplete="off" onkeypress="return isNumber(event)" placeholder="Enter amount to proceed" required="">
            </div>
                <div class="form-group" style="display: none">
                <label>Partial Payment </label>
                        <input type="hidden" name="attendee[1][ispartialpayment]" autocomplete="off" value="1">
                   </div>
                <td><input value="Pay Now" type="submit" class="submitBtn submit createBtn float-right"></td>

            <table border="1">
                <tbody>
                    <input name="eventId" autocomplete="off"  type="hidden" value="<?php echo $eventid; ?>"readonly>
                            <input name="parentsignupid" type="hidden" autocomplete="off" value="<?php echo $parentsignupid; ?>">
                            <input name="Event_Type"  type="hidden" autocomplete="off" value="PP">
            <input name="redirecturl" autocomplete="off" type="hidden" value="<?php echo site_url() ?>profile/index/userpartialpayments">
            <input name="ticketArray[<?php echo $ticketid; ?>]"  type="hidden"autocomplete="off" value="1" readonly>
                </tbody>
            </table>
            * - Mandatory Fields
        </form>
                                </div>
                                                            </div>
                        </div><!--End First Grid-->
                    </div>
                </div>
            </div>

            <div class="grid-lg-4 grid-md-12 grid-sm-12 nopadding">
                <div class="fs-form fs-form-widget-setting boxshadow">
                    <h2 class="fs-box-title">Payments Info</h2>
                    <div class="fs-form fs-form-widget-setting">
                        <div class="editFields">
           <?php $price = 0;
            $paid = 0;
            $bal = 0;
            $price = $getNamesInfo[0]['price'];
            $paid = $pastPayments['response']['eventList'][0]['totalAmount'] - $pastPayments['response']['eventList'][0]['totalinternethandlingfee'];
            $bal = $price - $paid;
            ?>  
        <label class="widthfloat" for="affiliateavail"><b>Event Name : </b> <?php echo ucfirst($getNamesInfo[0]['title']); ?> </label>
        <label class="widthfloat" for="affiliateavail"><b>Ticket Name : </b> <?php echo ucfirst($getNamesInfo[0]['name']); ?> </label>
        <label class="widthfloat" for="affiliateavail"><b>Ticket Price : </b> <?php echo $price; ?> </label>
        <label class="widthfloat" for="affiliateavail"><b>Paid Amount : </b> <?php echo $paid; ?> </label>
        <label class="widthfloat" for="affiliateavail"><b>Balance Amount : </b> <?php echo $bal; ?> </label>
            <div class="clearBoth"></div>
        </div> 
                    </div>
                </div>
            </div>

                    </div>
    </div>

</div>

<script>
    
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    alert('Please enter valid amount')
        return false;
    }
    return true;
    }
$('input.submit').click( function() {
    var tktPrice = <?php echo $getNamesInfo[0]['price']; ?> ;
    var paid = "<?php echo $pastPayments['response']['eventList'][0]['totalAmount']; ?> ";
    var balance = <?php echo $getNamesInfo[0]['price'] - $pastPayments['response']['eventList'][0]['totalAmount'] ; ?>;
    var amount = $("#amount"). val();
    if(amount > balance){
        alert("Entered amount exceeds the balance amount");
         $('#amount').focus();
    return false;
    }
});
</script>
