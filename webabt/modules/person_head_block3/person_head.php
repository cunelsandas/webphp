<?php

//แก้ tablename , foldername ตอนแรกใช้ tb_header กับ $mod มันไม่ได้นะ ต้องใช้ตัวแปรสิจ๊ะ  18/6/63

	$mod=EscapeValue(decode64($_GET['_mod']));
	$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
	$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
	$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
	$foldername=$gloUploadPath."/".$folder."/";
	if($device=="Mobile"){
		$block1_colsno="1";
		$block2_colsno="1";
		$block3_colsno="1";
		$block4_colsno="4";
        $block5_colsno="4";
        $block6_colsno="4";
        $block7_colsno="4";
        $block8_colsno="4";
        $block9_colsno="4";
        $block10_colsno="4";
        $block11_colsno="4";
        $block12_colsno="4";
	}else{
		$block1_colsno="1";
		$block2_colsno="3";
		$block3_colsno="3";
		$block4_colsno="3";
        $block5_colsno="3";
        $block6_colsno="3";
        $block7_colsno="3";
        $block8_colsno="3";
        $block9_colsno="3";
        $block10_colsno="3";
        $block11_colsno="3";
        $block12_colsno="3";
	}
	?>
<script type="text/javascript">
   function open_new_window(URL)
   {
   NewWindow = window.open(URL,"_blank","toolbar=no,menubar=0,status=0,copyhistory=0,scrollbars=yes,resizable=1,location=0,Width=600,Height=600") ;
   NewWindow.location = URL;
   }
 </script>
<div id="person_head">
<br>
<span class="banner_title"><?php echo $modname;?></span>
<center>
<br><br>
<table border="0" width="90%">
		<tr>
		 <?php // พนักงานเจ้าหน้าที่  บล๊อกการแสดง 1
				$i=1;
				$sql="Select * From $tablename Where sid='1' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							$history=!empty($row['history'])?"<div class=\"tooltip\"><img src=\"images/document_icon.png\"><span>".$row['history']."</span></div>":"";
							if($row['history'] == ""){
                                $history="";
							}else{
                                $history= "<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"../images/document_icon.png\"></a>";
							}
							echo"<td valign=\"top\" align=\"center\">";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
                            echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."<br/>".$row['position2']."</div>$history";  //position2ดึงมาจาก db เฉยๆเน้อ
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
		 <?php //block2
				$i=1;
				$sql="Select * From $tablename Where sid='2' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							if(strlen($row['history'])<10 Or $row['hostory']==""){
                                //$history="";
                                $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
							}else{
								$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
							}
							echo"<td valign=\"top\" align=\"center\">";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
                            echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."<br/>".$row['position2']."</div>$history";
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
<!-- block3 -->
<table border="0" width="90%" align="center">
		<tr>
		 <?php // เลขาหรือที่ปรึกษา  บล๊อกการแสดง 3
				$i=1;
				$sql="Select * From $tablename Where sid='3' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							if(strlen($row['history'])<10 Or $row['hostory']==""){
                                //$history="";
                                $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
							}else{
								$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
							}
							echo"<td valign=\"top\" align=\"center\" width='33%'>";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
							echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."<br/>".$row['position2']."</div>$history";
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
<!-- bolock4 -->
 <table border="0" width="90%" align="center">
		<tr>
		 <?php // ที่ปรึกษา  บล๊อกการแสดง 4
				$i=1;
				$sql="Select * From $tablename Where sid='4' And status='1' order by nolist";
				$rs=rsQuery($sql);
				if($rs){
						while($row=mysqli_fetch_assoc($rs)){
							$filepath=SearchImage($tablename,$row['no'],$foldername,"0");
							if(strlen($row['history'])<10 Or $row['hostory']==""){
                                //$history="";
                                $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
							}else{
								$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
							}
							echo"<td valign=\"top\" align=\"center\" width='33%'>";
							echo"<table height=\"100%\" border=\"0\">";
							echo"<tr>";
                            echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."<br/>".$row['position2']."</div>$history";
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
    <!-- bolock5 -->
    <table border="0" width="90%" align="center">
        <tr>
            <?php // ที่ปรึกษา  บล๊อกการแสดง 5
            $i=1;
            $sql="Select * From $tablename Where sid='5' And status='1' order by nolist";
            $rs=rsQuery($sql);
            if($rs){
                while($row=mysqli_fetch_assoc($rs)){
                    $filepath=SearchImage($tablename,$row['no'],$foldername,"0");
                    if(strlen($row['history'])<10 Or $row['hostory']==""){
                        //$history="";
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
                    }else{
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
                    }
                    echo"<td valign=\"top\" align=\"center\" width='33%'>";
                    echo"<table height=\"100%\" border=\"0\">";
                    echo"<tr>";
                    echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."<br/>".$row['position2']."</div>$history";
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
    <!-- bolock6 -->
    <table border="0" width="90%" align="center">
        <tr>
            <?php // ที่ปรึกษา  บล๊อกการแสดง 6
            $i=1;
            $sql="Select * From $tablename Where sid='6' And status='1' order by nolist";
            $rs=rsQuery($sql);
            if($rs){
                while($row=mysqli_fetch_assoc($rs)){
                    $filepath=SearchImage($tablename,$row['no'],$foldername,"0");
                    if(strlen($row['history'])<10 Or $row['hostory']==""){
                        //$history="";
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
                    }else{
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
                    }
                    echo"<td valign=\"top\" align=\"center\" width='33%'>";
                    echo"<table height=\"100%\" border=\"0\">";
                    echo"<tr>";
                    echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."</div>$history";
                    echo"</tr>";
                    echo"</table>";
                    echo"</td>";
                    if($i==$block6_colsno){
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
    <!-- bolock7 -->
    <table border="0" width="90%" align="center">
        <tr>
            <?php // ที่ปรึกษา  บล๊อกการแสดง 7
            $i=1;
            $sql="Select * From $tablename Where sid='7' And status='1' order by nolist";
            $rs=rsQuery($sql);
            if($rs){
                while($row=mysqli_fetch_assoc($rs)){
                    $filepath=SearchImage($tablename,$row['no'],$foldername,"0");
                    if(strlen($row['history'])<10 Or $row['hostory']==""){
                        //$history="";
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
                    }else{
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
                    }
                    echo"<td valign=\"top\" align=\"center\" width='33%'>";
                    echo"<table height=\"100%\" border=\"0\">";
                    echo"<tr>";
                    echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."</div>$history";
                    echo"</tr>";
                    echo"</table>";
                    echo"</td>";
                    if($i==$block7_colsno){
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
    <!-- bolock8 -->
    <table border="0" width="90%" align="center">
        <tr>
            <?php // ที่ปรึกษา  บล๊อกการแสดง 8
            $i=1;
            $sql="Select * From $tablename Where sid='8' And status='1' order by nolist";
            $rs=rsQuery($sql);
            if($rs){
                while($row=mysqli_fetch_assoc($rs)){
                    $filepath=SearchImage($tablename,$row['no'],$foldername,"0");
                    if(strlen($row['history'])<10 Or $row['hostory']==""){
                        //$history="";
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
                    }else{
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
                    }
                    echo"<td valign=\"top\" align=\"center\" width='33%'>";
                    echo"<table height=\"100%\" border=\"0\">";
                    echo"<tr>";
                    echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."</div>$history";
                    echo"</tr>";
                    echo"</table>";
                    echo"</td>";
                    if($i==$block8_colsno){
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
    <!-- bolock9 -->
    <table border="0" width="90%" align="center">
        <tr>
            <?php // ที่ปรึกษา  บล๊อกการแสดง 9
            $i=1;
            $sql="Select * From $tablename Where sid='9' And status='1' order by nolist";
            $rs=rsQuery($sql);
            if($rs){
                while($row=mysqli_fetch_assoc($rs)){
                    $filepath=SearchImage($tablename,$row['no'],$foldername,"0");
                    if(strlen($row['history'])<10 Or $row['hostory']==""){
                        //$history="";
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
                    }else{
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
                    }
                    echo"<td valign=\"top\" align=\"center\" width='33%'>";
                    echo"<table height=\"100%\" border=\"0\">";
                    echo"<tr>";
                    echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."</div>$history";
                    echo"</tr>";
                    echo"</table>";
                    echo"</td>";
                    if($i==$block9_colsno){
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
    <!-- bolock10 -->
    <table border="0" width="90%" align="center">
        <tr>
            <?php // ที่ปรึกษา  บล๊อกการแสดง 10
            $i=1;
            $sql="Select * From $tablename Where sid='10' And status='1' order by nolist";
            $rs=rsQuery($sql);
            if($rs){
                while($row=mysqli_fetch_assoc($rs)){
                    $filepath=SearchImage($tablename,$row['no'],$foldername,"0");
                    if(strlen($row['history'])<10 Or $row['hostory']==""){
                        //$history="";
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
                    }else{
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
                    }
                    echo"<td valign=\"top\" align=\"center\" width='33%'>";
                    echo"<table height=\"100%\" border=\"0\">";
                    echo"<tr>";
                    echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."</div>$history";
                    echo"</tr>";
                    echo"</table>";
                    echo"</td>";
                    if($i==$block10_colsno){
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
    <!-- bolock11 -->
    <table border="0" width="90%" align="center">
        <tr>
            <?php // ที่ปรึกษา  บล๊อกการแสดง 11
            $i=1;
            $sql="Select * From $tablename Where sid='11' And status='1' order by nolist";
            $rs=rsQuery($sql);
            if($rs){
                while($row=mysqli_fetch_assoc($rs)){
                    $filepath=SearchImage($tablename,$row['no'],$foldername,"0");
                    if(strlen($row['history'])<10 Or $row['hostory']==""){
                        //$history="";
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
                    }else{
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
                    }
                    echo"<td valign=\"top\" align=\"center\" width='33%'>";
                    echo"<table height=\"100%\" border=\"0\">";
                    echo"<tr>";
                    echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."</div>$history";
                    echo"</tr>";
                    echo"</table>";
                    echo"</td>";
                    if($i==$block11_colsno){
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
    <!-- bolock12 -->
    <table border="0" width="90%" align="center">
        <tr>
            <?php // ที่ปรึกษา  บล๊อกการแสดง 12
            $i=1;
            $sql="Select * From $tablename Where sid='12' And status='1' order by nolist";
            $rs=rsQuery($sql);
            if($rs){
                while($row=mysqli_fetch_assoc($rs)){
                    $filepath=SearchImage($tablename,$row['no'],$foldername,"0");
                    if(strlen($row['history'])<10 Or $row['hostory']==""){
                        //$history="";
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";   //ปิด popup
                    }else{
                        $history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64($tablename)."&p=".encode64($folder)."');\"><img src=\"images/document_icon.png\"></a>":"";
                    }
                    echo"<td valign=\"top\" align=\"center\" width='33%'>";
                    echo"<table height=\"100%\" border=\"0\">";
                    echo"<tr>";
                    echo"<td align=\"center\"><img src=".$filepath ."?ver=".rand(1,32000)." class=\"photo_border\"><div class='textbg'>".$row['name']."<br/>".nl2br($row['position'])."</div>$history";
                    echo"</tr>";
                    echo"</table>";
                    echo"</td>";
                    if($i==$block12_colsno){
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

