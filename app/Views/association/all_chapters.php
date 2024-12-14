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
        <h2>Association - Manage Chapters</h2>
    </div>
    <div class="float-right form-group"> <a href="<?php echo commonHelperGetPageUrl('add-chapter') . "/" . $associationId; ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add New Chapter</a> </div>

    <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="5">Chapter Title</th>
                    <th scope="col" data-tablesaw-priority="5">URL</th>
                    <th scope="col" data-tablesaw-priority="5">Description</th>
                    <th scope="col" data-tablesaw-priority="5">Action</th>
                    <th scope="col" data-tablesaw-priority="5">Members</th>
                    <th scope="col" data-tablesaw-priority="5">Reports</th>
                    <th scope="col" data-tablesaw-priority="5">Export</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($orgnizerDetails)) {
                    foreach ($orgnizerDetails as $allChapters) {
                        ?>
                        <tr>
                            <td><?php echo $allChapters['name']; ?></td>
                            <td><?php echo $allChapters['slug']; ?></td>
                            <td><?php echo $allChapters['information']; ?></td>
                            <td><a href="<?php echo commonHelperGetPageUrl('edit-chapter') . "/" . $allChapters['id']; ?>">Edit</a> | <a href="<?php echo commonHelperGetPageUrl('delete-chapter') . "/" . $allChapters['id']; ?>" onclick='return confirm("Are you sure to delete the chapter?")'>Delete</a></td>
                            <td><a href="<?php echo commonHelperGetPageUrl('view-chapter-members') . "/" . $allChapters['id']; ?>" style="text-align: center;">View</a></td>
                            <td><a href="<?php echo commonHelperGetPageUrl('chapter-reports') . "/" . $allChapters['id']; ?>" style="text-align: center;">View</a></td>
                            <td><a href="<?php echo commonHelperGetPageUrl('export-report') . "/chapter" . "/" . $allChapters['id']; ?>">Export</td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">There are no chapters in this association</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
