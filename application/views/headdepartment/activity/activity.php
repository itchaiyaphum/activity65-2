<div class="uk-container uk-container-center">
    <div class="uk-grid">
        <div class="tm-sidebar uk-width-medium-1-4 uk-hidden-small">
            <?php echo $leftmenu; ?>
        </div>
        <div class="tm-main uk-width-medium-3-4 uk-margin-top uk-margin-bottom">
            <div class="uk-clearfix">
                <div class="uk-float-left">
                    <h1>แบบสรุปการประเมินผลกิจกรรมชมรมวิชาชีพ</h1>
                </div>
            </div>
            <hr />
            <h2 class="uk-alert uk-alert-primary">
                <?= $semester->name ?>
            </h2>
            <div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
                <h3 class="uk-panel-title">กลุ่มการเรียน: <?php echo $group->group_name . ' / ' . $group->minor_name . ' / ' . $group->major_name; ?></h3>
                <hr />
                <table class="uk-table uk-table-hover uk-table-responsive uk-table-striped" cellpadding="1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัส</th>
                            <th>ชื่อ</th>
                            <th>สกุล</th>
                            <th>หน้าเสาธง</th>
                            <th>ชมรม</th>
                            <th>โฮมรูม</th>
                            <th>ลูกเสือ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form id="form" method="post" action="<?= site_url('headdepartment/activity_summary/advisor_save').'?group_id='.$this->input->get('group_id').'&semester_id='.$this->input->get('semester_id') ?>" class="uk-form">
                            <?php
                            foreach ($group->students as $key => $std) {
                            ?>
                                <tr>
                                    <td><?= ++$key ?></td>
                                    <td><?= $std->student_id ?></td>
                                    <td><?= $std->firstname ?></td>
                                    <td><?= $std->lastname ?></td>
                                    <td>
                                        <div class="uk-form-controls uk-form-controls-text">
                                            <?php
                                            if (isset($std->flagpole)) {
                                                if ($std->flagpole == 0) {
                                                    $flagpole = false;
                                                } else {
                                                    $flagpole = true;
                                                }
                                            } else {
                                                $flagpole = true;
                                            }
                                            ?>
                                            <label><input class="uk-radio" type="radio" name="flagpole[<?= $std->user_id; ?>]" value="1" <?= $flagpole === true ? 'checked' : '' ?>> ผ.</label>
                                            <label><input class="uk-radio" type="radio" name="flagpole[<?= $std->user_id; ?>]" value="0" <?= $flagpole === false ? 'checked' : '' ?>> มผ.</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="uk-form-controls uk-form-controls-text">
                                            <?php
                                            if (isset($std->club)) {
                                                if ($std->club == 0) {
                                                    $club = false;
                                                } else {
                                                    $club = true;
                                                }
                                            } else {
                                                $club = true;
                                            }
                                            ?>
                                            <label><input class="uk-radio" type="radio" name="club[<?= $std->user_id; ?>]" value="1" <?= $club === true ? 'checked' : '' ?>> ผ.</label>
                                            <label><input class="uk-radio" type="radio" name="club[<?= $std->user_id; ?>]" value="0" <?= $club === false ? 'checked' : '' ?>> มผ.</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="uk-form-controls uk-form-controls-text">
                                            <?php
                                            if (isset($std->homeroom)) {
                                                if ($std->homeroom == 0) {
                                                    $homeroom = false;
                                                } else {
                                                    $homeroom = true;
                                                }
                                            } else {
                                                if ($this->activity_summary->std_homeroom($std->user_id, $semester->id) === false) {
                                                    $homeroom = false;
                                                } else {
                                                    $homeroom = true;
                                                }
                                            }
                                            ?>
                                            <label><input class="uk-radio" type="radio" name="homeroom[<?= $std->user_id; ?>]" value="1" <?= $homeroom === true ? 'checked' : '' ?>> ผ.</label>
                                            <label><input class="uk-radio" type="radio" name="homeroom[<?= $std->user_id; ?>]" value="0" <?= $homeroom === false ? 'checked' : '' ?>> มผ.</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="uk-form-controls uk-form-controls-text">
                                            <?php
                                            if (isset($std->boy_scout)) {
                                                if ($std->boy_scout == 0) {
                                                    $boy_scout = false;
                                                } else {
                                                    $boy_scout = true;
                                                }
                                            } else {
                                                $boy_scout = true;
                                            }
                                            ?>
                                            <label><input class="uk-radio" type="radio" name="boy_scout[<?= $std->user_id; ?>]" value="1" <?= $boy_scout === true ? 'checked' : '' ?>> ผ.</label>
                                            <label><input class="uk-radio" type="radio" name="boy_scout[<?= $std->user_id; ?>]" value="0" <?= $boy_scout === false ? 'checked' : '' ?>> มผ.</label>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </form>
                    </tbody>
                </table>

            </div>

            <div class="uk-panel uk-panel-box uk-panel-box-primary uk-margin-top uk-text-center">
                <a class="uk-button uk-button-large uk-width-large-1-4 uk-margin-top" href="<?= site_url('headdepartment/activity_summary') ?>"><i class="uk-icon-home"></i> กลับหน้าหลัก</a>
                <?= $this->activity_summary->AdvisorSaveButton($group->id, $semester->id, 'headdepartment') ?>
                <div id="confirm-form" class="uk-modal">
                    <div class="uk-modal-dialog">
                        <a class="uk-modal-close uk-close"></a>
                        <div class="uk-modal-header">กรุณากดยินยันการบันทึกข้อมูลอีกครั้ง?</div>
                        <div>
                            <button class="uk-button uk-modal-close">ยกเลิก</button>
                            <button class="uk-button uk-button-primary" onclick="document.getElementById('form').submit();">ยืนยันการบันทึกข้อมูล</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>