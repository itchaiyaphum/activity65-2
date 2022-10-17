<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Edulevel_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Edulevel');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/edulevel/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
        $sql = "SELECT * FROM edulevel WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('edulevel_filter_search');
        $filter_status = $this->ci->input->get_post('edulevel_filter_status');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "status IN({$filter_status_value})";
        
        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "name LIKE '%{$filter_search_value}%'";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
