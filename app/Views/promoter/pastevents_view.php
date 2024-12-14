<div class="rightArea">
      <div class="heading">
        <h2>Promoter Events List</h2>
      </div>
      <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
          <thead>
            <tr>
              <th>Event Id</th><!--data-tablesaw-priority="persist"-->
              <th data-tablesaw-priority="2">Event Title</th>
              <th data-tablesaw-priority="2">City</th>
              <th scope="col" data-tablesaw-priority="5">Commission Earned</th>
              <th data-tablesaw-priority="2">Prmoter Code Status</th>
              <th data-tablesaw-priority="2">Options</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($promoters) > 0){?>
            <?php foreach($promoters as $promoter){?>
            <tr>
              <td><?php echo $promoter['eventId'];?></td>
              <td><?php echo $promoter['eventTitle'];?><br>
                 <?php if($promoter['type'] == 'offline') {
                     $reportsLink = commonHelperGetPageUrl('promoter-transaction-report', $promoter['eventId'] . '&offline&' . $promoter['code']);
                     ?>
                  <span class="PV_salestext PV_color">(Offline sales active)</span>
              <span class="PV_salestext">Transactions: <a href="<?php echo $reportsLink; ?>">Tickets - <?php echo $promoter['quantity']; ?></a> |  <a href="<?php echo $reportsLink; ?>">Amount - <?php echo $promoter['totalamount']; ?></a></span>
                  <?php } else{ ?>    
            <?php  }?>
              
              </td>
              <td><?php echo $promoter['city'];?></td> 
              <td><?php if ($promoter['type'] == 'affliate') {
                            if(isset($promoterSaleCommission[$promoter['promoterId']]) && !empty($promoterSaleCommission[$promoter['promoterId']])){
                                $commitionAmoutWithCurrency='';
                                foreach ($promoterSaleCommission[$promoter['promoterId']] as $pckey => $pcvalue) {
                                    $commitionAmoutWithCurrency.=$pckey.' '.$pcvalue."<br>";
                                }
                                echo isset($commitionAmoutWithCurrency) && $commitionAmoutWithCurrency!=''?$commitionAmoutWithCurrency:0;
                            }else{
                                echo 0;
                            }
                            }else{ echo '-';}
                            ?></td>
              <?php if($promoter['status'] == 1){?>
              <td><button type="button" class="btn greenBtn defaultCursor">ACTIVE</button></td>
              <?php } else{ ?>
              <td><button type="button" class="btn orangrBtn defaultCursor">INACTIVE</button></td>
              <?php } ?>
              
                <?php 
                $nowdate = strtotime(allTimeFormats('',11));
                if($promoter['type'] == 'offline' && $promoter['status'] == 1) {
					?><td><a href="offlinebooking?eventId=<?php echo $promoter['eventId'] ?>&id=<?php echo $promoter['promoterId'] ?>" class="sellBtn">SELL TICKETS</a></td><?php
				}else{
					?><td><a href="<?php echo commonHelperGetPageUrl('user-promoterview-eventdetailslist','past&'.$promoter['eventId'].'&'.$promoter['code']); ?>" class="sellBtn">VIEW DETAILS</a></td><?php
				}
				
				?>
              <?php } ?>
            </tr>
            <?php } else {?>
               <tr><td colspan="5"><div class="db-alert db-alert-info"><?php echo 'Sorry, No records found.';?></div></td></tr> 
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

