<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableTime extends JTable
{
    public $id = NULL;
    public $come_hour = NULL;
    public $come_minute = NULL;
    public $back_hour = NULL;
    public $back_minute = NULL;
    public $remark = NULL;
    public $remark_text = NULL;
    public $user_id = NULL;
    public $week = NULL;
    public $day = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('time', 'id', $db);
    }
}