  

    <div class="rightArea">
     <?php
		if($this->session->flashdata('errorMsg'))
		{ ?>
			<div class='db-alert db-alert-danger flashHide'><?php echo $this->session->flashdata('errorMsg');?></div>
		<?php } ?>     
     <?php
		if($this->session->flashdata('successMsg'))
		{ ?>
			<div class='db-alert db-alert-success flashHide'><?php echo $this->session->flashdata('successMsg');?></div>
		<?php } ?>     
     
      <div class="clearBoth"></div>
      <!--Data Section Start-->

      <div class="heading float-left">
            <h2>Create Ticket Group : <span><?php echo $eventName;?></span></h2>
        </div>
      
      <div class="editFields fs-add-discount-box">
        
          <form name=""  action="<?php echo $formAction ;?>" onsubmit="return validate();" method="POST">

          <div class="grid-sm-6 nopadding">
            <label>Ticket Group Name <span class="mandatory">*</span></label>
            <input type="text" class="textfield valid" id="GroupName" name="groupName" value="<?php if(isset($groupName)){echo $groupName;}?>">
            <p class="error" id="groupName_Valid"></p>
            <input type="hidden" name="groupId" id ="groupId" value = "<?php if(isset($groupId)){echo $groupId;}?>"/>
            <label>Group Order <span class="mandatory">*</span></label>
            <input type="number" class ="textfield valid" id="GroupOrder" name="groupOrder" value="<?php echo $order;?>">
            <label>Max selectable categories</label>
            <input type="number" class ="textfield valid" id="MaxTicketCategories" name="maxTicketCategories" value="<?php echo $maxticketcategories;?>">
            <p class="error" id="groupOrde_Valid"></p>
          </div>


          <div class="fs-form fs-form-widget-setting">
            <label class="pb-10imp">Select Tickets<span class="mandatory">*</span></label>
            <?php
           
            if(!isset($edit))
            {
                foreach($outGroupTicketData['tickets'] as $key=>$value)
                { ?>
                  
                  <p class='pb-10imp'>
                      <label><input type='checkbox' name='ticketIds[]' value='<?php echo $value['ticketid'];?>'><?php echo $value['TicketName'];?></label>
                    </p>
               <?php }
            }
            
                if(isset($selectedGroup)){
                foreach($selectedGroup as $key=>$value)
                { ?>
                    <p class='pb-10imp'>
                    <label>
                    <input type='checkbox' name='ticketIds[]' id ='<?php echo $value['ticketid'];?>' value='<?php echo $value['ticketid'];?>' checked='checked'><?php echo $value['TicketName'];?> 
                    </label>
                    </p>
                <?php    
                } }?>
                    <?php
                if(isset($edit)){
                if(isset($outGroupTicketData['tickets']) && !empty($outGroupTicketData['tickets']) ){
                 foreach($outGroupTicketData['tickets'] as $key=>$value)
                { ?>
                    <p class='pb-10imp'>
                    <label>
                    <input type='checkbox' name='ticketIds[]' id ='<?php echo $value['ticketid'];?>' value='<?php echo $value['ticketid'];?>' ><?php echo $value['TicketName'];?> 
                    </label>
                    </p>
                <?php }}}
                
                
             ?>
                    <?php
                
                if(isset($inGroupTicketData) && !empty($inGroupTicketData)){
                    if(count($outGroupTicketData)==0)
                    { ?>
                        <div class='heading float-left'><h2>Tickets used by other groups</h2></div>
                   <?php }
                    else
                    { ?>
                        <div class='heading float-left'><h2>Tickets in  another group</h2></div>
                   <?php }
                foreach($inGroupTicketData as $key=>$value)
                { ?>
                    <p class='pb-10imp'><b><?php echo $value['name'];?></b></p>
                <?php   foreach($value['tickets'] as $key1=>$value1) 
                   { ?>
                    <p class='pb-10imp'>
                      <label>
                        <input type='checkbox' name='ticketIds[]' id ='<?php echo $value1['ticketid'];?>' value='<?php echo $value1['ticketid'];?>' class='InGroup' title='Member Of a Group' ><?php echo $value1['TicketName'];?>
                      </label>
                      </p>
                  <?php }
            }}?>
                
                
                    <input type='hidden' name='eventId' value="<?php echo $eventId;?>"  /> 
            
             
          </div>

            <!-- <input type="submit" class="submitBtn createBtn float-right submitBtnTicketOptions" name="submit" value="Submit"/> -->
            <div class="btn-holder float-right">
              <button type="submit" class="createBtn" name="save">Submit</button>
              <a href="<?php echo commonHelperGetPageUrl('dashboard-ticketGroupig',$eventId); ?>"><button type="button"  class="saveBtn" name="cancel">cancel</button></a>    
            </div>

        
        </form>

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
             <p> This ticket belong to another group , Want to Move In this group </p>
            
             
              <p id ="popupid" ></p>
        <div class="sa-button-container">
            <button class="confirm confirmbtn check " value="Yes" >Yes</button>
             <button class="confirm cancel check" value="No" >No</button>
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