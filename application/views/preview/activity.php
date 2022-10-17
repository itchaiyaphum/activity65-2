<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php $this->load->view('preview/menu');?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h2>บันทึกประจำวัน</h2>
				</div>
			</div>
			<hr>
			<?php 
			$days_of_weeks = array('จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์');
    		for($i=0; $i<18; $i++){
    		    $week = ($i+1);
    		?>
			<article class="uk-article">
				<table class="uk-table">
					<tbody><tr>
						<td class="uk-width-1-10">สัปดาห์ที่ <?php echo ($i+1);?></td>
						<td class="uk-width-1-10">วัน</td>
						<td class="uk-width-3-10">กิจกรรม/งานที่ปฏิบัติ</td>
						<td class="uk-width-2-10">ปัญหาและอุปสรรค</td>
						<td class="uk-width-2-10">ประโยชน์ที่ได้รับ</td>
						<td class="uk-width-1-10" colspan="2"></td>
					</tr>
					<?php 
            		for($j=0; $j<count($days_of_weeks); $j++){
            		    $student_save = 0;
            		    $text_activity = '-';
            		    $text_problem = '-';
            		    $text_advantage = '-';
            		    for($k=0; $k<count($items); $k++){
            		        $item = $items[$k];
            		        if($item->week==($i+1) && $item->day==($j+1)){
            		            $text_activity = $item->activity;
            		            $text_problem = $item->problem;
            		            $text_advantage = $item->advantage;
            		            
            		            $student_save = 1;  //active
                    		    $advisor_check_status = $item->advisor_check_status;
                    		    $trainer_confirm_status = $item->trainer_confirm_status;
            		        }
            		    }
            		    
            		    $day = ($j+1);
            		    
            		    $form_name = "form-".$week."-".$day;
            		?>
            		
					<tr>
						<td>
							<form action="<?php base_url('preview/activity'); ?>" id="<?php echo $form_name;?>" class="main-form uk-form uk-form-horizontal" method="post">
								<input type="hidden" value="<?php echo $week;?>" name="week"/>
                        		<input type="hidden" value="<?php echo $day;?>" name="day"/>
                        		<input type="hidden" value="<?php echo $user_id;?>" name="user_id"/>
                        		<input type="hidden" value="<?php echo $advisor_check_status;?>" name="advisor_check_status"/>
                            	<input type="hidden" value="<?php echo $trainer_confirm_status;?>" name="trainer_confirm_status"/>
							</form>
						</td>
						<td><?php echo $days_of_weeks[$j];?></td>
						<td><?php echo $text_activity;?></td>
						<td><?php echo $text_problem;?></td>
						<td><?php echo $text_advantage;?></td>
						<td><a href="<?php echo base_url('preview/activity/form/?week='.$week.'&day='.$day.'&user_id='.$user_id); ?>" class="uk-button uk-button-small uk-button-success"><i class="uk-icon-pencil"></i> บันทึก</a></td>
					</tr>
					
					<?php 
					$filter_photos = array();
					for($n=0; $n<count($photo_items); $n++){
					    $photo = $photo_items[$n];
					    if($photo->week==($i+1) && $photo->day==($j+1)){
					        array_push($filter_photos, $photo);
					    }
					}
					
					if(count($filter_photos)){
					?>
					<tr>
						<td></td>
						<td colspan="5">
							<div class="uk-grid uk-grid-small">
								<?php 
								$class_width = "uk-width-1-3";
								if(count($filter_photos)==1){
								    $class_width = "uk-width-1-1";
								}else if(count($filter_photos)==2){
								    $class_width = "uk-width-1-2";
								}
								for($n=0; $n<count($filter_photos); $n++){
								    $photo = $filter_photos[$n];
								?>
								<div class="<?php echo $class_width;?>">
									<a target="_blank" href="<?php echo base_url('/storage/photos/'.$photo->file_name);?>"><img class="uk-thumbnail" src="<?php echo base_url('/storage/photos/thumbnail/'.$photo->file_name);?>"/></a>
								</div>
								<?php 
								} 
								?>
							</div>
						</td>
					</tr>
					<?php } ?>
							
					<?php 
					$filter_files = array();
					for($n=0; $n<count($file_items); $n++){
					    $file = $file_items[$n];
					    if($photo->week==($i+1) && $file->day==($j+1)){
					        array_push($filter_files, $file);
					    }
					}
					
					if(count($filter_files)){
					?>
					<tr>
						<td></td>
						<td colspan="5">
							<ul class="uk-list uk-list-line">
								<?php 
								for($n=0; $n<count($filter_files); $n++){
								    $file = $filter_files[$n];
								?>
								<li><a target="_blank" href="<?php echo base_url('/storage/files/'.$file->file_name);?>"><i class="uk-icon-cloud-download"></i> ดาวน์โหลด: <?php echo $file->orig_name;?></a></li>
								<?php 
								} 
								?>
							</ul>
						</td>
					</tr>
					<?php } ?>
					
					
					<?php 
    				if($student_save){
    				?>
    				<tr>
    					<td></td>
    					<td colspan="5">
    						<div class="uk-margin">
    						
    							<?php 
    							if($advisor_check_status){
    							?>
								<div class="uk-text-success">ครูนิเทศฝึกงาน: <i class="uk-icon-check"></i> ตรวจแล้ว</div>
								<?php 
							     }else{
								?>
								<div class="uk-text-danger">ครูนิเทศฝึกงาน: <i class="uk-icon-remove"></i> ยังไม่ตรวจ</div>
								<?php } ?>
    							<?php
    							if($trainer_confirm_status){
    							?>
								<div class="uk-text-success">ผู้ควบคุมการฝึกงาน: <i class="uk-icon-check"></i> ยืนยันแล้ว</div>
								<?php 
							     }else{
							    ?>
							    <div class="uk-text-danger">ผู้ควบคุมการฝึกงาน: <i class="uk-icon-remove"></i> ยังไม่ยืนยันแล้ว</div>
    							<?php } ?>
    							
    							<?php 
    							if($profile->user_type=="advisor"){
    							     if($advisor_check_status){
    							?>
        							<a href="#" data-form="<?php echo $form_name;?>" class="advisor_check_status_cancel_button uk-button uk-button-small uk-button-danger">ยกเลิกการตรวจเยี่ยม</a>
        							<?php 
        							}else{
        							?>
        							<a href="#" data-form="<?php echo $form_name;?>" class="advisor_check_status_ok_button uk-button uk-button-small uk-button-success">ยืนยันบันทึกการตรวจเยี่ยม</a>
                                <?php 
    							     }
    							}
    							?>
    							
    							<?php 
    							if($profile->user_type=="trainer"){
    							     if($trainer_confirm_status){
    							?>
        							<a href="#" data-form="<?php echo $form_name;?>" class="trainer_confirm_status_cancel_button uk-button uk-button-small uk-button-danger">ยกเลิกการตรวจยืนยัน</a>
        							<?php 
        							}else{
        							?>
        							<a href="#" data-form="<?php echo $form_name;?>" class="trainer_confirm_status_ok_button uk-button uk-button-small uk-button-success">บันทึกการตรวจยืนยัน</a>
                                <?php 
    							     }
    							}
    							?>
                                
                            </div>
    					</td>
    				</tr>
    				<?php 
					}
					?>
					
					<?php } ?>
					</tbody>
				</table>
			</article>
			<?php } ?>
			
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).on('ready', function(){
    $( ".advisor_check_status_cancel_button" ).on('click',function( event ) {
        event.preventDefault();
        $formName = $(this).data('form');
        $('#'+$formName).find('input[name="advisor_check_status"]').val(0);
        $('#'+$formName).submit();
    });
    $( ".trainer_confirm_status_cancel_button" ).on('click',function( event ) {
        event.preventDefault();
        $formName = $(this).data('form');
        $('#'+$formName).find('input[name="trainer_confirm_status"]').val(0);
        $('#'+$formName).submit();
    });
    $( ".advisor_check_status_ok_button" ).on('click',function( event ) {
        event.preventDefault();
        $formName = $(this).data('form');
        $('#'+$formName).find('input[name="advisor_check_status"]').val(1);
        $('#'+$formName).submit();
    });
    $( ".trainer_confirm_status_ok_button" ).on('click',function( event ) {
        event.preventDefault();
        $formName = $(this).data('form');
        $('#'+$formName).find('input[name="trainer_confirm_status"]').val(1);
        $('#'+$formName).submit();
    });
});
</script>
