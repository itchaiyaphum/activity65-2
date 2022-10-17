<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TableUserProfiles extends JTable
{
    public $id = NULL;
    public $user_id = NULL;
    public $country = NULL;
    public $website = NULL;
    
    public function __construct($db=NULL){
        parent::__construct('user_profiles', 'id', $db);
    }
}