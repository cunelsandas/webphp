<?php
$mod=EscapeValue(decode64($_GET['_mod']));
$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
$foldername=$gloUploadPath."/".$folder."/";
$no=EscapeValue(decode64($_GET['no']));

	$sql="Select * From ".$tablename." where no=$no";
	$rs=rsQuery($sql);
	if($rs){
	$row=mysqli_fetch_assoc($rs);

	
	?>
   
 <!--   <script type="text/javascript" src="js/jquery.js"></script> -->
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



		<TABLE width="100%" align="center" border="0">
		<TR>
			<TD align="left"><div class="subject"><?php echo $row['subject'];?></div>
			<?php
				echo "<div class=\"detail\">".$row['detail1']."</div>";
				if($showdate=="yes"){
					echo"<br>&nbsp;<div class=\"showdatepost\">".thaidate($row['datepost'])."</div>";
				}
			?>
	

	
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.6";
				  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
</script>
	
	<div class="fb-share-button" 
		data-href="http://<?php echo $domainname;?>/index.php?_mod=<?php echo encode64($mod);?>&no=<?php echo encode64($no);?>"  
		data-layout="button" 
		data-size="small" 
		data-mobile-iframe="true">
	<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">แชร์</a>
	</div>
	
	
			</TD>
		</tr>
		</table>
		<?php }?>



<table width="100%" border="0" align="center">
	<tr><td valign='top'>

<?php
	$strSql="select * from filename where tablename='$tablename' AND masterid='".$row['no']."' Order by id ASC";	
	$strSql2="select * from filename where tablename='$tablename' AND masterid='".$row['no']."' Order by id ASC";	
	$rs2=rsQuery($strSql);
	$rsPDF=rsQuery($strSql2);
	if($rs2){
	
		echo "<div style='max-width:95%'>";
		while($rs_filename=mysqli_fetch_assoc($rs2)){
					$type=strtolower(substr($rs_filename['filename'],-3));
					$cpic=file_exists($foldername.$rs_filename['filename']);
					
					if($cpic){
						if($type<>'pdf'){
						
							echo "<a href=\"".$foldername.$rs_filename['filename']."\" target=\"_blank\"><video autoplay controls width='720px' src=\"".$foldername.$rs_filename['filename']."\"'></video></a>";
						}
					}else{
						if($default_image=="0"){
						echo "<img src=\"images/notfound.jpg\">";
						}else{
							echo "<img src=\"images/".$default_image."\">";
						}
					}
		}
		echo "</div>";
	
	}

	if($rsPDF){
		
		while($rs_filename=mysqli_fetch_assoc($rsPDF)){
					$type=strtolower(substr($rs_filename['filename'],-3));
					$cpic=file_exists($foldername.$rs_filename['filename']);
					
					if($cpic){
						if($type=='pdf'){
						
							echo "<a href=\"".$foldername.$rs_filename['filename']."\" target=\"_blank\"><img src=\"images/pdf.gif\"></a>";
						}
					}
		}
		
		
	}

?>


</td></tr>
</table>
</div>
