<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Minor extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/major_model');
        $this->load->model('admin/minor_model');
        $this->load->model('admin/adminusers_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->minor_model->getPagination();
        $data['major_items'] = $this->major_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['items'] = $this->minor_model->getItems(array('limit'=>50));
        
        $this->load->view('nav');
        $this->load->view('admin/minor/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('minor_name', 'สาขางาน', 'trim|required|xss_clean');
        $this->form_validation->set_rules('minor_eng', 'สาขางาน (English)', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->minor_model->save()) {
                redirect('/admin/minor/');
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->minor_model->getPagination();
        $data['item'] = $this->minor_model->getItem($id);
        $data['major_items'] = $this->major_model->getItems(array('status'=>'publish','no_limit'=>true));
        
        $this->load->view('nav');
        $this->load->view('admin/minor/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->minor_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/minor/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->minor_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/minor/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->minor_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/minor/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->minor_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/minor/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->minor_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/minor/?per_page='.$per_page);
    }
}
