<div class="content-box">
<?php
	$file_no=1-1;   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	
	empty($_GET['type'])?$type="":$type=$_GET['type'];
	$modid=$_GET['_modid'];
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
	$foldername="/".$gloUploadPath."/".$folder."/";
	//ลบภาพ
if(isset($_GET['del'])){
		$filenameFordel=FindRS("select * from $table where id=".$_GET['del'],"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);	
		}
		$sql="DELETE From $table Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);
		
		
}


	// เช็คขนาดไฟล์ก่อนบันทึก
	$file=array();
	$size=array();
	$type=array();
	$images=array();
	if(isset($_POST['btadd'])){
	 // วนรับค่าจาก control
	for ($i=0;$i<=$file_no;$i++){
		$file[$i]=$_FILES['file'.$i]['name'];
		$size[$i]=$_FILES['file'.$i]['size'];
		$type[$i]=strtolower(substr($file[$i],-4));
		$images[$i]=$_FILES['file'.$i]['tmp_name'];
	}
	//วนเช็ค file type
	for ($i=0;$i<=$file_no;$i++){
		$x=$i+1;
		$strCheckFile=CheckFileUpload($file[$i],$size[$i],$limitsize,$SizeInMb,$x);
		if($strCheckFile[0]=="no"){
			echo $strCheckFile[1];
			exit();
		}
	}
	
	$sql="INSERT INTO $table(detail,filename,link) Values('".EscapeValue($_POST['txtdetail'])."','','')";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Order by id DESC limit 0,1";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['id'];
		// loop insert ชื่อไฟล์และcopy ไฟล์
		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$x=$i+1;
			if($file[$i]<>""){
				$newfile[$i]=$table.'_'.$id."_".$x.$type[$i];
				//$uploadimage=resizeimage($images[$i],$newfile[$i],$foldername,$domainname,$gloFullSlide_width,'false');
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				//$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				//$uppicname=rsQuery($filename);
				$filename="Update $table SET filename='".$newfile[$i]."' Where id=".$id;
				$upfilename=rsQuery($filename);
				}
			}

		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
	}
?>
<p style="margin-left:10px;">กำหนดภาพสไลด์โชว์</p>
<p style="margin-left:20px;">ภาพที่อัพล่าสุดจะแสดงก่อนโดยจะแสดงได้ทั้งหมด <?=$gloFullSlideshow_fileno;?> ภาพ ขนาดภาพ กว้าง : <?=$gloFullSlide_width;?> , สูง : <?=$gloFullSlide_height;?></p>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr>
	<td width="25%">รายละเอียดประกอบภาพ</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtdetail" /></td>
</tr>
<tr>
	<td valign="top">ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td>
	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
		}
	?>
	</td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
<BR><BR>
<div align="center">
<?php
$strpicture="Select * from $table Order by id DESC";
$rs=rsQuery($strpicture);
	if($rs){
		while($arr = mysqli_fetch_assoc($rs)){
			//$fileno=substr($arr['filename'],-5,1);
			echo "<img src=..".$foldername.$arr['filename']." width=276 height=200><br>".$arr['detail']."<br>&nbsp;&nbsp;&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้ใช่หรือไม่?');\">[ลบ]</a><br><br><br>";
		}
	}else{
		echo ":::: ยังไม่มีรูปภาพ ::::";
	}
?>
</div>
</form>
</div>