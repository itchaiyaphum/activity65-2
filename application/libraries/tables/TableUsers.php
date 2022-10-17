<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TableUsers extends JTable
{
    public $id = null;
    public $username = null;
    public $password = null;
    public $email = null;
    public $firstname = null;
    public $lastname = null;
    public $user_type = null;
    public $thumbnail = null;
    public $activated = null;
    public $banned = null;
    public $ban_reason = null;
    public $new_password_key = null;
    public $new_password_requested = null;
    public $new_email = null;
    public $new_email_key = null;
    public $last_ip = null;
    public $last_login = null;
    public $created = null;
    public $modified = null;
    public $college_id = null;
    
    public function __construct($db=null)
    {
        parent::__construct('users', 'id', $db);
    }
}
