<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$tabletype="tb_menugroup";
	$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$content="";


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
	$sql="INSERT INTO $table(subject,detail,groupid,status,listno) Values('$subject','$detail','$type','$ac','$listno')";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Order by no DESC limit 0,1";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($table,'add',$_SESSION['username'],'ID:'.$id);

		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}

}
?>

<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">

<tr>
	<td width="15%">กลุ่มเมนู (Menu Group)</td>
	<td ><select class="txt" name="cbotype"><option value="">- - - - กรุณาเลือก - - - -</option>
		<?php
		$sql="Select * From $tabletype Order by id";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
		//	if($ruser['id']==$row['id']){
		//		echo"<option value=\"".$row['id']."\" selected>".$row['name']."</option>";
		//	}else{
				echo"<option value=\"".$row['id']."\">".$row['name']."</option>";
		//	}
		}
		?>
		</select>
		</td>
</tr>
<tr>
	<td>ชื่อเมนูย่อย / ชื่อเรื่อง</td>
	<td><input type="text" name="txtsubject" size="100"></td>
</tr>
<tr>
	<td >รายละเอียด</td>
	<td><textarea name="detail1" id="mytextarea"></textarea></td>
</tr>

<tr>
	<td>ลำดับการแสดง</td>
	<td><input type="text" name="txtlistno"></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td ><input type="checkbox" name="active" />&nbsp;Active</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td ><input class="bt" type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
</form>
<script src='../js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({

        selector: '#mytextarea',
        theme: 'modern',
        width: "100%",
        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
        ],
		// toolbar with image picker
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
		// toolbar with out image picker
		// toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview  fullpage | forecolor backcolor emoticons',

        image_title: true,
        // enable automatic uploads of images represented by blob or data URIs
        automatic_uploads: true,
        // add custom filepicker only to Image dialog
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    // call the callback and populate the Title field with the file name
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        }

    });
</script>