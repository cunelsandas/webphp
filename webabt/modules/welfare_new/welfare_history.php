<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12/7/2017
 * Time: 3:42 PM
 */
$sql = 'SELECT c.name AS recname ,a.*,b.*,c.* FROM tb_welfare_pay a
        RIGHT JOIN tb_welfare_request b on a.request_id = b.id
        INNER JOIN tb_welfare_type c on b.type = c.id
        WHERE b.personid = \'' . $_SESSION['PID'] . '\'';
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
            ประวัติการรับเงิน
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-x:auto; height: 400px">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <thead style="background-color: #4b9cdb;">
                    <tr>
                        <th style="color: #e2e6ea">ประเภทเบี้ย</th>
                        <th style="color: #e2e6ea">ประจำงวดที่</th>
                        <th style="color: #e2e6ea">สถานะ</th>
                        <th style="color: #e2e6ea">จำนวนเงิน</th>
                        <th style="color: #e2e6ea">วันที่จ่ายเงิน</th>
                        <th style="color: #e2e6ea">หมายเหตุ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $val): ?>
                        <?php if ($val['paydate'] != []): ?>
                          <tr>
                              <td><?= $val['recname']; ?></td>
                              <td><?= MonthYaerThai($val['month']); ?></td>
                              <td><?= $val['status'] == 1 ? 'ยังไม่ได้รับเงิน' : 'รับเงินแล้ว'; ?></td>
                              <td><?= $val['amount']?></td>
                              <td><?= DateThaiNa($val['paydate']); ?></td>
                              <td><?= $val['remark'] == '' ? '-' : $val['remark'] ?></td>
                          </tr>
                        <?php endif; ?>


                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
