<?php
	$file_no=($gloFile_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloData_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
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
################## เพิ่มฝ่าย #######################
if(isset($_POST['btadddep'])){ // เมื่อมีการคลิกปุ่มเพิ่มฝ่าย
	if($_POST['name']<>""){
		$sql="Select * From tb_filestype Where name='".EscapeValue($_POST['name'])."'";
		$rs=rsQuery($sql);
		if($rs){
			$rows=mysqli_num_rows($rs);
		}else{
			$rows="0";
		}
		if($rows==0){
			$sql="INSERT INTO tb_filestype(name) Values('".EscapeValue($_POST['name'])."')";
			$rssave=rsQuery($sql);
		}else{
			echo"<p style=\"margin-left:10px;\">ชื่อ ".$_POST['name']." มีอยู่แล้วในระบบ</p>";
		}
	}
}
?>
<!--<div class="content-input">
<form name="adddep" method="POST" action="" enctype="multipart/form-data">
<p style="margin-left:10px;">เพิ่มประเภทเอกสาร : <input type="text" class="txt" name="name" autocomplete="off" style="width:250px;" />&nbsp;<input class="bt" type="submit" name="btadddep" value="เพิ่ม"/></p>
</form>
</div>-->

<!--        จบการเพิ่มไฟล์เอกสาร             -->
<?php

if(isset($_POST['btaddnew'])){
  

	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
$sql="INSERT INTO $table(name,email,status) Values('".EscapeValue($_POST['txtsubject'])."','".$_POST['txtemail']."','$ac')";
echo $sql;
	$rs=rsQuery($sql);
	if($rs){
		

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_file','add',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
?>
<form name="frmnew" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input" >
<tr>
	<td width="25%">ชื่อกอง</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtsubject" /></td>
</tr>
<tr>
	<td width="25%">อีเมลล์</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtemail" /></td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td><input type="checkbox" name="active" />&nbsp;Active</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btaddnew" value="เพิ่ม" /></td>
</tr>
</table>
</form>