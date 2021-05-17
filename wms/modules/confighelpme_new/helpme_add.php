<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
?>
  <link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
  <!-- datepicker thai year -->
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
		     var toDay =(d.getFullYear() + 543)  + '-' + (d.getMonth() + 1) + '-' + d.getDate();

	  $("#txtdatestart").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#txtdateend").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	  $("#dateInput").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	});
</script>


<?php

if(isset($_POST['btwb'])){
//	$chkver=$_SESSION['vervalue'];
//	if($chkver<>$_POST['txtver']){
//		echo"คุณกรอกรหัสความปลอดภัยไม่ตรงกับภาพ กรุณาตรวจสอบ";
//	}else{
		$sql="INSERT INTO $table(subject,detail,postby,datepost,ip,status) Values('".EscapeValue($_POST['txtsubject'])."','".EscapeValue($_POST['detail1'])."','".EscapeValue($_SESSION['name'])."','".ChangeYear($_POST['dateInput'],"en")."','".$_SERVER['REMOTE_ADDR']."','0')";
		$rs=rsQuery($sql);

		if($rs){
				// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$table','add',$_SESSION['username'],'ID:'.$_POST['txtsubject']);
			echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
//	}
}
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr>
	<td width="100">ชื่อเรื่อง</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtsubject" /></td>
</tr>
<tr>
	<td>วันที่</td>
	<td><input type="text" name="dateInput" id="dateInput" value="<?php echo ChangeYear(date("Y-m-d"),"th");?>" /></td>
</tr>
<tr>
	<td>รายละเอียด</td>
	<td><textarea name="detail1" class="txtarea"></textarea></td>
</tr>
<!--<tr>
	<td valign="top">รหัสปลอดภัย</td>
	<td><?php include("../itgmod/verify_image.php");?><input type="text" name="txtver" style="margin:2px;border:1px solid;height:23px;width:100px;"/></td>
</tr>-->
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btwb" value="เพิ่มกระทู้" /></td>
</tr>
</table>
</form>
