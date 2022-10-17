<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สรุปผลเข้าร่วมกิจกรรมโฮมรูม</title>

    <link rel="stylesheet" href="<?= base_url('assets/font/font.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/reset.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/summaryhomeroom-print.css') ?>">

    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/print.js') ?>"></script>
</head>

<body>

    <div class="pagebreak">
        <p class="header">
            สรุปผลเข้าร่วมกิจกรรมโฮมรูม
            <br>
            <?php $class = strtoupper($data->group_name)[0]; ?>
            ระดับชั้น <?= $class == 'D' || $class == 'E' ? 'ปวส.' : 'ปวช.'  ?> กลุ่มการเรียน <?= $data->group_name ?>
            สาขาวิชา <?= $data->major_name ?>
            <?= $data->semester_name ?>
            <br>
            ครูที่ปรึกษา <?= $data->firstname . ' ' . $data->lastname ?>
        </p>
        <table class="table-std">
            <thead>
                <th style="width: 2em">#</th>
                <th style="width: 7em">รหัสนักศึกษา</th>
                <th colspan="2">ชื่อ - นามสกุล</th>
                <th>มา</th>
                <th>ขาด</th>
                <th>สาย</th>
                <th>ลา</th>
                <th>เปอร์เซนต์</th>
                <th>สรุป</th>
            </thead>
            <tbody>
                <?php foreach ($data->students as $key => $std) { ?>
                <tr>
                    <td style="text-align: center;"><?= ++$key ?></td>
                    <td style="text-align: center;"><?= $std->student_id ?></td>
                    <td><?= $std->firstname ?></td>
                    <td><?= $std->lastname ?></td>
                    <td style="text-align: center;"><?= $std->come ?></td>
                    <td style="text-align: center;"><?= $std->not_come ?></td>
                    <td style="text-align: center;"><?= $std->late ?></td>
                    <td style="text-align: center;"><?= $std->leave ?></td>
                    <td style="text-align: center;"><?= $std->percent ?></td>
                    <td style="text-align: center;"><?= $std->result ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <p style="margin-top: 2em;">
            สรุป ผ่าน: <?= $data->pass ?> คน ไม่ผ่าน: <?= $data->not_pass ?> คน ทั้งหมด: <?= $data->all ?> คน
        <p>
    </div>
</body>

</html>