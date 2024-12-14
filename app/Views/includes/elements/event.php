<script type="text/javascript">
var dashboard_eventhome = "<?= site_url('dashboard/eventhome') ?>";
var add_bookmark = "<?= site_url('api/bookmarks/add') ?>";
var remove_bookmark = "<?= site_url('api/bookmarks/remove') ?>";
//variable for detecting page of bookmark view
var bookmark_page = "<?= $bookmark_page ?? false ?>";
var page = parseInt("<?= $eventsList['page'] ?? 1 ?>");
var bookmark_count = parseInt("<?= $eventsList['total'] ?? 0 ?>");
</script>
<?php
$id = $eventList[$key]['id'] ?? '';
$bookmarked = $eventList[$key]['bookMarked'] ?? false;
$eventUrl = $eventList[$key]['eventUrl'] ?? '';
$title = $eventList[$key]['title'] ?? '';
$thumbImage = $eventList[$key]['thumbImage'] ?? '';
$defaultThumbImage = $eventList[$key]['defaultThumbImage'] ?? site_url('assets/images/default-event-thumb.jpg');
$startDate = $eventList[$key]['startDate'] ?? date('Y-m-d H:i:s');
$endDate = $eventList[$key]['endDate'] ?? '';
$venueName = $eventList[$key]['venueName'] ?? '';
$cityName = $eventList[$key]['cityName'] ?? '';
$defaultCityName = $eventList[$key]['defaultCityName'] ?? 'All Cities';

if($venueName == 'Live'){
    $cityName = 'Online';
}

$eventUrl = isset($eventList[$key]['eventExternalUrl']) && !empty($eventList[$key]['eventExternalUrl']) 
    ? $eventList[$key]['eventExternalUrl'] 
    : ($eventList[$key]['eventUrl'] ?? '#');
$categoryName = $eventList[$key]['categoryName'] ?? 'General';
$masterEvent = $eventList[$key]['masterEvent'] ?? false;
?>
<li class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbBlock bookmarkid_<?= $id ?>">
    <div class="event-box-shadow">
        <a href="<?= $eventUrl ?>" class="thumbnail">
            <div class="eventImg">
                <img src="<?= $thumbImage ?>" width="" height=""
                     alt="<?= $title ?>" title="<?= $title ?>" 
                     onerror="this.src='<?= $defaultThumbImage ?>'; this.onerror = null" />
            </div>
            <div class="eventpadding">
                <h2>
                    <span class="eveHeadWrap"><?= $title ?></span>
                </h2>
                <div class="info">
                    <?php if($masterEvent == false): ?>
                        <span content="<?= $startDate ?>"><i class="icon2-calendar-o"></i> <?= allTimeFormats($startDate, 15) ?></span>
                    <?php else: ?>
                        <span><i class="icon2-calendar-o"></i> Multiple Dates</span>
                    <?php endif; ?>
                </div>
                <div class="eventCity" style="display: <?= ($defaultCityName == 'All Cities' ? 'block' : 'none') ?>;">
                    <span><?= $cityName ?></span>
                </div>
            </div>
        </a> 
        <a href="<?= $eventUrl ?>" class="category">
            <span class="mecat-<?= strtolower(preg_replace("/[^a-zA-Z]/", "", $categoryName)) ?> col<?= strtolower(preg_replace("/[^a-zA-Z]/", "", $categoryName)) ?>"></span> 
            <span class="catName"><em><?= $categoryName ?></em></span>
        </a>
        <span event_id="<?= $id ?>" 
              class="<?= $bookmarked ? 'add_bookmark icon2-bookmark' : 'icon2-bookmark-o add_bookmark' ?>"
              rel="<?= $bookmarked ? 'remove' : 'add' ?>"
              title="<?= $bookmarked ? 'Remove bookmark' : 'Add bookmark' ?>">
        </span>
    </div>
</li>