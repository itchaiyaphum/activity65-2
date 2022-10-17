<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <form action="<?php echo base_url('headadvisor/advisorgroup/edit');?>" method="post" name="adminForm" class="uk-form uk-form-horizontal">
            
    			<div class="uk-clearfix">
    				<div class="uk-float-left">
    					<h1>จัดการครูที่ปรึกษาประจำกลุ่ม [<?php echo (is_null($item->id))?'เพิ่ม':'แก้ไข';?>]</h1>
    				</div>
        			<div class="uk-float-right">
        				<input type="submit" value="บันทึกข้อมูล" class="uk-button uk-button-success"/>
        				<a href="<?php echo base_url('/headadvisor/advisorgroup/');?>" class="uk-button uk-button-danger">ยกเลิก</a>
        			</div>
    			</div>
    			<hr/>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">กลุ่มการเรียน</label>
                    <div class="uk-form-controls">
                        <select name="group_id"  class="uk-width-small-1-1 uk-width-large-1-2">
                        	<option value="0">- เลือกกลุ่มการเรียน -</option>
                        		<?php
                                for ($i=0; $i<count($major_items); $i++) {
                                    $row_major = $major_items[$i]; ?>
                            		<option value="0" disabled>-| <?php echo $row_major->major_name; ?></option>
                            		<?php
                                    for ($j=0; $j<count($minor_items); $j++) {
                                        $row_minor = $minor_items[$j];
                                        if ($row_major->id==$row_minor->major_id) {
                                            ?>
                                    		<option value="0" disabled>---| <?php echo $row_minor->minor_name; ?></option>
                                        	<?php
                                            for ($k=0; $k<count($group_items); $k++) {
                                                $row = $group_items[$k];
                                                if ($row_minor->id==$row->minor_id) {
                                                    ?>
                                			<option value="<?php echo $row->id; ?>" <?php echo ($row->id==$item->group_id)?'selected="selected"':''; ?>>------| <?php echo $row->group_name; ?></option>
                                			<?php
                                                }
                                            }
                                        }
                                    } ?>
                            	<?php
                                }
                                ?>
                        </select>
                    </div>
                </div>
    			<div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ครูที่ปรึกษา</label>
                    <div class="uk-form-controls">
                        <select name="advisor_id"  class="uk-width-small-1-1 uk-width-large-1-2">
                        	<option value="0">- เลือกครูที่ปรึกษา -</option>
                        	<?php
                            for ($i=0; $i<count($advisor_items); $i++) {
                                $row = $advisor_items[$i]; ?>
                        	<option value="<?php echo $row->id; ?>" <?php echo ($row->id==$item->advisor_id)?'selected="selected"':''; ?>><?php echo $row->firstname.' '.$row->lastname; ?></option>
                        	<?php
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" for="form-h-it">ประเภทครูที่ปรึกษา</label>
                    <div class="uk-form-controls">
                        <select name="advisor_type"  class="uk-width-small-1-1 uk-width-large-1-2">
                        	<option value="advisor" <?php echo ($item->advisor_type=='advisor')?'selected="selected"':'';?>>เป็นครูที่ปรึกษาหลัก</option>
                        	<option value="coadvisor" <?php echo ($item->advisor_type=='coadvisor')?'selected="selected"':'';?>>เป็นครูที่ปรึกษาร่วม</option>
                        </select>
                    </div>
                </div>
                
            	<input type="hidden" name="id" value="<?php echo $item->id;?>" />
            </form>

		</div>
	</div>
</div>
