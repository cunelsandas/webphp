<?php
	session_start();
	$google_apikey="AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw";
	$tablename="tb_electric";
	$point_no="5";
?>
<html>
 <head>
  <title> เพิ่มสมาชิกใหม่ </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- googlemap script -->
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize&key=<?php echo $google_apikey;?>"></script>
  <script  language="JavaScript" type="text/javascript">
    var map;
	var markersArray = [];

    function mapa() {
      //var opts = {'center': new google.maps.LatLng(26.12295, -80.17122), 'zoom':11, 'mapTypeId': google.maps.MapTypeId.ROADMAP }
     var opts = {'center': new google.maps.LatLng(<?php echo $customer_lat;?>,<?php echo $customer_lng;?>), 'zoom':16, 'mapTypeId': google.maps.MapTypeId.ROADMAP }
     map = new google.maps.Map(document.getElementById('mapdiv'),opts);
      google.maps.event.addListener(map,'click',function(event) {
			document.getElementById('latclicked').value = event.latLng.lat()
			document.getElementById('lngclicked').value =  event.latLng.lng()
		   // This event listener will call addMarker() when the map is clicked.
				  map.addListener('click', function(event) {
	 				addMarker(event.latLng);
				});
     });
     google.maps.event.addListener(map,'mousemove',function(event) {
      document.getElementById('latspan').innerHTML = event.latLng.lat()
      document.getElementById('lngspan').innerHTML = event.latLng.lng()
		
     /* document.getElementById('latlong').innerHTML = event.latLng.lat() + ', ' + event.latLng.lng() */
     });
	 
     }

	 // Adds a marker to the map and push to the array.
function addMarker(location) {
	 deleteOverlays();
	var marker = new google.maps.Marker({
	    position: location,
		map: map
	});
	markersArray.push(marker);
}

        // Deletes all markers in the array by removing references to them
        function deleteOverlays() {
            if (markersArray) {
                for (i in markersArray) {
                    markersArray[i].setMap(null);
                }
            markersArray.length = 0;
            }
        }
  
  </script>
  
<!-- end map script -->

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
	var url = 'lib/data.php?select_id='+select_id+'&result='+result;
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
				var obj8 = document.form_fifa.txtver;
				
				var vervalue = document.form_fifa.vervalue;
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
	//	}else if(obj8.value!=vervalue.value){
	//		alert('คุณป้อนรหัสยืนยันไม่ถูกต้อง กรุณาป้อมใหม่');
	//		obj8.focus();
	//		return false;
		}else{
			return true;
		}
	
}
</script>
</head>
<body onload="mapa()">
<?php
	
	if($_POST['btadd']){
		$chkver=$_SESSION['vervalue'];
		if($chkver<>$_POST['txtver']){
			echo "<script>alert('คุณป้อนรหัสยืนยันไม่ถูกต้อง'); window.history.go(-1);</script>";
			
		}else{
		$date=date('Y-m-d');
		$date_create=date('Y-m-d H:i:s');
		$name=$_POST['txtname'];
		$tel=$_POST['txttel'];
		$email=$_POST['txtemail'];
		$add_address=$_POST['txtadd_address'];
		$add_moo=$_POST['txtadd_moo'];
		$add_tambol=$_POST['txtadd_tambol'];
		$add_amphur=$_POST['txtadd_amphur'];
		$add_province=$_POST['txtadd_province'];
		$moo=$_POST['txtmoo'];
		$remark=$_POST['txtremark'];
		$subject=$_POST['txtsubject'];
		$post_ip=$_SERVER['REMOTE_ADDR'];
		$lat=($_POST['txtlat']==""?"0":$_POST['txtlat']);
		$lng=($_POST['txtlng']==""?"0":$_POST['txtlng']);

		for($i=1;$i<=$point_no;$i++){
				if($i==$point_no){
					$end="";
				}else{
					$end=";";
				}
				$m.=$_POST['p'.$i].$end;
		}
		$stradd="insert into $tablename(date,datecreate,name,telephone,email,add_address,add_moo,add_tambol,add_amphur,add_province,subject,moo,fix_with_code,remark,post_ip,status,active,result,datefinish,latitude,longitude) values('$date','$date_create','$name','$tel','$email','$add_address','$add_moo','$add_tambol','$add_amphur','$add_province','$subject','$moo','$m','$remark','$post_ip','1','1','','0000-00-00','$lat','$lng')";
		$rs=rsQuery($stradd);
		if($rs){
			echo "<BR><BR><BR>".$stradd;
			echo"<script>alert('บันทึกข้อมูลเรียบร้อย " .$customer_name."จะรีบดำเนินการให้ท่านโดยเร็ว');window.location.href='index.php?_mod=".$_GET['_mod']."';</script>";
		}

	}
	}
?>
<form name="form_fifa" id="inputArea" action="" method="POST" enctype="multipart/form-data"  onsubmit="return Chkfrm()">
	<fieldset>
		<legend>ข้อมูลผู้แจ้ง - งานไฟฟ้าสาธารณะ</legend>
		<span id="rule">ระบบการแจ้งปัญหาไฟฟ้าสาธารณะชำรุด <i><?php echo $customer_name;?></i><br>ขอให้ท่านป้อนข้อมูลในช่องที่มีเครื่องหมาย * ให้ครบ <br>เพื่อใช้ในการประสานงานและแจ้งปัญหาหรือการแก้ไขให้แก่ท่าน<br><i><?php echo $departmentname;?></i> จะทำการตรวจสอบและดำเนินการแก้ไขปัญหาให้โดยเร็ว<br>ขอขอบพระคุณที่ท่านเข้ามาใช้บริการ <br>ข้อมูลส่วนตัวของท่านจะไม่ถูกเปิดเผยแต่อย่างใด <br>หมายเลข ไอ.พี. ของท่านคือ <?php echo $_SERVER['REMOTE_ADDR'];?>
		</span>
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
				while($data=mysqli_fetch_array($rs)){
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
	<!--	<input type="text" name="txtadd_tambol">-->
		
		
	</fieldset>
	<br>
	<fieldset>
		<legend>รายละเอียด</legend>
		
				ข้าพเจ้ามีความประสงค์ให้<?php echo $customer_name;?> ซ่อมแซมไฟฟ้าสาธารณะ หมู่ที่ *: 
				<?php
					echo "<select name=\"txtmoo\" id=\"txtmoo\" style=\"width:60px;\"><option value=\"\">เลือก</option>";
					$i=0;
					for($i=1;$i<=10;$i++){
						echo "<option value=$i>$i</option>";
						}
					echo "</select>";
					?>
					<!--<input type="text" id="text1" name="txtmoo" maxlength="2" size="2" style="width:20px;">--> &nbsp;<?php echo $customer_tambon;?>
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รหัสเสาไฟฟ้า หรือสถานที่หรือจุดอ้างอิง(กรณีไม่ทราบรหัสเสา)<br>
			<?php
				$i=0;
				for($i=1;$i<=$point_no;$i++){
					echo "จุดที่$i&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"text\" id=\"text1\" name=\"p$i\" ><br>";
				}
				
			?>
			<br>
				<div><span>คลิกบนแผนที่เพื่อแจ้งพิกัดให้เจ้าหน้าที่ทราบ (อาจเป็นตำแหน่งโดยประมาณ)</span></div>
				<div class="eventtext">
					 <div>Lattitude:&nbsp;&nbsp; <input type="text" name="txtlat" id="latclicked" style="width:200px; border:1px inset gray;"><span id="latspan"></span></div>
					 <div>Longitude:&nbsp;&nbsp;<input type="text" name="txtlng" id="lngclicked" style="width:200px; border:1px inset gray;" ><span id="lngspan"></span></div>
					 </div>
			<!--  map -->
				<div id="mapdiv" style="width:100%; height:500px;"></div>
					
 
					


			<!-- end map -->
				<label for="txtb">หมายเหตุ</label>
				<textarea rows="4" cols="60" name="txtremark" style="width:400px;"></textarea>
				<br>
				<fieldset style="width:200px;background-color:#c7daf1;">
			 <label>รหัสยืนยัน *</label>
				<img src="verify_image.php"><br>
				<input type="text" name="txtver" style="width:100px;" />
				<input type="hidden" name="vervalue" value="<?php echo $_SESSION['vervalue'];?>">
				</fieldset>

					<input type="submit" name="btadd" value="บันทึก">
	</fieldset>

		
</form>
</body>
</html>