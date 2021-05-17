<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
 </head>
<?php
	$btname="addnew";

	if(isset($_POST['btsave'])){
		$id=$_POST['txtid'];
		$modid=$_POST['cbomodid'];
		$pagestyle=$_POST['cbopagestyle'];
		$itemcount=$_POST['txtitemcount'];
		$listno=$_POST['txtlistno'];
		
		if($_POST['active']=="on"){
			$status="1";
		}else{
			$status="0";
		}
		switch($_POST['btsave']){
			case "addnew":
				$sql="insert into tb_defaultpage(modid,pagestyle,itemcount,listno,status) value('$modid','$pagestyle','$itemcount','$listno','$status')";
				break;
			case "edit":
				$sql="update tb_defaultpage SET modid='$modid',pagestyle='$pagestyle',itemcount='$itemcount',listno='$listno',status='$status' where id='$id'";
				break;
		}
			$rs=rsQuery($sql);
		
			$btname="addnew";
}
	if(isset($_GET['id'])){
		$sql="select * from tb_defaultpage where id=".$_GET['id'];
		$rs=rsQuery($sql);
		$data=mysqli_fetch_array($rs);
		$v_id=$data['id'];
		$v_modid=$data['modid'];
		$v_pagestyle=$data['pagestyle'];
		$v_itemcount=$data['itemcount'];
		$v_listno=$data['listno'];
		$v_status=$data['status'];
		$btname="edit";
	}

	if(isset($_GET['del'])){
			$sql="delete from tb_defaultpage where id=".$_GET['del'];
			$del=rsQuery($sql);
	}
?>
 <body>
  <div class='content-box'>
		<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
		<p style="right:12%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=addnew\"  class='link'>เพิ่มรายการใหม่</a>";?></p>
		<br><br>
			<table class="content-input" width="90%">
				<tr><input type="hidden" name="txtid" value="<?php echo $v_id;?>">
					<td>module</td><td><select name="cbomodid">
						<?php
							$strsql="select * from tb_mod where typeid < 4";
							$rs=rsQuery($strsql);
							while($data=mysqli_fetch_assoc($rs)){
								if($data['modid']==$v_modid){
									echo "<option value='".$data['modid']."' selected>".$data['modname']."</option>";
								}else{
									echo "<option value='".$data['modid']."'>".$data['modname']."</option>";
								}
							}
						?>
						</select></td>
				</tr>
				<tr>
					<td>รูปแบบการแสดงผล</td><td><select name="cbopagestyle">
						<?php
							$strsql="select * from tb_pagestyle";
							$rs=rsQuery($strsql);
							while($data=mysqli_fetch_assoc($rs)){
								if($data['name']==$v_pagestyle){
									echo "<option value='".$data['name']."' selected>".$data['name']."</option>";
								}else{
									echo "<option value='".$data['name']."'>".$data['name']."</option>";
								}
							}
						?>
						</select></td>
				</tr>
				<tr>
					<td>จำนวนแสดงผล</td><td><input type="text" name="txtitemcount" value="<?php echo $v_itemcount;?>"></td>
				</tr>
				<tr>
					<td>ลำดับการแสดงผล</td><td><input type="text" name="txtlistno" value="<?php echo $v_listno;?>"></td>
				</tr>
				<tr>
					<td>สถานะการแสดงผล</td><td>
							<?php 
								if($v_status=="0"){
							?>
								<input type="checkbox" name="active" />&nbsp;Active
							<?php
								}else{
							?>
								<input type="checkbox" name="active" checked />&nbsp;Active
							<?php
								}
							?>
					</td>
				</tr>
				<tr><td></td><td><input type="submit" name="btsave" value="<?php echo $btname;?>"></td></tr>
			</table>
			</form>
			<br><br>
			<table width="90%" class="content-table">
				<tr>
					<th>id</th><th>รายการ</th><th>สถานะ</th><th>ลำดับการแสดงผล</th><th>จัดการ</th>
				</tr>
				<?php
					$sql="select * from tb_defaultpage order by listno";
					$rs=rsQuery($sql);
					if($rs){
						while($data=mysqli_fetch_assoc($rs)){
							echo "<tr><td>".$data['id']."</td>";
							echo "<td>".FindRS("select * from tb_mod where modid=".$data['modid'],"modname")."</td>";
							echo "<td>".$data['status']."</td>";
							echo "<td>".$data['listno']."</td>";
							echo "<td><a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&type=view&id=".$data['id']."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&del=".$data['id']."\" onclick=\"return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td></tr>";

						}
					}
				?>
		</table>
  </div>
 </body>
</html>
