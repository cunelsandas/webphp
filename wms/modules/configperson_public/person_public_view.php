<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	

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
	$name=EscapeValue($_POST['txtname']);
	$offid=EscapeValue($_POST['type']);
	$position=EscapeValue($_POST['txtposition']);
	$sid=EscapeValue($_POST['show']);
	$nolist=EscapeValue($_POST['txtnolist']);
	$history=$_POST['mytextarea'];
	$workgroup=EscapeValue($_POST['txtworkgroup']);
  // วนรับค่าจาก control
	for ($i=0;$i<=$file_no;$i++){
		$file[$i]=$_FILES['file'.$i]['name'];
		$size[$i]=$_FILES['file'.$i]['size'];
		$type[$i]=strtolower(substr($file[$i],-4));
	}
    // วนเช็คขนาดไฟล์
	for ($i=0;$i<=$file_no;$i++){
		$x=$i+1;
	if($size[$i]>$limitsize){
		echo"<p>ไฟล์ที่ ".$x." มีขนาดใหญ่เกินกว่า". $SizeInMb." Mb</p>";
		echo"<a href=\"javascript:window.history.back();\">ย้อนกลับ</a>";
		exit();
	}
	}
	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
$sql="UPDATE $table SET name='$name',offid='$offid',status='$ac',position='$position',sid='$sid',nolist='$nolist',history='$history',workgroup='$workgroup' Where no='".EscapeValue($_GET['no'])."'";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Where no='".EscapeValue($_GET['no'])."'";
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

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_public','edit',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where no='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input" >
<tr>
	<td width="25%">ชื่อ - สกุล</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" value="<?php echo $row['name'];?>" /></td>
</tr>
<tr>
	<td>ตำแหน่ง</td>
<!--	<td><input type="text" name="txtposition" class="txt1" value="--><?php //echo $row['position']?><!--"></td> -->
    <td><textarea name="txtposition" class="txt1" row="2" col="40"><?php echo $row['position']?></textarea></td>    <!-- test multiple line text -->
</tr>
<tr>
	<td>กลุ่มงาน</td>
	<td><input type="text" class="txt1" name="txtworkgroup" value="<?php echo $row['workgroup'];?>"/></td>
</tr>
<tr>
<td>หน่วยงาน</td>
		<td><select class="txt" name="type">
		<?php
		$sql="Select * From tb_publictype where status>'0' Order by listno";
		$rs=rsQuery($sql);
		while($row1=mysqli_fetch_assoc($rs)){
			if($row['offid']==$row1['id']){
				echo"<option value=\"".$row1['id']."\" selected>".$row1['name']."</option>";
			}else{
				echo"<option value=\"".$row1['id']."\">".$row1['name']."</option>";
			}
		}
		?>
		</select>
		</td>
</tr>
<tr>
	<td>บล๊อกการแสดง หัวหน้ากอง/ส่วน(1)</td>
		<td><select class="txt" name="show"><option value="">- - - - เลือกบล๊อกการแสดง - - - -</option>
		<?php
		$sql="Select * From tb_officer_show Order by showid";
		$rs=rsQuery($sql);
		while($row2=mysqli_fetch_assoc($rs)){
			if($row['sid']==$row2['showid']){
				echo"<option value=\"".$row2['showid']."\" selected>".$row2['shownumber']."</option>";
			}else{
				echo"<option value=\"".$row2['showid']."\">".$row2['shownumber']."</option>";
			}
		}
		?>
		</select>
		</td>
</tr>
<tr>
	<td>ลำดับการแสดง</td>
	<td><input type=text  class=txt1 name=txtnolist  value="<?php echo $row['nolist']?>"></td>
</tr>
<tr>
	<td>ประวัติการทำงาน</td>
	<td>
        <textarea name="mytextarea" id="mytextarea" style="width: 100%"><?php echo $row['history'];?></textarea>
	</td>
</tr>
<tr>
	<td valign="top">ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td><?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
			
}
?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
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
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="แก้ไข" /></td>
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


