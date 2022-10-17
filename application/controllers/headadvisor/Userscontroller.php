<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headadvisor' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Userscontroller extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('headadvisor/headadvisorusers_model');
        $this->load->model('admin/college_model');
        $this->load->model('admin/major_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headadvisor/menu', '', true);
        $data['pagination'] = $this->headadvisorusers_model->getPagination();
        $data['items'] = $this->headadvisorusers_model->getItems(array('limit'=>50));
        $data['college_items'] = $this->college_model->getItems(array('status'=>1));
        
        $this->load->view('nav', array('title'=>'/ หัวหน้างานครูที่ปรึกษา / จัดการครูที่ปรึกษา'));
        $this->load->view('headadvisor/users/index', $data);
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
            if ($this->input->post('id')=='' && $this->headadvisorusers_model->checkEmailExists($this->input->post('email'))) {
                $data['errors']['email'] = "มีอีเมล์นี้อยู่ในระบบแล้ว!";
            } else {
                if ($this->headadvisorusers_model->saveData()) {
                    redirect('/headadvisor/users/');
                } else {
                    $data['errors']['global'] = "ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบการกรอกข้อมูลและลองใหม่อีกครั้ง!";
                }
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data['leftmenu'] = $this->load->view('headadvisor/menu', '', true);
        $data['pagination'] = $this->headadvisorusers_model->getPagination();
        $data['item'] = $this->headadvisorusers_model->getItem($id);
        $data['item_profile'] = $this->headadvisorusers_model->getProfileItem($id);
        $data['college_items'] = $this->college_model->getItems(array('status'=>1,'no_limit' => true));
        $data['major_items'] = $this->major_model->getItems(array('status'=>1,'no_limit' => true));
        
        $this->load->view('nav', array('title'=>'/ หัวหน้างานครูที่ปรึกษา / จัดการครูที่ปรึกษา / (เพิ่ม/แก้ไข)'));
        $this->load->view('headadvisor/users/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->headadvisorusers_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/users/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->headadvisorusers_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/users/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->headadvisorusers_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/users/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->headadvisorusers_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/users/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->headadvisorusers_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/users/?per_page='.$per_page);
    }
}
