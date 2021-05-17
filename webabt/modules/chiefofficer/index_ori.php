<?php
	$foldername="fileupload/goverment/";
?>
<div id="chiefofficer">
<center>
<br><br><BR><BR><BR>
<!-- ปลัด-->
 <table align="center" >
<tr>
		<td>
		<table width="210" border="0" cellpadding="0" cellspacing="0" bgcolor=#FFFFFF>
              <tr> <!-- หัวของกรอบ-->
                <td width="20"><img src="images/component/cor01.jpg" width="20" height="6"></td>
                <td background="images/component/cor02.jpg"><img src="images/component/cor02.jpg" width="20" height="6"></td>
                <td width="20"><img src="images/component/cor03.jpg" width="20" height="6"></td>
              </tr>
              <tr> 
			  <?php  // หัวหน้า
				$sqlhead="Select * From tb_goverment Where  sid='1' And status='1' Order by nolist";
				//$sql="Select * From tb_officer Where offid='".$_GET['ID']."'";
				$rshead=rsQuery($sqlhead);
				$arr=mysql_fetch_array($rshead);
				$filename=SearchFileName("tb_goverment",$arr['no']);
				if($filename!="ไม่พบเอกสาร"){
					$pic=$filename;
				}else{
					$pic=$arr['no']."-1.JPG";
				}
				$history=!empty($arr['history'])?"<div class=\"tooltip\"><img src=\"images/document_icon.png\"><span>".$arr['history']."</span></div>":"";
			?>
                <td background="images/component/cor07.jpg">&nbsp;</td><!-- ด้านซ้ายของขอบ-->
				<td width="200" align="center"><img src="<?php echo $foldername.$pic;?>" width="135" height="165"><br><br><font  size=2 color="#0033FF"><?php echo $arr['name'];?><br><?php echo $arr['position'];?></font><?php echo $history;?></td>
				<td background="images/component/cor08.jpg">&nbsp;</td><!--ด้านขวาของขอบ-->
              </tr>
              <tr> <!--ด้านล่างของกรอบ-->
                <td><img src="images/component/cor05.jpg" width="20" height="6"></td>
                <td background="images/component/cor06.jpg"><img src="images/component/cor06.jpg" width="20" height="6"></td>
                <td><img src="images/component/cor04.jpg" width="20" height="6"></td>
              </tr>
            </table>

		</td>
	</tr>
	</table>
		<!--<tr><td height="20">&nbsp;</td></tr>-->

 <table align="center" >
<tr>
		<td>
		<table width="210" border="0" cellpadding="0" cellspacing="0" bgcolor=#FFFFFF>
              <tr> <!-- หัวของกรอบ -->
                <td width="20"><img src="images/component/cor01.jpg" width="20" height="6"></td>
                <td background="images/component/cor02.jpg"><img src="images/component/cor02.jpg" width="20" height="6"></td>
                <td width="20"><img src="images/component/cor03.jpg" width="20" height="6"></td>
              </tr>
              <tr> 
			  <?php  // รองปลัด
				$sqlhead="Select * From tb_goverment Where  sid='2' And status='1' Order by nolist";
				//$sql="Select * From tb_officer Where offid='".$_GET['ID']."'";
				$rshead=rsQuery($sqlhead);
				$arr=mysql_fetch_array($rshead);
				$filename=SearchFileName("tb_goverment",$arr['no']);
				if($filename!="ไม่พบเอกสาร"){
					$pic=$filename;
				}else{
					$pic=$arr['no']."-1.JPG";
				}
				$history=!empty($arr['history'])?"<div class=\"tooltip\"><img src=\"images/document_icon.png\"><span>".$arr['history']."</span></div>":"";
			?>
                <td background="images/component/cor07.jpg">&nbsp;</td><!-- ด้านซ้ายของขอบ-->
				<td width="200" align="center"><img src="<?php echo $foldername.$pic;?>" width="135" height="165"><br><br><font  size=2 color="#0033FF"><?php echo $arr['name'];?><br><?php echo $arr['position'];?></font><?php echo $history;?></td>
				<td background="images/component/cor08.jpg">&nbsp;</td><!--ด้านขวาของขอบ-->
           </tr>
              <tr> <!--ด้านล่างของกรอบ-->
                <td><img src="images/component/cor05.jpg" width="20" height="6"></td>
                <td background="images/component/cor06.jpg"><img src="images/component/cor06.jpg" width="20" height="6"></td>
                <td><img src="images/component/cor04.jpg" width="20" height="6"></td>
              </tr>
            </table>

		</td>
	</tr>
	</table>

 <table align="center" >
<tr>

		<?php  // หัวหน้าส่วนต่างๆ
				$sqlhead="Select * From tb_goverment Where  sid='3' And status='1' Order by nolist";
				//$sql="Select * From tb_officer Where offid='".$_GET['ID']."'";
				$rshead=rsQuery($sqlhead);
				$x=1;
				if(mysql_num_rows($rshead)>0){
					while($arr=mysql_fetch_array($rshead)){
				$filename=SearchFileName("tb_goverment",$arr['no']);
				if($filename!="ไม่พบเอกสาร"){
					$pic=$filename;
				}else{
					$pic=$arr['no']."-1.JPG";
				}
				$history=!empty($arr['history'])?"<div class=\"tooltip\"><img src=\"images/document_icon.png\"><span>".$arr['history']."</span></div>":"";
			?>
				<td>
				<table width="210" border="0" cellpadding="0" cellspacing="0" bgcolor=#FFFFFF>
				<tr> <!-- หัวของกรอบ-->
                <td width="20"><img src="images/component/cor01.jpg" width="20" height="6"></td>
                <td background="images/component/cor02.jpg"><img src="images/component/cor02.jpg" width="20" height="6"></td>
                <td width="20"><img src="images/component/cor03.jpg" width="20" height="6"></td>
              </tr>
              <tr> 
                <td background="images/component/cor07.jpg">&nbsp;</td><!-- ด้านซ้ายของขอบ-->
				<td width="200" align="center"><img src="<?php echo $foldername.$pic;?>" width="135" height="165"><br><br><font  size=2 color="#0033FF"><?php echo $arr['name'];?><br><?php echo $arr['position'];?></font><?php echo $history;?></td>
				<td background="images/component/cor08.jpg">&nbsp;</td><!--ด้านขวาของขอบ-->
              </tr>
              <tr> <!--ด้านล่างของกรอบ-->
                <td><img src="images/component/cor05.jpg" width="20" height="6"></td>
                <td background="images/component/cor06.jpg"><img src="images/component/cor06.jpg" width="20" height="6"></td>
                <td><img src="images/component/cor04.jpg" width="20" height="6"></td>
              </tr>
            </table>
			</td>
			<?php
					if($x==2){
					echo "</tr><tr>";
					$x=0;
				}
				$x++;
					}
				}
				?>
	</tr>
	</table>


	
      
  </center>

  </div>