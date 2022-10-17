<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <form action="<?php echo base_url('admin/major/edit');?>" method="post" name="adminForm" class="uk-form uk-form-horizontal">
            
    			<div class="uk-clearfix">
    				<div class="uk-float-left">
    					<h1>จัดการข้อมูลสาขาวิชา [<?php echo (is_null($item->id))?'เพิ่ม':'แก้ไข';?>]</h1>
    				</div>
        			<div class="uk-float-right">
        				<input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success"/>
        				<a href="<?php echo base_url('/admin/major/');?>" class="uk-button uk-button-danger">ยกเลิก</a>
        			</div>
    			</div>
    			<hr/>
    			
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">สาขาวิชา</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="major_name" value="<?php echo $item->major_name;?>">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">สาขาวิชา (English)</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="major_eng" value="<?php echo $item->major_eng;?>">
                    </div>
                </div>
                <div class="uk-form-row">
					<label class="uk-form-label" >สถานศึกษา</label>
					<div class="uk-form-controls">
						<select name="college_id" id="college_id">
						<option value="0">--- เลือกสถานศึกษา ---</option>
						<?php
                        for ($i=0; $i<count($college_items); $i++) {
                            $college = $college_items[$i]; ?>
							<option value="<?php echo $college->id; ?>" <?php echo ($item->college_id==$college->id)?' selected="selected" ':''; ?>><?php echo $college->name; ?></option>
							<?php
                        }
                        ?>
						</select>
					</div>
				</div>
            	<input type="hidden" name="id" value="<?php echo $item->id;?>" />
            </form>

		</div>
	</div>
</div>
