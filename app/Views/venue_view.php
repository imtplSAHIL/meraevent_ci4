<div class="container event_detail_main">
	<div class="col-sm-12 col-xs-12 header_img">
	<?php if(strlen($cityDetails['banner'])>0){?>
		<img src="<?php echo $cityDetails['banner'];?>" alt="<?php echo $cityDetails['name'];?>" title="<?php echo $cityDetails['name'];?>">
	<?php }?>
		<div id="event_div" class="" style="z-index: 99;">
            <div class="row orgbgcolor">
                <div class="img_below_cont ">
                    <h2><?php echo ucwords($cityDetails['name']);?></h2>
                </div>
                  <div class="Org_Rlist orgcontact_sublinks">
                      <?php
                             $tweet =  $title = $cityDetails['name']; 
                                $linkToShare = current_url();
                                $bitlyUrl=getTinyUrl($linkToShare);
                            ?>
                            <span class=""> <a
                                    href="http://www.facebook.com/share.php?u=<?= urlencode($linkToShare) ?>&title=Meraevents -<?= $title ?>"
                                    onClick="javascript: cGA('/event-share-facebook'); return fbs_click('<?= $linkToShare ?>', 'Meraevents - <?= $title ?> ')"
                                    target="_blank"> <i class="icon1 icon1-facebook"></i></a>
                            </span> 
                            <span class=""> <a
                                    onClick="javascript: cGA('/event-share-twitter');"
                                    href="https://twitter.com/share?url=<?= urlencode($linkToShare); ?>&amp;text=Meraevents - <?= $title ?>"
                                    target="_blank" class="nounderline social"> <i
                                            class="icon1 icon1-twitter"></i>
                            </a>
                            </span> 
                            <span class=""> <a
                                    onClick="javascript: cGA('/event-share-linkedin');"
                                    href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode($linkToShare) ?>&amp;title=<?php echo $tweet ?>&amp;summary=<?php echo $eventDetails['fullAddress'] ?>&amp;source=Meraevents"
                                    target="_blank" class="nounderline"> <i
                                            class="icon1 icon1-linkedin"></i></a>
                            </span> 
                            <span class=""> <a
                                    href="https://plus.google.com/share?url=<?= urlencode($linkToShare) ?>"
                                    target="_blank"> <i class="icon1 icon1-google-plus"></i>
                            </a>
                            </span>
                </div>  
            </div>

        </div>	
		
		
	</div>
	<div class="row">
	<?php if(strlen($cityDetails['information']) > 0){?>
            <h3 class="get_tickts">About <?php echo ucwords($cityDetails['name']);?></h3>
		<p>
		<?php echo $cityDetails['information'];?>
		</p> 
        <?php }?>
        </div>
	<div class="row">
		<div class="event-tabs orgeventtabs">
                    <a id="upcomingeventstab" class="eventsactive">
                        <h4 class="subHeadingFont"><span>Venues</span></h4>
                    </a>
                </div>
			<input type="hidden" id="page" value="<?php echo $page;?>" />
			<input type="hidden" id="cityId" value="<?php echo $cityId;?>" />
			<input type="hidden" id="rowId" value="<?php echo $rowId;?>" />
			<h4 id="no-venues" class="nomorevents" style="display:none;"> No Venues Found</h4>
			<ul id="venues" class="eventThumbs __web-inspector-hide-shortcut__">
                            <?php if(!empty($venuesData)){
                                foreach($venuesData as $key => $value){?>
                            <li class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbBlock">
                                <div class="event-box-shadow">
                                <a href="<?php echo commonHelperGetPageUrl('venue').$value['url'];?>" class="thumbnail">
                                    <div class="eventImg">
                                        <div style="position: absolute; z-index: 99; top: 40%; text-align: center; width: 100%; font-family: 'geomanist_regularregular', sans-serif; font-size: 21px; text-transform:uppercase; line-height: normal; color: #FFF;"><?php echo $value['name']?></div> 
                                        <img src="<?php echo $value['thumbnail']?>" width="" height="" alt="<?php echo $value['name']?>" title="<?php echo $value['name']?>" onerror="this.src='<?php echo $value['defaultImage'];?>'; this.onerror = null">
                                    </div>
                                    <div class="eventpadding bordernone">
                                        <h6>
                                            <span class="eveHeadWrap"><?php  echo $value['name']?></span>
                                        </h6>
                                        <div class="info text-ellipsis">
                                                <span class="icon-google_map_icon"></span> <span><?php echo $value['address'];?></span>
                                        </div></div>
                                </a>
                            </div>
                            </li>
                            <?php }}else{?>
                                            <h4 id="no-venues" class="text-center" > No Venues Found</h4>

                            <?php }?>
			</ul>
                    <div class="alignCenter" style="clear:both;display:block;">
                    <a id="viewMore" class="btn btn-primary borderGrey collapsed" <?php if($totalCount <= VENUES_EVENTS_DISPLAY_LIMIT ){?>style="display:none;" <?php }?>>View More</a>
                    </div>

		</div>

		<div class="col-sm-12 eventDetails" id="event_about"></div>
	</div>
</div>
<script>
//function setimage(e){
//	e.src= $(e).attr('errimg');
//}
                            
var api_getVenues = "<?php echo commonHelperGetPageUrl('api_getVenues');?>";
var venue_url = "<?php echo commonHelperGetPageUrl('venue');?>";
 </script>

