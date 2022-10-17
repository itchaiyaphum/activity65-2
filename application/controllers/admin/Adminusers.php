<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Adminusers extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/adminusers_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->adminusers_model->getPagination();
        $data['items'] = $this->adminusers_model->getItems(array('limit'=>50));

        $this->load->view('nav');
        $this->load->view('admin/users/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $confirm_password = $this->input->post('confirm_password');

        $this->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_type', 'ประเภทผู้ใช้', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        
        $this->form_validation->set_rules('new_password', 'รหัสผ่าน', 'trim|min_length[6]|max_length[30]|xss_clean|matches[confirm_password]');
        if (!empty($confirm_password)) {
            $this->form_validation->set_rules('confirm_password', 'ยืนยันรหัสผ่านใหม่', 'trim|min_length[6]|max_length[30]|xss_clean|matches[new_password]');
        }
        
        $data = array();
        
        $data['errors'] = array();
        if ($this->form_validation->run()) {
            if ($this->input->post('id')=='' && $this->adminusers_model->checkEmailExists($this->input->post('email'))) {
                $data['errors']['email'] = "มีอีเมล์นี้อยู่ในระบบแล้ว!";
            } else {
                if ($this->adminusers_model->save()) {
                    redirect('/admin/users/');
                } else {
                    $data['errors']['global'] = "ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบการกรอกข้อมูลและลองใหม่อีกครั้ง!";
                }
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->adminusers_model->getPagination();
        $data['item'] = $this->adminusers_model->getItem($id);
        
        $this->load->view('nav');
        $this->load->view('admin/users/form', $data);
        $this->load->view('footer');
    }

    public function bypass()
    {
        $user_id = $this->input->get_post('id', 0);
        $this->adminusers_model->bypass_login($user_id);
        redirect('/');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->adminusers_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/users/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->adminusers_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/users/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->adminusers_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/users/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->adminusers_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/users/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->adminusers_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/users/?per_page='.$per_page);
    }
}
