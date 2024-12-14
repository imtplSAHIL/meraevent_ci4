<!--important-->
<div class="page-container">
    <div class="wrap">
        <div class="container"> 

            <div class="innerPageContainer">
                <h2 class="create_eve_title">Start here </h2>
                
                <div class="row">
                    <form enctype="multipart/form-data" name="createEventForm" id="createEventForm" method="POST"> 
                        <input type="hidden" name="ticketCount" id="ticketCount" value="">
                        <input type="hidden" name="eventId" id="eventId" value="<?php  if (isset($eventId) && ($eventId > 0 )) { echo $eventId;} else{ echo 0;}?>">
                        <input type="hidden" name="thumbnailfileid" id="thumbnailfileid" value="<?php echo isset($eventDetails['thumbnailfileid'])?$eventDetails['thumbnailfileid']:'';?>">
                        <input type="hidden" name="bannerfileid" id="bannerfileid" value="<?php echo isset($eventDetails['bannerfileid'])?$eventDetails['bannerfileid']:'';?>">
                        <input type="hidden" name="submitValue" id="submitValue" value="" > 
                        <input type="hidden" name="categoryId" id="categoryId" value="<?php echo isset($eventDetails['categoryId'])?$eventDetails['categoryId']:'';?>"> 
                        <input type="hidden" name="subcategoryId" id="subcategoryId" value="<?php echo isset($eventDetails['subcategoryId'])?$eventDetails['subcategoryId']:'';?>">
                        <input type="hidden" id="addedCategories" value="<?php echo isset($eventDetails['categoryName'])?$eventDetails['categoryName']:'';?>">
                        <input type="hidden" id="cloudPath" value="<?php echo $this->config->item('images_content_cloud_path');?>">
                        <input type="hidden" name="latitude" id="latitude" value="<?php echo isset($eventDetails['latitude'])?$eventDetails['latitude']:'';?>">
                        <input type="hidden" name="longitude" id="longitude" value="<?php echo isset($eventDetails['longitude'])?$eventDetails['longitude']:'';?>"> 
                        <?php if(isset($duplicateEvent)){ ?>
                        <input type="hidden" name="duplicateEvent" id="duplicateEvent" value="<?php echo isset($duplicateEvent)?$duplicateEvent:'';?>"> 
                        <input type="hidden" name="eventid" id="eventid" value="<?php echo isset($eventid)?$eventid:'';?>"> 
                        <?php } ?>
                        <?php 
                        if(isset($userType) && $userType == "superadmin"){ ?>
                            <input type="hidden" name="userType" id="userType" value="<?php echo $userType ;?>"> 
                        <?php }
                               $disabledRegistrationTypeFree = $disabledRegistrationTypeNoReg = $cantChangeMessage = $bannerPathMsg=$thumbnailPathMsg='';
                               if (isset($eventId) && ($eventId > 0 )) {
                                   ?>
                            <input type="hidden" id="registrationTypeCheck" name="oldregistrationType" value="<?php echo isset($eventDetails['registrationType'])?$eventDetails['registrationType']:''; ?>">
                            <?php
                            if (isset($transactionsCount) && $transactionsCount > 0) {
                                if ($eventDetails['registrationType'] == 2) {
                                    $disabledRegistrationTypeFree = ' disabled="disabled" ';
                                    $disabledRegistrationTypeNoReg = ' disabled="disabled" ';
                                    $cantChangeMessage = 'cantChangeEventType';
                                }
                                if ($eventDetails['registrationType'] == 1) {
                                    $disabledRegistrationTypeNoReg = ' disabled="disabled" ';
                                    $cantChangeMessage = 'cantChangeEventType';
                                }
                            }
                            
                             if(isset($eventDetails['bannerPath']) && $eventDetails['bannerPath']!='' && ($eventDetails['bannerPath'] != $this->config->item('images_content_cloud_path'))){ 
                                $bannerPathMsg='style="display:none;"';
                        }
                              if(isset($eventDetails['thumbnailPath']) && $eventDetails['thumbnailPath']!='' && ($eventDetails['thumbnailPath'] != $this->config->item('images_content_cloud_path'))){ 
                                $thumbnailPathMsg='style="display:none;"';
                              }  
                        }
                        ?>
                        <div class="col-md-8 col-xs-12 col-sm-12">
                            <div class="row create_eve_container create_eve_bg animated">
                                <div class="col-sm-12 ">
                                    <h2 class="title_1">About</h2>
                                    <?php if(isset($messages)){ ?>
                                    <div class="db-alert db-alert-info"><?php echo $messages; ?></div>
                                    <?php } ?>
                                    <div id="eventDataSuccess" style="color: #26A65B;">

                                    </div>
                                    <div class="create-event-error">
                                        <ul id="eventDataErrors"></ul>
                                    </div>
                                  <!--   <div class="form-group event_type">
                                        <label>Event Type</label><br>
                                        <input <?php if(isset($eventDetails['registrationType']) && $eventDetails['registrationType']==2){ echo 'checked="checked"';}?> type="radio" name="registrationType" value="2" 
                                               id="registrationType2" class = "selecteventtype <?php echo $cantChangeMessage; ?>">
                                        <label class="eventype_space">Paid</label>
                                        <input <?php if(isset($eventDetails['registrationType']) && $eventDetails['registrationType']==1){ echo 'checked="checked"';}?> <?php echo $disabledRegistrationTypeFree; ?> type="radio" name="registrationType" value="1" id="registrationType1" class = "selecteventtype <?php echo $cantChangeMessage; ?>" >
                                        <label class="eventype_space">Free</label>
                                        <input <?php if(isset($eventDetails['registrationType']) && $eventDetails['registrationType']==3){ echo 'checked="checked"';}?> <?php echo $disabledRegistrationTypeNoReg; ?> type="radio" name="registrationType" value="3" id="registrationType3" class = "selecteventtype <?php echo $cantChangeMessage; ?>" >
                                        <label class="eventype_space">No Registration</label>

                                    </div>-->
                                    <div class="form-group">
                                        <label>Event Title</label>
                                        <input <?php if(!isset($eventDetails['title'])){ echo 'autofocus="true"'; } ?> type="text" class="form-control eventFields" name="title" id="eventTitle" value="<?php echo isset($eventDetails['title'])?$eventDetails['title']:'';?>">
                                    </div>

                                    <div class="form-group create_eve_labelspace">
                                        <label>Description</label>
                                        <textarea style="height: 170px;" type="text" ui-tinymce ="tinymceOptions" id="event-desc"  class="form-control eventFields" name="description" ><?php echo isset($eventDetails['description'])?$eventDetails['description']:'';?></textarea>
                                        
                                    </div>
                                    <div class="create_eve_dropdowns">
                                        <ul>
                                            <li class="dropdown fleft">
                                                 <label for="Category">Category</label>
                                                <a href="javascript:void(0);" class="dropdown-togglep selectCategory" data-toggle="dropdown" role="button" aria-expanded="false" <?php if(isset($eventDetails['categoryThemeColor'])){echo 'style="background:'.$eventDetails['categoryThemeColor'].'"';}?>><?php echo isset($eventDetails['categoryName'])?$eventDetails['categoryName']:'Select a Category';?><span class="icon-downArrow"></span></a>
                                                <ul class="dropdown-menu categorySelect" role="menu">
                                                    <?php if(isset($categoryList) && !empty($categoryList)){
                                                        foreach ($categoryList as $cListKey => $clistValue) {  ?>
                                                    <li onclick="categoryChanged('<?php echo $clistValue['id'];?>','<?php echo $clistValue['name'];?>','true','<?php echo $clistValue['themecolor'];?>');">
                                                        <a>
                                                            <i class="mecat-<?php echo strtolower(preg_replace("/[^a-zA-Z]/", "",$clistValue['name']));?> col<?php echo strtolower(preg_replace("/[^a-zA-Z]/", "",$clistValue['name']))?>"></i><?php echo strtolower($clistValue['name'])?>
                                                        </a>
                                                    </li>
                                             <?php      }
                                                    }?>


                                                </ul>
                                                <span id="categoryError" class="create-event-error error"></span>
                                            </li>

                                            <li class="dropdown ">
<label for="Sub Category" class="">Sub Category</label>
<input type="text" placeholder="Enter Sub Category " class="form-control eventFields" id="subCategoryName" name="subCategoryName" value="<?php echo isset($eventDetails['subCategoryName'])?$eventDetails['subCategoryName']:'';?>"/>
<span id="sub_category_error" style="color: red;"></span>
                                            </li>

                                        </ul>
                                    </div>
                                    
                                    <?php
                                    $liveevent_className = "";
                                    $liveevent_CheckedStatus = "";
                                    $liveevent_Value = 0;
                                    $demo_interest_CheckedStatus = "";
                                    if (isset($eventId) && $eventId > 0 && $eventDetails['eventMode'] == 1) {
                                        $liveevent_className = " selected";
                                        $liveevent_CheckedStatus = "checked='checked'";
                                        $liveevent_Value = 1;
                                    }
                                    $demo_interest_value = 0;
                                    if(isset($eventDetails['eventDetails']["demo_interest"]) || $eventDetails['eventDetails']["demo_interest"]==1)
                                    {
                                        $demo_interest_value = 1;
                                        $demo_interest_CheckedStatus = "checked='checked'";
                                    }
                                    ?>
                                    <div class="form-group sales">
                                        <span class='custom-checkbox<?php echo $liveevent_className; ?>'>
                                            <input type="checkbox" id="liveevent"  name="isliveevent" value="<?php echo $liveevent_Value; ?>" <?php echo $liveevent_CheckedStatus; ?> onclick="liveEventChange(this)" /> 
                                        </span>
                                        <h5> Online Event </h5><br>
                                    </div>
                                    <div class="form-group onlineEventLinkDiv sales">
                                    <span class='custom-checkbox <?php if($demo_interest_value == 1){ echo "selected"; }?>' >
                                            <input type="checkbox" id="demo_interest" name="demo_interest" value="<?php echo $demo_interest_value; ?>"  <?php echo $demo_interest_CheckedStatus; ?> onclick="demoStatusChange(this)" /> 
                                        </span>
                                        <h5>I'm interested to take a demo of the MeraEvents Virtual Event Platform.</h5><br>
                                    </div>

                                  <!-- <div class="form-group onlineEventLinkDiv eventTags fullwidth_form" style="display:none;">
                                        <span>Create a meeting on any Video conferencing tool either Zoom or Google Meet or your preferred app and paste the invite url here.</span>
                                        <p><b>Note: Ticket buyers will receive the below link on their confirmation ticket to join your online event.</b></p>
                                        <label>Meeting Invite Url</label><span><a onclick="doItLater()">(Do it Later)</a></span>
                                        <input type="url" class="form-control eventFields" name="onlineEventUrl" id="onlineEventUrl" value="<?php echo $eventDetails['eventDetails']['externalmeetingurl']; ?>">
                                        <p><b>For unlimited video conference packages, contact Pavan +91- 9396345677</b></p>                                        
                                    </div> -->

                                    <div class="form-group eventTags fullwidth_form">
                                        <label>Event URL </label>
                                        <span> <?php echo commonHelperGetPageUrl('preview-event'); ?></span>
                                        <input type="text" class="form-control eventFields tagsField " value="<?php echo isset($eventDetails['url'])?$eventDetails['url']:'';?>" name="url" id="eventUrl">

                                        <a onclick="checkUrlExists()" href="javascript:void(0);" class="checkurl_btn">Check Availability</a>
                                        <a onclick="editUrl()" href="javascript:void(0);" class="checkurl_btn" id="editurl">Edit</a>
                                        <span id="checkUrlAvail"></span>
                                    </div>

                                    <div class="form-group eventTags">
                                        <label>Tags </label>
                                        <input id="event_tags" type="text" placeholder="Enter a tag"
                                               name="tags" value="<?php echo isset($eventDetails['tags'])?strtolower($eventDetails['tags']):'';?>">
                                        <span id="event_tags_error" style="color: red;"></span>


                                    </div> 

                                    <div id="event_venue_div" <?php echo (isset($eventDetails['categoryId']) && ($eventDetails['categoryId'] == 15 || $eventDetails['categoryId'] == 16 || $eventDetails['eventMode'] == 1)) ? 'style="display:none"' : ''; ?>>
                                        <h2 class="title_2 clearBoth">Event Venue</h2>
                                        <div id="div_webinar">
                                            <div class="form-group" id="locationField"  >
                                                <label>Venue</label>
                                                <input type="text" class="form-control eventFields placechange" id="eventVenue" name="venueName" value="<?php echo isset($eventDetails['venueName'])?$eventDetails['venueName']:'';?>">
                                                <button id="clearVenue" class="clear-venue"><span class="icon2-repeat"></span></button>

                                                <span class="pull-right addAdd">+</span>
                                            </div>
                                            <div class="add_address" id="address" style="display: none;">
                                                <label class="add_address_space1">Address line 1</label>
                                                <input type="text" class="form-control eventFields field" id="eventAddress1" name="venueaddress1" value="<?php echo isset($eventDetails['location']['address1'])?$eventDetails['location']['address1']:'';?>">


                                                <div class="clear"></div>

                                                <label class="add_address_space">Address line 2</label>
                                                <input type="text" class="form-control eventFields" id="eventAddress2" name="venueaddress2" value="<?php echo isset($eventDetails['location']['address2'])?$eventDetails['location']['address2']:'';?>">


                                                <div class="clear"></div>				

                                                <ul>
                                                    <li <?php if($eventDetails['location']['mappingStateId']>0){ echo 'style="width:100%;"';} ?>>
                                                        <label class="add_address_space" for="Country">Country</label>
                                                        <input type="text" placeholder="Enter Your Country" class="form-control eventFields countryAutoComplete locationfields" id="country" name="country" value="<?php echo isset($eventDetails['location']['countryName'])?$eventDetails['location']['countryName']:'';?>"/>
                                                    <label for="country" id="countryError">&nbsp;</label>
                                                    </li>
                                                    <li <?php if($eventDetails['location']['mappingStateId']>0){ echo 'style="display:none;"';} ?>>
                                                        <label for="State" class="add_address_space">State</label>
<input type="text" placeholder="Enter Your State" class="form-control eventFields stateAutoComplete locationfields" id="state" name="state" value="<?php echo isset($eventDetails['location']['stateName'])?$eventDetails['location']['stateName']:'';?>"/>
                                                   <label for="state" id="stateError">&nbsp;</label>
                                                    </li>
                                                    <li>
                                                        <label for="city" class="add_address_space">City</label>
<input type="text" placeholder="Enter Your City" class="form-control eventFields cityAutoComplete locationfields" id="city" name="city" value="<?php echo isset($eventDetails['location']['cityName'])?$eventDetails['location']['cityName']:'';?>"/>
                                                   <label for="city">&nbsp;</label>
                                                    </li>
                                                     <li>
                                                        <label for="pincode" class="add_address_space">Pincode</label>
<input type="text" placeholder="Enter Your Pincode" class="form-control eventFields" id="pincode" name="pincode" value="<?php echo (isset($eventDetails['location']['pincode'])&& $eventDetails['location']['pincode']>0) ? $eventDetails['location']['pincode']:'';?>"/>
<label for="pincode">&nbsp;</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>   
                                    </div>

                                    <h2 class="title_3 clearBoth">Event Date</h2>
                                    <input type="hidden" name="isParentEvent" id="isParentEvent" value="<?php echo (isset($multiEvent) && $multiEvent==1) ? 1 : 0 ?>">
                                    <input type="hidden" name="selectMonthType" id="selectMonthType" value="0">
                                    <div class="create_eve_where change_currency ">
                                        <?php if($multiEvent!=1) {?>
                                        <ul id="singleEventDateTime">
                                            <li>
                                                <label for="Start date">Start date </label>
                                                <?php if (isset($eventId) && $eventId != '' && ( strtotime($eventDetails['startDate']) <= strtotime(allTimeFormats('',11))) && $eventDetails['status'] == 1 && $userType != "superadmin") { ?>
                                                <input type="text" class="form-control eventFields" id="start_date" name="startDate" value="<?php echo $eventDetails['convertedStartDate'];?>" readonly="readonly" disabled>
                                                <?php } else { ?>
                                                <input type="text" class="form-control eventFields" id="start_date" name="startDate" readonly="readonly" value="<?php echo isset($eventDetails['convertedStartDate'])?$eventDetails['convertedStartDate']:'';?>">
                                                    
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <label for="Start time">Start time</label>
                                                <div class="input-group bootstrap-timepicker">
                                                    <input id="event_start" type="text" class="input-small" name="startTime" readonly="readonly" value="<?php if(isset($eventDetails['convertedStartTime'])){ echo $eventDetails['convertedStartTime'];}?>" <?php if (isset($eventId) && $eventId != '' && ( strtotime($eventDetails['startDate']) <= strtotime(allTimeFormats('',12))) && $eventDetails['status'] == 1 && $userType != "superadmin") {
                                                        echo "disabled";
                                                } ?> >
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                </div>
                                            </li>
                                            <li>
                                                <label for="End date">End date</label>
                                                <input type="text" class="form-control eventFields" id="end_date" name="endDate" value="<?php if(isset($eventDetails['convertedEndDate'])){echo $eventDetails['convertedEndDate'];}?>" readonly="readonly">
                                                
                                            </li>
                                            <li>
                                                <label for="End time">End time</label>
                                                <div class="input-group bootstrap-timepicker">
                                                    <input id="event_end" type="text" class="input-small " name="endTime" value="<?php if(isset($eventDetails['convertedEndTime'])){echo $eventDetails['convertedEndTime'];}?>" readonly="readonly">
                                                    
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                                </div>
                                            </li>
                                            <li>
                                                <label  >Time Zone</label>
                                                    <div class="TicketDropdownHolder">
                                                        <select name="timezoneId"  id="timeZoneId">
                                                            <?php foreach ($timeZoneList as $timeZone) { ?>
                                                                <option  value="<?php echo $timeZone['id']; ?>" <?php if($eventDetails['timeZoneId']==$timeZone['id']){ echo 'selected="selected"';}?>><?php echo $timeZone['timezone']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                            </li>
                                            </ul>

                <?php if( !(isset($eventId) && $eventId != '') ) { ?>
                <p class="MultiDateEventsText" id= "multiEventsCheck"><a><i class="icon-calender"></i> Schedule Multiple Events</a></p>
                <?php } ?>                                         
             <?php } ?>
        <div id="multiEventDateTime" 
            style="<?php echo ($multiEvent!=1) ? 'display: none' : '' ;?> " >
         <!-- Multiple Date Events Open Container -->

            <div class="form-group" >
                <input type="hidden" name="multiEvents" id="multiEvents" value="<?php echo (isset($multiEvents) && $multiEvents!='' ) ? $multiEvents : '[]' ?>">
                <input type="hidden" name="deletedEvents" id="deletedEvents" value="[]">
               <div class="MultiDateEventsOpenContainer" id="MultiDateEventsOpenContainer" style="<?php echo (isset($multiEvent) && $multiEvent==1) ? 'display: none' : '' ;?>">
                  <div class="MultiDates-ListItems">
                     <ul>
                        <li class="width100">
                           <label>How often does this event occur?</label>
                           <div class="width40">
                              <div class="TicketDropdownHolder">
                                 <select id="eventPeriodType" class="MultiSelectBox" >
                                    <option value="days">Daily</option>
                                    <!--<option value="weeks">Weekly</option>
                                    <option value="months">Monthly</option>
                                    <option value="custom">Custom</option>-->
                                 </select>
                              </div>
                           </div>
                        </li>
                        <div id="monthlyEvents" style="display: none;">
                            <div id="byDayOfMonth">
                                <li class="width100">
                                   <label>It occurs every</label>
                                   <div class="width40">
                                      <div class="TicketDropdownHolder">
                                         <select   id="monthlyDay" class="MultiSelectBox">
                                            <?php for ($i=1; $i < 31; $i++) { 
                                                echo "<option value='$i'>".ordinal($i)."</option>";
                                            } ?>
                                            
                                         </select>
                                         <label class="multiselect-smalltext">day of the month</label>
                                      </div>
                                   </div>
                                </li>
                                <p class="inlineblock MarginBottom">
                                    <a href="javascript:void(0);" id="showDayOfWeek">Select by day of the week</a>
                                </p>
                            </div>
                            <div id="byDayOfWeek" style="display: none;">
                                <li class="width100">
                                   <label>Repeating every</label>
                                   <div class="width30">
                                      <div class="TicketDropdownHolder">
                                         <select   id="monthlyWeek" class="MultiSelectBox">
                                           <option value="0">First</option>
                                           <option value="1">Second</option>
                                           <option value="2">Third</option>
                                           <option value="3">Fourth</option>
                                         </select>
                                      </div>
                                   </div>

                                   <div class="width30 inlineblock repeatingdays">
                                      <div class="TicketDropdownHolder-Multidates">
                                         <select id="RepeatingEveryWeek"  multiple>
                                            <option value="0" checked>Sunday</option>
                                            <option value="1">Monday</option>
                                            <option value="2">Tuesday</option>
                                            <option value="3">Wednesday</option>
                                            <option value="4">Thursday</option>
                                            <option value="5">Friday</option>
                                            <option value="6">Saturday</option>
                                        </select>
                                      </div>
                                   </div>
                                </li>    
                                <p class="inlineblock MarginBottom">
                                    <a href="javascript:void(0);" id="showDayOfMonth">Select by day of the month</a>
                                </p>
                            </div>
                        </div>
                        <li class="width100" id="weeklyEvents" style="display: none;">
                           <label>What day(s) of the week?</label>                           
                            <div class="width40">
                                <div class="TicketDropdownHolder-Multidates">
                                <select id="MultiDatesWhatDaysofWeek"  multiple>
                                    <option value="0" checked>Sunday</option>
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5">Friday</option>
                                    <option value="6">Saturday</option>
                                </select>
                            </div>
                            </div>
                        </li>
                     </ul>
                  </div>


                  <div class="MultiDates-ListItems">
                     <ul>
                        <li>
                           <label>Start Date</label>
                           <div class="TicketDropdownHolder">
                              <?php if (isset($eventId) && $eventId != '' && ( strtotime($eventDetails['startDate']) <= strtotime(allTimeFormats('',11))) && $eventDetails['status'] == 1 && $userType != "superadmin") { ?>
                                <input type="text" class="form-control eventFields" id="repeatingStartDate"  value="<?php echo $eventDetails['convertedStartDate'];?>" readonly="readonly" disabled>
                                <?php } else { ?>
                                <input type="text" class="form-control eventFields" id="repeatingStartDate"  value="<?php echo isset($eventDetails['convertedStartDate'])?$eventDetails['convertedStartDate']:'';?>" readonly="readonly" >
                                    
                                <?php } ?>
                           </div>
                        </li>
                        <li>
                           <label>End Date</label>
                           <div class="TicketDropdownHolder">
                              <input id="repeatingEndDate" type="text" class="form-control eventFields "  value="<?php if(isset($eventDetails['convertedEndDate'])){echo $eventDetails['convertedEndDate'];}?>" readonly="readonly">
                           </div>
                        </li>
                        <li>
                        <label>Time Zone</label>
                        <div class="TicketDropdownHolder">
                            <select name="multEventTimezoneId" id="multEventTimezoneId">
                                <?php foreach ($timeZoneList as $timeZone) { ?>
                                    <option  value="<?php echo $timeZone['id']; ?>" <?php if($eventDetails['timeZoneId']==$timeZone['id']){ echo 'selected="selected"';}?>><?php echo $timeZone['timezone']; ?></option>
                        <?php } ?>
                            </select>
                        </div>   
                    </li>
                     </ul>
                  </div>

                  <div class="MultiDates-ListItems">
                     <ul>
                        <li>
                           <label>Start Time</label>
                           <div class="input-group bootstrap-timepicker">
                              <input type="text" class="form-control eventFields" id="repeatingStartTime"  value="">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                           </div>
                        </li>
                        <li>
                           <label>End Time</label>
                           <div class="input-group bootstrap-timepicker">
                              <input type="text" class="form-control eventFields" id="repeatingEndTime"  value="">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                           </div>
                        </li>
                        <li>
                           <label>Of the</label>
                           <div class="TicketDropdownHolder">
                              <select id="repeatingTimeType" class="MultiSelectBox" >
                                 <option value="0">Same Day</option>
                                 <option value="1">Next Day</option>
                                 <option value="2">2nd day</option>
                                 <option value="3">3rd day</option>
                                 <option value="4">4th day</option>
                                 <option value="5">5th day</option>
                                 <option value="6">6th day</option>
                              </select>
                           </div>
                        </li>

                     </ul>
                  </div>



                  <div class="MultiDates-ListItems">
                     <p class="MultiDates-DatesInfo" id="multiDateSummary">  </p>
                  </div>

                  <div class="MultiDates-ListItems">
                     <button type="button" id="multiDateAdd" class="btn btn-default btn-md MultiDatesBtn">Add</button>
                     <button type="button" id="multiEventCancel" class="btn btn-default btn-md MultiDatesBtn">Cancel</button>
                  </div>

               </div>
               <!-- MultiDateEventsOpenContainer End -->
            <label for="multiEventError" class="error"></label>   
            </div> <!-- Multiple Date Events Open Container -->




            <!-- Multiple Date List View -->

            <div id="multiDateListContainer">
                <!-- Start Here -->    
            </div>
            


            <!-- Multiple Date List View -->


            <!-- Multiple Date Add More Btn -->

                <?php if( !(isset($eventId) && $eventId != '') ) { ?>
                <div class="form-group">
                    <button type="button" class="MultiDates-AddMoreDates" id="MultiDates-AddMoreDates">ADD MORE DATES</button>
                </div>
                <?php } ?>


            <!-- Multiple Date Add More Btn -->
 

              <!--  <span id="addMoretime" class="add_time">Add another time and date</span>-->

        </div>
            </div>
 
                                    <div id="div_ticketwidget">
                                        <h2 class="title_3 clearBoth">Tickets</h2>
                                        <?php if((isset($eventId) && $eventId != '')) { ?>
                                        <div class="form-group marginbottom10 displayinline">
                                            <label><input type="checkbox" id="soldOutAll">  
                                            <span class="h4">Sold Out For All Tickets</span></label>  
                                        </div>
                                        
                                        <div class="form-group marginbottom10 displayinline">
                                            <label><input type="checkbox" id="notToDisplayAll">
                                            <span class="h4">Not to Display for All Tickets</span></label>    
                                        </div>
                                        <?php } ?>

                                        <?php echo $ticketView; ?>

                                    </div> <!--Entire Ticket Div-->
                                    <div class="create_sub">
                                        <button type="button" id="addnewticket" class="addmoretickets btn btn-default btn-md gobtn createeventbuttons add_ticket">Add Ticket</button>
                                    </div>

                                    <div>
                                        <h2 class="title_2 clearBoth">Payment Gateway & Service Charge:</h2>
                                        <div class="form-group TicketDropdownHolder">
                                            <?php
                                                    $feeArr = $this->config->item('organizer_fees');
                                                ?>
                                                <select name="organiser_fee" <?php if (isset($transactionsCount) && $transactionsCount > 0) echo 'disabled="disabled" ';; ?>   > 
                                                    <option value='0' <?php if($organiser_fee == '') echo 'selected="selected"';;?>>Organiser Pay Both The Fees (3.99%+GST)</option>
                                                    <option value="gatewaycharge" <?php if($organiser_fee == 'gatewaycharge') echo 'selected="selected"';;?>>Pass Payment Gateway fee to Customer (1.99%+GST)</option>
                                                    <option value="servicecharge" <?php if($organiser_fee == 'servicecharge') echo 'selected="selected"';;?>>Pass Service Charge to Customer (2%+GST)</option>
                                                    <option value="both" <?php if($organiser_fee == 'both') echo 'selected="selected"';;?>>Customer Pay Both The Fees (3.99%+GST)</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="create_eve_tickets" id="ticketsalebtn">

                                        <h2 class="title_3">Change the Label <?php echo isset($eventDetails['bookButtonValue'])?$eventDetails['bookButtonValue']:'';?></h2>
                                        <ul class="sales">

                                            <li class="salesbtn">
                                                <div class="TicketDropdownHolder">  
                                                    
                                                    <select id="booknowButtonValue" name="booknowButtonValue">
                                                        <?php if(isset($saleButtonTitleList) && !empty($saleButtonTitleList)){
                                                                foreach ($saleButtonTitleList as $sBkey => $sBvalue) { ?>
                                                        <option value="<?php echo $sBvalue['name']?>" <?php if(isset($eventDetails['eventDetails']['bookButtonValue']) && $eventDetails['eventDetails']['bookButtonValue']==$sBvalue['name']){ ?> selected <?php }?>>
                                                                   <?php echo $sBvalue['name']?>
                                                        </option>
                                                     <?php      }
                                                        }?>
                                                    </select> 
                                                </div>
                                            </li> 
                                        </ul>
                                    </div>
                                    <div class="public_event">
                                        <label><input <?php if(isset($eventDetails['private']) && $eventDetails['private']==0){ ?>checked="checked"<?php } ?> type="radio" name="private" value="0"  id="private0">
                                        Public page:</label><span> do list this event publicly</span>
                                        <br>
                                        <label><input <?php if(isset($eventDetails['private']) && $eventDetails['private']==1){ ?>checked="checked"<?php } ?> type="radio" name="private" value="1"  id="private1">
                                        Private page:</label> <span>do not list this event publicly</span>
                                        <?php if((isset($eventId) && $eventId != '')) { ?>
                                        <div class="form-group marginbottom10 ">
                                            <label><input type="checkbox" id="hideDate" name="hideDate" value="<?php echo $eventDetails['eventSettingData']['eventdatehide']; ?>" <?php if($eventDetails['eventSettingData']['eventdatehide'] == 1){echo 'checked'; } ?>>  
                                            <span class="h4">Hide Event Date & Time in Event Detail Page</span></label>  
                                        </div>
                                        <div class="form-group marginbottom10 ">
                                            <label><input type="checkbox" id="hideVenue" name="hideVenue" value="<?php echo $eventDetails['eventSettingData']['eventlocationhide']; ?>" <?php if($eventDetails['eventSettingData']['eventlocationhide'] == 1){echo 'checked'; } ?>>  
                                            <span class="h4">Hide Event Venue in Event Detail Page</span></label>  
                                        </div>
                                        <div class="form-group marginbottom10 ">
                                            <label><input type="checkbox" id="hideSimilarEvents" name="hideSimilarEvents" value="<?php echo $eventDetails['eventSettingData']['similareventshide']; ?>" <?php if($eventDetails['eventSettingData']['similareventshide'] == 1){echo 'checked'; } ?>>  
                                            <span class="h4">Hide Similar events in Event Detail Page</span></label>  
                                        </div>
                                        <?php } ?>
                                    </div>
                                    
                                <!--<?php  if(isset($eventDetails['categoryId']) && in_array($eventDetails['categoryId'], $eventsnow_categories)){?>
                                    <div class="form-group" style="padding:20px 0 0 0;margin:0; " id="eventsaccpet">
                                <?php }else{?>
                                     <div class="form-group" style="padding:20px 0 0 0;margin:0;display:none;" id="eventsaccpet">
                                <?php }?>
                                        <label> <input style="float:left; margin:0 10px 0 0;" <?php if(isset($eventSettingDetails['standardapi']) && ($eventSettingDetails['standardapi']==1) ){ ?>checked="checked" value="1" <?php } elseif(isset($eventSettingDetails['standardapi']) && ($eventSettingDetails['standardapi']==0)){ ?> value="0" <?php }else{ ?> checked="checked" value="1" <?php } ?> type="checkbox" name="accepttoenow"  id="accepttoenow">
                                            <h5 style="font-size: 14px; margin-left:25px;"> I accept to move this event in Eventsnow.</h5> </label>
                                    </div>-->
                                    <div class="form-group" style="padding:20px 0 0 0;margin:0;">
                                        <label> <input style="float:left; margin:0 10px 0 0;" <?php if(isset($eventDetails['acceptmeeffortcommission']) && ($eventDetails['acceptmeeffortcommission']==1) ){ ?>checked="checked" value="1" <?php } elseif(isset($eventDetails['acceptmeeffortcommission']) && ($eventDetails['acceptmeeffortcommission']==0)){ ?> value="0" <?php }else{ ?> checked="checked" value="1" <?php } ?> type="checkbox" name="acceptmeeffortcommission"  id="acceptmeeffortcommission"> 
                                            <h5 style="font-size: 14px; margin-left:25px;"> I accept to pay additional 6% for all MeraEvents Efforts, MeraEvents Partners and Affiliate Marketing Efforts.</h5> </label>
                                    </div>

                                    <div class="form-group" style="padding:10px 0 0 0;margin: 0;">                                     
                                    <h5 style="font-size: 14px;margin-left:25px;line-height: normal;color: #777;">By clicking <b>Save & Exit or Go Live</b>, you agree to our <a href="<?php echo commonHelperGetPageUrl("terms"); ?>" target="_blank">Terms</a> and confirm that you have read our Data, Payment Policy, including our Cookie Use Policy. You may receive SMS message notifications from MeraEvents and can opt out at any time.
                                    </h5>
                                </div>
				<div class="form-group" style="padding:10px 0 0 0;margin: 0;">                                     
                                    <h5 style="font-size: 14px;margin-left:25px;line-height: normal;color: gray;">In case of Event Cancellation, a non-refundable fee of 4.71% will be charged by MeraEvents from the Organizer(s).</h5>
                                    <h5 style="font-size: 14px;margin-left:25px;line-height: normal;color: gray;">Payment Release/Transfer for the collected ticket amount towards your listed event will be done only after the completion of the event within 3-5 working days.</h5>
                                    <h5 style="font-size: 14px;margin-left:25px;line-height: normal;color: gray;">If ticket amount is less than 2000, MeraEvents will charge INR 25+Taxes to user as Booking Fees. </h5>
                                </div>
                            </div>
                            <!--End Step1--> 
                            </div>  
                        </div>
                        <div class="col-xs-12 col-md-4 design_event" >
                            <img src="bannerImageSrc" id="hiddenImg" style="display: none;">

                            <h2 class="title">Design your event</h2>
                            <div class="create-event-error">
                                <ul id="eventBannerErrors"></ul>
                            </div>
                            <div id="bannerImageDiv" class="upload" style="<?php if(isset($eventDetails['bannerPath']) && (empty($eventDetails['bannerPath']) || ($eventDetails['bannerPath'] == $this->config->item('images_content_cloud_path')))){ echo "background:".$eventDetails['categoryThemeColor'].";";}?>background-image: url('<?php echo isset($eventDetails['bannerPath'])?$eventDetails['bannerPath']:'';?>');background-repeat:no-repeat;background-size:300px 100px;">

                                <input type="file" name="bannerImage" id="bannerImage" class="unused"/>
                                <span class="upload_image" <?php echo $bannerPathMsg;?> ></span>
                                <span class="upload_image_text" <?php echo $bannerPathMsg;?> >Upload Header Image<br>1170 x 370px</span>
                                <div id="removeBanner" style="float:right; width:auto; text-align:right; padding:2px 5px 5px 5px;"> <i class="icon2-times-circle"></i></div>
                            </div>
                            
                            <div class="create-event-error">
                                <ul id="eventLogoErrors"></ul>
                            </div>	  
                            <div id="thumbImageDiv" class="Upload_Thumb" style="<?php if(isset($eventDetails['thumbnailPath']) && (empty($eventDetails['thumbnailPath']) || ($eventDetails['thumbnailPath'] == $this->config->item('images_content_cloud_path')))){ echo "background:".$eventDetails['categoryThemeColor'].";";}?>background-image: url(' <?php echo isset($eventDetails['thumbnailPath'])?$eventDetails['thumbnailPath']:'';?> ');background-repeat:no-repeat;background-size:178px 103px;">
                                <input type="file" name="thumbImage" id="thumbImage" class="unused2"/>
                                <span class="upload_image2 " <?php echo $thumbnailPathMsg;?> ></span>
                                <span class="upload_image_text2 " <?php echo $thumbnailPathMsg;?> >Upload Thumbnail<br>350x 200px</span>
                               <div id="removeThumb" style="float:right; width:auto; text-align:right; padding:2px 5px 5px 5px;"><i class="icon2-times-circle"></i></div>
                            </div>


                            <div class="theme_text">
                                <h4 >Don't have any image to upload?</h4>
                                <h5 >Select picture from our library to match
                                    your theme.</h5>
                                <button style="display: none;" type="button" class="btn btn-default btn-md pickbtn">PICK A THEME</button>
                            </div>
                            <div class="theme_images">
                                <h3>PICK AN IMAGE</h3>
                                <ul>
                                    <?php
                                    foreach ($pickThemeImages as $theme) {
                                        ?>      
                                        <li>
                                            <a href="javascript:void(0);"  class="clip-circle" >
                                                <div src="javascript:void(0);" class="sprite-icon <?php echo $theme['theam'];?>-short"
                                                    alt="<?php echo $theme['theam'];?>" title="<?php echo $theme['theam'];?>"
                                                    data-thumburl="<?php echo $theme['thumb']; ?>"
                                                    data-bannerurl="<?php echo $theme['banner']; ?>">
                                                </div>
                                            </a>
                                        </li>   
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>
                            <?php include_once('includes/elements/create_event_buttons.php'); ?>
                    </form>

                </div>
                <!-- wrap --> 
            </div>

<?php include("includes/event_header.php"); ?> 
        </div>
        <!-- wrap --> 
    </div>
    <!-- page-container --> 
    <!-- on scroll code-->
    <!-- for prieview-->
    <a href="javascript:void(0);" target="_blank" id="previewEventURL" style="display: none;">Preview</a>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?php echo $this->config->item('google_app_key');?>"></script>
<style>
    #MoreTaxes li { margin-right:10px; float:left; line-height:40px;}
    .TaxField_width {width:80px !important;}
</style>
<script>
    $('#hideDate').on('change', function () {
                this.value = this.checked ? 1 : 0;
            }).change();
    $('#hideVenue').on('change', function () {
                this.value = this.checked ? 1 : 0;
            }).change();
    $('#hideSimilarEvents').on('change', function () {
                this.value = this.checked ? 1 : 0;
            }).change();        
var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch')?>";
var api_countryDetails = "<?php echo commonHelperGetPageUrl('api_countryDetails')?>";
var api_ticketCalculateTaxes = "<?php echo commonHelperGetPageUrl('api_ticketCalculateTaxes')?>";
var api_checkUrlExists = "<?php echo commonHelperGetPageUrl('api_checkUrlExists')?>";
var api_stateSearch = "<?php echo commonHelperGetPageUrl('api_stateSearch')?>";
var api_subcategoryList = "<?php echo commonHelperGetPageUrl('api_subcategoryList')?>";
var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch')?>";
var api_citySearch = "<?php echo commonHelperGetPageUrl('api_citySearch')?>";
var api_ticketDelete = "<?php echo commonHelperGetPageUrl('api_ticketDelete')?>";
var api_eventCreate = "<?php echo commonHelperGetPageUrl('api_eventCreate')?>";
var api_eventEdit = "<?php echo commonHelperGetPageUrl('api_eventEdit')?>";
var api_tagsList = "<?php echo commonHelperGetPageUrl('api_tagsList')?>";
var maxMultiDate=<?php echo defined('MULTI_EVENT_CREATION_LIMIT') ? MULTI_EVENT_CREATION_LIMIT : 60;?>;
var eventSyncCategories = <?php echo EVENTS_SYNC_ORG_CUSTOM_EMAIL;?>
</script>
<?php if (isset($eventId)) { ?>
    <script>
        var eventstartDate = '<?php echo $eventDetails['convertedStartDate'] ?>';
        var eventstartTime = '<?php echo $eventDetails['convertedStartTime'] ?>';
        var eventEndDate = '<?php echo $eventDetails['convertedEndDate'] ?>';
        var eventEndTime = '<?php echo $eventDetails['convertedEndTime'] ?>';
        var eventStatus = '<?php echo $eventDetails['status'] ?>';
		var deleteAllTicketsMessage='<?php echo MESSAGE_DELETE_ALL_TICKETS; ?>';
		var defaultCurrencyId='<?php echo $defaultCurrencyId;?>'
    </script>   
<?php } ?>
 
<script type="text/javascript">
    window.onload = function (e) {
        extendMoment(moment);    
        if($('#isParentEvent').val() == 1){
            generateMultiEventArrFromJson();
        }
    }
    
</script>