<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>upload images</title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
 </head>
<?php
	$modid=$_GET['_modid'];
	$modname=FindRS("select modname from tb_mod where modid=$modid","modname");

	echo "<p >$modname</p>";
	$file_no=0;   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$foldername="/images/";

if(isset($_GET['del'])){
		$filenameFordel=$_GET['del'];
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>""){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);	
		}
		
}


	$file=array();
	$size=array();
	$type=array();
if(isset($_POST['btadd'])){
   // วนรับค่าจาก control
	for ($i=0;$i<=$file_no;$i++){
		$file[$i]=$_FILES['file'.$i]['name'];
		$size[$i]=$_FILES['file'.$i]['size'];
		$type[$i]=strtolower(substr($file[$i],-4));
	//	$images[$i]=$_FILES['file'.$i]['tmp_name'];
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
		for ($i=0;$i<=$file_no;$i++){
			$x=$i+1;
			if($file[$i]<>""){
				$newfile[$i]=$file[$i];
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				// update table tb_trans บันทึกการเพิ่มข้อมูล
				$updatetran=UpdateTrans('upload image',$foldername,$_SESSION['username'],$newfile[$i]);
				}
			}
			

		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
?>
 <body>
 <form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" cellpadding="2" cellspacing="2" border="0" >
	<tr>
		<td>อัพโหลดภาพส่วนประกอบต่างๆของเว็บไปที่ <?php echo $foldername;?> ชื่อไฟล์ต้องเหมือนกับไฟล์เดิมที่ต้องการแทนที่และเป็นตัวพิมพ์เล็กทั้งหมด ตรวจสอบให้ถูกต้องก่อนการอัพโหลด</td>
	</tr>
	<tr>
		<td valign="top" >
			<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
				for ($i=0; $i<=$file_no;$i++){
					echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
				}
			?>
		</td>
	</tr>
	<tr>
		<td><input class="bt" type="submit" name="btadd" value="เพิ่ม" /></td>
	</tr>
</table>
</form>
<div style="border-style:solid;border-color:#990000;padding:10px;">
  <?php
	$dir = "../images/";

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
		if(is_file($dir.$file)){
			 echo "<img src=\"".$dir.$file."\" style=\"max-width:600px;padding:2px;box-shadow:5px 5px 5px #626262;\"><br>filename:<font color=\"#990000\">" . $file . "</font>&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$file."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?ไม่สามารถกู้กลับได้');\">[ลบ]</a><br><br>";
		}
	}
    closedir($dh);
  }
}

  ?>
  </div>
 </body>
</html>
