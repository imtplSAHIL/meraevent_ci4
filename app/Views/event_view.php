<!--Event_banner-->
<div class="container event_detail_main">
    <div class="col-sm-12 col-xs-12 header_img">

        <img src="<?php echo $eventData['bannerPath']; ?>" title="<?php echo $eventData['title'] . ', ' . $eventData['location']['cityName']; ?>" alt="<?php echo $eventData['eventDetails']['seodescription']; ?>" onError="this.src='<?php echo $eventData['defaultBannerImage']; ?>'; this.onerror = null">
        <?php include_once('includes/elements/event_detail_top.php'); ?>
        <?php $limitSingleTicketType = $eventData['eventDetails']['limitSingleTicketType']; ?>
        <input type="hidden" name="limitSingleTicketType" id="limitSingleTicketType" value="<?php echo $limitSingleTicketType; ?>">
        <input type="hidden" name="pageType" id="pageType" value="<?php echo $pageType; ?>">

        <div class="event_toggle">
            <div class="row eventDetails" id="event_tickets">
                <p>&nbsp;</p>
                <?php include_once('includes/elements/event_tickets.php'); ?>
                <div class="col-sm-4 col-xs-12 col-md-3 col-md-offset-1">
                    <div class="eventid"><a>Event ID : <?php echo $eventData['id']; ?></a></div>
                    <div class="invite_subcont">
                        <div class="inviteFriend">
                            <h4><?php if (isset($globalPromoterCode) && !empty($globalPromoterCode)) { ?>Affiliate Promoter Link<?php } else { ?>Invite friends<?php } ?></h4>
                            <?php
                            $title = $eventData['title'];
                            $tweet = substr($eventData['title'], 0, 100);
                            $linkToShare = $eventData['eventUrl'] . '/' . $eventData['id'];
                            if (isset($referralCode) && !empty($referralCode)) {
                                $linkToShare = $eventData['eventUrl'] . '/' . $eventData['id'] . '?reffCode=' . $referralCode;
                            }
                            if (isset($promoterCode) && !empty($promoterCode)) {
                                $linkToShare = $eventData['eventUrl'] . '/' . $eventData['id'] . '?ucode=' . $promoterCode;
                            }
                            if (isset($globalPromoterCode) && !empty($globalPromoterCode)) {
                                $linkToShare = $eventData['eventUrl'] . '/' . $eventData['id'] . '?acode=' . $globalPromoterCode;
                            }
                            $bitlyUrl = $linkToShare;
                            ?>
                            <span class="invitefirends">
                                <i class="icon1 icon1-invitefriend"></i>
                            </span>
                            <span class="">
                                <a href="https://www.facebook.com/share.php?u=<?= urlencode($linkToShare) ?>&title=Meraevents -<?= $title ?>"
                                   onClick="javascript: cGA('/event-share-facebook'); return fbs_click('<?= $linkToShare ?>', 'Meraevents - <?= $title ?> ')" 
                                   target="_blank"><i class="icon1 icon1-facebook"></i>
                                </a>
                            </span>

                            <span class="">
                                <a onClick="javascript: cGA('/event-share-twitter');" 
                                   href="https://twitter.com/share?url=<?= urlencode($linkToShare); ?>&amp;text=Meraevents - <?= $title ?>" 
                                   target="_blank" class="nounderline social"><i class="icon1 icon1-twitter"></i>
                                </a>
                            </span>
                            <span class="">
                                <a onClick="javascript: cGA('/event-share-linkedin');" 
                                   href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($linkToShare) ?>&amp;title=<?php echo $tweet ?>&amp;summary=<?php echo $eventData['fullAddress'] ?>&amp;source=Meraevents" 
                                   target="_blank" class="nounderline"><i class="icon1 icon1-linkedin"></i>
                                </a>
                            </span>
                        </div>
                        <?php if ($this->customsession->getData('userId') > 0 && isset($globalPromoterCode)) { ?>
                            <div class="Affiliate-Promote-Link" style="margin-top:0px;">
                                <div class="Affiliate-Promote-Copy">
                                    <input type="text" style="" value="<?php echo $eventData['eventUrl'] . '?acode=' . $globalPromoterCode; ?>" id="affiliate_link" readonly/>
                                    <input type="button" id="copyGlobalCodeButton" value="Copy Link">
                                </div>
                            </div>
                        <?php } ?>
                        <h4 style="margin:0 0 10px 0;"><a href="<?php echo commonHelperGetPageUrl("contactUs"); ?>" style="color:#464646;" target="_blank"><span class="icon2-envelope-o"> </span> Contact Us</a></h4>

                        <script>
                            function supportLink() {
                                _paq.push(['trackEvent', , 'EventPage', 'Contact Us']);
                                window.open("<?php echo commonHelperGetPageUrl("contactUs"); ?>");
                            }
                        </script>
                        <?php if ($eventData['eventDetails']['contactdisplay'] == 1 && $eventData['eventDetails']['contactdetails'] != "") { ?>    
                            <div class='inviteFriend'><p>&nbsp;</p><h4>For Enquiries</h4><?php echo $eventData['eventDetails']['contactdetails']; ?></div>
                        <?php } ?>

                        <div class="event_sub_sub_cont">
                            <p><b>Page Views : <span id="eventViewCount"><?php echo $eventData['eventDetails']['viewcount']; ?></span></b></p>
                            <?php if (strlen($eventData['eventDetails']['promotionaltext']) > 0) { ?>
                                <!--event specific right side banner-->
                                <p><?php echo $eventData['eventDetails']['promotionaltext']; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($ticketDetails) > 0) { ?>
                <div class="col-sm-12 eventDetails" id="event_about">
                    <h3>About The Event</h3>
                    <div>
                        <p><?php echo stripslashes($eventData['description']); ?></p>
                    </div>
                </div>
            <?php } ?>
            <?php include_once('includes/eventgallery.php'); ?>
            <?php if ($eventData['eventDetails']['tnctype'] == 'organizer' && !empty($eventData['eventDetails']['organizertnc']) && $eventData['id'] != 232651) { ?>
                <hr>
                <div class="col-sm-12 eventDetails" id="event_terms">
                    <h3>Terms &amp; Conditions</h3><a id="tnc"></a>
                    <?php echo stripslashes($eventData['eventDetails']['organizertnc']); ?>
                </div>
            <?php } ?>
            <?php if ($eventData['eventDetails']['tnctype'] == 'meraevents' && !empty($eventData['eventDetails']['meraeventstnc']) && $eventData['id'] != 232651) { ?>
                <div class="col-sm-12 eventDetails" id="event_terms">
                    <h3>Terms &amp; Condition</h3><a id="tnc"></a>
                    <?php echo stripslashes($eventData['eventDetails']['meraeventstnc']); ?>
                </div>
            <?php } ?>
            <?php if ($eventData['eventDetails']['organizertnc'] != '') { ?>
                <div class="col-sm-12 eventDetails" id="event_terms" style="display:none;">
                    <h3>Terms &amp; Conditions</h3>
                    <?php echo $eventData['eventDetails']['organizertnc']; ?>
                </div>
            <?php } ?>

            <div class="clearBoth"></div>
            <div class="col-sm-12 eventDetails" id="event_sameorganizer">
                <h3>More Events From Same Organizer</h3>
            </div>
            <ul id="eventThumbs" class="eventThumbs">
                <?php
                if (count($eventsList) > 0) {
                    $eventsListOnly = $eventsList['eventList'];
                    foreach ($eventsListOnly as $key => $eventData) {
                        $eventData['eventList'] = $eventsListOnly;
                        $eventData['bookmark_page'] = 1;
                        $eventData['key'] = $key;
                        $this->load->view('includes/elements/event', $eventData);
                    }
                }
                ?>
            </ul>
            <div id="noRecords"></div>
            <div class="clearBoth"></div>
            <input type="hidden" id="page" name="page" value="1">
            <div style="text-align: center" id="loadmore"><a id="loadmore" class="btn btn-primary borderGrey collapsed">More events</a></div>
           <?php if($eventTicketOptionSettings['similareventshide'] == '0'){ ?> 
            <div class="col-sm-12 eventDetails" id="event_samecategoryevents" style="padding: 1em 0;">
                <h3>Similar Category Events</h3>
            </div>
            <div class="col-lg-12">
                <ul id="CategoryeventThumbs" class="eventThumbs"></ul>
            </div>
            <div id="noRecords"></div>
            <div class="clearBoth"></div>
            <input type="hidden" id="pages" name="pages" value="1">
            <div style="text-align: center" id="loading"><a id="loading" class="btn btn-primary borderGrey collapsed">More events</a></div>
            <div style="margin: 10px 0 40px 0;"></div>
           <?php } ?>
            <!--   checing webinar events -->
            <?php
            if ($eventData['eventMode'] == 0 && $eventData['categoryName'] != 'Donations' && $eventData['categoryName'] != 'Webinar') {

                if (isset($eventData['latitude']) && $eventData['latitude'] != 0 && isset($eventData['longitude']) && $eventData['longitude'] != 0 && $eventData['latitude'] != null && $eventData['longitude'] != null) {
                    $mapType = 'lat';
                    $mapAddress = $eventData['latitude'] . ',' . $eventData['longitude'];
                } else {
                    $mapAddress = $eventData['fullAddress'];
                }
                $locationText = $eventData['fullAddress'];
                ?>
                <!-- <div class="col-sm-12 zeroPadd">
                    <h3>Venue Map</h3>
                    <div id="floating-panel"><input style="display: none;" id="latlng" type="text" value="<?php echo $eventData['latitude'] . ',' . $eventData['longitude']; ?>"></div>
                    <div id="map" frameborder="0" style="border:0;width:100%;margin: 10px 0 40px 0;height: 300px;"></div>
                </div> -->

                <script>
                    /*function initMap() {
                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 13,
                            center: {lat: <?php echo $eventData['latitude']; ?>, lng: <?php echo $eventData['longitude']; ?>}
                        });

                        var geocoder = new google.maps.Geocoder;
                        var infowindow = new google.maps.InfoWindow;

    <?php if ($mapType == 'lat') { ?>
                            geocodeLatLng(geocoder, map, infowindow);
    <?php } else { ?>
                            geocodeAddress(geocoder, map);
    <?php } ?>
                    }

                    function geocodeLatLng(geocoder, map, infowindow) {
                        var input = document.getElementById('latlng').value;
                        var latlngStr = input.split(',', 2);
                        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
                        geocoder.geocode({'location': latlng}, function (results, status) {
                            if (status === 'OK') {
                                if (results[1]) {
                                    map.setZoom(11);
                                    var marker = new google.maps.Marker({
                                        position: latlng,
                                        map: map
                                    });
    <?php if (isset($locationText) && $locationText != '') { ?>
                                        infowindow.setContent('<?php echo addslashes($eventData['fullAddress']); ?>');
    <?php } else { ?>
                                        resultsMap.setCenter(results[0].geometry.location);
    <?php } ?>
                                    infowindow.open(map, marker);
                                } else {
                                    console.log('No results found');
                                }
                            } else {
                                console.log('Geocoder failed due to: ' + status);
                            }
                        });
                    }

                    function geocodeAddress(geocoder, resultsMap) {
                        var address = "<?php echo(isset($eventData['fullAddress']) && $eventData['fullAddress'] != '' ) ? addslashes($eventData['fullAddress']) : 'India'; ?>";
                        geocoder.geocode({'address': address}, function (results, status) {
                            if (status === 'OK') {

                                resultsMap.setCenter(results[0].geometry.location);

                                var marker = new google.maps.Marker({
                                    map: resultsMap,
                                    position: results[0].geometry.location
                                });
                            } else {
                                console.log('Geocode was not successful for the following reason: ' + status);
                            }
                        });
                    }*/
                </script>
                <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item('google_app_key'); ?>&callback=initMap"></script> -->
            <?php } ?>
        </div>
    </div>
</div>
<!--end of banner-->
<?php $multiEventsCount = count($multiEventList) + 1; ?>
<!--Begin Structured Data -->
<script type="application/ld+json">
    [
    <?php for ($listCount = 0; $listCount < $multiEventsCount; $listCount++) { ?>
        {
        "@context":"http://schema.org",
        "@type":"Event",
        "name":"<?php echo $eventData['title']; ?>",
        "image":"<?php echo $eventData['bannerPath']; ?>",
        "url":"<?php echo $eventData['eventUrl']; ?>",
        "startDate":"<?php echo ($multiEventsCount > 1) ? appendTimeZone($multiEventList[$listCount]['startDateTime'], $eventData['location']['timeZoneName'], TRUE) : appendTimeZone($eventData['startDate'], $eventData['location']['timeZoneName'], TRUE); ?>",    
        "doorTime":"<?php echo seoFormat($eventData['startDate']); ?>",
        "location": {
        "@type": "EventVenue",
        "name": "<?php echo $eventData['location']['venueName'] . ": " . $eventData['location']['cityName']; ?>",
        "address": "<?php
        echo (isset($eventData['location']['address1']) && $eventData['location']['address1'] != '') ? $eventData['location']['address1'] . ', ' : '';
        echo (isset($eventData['location']['address2']) && $eventData['location']['address2'] != '') ? $eventData['location']['address2'] . ', ' : '';
        echo (isset($eventData['location']['cityName']) && $eventData['location']['cityName'] != '') ? $eventData['location']['cityName'] . ', ' : '';
        echo (isset($eventData['location']['countryName']) && $eventData['location']['countryName'] != '') ? $eventData['location']['countryName'] : '';
        echo (isset($eventData['location']['pincode']) && $eventData['location']['pincode'] != '') ? '- ' . $eventData['location']['pincode'] : '';
        ?>"
        <?php if (isset($eventData['latitude']) && $eventData['latitude'] != 0 && isset($eventData['longitude']) && $eventData['longitude'] != 0) {
            ?>, 
            "geo": {
            "@type": "GeoCoordinates",
            "latitude": "<?php echo $eventData['latitude']; ?>",
            "longitude": "<?php echo $eventData['longitude']; ?>"
            }<?php } ?>
        },
        "offers":[
        <?php
        $rows = 1;
        foreach ($ticketDetails as $ticket) {
            ?>
            {
            "@type":"Offer",
            "name": "<?php echo $ticket['name']; ?>",
            "price":"<?php echo $ticket['price']; ?>",
            "priceCurrency":"<?php echo (empty($ticket['currencyCode'])) ? 'INR' : $ticket['currencyCode']; ?>",
            "availability": "<?php
            if ($ticket['soldout'] == 0 && $ticket['pastTicket'] != 1 && $ticket['upcomingTicket'] != 1) {
                echo 'http://schema.org/InStock';
            } else {
                echo 'http://schema.org/SoldOut';
            }
            ?>",
            "url":"<?php echo $eventData['eventUrl']; ?>",
            "validFrom":"<?php echo appendTimeZone($ticket['startDate'], $eventData['location']['timeZoneName'], TRUE); ?>"
            }<?php
            if ($rows < count($ticketDetails)) {
                echo ',';
            }$rows++;
        }
        ?> 
        ],
        "description" : <?php echo json_encode(strip_tags(stripslashes($eventData['description']))); ?>,
        "endDate" :"<?php echo ($multiEventsCount > 1) ? appendTimeZone($multiEventList[$listCount]['endDateTime'], $eventData['location']['timeZoneName'], TRUE) : appendTimeZone($eventData['endDate'], $eventData['location']['timeZoneName'], TRUE); ?>"

        }<?php
        echo ($listCount + 1 == $multiEventsCount) ? '' : ',';
    }
    ?>
    ]
</script>

<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "Organization",
    "name" : "MeraEvents",
    "url": "<?php echo rtrim(site_url(), "/"); ?>",
    "logo": "<?php echo site_url(); ?>images/static/me-logo.svg",
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
    "telephone": "<?php
    $mobile = str_replace("-", " ", GENERAL_INQUIRY_MOBILE);
    echo ($mobile[0] == 0) ? '+91' . ltrim($mobile, "0") : $mobile;
    ?>",
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
    "url": "<?php echo site_url() ?>"
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
    "@id": "<?php echo site_url() ?>",
    "name": "Home"
    }
    } ,
    {
    "@type": "ListItem",
    "position": 2,
    "item":
    {
    "@id": "<?php echo site_url(); ?><?php echo strtolower($eventData['categoryName']); ?>",
    "name": "<?php echo $eventData['categoryName']; ?> Events"
    }
    }
    ,
    {
    "@type": "ListItem",
    "position": 3,
    "item":
    {
    "@id": "<?php echo $eventData['eventUrl']; ?>",
    "name": "<?php echo $eventData['title']; ?>"
    }
    }

    ]
    }
</script>

<!--End Structured Data -->

<div class="modal fade signup_popup" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="awesome_container">
                <h3 class="icon-icon-bookmark_icon"></h3>
                <h4>Awesome!</h4>
                <h4>Event saved successfully!</h4>

                <div style="width: 15%; margin: 0 auto">
                    <button type="submit" id="okId" class="btn btn-primary borderGrey collapsed" style="padding: 10px 20px; margin-bottom: 20px">oK</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('includes/email_invite.php'); ?>
<script rel="nofollow">
                var dashboard_eventhome = "<?php echo commonHelperGetPageUrl('dashboard-eventhome'); ?>";
                var api_morebookmark = "<?php
if ($eventtype == "upcomming") {
    echo commonHelperGetPageUrl('api_eventList');
}if ($eventtype == "past") {
    echo commonHelperGetPageUrl('api_pasteventList');
}
?>";
                var api_otherEvents = "<?php echo commonHelperGetPageUrl('api_otherEvents') ?>";
                var api_similarCategoryEvents = "<?php echo commonHelperGetPageUrl('api_similarCategoryEvents') ?>";
                var add_bookmark = "<?php echo commonHelperGetPageUrl('api_add_bookmark'); ?>";
                var remove_bookmark = "<?php echo commonHelperGetPageUrl('api_remove_bookmark'); ?>";
                var api_searchSearchEventAutocomplete = "<?php echo commonHelperGetPageUrl('api_searchSearchEventAutocomplete') ?>";
                var api_getTicketCalculation = '<?php echo commonHelperGetPageUrl('api_getTicketCalculation'); ?>';
                var api_bookNow = '<?php echo commonHelperGetPageUrl('api_bookNow'); ?>';
                var api_eventMailInvitations = "<?php echo commonHelperGetPageUrl('api_eventMailInvitations') ?>";
                var api_getProfileDropdown = "<?php echo commonHelperGetPageUrl('api_getProfileDropdown') ?>";
                var api_getTinyUrl = "<?php echo commonHelperGetPageUrl('api_getTinyUrl') ?>";
                var event_url = "<?php echo $linkToShare; ?>";
                var tweet = "<?php echo $tweet; ?>";
                var eventid = "<?php echo $eventData['id']; ?>";
                var viewCountUp = "<?php echo $viewCountUp; ?>";
                var api_updateEventViewCount = "<?php echo commonHelperGetPageUrl('api_updateEventViewCount') ?>";
                //var api_getEventViewCount = "<?php echo commonHelperGetPageUrl('api_getEventViewCount') ?>";
                var sDate = '<?php echo $eventData['startDate']; ?>';
                var eDate = '<?php echo $eventData['endDate']; ?>';
<?php if ($multiEvent == TRUE) { ?>
                    var enableDates = [<?php echo $enableDates; ?>];
                    var eventurl = '<?php echo $event_url; ?>';
                    var getParams = "<?php echo trim($getParams); ?>";
                    var multiEventsWithDates = <?php echo $multiEventListWithDates; ?>;
<?php } ?>
</script>


<script>
    $(document).ready(function () {
        var eventid = '<?php echo $eventData['id']; ?>';
        var page = $("#page").val();
        var id = $(this).attr("bookmarked_events_ids");
        var htmlData = '';
        var inputData = '';
        inputData += '?eventid=' + <?php echo $eventData['id']; ?>;
        inputData += '&page=' + page;
        var url = '<?php echo commonHelperGetPageUrl('api_otherEvents') ?>';
        $.ajax({
            url: "<?php echo commonHelperGetPageUrl('api_otherEvents') ?>" + inputData,
            type: 'GET',
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            },
            success: function (data) {
                if (data.status === false) {
                    $('#loadmore').hide();
                    $('div#event_sameorganizer').hide();
                    $('div#nomore').hide();
                }
                $.each(data.response.eventList, function (key, value) {
                    var event = value;
                    var eventURL = event.eventUrl
                    if (event.eventExternalUrl != undefined) {
                        eventURL = event.eventExternalUrl;
                    }
                    htmlData += '<li  class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbBlock bookmarkid_' + eventId.id + '"><div class="event-box-shadow">';
                    htmlData += '<a href="' + eventURL + '" class="thumbnail">';
                    htmlData += '<div class="eventImg">';
                    htmlData += '<img src="' + event.thumbImage + '" width="" height="" alt="' + event.title + '" title="' + event.title + '"';
                    htmlData += ' onError="this.src=\'' + event.defaultThumbImage + '\'; this.onerror = null"'
                    htmlData += ' />';
                    htmlData += '</div><div class="eventpadding"><h2>';
                    htmlData += '<span class="eveHeadWrap">' + event.title + '</span>';
                    htmlData += '</h2><div class="info">';
                    if (event.masterEvent == 1) {
                        htmlData += '<span><i class="icon2-calendar-o"></i> Multiple Dates</span>';
                    } else {
                        htmlData += '<span><i class="icon2-calendar-o"></i> ' + convertDate(event.startDate) + '</span>';
                    }
                    htmlData += '</div>';
                    htmlData += '<div class="eventCity" >';
                    if (event.cityName != '' && event.cityName != 'undefined') {
                        htmlData += '<span>' + event.cityName + '</span>';
                    }
                    htmlData += '</div></div><div class="overlay"><div class="overlayButt"><div class="overlaySocial">';
                    htmlData += '<span class="icon-fb"></span> <span class="icon-tweet"></span>';
                    htmlData += '<span class="icon-google"></span></div></div></div>';
                    htmlData += '</a> <a href="' + eventURL + '" class="category">';
                    htmlData += '<span class="mecat-' + event.categoryName.toLowerCase().replace(/[^a-zA-Z]/g, "") + ' col' + event.categoryName.toLowerCase().replace(/[^a-zA-Z]/g, "") + '"></span>';
                    htmlData += '<span class="catName"><em>' + event.categoryName + '</em></span> </a> ';
                    htmlData += '<span  event_id="' + event.id + '"';
                    if (event.bookMarked == 1)
                    {
                        htmlData += 'class="add_bookmark icon2-bookmark"  rle="remove" title="Remove bookmark" >';
                    } else {
                        htmlData += 'class="icon2-bookmark-o add_bookmark"  rle="add" title="Add bookmark" >';
                    }
                    htmlData += '</span></div></li>';
                });
                $('ul#eventThumbs').append(htmlData);
                if ($('.thumbBlock').length >= data.response.total) {
                    $('div#loadmore').hide();
                    $('div#nomore').show();
                    //alert('No more events by the Same Organizer');
                }
                //$('div#nomore').hide();
                $("#viewMorebookmarkEvents").removeClass("loading");
                if (data.response.nextPage == false) {

                    $('#viewMorebookmarkEvents').css('display', 'none');
                } else if (data.response.nextPage == true)
                {
                    $('#viewMorebookmarkEvents').css('display', 'inline-block');
                }
            }
        });
        var categoryname = '<?php echo $eventData['categoryName']; ?>';
        var cityid = '<?php echo $eventData['location']['cityId']; ?>';
        var categoryid = <?php echo $eventData['categoryId']; ?>;
        var pages = $("#pages").val();
        var id = $(this).attr("bookmarked_events_ids");
        var htmlDatas = '';
        var inputData = '';
        inputData += '?categoryname=' + categoryname;
        inputData += '&cityid=' + cityid;
        inputData += '&categoryid=' + categoryid;
        inputData += '&eventid=' + eventid;
        inputData += '&pages=' + pages;
        var url = '<?php echo commonHelperGetPageUrl('api_similarCategoryEvents') ?>';
        $.ajax({
            url: "<?php echo commonHelperGetPageUrl('api_similarCategoryEvents') ?>" + inputData,
            type: 'GET',
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            },
            success: function (data) {
                if (data.status === false) {
                    $('#loading').hide();
                    $('div#event_samecategoryevents').hide();
                    $('div#nomore').hide();
                }
                $.each(data.response.similarCategoryEventslist, function (key, value) {
                    var event = value;
                    var eventURL = event.eventUrl
                    if (event.eventExternalUrl != undefined) {
                        eventURL = event.eventExternalUrl;
                    }
                    htmlDatas += '<li  class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbBlocks bookmarkid_' + eventId.id + '"><div class="event-box-shadow">';
                    htmlDatas += '<a href="' + eventURL + '" class="thumbnail">';
                    htmlDatas += '<div class="eventImg">';
                    htmlDatas += '<img src="' + event.thumbImage + '" width="" height="" alt="' + event.title + '" title="' + event.title + '"';
                    htmlDatas += ' onError="this.src=\'' + event.defaultThumbImage + '\'; this.onerror = null"'
                    htmlDatas += ' />';
                    htmlDatas += '</div><div class="eventpadding"><h2>';
                    htmlDatas += '<span class="eveHeadWrap">' + event.title + '</span>';
                    htmlDatas += '</h2><div class="info">';
                    if (event.masterEvent == 1) {
                        htmlDatas += '<span><i class="icon2-calendar-o"></i> Multiple Dates</span>';
                    } else {
                        htmlDatas += '<span><i class="icon2-calendar-o"></i> ' + convertDate(event.startDate) + '</span>';
                    }
                    htmlDatas += '</div>';
                    htmlDatas += '<div class="eventCity" >';
                    if (event.cityName != '' && event.cityName != 'undefined') {
                        htmlDatas += '<span>' + event.cityName + '</span>';
                    }
                    htmlDatas += '</div></div><div class="overlay"><div class="overlayButt"><div class="overlaySocial">';
                    htmlDatas += '<span class="icon-fb"></span> <span class="icon-tweet"></span>';
                    htmlDatas += '<span class="icon-google"></span></div></div></div>';
                    htmlDatas += '</a> <a href="' + eventURL + '" class="category">';
                    htmlDatas += '<span class="mecat-' + event.categoryName.toLowerCase().replace(/[^a-zA-Z]/g, "") + ' col' + event.categoryName.toLowerCase().replace(/[^a-zA-Z]/g, "") + '"></span>';
                    htmlDatas += '<span class="catName"><em>' + event.categoryName + '</em></span> </a> ';
                    htmlDatas += '<span  event_id="' + event.id + '"';
                    if (event.bookMarked == 1)
                    {
                        htmlDatas += 'class="add_bookmark icon2-bookmark"  rle="remove" title="Remove bookmark" >';
                    } else {
                        htmlDatas += 'class="icon2-bookmark-o add_bookmark"  rle="add" title="Add bookmark" >';
                    }
                    htmlDatas += '</span></div></li>';
                });
                $('ul#CategoryeventThumbs').append(htmlDatas);
                if ($('.thumbBlocks').length >= data.response.total) {
                    $('div#loading').hide();
                    $('div#nomore').show();
                    //alert('No more events by the Same Organizer');
                }
                //$('div#nomore').hide();
                $("#viewMorebookmarkEvents").removeClass("loading");
                if (data.response.nextPage == false) {

                    $('#viewMorebookmarkEvents').css('display', 'none');
                } else if (data.response.nextPage == true)
                {
                    $('#viewMorebookmarkEvents').css('display', 'inline-block');
                }
            }
        });
    });
    $('#loadmore').on('click', function (e) {
        var html = '';
        var cityAndState = '';
        var id = $(this).attr("bookmarked_events_ids");
        var page = $("#page").val();
        page = parseInt(page) + 1;
        $("#page").val(page);
        var inputData = '';
        inputData += '?eventid=' + <?php echo $eventData['id']; ?>;
        inputData += '&page=' + page;
        $.ajax({
            url: "<?php echo commonHelperGetPageUrl('api_otherEvents') ?>" + inputData,
            type: "GET",
            //data: "eventid=<?php echo $eventData['id']; ?>&page="+page,
            success: function (data) {

                if (data.status === false) {
                    $('#loadmore').hide();
                    $('div#event_sameorganizer').hide();
                    $('div#nomore').show();
                }

                $.each(data.response.eventList, function (key, value) {
                    var event = value;
                    var eventURL = event.eventUrl
                    if (event.eventExternalUrl != undefined) {
                        eventURL = event.eventExternalUrl;
                    }
                    html += '<li  class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbBlock bookmarkid_' + eventId.id + '"><div class="event-box-shadow">';
                    html += '<a href="' + eventURL + '" class="thumbnail">';
                    html += '<div class="eventImg">';
                    html += '<img src="' + event.thumbImage + '" width="" height="" alt="' + event.title + '" title="' + event.title + '"';
                    html += ' onError="this.src=\'' + event.defaultThumbImage + '\'; this.onerror = null"'
                    html += ' />';
                    html += '</div><div class="eventpadding"><h2>';
                    html += '<span class="eveHeadWrap">' + event.title + '</span>';
                    html += '</h2><div class="info">';
                    if (event.masterEvent == 1) {
                        html += '<span><i class="icon2-calendar-o"></i> Multiple Dates</span>';
                    } else {
                        html += '<span><i class="icon2-calendar-o"></i> ' + convertDate(event.startDate) + '</span>';
                    }
                    html += '</div>';
                    html += '<div class="eventCity" >';
                    if (event.cityName != '' && event.cityName != 'undefined') {
                        html += '<span>' + event.cityName + '</span>';
                    }
                    html += '</div></div><div class="overlay"><div class="overlayButt"><div class="overlaySocial">';
                    html += '<span class="icon-fb"></span> <span class="icon-tweet"></span>';
                    html += '<span class="icon-google"></span></div></div></div>';
                    html += '</a> <a href="' + eventURL + '" class="category">';
                    html += '<span class="mecat-' + event.categoryName.toLowerCase().replace(/[^a-zA-Z]/g, "") + ' col' + event.categoryName.toLowerCase().replace(/[^a-zA-Z]/g, "") + '"></span>';
                    html += '<span class="catName"><em>' + event.categoryName + '</em></span> </a> ';
                    html += '<span  event_id="' + event.id + '"';
                    if (event.bookMarked == 1)
                    {
                        html += 'class="add_bookmark icon2-bookmark"  rel="remove" title="Remove bookmark" >';
                    } else {
                        html += 'class="icon2-bookmark-o add_bookmark"  rel="add" title="Add bookmark" >';
                    }
                    html += '</span></div></li>';
                });
                $("ul#eventThumbs").append(html);
                if ($('.thumbBlock').length >= data.response.total) {
                    $('div#loadmore').hide();
                    $('div#nomore').show();
                    //alert('No more events by the Same Organizer');
                }
                if (data.response.nextPage === false) {
                    // hiding the view more button and showing no more events text
                    $('#loadmore').hide();
                    $('div#nomore').hide();
                }
            }
        });
    });

    $('#loading').on('click', function (e) {
        var categoryname = '<?php echo $eventData['categoryName']; ?>';
        var cityid = '<?php echo $eventData['location']['cityId']; ?>';
        var categoryid = <?php echo $eventData['categoryId']; ?>;
        var pages = $("#pages").val();
        var id = $(this).attr("bookmarked_events_ids");
        var htmls = '';
        var cityAndState = '';
        var id = $(this).attr("bookmarked_events_ids");
        var pages = $("#pages").val();
        pages = parseInt(pages) + 1;
        $("#pages").val(pages);
        var inputData = '';
        inputData += '?categoryname=' + categoryname;
        inputData += '&cityid=' + cityid;
        inputData += '&categoryid=' + categoryid;
        inputData += '&eventid=' + eventid;
        inputData += '&pages=' + pages;
        $.ajax({
            url: "<?php echo commonHelperGetPageUrl('api_similarCategoryEvents') ?>" + inputData,
            type: "GET",
            //data: "eventid=<?php echo $eventData['id']; ?>&pages="+pages,
            success: function (data) {
                console.log(data)
                if (data.status === false) {
                    $('#loading').hide();
                    $('div#event_samecategoryevents').hide();
                    $('div#nomore').show();
                }

                $.each(data.response.similarCategoryEventslist, function (key, value) {
                    var event = value;
                    var eventURL = event.eventUrl
                    if (event.eventExternalUrl != undefined) {
                        eventURL = event.eventExternalUrl;
                    }
                    htmls += '<li  class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbBlocks bookmarkid_' + eventId.id + '"><div class="event-box-shadow">';
                    htmls += '<a href="' + eventURL + '" class="thumbnail">';
                    htmls += '<div class="eventImg">';
                    htmls += '<img src="' + event.thumbImage + '" width="" height="" alt="' + event.title + '" title="' + event.title + '"';
                    htmls += ' onError="this.src=\'' + event.defaultThumbImage + '\'; this.onerror = null"'
                    htmls += ' />';
                    htmls += '</div><div class="eventpadding"><h2>';
                    htmls += '<span class="eveHeadWrap">' + event.title + '</span>';
                    htmls += '</h2><div class="info">';
                    if (event.masterEvent == 1) {
                        htmls += '<span><i class="icon2-calendar-o"></i> Multiple Dates</span>';
                    } else {
                        htmls += '<span><i class="icon2-calendar-o"></i> ' + convertDate(event.startDate) + '</span>';
                    }
                    htmls += '</div>';
                    htmls += '<div class="eventCity" >';
                    if (event.cityName != '' && event.cityName != 'undefined') {
                        htmls += '<span>' + event.cityName + '</span>';
                    }
                    htmls += '</div></div><div class="overlay"><div class="overlayButt"><div class="overlaySocial">';
                    htmls += '<span class="icon-fb"></span> <span class="icon-tweet"></span>';
                    htmls += '<span class="icon-google"></span></div></div></div>';
                    htmls += '</a> <a href="' + eventURL + '" class="category">';
                    htmls += '<span class="mecat-' + event.categoryName.toLowerCase().replace(/[^a-zA-Z]/g, "") + ' col' + event.categoryName.toLowerCase().replace(/[^a-zA-Z]/g, "") + '"></span>';
                    htmls += '<span class="catName"><em>' + event.categoryName + '</em></span> </a> ';
                    htmls += '<span  event_id="' + event.id + '"';
                    if (event.bookMarked == 1)
                    {
                        htmls += 'class="add_bookmark icon2-bookmark"  rel="remove" title="Remove bookmark" >';
                    } else {
                        htmls += 'class="icon2-bookmark-o add_bookmark"  rel="add" title="Add bookmark" >';
                    }
                    htmls += '</span></div></li>';
                });
                $("ul#CategoryeventThumbs").append(htmls);
                if ($('.thumbBlocks').length >= data.response.total) {
                    $('div#loading').hide();
                    $('div#nomore').show();
                    //alert('No more events by the Same Organizer');
                }
                if (data.response.nextPage === false) {
                    // hiding the view more button and showing no more events text
                    $('#loading').hide();
                    $('div#nomore').hide();
                }
            }
        });
    });
</script>

<script>
    $(document).on("click", ".add_bookmark", function () {
        var eventId = jQuery(this).attr("event_id");
        var rel = jQuery(this).attr("rle");
        if (rel == 'add')
        {
            var ajaxurl = add_bookmark;
        } else
        {
            var ajaxurl = remove_bookmark;
        }
        var currentbutton = $(this);
        $.ajax({

            url: ajaxurl,
            type: 'GET',
            data: {eventId: eventId},
            headers: {'Authorization': 'bearer 930332c8a6bf5f0850bd49c1627ced2092631250'},
            dataType: 'json',
            async: true,
            success: function (data) {
                if (data['response']['status'] == true)
                {
                    if (rel == 'add')
                    {
                        currentbutton.attr("rel", "remove");
                        currentbutton.attr("title", "Remove Bookmark");
                        currentbutton.removeClass("icon2-bookmark-o");
                        currentbutton.addClass("icon2-bookmark");
                    } else
                    {
                        currentbutton.attr("rel", "add");
                        currentbutton.attr("title", "Add Bookmark");
                        currentbutton.removeClass("icon2-bookmark");
                        currentbutton.addClass("icon2-bookmark-o");
                    }
                    if (typeof bookmark_page != 'undefined' && bookmark_page == 1)
                    {
                        $(".bookmarkid_" + eventId).hide();
                        bookmark_count = bookmark_count - 1;
                        if (bookmark_count == 0)
                        {
                            $(".no_bookmark_msg").html("Sorry, No records found");
                        }
                    }
                }
            },
        });
    });
</script>