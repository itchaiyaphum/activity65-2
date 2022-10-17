<div style="background: url('<?php echo base_url('assets/imgs/bg.jpg')?>'); background-repeat:repeat-y;">
	<div id="wrapper" class="uk-container uk-container-center">
		<div class="uk-text-left uk-margin-top">
			<?php $this->load->view('home/header');?>
			<hr/>
			<div class="uk-grid">
				<div class="uk-width-2-10">
					<?php $this->load->view('home/menu');?>
				</div>
				<div class="uk-width-6-10" style="border-left: 1px solid #fff; padding: 10px;">
				
					<h1 style="color: #fff;"><u>คู่มือการใช้งาน (สำหรับนักศึกษา)</u></h1>
					
					<div class="uk-thumbnail">
						<img src="<?php echo base_url('assets/imgs/help/student/homepage.png');?>">
						<div class="uk-text-black">
							<div>เมื่อเข้ามาที่หน้าเว็บไซด์ จะพบกับหน้าจอดังรูปด้านบน โดยจะมีเมนูด้านซ้าย และ เมนูด้านขวา ดังนี้</div>
							<div>- เมนูด้านซ้าย: หน้าหลัก, ติดต่อเรา, คู่มือการใช้งาน, Facebook Group, Line Group</div>
							<div>- เมนูด้านขวา: ลงชื่อเข้าสู่ระบบ, สมัครสมาชิกใหม่</div>
						</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/login-1.png');?>">
						<div class="uk-text-black">เมื่อต้องการเข้าสู่ระบบ ให้คลิกที่ปุ่ม "ลงชื่อเข้าสู่ระบบ" และกรอกข้อมูล อีเมล์ และ รหัสผ่าน จากนั้นคลิกปุ่ม "เข้าสู่ระบบ"</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/homepage-logined.png');?>">
						<div class="uk-text-black">เมื่อเข้าสู่ระบบเรียบร้อยแล้ว หน้าเว็บไซด์หลัก เมนูด้านขวาจะเป็นเปลี่ยนปุ่ม "เข้าหน้าโปรโฟล์ของคุณ" และปุ่ม"ออกจากระบบ"</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/register-1.png');?>">
						<div class="uk-text-black">หากท่านยังไม่ได้เป็นสมาชิกของระบบ ให้คลิกปุ่ม สมัครสมาชิกใหม่ และกรอกข้อมูลต่างๆให้ครบถ้วน จากนั้นกดปุ่ม "ลงทะเบียน"</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/register-2.png');?>">
						<div class="uk-text-black">เมื่อลงทะเบียนใหม่เรียบร้อยแล้ว จะมีหน้าจอยืนยันการลงทะเบียนสำเร็จ</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/register-3.png');?>">
						<div class="uk-text-black">เมื่อลงทะเบียนใหม่เรียบร้อยแล้ว ระบบจะส่งข้อความต้อนรับไปแจ้งอัตโนมัติทางอีเมล์ที่ได้กรอกไว้ในขั้นตอนการลงทะเบียน ท่านสามารถคลิกที่ link ในอีเมล์เพื่อเข้าสู่ระบบใหม่ได้ทันที</div>
					</div>
					
					<!-- =================== ACTIVITY  =================== -->
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-1.png');?>">
						<div class="uk-text-black">เมื่อลงทะเบียนเข้าสู่ระบบครั้งแรก ระบบจะแจ้งให้นักศึกษาเลือกช่วงเวลาในการฝึกงาน ให้ท่านคลิกที่ link ที่ปรากฏ</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/profile-1.png');?>">
						<div class="uk-text-black">ให้ท่านเลือก ช่วงเวลาที่ฝึกงาน, สถานที่ฝึกงาน, ผู้คุ้มการฝึกงาน และอาจารย์นิเทศ จากนั้นกดปุ่ม "บันทึก" และสามารถกรอกข้อมูลอื่นๆไปพร้อมกันเลยทีเดียวก็ได้</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-2.png');?>">
						<div class="uk-text-black">
							<div>เมื่อนักศึกษาเลือก ช่วงเวลาที่ฝึกงาน, สถานที่ฝึกงาน, ผู้คุ้มการฝึกงาน และอาจารย์นิเทศ เรียบร้อยแล้ว เมื่อกลับมาที่เมนูบันทึกการเรียน ระบบจะแสดงหน้าจอพร้อมที่จะให้กรอกบันทึกข้อมูลต่างๆได้</div>
							<div>หากต้องการบันทึกข้อมูลให้กดปุ่ม "บันทึก" สีเขียวด้านขวา ของแต่ละวันที่ต้องการบันทึก</div>
						</div>
					</div>
					
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-3.png');?>">
						<div class="uk-text-black">กรอกข้อมูลต่างๆตามที่ต้องการ จากนั้นกดปุ่ม "บันทึกข้อมูล"</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-4.png');?>">
						<div class="uk-text-black">ระบบจะแสดงข้อมูลของวันนั้นๆ ที่ได้บันทึกข้อมูลไว้แล้ว และแสดงสถานะการตรวจของ "ครูนิเทศฝึกงาน และ ผู้คุมการฝึกงาน" ไว้ด้วย</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-5.png');?>">
						<div class="uk-text-black">นักศึกษาสามารถแก้ไขข้อมูลเพื่อเติม โดยการกดปุ่ม "บันทึก" แก้ไขข้อมูลต่างๆ หรือจะอัพโหลดรูปภาพ เอกสารประกอบต่างๆ ก็ได้</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-6.png');?>">
						<div class="uk-text-black">เมื่อมีการอัพโหลดรูปภาพ หรือ เอกสารประกอบ จะแสดงหน้าจอดังรูป</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-7.png');?>">
						<div class="uk-text-black">สามารถเข้าไปลบรูปภาพ และ เอกสารประกอบต่างๆได้อย่างง่าย เพียงคลิกปุ่ม x ดังรูป</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-8.png');?>">
						<div class="uk-text-black">เมื่อมีการลบรูปภาพ และ เอกสารประกอบ ก็จะแสดงดังหน้าจอดังรูป</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-9.png');?>">
						<div class="uk-text-black">เมื่อ ผู้ควบคุมการฝึกงาน กดยืนยันการบันทึกข้อมูล จะแสดงเครื่องหมายถูก ดังรูป</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/activity-10.png');?>">
						<div class="uk-text-black">เมื่อ ครูนิเทศฝึกงาน กดยืนยันการตรวจเยี่ยม จะแสดงเครื่องหมายถูก ดังรูป</div>
					</div>
					
					<!-- =================== TIME  =================== -->
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/time-1.png');?>">
						<div class="uk-text-black">เมื่อต้องการบันทึกเวลาเรียน ให้คลิกที่เมนู "บันทึกเวลาเรียน" ด้านซ้ายมือ จะแสดงหน้าจอการบันทึกเวลาเรียนของแต่ละวัน แต่ละสัปดาห์</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/time-2.png');?>">
						<div class="uk-text-black">นักศึกษาสามารถบันทึกข้อมูลเวลาได้ตามต้องการ เมื่อกดบันทึก จะมีสถานะการตรวจยืนยันจาก ครูนิเทศฝึกงานและผู้ควบคุมการฝึกงาน ให้ด้วย</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/time-3.png');?>">
						<div class="uk-text-black">เมื่อครูนิเทศกดยืนยันการตรวจเยี่ยมเรียบร้อย จะแสดงเครื่องหมายถูก ดังรูป</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/time-4.png');?>">
						<div class="uk-text-black">เมื่อ ผู้ควบคุมการฝึกงานยืนยันการตรวจสอบเรียบร้อย จะแสดงเครื่องหมายถูก ดังรูป</div>
					</div>
					
					<!-- =================== EVALUATION  =================== -->
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/evaluation-1.png');?>">
						<div class="uk-text-black">หน้าจอสรุปผลการฝึกงาน จะแสดงสถิติต่างๆของนักศึกษาทั้งหมด แสดงข้อมูลในรูปแบบกราฟแท่ง และ เปอร์เซนต์ โดยจะสรุปข้อมูลของการบันทึกการเรียน และ บันทึกเวลาเรียน ที่กรอกไว้ในระบบให้อัตโนมัติ</div>
					</div>
					
					<!-- =================== PROFILE EDIT  =================== -->
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/profile-edit.png');?>">
						<div class="uk-text-black">เมื่อต้องการแก้ไขข้อมูลส่วนตัว ให้คลิกที่เมนูด้านบน จากนั้นเลือกเมนู "แก้ไขข้อมูลส่วนตัว"</div>
					</div>

					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/profile-2.png');?>">
						<div class="uk-text-black">กรอกข้อมูลต่างๆ ให้ครบถ้วน จากนั้นกดปุ่ม "บันทึก"</div>
					</div>
					
					<!-- =================== CHANGE PASSWORD  =================== -->
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/change-password-1.png');?>">
						<div class="uk-text-black">เมื่อต้องการเปลี่ยนรหัสผ่าน ให้คลิกที่เมนู แก้ไขรหัสผ่าน และ กรอกข้อมูลรหัสผ่านเดิม และ รหัสผ่านใหม่ที่ต้องการ จากนั้นกดปุ่ม "บันทึกข้อมูล"</div>
					</div>
					
					<!-- =================== LOGOUT  =================== -->
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/logout-1.png');?>">
						<div class="uk-text-black">เมื่อต้องการออกจากระบบ สามารถคลิกที่เมนูด้านบน และเลือกเมนู "ออกจากระบบ"</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/logout-2.png');?>">
						<div class="uk-text-black">เมื่อต้องการออกจากระบบ สามารถเข้ามาที่หน้าแรก และคลิกปุ่ม "ออกจากระบบ"</div>
					</div>
					
					
					<!-- =================== OTHER  =================== -->
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/facebook.png');?>">
						<div class="uk-text-black">Faceboo Group: นักศึกษาสามารถเข้ามาพูดคุย แลกเปลี่ยนประสบการณ์ สอบถามข้อมูลกันได้ที่ Facebook Group นี้</div>
					</div>
					
					<div class="uk-thumbnail image-block">
						<img src="<?php echo base_url('assets/imgs/help/student/line.png');?>">
						<div class="uk-text-black">Line Group: นักศึกษาสามารถเข้ามาพูดคุย แลกเปลี่ยนประสบการณ์ สอบถามข้อมูลกันได้ที่ Line Group นี้ได้เช่นเดียวกัน</div>
					</div>
				
        			
				</div>
				<div class="uk-width-2-10" style="border-left: 1px solid #fff;">
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
.text-block{
    margin-top: 10px;
}
.image-block{
    margin-top: 30px;
}
.uk-text-black{
    padding: 5px;
    color: #000 !important;
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
