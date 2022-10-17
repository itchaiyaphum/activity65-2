<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Settings_model extends BaseModel
{
    public $table = null;

    public $ci = null;

    public function __construct()
    {
        parent::__construct();
        $this->ci = & get_instance();
    }

    public function validateStudent()
    {
        $this->ci->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('college_id', 'สถานศึกษา', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('major_id', 'แผนกวิชา', 'trim|required|xss_clean');
        
        if ($this->ci->form_validation->run()) {
            return true;
        }
        return false;
    }

    public function validateHeadDepartment()
    {
        $this->ci->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        
        if ($this->ci->form_validation->run()) {
            return true;
        }
        return false;
    }

    public function validateHeadAdvisor()
    {
        $this->ci->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('college_id', 'สถานศึกษา', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        
        if ($this->ci->form_validation->run()) {
            return true;
        }
        return false;
    }

    public function validateStaff()
    {
        $this->ci->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('college_id', 'สถานศึกษา', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        
        if ($this->ci->form_validation->run()) {
            return true;
        }
        return false;
    }

    public function validateExecutive()
    {
        $this->ci->form_validation->set_rules('firstname', 'ชื่อ', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('lastname', 'นามสกุล', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('college_id', 'สถานศึกษา', 'trim|required|xss_clean');
        $this->ci->form_validation->set_rules('email', 'อีเมล์', 'trim|required|xss_clean');
        
        if ($this->ci->form_validation->run()) {
            return true;
        }
        return false;
    }
}
