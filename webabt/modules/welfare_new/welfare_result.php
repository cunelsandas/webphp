<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12/7/2017
 * Time: 3:42 PM
 */
$sql = 'SELECT b.name AS recname,c.name AS stname,a.*,b.*,c.* FROM tb_welfare_request a INNER JOIN tb_welfare_type b on a.type = b.id INNER JOIN tb_welfare_status c ON a.status = c.id WHERE a.personid = \'' . $_SESSION['PID'] . '\'';
$data = result_array($sql);
?>
<style>
    table {
        font-size: 14px;
    }
</style>
<div class="container" style="padding-top: 10px;">
    <div class="card">
        <div class="card-header">
            ตรวจสอบผลการขอขึ้นทะเบียน
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-x:auto; height: 400px">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <thead style="background-color: #4b9cdb">
                    <tr>
                        <th style="color: #e2e6ea">ประเภทเบี้ย</th>
                        <th style="color: #e2e6ea">วันที่ขอ</th>
                        <th style="color: #e2e6ea">สถานะ</th>
                        <th style="color: #e2e6ea">วันที่อนุมัติ</th>
                        <th style="color: #e2e6ea">รายละเอียด</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $val): ?>
                        <tr>
                            <td><?= $val['recname']; ?></td>
                            <td><?= DateThaiNa($val['requestdate']); ?></td>
                            <td><?= $val['stname']; ?></td>
                            <td><?= $val['confirmdate'] == null ? 'ยังไม่ได้ทำการอนุมัติ' : DateThaiNa($val['confirmdate']); ?></td>
                            <td><?= $val['detail'] == null ? '-' : $val['detail'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

