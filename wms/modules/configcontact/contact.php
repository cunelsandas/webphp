<?php

	$modid=$_GET['_modid'];
	$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
	$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$sql="select * from $tablename where id=1";
	$rs=rsQuery($sql);
	if($rs){
		$data=mysqli_fetch_assoc($rs);
		$detail=$data['detail'];
	}

	if(isset($_POST['btsave'])){
		$detail=$_POST['mytextarea'];
		$strSql="update $tablename Set detail='$detail' where id=1";
		$rs=rsQuery($strSql);
		if($rs){
			echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}


?>
<form name="frm01" action="" method="post">
 <div class="content-box">
	<?php
		echo $modname;
		echo "<hr><br>";
	?>
	<table width="90%" class="content-input">
		<tr >
			<td >รายละเอียด</td>
			<td>
				<textarea name="mytextarea" id="mytextarea" style="width: 100%" ><?php echo $data['detail']; ?> </textarea>
			</td>
		</tr>
		<tr>
			<td></td><td><input type="submit" name="btsave" value="บันทึก"></td>
		</tr>
	</table>
	</div>
	</form>


<script src='../js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({

        selector: '#mytextarea',
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