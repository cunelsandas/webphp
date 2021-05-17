<?php $CheckBrowser = getBrowser();
$device = $CheckBrowser['device'];

if($device=="Mobile"){
    echo '<div id="purchase" style="padding-top: 10px">';
}
else{
    echo '<div id="purchase" style="padding-top: 150px">';
}
?>


<?php
$mod=EscapeValue(decode64($_GET['_mod']));
$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
//$foldername=$gloUploadPath."/".$folder."/";
	if(file_exists("images/".$bannername) and $bannername<>""){
			echo "<script>ChangeCssBg('purchase','".$bannername."');</script>";

		}else{
			echo "<p class='banner_title'>$modname</p>";

	}

//!empty($_GET['no'])?$no=$_GET['no']:null;
if(isset($_GET['no'])){
	$no=$_GET['no'];
}else{
	$no="";
}
if($no<>""){
	include"purchase_view.php";
}else{
	$rsfield=rsQuery("SHOW COLUMNS FROM tb_purchase_group LIKE 'listno'");
	$exists = (mysqli_num_rows($rsfield)?TRUE:FALSE);
	if($exists==FALSE){
		$sqlGroup="select * from tb_purchase_group order by id ASC";
	}else{
		$sqlGroup="select * from tb_purchase_group order by id ASC";
	}
	$rsGroup=rsQuery($sqlGroup);
	if($rsGroup){
		while($dataGroup=mysqli_fetch_assoc($rsGroup)){
			$GroupName=$dataGroup['name'];
			$GroupId=$dataGroup['id'];
			/* start sub page*/
			$pagelen =15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
			$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
			//รับค่าตัวแปร page แบบ get
				if(isset($_GET['page'])){
					$page=EscapeValue($_GET['page']);
				}else{
					$page="1";
				}

			$sql = "select no from $tablename Where status='1' and groupid=$GroupId"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
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
	$sql = "select * from $tablename Where status='1' and groupid=$GroupId order by datepost DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า


	/*คิวรี่ข้อมูลออกมาเพื่อแสดงผล */
	//$sql="Select * From ".$tablename." Where status='1'  Order by no DESC Limit $start1,$limit";
	$sql1=$sql;
	$Query = rsQuery($sql1); //คิวรี่คำสั่ง
//	$totalp = mysql_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalrecords==0){
		echo"<p align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล- - - - - - - - - -</p><BR><BR><BR><BR>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
echo"<center>";
echo "<div id='master-table'>";
echo"<table width=\"100%\" >";
echo "<tr><th colspan='2'>$GroupName</th></tr>";
echo"<tr>";
echo"<th width=\"80%\" align=\"center\" >หัวข้อ</td>";
if($showdate=="yes"){
echo"<th align=\"center\">วันที่</td>";
}
echo"</tr>";
while($arr = mysqli_fetch_array($Query)){

	echo"<tr onclick=\"window.location='index.php?_mod=".encode64($mod)."&no=".encode64($arr['no'])."'\">";
	echo"<td>".$arr['subject']."</td>";
	if($showdate=="yes"){
	echo"<td>".thaidate($arr['datepost'])."</td>";
	}
	echo"</td>";
	}
	echo"</table>";
	echo "</div>";
	echo"</center>";
}
echo "<div id=\"page_count\">";
if ($page > 1) {
	$back = $page - 1;
	echo "<a href=\"index.php?_mod=".encode64($mod)."&page=1&groupid=$GroupId\" title=\"หน้าแรก First Page\">|<</a>";
	echo "<a href=\"index.php?_mod=".encode64($mod)."&page=$back&groupid=$GroupId\" title=\"ย้อนกลับ Previous Page\"><<</a>";
	if ($start > 1) { echo "....."; }
}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = sprintf("#%06x",rand(0,16777215)); //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "<a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a>" ;
		} else {
			echo "<a href=\"index.php?_mod=".encode64($mod)."&page=".$i."&groupid=$GroupId\" title=\"ไปหน้าที่ $i\" >".$i."</a>" ;
		}
	$icount++;
	}
if ($page < $totalpage) {
	$next = $page +1;
	if ($end < $totalpage) { echo "....."; }
	echo "<a href=\"index.php?_mod=".encode64($mod)."&page=$next&groupid=$GroupId\" title=\"หน้าต่อไป Next Page\">>></a>";
	echo "<a href=\"index.php?_mod=".encode64($mod)."&page=$totalpage&groupid=$GroupId\" title=\"หน้าสุดท้าย Last Page\">>|</a>";
}
echo "<p>ขณะนี้คุณอยู่ที่หน้า $page</p>";
echo "</div>";

		}
	}

echo "</div>";

}
echo "<div class='phone-hide'>";

include "modules/egp/egp.php";
echo "</div>";
?>

