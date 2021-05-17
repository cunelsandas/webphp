<?php
	$btname="edit";
	$btdetail="addnew";
	$masterid=$_REQUEST['no'];
	$sql="select * from $tablename where id=$masterid";
	$rs=rsQuery($sql);
	if($rs){
		$data=mysqli_fetch_assoc($rs);
		$v_id=$data['id'];
		$v_name=$data['name'];
		$v_status=$data['status'];
		$v_date=ChangeYear($data['date'],"th");
		$sqldetail="select * from vote_detail where masterid=$v_id Order by id ASC";
		$rsdetail=rsQuery($sqldetail);
	}

	if(isset($_POST['btsave'])){
		$name=$_POST['txtname'];
		$date=ChangeYear($_POST['txtdate'],"en");
		$masterid=$_POST['txtmasterid'];
		$sql="Update $tablename set name='$name',date='$date' where id='$masterid'";
		$rs=rsQuery($sql);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=$masterid';</script>";
	}
	if(isset($_GET['detailid'])){
		$btdetail="edit";
		$v_detail=FindRS("select * from vote_detail where id=".$_GET['detailid'],"name");
		$v_id2=FindRS("select * from vote_detail where id=".$_GET['detailid'],"id");
	}
	if(isset($_POST['btdetail'])){
		$detail=$_POST['txtdetail'];
		$masterid=$_POST['txtmasterid'];
		$masterid2=$_POST['txtmasterid2'];
		switch($_POST['btdetail']){
			case "addnew":
				$sql="INSERT INTO vote_detail(name,masterid)values('$detail','$masterid')";
				break;
			case "edit":
				$sql="UPDATE vote_detail SET name='$detail' Where id='$masterid2'";
				break;
		}
		$btdetail="addnew";
		$rs=rsQuery($sql);

		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=$masterid';</script>";

	}

	if(isset($_GET['deldetail'])){

		$id = $_GET['deldetail'];
		$Mid = $_GET['no'];

		$sql="DELETE FROM vote_detail WHERE id = $id";
		$rs=rsQuery($sql);

		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=$Mid';</script>";

	}

	echo '<form name="frmvote_detail" method="POST" action="" enctype="multipart/form-data">';
	echo "<table class='content-input'>";
	echo "<tr><td>id</td><td>$v_id</td></tr>";
	echo "<tr><td>ชื่อหัวข้อ</td><td><input type='text' name='txtname' size='80' value='$v_name'></td></tr>";
	echo "<tr><td>วันที่</td><td><input type='text' name='txtdate' id='txtdate' value='$v_date'></td></tr>";
	echo "<tr><td></td><td><input type='submit' name='btsave' value='$btname'></td></tr>";
	echo "</table>";
	echo "<br>";
	echo "<table class='content-input'>";
	echo "<tr><td>ตัวเลือก</td><td><input type='text' name='txtdetail' value='$v_detail' size='80'></td><td><input type='submit' name='btdetail' value='$btdetail'><input type='hidden' name='txtmasterid' value='$v_id'><input type='hidden' name='txtmasterid2' value='$v_id2'></td></tr>";
	echo "</table>";
	echo "<br>";
	echo "<table class='content-table'>";
	echo "<tr>";
	echo "<th width='80%'>ตัวเลือก</th>";
	echo "<th width='20%'>จัดการ</th>";
	echo "</tr>";
	while($detail=mysqli_fetch_assoc($rsdetail)){
			$detail_id=$detail['id'];
			$detail_name=$detail['name'];
			echo "<tr><td>$detail_name</td>";
			echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$masterid."&detailid=".$detail_id."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$masterid."&deldetail=".$detail_id."\" onclick=\"return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";
	}
	echo "</table>";

	echo "</form>";
?>
