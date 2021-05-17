<?php

error_reporting(0);

$sql = "SELECT * FROM tb_citizen WHERE status = '3' ORDER BY date_denied desc";

if (isset($_POST['btsave']) != "") {

	  $month = $_POST['frm_month'];
	  $year = $_POST['frm_year'];
	  $moo =  $_POST['frm_moo'];
	  $yearnow = date('Y');

	  if ($year != "" && $month == "" && $moo == "") {
	    $sql = "SELECT * FROM tb_citizen WHERE status = '3' AND date_denied BETWEEN '$year-1-1' AND '$year-12-31' ORDER BY id";
	  }elseif ($year != "" && $month != "" && $moo == "") {
	    $sql = "SELECT * FROM tb_citizen WHERE status = '3' AND date_denied BETWEEN '$year-$month-1' AND '$year-$month-31' ORDER BY id";
	  }elseif ($year == "" && $month != "" && $moo == "") {
	    $sql = "SELECT * FROM tb_citizen WHERE status = '3' AND date_denied BETWEEN '$yearnow-$month-1' AND '$yearnow-$month-31' ORDER BY id";
	  }elseif ($year == "" && $month == "" && $moo != "") {
	    $sql = "SELECT * FROM tb_citizen WHERE status = '3' AND moo = '$moo' ORDER BY id";
	  }elseif ($year != "" && $month == "" && $moo != "") {
	    $sql = "SELECT * FROM tb_citizen WHERE status = '3' AND date_denied BETWEEN '$year-1-1' AND '$year-12-31' moo = '$moo' ORDER BY id";
	  }elseif ($year == "" && $month != "" && $moo != "") {
	    $sql = "SELECT * FROM tb_citizen WHERE status = '3' AND date_denied BETWEEN '$yearnow-$month-1' AND '$yearnow-$month-31' moo = '$moo' ORDER BY id";
	  }elseif ($year != "" && $month != "" && $moo != "") {
	    $sql = "SELECT * FROM tb_citizen WHERE status = '3' AND date_denied BETWEEN '$year-$month-1' AND '$year-$month-31' moo = '$moo' ORDER BY id";
	  }
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
    <h3>สรุปการจำหน่ายผู้มีสิทธิ์</h3>
    <hr>

<br>
		<div class="content-input" style="width:90%;">
			<form name="frmData" method="POST" enctype="multipart/form-data">
			<table width="100%" class="data">
				<tr>
					<td align="center">
            เดือน <select name="frm_month" class="form-control" id="frm_month">
              <option value=''></option>
              <?php
                $sqlmoo="select * from  month order by id";
              $rsmoo=rsQuery($sqlmoo);
              if($rsmoo){
                while($dmoo=mysqli_fetch_assoc($rsmoo)){
                  $mooid=$dmoo['id'];
                  $mooname=$dmoo['month'];
                  if($mooid==$status){
                    echo "<option value='$mooid' selected>$mooname</option>";
                  }else{
                    echo "<option value='$mooid'>$mooname</option>";
                  }
                }
              }
              ?>
            </select>
              ปี
              <select name="frm_year" style="width:100px">
                <option value=''></option>
  						<?php
  						$year = date('Y')+543;
  						$numyear = $year-10;
  						for ($i=$numyear; $i <= $year; $i++) {
  							$valyear = $numyear-543;
                echo "<option value='$valyear'>$numyear</option>";

  							$numyear++;
  						}

  						?>
  						</select>

            &nbsp;&nbsp;หมู่บ้าน

            <select name="frm_moo" class="form-control" id="moo">
              <option value=''></option>
              <?php
                $sqlmoo="select * from  tb_moo order by id";
              $rsmoo=rsQuery($sqlmoo);
              if($rsmoo){
                while($dmoo=mysqli_fetch_assoc($rsmoo)){
                  $mooid=$dmoo['id'];
                  $mooname=$dmoo['name'];
                  if($mooid==$status){
                    echo "<option value='$mooid' selected>$mooname</option>";
                  }else if ($mooid == "5") {
                    // code...
                  }else{
                    echo "<option value='$mooid'>$mooname</option>";
                  }
                }
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
			<th>ลำดับ</th>
			<th>ชื่อ-นามสกุล</th>
			<th>เลขที่บัตรประชาชน</th>
      <th>ที่อยู่</th>
      <th>สาเหตุการจำหน่าย</th>
			<th>จำหน่ายวันที่</th>
			<th>หมายเหตุ</th>
		</tr>
		<?php

    $n = 1;
    $rs = rsQuery($sql);
    while ($row = mysqli_fetch_array($rs)) {



      $prename =  FindRS("select name from tb_prename where id = ".$row['prename'],"name");
      $name = $prename . " " . $row['name'];
      $surname = $row['surname'];
      $fullname = $name." ".$surname;
      $personid = $row['personid'];
      $address = $row['address'];

			$deniedname =  FindRS("select name from tb_denied where id = ".$row['id_denied'],"name");

			$detail = $row['datail_denied'];
			$datedenied = DateThai($row['date_denied']);

      $sqls = "SELECT * FROM tb_welfare_request WHERE personid = ".$personid;
      $rss = rsQuery($sqls);


      echo "<tr align='center'><td>$n</td><td align='left'>$fullname</td><td>$personid</td><td>$address</td><td>$deniedname</td><td>$datedenied</td><td>$detail</td></tr>";

      $n++;
    }

			/*if($year > 0){
				echo "<tr><td>$year</td><td>$type1</td><td>$type2</td><td>$type3</td><td>$sumtype</td><td>$sumpay</td></tr>";
				echo "<tr><td colspan='9'> </td></tr>";
				echo "<tr style='font-weight: bold;'><td align='right'>ยอดรวมทั้งสิ้น</td><td>$type1</td><td>$type2</td><td>$type3</td><td></td><td>$sumpay</td></tr>";
			}else{
				echo "<tr><td colspan='9' align='center'>ยังไม่มีข้อมูล</td></tr>";
			}*/
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
