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
      <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet" type="text/css">   
      <style type="text/css">
        .event-footer .c-box_ttl-s3 {
          font-weight: 500;
        }
        .event-footer .c-box_ttl-s3, .c-box_txt {
         text-align: left;
        }
      </style>   
      <script async src="https://www.googletagmanager.com/gtag/js?id=AW-985224900"></script> 
      <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-985224900'); </script>
      <script type="text/javascript" language="javascript">
         var currentSite = '<?php echo site_url(); ?>';
         var cityId = '<?php echo $cityId; ?>';
         var stateId = '<?php echo $stateId; ?>';
      </script>
      <link href="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/css/main.927fa6c9.chunk.css?v=1" rel="stylesheet">

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
               <a class="navbar-brand" href="<?php echo site_url();?>valentinesday">
               <img src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/img/meraevents-logo-y.svg">
               </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav navbar-right">
                  <li <?php if(strtolower($currentCity) == 'india') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday">All Cities</a> </li>
                  <li <?php if(strtolower($currentCity) == 'hyderabad') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/hyderabad" >Hyderabad</a></li>
                  <li <?php if(strtolower($currentCity) == 'bengaluru') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/bengaluru">Bengaluru</a></li>
                  <li <?php if(strtolower($currentCity) == 'chennai') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/chennai">Chennai</a></li>
                  <li <?php if(strtolower($currentCity) == 'delhi') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/delhi">Delhi/NCR</a></li>
                  <li <?php if(strtolower($currentCity) == 'mumbai') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/mumbai">Mumbai</a></li>
                  <li <?php if(strtolower($currentCity) == 'pune') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/pune">Pune</a></li>
                  <li <?php if(strtolower($currentCity) == 'goa') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/goa">Goa</a></li>
                  <li <?php if(strtolower($currentCity) == 'ahmedabad') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/ahmedabad">Ahmedabad</a></li>
                  <li <?php if(strtolower($currentCity) == 'kolkata') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/kolkata">Kolkata</a></li>
                  <li <?php if(strtolower($currentCity) == 'jaipur') { echo 'class="active"'; } ?>><a href="<?php  echo site_url();?>valentinesday/jaipur">Jaipur</a></li>
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
                  if(count($bannerList) > 0)
                  {                    
                      $bcount = 1;
                      foreach($bannerList as $banner)
                      {
                ?>
               <div class="item <?php echo ($bcount==1)?'active':''; ?>">
                  <a href="<?php echo $banner['url']; ?>" target="_blank"><img data-lazy="<?php echo $banner['bannerImage']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>"></a>
               </div>
               <?php
                  $bcount++;
                  }                  
                  } else { ?>

                   <div><a href="#" target="_blank"><img src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/img/valentinesday-banner-1.png" /></a></div>
                   <div><a href="#" target="_blank"><img src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/img/valentinesday-banner-2.png" /></a></div>

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
               </div>
               <!--Search Field-->
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
            </div>
            <!--Row End-->
            <!-- <div class="row">
               </div> -->
         </div>
         <!--Container End-->
      </section>
      <section>
         <div class="container">
            <div class="row">
               <div class="col-lg-12 text-center">
                  <h1>Valentines Day Events in <?php echo $currentCity; ?> <?php echo $currentYear; ?></h1>
               </div>
            </div>
            <div class="row">
               <div class="b-content">
                  <div class="b-box-wrap">
                     <input type="hidden" id="page" name="page" value="1">
                     <div id="root"></div>
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
                        <li><a href="<?php  echo site_url();?>valentinesday"><i class="fa fa-chevron-right"></i> Valentines Day Events in India <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/hyderabad"><i class="fa fa-chevron-right"></i> Valentines Day Events in Hyderabad <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/bengaluru"><i class="fa fa-chevron-right"></i> Valentines Day Events in Bengaluru <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/chennai"><i class="fa fa-chevron-right"></i> Valentines Day Events in Chennai <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/delhi"><i class="fa fa-chevron-right"></i> Valentines Day Events in New Delhi/NCR <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/mumbai"><i class="fa fa-chevron-right"></i> Valentines Day Events in Mumbai <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/pune"><i class="fa fa-chevron-right"></i> Valentines Day Events in Pune <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/goa"><i class="fa fa-chevron-right"></i> Valentines Day Events in Goa <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/ahmedabad"><i class="fa fa-chevron-right"></i> Valentines Day Events in Ahmedabad <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/kolkata"><i class="fa fa-chevron-right"></i> Valentines Day Events in Kolkata <?php echo $currentYear; ?></a></li>
                        <li><a href="<?php  echo site_url();?>valentinesday/jaipur"><i class="fa fa-chevron-right"></i> Valentines Day Events in Jaipur <?php echo $currentYear; ?></a></li>
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
             "@id": "https://www.meraevents.com/valentinesday",
             "name": "Valentines Day Events"
             }
           },
           {
            "@type": "ListItem",
           "position": 3,
           "item":
            {
              "@id": "https://www.meraevents.com/valentinesday/<?php echo strtolower($currentCity);?>",
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
                   data: { term: request.term, microsite:'valentinesday',categoryId:1,subcategoryId:[1652] },
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
          
         });
         
      </script>
      <script>!function(l){function e(e){for(var r,t,n=e[0],o=e[1],u=e[2],f=0,i=[];f<n.length;f++)t=n[f],p[t]&&i.push(p[t][0]),p[t]=0;for(r in o)Object.prototype.hasOwnProperty.call(o,r)&&(l[r]=o[r]);for(s&&s(e);i.length;)i.shift()();return c.push.apply(c,u||[]),a()}function a(){for(var e,r=0;r<c.length;r++){for(var t=c[r],n=!0,o=1;o<t.length;o++){var u=t[o];0!==p[u]&&(n=!1)}n&&(c.splice(r--,1),e=f(f.s=t[0]))}return e}var t={},p={2:0},c=[];function f(e){if(t[e])return t[e].exports;var r=t[e]={i:e,l:!1,exports:{}};return l[e].call(r.exports,r,r.exports,f),r.l=!0,r.exports}f.m=l,f.c=t,f.d=function(e,r,t){f.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:t})},f.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},f.t=function(r,e){if(1&e&&(r=f(r)),8&e)return r;if(4&e&&"object"==typeof r&&r&&r.__esModule)return r;var t=Object.create(null);if(f.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:r}),2&e&&"string"!=typeof r)for(var n in r)f.d(t,n,function(e){return r[e]}.bind(null,n));return t},f.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return f.d(r,"a",r),r},f.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},f.p="/";var r=window.webpackJsonp=window.webpackJsonp||[],n=r.push.bind(r);r.push=e,r=r.slice();for(var o=0;o<r.length;o++)e(r[o]);var s=n;a()}([])
      </script>
      <script src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/js/1.85bd7f66.chunk.js?v=2"></script>
      <script src="<?php echo _HTTP_MICROSITE_CF_ROOT; ?>/js/main.f736b470.chunk.js?v=2"></script>
      <?php
         include(APPPATH."/views/includes/elements/wizrocket.php");
         //Loading Google ANalytics
         include(APPPATH."/views/includes/elements/googleanalytics.php");
         
         // Loading adroll tag
         include(APPPATH."/views/includes/elements/adroll_tag.php");
         
         ?> 
   </body>
</html>