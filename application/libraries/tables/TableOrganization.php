<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableOrganization extends JTable
{
    public $id = NULL;
    public $alias = NULL;
    public $parent_id = NULL;
    public $title = NULL;
    public $published = NULL;
    public $ordering = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('organization', 'id', $db);
    }
}