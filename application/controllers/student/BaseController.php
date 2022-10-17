<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            $user_type = $this->profile_lib->getUserType();
            if ($user_type!="student") {
                redirect('/student_restricted_access/');
            }
        }
    }
}
