<?php
$tb_mas="tb_nayok_mas";
$tb_sub="tb_nayok_sub";
$timedate=date("Y-m-d");
//แจ้งลบกระทู้ย่อย
if(isset($_GET['subno'])){
	$str="update ".$tb_sub." set deleted='1' where no='".$_GET['subno']."'";
	$rs=rsQuery($str);
	echo "<script>alert('ระบบรับแจ้งการลบ ID : ".$_GET['subno']." ไว้แล้ว');window.location.href='index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."';</script>";
}

//แจ้งลบกระทู้หลัก
if(isset($_GET['masno'])){
	$str="update ".$tb_mas." set deleted='1' where wid='".$_GET['masno']."'";
	$rs=rsQuery($str);
	echo "<script>alert('ระบบรับแจ้งการลบ  ID : ".$_GET['masno']." ไว้แล้ว');window.location.href='index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."';</script>";
}

if(isset($_POST['btaddpost'])){
	$chkver=$_SESSION['vervalue'];
	if($chkver<>$_POST['txtver']){
		echo"คุณกรอกรหัสผ่านไม่ตรงกับภาพ กรุณาตรวจสอบ";
	}else{
	$sql="INSERT INTO ".$tb_sub."(wid,detail,postby,datepost,ip,status,deleted) VALUES('".$_GET['no']."','".$_POST['txtpostadd']."','".$_POST['txtname']."','$timedate','".$_SERVER['REMOTE_ADDR']."','1','0')";
	$rs=rsQuery($sql);
	if($rs){
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."';</script>";
	}
}
}
$no=EscapeValue(decode64($_GET['no']));
$sql="Select * From ".$tb_mas." Where status='1' AND wid='$no'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
?>
<center>
<table width="90%" cellpadding="1" cellspacing="1" border="0" style="margin:10px;" id="border-dash-green">
<tr>
	<td colspan="2" align="left" >
		กระทู้ ID [<?php echo $row['wid'];?>] : <?php echo "&nbsp;&nbsp;".$row['subject'];?><br><br>&nbsp;
		<?php echo nl2br($row['detail']);?><br><br>&nbsp;&nbsp;&nbsp;
		<font id=text9-clay>&nbsp;&nbsp;โดย&nbsp;<?php echo $row['postby'];?>&nbsp;&nbsp;IP :<?php echo $row['ip'];?>&nbsp;&nbsp;วันที่ : <?php echo $row['updatetime'];?></font>&nbsp;&nbsp;&nbsp;
		<?php
		echo "<a href=index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."&masno=".$row['wid']." class=list>แจ้งลบ</a>";
		?>
	</td>
</tr>

</table><br>

<?php
$sql="Select * From ".$tb_sub." Where status='1' AND wid='".$_GET['no']."' Order by no DESC";
$rs=rsQuery($sql);
if(mysqli_num_rows($rs)>0){
	while($arr=mysqli_fetch_array($rs)){
		
		echo "<table width=90% cellpadding=1 cellspacing=1 border=0 id=border-dot-yellow>";
	
		echo"<tr>";
		echo"<td align=left><font id=text9-clay>Re : ID [".$arr['no']."]</font><br><br>&nbsp;";
		echo nl2br($arr['detail'])."<br><br>&nbsp;&nbsp;&nbsp;";
		echo "<font id=text9-clay>ตอบโดย : ".$arr['postby']."&nbsp;IP : ".$arr['ip']."&nbsp;วันที่ : ".$arr['updatetime']."</font>&nbsp;&nbsp;&nbsp;<a href=index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."&subno=".$arr['no']." class=list>แจ้งลบ</a>";
		echo"</tr>";
		echo"</table><br>";
	}
}
?>
</center>
<!-- ปิด ไม่ให้มีการตอบ 
<hr style="width:90%;">
<form name="frmaddpost" method="POST" action="">
<table width="90%" cellpadding="1" cellspacing="1" border="0" style="margin:10px;">
<tr>
	<td width="20%" valign="top"><p>ตอบกระทู้</p></td>
	<td width="80%" valign="top" align=left ><textarea class="txtarea" name="txtpostadd" cols=50 rows=5></textarea></td>
</tr>
<tr>
	<td  valign="top"><p>ชื่อ</p></td>
	<td  valign="top" align=left><input type="text" name="txtname" size="30"></td>
</tr>
<tr >
	<td valign="top" class="tbl1">รหัสผ่าน</td>
	<td class="tbl1" align=left><?php include("verify_image.php");?><input type="text" name="txtver" style="margin:2px;border:1px solid;height:23px;width:100px;"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td align=left><input class="bt" type="submit" name="btaddpost" value="ตอบกระทู้"/></td>
</tr>
</table>
</form>
-->