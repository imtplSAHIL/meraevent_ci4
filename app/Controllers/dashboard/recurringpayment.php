<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(-1);
require_once(APPPATH . 'libraries/gocardless/autoload.php');
require_once(APPPATH . 'handlers/config_handler.php');
require_once(APPPATH . 'handlers/recurringpayment_handler.php');
require_once(APPPATH . 'handlers/paymentgateway_handler.php');

class Recurringpayment extends CI_Controller 
{
	public function __construct() {
        parent::__construct();

        //getting required config to initiate gocardless client
        $config_handler = new Config_handler();
        $inputArray['key'] = 'recurringPayment';
        $inputArray['sourcecriteria'] = getUserId();
        $config_qry = $config_handler->getConfigDetails($inputArray);

        if($config_qry['status'] && $config_qry['statusCode']==200 ){
            $config = $config_qry['response']['configData'];    
            //getting enviroment and values from config
            $env = $config['env'];
            $token = $config['token'][$env];
            $env_var = $config['env_vars'][$env];
            $this->stripe_id = $config['stripe_gateway_id'];
            //echo '<pre>'; print_r(constant("\GoCardlessPro\Environment::".$env_var)); exit;
            $this->client = new \GoCardlessPro\Client([
                'access_token' => $token,
                'environment' => constant("\GoCardlessPro\Environment::".$env_var)
            ]);
        }
        else{
            header("Location: ".base_url()."dashboard"); exit;
        }

        $this->load->model('Recurringpaymentuser_model');
        $this->recurringHandler = new Recurringpayment_handler();
    }

    public function index($mode='',$modeid=''){
        
        $params["limit"] = "30";
        
        if($mode=='after'){
            $params['after'] = $modeid;
        }
        else if($mode=='before'){
            $params['before'] = $modeid;
        }
        
        $list = $this->client->payments()->list(["params" => $params]);
        
        if($list->api_response->status_code == 200){
            $payments = $list->api_response->body->payments;
            $data['after'] = $list->api_response->body->meta->cursors->after;
            $data['before'] = $list->api_response->body->meta->cursors->before;
        }
        else{
            //something went wrong.
        }

        $headerFields = array('S. No.','Invoice Id','Status','Created','Charge Date','Amount','Refunded');
        $data['headerFields'] = $headerFields;
        $data['searchData'] = $payments;
        $data['totalTransactions'] = 2;
        $data['messages'] = array();
        $data['pageName'] = 'Recurring Transactions';
        $data['pageTitle'] = 'MeraEvents | Recurring Transactions';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'recurringtransactions_view';
        $data['cssArray'] = array(
           $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'dashboard/apitransactions'
        );
        $this->load->view('templates/dashboard_template', $data);
    }

    public function customers($page=''){
        $inputArray['ownerId'] = getUserId();
        $inputArray['all'] = 1;
        $cusList = $this->recurringHandler->getCustomers($inputArray);
        if($cusList['statusCode'] == 200 && $cusList['statusCode'] ){
            $customers = $cusList['response']['userList'];
            // echo '<pre>'; print_r($customers); exit;
        }
        else{
            //something went wrong.
        }

        $headerFields = array('S. No.','Country','Name','Email','Address','City', 'Postal Code','Company');
        $data['headerFields'] = $headerFields;
        $data['searchData'] = $customers;
        // $data['searchSummary'] = $apiTransactions['response']['searchSummary'];
        $data['totalTransactions'] = $cusList['response']['total'];
        $data['messages'] = array();
        $data['pageName'] = 'Recurring Customers';
        $data['pageTitle'] = 'MeraEvents | Recurring Customers';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'recurringcustomers_view';
        $data['cssArray'] = array(
           $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui'
        );
        $this->load->view('templates/dashboard_template', $data);
    }

    public function addClient($complete=''){
        
        if($complete=='complete'){
            $redirect_flow_id = $this->input->get('redirect_flow_id');
            if($redirect_flow_id){
                $redirectFlow = $this->client->redirectFlows()->complete(
                    $redirect_flow_id, //The redirect flow ID from above.
                    ["params" => ["session_token" => getUserId()]]
                );

                // Save this mandate ID for the further payments.
                $mandate_id = $redirectFlow->links->mandate;

                // Save this customer ID for details.
                $customer_id = $redirectFlow->links->customer;
                //$customer_id = "CU0003P9EEEFSH";

                $customer = $this->client->customers()->get($customer_id);
                if($customer->api_response->status_code ==200){
                    
                    $insertPaymentArray=array();
                    $this->Recurringpaymentuser_model->resetVariable();
                    $insertPaymentArray[$this->Recurringpaymentuser_model->ownerid]=getUserId();
                    $insertPaymentArray[$this->Recurringpaymentuser_model->clientid]=$mandate_id;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->gatewayid]=1;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->firstname]=$customer->api_response->body->customers->given_name;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->lastname]=$customer->api_response->body->customers->family_name;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->email]=$customer->api_response->body->customers->email;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->companyname]=$customer->api_response->body->customers->company_name;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->address]=$customer->api_response->body->customers->address_line1.",".$customer->api_response->body->customers->address_line2.",".$customer->api_response->body->customers->address_line3;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->city]=$customer->api_response->body->customers->city;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->postalcode]=$customer->api_response->body->customers->postal_code;
                    $insertPaymentArray[$this->Recurringpaymentuser_model->countrycode]=$customer->api_response->body->customers->country_code;
                    
                    $this->Recurringpaymentuser_model->setInsertUpdateData($insertPaymentArray);
                    $payId = $this->Recurringpaymentuser_model->insert_data();
                    if(!$payId){
                        $error=1;
                    }
                    else{
                        $this->customsession->setData('addClientFlashMessage', SUCCESS_ADDED);
                        $redirectUrl = commonHelperGetPageUrl('dashboard-recurring');
                        redirect($redirectUrl);
                    }


                }
                else{
                    echo '<pre>fail'; print_r($customer->api_response);
                }
                

                // Display a confirmation page to the customer, telling them their Direct Debit has been
                // set up. You could build your own, or use ours, which shows all the relevant
                // information and is translated into all the languages we support.
                //print("Confirmation URL: " . $redirectFlow->confirmation_url . "<br />");
                //header("Location: ".$redirectFlow->confirmation_url); exit;
            }
        }
        else{
            try {
                $redirectFlow = $this->client->redirectFlows()->create([
                    "params" => [
                        "description" => "ARJYOPA TELECOM",
                        "session_token" => getUserId(),
                        "success_redirect_url" => commonHelperGetPageUrl('dashboard-recurring-complete'),
                    ]
                ]);    
            } catch (Exception $e) {
                echo"<pre>"; print($e->api_error->message); exit;
            }
            

            // Hold on to this ID - you'll need it when you
            // "confirm" the redirect flow later
            // print("ID: " . $redirectFlow->id . "<br />");

            // print("URL: " . $redirectFlow->redirect_url);
            header("Location: ".$redirectFlow->redirect_url); exit;
        }
        

        // echo '<pre>'; print_r("end"); exit;
    }

    public function addStripeClient($complete=''){
        $paymentGatewayHandler = new Paymentgateway_handler();
        $inputArray['gatewayId'] = $this->stripe_id;
        $data = $paymentGatewayHandler->getPaymentgatewayList($inputArray);

        if($data['status'] && $data['statusCode'] == 200 ){
            $secret_key = $data['response']['paymentgatewayList'][$this->stripe_id]['merchantid'];
            $publishable_key = $data['response']['paymentgatewayList'][$this->stripe_id]['hashkey'];
            $data['publishable_key'] = $publishable_key;
        }

        if($this->input->post('stripeSource') != ''){
            try {
                $stripeAccessKeys = array('secret_key' => $secret_key, 'publishable_key' => $publishable_key);
                $this->load->library('stripe/stripe.php', $stripeAccessKeys);

                // Create a Customer:
                $customer = \Stripe\Customer::create([
                    'source' => $this->input->post('stripeSource'),
                    'email' => $this->input->post('email'),
                ]);    

            } catch (Exception $e) {
                $error = $e->getJsonBody();
                $error_msg = $error['error']['message'];
                print ($error_msg); exit;
            }
            
            $customer_id = $customer->id;

            $clientid = $customer->default_source;

            $insertPaymentArray=array();
            $this->Recurringpaymentuser_model->resetVariable();
            $insertPaymentArray[$this->Recurringpaymentuser_model->ownerid]=getUserId();
            $insertPaymentArray[$this->Recurringpaymentuser_model->clientid]=$clientid;
            $insertPaymentArray[$this->Recurringpaymentuser_model->customerid]=$customer_id;
            $insertPaymentArray[$this->Recurringpaymentuser_model->gatewayid]=$this->stripe_id;
            $insertPaymentArray[$this->Recurringpaymentuser_model->firstname]=$this->input->post('firstname');
            $insertPaymentArray[$this->Recurringpaymentuser_model->lastname]=$this->input->post('lastname');
            $insertPaymentArray[$this->Recurringpaymentuser_model->email]=$this->input->post('email');
            $insertPaymentArray[$this->Recurringpaymentuser_model->address]=$this->input->post('address');
            $insertPaymentArray[$this->Recurringpaymentuser_model->city]=$this->input->post('city');
            $insertPaymentArray[$this->Recurringpaymentuser_model->postalcode]=$this->input->post('postal_code');
            $insertPaymentArray[$this->Recurringpaymentuser_model->countrycode]=$this->input->post('country');
            
            $this->Recurringpaymentuser_model->setInsertUpdateData($insertPaymentArray);
            $payId = $this->Recurringpaymentuser_model->insert_data();
            if(!$payId){
                $error=1;
            }
            else{
                $this->customsession->setData('addClientFlashMessage', SUCCESS_ADDED);
                $redirectUrl = commonHelperGetPageUrl('dashboard-recurring');
                redirect($redirectUrl);
            }

        }

        $data['messages'] = array();
        $data['pageName'] = 'Recurring Transactions';
        $data['pageTitle'] = 'MeraEvents | Add Stripe Customer';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'recurringstripe_view';
        $data['cssArray'] = array(
           $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui'
        );
        $this->load->view('templates/dashboard_template', $data);    
        
    }

    public function plan($mode,$id=""){
        $ownerId = getUserId();
        if (!empty($id) && $mode=='edit') {
            $inputArray = $this->input->post(); 
            
            if($inputArray['planSubmit'] == 'Update'){
                $inputArray['id'] = $id;
                $inputArray['ownerId'] = $ownerId;
                $planUpdateData = $this->recurringHandler->updatePlan($inputArray);
                // echo '<pre>'; print_r($planUpdateData); exit;
                if($planUpdateData['status'] && $planUpdateData['statusCode']==200 ){
                    $this->customsession->setData('planFlashMessage', SUCCESS_UPDATED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-recurring-listplans');
                    redirect($redirectUrl);
                }
                else{
                    $this->customsession->setData('planFlashMessage', 'Unable to update plan');
                    $redirectUrl = commonHelperGetPageUrl('dashboard-recurring-listplans');
                    redirect($redirectUrl);
                }
            }
                
            $inputArray['id'] = $id;
            $inputArray['ownerId'] = $ownerId;
            $inputArray['all'] = 1;
            $recPlanData = $this->recurringHandler->getPlans($inputArray);
            
            if($recPlanData['status'] && $recPlanData['statusCode']==200){
                $data['planData'] = $recPlanData['response']['planList'][0];
                $data['edit'] = 1;
            }
            else{
                $data['invalidRecord'] = 1;
            }
            // echo '<pre>'; print_r($data); exit;
            
        } else if($mode=='create'){
            //For adding the discount
            $planSubmit = $this->input->post('planSubmit');
            if ($planSubmit) {
                
                $inputArray = $this->input->post(); //Storing all the input form values in the inputArray
            
                $planData = $this->recurringHandler->addPlan($inputArray);

                if (!$planData['status']) {
                    $this->customsession->setData('planFlashMessage', 'Error While adding Plan');
                    $redirectUrl = commonHelperGetPageUrl('dashboard-recurring-listplans');
                    redirect($redirectUrl);
                } else {
                    $this->customsession->setData('planFlashMessage', SUCCESS_ADDED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-recurring-listplans');
                    redirect($redirectUrl);
                }
            
                
            }
        } else if($mode=='delete'){
            $inputArray = $this->input->post();
            // echo '<pre>'; print_r($inputArray); exit;
            $inputArray['ownerId'] = $ownerId;
            $inputArray['delete'] = 1;
            $planRes = $this->recurringHandler->deletePlan($inputArray);
            // echo '<pre>'; print_r($subRes); exit;
            echo json_encode($planRes); exit;
        
        }

        $data['messages'] = array();
        $data['pageName'] = 'Recurring Transactions';
        $data['pageTitle'] = 'MeraEvents | Add Plan Recurring Transactions ';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'recurringplan_view';
        $data['cssArray'] = array(
           $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'vue'
        );
        $this->load->view('templates/dashboard_template', $data);    

    }

    public function subscription($mode='',$id=""){
        //mode will be either edit or create
        $ownerId = getUserId();
        if (!empty($id) && $mode=='edit') {
            $inputArray = $this->input->post(); 
            if($inputArray['subscriptionSubmit'] == 'Update'){
                $inputArray['id'] = $id;
                $inputArray['ownerId'] = $ownerId;
                // echo '<pre>'; print_r($inputArray); exit;
                $subUpdateData = $this->recurringHandler->updateSubscription($inputArray);
                if($subUpdateData['status'] && $subUpdateData['statusCode']==200 ){
                    $this->customsession->setData('subFlashMessage', SUCCESS_UPDATED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-recurring-listsubscription');
                    redirect($redirectUrl);
                }
                else{
                    $this->customsession->setData('subFlashMessage', 'Unable to update subscription');
                    $redirectUrl = commonHelperGetPageUrl('dashboard-recurring-listsubscription');
                    redirect($redirectUrl);
                }
            }
                
            $inputArray['id'] = $id;
            $inputArray['ownerId'] = $ownerId;
            $inputArray['all'] = $ownerId;
            $recSubData = $this->recurringHandler->getSubscriptions($inputArray);
            if($recSubData['status'] && $recSubData['statusCode']==200){
                $data['subData'] = $recSubData['response']['subscritionList'][0];
                $data['edit'] = 1;
                if(strtotime("now") > strtotime($data['subData']["startdate"])){
                    $data['subStarted'] = 1;
                }
                $startdate = explode("-", $data['subData']["startdate"]);
                $data['subData']["startdate"] = $startdate[2]."/".$startdate[1]."/".$startdate[0];
                $enddate = explode("-", $data['subData']['enddate']);
                $data['subData']["enddate"] = $enddate[2]."/".$enddate[1]."/".$enddate[0];
            }
            else{
                $data['invalidRecord'] = 1;
            }
            // echo '<pre>'; print_r($data); exit;
            $userList = $this->recurringHandler->getCustomers(array('ownerId'=>$ownerId));

            if($userList['status']==1 && $userList['statusCode']==200){
                $data['users'] = $userList['response']['userList'];
            }

            $planList = $this->recurringHandler->getPlans(array('ownerId'=>$ownerId));
            if($planList['status']==1 && $planList['statusCode']==200){
                $data['plans'] = $planList['response']['planList'];
            }
        } else if($mode=='create'){
            //For adding the discount
            $subscriptionSubmit = $this->input->post('subscriptionSubmit');
            if ($subscriptionSubmit) {
                
                $inputArray = $this->input->post(); //Storing all the input form values in the inputArray
                
                $planData = $this->recurringHandler->addSubscription($inputArray);

                if (!$planData['status']) {
                    $this->customsession->setData('subFlashMessage', 'Error While adding Subscription');
                    $redirectUrl = commonHelperGetPageUrl('dashboard-recurring-listsubscription');
                    redirect($redirectUrl);
                } else {
                    $this->customsession->setData('subFlashMessage', SUCCESS_ADDED);
                    $redirectUrl = commonHelperGetPageUrl('dashboard-recurring-listsubscription');
                    redirect($redirectUrl);
                }
            }
            else{
                $userList = $this->recurringHandler->getCustomers(array('ownerId'=>$ownerId));
                if($userList['status']==1 && $userList['statusCode']==200){
                    $data['users'] = $userList['response']['userList'];
                }
                $planList = $this->recurringHandler->getPlans(array('ownerId'=>$ownerId));
                if($planList['status']==1 && $planList['statusCode']==200){
                    $data['plans'] = $planList['response']['planList'];
                }
            }
        }
        else if($mode=='delete'){
            $inputArray = $this->input->post();
            // echo '<pre>'; print_r($inputArray); exit;
            $inputArray['ownerId'] = $ownerId;
            $inputArray['delete'] = 1;
            $subRes = $this->recurringHandler->deleteSubscription($inputArray);
            // echo '<pre>'; print_r($subRes); exit;
            echo json_encode($subRes); exit;
        }

        $data['messages'] = array();
        $data['pageName'] = 'Recurring Transactions';
        $data['pageTitle'] = 'MeraEvents | Add Subscription ';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'recurringsubscription_view';
        $data['cssArray'] = array(
           $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui',
            $this->config->item('js_public_path') . 'vue'
        );
        $this->load->view('templates/dashboard_template', $data);    

    }

    public function listSubscriptions(){
        // error_reporting(-1);
        $inputArray=array();
        $inputArray['ownerId'] = getUserId();
        $inputArray['includeMandate'] = 1;
        $inputArray['includeUser'] = 1;
        $inputArray['includePlan'] = 1;
        $inputArray['all'] = 1;
        $subsList = $this->recurringHandler->getSubscriptions($inputArray);
        // echo '<pre>'; print_r($subsList); exit;
        if($subsList['status'] && $subsList['statusCode'] == 200){
            $subscriptions = $subsList['response']['subscritionList'];
        }
        else{
            
        }

        $headerFields = array('S. No.','Status','Customer','Collecting','Price','Starting','Ending','Action');
        $data['headerFields'] = $headerFields;
        $data['searchData'] = $subscriptions;
        // $data['searchSummary'] = $apiTransactions['response']['searchSummary'];
        $data['totalTransactions'] = $subsList['response']['total'];
        $data['messages'] = array();
        $data['pageName'] = 'Recurring Subscriptions';
        $data['pageTitle'] = 'MeraEvents | Recurring Subscriptions';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'recurringsubscriptions_list_view';
        $data['cssArray'] = array(
           $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui'
        );
        $this->load->view('templates/dashboard_template', $data);
    }

    public function listPlans(){
        // error_reporting(-1);
        $inputArray=array();
        $inputArray['ownerId'] = getUserId();
        $inputArray['all'] = 1;
        $plansList = $this->recurringHandler->getPlans($inputArray);
         // echo '<pre>'; print_r($plansList); exit;
        if($plansList['status'] && $plansList['statusCode'] == 200){
            $plans = $plansList['response']['planList'];
            $total = $plansList['response']['total'];
        }
        else{
            $plans = array();
            $total = 0;
        }

        $headerFields = array('S. No.','Status','Plan Name','Plan Code','Description','Price','Currecy','Action');
        $data['headerFields'] = $headerFields;
        $data['searchData'] = $plans;
        // $data['searchSummary'] = $apiTransactions['response']['searchSummary'];
        $data['totalTransactions'] = $plansList['response']['total'];
        $data['messages'] = array();
        $data['pageName'] = 'Recurring Plans';
        $data['pageTitle'] = 'MeraEvents | Recurring Plans';
        $data['hideLeftMenu'] = 1;
        $data['content'] = 'recurringplans_list_view';
        $data['cssArray'] = array(
           $this->config->item('css_public_path') . 'jquery-ui'
        );
        $data['jsArray'] = array(
            $this->config->item('js_public_path') . 'jQuery-ui'
        );
        $this->load->view('templates/dashboard_template', $data);
    }

    public function payment(){

        $inputArray = array();
        $inputArray['ownerId'] = getUserId();
        $inputArray['currentDay'] = 1;
        $inputArray['includeMandate'] = 1;
        $inputArray['includePlan'] = 1;
        $subs = $this->recurringHandler->getSubscriptions($inputArray);
        //echo '<pre>'; print_r($subs); exit;
        if($subs['status'] && $subs['statusCode']==200){
            if($subs['response']['total'] > 0){
                $subsList = $subs['response']['subscritionList'];
            }
        }

        foreach ($subsList as $key => $subscription) {
            $tempAmount = $tempMandate= $tempInvoice = '';
            $tempPayment = '';
            $tempAmount = $subscription['price'];
            $tempMandate = $subscription['mandate'];
            $invoiceNo = $this->recurringHandler->getInvoiceNo($inputArray);
            
            if($invoiceNo['status'] && $invoiceNo['response']['total'] > 0 ){
                if($invoiceNo['response']['invoiceRes'][0]['id']==''){
                    $tempInvoice = str_pad(1, 7, "0", STR_PAD_LEFT);
                }
                else{
                    $tempInvoice = str_pad($invoiceNo['response']['invoiceRes'][0]['id']+1, 7, "0", STR_PAD_LEFT);;    
                }
            }

            //status from gocardless
            $statsArr = array(  'pending_customer_approval' => '1',
                                'pending_submission' => '2',
                                'submitted' => '3',
                                'confirmed' => '4',
                                'paid_out' => '5',
                                'cancelled' => '6',
                                'customer_approval_denied' => '7',
                                'failed' => '8',
                                'charged_back' => '9');

            if($tempAmount=='' || $tempMandate=='' || $tempInvoice ==''){
                $error = 1;
            }
            else{
                try {
                    $tempPayment = $this->client->payments()->create([
                      "params" => [
                          "amount" => round($tempAmount*100), // 1 GBP in pence
                          "currency" => "GBP",
                          "links" => [
                              "mandate" => $tempMandate
                                           // The mandate ID from last section
                          ],
                          // Almost all resources in the API let you store custom metadata,
                          // which you can retrieve later
                          "metadata" => [
                              "invoice_number" => $tempInvoice
                          ]
                      ],
                      "headers" => [
                          "Idempotency-Key" => $tempInvoice
                      ]
                    ]);
                    if($tempPayment->api_response->status_code=201){
                        $inputArray = array();
                        $tempres = $inputArray['paymentId'] = $inputArray['chargeDate'] ='';
                        $tempres = $tempPayment->api_response->body->payments;
                        $inputArray['ownerId'] = getUserId();
                        $inputArray['recurringPaymentUserId'] = $subscription['recurringpaymentuserid'];
                        $inputArray['paymentId'] = $tempres->id;
                        $inputArray['chargeDate'] = $tempres->charge_date;
                        $inputArray['status'] = $statsArr[$tempres->status];
                        $inputArray['refunded'] = $tempres->amount_refunded;

                        $insertPayRes = $this->recurringHandler->addPayment($inputArray);
                        if(!$insertPayRes['status']){
                            $error=1;
                        }
                        // echo '<pre>'; print_r($tempPayment); 
                    }

                } catch (Exception $e) {
                    $error=1;
                }
                
                // echo '<pre>'; print_r($tempPayment); exit;
            }
        }

    }



        
}