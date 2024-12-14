<section class="inner-content-search p-20">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <h2>Chapters</h2>
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
<section class="chapters m-50">
    <div class="container">
        <div class="row ">
            <div class="tab-content">
                <?php
                if (!empty($organizationChapters['response']['chapterData'])) {
                    foreach ($organizationChapters['response']['chapterData'] as $chapter) {
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