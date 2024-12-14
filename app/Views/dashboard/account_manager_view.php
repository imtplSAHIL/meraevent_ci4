<script>
 <?php
  if($this->session->flashdata('msg')){  ?>
  var return_message="<?php echo $this->session->flashdata('msg'); ?>";
  <?php }?>
  
var message = "<?php echo $message;?>";
var organizer_mobile = "<?php echo $org_mobile;?>";
</script>

<div class="rightArea AccountManagerHolder">
	<?php
		if($this->session->flashdata('msg'))
		{
			echo "<div class='db-alert db-alert-success flashHide'>".$this->session->flashdata('msg')."</div>";
		}
		
	?>
	
	
	
    <div class="heading"><h2>Account Manager</h2></div>
	
    <div class="fs-form">         
        <div class="accountmanger">                          
                <div class="accountmanger-holder">
                    <div class="accountmanager-pic">
                        <img src="<?php if($sales_person_detail['imgfileid'] == 0){ echo $this->config->item('cfPath').'images/static/db-accountmanager-icon.jpg'; }else {echo $sales_person_detail['imgpath'];} ?>" class="acimg">
                    </div>
                    <div class="accountmanager-name">
                        <p class="AM-Name"><?php echo $sales_person_detail['name'];?></p>
						<?php 
							if(!isset($sales_person_detail))
								{
									echo "<div class='heading'>Account Manager Not assign </div>";
								}
						?>
                        <p class="AM-Designation"><?php echo $sales_person_detail['designation'];?></p>
                    </div>
                    <div class="accountmanager-social">
						<?php 
							if(!empty($sales_person_detail['facebooklink']))
							{
								echo "<a href='".$sales_person_detail['facebooklink']."' target='_blank' class='facebook'><span class='fa fa-facebook'></span></a>";
							}
							if(!empty($sales_person_detail['twitterlink']))
							{
								echo "<a href='". $sales_person_detail['twitterlink']."' target='_blank' class='twitter'><span class='fa fa-twitter'></span></a>";
							}
							if(!empty($sales_person_detail['linkedinlink']))
							{
								echo "<a href='".$sales_person_detail['linkedinlink']."' target='_blank' class='linkedin'><span class='fa fa-linkedin'></span></a>";
							}
						?>
                        
                        
                        
                    </div>
                </div><!--End of accountmanger-holder-->
                <div class="accountmanger-details">
                    <ul>
                        <li>
                            <span>EMAIL ID</span>
                            <p><a href="mailto:<?php $sales_person_detail['email'];?>"><?php echo $sales_person_detail['email'];?></a></p>
                        </li>
                        <li>
                            <span>MOBILE</span>
                            <p><?php echo $sales_person_detail['mobile'];?></p>
                        </li>
                        <li>
                            <span>LOCATION</span>
                            <p><?php echo $sales_person_detail['city'];?></p>
                        </li>
                    </ul>
                </div><!--End of accountmanger-details-->
                <div class="accountmanger-request-holder" 
					<?php 
						if(!isset($sales_person_detail))
						{
							echo "style='display:none'";
						}
					?>>
				
                    <div class="AM-sendrequest">
                        <!--<a href="<?php echo commonHelperGetPageUrl('send_mail_for_callback', $this->input->get('eventId/').'/'.$sales_person_detail['email']);?>" class="btn fs-btn ambtnone">Request Call Back</a>-->
						
						<a onclick="send_mail('<?php echo $sales_person_detail['email']; ?>','<?php echo $sales_person_detail['name']; ?>')" class="btn fs-btn ambtnone">Request Call Back</a>
                                                <a onclick="send_sms('<?php echo $sales_person_detail['mobile']; ?>','<?php echo $sales_person_detail['name']; ?>')" class="btn fs-btn ambtntwo">Send Sms</a>
						
                    </div>
                </div><!--End of accountmanger-request-holder-->         
        </div><!--End of accountmanger -->
    </div><!--End of fs-form-->
<div class="fs-form">    
        <div class="AM-form">
            <div class="AM-Heading"><h2>Support Team</h2></div>
        <div >
             <div class="accountmanger">
                <div class="accountmanger-details-one">
                    <ul>
                        <li>
                            <span>EMAIL ID</span>
                            <p><a href="mailto:<?php echo $support_team_email;?>"><?php echo $support_team_email;?></a></p>
                        </li>
                        <li>
                            <span>MOBILE</span>
                            <p><?php echo $support_team_mobile;?></p>
                        </li>
                        <li>
                            <span>LOCATION</span>
                            <p>Hyderabad</p>
                        </li>
                    </ul>
                </div><!--End of accountmanger-details-->
                 <div class="accountmanger-request-holder">
                    <div class="AM-sendrequest">
                        <a onclick="send_mail('<?php echo $support_team_email;?>','Support Team')"  class="btn fs-btn ambtnone">Request Call Back</a>
                        <a onclick="send_sms('<?php echo $support_team_mobile; ?>','Support Team')" class="btn fs-btn ambtntwo">Send Sms</a>
                    </div>
                </div><!--End of accountmanger-request-holder-->
             </div>    
        </div>
        </div>
       <div class="AM-form">
            <div class="AM-Heading"><h2>Payments Team</h2></div>
        <div >
             <div class="accountmanger">
                <div class="accountmanger-details-one">
                    <ul>
                        <li>
                            <span>EMAIL ID</span>
                            <p><a href="mailto:<?php echo $payment_team_email;?>"><?php echo $payment_team_email;?></a></p>
                        </li>
                        <li>
                            <span>MOBILE</span>
                            <p><?php echo $payment_team_mobile;?></p>
                        </li>
                        <li>
                            <span>LOCATION</span>
                            <p>Hyderabad</p>
                        </li>
                    </ul>
                </div><!--End of accountmanger-details-->
                 <div class="accountmanger-request-holder">
                    <div class="AM-sendrequest">
                        <a onclick="send_mail('<?php echo $payment_team_email;?>','Payments Team')"  class="btn fs-btn ambtnone">Request Call Back</a>
                       <a onclick="send_sms('<?php echo $payment_team_mobile; ?>','Payment Team')" class="btn fs-btn ambtntwo">Send Sms</a>
                    </div>
                </div><!--End of accountmanger-request-holder-->
             </div>    
        </div>
        </div>
    </div>
<div class="heading AM-Heading" id="ceo"><h2>CEO</h2></div>
      <div class="fs-form">         
        <div class="accountmanger">                
                <div class="accountmanger-holder">
                    <div class="accountmanager-pic">
                        <img src="<?php echo $this->config->item('images_static_path'); ?>team-1.png" class="acimg">
                    </div>
                    <div class="accountmanager-name">
                        <p class="AM-Name">Chennapa Naidu Darapaneni</p>
                        <p class="AM-Designation">Co-Founder & CEO</p>
                    </div>
                    <div class="accountmanager-social">
                        <a href="https://www.facebook.com/naidudc" target="_blank" class="facebook"><span class="fa fa-facebook"></span></a>
                        <a href="https://twitter.com/naidudc" target="_blank" class="twitter"><span class="fa fa-twitter"></span></a>
                        <a href="https://www.linkedin.com/in/naidudc/" target="_blank" class="linkedin"><span class="fa fa-linkedin"></span></a>
                    </div>
                </div><!--End of accountmanger-holder-->               

                <div class="accountmanger-details">
                    <ul>
                        <li>
                            <span>EMAIL ID</span>
                            <p><a href="mailto:<?php echo$ceo_mail;?>"><?php echo$ceo_mail;?></a></p>
                        </li>
                        <li>
                            <span>MOBILE</span>
                            <p><?php echo$ceo_mobile;?></p>
                        </li>
                        <li>
                            <span>LOCATION</span>
                            <p>Hyderabad</p>
                        </li>
                    </ul>
                </div><!--End of accountmanger-details-->

                <div class="accountmanger-request-holder">
                    <div class="AM-sendrequest">
                        <a onclick="send_mail('<?php echo$ceo_mail;?>','Chennapa Naidu Darapaneni')"  class="btn fs-btn ambtnone">Request Call Back</a>
                       <a onclick="send_sms('<?php echo$ceo_mobile; ?>','Chennapa Naidu Darapaneni')" class="btn fs-btn ambtntwo">Send Sms</a>
                    </div>
                </div><!--End of accountmanger-request-holder-->
        </div><!--End of accountmanger -->
    </div><!--End of fs-form-->
</div>
</div>
<script>
var api_bookingOfflineBooking = "<?php echo commonHelperGetPageUrl('api_bookingOfflineBooking');?>";
var api_getTicketCalculation = "<?php echo commonHelperGetPageUrl('api_getTicketCalculation');?>";
</script>


<!--Request Call Back-->
<div id="amCallBack" style="display:none;">
   <div class="db-popup dbam-popup">
      <div class="db-closeholder"><a class="db-close" href="#">&times;</a></div>
      <div class="db-popupcontent">
         <div class="sweet-alert showSweetAlert">
            <form name="mail_form" action="<?php echo commonHelperGetPageUrl('send_mail_for_callback');?>" method="POST">
		<input type="hidden" name="receiver_mail" id="rev_mail" value="" readonly>
		<input type="hidden" name="receivername" id="rev_name" value="" readonly>
		<input type="text" name="custom_subject" id="hiddenDiv"  placeholder="Subject of email" value=""></br>
		<textarea name="message" placeholder="Enter message"></textarea>
                    <div id="validation_mail" class="dbam-popupmsg"></div>
                <div class="sa-button-container">
                    <button name="submit" class="confirm confirmbtn" style="" id="yesButton" onclick=" return length_res_mail(document.mail_form.message)" value="Send"> Send</button>
		 </div>
            </form>
               
          </div>
       </div>
    </div>
</div>

<!--Send Message-->
<div id="amSendMessage" style="display:none;">
   <div class="db-popup dbam-popup">
      <div class="db-closeholder"><a class="db-close" href="#">&times;</a></div>
      <div class="db-popupcontent">
         <div class="sweet-alert showSweetAlert">            
            <h2 id="">Send Message</h2>
            <div class="amSendMessage">
              <form name="sms_form" action="<?php echo commonHelperGetPageUrl('send_sms');?>"  method="POST">
                <fieldset>
                    <input type="hidden" name="receiver_number" id="receiver_number" readonly>
                    <input type="hidden" name="receiver_name" id="receiver_name" readonly>
                    <input type="hidden" name="">
                    <input type="text" id="organizer_mobile" name="organizer_mobile" placeholder="Enter your number" maxlength="20" style="display:none;"  >
                    <div id="validation_organizer_mobile" class="dbam-popupmsg"></div>
                    <textarea name="message"  id="message" readonly></textarea>
                </fieldset>
                <div class="sa-button-container">
                    <button class="confirm sendmessagebtn" id="confirm" >Confirm</button>
                </div>
	      </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!--Send Message-->

<!--for Account Manager Image - -->
<div id="showpic" style="display:none;">
   <div class="db-popup dbam-popup">
      <div class="db-closeholder"><a class="db-close" href="#">&times;</a></div>
      <div class="db-popupcontent">
         <div class="sweet-alert showSweetAlert">            
            
            <div class="showpic">
              <img scr="" id="AccountManagePic">
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
</div>


<script>
if(organizer_mobile == '')
{
    var loadUtilsUrl = '<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>';
    $.fn.intlTelInput.loadUtils(loadUtilsUrl);
    $("#organizer_mobile").intlTelInput({
            autoPlaceholder: "off",
            separateDialCode: true
    }); 
    $("#otp_mobile").intlTelInput({
            autoPlaceholder: "off",
            separateDialCode: true
    });

}
</script>

<script type="text/javascript">
    window.onload = function (e){
        if(organizer_mobile == '')
        {
            var loadUtilsUrl = '<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>';
            $.fn.intlTelInput.loadUtils(loadUtilsUrl);
            $("#organizer_mobile").intlTelInput({
                    autoPlaceholder: "off",
                    initialCountry: intlCountrycode,
                    separateDialCode: true
            }); 
            $("#otp_mobile").intlTelInput({
                    autoPlaceholder: "off",
                    initialCountry: intlCountrycode,
                    separateDialCode: true
            });

        }
    }
</script>