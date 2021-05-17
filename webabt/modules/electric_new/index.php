<?php
$mod=decode64($_GET['_mod']);
!empty($_GET['no'])?$no=$_GET['no']:null;

if($no<>""){
	if($no=='addnew'){
		include"modules/electric/addnew.php";
	}else{
		include"modules/electric/view.php";
	}
}else{
	$tablename="tb_electric";
	$pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	$page = $_GET['page']; //รับค่าตัวแปร page แบบ get
	if(empty($page)){ $page=1; } //ถ้าตัวแปรเพจยังไม่มี ให้ค่าเริ่มต้นของ $page เป็น 1
	$sql = "select no from $tablename Where active='1'"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
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
	$sql = "select * from $tablename Where active='1' order by no DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	$result_reply = rsQuery($sql);
?>
<div id="electric">

<div align="right" style="padding-right:10px;"><a href="index.php?_mod=<?php echo encode64('electric');?>&no=addnew">แจ้งไฟฟ้าชำรุด</a></div><br>
<fieldset>
	
	<table id="newspaper-b">
		<tr>
			<th width="10%">รหัส</th>
			<th width="40%">เรื่อง</th>
			<th width="30%">วันที่แจ้ง</th>
			<th width="20%">สถานะงาน</th>
		</tr>
				<?php
				//$strsql="select * from $tablename Where active=1 order by no DESC";
				$strsql=$sql;
				$rsshow=rsQuery($strsql);
				

				while($data=mysqli_fetch_array($rsshow)){
						
						$status=FindRS('select * from tb_status where  id='.$data['status'],name);
						
						echo "<tr onclick=\"document.location = 'index.php?_mod=".encode64('electric')."&no=".$data['no']."';\"><td align=\"left\">".$data['no']."</td><td align=\"left\">".$data['subject']."</td><td align=\"right\">".DateTimeThai($data['datecreate'])."</td><td align=\"center\">".$status."</td></tr>";
						

				}
		?>
		</table>
		
</fieldset>

</div>
<?php
echo"<p style=\"text-align:center;margin-left:45px;padding-bottom:10px;\">";
echo "";
if ($page > 1) {
$back = $page - 1;
echo "<a href=$PHP_SELF?_mod=".encode64($mod)."&page=1><img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>&nbsp;&nbsp;";
echo "<a href=$PHP_SELF?_mod=".encode64($mod)."&page=$back><img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>&nbsp;&nbsp;";
if ($start > 1) { echo "....."; }
}
$icount=1;
For ($i=$start ; $i<=$end ; $i++) {
$bgcolor = ($icount% 2)? '#0080ff' : '#ff0000'; //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
if ($i == $page ) {
echo "&nbsp;<b><font color=#787a8d>[".$i."]</font></b>&nbsp;&nbsp;&nbsp;" ;
} else {
echo "&nbsp;<a href=$PHP_SELF?_mod=".encode64($mod)."&page=".$i." style=\"color:$bgcolor\"><font color=$bgcolor>".$i."</font></a>&nbsp;&nbsp;&nbsp;" ;
}
$icount++;
}
if ($page < $totalpage) {
$next = $page +1;
if ($end < $totalpage) { echo "....."; }
echo "&nbsp;&nbsp;<a href=$PHP_SELF?_mod=".encode64($mod)."&page=$next><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
echo "&nbsp;<a href=$PHP_SELF?_mod=".encode64($mod)."&page=$totalpage><img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
}
echo "</p>";
 
  }
  ?>