<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Province extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/province_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->province_model->getPagination();
        $data['items'] = $this->province_model->getItems(array('limit'=>50));
        
        $this->load->view('nav');
        $this->load->view('admin/province/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $id = $this->input->get_post('id', 0);
        
        $this->form_validation->set_rules('name', 'ชื่อจังหวัด', 'trim|required|xss_clean');
        if ($this->form_validation->run()) {								// validation ok
            if ($this->province_model->save()) {								// success
                redirect('/admin/province/');
            }
        }
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->province_model->getPagination();
        $data['item'] = $this->province_model->getItem($id);
        
        $this->load->view('nav');
        $this->load->view('admin/province/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $per_page = $this->input->get_post('per_page', 1);
        $this->province_model->publish($id);
        redirect('admin/province/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $per_page = $this->input->get_post('per_page', 1);
        $this->province_model->unpublish($id);
        redirect('admin/province/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $per_page = $this->input->get_post('per_page', 1);
        $this->province_model->trash($id);
        redirect('admin/province/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $per_page = $this->input->get_post('per_page', 1);
        $this->province_model->delete($id);
        redirect('admin/province/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $per_page = $this->input->get_post('per_page', 1);
        $this->province_model->restore($id);
        redirect('admin/province/?per_page='.$per_page);
    }
}
