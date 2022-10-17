<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
		<form action="<?php echo base_url('headdepartment/report');?>" method="post" name="adminForm" class="uk-form">
				<div class="uk-clearfix">
					<div>
						<h2>รายงานการปฏิบัติหน้าที่กิจกรรมโฮมรูมของครูที่ปรึกษา</h2>
					</div>
				</div>
				<hr/>

				<div class="uk-text-center">
					<select name="headdepartment_filter_semester" class="uk-width-small-1-1 uk-width-large-1-4" onchange="document.adminForm.submit();">
						<option value="">- กรุณาเลือกภาคเรียน -</option>
						<?php
                            foreach ($filter_semester as $semester) {
                                ?>
							<option value="<?php echo $semester->id; ?>" <?php echo set_select('headdepartment_filter_semester', $semester->id); ?>><?php echo $semester->name; ?></option>
						<?php
                            }
                        ?>
					</select>
					<select name="headdepartment_filter_type" class="uk-width-small-1-1 uk-width-large-1-4" onchange="document.adminForm.submit();">
						<option value="">- กรุณาเลือกรูปแบบรายงาน -</option>
						<option disabled value="9" <?php echo set_select('headdepartment_filter_type', '9'); ?>>- แบบรายงาน 9 สัปดาห์</option>
						<option disabled value="18" <?php echo set_select('headdepartment_filter_type', '18'); ?>>- แบบรายงาน 18 สัปดาห์</option>
						<option value="current" <?php echo set_select('headdepartment_filter_type', 'current'); ?>>- แบบรายงานจนถึงสัปดาห์ปัจจุบัน</option>
					</select>
				</div>
				<hr/>

				<?php
                if (count($items)<=0) {
                    ?>
				<div class="uk-alert uk-alert-danger uk-text-center"><h3>กรุณาเลือก ภาคเรียน และรูปแบบรายงาน ที่ต้องการ</h3></div>
				<?php
                }
                ?>

				<?php
                foreach ($items as $semester) {
                ?>
				<h2><?php echo $semester->semester_name;?></h2>
					<div class="uk-accordion" data-uk-accordion>
					<?php
					foreach ($semester->majors as $major) {
						?>
						<h1 class="uk-accordion-title uk-margin-top uk-margin-bottom">สาขาวิชา: <?php echo $major->major_name; ?></h1>
						<div class="uk-accordion-content">
						<?php
						foreach ($major->minors as $minor) {
							?>
							<h3 class="uk-alert uk-alert-primary uk-margin-large-top">สาขางาน: <?php echo $minor->minor_name; ?></h3>
							<?php
							foreach ($minor->groups as $group) {
							?>
							<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
								<div class="uk-grid uk-grid-small uk-hidden-large">
									<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold"><h3 class="uk-text-danger">กลุ่ม:</h3></div>
									<div class="uk-width-small-7-10">
										<h3 class="uk-text-danger"><?php echo $group->group_name; ?></h3>
									</div>
								</div>
								<table class="uk-table uk-table-hover uk-table-responsive uk-table-striped" cellpadding="1">
									<thead>
										<tr>
											<th class="uk-text-bold uk-text-danger">กลุ่ม: <?php echo $group->group_name; ?></th>
											<th class="uk-alert uk-alert-success uk-text-center" colspan="<?php echo count($homerooms); ?>">สัปดาห์กิจกรรม</th>
											<th></th>
											<th></th>
										</tr>
										<tr>
											<th>
												ครูที่ปรึกษา
											</th>
											<?php
											foreach ($homerooms as $homeroom) {
											?>
											<th><?php echo $homeroom->week; ?></th>
											<?php
											}
											?>
											<th>
												สัปดาห์
											</th>
											<th>
												ร้อยละ
											</th>
										</tr>
									</thead>
									<tbody>
									<?php
										foreach ($group->advisors as $advisor) {
									?>
									<tr>
										<td>
											<div class="uk-grid uk-grid-small">
												<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ครูที่ปรึกษา</div>
												<div class="uk-width-small-7-10">
													<?php echo $advisor->firstname.' '.$advisor->lastname; ?>
												</div>
											</div>
										</td>
										<?php
											foreach ($advisor->homerooms as $homeroom) {
												$tmp_icon_text = '<i class="uk-icon-close uk-button-danger"></i>';
												if($homeroom->is_check==1){
													$tmp_icon_text = '<i class="uk-icon-check uk-button-success"></i>';
												}
											?>
											<td class="uk-text-middle">
												<div class="uk-grid uk-grid-small">
													<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สัปดาห์ที่: <?php echo $homeroom->week; ?></div>
													<div class="uk-width-small-7-10">
														<?php echo $tmp_icon_text; ?>
													</div>
												</div>
											</td>
										<?php
										}
										?>
										<td class="uk-text-middle">
											<div class="uk-grid uk-grid-small">
												<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รวมจำนวนสัปดาห์</div>
												<div class="uk-width-small-7-10">
													<?php echo $advisor->stats_num_homeroom; ?>
												</div>
											</div>
										</td>
										<td class="uk-text-middle">
											<div class="uk-grid uk-grid-small">
												<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">คิดเป็นร้อยละ</div>
												<div class="uk-width-small-7-10">
													<?php echo $advisor->stats_num_checked_percent; ?>%
												</div>
											</div>
										</td>
									</tr>
									<?php
									}
									?>
									</tbody>
								</table>
							</div>
							<?php
							}
						} ?>
						</div>
					<?php
					} // major
					?>
					</div>
				<?php
				} // semester
				?>
            </form>
		</div>
	</div>
</div>
