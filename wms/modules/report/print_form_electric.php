<?php
//error_reporting(E_ALL);
//	ini_set('error_reporting', E_ALL);
//	ini_set('display_errors',1);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> ระบบงานบริการออนไลน์ </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<style>
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
	@font-face{
	font-family: THSarabunNew;
	src: url('../../../font/thsarabunnew/thsarabunnew.ttf') format('truetype');
	font-weight: normal;
    font-style: normal;
}
    .page {
		font-family:THSarabunNew;
			font-size:20px;
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		
    }
    .subpage {
	
        padding: 0.5cm;
        
        height: 245mm;
        outline: 2cm;
	/*	background:url("http://www.itglobal.co.th/share/images/krut.jpg") no-repeat top center; */
    }
	#thfont {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		font-size:20px;
	}
	#thfont table td{
		font-size:20px;
	}
    
    @page {
		
        size: A4;
        margin: 0;
    }
    @media print {
		
		
		.page {
			font-family:THSarabunNew;
			font-size:20px;
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
		 .subpage {
	
        padding: 0.5cm;
        
        height: 245mm;
        outline: 2cm;
		/*background:url("http://www.itglobal.co.th/share/images/krut.jpg") no-repeat top center; */
    }
	#thfont {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		font-size:20px;
	}
	#thfont table td{
		font-size:20px;
	}
    }

</style>
</head><body>
<?php
session_start();
if(!isset($_SESSION['userid'])){
	echo"<meta http-equiv=\"Refresh\" content=\"0;url=main.php\" />";
	exit();
}
include_once("../../../itgmod/connect.inc.php");

$image_file='../../../images/watermark_logo.jpg';
if(!isset($_GET['tb']) and !isset($_GET['no'])){
	echo "ไม่สามารถแสดงผลได้ กรุณาตรวจสอบการเรียกข้อมูล";
}else{
	$tablename=decode64($_GET['tb']);
	
	$no=decode64($_GET['no']);
	$sql="select * from $tablename where no=$no";
	$rs=rsQuery($sql);
	$data=mysqli_fetch_assoc($rs);
	$date="วันที่  ".thaidate($data['date']);
	$name=$data['name'];
	$add_address=$data['add_address'];
	$add_moo=$data['add_moo'];
	$add_tambol1=$data['add_tambol'];
	$add_amphur1=$data['add_amphur'];
	$add_province1=$data['province'];
	$add_tambol=FindRS("select * from district Where DISTRICT_ID='$add_tambol1'","DISTRICT_NAME");
	$add_amphur=FindRS("select * from amphur Where AMPHUR_ID='$add_amphur1'","AMPHUR_NAME");
	$add_province=FindRS("select * from province Where PROVINCE_ID='$add_province1'","PROVINCE_NAME");
	$telephone=$data['telephone'];
	$email=$data['email'];
	$moo=$data['moo'];
	$post_ip=$data['post_ip'];
	$remark=$data['remark'];
	$to="เรียน      ".$nayok_position;
	$writeform="เขียนที่     ".$customer_name;
	$text1="ข้าพเจ้า ".$name."    อยู่บ้านเลขที่ ".$add_address." หมู่ที่ ".$add_moo."  ตำบล ".$add_tambol."  อำเภอ  ".$add_amphur."  จังหวัด  ".$add_province."  โทรศัพท์ ".$telephone."  หมายเลขไอพี ".$post_ip;
	$map="แผนที่แสดงจุดที่ตั้งซ่อมแซมไฟฟ้า (กรุณาเขียนแผนที่โดยละเอียด)";
	$end="จึงเรียนมาเพื่อโปรดพิจารณา";

		switch($tablename){
			case "tb_electric":
				$picfolder="../../../fileupload/electric/";
				$folder="fileupload/electric/";
				$title="คำร้องซ่อมแซมไฟฟ้าสาธารณะ  (ออนไลน์)";
				$detail=explode(';',$data['fix_with_code']);
				$subject="ขอซ่อมแซมไฟฟ้าสาธารณะ";
				$text2="มีความประสงค์ให้ ".$customer_name."  ซ่อมแซมไฟฟ้าสาธารณะ หมู่ที่ ".$moo."  ".$customer_tambon."  ".$customer_amphur."  ".$customer_province."  ดังรายละเอียดต่อไปนี้";
				break;
			case "tb_generalrequest":
				$picfolder="../../../fileupload/generalrequest/";
				
				$folder="fileupload/generalrequest/";
				$title="คำร้องทั่วไป (ออนไลน์)";
				$subject=$data['subject'];
				$detail=$data['detail'];
				$text2="มีความประสงค์ ".$detail;
				break;
		}
			
		
			
			echo '<div class="page">
							<div class="subpage">
							<div id="thfont">
							<table height="100%" width="100%" border="0" style="background:url('.$image_file.') center center  no-repeat;">
								<tr>
								<td valign="top" width="100%" height="100%">
								<table width="100%" border="0">
								<tr><td colspan="2" align="center">'.$title.'</td></tr>
								<tr><td colspan="2" height="40px">เลขคำร้อง '.$no.'</td></tr>
								<tr>
									<td width="50%"></td><td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เขียนที่สำนักงาน'.$customer_name.'</td>
								</tr>
								<tr>
									<td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr>
									<td></td><td>'.$date.'</td>
								</tr>
								<tr>
									<td colspan="2">เรื่อง&nbsp;&nbsp;&nbsp;&nbsp;'.$subject.'</td>
								</tr>
								<tr>
									<td colspan="2">เรียน&nbsp;&nbsp;&nbsp;&nbsp;'.$nayok_position.'</td>
								</tr>
								<tr>
									<td colspan="2">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$text1.'<br>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$text2.'<br>
									
									</td>
								</tr>
								<tr>
									<td colspan="2">';
										switch($tablename){
										case "tb_electric":
											foreach($detail as $fixwithcode){
												$i+="1";
												$html_detail .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$i.'  '.$fixwithcode.'<br>';
											}
					
											//$html_detail.=$map.'<br><table width="100%" border ="1" height="300"><tr><td height="300">&nbsp;</td></tr></table>';
											break;
										case "tb_infrastructure":
											$html_detail='';
											break;
									}	
										echo $html_detail;
										$strSql="select * from filename where tablename='$tablename' AND masterid='".$no."' Order by id DESC Limit 0,3";	
										$rs2=rsQuery($strSql);
										$rs2_row=mysqli_num_rows($rs2);
										//ถ้า rs2 มีข้อมูลให้แสดงภาพแบบใหม่ ถ้าเป็น0ให้แสดงภาพตาม code เก่า
										if($rs2_row>0){ 
											//$i=0;
											echo '<br><table><tr>';
											while($rs_filename=mysqli_fetch_assoc($rs2)){
												$cpic=file_exists($picfolder.$rs_filename['filename']);
												$type=strtolower(substr($rs_filename['filename'],-3));
												$strfilename=strtolower($rs_filename['filename']);
												$needle="bf";
												if($cpic){
													if($type<>"pdf"){
														if (strpos($strfilename,$needle) !== false) {
															//ถ้ามีคำว่า bf ให้แสดงรูป
															$html_pic.='<td><a href="http://www.sunpukwan.go.th/'.$folder.$rs_filename['filename'].'" target="_blank"><img src="'.$picfolder.$rs_filename['filename'].'" width="180" height="140"></a></td>';
									
														}else{
															//ถ้าไม่มีคำว่าbf ให้แสดงรูป
															//$html_pic.='';
										
														}
													}
												}
												}
											echo '</tr></table>';
										}						

								echo'</td>
								</tr>
								<tr>
									<td colspan="2" align="center">จึงเรียนมาเพื่อโปรดพิจารณา</td>
								</tr>
								<tr>
									<td></td><td align="center">ขอแสดงความนับถือ</td>
								</tr>
								<tr>
									<td></td><td height="100px"></td>
								</tr>
								<tr>
									<td></td><td align="center">(&nbsp;'.$name.'&nbsp;)</td>
								</tr>
								<tr>
									<td></td><td align="center">ผู้ร้องเรียน</td>
								</tr>
								
								</table>
								</td>
								</tr>
								
				</table>
				</div>
				</div>
				</div>';
						
}
echo "</body></html>";
?>