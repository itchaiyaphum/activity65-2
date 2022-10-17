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
	<li class="<?php echo $this->helper_lib->getActiveMenu('student');?>">
		<a href="<?php echo base_url('student'); ?>"><span class="uk-icon-home"></span> หน้าหลัก</a>
	</li>
</ul>
<br/>
<div>
<img src="/assets/imgs/lineoa-itchaiyaphum.png" width="100%" alt="line oa: @itchaiyaphum"/>
<h3 class="uk-text-large uk-text-center">LINE: @itchaiyaphum</h3>
<div class="uk-text-center">ต้องการสอบถามปัญหาในการใช้งาน ขอความช่วยเหลือ ติดต่อทีมงานพัฒนา สามารถ add line และสอบถามโดยตรงได้ค่ะ...</div>
</div>