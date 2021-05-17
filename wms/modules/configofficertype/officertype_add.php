<?php
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername=$gloUploadPath.$folder."/";

if(isset($_POST['btadd'])){
	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}//institute=ลำดับการแสดง

	$sql="INSERT INTO $table(name,status,detail,listno,groupid) Values('".EscapeValue($_POST['txtname'])."','$ac','".$_POST['mytextarea']."','" .EscapeValue($_POST['txtlistno'])."','".$_POST['cbogroupid']."')";
	echo $sql;
	$rs=rsQuery($sql);
	if($rs){
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($table,'add',$_SESSION['username'],$_POST['txtname']);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
	//echo $sql;
}
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr>
	<td width="25%">ชื่อหน่วยงาน</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" /></td>
</tr>
<tr>
	<td>กลุ่มเมนู (menu group)</td>
	<td>
		<select name="cbogroupid"><option value='0'>ไม่แสดง</option>
		<?php
			$sql="select * from tb_menugroup order by id";
			$rs=rsQuery($sql);
			if($rs){
				while($data=mysqli_fetch_assoc($rs)){
					$name=$data['name'];
					$id=$data['id'];
					if($v_groupid==$id){
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
	<td>ลำดับการแสดง</td>
	<td><input type=text  class=txt1 name=txtlistno size=5></td>
</tr>
<tr>
	<td>อำนาจหน้าที่</td>
	<td><textarea name="mytextarea" id="mytextarea" > </textarea>
	</td>
</tr>

<tr>
	<td>&nbsp;</td>
	<td><input type="checkbox" name="active" />&nbsp;Active</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
</form>
