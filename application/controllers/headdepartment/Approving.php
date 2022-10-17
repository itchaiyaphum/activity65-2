<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headdepartment' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Approving extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/homeroom_model');
        $this->load->model('headdepartment/headdepartmentapproving_model');
        $this->load->model('homeroomconfirm_model');
        $this->load->library('homeroom_lib');
        $this->load->library('profile_lib');
    }
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['pagination'] = $this->homeroom_model->getPagination();
        $data['homerooms'] = $this->headdepartmentapproving_model->getApproving();
        $data['profile'] = $this->profile_lib->getData();

        $this->load->view('nav', array('title'=>'/ หัวหน้าแผนก / รับรองบันทึกกิจกรรมโฮมรูม'));
        $this->load->view('headdepartment/approving/index', $data);
        $this->load->view('footer');
    }

    public function confirm()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();
        
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['homeroom'] = $this->headdepartmentapproving_model->getConfirm($homeroom_id, $group_id);
        $data['profile'] = $this->profile_lib->getData();
        $data['homeroom_lib'] = $this->homeroom_lib;
        $data['group_id'] = $group_id;
        
        //TODO: log (action=viewed)
        // $this->headdepartmentapproving_model->saveAction('viewed', $homeroom_id, $group_id, $advisor_id, 'headdepartment');

        $this->load->view('nav', array('title'=>'/ หัวหน้าแผนก / รับรองบันทึกกิจกรรมโฮมรูม / ยืนยันบันทึกข้อมูล'));
        $this->load->view('headdepartment/approving/confirm', $data);
        $this->load->view('footer');
    }

    public function confirm_save()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        $this->headdepartmentapproving_model->saveAction('confirmed', $homeroom_id, $group_id, $advisor_id, 'headdepartment');
        redirect('/headdepartment/approving/');
    }

    public function approve_all()
    {
        $this->headdepartmentapproving_model->approve_all();
        redirect('/headdepartment/approving/');
    }

    public function unapprove_all()
    {
        $this->headdepartmentapproving_model->unapprove_all();
        redirect('/headdepartment/approving/');
    }

    public function approve()
    {
        $this->headdepartmentapproving_model->approve();
        redirect('/headdepartment/approving/');
    }

    public function unapprove()
    {
        $this->headdepartmentapproving_model->unapprove();
        redirect('/headdepartment/approving/');
    }

    public function remove_confirm()
    {
        $this->headdepartmentapproving_model->remove_confirm();
        redirect('/headdepartment/approving/');
    }
}
