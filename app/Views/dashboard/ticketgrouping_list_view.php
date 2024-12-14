<div class="rightArea">
    <?php
        $createGroupUrl = commonHelperGetPageUrl('dashboard-add_TicketGroup_View',$eventId);
       
        $deleteGroupUrl = commonHelperGetPageUrl('dashboard-deleteTicketGroup',$eventId.'/');
    
        if($this->session->flashdata('errorMsg'))
        { ?>
            <div class='db-alert db-alert-danger flashHide'><?php echo $this->session->flashdata('errorMsg');?></div>
       <?php }
	 if($this->session->flashdata('successMsg'))
        { ?>
            <div class='db-alert db-alert-success flashHide'><?php echo $this->session->flashdata('successMsg');?></div>
       <?php }	
	?> 
        <div class="heading float-left">
            <h2>Tickets Group: <span><?php echo $eventName;?></span></h2>
        </div>
        <div class="clearBoth"></div>
        <div class="float-right"> <a href="<?php echo $createGroupUrl; ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Create New Group</a> </div>
        <div class="clearBoth"></div>
        
        <div class="tablefields">
            <table width="100%" border="2" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
                <thead>
                    <tr>
                        <th scope="col" data-tablesaw-priority="persist">Group Name</th>
                        <th scope="col" data-tablesaw-priority="3">Tickets</th>
                        <th scope="col" data-tablesaw-priority="4">Max selectable categories</th>
                        <th scope="col" data-tablesaw-priority="5">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(isset($response['ticketgroups'])){
                    
                foreach($response['ticketgroups'] as $key => $value)
                { ?>
                   <tr>
                        <td><?php echo $value['name'];?></td><td>
                   <?php if(isset($value['tickets'])){
                        foreach($value['tickets'] as $id =>$ticket)  {echo $ticket['TicketName']?></br><?php } ?>
                   </td><td><?php echo $value['maxticketcategories'] > 0 ? $value['maxticketcategories'] : 'N/A' ;?></td><td>                            
                       <a href='<?php echo $createGroupUrl.'/'.$value['id'];?>' class='faicon'><p class='fa inlineblock margin10'><i class='icon2-edit'></i></p></a>
                       <a href='<?php echo  $deleteGroupUrl.$value['id'];?>' class='faicon'><p class='fa inlineblock margin10 delete'><i class='icon2-trash-o'></i></p></a>                            
                        </td>
                   </tr><?php }else{?> </td><td><?php echo $value['maxticketcategories'] > 0 ? $value['maxticketcategories'] : 'N/A' ;?></td><td>                            
                    <a href='<?php echo $createGroupUrl.'/'.$value['id'];?>' class='faicon'><p class='fa inlineblock margin10'><i class='icon2-edit'></i></p></a>
                    <a href='<?php echo $deleteGroupUrl.$value['id']; ?>' class='faicon'><p class='fa inlineblock margin10 delete'><i class='icon2-trash-o'></i></p></a>                            
                        </td>
                   </tr><?php }
                }}
                else{?>
                   <tr><td> Ticket category group is not created yet! <a href='<?php echo $createGroupUrl;?>'>Create ticket category group</a></td></tr>
               <?php }
                ?>        
            </tbody>
        </table>
    </div>
</div>


<div id="Permission" style="display:none;">
   <div class="db-popup dbam-popup">
      <div class="db-closeholder"><a class="db-close" href="#">&times;</a></div>
      <div class="db-popupcontent">
         <div class="sweet-alert showSweetAlert">
             <div class="sa-icon sa-warning pulseWarning" style="display: block;">
	 	<span class="sa-body pulseWarningIns"></span>
	 	<span class="sa-dot pulseWarningIns"></span>
	 			    </div>
             <p> Are you sure want to delete this ticket group? </p>
            
             
         <p id="deleteUrl" value=""></p>
        <div class="sa-button-container">
            <button class="deleteConfirm confirm confirmbtn " value="Yes" >Yes</button>
             <button class=" deleteConfirm confirm cancel " value="No" >No</button>
        </div>  
        
         </div>
         
      </div>
   </div>
</div>

<style>
    .modal{
	position: fixed;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 1050;
	background-color: rgba(136, 136, 136, 0.4);
    }
</style>

