<?php

	$CheckBrowser=getBrowser();
	$device=$CheckBrowser['device'];
	if($device=="Mobile"){
		$classmobile= "formobile";
	}else{
		$classmobile="content-input";
	}
  ?>
<script>
		function checkdetail(){
			if(document.getElementById('txtsubject').value=="" || document.getElementById('txtdetail').value=="" || document.getElementById('txtname').value==""){
				alert("กรุณากรอกข้อมูลที่มีเครื่องหมาย * ให้ครบทุกช่อง!!!");
				return false;
			} else {
                alert("คำร้องของท่านถูกบันทึกแล้วค่ะ");
                }


}
</script>

<?php
$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");


$foldername="/".$gloUploadPath."/".$folder."/";

if(isset($_POST['btwb'])){
	$chkver=$_SESSION['vervalue'];
	if($chkver<>$_POST['txtver']){
		echo"คุณกรอกรหัสยืนยันไม่ตรงกับภาพ กรุณาตรวจสอบ";
	}else{
		$file=array();
$size=array();
$type=array();
$images=array();

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
		$docno=0;
		$subject=EscapeValue($_POST['txtsubject']);
		$detail=EscapeValue($_POST['txtdetail']);
		$name=EscapeValue($_POST['txtname']);
		$address=EscapeValue($_POST['txtaddress']);
		$email=EscapeValue($_POST['txtemail']);
		$typeid=$_POST['cbotype'];
		$status="1";
		$process="1";
		$result="";
		$dt=date("Y-m-d H:i:s");
		$strField="SHOW COLUMNS FROM $tablename Where Field='docno'";
		$rsField=rsQuery($strField);
		$row=mysqli_num_rows($rsField);

		if($row>0){
			$fdocno=",docno";
			$vdocno=",'".$docno."'";
		}else{
			$fdocno="";
			$vdocno="";
		}
		$strField="SHOW COLUMNS FROM $tablename Where Field='type'";
		$rsField=rsQuery($strField);
		$row2=mysqli_num_rows($rsField);
		if($row2>0){
			$ftype=",type";
			$vtype=",'".$typeid."'";
		}else{
			$ftype="";
			$vtype="";
		}

		$sql="INSERT INTO $tablename(subject,detail,name,datepost,ip,status,address,email,process,result".$fdocno.$ftype.") Values('$subject','$detail','$name','$dt','".$_SERVER['REMOTE_ADDR']."','$status','$address','$email','$process','$result'".$vdocno.$vtype.")";
		$rs=rsQuery($sql);
		if($rs){
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
				$newfile[$i]=$tablename.'_'.$id."_".$x.$type[$i];

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



			// Send Email
//				$sql_email="select * from tb_email";
//				$rs_email=rsQuery($sql_email);
//				if($rs_email and mysqli_num_rows($rs_email)>0){
//
//					while($data_email=mysqli_fetch_assoc($rs_email)){
//							$receiver[] = $data_email['email'];
//					}
//					$MailTo = implode(",",$receiver);
//				}else{
//							$MailTo="info@".$domainname;
//				}
//
//				//$MailTo = $_REQUEST['email'] ;
//
//
//				$fm = "noreply@itglobal.co.th"; // *** ต้องใช้อีเมล์ @yourdomain.com เท่านั้น  ***
//				$to = "info@".$domainname;//test sasikan@itglobal.co.th //sub
//				$custemail = $MailTo; // อีเมล์ของผู้ติดต่อที่กรอกผ่านแบบฟอร์ม
//
//				$subj = "New แจ้งเรื่องร้องเรียน เลขที่ $helpid";
//
//				// -------------------------------------------------------------------
//
//				$message .= "<html><head><title> $subject </title> </head> <body>";
//
//
//				$message .="เรื่อง ". $subject."<br>".$detail."<br><br><a href=http://www.$domainname/index.php?_mod=".$_GET['_mod']."&type=".encode64('view')."&no=".encode64($helpid).">ไปที่หน้าเว็บ</a></body></html>";
//
//
//				// -------------------------------------------------------------------
//
//				$mesg = $message;
//
//				$mail = new PHPMailer();
//				$mail->CharSet = "utf-8";
//
//				$mail->SMTPDebug = 0;
//				$mail->IsSMTP();
//
//				$mail->Mailer = "smtp";
//				$mail->SMTPAutoTLS = false; //false//true
//				//$mail->SMTPSecure = 'ssl'; // บรรทัดนี้ ให้ Uncomment ไว้ เพราะ Mail Server ของโฮสต์ ไม่รองรับ SSL.
//				$mail->Port = "25"; // หมายเลข Port สำหรับส่งอีเมล์ 25 // 465
//
//				$mail->Host = "mail.itglobal.co.th"; //ใส่ SMTP Mail Server ของท่าน
//				$mail->Username = "admin@itglobal.co.th"; //ใส่ Email Username ของท่าน (ที่ Add ไว้แล้วใน Plesk Control Panel)
//				$mail->Password = "12345678a"; //ใส่ Password ของอีเมล์ (รหัสผ่านของอีเมล์ที่ท่านตั้งไว้)456852aB
//				 //-------------------------------------------------------------------
//
//				//$mail->From = $fm;
//				$mail->SetFrom($fm);
//				$mail->AddAddress($to);
//				$mail->AddReplyTo($custemail);
//
//				$mail->Subject = $subj;
//				$mail->MsgHTML($mesg);
//				$mail->WordWrap = 50;
//				//

				//if(!$mail->Send()) {
				//echo "<script>alert('Send Mail ERROR')</script>";
				//echo "<script>console.log('".$mail->ErrorInfo."')</script>";
				//$msg= "Send Mail False";
				//exit;
				//}
/*
				$MailFrom = "noreply@".$domainname;//$_POST['MailFrom'] ;
				$subject1 = "New แจ้งเรื่องร้องเรียน เลขที่ $helpid";
				$MailSubject = '=?UTF-8?B?'.base64_encode($subject1).'?=' ;//$_POST['MailSubject'] ;
				//$MailMessage = $_REQUEST['spaw1'] ;
				$MailMessage = "<html><head><title> $subject </title> </head> <body>";


				$MailMessage .="เรื่อง ". $subject."<br>".$detail."<br><br><a href=http://www.$domainname/index.php?_mod=".$_GET['_mod']."&type=".encode64('view')."&no=".encode64($helpid).">ไปที่หน้าเว็บ</a></body></html>";
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n" ;
				$headers .= "Reply-To: The Sender <".$MailFrom.">\r\n";
				$headers .= "Return-Path: The Sender <".$MailFrom.">\r\n";
				$headers .= "From: ".$domainname." <".$MailFrom.">\r\n";
				 $headers .= "Organization: ".$domainname."\r\n";
				$headers .= "X-Priority: 3\r\n";
				$headers .= "X-Mailer: PHP/". phpversion() ;
				 if(mail($MailTo, $MailSubject , $MailMessage, $headers)) {
					 $msg= "Send Mail Completed" ;  //ส่งเรียบร้อย
				}else{
					$msg= "Send Mail False" ; //ไม่สามารถส่งเมล์ได้
				}*/
		//End Send Email
			echo"<script>alert('คำร้องของคุณเลขที่ $helpid ข้อมูลถูกบันทึกแล้วขอบคุณค่ะ $msg');window.location.href='index.php?_mod=".$_GET['_mod']."';</script>";

		}
	}
}
?>
<style>
    body {
        color: black;
    }
</style>
<div class="<?php echo $classmobile;?>" style="width:90%;">
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<div align="left">
<label>วันที่ :
<?php echo DateThai(date("Y-m-d"));?><input type="hidden" name="dateInput" id="dateInput" value="<?php echo date("c");?>" />
</label>
<br>
    <label>ชื่อ <font color="red">*</font>:</label><br>
	<input type="text" name="txtname" id="txtname" style="width:90%;">
<br>
<label>ที่อยู่ :</label><br>
	<input type="text" name="txtaddress" id="txtaddress" placeholder="บ้านเลขที่ ตำบล/แขวง อำเภอ/เขต จังหวัด" style="width:90%;">
<br>
<label>อีเมล์/เบอร์โทรศัพท์</label><br>
<input type="text" name="txtemail" id="txtemail">
<br>
<label>ประเภท :</label><br>
<select name='cbotype'>
	<option value='0'>ไม่ระบุประเภท</option>
	<?php
		$strtype="select * from tb_helpme_type";
		$rstype=rsQuery($strtype);
		if(mysqli_num_rows($rstype)>0){
			while($datatype=mysqli_fetch_assoc($rstype)){
				echo "<option value='".$datatype['id']."'>".$datatype['name']."</option>";
			}
		}
	?>
</select>
<br>
    <label>เรื่อง <font color="red">*</font>:</label><br>
<input type="text" name="txtsubject" id="txtsubject" style="width:90%;">
<br>
    <label>รายละเอียด <font color="red">*</font>:</label><br>
<textarea name="txtdetail" class="txtarea" id="txtdetail" cols="40" rows="10" style="width:90%;"></textarea><br>
<fieldset>
	<legend>ไฟล์รูปภาพ หรือ pdf </legend>
		<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด   //$file_no change for 5 input box
		for ($i=0; $i<=4;$i++){
			echo "รูปที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type="file" name="file'.$i.'"  /><br /><br>';
		}
	?>
</fieldset>
	<br>
	<label>ป้อนรหัสยืนยัน :</label>
	<span>เงื่อนไข<br>
        1. กรุณาป้อนข้อมูล <font color="red">*</font> ให้ครบทุกช่อง <br>
	2. กรุณาใช้คำที่สุภาพและไม่เป็นการหมิ่นประมาท ใส่ร้ายผู้อื่น<br>
	3. ทางทีมงานขอสงวนสิทธิ์ในการลบข้อความไม่เหมาะสมใดๆโดยมิต้องแจ้งล่วงหน้า<br>
	**รายละเอียดและชื่อของท่านจะไม่ถูกเปิดเผย <br>
	ข้าพเจ้าขอยืนยันข้อความและยอมรับเงื่อนไขทุกข้อ <br>
	(กรุณาพิมพ์ให้เหมือนภาพ)<br>
	<img src="itgmod/verify_image.php" style="width:100px;height:30px;"><br><input type="number" name="txtver" style="margin:2px;border:1px solid;height:23px;width:100px;"/></span>
	<br><input class="bt" type="submit" name="btwb" value="บันทึก" onclick="return checkdetail();"/>

</div>
</form>
</div>
