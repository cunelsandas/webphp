<br><br>
<div id="data_download">

<?php

$mod=EscapeValue(decode64($_GET['_mod']));
$tablename=FindRS("select * from tb_mod where modtype='$mod'",tablename);
$folder=FindRS("select * from tb_mod where modtype='$mod'",foldername);
$modname=FindRS("select * from tb_mod where modtype='$mod'",modname);
$bannername=FindRS("select * from tb_mod where modtype='$mod'",bannername);
$foldername=$gloUploadPath."/".$folder."/";
echo "<center>";
	if(file_exists("images/".$bannername) and $bannername<>""){
			echo "<script>ChangeCssBg('data_download','".$bannername."');</script>";
		}else{
			echo "<p class='banner_title'>$modname</p>";
	}
echo "</center>";

!empty($_GET['no'])?$no=decode64($_GET['no']):null;
if($no<>""){
	//include"modules/data_download/download_form_view.php";
	$sql="select * from $tablename where no=$no";
	$rs=rsQuery($sql);
	$data=mysqli_fetch_array($rs);
	$subject=$data['subject'];
	$detail=$data['detail'];
	$datepost=DateThai($data['datepost']);
	$filename=SearchFileName($tablename,$data['no']);
		if($filename!="ไม่พบเอกสาร"){
			if(file_exists($foldername.$filename)){
				$doc="<a class=\"list\" href=".$foldername.$filename." target=_blank>Download</a>";
			}else{
				$doc= "ไม่พบเอกสาร";
			}
		}else{
			if(file_exists($foldername.$arr['doc']."")){
				$doc="<a class=\"list\" href=".$foldername.$arr['doc']." target=_blank>Download</a>";
			}else{
				$doc= "ไม่พบเอกสาร";
		}
		}
	
	echo "<table width='80%' id='master-table'>";
	echo "<tr><td>หัวข้อ :</td><td>".$subject."</td></tr>";
	echo "<tr><td>วันที่ :</td><td>".$datepost."</td></tr>";
	echo "<tr><td>รายละเอียด :</td><td>".$detail."</td></tr>";
	echo "<tr><td></td><td>".$doc."</td></tr>";
	echo "</table>";
}else{
$pagelen = 20; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
		if(isset($_GET['page'])){ 
		$page=EscapeValue($_GET['page']);
	}else{
		$page="1";
	}
	if(isset($_GET['offid'])){
		$sql = "select no from $tablename Where status='1' and offid=".EscapeValue($_GET['offid']); //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	}else{
		$sql="Select no From $tablename Where status='1'";
	}
	$result = rsQuery($sql);
	if($result){
		$totalrecords= $num_rows = mysqli_num_rows($result); //หาจำนวนแถวของขัอมูลทั้งหมด
	}else{
		$totalrecords= $num_rows ="0";
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
	if(isset($_GET['offid'])){
		$offid=EscapeValue($_GET['offid']);
	//	$sql="Select tb_download.*,tb_officertype.id as oid,tb_officertype.name From $tablename  INNER JOIN tb_officertype ON tb_download.offid=tb_officertype.id where status='1' and offid='".$_GET['offid']."' order by tb_download.offid,no DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
		$sql="Select * From $tablename where status='1' order by datepost DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	}else{
		//$sql="Select tb_download.*,tb_officertype.id as oid,tb_officertype.name From $tablename INNER JOIN tb_officertype ON tb_download.offid=tb_officertype.id where status='1' order by tb_download.offid, no DESC Limit $goto,$pagelen";
		$sql="Select * From $tablename where status='1' order by datepost DESC Limit $goto,$pagelen";
	}
	//$result_reply = rsQuery($sql);
	
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
echo "<div id='master-table'>";
echo"<center>";
echo"<table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\" class=\"tbl-border1\">";
echo"<tr>";
echo"<th width=\"50%\" align=\"center\">หัวข้อ</th>";
//echo"<th width=\"30%\" align=\"center\">หน่วยงาน</th>";
echo"<th align=\"center\">ดาวน์โหลด</th>";
echo"</tr>";
while($arr = mysqli_fetch_assoc($Query)){
	if($bgcolor=="#FEEFFD"){
		$bgcolor="#FFFFFF";
	}else{
		$bgcolor="#FEEFFD";
	}
	//$depname=FindRS("select name from tb_officertype where id=".$arr['offid'],"name");
	echo"<tr bgcolor=\"$bgcolor\">";
	echo"<td  align=\"left\" id=\"download-td\" >".$arr['subject']."&nbsp;<font color='#727272'>".DateThai($arr['datepost'])."</font></td>";
//	echo"<td id=\"download-td\" >".$depname."</td>";
	echo"<td id=\"download-td\" align=\"center\">";
	$filename=SearchFileName($tablename,$arr['no']);
		if($filename!="ไม่พบเอกสาร"){
			if(file_exists($foldername.$filename)){
				echo"<a class=\"list\" href=".$foldername.$filename." target=_blank>Download</a>";
			}else{
				echo "ไม่พบเอกสาร";
			}
		}else{
			if(file_exists($foldername.$arr['doc']."")){
				echo"<a class=\"list\" href=".$foldername.$arr['doc']." target=_blank>Download</a>";
			}else{
				echo "ไม่พบเอกสาร";
		}
		}
	echo"</td>";
	echo"</td>";
	
	}
	echo"</table>";
	echo"</center></div>";
}
echo "<div id=\"page_count\">";
if ($page > 1) {
	$back = $page - 1;
	echo "<a href=\"$PHP_SELF?_mod=".encode64($mod)."&page=1\" title=\"หน้าแรก First Page\">|<</a>";
	echo "<a href=\"$PHP_SELF?_mod=".encode64($mod)."&page=$back\" title=\"ย้อนกลับ Previous Page\"><<</a>";
	if ($start > 1) { echo "....."; }
}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = sprintf("#%06x",rand(0,16777215)); //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "<a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a>" ;
		} else {
			echo "<a href=\"$PHP_SELF?_mod=".encode64($mod)."&page=".$i."\" title=\"ไปหน้าที่ $i\" >".$i."</a>" ;
		}
	$icount++;
	}
if ($page < $totalpage) {
	$next = $page +1;
	if ($end < $totalpage) { echo "....."; }
	echo "<a href=\"$PHP_SELF?_mod=".encode64($mod)."&page=$next\" title=\"หน้าต่อไป Next Page\">>></a>";
	echo "<a href=\"$PHP_SELF?_mod=".encode64($mod)."&page=$totalpage\" title=\"หน้าสุดท้าย Last Page\">>|</a>";
}
echo "<p>ขณะนี้คุณอยู่ที่หน้า $page</p>";
echo "</div>";
echo "</div>";

}
?>