<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> รายงานอุบัติเหตุ </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="รายงานอุบัติเหตุ">
  <meta name="Description" content="">
  <link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
<!-- datepicker thai year -->
<!--- <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script> -->
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

	  $("#txtdatestart").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#txtdateend").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	  $("#txtdateout").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	});
</script>
<SCRIPT LANGUAGE="Javascript" SRC="FusionCharts/FusionCharts.js"></SCRIPT>
 </head>

 <body>

	<?php
		include_once("FusionCharts/FusionCharts.php");
		$tablename="tb_accident";
		if(isset($_POST['btsearch'])){
		$datestart=ChangeYear($_POST['txtdatestart'],"en");
		$dateend=ChangeYear($_POST['txtdateend'],"en");
		$strYear = date("Y",strtotime($datestart));
		
		$graphtype=$_POST['cbograph'];
		$graphWidth="700";
		$graphHeight="300";
		$caption="สรุปอุบัติเหตุจำแนกตามประเภท";
		$subcaption="ระหว่างวันที่.".DateThai($datestart)." ถึงวันที่ ".DateThai($dateend);
		$numbersuffix=" ครั้ง";  //หน่วยนับ
		$caption_y="ประเภท";  // แกนy แนวตั้ว  แสดงเป็นภาษาไทยไม่ได้
		$caption_x="ประเภท";  // แกน x แนวนอน

		$graphtype2=$_POST['cbograph'];
		$graphWidth2="700";
		$graphHeight2="300";
		$caption2="สรุปอุบัติเหตุจำแนกตามสถานที่เกิดเหตุ";
		$subcaption2=$subcaption;
		$numbersuffix2=" ครั้ง";  //หน่วยนับ
		$caption_y2="ประเภท";  // แกนy แนวตั้ว  แสดงเป็นภาษาไทยไม่ได้
		$caption_x2="หมู่ที่";  // แกน x แนวนอน

		$graphtype3=$_POST['cbograph'];
		$graphWidth3="700";
		$graphHeight3="300";
		$caption3="สรุปอุบัติเหตุจำแนกตามช่วงเวลาเกิดเหตุ";
		$subcaption3=$subcaption;
		$numbersuffix3=" ครั้ง";  //หน่วยนับ
		$caption_y3="ช่วงเวลา";  // แกนy แนวตั้ว  แสดงเป็นภาษาไทยไม่ได้
		$caption_x3="จำนวน";  // แกน x แนวนอน

		$graphtype4=$_POST['cbograph'];
		$graphWidth4="700";
		$graphHeight4="300";
		$caption4="สรุปอุบัติเหตุจำแนกตาจำนวนผู้บาดเจ็บ";
		$subcaption4=$subcaption;
		$numbersuffix4=" ราย";  //หน่วยนับ
		$caption_y4="ประเภท";  // แกนy แนวตั้ว  แสดงเป็นภาษาไทยไม่ได้
		$caption_x4="จำนวน";  // แกน x แนวนอน

		$strSql="select type,count(id) as sumtype from $tablename where date between '$datestart' And '$dateend' Group By type Order by type";
		$strsql1=$strSql;
		$strSql2="select moo,count(id) as summoo from $tablename where date between '$datestart' And '$dateend' Group By moo Order by moo";
		$strsql2=$strSql2;

		$strSql3="select time,count(id) as sumtime from $tablename where date between '$datestart' And '$dateend' Group By time Order by time";
		$strsql3=$strSql3;

		$strSql4="select month(date) as summonth,sum(sick) as sumsick,sum(injure) as suminjure,sum(dead) as sumdead from $tablename where year(date)='$strYear' Group By summonth Order by summonth";
		$strsql4=$strSql4;

		}
	?>
	<br>
	<center>
	<form name="frm01" method="POST" action="" >
		<table id="master-table">
			<tr>
				<th colspan="2">ข้อมูลสถิติการเกิดอุบัติเหตุ</th>
			</tr>
			<tr><td align="right">เลือกวันที่</td><td><input type="text" name="txtdatestart" id="txtdatestart" size="20">&nbsp;&nbsp;ถึงวันที่&nbsp;<input type="text" name="txtdateend" id="txtdateend"></td></tr>
			<tr>
								<td align="right">รูปแบบการแสดงกราฟ</td><td><select name="cbograph">
									<option value="Pie3D">กราฟวงกลม 3D</option>
									<option value="Column2D">กราฟแท่ง 2 มิติ</option>
									<option value="Column3D">กราฟแท่ง 3 มิติ</option>
									</select>
									</td>
								</tr>
			<tr><td></td><td><input type="submit" name="btsearch" value="ค้นหา"></td></tr>
		</table>
	</form>
	</center>
	
	<div id="chart">
	<?php
    
    $animateChart = $_GET['animate'];
    //Set default value of 1
    if ($animateChart==""){
        $animateChart = "1";
	}
    //$strXML will be used to store the entire XML document generated
    //Generate the chart element 
		$strXML = "<chart caption='$caption' subCaption='$subcaption' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix='$numbersuffix' xAxisName='$caption_x' yAxisName='$caption_y'  animation=' " .$animateChart. "' baseFont='Tahoma' baseFontSize ='12'>";
		//$strsql="select count(id) as countid,status,sum(id) as sumid from docin where docyear='$docyear' group by status";
		$rs=rsQuery($strsql1);
		if($rs){
			while($data1=mysqli_fetch_assoc($rs)){
				$statusname=FindRS("select * from tb_accident_type where id=".$data1['type'],"name");
			//	$strXML.="<set label='".$statusname."' value='".$data1['countid']."'>";
				 $strXML.="<set label='".$statusname."' value='".$data1['sumtype']."' />";
			}
		}
		 //Finally, close <chart> element
		$strXML .= "</chart>";
		  //Create the chart - Pie 3D Chart with data from strXML
			 echo renderChart("FusionCharts/$graphtype.swf", "", $strXML, "type", $graphWidth, $graphHeight, false, false);
			
		//echo renderChartHTML("FusionCharts/$graphtype.swf", "", $strXML, "FactorySum", $graphWidth, $graphHeight, false);
?>
</div>
<?php
		echo "<div id='master-table' align='center'>";
		echo "<table>";
		echo "<tr><th>ประเภท</th><th>จำนวน</th></tr>";
		$rs=rsQuery($strSql);
		if($rs){
			while($data=mysqli_fetch_assoc($rs)){
				$type=$data['type'];
				$typename=FindRS("select name from tb_accident_type where id=$type","name");
				$sumtype=$data['sumtype'];
				echo "<tr><td>$typename</td><td>$sumtype</td></tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	?>

<br>
<div id="chart">
	<?php
    
    $animateChart = $_GET['animate'];
    //Set default value of 1
    if ($animateChart==""){
        $animateChart = "1";
	}
    //$strXML will be used to store the entire XML document generated
    //Generate the chart element 
		$strXML = "<chart caption='$caption2' subCaption='$subcaption2' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix='$numbersuffix2' xAxisName='$caption_x2' yAxisName='$caption_y2'  animation=' " .$animateChart. "' baseFont='Tahoma' baseFontSize ='12'>";
		//$strsql="select count(id) as countid,status,depname from docin where docyear='$docyear' group by depname";
		$rs=rsQuery($strsql2);
		if($rs){
			while($data1=mysqli_fetch_assoc($rs)){
				$statusname=FindRS("select * from tb_accident_moo where id=".$data1['moo'],"name");

			//	$strXML.="<set label='".$statusname."' value='".$data1['countid']."'>";
				 $strXML.="<set label='".$statusname."' value='".$data1['summoo']."' />";
			}
		}
		 //Finally, close <chart> element
		$strXML .= "</chart>";
		  //Create the chart - Pie 3D Chart with data from strXML
			 echo renderChart("FusionCharts/$graphtype.swf", "", $strXML, "moo", $graphWidth, $graphHeight, false, false);
		//echo renderChartHTML("FusionCharts/$graphtype.swf", "", $strXML, "FactorySum", $graphWidth, $graphHeight, false);
?>
</div>
<?php
		echo "<div id='master-table' align='center'>";
		echo "<table>";
		echo "<tr><th>หมู่่ที่</th><th>จำนวน</th></tr>";
		$rs=rsQuery($strSql2);
		if($rs){
			while($data=mysqli_fetch_assoc($rs)){
				$type=$data['moo'];
				$typename=FindRS("select * from tb_accident_moo where id='$type'","name");
				$sumtype=$data['summoo'];
				echo "<tr><td>$typename</td><td>$sumtype</td></tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	?>

	<br>
<div id="chart">
	<?php
    //We also keep a flag to specify whether we've to animate the chart or not.
    //If the user is viewing the detailed chart and comes back to this page, he shouldn't
    //see the animation again.
    $animateChart = $_GET['animate'];
    //Set default value of 1
    if ($animateChart==""){
        $animateChart = "1";
	}
    //$strXML will be used to store the entire XML document generated
    //Generate the chart element 
		$strXML = "<chart caption='$caption3' subCaption='$subcaption3' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix='$numbersuffix3' xAxisName='$caption_x3' yAxisName='$caption_y3'  animation=' " .$animateChart. "' baseFont='Tahoma' baseFontSize ='12'>";
		//$strsql="select count(id) as countid,status,depname from docin where docyear='$docyear' group by depname";
		$rs=rsQuery($strsql3);
		if($rs){
			while($data1=mysqli_fetch_assoc($rs)){
				//$statusname=$data1['moo'];
				$statusname=FindRS("select * from tb_accident_time where id=".$data1['time'],"name");
			//	$strXML.="<set label='".$statusname."' value='".$data1['countid']."'>";
				 $strXML.="<set label='".$statusname."' value='".$data1['sumtime']."' />";
			}
		}
		 //Finally, close <chart> element
		$strXML .= "</chart>";
		  //Create the chart - Pie 3D Chart with data from strXML
			 echo renderChart("FusionCharts/$graphtype.swf", "", $strXML, "time", $graphWidth, $graphHeight, false, false);
		//echo renderChartHTML("FusionCharts/$graphtype.swf", "", $strXML, "FactorySum", $graphWidth, $graphHeight, false);
?>
</div>
<?php
		echo "<div id='master-table' align='center'>";
		echo "<table>";
		echo "<tr><th>ช่วงเวลาเกิดเหตุ</th><th>จำนวน</th></tr>";
		$rs=rsQuery($strSql3);
		if($rs){
			while($data=mysqli_fetch_assoc($rs)){
			
				$type=$data['time'];
				$typename=FindRS("select name from tb_accident_time where id=$type","name");
				$sumtype=$data['sumtime'];
				echo "<tr><td>$typename</td><td>$sumtype</td></tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	?>

		<br>
<div id="chart">
	<?php
    //We also keep a flag to specify whether we've to animate the chart or not.
    //If the user is viewing the detailed chart and comes back to this page, he shouldn't
    //see the animation again.
    $animateChart = $_GET['animate'];
    //Set default value of 1
    if ($animateChart==""){
        $animateChart = "1";
	}
    //$strXML will be used to store the entire XML document generated
    //Generate the chart element 
		$strXML = "<chart caption='$caption4' subCaption='$subcaption4' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix='$numbersuffix4' xAxisName='$caption_x4' yAxisName='$caption_y4'  animation=' " .$animateChart. "' baseFont='Tahoma' baseFontSize ='12'>";
		//$strsql="select count(id) as countid,status,depname from docin where docyear='$docyear' group by depname";
		$rs=rsQuery($strsql4);
		if($rs){
			while($data1=mysqli_fetch_assoc($rs)){
				//$statusname=$data1[''];
			//	$strXML.="<set label='".$statusname."' value='".$data1['countid']."'>";
				 $strXML.="<set label='ผู้ป่วย' value='".$data1['sumsick']."' />";
				$strXML.="<set label='ผู้บาดเจ็บ' value='".$data1['suminjure']."' />";
				$strXML.="<set label='ผู้เสียชีวิต' value='".$data1['sumdead']."' />";
			}
		}
		 //Finally, close <chart> element
		$strXML .= "</chart>";
		  //Create the chart - Pie 3D Chart with data from strXML
			 echo renderChart("FusionCharts/$graphtype.swf", "", $strXML, "sick4", $graphWidth, $graphHeight, false, false);
		//echo renderChartHTML("FusionCharts/$graphtype.swf", "", $strXML, "FactorySum", $graphWidth, $graphHeight, false);
?>
</div>
<?php
		echo "<div id='master-table' align='center'>";
		echo "<table>";
		echo "<tr><th>เดือน</th><th>ผู้ป่วย</th><th>ผู้บาดเจ็บ</th><th>ผู้เสียชีวิต</th><th>รวม</th></tr>";
		
		$rs=rsQuery($strSql4);
		if($rs){
			while($data=mysqli_fetch_assoc($rs)){
				
				$type=$data['summonth'];
				
				$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
				$typename=$strMonthCut[$type];
				$sumsick=$data['sumsick'];
				$suminjure=$data['suminjure'];
				$sumdead=$data['sumdead'];
				$total=$sumsick+$suminjure+$sumdead;
				$totalsick+=$sumsick;
				$totalinjure+=$suminjure;
				$totaldead+=$sumdead;
				$sumtotal+=$total;
				echo "<tr><td>$typename</td><td>$sumsick</td><td>$suminjure</td><td>$sumdead</td><td>$total</td></tr>";
			}
				echo "<tr><td></td><td>$totalsick</td><td>$totalinjure</td><td>$totaldead</td><td>$sumtotal</td></tr>";
		}
		echo "</table>";
		echo "</div>";
	?>
 </body>
</html>
