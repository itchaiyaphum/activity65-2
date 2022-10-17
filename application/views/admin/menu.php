<ul class="tm-nav uk-nav" data-uk-nav="">
	<li class="uk-nav-header">เมนูหลัก</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('admin');?>">
		<a href="<?php echo base_url('admin'); ?>"><span class="uk-icon-home"></span> หน้าหลัก</a>
	</li>
	
	
	<li><hr></li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('homeroom');?>">
		<a href="<?php echo base_url('admin/homeroom'); ?>"><span class="uk-icon-cube"></span> กิจกรรมโฮมรูม</a>
	</li>
	
	<li><hr></li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('semester');?>">
		<a href="<?php echo base_url('admin/semester'); ?>"><span class="uk-icon-cube"></span> จัดการภาคการศึกษา</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('college');?>">
		<a href="<?php echo base_url('admin/college'); ?>"><span class="uk-icon-cube"></span> จัดการสถานศึกษา</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('major');?>">
		<a href="<?php echo base_url('admin/major'); ?>"><span class="uk-icon-cube"></span> จัดการสาขาวิชา</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('minor');?>">
		<a href="<?php echo base_url('admin/minor'); ?>"><span class="uk-icon-cube"></span> จัดการสาขางาน</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('group');?>">
		<a href="<?php echo base_url('admin/group'); ?>"><span class="uk-icon-cube"></span> จัดการกลุ่มการเรียน</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('advisorgroup');?>">
		<a href="<?php echo base_url('admin/advisorgroup'); ?>"><span class="uk-icon-cube"></span> ที่ปรึกษาประจำกลุ่มการเรียน</a>
	</li>
	<li><hr></li>
	<li class="uk-nav-header">ผู้ใช้งาน</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('users');?>">
		<a href="<?php echo base_url('admin/users'); ?>"><span class="uk-icon-user"></span> จัดการผู้ใช้งาน</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('userstudent');?>">
		<a href="<?php echo base_url('admin/userstudent'); ?>"><span class="uk-icon-user"></span> จัดการรายชื่อนักเรียน</a>
	</li>
	<li class="<?php echo $this->helper_lib->getActiveMenu('importdata');?>">
		<a href="<?php echo base_url('admin/importdata'); ?>"><span class="uk-icon-cube"></span> Import Data</a>
	</li>
	<li><hr></li>
</ul>