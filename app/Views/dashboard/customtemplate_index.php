<?php
$eventCount = count($eventList);
if ($pageType == "upcoming") {
    $currentClass = "selected";
    $pastClass = "";
   $totalEventCount= isset($totalEventCount)?$totalEventCount:0;
    $currentTotal = "( <span id='totalcount'>" .$totalEventCount. "</span> )";
    $pastTotal = "";
    $message = $this->customsession->getData('message');
    $publishedLink = $this->customsession->getData('eventLink');
} else {
    $currentClass = "";
    $pastClass = "selected";
    $totalEventCount= isset($totalEventCount)?$totalEventCount:0;
    $pastTotal = "( <span id='totalcount'>" . $totalEventCount . " </span>)";
    $currentTotal = "";
}

?>
<div class="rightArea me_emailbuilder_container">
   <div class="gridn-container overflowauto">
      <h2 class="heading">System Templates</h2>
      <p class="info-text">Customize emails templates with your own content, links, logo and more. System will send your customised templates.</p>
      <div class="gridn-row">
          <div class="gridn-lg-3 gridn-md-6 gridn-sm-6 zeromarpad">
              <?php if(empty($onlineCustomTemplate)){?>
                <a href="<?php echo commonHelperGetPageUrl('dashboard-customtemplate-update', $eventId.'/online'); ?>" class="edit_discount_label">
              <?php  }else{?>
                  <a href="<?php echo commonHelperGetPageUrl('dashboard-customtemplate-update', $eventId.'/online/'.$onlineCustomTemplate[0]['id']); ?>" class="edit_discount_label">
              <?php }?>
            <div class="emailtype-grid">
               <!-- <p class="emailtype-icon"><img src="https://img.litmuscdn.com/resources/slate-product.jpg?1541459441"></p> -->
               <p class="emailtype-icon"><img src="https://img.litmuscdn.com/images/next/product-shots/checklist-email-3.png?1541459444"></p>
               <p class="emailtype-heading">Online Confirmation</p>
               <p class="emailtype-desc">Email Template for notification of online event ticket/ registration payment</p>
               <p class="emailtype-edit"><a href="#"><i class="fa fa-pencil"></i></a></p>
            </div></a>
         </div>
          
        <div class="gridn-lg-3 gridn-md-6 gridn-sm-6 zeromarpad">
            <?php if(empty($offlineCustomTemplate)){?>
                <a href="<?php echo commonHelperGetPageUrl('dashboard-customtemplate-update', $eventId.'/offline'); ?>" class="edit_discount_label">
            <?php  }else{?>
                    <a href="<?php echo commonHelperGetPageUrl('dashboard-customtemplate-update', $eventId.'/offline/'.$offlineCustomTemplate[0]['id']); ?>" class="edit_discount_label">
            <?php } ?>
            <div class="emailtype-grid">
               <!-- <p class="emailtype-icon"><img src="https://img.litmuscdn.com/resources/slate-newsletter.jpg?1541459441"></p> -->
               <p class="emailtype-icon"><img src="https://img.litmuscdn.com/images/next/product-shots/checklist-email-3.png?1541459444"></p>
               <p class="emailtype-heading">Offline Confirmation</p>
               <p class="emailtype-desc">Email Template for notification of offline event ticket/ registration payment</p>
               <p class="emailtype-edit"><a href="#"><i class="fa fa-pencil"></i></a></p>
            </div>
         </div>
          
<!--         <div class="gridn-lg-3 gridn-md-6 gridn-sm-6 zeromarpad">
             <a href="<?php echo commonHelperGetPageUrl('dashboard-customtemplate-update', $eventId.'/affiliate'); ?>" class="edit_discount_label">
            <div class="emailtype-grid">
                <p class="emailtype-icon"><img src="https://img.litmuscdn.com/resources/slate-receipt.jpg?1541459441"></p> 
               <p class="emailtype-icon"><img src="https://img.litmuscdn.com/images/next/product-shots/checklist-email-3.png?1541459444"></p>
               <p class="emailtype-heading">Affiliate Invitation</p>
               <p class="emailtype-desc">Email template for invitation to become affiliate</p>
               <p class="emailtype-edit"><a href="#"><i class="fa fa-pencil"></i></a></p>
            </div></a>
         </div>-->
          
<!--         <div class="gridn-lg-3 gridn-md-6 gridn-sm-6 zeromarpad">
             <a href="<?php echo commonHelperGetPageUrl('dashboard-customtemplate-update', $eventId); ?>" class="edit_discount_label">
            <div class="emailtype-grid">
                <p class="emailtype-icon"><img src="https://img.litmuscdn.com/resources/slate-simple.jpg?1541459441"></p> 
               <p class="emailtype-icon"><img src="https://img.litmuscdn.com/images/next/product-shots/checklist-email-3.png?1541459444"></p>
               <p class="emailtype-heading">Access Control</p>
               <p class="emailtype-desc">Email template for inviting administrators/ managers for your event</p>
               <p class="emailtype-edit"><a href="#"><i class="fa fa-pencil"></i></a></p>
            </div>
         </a>
         </div>-->
         </div>
      </div>
   </div>
</div>

<!--<script>
$(function(){
    $('.db_Eventbox').matchHeight();

});
</script>
<div id="popup3" style="display:none;">
    <div class="db-popup">
        <div class="db-closeholder"><a class="db-close" href="#">&times;</a></div>
        <div class="db-popupcontent">
            
            <div class="sweet-alert showSweetAlert"> 
                 
                    <div class="sa-icon sa-warning pulseWarning" style="display: block;">
                      <span class="sa-body pulseWarningIns"></span>
                      <span class="sa-dot pulseWarningIns"></span>
                    </div> 
                    <h2 id="deleteTxt">Are you sure?</h2>
       <p style="display: block;">You will not be able to undo this action!</p>   
       <div class="sa-button-container">
             <button class="confirm confirmbtn" style="" id="yesDeleteButton">Yes</button>
          <div class="sa-confirm-button-container">
          <button class="cancel" style="display: inline-block; box-shadow: none;">Cancel</button>         
                      </div>
                   </div>                
            </div>

        </div>
    </div>
</div>-->

<script type="text/javascript">
$('select').on('change', function() {
   $.ajax({
        method: 'POST',
        url: "/dashboard/customtemplate/getTemplate/",
        data: this.value,
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        dataType:"html",   
    }).success(function (data, status, headers, config) {
    }).error(function (data, status, headers, config) {
    });
})
</script>