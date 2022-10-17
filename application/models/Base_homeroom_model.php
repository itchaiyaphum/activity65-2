<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Base_homeroom_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->ci->load->library('homeroom_lib');
        $this->ci->load->library('profile_lib');
    }

    public function getItems($option=array())
    {
        $advisor_id = $this->ci->profile_lib->getUserId();

        $items = array();

        //get all homeroom items
        $this->ci->load->model('admin/homeroom_model', 'admin_homeroom_model');
        $homeroom_items = $this->ci->admin_homeroom_model->getItems(array(
            'status' => 1,
            'no_limit' => true,
            'orderby' => 'homerooms.week DESC'
        ));

        //get all groups items
        $group_items = $this->ci->homeroom_lib->getGroupsByAdvisor();

        //get all action items
        $action_items = $this->getAllActionItems();

        //get all groups items
        $advisor_groups_items = $this->getAllAdvisorGroups();

        foreach ($homeroom_items as $homeroom) {
            $temp_item = new stdClass();
            $temp_item->id              = $homeroom->id;
            $temp_item->week            = $homeroom->week;
            $temp_item->semester_name   = $homeroom->semester_name;
            $temp_item->join_start      = $homeroom->join_start;
            $temp_item->join_end        = $homeroom->join_end;
            $temp_item->is_lock         = $homeroom->id;
            $temp_item->remark          = $homeroom->remark;
            $temp_item->groups          = array();
            
            foreach ($group_items as $group) {
                $temp_group = new stdClass();
                $temp_group->id                 = $group->id;
                $temp_group->group_name         = $group->group_name;
                $temp_group->major_name         = $group->major_name;
                $temp_group->minor_name         = $group->minor_name;

                $temp_group->advisors           = array();
                foreach ($advisor_groups_items as $advisor_group) {
                    if ($advisor_group->group_id==$group->id) {
                        $action_status = 'pending';
                        foreach ($action_items as $action) {
                            if ($action->homeroom_id==$homeroom->id && $action->group_id==$group->id && $action->user_id==$advisor_group->advisor_id) {
                                $action_status = $action->action_status;
                            }
                        }

                        $tmp_advisor_group                  = new stdClass();
                        $tmp_advisor_group->advisor_id      = $advisor_group->advisor_id;
                        $tmp_advisor_group->advisor_type    = $advisor_group->advisor_type;
                        $tmp_advisor_group->advisor_status  = $action_status;

                        array_push($temp_group->advisors, $tmp_advisor_group);
                    }
                }

                array_push($temp_item->groups, $temp_group);
            }
            array_push($items, $temp_item);
        }

        // echo "<pre>";
        // print_r($items);
        // exit();
        
        return $items;
    }

    private function genAdvisorButtonStatus($advisor_status='')
    {
        $checkStatusHtml = "";
        if ($advisor_status=='viewed') {
            $checkStatusHtml = '<div class="uk-button-group">
                                            <div class="uk-button uk-button-mini"><i class="uk-icon-eye"></i></div>
                                            <div class="uk-button uk-button-mini">ครูที่ปรึกษาหลัก (กำลังบันทึกข้อมูล)</div>
                                        </div>';
        } elseif ($advisor_status=='confirmed') {
            $checkStatusHtml = '<div class="uk-button-group">
                                            <div class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-check"></i></div>
                                            <div class="uk-button uk-button-success uk-button-mini">ครูที่ปรึกษาหลัก (ยืนยันกรอกข้อมูลแล้ว)</div>
                                        </div>';
        } elseif ($advisor_status=='saving') {
            $checkStatusHtml = '<div class="uk-button-group">
                                            <div class="uk-button uk-button-primary uk-button-mini"><i class="uk-icon-gears"></i></div>
                                            <div class="uk-button uk-button-primary uk-button-mini">ครูที่ปรึกษาหลัก (กำลังบันทึก)</div>
                                        </div>';
        } else {
            $checkStatusHtml = '<div class="uk-button-group">
                                            <div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i></div>
                                            <div class="uk-button uk-button-mini">ครูที่ปรึกษาหลัก (รอบันทึกข้อมูล)</div>
                                        </div>';
        }
        return $checkStatusHtml;
    }

    private function genCoAdvisorButtonStatus($advisor_status='')
    {
        $advisor_status_html = "";
        if ($advisor_status=='viewed') {
            $advisor_status_html = '<div class="uk-button-group">
                                        <div class="uk-button uk-button-mini"><i class="uk-icon-eye"></i></div>
                                        <div class="uk-button uk-button-mini">ครูที่ปรึกษาร่วม (กำลังบันทึกข้อมูล)</div>
                                    </div>';
        } elseif ($advisor_status=='confirmed') {
            $advisor_status_html = '<div class="uk-button-group">
                                        <div class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-check"></i></div>
                                        <div class="uk-button uk-button-success uk-button-mini">ครูที่ปรึกษาร่วม (ยืนยันการกรอกข้อมูลแล้ว)</div>
                                    </div>';
        } elseif ($advisor_status=='saving') {
            $advisor_status_html = '<div class="uk-button-group">
                                        <div class="uk-button uk-button-warning uk-button-mini"><i class="uk-icon-gears"></i></div>
                                        <div class="uk-button uk-button-warning uk-button-mini">ครูที่ปรึกษาร่วม (กำลังบันทึกข้อมูล)</div>
                                    </div>';
        } else {
            $advisor_status_html = '<div class="uk-button-group">
                                        <div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i></div>
                                        <div class="uk-button uk-button-mini">ครูที่ปรึกษาร่วม (รอการบันทึกข้อมูล)</div>
                                    </div>';
        }
        return $advisor_status_html;
    }

    public function getAdvisorStatusHtml($advisors=null, $advisor_id=0)
    {
        $html = '';
        if (!is_null($advisors)) {
            foreach ($advisors as $advisor) {
                if ($advisor->advisor_type=='advisor') {
                    $html .= $this->genAdvisorButtonStatus($advisor->advisor_status);
                } elseif ($advisor->advisor_type=='coadvisor') {
                    $html .= $this->genCoAdvisorButtonStatus($advisor->advisor_status);
                }
            }
        }

        return $html;
    }

    public function getAdvisorTypeText($advisors=null, $advisor_id=0)
    {
        if ($advisor_id==0) {
            $advisor_id = $this->ci->profile_lib->getUserId();
        }

        $advisor_text = '';
        if (!is_null($advisors)) {
            foreach ($advisors as $advisor) {
                if ($advisor->advisor_type=='advisor' && $advisor->advisor_id==$advisor_id) {
                    $advisor_text = '<div class="uk-badge">เป็นที่ปรึกษาหลัก</div>';
                } elseif ($advisor->advisor_type=='coadvisor' && $advisor->advisor_id==$advisor_id) {
                    $advisor_text = '<div class="uk-badge uk-badge-warning">เป็นที่ปรึกษาร่วม</div>';
                }
            }
        }
        
        return $advisor_text;
    }
    

    public function getAllAdvisorGroups()
    {
        $sql = "SELECT * FROM advisors_groups WHERE status=1";
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

    // TODO: disable when action status has confirmed
    public function getEditButtonHtml($advisors=array(), $link='')
    {
        $html = "<a href='{$link}' class='uk-button uk-button-primary uk-button-small'><i class='uk-icon-pencil'></i> บันทึกข้อมูล</a>";
        foreach ($advisors as $advisor) {
            if ($advisor->advisor_status=='confirmed') {
                $html = "<a href='{$link}' class='uk-button uk-button-success uk-button-small'><i class='uk-icon-eye'></i> เรียกดูข้อมูล</a>";
            }
        }
        
        return $html;
    }

    // TODO: enable when all user_type has approved
    public function getPrintButtonHtml($advisors=array())
    {
        // $html = '<button disabled class="uk-button uk-button-small"><i class="uk-icon-print"></i></button>';
        $html = '';
        
        return $html;
    }
}
