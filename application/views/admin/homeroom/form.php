<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <form action="<?php echo base_url('admin/homeroom/edit');?>" method="post" name="adminForm" class="uk-form uk-form-horizontal">
            
    			<div class="uk-clearfix">
    				<div class="uk-float-left">
    					<h1>จัดการข้อมูลกิจกรรมโฮมรูม [<?php echo (is_null($item->id))?'เพิ่ม':'แก้ไข';?>]</h1>
    				</div>
        			<div class="uk-float-right">
        				<input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success"/>
        				<a href="<?php echo base_url('/admin/homeroom/');?>" class="uk-button uk-button-danger">ยกเลิก</a>
        			</div>
    			</div>
    			<hr/>
    			<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ภาคการเรียน</label>
                    <div class="uk-form-controls">
                        <select name="semester_id"  class="uk-width-1-2">
                        	<option value="0">- เลือกภาคการเรียน -</option>
                        	<?php 
                        	for($i=0; $i<count($semester_items); $i++){
                        	    $row = $semester_items[$i];
                        	?>
                        	<option value="<?php echo $row->id;?>" <?php echo ($row->id==$item->semester_id)?'selected="selected"':'';?>><?php echo $row->name;?></option>
                        	<?php } ?>
                        </select>
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">สัปดาห์ที่</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="week" value="<?php echo $item->week;?>">
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">วันที่เริ่มต้นทำกิจกรรมโฮมรูม</label>
                    <div class="uk-form-controls">
                        <input type="date" id="form-h-it" name="join_start" value="<?php echo date_format(date_create($item->join_start),'Y-m-d');?>">
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">วันที่สิ้นสุดทำกิจกรรมโฮมรูม</label>
                    <div class="uk-form-controls">
                        <input type="date" id="form-h-it" name="join_end" value="<?php echo date_format(date_create($item->join_end),'Y-m-d');?>">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">หมายเหตุ (optional)</label>
                    <div class="uk-form-controls">
                        <textarea id="w3review" name="remark" rows="3" cols="40"><?php echo $item->remark;?></textarea>
                    </div>
                </div>
                
            	<input type="hidden" name="id" value="<?php echo $item->id;?>" />
            </form>

		</div>
	</div>
</div>
