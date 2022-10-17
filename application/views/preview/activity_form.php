<?php
$activity = array(
	'name'	=> 'activity',
	'id'	=> 'activity',
	'value'	=> (isset($item->activity))?$item->activity:'',
	'rows'	=> 3,
);
$problem = array(
	'name'	=> 'problem',
	'id'	=> 'problem',
	'value'	=> (isset($item->problem))?$item->problem:'',
	'rows'	=> 3,
);
$advantage = array(
	'name'	=> 'advantage',
	'id'	=> 'advantage',
	'value'	=> (isset($item->advantage))?$item->advantage:'',
	'rows'	=> 3,
);
$attributes = array('class' => 'uk-panel uk-panel-box uk-panel-box-secondary uk-form uk-form-horizontal', 'id' => 'forgotform', 'method'=>'post');
?>
<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php $this->load->view('preview/menu');?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h2>บันทึกประจำวัน</h2>
				</div>
			</div>
            <?php echo form_open_multipart($this->uri->uri_string(), $attributes); ?>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('กิจกรรม/งานที่ปฏิบัติ', $activity['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_textarea($activity); ?>
                    <div>
                    	<?php echo form_error($activity['name']); ?>
                    	<?php echo isset($errors[$activity['name']])?$errors[$activity['name']]:''; ?>
                    </div>
                </div>
            </div>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('ปัญหาและอุปสรรค', $problem['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_textarea($problem); ?>
                    <div>
                    	<?php echo form_error($problem['name']); ?>
                    	<?php echo isset($errors[$problem['name']])?$errors[$problem['name']]:''; ?>
                    </div>
                </div>
            </div>
        	<div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"><?php echo form_label('ประโยชน์ที่ได้รับ', $advantage['id']); ?></label>
                <div class="uk-form-controls">
                    <?php echo form_textarea($advantage); ?>
                    <div>
                    	<?php echo form_error($advantage['name']); ?>
                    	<?php echo isset($errors[$advantage['name']])?$errors[$advantage['name']]:''; ?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it">รูปภาพ</label>
                <div class="uk-form-controls">
                    <ul class="uk-list uk-list-line uk-width-medium-3-4">
                		<li><input type="file" name="photo1"></li>
                	</ul>
                	<ul class="uk-list uk-list-line uk-width-medium-3-4">
                	<?php 
                	for($i=0; $i<count($photo_items); $i++){
                	    $photo = $photo_items[$i];
                	    if($photo->week==$week && $photo->day==$day){
                	?>
                	<li>
                		<div class="uk-alert">
                            <a href="<?php echo base_url('/preview/activity/photo_remove/?id='.$photo->id.'&week='.$week.'&day='.$day.'&user_id='.$user_id);?>" class="uk-alert-close uk-close"></a>
                            <p><a target="_blank" href="<?php echo base_url('/storage/photos/'.$photo->file_name);?>"><i class="uk-icon-cloud-download"></i> ดาวน์โหลด: <?php echo $photo->orig_name;?></a></p>
                        </div>
                	</li>
                	<?php 
                	    }
                	} 
                	?>
                	</ul>
                </div>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it">เอกสารดาวน์โหลด</label>
                <div class="uk-form-controls">
                    <ul class="uk-list uk-list-line uk-width-medium-3-4">
                		<li><input type="file" name="file1"></li>
                	</ul>
                	<ul class="uk-list uk-list-line uk-width-medium-3-4">
                	<?php 
                	for($i=0; $i<count($file_items); $i++){
                	    $file = $file_items[$i];
                	    if($file->week==$week && $file->day==$day){
                	?>
                	<li>
                		<div class="uk-alert">
                            <a href="<?php echo base_url('/preview/activity/file_remove/?id='.$file->id.'&week='.$week.'&day='.$day.'&user_id='.$user_id);?>" class="uk-alert-close uk-close"></a>
                            <p><a target="_blank" href="<?php echo base_url('/storage/files/'.$file->file_name);?>"><i class="uk-icon-cloud-download"></i> ดาวน์โหลด: <?php echo $file->orig_name;?></a></p>
                        </div>
                	</li>
                	<?php 
                	    }
                	} 
                	?>
                	</ul>
                </div>
            </div>
            <hr/>
            <div class="uk-form-row">
                <label class="uk-form-label" for="form-h-it"></label>
                <div class="uk-form-controls uk-text-left">
                    <input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success">
                </div>
            </div>
            <input type="hidden" name="week" value="<?php echo $week;?>"/>
            <input type="hidden" name="day" value="<?php echo $day;?>"/>
            <input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
            <input type="hidden" name="internship_id" value="<?php echo $internship_id;?>"/>
            <?php echo form_close(); ?>
		</div>
	</div>
</div>
