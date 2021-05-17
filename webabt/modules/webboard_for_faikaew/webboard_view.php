<script>
		function checkdetail(){
			if(document.getElementById('txtpostadd').value=="" || document.getElementById('txtname').value=="" ){
				alert("กรุณากรอกข้อมูลให้ครบทุกช่อง!!!");
				return false;
			}
			return true;
}
</script>
<?php
$timedate=date("Y-m-d");
//แจ้งลบกระทู้ย่อย
if(isset($_GET['subno'])){
	$subno=EscapeValue(decode64($_GET['subno']));
	$str="update tb_wb_sub set deleted='1' where no='$subno'";
	$rs=rsQuery($str);
	echo "<script>alert('ระบบรับแจ้งการลบ ID : ".$subno." ไว้แล้ว');window.location.href='index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."';</script>";
}

//แจ้งลบกระทู้หลัก
if(isset($_GET['masno'])){
	$masno=EscapeValue(decode64($_GET['masno']));
	$str="update tb_wb_mas set deleted='1' where wid='$masno'";
	$rs=rsQuery($str);
	echo "<script>alert('ระบบรับแจ้งการลบ  ID : ".$masno." ไว้แล้ว');window.location.href='index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."';</script>";
}

if(isset($_POST['btaddpost'])){
	$chkver=$_SESSION['vervalue'];
	if($chkver<>$_POST['txtver']){
		echo"คุณกรอกรหัสผ่านไม่ตรงกับภาพ กรุณาตรวจสอบ";
	}else{
	$dt=date("Y-m-d H:i:s");
	$postadd=EscapeValue($_POST['txtpostadd']);
	$name=EscapeValue($_POST['txtname']);
	

	$sql="INSERT INTO tb_wb_sub(wid,detail,postby,datepost,ip,status,deleted,createdate) VALUES('".EscapeValue(decode64($_GET['no']))."','".$postadd."','".$name."','$timedate','".$_SERVER['REMOTE_ADDR']."','1','0','$dt')";
	$rs=rsQuery($sql);
	if($rs){
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."';</script>";
	}
}
}
$sql="Select * From tb_wb_mas Where status='1' AND wid='".EscapeValue(decode64($_GET['no']))."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$cdate=$row['createdate'];
			if($cdate==null){
				$dt=DateThai($row['datepost']);
			}else{
				$dt=DateTimeThai($row['createdate']);
			}
?>
<center>
<div id='master-table'>
<table  >
<tr>
	<td align="left" class="master" ><font id=wb-subject>
		กระทู้ ID [<?php echo $row['wid'];?>] : <?php echo "&nbsp;&nbsp;".$row['subject'];?></font><br><br>&nbsp;
		<?php echo nl2br($row['detail']);?><br><br>&nbsp;&nbsp;&nbsp;
		<hr><br>
		&nbsp;&nbsp;โดย&nbsp;<?php echo $row['postby'];?>&nbsp;&nbsp&nbsp;&nbsp;วันที่ : <?php echo $dt;?>&nbsp;&nbsp;&nbsp;ไอพี:<?php echo $row['ip'];?>&nbsp;&nbsp;&nbsp;
		<?php
		echo "<a href=index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."&masno=".encode64($row['wid'])." class=list>แจ้งลบ</a>";
		?>
	</td>
</tr>

</table>
</div>
<br>

<?php

$sql="Select * From tb_wb_sub Where status='1'  AND wid='".EscapeValue(decode64($_GET['no']))."' Order by no DESC";
$rs=rsQuery($sql);
if(mysqli_num_rows($rs)>0){
	while($arr=mysqli_fetch_array($rs)){
		$cdate=$arr['createdate'];
			if($cdate==null){
				$dt=DateThai($arr['datepost']);
			}else{
				$dt=DateTimeThai($arr['createdate']);
			}
		echo "<div id='master-table'>";
		echo "<table width=90% cellpadding=1 cellspacing=1 border=0 class=tbl-2>";
	
		echo"<tr>";
		echo"<td align=left class=tbl-border-webboard-sub><font id=text-clay>Re : ID [".$arr['no']."]</font><br><br>&nbsp;";
		echo "<font id=wb-detail>".nl2br($arr['detail'])."</font><br><br>&nbsp;&nbsp;&nbsp;";
		echo "<hr><br>";
		echo "<font id=text-clay>ตอบโดย : ".$arr['postby']."&nbsp;&nbsp;วันที่ : ".$dt."</font>&nbsp;&nbsp;&nbsp;ไอพี:". $arr['ip']."&nbsp;&nbsp;&nbsp;<a href=index.php?_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."&subno=".encode64($arr['no'])." class=list>แจ้งลบ</a>";
		echo"</tr>";
		echo"</table></div><br>";
	}
}
?>
</center>
<hr style="width:90%;"><br>
<form name="frmaddpost" method="POST" action="">
<table class='content-input'>
<tr>
	<td width="20%" valign="top" class=tbl1><p>ตอบกระทู้</p></td>
	<td width="80%" valign="top" align=left ><textarea class="txtarea" name="txtpostadd" id="txtpostadd" cols=50 rows=5></textarea></td>
</tr>
<tr>
	<td  valign="top" class=tbl1><p>ชื่อ</p></td>
	<td  valign="top" align=left><input type="text" name="txtname" size="30" id="txtname"></td>
</tr>

<tr >
	<td valign="top"  align="right">ป้อนรหัสยืนยัน :</td>
	<td >เงื่อนไข<br>
			1. กรุณาป้อนข้อมูลให้ครบทุกช่อง มิฉะนั้นจะไม่สามารถบันทึกได้<br>
			2. กรุณาใช้คำที่สุภาพและไม่เป็นการหมิ่นประมาท ใส่ร้ายผู้อื่น<br>
			3. ทางทีมงานขอสงวนสิทธิ์ในการลบข้อความไม่เหมาะสมใดๆโดยมิต้องแจ้งล่วงหน้า <br>
			ข้าพเจ้าขอยืนยันที่จะปฏิบัติตามเงื่อนไข <br>
			<img src="itgmod/verify_image.php">(กรุณาพิมพ์อักษรให้เหมือนดังภาพ)<br>
			<input type="text" name="txtver" >
	</td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td align=left><input class="bt" type="submit" name="btaddpost" value="ตอบกระทู้" onclick="return checkdetail();"/></td>
</tr>
</table>
<center>
	<A HREF="javascript:history.back()">ย้อนกลับ</A>
</center>
</form>

