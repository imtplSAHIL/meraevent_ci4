<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Download controller (Downloading Files)
 *
 * @package		CodeIgniter
 * @author		Qison  Dev Team
 * @copyright	Copyright (c) 2016, Meraevents.
 * @Version		Version 1.0
 * @Since       Class available since Release Version 1.0 
 * @Created     01-30-2016
 * @Last Modified On  01-30-2016
 * @Last Modified By  Raviteja
 */
require_once(APPPATH . 'handlers/reports_handler.php');
require_once(APPPATH . 'handlers/event_handler.php');
require_once(APPPATH . 'handlers/collaborator_handler.php');
class Download extends CI_Controller {
    var $reportsHandler;
    var $eventHandler;
    var $collaboratorHandler;
    public function __construct() {
        parent::__construct();
        $this->reportsHandler = new reports_handler();
        $this->eventHandler = new event_handler();
        $this->collaboratorHandler = new collaborator_handler();
    }
	public function downloadCsv(){
		$inputArray = $this->input->get();
                 $loginCheck = $this->customsession->loginCheck();
                 if ($loginCheck != 1 && !$loginCheck['status'])
                 {
                    $loginurl= commonHelperGetPageUrl('user-login');
                    commonHelperRedirect($loginurl);
                 } 
                  
                $input['userId']=$this->customsession->getUserId();
                $input['eventId'] = $inputArray['eventid'];
                $input['collaborators']=TRUE;
                $userevent = $this->eventHandler->isOrganizerForEvent($input);
                if(!$userevent['status'] || $userevent['response']['totalCount'] == 0)
                {
                    
                   $homepage = commonHelperGetPageUrl('dashboard-transaction-report',$inputArray['eventid'].'&summary&all&1');
                   commonHelperRedirect($homepage);
                }
                //Checking for Collabrator Access
                $CollaInput['userids'][]=$this->customsession->getUserId();
                $CollaInput['eventId'] = $inputArray['eventid'];
                $CollaInput['getacesslevel'] =true;
                $collboratoroutput = $this->collaboratorHandler->getEventByUserIds( $CollaInput);
                
                if(isset($collboratoroutput['response']['collaboratorDetail']) && $collboratoroutput['response']['collaboratorDetail']['module'] == 'promote')
                {
                   $homepage = commonHelperGetPageUrl('dashboard-transaction-report',$inputArray['eventid'].'&summary&all&1');
                   commonHelperRedirect($homepage);
                }
              
		$output = $this->reportsHandler->exportTransactions($inputArray);
		$file = $output['response']['sourcepath'];
		ob_end_clean();
		header('Content-Description: File Transfer');
	    header('Content-Type: "application/octet-stream"');
	    header('Content-Disposition: attachment; filename='.basename($file));
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    readfile($file);
	    exit;
	}
}
?>
