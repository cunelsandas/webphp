<?php
session_start();
if(!isset($_SESSION['userid'])){
	echo"<meta http-equiv=\"Refresh\" content=\"0;url=main.php\" />";
	exit();
}
include_once("../../../connect.inc.php");

require_once("../../../tcpdf/startPDF.php");

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
				$subject="เรื่อง      ขอซ่อมแซมไฟฟ้าสาธารณะ";
				$text2="มีความประสงค์ให้ ".$customer_name."  ซ่อมแซมไฟฟ้าสาธารณะ หมู่ที่ ".$moo."  ".$customer_tambon."  ".$customer_amphur."  ".$customer_province."  ดังรายละเอียดต่อไปนี้";
				break;
			case "tb_infrastructure":
				$picfolder="../../../fileupload/infrastructure/";
				
				$folder="fileupload/infrastructure/";
				$title="คำร้องทั่วไป (ออนไลน์)";
				$subject="เรื่อง     ".$data['subject'];
				$detail=$data['detail'];
				$text2="มีความประสงค์ ".$detail;
				break;
		}

			$pdf->AddPage();
			$image_file='../../../images/watermark_logo.jpg';
			$pdf->Image($image_file,80,140,'','', '', '', '', false, 300, '', false, false, 0);

			$html='<div align="center">'.$title.'</div><br><table width="100%"><tr><td width="70%">&nbsp;</td><td width="30%">'.$writeform.'</td></tr><tr><td>&nbsp;</td><td>'.$date.'</td></tr></table><br><div align="left">'.$subject.'<br><br>'.$to.'<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$text1.'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$text2.'<br>';
			
			switch($tablename){
			case "tb_electric":
					
				foreach($detail as $fixwithcode){
						$i+="1";
						$html_detail .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$i.'  '.$fixwithcode.'<br>';
				}
					
						$html_detail.=$map.'<br><table width="100%" border ="1" height="300"><tr><td height="300">&nbsp;</td></tr></table>';
				break;
			case "tb_infrastructure":
				    $html_detail='';
				break;
	}
					$strSql="select * from filename where tablename='$tablename' AND masterid='".$no."' Order by id DESC Limit 0,3";	
					$rs2=rsQuery($strSql);
					$rs2_row=mysqli_num_rows($rs2);
					//ถ้า rs2 มีข้อมูลให้แสดงภาพแบบใหม่ ถ้าเป็น0ให้แสดงภาพตาม code เก่า
					if($rs2_row>0){ 
						//$i=0;
						$html_pic='<br><table><tr>';
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
						$html_pic.='</tr></table>';
					}
			$html_end='<br><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$end.'</div><br><br><br><table width="100%"><tr><td width="60%">&nbsp;</td><td width="40%" align="center">ลงชื่อ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$name.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ร้อง</td></tr></table>';
			$html_all=$html.$html_detail.$html_pic.$html_end;
			// output the HTML content
			$pdf->writeHTML($html_all, true, false, true, false, '');

			//Close and output PDF document
			$pdf->Output('yota_formGL_no_'.$no.'.pdf', 'I');
}
?>