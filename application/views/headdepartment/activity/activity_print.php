<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบสรุปการประเมินผลกิจกรรมชมรมวิชาชีพ</title>

    <link rel="stylesheet" href="<?= base_url('assets/font/font.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/reset.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/summaryactivity-print.css') ?>">

    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/print.js') ?>"></script>
</head>

<body>
    <!-- <pre>
        <?php var_dump($data); ?>
    </pre> -->
    <?php ob_start(); ?>
    <div class="pagebreak">
        <div class="d-flex">
            <div style="width: 50%">
                <img src="<?= base_url('assets/imgs/LOGO_Future_Professional_Organizations_of_Thailand.png') ?>" class="logo" align="right">
            </div>
            <div class="right-head">
                <div>อวท.15</div>
                <div>รหัสกลุ่ม <?= $data->group_code ?></div>
            </div>
        </div>
        <div class="header">
            แบบสรุปการประเมินผลกิจกรรมชมรมวิชาชีพ
            <br>ชมรมวิชาชีพ <?= $data->major_name . ' ' . str_replace("/", " ปีการศึกษา ", $data->semester_name); ?>
            <br>ระบบการเรียน (&nbsp;&nbsp;&nbsp;) ชั้นเรียนปกติ (&nbsp;&nbsp;&nbsp;) นอกชั้นเรียนปกติ
        </div>
        <table class="table-content">
            <thead>
                <tr>
                    <th rowspan="2">ลำดับ</th>
                    <th rowspan="2">รหัสนักเรียน นักศึกษา</th>
                    <th rowspan="2" colspan="2" style="width: 12em;">ชื่อ - นามสกุล</th>
                    <th rowspan="2">แผนก/ชั้น/กลุ่ม</th>
                    <th>กิจกรรม<br>หน้าเสาธง</th>
                    <th>กิจกรรม<br>ชมรม</th>
                    <th>กิจกรรม<br>โฮมรูม</th>
                    <th>กิจกรรม<br>พิเศษ</th>
                    <th>กิจกรรม<br>ลูกเสือ</th>
                    <th>กิจกรรม<br>รด.</th>
                    <th>บันทึกพิเศษ</th>
                    <th colspan="2">ผลการประเมิน</th>
                </tr>
                <tr>
                    <th colspan="7" style="text-align: left;">
                        &nbsp;(&nbsp;&nbsp;) บันทึกกาารเข้าร่วมกิจกรรมของชมรม<br>
                        &nbsp;(&nbsp;&nbsp;) หนังสือรับรองการเข้าร่วมกิจกรรม จากหน่วยงานสังกัดหรือหน่วยงานอื่นๆ
                    </th>
                    <th>ผ่าน (ผ.)</th>
                    <th>ไม่ผ่าน (มผ.)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $html = ob_get_contents();
                ob_end_flush();
                $n = 0;
                foreach ($data->students as $key => $std) {
                    if ($n == 17) {
                        echo "
                                </tbody>
                            </table>
                        </div>";
                        echo $html;
                        $n = 0;
                    }
                    $n++;
                ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $std->student_code ?></td>
                        <td class="text-left"><?= $std->firstname ?></td>
                        <td class="text-left"><?= $std->lastname ?></td>
                        <td><?= $data->group_name ?></td>
                        <td>
                            <?php
                            if ($std->flagpole === '1') {
                                echo "ผ.";
                            } elseif ($std->flagpole === '0') {
                                echo "<span style='color: #dc3545;'>มผ.</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($std->club === '1') {
                                echo "ผ.";
                            } elseif ($std->club === '0') {
                                echo "<span style='color: #dc3545;'>มผ.</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($std->homeroom === '1') {
                                echo "ผ.";
                            } elseif ($std->homeroom === '0') {
                                echo "<span style='color: #dc3545;'>มผ.</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($std->special === '1') {
                                echo "ผ.";
                            } elseif ($std->special === '0') {
                                echo "<span style='color: #dc3545;'>มผ.</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($std->boy_scout === '1') {
                                echo "ผ.";
                            } elseif ($std->boy_scout === '0') {
                                echo "<span style='color: #dc3545;'>มผ.</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($std->TROTCS === '1') {
                                echo "ผ.";
                            } elseif ($std->TROTCS === '0') {
                                echo "<span style='color: #dc3545;'>มผ.</span>";
                            }
                            ?>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>