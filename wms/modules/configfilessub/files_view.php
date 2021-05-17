<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$file_no=($gloFile_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloData_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));

?>
  <link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
  <!-- datepicker thai year -->
 <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
<style type="text/css">
.ui-datepicker{
	width:200px;
	font-family:tahoma;
	font-size:11px;
	text-align:center;
}
</style>
<script>
	$(function () {
		    var d = new Date();
		     var toDay =(d.getFullYear() + 543)  + '-' + (d.getMonth() + 1) + '-' + d.getDate();

	  $("#txtdatestart").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#txtdateend").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	  $("#dateInput").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	});
</script>


<?php
//ลบภาพ
if(isset($_GET['del'])){
		$filenameFordel=FindRS("select * from filename where id=".$_GET['del'],"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);
		}
		$sql="DELETE From filename Where id='".EscapeValue($_GET['del'])."'";
		$rs=rsQuery($sql);
}

$file=array();
$size=array();
$type=array();
$images=array();
if(isset($_POST['btadd'])){
  // วนรับค่าจาก control
	for ($i=0;$i<=$file_no;$i++){
		$file[$i]=$_FILES['file'.$i]['name'];
		$size[$i]=$_FILES['file'.$i]['size'];
		$path=$_FILES['file'.$i]['name'];
		$type[$i]=pathinfo($path, PATHINFO_EXTENSION);
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

	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
$sql="UPDATE $table SET subject='".EscapeValue($_POST['txtsubject'])."',detail='".$_POST['mytextarea']."',filetypeid='".$_POST['type']."',datepost='".ChangeYear($_POST['dateInput'],"en")."',status='$ac' Where no='".EscapeValue($_GET['no'])."'";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Where no='".EscapeValue($_GET['no'])."'";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];

		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$x=$i+1;
			if($file[$i]<>""){
				$newfile[$i]=$table."_".$id."_".$x.".".$type[$i];
					$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น
					if($chkimage=="image"){
						$uploadimage=resizeimage($images[$i],$newfile[$i],$foldername,$domainname,'0','true');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ

					}
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
				}
			}

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_file','edit',$_SESSION['username'],'ID:'.EscapeValue($_GET['no']));
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		//echo $sql;
	}
}
$sql="Select * From $table Where no='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
?>
<form name="frmnew" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input" >
<tr>
	<td width="25%">ชื่อเรื่อง</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtsubject" value="<?php echo $row['subject'];?>"/></td>
</tr>
<tr>
	<td>วันที่</td>
	<td><input type="text" name="dateInput" id="dateInput" value="<?php echo ChangeYear($row['datepost'],"th");?>" /></td>
</tr>
<tr>
	<td>รายละเอียด</td>
	<td>
        <textarea name="mytextarea" id="mytextarea" > <?php echo $row['detail']; ?> </textarea>
       </td>
</tr>
<tr>
<td>หน่วยงาน</td>
		<td><select class="txt" name="type"><option value="">- - - - กรุณาเลือก - - - -</option>
		<?php
		$sql="Select * From tb_submenu Order by id";
		$rs=rsQuery($sql);
		while($row1=mysqli_fetch_assoc($rs)){
			if($row1['id']==$row['filetypeid']){
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
	<td valign="top">
	<?php echo ShowAllowedFileUpload($gloUploadFileType);?>
	ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td><?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size="80" /><br />';

}
?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
	<?php
	if($arr['status']=="0"){
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
	<td><input class="bt" type="submit" name="btadd" value="แก้ไขข้อมูล" /></td>
</tr>
</table>
<br><br>
<?php
$strpicture="Select * from filename Where tablename='".$table."' AND masterid='".$_GET['no']."' Order by id";
$rs=rsQuery($strpicture);
while($arr = mysqli_fetch_assoc($rs)){
	$fileno=substr($arr['filename'],-5,1);
	$filetype=substr($arr['filename'],-3);
	if($filetype=="jpg" or $filetype=="png" or $filetype=="gif" or $filetype=="bmp"){
		echo "<img src=..".$foldername.$arr['filename']." width=300 height=300>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
	}else{
		echo "<a href=..".$foldername.$arr['filename']." target='_blank'><img src='../images/icon_pdf.gif' ></a>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
	}

	//echo "ไฟล์ที่ ".$fileno."&nbsp;<a href=..".$foldername.$arr['filename']." target=_blank>".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
}
?>
</form>

