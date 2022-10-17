<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Internship_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Internship');
        $this->table->setStatusKey('published');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/internship/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
        $sql = "SELECT * FROM internship WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('internship_filter_search');
        $filter_semester_id = $this->ci->input->get_post('internship_filter_semester_id');
        $filter_status = $this->ci->input->get_post('internship_filter_status');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "published IN({$filter_status_value})";
        // filter: semester_id
        if ($filter_semester_id != "") {
            $wheres[] = "semester_id IN({$filter_semester_id})";
        }
        
        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "name LIKE '%{$filter_search_value}%'";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
