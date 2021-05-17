<?php
	$tablename="tb_profile";
	if(isset($_POST['btsave'])){
		$name=$_POST['name'];
		$address=$_POST['address'];
		$tambol=$_POST['tambol'];
		$amphur=$_POST['amphur'];
		$province=$_POST['province'];
		$tel=$_POST['tel'];
		$email=$_POST['email'];
		$title=$_POST['web_title'];
		$keywords=$_POST['web_keywords'];
		$description=$_POST['web_description'];
		$img_filter=$_POST['img_filter'];
		$broadcast_firstpage=$_POST['broadcast_firstpage'];
		$sql="Update $tablename SET name='$name',address='$address',tambol='$tambol',amphur='$amphur',province='$province',tel='$tel',email='$email',web_keywords='$keywords',web_title='$title',web_description='$description',img_filter='$img_filter',broadcast_firstpage='$broadcast_firstpage' WHERE id = 1 ";
			$rs=rsQuery($sql);
			echo "<script>alert('บันทึกข้อมูลสำเร็จ');</script>";
	}else{
	
	
	$sql="select * from $tablename";
	$rs=rsQuery($sql);
	if($rs){
		$data=mysqli_fetch_assoc($rs);
		$name=$data['name'];
		$address=$data['address'];
		$tambol=$data['tambol'];
		$amphur=$data['amphur'];
		$province=$data['province'];
		$tel=$data['tel'];
		$email=$data['email'];
		$title=$data['web_title'];
		$keywords=$data['web_keywords'];
		$description=$data['web_description'];
		$img_filter=$data['img_filter'];
		$broadcast_firstpage=$data['broadcast_firstpage'];
	}
	}
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<div class="content-box">
	<table class="content-input" width="90%">
		<tr>
			<td width="20%">ชื่อ</td><td width="80%"><input type="text" name="name" placeholder="ชื่อ/บริษัท" value="<?php echo $name;?>" size="100"></td>
		</tr>
		<tr>
			<td>ที่อยู่</td><td><input type="text" name="address" placeholder="ที่อยู่ / บ้านเลขที่" value="<?php echo $address;?>" size="100"></td>
		</tr>
		<tr>
			<td>ตำบล/แขวง</td><td><input type="text" name="tambol" placeholder="" value="<?php echo $tambol;?>" ></td>
		</tr>
		<tr>
			<td>อำเภอ/เขต</td><td><input type="text" name="amphur" placeholder="" value="<?php echo $amphur;?>"></td>
		</tr>
		<tr>
			<td>จังหวัด</td><td><input type="text" name="province" placeholder="" value="<?php echo $province;?>"></td>
		</tr>
		<tr>
			<td>โทรศัพท์</td><td><input type="number" name="tel" placeholder="" value="<?php echo $tel;?>"></td>
		</tr>
		<tr>
			<td>email</td><td><input type="email" name="email" placeholder="ใช้ในการรับเมล์หรือส่งให้ผู้ติดต่อผ่านระบบ" value="<?php echo $email;?>" size="50"></td>
		</tr>
		<tr>
			<td>Title</td><td><input type="text" name="web_title" placeholder="แสดงในส่วน title ของ browser บนสุด" value="<?php echo $title;?>" size="100"></td>
		</tr>
		<tr>
			<td>Keywords</td><td><input type="text" name="web_keywords" placeholder="คำสำหรับค้นหา คั่นด้วยcomma เช่น บ้านจัดสรร , บ้านใหม่ , บ้านเชียงใหม่" value="<?php echo $keywords;?>" size="100"></td>
		</tr>
		<tr>
			<td>Description</td><td><input type="text" name="web_description" placeholder="คำอธิบายเว็บของคุณ เช่น บ้านสไตล์โมเดิร์น บนวิธีธรรมชาติ" value="<?php echo $description;?>" size="100"></td>
		</tr>
		<tr>
	<td>web filter</td>
	<td>
		<select name="img_filter">
			<?php
				$sqlfilter="select * from tb_filter";
				$rsfilter=rsQuery($sqlfilter);
				if($rsfilter){
					while($filter=mysqli_fetch_assoc($rsfilter)){
						if($img_filter==$filter['name']){
						echo "<option value='".$filter['name']."' selected>".$filter['name']."</option>";
						}else{
						echo "<option value='".$filter['name']."'>".$filter['name']."</option>";
						}
					}
				}
			?>
		</select>&nbsp;* ใส่ Effect ให้กับเว็บทั้งหมด
</tr>
<tr>
	<td>หน้า index ส่วนกลาง</td>
	<td><select name="broadcast_firstpage">
		<?php
			if($broadcast_firstpage==0){
				echo	"<option value='0' selected>ไม่ใช้หน้า index จากส่วนกลาง</option>";
				echo "<option value='1'>เปิดใช้หน้า index จากส่วนกลาง</option>";
			}else{
				echo	"<option value='0' >ไม่ใช้หน้า index จากส่วนกลาง</option>";
				echo "<option value='1' selected>เปิดใช้หน้า index จากส่วนกลาง</option>";
			}
			?>
		</td>
	</tr>
		<tr><td></td><td><input type="submit" name="btsave" value="บันทึก"></td></tr>
		</table>
	</div>
</form>