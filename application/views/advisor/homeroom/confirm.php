<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h2>บันทึกกิจกรรมโฮมรูม > ยืนยันบันทึกข้อมูล สัปดาห์ที่ (<?php echo $homeroom->week;?>)</h2>
				</div>
			</div>
			<hr/>
            <form action="<?php echo base_url('advisor/homeroom/confirm_save');?>" method="post" name="adminForm" id="adminForm">
				<div class="uk-grid uk-grid-small">
					<a class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("advisor/homeroom/activity/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 1: เช็คชื่อ</a>
					<a class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("advisor/homeroom/obedience/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 2: การให้โอวาท</a>
					<a class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("advisor/homeroom/risk/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 3: ประเมินความเสี่ยง</a>
					<a class="uk-button uk-margin-small-bottom uk-button-primary uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("advisor/homeroom/confirm/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 4: ยืนยันการบันทึกข้อมูล</a>
				</div>
                <br/><br/>
            	<h2>สรุปผลการเช็คชื่อ และ ประเมินความเสี่ยง</h2>
				<div class="uk-panel uk-panel-box uk-panel-box-primary uk-margin-top">
					<ul class="uk-list uk-list-line">
						<li>นักเรียนทั้งหมด: <?php echo $homeroom->summary->student_totals; ?> คน 
						| มา <?php echo $homeroom->summary->student_come; ?> คน 
						| ขาด <?php echo $homeroom->summary->student_not_come; ?> คน 
						| สาย <?php echo $homeroom->summary->student_late; ?> คน 
						| ลา <?php echo $homeroom->summary->student_leave; ?> คน 
						| เสี่ยง <?php echo $homeroom->summary->student_risk; ?> คน</li>
					</ul>
				</div>

				<?php
                foreach ($homeroom->groups as $group) {
                    if (count($group->students)<=0) {
                        continue;
                    } ?>
            	<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
                    <h3 class="uk-panel-title">กลุ่มการเรียน: <?php echo $group->group_name.' / '.$group->minor_name.' / '.$group->major_name; ?></h3>
                	<hr/>
                	<table class="uk-table uk-table-hover uk-table-responsive uk-table-striped" cellpadding="1">
                		<thead>
                			<tr>
                				<th width="5%" class="title">#</th>
                				<th class="title">
                					รหัสนักเรียน
                				</th>
                				<th class="title">
                					ชื่อ - นามสกุล
                				</th>
                				<th class="title">
                					สถานะเช็คชื่อ
                				</th>
                				<th class="title" width="20%">
                					สถานะความเสี่ยง
                				</th>
                				<th width="30%" class="title" nowrap="nowrap">
                					รายละเอียด / หมายเหตุ
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
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ลำดับที่:</div>
										<div class="uk-width-small-7-10"><?php echo($i++); ?></div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รหัสนักเรียน:</div>
										<div class="uk-width-small-7-10"><?php echo $student->student_code; ?></div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ชื่อ-นามสกุล:</div>
										<div class="uk-width-small-7-10">
											<?php echo $student->firstname; ?> <?php echo $student->lastname; ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สถานะเช็คชื่อ:</div>
										<div class="uk-width-small-7-10">
											<input disabled class="uk-radio" type="checkbox" checked="1"> <?php echo $homeroom_lib->convertStatusText($student->activity_status); ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สถานะความเสี่ยง:</div>
										<div class="uk-width-small-7-10">
											<input disabled class="uk-radio" type="checkbox" checked="1"> <?php echo $homeroom_lib->convertStatusText($student->risk_status); ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-collapse">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">รายละเอียด / หมายเหตุ:</div>
										<div class="uk-width-small-7-10">
											<div><?php echo $student->risk_detail; ?></div>
											<div><?php echo $student->risk_comment; ?></div>
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
            	
            	
            	<br/><br/>
            	<h2>สรุปผลการให้โอวาท</h2>
            	<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
                   <div>
                   		<h3>- เรื่องที่ให้คำแนะนำนักเรียน นักศึกษา</h3>
						<hr/>
                   		<div>
							<div class="uk-alert">
                   			<?php
                               if (isset($group->obedience)) {
                                   echo nl2br($group->obedience->obe_detail);
                               }?>
							</div>
                   		</div>
                   		<hr/>
						
                   		<h3>- รูปภาพขณะให้คำแนะนำนักเรียน นักศึกษา เพื่อใช้ประกอบการจัดทำรายงาน</h3>
                   		<div>
							<?php
                            foreach ($group->attachments as $file) {
                                ?>
                   				<div><img class="uk-thumbnail" src="<?php echo base_url($file->img_path); ?>" alt=""></div>
							<?php
                            } ?>
						</div>
                   </div>
            	</div>
            	
            	<input type="hidden" name="homeroom_id" value="<?php echo $homeroom->id;?>" />
            	<input type="hidden" name="group_id" value="<?php echo $group_id;?>" />
            </form>
            
            <br/><br/>
        	<div class="uk-panel uk-panel-box uk-panel-box-primary uk-margin-top uk-text-center">
			<?php echo $this->homeroom_lib->getConfirmButton($group->advisors, 'advisor/homeroom'); ?>
			<div id="confirm-form" class="uk-modal">
                    <div class="uk-modal-dialog">
                    	<a class="uk-modal-close uk-close"></a>
                    	<div class="uk-modal-header">คุณแน่ใจนะที่จะบันทึกข้อมูลหรือไม่?</div>
                        <div>
							<h2 class="uk-text-danger">
							กรุณาตรวจสอบการกรอกข้อมูลให้ถูกต้องและครบถ้วน<br/>
							เมื่อกดปุ่ม "ยืนยันการบันทึกข้อมูล"<br/>
							จะไม่สามารถแก้ไขข้อมูลได้</div>
                        	<div class="uk-margin-top uk-margin-bottom"><img src="<?php echo $profile->signature; ?>" /></div>
                        	<button class="uk-button uk-modal-close">ยกเลิก</button>
                        	<button class="uk-button uk-button-primary" onclick="document.getElementById('adminForm').submit();">ยืนยันการบันทึกข้อมูล</button>
                        </div>
                    </div>
                </div>
        	</div>

		</div>
	</div>
</div>
