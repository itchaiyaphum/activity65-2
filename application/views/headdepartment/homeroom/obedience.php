<?php
$attributes = array('class' => 'uk-form uk-form-horizontal', 'id' => 'adminForm', 'method'=>'post');
$obedience_id = 0;
?>
<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h2>บันทึกกิจกรรมโฮมรูม > ให้โอวาท สัปดาห์ที่ (<?php echo $homeroom->week;?>)</h2>
				</div>
			</div>
			<hr/>
			<?php echo form_open_multipart(base_url("headdepartment/homeroom/obedience/?id=".$homeroom->id."&group_id=".$group_id), $attributes); ?>
				<div class="uk-grid uk-grid-small">
					<a class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4 " href="<?php echo base_url("headdepartment/homeroom/activity/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 1: เช็คชื่อ</a>
					<a  class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4 uk-button-primary" href="<?php echo base_url("headdepartment/homeroom/obedience/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 2: การให้โอวาท</a>
					<a  class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4 " href="<?php echo base_url("headdepartment/homeroom/risk/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 3: ประเมินความเสี่ยง</a>
					<a  class="uk-button uk-margin-small-bottom uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4" href="<?php echo base_url("headdepartment/homeroom/confirm/?id=".$homeroom->id."&group_id=".$group_id);?>">STEP 4: ยืนยันการบันทึกข้อมูล</a>
				</div>

				<?php
                foreach ($homeroom->groups as $group) {
                    $obedience_id = $group->obedience->obe_id; ?>
            	<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
                    <h2>แบบบันทึกรายงาน การปฏิบัติงานของครูที่ปรึกษา</h2>
                	<hr/>
                	<h3 class="uk-panel-title">เรื่องที่ให้คำแนะนำ นักเรียน นักศึกษา</h3>
                	<div>
                		<textarea name="obe_detail" cols="" rows="10" class="uk-width-1-1"><?php echo $group->obedience->obe_detail; ?></textarea>
						<?php echo form_error('obe_detail', '<div class="uk-alert uk-alert-danger">', '</div>'); ?>
					</div>
            	</div>
				
               	<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
               		<br/>
                	<h3 class="uk-panel-title">แบบประเมินตนเอง สำหรับนักเรียน นักศึกษา โดยผ่านการสแกน QR Code เพื่อเป็นการเฝ้าระวังและป้องกันการแพร่ระบาดของโควิต 19</h3>
                	<hr/>
               		<h3>สถิติการตอบแบบสอบถามประเมินตนเอง</h3>
               		<div>
               			<ul class="uk-list uk-list-line">
               				<li>จำนวนผู้ตอบแบบสอบถามการคัดกรอง: <input type="number" name="survey_amount" min="0" max="<?php echo $group->obedience->student_totals; ?>" class="uk-form-width-mini uk-form-small" value="<?php echo $group->obedience->survey_amount; ?>"/> คน</li>
               				<li>นักเรียนทั้งหมด: (<?php echo $group->obedience->student_totals; ?>) คน</li>
               			</ul>
						<?php echo form_error('survey_amount', '<div class="uk-alert uk-alert-danger">', '</div>'); ?>
               		</div>
               	</div>
               	
               	<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
               		
               		<h3>รูปภาพขณะให้คำแนะนำนักเรียน นักศึกษา เพื่อใช้ประกอบการจัดทำรายงาน</h3>
               		<hr/>
               		<div class="uk-margin-top">
               			<div>กรุณาเลือกไฟล์รูปภาพ 2 รูป</div>
               			<input type="file" class="uk-button uk-width-1-2 uk-margin-top" name="upload_file_1"/>
               			<input type="file" class="uk-button uk-width-1-2 uk-margin-top" name="upload_file_2"/>
						<div class="uk-margin-top">
						<?php
                        foreach ($group->attachments as $file) {
                            ?>
							<img class="uk-thumbnail uk-width-1-1" src="<?php echo base_url($file->img_path); ?>" alt="">
						<?php
                        } ?>
						</div>
               		</div>
              	</div>
				<?php
                }
                ?>
            	
            	<input type="hidden" name="id" value="<?php echo $obedience_id;?>" />
            	<input type="hidden" name="group_id" value="<?php echo $group_id;?>" />
            	<input type="hidden" name="homeroom_id" value="<?php echo $homeroom->id;?>" />
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
