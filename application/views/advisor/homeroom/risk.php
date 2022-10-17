<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h2>บันทึกกิจกรรมโฮมรูม > ประเมินความเสี่ยง สัปดาห์ที่ (<?php echo $homeroom->week;?>)</h2>
				</div>
			</div>
			<hr/>
			
			<div class="uk-grid uk-grid-small">
				<a class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("advisor/homeroom/activity/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 1: เช็คชื่อ</a>
				<a class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("advisor/homeroom/obedience/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 2: การให้โอวาท</a>
				<a class="uk-button uk-button-primary uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("advisor/homeroom/risk/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 3: ประเมินความเสี่ยง</a>
				<a class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("advisor/homeroom/confirm/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 4: ยืนยันการบันทึกข้อมูล</a>
			</div>

            <form action="<?php echo base_url('advisor/homeroom/risk_save');?>" method="post" name="adminForm" id="adminForm">
			<?php
                foreach ($homeroom->groups as $group) {
                    ?>
            	<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
                    <h3 class="uk-panel-title">กลุ่มการเรียน: <?php echo $group->group_name.' / '.$group->minor_name.' / '.$group->major_name; ?></h3>
                	<hr/>
                	<table class="uk-table uk-table-hover uk-table-responsive uk-table-striped" cellpadding="1">
                		<thead>
                			<tr>
                				<th width="5%" class="title">#</th>
                				<th class="title">
                					รหัส
                				</th>
                				<th class="title">
                					ชื่อ - นามสกุล
                				</th>
                				<th class="title">
                					รายละเอียด
                				</th>
                				<th class="title">
                					หมายเหตุ
                				</th>
                				<th width="30%" >
                					สถานะความเสี่ยง
                				</th>
                			</tr>
                		</thead>
                		<tbody>
                		<?php
                        if (count($group->students)<=0) {
                            echo '<tr><td colspan="6" class="uk-text-center"><p>ไม่มีข้อมูล</p></td></tr>';
                        } else {
                            $i = 1;
                            foreach ($group->students as $student) {
                                ?>
                			<tr>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ลำดับที่: </div>
										<div class="uk-width-small-7-10"><?php echo($i++); ?></div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รหัสนักเรียน: </div>
										<div class="uk-width-small-7-10"><?php echo $student->student_code; ?></div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ชื่อ-นามสกุล: </div>
										<div class="uk-width-small-7-10">
											<?php echo $student->firstname; ?> <?php echo $student->lastname; ?>
										</div>
									</div>
                				</td>
								<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รายละเอียด:</div>
										<div class="uk-width-small-7-10">
											<input type="text" class="uk-input uk-width-small-1-1" name="student_items[<?php echo $student->id; ?>][detail]" value="<?php echo $student->risk_detail; ?>"/>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">หมายเหตุ:</div>
										<div class="uk-width-small-7-10">
											<input type="text" class="uk-input uk-width-small-1-1" name="student_items[<?php echo $student->id; ?>][comment]" value="<?php echo $student->risk_comment; ?>"/>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สถานะความเสี่ยง: </div>
										<div class="uk-width-small-7-10">
											<input class="uk-radio" type="radio" name="student_items[<?php echo $student->id; ?>][status]" value="risk" <?php echo ($student->risk_status=='risk')?'checked="1"':''; ?>> เสี่ยง
                							<input class="uk-radio" type="radio" name="student_items[<?php echo $student->id; ?>][status]" value="not_risk" <?php echo ($student->risk_status=='not_risk')?'checked="1"':''; ?>> ไม่เสี่ยง
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
            	<?php
                } ?>

				<input type="hidden" name="id" value="0" />
            	<input type="hidden" name="homeroom_id" value="<?php echo $homeroom->id;?>" />
            	<input type="hidden" name="group_id" value="<?php echo $group_id;?>" />
			</form>
			
			<br/><br/>
        	<div class="uk-panel uk-panel-box uk-panel-box-primary uk-margin-top uk-text-center">
				<?php echo $this->homeroom_lib->getSaveButton($group->advisors, 'advisor/homeroom'); ?>
        		<div id="confirm-form" class="uk-modal">
                    <div class="uk-modal-dialog">
                    	<a class="uk-modal-close uk-close"></a>
                    	<div class="uk-modal-header">กรุณากดยินยันการบันทึกข้อมูลอีกครั้ง?</div>
                        <div>
                        	<button class="uk-button uk-modal-close">ยกเลิก</button>
                        	<button class="uk-button uk-button-primary" onclick="document.getElementById('adminForm').submit();">ยืนยันการบันทึกข้อมูล</button>
                        </div>
                    </div>
                </div>
        	</div>

		</div>
	</div>
</div>
