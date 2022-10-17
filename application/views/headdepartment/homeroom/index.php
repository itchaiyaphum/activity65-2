<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
			<?php echo $leftmenu;?>
		</div>
		<div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
			<div class="uk-clearfix">
				<div class="uk-float-left">
					<h1>บันทึกกิจกรรมโฮมรูม</h1>
				</div>
			</div>
			<hr/>
            <form action="<?php echo base_url('headdepartment/homeroom');?>" method="post" name="adminForm">
				<?php
                foreach ($homeroom_items as $homeroom) {
                    ?>
            	<div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
                    <h3 class="uk-panel-title"><?php echo $homeroom->semester_name.' / สัปดาห์ที่: '.$homeroom->week.' / วันที่เริ่มต้น-สิ้นสุด: '; ?>
					( <?php echo $this->helper_lib->getDate($homeroom->join_start); ?> - 
            		<?php echo $this->helper_lib->getDate($homeroom->join_end); ?> )</h3>
                	<hr/>
                	<table class="uk-table uk-table-hover uk-table-responsive uk-table-striped" cellpadding="1">
                		<thead>
                			<tr>
                				<th width="5%">#</th>
                				<th width="30%">
                					กลุ่มการเรียน
                				</th>
                				<th width="15%">
                					สถานะที่ปรึกษา
                				</th>
                				<th>
                					สถานะการบันทึกข้อมูล
                				</th>
								<th width="25%">
                					
                				</th>
                			</tr>
                		</thead>
                		<tbody>
                		<?php
                        if (count($homeroom->groups)<=0) {
                            echo '<tr><td colspan="6" class="uk-text-center"><p>ไม่มีข้อมูล</p></td></tr>';
                        } else {
                            $i=1;
                            foreach ($homeroom->groups as $group) {
                                $link_activity = base_url("headdepartment/homeroom/activity?id={$homeroom->id}&group_id={$group->id}"); ?>
                			<tr>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">ลำดับที่:</div>
										<div class="uk-width-small-7-10">
											<?php echo($i++); ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">กลุ่มการเรียน:</div>
										<div class="uk-width-small-7-10">
											<div><?php echo $group->group_name; ?></div>
											<div><?php echo $group->minor_name; ?></div>
											<div><?php echo $group->major_name; ?></div>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สถานะที่ปรึกษา:</div>
										<div class="uk-width-small-7-10">
											<?php echo $this->base_homeroom_model->getAdvisorTypeText($group->advisors); ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">สถานะบันทึกข้อมูล:</div>
										<div class="uk-width-small-7-10">
											<?php echo $this->base_homeroom_model->getAdvisorStatusHtml($group->advisors); ?>
										</div>
									</div>
                				</td>
                				<td>
									<div class="uk-grid uk-grid-small">
										<div class="uk-width-small-3-10 uk-hidden-large uk-text-bold">กลุ่มการเรียน:</div>
										<div class="uk-width-small-7-10">
											<?php echo $this->base_homeroom_model->getEditButtonHtml($group->advisors, $link_activity); ?>
											<?php echo $this->base_homeroom_model->getPrintButtonHtml($group->advisors); ?>
										</div>
									</div>
								</td>
                			</tr>
                		<?php
                            }
                        } ?>
                		</tbody>
                	</table>
            	</div>
            	<?php
                } ?>
            </form>

		</div>
	</div>
</div>
