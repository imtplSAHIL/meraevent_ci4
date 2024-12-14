<section class="bdy-blk">
    <div class="container">
        <div class="blk-3 clearBlock">
            <?php
            if (!empty($articles)) {
                ?>
                <div class="cat-dyder-pnl clearBlock">
                    <div class="catg-title pull-left">
                        <h4 style="color:#dc5555; border-bottom:1px solid #dc5555"><?= $articles['category_name']; ?><i class="fa fa-chevron-right"></i></h4>
                    </div>
                    <div class="catg-cont pull-right">
                        <ul class="ind-cat-lst cat-list">
                            <?php
                            if (count($articles['blog_articles']) > 0) {
                                foreach ($articles['blog_articles'] as $key => $category_article) {
                                    ?>
                                    <li>
                                        <div>
                                            <a href="<?php echo site_url() . 'blog/' . $category_article['slug']; ?>">
                                                <img class="max-resimg" src="<?php echo $category_article['logoPath']; ?>" alt="" title="">
                                                <h5><?= $category_article['title']; ?></h5>
                                            </a>
                                            <p><?= substr(strip_tags($category_article['description']), 0, 170) . '.....'; ?></p>
                                            <footer class="clearBlock"> 
                                                <span class="pull-right"><?php echo date('jS M, Y', strtotime($category_article['created'])); ?></span> 
                                            </footer>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php } else { ?>
                <div class="cat-dyder-pnl clearBlock">
                    <div class="catg-title pull-left">
                        <h4 style="color:#dc5555; border-bottom:1px solid #dc5555">No data available</h4>
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
                                foreach ($categories as $category) {
                                    if ($popuplar_article['blog_category_id'] == $category['id']) {
                                        ?>
                                        <p><?php echo substr(strip_tags($category['blogtitle']), 0, 20); ?></p>
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