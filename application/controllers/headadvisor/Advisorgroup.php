<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headadvisor' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Advisorgroup extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/advisor_model');
        $this->load->model('admin/group_model');
        $this->load->model('admin/major_model');
        $this->load->model('admin/minor_model');
        $this->load->model('admin/advisorgroup_model');
        $this->load->model('admin/adminusers_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headadvisor/menu', '', true);
        $data['pagination'] = $this->advisorgroup_model->getPagination();
        $data['items'] = $this->advisorgroup_model->getItems(array('limit'=>50));
        $data['major_items'] = $this->major_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['minor_items'] = $this->minor_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['group_items'] = $this->group_model->getItems(array('status'=>'publish', 'no_limit' => true));
        
        $this->load->view('nav', array('title'=>'/ หัวหน้างานครูที่ปรึกษา / จัดการครูที่ปรึกษาประจำกลุ่ม'));
        $this->load->view('headadvisor/advisorgroup/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('advisor_id', 'ครูที่ปรึกษา', 'trim|required|xss_clean');
        $this->form_validation->set_rules('group_id', 'กลุ่มการเรียน', 'trim|required|xss_clean');
        $this->form_validation->set_rules('advisor_type', 'ประเภทครูที่ปรึกษา', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->advisorgroup_model->save()) {
                redirect('/headadvisor/advisorgroup/');
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('headadvisor/menu', '', true);
        $data['pagination'] = $this->advisorgroup_model->getPagination();
        $data['item'] = $this->advisorgroup_model->getItem($id);
        $data['major_items'] = $this->major_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['minor_items'] = $this->minor_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['group_items'] = $this->group_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['advisor_items'] = $this->advisor_model->getItems(array('status'=>'publish', 'no_limit' => true));
        
        $this->load->view('nav', array('title'=>'/ หัวหน้างานครูที่ปรึกษา / จัดการครูที่ปรึกษาประจำกลุ่ม / (เพิ่ม/แก้ไข)'));
        $this->load->view('headadvisor/advisorgroup/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->advisorgroup_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/advisorgroup/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->advisorgroup_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/advisorgroup/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->advisorgroup_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/advisorgroup/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->advisorgroup_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/advisorgroup/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->advisorgroup_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('headadvisor/advisorgroup/?per_page='.$per_page);
    }
}
