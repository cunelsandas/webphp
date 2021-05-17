<?php
$timedate=date("Y-m-d");
if(isset($_POST['btaddpost'])){
	$dt=date("Y-m-d H:i:s");
	$sql="INSERT INTO tb_wb_sub(wid,detail,postby,datepost,ip,status,deleted,createdate) VALUES('".$_GET['wid']."','".EscapeValue($_POST['txtpostadd'])."','".$_SESSION['name']."','$timedate','".$_SERVER['REMOTE_ADDR']."','1','0','$dt')";
	$rs=rsQuery($sql);
	if($rs){
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_wb_sub','add',$_SESSION['username'],'ID:'.$_POST['txtpostadd']);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&wid=".$_GET['wid']."';</script>";
	}
}
//if(isset($_POST['btdelete'])){
	//$strDel="Delete from tb_wb_sub Where no='" .$_POST['btdelete'] . "'";
	if(isset($_GET['subno'])){
	$subno=EscapeValue($_GET['subno']);
	$strDel="Update tb_wb_sub SET status='0' Where no='".$subno."'";
	$rsdel=rsQuery($strDel);
	if($rsdel){
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_wb_sub','delete',$_SESSION['username'],'ID:'.$_GET['subno']);
		echo"<script>alert('ลบข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=view&wid=".$_GET['wid']."';</script>";
	}
}

if(isset($_GET['masno'])){
	$masno=EscapeValue($_GET['masno']);
	$strDel="Update tb_wb_mas SET status='0' Where wid='".$masno."'";
	$rsdel=rsQuery($strDel);
	if($rsdel){
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_wb_sub','delete',$_SESSION['username'],'ID:'.$_GET['masno']);
		echo"<script>alert('ลบข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$wid=EscapeValue($_GET['wid']);
$sql="Select * From tb_wb_mas Where wid='".$wid."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
if($row['status']==0){
			$mas_bgcolor="#D3D3D3";
		}else{
			$mas_bgcolor="#EBF2FE";
		}
?>
<center>
<form name="frmaddpost" method="POST" action="">
<table width="90%" cellpadding="1" cellspacing="1" border="0" style="border-style:dashed; border-color:#CCCC00; background:<?php echo $mas_bgcolor;?>; border-width:1px ; padding:10px">
<tr>
	<td colspan="2" align="left" >
		MasID [<?php echo $row['wid'];?>] : <?php echo "&nbsp;&nbsp;".$row['subject'];?><br><br>&nbsp;
		<?php echo nl2br($row['detail']);?><br><br>&nbsp;&nbsp;&nbsp;
		<font id=text9-clay>&nbsp;&nbsp;โดย&nbsp;<?php echo $row['postby'];?>&nbsp;&nbsp;IP :<?php echo $row['ip'];?>&nbsp;&nbsp;วันที่ : <?php echo $row['updatetime'];?></font>&nbsp;&nbsp;&nbsp;
		<?php
		echo "<a href=main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."&masno=".$row['wid']." class=list>ลบ</a>";
		?>
	</td>
</tr>

</table><br>
<?php
//$sql="Select * From tb_wb_sub Where status='1' And deleted='1' And wid='".$_GET['no']."' Order by no";
$sql="Select * From tb_wb_sub Where wid='".$_GET['wid']."' Order by no";
$rs=rsQuery($sql);
if(mysqli_num_rows($rs)>0){
	while($arr=mysqli_fetch_assoc($rs)){
		if($arr['status']==0){
			$bgcolor="#D3D3D3";
		}else{
			$bgcolor="#EBFEF2";
		}
		if($arr['deleted']==1){
			$showdeleted="ถูกแจ้งลบ";
		}else{
			$showdeleted="";
		}
		echo"<table width=90% cellpadding=\"1\" cellspacing=\"1\" border=\"0\" style=\"border-style:dashed; border-color:#CC0000; background:".$bgcolor."; border-width:1px ; padding:10px;\">";
		echo"<tr>";
		echo"<td><font id=text9-clay>SubID [".$arr['no']."]</font>&nbsp;&nbsp;&nbsp;<font color=red>".$showdeleted."</font><br><br>&nbsp;";
		echo nl2br($arr['detail'])."<br><br>&nbsp;&nbsp;&nbsp;";
		echo "<font id=text9-clay>ตอบโดย : ".$arr['postby']."&nbsp;IP : ".$arr['ip']."&nbsp;วันที่ : ".$arr['updatetime']."</font>&nbsp;&nbsp;&nbsp;<a href=main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=".$_GET['type']."&wid=".$_GET['wid']."&subno=".$arr['no']." class=list>ลบ</a>";
		echo"</tr>";
		echo"</table><br>";
		
		
	//	echo"<table width=\"70%\" cellpadding=\"1\" cellspacing=\"1\" border=\"0\" style=\"border:1px solid;margin:10px;\">";
	//	echo"<tr height=\"23\" bgcolor=\"#FCA3F3\">";
	//	echo"<td colspan=\"2\" style=\"padding-top:5px;padding-bottom:5px;\">Re: ".$row['subject']."&nbsp;&nbsp;&nbsp;&nbsp;(กดปุ่มเพื่อลบรายการนี้&nbsp;&nbsp;<input class=bt type=submit name=btdelete value=". $arr['no'] .">&nbsp;&nbsp;)</td>";
	//	echo"</tr>";
	//	echo"<tr>";
	//	echo"<td width=\"10%\" style=\"padding-top:5px;padding-bottom:5px;\">ข้อความ</td>";
	//	echo"<td width=\"90%\" align=left style=WORD-BREAK:BREAK-ALL;>".nl2br($arr['detail'])."</td>";
	//	echo"</tr>";
	//	echo"<tr>";
	//	echo"<td colspan=\"2\" style=\"padding-top:5px;padding-bottom:5px;\">โดย : ".$arr['postby']."&nbsp;IP : ".$arr['ip']."&nbsp;วันที่ : ".thaidate($arr['datepost'])." เวลา : ". MyTime($arr['updatetime'])." </td>";
	//	echo"</tr>";
	//	echo"<tr height=\"8\" bgcolor=\"#FCA3F3\">";
	//	echo"<td colspan=\"2\" style=\"padding-top:5px;padding-bottom:5px;\">&nbsp;</td>";
	//	echo"</tr>";
	//	echo"</table>";
	}
}
?>
</center>
<hr style="width:95%;">

<center>
<table width="65%" class="content-input">
<tr>
	<td width="120" valign="top" >ตอบกระทู้</td>
	<td width="380" valign="top"><textarea class="txtarea" name="txtpostadd" cols="80" rows="5"></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td style="padding-top:10px;padding-bottom:10px;"><input class="bt" type="submit" name="btaddpost" value="ตอบกระทู้"/></td>
</tr>
</table>
</center>
</form>
