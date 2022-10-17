<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headdepartment' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Summaryhomeroom extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('summaryhomeroom_model', 'summary');
    }

    public function index()
    {
        $data['data'] = $this->summary->index($this->session->user_id);

        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $this->load->view('nav', array('title' => '/ หัวหน้าแผนก / สรุปผลเข้าร่วมกิจกรรมโฮมรูม'));
        $this->load->view('headdepartment/homeroom/summaryhomeroom', $data);
        $this->load->view('footer');
    }

    public function report()
    {
        $data['data'] = $this->summary->report(
            $this->input->get('id'),
            $this->input->get('semester') 
        );
        $this->load->view('advisor/homeroom/summaryhomeroom_report', $data);
    }
}
