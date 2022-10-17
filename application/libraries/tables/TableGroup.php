<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TableGroup extends JTable
{
    public $id = null;
    public $college_id = null;
    public $major_id = null;
    public $minor_id = null;
    public $group_code = null;
    public $group_name = null;
    public $created_at = null;
    public $updated_at = null;
    public $status = null;
    
    // Join Field (Hidden)
    private $major_name = null;
    private $minor_name = null;
    private $advisor_firstname = null;
    private $advisor_lastname = null;
    
    public function __construct($db=null)
    {
        parent::__construct('groups', 'id', $db);
    }
}
