<link rel="stylesheet" type="text/css" href="CSS/jquery-ui-1.7.2.custom.css">
<style type="text/css">
.ui-datepicker{
	width:200px;
	font-family:tahoma;
	font-size:11px;
	text-align:center;
}
</style>

<script type="text/javascript" src="Js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="Js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<center>
<?php
session_start();
$tb_mas="tb_nayok_mas";

if(isset($_POST['btwb'])){
	$chkver=$_SESSION['vervalue'];
	if($chkver<>$_POST['txtver']){
		echo"คุณกรอกรหัสความปลอดภัยไม่ตรงกับภาพ กรุณาตรวจสอบ";
	}else{
		$subject=EscapeValue($_POST['txtsubject']);
		$detail1=EscapeValue($_POST['txtdetail1']);
		$postby=EscapeValue($_POST['txtnamepost']);
		
		$sql="INSERT INTO ".$tb_mas."(subject,detail,postby,datepost,ip,status,deleted) Values('$subject','$detail1','$postby','".$_POST['dateInput']."','".$_SERVER['REMOTE_ADDR']."','1','0')";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='index.php?_mod=".$_GET['_mod']."';</script>";
		}
	}
}
?>

<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="90%" cellpadding="0" cellspacing="1" border="0"  class="tbl-border1">
<tr >
	<td width="20%" class="tbl2">ชื่อเรื่อง</td>
	<td width="80%" class="tbl1" align=left><input type="text" class="txt" name="txtsubject"  size=50/></td>
</tr>

<input type="hidden" name="dateInput" id="dateInput" value="<?php echo date("Y-m-d");?>" />

<tr >
	<td class="tbl2">รายละเอียด</td>
	<td class="tbl1" align=left><textarea name="detail1" class="txtarea" cols=50 rows=5></textarea></td>
</tr>
<tr >
	<td class="tbl2">ชื่อ</td>
	<td class="tbl1" align=left><input type="text" name="txtnamepost"  size=30 /></td>
</tr>
<tr >
	<td valign="top" class="tbl2">รหัสยืนยัน</td>
	<td class="tbl1" align=left><img src="itgmod/verify_image.php" ><input type="text" name="txtver"></td>
</tr>
<tr>
	<td class="tbl2"></td>
	<td class="tbl1" align=left><input class="bt" type="submit" name="btwb" value="บันทึก" /></td>
</tr>
</table>
</form>
</center>