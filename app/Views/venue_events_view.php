<script type="text/javascript">
var dashboard_eventhome="<?php echo commonHelperGetPageUrl('dashboard-eventhome');?>";
var add_bookmark = "<?php echo commonHelperGetPageUrl('api_add_bookmark'); ?>";
var remove_bookmark = "<?php echo commonHelperGetPageUrl('api_remove_bookmark'); ?>";
var api_eventList = "<?php echo commonHelperGetPageUrl('api_eventList'); ?>";
</script>
<div class="container event_detail_main">
	<div class="col-sm-12 col-xs-12 header_img">
	<?php if(strlen($venueDetails['banner'])>0){?>
		<img src="<?php echo $venueDetails['banner'];?>" alt="<?php echo $venueDetails['name'];?>" title="<?php echo $venueDetails['name'];?>">
	<?php }?>
		<div id="event_div" class="" style="z-index: 99;">
            <div class="row orgbgcolor">
                <div class="img_below_cont ">
                    <h2><?php echo $venueDetails['name']?></h2>
                    <div class="sub_links">
                           <span class="icon-google_map_icon"></span> <span><?php echo $venueDetails['address'];?></span>
                    </div>
                </div>
                  <div class="Org_Rlist orgcontact_sublinks">
                      <?php
                             $tweet =  $title = $venueDetails['name']; 
                                $linkToShare = current_url();
                                $bitlyUrl=getTinyUrl($linkToShare);
                            ?>
                            <span class=""> <a
                                    href="http://www.facebook.com/share.php?u=<?= urlencode($linkToShare) ?>&title=Meraevents -<?= $title ?>"
                                    onClick="javascript: cGA('/event-share-facebook'); return fbs_click('<?= $linkToShare ?>', 'Meraevents - <?= $title ?> ')"
                                    target="_blank"> <i class="icon1 icon1-facebook"></i></a>
                            </span> 
                            <span class=""> <a
                                    onClick="javascript: cGA('/event-share-twitter');"
                                    href="https://twitter.com/share?url=<?= urlencode($linkToShare); ?>&amp;text=Meraevents - <?= $title ?>"
                                    target="_blank" class="nounderline social"> <i
                                            class="icon1 icon1-twitter"></i>
                            </a>
                            </span> 
                            <span class=""> <a
                                    onClick="javascript: cGA('/event-share-linkedin');"
                                    href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($linkToShare) ?>&amp;title=<?php echo $tweet ?>&amp;summary=<?php echo $eventDetails['fullAddress'] ?>&amp;source=Meraevents"
                                    target="_blank" class="nounderline"> <i
                                            class="icon1 icon1-linkedin"></i></a>
                            </span> 
                            <span class=""> <a
                                    href="https://plus.google.com/share?url=<?= urlencode($linkToShare) ?>"
                                    target="_blank"> <i class="icon1 icon1-google-plus"></i>
                            </a>
                            </span>
                </div>  
            </div>

        </div>	
		
		
	</div>
        <div class="col-sm-12 eventDetails" id="event_about"></div>
	<div class="row">
		<div class="event-tabs orgeventtabs">
                    <a id="upcomingeventstab" class="eventsactive">
                        <h4 class="subHeadingFont"><span>Upcoming Events</span></h4>
                    </a>
                </div>
			<input type="hidden" id="page" value="1" />
			<input type="hidden" id="cityUrl" value="<?php echo $cityUrl;?>" />
			<input type="hidden" id="url" value="<?php echo $url;?>" />
			<h4 id="no-events" class="nomorevents" style="display:none;"> No Events Found</h4>
			<ul id="upcoming_events" class="eventThumbs __web-inspector-hide-shortcut__">
                            <?php if(!empty($eventsData)){
                                foreach($eventsData as $key => $eventDetails){?>
                            <li class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbBlock">
                                <div class="event-box-shadow">
                                <a	href="<?php echo $eventDetails['url'];?>" class="thumbnail">
                                    <div class="eventImg">
                                    <img src="<?php echo $eventDetails['thumbImage']?>" width="" height="" alt="<?php echo $eventDetails['title']?>" title="<?php echo $eventDetails['title']?>"
                                            errimg="<?php echo $eventDetails['defaultImage'];?>" onerror="setimage(this)" >
                                    </div>
                                    <div class="eventpadding">
                                    <h6>
                                        <span class="eveHeadWrap"><?php  echo $eventDetails['title']?></span>
                                    </h6>
                                    <div class="info">
                                            <span><i class="icon2-calendar-o"></i> <?php if($eventDetails['masterevent'] == TRUE){ echo "Multiple Dates"; }else{echo $eventDetails['startDateTime'];}?></span>
                                    </div>
                                </div>
                                    <!-- <div class="overlay">
                                            <div class="overlayButt">
                                                    <div class="overlaySocial">
                                                            <span class="icon-fb"></span> <span class="icon-tweet"></span>
                                                            <span class="icon-google"></span>
                                                    </div>
                                            </div>
                                    </div> -->
                                </a>

                                <a href="<?php echo $eventDetails['url'];?>" class="category"> <span class="icon1-<?php echo strtolower(preg_replace("/[^a-zA-Z]/", "",$eventDetails['categoryName']));?> col<?php echo strtolower(preg_replace("/[^a-zA-Z]/", "",$eventDetails['categoryName']));?>"></span>
                                               <span class="catName"><em><?php echo $eventDetails['categoryName'];?></em></span>
                                               
                               </a>
                               <span  event_id="<?php echo $eventDetails['id'];  ?>" <?php if($eventDetails['bookMarked'] == 1){echo " class='add_bookmark icon2-bookmark' rel='remove' title='Remove bookmark'"; }else{echo " class='icon2-bookmark-o add_bookmark'  rel='add' title='Add bookmark' "; }?> >
                            </span>
                                </div>
                            </li>
                            <?php }}else{?>
                                           <div class="text-center"> <h4 id="no-events" > No Events Found</h4> </div>

                            <?php }?>
			</ul>
                    <div class="alignCenter" style="clear:both;display:block;">
                    <a id="viewMore" class="btn btn-primary borderGrey collapsed" <?php if($totalCount <= VENUES_EVENTS_DISPLAY_LIMIT ){?>style="display:none;" <?php }?>>View More</a>
                    </div>

		</div>
    
    	<div class="row">
	<?php if(strlen($venueDetails['information']) > 0){?>
            <h3 class="get_tickts">About <?php echo $venueDetails['name']?></h3>
		<p>
		<?php echo $venueDetails['information'];?>
		</p> 
        <?php }?>
        </div>

		<div class="col-sm-12 eventDetails" id="event_about"></div>
	</div>
</div>
<script>
function setimage(e){
	e.src= $(e).attr('errimg');
    e.onerror = null;
}
                            
var api_getVenueEvents = "<?php echo commonHelperGetPageUrl('api_getVenueEvents')?>";
 </script>
 
 <script type="application/ld+json">
            {
            "@context"      : "http://schema.org",
            "@type"         : "EventVenue",
            "name"          : <?php echo json_encode($venueDetails['name'].': '. $cityName)?>,
            "description"   : <?php echo json_encode($venueDetails['information'])?>,
            "image"         : <?php if(!empty($venueDetails['banner'])){echo json_encode($venueDetails['banner']);}else{echo json_encode($defaultImagePath.'venues/venue-thumb-1.jpg');} ?>,
            "url"           :<?php echo json_encode(current_url()); ?>,
            "address"		:
                    { "@type": "PostalAddress", 
                        "streetAddress"     : <?php echo json_encode($venueDetails['address'])?>, 
                        "addressLocality"   : <?php echo json_encode($cityName); ?> 
                    }
            }
</script>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "<?php echo rtrim(site_url(),"/"); ?>",
    "logo": "<?php echo site_url(); ?>images/static/me-logo.svg",
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


<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    "name" : "MeraEvents",
    "url": "<?php echo site_url(); ?>",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "<?php echo site_url();?>search?keyword={search_term}",
        "query-input": "required name=search_term"
    }
}
</script>

<script type="application/ld+json">
<?php 
if(count($eventsData) > 0 ) {
    ?>
    [
        <?php
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
                "name":"<?php echo $eventValue['title']; ?>",
                "description": <?php echo json_encode(strip_tags(stripslashes($eventDesc))); ?>,
                "image":"<?php echo $eventValue['thumbImage']; ?>",
                "url":"<?php echo $eventValue['url']; ?>",
                "startDate":"<?php echo $eventValue['startDateTime']; ?>",
                "endDate":"<?php echo $eventValue['endDateTime']; ?>",
                "location":{
                    "@type":"EventVenue",
                    "name":<?php echo json_encode($venueDetails['name'].': '. $cityName)?>,
                    "address"       :
                    { "@type": "PostalAddress", 
                        "streetAddress"     : <?php echo json_encode($venueDetails['address'])?>, 
                        "addressLocality"   : <?php echo json_encode($cityName); ?> 
                    }
                }
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