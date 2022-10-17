<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableMajor extends JTable
{
    public $id = NULL;
    public $college_id = NULL;
    public $major_code = NULL;
    public $major_name = NULL;
    public $major_eng = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    public $status = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('majors', 'id', $db);
    }
}