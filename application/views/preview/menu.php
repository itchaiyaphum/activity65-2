<?php 
$profileData = $this->profile_lib->getData();
$user_id = $this->input->get('user_id',0);
?>
<ul class="tm-nav uk-nav" data-uk-nav="">
	<li class="uk-nav-header">เมนูหลัก</li>
	<li><a href="<?php echo base_url('/profile/'); ?>"><span class="uk-icon-home"></span> ย้อนกลับหน้าหลัก</a></li>
	<li class="uk-nav-header">เมนูจัดการนักศึกษาฝึกงาน</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('activity');?>">
		<a href="<?php echo base_url('preview/activity/?user_id='.$user_id); ?>"><span class="uk-icon-book"></span> บันทึกการเรียน</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('time');?>">
		<a href="<?php echo base_url('preview/time/?user_id='.$user_id); ?>"><span class="uk-icon-clock-o"></span> บันทึกเวลาเรียน</a>
	</li>
</ul>
<br/><br/>