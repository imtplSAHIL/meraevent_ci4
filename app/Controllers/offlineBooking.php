<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH . 'handlers/event_handler.php');

class OfflineBooking extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $organizerId = $this->customsession->getUserId();
        if (!empty($organizerId)) {
            redirect(site_url() . "offlineBooking/booking");
        }
        $data['content'] = 'offline_booking/login';
        $this->load->view('templates/offline_booking_template', $data);
    }

    public function booking()
    {
        $organizerId = $this->customsession->getUserId();
        if (empty($organizerId)) {
            redirect(site_url() . "offlineBooking");
        }
        $eventList = $this->getEventsList($organizerId);
        if (empty($eventList)) {
            redirect("/");
        }
        $data['eventList'] = $eventList;
        $data['content'] = 'offline_booking/registration';
        $this->load->view('templates/offline_booking_template', $data);
    }

    public function searchAttendee()
    {
        $organizerId = $this->customsession->getUserId();
        $postArray = $this->input->post();
        $this->db->select('a.attendeeid');
        $this->db->from('attendeedetail a');
        $this->db->join('eventsignup b', 'a.attendeeid = b.attendeeid');
        $this->db->join('event c', 'b.eventid = c.id');
        $this->db->where('c.ownerid', $organizerId);
        $this->db->where("a.value like '%" . $postArray['search'] . "%'");
        $this->db->order_by('a.id', 'DESC');
        $this->db->limit(1);
        $data = $this->db->get();
        $attendee_data = array();
        $status = 0;
        if ($data->num_rows() > 0) {
            $attendeeid = $data->result_array();
            $this->db->select('b.fieldname, a.value');
            $this->db->from('attendeedetail a');
            $this->db->join('customfield b', 'a.customfieldid = b.id');
            $this->db->where('a.attendeeid', $attendeeid['0']['attendeeid']);
            $attendee_data = $this->db->get()->result_array();
            $status = 1;
        }
        $output['status'] = $status;
        $output['attendee_data'] = $attendee_data;
        echo json_encode($output, false);
    }

    private function getEventsList($userId)
    {
        $this->load->model('Event_model');
        $this->Event_model->resetVariable();
        $selectInput = $orderBy = $whereCondition = $upcomingEventList = array();
        $selectInput['eventId'] = $this->Event_model->id;
        $selectInput['eventName'] = $this->Event_model->title;
        $whereCondition[$this->Event_model->status] = 1;
        $whereCondition[$this->Event_model->deleted] = 0;
        $whereCondition[$this->Event_model->ownerid] = $userId;
        $whereCondition[$this->Event_model->enddatetime . " > "] = allTimeFormats('', 11);
        $this->Event_model->setSelect($selectInput);
        $this->Event_model->setWhere($whereCondition);
        return $this->Event_model->get();
    }

}

?>
