<div class="rightArea">
    <?php
    $promoterSuccessMessage = $this->customsession->getData('promoterSuccessAdded');
    $this->customsession->unSetData('promoterSuccessAdded');
    if ($promoterSuccessMessage) {
        ?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $promoterSuccessMessage; ?></strong>
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Association - Custom Fields</h2>
    </div>
    <!--Data Section Start-->
    <div class="float-right"> <a href="<?php echo commonHelperGetPageUrl('association-add-custom-fields') . "/" . $associationId; ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add custom field</a> </div>
    <div class="clearBoth"></div>
    <input type="hidden" name="eventId" id="eventId" value="<?php echo $fieldData['0']['eventid']; ?>"/>
    <div class="tablefields">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="customFieldsDataTable" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="persist">Field Name</th>
                    <th scope="col" data-tablesaw-priority="3">Field Type</th>
                    <th scope="col" data-tablesaw-priority="3" style="width:10% !important;">Mandatory</th>
                    <th scope="col" data-tablesaw-priority="3">Status</th>
                    <th scope="col" data-tablesaw-priority="3" style="width:10% !important;">Level</th>
                    <th scope="col" data-tablesaw-priority="3">Order</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fieldData as $value) { ?>
                    <tr class="customfieldRow">
                        <td style="text-transform:none;"><?php echo $value['fieldname'] ?></td>
                        <td><?php echo $value['fieldtype'] ?></td>
                        <td><input id="mandatory<?php echo $value['id']; ?>" class="mandatory" type="checkbox" name="sport[]" value="<?php echo $value['id']; ?>" <?php
                            if ($value['fieldname'] !== 'Full Name' && $value['fieldmandatory'] == 1) {
                                echo 'checked=checked';
                            }
                            if (in_array($value['fieldname'], $this->config->item('default_customfileds'))) {
                                echo 'checked="checked" disabled="disabled"';
                            }
                            ?>>
                        </td>
                        <?php if (in_array($value['fieldname'], $this->config->item('default_customfileds'))) { ?>
                            <td style="text-align: center;"><button onclick="editCustomField('<?php echo $value['id']; ?>')" id="editCustomField<?php echo $value['id']; ?>" type="button" class="editCustomField btn blueBtn" style="display: none;">Edit</button></td>
                        <?php } else { ?>
                            <td>
                                <a href="<?php echo commonHelperGetPageUrl('association-edit-custom-fields') . "/" . $value['id']; ?>" id="editCustomField<?php echo $value['id']; ?>" class="editCustomField btn blueBtn">Edit</a>
                            </td>
                        <?php } ?>

                        <td><?php echo $value['fieldlevel']; ?></td>
                        <td><input id="ordervalue<?php echo $value['id']; ?>" type="text" value="<?php echo $value['order']; ?>" class="CustomOrder" disabled><span id="<?php echo $value['id']; ?>" class="orderIcon icon-edit" onclick="affecter(<?php echo $value['order']; ?>,<?php echo $value['id']; ?>)"></span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    var api_configureUpdateStatus = '<?php echo commonHelperGetPageUrl('api_configureUpdateStatus');?>';
    var oldorder;
    function affecter(order, id) {
        if (oldorder == order) {
            var customfieldid = id;
            $.ajax({
                url: "<?php echo commonHelperGetPageUrl('association-ordercustom-fields'); ?>", //the page containing php script
                type: "get", //request type,
                dataType: 'html',
                data: {ordervalue: $("#ordervalue" + id).val(), customfieldid: customfieldid},
                success: function (data) {
                    $("#dvLoading").hide();
                    alert('updated');
                }
            });
        } else {
            oldorder = order;
        }
    }
</script>
