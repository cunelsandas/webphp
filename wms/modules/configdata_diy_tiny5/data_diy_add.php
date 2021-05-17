<?php
//	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
//	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
//	$foldername="/".$gloUploadPath."/".$folder."/";
//	$tabletype="tb_menugroup";
//	$file_no=($gloActivity_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
//	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
//	$SizeInMb=round(($limitsize/$onemb));
//
//	$mod= $_GET['_mod'];
//	$no=$_GET['no'];
//?>
<!---->
<!---->
<!--<center>-->
<?php
//
//	if($_POST['btadd']){
//
//
//	if($_POST['active']=="on"){
//		$ac="1";
//	}else{
//		$ac="0";
//	}
//	$subject=EscapeValue($_POST['txtsubject']);
//	$detail=$_POST['detail1'];
//	$type=$_POST['cbotype'];
//	$listno=empty($_POST['txtlistno'])?"0":$_POST['txtlistno'];
//	$sql="UPDATE $table SET subject='$subject',detail='$detail',groupid='$type',status='$ac',listno='$listno' Where no='".$_GET['no']."'";
//	$rs=rsQuery($sql);
//	if($rs){
//		$sql="Select * From $table Where no='".$_GET['no']."'";
//		$rss=rsQuery($sql);
//		$r=mysqli_fetch_assoc($rss);
//		$id=$r['no'];
//			// update table tb_trans บันทึกการแก้ไขข้อมูล
//		$updatetran=UpdateTrans($table,'edit',$_SESSION['username'],'ID:'.$id);
//		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
//	}
//}
//$sql="Select * From $table Where no='".$_GET['no']."'";
//$rs=rsQuery($sql);
//$row=mysqli_fetch_assoc($rs);
//$subject=$row['subject'];
//$detail=$row['detail'];
//$type=$row['type'];
//$listno=$row['listno'];
//$typename=FindRS("select * from $tabletype where id='$type'","name");
//$status=$row['status'];
//?>
<!--<form name="frmnews" method="POST" action="" enctype="multipart/form-data">-->
<!--<table width="100%" cellpadding="2" cellspacing="2" border="0" class="content-input">-->
<!---->
<!--<tr >-->
<!--<td width="15%">กลุ่มเมนู (Menu Group)</td>-->
<!--		<td><select name="cbotype"><option value="">- - - - กรุณาเลือก - - - -</option>-->
<!--		--><?php
//		$sql="Select * From $tabletype Order by id";
//		$rs=rsQuery($sql);
//		while($row1=mysqli_fetch_assoc($rs)){
//			if($row1['id']==$type){
//				echo"<option value=\"".$row1['id']."\" selected>".$row1['name']."</option>";
//			}else{
//				echo"<option value=\"".$row1['id']."\">".$row1['name']."</option>";
//			}
//		}
//		?>
<!--		</select>-->
<!--		</td>-->
<!--	</tr>-->
<!--	<tr>-->
<!--	<td>ชื่อเมนูย่อย / ชื่อเรื่อง</td>-->
<!--	<td><input type="text" name="txtsubject" size="100" value="--><?php //echo $subject;?><!--"></td>-->
<!--</tr>-->
<!--<tr >-->
<!--	<td >รายละเอียด</td>-->
<!--	<td><textarea name="detail1" id="mytextarea">--><?php //echo $detail; ?><!--</textarea>-->
<!--	</td>-->
<!--</tr>-->
<!--<tr>-->
<!--	<td>ลำดับการแสดง</td>-->
<!--	<td><input type="text" name="txtlistno" value="--><?php //echo $listno;?><!--"></td>-->
<!--</tr>-->
<!--<tr >-->
<!--	<td>&nbsp;</td>-->
<!--	<td>-->
<!--	--><?php //
//	if($status=="0"){
//		echo "<input type=\"checkbox\" name=\"active\" />&nbsp;Active";
//	}else{
//		echo "<input type=\"checkbox\" name=\"active\" checked />&nbsp;Active";
//	}
//	?>
<!--	</td>-->
<!--</tr>-->
<!--<tr >-->
<!--	<td>&nbsp;</td>-->
<!--	<td ><input type="submit" name="btadd" value="แก้ไข" />-->
<!--	<!-- Load Facebook SDK for JavaScript -->-->
<!--						<span id="fb-root"></span>-->
<!--							<script>-->
<!--								(function(d, s, id) {-->
<!--									var js, fjs = d.getElementsByTagName(s)[0];-->
<!--									if (d.getElementById(id)) return;-->
<!--										  js = d.createElement(s); js.id = id;-->
<!--										  js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.6";-->
<!--										  fjs.parentNode.insertBefore(js, fjs);-->
<!--								}(document, 'script', 'facebook-jssdk'));-->
<!--						</script>-->
<!--						<span class="fb-share-button" -->
<!--							data-href="http://--><?php //echo $domainname;?><!--/index.php?_mod=--><?php //echo encode64($mod);?><!--&no=--><?php //echo encode64($no);?><!--"  -->
<!--							data-layout="button" -->
<!--							data-size="small" -->
<!--							data-mobile-iframe="true">-->
<!--							<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">แชร์</a>-->
<!--						</span>-->
<!--	-->
<!--	</td>-->
<!--</tr>-->
<!--</table>-->
<!---->
<!--</form>-->
<!--</center>-->
<!---->
<!--<script src='../js/tinymce/tinymce.min.js'></script>-->
<!--<script>-->
<!--    tinymce.init({-->
<!---->
<!--        selector: '#mytextarea',-->
<!--        theme: 'modern',-->
<!--        width: "100%",-->
<!--        height: 300,-->
<!--        plugins: [-->
<!--            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',-->
<!--            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',-->
<!--            'save table contextmenu directionality emoticons template paste textcolor'-->
<!--        ],-->
<!--		// toolbar with image picker-->
<!--        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',-->
<!--		// toolbar with out image picker-->
<!--		// toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview  fullpage | forecolor backcolor emoticons',-->
<!---->
<!--        image_title: true,-->
<!--        // enable automatic uploads of images represented by blob or data URIs-->
<!--        automatic_uploads: true,-->
<!--        // add custom filepicker only to Image dialog-->
<!--        file_picker_types: 'image',-->
<!--        file_picker_callback: function(cb, value, meta) {-->
<!--            var input = document.createElement('input');-->
<!--            input.setAttribute('type', 'file');-->
<!--            input.setAttribute('accept', 'image/*');-->
<!---->
<!--            input.onchange = function() {-->
<!--                var file = this.files[0];-->
<!--                var reader = new FileReader();-->
<!---->
<!--                reader.onload = function () {-->
<!--                    var id = 'blobid' + (new Date()).getTime();-->
<!--                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;-->
<!--                    var base64 = reader.result.split(',')[1];-->
<!--                    var blobInfo = blobCache.create(id, file, base64);-->
<!--                    blobCache.add(blobInfo);-->
<!---->
<!--                    // call the callback and populate the Title field with the file name-->
<!--                    cb(blobInfo.blobUri(), { title: file.name });-->
<!--                };-->
<!--                reader.readAsDataURL(file);-->
<!--            };-->
<!---->
<!--            input.click();-->
<!--        }-->
<!---->
<!--    });-->
<!--</script>-->

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
            <td><textarea name="detail1" id="myTextarea"></textarea></td>
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
<script
        type="text/javascript"
        src='https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js'
        referrerpolicy="origin">
</script>
<script type="text/javascript">
    tinymce.init({
        selector: '#myTextarea',
        images_upload_url: '../js/tinymce/postAcceptorDiy.php',
        images_upload_credentials: true,
        image_title: true,
        automatic_uploads: true,
        width: "100%",
        height: 400,
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