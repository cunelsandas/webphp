<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css">
<style type="text/css">
.ui-datepicker{
	width:200px;
	font-family:tahoma;
	font-size:11px;
	text-align:center;
}
</style>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>


<?php

if(isset($_POST['btwb'])){
	$chkver=$_SESSION['vervalue'];
	if($chkver<>$_POST['txtver']){
		echo"คุณกรอกรหัสความปลอดภัยไม่ตรงกับภาพ กรุณาตรวจสอบ";
	}else{
		$sql="INSERT INTO tb_help_mas(subject,detail,postby,datepost,ip,status) Values('".$_POST['txtsubject']."','".$_POST['detail1']."','".$_SESSION['name']."','".$_POST['dateInput']."','".$_SERVER['REMOTE_ADDR']."','0')";
		$rs=rsQuery($sql);
		if($rs){
				// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_help_mas','add',$_SESSION['username'],'ID:'.$_POST['txtsubject']);
			echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
}
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" cellpadding="2" cellspacing="2" border="0" >
<tr>
	<td width="100">ชื่อเรื่อง</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtsubject" /></td>
</tr>
<tr>
	<td>วันที่</td>
	<td><input type="text" name="dateInput" id="dateInput" value="<?php echo date("Y-m-d");?>" /></td>
</tr>
<tr>
	<td>รายละเอียด</td>
	<td><textarea name="detail1" class="txtarea"></textarea></td>
</tr>
<tr>
	<td valign="top">รหัสปลอดภัย</td>
	<td><?php include("../itgmod/verify_image.php");?><input type="text" name="txtver" style="margin:2px;border:1px solid;height:23px;width:100px;"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btwb" value="เพิ่มกระทู้" /></td>
</tr>
</table>
</form>
