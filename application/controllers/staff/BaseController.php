<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {
    public function __construct(){
        parent::__construct();
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }else{
            $profile = $this->profile_lib->getData();
            if($profile->user_type!="staff"){
                redirect('/staff_restricted_access/');
            }
        }
    }
}
