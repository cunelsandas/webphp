
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">


<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


<fieldset>

<?php //echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=persondata_add\" class='line'>เพิ่มข้อมูลใหม่</a>";?>

	<div class="content-table">
		<h3>จำหน่ายผู้มีสิทธิ์</h3>
    <hr>
		<br>
		<table id="example" class="cell-border" style="width: 100%;">
		  <thead>
			<tr>
			<th>ลำดับ</th>
			<th>วันที่ลงทะเบียน</th>
			<th>เลขบัตรประชาชน</th>
			<th>ชื่อ - นามสกุล</th>
			<th>สถานะ</th>
			<th>จำหน่าย</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql="select * from tb_citizen Order by id ASC";
			$rs=rsQuery($sql);
			$no=0;
			if(mysqli_num_rows($rs)>0){
					while($dperson=mysqli_fetch_assoc($rs)){
						$no+=1;
						$id=$dperson['id'];
						$personid=$dperson['personid'];
						$name=$dperson['name'];
						$surname=$dperson['surname'];
						$registerdate=DateThai($dperson['registerdate']);
						$idstatus = $dperson['status'];
						$status = FindRS("select name from tb_citizen_status where id = $idstatus","name");
						echo "<tr><td>$no</td><td>$registerdate</td><td>$personid</td><td>$name&nbsp;$surname</td><td>$status</td>";
					if ($dperson['status'] != "3") {
						echo "<td><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=persondata_denied_view&id=".$id."\"><img style='width:22px' src=\"../images/component/denied.png\" border=\"0\"/></a></td>";
					}else {
						echo "<td></td>";
					}
					}

			}else{
				echo "<tr><td colspan='6'>ยังไม่มีข้อมูล</td></tr>";
			}
		?>
		</tbody>
	</table>
	</div>
</fieldset>

<script language="JavaScript">

$(document).ready(function() {
    $('#example').DataTable();
} );

</script>
