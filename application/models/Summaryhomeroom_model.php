<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Summaryhomeroom_model extends CI_Model
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
            $sql = "SELECT `groups`.`id`, `groups`.`group_name`, `majors`.`major_name` FROM `groups` ,`majors`
        WHERE `groups`.`status`=1 AND `groups`.`id` IN (SELECT `group_id` FROM  `advisors_groups` WHERE `advisor_id`=? AND `status`=1)
        AND `majors`.`id`=`groups`.`major_id`;";
            $query = $this->db->query($sql, $advisor_id);
            $semester->groups = $query->result();
            foreach ($semester->groups as $group) {
                $group->students = $this->_GroupSummaryHomeroom($semester->id, $group->id);
                $group->not_pass = 0;
                $group->pass = 0;

                foreach ($group->students as $std) {
                    $summary = $this->_summary($std);
                    $std->percent = $summary['percent'];
                    if ($summary['result'] === true) {
                        $std->result = '<span class="uk-text-success">ผ่าน</span>';
                        $group->pass++;
                    } else {
                        $std->result = '<span class="uk-text-danger">ไม่ผ่าน</span>';
                        $group->not_pass++;
                    }
                }
                $group->all = $group->pass + $group->not_pass;
            }
        }
        return $data;
    }

    public function report($group_id, $semester_id)
    {
        $sql = "SELECT `groups`.`id`,`groups`.`group_name`,`majors`.`major_name`,`users_advisor`.`user_id`,`users_advisor`.`firstname`,
        `users_advisor`.`lastname`,`users_advisor`.`signature`,`semester`.`name` AS semester_name
        FROM `groups`
        LEFT JOIN `majors` ON `majors`.`id`=`groups`.`major_id`
        LEFT JOIN `advisors_groups` ON `advisors_groups`.`group_id`=`groups`.`id` 
            AND `advisors_groups`.`advisor_type`='advisor' AND `advisors_groups`.`status`=1
        LEFT JOIN `users_advisor` ON `advisors_groups`.`advisor_id`=`users_advisor`.`user_id`
        LEFT JOIN `semester` ON `semester`.`id`=?
        WHERE `groups`.`status`=1 AND `groups`.`id`=?;";
        $query = $this->db->query($sql, array($semester_id, $group_id));
        $data = $query->row();
            $data->students = $this->_GroupSummaryHomeroom($semester_id, $data->id);
            $data->not_pass = 0;
            $data->pass = 0;

            foreach ($data->students as $std_row) {
                $summary = $this->_summary($std_row);
                $std_row->percent = $summary['percent'];
                if ($summary['result'] === true) {
                    $std_row->result = '<span style="color: #198754;">ผ่าน</span>';
                    $data->pass++;
                } else {
                    $std_row->result = '<span style="color: #dc3545;">ไม่ผ่าน</span>';
                    $data->not_pass++;
                }
            }
            $data->all = $data->pass + $data->not_pass;

        return $data;
    }

    public function _GroupSummaryHomeroom($semester_id, $group_id)
    {
        $sql = "SELECT `users_student`.`user_id`, `users_student`.`firstname`, `users_student`.`lastname`, `users_student`.`student_id`, 
            SUM(CASE WHEN `homeroom_activity_items`.`check_status` = 'come' THEN 1 ELSE 0 END) AS 'come', 
            SUM(CASE WHEN `homeroom_activity_items`.`check_status` = 'late' THEN 1 ELSE 0 END) AS 'late', 
            SUM(CASE WHEN `homeroom_activity_items`.`check_status` = 'leave' THEN 1 ELSE 0 END) AS 'leave', 
            SUM(CASE WHEN `homeroom_activity_items`.`check_status` = 'not_come' THEN 1 ELSE 0 END) AS 'not_come',
            COUNT(`homeroom_activity_items`.`check_status`) AS 'sum'
            FROM `users_student` 
            LEFT JOIN `homeroom_activity_items`
            ON `homeroom_activity_items`.`student_id`=`users_student`.`user_id`
            AND `homeroom_activity_items`.`homeroom_id` IN (SELECT `id` FROM `homerooms` WHERE `semester_id`=?)
            WHERE `users_student`.`group_id`=? AND `users_student`.`status`=1
            GROUP BY `users_student`.`user_id`;";
        $query = $this->db->query($sql, array($semester_id, $group_id));
        return $query->result();
    }

    public function _summary($std)
    {
        $come_sum = $std->sum - ($std->late / 4 + $std->leave / 2 + $std->not_come);
        if ($std->sum != 0) {
            $data['percent'] = round($come_sum / $std->sum * 100);
        } else {
            $data['percent'] = 0;
        }

        if ($data['percent'] >= 60) {
            $data['result'] = true;
            return $data;
        } else {
            $data['result'] = false;
            return $data;
        }
    }
}
