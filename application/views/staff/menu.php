<ul class="tm-nav uk-nav" data-uk-nav="">
	<li class="uk-nav-header">เมนูหลัก</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('staff');?>">
		<a href="<?php echo base_url('staff'); ?>"><span class="uk-icon-home"></span> หน้าหลัก</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('homeroom');?>">
		<a href="<?php echo base_url('staff/homeroom'); ?>"><span class="uk-icon-pie-chart"></span> จัดการกิจกรรมโฮมรูม</a>
	</li>
</ul>