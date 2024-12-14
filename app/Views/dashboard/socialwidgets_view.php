<style type="text/css">
    .socialwidget_instructions {
        margin: 80px 0 20px 0; 
    }
    .socialwidget_instructions h3{
        margin: 20px 0 20px 0; 
        font-size: 18px;
        text-decoration: underline; 
    }
    .socialwidget_info_container {
        margin-bottom: 30px;
    }
    .socialwidget_info_container p {
        padding: 4px 0px 10px 0px;
    }
    .socialwidget_steps_img {
        width: auto;
        max-width: 540px;
    }
    .socialwidget_steps_img img{
        width: 100%;
    }
</style>
<div class="rightArea">
    <?php
        $successMessage = $this->customsession->getData('successMessage');
        $this->customsession->unSetData('successMessage');

        $errorMessage = $this->customsession->getData('errorMessage');
        $this->customsession->unSetData('errorMessage');
    ?>
   <?php if(isset($successMessage) && strlen($successMessage) > 1) { ?>
        <div id="Message" class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $successMessage; ?></strong> 
        </div>                 
    <?php } ?>   
    <?php if(isset($errorMessage) && strlen($errorMessage) > 1) { ?>
        <div id="Message" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $errorMessage; ?></strong> 
        </div>                 
    <?php } ?>
    <div class="heading">
        <h2>Social Widgets</h2>
    </div>
    <!--Data Section Start-->

    <div> <!-- class="fs-form" -->
        <div class="editFields fs-add-discount-box">

            <p>Connect your Facebook account with MeraEvents to add Page Tab</p>


            <button class="createBtn" onclick="fb2Auth();" id="addtofbButton">Add to Facebook Page </button>

             <div class="socialwidget_instructions">
                <h3>Instructions :</h3>
            <div class="socialwidget_info_container">                
                <p><b>Step 1 : </b>To start page tab activation, Click on above "Add to Facebook Page" button.</p>
                <p><b>Step 2 : </b>You will be redirected to Facebook</p>
                <p><b>Step 3 : </b>If you are already logged-in to Facebook, you will see ‘Add Page Tab’ page of Facebook else you need to login into your Facebook account. Now, select Facebook page where this event tab is to be shown.</p>
                <div class="socialwidget_steps_img">
                    <img src="<?php echo $this->config->item('images_static_path'); ?>facebook-step-1.png" />
                </div>   
            </div> 

            <div class="socialwidget_info_container">                
                <p><b>Step 4 : </b>Now, Ticket menu shows up on this page (or under ‘More’ menu)</p>
                <div class="socialwidget_steps_img">
                    <img src="<?php echo $this->config->item('images_static_path'); ?>facebook-step-5.png" />
                </div>   
            </div>

            <div class="socialwidget_info_container">                
                <p>You can change the priority of Tab from page Settings -> Edit Page -> Tabs.</p>
            </div>
            


        </div>









        </div>



       












    </div>

</div>
<script>
var h = parseInt($(window).height())*0.6; 
var w = parseInt($(window).width())*0.6 ;
function fb2Auth(){
    document.getElementById("addtofbButton").disabled = true;
    var fburl = "<?php echo $fbloginUrl; ?>";
    window.open(fburl, "", "width="+w+", height="+h+"top=0,left=0");
}

</script>
