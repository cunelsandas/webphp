<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername=$gloUploadPath.$folder."/";
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	
?>

<?php

if(isset($_POST['btadd'])){
	$name=EscapeValue($_POST['txtname']);
	$detail=$_POST['mytextarea'];
	$listno=EscapeValue($_POST['txtlistno']);
	$groupid=$_POST['cbogroupid'];
	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
$sql="UPDATE $table SET name='$name',status='$ac',detail='$detail',listno='$listno',groupid='$groupid' Where id='".EscapeValue($_GET['id'])."'";
	$rs=rsQuery($sql);
	if($rs){
		

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($table,'edit',$_SESSION['username'],$name);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where id='".EscapeValue($_GET['id'])."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr>
	<td width="25%">ชื่อหน่วยงาน</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" value="<?php echo $row['name'];?>" /></td>
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
					if($row['groupid']==$id){
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
	<td><input type=text  class=txt1 name=txtlistno  value="<?php echo $row['listno']?>"></td>
</tr>
<tr>
	<td>อำนาจหน้าที่</td>
	<td>
        <textarea name="mytextarea" id="mytextarea" > <?php echo $row['detail']; ?> </textarea>
</tr>

<tr>
	<td>&nbsp;</td>
	<td>
	<?php 
	if($row['status']=="0"){
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
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="แก้ไข" /></td>
</tr>
</table>

</form>