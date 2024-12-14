<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/category_handler.php');

class Category extends REST_Controller {

    public function __construct() {
        parent::__construct();
		parent::_oauth_validation_check();
        $this->categoryHandler = new Category_handler();
    }

    /*
     * Function to get the Category list
     *
     * @access	public
     * @param	string (major - 1 or 0)
     * @return	array
     */

    public function index_get() {
        $inputArray = $this->get();
        $categoryList = $this->categoryHandler->getCategoryList($inputArray);
        if ($categoryList['status'] && $categoryList['response']['total'] > 0) {
                    $formattedResponse = array();
                    foreach ($categoryList['response']['categoryList'] as $arrKey => $category) {
                        foreach ($category as $key => $value) {
                            switch ($key) {
                                case 'themecolor':
                                    $formattedResponse[$arrKey]['themeColor'] = $value;
                                    break;
                                case 'ticketsetting':
        //                            $formattedResponse[$arrKey]['ticketSetting'] = $value;
                                    break;
                                case 'categorydefaultbannerid':
                                    $formattedResponse[$arrKey]['defaultBannerPath'] = $value;
                                    break;
                                case 'categorydefaultthumbnailid':
                                    $formattedResponse[$arrKey]['defaultThumbnailPath'] = $value;
                                    break;
                                case 'imagefileid':
                                    $formattedResponse[$arrKey]['iconPath'] = $value;
                                    break;
                                default :$formattedResponse[$arrKey][$key] = $value;
                                    break;
                            }
                        }
                    }
                    $categoryList['response']['categoryList'] = $formattedResponse;
        }
        $resultArray = array('response' => $categoryList['response']);
        $statusCode = $categoryList['statusCode'];
        $this->response($resultArray, $statusCode);
    }

}
