<!--Right Content Area Start-->
            <div class="rightArea">
               
                <div class="heading float-left">
                    <h2>Event Details </h2>
                </div>
               
                <div class="clearBoth"></div>
                <!--Data Section Start-->

                <div class="clear-fix">&nbsp;</div>
                
                <div class="refundSec discount">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Event ID</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $eventDetails['title']; ?></td>
                               
                                <td><?php echo $eventId; ?></td>
                                <td><?php echo $startDateTime;?></td>
                                <td><?php echo $endDateTime;?></td>
               
                            </tr>
                            <?php $eventUrl = $eventDetails['eventUrl'].'/'.$eventDetails['id']."?ucode=".$promoterCode;
                                 $shareLink = urlencode($eventUrl);
                            ?>
                            <tr>
                                <td colspan="4" style="text-align:left;padding-left:40px">Promoter URL <span ><a href="<?php echo $eventUrl; ?>" target="_blank" style="color:orange !important"><?php echo $eventDetails['eventUrl']."?ucode=".$promoterCode; ?></a></span></td>
                            </tr>
                            <?php if($type == "current"){ ?>
                             <tr>
                              <td colspan="2" style="text-align:left;padding-left:40px;font-weight:600">SHARE THIS EVENT WITH </td>
                                  <td colspan="2" style="text-align:left;padding-left:40px">
                                       
	      <span><a target="_new" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $shareLink;?>"><i class="icon1 icon1-facebook"></i></a></span>              
	      <span> <a target="_new" href="http://twitter.com/?status=Meraevents <?php echo $shareLink;?>"><i class="icon1 icon1-twitter"></i></a></span>
	       <span> <a target="_new" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $shareLink;?>title=Meraevents"><i class="icon1 icon1-linkedin"></i></a></span>
                              </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div>
                        <a href="<?php echo commonHelperGetPageUrl('promoter-transaction-report', $eventId . '&' .'affiliate'.'&'. $promoterCode);?>" class="createBtn float-right" >View Report</a>
                      
                    <!--<button type="button" onclick="viewReports('<?php //echo $eventId,$promoterCode; ?>')" class="btn btn-grey float-right">View Report</button>-->
                    </div>
                    </div>
                <?php if(isset($ticketData) && !empty($ticketData)){ ?>
                    <div class="heading float-left">
                    <h2> Commissions by Ticket</h2>
                    </div>
                <div class="refundSec discount">
                    <table width="40%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                        <thead>
                        <th>Ticket Name</th>
                        <th>Price</th>
                        <th>Commission (%)</th>
                        </thead>
                        <tbody>
                            <?php foreach ($ticketData as $tdkey => $tdvalue) { ?>
                            <tr>
                                <td><?php echo $tdvalue['name'];?></td>
                                <td><?php 
                                if($tdvalue['price']==0 || $tdvalue['price']==''){
                                 echo $tdvalue['currencyCode'].' ---';
                                }else{
                                echo $tdvalue['currencyCode'].' '.$tdvalue['price'];
                                }
                                ?></td>
                                <td><?php echo $tdvalue['promotercommission'].' %';?></td>
                                
                            </tr>
                           
                            <?php } ?>
                         </tbody>
                    </table>
                  
                    </div>
               <?php } ?>
                <div class="clearBoth"></div>
                <div class="clear-fix">&nbsp;</div>
                <?php if(isset($affiliateResouces) && !empty($affiliateResouces)){ ?>
                    <div class="heading float-left">
                    <h2> Marketing Resources </h2>
                    </div>
                
                    <div class="refundSec discount">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
                        <thead>
                        <th>Resource Title</th>
                        <th>Content</th>
                        </thead>
                        <tbody>
                            <?php foreach ($affiliateResouces as $afkey => $afvalue) { ?>
                            <tr>
                                <td><h1><?php if($afkey=='banner'){ echo "BANNERS";}elseif($afkey=='email'){echo "EMAILERS";}else {
                                echo strtoupper($afkey);
                            }?></h1></td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php foreach ($afvalue as $key => $value) { ?>
                            <tr>
                                <td><?php echo $value['title'];?></td>
                                <?php 
                                    if ($value['resourcetype']=='twitter') {
                                                $resourceShareLink=$eventShortUrl;
                                            }else{
                                                $resourceShareLink=$eventUrl;
                                            }
                                
                                ?>
                                <td><span <?php if ($value['resourcetype']!='banner' && $value['resourcetype']!='email') { ?>style="display: none;" <?php } ?> id="copycontent_<?php echo $value['id'];?>" sharelink="<?php echo $resourceShareLink;?>"><?php echo $value['content'];?></span>
                                    <?php if ($value['resourcetype']!='banner' && $value['resourcetype']!='email') { ?><textarea rows="10" class="textarea" disabled=""><?php echo $value['content'];?></textarea><?php } ?>
                                <?php if($afkey!='banner' || $afkey!='email'){ ?> <br><span><?php echo $resourceShareLink;?></span><?php } ?>
                                    <span title="copy" class="promoterEventCommissionIcon" ><span contentid="<?php echo $value['id'];?>" class="copylink tooltip-bottom hoeverclass copycontent" data-tooltip="Copy to Clipboard">Copy</span></span>
                                    
                                </td>
                                
                            </tr>                                
                                  <?php } ?>
                            <?php } ?>
                            <tr><td></td><td></td></tr>
                         </tbody>
                    </table>
                  
                    </div>
               <?php } ?>
                
            </div>
   
<script>
    $(document).ready(function () {
    $('.copycontent').click(function(){
        var contentid=$(this).attr('contentid');
        var contentcopy=$('#copycontent_'+contentid).html();
        var promotersharelink=$('#copycontent_'+contentid).attr('sharelink');
        contentcopy+=' '+promotersharelink;
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(contentcopy).select();
        document.execCommand("copy");
        $temp.remove();
        $(this).attr('data-tooltip','Copied to clipboard');
    });
        
  
    });
    </script>