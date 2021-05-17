<?php

error_reporting(0);
	$num_yaer = array();


$sql = "SELECT * FROM tb_welfare_request WHERE confirmdate !=''";

if (isset($_POST['btsave']) != "") {
	$year = $_POST['frm_year'];
	$sql = "SELECT * FROM tb_welfare_request WHERE confirmdate < '$year-12-31'";
	$year = $year+543;
	array_push($num_yaer,$year);
}else {
	$sqls = "SELECT DISTINCT year FROM tb_welfare_request ORDER BY year";
	$rss = rsQuery($sqls);
	while ($rows = mysqli_fetch_array($rss)) {
		array_push($num_yaer,$rows['year']);
	}
}


$data = array();
for ($i=0; $i < count($num_yaer) ; $i++) {

	$num1 = 0;
	$num2 = 0;
	$num3 = 0;
	$rs = rsQuery($sql);

	while ($row = mysqli_fetch_array($rs)) {

		$dateyear = strtotime($row['confirmdate']);
		$chkyear = date('Y', $dateyear)+543;

		if ($chkyear == $num_yaer[$i]) {
			//echo $row['year']."-->".$num_yaer[$i]."<br>";

			if ($row['type'] == 1) {
				$num1++;
			}elseif ($row['type'] == 2) {
				$num2++;
			}elseif ($row['type'] == 3) {
				$num3++;
			}

}
}

	$data[$i] = array('year' => $num_yaer[$i],
								'num1' => $num1,
								'num2' => $num2,
								'num3' => $num3);
}
?>

<style>

.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: white;
  color: black;
  border: 2px solid #4CAF50;
	background:url('../images/component/excel.png') 50% 50% no-repeat;
	background-size: 50%;
}
.button2 {
  background-color: white;
  color: black;
  border: 2px solid #000000;
	background:url('../images/component/print.png') 50% 50% no-repeat;
	background-size: 50%;
}

.button1:hover {
  background-color: #4CAF50;
  color: white;
}

.button2:hover {
  background-color: #737373;
  color: white;
}


table .data{
  width: 100%;
}

.data td, th {
  padding: 8px;
  border: 0px;
	text-align: center;
}
.data  tr:hover td {
	background-color:#A2AB58;
}

.content-table td {
	text-align: center;
}

</style>


<fieldset>
	<div class="content-table">
    <h3>สรุปผลผู้มีสิทธิ์ได้รับเบี้ยยังชีพ</h3>
    <hr>

<br>
		<div class="content-input" style="width:90%;">
			<form name="frmData" method="POST" enctype="multipart/form-data">
			<table width="100%" class="data">
				<tr>
					<td align="center">ปี
						<select name="frm_year" style="width:100px">
							<option value=''></option>
						<?php
						$year = date('Y')+543;
						$numyear = $year-10;
						for ($i=$numyear; $i <= $year; $i++) {
							$valyear = $numyear-543;
							if($valyear==$Year){
									echo "<option value='$valyear' selected>$numyear</option>";
								}else {
									echo "<option value='$valyear'>$numyear</option>";
								}
							$numyear++;
						}

						?>
						</select>
            <input type="submit" name="btsave" value="ค้นหา">
					</td>
				</tr>

			</table>

</div>

    <br>
<div name="data_table" id="data_table">
	<table name="showdata" width="100%">
    <tr>
			<th></th>
			<th colspan="3">ประเภทเบี้ย</th>
			<th colspan="1"></th>
		</tr>
		<tr>
			<th>ปี</th>
			<th>ผู้สูงอายุ</th>
      <th>ผู้พิการ</th>
			<th>ผู้ป่วยโรคเอดส์</th>
			<th>รวมจำนวนเบี้ยทั้งสิ้น</th>
		</tr>
		<?php



		for ($i=0; $i < count($data); $i++) {

			$year = $data[$i]['year'];
			$type1 = $data[$i]['num1'];
			$type2 = $data[$i]['num2'];
			$type3 = $data[$i]['num3'];
			$sumtype = $type1+$type2+$type3;
			$sum1 = $sum1+$type1;
			$sum2 = $sum2+$type2;
			$sum3 = $sum3+$type3;
			$allsum = $sum1+$sum2+$sum3;

			echo "<tr align='center'><td>$year</td><td>$type1</td><td>$type2</td><td>$type3</td><td>$sumtype</td></tr>";
		}

		//echo "<tr><td colspan='6'> </td></tr>";
		//echo "<tr align='center' style='font-weight: bold;'><td align='right'>ยอดรวมทั้งสิ้น</td><td>$sum1</td><td>$sum2</td><td>$sum3</td><td>$allsum</td></tr>";

		?>
	</table>
</div>

				<input type="hidden" id="create_excel" name="create_excel" value="create excel">
	</div>
	<div style="text-align:center;">
		<textarea name="frm_code" id="frm_code" style="display:none;"></textarea>
			<input type="button" class="button button1" id="create_excel" name="create_excel" onClick="this.form.action='modules/configwelfare/excel.php'; submit()">
			<input name="b_print" type="button" class="button button2" onClick="printdiv('data_table');">

		</input>
	</div>
</form>
</fieldset>

<script>

	$(document).ready(function(){

			var code = $('#data_table').html();
			document.getElementById("frm_code").innerHTML = code;

			$('#create_excel').click(function(){
				var excel_data = $('#data_table').html();
				var data = encodeURI(excel_data);
				var page = "modules/configwelfare/excel.php&data="+excel_data;

				window.location = page;
				/*$.ajax({
					type: "POST",
					url: page,
					data: {data: excel_data},
					success: function(response) {

           }
				 });*/
});
});



function printdiv(printpage,fontsize)
{

if(fontsize==null){
 var fon1=12;
}else{
 var fon1=fontsize;
}
var headstr = "<html><head><title></title><style type='text/css'>[data-negative]{color: red;}@import url(../font/thsarabunnew.css);table tr:nth-child(odd) td{ background-color:#efefef;}table tr:nth-child(even) td{background-color:white;} body,th,td{font-family:THSarabunNew;font-size:"+fon1+"px;padding:3px;} th{background-color:#7f7f7f;color:white;}.title{ width:100%;background-color:#272727;color:yellow;}.th1{width:70%;height:30px; line-height:30px; background-color:#7f7f7f;color:white;display:inline-block;}.th2{width:30%;height:30px;line-height:30px;background-color:#7f7f7f;color:white;display:inline-block;}.tr1{width:70%;height:30px;line-height:30px;border-bottom:1px dashed #004080;color:blue;display:inline-block;}.tr2{width:30%;height:30px;line-height:30px;border-bottom:1px dashed #004080;color:blue;display:inline-block;}.hideul{margin-left:20px;width:100%;list-style:none;}.hideul li{height:30px;line-height:30px; background-color:#d8fcf8;border-bottom:1px dashed #868686;width:90%;}.hideul li:hover{cursor:pointer;background-color:#ffffcc;}  .bottomLine{ background-color:#b6b6b6;color:black;} .pagebreak{page-break-after: always;} @page {size: 210mm 297mm; margin: 25mm 25mm 25mm 25mm; }@media print {@page {margin:15mm 5mm 15mm 5mm} body {background: #FFF;}table,td{overflow:visible !important;} }</style></head><body>";
var footstr = "</body></html>";
var newstr = document.all.item(printpage).innerHTML;
//var oldstr = document.body.innerHTML;
//document.body.innerHTML = headstr+newstr+footstr;
//window.print();
//document.body.innerHTML = oldstr;
//return false;

myWindow=window.open('','_blank');
myWindow.document.write(headstr+newstr+footstr);
myWindow.focus();
myWindow.document.close();

}


</script>
