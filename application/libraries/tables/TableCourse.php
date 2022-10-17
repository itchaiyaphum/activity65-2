<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableCourse extends JTable
{
    public $id = NULL;
    public $name = NULL;
    public $course_code = NULL;
    public $credit = NULL;
    public $hour_per_week = NULL;
    public $num_of_week = NULL;
    public $advisor_id = NULL;
    public $semester_id = NULL;
    public $status = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    public $college_id = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('course', 'id', $db);
    }
}