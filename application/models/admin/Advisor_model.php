<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Advisor_model extends BaseModel
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
            'base_url' => '/admin/advisor/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
        $sql = "SELECT users.*,
                        ua.major_id, ua.college_id
                    FROM users 
                    LEFT JOIN users_advisor as ua ON (users.id=ua.user_id)
                    WHERE (users.user_type='advisor' || users.user_type='headdepartment') AND {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('advisor_filter_search');
        $filter_status = $this->ci->input->get_post('advisor_filter_status');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "users.activated IN({$filter_status_value})";
        
        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "(users.firstname LIKE '%{$filter_search_value}%' OR users.lastname LIKE '%{$filter_search_value}%' OR email LIKE '%{$filter_search_value}%')";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
