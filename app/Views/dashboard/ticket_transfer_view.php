<div class="rightArea">
    <div class="fs-form">
        <h2 class="fs-box-title">Custom Fields</h2>
        <div class="editFields">
            <?php if (isset($error)) { ?>
                <div id="flashMessage" class="db-alert db-alert-danger flashHide"> <?php echo $error[0]; ?>
                </div>
            <?php } else { ?>
                <div id="flashMessage" class="db-alert flashHide" style="display:none"> 
                </div>
                <form name="customfields" id="customfields" method="post" action="" class="ticketTransferFlags">
                    <input type="hidden" name="eventId" value ="<?php echo $eventId; ?>" id="eventId"/>
                    <input type="hidden" name="eventsignupId" value ="<?php echo $eventsignupId; ?>" id="eventsignupId"/>
                    <input type="hidden" name="registrationIds[]" value ="<?php echo $eventsignupId; ?>" />
                    
                    <?php
                    $attendeeId = '';
                    //print_r($attendeedetailList);exit;
                    $i = 1;
                    foreach ($attendeedetailList as $aid => $cIdArray) {
                        $ticket_name = array_column($cIdArray, 'ticketname');
                            ?>
                            <h1>Attendee <?php echo $i++ . ' for ticket ' . $ticket_name[0]; ?></h1>
                        <?php 
                        foreach ($cIdArray as $cId => $value) {
                            ?>

                            <div class="form-group">
                                <?php
                                switch ($value['fieldtype']) {
                                    case 'textarea': ?>
                                <label><?php echo $value['fieldname']; ?><?php if ($value['fieldmandatory'] == 1) { ?><span class="mandatory"> *</span><?php } ?></label>
                                <textarea name="<?php if($value['id']!='cf_'.$aid.'_'.$cId){?>update[<?php echo $value['id']; ?>]<?php }else{?>insert[<?php echo $aid; ?>][<?php echo $cId; ?>]<?php }?>" 
                                               id="<?php echo $value['id']; ?>"><?php echo $value['value']; ?></textarea>
                                  <?php break;  case 'textbox':
                                        ?>
                                        <label><?php echo $value['fieldname'];  if ($value['fieldname'] == 'Mobile No' && strlen($value['value']) <= 10) { $value['value'] = '+91'.$value['value']; } ?><?php if ($value['fieldmandatory'] == 1) { ?><span class="mandatory"> *</span><?php } ?></label>
                                        <input type="text" class="textfield <?php if ($value['fieldname'] == 'Country') { ?>countryAutoComplete<?php } elseif ($value['fieldname'] == 'State') { ?>stateAutoComplete<?php } elseif ($value['fieldname'] == 'City') { ?>cityAutoComplete<?php } ?> <?php if ($value['fieldname'] == 'Mobile No') { echo 'mobileNoFlags'; }?>" name="<?php if($value['id']!='cf_'.$aid.'_'.$cId){?>update[<?php echo $value['id']; ?>]<?php }else{?>insert[<?php echo $aid; ?>][<?php echo $cId; ?>]<?php }?>" 
                                               id="<?php echo $value['id']; ?>"  value ="<?php echo $value['value']; ?>">
                                              <?php /*if ($value['fieldname'] == 'Mobile No') { ?>
                                               <span style="margin-bottom:20px;"><?php echo MESSAGE_COUNTRYCODE_NOTE;?></span>
                                              <?php } */?>
                    <?php break;
                case 'date':
                    ?>
                                        <label><?php echo $value['fieldname']; ?><?php if ($value['fieldmandatory'] == 1) { ?><span class="mandatory"> *</span><?php } ?></label>
                                        <input name="<?php if($value['id']!='cf_'.$aid.'_'.$cId){?>update[<?php echo $value['id']; ?>]<?php }else{?>insert[<?php echo $aid; ?>][<?php echo $cId; ?>]<?php }?>" id="<?php echo $value['id']; ?>" type="text" type="text" class="textfield form-control customValidationClass  form-datepicker" value ="<?php echo $value['value']; ?>"/>
                                        <?php break;
                                    case 'file': break;
                                    case 'radio':
                                    case 'checkbox': 
                                    case 'dropdown': ?>
                                        
                                        <label><?php echo $value['fieldname']; ?><?php if ($value['fieldmandatory'] == 1) { ?><span class="mandatory"> *</span><?php } ?></label>
                                      <?php  
                                        if($value['fieldtype']=='dropdown'){ ?> 
                                        <select id="<?php echo $value['id']; ?>" class="form-control" name="<?php if($value['id']!='cf_'.$aid.'_'.$cId){?>update[<?php echo $value['id']; ?>]<?php }else{?>insert[<?php echo $aid; ?>][<?php echo $cId; ?>]<?php }?>">
                                            <?php if(!in_array("", $value['values'])){?>
                                                <option value=""></option>
                                            <?php } ?>
                                     <?php   foreach ($value['values'] as $cfvalues) {  ?>
                                            <option value="<?php echo $cfvalues; ?>" <?php if($cfvalues==$value['value']){echo 'selected="selected"';}?>><?php echo $cfvalues; ?></option>
                                     <?php }  ?> 
                                        </select>
                                         
                                        <?php } else{ 
                                            if($value['fieldtype']=='checkbox'){
                                                $selectedvalues=  explode(',', $value['value']);
                                            }
                                            ?>
                                         <?php   foreach ($value['values'] as $cfvalues) {  ?>
                                        <input class="<?php echo $value['id'];?> <?php echo $value['fieldtype']=='radio'?'radio[]':'checkboxes[]'; ?>" name="<?php if($value['id']!='cf_'.$aid.'_'.$cId){?>update[<?php echo $value['id']; ?>]<?php }else{?>insert[<?php echo $aid; ?>][<?php echo $cId; ?>]<?php }?>[]" id="<?php echo $value['id'];?>" type="<?php echo $value['fieldtype'];?>" value="<?php echo $cfvalues;?>" <?php if(in_array($cfvalues,$selectedvalues) || $cfvalues==$value['value']){ echo 'checked="checked"';}?> /><?php echo $cfvalues;?>
                                        <?php } ?>
                                        <span id="err<?php echo $value['id']; ?>"></span>
                                            <?php }
                                        break;
                                } ?>

                                <span></span>
            <?php if ($value['fieldmandatory'] == 1) { ?>
                                    <script type="text/javascript">
                                        $(function () {
                                            var obj = {<?php echo $value['id']; ?>: {required: true}};
                <?php if ($value['fieldname'] == 'Email Id') { ?>
                                                obj[<?php echo $value['id']; ?>].email = true;
                <?php } elseif ($value['fieldname'] == 'Mobile No') { ?>
                                                obj[<?php echo $value['id']; ?>].phonePattern = true;
                                                obj[<?php echo $value['id']; ?>].minlength = 1;
                                                 
                <?php } ?>  <?php  if($value['fieldtype']=='checkbox' || $value['fieldtype']=='radio'){?>
                                            //addRules(obj);
                                            for (var item in obj) {
                                                $('.' + item + '').rules('add', obj[item]);
                                            }
                <?php }else{?>
                    for (var item in obj) {
                                                $('#' + item + '').rules('add', obj[item]);
                                            }
                    <?php }?>
                                        });
                                    </script>
            <?php } ?>
                            </div>
                        <?php }
    } ?>
            
                            
                    <div class="fs-custom-field-buttons float-right">
                        <?php 
                        if($stagedevent == 1) {
                          // echo $paymentstage;
                            if($stagedstatus == 1){
                             
                            ?>
                        <input type="submit" name="stagedstatus" class="curationapprove curationbtn" value="approve" id="stagedApprove">
                        <input type="submit" name="stagedstatus" class="curationreject curationbtn" value="reject" id="stagedReject">
                        <a class="curationapprove curationbtn" style="display: none; cursor: not-allowed;" id="stagedApproveAnchor" >Approve</a>
                        <a class="curationreject curationbtn" style="display: none; cursor: not-allowed;" id="stagedRejectAnchor" >Reject</a>
                            <?php } else{?>
                            <a class="curationapprove curationbtn"  style="cursor: not-allowed;" id="stagedApproveAnchor" ><?php if($stagedstatus == 2) { echo "Approved"; }else { echo "Approve"; } ?></a>
                            <a class="curationreject curationbtn" style="cursor: not-allowed;" id="stagedRejectAnchor" ><?php if($stagedstatus == 3) { echo "Rejected"; }else { echo "Reject"; } ?></a>
                            <?php } } ?>
                        <input id="saveSendCustomFieldsData" type="button" name="stagedstatus" class="createBtn" value="save & send mail"  />
                        <input id="saveCustomFieldsData" type="submit" name="stagedstatus" class="createBtn" value="save"/>
                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report') . '/' . $eventId . '/summary/all/1'; ?>">
                            <button type="button" class="saveBtn">cancel</button>
                        </a>
                    </div>
                </form>
<?php } ?>
        </div>
    </div>    
</div>
<script>
var loadUtilsUrl = '<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>';
    $.fn.intlTelInput.loadUtils(loadUtilsUrl);
    $(".mobileNoFlags").intlTelInput({
        autoPlaceholder: "off",
        separateDialCode: true,
    }); 

    var api_updateCFData = '<?php echo commonHelperGetPageUrl('api_updateCustomfieldsData'); ?>';
    var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch') ?>";
    var api_stateSearch = "<?php echo commonHelperGetPageUrl('api_stateSearch') ?>";
    var api_citySearch = "<?php echo commonHelperGetPageUrl('api_citySearch') ?>";
    var api_dashboardtransaction = "<?php echo commonHelperGetPageUrl('dashboard-transaction-report') ?>";
</script>

<script>
    window.onload = function (e){
        setCountryFlag('mobileNoFlags','class');
    }

</script>