<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_lib
{
    public $ci = null;

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    public function isLogin()
    {
        if ($this->ci->session->userdata('user_id')) {
            return true;
        }
        return false;
    }

    public function login($email = '', $password = '')
    {
        if ($email == "student@demo.com" && $password == '123456') {
            $this->setUserSession(array(
                'user_id' => 111,
                'email' => $email,
                'firstname' => 'Wannapong',
                'lastname' => 'Kumjumpon',
                'guest' => 0
            ));
            return true;
        }
        return false;
    }

    public function bypass_login($data=array())
    {
        $user_id = 0;
        
        if (isset($data['user_id'])) {
            $user_id = $data['user_id'];
        }

        $this->ci->tank_auth->create_autologin($user_id);

        return $this->ci->session->set_userdata(array(
            'user_id'	=> $data['user_id'],
            'username'	=> $data['username'],
            'email'	    => $data['email'],
            'firstname'	=> $data['firstname'],
            'lastname'	=> $data['lastname'],
            'user_type'	=> $data['user_type'],
            'thumbnail'	=> $data['thumbnail'],
            'bypass'	=> $data['bypass'],
            'status'	=> $data['status']
        ));
    }

    public function logout()
    {
        $this->ci->session->sess_destroy();
    }

    public function setUserSession($data = array())
    {
        $this->ci->session->set_userdata($data);
    }
}
