
<div class="rightArea">
    <div class="heading float-left">
        <h2> Past Attendee Listing: </h2>
        
    </div>
    
    
    <div class="float-right view-less  pointerCursor" style='display:none;'><a><span style='color:#515151;'><u>View less</u></span></a></div>    
    
    <div class="clearBoth"></div>
    <div class="clearBoth"></div>
            <?php //For all the errors of server side validations
    if (isset($messages)) {
    ?>
    <div id="commFlashErrorMessage" class="db-alert db-alert-danger flashHide">
        <strong>  <?php echo $messages; ?></strong> 
    </div>  
<?php } ?>
    <div class="tablefields">
        <form id="viralTicket" method="post" action="">
<!--            <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-mode="swipe" data-tablesaw-minimap>-->
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
                    <tr>
                    	 <th scope="col">S.No</th>
                        <th scope="col">Name</th>
                        <th scope="col" >Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">City</th>
                        <th scope="col" >State</th>
                        <th scope="col" >Country</th>
                        <th scope="col" >Category</th>
<!--                        <th scope="col" >Actions</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pastAttCount = count($pastAttList);
                    if ($pastAttCount > 0) {
                        $viral_enable=false;
						$i=1;
                        foreach ($pastAttList as $key => $val) {
                        	
                            ?>
                            <tr>
                            	<td><?php echo $i++; ?></td>
                                <td><?php echo $val['name']; ?></td>
                                <td><?php echo $val['email']; ?></td>
                                <td><?php echo $val['mobile']; ?></td>
                                <td width="30%">
                                    <?php echo $val['city']; ?>
                                </td>
                                <td><?php echo $val['state']; ?></td>
                                <td><?php echo $val['country']; ?></td>
                                <td><?php echo $val['category']; ?></td>
<!--                                <td><span id="<?php echo $val['id']; ?>" class="orderIcon icon-edit"></span></td>-->
                            </tr>
                            <?php
                        }
                    
                        ?>
                            
<?php
} else {
    ?>
    <tr> <td colspan="8">                
            <div id="noViralTicketingMessage" class="db-alert db-alert-info">                    
                    <strong>There are no past attendees</strong> 
                </div>
           </td>
    </tr>                        
<?php    
}
?>
                </tbody>
            </table>
            
        </form>
    </div>
   
</div>