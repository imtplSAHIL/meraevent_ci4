<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?> 
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Edit Membership Type</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form name="personalDetails" id="personalDetails" method="post" action="" >
            <input type="hidden" name="id" value="<?php echo $getMem['id']; ?>">
            <input type="hidden" name="org_id" value="<?php echo $getMem['org_id']; ?>">
            <div id="userSuccessMessage"> </div> <div id="userErrorMessage"> </div>
            <div class="form-group">
                <label>Name <span class="mandatory">*</span></label>
                <input type="text" id="username" name="name" class="textfield" value="<?php echo $getMem['name']; ?>" onkeypress="return Validate(event);">
                <span></span>
            </div>
            <div class="form-group">
                <label>Description<span class="mandatory">*</span></label>
                <textarea class="textarea" name="information" style="margin-bottom: 0px;"><?php echo $getMem['summary']; ?></textarea>
                <span></span>
            </div>
            <div class="form-group">
                <label>Chapter Level <span class="mandatory">*</span></label>
                <ul>
                    <li style="width: 30%; float: left">
                        <label><input type="radio" name="chapterlevel" class="customFieldLevel" id="customFieldLevelEvent" value="all" required <?php echo $getMem['chapterlevel'] == 'all' ? 'checked' : ''; ?>>All Chapters</label>
                    </li>
                    <li>
                        <label><input type="radio" name="chapterlevel" class="customFieldLevel" id="customFieldLevelTicket" value="chapter" required <?php echo $getMem['chapterlevel'] == 'chapter' ? 'checked' : ''; ?>>Include Specific Chapters</label>
                    </li>
                </ul>
            </div>
            <div class="form-group fieldLevelTickets" <?php echo $getMem['chapterlevel'] == 'chapter' ? '' : 'style="display: none"'; ?>>
                <label>Chapters <span class="mandatory"> *</span></label>
                <div style="position:relative">
                    <ul>
                        <?php foreach ($chapterList as $key => $value) { ?>
                            <li style="width: 33.33%; float: left">
                                <label><input type="checkbox" name="chapterIds[]" required value="<?php echo $value['id']; ?>" <?php echo in_array($value['id'], explode(",", $getMem["includechapterids"])) ? 'checked' : ''; ?>><?php echo $value['name']; ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div style="clear: both"></div>
            <br>
            <div class="form-group">
                <label>Price (INR) <span class="mandatory" >*</span></label>
                <input type="text" name="price" class="textfield" value="<?php echo $getMem['price'] ?>" onkeypress="return isNumberKey(event)">
                <span></span>
            </div>
            <div class="form-group">
                <label>GST ( % )<span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="tax">
                        <option value="" <?php if ($getMem['tax'] == '0') { ?> selected="selected" <?php } ?>>None</option>
                        <option value="5" <?php if ($getMem['tax'] == '5') { ?> selected="selected" <?php } ?>>5</option>
                        <option value="18" <?php if ($getMem['tax'] == '18') { ?> selected="selected" <?php } ?>>18</option>
                        <option value="28" <?php if ($getMem['tax'] == '28') { ?> selected="selected" <?php } ?>>28</option>
                        <option value="40" <?php if ($getMem['tax'] == '40') { ?> selected="selected" <?php } ?>>40</option>
                    </select>
                </div>
                <span></span>
            </div>
            <div class="form-group">
                <label>Select Category Type <span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="type" id='categoryType'>
                        <option value="lifetime" <?php if ($getMem['type'] == 'lifetime') { ?> selected="selected" <?php } ?>>Lifetime</option>
                        <option value="annual" <?php if ($getMem['type'] == 'annual') { ?> selected="selected" <?php } ?>>Annual</option>
                        <option value="semi" <?php if ($getMem['type'] == 'semi') { ?> selected="selected" <?php } ?>>Semi</option>
                        <option value="quarter" <?php if ($getMem['type'] == 'quarter') { ?> selected="selected" <?php } ?>>Quarter</option>
                        <option value="month" <?php if ($getMem['type'] == 'month') { ?> selected="selected" <?php } ?>>Month</option>
                    </select>
                </div>
                <span></span>
            </div>
            <div class="form-group validityEndDate" <?php echo $getMem['type'] == 'lifetime' ? 'style="display: none"' : ''; ?>>
                <label>Valid Till</label>
                <input type="text" name="validtill" id="validtill" class="textfield" value="<?php echo (!empty($getMem['validtill']) && $getMem['validtill'] != '0000-00-00') ? date('m/d/Y', strtotime($getMem['validtill'])) : ''; ?>">
                <span></span>
            </div>
            <div class="clearBoth"></div>
            <input type="submit"  name="submit" class="createBtn float-right" value="Update MemberShip Type"/>
        </form>
    </div>
</div>
<script>
    function Validate(event) {
        var regex = new RegExp("^[a-zA-Z0-9-!& ]");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            alert('only & and - are allowed');
            event.preventDefault();
            return false;
        }
    } 
</script>