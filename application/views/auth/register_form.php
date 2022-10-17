<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$firstname = array(
	'name'	=> 'firstname',
	'id'	=> 'firstname',
	'value'	=> set_value('firstname'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$lastname = array(
	'name'	=> 'lastname',
	'id'	=> 'lastname',
	'value'	=> set_value('lastname'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
$attributes = array('class' => 'uk-panel uk-panel-box uk-panel-box-secondary uk-form uk-form-horizontal', 'id' => 'forgotform', 'method'=>'post');
?>
<div class="uk-vertical-align uk-text-center uk-height-1-1 uk-margin-large-top uk-margin-large-bottom">
	<div class="uk-vertical-align-middle" style="width: 450px;">
    <h3>สมัครสมาชิกใหม่</h3>
        <?php echo form_open($this->uri->uri_string(), $attributes); ?>
        	<?php if ($use_username) { ?>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('ชื่อผู้ใช้ (username)', $username['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_input($username); ?>
                    <div>
                    	<?php echo form_error($username['name']); ?>
                    	<?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?>
                    </div>
                </div>
            </div>
        	<?php } ?>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('ชื่อ', $firstname['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_input($firstname); ?>
                    <div>
                    	<?php echo form_error($firstname['name']); ?>
                    	<?php echo isset($errors[$firstname['name']])?$errors[$firstname['name']]:''; ?>
                    </div>
                </div>
            </div>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('นามสกุล', $lastname['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_input($lastname); ?>
                    <div>
                    	<?php echo form_error($lastname['name']); ?>
                    	<?php echo isset($errors[$lastname['name']])?$errors[$lastname['name']]:''; ?>
                    </div>
                </div>
            </div>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('สถานศึกษา', 'organization_id'); ?></label>
                <div class="uk-form-controls uk-text-left">
                	<select name="organization_id" id="organization_id">
                	<option value="0">--- เลือกสถานศึกษา ---</option>
                    <?php 
                    for($i=0; $i<count($colleges); $i++){
                        $college = $colleges[$i];
                        ?>
                        <option value="<?php echo $college->id;?>"><?php echo $college->name;?></option>
                        <?php
                    }
                    ?>
                    </select>
                </div>
            </div>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('อีเมล์', $email['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_input($email); ?>
                    <div>
                    	<?php echo form_error($email['name']); ?>
                    	<?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('รหัสผ่าน', $password['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_password($password); ?>
                    <div>
                    	<?php echo form_error($password['name']); ?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('ยืนยันรหัสผ่าน', $confirm_password['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_password($confirm_password); ?>
                    <div>
                    	<?php echo form_error($confirm_password['name']); ?>
                    </div>
                </div>
            </div>
        	<?php if ($captcha_registration) {
        		if ($use_recaptcha) { 
        	?>
        	<div class="uk-form-row">
                <div class="uk-form-controls" style="margin-left: 50px;">
                    <div id="recaptcha_image"></div>
                    <div>
                    	<a href="javascript:Recaptcha.reload()">เปลี่ยนรหัส CAPTCHA</a>
                    </div>
                </div>
            </div>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it">กรอกรหัสที่ปรากฏ</label>
                <div class="uk-form-controls">
                    <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" size="30"/>
                    <div>
                    	<?php echo form_error('recaptcha_response_field'); ?>
                    </div>
                    <?php echo $recaptcha_html; ?>
                </div>
            </div>
        	<?php } else { ?>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it">กรอกรหัสที่ปรากฏ:</label>
                <div class="uk-form-controls">
                    <?php echo $captcha_html; ?>
                </div>
            </div>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('Confirmation Code', $captcha['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_input($captcha); ?>
                    <div>
                    	<?php echo form_error($captcha['name']); ?>
                    </div>
                </div>
            </div>
        <?php 
        	}
        } 
        ?>
        <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-it"></label>
            <div class="uk-form-controls uk-text-left">
                <input type="submit" value="ลงทะเบียน" class="uk-button uk-button-success">
            </div>
        </div>
        <?php echo form_close(); ?>
	</div>
</div>