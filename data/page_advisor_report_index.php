<?php
//
//		- models/advisor/Advisorreport_model: getApproving();
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
								[homerooms] 		=> Array(
									[0] => stdClass Object(
										[id] 				=> 1
										[week] 				=> 1
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
											),
											[3] => stdClass Object(
												[advisor_id] 		=> 4
												[advisor_type] 		=> 'headadvisor'
												[advisor_status] 	=> 'confirmed'
											)
											[4] => stdClass Object(
												[advisor_id] 		=> 5
												[advisor_type] 		=> 'executive'
												[advisor_status] 	=> 'confirmed'
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
	)
);
