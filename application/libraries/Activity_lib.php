<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activity_lib
{

    public $ci = null;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->library('upload');
        $this->ci->load->library('image_lib');
    }

    public function save($data)
    {
        $this->ci->db->where('user_id', $data['user_id']);
        $this->ci->db->where('day', $data['day']);
        $this->ci->db->where('week', $data['week']);
        $query = $this->ci->db->get('activity');
        if ($query->num_rows()){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $data['user_id']);
            $this->ci->db->where('day', $data['day']);
            $this->ci->db->where('week', $data['week']);
            if ($this->ci->db->update('activity', $data)) {
                $this->saveFiles($data);
                $this->savePhotos($data);
                return array(
                    'user_id' => $data['user_id']
                );
            }
        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('activity', $data)) {
                $user_id = $this->ci->db->insert_id();
                $this->saveFiles($data);
                $this->savePhotos($data);
                return array(
                    'user_id' => $user_id
                );
            }
        }
        return NULL;
    }
    
    private function savePhotos($data){
        $config = array();
        $config['upload_path'] = './storage/photos/';
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['file_name'] = md5(microtime());
        $config['max_size']	= '10240';
        
        $this->ci->upload->initialize($config);
        
        if($this->ci->upload->do_upload('photo1')){
            $photo1_data = $this->ci->upload->data();
            $this->ci->db->insert('attachment_photos', array(
                'file_name' => $photo1_data['file_name'],
                'file_ext' => $photo1_data['file_ext'],
                'orig_name' => $photo1_data['client_name'],
                'internship_id' => $data['internship_id'],
                'user_id' => $data['user_id'],
                'week' => $data['week'],
                'day' => $data['day'],
            ));
            
            //reset photo
            $config_photo['image_library'] = 'gd2';
            $config_photo['source_image']	= $config['upload_path'].$photo1_data['file_name'];
            $config_photo['create_thumb'] = FALSE;
            $config_photo['maintain_ratio'] = TRUE;
            $config_photo['width']	= 1024;
            $config_photo['height']	= 1024;
            $this->ci->image_lib->initialize($config_photo);
            $this->ci->image_lib->resize();
            
            //crop photo
            $config_photo['image_library'] = 'gd2';
            $config_photo['source_image']	= $config['upload_path'].$photo1_data['file_name'];
            $config_photo['new_image'] = $config['upload_path'].'/thumbnail/'.$photo1_data['file_name'];
            $config_photo['create_thumb'] = FALSE;
            $config_photo['maintain_ratio'] = TRUE;
            $config_photo['width']	= 500;
            $config_photo['height']	= 500;
            $this->ci->image_lib->initialize($config_photo);
            $this->ci->image_lib->resize();
            
        }
    }
    
    private function saveFiles($data){
        $config = array();
        $config['upload_path'] = './storage/files/';
        $config['allowed_types'] = 'zip|rar|pdf|jpg|png|xls|xlsx|doc|docx';
        $config['file_name'] = md5(microtime());
        $config['max_size']	= '10240';
        
        $this->ci->upload->initialize($config);
        
        if($this->ci->upload->do_upload('file1')){
            $file1_data = $this->ci->upload->data();
            $this->ci->db->insert('attachment_files', array(
                'file_name' => $file1_data['file_name'],
                'file_ext' => $file1_data['file_ext'],
                'orig_name' => $file1_data['client_name'],
                'internship_id' => $data['internship_id'],
                'user_id' => $data['user_id'],
                'week' => $data['week'],
                'day' => $data['day'],
            ));
        }
    }

    public function getItem($user_id = 0, $day = 0, $week = 0)
    {
        $this->ci->db->where('user_id', $user_id);
        $this->ci->db->where('day', $day);
        $this->ci->db->where('week', $week);
        $query = $this->ci->db->get('activity');
        if ($query->num_rows())
            return $query->row();
        return NULL;
    }

    public function getItems($user_id = 0)
    {
        $this->ci->db->where('user_id', $user_id);
        $query = $this->ci->db->get('activity');
        if ($query->num_rows())
            return $query->result();
        return NULL;
    }
    
    public function getFileItems($user_id = 0, $internship_id = 0)
    {
        $this->ci->db->where('user_id', $user_id);
        $this->ci->db->where('internship_id', $internship_id);
        $query = $this->ci->db->get('attachment_files');
        if ($query->num_rows())
            return $query->result();
        return NULL;
    }
    
    public function getPhotoItems($user_id = 0, $internship_id = 0)
    {
        $this->ci->db->where('user_id', $user_id);
        $this->ci->db->where('internship_id', $internship_id);
        $query = $this->ci->db->get('attachment_photos');
        if ($query->num_rows())
            return $query->result();
        return NULL;
    }
    
    public function removeFile($id = 0)
    {
        $this->ci->db->where('id', $id);
        if ($this->ci->db->delete('attachment_files'))
            return true;
        return false;
    }
    
    public function removePhoto($id = 0)
    {
        $this->ci->db->where('id', $id);
        if ($this->ci->db->delete('attachment_photos'))
            return true;
        return false;
    }
}
