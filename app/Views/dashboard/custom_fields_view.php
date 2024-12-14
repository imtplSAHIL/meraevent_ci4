<div class="rightArea">
<!--    <div class="rightSec">
        <div class="search-container">
            <input class="search searchExpand icon-search"
                   id="searchId" type="search"
                   placeholder="Search">
            <a class="search icon-search"></a> </div>
    </div>-->
    <div class="heading float-left">
        <h2>Event: <span><?php echo $eventTitle; ?></span></h2>
        <p>Setup the registration form for this event. Use the checkboxes to specify which fields should apply to attendees. Checkboxes that are disabled are mandatory information
            collected by default. You can choose from and add predetermined fields to the registration form or create your own custom field. You can also re-order the fields in the
            form by dragging and dropping them.</p>
    </div>
    <div class="clearBoth"></div>
    <!--Data Section Start-->

    <div class="float-right"> <a id="add_custom_field" href="javascript:void(0);" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add custom fields</a> </div>
    <div class="clearBoth"></div>
    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
    <?php
    if (isset($errors)) {
        echo $errors[0];
    } else {
        ?>
        <div class="tablefields">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="customFieldsDataTable" data-tablesaw-minimap>
                <thead>
                    <tr>
                        <th scope="col" data-tablesaw-priority="persist">Field Name</th>
                        <th scope="col" data-tablesaw-priority="3">Field Type</th>
                        <th scope="col" data-tablesaw-priority="3" style="width:10% !important;">Mandatory</th>
                        <th scope="col" data-tablesaw-priority="3" style="width:10% !important;">Display<br />on Ticket</th>
                        <th scope="col" data-tablesaw-priority="3">Status</th>
                        <th scope="col" data-tablesaw-priority="3" style="width:10% !important;">Level</th>
                        <th scope="col" data-tablesaw-priority="3">Custom<br />Validation</th>
                        <th scope="col" data-tablesaw-priority="3">Order</th>
                    </tr>
                </thead>
                    <tbody>
                    <?php
                    $customFieldsHideArray = array();
                    $hideInvoiceCustomFields = array(11,12,13);
                    $count = 1;
                    
                    foreach ($customFieldData as $key => $value) {
                        // if ($value['fieldlevel'] == 'ticket' && empty($value['other_ticketids'])) {
                        //     continue;
                        // }
                        if(in_array($value['commonfieldid'], $hideInvoiceCustomFields)) continue;
                        $trClass = 'class="customfieldRow"';
                        $label = "yes";
                        $className = 'orangrBtn';
                        $buttonValue = 'hide';
                           if ($value['displaystatus'] == 1) {
                               ++$count;
                               if(in_array($value['fieldname'], $this->config->item('default_customfileds'))){ 
                                 $label = "no";
                               }else{
                                 $className = 'greenBtn';
                                 $buttonValue = 'show';
                                }
                            }  else {
                                $customFieldsHideArray[$key] = $value;
                               
                            }   
                           if ($count % 2 != 0) {
                            $trClass = 'class="customfieldRow odd"';
                            }else{
                                $trClass = 'class="customfieldRow"';
                        }
                        if($label == "no" || $buttonValue != 'hide') { ?>
                        <tr <?php echo $trClass; ?>>
                            <td style="text-transform:none;"><?php echo $value['fieldname']; ?></td>
                            <td><?php echo $value['fieldtype']; ?></td>
                            <td><input id="mandatory<?php echo $value['id']; ?>" class="mandatory" type="checkbox" name="sport[]" value="<?php echo $value['id']; ?>" <?php
                                if ($value['fieldname'] !== 'Full Name' && $value['fieldmandatory'] == 1) {
                                    echo 'checked=checked';
                                }
                                if (in_array($value['fieldname'], $this->config->item('default_customfileds'))) {
                                    echo 'checked="checked" disabled="disabled"';
                                }
                                ?>></td>
                            <td><input id="displayonticket<?php echo $value['id']; ?>" class="displayonticket" type="checkbox" name="sport[]" value="<?php echo $value['id']; ?>" <?php
                                if ($value['fieldname'] !== 'Full Name' && $value['displayonticket'] == 1) {
                                    echo 'checked=checked';
                                }
                                if ($value['fieldname'] == 'Full Name' || ($value['commonfieldid'] == 11 && !in_array($value['commonfieldid'], $hideInvoiceCustomFields))
                                        || $value['fieldname'] == 'Company Address' || $value['fieldname'] == 'GST Number') {
                                    echo 'checked="checked" disabled="disabled"';
                                }
                                
                                if ($value['fieldtype'] == 'file'  ) {
                                	echo ' disabled="disabled"';
                                }
                                ?>></td>
                            <?php 
                            
                            if (in_array($value['fieldname'], $this->config->item('default_customfileds'))) { ?>
                                <td style="text-align: center;"><button onclick="editCustomField('<?php echo $value['id']; ?>')" id="editCustomField<?php echo $value['id']; ?>" type="button" class="editCustomField btn blueBtn" >Edit</button></td>
                                <?php } else { ?>
                                <td>
                                    <button id="displaystatus<?php echo $value['id']; ?>" value="<?php echo $value['id']; ?>" type="button" class="btn <?php echo $className; ?> displaystatus"><?php echo $buttonValue ?></button>
                                    <?php if (!empty($value['commonfieldid']) || $value['customfieldid'] == 0) {
                                        ?>
                                        <button onclick="editCustomField('<?php echo $value['id']; ?>')" id="editCustomField<?php echo $value['id']; ?>" type="button" class="editCustomField btn blueBtn">Edit</button>
                                <?php }
                                ?>
                                </td>
                                    <?php } ?>
                    <!--<td><?php echo (isset($indexedEventTickets[$value['ticketid']]['name'])) ? $indexedEventTickets[$value['ticketid']]['name'] : ''; ?></td>-->
                    		
                    
                            <td><?php echo $value['fieldlevel']; ?></td>
                            <td><?php if($value['fieldtype'] == 'textbox'){ ?><a href="<?php echo commonHelperGetPageUrl("dashboard-customField_curation", $eventId."&".$value['id']); ?>" id="<?php echo $value['id']; ?>" class="createBtn float-left font14">Add/Update</a><?php }?></td>
                            <td><input id="ordervalue<?php echo $value['id']; ?>" type="text" value="<?php echo $value['order']; ?>" class="CustomOrder" disabled><span id="<?php echo $value['id']; ?>" class="orderIcon icon-edit"></span></td>
                        </tr>
                    <?php }  } 
                       foreach ($customFieldsHideArray as $key => $value) {
                           ++$count;
                           $trClass = 'class="customfieldRow"';
                            if ($count % 2 != 0) {
                            $trClass = 'class="customfieldRow odd"';
                        }else{
                            $trClass = 'class="customfieldRow"';
                        }
                         $className = 'orangrBtn';
                         $buttonValue = 'hide';?>
                           <tr <?php echo $trClass; ?>>
                            <td style="text-transform:none;"><?php echo $value['fieldname']; ?></td>
                            <td><?php echo $value['fieldtype']; ?></td>
                            <td><input id="mandatory<?php echo $value['id']; ?>" class="mandatory" type="checkbox" name="sport[]" value="<?php echo $value['id']; ?>" <?php
                                if ($value['fieldname'] !== 'Full Name' && $value['fieldmandatory'] == 1) {
                                    echo 'checked=checked';
                                }
                                ?>></td>
                            <td><input id="displayonticket<?php echo $value['id']; ?>" class="displayonticket" type="checkbox" name="sport[]" value="<?php echo $value['id']; ?>" <?php
                                if ($value['fieldname'] !== 'Full Name' && $value['displayonticket'] == 1) {
                                    echo 'checked=checked';
                                }
                               ?>></td>
                               <td>
                                    <button id="displaystatus<?php echo $value['id']; ?>" value="<?php echo $value['id']; ?>" type="button" class="btn <?php echo $className; ?> displaystatus"><?php echo $buttonValue ?></button>
                                    <?php if ($value['commonfieldid'] == 0) {
                                        ?>
                                        <button onclick="editCustomField('<?php echo $value['id']; ?>')" id="editCustomField<?php echo $value['id']; ?>" type="button" class="editCustomField btn blueBtn">Edit</button>
                                <?php }
                                ?>
                                </td>
      
                    <!--<td><?php echo (isset($indexedEventTickets[$value['ticketid']]['name'])) ? $indexedEventTickets[$value['ticketid']]['name'] : ''; ?></td>-->
                    		
                            <td><?php echo $value['ticketName']; ?></td>
                            <td>&nbsp;</td>
                            <td><input id="ordervalue<?php echo $value['id']; ?>" type="text" value="<?php echo $value['order']; ?>" class="CustomOrder" disabled><span id="<?php echo $value['id']; ?>" class="orderIcon icon-edit"></span></td>
                        </tr>
                       <?php }
                       ?>
                </tbody>
            </table>
        </div>
<?php } ?>
</div>

<script>
var dasboard_configureAddcustomfields = "<?php echo commonHelperGetPageUrl('dasboard-configureAddcustomfields')?>";
var api_configureGetDashboardEventCustomFields = '<?php echo commonHelperGetPageUrl('api_configureGetDashboardEventCustomFields');?>';
var api_configureUpdateStatus = '<?php echo commonHelperGetPageUrl('api_configureUpdateStatus');?>';
var api_reportsGetReportDetails = "<?php echo commonHelperGetPageUrl('api_reportsGetReportDetails')?>";

 </script>
 
<?php include_once 'cf_validation_file_upload.php'; ?>