<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'student' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Home extends BaseController
{
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('student/menu', '', true);
        
        $this->load->view('nav');
        $this->load->view('student/index', $data);
        $this->load->view('footer');
    }
}
