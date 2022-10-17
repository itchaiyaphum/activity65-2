<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Homeroomrisk_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('HomeRoomRisk');
    }

    public function getRisks($homeroom_id=0, $group_id=0)
    {
        //get homeroom item
        $this->ci->load->model('admin/homeroom_model', 'admin_homeroom_model');
        $homeroom_item = $this->ci->admin_homeroom_model->getItem($homeroom_id);

        //get group item
        $group_item = $this->ci->homeroom_lib->getGroupItem($group_id);

        //get action items
        $action_items = $this->ci->homeroom_lib->getActionItems($homeroom_id, $group_id);

        //get advisors items by group_id
        $advisor_items = $this->ci->homeroom_lib->getAdvisorGroupsItems($group_id);

        //get students items by group_id
        $student_items = $this->ci->homeroom_lib->getStudentItems($group_id);

        //get risk items
        $risk_items = $this->ci->homeroom_lib->getRiskItems($homeroom_id, $group_id);
        
        $item = new stdClass();
        $item->id               = $homeroom_item->id;
        $item->semester_id    = $homeroom_item->semester_id;
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
                $risk_detail = '';
                $risk_comment = '';
                $risk_status = 'not_risk';//set default value
                //check risk status on each students
                foreach ($risk_items as $risk_item) {
                    if ($risk_item->homeroom_id==$homeroom_item->id && $risk_item->group_id==$group_item->id && $risk_item->student_id==$student->user_id) {
                        $risk_detail    = $risk_item->risk_detail;
                        $risk_comment   = $risk_item->risk_comment;
                        $risk_status    = $risk_item->risk_status;
                    }
                }
                $item_student                       = new stdClass();
                $item_student->id                   = $student->user_id;
                $item_student->student_code         = $student->student_code;
                $item_student->firstname            = $student->firstname;
                $item_student->lastname             = $student->lastname;
                $item_student->risk_detail          = $risk_detail;
                $item_student->risk_comment         = $risk_comment;
                $item_student->risk_status          = $risk_status;
                array_push($item_group->students, $item_student);
            }

            array_push($item->groups, $item_group);
        }

        return $item;
    }

    public function save($data=null)
    {
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $group_id = $this->ci->input->get_post('group_id', 0);

        $data['created_at'] = mdate('%Y-%m-%d %H:%i:%s', time()); //TODO: if item exists, it will not record
        $data['updated_at'] = mdate('%Y-%m-%d %H:%i:%s', time());
        
        $this->ci->db->delete('homeroom_risks', array('homeroom_id' => $homeroom_id, 'group_id' => $group_id));
        return parent::save($data);
    }

    public function saveItems()
    {
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $group_id = $this->ci->input->get_post('group_id', 0);
        $student_items = $this->ci->input->get_post('student_items', array());
        
        $risk_items = array();
        foreach ($student_items as $key => $val) {
            if (isset($val['status'])) {
                array_push($risk_items, array(
                    'homeroom_id' => $homeroom_id,
                    'group_id' => $group_id,
                    'student_id' => $key,
                    'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'status' => 1,
                    'risk_detail' => $val['detail'],
                    'risk_comment' => $val['comment'],
                    'risk_status' => $val['status']
                ));
            }
        }
        
        // clear old homeroom data
        $this->ci->db->delete('homeroom_risk_items', array('homeroom_id' => $homeroom_id, 'group_id' => $group_id));
        
        // insert activity items
        return $this->ci->db->insert_batch('homeroom_risk_items', $risk_items);
    }
}
