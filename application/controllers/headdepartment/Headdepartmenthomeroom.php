<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headdepartment' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Headdepartmenthomeroom extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('base_homeroom_model');
        $this->load->model('homeroomactivity_model');
        $this->load->model('homeroomobedience_model');
        $this->load->model('homeroomrisk_model');
        $this->load->model('homeroomconfirm_model');
        $this->load->model('admin/student_model');
        $this->load->library('form_validation');
        $this->load->library('profile_lib');
        $this->load->library('homeroom_lib');
    }

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['homeroom_items'] = $this->base_homeroom_model->getItems(array('limit'=>50));

        $this->load->view('nav', array('title'=>'/ หัวหน้าแผนก / บันทึกกิจกรรมโฮมรูม'));
        $this->load->view('headdepartment/homeroom/index', $data);
        $this->load->view('footer');
    }
    
    public function activity()
    {
        $id = $this->input->get_post('id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['homeroom'] = $this->homeroomactivity_model->getActivities($id, $group_id);
        $data['group_id'] = $group_id;
        
        $this->load->view('nav', array('title'=>'/ หัวหน้าแผนก / บันทึกกิจกรรมโฮมรูม / step1: เช็คชื่อ'));
        $this->load->view('headdepartment/homeroom/activity', $data);
        $this->load->view('footer');
    }
    
    public function activity_save()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        $data = $this->input->post();
        $data['advisor_id'] = $advisor_id;

        $this->homeroomactivity_model->save($data);
        $this->homeroomactivity_model->saveItems();
        $this->homeroom_lib->saveAction('saving', $homeroom_id, $group_id, $advisor_id);
        redirect('/headdepartment/homeroom/obedience/?id='.$homeroom_id.'&group_id='.$group_id);
    }
    
    public function obedience()
    {
        $homeroom_id = $this->input->get_post('id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        $this->form_validation->set_rules('obe_detail', 'เรื่องที่ให้คำแนะนำ นักเรียน นักศึกษา', 'trim|required|xss_clean', array('required' => 'กรุณากรอกข้อมูล เรื่องที่ให้คำแนะนำ นักเรียน นักศึกษา'));
        $this->form_validation->set_rules('survey_amount', 'จำนวนผู้ตอบแบบสอบถาม', 'trim|required|xss_clean|integer', array('required' => 'กรุณากรอกข้อมูล จำนวนผู้ตอบแบบสอบถาม'));
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $data['advisor_id'] = $advisor_id;
            $this->homeroomobedience_model->saveData($data);
            redirect('/headdepartment/homeroom/risk/?id='.$homeroom_id.'&group_id='.$group_id);
        }
        
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['homeroom'] = $this->homeroomobedience_model->getObediences($homeroom_id, $group_id);
        $data['group_id'] = $group_id;
        
        $this->load->view('nav', array('title'=>'/ หัวหน้าแผนก / บันทึกกิจกรรมโฮมรูม / step2: ให้โอวาท'));
        $this->load->view('headdepartment/homeroom/obedience', $data);
        $this->load->view('footer');
    }
    
    public function risk()
    {
        $homeroom_id = $this->input->get_post('id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['homeroom'] = $this->homeroomrisk_model->getRisks($homeroom_id, $group_id);
        $data['group_id'] = $group_id;
        
        $this->load->view('nav', array('title'=>'/ หัวหน้าแผนก / บันทึกกิจกรรมโฮมรูม / step3: ประเมินความเสี่ยง'));
        $this->load->view('headdepartment/homeroom/risk', $data);
        $this->load->view('footer');
    }
    
    public function risk_save()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        $data = $this->input->post();
        $data['advisor_id'] = $advisor_id;

        $this->homeroomrisk_model->save($data);
        $this->homeroomrisk_model->saveItems();
        redirect('/headdepartment/homeroom/confirm/?id='.$homeroom_id.'&group_id='.$group_id);
    }
    
    public function confirm()
    {
        $homeroom_id = $this->input->get_post('id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        $data['homeroom'] = $this->homeroomconfirm_model->getConfirm($homeroom_id, $group_id);
        $data['profile'] = $this->profile_lib->getData();
        $data['homeroom_lib'] = $this->homeroom_lib;
        $data['group_id'] = $group_id;
        
        $this->load->view('nav', array('title'=>'/ หัวหน้าแผนก / บันทึกกิจกรรมโฮมรูม / step4: ยืนยันข้อมูล'));
        $this->load->view('headdepartment/homeroom/confirm', $data);
        $this->load->view('footer');
    }

    public function confirm_save()
    {
        $homeroom_id = $this->input->get_post('homeroom_id', 0);
        $group_id = $this->input->get_post('group_id', 0);
        $advisor_id = $this->profile_lib->getUserId();

        // $this->homeroomconfirm_model->saveData();
        $this->homeroom_lib->saveAction('confirmed', $homeroom_id, $group_id, $advisor_id);
        redirect('/headdepartment/homeroom/');
    }
}
