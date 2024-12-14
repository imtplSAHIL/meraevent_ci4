<?php
   //As per government order new year events are deleted for 2021.. So adding exit forcibly here and redirecting to home page.
   header('Location: https://www.meraevents.com/');
   exit;
?>
<!DOCTYPE html>
<html lang="en">
   <head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>	
    <meta name="description" http-equiv="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" http-equiv="keywords" content="<?php echo $pageKeywords; ?>" />
    <?php if(!empty($canonicalurl)){?>
     <link rel="canonical" href="<?php echo $canonicalurl; ?>"/>  
    <?php }?>

    <meta name="author" content="MeraEvents" />
    <meta name="rating" content="general" /> 

    <link href="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/css/bootstrap.min.css.gz" rel="stylesheet">
    <link href="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/css/styles.min.css.gz" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
      
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
	 
   </head>
   <body id="page-top" class="index" onload=resetfilters()>
      <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
         <div class="container fluid">
            <div class="navbar-header page-scroll">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
               </button>
               <a class="navbar-brand" href="<?php echo site_url();?>newyear">
                  <img src="https://static.meraevents.com/newyear/assets/img/meraevents-logo-y.svg">
               </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav navbar-right">
          <li <?php if(strtolower($currentCity) == 'india') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear">India</a> </li>
          <li <?php if(strtolower($currentCity) == 'hyderabad') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/hyderabad" >Hyderabad</a></li>
          <li <?php if(strtolower($currentCity) == 'bengaluru') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/bengaluru">Bengaluru</a></li>
          <li <?php if(strtolower($currentCity) == 'chennai') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/chennai">Chennai</a></li>
          <li <?php if(strtolower($currentCity) == 'delhi') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/delhi">Delhi/NCR</a></li>
          <li <?php if(strtolower($currentCity) == 'mumbai') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/mumbai">Mumbai</a></li>
          <li <?php if(strtolower($currentCity) == 'pune') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/pune">Pune</a></li>
          <li <?php if(strtolower($currentCity) == 'goa') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/goa">Goa</a></li>
		  <li <?php if(strtolower($currentCity) == 'ahmedabad') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/ahmedabad">Ahmedabad</a></li>
		  <li <?php if(strtolower($currentCity) == 'pondicherry') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/pondicherry">Pondicherry</a></li>
		  <li <?php if(strtolower($currentCity) == 'jaipur') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/jaipur">Jaipur</a></li>
		  <li <?php if(strtolower($currentCity) == 'others') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>newyear/others">Others</a></li>
          
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container-fluid -->
      </nav>
       <!-- Header -->
       <header class="sliderhead">
           <div class="container-fluid">
               <div class="center slider">
                   <?php
                   if (count($bannerList) > 0) {
                       $bcount = 1;
                       foreach ($bannerList as $banner) {
                           ?>
                           <div class="item <?php echo ($bcount == 1) ? 'active' : ''; ?>">
                               <a href="<?php echo $banner['url']; ?>" target="_blank"><img  data-lazy="<?php echo $banner['bannerImage']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>"></a>
                           </div>
                           <?php
                           $bcount++;
                       }
                   } else {
                       ?>
                       <!--<div><a href="#" target="_blank"><img u="image" data-lazy="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/img/nye-banner-1.png" /></a></div>-->
                       <div><a href="#" target="_blank"><img u="image" data-lazy="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/img/nye-banner-2.png" /></a></div>
                   <?php } ?>
               </div>
           </div>
       </header>

      <section class="filterssection">
         <div class="container">
            <div class="row">

              <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                 <div class="form-group event-search searchbox">
                    <form id="event-check" name="event-check" action="/search" method="get">
                       <input  type="text" autocomplete="off" name="keyword" id="keyword"  class="form-control ui-autocomplete-input"   placeholder="Search with event title or event id">
                       <button type="submit">Search</button>
                    </form>
                 </div>
                 <div style="display: none;" id="suggestions" class="suggestionsBox">
                    <div id="autoSuggestionsList" class="suggestionList">
                       &nbsp;
                    </div>
                 </div>
              </div><!--Search Field-->

               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group search-filter margin10">
				  
				  <select class="form-control priceselectbox" name="filtercat" id="filtercat">
                      <option value="">Filter By Category</option>
					  	<?php
						foreach($newyearfiltersList as $newyearfilters)
					{ ?>
                      <option value="<?php echo $newyearfilters['id'] ;?>"><?php echo $newyearfilters['name'] ;?></option>
                     <?php } ?> 
                    </select> 
                                   
               </div> 
</div>
               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group search-filter margin10">
                    
					<select class="form-control priceselectbox" name="filterprice" id="filterprice">
                      <option value="">Filter By Price</option>
                      <option value="0-1000">0 - 1000</option>
                      <option value="1001-2500">1001 - 2500</option>
                      <option value="2501-5000">2501 - 5000</option>
                      <option value="5001-10000">5001 - 10000</option>
                      <option value="10001">10000 Above</option>
                    </select> 
					
                    
                  </div>
               </div> 

               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group search-filter margin10">
                    <button class="filterbtn" id="filterbtn">FILTER</button>
                  </div>
               </div>

            </div><!--Row End-->

            <!-- <div class="row">
                
            </div> -->


         </div><!--Container End-->
      </section>
      
      <!-- <section class="padding-ten offers-webview">
         <div class="container offers-section">
            <div class="row">
                <div class="col-lg-12 text-center">
                  <img src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/img/nye-microsite-offers-banner.jpg" class="offerimage" />
                </div>
            </div>
         </div>
      </section>

      <section class="padding-ten offers-mobileview">
         <div class="container offers-section">
            <div class="row">
                <div class="col-lg-12 text-center">
                  <img src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/img/nye-microsite-offers-banner-mobile.jpg" class="offerimage" />
                </div>
            </div>
         </div>
      </section> -->

 

        <section>
         <div class="container">
            <div class="row">
               <div class="col-lg-12 text-center">
                  <h1>New year Events in <?php echo $currentCity; ?> 2021</h1>
               </div>
            </div>
            <div class="row">
               <div class="b-content">
                  <div class="b-box-wrap">
				  <input type="hidden" id="page" name="page" value="1">
				<?php
				$eventsData = $eventsList['eventList'];
				if(count($eventsData) > 0)
				{
					?>
                     <div class="b-tabs_content" id="eventsBox">
                    <?php
					foreach($eventsData as $event)
					{
						$eventVenue = $event['venueName'].", ".$event['cityName'];
					   $datetime = $event['startDate'];
                       $utc = new DateTime($datetime, new DateTimeZone('UTC'));
                       $utc->setTimezone(new DateTimeZone('Asia/Kolkata'));
                       $startdate=$utc->format('Y-m-d H:i:s');					
						
						?>
                        <!--Event Gird-->
                        <div class="b-tabs_pane-item col-lg-4 col-md-6 col-sm-6 col-xs-12 col-50" itemscope itemtype="http://schema.org/Event">
                           <a href="<?php echo $event['eventUrl']; ?>" itemprop="url">
                              <div class="c-box">
                                 <div class="c-box_inner">
                                    <div class="b-box_img-wrap b-box_grdnt-a bg-image">
                                       <img itemprop="image" src="<?php echo (strlen($event['thumbImage'])>0)?$event['thumbImage']:_HTTP_MICROSITE_CF_ROOT.'/img/newyear-t1456213091.jpg'; ?>" alt="<?php echo $event['title']; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="event-footer">
                                 <div class="c-box_cont">
                                    <h2 class="c-box_ttl-s3" itemprop="name" style="float:left;"><?php echo $event['title']; ?></h2>
                                    <hr class="hr-pattern">
                                    <p class="c-box_txt" itemprop="location" itemscope itemtype="http://schema.org/EventVenue"><span itemprop="name"><?php echo substr($event['venueName'].": ".$event['cityName'],0,100); ?></span><span itemprop="address" style="display: none"><?php echo substr($eventVenue,0,100).', India'; ?></span></p>
                                 </div>
                                 <div class="c-box_date-item" itemprop="startDate" content="<?php echo $startdate;?>">
                                    <time datetime="2016-09-23T20:00" class="date c-box_date"><span class="date_dt"><?php echo date('d',strtotime($startdate)) ;?></span><span class="date_rh"><span class="date_rh-m"><?php echo date('M',strtotime($startdate)) ;?></span></span><span class="date_ad"><?php echo date('h:i a',strtotime($startdate)) ;?></span></time>
                                 </div>
                              </div>
                           </a>
                        </div>
                        <!--Event Gird-->

                       <?php
				  }
					?>
                      
                     </div>

                     <!--Load More Section-->
				
                     <div class="row text-center" >
                        <div class="btn-icon_more" id="viewMoreEvents" style="display:<?php echo (count($eventsList) > 0 && $eventsList['nextPage'])?"inline-block":"none";?>">
                           <a class="btn btn-icon" id="loadmore">More events</a>                      
                        </div>
                       </div>
					  <!--Load More Section-->
                   <?php
					
				}
				else{
					?> <div class="row" id="noMoreEvents">
                            <div class="nomoreevents pt50">No more events. <a href="<?php echo site_url(); ?>newyear">Click here</a> to load all events.</div>
                    </div>
					 
                    <?php
				}
				?>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <footer>
         <div class="footer-above">
            <div class="container">
               <div class="row">



                  <div class="footer-col col-lg-4 col-md-6 col-sm-6 col-xs-12 newyearcities">
                     <h3>New Year Events & Parties 2021</h3>
                    <p style="font-size: 13px;margin-bottom: 20px;text-align: justify;margin-top: 20px;">Get ready to beat the new year at the beautiful moonlight party in India. Make this New Year Eve 2021 a memorable one by going to a one of a kind bash!!! This new year, reverberate in the celebrations at your favourite destinations moonlight 2021 under the stars with live music, DJ, dance parties and alcohol.</p>
                    <p style="font-size: 13px;text-align: justify;">Get ready to dine, dance, dazzle and gift yourself an extravagant and valuable experience by being a part of all the fun and excitement. Have a blast, groove to some silk beats and enjoy an unlimited flow of alcohol. Let’s gather at this massive new year’s 2021 blast as the momentum catches up with the clock ticking to strike 12.</p>
                  </div>


                  <div class="footer-col col-lg-4 col-md-6 col-sm-6 col-xs-12 newyearcities">
                     <h3>Browse Events</h3>
                     
                     <ul>
                        <li><a href="<?php  echo site_url();?>newyear"><i class="fa fa-chevron-right"></i> New Year Events in India 2021</a></li>
                        <li><a href="<?php  echo site_url();?>newyear/hyderabad"><i class="fa fa-chevron-right"></i> New Year Events in Hyderabad 2021</a></li>
                        <li><a href="<?php  echo site_url();?>newyear/bengaluru"><i class="fa fa-chevron-right"></i> New Year Events in Bengaluru 2021</a></li>
                        <li><a href="<?php  echo site_url();?>newyear/chennai"><i class="fa fa-chevron-right"></i> New Year Events in Chennai 2021</a></li>
                        <li><a href="<?php  echo site_url();?>newyear/delhi"><i class="fa fa-chevron-right"></i> New Year Events in New Delhi / NCR 2021</a></li>
                        <li><a href="<?php  echo site_url();?>newyear/mumbai"><i class="fa fa-chevron-right"></i> New Year Events in Mumbai 2021</a></li>
                        <li><a href="<?php  echo site_url();?>newyear/pune"><i class="fa fa-chevron-right"></i> New Year Events in Pune 2021</a></li>
                        <li><a href="<?php  echo site_url();?>newyear/goa"><i class="fa fa-chevron-right"></i> New Year Events in Goa 2021</a></li>
            						<li><a href="<?php  echo site_url();?>newyear/ahmedabad"><i class="fa fa-chevron-right"></i> New Year Events in Ahmedabad 2021</a></li>
            						<li><a href="<?php  echo site_url();?>newyear/pondicherry"><i class="fa fa-chevron-right"></i> New Year Events in Pondicherry 2021</a></li>
            						<li><a href="<?php  echo site_url();?>newyear/jaipur"><i class="fa fa-chevron-right"></i> New Year Events in Jaipur 2021</a></li>
                     </ul>
                  </div>

                  <!-- <div class="footer-col col-lg-4 col-md-6 col-sm-6 col-xs-12">
                     <h3>Browse By Keywords</h3>                     
                  </div> -->

                  <div class="footer-col col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <h3>Contact Us</h3>
                    
                     <div class="b-footer_contacts">
                     <div class="b-footer_contacts-mail col-sm-4 col-lg-12"><a href="mailto:support@meraevents.com" class="link"><i class="fa fa-fw fa-envelope"></i> support@meraevents.com</a></div>
                        <ul class="b-footer_contacts-phones col-sm-4 col-lg-12">
                           <li><a href="tel:040-49171447"><i class="fa fa-fw fa-phone"></i> 040-49171447</a></li>
                        </ul>
                     <ul class="list-inline">
                        <li>
                           <a href="https://www.facebook.com/meraeventsindia" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                        </li>
                        <li>
                           <a href="https://twitter.com/#!/meraeventsindia" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                        </li>
                        <li>
                           <a href="https://www.linkedin.com/company/meraevents" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                        </li>
                     </ul>
                     </div>
                  </div>

                  <!--<div class="footer-col col-lg-4 col-md-6 col-sm-6 col-xs-12">
                     <h3>Instagram</h3>                                           
                  </div>-->  

               </div>
            </div>
         </div>
         <div class="footer-below">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     Copyright &copy; <?php echo date ('Y')?>, Versant Online Solutions Pvt Ltd.
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
      <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
         <a class="btn btn-primary" href="#page-top">
         <i class="fa fa-chevron-up"></i>
         </a>
      </div>
      <?php if (in_array(strtolower($currentCity), array('hyderabad', 'bengaluru', 'chennai', 'mumbai', 'pune'))) { ?>
      <!-- <div class="modal" id="myModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body" style="padding: 0px">
                      <?php if(strtolower($currentCity) == 'hyderabad') { ?>
                      <a href="<?php  echo site_url();?>event/new-year-eve-2021-at-country-club"><img style="width: 100%" src="<?php  echo site_url();?>microsites/newyear/img/hyderabad.png"></a>
                      <?php } else if(strtolower($currentCity) == 'bengaluru') { ?>
                      <a href="<?php  echo site_url();?>event/nye-2021-at-taj-mg-road-ft-dj-essie-de-val"><img style="width: 100%" src="<?php  echo site_url();?>microsites/newyear/img/bengaluru.png"></a>
                      <?php } else if(strtolower($currentCity) == 'chennai') { ?>
                      <a href="<?php  echo site_url();?>event/destination-nye-2021-radisson-blu"><img style="width: 100%" src="<?php  echo site_url();?>microsites/newyear/img/chennai.png"></a>
                      <?php } else if(strtolower($currentCity) == 'mumbai') { ?>
                      <a href="<?php  echo site_url();?>event/disco-ball-nye-2021"><img style="width: 100%" src="<?php  echo site_url();?>microsites/newyear/img/mumbai.png"></a>
                      <?php } else if(strtolower($currentCity) == 'pune') { ?>
                      <a href="<?php  echo site_url();?>event/nye-2021-at-cuba-libre-wakad"><img style="width: 100%" src="<?php  echo site_url();?>microsites/newyear/img/pune.png"></a>
                      <?php } ?>
                  </div>
              </div>
          </div>
      </div> -->



      <?php } ?>

<?php 
if ($currentServer = 'PROD')
{
	?>
	<script>(function() {
    var _fbq = window._fbq || (window._fbq = []);
    if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
    }
    _fbq.push(['addPixelId', '1463712837251114']);
    })();
    window._fbq = window._fbq || [];
    window._fbq.push(['track', 'PixelInitialized', {}]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1463712837251114&amp;ev=PixelInitialized" /></noscript>
    
    
    <!--Twitter Conversion code-->
    <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
	<script type="text/javascript">twttr.conversion.trackPid('nu2if', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
    <noscript>
    <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=nu2if&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
    <img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=nu2if&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
    </noscript>
	<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "BreadcrumbList",
 "itemListElement":
 [
  {
   "@type": "ListItem",
   "position": 1,
   "item":
   {
    "@id": "https://www.meraevents.com/",
    "name": "Home"
    }
  },
  {
   "@type": "ListItem",
   "position": 2,
   "item":
   {
    "@id": "https://www.meraevents.com/newyear",
    "name": "New Year Events"
    }
  },
  {
   "@type": "ListItem",
  "position": 3,
  "item":
   {
     "@id": "https://www.meraevents.com/newyear/<?php echo strtolower($currentCity);?>",
     "name": "<?php echo ucwords(strtolower($currentCity));?>"
   }
  }
 ]
}
</script>
    <?php 
}
?>

      <!-- jQuery -->
      <script src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/js/jquery.min.js.gz"></script>
	    <script src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/js/jquery-ui.min.js.gz"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/js/bootstrap.min.js.gz"></script>
      <!-- Plugin JavaScript -->
      <script src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/js/jquery.easing.min.js.gz"></script>
      <!-- Theme JavaScript -->
      <script src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/js/nye-theme.min.js.gz"></script>
	  <script src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/js/slick.min.js.gz"></script>
	    <!-- ======== JavaScript ======== -->
    <script type="text/javascript" language="javascript">
	var currentSite = '<?php echo site_url(); ?>';
	var cityId = '<?php echo $cityId; ?>';
	var stateId = '<?php echo $stateId; ?>';
	</script>
      <script type="text/javascript">
      $(document).on('ready', function() {
        <?php if (in_array(strtolower($currentCity), array('hyderabad', 'bengaluru', 'chennai', 'mumbai', 'pune'))) { ?>
            setTimeout(function(){ $('#myModal').modal('show'); }, 300);
        <?php } ?>
        $(".center").slick({
           autoplay: true,
           autoplaySpeed: 3000,
           speed: 1000,
           dots: false,
           infinite: true,
           centerMode: true,
           centerPadding: '100px',
           slidesToShow: 1,
           arrows: true,
           cssEase: 'ease',
           easing: 'linear',
           edgeFriction: 0.35,
           lazyLoad: 'ondemand',
           mobileFirst: false,
           fade: false,
           slidesToScroll: 1,
            responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: true,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1,
              }
            }
         ]
        });
		
		
		$("#keyword").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '/api/search/searchDynamicMicrositesEventAutocomplete',
                type: "GET",
                dataType: "json",
                data: { term: request.term, microsite:'newyear',categoryId:8 },
                success: function(data) {
                    response(data);
					//console.log(data);
				}
			});
		},
		select: function(event, ui) {
				$(this).val(ui.item.url);
				window.location = currentSite+'event/'+ui.item.url;
				return false;
		},
			selectFirst: true,
			autoFocus: true
       });
	   $('#loadmore').on('click',function (e) {
		
		var cityAndState = '';
		if(cityId.length > 0 && cityId!=null){ cityAndState=cityAndState+'cityId='+cityId; }
		else if(stateId.length > 0 && stateId!=null){ cityAndState=cityAndState+'stateId='+stateId; }
		var page = $("#page").val();
		 page = parseInt(page) + 1;
		$("#page").val(page);
		$.ajax({
            url: '/api/event/list?countryId=14&categoryId=8&day=6&page='+page+'&limit=24&eventMode=0&eventType=nonwebinar&'+cityAndState,
            type: "GET",
            dataType: "json",
            success: function(data) {
				html = renderEvents(data);
                $("#eventsBox").append(html);
				  
                if (data.response.nextPage === false) {
                    // hiding the view more button and showing no more events text
                    $('#viewMoreEvents').hide();
                    $('#noMoreEvents').show();
                }
			    //console.log(data);
			}
		});
	}); 
	
	$('#filterbtn').on('click',function (e) {
		
		var cityAndState = '';
		if(cityId.length > 0 && cityId!=null){ cityAndState=cityAndState+'cityId='+cityId; }
		else if(stateId.length > 0 && stateId!=null){ cityAndState=cityAndState+'stateId='+stateId; }
		var cat = $("#filtercat").val();
		var price = $("#filterprice").val();
		if(cat!=""){
		filtcat = '&filcat='+cat;	
		}else{
			filtcat = '';
		}
		if(price!=""){
		filtprice = '&filtprice='+price;	
		}else{
			filtprice = '';
		}
		 
		$.ajax({
            url: '/api/event/filterlist?countryId=14&categoryId=8&day=6&limit=24&eventMode=0&eventType=nonwebinar&'+cityAndState+filtcat+filtprice,
            type: "GET",
            dataType: "json",
            success: function(data) {
				html = renderEvents(data);
                $("#eventsBox").html(html); 
				  
                if (data.response.nextPage === false) {
                    // hiding the view more button and showing no more events text
                    $('#viewMoreEvents').hide();
                    $('#noMoreEvents').show();
                }
			    //console.log(data);
			}
		});
    $('html, body').animate({ scrollTop: 450 }, 'slow', function () {
        //alert("reached top");
    });
	}); 
	
	
	  
       
      });
	  
	  function renderEvents(data) {
    var html = '';	
	if(data.response.total >  0){
    var totalEvents = data.response.eventList.length;  
	for (var i=0;i<totalEvents; i++)
    {  
       var event = data.response.eventList[i];
	   var datetime = event.startDate;  
        datetime = datetime.replace(/-/g,"/");	   
        var date = new Date(datetime);
        var month = date.toString().split(" ")[1].toUpperCase();	
        var day = date.toString().split(" ")[2];
        var qtime = date.toString().split(" ")[4];		
	    var h = (qtime.slice(0,2) % 12) || 12;
		h = (h > 9) ? h : '0'+h;
		var m = qtime.slice(3,5)
	    var ampm = qtime.slice(0,2)  < 12 ? 'a.m' : 'p.m'; 
		var time = h+":"+m+" "+ampm;
		
		var eventVenue = event.venueName+", "+event.cityName;
		var eventThumb = (event.thumbImage.length > 0 && event.thumbImage != 'https://static.meraevents.com/content/categorylogo/Entertainment1455800681.jpg')?event.thumbImage:'https://static.meraevents.com/microsites/newyear/img/newyear-t1456213091.jpg';		
        html += '<div class="b-tabs_pane-item col-lg-4 col-md-6 col-sm-6 col-xs-12 col-50" itemscope itemtype="http://schema.org/Event"><a href='+event.eventUrl+' itemprop="url"><div class="c-box"><div class="c-box_inner"><div class="b-box_img-wrap b-box_grdnt-a bg-image">';
		html += '<img itemprop="image" src="'+eventThumb+'" width="" height="" alt="'+event.title+'" title="'+event.title+'" onerror="https://static.meraevents.com/microsites/newyear/img/newyear-t1456213091.jpg" />';
		html += '</div></div></div><div class="event-footer"><div class="c-box_cont"><h2 style="float:left;" class="c-box_ttl-s3" itemprop="name">';
        html += event.title+'</h2><hr class="hr-pattern"><p class="c-box_txt" itemprop="location" itemscope itemtype="http://schema.org/Place"><span itemprop="name">';
        html += eventVenue+'</span></p></div><div class="c-box_date-item" itemprop="startDate" content="'+event.startDate+'"><time datetime="2016-09-23T20:00" class="date c-box_date"><span class="date_dt"> ';		
        html += day+'</span><span class="date_rh"><span class="date_rh-m">'+month+'</span></span><span class="date_ad">'+time+'</span></time></div></div></a></div>'; 		
    }
	}else{
		 $('#viewMoreEvents').hide();
	}
    return html;
}

function resetfilters(){
	$("#filtercat").val("");
	$("#filterprice").val("");
	
}
    </script>
	 
	 
	<script>
  
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41640740-1', 'auto');
ga('send', 'pageview');
 
</script>
<?php include(APPPATH."/views/includes/elements/googletagmanagercode.php");?>
 <?php include(APPPATH."/views/includes/elements/wizrocket.php");?>
<script type="text/javascript">
wizrocket.event.push("Visited from Microsite", {"Event Name":"newyear2021"});
</script>
<?php // Loading adroll tag
include(APPPATH."/views/includes/elements/adroll_tag.php");
?>
   </body>
</html>