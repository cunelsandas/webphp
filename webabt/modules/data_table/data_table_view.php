<?php
$no=EscapeValue(decode64($_GET['no']));
$mod=EscapeValue(decode64($_GET['_mod']));
$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
$foldername=$gloUploadPath."/".$folder."/";
$sql="Select * from $tablename where no=$no";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);

?>
<center>
<div id="master-table">
<table width="100%">
	<tr >
		<td colspan="2" align="left" style="padding:8px;">&nbsp;ชื่อเอกสาร&nbsp;:&nbsp;<?php echo $row['subject'];?>&nbsp;
		<?php 
			if($showdate=="yes"){
					echo "&nbsp;[&nbsp;".thaidate($row['datepost'])."&nbsp;]";
					}
			
			?>
			</td>
	</tr>
	<tr>
		<td width="20%" valign="top" >รายละเอียดเอกสาร</td>
		<td  valign="top"  ><?php echo nl2br($row['detail']);?></td>
	</tr>
	<tr>
		<td></td>
		<td>
		<?php
	$strSql="select * from filename where tablename='$tablename' AND masterid='".$no."' Order by id DESC";	
	$rs2=rsQuery($strSql);
	
	if($rs2){ 
	//$i=0;
	while($rs_filename=mysqli_fetch_array($rs2)){
		
		$cpic=file_exists($foldername.$rs_filename['filename']);
		$type=strtolower(substr($rs_filename['filename'],-3));
		if($cpic){
			if($type<>"pdf"){
			echo"<a href=".$foldername.$rs_filename['filename']." target=\"_blank\"><img src=".$foldername.$rs_filename['filename']." width=\"150\" height=150 id='$borderpic' /></a>&nbsp;&nbsp;";
			
			}else{
				echo"<a href=".$foldername.$rs_filename['filename']." target=\"_blank\"><img src=\"images/pdf.gif\" title=\"ดาวน์โหลดเอกสาร\"></a>&nbsp;&nbsp;";
				//echo "<iframe id='".$rs_filename['filename']."' width='600' height='800' src='".$foldername.$rs_filename['filename']."'></iframe>";
				//echo "<object src='".$foldername.$rs_filename['filename']."' width='700px' height='700px'>";
				//echo "<embed src='".$foldername.$rs_filename['filename']."' width='700px' height='700px'></embed>";
				//echo "</object>";
			}
		}
	}
	}

?>
	
		</td>
	</tr>
</table>
</div>
<br>
<A HREF="javascript:history.back()">ย้อนกลับ</A> 
</center>
</div>