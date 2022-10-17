<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h1>จัดการข้อมูลครูที่ปรึกษา</h1>
				</div>
    			<div class="uk-float-right">
    				<a href="<?php echo base_url('/headadvisor/users/edit');?>" class="uk-button uk-button-success"><i class="uk-icon-plus"></i> เพิ่ม</a>
    			</div>
			</div>
			<hr/>
            <form action="<?php echo base_url('headadvisor/users');?>" method="post" name="adminForm">
            	<table class="uk-table uk-table-hover uk-table-responsive uk-table-striped">
            		<tr>
            			<td width="100%">
            				Filter:
            				<input type="text" name="users_filter_search" id="search" value="<?php echo set_value('users_filter_search');?>" class="text_area" onchange="document.adminForm.submit();" />
            				<button onclick="this.form.submit();">Go</button>
            				<button onclick="document.getElementById('search').value='';this.form.submit();">Reset</button>
            			</td>
            			<td nowrap="nowrap">
							<select name="users_filter_user_type" onchange="document.adminForm.submit();">
                            	<option value="">- เลือกประเภทผู้ใช้ -</option>
                            	<option value="advisor" <?php echo set_select('users_filter_user_type', 'advisor');?>>อาจารย์ที่ปรึกษา (Advisor)</option>
                            	<option value="headdepartment" <?php echo set_select('users_filter_user_type', 'headdepartment');?>>หัวหน้าแผนกฯ (Head of Department)</option>
                            </select>
            				<?php echo $this->helper_lib->getStatusHtml('users_filter_status');?>
            			</td>
            		</tr>
            	</table>

            	<table class="uk-table uk-table-hover uk-table-responsive uk-table-striped" cellpadding="1">
            		<thead>
            			<tr>
            				<th width="5%" class="title">#</th>
            				<th class="title">
            					ชื่อ-นามสกุล
            				</th>
            				<th class="title">
            					อีเมล์
            				</th>
            				<th class="title">
            					ประเภทผู้ใช้
            				</th>
            				<th class="title" width="20%">
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
                        $k = 0;
                        for ($i=0, $n=count($items); $i < $n; $i++) {
                            $row 	=& $items[$i];
                            
                            $per_page = $this->input->get_post('per_page', 1);
                            $link_edit = base_url('headadvisor/users/edit/?id='.$row->id.'&per_page='.$per_page);
                            $link_restore = base_url('headadvisor/users/restore/?id='.$row->id.'&per_page='.$per_page);
                            $link_trash = base_url('headadvisor/users/trash/?id='.$row->id.'&per_page='.$per_page);
                            $link_delete = base_url('headadvisor/users/delete/?id='.$row->id.'&per_page='.$per_page);
                            
                            $status_link = base_url('headadvisor/users/unpublish/?id='.$row->id.'&per_page='.$per_page);
                            if ($row->activated==0) {
                                $status_link = base_url('headadvisor/users/publish/?id='.$row->id.'&per_page='.$per_page);
                            } ?>
            			<tr class="<?php echo "row$k"; ?>">
            				<td>
								<div class="uk-grid uk-grid-small">
									<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ลำดับที่:</div>
									<div class="uk-width-small-7-10">
										<?php echo $this->helper_lib->getPaginationIndex($i+1, 50); ?>
									</div>
								</div>
            				</td>
            				<td>
								<div class="uk-grid uk-grid-small">
									<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ชื่อ-นามสกุล:</div>
									<div class="uk-width-small-7-10">
										<a href="<?php echo $link_edit; ?>"><?php echo $row->firstname.' '.$row->lastname; ?></a>
									</div>
								</div>
            				</td>
            				<td>
								<div class="uk-grid uk-grid-small">
									<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">อีเมล์:</div>
									<div class="uk-width-small-7-10">
										<a href="<?php echo $link_edit; ?>"><?php echo $row->email; ?></a>
									</div>
								</div>
            				</td>
            				<td>
								<div class="uk-grid uk-grid-small">
									<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ประเภทผู้ใช้:</div>
									<div class="uk-width-small-7-10">
										<?php echo $row->user_type; ?>
									</div>
								</div>
            				</td>
            				<td>
								<div class="uk-grid uk-grid-small">
									<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สถานะ:</div>
									<div class="uk-width-small-7-10">
										<a href="<?php echo $status_link; ?>"><?php echo $this->helper_lib->getStatusIcon($row->activated); ?></a>
									</div>
								</div>
            				</td>
            				<td>
								<div class="uk-grid uk-grid-small">
									<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold"></div>
									<div class="uk-width-small-7-10">
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
									</div>
								</div>
            				</td>
            			</tr>
            		<?php
                        $k = 1 - $k;
                        }
                    }
                    ?>
            		</tbody>
            	</table>
            </form>

		</div>
	</div>
</div>
