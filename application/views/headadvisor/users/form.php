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
    					<h1>จัดการข้อมูลครูที่ปรึกษา [<?php echo (is_null($item->id))?'เพิ่ม':'แก้ไข';?>]</h1>
    				</div>
        			<div class="uk-float-right">
        				<input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success"/>
        				<a href="<?php echo base_url('/headadvisor/users/');?>" class="uk-button uk-button-danger">ยกเลิก</a>
        			</div>
    			</div>
    			<hr/>
    			<div>
    			<?php echo isset($errors['global'])?$errors['global']:''; ?>
    			</div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ชื่อ</label>
                    <div class="uk-form-controls">
                        <input type="text" class='uk-width-small-1-1' name="firstname" value="<?php echo $item->firstname;?>" class="uk-width-1-2">
                    	<div>
                        <?php echo form_error('firstname'); ?>
                		<?php echo isset($errors['firstname'])?$errors['firstname']:''; ?>
                		</div>
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">นามสกุล</label>
                    <div class="uk-form-controls">
                        <input type="text" class='uk-width-small-1-1' name="lastname" value="<?php echo $item->lastname;?>" class="uk-width-1-2">
                    	<div>
                        <?php echo form_error('lastname'); ?>
                		<?php echo isset($errors['lastname'])?$errors['lastname']:''; ?>
                		</div>
                    </div>
                </div>
				<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">อีเมล์</label>
                    <div class="uk-form-controls">
                        <input type="text" class='uk-width-small-1-1' name="email" value="<?php echo $item->email;?>" class="uk-width-1-2">
                        <div>
                        <?php echo form_error('email'); ?>
                		<?php echo isset($errors['email'])?$errors['email']:''; ?>
                		</div>
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ประเภทผู้ใช้</label>
                    <div class="uk-form-controls">
                    	<select name="user_type" class="uk-width-small-1-1">
                        	<option value="advisor" <?php echo ($item->user_type=='advisor')?'selected="selected"':'';?>>อาจารย์ที่ปรึกษา (Advisor)</option>
                        	<option value="headdepartment" <?php echo ($item->user_type=='headdepartment')?'selected="selected"':'';?>>หัวหน้าแผนกฯ (Head of Department)</option>
                        </select>
                        <div>
                        <?php echo form_error('user_type'); ?>
                		<?php echo isset($errors['user_type'])?$errors['user_type']:''; ?>
                		</div>
                    </div>
                </div>
				<div class="uk-form-row">
					<label class="uk-form-label" >สถานศึกษา</label>
					<div class="uk-form-controls">
						<select name="college_id" id="college_id" class="uk-width-small-1-1">
						<option value="0">--- เลือกสถานศึกษา ---</option>
						<?php
                        for ($i=0; $i<count($college_items); $i++) {
                            $college = $college_items[$i]; ?>
							<option value="<?php echo $college->id; ?>" <?php echo ($item_profile->college_id==$college->id)?' selected="selected" ':''; ?>><?php echo $college->name; ?></option>
							<?php
                        }
                        ?>
						</select>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" >แผนกวิชา</label>
					<div class="uk-form-controls">
						<select name="major_id" id="major_id" class="uk-width-small-1-1">
						<option value="0">--- เลือกแผนกวิชา ---</option>
						<?php
                        for ($i=0; $i<count($college_items); $i++) {
                            $college = $college_items[$i]; ?>
							<option disabled>-| <?php echo $college->name; ?></option>
							<?php
                            for ($j=0; $j<count($major_items); $j++) {
                                $major = $major_items[$j];
                                echo $major->college_id.'===='.$college->id;
                                if ($major->college_id==$college->id) {
                                    ?>
									<option value="<?php echo $major->id; ?>" <?php echo ($item_profile->major_id==$major->id)?' selected="selected" ':''; ?>>---| <?php echo $major->major_name; ?></option>
								<?php
                                }
                            }
                        }
                        ?>
						</select>
					</div>
				</div>
            	
            	<input type="hidden" name="id" value="<?php echo $item->id;?>" />
            <?php echo form_close(); ?>
		</div>
	</div>
</div>
