<?php

$id = $_GET['id'] ;
$sql = "SELECT * FROM tb_welfare_request WHERE id = ".$id;
$rs = rsQuery($sql);

$row = mysqli_fetch_array($rs);

$personid =  $row['personid'];
$registerdate = DateThai($row['requestdate']);
$detail = $row['detail'];
$status = $row['status'];

$idprename = FindRS("select prename from tb_citizen where personid= $personid ","prename");
$prename = FindRS("select name from tb_prename where id = $idprename ","name");
$name = FindRS("select name from tb_citizen where personid= $personid ","name");
$surname =FindRS("select surname from tb_citizen where personid= $personid ","surname");
$fullname = $prename.$name."  ".$surname;

$idtype = $row['type'];
$nametype = FindRS("select name from tb_welfare_type where id= $idtype ","name");

$year = $row['year'];
$amount = $row['amount'];




$sqls = "SELECT * FROM tb_welfare_pay WHERE request_id = $id  ORDER BY id DESC LIMIT 0 , 1";
$rss = rsQuery($sqls);
$rows = mysqli_fetch_array($rss);
$paymonth = $rows['paymonth']+1;




if (isset($_POST["btsave"]) != "") {

  $date = $_POST['frm_date'];
  $status = $_POST['frm_status'];
  $amount = $_POST['frm_amount'];
  $detail = $_POST['frm_detail'];
  $dateYear = date('Y');
  $month = $dateYear."-".$_POST['frm_month'];
  //$datepay = date('Y-m-d');
  //$amount = FindRS("select amount from tb_welfare_request where id= $id ","amount");

  $sqls = "INSERT INTO tb_welfare_pay(paydate,status,remark,amount,month,request_id)
  VALUES ('$date','$status','$detail','$amount','$month','$id')";

  if (rsQuery($sqls)) {
    echo "<script>alert('บันทึกข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=welfare_pay_before'</script>";
  }

}


?>


<script>
	$(function () {
		    var d = new Date();
		     var toDay =(d.getFullYear())  + '-' + (d.getMonth() + 1) + '-' + d.getDate();

	  $("#dateInput").datepicker({ showOn: 'focus', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	});

</script>


<div class="content-input" style="width:90%;">
<form name="frmData" method="POST" action="" enctype="multipart/form-data">

<br>

<fieldset>
	<legend>รายละเอียด</legend>
	<table>
	<tr>
    <td>
		ชื่อ-สกุล</td><td><input type="text" name="txtpersonid"value="<?php echo $fullname;?>" disabled>
		</td>
    <td>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลขบัตรประชาชน</td><td><input type="text" name="txtpersonid" value="<?php echo $personid;?>" disabled>
</td>
  </tr>
	<tr>
    <td>
  ประเภทเบี้ย</td><td><input type="text" name="txtpersonid"value="<?php echo $nametype;?>" disabled>
  </td>
</tr>
</table>
</fieldset>
<br>



<fieldset>
	<legend>ประวัติการจ่ายเบี้ย</legend>
<?php
$sqls = "SELECT c.name AS recname ,a.*,b.*,c.* FROM tb_welfare_pay a
        INNER JOIN tb_welfare_request b on a.request_id = b.id
        INNER JOIN tb_welfare_type c on b.type = c.id
        WHERE b.id = '$id'";
        $rss = rsQuery($sqls);
        $data = mysqli_num_rows($rss);
?>

<div class="content-table">
<table style="width:100%">
    <thead>
    <tr>
        <th>ประเภทเบี้ย</th>
        <th>ประจำงวดที่</th>
        <th>สถานะ</th>
        <th>จำนวนเงิน</th>
        <th>วันที่จ่ายเงิน</th>
        <th>หมายเหตุ</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($data != 0) :?>

    <?php while ($val = mysqli_fetch_array($rss)) {?>
        <tr>
            <td><?= $val['recname']; ?></td>
            <td><?= MonthYaerThai($val['month']); ?></td>
            <td><?= $val['status'] == 1 ? 'ยังไม่ได้รับเงิน' : 'รับเงินแล้ว'; ?></td>
            <td><?= $val['amount']?></td>
            <td><?= DateThai($val['paydate']); ?></td>
            <td><?= $val['remark'] == '' ? '-' : $val['remark'] ?></td>
        </tr>
    <?php } ?>

    <?php else:?>
    <tr>
        <td colspan="6" style="text-align: center; padding-top: 15px;"><h3><b style="color: red;">ไม่พบข้อมูล</b></h3></td>
    </tr>
    <?php endif;?>
    </tbody>
</table>
</div>

</fieldset>

<br>

<fieldset>
	<legend>บันทึกการจ่ายเบี้ย</legend>
	<table>

    <tr>
      <td>
        เบี้ยประจำเดือน
  		</td>
      <td>

        <?php
        $string = date('M');
        $month_number = date("n",strtotime($string));
        ?>

        <select name="frm_month">
        <?php
          $sqlmoo="select * from month order by id";
        $rsmoo=rsQuery($sqlmoo);
        if($rsmoo){
          while($dmoo=mysqli_fetch_assoc($rsmoo)){
            $mooid=$dmoo['id'];
            $mooname=$dmoo['month'];
            if($mooid==$month_number){
              echo "<option value='$mooid' selected>$mooname</option>";
            }else{
              echo "<option value='$mooid'>$mooname</option>";
            }
          }
        }
        ?>
        </select>

        &nbsp;&nbsp; ปีงบประมาณ <?php echo $year; ?>
  		</td>
    </tr>

    <tr>
      <td>
    วันที่จ่าย</td><td><input type="text" name="frm_date" id="dateInput" class="datepick" value="<?php echo date('Y-m-d') ?>" >
    </td>
    </tr>

	<tr>
    <td>
		สถานะ</td><td>
      <select name="frm_status">
        <option value='2' selected>รับเงินแล้ว</option>
        <option value='1'>ยังไม่ได้รับเงิน</option>
      </select>
		</td>
  </tr>

  <tr>
    <td>
    จำนวนเงิน </td><td>
      <input type="text" name="frm_amount" value="<?php echo $amount ?>">
    </td>
  </tr>

  <tr>
    <td>
	หมายเหตุ</td>
  <td>
  <textarea  name="frm_detail" rows="5"><?php echo $detail;?></textarea>
</td>
</tr>

</table>
</fieldset>

<input type="hidden" name="frm_paymonth" value="<?php echo $paymonth; ?>" >



<br>
<input type="submit" name="btsave" value="บันทึก">
</form>
</div>
