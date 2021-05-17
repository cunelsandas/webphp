<?php
	$file_no=1;   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloData_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$spaw=new SpawEditor("spaw1",$content);
?>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css">
<style type="text/css">
.ui-datepicker{
	width:200px;
	font-family:tahoma;
	font-size:11px;
	text-align:center;
}
</style>
<script type="text/javascript" src="js/jscolor.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<center>
<?php
$file=array();
$size=array();
$type=array();
if(isset($_POST['btadd'])){
  // วนรับค่าจาก control
//	for ($i=0;$i<=$file_no;$i++){
		$file[0]=$_FILES['file0']['name'];
		$size[0]=$_FILES['file0']['size'];
		$type[0]=strtolower(substr($file[0],-4));

		$file[1]=$_FILES['file1']['name'];
		$size[1]=$_FILES['file1']['size'];
		$type[1]=strtolower(substr($file[1],-4));
//	}
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
			
	$sql="INSERT INTO $table(subject,detail1,weblink,linkname,datepost,ip,status,picture_main,picture_bg,bg_color) Values('".$_POST['txtsubject']."','".$_POST['spaw1']."','".$_POST['weblink']."','".$_POST['linkname']."','".$_POST['dateInput']."','".$_SERVER['REMOTE_ADDR']."','$ac','','','".$_POST['bg_color']."')";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Order by no DESC limit 0,1";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_array($rss);
		$id=$r['no'];
		// loop insert ชื่อไฟล์และcopy ไฟล์
			$newfile=array();
			$newfile[0]=$table.'_'.$id."_main".$type[0];
			$newfile[1]=$table.'_'.$id."_bg".$type[1];
	//	for ($i=0;$i<=$file_no;$i++){
	//		$x=$i+1;
	//		if($file[$i]<>""){
	//			$newfile[$i]=$table.'_'.$id."_".$x.$type[$i];
			if(!empty($_FILES['file0']['name'])){
				copy($_FILES['file0']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[0]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
			
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[0]."')";
				$uppicname=rsQuery($filename);
				$updatemain="update tb_firstpage SET picture_main='".$newfile[0]."' Where no=".$id;
				$up=rsQuery($updatemain);
			}
			if(!empty($_FILES['file1']['name'])){
				copy($_FILES['file1']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[1]);
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[1]."')";
				$uppicname=rsQuery($filename);
				$updatemain="update tb_firstpage SET picture_bg='".$newfile[1]."' Where no=".$id;
				$up=rsQuery($updatemain);
			}
	//			}
	//		}
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($table,'add',$_SESSION['username'],'ID:'.$id);
		
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}

?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr>
	<td width="20%" >ชื่อเรื่อง</td>
	<td width="400"><input type="text" name="txtsubject" size="100"/></td>
</tr>
<tr>
	<td >วันที่</td>
	<td><input type="text" name="dateInput" id="dateInput" value="<?php echo date("Y-m-d");?>" /></td>
</tr>

<tr>
	<td >รายละเอียด</td>
	<td><?php $spaw->show(); ?><!--<textarea name="detail1" class="txtarea"></textarea>--></td>
</tr>
<tr>
	<td >Web Link</td>
	<td><input type="text" name="weblink"></td>
</tr>
<tr>
	<td >ชื่อ Link</td>
	<td><input type="text" name="linkname"></td>
</tr>
<tr>
	<td >สีพื้นหลัง (Background Color)</td>
	<td><input type="text" name="bg_color" class="color {required:false}"></td>
</tr>
<tr>
	<td valign="top" >ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?>Mb</td>
	<td>
	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
	//	for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ภาพ&nbsp;&nbsp;&nbsp;<input type='file' name='file0' size='50' /><br />";
			echo "ไฟล์พื้นหลัง(background)&nbsp;&nbsp;&nbsp;<input type='file' name='file1' size='50' /><br />";
	//	}
	?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td ><input type="checkbox" name="active" />&nbsp;Active</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td ><input type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
</form>
</center>