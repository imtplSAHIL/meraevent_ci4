<!--Right Content Area Start-->
<?php //print_r($salesData); ?>
<div class="rightArea">
    <!--    <div class="rightSec">
            <div class="search-container">
                <input class="search searchExpand icon-search"
                       id="searchId" type="search"
                       placeholder="Search">
                <a class="search icon-search"></a> </div>
        </div>-->
    <div class="heading">
        <h2>Sales Effort: <span> <?php echo isset($eventTitle) ? $eventTitle : ''; ?></span></h2>
    </div>
    <!--Data Section Start-->
    <div class="sales salesefforts">
        <?php
        if (isset($errors)) {
            echo $errors[0];
        } else {
            $finalAmount['totalquantity'] = 0;
            //$finalAmount['totalamount'][''] = 0;
            ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="33.33333%">
                    <col width="33.33333%">
                    <col width="33.33333%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Sales Type</th>
                        <th>Tickets Sold</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($salesData['organizer'])) { ?>
                        <tr>
                            <td>Organizer Sales</td>
                            <?php
                            if ($salesData['organizer']['totalquantity'] > 0) {
                                $finalAmount['totalquantity']+=$salesData['organizer']['totalquantity'];
                                ?>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&organizer&1'); ?>"><?php echo $salesData['organizer']['totalquantity']; ?></a></td>
                            <?php } else { ?>
                                <td>0</td>
                                <?php
                            }
                            if (is_array($salesData['organizer']['totalpaidamount'])) {
                                ?>
                                <td><?php
                                    foreach ($salesData['organizer']['totalpaidamount'] as $key => $value) {
                                        if (strpos($key, 'quantity') !== false) {}else{
                                        if (!isset($finalAmount['totalamount'][$key])) {
                                            $finalAmount['totalamount'][$key] = 0;
                                        }
                                        $finalAmount['totalamount'][$key]+=floatval(str_replace(',','',$value));
                                        ?>
                                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&organizer&1', '?currencycode=' . $key); ?>"><?php echo $key . ' ' . $value . "\n"; ?></a></br>
                                    <?php } }
                                    ?>
                                </td>
                            <?php } else {
                                ?> <td>0</td><?php }
                            ?>
                        </tr>
                    <?php }
                    ?>
                        
                        
                    
                    <?php //disabled 
                    if (!isset($salesData['affiliate'])) { ?>
                        <tr>
                            <td>Global Affiliate Marketing Sales</td>
                            <?php
                            if ($salesData['affiliate']['totalquantity'] > 0) {
                                $finalAmount['totalquantity']+=$salesData['affiliate']['totalquantity'];
                                ?>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&globalaffiliate&1', '?promotercode=promoter'); ?>"><?php echo $salesData['affiliate']['totalquantity']; ?></a></td>
                            <?php } else { ?>
                                <td>0</td>
                                <?php
                            }
                            if (is_array($salesData['affiliate']['totalpaidamount'])) {
                                ?>
                                <td><?php
                                    foreach ($salesData['affiliate']['totalpaidamount'] as $key => $value) {
                                        if (strpos($key, 'quantity') !== false) {}else{
                                        if (!isset($finalAmount['totalamount'][$key])) {
                                            $finalAmount['totalamount'][$key] = 0;
                                        }
                                        $finalAmount['totalamount'][$key]+=floatval(str_replace(',','',$value));
                                        ?>
                                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&globalaffiliate&1', '?promotercode=promoter&currencycode=' . $key); ?>"><?php echo $key . ' ' . $value . "\n"; ?></a></br>
                                    <?php } }
                                    ?>
                                </td>
                            <?php } else {
                                ?> <td>0</td><?php }
                            ?>
                        </tr>
                    <?php }
                    ?>    
                        
                        

                    <?php if (isset($salesData['promoter'])) { ?>
                        <tr>
                            <td>Affiliate Marketing Sales</td>
                            <?php
                            if ($salesData['promoter']['totalquantity'] > 0) {
                                $finalAmount['totalquantity']+=$salesData['promoter']['totalquantity'];
                                ?>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&affiliate&1', '?promotercode=promoter'); ?>"><?php echo $salesData['promoter']['totalquantity']; ?></a></td>
                            <?php } else { ?>
                                <td>0</td>
                                <?php
                            }
                            if (is_array($salesData['promoter']['totalpaidamount'])) {
                                ?>
                                <td><?php
                                    foreach ($salesData['promoter']['totalpaidamount'] as $key => $value) {
                                        if (strpos($key, 'quantity') !== false) {}else{
                                        if (!isset($finalAmount['totalamount'][$key])) {
                                            $finalAmount['totalamount'][$key] = 0;
                                        }
                                        $finalAmount['totalamount'][$key]+=floatval(str_replace(',','',$value));
                                        ?>
                                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&affiliate&1', '?promotercode=promoter&currencycode=' . $key); ?>"><?php echo $key . ' ' . $value . "\n"; ?></a></br>
                                    <?php } }
                                    ?>
                                </td>
                            <?php } else {
                                ?> <td>0</td><?php }
                            ?>
                        </tr>
                    <?php }
                    ?>
                    <?php if (isset($salesData['offlinepromoter'])) { ?>
                        <tr>
                            <td>Offline Promoter Sales</td>
                            <?php
                            if ($salesData['offlinepromoter']['totalquantity'] > 0) {
                                $finalAmount['totalquantity']+=$salesData['offlinepromoter']['totalquantity'];
                                ?>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&offline&1'); ?>"><?php echo $salesData['offlinepromoter']['totalquantity']; ?></a></td>
                            <?php } else { ?>
                                <td>0</td>
                                <?php
                            }
                            if (is_array($salesData['offlinepromoter']['totalpaidamount'])) {
                                ?>
                                <td><?php
                                    foreach ($salesData['offlinepromoter']['totalpaidamount'] as $key => $value) {
                                        if (strpos($key, 'quantity') !== false) {}else{
                                        if (!isset($finalAmount['totalamount'][$key])) {
                                            $finalAmount['totalamount'][$key] = 0;
                                        }
                                        $finalAmount['totalamount'][$key]+=floatval(str_replace(',','',$value));
                                        ?>
                                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&offline&1', '?currencycode=' . $key); ?>"><?php echo $key . ' ' . $value . "\n"; ?></a></br>
                                    <?php } }
                                    ?>
                                </td>
                            <?php } else {
                                ?> <td>0</td><?php }
                            ?>
                        </tr>
                    <?php }
                    ?>       
                    <?php if (isset($salesData['boxoffice'])) { ?>
                        <tr>
                            <td>Box Office Sales</td>
                            <?php
                            if ($salesData['boxoffice']['totalquantity'] > 0) {
                                $finalAmount['totalquantity']+=$salesData['boxoffice']['totalquantity'];
                                ?>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&boxoffice&1'); ?>"><?php echo $salesData['boxoffice']['totalquantity']; ?></a></td>
                            <?php } else { ?>
                                <td>0</td>
                                <?php
                            }
                            if (is_array($salesData['boxoffice']['totalpaidamount'])) {
                                ?>
                                <td><?php
                                    foreach ($salesData['boxoffice']['totalpaidamount'] as $key => $value) {
                                        if (strpos($key, 'quantity') !== false) {}else{
                                        if (!isset($finalAmount['totalamount'][$key])) {
                                            $finalAmount['totalamount'][$key] = 0;
                                        }
                                        $finalAmount['totalamount'][$key]+=floatval(str_replace(',','',$value));
                                        ?>
                                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&boxoffice&1', '?currencycode=' . $key); ?>"><?php echo $key . ' ' . $value . "\n"; ?></a></br>
                                    <?php } }
                                    ?>
                                </td>
                            <?php } else {
                                ?> <td>0</td><?php }
                            ?>
                        </tr>
                    <?php }
                    ?>
                        <?php if (isset($salesData['spotregistration'])) { ?>
                        <tr>
                            <td>Spot Registration</td>
                            <?php
                            if ($salesData['spotregistration']['totalquantity'] > 0) {
                                $finalAmount['totalquantity']+=$salesData['spotregistration']['totalquantity'];
                                ?>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&spotregistration&1'); ?>"><?php echo $salesData['spotregistration']['totalquantity']; ?></a></td>
                            <?php } else { ?>
                                <td>0</td>
                                <?php
                            }
                            if (is_array($salesData['spotregistration']['totalpaidamount'])) {
                                ?>
                                <td><?php
                                    foreach ($salesData['spotregistration']['totalpaidamount'] as $key => $value) {
                                        if (strpos($key, 'quantity') !== false) {}else{
                                        if (!isset($finalAmount['totalamount'][$key])) {
                                            $finalAmount['totalamount'][$key] = 0;
                                        }
                                        $finalAmount['totalamount'][$key]+=floatval(str_replace(',','',$value));
                                        ?>
                                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&spotregistration&1', '?currencycode=' . $key); ?>"><?php echo $key . ' ' . $value . "\n"; ?></a></br>
                                    <?php } }
                                    ?>
                                </td>
                            <?php } else {
                                ?> <td>0</td><?php }
                            ?>
                        </tr>
                    <?php }
                    ?>
                        
                    <?php if (isset($salesData['viral'])) { ?>
                        <tr>
                            <td>Viral Ticketing Sales</td>
                            <?php
                            if ($salesData['viral']['totalquantity'] > 0) {
                                $finalAmount['totalquantity']+=$salesData['viral']['totalquantity'];
                                ?>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&viral&1'); ?>"><?php echo $salesData['viral']['totalquantity']; ?></a></td>
                            <?php } else { ?>
                                <td>0</td>
                                <?php
                            }
                            if (is_array($salesData['viral']['totalpaidamount'])) {
                                ?>
                                <td><?php
                                    foreach ($salesData['viral']['totalpaidamount'] as $key => $value) {
                                        if (strpos($key, 'quantity') !== false) {}else{
                                        if (!isset($finalAmount['totalamount'][$key])) {
                                            $finalAmount['totalamount'][$key] = 0;
                                        }
                                        $finalAmount['totalamount'][$key]+=floatval(str_replace(',','',$value));
                                        ?>
                                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&viral&1', '?currencycode=' . $key); ?>"><?php echo $key . ' ' . $value . "\n"; ?></a></br>
                                    <?php } }
                                    ?>
                                </td>
                            <?php } else {
                                ?> <td>0</td><?php }
                            ?>
                        </tr>
                    <?php }
                    ?>
                    <?php if (isset($salesData['meraevents'])) { ?>
                        <tr>
                            <td>MeraEvents Sales</td>
                            <?php
                            if ($salesData['meraevents']['totalquantity'] > 0) {
                                $finalAmount['totalquantity']+=$salesData['meraevents']['totalquantity'];
                                ?>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&meraevents&1'); ?>"><?php echo $salesData['meraevents']['totalquantity']; ?></a></td>
                            <?php } else { ?>
                                <td>0</td>
                                <?php
                            }
                            if (is_array($salesData['meraevents']['totalpaidamount'])) {
                                ?>
                                <td><?php
                                    foreach ($salesData['meraevents']['totalpaidamount'] as $key => $value) {
                                        if (strpos($key, 'quantity') !== false) {}else{
                                        if (!isset($finalAmount['totalamount'][$key])) {
                                            $finalAmount['totalamount'][$key] = 0;
                                        }
                                        $finalAmount['totalamount'][$key]+=floatval(str_replace(',','',$value));
                                        ?>
                                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report', $eventId . '&summary&meraevents&1', '?currencycode=' . $key); ?>"><?php echo $key . ' ' . $value . "\n"; ?></a></br>
                                    <?php } }
                                    ?>
                                </td>
                            <?php } else {
                                ?> <td>0</td><?php }
                            ?>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>
                                <?php if ($finalAmount['totalquantity'] > 0) { ?>
                                    <?php echo $finalAmount['totalquantity']; ?>
                                    <?php
                                } else {
                                    echo '0';
                                }
                                ?>
                            </strong></td>
                        <td><strong>
                                <?php if (is_array($finalAmount['totalamount'])) { ?>
                                    <?php foreach ($finalAmount['totalamount'] as $key => $value) { if($key!=''){ ?>
                                        <?php 
                                        if($key=='USD'){
                                        echo $key . ' ' . $value . "</br>";     
                                        }else{
                                        echo $key . ' ' . number_format($value) . "</br>"; 
                                        }
                                        ?>
                                    <?php }
                                    }
                                } else {
                                    echo '0';
                                }
                                ?>
                            </strong></td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
    </div>