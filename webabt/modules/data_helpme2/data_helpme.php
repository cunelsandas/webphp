<div id="data_helpme">
<?php
$mod=EscapeValue(decode64($_GET['_mod']));
!empty($_GET['no'])?$no=EscapeValue(decode64($_GET['no'])):null;
!empty($_GET['type'])?$type=EscapeValue(decode64($_GET['type'])):null;

$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");

	if(file_exists("images/".$bannername) and $bannername<>""){
			echo "<script>ChangeCssBg('data_image','".$bannername."');</script>";
		}else{
			echo "<p class='banner_title'>$modname</p>";
	}


if($type=="addnew"){
	include"data_helpme_add.php";
}elseif($type=="view"){
	include"data_helpme_view.php";
}else{

	$name_btn = "แจ้งเรื่อง ร้องเรียน-ร้องทุกข์/ร้องเรียนการทุจริต";

if ($z != "") {
	$name_btn = "แจ้งปัญหา/เรื่องร้องเรียน/ปัญหาข้อกฎหมาย";
}




	$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
	?>
	<div valign="top"><?php
					$CheckBrowser=getBrowser();
	$device=$CheckBrowser['device'];
	if($device=="Mobile"){
		echo"<a href='view.php' class='link' target='_blank'>".$name_btn."</a>";
	}else{
		echo"<a href=\"index.php?_mod=".$_GET['_mod']."&type=".encode64('addnew')." \" class='link'>".$name_btn."</a>";
	}


					?></div><br>
	<div id="master-table">
	<table width="100%" border=0><tr><th width=10%>เลขคำร้อง</th><th width=20%>วันที่</th><th width=50%>เรื่อง</th><th width=20%>สถานะ</th></tr>
	<?php

	$pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	if(isset($_GET['page'])){
		$page=EscapeValue($_GET['page']);
	}else{
		$page="1";
	}
	$sql = "select id from $tablename Where status='1'"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	$result = rsQuery($sql);
		if($result){
			$totalrecords= $num_rows = mysqli_num_rows($result); //หาจำนวนแถวของขัอมูลทั้งหมด
		}else{
			$totalrecords= $num_rows = "0";
		}

	$totalpage = ceil($num_rows / $pagelen);
	$goto = ($page-1) * $pagelen; // หาหน้าที่จะกระโดดไป
	$start = $page - $range;
	$end = $page + $range;
	if ($start <= 1) {
		$start = 1;
	}
	if ($end >= $totalpage) {
		$end = $totalpage;
	}
	$sql = "select * from $tablename Where status='1' order by datepost DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า



	$sql1=$sql;
	$Query = rsQuery($sql1); //คิวรี่คำสั่ง

	if($totalrecords==0){
		echo "<tr><td colspan='4'>";
		echo"<p align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล- - - - - - - - - -</p><BR><BR><BR><BR>";
		echo "</td></tr></table></div>";
		/*	วนลูปข้อมูล */
	}else{

		while($arr = mysqli_fetch_assoc($Query)){
			$processname=FindRS("select * from tb_helpme_process where id=".$arr['process'],"name");

			echo "<tr ><td id=\"helpme-td\"><a href=index.php?_mod=".$_GET['_mod']."&type=".encode64('view')."&no=".encode64($arr['id']).">".$arr['id']."</a></td>";
			echo "<td id=\"helpme-td\">".DateThai($arr['datepost'])."</td>";
			echo "<td id=\"helpme-td\"><a href=index.php?_mod=".$_GET['_mod']."&type=".encode64('view')."&no=".encode64($arr['id']).">".$arr['subject']."</a></td>";
			echo "<td id=\"helpme-td\">".$processname."</td></tr>";


		}
		echo "</table></div>";
	}

echo "<div id=\"page_count\">";
if ($page > 1) {
	$back = $page - 1;
	echo "<a href=\"index.php?_mod=".encode64($mod)."&page=1\" title=\"หน้าแรก First Page\">|<</a>";
	echo "<a href=\"index.php?_mod=".encode64($mod)."&page=$back\" title=\"ย้อนกลับ Previous Page\"><<</a>";
	if ($start > 1) { echo "....."; }
}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = sprintf("#%06x",rand(0,16777215)); //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "<a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a>" ;
		} else {
			echo "<a href=\"index.php?_mod=".encode64($mod)."&page=".$i."\" title=\"ไปหน้าที่ $i\" >".$i."</a>" ;
		}
	$icount++;
	}
if ($page < $totalpage) {
	$next = $page +1;
	if ($end < $totalpage) { echo "....."; }
	echo "<a href=\"index.php?_mod=".encode64($mod)."&page=$next\" title=\"หน้าต่อไป Next Page\">>></a>";
	echo "<a href=\"index.php?_mod=".encode64($mod)."&page=$totalpage\" title=\"หน้าสุดท้าย Last Page\">>|</a>";
}
echo "<p>ขณะนี้คุณอยู่ที่หน้า $page</p>";
echo "</div>";
echo "</div>";

}
?>
