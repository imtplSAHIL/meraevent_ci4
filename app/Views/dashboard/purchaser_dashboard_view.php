<!--Right Content Area Start-->

<div class="rightArea">
    <?php $GPTW_EVENTS_ARRAY = GPTW_EVENTS_ARRAY; ?>
    <form action='' method="POST" />
    <div class="heading">
    <h2> <?php if(!empty($GPTW_EVENTS_ARRAY[$eventId])) { echo "Confirmed Purchaser Details"; } else { echo "Export Reports"; } ?> : <span> <?php echo isset($eventTitle) ? $eventTitle : ''; ?></span></h2>
    </div>
    <!--Data Section Start-->
    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
    <input type="hidden" name="page" id="page" value="<?php echo $page; ?>"/>
    <input type="hidden" name="promoterCode" id="promoterCode" value="<?php echo $promoterCode; ?>"/>
    <input type="hidden" name="currencyCode" id="currencyCode" value="<?php echo $currencyCode; ?>"/>
    <input type="hidden" name="transactionType" id="transactionType" value="<?php echo $transactionType; ?>"/>

    <?php $qString= "";

    if (isset($promoterCode) && !empty($promoterCode)){
        $qString .= 'promotercode='.$promoterCode;
    }else if(isset($currencyCode) && !empty ($currencyCode)){
        $qString .= '&currencycode='.$currencyCode;
    }


    ?>
    <input type="hidden" name="qString" id="qString" value="<?php echo $qString; ?>"/>
    <div class="fs-transtaction-actions">
        <div class="fs-filter-actions">
            <?php if(!isset($showFilters)){
                $transactionTypes = array(
                    'card' => 'Card Transactions',
                    'free' => 'Free Transactions',
                    'incomplete' => 'Lead Transactions',
                    'failed' => 'Incomplete Transactions',
                    'viral' => 'Viral Transactions',
                    'organizer' => 'Organizer Marketing Reports',
                    'affiliate' => 'Affiliate Marketing Reports',
                    'offline' => 'Offline Transactions',
                    'boxoffice' => 'Box Office Transactions',
                    'cancel' => 'Cancel Transactions',
                    'meraevents' => 'MeraEvents Marketing Reports',
                    'spotregistration' => 'Spot Registration Transactions'
                );

                ?>
                <div class="defaultDroplist widthfloat pb-30imp margintop10">
                    <div>
                        <label class="icon-downarrow">
                            <select name="selectTransType" id="selectTransType">
                                <option <?php if ($transactionType == 'all') { ?>selected="selected"<?php } ?> value="all">All  Transactions</option>
                                <?php foreach ($transactionTypes as $key => $value) { ?>
                                    <option <?php if ($transactionType == $key) { ?>selected="selected"<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </div>

                    <div>
                        <label class="icon-downarrow">
                            <select name="selectTicketType" id="selectTicketType">
                                <option value="0">Select Ticket</option>
                                <?php foreach ($ticketsData as $ticket) { ?>
                                    <option <?php
                                    if ($ticketId == $ticket['id']) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $ticket['id']; ?>"><?php echo $ticket['name']; ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </div>

                    <?php

                    if($eventSettings['stagedevent'] == 1) { ?>
                        <div>
                            <label class="icon-downarrow">
                                <select name="selectStagedRegistrationState" id="selectStagedRegistrationState" style="width: 260px">
                                    <option value="0"><?php echo ($eventSettings['paymentstage'] == 1)?"Select Prepaid Registration State":"Select Postpaid Registration State";?></option>
                                    <?php foreach ($stagedRegistrationStates as $stagedRegistrationStateKey => $stagedRegistrationStateValue) { ?>
                                        <option <?php
                                        if ($stagedRegistrationStateKey == $selectStagedRegistrationState) {
                                            echo "selected";
                                        }
                                        ?> value="<?php echo $stagedRegistrationStateKey; ?>"><?php echo $stagedRegistrationStateValue; ?></option>
                                    <?php } ?>
                                </select>
                            </label>
                        </div>
                        <?php if($eventSettings['paymentstage'] == 2){ ?>
                            <!--  <div>
                <label class="icon-downarrow">
                      <select name="selectStagedPaymentStatus" id="selectStagedPaymentStatus" style="width: 235px" >
                        <option value="0">Select Staged Payment Status</option>
                        <?php /*foreach ($stagedPaymentStatus as $stagedPaymentStatusKey => $stagedPaymentStatusValue) { ?>
                            <option <?php
                            if ($stagedPaymentStatusKey == $selectStagedPaymentStatus) {
                                echo "selected";
                            }
                            ?> value="<?php echo $stagedPaymentStatusKey; ?>"><?php echo $stagedPaymentStatusValue; ?></option>
                            <?php } */ ?>
                    </select>
                </label>
            </div>  -->
                        <?php } ?>
                    <?php } ?>
                    <div class="fs-summary-detail">
                        <?php if ($transactionType != 'cancel') { ?>
                            <label style="float:left;"> <input class="reportType" type="radio" name="reportType" value="summary" <?php if ($reportType == 'summary') { ?>checked="checked" <?php } ?>>
                                Summary</label>
                        <?php } ?>
                        <?php if ($transactionType != 'incomplete') { ?>
                            <label style="float:left;"> <input class="reportType" type="radio" name="reportType" value="detail" <?php if ($reportType == 'detail') { ?>checked="checked" <?php } ?>>
                                Detail</label>
                        <?php } ?>
                    </div>
                    <?php if (isset($downloadAllRequired)) { ?>
                        <div>
                            <button id="downloadAll" name="downloadAll" class="Btn" type="button">Download all files</button>
                            <p id="download_files" style=" text-align: center;padding: 0;margin: 10px 0;"></p>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="fs-export-email fs-export-reports-special">
            <?php if($errors){ ?>
                <button type="button" class="Btn blueborder" name="exportReports"  onClick="alert('No records found')";><span class="icon-export"></span>Export</button>
            <?php }else{ ?>
                <button type="button" class="Btn blueborder" name="exportReports" id="exportReports"><span class="icon-export"></span>Export</button>
            <?php }?>
            <!--        <button type="button" class="Btn"><span class="icon-mail"></span>email body</button>-->
            <?php if(!isset($showFilters)){ ?>
                <button type="button" class="Btn greenborder" name="emailAttachedReports" id="emailAttachedReports"><span class="icon-attachment"></span>Email Attachment</button>
            <?php } ?>
        </div>
    </div>
<?php if($transactionType != 'failed'){  ?>
    <table width="100%">
        <?php if ($transactionType != 'incomplete') { ?>

            <tr class="TotalTable">
                <td colspan="12" style="border:none;padding: 0;">
                    <table width="100%" align="left" cellpadding="0" cellspacing="0" style="background:none; font-size:24px; font-weight:normal; border:none;" class="TransactionTotalDiv">
                        <tbody>
                        <tr>
                            <td colspan="2">
                                <span class="transactiontitle">Total Quantity</span>
                                <span id="quantitySum"><?php echo isset($grandTotal['totalquantity']) ? $grandTotal['totalquantity'] : 0; ?></span>
                            </td>
                            <td colspan="2"><span class="transactiontitle">Ticket Amount</span>
                                <span id="amountSum"><?php
                                    if (isset($grandTotal['totalamount']) && is_array($grandTotal['totalamount'])) {
                                        $currencyStr = '';
                                        foreach ($grandTotal['totalamount'] as $key => $value) {
                                            if (!empty($key) && strpos($key, 'quantity') == false && $key != 'FREE' && $key != 'quantity') {
                                                $currencyStr.=$key . ' ' . $value . "</br>";
                                            }
                                        }
                                        echo (!empty($currencyStr)) ? $currencyStr : '0';
                                    } else {
                                        echo '0';
                                    }
                                    ?></span>
                            </td>
                            <td colspan="2"><span class="transactiontitle">Taxes</span>
                                <span id="amountSum">
                                          <?php
                                          if (isset($grandTotal['totaltaxes']) && is_array($grandTotal['totaltaxes']) && !empty($grandTotal['totaltaxes']) && $transactionType != 'free') {
                                              foreach ($grandTotal['totaltaxes'] as $ttkey => $ttvalue) {
                                                  if ($ttkey != '') {
                                                      echo $ttkey . ' ' . $ttvalue . "<br>";
                                                  }
                                              }
                                          } else {
                                              echo '0';
                                          }
                                          ?>
                                      </span>
                            </td>
                            <td colspan="2"><span class="transactiontitle">Total Discount</span>
                                <span id="amountSum"><?php
                                    if (isset($grandTotal['totaldiscount']) && is_array($grandTotal['totaldiscount'])) {
                                        $currencyStr = '';
                                        foreach ($grandTotal['totaldiscount'] as $key => $value) {
                                            if (!empty($key)) {
                                                $currencyStr.=$key . ' ' . $value . "</br>";
                                            }
                                        }
                                        echo !empty($currencyStr) ? $currencyStr : '0';

                                    } else {
                                        echo '0';
                                    }
                                    ?></span>
                            </td>
                            <td colspan="2"><span class="transactiontitle">Referral Amount</span>
                                <span id="amountSum"><?php
                                    if (isset($grandTotal['referralamount']) && is_array($grandTotal['referralamount'])) {
                                        $currencyStr = '';
                                        foreach ($grandTotal['referralamount'] as $key => $value) {
                                            if (!empty($key)) {
                                                $currencyStr.=$key . ' ' . $value . "</br>";
                                            }
                                        }
                                        echo !empty($currencyStr) ? $currencyStr : '0';

                                    } else {
                                        echo '0';
                                    }
                                    ?></span>
                            </td>
                            <td colspan="2"><span class="transactiontitle">Total Amount</span>
                                <span id="paidSum"><?php
                                    if (isset($grandTotal['totalpaid']) && is_array($grandTotal['totalpaid'])) {
                                        $currencyStr = '';
                                        foreach ($grandTotal['totalpaid'] as $key => $value) {
                                            if (strpos($key, 'quantity') !== false) {}else{
                                                if (!empty($key) && $key != 'FREE') {
                                                    $currencyStr.=$key . ' ' . $value . "</br>";
                                                }
                                            }
                                        }
                                        echo!empty($currencyStr) ? $currencyStr : '0';
                                    } else {
                                        echo '0';
                                    }
                                    ?></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php }else{  ?>
    
    
    
    <?php } ?>    
    <div class="clearBoth"></div>
    <!--Curation Events Buttons-->
    <?php if($eventSettings['stagedevent'] == 1 && $reportType == 'summary'){ ?>
        <div class="CurationBox">
            <div class="grid-md-5 grid-sm-5 curationselect">
                <label><input type="checkbox" name="" id="selectall" ><b>Select All Transactions</b></label>
            </div>
            <div class="grid-md-5 grid-sm-5 pull-right curationbtngroup">
                <input type="submit" name="stagedstatus" class="curationapprove curationbtn" value="approve" />
                <input type="submit" name="stagedstatus" class="curationreject curationbtn" value="reject" />
                <!-- <input type="submit" name="stagedstatus" class="curationhold curationbtn" value="hold" /> -->
            </div>
        </div>
    <?php } ?>
    <!--Curation Events Buttons-->
    <div class="refundSec bottomAdjust100" <?php if($eventSettings['stagedevent'] == 1 ){ ?> style="width: 100%; overflow: scroll;" <?php } ?> >
        <?php if (count($headerFields) > 0) { ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="transactionTable" class="transactionTable">
            <thead>
            <tr>
                <?php foreach ($headerFields as $value) {
                    ?>
                    <th scope="col" data-tablesaw-priority="2"><?php echo $value; ?></th>
                <?php } ?>
                <?php 
                if (isset($fileCustomFieldArray) && count($fileCustomFieldArray)) {
                    foreach ($fileCustomFieldArray as $custId => $custName) {
                        $custIdArray[] = $custId;
                        ?>
                        <th scope="col" data-tablesaw-priority="1"><?php echo $custName; ?></th>
                        <?php
                    }
                }
                ?>
                <?php  if ($reportType == 'summary' && $transactionType != 'failed') {  ?>

                    <!--Curation-->

                    <!--Curation-->
                <?php }
                if($eventSettings['stagedevent'] == 1 ){
                    if($reportType == 'summary'){
                        ?>
                        <th scope="col" data-tablesaw-priority="1">ACTION</th>
                    <?php } ?>
                    <th scope="col" data-tablesaw-priority="1">STATUS</th>
                    <th scope="col" data-tablesaw-priority="1">PAYMENT STATUS</th>
                    <?php
                    if($reportType == 'summary'){
                        ?>
                        <!--<th scope="col" data-tablesaw-priority="1">RESEND EMAIL</th>-->
                    <?php }
                }
                ?>
            </tr>
            </tr>
            </thead>
            <?php } ?>
            <tbody>
            <?php if (isset($errors)) { ?>
                <tr>
                    <td colspan="9"><div class="db-alert db-alert-info"><?php print_r($errors[0]); ?></div></td>
                </tr>
                <?php
            } else {
                if($transactionType != 'failed'){
            $SNo = ($page-1)*REPORTS_DISPLAY_LIMIT + 1;
            $loop = 1;
            if ($reportType == 'detail') {
                $signUpId = 0;
                foreach ($transactionList as $transaction) {
                    foreach ($transaction as $value) {
                        foreach ($value['ticketDetails'] as $ticket) {
                                
                            ?>
                            <tr>
                                <td><?php echo ($signUpId != $value['id']) ? $SNo++ : ' ' ; ?></td>
                                <?php if ($transactionType != 'incomplete') { ?>
                                    <td><?php echo $value['id']; ?></td>
                                <?php } ?>
                                <td><span><?php echo $value['signupDate']; ?></span></td>
                                <td><?php echo $ticket['tickettype']; ?></td>
                                <?php if ($transactionType == 'affiliate'  || $transactionType == 'globalaffiliate') { ?>
                                    <td><?php echo $ticket['promotercode']; ?></td>
                                <?php } ?>
                                <td><?php echo $value['contactDetails']['name'] . '<br>' . $value['contactDetails']['email'] . '<br>' . $value['contactDetails']['phone']; ?></td>
                                <td><?php echo $ticket['quantity']; ?></td>
                                <td><?php echo $ticket['amount']; ?></td>
                                <?php if ($transactionType != 'incomplete' && $transactionType != 'cancel') { ?>
                                    <td><?php echo $value['paid'];
                                        ?></td>
                                    <td><?php echo $value['discount']; ?>
                                        <!--                                            <span class="float-right grayBg icon-add view"></span>--></td>
                                    <td><?php echo $value['referralamount']; ?></td>
                                <?php } elseif ($transactionType == 'incomplete') {
                                    ?>
                                    <?php 
                                        if($eventId == 234986 || $eventId == 240049 || $eventId == 245850)
                                        {
                                            echo "<td>".$ticket['failedcount']."</td>";
                                        }
                                    ?>
                                    <td><?php echo $ticket['comment']; ?>
                                        <!--<span class="float-right grayBg icon-add view"></span>-->
                                    </td>
                                <?php } else {
                                    ?>
                                    <td><?php echo $value['paid'];
                                        ?></td>
                                    <td><?php
                                        if(isset($value['comment']) && !empty($value['comment'])){
                                            foreach ($value['comment']  as $vcmtkey => $vcmtvalue) {
                                                echo ($vcmtkey+1).'. '.$vcmtvalue."<br>";
                                            }
                                        }

                                        ?>
                                        <!--<span class="float-right grayBg icon-add view"></span>-->
                                    </td>
                                    <?php
                                }
                                $colspan = '9';
                                if ($transactionType == 'cod') {
                                    $colspan = '12';
                                    ?>
                                    <td><?php echo $ticket['comment']; ?></td>
                                    <td><?php echo $ticket['status']; ?></td>
                                    <td><?php echo $ticket['deliverystatus']; ?></td>
                                <?php } ?>
                                <?php

                                if (isset($custIdArray) && count($custIdArray) > 0) {

                                    foreach ($custIdArray as $key => $id) {
                                        $path = '';
                                        if (isset($ticket['customfields'][$id]['value'])) {
                                            $path = $ticket['customfields'][$id]['value'];
                                        }
                                        if (strlen($path) > 0) {
                                            ?>
                                            <td><a href="<?php echo $path; ?>" target="_blank">View</a> | <br/><a href="<?php echo commonHelperGetPageUrl('download-file','','?filePath='.$path); ?>">Download</a></td>

                                        <?php } else { ?>
                                            <td>&nbsp;</td>
                                            <?php
                                        }
                                    }
                                    ?>

                                <?php }


                                if($eventSettings['stagedevent'] == 1){?>


                                    <!--Curation-->
                                    <!-- <td><?php // if($value['stagedstatus'] == 1) { ?><input type="checkbox" name="registrationIds[]" value="<?php // echo $value['id']; ?>"> <?php // } ?></td> -->
                                    <td><b><?php if($value['stagedstatus'] == 1){ echo 'Registered'; } else if($value['stagedstatus'] == 2){ echo 'Approved'; } else if($value['stagedstatus'] == 3){ echo 'Rejected'; }else{ echo $value['stagedstatus']; } ?></b></td>
                                    <td><b><?php

                                            $paidStatus = 'Not paid';
                                            if($eventSettings['stagedevent'] == 1 && $value['transactionstatus'] == 'success' && in_array($eventSettings['paymentstage'],array(1,2))  && !in_array($value['paymentstatus'],array('Refunded','Canceled')) || $ticket['amount'] == '0' ){
                                                $paidStatus = 'Paid';
                                            }
                                            echo $paidStatus;
                                            // paymentstage
                                            ?> </b></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        $signUpId = $value['id'];
                    }
                }
            } else {
                







                foreach ($transactionList as $value) {
                    $loop = 1;
                    $bookedTicketsCount = count($value['ticketDetails']);
                    $forActionCheckBox = 0;
                    // foreach ($value['ticketDetails'] as $key => $ticket) {
                        $forActionCheckBox++;
                        if(empty($purchaser_data[$value['id']]))
                        {
                            continue;
                        }
                        if(empty($purchaser_data[$value['id']]['purchaser_date']))
                        {
                            $new_datetime = DateTime::createFromFormat ( "Y-m-d H:i:s", $value['signupDate'] );
                            $purchaser_data[$value['id']]['purchaser_date'] = $new_datetime->format('d/m/Y'); //, $value['signupDate']
                        }
                        ?>
                        <tr>
                            <td><?php echo $loop == 1 ? $SNo++ : ''; ?></td>
                            <td><span><?php echo $loop == 1 ? $purchaser_data[$value['id']]['purchaser_date'] : ''; ?></span></td>
                            <td><?php echo $purchaser_data[$value['id']]['org_name']; ?></td>
                            <td><?php echo $purchaser_data[$value['id']]['first_name']. ' '.$purchaser_data[$value['id']]['last_name']; ?></td>
                            <td><?php echo $purchaser_data[$value['id']]['email_id']; ?></td>
                            <td><?php echo $purchaser_data[$value['id']]['mobile']; ?></td>
                            <td><?php echo $purchaser_data[$value['id']]['quantity']; ?></td>
                            <td><?php if($value['paymenttransactionid'] == 'Offline') { echo $value['paymenttransactionid']; } else { echo 'Online'; } ?></td>
                            <td><?php echo $purchaser_data[$value['id']]['tax_invoice_number']; ?></td>
                            <?php if ($transactionType != 'incomplete' && $transactionType != 'cancel') { ?>
                                <td><?php echo $value['paid'];
                                    ?></td>
                                
                            <?php }
                            $colspan = '9';
                           
                            if (isset($custIdArray) && count($custIdArray) > 0 ) {
                                foreach ($custIdArray as $key => $id) {
                                    if($bookedTicketsCount == $loop){
                                        $path = '';
                                        if (isset($value['customfields'][$id])) {
                                            $path = $value['customfields'][$id];
                                        }
                                        if (strlen($path) > 0) {
                                            ?>
                                            <td><a href="<?php echo $path; ?>" target="_blank">View</a> | <br/><a href="<?php echo commonHelperGetPageUrl('download-file','','?filePath='.$path);?>">Download</a></td>
                                        <?php } else { ?>
                                            <td>&nbsp;</td>
                                            <?php
                                        }
                                    }else{
                                        echo "<td>&nbsp;</td>";
                                    }
                                }
                                ?>
                            <?php }
                            ?>
                            <td>
                                    <?php
                                      if (!empty($GPTW_EVENTS_ARRAY[$eventId]))
                                        {
                                            ?>
                                            <a href='<?php echo commonHelperGetPageUrl('dashboard-edit-offline-purchaser', $value['id']);?>' title="Edit Details" >Edit Invoice</a> <br /><br />
                                            
                                            <?php
                                            if($GPTW_transactions[$value['id']]['raise_tax_invoice'] != 1) {
                                                ?>
                                            <a href="#" onclick="return func_confirm_raise_tax_invoice('<?php echo commonHelperGetPageUrl('raise-tax-invoice', $value['id']); ?>')" > Raise Tax Invoice</a> <br /><br />
                                            <?php
                                            }
                                            else
                                            {
                                                echo "Raise Tax Invoice <br /><br />";
                                            }
                                            ?>
                                            
                                            <?php
                                            if($GPTW_transactions[$value['id']]['raise_tax_invoice'] == 1) {
                                            ?>
                                            <a target="_blank" href='<?php echo commonHelperGetPageUrl('dashboard-email-tax-invoice', $value['id']);?>' > Email Tax Invoice</a> <br /><br />
                                            <?php
                                            }
                                            else
                                            {
                                                echo "Email Tax Invoice <br /><br />";
                                            }
                                            ?>
                                            <a target="_blank" href='<?php echo commonHelperGetPageUrl('dashboard-download-tax-invoice', $value['id']);?>' >Download Tax Invoice</a>
                                        <?php
                                        }
                                        ?>
                             </td>
                            <?php if($eventSettings['stagedevent'] == 1){ ?>
                                <!--Curation-->
                                <td><?php if($value['stagedstatus'] == 1 && $forActionCheckBox == 1) { ?><input type="checkbox" name="registrationIds[]" value="<?php echo $value['id']; ?>"> <?php }?></td>
                                <td><b><?php if($value['stagedstatus'] == 1){ echo 'Registered'; } else if($value['stagedstatus'] == 2){ echo 'Approved'; } else if($value['stagedstatus'] == 3){ echo 'Rejected'; }else{ echo $value['stagedstatus']; } ?></b></td>
                                <td><b><?php

                                        $paidStatus = 'Not paid';
                                        if($eventSettings['stagedevent'] == 1 && $value['transactionstatus'] == 'success' && in_array($eventSettings['paymentstage'],array(1,2))  && !in_array($value['paymentstatus'],array('Refunded','Canceled')) || $ticket['amount'] == '0'){
                                            $paidStatus = 'Paid';
                                        }
                                        echo $paidStatus;
                                        // paymentstage
                                        ?> </b></td>
                               

                                <!--Curation-->
                            <?php } ?>
                        </tr>
                        <?php
                        $loop++;
                    // }
                }
            }
            ?>
            </tbody>
        </table>
    <?php if ($totalTransactionCount > REPORTS_DISPLAY_LIMIT) { ?>
        <div class="float-right dropwidth100">
            <?php
            $totalTrns = $grandTotal['totalquantity'];
            $url_dashboardReports = commonHelperGetPageUrl('url_dashboardReports')."/$eventId/$reportType/$transactionType/";
            if (REPORTS_DISPLAY_LIMIT > $totalTrns) {
                $loopCount = 1;
            } else {
                $loopCount = ceil($totalTransactionCount / REPORTS_DISPLAY_LIMIT);
            }
            if($loopCount > 1){
                for ($i=1; $i <= $loopCount; $i++) {
                    if($i == $page){
                        echo "<a class='Btn blueborder' href ='".$url_dashboardReports."$i"."'> <b> <u> $i </u> </b> </a>";
                    }
                    else{
                        echo "<a class='Btn blueborder' href ='".$url_dashboardReports."$i".'?ticketid='.$ticketId."'> $i </a>";
                    }
                }
            }
            ?>
        </div>
    <?php } ?>
    <input type="hidden" name="SNo" id="SNo" value="<?php echo $SNo; ?>"/>
    <input type="hidden" name="displaylimit" id="displaylimit" value="<?php echo REPORTS_DISPLAY_LIMIT; ?>"/>
    <input type="hidden" name="totalTransactionCount" id="totalTransactionCount" value="<?php echo $totalTransactionCount; ?>"/>
    <?php if(isset($custIdArray)){?>
        <input type="hidden" name="custIds" id="custIds" value="<?php echo json_encode($custIdArray) ?>" />
    <?php }?>
     <?php }else{?>
                <?php
                $i = 1;
         foreach($grandTotal['response']['transactionList'] as $transactions){
             ?>
        <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo date($transactions['eventsignupid']); ?></td>
                        <td><?php echo $transactions['signupdate']; ?></td>
                        <td><?php echo $transactions['ticketname']; ?></td>
                        <!-- <td><?php //echo $transactions['transactiontickettype']; ?></td> -->
                        <td><?php echo $transactions['name'] . '<br>' . $transactions['email'] . '<br>' . $transactions['mobile']; ?></td>
                        <td><?php echo $transactions['quantity']; ?></td>
                        <td><?php echo $transactions['pg_status']; ?></td>                       
                        <td><?php echo $transactions['pg_amount']; ?></td>
                        <td><?php echo $transactions['pg_message']; ?></td>

        </tr>
                 <?php
         }
         ?>
             <?php
                } } ?>
        </form>
        <script>
            var api_eventResendEmail = "<?php echo ($eventSettings['stagedevent'] == 1) ? commonHelperGetPageUrl('api_stagedEventResendEmail') : commonHelperGetPageUrl('api_resendDelegateEmail') ?>";
            var staged = "<?php echo ($eventSettings['stagedevent'] == 1) ? 1 : 0 ?>";
        </script>