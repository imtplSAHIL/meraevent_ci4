<div class="rightArea">
    <div class="heading">
        <h2>Events Daily Detail Report</h2>
    </div>
    <?php
    $fromDate = isset($_GET['fromdate']) ? $_GET['fromdate'] : date('m/d/Y');
    $toDate = isset($_GET['todate']) ? $_GET['todate'] : date('m/d/Y');
    ?>
    <div class="fs-transtaction-actions">
        <div class="fs-filter-actions">
            <div class="defaultDroplist widthfloat margintop10">
                <div class="grid-lg-12 nopadding">
                    <div class="grid-lg-2">
                        <input type="text" name="fromdate" id="startdate" placeholder="From Date" class="textfield" value="<?php echo $fromDate; ?>" >
                    </div>
                    <div class="grid-lg-2">
                        <input type="text" name="todate" id="enddate" placeholder="To Date" class="textfield" value="<?php echo $toDate; ?>" >
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
    <div class="salesefforts refundSec bottomAdjust100">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="5%">
                <col width="10%">
                <col width="20%">
                <col width="10%">
                <col width="20%">
                <col width="10%">
                <col width="10%">
                <col width="15%">
            </colgroup>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Event Id</th>
                    <th>Event Name</th>
                    <th>Reg.No</th>
                    <th>Contact Details</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($dailyReportData)) {
                    $SNo = ($page - 1) * REPORTS_DISPLAY_LIMIT + 1;
                    foreach ($dailyReportData as $eventSale) {
                        ?>
                        <tr>
                            <td><?php echo $SNo++; ?></td>
                            <td><?php echo $eventSale['eventId']; ?></td>
                            <td><?php echo $eventSale['title']; ?></td>
                            <td><?php echo $eventSale['id']; ?></td>
                            <td><?php echo $attendeeData[$eventSale['id']]['1'] . '<br>' . $attendeeData[$eventSale['id']]['2'] . '<br>' . $attendeeData[$eventSale['id']]['3']; ?></td>
                            <td><?php echo number_format($eventSale['quantity']); ?></td>
                            <td><?php echo number_format(round($eventSale['saleAmt'])); ?></td>
                            <td><?php echo allTimeFormats(convertTime($eventSale['signupdate'], $eventSale['timeZone'], true), 11); ?></td>
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
        <?php if ($totalCount > REPORTS_DISPLAY_LIMIT) { ?>
            <div class="float-right dropwidth100">
                <?php
                $totalTrns = $totalCount;
                $url_dashboardReports = commonHelperGetPageUrl('dashboard-events-daily-detail-report') . '?fromdate=' . $fromDate . '&todate=' . $toDate;
                if (REPORTS_DISPLAY_LIMIT > $totalTrns) {
                    $loopCount = 1;
                } else {
                    $loopCount = ceil($totalCount / REPORTS_DISPLAY_LIMIT);
                }
                if ($loopCount > 1) {
                    for ($i = 1; $i <= $loopCount; $i++) {
                        if ($i == $page) {
                            echo "<a class='Btn blueborder' href ='" . $url_dashboardReports . "&page=" . $i . "'> <b> <u> $i </u> </b> </a>";
                        } else {
                            echo "<a class='Btn blueborder' href ='" . $url_dashboardReports . "&page=" . $i . "'> $i </a>";
                        }
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    var event_report_url = '<?php echo commonHelperGetPageUrl('dashboard-events-daily-detail-report'); ?><?php echo isset($subUserId) ? '/' . $subUserId : ''; ?>';
    $('#searchBtn').on('click', function () {
        window.location = event_report_url + '?fromdate=' + $('#startdate').val() + '&todate=' + $('#enddate').val();
    });
    $('#exportBtn').on('click', function () {
        window.location = event_report_url + '?fromdate=' + $('#startdate').val() + '&todate=' + $('#enddate').val() + '&download=true';
    });
</script>