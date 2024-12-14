<div class="clearL"></div>
<div class="rightArea">

    <div class="db-bg-holder">
        <div class="heading float-left">
            <h2><?php echo $chapterDetails['name']; ?></h2>
        </div>
        <div class="fs-settings-buttons">
            <a href="<?php echo commonHelperGetPageUrl('edit-chapter') . "/" . $chapterDetails['id']; ?>"><button type="button" class="Edit-Btn blueborder"><span class="fa fa-edit"></span>Edit</button></a>
            <a href="<?php echo commonHelperGetPageUrl('view-chapter-members') . "/" . $chapterDetails['id']; ?>"><button type="button" class="Edit-Btn blueborder"><span class="fa fa-edit"></span>Manage Chapters</button></a>
        </div>
    </div>
    <div class="db-org-url">
        <p>Link</p>
        <div class="paddingtb10">
            <?php
            $eventUrl = $this->config->item('server_path') . "c/" . $chapterDetails['slug'];
            $tweet = substr($chapterDetails['name'], 0, 100);
            ?>
            <a id="eventURL" href="<?php echo $eventUrl; ?>" target="_blank" class="linkscolor"><span class="mce-ico mce-i-link"></span><?php echo $eventUrl; ?></a>
            <span id="copyEventURL" class="copylink tooltip-bottom hoeverclass" data-tooltip="Copy to Clipboard">Copy Link</span>
            <div class="orglink-share">
                <span class="org-sharetext">Share : </span>
                <a href="http://www.facebook.com/share.php?u=<?= urlencode($eventUrl) ?>&title=Meraevents -<?= $chapterDetails['name'] ?>" target="_blank"><span class="fa fa-facebook"></span></a>
                <a href="#" id="twitterShareUrl" target="_blank"><span class="fa fa-twitter"></span></a>
                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($eventUrl) ?>&amp;title=<?php echo $tweet ?>&amp;source=Meraevents" target="_blank"><span class="fa fa-linkedin"></span></a>
            </div>
        </div>
    </div>

    <div class="clearBoth"></div>
    <!--Graph Section Start-->
    <div class="graphSec">
        <div class="Box1">
            <div class="fixedBox">
                <h2 class="boxborder c2">CHAPTER OVERVIEW</h2>

                <div class="clearBoth"></div>
                <div class="fs-Box1-content">
                    <!--New Code Display-->
                    <div class="db-BoxStats">
                        <div id="ticketAmountDiv">
                            <div class="db-BoxStatsDiv stats-borderright mb-0imp textcenter">
                                <div class="db-BoxStatsInfo">
                                    <span class="labeltext" id="totalRevenueWithCurrency">CHAPTER NAME</span>
                                    <p style="font-size: 14px;">
                                        <?php echo ucfirst($chapterDetails['name']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="db-BoxStatsDiv mb-0imp textcenter">
                            <div class="db-BoxStatsInfo">
                                <span class="labeltext">MEMBERS JOINED</span>
                                <p id="ticketSoldTotal"><span class="fa fa-ticket"></span><?php
                                    if ($membersCount > 0) {
                                        echo $membersCount;
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="db-BoxStatsDiv stats-bordertop stats-borderright mb-0imp textcenter">
                            <div class="db-BoxStatsInfo">
                                <span class="labeltext">TOTAL SALES</span>
                                <p><span class="fa fa-rupee"></span><?php
                                    if ($chapterDetails['totalamount'] > 0) {
                                        echo round($chapterDetails['totalamount']);
                                    } else {
                                        echo '0';
                                    }
                                    ?></p>
                            </div>
                        </div>
                        <div class="db-BoxStatsDiv stats-bordertop mb-0imp textcenter">
                            <div class="db-BoxStatsInfo">
                                <span class="labeltext">NUMBER OF RENEWALS</span>
                                <p id="conversionRate"><span class="fa fa-"></span><?php echo round((isset($eventDetail['viewcount']) && $eventDetail['viewcount'] > 0 && $totalSaleDataAllCurrencies[key($totalSaleData['currencySale']) . 'quantity'] > 0) ? (($totalSaleDataAllCurrencies[key($totalSaleData['currencySale']) . 'quantity'] / $eventDetail['viewcount']) * 100) : 0); ?></p>
                            </div>
                        </div>
                    </div>
                    <!--New Code Display-->
                </div>
            </div>
        </div>
        <!-- Second Row-->
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.hoeverclass').on('mouseout', function () {
            $(this).attr('data-tooltip', 'Copy to Clipboard');
        });
        document.getElementById("copyEventURL").addEventListener("click", function () {
            copyToClipboard(document.getElementById("eventURL"));
            $(this).attr('data-tooltip', 'Link copied to clipboard');
        });
    });
</script>