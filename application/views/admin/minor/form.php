<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <form action="<?php echo base_url('admin/minor/edit');?>" method="post" name="adminForm" class="uk-form uk-form-horizontal">
            
    			<div class="uk-clearfix">
    				<div class="uk-float-left">
    					<h1>จัดการข้อมูลสาขางาน [<?php echo (is_null($item->id))?'เพิ่ม':'แก้ไข';?>]</h1>
    				</div>
        			<div class="uk-float-right">
        				<input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success"/>
        				<a href="<?php echo base_url('/admin/minor/');?>" class="uk-button uk-button-danger">ยกเลิก</a>
        			</div>
    			</div>
    			<hr/>
    			<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">สาขาวิชา</label>
                    <div class="uk-form-controls">
                        <select name="major_id"  class="uk-width-1-2">
                        	<option value="0">- เลือกสาขาวิชา -</option>
                        	<?php 
                        	for($i=0; $i<count($major_items); $i++){
                        	    $row = $major_items[$i];
                        	?>
                        	<option value="<?php echo $row->id;?>" <?php echo ($row->id==$item->major_id)?'selected="selected"':'';?>><?php echo $row->major_name;?></option>
                        	<?php } ?>
                        </select>
                    </div>
                </div>
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">สาขางาน</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="minor_name" value="<?php echo $item->minor_name;?>">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">สาขางาน (English)</label>
                    <div class="uk-form-controls">
                        <input type="text" iminorrm-h-it" name="minor_eng" value="<?php echo $item->minor_eng;?>">
                    </div>
                </div>
                
            	<input type="hidden" name="id" value="<?php echo $item->id;?>" />
            </form>

		</div>
	</div>
</div>
