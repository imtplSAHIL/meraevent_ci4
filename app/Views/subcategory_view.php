<script type="text/javascript">
var dashboard_eventhome="<?php echo commonHelperGetPageUrl('dashboard-eventhome');?>";
var add_bookmark = "<?php echo commonHelperGetPageUrl('api_add_bookmark'); ?>";
var remove_bookmark = "<?php echo commonHelperGetPageUrl('api_remove_bookmark'); ?>";
var api_eventList = "<?php echo commonHelperGetPageUrl('api_eventList'); ?>";
//variable fro detecting page of bookmark view
var bookmark_page="<?php echo $bookmark_page;?>";
var page= parseInt("<?php echo $eventsList['page'];?>");
var bookmark_count= parseInt("<?php echo $eventsList['total'];?>");
var countryId = "<?php echo $defaultCountryId; ?>";
var cityId = "<?php echo $defaultCityId; ?>";
var categoryId = "<?php echo $defaultCategoryId; ?>";
var subcategoryId = <?php echo isset($selectedSubcategoryId) ? "[".implode(',',$selectedSubcategoryId)."]" : "\"\"" ?>;
</script>

<div class="page-container">
  <div class="wrap">
    <div class="container subcategorypage_view">
      <?php if(count($topBannerList) > 0){ ?> 
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
       <?php $this->load->view('includes/top_banner'); ?>
      </div>
      <?php } ?>
               
     <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="titletext"><?php if(isset($subcategoryName)){ echo $subcategoryName; } ?></h1>
        </div> 
     </div>

      <div class="row">

        <?php if(count($eventsList) > 0 ) { ?>
        <ul id="eventThumbs" class="eventThumbs">
              <?php
                    $eventsListOnly =  $eventsList['eventList'];
                  foreach($eventsListOnly as $key=>$eventData) { ?>

                 <li class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbBlock bookmarkid_<?php echo $eventData['id'];?>">
                  <div class="event-box-shadow">
                    <a href="<?php echo $eventData['eventUrl']; ?>" class="thumbnail">
                      <div class="eventImg">
                        <img src="<?php echo $eventData['thumbImage']; ?>" width="" height=""
                        alt="<?php echo $eventData['title']; ?>" title="<?php echo $eventData['title']; ?>" onError="this.src='<?php echo $eventData['defaultThumbImage']; ?>'; this.onerror = null" />
                      </div>
                      <div class="eventpadding">
                        <h2>
                        <span class="eveHeadWrap"><?php echo $eventData['title']; ?></span>
                        </h2>
                        <div class="info">
                          <?php if($eventData['masterEvent'] == FALSE){ ?>
                          <span content="<?php echo $startDate;?>"><i class="icon2-calendar-o"></i> <?php echo allTimeFormats($eventData['startDate'],15); ?></span>
                          <?php }else{ ?>
                          <span><i class="icon2-calendar-o"></i> Multiple Dates</span>
                          <?php }?>
                        </div>
                        <div class="eventCity" style='display:<?php if($defaultCityName == "All Cities"){ ?> block <?php } else { ?> block <?php } ?>;'>
                          <span><?php echo $eventData['cityName'];?></span>
                        </div>
                      </div>
                    </a> 
                  <a href="<?php echo $eventData['eventUrl']; ?>" class="category">
                  <span class="mecat-<?php echo strtolower(preg_replace("/[^a-zA-Z]/", "", $eventData['categoryName'])); ?> col<?php echo strtolower(preg_replace("/[^a-zA-Z]/", "", $eventData['categoryName'])); ?>"></span> 
                  <span class="catName"><em><?php echo $eventData['categoryName']; ?></em>
                   </span>
                  </a>
                  <span  event_id="<?php echo $eventData['id'];  ?>" <?php if($eventData['bookMarked'] == 1){echo " class='add_bookmark icon2-bookmark ' rel='remove' title='Remove bookmark'"; }else{echo " class='icon2-bookmark-o add_bookmark'  rel='add' title='Add bookmark' "; }?> >
                  </span>
                </div>
                </li>  

             <?php }  ?>   
         </ul>  
          <?php }else{  ?> 
            <div class="col-lg-12 noeventsfound padding-sixty">No Events Found</div>    
          <?php } ?>             
<input type="text" name="page" id="page" value="2" hidden>
<div class="col-lg-12 text-center loadmoreevents">
         <div class="alignCenter" >
          <a id="viewMoreEvents" class="btn btn-primary borderGrey collapsed" data-wipe="View More Events" style="position: relative; display:<?php echo (count($eventsList) > 0 && $eventsList['nextPage'])?"inline-block":"none";?>"
             data-toggle="collapse" href="" aria-expanded="false" aria-controls="popularEvents">
            More Events </a>
        </div>
</div>
 
      </div> <!-- /.Event Grid Row End --> 

    </div> <!-- /.container subcategorypage_view -->

    <div class="container-fluid marginbottom50">
      <?php if(isset($subCategorycontent) && !empty($subCategorycontent)){ ?> 
        <div class="subcategory-bg padding-fifty">
        <div class="container">
        
          <div class="col-lg-12">
            <p><?php echo $subCategorycontent['description']; ?></p>
          </div>
  <!--         <div class="col-lg-6">
            <img src="<?php echo $subCategorycontent['contentImage']; ?>">
          </div> -->
        
        </div>
        </div>
      <?php } ?>
       
    </div>


  </div> <!-- /.Wrap -->
</div> <!-- /.page-container -->
<!-- on scroll code-->






