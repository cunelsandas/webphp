<?php
	
	$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
	$folder=FindRS("select foldername from tb_mod where modid=$modid","foldername");
	$foldername=$gloUploadPath.$folder."/";
	$point_no="5";
	$file_no=($gloNews_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$content="";
	
?>

<script language="javascript">
// Start XmlHttp Object
function uzXmlHttp(){
    var xmlhttp = false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            xmlhttp = false;
        }
    }
 
    if(!xmlhttp && document.createElement){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
// End XmlHttp Object

function data_show(select_id,result){
	var url = '../lib/data.php?select_id='+select_id+'&result='+result;
	//alert(url);
	
    xmlhttp = uzXmlHttp();
    xmlhttp.open("GET", url, false);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
    xmlhttp.send(null);
	document.getElementById(result).innerHTML =  xmlhttp.responseText;
}
//window.onLoad=data_show(5,'amphur'); 
</script>

<script language="JavaScript" type="text/javascript">
function Chkfrm()
         {
				var obj0 = document.form_fifa.txtsubject;
                var obj1 = document.form_fifa.txtname;
				var obj2 = document.form_fifa.txttel;
				var obj3 = document.form_fifa.txtadd_address;
				var obj4 = document.form_fifa.txtadd_province;
				var obj5 = document.form_fifa.txtadd_amphur;
				var obj6 = document.form_fifa.txtadd_tambol;
				var obj7 = document.form_fifa.txtmoo;
				
		if (obj0.value.length==0)
		{
			alert('กรุณาป้อนชื่อเรื่องที่ต้องการแจ้งปัญหา');
			obj0.focus();
			return false;
		}	
		else if (obj1.value.length==0)   {
           alert('กรุณากรอกชื่อและนามสกุลของผู้แจ้งด้วยคะ');
           obj1.focus();
           return false;
        } else if (obj2.value.length==0)  {
           alert('กรุณากรอกหมายเลขโทรศัพท์สำหรับติดต่อด้วยคะ');
		    obj2.focus();
           return false;

		} else if (obj3.value.length==0){
			 alert('กรุณาป้อมที่อยู่ของผู้แจ้งด้วยค่ะ');
			obj3.focus();
			return false;
		} else if (obj4.value.length==0){
			alert('กรุณาเลือกจังหวัดของคุณด้วยค่ะ');
			obj4.focus();
			return false;
		} else if (obj5.length==0){
			alert('กรุณาเลือกอำเภอด้วยค่ะ');
			obj5.focus();
			return false;
		}else if (obj6.length==0){
			alert('กรุณาเลือกตำบลก่อนค่ะ');
			obj6.focus();
			return false;
		}else if (obj7.value.length==0){
			alert('กรุณาเลือกประเภทคำร้องก่อนค่ะ');
			obj7.focus();
			return false;
		}else if(obj8.value==0){
			alert('คุณป้อนรายละเอียดก่อนค่ะ');
			obj8.focus();
			return false;
		
		}else{
			return true;
		}
	
}
</script>
<?php
	
	if($_POST['btadd']){
		$date=date('Y-m-d');
		$date_create=date('Y-m-d H:i:s');
		$name=EscapeValue($_POST['txtname']);
		$tel=EscapeValue($_POST['txttel']);
		$email=EscapeValue($_POST['txtemail']);
		$add_address=$_POST['txtadd_address'];
		$add_moo=$_POST['txtadd_moo'];
		$add_tambol=$_POST['txtadd_tambol'];
		$add_amphur=$_POST['txtadd_amphur'];
		$add_province=$_POST['txtadd_province'];
		$type=$_POST['txttype'];
		$remark=EscapeValue($_POST['txtremark']);
		$post_ip=$_SERVER['REMOTE_ADDR'];
		$status=$_POST['cbostatus'];
		$subject=EscapeValue($_POST['txtsubject']);
		$result=EscapeValue($_POST['txtresult']);
		$light=EscapeValue($_POST['cbolight']);
		$lightno=$_POST['cbolightno'];
		$starter=$_POST['cbostarter'];
		$ballard=$_POST['cboballard'];
		$lamp=$_POST['cbolamp'];
		$wired=EscapeValue($_POST['txtwired']);
		$other=EscapeValue($_POST['txtother']);
		$detail=EscapeValue($_POST['txtdetail']);
	
		$file=array();
		$size=array();
		$type=array();
		$images=array();
		 // วนรับค่าจาก control
		for ($i=0;$i<=$file_no;$i++){
			$file[$i]=$_FILES['file'.$i]['name'];
			$size[$i]=$_FILES['file'.$i]['size'];
			$type[$i]=strtolower(substr($file[$i],-4));
			$images[$i]=$_FILES['file'.$i]['tmp_name'];
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

		$stradd="insert into $tablename(date,datecreate,name,telephone,email,add_address,add_moo,add_tambol,add_amphur,add_province,subject,type,detail,remark,post_ip,status,active,result,datefinish,light,lightno,starter,ballard,lamp,wired,other) values('$date','$date_create','$name','$tel','$email','$add_address','$add_moo','$add_tambol','$add_amphur','$add_province','$subject','$type','$detail','$remark','$post_ip','$status','$ac','$result','0000-00-00','$light','$lightno','$starter','$ballard','$lamp','$wired','$other')";
		$rs=rsQuery($stradd);
		if($rs){
			$sql="Select * From $tablename Order by no DESC limit 0,1";
			$rss=rsQuery($sql);
			$r=mysqli_fetch_assoc($rss);
			$id=$r['no'];
			// loop insert ชื่อไฟล์และcopy ไฟล์
			$newfile=array();
			for ($i=0;$i<=$file_no;$i++){
				$x=$i+1;
				if($file[$i]<>""){
					$newfile[$i]='bf_'.$tablename.'_'.$id."_".$x.$type[$i];
					if($type[$i]==".pdf"){
						copy($_FILES['file'.$i]['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
					}else{
						$uploadimage=resizeimage($images[$i],$newfile[$i],$foldername,$domainname,'0','true');
					}
					$filename="INSERT INTO filename(tablename,masterid,filename) Values('".$tablename."','".$id."','".$newfile[$i]."')";
					$uppicname=rsQuery($filename);
				}
			}
			$updatetran=UpdateTrans($tablename,'add',$_SESSION['username'],'ID:'.$id);
			echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}

	}
	
?>
<form name="form_fifa" id="inputArea" action="" method="POST" enctype="multipart/form-data"  onSubmit="return Chkfrm()">
	<fieldset>
		<legend>ข้อมูลผู้แจ้ง</legend>
		
		<label for="txtsubject" class="label">เรื่อง * </label>
		<input type="text" name="txtsubject"/>
		<label for="txtname" class="label">ชื่อ-นามสกุล *</label>
		<input type="text" name="txtname"/>
		
		<label for="txttel">โทรศัพท์ *</label>
		<input type="text" name="txttel"/>
		<label for="txtemail">อีเมล์</label>
		<input type="input" name="txtemail"/>
		<label for="txtaddress">บ้านเลขที่ *</label>
		<input type="text" name="txtadd_address">
		<label for="txtmoo">หมู่ที่</label>
		<input type="text" name="txtadd_moo">
		<label for="txtmoo">จังหวัด *</label>
			<?php 
				echo "<select name=\"txtadd_province\" id=\"province\" onchange=\"data_show(this.value,'amphur');\"><option value=\"\">-- เลือกจังหวัด --</option>";
				$province="select * from province order by PROVINCE_NAME";
				$rs=rsQuery($province);
				while($data=mysqli_fetch_assoc($rs)){
					echo "<option value=\"".$data['PROVINCE_ID']."\">".$data['PROVINCE_NAME']."</option>";
				}
				echo "</select>";
			?>
		<!--<input type="text" name="txtadd_province">-->
		<label for="txtmoo">อำเภอ *</label>
			<?php 
				echo "<select name=\"txtadd_amphur\" id=\"amphur\" onChange=\"data_show(this.value,'district');\"><option value=\"\"></option>";
				echo "</select>";	
			?>
		<!--<input type="text" name="txtadd_amphur">-->
		<label for="txtmoo">ตำบล *</label>
		<?php 
				echo "<select name=\"txtadd_tambol\" id=\"district\" ><option value=\"\"></option>";
				echo "</select>";	
			?>
	</fieldset>
	<br>
	<fieldset>
		<legend>รายละเอียด</legend>
			<br>
					ประเภทคำร้อง *: 
					<select name="txttype" id="txttype" style="width:60px;"><option value="">เลือก</option>
				<?php
				
					$sql="select * from tb_generalrequest_type";
					$rs=rsQuery($sql);
					if($rs){
						while($rs_data=mysqli_fetch_assoc($rs)){
							echo "<option value=\"".$rs_data['id']."\">".$rs_data['name']."</option>";
						}
					
					}
					?>
					</select>
				<label>รายละเอียด*</label>
				<textarea rows="4" cols="60" name="txtdetail" style="width:500px;"></textarea>
			
			<br>
				<label for="txtb">หมายเหตุ</label>
				<textarea rows="4" cols="60" name="txtremark" style="width:500px;"></textarea>
				<br>
				<label>สถานะงาน</label>
				<select name="cbostatus">
					<?php
						$sql="select * from tb_status order by id";
						$rsstatus=rsQuery($sql);
						if($rsstatus){
							while($data=mysqli_fetch_assoc($rsstatus)){
								echo "<option value=\"".$data['id']."\">".$data['name']."</option>";
							}
						}
						?>
				</select>
				<br>
				<label for="txtresult">ผลการดำเนินการ</label>
				<textarea rows="4" cols="60" name="txtresult" style="width:500px;" ></textarea>
				
<!--
				<label>ไฟล์ภาพขนาดไม่เกิน <?php echo $SizeInMb;?> Mb (jpg,png,bmp,gif,pdf)</label>
	
	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). "&nbsp;&nbsp;<input type=\"file\" name=\"file".$i."\" size=\"50\" /><br />";
		}
	?>
	-->
	<label>สถานะ Active หมายถึงให้แสดงหัวข้อนี้ เอาเครื่องหมายออกเพื่อปิดการแสดงผล</label>

		<input type="checkbox" name="active" style="padding:0px;margin:0px;display:inline;width:30px;"/>&nbsp;Active
				<br>
			
				<br>
					<input type="submit" name="btadd" value="บันทึก">
	</fieldset>
</form>