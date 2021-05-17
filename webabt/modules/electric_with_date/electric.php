<div class="content-box">
<p style="margin-left:10px;">รายการแจ้งไฟฟ้าสาธารณะ</p><hr><br>
<?php
$tablename="tb_electric";

empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
if($type=="addnew"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
	include"electric_add.php";
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"electric_view.php";
}else{
	if(isset($_GET['active'])){
		$sql="UPDATE $tablename SET active='".$_GET['active']."' Where no='".$_GET['no']."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='index.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
	if(isset($_GET['del'])){
		$sql="DELETE From $tablename Where no='".$_GET['del']."'";
		$rs=rsQuery($sql);
		if($rs){
			// update table tb_trans บันทึกการลบข้อมูล
			$updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$_GET['del']);
			echo"<script>window.location.href='index.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
?>
<p style="righ:0%; "><?php echo"<a href=\"index.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มรายการใหม่</a>";?></p>
<center>
<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = เปิดการแสดงผล : <img src="../images/component/01.png" /> = ปิดการแสดงผล </p><br>
<table width="100%" class="content-input" >
<tr >
	<td>&nbsp;รายการ</td>
    <td>&nbsp;สถานะ</td>
	<td align="center">วันที่แจ้ง</td>

</tr>
<?php
$pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	if(isset($_GET['page'])){
		$page=EscapeValue($_GET['page']);
	}else{
		$page="1";
	}
	$sql = "select no from $tablename"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
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
		while($arr = mysqli_fetch_assoc($Query)){
			echo"<tr bgcolor=\"#FCEE98\" height=\"23\">";
			echo"<td>&nbsp;".$arr['subject']."</td>";
            echo"<td align=\"left\">";
            if($arr['status']=="1"){
                echo"รอตรวจสอบ";
            }elseif($arr['status']=="2"){
                echo"กำลังดำเนินการ";
            }elseif($arr['status']=="3"){
                echo"ตรวจสอบแล้วไม่มีมูล";
            }elseif($arr['status']=="4"){
                echo"ดำเนินการเสร็จแล้ว";
            }
            elseif($arr['status']=="5"){
                echo"ดำเนินการและส่งเมล์ตอบกลับแล้ว";
            }
			echo"<td align=\"center\">&nbsp;".thaidate($arr['datecreate'])."</td>";
			echo"<td align=\"center\">";

			echo"</td>";

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
		echo "<a href=index.php?_mod=".$_GET['_mod']."&_modid=".$modid."&page=1><img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>&nbsp;&nbsp;";
		echo "<a href=index.php?_mod=".$_GET['_mod']."&_modid=".$modid."&page=$back><img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>&nbsp;&nbsp;";
			if ($start > 1) { echo "....."; }
	}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = ($icount% 2)? '#0080ff' : '#ff0000'; //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "&nbsp;<b><font color=#787a8d>[".$i."]</font></b>&nbsp;&nbsp;&nbsp;" ;
		} else {
			echo "&nbsp;<a href=index.php?_mod=".$_GET['_mod']."&_modid=".$modid."&page=".$i." style=\"color:$bgcolor\"><font color=$bgcolor>".$i."</font></a>&nbsp;&nbsp;&nbsp;" ;
		}
		$icount++;
	}
	if ($page < $totalpage) {
		$next = $page +1;
		if ($end < $totalpage) { echo "....."; }
		echo "&nbsp;&nbsp;<a href=index.php?_mod=".$_GET['_mod']."&_modid=".$modid."&page=$next><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
		echo "&nbsp;<a href=index.php?_mod=".$_GET['_mod']."&_modid=".$modid."&page=$totalpage><img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	}
		echo "</p>";

// end if
}
?>
</div>
