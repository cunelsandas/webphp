<?php
	$file_no=($gloDownloadform_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloData_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";

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
	$file=array();
	$size=array();
	$type=array();
	$images=array();
if(isset($_POST['btaddnew'])){
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

	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
	if($file1<>""){
		$newid="doc-".$_GET['no'].$type1;
	}else{
		$newid="";
	}
//	$sql="INSERT INTO tb_download(subject,detail,status,datepost,offid) Values('".$_POST['txtsubject']."','".$_POST['detail']."','$ac','".$_POST['dateInput']."','".$_POST['type']."')";
//	$rs=rsQuery($sql);
//	if($rs){
//		if($file1<>""){
//			$sql="Select no From tb_download Order by no DESC limit 0,1";
//			$rss=rsQuery($sql);
//			$ar=mysqli_fetch_assoc($rss);
//			$id=$ar['no'];
//			$newid="doc-$id".$type1;
//			copy($_FILES['file1']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/docs/download/".$newid);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
//			$sql="UPDATE tb_download SET doc='$newid' Where no='$id'";
//			$rs=rsQuery($sql);
//		}
$sql="INSERT INTO $table(subject,detail,status,datepost,offid) Values('".EscapeValue($_POST['txtsubject'])."','".$_POST['mytextarea']."','".$ac."','".ChangeYear($_POST['dateInput'],"en")."','".$_POST['type']."')";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Order by no DESC limit 0,1";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];
		// loop insert ชื่อไฟล์และcopy ไฟล์
		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$x=$i+1;
			if($file[$i]<>""){
				$newfile[$i]=$table.'_'.$id."_".$x.$type[$i];
					$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น 
					if($chkimage=="image"){  
						$uploadimage=resizeimage($images[$i],$newfile[$i],$foldername,$domainname,'0','true');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($images[$i],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}
						
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
				}
			}
			
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($table,'add',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		//echo $sql2;
	}
}
?>
<form name="frmnew" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input" >
<tr>
	<td width="25%">ชื่อเรื่อง</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtsubject" /></td>
</tr>
<tr>
	<td>วันที่</td>
	<td><input type="text" name="dateInput" id="dateInput" value="<?php echo ChangeYear(date("Y-m-d"),"th");?>" /></td>
</tr>
<tr>
	<td>รายละเอียด</td>
	<td><textarea name="mytextarea" id="mytextarea" >  </textarea></td>
</tr>
<tr>
<td>หน่วยงาน</td>
		<td><select class="txt" name="type"><option value="">- - - - กรุณาเลือก - - - -</option>
		<?php
		$sql="Select * From tb_officertype where status='1' Order by id";
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
	<td valign="top">
	<?php echo ShowAllowedFileUpload($gloUploadFileType);?>
		ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td>การอัพไฟล์ jpg ระบบจะทำการลดขนาดภาพให้อัตโนมัติ ท่านสามารถนำภาพที่ถ่ายจากกล้องมาใช้ได้ทันที<br>
	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
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
	<td><input class="bt" type="submit" name="btaddnew" value="เพิ่มเอกสาร" /></td>
</tr>
</table>
</form>
