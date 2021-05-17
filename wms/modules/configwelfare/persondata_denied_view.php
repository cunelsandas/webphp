<?php

error_reporting(0);

	$id=$_GET['id'];
	$sql="select * from tb_citizen where id=$id";
	$rs=rsQuery($sql);

// แสดงข้อมูลจากไฟล์ persondata.php
	if(mysqli_num_rows($rs)>0){

	$data=mysqli_fetch_assoc($rs);

	$id=$data['id'];
	$personid=$data['personid'];
	$name=$data['name'];
	$surname=$data['surname'];
	$prename=$data['prename'];
	$address=$data['address'];
	$moo=$data['moo'];
  $denied=$data['id_denied'];

  $prename = FindRS("select name from tb_prename where id = $prename ","name");
  $fullname = $prename.$name."  ".$surname;


  $nametype = FindRS("select name from tb_welfare_type where id= $idtype ","name");
	}

		if(isset($_POST['btsave'])){

      $type = $_POST['radio'];
      $detail = $_POST['detail'];
      $end_str_pay = $_POST['end_str_pay'];

	$sql="Update tb_citizen SET status='3',id_denied='$type',datail_denied='$detail',date_denied='$end_str_pay' Where id=$id";
	$rs=rsQuery($sql);

  $sql="Update tb_welfare_request SET status = '5',end_pay_date = '".$end_str_pay."'  Where personid=".$personid;
	$rs=rsQuery($sql);

	if($rs){

		echo "<script>alert('บันทึกข้อมูลแล้ว');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=persondata_denied'</script>";

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
         $("#end_str_pay").datepicker({ showOn: 'focus', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                   dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
                   monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
                   monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	});

</script>
<div class="content-input" style="width:90%;">
	<h3>จำหน่ายผู้มีสิทธิ์</h3>
	<hr>
<form name="frmData" method="POST" action="" enctype="multipart/form-data">
<div align="left"><input type="hidden" name="txtid" value="<?php echo $id;?>">

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
    <td>ประเภทเบี้ย&nbsp;&nbsp;&nbsp;</td>
    <td colspan="2">
    <?php
    $sql1 = "SELECT * FROM tb_welfare_request WHERE personid = '".$personid."'";
    $rs1 = rsQuery($sql1);
    while ($row = mysqli_fetch_array($rs1)) {
      $type = $row['type'];
      $nametype = FindRS("select name from tb_welfare_type where id= $type ","name");
      echo "&nbsp;'".$nametype."' &nbsp;";
    }
    ?>
  </td>
</tr>

</table>
</fieldset>

<br>

<fieldset>
	<legend>ประเภทการจำหน่าย</legend>
	<table>
	<tr>
  		<?php
  			$sqlmoo="select * from tb_denied order by id";
  			$rsmoo=rsQuery($sqlmoo);
        $i = 1;
  			if($rsmoo){
  				while($dmoo=mysqli_fetch_assoc($rsmoo)){

  					$mooid=$dmoo['id'];
  					$mooname=$dmoo['name'];
  					if($mooid==$denied){
  						echo '<td><input type="radio" id="radio'.$i.'" name="radio" value="'.$i.'" checked><label for="radio'.$i.'">&nbsp; '.$mooname.' &nbsp;&nbsp;&nbsp;</label></td>';
  					}else{
  						echo '<td><input type="radio" id="radio'.$i.'" name="radio" value="'.$i.'"><label for="radio'.$i.'">&nbsp; '.$mooname.' &nbsp;&nbsp;&nbsp;</label></td>';
  					}
            $i++;
  				}
  			}
  		?>
  </tr>
  <tr>
    <td colspan="1">
      <label>หมายเหตุ</label>
    </td>
    <td colspan="4">
      <br>
      <textarea name="detail" rows="4"></textarea>
    </td>
  </tr>

</table>
</fieldset>

<br>

<input type="hidden" name="end_str_pay" id="end_str_pay" value="<?php echo date('Y-m-d');?>"/>

<input type="submit" name="btsave" value="บันทึก">


</form>
</div>
</div>
