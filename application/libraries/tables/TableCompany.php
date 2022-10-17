<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableCompany extends JTable
{
    public $id = NULL;
    public $name = NULL;
    public $type_name = NULL;
    public $address = NULL;
    public $province_id = NULL;
    public $status = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('company', 'id', $db);
    }
}