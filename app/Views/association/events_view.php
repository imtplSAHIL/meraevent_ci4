<section class="inner-content-search p-20">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <h2>Events</h2>
            </div>
            <div class="col-xs-12 col-sm-8">
<!--                <form class="navbar-form navbar-right" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                    <button id="menu-toggle" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-filter"></span></button>
                </form>-->
            </div>
        </div>
    </div>
</section>

<section class="event-tab event-tab-inner p-50">
    <div class="container">
        <div class="row ">
            <div class="tab-content">
                <?php
                if (!empty($organizationEvents['response']['OrganizationEventsData'])) {
                    foreach ($organizationEvents['response']['OrganizationEventsData'] as $event) {
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