<?php
	$table="tb_banner_position";
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$foldername="/fileupload/banner/";

if(isset($_POST['btadd'])){
	$name=EscapeValue($_POST['txtname']);
	$detail=$_POST['mytextarea'];
	$width=EscapeValue($_POST['txtwidth']);
	$height=EscapeValue($_POST['txtheight']);

	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
$sql="UPDATE $table SET name='$name',status='$ac',detail='$detail',banner_width='$width',banner_height='$height' Where id='".$_GET['id']."'";
	$rs=rsQuery($sql);
	if($rs){
		

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$table','edit',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where id='".$_GET['id']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
?>

<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr>
	<td width="25%">ชื่อ Banner</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" value="<?php echo $row['name'];?>" /></td>
</tr>
<tr>
	<td>รายละเอียด</td>
	<td>

        <textarea name="mytextarea" id="mytextarea" > <?php echo $row['detail']; ?> </textarea>
	</td>
</tr>
<tr>
	<td width="25%">ความกว้าง / Width (pixel)</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtwidth" value="<?php echo $row['banner_width'];?>"/></td>
</tr>
<tr>
	<td width="25%">ความสูง / Height (pixel)</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtheight" value="<?php echo $row['banner_height'];?>"/></td>
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
	<td><input type="submit" name="btadd" value="แก้ไข" /></td>
</tr>
</table>

</form>