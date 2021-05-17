<?php
	$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	
if(isset($_POST['btadd'])){


	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
	$name=EscapeValue($_POST['txtsubject']);
	$video_id=EscapeValue($_POST['txtvideo_id']);
	$sql="INSERT INTO $table(name,video_id,active) Values('$name','$video_id','$ac')";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Order by id DESC limit 0,1";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['id'];
	
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($table,'add',$_SESSION['username'],'ID:'.$id);
	
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}

?>

<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input" >
<tr>
	<td width="25%">ชื่อ video</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtsubject" size="70"/></td>
</tr>


<tr>
	<td >video id ของYoutube (เฉพาะรหัสเท่านั้น)</td>
	<td><input type="text" size="70" class="txt" name="txtvideo_id" size="70"/></td>
</tr>
<!--<tr>
	<td >รายละเอียด2</td>
	<td><textarea name="detail2" class="txtarea"></textarea></td>
</tr>-->

<tr>
	<td>&nbsp;</td>
	<td ><input type="checkbox" name="active" />&nbsp;Active</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td ><input class="bt" type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
</form>
<table>
	<tr>
		<td>วิธีนำรหัสไฟล์วีดีโอใน Youtube </td>
	</tr>
	<tr>
		<td><img src="../images/component/embed_youtube.jpg"></td>
	</tr>
</table>

