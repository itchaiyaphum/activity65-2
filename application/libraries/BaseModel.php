<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class BaseModel
{
    public $ci = null;
    public $table = null;

    public function __construct()
    {
        $this->ci = & get_instance();
    }
    
    public function getItem($id = 0)
    {
        $this->table->load($id);
        return $this->table;
    }
    
    public function save($data = null)
    {
        if (is_null($data)) {
            $data = $this->ci->input->post();
        }
        return $this->table->save($data);
    }
    
    public function publish($id = 0)
    {
        return $this->table->publish($id, 1);
    }
    
    public function unpublish($id = 0)
    {
        return $this->table->publish($id, 0);
    }
    
    public function trash($id = 0)
    {
        return $this->table->publish($id, (- 1));
    }
    
    public function delete($id = 0)
    {
        return $this->table->delete($id);
    }
    
    public function restore($id = 0)
    {
        return $this->table->publish($id, 0);
    }

    public function renderQueryWhere($wheres = array(), $options = array())
    {
        // render : wheres
        if (!isset($options['where_type'])) {
            $options['where_type'] = 'AND';
        }
        $sql_wheres = (count($wheres) >= 2) ? implode(" {$options['where_type']} ", $wheres) : implode(' ', $wheres);
        // render : orderby
        $filter_orderby_value = $this->getQueryOrderBy($options);
        // render : limit
        $filter_limit_value = $this->getQueryLimit($options);
        $sql_wheres .= $filter_orderby_value;
        $sql_wheres .= $filter_limit_value;
        return $sql_wheres;
    }

    public function getQueryStatus($options)
    {
        $filter_status = '';
        if (!isset($options['filter_status'])) {
            $filter_status = $this->ci->input->get_post('filter_status');
        } else {
            $filter_status = $options['filter_status'];
        }
        $filter_status_value = '0,1';
        if (isset($options['status'])) {
            if (is_array($options['status'])) {
                $filter_status_value = implode(',', $options['status']);
            } elseif ($options['status'] == "all") {
                $filter_status_value = '0,1';
            } elseif ($options['status'] == "publish") {
                $filter_status_value = '1';
            } elseif ($options['status'] == "unpublish") {
                $filter_status_value = '0';
            } elseif ($options['status'] == "trash") {
                $filter_status_value = '-1';
            } else {
                $filter_status_value = $options['status'];
            }
        } else {
            if ($filter_status == "publish") {
                $filter_status_value = '1';
            } elseif ($filter_status == "unpublish") {
                $filter_status_value = '0';
            } elseif ($filter_status == "trash") {
                $filter_status_value = '-1';
            }
        }
        return $filter_status_value;
    }

    public function getQueryOrderBy($options)
    {
        $filter_orderby = '';
        if (isset($options['orderby'])) {
            $filter_orderby = $options['orderby'];
        }
        $sql_wheres = "";
        if (! empty($filter_orderby)) {
            $sql_wheres = " ORDER BY {$filter_orderby} ";
        }
        return $sql_wheres;
    }

    public function getQueryLimit($options)
    {
        $filter_page = $this->ci->input->get_post('per_page');
        if (isset($options['per_page'])) {
            $filter_page = $options['per_page'];
        }
        $filter_limit = 10;
        if (isset($options['limit'])) {
            $filter_limit = $options['limit'];
        }
        $sql_wheres = "";
        $limit = "";
        if (! empty($filter_limit) && $filter_limit != "all") {
            $filter_offset_value = 0;
            if ($filter_page > 1) {
                $filter_offset_value = ($filter_page - 1) * $filter_limit;
            }
            $filter_limit_value = $filter_limit;
            $limit = " LIMIT {$filter_offset_value},{$filter_limit_value} ";
        }
        if (! isset($options['no_limit'])) {
            $sql_wheres .= $limit;
        }
        return $sql_wheres;
    }
}
