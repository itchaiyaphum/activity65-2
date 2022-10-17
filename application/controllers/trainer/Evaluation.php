<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'trainer' . DIRECTORY_SEPARATOR . 'BaseController.php';

class Evaluation extends BaseController
{

    public function index()
    {
        $profile = $this->profile_lib->getData();
        $trainer_id = $profile->user_id;
        
        $items = array();
        
        // Time Items
        $sql = "SELECT * FROM time ";
        $query = $this->db->query($sql);
        $items['time_items'] = $query->result();
        
        // Activity Items
        $sql = "SELECT * FROM activity ";
        $query = $this->db->query($sql);
        $items['activity_items'] = $query->result();
        
        // Student Items
        $sql = "SELECT u.* FROM users as u
                LEFT JOIN users_student as us ON(us.user_id=u.id)
                    WHERE u.user_type='student' AND us.trainer_id={$trainer_id} ";
        $query = $this->db->query($sql);
        $items['student_items'] = $query->result();
        
        
        $data = array();
        $data['leftmenu'] = $this->load->view('trainer/menu', '', true);
        $data['data'] = $this->renderViewIndexData($items);
        
        $this->load->view('nav');
        $this->load->view('trainer/evaluation/index', $data);
        $this->load->view('footer');
    }
    
    private function renderViewIndexData($items=array()){
        //get items data
        $student_items = $items['student_items'];
        $time_items = $items['time_items'];
        $activity_items = $items['activity_items'];
    
        // calculation
    
        // define summary stats
        $total_student = count($student_items);
        $total_come = 0;
        $total_late = 0;
        $total_not_come = 0;
        $total_leave = 0;
        $total_all = 0;
        $total_advisor_check = 0;
        $total_advisor_not_check = 0;
        $total_student_activity = 0;
        $total_student_not_activity = 0;
        $total_trainer_confirm = 0;
        $total_trainer_not_confirm = 0;
    
        $stats = array();
        for($i=0; $i<$total_student; $i++){
            $student = $student_items[$i];
    
            $num_come = 0;
            $num_late = 0;
            $num_not_come = 0;
            $num_leave = 0;
            $num_total = 0;
    
            $advisor_time_check = 0;
            $advisor_time_not_check = 0;
            $advisor_activity_check = 0;
            $advisor_activity_not_check = 0;
    
            $advisor_check_percentage = 0;
            $student_activity = 0;
            $student_not_activity = 0;
            $student_activity_percentage = 0;
    
            $trainer_time_confirm = 0;
            $trainer_time_not_confirm = 0;
            $trainer_activity_confirm = 0;
            $trainer_activity_not_confirm = 0;
    
            $trainer_confirm_percentage = 0;
    
            // calculate stats (time) each student
            for($j=0; $j<count($time_items); $j++){
                if($time_items[$j]->user_id==$student->id){
                    // calculate: come
                    $num_come++;
    
                    // calculate: not come
                    // calculate: late
                    // calculate: leave
    
                    // calculate: advisor check
                    if($time_items[$j]->advisor_check_status==1){
                        $advisor_time_check++;
                    }else{
                        $advisor_time_not_check++;
                    }
    
                    // calculate: trainer confirm
                    if($time_items[$j]->trainer_confirm_status==1){
                        $trainer_time_confirm++;
                    }else{
                        $trainer_time_not_confirm++;
                    }
                }
            }
    
            // calculate stats (activity) each student
            for($j=0; $j<count($activity_items); $j++){
                if($activity_items[$j]->user_id==$student->id){
                    // calculate: activity save
                    $student_activity++;
    
                    // calculate: advisor check
                    if($activity_items[$j]->advisor_check_status==1){
                        $advisor_activity_check++;
                    }else{
                        $advisor_activity_not_check++;
                    }
    
                    // calculate: trainer confirm
                    if($activity_items[$j]->trainer_confirm_status==1){
                        $trainer_activity_confirm++;
                    }else{
                        $trainer_activity_not_confirm++;
                    }
                }
            }
    
            $num_total = $num_come;
    
            // summary stats
            $total_come += $num_come;
            $total_late += $num_late;
            $total_not_come += $num_not_come;
            $total_leave += $num_leave;
            $total_all += $num_total;
    
            $advisor_check = ($advisor_time_check + $advisor_activity_check);
            $advisor_not_check = ($advisor_time_not_check + $advisor_activity_not_check);
            $trainer_confirm = ($trainer_time_confirm + $trainer_activity_confirm);
            $trainer_not_confirm = ($trainer_time_not_confirm + $trainer_activity_not_confirm);
    
            $total_advisor_check += $advisor_check;
            $total_advisor_not_check += $advisor_not_check;
            $total_student_activity += $student_activity;
            $total_student_not_activity += (($advisor_time_check+$advisor_time_not_check)-$student_activity);
            $total_trainer_confirm += $trainer_confirm;
            $total_trainer_not_confirm += $trainer_not_confirm;
    
            $advisor_check_percentage = ($advisor_check/($advisor_check+$advisor_not_check)) * 100;
            $student_activity_percentage = ($student_activity/($advisor_time_check+$advisor_time_not_check)) * 100;
            $trainer_confirm_percentage = ($trainer_confirm/($trainer_confirm+$trainer_not_confirm)) * 100;
    
            // mapping data
            $stat = new stdClass();
            $stat->student_id = $student->id;
            $stat->student_name = $student->firstname." ".$student->lastname;;
            $stat->come = $num_come;
            $stat->not_come = $num_not_come;
            $stat->late = $num_late;
            $stat->leave = $num_leave;
            $stat->total = $num_total;
            $stat->advisor_check_percentage = $advisor_check_percentage;
            $stat->student_activity_percentage = $student_activity_percentage;
            $stat->trainer_confirm_percentage = $trainer_confirm_percentage;
            array_push($stats, $stat);
        }
    
        $total_advisor_check_percentage = ($total_advisor_check/($total_advisor_check+$total_advisor_not_check)) * 100;
        $total_student_activity_percentage = ($total_student_activity/($total_student_activity+$total_student_not_activity)) * 100;
        $total_trainer_confirm_percentage = ($total_trainer_confirm/($total_trainer_confirm+$total_trainer_not_confirm)) * 100;
    
        // totals
        $totals = new stdClass();
        $totals->come = $total_come;
        $totals->not_come = $total_not_come;
        $totals->late = $total_late;
        $totals->leave = $total_leave;
        $totals->total = $total_all;
        $totals->advisor_check = $total_advisor_check;
        $totals->student_activity = $total_student_activity;
        $totals->trainer_confirm = $total_trainer_confirm;
        $totals->advisor_check_percentage = $total_advisor_check_percentage;
        $totals->student_activity_percentage = $total_student_activity_percentage;
        $totals->trainer_confirm_percentage = $total_trainer_confirm_percentage;
    
        //mapping data
        $data = new stdClass();
        $data->stats = $stats;
        $data->totals = $totals;
    
        return $data;
    }
    
}
