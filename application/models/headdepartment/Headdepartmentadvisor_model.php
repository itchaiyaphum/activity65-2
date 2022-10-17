<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Headdepartmentadvisor_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Users');
        $this->table->setStatusKey('activated');
    }

    public function checkEmailExists($email='')
    {
        $sql = "SELECT email FROM users WHERE email='{$email}' ";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return count($items);
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/headdepartment/advisor/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }
    
    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
        $sql = "SELECT * FROM users WHERE user_type='advisor' AND {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }
    
    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('users_filter_search');
        $filter_status = $this->ci->input->get_post('users_filter_status');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "activated IN({$filter_status_value})";
        
        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "(firstname LIKE '%{$filter_search_value}%' OR lastname LIKE '%{$filter_search_value}%' OR email LIKE '%{$filter_search_value}%')";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
