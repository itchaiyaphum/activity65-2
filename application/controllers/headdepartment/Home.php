<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headdepartment' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Home extends BaseController
{
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headdepartment/menu', '', true);
        
        $this->load->view('nav', array('title'=>'/ หัวหน้าแผนก / หน้าหลัก'));
        $this->load->view('headdepartment/index', $data);
        $this->load->view('footer');
    }
}
