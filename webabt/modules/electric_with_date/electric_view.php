<?php
	$tablename="tb_electric";
	$point_no="5";
	$file_no=($gloNews_fileno-1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
	$limitsize=$gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
	$SizeInMb=round(($limitsize/$onemb));
	$content="";
	$foldername="/fileupload/electric/";
?>
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.7.2.custom.css">
<style type="text/css">
.ui-datepicker{
	width:200px;
	font-family:tahoma;
	font-size:11px;
	text-align:center;
}
</style>
 <script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>

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

<script type="text/javascript">
$(function(){
	// แทรกโค้ต jquery
	$("#datefinish").datepicker({ dateFormat: 'yy-mm-dd' });
});



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
			alert('กรุณาเลือกหมู่ ที่เกิดปัญหาก่อนค่ะ');
			obj7.focus();
			return false;

		}else{
			return true;
		}

}
</script>
<?php
	if(isset($_GET['del'])){
		$filenameFordel=FindRS("select * from filename where id=".$_GET['del'],"filename");
		//echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
		if($filenameFordel<>"Not Found"){
			unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel);
		}
		$sql="DELETE From filename Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);


}
	if($_POST['btadd']){
		$no=$_GET['no'];
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
		$subject=EscapeValue($_POST['txtsubject']);
		$status=$_POST['cbostatus'];
		$datefinish=$_POST['datefinish'];
		$officer=$_POST['cboofficer'];
		$result=EscapeValue($_POST['txtresult']);
		$mooban=$_POST['txtmooban'];

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

		//$stradd="insert into $tablename(date,datecreate,name,telephone,email,add_address,add_moo,add_tambol,add_amphur,add_province,subject,moo,fix_with_code,remark,post_ip,status,active,result) values('$date','$date_create','$name','$tel','$email','$add_address','$add_moo','$add_tambol','$add_amphur','$add_province','$subject','$moo','$m','$remark','$post_ip','0','$ac','$result')";
		$stradd="Update $tablename SET name='$name',telephone='$tel',email='$email',add_address='$add_address',add_moo='$add_moo',add_tambol='$add_tambol',add_amphur='$add_amphur',add_province='$add_province',subject='$subject',moo='$moo',fix_with_code='$m',remark='$remark',post_ip='$post_ip',status='$status',active='$ac',result='$result',datefinish='$datefinish',officer='$officer',mooban='$mooban' Where no=".$_GET['no'];
		$rs=rsQuery($stradd);
		if($rs){

			$sql="Select * From $tablename Where no='".$_GET['no']."'";
			$rss=rsQuery($sql);
			$r=mysqli_fetch_assoc($rss);
			$id=$r['no'];
			// loop insert ชื่อไฟล์และcopy ไฟล์
			$newfile=array();
			for ($i=0;$i<=$file_no;$i++){
				$x=$i+1;
				if($file[$i]<>""){
					$newfile[$i]=$tablename.'_'.$id."_".$x.$type[$i];
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
	$sql="Select * from $tablename where no=".$_GET['no'];
	$rs=rsQuery($sql);
	$data=mysqli_fetch_assoc($rs);
	$name=$data['name'];
		$tel=$data['telephone'];
		$email=$data['email'];
		$add_address=$data['add_address'];
		$add_moo=$data['add_moo'];
		$add_tambol=$data['add_tambol'];
		$add_amphur=$data['add_amphur'];
		$add_province=$data['add_province'];
		$province_name=FindRS("select * from province Where PROVINCE_ID='$add_province'","PROVINCE_NAME");
		$amphur_name=FindRS("select * from amphur Where AMPHUR_ID='$add_amphur'","AMPHUR_NAME");
		$tambol_name=FindRS("select * from district Where DISTRICT_ID='$add_tambol'","DISTRICT_NAME");
		$moo=$data['moo'];
		$remark=$data['remark'];
		$result=$data['result'];
		$active=$data['active'];
		$status=$data['status'];
		$subject=$data['subject'];
		$array=explode(';',$data['fix_with_code']);
		$datefinish=$data['datefinish'];
		$officer=$data['officer'];
		$mooban=$data['mooban'];
?>
<div class="content-input">
<form name="form_fifa" id="inputArea" action="" method="POST" enctype="multipart/form-data"  onSubmit="return Chkfrm()">
	<fieldset>
		<legend>ข้อมูลผู้แจ้ง</legend>

		<label for="txtno">เลขที่</label>
		<input type="text" name="txtno" value="<?php echo EscapeValue($_GET['no']);?> " disabled="disabled">
		<label for="txtsubject" class="label">เรื่อง <font color="red">*</font> </label>
		<input type="text" name="txtsubject" value="<?php echo $subject;?>" readonly/><br>
		<label for="txtname" class="label">ชื่อ-นามสกุล <font color="red">*</font></label>
		<input type="text" name="txtname" value="<?php echo $name;?>" readonly/>

		<label for="txttel">โทรศัพท์ <font color="red">*</font></label>
		<input type="text" name="txttel" value="<?php echo $tel;?>" readonly/>
		<br><label for="txtemail">อีเมล์</label>
		<input type="input" name="txtemail" value="<?php echo $email;?>" readonly/>
		<label for="txtaddress">บ้านเลขที่ <font color="red">*</font></label>
		<input type="text" name="txtadd_address" value="<?php echo $add_address;?>" readonly>
		<br><label for="txtmoo">ที่อยู่</label>
		<input type="text" name="txtadd_moo" size="50" value="<?php echo $add_moo;?>" readonly>
		<label for="txtmoo">จังหวัด <font color="red">*</font></label>
			<?php
				echo "<select name=\"txtadd_province\" id=\"province\" onchange=\"data_show(this.value,'amphur');\"><option value=\"".$add_province."\">$province_name</option>";
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
				ข้าพเจ้ามีความประสงค์ให้<?php echo $customer_name;?> ซ่อมแซมไฟฟ้าสาธารณะ หมู่ที่ <font color="red">*</font>:<?php
					echo "<select name=\"txtmoo\" id=\"txtmoo\" style=\"width:20px;\"><option value=\"$moo\">$moo</option>";
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
					foreach($array as $fixwithcode){
					$i+="1";
					echo "จุดที่$i&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"text1\" name=\"p$i\" value=\"$fixwithcode\" ><br>";
				}



			?>
			<br>

			<br>
				<label for="txtb">หมายเหตุ</label>
				<textarea rows="4" cols="100" name="txtremark" style="width:500px"><?php echo $remark;?></textarea>

				<br>
				<label>สถานะงาน</label>
				<select name="cbostatus" disabled>
					<?php
						$sql="select * from tb_status order by id";
						$rsstatus=rsQuery($sql);
						if($rsstatus){
							$statusname=FindRS("select * from tb_status where id=".$status,"name");
							echo "<option value=\"".$status."\">".$statusname."</option>";
							while($data=mysqli_fetch_assoc($rsstatus)){
								echo "<option value=\"".$data['id']."\">".$data['name']."</option>";
							}
						}
						?>
				</select>
				<br>
				<label for="txtresult">ผลการดำเนินการ</label>
				<textarea rows="4" cols="100" name="txtresult" style="width:500px;" disabled><?php echo $result;?></textarea>
				<br>
		<!--		<label for="cbolight">หลอดไฟ</label>
				<select name="cbolight">
					<?php
						if($light<>""){
							echo "<option value=\"".$light."\">".$light." วัตต์</option>";
						}else{
							echo "<option value=''></option>";
						}
					?>

					<option value="18">18 วัตต์</option>
					<option value="36">36 วัตต์</option>
				</select>
				<select name="cbolightno">
					<?php

						echo "<option value='$lightno'>$lightno</option>";
						for($x=0;$x<=5;$x++){
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					?>
				</select>จำนวน

				<label for="cbostarter">สตาร์ทเตอร์</label>
							<select name="cbostarter">
					<?php
						echo "<option value='$starter'>$starter</option>";
						for($x=0;$x<=5;$x++){
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					?>
				</select>
					จำนวน
				<label for="cboballard">บัลลาสต์</label>
						<select name="cboballard">
					<?php
						echo "<option value='$ballard'>$ballard</option>";
						for($x=0;$x<=5;$x++){
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					?>
				</select> จำนวน
				<label for="cbolamp">กิ่งโคม</label>
						<select name="cbolamp">
					<?php
						echo "<option value='$lamp'>$lamp</option>";
						for($x=0;$x<=5;$x++){
							echo "<option value=\"".$x."\">".$x."</option>";
						}
					?>
				</select> จำนวน
				<label for="txtwired">สายไฟ</label>
				<input type="text" name="txtwired" value="<?php echo $wired;?>"> เมตร
				<label for="txtother">อื่นๆ</label>
				<input type="text" name="txtother" value="<?php echo $other;?>">
				<br>
				<label for="cboofficer">เจ้าหน้าที่ผู้ดำเนินการ</label>
				<select name="cboofficer">
				<?php
					$sql="select * from tb_officer";
					$r=rsQuery($sql);
					echo "<option value=\"".$officer."\">".$officer."</option>";
					while($d=mysqli_fetch_assoc($r)){
						echo "<option value=\"".$d['name']."\">".$d['name']."</option>";
					}
					?>
					</select>
				<br>
				-->
				<label>วันที่ดำเนินการเสร็จ</label>
				<input type="text" name="datefinish" disabled id="datefinish" value="<?php echo $datefinish;?>">
				<br>

				<label>ไฟล์ภาพขนาดไม่เกิน <?php echo $SizeInMb;?> Mb (jpg,png,bmp,gif,pdf)</label><br>

	<?php  //วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
		for ($i=0; $i<=$file_no;$i++){
			echo "ไฟล์ที่&nbsp;".($i+1). '&nbsp;&nbsp;<input type=file name=file'.$i.' size=50 /><br />';
		}
	?>
	<label>สถานะ Active หมายถึงให้แสดงหัวข้อนี้ เอาเครื่องหมายออกเพื่อปิดการแสดงผล</label>
	<br>
	<?php
	if($active==0){
			echo "<input type=\"checkbox\" name=\"active\" style=\"margin:0px;display:inline;padding:0px;width:30px;\"/>Active";
		}else{
			echo "<br><input type=\"checkbox\" name=\"active\" style=\"margin:0px;display:inline;padding:0px;background-color:#ffff00;width:30px;\" checked/>&nbsp;Active";
		}
			echo "<br><br>";
			echo "<input type=\"submit\" name=\"btadd\" value=\"บันทึก\">&nbsp;&nbsp;";
			echo "<input type=\"button\" name=\"print\" onclick=\"window.open('modules/report/print_form_electric.php?tb=".encode64('tb_electric')."&no=".encode64($_GET['no'])."')\" value=\"พิมพ์คำร้อง\">&nbsp;&nbsp;";
	//		echo "<input type=\"button\" name=\"print\" onclick=\"window.open('modules/report/report_gl_01.php?tb=".encode64('tb_electric')."&no=".encode64($_GET['no'])."')\" value=\"พิมพ์รายงานสรุป\">&nbsp;&nbsp;";
	//		echo "<input type=\"button\" name=\"print\" onclick=\"window.open('modules/report/print_mail.php?tb=".encode64('tb_electric')."&no=".encode64($_GET['no'])."')\" value=\"พิมพ์จดหมายแจ้งกลับ\">&nbsp;&nbsp;";
		?>
	</fieldset>
	<br>
	<?php
		$strpicture="Select * from filename Where tablename='".$tablename."' AND masterid='".$_GET['no']."' Order by id";
		$rs=rsQuery($strpicture);
		while($arr = mysqli_fetch_assoc($rs)){
			$fileno=substr($arr['filename'],-5,1);
			echo "<img src=..".$foldername.$arr['filename']." width=300 height=300>&nbsp;&nbsp;ไฟล์ที่ ".$fileno."&nbsp;".$arr['filename']."&nbsp;<a href=\"index.php?_mod=".$_GET['_mod']."&type=view&no=".$_GET['no']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
		}
?>
</form>
</div>
