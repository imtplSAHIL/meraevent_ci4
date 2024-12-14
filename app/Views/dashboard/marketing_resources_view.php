<div class="rightArea">
    <?php
		if($this->session->flashdata('successMsg'))
		{ ?>
			<div class='db-alert db-alert-success flashHide'><?php echo $this->session->flashdata('successMsg');?></div>
		<?php } ?>     
     <?php if(isset($output) && !empty($output)){ if($output['status']){ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $output['response']['messages'][0] ?></strong> 
        </div>                 
    <?php }else{ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $output['response']['messages'][0]; ?></strong> 
        </div>                 
     <?php } }?>
    
    <div class="clearBoth"></div>
    <div class="float-right"> 
        <a href="<?php echo commonHelperGetPageUrl("dashboard-add-marketing-resources", $eventId); ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add Resource
        </a> </div>
    <div class="clearBoth"></div>
    <div class="heading float-left">
        <h2>Marketing Resources List: <span> <?php echo $eventName; ?> </span></h2>
    </div>
    <div class="clearBoth"></div>
   
        <div class="tablefields">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
                <thead>
                    <tr>
                        <th scope="col" data-tablesaw-priority="2">Resource Type</th>
                        <th scope="col" data-tablesaw-priority="2">Title</th>
                        <th scope="col" data-tablesaw-priority="2">Content</th>
                        <th scope="col" data-tablesaw-priority="2">Current Status</th>
                        <th scope="col" data-tablesaw-priority="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($affiliateResouces) && !empty($affiliateResouces)){  
                    foreach ($affiliateResouces as $afkey => $afvalue) { ?>
                     <tr>
                       <td><?php echo $afvalue['resourcetype'];?></td>
                       <td><?php echo $afvalue['title'];?></td>
                       <td><?php 
                       if($afkey!='banner' && $afkey!='email' ){
                                        echo substr($afvalue['content'], 0, 140);
                                        if(strlen($afvalue['content'])>140){
                                           echo "...";?>
                           <br>
                           <a class="" style="font-size: 14px;" href="<?php echo commonHelperGetPageUrl("dashboard-add-marketing-resources", $eventId.'/'.$afvalue['id']); ?>">View More</a>
                                               <?php 
                                        }
                                    }else{
                                    echo $afvalue['content'];
                                    }
                       ?></td>
                       
                        <td>
                            <?php if ($afvalue['status'] == 1) { ?>
                                <button onclick="changeResourceStatus('<?php echo $afvalue['id']; ?>','<?php echo $eventId;?>')" type="button" class="btn greenBtn" id='<?php echo $afvalue['id']; ?>'>ACTIVE </button>
                            <?php } else { ?>
                                <button onclick="changeResourceStatus('<?php echo $afvalue['id']; ?>','<?php echo $eventId;?>')" type="button" class="btn orangrBtn" id='<?php echo $afvalue['id']; ?>'>INACTIVE </button>
                            <?php } ?></td>
                        <td><a href="<?php echo commonHelperGetPageUrl("dashboard-add-marketing-resources", $eventId.'/'.$afvalue['id']); ?>"><span class="icon-edit" id=""></span></a></td>
                            </tr>  
                <?php } }else{ ?>
                            <tr><td colspan="5">No Resource Found</td></tr>
                    <?php } ?>
                                    
            </tbody>
        </table>
    </div>

 <br>

</div>

<script>
    var api_resource_status='<?php echo commonHelperGetPageUrl("api-resource-status");?>';
    </script>