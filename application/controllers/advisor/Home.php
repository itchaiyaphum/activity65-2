<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'advisor' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Home extends BaseController
{
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('advisor/menu', '', true);
        
        $this->load->view('nav', array('title'=>'/ ครูที่ปรึกษา / หน้าหลัก'));
        $this->load->view('advisor/index', $data);
        $this->load->view('footer');
    }
}
