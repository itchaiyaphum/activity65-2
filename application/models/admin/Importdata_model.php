<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Importdata_model extends BaseModel
{
    public function saveData()
    {
        $data           = $this->ci->input->post();
        $csv_data       = $data['csv_data'];
        $update_exists  = $data['update_exists'];
        $data_type      = $data['data_type'];

        $items = $this->extractData($csv_data);

        $result = false;
        if ($data_type=='group') {
            $result = $this->importGroup($items, array('update_exists'=>$update_exists));
        } elseif ($data_type=='major') {
            $result = $this->importMajor($items, array('update_exists'=>$update_exists));
        } elseif ($data_type=='minor') {
            $result = $this->importMinor($items, array('update_exists'=>$update_exists));
        } elseif ($data_type=='advisor') {
            $result = $this->importAdvisor($items, array('update_exists'=>$update_exists));
        } elseif ($data_type=='student') {
            $result = $this->importStudent($items, array('update_exists'=>$update_exists));
        }
        return $result;
    }

    public function extractData($csv_data=null)
    {
        if (is_null($csv_data)) {
            $csv_data = $this->ci->input->get_post('csv_data');
        }
        
        //extract data to each block
        $rows = explode("\n", $csv_data);

        $items = array();
        //explode data by tab
        foreach ($rows as $row) {
            //extract data by tab
            $item = explode("/t", $row);
            //extract data by comma
            if (count($item)<=1) {
                $item = explode(",", $row);
            }

            array_push($items, $item);
        }

        return $items;
    }

    // [group_code,group_name,college_id,major_id,minor_id,status]
    public function importGroup($items=null, $options=array())
    {
        $valid_num_field = 6;
        $update_exists = $options['update_exists'];

        $prepare_data = array();
        foreach ($items as $item) {
            $num = count($item);

            //check valid num field
            if ($num==$valid_num_field) {
                array_push($prepare_data, array(
                    'group_code' => $item[0],
                    'group_name' => $item[1],
                    'college_id' => $item[2],
                    'major_id' => $item[3],
                    'minor_id' => $item[4],
                    'status' => $item[5],
                    'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time())
                ));
            }
        }

        // echo "<pre>";
        // print_r($items);
        // print_r($prepare_data);
        // exit();
        
        if (count($prepare_data)) {
            if ($update_exists=='update') {
                return $this->updateData('groups', $prepare_data, 'group_code');
            } elseif ($update_exists=='replace') {
                return $this->insertData('groups', $prepare_data, 'group_code');
            }
        }
        return false;
    }

    // [college_id,major_code,major_name,major_eng,status]
    public function importMajor($items=null, $options=array())
    {
        $valid_num_field = 5;
        $update_exists = $options['update_exists'];

        $prepare_data = array();
        foreach ($items as $item) {
            $num = count($item);

            //check valid num field
            if ($num>=$valid_num_field) {
                array_push($prepare_data, array(
                    'college_id' => $item[0],
                    'major_code' => $item[1],
                    'major_name' => $item[2],
                    'major_eng' => $item[3],
                    'status' => $item[4],
                    'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time())
                ));
            }
        }

        // echo "<pre>";
        // print_r($items);
        // print_r($prepare_data);
        // exit();
        
        if (count($prepare_data)) {
            if ($update_exists=='update') {
                return $this->updateData('majors', $prepare_data, 'major_code');
            } elseif ($update_exists=='replace') {
                return $this->insertData('majors', $prepare_data, 'major_code');
            }
        }
        return false;
    }

    // [college_id,major_id,minor_code,minor_name,minor_eng,status]
    public function importMinor($items=null, $options=array())
    {
        $valid_num_field = 6;
        $update_exists = $options['update_exists'];

        $prepare_data = array();
        foreach ($items as $item) {
            $num = count($item);

            //check valid num field
            if ($num>=$valid_num_field) {
                array_push($prepare_data, array(
                    'college_id' => $item[0],
                    'major_id' => $item[1],
                    'minor_code' => $item[2],
                    'minor_name' => $item[3],
                    'minor_eng' => $item[4],
                    'status' => $item[5],
                    'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time())
                ));
            }
        }

        // echo "<pre>";
        // print_r($items);
        // print_r($prepare_data);
        // exit();
        
        if (count($prepare_data)) {
            if ($update_exists=='update') {
                return $this->updateData('minors', $prepare_data, 'minor_code');
            } elseif ($update_exists=='replace') {
                return $this->insertData('minors', $prepare_data, 'minor_code');
            }
        }
        return false;
    }

    // [college_id,major_id,firstname,lastname,email]
    public function importAdvisor($items=null, $options=array())
    {
        $valid_num_field = 5;
        $update_exists = $options['update_exists'];

        $prepare_data = array();
        foreach ($items as $item) {
            $num = count($item);

            //check valid num field
            if ($num>=$valid_num_field) {
                array_push($prepare_data, array(
                    'college_id' => $item[0],
                    'major_id' => $item[1],
                    'firstname' => $item[2],
                    'lastname' => $item[3],
                    'email' => $item[4],
                    'status' => 1,
                    'created_at' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time())
                ));
            }
        }

        //get all majors
        $sql = "SELECT id as major_id, major_code  FROM majors";
        $query = $this->ci->db->query($sql);
        $majors_items = $query->result();

        //get auto key (major_id) on table: majors by compare with major_code field
        foreach ($prepare_data as &$pre_data) {
            foreach ($majors_items as $major) {
                if ($major->major_code==$pre_data['major_id']) {
                    $pre_data['major_id'] = $major->major_id;
                }
            }
        }

        // echo "<pre>";
        // print_r($prepare_data);
        // exit();
        
        if (count($prepare_data)) {
            if ($update_exists=='update') {
                return $this->updateData('users_advisor', $prepare_data, 'email');
            } elseif ($update_exists=='replace') {
                return $this->insertData('users_advisor', $prepare_data, 'email');
            }
        }
        return false;
    }

    // [college_id,major_id,minor_id,group_id,student_id,firstname,lastname,email]
    public function importStudent($items=null, $options=array())
    {
        $valid_num_field = 8;
        $update_exists = $options['update_exists'];

        $prepare_data = array();
        foreach ($items as $item) {
            $num = count($item);

            //check valid num field
            if ($num>=$valid_num_field) {
                array_push($prepare_data, array(
                    'college_id'    => $item[0],
                    'major_id'      => $item[1],
                    'minor_id'      => $item[2],
                    'group_id'      => $item[3],
                    'student_id'    => $item[4],
                    'firstname'     => $item[5],
                    'lastname'      => $item[6],
                    'email'         => $item[7],
                    'status'        => 1,
                    'created_at'    => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'updated_at'    => mdate('%Y-%m-%d %H:%i:%s', time())
                ));
            }
        }

        //get all groups
        $sql = "SELECT id as group_id, group_code, minor_id, major_id FROM groups";
        $query = $this->ci->db->query($sql);
        $group_items = $query->result();

        //get auto key (group_id,major_id,minor_id) on groups by group_code
        foreach ($prepare_data as &$pre_data) {
            foreach ($group_items as $group) {
                if ($group->group_code==$pre_data['group_id']) {
                    $pre_data['group_id'] = $group->group_id;
                    $pre_data['major_id'] = $group->major_id;
                    $pre_data['minor_id'] = $group->minor_id;
                }
            }
        }

        // echo "<pre>";
        // print_r($items);
        // print_r($prepare_data);
        // exit();
        
        if (count($prepare_data)) {
            if ($update_exists=='update') {
                return $this->updateData('users_student', $prepare_data, 'email');
            } elseif ($update_exists=='replace') {
                return $this->insertData('users_student', $prepare_data, 'email');
            }
        }
        return false;
    }

    private function insertData($table=null, $items=null, $key='id')
    {
        $ids = array();
        foreach ($items as $item) {
            array_push($ids, $item[$key]);
        }

        $this->ci->db->where_in($key, $ids);
        $this->ci->db->delete($table);
        
        $result = $this->ci->db->insert_batch($table, $items);
        return $result;
    }
        
    private function updateData($table=null, $items=null, $key='id')
    {
        return $this->ci->db->update_batch($table, $items, $key);
    }

    public function autogenAdvisor()
    {
        // select all data on table: users_advisor
        $sql = "SELECT * FROM users_advisor";
        $query = $this->ci->db->query($sql);
        $advisor_items = $query->result();

        // select all data on table: users
        $sql = "SELECT * FROM users";
        $query = $this->ci->db->query($sql);
        $users_items = $query->result();

        // prepare data
        $prepare_data = array();
        foreach ($advisor_items as $advisor) {
            $is_email_exists = false;
            foreach ($users_items as $user) {
                if ($user->email==$advisor->email) {
                    $is_email_exists = true;
                }
            }
            if (!$is_email_exists) {
                array_push($prepare_data, array(
                    'firstname' => $advisor->firstname,
                    'lastname' => $advisor->lastname,
                    'email' => $advisor->email,
                    'user_type' => 'advisor',
                    'created' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'modified' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'password' => md5('advisor1234567890'),
                    'activated' => 1,
                ));
            }
        }

        // echo "<pre>";
        // echo count($prepare_data)."<br/>";
        // print_r($prepare_data);
        // exit();

        // insert_batch data on table: users
        $result = false;
        if (count($prepare_data)) {
            $result = $this->ci->db->insert_batch('users', $prepare_data);
        }
        return $result;
    }

    public function autogenStudent()
    {
        // select all data on table: users_student
        $sql = "SELECT * FROM users_student";
        $query = $this->ci->db->query($sql);
        $student_items = $query->result();

        // select all data on table: users
        $sql = "SELECT * FROM users";
        $query = $this->ci->db->query($sql);
        $users_items = $query->result();

        // prepare data
        $prepare_data = array();
        foreach ($student_items as $student) {
            $is_email_exists = false;
            foreach ($users_items as $user) {
                if ($user->email==$student->email) {
                    $is_email_exists = true;
                }
            }
            if (!$is_email_exists) {
                array_push($prepare_data, array(
                    'firstname' => $student->firstname,
                    'lastname' => $student->lastname,
                    'email' => $student->email,
                    'user_type' => 'student',
                    'created' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'modified' => mdate('%Y-%m-%d %H:%i:%s', time()),
                    'password' => md5('student1234567890'),
                    'activated' => 1,
                ));
            }
        }

        // echo "<pre>";
        // echo count($prepare_data)."<br/>";
        // print_r($prepare_data);
        // exit();

        //sync user_id from id on table: users
        $this->syncUserIdToUsersStudent();

        // insert_batch data on table: users
        $result = false;
        if (count($prepare_data)) {
            $result = $this->ci->db->insert_batch('users', $prepare_data);
        }
        return $result;
    }

    //sync user_id from id on table: users
    private function syncUserIdToUsersStudent()
    {
        // select all data on table: users_student
        $sql = "SELECT * FROM users_student";
        $query = $this->ci->db->query($sql);
        $student_items = $query->result();

        // select all data on table: users
        $sql = "SELECT * FROM users";
        $query = $this->ci->db->query($sql);
        $users_items = $query->result();

        // prepare data
        $prepare_data = array();
        foreach ($users_items as $user) {
            foreach ($student_items as $student) {
                if ($user->email==$student->email) {
                    array_push($prepare_data, array(
                        'id' => $student->id,
                        'user_id' => $user->id
                    ));
                }
            }
        }

        // echo "<pre>";
        // print_r($prepare_data);
        // exit();

        //update data on table: users_student
        if (count($prepare_data)) {
            $this->ci->db->update_batch('users_student', $prepare_data, 'id');
        }
    }
}
