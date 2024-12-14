
 
      <div class="heading">
        <h2>MeraWallet Transactions</h2>
      </div>
      <!--Data Section Start-->
         <div class="tablefields">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-center" id="myWalletTransactions">
          <thead>
            <tr>
              <th>Type</th>
              <th>Withdrawal</th>
              <th>Deposit</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
          <?php
		  $trCount = count($transactions);
		  if($trCount > 0){
		  	foreach($transactions as $transaction){
			  $type= $transaction['type'];
			  ?>
              <tr>
              	<td><?php echo $type; ?></td>
                
                <?php
				if($type == 'Added to Wallet'){
					?>
                    <td>&nbsp;</td>
                	<td>INR <?php echo $transaction['amount']; ?></td>
					<?php
				}
				elseif($type == 'Paid for an Order'){?>
                    <td>INR <?php echo $transaction['amount']; ?></td>
                	<td>&nbsp;</td>
					<?php
				}
				?>
                <td><?php echo $transaction['creationTime']; ?></td>
              </tr>
              <?php
		  }
		  }
		  else{
			  ?>
              <tr><td colspan="4"><div id="alertMessage" class="db-alert db-alert-danger">No records found.</div></td></tr>
              <?php
		  }
		  ?>
          
          
            
          </tbody>
        </table>
        
        
        <?php
		if($trCount >= 5) // && $trCount < 5
		{ 
		
			?>
            <input type="hidden" id="page" name="page" value="<?php echo ($page+1);?>"/>
            <div><a id="viewMoreTrs" class="submitBtn createBtn float-right" >Load More</a> </div>
            <?php
		}
		?>
        
       
    
<script type="text/javascript" language="javascript">
var api_getTransactions = '<?php echo commonHelperGetPageUrl('api_getTransactions');?>';
</script>
