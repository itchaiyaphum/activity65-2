<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headdepartment' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Advisor extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('headdepartment/headdepartmentadvisor_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['pagination'] = $this->headdepartmentadvisor_model->getPagination();
        $data['items'] = $this->headdepartmentadvisor_model->getItems(array('limit'=>50));
        
        $this->load->view('nav');
        $this->load->view('headdepartment/advisor/index', $data);
        $this->load->view('footer');
    }

    public function edit()
    {
        $this->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_type', 'ประเภทผู้ใช้', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        
        $data = array();
        
        $data['errors'] = array();
        if ($this->form_validation->run()) {
            if ($this->input->post('id')=='' && $this->headdepartmentadvisor_model->checkEmailExists($this->input->post('email'))) {
                $data['errors']['email'] = "มีอีเมล์นี้อยู่ในระบบแล้ว!";
            } else {
                if ($this->headdepartmentadvisor_model->save()) {
                    redirect('/headdepartment/advisor/');
                } else {
                    $data['errors']['global'] = "ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบการกรอกข้อมูลและลองใหม่อีกครั้ง!";
                }
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['pagination'] = $this->headdepartmentadvisor_model->getPagination();
        $data['item'] = $this->headdepartmentadvisor_model->getItem($id);
        
        $this->load->view('nav');
        $this->load->view('headdepartment/advisor/form', $data);
        $this->load->view('footer');
    }

    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->headdepartmentadvisor_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headdepartment/advisor/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->headdepartmentadvisor_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headdepartment/advisor/?per_page='.$per_page);
    }
}
