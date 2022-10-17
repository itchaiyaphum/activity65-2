<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Minor_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Minor');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/minor/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
//         $sql = "SELECT * FROM minors WHERE {$where}";
        $sql = "SELECT majors.major_name, minors.* FROM minors
                    LEFT JOIN majors ON (minors.major_id=majors.id)
                    WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('minor_filter_search');
        $filter_major_id = $this->ci->input->get_post('minor_filter_major_id');
        $filter_status = $this->ci->input->get_post('minor_filter_status');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "minors.status IN({$filter_status_value})";
        
        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "minors.minor_name LIKE '%{$filter_search_value}%'";
        }

        // filter: major_id
        if ($filter_major_id != "" && $filter_major_id != "all") {
            $wheres[] = "minors.major_id IN({$filter_major_id})";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
