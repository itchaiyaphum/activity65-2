<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableAdvisorsGroups extends JTable
{
    public $id = NULL;
    public $advisor_id = NULL;
    public $group_id = NULL;
    public $advisor_type = NULL;
    public $status = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    
    private $advisor_firstname = NULL;
    private $advisor_lastname = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('advisors_groups', 'id', $db);
    }
}