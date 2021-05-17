<script type="text/javascript" src="http://itglobal.co.th/itgmod/js01.js"></script>
<script>
function ajaxCall(select_id,displayid,tablename){
		var data="select_id="+select_id+"&tablename="+tablename;
		var URL="../itgmod/searchdata.php";
		ajaxLoad("get",URL,data,displayid);
}

	function ajaxShowTable(select_id,displayid,tablename,modid){
		var data="select_id="+select_id+"&tablename="+tablename+"&modid="+modid;
		var URL="../itgmod/searchdata.php";
		ajaxLoad("get",URL,data,displayid);
}
</script>
<?php
$btname="addnew";
$modid=$_GET['_modid'];
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
if(isset($_POST['btsave'])){
		$id=$_POST['txtid'];
		$name=$_POST['txtname'];
		$listno=$_POST['txtlistno'];
		$offid=$_POST['cbotype'];
		$workgroupid=$_POST['workgroup'];
	switch($_POST['btsave']){
	
		case "addnew":
			$sql="insert into $tablename(name,offid,workgroupid,listno) values('$name','$offid','$workgroupid','$listno')";
			$alert="<script>alert('บันทึกข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
			
			break;

		case "edit":
			$sql="update $tablename SET name='$name',offid='$offid',listno='$listno',workgroupid='$workgroupid' Where id=$id";
			$alert="<script>alert('แก้ไขข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
			break;
	}
		$btname="addnew";
		$rs=rsQuery($sql);
		if($rs){
			echo $alert;
		}

}
if(isset($_GET['del'])){
	$delid=$_GET['del'];
	$sql="delete from $tablename where id=$delid";
	$rsDel=rsQuery($sql);
	echo "<script>alert('ลบข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";

}

if(isset($_GET['id'])){
	$btname="edit";
	$sql="select * from $tablename where id=".$_GET['id'];
	$rs=rsQuery($sql);
	if($rs){
		$data=mysqli_fetch_assoc($rs);
		$v_id=$data['id'];
		$v_name=$data['name'];
		$v_listno=$data['listno'];
		$v_offid=$data['offid'];
		$v_workgroupid=$data['workgroupid'];
		$v_workgroupname=FindRS("select * from tb_officer_workgroup where id=".$v_workgroupid,"name");
		}
}
?>

<div class="content-box">
<?php
	echo $modname;
	echo "<hr>";
?>
<p style="right:10%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnews\" class=\"link\">เพิ่มข้อมูลใหม่</a>";?></p><br><br>
<form method="post" action="" name="frm01" id="frm01">
	<table width="90%" class="content-input">
		<tr>
			<td width="20%">หน่วยงาน</td><td><select name="cbotype" id="cbotype" onchange="ajaxCall(this.value,'workgroup','tb_officer_workgroup');">
				<option value="">เลือก</option>
				<?php
					$sql="select * from tb_officertype where status>0 order by listno";

					$rs=rsQuery($sql);
					if($rs){
						while($data=mysqli_fetch_assoc($rs)){
							$id=$data['id'];
							$name=$data['name'];

							if($v_offid==$id){
								echo "<option value='$id' selected>$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";
							}
						}
					}
				?>
				</select></td>
			</tr>
			<tr>
				<td>สายงานหลัก</td>
				<td><select name="workgroup" id="workgroup" onchange="ajaxShowTable(this.value,'showworkgroup','tb_officer_workgroup',<?php echo $modid;?> );">
				<option value="<?php echo $v_workgroupid;?>"><?php echo $v_workgroupname;?></option>
				
</select>
				
							
						
				</td>
			</tr>
			<tr><td>id:<?php echo $v_id;?></td><td><input type="hidden" name="txtid" value="<?php echo $v_id;?>"></td></tr>
			<tr>
				<td>ชื่อสายงานย่อย</td><td><input type="text" name="txtname" id="txtname" value="<?php echo $v_name;?>"></td>
			</tr>
			<tr>
				<td>ลำดับการแสดงผล</td><td><input type="text" name="txtlistno" value="<?php echo $v_listno;?>"></td>
			</tr>
			<tr>
				<td></td><td><input type="submit" name="btsave" id="btsave" value="<?php echo $btname;?>">&nbsp;&nbsp;</td>
			</tr>
		</table>
		<div id="showdata">
		<table width="100%" class="content-table" >
	<thead>
		<tr>
			<th width="50%" class="topleft">รายการ</th>
			<th width="25%" align="center">ลำดับ</th>
			
			<th width="25%" align="center" class="topright">ปรับปรุง</th>
		</tr>
	</thead>
	  <tfoot>
    	<tr>
        	<td colspan="4" class="botleft"><em></em></td>
        	<td class="botright">&nbsp;</td>
        </tr>
    </tfoot>
<?php
############################# แบ่งหน้าเพื่อให้แสดงผลรวดเร็ว #######################
$pagelen = 20; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	if(isset($_GET['page'])){ 
		$page=EscapeValue($_GET['page']);
	}else{
		$page="1";
	}
	
	$officertype=$_GET['type'];
	if(empty($officertype)){
		$offtype="";
		$otype="";
	}else{
		$offtype="Where filetypeid=$officertype";
		$otype=$officertype;
	}
	$sql = "select no from $tablename $offtype order by filetypeid,no ASC"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	$result = rsQuery($sql);
	
	
	if($result){
		$totalrecords= $num_rows = mysqli_num_rows($result); //หาจำนวนแถวของขัอมูลทั้งหมด
	}else{
		$totalrecords = $num_rows ="0";
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
	
		$sql="select * from tb_officer_subworkgroup order by id ";

$Query = rsQuery($sql); //คิวรี่คำสั่ง
	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalp==0){
		echo"<tr height=\"30\">";
		echo"<td colspan=\"5\" align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</td>";
		echo"</tr>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		while($arr = mysqli_fetch_assoc($Query)){
			echo"<tr>";
			echo"<td>&nbsp;".$arr['name']."</td>";
			//echo"<td>".$arr['filetypeid']."</td>";
			echo"<td>".$arr['listno']."</td>";
			
			
			echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&id=".$arr['id']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบหัวข้อข่าวนี้หรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";			
			$i++;
		}
	}
	echo"</table>";
echo "<div id=\"page_count\">";
if ($page > 1) {
	$back = $page - 1;
	echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$otype&page=1\" title=\"หน้าแรก First Page\">|<<img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>";
	echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$otype&page=$back\" title=\"ย้อนกลับ Previous Page\"><<<img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	if ($start > 1) { echo "....."; }
}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = sprintf("#%06x",rand(0,16777215)); //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "&nbsp;<b><font color=#787a8d><a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a></font></b>" ;
		} else {
			echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$otype&page=".$i."\" title=\"ไปหน้าที่ $i\" style=\"color:$bgcolor\">".$i."</a>" ;
		}
		$icount++;
	}
	if ($page < $totalpage) {
	$next = $page +1;
	if ($end < $totalpage) { echo "....."; }
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$otype&page=$next\" title=\"หน้าต่อไป Next Page\">>><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$otype&page=$totalpage\" title=\"หน้าสุดท้าย Last Page\">>|<img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	}
	echo "<p>ขณะนี้คุณอยู่ที่หน้า $page</p></div>";

?>

</div>
</form>


</div>