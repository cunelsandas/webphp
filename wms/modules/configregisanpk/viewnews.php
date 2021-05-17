<?php
	$table="tb_regisanpk";
	$foldername="/fileupload/regisonline/";
	$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	
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
//ลบภาพ
if(isset($_GET['del'])){
		$filenameFordel=FindRS("select * from filename where id=".$_GET['del'],"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);	
		}
		$sql="DELETE From filename Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);
		
		
}

$no = $_GET['id'];
$sql="Select * From $table Where id='$no'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$nameth=$row['nameth'];
  $age=$row['age'];
  $namestudent=$row['namestudent'];
  $nickname=$row['nickname'];
  //$birthday=ChangeYear($row['txtbirthday'],"en");
  $relation=$row['relation'];
  $level=$row['level'];
  $term=$row['term'];
  $schoolyear=$row['schoolyear'];
  $birthday=$row['birthday'];
  $birthday1=$row['birthday1'];
  //$idcarddate=ChangeYear($row['txtidcarddate'],"en");
  //$idcardexpire=ChangeYear($row['txtidcardexpire'],"en");
  $birthmonth=$row['birthmonth'];
  $birthyear=$row['birthyear'];
  $agestudent=$row['agestudent'];
  $agestudentmonth=$row['agestudentmonth'];
  $idcard=$row['idcard'];
  $race=$row['race'];
  $nationality=$row['nationality'];
  $religion=$row['religion'];
  $adress=$row['adress'];
  $moo=$row['moo'];
  $alley=$row['alley'];
  $road=$row['road'];
  $tumbol=$row['tumbol'];
  $umper=$row['umper'];
  $county=$row['county'];
  $phone=$row['phone'];
  $namefather=$row['namefather'];
  $agefather=$row['agefather'];
  $idcardfather=$row['idcardfather'];
  $adressfather=$row['adressfather'];
  $moofather=$row['moofather'];
  $tumbolfather=$row['tumbolfather'];
  $umperfather=$row['umperfather'];
  $countyfather=$row['countyfather'];
  $careerfather=$row['careerfather'];
  $officefather=$row['officefather'];
  $positionfather=$row['positionfather'];
  $phoneofficefather=$row['phoneofficefather'];
  $mobilefather=$row['mobilefather'];
  $namemother=$row['namemother'];
  $agemother=$row['agemother'];
  $idcardmother=$row['idcardmother'];
  $adressmother=$row['adressmother'];
  $moomother=$row['moomother'];
  $tumbolmother=$row['tumbolmother'];
  $umpermother=$row['umpermother'];
  $countymother=$row['countymother'];
  $careermother=$row['careermother'];
  $officemother=$row['officemother'];
  $positionmother=$row['positionmother'];

  $phoneofficemothrt=$row['phoneofficemothrt'];
  $mobilemother=$row['mobilemother'];
  $cbomaritalstatus=$row['cbomaritalstatus'];
  $parent=$row['parent'];
  $parentname=$row['parentname'];
  $parentage=$row['parentage'];
  $parentphone=$row['parentphone'];
  $parentcareer=$row['parentcareer'];
  $parentoffice=$row['parentoffice'];
  $bloodtype=$row['bloodtype'];
  $congenitaldisease=$row['congenitaldisease'];
  

  
                
              
?>

<div id="careers" style="padding: 150px 40px 60px 100px;overflow-x:auto;">
 <form name="frmAdd" method="POST" action="" enctype="multipart/form-data">
    <div class="content-box1">
      
        <fieldset class="content-input1">
          <legend><?php echo $customer_name;?></legend>
            <label>ข้าพเจ้า *</label><input type="text" name="txtnameth" id="txtnameth"  value="<?php echo $nameth;?>" style="width:50%;"><label>อายุ *</label><input type="text" name="txtage" id="txtage"  value="<?php echo $age;?>" style="width:10%;"><br><br>
            <label>มีความประสงค์ขอนำนักเรียน ชื่อ *</label><input type="text" name="txtnamestudent"  value="<?php echo $namestudent;?>" style="width:50%;"><label>ชื่อเล่น *</label><input type="text" name="txtnickname" id="txtnickname"  value="<?php echo $nickname;?>" style="width:10%;"><br><br>
            <label>เกี่ยวข้องโดยเป็น * </label><input type="text" name="txtrelation" id="txtrelation"  value="<?php echo $relation;?>">&nbsp;&nbsp;<label>ของข้าพเจ้า สมัครเข้ารับการศึกษาในโรงเรียนอนุบาลหนองป่าครั่ง ๒ ในระดับชั้น</label><input type="text" name="txtlevel" id="txtlevel"  value="<?php echo $level;?>" style="width:20%;"><br><br><label>ในภาคเรียนที่</label><input type="text" name="txtterm" id="txtterm"  value="<?php echo $term;?>" style="width:10%;"><label>ประจำปีการศึกษา</label><input type="text" name="txtschoolyear" id="txtschoolyear"  value="<?php echo $schoolyear;?>" style="width:20%;">&nbsp; <label>โดยมีข้อมูลพื้นฐานดังนี้</label><br><br>
        </fieldset>
        <fieldset class="content-input1">
          <legend>ประวัติส่วนตัวนักเรียน (student background)</legend>
            <label>นักเรียนเกิดวัน</label><input type="text" name="txtbirthday" id="txtbirthday"  value="<?php echo $birthday;?>">
            <label>ที่</label><input type="text" name="txtbirthday1"  value="<?php echo $birthday1;?>" size="15">
            <label>เดือน</label><input type="text" name="txtbirthmonth"  value="<?php echo $birthmonth;?>" size="15">
            <label>พ.ศ.</label><input type="text" name="txtbirthyear"  value="<?php echo $birthyear;?>" size="15"><br><br>
          <label>อายุ</label><input type="text" name="txtagestudent"  value="<?php echo $agestudent;?>"> &nbsp;<label>ปี</label>
            <input type="text" name="txtagestudentmonth"  value="<?php echo $agestudentmonth;?>">&nbsp; <label>เดือน</label>
            <br><br>
            <label>เลขประจำตัวประชาชน</label><input type="text" name="txtidcard"  value="<?php echo $idcard;?>">
          <label>เชื้อชาติ</label><input type="text" name="txtrace" id="txtrace"  value="<?php echo $race;?>">
            <label>สัญชาติ</label><input type="text" name="txtnationality" id="txtnationality"  value="<?php echo $nationality;?>">
            <label>นับถือศาสนา</label><input type="text" name="txtreligion"  size="10" value="<?php echo $religion;?>"><br><br>
            <label>ที่อยู่ตามทะเบียนราษฎร์เลขที่</label><input type="text" name="txtadress"  size="10" value="<?php echo $adress;?>">
            <label>หมู่</label><input type="text" name="txtmoo"  size="10" value="<?php echo $moo;?>">
            <label>ตรอก/ซอย</label><input type="text" name="txtalley"  size="10" value="<?php echo $alley;?>">
            <label>ถนน</label><input type="text" name="txtroad"  size="10" value="<?php echo $road;?>">
            <label>ตำบล</label><input type="text" name="txttumbol"  size="10" value="<?php echo $tumbol;?>">
            <label>อำเภอ</label><input type="text" name="txtumper"  size="10" value="<?php echo $umper;?>"><br><br>
            <label>จังหวัด</label><input type="text" name="txtcounty"  size="10" value="<?php echo $county;?>">
            <label>โทรศัพท์</label><input type="text" name="txtphone"  size="10" value="<?php echo $phone;?>">
            </fieldset>
            <fieldset class="content-input1">
            <legend>ผู้ปกครอง</legend>
         
          <label>ชื่อ-สกุล บิดา</label><input type="text" name="txtnamefather"  value="<?php echo $namefather;?>" style="width:20%;">
          <label>อายุ</label><input type="text" name="txtagefather"  value="<?php echo $agefather;?>">&nbsp; <label>ปี</label><br><br>
          <label>เลขประจำตัวประชาชน</label><input type="text" name="txtidcardfather"  value="<?php echo $idcardfather;?>">
            <label>อาศัยอยู่บ้านเลขที่</label><input type="text" name="txtadressfather"  value="<?php echo $adressfather;?>" >
            <label>หมู่</label><input type="text" name="txtmoofather"  value="<?php echo $moofather;?>">
            <label>ตำบล</label><input type="text" name="txttumbolfather"  value="<?php echo $tumbolfather;?>"><br><br>
          <label>อำเภอ</label><input type="text" name="txtumperfather"  value="<?php echo $umperfather;?>"><label>จังหัวด</label><input type="text" name="txtcountyfather"  value="<?php echo $countyfather;?>"><br><br>
          
            <label>อาชีพ</label><input type="text" name="txtcareerfather"  value="<?php echo $careerfather;?>">
             <label>สถานที่ทำงาน</label><input type="text" name="txtofficefather"  value="<?php echo $officefather;?>">
              <label>ตำแหน่ง</label><input type="text" name="txtpositionfather"  value="<?php echo $positionfather;?>">
               <label>โทรศัพท์(สถานที่ทำงาน)</label><input type="text" name="txtphoneofficefather"  value="<?php echo $phoneofficefather;?>">
                <label>โทรศัพท์(มือถือ)</label><input type="text" name="txtmobilefather"  value="<?php echo $mobilefather;?>"><br><br>
          <label>ชื่อ-สกุล มารดา</label><input type="text" name="txtnamemother"  value="<?php echo $namemother;?>" style="width:20%;">
          <label>อายุ</label><input type="text" name="txtagemother"  value="<?php echo $agemother;?>">&nbsp; <label>ปี</label><br><br>
          <label>เลขประจำตัวประชาชน</label><input type="text" name="txtidcardmother" p value="<?php echo $idcardmother;?>">
            <label>อาศัยอยู่บ้านเลขที่</label><input type="text" name="txtadressmother" p value="<?php echo $adressmother;?>" >
            <label>หมู่</label><input type="text" name="txtmoomother"  value="<?php echo $moomother;?>">
            <label>ตำบล</label><input type="text" name="txttumbolmother"  value="<?php echo $tumbolmother;?>"><br><br>
          <label>อำเภอ</label><input type="text" name="txtumpermother"  value="<?php echo $umpermother;?>"><label>จังหัวด</label><input type="text" name="txtcountymother"  value="<?php echo $countymother;?>"><br><br>
          
            <label>อาชีพ</label><input type="text" name="txtcareermother"  value="<?php echo $careermother;?>">
             <label>สถานที่ทำงาน</label><input type="text" name="txtofficemother"  value="<?php echo $officemother;?>">
              <label>ตำแหน่ง</label><input type="text" name="txtpositionmother"  value="<?php echo $positionmother;?>">
               <label>โทรศัพท์(สถานที่ทำงาน)</label><input type="text" name="txtphoneofficemothrt"  value="<?php echo $phoneofficemothrt;?>">
                <label>โทรศัพท์(มือถือ)</label><input type="text" name="txtmobilemother"  value="<?php echo $mobilemother;?>"><br><br>
                <?php
                 $sql="select * from tb_marital_status where id='".$cbomaritalstatus."'";
			    $rs=rsquery($sql);
			    if($rs){
			    $data=mysqli_fetch_assoc($rs);
				$marital = $data['name'];
			     }
                ?>
                 <label>สถานภาพของบิดา มารดา</label><input type="text" name="cbomaritalstatus"  value="<?php echo $marital;?>">

            <br><br>
            <label>กรณีที่บิดา มารดาแยกกันหรืออย่าร้างกัน นักเรียนอาศัยอยู่กับใคร</label><input type="text" name="txtparent" id="txtparent"  value="<?php echo $parent;?>" style="width:20%;"> <label>ชื่อ-สกุล</label><input type="text" name="txtparentname"  value="<?php echo $parentname;?>"> <label>อายุ</label><input type="text" name="txtparentage"  value="<?php echo $parentage;?>"> <label>ปี</label><br><br> <label>โทรศัพท์</label><input type="text" name="txtparentphone"  value="<?php echo $parentphone;?>">
             <label>อาชีพ</label><input type="text" name="txttxtparentcareer"  value="<?php echo $parentcareer;?>">  <label>สถานที่ทำงาน</label><input type="text" name="txtparentoffice"  value="<?php echo $parentoffice;?>"><br><br>

        </fieldset>

        <fieldset class="content-input1">
          <legend>สุขภาพนักเรียน</legend>
            <label>หมู่โลหิต กรุ๊ป</label><input type="text" name="txtbloodtype"  value="<?php echo $bloodtype;?>"><label>โรคประจำตัว</label><input type="text" name="txtcongenitaldisease"  value="<?php echo $congenitaldisease;?>">
        </fieldset>

      
        
        <fieldset class="content-input1">
            <legend>คำรับรอง</legend>
              ข้าพเจ้าขอรับรองว่า ข้อมูลกังกล่าวเป็นความจริงทุกประการ และจะให้ความร่วมมือปฏิบัติตามกฎระเบียบของโรงเรียนทุกประการโดยเคร่งครัด<br><br>
        </fieldset>
    </div>
    <?php
$strpicture="Select * from filename Where tablename='".$table."' AND masterid='$no' Order by id";
$rs=rsQuery($strpicture);
while($arr = mysqli_fetch_array($rs)){
	$fileno=substr($arr['filename'],-5,1);
	echo "<img src=..".$foldername.$arr['filename']." width=300 height=300>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br><br><br>";
}
?>
  </form>
</div>


</center>

