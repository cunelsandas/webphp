
  <link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
  <!-- datepicker thai year -->
 <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
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
<SCRIPT LANGUAGE="Javascript" SRC="../FusionCharts/FusionCharts.js"></SCRIPT>
<div class="content-box">
  <?php
 $mod=$_GET['_mod'];
$tablename="tb_infoservice";
$tablename2="tb_infoservice_type";
empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=EscapeValue($_GET['_modid']);
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
echo "<p >$modname</p><hr><br>";

if($type=="addnew"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
	include"infoservice_add.php";
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"infoservice_view.php";
}elseif($type=="moo"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"infoservice_moo.php";
}elseif($type=="time"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"infoservice_time.php";
}elseif($type=="type"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"infoservice_type.php";
}elseif($type=="report"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"infoservice_report.php";
}else{
	if(isset($_GET['status'])){
		$sql="UPDATE $tablename SET status='".EscapeValue($_GET['status'])."' Where no='".EscapeValue($_GET['no'])."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
	if(isset($_GET['del'])){
		$sql="DELETE From $tablename Where id='".EscapeValue($_GET['del'])."'";
		$rs=rsQuery($sql);
		if($rs){
				// update table tb_trans บันทึกการลบ
		$updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$id);
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}

?>

<p style="right:10%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มรายการใหม่</a>";?></p>

<p style="left:10%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=report\" class='link'>รายงาน</a>";?></p><br><br>
<form name="frm01" method="POST" action="" >
		<table class="content-input">
			<tr>
				<th colspan="2"><?php echo $modname ?></th>
			</tr>
			<tr><td align="right">เลือกวันที่</td><td><input type="text" name="txtdatestart" id="txtdatestart" size="20">&nbsp;&nbsp;ถึงวันที่&nbsp;<input type="text" name="txtdateend" id="txtdateend"></td></tr>
			
			<tr><td></td><td><input type="submit" name="btsearch" value="ค้นหา"></td></tr>
		</table>
	</form>
	<table class="content-detail" width="80%">
		<tr>
			<td><a href="main.php?_mod=<?php echo $mod;?>&_modid=<?php echo $modid;?>&type=moo">กำหนดหมู่</a></td>
<!--			<td><a href="main.php?_mod=--><?php //echo $mod;?><!--&_modid=--><?php //echo $modid;?><!--&type=time">กำหนดช่างเวลา</a></td>-->
			<td><a href="main.php?_mod=<?php echo $mod;?>&_modid=<?php echo $modid;?>&type=type">กำหนดประเภท</a></td>
		</tr>
	</table>
	<br>
<table class="content-table">

		<tr>
			<th width="20%" class="topleft">&nbsp;ประเภท</th>
            <th width="10%" align="center">จำนวน</th>
			<th width="20%" align="center">วันที่</th>
			<th width="20%" align="center">หมู่ที่</th>
			<th width="10%" align="center" class="topright">ปรับปรุง</th>
		</tr>
	
	<?php
		$strDate=getdate();
		$month=$strDate['mon'];
		$year=$strDate['year'];
	
			$sql = "select * from $tablename Where month(date)='$month' And year(date)='$year' order by date DESC"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
			
		if(isset($_POST['btsearch'])){
			$datestart=ChangeYear($_POST['txtdatestart'],"en");
			$dateend=ChangeYear($_POST['txtdateend'],"en");
			$sql="select * from $tablename Where date Between '$datestart' And '$dateend' Order by date DESC";
		}
$modid=$_GET['_modid'];
/*คิวรี่ข้อมูลออกมาเพื่อแสดงผล */
$Query = rsQuery($sql); //คิวรี่คำสั่ง
	if($Query){
		$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	}else{
		$totalp="0";
	}
	if($totalp==0){
		echo"<tr height=\"30\">";
		echo"<td colspan=\"5\" align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</td>";
		echo"</tr>";
		/*	วนลูปข้อมูล */
	}else{
	
		while($arr = mysqli_fetch_assoc($Query)){
			$type=$arr['type'];
            $person=$arr['service_person'];
			$date=thaidate($arr['date']);
			$moo=$arr['moo'];
			$mooname=FindRs("select * from tb_infoservice_moo where id='$moo'","name");
			$typename=FindRS("select * from $tablename2 Where id=".$type,"name");

			echo"<tr >";
			echo"<td>$typename</td>";
            echo"<td>$person</td>";
			echo"<td>$date</td>";
			echo"<td align=\"center\">$mooname</td>";
			echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&id=".$arr['id']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";			
			
		}
	}
	echo"</table>";
}
	?>
	</div>