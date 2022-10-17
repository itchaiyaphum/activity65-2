<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_lib
{
    public $table_student = null;
    public function __construct()
    {
        $this->ci = & get_instance();
        $this->table_student = $this->ci->factory_lib->getTable('Users');
    }

    public function getUserType($user_id=0)
    {
        if ($user_id==0) {
            $user_id = $this->ci->tank_auth->get_user_id();
        }
        $sql = 'SELECT user_type FROM users WHERE id=' . $user_id;
        $query = $this->ci->db->query($sql);
        $row = $query->row();
        if (isset($row)) {
            return $row->user_type;
        }
        return 'guest';
    }
    public function getUserId()
    {
        return $this->ci->tank_auth->get_user_id();
    }

    public function getData()
    {
        $user_id = $this->ci->tank_auth->get_user_id();
        $this->table_student->load($user_id);
        $profile =& $this->table_student;
        $profile->user_id = $profile->id;
            
        if ($profile->user_type=='student') {
            $profile = $this->getStudentProfile($profile);
        } elseif ($profile->user_type=='advisor') {
            $profile = $this->getAdvisorProfile($profile);
        } elseif ($profile->user_type=='headdepartment') {
            $profile = $this->getHeadDepartmentProfile($profile);
        } elseif ($profile->user_type=='headadvisor') {
            $profile = $this->getHeadAdvisorProfile($profile);
        } elseif ($profile->user_type=='executive') {
            $profile = $this->getExecutiveProfile($profile);
        } elseif ($profile->user_type=='staff') {
            $profile = $this->getStaffProfile($profile);
        }
        
        return $profile;
    }
    
    private function getAdvisorProfile($profile)
    {
        $this->ci->db->where('user_id', $profile->user_id);
        $query = $this->ci->db->get('users_advisor');
        if ($query->num_rows()) {
            $row = $query->row();
            
            $profile->firstname = $row->firstname;
            $profile->lastname = $row->lastname;
            $profile->user_id = $row->user_id;
            $profile->major_id = $row->major_id;
            $profile->college_id = $row->college_id;
            $profile->signature = $row->signature;
        }
        return $profile;
    }

    private function getHeadAdvisorProfile($profile)
    {
        $this->ci->db->where('user_id', $profile->user_id);
        $query = $this->ci->db->get('users_headadvisor');
        if ($query->num_rows()) {
            $row = $query->row();
            
            $profile->firstname = $row->firstname;
            $profile->lastname = $row->lastname;
            $profile->user_id = $row->user_id;
            $profile->college_id = $row->college_id;
            $profile->signature = $row->signature;
        }
        return $profile;
    }

    private function getHeadDepartmentProfile($profile)
    {
        $this->ci->db->where('user_id', $profile->user_id);
        $query = $this->ci->db->get('users_headdepartment');
        if ($query->num_rows()) {
            $row = $query->row();
            
            $profile->firstname = $row->firstname;
            $profile->lastname = $row->lastname;
            $profile->user_id = $row->user_id;
            $profile->college_id = $row->college_id;
            $profile->major_id = $row->major_id;
            $profile->signature = $row->signature;
        }
        return $profile;
    }
    
    private function getExecutiveProfile($profile)
    {
        $this->ci->db->where('user_id', $profile->user_id);
        $query = $this->ci->db->get('users_executive');
        if ($query->num_rows()) {
            $row = $query->row();
            
            $profile->firstname = $row->firstname;
            $profile->lastname = $row->lastname;
            $profile->user_id = $row->user_id;
            $profile->college_id = $row->college_id;
            $profile->signature = $row->signature;
        }
        return $profile;
    }

    private function getStaffProfile($profile)
    {
        $this->ci->db->where('user_id', $profile->user_id);
        $query = $this->ci->db->get('users_staff');
        if ($query->num_rows()) {
            $row = $query->row();
            
            $profile->firstname = $row->firstname;
            $profile->lastname = $row->lastname;
            $profile->user_id = $row->user_id;
            $profile->college_id = $row->college_id;
        }
        return $profile;
    }
    
    private function getStudentProfile($profile)
    {
        $this->ci->db->where('user_id', $profile->user_id);
        $query = $this->ci->db->get('users_student');
        if ($query->num_rows()) {
            $row = $query->row();
            
            $profile->student_id = $row->student_id;
            $profile->major_id = $row->major_id;
            $profile->college_id = $row->college_id;
            $profile->group_id = $row->group_id;
        }
        return $profile;
    }
    
    public function getColleges()
    {
        $this->ci->load->model('admin/college_model');
        return $this->ci->college_model->getItems(array('status'=>1));
    }
    
    public function getStaff()
    {
        $this->ci->db->where('user_type', 'staff');
        $this->ci->db->where('activated', 1);
        $query = $this->ci->db->get('users');
        if ($query->num_rows()) {
            return $query->result();
        }
        return null;
    }

    public function getAdvisor()
    {
        $this->ci->db->where('user_type', 'advisor');
        $this->ci->db->where('activated', 1);
        $query = $this->ci->db->get('users');
        if ($query->num_rows()) {
            return $query->result();
        }
        return null;
    }
    
    public function save($data)
    {
        $profile = $this->ci->profile_lib->getData();
        if ($profile->user_type=='student') {
            return $this->saveStudent($data);
        }
        return false;
    }

    public function saveStudent($data)
    {
        //upload thumbnail
        $thumbnail = $this->saveThumbnail($data);
        
        $users_data = array();
        $users_data['firstname'] = $data['firstname'];
        $users_data['lastname'] = $data['lastname'];
        $users_data['email'] = $data['email'];
        if (!empty($thumbnail)) {
            $users_data['thumbnail'] = $thumbnail;
        }
        $users_data['modified'] = date('Y-m-d H:i:s');
        
        //save table: users
        $this->ci->db->where('id', $data['user_id']);
        $this->ci->db->update('users', $users_data);
        
        unset($data['thumbnail']);
        
        //save table: users_student
        $this->ci->db->where('user_id', $data['user_id']);
        $query = $this->ci->db->get('users_student');
        if ($query->num_rows()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $data['user_id']);
            if ($this->ci->db->update('users_student', $data)) {
                return true;
            }
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('users_student', $data)) {
                return true;
            }
        }
        
        return false;
    }
    
    public function saveAdvisor($data)
    {
        //upload thumbnail
        $thumbnail = $this->saveThumbnail($data);

        //upload signature
        $signature = $this->saveSignature($data);
        if (!empty($signature)) {
            $data['signature'] = $signature;
        }
        
        $users_data = array();
        $users_data['firstname'] = $data['firstname'];
        $users_data['lastname'] = $data['lastname'];
        $users_data['email'] = $data['email'];
        if (!empty($thumbnail)) {
            $users_data['thumbnail'] = $thumbnail;
        }
        $users_data['modified'] = date('Y-m-d H:i:s');

        
        //save table: users
        $this->ci->db->where('id', $data['user_id']);
        $this->ci->db->update('users', $users_data);
    
        unset($data['thumbnail']);
        
        //save table: users_advisor
        $this->ci->db->where('user_id', $data['user_id']);
        $query = $this->ci->db->get('users_advisor');
        if ($query->num_rows()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $data['user_id']);
            if ($this->ci->db->update('users_advisor', $data)) {
                return true;
            }
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('users_advisor', $data)) {
                return true;
            }
        }
    
        return false;
    }

    public function saveHeadAdvisor($data)
    {
        //upload thumbnail
        $thumbnail = $this->saveThumbnail($data);

        //upload signature
        $signature = $this->saveSignature($data);
        if (!empty($signature)) {
            $data['signature'] = $signature;
        }
        
        $users_data = array();
        $users_data['firstname'] = $data['firstname'];
        $users_data['lastname'] = $data['lastname'];
        $users_data['email'] = $data['email'];
        if (!empty($thumbnail)) {
            $users_data['thumbnail'] = $thumbnail;
        }
        $users_data['modified'] = date('Y-m-d H:i:s');

        
        //save table: users
        $this->ci->db->where('id', $data['user_id']);
        $this->ci->db->update('users', $users_data);
    
        unset($data['thumbnail']);
        
        //save table: users_headadvisor
        $this->ci->db->where('user_id', $data['user_id']);
        $query = $this->ci->db->get('users_headadvisor');
        if ($query->num_rows()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $data['user_id']);
            if ($this->ci->db->update('users_headadvisor', $data)) {
                return true;
            }
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('users_headadvisor', $data)) {
                return true;
            }
        }
    
        return false;
    }

    public function saveHeadDepartment($data)
    {
        //upload thumbnail
        $thumbnail = $this->saveThumbnail($data);

        //upload signature
        $signature = $this->saveSignature($data);
        if (!empty($signature)) {
            $data['signature'] = $signature;
        }
        
        $users_data = array();
        $users_data['firstname'] = $data['firstname'];
        $users_data['lastname'] = $data['lastname'];
        $users_data['email'] = $data['email'];
        if (!empty($thumbnail)) {
            $users_data['thumbnail'] = $thumbnail;
        }
        $users_data['modified'] = date('Y-m-d H:i:s');

        
        //save table: users
        $this->ci->db->where('id', $data['user_id']);
        $this->ci->db->update('users', $users_data);
    
        unset($data['thumbnail']);
        
        //save table: users_headadvisor
        $this->ci->db->where('user_id', $data['user_id']);
        $query = $this->ci->db->get('users_headdepartment');
        if ($query->num_rows()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $data['user_id']);
            if ($this->ci->db->update('users_headdepartment', $data)) {
                return true;
            }
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('users_headdepartment', $data)) {
                return true;
            }
        }
    
        return false;
    }

    public function saveExecutive($data)
    {
        //upload thumbnail
        $thumbnail = $this->saveThumbnail($data);

        //upload signature
        $signature = $this->saveSignature($data);
        if (!empty($signature)) {
            $data['signature'] = $signature;
        }
        
        $users_data = array();
        $users_data['firstname'] = $data['firstname'];
        $users_data['lastname'] = $data['lastname'];
        $users_data['email'] = $data['email'];
        if (!empty($thumbnail)) {
            $users_data['thumbnail'] = $thumbnail;
        }
        $users_data['modified'] = date('Y-m-d H:i:s');

        
        //save table: users
        $this->ci->db->where('id', $data['user_id']);
        $this->ci->db->update('users', $users_data);
    
        unset($data['thumbnail']);
        
        //save table: users_executive
        $this->ci->db->where('user_id', $data['user_id']);
        $query = $this->ci->db->get('users_executive');
        if ($query->num_rows()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $data['user_id']);
            if ($this->ci->db->update('users_executive', $data)) {
                return true;
            }
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('users_executive', $data)) {
                return true;
            }
        }
    
        return false;
    }
    
    public function saveStaff($data)
    {
        //upload thumbnail
        $thumbnail = $this->saveThumbnail($data);
    
        $users_data = array();
        $users_data['firstname'] = $data['firstname'];
        $users_data['lastname'] = $data['lastname'];
        $users_data['email'] = $data['email'];
        if (!empty($thumbnail)) {
            $users_data['thumbnail'] = $thumbnail;
        }
        $users_data['modified'] = date('Y-m-d H:i:s');
    
        //save table: users
        $this->ci->db->where('id', $data['user_id']);
        $this->ci->db->update('users', $users_data);
    
        unset($data['thumbnail']);
    
        //save table: users_staff
        $this->ci->db->where('user_id', $data['user_id']);
        $query = $this->ci->db->get('users_staff');
        if ($query->num_rows()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->ci->db->where('user_id', $data['user_id']);
            if ($this->ci->db->update('users_staff', $data)) {
                return true;
            }
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            if ($this->ci->db->insert('users_staff', $data)) {
                return true;
            }
        }
    
        return false;
    }
    
    private function saveThumbnail($data)
    {
        $profile = $this->ci->profile_lib->getData();
        
        $config = array();
        $config['upload_path'] = './storage/profiles/';
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['file_name'] = $profile->user_id;
        $config['max_size']	= '10240';
        $this->ci->upload->initialize($config);
    
        if ($this->ci->upload->do_upload('thumbnail')) {
            $thumbnail_data = $this->ci->upload->data();
            //resize thumbnail
            $config_photo['image_library'] = 'gd2';
            $config_photo['source_image']	= $config['upload_path'].$thumbnail_data['file_name'];
            $config_photo['new_image'] = $config['upload_path'].'/thumbnail/'.$thumbnail_data['file_name'];
            $config_photo['create_thumb'] = false;
            $config_photo['maintain_ratio'] = false;
            $config_photo['width']	= 150;
            $config_photo['height']	= 150;
            $this->ci->image_lib->initialize($config_photo);
            $this->ci->image_lib->resize();
            
            return '/storage/profiles/thumbnail/'.$thumbnail_data['file_name'];
        } else {
            return false;
        }
    }

    private function saveSignature($data)
    {
        $profile = $this->ci->profile_lib->getData();
        
        $config = array();
        $config['upload_path'] = './storage/profiles/';
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['file_name'] = $profile->user_id;
        $config['max_size']	= '10240';
        $this->ci->upload->initialize($config);
    
        if ($this->ci->upload->do_upload('signature')) {
            $thumbnail_data = $this->ci->upload->data();
            //resize thumbnail
            $config_photo['image_library'] = 'gd2';
            $config_photo['source_image']	= $config['upload_path'].$thumbnail_data['file_name'];
            $config_photo['new_image'] = $config['upload_path'].'/signature/'.$thumbnail_data['file_name'];
            $config_photo['create_thumb'] = false;
            $config_photo['maintain_ratio'] = true;
            $config_photo['width']	= 300;
            $config_photo['height']	= 250;
            $this->ci->image_lib->initialize($config_photo);
            $this->ci->image_lib->resize();
            
            return '/storage/profiles/signature/'.$thumbnail_data['file_name'];
        } else {
            return false;
        }
    }
}
