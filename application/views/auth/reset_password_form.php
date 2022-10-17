<?php
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);

$attributes = array('class' => 'uk-panel uk-panel-box uk-panel-box-secondary uk-form uk-form-horizontal', 'id' => 'forgotform', 'method'=>'post');
?>
<div class="uk-vertical-align uk-height-1-1 uk-margin-large-top uk-margin-large-bottom uk-text-center">
	<div class="uk-vertical-align-middle" style="width: 450px;">
    <h3>เปลี่ยนรหัสผ่านใหม่</h3>
    <?php echo form_open($this->uri->uri_string(), $attributes); ?>
    <div class="uk-form-row">
        <label class="uk-form-label" for="form-h-it"><?php echo form_label('รหัสผ่านใหม่', $new_password['id']); ?></label>
        <div class="uk-form-controls">
            <?php echo form_password($new_password); ?>
            <div>
            	<?php echo form_error($new_password['name']); ?>
            	<?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?>
            </div>
        </div>
    </div>
    <div class="uk-form-row">
        <label class="uk-form-label" for="form-h-it"><?php echo form_label('ยืนยันรหัสผ่านใหม่', $confirm_new_password['id']); ?></label>
        <div class="uk-form-controls">
            <?php echo form_password($confirm_new_password); ?>
            <div>
            	<?php echo form_error($confirm_new_password['name']); ?>
            	<?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?>
            </div>
        </div>
    </div>
    <div class="uk-form-row">
        <label class="uk-form-label" for="form-h-it"></label>
        <div class="uk-form-controls">
            <input type="submit" value="เปลี่ยนรหัสผ่าน" class="uk-button uk-button-success">
        </div>
    </div>
    <?php echo form_close(); ?>
	</div>
</div>