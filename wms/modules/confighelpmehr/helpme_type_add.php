<?php
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table="tb_hr_type";
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername=$gloUploadPath.$folder."/";

if(isset($_POST['btadd'])){
	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}//institute=ลำดับการแสดง

	$sql="INSERT INTO $table(name) Values('".EscapeValue($_POST['txtname'])."')";
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
	<td width="25%">ประเภทคำร้อง</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" /></td>
</tr>


	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
</form>
