
<!-- ข่าวประชาสัมพันธ์-->
<table width="500" cellpadding="0" cellspacing="1" border="0" style="margin-top:5px;">

	<tr>
			<td><img src="images/mn_news.png" ></td>	
	</tr>
</table>

<table cellspacing="1" cellpadding="1"  width="500" style="margit-top:5px;" border=0>
<tr>
	<td>

	<?php
		$sql="select * from tb_news where status=1 order by datepost DESC limit 0,2";  // เลือกออกมา 2 record ที่ใหม่ที่สุด
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_array($rs)){
			$c+=1;
				
				//$detail1=substr($detail1,0,600)."  ..."; //ตัดคำที่ 600 ตัวอักษร
				$detail1=$row["detail1"];
			
				if($detail1<>""){
				$detail1=wordwrap($detail1,100);
				}else{
					$detail1="";
				}
				if ($row){
						$strSql="select * from filename where tablename='tb_news' AND masterid='".$row['no']."' Order by Rand() limit 1";	
						$rs2=mysqli_query($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
					}
					if($c==1){ //สลับซ้ายขวา
						$strData="<table border=0><tr><td width=150><img src=images/news/".$rs_filename['filename']." width=150 height=150></td><td width=340 class=tbl3 valign=top><a href=index.php?_mod=news&no=".$row['no'].">".$row['subject']."</a><br>".$detail1."</td></tr></table>";
					}else{
						$strData="<table border=0><tr><td width=340 class=tbl3 valign=top><a href=index.php?_mod=news&no=".$row['no'].">".$row['subject']."</a><br>".$detail1."</td><td width=150><img src=images/news/".$rs_filename['filename']." width=150 height=150></td></tr></table>";
					}
					echo $strData;
					if($c>=2){
						$c=0;
					}
		}
		?>

		</td></tr>
		</table>



<br>
<table width="500" cellpadding="0" cellspacing="1" border="0" style="margin-top:5px;">
	<tr>
			<td><img src="images/mn_activity.png" ></td>	
	</tr>
</table>
<!-- กิจกรรม/โครงการ แต่ละกอง-->
<?php
	$strsql="select * from tb_activity_dep order by id";   // วนลูปส่วน/กอง จาก tb_activity_dep เพื่อเอา id ไปแสดงผลใน tb_activity(department)
	$rs1=rsQuery($strsql);
	while($dep=mysqli_fetch_array($rs1)){
		$depid=$dep['id'];
		$depname=$dep['name'];
		?>
<table width="500" cellpadding="0" cellspacing="1"  style="margin-top:5px;">
	<tr>
			<td class="textblur"><?php echo $depname;?></td>
	</tr>
</table>
<table cellspacing="1" cellpadding="1" width="500" style="margit-top:5px;">
	
	<?php
		$sql="select * from tb_activity where department=$depid and status=1 order by datepost DESC limit 0,2";  // เลือกออกมา 2 record ที่ใหม่ที่สุด
		$rs=rsQuery($sql);
		$rowno=mysqli_num_rows($rs);
		if($rowno>0){
		while($row=mysqli_fetch_array($rs)){

				$detail1=$row["detail1"];
			
				if($detail1<>""){
				$detail1=wordwrap($detail1,100);
				}else{
					$detail1="";
				}
				if ($row){
						$strSql="select * from filename where tablename='tb_activity' AND masterid='".$row['no']."' Order by Rand() limit 1";	
						$rs2=mysqli_query($strSql);
						$rs_filename=mysqli_fetch_array($rs2);
						}
						$strData="<tr><td width=150><img src=images/activity/".$rs_filename['filename']." width=150 height=150></td><td width=350 class=tbl3 valign=top><a href=index.php?_mod=activity&no=".$row['no'].">".$row['subject']."</a><br>".$detail1."</td></tr>";
						echo $strData;
					
		}
		}else{ // กรณีไ่ม่มีข้อมูลให้ใส่กรอบเปล่า
			echo "<tr><td width=400 height=200 class=tbl3 valign=top colspan=2>&nbsp;</td></tr>";
			
		}
		?>

	</table>
	<?php
	}
		?>
	<!--จัดซื้อจัดจ้าง-->
	<br>
<table width="500" cellpadding="0" cellspacing="1" border="0" style="margin-top:5px;">
	<tr>
			<td><img src="images/mn_purchase.png" ></td>	
	</tr>
</table>
<table width=500 border=0>
	<tr><td width=350 height=200 class=tbl3 valign=top colspan=2>
		<?php 
				  $sql="Select * From tb_purchase where status='1' Order by datepost LIMIT 0,5";
		  			mysqli_query("SET NAMES utf8");
				  $rs=mysqli_query($sql);
					while($row = mysqli_fetch_array($rs)){
						$nowdate=date("Y-m-d");
						$datediff=DateDiff($row['datepost'],$nowdate);
						if($datediff<=10){
							$newdata="<img src=images/component/new.gif>";
						}else{
							$newdata="";
						}
						echo "<p style=\"margin:20px;\"><a class=\"menu\" href=\"index.php?_mod=purchase&no=".$row['no']."\"><b>".$row['subject']."</b>&nbsp;</a>".$newdata."<BR>";
						//$msg=iconv("UTF-8","TIS-620",$row['detail']);
						//$msg=wordwrap($msg,100);
						//$msg=iconv("TIS-620","UTF-8",$msg);
						//$msg=$msg."....";
						//echo $msg;
						//echo "<font size=2 color=#808080>&nbsp;ประกาศ :&nbsp;";
						//echo thaidate($row['datepost'])."</font>";
						echo "</p>";
						}
				  ?>
	</td></tr>
</table>

