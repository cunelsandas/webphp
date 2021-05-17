<?php

error_reporting(0);

	$folder="welfare";
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$folderupload="/01-newweb/".$gloUploadPath."/".$folder."/";
	$foldername="../".$gloUploadPath."/".$folder."/";
	$tablename="tb_citizen";

//ลบภาพ
if(isset($_GET['del'])){
		$filenameFordel=FindRS("select * from filename where id=".$_GET['del'],"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$folderupload.$filenameFordel);
		}
		$sql="DELETE From filename Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);


}

	$id=$_GET['id'];
	$sql="select * from tb_citizen where id=$id";
	$rs=rsQuery($sql);

// แสดงข้อมูลจากไฟล์ persondata.php
	if(mysqli_num_rows($rs)>0){
		$data=mysqli_fetch_assoc($rs);
	$id=$data['id'];
	$personid=$data['personid'];
	$password=$data['password'];
	$name=$data['name'];
	$surname=$data['surname'];
	$prename=$data['prename'];
	$otherprename=$data['otherprename'];
	$birthdate=ChangeYear($data['birthdate'],"th");
	$calage=calage(strtotime($data['birthdate']),time());
	$nationality=$data['nationality'];
	$address=$data['address'];
	$moo=$data['moo'];
	$soi=$data['soi'];
	$road=$data['road'];
	$telephone=$data['telephone'];
	$maritalstatus=$data['maritalstatus'];
	$occupation=$data['occupation'];
	$income=$data['income'];
	$welfare_older=$data['welfare_older'];
	$welfare_handicap=$data['welfare_handicap'];
	$welfare_aids=$data['welfare_aids'];
	$newcitizendate=(empty($data['newcitizendate'])?"":ChangeYear($data['newcitizendate'],"th"));
	$bankname=$data['bankname'];
	$bankbranch=$data['bankbranch'];
	$bankaccount=$data['bankaccount'];
	$bankaccountname=$data['bankaccountname'];
	$status_edit=$data['status_edit'];
	$registerdate=$data['registerdate'];
	$name2=$data['name2'];
	$personid2=$data['personid2'];
	$address2=$data['address2'];
	$relationship=$data['relationship'];
	$telephone2=$data['telephone2'];

	$handicap_eye=$data['handicap_eye'];
	$handicap_ear=$data['handicap_ear'];
	$handicap_body=$data['handicap_body'];
	$handicap_mind=$data['handicap_mind'];
	$handicap_brain=$data['handicap_brain'];
	$handicap_learn=$data['handicap_learn'];
	$handicap_ortistic=$data['handicap_ortistic'];

	$chkolder = ($welfare_older==1?checked:"");
	$chkhandicap = ($welfare_handicap==1?checked:"");
	$chkaids = ($welfare_aids==1?checked:"");

	$chkhandicap_eye=($handicap_eye==1?checked:"");
	$chkhandicap_ear=($handicap_ear==1?checked:"");
	$chkhandicap_body=($handicap_body==1?checked:"");
	$chkhandicap_mind=($handicap_mind==1?checked:"");
	$chkhandicap_brain=($handicap_brain==1?checked:"");
	$chkhandicap_learn=($handicap_learn==1?checked:"");
	$chkhandicap_ortistic=($handicap_ortistic==1?checked:"");

	$status=$data['status'];

  $statusmain =  FindRS("select name from tb_citizen_status where id = $status ","name");

	$status_edit=$data['status_edit'];
		if($status_edit==0){
			$allowedit="selected";
			$noedit="";
		}else{
			$allowedit="";
			$noedit="selected";
		}
	}

		if(isset($_POST['btsave'])){
	$id=$_POST['txtid'];
	$personid=$_POST['txtpersonid'];
	$name=$_POST['txtname'];
	$surname=$_POST['txtsurname'];
	$prename=$_POST['cboprename'];
	$otherprename=$_POST['txtotherprename'];
	$birthdate=ChangeYear($_POST['txtbirthdate'],"en");
	$nationality=$_POST['txtnationality'];
	$address=$_POST['txtaddress'];
	$moo=$_POST['cbomoo'];
	$soi=$_POST['txtsoi'];
	$road=$_POST['txtroad'];
	$telephone=$_POST['txttelephone'];
	$maritalstatus=$_POST['cbomaritalstatus'];
	$occupation=$_POST['txtoccupation'];
	$income=(!empty($_POST['txtincome'])?$_POST['txtincome']:0);
	$welfare_older=($_POST['chkwelfare_older']==1?1:0);
	$welfare_handicap=($_POST['chkwelfare_handicap']==1?1:0);
	$welfare_aids=($_POST['chkwelfare_aids']==1?1:0);
	$newcitizendate=(empty($_POST['txtnewcitizendate'])?"":ChangeYear($_POST['txtnewcitizendate'],"en"));
	$bankname=$_POST['cbobankname'];
	$bankbranch=$_POST['txtbankbranch'];
	$bankaccount=$_POST['txtbankaccount'];
	$bankaccountname=$_POST['txtbankaccountname'];
	$name2=$_POST['txtname2'];
	$personid2=(!empty($_POST['txtpersonid2'])?$_POST['txtpersonid2']:null);
	$address2=$_POST['txtaddress2'];
	$relationship=$_POST['cborelationship'];
	$telephone2=$_POST['txttelephone2'];

	$handicap_eye=($_POST['chkhandicap_eye']==1?1:0);
	$handicap_ear=($_POST['chkhandicap_ear']==1?1:0);
	$handicap_body=($_POST['chkhandicap_body']==1?1:0);
	$handicap_mind=($_POST['chkhandicap_mind']==1?1:0);
	$handicap_brain=($_POST['chkhandicap_brain']==1?1:0);
	$handicap_learn=($_POST['chkhandicap_learn']==1?1:0);
	$handicap_ortistic=($_POST['chkhandicap_ortistic']==1?1:0);

	$status=$_POST['cbostatus'];
	$status_edit=$_POST['cbostatus_edit'];
	$password=$_POST['txtpassword'];

	$sql="Update tb_citizen SET name='$name',surname='$surname',prename='$prename',otherprename='$otherprename',birthdate='$birthdate',nationality='$nationality',address='$address',moo='$moo',soi='$soi',road='$road',telephone='$telephone',maritalstatus='$maritalstatus',occupation='$occupation',income='$income',welfare_older='$welfare_older',welfare_handicap='$welfare_handicap',welfare_aids='$welfare_aids',newcitizendate='$newcitizendate',bankname='$bankname',bankaccount='$bankaccount',bankaccountname='$bankaccountname',name2='$name2',personid2='$personid2',address2='$address2',relationship='$relationship',telephone2='$telephone2',handicap_eye='$handicap_eye',handicap_ear='$handicap_ear',handicap_body='$handicap_body',handicap_mind='$handicap_mind',handicap_brain='$handicap_brain',handicap_learn='$handicap_learn',handicap_ortistic='$handicap_ortistic',bankbranch='$bankbranch',status_edit='$status_edit',password='$password' Where id=$id";
	$rs=rsQuery($sql);
	if($rs){
		$file=array();
		$size=array();
		$type=array();
		$images=array();
		$newfile=array();
		$postname=array("personid","address","bank","authority","authority_personid","authority_address","handicapid","aids");
  // วนรับค่าจาก control
	for ($i=0;$i<=7;$i++){
	//	$file[$i]=$_FILES['file'.$i]['name'];
		$file[$i]=$_FILES[$postname[$i]]['name'];
		$size[$i]=$_FILES[$postname[$i]]['size'];
		$type[$i]=strtolower(substr($file[$i],-4));
		$images[$i]=$_FILES[$postname[$i]]['tmp_name'];
	//วนเช็ค file type
		$x=$i+1;
		$strCheckFile=CheckFileUpload($file[$i],$size[$i],$limitsize,$SizeInMb,$x);
		if($strCheckFile[0]=="no"){
			echo $strCheckFile[1];
			exit();
		}else{

			if($file[$i]<>""){
				$newfile[$i]=$tablename.'_'.$id."_".$postname[$i].$type[$i];

				$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น
					if($chkimage=="image"){
						$uploadimage=resizeimage($images[$i],$newfile[$i],$folderupload,$domainname,'0','false');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($images[$i],$_SERVER['DOCUMENT_ROOT'].$folderupload.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}

				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);


				}

		}
	}


		echo "<script>alert('บันทึกข้อมูลแล้ว');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=persondata'</script>";

	}
}
?>

<script>
	$(function () {
		    var d = new Date();
		     var toDay =(d.getFullYear() + 543)  + '-' + (d.getMonth() + 1) + '-' + d.getDate();

	  $("#txtbirthdate").datepicker({ showOn: 'focus', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#txtnewcitizendate").datepicker({ showOn: 'focus', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	});

</script>
<div class="content-input" style="width:90%;">
<form name="frmData" method="POST" action="" enctype="multipart/form-data">
<div align="left"><input type="hidden" name="txtid" value="<?php echo $id;?>">

<br>
<fieldset>
	<legend>กำหนดรหัสและสิทธิ</legend>
	<table>
	<tr><td>
		สถานะ</td><td>

			<input type="text" name="cbostatus" value="<?php echo $statusmain; ?>" disabled/>

			&nbsp;&nbsp;&nbsp;&nbsp;แก้ไขข้อมูลตนเอง&nbsp;<select name="cbostatus_edit"><option value="0" <?php echo $allowedit;?>>อนุญาตให้แก้ไขข้อมูล</option><option value="1" <?php echo $noedit;?>>ไม่อนุญาตให้แก้ไขข้อมูล</option></select>
		</td></tr>
	<tr><td>
	เลขบัตรประชาชน</td><td><input type="text" name="txtpersonid" placeholder="เลขประจำตัวคนพิการ / เลขบัตรประชาชน ตัวเลขเท่านั้น" maxlength="13" value="<?php echo $personid;?>" disabled>
&nbsp;รหัสผ่าน<input type="text" name="txtpassword" value="<?php echo $password;?>"></td></tr>
<tr><td colspan='2'>เลขบัตรประชาชนใช้เป็น user name สำหรับเข้าระบบ
	<br>แก้ไขข้อมูลตนเอง หากไม่อนุญาต ผู้ลงทะเบียนจะไม่สามารถแก้ไขข้อมูลส่วนบุคคลได้เองหน้าเว็บ
</td></tr>
</table>
</fieldset>
<br>
<fieldset>
	<legend>ข้อมูลส่วนบุคคล </legend>
	<br>
	<label>วันที่สมัครใช้งานระบบ :
<?php echo DateTimeThai($registerdate);?>
</label>
<table>

<tr><td>
	คำนำหน้าชื่อ</td><td><select name="cboprename" onchange="otherPrename(this.value);"><option value='0'>คำนำหน้าชื่อ</option>
		<?php
			$sqlmoo="select * from tb_prename order by id";
			$rsmoo=rsQuery($sqlmoo);
			if($rsmoo){
				while($dmoo=mysqli_fetch_assoc($rsmoo)){
					$mooid=$dmoo['id'];
					$mooname=$dmoo['name'];
					if($mooid==$prename){
						echo "<option value='$mooid' selected>$mooname</option>";
					}else{
						echo "<option value='$mooid'>$mooname</option>";
					}
				}
			}
		?>
	</select>&nbsp;
	ระบุ&nbsp;<input type="text" name="txtotherprename" id="txtotherprename" placeholder="ระบุ คำนำหน้าชื่อ"  value="<?php echo $otherprename;?>">
	</td></tr>
	<tr><td>
	ชื่อ</td><td><input type="text" name="txtname" id="txtname" placeholder="ชื่อ" value="<?php echo $name;?>"></td></tr><tr><td>

	นามสกุล</td><td><input type="text" name="txtsurname" id="txtsurname" placeholder="นามสกุล" value="<?php echo $surname;?>">
</td></tr>
<tr><td>
	วันเกิด</td><td><input type="text" name="txtbirthdate" id="txtbirthdate"  placeholder="วันเกิด" value="<?php echo $birthdate;?>">&nbsp;อายุ :&nbsp;<?php echo $calage;?>
</td></tr>
<tr><td>
สัญชาติ</td><td><input type="text" name="txtnationality" id="txtnationality" placeholder="สัญญาติ" value="<?php echo $nationality;?>">
</td></tr>
<tr><td>
ที่อยู่ </td><td>	<input type="text" name="txtaddress" id="txtaddress" placeholder="บ้านเลขที่" value="<?php echo $address;?>">
</td></tr>
<tr><td>
หมู่	</td><td><select name="cbomoo"><option value="0">เลือก</option>
		<?php
			$sqlmoo="select * from tb_moo order by name";
			$rsmoo=rsQuery($sqlmoo);
			if($rsmoo){
				while($dmoo=mysqli_fetch_assoc($rsmoo)){
					$mooid=$dmoo['id'];
					$mooname=$dmoo['name'];
					if($mooid==$moo){
						echo "<option value='$mooid' selected>$mooname</option>";
					}else{
						echo "<option value='$mooid'>$mooname</option>";
					}
				}
			}
		?>
	</select>
</td></tr><tr><td>
ซอย </td><td>	<input type="text" name="txtsoi" placeholder="ซอย / ชุมชน" value="<?php echo $soi;?>"></td></tr>
<tr><td>ถนน</td><td><input type="text" name="txtroad" placeholder="ถนน" value="<?php echo $road;?>">
</td></tr><tr><td colspan='2'>
	<label>ตำบล<?php echo $customer_tambon."&nbsp;อำเภอ".$customer_amphur."&nbsp;จังหวัด".$customer_province;?></label>
</td></tr><tr><td>
	หมายเลขโทรศัพท์ </td><td><input type="text" name="txttelephone" placeholder="หมายเลขโทรศัพท์ ตัวเลขเท่านั้น" value="<?php echo $telephone;?>">
</td></tr><tr><td>

	สถานภาพการสมรส </td><td><select name="cbomaritalstatus"><option value='0'>สถานภาพสมรส</option>
			<?php
			$sqlmoo="select * from tb_maritalstatus order by id";
			$rsmoo=rsQuery($sqlmoo);
			if($rsmoo){
				while($dmoo=mysqli_fetch_assoc($rsmoo)){
					$mooid=$dmoo['id'];
					$mooname=$dmoo['name'];
					if($mooid==$maritalstatus){
						echo "<option value='$mooid' selected>$mooname</option>";
					}else{
						echo "<option value='$mooid'>$mooname</option>";
					}
				}
			}
		?>
	</select>
</td></tr><tr><td>
อาชีพ </td><td>	<input type="text" name="txtoccupation" placeholder="อาชีพ" value="<?php echo $occupation;?>" >&nbsp;รายได้ต่อเดือน&nbsp;<input type="number" name="txtincome" placeholder="รายได้ต่อเดือน (ตัวเลขเท่านั้น)"  value="<?php echo $income;?>">
</td></tr><tr><td colspan='2'>
&nbsp;<label>กรณีต้องการให้โอนเงิน กรุณาระบุชื่อธนาคาร สาขา เลขบัญชี และชื่อเจ้าของบัญชี </td>
</tr>
<tr><td>ชื่อธนาคาร</td><td>
	<select name="cbobankname">
		<?php
			$sqlmoo="select * from tb_bankname order by id";
			$rsmoo=rsQuery($sqlmoo);
			if($rsmoo){
				while($dmoo=mysqli_fetch_assoc($rsmoo)){
					$mooid=$dmoo['id'];
					$mooname=$dmoo['name'];
					if($mooid==$bankname){
						echo "<option value='$mooid' selected>$mooname</option>";
					}else{
						echo "<option value='$mooid'>$mooname</option>";
					}
				}
			}
		?>
	</select>
	</td></tr>
<tr><td>
	ชื่อสาขา </td><td><input type="text" name="txtbankbranch" placeholder="ชื่อสาขา"  value="<?php echo $bankbranch;?>">
</td></tr><tr><td>
	เลขบัญชี </td><td><input type="text" name="txtbankaccount" placeholder="เลขบัญชีธนาคาร"  value="<?php echo $bankaccount;?>">
</td></tr><tr><td>
	ชื่อบัญชี </td><td><input type="text" name="txtbankaccountname" placeholder="ชื่อบัญชี"  value="<?php echo $bankaccountname;?>">
</td></tr>
</table>
</fieldset>

<br>

<fieldset>
	<legend>บุคคลอ้างอิงที่สามารถติดต่อได้</legend>
<table><tr><td>
ชื่อ-นามสกุล</td><td>	<input type="text" name="txtname2" placeholder="ชื่อ-นามสกุล"  value="<?php echo $name2;?>"></td></tr>
<tr><td>หมายเลขโทรศัพท์</td><td> <input type="text" name="txttelephone2" placeholder="โทรศัพท์"  value="<?php echo $telephone2;?>">
</td></tr><tr><td>
เลขบัตรประชาชน</td><td>	<input type="text" name="txtpersonid2" placeholder="เลขประจำตัวประชาชน ของบุคคลอ้างอิง" maxlength="13" value="<?php echo $personid2;?>" >
</td></tr><tr><td>
ที่อยู่</td><td><input type="text" name="txtaddress2" placeholder="ที่อยู่ผู้อ้างอิง บ้านเลขที่ ตำบล อำเภอ จังหวัด" value="<?php echo $address2;?>"  >
</td></tr><tr><td>
ความเกี่ยวข้อง</td><td>	<select name="cborelationship"><option value="0">มีความเกี่ยวข้อง</option>
		<?php
			$sqlmoo="select * from tb_relationship order by id";
			$rsmoo=rsQuery($sqlmoo);
			if($rsmoo){
				while($dmoo=mysqli_fetch_assoc($rsmoo)){
					$mooid=$dmoo['id'];
					$mooname=$dmoo['name'];
					if($mooid==$relationship){
						echo "<option value='$mooid' selected>$mooname</option>";
					}else{
						echo "<option value='$mooid'>$mooname</option>";
					}
				}
			}
		?>
	</select>
</td></tr></table>
</fieldset>
<br>
	<fieldset>
		<legend>สถานภาพการรับสวัสดิการภาครัฐ</legend>
		<br>
		<input type="checkbox" name="chkwelfare_older" value="1" <?php echo $chkolder;?>>&nbsp;เคยได้รับเบี้ยผู้สูงอายุ
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" name="chkwelfare_handicap" value="1" <?php echo $chkhandicap;?>>&nbsp;เคยได้รับเบี้ยผู้พิการ
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" name="chkwelfare_aids" value="1" <?php echo $chkaids;?> >&nbsp;เคยได้รับเบี้ยยังชีพผู้ป่วยเอดส์
		<br><br>
		<label>เคยได้รับ ย้ายภูมิลำเนาเข้ามาอยู่ใหม่ เมื่อวันที่<label>&nbsp;<input type="text" name="txtnewcitizendate" id="txtnewcitizendate" value="<?php echo $newcitizendate;?>">
	</fieldset>

<br>
	<fieldset>
		<legend>สำหรับผู้พิการ</legend>

			ประเภทความพิการ (เลือกได้มากกว่า 1 ข้อ)
			<br>
			<table width='90%'>
			<tr><td width='50%'>
			<input type="checkbox" name="chkhandicap_eye" value="1" <?php echo $chkhandicap_eye;?>>&nbsp;ความพิการทางการเห็น
			<br><br>
			<input type="checkbox" name="chkhandicap_ear" value="1" <?php echo $chkhandicap_ear;?>>&nbsp;ความพิการทางการได้ยินหรือสื่อความหมาย
			<br><br>
			<input type="checkbox" name="chkhandicap_body" value="1" <?php echo $chkhandicap_body;?>>&nbsp;ความพิการทางการเคลื่อนไหวหรือทางร่างกาย
			<br><br>
			<input type="checkbox" name="chkhandicap_mind" value="1" <?php echo $chkhandicap_mind;?>>&nbsp;ความพิการทางการจิตใจหรือพฤติกรรม
			</td>
			<td width='50%' valign='top'>

			<input type="checkbox" name="chkhandicap_brain" value="1" <?php echo $chkhandicap_brain;?>>&nbsp;ความพิการทางสติปัญญา
			<br><br>
			<input type="checkbox" name="chkhandicap_learn" value="1" <?php echo $chkhandicap_learn;?>>&nbsp;ความพิการทางการเรียนรู้
			<br><br>
			<input type="checkbox" name="chkhandicap_ortistic" value="1" <?php echo $chkhandicap_ortistic;?>>&nbsp;ความพิการทางออทิสติก
			<br><br>
			</td></tr>
			</table>
	</fieldset>
	<br>
	<fieldset>
		<legend>ส่งเอกสาร (ไฟล์ jpg หรือ pdf )</legend>
			<br>

				<input type="file" name="personid"  />&nbsp;สำเนาบัตรประชาชน
				<br>

				<input type="file" name="address"  />&nbsp;สำเนาทะเบียนบ้าน
				<br>

				<input type="file" name="bank"  />&nbsp;สำเนาสมุดเงินฝาก บัญชีที่ต้องการให้โอนเงินเข้า
				<br>

				<input type="file" name="authority"  />&nbsp;	หนังสือมอบอำนาจ กรณีให้ผู้อื่นรับเงินแทน
				<br>
				<input type="file" name="authority_personid"  />&nbsp;สำเนาบัตรประชาชน ผู้รับมอบอำนาจ
				<br>

				<input type="file" name="authority_address"  />&nbsp;สำเนาบัตรทะเบียนบ้านผู้รับมอบอำนาจ
				<br>

				<input type="file" name="handicap"  />&nbsp;(สำหรับผู้พิการ) 		สำเนาบัตรคนพิการ
				<br>

				<input type="file" name="aids"  />&nbsp; (สำหรับผู้ป่วยเอดส์) 		ใบรับรองแพทย์ ออกโดยสถานพยาบาลของรัฐ
				<br>
	</fieldset>
	<br>

		<fieldset><legend>ไฟล์เอกสาร</legend>
			<?php
$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$_GET['id']."' Order by id";
$rs=rsQuery($strpicture);
while($arr = mysqli_fetch_assoc($rs)){

	$filetype=substr($arr['filename'],-3);
	if($filetype=="jpg" or $filetype=="png" or $filetype=="gif" or $filetype=="bmp"){
		echo "<a href=".$foldername.$arr['filename']." target='_blank'><img src=".$foldername.$arr['filename']." width='150' height='150' class='".$row['img_filter']."'></a>&nbsp;&nbsp;&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=persondata_view&id=".$_GET['id']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
	}else{
		echo "<a href=".$foldername.$arr['filename']." target='_blank'><img src='../images/icon_pdf.gif' ></a>&nbsp;&nbsp;&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=persondata_view&id=".$_GET['id']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
	}
}
?>
</fieldset>
	<br>

<input type="submit" name="btsave" value="บันทึก">


</form>
</div>
</div>
