<?php
		$img_new="<img src=images/new.gif>";
					
				
				// banner
				$banner_position_name="header";
				$banner_position_id=FindRS("select * from tb_banner_position where name='$banner_position_name'","id");
				$banner_position_width=FindRS("select * from tb_banner_position where name='$banner_position_name'","banner_width");
				$banner_position_height=FindRS("select * from tb_banner_position where name='$banner_position_name'","banner_height");
				$sql="select * from tb_banner where position='$banner_position_id' and status='1' order by listno";
				$rs=rsQuery($sql);
				if(mysqli_num_rows($rs)>0){
					while($data=mysqli_fetch_assoc($rs)){
						$link_to=$data['link_to'];
						$alt=$data['alt'];
						$name=substr($data['name'],0,1);
						if($name=="#"){
							$target="";
						}else{
							$target="target='_blank'";
						}
						$filepath=SearchImage('tb_banner',$data['id'],"fileupload/banner/","0");
						echo "<a href='$link_to' title='$alt' $target>";
						echo "<img src=\"$filepath\" alt=\"$alt\">";
						echo "</a>";
						echo "<br>";
						echo "<br>";
					}
				}
	

					$strSQL="select * from tb_defaultpage Where status>0 Order by listno";
					$rsDef=rsQuery($strSQL);
					if(mysqli_num_rows($rsDef)>0){
						While($dp=mysqli_fetch_assoc($rsDef)){
								$dp_modid=$dp['modid'];
								$dp_pagestyle=$dp['pagestyle'];
								$dp_itemcount=$dp['itemcount'];
								
								$mod=FindRS("select * from tb_mod Where modid='$dp_modid'","modtype");
								
								$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
								$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
								$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
								$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
								$foldername=$gloUploadPath."/".$folder."/";
								
								if($device=="Mobile"){
										
											
											
											switch($mod){
												case "purchase":
													echo "<p class='banner_title'>$modname</p>";
														echo "<div id='$dp_pagestyle'>";
															$sql="Select * From $tablename where status=1 Order by datepost DESC limit 0,15";
									  					rsQuery("SET NAMES utf8");
														 $rs=rsQuery($sql);
														 if($rs){
															 echo "<div class='textbox'>";
															 $row_count=0;
															while($row = mysqli_fetch_assoc($rs)){
																$row_count +=1;
																$datediff=DateDiff($row['datepost'],date("Y-m-d"));
																	if($datediff<=10){
																		$img=$img_new;
																	}else{
																		$img="";
																	}
								
																echo "<div class='textbox_text' style='position:relative;'><span class='row_count'>$row_count</span><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row['no'])."><b>".$row['subject']."</b>&nbsp;</a>".$img."</div>";
															}
																echo "<a href=\"index.php?_mod=".encode64($mod)."&g=".encode64('1')."\" class=\"readmore\"></a>";
																echo "</div>";
														 }
															echo "</div>";
													break;
												case "youtube":
														echo "<p class='banner_title'>$modname</p>";
														echo "<div id='$dp_pagestyle'>";
														echo "<br>";
														$sql="select * from $tablename where active='1' Order by id DESC Limit 0,$dp_itemcount";
														$rs=rsQuery($sql);
														if($rs){
															echo "<table><tr>";
																while($data=mysqli_fetch_assoc($rs)){
																	$video_id=$data['video_id'];
																	echo "<td><iframe width=\"$glo_youtube_width\" height=\"$glo_youtube_height\" src=\"https://www.youtube.com/embed/$video_id\" frameborder=\"0\" allowfullscreen></iframe>";
																	if($device=="Mobile"){
																		echo "</td><tr>";
																	}
																echo "</td>";
																}
																echo "</tr></table>";
														}
														echo "</div>";

													break;

												case "slideshow":


													break;

												default:
													echo "<p class='banner_title'>$modname</p>";
										echo "<div id='$dp_pagestyle' align='center'>";
											echo "<table width='98%'>";
											echo "<tr><td width='100%' align='center'>";
											
											$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,$dp_itemcount";
											$rs=rsQuery($sql);
											if($rs!==false){
												$count_row=0;
												while($row_news=mysqli_fetch_assoc($rs)){
													$count_row +=1;
													$showimage=SearchImage($tablename,$row_news['no'],$foldername,"0");
													echo "<div class='polaroid'>";
													echo "<a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img src='$showimage'>";
													echo "<div class='polaroid_text'>".$row_news['subject']."</a></div>";
													echo "</div>";
													//echo "<td valign='top' width='47%'><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img src='$showimage' class='default'><div id=subject>".$row_news['subject']."</a></div></td>";
													//if($count_row==2){
													//	echo "</tr><tr>";
													//	$count_row=0;
													//}
												}
											
												echo "</td></tr>";
												echo "<tr><td colspan=\"1\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
											}
											echo "</table>";
										echo "</div>";								
										echo "<br>";

											break;
											} //end switch
	// desktop								
								}else{  
									switch($dp_pagestyle){
									case "html":
										echo "<p class='banner_title'>$modname</p>";
										echo "<div id='html-default'>";
										$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,$dp_itemcount";
											$rs=rsQuery($sql);
											if(mysqli_num_rows($rs)>0){
												echo "<table width='90%'>";
													while($data=mysqli_fetch_assoc($rs)){
														echo "<tr><td width='100%'>";
														//echo $data['subject'];
														//echo "<br>";
														echo $data['detail'];
														echo "</td></tr>";
													}
												echo "</table>";
											}
											echo "</div>";
										break;
									
									case "item_for_sale":


										break;

									case "image_only":
										echo "<p class='banner_title'>$modname</p>";
										echo "<div id='$dp_pagestyle'>";
											if(file_exists("images/".$bannername) and $bannername<>""){
												echo "<img src='images/$bannername'>";
											}else{
												echo "<p class='banner_title'>$modname</p>";
											}
									
											$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,$dp_itemcount";
											$rs=rsQuery($sql);
											echo "<table width='90%' ><tr><td >";
											echo "<div id=\"mainwrapper\">";
											if(mysqli_num_rows($rs)>0){
												
												while($row_news=mysqli_fetch_assoc($rs)){
													
													$showimage=SearchImage($tablename,$row_news['no'],$foldername,"0");
													$subject=$row_news['subject'];
													if($device=="Mobile"){
														$detail=iconv_substr($row_news['detail1'],0,200,"UTF-8")."...";
													}else{
														$detail=$row_news['detail1'];
													}
													echo "<div id=\"box-3\" class=\"box\">";
														echo "<a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img id=\"image-3\" src='$showimage' width='200' height='200'>";
														echo "<span class=\"caption scale-caption\">";
														echo "<h3>".$subject."</h3>";
														echo "<p>".$detail."</p>";
														echo "</span>";
													echo "</div>";				
													}
												}
												echo "</div>";
											echo "</td></tr>";
											echo "<tr><td colspan=\"1\" align=\"right\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
											echo "</table>";
											echo "</div>";
	
										break;

									case "image_with_slide":
										
										echo "<div id='$dp_pagestyle'>";
											if(file_exists("images/".$bannername) and $bannername<>""){
												echo "<img src='images/$bannername'>";
											}else{
												echo "<p class='banner_title'>$modname</p>";
											}
											$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,$dp_itemcount";
											$rs=rsQuery($sql);
											if($rs){
											
												echo "<table width='90%'><tr>";
												$numrow=0;
												$rnd=x;
												if($device=="Mobile"){
													$width="330";
													$height="300";
													$polaroid_height="500";
													$img_per_row=1;
													$dp_itemcount=1;
												}else{
													$width="240";
													$height="200";
													$polaroid_height="240";
													$img_per_row=3;
													$dp_itemcount=$dp_itemcount;
												}
												while($row_news=mysqli_fetch_assoc($rs)){
													$numrow+=1;
													$a+=1;
													$sqlimg="select * from filename where tablename='$tablename' and masterid=".$row_news['no']." Limit 0,$dp_itemcount";
													$rsImg=rsQuery($sqlimg);
													$subject=$row_news['subject'];
													$detail=$row_news['detail1'];
													$slider="slider".$row_news['no'];
													$slider_style=ImageSlide($slider,$width,$height,$rnd,0);
													echo "<td valign='top' align='center' style='padding-bottom:10px;'>";
													if($device<>"Mobile"){
													echo $slider_style;
													}
													echo '<div id="'.$slider.'" class="polaroid" style="width:'.$width.'px;height:'.($polariod_height).'px;">
																<div class="viewport">
																	<ul class="overview">';
																	while($dataIMG=mysqli_fetch_assoc($rsImg)){
																		$imgname=$foldername.$dataIMG['filename'];
																		echo "<li><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img src='$imgname' style='width:100%;height:100%;'></a></li>";
																		}
														echo '</ul></div><div class="container">'.$subject.'</div></div>';	
																if($a%2==0){
																		$rnd=x;
																}else{
																		$rnd=y;
																}		
														echo "</td>";
								
															if($numrow==$img_per_row){
																$numrow=0;
																echo "</tr><tr>";
															}
												}
											echo "</tr>";
											echo "<tr><td colspan=\"3\" align=\"right\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
											echo "</table>";
											}
											echo "</div>";
										break;

									case "image_and_subject":
										
										echo "<div id='$dp_pagestyle'>";
											if(file_exists("images/".$bannername) and $bannername<>""){
												echo "<img src='images/$bannername'>";
											}else{
												echo "<p class='banner_title'>$modname</p>";
											}
				
											echo "<table width='90%'>";
											echo "<tr>";
											$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,$dp_itemcount";
											$rs=rsQuery($sql);
											if($rs!==false){
												while($row_news=mysqli_fetch_assoc($rs)){
													$showimage=SearchImage($tablename,$row_news['no'],$foldername,"0");
													echo "<td valign=top><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img src='$showimage' class='default'><div id=subject>".$row_news['subject']."</a></div></td>";
												}
												echo "</tr>";
												echo "<tr><td colspan=\"3\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
											}
											echo "</table>";
										echo "</div>";
										break;

									case "image_and_subject_with_slide":
										
											echo "<div id='$dp_pagestyle'>";
											if(file_exists("images/".$bannername) and $bannername<>""){
												echo "<img src='images/$bannername'>";
											}else{
												echo "<p class='banner_title'>$modname</p>";
											}
											$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,$dp_itemcount";
											$rs=rsQuery($sql);
											if($rs){
											
												echo "<table width='90%'><tr>";
												$numrow=0;
												$rnd=x;
													if($device=="Mobile"){
													$width="330";
													$height="300";
													$polaroid_height="500";
													$img_per_row=1;
													$dp_itemcount=1;
												}else{
													$width="240";
													$height="200";
													$polaroid_height="240";
													$img_per_row=3;
													$dp_itemcount=$dp_itemcount;
												}
												while($row_news=mysqli_fetch_assoc($rs)){
													$numrow+=1;
													$a+=1;
													$sqlimg="select * from filename where tablename='$tablename' and masterid=".$row_news['no']." Limit 0,$dp_itemcount";
													$rsImg=rsQuery($sqlimg);
													$subject=$row_news['subject'];
													$detail=$row_news['detail1'];
													$slider="slider".$row_news['no'];
													$slider_style=ImageSlide($slider,$width,$height,$rnd,0);
													echo "<td valign='top' align='center' style='padding-bottom:10px;'>";
													if($device<>"Mobile"){
													echo $slider_style;
													}
													echo '<div id="'.$slider.'" class="polaroid" style="width:'.$width.'px;height:'.($polariod_height).'px;">
																<div class="viewport">
																	<ul class="overview">';
																	while($dataIMG=mysqli_fetch_assoc($rsImg)){
																		$imgname=$foldername.$dataIMG['filename'];
																		echo "<li><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img src='$imgname' style='width:100%;height:100%;'></a></li>";
																		}
														echo '</ul></div><div class="container">'.$subject.'</div></div>';	
																if($a%2==0){
																		$rnd=x;
																}else{
																		$rnd=y;
																}		
														echo "</td>";
								
															if($numrow==$img_per_row){
																$numrow=0;
																echo "</tr><tr>";
															}
												}
											echo "</tr>";
											echo "<tr><td colspan=\"3\" align=\"right\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
											echo "</table>";
											}
											echo "</div>";
										break;

									case "image_and_detail":
										
										echo "<div id='$dp_pagestyle'>";
											if(file_exists("images/".$bannername) and $bannername<>""){
												echo "<img src='images/$bannername'>";
											}else{
												echo "<p class='banner_title'>$modname</p>";
											}
					
										$sql2="Select * From $tablename Where status=1 Order by datepost DESC limit 0,$dp_itemcount";			
										$rs2=rsQuery($sql2);
										if($rs2){
											echo "<table width='90%'>";
												while($row_news=mysqli_fetch_assoc($rs2)){
													$showimage=SearchImage($tablename,$row_news['no'],$foldername,"0");
													$data_id=$row_news['no'];
													$data_subject=$row_news['subject'];
													$data_detail=$row_news['detail1'];
													if($device=="Mobile"){
														echo "<tr><td ><img src='$showimage' class='default'><div id=subject><a href='index.php?_mod=".encode64($mod)."&no=".encode64($data_id)."'>-:-&nbsp;".$data_subject."&nbsp;-:-</a></div><div id=detail>".iconv_substr($data_detail,0,150,"UTF-8")."...</div></td></tr>";
													}else{
														echo "<tr><td width='30%'><img src='$showimage' class='default'></td><td width='70%' style='padding-left:10px;'><div id=subject><a href='index.php?_mod=".encode64($mod)."&no=".encode64($data_id)."'>-:-&nbsp;".$data_subject."&nbsp;-:-</a></div><div id=detail>".$data_detail."</div></td></tr>";
													}
												}
											echo "<tr><td colspan=\"2\" align=\"right\" valign=\"bottom\" height=\"10\"><a href=\"index.php?_mod=".encode64($mod)."\" class='readmore'></a></td></tr>";
											echo "</table>";
										}
										echo "</div>";
	
										break;

									case "image_and_detail_with_slide":
										
											echo "<div id='$dp_pagestyle'>";
											if(file_exists("images/".$bannername) and $bannername<>""){
												echo "<img src='images/$bannername'>";
											}else{
												echo "<p class='banner_title'>$modname</p>";
											}
											$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,$dp_itemcount";
											$rs=rsQuery($sql);
											if($rs){
											
												echo "<table width='90%'><tr>";
												$numrow=0;
												$rnd=x;
													if($device=="Mobile"){
													$width="330";
													$height="300";
													$polaroid_height="500";
													$img_per_row=1;
													$dp_itemcount=1;
												}else{
													$width="240";
													$height="200";
													$polaroid_height="240";
													$img_per_row=3;
													$dp_itemcount=$dp_itemcount;
												}
												while($row_news=mysqli_fetch_assoc($rs)){
													$numrow+=1;
													$a+=1;
													$sqlimg="select * from filename where tablename='$tablename' and masterid=".$row_news['no']." Limit 0,$dp_itemcount";
													$rsImg=rsQuery($sqlimg);
													$subject=$row_news['subject'];
													$slider="slider".$row_news['no'];													
													if($device=="Mobile"){
														$detail=iconv_substr($row_news['detail1'],0,100,"UTF-8")."...";
														$slider_style="";
													}else{
														$detail=$row_news['detail1'];
														$slider_style=ImageSlide($slider,$width,$height,$rnd,0);
													}
														echo "<td valign='top' align='center' style='padding-bottom:10px;'>";
													echo $slider_style;
													echo '<div id="'.$slider.'" class="polaroid" style="width:'.$width.'px;height:'.($polariod_height).'px;">
																<div class="viewport">
																	<ul class="overview">';
																	while($dataIMG=mysqli_fetch_assoc($rsImg)){
																		$imgname=$foldername.$dataIMG['filename'];
																		echo "<li><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img src='$imgname' style='width:100%;height:100%;'>$subject<br>$detail</a></li>";
																		}
														echo '</ul></div><div class="container">'.$subject.'</div></div>';	
																if($a%2==0){
																		$rnd=x;
																}else{
																		$rnd=y;
																}		
														echo "</td>";
								
															if($numrow==$img_per_row){
																$numrow=0;
																echo "</tr><tr>";
															}
												}
											echo "</tr>";
											echo "<tr><td colspan=\"3\" align=\"right\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
											echo "</table>";
											}
											echo "</div>";

										break;

									case "subject_only":
										
										echo "<div id='$dp_pagestyle'>";
											if(file_exists("images/".$bannername) and $bannername<>""){
												echo "<img src='images/$bannername'>";
											}else{
												echo "<p class='banner_title'>$modname</p>";
											}
										echo '<center><table width="90%">';				
									 
										$sql="Select * From $tablename where status='1' Order by datepost DESC limit 0,$dp_itemcount";
					  					rsQuery("SET NAMES utf8");
										 $rs=rsQuery($sql);
										 if($rs){
											while($row = mysqli_fetch_assoc($rs)){
												$datediff=DateDiff($row['datepost'],date("Y-m-d"));
												if($datediff<=10){
														$img=$img_new;
												}else{
														$img="";
												}
											echo "<tr><td><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row['no'])."><b>".$row['subject']."</b>&nbsp;</a>".$img."</td></tr>";
											}
											echo "<tr><td colspan=\"1\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
										}
										echo "</table>";
										echo "</div>";
										break;
								
									case "youtube":
										
										echo "<div id='$dp_pagestyle'>";
										if(file_exists("images/".$bannername) and $bannername<>""){
											echo "<img src='images/$bannername'>";
										}else{
											echo "<p class='banner_title'>$modname</p>";
										}
										echo "<br>";
										$sql="select * from $tablename where active='1' Order by id DESC Limit 0,$dp_itemcount";
										$rs=rsQuery($sql);
											if($rs){
												echo "<table><tr>";
													while($data=mysqli_fetch_assoc($rs)){
													$video_id=$data['video_id'];
													echo "<td><iframe width=\"$glo_youtube_width\" height=\"$glo_youtube_height\" src=\"https://www.youtube.com/embed/$video_id\" frameborder=\"0\" allowfullscreen></iframe>";
													if($device=="Mobile"){
														echo "</td><tr>";
													}
													echo "</td>";
													}
												echo "</tr></table>";
											}
											echo "</div>";
										break;
									
									case "purchase_with_tab":
										
										echo "<div id='$dp_pagestyle'>";
										if(file_exists("images/".$bannername) and $bannername<>""){
											echo "<img src='images/$bannername'>";
										}else{
											echo "<p class='banner_title'>$modname</p>";
										}
										echo "<br>";
										echo '<div id="tab">
												   <ul class="tabs" data-persist="true">
												   <li><a href="#purchase_1" style="background-color:#ffff00;">ประกาศสอบราคาจัดซื้อจัดจ้าง</a></li>
												   <li><a href="#purchase_3" style="background-color:#cc6600;">ข้อมูลราคากลาง</a></li>
													<li><a href="#purchase_2" style="background-color:#60a5f0;">ผลการจัดซื้อจัดจ้าง</a></li>
													
												   </ul>
													<div class="tabcontents"><center>';
													$sqlG="select * from tb_purchase_group";
													$rsG=rsQuery($sqlG);
													if($rsG){
														while($dataG=mysqli_fetch_assoc($rsG)){
															$groupid=$dataG['id'];
															$groupname=$dataG['name'];
																echo "<div id='purchase_".$groupid."'>"; 
																	echo "<table width='80%' >";
																		echo "<tr><th>$groupname</th></tr>";
																			$sql="Select * From $tablename where status=1 and groupid=$groupid Order by datepost DESC limit 0,9";
														  					rsQuery("SET NAMES utf8");
																			 $rs=rsQuery($sql);
																			 if($rs){
																				while($row = mysqli_fetch_assoc($rs)){
																					$datediff=DateDiff($row['datepost'],date("Y-m-d"));
																						if($datediff<=10){
																								$img=$img_new;
																							}else{
																								$img="";
																						}
																						echo "<tr><td><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row['no'])."><b>".$row['subject']."</b>&nbsp;</a>".$img."</td></tr>";
																				}
																				echo "<tr><td colspan=\"1\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($mod)."&g=".encode64('1')."\" class=\"readmore\"></a></td></tr>";
																			 }
																	echo "</table></div>";
																}
													}
											echo "</div></div>";
											break;

										case "purchase_by_group":
											
											echo "<div id='$dp_pagestyle'>";
										if(file_exists("images/".$bannername) and $bannername<>""){
											echo "<img src='images/$bannername'>";
										}else{
											echo "<p class='banner_title'>$modname</p>";
										}
										echo "<br>";
												echo "<center>";
												$sqlG="select * from tb_purchase_group";
											$rsG=rsQuery($sqlG);
											if($rsG){
												while($dataG=mysqli_fetch_assoc($rsG)){
													$groupid=$dataG['id'];
													$groupname=$dataG['name'];
													echo "<table width='90%' class='opacity-table'>";
													echo "<tr><th>$groupname</th></tr>";
													$sql="Select * From $tablename where status=1 and groupid=$groupid Order by datepost DESC limit 0,6";
									  					rsQuery("SET NAMES utf8");
														 $rs=rsQuery($sql);
														 if($rs){
															while($row = mysqli_fetch_assoc($rs)){
																$datediff=DateDiff($row['datepost'],date("Y-m-d"));
																	if($datediff<=10){
																		$img=$img_new;
																	}else{
																		$img="";
																	}
								
																echo "<tr><td><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row['no'])."><b>".$row['subject']."</b>&nbsp;</a>".$img."</td></tr>";
															}
																echo "<tr><td colspan=\"1\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($mod)."&g=".encode64('1')."\" class=\"readmore\"></a></td></tr>";
														 }
														echo "</table>";
													}
												}
										echo "</center>";
										break;
										
										case "purchase_by_date":
											
											echo "<div id='$dp_pagestyle' class='default-class'>";
										if(file_exists("images/".$bannername) and $bannername<>""){
											echo "<img src='images/$bannername'>";
										}else{
											echo "<p class='banner_title'>$modname</p>";
										}
										
												
													echo "<table width='90%' class='opacity-table'>";
													
													$sql="Select * From $tablename where status=1 Order by datepost DESC limit 0,20";
									  					rsQuery("SET NAMES utf8");
														 $rs=rsQuery($sql);
														 if($rs){
															while($row = mysqli_fetch_assoc($rs)){
																$datediff=DateDiff($row['datepost'],date("Y-m-d"));
																	if($datediff<=10){
																		$img=$img_new;
																	}else{
																		$img="";
																	}
								
																echo "<tr><td><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row['no'])."><b>".$row['subject']."</b>&nbsp;</a>".$img."</td></tr>";
															}
																echo "<tr><td colspan=\"1\" align=\"right\" valign=\"top\"><a href=\"index.php?_mod=".encode64($mod)."&g=".encode64('1')."\" class=\"readmore\"></a></td></tr>";
														 }
														echo "</table>";
												echo "</div>";
										
										break;

										case "slideshow":
											echo '<center>
											<div id="slideshow">
											<!-- slide show-->
											<div class="slider-wrapper theme-default">
												<div class="ribbon"></div>
												<div id="slider" class="nivoSlider">';
													$picfoldername="fileupload/slideshow/";
													$slidesql="select * from tb_slideshow Order by id DESC Limit 0,$gloSlideshow_fileno";
													$rsslide=rsQuery($slidesql);
														if($rsslide){
															while($slideshow=mysqli_fetch_assoc($rsslide)){
																echo "<img src=\"".$picfoldername.$slideshow['filename']."\" width='".$gloSlide_width."' height='".$gloSlide_height."' title='".$slideshow['detail']."'>";
																}
														}

											echo '</div>
														</div>
														<script type="text/javascript" src="nivo-slider/jquery-1.7.1.min.js"></script>
														 <script type="text/javascript" src="nivo-slider/jquery.nivo.slider.pack.js"></script>';
														 ?>
													    <script type="text/javascript">
													      jQuery(function() {
														        $('#slider').nivoSlider();
																    });
													    </script>
													<!-- end slideshow -->
														</div>
													</center>
													<?php
															break;
								}  //end switch
								echo '<script src="js/jquery.tinycarousel.js"></script>';  // for slide
								echo '<script src="js/tabcontent.js" type="text/javascript"></script>'; // tab
								
								} // end if mobile
						}
					}
						
?>
<img src="images/mn_chiangmainews.png">

	<?php
		if($device<>"Mobile"){
			$col_height="500";
			$col_width="700";
			$font_size="25";
			}else{
			$col_height="1000";
			$col_width="100%";
			$font_size="40";
			}
			$news_row="15";

	?>
	<div id="chiangmainews">
	<iframe  height="<?php echo $col_height;?>"  width="<?php echo $col_width;?>" src="http://feed.mikle.com/widget/?rssmikle_url=http%3A%2F%2Fwww.chiangmainews.co.th%2Fpage%2F%3Ffeed%3Drss2&rssmikle_frame_width=<?php echo $col_width;?>&rssmikle_frame_height=<?php echo $col_height;?>&frame_height_by_article=0&rssmikle_target=_blank&rssmikle_font=Arial%2C%20Helvetica%2C%20sans-serif&rssmikle_font_size=<?php echo $font_size;?>&rssmikle_border=off&responsive=off&rssmikle_css_url=https%3A%2F%2Fdl.dropboxusercontent.com%2Fu%2F172851763%2Fcss%2Ffw008.css%3F0.16332269235495667&text_align=left&text_align2=left&corner=off&scrollbar=on&autoscroll=on&scrolldirection=up&scrollstep=3&mcspeed=20&sort=New&rssmikle_title=off&rssmikle_title_bgcolor=%230066FF&rssmikle_title_color=%23FFFFFF&rssmikle_item_bgcolor=%23FFFFFF&rssmikle_item_title_length=55&rssmikle_item_title_color=%230066FF&rssmikle_item_border_bottom=on&rssmikle_item_description=on&item_link=off&rssmikle_item_description_length=150&rssmikle_item_description_color=%23666666&rssmikle_item_date=gl1&rssmikle_timezone=Etc%2FGMT&datetime_format=%25e.%25m.%25Y%20%25l%3A%25M%20%25p&item_description_style=text%2Btn&item_thumbnail=full&item_thumbnail_selection=auto&article_num=<?php echo $news_row;?>&rssmikle_item_podcast=off&" scrolling="no" name="rssmikle_frame" marginwidth="0" marginheight="0" vspace="0" hspace="0" frameborder="0"></iframe>
	
</div>
<br><br>

<?php
// banner
				$banner_position_name="content_bottom";
				$banner_position_id=FindRS("select * from tb_banner_position where name='$banner_position_name'","id");
				$banner_position_width=FindRS("select * from tb_banner_position where name='$banner_position_name'","banner_width");
				$banner_position_height=FindRS("select * from tb_banner_position where name='$banner_position_name'","banner_height");
				$sql="select * from tb_banner where position='$banner_position_id' and status='1' order by listno";
				$rs=rsQuery($sql);
				if(mysqli_num_rows($rs)>0){
					while($data=mysqli_fetch_assoc($rs)){
						$link_to=$data['link_to'];
						$alt=$data['alt'];
						$name=substr($data['name'],0,1);
						if($name=="#"){
							$target="";
						}else{
							$target="target='_blank'";
						}
						$filepath=SearchImage('tb_banner',$data['id'],"fileupload/banner/","0");
						echo "<a href='$link_to' title='$alt' $target>";
						echo "<img src=\"$filepath\" alt=\"$alt\">";
						echo "</a>&nbsp;&nbsp;&nbsp;";
						
					}
				}
				?>
				<br><br>