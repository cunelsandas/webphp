
<p style="margin-left:10px;">รายการแจ้งไฟฟ้าสาธารณะ</p>
<?php
$tablename="tb_electric";

empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
if($type=="addnew"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
	include"addnew.php";
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"view.php";
}else{
	if(isset($_GET['active'])){
		$sql="UPDATE $tablename SET active='".$_GET['active']."' Where no='".$_GET['no']."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
	if(isset($_GET['del'])){
		$sql="DELETE From $tablename Where no='".$_GET['del']."'";
		$rs=rsQuery($sql);
		if($rs){
			// update table tb_trans บันทึกการลบข้อมูล
			$updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$_GET['del']);
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
?>
<p style="margin-left:10px;"><img src="../images/component/add_24.png"/>&nbsp;<?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\">เพิ่มรายการใหม่</a>";?></p>
<center>
<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = เปิดการแสดงผล : <img src="../images/component/01.png" /> = ปิดการแสดงผล </p>
<table width="100%" cellpadding="1" cellspacing="1" border="0" style="margin-bottom:10px;">
<tr height="30" bgcolor="#FEC90E">
	<td width="330">&nbsp;รายการ</td>
	<td width="130" align="center">วันที่แจ้ง</td>
	<td width="50" align="center">สถานะ</td>
	<td width="70" align="center">ปรับปรุง</td>
</tr>
<?php
$pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	$page = $_GET['page']; //รับค่าตัวแปร page แบบ get
	if(empty($page)){ $page=1; } //ถ้าตัวแปรเพจยังไม่มี ให้ค่าเริ่มต้นของ $page เป็น 1
	$sql = "select no from $tablename"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	$result = rsQuery($sql)or die(mysqli_error());
	$totalrecords= $num_rows = mysqli_num_rows($result); //หาจำนวนแถวของขัอมูลทั้งหมด
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
	$sql = "select * from $tablename order by no DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	$result_reply = rsQuery($sql);

/*คิวรี่ข้อมูลออกมาเพื่อแสดงผล */
//$sql="Select * From $tablename Order by no DESC Limit $start1,$limit";
	//$sql1=$sql;
$Query = rsQuery($sql); //คิวรี่คำสั่ง
	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalp==0){
		echo"<tr height=\"30\">";
		echo"<td colspan=\"4\" align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</td>";
		echo"</tr>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		while($arr = mysqli_fetch_array($Query)){
			echo"<tr bgcolor=\"#FCEE98\" height=\"23\">";
			echo"<td>&nbsp;".$arr['subject']."</td>";
			echo"<td>&nbsp;".thaidate($arr['datecreate'])."</td>";
			echo"<td align=\"center\">";
			if($arr['active']=="0"){
				echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&active=1&no=".$arr['no']."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
			}else{
				echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&active=0&no=".$arr['no']."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
			}
			echo"</td>";
			echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$arr['no']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['no']."\" onclick=\"return confirm('คุณต้องการลบรายการนี้หรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";			
			$i++;
		}
	}
	echo"</table>";
	echo "</center>";


	echo"<p style=\"text-align:center;margin-left:45px;padding-bottom:10px;\">";
	echo "";
	if ($page > 1) {
		$back = $page - 1;
		echo "<a href=$PHP_SELF?_mod=".$_GET['_mod']."&_modid=".$modid."&page=1><img src=\"../images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>&nbsp;&nbsp;";
		echo "<a href=$PHP_SELF?_mod=".$_GET['_mod']."&_modid=".$modid."&page=$back><img src=\"../images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>&nbsp;&nbsp;";
			if ($start > 1) { echo "....."; }
	}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = ($icount% 2)? '#0080ff' : '#ff0000'; //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "&nbsp;<b><font color=#787a8d>[".$i."]</font></b>&nbsp;&nbsp;&nbsp;" ;
		} else {
			echo "&nbsp;<a href=$PHP_SELF?_mod=".$_GET['_mod']."&_modid=".$modid."&page=".$i." style=\"color:$bgcolor\"><font color=$bgcolor>".$i."</font></a>&nbsp;&nbsp;&nbsp;" ;
		}
		$icount++;
	}
	if ($page < $totalpage) {
		$next = $page +1;
		if ($end < $totalpage) { echo "....."; }
		echo "&nbsp;&nbsp;<a href=$PHP_SELF?_mod=".$_GET['_mod']."&_modid=".$modid."&page=$next><img src=\"../images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
		echo "&nbsp;<a href=$PHP_SELF?_mod=".$_GET['_mod']."&_modid=".$modid."&page=$totalpage><img src=\"../images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	}
		echo "</p>";

// end if
}
?>