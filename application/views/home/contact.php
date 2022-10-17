<div style="background: url('<?php echo base_url('assets/imgs/bg.jpg')?>'); background-repeat:repeat-y;">
<div id="wrapper" class="uk-container uk-container-center">
  <div class="uk-text-left uk-margin-top">
    <?php $this->load->view('home/header');?>
    <hr/>
    <div class="uk-grid uk-grid-small">
				<div class="uk-width-large-8-10">
				
					<h1 style="color: #fff;"><u>ติดต่อผู้ดูแลระบบ</u></h1>
          <div>
              งานศูนย์ข้อมูลสารสนเทศ ฝ่ายแผนงานและความร่วมมือ วิทยาลัยเทคนิคชัยภูมิ<br/>
              240 หมู่ ต.ในเมือง อ.เมือง จ.ชัยภูมิ 36000<br/>
              โทร. 044-812075-6<br/>
              อีเมล์ techniccyp@hotmail.com
          </div>
          <br/>
          <div id="map" style="height: 400px; width: 100%;"></div>
                <script>
                  function initMap() {
                    var uluru = {lat: 15.8102585, lng: 102.0157636};
                    var map = new google.maps.Map(document.getElementById('map'), {
                      zoom: 13,
                      center: uluru
                    });
                
                    var contentString = '<div id="content">'+
                        '<div id="siteNotice">'+
                        '</div>'+
                        '<h3 id="firstHeading" class="firstHeading">ติดต่อผู้ดูแลระบบ</h3>'+
                        '<div id="bodyContent">'+
                        '<p>งานศูนย์ข้อมูลสารสนเทศ ฝ่ายแผนงานและความร่วมมือ วิทยาลัยเทคนิคชัยภูมิ</p>'+
                        '</div>'+
                        '</div>';
                
                    var infowindow = new google.maps.InfoWindow({
                      content: contentString
                    });
                
                    var marker = new google.maps.Marker({
                      position: uluru,
                      map: map,
                      title: 'ติดต่อผู้ดูแลระบบ'
                    });
                    infowindow.open(map, marker);
                    
                  }
                </script>
                <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyC4RnT2-iZ5cDLhoMoN5w-_LHWRrDVx1mM&callback=initMap" async defer></script>
				
				  </div>
				<div class="uk-width-large-2-10" style="border-left: 1px solid #fff;">
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
