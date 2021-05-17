 <html>
 <head>
 <title> New Document </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
	@font-face{
font-family: THSarabunNew;
src: url("../../../font/THSarabunNew/THSarabunNew.ttf") format("truetype");
font-weight: normal;
    font-style: normal;
}
    body {
    margin: 0;
    padding: 0;
    background-color: #ffffff;
	
	font-family: THSarabunNew,Tahoma ,sans-serif;
	font-size:20px;
	line-height:5.0em;
}
    
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
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
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        .page {
			font-family: THSarabunNew,Tahoma ,sans-serif;
	font-size:20px;
	line-height:2.0em;
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }


    </style></head><body>
<?php	
	
		include_once("../../../connect.inc.php");
		
		
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
			$data=mysqli_fetch_array($rs);
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

		//	$baht=bahtText($data['price']);
		//	$html_detail.=$name;
			?>
			<div class="page">
							<div class="subpage">
							<table height="100%" width="100%" border="0">
								<tr>
								<td valign="top" width="100%" height="100%">
								<table width="100%" border="0">
								<tr><td colspan="2" height="40px"></td></tr>
								<tr>
									<td width="50%">ที่ ชม ๕๕๕๐๓/ </td><td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงาน$customer_name</td>
								</tr>
								<tr>
									<td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อ.เมืองเชียงใหม่ จ.เชียงใหม่ ๕ํ๐๑๐๐</td>
								</tr>
								<tr>
									<td></td><td>วันที่</td>
								</tr>
								<tr>
									<td>เรื่อง&nbsp;&nbsp;&nbsp;&nbsp;แจ้งผลการดำเนินงาน</td><td></td>
								</tr>
								<tr>
									<td>เรียน&nbsp;&nbsp;&nbsp;&nbsp;$name</td><td></td>
								</tr>
								<tr>
									<td colspan="2">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่กองช่าง $customer_name ได้รับแจ้งจากท่านให้ดำเนินการแก้ไขปัญหาเรื่อง  $workนั้น งาน$depname กองช่าง $customer_name ได้ดำเนินการตามคำร้องดังกล่าวแล้ว&nbsp;&nbsp; เมื่อวันที่ $datefinish. '
									
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">จึงเรียนมาเพื่อโปรดทราบ</td>
								</tr>
								<tr>
									<td></td><td align="center">ขอแสดงความนับถือ</td>
								</tr>
								<tr>
									<td></td><td height="100px"></td>
								</tr>
								<tr>
									<td></td><td align="center">(&nbsp;$nayok_name&nbsp;)</td>
								</tr>
								<tr>
									<td></td><td align="center">$nayok_position</td>
								</tr>
								
								</table>
								</td>
								</tr>
								<tr>
								<td>กองช่าง <br>โทร (๐๕๓) ๒๗๖๔๙๑ ต่อ ๓๐๓<br>โทรสาร (๐๕๓) ๘๐๕๑๘๓<br>$domainname<br>E-mail : info@maehia.go.th<br>yota.maehia.go.th</td>
								</tr>
				</table>
				</div>
				</div>
				<div class="page">
				<div class="subpage">
					<table height="100%" width="100%" border="0">
					<tr><td height="33%" width="40%"></td><td width="60%"></td></tr>
					<tr><td height="33%" align="left" valign="top">กองช่าง<br>$customer_name<br>อ.เมือง<br>จ.เชียงใหม่<br>50100</td><td align="left" valign="center">ผู้รับ<br>$name<br>$add_address    หมู่ที่ $add_moo<br>ตำบล$add_tambol<br>อำเภอ$add_amphur<br>จังหวัด$add_province</td></tr>
					<tr><td height="33%"></td><td></td></tr>
				</table>
				</div>
				</div>
				
<?php
		}
			?>
			</body></html>