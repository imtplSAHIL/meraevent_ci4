<?php
$eventId = $eventData['id'];
$configCustomDatemsg = json_decode(CONFIGCUSTOMDATEMSG, true);
$configCustomTimemsg = json_decode(CONFIGCUSTOMTIMEMSG, true);
$configspecialTickets = json_decode(SPECIALTICKETS, true);
$customValidationEventIds = json_decode(CUSTOMVALIDATIONEVENTIDS, true);
$configspecialTickets = isset($configspecialTickets[$eventId]) ? $configspecialTickets[$eventId] : array();
?>
<div style="visibility: hidden; display: none; width: 1170px; height: 128px; margin: 0px; float: none; position: static; top: auto; right: auto; bottom: auto; left: auto;"></div>
<div id="event_div" class="" style="z-index: 99;">
    <div class="row <?php echo preg_replace("/[^a-zA-Z]/", "", strtolower($eventData['categoryName'])); ?>">
        <div class="img_below_cont ">
            <h1><?php echo isset($eventData['title']) ? $eventData['title'] : ''; ?></h1>
            <?php
            if ((isset($eventTicketOptionSettings['eventdatehide']) && $eventTicketOptionSettings['eventdatehide'] == 1) || $eventData['categoryName'] == 'Donations') {
                
            } else {
                ?>
                <div class="sub_links"><span class="icon-calender"></span>                       
                    <?php if ($multiEvent == FALSE) { ?>
                    
                        <?php
                        $sDate = strtotime($eventData['startDate']);
                        $eDate = strtotime($eventData['endDate']);
                        $diff = ($eDate - $sDate)/ (60 * 60 * 24);
                        if($eventData['startDate'] < date() && $diff > 5){
                            echo allTimeFormats(date(), 3) . '-' . allTimeFormats($eventData['endDate'], 3) . " | " . allTimeFormats($eventData['startDate'], 4) . ' to ' . allTimeFormats($eventData['endDate'], 4) . ' ' . $eventData['location']['timezone']; ;
                        }else{
                        if (isset($configCustomDatemsg[$eventId]) && !isset($configCustomTimemsg[$eventId])) {
                            echo $configCustomDatemsg[$eventId] . " | " . allTimeFormats($eventData['startDate'], 4) . ' to ' . allTimeFormats($eventData['endDate'], 4) . ' ' . $eventData['location']['timezone'];
                        } else if (isset($configCustomTimemsg[$eventId]) && !isset($configCustomDatemsg[$eventId])) {
                            echo allTimeFormats($eventData['startDate'], 3);
                            ?><?php
                            if (allTimeFormats($eventData['startDate'], 9) != allTimeFormats($eventData['endDate'], 9)) {
                                echo " - " . allTimeFormats($eventData['endDate'], 3);
                            } echo " | " . $configCustomTimemsg[$eventId];
                        } else if (isset($configCustomTimemsg[$eventId]) && isset($configCustomDatemsg[$eventId])) {
                            echo $configCustomDatemsg[$eventId] . " | " . $configCustomTimemsg[$eventId];
                        } else {
                            echo allTimeFormats($eventData['startDate'], 3);
                            ?><?php
                            if (allTimeFormats($eventData['startDate'], 9) != allTimeFormats($eventData['endDate'], 9)) {
                                echo " - " . allTimeFormats($eventData['endDate'], 3);
                            } echo " | " . allTimeFormats($eventData['startDate'], 4) . ' to ' . allTimeFormats($eventData['endDate'], 4) . ' ' . $eventData['location']['timezone'];
                        }
                    }
                        ?>
                        <?php
                    } else {
                        echo allTimeFormats($eventData['startDate'], 4) . ' to ' . allTimeFormats($eventData['endDate'], 4);
                    }
                    ?>
                </div>
                <?php
            }
            if ((isset($eventTicketOptionSettings['eventlocationhide']) && $eventTicketOptionSettings['eventlocationhide'] == 1) || $eventData['categoryName'] == 'Donations') {
                
            } else {
                ?>
                <div class="sub_links">
                    <span class="icon-google_map_icon"></span>
                    <?php
                    if (isset($eventData['eventMode']) && $eventData['eventMode'] == 1) {
                        echo "<span>Virtual Event</span>";
                    } else if ($eventData['categoryName'] == 'Webinar') {
                        echo "<span>Webinar</span>";
                    } else {
                        echo "<span>" . $eventData['fullAddress'] . "</span>";
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <!-- <div class="Rlist">
            <ul>
                <?php
                if (isset($eventData['description']) && strlen(stripslashes($eventData['description'])) > 990) {
                    $description = substr($eventData['description'], 0, 900) . "...";
                } else {
                    $description = $eventData['description'];
                } $description = urlencode(strip_tags($description));
                ?>
                <li class="<?php echo preg_replace("/[^a-zA-Z]/", "", strtolower($eventData['categoryName'])); ?>"><a class="customAnchor" onclick="setReminder('http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode($eventData['title']); ?>&dates=<?php echo reminderDate($eventData['startDate']) . 'T' . date('His', strtotime($eventData['startDate'])); ?>/<?php echo reminderDate($eventData['endDate']) . 'T' . date('His', strtotime($eventData['endDate'])); ?>&location=<?php echo $eventData['fullAddress']; ?>&details=<?php echo addslashes($description); ?>&trp=false&sprop=&sprop=name:')" target="_blank" rel="nofollow"><span class="icon-alaram_icon"></span>Set Reminder</a></li>
                <?php if (!empty($eventData['fullAddress']) && $eventData['eventMode'] == 0 && $eventData['categoryName'] != 'Donations' && $eventData['categoryName'] != 'Webinar') { ?>
                    <li class="<?php echo preg_replace("/[^a-zA-Z]/", "", strtolower($eventData['categoryName'])); ?>">
                        <a class="customAnchor" onclick="getDirection('<?php echo urlencode($eventData['fullAddress']); ?>');" target="_blank">
                            <span class="icon-google_map_icon"></span>
                            Get Directions
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div> -->
    </div>

</div>
<script>
    function getDirection(address) {
        if (recommendationsEnable) {
            _paq.push(['trackEvent', , 'EventPage', 'Get Directions']);
        }
        window.open('https://maps.google.com/maps?saddr=&daddr=' + address);
    }
    function setReminder(location) {
        if (recommendationsEnable) {
            _paq.push(['trackEvent', , 'EventPage', 'Set Reminder']);
        }
        window.open(location);
    }
</script>
<style>
    .customAnchor:hover{
        cursor: pointer;
    }
</style>
