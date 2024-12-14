<div class="rightArea rightbg">
    <h3>Association View</h3>
    <div>
        <div class="tabcontents">
            <div id="upcoming-eventview">
                <?php
                if (!empty($associationList)) {
                    foreach ($associationList as $association) {
                        $Url = site_url() . "o/" . $association['slug'];
                        ?>
                        <div class="db_EventboxNew EventTitleholder grid-lg-4 grid-md-6 grid-sm-6 grid-xs-12">
                            <!--Event id & Venue-->
                            <div class="EventIDHolder">
                                <div class="db_EventID">ID : <a href="<?php echo $Url; ?>" target="_blank"><?php echo $association['id']; ?></a></div>
                                <div class="db-public-status">
                                    <a title="Edit Event" class="tooltip-left hoeverclass" data-tooltip="Edit Event" href="<?php echo commonHelperGetPageUrl('association_profile') . "/" . $association['id']; ?>"><span class="fa fa-edit gridview-edit"></span></a>
                                </div>
                            </div>
                            <!--Event id & Venue-->

                            <div class="title-ribbon title-both-ribbon">
                                <h2>
                                    <a class="showeventbox" href="<?php echo $Url; ?>" target="_blank" title="<?php echo $association['name']; ?>"><?php echo $association['name']; ?></a>
                                </h2>
                            </div>
                            <div class="Event-GridHolder">
                                <div class="grid-lg-6 grid-xs-6 nopadding">
                                    <span>TOTAL CHAPTERS</span>
                                    <a class="showeventbox" href="<?php echo commonHelperGetPageUrl('association_chapters') . "/" . $association['id'] ?>">
                                        <p><?php echo $association['chapterCount']; ?></p>
                                    </a>
                                </div>
                                <div class="grid-lg-6 grid-xs-6 nopadding">
                                    <span>TOTAL MEMBERS</span>
                                    <a class="showeventbox" href="<?php echo commonHelperGetPageUrl('association_members') . "/" . $association['id'] ?>">
                                        <p><?php echo $association['memberCount']; ?></p>
                                    </a>
                                </div>
                            </div>

                            <div class="db-eventview-controls">
                                <ul>
                                    <li class="grid-lg-6 grid-sm-6 grid-xs-6 nopadding">
                                        <a href="<?php echo commonHelperGetPageUrl('association_dashboard') . "/" . $association['id']; ?>"><h5><span class="fa fa-dashboard"></span> Dashboard</h5></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<h6 id="no-results"> There are no assocations</h6>';
                }
                ?>
            </div>
        </div>
    </div>
</div>