<?php
	$modid=$_GET['_modid'];
	$mod=$_GET['_mod'];
    $modname=FindRS("select modname from tb_mod where modid=$modid","modname");
    $tablename="tb_lpa_submenu_2563";
	$type=$_GET['type'];


	$btvalue="addnew";
	$sqlShow="select * from $tablename Order by menuid ASC ,listno ASC";
	$rsShow=rsQuery($sqlShow);
	if($rsShow || msyqli_num_rows($rsShow)>0){
		while($data=mysqli_fetch_assoc($rsShow)){
			$id=$data['id'];
			$menuid=$data['menuid'];
			$menuname=FindRS("select * from tb_lpa_menu_2563 where id=".$menuid,"name");
			$name=$data['name'];
			$listno=$data['listno'];
			$strTableDetail .="<tr><td>$menuname</td><td>$name</td><td align='center'>$listno</td><td align='center'><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=".$type."&id=".$id."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=".$type."&del=".$id."\" onclick=\"return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่ ?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
		}

	}
	if(isset($_GET['id'])){
	$id=$_GET['id'];
	$sql="select * from $tablename where id=$id";
	$rsView=rsQuery($sql);
	if($rsView){
		$data=mysqli_fetch_assoc($rsView);
		$vid=$data['id'];
		$vname=$data['name'];
		$vlistno=$data['listno'];
		$btvalue="edit";
		$vmenuid=$data['menuid'];
	}
	}

	if(isset($_POST['btsave'])){
		
		$id=$_POST['id'];
		$name=$_POST['name'];
		$listno=($_POST['listno']=="")?"0":$_POST['listno'];
		$menuid=$_POST['menu'];
		if($_POST['btsave']=="addnew"){
			$sql="insert into $tablename(name,listno,menuid)values('$name',$listno,$menuid)";
			$msg="เพิ่มข้อมูลใหม่สำเร็จ";
		}else{
			$sql="update $tablename SET name='$name',listno=$listno,menuid=$menuid where id=$id";
			$msg="แก้ไขข้อมูลสำเร็จ";
		}
			$rs=rsQuery($sql);
			if($rs){
				echo "<script>alert('".$msg."');window.location.href='main.php?_modid=".$modid."&_mod=".$mod."&type=".$type."';</script>";
			}
			

	}

	if(isset($_GET['del'])){
        $sql = "DELETE From $tablename Where id='" . $_GET['del'] . "'";
        $rs=rsQuery($sql);
        if($rs){
            // update table tb_trans บันทึกการลบ
            $updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$_GET['del']);
            echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=".$type."';</script>";
        }
    }

?>
<form name='frmlpa' action='' method='POST'>
<div class='content-box'>
	<p>หัวข้อย่อย การประเมิน lpa</p>
	<hr>
		<div class='content-input'>
			<table width='100%'>
				<tr>
					<td>หัวข้อหลัก
							<select name='menu'>
								<?php
									$sql="select * from tb_lpa_menu_2563 order by listno ASC";
									$rsMenu=rsQuery($sql);
									if($rsMenu){
										while($dMenu=mysqli_fetch_assoc($rsMenu)){
											$id=$dMenu['id'];
											$name=$dMenu['name'];
											if($id==$vmenuid){
												echo "<option value='$id' selected>$name</option>";
											}else{
												echo "<option value='$id'>$name</option>";
											}
										}
									}
								?>
							</select>
					</td>
				</tr>
				<tr>
					<td>ชื่อ<input type='text' name='name' value='<?php echo $vname;?>' size='40'>&nbsp;ลำดับที่<input type='text' name='listno' value='<?php echo $vlistno;?>'></td>
				</tr>
				<tr>
					<td><input type='hidden' name='id' value='<?php echo $vid;?>'><input type='submit' name='btsave' value='<?php echo $btvalue;?>'></td>
				</tr>
			</table>
		</div>

		<div class='content-table'>
			<table width='100%'>
				<tr>
					<th width='40%'>หัวข้อหลัก</th>
					<th width='30%'>รายการ</th>
					<th width='20%'>ลำดับการแสดงผล</th>
					<th width='10%'></th>
				</tr>
				<?php echo $strTableDetail;?>
			</table>
		</div>
</div>
</form>

