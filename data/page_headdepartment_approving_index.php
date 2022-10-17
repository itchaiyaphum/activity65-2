<?php
//
//		- login as user_type: advisor
//		- user_id: 1
//		- models/headdepartment/Headdepartmentapproving_model: getApproving($major_id);
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
		[major_id] 			=> 1
		[major_name] 		=> 'เทคโนโลยีสารสนเทศ'
		[minors] 			=> Array(
			[0] => stdClass Object(
				[minor_id] 		=> 1
				[minor_name] 	=> 'ระบบเครือข่ายคอมพิวเตอร์'
				[groups] 		=> Array(
					[0] => stdClass Object(
						[grooup_id] 		=> 1
						[group_name] 		=> 'กลุ่ม 1'
						[advisors] 		=> Array(
							[0] => stdClass Object(
								[advisor_id] 		=> 1
								[advisor_type] 		=> 'advisor'
								[firstname] 		=> 'อ.อลงกรณ์'
								[lastname] 			=> 'ภูคงคา'
							),
							[1] => stdClass Object(
								[advisor_id] 		=> 2
								[advisor_type] 		=> 'coadvisor'
								[firstname] 		=> 'อ.ทิพยา'
								[lastname] 			=> 'สุวรรณชัย'
							)
						),
						[approving] 		=> Array(
							[0] => stdClass Object(
								[advisor_id] 		=> 1
								[advisor_type] 		=> 'advisor'
								[advisor_status] 	=> 'confirmed'
							),
							[1] => stdClass Object(
								[advisor_id] 		=> 2
								[advisor_type] 		=> 'coadvisor'
								[advisor_status] 	=> 'pending'
							),
							[2] => stdClass Object(
								[advisor_id] 		=> 3
								[advisor_type] 		=> 'headdepartment'
								[advisor_status] 	=> 'confirmed'
							)
						)
					),
					[1] => stdClass Object(
						[grooup_id] 		=> 2
						[group_name] 		=> 'กลุ่ม 2'
						[advisors] 		=> Array(
							[0] => stdClass Object(
								[advisor_id] 		=> 1
								[advisor_type] 		=> 'advisor'
								[firstname] 		=> 'อ.อลงกรณ์'
								[lastname] 			=> 'ภูคงคา'
							),
							[1] => stdClass Object(
								[advisor_id] 		=> 2
								[advisor_type] 		=> 'coadvisor'
								[firstname] 		=> 'อ.ทิพยา'
								[lastname] 			=> 'สุวรรณชัย'
							)
						),
						[approving] 		=> Array(
							[0] => stdClass Object(
								[advisor_id] 		=> 1
								[advisor_type] 		=> 'advisor'
								[advisor_status] 	=> 'saving'
							),
							[1] => stdClass Object(
								[advisor_id] 		=> 2
								[advisor_type] 		=> 'coadvisor'
								[advisor_status] 	=> 'viewed'
							),
							[2] => stdClass Object(
								[advisor_id] 		=> 3
								[advisor_type] 		=> 'headdepartment'
								[advisor_status] 	=> 'viewed'
							)
						)
					)
				)
			)
		)
	)
);
