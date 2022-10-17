
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

##
## Database: `activity64`
##

############################ TABLE: ci_sessions ##############################
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);



############################ TABLE: college ##############################
CREATE TABLE `college` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `college` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'วิทยาลัยเทคนิคชัยภูมิ', 1, '2015-05-19 02:45:30', '2015-05-28 08:27:57'),
(2, 'วิทยาลัยเทคนิคขอนแก่น', 1, '2015-05-19 02:45:30', '2015-05-23 18:38:09'),
(3, 'วิทยาลัยสารพัดช่าง', 1, '2015-05-19 02:45:51', '2015-05-23 18:37:33'),
(4, 'วิทยาลัยเกษตร', -1, '2015-05-23 18:40:31', '2015-05-23 18:40:31'),
(5, 'วิทยาลัยแก้งคร้อ', -1, '2015-05-23 18:40:41', '2015-05-23 18:40:41'),
(6, 'วิทยาลัยเชตุพน', -1, '2015-05-23 18:40:56', '2015-05-23 18:41:34'),
(7, 'วิทยาลัยเทคนิคชลบุรี', -1, '2015-05-19 02:45:30', '2015-05-19 02:45:30');

ALTER TABLE `college`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `college`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;



############################ TABLE: groups ##############################
CREATE TABLE `groups` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `group_code` int(11) NOT NULL COMMENT 'รหัสกลุ่ม',
  `group_name` varchar(100) NOT NULL,
  `college_id` int(11) NOT NULL COMMENT 'รหัสสถานศึกษา',
  `major_id` int(11) NOT NULL COMMENT 'สาขาวิชา',
  `minor_id` int(11) NOT NULL COMMENT 'สาขางาน',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `group_code`, `group_name`, `college_id`, `major_id`, `minor_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 632090102, 'กลุ่ม 1', 1, 4, 1, '2021-05-27 14:19:39', '2021-05-27 14:19:39', 1),
(2, 632090101, 'กลุ่ม 2', 1, 4, 1, '2021-05-27 14:21:04', '2021-05-27 14:21:04', 1);

ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `college_id` (`college_id`,`major_id`,`minor_id`);

ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง', AUTO_INCREMENT=14;



############################ TABLE: homerooms ##############################
CREATE TABLE `homerooms` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `week` int(2) NOT NULL,
  `join_start` datetime NOT NULL,
  `join_end` datetime NOT NULL,
  `cover_img` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by_user_id` int(11) NOT NULL,
  `is_lock` int(1) NOT NULL DEFAULT '0',
  `remark` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `homerooms` (`id`, `semester_id`, `week`, `join_start`, `join_end`, `cover_img`, `created_at`, `updated_at`, `status`, `created_by_user_id`, `is_lock`, `remark`) VALUES
(3, 3, 1, '2021-05-27 00:00:00', '2021-05-31 00:00:00', 'homeroom/2021/id-1.jpg', '2021-05-27 15:15:03', '2021-05-27 15:15:03', 1, 1, 0,''),
(4, 3, 2, '2021-05-28 00:00:00', '2021-05-29 00:00:00', 'homeroom/2021/id-2.jpg', '2021-05-27 15:15:03', '2021-05-27 15:15:03', 1, 1, 0,'');

ALTER TABLE `homerooms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `homerooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;



############################ TABLE: homeroom_activities ##############################
CREATE TABLE `homeroom_activities` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `homeroom_id` int(11) NOT NULL COMMENT 'รหัสกิจกรรมโฮมรูม',
  `advisor_id` int(11) NOT NULL COMMENT 'บันทึกข้อมูลโดยใคร',
  `group_id` int(11) NOT NULL COMMENT 'กลุ่มการเรียน',
  `created_at` int(11) NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` int(11) NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `homeroom_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeroom_id` (`homeroom_id`,`group_id`,`advisor_id`) USING BTREE;

ALTER TABLE `homeroom_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง';



############################ TABLE: homeroom_activity_items ##############################
CREATE TABLE `homeroom_activity_items` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `homeroom_id` int(11) NOT NULL COMMENT 'รหัสกิจกรรมโฮมรูม',
  `group_id` int(11) NOT NULL COMMENT 'รหัสกลุ่มการเรียน',
  `student_id` int(11) NOT NULL COMMENT 'รหัสนักเรียน',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ',
  `check_status` varchar(10) NOT NULL COMMENT 'สถานะการเข้าร่วมกิจกรรมโฮมรูม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `homeroom_activity_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeroom_id` (`homeroom_id`,`group_id`,`student_id`);

ALTER TABLE `homeroom_activity_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง';



############################ TABLE: homeroom_obediences ##############################
CREATE TABLE `homeroom_obediences` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `homeroom_id` int(11) NOT NULL COMMENT 'รหัสกิจกรรมโฮมรูม',
  `advisor_id` int(11) NOT NULL COMMENT 'บันทึกข้อมูลโดยใคร',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ',
  `group_id` int(11) NOT NULL COMMENT 'รหัสกลุ่มเรียน',
  `obe_detail` text NOT NULL COMMENT 'รายละเอียดการให้โอวาท',
  `question_amount` int(2) NOT NULL COMMENT 'จำนวนคนที่ตอบแบบสอบถาม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `homeroom_obediences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeroom_id_2` (`homeroom_id`,`group_id`,`advisor_id`) USING BTREE;

ALTER TABLE `homeroom_obediences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง';



############################ TABLE: homeroom_obedience_attachments ##############################
CREATE TABLE `homeroom_obedience_attachments` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `img` varchar(100) NOT NULL COMMENT 'ที่อยู่รูปภาพกิจกรรม',
  `homeroom_id` int(11) NOT NULL COMMENT 'รหัสกิจกรรมโฮมรูม',
  `advisor_id` int(11) NOT NULL COMMENT 'รหัสครูที่ปรึกษา',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `homeroom_obedience_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeroom_id` (`homeroom_id`,`advisor_id`);

ALTER TABLE `homeroom_obedience_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง', AUTO_INCREMENT=3;



############################ TABLE: homeroom_risks ##############################
CREATE TABLE `homeroom_risks` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `homeroom_id` int(11) NOT NULL COMMENT 'รหัสกิจกรรมโฮมรูม',
  `group_id` int(11) NOT NULL COMMENT 'กลุ่มการเรียน',
  `advisor_id` int(11) NOT NULL COMMENT 'บันทึกข้อมูลโดยใคร',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `homeroom_risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeroom_id` (`homeroom_id`,`group_id`,`advisor_id`);

ALTER TABLE `homeroom_risks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง';



############################ TABLE: homeroom_risk_items ##############################
CREATE TABLE `homeroom_risk_items` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `homeroom_id` int(11) NOT NULL COMMENT 'รหัสกิจกรรมโฮมรูม',
  `student_id` int(11) NOT NULL COMMENT 'รหัสนักเรียน',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ',
  `risk_detail` varchar(200) NOT NULL COMMENT 'รายงานปัญหานักเรียน',
  `risk_comment` varchar(200) NOT NULL COMMENT 'หมายเหตุ',
  `risk_status` int(1) NOT NULL DEFAULT '0' COMMENT 'สถานะความเสี่ยง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `homeroom_risk_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeroom_id` (`homeroom_id`,`student_id`);

ALTER TABLE `homeroom_risk_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง';



############################ TABLE: login_attempts ##############################
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;



############################ TABLE: majors ##############################
CREATE TABLE `majors` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `college_id` int(11) NOT NULL COMMENT 'รหัสสถานศึกษา',
  `major_code` varchar(10) NOT NULL COMMENT 'รหัสสาขาวิชา',
  `major_name` varchar(100) NOT NULL COMMENT 'ชื่อสาขาวิชา',
  `major_eng` varchar(100) NOT NULL COMMENT 'ชื่อสาขาวิชาภาษาอังกฤษ',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `majors` (`id`, `college_id`, `major_code`, `major_name`, `major_eng`, `created_at`, `updated_at`, `status`) VALUES
(1, 0, '2101', 'ช่างยนต์', 'Mechanic', '2021-05-27 14:26:09', '2021-05-27 14:26:09', 1),
(2, 0, '2102', 'ช่างกลโรงงาน', 'Factory mechanic', '2021-05-27 14:26:09', '2021-05-27 14:26:09', -1),
(4, 0, '', 'เทคโนโลยีสารสนเทศ', 'Information Technology', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `college_id` (`college_id`);

ALTER TABLE `majors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง', AUTO_INCREMENT=5;



############################ TABLE: minors ##############################
CREATE TABLE `minors` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `minor_code` varchar(10) NOT NULL COMMENT 'รหัสสาขางาน',
  `minor_name` varchar(100) NOT NULL COMMENT 'ชื่อสาขางาน',
  `minor_eng` varchar(100) NOT NULL COMMENT 'ชื่อสาขางานภาษาอังกฤษ',
  `college_id` int(11) NOT NULL COMMENT 'รหัสสถานศึกษา',
  `major_id` int(11) NOT NULL COMMENT 'รหัสสาขาวิชา',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `minors` (`id`, `minor_code`, `minor_name`, `minor_eng`, `college_id`, `major_id`, `created_at`, `updated_at`, `status`) VALUES
(1, '', 'แอนนิเมชั่น', 'Animation', 1, 4, '2021-05-28 00:00:00', '2021-05-28 00:00:00', 1),
(2, '', 'รถยนต์ไฟฟ้า', 'EV', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

ALTER TABLE `minors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `college_id` (`college_id`,`major_id`);

ALTER TABLE `minors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง', AUTO_INCREMENT=3;



############################ TABLE: semester ##############################
CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `semester` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(3, 'ภาคเรียนที่ 1/2564', 1, '2015-05-24 16:27:34', '2015-05-24 18:16:18');

ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;



############################ TABLE: users ##############################
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(50) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_type` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'student',
  `organization_id` int(11) NOT NULL DEFAULT '0',
  `thumbnail` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '/storage/profiles/no-thumbnail.jpg',
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `major_id` int(11) NOT NULL,
  `minor_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `user_type`, `organization_id`, `thumbnail`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`, `major_id`, `minor_id`, `group_id`) VALUES
(1, '', '57a7ea46a6c58f62f02a782bd0fb6ee8', 'admin@demo.com', 'admin', 'demo', 'admin', 3, '/storage/profiles/no-thumbnail.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2021-05-29 04:02:24', '2016-03-14 10:13:19', '2021-05-29 04:02:24', 0, 0, 0),
(2, '', '57a7ea46a6c58f62f02a782bd0fb6ee8', 'student@demo.com', 'student', 'demo', 'student', 3, '/storage/profiles/no-thumbnail.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2021-05-27 20:23:37', '2016-03-08 10:39:02', '2021-05-27 17:55:38', 0, 0, 0),
(3, '', '57a7ea46a6c58f62f02a782bd0fb6ee8', 'staff@demo.com', 'staff', 'demo', 'staff', 3, '/storage/profiles/no-thumbnail.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, '49.237.203.62', '2017-03-27 09:41:59', '2016-03-08 23:15:40', '2017-03-26 19:41:59', 0, 0, 0),
(4, '', '57a7ea46a6c58f62f02a782bd0fb6ee8', 'advisor@demo.com', 'advisor', 'demo', 'advisor', 0, '/storage/profiles/no-thumbnail.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2021-05-28 09:40:17', '2016-03-16 17:40:22', '2021-05-28 09:40:17', 0, 0, 0),
(5, '', '57a7ea46a6c58f62f02a782bd0fb6ee8', 'headadvisor@demo.com', 'advisor', 'demo', 'headadvisor', 0, '/storage/profiles/no-thumbnail.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2021-05-28 09:40:17', '2016-03-16 17:40:22', '2021-05-28 09:40:17', 0, 0, 0),
(6, '', '57a7ea46a6c58f62f02a782bd0fb6ee8', 'headdepartment@demo.com', 'advisor', 'demo', 'headdepartment', 0, '/storage/profiles/no-thumbnail.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2021-05-28 09:40:17', '2016-03-16 17:40:22', '2021-05-28 09:40:17', 0, 0, 0),
(7, '', '57a7ea46a6c58f62f02a782bd0fb6ee8', 'executive@demo.com', 'advisor', 'demo', 'executive', 0, '/storage/profiles/no-thumbnail.jpg', 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2021-05-28 09:40:17', '2016-03-16 17:40:22', '2021-05-28 09:40:17', 0, 0, 0);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `major_id` (`major_id`),
  ADD KEY `group_id` (`group_id`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;



############################ TABLE: users_student ##############################
CREATE TABLE `users_student` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname_en` varchar(50) NOT NULL,
  `lastname_en` varchar(50) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `college_id` int(11) NOT NULL DEFAULT '1',
  `department_id` int(11) NOT NULL DEFAULT '1',
  `major_id` int(11) NOT NULL,
  `minor_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `edulevel` int(11) NOT NULL,
  `religion_title` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `congenital_disease` varchar(255) NOT NULL,
  `drug_allergy` varchar(255) NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `experience_work` text NOT NULL,
  `experience_skill` text NOT NULL,
  `experience_intesting` text NOT NULL,
  `experience_status` tinyint(1) NOT NULL DEFAULT '0',
  `experience_marry_name` varchar(255) NOT NULL,
  `experience_marry_cocupation` varchar(255) NOT NULL,
  `emergency_name` varchar(255) NOT NULL,
  `emergency_address` text NOT NULL,
  `emergency_mobile` varchar(50) NOT NULL,
  `hometown_no` varchar(50) NOT NULL,
  `hometown_moo` varchar(50) NOT NULL,
  `hometown_subdistrict` varchar(50) NOT NULL,
  `hometown_district` varchar(50) NOT NULL,
  `hometown_province` varchar(50) NOT NULL,
  `hometown_postcode` varchar(50) NOT NULL,
  `hometown_mobile` varchar(255) NOT NULL,
  `current_address_no` varchar(255) NOT NULL,
  `current_address_moo` varchar(255) NOT NULL,
  `current_address_subdistrict` varchar(255) NOT NULL,
  `current_address_district` varchar(255) NOT NULL,
  `current_address_province` varchar(255) NOT NULL,
  `current_address_postcode` varchar(255) NOT NULL,
  `current_address_mobile` varchar(255) NOT NULL,
  `advisor_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `internship_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `organization_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users_student`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;



############################ TABLE: user_autologin ##############################
CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `user_autologin`
  ADD PRIMARY KEY (`key_id`,`user_id`);



############################ TABLE: user_signatures ##############################
CREATE TABLE `user_signatures` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `img` varchar(100) NOT NULL COMMENT 'รูปภาพ',
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้งานระบบ',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user_signatures`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_signatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง', AUTO_INCREMENT=3;



############################ TABLE: users_advisor ##############################
CREATE TABLE `users_advisor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `major_id` int(11) NOT NULL,
  `signature` varchar(200) NOT NULL,
  `college_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users_advisor`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_advisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;



############################ TABLE: homeroom_confirm ##############################
CREATE TABLE `homeroom_confirm` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `homeroom_id` int(11) NOT NULL COMMENT 'รหัสกิจกรรมโฮมรูม',
  `advisor_id` int(11) NOT NULL COMMENT 'บันทึกข้อมูลโดยใคร',
  `advisor_type` varchar(10) NOT NULL COMMENT 'ประเภทครูที่ปรึกษา',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `homeroom_confirm`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `homeroom_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง';
  
  
  
############################ TABLE: advisors_groups ##############################
CREATE TABLE `advisors_groups` (
  `id` int(11) NOT NULL COMMENT 'รหัสอ้างอิง',
  `advisor_id` int(11) NOT NULL COMMENT 'ครูที่ปรึกษา',
  `group_id` int(11) NOT NULL COMMENT 'กลุ่มการเรียน',
  `advisor_type` varchar(10) NOT NULL COMMENT 'ประเภทที่ปรึกษา',
  `created_at` datetime NOT NULL COMMENT 'บันทึกข้อมูลเมื่อไหร่',
  `updated_at` datetime NOT NULL COMMENT 'แก้ไขข้อมูลล่าสุดเมื่อไหร่',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `advisors_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advisor_id` (`advisor_id`,`group_id`);

ALTER TABLE `advisors_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสอ้างอิง', AUTO_INCREMENT=2;

  
############################ TABLE: homeroom_actions ##############################
CREATE TABLE `homeroom_actions` (
  `id` int(11) NOT NULL,
  `homeroom_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` varchar(15) NOT NULL,
  `action_status` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `homeroom_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeroom_id` (`homeroom_id`,`group_id`,`user_id`);

ALTER TABLE `homeroom_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


############################ TABLE: users_executive ##############################
CREATE TABLE `users_executive` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `college_id` int(11) NOT NULL DEFAULT '1',
  `signature` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users_executive`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_executive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


############################ TABLE: users_headadvisor ##############################
CREATE TABLE `users_headadvisor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `college_id` int(11) NOT NULL DEFAULT '1',
  `signature` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users_headadvisor`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_headadvisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


############################ TABLE: users_headdepartment ##############################
CREATE TABLE `users_headdepartment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `major_id` int(11) NOT NULL,
  `college_id` int(11) NOT NULL DEFAULT '1',
  `signature` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users_headdepartment`
  ADD KEY `id` (`id`);

ALTER TABLE `users_headdepartment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


############################ TABLE: users_staff ##############################
CREATE TABLE `users_staff` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `college_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users_staff`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;