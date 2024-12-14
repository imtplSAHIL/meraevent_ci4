<section class="bdy-blk">
    <div class="container">
        <div class="blk-1 clearBlock">
            <div class="bnr-blk pull-left">
                <div class="banner-carousel cont-slider">
                    <?php
                    if (!empty($articles)) {
                        foreach ($articles as $cnt => $article) {
                            if (!empty($article['file_name'])) {
                                ?>
                                <div class="item"> 
                                    <a href="<?php echo site_url() . 'blog/' . $article['slug']; ?>">
                                        <img src="<?php echo $article['logoPath']; ?>" alt="Articles" title=""></a>
                                    <article> 
                                        <a href="<?php echo site_url() . '' . $article['slug']; ?>"><h3><?php echo $article['title']; ?></h3></a>
                                    </article>
                                </div>
                                <?php
                            }
                            if ($cnt == 6) {
                                break;
                            }
                        }
                    } else {
                        ?>
                        <div class="cat-dyder-pnl clearBlock">
                            <div class="">
                                <h3 style="color:#dc5555; margin:10% 0% 0% 40%">No data available</h3>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="pull-right vid-block">
                <div class="vid-pnl">
                    <?php foreach ($latestVideos['items'] as $k => $videos) { ?>
                        <div class="vid-box"> <img class="max-resimg" src="<?= $videos['snippet']['thumbnails']['high']['url'] ?>" alt="" title=""> 
                            <a class="enow-vid" onclick="https://www.youtube.com/embed/<?= $videos['id']['videoId'] ?>?autoplay=1&rel=0"> <i class="fa fa-play-circle-o"></i>
                                <p><?= substr($videos['snippet']['title'], 0, 30) . '...'; ?></p>
                            </a> 
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="blk-3 clearBlock">
            <?php foreach ($blog_categories as $catName => $category) { ?>
                <div class="cat-dyder-pnl clearBlock">
                    <div class="catg-title pull-left">
                        <?php
                        $j = 1;
                        foreach ($articles as $artId => $article) {
                            if ($article['blog_category_id'] == $category['id']) {
                                ?>
                                <a href="<?php echo site_url() . 'blog/category/' . $category['slug']; ?>"><h4 style="color:#dc5555; border-bottom:1px solid #dc5555"><?php echo $category['blogtitle']; ?><i class="fa fa-chevron-right"></i></h4></a>
                                <?php
                                if ($j++ == 1) {
                                    break;
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="catg-cont pull-right">
                        <ul class="ind-cat-lst">
                            <?php
                            $i = 1;
                            foreach ($articles as $artId => $article) {
                                if ($article['blog_category_id'] == $category['id']) {
                                    ?>
                                    <li>
                                        <div><a href="<?php echo site_url() . 'blog/' . $article['slug']; ?>"><img class="max-resimg" src="<?php echo $article['logoPath']; ?>" alt="" title="">
                                                <h5><?php echo $article['title'] ?></h5>
                                            </a>
                                            <p><?= substr(strip_tags($article['description']), 0, 170) . '.....'; ?></p>
                                            <footer class="clearBlock"> <span class="pull-right"><?php echo date('jS M, Y', strtotime($article['created'])); ?></span></footer>
                                        </div>
                                    </li>
                                    <?php
                                    if ($i >= 3) {
                                        break 1;
                                    }
                                    $i++;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if (!empty($popuplar_articles)) { ?>
            <div class="blk-4 clearBlock">
                <h2>Most Popular</h2>
                <div class="ppulr-panel">
                    <ul class="ppulr-lst">
                        <?php foreach ($popuplar_articles as $popuplar_article) { ?>
                            <li>
                                <a href="<?php echo site_url() . 'blog/' . $popuplar_article['slug']; ?>">
                                    <img src="<?php echo $popuplar_article['pop_file_name']; ?>" alt="" title="">
                                    <h6><?= $popuplar_article['title']; ?></h6>
                                </a>
                                <?php
                                foreach ($blog_categories as $catName => $category) {
                                    if ($popuplar_article['blog_category_id'] == $category['id']) {
                                        ?>
                                        <p><?php echo substr(strip_tags($category['blogtitle']), 0, 20); ?>
                                        </p>
                                        <?php
                                    }
                                }
                                ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</section>