<?php
$locality = $urlExtension  = $firstsegment = $secondsegment = "";
if ($defaultCityName == LABEL_ALL_CITIES) { $locality = $defaultCountryName; }
else { $locality = $defaultCityName; }//$urlExtension = "/" . $locality . "-Events";}
$firstsegment = $this->uri->segment(1);
$secondsegment = $this->uri->segment(2);
$cityName = str_replace('-events','', $firstsegment);
?>
<?php if($cityName == "") { ?>
<script type="application/ld+json">
{
    "name" : "MeraEvents",
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "<?php echo $this->config->item('protocol'); ?><?php echo getenv('HTTP_HOST');?>/",
    "logo": "<?php echo $this->config->item('protocol'); ?><?php echo getenv('HTTP_HOST');?>/images/static/me-logo.svg",
    "contactPoint": [
        {
            "@type": "ContactPoint",
            "telephone": "040-49171447",
            "contactType": "customer service",
            "areaServed": "India"
        }
    ],
    "sameAs" : [
        "https://www.facebook.com/meraeventsindia",
        "https://twitter.com/MeraEventsIndia",
        "https://www.linkedin.com/company/meraevents",        
        "https://www.youtube.com/channel/UCIssSCbUxybJ3cHoMnExdDg",
        "https://instagram.com/meraeventsindia",
        "https://www.pinterest.com/meraevents/"
    ]
}
</script>
<?php } ?>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    "name" : "MeraEvents",
    "url": "<?php echo $this->config->item('protocol'); ?><?php echo getenv('HTTP_HOST');?><?php echo $urlExtension; ?>",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "<?php echo $this->config->item('protocol'); ?><?php echo getenv('HTTP_HOST');?>/search?keyword={search_term}",
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
    "@id": "<?php echo $this->config->item('protocol'); ?><?php echo getenv('HTTP_HOST');?>",
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
     "@id": "<?php echo $this->config->item('protocol'); ?><?php echo getenv('HTTP_HOST');?><?php echo "/".$breadCrumb; ?>",
     "name": "<?php echo ucfirst($cityName); ?> "
   }
  }
<?php } if ($secondsegment != "") { ?>
  ,
  {
   "@type": "ListItem",
  "position": 3,
  "item":
   {
     "@id": "<?php echo $this->config->item('protocol'); ?><?php echo getenv('HTTP_HOST');?><?php echo "/".$firstsegment."/".$secondsegment; ?>",
     "name": "<?php echo ucfirst($secondsegment); ?>"
   }
  }
<?php } ?>
 ]
}
</script>
<script>
    var recommendedEventsIds=[];
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
                        <?php
                        include("includes/elements/home_filter.php"); ?>
			<!--carousal-->
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<?php $this->load->view('includes/top_banner'); ?>
                        </div>
			<!--EO carousal-->
			<div class="clearfix"></div>
                        <?php if($this->config->item('recommendationsEnable')){?>
                        <div class="row">
				<h3 class="subHeadingFont" id="eventCaption" <?php  // && $eventsList['nextPage'] ?>>
                                    <span id="recommendedTextSpan">Recommended Events</span>
                                    <input type="hidden" value="<?php echo $totalRecommendedResultCount; ?>" id="totalRecommendedResultCount" />
				</h3>
				 <ul id="eventRecommendedThumbs" class="eventThumbs">
                                        <?php
                                            $eventsListOnly =  $eventsRecommendedList['eventList'];
                                            foreach($eventsListOnly as $key=>$eventData) {
                                                $eventData['eventList']=$eventsListOnly;
                                                $eventData['key']=$key; ?>
                                     <script>
                                         recommendedEventsIds.push('<?php echo $eventData['id'];;?>');
                                    </script>
                                              <?php  $this->load->view('includes/elements/event', $eventData); 
                                            }  
                                        ?>   
                                
                                   </ul>   
                                <div id="noRecommendedRecords"></div>
				<div class="clearBoth"></div>
                                <div class="alignCenter" style="position: relative;">
					<a ng-click="getMoreRecommendedEvents()" id="viewMoreRecommendedEvents"
					   class="btn btn-primary borderGrey collapsed"
					   data-wipe="View More Events" style="position: relative; display:<?php echo (count($eventsRecommendedList) > 0 && $eventsRecommendedList['nextPage'])?"inline-block":"none";?>"
					   data-toggle="collapse" href="#popularEvents"
					   aria-expanded="false" aria-controls="popularEvents">
						More Recommended Events </a>
				</div>
                                <div id="noMoreRecommendedEvents" style="position: relative;  text-align: center;display:<?php echo ( count($eventsRecommendedList) > 0 && $eventsRecommendedList['nextPage'])?" none":"block";?>;"  >
                                    <a id="returnToTopRecom" href="javascript:;" class="returnToTop"
                                                   style="font-size: 20px;  font-weight: normal;display:<?php if(count($eventsRecommendedList) > 0 && $eventsRecommendedList['nextPage']){echo "none";}else{echo 'block';}?>;">Please return to top</a>
					</div>
									   <input type="hidden" id="currentRecommendedPage" value="<?php echo $recommendedPage+1;?>">
                                        <input type="hidden" id="currentRecommendedLimit" value="<?php echo $recommendedLimit;?>">
			</div>
                        <?php } ?>
                        <!--<div style="width: 30px;">&nbsp;</div>-->
                        	
			<div class="row">
				<h3 class="subHeadingFont" id="eventCaption" <?php  // && $eventsList['nextPage'] ?>>
					<span>Upcoming Events </span>
                                    <input type="hidden" value="<?php echo $totalResultCount; ?>" id="totalResultCount" />
				</h3>
				<div id="selectedFilter" class="hidden-lg hidden-md hidden-sm row">
					<div class="tags filterCity col-xs-4"><span class="pull-right">X</span>Bengaluru </div>
					<div class="tags filterCat col-xs-4"><span class="pull-right">X</span>Professional </div>
					<div class="tags filterDate col-xs-4"><span class="pull-right">X</span> Tomorrow </div>
				</div>
				 <ul id="eventThumbs" class="eventThumbs">
                                <?php if(count($eventsList) > 0 ) { ?>
                                        <?php
                                            $eventsListOnly =  $eventsList['eventList'];
                                            foreach($eventsListOnly as $key=>$eventData) {
                                                $eventData['eventList']=$eventsListOnly;
                                                $eventData['key']=$key;
                                                $this->load->view('includes/elements/event', $eventData); 
                                            }  
                                        ?>   
                                <?php }  ?>	
                                   </ul>   
                                <div id="noRecords"></div>
				<div class="clearBoth"></div>
                                <div class="alignCenter" style="position: relative;">
					<a ng-click="getMoreEvents()" id="viewMoreEvents"
					   class="btn btn-primary borderGrey collapsed"
					   data-wipe="View More Events" style="position: relative; display:<?php echo (count($eventsList) > 0 && $eventsList['nextPage'])?"inline-block":"none";?>"
					   data-toggle="collapse" href="#popularEvents"
					   aria-expanded="false" aria-controls="popularEvents">
						More Events </a>
				</div>
                                <div id="noMoreEvents" style="position: relative;  text-align: center;display:<?php echo ( count($eventsList) > 0 && $eventsList['nextPage'])?" none":"block";?>;"  >
						<a id="returnToTop" href="javascript:;"
						   style="font-size: 20px;  font-weight: normal;" <?php if (count($eventsList) > 0) {echo 'style="display:block"';}else{ echo 'style="display:none;"';}?>>Please return to top</a>
					</div>
									   <input type="hidden" id="currentPage" value="<?php echo $page+1;?>">
                                        <input type="hidden" id="currentLimit" value="<?php echo $limit;?>">
			</div>
		</div>
		<?php include_once('includes/events_happening.php');?>
		 <div id="bottomBanner" class="container well" >
            <?php $this->load->view('includes/bottom_banner'); ?> 
                        </div>
            </div>
		<!--Create Event-->
		<div class="container-fluid bgRed colorWhite createEvent">
			<h3>host your event and turn your passion into business</h3>
			<div class="alignCenter">
				<!--<button class="btn btn-primary borderWhite">create event now</button>-->
				<a href="<?php echo commonHelperGetPageUrl('create-event');?>" class="btn btn-success borderWhite"
				   data-wipe="create event now" style="position: relative">
					create event </a>
			</div>
		</div>
		<!--EO Create Event -->
		<!-- blog -->
                                        <?php $this->load->view('includes/blog_feed'); ?>
		<!-- EO blog-->
</div>
                        <?php
                        include("includes/elements/home_scroll_filter.php"); ?>
				</div>
			</div>
<!-- Modal -->
<script>
   var api_commonRequestProcessRequest = "<?php echo commonHelperGetPageUrl('api_commonRequestProcessRequest')?>";
   var api_subcategoryEventsCount = "<?php echo commonHelperGetPageUrl('api_subcategoryEventsCount')?>";
   var api_cityEventsCount = "<?php echo commonHelperGetPageUrl('api_cityEventsCount')?>";
   var api_categoryEventsCount = "<?php echo commonHelperGetPageUrl('api_categoryEventsCount')?>";
   var api_filterEventsCount = "<?php echo commonHelperGetPageUrl('api_filterEventsCount')?>";
   var api_categorycityEventsCount = "<?php echo commonHelperGetPageUrl('api_categorycityEventsCount')?>";
   var api_subcategorycityEventsCount = "<?php echo commonHelperGetPageUrl('api_subcategorycityEventsCount')?>";
   var api_bannerList = "<?php echo commonHelperGetPageUrl('api_bannerList')?>";
   var api_eventList = "<?php echo commonHelperGetPageUrl('api_eventList')?>";
   var api_eventPiwikList = "<?php echo commonHelperGetPageUrl('api_eventPiwikList')?>";
   var api_blogBloglist = "<?php echo commonHelperGetPageUrl('api_blogBloglist')?>";
   var api_catgBlogData = "<?php echo commonHelperGetPageUrl('api_catgBlogData')?>";
   var displayPiwikLimit = "<?php echo DEFAULT_EVENTS_DISPLAY;?>";
</script>