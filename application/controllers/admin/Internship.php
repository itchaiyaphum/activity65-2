<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Internship extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/internship_model');
        $this->load->model('admin/edulevel_model');
        $this->load->model('admin/college_model');
        $this->load->model('admin/semester_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->internship_model->getPagination();
        $data['items'] = $this->internship_model->getItems();
        $data['semester_items'] = $this->semester_model->getItems(array('status'=>'publish'));
        
        $this->load->view('nav');
        $this->load->view('admin/internship/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('title', 'ชื่อหัวข้อการฝึกงาน', 'trim|required|xss_clean');
        $this->form_validation->set_rules('internship_start', 'วันที่เริ่มต้นการฝึกงาน', 'trim|required|xss_clean');
        $this->form_validation->set_rules('internship_end', 'วันที่สิ้นสุดการฝึกงาน', 'trim|required|xss_clean');
        $this->form_validation->set_rules('num_weeks', 'จำนวนสัปดาห์การฝึกงาน', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->internship_model->save()) {
                redirect('/admin/internship/');
            }
        }
            
        $id = $this->input->get_post('id',0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->internship_model->getPagination();
        $data['item'] = $this->internship_model->getItem($id);
        $data['edulevel_items'] = $this->edulevel_model->getItems(array('status'=>'publish'));
        $data['college_items'] = $this->college_model->getItems(array('status'=>'publish'));
        $data['semester_items'] = $this->semester_model->getItems(array('status'=>'publish'));
        
        $this->load->view('nav');
        $this->load->view('admin/internship/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id',0);
        $this->internship_model->publish($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/internship/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id',0);
        $this->internship_model->unpublish($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/internship/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id',0);
        $this->internship_model->trash($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/internship/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id',0);
        $this->internship_model->delete($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/internship/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id',0);
        $this->internship_model->restore($id);
        $per_page = $this->input->get_post('per_page',1);
        redirect('admin/internship/?per_page='.$per_page);
    }
}
