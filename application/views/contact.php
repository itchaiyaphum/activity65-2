<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php $this->load->view('menu');?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<h1>ติดต่อผู้ดูแลระบบ</h1>
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
	</div>
</div>
