<?php
$major_name = '';
foreach ($homerooms as $homeroom) {
    $major_name = $homeroom->major_name;
}
?>
<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<form action="<?php echo base_url('headdepartment/approving');?>" method="post" name="adminForm">
				<div class="uk-clearfix">
					<div>
						<h1 class="uk-alert uk-alert-success uk-text-center uk-margin-top uk-margin-bottom">สาขาวิชา: <?php echo $major_name; ?></h1>
						<h2>อนุมัติการบันทึกข้อมูลกิจกรรมโฮมรูม</h2>
					</div>
				</div>
				<hr/>
            	<table class="uk-table uk-table-hover uk-table-responsive uk-table-striped">
            		<tr>
            			<td nowrap="nowrap">
							<!--
							<select>
								<option>== เลือกสาขางานทั้งหมด ==</option>
								<option>เทคโนโลยีสารสนเทศ</option>
								<option>ระบบเครือข่ายคอมพิวเตอร์</option>
								<option>คอมพิวเตอร์กราฟิก</option>
							</select>
							<select>
								<option>== เลือกสัปดาห์ทั้งหมด ==</option>
								<option>สัปดาห์ที่ 1</option>
								<option>สัปดาห์ที่ 2</option>
								<option>สัปดาห์ที่ 3</option>
								<option>สัปดาห์ที่ 4</option>
							</select>
							<select>
								<option>== เลือกครูที่ปรึกษาทั้งหมด ==</option>
								<option>Advisor1 Demo</option>
								<option>Advisor2 Demo</option>
								<option>Advisor3 Demo</option>
								<option>Advisor4 Demo</option>
							</select>
							-->
            			</td>
            		</tr>
            	</table>

				<?php
                foreach ($homerooms as $homeroom) {
                    $major_name = $homeroom->major_name; ?>
					<h2 class="uk-alert uk-alert-primary"><?php echo $homeroom->semester_name.' สัปดาห์ที่: '.$homeroom->week; ?> 
						(<?php echo date_format(date_create($homeroom->join_start), 'Y-m-d').' - '.date_format(date_create($homeroom->join_end), 'Y-m-d'); ?>)</h2>
					<?php
                    foreach ($homeroom->minors as $minor) {
                        $links = array(
                            'approve' => base_url("headdepartment/approving/approve_all/?homeroom_id={$homeroom->id}&minor_id={$minor->minor_id}"),
                            'unapprove' => base_url("headdepartment/approving/unapprove_all/?homeroom_id={$homeroom->id}&minor_id={$minor->minor_id}")
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
									<th width="15%">
										กลุ่มการเรียน
									</th>
									<th width="20%" >
										ครูที่ปรึกษา
									</th>
									<th>
										สถานะบันทึกกิจกรรมโฮมรูม
									</th>
									<th width="35%">
										รับรองจากหัวหน้าแผนก
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
                            if (count($minor->groups)<=0) {
                                echo '<tr><td colspan="7" class="uk-text-center"><p>ไม่มีข้อมูล</p></td></tr>';
                            } else {
                                foreach ($minor->groups as $group) {
                                    $link_confirm = base_url('headdepartment/approving/confirm/?homeroom_id='.$homeroom->id.'&group_id='.$group->group_id); ?>
								<tr>
									<td>
										<div class="uk-grid uk-grid-small">
											<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">กลุ่มการเรียน:</div>
											<div class="uk-width-small-7-10">
												<?php echo $group->group_name; ?>
											</div>
										</div>
									</td>
									<td>
										<div class="uk-grid uk-grid-small">
											<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ครูที่ปรึกษา:</div>
											<div class="uk-width-small-7-10">
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
										<div class="uk-grid uk-grid-small">
											<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สถานะบันทึกกิจกรรมโฮมรูม:</div>
											<div class="uk-width-small-7-10">
												<?php
                                                $links = array(
                                                    'view' => base_url("headdepartment/approving/confirm/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                    'remove' => base_url("headdepartment/approving/remove_confirm/?homeroom_id={$homeroom->id}&group_id={$group->group_id}")
                                                );
                                    echo $this->homeroom_lib->getAdvisorStatusHtml($group->advisors, $group->approving, $links); ?>
											</div>
										</div>
									</td>
									<td>
										<div class="uk-grid uk-grid-small">
											<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รับรองจากหัวหน้าแผนก:</div>
											<div class="uk-width-small-7-10">
												<?php
                                                $links = array(
                                                    'view' => base_url("headdepartment/approving/confirm/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                    'approve' => base_url("headdepartment/approving/approve/?homeroom_id={$homeroom->id}&group_id={$group->group_id}"),
                                                    'remove' => base_url("headdepartment/approving/unapprove/?homeroom_id={$homeroom->id}&group_id={$group->group_id}")
                                                );
                                    echo $this->homeroom_lib->getHeadDepartmentStatusHtml($group->approving, $links); ?>
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
                }?>
            </form>
		</div>
	</div>
</div>
