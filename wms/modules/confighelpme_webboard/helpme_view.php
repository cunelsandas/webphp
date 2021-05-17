<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";

	$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
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
$timenow=date("Y-m-d");
if(isset($_POST['btmail'])){ //ส่งเมล์
$MailTo = $_REQUEST['email'] ;
$MailFrom = "info@".$domainname;//$_POST['MailFrom'] ;
$MailSubject = "แจ้งผลการดำเนินการแก้ไขเรื่องร้องเรียน";//$_POST['MailSubject'] ;
$MailMessage = $_REQUEST['mytextarea'] ;

$Headers = "MIME-Version: 1.0\r\n" ;
$Headers .= "Content-type: text/html; charset=UTF-8\r\n" ;
                          // ส่งข้อความเป็นภาษาไทย ใช้ "windows-874"
$Headers .= "From: ".$MailFrom." <".$MailFrom.">\r\n" ;
$Headers .= "Reply-to: ".$MailFrom." <".$MailFrom.">\r\n" ;
$Headers .= "X-Priority: 3\r\n" ;
$Headers .= "X-Mailer: PHP mailer\r\n" ;

        if(mail($MailTo, $MailSubject , $MailMessage, $Headers, $MailFrom))
        {
        $msg= "Send Mail True" ;  //ส่งเรียบร้อย
        }else{
        $msg= "Send Mail False" ; //ไม่สามารถส่งเมล์ได้
        }

	echo"<script>alert('$msg');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
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
	$strupdate="Update $table SET process='".$_POST['cboprocess']."',result='".$_POST['mytextarea']."' Where id='".EscapeValue($_GET['no'])."'";
	$rsupdate=rsQuery($strupdate);
	if($rsupdate){
	$strsql="select id from $tablename Order by id DESC Limit 0,1";
			$rs1=rsQuery($strsql);
			$data=mysqli_fetch_assoc($rs1);
			$helpid=$data['id'];

		$id=$helpid;
		// loop insert ชื่อไฟล์และcopy ไฟล์
		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$x=$i+1;
			if($file[$i]<>""){
				$newfile[$i]='af_'.$tablename.'_'.$id."_".$x.$type[$i];

				$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น
					if($chkimage=="image"){
						$uploadimage=resizeimage($images[$i],$newfile[$i],$foldername,$domainname,'0','true');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($images[$i],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}

				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
				}
			}


	echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}

$timedate=date("Y-m-d");
if(isset($_POST['btaddpost'])){
	$dt=date("Y-m-d H:i:s");
	$sql="INSERT INTO tb_helpme_sub(wid,detail,postby,datepost,ip,status,deleted,createdate) VALUES('".$_GET['no']."','".EscapeValue($_POST['txtpostadd'])."','".$_SESSION['name']."','$timedate','".$_SERVER['REMOTE_ADDR']."','1','0','$dt')";
	$rs=rsQuery($sql);
	if($rs){
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_helpme_sub','add',$_SESSION['username'],'ID:'.$_POST['txtpostadd']);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."';</script>";
	}
}

	if(isset($_GET['subno'])){
	$subno=EscapeValue($_GET['subno']);
	$strDel="Update tb_helpme_sub SET status='0' Where no='".$subno."'";
	$rsdel=rsQuery($strDel);
	if($rsdel){
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_helpme_sub','delete',$_SESSION['username'],'ID:'.$_GET['subno']);
		echo"<script>alert('ลบข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."';</script>";
	}
}


$sql="Select * From $table Where id='".EscapeValue($_GET['no'])."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
?>
<table width="100%" class="content-detail">
<tr height="25"  >
	<td colspan="2">เลขที่คำร้อง : <?php echo $row['id'];?></td>
</tr>
<tr height="25"   >
	<td colspan="2">วันที่แจ้ง : <?php echo DateTimeThai($row['datepost']);?>&nbsp;&nbsp; IP Address : <?php echo $row['ip'];?>
	<BR><BR>เรื่อง : <?php echo $row['subject'];?>
	<br><br>ผู้แจ้ง : <?php echo $row['name'];?>
	<br><br>ที่อยู่ : <?php echo $row['address'];?>
	<br><br> อีเมล์/โทรศัพท์ : <?php echo $row['email'];?>
	<br><br>รายละเอียด :<br>
	<?php echo nl2br($row['detail']);?>
	</td>
</tr>


</table>
<br>
<hr style="width:90%;">
<br>
<form name="frmaddpost" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr>
	<td width="140">ขั้นตอน</td><input type=hidden name="email" value="<?php echo $row['email'];?>">
	<td width="360"><select class="txt" name="cboprocess"><option value="">- - - - กรุณาเลือก - - - -</option>
		<?php
		$sql="Select * From tb_helpme_process Order by id";
		$rs=rsQuery($sql);
		while($rowprocess=mysqli_fetch_assoc($rs)){
			if($row['process']==$rowprocess['id']){
				echo"<option value=\"".$rowprocess['id']."\" selected>".$rowprocess['name']."</option>";
			}else{
				echo"<option value=\"".$rowprocess['id']."\">".$rowprocess['name']."</option>";
			}
		}
		?>
	</td>
<tr>
	<td width="140" valign="top">ผลการดำเนินการ<br>**อย่าใส่ชื่อหรือรายละเอียดที่จะระบุตัวผู้ร้องได้</td>
	<td valign="top" bgcolor="#FFFFFF">				
	<textarea name="mytextarea" id="mytextarea" > <?php echo $row['result']; ?> </textarea>
</td>
</tr>
<tr>
	<td valign="top" >
		<?php echo ShowAllowedFileUpload($gloUploadFileType);?>
		ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td>การอัพไฟล์ jpg ระบบจะทำการลดขนาดภาพให้อัตโนมัติ ท่านสามารถนำภาพที่ถ่ายจากกล้องมาใช้ได้ทันที<br>
	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=6;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
		}
	?>
	</td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="บันทึก"/>&nbsp;&nbsp;<a href="report/helpme/html_form01.php?id=<?php echo $row['id'];?>&tb=<?php echo $table;?>&fd=<?php echo $folder;?>" target="_Blank">พิมพ์คำร้อง</a>&nbsp;&nbsp;<!--<input class="bt" type="submit" name="btmail" value="ส่งเมล์"/>--></td>
</tr>

</table>
</form>
<?php
$strpicture="Select * from filename Where tablename='".$table."' AND masterid='".$_GET['no']."' Order by id";
$rs=rsQuery($strpicture);
while($arr = mysqli_fetch_assoc($rs)){
	$fileno=substr($arr['filename'],-5,1);
	$filetype=substr($arr['filename'],-3);
	if($filetype=="jpg" or $filetype=="png" or $filetype=="gif" or $filetype=="bmp"){
		echo "<img src=..".$foldername.$arr['filename']." width=300 height=300>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<br><br>";
	}else{
		echo "<a href=..".$foldername.$arr['filename']." target='_blank'><img src='../images/icon_pdf.gif' ></a>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<br><br>";
	}
}
?>
<br><hr>
<form name="frmaddpost" method="POST" action="">
<?php
//$sql="Select * From tb_helpme_sub Where status='1' And deleted='1' And wid='".$_GET['no']."' Order by no";
$sql="Select * From tb_helpme_sub Where wid='".$_GET['no']."' Order by no";
$rs=rsQuery($sql);
if(mysqli_num_rows($rs)>0){
	while($arr=mysqli_fetch_assoc($rs)){
		if($arr['status']==0){
			$bgcolor="#D3D3D3";
		}else{
			$bgcolor="#EBFEF2";
		}
		if($arr['deleted']==1){
			$showdeleted="ถูกแจ้งลบ";
		}else{
			$showdeleted="";
		}
		echo"<table width=90% cellpadding=\"1\" cellspacing=\"1\" border=\"0\" style=\"border-style:dashed; border-color:#CC0000; background:".$bgcolor."; border-width:1px ; padding:10px;\">";
		echo"<tr>";
		echo"<td><font id=text9-clay>SubID [".$arr['no']."]</font>&nbsp;&nbsp;&nbsp;<font color=red>".$showdeleted."</font><br><br>&nbsp;";
		echo nl2br($arr['detail'])."<br><br>&nbsp;&nbsp;&nbsp;";
		echo "<font id=text9-clay>ตอบโดย : ".$arr['postby']."&nbsp;IP : ".$arr['ip']."&nbsp;วันที่ : ".$arr['updatetime']."</font>&nbsp;&nbsp;&nbsp;<a href=main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=".$_GET['type']."&no=".$_GET['no']."&subno=".$arr['no']." class=list>ลบ</a>";
		echo"</tr>";
		echo"</table><br>";

	}
}
?>
</center>
<hr style="width:95%;">

<center>
<table width="65%" class="content-input">
<tr>
	<td width="120" valign="top" >ตอบกระทู้</td>
	<td width="380" valign="top"><textarea class="txtarea" name="txtpostadd" cols="80" rows="5"></textarea></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td style="padding-top:10px;padding-bottom:10px;"><input class="bt" type="submit" name="btaddpost" value="ตอบกระทู้"/></td>
</tr>
</table>
</center>
</form>
