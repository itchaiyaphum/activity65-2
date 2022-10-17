<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'executive' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Approving extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/homeroom_model');
        $this->load->model('executive/executiveapproving_model');
        $this->load->model('homeroomconfirm_model');
        $this->load->library('homeroom_lib');
        $this->load->library('profile_lib');
    }
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('executive/menu', '', true);
        $data['pagination'] = $this->homeroom_model->getPagination();
        $data['approvings'] = $this->executiveapproving_model->getApproving();
        $data['filter_weeks'] = $this->executiveapproving_model->getFilterWeeks();
        $data['filter_majors'] = $this->executiveapproving_model->getFilterMajors();
        $data['profile'] = $this->profile_lib->getData();

        $this->load->view('nav', array('title'=>'/ ผู้บริหาร / อนุมัติการส่งกิจกรรมโฮมรูม'));
        $this->load->view('executive/approving/index', $data);
        $this->load->view('footer');
    }

    public function confirm()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();
        
        $data = array();
        $data['leftmenu'] = $this->load->view('executive/menu', '', true);
        $data['homeroom'] = $this->executiveapproving_model->getConfirm($homeroom_id, $group_id);
        $data['profile'] = $this->profile_lib->getData();
        $data['homeroom_lib'] = $this->homeroom_lib;
        $data['group_id'] = $group_id;
        
        //TODO: log (action=viewed)
        // $this->executiveapproving_model->saveAction('viewed', $homeroom_id, $group_id, $advisor_id, 'headdepartment');

        $this->load->view('nav', array('title'=>'/ ผู้บริหาร / อนุมัติการส่งกิจกรรมโฮมรูม / ยืนยันการบันทึกข้อมูล'));
        $this->load->view('executive/approving/confirm', $data);
        $this->load->view('footer');
    }

    public function confirm_save()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        $this->executiveapproving_model->saveAction('confirmed', $homeroom_id, $group_id, $advisor_id, 'executive');
        redirect('/executive/approving/');
    }

    public function approve_all()
    {
        $this->executiveapproving_model->approve_all();
        redirect('/executive/approving/');
    }

    public function unapprove_all()
    {
        $this->executiveapproving_model->unapprove_all();
        redirect('/executive/approving/');
    }

    public function approve()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        $this->executiveapproving_model->saveAction('confirmed', $homeroom_id, $group_id, $advisor_id, 'executive');
        redirect('/executive/approving/');
    }

    public function unapprove()
    {
        $this->executiveapproving_model->unapprove();
        redirect('/executive/approving/');
    }

    public function remove_confirm()
    {
        $this->executiveapproving_model->remove_confirm();
        redirect('/executive/approving/');
    }
}
