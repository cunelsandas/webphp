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
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	
	$blockno="20";
//ลบภาพ
if(isset($_GET['del'])){
		$filenameFordel=FindRS("select * from filename where id=".$_GET['del'],"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);	
		}
		$sql="DELETE From filename Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);
}

$file=array();
$size=array();
$type=array();
if(isset($_POST['btadd'])){
	$name=EscapeValue($_POST['txtname']);
	$offid=EscapeValue($_POST['type']);
	$position=EscapeValue($_POST['txtposition']);
	$sid=EscapeValue($_POST['show']);
	$nolist=EscapeValue($_POST['txtnolist']);
	$history=$_POST['mytextarea'];
	$workgroup=EscapeValue($_POST['txtworkgroup']);
  // วนรับค่าจาก control
	for ($i=0;$i<=$file_no;$i++){
		$file[$i]=$_FILES['file'.$i]['name'];
		$size[$i]=$_FILES['file'.$i]['size'];
		$type[$i]=strtolower(substr($file[$i],-4));
	}
    // วนเช็คขนาดไฟล์
	for ($i=0;$i<=$file_no;$i++){
		$x=$i+1;
	if($size[$i]>$limitsize){
		echo"<p>ไฟล์ที่ ".$x." มีขนาดใหญ่เกินกว่า". $SizeInMb." Mb</p>";
		echo"<a href=\"javascript:window.history.back();\">ย้อนกลับ</a>";
		exit();
	}
	}
	if($_POST['active']=="on"){
		$ac="1";
	}else{
		$ac="0";
	}
$sql="UPDATE $table SET name='$name',offid='$offid',status='$ac',position='$position',sid='$sid',nolist='$nolist',history='$history',workgroup='$workgroup' Where no='".EscapeValue($_GET['no'])."'";
	$rs=rsQuery($sql);
	if($rs){
		if($_POST['cboinsert']=='1'){
			$str1="update $table set nolist=nolist+1 where offid='$offid' and sid='$sid' and nolist>'$nolist'";
			$rs1=rsQuery($str1);
		}
		$sql="Select * From $table Where no='".EscapeValue($_GET['no'])."'";
		$rss=rsQuery($sql);
		$r=mysqli_fetch_assoc($rss);
		$id=$r['no'];

		$newfile=array();
		for ($i=0;$i<=$file_no;$i++){
			$tmp_date = new DateTime();
			$x = $tmp_date->format('Y-m-d_His') ;
			if($file[$i]<>""){
				$newfile[$i]=$table."_".$id."_".$x.$type[$i];
				copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
				$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$table."','".$id."','".$newfile[$i]."')";
				$uppicname=rsQuery($filename);
				}
			}

			// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('tb_officer','edit',$_SESSION['username'],'ID:'.$id);
		echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
}
$sql="Select * From $table Where no='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_assoc($rs);
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input" >
<tr>
	<td width="25%">ชื่อ - สกุล</td>
	<td width="75%"><input type="text" size="70" class="txt" name="txtname" value="<?php echo $row['name'];?>" /></td>
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
	<td><input type="text" class="txt1" name="txtworkgroup" value="<?php echo $row['workgroup'];?>"/></td>
</tr>
<tr>
<td>หน่วยงาน</td>
		<td><select class="txt" name="type">
		<?php
		$sql="Select * From tb_officertype where status>'0' Order by listno";
		$rs=rsQuery($sql);
		while($row1=mysqli_fetch_assoc($rs)){
			if($row['offid']==$row1['id']){
				echo"<option value=\"".$row1['id']."\" selected>".$row1['name']."</option>";
			}else{
				echo"<option value=\"".$row1['id']."\">".$row1['name']."</option>";
			}
		}
		?>
		</select>
		</td>
</tr>
<tr>
    <td>บล๊อกการแสดง หัวหน้ากอง/ส่วน(1) หัวหน่วยงาน (10,13,15)</td>
		<td><select class="txt" name="show"><option value="">- - - - เลือกบล๊อกการแสดง - - - -</option>
		<?php
		//$sql="Select * From tb_officer_show Order by showid";
		//$rs=rsQuery($sql);
		//while($row2=mysqli_fetch_assoc($rs)){
		//	if($row['sid']==$row2['showid']){
		//		echo"<option value=\"".$row2['showid']."\" selected>".$row2['shownumber']."</option>";
		//	}else{
		//		echo"<option value=\"".$row2['showid']."\">".$row2['shownumber']."</option>";
		//	}
		//}
		for($a=1;$a<=$blockno;$a++){
			if($row['sid']==$a){
				echo"<option value=\"".$a."\" selected>".$a."</option>";
			}else{
				echo"<option value=\"".$a."\">".$a."</option>";
			}
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
		<input type=text  class=txt1 name=txtnolist  value="<?php echo $row['nolist']?>">
	</td>
</tr>
<tr>
	<td>ประวัติการทำงาน</td>
	<td>
        <textarea name="mytextarea" id="mytextarea" > <?php echo $row['history']; ?> </textarea>

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
	<td>
	<?php 
	if($row['status']=="0"){
		?>
		<input type="checkbox" name="active" />&nbsp;Active
	<?php
	}else{
		?>
		<input type="checkbox" name="active" checked />&nbsp;Active
	<?php
	}
	?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input class="bt" type="submit" name="btadd" value="แก้ไข" /></td>
</tr>
</table>
<?php
$strpicture="Select * from filename Where tablename='".$table."' AND masterid='".$_GET['no']."' Order by id";
$rs=rsQuery($strpicture);
while($arr = mysqli_fetch_assoc($rs)){
	$fileno=substr($arr['filename'],-5,1);
	echo "<img src=..".$foldername.$arr['filename']." width='300px'>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
}
?>
</form>

<br>
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
								$td="<center><img src=".$filepath ."?".rand(1,32000)." class=\"photo_border\" width='150' ><div class='textbg'>".$name."<br/>".nl2br($position)."<br>$history<p style='color:white;'>บล็อกที่ ".$x." ลำดับที่ ".$listno."</p></div></center><br/><br/>";
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


