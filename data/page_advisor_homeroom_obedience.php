<?php
//
//		- login as user_type: advisor
//		- user_id: 1
//		- models/Homeroomobedience_model: getObediences($homeroom_id, $group_id);
//
$homeroom_item = stdClass Object(
    [id] 				=> 1
    [semester_name] 	=> 'ภาคการเรียนที่ 1/2564'
    [week] 				=> 1
    [join_start] 		=> '2021-06-05'
    [join_end] 			=> '2021-06-07'
    [is_lock] 			=> 0
    [is_lock_remark] 	=> ''
    [groups] 			=> Array(
        [0] => stdClass Object(
            [group_id] 	            => 1
            [group_name] 		    => 'กลุ่ม 1'
            [minor_name] 		    => 'สาขางานเครื่องยนต์'
            [major_name] 		    => 'สาขาวิชาช่างยนต์'
            [obedience] 	        => stdClass Object(
                [obe_id] 		    => 1
                [obe_detail] 		=> ''
                [survey_amount] 	=> 10
                [student_totals] 	=> 19
            ),
            [advisors] 			    => Array(
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
            [attactments] 			=> Array(
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
