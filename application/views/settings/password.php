<?php
$old_password = array(
    'name'	=> 'old_password',
    'id'	=> 'old_password',
    'size'	=> 30,
    'class' => 'uk-width-large-1-1'
);
$new_password = array(
    'name'	=> 'new_password',
    'id'	=> 'new_password',
    'size'	=> 30,
    'class' => 'uk-width-large-1-1'
);
$confirm_new_password = array(
    'name'	=> 'confirm_new_password',
    'id'	=> 'confirm_new_password',
    'size'	=> 30,
    'class' => 'uk-width-large-1-1'
);
$attributes = array('class' => 'uk-form uk-form-horizontal', 'id' => 'loginform', 'method'=>'post');
?>
<div class="uk-container uk-container-center">
    <h1 class='uk-text-large uk-margin-top'><i class="uk-icon-pencil"></i> แก้ไขข้อมูลรหัสผ่าน</h1>
    <hr/>
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php $this->load->view('settings/menu');?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <div class="uk-height-1-1 uk-margin-large-bottom">

                <?php echo form_open($this->uri->uri_string(), $attributes); ?>
                <?php if (isset($messages)) { ?>
                <div class="uk-alert uk-alert-success"><?php echo $messages;?></div>
                <?php } ?>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it"><?php echo form_label("รหัสผ่านเดิม:", $old_password['id']); ?></label>
                    <div class="uk-form-controls">
                        <?php echo form_password($old_password); ?>
                        <div>
                        <?php echo form_error($old_password['name']); ?>
                        <?php echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; ?>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it"><?php echo form_label("รหัสผ่านใหม่:", $new_password['id']); ?></label>
                    <div class="uk-form-controls">
                        <?php echo form_password($new_password); ?>
                        <div>
                        <?php echo form_error($new_password['name']); ?>
                        <?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it"><?php echo form_label("ยืนยันรหัสผ่านใหม่:", $confirm_new_password['id']); ?></label>
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
                    <div class="uk-form-controls uk-text-left">
                        <input type="submit" value="บันทึกข้อมูล" class="uk-button uk-width-large-1-2 uk-button-success">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
		</div>
	</div>
</div>
