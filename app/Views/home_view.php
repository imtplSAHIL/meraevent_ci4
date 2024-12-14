<?php 
$locality = $urlExtension = "";
if ($defaultCityName == LABEL_ALL_CITIES) { 
    $locality = $defaultCountryName; 
} else { 
    $locality = $defaultCityName; 
}

// Using the segments passed from the controller
$cityName = $firstsegment ? str_replace('-events', '', $firstsegment) : "";
?>
<?php if($cityName == "") { ?>
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "<?= rtrim(site_url(), "/") ?>",
    "logo": "<?= site_url('images/static/me-logo.svg') ?>",
    "name" : "MeraEvents",
	"sameAs" : [
        "https://www.facebook.com/meraeventsindia",
        "https://twitter.com/MeraEventsIndia",
        "https://www.linkedin.com/company/meraevents",        
        "https://www.youtube.com/channel/UCIssSCbUxybJ3cHoMnExdDg",
        "https://instagram.com/meraeventsindia",
        "https://www.pinterest.com/meraevents/"
    ],
    "contactPoint": [
        {
            "@type": "ContactPoint",
            "telephone": "<?php $mobile = str_replace("-", " ", GENERAL_INQUIRY_MOBILE); echo ($mobile[0] == 0) ? '+91'.ltrim($mobile,"0") : $mobile; ?>",
            "contactType": "customer service",
			"areaServed" : "IN",
			"availableLanguage" : ["English"]
        }
    ]
}
</script>
<?php } ?>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    "name" : "MeraEvents",
    "url": "<?= site_url() ?>",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "<?= site_url() ?>search?keyword={search_term}",
        "query-input": "required name=search_term"
    }
}
</script>

<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "BreadcrumbList",
 "itemListElement":
 [
  {
   "@type": "ListItem",
   "position": 1,
   "item":
   {
    "@id": "<?= site_url() ?>",
    "name": "Event Tickets"
    }
  }
  <?php if ($firstsegment != "") { ?>
  ,
  {
   "@type": "ListItem",
  "position": 2,
  "item":
   {
     "@id": "<?= site_url().$breadCrumb ?>",
     "name": "<?= ucfirst($cityName) ?> "
   }
  }
<?php } if ($secondsegment != "") { ?>
  ,
  {
   "@type": "ListItem",
  "position": 3,
  "item":
   {
     "@id": "<?= site_url().$firstsegment."/".$secondsegment ?>",
     "name": "<?= ucfirst($secondsegment) ?>"
   }
  }
<?php } ?>
 ]
}
</script>
<!--important-->
<div ng-controller="filterController">
<div class="page-container" >
	<div class="wrap">
		<div class="container HomeContainer">
			<!-- Main component for a primary marketing message or call to action -->
			<div class="search-container searchABC">
				<input class="search form-control searchExpand icon-me_search"
					   id="searchId" type="search"
					   placeholder="Search by Event Name , Event ID , Kyey Words">
<a class="search icon-me_search"></a>
			</div>
                        <?= view('includes/elements/home_filter.php') ?>
			<!--carousal-->
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <?= view('includes/top_banner') ?>
                        </div>
			<!--EO carousal-->
			<div class="clearfix"></div>
			
		</div>
    </div>
    <section class="eventlist">
      <div class="container HomeContainer mt-zero">
        
      <div class="row">
        <h3 class="subHeadingFont" id="eventCaption" <?php  // && $eventsList['nextPage'] ?>>
          <span>Upcoming Events </span>
        </h3>
        <div id="selectedFilter" class="hidden-lg hidden-md hidden-sm row">
          <div class="tags filterCity col-xs-4"><span class="pull-right">X</span>Bengaluru </div>
          <div class="tags filterCat col-xs-4"><span class="pull-right">X</span>Professional </div>
          <div class="tags filterDate col-xs-4"><span class="pull-right">X</span> Tomorrow </div>
        </div>
         <ul id="eventThumbs" class="eventThumbs">
            <?php if(!empty($eventsList) && !empty($eventsList['eventList'])): ?>
                <?php
                $eventsListOnly = $eventsList['eventList'];
                foreach($eventsListOnly as $key => $eventData):
                    $eventData['eventList'] = $eventsListOnly;
                    $eventData['key'] = $key;
                    echo view('includes/elements/event', $eventData);
                endforeach;
                ?>
            <?php else: ?>
                <li class="no-events">
                    <div class="alert alert-info">
                        No events found. Please try different filters.
                    </div>
                </li>
            <?php endif; ?>
        </ul>
        <div id="noRecords"></div>
        <div class="clearBoth"></div>
                                <div class="alignCenter" style="position: relative;">
          <a ng-click="getMoreEvents()" id="viewMoreEvents"
             class="btn btn-primary borderGrey collapsed"
             data-wipe="View More Events" style="position: relative; display:<?php echo (is_array($eventsList) && !empty($eventsList['eventList']) && isset($eventsList['nextPage'])) ? "inline-block" : "none"; ?>"
             data-toggle="collapse" href="#popularEvents"
             aria-expanded="false" aria-controls="popularEvents">
            More Events </a>
        </div>
                                <div id="noMoreEvents" style="position: relative; text-align: center; display:<?php echo (is_array($eventsList) && !empty($eventsList['eventList']) && isset($eventsList['nextPage'])) ? "none" : "block"; ?>;">
            <a id="returnToTop" href="javascript:;"
               style="font-size: 20px;  font-weight: normal;" <?php if (isset($eventsList) && is_array($eventsList) && count($eventsList) > 0) {echo 'style="display:block"';}else{ echo 'style="display:none;"';}?>>Please return to top</a>
          </div>
                     <input type="hidden" id="currentPage" value="<?php echo isset($page) ? $page : 1; ?>">
                                        <input type="hidden" id="currentLimit" value="<?php echo isset($limit) ? $limit : 12; ?>">
      </div>  
      </div>
    </section>
    <div class="container HomeContainer">
		
		 <div id="bottomBanner" class="container well" >
             
                        </div>
            </div>
		<!--Create Event-->
		<div class="container-fluid bgRed colorWhite createEvent">
			<h3>host your event and turn your passion into business</h3>
			<div class="alignCenter">
				<!--<button class="btn btn-primary borderWhite">create event now</button>-->
				<a href="" class="btn btn-success borderWhite"
				   data-wipe="create event now" style="position: relative">
					create event </a>
			</div>
		</div>
		<!--EO Create Event -->
		<!-- blog -->
        
		<!-- EO blog-->
        
        <?php
		//code related to seo page description, if set for this url
		if(isset($pageDescription) && strlen(trim($pageDescription)) > 0){
			?>
            <div class="container-fluid bgAsh">
            	<div  class="eventDetails pageDescContainer">
                <?= stripslashes(trim($pageDescription)) ?>
                </div>
            </div>
            <?php
		}
		?>
        
</div>
                        <?= view('includes/elements/home_scroll_filter.php') ?>
				</div>
			</div>
<!-- Modal -->
<script>
   var api_commonRequestProcessRequest = "<?= commonHelperGetPageUrl('api_commonRequestProcessRequest')?>";
   var api_subcategoryEventsCount = "<?= commonHelperGetPageUrl('api_subcategoryEventsCount')?>";
   var api_cityEventsCount = "<?= commonHelperGetPageUrl('api_cityEventsCount')?>";
   var api_categoryEventsCount = "<?= commonHelperGetPageUrl('api_categoryEventsCount')?>";
   var api_filterEventsCount = "<?= commonHelperGetPageUrl('api_filterEventsCount')?>";
   var api_categorycityEventsCount = "<?= commonHelperGetPageUrl('api_categorycityEventsCount')?>";
   var api_subcategorycityEventsCount = "<?= commonHelperGetPageUrl('api_subcategorycityEventsCount')?>";
   var api_bannerList = "<?= commonHelperGetPageUrl('api_bannerList')?>";
   var api_eventList = "<?= commonHelperGetPageUrl('api_eventList')?>";
   var api_blogBloglist = "<?= commonHelperGetPageUrl('api_blogBloglist')?>";
   var api_catgBlogData = "<?= commonHelperGetPageUrl('api_catgBlogData')?>";
</script>

<script type="application/ld+json">
<?php 
if( defined('IS_CRAWLER') && IS_CRAWLER && count($eventsList) > 0 ) {
	?>
	[
		<?php
		$eventsData =  $eventsList['eventList'];
		$eventsDataCount = count($eventsData);
		$evCnt = 0;
        foreach($eventsData as $ekey=>$eventValue) {
			$eventDesc = (strlen(trim($eventValue['description'])) > 0)?str_replace('"',"'",$eventValue['description']):$eventValue['title'];
			$doorTimeEx = explode(" ",$eventValue['startDate']);
			$doorTime = $doorTimeEx[1];
			?>
			{
				"@context":"http://schema.org",
				"@type":"Event",
				"name":"<?= $eventValue['title'] ?>",
				"description": <?= json_encode(strip_tags(stripslashes($eventDesc))) ?>,
				"image":"<?= $eventValue['thumbImage'] ?>",
				"url":"<?= $eventValue['eventUrl'] ?>",
				"startDate":"<?= $eventValue['startDate'] ?>",
				"endDate":"<?= $eventValue['endDate'] ?>",
				"doorTime":"<?= $doorTime ?>",
				"location":{
					"@type":"EventVenue",
					"name":"<?= $eventValue['venueName'].': '.$eventValue['cityName'] ?>",
					"address": <?= json_encode(stripslashes($eventValue['venueAddress'].' '.$eventValue['cityName'].', '.$eventValue['countryName']))?>
				},
        "offers":[
                <?php $rows=1; foreach($ticketDetial[$eventValue['id']] as $ticket){?>

                        {
                            "@type":"Offer",
                            "name": "<?= $ticket['name'] ?>", 
                            "price":"<?= $ticket['price'] ?>",
                            "priceCurrency":"<?= (empty($ticket['currencyCode']))?'INR':$ticket['currencyCode'] ?>", 
                            "availability": "<?= ($ticket['soldout']==0 /*&& $ticket['pastTicket'] !=1 && $ticket['upcomingTicket'] !=1*/ )?'http://schema.org/InStock':'http://schema.org/SoldOut'?>", 
                            "url":"<?= $eventValue['eventUrl'] ?>",
                            "validFrom":"<?= appendTimeZone($ticket['startdatetime'],$eventValue['timeZone'],TRUE)?>"
                            
                        }
                    <?php if($rows<count($ticketDetial[$eventValue['id']])){ echo ',';}$rows++;
                }?> 
        ]
			}
			<?php
			if(++$evCnt !== $eventsDataCount) { echo ","; } 
		}
		?>
	]
	<?php
}
?>
</script>