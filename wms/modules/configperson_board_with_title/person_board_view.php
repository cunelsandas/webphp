<?php
	$allowed=$gloBoard_allowed_filetype;
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$file_no=($gloBoard_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=530000;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k

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

$file=array();
$size=array();
$type=array();
if(isset($_POST['btadd'])){
  // วนรับค่าจาก control
	for ($i=0;$i<=$file_no;$i++){
		$file[$i]=$_FILES['file'.$i]['name'];
		$size[$i]=$_FILES['file'.$i]['size'];
		$type[$i]=strtolower(substr($file[$i],-4));
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

	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
	$name=EscapeValue($_POST['txtname']);
	$position=$_POST['type'];
	$sid=$_POST['show'];
	$nolist=$_POST['txtnolist'];
	$history=$_POST['mytextarea'];
//$sql="UPDATE $table SET name='".$_POST['txtname']."',position='".$_POST['type']."',sid='".$_POST['show']."',status='".$ac."',nolist='".$_POST['txtnolist']."',history='".$_POST['mytextarea']."' Where no='".$_GET['no']."'";
$sql="Update $table SET name='$name',position='$position',sid='$sid',status='$ac',nolist='$nolist',history='$history' Where no='".$_GET['no']."'";

	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Where no='".$_GET['no']."'";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];

		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$tmp_date = new DateTime();
			$x = $tmp_date->format('Y-m-d_His') ;
			if($file[$i]<>""){
				$newfile[$i]=$table."_".$id."_".$x.$type[$i];
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
				}
			}

			// update table tb_trans บันทึกการแก้ไขข้อมูล
		$updatetran=UpdateTrans($table,'edit',$_SESSION['username'],'ID:'.$id);
		
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where no='".$_GET['no']."'";
$rs=rsQuery($sql);
$ruser=mysqli_fetch_assoc($rs);
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr>
	<td width="25%">ชื่อ - สกุล</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" value="<?php echo $ruser['name'];?>" /></td>
</tr>
<tr>
<td>ตำแหน่ง</td>
		<td><input type="text" name="type" id="type" value="<?php echo $ruser['position'];?>" /></td>
</tr>
<tr>
	<td>บล๊อกการแสดง ประธาน(1),รอง(2),เลขา/ที่ปรึกษา(3),เขต1(4),เขต2(5),เขต3(6)</td>
		<td><select class="txt" name="show"><option value="">- - - - กรุณาเลือกลำดับการแสดง - - - -</option>
		<?php
		$sql="Select * From tb_officer_show Order by showid";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			if($ruser['sid']==$row['showid']){
				echo"<option value=\"".$row['showid']."\" selected>".$row['shownumber']."</option>";
			}else{
				echo"<option value=\"".$row['showid']."\">".$row['shownumber']."</option>";
			}
		}
		?>
		</select>
		</td>
</tr>
<tr>
	<td valign="top">ลำดับการแสดง</td>
	<td><input type="text" class="txt1" name="txtnolist"  value="<?php echo $ruser['nolist'];?>"/></td>
</tr>
<tr>
	<td>ประวัติการทำงาน</td>
	<td>
        <textarea name="mytextarea" id="mytextarea" > <?php echo $row['history']; ?> </textarea>

	</td>
</tr>
<tr>
	<td valign="top" >
	<?php echo ShowAllowedFileUpload($gloUploadFileType);?>
	ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td>ไฟล์รูปความกว้าง 150px หรือกำหนดความกว้างให้เท่ากันทุกรูป<br>
	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
		}
	?>
	</td>
	</tr>
<tr>
	<td>&nbsp;</td>
	<td>
	<?php 
	if($ruser['status']=="0"){
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
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="btadd" value="แก้ไข" /></td>
</tr>
</table>
<?php
$strpicture="Select * from filename Where tablename='".$table."' AND masterid='".$_GET['no']."' Order by id";
$rs=rsQuery($strpicture);
while($arr = mysqli_fetch_assoc($rs)){
	$fileno=substr($arr['filename'],-5,1);
	echo "<img src=..".$foldername.$arr['filename']." width=300 height=300>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
}
?>
</form>
