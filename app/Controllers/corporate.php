<?php
/**
 * Created by PhpStorm.
 * User: bbhar
 * Date: 1/10/2018
 * Time: 4:34 PM
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/corporate_handler.php');
class Corporate extends CI_Controller {
    var $commonHandler, $corporateHandler, $ci;
    public function __construct()
    {
        parent::__construct();
        $this->commonHandler = new Common_handler();
        $this->corporateHandler = new Corporate_Handler();
    }

    public function index(){
        //Prepare cookie data
        $cookieData = $this->commonHandler->headerValues();
        //Check if there is any cookie data
        if (count($cookieData) > 0) {
            //Set country list in the data array
            $data['countryList'] = isset($cookieData['countryList']) ? $cookieData['countryList'] : array();
            //Set the default country id
            $this->defaultCountryId = isset($cookieData['defaultCountryId']) ? $cookieData['defaultCountryId'] : $this->defaultCountryId;
        }
        //Set footer values
        $footerValues = $this->commonHandler->footerValues();
        //Set category list
        $data['categoryList'] = $footerValues['categoryList'];
        //Set city list
        $data['cityList'] = $footerValues['cityList'];
        //Set default country id
        $data['defaultCountryId'] = $this->defaultCountryId;
        //Set error is true
        $data['content'] = "includes/static/corporate_view";
        $data['pageName'] = "Corporate Users";
        $data['pageTitle'] =  "Corporate";
        $this->load->view('templates/user_template', $data);
    }

    public function store(){
        try {
            if(isset($_POST) && !empty($_POST)){
                print_r( $this->corporateHandler->add($_POST) );
            } else {
                echo respond(false, "Please complete the details!");
            }
        } catch(\Exception $e){

        }
    }

    public function check(){
        try {
            if(isset($_POST) && !empty($_POST)){
                $check = $this->corporateHandler->isActive($_POST['domain']);
                if($check){
                    echo respond(true, "Domain is registered with us!");
                } else {
                    echo respond(false, "Domain is not registered with us!");
                }
            } else {
                echo respond(false, "Enter a domain!");
            }
        } catch (\Exception $e){
            error_log($e->getMessage());
            echo respond(false, "Failed to load data!");
        }
    }

    public function enquire(){
        try {
            if(isset($_POST) && !empty($_POST)){
                print_r( $this->corporateHandler->sendEnquiry($_POST) );
            } else {
                echo respond(false, "Please complete the details!");
            }
        } catch (\Exception $e){

        }
    }
}