<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableMinor extends JTable
{
    public $id = NULL;
    public $college_id = NULL;
    public $major_id = NULL;
    public $minor_code = NULL;
    public $minor_name = NULL;
    public $minor_eng = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    public $status = NULL;
    
    // Join Field (Hidden)
    private $major_name = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('minors', 'id', $db);
    }
}