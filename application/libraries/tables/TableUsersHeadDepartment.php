<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TableUsersHeadDepartment extends JTable
{
    public $id = null;
    public $user_id = null;
    public $firstname = null;
    public $lastname = null;
    public $created_at = null;
    public $updated_at = null;
    public $email = null;
    public $college_id = null;
    public $major_id = null;
    public $signature = null;
    
    public function __construct($db=null, $key='id')
    {
        parent::__construct('users_headdepartment', $key, $db);
    }
}
