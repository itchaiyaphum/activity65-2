<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Course extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/course_model');
        $this->load->model('admin/advisor_model');
        $this->load->model('admin/semester_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->course_model->getPagination();
        $data['items'] = $this->course_model->getItems(array('limit'=>50));
        $data['semester_items'] = $this->semester_model->getItems(array('status'=>'publish'));
        
        $this->load->view('nav');
        $this->load->view('admin/course/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('name', 'รายวิชา', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->course_model->save()) {
                redirect('/admin/course/');
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->course_model->getPagination();
        $data['item'] = $this->course_model->getItem($id);
        $data['advisor_items'] = $this->advisor_model->getItems(array('status'=>'publish'));
        $data['semester_items'] = $this->semester_model->getItems(array('status'=>'publish'));
        
        $this->load->view('nav');
        $this->load->view('admin/course/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->course_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/course/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->course_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/course/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->course_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/course/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->course_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/course/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->course_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/course/?per_page='.$per_page);
    }
}
