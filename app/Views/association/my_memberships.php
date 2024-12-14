<div class="rightArea">
    <div class="heading" >
        <h2>My Subscriptiopns</h2>
    </div>
    <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="5">Membership Type</th>
                    <th scope="col" data-tablesaw-priority="5">Purchase Date</th>
                    <th scope="col" data-tablesaw-priority="5">Valid From</th>
                    <th scope="col" data-tablesaw-priority="5">Expiry Date</th>
                    <th scope="col" data-tablesaw-priority="5">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscriptionsInfo as $data) { ?>   
                <td><?php echo $data['name']; ?></td>
                <td><?php echo date("d-F-Y", strtotime($data['purchasedate'])); ?></td>
                <td><?php echo date("d-F-Y", strtotime($data['validfrom'])); ?></td>
                <td><?php if($data['type'] == 'lifetime'){echo "Lifetime";}else{echo date("d-F-Y", strtotime($data['validto'])); } ?></td>
                <td><a href="<?php echo commonHelperGetPageUrl('association-update-membership-user-profile') . "/" . $data['s_id']; ?>">Update Details</td>
            
            </tbody>

            <?php } ?> 
        </table>
    </div>
</div>
