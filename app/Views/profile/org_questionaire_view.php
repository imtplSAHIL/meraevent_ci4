<style>
    .error{
        color: #FB1919 !Important;
    }
    .editFields span.icon-downarrow {
    right: 0px;
    position: absolute;
    top: 64%;
}
</style>
<div class="rightArea">
   <?php 
   $promoterFlashErrorMessage = $this->customsession->getData('promoterFlashErrorMessage');
   $this->customsession->unSetData('promoterFlashErrorMessage');
   ?>
    <?php if($promoterFlashErrorMessage){ ?>
    <div   class="db-alert db-alert-success flashHide" ><?php echo $promoterFlashErrorMessage; ?></div>
    <?php } ?>
    <?php if($this->session->flashdata('message')){ ?>
    <div class="db-alert db-alert-danger"><?php echo $this->session->flashdata('message'); ?></div>
    <?php } ?>
    
    <div class="heading">
        <h2>Organizer Evaluation:</h2>
    </div>
    <div class="editFields fs-add-promoter-form">
        <form name='orgEvaluationForm' method='post' action='' id='orgEvaluationForm'>
            <label>Please mention your location <span class="mandatory">*</span></label>
            <input type="hidden" class="textfield" name='id' id='id' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['id'] : ''; ?>">
            <input type="text" class="textfield localityAutoComplete" placeholder="Enter your location" name='location' id='locality' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['location'] : ''; ?>">
            <label>How many events do you organize in a calendar year <span class="mandatory">*</span></label>
            <label><span style="top:15px;" class="float-left icon-downarrow"></span></label>
            <select name="org_year_events" id="org_year_events">
                <option value="">Select</option>
                <option value="Upto 4 events" <?php if($orgEvaluationdata[0]['org_year_events'] == 'Upto 4 events'){ echo 'selected';} ?>>Upto 4 events</option>
                <option value="5-12 events" <?php if($orgEvaluationdata[0]['org_year_events'] == '5-12 events'){ echo 'selected';} ?>>5-12 events</option>
                <option value="13-25 events" <?php if($orgEvaluationdata[0]['org_year_events'] == '13-25 events'){ echo 'selected';} ?>>13-25 events</option>
                <option value="Above 25 events" <?php if($orgEvaluationdata[0]['org_year_events'] == 'Above 25 events'){ echo 'selected';} ?>>Above 25 events</option>
            </select>
            <br/>
            <label>What categories of events do you organize <span class="mandatory">*</span></label>
            <label><input type="checkbox" name='cat_type[]' id='checkbox' value="Conferences/Seminar" <?php echo in_array('Conferences/Seminar', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?>>Conferences/Seminar</label>
            <label><input type="checkbox" name='cat_type[]' id='checkbox' value="Entertainment/Live Concerts/ Night Life/Lifestyle" <?php echo in_array('Entertainment/Live Concerts/ Night Life/Lifestyle', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?>>Entertainment/Live Concerts/ Night Life/Lifestyle</label>
            <label><input type="checkbox" name='cat_type[]' id='checkbox' value="Sports/Marathons/Running/Cycling" <?php echo in_array('Sports/Marathons/Running/Cycling', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?>>Sports/Marathons/Running/Cycling</label>
            <label><input type="checkbox" name='cat_type[]' id='checkbox' value="Training/Workshops" <?php echo in_array('Training/Workshops', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?>>Training/Workshops</label>
            <label><input type="checkbox" name='cat_type[]' id='checkbox' value="Spiritual & Wellness" <?php echo in_array('Spiritual & Wellness', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?>>Spiritual & Wellness</label>
            <label><input type="checkbox" name='cat_type[]' id='checkbox' value="Campus/College/School events" <?php echo in_array('Campus/College/School events', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?>>Campus/College/School events</label>
            <label><input type="checkbox" name='cat_type[]' id='checkbox' value="Tradeshows/Expos" <?php echo in_array('Tradeshows/Expos', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?>>Tradeshows/Expos</label>
            <label><input type="checkbox" name='cat_type[]' id='checkbox' value="Activities/Trekking/Hiking/Camping/Adventure" <?php echo in_array('Activities/Trekking/Hiking/Camping/Adventure', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?>>Activities/Trekking/Hiking/Camping/Adventure</label>
            <label><input type="checkbox" name='cat_type[]' id="other_category" onclick="valueChanged()" value="Other" <?php echo in_array('Other', explode(",", $orgEvaluationdata[0]["cat_type"])) ? 'checked' : ''; ?> >Other</label>
            <label><input type="text" name="other_cat_type" class="textfield" id ="other_category_text" value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['other_cat_type'] : ''; ?>" style="display:none;" /></label>
            <br/>
            <label>Avg number of attendees per event <span class="mandatory">*</span></label>
                        <label><span style="top:15px;" class="float-left icon-downarrow"></span></label>
            <select name="avg_attendees">
                <option value="">Select</option>
                <option value="Upto 100" <?php if($orgEvaluationdata[0]['avg_attendees'] == 'Upto 100'){ echo 'selected';} ?>>Upto 100</option>
                <option value="100-500" <?php if($orgEvaluationdata[0]['avg_attendees'] == '100-500'){ echo 'selected';} ?>>100-500</option>
                <option value="500-1000" <?php if($orgEvaluationdata[0]['avg_attendees'] == '500-1000'){ echo 'selected';} ?>>500-1000</option>
                <option value="1000-5000" <?php if($orgEvaluationdata[0]['avg_attendees'] == '1000-5000'){ echo 'selected';} ?>>1000-5000</option>
                <option value="Above 5000" <?php if($orgEvaluationdata[0]['avg_attendees'] == 'Above 5000'){ echo 'selected';} ?>>Above 5000</option>
            </select>
            <label>Average ticket price per event <span class="mandatory">*</span></label>
                        <label><span style="top:15px;" class="float-left icon-downarrow"></span></label>
            <select name="avg_price">
                <option value="">Select</option>
                <option value="Upto 100"  <?php if($orgEvaluationdata[0]['avg_price'] == 'Upto 100'){ echo 'selected';} ?>>Upto 100</option>
                <option value="100-500"  <?php if($orgEvaluationdata[0]['avg_price'] == '100-500'){ echo 'selected';} ?>>100-500</option>
                <option value="500-1000"  <?php if($orgEvaluationdata[0]['avg_price'] == '500-1000'){ echo 'selected';} ?>>500-1000</option>
                <option value="1000-5000"  <?php if($orgEvaluationdata[0]['avg_price'] == '1000-5000'){ echo 'selected';} ?>>1000-5000</option>
                <option value="Above 5000"  <?php if($orgEvaluationdata[0]['avg_price'] == 'Above 5000'){ echo 'selected';} ?>>Above 5000</option>
            </select>
            <label>Are you using your website for selling tickets (If yes please list your website)  <span class="mandatory">*</span></label>
                        <label><span style="top:15px;" class="float-left icon-downarrow"></span></label>
            <select name="org_website" id="org_website">
                <option value="">Select</option>
                <option value="Yes" <?php if($orgEvaluationdata[0]['org_website'] == 'Yes'){ echo 'selected';} ?>>Yes</option>
                <option value="No" <?php if($orgEvaluationdata[0]['org_website'] == 'No'){ echo 'selected';} ?>>No</option>
            </select>
                        <label style="display: none;" id='id_other_org_website'>Please enter your website for selling tickets</label>
            <input type="text" class="textfield" name='other_org_website' id='other_org_website' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['other_org_website'] : ''; ?>" style="display:none;">

            <label>How many events have you done in the past <span class="mandatory">*</span></label>
                        <label><span style="top:15px;" class="float-left icon-downarrow"></span></label>

            <select name="avg_events">
                <option value="">Select</option>
                <option value="None" <?php if($orgEvaluationdata[0]['avg_events'] == 'None'){ echo 'selected';} ?>>None</option>
                <option value="Less than 10" <?php if($orgEvaluationdata[0]['avg_events'] == 'Less than 10'){ echo 'selected';} ?>>Less than 10</option>
                <option value="10-50" <?php if($orgEvaluationdata[0]['avg_events'] == '10-50'){ echo 'selected';} ?>>10-50</option>
                <option value="50-100" <?php if($orgEvaluationdata[0]['avg_events'] == '50-100'){ echo 'selected';} ?>>50-100</option>
                <option value="Above 100" <?php if($orgEvaluationdata[0]['avg_events'] == 'Above 100'){ echo 'selected';} ?>>Above 100</option>
            </select>
            <label>Are you using any existing payment gateway/ticketing platforms( if yes, please list out) * <span class="mandatory">*</span></label>
            <label><span style="top:15px;" class="float-left icon-downarrow"></span></label>
            <select name="ticketing_platform" id="ticketing_platform">
                <option value="">Select</option>
                <option value="Yes" <?php if($orgEvaluationdata[0]['ticketing_platform'] == 'Yes'){ echo 'selected';} ?>>Yes</option>
                <option value="No" <?php if($orgEvaluationdata[0]['ticketing_platform'] == 'No'){ echo 'selected';} ?>>No</option>
            </select>
            <label style="display: none;" id='id_other_ticketing_platform'>Please enter other ticketing platfrom</label>
            <input type="text" class="textfield" name='other_ticketing_platform' id='other_ticketing_platform' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['other_ticketing_platform'] : ''; ?>" style="display:none;">

            <label>Your expectation from MeraEvents <span class="mandatory">*</span></label>
            <label><input type="checkbox" name='org_expectations[]' id='checkbox' value="Seamless payment gateway" <?php echo in_array('Seamless payment gateway', explode(",", $orgEvaluationdata[0]["org_expectations"])) ? 'checked' : ''; ?>>Seamless payment gateway</label>
            <label><input type="checkbox" name='org_expectations[]' id='checkbox' value="Best in class Customer Support" <?php echo in_array('Best in class Customer Support', explode(",", $orgEvaluationdata[0]["org_expectations"])) ? 'checked' : ''; ?>>Best in class Customer Support</label>
            <label><input type="checkbox" name='org_expectations[]' id='checkbox' value="Increasing ticket sales" <?php echo in_array('Increasing ticket sales', explode(",", $orgEvaluationdata[0]["org_expectations"])) ? 'checked' : ''; ?>>Increasing ticket sales</label>
            <label><input type="checkbox" name='org_expectations[]' id='checkbox' value="Management of event day registration" <?php echo in_array('Management of event day registration', explode(",", $orgEvaluationdata[0]["org_expectations"])) ? 'checked' : ''; ?>>Management of event day registration</label>
            <label><input type="checkbox" name='org_expectations[]' id='checkbox' value="End to end event management technology" <?php echo in_array('End to end event management technology', explode(",", $orgEvaluationdata[0]["org_expectations"])) ? 'checked' : ''; ?>>End to end event management technology</label>
            <label><input type="checkbox" name='org_expectations[]' id='org_expectations' onclick="valueChange()" value="Other" <?php echo in_array('Other', explode(",", $orgEvaluationdata[0]["org_expectations"])) ? 'checked' : ''; ?>>Other</label>
            <input type="text" name="other_meraevents_expectations" class="textfield" id ="other_meraevents_expectations" value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['other_meraevents_expectations'] : ''; ?>" style="display:none;" />

            <h3>Social Media Details</h3>
            <label>Currently which mediums do you use for your event promotion <span class="mandatory">*</span></label>
            <label><input type="checkbox" name='org_promotion[]' id='checkbox' value="Digital Marketing" <?php echo in_array('Digital Marketing', explode(",", $orgEvaluationdata[0]["org_promotion"])) ? 'checked' : ''; ?>>Digital Marketing</label>
            <label><input type="checkbox" name='org_promotion[]' id='checkbox' value="Outdoor Hoardings" <?php echo in_array('Outdoor Hoardings', explode(",", $orgEvaluationdata[0]["org_promotion"])) ? 'checked' : ''; ?>>Outdoor Hoardings</label>
            <label><input type="checkbox" name='org_promotion[]' id='checkbox' value="Radio ads" <?php echo in_array('Radio ads', explode(",", $orgEvaluationdata[0]["org_promotion"])) ? 'checked' : ''; ?>>Radio ads</label>
            <label><input type="checkbox" name='org_promotion[]' id='checkbox' value="Newspaper ads" <?php echo in_array('Newspaper ads', explode(",", $orgEvaluationdata[0]["org_promotion"])) ? 'checked' : ''; ?>>Newspaper ads</label>
            <label><input type="checkbox" name='org_promotion[]' id='checkbox' value="TV ads" <?php echo in_array('TV ads', explode(",", $orgEvaluationdata[0]["org_promotion"])) ? 'checked' : ''; ?>>TV ads</label>
            <label><input type="checkbox" name='org_promotion[]' id='other_socialmedia' onclick="valueChanges()" value="Other" <?php echo in_array('Other', explode(",", $orgEvaluationdata[0]["org_promotion"])) ? 'checked' : ''; ?>>Other</label>
            <input type="text" name="other_social_media" class="textfield" id ="other_social_media" value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['other_social_media'] : ''; ?>" style="display:none;" />
            
            <label>Which channels you use mainly for Marketing <span class="mandatory">*</span></label>
            <label><input type="checkbox" name='org_marketing[]' id='checkbox' value="Facebook" <?php echo in_array('Facebook', explode(",", $orgEvaluationdata[0]["org_marketing"])) ? 'checked' : ''; ?>>Facebook</label>
            <label><input type="checkbox" name='org_marketing[]' id='checkbox' value="Twitter" <?php echo in_array('Twitter', explode(",", $orgEvaluationdata[0]["org_marketing"])) ? 'checked' : ''; ?>>Twitter</label>
            <label><input type="checkbox" name='org_marketing[]' id='checkbox' value="LinkedIn" <?php echo in_array('LinkedIn', explode(",", $orgEvaluationdata[0]["org_marketing"])) ? 'checked' : ''; ?>>LinkedIn</label>
            <label><input type="checkbox" name='org_marketing[]' id='checkbox' value="Instagram" <?php echo in_array('Instagram', explode(",", $orgEvaluationdata[0]["org_marketing"])) ? 'checked' : ''; ?>>Instagram</label>
            <label><input type="checkbox" name='org_marketing[]' id='checkbox' value="Youtube" <?php echo in_array('Youtube', explode(",", $orgEvaluationdata[0]["org_marketing"])) ? 'checked' : ''; ?>>Youtube</label>
            <label><input type="checkbox" name='org_marketing[]' id='checkbox' value="Google" <?php echo in_array('Google', explode(",", $orgEvaluationdata[0]["org_marketing"])) ? 'checked' : ''; ?>>Google</label>
            <label><input type="checkbox" name='org_marketing[]' id='checkbox' value="Email" <?php echo in_array('Email', explode(",", $orgEvaluationdata[0]["org_marketing"])) ? 'checked' : ''; ?>>Email</label>
            <label><input type="checkbox" name='org_marketing[]' id='checkbox' value="SMS" <?php echo in_array('SMS', explode(",", $orgEvaluationdata[0]["org_marketing"])) ? 'checked' : ''; ?>>SMS</label>

            <label>Please share your Facebook fanpage url <span class="mandatory"></span></label>
            <input type="text" class="textfield" name='fb_url' id='fb_url' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['fb_url'] : ''; ?>">
            
            <label>Please share your Twitter handle <span class="mandatory"></span></label>
            <input type="text" class="textfield" name='twitter_url' id='twitter_url' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['twitter_url'] : ''; ?>">
            
            <label>Please share your Instagram handle <span class="mandatory"></span></label>
            <input type="text" class="textfield" name='insta_url' id='insta_url' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['insta_url'] : ''; ?>">
            
            <label>Please share your LinkedIn page url <span class="mandatory" ></span></label>
            <input type="text" class="textfield" name='linkedin_url' id='linkedin_url' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['linkedin_url'] : ''; ?>">
            
            <h2>Event promotion</h2>
            <br>
            <label>Are you interested in additional promotion from MeraEvents <span class="mandatory">*</span></label>
            <select name="meraevents_promotion" id="meraevents_promotion">
                <option value="">Select</option>
                <option value="Yes" <?php if($orgEvaluationdata[0]['meraevents_promotion'] == 'Yes'){ echo 'selected';} ?>>Yes</option>
                <option value="No" <?php if($orgEvaluationdata[0]['meraevents_promotion'] == 'No'){ echo 'selected';} ?>>No</option>
            </select>
            
            <label id="id_meraevents_promotion_plan" style="display:none;">What is the amount you plan to spend for Event promotion <span class="mandatory">*</span></label>
                        <label><span style="top:15px; display: none;" class="float-left icon-downarrows"></span></label>
            <select name="meraevents_promotion_plan" id="meraevents_promotion_plan" style="display:none;">
                <option value="">Select</option>
                <option value="No Marketing Budget" <?php if($orgEvaluationdata[0]['meraevents_promotion_plan'] == 'No Marketing Budget'){ echo 'selected';} ?>>No Marketing Budget</option>
                <option value="Less than Rs.10,000" <?php if($orgEvaluationdata[0]['meraevents_promotion_plan'] == 'Less than Rs.10,000'){ echo 'selected';} ?>>Less than Rs.10,000</option>
                <option value="Rs.10,000-Rs.50,000" <?php if($orgEvaluationdata[0]['meraevents_promotion_plan'] == 'Rs.10,000-Rs.50,000'){ echo 'selected';} ?>>Rs.10,000-Rs.50,000</option>
                <option value="Above Rs.1,00,000" <?php if($orgEvaluationdata[0]['meraevents_promotion_plan'] == 'Above Rs.1,00,000'){ echo 'selected';} ?>>Above Rs.1,00,000</option>

            </select>
            
            <label>Do you have internal marketing team for promoting your event  <span class="mandatory">*</span></label>
                        <label><span style="top:15px;" class="float-left icon-downarrow"></span></label>
            <select name="internal_marketing">
                <option value="">Select</option>
                <option value="Yes" <?php if($orgEvaluationdata[0]['internal_marketing'] == 'Yes'){ echo 'selected';} ?>>Yes</option>
                <option value="No" <?php if($orgEvaluationdata[0]['internal_marketing'] == 'No'){ echo 'selected';} ?>>No</option>
            </select>
            
            <label>Do you take support from any external Marketing/Digital Agency for promoting your event( If yes, please list out name of the company) <span class="mandatory"></span></label>
            <label><span style="top:15px;" class="float-left icon-downarrow"></span></label>
            <select name="ext_marketing" id="ext_marketing">
                <option value="">Select</option>
                <option value="Yes" <?php if($orgEvaluationdata[0]['ext_marketing'] == 'Yes'){ echo 'selected';} ?>>Yes</option>
                <option value="No" <?php if($orgEvaluationdata[0]['ext_marketing'] == 'No'){ echo 'selected';} ?>>No</option>
            </select>
            <label style="display: none;" id='id_ext_marketing'>Please enter external Marketing/Digital Agency for promoting your event</label>
            <input type="text" class="textfield" name='other_ext_marketing' id='other_ext_marketing' value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['other_ext_marketing'] : ''; ?>" style="display:none;">

            <label>Any other comments <span class="mandatory"></span></label>
            <input type="text" class="textfield" name='comments' id='comments'  value="<?php echo isset($orgEvaluationdata) ? $orgEvaluationdata[0]['comments'] : ''; ?>">
            <div id='codeError' class='error' ></div>
            <div class="clearBoth"></div>
            <div class="btn-holder float-right">
                <input name="submit" type="submit" id="org_Btn" class="createBtn" value="Save">
                <a href="<?php echo commonHelperGetPageUrl("dashboard-myevent"); ?>">
                    <span class="saveBtn">Cancel</span> 
                </a>
            </div>
        </form>
    </div>         
    </div>

<script>
    $cbx_group = $("input:checkbox[name='cat_type[]']");
    $cbx_group.prop('required', true);
if($cbx_group.is(":checked")){
  $cbx_group.prop('required', false);
}

$cbx_groups = $("input:checkbox[name='org_expectations[]']");
    $cbx_groups.prop('required', true);
if($cbx_groups.is(":checked")){
  $cbx_groups.prop('required', false);
}

$cbx_group_data = $("input:checkbox[name='org_promotion[]']");
    $cbx_group_data.prop('required', true);
if($cbx_group_data.is(":checked")){
  $cbx_group_data.prop('required', false);
}

$cbx_group_datas = $("input:checkbox[name='org_marketing[]']");
    $cbx_group_datas.prop('required', true);
if($cbx_group_datas.is(":checked")){
  $cbx_group_datas.prop('required', false);
}



$('#orgEvaluationForm').validate({
    rules: {
        location: {
            required: true,
            maxlength: 100
        },
        org_year_events: {
            required: true
        },
        avg_attendees: {
            required: true,
        },
        avg_price: {
            required: true
        },
        org_website: {
            required: true
        },
        avg_events: {
            required: true
        },
        ticketing_platform: {
            required: true
        },
        meraevents_promotion: {
            required: true
        },
        internal_marketing: {
            required: true
        }
    },
    messages: {
        location: {
            required: "This field is required",
            maxlength: "Please enter not more than 100 characters"
        },
        org_year_events: {
            required: "This field is required"
        },
        avg_attendees: {
            required: "This field is required"
        },
        avg_price: {
            required: "This field is required"
        },
        org_website: {
            required: "This field is required"
        },
        avg_events: {
            required: "This field is required"
        },
        ticketing_platform: {
            required: "This field is required"
        },
        "cat_type[]": {
            required: "This field is required"
        },
        "org_expectations[]": {
            required: "This field is required"
        },
        "org_promotion[]": {
            required: "This field is required"
        },
        "org_promotion[]": {
            required: "This field is required"
        },
        "org_marketing[]": {
            required: "This field is required"
        },
        meraevents_promotion: {
            required: "This field is required"
        },
        internal_marketing: {
            required: "This field is required"
        }
    },
    
    
    errorPlacement: function (error, element) {
        if (element.attr("type") == 'checkbox') {
            error.insertBefore(element.parent());
        } else if (element.attr("type") == 'radio') {
            error.insertBefore(element.parent());
        } else{
            error.insertBefore(element);
        }
    }
    
    });
    
    function valueChanged()
    {
        if($('#other_category').is(":checked"))   
            $("#other_category_text").show();
        else
            $("#other_category_text").hide();
    }
    function valueChange()
    {
        if($('#org_expectations').is(":checked"))   
            $("#other_meraevents_expectations").show();
        else
            $("#other_meraevents_expectations").hide();
    }
    function valueChanges()
    {
        if($('#other_socialmedia').is(":checked"))   
            $("#other_social_media").show();
        else
            $("#other_social_media").hide();
    }
    $(document).ready(function() {
        if($('#other_socialmedia').is(":checked"))   
            $("#other_social_media").show();
        if($('#org_expectations').is(":checked"))   
            $("#other_meraevents_expectations").show();
        if($('#other_category').is(":checked"))   
            $("#other_category_text").show();
        if($('#org_website').val() === 'Yes'){
            $("#id_other_org_website").show();
            $("#other_org_website").show();
        }
        if($('#ticketing_platform').val() === 'Yes'){
            $("#id_other_ticketing_platform").show();
            $("#other_ticketing_platform").show();
        }
        if($('#meraevents_promotion').val() === 'Yes'){
            $("#id_meraevents_promotion_plan").show();
            $("#meraevents_promotion_plan").show();
        }
        if($('#ext_marketing').val() === 'Yes'){
            $("#id_other_ext_marketing").show();
            $("#other_ext_marketing").show();
        }
    });
    
    $('#org_website').change(function(){
        var org_web = $('#org_website').val();
        if (org_web==='Yes'){
            document.getElementById('id_other_org_website').style.display='block';
       document.getElementById('other_org_website').style.display='block';
   }else{
       document.getElementById('id_other_org_website').style.display='none';
       document.getElementById('other_org_website').style.display='none';
   }
   });
   $('#ticketing_platform').change(function(){
        var other_tkt_platform = $('#ticketing_platform').val();
        if (other_tkt_platform==='Yes'){
            document.getElementById('id_other_ticketing_platform').style.display='block';
       document.getElementById('other_ticketing_platform').style.display='block';
   }else{
       document.getElementById('id_other_ticketing_platform').style.display='none';
       document.getElementById('other_ticketing_platform').style.display='none';
   }
   });
   $('#ext_marketing').change(function(){
        var other_ext_marketing = $('#ext_marketing').val();
        if (other_ext_marketing ==='Yes'){
            document.getElementById('id_ext_marketing').style.display='block';
       document.getElementById('other_ext_marketing').style.display='block';
   }else{
       document.getElementById('id_ext_marketing').style.display='none';
       document.getElementById('other_ext_marketing').style.display='none';
   }
   });
   $('#meraevents_promotion').change(function(){
        var meraevents_promotion = $('#meraevents_promotion').val();
        if (meraevents_promotion ==='Yes'){
            document.getElementById('id_meraevents_promotion_plan').style.display='block';
       document.getElementById('meraevents_promotion_plan').style.display='block';
   }else{
       document.getElementById('id_meraevents_promotion_plan').style.display='none';
       document.getElementById('meraevents_promotion_plan').style.display='none';
   }
   });
</script>


    