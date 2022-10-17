<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Importdata extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/importdata_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('data_type', 'รูปแบบข้อมูล', 'trim|required|xss_clean', array('required' => 'กรุณาเลือกรูปแบบข้อมูล'));
        $this->form_validation->set_rules('csv_data', 'ข้อมูล CSV Text', 'trim|required|xss_clean', array('required' => 'กรุณากรอกข้อมูล CSV Text'));
        
        $data = array();
        $data['errors'] = array();
        if ($this->form_validation->run()) {
            if ($this->importdata_model->saveData()) {
                $data['errors']['global'] = "นำเข้าข้อมูลเรียบร้อยแล้ว!";
            } else {
                $data['errors']['global'] = "ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบการกรอกข้อมูลและลองใหม่อีกครั้ง!";
            }
        }

        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        
        $this->load->view('nav');
        $this->load->view('admin/importdata/index', $data);
        $this->load->view('footer');
    }

    public function autogen_advisor()
    {
        $this->importdata_model->autogenAdvisor();
        redirect('admin/importdata');
    }

    public function autogen_student()
    {
        $this->importdata_model->autogenStudent();
        redirect('admin/importdata');
    }
}
