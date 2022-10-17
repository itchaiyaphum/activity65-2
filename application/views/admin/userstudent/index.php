<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h1>จัดการประเภทผู้ใช้งาน</h1>
				</div>
    			<div class="uk-float-right">
    				<a href="<?php echo base_url('/admin/userstudent/edit');?>" class="uk-button uk-button-success"><i class="uk-icon-plus"></i> เพิ่ม</a>
    			</div>
			</div>
			<hr/>
            <form action="<?php echo base_url('admin/userstudent');?>" method="post" name="adminForm">
            	<table class="uk-table">
            		<tr>
            			<td width="100%">
            				Filter:
            				<input type="text" name="users_filter_search" id="search" value="<?php echo set_value('users_filter_search');?>" class="text_area" onchange="document.adminForm.submit();" />
            				<button onclick="this.form.submit();">Go</button>
            				<button onclick="document.getElementById('search').value='';this.form.submit();">Reset</button>
            			</td>
            			<td nowrap="nowrap">
							<select name="users_filter_group_id" onchange="document.adminForm.submit();">
                        		<option value="all">- แสดงทุกกลุ่มการเรียน -</option>
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
                                        	<option value="<?php echo $row->id; ?>" <?php echo set_select('users_filter_group_id', $row->id); ?>>------| <?php echo $row->group_name; ?></option>
                                			<?php
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                        	</select>
            				<?php echo $this->helper_lib->getStatusHtml('users_filter_status');?>
            			</td>
            		</tr>
            	</table>

            	<table class="uk-table uk-table-hover" cellpadding="1">
            		<thead>
            			<tr>
            				<th width="5%" class="title">#</th>
            				<th class="title">
            					รหัสนักเรียน
            				</th>
            				<th class="title">
            					ชื่อ-นามสกุล
            				</th>
            				<th class="title">
            					กลุ่มการเรียน/สาขางาน/สาขาวิชา
            				</th>
            				<th class="title">
            					อีเมล์
            				</th>
            				<th class="title">
            					สถานะ
            				</th>
            				<th width="15%" class="title" nowrap="nowrap">
            					-
            				</th>
            			</tr>
            		</thead>
            		<tfoot>
            			<tr>
            				<td colspan="10" class="uk-text-center">
            					<ul class="uk-pagination"><?php echo $pagination->create_links(); ?></ul>
            				</td>
            			</tr>
            		</tfoot>
            		<tbody>
            		<?php
                    if (count($items)<=0) {
                        echo '<tr><td colspan="6" class="uk-text-center"><p>ไม่มีข้อมูล</p></td></tr>';
                    } else {
                        $i=0;
                        foreach ($items as $student) {
                            $per_page = $this->input->get_post('per_page', 1);
                            $link_edit = base_url('admin/userstudent/edit/?id='.$student->id.'&per_page='.$per_page);
                            $link_restore = base_url('admin/userstudent/restore/?id='.$student->id.'&per_page='.$per_page);
                            $link_trash = base_url('admin/userstudent/trash/?id='.$student->id.'&per_page='.$per_page);
                            $link_delete = base_url('admin/userstudent/delete/?id='.$student->id.'&per_page='.$per_page);
                            
                            $status_link = base_url('admin/userstudent/unpublish/?id='.$student->id.'&per_page='.$per_page);
                            if ($student->status==0) {
                                $status_link = base_url('admin/userstudent/publish/?id='.$student->id.'&per_page='.$per_page);
                            } ?>
            			<tr>
            				<td>
            					<?php echo $this->helper_lib->getPaginationIndex($i+1, 50); ?>
            				</td>
            				<td>
								<?php echo $student->student_id; ?>
            				</td>
            				<td>
            					<a href="<?php echo $link_edit; ?>"><?php echo $student->firstname.' '.$student->lastname; ?></a>
            				</td>
            				<td>
								<div>- <?php echo $student->group_name; ?> (<?php echo $student->group_code; ?>)</div>
								<div>- <?php echo $student->minor_name; ?></div>
								<div>- <?php echo $student->major_name; ?></div>
            				</td>
            				<td>
            					<?php echo $student->email; ?>
            				</td>
            				<td>
            					<a href="<?php echo $status_link; ?>"><?php echo $this->helper_lib->getStatusIcon($student->status); ?></a>
            				</td>
            				<td>
            					<a href="<?php echo $link_edit; ?>" class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-pencil"></i></a>
            					<?php
                                if ($this->helper_lib->getFilterStatus('users_filter_status')=='trash') {
                                    ?>
            					<a href="<?php echo $link_restore; ?>" class="uk-button uk-button-primary uk-button-mini"><i class="uk-icon-reply"></i></a>
            					<a href="<?php echo $link_delete; ?>" class="uk-button uk-button-danger uk-button-mini"><i class="uk-icon-remove"></i></a>
            					<?php
                                } else {?>
            					<a href="<?php echo $link_trash;?>" class="uk-button uk-button-primary uk-button-mini"><i class="uk-icon-trash"></i></a>
            					<?php } ?>
            				</td>
            			</tr>
            		<?php
                        $i++;
                        }
                    }
                    ?>
            		</tbody>
            	</table>
            
            	<input type="hidden" name="boxchecked" value="0" />
            </form>

		</div>
	</div>
</div>
