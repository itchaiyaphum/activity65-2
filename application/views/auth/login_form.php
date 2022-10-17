<?php
$login = array(
    'name'	=> 'login',
    'id'	=> 'login',
    'value' => set_value('login'),
    'maxlength'	=> 80,
    'size'	=> 30,
    'class' => 'uk-width-large-1-1'
);
if ($login_by_username and $login_by_email) {
    $login_label = 'อีเมล์ หรือ ชื่อผู้ใช้';
} elseif ($login_by_username) {
    $login_label = 'ชื่อผู้ใช้';
} else {
    $login_label = 'อีเมล์';
}
$password = array(
    'name'	=> 'password',
    'id'	=> 'password',
    'size'	=> 30,
    'class' => 'uk-width-large-1-1'
);
$captcha = array(
    'name'	=> 'captcha',
    'id'	=> 'captcha',
    'maxlength'	=> 8,
    'class' => 'uk-width-large-1-1'
);
$attributes = array('class' => 'uk-panel uk-panel-box uk-panel-box-secondary uk-form uk-form-horizontal', 'id' => 'loginform', 'method'=>'post');
?>
<div class="uk-vertical-align uk-text-center uk-height-1-1 uk-margin-large-top uk-margin-large-bottom">
	<div class="uk-vertical-align-middle" style="width: 450px;">
		<h3>ลงชื่อเข้าสู่ระบบ</h3>
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
            <label class="uk-form-label" for="form-h-it"><?php echo form_label('รผัสผ่าน', $password['id']); ?></label>
            <div class="uk-form-controls">
                <?php echo form_password($password); ?>
                <div>
                <?php echo form_error($password['name']); ?>
                <?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
                </div>
            </div>
        </div>
        <?php
        if ($show_captcha) {
            if ($use_recaptcha) {
                ?>
        <div class="uk-form-row">
            <div class="uk-form-controls" style="margin-left: 50px;">
                <div id="recaptcha_image"></div>
                <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
            </div>
        </div>
        <div class="uk-form-row">
            <div class="uk-form-controls"">
            	<label class="uk-form-label" for="form-h-it">กรอกรหัสที่ปรากฏ</label>
                <div>
                	 <?php
                     echo form_input(array(
                        'name'	=> 'recaptcha_response_field',
                        'id'	=> 'recaptcha_response_field',
                        'size'	=> 30,
                     )); ?>
                </div>
                <div>
                	<?php echo form_error('recaptcha_response_field'); ?>
                </div>
                <?php echo $recaptcha_html; ?>
            </div>
        </div>
        <?php
            } else { ?>
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
                <input type="submit" value="เข้าสู่ระบบ" class="uk-button uk-button-success uk-width-large-1-1">
            </div>
        </div>
        <!--
        <hr/>
        <div class="uk-text-center">
            <div><?php echo anchor('/auth/forgot_password/', 'ลืมรหัสผ่าน'); ?> | <?php if ($this->config->item('allow_registration', 'tank_auth')) {
            echo anchor('/auth/register/', 'สมัครสมาชิกใหม่');
        } ?></div>
        </div>
        -->
        <input type="hidden" name="remember" value="1"/>
        <?php echo form_close(); ?>
	</div>
</div>