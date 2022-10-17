<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Homeroomobedience_model extends BaseModel
{
    public $table = null;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->ci->factory_lib->getTable('HomeRoomObedience');
    }

    public function getObediences($homeroom_id=0, $group_id=0)
    {
        //get homeroom item
        $this->ci->load->model('admin/homeroom_model', 'admin_homeroom_model');
        $homeroom_item = $this->ci->admin_homeroom_model->getItem($homeroom_id);

        //get group item
        $group_item = $this->ci->homeroom_lib->getGroupItem($group_id);

        //get action items
        $action_items = $this->ci->homeroom_lib->getActionItems($homeroom_id, $group_id);

        //get Obedience item
        $obedience_item = $this->getItem($homeroom_id, $group_id);

        //get students items by group_id
        $student_items = $this->ci->homeroom_lib->getStudentItems($group_id);

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
            
            $item_group->attachments        = array();
            foreach ($attactment_items as $attachment) {
                $item_file                  = new stdClass();
                $item_file->img_id          = $attachment->id;
                $item_file->img_path        = $attachment->img;

                array_push($item_group->attachments, $item_file);
            }

            array_push($item->groups, $item_group);
        }

        // echo "<pre>";
        // print_r($item);
        // exit();

        return $item;
    }

    public function getAttachments($homeroom_id=0, $group_id=0)
    {
        $sql = 'SELECT * FROM homeroom_obedience_attachments WHERE homeroom_id=' . $homeroom_id.' AND group_id=' . $group_id.' AND status=1';
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function getItem($homeroom_id=0, $group_id=0)
    {
        $items = $this->getItems($homeroom_id, $group_id);

        $id = 0;
        if (count($items)) {
            $id = $items[0]->id;
            $this->table->load($id);
        }
        return $this->table;
    }

    public function getItems($homeroom_id=0, $group_id=0)
    {
        $sql = 'SELECT * 
                    FROM homeroom_obediences
                    WHERE homeroom_id='.$homeroom_id.' AND group_id='.$group_id;
        $query = $this->ci->db->query($sql);
        $items = $query->result();
        return $items;
    }

    public function saveData()
    {
        $obedience_data = $this->ci->input->post();
        $homeroom_id = $this->ci->input->post('homeroom_id', 0);
        $group_id = $this->ci->input->post('group_id', 0);
        $advisor_id = $this->ci->profile_lib->getUserId();
        
        /*
        // upload files
        */
        $file_items = $this->saveFiles();
        $files_data = array();
        foreach ($file_items as $key => $val) {
            if (!is_null($val)) {
                array_push($files_data, array(
                    'homeroom_id'   => $homeroom_id,
                    'group_id'      => $group_id,
                    'img'           => $val,
                    'created_at'    => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at'    => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'status'        => 1
                ));
            }
        }
        if (count($files_data)) {
            // clear old obedience_attachments data
            $this->ci->db->delete('homeroom_obedience_attachments', array('homeroom_id' => $homeroom_id, 'group_id' => $group_id));
            // insert obedience_attachments items
            $this->ci->db->insert_batch('homeroom_obedience_attachments', $files_data);
        }

        /*
        // save obedience data
        */
        $obedience_items = $this->getItems($homeroom_id, $group_id);
        
        $data['advisor_id'] = $advisor_id;
        if (count($obedience_items)) {
            $data['id'] = $obedience_items[0]->id;
            $data['updated_at'] = mdate('%Y-%m-%d %H:%i:%s', time());
        } else {
            $data['created_at'] = mdate('%Y-%m-%d %H:%i:%s', time());
            $data['updated_at'] = mdate('%Y-%m-%d %H:%i:%s', time());
            $data['status'] = 1;
        }

        return $this->save(array_merge($obedience_data, $data));
    }

    private function saveFiles()
    {
        $homeroom_id = $this->ci->input->post('homeroom_id', 0);
        $group_id = $this->ci->input->post('group_id', 0);
        $advisor_id = $this->ci->profile_lib->getUserId();
        
        $config = array();
        $config['upload_path'] = './storage/obediences/';
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['file_name'] = $homeroom_id.'-'.$group_id.'-'.$advisor_id;
        $config['max_size']	= '10240';
        $this->ci->upload->initialize($config);

        $file_items = array(
            'file1' => null,
            'file2' => null
        );
    
        if ($this->ci->upload->do_upload('upload_file_1')) {
            $file1_data = $this->ci->upload->data();
            //resize thumbnail
            $config_photo['image_library'] = 'gd2';
            $config_photo['source_image']	= $config['upload_path'].$file1_data['file_name'];
            $config_photo['new_image'] = $config['upload_path'].'/thumbnail/'.$file1_data['file_name'];
            $config_photo['create_thumb'] = false;
            $config_photo['maintain_ratio'] = true;
            $config_photo['width']	= 1920;
            $config_photo['height']	= 1080;
            $this->ci->image_lib->initialize($config_photo);
            $this->ci->image_lib->resize();
            
            $file_items['file1'] = '/storage/obediences/thumbnail/'.$file1_data['file_name'];
        }

        if ($this->ci->upload->do_upload('upload_file_2')) {
            $file2_data = $this->ci->upload->data();
            //resize thumbnail
            $config_photo['image_library'] = 'gd2';
            $config_photo['source_image']	= $config['upload_path'].$file2_data['file_name'];
            $config_photo['new_image'] = $config['upload_path'].'/thumbnail/'.$file2_data['file_name'];
            $config_photo['create_thumb'] = false;
            $config_photo['maintain_ratio'] = false;
            $config_photo['width']	= 1920;
            $config_photo['height']	= 1080;
            $this->ci->image_lib->initialize($config_photo);
            $this->ci->image_lib->resize();
            
            $file_items['file2'] = '/storage/obediences/thumbnail/'.$file2_data['file_name'];
        }

        return $file_items;
    }
}
