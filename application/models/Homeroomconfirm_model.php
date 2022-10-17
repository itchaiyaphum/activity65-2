<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Homeroomconfirm_model extends BaseModel
{
    public $table = null;
    public $table_obedience = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('HomeRoomConfirm');
        $this->table_obedience = $this->ci->factory_lib->getTable('HomeRoomObedience');
    }

    public function getConfirm($homeroom_id=0, $group_id=0)
    {
        //get homeroom item
        $this->ci->load->model('admin/homeroom_model', 'admin_homeroom_model');
        $homeroom_item = $this->ci->admin_homeroom_model->getItem($homeroom_id);

        //get group item
        $group_item = $this->ci->homeroom_lib->getGroupItem($group_id);

        //get action items
        $action_items = $this->ci->homeroom_lib->getActionItems($homeroom_id, $group_id);

        //get Obedience item
        $obedience_item = $this->getObedienceItem($homeroom_id, $group_id);

        //get students items by group_id
        $student_items = $this->ci->homeroom_lib->getStudentItems($group_id);

        //get activity items
        $activity_items = $this->ci->homeroom_lib->getActivityItems($homeroom_id, $group_id);

        //get risk items
        $risk_items = $this->ci->homeroom_lib->getRiskItems($homeroom_id, $group_id);

        //get advisors items by group_id
        $advisor_items = $this->ci->homeroom_lib->getAdvisorGroupsItems($group_id);
        
        //get attachments items
        $attactment_items = $this->getAttachments($homeroom_id, $group_id);

        $item = new stdClass();
        $item->id               = $homeroom_item->id;
        $item->semester_id      = $homeroom_item->semester_id;
        $item->week             = $homeroom_item->week;
        $item->join_start       = $homeroom_item->join_start;
        $item->join_end         = $homeroom_item->join_end;
        $item->is_lock          = $homeroom_item->is_lock;
        $item->is_lock_remark   = $homeroom_item->remark;
        
        $tmp_summary                       = new stdClass();
        $tmp_summary->student_totals       = count($student_items);
        $tmp_summary->student_come         = 0;
        $tmp_summary->student_not_come     = 0;
        $tmp_summary->student_late         = 0;
        $tmp_summary->student_leave        = 0;
        $tmp_summary->student_risk         = 0;
        $tmp_summary->student_not_risk     = 0;

        $item->groups           = array();
        if (isset($group_item)) {
            $item_group                     = new stdClass();
            $item_group->group_id           = $group_item->id;
            $item_group->group_name         = $group_item->group_name;
            $item_group->minor_name         = $group_item->minor_name;
            $item_group->major_name         = $group_item->major_name;

            $obe_id             = 0;
            $obe_detail         = '';
            $survey_amount      = 0;
            $student_totals     = count($student_items);
            if (isset($obedience_item)) {
                $obe_id             = $obedience_item->id;
                $obe_detail         = $obedience_item->obe_detail;
                $survey_amount      = $obedience_item->survey_amount;
            }
            $tmp_obedience                  = new stdClass();
            $tmp_obedience->obe_id          = $obe_id;
            $tmp_obedience->obe_detail      = $obe_detail;
            $tmp_obedience->survey_amount   = $survey_amount;
            $tmp_obedience->student_totals  = $student_totals;
            $item_group->obedience          = $tmp_obedience;

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
                $activity_status = '';//set default value
                //check activity status on each students
                foreach ($activity_items as $activity_item) {
                    if ($activity_item->homeroom_id==$homeroom_item->id && $activity_item->group_id==$group_item->id && $activity_item->student_id==$student->user_id) {
                        $activity_status    = $activity_item->check_status;
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
                $item_student->activity_status      = $activity_status;
                array_push($item_group->students, $item_student);

                //calculate stats: risk
                if ($risk_status=='risk') {
                    $tmp_summary->student_risk++;
                } elseif ($risk_status=='not_risk') {
                    $tmp_summary->student_not_risk++;
                }
                //calculate stats: activity
                if ($activity_status=='come') {
                    $tmp_summary->student_come++;
                } elseif ($activity_status=='not_come') {
                    $tmp_summary->student_not_come++;
                } elseif ($activity_status=='late') {
                    $tmp_summary->student_late++;
                } elseif ($activity_status=='leave') {
                    $tmp_summary->student_leave++;
                }
            }
            
            $item_group->attachments        = array();
            foreach ($attactment_items as $attachment) {
                $item_file                  = new stdClass();
                $item_file->img_id          = $attachment->id;
                $item_file->img_path        = $attachment->img;

                array_push($item_group->attachments, $item_file);
            }

            array_push($item->groups, $item_group);
        }

        $item->summary                      = $tmp_summary;

        return $item;
    }

    public function getObedienceItems($homeroom_id=0, $group_id=0)
    {
        $sql = 'SELECT * 
                    FROM homeroom_obediences
                    WHERE homeroom_id='.$homeroom_id.' AND group_id='.$group_id;
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getObedienceItem($homeroom_id=0, $group_id=0)
    {
        $items = $this->getObedienceItems($homeroom_id, $group_id);

        $id = 0;
        if (count($items)) {
            $id = $items[0]->id;
            $this->table_obedience->load($id);
        }
        return $this->table_obedience;
    }

    private function getAttachments($homeroom_id = 0, $group_id = 0)
    {
        // get obedience attactments belong advisor logined
        $sql = 'SELECT *
                FROM homeroom_obedience_attachments
                WHERE homeroom_id='.$homeroom_id.' AND group_id='.$group_id;
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function saveData()
    {
        $confirm_data   = $this->ci->input->post();
        $homeroom_id    = $this->ci->input->post('homeroom_id', 0);
        $group_id       = $this->ci->input->post('group_id', 0);
        $advisor_id     = $this->ci->profile_lib->getUserId();
        $advisor_type   = $this->ci->homeroom_lib->getUserType($group_id);

        $confirm_items = array();
        array_push($confirm_items, array(
            'homeroom_id'   => $homeroom_id,
            'user_id'       => $advisor_id,
            'user_type'     => $advisor_type,
            'action_status' => 'confirmed',
            'created_at'    => mdate('%Y-%m-%d %H:%i:%s', time()),
            'updated_at'    => mdate('%Y-%m-%d %H:%i:%s', time()),
            'status'        => 1
        ));
        
        // clear old homeroom data
        $this->ci->db->delete('homeroom_actions', array('homeroom_id' => $homeroom_id, 'group_id' => $group_id, 'user_id' => $advisor_id));
        
        // insert activity items
        return $this->ci->db->insert_batch('homeroom_actions', $confirm_items);
    }
}
