<?php
$profile = $this->profile_lib->getData();

$firstname = array(
    'name'	=> 'firstname',
    'id'	=> 'firstname',
    'value'	=> $profile->firstname,
    'class' => 'uk-width-large-1-1'
);
$lastname = array(
    'name'	=> 'lastname',
    'id'	=> 'lastname',
    'value'	=> $profile->lastname,
    'class' => 'uk-width-large-1-1'
);
$email = array(
    'name'	=> 'email',
    'id'	=> 'email',
    'value'	=> $profile->email,
    'size'	=> 30,
    'class' => 'uk-width-large-1-1'
);

$attributes = array('class' => 'uk-form uk-form-horizontal', 'id' => 'loginform', 'method'=>'post');
?>
<div class="uk-container uk-container-center">
    <h1 class='uk-text-large uk-margin-top'><i class="uk-icon-pencil"></i> แก้ไขข้อมูลส่วนตัว</h1>
    <hr/>
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php $this->load->view('settings/menu');?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <div class="uk-height-1-1 uk-margin-large-bottom">
                <?php echo (!empty($messages))?$messages:""; ?>
            	<?php echo form_open_multipart($this->uri->uri_string(), $attributes); ?>
           	 		<div class="uk-grid">
           	 			<div class="uk-width-large-3-4">
                            <div class="uk-form-row">
                                <label class="uk-form-label" ><?php echo form_label("อีเมล์", $email['id']); ?></label>
                                <div class="uk-form-controls">
                                    <?php echo form_input($email); ?>
                                	<div>
                                    	<?php echo form_error($email['name']); ?>
                                    	<?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" ><?php echo form_label("ชื่อ", $firstname['id']); ?></label>
                                <div class="uk-form-controls">
                                	<?php echo form_input($firstname); ?>
                                	<div>
                                    	<?php echo form_error($firstname['name']); ?>
                                    	<?php echo isset($errors[$firstname['name']])?$errors[$firstname['name']]:''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label" ><?php echo form_label("นามสกุล", $lastname['id']); ?></label>
                                <div class="uk-form-controls">
                                	<?php echo form_input($lastname); ?>
                                	<div>
                                    	<?php echo form_error($lastname['name']); ?>
                                    	<?php echo isset($errors[$lastname['name']])?$errors[$lastname['name']]:''; ?>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="uk-form-row">
                                <label class="uk-form-label" >รูปภาพส่วนตัว</label>
                                <div class="uk-form-controls">
                                	<img class="uk-border-circle" width="120" height="120" src="<?php echo $profile->thumbnail;?>">
                                    <br/><br/>
                                    <div><input type="file" name="thumbnail"></div>
                                </div>
                            </div>

                            <hr/>
                            <div class="uk-form-row">
                                <label class="uk-form-label" >ลายเซนต์ประจำตัว</label>
                                <div class="uk-form-controls">
                                	<img class="uk-border-rounded" width="350" height="250" src="<?php echo $profile->signature;?>">
                                    <br/><br/>
                                    <div><input type="file" name="signature"></div>
                                </div>
                            </div>
                		</div>
                	</div>
                    
                    <hr/>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="form-h-it"></label>
                        <div class="uk-form-controls uk-text-left">
                            <input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success uk-width-large-1-2">
                        </div>
                    </div>
                    
                <?php echo form_close(); ?>
            </div>
		</div>
	</div>
</div>
