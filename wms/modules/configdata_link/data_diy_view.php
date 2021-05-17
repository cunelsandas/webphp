<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$tabletype="tb_menugroup";
	$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
?>

 <script src='../js/tinymce/tinymce.min.js'></script>
<script>
  tinymce.init({
	
    selector: '#mytextarea',
	theme: 'modern',
    width: 600,
    height: 300,
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'save table contextmenu directionality emoticons template paste textcolor'
    ],
    
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',

	images_upload_url: '../js/tinymce/tiny_upload_image.php',
 
  images_upload_credentials: true
  });
  </script>
<center>
<?php

	if($_POST['btadd']){


	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
	$subject=EscapeValue($_POST['txtsubject']);
	$detail=$_POST['detail1'];
	$type=$_POST['cbotype'];
	$listno=empty($_POST['txtlistno'])?"0":$_POST['txtlistno'];
	$sql="UPDATE $table SET subject='$subject',detail='$detail',groupid='$type',status='$ac',listno='$listno' Where no='".$_GET['no']."'";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Where no='".$_GET['no']."'";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];
			// update table tb_trans บันทึกการแก้ไขข้อมูล
		$updatetran=UpdateTrans($table,'edit',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where no='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
$subject=$row['subject'];
$detail=$row['detail'];
$type=$row['type'];
$listno=$row['listno'];
$typename=FindRS("select * from $tabletype where id='$type'","name");
$status=$row['status'];
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="content-input">

<tr >
<td width="15%">กลุ่มเมนู (Menu Group)</td>
		<td><select name="cbotype"><option value="">- - - - กรุณาเลือก - - - -</option>
		<?php
		$sql="Select * From $tabletype Order by id";
		$rs=rsQuery($sql);
		while($row1=mysqli_fetch_assoc($rs)){
			if($row1['id']==$type){
				echo"<option value=\"".$row1['id']."\" selected>".$row1['name']."</option>";
			}else{
				echo"<option value=\"".$row1['id']."\">".$row1['name']."</option>";
			}
		}
		?>
		</select>
		</td>
	</tr>
	<tr>
	<td>ชื่อเมนูย่อย / ชื่อเรื่อง</td>
	<td><input type="text" name="txtsubject" size="100" value="<?php echo $subject;?>"></td>
</tr>
<tr >
	<td >Url</td>
    <td><input type="text" name="detail1"><?php echo $detail; ?></td>

    </td>
</tr>
<tr>
	<td>ลำดับการแสดง</td>
	<td><input type="text" name="txtlistno" value="<?php echo $listno;?>"></td>
</tr>
<tr >
	<td>&nbsp;</td>
	<td>
	<?php 
	if($status=="0"){
		echo "<input type=\"checkbox\" name=\"active\" />&nbsp;Active";
	}else{
		echo "<input type=\"checkbox\" name=\"active\" checked />&nbsp;Active";
	}
	?>
	</td>
</tr>
<tr >
	<td>&nbsp;</td>
	<td ><input type="submit" name="btadd" value="แก้ไข" /></td>
</tr>
</table>

</form>
</center>

