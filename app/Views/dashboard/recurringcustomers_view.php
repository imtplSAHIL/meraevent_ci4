<!--Right Content Area Start-->
<div class="rightArea">
    <div class="heading">
        <h2>Clients</h2>
    </div>
    <div class="clearBoth"></div>
    <div class="success"> 
        <?php if($this->customsession->getData('addClientFlashMessage')!=''){ echo "Client added successfully"; $this->customsession->unSetData('addClientFlashMessage');  } ?>
    </div>
    <!--Data Section Start-->
    <!--
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
    -->
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
                                    <td><?php echo $value['countrycode']; ?></td>
                                    <td><?php echo ucwords($value['firstname'].$value['lastname']); ?></td>
                                    <td><?php echo $value['email']; ?></td>
                                    <td><?php echo $value['address']; ?></td>
                                    <td><?php echo $value['city']; ?></td>
                                    <td><?php echo $value['postalcode']; ?></td>
                                    <td><?php echo $value['companyname']; ?></td>
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

      

    
  