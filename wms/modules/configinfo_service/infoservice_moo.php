<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
 </head>

 <body>
  <?php
	$btname="addnew";
$modid=$_GET['_modid'];
		$v_id="";
		$v_name="";
		

		$tablename="tb_infoservice_moo";

		if(isset($_GET['del'])){
		$sql="DELETE From $tablename Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);
		if($rs){
				// update table tb_trans บันทึกการลบ
		$updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$id);
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
		if(isset($_POST['btsave'])){
			$btname=$_POST['btsave'];
			$id=$_POST['editid'];
			$name=EscapeValue($_POST['txtname']);
			if($btname=="addnew"){
				$sql="insert into $tablename(name) values('$name')";
			}
			if($btname=="edit"){
				$sql="update $tablename SET name='$name' Where id='$id'";
			}
			$rsupdate=rsQuery($sql);
			if($rsupdate){
				$updatetran=UpdateTrans($tablename,'add',$_SESSION['username'],'ID:'.$id);
				
				echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
			}

		}

			if(isset($_GET['id'])){
				$sql="select * from $tablename where id=".$_GET['id'];
				$rs=rsQuery($sql);
				if($rs){
					$vdata=mysqli_fetch_assoc($rs);
					$v_id=$vdata['id'];
					$v_name=$vdata['name'];
				}
				$btname="edit";
		}
  ?>
	<form name="frmadd" method="POST" action="">
		
		<table class="content-input">
			<tr>
				<th>ชื่อหมู่/ชื่อหมู่บ้าน</th><td><input type="text" name="txtname" value="<?php echo $v_name;?>"></td>
			</tr>
			<tr>
				<td></td><td><input type="submit" name="btsave" value="<?php echo $btname;?>"><input type="hidden" name="editid" value="<?php echo $v_id;?>"</td>
			</tr>
		</table>
		
	</form>
	<br>
		
			<table width="80%" class="content-table">
				<tr>
					<th>รายการ</th><th>จัดการ</th>
				</tr>
				<?php
					$strsql="select * from $tablename order by id";
					$rs=rsQuery($strsql);
					if($rs){
						while($data=mysqli_fetch_assoc($rs)){
							$id=$data['id'];
							$name=$data['name'];
							echo "<tr><td>$name</td><td><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=moo&id=".$id."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=moo&del=".$id."\" onclick=\"return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td></tr>";
						}
					}
				?>
				</table>
			
 </body>
</html>

