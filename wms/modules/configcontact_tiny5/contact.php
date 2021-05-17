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
<script
        type="text/javascript"
        src='https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js'
        referrerpolicy="origin">
</script>
<script type="text/javascript">
    tinymce.init({
        selector: '#mytextarea',
        images_upload_url: '../js/tinymce/postAcceptorContact.php',
        images_upload_credentials: true,
        image_title: true,
        automatic_uploads: true,
        width: "100%",
        height: 500,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'table emoticons template paste help'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link image | print preview media fullpage | ' +
            'forecolor backcolor emoticons | help',
        menu: {
            favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
        },
        menubar: 'favs file edit view insert format tools table help',
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            /*
              Note: In modern browsers input[type="file"] is functional without
              even adding it to the DOM, but that might not be the case in some older
              or quirky browsers like IE, so you might want to add it to the DOM
              just in case, and visually hide it. And do not forget do remove it
              once you do not need it anymore.
            */

            input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    /*
                      Note: Now we need to register the blob in TinyMCEs image blob
                      registry. In the next release this part hopefully won't be
                      necessary, as we are looking to handle it internally.
                    */
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });

</script>