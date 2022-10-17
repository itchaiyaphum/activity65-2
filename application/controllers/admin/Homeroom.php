<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Homeroom extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/semester_model');
        $this->load->model('admin/homeroom_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->homeroom_model->getPagination();
        $data['items'] = $this->homeroom_model->getItems(array('limit'=>50));
        
        $this->load->view('nav');
        $this->load->view('admin/homeroom/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('week', 'สัปดาห์', 'trim|required|xss_clean');
//         $this->form_validation->set_rules('join_start', 'วันที่เริ่มต้นทำกิจกรรมโฮมรูม', 'trim|required|xss_clean');
//         $this->form_validation->set_rules('join_end', 'วันที่สิ้นสุดทำกิจกรรมโฮมรูม', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->homeroom_model->save()) {
                redirect('/admin/homeroom/');
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->homeroom_model->getPagination();
        $data['item'] = $this->homeroom_model->getItem($id);
        $data['semester_items'] = $this->semester_model->getItems(array('status'=>'publish'));
        
        $this->load->view('nav');
        $this->load->view('admin/homeroom/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->homeroom_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/homeroom/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->homeroom_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/homeroom/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->homeroom_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/homeroom/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->homeroom_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/homeroom/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->homeroom_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/homeroom/?per_page='.$per_page);
    }
}
