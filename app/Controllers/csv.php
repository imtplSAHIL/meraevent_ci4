<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class csv extends CI_Controller {

    public function __construct() {
        parent::__construct();
      //  $this->load->model('ExcelModel');
        $this->load->library('email');
        $this->load->config('email'); // Load the email config

    }

    public function index() {
        $this->load->view('upload_form');
    }

    public function uploadp() {
        $file = $_FILES['csv_file'];

        if ($file['error'] == 0) {
            $filePath = './uploads/' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $filePath);

            if (($handle = fopen($filePath, 'r')) !== FALSE) {
                $data = [];
                while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $data[] = $row; // Each row is an array
                    // Store each row in the database
                 //   $this->ExcelModel->insert_contact($row[0], $row[1]); // Assuming name is in column 1 and email in column 2
                }
                fclose($handle);

                // Load the preview view
                $this->load->view('excel_preview', ['data' => $data]);
            }
        } else {
            echo "Error uploading file.";
        }
    }
    public function upload() {
        $file = $_FILES['csvfile'];
    
        if ($file['error'] == 0) {
            $filePath = './uploads/' . basename($file['name']);
           // echo $filePath;
            //move_uploaded_file($file['tmp_name'], $filePath);
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    if (($handle = fopen($filePath, 'r')) !== FALSE) {
                        $data = [];
                        $isFirstRow = true; 
                        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            if ($isFirstRow) {
                                $isFirstRow = false; 
                                continue;
                            }
                            if (count($row) >= 2) { 
                                $data[] = $row; 
                            }
                        }
                        fclose($handle);
                        echo json_encode(['status' => 'success', 'data' => $data, 'count' => count($data)]);
                    }
                } else {
                   $data =  error_log("Error moving uploaded file: " . error_get_last()['message']);
                    echo json_encode(['status' => 'fail', 'data' => $data, 'count' => 0]);

                }
            
    
           
        } else {
            echo "Error uploading file.";
        }
    }
    public function send_emailp() {
        if ($this->input->post('data')) {
            $data = json_decode($this->input->post('data'), true);
            
            if ($data === null) {
                echo "JSON decode error: " . json_last_error_msg();
            } else {
                $emailCount = 0;
                foreach ($data as $row) {
                    $email = isset($row[1]) ? $row[1] : ''; // Assuming the email is in the second column
                    
                    // Prepare email
                    $this->email->from('admin@meraevents.com', 'Mera');
                    $this->email->to($email);
                    $this->email->subject('Subject of the Email');
                    $this->email->message('This is a test email.');

                    if ($this->email->send()) {
                        $emailCount++;
                    }

                    // Clear the email settings for the next iteration
                    $this->email->clear();
                }

                // Load success view or display success message
                echo "$emailCount email(s) sent successfully!";
            }
        } else {
            echo "No data received!";
        }
    }
    public function send_email() {
        // Print the raw POST data to check what is being received
     
    
        if ($this->input->post('data')) {
            $data = json_decode($this->input->post('data'), true);
            
          //  print_r($this->input->post('data'));exit;

                $emailCount = 0;
                foreach ($data as $row) {
                    $emailk = isset($row[1]) ? $row[1] : ''; // Assuming the email is in the second column
                    
                    // Prepare email

                    $subject = 'Bulk Registrations Process Completed';
        $message = '<table width="90%" border="0" cellpadding="1" cellspacing="2">
                    <tr>
                        <td colspan="2">Dear ' . trim($row[0]) . ',</td>
                    </tr>
                    <tr>
                    <td colspan="2">&nbsp;<br /></td>
                    </tr>';
        $message.='<tr>
                        <td colspan="2">
                            The bulk registrations process is completed. You can see the uploaded registrations in event dashboard.
                        </td>
                        </tr>
                        <tr>
                        <td colspan="2">&nbsp;<br /></td>
                        </tr>
                        <tr>
                                <td colspan="2">Best Regards, <br />
                                <b>Team Mera Events</b></td>
                        </tr>
                </table>';

        $to   = $row[1];
        $from = 'MeraEvents<admin@meraevents.com>';
        $cc   = '';
        $bcc  = 'venkateshr@meraevents.com, kmlalnehru9@gmail.com';
        
        // echo "<br> $to, $cc, $bcc, $from, $subject <br>";
        // echo '<pre>';print_r($message);echo '</pre>';
        $email = $this->EmailSend($from,$to, $subject, $message,$attachment = '', $replyto = '', $content = NULL, $sentMessageArray = array());
                    // Clear the email settings for the next iteration
                    $this->email->clear();
                }

                // Load success view or display success message
              //  echo "$emailCount email(s) sent successfully!";
            
        } else {
            echo "No data received!";
        }
    }

    function sendEmail($from, $to, $subject, $message, $attachment = '', $replyto = '', $content = NULL, $sentMessageArray = array())
    {
        if ($this->ci->config->Item('emailEnable') == true) {
            $email = '';
            $recepientName = '';
            if (preg_match_all('/\s*"?([^><,"]+)"?\s*((?:<[^><,]+>)?)\s*/', $from, $matches, PREG_SET_ORDER) > 0) {
                foreach ($matches as $m) {
                    if (!empty($m[2])) {
                        $recepientName = $m[1];
                        $email = trim($m[2], '<>');
                    } else {
                        $email = $m[1];
                    }
                }
            }
            //CODE RELATED TO MANDRILL MAIL
            $this->ci->email->from($email, $recepientName);
            $this->ci->email->reply_to($replyto);
            $this->ci->email->to($to);
            $this->ci->email->subject($subject);
            $this->ci->email->message($message);
            // $cc = '';
            $bcc = '';
            $uid = time();
            if (!empty($attachment)) {
                $this->ci->email->attach($attachment);
            }
            $mailResponse = $this->ci->email->send();
            if ($mailResponse) {
                $mailStatus = $mailResponse;
            } else {//If mandrilla mail send failed
                //MANUAL MAIL SENDING
                $email_txt = $message; // Message that the email has in it
                $headers = "From: " . $from;
                $data = $fileatt = $fileatt_type = $fileatt_name = $data = '';
                if ($attachment) {
                    $fileatt = $attachment; // Path to the file
                    $fileatt_type = "application/octet-stream"; // File Type
                    $start = strrpos($attachment, '/') == -1 ? strrpos($attachment, '//') : strrpos($attachment, '/') + 1;
                    $fileatt_name = substr($attachment, $start, strlen($attachment)); // Filename that will be used for the file as the attachment
                    $file = fopen($fileatt, 'rb');
                    $data = fread($file, filesize($fileatt));
                    fclose($file);
                }
                $semi_rand = md5(time());
                $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
                $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
                $email_message .= "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type:text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $email_txt . "\n\n";
                $data = chunk_split(base64_encode($data));
                $email_message .= "--{$mime_boundary}\n" . "Content-Type: {$fileatt_type};\n" . " name=\"{$fileatt_name}\"\n" . //"Content-Disposition: attachment;\n" . //" filename=\"{$fileatt_name}\"\n" . "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n" . "--{$mime_boundary}--\n";
                        $mailStatus = mail($to, $subject, $email_message, $headers);
            }
            $sentMessageArray['status'] = $mailStatus;
                      if ($mailStatus) {
                $output['status'] = TRUE;
                $output["response"]['email'] = Email_SENT;
                $output["response"]['messages'][] = SUCCESS_MAIL_SENT;
                $output['statusCode'] = STATUS_OK;
                return $output;
            } else {
                $output['status'] = FALSE;
                $output["response"]['messages'][] = ERROR_EMAIL_NOT_SENT;
                $output['statusCode'] = STATUS_SERVER_ERROR;
                return $output;
            }
        }
        $output['status'] = TRUE;
        $output["response"]['email'] = Email_SENT;
        $output["response"]['messages'][] = ERROR_EMAIL_NOT_SENT;
        $output['statusCode'] = STATUS_OK;
        return $output;
    }
}
?>