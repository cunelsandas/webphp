<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	
?>

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
if(isset($_POST['genlink'])){
	if(is_numeric($_POST['cbogenlink'])){
		$encode=encode64('files')."&type=".encode64($_POST['cbogenlink']);
	}else{
		$encode=encode64($_POST['cbogenlink']);
		
	}
	$genlink="index.php?_mod=".$encode;
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
$sql="UPDATE $table SET name='".$_POST['txtname']."',position='".$_POST['type']."',status='$ac',listno='".$_POST['txtlistno']."',alt='".$_POST['txtalt']."',link_to='".$_POST['txtlink_to']."' Where id='".$_POST['txtid']."'";

	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Where id='".$_GET['no']."'";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['id'];

		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$x=$i+1;
			if($file[$i]<>""){
				$newfile[$i]=$table."_".$id."_".$x.$type[$i];
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
				}
			}

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$table','edit',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where id='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table class="content-input" >
<tr>
<tr>
	<td colspan="2">ใส่ # ไว้หน้าชื่อBanner เพื่อไม่เปิดหน้าใหม่เวลากด Link ( target='_blank' )</td>
</tr>
	<td width="25%">ชื่อ Banner</td>
	<td width="75%"><input type="text" size="150" class="txt" name="txtname" value="<?php echo $row['name'];?>" /></td>
</tr>
<tr><td>id</td><td><input type="text" name="txtid" value="<?php echo $row['id'];?>"></td></tr>
<tr>
<td>ประเภท</td>
		<td><select class="txt" name="type">
		<?php
		$sql="Select * From tb_banner_position Order by id";
		$rs=rsQuery($sql);
		while($row1=mysqli_fetch_assoc($rs)){
			if($row['position']==$row1['id']){
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
	<td>คำอธิบาย (alt)</td>
	<td><input type=text  class="txt1" name="txtalt" size="150" value="<?php echo $row['alt'];?>"></td>
</tr>
<tr>
	<td>link to</td>
	<td>
		<input type="text" class="txt1" name="txtlink_to" size="150" id="txtlink_to" value="<?php echo $row['link_to'];?>"><br>
	</td>
</tr>
<tr>
	<td> </td>
	<td bgcolor="#fbfda8">สร้าง link ภายในเว็บ
		<select name="cbogenlink"><option value="">เลือกโมดูลที่ต้องการสร้างแบนเนอร์</option>
			<?php
				$str="select * from tb_mod Where typeid<='3' Order by modname";
				$rsMod=rsQuery($str);
				if($rsMod){
					while($dMod=mysqli_fetch_assoc($rsMod)){
						echo "<option value='".$dMod['modtype']."'>".$dMod['modname']."[ ".$dMod['modtype']." ]</option>";
					}
				}

				$str="select * from tb_filestype Where listno='0' and name<>''";
				$rsMod=rsQuery($str);
				if($rsMod){
					while($dMod=mysqli_fetch_assoc($rsMod)){
						echo "<option value='".$dMod['fid']."'>".$dMod['name']."[ ".$dMod['fid']." ]</option>";
					}
				}
			?>
		</select>&nbsp;
		<input type="submit" name="genlink" value="สร้าง link">&nbsp;
		<input type="text" id="txtgenlink" name="txtgenlink" placeholder="กดปุ่นสร้าง link และ copy ข้อมูลที่ได้ไปไว้บรรทัดบน" size="40" value="<?php echo $genlink;?>">	
	</td>
</tr>
<tr>
	<td>ลำดับการแสดง</td>
	<td><input type="text"  class="txt1" name="txtlistno"  value="<?php echo $row['listno'];?>"></td>
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


