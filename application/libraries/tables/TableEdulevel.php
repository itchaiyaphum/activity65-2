<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableEdulevel extends JTable
{
    public $id = NULL;
    public $name = NULL;
    public $status = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('edulevel', 'id', $db);
    }
}