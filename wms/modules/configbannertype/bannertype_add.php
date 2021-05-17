<?php
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table="tb_banner_position";
	$foldername="/fileupload/banner/";

?>


<!--        จบการเพิ่มไฟล์เอกสาร             --->

<?php

if(isset($_POST['btadd'])){
	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}//institute=ลำดับการแสดง

	$sql="INSERT INTO $table(name,status,detail,banner_width,banner_height) Values('".EscapeValue($_POST['txtname'])."','$ac','".$_POST['mytextarea']."','".$_POST['txtwidth']."','".$_POST['txtheight']."')";
	$rs=rsQuery($sql);
	if($rs){
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$table','add',$_SESSION['username'],'ID:'.$id.'  '.$_POST['txtname']);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
	//echo $sql;
}
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table class="content-input" >
<tr>
	<td width="25%">ชื่อ Banner</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" /></td>
</tr>

<tr>
	<td>รายละเอียด</td>
	<td>
        <textarea name="mytextarea" id="mytextarea" > </textarea>
	</td>
</tr>
<tr>
	<td width="25%">ความกว้าง / Width (pixel)</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtwidth" /></td>
</tr>
<tr>
	<td width="25%">ความสูง / Height (pixel)</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtheight" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="checkbox" name="active" />&nbsp;Active</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
</form>
