<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Homeroom_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('HomeRoom');
    }

    public function getPagination()
    {
        return $this->ci->helper_lib->getPagination(array(
            'base_url' => '/admin/homeroom/',
            'total_rows' => count($this->getItems(array(
                'no_limit' => true
            ))),
            'per_page' => 50
        ));
    }
    
    public function getStudentItems($activity_id=0)
    {
        $advisor_majors = "1,2"; //TODO: what?
        $sql = "SELECT 
                    users_student.*, 
                    groups.group_name, 
                    majors.major_name 
                FROM users_student
                LEFT JOIN groups ON (users_student.group_id=groups.id)
                LEFT JOIN majors ON (users_student.major_id=majors.id)
                WHERE users_student.major_id IN(".$advisor_majors.")";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getItems($options = array())
    {
        $where = $this->getQueryWhere($options);
//         $sql = "SELECT * FROM homerooms WHERE {$where}";
        $sql = "SELECT semester.name AS semester_name,homerooms.* FROM homerooms
                    LEFT JOIN semester ON (homerooms.semester_id=semester.id)
                    WHERE {$where}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getQueryWhere($options)
    {
        $filter_search = $this->ci->input->get_post('homeroom_filter_search');
        $filter_status = $this->ci->input->get_post('homeroom_filter_status');
        
        $wheres = array();
        
        // filter: status
        $options['filter_status'] = $filter_status;
        $filter_status_value = $this->getQueryStatus($options);
        $wheres[] = "homerooms.status IN({$filter_status_value})";
        
        // filter: search
        if ($filter_search != "") {
            $filter_search_value = $filter_search;
            $wheres[] = "homerooms.week LIKE '%{$filter_search_value}%'";
        }
        
        // render query
        return $this->renderQueryWhere($wheres, $options);
    }
}
