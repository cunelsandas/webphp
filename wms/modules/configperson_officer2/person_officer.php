<div class="content-box">
<?php

empty($_GET['type'])?$type="":$type=$_GET['type'];
$departmentname=FindRS("select * from tb_officertype where id=$type","name");
$modid=$_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
$folder=FindRS("select * from tb_mod where modid='$modid'","foldername");
	$foldername="../".$gloUploadPath."/".$folder."/";
echo "<p >$modname</p><hr><br>";

if($type=="addnew"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
	include"person_officer_add.php";
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"person_officer_view.php";
}else{
	if(isset($_GET['status'])){
		$sql="UPDATE $tablename SET status='".EscapeValue($_GET['status'])."' Where no='".EscapeValue($_GET['no'])."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type';</script>";
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
	$total_no=FindRS("Select count(no) as sumno from $tablename where offid=$type","sumno");
	if($total_no==0){
		$chart_height="300px";
	}else{
	$chart_height=($total_no*250)."px";
	}
?>

<div class="content-input">
<select name="type" onchange="window.location.href='main.php?_mod=configofficer&_modid=<?php echo $_GET['_modid'];?>&type='+this.options[this.selectedIndex].value;"><option value="">- - - -ค้นหาจากประเภท - - - -</option>
		<option value="">ทั้งหมด</option>
		<?php
		$sql="Select * From tb_officertype Order by id";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
				echo"<option value=\"".$row['id']."\">".$row['name']."</option>";
		}

		?>
		</select>&nbsp;&nbsp;&nbsp;<span ><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มรายการใหม่</a>";?></span>
		</div>
		<br>


<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = active : <img src="../images/component/01.png" /> = not active </p>
<div class="hold" >
<div class="tree">
<script src="../js/jquery-scrolltofixed-min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>

<?php

		$strWg="select * from $tablename where offid=$type and workgroupid=0 order by nolist";

				$rsWg=rsQuery($strWg);
				if($rsWg){
					$numrow1=mysqli_num_rows($rsWg);
						if($numrow1>0){
							echo "<ul>";  //หัวหน้าส่วน
							echo "<li>";
							$x=0;
							while($dataHead=mysqli_fetch_assoc($rsWg)){
								$x+=1;
								$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$dataWg['no']."' Order by id";
								$rs2=rsQuery($strpicture);
								$arr = mysqli_fetch_assoc($rs2);
								$fileno=substr($arr['filename'],-5,1);
								$filepath=SearchImage($tablename,$dataHead['no'],$foldername,"0");
								$no=$dataHead['no'];
								$name=$dataHead['name'];
								$position=$dataHead['position'];
								$workgroup=$dataHead['workgroup'];
								$listno=$dataHead['nolist'];
									if($data['status']=="0"){
										$status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&status=1&no=".$no."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
									}else{
										$status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&status=0&no=".$no."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
									}
								echo "<div class='picbox'>".$workgroup."<br>$listno<br>";
								echo "<img src='$filepath' width='80'>";
								echo "<br>$name<br>".nl2br($position)."<br>";
								echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$no."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&del=".$no."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a><br>$status";
								echo "</div>";
								if($x<$numrow1){
										echo "<span class='line'></span>";
									}
							}
								$sqlworkgroup="select * from tb_officer_workgroup where offid=$type and listno>0 order by listno";
								$rsw=rsQuery($sqlworkgroup);

								if($rsw){
									$numrow2=mysqli_num_rows($rsw);
									if($numrow2>0){

										echo "<ul>";
											while($dWorkGroup=mysqli_fetch_assoc($rsw)){
												$workgroup_id=$dWorkGroup['id'];
												$workgroup_name=$dWorkGroup['name'];
												echo "<li><span class='org_title line'>$workgroup_name</span>";   //หัวหน้าฝ่าย
												$sqlWK="select * from $tablename where offid=$type and workgroupid=$workgroup_id and subworkgroupid=0 Order by nolist";
												$rs=rsQuery($sqlWK);
												$numrow3=mysqli_num_rows($rs);
												if($numrow3>0){
													$y=0;
													while($dataWg=mysqli_fetch_assoc($rs)){
														$y+=1;
														$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$dataWg['no']."' Order by id";
														$rs2=rsQuery($strpicture);
														$arr = mysqli_fetch_assoc($rs2);
														$fileno=substr($arr['filename'],-5,1);
														$filepath=SearchImage($tablename,$dataWg['no'],$foldername,"0");
														$no=$dataWg['no'];
														$name=$dataWg['name'];
														$position=$dataWg['position'];
														$workgroup=$dataWg['workgroup'];
														$listno=$dataWg['nolist'];
															if($data['status']=="0"){
																$status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&status=1&no=".$no."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
															}else{
																$status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&status=0&no=".$no."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
															}
															echo "<div class='picbox'>".$workgroup."<br>$listno<br>";
														echo "<img src='$filepath' width='80'>";
														echo "<br>$name<br>$position<br>";
														echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$no."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&del=".$no."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a><br>$status";
														echo "</div>";
														if($y<$numrow3){
															echo "<span class='line'></span>";
														}
													}
												}

													$sqlSub="select * from tb_officer_subworkgroup where workgroupid=$workgroup_id order by listno";
													$rsSub=rsQuery($sqlSub);

														echo "<ul>";
														while($dSub=mysqli_fetch_assoc($rsSub)){
															$subworkgroup_id=$dSub['id'];
															$subworkgroup_name=$dSub['name'];
															$chart_width+=200;
																echo "<li>$subworkgroup_name";  //<a href="#">หัวหน้างาน</a>
																	$sqlOff="select * from $tablename where offid=$type and workgroupid=$workgroup_id and subworkgroupid=$subworkgroup_id order by nolist";
																	$rsOff=rsQuery($sqlOff);
																	$numrow4=mysqli_num_rows($rsOff);
																			echo "<ul>";
																			echo "<li>"; //<a href="#">พนักงาน</a></li>
																			$z=0;
																			while($dOff=mysqli_fetch_assoc($rsOff)){
																				$z+=1;
																				$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$dataWg['no']."' Order by id";
																				$rs2=rsQuery($strpicture);
																				$arr = mysqli_fetch_assoc($rs2);
																				$fileno=substr($arr['filename'],-5,1);
																				$filepath=SearchImage($tablename,$dOff['no'],$foldername,"0");
																				$no=$dOff['no'];
																				$name=$dOff['name'];
																				$position=$dOff['position'];
																				$workgroup=$dOff['workgroup'];
																				$listno=$dOff['nolist'];

																				echo "<div class='picbox'>".$workgroup.$listno."<br>";
																				echo "<img src='$filepath' width='80'>";
																				echo "<br>$name<br>$position<br>";
																				echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$no."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&del=".$no."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a><br>$status";
																				echo "</div>";
																				if($z<$numrow4){
																					echo "<span class='line'></span>";
																				}

																			}
																			echo "</li>";
																		echo "</ul>";
															echo "</li>";
														}
											echo"</ul>";
									echo"</li>";
											}
							echo"</ul>";
									}
								}
			echo "</li>";
		echo "</ul>";
						}
				}
echo "</div>";
echo "</div>";
}  //end if บนสุด
	if($chart_width<=1000){
		$chart_width="1000"."px";
	}

?>
</div>

<SCRIPT language="javascript" type="text/javascript">
	$(document).ready(function(){
//custom


		$(".content-box").css("width", "<?php echo $chart_width;?>");
		$(".content-box").css("height", "<?php echo $chart_height;?>");

//font

});
</SCRIPT>

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

