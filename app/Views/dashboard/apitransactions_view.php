<!--Right Content Area Start-->
<div class="rightArea">
    <div class="heading">
        <h2>API Transactions</h2>
    </div>
    <!--Data Section Start-->
    <div class="fs-transtaction-actions">
	<div class="fs-filter-actions">
            <?php echo form_open(''); ?>
                <div class="defaultDroplist widthfloat margintop10">
                    <div class="grid-lg-12 nopadding">
                        <input type="text" value="all" id="transactiontype" name="transactiontype" hidden>
                        <div class="grid-lg-2">
                            <input type="text" class="textfield mb-0imp"  placeholder="Enter Event Id" name="eventid" id="eventid" value="<?php echo (isset($formdata['eventid']))? $formdata['eventid']: ''; ?>">
                         </div>
                        
                        
                        <div class="grid-lg-2">
                            <input type="text" name="startdate" id="startdate" class="textfield datepicker mb-0imp valid" value="<?php echo (isset($formdata['startdate']))? $formdata['startdate']: ''; ?>" >
                         </div>
                        <div class="grid-lg-2">
                            <input  type="text" name="enddate" id="enddate" class="textfield datepicker mb-0imp valid" value="<?php echo (isset($formdata['enddate']))? $formdata['enddate']: ''; ?>" >
                         </div>
            
                        <input type="text" name="hiddenDate"  id="hiddenDate" value="<?php echo date("m/d/Y"); ?>" hidden="">                         
                        <input type="text" id="hiddenPage" name="page" value="<?php echo (isset($formdata['page']))? $formdata['page']: ''; ?>" hidden="">

                    </div>
                </div>
            <div class="grid-lg-12 widthfloat nopadding">
                <div class="grid-lg-4">
                    <input type="button" value="Search" id="searchButton" class="createBtn">
                </div>
            </div>
            </form>
        </div>
    </div>
    
    
    <?php if(isset($totalTransactions) && $totalTransactions > 0){ ?>
    
    <div class="grid-lg-11">
        <table class="widthfloat">
            <tr class="TotalTable">
                <td style="border:none;padding: 0;">
                   <table width="100%" align="left" cellpadding="0" cellspacing="0" style="background:none; font-size:24px; font-weight:normal; border:none;" class="TransactionTotalDiv">
                        <tbody>
                           <tr>
                              <td colspan="2">
                                 <span class="transactiontitle">Total Quantity</span>
                                 <span id="quantitySum"><?php echo $searchSummary['quantity']; ?></span>
                              </td>
                              <td colspan="2"><span class="transactiontitle">Total Amount</span> 
                                 <span id="amountSum">
                                     <?php foreach($searchSummary['amount'] as $key => $value){
                                        echo $key.' '.$value; 
                                        echo '<br/>';
                                      } ?>
                                     </span>
                              </td>
                           </tr>
                        </tbody>
                     </table> 
                </td>
            </tr>
        </table>

    </div>
    <?php } ?>
    
    <div class="clearBoth"></div>
    <div class="refundSec bottomAdjust100">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="transactionTable" class="transactionTable">
                <?php if (count($headerFields) > 0) { ?>
                <thead>
                    <tr>
                        <?php foreach ($headerFields as $value) {
                            ?>

                            <th scope="col"><?php echo $value; ?></th>

                        <?php } ?> 
                    </tr>
                    </tr>
                </thead>
                <?php } ?>
                
                <tbody>
                
                    <?php if (isset($messages)) { ?>
                    <tr>
                        <td colspan="9"><div class="db-alert db-alert-info"><?php print_r($messages[0]); ?></div></td>
                    </tr>
                    <?php } ?> 
                    <?php if(isset($totalTransactions) && $totalTransactions > 0 && !isset($messages)){ ?>
                           <?php $SNo = 1;
                            $loop = 1;
                            foreach ($searchData as $key => $value) {
                                $loop = 1;  ?>
                                <tr>
                                    <td><?php echo $loop == 1 ? $SNo++ : ''; ?></td>
                                    <td><?php echo $value['id']; ?></td>
                                    <td><?php echo $value['convertedSignupDate']; ?></td>
                                    <td><?php echo $value['eventName']; ?> (<?php echo $value['eventid']; ?>)</td>
                                    <td><?php echo $value['quantity']; ?></td>
                                    <?php if(strlen($value['currencyCode']) >0){ ?>
                                    <td><?php echo $value['currencyCode'].'  '.$value['totalamount']; ?></td>
                                    <?php }else{ ?>
                                        <td><?php echo "FREE 0"; ?></td>
                                    <?php } ?>
                                </tr>
                            <?php  $loop++; } ?>
                    <?php } ?>
              
                          <?php if (isset($formErrors)){ ?>
                              <tr>
                                  <td colspan="6">   
                                      <div class="db-alert db-alert-info">
                                          <?php foreach($formErrors as $v): ?>
                                          <strong><?php echo $v; ?></strong> 
                                          <?php endforeach; ?>
                                      </div>
                                  </td>
                              </tr>
                        <?php } ?>
                </tbody>
            </table>
            <input type="text" id="sNo" value="<?php echo $SNo;?> " hidden="">
            <input type="text" id="hiddenTransactionTotal" value="<?php echo $totalTransactions; ?>" hidden="">
            <input type="text" id="hiddenDisplayLimit" value="<?php echo REPORTS_DISPLAY_LIMIT; ?>" hidden="">
            <?php if ($totalTransactions > REPORTS_DISPLAY_LIMIT) { ?>
               <button type="button" name="loadMoreTransactions" id="loadMoreTransactions">Load More</button>
           <?php } ?>  

      

    
  