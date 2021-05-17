<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
?>


<center>
<?php
//ลบภาพ
if(isset($_GET['del'])){
		$filenameFordel=FindRS("select * from filename where id=".$_GET['del'],"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);	
		}
		$sql="DELETE From filename Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);
		
		
}


if(isset($_POST['btadd'])){
 

	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
	$name=EscapeValue($_POST['txtsubject']);
	$video_id=EscapeValue($_POST['txtvideo_id']);
	$sql="UPDATE $table SET name='$name',video_id='$video_id',active='$ac' Where id='".EscapeValue($_GET['id'])."'";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Where id='".EscapeValue($_GET['id'])."'";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['id'];

		

			// update table tb_trans บันทึกการแก้ไขข้อมูล
		$updatetran=UpdateTrans($table,'edit',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where id='".EscapeValue($_GET['id'])."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
$video_id=$row['video_id'];
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr bgcolor="#8BCFFF">
	<td width="20%" style="padding-top:10px;padding-bottom:10px;">ชื่อวีดีโอ</td>
	<td width="80%"><input type="text" class="txt" name="txtsubject" value="<?php echo $row['name'];?>" size="70"/></td>
</tr>

<tr bgcolor="#8BCFFF">
	<td style="padding-top:10px;padding-bottom:10px;">video id (รหัสไฟล์วีดีโอของ Youtube)</td>
	<td><input type="text" class="txt" name="txtvideo_id" value="<?php echo $row['video_id'];?>" size="70"/>
	</td>
</tr>

<tr bgcolor="#8BCFFF">
	<td>&nbsp;</td>
	<td style="padding-top:10px;padding-bottom:10px;">
	<?php 
	if($row['status']=="0"){
		?>
		<input type="checkbox" name="active" />&nbsp;Active
	<?php
	}else{
		?>
		<input type="checkbox" name="active" checked />&nbsp;Active
	<?php
	}
	?>
	</td>
</tr>
<tr bgcolor="#8BCFFF">
	<td>&nbsp;</td>
	<td style="padding-top:10px;padding-bottom:10px;"><input class="bt" type="submit" name="btadd" value="แก้ไข" /></td>
</tr>
</table>

</form>
<?php
	echo "หากท่านไม่เห็นวีดีโอจาก youtube แสดงว่าท่านใส่รหัส video_id ผิด กรุณาตรวจสอบรหัส $video_id นี้ใหม่ <br>";
	echo "<iframe width=\"$glo_youtube_width\" height=\"$glo_youtube_height\" src=\"https://www.youtube.com/embed/$video_id\" frameborder=\"0\" allowfullscreen></iframe>";
?>

<table>
	<tr>
		<td>วิธีนำรหัสไฟล์วีดีโอใน Youtube </td>
	</tr>
	<tr>
		<td><img src="../images/component/embed_youtube.jpg"></td>
	</tr>
</table>
</center>

