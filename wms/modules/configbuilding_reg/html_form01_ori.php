<html>
 <head>
  <title> คำร้องทุกข์ออนไลน์ </title>
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
	src: url('../../../font/THSarabunNew/THSarabunNew.ttf') format('truetype');
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
		background:url("../../../images/krut.jpg") no-repeat top center; 
    }
	#thfont {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		
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
        
        height: 240mm;
        outline: 2cm;
		/*background:url("http://www.sunpukwan.go.th/images/krut.jpg") no-repeat top center; */
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
		include_once("../../../connect.inc.php");
		

		if (!isset($_GET['id'])) {
		echo "ไม่พบเลขที่คำร้อง ไม่สามารถแสดงผลได้";
		exit();
		}

		$code=trim($_GET['id']);
		$result=rsQuery("Select * from tb_helpme_mas Where id=$code");
	if (!$result) {
		echo "ไม่พบคำร้องเลขที่ ". $code;
	}
	else {
		 // ออกเอกสารเป็นไอ.ที.โกลโบล อัพเดท status_print
			

		$r = mysql_fetch_assoc($result);
		$id="คำร้องออนไลน์เลขที่ ".$r['id'];
		$datepost=DateTimeThai($r['datepost']);
		$name=$r['name'];
		$address=$r['address'];
		$email=$r['email'];
		
		$detail=$r['detail'];
		$ip=$r['ip'];
		$process=FindRS("select * from tb_helpme_process where id=".$r['id'],"name");
		$result=$r['result'];
		$to="เรียน      ".$nayok_position;
		//$writeform="เขียนที่     ".$customer_name;
		$writeform="";
		$text1="ข้าพเจ้า ".$name."<br>   ที่อยู่".$address."  <br>หมายเลขไอพี ".$ip."<br>  โทรศัพท์/อีเมล์ ".$email;
		$end="จึงเรียนมาเพื่อโปรดพิจารณา";
		$title="คำร้องทุกข์ (ออนไลน์)";
		$subject=$r['subject'];
		$text2=$detail;
		
	}

;


			
			$html='<br><br><div align="center">'.$title.'</div><div align="left">'.$id.'<br>'.$datepost.'<br>'.$subject.'<br>ผู้แจ้ง'.$name.'<br>ที่อยู่'.$address.'&nbsp;&nbsp;email '.$email.'<br>'.$to.'<br><br><span style="text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$text1.'</span><br><span style="text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;'.$text2.'</span><br>';

			$html_end='<br><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$end.'</div><br><br><br><table width="100%"><tr><td width="60%">&nbsp;</td><td width="40%" align="center"></td></tr><tr><td>&nbsp;</td><td align="center"></td></tr></table>';
			$html_all=$html.$html_detail.$html_pic.$html_end;
			
			echo '<div class="page">
							<div class="subpage">
							<div id="thfont">
							<table height="100%" width="100%" border="0">
								<tr>
								<td valign="top" width="100%" height="100%">
								<table width="100%" border="0">
								<tr><td colspan="2" height="40px"></td></tr>
								<tr>
									<td width="50%">'.$id.'</td><td width="50%" align="right">สำนักงาน'.$customer_name.'</td>
								</tr>
								<tr>
									<td></td><td align="right">'.$customer_tambon.'  '.$customer_amphur.'  '.$customer_province.' </td>
								</tr>
								<tr>
									<td></td><td>วันที่ '.$datepost.'</td>
								</tr>
								<tr>
									<td colspan="2">เรื่อง&nbsp;&nbsp;&nbsp;&nbsp;'.$subject.'</td>
								</tr>
								<tr>
									<td colspan="2">เรียน&nbsp;&nbsp;&nbsp;&nbsp;'.$nayok_position.'</td>
								</tr>
								<tr>
									<td colspan="2" style="text-align:justify">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$detail.'
									
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">จึงเรียนมาเพื่อโปรดพิจารณา</td>
								</tr>
								<tr>
									<td></td>	<td align="center">ขอแสดงความนับถือ<br><BR></td>
								</tr>
								
							
								<tr>
									<td></td><td align="center">'.$text1.' </td>
								</tr>
								<tr>
									<td></td><td align="center">(ผู้แจ้ง/ร้องเรียน) </td>
								</tr>
								
							</table>
							</div>
							</div>
							</div>
							</body>
							</html>';
?>