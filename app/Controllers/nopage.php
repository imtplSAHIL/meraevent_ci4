<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH . 'handlers/seodata_handler.php');

class NoPage extends CI_Controller {
    
     public function __construct() {
        parent::__construct();
        $this->seoHandler = new Seodata_handler();
     }
     
      public function index() { 
         
          $url = commonHelperGetPageUrl('home');
          
          $seoKeys = $paramArray = array();
          $param1 = $param2 = $param3 = '';
          
		  //var_dump(COUNTRY_URI);
          if(defined("COUNTRY_URI")){
            $param1 = COUNTRY_URI;
            $param2 = $this->uri->segment(1);
            $param3 = $this->uri->segment(2);
            $param4 = $this->uri->segment(3);
            $param5 = $this->uri->segment(4);
          }
          else{
            $param1 = $this->uri->segment(1);
            $param2 = $this->uri->segment(2);
            $param3 = $this->uri->segment(3);
            $param4 = $this->uri->segment(4);
            $param5 = $this->uri->segment(5);
          
          }
          

          
          if(isset($param1) && $param1 != ''){
              $paramArray[] = $param1;
          }
          if(isset($param2) && $param2 != ''){
              $paramArray[] = $param2;
          }
          if(isset($param3) && $param3 != ''){
              $paramArray[] = $param3;
          }
          if(isset($param4) && $param4 != ''){
              $paramArray[] = $param4;
          }
          if(isset($param5) && $param5 != ''){
              $paramArray[] = $param5;
          }
		  //print_r($paramArray); exit;
          //only one param
          $seoArray['url'] = $paramArray['0'];
		  
		  //print_r($paramArray); exit;
          if(count($paramArray) > 1){
              
              for ($i = 1; $i < count($paramArray); $i++) {
                    $seoArray['url'] .= '/'.$paramArray[$i];
                }
              //$seoArray['searchRegex'] = 1;
          }

        //URLS redirect 
        $hyderabadUrls  = array('search/hyderabad/newyear','search/hyderabad/new-year-events','NewYear/event/3112-new-year-party-with-dj-piyush-n-convention-hyderabad','newyear/Hyderabad/madhapur','blog/2011/12/17/top-new-year-parties-in-hyderabad-–-the-best-new-year-parties-of-hyderabad','master/Meraevents/newyear2013/Hyderabad','newyear/Hyderabad‎','blog/tag/new-year-events-2014-hyderabad/','search/hyderabad/new-years','Meraevents/newyear/Hyderabad','blog/tag/stag-parties-in-hyderabad-this-new-years-eve','newyear/Hyderabad/djpiyush','search/hyderabad/new-year-eve','blog/tag/new-year-events-in-hyderabad-2014','search/hyderabad/new-year-eve-2014','newyear/Hyderabad.','newyear/Hyderabad1','newyear/Hyderabadn','blog/2013/12/02/city-of-m-2014-prologue-new-year-fest-in-hyderabad','search/hyderabad/new-year','blog/2013/11/28/new-year-bash-in-hyderabad','blog/2013/11/18/new-year-events-in-hyderabad-2014','blog/2012/12/07/hyderabad-new-year-eve-parties','search/hyderabad/happy-new-year','blog/tag/new-year-parties-hyderabad','newyear/hyderAbadaaa','NewYear/event/new-year-bash-2013-the-square-hyderabad','newyear/Hyderabad/venues','newyear/Hyderabadclick','blog/2013/12/22/new-year-party-at-pickles-in-hyderabad','NewYear/HyderabadNew','newyear/Hyderabadnovotel','newyear/Hyderabad-Events','newyear/newyear/Hyderabad','newyear/Hyderabadpnr','newyearold/Hyderabad','blog/10-best-new-year-2014-events-in-hyderabad','master/Meraevents/newyear/Hyderabad','newyear/Hyderabad/kukatpally','blog/2013/11/28/bisket-new-year-bash-2014-hyderabad','blog/2013/11/19/coco-grande-new-year-eve-party-hyderabad','search/hyderabad/new-year-passes','Meraevents2.4/Meraevents/newyear/Hyderabad','search/hyderabad/newyear-ramoji','search/hyderabad/new-year-celebrations-2014','State/newyear/Hyderabad','blog/2012/12/06/new-year-parties-hyderabad-book-your-tickets-now','search/hyderabad/new-year-partt','newyear/hyd','newyear/hydarabad','newyear/hyde','newyear/Hyder','newyear/hyderbad','newyear/vijayawada','newyear/visakhapatnam','newyear/vizag','newyear/vskp','newyear/Warangal');
        if(in_array(urldecode($seoArray['url']), $hyderabadUrls)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear/hyderabad");
          exit();
        }
        $mumbaiUrls = array('blog/tag/new-year-2014-in-mumbai','blog/2013/12/03/midnight-flight-2014-to-paris-new-year-eves-party-in-mumbai','blog/2013/12/13/carnival-2013-new-years-eve-party-in-mumbai','blog/tag/new-year-eve-2014-parties-in-thane-mumbai','master/Meraevents/newyear/Mumbai','blog/2013/12/05/megablast-13-new-year-eve-party-in-mumbai','search/mumbai/new-years-eve-party-2','blog/2013/11/18/new-year-2014-events-in-mumbai','blog/2013/12/03/new-year-eve-party-in-mumbai','search/mumbai/new-year','newyear/navimumbai','NewYear/event/pirates-of-navi-mumbai-new-year-party','blog/2011/12/17/top-new-year-parties-in-mumbai-–-the-best-new-year-parties-of-mumbai','newyear/Mumbaiand','newyear/Mumbaiogle','search/mumbai/new-years-eve-party-2012','search/mumbai/new-years-eve-party-2013','search/mumbai/new-year-2014','search/mumbai/new-year-2015','newyear/Mumbai/panvel','newyear/Mumbai','newyear/Mumbai/2015','newyear/Mumbai/2014','newyear/newyear/Mumbai','blog/tag/midnight-flight-2014-to-paris-new-year-party-in-mumbai','blog/2012/12/10/new-year-parties-mumbai-book-now','blog/tag/megablast-13-new-year-eve-party-in-mumbai','State/newyear/Mumbai','blog/2013/12/04/new-year-party-2014-in-pali-beach-resort-mumbai','blog/tag/new-year-2014-events-in-mumbai','search/mumbai/new-year-night','newyearold/Mumbai','NewYear/event/new-year-bash--mohili-meadows-resort-karjat-mumbai','newyear/Mumbai/chembur','blog/tag/new-year-eve-party-in-mumbai');
        if(in_array(urldecode($seoArray['url']), $mumbaiUrls)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear/mumbai");
          exit();
        } 
        $kolkataUrls = array('newyear/kolkatta','newyear/kolkTA');
        if(in_array(urldecode($seoArray['url']), $mumbaiUrls)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear/kolkata");
          exit();
        } 
        $bangaloreUrls = array('search/bengaluru/new-year-bash','Meraevents2.4/Meraevents/newyear/Bengaluru','search/bengaluru/newyear-eve','search/bengaluru/new-year-event','newyear/newyear/Bengaluru','search/bengaluru/new-year-party-at-clarks-exotica','blog/2012/12/10/new-year-eve-parties-bengaluru','search/bengaluru/3112-new-year-party','newyearold/Bengaluru','search/bengaluru/new-year','State/newyear/Bengaluru','newyear/Bengaluru.','newyear/Bengaluru-please','blog/2010/12/06/new-year-party-heaven-11-bangalore-on-31st-december-8pm-onwards-book-your-ticket-now','blog/2010/12/14/gigantic-new-year-party-2011-at-e-zone-club-the-manhattan-2011-bangalore-book-your-tickets-now','blog/2011/12/18/top-new-year-parties-in-bangalore-the-best-new-year-parties-of-bangalore','blog/2013/11/18/new-year-2014-events-in-bangalore','blog/2013/11/18/new-year-eve-2014-party-bangalore','blog/2013/11/18/new-year-eve-party-bangalore','blog/2013/11/19/coco-grande-new-year-eve-party-bangalore','blog/2013/11/19/new-year-eve-party-bangalore','blog/2013/12/01/arabian-nights-new-year-2014-party-in-bangalorearabian-nights-new-year-2014-party-in-bangalore','blog/2013/12/02/masquerade-ball-night-new-year-2014-party-in-bangalore','blog/2013/12/02/royal-carnival-night-new-year-2014-party-in-bangalore','blog/2013/12/03/regalo-2014-new-year-party-in-bangalore','blog/2013/12/04/beach-2014-new-year-blast-in-bangalore','blog/2013/12/04/new-year-2014-parties-in-bangalore','blog/2013/12/15/2014-new-year-party-in-bangalore','blog/2013/12/15/loud-new-years-eve-2014-at-pebble-in-bangalore','blog/2013/12/18/five-best-new-year-parties-in-bangalore-for-stags','blog/2013/12/22/crescendo-2014-new-year-party-in-bangalore','blog/2013/12/22/royal-new-year-2014-celebration-with-deejay-jakeeh-in-bangalore','blog/tag/crescendo-2014-new-year-party-in-bangalore','blog/tag/masquerade-ball-night-new-year-2014-party-in-bangalore','blog/tag/new-year-2014-parties-and-events-in-bangalore-book-tickets-for-the-best-new-yearevents-2014-in-bangalore-buy-new-year-packages','blog/tag/new-year-2014-parties-and-events-in-bangalore-book-tickets-for-the-best-new-year-events-2014-in-bangalore-buy-new-year-packages','blog/tag/new-year-2014-parties-in-bangalore','blog/tag/new-year-parties-bangalore-2014','blog/tag/new-year-parties-in-bangalore-welcome-new-year-2014-with-a-bash-buy-new-year-party-tickets-online-for-31st-december-2013-celebrations','blog/tag/reincarnation-2014-new-year-party-in-bangalore','newyear/Bangalore','NewYear/event/cromozome-xx-13--ezone-club-bangalore','NewYear/event/dusk2dawn--new-year-2013-party-in-bangalore','NewYear/event/las-vegas-2013--manipal-county-bangalore','NewYear/event/oko-2013--bangalore','NewYear/event/the-last-party-2013--sutra-the-lalit-ashok-bangalore','newyear/banglore','newyear/bangluru','newyear/bengalore','newyear/benguluru','newyear/mysore','newyear/mumabi');
        if(in_array(urldecode($seoArray['url']), $bangaloreUrls)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear/bengaluru");
          exit();
        } 
        $puneUrl = array('blog/2013/11/27/new-year-2014-dj-party-in-pune','blog/2013/11/18/pune-new-year-eve-parties-2014','blog/2012/12/12/new-year-parties-pune-book-tickets-now','search/pune/new-year','blog/2013/12/12/evening-of-bonfires-on-new-year-eve-in-pune','newyear/maharashtra','blog/2013/12/13/dont-stop-lights-2013-new-year-party-in-vadodara','blog/tag/new-year-eve-party-in-vadodara','blog/tag/new-year-party-2013-in-vadodara','blog/tag/new-year-party-in-vadodara-2013','NewYear/event/new-year-disco-theme2013--vadodara','blog/tag/new-year-party-in-baroda');
        if(in_array(urldecode($seoArray['url']), $puneUrl)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear/pune");
          exit();
        } 
        $delhiUrls = array('blog/2011/12/18/top-new-year-parties-in-new-delhi-–-the-best-new-year-parties-of-new-delhi','blog/2012/12/12/new-year-parties-delhi-ncr','blog/2013/11/18/events-in-delhi-for-new-year-2014','blog/tag/new-year-2014-parties-and-events-in-delhi-ncr','blog/tag/new-year-parties-delhi-ncr-2014','newyear/delhi-ncr','newyear/NewDelhi1','newyear/NewDelhi23','newyearold/NewDelhi','search/newdelhi/new-year-eve','search/newdelhi/new-year-eve-events','State/newyear/NewDelhi','newyear/gurgaon');
        if(in_array(urldecode($seoArray['url']), $delhiUrls)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear/delhi");
          exit();
        } 
        $chennaiUrls = array('blog/2011/12/19/top-new-year-parties-in-chennai-–-the-best-new-year-parties-of-chennai','blog/2012/12/10/new-year-parties-chennai-book-your-tickets-now','blog/2013/11/18/events-in-chennai-for-new-year-2014','blog/2013/11/29/2014-incredible-new-year-beach-house-party-in-chennai','blog/2013/12/02/moon-dance-2014-new-year-event-in-chennai','blog/2013/12/05/new-year-2014-zombieland-theme-party-in-chennai','blog/2013/12/09/new-year-2014-grandeur-festival-chennai','blog/2013/12/11/holovisual-night-new-year-party-2014-in-chennai','blog/2013/12/11/step-in-2014-new-year-eve-party-in-chennai','blog/2013/12/13/new-year-2014-eve-party-in-chennai','blog/2013/12/13/the-tricolor-new-year-bash-in-chennai','blog/2013/12/19/katz-boom-2014-new-years-eve-in-chennai','blog/tag/2014-incredible-new-year-beach-house-party-in-chennai','blog/tag/2014-new-year-beach-house-party-in-chennai','blog/tag/2014-new-year-parties-in-chennai','blog/tag/moon-dance-2014-new-year-event-in-chennai','blog/tag/moon-dance-2014-new-year-party-in-chennai','blog/tag/new-year-2014-chennai','blog/tag/new-year-2014-eve-party-in-chennai','blog/tag/new-year-2014-parties-and-events-in-chennai','blog/tag/new-year-party-in-chennai-2013-2014','blog/tag/new-year-party-tickets-chennai','blog/tag/zombieland-new-year-theme-party-2014-in-chennai','master/Meraevents/newyear/Chennai','Meraevents2.4/Meraevents/newyear/Chennai','Newyear/Chennai‎','newyear/India/Chennai','newyearold/Chennai','search/chennai/newyear','search/chennai/new-year-party','search/chennai/new-years','State/newyear/Chennai','newyear/chenna');
        if(in_array(urldecode($seoArray['url']), $chennaiUrls)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear/chennai");
          exit();
        } 

        $indiaUrls = array('blog/2010/12/21/new-year-2011-party-in-india-get-register-online-book-your-ticket-now','blog/2010/12/23/india’s-best-new-year-parties-book-ticket-for-new-year-eventsnew-year-passes','blog/2011/12/22/new-years-eve-parties-around-india-all-the-best-parties-one-place-meraevents-com','blog/2013/11/18/new-year-2014-events-in-india','blog/2013/12/06/new-year-2014-parties-in-india-new-year-eve-parties','blog/2013/12/15/esselworld-bignite-2013-indias-largest-new-years-bash','blog/tag/indian-new-year-events-tickets-2014','blog/tag/new-year-2014-parties-in-india','master/Meraevents/newyear/India','newyear/Indiat','newyear/Indiaucode=DMM','newyear/newyear/India','newyear/newyear/newyear/India','newyear/newyear/newyear/newyear/India','newyear/newyear/newyear/newyear/newyear/India','newyear/Other/India','newyearold/All','newyearold/Other','search/all','search/allcities/new-year','search/allcities/new-year-eve','search/allcities/new-years-eve','State/newyear/All','newyear2013','newyearold','newyear/Home','newyear/index.php','my-events/newyear','newyear/2016','NEWYEAR/2017','NEWYEAR/2017/','master/Meraevents/Home','master/Meraevents/newyear','master/Meraevents/newyear/All','master/Meraevents/newyear/Other','master/Meraevents/newyear2013','Meraevents/newyear','Meraevents2.4/Meraevents/newyear','Meraevents2.4/Meraevents/newyear/All','Meraevents2.4/Meraevents/newyear/Other','blog/2010/12/events/newyear-events','blog/2011/12/Newyear-2012-Parties','blog/2013/11/18/new-year-eve-parties-2014','blog/newyear','blog/tag/2014-new-year','blog/tag/2014-new-year-parties','blog/tag/buy-new-year-party-tickets-online','blog/tag/new-year','blog/tag/new-year-2014-parties','blog/tag/new-year-2014-party','blog/tag/new-year-2014-party/page/2','blog/tag/new-year-2014-party-tickets','blog/tag/new-year-parties-2014','blog/tag/new-year-party','blog/tag/new-year-party-event-2014/page/2','blog/tag/new-year-passes','blog/tag/top-new-year-2014-parties','browse/newyear/All','Home','Home/newyear','List','NewYear/event/new-year-celebration-2013','NewYear/event/new-year-destination-2013','State/newyear/Other','newyear/my-tickets','newyear/navi','newyear/newyear','NewYear/event/new-year-party13','NewYear/event/new-year-party-2013','3.3/Meraevents/event/new-year-bash-event');
        if(in_array(urldecode($seoArray['url']), $indiaUrls)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear");
          exit();
        }          

        $goaUrls = array('State/newyear/Goa','newyear/goaaaa','newyearold/Goa');
        if(in_array(urldecode($seoArray['url']), $goaUrls)){
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".base_url()."newyear/goa");
          exit();
        } 
        $ahmedabadUrls = array('newyear/Puducherry','newyear/pondy','blog/tag/new-year-party-soiree-2014-in-pondicherry');
        if(in_array(urldecode($seoArray['url']), $ahmedabadUrls)){
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".base_url()."newyear/ahmedabad");
            exit();
        }
        $miscUrls = array('2015/12/09/camp-your-new-year-night-with-your-family','blog/2010/12/14/mega-new-year-eve-extravaganza-on-31st-december-2010-noida-book-your-tickets-now','blog/2011/12/23/new-years-eve-2012-with-jalebee-cartel-and-dj-aneez','blog/2011/12/24/new-years-eve-party-hulla-night-lonavala-venetian-carnival','blog/2011/12/29/new-years-eve-passes-getting-sold-out-fast-so-hurry-book-now','blog/2012/04/13/bengali-new-year-celebrations','blog/2012/12/18/new-year-bash-2013-10-lounge','blog/2012/12/18/new-year-party-2013-ramoji-film-city','blog/2012/12/19/slushy-nite-celebrity-club-2013-new-year-party','blog/2013/11/27/new-year-2014-dj-night-party-at-krishna-sundar-garden','blog/2013/11/27/new-year-2014-pool-side-party-in-coorg','blog/2013/12/01/musikon-manali-2013-new-years-eve-party','blog/2013/12/09/new-year-party-soiree-2014-in-pondicherry','blog/2013/12/17/cyclone-new-year-bash-2014-at-papyrus-port-resort','blog/2013/12/22/new-year-2014-dance-party-at-meerut','blog/2013/12/22/new-year-eve-with-dj-kartech-at-crystal-ballroom','blog/2013/12/22/new-year-eve-with-nizami-bandhu-performing-live-at-central-courtyard','blog/tag/bengali-new-year-celebrations-nababarsha','blog/tag/buy-new-year-party-tickets-online-for-31st-december-2013-celebrations','blog/tag/events-in-pondicherry-this-new-year','blog/tag/grandeur-new-year-festival-2014','blog/tag/new-year-2014-dance-party-at-meerut','blog/tag/new-year-2014-dj-night-party-at-krishna-sundar-garden','blog/tag/new-year-2014-pool-side-party-coorg','blog/tag/new-year-beach-house-party-in','master/Meraevents/event/new-year-bash-event','master/Meraevents/event/new-year-new-design','Meraevents2.4/Meraevents/event/i-amtesting-new-year-event','Meraevents2.4/Meraevents/event/new-year-event-on-stage','newyear/Allook','newyear/aurangabad','newyear/capetown','newyear/chandigarh','newyear/company-details','NewYear/event/2-day-night-stay-package-taracomfort-hotel-ramojji-film-city','NewYear/event/2-nights-new-year-party-package','NewYear/event/2-nights-stay-package-30th-31st-dec-shantiniketan-economy-stay','NewYear/event/2-nights-stay-package-30th-31st-dec-sitara-luxury-hotel','NewYear/event/2-nights-stay-package-30th-31st-dec-vasundhara-villa','NewYear/event/31st-dec--new-year-eve-party-in-udaipur-2012--2013','NewYear/event/31st-new-year-dj-party-in-ahmedabad-with-dj-devmani--welcome-2013','NewYear/event/31stnite-mega-blast-lets-greet-2013','NewYear/event/4-play-by-jersey-9-belapur','NewYear/event/amnesia-new-year-party-at-liv-lounge','NewYear/event/back-to-school-at-baroke--new-year-party','NewYear/event/biggest-new-year-bash--yazoo-park','NewYear/event/bnew-year-eve-2013-beach-party--casa-marina-resortb','NewYear/event/bollywood-night','NewYear/event/boondon-ka-paigham','NewYear/event/carnival-club-2013','NewYear/event/celebrate-new-year-eve-2013-oriental-pavillion','NewYear/event/celebrate-new-year--mantra-hill-resort-2013','NewYear/event/celebrate-new-years-eve-in-sufi-style-2013--king-arthur','NewYear/event/cest-la-vie-biggest-new-year-party','NewYear/event/cheers-2013','NewYear/event/club-leos-new-year-bash-2013','NewYear/event/dabangg-2013-the-golconda-hotel','NewYear/event/dance-throne-2013-nye-night','NewYear/event/della-adventure-new-years-eve-masquerade-ball','NewYear/event/desi-dhamaal-new-year-eve-2013','NewYear/event/desi-nite-nye-2013','NewYear/event/destination-2013-exotica','NewYear/event/detach-detox-dream_1','NewYear/event/electric-night--new-year-celebration-2013','NewYear/event/euphoria2013','NewYear/event/event-reloaded-2012-at-hotel-atrium','NewYear/event/fantasy-2013','NewYear/event/gangnam-2013','NewYear/event/ghost-at-vvip-colaba','NewYear/event/ghost-d-nye-bash-d-lake-view-resort','NewYear/event/glamour-and-glitz-carbon-the-park-hotel','NewYear/event/glow-party-at-manchester-united-caf-barcopy','NewYear/event/hangout-poolside-manali-resorts-water-park','NewYear/event/hollywood-to-bollywood-be-yourself','NewYear/event/hoopla-2013','NewYear/event/jashn-2013-sentosa-resorts','NewYear/event/lake-fiesta-2013','NewYear/event/last-standnew-year-bash-mahalaxmi-lawns-d.p.road-karve-nagar','NewYear/event/marvelous-2013','NewYear/event/mks-beautiful-31st-eve--gorai-beach','NewYear/event/-mystique-2013-the-golkonda-resort-and-spa','NewYear/event/new_year_party_jc_residency','NewYear/event/new-year-2013-10-lounge','NewYear/event/new-year-2013-celebrations--sanskruti','NewYear/event/new-year-2013-passes--starrock-avail-30-offer','NewYear/event/new-year-2013-taj-deccan','NewYear/event/new-year-bash-2013-taj-falaknuma-palace','NewYear/event/new-year-bash-at-licec','NewYear/event/new-year-bash-at-vapour','NewYear/event/new-year-blast-2013-at-coorg','NewYear/event/new-year-buffet-at-bricklane','NewYear/event/new-year-eve-2013-aros-at-hitex-campus','NewYear/event/new-year-eve-2013-the-woodrose-club','NewYear/event/new-year-eve-at-the-leela-kempinski-gurgaon','NewYear/event/new-year-eve-at-veranda','NewYear/event/new-year-eve-celebration-eternia-hinjewadi','NewYear/event/new-year-event-at-movida-cp-vegas-theme','NewYear/event/new-year-eve-party-at-bahi-kitchen-lounge-bar','NewYear/event/new-year-eve-prom-night-2013-at-cafe-ludus','NewYear/event/new-year-eve-theme-party','NewYear/event/new-year--pali-beach-resort','NewYear/event/new-year-paradise-party-2013','NewYear/event/new-year-part-at-hotel-moksh-2013','NewYear/event/new-year-party_nerul-gymkhana','NewYear/event/new-year-party-13-senora-beach-resorts','NewYear/event/new-year-party-2013-at-rfc','NewYear/event/new-year-party-2013-prakruti-resort','NewYear/event/new-year-party-adventure-plus','NewYear/event/new-year-party-at-lap--hotel-samrat','NewYear/event/new-year-party-at-royal-orchid-13','NewYear/event/new-year-party-at-tab-01','NewYear/event/new-years-eve-at-shiro','NewYear/event/new-years-eve-with-dj-enoch-benny','NewYear/event/night-of-elegance-2013-papyrus-port','NewYear/event/nothing-but-house-new-year-party','NewYear/event/nye-black--red-party-2013','NewYear/event/on-the-rocksblue-moon-club-mira-road-e','NewYear/event/rock-n-rolla--new-years-eve-party-2013','NewYear/event/sin-sation-2013','NewYear/event/slushy-nite-celebrity-club','NewYear/event/sparkz-new-year-bash-2013','NewYear/event/stay-connected--treasure-island','NewYear/event/step-up-2013--raga-lawn-on-31st-dec','NewYear/event/survival-2013-with-dj-aqeel','NewYear/event/tab-1-coming-soon','NewYear/event/tandav-2013','NewYear/event/the-31st-night-hangover-party--hitex','NewYear/event/the-big-white-night-out--nye-2013--1-lounge-kp','NewYear/event/the-hulla-night-2013','NewYear/event/the-one-pulse-2013','NewYear/event/the-place-angels-of-the-nite','NewYear/event/the-redemption-2013-vol-ii','NewYear/event/the-royale-midnight-celebration--nye-2013--hardrock-cafe','NewYear/event/the-top-spin','NewYear/event/vanquish-2013--rain','NewYear/event/velocity-2013-new-year-party','NewYear/event/verve-2013--hotel-ashok','NewYear/event/visa-on-arrival-at-canvas-lounge','NewYear/event/wet-and-wild-new-year-2013','NewYear/event/white-winter-wonderland-palace-party--kino-108','NewYear/event/wonderland-2012--2013','NewYear/event/-xtasy-2013-new-year-eve','NewYear/event/xtasy-new-year-party--hicc-novotel','NewYear/event/zest-2013--abhiman-lawn','NewYear/event/zest-arena','NewYear/event/zumba-rocks-new-year-party','newyear/fdfdfdfdfdfdf','newyear/hghggh','newyear/holi2015','newyear/jodhpur','newyear/kothur','newyear/lavasa','newyear/lonvala','newyear/lucknow','newyear/mahabaleshwar','newyear/marine','newyear/new-year-camping-party','newyear/Other/vizag','newyear/Panvel','newyear/patna','newyear/PCMC','newyear/pimpari','newyear/Rajahmundry','newyear/ranchi','newyear/sachin','newyear/Sharjah','newyear/shimoga','newyear/templates/index_tpl.php','newyear/thane','newyear/udaipur','newyear/vashi','blog/2011/12/06/bisket-new-year-bash-2012','blog/2011/12/06/bisket-new-year-bash-2013','blog/2012/12/12/bisket-new-year-bash-n-grill-book-now','NewYear/event/bisket-new-year-bash-2013','blog/2012/12/18/31-12-new-year-party-with-dj-piyush-n-convention','blog/tag/31-12-new-year-bash-with-dj-piyush','blog/2012/12/18/2013-new-year-bash-leonia-resorts','NewYear/event/new_year_party_at_leonia_2013');
        if(in_array(urldecode($seoArray['url']), $miscUrls)){
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".base_url()."newyear");
            exit();
        }
        
          $seoKeys = $this->seoHandler->getSeoData($seoArray);
		  //print_r($seoArray);print_r($seoKeys);exit;
          
          if(isset($seoKeys['response']['seoData']) && count($seoKeys['response']['seoData']) > 0){
              
            $seoData = array();
            $mappingtype = $controller = $method = '';
            $seoData = $seoKeys['response']['seoData'][0];
			
			
			
            //get type include/redirect
            $mappingtype = $seoData['mappingtype'];
            //get type of controller - home/microsite
            $controller = $seoData['pagetype'];
            if ($controller != '') {
                $loadControl = 'controllers/' . $controller . '.php';
                require_once(APPPATH . $loadControl);
            }
            //get mapping method
            $method = $seoData['mappingurl'];
            //unserialize the params
			$paramsStr = str_replace("\\", "", stripslashes($seoData['params']));
			$paramsList = unserialize($paramsStr);
            //$paramsList = unserialize($seoData['params']);
			if(isset($seoData['countryid']) && $seoData['countryid'] > 0){
				setcookie('countryId',$seoData['countryid'],time()+COOKIE_EXPIRATION_TIME);
				$paramsList['countryId'] = $seoData['countryid'];
			}
			//print_r($paramsList);exit;
            
            if($mappingtype == 'redirect' && $method == ''){
                redirect($url);
            }

            if ($mappingtype == 'include') {
                //for microsites
                if ($controller == 'microsite') {
                    //create an object
                    $Obj = new microsite();

                    $paramsInput['name'] = $paramsList['name'];
                    if (isset($paramsList['param'])) {
                        $paramsInput['param'] = strtolower($param2);
                    }
					//print_r($paramsInput); exit;
					
					if(isset($paramArray[1])){
						$msresponse = $Obj->$method($paramsInput['name'], $paramArray[1]);
					}else {
                        $msresponse = $Obj->$method($paramsInput['name']);
                    }
					
                   
					
					//when given microsite not found, redirecting home page
					//var_dump($msresponse); exit;
					if(!$msresponse){
						redirect($url);
					}
                }
                //for cities or categories or both
                else if ($controller == 'home') {

                    $Obj = new home();
                    $homeresponse = $Obj->$method($paramsList);

                } else {
                    //if ($controller == 'other')
                }
            } else if ($mappingtype == 'redirect') {
                //redirect to the specific url
                header("HTTP/1.1 301 Moved Permanently"); 
                header("Location: ".$url . $method); 
                exit();
            } else {
                redirect($url);
            }
        }
        else
        {
            $seoKeys = $this->seoHandler->getSeoDataAliases($seoArray);
            if(isset($seoKeys['response']['seoData']) && count($seoKeys['response']['seoData']) > 0){
                $seoData = array();
                $mappingtype = $controller = $method = '';
                $seoData = $seoKeys['response']['seoData'][0];

                //get type include/redirect
                $mappingtype = $seoData['mappingtype'];
                //get type of controller - home/microsite
                $controller = $seoData['pagetype'];
                if ($controller != '') {
                    $loadControl = 'controllers/' . $controller . '.php';
                    require_once(APPPATH . $loadControl);
                }
                //get mapping method
                $method = $seoData['mappingurl'];
                //unserialize the params
                            $paramsStr = str_replace("\\", "", stripslashes($seoData['params']));
                            $paramsList = unserialize($paramsStr);
                //$paramsList = unserialize($seoData['params']);
                            if(isset($seoData['countryid']) && $seoData['countryid'] > 0){
                                    setcookie('countryId',$seoData['countryid'],time()+COOKIE_EXPIRATION_TIME);
                                    $paramsList['countryId'] = $seoData['countryid'];
                            }
                            //print_r($paramsList);exit;

                if($mappingtype == 'redirect' && $method == ''){
                    redirect($url);
                }

                if ($mappingtype == 'redirect') {
                    //redirect to the specific url
                    header("HTTP/1.1 301 Moved Permanently"); 
                    header("Location: ".$url . $method); 
                    exit();
                } 
            }
            redirect($url);
        }
    }    
}

?>