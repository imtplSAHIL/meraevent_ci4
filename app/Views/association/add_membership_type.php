<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?> 
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Add Membership Type</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form name="personalDetails" id="personalDetails" method="post" action="" >
            <div id="userSuccessMessage"> </div> <div id="userErrorMessage"> </div>
            <div class="form-group">
                <label>Name <span class="mandatory">*</span></label>
                <input type="text" id="username" name="name" value="" class="textfield" onkeypress="return Validate(event);">
                <span></span>
            </div>
            <div class="form-group">
                <label>Description<span class="mandatory">*</span></label>
                <textarea class="textarea" name="information" style="margin-bottom: 0px;"></textarea>
                <span></span>
            </div>
            <div class="form-group">
                <label>Chapter Level <span class="mandatory">*</span></label>
                <ul>
                    <li style="width: 30%; float: left">
                        <label><input type="radio" name="chapterlevel" class="customFieldLevel" id="customFieldLevelEvent" value="all" required>All Chapters</label>
                    </li>
                    <li>
                        <label><input type="radio" name="chapterlevel" class="customFieldLevel" id="customFieldLevelTicket" value="chapter" required>Include Chapters</label>
                    </li>
                </ul>
            </div>
            <div class="form-group fieldLevelTickets" style="display: none">
                <label>Chapters <span class="mandatory"> *</span></label>
                <div style="position:relative">
                    <ul>
                        <?php foreach ($chapterList as $key => $value) { ?>
                            <li style="width: 33.33%; float: left">
                                <label><input type="checkbox" name="chapterIds[]" required value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div style="clear: both"></div>
            <br>
            <div class="form-group">
                <label>Price (INR) <span class="mandatory" >*</span></label>
                <input type="text" name="price" class="textfield" onkeypress="return isNumberKey(event)">
                <span></span>
            </div>
            <div class="form-group">
                <label>GST ( % )<span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="tax">
                        <option value="">None</option>
                        <option value="5">5</option>
                        <option value="18">18</option>
                        <option value="28">28</option>
                        <option value="40">40</option>
                    </select>
                </div>
                <span></span>
            </div>
            <div class="form-group">
                <label>Select Category Type <span class="mandatory">*</span></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select name="type" id='categoryType'>
                        <option value="lifetime">Lifetime</option>
                        <option value="annual">Annual</option>
                        <option value="semi">Semi</option>
                        <option value="quarter">Quarter</option>
                        <option value="month">Month</option>
                    </select>
                </div>
                <span></span>
            </div>
            <div class="form-group validityEndDate" style="display: none">
                <label>Valid Till</label>
                <input type="text" name="validtill" id="validtill" class="textfield">
                <span></span>
            </div>
            <div class="clearBoth"></div>
            <input type="submit"  name="submit" class="createBtn float-right" value="Create MemberShip Type"/>
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