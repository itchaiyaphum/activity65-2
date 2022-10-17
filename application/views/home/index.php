<div style="background: url('<?php echo base_url('assets/imgs/bg.jpg')?>'); background-repeat:repeat-y;">
	<div id="wrapper" class="uk-container uk-container-center">
		<div class="uk-text-left uk-margin-top">
			<?php $this->load->view('home/header');?>
			<hr/>
			<div class="uk-grid uk-grid-small">
				<div class="uk-width-large-8-10">
					<img src="/assets/imgs/homepage_landing.jpg" class='uk-width-1-1'>
				</div>
				<div class="uk-width-large-2-10" style="border-left: 1px solid #fff; padding: 10px;">
					<?php $this->load->view('home/rightmenu');?>
				</div>
			</div>
			<hr/>
			<?php $this->load->view('home/footer_txt.php');?>
		</div>
		
	</div>
</div>
<style>
#wrapper {
    color: #fff;
}
.website-header {
    margin-top: 20px;
    color: #fff;
    font-size: 60px;
    line-height: 80px;
}
.uk-nav>li>a {
    color: #fff;
}
</style>
