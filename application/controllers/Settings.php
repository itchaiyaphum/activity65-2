<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    
        $this->load->helper(array('form', 'url'));
        $this->load->model('settings_model');
        $this->load->model('admin/college_model');
        $this->load->model('admin/major_model');
        $this->load->model('admin/department_model');
        $this->load->model('admin/internship_model');
        $this->load->model('admin/company_model');
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
    }
    
    public function index()
    {
        redirect('settings/profile');
    }

    private function profileStudent($input_data=null)
    {
        $profile = $this->profile_lib->getData();
        if (is_null($input_data)) {
            $input_data = $this->input->post();
        }
        $input_data['user_id'] = $profile->user_id;

        $data = array();
        
        if ($this->settings_model->validateStudent()) {
            if ($this->profile_lib->saveStudent($input_data)) {
                $data['messages'] = 'บันทึกข้อมูลเรียบร้อบ';
                redirect('settings/profile');
            } else {
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v) {
                    $data['errors'][$k] = $this->lang->line($v);
                }
            }
        }
                
        $data['college_items'] = $this->college_model->getItems(array('status'=>1,'no_limit'=>true));
        $data['major_items'] = $this->major_model->getItems(array('status'=>1,'no_limit'=>true));
                
        $this->load->view('nav', array('title'=>'/ จัดการข้อมูลส่วนตัว / นักเรียน'));
        $this->load->view('settings/profile_student', $data);
        $this->load->view('footer');
    }

    private function profileAdvisor($input_data=null)
    {
        $this->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');

        $profile = $this->profile_lib->getData();
        if (is_null($input_data)) {
            $input_data = $this->input->post();
        }
        $input_data['user_id'] = $profile->user_id;

        $data = array();

        if ($this->form_validation->run()) {
            if ($this->profile_lib->saveAdvisor($input_data)) {
                $data['messages'] = "<div class='uk-alert uk-alert-success'>บันทึกข้อมูลเรียบร้อยแล้ว...</div>";
            } else {
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v) {
                    $data['errors'][$k] = $this->lang->line($v);
                }
            }
        }
                
        $this->load->view('nav', array('title'=>'/ จัดการข้อมูลส่วนตัว / ครูที่ปรึกษา'));
        $this->load->view('settings/profile_advisor', $data);
        $this->load->view('footer');
    }

    private function profileHeadAdvisor($input_data=null)
    {
        $profile = $this->profile_lib->getData();
        if (is_null($input_data)) {
            $input_data = $this->input->post();
        }
        $input_data['user_id'] = $profile->user_id;

        $data = array();

        if ($this->settings_model->validateHeadAdvisor()) {
            if ($this->profile_lib->saveHeadAdvisor($input_data)) {
                $data['messages'] = 'บันทึกข้อมูลเรียบร้อบ';
                redirect('settings/profile');
            } else {
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v) {
                    $data['errors'][$k] = $this->lang->line($v);
                }
            }
        }
                
        $data['college_items'] = $this->college_model->getItems(array('status'=>1,'no_limit' => true));
                
        $this->load->view('nav', array('title'=>'/ จัดการข้อมูลส่วนตัว / หัวหน้างานครูที่ปรึกษา'));
        $this->load->view('settings/profile_headadvisor', $data);
        $this->load->view('footer');
    }

    private function profileStaff($input_data=null)
    {
        $profile = $this->profile_lib->getData();
        if (is_null($input_data)) {
            $input_data = $this->input->post();
        }
        $input_data['user_id'] = $profile->user_id;

        $data = array();

        if ($this->settings_model->validateStaff()) {
            if ($this->profile_lib->saveStaff($input_data)) {
                $data['messages'] = 'บันทึกข้อมูลเรียบร้อบ';
                redirect('settings/profile');
            } else {
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v) {
                    $data['errors'][$k] = $this->lang->line($v);
                }
            }
        }
                
        $data['college_items'] = $this->college_model->getItems(array('status'=>1,'no_limit' => true));
                
        $this->load->view('nav', array('title'=>'/ จัดการข้อมูลส่วนตัว / เจ้าหน้าที่งานครูที่ปรึกษา'));
        $this->load->view('settings/profile_staff', $data);
        $this->load->view('footer');
    }

    private function profileHeadDepartment($input_data=null)
    {
        $profile = $this->profile_lib->getData();
        if (is_null($input_data)) {
            $input_data = $this->input->post();
        }
        $input_data['user_id'] = $profile->user_id;

        $data = array();

        if ($this->settings_model->validateHeadDepartment()) {
            if ($this->profile_lib->saveHeadDepartment($input_data)) {
                $data['messages'] = 'บันทึกข้อมูลเรียบร้อบ';
                redirect('settings/profile');
            } else {
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v) {
                    $data['errors'][$k] = $this->lang->line($v);
                }
            }
        }
            
        $data['college_items'] = $this->college_model->getItems(array('status'=>1,'no_limit' => true));
        $data['major_items'] = $this->major_model->getItems(array('status'=>1,'no_limit' => true));
            
        $this->load->view('nav', array('title'=>'/ จัดการข้อมูลส่วนตัว / หัวหน้าแผนก'));
        $this->load->view('settings/profile_headdepartment', $data);
        $this->load->view('footer');
    }

    private function profileExecutive($input_data=null)
    {
        $profile = $this->profile_lib->getData();
        if (is_null($input_data)) {
            $input_data = $this->input->post();
        }
        $input_data['user_id'] = $profile->user_id;

        $data = array();

        if ($this->settings_model->validateExecutive()) {
            if ($this->profile_lib->saveExecutive($input_data)) {
                $data['messages'] = 'บันทึกข้อมูลเรียบร้อบ';
                redirect('settings/profile');
            } else {
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v) {
                    $data['errors'][$k] = $this->lang->line($v);
                }
            }
        }
            
        $data['college_items'] = $this->college_model->getItems(array('status'=>1,'no_limit' => true));
            
        $this->load->view('nav', array('title'=>'/ จัดการข้อมูลส่วนตัว / ผู้บริหาร'));
        $this->load->view('settings/profile_executive', $data);
        $this->load->view('footer');
    }

    public function profile()
    {
        if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
            redirect('/auth/login/');
        } else {
            $profile = $this->profile_lib->getData();
            $data['errors'] = array();
            $input_data = $this->input->post();
            
            if ($profile->user_type=="student") {
                $this->profileStudent($input_data);
            } elseif ($profile->user_type=="advisor") {
                $this->profileAdvisor($input_data);
            } elseif ($profile->user_type=="headadvisor") {
                $this->profileHeadAdvisor($input_data);
            } elseif ($profile->user_type=="staff") {
                $this->profileStaff($input_data);
            } elseif ($profile->user_type=="headdepartment") {
                $this->profileHeadDepartment($input_data);
            } elseif ($profile->user_type=="executive") {
                $this->profileExecutive($input_data);
            } else {
                $this->load->view('nav', array('title'=>'/ จัดการข้อมูลส่วนตัว / เกิดข้อผิดพลาด'));
                echo "no this user_type on this platform! please contact administrator!";
                $this->load->view('footer');
            }
        }
    }

    public function password()
    {
        if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
            redirect('/auth/login/');
        } else {
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
            $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

            $data['errors'] = array();

            if ($this->form_validation->run()) {								// validation ok
                if ($this->tank_auth->change_password(
                    $this->form_validation->set_value('old_password'),
                    $this->form_validation->set_value('new_password')
                )) {	// success
                    $data['messages'] = $this->lang->line('auth_message_password_changed');
                } else {														// fail
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) {
                        $data['errors'][$k] = $this->lang->line($v);
                    }
                }
            }
            $this->load->view('nav', array('title'=>'/ จัดการข้อมูลส่วนตัว / เปลี่ยนรหัสผ่าน'));
            $this->load->view('settings/password', $data);
            $this->load->view('footer');
        }
    }
    
    private function _show_message($message)
    {
        $this->session->set_flashdata('message', $message);
    }
}
