<?php

$id = $_GET['id'] ;
$sql = "SELECT * FROM tb_welfare_request WHERE id = ".$id;
$rs = rsQuery($sql);

$row = mysqli_fetch_array($rs);

$personid =  $row['personid'];
$registerdate = DateThai($row['requestdate']);
$detail = $row['detail'];
$status = $row['status'];
$start_pay_date = $row['start_pay_date'];

$idprename = FindRS("select prename from tb_citizen where personid= $personid ","prename");
$prename = FindRS("select name from tb_prename where id = $idprename ","name");
$name = FindRS("select name from tb_citizen where personid= $personid ","name");
$surname =FindRS("select surname from tb_citizen where personid= $personid ","surname");
$fullname = $prename.$name."  ".$surname;

$idtype = $row['type'];
$nametype = FindRS("select name from tb_welfare_type where id= $idtype ","name");

// UPDATE

if (isset($_POST["btsave"]) != "") {

  $frm_status = $_POST['frm_status'];
  $frm_detail = $_POST['frm_detail'];
  $configdate = date("Y-m-d");
  $frm_str_pay = $_POST['frm_str_pay'];

  $sqls = "UPDATE tb_welfare_request SET status = '$frm_status', detail = '$frm_detail'  WHERE id =".$id;

  if ($frm_status == "2") {
    $sqlss = "UPDATE tb_citizen SET status = '2' WHERE personid =".$personid;
    rsQuery($sqlss);
    $sqls = "UPDATE tb_welfare_request SET status = '$frm_status', confirmdate = '$configdate', detail = '$frm_detail', start_pay_date = '$frm_str_pay'  WHERE id =".$id;
  }

  if (rsQuery($sqls)) {
    echo "<script>alert('บันทึกข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=welfare_confirm'</script>";
  }


}

?>

<link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
 <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
<style type="text/css">
.ui-datepicker{
	width:200px;
	font-family:tahoma;
	font-size:11px;
	text-align:center;
}
</style>
<script>
	$(function () {
		    var d = new Date();
		    var toDay = new Date();

	  $("#frm_str_pay").datepicker({ showOn: 'focus', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
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
<tr>
  <td>
วันที่ยืนเรื่อง</td><td><input type="text" name="txtpersonid"value="<?php echo $registerdate;?>" disabled>
</td>
</tr>
</table>
</fieldset>
<br><br><br>


<fieldset>
	<legend>ช่องทางการติดต่อ</legend>

	<table width="100%">
    <tr>
      <td width="25%" align="center"><img src="../../images/component/Call.svg" alt="Smiley face" height="80" width="100"></td>
      <td width="25%" align="center"><a href="https://www.google.com/gmail/"><img src="../../images/component/Mail.png" alt="Smiley face" height="75" width="90"></a></td>
      <td width="25%" align="center"><img src="../../images/component/Line.png" alt="Smiley face" height="80" width="80"></td>
      <td width="25%" align="center"><a href="https://www.facebook.com/"><img src="../../images/component/Facebook.png" alt="Smiley face" height="60" width="60"></a></td>
    </tr>
	<tr>
    <td width="25%" align="center"><?php echo $telephone; ?></td>
    <td width="25%" align="center"><?php echo $email; ?></td>
    <td width="25%" align="center"><?php echo $line; ?></td>
    <td width="25%" align="center"><?php echo $facebook; ?></td>
  </tr>

</table>

</fieldset>

<br><br><br>


<fieldset>
	<legend>กำหนดสถานะผู้รับสิทธิ</legend>
	<table>
	<tr>
    <td>
		สถานะผู้รับสิทธิ</td><td>
      <select name="frm_status">
      <?php
        $sqlmoo="select * from tb_welfare_status order by id";
      $rsmoo=rsQuery($sqlmoo);
      if($rsmoo){
        while($dmoo=mysqli_fetch_assoc($rsmoo)){
          $mooid=$dmoo['id'];
          $mooname=$dmoo['name'];
          if($mooid==$status){
            echo "<option value='$mooid' selected>$mooname</option>";
          }else if ($mooid == "5") {
            // code...
          }else{
            echo "<option value='$mooid'>$mooname</option>";
          }
        }
      }
      ?>
      </select>
		</td>
  </tr>
  <tr>
    <td>วันที่เริ่มจ่ายเบี้ย</td>
  <td>
  <input type="text" name="frm_str_pay" id="frm_str_pay" value="<?php if ($start_pay_date = "0000-00-00"){ echo date('Y-m-d'); }else { echo $start_pay_date; }?>"/>
</td>
</tr>

<tr>
  <td>
รายละเอียด</td>
<td>
<textarea colspan="2" name="frm_detail" rows="5"><?php echo $detail;?></textarea>
</td>
</tr>

</table>
</fieldset>
<br>
<input type="submit" name="btsave" value="บันทึก">
</form>
</div>
