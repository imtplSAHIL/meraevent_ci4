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
        <h2>Registered Members View For - <?php echo $getCmembers['chapterName']; ?></h2>
    </div>
    <div class="float-right form-group"> <a href="<?php echo commonHelperGetPageUrl('association-add-new-member') . "/" . $getCmembers['parentassociationid']; ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add New Member</a> </div>

    <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="5">Reg. No</th>
                    <th scope="col" data-tablesaw-priority="5">Name</th>
                    <th scope="col" data-tablesaw-priority="5">Email</th>
                    <th scope="col" data-tablesaw-priority="5">Mobile Number</th>
                    <th scope="col" data-tablesaw-priority="5">Registered On</th>
                    <th scope="col" data-tablesaw-priority="5">Validity</th>
                    <th scope="col" data-tablesaw-priority="5">Membership Name</th>
                    <th scope="col" data-tablesaw-priority="5">Membership Category</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($getCmembers['userdetails'])) {
                    foreach ($getCmembers['userdetails'] as $data) {
                        ?>
                        <tr>
                            <td><?php echo $data['signupid']; ?></td>
                            <td><?php echo $data['name']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo $data['mobile']; ?></td>
                            <td><?php echo date("d-F-Y", strtotime($data['validfrom'])); ?></td>
                            <td><?php echo (($data['type'] != 'lifetime')?date("d-F-Y", strtotime($data['validto'])):"Lifetime"); ?></td>
                            <td><?php echo ucfirst($data['cname']); ?></td>
                            <td><?php echo ucfirst($data['type']); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr><td>No data found </td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
