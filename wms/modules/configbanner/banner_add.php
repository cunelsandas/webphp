<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script> 
<?php
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";


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
	}//institute=ลำดับการแสดง

$sql="INSERT INTO $table(name,position,status,alt,link_to,listno) Values('".$_POST['txtname']."','".$_POST['type']."','$ac','".$_POST['txtalt']."','".$_POST['txtlink_to']. "','".$_POST['txtlistno']."')";
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
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
				}
			}

	
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$table','add',$_SESSION['username'],'ID:'.$id.'  '.$_POST['txtname']);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
	//echo $sql;
}
$genlink="";
if(isset($_POST['genlink'])){
	if(is_numeric($_POST['cbogenlink'])){
		$encode=encode64('files')."&type=".encode64($_POST['cbogenlink']);
	}else{
		$encode=encode64($_POST['cbogenlink']);
		
	}
	$genlink="index.php?_mod=".$encode;
}
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table class="content-input" >
<tr>
	<td colspan="2">ใส่ # ไว้หน้าชื่อBanner เพื่อไม่เปิดหน้าใหม่เวลากด Link (  target='_blank' )</td>
</tr>
<tr>
	<td width="25%">ชื่อ Banner</td>
	<td width="75%"><input type="text" size="170" class="txt" name="txtname" /></td>
</tr>


<tr>
<td>ประเภท</td>
		<td><select class="txt" name="type"><option value="">- - - - กรุณาเลือก - - - -</option>
		<?php
		$sql="Select * From tb_banner_position Order by id";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			
				echo"<option value=\"".$row['id']."\">".$row['name']."</option>";
			
		}
		?>
		</select>
		</td>
</tr>

<tr>
	<td>คำอธิบาย (alt)</td>
	<td><input type=text  class="txt1" name="txtalt" size="150"></td>
</tr>
<tr>
	<td>link to</td>
	<td>
		<input type="text" class="txt1" name="txtlink_to" size="150" id="txtlink_to"><br>
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
	<td><input type="text"  class="txt1" name="txtlistno"  value="<?php echo $row['nolist']?>"></td>
</tr>
<tr>
	<td valign="top">ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td><?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.'  /><br />';
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
