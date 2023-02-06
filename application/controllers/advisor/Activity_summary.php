<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'advisor' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Activity_summary extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('activity_summary_model', 'activity_summary');
    }
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('advisor/menu', '', true);
        $data['data'] = $this->activity_summary->index($this->session->user_id);

        $this->load->view('nav', array('title'=>'/ ครูที่ปรึกษา / แบบสรุปการประเมินผลกิจกรรมชมรมวิชาชีพ'));
        $this->load->view('advisor/activity/index', $data);
        $this->load->view('footer');
    }
    public function activity()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('advisor/menu', '', true);
        $data['group'] = $this->activity_summary->activity(
            $this->input->get('group_id'),
            $this->input->get('semester_id')
        );
        $data['semester'] = $this->activity_summary->SemesterData($this->input->get('semester_id'));

        $this->load->view('nav', array('title'=>'/ ครูที่ปรึกษา / บันทึกการประเมินผลกิจกรรมชมรมวิชาชีพ'));
        $this->load->view('advisor/activity/activity', $data);
        $this->load->view('footer');
    }
    public function advisor_save()
    {

        $this->activity_summary->advisor_save();
        redirect('advisor/activity_summary');
    }
    public function report()
    {
        $data['data'] = $this->activity_summary->AdvisorPrint(
            $this->input->get('group_id'),
            $this->input->get('semester_id')
        );
        $this->load->view('advisor/activity/activity_print', $data);
    }
}