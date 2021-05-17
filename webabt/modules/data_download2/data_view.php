   <!--  <script type="text/javascript" src="js/jquery.js"></script> -->
    <script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
	<script type="text/javascript" src="js/jquery-1.32.min.js"></script>
	<script type="text/javascript" src="js/jquery.colorbox.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
	<link type="text/css" media="screen" rel="stylesheet" href="css/colorbox.css" />

    <script type="text/javascript">
    $(function() {
        $('#gallery a').lightBox();
    });
    </script>
<?php
$mod=EscapeValue(decode64($_GET['_mod']));
$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");

$foldername=$gloUploadPath."/".$folder."/";
$no=EscapeValue(decode64($_GET['no']));
$sql="Select * From $tablename where no='$no'";

$rs=rsQuery($sql);
if($rs){
$row=mysqli_fetch_assoc($rs);
}
?>
<center>
<div id="master-table">
<table width="90%" cellpadding="1" cellspacing="1" border="0" class="tbl-border1" style="margin-bottom:10px;">
	<tr >
		<td colspan="2" class="tbl2" align="left" style="padding:8px;">&nbsp;ชื่อ&nbsp;:&nbsp;<?php echo $row['subject'];?>
		<?php
				echo "&nbsp;[&nbsp;".thaidate($row['datepost'])."&nbsp]";

			?></td>
	</tr>
	<tr>
		<td  width="120" valign="top" class="tbl2" style="padding:8px;">หน่วยงาน</td>
		<td width="480" valign="top" class="tbl1" style="padding:8px;"><?php echo $row['offid'];?></td>
	</tr>
	<tr>
		<td  width="120" valign="top" class="tbl2" style="padding:8px;">เลขที่หนังสือ</td>
		<td width="480" valign="top" class="tbl1" style="padding:8px;"><?php echo $row['booknum'];?></td>
	</tr>
	<tr>
		<td  width="120" valign="top" class="tbl2" style="padding:8px;">หนังสือลงวันที่</td>
		<td width="480" valign="top" class="tbl1" style="padding:8px;"><?php echo $row['datebook'];?></td>
	</tr>
	<tr>
		<td  width="120" valign="top" class="tbl2" style="padding:8px;">รายละเอียด</td>
		<td width="480" valign="top" class="tbl1" style="padding:8px;"><?php echo $row['detail'];?></td>
	</tr>
	</table>
	</div>

<table width="90%" border="0" align="center">

	<tr>
<div id="gallery">
<?php
	$strSql="select * from filename where tablename='$tablename' AND masterid='".$row['no']."' Order by id DESC";
	$rs2=rsQuery($strSql);

	if($rs2){
	while($rs_filename=mysqli_fetch_assoc($rs2)){

		$cpic=file_exists($foldername.$rs_filename['filename']);

		$type=strtolower(substr($rs_filename['filename'],-3));

		if($cpic){
			if($type<>"pdf"){
			echo"<a href=".$foldername.$rs_filename['filename']." target=\"_blank\"><img src=".$foldername.$rs_filename['filename']." width=\"150\" height=150 id='$borderpic' /></a>&nbsp;&nbsp;";

			}
		}
	}
	}else{

	for($i=1;$i<=16;$i++){
		$cpic=file_exists($foldername.$row['no']."-$i.JPG");
		if($cpic){
			echo"<a href='".$foldername.$row['no']."-$i.JPG'  target=\"_blank\"><img src='".$foldername.$row['no']."-$i.JPG'  width=\"150\" height=150 style=\"margin:5px;\" border=\"0\" /></a>";
		}
	}
}

?>
</div>
</tr>
<tr><br><br></tr>
<tr> <!-- pdf -->
		<?php
	$strSql="select * from filename where tablename='$tablename' AND masterid='".$row['no']."' Order by id DESC";
	$rs2=rsQuery($strSql);

	if($rs2){
	//$i=0;
	while($rs_filename=mysqli_fetch_assoc($rs2)){

		$cpic=file_exists($foldername.$rs_filename['filename']);
		$type=strtolower(substr($rs_filename['filename'],-3));
		if($cpic){
			if($type=="pdf"){

				echo"&nbsp;&nbsp;<a href=".$foldername.$rs_filename['filename']." target=\"_blank\" title=\"เอกสาร PDF\"><img src=\"images/pdf.gif\" style=\"border:none;width:80px;height:95px;\" /></a>&nbsp;&nbsp;";
			}
		}
	}
	}

?>
</tr>
</table>
<A HREF="javascript:history.back()">ย้อนกลับ</A>
</center>


</div>