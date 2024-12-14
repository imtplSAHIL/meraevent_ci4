<div class="rightArea">
     <?php if(isset($output) && !empty($output)){ if($output['status']){ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $output['response']['messages'][0] ?></strong> 
        </div>                 
    <?php }else{ ?>
        <div id="promoterFlashErrorMessage" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $output['response']['messages'][0]; ?></strong> 
        </div>                 
     <?php } }
    
     ?>
    <?php if (empty($orgDetails)) {?>
  <div class="float-right"> 
        <a href="<?php echo commonHelperGetPageUrl('organizerProfile');?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add Organizer Page
        </a> </div>
    <?php }?>
    <div class="clearBoth"></div>
   
        <div class="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
                <thead>
                    <tr>
                        <th scope="col" data-tablesaw-priority="2">Organizer Display Name</th>
                        <th scope="col" data-tablesaw-priority="2">Url</th>
                        <th scope="col" data-tablesaw-priority="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orgDetails)) {
                        $class = 'odd';
                        if ($i % 2 == 0) {
                            $class = '';
                        }   
                                ?>
                                <tr <?php echo $class; ?> >
                                    <td><?php echo $orgDetails['name']; ?></td>
                                    <td><?php echo $this->config->item('server_path')."o/".$orgDetails['slug']; ?></td>
                                    <td  align="center" ><a href="<?php echo commonHelperGetPageUrl('organizerProfile');?>">Edit</a></td>
                                </tr>
                           
                        <?php }
                     ?>                     
            </tbody>
        </table>
    </div>
</div>