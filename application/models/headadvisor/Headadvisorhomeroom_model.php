<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Headadvisorhomeroom_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Users');
        $this->table->setStatusKey('activated');
    }
    
    public function getAdvisorItems()
    {
        $sql = "SELECT * FROM users WHERE user_type='advisor' ";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function approve()
    {
        $confirm_data = $this->ci->input->post();
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $user_id = $this->ci->tank_auth->get_user_id();
        $user_type = 'headadvisor';

        $confirm_items = array();
        array_push($confirm_items, array(
            'homeroom_id' => $homeroom_id,
            'user_id' => $user_id,
            'user_type' => $user_type,
            'action_status' => 'confirmed',
            'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
            'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
            'status' => 1
        ));
        
        // clear old homeroom data
        $this->ci->db->delete('homeroom_actions', array('homeroom_id' => $homeroom_id, 'user_id' => $user_id));
        
        // insert activity items
        return $this->ci->db->insert_batch('homeroom_actions', $confirm_items);
    }

    public function unapprove()
    {
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $user_id = $this->ci->tank_auth->get_user_id();
        return $this->ci->db->delete('homeroom_actions', array('homeroom_id' => $homeroom_id, 'user_id' => $user_id));
    }

    public function remove_confirm()
    {
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $advisor_id = $this->ci->input->get_post('advisor_id', 0);
        return $this->ci->db->delete('homeroom_actions', array('homeroom_id' => $homeroom_id, 'user_id' => $advisor_id));
    }
}
