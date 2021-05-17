<?php
		$img_new="<img src=images/new.gif>";
?>
<!--<embed src="fileupload/mp3/march.mp3" autostart="true" loop="false" hidden="true" type="audio/mpeg>  -->	

<div id="activity_nayok">
	<center>
	
	 <?php	
					$mod="activity_nayok";
					$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
					$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
					$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
					$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
					$foldername=$gloUploadPath."/".$folder."/";
					if(file_exists("images/".$bannername) and $bannername<>""){
						echo "<script>ChangeCssBg('activity_nayok','".$bannername."');</script>";
					}else{
						echo "<p class='banner_title'>$modname</p>";
					}
					$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					echo "<table width='90%'><tr><td >";
					echo "<div id=\"mainwrapper\">";
					if($rs){
					while($row_news=mysqli_fetch_assoc($rs)){
						$numrow=$numrow+1;
						$showimage=SearchImage($tablename,$row_news['no'],$foldername,"0");
						$subject=$row_news['subject'];
						$detail=$row_news['detail1'];
						echo "<div id=\"box-3\" class=\"box\">";
						echo "<a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img id=\"image-3\" src='$showimage' width='200' height='200'>";
						echo "<span class=\"caption scale-caption\">";
						echo "<h3>".$subject."</h3>";
						echo "<p>".$detail."</p>";
						echo "</span>";
						echo "</div>";				
					}
					echo "</div>";
					echo "</td></tr>";
					echo "<tr><td colspan=\"1\" align=\"right\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
					}
					
?>
			
	</table>
	</center>
</div>

<br>
<br>
<div id="news">
	 <?php
					$mod="news";
					$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
					$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
					$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
					$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
					$foldername=$gloUploadPath."/".$folder."/";
					if(file_exists("images/".$bannername) and $bannername<>""){
						echo "<script>ChangeCssBg('news','".$bannername."');</script>";
					}else{
						echo "<p class='banner_title'>$modname</p>";
					}
					
					
					//$foldername="fileupload/news/";
					$sql2="Select * From $tablename Where status=1 Order by datepost DESC limit 0,1";			
					$rs2=rsQuery($sql2);
					if($rs2){
						echo "<table width='90%'>";
						while($row_news=mysqli_fetch_assoc($rs2)){
						$showimage=SearchImage($tablename,$row_news['no'],$foldername,"0");
						
						$data_id=$row_news['no'];
						$data_subject=$row_news['subject'];
						$data_detail=$row_news['detail1'];
						echo "<tr><td><img src='$showimage' class='default'></td><td style='padding-top:10px;padding-left:10px;'><div id=subject><a href='index.php?_mod=".encode64($mod)."&no=".encode64($data_id)."'>-:-&nbsp;".$data_subject."&nbsp;-:-</a></div><div id=detail>".$data_detail."</div></td></tr>";
						}
				
						echo "<tr><td colspan=\"2\" align=\"right\" valign=\"bottom\" height=\"10\"><a href=\"index.php?_mod=".encode64($mod)."\" class='readmore'></a></td></tr>";
						echo "</table>";
					}
					
?>	
	
</div>
<br>

<div id="activity">
 <BR><BR><BR>
	<center>
	
	 <?php
					$mod="activity";
					$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
					$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
					$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
					$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
					$foldername=$gloUploadPath."/".$folder."/";
					if(file_exists("images/".$bannername) and $bannername<>""){
						echo "<script>ChangeCssBg('activity','".$bannername."');</script>";
					}else{
						echo "<p class='banner_title'>$modname</p>";
					}
					$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 1,6";
					$rs=rsQuery($sql);
					if($rs){
						echo '<script src="js/jquery.tinycarousel.js"></script>';
						echo "<table width='90%'><tr>";
						$numrow=0;
						$rnd=x;
						if($device=="Mobile"){
							$width="500";
							$height="400";
							$polaroid_height="500";
							$img_per_row=1;
						}else{
							$width="240";
							$height="200";
							$polaroid_height="240";
							$img_per_row=3;
						}
						while($row_news=mysqli_fetch_assoc($rs)){
							
							$numrow+=1;
							$a+=1;
							
							$sqlimg="select * from filename where tablename='$tablename' and masterid=".$row_news['no']." Limit 0,3";
							$rsImg=rsQuery($sqlimg);
							$subject=$row_news['subject'];
							$detail=$row_news['detail1'];
							$slider="slider".$row_news['no'];
							$slider_style=ImageSlide($slider,$width,$height,$rnd,0);
							
							echo "<td valign='top' align='center' style='padding-bottom:10px;'>";
							
							echo $slider_style;
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
					}
					
?>
	</table>
	</center>
</div>


<br>
<!-- จัดซื้อจัดจ้าง -->
    <div id="purchase">
					<?php
						$mod="purchase";
						$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
						$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
						$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
						$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
						$foldername=$gloUploadPath."/".$folder."/";
					if(file_exists("images/".$bannername) and $bannername<>""){
						echo "<script>ChangeCssBg('purchase','".$bannername."');</script>";
					}else{
						echo "<p class='banner_title'>$modname</p>";
					}
					?>
					<center>
					<table width="90%">				
					<?php 
						$sql="Select * From $tablename where status='1' Order by datepost DESC limit 0,6";
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
							?>	
				</table>
				</center>
            </div>	
			<br><br>
	<div id="travel">
	 <?php
					$mod="travel";
					$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
					$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
					$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
					$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
					$foldername=$gloUploadPath."/".$folder."/";
					if(file_exists("images/".$bannername) and $bannername<>""){
						echo "<script>ChangeCssBg('travel','".$bannername."');</script>";
					}else{
						echo "<p class='banner_title'>$modname</p>";
					}
					
					
					$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					if($rs){
						echo "<table width=90% border=0>";
						echo "<tr>";
					while($row_news=mysqli_fetch_assoc($rs)){

						$showimage=SearchImage($tablename,$row_news['no'],$foldername,"0");
						echo "<td valign=top><a href=index.php?_mod=".encode64($mod)."&no=".encode64($row_news['no'])." ><img src='$showimage'  class='default'><div id=subject>".$row_news['subject']."</a></div></td>";
					}
					echo "</tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($mod)."\" class=\"readmore\"></a></td></tr>";
					echo "</table>";
					}
					
				
?>	
</div>

<br><br>


<div id="youtube" align="center">
			<?php
				$mod="youtube";
					$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
					$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
					$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
					$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
					$foldername=$gloUploadPath."/".$folder."/";
					if(file_exists("images/".$bannername) and $bannername<>""){
						echo "<script>ChangeCssBg('youtube','".$bannername."');</script>";
					}else{
						echo "<p class='banner_title'>$modname</p>";
					}
					echo "<br>";
				$sql="select * from $tablename where active='1' Order by id DESC Limit 0,2";
				$rs=rsQuery($sql);
				if($rs){
					echo "<table><tr>";
					while($data=mysqli_fetch_assoc($rs)){
						$video_id=$data['video_id'];
						
						echo "<td><iframe width=\"$glo_youtube_width\" height=\"$glo_youtube_height\" src=\"https://www.youtube.com/embed/$video_id\" frameborder=\"0\" allowfullscreen></iframe><td>";
					}
					echo "</tr></table>";
				}
			?>
	</div>
<br>
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
<div id="otop">
	 <?php
					$mod="otop";
					$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
					$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
					$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
					$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
					$foldername=$gloUploadPath."/".$folder."/";
					if(file_exists("images/".$bannername) and $bannername<>""){
						echo "<script>ChangeCssBg('otop','".$bannername."');</script>";
					}else{
						echo "<p class='banner_title'>$modname</p>";
					}
				
					echo "<table width='90%'>";
					echo "<tr>";
					$sql="Select * From $tablename Where status=1 Order by datepost DESC limit 0,3";
					
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
				
?>	
</div>

