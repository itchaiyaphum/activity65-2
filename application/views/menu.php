<ul class="tm-nav uk-nav" data-uk-nav="">
	<li class="uk-nav-header">เมนูหลัก</li>
	<li class="<?php echo $this->helper_lib->getActiveMainMenu('');?>">
		<a href="<?php echo base_url(''); ?>"><span class="uk-icon-home"></span> หน้าหลัก</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMainMenu('contact');?>">
		<a href="<?php echo base_url('contact/'); ?>"><span class="uk-icon-comment-o"></span> ติดต่อเรา</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMainMenu('help');?>">
		<a href="<?php echo base_url('help/'); ?>"><span class="uk-icon-book"></span> คู่มือการใช้งาน</a>
	</li>
</ul>
<br/><br/>