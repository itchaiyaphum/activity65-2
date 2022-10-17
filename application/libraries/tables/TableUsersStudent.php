<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TableUsersStudent extends JTable
{
    public $id = null;
    public $user_id = null;
    public $firstname = null;
    public $lastname = null;
    public $student_id = null;
    public $email = null;
    public $college_id = null;
    public $major_id = null;
    public $minor_id = null;
    public $group_id = null;
    public $created_at = null;
    public $updated_at = null;
    public $status = null;

    public function __construct($db=null)
    {
        parent::__construct('users_student', 'id', $db);
    }
}
