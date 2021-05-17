
<br />&nbsp;&nbsp;&nbsp;<img src="images/component/62.png" />&nbsp;<strong>สายตรงท่านนายกฯ</strong>


<?php
$tb_mas="tb_nayok_mas";
$tb_sub="tb_nayok_sub";
$folder1="nayok_add.php";
$folder2="nayok_view.php";

!empty($_GET['no'])?$no=decode64($_GET['no']):null;
!empty($_GET['type'])?$type=EscapeValue(decode64($_GET['type'])):null;
if($type=="addnew"){
	include $folder1;
}elseif($type=="view"){
	include $folder2;
}else{
	?>
	<p style="margin-left:10px;"><img src="images/component/add_24.png"/>&nbsp;<?php echo"<a class=\"book\" href=\"index.php?_mod=".$_GET['_mod']."&type=".encode64('addnew')." \"> เพิ่มข้อความใหม่</a>";?></p>
	<div id="master-table">
	<?php
	############################# แบ่งหน้าเพื่อให้แสดงผลรวดเร็ว #######################
	if(!isset($_GET['start'])){
		$start1=0;
	}else{
		$start1=$_GET['start'];
	}
	$limit = '20'; // แสดงผลหน้าละกี่หัวข้อ

	/* หาจำนวน record ทั้งหมด
	ปล. อันนี้ต้องใช้กับตัวแบ่งนะ ห้ามเอาออก*/
	$sql="Select * From ".$tb_mas." where status='1'";
	$Qtotal = rsQuery($sql); //คิวรี่ คำสั่ง
	$total = mysqli_num_rows($Qtotal); // หาจำนวน record

	/*คิวรี่ข้อมูลออกมาเพื่อแสดงผล */
	$sql="Select * From ".$tb_mas." Where status='1' Order by wid DESC Limit $start1,$limit";
	$Query = rsQuery($sql); //คิวรี่คำสั่ง
	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalp==0){
		echo"<p style=\"text-align:center;\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</p>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		echo "<table><tr><th width=85% align=left>รายการ</th><th width=15% align=center>ตอบ</th></tr>";
		while($arr = mysqli_fetch_array($Query)){
			echo"<tr><td align=left><a class=\"book\" href=\"index.php?_mod=".$_GET['_mod']."&type=".encode64('view')."&no=".encode64($arr['wid'])."\">";
			echo $arr['subject']."</a><br><font id=text9-clay>&nbsp;&nbsp;โดย :".$arr['postby']."&nbsp;&nbsp;".$arr['updatetime']."</font></td>";
			$sql="Select * From ".$tb_sub." Where wid='".$arr['wid']."'";
			$crs=rsQuery($sql);
			$num=mysqli_num_rows($crs);
			if($num==0){
				echo"<td align=center><font style=\"color:red;\">$num</font><?td>";
			}else{
				echo"<td align=center>$num</td>";
			}
			echo"</tr>";
		}
		echo "</table>";
	}
	/* ตัวแบ่งหน้า */
	$page = ceil($total/$limit); // เอา record ทั้งหมด หารด้วย จำนวนที่จะแสดงของแต่ละหน้า

	/* เอาผลหาร มาวน เป็นตัวเลข เรียงกัน เช่น สมมุติว่าหารได้ 3 เอามาวลก็จะได้ 1 2 3 */
	empty($_GET['page'])?$p="1":$p=$_GET['page'];
	echo"<p style=\"text-align:left;\">&nbsp;&nbsp;&nbsp;";
	for($i=1;$i<=$page;$i++){			
		if($_GET['page']==$i){ //ถ้าตัวแปล page ตรง กับ เลขที่วนได้
			echo"[<a href='index.php?_mod=".$_GET['_mod']."&start=".$limit*($i-1)."&page=$i'><font color=#FF0000><B>$i</B></font></A>]"; //ลิ้งค์ แบ่งหน้า เงื่อนไขที่ 1
		}else{
			echo"[<a href='index.php?_mod=".$_GET['_mod']."&start=".$limit*($i-1)."&page=$i'>$i</A>]"; //ลิ้งค์ แบ่งหน้า เงื่อนไขที่ 2
		}			
	}
	echo"</p>";
?>
<?php
}
?>	

</div>


