<br><br>
<div id="webboard">
<?php
$mod=EscapeValue(decode64($_GET['_mod']));
$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
echo "<center>";
	if(file_exists("images/".$bannername) and $bannername<>""){
			echo "<script>ChangeCssBg('webboard','".$bannername."');</script>";
		}else{
			echo "<p class='banner_title'>$modname</p>";
	}

echo "<p style='font-size:25px;color:green;text-decoration:underline;''>นายกเทศมนตรี</p>";
echo "<p style='font-size:25px;margin-top:10px;'>โทร : 0980977473</p>";
echo "<p style='font-size:25px;color:green;text-decoration:underline;margin-top:10px;''>ปลัดเทศบาล</p>";
echo "<p style='font-size:25px;margin-top:10px;'>โทร : 0630061172</p>";
echo "<br>";
echo "</center>";
!empty($_GET['no'])?$no=$_GET['no']:null;
!empty($_GET['type'])?$type=decode64($_GET['type']):null;
if($type=="addnew"){
	include"webboard_add.php";
}elseif($type=="view"){
	include"webboard_view.php";
}else{
	?>
	<p style="margin-left:10px;"><img src="images/component/add_24.png"/>&nbsp;<?php echo"<a class=\"book\" href=\"index.php?_mod=".encode64($mod)."&type=".encode64('addnew')." \">เพิ่มกระทู้ใหม่</a>";?></p>
	<?php
	############################# แบ่งหน้าเพื่อให้แสดงผลรวดเร็ว #######################
	$pagelen = 20; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	$page = EscapeValue($_GET['page']); //รับค่าตัวแปร page แบบ get
	if(empty($page)){ $page=1; } //ถ้าตัวแปรเพจยังไม่มี ให้ค่าเริ่มต้นของ $page เป็น 1
	$sql = "select wid from $tablename Where status='1'"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
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
	$sql = "select * from $tablename Where status='1' order by wid DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	$sql1=$sql;
	$Query = rsQuery($sql1); //คิวรี่คำสั่ง
	if($totalrecords==0){
		echo "<br><br><br>";
		echo"<p align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล- - - - - - - - - -</p><BR><BR><BR><BR>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		echo "<div id='master-table'>";
		echo "<table width='100%'>";
		echo "<tr><th width=85% align=left>หัวข้อ</th><th width=15% align=center>ตอบ</th></tr>";

		while($arr = mysqli_fetch_assoc($Query)){
			$cdate=$arr['createdate'];
			if($cdate==null){
				$dt=DateThai($arr['datepost']);
			}else{
				$dt=DateTimeThai($arr['createdate']);
			}
			echo"<tr onclick='window.location=\"index.php?_mod=".encode64($mod)."&type=".encode64('view')."&no=".encode64($arr['wid'])."\"'><td ><a style='font-weight: bold' href=\"index.php?_mod=".encode64($mod)."&type=".encode64('view')."&no=".encode64($arr['wid'])."\">";
			echo $arr['subject']."</a><br><font id=text-clay>&nbsp;&nbsp;โดย :".$arr['postby']."&nbsp;&nbsp;".$dt."</font></td>";
			$sql_sub="Select * From tb_wb_subnayok Where wid='".$arr['wid']."'";
			$crs=rsQuery($sql_sub);
			if($crs){
				$num=mysqli_num_rows($crs);
			}else{
				$num="0";
			}
			if($num==0){
				echo"<td align=center ><font style=\"color:red;\">$num</font><?td>";
			}else{
				echo"<td align=center ><font >$num</font></td>";
			}
			echo"</tr>";
		}
		echo "</table>";
		echo "</div>";
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