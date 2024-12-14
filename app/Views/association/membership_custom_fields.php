<?php
if (!empty($customFields['response']['customFields'])) {
    foreach ($customFields['response']['customFields'] as $customField) {
        $fieldName = str_replace(" ", "", preg_replace("/[^A-Za-z0-9\s\s]/", "", $customField['fieldname']));
        $manadatorySpan = $requiredInput = '';
        if ($customField['fieldmandatory'] == 1) {
            $manadatorySpan = '<span class="mandatory" >*</span>';
            $requiredInput = 'required';
        }
        if ($customField['fieldtype'] == 'textbox') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <input type="text" name="<?php echo $fieldName; ?>" class="form-control" <?php echo $requiredInput; ?>>
            </div>
            <?php
        } else if ($customField['fieldtype'] == 'textarea') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <textarea type="text" name="<?php echo $fieldName; ?>" class="form-control" <?php echo $requiredInput; ?>></textarea>
            </div>
            <?php
        } else if ($customField['fieldtype'] == 'dropdown') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <div style="position:relative">
                    <span class="icon-downarrow downarrowSettings"></span>
                    <select class="form-control" name="<?php echo $fieldName; ?>" <?php echo $requiredInput; ?>>
                        <option value=''>Select</option>
                        <?php foreach ($customFields['response']['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                            <option value="<?php echo $customFieldValueArr['value']; ?>"><?php echo $customFieldValueArr['value']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php
        } else if ($customField['fieldtype'] == 'radio') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <ul>
                    <?php foreach ($customFields['response']['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                        <li style="width: 33.33%; float: left">
                            <label><input type="radio" name="<?php echo $fieldName; ?>" value="<?php echo $customFieldValueArr['value']; ?>" <?php echo $requiredInput; ?>><?php echo $customFieldValueArr['value']; ?></label>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div style="clear:both"></div>
            <?php
        } else if ($customField['fieldtype'] == 'checkbox') {
            ?>
            <div class="form-group">
                <label><?php echo $customField['fieldname']; ?> <?php echo $manadatorySpan; ?></label>
                <div style="position:relative">
                    <ul>
                        <?php foreach ($customFields['response']['customFieldValues'][$customField['id']] as $customFieldValueArr) { ?>
                            <li style="width: 33.33%; float: left">
                                <label><input type="checkbox" name="<?php echo $fieldName; ?>[]" value="<?php echo $customFieldValueArr['value']; ?>" <?php echo $requiredInput; ?>><?php echo $customFieldValueArr['value']; ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div style="clear:both"></div>
            <?php
        }
    }
}
?>