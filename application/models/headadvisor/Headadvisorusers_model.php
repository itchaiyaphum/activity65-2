<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Headadvisorusers_model extends BaseModel
{
    public $table = null;
    public $table_advisor = null;
    public $table_headdepartment = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Users');
        $this->table_advisor = $this->ci->factory_lib->getTable('UsersAdvisor', 'user_id');
        $this->table_headdepartment = $this->ci->factory_lib->getTable('UsersHeadDepartment', 'user_id');
        $this->table->setStatusKey('activated');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/headadvisor/users/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }
    
    public function checkEmailExists($email='')
    {
        $sql = "SELECT * FROM users WHERE email='".$email."'";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return count($items);
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
        $sql = "SELECT * FROM users WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getProfileItem($id=0)
    {
        $item = $this->getItem($id);
        if ($item->user_type=='headdepartment') {
            $this->table_headdepartment->load($id);
            return $this->table_headdepartment;
        }
        
        $this->table_advisor->load($id);
        return $this->table_advisor;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('users_filter_search');
        $filter_user_type = $this->ci->input->get_post('users_filter_user_type');
        $filter_status = $this->ci->input->get_post('users_filter_status');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "activated IN({$filter_status_value})";
        
        // filter: user_type
        if ($filter_user_type != "") {
            $filter_user_type_value = $filter_user_type;
            $wheres[] = "user_type='{$filter_user_type_value}'";
        } else {
            $wheres[] = "(user_type='advisor' OR user_type='headdepartment')";
        }

        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "(firstname LIKE '%{$filter_search_value}%' OR lastname LIKE '%{$filter_search_value}%' OR email LIKE '%{$filter_search_value}%')";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }

    public function saveData()
    {
        // save profile
        $data = $this->ci->input->post();
        if ($data['user_type']=='advisor') {
            $this->saveAdvisor($data);
        } elseif ($data['user_type']=='headdepartment') {
            $this->saveHeadDepartment($data);
        }

        // save table: users
        return $this->save();
    }

    public function saveAdvisor($data)
    {
        $users_data = array();
        $users_data['user_id'] = $data['id'];
        $users_data['firstname'] = $data['firstname'];
        $users_data['lastname'] = $data['lastname'];
        $users_data['email'] = $data['email'];
        $users_data['college_id'] = $data['college_id'];
        $users_data['major_id'] = $data['major_id'];
        
        //save table: users_advisor
        $this->ci->db->where('user_id', $users_data['user_id']);
        $query = $this->ci->db->get('users_advisor');
        if ($query->num_rows()) {
            $users_data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $users_data['user_id']);
            if ($this->ci->db->update('users_advisor', $users_data)) {
                return true;
            }
        } else {
            $users_data['created_at'] = date('Y-m-d H:i:s');
            $users_data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('users_advisor', $users_data)) {
                return true;
            }
        }
    
        return false;
    }

    public function saveHeadDepartment($data)
    {
        $users_data = array();
        $users_data['user_id'] = $data['id'];
        $users_data['firstname'] = $data['firstname'];
        $users_data['lastname'] = $data['lastname'];
        $users_data['email'] = $data['email'];
        $users_data['college_id'] = $data['college_id'];
        $users_data['major_id'] = $data['major_id'];
        
        //save table: users_headdepartment
        $this->ci->db->where('user_id', $users_data['user_id']);
        $query = $this->ci->db->get('users_headdepartment');
        if ($query->num_rows()) {
            $users_data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $users_data['user_id']);
            if ($this->ci->db->update('users_headdepartment', $users_data)) {
                return true;
            }
        } else {
            $users_data['created_at'] = date('Y-m-d H:i:s');
            $users_data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('users_headdepartment', $users_data)) {
                return true;
            }
        }
    
        return false;
    }
}
