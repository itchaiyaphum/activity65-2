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
            <?php foreach ($data as $semester) { ?>
            <div class="uk-panel uk-panel-box uk-panel-box-default uk-margin-top">
                <h3 class="uk-panel-title"><?= $semester->name ?></h3>
                <div>
                    <table class="uk-table uk-table-hover uk-table-responsive uk-table-striped" cellpadding="1">
                        <thead>
                            <tr>
                                <th>กลุ่ม</th>
                                <th>สาขางาน</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($semester->group_list as $gr) { ?>
                                <tr>
                                    <td><?= $gr->group_name ?></td>
                                    <td><?= $gr->minor_name ?></td>
                                    <td>
                                        <?= $this->activity_summary->AdvisorIndedxButton($gr->id, $semester->id, 'headdepartment') ?>
                                    </td>
                                    <td>
                                        <?= $this->activity_summary->PrintButton($gr->id, $semester->id, 'headdepartment') ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>