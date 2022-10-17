<?php
$attributes = array('class' => 'uk-form uk-form-horizontal', 'name' => 'adminForm', 'id' => 'adminForm', 'method'=>'post');
?>
<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <?php echo form_open(base_url('admin/importdata'), $attributes); ?>
    			<div class="uk-clearfix">
    				<div class="uk-float-left">
    					<h1>Import ข้อมูลลงในระบบ</h1>
    				</div>
        			<div class="uk-float-right">
        				<input type="submit" value="Import Data" class="uk-button uk-button-success"/>
        			</div>
    			</div>
    			<hr/>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">รูปแบบข้อมูล</label>
                    <div class="uk-form-controls">
                    	<select name="data_type" class="uk-width-1-2">
                        	<option value="">- เลือกรูปแบบข้อมูลที่ต้องการดำเนินนการ -</option>
                        	<option value="student">ข้อมูลนักเรียน (Student)</option>
                        	<option value="advisor">ข้อมูลอาจารย์ที่ปรึกษา (Advisor)</option>
                        	<option value="major">ข้อมูลสาขาวิชา (Major)</option>
                        	<option value="minor">ข้อมูลสาขางาน (Minor)</option>
                        	<option value="group">ข้อมูลกลุ่มการเรียน (Group)</option>
                        </select>
                        <div>
							<?php echo form_error('data_type', '<div class="uk-alert">', '</div>'); ?>
                		</div>
                    </div>
                </div>
				<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">วิธีการนำเข้าข้อมูล</label>
                    <div class="uk-form-controls">
						<div>
							<input type="radio" name="update_exists" value="replace" checked /> เขียนทับข้อมูลที่มีอยู่แล้ว (Replace Exists)
							<input type="radio" name="update_exists" value="update" /> อัพเดตข้อมูลที่มีอยู่แล้ว (Update Exists)
						</div>
						<div>
							<?php echo form_error('update_exists'); ?>
                		</div>
                    </div>
                </div>
				<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ข้อมูล CSV Text</label>
                    <div class="uk-form-controls">

						<div>
							<?php echo form_error('csv_data', '<div class="uk-alert">', '</div>'); ?>
							<?php echo isset($errors['csv_data'])?$errors['csv_data']:''; ?>
                		</div>

						<?php
                        if (isset($errors['global'])) {
                            ?>
							<div class="uk-alert"><?php echo $errors['global']; ?></div>
						<?php
                        } ?>

                    	<textarea rows='20' class="uk-width-1-1" name='csv_data'></textarea>
						
						<div class="uk-alert uk-alert-success">นักเรียน (Student): [college_id,major_id,minor_id,group_id,student_id,firstname,lastname,email]</div>
						<div class="uk-alert uk-alert-success">ครูที่ปรึกษา (Advisor): [college_id,major_id,firstname,lastname,email,status]</div>
						<div class="uk-alert uk-alert-success">สาขาวิชา (Major): [college_id,major_code,major_name,major_eng,status]</div>
						<div class="uk-alert uk-alert-success">สาขางาน (Minor): [college_id,major_id,minor_code,minor_name,minor_eng,status]</div>
						<div class="uk-alert uk-alert-success">กลุ่มการเรียน (Group): [group_code,group_name,college_id,major_id,minor_id,status]</div>
                    
						<br/><br/>
						<div class="uk-button-group">
							<a class="uk-button uk-button-primary" href="<?php echo base_url('admin/importdata/autogen_advisor');?>">Auto Gen User Advisor</a>
							<a class="uk-button uk-button-primary" href="<?php echo base_url('admin/importdata/autogen_student');?>">Auto Gen User Student</a>
						</div>

					</div>
                </div>
            <?php echo form_close(); ?>
		</div>
	</div>
</div>
