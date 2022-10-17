<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TableHomeRoom extends JTable
{
    public $id = null;
    public $semester_id = null;
    public $week = null;
    public $join_start = null;
    public $join_end = null;
    public $cover_img = null;
    public $created_at = null;
    public $updated_at = null;
    public $status = null;
    public $created_by_user_id = null;
    public $is_lock = null;
    public $remark = null;
    
    // Join Field (Hidden)
    private $semester_name = null;
    
    public function __construct($db=null)
    {
        parent::__construct('homerooms', 'id', $db);
    }
}
