
<div class="page-container">
   <div class="wrap orgfeaturessection">
      <!-- Header container   -->
      <?php $this->load->view("includes/static/common/orgfeatures_header_view.php"); ?>
      <!-- Header container -->
      <!--Start of Features Tab-->
      <div class="container-fluid">
         <div class="container">
               <div class="row">
                  <div class="orgfeaturestab">
                     <ul>
                        <li><a href="<?php echo site_url(); ?>features">Manage</a></li>
                        <li><a href="<?php echo site_url(); ?>features/promote">Promote</a></li>
                        <li><a href="<?php echo site_url(); ?>features/communicate">Communicate</a></li>
                        <li><a href="<?php echo site_url(); ?>features/reports">Reports</a></li>
                        <li><a href="<?php echo site_url(); ?>features/payment">Payment</a></li>
                        <li><a href="<?php echo site_url(); ?>features/checkinapp">Check In App</a></li>
                        <li><a href="<?php echo site_url(); ?>features/whitelabelapp" class="tabselected">White Label Networking App</a></li>
                     </ul>
               </div>  
               </div>        
         </div>
      </div>
     <section id="content1">        
         <div class="container-fluid orgfeatures-bg orgfeatures-section">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="orgfeatures-feat text-left marginbottom10">
                           <img src="<?php echo $this->config->item('images_static_path'); ?>moozup-feat-screen.jpg">
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="orgfeatures-info">
                           <h2>MoozUp</h2>
                           <p>MoozUp white label solution, allows your event to go mobile,
and supercharges your attendee engagement and
networking experience.</p>
<p><b>Advantages of MoozUp</b></p>
   <p class="marginbottom10"><img src="<?php echo $this->config->item('images_static_path'); ?>arrow.gif"> White Label Apps</p>
   <p class="marginbottom10"><img src="<?php echo $this->config->item('images_static_path'); ?>arrow.gif"> Attendee Networking</p>
   <p class="marginbottom10"><img src="<?php echo $this->config->item('images_static_path'); ?>arrow.gif"> Live Q & A</p>
   <p class="marginbottom10"><img src="<?php echo $this->config->item('images_static_path'); ?>arrow.gif"> Agenda</p>
   <p class="marginbottom10"><img src="<?php echo $this->config->item('images_static_path'); ?>arrow.gif"> Sponsors</p>
   <p class="marginbottom10"><img src="<?php echo $this->config->item('images_static_path'); ?>arrow.gif"> Meeting Requests</p>
   <p class="marginbottom10"><img src="<?php echo $this->config->item('images_static_path'); ?>arrow.gif"> Live Polls</p>
   <p class="marginbottom10"><img src="<?php echo $this->config->item('images_static_path'); ?>arrow.gif"> Social Media Integration</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>       
 
      </section>
   </div>
   <!-- End of Wrap -->
</div>
<!--End of Page Container-->