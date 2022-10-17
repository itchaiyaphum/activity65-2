<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <form action="<?php echo base_url('admin/college/edit');?>" method="post" name="adminForm" class="uk-form uk-form-horizontal">
            
    			<div class="uk-clearfix">
    				<div class="uk-float-left">
    					<h1>จัดการข้อมูลสถานศึกษา [<?php echo (is_null($item->id))?'เพิ่ม':'แก้ไข';?>]</h1>
    				</div>
        			<div class="uk-float-right">
        				<input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success"/>
        				<a href="<?php echo base_url('/admin/college/');?>" class="uk-button uk-button-danger">ยกเลิก</a>
        			</div>
    			</div>
    			<hr/>
    			
            	<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">สถานศึกษา</label>
                    <div class="uk-form-controls">
                        <input type="text" id="form-h-it" name="name" value="<?php echo $item->name;?>">
                    </div>
                </div>
                
            	<input type="hidden" name="id" value="<?php echo $item->id;?>" />
            </form>

		</div>
	</div>
</div>
