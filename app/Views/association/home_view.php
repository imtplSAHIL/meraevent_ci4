<section class="event-tab event-tab-inner p-50">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>Upcoming Events</h2>
            </div>
            <div class="col-xs-6 text-right">
                <button class="btn btn-primary"><a href="<?php echo $association_url; ?>/events">View All</a></button>
            </div>
        </div>

        <div class="row">
            <div class="tab-content">
                <?php
                if (!empty($eventsData)) {
                    $i = 0;
                    foreach ($eventsData as $event) {
                        if ($i == 3) {
                            continue;
                        }
                        $i++;
                        ?>
                        <a href="<?php echo $event['url']; ?>">
                            <div class="col-sm-6 col-xs-12 col-md-4">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="<?php echo $event['logoPath']; ?>" width="" height="" alt="<?php echo $event['title']; ?>" title="<?php echo $event['title']; ?>" class="img-responsive">
                                    </div>
                                    <div class="card-container">
                                        <h4><?php echo $event['title']; ?></h4>
                                    </div>
                                    <ul>
                                        <li><span class="glyphicon glyphicon-calendar"></span> <?php echo date('h:i A M d, Y', strtotime($event['startDateTime'])); ?></li>
                                        <li><span class="glyphicon glyphicon-map-marker"></span> <?php echo $event['venue']; ?>, <?php echo $event['city']; ?></li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                } else {
                    ?>
                    There are no events
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<section class="event-tab chapters p-50">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>Chapters</h2>
            </div>
            <div class="col-xs-6 text-right">
                <button class="btn btn-primary"><a href="<?php echo $association_url; ?>/chapters">View All</a></button>
            </div>
        </div>

        <div class="row">
            <div class="tab-content">
                <?php
                if (!empty($organizationChapters['response']['chapterData'])) {
                    $i = 0;
                    foreach ($organizationChapters['response']['chapterData'] as $chapter) {
                        if ($i == 6) {
                            continue;
                        }
                        $i++;
                        ?>
                        <a href="<?php echo site_url() . 'c/' . $chapter['slug']; ?>">
                            <div class="col-sm-6 col-xs-12 col-md-4">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="<?php echo $chapter['bannerPath']; ?>" alt=" " title="" class="img-responsive">
                                    </div>
                                    <div class="card-container">
                                        <h3><?php echo $chapter['name']; ?></h3>
                                        <p><?php echo $chapter['information']; ?></p>
                                    </div>
                                    <div class="card-footer text-center">Join</div>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                } else {
                    ?>
                    There are no chapters
                <?php } ?>
            </div>
        </div>
    </div>
</section>