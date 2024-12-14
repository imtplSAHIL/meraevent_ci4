<?php 
	$userId = $this->customsession->getUserId();
	$isLogin = ($userId > 0) ? 1 : 0 ;
	$isAttendee = $this->customsession->getData('isAttendee');
	$isPromoter = $this->customsession->getData('isPromoter');
	$isOrganizer = $this->customsession->getData('isOrganizer');
	//print_r($this->uri);

 ?>
<div class="leftFixed">
 <div id="cssmenu"><!--class="fs-special-view-left-menu"-->
        <ul>
          <li class="has-sub"><a href='<?php echo commonHelperGetPageUrl('user-myprofile');?>' <?php echo ($this->uri->segment(1) == 'profile') ? ' class="currentPage"' : ''; ?>><span class="icon icon-configer"></span>Profile</a>
            <ul <?php echo ($this->uri->segment(1) == 'profile') ? ' id="currentMenu" style="display: block"' : ''; ?>>
              <li><a <?php if($this->uri->segment(1)=="profile" && $this->uri->segment(2)==""){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-myprofile');?>"  id="showdropdowntwo" class="unselected">Personal Details</a> </li>
			  <?php if($isOrganizer == 1) { ?>
              <li><a <?php if($this->uri->segment(2)=="company"){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-companyprofile');?>" class="unselected">Company Details</a></li>
			   
			   <li><a <?php if($this->uri->segment(2)=="bank"){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-bankdetail');?>" >Bank Details</a></li>
               <li><a <?php if($this->uri->segment(2)=="alert"){echo 'class="currentsubLink"';}?>  href="<?php echo commonHelperGetPageUrl('user-alert');?>" >Alerts</a></li>
			   
			  <?php } ?>
			  
              <li><a <?php if($this->uri->segment(2)=="changePassword"){echo 'class="currentsubLink"';}?>  href="<?php echo commonHelperGetPageUrl('changepassword');?>"  class="unselected">Change Password</a></li>
              <li><a <?php if($this->uri->segment(2)=="developerapi"){echo 'class="currentsubLink"';}?>  href="<?php echo commonHelperGetPageUrl('developerapi');?>"  class="unselected">Apps List</a></li>
              <li><a <?php if($this->uri->segment(3)=="affiliateBonus"){echo 'class="currentsubLink"';}?>  href="<?php echo commonHelperGetPageUrl('dashboard-global-affliate-bonus');?>"  class="unselected">Affiliate Bonus</a></li>
            </ul>
          </li>
          
          <!--my wallet-->
          <!--
          <li class="has-sub"><a href='<?php echo commonHelperGetPageUrl('user-mywallet');?>' <?php echo ($this->uri->segment(1) == 'mywallet') ? ' class="currentPage"' : ''; ?>><span class="icon icon2-google-wallet menuLeft"></span><span>MeraWallet</span></a>
            <ul <?php echo ($this->uri->segment(1) == 'mywallet') ? ' id="currentMenu" style="display: block"' : ''; ?>>
              <li><a <?php if($this->uri->segment(1)=="mywallet" && $this->uri->segment(2
                      )==""){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-mywallet');?>"  id="showdropdowntwo" class="unselected">Wallet Home</a> </li>
              <li><a <?php if($this->uri->segment(2)=="transactions"){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-mywallet-transactions');?>" class="unselected">Transactions</a></li>
			   -->
			   <!--<li><a <?php if($this->uri->segment(2)=="vouchers"){echo 'class="currentsubLink"';}?> href="<?php echo commonHelperGetPageUrl('user-mywallet-vouchers');?>" class="unselected">Vouchers</a></li>
               <li><a <?php if($this->uri->segment(2)=="beneficiaries"){echo 'class="currentsubLink"';}?>  href="<?php echo commonHelperGetPageUrl('user-mywallet-beneficiaries');?>" class="unselected">Beneficiaries</a></li>-->
		     
			  <!--my wallet-->
              
            </ul>
          </li>
          <li><a href="<?php echo commonHelperGetPageUrl('dashboard-recurring');?>" class="unselected"><span class="icon icon2-gbp"></span><span>Recurring Payments</span></a></li>
          
        </ul>
      </div>
      <div class="sidebar-full-height-bg"></div>
 </div>
