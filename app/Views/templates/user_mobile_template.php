<?php
if($content == 'event_view' || $content == 'search_view') {
    $this->load->view('includes/event_header');
} else {
   $this->load->view('includes/header2'); 
}
 
$this->load->view($content);
$this->load->view('includes/footer2');
?>
