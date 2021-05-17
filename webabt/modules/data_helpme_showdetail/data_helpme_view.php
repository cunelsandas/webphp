<?php
$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
$foldername=$gloUploadPath."/".$folder."/";
$v_no=EscapeValue(decode64($_GET['no']));
$sql="Select * From $tablename Where id='".$v_no."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
$processname=FindRS("select * from tb_helpme_process where id=".$row['process'],"name");
$statusdetail=$row['statusdetail'];
?>

<table width="90%" cellpadding="1" cellspacing="1" class="content-input">
<tr height="25">
	<td colspan="2" align=left>เลขคำร้อง : <?php echo $row['id'];?></td>
</tr>
<tr class=tbl3 height="25" >
	<td colspan="2" align=left class="helpme">วันที่แจ้ง : <?php echo DateTimeThai($row['datepost']);?>
	<br><br>เรื่อง : &nbsp;<?php echo $row['subject'];?>
	<!--<br><br>ชื่อผู้แจ้ง : <?php echo $row['name'];?><br>&nbsp;-->
	
	</td>
</tr>

<tr class=tbl3 height="25" >
	<td colspan="2" align=left>รายละเอียด : &nbsp;<?php echo $row['detail'];?></td>
</tr>





<tr>
	<td colspan=2>&nbsp;&nbsp;</td>
</tr>
<tr>
	<td colspan=2>สถานะ : <?php echo $processname;?></td>

	
</tr>
<tr>
	<td colspan=2>ผลการดำเนินการ</td>
</tr>
<tr>
	<td colspan=2 id="helpme-result">&nbsp;<?php echo $row['result'];?></td>
</tr>

</table>
</div>