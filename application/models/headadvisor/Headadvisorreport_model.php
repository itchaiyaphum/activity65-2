<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Headadvisorreport_model extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getHomeroomItems()
    {
        $sql = "SELECT homerooms.*, semester.name as semester_name FROM homerooms 
                    LEFT JOIN semester ON (homerooms.semester_id=semester.id)
                    WHERE homerooms.status=1 ORDER BY homerooms.week ASC";
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

    public function getSemesterItems()
    {
        $sql = "SELECT * FROM semester WHERE status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getMinorItems($major_id=0)
    {
        $sql = "SELECT * FROM minors WHERE major_id={$major_id} AND status=1";
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getGroupItems($major_id=0)
    {
        $sql = "SELECT * FROM groups WHERE major_id={$major_id} AND status=1";
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

    public function getApproving($major_id=0)
    {
        $filter_semester = $this->ci->input->get_post('headadvisor_filter_semester');
        $filter_major = $this->ci->input->get_post('headadvisor_filter_major');
        $filter_type = $this->ci->input->get_post('headadvisor_filter_type');

        $items = array();

        if ($filter_semester=="" || $filter_major=="" || $filter_type=="") {
            return $items;
        }

        //get homeroom item
        $homeroom_items = $this->getHomeroomItems();

         //get semester items
         $semester_items = $this->getSemesterItems();
        
        //get major item
        $this->ci->load->model('admin/major_model', 'admin_major_model');
        $major_item = $this->ci->admin_major_model->getItem($filter_major);
        
        //get minor items
        $this->ci->load->model('admin/minor_model', 'admin_minor_model');
        $minor_items = $this->getMinorItems($filter_major);
        
        //get advisor_group items
        $advisor_group_items = $this->getAdvisorGroupItems();

        //get group items
        $group_items = $this->getGroupItems($filter_major);

        //get action items
        $action_items = $this->getAllActionItems();

        foreach ($semester_items as $semester) {
            $item = new stdClass();
            $item->semester_id          = $semester->id;
            $item->semester_name        = $semester->name;
            $item->majors               = array();

            $item_major                 = new stdClass();
            $item_major->major_id       = $major_item->id;
            $item_major->major_name     = $major_item->major_name;
            $item_major->minors         = array();

            foreach ($minor_items as $minor) {
                $item_minor                 = new stdClass();
                $item_minor->minor_id       = $minor->id;
                $item_minor->minor_name     = $minor->minor_name;
                $item_minor->groups         = array();

                foreach ($group_items as $group) {
                    if ($group->major_id==$major_item->id && $group->minor_id==$minor->id) {
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

                                $item_advisor->stats_num_homeroom   = count($homeroom_items);
                                $item_advisor->stats_num_checked_percent    = 0;

                                $item_advisor->homerooms            = array();

                                $tmp_stats_num_checked      = 0;

                                foreach ($homeroom_items as $homeroom) {
                                        $item_homeroom              = new stdClass();
                                        $item_homeroom->id          = $homeroom->id;
                                        $item_homeroom->week        = $homeroom->week;
                                        $item_homeroom->is_check    = 0;
                                        $item_homeroom->approving   = array();
                                        
                                        foreach ($action_items as $action) {
                                            if ($action->homeroom_id==$homeroom->id && $action->group_id==$group->id && $action->user_id==$advisor_group->advisor_id) {
                                                $item_approving                         = new stdClass();
                                                $item_approving->advisor_id             = $action->user_id;
                                                $item_approving->advisor_type           = $action->user_type;
                                                $item_approving->advisor_status         = $action->action_status;

                                                $item_homeroom->is_check                = 1;
                                                $tmp_stats_num_checked                  += 1;

                                                array_push($item_homeroom->approving, $item_approving);
                                            }
                                        }

                                        array_push($item_advisor->homerooms, $item_homeroom);
                                }

                                $item_advisor->stats_num_checked_percent    = ($tmp_stats_num_checked/$item_advisor->stats_num_homeroom)*100;

                                array_push($item_group->advisors, $item_advisor); 
                            }
                        }

                         array_push($item_minor->groups, $item_group);
                    }
                }
                
                array_push($item_major->minors, $item_minor);
                
            }

            array_push($item->majors, $item_major);

            array_push($items, $item);
        }

        // echo "<pre>";
        // print_r($items);
        // exit();

        return $items;

    }

}
