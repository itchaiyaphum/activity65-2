<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableAttachmentFiles extends JTable
{
    public $id = NULL;
    public $user_id = NULL;
    public $internship_id = NULL;
    public $week = NULL;
    public $day = NULL;
    public $file_name = NULL;
    public $file_ext = NULL;
    public $orig_name = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('attachment_files', 'id', $db);
    }
}