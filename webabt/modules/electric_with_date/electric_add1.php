<?php
	$tablename="tb_electric";
	$point_no="5";
	$file_no=($gloNews_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$content="";
	$foldername="/fileupload/electric/";
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
				var obj8 = document.form_fifa.txtpsnid;

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
		}else if (obj7.value.length==0){
			alert('กรุณาเลือกหมู่ ที่เกิดปัญหาก่อนค่ะ');
			obj7.focus();
			return false;
		} else if (obj8.value.length==0){
			alert('กรุณากรอกบัตรประชาชนด้วย');
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
		$tel=$_POST['txttel'];
		$email=$_POST['txtemail'];
		$add_address=$_POST['txtadd_address'];
		$add_moo=$_POST['txtadd_moo'];
		$add_tambol=$_POST['txtadd_tambol'];
		$add_amphur=$_POST['txtadd_amphur'];
		$add_province=$_POST['txtadd_province'];
		$moo=$_POST['txtmoo'];
		$remark=EscapeValue($_POST['txtremark']);
		$post_ip=$_SERVER['REMOTE_ADDR'];
		$status=$_POST['cbostatus'];
		$subject=EscapeValue($_POST['txtsubject']);
		$result=EscapeValue($_POST['txtresult']);
		$mooban=$_POST['txtmooban'];
		$psnid=$_POST['txtpsnid'];

		for($i=1;$i<=$point_no;$i++){
				if($i==$point_no){
					$end="";
				}else{
					$end=";";
				}
				$m.=$_POST['p'.$i].$end;
		}
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
		}

		$stradd="insert into $tablename(date,datecreate,name,telephone,email,add_address,add_moo,add_tambol,add_amphur,add_province,subject,moo,fix_with_code,remark,post_ip,status,active,result,datefinish,mooban) values('$date','$date_create','$name','$tel','$email','$add_address','$add_moo','$add_tambol','$add_amphur','$add_province','$subject','$moo','$m','$remark','$post_ip','$status','$ac','$result','0000-00-00','$mooban')";
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
			echo"<script>alert('บันทึกข้อมูลเรียบร้อย');
			window.location.href='index.php?_mod=".$_GET['_mod']."';</script>";
		}

	}

?>
<div class="content-input">
<form name="form_fifa" id="inputArea" action="" method="POST" enctype="multipart/form-data"  onSubmit="return Chkfrm()">
	<fieldset>
		<legend>ข้อมูลผู้แจ้ง</legend>

		<label for="txtsubject" class="label">เรื่อง <font color="red">*</font> </label>
		<input type="text" name="txtsubject"/>
		<label for="txtname" class="label">ชื่อ-นามสกุล <font color="red">*</font></label>
		<input type="text" name="txtname"/>
		<label for="txtpsnid" class="label">เลขบัตรประชาชน <font color="red">*</font></label>
		<input type="text" name="txtpsnid"/>
		<label for="txttel">โทรศัพท์ <font color="red">*</font></label>
		<input type="text" name="txttel"/>
		<label for="txtemail">อีเมล์</label>
		<input type="text" name="txtemail"/>
		<label for="txtmoo">ที่อยู่</label>
		<input type="text" size="50" name="txtadd_moo">
		<br><label for="txtmoo">จังหวัด <font color="red">*</font></label>
			<?php
				echo "<select name=\"txtadd_province\" id=\"province\" onchange=\"data_show(this.value,'amphur');\"><option value=\"\">-- เลือกจังหวัด --</option>";
				$province="select * from province order by PROVINCE_NAME";
				$rs=rsQuery($province);
				while($data=mysqli_fetch_assoc($rs)){
					echo "<option value=\"".$data['PROVINCE_ID']."\">".$data['PROVINCE_NAME']."</option>";
				}
				echo "</select>";
			?>

	</fieldset>
	<br>
	<fieldset>
		<legend>รายละเอียด</legend>
			<br>
				ข้าพเจ้ามีความประสงค์ให้<?php echo $customer_name;?> ซ่อมแซมไฟฟ้าสาธารณะ หมู่ที่ <font color="red">*</font>:
				<?php
					echo "<select name=\"txtmoo\" id=\"txtmoo\" style=\"width:20px;\"><option value=\"\">เลือก</option>";
					for($i=1;$i<=10;$i++){
						echo "<option value=$i>$i</option>";
						}
					echo "</select>";
					echo "&nbsp;&nbsp;&nbsp;<br>หมู่บ้าน&nbsp;:&nbsp;<input type=\"text\" name=\"txtmooban\" size=\"60\">";
					?> &nbsp;<?php echo $customer_tambon;?>
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รหัสเสา หรือสถานที่หรือจุดอ้างอิง(กรณีไม่ทราบรหัสเสา)<br>
			<?php
				$i=0;
				for($i=1;$i<=$point_no;$i++){
					echo "จุดที่$i&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"text1\" name=\"p$i\" ><br>";
				}

			?>
			<br>

			<br>
				<label for="txtb">หมายเหตุ</label>
				<textarea rows="4" cols="60" name="txtremark" style="width:500px;"></textarea>
				<br>
		<!--		<label for="cbolight">หลอดไฟ</label>
				<select name="cbolight">
					<option value="18">18 วัตต์</option>
					<option value="36">36 วัตต์</option>
				</select>
				<select name="cbolightno">
					<?php
						for($x=0;$x<=5;$x++){
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					?>
				</select>จำนวน

				<label for="cbostarter">สตาร์ทเตอร์</label>
							<select name="cbostarter">
					<?php
						for($x=0;$x<=5;$x++){
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					?>
				</select>
					จำนวน
				<label for="cboballard">บัลลาสต์</label>
						<select name="cboballard">
					<?php
						for($x=0;$x<=5;$x++){
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					?>
				</select> จำนวน
				<label for="cbolamp">กิ่งโคม</label>
						<select name="cbolamp">
					<?php
						for($x=0;$x<=5;$x++){
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					?>
				</select> จำนวน
				<label for="txtwired">สายไฟ</label>
				<input type="text" name="txtwired"> เมตร
				<label for="txtother">อื่นๆ</label>
				<input type="text" name="txtother">
-->
				<label>ไฟล์ภาพขนาดไม่เกิน <?php echo $SizeInMb;?> Mb (jpg,png,bmp,gif,pdf)</label><br>

	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). "&nbsp;&nbsp;<input type=\"file\" name=\"file".$i."\" size=\"50\" /><br />";
		}
	?>

        <label style="color: red">*ทั้งนี้ ผู้แจ้งจะต้องเข้ามาแจ้งยืนยันความประสงค์อีกครั้งที่สำนักงาน องค์การบริหารส่วนตำบลนาสักด้วย</label>
	<label>สถานะ Active หมายถึงให้แสดงหัวข้อนี้ เอาเครื่องหมายออกเพื่อปิดการแสดงผล</label>

		<br><input type="checkbox" name="active" style="padding:0px;margin:0px;display:inline;width:30px;"/>&nbsp;Active
				<br>

				<br>
					<input type="submit" name="btadd" value="บันทึก">
	</fieldset>


</form>
</div>
