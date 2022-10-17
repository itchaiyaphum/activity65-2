<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableInternship extends JTable
{
    public $id = NULL;
    public $title = NULL;
    public $college_id = NULL;
    public $edulevel_id = NULL;
    public $semester_id = NULL;
    public $department_id = NULL;
    public $group_id = NULL;
    public $internship_start = NULL;
    public $internship_end = NULL;
    public $num_weeks = NULL;
    public $published = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('internship', 'id', $db);
    }
}