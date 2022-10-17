<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Userstudent extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/userstudent_model');
        $this->load->model('admin/major_model');
        $this->load->model('admin/minor_model');
        $this->load->model('admin/group_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->userstudent_model->getPagination();
        $data['items'] = $this->userstudent_model->getItems(array('limit'=>50,'orderby'=>'users_student.student_id ASC'));
        $data['major_items'] = $this->major_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['minor_items'] = $this->minor_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['group_items'] = $this->group_model->getItems(array('status'=>'publish', 'no_limit' => true));
        
        $this->load->view('nav');
        $this->load->view('admin/userstudent/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->form_validation->set_rules('student_id', 'รหัสนักเรียน', 'trim|required|xss_clean');
        $this->form_validation->set_rules('group_id', 'กลุ่มการเรียน', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        
        $data = array();
        
        $data['errors'] = array();
        if ($this->form_validation->run()) {
            if ($this->input->post('id')=='' && $this->userstudent_model->checkEmailExists($this->input->post('email'))) {
                $data['errors']['email'] = "มีอีเมล์นี้อยู่ในระบบแล้ว!";
            } else {
                if ($this->userstudent_model->save()) {
                    redirect('/admin/userstudent/');
                } else {
                    $data['errors']['global'] = "ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบการกรอกข้อมูลและลองใหม่อีกครั้ง!";
                }
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->userstudent_model->getPagination();
        $data['item'] = $this->userstudent_model->getItem($id);

        $data['major_items'] = $this->major_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['minor_items'] = $this->minor_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['group_items'] = $this->group_model->getItems(array('status'=>'publish', 'no_limit' => true));
        
        $this->load->view('nav');
        $this->load->view('admin/userstudent/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->userstudent_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/userstudent/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->userstudent_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/userstudent/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->userstudent_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/userstudent/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->userstudent_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/userstudent/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->userstudent_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/userstudent/?per_page='.$per_page);
    }
}
