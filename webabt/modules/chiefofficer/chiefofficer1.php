<?php
	$foldername="fileupload/goverment/";
	$tablename="tb_goverment";
	$block1_colsno="1";
	$block2_colsno="1";
	$block3_colsno="3";
	$block4_colsno="3";
?>
<script type="text/javascript">
   function open_new_window(URL)
   {
   NewWindow = window.open(URL,"_blank","toolbar=no,menubar=0,status=0,copyhistory=0,scrollbars=yes,resizable=1,location=0,Width=600,Height=600") ;
   NewWindow.location = URL;
   }
 </script>
<div id="chiefofficer">
<center>

<table border="0" width="90%">	
		<tr>
		 <?php // พนักงานเจ้าหน้าที่  บล๊อกการแสดง 1
				$i=1;
				$sql="Select * From $tablename Where sid='1' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							//$history=!empty($row['history'])?"<div class=\"tooltip\"><img src=\"images/document_icon.png\"><span>".$row['history']."</span></div>":"";
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_goverment')."&p=".encode64('goverment')."');\"><img src=\"images/document_icon.png\"></a>":"";
							echo"<td valign=\"top\" align=\"center\">";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
							echo"<td align=\"center\"><img src=".$filepath ." class=\"photo_border\"><br/><br/>".$row['name']."<br/>".$row['position']."$history";
							echo"</tr>";
							echo"</table>";
							echo"</td>";
								if($i==$block1_colsno){
									echo"</tr><tr>";
									$i=0;
								}
							$i++;
						}
				}
	?>
	</tr>
</table>
<BR>
<table border="0" width="90%" align="center">	
		<tr>
		 <?php // รองนายก  บล๊อกการแสดง 2
				$i=1;
				$sql="Select * From $tablename Where sid='2' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_goverment')."&p=".encode64('goverment')."');\"><img src=\"images/document_icon.png\"></a>":"";
							echo"<td valign=\"top\" align=\"center\">";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
							echo"<td align=\"center\"><img src=".$filepath ." class=\"photo_border\"><br/><br/>".$row['name']."<br/>".$row['position']."$history";
							echo"</tr>";
							echo"</table>";
							echo"</td>";
								if($i==$block2_colsno){
									echo"</tr><tr>";
									$i=0;
								}
							$i++;
						}
				}
	?>
	</tr>
</table>
<br>
<!--เลขา-->
<table border="0" width="90%" align="center">	
		<tr>
		 <?php // เลขาหรือที่ปรึกษา  บล๊อกการแสดง 3
				$i=1;
				$sql="Select * From $tablename Where sid='3' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_goverment')."&p=".encode64('goverment')."');\"><img src=\"images/document_icon.png\"></a>":"";
							echo"<td valign=\"top\" align=\"center\">";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
							echo"<td align=\"center\"><img src=".$filepath ." class=\"photo_border\"><br/><br/>".$row['name']."<br/>".$row['position']."$history";
							echo"</tr>";
							echo"</table>";
							echo"</td>";
								if($i==$block3_colsno){
									echo"</tr><tr>";
									$i=0;
								}
							$i++;
						}
				}
	?>
	</tr>
</table>
<br>
<!--ที่ปรึกษา -->
 <table border="0">	
		<tr>
		 <?php // ที่ปรึกษา  บล๊อกการแสดง 4
				$i=1;
				$sql="Select * From $tablename Where sid='4' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_goverment')."&p=".encode64('goverment')."');\"><img src=\"images/document_icon.png\"></a>":"";
							echo"<td valign=\"top\" align=\"center\">";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
							echo"<td align=\"center\"><img src=".$filepath ." class=\"photo_border\"><br/><br/>".$row['name']."<br/>".$row['position']."$history";
							echo"</tr>";
							echo"</table>";
							echo"</td>";
								if($i==$block4_colsno){
									echo"</tr><tr>";
									$i=0;
								}
							$i++;
						}
				}
	?>
	</tr>
</table>  
  </center>
  </div>