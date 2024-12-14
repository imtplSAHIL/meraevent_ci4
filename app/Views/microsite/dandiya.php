<?php $currentYear = date('Y'); ?>
<!DOCTYPE html>
<html lang="en">
   <head>
    
      <meta charset="utf-8">
     	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" http-equiv="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" http-equiv="keywords" content="<?php echo $pageKeywords; ?>" />
    <?php if(!empty($canonicalurl)){?>
         <link rel="canonical" href="<?php echo $canonicalurl; ?>"/>  
    <?php }?>
   
     <meta name="author" content="MeraEvents" />
    <meta name="rating" content="general" /> 
	<title><?php echo $pageTitle; ?></title>
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
   <body id="page-top" class="index" onload="resetfilters()">
      <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
         <div class="container fluid">
            <div class="navbar-header page-scroll">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
               </button>
               <a class="navbar-brand" href="<?php echo site_url();?>dandiya">
                  <img src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/img/meraevents-logo-y.svg">
               </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav navbar-right">
          <li <?php if(strtolower($currentCity) == 'india') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya">All Cities</a> </li>
          <li <?php if(strtolower($currentCity) == 'hyderabad') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/hyderabad" >Hyderabad</a></li>
          <li <?php if(strtolower($currentCity) == 'bengaluru') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/bengaluru">Bengaluru</a></li>
          <!--<li <?php if(strtolower($currentCity) == 'chennai') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/chennai">Chennai</a></li>-->
          <li <?php if(strtolower($currentCity) == 'delhi') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/delhi">Delhi/NCR</a></li>
          <li <?php if(strtolower($currentCity) == 'mumbai') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/mumbai">Mumbai</a></li>
          <li <?php if(strtolower($currentCity) == 'pune') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/pune">Pune</a></li>
          <!--<li <?php if(strtolower($currentCity) == 'goa') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/goa">Goa</a></li>-->
		  <li <?php if(strtolower($currentCity) == 'ahmedabad') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/ahmedabad">Ahmedabad</a></li>
		  <li <?php if(strtolower($currentCity) == 'kolkata') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/kolkata">Kolkata</a></li>
		  <li <?php if(strtolower($currentCity) == 'jaipur') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>dandiya/jaipur">Jaipur</a></li>
          
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container-fluid -->
      </nav>
      <!-- Header -->
      <header class="sliderhead" <?php if(count($bannerList) == 0) { ?>style="height: 50px"<?php } ?>>
         <div class="container-fluid">
            <div class="center slider">
				       <?php
	if(count($bannerList) > 0)
	{
		
					$bcount = 1;
					foreach($bannerList as $banner)
					{
						?><div class="item <?php echo ($bcount==1)?'active':''; ?>">
					      		<a href="<?php echo $banner['url']; ?>" target="_blank"><img data-lazy="<?php echo $banner['bannerImage']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>"></a>
					    </div><?php
						$bcount++;
					}					
					
	} else { ?>

                  
                                          
               
	<?php } ?>
            </div>
         </div>
      </header>
      


      <section class="filterssection">
         <div class="container">
            <div class="row">

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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

               <!--<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
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
               </div><div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group search-filter margin10">
                    <button class="filterbtn" id="filterbtn">FILTER</button>
                  </div>
               </div>-->

            </div><!--Row End-->

            <!-- <div class="row">
                
            </div> -->


         </div><!--Container End-->
      </section>
      
      <section>
         <div class="container">
            <div class="row">
               <div class="col-lg-12 text-center">
                  <h1>Dandiya Events in <?php echo $currentCity; ?> <?php echo $currentYear; ?></h1>
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
                        <div class="b-tabs_pane-item col-lg-4 col-md-6 col-sm-6 col-xs-12 col-50" itemscope itemtype="https://schema.org/Event">
                           <a href="<?php echo $event['eventUrl']; ?>" itemprop="url">
                              <div class="c-box">
                                 <div class="c-box_inner">
                                    <div class="b-box_img-wrap b-box_grdnt-a bg-image">
                                       <img itemprop="image" src="<?php echo (strlen($event['thumbImage'])>0)?$event['thumbImage']:_HTTP_MICROSITE_CF_ROOT.'/img/dandiya-thumb.jpg'; ?>" alt="<?php echo $event['title']; ?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="event-footer">
                                 <div class="c-box_cont">
                                    <h3 class="c-box_ttl-s3" itemprop="name" style="float:left;"><?php echo $event['title']; ?></h3>
                                    <hr class="hr-pattern">
                                    <p class="c-box_txt" itemprop="location" itemscope itemtype="https://schema.org/Place"><span><?php echo substr($eventVenue,0,100); ?></span></p>
                                 </div>
                                 <span style="display:none" itemprop="endDate" content="<?php echo $event['endDate'];?>"></span>
                                 <div class="c-box_date-item" itemprop="startDate" content="<?php echo $startdate;?>">
                                    <time datetime="<?php echo $startdate;?>" class="date c-box_date"><span class="date_dt"><?php echo date('d',strtotime($startdate)) ;?></span><span class="date_rh"><span class="date_rh-m"><?php echo date('M',strtotime($startdate)) ;?></span></span><span class="date_ad"><?php echo date('h:i a',strtotime($startdate)) ;?></span></time>
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
                            <div class="nomoreevents pt50">No more events. <a href="<?php echo site_url(); ?>dandiya">Click here</a> to load all events.</div>
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
                  <div class="footer-col col-lg-4 col-md-6 col-sm-6 col-xs-12 footercities">
                     <h3>Browse Events</h3>
                     
                     <ul>
                        <li><a href="<?php  echo site_url();?>dandiya"><i class="fa fa-chevron-right"></i> Dandiya Events in India <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>dandiya/hyderabad"><i class="fa fa-chevron-right"></i> Dandiya Events in Hyderabad <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>dandiya/bengaluru"><i class="fa fa-chevron-right"></i> Dandiya Events in Bengaluru <?php echo $currentYear; ?></a></li>
                        <!--<li><a href="<?php  echo site_url();?>dandiya/chennai"><i class="fa fa-chevron-right"></i> Dandiya Events in Chennai <?php echo $currentYear; ?></a></li>-->
                        <li><a href="<?php  echo site_url();?>dandiya/delhi"><i class="fa fa-chevron-right"></i> Dandiya Events in New Delhi/NCR <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>dandiya/mumbai"><i class="fa fa-chevron-right"></i> Dandiya Events in Mumbai <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>dandiya/pune"><i class="fa fa-chevron-right"></i> Dandiya Events in Pune <?php echo $currentYear; ?></a></li>
                        <!--<li><a href="<?php  echo site_url();?>dandiya/goa"><i class="fa fa-chevron-right"></i> Dandiya Events in Goa <?php echo $currentYear; ?></a></li>-->
						<li><a href="<?php  echo site_url();?>dandiya/ahmedabad"><i class="fa fa-chevron-right"></i> Dandiya Events in Ahmedabad <?php echo $currentYear; ?></a></li>
						<li><a href="<?php  echo site_url();?>dandiya/kolkata"><i class="fa fa-chevron-right"></i> Dandiya Events in Kolkata <?php echo $currentYear; ?></a></li>
						<li><a href="<?php  echo site_url();?>dandiya/jaipur"><i class="fa fa-chevron-right"></i> Dandiya Events in Jaipur <?php echo $currentYear; ?></a></li>
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

                  <div class="footer-col col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <!--   <h3>Instagram</h3>  
                      LightWidget WIDGET<script src="//lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/d91801206a0e552fa583ec22aa416a2a.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0; overflow: hidden;"></iframe>    -->                
                  </div>

               </div>
            </div>
         </div>
         <div class="footer-below">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12">
                     Copyright &copy; <?php echo date("Y");?>, Versant Online Solutions Pvt Ltd.
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
	  

<?php 
if ($currentServer = 'PROD')
{
	?>
	<!-- <script>(function() {
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
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1463712837251114&amp;ev=PixelInitialized" /></noscript> -->
    
    
    
	<script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "BreadcrumbList",
 "itemListElement":
 [
  {
   "@type": "ListItem",
   "position": 1,
   "item":
   {
    "@id": "https://www.meraevents.com/",
    "name": "MeraEvents"
    }
  },
  {
   "@type": "ListItem",
   "position": 2,
   "item":
   {
    "@id": "https://www.meraevents.com/dandiya",
    "name": "Dandiya Events"
    }
  },
  {
   "@type": "ListItem",
  "position": 3,
  "item":
   {
     "@id": "https://www.meraevents.com/dandiya/<?php echo strtolower($currentCity);?>",
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
                data: { term: request.term, microsite:'dandiya',categoryId:1,subcategoryId:8 },
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
            url: '/api/event/list?countryId=14&categoryId=1&subcategoryId[]=8&day=6&page='+page+'&limit=24&eventMode=0&eventType=nonwebinar&'+cityAndState,
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
		
		var eventThumb = event.thumbImage;
		if(event.thumbImage.length > 0){
			if(!event.thumbImage.indexOf("categorylogo/")){
				eventThumb = '<?php echo _HTTP_MICROSITE_CF_ROOT.'/img/dandiya-thumb.jpg'; ?>';				}
		}else{
			eventThumb = '<?php echo _HTTP_MICROSITE_CF_ROOT.'/img/dandiya-thumb.jpg'; ?>';
		}
		
		
			
        html += '<div class="b-tabs_pane-item col-lg-4 col-md-6 col-sm-6 col-xs-12 col-50" itemscope itemtype="https://schema.org/Event"><a href='+event.eventUrl+' itemprop="url"><div class="c-box"><div class="c-box_inner"><div class="b-box_img-wrap b-box_grdnt-a bg-image">';
		html += '<img itemprop="image" src="'+eventThumb+'" width="" height="" alt="'+event.title+'" title="'+event.title+'" onerror="<?php echo _HTTP_MICROSITE_CF_ROOT.'/img/dandiya-thumb.jpg'; ?>; this.onerror = null" />';
		html += '</div></div></div><div class="event-footer"><div class="c-box_cont"><h3 style="float:left;" class="c-box_ttl-s3" itemprop="name">';
        html += event.title+'</h3><hr class="hr-pattern"><p class="c-box_txt" itemprop="location" itemscope itemtype="https://schema.org/Place"><span itemprop="name">';
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


<?php

include(APPPATH."/views/includes/elements/wizrocket.php");
//Loading Google ANalytics
include(APPPATH."/views/includes/elements/googleanalytics.php");

// Loading adroll tag
include(APPPATH."/views/includes/elements/adroll_tag.php");

?>	
	 

	 
   </body>
</html>