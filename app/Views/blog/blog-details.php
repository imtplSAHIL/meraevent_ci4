<section class="bdy-blk">
    <div class="container">
        <div class="inr-blk">
            <div class="clmns-pan clearBlock">
                <div class="lft-pan pulled-left">
                    <div class="sectin-2">
                        <?php $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
                        <ul class="socl-mdi-list">
                            <li><a class="facebook customer share" href="https://www.facebook.com/sharer.php?u=<?= $url; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook"></i><span>Share</span></a></li>
                            <li><a class="twitter customer share" href="https://twitter.com/share?url=<?= $url; ?>&amp;text=<?= $article_details['title'] ?>" title="Twitter share" target="_blank"><i class="fa fa-twitter"></i><span>Tweet</span></a></li>
                            <li><a class="linkedin customer share" href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $url; ?>" title="linkedin" target="_blank"><i class="fa fa-linkedin"></i><span>Linked In</span></a></li>
                        </ul>
                    </div>
                    <div class="sectin-3">
                        <ul class="menulisting">
                            <?php
                            foreach ($blog_categories as $catName => $category) {
                                $j = 1;
                                foreach ($articles as $artId => $article) {
                                    if ($article['blog_category_id'] == $category['id']) {
                                        ?>
                                        <li><a style="color:#4cc5d3;" href="<?php echo site_url() . 'blog/category/' . $category['slug'] ?>"><?php echo ucfirst($category['blogtitle']); ?></a></li>
                                        <?php
                                        if ($j++ == 1) {
                                            break;
                                        }
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="mid-pan pulled-left">
                    <div class="mid-cont">
                        <figure> <img src="<?php echo $article_details['file_name']; ?>" alt="" title=""> </figure>
                        <h6><?php echo date('jS M, Y', strtotime($article_details['created'])); ?></h6>
                        <h1><?= $article_details['title'] ?></h1>
                        <p><?= stripslashes($article_details['description']); ?></p>
                    </div>
                </div>
                <div class="rit-pan pulled-right">
                    <?php if (!empty($article_details['event_name'])) { ?>
                        <div class="eventDetails">
                            <h4 class="title-1"><?= $article_details['event_name'] ?></h4>
                            <ul>
                                <li><i class="fa fa-calendar"></i><?php echo date('jS M, Y', strtotime($article_details['event_date'])); ?></li>
                                <li><i class="fa fa-map-marker"></i><?= $article_details['event_location'] ?></li>
                                <li><i class="fa fa-inr"></i><?= $article_details['event_ticket_price'] ?></li>
                            </ul>
                            <p><a target="_blank" href="<?= $article_details['event_url'] ?>">Book Now</a></p>
                        </div>
                    <?php } ?>
                    <?php if (!empty($nArticles)) { ?>
                        <h5>RELATED POSTS</h5>
                        <ul class="reltd-lst">
                            <?php foreach ($nArticles as $article) { ?>
                                <li>
                                    <a href="<?php echo site_url() . 'blog/' . $article['slug']; ?>"><img src="<?php echo $article['logopath'] ?>" alt="" title="">
                                        <h6><?= $article['title'] ?></h6>
                                    </a>
                                    <?php
                                    foreach ($categoriesList as $category) {
                                        if ($category['id'] = $article['blog_category_id']) {
                                            ?>
                                            <p><?php echo $category['blogtitle'] ?></p>
                                            <?php
                                        }
                                    }
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <div class="commentBlock">
                <div class="cb-intr">
                    <div class="header-title-1">
                        <h5>Comments</h5>
                        <h5 class="comment-resp-msg" style="text-align: center; font-size: 12px;color: green;"></h5>
                    </div>
                    <div class="commentBox">
                        <form id="articleComments" method="post">
                            <div class="details">
                                <input type="text" id="name" name="name" placeholder="Name" required>
                                <input type="email" id="email" name="email" placeholder="Email" required>
                                <input type="hidden" id="article_id" name="article_id" value="<?php echo $article_details['id']; ?>" placeholder="Email" required>

                            </div>
                            <div class="comment">
                                <textarea placeholder="Comment..." name="comment" id="comment"></textarea>
                            </div>
                            <div class="btn">
                                <button id="postbtn" type="button">Post</button>
                            </div>
                        </form>
                    </div>
                    <div class="postsBox">
                        <?php
                        if (count($comments['comments']) > 0) {
                            foreach ($comments['comments'] as $comment) {
                                ?>
                                <div class="postBox">
                                    <div class="profilePic"> <img src="images/default-pic.png" alt=""> </div>
                                    <div class="postDetails">
                                        <h6><?php echo $comment['comment_by_name']; ?> <span><?php echo date('jS M, Y', strtotime($comment['created'])); ?></span> </h6>
                                        <p><?php echo $comment['comment']; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
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

