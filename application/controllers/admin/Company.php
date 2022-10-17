<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Company extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/company_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->company_model->getPagination();
        $data['items'] = $this->company_model->getItems(array('limit'=>50));
        
        $this->load->view('nav');
        $this->load->view('admin/company/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('name', 'สถานประกอบการ', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->company_model->save()) {
                redirect('/admin/company/');
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->company_model->getPagination();
        $data['item'] = $this->company_model->getItem($id);
        
        $this->load->view('nav');
        $this->load->view('admin/company/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->company_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/company/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->company_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/company/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->company_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/company/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->company_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/company/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->company_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/company/?per_page='.$per_page);
    }
}
