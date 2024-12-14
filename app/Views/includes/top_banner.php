<?php
$topBannerCount = !empty($topBannerList) ? count($topBannerList) : 0;
?>
<div class="carousel-inner" role="listbox">
<?php if($topBannerCount > 0): ?>
    <?php
    foreach($topBannerList as $index => $banValue):
        $active = ($index == 0) ? "active" : "";
        $bannerTitle = $banValue['title'];
        $bannerImage = $banValue['bannerImage'];
        $bannerUrl = $banValue['url'];
        $bannerTarget = $banValue['target'] ?? '_self';
    ?>
    <div class="item <?= $active ?>">
        <a href="<?= $bannerUrl ?>" target="<?= $bannerTarget ?>" title="<?= $bannerTitle ?>">
            <img src="<?= $bannerImage ?>" alt="<?= $bannerTitle ?>">
        </a>
    </div>
    <?php endforeach; ?>
    
    <?php if($topBannerCount > 1): ?>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
    <?php endif; ?>
<?php else: ?>
    <!-- Default banner or empty state -->
    <div class="item active">
        <img src="<?= $images_static_path ?>default-banner.jpg" alt="Welcome">
    </div>
<?php endif; ?>
</div>