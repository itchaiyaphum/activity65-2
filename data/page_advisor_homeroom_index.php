<?php
//
//		- login as user_type: advisor
//		- user_id: 1
//		- models/Base_homeroom_model: getItems();
//
$homeroom_items = Array(
	[0] => stdClass Object(
		[id] 				=> 1
		[semester_name] 	=> 'ภาคการเรียนที่ 1/2564'
		[week] 				=> 1
		[join_start] 		=> '2021-06-05'
		[join_end] 			=> '2021-06-07'
		[is_lock] 			=> 0
		[is_lock_remark] 	=> ''
		[groups] 			=> Array(
			[0] => stdClass Object(
				[id] 				=> 1
				[group_name] 		=> 'กลุ่ม 1'
				[minor_name] 		=> 'สาขางานเครื่องยนต์'
				[major_name] 		=> 'สาขาวิชาช่างยนต์'
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
					)
				)
			),
			[1] => stdClass Object(
				[id] 				=> 2
				[group_name] 		=> 'กลุ่ม 2'
				[minor_name] 		=> 'สาขางานเครื่องยนต์'
				[major_name] 		=> 'สาขาวิชาช่างยนต์'
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
					)
				)
			)
		)
	)
);
