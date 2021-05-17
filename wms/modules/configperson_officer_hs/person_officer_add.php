<style>
	fieldset{
		padding:20px;
		border-radius:5px;
		margin-bottom:10px;
		
	}
	legend{
		color:black;
		background-color:#eeeeee;
		padding:5px;
		border:1px solid #fdfdff;
	}
</style>
<?php
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";

	$blockno="40";
	$v_status="";
	$v_edit="";
	$v_delete="";

$file=array();
$size=array();
$type=array();
if(isset($_POST['btadd'])){
	$name=EscapeValue($_POST['txtname']);
	$offid=EscapeValue($_POST['type']);
	$position=EscapeValue($_POST['txtposition']);
	$sid=$_POST['show'];
	$nolist=EscapeValue($_POST['txtnolist']);
	$history=$_POST['mytextarea'];
	$workgroup=EscapeValue($_POST['txtworkgroup']);
   // วนรับค่าจาก control
	for ($i=0;$i<=$file_no;$i++){
		$file[$i]=$_FILES['file'.$i]['name'];
		$size[$i]=$_FILES['file'.$i]['size'];
		$type[$i]=strtolower(substr($file[$i],-4));
		$images[$i]=$_FILES['file'.$i]['tmp_name'];
	}
	//วนเช็ค file type
	for ($i=0;$i<=$file_no;$i++){
		$x=$i+1;
		$strCheckFile=CheckFileUpload($file[$i],$size[$i],$limitsize,$SizeInMb,$x);
		if($strCheckFile[0]=="no"){
			echo $strCheckFile[1];
			exit();
		}
	}
	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}//institute=ลำดับการแสดง

$sql="INSERT INTO $table(name,offid,status,position,sid,nolist,history,workgroup) Values('$name','$offid','$ac','$position','$sid','$nolist','$history','$workgroup')";
	$rs=rsQuery($sql);
	if($rs){
		$sql="Select * From $table Order by no DESC limit 0,1";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];
		// loop insert ชื่อไฟล์และcopy ไฟล์
		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$tmp_date = new DateTime();
			$x = $tmp_date->format('Y-m-d_His') ;
			if($file[$i]<>""){
				$newfile[$i]=$table.'_'.$id."_".$x.$type[$i];
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
			}
		}

		if($_POST['cboinsert']=='1'){
			$str1="update $table set nolist=nolist+1 where offid='$offid' and sid='$sid' and nolist>'$nolist'";
			$rs1=rsQuery($str1);
		}
			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_officer','add',$_SESSION['username'],'ID:'.$id.'  '.$_POST['txtname']);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
	//echo $sql;
}
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input" >
<tr>
	<td width="25%">ชื่อ - สกุล</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" /></td>
</tr>
<tr>
    <!--<td>ตำแหน่ง</td>-->
    <!--		<td><input type="text"  size="60" name="type" id="type" value="--><?php //echo $row['position'];?><!--"  /></td>-->
    <td>ตำแหน่ง</td>
    <!--	<td><input type="text" name="txtposition" class="txt1" value="--><?php //echo $row['position']?><!--"></td>-->
    <td><textarea name="txtposition" id="type" row="2" col="40"><?php echo $row['position']?></textarea></td>    <!-- test multiple line text -->
</tr>
<tr>
	<td>กลุ่มงาน</td>
	<td><input type="text" class="txt1" name="txtworkgroup" /></td>
</tr>
<tr>
<td>หน่วยงาน</td>
		<td><select class="txt" name="type"><option value="">- - - - กรุณาเลือก - - - -</option>
		<?php
		$sql="Select * From tb_officertype where status>'0' Order by listno";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			if($ruser['oid']==$row['id']){
				echo"<option value=\"".$row['id']."\" selected>".$row['name']."</option>";
			}else{
				echo"<option value=\"".$row['id']."\">".$row['name']."</option>";
			}
		}
		?>
		</select>
		</td>
</tr>
<tr>
	<td>บล๊อกการแสดง หัวหน้ากอง/ส่วน(1)</td>
		<td><select class="txt" name="show"><option value="">- - - - กรุณาเลือกบล็อกการแสดง - - - -</option>
		<?php
		//$sql="Select * From tb_officer_show Order by showid";
		//$rs=rsQuery($sql);
		//while($row=mysqli_fetch_assoc($rs)){
		for($a=1;$a<=$blockno;$a++){
			echo"<option value=\"".$a."\">".$a."</option>";	
		}
		?>
		</select>
		</td>
</tr>
<tr>
	<td>ลำดับการแสดง</td>
	<td>
		<select name='cboinsert'>
			<option value='0'>เพิ่ม</option>
			<option value='1'>แทรกแทนลำดับที่</option>
		</select>
		<input type='text'  class='txt1' name='txtnolist' size='5'></td>
</tr>
<tr>
	<td>ประวัติการทำงาน</td>
	<td><textarea name="mytextarea" id="mytextarea" > </textarea>
	</td>
</tr>
<tr>
	<td valign="top">ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb;?> Mb</td>
	<td><?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
		}
	?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="checkbox" name="active" />&nbsp;Active</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="เพิ่ม" /></td>
</tr>
</table>
</form>
<br>
<form name='frmshow' action='' method='post' class='content-input'>
	<select name='cboFindDep' onchange='this.form.submit()'>
		<option value='0'>เลือกโครงสร้างหน่วยงาน</option>
		<?php
			$sql="Select * From tb_officertype where status>'0' Order by listno";
			$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			echo"<option value=\"".$row['id']."\">".$row['name']."</option>";
		}
		?>
	</select>


<?php
	
	

//	if(isset($_POST['cboFindDep'])){
		
		$depid=$_POST['cboFindDep'];
	if($depid>0){
		$depname=FindRS("select * from tb_officertype where id='".$depid."'","name");
		echo "<center><p style='padding:5px;background-color:white;margin-top:10px;margin-bottom:10px;'>".$depname."</p></center>";
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
		for($x = 1; $x <= $blockno; $x++) {
			echo "<fieldset>";
			echo "<legend>บล็อกที่ $x</legend>";
			echo "<table border=\"0\"  align=\"center\" width=\"100%\">";
			echo	"<tr>";
			// พนักงานเจ้าหน้าที่  บล๊อกการแสดง $x
				$i=1;
				$sqlFind="Select * From $table Where offid='".$depid."' And sid='".$x."' order by nolist";
				$rs=rsQuery($sqlFind);
				
				if($rs){
						while($row2=mysqli_fetch_assoc($rs)){
							//if($row2['status']=="0"){
							//	$v_status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=1&no=".$row2['no']."\"><img src=\"../images/component/01.png\" border=\"0\" title='สถานะ inactive'/></a>";
							//}else{
							//	$v_status="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=0&no=".$row2['no']."\"><img src=\"../images/component/02.png\" border=\"0\" title='สถานะ active' /></a>";
							//}
							//$v_edit="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$row2['no']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" title='แก้ไขข้อมูล'/></a>";
							//$v_delete="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$row2['no']."\" onclick=\"return confirm('คุณต้องการลบหรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\" title='ลบข้อมูล'/></a>";
			
							//$filepath=SearchImage($tablename,$row2['no'],$foldername,"0");
							$filename=FindRS("select * from filename where tablename='".$table."' and masterid='".$row2['no']."'","filename");
							$filepath="..".$foldername.$filename;
							$listno=$row2['nolist'];
							if($row2['history']==null || $row2['history']=="" || empty($row2['history'])){
									$history="";

							}else{
									$history= "<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row2['no'])."&tb=".encode64('tb_officer')."&p=".encode64('officer')."');\"><img src=\"../images/document_icon.png\"></a>";
							}

							if($row2['position']=="blank"){
								$position="";
							}else{
								$position=$row2['position'];
							}
							if($row2['name']=="blank"){
								$name="";
								$td="<span width='100%'>&nbsp;&nbsp;</span>";
							}else{
								$name=$row2['name'];
								$td="<center><img src=".$filepath ."?".rand(1,32000)." class=\"photo_border\" width='150' ><div class='textbg'>".$name."<br/>".nl2br($position)."<br>$history<p style='color:white;'>บล็อกที่ ".$x." ลำดับที่ ".$listno."</p><p>$v_status &nbsp; $v_edit &nbsp; $v_delete</p></div></center><br/><br/>";
							}

							echo"<td valign=\"top\" align=\"".$align[$x]."\" width='33%'>";
						//	echo"<table height=\"100%\" border=\"0\">";
						//	echo"<tr>";
						//	echo "<td>";
							echo $td;
					//		echo"</td></tr>";
					//		echo"</table>";
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
			echo "</fieldset>";
		}
	}
	

?>
</form>