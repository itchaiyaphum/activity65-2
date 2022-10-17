<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h1>จัดการกิจกรรมโฮมรูม</h1>
				</div>
    			<div class="uk-float-right">
    				<a href="<?php echo base_url('/admin/homeroom/edit');?>" class="uk-button uk-button-success"><i class="uk-icon-plus"></i> เพิ่ม</a>
    			</div>
			</div>
			<hr/>
            <form action="<?php echo base_url('admin/homeroom');?>" method="post" name="adminForm">
            	<table class="uk-table">
            		<tr>
            			<td width="100%">
            				Filter:
            				<input type="text" name="homeroom_filter_search" id="search" value="<?php echo set_value('homeroom_filter_search');?>" class="text_area" onchange="document.adminForm.submit();" />
            				<button onclick="this.form.submit();">Go</button>
            				<button onclick="document.getElementById('search').value='';this.form.submit();">Reset</button>
            			</td>
            			<td nowrap="nowrap">
            				<?php echo $this->helper_lib->getStatusHtml('homeroom_filter_status');?>
            			</td>
            		</tr>
            	</table>
            
            	<table class="uk-table uk-table-hover" cellpadding="1">
            		<thead>
            			<tr>
            				<th width="5%" class="title">#</th>
            				<th class="title">
            					ภาคการเรียน
            				</th>
            				<th class="title">
            					สัปดาห์ที่
            				</th>
            				<th class="title">
            					วันที่เริ่มต้น
            				</th>
            				<th class="title" width="20%">
            					วันที่สิ้นสุด
            				</th>
            				<th width="10%" class="title" nowrap="nowrap">
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
                        echo '<tr><td colspan="8" class="uk-text-center"><p>ไม่มีข้อมูล</p></td></tr>';
                    } else {
                        $k = 0;
                        for ($i=0, $n=count($items); $i < $n; $i++) {
                            $row 	=& $items[$i];
                            
                            $per_page = $this->input->get_post('per_page', 1);
                            $link_edit = base_url('admin/homeroom/edit/?id='.$row->id.'&per_page='.$per_page);
                            $link_restore = base_url('admin/homeroom/restore/?id='.$row->id.'&per_page='.$per_page);
                            $link_trash = base_url('admin/homeroom/trash/?id='.$row->id.'&per_page='.$per_page);
                            $link_delete = base_url('admin/homeroom/delete/?id='.$row->id.'&per_page='.$per_page);
                            
                            $status_link = base_url('admin/homeroom/unpublish/?id='.$row->id.'&per_page='.$per_page);
                            if ($row->status==0) {
                                $status_link = base_url('admin/homeroom/publish/?id='.$row->id.'&per_page='.$per_page);
                            } ?>
            			<tr class="<?php echo "row$k"; ?>">
            				<td>
            					<?php echo $this->helper_lib->getPaginationIndex($i+1, 50); ?>
            				</td>
            				<td>
            					<a href="<?php echo $link_edit; ?>"><?php echo $row->semester_name; ?></a>
            				</td>
            				<td>
            					<a href="<?php echo $link_edit; ?>"><?php echo $row->week; ?></a>
            				</td>
            				<td>
            					<a href="<?php echo $link_edit; ?>"><?php echo date_format(date_create($row->join_start), 'Y-m-d'); ?></a>
            				</td>
            				<td>
            					<a href="<?php echo $link_edit; ?>"><?php echo date_format(date_create($row->join_end), 'Y-m-d'); ?></a>
            				</td>
            				<td>
            					<a href="<?php echo $status_link; ?>"><?php echo $this->helper_lib->getStatusIcon($row->status); ?></a>
            				</td>
            				<td>
            					<a href="<?php echo $link_edit; ?>" class="uk-button uk-button-success uk-button-mini"><i class="uk-icon-pencil"></i></a>
            					<?php
                                if ($this->helper_lib->getFilterStatus('homeroom_filter_status')=='trash') {
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
                        $k = 1 - $k;
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
