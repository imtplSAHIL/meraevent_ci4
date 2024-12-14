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
        <h2>Add / Edit Recurring Subscription </h2>
    </div>
    <?php //For all the errors of server side validations
    if ($this->customsession->getData('subFlashMessage')) {
    ?>
    <div class="db-alert db-alert-danger flashHide">
        <strong><?php echo $this->customsession->getData('subFlashMessage') ?></strong> 
    </div>  
<?php $this->customsession->unSetData('subFlashMessage'); } ?>
    <div class="editFields fs-add-discount-box">
        <form name='addRecurringSubscriptionForm' method='post' action='' id='addRecurringSubscriptionForm'  @submit="checkRecurringSubscription">
            <p v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul class="formErrors" v-if="errors.length">
                  <li v-for="error in errors">{{ error }}</li>
                </ul>
            </p>
            <label>Collect <span class="mandatory">*</span></label>
            <div class="valid_date valid_bottom">
                <ul>
                    <li> 
                        <label><input type="radio" name="periodType" v-model="periodType" value="1" checked="checked" <?php echo ($subStarted) ? "disabled" : ""?>> Daily </label>
                        <label><input type="radio" name="periodType" v-model="periodType" value="2" <?php echo ($subStarted) ? "disabled" : ""?>> Monthly </label>
                        <label><input type="radio" name="periodType" v-model="periodType" value="3" <?php echo ($subStarted) ? "disabled" : ""?>> Yearly </label>
                    </li>                    
                </ul>
            </div>
            <div class="clearBoth height10"></div>
            <label>Customer <span class="mandatory">*</span></label>
            <label>
                <span style="top:10px;" class="float-left icon-downarrow"></span>
                <select id="recurringpaymentuserid" name="recurringpaymentuserid" v-model="recurringpaymentuserid" <?php echo ($subStarted) ? "disabled" : ""?>>
                    <option value="">Select Customer</option>
                    <?php for ($i=0; $i <count($users) ; $i++ ) { 
                        echo "<option value=".$users[$i]['id'].">".$users[$i]['firstname'].' '.$users[$i]['lastname']."</option>";
                    } ?>
                </select>
            </label>
            
            <label>Plan <span class="mandatory">*</span></label>
            <label>
                <span style="top:10px;" class="float-left icon-downarrow"></span>
                <select id="planid" name="planid" v-model="planid" <?php echo ($subStarted) ? "disabled" : ""?>>
                    <option value="">Select Plan</option>
                    <?php for ($i=0; $i <count($plans) ; $i++ ) { 
                        echo "<option value=".$plans[$i]['id'].">".$plans[$i]['name']."</option>";
                    } ?>
                </select>
            </label>

            <div class="discountDateClass">
                <ul>
                    <li>
                        <label>Valid From (dd/mm/yyyy)<span class="mandatory">*</span></label>
                        <input type="text" class="textfield" id="subscriptionStartDate" name="subscriptionStartDate" v-model="subscriptionStartDate" <?php echo ($subStarted) ? "disabled" : ""?>>  
                    </li>
                </ul>
            </div>
            <div class="discountDateClass">
                <ul>
                    <li>
                        <label>Valid Till (dd/mm/yyyy)<span class="mandatory">*</span></label>
                        <input type="text" class="textfield" id="subscriptionEndDate" name="subscriptionEndDate" v-model="subscriptionEndDate" >  
                    </li>
                </ul>
            </div>
            <div class="clearBoth height10"></div>

            <label>Status<span class="mandatory">*</span></label>
            <div class="valid_date valid_bottom">
                <ul>
                    <li> 
                        <label><input type="radio" name="subscriptionStatus" v-model="subscriptionStatus" value="1" >Active</label></li>
                        <label><input type="radio" name="subscriptionStatus" v-model="subscriptionStatus" value="0" >Inactive</label></li>                    
                
                </ul>
            </div>
            <div class="clearBoth height10"></div>

            <div class="btn-holder float-right">
                <input type="submit" name='subscriptionSubmit' class="createBtn" id="subscriptionSubmit" value='<?php echo ($edit==1)? "Update": "Save"?>'>
                <a href="<?php echo commonHelperGetPageUrl('dashboard-recurring-listsubscription'); ?>" class="saveBtn"><span ></span>Cancel</a>
            </div>            
        </form>
    </div>
</div>
<script type="text/javascript">
    window.onload = function(e){
        const app = new Vue({
          el:'#addRecurringSubscriptionForm',
          data:{
            errors:[],
            periodType:<?php echo ($subData['periodtype']) ? $subData['periodtype'] : 1;?>,
            recurringpaymentuserid:"<?php echo ($subData['recurringpaymentuserid']) ? $subData['recurringpaymentuserid'] : '';?>",
            planid:"<?php echo ($subData['planid']) ? $subData['planid'] : '';?>",
            subscriptionStartDate:<?php echo ($subData['startdate']) ? '"'.$subData['startdate'].'"' : 'null';?>,
            subscriptionEndDate:<?php echo ($subData['enddate']) ? '"'.$subData['enddate'].'"' : 'null';?>,
            subscriptionStatus:<?php echo (isset($subData['status']) && $subData['status'] == 0) ? 0 : '1';?>
          },
          mounted: function() {
              var self = this;
              $('#subscriptionStartDate').datepicker({
                minDate: "0",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
                onSelect:function(selectedDate, datePicker) {            
                    self.subscriptionStartDate = selectedDate;
                    $('#subscriptionEndDate').datepicker('option', 'minDate', selectedDate);
                }
              });
              $('#subscriptionEndDate').datepicker({
                minDate: "0",
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: "dd/mm/yy",
                onSelect:function(selectedDate, datePicker) {            
                    self.subscriptionEndDate = selectedDate;
                }
              });
          },
          methods:{
            checkRecurringSubscription:function(e) {
              if(this.periodType && this.recurringpaymentuserid && this.planid && this.subscriptionStartDate && this.subscriptionEndDate && this.subscriptionStatus ) return true;
              this.errors = [];
              if(!this.periodType) this.errors.push("Please select collect Type.");
              if(!this.recurringpaymentuserid) this.errors.push("Please select a Customer.");
              if(!this.planid) this.errors.push("Please select a Plan.");
              if(!this.subscriptionStartDate) this.errors.push("Please select subscrption start date.");
              if(!(/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/g).test(this.subscriptionStartDate)) this.errors.push("Please select valid start date.");
              if(!(/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/g).test(this.subscriptionEndDate)) this.errors.push("Please select valid end date.");
              if(!this.subscriptionEndDate) this.errors.push("Please select subscrption end date.");
              if(!this.subscriptionStatus) this.errors.push("Please select subscrption status.");
              e.preventDefault();
            }
          }
        });
        
    }
    
</script>