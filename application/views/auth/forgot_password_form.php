<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'อีเมล์ หรือ ชื่อผู้ใช้';
} else {
	$login_label = 'อีเมล์';
}
$attributes = array('class' => 'uk-panel uk-panel-box uk-panel-box-secondary uk-form uk-form-horizontal', 'id' => 'forgotform', 'method'=>'post');
?>
<div class="uk-vertical-align uk-text-center uk-height-1-1 uk-margin-large-top uk-margin-large-bottom">
	<div class="uk-vertical-align-middle" style="width: 450px;">
    <h3>ลืมรหัสผ่าน</h3>
    <?php echo form_open($this->uri->uri_string(), $attributes); ?>
    <div class="uk-form-row">
        <label class="uk-form-label" for="form-h-it"><?php echo form_label($login_label, $login['id']); ?></label>
        <div class="uk-form-controls">
            <?php echo form_input($login); ?>
            <div>
            	<?php echo form_error($login['name']); ?>
            	<?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
            </div>
        </div>
    </div>
    <div class="uk-form-row">
        <label class="uk-form-label" for="form-h-it"></label>
        <div class="uk-form-controls uk-text-left">
            <input type="submit" value="รับรหัสผ่านใหม่" class="uk-button uk-button-success">
        </div>
    </div>
    <?php echo form_close(); ?>
    </div>
</div>