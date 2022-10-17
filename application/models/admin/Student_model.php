<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Student_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('UsersStudent');
        $this->table->setStatusKey('activated');
    }

    public function getStudentsByAdvisorAmount($advisor_id=0)
    {
        if ($advisor_id==0) {
            $advisor_id = $this->ci->tank_auth->get_user_id();
        }
        // get all students belong advisor logined
        $sql = 'SELECT users_student.id  FROM users_student
                WHERE users_student.group_id IN( SELECT group_id FROM advisors_groups WHERE advisor_id='.$advisor_id.' AND status=1)';
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return count($items);
    }
    
    public function getStudentsByAdvisor($advisor_id=0)
    {
        if ($advisor_id==0) {
            $advisor_id = $this->ci->tank_auth->get_user_id();
        }
        $sql = "SELECT
                    users_student.id, users_student.student_id, users_student.firstname, users_student.lastname, users_student.group_id,
                    groups.group_name,
                    majors.id AS major_id, majors.major_name,
                    minors.id AS minor_id, minors.minor_name
                FROM users_student
                LEFT JOIN groups ON (users_student.group_id=groups.id)
                LEFT JOIN minors ON (groups.minor_id=minors.id)
                LEFT JOIN majors ON (minors.major_id=majors.id)
                WHERE users_student.group_id IN( SELECT group_id FROM advisors_groups WHERE advisor_id={$advisor_id} AND status=1 )";
        $query = $this->ci->db->query($sql);
        $students = $query->result();
        
        $items = array();
        foreach ($students as $item) {
            $add_to_array = false;
            foreach ($items as $val) {
                if ($item->group_id==$val['group_id']) {
                    array_push($items[$item->group_id]['items'], $item);
                    $add_to_array = true;
                }
            }
            if ($add_to_array==false) {
                $items[$item->group_id] = array(
                    'group_id' => $item->group_id,
                    'group_name' => $item->group_name,
                    'major_name' => $item->major_name,
                    'minor_name' => $item->minor_name,
                    'items' => array()
                );
                array_push($items[$item->group_id]['items'], $item);
            }
        }
        return $items;
    }

    public function getItems($options=array())
    {
        $sql = "SELECT
                    users_student.id, users_student.student_id, users_student.firstname, users_student.lastname, users_student.group_id,
                    groups.group_name,
                    majors.id AS major_id, majors.major_name,
                    minors.id AS minor_id, minors.minor_name
                FROM users_student
                    LEFT JOIN groups ON (users_student.group_id=groups.id)
                    LEFT JOIN minors ON (groups.minor_id=minors.id)
                    LEFT JOIN majors ON (minors.major_id=majors.id)
                WHERE status=1 )";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }
}
