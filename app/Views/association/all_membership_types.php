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
    <div class="heading" >
        <h2>Association - Membership Types</h2>
    </div>

    <div class="float-right"> <a href="<?php echo commonHelperGetPageUrl('add-membership-type') . "/" . $associationId; ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add Membership Type</a> </div>
    <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="5">Name</th>
                    <th scope="col" data-tablesaw-priority="5">Summary</th>
                    <th scope="col" data-tablesaw-priority="5">Price</th>
                    <th scope="col" data-tablesaw-priority="5">Type</th>
                    <th scope="col" data-tablesaw-priority="5">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($membership_types)) {
                    foreach ($membership_types as $membership_type) {
                        ?>
                        <tr>
                            <td><?php echo ucfirst($membership_type['name']); ?></td>
                            <td><?php echo $membership_type['information']; ?></td>
                            <td><?php echo $membership_type['price']; ?></td>
                            <td><?php echo ucfirst($membership_type['type']); ?></td>
                            <td>
                                <a href="<?php echo commonHelperGetPageUrl('edit-membership-type') . "/" . $membership_type['id']; ?>">Edit</a> | 
                                <a href="<?php echo commonHelperGetPageUrl('delete-membership-type') . "/" . $membership_type['id']; ?>" onclick='return confirm("Are you sure to delete the membership type?")'>Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">There are no membership types in this association</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>  
    </div>
</div>
