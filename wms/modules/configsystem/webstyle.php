<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

   <!-- code สำหรับเลือกสีตัวอักษร -->
   <script type="text/javascript" src="js/jscolor.js"></script>

 </head>
	<?php
		if(isset($_POST['btsave'])){
				$font_family=$_POST['font_family'];
				$font_size=$_POST['font_size'];
				$font_color=$_POST['font_color'];
				$font_family=$_POST['font_family'];
				$body_bg=$_POST['body_bg'];
				$a_color=$_POST['a_color'];
				$a_hover=$_POST['a_hover'];
				$div_container=$_POST['div_container'];
				$div_container_width=$_POST['div_container_width'];

				$div_header=$_POST['div_header'];
				$div_header_height=$_POST['div_header_height'];
				$div_bottom_height=$_POST['div_bottom_height'];

				$slide_width=$_POST['slide_width'];
				$slide_height=$_POST['slide_height'];

				$marquee_bg=$_POST['marquee_bg'];

				$div_menutop=$_POST['div_menutop'];
				$div_menutop_stick=$_POST['div_menutop_stick'];
				$div_content_all=$_POST['div_content_all'];

				$div_sidemenu=$_POST['div_sidemenu'];
				$a_sidemenu=$_POST['a_sidemenu'];
				$a_sidemenu_hover=$_POST['a_sidemenu_hover'];

				$sql="update tb_css SET body_bg='$body_bg',font_color='$font_color',font_size='$font_size',a_color='$a_color',a_hover='$a_hover',div_menutop='$div_menutop',div_menutop_stick='$div_menutop_stick',div_content_all='$div_content_all',font_family='$font_family',return_default=0,div_container='$div_container',div_container_width='$div_container_width',div_header_height='$div_header_height',div_bottom_height='$div_bottom_height',slide_width='$slide_width',slide_height='$slide_height',marquee_bg='$marquee_bg',div_sidemenu='$div_sidemenu',a_sidemenu='$a_sidemenu',a_sidemenu_hover='$a_sidemenu_hover' Where id=1";
				$rs=rsQuery($sql);
				echo "<script>alert('แก้ไขข้อมูลสำเร็จ')</script>";

 }
		if(isset($_POST['btreset'])){
				$font_family="";
				$font_size="0";
				$font_color="";
				$font_family="";
				$body_bg="";
				$a_color="";
				$a_hover="";
				$div_container="";
				$div_header="";
				$div_menutop="";
				$div_menutop_stick="";
				$div_content_all="";
				$sql="update tb_css SET body_bg='$body_bg',font_color='$font_color',font_size='$font_size',a_color='$a_color',a_hover='$a_hover',div_menutop='$div_menutop',div_menutop_stick='$div_menutop_stick',div_content_all='$div_content_all',font_family='$font_family',return_default=1 Where id=1";
				$rs=rsQuery($sql);
				echo "<script>alert('คืนค่ากลับเป็นค่าเริ่มต้นสำเร็จ')</script>";
		}

		$sql="select * from tb_css where id=1";
		$rs=rsQuery($sql);
		$data=mysqli_fetch_assoc($rs);
		$font_family=$data['font_family'];
		$font_size=$data['font_size'];
		$font_color=$data['font_color'];
		$font_family=$data['font_family'];
		$body_bg=$data['body_bg'];
		$a_color=$data['a_color'];
		$a_hover=$data['a_hover'];
		$div_container=$data['div_container'];
		$div_header=$data['div_header'];
		$div_menutop=$data['div_menutop'];
		$div_menutop_stick=$data['div_menutop_stick'];
		$div_content_all=$data['div_content_all'];
		$div_container_width=$data['div_container_width'];
		$div_sidemenu=$data['div_sidemenu'];
		$a_sidemenu=$data['a_sidemenu'];
		$a_sidemenu_hover=$data['a_sidemenu_hover'];
		$marquee_bg=$data['marquee_bg'];
		$div_container_width=$data['div_container_width'];
		$div_header=$data['div_header'];
		$div_header_height=$data['div_header_height'];
		$div_bottom_height=$data['div_bottom_height'];
		$slide_width=$data['slide_width'];
		$slide_height=$data['slide_height'];

		//$div_content=$data['div_content'];



	?>
 <body>
 <div class="content-box">
  <form name="frmnews" method="POST" action="" enctype="multipart/form-data">
	<table width="80%" class="content-input" >
		<tr>
			<td  width="20%">body background color</td>
			<td width="80%"><input type="text" name="body_bg" value="<?php echo $body_bg;?>" class="color {required:false}" ></td>
		</tr>

		<tr>
			<td >แบบตัวอักษร (body font)</td>
			<td >
					<select name="font_family">
						<?php
							$font=array(THSarabunNew,THBaijam,THK2DJuly8,THChakraPetch,THNiramitAS,Tahoma ,'sans-serif','AngsanaNew');
							foreach($font as $value){
								if($font_family==$value){
									echo "<option value='$value' selected>$value</option>";
								}else{
									echo "<option value='$value'>$value</option>";
								}
							}
						?>
					</select>
					&nbsp;&nbsp;
					ขนาดตัวอักษร(px)
					&nbsp;&nbsp;
					<input type="text" name="font_size" value="<?php echo $font_size;?>" size="3">
					&nbsp;&nbsp;
					สีตัวอักษร
					&nbsp;&nbsp;
					<input type="text" name="font_color" class="color {required:false}"  value="<?php echo $font_color;?>">
			</td>

		</tr>
		<tr>
			<td>สีสิงค์( Anchor )</td>
			<td>
				<input type="text" name="a_color" class="color {required:false}"  value="<?php echo $a_color;?>">
				&nbsp;&nbsp;
				สีลิงค์เมาส์ชี้ ( Anchor Hover)
				&nbsp;&nbsp;
				<input type="text" name="a_hover" class="color {required:false}"  value="<?php echo $a_hover;?>">


			</td>
		</tr>

		<tr>
			<td  >container background </td>
			<td ><input type="text" name="div_container" value="<?php echo $div_container;?>" class="color {required:false}">(สีพื้นส่วนเนื้อหา)</td>
		</tr>
		<tr>
			<td>container width (px)</td>
			<td><input type='text' name='div_container_width' value="<?php echo $div_container_width;?>">ความกว้าง ตัวเลขเท่านั้น</td>
		</tr>
		<tr>
			<td>header height (px)</td>
			<td><input type='text' name='div_header_height' value="<?php echo $div_header_height;?>">ความสูง ตัวเลขเท่านั้น</td>
		</tr>

		<tr>
			<td>bottom height (px)</td>
			<td><input type='text' name='div_bottom_height' value="<?php echo $div_bottom_height;?>">ความสูง ตัวเลขเท่านั้น</td>
		</tr>
		<tr>
			<td>marquee bg color </td>
			<td><input type='text' name='marquee_bg' value="<?php echo $marquee_bg;?>" class="color {required:false}">สีพื้นตัวอักษรวิ่ง</td>
		</tr>
	</table>
	<br>
		<table width="80%" class="content-input">
		<tr><th colspan='2'>MenuTop เมนูบน</th></tr>
		<tr>
			<td  width="20%">menutop background color</td>
			<td ><input type="text" name="div_menutop" value="<?php echo $div_menutop;?>" class="color {required:false}"></td>
		</tr>
		<tr>
			<td  >menutop color on stick </td>
			<td><input type="text" name="div_menutop_stick" value="<?php echo $div_menutop_stick;?>" class="color {required:false}"></td>
		</tr>
		</table>

	<br>
		<table width='80%' class="content-input">
			<tr><th colspan='2'>SideMenu เมนูข้าง</th></tr>
			<tr>
				<td width="20%">sidemenu background color</td>
				<td><input type="text" name="div_sidemenu" value="<?php echo $div_sidemenu;?>" class="color {required:false}"></td>
			<tr>
				<td>สีลิงค์  a:color</td>
				<td><input type="text" name="a_sidemenu" value="<?php echo $a_sidemenu;?>" class="color {required:false}"></td>
			<tr>
			<tr>
				<td>สีลิงค์  เมาส์ชี้ a:hover</td>
				<td><input type="text" name="a_sidemenu_hover" value="<?php echo $a_sidemenu_hover;?>" class="color {required:false}"></td>
			<tr>
		</table>
		<br>
			<table width='80%' class="content-input">
			<tr><th colspan='2'>Slide show</th></tr>
			<tr>
				<td width="20%">width (px)</td>
				<td><input type='text' name='slide_width' value="<?php echo $slide_width;?>">ความกว้าง ตัวเลขเท่านั้น</td>
			</tr>
			<tr>
				<td>height (px)</td>
				<td><input type='text' name='slide_height' value="<?php echo $slide_height;?>">ความสูง ตัวเลขเท่านั้น</td>
			</tr>

		<tr>
			<td></td><td><input type="submit" name="btsave" value="save">&nbsp;&nbsp;&nbsp;<input type="submit" name="btreset" value="reset" title="คืนค่าเป็น Default" onclick="return confirm('คุณต้องการคืนค่ากลับไปเป็นค่า Default ใช่หรือไม่');"></td>
		</tr>
	</table>
	<object data="http://<?php echo $domainname;?>" width="90%" height="800"> <embed src="http://<?php echo $domainname;?>" width="90%" height="800"> </embed> Error: Embedded data could not be displayed. </object>
	</form>
	</div>
 </body>
</html>
