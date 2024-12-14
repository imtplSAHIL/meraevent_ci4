    <div class="rightArea">

      <?php if (isset($messages)) { ?>
        <div id="alertMessage" <?php if($status) { ?>
             class="db-alert db-alert-success flashHide" <?php } else { ?> 
             class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $messages; ?></strong> 
        </div>
    <?php } ?> 
      <div class="heading">
        <div style="float:left;width:30%;"><h2>Affiliate Bonus</h2></div>
        <!--
        <?php
		if($redeemablePoints > 0){
			?><div style="float:right; "><p style="float: left; padding: 20px 40px 30px 0; font-size: 24px; font-weight: normal; color: #F44336;">Total Redeemable Points : <?php echo $redeemablePoints; ?></p><?php
			if($mywallet){ 
			?>
            <a href="javascript:void(0)" class="createBtn float-left font14" id="redeemPoints" title="Click to redeem your points."> Redeem/Transfer to wallet</a></div>
            <?php
            }
			else{
				?>
                <a href="<?php echo commonHelperGetPageUrl('user-mywallet');?>" class="createBtn float-left font14" title="Create wallet to redeem your points"> Create MeraWallet</a></div>
                <?php
			}
		}
		?>
        -->
      </div>
      
      
      
      
      <!--Data Section Start-->
         <div class="tablefields">
             <form name="alerts" method="post" is="alerts" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-center">
          <thead>
            <tr>
              <th>Date</th>
              <th>Event</th>
              <th>Ticket Sale</th>
              <th>Commission Earned(INR)</th>
              <th>Type</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
              <?php 
			  //print_r($affiliateBonusDetails); 
			  $totalqty=0;
			  if(count($affiliateBonusDetails)>0){
                  $totalCommission=0;
                        foreach ($affiliateBonusDetails as $key => $value) {
                            $totalqty=$totalqty+$eventSignupTicketsData[$value['signupid']];
                  			?>
                            <tr>
                              <td class="alert-chkbtn"><?php echo $value['trtime'];?></td>
                              <td><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a></td>
                              <td class="alert-chkbtn"><?php echo $eventSignupTicketsData[$value['signupid']];?></td>
                              <td class="alert-chkbtn"><?php echo $value['points'];?></td>
                              <td class="alert-chkbtn"><?php echo ucfirst($value['type']);?></td>
                              <td class="alert-chkbtn"><?php echo ($value['wallettransferred'] == 1)?"Transferred to Wallet":"";?></td>  
                            </tr>
                        <?php 
						$totalCommission+=$value['points'];
                        } ?>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td><b><?php echo $totalqty;?></b></td>
                                <td><b><?php echo 'INR '.$totalCommission;?></b></td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        
                      <?php  }else{ ?>
                     <tr>
                        <td colspan="4"><div class="db-alert db-alert-info">No data found.</div></td>
                    </tr>
               <?php }?>
        </tbody>
        </table>
<!--        <div class="float-right">
          <input type="submit" class="createBtn float-right" name="alertForm" value="Save & Exit"/>
        </div>-->
             </form>
        
        </div>
    </div>
    
<script type="text/javascript" language="javascript">
var api_redeemPoints = '<?php echo commonHelperGetPageUrl('api_redeemPoints');?>';
</script>
