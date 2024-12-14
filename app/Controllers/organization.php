<?php

//error_reporting(-1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Organization controller (Grouping of events Page)
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2015, Meraevents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     07-12-2015
 * @Last Modified On  07-12-2015
 * @Last Modified By  Raviteja
 */
require_once(APPPATH . 'handlers/organization_handler.php');
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/booking_handler.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/paymentgateway_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH . 'handlers/association_handler.php');

class Organization extends CI_Controller
{

    var $organizationHandler;
    var $commonHandler;

    public function __construct()
    {
        parent::__construct();
        $this->organizationHandler = new organization_handler();
        $this->commonHandler = new Common_handler();
        $this->userHandler = new User_handler();
        $this->associationHandler = new Association_handler();
        $this->defaultCountryId = $this->defaultCityId = $this->defaultCategoryId = 0;
        $this->defaultCustomFilterId = 1;
    }

    public function index()
    {
        $segment = $this->uri->segment(3);
        if (isset($segment) && $segment != '') {
            $getVar['orgid'] = $this->uri->segment(3);
        } else {
            $getVar['slug'] = $this->uri->segment(2);
            $result = $this->db->select('id')->from('organization')->where('slug', $getVar['slug'])->limit(1)->get()->row();
            $getVar['orgid'] = $result->id;
        }


        $getParams = $this->input->get();
        if (isset($getParams['ucode']) && $getParams['ucode'] == 'organizer') {
            $getVar['effort'] = 'organizer';
        }
        $data['countryList'] = '';
        $data['categoryList'] = '';
        $cookieData = $this->commonHandler->headerValues();
        $footerValues = $this->commonHandler->footerValues();
        $data['eventsData'] = array();
        $data['organizationDetails'] = array();


        if (count($cookieData) > 0) {
            $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
            $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }
        $totalOrgevents = 0;
        $getVar['type'] = 'upcoming';
        $organizationDetails = $this->organizationHandler->getOrganizationDetails($getVar);

        $totalOrgevents = $totalOrgevents + $organizationDetails['response']['totalcount'];

        if ($organizationDetails['status'] && $organizationDetails['response']['totalcount'] == 0 && !empty($organizationDetails['response']['organizationData']['0']) && $organizationDetails['response']['organizationData']['0']['isassociation'] == 0) {
            $getVar['type'] = 'past';
            $organizationDetails = $this->organizationHandler->getOrganizationDetails($getVar);
            $totalOrgevents = +$organizationDetails['response']['totalcount'];
        } else {
            $getVar1 = $getVar;
            $getVar1['type'] = 'past';
            $organizationPastDetails = $this->organizationHandler->getOrganizationDetails($getVar1);
            $totalOrgevents = $totalOrgevents + $organizationPastDetails['response']['totalcount'];
        }
        $data['orgTotalEvents'] = $totalOrgevents;
        if (!$organizationDetails['status'] || empty($organizationDetails['response']['organizationData'])) {
            $data['content'] = 'error_view';
            $data['message'] = ERROR_NO_RECORDS;
        } else {
            $data['content'] = 'organization_view';
            if (isset($getVar['effort'])) {
                foreach ($organizationDetails['response']['OrganizationEventsData'] as $key => $value) {
                    $organizationDetails['response']['OrganizationEventsData'][$key]['url'] = $value['url'] . '?ucode=organizer';
                }
            }
        }
        $organizationList = $organizationDetails['response']['organizationData'];

        //IF cookie is not set then create a new cookie with the event id as the key and 1 view as current view count and 1 day expiry time
        if (!isset($_COOKIE[$getVar['orgid']])) {
            setcookie($getVar['orgid'], '1', time() + (86400 * 7), "/");
            //$this->eventHandler->updateEventViewCount($eventId);\
            //Set view count 1
            $data['viewCountUp'] = 1;
            $updatedViews = $this->organizationHandler->updateViewCount($organizationList[0]);
            if ($updatedViews['status']) {
                $organizationList[0]['viewcount'] = $organizationList[0]['viewcount'] + 1;
            }
        } else {
            $organizationList[0]['viewcount'] = $organizationList[0]['viewcount'];
        }

        if ($organizationList[0]['isassociation'] == 1) {
            if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
                $data['logopath'] = $organizationList[0]['logoPath'];
            } else {
                $data['logopath'] = '';
            }
            if (isset($organizationList[0]['faviconPath']) && strlen($organizationList[0]['faviconPath']) > 0) {
                $data['faviconPath'] = $organizationList[0]['faviconPath'];
            } else {
                $data['faviconPath'] = '';
            }
            //Get Chapters
            $chapterVar['parentassociationid'] = $organizationList[0]['id'];
            $organizationChapters = $this->organizationHandler->getAssociationChapters($chapterVar);
            $data['pageTitle'] = $organizationList[0]['name'];
            $data['eventsData'] = $organizationDetails['response']['OrganizationEventsData'];
            $data['organizationChapters'] = $organizationChapters;
            $data['association_url'] = site_url() . 'o/' . $organizationList[0]['slug'];
            $data['content'] = 'association/home_view';
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'jquery.validate',
                $this->config->item('js_public_path') . 'association.bootstrap.min',
                $this->config->item('js_public_path') . 'association.npm'
            );
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'association.bootstrap.min',
                $this->config->item('css_public_path') . 'association',
            );
            $this->load->view('templates/association_template', $data);
        } else {
            $data['organizationDetails'] = $organizationList[0];
            $data['eventsData'] = $organizationDetails['response']['OrganizationEventsData'];
            $data['totalCount'] = $organizationDetails['response']['totalcount'];
            $data['pageType'] = $getVar['type'];
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'jquery.validate',
                $this->config->item('js_public_path') . 'organization',
                $this->config->item('js_public_path') . 'inviteFriends',
            );

            if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
                $data['logopath'] = $organizationList[0]['logoPath'];
            } else {
                $data['logopath'] = $organizationList[0]['logoPath'];
            }
            $data['pageTitle'] = 'MeraEvents | Organizer Profile';
            $data['categoryList'] = $footerValues['categoryList'];
            $data['cityList'] = $footerValues['cityList'];
            $data['defaultCountryId'] = $this->defaultCountryId;
            $template = 'templates/innerpage_template';
            if (empty($organizationDetails['response']['organizationData'])) {
                $template = 'templates/user_template';
                $data['content'] = '404_view';
                $data['pageTitle'] = '404 Page Not Found: MeraEvents.com';
            } else {
                $data['cssArray'] = array(
                    $this->config->item('css_public_path') . 'themify-icons',
                    $this->config->item('css_public_path') . 'bootstrap-4.3.1',
                    $this->config->item('css_public_path') . 'rangeslider',
                    $this->config->item('css_public_path') . 'lightgallery',
                    $this->config->item('css_public_path') . 'style_innnerpage',
                );
            }
            $this->load->view($template, $data);
        }
    }

    public function events()
    {
        $getVar['slug'] = $this->uri->segment(2);
        $result = $this->db->select('id')->from('organization')->where('slug', $getVar['slug'])->limit(1)->get()->row();
        $getVar['orgid'] = $result->id;

        $organizationDetails = $this->organizationHandler->getAssociationOrganizationDetails($getVar);
        if (!$organizationDetails['status'] || empty($organizationDetails['response']['organizationData'])) {
            $data['content'] = 'error_view';
            $data['message'] = ERROR_NO_RECORDS;
        } else {
            $organizationList = $organizationDetails['response']['organizationData'];
            $getOrganizationLogo = $this->organizationHandler->getLogo($organizationDetails['response']['organizationData'][0]['parentassociationid']);
            if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
                $data['logopath'] = $organizationList[0]['logoPath'];
            } else {
                $data['logopath'] = '';
            }
            if (isset($organizationList[0]['faviconPath']) && strlen($organizationList[0]['faviconPath']) > 0) {
                $data['faviconPath'] = $organizationList[0]['faviconPath'];
            } else {
                $data['faviconPath'] = '';
            }
            if (isset($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) && strlen($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) > 0) {
                $data['associationlogopath'] = $getOrganizationLogo['response']['organizationData'][0]['associationlogoPath'];
            } else {
                $data['associationlogopath'] = '';
            }
            $eventInput['id'] = $organizationList[0]['id'];
            $eventInput['type'] = 'upcoming';
            $data['pageTitle'] = $organizationList[0]['name'] . ' - Events';
            $data['organizationDetails'] = $organizationList[0];
            $data['organizationEvents'] = $this->organizationHandler->organizationUserEvents($eventInput);
            $data['association_url'] = site_url() . 'o/' . $organizationList[0]['slug'];
            if ($organizationList[0]['parentassociationid'] > 0) {
                $data['is_chapter'] = true;
                $data['association_url'] = site_url() . 'c/' . $organizationList[0]['slug'];
            }
            $data['content'] = 'association/events_view';
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'jquery.validate',
                $this->config->item('js_public_path') . 'association.bootstrap.min',
                $this->config->item('js_public_path') . 'association.npm'
            );
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'association.bootstrap.min',
                $this->config->item('css_public_path') . 'association',
            );
            $this->load->view('templates/association_template', $data);
        }
    }

    public function chapters()
    {
        $getVar['slug'] = $this->uri->segment(2);
        $result = $this->db->select('id')->from('organization')->where('slug', $getVar['slug'])->limit(1)->get()->row();
        $getVar['orgid'] = $result->id;

        $organizationDetails = $this->organizationHandler->getAssociationOrganizationDetails($getVar);
        if (!$organizationDetails['status'] || empty($organizationDetails['response']['organizationData'])) {
            $data['content'] = 'error_view';
            $data['message'] = ERROR_NO_RECORDS;
        } else {
            $organizationList = $organizationDetails['response']['organizationData'];
            if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
                $data['logopath'] = $organizationList[0]['logoPath'];
            } else {
                $data['logopath'] = '';
            }
            if (isset($organizationList[0]['faviconPath']) && strlen($organizationList[0]['faviconPath']) > 0) {
                $data['faviconPath'] = $organizationList[0]['faviconPath'];
            } else {
                $data['faviconPath'] = '';
            }
            //Get Chapters
            $chapterVar['parentassociationid'] = $organizationList[0]['id'];
            $organizationChapters = $this->organizationHandler->getAssociationChapters($chapterVar);
            $data['pageTitle'] = $organizationList[0]['name'] . ' - Chapters';
            $data['organizationDetails'] = $organizationList[0];
            $data['organizationChapters'] = $organizationChapters;
            $data['association_url'] = site_url() . 'o/' . $organizationList[0]['slug'];
            $data['content'] = 'association/chapters_view';
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'jquery.validate',
                $this->config->item('js_public_path') . 'association.bootstrap.min',
                $this->config->item('js_public_path') . 'association.npm'
            );
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'association.bootstrap.min',
                $this->config->item('css_public_path') . 'association',
            );
            $this->load->view('templates/association_template', $data);
        }
    }

    public function members()
    {
        $getVar['slug'] = $this->uri->segment(2);
        $result = $this->db->select('id')->from('organization')->where('slug', $getVar['slug'])->limit(1)->get()->row();
        $getVar['orgid'] = $result->id;

        $organizationDetails = $this->organizationHandler->getAssociationOrganizationDetails($getVar);

        if (!$organizationDetails['status'] || empty($organizationDetails['response']['organizationData'])) {
            $data['content'] = 'error_view';
            $data['message'] = ERROR_NO_RECORDS;
        } else {
            $organizationList = $organizationDetails['response']['organizationData'];
            $getOrganizationLogo = $this->organizationHandler->getLogo($organizationDetails['response']['organizationData'][0]['parentassociationid']);
            if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
                $data['logopath'] = $organizationList[0]['logoPath'];
            } else {
                $data['logopath'] = '';
            }
            if (isset($organizationList[0]['faviconPath']) && strlen($organizationList[0]['faviconPath']) > 0) {
                $data['faviconPath'] = $organizationList[0]['faviconPath'];
            } else {
                $data['faviconPath'] = '';
            }
            if (isset($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) && strlen($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) > 0) {
                $data['associationlogopath'] = $getOrganizationLogo['response']['organizationData'][0]['associationlogoPath'];
            } else {
                $data['associationlogopath'] = '';
            }

            if ($organizationDetails['response']['organizationData'][0]['parentassociationid'] == 0) {
                $organizationMembers = $this->organizationHandler->getAllChapters($getVar['orgid']);
            } else {
                $organizationMembers = $this->organizationHandler->getChapterMembers($getVar['orgid']);
            }
            $data['Organizationurl'] = site_url() . 'o/' . $getOrganizationLogo['response']['organizationData'][0]['slug'];
            $data['pageTitle'] = $organizationList[0]['name'] . ' - Members';
            $data['organizationDetails'] = $organizationList[0];
            $data['organizationMembers'] = $organizationMembers;
            $data['association_url'] = site_url() . 'o/' . $organizationList[0]['slug'];
            if ($organizationList[0]['parentassociationid'] > 0) {
                $data['is_chapter'] = true;
                $data['association_url'] = site_url() . 'c/' . $organizationList[0]['slug'];
            }
            $data['content'] = 'association/members_view';
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'jquery.validate',
                $this->config->item('js_public_path') . 'association.bootstrap.min',
                $this->config->item('js_public_path') . 'association.npm'
            );
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'association.bootstrap.min',
                $this->config->item('css_public_path') . 'association',
            );
            $this->load->view('templates/association_template', $data);
        }
    }

    public function login()
    {
        $getVar['slug'] = $this->uri->segment(2);
        $result = $this->db->select('id')->from('organization')->where('slug', $getVar['slug'])->limit(1)->get()->row();
        $getVar['orgid'] = $result->id;

        $organizationDetails = $this->organizationHandler->getAssociationOrganizationDetails($getVar);
        if (!$organizationDetails['status'] || empty($organizationDetails['response']['organizationData'])) {
            $data['content'] = 'error_view';
            $data['message'] = ERROR_NO_RECORDS;
        } else {
            $organizationList = $organizationDetails['response']['organizationData'];
            if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
                $data['logopath'] = $organizationList[0]['logoPath'];
            } else {
                $data['logopath'] = '';
            }
            if (isset($organizationList[0]['faviconPath']) && strlen($organizationList[0]['faviconPath']) > 0) {
                $data['faviconPath'] = $organizationList[0]['faviconPath'];
            } else {
                $data['faviconPath'] = '';
            }

            if ($this->input->post('submit')) {
                $inputArrays = $this->input->post();
                $checkUser = $this->organizationHandler->checkuserdata($inputArrays);
                if (!empty($checkUser['status'])) {
                    //redirect(commonHelperGetPageUrl('association_chapters') . "/" . $id);
                    if (count($checkUser['response']['userData']) > 0 && count($checkUser['membershipdata']) > 0) {
                        redirect(site_url() . 'o/' . $organizationList[0]['slug']);
                    }
                }
            }
            $data['userDetails'] = $checkUser['response']['messages'][0];
            $data['pageTitle'] = $organizationList[0]['name'] . ' - Login';
            $data['organizationDetails'] = $organizationList[0];
            $data['association_url'] = site_url() . 'o/' . $organizationList[0]['slug'];
            $data['content'] = 'association/login_view';
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'jquery.validate',
                $this->config->item('js_public_path') . 'association.bootstrap.min',
                $this->config->item('js_public_path') . 'association.npm'
            );
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'association.bootstrap.min',
                $this->config->item('css_public_path') . 'association',
            );
            $this->load->view('templates/association_template', $data);
        }
    }

    public function chapterHome()
    {
        $getVar['slug'] = $this->uri->segment(2);
        $result = $this->db->select('id')->from('organization')->where('slug', $getVar['slug'])->limit(1)->get()->row();
        $getVar['orgid'] = $result->id;

        $organizationDetails = $this->organizationHandler->getAssociationOrganizationDetails($getVar);
        if (!$organizationDetails['status'] || empty($organizationDetails['response']['organizationData'])) {
            $data['content'] = 'error_view';
            $data['message'] = ERROR_NO_RECORDS;
        } else {
            $organizationList = $organizationDetails['response']['organizationData'];
            $getOrganizationLogo = $this->organizationHandler->getLogo($organizationList[0]['parentassociationid']);
            if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
                $data['logopath'] = $organizationList[0]['logoPath'];
            } else {
                $data['logopath'] = '';
            }
            if (isset($organizationList[0]['faviconPath']) && strlen($organizationList[0]['faviconPath']) > 0) {
                $data['faviconPath'] = $organizationList[0]['faviconPath'];
            } else {
                $data['faviconPath'] = '';
            }
            if (isset($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) && strlen($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) > 0) {
                $data['associationlogopath'] = $getOrganizationLogo['response']['organizationData'][0]['associationlogoPath'];
            } else {
                $data['associationlogopath'] = '';
            }
            $data['Organizationurl'] = site_url() . 'o/' . $getOrganizationLogo['response']['organizationData'][0]['slug'];
            $merbershipTypeInput['id'] = $organizationList['0']['id'];
            $merbershipTypeInput['parentassociationid'] = $organizationList['0']['parentassociationid'];
            $eventInput['id'] = $organizationList[0]['id'];
            $eventInput['type'] = 'upcoming';
            $data['pageTitle'] = $organizationList[0]['name'];
            $data['organizationDetails'] = $organizationList[0];
            //Get Events
            $data['organizationEvents'] = $this->organizationHandler->organizationUserEvents($eventInput);
            //Get Chapter Members
            $data['organizationMembers'] = $this->organizationHandler->getChapterMembers($getVar['orgid']);
            //Get Membership Types
            $data['membershipTypes'] = $this->organizationHandler->getMembershipTypes($merbershipTypeInput);
            $data['association_url'] = site_url() . 'c/' . $organizationList[0]['slug'];
            $data['is_chapter'] = true;
            $data['content'] = 'association/chapters_home_view';
            $data['jsArray'] = array(
                $this->config->item('js_public_path') . 'jquery.validate',
                $this->config->item('js_public_path') . 'association.bootstrap.min',
                $this->config->item('js_public_path') . 'association.npm'
            );
            $data['cssArray'] = array(
                $this->config->item('css_public_path') . 'association.bootstrap.min',
                $this->config->item('css_public_path') . 'association',
            );
            $this->load->view('templates/association_template', $data);
        }
    }

    public function join()
    {
        $getVar['slug'] = $this->uri->segment(2);
        $result = $this->db->select('id')->from('organization')->where('slug', $getVar['slug'])->limit(1)->get()->row();
        $getVar['orgid'] = $result->id;

        $organizationDetails = $this->organizationHandler->getAssociationOrganizationDetails($getVar);
        if (!$organizationDetails['status'] || empty($organizationDetails['response']['organizationData'])) {
            $data['content'] = 'error_view';
            $data['message'] = ERROR_NO_RECORDS;
        } else {
            $getOrganizationLogo = $this->organizationHandler->getLogo($organizationDetails['response']['organizationData'][0]['parentassociationid']);
            $inputArray['parentassociationid'] = $organizationDetails['response']['organizationData'][0]['parentassociationid'];
            $getParentassociationeventid = $this->organizationHandler->getEventId($inputArray);
            $organizationList = $organizationDetails['response']['organizationData'];
            $merbershipTypeInput['id'] = $organizationList['0']['id'];
            $merbershipTypeInput['parentassociationid'] = $organizationList['0']['parentassociationid'];
            $membershipTypes = $this->organizationHandler->getMembershipTypes($merbershipTypeInput);
            $associationid = $merbershipTypeInput['parentassociationid'];
            $getTerms = $this->associationHandler->getTerms($associationid);
            if (!empty($membershipTypes['response']['membershipTypes'])) {
                if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
                    $data['logopath'] = $organizationList[0]['logoPath'];
                } else {
                    $data['logopath'] = '';
                }
                if (isset($organizationList[0]['faviconPath']) && strlen($organizationList[0]['faviconPath']) > 0) {
                    $data['faviconPath'] = $organizationList[0]['faviconPath'];
                } else {
                    $data['faviconPath'] = '';
                }
                if (isset($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) && strlen($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) > 0) {
                    $data['associationlogopath'] = $getOrganizationLogo['response']['organizationData'][0]['associationlogoPath'];
                } else {
                    $data['associationlogopath'] = '';
                }
                //Get Paymentways
                $eventGateways = array();
                $gateWayInput['eventId'] = $getParentassociationeventid[0]['eventid'];
                $gateWayInput['gatewayStatus'] = true;
                $eventHandler = new Event_handler();
                $gateWayData = $eventHandler->getEventPaymentGateways($gateWayInput);
                if ($gateWayData['status'] && count($gateWayData['response']['gatewayList']) > 0) {
                    $eventGateways = $gateWayData['response']['gatewayList'];
                }
                $data['Organizationurl'] = site_url() . 'o/' . $getOrganizationLogo['response']['organizationData'][0]['slug'];
                $data['chapterName'] = $organizationDetails['response']['organizationData'][0]['name'];
                $data['eventGateways'] = $eventGateways;
                $data['orgid'] = $organizationList[0]['id'];
                $data['termsandconditions'] = $getTerms[0]['termsandconditions'];
                $data['association_url'] = site_url() . 'c/' . $organizationList[0]['slug'];
                $data['membershipTypes'] = $membershipTypes;
                $data['content'] = 'association/join_group';
                $data['pageTitle'] = 'MeraEvents | Membership Subscription';
                $data['is_chapter'] = true;
                $data['jsArray'] = array(
                    $this->config->item('js_public_path') . 'jquery.validate',
                    $this->config->item('js_public_path') . 'association.bootstrap.min',
                    $this->config->item('js_public_path') . 'association.npm'
                );
                $data['cssArray'] = array(
                    $this->config->item('css_public_path') . 'association.bootstrap.min',
                    $this->config->item('css_public_path') . 'association',
                );
                $this->load->view('templates/association_template', $data);
            } else {
                redirect(site_url() . 'c/' . $organizationList[0]['slug']);
            }
        }
    }

    public function saveMembership()
    {
        $inputArray = $this->input->post();
        $joinMember = $this->organizationHandler->joinMembers($inputArray);
        if (empty($joinMember['status'])) {
            $response['message'] = $joinMember['response']['messages'];
            $response['status'] = '';
            echo json_encode($response, true);
            die;
        }
        $eventSignupId = $joinMember['response']['total'];
        if ($inputArray['totalamount'] > 0) {
            $paymentGatewaySelected = $inputArray['paymentGateway'];
            $paymentGatewayIdSelected = $inputArray['paymentGatewayId'];
            $inputPaymentGateway['gatewayIds'] = [$paymentGatewayIdSelected];
            $paymentGateway = new Paymentgateway_handler();
            $gateWayData = $paymentGateway->getPaymentgatewayList($inputPaymentGateway);
            if (strtolower($paymentGatewaySelected) == 'razorpay') {
                $pgatewayData = $gateWayData['response']['paymentgatewayList'][$paymentGatewayIdSelected];
                $rpaykeyid = $pgatewayData['merchantid'];
                $rpaykeysecret = $pgatewayData['hashkey'];

                $razorpayAccessKeys = array('rpaykeyid' => $rpaykeyid, 'rpaykeysecret' => $rpaykeysecret);
                $this->load->library('razorpay/razorpay.php', $razorpayAccessKeys);

                $razorpayInput['receipt'] = $eventSignupId;
                $razorpayInput['amount'] = ($inputArray['totalamount'] * 100);
                $razorpayInput['currency'] = 'INR';
                $razorpayInput['payment_capture'] = 1; // auto capture

                $razorpayOrderId = $this->razorpay->createOrderId($razorpayInput);
                $_SESSION['razorpay_order_id'] = $razorpayOrderId;

                unset($razorpayInput['receipt']);
                unset($razorpayInput['payment_capture']);
                unset($razorpayInput['currency']);

                $razorpayInput['key'] = $rpaykeyid;
                $razorpayInput['name'] = "MeraEvents.com";
                $razorpayInput['description'] = 'Membership';
                $razorpayInput['prefill'] = array("name" => $inputArray['name'], "email" => $inputArray['email'], "contact" => $inputArray['mobile']);
                $razorpayInput['notes'] = array("address" => (isset($inputArray['Address1']) ? $inputArray['Address1'] : ''), "merchant_order_id" => $eventSignupId);
                $razorpayInput['theme'] = array("color" => "#5F259F");
                $razorpayInput['order_id'] = $razorpayOrderId;
                $razorpayInput['returnUrl'] = commonHelperGetPageUrl('organization_razorpayProcessingPage') . '?eventSignup=' . $eventSignupId . '&paymentGatewayKey=' . $pgatewayData['id'];
                $response['razorpayInput'] = json_encode($razorpayInput);
            }
        } else {
            $eventInfo['orderId'] = $eventSignupId;
            $this->organizationHandler->EventSignupUpdate($eventInfo);
            $usersdata = $this->organizationHandler->userData($eventSignupId);
            $this->organizationHandler->sendConfirmationEmail($usersdata);
        }
        $response['eventSignupId'] = $eventSignupId;
        $response['totalamount'] = $inputArray['totalamount'];
        $response['name'] = $inputArray['name'];
        $response['email'] = $inputArray['email'];
        $response['mobile'] = $inputArray['mobile'];
        $response['status'] = true;
        echo json_encode($response, true);
        die;
    }

    function confirmation()
    {
        $getData = $this->organizationHandler->userData($_GET['id']);

        $orgid['orgid'] = $getData['organizationid'];
        $organizationDetails = $this->organizationHandler->getAssociationOrganizationDetails($orgid);
        $organizationList = $organizationDetails['response']['organizationData'];
        if (isset($organizationList[0]['logoPath']) && strlen($organizationList[0]['logoPath']) > 0) {
            $data['logopath'] = $organizationList[0]['logoPath'];
        } else {
            $data['logopath'] = '';
        }
        if (isset($organizationList[0]['faviconPath']) && strlen($organizationList[0]['faviconPath']) > 0) {
            $data['faviconPath'] = $organizationList[0]['faviconPath'];
        } else {
            $data['faviconPath'] = '';
        }
        $getOrganizationLogo = $this->organizationHandler->getLogo($organizationDetails['response']['organizationData'][0]['parentassociationid']);
        if (isset($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) && strlen($getOrganizationLogo['response']['organizationData'][0]['associationlogoPath']) > 0) {
            $data['associationlogopath'] = $getOrganizationLogo['response']['organizationData'][0]['associationlogoPath'];
        } else {
            $data['associationlogopath'] = '';
        }

        $data['Organizationurl'] = site_url() . 'o/' . $getOrganizationLogo['response']['organizationData'][0]['slug'];
        $data['confirmationData'] = $getData;
        $data['organizationData'] = $organizationDetails;
        $data['association_url'] = site_url() . 'c/' . $organizationList[0]['slug'];
        $data['pageTitle'] = 'MeraEvents | Membership Confirmation';
        $data['content'] = 'association/confirmation_view';
        $data['is_chapter'] = true;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jquery.validate',
            $this->config->item('js_public_path') . 'association.bootstrap.min',
            $this->config->item('js_public_path') . 'association.npm'
        );
        $data['cssArray'] = array(
            $this->config->item('css_public_path') . 'association.bootstrap.min',
            $this->config->item('css_public_path') . 'association',
        );
        $this->load->view('templates/association_template', $data);
    }

}

?>