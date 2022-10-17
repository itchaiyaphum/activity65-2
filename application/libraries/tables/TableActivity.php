<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableActivity extends JTable
{
    public $id = NULL;
    public $activity = NULL;
    public $problem = NULL;
    public $advantage = NULL;
    public $user_id = NULL;
    public $week = NULL;
    public $day = NULL;
    public $created_at = NULL;
    public $updated_at = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('activity', 'id', $db);
    }
}