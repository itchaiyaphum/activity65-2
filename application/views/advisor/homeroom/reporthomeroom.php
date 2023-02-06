<?php
$dot = '..............................................';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คป 06</title>

    <link rel="stylesheet" href="<?= base_url('assets/font/font.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/reset.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/print.css') ?>">

    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/print.js') ?>"></script>
</head>

<body>
    <?php
    $count_week = count($week);
    foreach ($week as $k_we => $we) {

        $count_group = count($we->group);

        foreach ($we->group as $k_gr => $gr) {
    ?>
            <div class="pagebreak">
                <div style="width: 100%; height: 100%;">
                    <div style="text-indent: 2em;">
                        <h3 style="display: inline;"><b>บันทึกรายงาน การปฎิบัติงานของครูที่ปรึกษา</b></h3>
                        <span style="float: right; top: 0.2rem"><span style="font-size: 18pt;">&nbsp;</span>สัปดาห์ที่ <?= $we->week; ?> &emsp;&emsp;&emsp; คป ๐๖/๑</span>
                    </div>

                    <div>
                        วันที่&ensp; <?= $gr->thaidate['d']; ?> &ensp;
                        เดือน&ensp; <?= $gr->thaidate['m']; ?> &ensp;
                        พ.ศ.&ensp; <?= $gr->thaidate['y']; ?> &ensp;
                        แผนกวิชา&ensp; <?= $gr->major_name; ?>
                        <br />
                        ระดับ&ensp; <?= $gr->level_group; ?> &ensp;
                        กลุ่ม&ensp; <?= $gr->group_name; ?> &ensp;
                        จำนวนนักศึกษาทั้งหมด&ensp; <?= $gr->std_all; ?> &ensp;คน&nbsp;
                        มา&ensp;&ensp; <?= $gr->std_come; ?> &ensp;คน&nbsp;
                        ขาด&ensp;&ensp; <?= $gr->std_notcome; ?> &ensp;คน
                    </div>
                    <div>
                        <div style="float: left;">ชื่อครูที่ปรึกษา</div>
                        <div style="margin-left: 5em;"><?= $gr->advisor_name; ?></div>
                    </div>
                    <div>
                        <b>๑.&emsp;เรื่องที่ให้คำแนะนำ นักเรียน นักศึกษา ในวันโฮมรูม</b>
                        <div style="width: 100%; padding-left: 2em; overflow: hidden;" class="obedience">
                            <?= $gr->obedience; ?>
                        </div>
                    </div>

                    <div>
                        <b>๒.&emsp;แจ้งรายชื่อนักเรียน-นักศึกษา ที่มีปัญหาให้ผู้ปกครองได้รับทราบ</b> (เรื่องที่แจ้ง เช่น การเข้าแถว/ขาดการโฮมรูม/<br />
                        การไม่เข้าร่วมกิจกรรม/การขาดเรียน/ความประพฤติฯ/หรือเรื่องอื่นๆที่ต้องการแจ้งให้ผู้ปกครองใด้รับทราบ)
                    </div>
                    <br />

                    <table class="risk-table">
                        <thead>
                            <tr>
                                <th style="width: 2em">เลขที่</th>
                                <th style="width: 9em">ชื่อ-สกุล</th>
                                <th style="width: 15em">เรื่องที่แจ้ง</th>
                                <th style="width: 6em">เบอร์โทรผู้ปกครอง</th>
                                <th>หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $risk_count = 0;
                            foreach ($gr->risk as $risk_i) {
                                $risk_count++;
                            ?>
                                <tr>
                                    <td><?= $risk_count; ?></td>
                                    <td><?= $risk_i->firstname . ' ' . $risk_i->lastname; ?></td>
                                    <td><?= $risk_i->risk_detail; ?></td>
                                    <td>&nbsp;</td>
                                    <td><?= $risk_i->risk_comment; ?></td>
                                </tr>
                            <?php

                            }
                            for ($i = 0; $i < (20 - $risk_count); $i++) {
                            ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            <?php
                            }
                            ?>
                        <tbody>
                    </table>
                    <div class="sign">
                        <table class="sign-table">
                            <tr>
                                <td class="sign-l">

                                    <div>
                                        <div class="signature" style="transform: translate(16mm, -7mm);">
                                            <img <?= empty($gr->re_advisor[0]->signature) ? '' : ' src="' . base_url($gr->re_advisor[0]->signature) . '"'; ?> alt="">
                                        </div>
                                        ลงชื่อ

                                        ...........................................................
                                        ครูที่ปรึกษา ๑

                                    </div>
                                    <div class="sign-name" style="margin-left: -13mm;">
                                        (&nbsp;<?= $gr->re_advisor[0]->firstname . ' ' . $gr->re_advisor[0]->lastname; ?>&nbsp;)
                                    </div>
                                </td>
                                <td class="sign-r">
                                    <div>
                                        <div class="signature" style="transform: translate(20mm, -7mm);">
                                            <img <?= empty($gr->headdepartment->signature) ? '' : ' src="' . base_url($gr->headdepartment->signature) . '"'; ?> alt="">
                                        </div>
                                        ลงชื่อ
                                        .........................................................
                                        หัวหน้าแผนกฯ

                                    </div>
                                    <div class="sign-name" style="margin-left: -13mm;">
                                        (&nbsp;<?= empty($gr->headdepartment) ? $dot : $gr->headdepartment->firstname . ' ' . $gr->headdepartment->lastname; ?>&nbsp;)
                                    </div>


                                </td>

                            <tr>
                                <td class="sign-l">
                                    <div>
                                        <div class="signature" style="transform: translate(16mm, -7mm);">
                                            <img <?= empty($gr->re_advisor[1]->signature) ? '' : ' src="' . base_url($gr->re_advisor[1]->signature) . '"'; ?> alt="">
                                        </div>
                                        ลงชื่อ
                                        ...........................................................
                                        ครูที่ปรึกษา ๒

                                    </div>
                                    <div class="sign-name" style="margin-left: -13mm;">
                                        (&nbsp;<?= empty($gr->re_advisor[1]) ? $dot : $gr->re_advisor[1]->firstname . ' ' . $gr->re_advisor[1]->lastname; ?>&nbsp;)
                                    </div>

                                </td>
                                <td class="sign-r">

                                </td>
                            </tr>
                            <tr>
                                <td class="sign-l">
                                    <div>
                                        <div class="signature" style="transform: translate(13mm, -7mm);">
                                            <img <?= empty($gr->headadvisor->signature) ? '' : ' src="' . base_url($gr->headadvisor->signature) . '"'; ?> alt="">
                                        </div>
                                        ลงชื่อ
                                        ..............................................
                                        หัวหน้างานครูที่ปรึกษา

                                    </div>
                                    <div class="sign-name" style="margin-left: -22mm;">
                                        (&nbsp;<?= empty($gr->headadvisor) ? $dot : $gr->headadvisor->firstname . ' ' . $gr->headadvisor->lastname; ?>&nbsp;)
                                    </div>

                                </td>
                                <td class="sign-r">
                                    <div>
                                        <div class="signature" style="transform: translate(13mm, -7mm);">
                                            <img <?= empty($gr->executive->signature) ? '' : ' src="' . base_url($gr->executive->signature) . '"'; ?> alt="">
                                        </div>
                                        ลงชื่อ................................................
                                        รองผู้อำนวยการฝ่ายพัฒนาฯ

                                    </div>
                                    <div class="sign-name" style="margin-left: -30mm;">
                                        (&nbsp;<?= empty($gr->executive) ? $dot : $gr->executive->firstname . ' ' . $gr->executive->lastname; ?>&nbsp;)
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

            <div class="pagebreak">
                <h3 style="text-align: center;">ภาพกิจกรรมโฮมรูม สัปดาห์ที่ <?= $we->week; ?> กลุ่ม <?= $gr->group_name; ?></h3>

                <div class="img-top">
                    <img <?= empty($gr->obediences_img[0]->img) ? '' : ' src="' . base_url($gr->obediences_img[0]->img) . '"'; ?> alt="">
                </div>
                <div class="img-bottom">
                    <img <?= empty($gr->obediences_img[1]->img) ? '' : ' src="' . base_url($gr->obediences_img[1]->img) . '"'; ?> alt="">
                </div>
            </div>

</body>

</html>
<?php
        }
    }
?>