<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12/6/2017
 * Time: 1:48 PM
 */
$Y = date('Y') + 543;
$sqlYear = 'SELECT * FROM tb_welfare WHERE year = ' . $Y;
$year = result_row($sqlYear);
$sqlID = 'SELECT * FROM tb_citizen WHERE id = \'' . $_SESSION['ID'] . '\'';
$Master = result_row($sqlID);
$sqlReceivet = 'SELECT * FROM tb_welfare_receivetype';
$Receivet = result_array($sqlReceivet);
$yearA = $year['year'];
$personID = $Master['personid'];
$calage = getAge2($Master['birthdate']);
if ($calage >= 90) {
    $olderpay = $year['older90'];
} elseif ($calage >= 80 && $calage < 90) {
    $olderpay = $year['older80'];
} elseif ($calage >= 70 && $calage < 80) {
    $olderpay = $year['older70'];
} elseif ($calage >= 60 && $calage < 70) {
    $olderpay = $year['older60'];
} else {
    $olderpay = 0;
}
$showolder = result_row('SELECT * FROM tb_welfare_request WHERE type = \'1\' AND year = \'' . $yearA . '\' AND personid = \'' . $personID . '\'');
if (strtotime($Master['birthdate']) >= strtotime($year['birthdate']) || $showolder != '') {
    $showolder = "disabled";
} else {
    $showolder = "";
}
$showhandicap = result_row('SELECT * FROM tb_welfare_request WHERE type = \'2\' AND year = \'' . $yearA . '\' AND personid = \'' . $personID . '\'');
$showaids = result_row('SELECT * FROM tb_welfare_request WHERE type = \'3\' AND year = \'' . $yearA . '\' AND personid = \'' . $personID . '\'');
$showhandicap = ($showhandicap == '' ? '' : "disabled");
$showaids = ($showaids == '' ? '' : "disabled");
if ($showolder == 'disabled' && $showhandicap == 'disabled' && $showaids == 'disabled') {
    $showBt = 'disabled';
    $showTxt = 'ท่านไม่สามารถขอรับเบี้ยได้';
} else {
    $showBt = '';
    $showTxt = '';
}
?>
<style>
    #aa, .form-control, .form-check, .form-group, label, .file, .row {
        font-size: 14px;
    }

    .form-control {
        padding: 0.375rem 0.75rem;
    }
</style>
<div class="container" style="padding-top: 10px;">
    <div class="card">
        <div class="card-header">
            ขอขึ้นทะเบียนรับเงินเบี้ยยังชีพ
        </div>
        <div class="card-body">
            <h5 class="card-title">ปีงบประมาณ <?php echo $year['year'] ?></h5>
            <form method="post" enctype="multipart/form-data">
                <input type="text" value="<?php echo $year['year'] ?>" name="year" hidden>
                <input type="text" value="<?php echo $Master['personid'] ?>" name="personid" hidden>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="<?= $olderpay ?>"
                               name="olderpay" <?= $showolder ?>>
                        ขอรับเบี้ยยังชีพผู้สูงอายุ ( ท่านต้องเกิดก่อนวันที่ <?php echo DateThaiNa($year['birthdate']) ?>
                        ) อายุ <?php echo $calage ?> จำนวนเงิน <?= $olderpay ?> บาท
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="<?= $year['handicap'] ?>"
                               name="handicap" <?= $showhandicap ?>>
                        ขอรับเบี้ยยังชีพผู้พิการ จำนวน <?= $year['handicap'] ?> บาท
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="<?= $year['aids'] ?>"
                               name="aids" <?= $showaids ?>>
                        ขอรับเบี้ยยังชีพผู้ป่วยเอดส์ จำนวนเงิน <?= $year['aids'] ?> บาท
                    </label>
                </div>
                <div>
                    <label>* หากท่านเคยลงทะเบียนในปีงบประมาณ <?php echo $year['year']; ?>
                        ไว้แล้วจะไม่สามารถลงซ้ำได้ </label>
                </div>
                <div class="row" style="padding-bottom: 10px;">
                    <div class="col-sm-6">
                        เลือกวิธีการรับเงิน
                        <select name="receivetype" class="form-control" <?php echo $showBt ?>>
                            <?php
                            foreach ($Receivet as $key => $value):
                                ?>
                                <option value="<?= $value['id']; ?>"><?= $value['name'] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>
                <button type="submit" name="btRequest" class="btn btn-outline-success" <?php echo $showBt ?>>บันทึก
                </button>
                <span><?php echo $showTxt ?></span>
            </form>
        </div>
    </div>
</div>
