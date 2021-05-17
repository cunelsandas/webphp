<div class='tree'>
  <?php
  $mod=EscapeValue(decode64($_GET['_mod']));
	$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
	$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
	$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
	$foldername=$gloUploadPath."/".$folder."/";
	if(isset($_GET['type'])){
		$type=decode64($_GET['type']);
		$strWg="select * from $tablename where offid=$type and workgroupid=0";
				$rsWg=rsQuery($strWg);
				if($rsWg){
					$numrow=mysqli_num_rows($rsWg);
						if($numrow>0){
							$dataWg=mysqli_fetch_assoc($rsWg);
							$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$dataWg['no']."' Order by id";
							$rs2=rsQuery($strpicture);
							$arr = mysqli_fetch_assoc($rs2);
							$fileno=substr($arr['filename'],-5,1);
							$filepath=SearchImage($tablename,$_GET['no'],$foldername,"0");
							$no=$dataWg['no'];
							$name=$dataWg['name'];
							$position=$dataWg['position'];
							$workgroup=$dataWg['workgroup'];
								if($data['status']=="0"){
									$status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&status=1&no=".$no."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
								}else{
									$status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&status=0&no=".$no."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
								}
						echo "<ul>";  //หัวหน้าส่วน
							echo "<li>";
							echo "<div class='picbox'>".$workgroup."<br>";
							echo "<img src='$filepath' width='80'>";
							echo "<br>$name<br>$position<br>";
				//			echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$no."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&del=".$no."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a><br>$status";
							echo "</div>";

								$sqlworkgroup="select * from tb_officer_workgroup where offid=$type order by listno";
								$rsw=rsQuery($sqlworkgroup);
								$rswrow=mysqli_num_rows($rsw);
								if($rsw){
									if($rswrow>0){
										echo "<ul>";
											while($dWorkGroup=mysqli_fetch_assoc($rsw)){
												$workgroup_id=$dWorkGroup['id'];
												$workgroup_name=$dWorkGroup['name'];
												echo "<li>$workgroup_name";   //หัวหน้าฝ่าย
												$sqlWK="select * from $tablename where offid=$type and workgroupid=$workgroup_id and subworkgroupid=0";
												$rs=rsQuery($sqlWK);
												if($rs){
													$dataWg=mysqli_fetch_assoc($rs);
													$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$dataWg['no']."' Order by id";
													$rs2=rsQuery($strpicture);
													$arr = mysqli_fetch_assoc($rs2);
													$fileno=substr($arr['filename'],-5,1);
													$filepath=SearchImage($tablename,$_GET['no'],$foldername,"0");
													$no=$dataWg['no'];
													$name=$dataWg['name'];
													$position=$dataWg['position'];
													$workgroup=$dataWg['workgroup'];
														if($data['status']=="0"){
															$status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&status=1&no=".$no."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
														}else{
															$status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&status=0&no=".$no."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
														}
													echo "<div class='picbox'>".$workgroup."<br>";
													echo "<img src='$filepath' width='80'>";
													echo "<br>$name<br>$position<br>";
							//						echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$no."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&del=".$no."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a><br>$status";
													echo "</div>";

												}

													$sqlSub="select * from tb_officer_subworkgroup where workgroupid=$workgroup_id order by listno";
													$rsSub=rsQuery($sqlSub);

														echo "<ul>";
														while($dSub=mysqli_fetch_assoc($rsSub)){
															$subworkgroup_id=$dSub['id'];
															$subworkgroup_name=$dSub['name'];
																echo "<li>$subworkgroup_name";  //<a href="#">หัวหน้างาน</a>
																	$sqlOff="select * from $tablename where offid=$type and workgroupid=$workgroup_id and subworkgroupid=$subworkgroup_id order by nolist";
																	$rsOff=rsQuery($sqlOff);
																	$row=mysqli_num_rows($rsOff);
																			echo "<ul>";
																			echo "<li>"; //<a href="#">พนักงาน</a></li>
																			$i=0;
																			while($dOff=mysqli_fetch_assoc($rsOff)){
																				$i+=1;
																				$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$dataWg['no']."' Order by id";
																				$rs2=rsQuery($strpicture);
																				$arr = mysqli_fetch_assoc($rs2);
																				$fileno=substr($arr['filename'],-5,1);
																				$filepath=SearchImage($tablename,$_GET['no'],$foldername,"0");
																				$no=$dOff['no'];
																				$name=$dOff['name'];
																				$position=$dOff['position'];
																				$workgroup=$dOff['workgroup'];
																				$listno=$dOff['nolist'];

																				echo "<div class='picbox'>".$workgroup.$listno."<br>";
																				echo "<img src='$filepath' width='80'>";
																				echo "<br>$name<br>$position<br>";
													//							echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$no."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=$type&del=".$no."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a><br>$status";
																				echo "</div>";
																				if($i<$row){
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

}  //end if บนสุด

?>
</div>

