<?php
	$mod=EscapeValue(decode64($_GET['_mod']));
	$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
	$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
	$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
	$foldername=$gloUploadPath."/".$folder."/";
	if($device=="Mobile"){
		$block1_colsno="1"; //ประธาน แสดงจำนวน columnว่าให้แสงดกี่ภาพ
	$block2_colsno="1"; //รองประธาน
	$block3_colsno="1"; // เลขา
	$block4_colsno="1"; //สมาชิกเขต 1
	$block5_colsno="1";
	$block6_colsno="1";
	}else{
	$block1_colsno="1"; //ประธาน แสดงจำนวน columnว่าให้แสงดกี่ภาพ
	$block2_colsno="1"; //รองประธาน
	$block3_colsno="1"; // เลขา
	$block4_colsno="3"; //สมาชิกเขต 1
	$block5_colsno="3";
	$block6_colsno="3";
	}
	$block4_title="";
	$block5_title="";
	$block6_title="";
?>
<script type="text/javascript">
   function open_new_window(URL)
   {
   NewWindow = window.open(URL,"_blank","toolbar=no,menubar=0,status=0,copyhistory=0,scrollbars=yes,resizable=1,location=0,Width=600,Height=600") ;
   NewWindow.location = URL;
   }
 </script>
<div id="person_board">
<span class="banner_title"><?php echo $modname;?></span>
<center>  

<table border="0" width="90%">	
		<tr>
		 <?php // ประธานสภา  บล๊อกการแสดง 1
				$i=1;
				$sql="Select * From $tablename Where sid='1' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							//$history=!empty($row['history'])?"<div class=\"tooltip\"><img src=\"images/document_icon.png\"><span>".$row['history']."</span></div>":"";
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
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
		 <?php // รองประธาน  บล๊อกการแสดง 2
				$i=1;
				$sql="Select * From $tablename Where sid='2' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
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
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
							echo"<td valign=\"top\" align='left' id='board-block3'>";
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
<p><?php echo $block4_title;?></p>
<!--สมาชิกเขต 1 -->
 <table border="0">	
		<tr>
		 <?php // สมาชิกสภาเขต 1  บล๊อกการแสดง 4
				$i=1;
				$sql="Select * From $tablename Where sid='4' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
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
<br>
<p><?php echo $block5_title;?></p>
<!--สมาชิกเขต 2 -->
 <table border="0">	
		<tr>
		 <?php // สมาชิกสภาเขต 2  บล๊อกการแสดง 5
				$i=1;
				$sql="Select * From $tablename Where sid='5' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
							echo"<td valign=\"top\" align=\"center\">";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
							echo"<td align=\"center\"><img src=".$filepath ." class=\"photo_border\"><br/><br/>".$row['name']."<br/>".$row['position']."$history";
							echo"</tr>";
							echo"</table>";
							echo"</td>";
								if($i==$block5_colsno){
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
<p><?php echo $block6_title;?></p>
<!--สมาชิกเขต 3 -->
 <table border="0">	
		<tr>
		 <?php // สมาชิกสภาเขต 3  บล๊อกการแสดง 6
				$i=1;
				$sql="Select * From $tablename Where sid='6' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
							echo"<td valign=\"top\" align=\"center\">";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
							echo"<td align=\"center\"><img src=".$filepath ." class=\"photo_border\"><br/><br/>".$row['name']."<br/>".$row['position']."$history";
							echo"</tr>";
							echo"</table>";
							echo"</td>";
								if($i==$block5_colsno){
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