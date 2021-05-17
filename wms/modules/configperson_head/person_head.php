<style>
	fieldset{
		padding:20px;
		border-radius:5px;
		margin-bottom:10px;
		background-color:#a2ab58;
	}
	legend{
		color:black;
		background-color:#eeeeee;
		padding:5px;
		border:1px solid #fdfdff;
	}
</style>
<div class="content-box">

<?php

empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
$foldername="/".$gloUploadPath."/".$folder."/";
$file_no=($gloHeader_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
$SizeInMb=round(($limitsize/$onemb));
$blockno="20";
$v_status="";
$v_edit="";
$v_delete="";
if($type=="view"){
	$btsave="Edit";
}else{
	$btsave="Addnew";
}
echo "<p >$modname</p><hr><br>";

	if(isset($_GET['status'])){
		$sql="UPDATE $tablename SET status='".$_GET['status']."' Where no='".$_GET['no']."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
	if(isset($_GET['del'])){
		//delete picture
		$filenameFordel=FindRS("select * from filename where tablename='$tablename' And masterid=".EscapeValue($_GET['del']),"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);	
		}
		$sql="DELETE From filename Where id='".EscapeValue($_GET['del'])."'";
		$rs=rsQuery($sql);
		
		$sql="DELETE From $tablename Where no='".$_GET['del']."'";
		$rs=rsQuery($sql);
		if($rs){
			// update table tb_trans บันทึกการเพิ่มข้อมูล
			$updatetran=UpdateTrans($tablename,'delete',$_SESSION['username'],'ID:'.$_GET['del']);
			echo "<script>alert('ไฟล์ : ".$filenameFordel." ถูกลบแล้ว');</script>";
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
		
		
	}
	//delete picture
	if(isset($_GET['delpic'])){
		$filenameFordel=FindRS("select * from filename where id=".EscapeValue($_GET['delpic']),"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);	
		}
		$sql="DELETE From filename Where id='".EscapeValue($_GET['delpic'])."'";
		$rs=rsQuery($sql);
	
	}
	// Add & UPDATE
	$file=array();
	$size=array();
	$type=array();
	if(isset($_POST['btsave'])){
		$btsavevalue=$_POST['btsave'];
		// วนรับค่าจาก control
		for ($i=0;$i<=$file_no;$i++){
			$file[$i]=$_FILES['file'.$i]['name'];
			$size[$i]=$_FILES['file'.$i]['size'];
			$type[$i]=strtolower(substr($file[$i],-4));
		}
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
		if($btsavevalue=="Edit"){
			$sql="UPDATE $tablename SET name='".EscapeValue($_POST['txtname'])."',position='".EscapeValue($_POST['type'])."',sid='".$_POST['sid']."',status='$ac',nolist='".EscapeValue($_POST['nolist'])."',history='".$_POST['mytextarea']."' Where no='".EscapeValue($_GET['no'])."'";
			$msg="แก้ไขข้อมูลสำเร็จ";
			$sqlPic="Select * From $tablename Where no='".EscapeValue($_GET['no'])."'";
		}
		if($btsavevalue=="Addnew"){
			$sql="INSERT INTO $tablename(name,position,status,sid,nolist,history) Values('".EscapeValue($_POST['txtname'])."','".EscapeValue($_POST['type'])."','$ac','".$_POST['sid']."','".EscapeValue($_POST['nolist'])."','".$_POST['mytextarea']."')";
			$msg="เพิ่มข้อมูลใหม่สำเร็จ";
			$sqlPic="Select * From $tablename Order by no DESC limit 0,1";
		}
	$rs=rsQuery($sql);
	if($rs){
		//$sql="Select * From $tablename Where no='".EscapeValue($_GET['no'])."'";
		$rss=rsQuery($sqlPic);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];

		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$tmp_date = new DateTime();
			$x = $tmp_date->format('Y-m-d_His') ;
			if($file[$i]<>""){
				$newfile[$i]=$tablename."_".$id."_".$x.$type[$i];
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
			}
		}

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($tablename,'edit',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('".$msg."');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}

	// view
	
		$strview="select * from $tablename where no=".$_GET['no'];
		$rsview=rsQuery($strview);
		$row=mysqli_fetch_assoc($rsview);
		
		
	
?>
<span style="right:12%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มรายการใหม่</a>";?></span><br>
<center>
<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = active : <img src="../images/component/01.png" /> = not active </p>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data" class='content-input'>
<table width="100%" >
<tr>
	<td width="25%">ชื่อ - สกุล</td>
	<td width="75%"><input type="text" size="70" size="60" name="txtname" value="<?php echo $row['name'];?>" /></td>
</tr>
<!--<tr>
	<td>ลำดับการแสดง</td>
	<td><input type="text" name="txtdetail" class="txt1" value="<?php echo $row['op']?>"></td>
</tr>-->
<tr>
<!--<td>ตำแหน่ง</td>-->
<!--		<td><input type="text"  size="60" name="type" id="type" value="--><?php //echo $row['position'];?><!--"  /></td>-->
    <td>ตำแหน่ง</td>
    <!--	<td><input type="text" name="txtposition" class="txt1" value="--><?php //echo $row['position']?><!--"></td>-->
    <td><textarea name="type" id="type" row="2" col="40"><?php echo $row['position']?></textarea></td>    <!-- test multiple line text -->
</tr>
<tr>
	<td>บล๊อกการแสดง</td>
		<td>นายก(1) รอง(2) เลขา/ที่ปรึกษา(3) ,ที่ปรึกษา(4)<br><select class="txt" name="sid"><option value="">- - - - กรุณาเลือกบล็อกการแสดง - - - -</option>
		<?php
		//$sql="Select * From tb_officer_show Order by showid";
		//$rs=rsQuery($sql);
		//while($row2=mysqli_fetch_assoc($rs)){
		for($a=1;$a<=$blockno;$a++){		
			if($row['sid']==$a){
				echo"<option value=\"".$a."\" selected>".$a."</option>";
			}else{
				echo"<option value=\"".$a."\">".$a."</option>";
			}
		}
		?>
		</select>
		</td>
</tr>
<tr>
	<td>ลำดับการแสดง</td>
		<td><input type="text"  size="60" name="nolist" value="<?php echo $row['nolist'];?>" />
		</td>
</tr>
<tr>
	<td>ประวัติการทำงาน</td>
	<td>
        <textarea name="mytextarea" id="mytextarea" style="width: 100%"><?php echo $row['history'];?></textarea>
	</td>
</tr>
<tr>
	<td valign="top"><?php echo ShowAllowedFileUpload($gloUploadFileType);?>ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td>	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
			
}
?></td>
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
	<td><input class="bt" type="submit" name="btsave" value="<?php echo $btsave;?>" /></td>
</tr>
</table>
<?php
$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$_GET['no']."' Order by id";
$rs=rsQuery($strpicture);
while($arr = mysqli_fetch_assoc($rs)){
	
	echo "<img src='..".$foldername.$arr['filename']."' style='max-width:300px;'>&nbsp;&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&delpic=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
}
?>
</form>
<?php
	$block_colno=array("0",
							"1",
							"3",
							"3",
							"3",
							"3",
							"3",
							"3",
							"3",
							"3",
							"3",
							"3",
							"3",
							"3",
							"3",
							"1",
							"3",
							"3",
							"3",
							"3",
							"3");
	
	//กำหนดตำแหน่งรูป left,center,right เริ่มจาก 0
	$align=array("center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center");
	for($x = 1; $x <= $blockno; $x++) {
			echo "<fieldset>";
			echo "<legend>บล็อกที่ $x</legend>";
			echo "<table border=\"0\"  align=\"center\" width=\"100%\">";
			echo	"<tr>";
			// พนักงานเจ้าหน้าที่  บล๊อกการแสดง $x
			$i=1;
			$sqlFind="Select * From $tablename Where sid='".$x."' order by nolist";
			$rs=rsQuery($sqlFind);
			if($rs){
				while($row2=mysqli_fetch_assoc($rs)){
					//$filepath=SearchImage($tablename,$row2['no'],$foldername,"0");
					if($row2['status']=="0"){
								$v_status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=1&no=".$row2['no']."\"><img src=\"../images/component/01.png\" border=\"0\" title='สถานะ inactive'/></a>";
							}else{
								$v_status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=0&no=".$row2['no']."\"><img src=\"../images/component/02.png\" border=\"0\" title='สถานะ active' /></a>";
							}
							$v_edit="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$row2['no']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" title='แก้ไขข้อมูล'/></a>";
							$v_delete="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$row2['no']."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\" title='ลบข้อมูล'/></a>";
					$filename=FindRS("select * from filename where tablename='".$tablename."' and masterid='".$row2['no']."'","filename");
					$filepath="..".$foldername.$filename;
					$listno=$row2['nolist'];
					if($row2['history']==null || $row2['history']=="" || empty($row2['history'])){
						$history="";
					}else{
						$history= "<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row2['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"../images/document_icon.png\"></a>";
					}

					if($row2['position']=="blank"){
						$position="";
					}else{
						$position=$row2['position'];
					}
					if($row2['name']=="blank"){
						$name="";
						$td="<span width='100%'>&nbsp;&nbsp;</span>";
					}
                    else{
						$name=$row2['name'];
						$td="<center><img src=".$filepath ."?".rand(1,32000)." class=\"photo_border\" width='150' ><div class='textbg'>".$name."<br/>".nl2br($position)."<br>$history<p style='color:white;'>บล็อกที่ ".$x." ลำดับที่ ".$listno."</p><p>$v_status &nbsp; $v_edit &nbsp; $v_delete</p></div></center><br/><br/>";
					}


							echo"<td valign=\"top\" align=\"".$align[$x]."\" width='33%'>";
						//	echo"<table height=\"100%\" border=\"0\">";
						//	echo"<tr>";
						//	echo "<td>";
							echo $td;
					//		echo"</td></tr>";
					//		echo"</table>";
							echo"</td>";
								if($i==$block_colno[$x]){
									echo"</tr><tr>";
									$i=0;
								}
							$i++;
						}
				}

			echo "</tr>";
			echo "</table>";
			echo "</fieldset>";
	}
	



?>
</center>

</div>


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

<script type="text/javascript">
   function open_new_window(URL)
   {
   NewWindow = window.open(URL,"_blank","toolbar=no,menubar=0,status=0,copyhistory=0,scrollbars=yes,resizable=1,location=0,Width=600,Height=600") ;
   NewWindow.location = URL;
   }
 </script>