<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-text-center">
				<h2>สรุปผลการฝึกงานในสถานประกอบการ</h2>
				<h3>(สำหรับครูฝึกในสถานประกอบการ/ผู้ควบคุมงาน)</h3>
			</div>
			<hr>
			
			<table class="uk-table uk-table-border">
				<thead>
					<tr>
						<th class="uk-text-center">ลำดับที่</th>
						<th>ชื่อนักศึกษา</th>
						<th class="uk-text-center">มา</th>
						<th class="uk-text-center">สาย</th>
						<th class="uk-text-center">ไม่มา</th>
						<th class="uk-text-center">ลา</th>
						<th class="uk-text-center">รวม</th>
						<th class="uk-text-center">การตรวจเยี่ยม</th>
						<th class="uk-text-center">บันทึกการทำงาน</th>
						<th class="uk-text-center">การตรวจยืนยัน</th>
					</tr>
				</thead>
				<?php
				for($i=0; $i<count($data->stats); $i++){
				    $item = $data->stats[$i];
			    ?>
				<tr>
					<td class="uk-text-center"><?php echo ($i+1)?></td>
					<td><a href="<?php echo base_url('/preview/time/?user_id='.$item->student_id);?>"><?php echo $item->student_name;?></a></td>
					<td class="uk-text-center"><?php echo $item->come;?></td>
					<td class="uk-text-center"><?php echo $item->late;?></td>
					<td class="uk-text-center"><?php echo $item->not_come;?></td>
					<td class="uk-text-center"><?php echo $item->leave;?></td>
					<td class="uk-text-center"><?php echo $item->total;?></td>
					<td class="uk-text-center"><?php echo $this->helper_lib->getProgressBarHtml($item->advisor_check_percentage);?></td>
					<td class="uk-text-center"><?php echo $this->helper_lib->getProgressBarHtml($item->student_activity_percentage);?></td>
					<td class="uk-text-center"><?php echo $this->helper_lib->getProgressBarHtml($item->trainer_confirm_percentage);?></td>
				</tr>
				<?php 
				}
				?>
				<tr>
					<td class="uk-text-right">รวม:</td>
					<td class="uk-text-center"><?php echo count($data->stats);?></td>
					<td class="uk-text-center"><?php echo $data->totals->come;?></td>
					<td class="uk-text-center"><?php echo $data->totals->late;?></td>
					<td class="uk-text-center"><?php echo $data->totals->not_come;?></td>
					<td class="uk-text-center"><?php echo $data->totals->leave;?></td>
					<td class="uk-text-center"><?php echo $data->totals->total;?></td>
					<td class="uk-text-center"><?php echo $this->helper_lib->getProgressBarHtml($data->totals->advisor_check_percentage);?></td>
					<td class="uk-text-center"><?php echo $this->helper_lib->getProgressBarHtml($data->totals->student_activity_percentage);?></td>
					<td class="uk-text-center"><?php echo $this->helper_lib->getProgressBarHtml($data->totals->trainer_confirm_percentage);?></td>
				</tr>
			</table>
			
			<br/>
			<h2><u>สรุป</u></h2>
			<div class="uk-grid">
        		<div class="uk-width-medium-1-4">
        			<h3>สรุปเวลาปฏิบัติงาน</h3>
        			<ul class="uk-list uk-list-striped">
        				<li>มา = <?php echo $data->totals->come;?> วัน</li>
        				<li>ไม่มา = <?php echo $data->totals->not_come;?> วัน</li>
        				<li>สาย = <?php echo $data->totals->late;?> วัน</li>
        				<li>ลา = <?php echo $data->totals->leave;?> วัน</li>
        			</ul>
        		</div>
        		<div class="uk-width-medium-1-4">
        			<h3>สรุปบันทึกปฏิบัติงาน</h3>
        			<ul class="uk-list uk-list-striped">
        				<li>ส่งบันทึกแล้ว = <?php echo $data->totals->student_activity;?> วัน</li>
        				<!-- <li>ยังไม่ส่งบันทึก = <?php echo $data->totals->student_not_activity;?> วัน</li> -->
        			</ul>
        		</div>
        		<div class="uk-width-medium-1-4">
        			<h3>สรุปครูนิเทศน์ตรวจเยี่ยม</h3>
        			<ul class="uk-list uk-list-striped">
        				<li>ตรวจแล้ว = <?php echo $data->totals->advisor_check;?> ครั้ง</li>
        				<!-- <li>ยังไม่ตรวจ = <?php echo $data->totals->advisor_not_check;?> วัน</li>  -->
        			</ul>
        		</div>
        		<div class="uk-width-medium-1-4">
        			<h3>สรุปผู้ควบคุมตรวจยืนยัน</h3>
        			<ul class="uk-list uk-list-striped">
        				<li>ตรวจแล้ว = <?php echo $data->totals->trainer_confirm;?> ครั้ง</li>
        				<!-- <li>ยังไม่ตรวจ = <?php echo $data->totals->trainer_not_confirm;?> วัน</li> -->
        			</ul>
        		</div>
        	</div>
        	
        	<h2><u>หมายเหตุ</u></h2>
        	<div>
        		<span><u>การตรวจยืนยัน</u></span>
        		บันทึกผล ทำโดยผู้ควบคุมการฝึกงาน หรือครูฝึกงานในสถานประกอบการ ให้การยืนยันในระบบออนไลน์
        	</div>
			<div>
        		<span><u>การตรวจเยี่ยม</u></span>
        		หมายถึง ครูนิเทศน์การฝึกงาน หรือ ครูที่ปรึกษา เข้าตรวจสอบในระบบออนไลน์
        	</div>
		</div>
	</div>
</div>
