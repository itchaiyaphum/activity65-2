<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Group extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/major_model');
        $this->load->model('admin/minor_model');
        $this->load->model('admin/group_model');
        $this->load->model('admin/adminusers_model');
        $this->load->library('form_validation');
        $this->load->library('helper_lib');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->group_model->getPagination();
        $data['items'] = $this->group_model->getItems(array('limit'=>50));
        $data['major_items'] = $this->major_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['minor_items'] = $this->minor_model->getItems(array('status'=>'publish', 'no_limit' => true));
        $data['helper_lib'] = $this->helper_lib;

        $this->load->view('nav');
        $this->load->view('admin/group/index', $data);
        $this->load->view('footer');
    }
    
    public function edit()
    {
        $this->form_validation->set_rules('group_name', 'กลุ่มการเรียน', 'trim|required|xss_clean');
        
        if ($this->form_validation->run()) {
            if ($this->group_model->save()) {
                redirect('/admin/group/');
            }
        }
            
        $id = $this->input->get_post('id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        $data['pagination'] = $this->group_model->getPagination();
        $data['item'] = $this->group_model->getItem($id);
        $data['major_items'] = $this->major_model->getItems(array('status'=>'publish','no_limit'=>true));
        $data['minor_items'] = $this->minor_model->getItems(array('status'=>'publish','no_limit'=>true));
        
        $sql = "SELECT * FROM users WHERE user_type='advisor' AND activated=1 ";
        $data['advisor_items'] = $this->adminusers_model->getItemsCustom($sql);
        
        $this->load->view('nav');
        $this->load->view('admin/group/form', $data);
        $this->load->view('footer');
    }
    
    public function publish()
    {
        $id = $this->input->get_post('id', 0);
        $this->group_model->publish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/group/?per_page='.$per_page);
    }
    public function unpublish()
    {
        $id = $this->input->get_post('id', 0);
        $this->group_model->unpublish($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/group/?per_page='.$per_page);
    }
    public function trash()
    {
        $id = $this->input->get_post('id', 0);
        $this->group_model->trash($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/group/?per_page='.$per_page);
    }
    public function delete()
    {
        $id = $this->input->get_post('id', 0);
        $this->group_model->delete($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/group/?per_page='.$per_page);
    }
    public function restore()
    {
        $id = $this->input->get_post('id', 0);
        $this->group_model->restore($id);
        $per_page = $this->input->get_post('per_page', 1);
        redirect('admin/group/?per_page='.$per_page);
    }
}
