<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TableHomeRoomRisk extends JTable
{
    public $id = null;
    public $homeroom_id = null;
    public $group_id = null;
    public $advisor_id = null;
    public $created_at = null;
    public $updated_at = null;
    public $status = null;
    
    public function __construct($db=null)
    {
        parent::__construct('homeroom_risks', 'id', $db);
    }
}
