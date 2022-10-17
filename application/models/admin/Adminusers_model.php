<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Adminusers_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Users');
        $this->table->setStatusKey('activated');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/users/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }

    public function save($data = null)
    {
        $data = $this->ci->input->post();
        $new_password = $data['new_password'];
        $confirm_password = $data['confirm_password'];

        if (!empty($new_password) || !empty($confirm_password)) {
            if ($new_password==$confirm_password) {
                $data['password'] = md5($new_password);
            }
        }

        return parent::save($data);
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

    public function bypass_login($user_id = 0)
    {
        $this->table->load($user_id);
        return $this->ci->auth_lib->bypass_login(array(
            'user_id'	=> $this->table->id,
            'username'	=> $this->table->username,
            'email'	    => $this->table->email,
            'firstname'	=> $this->table->firstname,
            'lastname'	=> $this->table->lastname,
            'user_type'	=> $this->table->user_type,
            'thumbnail'	=> $this->table->thumbnail,
            'bypass'	=> 1,
            'status'	=> $this->table->activated
        ));
    }
    
    public function getItemsCustom($sql = 'SELECT * FROM users')
    {
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
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
        }
        
        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "(firstname LIKE '%{$filter_search_value}%' OR lastname LIKE '%{$filter_search_value}%' OR email LIKE '%{$filter_search_value}%')";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
