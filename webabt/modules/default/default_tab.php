<?php
		$img_new="<img src=images/new.gif>";
?>
<html>
<head>
<meta charset="utf-8">
<!-- เพลง -->
<!--<embed src="fileupload/mp3/march.mp3" autostart="true" loop="false" hidden="true">  -->

</head>

<body>
<center>
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
</center>
<div id="default-news">
	 <?php
					$tb_name="tb_news";
					$div_name="news";
					$foldername="fileupload/news/";
					echo "<table width=90% border=0><th colspan=2></th>";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					if ($row_news){

						$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
						$rs2=rsQuery($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
					}
					$datediff=DateDiff($row['datepost'],date("Y-m-d"));
								if($datediff<=10){
									$img=$img_new;
									
								}else{
									$img="";
								}
					
					echo "<tr>";
					echo "<td valign='top' colspan='2'><div id=subject><a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." >".$row_news['subject']."</a>".$img."</div></td>";
				//	echo "<td width=\"40%\"><img src=fileupload/$div_name/".$rs_filename['filename']." ></td>";
					
					echo "</tr>";
				
					}
					echo "<tr><td colspan=\"2\" align=\"right\" valign=\"bottom\" height=\"10\"><a href=\"index.php?_mod=".encode64($div_name)."\" class=\"readmore\"></a></td></tr>";
					echo "</table>";
?>	
</div>


<div id="default-activity">
	<center>
	<table width="90%"><tr width="100%">
	 <?php
					$tb_name="tb_activity";
					$div_name="activity";
					$foldername="fileupload/activity/";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,6";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
						$numrow=$numrow+1;
					if ($row_news){
						$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
						$rs2=rsQuery($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
					}
					
					echo "<td valign='top' width='30%'>";
					echo "<a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." ><img src=fileupload/$div_name/".$rs_filename['filename']."></a><br><br><div id=subject><a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." >".$row_news['subject']."</a></div></td>";
					//echo "<div id=subject><a href=index.php?_mod=".encode64($div_name)."&no=".$row_news['no']." >".$row_news['subject']."</a></div><div id=detail>".$row_news['detail1']."</div></td>";
					
						if($numrow==3){
						echo "</tr><tr>";
						$numrow=0;
					}
				
					}
				
					echo "</tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($div_name)."\" class=\"readmore\"></a></td></tr>";
?>
	</table>
	</center>
</div>

<div id="tabs">
  <ul>
    <li><a href="#default-purchase">จัดซื้อจัดจ้าง</a></li>
    <li><a href="#default-otop">สินค้าชุมชน</a></li>
    <li><a href="#default-travel">สถานที่สำคัญ</a></li>
  </ul>
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
					if ($row_news){
						$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
						$rs2=rsQuery($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
					}
					echo "<td valign=top><a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." ><img src=fileupload/$div_name/".$rs_filename['filename']." width=\"100\" height=\"100\"><div id=subject>".$row_news['subject']."</a></div></td>";				
					}
					echo "</tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($div_name)."\" class=\"readmore\"></a></td></tr>";
					echo "</table>";
?>	
</div>
  <div id="default-travel">
	 <?php
					$tb_name="tb_travel";
					$div_name="otop";
					$foldername="fileupload/otop/";
					echo "<table width=90% border=0><th colspan=2></th>";
					echo "<tr>";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					if ($row_news){
						$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
						$rs2=rsQuery($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
					}
					
					echo "<td valign=top><a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row_news['no'])." ><img src=fileupload/$div_name/".$rs_filename['filename']." width=\"100\" height=\"100\"><div id=subject>".$row_news['subject']."</a></div></td>";
					}
					echo "</tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($div_name)."\" class=\"readmore\"></a></td></tr>";
					echo "</table>";
?>	
</div>
</div>
 


			
	

	
<!-- สาระน่ารู้ -->
<!--
		   <div id="default-tip">
				<table width=90% border=0><th colspan=2></th>
					<tr>
					<td>
					
					<?php 
							$tb_name="tb_tip";
					$div_name="tip";
						$sql="Select * From $tb_name where status='1' Order by datepost DESC limit 0,5";
		  					
							 $rs=rsQuery($sql);
							while($row = mysqli_fetch_array($rs)){
								$datediff=DateDiff($row['datepost'],date("Y-m-d"));
								if($datediff<=10){
									$img=$img_new;
									
								}else{
									$img="";
								}
								
								echo "<div id=\"subject\"><img src=\"images/component/icon-menu3.png\" align=\"middle\" style=\"border:0;\">&nbsp;&nbsp;&nbsp;<a href=index.php?_mod=".encode64($div_name)."&no=".encode64($row['no']).">".$row['subject']."&nbsp;</a>".$img."</div>";
							}
							?>
					</td>
					</tr>
					<tr height="20">
						<td colspan="2" align="right" valign="bottom" height="20"><a href="index.php?_mod=<?php echo encode64($div_name);?>" class="readmore"></a></td></tr>
					</table>
				
				
				
            </div>
			-->
		
</body>
</html>
