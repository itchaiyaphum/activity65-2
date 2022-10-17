<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headadvisor' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Headadvisorreport extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('base_homeroom_model');
        $this->load->model('headadvisor/headadvisorreport_model');
        $this->load->model('admin/homeroom_model', 'admin_homeroom_model');
        $this->load->model('admin/major_model', 'admin_major_model');
        $this->load->model('admin/semester_model', 'admin_semester_model');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headadvisor/menu', '', true);
        $data['items'] = $this->headadvisorreport_model->getApproving();
        $data['homerooms'] = $this->admin_homeroom_model->getItems(array(
            'status' => 1,
            'no_limit' => true,
            'orderby' => 'homerooms.week ASC'
        ));
        
        $data['filter_semester'] = $this->admin_semester_model->getItems(array(
            'status' => 1,
            'no_limit' => true
        ));
        $data['filter_major'] = $this->admin_major_model->getItems(array(
            'status' => 1,
            'no_limit' => true
        ));

        $data['profile'] = $this->profile_lib->getData();


        $this->load->view('nav', array('title'=>'/ หัวหน้างานครูที่ปรึกษา / รายงานการปฏิบัติหน้าที่กิจกรรมโฮมรูม'));
        $this->load->view('headadvisor/report/index', $data);
        $this->load->view('footer');
    }
    
}
