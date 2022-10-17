<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableCollege extends JTable
{
    public $id = NULL;
    public $name = NULL;
    public $province_id = NULL;
    public $status = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('college', 'id', $db);
    }
}