<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Time extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper(array(
            'form',
            'url'
        ));
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        
    }
    

    public function index()
    {
       
        $profile = $this->profile_lib->getData();
        
        $user_id = $this->input->get('user_id',$profile->user_id);
        
        $day = $this->input->get_post('day', 1);
        $week = $this->input->get_post('week', 1);
        
        $advisor_check_status = $this->input->get_post('advisor_check_status', 0);
        $trainer_confirm_status = $this->input->get_post('trainer_confirm_status', 0);
        
        $this->form_validation->set_rules('come_hour', 'เวลามา (ชั่วโมง)', 'trim|required|xss_clean');
        $this->form_validation->set_rules('come_minute', 'เวลามา (นาที)', 'trim|required|xss_clean');
        $this->form_validation->set_rules('back_hour', 'เวลากลับ (ชั่วโมง)', 'trim|required|xss_clean');
        $this->form_validation->set_rules('back_minute', 'เวลากลับ (นาที)', 'trim|required|xss_clean');
        $this->form_validation->set_rules('remark', 'หมายเหตุ', 'trim|xss_clean');
        $this->form_validation->set_rules('remark_text', 'อื่นๆ', 'trim|xss_clean');
        
        $data['errors'] = array();
        if ($this->form_validation->run()) { // validation ok
            if ($this->time_lib->save(array(
                'user_id' => $user_id,
                'advisor_check_status' => $advisor_check_status,
                'trainer_confirm_status' => $trainer_confirm_status,
                'day' => $day,
                'week' => $week,
                'come_hour' => $this->form_validation->set_value('come_hour'),
                'come_minute' => $this->form_validation->set_value('come_minute'),
                'back_hour' => $this->form_validation->set_value('back_hour'),
                'back_minute' => $this->form_validation->set_value('back_minute'),
                'remark' => $this->form_validation->set_value('remark'),
                'remark_text' => $this->form_validation->set_value('remark_text')
            ))) { // success
                redirect('preview/time/?user_id='.$user_id);
            } else { // fail
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v)
                    $data['errors'][$k] = $this->lang->line($v);
            }
        }
        
        $data = array();
        $data['items'] = $this->time_lib->getItems($user_id);
        $data['profile'] = $profile;
        $data['user_id'] = $user_id;
        
        $this->load->view('nav');
        $this->load->view('preview/time', $data);
        $this->load->view('footer');
         
    }
}
