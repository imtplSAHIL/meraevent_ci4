<div class="rightArea">
    <div class="heading" >
        <h2>My Memberships View</h2>
    </div>
    <div class="float-right"> <a href="<?php echo commonHelperGetPageUrl('dashboard-add-chapter'); ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add New Chapter</a> </div>
    <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="5">Chapter Title</th>
                    <th scope="col" data-tablesaw-priority="5">URL</th>
                    <th scope="col" data-tablesaw-priority="5">Purchase Date</th>
                    <th scope="col" data-tablesaw-priority="5">Valid From</th>
                    <th scope="col" data-tablesaw-priority="5">Expiry Date</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($subscriptionsInfo as $data) { ?>   
                <td><?php echo $data['name']; ?></td>
                <td><?php echo $data['url']; ?></td>
                <td><?php echo $data['purchasedate']; ?></td>
                <td><?php echo $data['validfrom']; ?></td>
                <td><?php echo (($data['type'] != 'lifetime')?date("d-F-Y", strtotime($data['validto'])):"Lifetime"); ?></td>
            
            </tbody>

            <?php } ?> 
        </table>
    </div>
</div>
