<?php

/**
 * Maintaing Gallery related data
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @param		eventId - required
 * 
 */
/*
 * Place includes, constant defines and $_GLOBAL settings here.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');
require(APPPATH . 'handlers/gallery_handler.php');

class Gallery extends REST_Controller {

    var $galleryHandler;

    public function __construct() {
        parent::__construct();
        parent::_oauth_validation_check();
        $this->galleryHandler = new gallery_handler();
    }

    public function index_get() {
        $inputArray = $this->get();
        $galleryList = $this->galleryHandler->getEventGalleryList($inputArray);
        if ($galleryList['status'] && $galleryList['response']['total'] > 0) {
            foreach($galleryList['response']['galleryList'] as $key => $value){
                unset($galleryList['response']['galleryList'][$key]['imageId']); 
                unset($galleryList['response']['galleryList'][$key]['thumbnailId']); 
            }
        }
        $resultArray = array('response' => $galleryList['response'],'statusCode' => $galleryList['statusCode']);
        $this->response($resultArray, $galleryList['statusCode']);
    }

}

