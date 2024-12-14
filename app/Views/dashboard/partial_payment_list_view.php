<div class="rightArea">
             <?php
        $offlinePromoterMessage = $this->customsession->getData('offlinePromoterFlashMessage');
        $this->customsession->unSetData('offlinePromoterFlashMessage');
        if ($offlinePromoterMessage) { ?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $offlinePromoterMessage; ?></strong> 
        </div>
    <?php } ?>
    <?php if(isset($messages)){?>
                <div class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $messages;?></strong> 
        </div>                 
        <?php }?>
      <div class="heading float-left">
        <h2>Partial Payments List: <span> <?php echo $eventName; ?></span></h2>
      </div>
    <?php if(!empty($donationTktId)){ ?>
    <div class="heading float-left">
        <h2>Partial Payment Ticket Price : <i>Rs.</i><span> <input type="text" name="tkt_amt" id="tkt_price" onkeypress="return isNumber(event)" value="<?php echo $donationTktPrice; ?>"  class="textfield" width="50%" required/>
                <input type="hidden" name="t_id" id="tkt_id" value="<?php echo $donationTktId ; ?>" class="textfield" width="50%"/>
            </span><input type="submit" name="submit" value="Save" id="price_update" class="btn greenBtn" width="50%"/>
        </h2>
    </div>
    <?php } ?>
      <div class="clearBoth"></div>
      <div class="float-right"> <a href="<?php echo commonHelperGetPageUrl('dashboard-add-partial-payment', $eventId); ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add New Partial Payemnt</a> </div>
      <div class="clearBoth"></div>
      <div class="tablefields">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-mode="swipe" data-tablesaw-minimap>
          <thead>
            <tr>
              <th scope="col">User Details</th><!--data-tablesaw-priority="persist"-->
              <th scope="col" data-tablesaw-priority="3">Tickets Quantity</th>
              <th scope="col" data-tablesaw-priority="3">Ticket Price</th>
              <th scope="col" data-tablesaw-priority="3">Amount Paid</th>
              <th scope="col" data-tablesaw-priority="3">Current Status</th>
              <th scope="col" data-tablesaw-priority="3">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $rows = array();
            if ($partialPaymentsList['status'] && $partialPaymentsList['response']['total'] == 0) { ?>
                        <tr><td colspan="6">
                                <div class="db-alert db-alert-info">                    
                                    <strong> <?php echo $partialPaymentsList['response']['messages'][0]; ?></strong> 
                                </div>
                            </td> </tr> <?php
            } else if ($partialPaymentsList['status'] && $partialPaymentsList['response']['total'] > 0) {  
                
                $i = 1;
                foreach($partialPaymentsList['response']['partialPaymentsList'] as   $row){
                 $reportsLink = commonHelperGetPageUrl('dashboard-transaction-report', $row['eventid'] . '&summary&offline&1','?promotercode='.$row['code']);
                 
           $class = 'odd';
                        if ($i % 2 == 0) {
                            $class = '';
                        }
                ?>
             <tr <?php echo $class; ?> >
                 <td> <?php echo $row['name']; ?></td>
               
              <td> 1</td>
                <td>
              <?php if($row['totalamount'] !=''){ ?> <?php echo $row['totalamount']; ?><?php }else{echo '0';}  ?>
              </td>
              <td>
                  <?php  if($partialPaymentsList['amountPaidData'][$row['eventsignupid']] > 0){
      echo 'Rs. '.$partialPaymentsList['amountPaidData'][$row['eventsignupid']];
                  }else{
                      echo '0';
                  } ?>
              </td>
              <td><button onclick="changeStatus('<?php echo $row['id']; ?>')" type="button" <?php if ($row['status'] == 1) { ?> class="btn greenBtn" <?php } else { ?> class="btn orangrBtn" <?php } ?>id='<?php echo $row['id']; ?>'><?php if ($row['status'] == 1) {
                    echo 'active';
                } else {
                    echo 'inactive';
                } ?></button>
              </td>
              <td> <a href="<?php echo commonHelperGetPageUrl('dashboard-edit-partialPayments',$eventId.'&'.$row['id']); ?>"><span class="icon-edit"></span></a> </td>
              
              
            </tr>
                <?php $i++;  } } ?>
          </tbody>
        </table>
      </div>
    </div>

<script>
$(document).ready(function () {
        
        $('#price_update').click(function () {
                var tktId = $('#tkt_id').val();
                var tkt_price = $('#tkt_price').val();
                if(tkt_price == ''){
                    alert('Please enter Ticket amount');
                    return false;
                }
                $.ajax({
                    url: '<?php echo commonHelperGetPageUrl('save-dontation-tkt-price'); ?>',
                    type: 'POST',
                    data: {tktid : tktId, tktPrice: tkt_price},
                    beforeSend: function () {
                        $("#dvLoading").show();
                    },
                    success: function (result) {
                        alert('Updated successfully');
                        $("#dvLoading").hide();
                    },
                });
        });
    });
</script>