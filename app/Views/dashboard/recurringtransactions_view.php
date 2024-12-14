<!--Right Content Area Start-->
<div class="rightArea">
    <div class="heading">
        <h2>Recurring Payments</h2>
    </div>
    <div class="clearBoth"></div>
    <div class="success"> 
        <?php if($this->customsession->getData('addClientFlashMessage')!=''){ echo "Client added successfully"; $this->customsession->unSetData('addClientFlashMessage');  } ?>
    </div>
    <div class="widthfloat nopadding">
        <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-addclient');?>"><input type="button" value="Add Client" id="addClient" class="createBtn"></a>
        <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-customers');?>"><input type="button" value="Clients" id="viewClient" class="createBtn"></a>
        <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-listsubscription');?>"><input type="button" value="Subscriptions" id="listSubscription" class="createBtn"></a>
        <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-listplans');?>"><input type="button" value="Plans" id="listPlans" class="createBtn"></a>
        <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-payments');?>"><input type="button" value="Payments" id="listPayments" class="createBtn"></a>
        <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-createsubscription');?>"><input type="button" value="Create Subscription" id="createSubscription" class="createBtn"></a>
        <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-createplan');?>"><input type="button" value="Create Plan" id="createPlan" class="createBtn"></a>
    </div>
    
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
                
                    <?php if (isset($messages) && !empty($messages)) { ?>
                    <tr>
                        <td colspan="9"><div class="db-alert db-alert-info"><?php print_r($messages[0]); ?></div></td>
                    </tr>
                    <?php } ?> 
                    <?php if(!isset($messages) || empty($messages)){ ?>
                           <?php $SNo = 1;
                            $loop = 1;
                            foreach ($searchData as $key => $value) {
                                $loop = 1;  ?>
                                <tr>
                                    <td><?php echo $loop == 1 ? $SNo++ : ''; ?></td>
                                    <td><?php echo $value->metadata->invoice_number; ?></td>
                                    <td><?php echo ucwords($value->status); ?></td>
                                    <td><?php echo $value->created_at; ?></td>
                                    <td><?php echo $value->charge_date; ?></td>
                                    <td><?php echo $value->amount/100; ?></td>
                                    <td><?php echo $value->amount_refunded/100; ?></td>
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
            <div align="right">
                <?php if ($before !='') { ?>
                   <a href=<?php echo commonHelperGetPageUrl('dashboard-recurring')."/index/before/".$before ?>> <button type="button" name="loadNextTransactions" id="loadNextTransactions" class="createBtn"> Previous </button></a>
                <?php } ?>  
                <?php if ($after !='') { ?>
                   <a href=<?php echo commonHelperGetPageUrl('dashboard-recurring')."/index/after/".$after ?>> <button type="button" name="loadNextTransactions" id="loadNextTransactions" class="createBtn"> Next </button></a>
                <?php } ?>      
            </div>
      

    
  