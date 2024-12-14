<div class="rightArea">
    <div class="heading">
        <h2>Events Payment Report</h2>
    </div>
    <div class="fs-transtaction-actions">
        <div class="fs-filter-actions">
            <div class="defaultDroplist widthfloat margintop10">
                <div class="grid-lg-12 nopadding">
                    <div class="grid-lg-2">
                        <input type="text" name="startdate" id="startdate" placeholder="Start Date" class="textfield" value="<?php echo (isset($_GET['startdate'])) ? $_GET['startdate'] : date('m/d/Y'); ?>" >
                    </div>
                    <div class="grid-lg-2">
                        <input type="text" name="enddate" id="enddate" placeholder="End Date" class="textfield" value="<?php echo (isset($_GET['enddate'])) ? $_GET['enddate'] : date('m/d/Y'); ?>" >
                    </div>
                    <div class="grid-lg-6">
                        <input type="button" value="Search" id="searchBtn" class="createBtn" style="margin-top: 5px">
                        <input type="button" value="Export" id="exportBtn" class="createBtn" style="margin-top: 5px; margin-left: 5px">
                        <?php if (isset($subUserId)) { ?>
                            <a href="<?php echo commonHelperGetPageUrl('dashboard-sub-user-reports'); ?>" class="createBtn DBcreateBtn" style="margin-top: 5px; margin-left: 5px; padding: 5px 15px">Back to Sub User Reports</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearBoth"></div>
    <!--Data Section Start-->
    <div class="salesefforts">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="10%">
                <col width="40%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <thead>
                <tr>
                    <th>Event Id</th>
                    <th>Event Name</th>
                    <th>Paid Amount</th>
                    <th>Commission Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $finalPaidAmt = $finalCommissionAmt = 0;
                if (!empty($paymentReportData)) {
                    foreach ($paymentReportData as $eventPayment) {
                        $paidAmt = round($eventPayment['paidAmt']);
                        $commissionAmt = round($eventPayment['commissionAmt']);
                        $finalPaidAmt += $paidAmt;
                        $finalCommissionAmt += $commissionAmt;
                        ?>
                        <tr>
                            <td><?php echo $eventPayment['id']; ?></td>
                            <td><?php echo $eventPayment['title']; ?></td>
                            <td><?php echo number_format($paidAmt); ?></td>
                            <td><?php echo number_format($commissionAmt); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td><strong><?php echo number_format($finalPaidAmt); ?></strong></td>
                    <td><strong><?php echo number_format($finalCommissionAmt); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    var event_report_url = '<?php echo commonHelperGetPageUrl('dashboard-events-payment-report'); ?><?php echo isset($subUserId) ? '/' . $subUserId : ''; ?>';
    $('#searchBtn').on('click', function () {
        window.location = event_report_url + '?startdate=' + $('#startdate').val() + '&enddate=' + $('#enddate').val();
    });
    $('#exportBtn').on('click', function () {
        window.location = event_report_url + '?startdate=' + $('#startdate').val() + '&enddate=' + $('#enddate').val() + '&download=true';
    });
</script>