<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
@import url(font1/AS/THniramit.css);
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
  .stamp{
  position:relative;
    width: 100%;
   
  }

  .stamp table{
    border-collapse: collapse;
    position:absolute;
    right:0px;
    
  }
  .stamp table, .stamp th, .stamp td {
    font-size:8px;
    font-style:bold;
    border: 2px solid red;
    color:red;
    padding:2px;
  }
  .line{
    border-bottom: 1px dotted black;
    width:100px;
  }
  .newline{
    margin-left:60px;
  }
  .newline1{
    padding-left:50px;
    padding-right: 50px;
    width: 100%;
  }
  .newline20{
    padding-left:20px;
    padding-right: 20px;
    width: 100%;
  }
  .newline21{
    padding-left:20px;
    padding-right: 20px;
    width: 100%;
  }
  .newline25{
    padding-left:25px;
    padding-right: 25px;
    width: 100%;
  }
  .newline30{
    padding-left:30px;
    padding-right: 30px;
    width: 100%;
  }
    .page {
    font-family:THSarabunNew;
      font-size:24px;
        width: 8.5in;
    min-height: 14in;
        padding: 1cm;
        margin: 1cm auto;
       /* border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);*/
    
    }
    .subpage {
  
        padding: 0.5cm;
        
        height: 13in;
        outline: 2cm;
    background:url("../../images/logo_big.jpg") no-repeat center 220px;
    text-align:justify;
    
    }
  #thfont {
    font-family: THSarabunNew,Tahoma ,sans-serif;
    font-size:12px;
  }
  #thfont table td{
    font-size:12px;
  }
    
    @page {
     width: 8.5in;
    height: 14in;
        size: Legal;
        margin: 0;
    }
    @media print {
    
    
    .page {
      font-family:THSarabunNew;
      font-size:22px;
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after:auto ;

        }
     .subpage {
  
        padding: 0.5cm;
        
       
    height: 12in;
    /*    outline: 2cm; */
    background:url("../../images/logo_big.jpg") no-repeat center 220px;
    text-align:justify;
    }
  #thfont {
    font-family: THSarabunNew,Tahoma ,sans-serif;
    font-size:12px;
  }
  #thfont table , td{
    font-size:12px;
  }
  p{
     page-break-after: always;
  }
   .newline{
    margin-left: 60px;

  }
  .newline1{
    padding-left:50px;
    padding-right: 50px;
 text-decoration: underline;
  }
  .newline20{
    padding-left:15px;
    padding-right: 15px;
    width: 100%;
     text-decoration: underline;
  }
  .newline21{
    padding-left:15px;
    padding-right: 15px;
    width: 100%;
     
  }
  .newline25{
    padding-left:15px;
    padding-right: 15px;
    width: 100%;
     text-decoration: underline;
  }
  .newline30{
    padding-left:15px;
    padding-right: 15px;
    width: 100%;
     text-decoration: underline;
  }
    }
/*---*/
 

</style>
 </head>
<?php
  function thaidateFull($vardate) { 
  $_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",  
    "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",  
    "07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",  
    "10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");
  
  
  $yy=substr($vardate,0,4);
  $mm=substr($vardate,5,2);
  $dd=substr($vardate,8,2);

  $yy += 543;
  if ($yy==543){
    $dateT = "-";
  }else{
    $dateT=$dd ." เดือน ".$_month_name[$mm]."  พ.ศ. ".$yy;
   }
  return $dateT;
} 
    //include_once("itgmod/connect.inc.php");
    
   /* if(isset($_GET['id'])){
    $tablename=decode64($_GET['tb']);
    $f_id=decode64($_GET['id']);
    $sql="select * from $tablename where id=$f_id";
    $rs=rsQuery($sql);
    if($rs){
      $Adata=mysqli_fetch_array($rs);
      $v_planfee=ThaiNum($Adata['planfee']);
      $v_docfee=ThaiNum($Adata['docfee']);
      
      $v_authorityname=$Adata['authorityname'];

      //$v_datestart=ThaiNum(thaidateFull($Adata['datestart']));
      //$v_dateend=ThaiNum(thaidateFull($Adata['dateend']));
      $v_datestart="............ เดือน .................................. พ.ศ. ....................";
      $v_dateend="............ เดือน .................................. พ.ศ. ....................";
      $v_calno=ThaiNum($Adata['calno']);
      $v_docno=ThaiNum($Adata['docno']);
      $v_docyear=ThaiNum($Adata['docyear']);
      
      $Bcode=$Adata['buildingcode'];
      $sql="select * from tb_building1 where code='$Bcode'";
      $rs1=rsQuery($sql);
      if($rs1){
      $data=mysqli_fetch_assoc($rs1);
      $v_id=$data['id'];
      $v_date=DateThai($data['date']);
      $v_date_create=$data['date_create'];
      $v_code=$data['code'];
      $v_name=$data['name'];
      $v_tel=$data['tel'];
      $v_email=$data['email'];
    
      $v_address1=ThaiNum($data['address1']);
      $v_moo1=ThaiNum($data['moo1']);
      $v_tambol1=FindRS("select * from district Where DISTRICT_ID='".$data['tambol1']."'","DISTRICT_NAME");
      $v_amphur1=FindRS("select * from amphur Where AMPHUR_ID='".$data['amphur1']."'","AMPHUR_NAME");
      $v_province1=FindRS("select * from province Where PROVINCE_ID='".$data['province1']."'","PROVINCE_NAME");
      $v_soi1=$data['soi1'];
      $v_road1=$data['road1'];
    
      $v_address2=$data['address2'];
      $v_moo2=$data['moo2'];
      $v_tambol2=FindRS("select * from district Where DISTRICT_ID='".$data['tambol2']."'","DISTRICT_NAME");
      $v_amphur2=FindRS("select * from amphur Where AMPHUR_ID='".$data['amphur2']."'","AMPHUR_NAME");
      $v_province2=FindRS("select * from province Where PROVINCE_ID='".$data['province2']."'","PROVINCE_NAME");
      $v_soi2=$data['soi2'];
      $v_road2=$data['road2'];

      $v_address3=$data['address3'];
      $v_moo3=$data['moo3'];
      $v_tambol3=FindRS("select * from district Where DISTRICT_ID='".$data['tambol3']."'","DISTRICT_NAME");
      $v_amphur3=FindRS("select * from amphur Where AMPHUR_ID='".$data['amphur3']."'","AMPHUR_NAME");
      $v_province3=FindRS("select * from province Where PROVINCE_ID='".$data['province3']."'","PROVINCE_NAME");
      $v_soi3=$data['soi3'];
      $v_road3=$data['road3'];

      $v_address4=ThaiNum($data['address4']);
      $v_moo4=ThaiNum($data['moo4']);
      $v_tambol4=FindRS("select * from district Where DISTRICT_ID='".$data['tambol4']."'","DISTRICT_NAME");
      $v_amphur4=FindRS("select * from amphur Where AMPHUR_ID='".$data['amphur4']."'","AMPHUR_NAME");
      $v_province4=FindRS("select * from province Where PROVINCE_ID='".$data['province4']."'","PROVINCE_NAME");
      $v_soi4=$data['soi4'];
      $v_road4=$data['road4'];

      $v_btype=$data['btype'];
      $v_bdate=$data['bdate'];
      $v_bid=$data['bid'];
      $v_name3=$data['name3'];

      $v_doctype=$data['doctype'];
      $v_building_owner=$data['building_owner'];
      $v_land_id=ThaiNum($data['land_id']);
      $v_land_owner=$data['land_owner'];
      $v_building_type=ThaiNum($data['building_type']);

      $v_building_type1=ThaiNum($data['building_type1']);
      $v_building_unit1=ThaiNum($data['building_unit1']);
      $v_building_for1=$data['building_for1'];
      $v_building_size1=ThaiNum($data['building_size1']);
      $v_building_car1=ThaiNum($data['building_car1']);
    
      $v_building_type2=ThaiNum($data['building_type2']);
      $v_building_unit2=ThaiNum($data['building_unit2']);
      $v_building_for2=$data['building_for2'];
      $v_building_size2=ThaiNum($data['building_size2']);
      $v_building_car2=ThaiNum($data['building_car2']);

      $v_building_type3=ThaiNum($data['building_type3']);
      $v_building_unit3=ThaiNum($data['building_unit3']);
      $v_building_for3=$data['building_for3'];
      $v_building_size3=ThaiNum($data['building_size3']);
      $v_building_car3=ThaiNum($data['building_car3']);
    
      $v_forman1=ThaiNum($data['forman1']);
      $v_forman2=ThaiNum($data['forman2']);
      $v_workday=$data['workday'];

      $v_remark=$data['remark'];
    
      $v_post_ip=$data['post_ip'];
      $lat=$data['latitude'];
      $lng=$data['longitude'];
      }
    }
  }*/
  $no = $_GET['id'];
  $sql = "select * from tb_regisanpk where id = '".$no."' ";
  $rs = rsQuery($sql);
  if($rs){
    $data = mysqli_fetch_array($rs);
    $nameth=$data['nameth'];
  $age=$data['age'];
  $namestudent=$data['namestudent'];
  $nickname=$data['nickname'];
  //$birthday=ChangeYear($data['birthday'],"en");
  $relation=$data['relation'];
  $level=$data['level'];
  $term=$data['term'];
  $schoolyear=$data['schoolyear'];
  $birthday=$data['birthday'];
  $birthday1=$data['birthday1'];
  //$idcarddate=ChangeYear($data['idcarddate'],"en");
  //$idcardexpire=ChangeYear($data['idcardexpire'],"en");
  $birthmonth=$data['birthmonth'];
  $birthyear=$data['birthyear'];
  $agestudent=$data['agestudent'];
  $agestudentmonth=$data['agestudentmonth'];
  $idcard=$data['idcard'];
  $race=$data['race'];
  $nationality=$data['nationality'];
  $religion=$data['religion'];
  $adress=$data['adress'];
  $moo=$data['moo'];
  $alley=$data['alley'];
  $road=$data['road'];
  $tumbol=$data['tumbol'];
  $umper=$data['umper'];
  $county=$data['county'];
  $phone=$data['phone'];
  $namefather=$data['namefather'];
  $agefather=$data['agefather'];
  $idcardfather=$data['idcardfather'];
  $adressfather=$data['adressfather'];
  $moofather=$data['moofather'];
  $tumbolfather=$data['tumbolfather'];
  $umperfather=$data['umperfather'];
  $countyfather=$data['countyfather'];
  $careerfather=$data['careerfather'];
  $officefather=$data['officefather'];
  $positionfather=$data['positionfather'];
  $phoneofficefather=$data['phoneofficefather'];
  $mobilefather=$data['mobilefather'];
  $namemother=$data['namemother'];
  $agemother=$data['agemother'];
  $idcardmother=$data['idcardmother'];
  $adressmother=$data['adressmother'];
  $moomother=$data['moomother'];
  $tumbolmother=$data['tumbolmother'];
  $umpermother=$data['umpermother'];
  $countymother=$data['countymother'];
  $careermother=$data['careermother'];
  $officemother=$data['officemother'];
  $positionmother=$data['positionmother'];

  $phoneofficemothrt=$data['phoneofficemothrt'];
  $mobilemother=$data['mobilemother'];
  $cbomaritalstatus=$data['cbomaritalstatus'];
  $parent=$data['parent'];
  $parentname=$data['parentname'];
  $parentage=$data['parentage'];
  $parentphone=$data['parentphone'];
  $parentcareer=$data['parentcareer'];
  $parentoffice=$data['parentoffice'];
  $bloodtype=$data['bloodtype'];
  $congenitaldisease=$data['congenitaldisease'];


  if($parentage == 0){
    $parentage1 = "-";
  }
  if ($parent = " ") {
    $parent1 = "-";
  }
  if ($parentname = " ") {
    $parentname1= "-";
  }
  if ($parentphone =" ") {
    $parentphone1= "-";
  }
   if ($parentcareer =" ") {
    $parentcareer1= "-";
  }
   if ($parentoffice =" ") {
    $parentoffice1= "-";
  }

  }

  $sql1 = "select * from tb_marital_status where id = '".$cbomaritalstatus."' ";
  $rss = rsQuery($sql1);
  $data1 = mysqli_fetch_array($rss);
  $name = $data1['name'];
?>
 <body>
 <div class="page">
  <div class="subpage" style="position:relative; width: 100%">
  <span style="position:absolute;top:-10px;right:0px; border-style: solid;
    border-width: medium;width: 2cm;height: 3cm;text-align: center;padding-top: 15px;">ติดรูปถ่าย <br>ขนาด 1 นิ้ว</span>
    <span style="position:absolute;top:-10px;left: :0px;"><img src="img/logo.jpg" width="110px" height="110px"></span>
  <div style="position:absolute;width:95%;" align="center">

    <span style="position:relative;font-size:20px;color:red;"></span>
    
  </div>
   <table width="100%" border="0">
    <!--<tr>
      <td align="center"><img src="../../images/krut.jpg"></td>
    </tr>-->
    <tr>
      <td align="center" width="100%" style="font-size:23px;"><strong>ใบสมัครเข้าโรงเรียนอนุบาลหนองป่าครั่ง<br>เทศบาลตำบลหนองป่าครั่ง อำเภอเมืองเชียงใหม่ จังหวัดเชียงใหม่</strong></td>
    </tr>

  </table>
  <br>
    <div style="float: right;">เขียนที่............................... <br>วันที่........ เดือน........ พ.ศ.........</div><br>
    <br>
    <span class="newline">ข้าพเจ้า(นาย,นาง,นางสาว,อื่นๆ)</span><span class="newline1"><?php echo $nameth;?></span>อายุ
    <span class="newline1"><?php echo $age;?></span>ปี<br>มีความประสงค์ขอนำบุตร/หลาน ชื่อ (ด.ช,ด.ญ)<span class="newline1"><?php echo $namestudent;?></span>ชื่อเล่น<span class="newline1"><?php echo $nickname;?></span><br>เกี่ยวข้องโดยเป็น<span class="newline20"><?php echo $relation;?></span>ของข้าพเจ้าสมัครเข้ารับการศึกษาในโรงเรียนอนุบาลหนองป่าครั่ง 2<br>
    ในระดับชั้นอนุบาลที่<span class="newline1"><?php echo $level;?></span>ในภาคเรียนที่<span class="newline20"><?php echo $term;?></span>ประจำปีการศึกษา<span class="newline20"><?php echo $schoolyear;?></span>
    <br>
    โดยมีข้อมูลดังนี้
    <br>
      <span class="newline">นักเรียนเกิดวัน</span><span class="newline20"><?php echo $birthday;?></span>ที่<span class="newline20"><?php echo $birthday1;?></span>เดือน<span class="newline20"><?php echo $birthmonth;?></span>พ.ศ.<?php echo $birthyear;?>&nbsp;&nbsp;อายุ<span class="newline20"><?php echo $agestudent;?></span>ปี<span class="newline20"><?php echo $agestudentmonth;?></span>เดือน
      <br>
      เลขประจำตัวประชาชน<span class="newline25"><?php echo $idcard;?></span>เชื้อชาติ<span class="newline25"><?php echo $race;?></span>สัญชาติ<span class="newline25"><?php echo $nationality;?></span>นับถือศาสนา<span class="newline25"><?php echo $religion;?></span><br>
      ที่อยู่ตามทะเบียนราษฎร์เลขที่<span class="newline30"><?php echo $adress;?></span>หมู่<span class="newline30"><?php echo $moo;?></span>ตรอก/ซอย<span class="newline30"><?php echo $alley;?></span>ถนน<span class="newline30"><?php echo $road;?></span><br>
      ตำบล<span class="newline30"><?php echo $tumbol;?></span>อำเภอ<span class="newline30"><?php echo $umper;?></span>จังหวัด<span class="newline30"><?php echo $county;?></span>โทรศัพท์<span class="newline30"><?php echo $phone;?></span>
    <br>
    <strong><u>ผู้ปกครอง</u></strong><span class="newline21">บิดาชื่อ</span><span class="newline25"><?php echo $namefather;?></span>อายุ <span class="newline25"><?php echo $agefather;?>ปี</span>เลขประจำตัวประชาชน<span style="padding-left: 15px;padding-right:20px;"><?php echo $idcardfather;?></span><br>อาศัยอยู่บ้านเลขที่<span class="newline25"><?php echo $adressfather;?></span>หมู่<span class="newline25"><?php echo $moofather;?></span>ตำบล<span class="newline25"><?php echo $tumbolfather;?></span>อำเภอ<span class="newline25"><?php echo $umperfather;?></span>จังหวัด<span style="padding-left: 5px;padding-right:25px;"><?php echo $countyfather;?></span><br>อาชีพ<span class="newline30"><?php echo $careerfather;?></span>สถานที่ทำงาน<span class="newline30"><?php echo $officefather;?></span>ตำแหน่ง<span class="newline30"><?php echo $positionfather;?></span><br>โทรศัพท์(สถานที่ทำงาน)<span class="newline30"><?php echo $phoneofficefather;?></span>โทรศัพท์(มือถือ)<span class="newline25"><?php echo $mobilefather;?></span><br>
      <span class="newline">มารดาชื่อ</span><span class="newline20"><?php echo $namemother;?></span>อายุ<span class="newline20"><?php echo $agemother;?>ปี</span>เลขประจำตัวประชาชน<span class="newline20"><?php echo $idcardmother;?></span><br>อาศัยอยู่บ้านเลขที่<span class="newline25"><?php echo $adressmother;?></span>หมู่<span class="newline25"><?php echo $moomother;?></span>ตำบล<span class="newline25"><?php echo $tumbolmother;?></span>อำเภอ<span class="newline25"><?php echo $umpermother;?></span>จังหวัด<span class="newline25"><?php echo $countymother;?></span><br>อาชีพ<span class="newline30"><?php echo $careermother;?></span>สถานที่ทำงาน<span class="newline30"><?php echo $officemother;?></span>ตำแหน่ง<span class="newline30"><?php echo $positionmother;?></span><br></span>โทรศัพท์(สถานที่ทำงาน)<span class="newline30"><?php echo $phoneofficemothrt;?></span>โทรศัพท์(มือถือ)<span class="newline30"><?php echo $mobilemother;?></span><br>

      <strong>สถานภาพของบิดา มารดา</strong><span class="newline30"><?php echo $name;?></span><br>
      กรณีบิดา มารดา แยกหรืออย่าร้างกัน นักเรียนอาศัยอยู่กับใคร<span class="newline30"><?php echo $parent1;?></span><br>ชื่อ-สกุล<span class="newline30"><?php echo $parentname1;?></span>อายุ<span class="newline30"><?php echo $parentage1;?></span>ปี
      โทรศัพท์<span class="newline30"><?php echo $parentphone1;?></span><br>อาชีพ<span class="newline30"><?php echo $parentcareer1;?></span>สถานที่ทำงาน<span class="newline30"><?php echo $parentoffice1;?></span>

    <br>
    <strong>สุขภาพของนักเรียน</strong><br>
    ๑.หมู่โลหิต<span class="newline30"><?php echo $bloodtype;?></span>๒.โรคประจำตัว<span class="newline30"><?php echo $congenitaldisease;?></span><br>

    <strong>คำรับรอง</strong><br>
      <span class="newline"><strong>ข้าพเจ้ารับรองว่า ข้อมูลดังกล่าวเป็นความความจริงทุกประการ และจะใช้ความร่วมมือปฏิบัติตามกฎระเบียบของโรงเรียนทุกประการโดยเคร่งครัด</strong></span><br>
<div style="float: left;">ลงชื่อ......................................ผู้ปกครอง <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(......................................)</div>
<div style="float: right;">ลงชื่อ.....................................ผู้รับสมัคร <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(......................................)</div>
 </body>
</html>
