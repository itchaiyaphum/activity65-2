<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'trainer' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Home extends BaseController
{

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('trainer/menu', '', true);
        
        $this->load->view('nav');
        $this->load->view('trainer/index', $data);
        $this->load->view('footer');
    }
}
