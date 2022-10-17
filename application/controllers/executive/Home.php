<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'executive' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Home extends BaseController
{
    public function index()
    {
        $data = array();
        $data['leftmenu'] = $this->load->view('executive/menu', '', true);
        
        $this->load->view('nav', array('title'=>'/ ผู้บริหาร / หน้าหลัก'));
        $this->load->view('executive/index', $data);
        $this->load->view('footer');
    }
}
