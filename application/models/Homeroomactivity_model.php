<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Homeroomactivity_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('HomeRoomActivity');
    }

    public function saveItems()
    {
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $group_id = $this->ci->input->get_post('group_id', 0);
        $students = $this->ci->input->get_post('join_status', array());
        
        $activity_items = array();
        foreach ($students as $key => $val) {
            if (isset($val)) {
                array_push($activity_items, array(
                    'homeroom_id' => $homeroom_id,
                    'group_id' => $group_id,
                    'student_id' => $key,
                    'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'status' => 1,
                    'check_status' => $val
                ));
            }
        }
        
        // clear old homeroom data
        $this->ci->db->delete('homeroom_activity_items', array('homeroom_id' => $homeroom_id, 'group_id' => $group_id));
        
        // insert activity items
        return $this->ci->db->insert_batch('homeroom_activity_items', $activity_items);
    }

    public function getActivities($homeroom_id=0, $group_id=0)
    {
        //get homeroom item
        $this->ci->load->model('admin/homeroom_model', 'admin_homeroom_model');
        $homeroom_item = $this->ci->admin_homeroom_model->getItem($homeroom_id);

        //get group item
        $this->ci->load->model('admin/group_model', 'admin_group_model');
        $group_item = $this->ci->homeroom_lib->getGroupItem($group_id);

        //get action items
        $action_items = $this->ci->homeroom_lib->getActionItems($homeroom_id, $group_id);

        //get students items by group_id
        $student_items = $this->ci->homeroom_lib->getStudentItems($group_id);

        //get advisors items by group_id
        $advisor_items = $this->ci->homeroom_lib->getAdvisorGroupsItems($group_id);

        //get activity items
        $activity_items = $this->ci->homeroom_lib->getActivityItems($homeroom_id, $group_id);
        
        $item = new stdClass();
        $item->id               = $homeroom_item->id;
        $item->semester_id      = $homeroom_item->semester_id;
        $item->week             = $homeroom_item->week;
        $item->join_start       = $homeroom_item->join_start;
        $item->join_end         = $homeroom_item->join_end;
        $item->is_lock          = $homeroom_item->is_lock;
        $item->is_lock_remark   = $homeroom_item->remark;
        $item->groups           = array();

        if (isset($group_item)) {
            $advisor_id = 0;
            $advisor_type = '';
            $advisor_status = 'pending';
            if (isset($action_item)) {
                if ($action_item->homeroom_id==$homeroom_item->id && $action_item->group_id==$group_item->id) {
                    $advisor_type = $action_item->user_type;
                    $advisor_status = $action_item->action_status;
                }
            } else {
                $advisor_id = $this->ci->profile_lib->getUserId();
            }
            $item_group                     = new stdClass();
            $item_group->id                 = $group_item->id;
            $item_group->group_name         = $group_item->group_name;
            $item_group->minor_name         = $group_item->minor_name;
            $item_group->major_name         = $group_item->major_name;
            $item_group->advisor_id         = $advisor_id;
            $item_group->advisor_type       = $advisor_type;
            $item_group->advisor_status     = $advisor_status;

            $item_group->advisors           = array();
            foreach ($advisor_items as $advisor) {
                $advisor_status = 'pending';
                foreach ($action_items as $action) {
                    if ($action->homeroom_id==$homeroom_item->id && $action->group_id==$group_item->id && $action->user_id==$advisor->advisor_id) {
                        $advisor_status = $action->action_status;
                    }
                }
                $item_advisor                     = new stdClass();
                $item_advisor->advisor_id         = $advisor->advisor_id;
                $item_advisor->advisor_type       = $advisor->advisor_type;
                $item_advisor->advisor_status     = $advisor_status;

                array_push($item_group->advisors, $item_advisor);
            }

            $item_group->students           = array();

            foreach ($student_items as $student) {
                $activity_status = 'come'; //set default value
                //check activity status on each students
                foreach ($activity_items as $activity_item) {
                    if ($activity_item->homeroom_id==$homeroom_item->id && $activity_item->group_id==$group_item->id && $activity_item->student_id==$student->user_id) {
                        $activity_status = $activity_item->check_status;
                    }
                }
                $item_student                       = new stdClass();
                $item_student->id                   = $student->user_id;
                $item_student->student_code         = $student->student_code;
                $item_student->firstname            = $student->firstname;
                $item_student->lastname             = $student->lastname;
                $item_student->activity_status      = $activity_status;
                array_push($item_group->students, $item_student);
            }

            array_push($item->groups, $item_group);
        }

        // echo "<pre>";
        // print_r($item);
        // exit();
        
        return $item;
    }
}
