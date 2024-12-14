<script type="text/javascript">
    var dashboard_eventhome = "<?php echo commonHelperGetPageUrl('dashboard-eventhome'); ?>";
    var add_bookmark = "<?php echo commonHelperGetPageUrl('api_add_bookmark'); ?>";
    var remove_bookmark = "<?php echo commonHelperGetPageUrl('api_remove_bookmark'); ?>";
</script>
<!-- hero-full-single 1920 X 500 pixels dimensions-->
<!-- container title-single -->
<div class="bg-header" id="organizer-header">
    <div class="hero-full-single-organizer">
        <div class="container">
            <div class="row">
                <div class="organizer-container">
                    <div class="organizer-logo"><img src="<?php echo str_replace("/content/content", "/content", $logopath); ?>" width="150px" height="150px"></div>
                    <div class="organizer-bio-container">
                        <h2 class="organizer-name">
                            <?php echo $organizationDetails['name'] ?>
                        </h2>
                        <p class="organizer-specs">
                            Total Page Views : <?php echo $organizationDetails['viewcount']; ?>
                        </p>
                        <p class="organizer-dob">
                            Total Events Conducted : <?php echo $orgTotalEvents; ?>
                        </p>
                        <div class="organizer-social-links">
                            <a href="<?php echo $organizationDetails['facebooklink']; ?>" target="_blank"><i class="ion-social-facebook"></i></a>
                            <a href="<?php echo $organizationDetails['twitterlink']; ?>" target="_blank"><i class="ion-social-twitter"></i></a>
                            <a href="<?php echo $organizationDetails['linkedinlink']; ?>" target="_blank"><i class="ion-social-linkedin"></i></a>
                            <a href="<?php echo $organizationDetails['instagramlink']; ?>" target="_blank"><i class="ion-social-instagram"></i></a>
                        </div>
                    </div><!-- organizer-bio-container -->
                </div> <!-- organizer continer -->

            </div>
        </div>
    </div>
</div>

<div class="page-single">
    <div class="main-content-single content-slider-single organizer-grey-bg" id="organizer-single-page">
        <div class="container mt-3">
            <div class="listing-section">
                <div class="row">
                    <div class="col-lg-12 p-0">
                        <div class="content-area pb-0">
                            <?php if (strlen($organizationDetails['information']) > 0) { ?>
                                <section class="listing-section__single">
                                    <div class="list-info mt-0 eventCatName">
                                        <h3 class="get_tickts">About <?php echo $organizationDetails['name'] ?></h3>
                                        <?php if (strlen($organizationDetails['information']) > 350) { ?>
                                            <?php
                                            $description = $organizationDetails['information'];
                                            $first = substr($description, 0, 350);
                                            $last = substr($description, 350);
                                            ?>
                                            <p class="tckdesc"> <?php echo $first . '<i>...</i><span style="display:none">' . $last . '</span>'; ?></p>
                                            <p class="ticket-desc-loadmore"><a href="javascript:;">Show More</a></p>
                                        <?php } else { ?>
                                            <p class="tckdesc"> <?php echo $organizationDetails['information'] ?></p>
                                        <?php } ?>
                                    </div>
                                </section>
                            <?php } ?>

                            <section class="listing-section__single" id="events">
                                <div class="">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a href="javascript:;" id="upcomingeventstab" class="nav-item nav-link eventtypes events <?= $pageType == 'upcoming' ? 'active' : ''; ?>" pagetype="upcoming" aria-controls="upcomingevents-tab" aria-selected="true">Upcoming Events</a>
                                            <a href="javascript:;" id="pasteventstab" class="nav-item nav-link eventtypes <?= $pageType == 'past' ? 'active' : ''; ?>" pagetype="past" aria-controls="pastevents-tab" aria-selected="false">Past Events</a>
                                        </div>
                                    </nav>
                                    <input type="hidden" id="page" value="1" />
                                    <input type="hidden" id="pageType" value="<?php echo $pageType; ?>" />
                                    <input type="hidden" id="organization" value="<?php echo $organizationDetails['id']; ?>" />
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="upcomingevents-tab" role="tabpanel" aria-labelledby="upcomingevents-tab">
                                            <div class="eventgrid-container" >
                                                <?php if (!empty($eventsData)) { ?>
                                                    <div class="row" id="upcoming_past_events">
                                                        <?php foreach ($eventsData as $key => $eventDetails) { ?>
                                                            <div class="col-lg-4 col-md-6 col-xs-12 thumbBlock">
                                                                <div class="eventgrid-single">
                                                                    <div class="eventgrid-img">
                                                                        <a href="<?php echo $eventDetails['url']; ?>"><img src="<?php echo $eventDetails['logoPath'] ?>"></a>
                                                                    </div>
                                                                    <div class="eventgrid-info-container">
                                                                        <div class="eventgrid-info">
                                                                            <h1 class="event-title"><a href="<?php echo $eventDetails['url']; ?>"><?php echo $eventDetails['title'] ?></a></h1>
                                                                            <?php if($eventDetails['eventdatehide'] == 0){ ?>
                                                                            <div class="event-date-time">
                                                                                <i class="ti-time"></i>
                                                                                <span><?php
                                                                                
                                                                                    if ($eventDetails['masterevent'] == TRUE) {
                                                                                        echo "Multiple Days" . " | " . $eventDetails['startDateTime'];
                                                                                    } else {
                                                                                        echo $eventDetails['startDateTime'];
                                                                                    }
                                                                                
                                                                                    ?> </span>
                                                                            </div>
                                                                            <?php }else{
                                                                                    
                                                                                } ?>
                                                                            <div class="event-venue">
                                                                                <i class="ti-location-pin"></i>
                                                                                <span><?php if($eventDetails['venue'] == 'Live') { echo 'Online'; } else { echo $eventDetails['venue']; } ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="eventgrid-bottom">
                                                                         <div class="eventgrid-host"></div> <!--  Venue: <a href="#"><?php echo $eventDetails['venue']; ?></a>-->
                                                                            <div class="eventgrid-quicklinks">
                                                                                <a href="javascript:;" event_id="<?php echo $eventDetails['eventId']; ?>" <?php
                                                                                if ($eventDetails['bookmarked'] == 1) {
                                                                                    echo " class='add_bookmark icon2-bookmark'  rel='remove' title='Remove bookmark'";
                                                                                } else {
                                                                                    echo " class='icon2-bookmark-o add_bookmark'  rel='add' title='Add bookmark' ";
                                                                                }
                                                                                ?>><i class="ti-bookmark"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php } else { ?>
                                                    <h4 id="no-events" > No Events Found</h4>
                                                <?php } ?>
                                            </div>
                                            <div class="text-center mb-4" style="clear:both;display:block;">
                                                <a id="viewMore" class="btn btn-primary borderGrey collapsed" <?php if ($totalCount <= ORGANIZATION_EVENTS_DISPLAY_LIMIT) { ?>style="display:none;" <?php } ?>>View More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>
                </div>
            </div>
        </div> <!-- listing-section/ -->
    </div> <!-- container/  -->
</div><!-- main-content-single/ -->
</div> <!-- pagesingle/ -->

<!-- end-page -->
<script>
    var api_organizationEvents = "<?php echo commonHelperGetPageUrl('api_organizationEvents') ?>";
    var api_getOrgContacts = "<?php echo commonHelperGetPageUrl('api_organizerContactEmails') ?>";
</script>