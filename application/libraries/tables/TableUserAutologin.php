<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableUserAutologin extends JTable
{
    public $key_id = NULL;
    public $user_id = NULL;
    public $user_agent = NULL;
    public $last_ip = NULL;
    public $last_login = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('user_autologin', 'key_id', $db);
    }
}