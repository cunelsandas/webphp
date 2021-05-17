<style>
	fieldset{
		padding:20px;
		border-radius:5px;
		margin-bottom:10px;
		
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
$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	
echo "<p >$modname</p><hr><br>";

if($type=="addnew"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
	include"person_officer_add.php";
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"person_officer_view.php";
}else{
	$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");

$blockno="20";
	$v_status="";
	$v_edit="";
	$v_delete="";
	if(isset($_GET['status'])){
		$sql="UPDATE $tablename SET status='".EscapeValue($_GET['status'])."' Where no='".EscapeValue($_GET['no'])."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
	if(isset($_GET['del'])){
		$sql="DELETE From $tablename Where no='".EscapeValue($_GET['del'])."'";
		$rs=rsQuery($sql);
		if($rs){	
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans($tablename,'delete',$_SESSION['username'],'ID:'.EscapeValue($_GET['del']));

			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
?>

<div >

	<center>
		<span style="right:12%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มรายการใหม่</a>";?></span><br>
	</center>
		<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = active : <img src="../images/component/01.png" /> = not active </p>
	<form name='frmshow' action='' method='post' class='content-input'>
	<select name='cboFindDep' onchange='this.form.submit()'>
		<option value='0'>เลือกโครงสร้างหน่วยงาน</option>
		<?php
			$sql="Select * From tb_officertype where status>'0' Order by listno";
			$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			echo"<option value=\"".$row['id']."\">".$row['name']."</option>";
		}
		?>
	</select>


<?php
	
	

//	if(isset($_POST['cboFindDep'])){
		
		$depid=$_POST['cboFindDep'];
	if($depid>0){
		$depname=FindRS("select * from tb_officertype where id='".$depid."'","name");
		echo "<center><p style='padding:5px;background-color:white;margin-top:10px;margin-bottom:10px;'>".$depname."</p></center>";
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
							"3",
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
				$sqlFind="Select * From $tablename Where offid='".$depid."' And sid='".$x."' order by nolist";
				$rs=rsQuery($sqlFind);
				
				if($rs){
						while($row2=mysqli_fetch_assoc($rs)){
							if($row2['status']=="0"){
								$v_status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=1&no=".$row2['no']."\"><img src=\"../images/component/01.png\" border=\"0\" title='สถานะ inactive'/></a>";
							}else{
								$v_status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=0&no=".$row2['no']."\"><img src=\"../images/component/02.png\" border=\"0\" title='สถานะ active' /></a>";
							}
							$v_edit="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$row2['no']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" title='แก้ไขข้อมูล'/></a>";
							$v_delete="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$row2['no']."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\" title='ลบข้อมูล'/></a>";
			
							//$filepath=SearchImage($tablename,$row2['no'],$foldername,"0");
							$filename=FindRS("select * from filename where tablename='".$tablename."' and masterid='".$row2['no']."'","filename");
							$filepath="..".$foldername.$filename;
							$listno=$row2['nolist'];
							if($row2['history']==null || $row2['history']=="" || empty($row2['history'])){
									$history="";

							}else{
									$history= "<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row2['no'])."&tb=".encode64('tb_officer')."&p=".encode64('officer')."');\"><img src=\"../images/document_icon.png\"></a>";
							}

							if($row2['position']=="blank"){
								$position="";
							}else{
								$position=$row2['position'];
							}
							if($row2['name']=="blank"){
								$name="";
								$td="<span width='100%'>&nbsp;&nbsp;</span>";
							}else{
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
	}
	

?>
</form>
<?php }?>
</div>
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