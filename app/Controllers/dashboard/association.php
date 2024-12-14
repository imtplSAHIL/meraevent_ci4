<?php

//error_reporting(-1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'handlers/association_handler.php');
require_once(APPPATH . 'handlers/organization_handler.php');
require_once(APPPATH . 'handlers/user_handler.php');
require_once(APPPATH.'handlers/profile_handler.php');

class Association extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->associationHandler = new Association_handler();
        $this->organizationHandler = new Organization_handler();
        $this->userHandler = new User_handler();
        $this->profileHandler = new Profile_handler();
    }

    public function index()
    {
        $userId = $this->customsession->getUserId();
        $inputArray['id'] = $userId;
        $associationList = $this->associationHandler->getAssociationsList($inputArray);

        $data['associationList'] = $associationList['response']['organizationData'];
        $data['content'] = '../association/association_view';
        $data['pageName'] = 'Association View';
        $data['pageTitle'] = 'MeraEvents | Association View';
        $data['hideLeftMenu'] = 1;

        $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui', $this->config->item('js_public_path') . 'intlTelInput');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function dashboard($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $inputArray['id'] = $id;
        $orgnizerData = $this->associationHandler->getAssociationDetailsOnly($inputArray);
        //Get Association Chapters
        $orgInput['parentassociationid'] = $id;
        $chapterList = $this->associationHandler->getAssociationChapterList($orgInput);
        $memberCount = 0;
        if (!empty($chapterList)) {
            $chapter_ids = array();
            foreach ($chapterList as $chapter) {
                $chapter_ids[] = $chapter['id'];
            }
            $memberList = $this->associationHandler->getAssociationMembersList($chapter_ids);
            foreach ($memberList as $signupids) {
                $getpayment[] = $signupids['signupid'];
            }
            $memberCount = count($memberList);
        }

        $getTotalPayment = !empty($getpayment) ? $this->associationHandler->getPaymentInfo($getpayment) : 0;

        $data['orgnizerDetails'] = $orgnizerData['response']['orgDetails'];
        $data['chapterCount'] = count($chapterList);
        $data['totalPayment'] = !empty($getTotalPayment) ? round($getTotalPayment[0]['totalamount']) : 0;
        $data['membersCount'] = $memberCount;
        $data['content'] = '../association/association_dashboard';
        $data['pageName'] = 'Association Dashboard';
        $data['pageTitle'] = 'MeraEvents | Association Dashboard';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;

        $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui', $this->config->item('js_public_path') . 'intlTelInput');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function profile($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $inputArray['id'] = $id;
        $orgnizerData = $this->associationHandler->getAssociationProfileDetails($inputArray);

        $update = $this->input->post('OrganizerDetailsForm');
        if ($update && $this->input->post("org_id") > 0) {
            $userInfo['orgid'] = $this->input->post("org_id");
            $userInfo['name'] = $this->input->post("name");
            $userInfo['domain'] = $this->input->post("domain");
            $userInfo['information'] = $this->input->post("information");
            $userInfo['seotitle'] = $this->input->post("seotitle");
            $userInfo['seokeywords'] = $this->input->post("seokeywords");
            $userInfo['seodescription'] = $this->input->post("seodescription");
            $userInfo['facebooklink'] = $this->input->post("facebooklink");
            $userInfo['twitterlink'] = $this->input->post("twitterlink");
            $userInfo['linkedinlink'] = $this->input->post("linkedinlink");
            $userInfo['instagramlink'] = $this->input->post("instagramlink");
            $userInfo['logopathid'] = $_FILES['logopathid'];
            $userInfo['faviconpathid'] = $_FILES['faviconpathid'];
            $updatePersonalData = $this->associationHandler->updateAssociationProfile($userInfo);
            if ($updatePersonalData['status']) {
                redirect(commonHelperGetPageUrl('association'));
            } else {
                $data['status'] = FALSE;
                $data['message'] = $updatePersonalData['response']['messages'][0];
                $this->customsession->setData('promoterSuccessAdded', 'ADDED_SUCCESSFULL');
            }
        }

        $data['orgnizerDetails'] = $orgnizerData['response']['organizationData'][0];
        $data['content'] = '../association/edit_association_profile_details';
        $data['pageName'] = 'MyMemberships';
        $data['pageTitle'] = 'MeraEvents | Association Details';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;

        $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui', $this->config->item('js_public_path') . 'intlTelInput');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'intlTelInput');
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/profile');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function members($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $chaptesdata = $this->associationHandler->getAssociationMembers($id);
        $this->customsession->setData('currentAssociationId', $id);
        $data['regMembers'] = !empty($chaptesdata) ? $chaptesdata['userdetails'] : array();
        $data['pageName'] = 'Association Members Directory';
        $data['pageTitle'] = 'MeraEvents | Association - Members Directory';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;
        $data['content'] = 'association/members_directory';
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/table-saw');
        $this->load->view('templates/chapter_template', $data);
    }

    public function chapters($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $inputArray['id'] = $id;
        $associationChapterDetails = $this->associationHandler->getChapterList($inputArray);

        $data['orgnizerDetails'] = $associationChapterDetails['response']['organizationData'];
        $data['pageName'] = 'Association Chapters';
        $data['pageTitle'] = 'MeraEvents | Association - Manage Chapters';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;
        $data['content'] = '../association/all_chapters';
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/table-saw');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function addchapter($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }

        if ($this->input->post('submit')) {
            $inputArray['name'] = $this->input->post('name');
            $inputArray['slug'] = $this->input->post('slug');
            $inputArray['logopathid'] = $_FILES['logopathid'];
            $inputArray['bannerpathid'] = $_FILES['bannerpathid'];
            $inputArray['information'] = $this->input->post('information');
            $inputArray['orgid'] = $id;
            $userId = $this->customsession->getUserId();
            $inputArray['userid'] = $userId;

            $userNameCheck = $this->associationHandler->checkUrl($inputArray['slug']);

            if ($userNameCheck['status'] == true) {
                $status = FALSE;
                $messages = $userNameCheck['response']['messages'];
            } else {
                $output = $this->associationHandler->addChapter($inputArray);
                if ($output) {
                    $this->customsession->setData('promoterSuccessAdded', ADDED_SUCCESSFULL);
                    redirect(commonHelperGetPageUrl('association_chapters') . "/" . $id);
                }else{
                    $data['status'] = FALSE;
                    $data['message'] = $updatePersonalData['response']['messages'][0];
                    $this->customsession->setData('promoterSuccessAdded', 'ADDED_SUCCESSFULL');
                }
            }
            $data['message'] = $messages;
            $data['status'] = $status;
        }

        $data['content'] = 'association/add_chapter';
        $data['pageName'] = 'Add Chapter';
        $data['pageTitle'] = 'MeraEvents | Association - Add Chapter';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;

        $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui', $this->config->item('js_public_path') . 'intlTelInput');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'intlTelInput');
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/profile');
        $this->load->view('templates/chapter_template', $data);
    }

    public function editchapter($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        if ($this->session->flashdata('message')) {
            $messages = $this->session->flashdata('message');
        }

        $inputArray['id'] = $id;
        $orgnizerData = $this->associationHandler->getChapter($inputArray);
        $update = $this->input->post('OrganizerDetailsForm');
        if ($update) {
            $userInfo['orgid'] = $this->input->post("org_id");
            $userInfo['name'] = $this->input->post("name");
            $userInfo['information'] = $this->input->post("information");
            $userInfo['bannerpathid'] = $_FILES['bannerpathid'];
            $userInfo['logopathid'] = $_FILES['logopathid'];
            $userInfo['parentassociationid'] = $this->input->post('parentassociationid');

            $userNameCheck = $this->associationHandler->checkUrl($userInfo['name']);

            if ($userNameCheck['status'] == true && $id != $userNameCheck['response']['data']['0']['id']) {
                $status = FALSE;
                $messages = $userNameCheck['response']['messages'];
            } else {
                $updatePersonalData = $this->associationHandler->editChapter($userInfo);
                //echo "<pre>"; print_r($updatePersonalData); exit;
                if ($updatePersonalData['status']) {
                    $this->customsession->setData('promoterSuccessAdded', ADDED_SUCCESSFULL);
                    redirect(commonHelperGetPageUrl('association_chapters') . "/" . $userInfo['parentassociationid']);
                } else {
                    $data['status'] = FALSE;
                    $data['message'] = $updatePersonalData['response']['messages'][0];
                    $this->customsession->setData('promoterSuccessAdded', 'ADDED_SUCCESSFULL');
                }
            }
        }
        $data['content'] = 'association/edit_chapter';
        $data['pageName'] = 'Edit Chapter';
        $data['pageTitle'] = 'MeraEvents | Association - Edit Chapter';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $orgnizerData['response']['organizationData'][0]['parentassociationid'];

        $data['orgnizerDetails'] = $orgnizerData['response']['organizationData'][0];
        $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui', $this->config->item('js_public_path') . 'intlTelInput');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'intlTelInput');
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/profile');
        $this->load->view('templates/chapter_template', $data);
    }

    public function deletechapter($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $deletechapter = $this->associationHandler->deletechapter($id);
        if ($deletechapter['status'] == FALSE) {
            $this->customsession->setData('promoterSuccessAdded', CHAPTER_DELETE_SUCCESSFUL);
        } else {
            $this->customsession->setData('promoterSuccessAdded', MEMBERSHIP_DELETE_MESSAGE);
        }
        redirect(commonHelperGetPageUrl('association_chapters') . "/" . $deletechapter['o_id']);
    }

    public function checkNameExists()
    {
        $url = $_REQUEST['url'];
        $orgid = $_REQUEST['orgId'];

        $inputArray['url'] = $url;
        $inputArray['orgId'] = $orgid;

        $check = $this->associationHandler->checkNameExists($inputArray);
        if ($check) {
            $output['status'] = TRUE;
            $output['response']['userNameStatus'] = TRUE;
            $output['response']['messages'] = CHAPTER_EXIST;
            $output['response']['total'] = 1;
            $output['statusCode'] = STATUS_OK;
            echo json_encode($output, false);
        } else {
            $output['status'] = TRUE;
            $output['response']['userNameStatus'] = FALSE;
            $output['response']['messages'] = CHAPTER_NAME_AVAILABLE;
            $output['response']['total'] = 0;
            $output['statusCode'] = STATUS_OK;
            echo json_encode($output, true);
        }
    }

    //function to get the members registered for particular chapter
    public function viewChapterMembers($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $getChapterMembers = $this->organizationHandler->getChapterMembers($id);

        $data['getCmembers'] = $getChapterMembers;
        $data['getCmembers']['id'] = $id;
        $data['pageName'] = 'Chapter Members';
        $data['pageTitle'] = 'MeraEvents | Association Chapters';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $getChapterMembers['parentassociationid'];
        $data['content'] = '../association/all_registered_members';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/table-saw'
        );
        $this->load->view('templates/dashboard_template', $data);
    }

    //function to get the chapter dashboard
    public function chapterReports($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }

        $getReports = $this->associationHandler->getchapterReports($id);
        $data['content'] = 'chapter_reports_view';
        $data['pageName'] = 'Organization Details';
        $data['pageTitle'] = 'MeraEvents | Chapter Dashboard';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $getReports['parentassociationid'];
        if (!empty($getReports['signupid'])) {
            $data['membersCount'] = count($getReports['signupid']);
        } else {
            $data['membersCount'] = 0;
        }
        $data['chapterDetails'] = $getReports;
        $data['chapterDetails']['id'] = $id;
        $data['jsTopArray'] = array($this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'intlTelInput');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'intlTelInput');
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/profile');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function export($type, $id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        if ($type == 'association') {
            $usersData = $this->associationHandler->getAssociationMembers($id);
        } else {
            $usersData = $this->organizationHandler->getChapterMembers($id);
        }
        ob_end_clean();

        $filename = 'users_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        $file = fopen('php://output', 'w');

        if (empty($usersData['userdetails'])) {
            $header = array("No data found, Thank you");
            fputcsv($file, $header);
        } else {
            $header = array("Name", "Email", "Mobile", "Valid From", "Valid To", "Reg No.", "Type", "Category", "Chapter");
            if ($type != 'association') {
                unset($header[8]);
            }
            fputcsv($file, $header);
            foreach ($usersData['userdetails'] as $line) {
                $line['validfrom'] = date("d-F-Y", strtotime($line['validfrom']));
                $line['validto'] = date("d-F-Y", strtotime($line['validto']));
                fputcsv($file, $line);
            }
        }
        fclose($file);
        exit;
    }

    public function membershiptypes($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $inputArray['id'] = $id;
        $membership_types = $this->associationHandler->getMembershipTypes($inputArray);

        $data['membership_types'] = $membership_types['response']['membership_types'];
        $data['pageName'] = 'Association Chapters';
        $data['pageTitle'] = 'MeraEvents | Association - Memership Types';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;
        $data['content'] = 'association/all_membership_types';
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/table-saw'
        );
        $this->load->view('templates/chapter_template', $data);
    }

    public function addmembershiptype($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        if ($this->input->post('submit')) {
            $inputArray = $_POST;
            $inputArray['associationid'] = $id;
            $add = $this->associationHandler->addMembershipType($inputArray);
            if ($add) {
                $this->customsession->setData('promoterSuccessAdded', ADDED_SUCCESSFULL);
                redirect(commonHelperGetPageUrl('association_membershiptypes') . "/" . $inputArray['associationid']);
            } else {
                $data['output'] = $add['response']['messages'][0];
            }
        }

        $chapterinputArray['id'] = $id;
        $associationChapterDetails = $this->associationHandler->getChapterList($chapterinputArray);
        $data['pageName'] = 'Association Chapters';
        $data['pageTitle'] = 'MeraEvents | Association - Add Membership Type';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;
        $data['chapterList'] = $associationChapterDetails['response']['organizationData'];
        $data['content'] = '../association/add_membership_type';
        $data['jsArray'] = array($this->config->item('js_public_path') . 'bootstrap',
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'bootstrap-timepicker',
            $this->config->item('js_public_path') . 'dashboard/membership_type');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'dashboard-timepicker',
            $this->config->item('css_public_path') . 'bootstrap',
            $this->config->item('css_public_path') . 'jquery-ui');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function editmembershiptype($id)
    {
        $checkAccess = $this->associationHandler->checkMembershipAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $getMembershipData = $this->associationHandler->getMembershipTypeData($id);
        if ($getMembershipData['status'] == FALSE) {

            if ($this->input->post('submit')) {
                $inputArray = $this->input->post();
                $editMemType = $this->associationHandler->editMembershipType($inputArray);

                if ($editMemType) {
                    $this->customsession->setData('promoterSuccessAdded', UPDATED_SUCCESSFULL);
                    redirect(commonHelperGetPageUrl('association_membershiptypes') . "/" . $inputArray['org_id']);
                }
            }

            $chapterinputArray['id'] = $getMembershipData['org_id'];
            $associationChapterDetails = $this->associationHandler->getChapterList($chapterinputArray);
            $data['getMem'] = $getMembershipData;
            $data['pageName'] = 'Membership Types';
            $data['pageTitle'] = 'MeraEvents | Association - Edit Membership Type';
            $data['hideLeftMenu'] = 1;
            $data['associationMenu'] = 1;
            $data['associationId'] = $getMembershipData['org_id'];
            $data['chapterList'] = $associationChapterDetails['response']['organizationData'];
            $data['content'] = '../association/edit_membership_type';
            $data['jsArray'] = array($this->config->item('js_public_path') . 'bootstrap',
                $this->config->item('js_public_path') . 'jQuery-ui',
                $this->config->item('js_public_path') . 'bootstrap-timepicker',
                $this->config->item('js_public_path') . 'dashboard/membership_type');
            $data['cssArray'] = array($this->config->item('css_public_path') . 'dashboard-timepicker',
                $this->config->item('css_public_path') . 'bootstrap',
                $this->config->item('css_public_path') . 'jquery-ui');
            $this->load->view('templates/dashboard_template', $data);
        } else {
            $this->customsession->setData('promoterSuccessAdded', MEMBERSHIP_EDIT_MESSAGE);
            redirect(commonHelperGetPageUrl('association_membershiptypes') . "/" . $getMembershipData['org_id']);
        }
    }

    public function deletemembershiptype($id)
    {
        $checkAccess = $this->associationHandler->checkMembershipAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $deleteMembership = $this->associationHandler->deleteMembershipType($id);
        if ($deleteMembership['status'] == FALSE) {
            $this->customsession->setData('promoterSuccessAdded', MEMBERSHIP_DELETE_SUCCESSFUL);
            redirect(commonHelperGetPageUrl('association_membershiptypes') . "/" . $deleteMembership['o_id']);
        } else {
            $this->customsession->setData('promoterSuccessAdded', MEMBERSHIP_DELETE_MESSAGE);
            redirect(commonHelperGetPageUrl('association_membershiptypes') . "/" . $deleteMembership['o_id']);
        }
    }

    public function addNewMember($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $inputArray['id'] = $id;
        $associationChapterDetails = $this->associationHandler->getChapterList($inputArray);
        if (!empty($associationChapterDetails['response']['organizationData'])) {
            if ($this->input->post('submit')) {
                $inputArrays = $this->input->post();
                $addMemberInput = $this->organizationHandler->addMemberData($inputArrays);
                if (empty($addMemberInput['status'])) {
                    $this->customsession->setData('promoterSuccessAdded', $addMemberInput['response']['messages']);
                    $data['message'] = $addMemberInput['response']['messages'];
                    $data['status'] = '';
                } else {
                    $eventSignupId = $addMemberInput['response']['total'];
                    $usersdata = $this->organizationHandler->userData($eventSignupId);
                    $this->organizationHandler->sendConfirmationEmail($usersdata);
                    $this->customsession->setData('promoterSuccessAdded', UPDATED_SUCCESSFULL);
                    redirect(commonHelperGetPageUrl('association_members') . "/" . $id);
                }
            }

            $chapters = $associationChapterDetails['response']['organizationData'];
            $data['chapters'] = $chapters;
            $data['pageName'] = 'Association Chapters';
            $data['pageTitle'] = 'MeraEvents | Association - Add New Member';
            $data['hideLeftMenu'] = 1;
            $data['associationMenu'] = 1;
            $data['associationId'] = $id;
            $data['content'] = 'association/add_new_members';
            $this->load->view('templates/chapter_template', $data);
        } else {
            $this->customsession->setData('promoterSuccessAdded', EMPTY_MEMBERSHIP_TYPES);
            redirect(commonHelperGetPageUrl('association_members') . "/" . $id);
        }
    }

    public function updateProfilePic($id)
    {
        $associationId = $this->customsession->getData('currentAssociationId');
        $checkAccess = $this->associationHandler->checkAssociationAccess($associationId);
        $memberStatus = $this->associationHandler->isValidAssociationMember($id, $associationId);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }

        if (!$memberStatus) {
            $this->noAccess();
            return false;
        }

        $userInfo           = array();
        $userInfo['userId'] = $id;

        if ($this->input->post('submit')) {
            $image = $_FILES['picture']['name'];
            if ($image) {
                $updatePersonalData = $this->profileHandler->updateMemberProfileImage($userInfo);
            }

            $personalInfo['profileimagefileid'] = $updatePersonalData['response']['imageFileId'];
            $data['message'] = $updatePersonalData['response']['messages']['0'];
            $data['status']  = $updatePersonalData['status'];
        }

        if ($userInfo['userId'] > 0) {
            $personalDetails = $this->profileHandler->getPersonalDetails($userInfo);
            $data['personalDetails']['profileimagefilepath']
                = $personalDetails['response']['personalDetails']['0']['response']['userData']['profileimagefilepath'];
        }

            $data['pageName'] = 'Upload Profile Picture';
            $data['pageTitle'] = 'MeraEvents | Association Member - Upload Profile Picture';
            $data['hideLeftMenu'] = 1;
            $data['associationMenu'] = 1;
            $data['associationId'] = $associationId;
            $data['content'] = 'association/update_profile_pic';
            $this->load->view('templates/chapter_template', $data);
    }

    public function getMembershipTypeOptions()
    {
        $inputArray = $this->input->post();
        $membershipTypes = $this->organizationHandler->getMembershipTypes($inputArray);
        $data = '<option value="">Select Membership Type</option>';
        if (!empty($membershipTypes['response']['membershipTypes'])) {
            foreach ($membershipTypes['response']['membershipTypes'] as $membershipType) {
                $data .= "<option value=" . $membershipType['id'] . ">" . $membershipType['name'] . "</option>";
            }
        }
        echo $data;
    }

    public function getMembershipTypeCustomFields()
    {
        $inputArray = $this->input->post();
        $customFields = $this->organizationHandler->getMembershipTypeCustomFields($inputArray);
        $data['customFields'] = $customFields;
        $this->load->view('association/membership_custom_fields', $data);
    }

    public function customfields($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $inputArray['associationid'] = $id;
        $getCustomfields = $this->associationHandler->getCustomfields($inputArray);
        $data = array();
        $data['fieldData'] = $getCustomfields;
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;
        $data['jsArray'] = array($this->config->item('js_public_path') . 'dashboard/customfieldslisting');
        $data['content'] = '../association/custom_fields';
        $data['pageTitle'] = 'MeraEvents | Association - Custom Fields';
        $this->load->view('templates/dashboard_template', $data);
    }

    public function addcustomfield($id)
    {
        $checkAccess = $this->associationHandler->checkAssociationAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        if ($this->input->post('submit')) {
            $inputArray = $this->input->post();
            $addMemberInput = $this->associationHandler->addfields($inputArray);
            if ($addMemberInput) {
                $this->customsession->setData('promoterSuccessAdded', ADDED_SUCCESSFULL);
                redirect(commonHelperGetPageUrl('association-custom-fields') . "/" . $id);
            }
        }
        $inputArray['id'] = $id;
        $membership_types = $this->associationHandler->getMembershipTypes($inputArray);
        $this->organization_model->resetVariable();
        $selectInput['id'] = $this->organization_model->id;
        $selectInput['eventid'] = $this->organization_model->eventid;
        $this->organization_model->setSelect($selectInput);
        $where[$this->organization_model->id] = $id;
        $this->organization_model->setWhere($where);
        $associationdata = $this->organization_model->get();
        $data['membership_types'] = $membership_types['response']['membership_types'];
        $data['associationdata'] = $associationdata;
        $data['pageTitle'] = 'MeraEvents | Association - Add Custom Field';
        $data['content'] = '../association/add_custom_field';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $id;
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/customscripts',
            $this->config->item('js_public_path') . 'dashboard/customfields',
            $this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'common');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function editcustomfield($id)
    {
        $inputArray['customfieldid'] = $id;
        $checkAccess = $this->associationHandler->checkCustomFieldAccess($id);
        if (empty($checkAccess['status'])) {
            $this->noAccess();
            return false;
        }
        $getFields = $this->associationHandler->getFieldData($inputArray);
        $associationData = $this->associationHandler->getAssociationByEvent($getFields['customfieldsdata'][0]['eventid']);
        if ($this->input->post('submit')) {
            $inputArray = $this->input->post();
            $inputArray['customfieldid'] = $id;
            $addMemberInput = $this->associationHandler->editfields($inputArray);
            if ($addMemberInput) {
                $this->customsession->setData('promoterSuccessAdded', ADDED_SUCCESSFULL);
                redirect(commonHelperGetPageUrl('association-custom-fields') . "/" . $associationData[0]['id']);
            }
        }
        $inputArray['id'] = $associationData[0]['id'];
        $membership_types = $this->associationHandler->getMembershipTypes($inputArray);
        $data['membership_types'] = $membership_types['response']['membership_types'];
        $data['associationdata'] = $associationData;
        $data['fieldsdata'] = $getFields;
        $data['pageTitle'] = 'MeraEvents | Association - Edit Custom Field';
        $data['content'] = '../association/edit_custom_field';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['associationId'] = $associationData[0]['id'];
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'dashboard/customscripts',
            $this->config->item('js_public_path') . 'dashboard/customfields',
            $this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $data['cssArray'] = array($this->config->item('css_public_path') . 'common');
        $this->load->view('templates/dashboard_template', $data);
    }

    public function updatecustomfieldorder($inputArray)
    {
        $inputArray['ordervalue'] = $_GET['ordervalue'];
        $inputArray['customfieldid'] = $_GET['customfieldid'];
        $updatefield = $this->associationHandler->updateordercustomfield($inputArray);
        $data['status'] = $updatefield['status'];
        $data['response'] = $updatefield['response'];
        return $data;
    }

    public function updateMembershipUserProfile($c_id)
    {
        $getChapterMembershipInfo = $this->associationHandler->getChapterMembershipData($c_id);
        $inputArray['id'] = $getChapterMembershipInfo['membershipdetailsinfo'][0]['membershipid'];
        $customFields = $this->organizationHandler->getMembershipTypeCustomFields($inputArray);

        if ($this->input->post('submit')) {
            $inputArrays = $this->input->post();
            $updateData = $this->organizationHandler->updateMembershipUserProfile($inputArrays);
            if ($updateData) {
                redirect(commonHelperGetPageUrl('my_memberships'));
            }
        }

        $data['customFields'] = $customFields;
        $data['editdata'] = $getChapterMembershipInfo;
        $data['pageName'] = 'Association Chapters';
        $data['pageTitle'] = 'MeraEvents | Association - Add New Member';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'association/update_membership_profile';
        $this->load->view('templates/chapter_template', $data);
    }

    public function noAccess()
    {
        $message = $this->uri->segment(3);
        $data['pageName'] = 'Event Dashboard';
        $data['pageTitle'] = 'Event Dashboard';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'no_acess_view';
        $data['message'] = $message;
        $this->load->view('templates/dashboard_template', $data);
    }

    // public function importMembers($id)
    // {
    //     $inputArray['id'] = $id;
    //     $associationChapterDetails = $this->associationHandler->getChapterList($inputArray);
    //     $inputArray['cid'] = $this->input->post('chapter_id');
    //     $inputArray['mid'] = $this->input->post('mermbershiptype_id');
    //     $inputArray['file'] = $this->input->post('csvfile');
    //     $eventId = $this->associationHandler->getEventId($inputArray);
    //     $inputArray['eventid'] = $eventId[0]['eventid'];
    //     $update = $this->input->post('guestBooking');

    //     if ($update == "Upload") {
    //         $this->customsession->unSetData('errorCsvFile');
    //         $booking = $this->associationHandler->checkimport($inputArray);
    //         if ($booking['status'] == TRUE) {
    //             $data['status'] = true;
    //             if(isset($booking['errorFileUrl']) && $booking['errorFileUrl'] !=''){
    //                 $data['errorUrl'] = $booking['errorFileUrl'];
    //             }
    //             $data['messages'] = $booking['response']['messages'][0];
    //             $successMessage = $booking['response']['messages'][0];
    //             $this->customsession->setData('guestListBookingSuccessMessage', $successMessage);
    //             $this->customsession->setData('errorCsvFile', $booking['errorFileUrl']);
    //             $redirectUrl = commonHelperGetPageUrl('dashboard-guestlist-booking', $eventId);
    //             redirect($redirectUrl);
    //         } else {
    //             $this->customsession->unSetData('errorCsvFile');
    //             $data['status'] = false;
    //             $data['messages'] = $booking['response']['messages'][0];
    //         }
    //     }
    //     //$importdata = $this->associationHandler->checkimport($inputArray);

    //     $chapters = $associationChapterDetails['response']['organizationData'];
    //     $data['chapters'] = $chapters;
    //     $data['membership_types'] = $membership_types['response']['membership_types'];
    //     $data['pageName'] = 'Guest List Booking';
    //     $data['pageTitle'] = 'MeraEvents | Association Import Members';
    //     $data['hideLeftMenu'] = 0;
    //     $data['associationId'] = $id;
    //     $data['content'] = 'association_import_members_view';
    //     $data['jsArray'] = array(
    //         $this->config->item('js_public_path') . 'dashboard/offlinePromoter'
    //     );
    //     $this->load->view('templates/dashboard_template', $data);
    // }

    public function termsandconditions($id)
    {
        $associationid = $id;
        $userId = $this->customsession->getUserId();
        $inputArray['id'] = $userId;
        $getTerms = $this->associationHandler->getTerms($associationid);
        if ($this->input->post('submit')) {
            $updateArray['associationid'] = $this->input->post('associationid');
            $updateArray['termsandconditions'] = strip_tags($this->input->post('tncDescription'), '<div><p><strong><em><img><a><ul><li><ol><span><font><h1><h2><h3><h4><h5><h6><br><table><th><tr><td><sup><sub><center>');
            $insertTerms = $this->associationHandler->inserTerms($updateArray);

            if ($insertTerms) {
                $this->customsession->setData('promoterSuccessAdded', UPDATED_SUCCESSFULL);
                redirect(commonHelperGetPageUrl('association_terms_conditions') . "/" . $associationid);
            }
        }
        $data['pageName'] = 'Association Chapters';
        $data['pageTitle'] = 'MeraEvents | Association - Terms & Conditions';
        $data['hideLeftMenu'] = 1;
        $data['associationMenu'] = 1;
        $data['content'] = '../association/add_terms_conditions';
        $data['associationId'] = $associationid;
        $data['termsandconditions'] = $getTerms[0]['termsandconditions'];
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'tinymce/tinymce',
            $this->config->item('js_public_path') . 'customTmc',
            $this->config->item('js_public_path') . 'dashboard/dashboard_configure');
        $this->load->view('templates/dashboard_template', $data);
    }

}
