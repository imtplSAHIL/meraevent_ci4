<div class="rightArea">
    <div class="heading">
        <h2>Events Summary Report</h2>
    </div>
    <div class="fs-transtaction-actions">
        <div class="fs-filter-actions">
            <div class="defaultDroplist widthfloat margintop10">
                <div class="grid-lg-12 nopadding">
                    <div class="grid-lg-2">
                        <select name="summary_type" id="summary_type" style="margin-top: 0px">
                            <option value="upcoming">Upcoming Events</option>
                            <option value="past"<?php echo (isset($_GET['type']) && $_GET['type'] == 'past') ? ' selected' : ''; ?>>Past Events</option>
                            <option value="all"<?php echo (isset($_GET['type']) && $_GET['type'] == 'all') ? ' selected' : ''; ?>>All</option>
                        </select>
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
                <col width="25%">
                <col width="12.5%">
                <col width="12.5%">
                <col width="12.5%">
                <col width="12.5%">
                <col width="12.5%">
            </colgroup>
            <thead>
                <tr>
                    <th>Event Id</th>
                    <th>Event Name</th>
                    <th>Total Tickets</th>
                    <th>Total Sale Amount</th>
                    <th>Paid Amount</th>
                    <th>Commission Amount</th>
                    <th>Remaining Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $finalTicketsQty = $finalSaleAmt = $finalPaidAmt = $finalCommissionAmt = $finalRemainingAmt = 0;
                if (!empty($summaryReportData['0'])) {
                    foreach ($summaryReportData['0'] as $eventSale) {
                        $totPaidAmt = $totalCommission = 0;
                        if (!empty($summaryReportData['1'])) {
                            foreach ($summaryReportData['1'] as $eventPayment) {
                                if ($eventPayment['eventid'] == $eventSale['id']) {
                                    $totPaidAmt = $eventPayment['paidAmt'];
                                    $totalCommission = $eventPayment['commissionAmt'];
                                }
                            }
                        }
                        $saleAmt = round($eventSale['saleAmt']);
                        $totalAmtToBePaid = $saleAmt - $totPaidAmt - $totalCommission;
                        $finalTicketsQty += $eventSale['ticketQty'];
                        $finalSaleAmt += $saleAmt;
                        $finalPaidAmt += $totPaidAmt;
                        $finalCommissionAmt += $totalCommission;
                        $finalRemainingAmt += $totalAmtToBePaid;
                        ?>
                        <tr>
                            <td><?php echo $eventSale['id']; ?></td>
                            <td><?php echo $eventSale['title']; ?></td>
                            <td><?php echo number_format($eventSale['ticketQty']); ?></td>
                            <td><?php echo number_format($saleAmt); ?></td>
                            <td><?php echo number_format($totPaidAmt); ?></td>
                            <td><?php echo number_format($totalCommission); ?></td>
                            <td><?php echo number_format($totalAmtToBePaid); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td><strong><?php echo number_format($finalTicketsQty); ?></strong></td>
                    <td><strong><?php echo number_format($finalSaleAmt); ?></strong></td>
                    <td><strong><?php echo number_format($finalPaidAmt); ?></strong></td>
                    <td><strong><?php echo number_format($finalCommissionAmt); ?></strong></td>
                    <td><strong><?php echo number_format($finalRemainingAmt); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    var event_report_url = '<?php echo commonHelperGetPageUrl('dashboard-events-summary-report'); ?><?php echo isset($subUserId) ? '/' . $subUserId : ''; ?>';
    $('#searchBtn').on('click', function () {
        window.location = event_report_url + '?type=' + $('#summary_type').val();
    });
    $('#exportBtn').on('click', function () {
        window.location = event_report_url + '?type=' + $('#summary_type').val() + '&download=true';
    });
</script>