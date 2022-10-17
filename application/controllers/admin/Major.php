<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Major extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/major_model');
        $this->load->model('admin/college_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->major_model->getPagination();
        $data['items'] = $this->major_model->getItems(array('limit'=>50));
        
        $this->load->view('nav');
        $this->load->view('admin/major/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('major_name', 'สาขาวิชา', 'trim|required|xss_clean');
        $this->form_validation->set_rules('major_eng', 'สาขาวิชา (English)', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->major_model->save()) {
                redirect('/admin/major/');
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->major_model->getPagination();
        $data['item'] = $this->major_model->getItem($id);
        $data['college_items'] = $this->college_model->getItems(array('status'=>1,'no_limit'=>true));
        
        $this->load->view('nav');
        $this->load->view('admin/major/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->major_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/major/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->major_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/major/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->major_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/major/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->major_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/major/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->major_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/major/?per_page='.$per_page);
    }
}
