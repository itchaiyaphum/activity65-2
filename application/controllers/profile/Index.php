<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->executeRedirection();
    }
    
    private function executeRedirection()
    {
        $profile = $this->profile_lib->getData();
        if ($profile->user_type=="advisor") {
            redirect('/advisor/');
        } elseif ($profile->user_type=="headdepartment") {
            redirect('/headdepartment/');
        } elseif ($profile->user_type=="headadvisor") {
            redirect('/headadvisor/');
        } elseif ($profile->user_type=="executive") {
            redirect('/executive/');
        } elseif ($profile->user_type=="student") {
            redirect('/student/');
        } elseif ($profile->user_type=="staff") {
            redirect('/staff/');
        } elseif ($profile->user_type=="admin") {
            redirect('/admin/');
        }
    }

    public function index()
    {
        $this->load->view('nav');
        $this->load->view('student/index');
        $this->load->view('footer');
    }
}
