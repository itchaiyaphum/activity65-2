<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Activity_summary_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index($advisor_id)
    {
        $sql_semester = "SELECT * FROM `semester` WHERE `status`=1 ORDER BY `id` DESC;";
        $qr_semester = $this->db->query($sql_semester);
        $data = $qr_semester->result();
        foreach ($data as $semester) {
            $sql = "SELECT `groups`.`id`, `groups`.`group_code`, `groups`.`group_name`, `majors`.`major_name`, `minors`.`minor_name` FROM `advisors_groups` 
            LEFT JOIN `groups` ON `groups`.`id`=`advisors_groups`.`group_id`
            LEFT JOIN `majors` ON `groups`.`major_id`=`majors`.`id`
            LEFT JOIN `minors` ON `groups`.`minor_id`=`minors`.`id`
            WHERE `advisors_groups`.`advisor_id`=? AND `advisors_groups`.`advisor_type`='advisor' AND `advisors_groups`.`status`=1;";
            $query = $this->db->query($sql, $advisor_id);
            $semester->group_list = $query->result();
        }
        return $data;
    }
    public function activity($group_id, $semester_id)
    {
        $data = $this->_group_data($group_id);
        $data->students = $this->_students_list($group_id, $semester_id);
        return $data;
    }

    public function advisor_save()
    {
        $in = $this->input->post();
        $semester_id = $this->input->get('semester_id');
        $data = array();
        foreach ($in as $name => $std) {
            foreach ($std as $student_id => $val) {
                $data[$student_id]['student_id'] = $student_id;
                $data[$student_id]["{$name}"] = $val;
                $data[$student_id]["updated_at"] = date('Y-m-d H:i:s');
                // $data[$student_id] = array_merge ($data,array(
                //     'student_id' => $student_id,
                //     'flagpole' => $student_id,
                //     "{$name}" => $val,
                //     'updated_at' => date('Y-m-d H:i:s')
                // ));
            }
        }
        $sql = "INSERT INTO `activity_summary_items`
        (`semester_id`, `student_id`, `flagpole`, `club`, `homeroom`, `special`,`boy_scout`, `updated_at`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE 
        student_id=VALUES(student_id),
        flagpole=VALUES(flagpole),
        club=VALUES(club),
        homeroom=VALUES(homeroom),
        special=VALUES(special),
        boy_scout=VALUES(boy_scout),
        updated_at=VALUES(updated_at)";
        foreach ($data as $data_r) {
            $data_r = array(
                'semester_id' => $semester_id,
                'student_id' => $data_r['student_id'],
                'flagpole' => isset($data_r['flagpole']) ? $data_r['flagpole'] : null,
                'club' => isset($data_r['club']) ? $data_r['club'] : null,
                'homeroom' => isset($data_r['homeroom']) ? $data_r['homeroom'] : null,
                'special' => isset($data_r['special']) ? $data_r['special'] : null,
                'boy_scout' => isset($data_r['boy_scout']) ? $data_r['boy_scout'] : null,
                'updated_at' => $data_r['updated_at']
            );
            $this->db->query($sql, $data_r);
        }

        $this->_actions_save(
            $semester_id    = $semester_id,
            $group_id       = $this->input->get('group_id'),
            $user_id        = $this->session->user_id,
            $user_type      = 'advisor',
            $action_status  = 'save',
            $activity       = 'advisor_check'
        );
    }

    public function SemesterData($semester_id=null) {
        if ($semester_id==null) {
            $sql = "SELECT * FROM `semester` WHERE `status`=1 ORDER BY `id` DESC;";
            $query = $this->db->query($sql);
            return $query->result();
        } else {
            $sql = "SELECT * FROM `semester` WHERE `status`=1 AND `id`=? ORDER BY `id` DESC;";
            $query = $this->db->query($sql, $semester_id);
            return $query->row();
        }
        
        
    }

    public function std_homeroom($student_id, $semester_id)
    {
        $sql = "SELECT 
        SUM(CASE WHEN `homeroom_activity_items`.`check_status` = 'come' THEN 1 ELSE 0 END) AS 'come', 
        SUM(CASE WHEN `homeroom_activity_items`.`check_status` = 'late' THEN 1 ELSE 0 END) AS 'late', 
        SUM(CASE WHEN `homeroom_activity_items`.`check_status` = 'leave' THEN 1 ELSE 0 END) AS 'leave', 
        SUM(CASE WHEN `homeroom_activity_items`.`check_status` = 'not_come' THEN 1 ELSE 0 END) AS 'not_come',
        COUNT(`homeroom_activity_items`.`check_status`) AS 'sum'
        FROM `homeroom_activity_items` 
        INNER JOIN `homerooms` ON `homerooms`.`id`=`homeroom_activity_items`.`homeroom_id`
        WHERE `homeroom_activity_items`.`student_id`=?
        AND `homerooms`.`semester_id`=?
        AND `homeroom_activity_items`.`status`=1 
        GROUP BY `student_id`;";
        $query = $this->db->query($sql, array($student_id, $semester_id));
        $result = $query->row();
        if (empty($result)) {
            return false;
        }
        $this->load->model('summaryhomeroom_model', 'summaryhomeroom');
        $data = $this->summaryhomeroom->_summary($result);
        return $data['result'];
    }

    public function _group_data($group_id)
    {
        $sql = "SELECT `groups`.`id`, `groups`.`group_code`, `groups`.`group_name`, `majors`.`major_name`, `minors`.`minor_name` FROM `groups` 
        LEFT JOIN `majors` ON `groups`.`major_id`=`majors`.`id`
        LEFT JOIN `minors` ON `groups`.`minor_id`=`minors`.`id`
        WHERE `groups`.`id`=?;";
        $query = $this->db->query($sql, $group_id);
        $data = $query->row();
        return $data;
    }
    public function _students_list($group_id, $semester_id)
    {
        $sql = "SELECT `users_student`.`user_id`,`users_student`.`firstname`,`users_student`.`lastname`,`users_student`.`student_id` as std_code,
        `activity_summary_items`.*
        FROM `users_student`
        LEFT JOIN `activity_summary_items` 
        ON `activity_summary_items`.`student_id`=`users_student`.`user_id` AND `activity_summary_items`.`semester_id`=? 
        WHERE `users_student`.`group_id`=? AND `users_student`.`status`=1;";
        $query = $this->db->query($sql, array($semester_id, $group_id));
        $data = $query->result();
        return $data;
    }
    public function _actions_save($semester_id, $group_id,$user_id,$user_type,$action_status,$activity)
    {
        $check = $this->_SaveCheck($group_id, $semester_id, $activity);
        if (!isset($check->id)) {
            $sql = "INSERT INTO `activity_summary_actions`(`group_id`, `user_id`, `semester_id`, `user_type`, `action_status`, `activity`, `created_at`, `updated_at`, `status`) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW(), 1)";
            $this->db->query($sql, array($group_id,$user_id,$semester_id,$user_type,$action_status,$activity));
        } else {
            $sql = "UPDATE `activity_summary_actions` SET `group_id`=?,`user_id`=?, `semester_id`=?, `user_type`=?,`action_status`=?,`activity`=?,`updated_at`=NOW(),`status`=1 WHERE `id`=?";
            $this->db->query($sql, array($group_id,$user_id,$semester_id,$user_type,$action_status,$activity, $check->id));
        }
    }

    public function _SaveCheck($group_id,$semester_id, $activity)
    {
        $sql = "SELECT * FROM `activity_summary_actions` 
        WHERE `group_id`=? AND `semester_id`=? AND `activity`=? AND `status`=1;";
        $query = $this->db->query($sql, array($group_id, $semester_id, $activity));
        $data = $query->row();
        return $data;
    }

    public function AdvisorIndedxButton($group_id, $semester_id, $user_type = 'advisor')
    {
        $check = $this->_SaveCheck($group_id, $semester_id, 'advisor_check');
        $link = site_url($user_type.'/activity_summary/activity')."?group_id={$group_id}&semester_id={$semester_id}";
        if (isset($check->id)) {
            if ($check->action_status == 'save') {
                return "<a href='{$link}' class='uk-button uk-button-success uk-button-small'><i class='uk-icon-eye'></i> เรียกดูข้อมูล</a>";
            } else {
                return "<a href='{$link}' class='uk-button uk-button-primary uk-button-small'><i class='uk-icon-pencil'></i> บันทึกข้อมูล</a>";
            }
        } else {
            return "<a href='{$link}' class='uk-button uk-button-primary uk-button-small'><i class='uk-icon-pencil'></i> บันทึกข้อมูล</a>";
        }
    }
    public function AdvisorSaveButton($group_id, $semester_id, $user_type = 'advisor')
    {
        $check = $this->_SaveCheck($group_id, $semester_id, 'advisor_check');
        if (isset($check->id)) {
            if ($check->action_status == 'save') {
                return '<button class="uk-button uk-button-success uk-button-large uk-width-large-1-4 uk-margin-top" data-uk-modal="{target:\'#confirm-form\'}">บันทึกข้อมูลอีกครั้ง</button>';
            } else {
                return '<button class="uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top" data-uk-modal="{target:\'#confirm-form\'}">กดบันทึกข้อมูล</button>';
            }
        } else {
            return '<button class="uk-button uk-button-primary uk-button-large uk-width-large-1-4 uk-margin-top" data-uk-modal="{target:\'#confirm-form\'}">กดบันทึกข้อมูล</button>';
        }
    }

    public function PrintButton($group_id, $semester_id, $user_type = 'advisor')
    {
        $check = $this->_SaveCheck($group_id, $semester_id, 'advisor_check');
        $link = site_url($user_type.'/activity_summary/report')."?group_id={$group_id}&semester_id={$semester_id}";
        if (isset($check->id)) {
            if ($check->action_status == 'save') {
                return "<a href='{$link}' class='uk-button uk-button-small' target='_blank'><i class='uk-icon-print'></i> พิมพ์ อวท.15</a>";
            } else {
                return "<button type='button' class='uk-button uk-button-small' disabled><i class='uk-icon-print'></i> พิมพ์ อวท.15</button>";
            }
        } else {
            return "<button type='button' class='uk-button uk-button-small' disabled><i class='uk-icon-print'></i> พิมพ์ อวท.15</button>";
        }
    }
    
    public function AdvisorPrint($group_id, $semester_id)
    {
        $sql = "SELECT `groups`.`group_code`, `groups`.`group_name`,
        `majors`.`major_code`, `majors`.`major_name`,
        `semester`.`name` AS semester_name
        FROM `groups` 
        LEFT JOIN `majors` ON `majors`.`id` = `groups`.`major_id`
        LEFT JOIN `semester` ON `semester`.`id`=?
        WHERE `groups`.`id`=?;";
        $query = $this->db->query($sql, array($semester_id, $group_id));
        $data = $query->row();

        $sql_data = "SELECT `activity_summary_items`.*, `users_student`.`firstname`, `users_student`.`lastname`, `users_student`.`student_id` AS student_code
        FROM `activity_summary_items` 
        INNER JOIN `users_student` ON `users_student`.`user_id`=`activity_summary_items`.`student_id`
        WHERE `users_student`.`group_id`=? AND `activity_summary_items`.`semester_id`=?;";
        $qr_data = $this->db->query($sql_data, array($group_id, $semester_id));
        $data->students = $qr_data->result();

        return $data;
    }
}
