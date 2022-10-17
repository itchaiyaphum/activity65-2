<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php $this->load->view('preview/menu');?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
             	<div class="uk-container">
            		<div class="uk-clearfix">
            			<div class="uk-float-left">
            				<h2>บันทึกเวลาเรียน</h2>
            			</div>
            		</div>
            		<hr>
            		<?php 
            		$days_of_weeks = array('จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์');
            		for($i=0; $i<18; $i++){
            		?>
            			<table class="uk-table">
            				<tr>
            					<td class="uk-width-1-10">สัปดาห์ที่ <?php echo ($i+1);?></td>
            					<td class="uk-width-1-10">วัน</td>
            					<td class="uk-width-2-10">เวลามา</td>
            					<td class="uk-width-2-10">เวลากลับ</td>
            					<td class="uk-width-3-10">หมายเหตุ</td>
            					<td class="uk-width-1-10" colspan="2"></td>
            				</tr>
            			</table>
            			<?php 
                    	for($j=0; $j<count($days_of_weeks); $j++){
                    	    $student_save = 0;
                		    $come_hour = 0;
                		    $come_minute = 0;
                		    $back_hour = 0;
                		    $back_minute = 0;
                		    $remark = 0;
                		    $remark_text = "";
                		    for($k=0; $k<count($items); $k++){
                		        $item = $items[$k];
                		        if($item->week==($i+1) && $item->day==($j+1)){
                		            $come_hour = $item->come_hour;
                        		    $come_minute = $item->come_minute;
                        		    $back_hour = $item->back_hour;
                        		    $back_minute = $item->back_minute;
                        		    $remark = $item->remark;
                        		    $remark_text = $item->remark_text;
                        		    
                        		    $student_save = 1;  //active
                        		    $advisor_check_status = $item->advisor_check_status;
                        		    $trainer_confirm_status = $item->trainer_confirm_status;
                		        }
                		    }
                		    
                		    $form_name = "form-".($i+1)."-".($j+1);
                		    
                    	?>
                    	<form action="<?php base_url('preview/time'); ?>" id="<?php echo $form_name;?>" class="main-form uk-form uk-form-horizontal" method="post">
                    	<table class="uk-table">
            				<tr>
            					<td class="uk-width-1-10"></td>
            					<td class="uk-width-1-10"><?php echo $days_of_weeks[$j];?></td>
            					<td class="uk-width-2-10">
            						<select name="come_hour" style="width: 50px; float: left;">
                                		<?php 
                                		for($ii=0; $ii<24; $ii++){
                                		?>
                                		<option value="<?php echo $ii;?>" <?php echo ($ii==$come_hour)?' selected="selected" ':''; ?>><?php echo $ii;?></option>
                                		<?php } ?>
                                	</select>
                                	<select name="come_minute" style="width: 50px; float: left; margin-left: 5px;">
                                		<?php 
                                		for($ii=0; $ii<60; $ii++){
                                		?>
                                		<option value="<?php echo $ii;?>" <?php echo ($ii==$come_minute)?' selected="selected" ':''; ?>><?php echo $ii;?></option>
                                		<?php } ?>
                                	</select>
                                </td>
            					<td class="uk-width-2-10">
            						<select name="back_hour" style="width: 50px; float: left;">
                                		<?php 
                                		for($ii=0; $ii<24; $ii++){
                                		?>
                                		<option value="<?php echo $ii;?>" <?php echo ($ii==$back_hour)?' selected="selected" ':''; ?>><?php echo $ii;?></option>
                                		<?php } ?>
                                	</select>
            						<select name="back_minute" style="width: 50px; float: left; margin-left: 5px;">
                                		<?php 
                                		for($ii=0; $ii<60; $ii++){
                                		?>
                                		<option value="<?php echo $ii;?>" <?php echo ($ii==$back_minute)?' selected="selected" ':''; ?>><?php echo $ii;?></option>
                                		<?php } ?>
                                	</select>
            					</td>
            					<td class="uk-width-3-10">
            						<div class="uk-form-row">
                						<select style="width: 100%;" name="remark">
                							<option value="0" <?php echo ($remark==0)?' selected="selected" ':''; ?>></option>
                							<option value="1" <?php echo ($remark==1)?' selected="selected" ':''; ?>>วันหยุดราชการ</option>
                							<option value="2" <?php echo ($remark==2)?' selected="selected" ':''; ?>>วันหยุดสถานประกอบการ</option>
                							<option value="3" <?php echo ($remark==3)?' selected="selected" ':''; ?>>ทำงานนอกเวลา</option>
                							<option value="4" <?php echo ($remark==4)?' selected="selected" ':''; ?>>อื่นๆ</option>
                						</select>
                						<textarea style="height: 30px; width: 100%;" name="remark_text"><?php echo $remark_text;?></textarea>
            						</div>
            					</td>
            					<td class="uk-width-1-10">
            						<input type="submit" value="บันทึก" class="uk-button uk-button-small uk-button-success">
            					</td>
            				</tr>
            				
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
            				
            			</table>
            			
                		<input type="hidden" value="<?php echo ($i+1);?>" name="week"/>
                		<input type="hidden" value="<?php echo ($j+1);?>" name="day"/>
                		<input type="hidden" value="<?php echo $user_id;?>" name="user_id"/>
                		<input type="hidden" value="<?php echo $advisor_check_status;?>" name="advisor_check_status"/>
                    	<input type="hidden" value="<?php echo $trainer_confirm_status;?>" name="trainer_confirm_status"/>
                		</form>
            			<?php } ?>
            		<?php } ?>
        	</div>
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


