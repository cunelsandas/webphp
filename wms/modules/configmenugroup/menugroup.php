<div class="content-box">
<?php
//$tablename="tb_menugroup";
empty($_GET['type'])?$type="":$type=$_GET['type'];
$btsave_value="addnew";
$modid=$_GET['_modid'];
$modname=FindRS("select * from tb_mod where modid=".$modid,"modname");
$tablename=FindRS("select * from tb_mod where modid=".$modid,"tablename");

$uploadfoldername="/images/";
echo "<p>$modname</p><hr><br>";
	if(isset($_POST['btsave'])){
		$id=$_POST['txtid'];
		$name=$_POST['txtname'];
		$listno=empty($_POST['txtlistno'])?"0":$_POST['txtlistno'];

		switch($_POST['btsave']){
			case "addnew":
				$v_bannername=$_FILES['txtbannername']['name'];
				$sql="Insert into $tablename(name,listno,bannername) Values('$name','$listno','$v_bannername')";
				$alert="<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
				break;

			case "edit":
				$filebanner=$_FILES['txtbannername']['name'];
				if(!empty($filebanner)){
						$banner=$filebanner;
					}else{
						$banner=$_POST['txtbanner'];
				} 
				$sql="Update $tablename set name='$name',listno='$listno',bannername='$banner' Where id=".$id;
				$alert="<script>alert('แก้ไขข้อมูลเรียบร้อย".$_FILES['txtbannername']['name']."');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
				break;
		}
		$rsUp=rsQuery($sql);
		if($rsUp){
			copy($_FILES['txtbannername']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$uploadfoldername.$_FILES['txtbannername']['name']);
		//	echo $_SERVER['DOCUMENT_ROOT'].$uploadfoldername.$_FILES['txtbannername']['name']; 
		
			echo $alert;
		}else{
			echo "<script>alert('ไม่สามารถบันทึกหรือแก้ไขข้อมูลได้ กรุณาตรวจสอบ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}


	if(isset($_GET['status'])){
		$sql="UPDATE $tablename SET status='".$_GET['status']."' Where id='".$_GET['id']."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
	if(isset($_GET['del'])){
		$sql="DELETE From $tablename Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);
		if($rs){	
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$_GET['del']);

			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}

if($type=="addnew"){
	$v_id="";
	$v_name="";
	$v_listno="0";
	$btsave_value="addnew";
	$bannername="";
}
if($type=="view"){
	$id=EscapeValue($_GET['id']);
	$sql="select * from $tablename where id=$id";
	$rs=rsQuery($sql);
	if($rs){
		$data=mysqli_fetch_assoc($rs);
		$v_id=$data['id'];
		$v_name=$data['name'];
		$v_listno=$data['listno'];
		$bannername=$data['bannername'];
		$btsave_value="edit";
	}
}

?>

<p style="right:20%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มข้อมูลใหม่</a>";?></p><BR><BR>

<center>
<form name="frmedit" method="POST" action="" enctype="multipart/form-data">
	<table class="content-input" width="80%">
		<input type="hidden" name="txtid" value="<?php echo $v_id;?>">
		<tr><td>id:<?php echo $v_id;?></td><td></td></tr>
	
		<tr>
			<td>ชื่อกลุ่มเมนู</td><td><input type="text" name="txtname" value="<?php echo $v_name;?>"></td>
		</tr>
		<tr>
			<td>ลำดับการแสดง</td><td><input type="text" name="txtlistno" value="<?php echo $v_listno;?>">&nbsp;(0=ไม่แสดง)</td>
		</tr>
		<tr>
			<td valign="top" align="right">รูปแบนเนอร์</td>
			<td><input type="text" name="txtbanner" value="<?php echo $bannername;?>">&nbsp;&nbsp;<input type="file" name="txtbannername" ></td>
		</tr>
		<tr>
			<td></td><td><img src="../images/<?php echo $bannername;?>"></td>
		</tr>
		<tr>
			<td></td><td><input type="submit" name="btsave" value="<?php echo $btsave_value;?>"></td>
		</tr>
	</table>

</form>
<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = active : <img src="../images/component/01.png" /> = not active </p>
<table width="100%" class="content-table">
<tr>
	<th width="70%" align="center">ชื่อ</th>
	<th width="10%" align="center">ลำดับการแสดง</th>
	<th width="10%" align="center">สถานะ</th>
	<th width="10%" align="center">ปรับปรุง</th>
</tr>
<?php
	$pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	$page = $_GET['page']; //รับค่าตัวแปร page แบบ get
	if(empty($page)){ $page=1; } //ถ้าตัวแปรเพจยังไม่มี ให้ค่าเริ่มต้นของ $page เป็น 1
	$officertype=$_GET['type'];
	
	$sql = "select id from $tablename order by name ASC"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	$result = rsQuery($sql);
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
	$sql1 = "select * from $tablename order by listno ASC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	//$sql="Select tb_officer.*,tb_officertype.oid as oid,tb_officertype.nametype From tb_officer INNER JOIN tb_officertype ON tb_officer.offid=tb_officertype.oid $offtype  order by tb_officer.offid, no Limit $goto,$pagelen";
############################# แบ่งหน้าเพื่อให้แสดงผลรวดเร็ว #######################

$Query = rsQuery($sql1); //คิวรี่คำสั่ง
	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalp==0){
		echo"<tr height=\"30\">";
		echo"<td colspan=\"5\" align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</td>";
		echo"</tr>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		while($arr = mysqli_fetch_assoc($Query)){
			echo"<tr bgcolor=\"#FCEE98\" height=\"23\">";
			//echo"<td>&nbsp;(".$arr['nolist'].")&nbsp;".$arr['name']."</td>";
			//echo"<td>&nbsp;".thaidate($arr['date'])."</td>";
			echo"<td>".$arr['name']."</td>";
			echo"<td>".$arr['listno']."</td>";
			echo"<td align=\"center\">";
			if($arr['status']=="0"){
				echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=1&id=".$arr['id']."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
			}else{
				echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=0&id=".$arr['id']."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
			}
			echo"</td>";
			echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&id=".$arr['id']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";			
			$i++;
		}
	}
	echo"</table>";

	/* ตัวแบ่งหน้า */
	echo "<div id=\"page_count\">";

echo "";
if ($page > 1) {
$back = $page - 1;
echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=1\" title=\"หน้าแรก First Page\">|<<img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>&nbsp;&nbsp;";
echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$back\" title=\"ย้อนกลับ Previous Page\"><<<img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>&nbsp;&nbsp;";
if ($start > 1) { echo "....."; }
}
$icount=1;
For ($i=$start ; $i<=$end ; $i++) {
//$bgcolor = ($icount% 2)? '#0080f$i' : '#ff000$i'; //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
$bgcolor = sprintf("#%06x",rand(0,16777215));
if ($i == $page ) {
echo "&nbsp;<b><font color=#787a8d><a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a></font></b>" ;
} else {
echo "&nbsp;<a href=main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=".$i."  title=\"ไปหน้า $i\" style=\"color:$bgcolor\">".$i."</a>" ;
}
$icount++;
}
if ($page < $totalpage) {
$next = $page +1;
if ($end < $totalpage) { echo "....."; }
echo "&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$next\" title=\"หน้าต่อไป Next Page\">>><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
echo "&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$totalpage\" title=\"หน้าสุดท้าย Last Page\">>|<img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
}
echo "<p>ขณะนี้คุณอยู่ที่หน้า $page</p></div>";

?>
