<style type="text/css">
    .formErrors {
        padding: 10px 15px;
        width: auto;
        background: #fdeded;
        border: 1px solid #ffd3d3;
        margin: 10px 0 20px 0;
        max-width: 600px;
        color: #cc4747;
    }
</style>
<div class="rightArea">
    <div class="heading">
        <h2>Add / Edit Recurring Plan : <span><?php echo $eventName; ?></span></h2>
    </div>
    <?php //For all the errors of server side validations
    if (isset($addRecurringPlanOutput) && !$addRecurringPlanOutput['status']) {
    ?>
    <div class="db-alert db-alert-danger flashHide">
        <strong><?php print_r($addRecurringPlanOutput['response']['messages'][0]); ?></strong> 
    </div>  
<?php } ?>
    <div class="editFields fs-add-discount-box">
        <form name="addRecurringPlanForm" method='post' action='' id='addRecurringPlanForm' @submit="checkRecurringPlanForm">
            <p v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul class="formErrors" v-if="errors.length">
                  <li v-for="error in errors">{{ error }}</li>
                </ul>
            </p>
            <label>Plane Name <span class="mandatory">*</span></label>                                                                                                                           
            <input type="text" class="textfield" id="planName" name="planName" v-model="planName">
            
            <label>Plan Code<span class="mandatory">*</span></label>
            <input type="text" class="textfield" id="planCode" name="planCode" v-model="planCode" >
            <div id='codeError' class='error'></div>
             
            <label>Plan Currency <span class="mandatory">*</span></label>
            <div class="valid_date valid_bottom">
                <ul>
                    <li> 
                        <label><input type="radio" name="planCurrency" v-model="planCurrency" value="10" checked="checked"> GBP </label></li>                    
                
                </ul>
            </div>
            <div class="clearBoth height10"></div>
            <label style="float:left;">Plan Price <span class="mandatory">*</span> <span class="suggestiontext-g">(Enter the plan value here. For ex.200 for 200 EURO)</span> </label>
            <input type="text" class="textfield" id="planPrice" name="planPrice" v-model="planPrice" >

            <label>Description <span class="mandatory">*</span> <span class="suggestiontext-g"></span> </label>
            <input type="textbox" class="textfield" id="planDescription" name="planDescription" v-model="planDescription" >
            <div class="clearBoth height10"></div>

            <label>Status<span class="mandatory">*</span></label>
            <div class="valid_date valid_bottom">
                <ul>
                    <li> 
                        <label><input type="radio" name="planStatus" v-model="planStatus" value="1" >Active</label></li>
                        <label><input type="radio" name="planStatus" v-model="planStatus" value="0" >Inactive</label></li>                    
                
                </ul>
            </div>
            <div class="clearBoth height10"></div>

            <div class="btn-holder float-right">
                <input type="submit" name="planSubmit" class="createBtn" id="planSubmit" value='<?php echo $edit == 1 ? "Update": "Save"?>'>
                <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-listplans'); ?>" class="saveBtn"><span ></span>Cancel</a>
            </div>            
        </form>
    </div>
</div>

<script type="text/javascript">
    window.onload = function(e){
        const app = new Vue({
          el:'#addRecurringPlanForm',
          data:{
            errors:[],
            planName:<?php echo ($planData['name']) ? '"'.$planData['name'].'"' : 'null';?>,
            planCode:<?php echo ($planData['code']) ? '"'.$planData['code'].'"' : 'null';?>,
            planCurrency:<?php echo ($planData['currencyid']) ? '"'.$planData['currencyid'].'"' : 10;?>,
            planPrice:<?php echo ($planData['price']) ? '"'.$planData['price'].'"' : 'null';?>,
            planDescription:<?php echo ($planData['description']) ? '"'.$planData['description'].'"' : 'null';?>,
            planStatus:<?php echo (isset($planData['status']) && $planData['status'] == 0) ? 0 : '1';?>
          },
          methods:{
            checkRecurringPlanForm:function(e) {
              if(this.planName && this.planCode && this.planCurrency && this.planPrice && !isNaN(this.planPrice) && this.planDescription && this.planStatus) 
              if(this.planDescription !=null) return (this.planDescription.length < 250) ?  true : false;
              this.errors = [];
              if(!this.planName) this.errors.push("Please Enter a Name.");
              if(!this.planCode) this.errors.push("Please Enter a Code.");
              if(!this.planCurrency) this.errors.push("Please select Currency.");
              if(!this.planPrice) this.errors.push("Please Enter a valid price.");
              if(isNaN(this.planPrice)) this.errors.push("Please Enter a valid price.");
              if(!this.planDescription) this.errors.push("Please Enter a Description.");
              else if(this.planDescription.length > 255) this.errors.push("Please enter less than 250 characters for Description.");
              if(!this.planStatus) this.errors.push("Please select the status.");
              e.preventDefault();
            }
          }
        })    
    }
    
</script>