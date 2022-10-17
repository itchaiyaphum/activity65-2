<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headadvisor' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Approving extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('admin/homeroom_model');
        $this->load->model('headadvisor/headadvisorapproving_model');
        $this->load->model('homeroomconfirm_model');
        $this->load->library('homeroom_lib');
        $this->load->library('profile_lib');
    }
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headadvisor/menu', '', true);
        $data['pagination'] = $this->homeroom_model->getPagination();
        $data['approvings'] = $this->headadvisorapproving_model->getApproving();
        $data['filter_weeks'] = $this->headadvisorapproving_model->getFilterWeeks();
        $data['filter_majors'] = $this->headadvisorapproving_model->getFilterMajors();
        $data['profile'] = $this->profile_lib->getData();

        $this->load->view('nav', array('title'=>'/ หัวหน้างานครูที่ปรึกษา / อนุมัติการบันทึกกิจกรรมโฮมรูม'));
        $this->load->view('headadvisor/approving/index', $data);
        $this->load->view('footer');
    }

    public function confirm()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();
        
        $data = array();
        $data['leftmenu'] = $this->load->view('headadvisor/menu', '', true);
        $data['homeroom'] = $this->headadvisorapproving_model->getConfirm($homeroom_id, $group_id);
        $data['profile'] = $this->profile_lib->getData();
        $data['homeroom_lib'] = $this->homeroom_lib;
        $data['group_id'] = $group_id;
        
        //TODO: log (action=viewed)
        // $this->headadvisorapproving_model->saveAction('viewed', $homeroom_id, $group_id, $advisor_id, 'headdepartment');

        $this->load->view('nav', array('title'=>'/ หัวหน้างานครูที่ปรึกษา / อนุมัติการบันทึกกิจกรรมโฮมรูม / ยืนยันการบันทึกข้อมูล'));
        $this->load->view('headadvisor/approving/confirm', $data);
        $this->load->view('footer');
    }

    public function confirm_save()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        $this->headadvisorapproving_model->saveAction('confirmed', $homeroom_id, $group_id, $advisor_id, 'headadvisor');
        redirect('/headadvisor/approving/');
    }

    public function approve_all()
    {
        $this->headadvisorapproving_model->approve_all();
        redirect('/headadvisor/approving/');
    }

    public function unapprove_all()
    {
        $this->headadvisorapproving_model->unapprove_all();
        redirect('/headadvisor/approving/');
    }

    public function approve()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        $this->headadvisorapproving_model->saveAction('confirmed', $homeroom_id, $group_id, $advisor_id, 'headadvisor');
        redirect('/headadvisor/approving/');
    }

    public function unapprove()
    {
        $this->headadvisorapproving_model->unapprove();
        redirect('/headadvisor/approving/');
    }

    public function remove_confirm()
    {
        $this->headadvisorapproving_model->remove_confirm();
        redirect('/headadvisor/approving/');
    }
}
