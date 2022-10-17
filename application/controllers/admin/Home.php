<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Home extends BaseController
{

    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('admin/menu', '', true);
        
        $this->load->view('nav');
        $this->load->view('admin/index', $data);
        $this->load->view('footer');
    }
}
