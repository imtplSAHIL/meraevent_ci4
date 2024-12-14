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
    <div class="heading" ><?php $id = $associationId; ?>
        <h2>Association - Members Directory </h2>

    </div>

    <div class="float-right form-group">
            <a href="<?php echo commonHelperGetPageUrl('export-report') . "/association" . "/" . $id; ?>"><button type="button" class="Edit-Btn blueborder"><span class="fa fa-edit"></span>Export</button></a>
            <a href="<?php echo commonHelperGetPageUrl('association-add-new-member') . "/" . $associationId; ?>"><button type="button" class="Edit-Btn blueborder"><span class="fa fa-edit"></span>Add New Member</button></a>
    </div>
    <br>
    <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="5">Reg. No</th>
                    <th scope="col" data-tablesaw-priority="5"></th>
                    <th scope="col" data-tablesaw-priority="5">Name</th>
                    <th scope="col" data-tablesaw-priority="5">Email</th>
                    <th scope="col" data-tablesaw-priority="5">Mobile Number</th>
                    <th scope="col" data-tablesaw-priority="5">Valid From</th>
                    <th scope="col" data-tablesaw-priority="5">Validity</th>
                    <th scope="col" data-tablesaw-priority="5">Membership Name</th>
                    <th scope="col" data-tablesaw-priority="5">Membership Category</th>
                    <th scope="col" data-tablesaw-priority="5">Chapter</th>
                    <th scope="col" data-tablesaw-priority="5">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($regMembers)) {
                    foreach ($regMembers as $data) {
                        ?>
                        <tr>
                            <td><?php echo $data['signupid']; ?></td>
                            <td><?php if (trim($data['profileimagefilepath']) != "") { ?>
                                    <img src="
            <?php echo trim($data['profileimagefilepath']); ?>" style="width: 50px;height: 50px;"/>
                                <?php } ?></td>
                            <td><?php echo $data['name']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo $data['mobile']; ?></td>
                            <td><?php echo date("d-F-Y", strtotime($data['validfrom'])); ?></td>
                            <td><?php echo (($data['type'] != 'lifetime')?date("d-F-Y", strtotime($data['validto'])):"Lifetime"); ?></td>
                            <td><?php echo ucfirst($data['cname']); ?></td>
                            <td><?php echo ucfirst($data['type']); ?></td>
                            <td><?php echo $data['chapter']; ?></td>
                            <td><a href="<?php echo commonHelperGetPageUrl('association-update-profile-pic') . "/" . (int)$data['userid']; ?>">Change Profile Picture</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                        <tr><td colspan="11">There are no members in this association</td> </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
