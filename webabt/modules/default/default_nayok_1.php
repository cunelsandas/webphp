<?php
		$img_new="<img src=images/new.gif>";
?>
<html>
<head>
<!-- เพลง -->
<!--<embed src="fileupload/mp3/march.mp3" autostart="true" loop="false" hidden="true">  -->
</head>

<body>
<br>
<div id="default-activity-nayok">
	<center>
	
	 <?php
					$tb_name="tb_activity_nayok";
					$div_name="activity_nayok";
					$foldername="fileupload/activity_nayok/";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					echo "<table><tr><td>";
					echo "<div id=\"mainwrapper\">";
					while($row_news=mysqli_fetch_array($rs)){
						$numrow=$numrow+1;
				//	if ($row_news){
				//		$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
				//		$rs2=rsQuery($strSql);
				//		$rs_filename=mysqli_fetch_array($rs2);
				//	}
					$showimage=SearchImage($tb_name,$row_news['no'],$foldername,"0");
					$subject=$row_news['subject'];
					$detail=$row_news['detail1'];
					echo "<div id=\"box-6\" class=\"box\">";
					echo "<a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." ><img id=\"image-6\" src='$showimage'>";
					echo "<span class=\"caption scale-caption\">";
					echo "<h3>".$subject."</h3>";
					echo "<p>".$detail."</p>";
					echo "</span>";
					echo "</div>";
				
				
					}
					echo "</div>";
					echo "</td></tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($div_name)."\" class=\"readmore\"></a></td></tr>";
?>
			
	</table>
	</center>
</div>
<br>
<br>
	<div id="slideshow">
	<!-- slide show-->
	 <div class="slider-wrapper theme-default">
            <div class="ribbon"></div>
            <div id="slider" class="nivoSlider">
				<?php
					$picfoldername="fileupload/slideshow/";
					$slidesql="select * from tb_slideshow Order by id DESC Limit 0,$gloSlideshow_fileno";
					$rsslide=rsQuery($slidesql);
					if($rsslide){
						while($slideshow=mysqli_fetch_array($rsslide)){
							echo "<img src=\"".$picfoldername.$slideshow['filename']."\" width='".$gloSlide_width."' height='".$gloSlide_height."' title='".$slideshow['detail']."'>";
						}
					}
				
				?>
            </div>
			</div>
	<script type="text/javascript" src="nivo-slider/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="nivo-slider/jquery.nivo.slider.pack.js"></script>
    <script type="text/javascript">
      jQuery(function() {
        $('#slider').nivoSlider();
    });
    </script>
	<!-- end slideshow -->
	</div>
<br>
<br>
<div id="default-news">
	 <?php
					$tb_name="tb_news";
					$div_name="news";
					$foldername="fileupload/news/";
					echo "<table width='90%' border='0'><th colspan='2'></th>";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					//$showimage=SearchImage($tb_name,$row_news['no'],$foldername,"0");
					
					
					echo "<tr>";
					//echo "<td width=\"30%\"><img src='$showimage' ></td>";
					echo "<td valign='center' colspan='2'><div id=subject><a href=index.php?_mod=".encode64($div_name)."&no=".$row_news['no']." >-:-&nbsp;".$row_news['subject']."&nbsp;-:-</a></div><div id=detail>".$row_news['detail1']."</div></td>";
					
					
					echo "</tr>";
				
					}
					echo "<tr><td colspan=\"2\" align=\"right\" valign=\"bottom\" height=\"10\"><a href=\"index.php?_mod=".encode64($div_name)."\" class='readmore'></a></td></tr>";
					echo "</table>";
?>	
</div>
<br>
<div id="default-activity">
	<center>
	
	 <?php
					$tb_name="tb_activity";
					$div_name="activity";
					$foldername="fileupload/activity/";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,6";
					
					$rs=rsQuery($sql);
					echo "<table><tr><td>";
					echo "<div id=\"mainwrapper\">";
					while($row_news=mysqli_fetch_array($rs)){
						$numrow=$numrow+1;
				//	if ($row_news){
				//		$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
				//		$rs2=rsQuery($strSql);
				//		$rs_filename=mysqli_fetch_array($rs2);
				//	}
					$showimage=SearchImage($tb_name,$row_news['no'],$foldername,"0");
					$subject=$row_news['subject'];
					$detail=$row_news['detail1'];
					echo "<div id=\"box-6\" class=\"box\">";
					echo "<a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." ><img id=\"image-6\" src='$showimage'>";
					echo "<span class=\"caption scale-caption\">";
					echo "<h3>".$subject."</h3>";
					echo "<p>".$detail."</p>";
					echo "</span>";
					echo "</div>";
				
				
					}
					echo "</div>";
					echo "</td></tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($div_name)."\" class=\"readmore\"></a></td></tr>";
?>
	
		
		
			
		
	</table>
	</center>
</div>
<br>

<!-- จัดซื้อจัดจ้าง -->
    <div id="default-purchase">
				
					<table width=90% border=0>
					<tr><th></th></tr>
					<tr><td>
					<?php 
						$tb_name="tb_purchase";
					$div_name="purchase";
						$sql="Select * From $tb_name where status='1' Order by datepost DESC limit 0,6";
		  					rsQuery("SET NAMES utf8");
							 $rs=rsQuery($sql);
							while($row = mysqli_fetch_array($rs)){
								$datediff=DateDiff($row['datepost'],date("Y-m-d"));
								if($datediff<=10){
									$img=$img_new;
									
								}else{
									$img="";
								}
								
								echo "<li><a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row['no'])."><b>".$row['subject']."</b>&nbsp;</a>".$img."</li>";
							}
							?>
                
				<div align="right" valign="center"><a href="index.php?_mod=<?php echo encode64($div_name);?>" class="readmore"></a></div>
				
				</td></tr></table>
            </div>	
			<br><br>
	


<div id="youtube" align="center">
			<?php
				$sql="select * from tb_youtube where active='1' Order by id DESC Limit 0,2";
				$rs=rsQuery($sql);
				if($rs){
					echo "<table><tr>";
					while($data=mysqli_fetch_array($rs)){
						$video_id=$data['video_id'];
						
						echo "<td><iframe width=\"$glo_youtube_width\" height=\"$glo_youtube_height\" src=\"https://www.youtube.com/embed/$video_id\" frameborder=\"0\" allowfullscreen></iframe><td>";
					}
					echo "</tr></table>";
				}
			?>
	</div>
<br>
<div id="default-travel">
	 <?php
					$tb_name="tb_travel";
					$div_name="travel";
					$foldername="fileupload/travel/";
					echo "<table width=90% border=0><th colspan=2></th>";
					echo "<tr>";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					//if ($row_news){
					//	$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
					//	$rs2=rsQuery($strSql);
					//	$rs_filename=mysqli_fetch_array($rs2);
					//}
					$showimage=SearchImage($tb_name,$row_news['no'],$foldername,"0");
					
					
					echo "<td valign=top><a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." ><img src='$showimage' width=\"100\" height=\"100\"><div id=subject>".$row_news['subject']."</a></div></td>";
					
					
					
				
					}
					echo "</tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($div_name)."\" class=\"readmore\"></a></td></tr>";
				echo "</table>";
?>	
</div>

<br>
<div id="default-otop">
	 <?php
					$tb_name="tb_otop";
					$div_name="otop";
					$foldername="fileupload/otop/";
					echo "<table width=90% border=0><th colspan=2></th>";
					echo "<tr>";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					//if ($row_news){
					//	$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
					//	$rs2=rsQuery($strSql);
					//	$rs_filename=mysqli_fetch_array($rs2);
					//}
					$showimage=SearchImage($tb_name,$row_news['no'],$foldername,"0");
					
					
					echo "<td valign=top><a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." ><img src='$showimage' width=\"100\" height=\"100\"><div id=subject>".$row_news['subject']."</a></div></td>";
					
					
					
				
					}
					echo "</tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($div_name)."\" class=\"readmore\"></a></td></tr>";
				echo "</table>";
?>	
</div>
	
</body>
</html>
