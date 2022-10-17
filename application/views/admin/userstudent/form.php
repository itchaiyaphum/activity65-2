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
        				<a href="<?php echo base_url('/admin/userstudent/');?>" class="uk-button uk-button-danger">ยกเลิก</a>
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
                    <label class="uk-form-label" for="form-h-it">รหัสนักเรียน *</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="student_id" value="<?php echo $item->student_id;?>" class="uk-width-1-2">
                    	<div>
                        <?php echo form_error('student_id'); ?>
                		<?php echo isset($errors['student_id'])?$errors['student_id']:''; ?>
                		</div>
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">กลุ่มการเรียน *</label>
                    <div class="uk-form-controls">
                        <select name="group_id"  class="uk-width-1-2">
                        	<option value="0">- เลือกกลุ่มการเรียน -</option>
                        		<?php
                                for ($i=0; $i<count($major_items); $i++) {
                                    $row_major = $major_items[$i]; ?>
                            		<option value="0" disabled>-| <?php echo $row_major->major_name; ?></option>
                            		<?php
                                    for ($j=0; $j<count($minor_items); $j++) {
                                        $row_minor = $minor_items[$j];
                                        if ($row_major->id==$row_minor->major_id) {
                                            ?>
                                    		<option value="0" disabled>---| <?php echo $row_minor->minor_name; ?></option>
                                        	<?php
                                            for ($k=0; $k<count($group_items); $k++) {
                                                $row = $group_items[$k];
                                                if ($row_minor->id==$row->minor_id) {
                                                    ?>
                                			<option value="<?php echo $row->id; ?>" <?php echo ($row->id==$item->group_id)?'selected="selected"':''; ?>>------| <?php echo $row->group_name; ?></option>
                                			<?php
                                                }
                                            }
                                        }
                                    } ?>
                            	<?php
                                }
                                ?>
                        </select>
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
            	
            	<input type="hidden" name="id" value="<?php echo $item->id;?>" />
            <?php echo form_close(); ?>
		</div>
	</div>
</div>
