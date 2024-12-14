<?php $chapter['slug'] = $this->uri->segment(2); ?>
<section class="banner-top">
    <img src="<?php echo $organizationDetails['bannerPath']; ?>" alt="" title="" class="img-responsive">
</section>
<section class="banner-section-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-7">
                <div class="Member-bootm">
                    <div class="col-sm-3 col-xs-4">
                        <div class="Member-box">
                            <img src="/images/association/Member-icon.png" alt="Member">
                            <div>
                                <p><?php echo!empty($organizationMembers['userdetails']) ? count($organizationMembers['userdetails']) : 0; ?></p>
                                <p>Members</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-8">
                        <ul class="nav navbar-nav navbar-right">
                            <?php if (!empty($membershipTypes['response']['membershipTypes'])) { ?>
                                <li><a href="<?php echo site_url() . 'c/' . $chapter['slug'] . '/' . 'join'; ?>"> Join Group </a></li>
                                <!--    <li> or </li>
                                    <li><a href="#"> Renew Membership</a></li> -->
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-5">
                <div class="banner-speaker">
                    <p><b><?php echo $organizationDetails['name']; ?></b></p>
                    <!--<p> Anudeep Chappa</p>-->
                    <!--<p> ad@amaravati.tie.org </p>-->
                    <ul class="nav navbar">
                        <!--    <h5 style="float: none"><a href=""> Contact admin </a> </h5> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="p-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p style="margin-top: 30px;"><?php echo $organizationDetails['information']; ?></p>
            </div>
        </div>
    </div>
</section>
<section class="event-tab p-50">
    <div class="container">

        <ul class="nav nav-justified">
            <li class="active"><a data-toggle="tab" href="#Upcoming_event">Events</a></li>
        </ul>
        <div class="tab-content p-50">
            <div id="Upcoming_event" class="tab-pane fade in active">
                <div class="row">
                    <?php
                    if (!empty($organizationEvents['response']['OrganizationEventsData'])) {
                        $i = 0;
                        foreach ($organizationEvents['response']['OrganizationEventsData'] as $event) {
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
                                            <ul>
                                                <li><span class="glyphicon glyphicon-calendar"></span> <?php echo date('h:i A M d, Y', strtotime($event['startDateTime'])); ?></li>
                                                <li><span class="glyphicon glyphicon-map-marker"></span> <?php echo $event['venue']; ?>, <?php echo $event['city']; ?></li>
                                            </ul>
                                        </div>
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
                <?php if (!empty($organizationEvents['response']['OrganizationEventsData'])) { ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary"><a href="<?php echo $association_url; ?>/events">View All Events</a></button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<section class="slider-users p-50 m-20">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <h2>Chapter Members</h2>
            </div>
            <?php if (!empty($organizationMembers['userdetails'])) { ?>
                <!--                <div class="col-xs-12 col-sm-6">
                                    <form class="navbar-form navbar-right" role="search">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>-->
            <?php } ?>
        </div>

        <div class="row p-20" data-toggle="modal" data-target="#exampleModal">
            <?php
            if (!empty($organizationMembers['userdetails'])) {
                foreach ($organizationMembers['userdetails'] as $Member) {
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 text-center" data-target="#carouselExample" data-slide-to="1">
                        <div class="card">
                            <?php if (trim($Member['profileimagefilepath']) != "") { ?>
                                <img src="<?php echo trim($Member['profileimagefilepath']); ?>"/>
                            <?php } ?>
                            <div class="card-container">
                                <h4><?php echo $Member['name']; ?></h4>
                                <h5>
                                    <?php
                                    if (trim($Member['company']) != "") {
                                        echo trim($Member['company']);
                                    }
                                    ?>
                                    <?php
                                    if (trim($Member['designation']) != "") {
                                        echo "<br/>" . trim($Member['designation']);
                                    }
                                    ?>
                                </h5>
                                <div style="margin-top: 10px">
                                    <?php if (trim($Member['facebooklink']) != "") { ?>
                                        <a href="<?php echo trim($Member['facebooklink']); ?>"><img src="<?php echo $this->config->item('images_cloud_path'); ?>images/association/f.png" style="height: 25px; width: 25px"></a>
                                    <?php } if (trim($Member['twitterlink']) != "") { ?>
                                        <a href="<?php echo trim($Member['twitterlink']); ?>"><img src="<?php echo $this->config->item('images_cloud_path'); ?>images/association/t.png" style="height: 25px; width: 25px"></a>
                                    <?php } if (trim($Member['linkedinlink']) != "") { ?>
                                        <a href="<?php echo trim($Member['linkedinlink']); ?>"><img src="<?php echo $this->config->item('images_cloud_path'); ?>images/association/linkedin.png" style="height: 25px; width: 25px"></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center" data-target="#carouselExample" data-slide-to="1">
                    <div class="card-container">
                        <h4>No members joined yet</h4>
                        <p></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>