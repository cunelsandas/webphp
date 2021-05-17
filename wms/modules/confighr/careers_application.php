<html>
 <head>
  <title> ใบสมัครงาน </title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
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

	  $("#txtbirthday").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#txtidcarddate").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	  $("#txtidcardexpire").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	});
</script>
 </head>

<?php
//	include_once("../../itgmod/connect.inc.php");
	$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	
	//ลบภาพ
if(isset($_GET['del'])){
		
		unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$_GET['del']);	
		$fieldname=$_GET['type'];
		$sql="DELETE From filename Where filename='".$_GET['del']."'";
		$rs=rsQuery($sql);
		$sql2="update $tablename SET $fieldname='' Where id=".$_GET['id'];
		$rs2=rsQuery($sql2);
		
		
}
	$btname="addnew";
	if(isset($_POST['btsave'])){
	//$id=$_POST['txtid'];
	$dateregis=date("Y-m-d H:i:s");
	$nameth=$_POST['txtnameth'];
	$nameen=$_POST['txtnameen'];
	$positon=$_POST['txtposition'];
	$salary=$_POST['txtsalary'];
	$birthday=ChangeYear($_POST['txtbirthday'],'en');
	$race=$_POST['txtrace'];
	$nationality=$_POST['txtnationality'];
	$religion=$_POST['txtreligion'];
	$idcard=$_POST['txtidcard'];
	$idcardamphur=$_POST['txtidcardamphur'];
	$idcardprovince=$_POST['txtidcardprovince'];
	$idcarddate=ChangeYear($_POST['txtidcarddate'],"en");
	$idcardexpire=ChangeYear($_POST['txtidcardexpire'],"en");
	$height=$_POST['txtheight'];
	$weight=$_POST['txtweight'];
	$maritalstatus=$_POST['cbomaritalstatus'];
	$spousename=$_POST['txtspousename'];
	$spouseoccupation=$_POST['txtspouseoccupation'];
	$spouseaddress=$_POST['txtspouseaddress'];
	$spouserace=$_POST['txtspouserace'];
	$spousenationality=$_POST['txtspousenationality'];
	$spousereligion=$_POST['txtspousereligion'];
	$children=$_POST['txtchildren'];
	$fathername=$_POST['txtfathername'];
	$fatheroccupation=$_POST['txtfatheroccupation'];
	$mothername=$_POST['txtmothername'];
	$motheroccupation=$_POST['txtmotheroccupation'];
	$presentaddress=$_POST['txtpresentaddress'];
	$address=$_POST['txtaddress'];
	$telephone=$_POST['txttelephone'];
	$mobile=$_POST['txtmobile'];
	$email=$_POST['txtemail'];
	$educate11=$_POST['txteducate11'];
	$educate12=$_POST['txteducate12'];
	$educate13=$_POST['txteducate13'];
	$educate21=$_POST['txteducate21'];
	$educate22=$_POST['txteducate22'];
	$educate23=$_POST['txteducate23'];
	$educate31=$_POST['txteducate31'];
	$educate32=$_POST['txteducate32'];
	$educate33=$_POST['txteducate33'];
	$educate41=$_POST['txteducate41'];
	$educate42=$_POST['txteducate42'];
	$educate43=$_POST['txteducate43'];
	$thaispeak=$_POST['cbothaispeak'];
	$thaiwrite=$_POST['cbothaiwrite'];
	$thairead=$_POST['cbothairead'];
	$engspeak=$_POST['cboengspeak'];
	$engwrite=$_POST['cboengwrite'];
	$engread=$_POST['cboengread'];
	$chispeak=$_POST['cbochispeak'];
	$chiwrite=$_POST['cbochiwrite'];
	$chiread=$_POST['cbochiread'];

	$employ11=$_POST['txtemploy11'];
	$employ12=$_POST['txtemploy12'];
	$employ13=$_POST['txtemploy13'];
	$employ14=$_POST['txtemploy14'];
	$employ21=$_POST['txtemploy21'];
	$employ22=$_POST['txtemploy22'];
	$employ23=$_POST['txtemploy23'];
	$employ24=$_POST['txtemploy24'];
	$employ31=$_POST['txtemploy31'];
	$employ32=$_POST['txtemploy32'];
	$employ33=$_POST['txtemploy33'];
	$employ34=$_POST['txtemploy34'];
	$employ41=$_POST['txtemploy41'];
	$employ42=$_POST['txtemploy42'];
	$employ43=$_POST['txtemploy43'];
	$employ44=$_POST['txtemploy44'];

	$software=$_POST['txtsoftware'];
	$vehicle=$_POST['txtvehicle'];
	$hobbie=$_POST['txthobbie'];
	$ability=$_POST['txtability'];

	$country=$_POST['cbocountry'];
	$emergencyname=$_POST['txtemergencyname'];
	$emergencyrelate=$_POST['txtemergencyrelate'];
	$friendname=$_POST['txtfriendname'];
	$friendrelate=$_POST['txtfriendrelate'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$status_accept=$_POST['txtstatus_accept'];
	switch($_POST['btsave']){
		case "addnew":
				$strsql="insert into $tablename(
						dateregis,
						nameth,
						nameen,
						positon,
						salary,
						birthday,
						race,
						nationality,
						religion,
						idcard,
						idcardamphur,
						idcardprovince,
						idcarddate,
						idcardexpire,
						height,
						weight,
						maritalstatus,
						spousename,
						spouseoccupation,
						spouseaddress,
						spouserace,
						spousenationality,
						spousereligion,
						children,
						fathername,
						fatheroccupation,
						mothername,
						motheroccupation,
						presentaddress,
						address,
						telephone,
						mobile,
						email,
						educate11,
						educate12,
						educate13,
						educate21,
						educate22,
						educate23,
						educate31,
						educate32,
						educate33,
						educate41,
						educate42,
						educate43,
						thaispeak,
						thaiwrite,
						thairead,
						engspeak,
						engwrite,
						engread,
						chispeak,
						chiwrite,
						chiread,

						employ11,
						employ12,
						employ13,
						employ14,
						employ21,
						employ22,
						employ23,
						employ24,
						employ31,
						employ32,
						employ33,
						employ34,
						employ41,
						employ42,
						employ43,
						employ44,

						software,
						vehicle,
						hobbie,
						ability,

						country,
						emergencyname,
						emergencyrelate,
						friendname,
						friendrelate,
						ip,
						status_accept)
						Value(
						'$dateregis',
						'$nameth',
						'$nameen',
						'$positon',
						'$salary',
						'$birthday',
						'$race',
						'$nationality',
						'$religion',
						'$idcard',
						'$idcardamphur',
						'$idcardprovince',
						'$idcarddate',
						'$idcardexpire',
						'$height',
						'$weight',
						'$maritalstatus',
						'$spousename',
						'$spouseoccupation',
						'$spouseaddress',
						'$spouserace',
						'$spousenationality',
						'$spousereligion',
						'$children',
						'$fathername',
						'$fatheroccupation',
						'$mothername',
						'$motheroccupation',
						'$presentaddress',
						'$address',
						'$telephone',
						'$mobile',
						'$email',
						'$educate11',
						'$educate12',
						'$educate13',
						'$educate21',
						'$educate22',
						'$educate23',
						'$educate31',
						'$educate32',
						'$educate33',
						'$educate41',
						'$educate42',
						'$educate43',
						'$thaispeak',
						'$thaiwrite',
						'$thairead',
						'$engspeak',
						'$engwrite',
						'$engread',
						'$chispeak',
						'$chiwrite',
						'$chiread',

						'$employ11',
						'$employ12',
						'$employ13',
						'$employ14',
						'$employ21',
						'$employ22',
						'$employ23',
						'$employ24',
						'$employ31',
						'$employ32',
						'$employ33',
						'$employ34',
						'$employ41',
						'$employ42',
						'$employ43',
						'$employ44',

						'$software',
						'$vehicle',
						'$hobbie',
						'$ability',

						'$country',
						'$emergencyname',
						'$emergencyrelate',
						'$friendname',
						'$friendrelate',
						'$ip',
						'$status_accept')";
	
			break;
		
		case "edit":
				$strsql="Update $tablename SET 
					nameth='$nameth',
	nameen='$nameen',
	positon='$position',
	salary='$salary',
	birthday='$birthday',
	race='$race',
	nationality='$nationality',
	religion='$religion',
	idcard='$idcard',
	idcardamphur='$idcardamphur',
	idcardprovince='$idcardprovince',
	idcarddate='$idcarddate',
	idcardexpire='$idcardexpire',
	height='$height',
	weight='$weight',
	maritalstatus='$maritalstatus',
	spousename='$spousename',
	spouseoccupation='$spouseoccupation',
	spouseaddress='$spouseaddress',
	spouserace='$spouserace',
	spousenationality='$spousenationality',
	spousereligion='$spousereligion',
	children='$children',
	fathername='$fathername',
	fatheroccupation='$fatheroccupation',
	mothername='$mothername',
	motheroccupation='$motheroccupation',
	presentaddress='$presentaddress',
	address='$address',
	telephone='$telephone',
	mobile='$mobile',
	email='$email',
	educate11='$educate11',
	educate12='$educate12',
	educate13='$educate13',
	educate21='$educate21',
	educate22='$educate22',
	educate23='$educate23',
	educate31='$educate31',
	educate32='$educate32',
	educate33='$educate33',
	educate41='$educate41',
	educate42='$educate42',
	educate43='$educate43',
	thaispeak='$thaispeak',
	thaiwrite='$thaiwrite',
	thairead='$thairead',
	engspeak='$engspeak',
	engwrite='$engwrite',
	engread='$engread',
	chispeak='$chispeak',
	chiwrite='$chiwrite',
	chiread='$chiread',

	employ11='$employ11',
	employ12='$employ12',
	employ13='$employ13',
	employ14='$employ14',
	employ21='$employ21',
	employ22='$employ22',
	employ23='$employ23',
	employ24='$employ24',
	employ31='$employ31',
	employ32='$employ32',
	employ33='$employ33',
	employ34='$employ34',
	employ41='$employ41',
	employ42='$employ42',
	employ43='$employ43',
	employ44='$employ44',

	software='$software',
	vehicle='$vehicle',
	hobbie='$hobbie',
	ability='$ability',

	country='$country',
	emergencyname='$emergencyname',
	emergencyrelate='$emergencyrelate',
	friendname='$friendname',
	status_accept='$status_accept',
	friendrelate='$friendrelate' Where id=".$_POST['txtid'];
	

			break;

	}
	$sqltest=$strsql;
	$rs=rsQuery($strsql);
	if($rs){
		if($_POST['btsave']=="addnew"){
		$sql="Select * From $tablename Order by id DESC limit 0,1";
		}
		
		
		if($_POST['btsave']=="edit"){
			$sql="select * from $tablename where id=".$_POST['txtid'];
		}
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['id'];
	//อัพรูปถ่ายผู้สมัคร
	if(!empty($_FILES['image_person']['name'])){
		$file_person=$_FILES['image_person']['name'];
		$size_person=$_FILES['image_person']['size'];
		$type_person=strtolower(substr($file_person,-4));
		$image_person=$_FILES['image_person']['tmp_name'];
		$name_person=$tablename.'_'.$id.'_person'.$type_person;
		$strCheckFile=CheckFileUpload($file_person,$size_person,$limitsize,$SizeInMb,"รูปภ่าย");
			if($strCheckFile[0]=="no"){
				echo $strCheckFile[1];
				exit();
			}
				$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น 
					if($chkimage=="image"){  
						$uploadimage=resizeimage($image_person,$name_person,$foldername,$domainname,'0','false');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($image_person,$_SERVER['DOCUMENT_ROOT'].$foldername.$name_person);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}

				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$name_person."')";
				$uppicname=rsQuery($filename);
				$strupdate="update $tablename set image_person='$name_person' Where id=$id";
				$rsup=rsQuery($strupdate);
	}
	//อัพบัตรประชาชน
		if(!empty($_FILES['image_idcard']['name'])){
		$file_idcard=$_FILES['image_idcard']['name'];
		$size_idcard=$_FILES['image_idcard']['size'];
		$type_idcard=strtolower(substr($file_idcard,-4));
		$image_idcard=$_FILES['image_idcard']['tmp_name'];
		$name_idcard=$tablename.'_'.$id.'_idcard'.$type_idcard;
		$strCheckFile=CheckFileUpload($file_idcard,$size_idcard,$limitsize,$SizeInMb,"บัตรประชาชน");
			if($strCheckFile[0]=="no"){
				echo $strCheckFile[1];
				exit();
			}
				$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น 
					if($chkimage=="image"){  
						$uploadimage=resizeimage($image_idcard,$name_idcard,$foldername,$domainname,'0','false');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($image_idcard,$_SERVER['DOCUMENT_ROOT'].$foldername.$name_idcard);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}

				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$name_idcard."')";
				$uppicname=rsQuery($filename);
				$strupdate="update $tablename set image_idcard='$name_idcard' Where id=$id";
				$rsup=rsQuery($strupdate);
				
	}
	//อัพรูปสำเนาทะเบียนบ้าน
	if(!empty($_FILES['image_address']['name'])){
		$file_address=$_FILES['image_address']['name'];
		$size_address=$_FILES['image_address']['size'];
		$type_address=strtolower(substr($file_address,-4));
		$image_address=$_FILES['image_address']['tmp_name'];
		$name_address=$tablename.'_'.$id.'_address'.$type_address;
		$strCheckFile=CheckFileUpload($file_address,$size_address,$limitsize,$SizeInMb,"ทะเบียนบ้าน");
			if($strCheckFile[0]=="no"){
				echo $strCheckFile[1];
				exit();
			}
				$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น 
					if($chkimage=="image"){  
						$uploadimage=resizeimage($image_address,$name_address,$foldername,$domainname,'0','false');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($image_address,$_SERVER['DOCUMENT_ROOT'].$foldername.$name_address);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}

				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$name_address."')";
				$uppicname=rsQuery($filename);
				$strupdate="update $tablename set image_address='$name_address' Where id=$id";
				$rsup=rsQuery($strupdate);
				
	}
	//อัพประวัติการศึกษา
	if(!empty($_FILES['image_education']['name'])){
		$file_education=$_FILES['image_education']['name'];
		$size_education=$_FILES['image_education']['size'];
		$type_education=strtolower(substr($file_education,-4));
		$image_education=$_FILES['image_education']['tmp_name'];
		$name_education=$tablename.'_'.$id.'_education'.$type_education;
		$strCheckFile=CheckFileUpload($file_education,$size_education,$limitsize,$SizeInMb,"วุฒิการศึกษา");
			if($strCheckFile[0]=="no"){
				echo $strCheckFile[1];
				exit();
			}
				$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น 
					if($chkimage=="image"){  
						$uploadimage=resizeimage($image_education,$name_education,$foldername,$domainname,'0','false');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($image_education,$_SERVER['DOCUMENT_ROOT'].$foldername.$name_education);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}

				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$name_education."')";
				$uppicname=rsQuery($filename);
				$strupdate="update $tablename set image_education='$name_education' Where id=$id";
				$rsup=rsQuery($strupdate);
	}
	//อัพประวัติส่วนตัว resume
	if(!empty($_FILES['image_resume']['name'])){
		$file_resume=$_FILES['image_resume']['name'];
		$size_resume=$_FILES['image_resume']['size'];
		$type_resume=strtolower(substr($file_resume,-4));
		$image_resume=$_FILES['image_resume']['tmp_name'];
		$name_resume=$tablename.'_'.$id.'_resume'.$type_resume;
		$strCheckFile=CheckFileUpload($file_resume,$size_resume,$limitsize,$SizeInMb,"ประวัติส่วนตัว resume");
			if($strCheckFile[0]=="no"){
				echo $strCheckFile[1];
				exit();
			}
				$chkimage=isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น 
					if($chkimage=="image"){  
						$uploadimage=resizeimage($image_resume,$name_resume,$foldername,$domainname,'0','false');
					}
					if($chkimage=="no"){  //ถ้าไม่ใช่ไฟล์รูปให้copy
						copy($image_resume,$_SERVER['DOCUMENT_ROOT'].$foldername.$name_resume);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}

				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$name_resume."')";
				$uppicname=rsQuery($filename);
				$strupdate="update $tablename set image_resume='$name_resume' Where id=$id";
				$rsup=rsQuery($strupdate);
	}
		
		
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}


	if(isset($_GET['id'])){
		$btname="edit";
		$sql="select * from $tablename where id=".$_GET['id'];
		$rs=rsQuery($sql);
		if(mysqli_num_rows($rs)>0){
			$data=mysqli_fetch_assoc($rs);
			$v_id=$data['id'];
	$v_nameth=$data['nameth'];
	$v_nameen=$data['nameen'];
	$v_positon=$data['position'];
	$v_salary=$data['salary'];
	$v_birthday=ChangeYear($data['birthday'],"th");
	$v_race=$data['race'];
	$v_nationality=$data['nationality'];
	$v_religion=$data['religion'];
	$v_idcard=$data['idcard'];
	$v_idcardamphur=$data['idcardamphur'];
	$v_idcardprovince=$data['idcardprovince'];
	$v_idcarddate=ChangeYear($data['idcarddate'],"th");
	$v_idcardexpire=ChangeYear($data['idcardexpire'],"th");
	$v_height=$data['height'];
	$v_weight=$data['weight'];
	$v_maritalstatus=$data['maritalstatus'];
	$v_spousename=$data['spousename'];
	$v_spouseoccupation=$data['spouseoccupation'];
	$v_spouseaddress=$data['spouseaddress'];
	$v_spouserace=$data['spouserace'];
	$v_spousenationality=$data['spousenationality'];
	$v_spousereligion=$data['spousereligion'];
	$v_children=$data['children'];
	$v_fathername=$data['fathername'];
	$v_fatheroccupation=$data['fatheroccupation'];
	$v_mothername=$data['mothername'];
	$v_motheroccupation=$data['motheroccupation'];
	$v_presentaddress=$data['presentaddress'];
	$v_address=$data['address'];
	$v_telephone=$data['telephone'];
	$v_mobile=$data['mobile'];
	$v_email=$data['email'];
	$v_educate11=$data['educate11'];
	$v_educate12=$data['educate12'];
	$v_educate13=$data['educate13'];
	$v_educate21=$data['educate21'];
	$v_educate22=$data['educate22'];
	$v_educate23=$data['educate23'];
	$v_educate31=$data['educate31'];
	$v_educate32=$data['educate32'];
	$v_educate33=$data['educate33'];
	$v_educate41=$data['educate41'];
	$v_educate42=$data['educate42'];
	$v_educate43=$data['educate43'];
	$v_thaispeak=$data['thaispeak'];
	$v_thaiwrite=$data['thaiwrite'];
	$v_thairead=$data['thairead'];
	$v_engspeak=$data['engspeak'];
	$v_engwrite=$data['engwrite'];
	$v_engread=$data['engread'];
	$v_chispeak=$data['chispeak'];
	$v_chiwrite=$data['chiwrite'];
	$v_chiread=$data['chiread'];

	$v_employ11=$data['employ11'];
	$v_employ12=$data['employ12'];
	$v_employ13=$data['employ13'];
	$v_employ14=$data['employ14'];
	$v_employ21=$data['employ21'];
	$v_employ22=$data['employ22'];
	$v_employ23=$data['employ23'];
	$v_employ24=$data['employ24'];
	$v_employ31=$data['employ31'];
	$v_employ32=$data['employ32'];
	$v_employ33=$data['employ33'];
	$v_employ34=$data['employ34'];
	$v_employ41=$data['employ41'];
	$v_employ42=$data['employ42'];
	$v_employ43=$data['employ43'];
	$v_employ44=$data['employ44'];

	$v_software=$data['software'];
	$v_vehicle=$data['vehicle'];
	$v_hobbie=$data['hobbie'];
	$v_ability=$data['ability'];

	$v_country=$data['country'];
	$v_emergencyname=$data['emergencyname'];
	$v_emergencyrelate=$data['emergencyrelate'];
	$v_friendname=$data['friendname'];
	$v_friendrelate=$data['friendrelate'];
	$v_status_accept=$data['status_accept'];
	$v_image_person=$data['image_person'];
	$v_image_idcard=$data['image_idcard'];
	$v_image_address=$data['image_address'];
	$v_image_education=$data['image_education'];
	$v_image_resume=$data['image_resume'];
		}
	}


?>
 <body>
 <form name="frmAdd" method="POST" action="" enctype="multipart/form-data">
		<div class="content-box">
			
				<fieldset class="content-input">
					<legend><?php echo $customer_name;?></legend>
						<label>id:<?php echo $v_id;?></label><br><input type="hidden" name="txtid" value="<?php echo $v_id;?>">
						<label>ชื่อ-สกุล ภาษาไทย</label><input type="text" name="txtnameth" placeholder="name - surname in thai" value="<?php echo $v_nameth;?>" style="width:50%;"><br>
						<label>ชื่อ-สกุล ภาษาอังกฤษ</label><input type="text" name="txtnameen" placeholder="name - surname in english" value="<?php echo $v_nametn;?>" style="width:50%;"><br>
						<label>ตำแหน่งที่สมัคร</label><input type="text" name="txtposition" placeholder="position applied for" value="<?php echo $v_position;?>">&nbsp;&nbsp;&nbsp;&nbsp;<label>เงินเดือนที่ต้องการ(บาท/เดือน)</label><input type="text" name="txtsalary" placeholder="expected salary (bath/month)" value="<?php echo $v_salary;?>" style="width:20%;"><br>
				</fieldset>
				<fieldset class="content-input">
					<legend>ประวัติส่วนตัว (personal background)</legend>
						<label>1. วัน / เดือน / ปี เกิด</label><input type="text" name="txtbirthday" id="txtbirthday" placeholder="date of birth" value="<?php echo $v_birthday;?>">
						<label>เชื่อชาติ</label><input type="text" name="txtrace" placeholder="race" value="<?php echo $v_race;?>">
						<label>สัญชาติ</label><input type="text" name="txtnationality" placeholder="nationaliry" value="<?php echo $v_nationality;?>">
						<label>ศาสนา</label><input type="text" name="txtreligion" placeholder="religion" value="<?php echo $v_religion;?>"><br>
					<label>เลขบัตรประชาชน</label><input type="text" name="txtidcard" placeholder="id card" value="<?php echo $v_idcard;?>">
						<label>ออกให้ ณ. อำเภอ</label><input type="text" name="txtidcardamphur" placeholder="issued at" value="<?php echo $v_idcardamphur;?>">
						<label>จังหวัด</label><input type="text" name="txtidcardprovince" placeholder="province" value="<?php echo $v_idcardprovince;?>"><br>
					<label>วันออกบัตร</label><input type="text" name="txtidcarddate" id="txtidcarddate" placeholder="issued date" value="<?php echo $v_idcarddate;?>">
						<label>วันหมดอายุ</label><input type="text" name="txtidcardexpire" id="txtidcardexpire" placeholder="expire date" value="<?php echo $v_idcardexpire;?>">
						<label>ส่วนสูง(ซม)</label><input type="text" name="txtheight" placeholder="height(cm)" value="<?php echo $v_height;?>">
						<label>น้ำหนัก(กก)</label><input type="text" name="txtweight" placeholder="weight(kgs)" value="<?php echo $v_weight;?>"><br>
					<label>2. สถานะครอบครัว</label>
						<select name="cbomaritalstatus">
							<?php
								$sql="select * from tb_marital_status";
								$rs=rsquery($sql);
								if($rs){
								while($data=mysqli_fetch_assoc($rs)){
									echo "<option value='".$data['id']."'>".$data['name']."</option>";
								}
								}
							?>
						</select><br>
					<label>ชื่อ-สกุลคู่สมรส</label><input type="text" name="txtspousename" placeholder="spouse 's name" value="<?php echo $v_spousename;?>" style="width:20%;">
					<label>อาชีพ</label><input type="text" name="txtspouseoccupation" placeholder="occupation" value="<?php echo $v_spouseoccupation;?>"><br>
					<label>สถานที่ทำงาน</label><input type="text" name="txtspouseaddress" placeholder="firm address" value="<?php echo $v_spouseaddress;?>">
						<label>เชื่อชาติ</label><input type="text" name="txtspouserace" placeholder="race" value="<?php echo $v_spouserace;?>">
						<label>สัญชาติ</label><input type="text" name="txtspousenationality" placeholder="nationaliry" value="<?php echo $v_spousenationality;?>">
						<label>ศาสนา</label><input type="text" name="txtspousereligion" placeholder="religion" value="<?php echo $v_spousereligion;?>"><br>
					<label>จำนวนบุตร</label><input type="text" name="txtchildren" placeholder="number of children" value="<?php echo $v_children;?>"><br>
					<label>ชื่อ-สกุลบิดา</label><input type="text" name="txtfathername" placeholder="father 's name-surname" value="<?php echo $v_fathername;?>" style="width:20%;">
						<label>อาชีพ</label><input type="text" name="txtfatheroccupation" placeholder="occupation" value="<?php echo $v_fatheroccupation;?>"><br>
					<label>ชื่อ-สกุลมารดา</label><input type="text" name="txtmothername" placeholder="mother 's name-surname" value="<?php echo $v_mothername;?>" style="width:20%;">
						<label>อาชีพ</label><input type="text" name="txtmotheroccupation" placeholder="occupation" value="<?php echo $v_motheroccupation;?>"><br>
					<label>3. ที่อยู่ปัจจุบันที่ติดต่อได้</label><input type="text" name="txtpresentaddress" placeholder="present address" value="<?php echo $v_presentaddress;?>" style="width:50%;"><br>
					<label>ที่อยู่ตามทะเบียนบ้าน</label><input type="text" name="txtaddress" placeholder="permanent address" value="<?php echo $v_address;?>" style="width:50%;"><br>
					<label>โทรศัพท์</label><input type="text" name="txttelephone" placeholder="telephone number" value="<?php echo $v_telephone;?>">
						<label>มือถือ</label><input type="text" name="txtmobile" placeholder="mobile no." value="<?php echo $v_mobile;?>">
						<label>อีเมล์</label><input type="text" name="txtemail" placeholder="email address" value="<?php echo $v_email;?>"><br>
				</fieldset>

				<fieldset class="content-input">
					<legend>ประวัติการศึกษา educationnal background</legend>
						<table class="content-table" width="90%">
							<tr>
								<th>ระดับการศึกษา<br>educational level</th><th>สถานศึกษา<br>institution</th><th>สาขาวิชา/วุฒิที่ได้รับ<br>couse /completed</th><th>ปีที่จบ <br>year</th>
							</tr>
							<tr>
								<td>ประถม</td><td><input type="text" name="txteducate11" value="<?php echo $v_educate11;?>"></td><td><input type="text" name="txteducate12" value="<?php echo $v_educate12;?>"></td><td><input type="text" name="txteducate13" value="<?php echo $v_educate13;?>"></td>
							</tr>
							<tr>
								<td>มัธยม/ปวช.</td><td><input type="text" name="txteducate21" value="<?php echo $v_educate21;?>"></td><td><input type="text" name="txteducate22" value="<?php echo $v_educate22;?>"></td><td><input type="text" name="txteducate23" value="<?php echo $v_educate23;?>"></td>
							</tr>
							<tr>
								<td>อนุปริญญา/ปริญญาตรี</td><td><input type="text" name="txteducate31" value="<?php echo $v_educate31;?>"></td><td><input type="text" name="txteducate32" value="<?php echo $v_educate32;?>"></td><td><input type="text" name="txteducate33" value="<?php echo $v_educate33;?>"></td>
							</tr>
							<tr>
								<td>อื่นๆ</td><td><input type="text" name="txteducate41" value="<?php echo $v_educate41;?>"></td><td><input type="text" name="txteducate42" value="<?php echo $v_educate42;?>"></td><td><input type="text" name="txteducate43" value="<?php echo $v_educate43;?>"></td>
							</tr>
						</table>
						<br>
						<table class="content-table" width="90%">
							<tr>
								<th>ภาษา<br>language</th><th>การพูด<br>speaking</th><th>การเขียน<br>writing</th><th>การอ่าน<br>reading</th>
							</tr>
							<tr>
								<td>ไทย (thai)</td>
								<td><select name="cbothaispeak">
								<?php 
									echo "<option value='$v_thaispeak'>$v_thaispeak</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
								<td><select name="cbothaiwrite">
								<?php 
									echo "<option value='$v_thaiwrite'>$v_thaiwrite</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
								<td><select name="cbothairead">
								<?php 
									echo "<option value='$v_thairead'>$v_thairead</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
							</tr>
							<tr>
								<td>อังกฤษ (english)</td>
								<td><select name="cboengspeak">
								<?php 
									echo "<option value='$v_engspeak'>$v_engspeak</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
								<td><select name="cboengwrite">
								<?php 
									echo "<option value='$v_engwrite'>$v_engwrite</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
								<td><select name="cboengread">
								<?php 
									echo "<option value='$v_engread'>$v_engread</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
							</tr>
							<tr>
								<td>จีน (chinese)</td>
								<td><select name="cbochispeak">
								<?php 
									echo "<option value='$v_chispeak'>$v_chispeak</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
								<td><select name="cbochiwrite">
								<?php 
									echo "<option value='$v_chiwrite'>$v_chiwrite</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
								<td><select name="cbochiread">
								<?php 
									echo "<option value='$v_chiread'>$v_chiread</option>";
								?>
								<option value="ดีมาก/good">ดีมาก/good</option><option value="ดี/fair">ดี/fair</option><option value="พอใช้/poor">พอใช้/poor</option></td>
							</tr>
						</table>

				</fieldset>

				<fieldset class="content-input">
					<legend>ประวัติการทำงาน employment history</legend>
						<table class="content-table" width="90%">
							<tr>
								<th>ชื่อสถานประกอบการ<br>list of employed</th><th>ช่วงเวลา<br>date employed</th><th>ตำแหน่ง<br> position</th><th>เงินเดือนสุดท้าย<br>last salary</th>
							</tr>
							<tr>
								<td><input type="text" name="txtemploy11" value="<?php echo $v_employ11;?>"></td><td><input type="text" name="txtemploy12" value="<?php echo $v_employ12;?>"></td><td><input type="text" name="txtemploy13" value="<?php echo $v_employ13;?>"></td><td><input type="text" name="txtemploy14" value="<?php echo $v_employ14;?>"></td>
							</tr>
							<tr>
								<td><input type="text" name="txtemploy21" value="<?php echo $v_employ21;?>"></td><td><input type="text" name="txtemploy22" value="<?php echo $v_employ22;?>"></td><td><input type="text" name="txtemploy23" value="<?php echo $v_employ23;?>"></td><td><input type="text" name="txtemploy24" value="<?php echo $v_employ24;?>"></td>
							</tr>
							<tr>
								<td><input type="text" name="txtemploy31" value="<?php echo $v_employ31;?>"></td><td><input type="text" name="txtemploy32" value="<?php echo $v_employ32;?>"></td><td><input type="text" name="txtemploy33" value="<?php echo $v_employ33;?>"></td><td><input type="text" name="txtemploy34" value="<?php echo $v_employ34;?>"></td>
							</tr>
							<tr>
								<td><input type="text" name="txtemploy41" value="<?php echo $v_employ41;?>"></td><td><input type="text" name="txtemploy42" value="<?php echo $v_employ42;?>"></td><td><input type="text" name="txtemploy43" value="<?php echo $v_employ43;?>"></td><td><input type="text" name="txtemploy44" value="<?php echo $v_employ44;?>"></td>
							</tr>
						</table>
				</fieldset>
				<fieldset class="content-input">
					<legend>ความสามารถพิเศษ (special ability)</legend>
						<label>คอมพิวเตอร์ ระบุsoftware</label><input type="text" name="txtsoftware" placeholder="software ex.office , autocad , html" value="<?php echo $v_software;?>" style="width:20%;"><br>
						<label>การขับขี่ยานพาหนะ</label><input type="text" name="txtvehicle" placeholder="can you drive ex: car motocycle truck" value="<?php echo $v_vehicle;?>" style="width:20%;"><br>
						<label>งานอดิเรก</label><input type="text" name="txthobbie" placeholder="hobbies" value="<?php echo $v_hobbie;?>" style="width:20%;"><br>
						<label>ความสามารถพิเศษ</label><input type="text" name="txtability" placeholder="special ability" value="<?php echo $v_ability;?>" style="width:20%;"><br>
						<label>สามารถปฏิบัติงานต่างจังหวัด</label><select name="cbocountry"><option value="yes">ได้/yes</option><option value="ไม่ได้/no">ไม่ได้/no</option></select><br>
						<label>กรณีฉุกเฉินบุคคลที่ติดต่อได้</label><input type="text" name="txtemergencyname" placeholder="person to notifed in case of emergency" value="<?php echo $v_emergencyname;?>" style="width:20%;">
							<label>เกี่ยวข้องเป็น</label><input type="text" name="txtemergencyrelate" placeholder="related to the applicant as" value="<?php echo $v_emergencyrelate;?>" style="width:20%;"><br>
						<label>บุคคลในบริษัทที่ท่านรู้จัก</label><input type="text" name="txtfriendname" placeholder="relatives or friends working in this company" value="<?php echo $v_friendname;?>" style="width:20%;">
							<label>เกี่ยวข้องเป็น</label><input type="text" name="txtfriendrelate" placeholder="related to the applicant as" value="<?php echo $v_friendrelate;?>"><br>
				</fieldset>
				<fieldset class="content-input">
					<legend>เอกสารที่ใช้ในการสมัคร</legend>
						<table >
							<?php
								if(empty($v_image_person)){
									echo '<tr><td>รูปถ่าย ขนาด 2 นิ้ว  ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person" id="image_person"></td></tr>';
								}else{
									echo '<tr><td>รูปถ่าย ขนาด 2 นิ้ว</td><td><a href="..'.$foldername.'/'.$v_image_person.'" target="_blank"><img src="..'.$foldername.'/'.$v_image_person.'" style="width:200px;height:200px;"></a>';
									echo "&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=image_person&id=".$_GET['id']."&del=".$v_image_person."\" onclick=\"return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?');\">[ลบ]</a></td></tr>";
								}
								if(empty($v_image_idcard)){
									echo '<tr><td>บัตรประชาชน  ( ไฟล์ jpg , png )</td><td><input type="file" name="image_idcard" id="image_idcard"></td></tr>';
								}else{
									echo '<tr><td>บัตรประชาชน</td><td><a href="..'.$foldername.'/'.$v_image_idcard.'" target="_blank"><img src="..'.$foldername.'/'.$v_image_idcard.'" style="width:200px;height:200px;"></a>';
									echo "&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=image_idcard&id=".$_GET['id']."&del=".$v_image_idcard."\" onclick=\"return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?');\">[ลบ]</a></td></tr>";
								}
								if(empty($v_image_address)){
									echo '<tr><td>ทะเบียนบ้าน  ( ไฟล์ jpg , png )</td><td><input type="file" name="image_address" id="image_address"></td></tr>';
								}else{
									echo '<tr><td>ทะเบียนบ้าน</td><td><a href="..'.$foldername.'/'.$v_image_address.'" target="_blank"><img src="..'.$foldername.'/'.$v_image_address.'" style="width:200px;height:200px;"></a>';
									echo "&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=image_address&id=".$_GET['id']."&del=".$v_image_address."\" onclick=\"return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?');\">[ลบ]</a></td></tr>";
								}
								if(empty($v_image_education)){
									echo '<tr><td>วุฒิการศึกษา  ( ไฟล์ jpg , png )</td><td><input type="file" name="image_education" id="image_education"></td></tr>';
								}else{
									echo '<tr><td>วุฒิการศึกษา</td><td><a href="..'.$foldername.'/'.$v_image_education.'" target="_blank"><img src="..'.$foldername.'/'.$v_image_education.'" style="width:200px;height:200px;"></a>';
									echo "&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=image_education&id=".$_GET['id']."&del=".$v_image_education."\" onclick=\"return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?');\">[ลบ]</a></td></tr>";
								}
								if(empty($v_image_resume)){
									echo '<tr><td>ประวัติ (resume)  ( ไฟล์ jpg , png )</td><td><input type="file" name="image_resume" id="image_resume"></td></tr>';
								}else{
									echo '<tr><td>ประวัติ (resume)</td><td><a href="..'.$foldername.'/'.$v_image_resume.'" target="_blank"><img src="..'.$foldername.'/'.$v_image_resume.'" style="width:200px;height:200px;"></a>';
									echo "&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=image_resume&id=".$_GET['id']."&del=".$v_image_resume."\" onclick=\"return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?');\">[ลบ]</a></td></tr>";
								}
				?>			
									
						
						</table>
				</fieldset>
				<fieldset class="content-input">
						<label>ผลการรับสมัคร</label>
						<select name="txtstatus_accept">
							<?php
								if($v_status_accept==0){
									echo "<option value='0' selected>รอ</option>";
									echo "<option value='1'>ตกลงจ้าง</option>";
								}	
								if($v_status_accept==1){
									echo "<option value='0' >รอ</option>";
									echo "<option value='1' selected>ตกลงจ้าง</option>";
								}
								?>
							
							
						</select><br><br>
						
						<input type="submit" name="btsave" value="<?php echo $btname;?>">
				</fieldset>
		</div>
	</form>
 </body>
</html>
