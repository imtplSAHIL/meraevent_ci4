<div class="rightArea">
    <?php
    $bankDetailListMessage = $this->customsession->getData('bankDetailMessage');
    $this->customsession->unSetData('bankDetailMessage');
    $bankDetailErrorMessage = $this->customsession->getData('bankDetailErrorMessage');
    $this->customsession->unSetData('bankDetailErrorMessage');
    ?>

    <?php if ($bankDetailListMessage) { ?>
        <div   class="db-alert db-alert-success flashHide" ><?php echo $bankDetailListMessage; ?></div><?php } ?> 
        <?php if ($bankDetailErrorMessage) { ?> <div   class="db-alert db-alert-danger flashHide" ><?php echo $bankDetailErrorMessage; ?></div><?php } ?>

        <div class="heading">
            <h2>Bank Details</h2>
        </div>
        <div class="editFields fs-bank-details">
            <form id="bankDetailsForm" name="bankDetailsForm" method="post" action="" enctype="multipart/form-data">
                <label>Account Holder Name <span class="mandatory">*</span></label>
                <input type="text" class="textfield" name="accountName" id="accountName" value="<?php echo $bankDetails['accountname']; ?>">
                <label>Account Number <span class="mandatory">*</span></label>
                <input type="text" class="textfield" name="accountNumber" id="accountNumber" value="<?php echo $bankDetails['accountnumber']; ?>">
                <label>Bank Name <span class="mandatory">*</span></label>
                <input type="text" class="textfield" name="bankName" id="bankName" value="<?php echo $bankDetails['bankname']; ?>">
                <label>Branch <span class="mandatory">*</span></label>
                <input type="text" class="textfield" name="branch" id="branch" value="<?php echo $bankDetails['branch']; ?>">
                <label>IFSC Code <span class="mandatory">*</span></label>
                <input type="text" class="textfield" name="ifsccode" id="ifsccode" value="<?php echo $bankDetails['ifsccode']; ?>">
                <!-- <label>Service Tax Number:</label>
                <input type="text" class="textfield" name="serviceTaxNumber" id="serviceTaxNumber" value="<?php echo $bankDetails['servicetaxnumber']; ?>"> -->
                <label>PAN Number </label>
                <input type="text" class="textfield" name="pancard" id="pancard" value="<?php echo $bankDetails['pancard']; ?>">
                <label>Aadhar Number </label>
                <input type="text" class="textfield" name="aadhar" id="aadhar" value="<?php echo $bankDetails['aadhar']; ?>">
                <label>GST Number </label>
                <input type="text" class="textfield" name="gst" id="gst" value="<?php echo $bankDetails['gst']; ?>">

                <?php if($bankDetails['gst']==''){ ?>
                <label>GST Exemption Document <a href="<?php echo $gst_form_path?>" class="green" target="_blank">(Download Sample Document here)</a> </label>
                <input type="file" class="textfield" name="gstDocument" id="gstDocument" value="">
                    <?php if($bankDetails['docPath']!=''){ ?>
                        <a href="<?php echo $bankDetails['docPath']?>" target="_blank" style="color: #5f259f">Uploaded document</a><br><br>
                        <embed src="<?php echo $bankDetails['docPath']?>"/>
                    <?php } ?>
                        <label>Upload Pancard </label>
                <input type="file" class="textfield" name="orgpancard" id="orgpancard" value="">
                    <?php if($bankDetails['panPath']!=''){ ?>
                        <a href="<?php echo $bankDetails['panPath']?>" target="_blank" style="color: #5f259f">Uploaded document</a><br><br>
                        <embed src="<?php echo $bankDetails['panPath']?>" width="150px" height="150px"/>
                    <?php } ?>
                        <label>Upload Adharcard </label>
                <input type="file" class="textfield" name="orgadharcard" id="orgadharcard" value="">
                    <?php if($bankDetails['adharPath']!=''){ ?>
                        <a href="<?php echo $bankDetails['adharPath']?>" target="_blank" style="color: #5f259f"  width="150px" height="150px">Uploaded document</a><br><br>
                        <embed src="<?php echo $bankDetails['adharPath']?>" width="150px" height="150px"/>
                    <?php } ?>
                        <label>Upload Cancellation Cheque</label>
                <input type="file" class="textfield" name="orgcheque" id="orgcheque" value="">
                    <?php if($bankDetails['chequePath']!=''){ ?>
                        <a href="<?php echo $bankDetails['chequePath']?>" target="_blank" style="color: #5f259f">Uploaded document</a><br><br>
                        <embed src="<?php echo $bankDetails['chequePath']?>" width="150px" height="150px"/>
                    <?php } ?>
                <?php } ?>

                <label>Account Type</label>
                <p style="float:left; width:30%">
                    <label><input type="radio" name="accountType" id="accountType"  value="current" class="textfield" <?php if ($bankDetails['accounttype'] == 'Current') { ?> checked="checked" <?php } ?>  style="float:left; width:auto;margin-right:10px; margin-top:5px;">Current</label>
                </p>
                <p style="float:left; width:30%">
                    <label><input type="radio" name="accountType" id="accountType" value="savings" class="textfield"  <?php if ($bankDetails['accounttype'] == 'Savings' || $bankDetails['accounttype'] == '') { ?> checked="checked" <?php } ?> style="float:left; width:auto;margin-right:10px;margin-top:5px;">Savings</label></p>

                <input type="submit" name="bankDetails"  value="SAVE" class="submitBtn fs-btn float-right fieldsValidate"/>
            </form>
        </div>
        
        <script>
        $( ".fieldsValidate" ).click(function() {
            var pancard = $('#pancard').val();
            var aadhar = $('#aadhar').val();
            // if(pancard =='' && aadhar ==''){
            //     alert('Please enter Pancard or Aadhar no');
            //     return false;
            // }
        });
        </script>
</div>
