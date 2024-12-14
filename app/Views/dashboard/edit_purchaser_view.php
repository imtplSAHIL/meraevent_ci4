<div class="rightArea">
    <div class="fs-form">
        <h2 class="fs-box-title">Edit Invoice Details</h2>
        <div class="editFields">
            <?php if (isset($status_message)) { ?>
                <div id="flashMessage" class="db-alert db-alert-success flashHide"> <?php echo $status_message; ?>
                </div>
            <?php } ?>
                <div id="flashMessage" class="db-alert flashHide" style="display:none"> 
                </div>
                <form name="purchaserform" id="purchaserform" method="post" action="">
                    <input type="hidden" name="redirect_page" value ="<?php echo $redirect_page; ?>" id="redirect_page"/>
                    <input type="hidden" name="eventsignupId" value ="<?php echo $eventsignupId; ?>" id="eventsignupId"/>

                    <div class="form-group">
                        <label>First Name<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="first_name" id="first_name" value="<?php echo $purchaserDetails['first_name']; ?>">
                        <span></span>
                    </div>

                    <div class="form-group">
                        <label>Last Name<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="last_name" id="last_name" value="<?php echo $purchaserDetails['last_name']; ?>">
                        <span></span>
                    </div>


                    <div class="form-group">
                        <label>Email Id<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="email_id" id="email_id" value="<?php echo $purchaserDetails['email_id']; ?>">
                        <span></span>
                    </div>


                    <div class="form-group">
                        <label>Mobile<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="mobile" id="mobile" value="<?php echo $purchaserDetails['mobile']; ?>">
                        <span></span>
                    </div>


                    <div class="form-group">
                        <label>Organization Name<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="org_name" id="org_name" value="<?php echo $purchaserDetails['org_name']; ?>">
                        <span></span>
                    </div>

                    <div class="form-group">
                        <label>GST</label>
                         <input type="text" class="textfield" name="gst" id="gst" value="<?php echo $purchaserDetails['gst']; ?>">
                        <span></span>
                    </div>

                    <div class="form-group">
                        <label>PAN Number</label>
                         <input type="text" class="textfield" name="pan" id="pan" value="<?php echo $purchaserDetails['pan']; ?>">
                        <span></span>
                    </div>


                    <div class="form-group">
                        <label>PO Number</label>
                         <input type="text" class="textfield" name="po_number" id="po_number" value="<?php echo $purchaserDetails['po_number']; ?>">
                        <span></span>
                    </div>

                    <div class="form-group">
                        <label>Invoice Number<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="tax_invoice_number" id="tax_invoice_number" value="<?php echo $purchaserDetails['tax_invoice_number']; ?>">
                        <span></span>
                    </div>

                    <!-- <div class="form-group">
                        <label>Invoice Date<span class="mandatory"> *</span></label>
                        <?php
                            // $invoice_date = date('m/d/Y',strtotime($purchaserDetails['cts']));
                            // if(!empty($purchaserDetails['invoice_date']))
                            // {
                            //     $invoice_date = $purchaserDetails['invoice_date'];
                            // }
                        ?>
                         <input type="text" class="textfield form-datepicker" name="invoice_date" id="invoice_date" value="<?php echo $invoice_date; ?>">
                        <span></span>
                    </div> -->

                    <div class="form-group">
                        <label>Job Title<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="job_title" id="job_title" value="<?php echo $purchaserDetails['job_title']; ?>">
                        <span></span>
                    </div>

                    <div class="form-group">
                        <label>Industry<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="industry" id="industry" value="<?php echo $purchaserDetails['industry']; ?>">
                        <span></span>
                    </div>

                    <div class="form-group">
                        <label>Employee Strength<span class="mandatory"> *</span></label>
                         <input type="text" class="textfield" name="employee_strength" id="employee_strength" value="<?php echo $purchaserDetails['employee_strength']; ?>">
                        <span></span>
                    </div>

                    <div class="form-group">
                        <label>Billing Address<span class="mandatory"> *</span></label>
                         <input type="text" class="textarea" name="billing_address" id="billing_address" value="<?php echo $purchaserDetails['billing_address']; ?>">
                        <span></span>
                    </div>

                    <div class="form-group ">
                        <label style="width: 100%" for="exampleInputtext1">
                        State<span style="color:red">*</span>
                        <span style="font-size: 11px;"></span>
                        </label>
                        <select class="form-control" name="state" id="pur_state" data-originalname="State" value="">
                        <option value=''>Select</option>
                            <?php
                                $gst_states_array = array('01' => "JAMMU AND KASHMIR", '02' => "HIMACHAL PRADESH", '03' => "PUNJAB", '04' => "CHANDIGARH", '05' => "UTTARAKHAND", '06' => "HARYANA", '07' => "DELHI", '08' => "RAJASTHAN", '09' => "UTTAR PRADESH", '10' => "BIHAR", '11' => "SIKKIM", '12' => "ARUNACHAL PRADESH", '13' => "NAGALAND", '14' => "MANIPUR", '15' => "MIZORAM", '16' => "TRIPURA", '17' => "MEGHALAYA", '18' => "ASSAM", '19' => "WEST BENGAL", '20' => "JHARKHAND", '21' => "ODISHA", '22' => "CHATTISGARH", '23' => "MADHYA PRADESH", '24' => "GUJARAT", '26' => "DADRA AND NAGAR HAVELI AND DAMAN AND DIU (NEWLY MERGED UT)", '27' => "MAHARASHTRA", '28' => "ANDHRA PRADESH(BEFORE DIVISION)", '29' => "KARNATAKA", '30' => "GOA", '31' => "LAKSHADWEEP", '32' => "KERALA", '33' => "TAMIL NADU", '34' => "PUDUCHERRY", '35' => "ANDAMAN AND NICOBAR ISLANDS", '36' => "TELANGANA", '37' => "ANDHRA PRADESH (NEWLY ADDED)", '38' => "LADAKH (NEWLY ADDED)");
                                foreach($gst_states_array as $state_code => $statename)
                                {
                                    ?>
                                    <option value="<?php echo $state_code; ?>" <?php if($purchaserDetails['state'] == $state_code) { echo "selected=true"; } ?> ><?php echo $statename; ?></option>
                                    <?php
                                }
                            ?>
                            </select>
                        <span class="pur_state"></span>
                    </div>
                    
                    <div class="fs-custom-field-buttons float-right">
                        <input id="saveCustomFieldsData" type="submit" name="Submit" class="createBtn" value="Save"/>
                        <a href="<?php echo commonHelperGetPageUrl('dashboard-offline-pending-transaction-report'). $purchaserDetails['eventid']; ?>">
                            <button type="button" class="saveBtn">cancel</button>
                        </a>
                    </div>
                </form>
        </div>
    </div>    
</div>
