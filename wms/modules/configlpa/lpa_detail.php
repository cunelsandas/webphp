<?php
	$modid=$_GET['_modid'];
	$mod=$_GET['_mod'];
    $modname=FindRS("select modname from tb_mod where modid=$modid","modname");
    $tablename="tb_lpa_detail";
	$type=$_GET['type'];


	$btvalue="addnew";
	$sqlShow="select * from $tablename Order by menuid ASC,submenuid ASC ,listno ASC";
	$rsShow=rsQuery($sqlShow);
	if($rsShow || msyqli_num_rows($rsShow)>0){
		while($data=mysqli_fetch_assoc($rsShow)){
			$id=$data['id'];
			$menuid=$data['menuid'];
			$menuname=FindRS("select * from tb_lpa_menu where id=".$menuid,"name");
			$submenuid=$data['submenuid'];
			$submenuname=FindRS("select * from tb_lpa_submenu where id=".$submenuid,"name");
			$name=$data['name'];
			$listno=$data['listno'];
			$modname=$data['modname'];
			$link=$data['link'];
			$strTableDetail .="<tr><td>$menuname</td><td>$submenuname</td><td>$name</td><td align='center'>$listno</td><td>$modname</td><td>$link</td><td align='center'><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=".$type."&id=".$id."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=".$type."&del=".$id."\" onclick=\"return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่ ?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
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
		$vmodname=$data['modname'];
		$vlink=$data['link'];
		$vsubmenuid=$data['submenuid'];
	}
	}

	if(isset($_POST['btsave'])){
		
		$id=$_POST['id'];
		$name=$_POST['name'];
		$listno=($_POST['listno']=="")?"0":$_POST['listno'];
		$menuid=$_POST['menu'];
		$submenuid=$_POST['submenu'];
		$modname=$_POST['modname'];
		$link=$_POST['link'];

		if($_POST['btsave']=="addnew"){
			$sql="insert into $tablename(name,listno,menuid,submenuid,modname,link)values('$name',$listno,$menuid,$submenuid,'$modname','$link')";
			$msg="เพิ่มข้อมูลใหม่สำเร็จ";
		}else{
			$sql="update $tablename SET name='$name',listno=$listno,menuid=$menuid,submenuid=$submenuid,modname='$modname',link='$link' where id=$id";
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
	<p>รายละเอียด การประเมิน lpa</p>
	<hr>
		<div class='content-input'>
			<table width='100%'>
				<tr>
					<td>หัวข้อหลัก</td>
					<td>
							<select name='menu'>
								<?php
									$sql="select * from tb_lpa_menu order by listno ASC";
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
					<td>หัวข้อรอง</td>
					<td>
							<select name='submenu'>
								<?php
									$sql="select * from tb_lpa_submenu order by menuid ASC ,listno ASC";
									$rsMenu=rsQuery($sql);
									if($rsMenu){
										while($dMenu=mysqli_fetch_assoc($rsMenu)){
											$id=$dMenu['id'];
											$name=$dMenu['name'];
											if($id==$vsubmenuid){ //undefined variable use ''
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
					<td>รายละเอียด</td>
					<td><input type='text' name='name' value='<?php echo $vname;?>' size='40'>&nbsp;ลำดับที่<input type='text' name='listno' value='<?php echo $vlistno;?>'></td>
				</tr>
				<tr>
					<td>โมดูล</td>
					<td>
						<select name='modid' id='modid' onchange="getLink(this.value,'modid');">
							<option value=''>ไม่เลือก</option>
							<?php
								$sql="select * from tb_mod order by modid ASC";
								$rsmod=rsQuery($sql);
								if($rsmod){
									while($dMod=mysqli_fetch_assoc($rsmod)){
										$mid="index.php?_mod=".encode64($dMod['modtype']);
										$mname=$dMod['modname'];
										echo "<option value='$mid'>$mname</option>";
									}
								}
							?>
						</select>
						&nbsp;ไฟล์เอกสาร
						<select name='files' id='files' onchange="getLink(this.value,'files');">
							<option value=''>ไม่เลือก</option>
							<?php
								$sql="select * from tb_filestype order by fid";
								$rsfile=rsQuery($sql);
								if($rsfile){
									while($dfile=mysqli_fetch_assoc($rsfile)){
										$fid="index.php?_mod=".encode64('files')."&type=".encode64($dfile['fid']);
										$fname=$dfile['name'];
										echo "<option value='$fid'>$fname</option>";
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Link</td>
					<td><input type='text' name='link' id='link' value='<?php echo $vlink;?>' size='40'><input type='text' name='modname' id='modname' value='<?php echo $vmodname;?>'></td>
				</tr>
				<tr>
				
					<td><input type='hidden' name='id' value='<?php echo $vid;?>'></td>
					<td><input type='submit' name='btsave' value='<?php echo $btvalue;?>'></td>
				</tr>
			</table>
		</div>

		<div class='content-table'>
			<table width='100%'>
				<tr>
					<th width='10%'>หัวข้อหลัก</th>
					<th width='10%'>หัวข้อย่อย
					<th width='25%'>รายละเอียด</th>
					<th width='5%'>ลำดับ</th>
					<th width='10%'>module</th>
					<th width='10%'>link</th>
					<th width='7%'></th>
				</tr>
				<?php echo $strTableDetail;?>
			</table>
		</div>
</div>
</form>
<script>
function getLink(link,select_id) {
  var x = link; //document.getElementById("modid").value;
  var e = document.getElementById(select_id);
  var strE = e.options[e.selectedIndex].text;
 
	document.getElementById("link").value =  x ;
	document.getElementById("modname").value=strE;

}
</script>
