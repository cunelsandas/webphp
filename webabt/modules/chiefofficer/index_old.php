		
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="10" background="images/g1.jpg">&nbsp;</td>
          <td background="images/g2.jpg">
		  <img src="images/head_11.jpg" width="167" height="26">
		
		<!--<img src="images/head_<%=request("ID")%>.jpg" width="167" height="26">--></td>
          <td width="10"><img src="images/g3.jpg" width="10" height="26"></td>
        </tr>
        <tr>
          <td width="10" background="images/g4.jpg">&nbsp;</td>
          <td valign="top">
		  
 <table align="center" >
<tr>

		<td>
		<table width="210" border="0" cellpadding="0" cellspacing="0">
              <tr> <!-- หัวของกรอบ-->
                <td width="20"><img src="images/cor01.jpg" width="20" height="6"></td>
                <td background="images/cor02.jpg"><img src="images/cor02.jpg" width="20" height="6"></td>
                <td width="20"><img src="images/cor03.jpg" width="20" height="6"></td>
              </tr>
              <tr> 
			  <?php  // หัวหน้า
				$sqlhead="Select * From tb_goverment Where  sid='1' And status='1'";
				//$sql="Select * From tb_officer Where offid='".$_GET['ID']."'";
				$rshead=rsQuery($sqlhead);
				$arr=mysql_fetch_array($rshead)
			?>
                <td background="images/cor07.jpg">&nbsp;</td><!-- ด้านซ้ายของขอบ-->
				<td width="200" align="center"><img src="images/goverment/<?php echo "".$arr['no']."-1.JPG";?>" width="135" height="165"><br><br><font  color="#0033FF"><?php echo $arr['name'];?><br><?php echo $arr['position'];?></font></td>
				<td background="images/cor08.jpg">&nbsp;</td><!--ด้านขวาของขอบ-->
              </tr>
              <tr> <!--ด้านล่างของกรอบ-->
                <td><img src="images/cor05.jpg" width="20" height="6"></td>
                <td background="images/cor06.jpg"><img src="images/cor06.jpg" width="20" height="6"></td>
                <td><img src="images/cor04.jpg" width="20" height="6"></td>
              </tr>
            </table>
		</td>
		<tr><td height="20">&nbsp;</td></tr>
		
	<table border="0">
	<tr>
		<td>
		<table border="0" align="center">
		
		<tr align=center width="100%">
		  <?php  // รอง
				$sqlhead="Select * From tb_goverment Where  sid='2' And status='1'";
				//$sql="Select * From tb_officer Where offid='".$_GET['ID']."'";
				$rshead=rsQuery($sqlhead);
				$arr=mysql_fetch_array($rshead)
			?>
			<td align="Center">
				<table style="margin:10px; class=tbl-border border=0">
					<tr>
						<td align="center"><img src="images/goverment/<?php echo "".$arr['no']."-1.JPG";?>" width="135" height="165"><br><br><font  color="#0033FF"><?php echo $arr['name'];?><br><?php echo $arr['position'];?></font>
						</td>
					</tr>
				</table>
			</td>
		
	<!--	 <?php // พนักงานเจ้าหน้าที่ แถว2 รองปลัด
	$i=1;
	$sql="Select * From tb_goverment Where sid='2' And status='1'";
	$rs=rsQuery($sql);
	if(mysql_num_rows($rs)>0){
		while($row=mysql_fetch_array($rs)){
			echo"<td align=\"center\">";
			echo"<table style=\"margin:10px;\" class=\"tbl-border\" border=\"0\">";
				echo"<tr>";
					echo"<td align=\"center\"><img src=\"images/goverment/".$row['no']."-1.JPG\" width=\"135\" height=\"165\"><br/><br/><font color=\"#FF6600\">".$row['name']."<br/>".$row['position']."</font>";
				echo"</tr>";
			echo"</table>";
			echo"</td>";
			if($i==3){
				echo"</tr></tr>";
				$i=0;
			}
			$i++;
		}
	}
	?>-->

	
	</tr>
	</table>

	</td>
	</tr>
	
<tr>
<td>
	<table border="0">	
		<tr>
		 <?php // พนักงานเจ้าหน้าที่
	$i=1;
	$sql="Select * From tb_goverment Where sid='3' And status='1' Order by no" ;
	$rs=rsQuery($sql);
	if(mysql_num_rows($rs)>0){
		while($row=mysql_fetch_array($rs)){
			echo"<td>";
			echo"<table style=\"margin:10px;\" class=\"tbl-border\" border=\"0\">";
				echo"<tr>";
					echo"<td align=\"center\"><img src=\"images/goverment/".$row['no']."-1.JPG\" width=\"135\" height=\"165\"><br/><br/><font color=\"#FF6600\">".$row['name']."<br/>".$row['position']."</font>";
				echo"</tr>";
			echo"</table>";
			echo"</td>";
			if($i==3){
				echo"</tr></tr>";
				$i=0;
			}
			$i++;
		}
	}
	?>
	</tr>
	</table>
	</td>
	</tr>
		
		<!--  วนลูปแสดงรูป -->
		<td>
		<table width="180" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" border="1"></td>
			</tr>
			<tr>
				<td align="center"></td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
			</tr>
         </table>
	</td>
		</tr>
		</table>
		

		  </td>
          <td background="images/g9.jpg">&nbsp;</td>
        </tr>
        <tr>
          <td><img src="images/g6.jpg" width="10" height="13"></td>
          <td background="images/g7.jpg"><img src="images/g7.jpg" width="1" height="13"></td>
          <td><img src="images/g8.jpg" width="10" height="13"></td>
        </tr>
      </table>
      
    </td>

  </tr>
</table>