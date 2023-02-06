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
    <?php ob_start(); ?>
    <div class="pagebreak">
        <div class="d-flex">
            <div style="width: 50%">
                <img src="<?= base_url('assets/imgs/LOGO_Future_Professional_Organizations_of_Thailand.png') ?>" class="logo" align="right">
            </div>
            <div class="right-head">
                <div>อวท.15</div>
                <div>รหัสกลุ่ม 61310505</div>
            </div>
        </div>
        <div class="header">
            แบบสรุปการประเมินผลกิจกรรมชมรมวิชาชีพ
            <br>ชมรมวิชาชีพ เทคโนโลยีสารสนเทศ ภาคการเรียนที่ 1 ปีการศึกษา 2564
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
                for ($i = 1; $i <= 20; $i++) { 
                    if ($n == 17) {
                        echo "
                                </tbody>
                            </table>
                        </div>";
                        echo $html;
                        $n=0;
                    }
                    $n++;
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td>62209010000</td>
                        <td class="text-left">นายพันธกิจ</td>
                        <td class="text-left">มะลิทอง</td>
                        <td>D5</td>
                        <td>ผ.</td>
                        <td>ผ.</td>
                        <td>ผ.</td>
                        <td>ผ.</td>
                        <td>ผ.</td>
                        <td>ผ.</td>
                        <td>ผ.</td>
                        <td>ผ.</td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>