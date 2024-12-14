<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class samplecsv extends CI_Controller {

    public function __construct() {
        parent::__construct();
    //    $this->load->model('CsvModel'); // Load your model
    }

    public function index() {
        $this->load->view('csv_upload_view'); // Load the view
    }

    public function uploadCsv() {
        // Load the CSV library
        $this->load->library('csvreader');

        // Check if a file is uploaded
        if ($_FILES['csvfile']['name']) {
            $config['upload_path'] = './uploads/'; // Ensure this directory exists
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '2048'; // Max size in KB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('csvfile')) {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];

                // Read CSV file
                $csv_data = $this->csvreader->parse_file($file_path);
                echo json_encode(['status' => 'success', 'data' => $csv_data, 'count' => count($csv_data)]);
            } else {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
            }
        }
    }

   /* public function saveData() {
        $data = json_decode($this->input->post('data'), true);
        
        if ($this->CsvModel->insertBatch($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Records saved successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save records']);
        }
    }*/
}
