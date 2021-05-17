<?php
		$img_new="<img src=images/new.gif>";
?>
<html>
<head>
<!-- เพลง -->
<!--<embed src="fileupload/mp3/march.mp3" autostart="true" loop="false" hidden="true">  -->
</head>

<body>
<div id="default-news">
	 <?php
					$tb_name="tb_news";
					$div_name="news";
					echo "<table width=100% border=0><th colspan=2></th>";
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
					echo "<td width=\"40%\"><img src=fileupload/$div_name/".$rs_filename['filename']." ></td>";
					
					echo "</tr>";
				
					}
					echo "<tr><td colspan=\"2\" align=\"right\" valign=\"bottom\" height=\"10\"><a href=\"index.php?_mod=".encode64($div_name)."\">อ่านทั้งหมด</a></td></tr>";
					echo "</table>";
?>	
</div>
<div id="default-activity">
	<center>
	<table width="100%"><tr width="100%">
	 <?php
					$tb_name="tb_activity";
					$div_name="activity";
					$sql="Select * From $tb_name Where status=1 Order by datepost DESC limit 0,3";
					
					$rs=rsQuery($sql);
					
					while($row_news=mysqli_fetch_array($rs)){
					if ($row_news){
						$strSql="select * from filename where tablename='$tb_name' AND masterid='".$row_news['no']."' Order by Rand() limit 1";	
						$rs2=rsQuery($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
					}
					
					echo "<td >";
					echo "<img src=fileupload/$div_name/".$rs_filename['filename'].">";
					echo "<div id=subject><a href=index.php?_mod=".encode64($div_name)."&no=".$row_news['no']." >".$row_news['subject']."</a></div><div id=detail>".$row_news['detail1']."</div></td>";
					
					
				
					}
					echo "</tr>";
					echo "<tr><th colspan=\"3\" align=\"center\" valign=\"center\" ><a href=\"index.php?_mod=".encode64($div_name)."\">อ่านทั้งหมด</a></th></tr>";
?>
	</table>
	</center>
</div>


<!-- จัดซื้อจัดจ้าง -->
    <div id="default-purchase">
				
					<table width=100% border=0>
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
								
								echo "<li><a href=index.php?_mod=".encode64($div_name)."&no=".$row['no']."><b>".$row['subject']."</b>&nbsp;</a>".$img."</li>";
							}
							?>
                
				<div align="right" valign="center"><a href="index.php?_mod=<?php echo encode64($div_name);?>">อ่านทั้งหมด</a></div>
				
				</td></tr></table>
            </div>	
			
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

<!-- สาระน่ารู้ -->
           <div id="default-tip">
				<table width=100% border=0><th colspan=2></th>
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
								
								echo "<div id=\"subject\"><img src=\"images/component/icon-menu3.png\" align=\"middle\" style=\"border:0;\">&nbsp;&nbsp;&nbsp;<a href=index.php?_mod=".encode64($div_name)."&no=".$row['no'].">".$row['subject']."&nbsp;</a>".$img."</div>";
							}
							?>
					</td>
					</tr>
					<tr height="20">
						<td colspan="2" align="right" valign="bottom" height="20"><a href="index.php?_mod=<?php echo encode64($div_name);?>">อ่านทั้งหมด</a></td></tr>
					</table>
				
				
				
            </div>
</body>
</html>
