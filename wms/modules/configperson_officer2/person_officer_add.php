<script type="text/javascript" src="http://www.itglobal.co.th/itgmod/js01.js"></script>
<script>

function ajaxCall(select_id,displayid,tablename){
		var data="select_id="+select_id+"&tablename="+tablename;
		var URL="../itgmod/searchdata.php";
		ajaxLoad("get",URL,data,displayid);
}

	function ajaxShowTable(select_id,displayid,tablename,modid){
		var data="select_id="+select_id+"&tablename="+tablename+"&modid="+modid;
		var URL="../itgmod/searchdata.php";
		ajaxLoad("get",URL,data,displayid);
}

</script>
<?php
	$file_no=($gloOfficer_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$table=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername="/".$gloUploadPath."/".$folder."/";



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
	$workgroupid=$_POST['workgroup'];
	$subworkgroupid=$_POST['subworkgroup'];
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

$sql="INSERT INTO $table(name,offid,status,position,sid,nolist,history,workgroup	,workgroupid,subworkgroupid) Values('$name','$offid','$ac','$position','$sid','$nolist','$history','$workgroup','$workgroupid','$subworkgroupid')";
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
	<td>ตำแหน่ง</td>
    <td><textarea name="txtposition" id="type" row="2" col="40"><?php echo $row['position']?></textarea></td>    <!-- test multiple line text -->
</tr>

<tr>
<td>หน่วยงาน</td>
		<td><select class="txt" name="type" id="type" onchange="ajaxCall(this.value,'workgroup','tb_officer_workgroup');"><option value="">- - - - กรุณาเลือก - - - -</option>
		<?php
		$sql="Select * From tb_officertype where status>'0' Order by listno";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			echo"<option value=\"".$row['id']."\">".$row['name']."</option>";
		}
		?>
		</select>
		</td>
</tr>
<tr>

<td>สายงานหลัก</td>
		<td><select class="txt" name="workgroup" id="workgroup" onchange="ajaxCall(this.value,'subworkgroup','tb_officer_subworkgroup');">
		<?php
				$sql = "select * from tb_officer_workgroup order by id";
				$rsss = rsQuery($sql);
				if ($rsss) {

					while ($data = mysqli_fetch_array($rsss)) {
					if($v_workgroupid==$data['id']){
								echo '<option value='.$data['id'].' selected>'.$data['name'].'</option>';
							}else{
								echo '<option value='.$data['id'].'>'.$data['name'].'</option>';
							}


					}

				}
				?>
				</select>
		</td>
</tr>
<tr>
<td>สายงานย่อย</td>
		<td><select class="txt" name="subworkgroup" id="subworkgroup" onchange="ajaxCall(this.value,'showsubworkgroup','tb_officer_subworkgroup');">
		<?php
				$sql = "select * from tb_officer_subworkgroup order by id";
				$rsss = rsQuery($sql);
				if ($rsss) {

					while ($data = mysqli_fetch_array($rsss)) {
					if($v_workgroupid==$data['id']){
								echo '<option value='.$data['id'].' selected>'.$data['name'].'</option>';
							}else{
								echo '<option value='.$data['id'].'>'.$data['name'].'</option>';
							}


					}

				}
				?>
				</select>
		</td>
</tr>
<tr>
	<td>ชื่อกลุ่มงาน</td>
	<td><input type="text" class="txt1" name="txtworkgroup" /></td>
</tr>
<tr>
	<td>บล๊อกการแสดง หัวหน้ากอง/ส่วน(1)</td>
		<td><select class="txt" name="show"><option value="">- - - - กรุณาเลือกบล็อกการแสดง - - - -</option>
		<?php
		$sql="Select * From tb_officer_show Order by showid";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			if($ruser['showid']==$row['showid']){
				echo"<option value=\"".$row['showid']."\" selected>".$row['shownumber']."</option>";
			}else{
				echo"<option value=\"".$row['showid']."\">".$row['shownumber']."</option>";
			}
		}
		?>
		</select>
		</td>
</tr>
<tr>
	<td>ลำดับการแสดง</td>
	<td><input type=text  class=txt1 name=txtnolist size=5></td>
</tr>
<tr>
	<td>ประวัติการทำงาน</td>
	<td><textarea name="mytextarea" id="mytextarea" style="width: 100%"></textarea>
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
