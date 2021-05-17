<div class="content-box">


<!-- ################## ส่วนของการตั้งค่าข้อความ 1 และรูปโลโก้ ##################### !-->
<?php
$modid=$_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid",'modname');
$tablename=FindRS("select tablename from tb_mod where modid=$modid",'tablename');
echo "<p>$modname</p><hr><br>";
if(isset($_POST['btword1'])){

	$sql="UPDATE $tablename SET maintext='".$_POST['txtword']."'";
	$rs=rsQuery($sql);
	if($rs){
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');</script>";
	}
}
$sql="Select * From $tablename";
$rs=rsQuery($sql);
if(mysqli_num_rows($rs)==0){
	$sql="INSERT INTO $tablename(maintext) Values('')";
	$rs=rsQuery($sql);
}else{
	$sql="Select * From $tablename";
	$rs=rsQuery($sql);
	$row=mysqli_fetch_array($rs);
}
?>



<!-- ############################# ส่วนของการตั้งค่าข้อความวิ่ง ############################ !-->
<?php
if(isset($_POST['btaddmarquee'])){
	$sql="UPDATE tb_marquee SET txt1='".$_POST['mytextarea']."',txt2='".$_POST['txt2']."',txt3='".$_POST['txt3']."',marquee='".$_POST['chkmarquee']."'";
	$rs=rsQuery($sql);
	if($rs){
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');</script>";
	}
}
$sql="Select * From tb_marquee";
$rs=rsQuery($sql);
if(mysqli_num_rows($rs)==0){
	$sql="INSERT INTO tb_marquee(txt1) Value('')";
	$rs=rsQuery($sql);
}else{
	$rows=mysqli_fetch_assoc($rs);
}

?>

<form name="frmmarquee" method="POST" action="">
<table width="100%" class="content-input">
<tr >
	<td colspan="2">ข้อความวิ่ง</td>
</tr>
<tr>
	<td width="100">ข้อความ </td>
	<td width="75%">
        <textarea type="text" class="form-control" name="mytextarea" id="mytextarea" style="width: 100%"><?php echo $rows['txt1'];?></textarea>
        </td>
</tr>
<!--<tr>
	<td>ข้อความที่ 2 </td>
	<td><input class="txt"  type="text" name="txt2"  value="<?php echo $rows['txt2'];?>"/></td>
</tr>
<tr>
	<td>ข้อความที่ 3 </td>
	<td><input class="txt"  type="text" name="txt3"  value="<?php echo $rows['txt3'];?>"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
	<?php
	if($rows['marquee']=="on"){
		?>
		<input type="checkbox" name="chkmarquee" checked /> แสดงข้อความแบบสุ่ม</td>
	<?php
	}else{
		?>
		<input type="checkbox" name="chkmarquee" /> แสดงข้อความแบบสุ่ม</td>
	<?php
	}
	?>

</tr>
-->
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btaddmarquee" value="บันทึกข้อมูล"/></td>
</tr>
</table>
</form>

<!-- ###################### สิ้นสุด #################################### !-->

<!-- ############################# ส่วนของการตั้งค่าPOPUP ############################ !-->
<!--<?php
if(isset($_POST['btaddpopup'])){
	$sql="UPDATE tb_popup SET txt1='".$_POST['txtpopup']."',popup='".$_POST['popup']."'";
	$rs=rsQuery($sql);
	if($rs){
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');</script>";
	}
}
$sql="Select * From tb_popup";
$rs=rsQuery($sql);
if(mysqli_num_rows($rs)==0){
	$sql="INSERT INTO tb_popup(txt1) Values('')";
	$rs=rsQuery($sql);
}else{
	$rowarr=mysqli_fetch_assoc($rs);
}
?>

<form name="frmpopup" method="POST" action="">
<table width="100%" cellpadding="2" cellspacing="2" style="border:1px solid;">
<tr bgcolor="#FFCCE0">
	<td colspan="2">Pop up window</td>
</tr>
<tr>
	<td width="75%">ข้อความ</td>
	<td width="420"><input type="text" class="txt" name="txtpopup" value="<?php echo $rowarr['txt1'];?>"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>
	<?php
	if($rowarr['popup']=="on"){
		?>
		<input type="checkbox" name="popup" checked/>&nbsp;แสดงหน้าต่าง</td>
	<?php
	}else{
		?>
		<input type="checkbox" name="popup"/>&nbsp;แสดงหน้าต่าง</td>
	<?php
	}
	?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btaddpopup" value="บันทึก Popup"/></td>
</tr>
</table>
</form>
-->
<!-- ###################### สิ้นสุด #################################### !-->


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

            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',


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