<div class="rightArea">
    <div class="heading">
        <h2>Traffic Report: <span> <?php echo isset($eventTitle) ? $eventTitle : ''; ?></span></h2>
    </div>
    <!--Data Section Start-->
    <div class="sales salesefforts">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="25%">
                <col width="25%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <thead>
                <tr>
                    <th>Widget Referral Type</th>
                    <th>View Count</th>
                    <th>Tickets Sold</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalRefCount = $totalTicketQty = $totalAmount = 0;
                if (!empty($widgetReferralTraffic)) {
                    foreach ($widgetReferralTraffic as $rcode => $rcount) {
                        $totalRefCount += $rcount;
                        $qty = $amt = 0;
                        if (!empty($eventsignupData)) {
                            foreach ($eventsignupData as $signupData) {
                                if ($signupData['promotercode'] == 'organizer' && $signupData['rcode'] == 'widget_' . $rcode) {
                                    $qty = $signupData['ticketQty'];
                                    $amt = $signupData['totalAmt'];
                                }
                            }
                        }
                        $totalTicketQty += $qty;
                        $totalAmount += $amt;
                        ?>
                        <tr>
                            <td><?php echo $rcode; ?></td>
                            <td><?php echo $rcount; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $amt; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?php echo $totalRefCount; ?></strong></td>
                    <td><strong><?php echo $totalTicketQty; ?></strong></td>
                    <td><strong><?php echo $totalAmount; ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>