 <center>
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
		<TABLE width="100%" align="center" border="0">
		<TR>
			<TD align="left"><div class="subject"><?php echo $row['subject'];?></div>
			<?php
				echo "<div class=\"detail\">".$row['detail']."</div>";
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
	<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">ск├ь</a>
	</div>
	<!-- Your like button code -->
	<div class="fb-like" 
		data-href="http://<?php echo $domainname;?>/index.php?_mod=<?php echo encode64($mod);?>&no=<?php echo encode64($no);?>" 
		data-layout="standard" 
		data-action="like" 
		data-show-faces="true">
	</div>
	
			</TD>
		</tr>
		</table>
		<?php }?>
<br>
</div>