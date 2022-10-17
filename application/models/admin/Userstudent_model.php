<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Userstudent_model extends BaseModel
{
    public $table = null;
    public $table_group = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('UsersStudent');
        $this->table_group = $this->ci->factory_lib->getTable('Group');
        $this->table->setStatusKey('status');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/userstudent/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }
    
    public function checkEmailExists($email='')
    {
        $sql = "SELECT * FROM users_student WHERE email='".$email."'";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return count($items);
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
        $sql = "SELECT 
                    groups.group_name, groups.group_code,
                    majors.major_name,
                    minors.minor_name,
                    users.firstname AS advisor_firstname, users.lastname AS advisor_lastname,
                    users_student.* 
                FROM users_student 
                    LEFT JOIN groups ON (users_student.group_id=groups.id) 
                    LEFT JOIN users ON (users_student.user_id=users.id) 
                    LEFT JOIN majors ON (groups.major_id=majors.id) 
                    LEFT JOIN minors ON (groups.minor_id=minors.id) 
                WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function save($data = null)
    {
        $data = $this->ci->input->post();

        // get major_id,minor_id by using group_id find it
        $group_id = $this->ci->input->get_post('group_id');
        $this->table_group->load($group_id);
        $data['major_id'] = $this->table_group->major_id;
        $data['minor_id'] = $this->table_group->minor_id;

        $email = $data['email'];

        // add or edit data on table: users
        $sql = "SELECT * FROM users WHERE email='{$email}' ";
        $query = $this->ci->db->query($sql);
        $user_items = $query->result();

        if (count($user_items)) {
            $user_id = 0;
            foreach ($user_items as $user) {
                $user_id = $user->id;
            }

            //set this data for table: users_student
            $data['user_id'] = $user_id;

            //edit data on table users
            $prepare_users_data = array(
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'modified' => mdate('%Y-%m-%d %H:%i:%s', time()),
            );
            $this->ci->db->update('users', $prepare_users_data, array('id'=>$user_id));
        } else {
            //insert data
            $prepare_data = array(
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'user_type' => 'student',
                'created' => mdate('%Y-%m-%d %H:%i:%s', time()),
                'modified' => mdate('%Y-%m-%d %H:%i:%s', time()),
                'password' => md5('student1234567890'),
                'activated' => 1,
            );
            $this->ci->db->insert('users', $prepare_data);

            $data['user_id'] = $this->ci->db->insert_id(); //get user_id for table: users_student
        }

        return parent::save($data);
    }
    
    public function getItemsCustom($sql = 'SELECT * FROM users_student')
    {
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('users_filter_search');
        $filter_status = $this->ci->input->get_post('users_filter_status');
        $filter_group_id = $this->ci->input->get_post('users_filter_group_id');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "users_student.status IN({$filter_status_value})";
        
        // filter: group_id
        if ($filter_group_id != "" && $filter_group_id != "all") {
            $wheres[] = "groups.id IN({$filter_group_id})";
        }
        
        // filter: group_name, advisor firstname, lastname
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "groups.group_name LIKE '%{$filter_search_value}%' 
                            OR majors.major_name LIKE '%{$filter_search_value}%' 
                            OR minors.minor_name LIKE '%{$filter_search_value}%' 
                            OR users_student.student_id LIKE '%{$filter_search_value}%' 
                            OR users_student.email LIKE '%{$filter_search_value}%' 
                            OR users_student.firstname LIKE '%{$filter_search_value}%' 
                            OR users_student.lastname LIKE '%{$filter_search_value}%' ";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
