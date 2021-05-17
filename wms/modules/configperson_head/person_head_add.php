<?php
	$file_no=($gloHeader_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$content="";
?>

<hr />
<!--        จบการเพิ่มไฟล์เอกสาร             --->

<?php
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
$sql="INSERT INTO $table(name,position,status,sid,nolist,history) Values('".EscapeValue($_POST['txtname'])."','".EscapeValue($_POST['type'])."','$ac','".$_POST['sid']."','".EscapeValue($_POST['nolist'])."','".$_POST['mytextarea']."')";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Order by no DESC limit 0,1";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];
		// loop insert ชื่อไฟล์และcopy ไฟล์
		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$tmp_date = new DateTime();
			$x = $tmp_date->format('Y-m-d_His') ;
			if($file[$i]<>""){
				$newfile[$i]=$table.'_'.$id."_".$x.$type[$i];
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
				}
			}

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($tablename,'add',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
	//echo $sql;
}
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-table">
<tr>
	<td width="25%">ชื่อ - สกุล</td>
	<td width="75%"><input type="text" size="70" size="60"  name="txtname" /></td>
</tr>
<!--<tr>
	<td>ลำดับการแสดง</td>
	<td><input type="text" name="txtdetail" size="16" /></td>
</tr>-->
<tr>
<td>ตำแหน่ง</td>
		<td><input type="text" size="60"name="type" id="type" /></td>
</tr>
<tr>
	<td>บล๊อกการแสดง</td>
		<td>นายก(1) รอง(2) เลขา/ที่ปรึกษา(3) ,ที่ปรึกษา(4)<br><select class="txt" name="sid"><option value="">- - - - กรุณาเลือกบล็อกการแสดง - - - -</option>
		<?php
		$sql="Select * From tb_officer_show Order by showid";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			if($ruser['showid']==$row['showid']){
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
	<td>ลำดับการแสดง</td>
		<td><!--<select class="txt" name="show"><option value="">- - - - กรุณาเลือกลำดับการแสดง - - - -</option>
		<?php
		$sql="Select * From tb_officer_show Order by showid";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			if($ruser['showid']==$row['showid']){
				echo"<option value=\"".$row['showid']."\" selected>".$row['shownumber']."</option>";
			}else{
				echo"<option value=\"".$row['showid']."\">".$row['shownumber']."</option>";
			}
		}
		?>
		</select>--><input type="text"  size="60" name="nolist"  />
		</td>
</tr>
<tr>
	<td>ประวัติการทำงาน</td>
	<td><textarea name="mytextarea" id="mytextarea" style="width: 100%"></textarea>
	</td>
</tr>
<tr>
	<td valign="top"><?php echo ShowAllowedFileUpload($gloUploadFileType);?>ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td><?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
			
}
?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="checkbox" name="active" />&nbsp;Active</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
</form>
