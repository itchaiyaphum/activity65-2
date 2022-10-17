<?php
//
//		- models/headdepartment/Headdepartmentreport_model: getApproving();
//
$approving_items = Array(
	[0] => stdClass Object(
		[semester_id] 			=> 1
		[semester_name] 		=> 'ภาคการเรียนที่ 2/2564'
		[majors] 				=> Array(
			[0] => stdClass Object(
				[major_id] 				=> 1
				[major_name] 			=> 'เทคโนโลยีสารสนเทศ'
				[minors] 				=> Array(
					[0] => stdClass Object(
						[minor_id] 		=> 1
						[minor_name] 	=> 'ระบบเครือข่ายคอมพิวเตอร์'
						[groups] 		=> Array(
							[0] => stdClass Object(
								[grooup_id] 		=> 1
								[group_name] 		=> 'กลุ่ม 1'
								[advisors] 		=> Array(
									[0] => stdClass Object(
										[advisor_id] 					=> 1
										[advisor_type] 					=> 'advisor'
										[firstname] 					=> 'อ.อลงกรณ์'
										[lastname] 						=> 'ภูคงคา'
										[stats_num_homeroom] 			=> 18
										[stats_num_checked_percent] 	=> 100
										[homerooms] 					=> Array(
											[0] => stdClass Object(
												[id] 				=> 1
												[week] 				=> 1
												[is_check] 			=> 1
												[approving] 		=> Array(
													[0] => stdClass Object(
														[advisor_id] 		=> 1
														[advisor_type] 		=> 'advisor'
														[advisor_status] 	=> 'confirmed'
													)
												)
											),
											[1] => stdClass Object(
												[id] 				=> 2
												[week] 				=> 2
												[is_check] 			=> 0
												[approving] 		=> Array()
										)
									)
								)
							)
						)
					)
				)
			)
		)
	)
);
