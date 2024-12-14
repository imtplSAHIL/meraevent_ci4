<div class="rightArea">
    <div class="heading">
        <h2>Sub User Report</h2>
    </div>
    <!--Data Section Start-->
    <div class="salesefforts refundSec bottomAdjust100">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="25%">
                <col width="25%">
                <col width="50%">
            </colgroup>
            <thead>
                <tr>
                    <th>Owner Details</th>
                    <th>Company</th>
                    <th>Reports</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($owner_details)) {
                    foreach ($owner_details as $owner_detail) {
                        ?>
                        <tr>
                            <td><?php echo $owner_detail['name']; ?></td>
                            <td><?php echo $owner_detail['company']; ?></td>
                            <td>
                                <p style="padding-bottom: 5px;"><a href="<?php echo commonHelperGetPageUrl('dashboard-events-summary-report') . '/' . $owner_detail['id']; ?>">Events Summary</a>
                                <p style="padding-bottom: 5px;"><a href="<?php echo commonHelperGetPageUrl('dashboard-events-daily-report') . '/' . $owner_detail['id']; ?>">Events Daily</a></p>
                                <p style="padding-bottom: 5px;"><a href="<?php echo commonHelperGetPageUrl('dashboard-events-daily-detail-report') . '/' . $owner_detail['id']; ?>">Events Daily Detail</a></p>
                                <p style="padding-bottom: 5px;"><a href="<?php echo commonHelperGetPageUrl('dashboard-events-payment-report') . '/' . $owner_detail['id']; ?>">Events Payment</a></p>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">No data found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>