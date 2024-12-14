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
<!--important-->
<div ng-controller="filterController">
<div class="page-container" >
	<div class="wrap">
		<div class="container HomeContainer">
			<!-- Main component for a primary marketing message or call to action -->
			
                        
			<!--EO carousal-->
			<div class="clearfix"></div>
			<div class="row">
				<h3 class="subHeadingFont" id="eventCaption" <?php  // && $eventsList['nextPage'] ?>>
					<span>Bookmarked Events </span>
				</h3>
				<div class="row">
				
					<a href="<?php echo commonHelperGetPageUrl('bookmarked');?>" class="eventtypes<?php if ($secondsegment=="bookmarked"){echo" eventsactive";}?>"><h4 class="subHeadingFont" id="eventCaption"><span>Upcoming Events</span></h4><a> 
					<a href="<?php echo commonHelperGetPageUrl('pastbookmarked');?>" class="eventtypes<?php if ($secondsegment=="pastbookmarked"){echo" eventsactive";}?>"><h4 class="subHeadingFont" id="eventCaption">
					<span id="past-events-tab">Past Events</span></h4><a>
				</div>
				 <ul id="eventThumbs" class="eventThumbs">
                                <?php if(count($eventsList) > 0 ) { ?>
                                        <?php
                                            $eventsListOnly =  $eventsList['eventList'];
                                            foreach($eventsListOnly as $key=>$eventData) {
                                                $eventData['eventList']=$eventsListOnly;
												$eventData['bookmark_page']=1;
                                                $eventData['key']=$key;
                                                $this->load->view('includes/elements/event', $eventData); 
                                            }  
                                        ?>   
                                <?php }?>
									</ul>
								                 <div id="noRecords"></div>
				<div class="clearBoth"></div>
								
							<div class="alignCenter" style="position: relative;">
					<a  id="viewMorebookmarkEvents" bookmarked_events_ids= <?php echo json_encode($bookmarked_events_ids);?>
					   class=" view btn btn-primary borderGrey collapsed"
					  style="position: relative; display:<?php echo (count($eventsList) > 0&& $eventsList['nextPage'] )?"inline-block":"none";?>"
					   
					   >
						More Events </a>
				</div>
				
                                     
                                
			</div>
		</div>
		<center>
		<div class="no_bookmark_msg">
		<?php 
		if( $eventsList['total']==0)
				{
			           echo $eventsList['messages'][0];
				}
				
		?>
		</div>
		</center>
		
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
   var api_morebookmark = "<?php if($eventtype=="upcomming"){echo commonHelperGetPageUrl('api_eventList');}if($eventtype=="past"){echo commonHelperGetPageUrl('api_pasteventList');}?>";
   var api_blogBloglist = "<?php echo commonHelperGetPageUrl('api_blogBloglist')?>";
   var api_catgBlogData = "<?php echo commonHelperGetPageUrl('api_catgBlogData')?>";
</script>