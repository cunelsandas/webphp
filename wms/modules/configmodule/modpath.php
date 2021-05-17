<?php
	$btname="addnew";
	if(isset($_GET['id'])){
		$sql="select * from tb_modpath where id=".$_GET['id'];
		$rs=rsQuery($sql);
		$data=mysqli_fetch_assoc($rs);
		$v_id=$data['id'];
		$v_name=$data['name'];
		$v_wms_path=$data['wms_path'];
		$v_web_path=$data['web_path'];
		$v_server_path=$data['server_path'];
		$v_create_table=$data['create_table'];
		$btname="edit";
}
	if(isset($_POST['btsave'])){

		$btname="addnew";
		$id=$_POST['txtid'];
		$name=$_POST['txtname'];
		$wms_path=$_POST['txtwms_path'];
		$web_path=$_POST['txtweb_path'];
		$server_path=$_POST['txtserver_path'];
		$create_table=$_POST['txtcreate_table'];
		switch($_POST['btsave']){
			case "addnew":
				$strSql="insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('$name','$wms_path','$web_path','$server_path','$create_table')";
				break;

			case "edit":
				$strSql="Update tb_modpath SET name='$name',wms_path='$wms_path',web_path='$web_path',server_path='$server_path',create_table='$create_table' Where id=".$id;
				break;
		}
		$rs=rsQuery($strSql);
		if($rs){

			echo "<script>alert('บันทึกข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."';</script>";
		}
	}
?>
<div class="content-box">
	<form name="frmModpath" action="" method="post" enctype="multipath/form-data">
		<table class='content-input' width="90%">
			<tr>
				<td>id</td><td><?php echo $v_id;?><input type="hidden" name="txtid" value="<?php echo $v_id;?>"></td>
			</tr>
			<tr>
				<td>name</td><td><input type="text" name="txtname" value="<?php echo $v_name;?>"></td>
			</tr>
			<tr>
				<td>wms_path</td><td><input type="text" name="txtwms_path" value="<?php echo $v_wms_path;?>" size="100"></td>
			</tr>
			<tr>
				<td>web_path</td><td><input type="text" name="txtweb_path" value="<?php echo $v_web_path;?>" size="100"></td>
			</tr>
			<tr>
				<td>server_path</td><td><input type="text" name="txtserver_path" value="<?php echo $v_server_path;?>" size="100"></td>
			</tr>
			<tr>
				<td>script create table</td><td><textarea name="txtcreate_table" cols="100" rows="6"><?php echo $v_create_table;?></textarea></td>
			</tr>
			<tr>
				<td></td><td><input type="submit" name="btsave" value="<?php echo $btname;?>"></td>
			</tr>
		</table>
	</form>

	<br>
		<table class='content-table'>
			<tr>
				<th>id</th>
				<th>name</th>
				<th>wms_path</th>
				<th>web_path</th>
				<th>server_path</th>
				<th>create_table</th>
				<th>จัดการ</th>
			</tr>
			<?php
				$sql="select * from tb_modpath";
				$rs=rsQuery($sql);
				if(mysqli_num_rows($rs)>0){
					while($data=mysqli_fetch_assoc($rs)){
						echo "<tr><td>".$data['id']."</td><td>".$data['name']."</td><td>".$data['wms_path']."</td><td>".$data['web_path']."</td><td>".$data['server_path']."</td><td>".$data['create_table']."</td><td><a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=view&id=".$data['id']."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a></td></tr>";
						}
				}
			?>
		</table>
</div>
