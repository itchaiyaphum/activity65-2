<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Edulevel extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/edulevel_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->edulevel_model->getPagination();
        $data['items'] = $this->edulevel_model->getItems(array('limit'=>50));
        
        $this->load->view('nav');
        $this->load->view('admin/edulevel/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('name', 'ระดับการศึกษา', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {								// validation ok
            if ($this->edulevel_model->save()) {								// success
                redirect('/admin/edulevel/');
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->edulevel_model->getPagination();
        $data['item'] = $this->edulevel_model->getItem($id);
        
        $this->load->view('nav');
        $this->load->view('admin/edulevel/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->edulevel_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/edulevel/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->edulevel_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/edulevel/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->edulevel_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/edulevel/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->edulevel_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/edulevel/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->edulevel_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/edulevel/?per_page='.$per_page);
    }
}
