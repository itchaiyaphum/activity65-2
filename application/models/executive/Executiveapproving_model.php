<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Executiveapproving_model extends BaseModel
{
    public $table = null;
    public $table_obedience = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('Users');
        $this->table->setStatusKey('activated');
        $this->table_obedience = $this->ci->factory_lib->getTable('HomeRoomObedience');
    }

    public function getHomeroomItems($options=array())
    {
        $filter_week = $this->ci->input->get_post('executive_filter_week');

        $wheres = array();
        $wheres[] = "homerooms.status=1";
        if ($filter_week != "") {
            $wheres[] = "homerooms.id IN({$filter_week})";
        }

        $options = array('orderby' => 'homerooms.week DESC');
        $wheres_sql = $this->renderQueryWhere($wheres, $options);

        $sql = "SELECT homerooms.*, semester.name as semester_name FROM homerooms 
                    LEFT JOIN semester ON (homerooms.semester_id=semester.id)
                    WHERE {$wheres_sql}";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getAllActionItems()
    {
        $sql = "SELECT * FROM homeroom_actions WHERE status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getMinorItems()
    {
        $sql = "SELECT * FROM minors WHERE status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getGroupItems()
    {
        $sql = "SELECT * FROM groups WHERE status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getAdvisorGroupItems()
    {
        $sql = "SELECT advisors_groups.*, users.firstname, users.lastname FROM advisors_groups 
                    LEFT JOIN users ON (advisors_groups.advisor_id=users.id)
                    WHERE advisors_groups.status=1 ";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }


    // dependency of getApproving()
    public function getMajorItems($options=array())
    {
        $filter_major = $this->ci->input->get_post('executive_filter_major');

        $wheres = array();
        $wheres[] = "status=1";
        if ($filter_major != "") {
            $wheres[] = "id IN({$filter_major})";
        }

        $wheres_sql = $this->renderQueryWhere($wheres, $options);

        $sql = "SELECT * FROM majors WHERE {$wheres_sql}";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getFilterWeeks()
    {
        //get homeroom items
        $homeroom_items = $this->ci->homeroom_model->getItems(array('status'=>1, 'no_limit'=>true));
        
        $items = array();

        foreach ($homeroom_items as $homeroom) {
            $item_weeks = new stdClass();
            $item_weeks->id               = $homeroom->id;
            $item_weeks->name             = $homeroom->week;
            array_push($items, $item_weeks);
        }

        // echo "<pre>";
        // print_r($items);
        // exit();
        
        return $items;
    }

    public function getFilterMajors()
    {
        //get major items
        $this->ci->load->model('admin/major_model', 'admin_major_model');
        $major_items = $this->ci->admin_major_model->getItems(array('status'=>1, 'no_limit'=>true));
        
        $items = array();

        foreach ($major_items as $major) {
            $item_majors = new stdClass();
            $item_majors->id               = $major->id;
            $item_majors->name             = $major->major_name;
            array_push($items, $item_majors);
        }

        // echo "<pre>";
        // print_r($items);
        // exit();
        
        return $items;
    }

    public function getApproving()
    {
        $filter_week = $this->ci->input->get_post('executive_filter_week');
        $filter_major = $this->ci->input->get_post('executive_filter_major');

        $profile = $this->ci->profile_lib->getData();

        //get homeroom item
        $homeroom_items = $this->getHomeroomItems(array('no_limit'=>true));
        
        //get major item
        $major_items = $this->getMajorItems(array('no_limit'=>true));
        
        //get minor items
        $minor_items = $this->getMinorItems();
        
        //get advisor_group items
        $advisor_group_items = $this->getAdvisorGroupItems();

        //get group items
        $group_items = $this->getGroupItems();

        //get action items
        $action_items = $this->getAllActionItems();

        $items = array();

        if ($filter_week=="" || $filter_major=="") {
            return $items;
        }

        foreach ($major_items as $major) {
            $item_major = new stdClass();
            $item_major->major_id               = $major->id;
            $item_major->major_name             = $major->major_name;

            $item_major->homerooms              = array();
            foreach ($homeroom_items as $homeroom) {
                $item_homeroom = new stdClass();
                $item_homeroom->id               = $homeroom->id;
                $item_homeroom->semester_name    = $homeroom->semester_name;
                $item_homeroom->week             = $homeroom->week;
                $item_homeroom->join_start       = $homeroom->join_start;
                $item_homeroom->join_end         = $homeroom->join_end;
                $item_homeroom->is_lock          = $homeroom->is_lock;
                $item_homeroom->is_lock_remark   = $homeroom->remark;

                $item_homeroom->minors           = array();
                foreach ($minor_items as $minor) {
                    if ($minor->major_id==$major->id) {
                        $item_minor                 = new stdClass();
                        $item_minor->minor_id       = $minor->id;
                        $item_minor->minor_name     = $minor->minor_name;

                        $item_minor->groups         = array();
                        foreach ($group_items as $group) {
                            if ($group->major_id==$major->id && $group->minor_id==$minor->id) {
                                $item_group                     = new stdClass();
                                $item_group->group_id           = $group->id;
                                $item_group->group_name         = $group->group_name;

                                $item_group->advisors           = array();
                                foreach ($advisor_group_items as $advisor_group) {
                                    if ($advisor_group->group_id==$group->id) {
                                        $item_advisor                       = new stdClass();
                                        $item_advisor->advisor_id           = $advisor_group->advisor_id;
                                        $item_advisor->advisor_type         = $advisor_group->advisor_type;
                                        $item_advisor->firstname            = $advisor_group->firstname;
                                        $item_advisor->lastname             = $advisor_group->lastname;
                                        array_push($item_group->advisors, $item_advisor);
                                    }
                                }

                                $item_group->approving           = array();
                                foreach ($action_items as $action) {
                                    if ($action->homeroom_id==$homeroom->id && $action->group_id==$group->id) {
                                        $item_approving                    = new stdClass();
                                        $item_approving->user_id           = $action->user_id;
                                        $item_approving->user_type         = $action->user_type;
                                        $item_approving->user_status       = $action->action_status;
                                        array_push($item_group->approving, $item_approving);
                                    }
                                }

                                array_push($item_minor->groups, $item_group);
                            }
                        }
                        array_push($item_homeroom->minors, $item_minor);
                    }
                }
                array_push($item_major->homerooms, $item_homeroom);
            }
            array_push($items, $item_major);
        }

        // echo "<pre>";
        // print_r($items);
        // exit();
        
        return $items;
    }

    public function getHeadDepartmentStatusButton($approving=null, $links=null)
    {
        $html = '';
        if (isset($approving)) {
            foreach ($approving as $approve) {
                if ($approve->user_type=='headdepartment') {
                    if ($approve->user_status=='viewed') {
                        $html = '<div class="uk-button uk-button-primary uk-button-mini"><i class="uk-icon-circle-o"></i> ยังไม่ได้รับการรับรอง</div>';
                    } elseif ($approve->user_status=='confirmed') {
                        $html = '<div class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-check"></i> รับรองการส่งแล้ว</div>';
                    } else {
                        $html = '<div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ยังไม่ได้เปิดอ่าน</div>';
                    }
                }
            }
        }

        //set default button
        if ($html=="") {
            $html .= '<div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ยังไม่ได้เปิดอ่าน</div>';
        }

        return $html;
    }

    public function getHeadAdvisorStatusButton($approving=null, $links=null)
    {
        $html = '';
        if (isset($approving)) {
            foreach ($approving as $approve) {
                if ($approve->user_type=='headadvisor') {
                    if ($approve->user_status=='viewed') {
                        $html = '<div class="uk-button uk-button-mini"><i class="uk-icon-eye"></i> ยังไม่ได้รับการรับรอง</div>';
                    } elseif ($approve->user_status=='confirmed') {
                        $html = '<div class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-check"></i> รับรองการส่งแล้ว</div>';
                    }
                }
            }
        }

        //set default button
        if ($html=="") {
            $html .= '<div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ยังไม่ได้เปิดอ่าน</div>';
        }

        return $html;
    }

    public function getExecutiveStatusButton($approving=null, $links=null)
    {
        $user_status = '';

        $headadvisor_has_approved = false;
        if (!is_null($approving)) {
            foreach ($approving as $approve) {
                // check if headadvisor has confirmed or not
                if ($approve->user_type=='headadvisor' && $approve->user_status=='confirmed') {
                    $headadvisor_has_approved = true;
                }
                //get user status from executive
                if ($approve->user_type=='executive') {
                    $user_status = $approve->user_status;
                }
            }
        }

        $approve_button = '';
        if ($headadvisor_has_approved) {
            if (isset($links)) {
                foreach ($links as $key=>$link) {
                    if ($key=='approve') {
                        $approve_button = " <a href='{$link}' class='uk-button uk-button-success uk-button-mini'><i class='uk-icon-save'></i></a>";
                    }
                }
            }
        }

        $remove_button = '';
        if (isset($links)) {
            foreach ($links as $key=>$link) {
                if ($key=='remove') {
                    $remove_button = " <a href='{$link}' class='uk-button uk-button-danger uk-button-mini'><i class='uk-icon-remove'></i></a>";
                }
            }
        }

        $view_button = '';
        if (isset($links)) {
            foreach ($links as $key=>$link) {
                if ($key=='view') {
                    $view_button = " <a href='{$link}' class='uk-button uk-button-mini'><i class='uk-icon-eye'></i></a>";
                }
            }
        }

        $html = "";
        if ($user_status=='viewed') {
            $html = '<div class="uk-button uk-button-mini"><i class="uk-icon-eye"></i> ยังไม่ได้รับการรับรอง</div>';
            $html .= $view_button;
            $html .= $approve_button;
        } elseif ($user_status=='confirmed') {
            $html = '<div class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-check"></i> รับรองการส่งแล้ว</div>';
            $html .= $view_button;
            $html .= $remove_button;
        } else {
            $html = '<div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ยังไม่ได้เปิดอ่าน</div>';
            $html .= $view_button;
            $html .= $approve_button;
        }

        return $html;
    }

    public function getConfirm($homeroom_id=0, $group_id=0)
    {
        //get homeroom item
        $homeroom_item = $this->ci->homeroom_model->getItem($homeroom_id);

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

        //get all action items ($homeroom_id, $group_id)
        $action_all_items = $this->getActionAll($homeroom_id, $group_id);

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

            $item_group->approving           = array();
            foreach ($action_all_items as $approve) {
                if ($approve->user_type=='headdepartment' || $approve->user_type=='headadvisor' || $approve->user_type=='executive') {
                    $item_approve                  = new stdClass();
                    $item_approve->user_id         = $approve->user_id;
                    $item_approve->user_type       = $approve->user_type;
                    $item_approve->user_status     = $approve->action_status;

                    array_push($item_group->approving, $item_approve);
                }
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

        // echo "<pre>";
        // print_r($item);
        // exit();

        return $item;
    }

    public function getConfirmButton($approving=null, $link='headadvisor/approving')
    {
        $user_id = $this->ci->profile_lib->getUserId();

        $user_status = '1';
        $approve_by_headdepartment = false;
        $approve_by_headadvisor = false;
        if (!is_null($approving)) {
            foreach ($approving as $approve) {
                // get executive action status
                if ($approve->user_type=='executive' && $approve->user_id==$user_id) {
                    $user_status = $approve->user_status;
                }
                //check if headdepartment approved or not
                if ($approve->user_type=='headadvisor' && $approve->user_status=='confirmed') {
                    $approve_by_headadvisor = true;
                }
                //check if headadvisor approved or not
                if ($approve->user_type=='headdepartment' && $approve->user_status=='confirmed') {
                    $approve_by_headdepartment = true;
                }
            }
        }

        $html = '';
        $link_to = base_url($link);

        if ($approve_by_headdepartment && $approve_by_headadvisor) {
            if ($user_status=='confirmed') {
                $html .= "<a class='uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top' href='{$link_to}'><i class='uk-icon-home'></i> กลับหน้าหลัก</a> ";
                $html .= "<button disabled class='uk-button uk-button-primary uk-button-large uk-width-large-2-4 uk-margin-top' data-uk-modal=\"{target:'#confirm-form'}\">รับรองการส่งแล้ว</button>";
            } else {
                $html .= "<a class='uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top' href='{$link_to}'><i class='uk-icon-home'></i> กลับหน้าหลัก</a> ";
                $html .= "<button class='uk-button uk-button-success uk-button-large uk-width-large-2-4 uk-margin-top' data-uk-modal=\"{target:'#confirm-form'}\"><i class='uk-icon-save'></i> กดรับรองการส่ง</button>";
            }
        } else {
            $html .= "<a class='uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top' href='{$link_to}'><i class='uk-icon-home'></i> กลับหน้าหลัก</a> ";
            $html .= "<button disabled class='uk-button uk-button-large uk-width-large-2-4 uk-margin-top'><i class='uk-icon-hourglass-o'></i> ...รอหัวหน้างานครูที่ปรึกษายืนยันข้อมูลก่อน...</button>";
        }

        return $html;
    }

    private function getActionAll($homeroom_id=0, $group_id=0)
    {
        $where_homeroom = "";
        if ($homeroom_id!=0) {
            $where_homeroom ="homeroom_id={$homeroom_id} AND ";
        }
        
        $where_group = "";
        if ($group_id!=0) {
            $where_group = "group_id={$group_id} AND ";
        }

        $sql = "SELECT * FROM homeroom_actions
                    WHERE {$where_homeroom} {$where_group} status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    private function getObedienceItems($homeroom_id=0, $group_id=0)
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
    
    public function getAdvisorItems()
    {
        $sql = "SELECT * FROM users WHERE user_type='advisor' ";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function saveAction($action_status='viewed', $homeroom_id=0, $group_id=0, $advisor_id=0, $advisor_type='headadvisor')
    {
        if ($advisor_id==0) {
            $advisor_id = $this->ci->profile_lib->getUserId();
        }
        
        $action_item = array(
            'homeroom_id' => $homeroom_id,
            'group_id' => $group_id,
            'user_id' => $advisor_id,
            'user_type' => $advisor_type,
            'action_status' => $action_status,
            'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
            'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
            'status' => 1
        );
        
        // clear old homeroom action if action=confirmed
        $this->ci->db->delete('homeroom_actions', array('homeroom_id' => $homeroom_id, 'group_id' => $group_id, 'user_id' => $advisor_id));

        // insert homeroom action
        return $this->ci->db->insert('homeroom_actions', $action_item);
    }

    public function getGroupByMinorId($minor_id=0)
    {
        $sql = "SELECT * FROM groups WHERE minor_id={$minor_id} AND status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function approve_all()
    {
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $minor_id = $this->ci->input->get_post('minor_id', 0);
        $user_id = $this->ci->profile_lib->getUserId();
        $user_type = 'executive';

        // get all action items
        $action_all_items = $this->getActionAll($homeroom_id);
        
        // get group belong minor item (where minor_id=$minor_id)
        $group_items = $this->getGroupByMinorId($minor_id);
        
        $approve_items = array();
        $group_ids = array();
        foreach ($group_items as $group) {
            //check if this group has saved by advisor or coadvisor already
            $enable_approve_advisor = false;
            foreach ($action_all_items as $action) {
                if (($action->user_type=='advisor' || $action->user_type=='coadvisor') && $action->action_status=='confirmed' && $action->group_id==$group->id) {
                    $enable_approve_advisor = true;
                }
            }
            //check if this group has confirmed by headdepartment
            //TODO: bug, it not have reason
            $enable_approve_headdepartment = false;
            foreach ($action_all_items as $action) {
                if ($action->user_type=='headdepartment' && $action->action_status=='confirmed' && $action->group_id==$group->id) {
                    $enable_approve_headdepartment = true;
                }
            }

            if ($enable_approve_advisor) {
                array_push($group_ids, $group->id);
                array_push($approve_items, array(
                    'homeroom_id' => $homeroom_id,
                    'group_id' => $group->id,
                    'user_id' => $user_id,
                    'user_type' => $user_type,
                    'action_status' => 'confirmed',
                    'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'status' => 1
                ));
            }
        }
        
        // echo "<pre>";
        // print_r($action_all_items);
        // print_r($group_ids);
        // print_r($approve_items);
        // exit();
        
        //clear old homeroom data
        if (count($group_ids)) {
            $this->ci->db->where('homeroom_id', $homeroom_id);
            $this->ci->db->where('user_id', $user_id);
            $this->ci->db->where_in('group_id', $group_ids);
            $this->ci->db->delete('homeroom_actions');
        }
        
        // insert activity items
        if (count($approve_items)) {
            return $this->ci->db->insert_batch('homeroom_actions', $approve_items);
        }

        return false;
    }

    public function unapprove_all()
    {
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $minor_id = $this->ci->input->get_post('minor_id', 0);
        $user_id = $this->ci->profile_lib->getUserId();

        // get group belong minor item (where minor_id=$minor_id)
        $group_items = $this->getGroupByMinorId($minor_id);

        $group_ids = array();
        foreach ($group_items as $group) {
            array_push($group_ids, $group->id);
        }

        // echo "<pre>";
        // print_r($group_ids);
        // exit();

        // clear old homeroom data
        if (count($group_ids)) {
            $this->ci->db->where('homeroom_id', $homeroom_id);
            $this->ci->db->where('user_id', $user_id);
            $this->ci->db->where_in('group_id', $group_ids);
            return $this->ci->db->delete('homeroom_actions');
        }
        
        return false;
    }

    public function unapprove()
    {
        $homeroom_id = $this->ci->input->get_post('homeroom_id', 0);
        $group_id = $this->ci->input->get_post('group_id', 0);
        $user_id = $this->ci->profile_lib->getUserId();

        return $this->ci->db->delete('homeroom_actions', array('homeroom_id' => $homeroom_id,'group_id' => $group_id, 'user_id' => $user_id));
    }
}
