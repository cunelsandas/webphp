<?php
//error_reporting(E_ALL); //สำหรับเช็ค error
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors',1);
date_default_timezone_set('Asia/Bangkok');  //วันเวลาให้เป็นของไทย
####################### connect database ##########################

$gloActivity_fileno = 20;  // เก็บค่าจำนวนไฟล์ในการอัพโหลด
$gloNews_fileno = 6;
$gloPurchase_fileno = 3;
$gloOtop_fileno = 6;
$gloTravel_fileno = 6;
$gloDownloadform_fileno = 1;
$gloFile_fileno = 6;
$gloGoverment_fileno = 1; //ส่วนราชการ
$gloHeader_fileno = 1;  //ผู้บริหาร
$gloOfficer_fileno = 1;  //เจ้าหน้าที่
$gloBoard_fileno = 1;  //สมาชิก
$gloTip_fileno = 3;  //สาระน่าร

$onemb = 1048576;  // 1 mb = 1,048,576 bytes

$gloPicture_filesize = $onemb * 5;  // กำหนดขนาดรูปภาพ
$gloData_filesize = $onemb * 50;  // กำหนดขนาดไฟล์เอกสารต่างๆ  	1 MB = 1,048,576 bytes

$gloFullSlideshow = 0; // 0 ไม่ใช้ Full slider ,1 ใช้ Full slider
$gloFullSlideshow_fileno = 10;  // จำนวนภาพที่แสดงในหน้าแรกของ FullSlider
$gloFullSlide_width = "1180px";  //กำหนดขนาดความว้างภาพ slide show
$gloFullSlide_height = "450px";  // กำนหดขนาดความสูง slide show

$glo_youtube_width = "340";  // กำหนดความกว่างไฟล์ youtube หน่วย px
$glo_youtube_height = "300";

$gloSlideshow_fileno = 20;  // จำนวนภาพที่แสดงในหน้าแรกของ Slideshow
$gloSlide_width = "750px";  //กำหนดขนาดความว้างภาพ slide show
$gloSlide_height = "350px";  // กำนหดขนาดความสูง slide show

$gloUploadPath = "fileupload";  //โฟลเดอร์เก็บข้อมูล

//ตัวแปรเก็บข้อมูลลูกค้า
$customer_name = "เทศบาลตำบลไม้ยา";
$customer_tambon = "ไม้ยา";
$customer_amphur = "พญาเม็งราย";
$customer_province = "เชียงราย";
$customer_postcode = "57290";
$customer_address = "";
$customer_tel = "<br>E-Mail : ";
$domainname = "songkwae.go.th";            // ไม่ต้องมี www
$nayok_position = "นายกเทศมนตรีตำบลไม้ยา";
$nayok_name = "นายเอนก ไกลถิ่น";
$palad_name = "";
$showdate = "yes"; //แสดงวันที่กำกับ ค่าคือ yes/no
$head_background = "<img src=images/head_bg.jpg width=950 height=250>";
$startdate = "17/08/2562";  //วันเริ่มนับสถิติ

$egp_code = '5571201'; // รหัสองค์กร
$egp_color = '33ccff'; // รหัสสีไม่ต้องมี #
$egp_height = '500'; // ความสูงของ content

$customer_lat = "19.7306582";
$customer_lng = "100.1179988";


# Connect database
$g_user = "root";
$g_pw = '';
$g_db = "web29900";



include_once("myfnc.php");


?>