<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Reporthomeroom_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('profile_lib');
    }
    public function index()
    {
        $sql_semester = "SELECT * FROM `semester` WHERE `status`=1 ORDER BY `id` DESC;";
        $qr_semester = $this->db->query($sql_semester);
        $data = $qr_semester->result();
        $c = 0;
        foreach ($data as $semester) {
            $user_id = $this->session->user_id;
            $qr_week = $this->db->query("SELECT * FROM `homerooms` WHERE `status` = 1 AND `semester_id`={$semester->id}");
            $semester->week = $qr_week->result();

            foreach ($semester->week as $week) {

                $qr_group = $this->db->query("SELECT * FROM `groups` WHERE `status`=1 AND `id` IN (SELECT `group_id` FROM `advisors_groups` WHERE `advisor_id`='$user_id' AND `status`=1)");
                $re_group = $qr_group->result();

                $week->group = $re_group;
                foreach ($week->group as $key => $group) {

                    if ($this->session->user_type == 'advisor') {
                        $qr_advisor = $this->db->query("SELECT * FROM `homeroom_actions` WHERE `group_id` = $group->id AND `homeroom_id` = $week->id AND `user_type` = 'advisor' AND `action_status` = 'confirmed' AND `status` = 1");
                        $advisor_num_rows = $qr_advisor->num_rows();

                        if ($advisor_num_rows == 1) {
                            $group->advisor_check = '<i class="uk-icon-check uk-text-success"></i>';
                            $advisor_confirm = TRUE;
                        } else {
                            $group->advisor_check = '<i class="uk-icon-close uk-text-danger"></i>';
                            $advisor_confirm = FALSE;
                        }
                    } elseif ($this->session->user_type == 'headdepartment') {
                        $qr_advisor = $this->db->query("SELECT * FROM `homeroom_actions` WHERE `group_id` = $group->id AND `homeroom_id` = $week->id AND `user_type` = 'headdepartment' AND `action_status` = 'confirmed' AND `status` = 1");
                        $advisor_num_rows = $qr_advisor->num_rows();

                        if ($advisor_num_rows == 1) {
                            $group->advisor_check = '<i class="uk-icon-check uk-text-success"></i>';
                            $advisor_confirm = TRUE;
                        } else {
                            $group->advisor_check = '<i class="uk-icon-close uk-text-danger"></i>';
                            $advisor_confirm = FALSE;
                        }
                    }

                    $qr_headdepartment = $this->db->query("SELECT * FROM `homeroom_actions` WHERE `group_id` = $group->id AND `homeroom_id` = $week->id AND `user_type` = 'headdepartment' AND `action_status` = 'confirmed' AND `status` = 1");
                    $headdepartment_num_rows = $qr_headdepartment->num_rows();
                    if ($headdepartment_num_rows == 1) {
                        $group->headdepartment_check = '<i class="uk-icon-check uk-text-success"></i>';
                        $headdepartment_confirm = TRUE;
                    } else {
                        $group->headdepartment_check = '<i class="uk-icon-close uk-text-danger"></i>';
                        $headdepartment_confirm = FALSE;
                    }

                    $qr_headadvisor = $this->db->query("SELECT * FROM `homeroom_actions` WHERE `group_id` = $group->id AND `homeroom_id` = $week->id AND `user_type` = 'headadvisor' AND `action_status` = 'confirmed' AND `status` = 1");
                    $headadvisor_num_rows = $qr_headadvisor->num_rows();
                    if ($headadvisor_num_rows == 1) {
                        $group->headadvisor_check = '<i class="uk-icon-check uk-text-success"></i>';
                        $headadvisor_confirm = TRUE;
                    } else {
                        $group->headadvisor_check = '<i class="uk-icon-close uk-text-danger"></i>';
                        $headadvisor_confirm = FALSE;
                    }

                    $qr_executive = $this->db->query("SELECT * FROM `homeroom_actions` WHERE `group_id` = $group->id AND `homeroom_id` = $week->id AND `user_type` = 'executive' AND `action_status` = 'confirmed' AND `status` = 1");
                    $executive_num_rows = $qr_executive->num_rows();
                    if ($executive_num_rows == 1) {
                        $group->executive_check = '<i class="uk-icon-check uk-text-success"></i>';
                        $executive_confirm = TRUE;
                    } else {
                        $group->executive_check = '<i class="uk-icon-close uk-text-danger"></i>';
                        $executive_confirm = FALSE;
                    }
                    // $advisor_confirm && $headdepartment_confirm && $headadvisor_confirm && $executive_confirm
                    if ($advisor_confirm && $headdepartment_confirm && $headadvisor_confirm && $executive_confirm) {
                        $group->checkbox = "<input type='checkbox' class='week-checkbox{$semester->id}' name='week[]' value='{$week->id},{$group->id}' style='transform: scale(1.5);'>";
                    } else {
                        $group->checkbox = '<input type="checkbox" style="transform: scale(1.5);" disabled>';
                    }
                }
            }
        }
        return $data;
    }


    public function data()
    {

        $this->load->library('tothai');
        $user_id = $this->session->user_id;
        $select = $this->input->post('week');
        foreach ($select as $value) {
            $select_r[] = explode(",", $value);
        }
        foreach ($select_r as $value) {
            $week_i[] = $value[0];
            $week_group[$value[0]][] = $value[1];
        }

        $week_r = implode(', ', array_unique($week_i));

        $qr_week = $this->db->query("SELECT * FROM `homerooms` WHERE `status` = 1 AND `id` IN (SELECT `homeroom_actions`.`homeroom_id` FROM `homeroom_actions` WHERE `homeroom_actions`.`homeroom_id` IN ($week_r) AND `homeroom_actions`.`user_id` = $user_id AND `homeroom_actions`.`action_status` = 'confirmed')");
        $data['week'] = $qr_week->result();

        foreach ($data['week'] as $week) {


            $group_r = implode(', ', $week_group[$week->id]);
            $qr_group = $this->db->query("SELECT * FROM `advisors_groups` 
                INNER JOIN `groups` ON `groups`.`id`=`advisors_groups`.`group_id` 
                INNER JOIN `majors` ON `majors`.`id`=`groups`.`major_id`
                WHERE `advisors_groups`.`advisor_id`= {$user_id}  AND `advisors_groups`.`group_id` IN ({$group_r}) AND `advisors_groups`.`status`=1;");
            $week->group = $qr_group->result();
            foreach ($week->group as $group) {

                $group->data = true;

                $class = strtolower($group->group_name[0]);
                $group->level_group = ($class == 'd' || $class == 'e') ? 'ปวส.' : 'ปวช.';



                $qr_date = $this->db->query("SELECT * FROM `homeroom_actions` WHERE `homeroom_id` = ? AND `user_id` = ?;", array($week->id, $user_id));
                $date = $qr_date->result();

                $dateth['d'] = $this->tothai->toThaiDateTime($date[0]->created_at, '%d');
                $dateth['m'] = $this->tothai->toThaiDateTime($date[0]->created_at, '%m');
                $dateth['y'] = $this->tothai->toThaiDateTime($date[0]->created_at, '%y');
                $group->thaidate = $dateth;

                $qr_ck_std = $this->db->query("SELECT * FROM `homeroom_activity_items` WHERE `group_id` IN (" . $group->group_id . ") AND `homeroom_id`= $week->id");
                $ck_std = $qr_ck_std->result();
                $group->std_all = 0;
                $group->std_come = 0;
                $group->std_notcome = 0;
                foreach ($ck_std as $ck) {
                    $group->std_all++;
                    if ($ck->check_status == 'come') {
                        $group->std_come++;
                    } else {
                        $group->std_notcome++;
                    }
                }

                $qr_advisor = $this->db->query("SELECT * FROM `advisors_groups`
INNER JOIN `users_advisor`
ON `users_advisor`.`user_id`=`advisors_groups`.`advisor_id`
AND `advisors_groups`.`group_id`= " . $week->group[0]->group_id . "
AND `advisors_groups`.`status` = 1
ORDER BY `advisors_groups`.`advisor_type` ASC");
                $group->re_advisor = $qr_advisor->result();
                $group->advisor_name = null;
                $advisor_num = 1;
                foreach ($group->re_advisor as $advisor) {
                    $group->advisor_name .= '
    <div>' . $this->tothai->thainum($advisor_num++) . '. ' . $advisor->firstname . ' ' . $advisor->lastname . '</div>
    ';
                    $advisor->signature = $this->profile_lib->getUserData($advisor->user_id, 'signature');
                }

                $qr_obediences = $this->db->query("SELECT * FROM `homeroom_obediences` WHERE `group_id` = $group->group_id AND `homeroom_id` = $week->id AND `status` = 1");
                $obediences = $qr_obediences->result();
                $group->obedience = mb_substr($obediences[0]->obe_detail, 0, 450, 'UTF-8');

                $qr_obediences_img = $this->db->query("SELECT * FROM `homeroom_obedience_attachments` WHERE `group_id` = $group->group_id AND `homeroom_id` = $week->id AND `status` = 1");
                $group->obediences_img = $qr_obediences_img->result();

                $qr_risk = $this->db->query("SELECT * FROM `homeroom_risk_items`
INNER JOIN `users_student`
ON `users_student`.`user_id`=`homeroom_risk_items`.`student_id`
AND `homeroom_risk_items`.`group_id` IN (" . $group->group_id . ") AND `homeroom_risk_items`.`homeroom_id`=$week->id AND `homeroom_risk_items`.`risk_status`='risk'");
                $group->risk = $qr_risk->result();

                $qr_headdepartment = $this->db->query("SELECT * FROM `homeroom_actions`
        INNER JOIN `users_headdepartment`
        ON `homeroom_actions`.`user_id`=`users_headdepartment`.`user_id`
        AND `homeroom_actions`.`group_id`= " . $group->group_id . " AND `homeroom_actions`.`action_status`='confirmed'
        AND `homeroom_actions`.`homeroom_id`=$week->id");
                $group->headdepartment = $qr_headdepartment->row();
                $group->headdepartment->signature = $this->profile_lib->getUserData($group->headdepartment->user_id, 'signature');

                $qr_headadvisor = $this->db->query("SELECT * FROM `homeroom_actions`
        INNER JOIN `users_headadvisor`
        ON `homeroom_actions`.`user_id`=`users_headadvisor`.`user_id`
        AND `homeroom_actions`.`group_id`= " . $group->group_id . " AND `homeroom_actions`.`action_status`='confirmed'
        AND `homeroom_actions`.`homeroom_id`=$week->id");
                $group->headadvisor = $qr_headadvisor->row();
                $group->headadvisor->signature = $this->profile_lib->getUserData($group->headadvisor->user_id, 'signature');

                $qr_executive = $this->db->query("SELECT * FROM `homeroom_actions`
        INNER JOIN `users_executive`
        ON `homeroom_actions`.`user_id`=`users_executive`.`user_id`
        AND `homeroom_actions`.`group_id`= " . $group->group_id . " AND `homeroom_actions`.`action_status`='confirmed'
        AND `homeroom_actions`.`homeroom_id`=$week->id");
                $group->executive = $qr_executive->row();
                $group->executive->signature = $this->profile_lib->getUserData($group->executive->user_id, 'signature');
            }
        }

        return $data;
    }
}
