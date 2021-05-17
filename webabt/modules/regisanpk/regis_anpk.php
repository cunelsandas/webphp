
    <link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> 


  <!-- datepicker thai year -->
 <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>


<?php
  
  
//  include_once("../../itgmod/connect.inc.php");
  $tablename="tb_regisanpk";
  $limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
  $SizeInMb=round(($limitsize/$onemb));
  $foldername="/fileupload/regisonline/";

  $btname="addnew";
  if(isset($_POST['btsave'])){
    $chkver=$_SESSION['vervalue'];
  if($chkver!=$_POST['txtver']){
    echo"คุณกรอกรหัสยืนยันไม่ตรงกับภาพ กรุณาตรวจสอบ";
  }else{
  //$dateregis=date("Y-m-d H:i:s");
  $nameth=$_POST['txtnameth'];
  $age=$_POST['txtage'];
  $namestudent=$_POST['txtnamestudent'];
  $nickname=$_POST['txtnickname'];
  //$birthday=ChangeYear($_POST['txtbirthday'],"en");
  $relation=$_POST['txtrelation'];
  $level=$_POST['txtlevel'];
  $term=$_POST['txtterm'];
  $schoolyear=$_POST['txtschoolyear'];
  $birthday=$_POST['txtbirthday'];
  $birthday1=$_POST['txtbirthday1'];
  //$idcarddate=ChangeYear($_POST['txtidcarddate'],"en");
  //$idcardexpire=ChangeYear($_POST['txtidcardexpire'],"en");
  $birthmonth=$_POST['txtbirthmonth'];
  $birthyear=$_POST['txtbirthyear'];
  $agestudent=$_POST['txtagestudent'];
  $agestudentmonth=$_POST['txtagestudentmonth'];
  $idcard=$_POST['txtidcard'];
  $race=$_POST['txtrace'];
  $nationality=$_POST['txtnationality'];
  $religion=$_POST['txtreligion'];
  $adress=$_POST['txtadress'];
  $moo=$_POST['txtmoo'];
  $alley=$_POST['txtalley'];
  $road=$_POST['txtroad'];
  $tumbol=$_POST['txttumbol'];
  $umper=$_POST['txtumper'];
  $county=$_POST['txtcounty'];
  $phone=$_POST['txtphone'];
  $namefather=$_POST['txtnamefather'];
  $agefather=$_POST['txtagefather'];
  $idcardfather=$_POST['txtidcardfather'];
  $adressfather=$_POST['txtadressfather'];
  $moofather=$_POST['txtmoofather'];
  $tumbolfather=$_POST['txttumbolfather'];
  $umperfather=$_POST['txtumperfather'];
  $countyfather=$_POST['txtcountyfather'];
  $careerfather=$_POST['txtcareerfather'];
  $officefather=$_POST['txtofficefather'];
  $positionfather=$_POST['txtpositionfather'];
  $phoneofficefather=$_POST['txtphoneofficefather'];
  $mobilefather=$_POST['txtmobilefather'];
  $namemother=$_POST['txtnamemother'];
  $agemother=$_POST['txtagemother'];
  $idcardmother=$_POST['txtidcardmother'];
  $adressmother=$_POST['txtadressmother'];
  $moomother=$_POST['txtmoomother'];
  $tumbolmother=$_POST['txttumbolmother'];
  $umpermother=$_POST['txtumpermother'];
  $countymother=$_POST['txtcountymother'];
  $careermother=$_POST['txtcareermother'];
  $officemother=$_POST['txtofficemother'];
  $positionmother=$_POST['txtpositionmother'];

  $phoneofficemothrt=$_POST['txtphoneofficemothrt'];
  $mobilemother=$_POST['txtmobilemother'];
  $cbomaritalstatus=$_POST['cbomaritalstatus'];
  $parent=$_POST['txtparent'];
  $parentname=$_POST['txtparentname'];
  $parentage=$_POST['txtparentage'];
  $parentphone=$_POST['txtparentphone'];
  $parentcareer=$_POST['txttxtparentcareer'];
  $parentoffice=$_POST['txtparentoffice'];
  $bloodtype=$_POST['txtbloodtype'];
  $congenitaldisease=$_POST['txtcongenitaldisease'];
  
 
    
        $strsql="insert into $tablename(
            nameth,
            age,
            namestudent,
            nickname,
            relation,
            level,
            term,
            schoolyear,
            birthday,
            birthday1,
            birthmonth,
            birthyear,
            agestudent,
            agestudentmonth,
            idcard,
            race,
            nationality,
            religion,
            adress,
            moo,
            alley,
            road,
            tumbol,
            umper,
            county,
            phone,
            namefather,
            agefather,
            idcardfather,
            adressfather,
            moofather,
            tumbolfather,
            umperfather,
            countyfather,
            careerfather,
            officefather,
            positionfather,
            phoneofficefather,
            mobilefather,
            namemother,
            agemother,
            idcardmother,
            adressmother,
            moomother,
            tumbolmother,
            umpermother,
            countymother,
            careermother,
            officemother,
            positionmother,
            phoneofficemothrt,
            mobilemother,
            cbomaritalstatus,
            parent,

            parentname,
            parentage,
            parentphone,
            parentcareer,
            parentoffice,
            bloodtype,
            congenitaldisease
            )
            Values(
            '$nameth',
            '$age',
            '$namestudent',
            '$nickname',
            '$relation',
            '$level',
            '$term',
            '$schoolyear',
            '$birthday',
            '$birthday1',
            '$birthmonth',
            '$birthyear',
            '$agestudent',
            '$agestudentmonth',
            '$idcard',
            '$race',
            '$nationality',
            '$religion',
            '$adress',
            '$moo',
            '$alley',
            '$road',
            '$tumbol',
            '$umper',
            '$county',
            '$phone',
            '$namefather',
            '$agefather',
            '$idcardfather',
            '$adressfather',
            '$moofather',
            '$tumbolfather',
            '$umperfather',
            '$countyfather',
            '$careerfather',
            '$officefather',
            '$positionfather',
            '$phoneofficefather',
            '$mobilefather',
            '$namemother',
            '$agemother',
            '$idcardmother',
            '$adressmother',
            '$moomother',
            '$tumbolmother',
            '$umpermother',
            '$countymother',
            '$careermother',
            '$officemother',
            '$positionmother',
            '$phoneofficemothrt',
            '$mobilemother',
            '$cbomaritalstatus',
            '$parent',

            '$parentname',
            '$parentage',
            '$parentphone',
            '$parentcareer',
            '$parentoffice',
            '$bloodtype',
            '$congenitaldisease'
            )";
  
     
    
    
  
  }
  $rs=rsQuery($strsql);
  if($rs){
    $sql="Select * From $tablename Order by id DESC limit 0,1";
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
              
              
             

        //อัพรูปถ่ายผู้สมัคร2
  if(!empty($_FILES['image_person2']['name'])){
    $file_person=$_FILES['image_person2']['name'];
    $size_person=$_FILES['image_person2']['size'];
    $type_person=strtolower(substr($file_person,-4));
    $image_person=$_FILES['image_person2']['tmp_name'];
    $name_person=$tablename.'_'.$id.'_person2'.$type_person;
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
    //สำเนาสูติบัตรนักเรียน
  if(!empty($_FILES['image_person3']['name'])){
    $file_person=$_FILES['image_person3']['name'];
    $size_person=$_FILES['image_person3']['size'];
    $type_person=strtolower(substr($file_person,-4));
    $image_person=$_FILES['image_person3']['tmp_name'];
    $name_person=$tablename.'_'.$id.'_person3'.$type_person;
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

        //สำเนาทะเบียนบ้านมีชื่อนักเรียน
  if(!empty($_FILES['image_person4']['name'])){
    $file_person=$_FILES['image_person4']['name'];
    $size_person=$_FILES['image_person4']['size'];
    $type_person=strtolower(substr($file_person,-4));
    $image_person=$_FILES['image_person4']['tmp_name'];
    $name_person=$tablename.'_'.$id.'_person4'.$type_person;
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
   //สำเนาใบเปลี่ยนชื่อ-สกุลนักเรียน
  if(!empty($_FILES['image_person5']['name'])){
    $file_person=$_FILES['image_person5']['name'];
    $size_person=$_FILES['image_person5']['size'];
    $type_person=strtolower(substr($file_person,-4));
    $image_person=$_FILES['image_person5']['tmp_name'];
    $name_person=$tablename.'_'.$id.'_person5'.$type_person;
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
  //สมุดบันทึกสุขภาพนักเรียน (เล่มชมพู/ฟ้า)
  if(!empty($_FILES['image_person6']['name'])){
    $file_person=$_FILES['image_person6']['name'];
    $size_person=$_FILES['image_person6']['size'];
    $type_person=strtolower(substr($file_person,-4));
    $image_person=$_FILES['image_person6']['tmp_name'];
    $name_person=$tablename.'_'.$id.'_person6'.$type_person;
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
  //สำเนาบัตรประชาชน บิดา มารดา
  if(!empty($_FILES['image_person7']['name'])){
    $file_person=$_FILES['image_person7']['name'];
    $size_person=$_FILES['image_person7']['size'];
    $type_person=strtolower(substr($file_person,-4));
    $image_person=$_FILES['image_person7']['tmp_name'];
    $name_person=$tablename.'_'.$id.'_person7'.$type_person;
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
  //สำเนาทะเบียนบ้าน บิดา มารดา
  if(!empty($_FILES['image_person8']['name'])){
    $file_person=$_FILES['image_person8']['name'];
    $size_person=$_FILES['image_person8']['size'];
    $type_person=strtolower(substr($file_person,-4));
    $image_person=$_FILES['image_person8']['tmp_name'];
    $name_person=$tablename.'_'.$id.'_person8'.$type_person;
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
   
     }        
            

    echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href=\"index.php?_mod=cmVnaXNvbmxpbmU\";</script>";
  }
}


  
  
?>
 <div id="careers" style="padding: 150px 40px 60px 100px;overflow-x:auto;">
  <center><h2 style="color:#E8DD96;">ใบสมัครออนไลน์</h2></center>
 <form name="frmAdd" method="POST" action="" enctype="multipart/form-data">
    <div class="content-box1">
      
        <fieldset class="content-input1">
          <legend><?php echo $customer_name;?></legend>
            <label>ข้าพเจ้า *</label><input type="text" name="txtnameth" id="txtnameth"  value="<?php echo $v_nameth;?>" style="width:50%;"><label>อายุ *</label><input type="text" name="txtage" id="txtage"  value="<?php echo $v_nameth;?>" style="width:10%;"><br>
            <label>มีความประสงค์ขอนำนักเรียน ชื่อ *</label><input type="text" name="txtnamestudent"  value="<?php echo $v_nametn;?>" style="width:50%;"><br><br><label>ชื่อเล่น *</label><input type="text" name="txtnickname" id="txtnickname"  value="<?php echo $v_nameth;?>" style="width:10%;">
            <label>เกี่ยวข้องโดยเป็น * </label><input type="text" name="txtrelation" id="txtrelation"  value="<?php echo $v_position;?>">&nbsp;&nbsp;<label>ของข้าพเจ้า สมัครเข้ารับการศึกษาในโรงเรียนอนุบาลหนองป่าครั่ง ๒ ในระดับชั้น</label><input type="text" name="txtlevel" id="txtlevel"  value="<?php echo $v_salary;?>" style="width:20%;"><label>ในภาคเรียนที่</label><input type="text" name="txtterm" id="txtterm"  value="<?php echo $v_salary;?>" style="width:10%;"><label>ประจำปีการศึกษา</label><input type="text" name="txtschoolyear" id="txtschoolyear"  value="<?php echo $v_salary;?>" style="width:20%;">&nbsp;<br> <br><br><br><br><label>โดยมีข้อมูลพื้นฐานดังนี้</label><br>
        </fieldset>
        <fieldset class="content-input1">
          <legend>ประวัติส่วนตัวนักเรียน (student background)</legend>
            <label>นักเรียนเกิดวัน</label><input type="text" name="txtbirthday" id="txtbirthday"  value="<?php echo $v_birthday;?>">
            <label>ที่</label><input type="text" name="txtbirthday1"  value="<?php echo $v_race;?>" size="15">
            <label>เดือน</label><input type="text" name="txtbirthmonth"  value="<?php echo $v_nationality;?>" size="15"><br><br>
            <label>พ.ศ.</label><input type="text" name="txtbirthyear"  value="<?php echo $v_religion;?>" size="15">
          <label>อายุ</label><input type="text" name="txtagestudent"  value="<?php echo $v_idcard;?>"> &nbsp;<label>ปี</label>
            <input type="text" name="txtagestudentmonth"  value="<?php echo $v_idcardamphur;?>">&nbsp; <label>เดือน</label>
            <br><br>
            <label>เลขประจำตัวประชาชน</label><input type="text" name="txtidcard"  value="<?php echo $v_idcardprovince;?>">
          <label>เชื้อชาติ</label><input type="text" name="txtrace" id="txtrace"  value="<?php echo $v_idcarddate;?>"><br><br>
            <label>สัญชาติ</label><input type="text" name="txtnationality" id="txtnationality"  value="<?php echo $v_idcardexpire;?>">
            <label>นับถือศาสนา</label><input type="text" name="txtreligion"  size="10" value="<?php echo $v_height;?>"><br><br>
            <label>ที่อยู่ตามทะเบียนราษฎร์เลขที่</label><input type="text" name="txtadress"  size="10" value="<?php echo $v_weight;?>">
            <label>หมู่</label><input type="text" name="txtmoo"  size="10" value="<?php echo $v_weight;?>">
            <label>ตรอก/ซอย</label><input type="text" name="txtalley"  size="10" value="<?php echo $v_weight;?>"><br><br>
            <label>ถนน</label><input type="text" name="txtroad"  size="10" value="<?php echo $v_weight;?>">
            <label>ตำบล</label><input type="text" name="txttumbol"  size="10" value="<?php echo $v_weight;?>">
            <label>อำเภอ</label><input type="text" name="txtumper"  size="10" value="<?php echo $v_weight;?>">
            <label>จังหวัด</label><input type="text" name="txtcounty"  size="10" value="<?php echo $v_weight;?>"><br><br>
            <label>โทรศัพท์</label><input type="text" name="txtphone"  size="10" value="<?php echo $v_weight;?>">
            </fieldset>
            <fieldset class="content-input1">
            <legend>ผู้ปกครอง</legend>
         
          <label>ชื่อ-สกุล บิดา</label><input type="text" name="txtnamefather"  value="<?php echo $v_spousename;?>" style="width:20%;">
          <label>อายุ</label><input type="text" name="txtagefather"  value="<?php echo $v_spouseoccupation;?>">&nbsp;<label>ปี</label> <br><br>
          <label>เลขประจำตัวประชาชน</label><input type="text" name="txtidcardfather"  value="<?php echo $v_spouseaddress;?>">
            <label>อาศัยอยู่บ้านเลขที่</label><input type="text" name="txtadressfather"  value="<?php echo $v_spouserace;?>" ><br><br>
            <label>หมู่</label><input type="text" name="txtmoofather"  value="<?php echo $v_spousenationality;?>">
            <label>ตำบล</label><input type="text" name="txttumbolfather"  value="<?php echo $v_spousereligion;?>">
          <label>อำเภอ</label><input type="text" name="txtumperfather"  value="<?php echo $v_children;?>"><br><br><label>จังหัวด</label><input type="text" name="txtcountyfather"  value="<?php echo $v_children;?>">
          
            <label>อาชีพ</label><input type="text" name="txtcareerfather"  value="<?php echo $v_fatheroccupation;?>">
             <label>สถานที่ทำงาน</label><input type="text" name="txtofficefather"  value="<?php echo $v_fatheroccupation;?>">
              <label>ตำแหน่ง</label><input type="text" name="txtpositionfather"  value="<?php echo $v_fatheroccupation;?>">
               <label>โทรศัพท์(สถานที่ทำงาน)</label><input type="text" name="txtphoneofficefather"  value="<?php echo $v_fatheroccupation;?>"><br><br><br>
                <label>โทรศัพท์(มือถือ)</label><input type="text" name="txtmobilefather"  value="<?php echo $v_fatheroccupation;?>"><br><br><hr style="margin-bottom: 10px;">
          <label>ชื่อ-สกุล มารดา</label><input type="text" name="txtnamemother"  value="<?php echo $v_spousename;?>" style="width:20%;">
          <label>อายุ</label><input type="text" name="txtagemother"  value="<?php echo $v_spouseoccupation;?>">&nbsp;<label>ปี</label> <br><br>
          <label>เลขประจำตัวประชาชน</label><input type="text" name="txtidcardmother" p value="<?php echo $v_spouseaddress;?>">
            <label>อาศัยอยู่บ้านเลขที่</label><input type="text" name="txtadressmother" p value="<?php echo $v_spouserace;?>" ><br><br>
            <label>หมู่</label><input type="text" name="txtmoomother"  value="<?php echo $v_spousenationality;?>">
            <label>ตำบล</label><input type="text" name="txttumbolmother"  value="<?php echo $v_spousereligion;?>">
          <label>อำเภอ</label><input type="text" name="txtumpermother"  value="<?php echo $v_children;?>"><br><br><label>จังหัวด</label><input type="text" name="txtcountymother"  value="<?php echo $v_children;?>">
          
            <label>อาชีพ</label><input type="text" name="txtcareermother"  value="<?php echo $v_fatheroccupation;?>">
             <label>สถานที่ทำงาน</label><input type="text" name="txtofficemother"  value="<?php echo $v_fatheroccupation;?>">
              <label>ตำแหน่ง</label><input type="text" name="txtpositionmother"  value="<?php echo $v_fatheroccupation;?>">
               <label>โทรศัพท์(สถานที่ทำงาน)</label><input type="text" name="txtphoneofficemothrt"  value="<?php echo $v_fatheroccupation;?>"><br><br><br>
                <label>โทรศัพท์(มือถือ)</label><input type="text" name="txtmobilemother"  value="<?php echo $v_fatheroccupation;?>"><br><br><br>
                 <label>สถานภาพของบิดา มารดา</label>
            <select name="cbomaritalstatus" style="float: left;">
              <?php
                $sql="select * from tb_marital_status";
                $rs=rsquery($sql);
                if($rs){
                while($data=mysqli_fetch_assoc($rs)){
                  echo "<option value='".$data['id']."'>".$data['name']."</option>";
                }
                }
              ?>
            </select><br><br>
            <label>กรณีที่บิดา มารดาแยกกันหรืออย่าร้างกัน นักเรียนอาศัยอยู่กับใคร</label><input type="text" name="txtparent" id="txtparent"  value="<?php echo $v_salary;?>" style="width:20%;"><br><br> <label>ชื่อ-สกุล</label><input type="text" name="txtparentname"  value="<?php echo $v_fatheroccupation;?>"> <label>อายุ</label><input type="text" name="txtparentage"  value="<?php echo $v_fatheroccupation;?>"> <label>ปี</label> <label>โทรศัพท์</label><input type="text" name="txtparentphone"  value="<?php echo $v_fatheroccupation;?>"><br><br>
             <label>อาชีพ</label><input type="text" name="txttxtparentcareer"  value="<?php echo $v_fatheroccupation;?>" style="padding-left: 10px;">  <label>สถานที่ทำงาน</label><input type="text" name="txtparentoffice"  value="<?php echo $v_fatheroccupation;?>"><br>

        </fieldset>

        <fieldset class="content-input1">
          <legend>สุขภาพนักเรียน</legend>
            <label>หมู่โลหิต กรุ๊ป</label><input type="text" name="txtbloodtype"  value="<?php echo $v_fatheroccupation;?>"><label>โรคประจำตัว</label><input type="text" name="txtcongenitaldisease"  value="<?php echo $v_fatheroccupation;?>">
        </fieldset>

      
        <fieldset class="content-input1">
          <legend>เอกสารที่ใช้ในการสมัคร</legend>
            <table >
              <tr><td>รูปถ่าย ขนาด 1 นิ้ว ใบที่1 * ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person" id="image_person"></td></tr>
              <tr><td>รูปถ่าย ขนาด 1 นิ้ว ใบที่2 * ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person2" id="image_person2"></td></tr>
              <tr><td> สำเนาสูติบัตรนักเรียน  * ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person3" id="image_person3"></td></tr>
              <tr><td>สำเนาทะเบียนบ้านมีชื่อนักเรียน * ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person4" id="image_person4"></td></tr>
              <tr><td>สำเนาใบเปลี่ยนชื่อ-สกุลนักเรียน  ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person5" id="image_person5"></td></tr>
              <tr><td>สมุดบันทึกสุขภาพนักเรียน (เล่มชมพู/ฟ้า) * ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person6" id="image_person6"></td></tr>
              <tr><td>สำเนาบัตรประชาชน บิดา มารดา * ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person7" id="image_person7"></td></tr>
              <tr><td>สำเนาทะเบียนบ้าน บิดา มารดา * ( ไฟล์ jpg , png )</td><td><input type="file" name="image_person8" id="image_person8"></td></tr>


             
 
 

 
 

            </table>
        </fieldset>
        <fieldset class="content-input1">
            <legend>คำรับรอง</legend>
              ข้าพเจ้าขอรับรองว่า ข้อมูลกังกล่าวเป็นความจริงทุกประการ และจะให้ความร่วมมือปฏิบัติตามกฎระเบียบของโรงเรียนทุกประการโดยเคร่งครัด<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<img src="http://'.$domainname.'/itgmod/verify_image.php">';?>&nbsp;&nbsp;ป้อนตัวเลขให้เหมือน<br>
            <input type="number" name="txtver" ><br><br>
            <input type="submit" name="btsave" value="บันทึกข้อมูล" onclick="return CheckField();" >&nbsp;&nbsp;<br><br><span style="color: red">* </span> กรุณาตรวจสอบความถูกต้องก่อนกดบันทึก
        </fieldset>
    </div>
  </form>
</div>
 <script>
  function CheckField(){
      if(document.getElementById('txtnameth').value==""){
          alert('กรุณาป้อนชื่อก่อน');
          
          document.getElementById('txtnameth').focus();
          return false;
      }
        if( document.getElementById('txtposition').value=="" ){
          alert('กรุณาป้อนตำแหน่งที่ต้องการสมัครงานก่อน');
          document.getElementById('txtposition').focus();
          return false;
        }
        if (document.getElementById('txtsalary').value=="")
        {
          alert('กรุณาป้อนเงินเดือนที่ต้องการ');
          document.getElementById('txtsalary').focus();
          return false;
        } 
         if (document.getElementById('txtemail').value=="")
         {
          alert('กรุณาป้อนอีเมล์สำหรับติดต่อกลับ');
           document.getElementById('txtemail').focus();
           return false;
         }  
        if ( document.getElementById('txtmobile').value=="")
        {
          alert('ป้อนหมายเลขโทรศัพท์มือถือ');
           document.getElementById('txtmobile').focus();
           return false;

        }
        if ( document.getElementById('image_person').value=="")
        {
          alert('อัพโหลดรูปภาพของท่านก่อนส่งข้อมูล');
           document.getElementById('image_person').focus();
           return false;

        }
        if ( document.getElementById('image_person2').value=="")
        {
          alert('อัพโหลดรูปภาพของท่านก่อนส่งข้อมูล');
           document.getElementById('image_person2').focus();
           return false;

        }
        if ( document.getElementById('image_person3').value=="")
        {
          alert('อัพโหลดรูปภาพของท่านก่อนส่งข้อมูล');
           document.getElementById('image_person3').focus();
           return false;

        }
        if ( document.getElementById('image_person4').value=="")
        {
          alert('อัพโหลดรูปภาพของท่านก่อนส่งข้อมูล');
           document.getElementById('image_person4').focus();
           return false;

        }
        if ( document.getElementById('image_person6').value=="")
        {
          alert('อัพโหลดรูปภาพของท่านก่อนส่งข้อมูล');
           document.getElementById('image_person6').focus();
           return false;

        }
        if ( document.getElementById('image_person7').value=="")
        {
          alert('อัพโหลดรูปภาพของท่านก่อนส่งข้อมูล');
           document.getElementById('image_person7').focus();
           return false;

        }
        if ( document.getElementById('image_person8').value=="")
        {
          alert('อัพโหลดรูปภาพของท่านก่อนส่งข้อมูล');
           document.getElementById('image_person8').focus();
           return false;

        }
        if ( document.getElementById('image_idcard').value=="")
        {
          alert('อัพโหลดภาพถ่ายบัตรประชาชนก่อน');
           document.getElementById('image_idcard').focus();
           return false;

        }
        return true;
      }
 </script>


