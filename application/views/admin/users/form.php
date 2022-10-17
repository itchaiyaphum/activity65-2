<?php
$attributes = array('class' => 'uk-form uk-form-horizontal', 'name' => 'adminForm', 'id' => 'adminForm', 'method'=>'post');
?>
<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <?php echo form_open($this->uri->uri_string(), $attributes); ?>
    			<div class="uk-clearfix">
    				<div class="uk-float-left">
    					<h1>จัดการข้อมูลผู้ใช้ [<?php echo (is_null($item->id))?'เพิ่ม':'แก้ไข';?>]</h1>
    				</div>
        			<div class="uk-float-right">
        				<input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success"/>
        				<a href="<?php echo base_url('/admin/users/');?>" class="uk-button uk-button-danger">ยกเลิก</a>
        			</div>
    			</div>
    			<hr/>
    			<div>
    			<?php echo isset($errors['global'])?$errors['global']:''; ?>
    			</div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ชื่อ *</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="firstname" value="<?php echo $item->firstname;?>" class="uk-width-1-2">
                    	<div>
                        <?php echo form_error('firstname'); ?>
                		<?php echo isset($errors['firstname'])?$errors['firstname']:''; ?>
                		</div>
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">นามสกุล *</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="lastname" value="<?php echo $item->lastname;?>" class="uk-width-1-2">
                    	<div>
                        <?php echo form_error('lastname'); ?>
                		<?php echo isset($errors['lastname'])?$errors['lastname']:''; ?>
                		</div>
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ประเภทผู้ใช้ *</label>
                    <div class="uk-form-controls">
                    	<select name="user_type" class="uk-width-1-2">
                        	<option value="">- เลือกประเภทผู้ใช้ -</option>
                        	<option value="student" <?php echo ($item->user_type=='student')?'selected="selected"':'';?>>นักศึกษา (Student)</option>
                        	<option value="advisor" <?php echo ($item->user_type=='advisor')?'selected="selected"':'';?>>อาจารย์ที่ปรึกษา (Advisor)</option>
                        	<option value="headdepartment" <?php echo ($item->user_type=='headdepartment')?'selected="selected"':'';?>>หัวหน้าแผนกฯ (Head of Department)</option>
                        	<option value="headadvisor" <?php echo ($item->user_type=='headadvisor')?'selected="selected"':'';?>>หัวหน้างานครูที่ปรึกษา (Head of Advisor)</option>
                        	<option value="staff" <?php echo ($item->user_type=='staff')?'selected="selected"':'';?>>เจ้าหน้าที่งานครูที่ปรึกษา (Staff)</option>
                        	<option value="executive" <?php echo ($item->user_type=='executive')?'selected="selected"':'';?>>ฝ่ายบริหาร (Executive)</option>
                        	<option value="admin" <?php echo ($item->user_type=='admin')?'selected="selected"':'';?>>ผู้ดูแลระบบ (Admin)</option>
                        </select>
                        <div>
                        <?php echo form_error('user_type'); ?>
                		<?php echo isset($errors['user_type'])?$errors['user_type']:''; ?>
                		</div>
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">อีเมล์ *</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="email" value="<?php echo $item->email;?>" class="uk-width-1-2">
                        <div>
                        <?php echo form_error('email'); ?>
                		<?php echo isset($errors['email'])?$errors['email']:''; ?>
                		</div>
                    </div>
                </div>
				<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">รหัสผ่าน</label>
                    <div class="uk-form-controls">
                        <input type="password" id="form-h-it" name="new_password" class="uk-width-1-2">
                        <div>
                        <?php echo form_error('new_password'); ?>
                		<?php echo isset($errors['new_password'])?$errors['new_password']:''; ?>
                		</div>
                    </div>
                </div>
				<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ยืนยันรหัสผ่าน</label>
                    <div class="uk-form-controls">
                        <input type="password" id="form-h-it" name="confirm_password" class="uk-width-1-2">
                        <div>
                        <?php echo form_error('confirm_password'); ?>
                		<?php echo isset($errors['confirm_password'])?$errors['confirm_password']:''; ?>
                		</div>
                    </div>
                </div>
            	<input type="hidden" name="id" value="<?php echo $item->id;?>" />
            <?php echo form_close(); ?>
		</div>
	</div>
</div>
