<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH . 'handlers/common_handler.php');

class Content extends CI_Controller
{

    var $commonHandler;
    var $userHandler;
    var $data;

    public function __construct()
    {
        parent::__construct();

        $this->commonHandler = new Common_handler();
    }

    public function index($inputArray)
    {
        $input = $this->input->get();
        $headerValues = $this->commonHandler->headerValues($input);
        $data['countryList'] = array();
        $data = $headerValues;
        $data['categoryList'] = array();
        $footerValues = $this->commonHandler->footerValues();
        $data['categoryList'] = $footerValues['categoryList'];
        $data['cityList'] = $footerValues['cityList'];
        $data['defaultCountryName'] = $headerValues['defaultCountryName'];
        switch ($inputArray) {
            case "Career":
                $data['content'] = 'includes/static/careers_view';
                $data['pageName'] = "Career";
                $data['pageTitle'] = "Career";
                break;
            case "Mediakit":
                $data['content'] = 'includes/static/mediakit_view';
                $data['pageName'] = "Mediakit";
                $data['pageTitle'] = "Mediakit";
                break;
            case "FAQ":
                $data['content'] = 'includes/static/faq_view';
                $data['pageName'] = "FAQ";
                $data['pageTitle'] = "FAQ";
                break;
            case "Pricing":
                $data['content'] = 'includes/static/faq_view';
                $data['pricing'] = 1;
                $data['pageName'] = "Pricing";
                $data['pageTitle'] = "Pricing";
                break;
            case "globalaffiliate-faq":
                $data['content'] = 'includes/static/affiliate_program_faq';
                $data['globalaffiliate'] = 1;
                $data['hideGlobalAffiliateHeader'] = 1;
                $data['pageName'] = "globalaffiliate";
                $data['pageTitle'] = "Global Affiliate FAQ";
                break;
            case "globalaffiliate-why":
                $data['content'] = 'includes/static/affiliate_program_why';
                $data['globalaffiliate'] = 1;
                $data['hideGlobalAffiliateHeader'] = 1;
                $data['pageName'] = "globalaffiliate";
                $data['pageTitle'] = "Why Global Affiliate";
                break;
            case "globalaffiliate-join":
                $data['content'] = 'includes/static/affiliate_program_create';
                $data['globalaffiliate'] = 1;
                $data['pageName'] = "globalaffiliate";
                $data['pageTitle'] = "Joing Global Affiliate";
                $data['hideGlobalAffiliateHeader'] = 1;
                $data['jsArray'] = array($this->config->item('js_public_path') . 'global-affiliate');
                require_once(APPPATH . 'handlers/promoter_handler.php');
                $promoterHandler = new Promoter_handler();
                $data['isGlobalPromoter'] = false;
                if (getUserId()) {
                    $inputCode['userid'] = getUserId();
                    $codeResponse = $promoterHandler->getGlobalCode($inputCode);
                }
                if (isset($codeResponse) && $codeResponse['status'] && $codeResponse['response']['total'] > 0) {
                    $data['code'] = $codeResponse['response']['promoterList'][0]['code'];
                    $data['isGlobalPromoter'] = true;
                } else {
                    $data['code'] = $promoterHandler->generateCodeForGlobalAff();
                }
                break;
            case "globalaffiliate-view":
                $data['content'] = 'includes/static/affiliate_program_view';
                $data['globalaffiliate'] = 1;
                $data['hideGlobalAffiliateHeader'] = 1;
                $data['pageName'] = "globalaffiliate";
                $data['pageTitle'] = "Global Affiliate";
                break;
            case "News":
                $data['content'] = 'includes/static/news_and_press_view';
                $data['pageName'] = "News";
                $data['pageTitle'] = "News";
                break;
            case "Client_feedback":
                $data['content'] = 'includes/static/client_feedback_view';
                $data['pageName'] = "Client Feedback";
                $data['pageTitle'] = "Client Feedback";
                break;
            case "Aboutus":
                $data['content'] = 'includes/static/aboutus_view';
                $data['pageName'] = "About Us";
                $data['pageTitle'] = "About Us";
                break;
            case "Aboutus_mobile":
                $data['content'] = 'includes/static/aboutus_mobile_view';
                $data['pageName'] = "About Us";
                $data['pageTitle'] = "About Us";
                break;
            case "Team":
                $data['content'] = 'includes/static/team_view';
                $data['pageName'] = "Team";
                $data['pageTitle'] = "Team";
                break;
            case "apidevelopers":
                $data['content'] = 'includes/static/developers_view';
                $inputArray = "Developers";
                break;
            case "Eventregistration":
                $data['content'] = 'includes/static/eventregistration_view';
                $data['pageName'] = "Free Event Registration";
                $data['pageTitle'] = "Free Event Registration";
                break;
            case "Selltickets":
                $data['content'] = 'includes/static/selltickets_view';
                $data['pageName'] = "Sell Tickets Online";
                $data['pageTitle'] = "Sell Tickets Online";
                break;
            case "Terms":
                $data['content'] = 'includes/static/terms_view';
                $data['pageName'] = "Terms and Conditions";
                $data['pageTitle'] = "Terms and Conditions";
                break;
            case "privacypolicy":
                $data['content'] = 'includes/static/privacypolicy_view';
                $data['pageName'] = "Privacy Policy";
                $data['pageTitle'] = "Privacy Policy";
                break;
            case "support":
                $data['content'] = 'includes/static/support_view';
                $data['pageName'] = "Support";
                $data['pageTitle'] = "Support";
                break;
            case "contact":
                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    ini_set('max_execution_time', 0);
                    ini_set('memory_limit', -1);
                    $cname = $this->input->post('cname');
                    $cemail = $this->input->post('cemail');
                    $cphone = $this->input->post('cphone');
                    $cmsg = $this->input->post('cmsg');
                    $captcha = $this->input->post('g-recaptcha-response');
                    if (!empty($cname) && !empty($cemail) && !empty($cphone) && !empty($cmsg) && !empty($captcha)) {
                        require_once(APPPATH . 'libraries/ReCaptcha/ReCaptcha.php');
                        $secret = $this->config->item('recaptchaSecretKey');
                        $ip = commonHelperGetClientIp();
                        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
                        // Make the call to verify the response and also pass the user's IP address
                        $resp = $recaptcha->setExpectedHostname($_SERVER['HTTP_HOST'])->verify($captcha, $ip);
                        if (!$resp->isSuccess()) {
                            $data['message'] = 'ReCaptcha Verification Failed';
                        } else {
                            $emailHandler = new Email_handler();
                            $ContactInputs['cname'] = $cname;
                            $ContactInputs['cemail'] = $cemail;
                            $ContactInputs['cphone'] = $cphone;
                            $ContactInputs['cmsg'] = $cmsg;
                            $email_send = $emailHandler->contactEmail($ContactInputs);
                            if (isset($email_send['status']) && $email_send['status']) {
                                $data['message'] = 'Your request submitted successfully';
                            } else {
                                $data['message'] = 'Some error occurs while submitting the form please try again';
                            }
                        }
                    } else {
                        $data['message'] = 'Some error occurs while submitting the form please try again';
                    }
                }
                $data['siteKey'] = $this->config->item('recaptchaSiteKey');
                $data['content'] = 'includes/static/contact_view';
                $data['pageName'] = "Contact";
                $data['pageTitle'] = "Contact";
                break;
            case "consult":
                $data['content'] = 'includes/static/consult_view';
                $data['pageName'] = "Consult";
                $data['pageTitle'] = "Consult";
                break;
            case "bugbounty":
                $data['content'] = 'includes/static/bugbounty_view';
                $data['pageName'] = "Bug Bounty";
                $data['pageTitle'] = "Bug Bounty";
                break;
            case "thecollegefever":
                $data['content'] = 'includes/static/college_fever_view';
                $data['pageName'] = "TheCollegeFever";
                $data['pageTitle'] = "TheCollegeFever";
                break;
            case "sitemap":
                if (isset($data['defaultCountryId']) && $data['defaultCountryId'] > 0) {
                    if (array_key_exists($data['defaultCountryId'], $data['countryList'])) {
                        $data['countryDetails'] = $data['countryList'][$data['defaultCountryId']];
                    }
                }
                $data['citiesAvaialble'] = false;
                if (count($data['cityList']) > 0) {
                    $data['citiesAvaialble'] = true;
                }
                $data['dynamicMicrosites'] = array('holi', 'newyear', 'dandiya');
                $data['content'] = 'includes/static/sitemap_view';
                $data['pageName'] = "Site Map";
                $data['pageTitle'] = "Site Map";
                break;
            case "organizerfeatures_manage":
                $data['content'] = 'includes/static/organizerfeatures_manage';
                $data['pageName'] = "Manage Features";
                $data['pageTitle'] = "Manage Features";
                break;
            case "organizerfeatures_promote":
                $data['content'] = 'includes/static/organizerfeatures_promote';
                $data['pageName'] = "Promote Features";
                $data['pageTitle'] = "Promote Features";
                break;
            case "organizerfeatures_communicate":
                $data['content'] = 'includes/static/organizerfeatures_communicate';
                $data['pageName'] = "Communicate Features";
                $data['pageTitle'] = "Communicate Features";
                break;
            case "organizerfeatures_reports":
                $data['content'] = 'includes/static/organizerfeatures_reports';
                $data['pageName'] = "Reports";
                $data['pageTitle'] = "Reports";
                break;
            case "organizerfeatures_payment":
                $data['content'] = 'includes/static/organizerfeatures_payment';
                $data['pageName'] = "Payment";
                $data['pageTitle'] = "Payment";
                break;
            case "organizerfeatures_checkinapp":
                $data['content'] = 'includes/static/organizerfeatures_checkinapp';
                $data['pageName'] = "Event Check In & Badge Printing App";
                $data['pageTitle'] = "Event Check In & Badge Printing App";
                break;
            case "organizerfeatures_whitelabelapp":
                $data['content'] = 'includes/static/organizerfeatures_whitelabelapp';
                $data['pageName'] = "MoozUp White Label Networking App";
                $data['pageTitle'] = "MoozUp White Label Networking App";
                break;
            case "contact":
                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    ini_set('max_execution_time', 0);
                    ini_set('memory_limit', -1);
                    $cname = $this->input->post('cname');
                    $cemail = $this->input->post('cemail');
                    $cphone = $this->input->post('cphone');
                    $cmsg = $this->input->post('cmsg');
                    $captcha = $this->input->post('g-recaptcha-response');
                    if (!empty($cname) && !empty($cemail) && !empty($cphone) && !empty($cmsg) && !empty($captcha)) {
                        require_once(APPPATH . 'libraries/ReCaptcha/ReCaptcha.php');
                        $secret = $this->config->item('recaptchaSecretKey');
                        $ip = commonHelperGetClientIp();
                        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
                        // Make the call to verify the response and also pass the user's IP address
                        $resp = $recaptcha->setExpectedHostname($_SERVER['HTTP_HOST'])->verify($captcha, $ip);
                        if (!$resp->isSuccess()) {
                            $data['message'] = 'ReCaptcha Verification Failed';
                        } else {
                            $emailHandler = new Email_handler();
                            $ContactInputs['cname'] = $cname;
                            $ContactInputs['cemail'] = $cemail;
                            $ContactInputs['cphone'] = $cphone;
                            $ContactInputs['cmsg'] = $cmsg;
                            $email_send = $emailHandler->contactEmail($ContactInputs);
                            if (isset($email_send['status']) && $email_send['status']) {
                                $data['message'] = 'Your request submitted successfully';
                            } else {
                                $data['message'] = 'Some error occurs while submitting the form please try again';
                            }
                        }
                    } else {
                        $data['message'] = 'Some error occurs while submitting the form please try again';
                    }
                }
                $data['siteKey'] = $this->config->item('recaptchaSiteKey');
                $data['content'] = 'includes/static/contact_view';
                $data['pageName'] = "Contact";
                $data['pageTitle'] = "Contact";
                break;
            case "contact_mobile":
                if ($this->input->server('REQUEST_METHOD') == 'POST') {
                    ini_set('max_execution_time', 0);
                    ini_set('memory_limit', -1);
                    $cname = $this->input->post('cname');
                    $cemail = $this->input->post('cemail');
                    $cphone = $this->input->post('cphone');
                    $cmsg = $this->input->post('cmsg');
                    if (!empty($cname) && !empty($cemail) && !empty($cphone) && !empty($cmsg)) {
                        $emailHandler = new Email_handler();
                        $ContactInputs['cname'] = $cname;
                        $ContactInputs['cemail'] = $cemail;
                        $ContactInputs['cphone'] = $cphone;
                        $ContactInputs['cmsg'] = $cmsg;
                        $email_send = $emailHandler->contactEmail($ContactInputs);
                        if (isset($email_send['status']) && $email_send['status']) {
                            $data['message'] = 'Your request submitted successfully';
                        }
                    } else {
                        $data['message'] = 'Some error occurs while submitting the form please try again';
                    }
                }
                $data['siteKey'] = $this->config->item('recaptchaSiteKey');
                $data['content'] = 'includes/static/contact_mobile_view';
                $data['pageName'] = "Contact";
                $data['pageTitle'] = "Contact";
                break;
            default:
                $data['content'] = '';
                break;
        }
        $data['pageTitle'] = $data['pageTitle'] . ' | MeraEvents';
        $data['seoStaus'] = 1;
        $data['seoDescription'] = $data['pageTitle'] . ' | ' . $data['defaultCountryName'];
        $data['pageKeywords'] = 'Events in ' . $data['defaultCountryName'] . ', Event, Upcoming Events, Events, Event Ticket Booking Website, Event Ticket Booking Online, Event today, Events today, Today events, Event ticket booking online, Event Ticket Booking, Event ticket booking sites, Concerts, Event Happening, Online Ticket for Events, Events Booking Online, live shows ticket booking, Upcoming Events ' . $data['defaultCountryName'] . ', Online Events Booking, Buy concert tickets, Tickets for concerts, Tickets for events' . ', ' . $data['pageTitle'];
        $data['cssArray'] = array($this->config->item('css_public_path') . 'print_tickets');
        $jsData = array(
            $this->config->item('js_public_path') . 'jquery.validate',
            $this->config->item('js_public_path') . 'static',
            $this->config->item('js_public_path') . 'common');
        if (isset($data['jsArray']) && count($data['jsArray']) > 0) {
            $data['jsArray'] = array_merge($data['jsArray'], $jsData);
        } else {
            $data['jsArray'] = $jsData;
        }

        if ($data['content'] == 'includes/static/aboutus_mobile_view' || $data['content'] == 'includes/static/contact_mobile_view') {
            $this->load->view('templates/user_mobile_template', $data);
        } else {
            $this->load->view('templates/user_template', $data);
        }
    }

    public function why_meraevents($inputArray)
    {
        switch ($inputArray) {
            case "why":
                $data['content'] = 'why_meraevents/why_view';
                $data['pageTitle'] = "Events & Conferences in India,Today,This Weekend and Upcoming - MeraEvents";
                $data['pageDescription'] = "Events in Hyderabad, activities in Hyderabad, things to do in Hyderabad, events in bangalore today, events in bangalore this weekend, upcoming events in Hyderabad, events in Hyderabad 2020.";
                break;
            case "registration":
                $data['content'] = 'why_meraevents/registration_view';
                $data['pageTitle'] = "Online Registration Forms ! Event registration - MeraEvents";
                $data['pageDescription'] = "Online registration forms allow you to easily plan your next event, such as conferences, workshops or classes. Start by modifying a sample record.";
                break;
            case "marketing":
                $data['content'] = 'why_meraevents/marketing_view';
                $data['pageTitle'] = "Why Is Event Marketing Important | Multi-Channel Marketing - MeraEvents";
                $data['pageDescription'] = "MeraEvents is discovery platform that brings all events, Activities and things to do in chennai,Hyderabad,Benguluru. Discover events for parties, concerts, food, adventure, sports, art, technology, nightlife, workshops, photography and more.";
                break;
                break;
            case "check_in":
                $data['content'] = 'why_meraevents/check_in_view';
                $data['pageTitle'] = "Event Check in, Events in Hyderabad, Mumbai - MeraEvents";
                $data['pageDescription'] = "Things To Do in Mumbai, Hyderabad, Chennai - Meet Your City! Curated and carefully chosen by our editors, the best of the best that this city has to.";
                break;
            case "appify":
                $data['content'] = 'why_meraevents/appify_view';
                $data['pageTitle'] = "Appify Harness the power of apps - MeraEvents";
                $data['pageDescription'] = "Discover app -based strategies to simplify your daily operations. Are you an entrepreneur short on time and resources? Is the struggle to streamline your workflow reaching your bottom line?";
                break;
            case "assistant":
                $data['content'] = 'why_meraevents/assistant_view';
                $data['pageTitle'] = "Your Trusted Event Assistant with an Event Planner - MeraEvents";
                $data['pageDescription'] = "Event Assistant includes things like creating room plans, selecting a menu, booking a venue, finding entertainment, and everything to do with coordinating an event. An event assistant should be able to multitask because he wears many hats throughout the life cycle of an event.";
                break;
            default:
                $data['content'] = '';
                break;
        }
        $this->load->view('templates/why_meraevents_template', $data);
    }

}

?>