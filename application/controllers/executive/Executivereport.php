<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'executive' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Executivereport extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('base_homeroom_model');
        $this->load->model('executive/executivereport_model');
        $this->load->model('homeroomactivity_model');
        $this->load->model('homeroomobedience_model');
        $this->load->model('homeroomrisk_model');
        $this->load->model('homeroomconfirm_model');
        $this->load->model('admin/student_model');
        $this->load->model('admin/homeroom_model', 'admin_homeroom_model');
        $this->load->model('admin/major_model', 'admin_major_model');
        $this->load->model('admin/semester_model', 'admin_semester_model');
        $this->load->library('form_validation');
        $this->load->library('profile_lib');
        $this->load->library('homeroom_lib');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('executive/menu', '', true);
        $data['items'] = $this->executivereport_model->getApproving();
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


        $this->load->view('nav', array('title'=>'/ ผู้บริหาร / รายงานการปฏิบัติหน้าที่กิจกรรมโฮมรูม'));
        $this->load->view('executive/report/index', $data);
        $this->load->view('footer');
    }
    
}
