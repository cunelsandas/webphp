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
<div id="default-news">
	 <?php
					$tb_name="tb_news";
					$div_name="news";
					$foldername="fileupload/news/";
					echo "<table width='90%' border='0'><th colspan='2'></th>";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					$showimage=SearchImage($tb_name,$row_news['no'],$foldername,"0");
					
					
					echo "<tr>";
					echo "<td width=\"30%\"><img src='$showimage' ></td>";
					echo "<td valign='center'><div id=subject><a href=index.php?_mod=".encode64($div_name)."&no=".$row_news['no']." >".$row_news['subject']."</a></div><div id=detail>".$row_news['detail1']."</div></td>";
					
					
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




<br><br>
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
	<div id="default-otop">
	 <?php
					$tb_name="tb_otop";
					$div_name="otop";
					echo "<table width=100% border=0><th colspan=2></th>";
					echo "<tr>";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					if ($row_news){
						$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
						$rs2=rsQuery($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
					}
					
					
					
					echo "<td valign=top><a href=index.php?_mod=".encode64($div_name)."&no=".$row_news['no']." ><img src=fileupload/$div_name/".$rs_filename['filename']." width=\"100\" height=\"100\"><div id=subject>".$row_news['subject']."</a></div></td>";
					
					
					
				
					}
					echo "</tr>";
					echo "<tr><td colspan=\"3\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($div_name)."\">อ่านทั้งหมด</a></td></tr>";
					echo "</table>";
?>	
</div>
<div id="default-travel">
	 <?php
					$tb_name="tb_travel";
					$div_name="travel";
					echo "<table width=100% border=0>";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					if ($row_news){
						$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
						$rs2=rsQuery($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
					}
					
					
					echo "<tr>";
					echo "<td valign=top><div id=subject><a href=index.php?_mod=".encode64($div_name)."&no=".$row_news['no']." >".$row_news['subject']."</a></div><div id=detail>".$row_news['detail1']."</div></td>";
					echo "<td width=\"40%\"><img src=fileupload/$div_name/".$rs_filename['filename']." width=\"150\" height=\"150\"></td>";
					
					echo "</tr>";
				
					}
					echo "<tr><td colspan=\"2\" align=\"right\" height=\"40\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($div_name)."\">อ่านทั้งหมด</a></td></tr>";
					echo "</table>";
?>	
</div>

<!--
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
	-->
	<br>

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
<!--	<div id="webboard1">
		<?php
			$tablename="tb_wb_mas";
			$div_name="webboard";
			echo "<img src='images/mn_webboard.png'>";
			echo "<table width='90%'>";
		echo "<tr><th width=85% align=left>หัวข้อ</th><th width=15% align=center>ตอบ</th></tr>";
		$sql = "select * from $tablename Where status='1' order by wid DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่
		while($arr = mysqli_fetch_array($Query)){
			$cdate=$arr['createdate'];
			if($cdate==null){
				$dt=DateThai($arr['datepost']);
			}else{
				$dt=DateTimeThai($arr['createdate']);
			}
			echo"<tr><td ><a href=\"index.php?_mod=".encode64($div_name)."&type=".encode64('view')."&no=".encode64($arr['wid'])."\">";
			echo $arr['subject']."</a><br><font id=text-clay>&nbsp;&nbsp;โดย :".$arr['postby']."&nbsp;&nbsp;".$dt."</font></td>";
			$sql="Select * From tb_wb_sub Where wid='".$arr['wid']."'";
			$crs=rsQuery($sql);
			$num=mysqli_num_rows($crs);
			if($num==0){
				echo"<td align=center ><font style=\"color:red;\">$num</font><?td>";
			}else{
				echo"<td align=center ><font >$num</font></td>";
			}
			echo"</tr>";
		}
		echo "<tr><td colspan=\"2\" align=\"right\" valign=\"bottom\"><a href=\"index.php?_mod=".encode64($div_name)."\" class='readmore'></a></td></tr>";
		echo "</table>";
		?>
	</div>
	-->
</body>
</html>
