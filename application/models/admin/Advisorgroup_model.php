<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Advisorgroup_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('AdvisorsGroups');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/advisorgroup/',
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
                    groups.group_name, groups.group_code,
                    majors.major_name,
                    minors.minor_name,
                    users.firstname AS advisor_firstname, users.lastname AS advisor_lastname,
                    advisors_groups.* 
                FROM advisors_groups 
                    LEFT JOIN groups ON (advisors_groups.group_id=groups.id) 
                    LEFT JOIN users ON (advisors_groups.advisor_id=users.id) 
                    LEFT JOIN majors ON (groups.major_id=majors.id) 
                    LEFT JOIN minors ON (groups.minor_id=minors.id) 
                WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('advisorgroup_filter_search');
        $filter_status = $this->ci->input->get_post('advisorgroup_filter_status');
        $filter_group_id = $this->ci->input->get_post('advisorgroup_filter_group_id');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "advisors_groups.status IN({$filter_status_value})";
        
        // filter: group_id
        if ($filter_group_id != "" && $filter_group_id != "all") {
            $wheres[] = "groups.id IN({$filter_group_id})";
        }
        
        // filter: search
        // group_name, advisor firstname, lastname
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "groups.group_name LIKE '%{$filter_search_value}%' 
                            OR users.firstname LIKE '%{$filter_search_value}%' 
                            OR users.lastname LIKE '%{$filter_search_value}%' ";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
