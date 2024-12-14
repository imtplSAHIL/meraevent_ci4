<!--Right Content Area Start-->
<div class="rightArea">
    <div class="heading">
        <h2>Recurring Subscriptions</h2>
    </div>
    <div class="clearBoth"></div>
        <?php if($this->customsession->getData('addClientFlashMessage')){ ?>
        <div class="success db-alert db-alert-success flashHide"> 
            <?php echo "Client added successfully"; $this->customsession->unSetData('addClientFlashMessage');  ?>
        </div>
        <?php } ?>
        <?php if($this->customsession->getData('subFlashMessage')){ ?>
        <div class="success db-alert db-alert-success flashHide"> 
            <?php echo $this->customsession->getData('subFlashMessage'); $this->customsession->unSetData('subFlashMessage');  ?>
        </div>
        <?php } ?>

    
    <!--Data Section Start-->
    <!--
    <div class="fs-transtaction-actions">
	<div class="fs-filter-actions">
            <?php echo form_open(''); ?>
                <div class="defaultDroplist widthfloat margintop10">
                    <div class=" nopadding">
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
            <div class="widthfloat nopadding">
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
                                    <td><?php echo ($value['status']==1) ? "Active" : "Inactive"; ?></td>
                                    <td><?php echo ucwords($value['firstname']." ".$value['lastname']); ?></td>
                                    <td><?php switch ($value['periodtype']) {
                                        case '1' : echo 'Daily'; break;
                                        case '2' : echo 'Monthly'; break;
                                        case '3' : echo 'Yearly'; break;
                                        
                                    } ?></td>
                                    <td><?php echo $value['price']; ?></td>
                                    <td><?php echo $value['startdate']; ?></td>
                                    <td><?php echo $value['enddate']; ?></td>
                                    <td>
                                        <a title="Edit Subscription" class="tooltip-left hoeverclass" data-tooltip="Edit Subscription" 
                                        href="<?php echo base_url()."dashboard/recurringpayment/subscription/edit/".$value['id']?>"><span class="fa fa-edit gridview-edit"></span></a>
                                        <a title="Delete Subscription" class="tooltip-left hoeverclass" data-tooltip="Delete Subscription" onclick="deleteSubscription(this)" data-id="<?php echo $value['id']?>" href="javascript:void(0);"><span class="fa fa-trash gridview-delete"></span></a>
                                    </td>
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

      
<script type="text/javascript">
    var delUrl = '<?php echo base_url()."dashboard/recurringpayment/subscription/delete/"?>';
</script>
    
  <script type="text/javascript">
    function deleteSubscription(comp) {
        var r = confirm("Are you sure you want to delete this Subscription!");
        if(r == true)
        {   
            var id = $(comp).data('id');
            var that = $(comp).closest("tr");
            $(comp).hide();
            $(that).css("opacity","0.7");
            $.ajax({
                url: delUrl,
                type: "POST",
                data: {id: id},
                headers: {'Authorization': 'bearer 930332c8a6bf5f0850bd49c1627ced2092631250'},
                cache: false,
                dataType: 'json',
                success:
                    function (data) {
                        if (data.status) {
                            $(comp).closest("td").html("Deleted");
                            $(that).hide(500);
                        }
                    },
                error: function (data, x, y) {
                    $(comp).show();
                    $(that).css("opacity","1");
                }
            });
        }
    }
  </script>