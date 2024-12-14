<?php

/**
 * To accept authorization from user
 *
 * Used to accept authorization from user
 *
 * @author     Original Author <Jagadish M S>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS:1.0
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'libraries/REST_Controller.php');
require_once(APPPATH . 'handlers/common_handler.php');
require_once(APPPATH . 'handlers/file_handler.php');
//error_reporting(-1);
//ini_set('display_errors',-1);
//require(APPPATH.'libraries/REST_Controller.php');
class Authorize extends REST_Controller {

    public $server, $ci;

    public function __construct() {
        parent::__construct();
        $this->ci = & get_instance();
        $this->load->model('Server_model');
        $this->load->model('Oauth_clients_model');
        $this->server = $this->Server_model->getServer();
        $this->commonHandler = new Common_handler();
    }

    public function authorizationcode_get() {
        $input = $this->input->get();
        //if (empty(getUserId())) {
//            $statusCode = STATUS_BAD_REQUEST;
//            $output = array();
//            $output['response']['messages'][] = ERROR_NO_SESSION;
//            $this->response($output,$statusCode);
//        } else {
			$this->ci->form_validation->reset_form_rules();
			$this->ci->form_validation->pass_array($input);
			$this->ci->form_validation->set_rules('clientId', 'clientId', 'is_natural_no_zero|required_strict');
			//$this->ci->form_validation->set_rules('response_type', 'response_type', 'required_strict');
			//$this->ci->form_validation->set_rules('state', 'state', 'required_strict');
			if ($this->ci->form_validation->run() == FALSE) {
				$response = $this->ci->form_validation->get_errors();
				$output['response']['messages'] = $response['message'];
				$statusCode = STATUS_BAD_REQUEST;
				$this->response($output,$statusCode);
			}
			$_GET['client_id']=$this->input->get('clientId');
			$_GET['response_type']='code';
            $request = OAuth2\Request::createFromGlobals();
			$response = new OAuth2\Response();
			$user_id = $this->ci->customsession->getData('userId');
			$is_authorized=true;
            $this->server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);
			//print_r($response);exit;
			//var_dump($response->getStatusCode());exit;
			if ($response->getStatusCode() != 302) {
				$output['response']['messages'][] = $response->getParameter('error_description');
				$statusCode = $response->getStatusCode();
				$this->response($output,$statusCode);
            }else{
				$code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=') + 5, 40);
				$output['response']['authorizationCode']=$code;
				$this->response($output,STATUS_OK);
			}
       // }
    }
	public function getaccesstoken_post(){
		$input=$this->input->post();
		$this->ci->form_validation->reset_form_rules();
		$this->ci->form_validation->pass_array($input);
		$this->ci->form_validation->set_rules('clientId', 'clientId', 'is_natural_no_zero|required_strict');
		$this->ci->form_validation->set_rules('clientSecret', 'clientSecret', 'required_strict');
		$this->ci->form_validation->set_rules('authorizationCode', 'authorizationCode', 'required_strict');
		if ($this->ci->form_validation->run() == FALSE) {
			$response = $this->ci->form_validation->get_errors();
			$output['response']['messages'] = $response['message'];
			$statusCode = STATUS_BAD_REQUEST;
			$this->response($output,$statusCode);
		}
		$_POST['client_id']=$this->input->post('clientId');
		$_POST['client_secret']=$this->input->post('clientSecret');
		$_POST['grant_type']='authorization_code';
		$_POST['code']=$this->input->post('authorizationCode');
		$request = OAuth2\Request::createFromGlobals();
        $response = new OAuth2\Response();
		$this->server->handleTokenRequest($request,$response);
		if($response->getStatusCode()!=200){
			$output['response']['messages'][] = $response->getParameter('error_description');
			$statusCode = $response->getStatusCode();
			$this->response($output,$statusCode);
		}else{
			$output['response']['accessToken'] = $response->getParameter('access_token');
			$output['response']['expiresIn'] = date("d/m/Y h:i:s a", time() + $response->getParameter('expires_in'));
			$output['response']['tokenType'] = $response->getParameter('token_type');
			$output['response']['refreshToken'] = $response->getParameter('refresh_token');
			$this->response($output,STATUS_OK);
		}
	}

}
