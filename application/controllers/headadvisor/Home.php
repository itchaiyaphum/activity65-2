<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'headadvisor' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Home extends BaseController
{
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('headadvisor/menu', '', true);
        
        $this->load->view('nav', array('title'=>'/ หัวหน้างานครูที่ปรึกษา / หน้าหลัก'));
        $this->load->view('headadvisor/index', $data);
        $this->load->view('footer');
    }
}
