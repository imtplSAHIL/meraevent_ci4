<!--important-->
<style type="text/css">
  .discoverheading {padding: 10px; background: #eaeaea; border-bottom: 2px solid #d0d0d0; font-size: 16px;}
  .sitemap {margin-top:10px !important;}.sitemap, .discoverheading { font-family:'Open Sans',sans-serif;}
  .sitemap ul {padding: 10px; margin-bottom: 20px; display: inline-block; width: 100%;}
  .sitemap ul li{ display: inline-block; width: 100%;}
  .sitemap ul li a{width: 100%; text-decoration: none; padding: 10px 0 5px 0; display: inline-block; color:#666; font-size:13px;} .sitemap ul li a:hover{color:#5f259f;}
  @media (min-width: 600px) and (max-width: 768px) { .site-grid-50 {width: 50%;float: left;} }
</style>
<div class="page-container">
<div class="wrap">
  <div class="container newsContainer">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-12 news_para">
      <h4 class="news_heading_1"> Sitemap </h4>
      </div>

    </div>
     
    <div class="row news_block_1 sitemap">
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 site-grid-50">
    <h4 class="discoverheading">Discover Events</h4>
    <ul>
        <li><a href="<?php echo $countryDetails['domain']; ?>">&ndash; &nbsp; Events In <?php echo $countryDetails['name']; ?></a></li>
        
        <?php
		if($citiesAvaialble){
			foreach($cityList as $ctId => $ctData){
				$cityName = strtolower(str_replace(' ','-',$ctData['name']));
				?><li><a href="<?php echo $countryDetails['domain']."/".$cityName; ?>-events" title="Events In <?php echo $ctData['name']; ?>">&ndash; &nbsp; Events In <?php echo $ctData['name']; ?></a></li><?php
			}
		}
		?>  
    </ul>  
  </div>
  
  
  <?php
  if(count($categoryList) > 0){
	  foreach($categoryList as $catKey => $catVal){
		  ?>
          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 site-grid-50">
            <h4 class="discoverheading">Discover <?php echo $catVal['name']; ?> Events</h4>
            <ul>
                <li><a href="<?php echo $countryDetails['domain']; ?>/<?php echo strtolower($catVal['name']); ?>">&ndash; &nbsp; <?php echo $catVal['name']; ?> Events In <?php echo $countryDetails['name']; ?></a></li>
                <?php
				if($citiesAvaialble){
					foreach($cityList as $ctId => $ctData){
						$cityName = strtolower(str_replace(' ','-',$ctData['name']));
						//echo strtolower($catVal['name'])."<br>";
						if(in_array(strtolower($catVal['name']),$dynamicMicrosites)){
							?><li><a href="<?php echo $countryDetails['domain']; ?>/<?php echo strtolower($catVal['value']); ?>/<?php echo $cityName; ?>" title="<?php echo $catVal['name']; ?> Events In <?php echo $ctData['name']; ?>">&ndash; &nbsp;<?php echo $catVal['name']; ?> Events In <?php echo $ctData['name']; ?></a></li><?php
						}else{
							?><li><a href="<?php echo $countryDetails['domain']."/".$cityName; ?>-events/<?php echo strtolower($catVal['value']); ?>" title="<?php echo $catVal['name']; ?> Events In <?php echo $ctData['name']; ?>">&ndash; &nbsp;<?php echo $catVal['name']; ?> Events In <?php echo $ctData['name']; ?></a></li><?php
						}
					}
				}
				?>
            </ul>  
          </div>
          <?php
	  }
  }
  ?>
  
  

  

  

  
</div>
     
  </div>
  <!-- /.wrap --> 
</div>
<!-- /.page-container --> 
<!-- on scroll code-->
<?php  $this->load->view("includes/elements/home_scroll_filter.php"); ?>
