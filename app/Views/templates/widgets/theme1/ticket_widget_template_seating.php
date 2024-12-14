
      <div class="page-container">
      <div class="wrap">
      <!--   Big container   -->
      <div class="container">
      <div class="row">
         <div class="wizard768"> <!--col-lg-8 col-lg-offset-2 -->
            <!--      Wizard container        -->
            <div class="wizard-container">
               <div class="card wizard-card">
                      
                     <div class="wizard-header">
                        <div class="wizard-title">
                            <h2 style="<?php if(isset($eventTitleColor) && $eventTitleColor != '') echo 'color:' . '#' . $eventTitleColor . ';'; ?>"><?php echo (isset($eventData['title']) && $showTitle)?ucwords($eventData['title']):'';?></h2>
                        </div>
                        <div class="wizard-location">
                            <?php if($showDateTime){ ?>
                           <p><?php 
                             if(isset($configCustomDatemsg[$eventId]) && !isset($configCustomTimemsg[$eventId])){
                             	echo $configCustomDatemsg[$eventId]." | ".allTimeFormats($eventData['startDate'],4).' to '.allTimeFormats($eventData['endDate'],4).' '.$eventData['location']['timezone'];
                            }else if(isset($configCustomTimemsg[$eventId]) && !isset($configCustomDatemsg[$eventId])){
                             	echo allTimeFormats($eventData['startDate'],3);?><?php if (allTimeFormats($eventData['startDate'],9) != allTimeFormats($eventData['endDate'],9))  { echo " - ". allTimeFormats($eventData['endDate'],3);} echo " | ".$configCustomTimemsg[$eventId];
                            }else if(isset($configCustomTimemsg[$eventId]) && isset($configCustomDatemsg[$eventId])){
                             	echo $configCustomDatemsg[$eventId]." | ".$configCustomTimemsg[$eventId];
                            }else{
                            	echo allTimeFormats($eventData['startDate'],3);?><?php if (allTimeFormats($eventData['startDate'],9) != allTimeFormats($eventData['endDate'],9))  { echo " - ". allTimeFormats($eventData['endDate'],3);} echo " | ".allTimeFormats($eventData['startDate'],4).' to '.allTimeFormats($eventData['endDate'],4).' '.$eventData['location']['timezone'];
                            }  ?></p>
                            <?php } ?>
                           <?php if($showLocation){ ?>
                           <p><a><?php if(isset($eventData['eventMode']) && $eventData['eventMode'] == 1){ echo "Webinar"; } else { echo $eventData['fullAddress']; } ?></a></p>
                           <?php } ?>
                           <?php  if(isset($widgetSettings[WIDGET_NOTES]) && $widgetSettings[WIDGET_NOTES]!=''){ ?>
                           <div class="widgetnotes">
                               Note: <?php echo $widgetSettings[WIDGET_NOTES];?>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                     <div class="wizard-navigation">
                        <ul class="nav nav-tabssection">
                            <li><a href="<?php echo $ticketediteventurl;?>">
                                    <?php  if(isset($widgetSettings[TICKET_TAB_TITLE]) && $widgetSettings[TICKET_TAB_TITLE]!=''){
                                        echo $widgetSettings[TICKET_TAB_TITLE];
                                    }else{ echo "TICKETS"; }?>
                                    
                                </a></li>
                                <li><a href="<?php echo $ticketorderdetailurl;?>">DETAILS</a></li>
                            <li><a class="tabhighlight" style="<?php if ($headingBackgroundColor != '') echo 'background:' . '#' . $headingBackgroundColor . ';'; ?>">PAYMENT</a></li>
                        </ul>
                     </div>
                     <div class="iframetab-content">
                         <div class="tab-pane" id="ticket_pane_tab1">
                           <div class="row">
                              <div class="widget-container">
                               
                                  
                                 <?php $this->load->view('seatsio'); ?>
                                  
                                  
                              
                              </div>
                              
                               
                             </div>
                        </div>  
                          
                      </div>   
                 
                  </div>
                  </div>
                  <!-- wizard container -->
                  </div>
               </div>
               <!-- row -->
            </div>
            <!--  big container -->
         </div>
      </div>
      

<script type="text/javascript" language="javascript">
var api_getTinyUrl = '';
</script>