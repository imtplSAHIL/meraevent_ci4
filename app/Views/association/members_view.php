<section class="inner-content-search p-20">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <h3> Members  <?php
                    if (!empty($organizationMembers['chapterName'])) {
                        echo '-' . $organizationMembers['chapterName'];
                    }
                    ?>
                </h3>
            </div>
            <div class="col-xs-12 col-sm-8">
                <?php if (!empty($organizationMembers['userdetails'])) { ?>
                    <!--                    <form class="navbar-form navbar-right" role="search">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                                </div>
                                            </div>
                                            <button class="btn btn-default"> <span class="glyphicon glyphicon-filter"></span> </button>
                                        </form>-->
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<section class="slider-users m-20">
    <div class="container">
        <div class="row p-20" data-toggle="modal" data-target="#exampleModal">
            <?php
            if (!empty($organizationMembers['userdetails'])) {
                foreach ($organizationMembers['userdetails'] as $data) {
                    ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 text-center" data-target="#carouselExample" data-slide-to="1">
                        <div class="card">
                            <?php if (trim($data['profileimagefilepath']) != "") { ?>
                                <img src="<?php echo trim($data['profileimagefilepath']); ?>"/>
                            <?php } ?>
                            <div class="card-container">
                                <h4><?php echo $data['name']; ?></h4>
                                <h5>
                                    <?php
                                    if (trim($data['company']) != "") {
                                        echo trim($data['company']);
                                    }
                                    ?>
                                    <?php
                                    if (trim($data['designation']) != "") {
                                        echo "<br/>" . trim($data['designation']);
                                    }
                                    ?>
                                </h5>
                                <div style="margin-top: 10px">
                                    <?php if (trim($data['facebooklink']) != "") { ?>
                                        <a href="<?php echo trim($data['facebooklink']); ?>"><img src="<?php echo $this->config->item('images_cloud_path');?>images/association/f.png" style="height: 25px; width: 25px"></a>
                                    <?php } if (trim($data['twitterlink']) != "") { ?>
                                        <a href="<?php echo trim($data['twitterlink']); ?>"><img src="<?php echo $this->config->item('images_cloud_path');?>images/association/t.png" style="height: 25px; width: 25px"></a>
                                    <?php } if (trim($data['linkedinlink']) != "") { ?>
                                        <a href="<?php echo trim($data['linkedinlink']); ?>"><img src="<?php echo $this->config->item('images_cloud_path');?>images/association/linkedin.png" style="height: 25px; width: 25px"></a>
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