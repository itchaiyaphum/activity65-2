<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<form action="<?php echo base_url('executive/approving');?>" method="post" name="adminForm" class="uk-form">
				<div class="uk-clearfix">
					<div>
						<h2>อนุมัติการบันทึกข้อมูลกิจกรรมโฮมรูม</h2>
					</div>
				</div>
				<hr/>

				<div class="uk-text-center">
					<select name="executive_filter_week" onchange="document.adminForm.submit();">
						<option value="">- กรุณาเลือกสัปดาห์ -</option>
						<?php
                            foreach ($filter_weeks as $week) {
                                ?>
							<option value="<?php echo $week->id; ?>" <?php echo set_select('executive_filter_week', $week->id); ?>>สัปดาห์ที่ <?php echo $week->name; ?></option>
						<?php
                            }
                        ?>
					</select>
					<select name="executive_filter_major" onchange="document.adminForm.submit();">
						<option value="">- กรุณาเลือกสาขาวิชา -</option>
						<?php
                            foreach ($filter_majors as $major) {
                                ?>
							<option value="<?php echo $major->id; ?>" <?php echo set_select('executive_filter_major', $major->id); ?>>สาขาวิชา: <?php echo $major->name; ?></option>
						<?php
                            }
                        ?>
					</select>
					</div>
				<hr/>

				<?php
                if (count($approvings)<=0) {
                    ?>
				<div class="uk-alert uk-alert-danger uk-text-center"><h3>กรุณาเลือก สัปดาห์และสาขาวิชา ที่ต้องการ</h3></div>
				<?php
                }
                ?>

				<div class="uk-accordion" data-uk-accordion>
				<?php
                foreach ($approvings as $major) {
                    ?>
					<h1 class="uk-accordion-title uk-margin-top uk-margin-bottom">สาขาวิชา: <?php echo $major->major_name; ?></h1>
					<div class="uk-accordion-content">
					<?php
                    foreach ($major->homerooms as $homeroom) {
                        ?>
						<h3 class="uk-alert uk-alert-primary"><?php echo $homeroom->semester_name.' สัปดาห์ที่: '.$homeroom->week; ?> (<?php echo date_format(date_create($homeroom->join_start), 'Y-m-d').' - '.date_format(date_create($homeroom->join_end), 'Y-m-d'); ?>)</h3>
						<?php
                        foreach ($homeroom->minors as $minor) {
                            $links = array(
                                'approve' => base_url("executive/approving/approve_all/?homeroom_id={$homeroom->id}&minor_id={$minor->minor_id}"),
                                'unapprove' => base_url("executive/approving/unapprove_all/?homeroom_id={$homeroom->id}&minor_id={$minor->minor_id}")
                            ); ?>
						<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
							<h3 class="uk-panel-title">
								สาขางาน: <?php echo $minor->minor_name; ?>
								<div class="uk-float-right">
									<?php echo $this->homeroom_lib->getApproveAllStatusHtml($minor, $links); ?>
								</div>
							</h3>
							<hr/>
							<table class="uk-table uk-table-hover uk-table-responsive uk-table-striped" cellpadding="1">
								<thead>
									<tr>
										<th>
											กลุ่มการเรียน
										</th>
										<th width="25%">
											รับรองจากหัวหน้าแผนก
										</th>
										<th width="25%">
											รับรองจากหัวหน้างานครูฯ
										</th>
										<th>
											รับรองจากฝ่ายบริหาร
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
                                if (count($minor->groups)<=0) {
                                    echo '<tr><td colspan="7" class="uk-text-center"><p>ไม่มีข้อมูล</p></td></tr>';
                                } else {
                                    foreach ($minor->groups as $group) {
                                        $link_confirm = base_url('executive/approving/confirm/?homeroom_id='.$homeroom->id.'&group_id='.$group->group_id); ?>
									<tr>
										<td>
											<div class="uk-grid uk-grid-collapse">
												<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">กลุ่มการเรียน:</div>
												<div class="uk-width-small-7-10 uk-width-large-1-1">
													<div><?php echo $group->group_name; ?></div>
													<?php
                                                    foreach ($group->advisors as $advisor) {
                                                        ?>
														<div><?php echo $advisor->firstname." ".$advisor->lastname; ?></div>
														<?php
                                                    } ?>
												</div>
											</div>
										</td>
										<td>
											<div class="uk-grid uk-grid-collapse">
												<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รับรองจากหัวหน้าแผนก:</div>
												<div class="uk-width-small-7-10 uk-width-large-1-1">
													<?php
                                                    $links = array(
                                                        'view' => base_url("executive/approving/confirm/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                        'approve' => base_url("executive/approving/approve/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                        'remove' => base_url("executive/approving/unapprove/?homeroom_id={$homeroom->id}&group_id={$group->group_id}")
                                                    );
                                        echo $this->executiveapproving_model->getHeadDepartmentStatusButton($group->approving, $links); ?>
												</div>
											</div>
										</td>
										<td>
											<div class="uk-grid uk-grid-collapse">
												<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รับรองจากหัวหน้างานครูฯ:</div>
												<div class="uk-width-small-7-10 uk-width-large-1-1">
													<?php
                                                        $links = array(
                                                            'view' => base_url("executive/approving/confirm/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                            'approve' => base_url("executive/approving/approve/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                            'remove' => base_url("executive/approving/unapprove/?homeroom_id={$homeroom->id}&group_id={$group->group_id}")
                                                        );
                                        echo $this->executiveapproving_model->getHeadAdvisorStatusButton($group->approving, $links); ?>
												</div>
											</div>
										</td>
										<td>
										<div class="uk-grid uk-grid-collapse">
												<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รับรองจากฝ่ายบริหาร:</div>
												<div class="uk-width-small-7-10 uk-width-large-1-1">
													<?php
                                                        $links = array(
                                                            'view' => base_url("executive/approving/confirm/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                            'approve' => base_url("executive/approving/approve/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                            'remove' => base_url("executive/approving/unapprove/?homeroom_id={$homeroom->id}&group_id={$group->group_id}")
                                                        );
                                        echo $this->executiveapproving_model->getExecutiveStatusButton($group->approving, $links); ?>
												</div>
											</div>
										</td>
									</tr>
								<?php
                                    }
                                } ?>
								</tbody>
							</table>
						</div>
						<br/><br/>
						<?php
                        }
                    } ?>
					</div>
				<?php
                }?>
				</div>
            </form>
		</div>
	</div>
</div>
