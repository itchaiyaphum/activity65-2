<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Group_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Group');
        $this->ci->load->library('helper_lib');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/group/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
        $sql = "SELECT 
                    majors.major_name, 
                    minors.minor_name, 
                    groups.* FROM groups
                LEFT JOIN majors ON (groups.major_id=majors.id)
                LEFT JOIN minors ON (groups.minor_id=minors.id)
                WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('group_filter_search');
        $filter_minor_id = $this->ci->input->get_post('group_filter_minor_id');
        $filter_status = $this->ci->input->get_post('group_filter_status');

        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "groups.status IN({$filter_status_value})";
        
        // filter: minor_id
        if ($filter_minor_id != "" && $filter_minor_id != "all") {
            $wheres[] = "groups.minor_id IN({$filter_minor_id})";
        }

        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "groups.group_name LIKE '%{$filter_search_value}%' OR groups.group_code LIKE '%{$filter_search_value}%'";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
