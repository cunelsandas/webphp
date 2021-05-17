<div id="file">

		<?php
			$mod=EscapeValue(decode64($_GET['_mod']));
			$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
			$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
			$foldername=$gloUploadPath."/".$folder."/";
			$type=EscapeValue(decode64($_GET['type']));
			$sql1="Select * From tb_filestype Where fid=".$type;

			$rs1=rsQuery($sql1);
			if($rs1){
				$dtype=mysqli_fetch_assoc($rs1);
				$typename=$dtype['name'];
				if($typename<>""){
				echo "<p style=\"margin-left:15px;\" class='banner_title'><strong>".$typename."</strong></p>";
				}
			}
!empty($_GET['no'])?$no=$_GET['no']:null;
if($no<>""){
	include"files_view.php";
}else{
	$pagelen = 20; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	if(isset($_GET['page'])){
		$page=EscapeValue($_GET['page']);
	}else{
		$page="1";
	}
	$sql = "select no from $tablename Where filetypeid=$type And status='1'"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
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
	$sql = "select * from $tablename Where filetypeid=$type And status='1' order by datepost DESC,no ASC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit

	/*คิวรี่ข้อมูลออกมาเพื่อแสดงผล */
	//$sql="Select * From ".$tablename." Where status='1'  Order by no DESC Limit $start1,$limit";
	$sql1=$sql;
	$Query = rsQuery($sql1); //คิวรี่คำสั่ง
	if($totalrecords==0){
		echo"<p align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล- - - - - - - - - -</p><BR><BR><BR><BR>";
		/*	วนลูปข้อมูล */
	}else{

		$i=$start;
		echo"<center>";
		echo"<table width=\"90%\" cellpadding=\"1\" cellspacing=\"1\" id=\"master-table\">";
		echo"<tr>";
		echo "<th>ลำดับ</th>";
		echo"<th width=\"75%\" align=\"left\" >รายการ</th>";
		if($showdate=="yes"){
			echo"<th align=\"center\" >วันที่</th>";
		}
		echo"</tr>";
		$countrow=$goto;
		while($arr = mysqli_fetch_assoc($Query)){
		$countrow +=1;
		echo"<tr onclick='window.location=\"index.php?_mod=".$_GET['_mod']."&no=".encode64($arr['no'])."\";'>";
		echo "<td align='center'>$countrow</td>";
		echo"<td align=\"left\">".$arr['subject']."</td>";
		if($showdate=="yes"){
		echo"<td align='center' >".DateThai($arr['datepost'])."</td>";
		}
	echo"</tr>";
	}
	echo"</table>";
	echo"</center>";
}
echo"<p style=\"text-align:center;margin-left:45px;padding-bottom:10px;\">";
echo "";
if ($page > 1) {
$back = $page - 1;
echo "<a href=index.php?_mod=".encode64($mod)."&page=1&type=".$_GET['type']." title=\"หน้าแรก First Page\">|<</a>";
echo "<a href=index.php?_mod=".encode64($mod)."&page=$back&type=".$_GET['type']." title=\"ย้อนกลับ Previous Page\"><<</a>";
if ($start > 1) { echo "....."; }
}
$icount=1;
For ($i=$start ; $i<=$end ; $i++) {
$bgcolor = ($icount% 2)? '#0080ff' : '#ff0000'; //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
if ($i == $page ) {
echo "<a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a>" ;
} else {
echo "<a href=index.php?_mod=".encode64($mod)."&page=".$i."&type=".$_GET['type']." style=\"color:$bgcolor\">".$i."</a>" ;
}
$icount++;
}
if ($page < $totalpage) {
$next = $page +1;
if ($end < $totalpage) { echo "....."; }
echo "&nbsp;&nbsp;<a href=index.php?_mod=".encode64($mod)."&page=$next&type=".$_GET['type']." title=\"หน้าต่อไป Next Page\">>></a>";
echo "&nbsp;<a href=index.php?_mod=".encode64($mod)."&page=$totalpage&type=".$_GET['type']." title=\"หน้าสุดท้าย Last Page\">>|</a>";
}
echo "</p></div>";

}