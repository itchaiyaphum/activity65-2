<?php 
$profileData = $this->profile_lib->getData();
?>
<div class="uk-panel  uk-text-center">
	<img class="uk-border-circle" width="120" height="120" src="<?php echo $profileData->thumbnail;?>" alt="">
	<div class="uk-text-large uk-margin-top"><?php echo $profileData->firstname;?> <?php echo $profileData->lastname;?></div>
	<div><?php echo $profileData->email;?></div>
</div>
<hr />
<ul class="tm-nav uk-nav" data-uk-nav="">
	<li class="uk-nav-header">เมนูหลัก</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('profile');?>">
		<a href="<?php echo base_url('settings/profile'); ?>"><span class="uk-icon-pencil"></span> แก้ไขข้อมูลส่วนตัว</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('password');?>">
		<a href="<?php echo base_url('settings/password/'); ?>"><span class="uk-icon-lock"></span> แก้ไขรหัสผ่าน</a>
	</li>
</ul>
<br/><br/>