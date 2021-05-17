<?php
		
		include_once("../../../connect.inc.php");
		require_once("../../../tcpdf/startPDF.php");
		
		if(isset($_GET['no'])){
			
			$no=decode64($_GET['no']);
			$tablename=decode64($_GET['tb']);
			switch($tablename){
				case "tb_electric":
					$picfolder="../../../fileupload/electric/";
					$depname="ไฟฟ้าสาธารณะ";
					$work="บำรุงรักษา  ซ่อมแซมไฟฟ้าสาธารณะนั้น";
					break;
				case "tb_infrastructure":
					$picfolder="../../../fileupload/infrastructure/";
					$depname="สาธารณูปโภค";
					$work="บำรุงรักษา  ซ่อมแซมสาธารณูปโภคนั้น";
					break;
			}
			$sql="select * from $tablename where no=$no";
			$rs=rsQuery($sql);
			$data=mysqli_fetch_assoc($rs);
			$date=thaidate($data['date']);
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
			$datefinish=thaidate($data['datefinish']);
			$subject=$data['subject'];
			$status=$data['status'];
			$result=$data['result'];
			$officer=$data['officer'];
			$position=FindRS("select * from tb_officer where name='$officer'","position");
			$statusname=FindRS("select * from tb_status where id=".$status,"name");
			$to="เรียน      ".$nayok_position;
			if($tablename=="tb_electric"){
				$light=empty($data['light'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หลอดไฟขนาด ".$data['light']." วัตต์&nbsp;&nbsp;";
				$lightno=empty($data['lightno'])?"":"จำนวน ".$data['lightno']." หลอด<br>";
				$starter=empty($data['starter'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สตาร์ทเตอร์ จำนวน ".$data['starter']." อัน<br>";
				$ballard=empty($data['ballard'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บัลลาสต์ จำนวน ".$data['ballard']." อัน<br>";
				$lamp=empty($data['lamp'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;โคมไฟ จำนวน ".$data['lamp']." โคม<br>";
				$wired=empty($data['wired'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สายไฟ จำนวน ".$data['wired']." เมตร<br>";
				$other=empty($data['other'])?"":"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อื่นๆ ".$data['other']."<br>";
				$strdo="โดยใช้อุปกรณ์ดังนี้<br>".$light.$lightno.$starter.$ballard.$lamp.$wired.$other;
			}else{
				$strdo="เห็นควร........................................................................................................................................................................................................<br>........................................................................................................................................................................................................................<br>";
			}
			$pdf->AddPage();
			
			$image_file='../../../images/watermark_logo.jpg';
			$pdf->Image($image_file,80,80,'','', '', '', '', false, 300, '', false, false, 0);
			$html='
				<style>
			span.box1 { 
				font-size:15pt;
				font-family:Tahoma;
				padding-left:15pt;
				border:1px solid red;
				overflow:hidden;
				}	
			span.box2 { 
				font-size:10pt;
				font-family:Tahoma;
				padding-left:15;

				border:1px solid green;
				overflow:hidden;
				}
			span.box3 { 
				font-size:5px;
				font-family:Tahoma;
				padding-left:5px;
				border:1px solid blue;
				overflow:hidden;
				}
				</style>
				<body>
			<div align="center" style="font-size:20px;">รายงานผลการดำเนินการแก้ไข'.$depname.'</div><br>
			'.$to.'<br>
			อ้างถึงคำร้อง ลงวันที่ '.$date.'<br>
			<span style="width:100%;word-wrap: break-word;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่'.$name.'ได้ยื่นคำร้องให้งาน'.$depname .'  ดำเนินการแก้ไขปัญหาเรื่อง  '.$work.'</span><br>
			<span style="text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; งาน'.$depname.' กองช่าง ได้ดำเนินการตามคำร้องดังกล่าวแล้ว&nbsp;&nbsp; เมื่อวันที่ '.$datefinish. '  ผลปรากฏว่า</span><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$statusname.'<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$result.'<br>
			'.$strdo.'<br>	ทั้งนี้ได้แจ้งผลการดำเนินงานให้แก่ผู้ขอ หรือผู้แทนได้ทราบ<br><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดทราบ<br><br>
			<table width="100%"><tr>
			
			<td width="100%" border="0">
			<div align="center">
			ลงชื่อ .......................................................................เจ้าหน้าที่ผู้ควบคุมงาน<br>
			(&nbsp;&nbsp;'.$officer.'&nbsp;&nbsp;)<br>'.$position.'</div>
			</td>
			</tr></table>
			<div align="center" style="font-size:12pt;"></div>
			<table width="100%" border="1">
			<tr><td width=50% style="border-right-style:solid;border-width:1px;font-size:16px;">เรียน '.$nayok_position.'<br>- เพื่อโปรดพิจารณา<br><br><br><br>
			<div align="center">
			ลงชื่อ.......................................................ผอ.กองช่าง<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;'.$headofficer.'&nbsp;)<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><BR><BR>
			ลงชื่อ.......................................................ปลัดเทศบาล<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;'.$paladname.'&nbsp;)<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
			</div></td>
			<td width="50%" style="border-top-style:solid;border-width:1px;font-size:16px;">คำสั่ง<br>
			&nbsp;&nbsp;<table width="10" height="10"><tr><td width="10" height="10" border="1">&nbsp;</td><td border="0" width="50">&nbsp;ทราบ</td></tr>
			<tr><td border="0" colspan="2" height="1">&nbsp;</td></tr>
			<tr><td border="1">&nbsp;</td><td border="0" width="150">&nbsp;..................................................</td></tr></table><br><br>
			<br>
			&nbsp;&nbsp;ลงชื่อ.........................................................รองนายกฯ<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(    '.$boardname.'    )<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><BR><BR>
			ลงชื่อ.......................................................'.$nayok_position.'<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;'.$nayok_name.'&nbsp;)<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
			
	</td></tr></table></body>';

			$pdf->writeHTML($html, true, false, true, false, '');
			
			$pdf->AddPage();
			$image_file='../../../images/watermark_logo.jpg';
			$pdf->Image($image_file,80,100,'','', '', '', '', false, 300, '', false, false, 0);
			$strSql="select * from filename where tablename='$tablename' AND masterid='".$no."' Order by id DESC Limit 0,3";	
					$rs2=mysqli_query($strSql);
					$rs2_row=mysqli_num_rows($rs2);
					//ถ้า rs2 มีข้อมูลให้แสดงภาพแบบใหม่ ถ้าเป็น0ให้แสดงภาพตาม code เก่า
					$html_pic='<body><p>ภาพถ่ายผลการดำเนินการ ตามคำร้อง</p><br>';
					if($rs2_row>0){ 
						//$i=0;
						$html_pic.='<br><table><tr>';
						while($rs_filename=mysqli_fetch_assoc($rs2)){
		
							$cpic=file_exists($picfolder.$rs_filename['filename']);
							$type=strtolower(substr($rs_filename['filename'],-3));
							$strfilename=strtolower($rs_filename['filename']);
							$needle="bf";
						if($cpic){
								if($type<>"pdf"){
									if (strpos($strfilename,$needle) !== false) {
										//ถ้ามีคำว่า bf ให้แสดงรูป
										
										$html_pic.='<td>ก่อนดำเนินการ<a href="http://yota.maehia.go.th/'.$picfolder.$rs_filename['filename'].'" target="_blank"><img src="'.$picfolder.$rs_filename['filename'].'" width="180" height="140"></a></td>';
									
									}else{
										//ถ้าไม่มีคำว่าbf ให้แสดงรูป
										$html_pic.='<td>หลังดำเนินการ<a href="http://yota.maehia.go.th/'.$picfolder.$rs_filename['filename'].'" target="_blank"><img src="'.$picfolder.$rs_filename['filename'].'" width="180" height="140"></a></td>';
										
									}
								}
							}
						}
						$html_pic.='</tr></table>';
					}
				$html_pic.='</body>';
				$pdf->writeHTML($html_pic, true, false, true, false, '');
			//Close and output PDF document
			$pdf->Output('report_gl_no_'.$no.'.pdf', 'I');
		}
  ?>