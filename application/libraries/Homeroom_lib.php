<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homeroom_lib
{
    public $ci = null;

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    /*
    //  ==================== All ====================
    */
    public function convertStatusText($key=null)
    {
        $values = array(
            'come' => '<div class="uk-badge uk-badge-success">มา</div>',
            'not_come' => '<div class="uk-badge uk-badge-danger">ขาด</div>',
            'late' => '<div class="uk-badge uk-badge-warning">สาย</div>',
            'leave' => '<div class="uk-badge uk-badge-warning">ลา</div>',
            'risk' => '<div class="uk-badge uk-badge-danger">เสี่ยง</div>',
            'not_risk' => '<div class="uk-badge uk-badge-success">ไม่เสี่ยง</div>'
        );
        $value = $key;
        if (isset($key)) {
            if (isset($values[$key])) {
                $value = $values[$key];
            }
        }
        return $value;
    }

    private function genAdvisorButtonStatus($advisor_status='', $links=null, $advisor_id=0)
    {
        $remove_button = '';
        if (isset($links)) {
            foreach ($links as $key=>$link) {
                if ($key=='remove') {
                    $remove_button = " <a href='{$link}&advisor_id={$advisor_id}' class='uk-button uk-button-danger uk-button-mini'><i class='uk-icon-remove'></i></a>";
                }
            }
        }

        $html = "";
        if ($advisor_status=='viewed') {
            $html = '<div class="uk-button uk-button-mini"><i class="uk-icon-eye"></i> ครูที่ปรึกษาหลัก (กำลังบันทึก)</div>';
        } elseif ($advisor_status=='confirmed') {
            $html = '<div class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-check"></i> ครูที่ปรึกษาหลัก</div>';
            $html .= $remove_button;
        } elseif ($advisor_status=='saving') {
            $html = '<div class="uk-button uk-button-primary uk-button-mini">ครูที่ปรึกษาหลัก (กำลังบันทึก)</div>';
        } else {
            $html = '<div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ครูที่ปรึกษาหลัก (รอบันทึก)</div>';
        }
        return $html;
    }

    private function genCoAdvisorButtonStatus($advisor_status='', $links=null, $advisor_id=0)
    {
        $remove_button = '';
        if (isset($links)) {
            foreach ($links as $key=>$link) {
                if ($key=='remove') {
                    $remove_button = " <a href='{$link}&advisor_id={$advisor_id}' class='uk-button uk-button-danger uk-button-mini'><i class='uk-icon-remove'></i></a>";
                }
            }
        }

        $html = "";
        if ($advisor_status=='viewed') {
            $html = '<div class="uk-button uk-button-mini"><i class="uk-icon-eye"></i> ครูที่ปรึกษาร่วม (กำลังบันทึก)</div>';
        } elseif ($advisor_status=='confirmed') {
            $html = '<div class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-check"></i> ครูที่ปรึกษาร่วม</div>';
            $html .= $remove_button;
        } elseif ($advisor_status=='saving') {
            $html = '<div class="uk-button uk-button-warning uk-button-mini"><i class="uk-icon-gears"></i> ครูที่ปรึกษาร่วม (กำลังบันทึก)</div>';
        } else {
            $html = '<div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ครูที่ปรึกษาร่วม (รอบันทึก)</div>';
        }
        return $html;
    }

    public function getAdvisorStatusHtml($advisors=null, $approving=null, $links=null)
    {
        $html = '';
        if (isset($advisors) && isset($approving)) {
            foreach ($advisors as $advisor) {
                $html_advisor = '';
                foreach ($approving as $approve) {
                    if ($advisor->advisor_id==$approve->advisor_id) {
                        if ($advisor->advisor_type=='advisor') {
                            $html_advisor .= $this->genAdvisorButtonStatus($approve->advisor_status, $links, $approve->advisor_id);
                        } elseif ($advisor->advisor_type=='coadvisor') {
                            $html_advisor .= $this->genCoAdvisorButtonStatus($approve->advisor_status, $links, $approve->advisor_id);
                        }
                    }
                }
                if ($html_advisor!="") {
                    $html .= $html_advisor;
                }
                if ($advisor->advisor_type=='advisor' && $html_advisor=="") {
                    //set default button
                    $html .= '<div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ครูที่ปรึกษาหลัก (รอบันทึก)</div>';
                } elseif ($advisor->advisor_type=='coadvisor' && $html_advisor=="") {
                    //set default button
                    $html .= '<div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ครูที่ปรึกษาร่วม (รอบันทึก)</div>';
                }
            }
        }

        return $html;
    }

    private function genHeadDepartmentButtonStatus($approving=null, $advisor_status='', $links=null)
    {
        $enable_approve_button = true;
        if (!is_null($approving)) {
            foreach ($approving as $approve) {
                if ($approve->advisor_status=='confirmed' && $approve->advisor_type=='headdepartment') {
                    $enable_approve_button = false;
                }
            }
        }

        $approve_button = '';
        if ($enable_approve_button) {
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
                    $view_button = " <a href='{$link}' class='uk-button uk-button-mini'><i class='uk-icon-eye'></i></a> ";
                }
            }
        }

        $html = "";
        if ($advisor_status=='viewed') {
            $html .= $view_button;
            $html .= '<div class="uk-button uk-button-mini"><i class="uk-icon-eye"></i> ยังไม่ได้รับการรับรอง</div>';
            $html .= $approve_button;
        } elseif ($advisor_status=='confirmed') {
            $html .= $view_button;
            $html .= '<div class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-check"></i> รับรองการส่งแล้ว</div>';
            $html .= $remove_button;
        } else {
            $html .= $view_button;
            $html .= ' <div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ยังไม่ได้เปิดอ่าน</div>';
        }

        return $html;
    }

    public function getHeadDepartmentStatusHtml($approving=null, $links=null)
    {
        $enable_approve_button = false;
        if (!is_null($approving)) {
            foreach ($approving as $approve) {
                if ($approve->advisor_status=='confirmed') {
                    $enable_approve_button = true;
                }
            }
        }

        $approve_button = '';
        if ($enable_approve_button) {
            if (isset($links)) {
                foreach ($links as $key=>$link) {
                    if ($key=='approve') {
                        $approve_button = " <a href='{$link}' class='uk-button uk-button-success uk-button-mini'><i class='uk-icon-save'></i></a>";
                    }
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

        $html = '';
        if (isset($approving)) {
            foreach ($approving as $approve) {
                if ($approve->advisor_type=='headdepartment') {
                    $html .= $this->genHeadDepartmentButtonStatus($approving, $approve->advisor_status, $links);
                }
            }

            //set default button
            if ($html=="") {
                $html .= $view_button;
                $html .= ' <div class="uk-button uk-button-mini"><i class="uk-icon-circle-o"></i> ยังไม่ได้เปิดอ่าน</div>';
                $html .= $approve_button;
            }
        }

        return $html;
    }

    public function getApproveAllStatusHtml($minior, $links=null)
    {
        $html = '';
        if (isset($minior->groups)) {
            if (count($minior->groups)) {
                if (isset($links)) {
                    foreach ($links as $key=>$link) {
                        if ($key=='approve') {
                            $html .= " <a href='{$link}' class='uk-button uk-button-success uk-button-mini'><i class='uk-icon-save'></i> กดยืนยันการส่งข้อมูล</a>";
                        } elseif ($key=='unapprove') {
                            $html .= " <a href='{$link}' class='uk-button uk-button-danger uk-button-mini'><i class='uk-icon-remove'></i> กดยกเลิกการส่งข้อมูล</a>";
                        }
                    }
                }
            }
        }

        return $html;
    }


    /*
    //  ==================== Student ====================
    */
    public function getStudentItems($group_id=0)
    {
        $sql = "SELECT group_id, user_id, student_id as student_code, firstname, lastname FROM users_student 
                    WHERE group_id={$group_id} AND status=1 ORDER BY student_code ASC";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }




    /*
    // ==================== Groups ====================
    */
    public function getGroupsByAdvisor($advisor_id=0)
    {
        if ($advisor_id==0) {
            $advisor_id = $this->ci->profile_lib->getUserId();
        }
        $sql = "SELECT groups.*,majors.major_name,minors.minor_name FROM groups 
                    LEFT JOIN majors ON (groups.major_id=majors.id)
                    LEFT JOIN minors ON (groups.minor_id=minors.id)
                    WHERE groups.id IN (SELECT group_id FROM advisors_groups WHERE advisor_id={$advisor_id} AND status=1) 
                            AND groups.status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getGroupItem($group_id=0)
    {
        $sql = "SELECT groups.*,majors.major_name,minors.minor_name FROM groups 
                    LEFT JOIN majors ON (groups.major_id=majors.id)
                    LEFT JOIN minors ON (groups.minor_id=minors.id)
                    WHERE groups.id={$group_id} AND groups.status=1";
        $query = $this->ci->db->query($sql);
        $item = $query->row();
        return $item;
    }

    


    
    /*
    //  ==================== Homeroom ====================
    */
    public function getSaveButton($advisors=null, $link='advisor/homeroom')
    {
        $disable_save_button = false;
        if (!is_null($advisors)) {
            foreach ($advisors as $advisor) {
                if ($advisor->advisor_status=='confirmed') {
                    $disable_save_button = true;
                }
            }
        }

        $html = '';
        $link_to = base_url($link);
        if ($disable_save_button) {
            $html .= "<a class='uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top' href='{$link_to}'><i class='uk-icon-home'></i> กลับหน้าหลัก</a> ";
            $html .= "<button disabled class='uk-button uk-button-primary uk-button-large uk-width-large-2-4 uk-margin-top' data-uk-modal=\"{target:'#confirm-form'}\">ยืนยันการบันทึกข้อมูลเรียบร้อยแล้ว</button>";
        } else {
            $html .= "<a class='uk-button uk-button-large uk-width-large-1-4 uk-margin-top' href='{$link_to}'><i class='uk-icon-home'></i> กลับหน้าหลัก</a> ";
            $html .= " <button class='uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top' data-uk-modal=\"{target:'#confirm-form'}\">กดบันทึกข้อมูล</button>";
        }
        return $html;
    }

    public function getConfirmButton($advisors=null, $link='advisor/homeroom')
    {
        $advisor_id = $this->ci->profile_lib->getUserId();

        $advisor_status = '';
        if (!is_null($advisors)) {
            foreach ($advisors as $advisor) {
                if ($advisor->advisor_id==$advisor_id) {
                    $advisor_status = $advisor->advisor_status;
                }
            }
        }

        $html = '';
        if ($advisor_status=='confirmed') {
            $link_to = base_url($link);
            $html .= "<a class='uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top' href='{$link_to}'><i class='uk-icon-home'></i> กลับหน้าหลัก</a> ";
            $html .= "<button disabled class='uk-button uk-button-success uk-button-large uk-width-large-2-4 uk-margin-top' data-uk-modal=\"{target:'#confirm-form'}\">ยืนยันการบันทึกข้อมูลเรียบร้อยแล้ว</button>";
        } else {
            $html .= "<button class='uk-button uk-button-success uk-button-large uk-width-large-2-4 uk-margin-top' data-uk-modal=\"{target:'#confirm-form'}\"><i class='uk-icon-save'></i> กดยืนยันการบันทึกข้อมูล</button>";
        }
        return $html;
    }



    /*
    //  ==================== Homeroom Action ================================
    */
    public function saveAction($action_status='viewed', $homeroom_id=0, $group_id=0, $advisor_id=0)
    {
        $advisor_type = $this->getUserType($group_id);
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
        
        // clear old homeroom action
        $this->ci->db->delete('homeroom_actions', array('homeroom_id' => $homeroom_id, 'group_id' => $group_id, 'user_id' => $advisor_id));
        
        // insert homeroom action
        return $this->ci->db->insert('homeroom_actions', $action_item);
    }

    public function getActionItem($homeroom_id=0, $group_id=0)
    {
        $sql = "SELECT * FROM homeroom_actions 
                    WHERE homeroom_id={$homeroom_id} AND group_id={$group_id} AND status=1";
        $query = $this->ci->db->query($sql);
        $item = $query->row();
        return $item;
    }

    public function getActionItems($homeroom_id=0, $group_id=0, $advisor_id=0)
    {
        if ($advisor_id==0) {
            $advisor_id = $this->ci->profile_lib->getUserId();
        }
        
        $group_ids = $group_id;
        if ($group_id==0) {
            $group_items = $this->getGroupsByAdvisor($advisor_id);
            $groups = array();
            foreach ($group_items as $group) {
                array_push($groups, $group->id);
            }
            $group_ids = implode(',', $groups);
        }

        $sql = "SELECT * FROM homeroom_actions 
                    WHERE homeroom_id={$homeroom_id} AND user_id IN (SELECT DISTINCT advisor_id FROM advisors_groups WHERE group_id IN({$group_ids})) 
                            AND status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }



    /*
    //  ==================== Advisor ====================
    */
    public function getUserType($group_id=0, $advisor_id=0)
    {
        if ($advisor_id==0) {
            $advisor_id = $this->ci->profile_lib->getUserId();
        }
        $sql = "SELECT advisor_type FROM advisors_groups WHERE group_id={$group_id} AND advisor_id={$advisor_id}";
        $query = $this->ci->db->query($sql);
        $item = $query->row();

        $advisor_type = '';
        if (isset($item)) {
            $advisor_type = $item->advisor_type;
        }
        return $advisor_type;
    }

    public function getAdvisorGroupsItems($group_id=0)
    {
        $group_ids = $group_id;
        if ($group_id==0) {
            //get all groups items
            $group_items = $this->getGroupsByAdvisor();
            $groups = array();
            foreach ($group_items as $group) {
                array_push($groups, $group->id);
            }
            $group_ids = implode(',', $groups);
        }

        $sql = "SELECT * FROM advisors_groups WHERE group_id IN({$group_ids}) AND status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getAdvisorType($group_id=0, $advisor_id=0)
    {
        if ($advisor_id==0) {
            $advisor_id = $this->ci->profile_lib->getUserId();
        }
        $advisor_groups = $this->getAdvisorGroupsItems($group_id);

        $advisor_type = '';
        foreach ($advisor_groups as $advisor) {
            $advisor_type = $advisor->advisor_type;
            break;
        }
        return $advisor_type;
    }



    /*
    // ==================== Activity ====================
    */
    public function getActivityItems($homeroom_id=0, $group_id=0)
    {
        $sql = "SELECT * FROM homeroom_activity_items 
                    WHERE homeroom_id={$homeroom_id} AND group_id={$group_id} AND status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }



    /*
    // ==================== Risk ====================
    */
    public function getRiskItems($homeroom_id=0, $group_id=0)
    {
        $sql = "SELECT * FROM homeroom_risk_items 
                    WHERE homeroom_id={$homeroom_id} AND group_id={$group_id} AND status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }
}
