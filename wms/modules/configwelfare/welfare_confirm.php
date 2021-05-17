<?php
	if(isset($_GET['del'])){
		$delid=$_GET['del'];
		$strDel="Delete from tb_citizen where id=$delid";
		$rsDel=rsQuery($strDel);
		echo "<script>alert('ลบข้อมูล id $delid ออกจากระบบแล้ว')</script>";
}

	$sql = 'SELECT b.name AS recname,c.name AS stname,a.id AS idmain,a.*,b.*,c.* FROM tb_welfare_request a INNER JOIN tb_welfare_type b on a.type = b.id INNER JOIN tb_welfare_status c ON a.status = c.id WHERE status = 1';


if (isset($_POST['btsave']) != "") {
$typex = 0;
	$idprename = $_POST['frm_idprename'];
	$status = $_POST['frm_status'];

	if ($idprename != "" && $status == "") { //ค้นหาเลขบัตร
		$sql = "SELECT b.name AS recname,c.name AS stname,a.id AS idmain,a.*,b.*,c.* FROM tb_welfare_request a INNER JOIN tb_welfare_type b on a.type = b.id INNER JOIN tb_welfare_status c ON a.status = c.id WHERE personid = $idprename";
	}elseif ($idprename == "" && $status != "") {//ค้นหาสถานะ
		$sql = "SELECT b.name AS recname,c.name AS stname,a.id AS idmain,a.*,b.*,c.* FROM tb_welfare_request a INNER JOIN tb_welfare_type b on a.type = b.id INNER JOIN tb_welfare_status c ON a.status = c.id WHERE status = $status";
	}elseif ($idprename != "" && $status != "") {//ค้นหาทั้งสอง
		$sql = "SELECT b.name AS recname,c.name AS stname,a.id AS idmain,a.*,b.*,c.* FROM tb_welfare_request a INNER JOIN tb_welfare_type b on a.type = b.id INNER JOIN tb_welfare_status c ON a.status = c.id WHERE personid = $idprename AND status = $status";
	}elseif ($idprename == "" && $status == "") {//ค้นหาทั้งสอง
		$sql = "SELECT b.name AS recname,c.name AS stname,a.id AS idmain,a.*,b.*,c.* FROM tb_welfare_request a INNER JOIN tb_welfare_type b on a.type = b.id INNER JOIN tb_welfare_status c ON a.status = c.id";
	}
}


?>

<style>
table .data {
  width: 100%;
}

 .data td, th {
  padding: 8px;
  border: 0px;
}

.data  tr:hover td {
	background-color:#A2AB58;
}

</style>


<fieldset>
	<div class="content-table">
    <h3>ข้อมูลรออนุมัติ</h3>
    <hr>

<br>
		<div class="content-input" style="width:90%;">
			<form name="frmData" method="POST" action="" enctype="multipart/form-data">
			<table width="100%" class="data">
				<tr>
					<td>ค้นหาเลขบัตรประชาชน:
						<input type="text" name="frm_idprename">
					</td>

					<td>ค้นหาสถานะ:
						<select name="frm_status">
							<option value=''>แสดงทั้งหมด</option>
			      <?php
			        $sqlmoo="select * from tb_welfare_status order by id";
			      $rsmoo=rsQuery($sqlmoo);
			      if($rsmoo){
			        while($dmoo=mysqli_fetch_assoc($rsmoo)){
			          $mooid=$dmoo['id'];
			          $mooname=$dmoo['name'];
			          if($mooid=="1"){
			            echo "<option value='$mooid' selected>$mooname</option>";
			          }else{
			            echo "<option value='$mooid'>$mooname</option>";
			          }
			        }
			      }
			      ?>
			      </select></td>

				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" name="btsave" value="ค้นหา">
				</tr>
			</table>
		</form>
</div>

    <br>
	<table width="100%">
		<tr>
			<th>เลขบัตรประชาชน</th>
			<th>วันที่ขอ</th>
      <th>ประเภทเบี้ย</th>
			<th>สถานะ</th>
			<th>รายละเอียด</th>
			<th>แก้ไข</th>
		</tr>
		<?php
    $rs=rsQuery($sql);
			$no=0;
			if(mysqli_num_rows($rs)>0){
					while($row=mysqli_fetch_array($rs)){
            $id = $row['idmain'];
						$type = $row['recname'];
            $registerdate=DateThai($row['requestdate']);
						$personid=$row['personid'];
            $status = $row['stname'];
						$detail = $row['detail'];

						echo "<tr><td>$personid</td><td>$registerdate</td><td>$type</td><td>$status</td><td>$detail</td>";

						if ($row['status'] != "5") {
							echo "<td><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=welfare_confirm_view&id=".$id."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></td>";
						}else {
							echo "<td></td>";
						}

					}

			}else{
				echo "<tr><td colspan='6' align=center>ยังไม่มีข้อมูล</td></tr>";
			}
		?>
	</table>
	</div>
</fieldset>
