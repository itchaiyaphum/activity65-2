<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'staff' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Homeroom extends BaseController
{
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('staff/menu', '', true);
        
        $this->load->view('nav');
        $this->load->view('staff/homeroom', $data);
        $this->load->view('footer');
    }
}
