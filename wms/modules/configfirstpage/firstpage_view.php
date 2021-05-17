<?php
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$file_no=1;   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloData_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
?>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css">
<style type="text/css">
.ui-datepicker{
	width:200px;
	font-family:tahoma;
	font-size:11px;
	text-align:center;
}
</style>
<script type="text/javascript" src="js/jscolor.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<center>
<?php
//ลบภาพ
if(isset($_GET['del'])){
		$filenameFordel=FindRS("select * from filename where id=".$_GET['del'],"filename");

		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		//if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);	
		//}
		$sql="DELETE From filename Where id=".$_GET['del'];

		$rs=rsQuery($sql);
		
		
}
if(isset($_GET['ptype'])){
	$ptype=$_GET['ptype'];
		switch($ptype){
			case main:
				$up="update tb_firstpage set picture_main=null Where no=".$_GET['no'];
				break;
			case bg:
				$up="update tb_firstpage set picture_bg=null where no=".$_GET['no'];
				break;
		}
		$r=rsQuery($up);
}

$file=array();
$size=array();
$type=array();
if(isset($_POST['btadd'])){
  // วนรับค่าจาก control
	$file[0]=$_FILES['file0']['name'];
		$size[0]=$_FILES['file0']['size'];
		$type[0]=strtolower(substr($file[0],-4));

		$file[1]=$_FILES['file1']['name'];
		$size[1]=$_FILES['file1']['size'];
		$type[1]=strtolower(substr($file[1],-4));
	//วนเช็ค file type
	for ($i=0;$i<=$file_no;$i++){
		$x=$i+1;
		$strCheckFile=CheckFileUpload($file[$i],$size[$i],$limitsize,$SizeInMb,$x);
		if($strCheckFile[0]=="no"){
			echo $strCheckFile[1];
			exit();
		}
	}
		

	if($_POST['active']=="on"){
		$ac="1";
		}else{
		$ac="0";
	}

	$sql="UPDATE $table SET subject='".$_POST['txtsubject']."',detail1='".$_POST['mytextarea']."',weblink='".$_POST['weblink']."',linkname='".$_POST['linkname']."',datepost='".$_POST['dateInput']."',ip='".$_SERVER['REMOTE_ADDR']."',status='$ac',bg_color='".$_POST['bg_color']."' Where no='".$_GET['no']."'";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Where no='".$_GET['no']."'";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_array($rss);
		$id=$r['no'];

		$newfile=array();
			$newfile[0]=$table.'_'.$id."_main".$type[0];
			$newfile[1]=$table.'_'.$id."_bg".$type[1];
				if(!empty($_FILES['file0']['name'])){
					copy($_FILES['file0']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[0]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[0]."')";
					$uppicname=rsQuery($filename);
					$updatemain="update tb_firstpage SET picture_main='".$newfile[0]."' Where no=".$id;
					$up=rsQuery($updatemain);
				}
				if(!empty($_FILES['file1']['name'])){
					copy($_FILES['file1']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[1]);
					$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[1]."')";
					$uppicname=rsQuery($filename);
					$updatemain="update tb_firstpage SET picture_bg='".$newfile[1]."' Where no=".$id;
					$up=rsQuery($updatemain);
				}
			// update table tb_trans บันทึกการแก้ไขข้อมูล
		$updatetran=UpdateTrans($table,'edit',$_SESSION['username'],'ID:'.$id);
	//	$updatemain="update tb_firstpage SET picture_main='".$newfile[0]."',picture_bg='".$newfile[1]."' Where no=".$id;
	//	$up=rsQuery($updatemain);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where no='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);

?>

<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
<tr >
	<td width="20%" >ชื่อเรื่อง</td>
	<td width="400"><input type="text" class="txt" name="txtsubject" value="<?php echo $row['subject'];?>" size="100"/></td>
</tr>
<tr >
	<td >วันที่</td>
	<td><input type="text" name="dateInput" id="dateInput" value="<?php echo $row['datepost'];?>" /></td>
</tr>

<tr >
	<td >รายละเอียด</td>
	<td>
        <textarea name="mytextarea" id="mytextarea" style="width: 100%"><?php echo $row['detail1'];?></textarea>

	</td>
</tr>
<tr >
	<td >Web Link</td>
	<td><input type="text" name="weblink"  value="<?php echo $row['weblink'];?>"></td>
</tr>
<tr >
	<td >ชื่อ Link</td>
	<td><input type="text" name="linkname"  value="<?php echo $row['linkname'];?>"></td>
</tr>
<tr >
	<td >สีพื้นหลัง (Background Color)</td>
	<td><input type="text" name="bg_color" class="color"  value="<?php echo $row['bg_color'];?>"></td>
</tr>
<!--<tr >
	<td >รายละเอียด2</td>
	<td><textarea name="detail2" class="txtarea"><?php echo $row['detail2'];?></textarea></td>
</tr>-->
<tr >
	<td valign="top" >ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td>
	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
	
			echo "ไฟล์ภาพ&nbsp;&nbsp;&nbsp;<input type=file name=file0 size=50 /><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&ptype=main&no=".$_GET['no']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br />";
			echo "ไฟล์พื้นหลัง(background)&nbsp;&nbsp;&nbsp;<input type=file name=file1 size=50 /><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&ptype=bg&no=".$_GET['no']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br />";
			

?>
</td>
	</tr>
<tr >
	<td>&nbsp;</td>
	<td >
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
<tr >
	<td>&nbsp;</td>
	<td ><input class="bt" type="submit" name="btadd" value="แก้ไข" /></td>
</tr>
</table>
<?php
$strpicture="Select * from filename Where tablename='".$table."' AND masterid='".$_GET['no']."' Order by id";
$rs=rsQuery($strpicture);
while($arr = mysqli_fetch_array($rs)){
	$fileno=substr($arr['filename'],-5,1);
	echo "<img src=..".$foldername.$arr['filename']." width=300 height=300>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
}
?>
</form>
</center>


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