<div class="uk-container uk-container-center">
    <div class="uk-grid">
        <div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
            <?php echo $leftmenu; ?>
        </div>
        <div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <div class="uk-clearfix">
                <div class="uk-float-left">
                    <h1>สรุปผลเข้าร่วมกิจกรรมโฮมรูม</h1>
                </div>
            </div>
            <hr />

            <?php foreach ($data as $semester) { ?>
                <?php foreach ($semester->groups as $group) { ?>
                    <div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top uk-overflow-container">
                        <h3 class="uk-panel-title"><?= $semester->name ?> กลุ่ม <?= $group->group_name ?> สาขาวิชา <?= $group->major_name ?></h3>
                        <div class="uk-panel-badge">
                            <a href="<?= site_url('advisor/summaryhomeroom/report') . '?id=' . $group->id.'&semester='.$semester->id ?>" target="_blank"><button type="button" class="uk-button uk-button-primary uk-button-mini submit"><i class="uk-icon-print"></i> Print</button></a>
                        </div>
                        <hr>
                        <table class="uk-table uk-table-striped" cellpadding="1">
                            <thead>
                                <tr>
                                    <th class="uk-text-center">
                                        รหัสนักเรียน-นักศึกษา
                                    </th>
                                    <th class="uk-text-center">
                                        ชื่อ - นามสกุล
                                    </th>
                                    <th class="uk-text-center">
                                        มา
                                    </th>
                                    <th class="uk-text-center">
                                        ขาด
                                    </th>
                                    <th class="uk-text-center">
                                        สาย
                                    </th>
                                    <th class="uk-text-center">
                                        ลา
                                    </th>
                                    <th class="uk-text-center">
                                        เปอร์เซนต์
                                    </th>
                                    <th class="uk-text-center">
                                        สรุป
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($group->students as $std_row) { ?>
                                    <tr>
                                        <td class="uk-text-center"><?= $std_row->student_id ?></td>
                                        <td class="uk-text-center"><?= $std_row->firstname . ' ' . $std_row->lastname ?></td>
                                        <td class="uk-text-center"><?= $std_row->come ?></td>
                                        <td class="uk-text-center"><?= $std_row->not_come ?></td>
                                        <td class="uk-text-center"><?= $std_row->late ?></td>
                                        <td class="uk-text-center"><?= $std_row->leave ?></td>
                                        <td class="uk-text-center"><?= $std_row->percent ?></td>
                                        <td class="uk-text-center"><?= $std_row->result ?></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="uk-panel">
                            <p><?= "สรุป ผ่าน: {$group->pass} คน ไม่ผ่าน: {$group->not_pass} คน รวม: {$group->all} คน" ?></p>
                        </div>

                        <div class="uk-panel">
                            <span class="uk-text-danger">หมายเหตุ</span>
                            <ul class="uk-list uk-margin-top-remove">
                                <ul>
                                    <li>- <span class="uk-text-success">ผ่าน</span> มามากกว่าหรือเท่ากับ 60 เปอร์เซนต์</li>
                                </ul>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

            <?php } ?>
        </div>
    </div>
</div>