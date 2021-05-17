<?php
	$mod=EscapeValue(decode64($_GET['_mod']));
	$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
	$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
	$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
	$foldername=$gloUploadPath."/".$folder."/";

	$blockno="20";
//กำหนดจำนวนรูปต่อแถว เริ่มจาก 0
	if($device=="Mobile"){
			$block_colno=array("0",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1",
												"1");
	}else{
	$block_colno=array("0",
												"1",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3",
												"3");
	}
	//กำหนดตำแหน่งรูป left,center,right เริ่มจาก 0
	$align=array("center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center",
								"center");


			$id=EscapeValue(decode64($_GET['type']));
			$sql="Select * From tb_publictype Where id='".$id."'";
			$rs=rsQuery($sql);
			$row=mysqli_fetch_assoc($rs);
			$detail=$row['detail'];
			$depname=$row['name'];

		?>
<script type="text/javascript">
   function open_new_window(URL)
   {
   NewWindow = window.open(URL,"_blank","toolbar=no,menubar=0,status=0,copyhistory=0,scrollbars=yes,resizable=1,location=0,Width=600,Height=600") ;
   NewWindow.location = URL;
   }
 </script>

<div id="person_public">
<br><br>
<span class="banner_title"><?php echo "โครงสร้างผู้นำชุมชน ".$depname;?></span><br><br>

<br><br>
<center>



<?php

	for($x = 1; $x <= $blockno; $x++) {
		echo "<table border=\"0\"  align=\"center\" width=\"95%\">";
		echo	"<tr>";
		 // พนักงานเจ้าหน้าที่  บล๊อกการแสดง $x
				$i=1;
				$sql="Select * From $tablename Where offid='".$id."' And sid='".$x."' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							//$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_officer')."&p=".encode64('officer')."');\"><img src=\"images/document_icon.png\"></a>":"";
							if($row['position']=="blank"){
								$position="";
							}else{
								$position=$row['position'];
							}
							if($row['name']=="blank"){
								$name="";
								$td="<span width='200'></span>";
							}else{
								$name=$row['name'];
								$td="<center><img src=".$filepath ."?".rand(1,32000)." class=\"photo_border\"><div class='textbg'><br/>".$name."<br/>".nl2br($position)."</div></center><br/><br/>";
							}

							echo"<td valign=\"top\" align=\"".$align[$x]."\" width='30%'>";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
							echo "<td>";
							echo $td;
							echo"</td></tr>";
							echo"</table>";
							echo"</td>";
								if($i==$block_colno[$x]){
									echo"</tr><tr>";
									$i=0;
								}
							$i++;
						}
				}

	echo "</tr>";
	echo "</table>";
}
?>
</center>
</div>
