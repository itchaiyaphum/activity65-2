<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableLoginAttempts extends JTable
{
    public $id = NULL;
    public $ip_address = NULL;
    public $login = NULL;
    public $time = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('login_attempts', 'id', $db);
    }
}