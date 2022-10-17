<?php
//
//		- login as user_type: advisor
//		- user_id: 1
//		- models/Homeroomconfirm_model: getConfirm($homeroom_id, $group_id);
//
$homeroom_item = stdClass Object(
    [id] 				=> 1
    [semester_name] 	=> 'ภาคการเรียนที่ 1/2564'
    [week] 				=> 1
    [join_start] 		=> '2021-06-05'
    [join_end] 			=> '2021-06-07'
    [is_lock] 			=> 0
    [is_lock_remark] 	=> ''
    [summary] 	        => stdClass Object(
        [student_totals] 	=> 10
        [student_come] 		=> 7
        [student_not_come] 	=> 1
        [student_late] 		=> 1
        [student_leave] 	=> 1
        [student_risk] 		=> 1
        [student_not_risk] 	=> 9
    ),
    [groups] 			=> Array(
        [0] => stdClass Object(
            [id] 				=> 1
            [group_name] 		=> 'กลุ่ม 1'
            [minor_name] 		=> 'สาขางานเครื่องยนต์'
            [major_name] 		=> 'สาขาวิชาช่างยนต์'
            [obedience] 	    => stdClass Object(
                [obe_id] 		    => 1
                [obe_detail] 		=> ''
                [survey_amount] 	=> 10
                [student_totals] 	=> 10
            ),
            [advisors] 			=> Array(
                [0] => stdClass Object(
                    [advisor_id] 		=> 1
                    [advisor_type] 		=> 'advisor'
                    [advisor_status] 	=> 'saving'
                ),
                [1] => stdClass Object(
                    [advisor_id] 		=> 1
                    [advisor_type] 		=> 'coadvisor'
                    [advisor_status] 	=> 'pending'
                ),
            ),
            [students] 	        => Array(
                [0] => stdClass Object(
                    [id] 				=> 1
                    [student_code] 		=> '5839010002'
                    [firstname] 		=> 'จุฑามาศ'
                    [lastname] 		    => 'ปะกาเวสูง'
                    [risk_detail] 	    => ''
                    [risk_comment] 	    => ''
                    [risk_status] 	    => 'risk'
                    [activity_status] 	=> 'come'
                ),
                [1] => stdClass Object(
                    [id] 				=> 2
                    [student_code] 		=> '5839010024'
                    [firstname] 		=> 'นาย ชยานนท์'
                    [lastname] 		    => 'แก้วปิ่น'
                    [risk_detail] 	    => ''
                    [risk_comment] 	    => ''
                    [risk_status] 	    => 'not_risk'
                    [activity_status] 	=> 'not_come'
                )
            ),
            [attactments]   => Array(
                [0] => stdClass Object(
                    [img_id] 		=> 1
                    [img_path] 		=> '/storage/obediences/thumbnail/3-1.png'
                ),
                [1] => stdClass Object(
                    [img_id] 	    => 1
                    [img_path] 		=> '/storage/obediences/thumbnail/3-2.png'
                )
            )
        )
    )
);
