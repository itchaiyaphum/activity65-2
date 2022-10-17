<ul class="tm-nav uk-nav" data-uk-nav="">
	<li class="uk-nav-header">เมนูหลัก</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('trainer');?>">
		<a href="<?php echo base_url('trainer'); ?>"><span class="uk-icon-home"></span> หน้าหลัก</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('evaluation');?>">
		<a href="<?php echo base_url('trainer/evaluation'); ?>"><span class="uk-icon-pie-chart"></span> ประเมินผลการฝึกงาน</a>
	</li>
</ul>