<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h2>บันทึกกิจกรรมโฮมรูม > เช็คชื่อ สัปดาห์ที่ (<?php echo $homeroom->week;?>)</h2>
				</div>
			</div>
			<hr/>
            <form action="<?php echo base_url('headdepartment/homeroom/activity_save');?>" method="post" name="adminForm" id="adminForm">
				<div class="uk-grid uk-grid-small">
					<a class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4 uk-button-primary" href="<?php echo base_url("headdepartment/homeroom/activity/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 1: เช็คชื่อ</a>
					<a  class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("headdepartment/homeroom/obedience/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 2: การให้โอวาท</a>
					<a  class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4 " href="<?php echo base_url("headdepartment/homeroom/risk/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 3: ประเมินความเสี่ยง</a>
					<a  class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("headdepartment/homeroom/confirm/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 4: ยืนยันการบันทึกข้อมูล</a>
				</div>

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
                				<th class="title" width="15%">
                					รหัสนักเรียน
                				</th>
                				<th class="title">
                					ชื่อ - นามสกุล
                				</th>
                				<th class="title" width="40%">
                					สถานะการเข้าร่วม
                				</th>
                			</tr>
                		</thead>
                		<tbody>
                		<?php
                        if (count($group->students)<=0) {
                            echo '<tr><td colspan="6" class="uk-text-center"><p>ไม่มีข้อมูล</p></td></tr>';
                        } else {
                            $i=1;
                            foreach ($group->students as $student) {
                                ?>
                			<tr>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ลำดับที่:</div>
										<div class="uk-width-small-7-10">
											<?php echo($i++); ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รหัสนักเรียน:</div>
										<div class="uk-width-small-7-10">
											<?php echo $student->student_code; ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ชื่อ - นามสกุล:</div>
										<div class="uk-width-small-7-10">
											<?php echo $student->firstname; ?> <?php echo $student->lastname; ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สถานะการเข้าร่วม:</div>
										<div class="uk-width-small-7-10">
											<input class="uk-radio" type="radio" name="join_status[<?php echo $student->id; ?>]" value="come" <?php echo ($student->activity_status=='come')?'checked="1"':''; ?>> มา
											<input class="uk-radio" type="radio" name="join_status[<?php echo $student->id; ?>]" value="not_come" <?php echo ($student->activity_status=='not_come')?'checked="1"':''; ?>> ขาด
											<input class="uk-radio" type="radio" name="join_status[<?php echo $student->id; ?>]" value="late" <?php echo ($student->activity_status=='late')?'checked="1"':''; ?>> สาย
											<input class="uk-radio" type="radio" name="join_status[<?php echo $student->id; ?>]" value="leave" <?php echo ($student->activity_status=='leave')?'checked="1"':''; ?>> ลา
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
            
            	<input type="hidden" name="homeroom_id" value="<?php echo $homeroom->id;?>" />
            	<input type="hidden" name="group_id" value="<?php echo $group_id;?>" />
            </form>
            
            <br/><br/>
        	<div class="uk-panel uk-panel-box uk-panel-box-primary uk-margin-top uk-text-center">
				<?php echo $this->homeroom_lib->getSaveButton($group->advisors, 'headdepartment/homeroom'); ?>
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
