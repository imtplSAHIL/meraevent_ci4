<div class="rightArea">
     <?php if(isset($output) && !empty($output)){ if($output['status']){ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $output['response']['messages'][0] ?></strong> 
        </div>                 
    <?php }else{ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $output['response']['messages'][0]; ?></strong> 
        </div>                 
     <?php } }?>
    <div class="fs-form"> 
       <h2 class="fs-box-title">Affiliate Commission</h2>
       <div class="editFields">
    <form name='globalPromoterCommissionForm' method='post' action='' id='globalPromoterCommissionForm'>
        
            <label>Commission <span class="mandatory">*</span> (%)</label>
            <input required="" type="number" class="textfield" name='commission' id='commission' min="1" max="80" value="<?php echo isset($affiliateCustomCommition['affiliateglobalcommission']) && $affiliateCustomCommition['affiliateglobalcommission']!=''?$affiliateCustomCommition['affiliateglobalcommission']:''?>">
            <div id='codeError' class='error'></div>
            <div class="clearBoth"></div>
            <div class="btn-holder float-right">
                <input name="submit" type="submit" id="globalcommpromoButton" class="createBtn" value="Save">
                
            </div>
        </form>
           
        </div> 
   </div> 
    
    
    
    <?php
    $promoterSuccessMessage = $this->customsession->getData('promoterSuccessAdded');
    $this->customsession->unSetData('promoterSuccessAdded');
    if ($promoterSuccessMessage) { ?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $promoterSuccessMessage; ?></strong> 
        </div>
    <?php } ?>
    <br><br>
    
    <div class="float-right"> 
        <a href="<?php echo commonHelperGetPageUrl("dashboard-add-org-affliate"); ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add New Promoter
        </a> </div>
    <div class="clearBoth"></div>
     <?php if(isset($promoterDetails) && !$promoterDetails['status']) { ?>               
        <div class="db-alert db-alert-danger flashHide">                    
            <strong><?php print_r($promoterDetails['response']['messages'][0]); ?></strong> 
        </div>
        <?php } ?> 
    <div class="clearBoth"></div>
    <div class="heading float-left">
        <h2>Promoters List: <span> <?php echo $eventName; ?> <?php //echo $eventId;  ?></span></h2>
    </div>
    <div class="clearBoth"></div>
    

        <div class="tablefields">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
                <thead>
                    <tr>
                        <th scope="col" data-tablesaw-priority="2">Promoter Name</th>
                        <th scope="col" data-tablesaw-priority="2">Promoter Email</th>
                        <th scope="col" data-tablesaw-priority="2">Promoter Code</th>
                        <th scope="col" data-tablesaw-priority="2">Commission (%)</th>
                        <th scope="col" data-tablesaw-priority="2">Tickets sold</th>
                        <th scope="col" data-tablesaw-priority="2">Ticket Amount</th>
                        <th scope="col" data-tablesaw-priority="2">Current Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($promoterDetails['status'] && $promoterDetails['response']['total'] == 0) { ?>
                        <tr><td colspan="6">
                                <div id="noPromoterMessage" class="db-alert db-alert-info">                    
                                    <strong> <?php echo $promoterDetails['response']['messages'][0]; ?></strong> 
                                </div>
                            </td> </tr> <?php
            } else if ($promoterDetails['status'] && $promoterDetails['response']['total'] > 0) {              
                    $i = 0;
                    $promoterList = $promoterDetails['response']['promoterList'];
                    foreach ($promoterList as $index => $row) {
                        $class = 'odd';
                        if ($i % 2 == 0) {
                            $class = '';
                        }
                                ?>
                                <tr <?php echo $class; ?> >
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><input id="promoterCommission<?php echo $index;?>" userid="<?php echo $row['userid'];?>" promoterid="<?php echo $customCommissions[$row['userid']]['customcommission']['promoterid']; ?>" type="text" value="<?php echo isset($customCommissions[$row['userid']]['customcommission']['commission'])?$customCommissions[$row['userid']]['customcommission']['commission']:0; ?>" class="CustomOrder" disabled=""><span id="<?php echo $index;?>" class="promoterCommissionIcon icon-edit"></span></td>
                                    <td><?php $totq=0; foreach ($row['quantity'] as $rqkey => $rqvalue) {
                                        $totq += $rqvalue;
                                        } echo $totq;?></td>
                                    <td><?php if(!empty($row['totalamount'])){
                                        $commitionAmoutWithCurrency='';
                                        foreach ($row['totalamount'] as $rtkey => $rtvalue) {
                                            if($rtkey!=''){
                                        $commitionAmoutWithCurrency.=$rtkey." ".$rtvalue."<br>";
                                            }
                                        
                                    } echo isset($commitionAmoutWithCurrency) && $commitionAmoutWithCurrency!=''?$commitionAmoutWithCurrency:0; }else{ echo 0;} ?></td>
                                    <td><?php if(isset($customCommissions[$row['userid']]) && !empty($customCommissions[$row['userid']]) && $customCommissions[$row['userid']]['status'] == 0) { ?>
                                            <button onclick="changeOrgAffiliateStatus('<?php echo $row['id']; ?>','<?php echo $organizerid;?>')" type="button" class="btn orangrBtn" id='<?php echo $row['id']; ?>'>INACTIVE </button>
                                        <?php } else { ?>
                                        <button onclick="changeOrgAffiliateStatus('<?php echo $row['id']; ?>','<?php echo $organizerid;?>')" type="button" class="btn greenBtn" id='<?php echo $row['id']; ?>'>ACTIVE </button>
                                            
                                        <?php } ?></td>
                                </tr>
                            <?php }
                        }
                     ?>                     
            </tbody>
        </table>
    </div>
</div>

<script>
    var api_org_promotesetStatus='<?php echo commonHelperGetPageUrl('api_org_promotesetStatus');?>';
    var orgPromoterCommissionEdit='<?php echo commonHelperGetPageUrl('orgPromoterCommissionEdit');?>';
    
</script>